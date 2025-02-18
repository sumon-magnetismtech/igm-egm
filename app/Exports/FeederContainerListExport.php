<?php

namespace App\Exports;

use App\MLO\Blcontainer;
use App\MLO\Feederinformation;
use FontLib\TrueType\Collection;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithCustomStartCell;
use Maatwebsite\Excel\Concerns\WithHeadings;

class FeederContainerListExport implements FromCollection, WithCustomStartCell, ShouldAutoSize, WithColumnWidths, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    protected $allContainers;
    public function __construct($allContainers)
    {
        $this->allContainers = $allContainers;
    }

    public function collection()
    {
        $filterContainerData=collect();
        foreach($this->allContainers as $key => $container){
            $filterContainerData[$key]=[$container->contref,$container->type, $container->status, $container->mloblinformation->bolreference];
        }
        return $filterContainerData;
    }

    public function startCell(): string
    {
        return 'B1';
    }

    public function columnWidths(): array
    {
        return [
            'A' => 25,
            'B' => 25,
            'C' => 10,
            'D' => 10,
            'E' => 30,
        ];
    }

    public function headings(): array
    {
        return [
            'Container No',
            'Type',
            'Status',
            'BL No'
        ];
    }

}
