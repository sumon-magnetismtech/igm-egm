<?php

namespace App\Imports;

use App\Package;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class PackagesImport implements ToModel, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new Package([
            'packagecode' => $row['packagecode'],
            'description' => $row['description'],
        ]);
    }
}
