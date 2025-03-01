<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithCustomStartCell;
use Maatwebsite\Excel\Concerns\WithDrawings;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class MloDoContainerReport implements FromCollection, WithHeadings, ShouldAutoSize, WithCustomStartCell
{
    /**
    * @return \Illuminate\Support\Collection
    */

    protected $mloblInformations, $dateType, $fromDate, $tillDate, $i;

    public function __construct($mloblInformations, $dateType,$fromDate, $tillDate)
    {
        $this->mloblInformations = $mloblInformations;
        $this->dateType = $dateType;
        $this->fromDate = $fromDate;
        $this->tillDate = $tillDate;
    }

    public function collection()
    {
        $containerList=collect();
        $this->i = 0;
        foreach($this->mloblInformations as $key => $mloblInformation){
            foreach($mloblInformation->blcontainers as $contKey => $container){
                $containerList[$this->i++] = [
//                    $mloblInformation->mloMoneyReceipt->deliveryOrder->DO_Date ? date('d-m-Y', strtotime($mloblInformation->mloMoneyReceipt->deliveryOrder->DO_Date)) : null,
                    $container->contref,
                    $container->type,
                    $container->status,
                    $mloblInformation->mloMoneyReceipt->uptoDate ? date('d-m-Y', strtotime($mloblInformation->mloMoneyReceipt->uptoDate)) : null,
                    $mloblInformation->bolreference,
                    $mloblInformation->mlofeederInformation->feederVessel,
                    $mloblInformation->mlofeederInformation->voyageNumber,
                    $mloblInformation->mlofeederInformation->rotationNo,
                    $mloblInformation->principal->code
                ];

            }
        }
//        dd($containerList);

        return $containerList;
    }


    public function headings(): array
    {

        if($this->dateType == 'weekly'){
            $dateRange = now()->subDays(7)->format('d-m-Y') ." to ". now()->format('d-m-Y');
        }elseif($this->dateType=="monthly"){
            $dateRange = now()->subDays(30)->format('d-m-Y') .' to '. now()->format('d-m-Y');
        }elseif($this->dateType=='custom'){
            $dateRange = $this->fromDate ? date('d-m-Y', strtotime($this->fromDate)) : null .' to '.$this->tillDate ? date('d-m-Y', strtotime($this->tillDate)) : null;
        }else {
            $dateRange = now()->format('d-m-Y') . ' to ' . now()->format('d-m-Y');
        }

        return [
            [
                "Container List Against Delivery Order (Main Line)",
            ],
            [
                "DO Date : $dateRange",
            ],
            [
//                'DO Date',
                'Container',
                'Type',
                'Sta',
                'Upto',
                'HBL',
                'Vessel Name',
                'Voyage',
                'Rotation',
                'PRI'
            ]
        ];
    }

    public function columnWidths(): array
    {
        return [
//            'A' => 10,
            'A' => 14,
            'B' => 5,
            'C' => 3.60,
            'D' => 9.71,
            'E' => 19,
            'F' => 26,
            'G' => 7,
            'H' => 10,
            'I' => 5,
        ];
    }

    public function startCell(): string
    {
        return 'A1';
    }

    public function styles(Worksheet $sheet)
    {
//        $sheet->getPageSetup()->setOrientation(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::ORIENTATION_LANDSCAPE);
        $sheet->getPageMargins()->setTop(.5);
        $sheet->getPageMargins()->setRight(0.3);
        $sheet->getPageMargins()->setLeft(0.3);
        $sheet->getPageMargins()->setBottom(.3);
        $sheet->getPageSetup()->setHorizontalCentered(true);
        $sheet->mergeCells('A1:I1');
        $sheet->mergeCells('A2:I2');

        $styleArray = [
            'borders' => [
                'allBorders' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                    'color' => ['rgb' => '000000'],
                ],
            ],
        ];
        $totalRows = $this->i + 3;
        $sheet->getStyle("A3:I$totalRows")->applyFromArray($styleArray);

        $alignment = [
            'alignment' => [
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
            ],
        ];

        $sheet->getStyle('A1')->applyFromArray($alignment);
        $sheet->getStyle('A2')->applyFromArray($alignment);
        return [
            // Style the first row as bold text.
            1    => ['font' => ['bold' => true, 'size' => 18],],
            2    => ['font' => ['bold' => true, 'size' => 15]],

            // Styling a specific cell by coordinate.
            'A2' => ['font' => ['italic' => true]],

            // Styling an entire column.
            'A'  => ['font' => ['bold' => true]],
        ];



    }
}
