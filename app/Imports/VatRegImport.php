<?php

namespace App\Imports;

use App\Vatreg;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class VatRegImport implements ToModel, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
//        dd($row);
        return new Vatreg([
            'BIN' => $row['bin'],
            'NAME' => $row['name'],
            'ADD1' => $row['add1']
        ]);
    }
}
