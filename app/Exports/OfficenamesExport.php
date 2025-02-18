<?php

namespace App\Exports;

use App\Officename;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;

class OfficenamesExport implements FromCollection, WithHeadings
{

    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return Officename::all();
    }


    public function headings(): array
    {
        return [
            '#',
            'Office Code',
            'Office Name',
            'Created At',
            'Updated At',
        ];
    }

}