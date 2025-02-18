<?php

namespace App\Imports;

use App\Offdock;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;

class OffdocksImport implements ToModel, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new Offdock([
            'code' => $row['code'],
            'name' => $row['name'],
            'location' => $row['location'],
            'phone' => $row['phone'],
        ]);
    }

    /**
     * @return array
     */
//    public function rules(): array
//    {
//        // TODO: Implement rules() method.
//
//        return[
//
//            'code' => 'unique:offdocks'
//
//        ];
//
//    }
}
