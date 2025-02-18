<?php

namespace App\Imports;

use App\Containertype;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;

class ContainertypesImport implements ToModel, WithValidation, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new Containertype([

            'isocode' => $row['isocode'],
            'dimension' => $row['dimension'],
            'description' => $row['description'],

        ]);
    }

    /**
     * @return array
     */
    public function rules(): array
    {
        // TODO: Implement rules() method.

        return[

            'isocode' => 'unique:containertypes'

        ];

    }
}
