<?php

namespace App\Imports;

use App\Commodity;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;

class CommoditysImport implements ToModel, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new Commodity([
            'commoditycode' => $row['commoditycode'],
            'commoditydescription' => $row['commoditydescription']
        ]);
    }

    /**
     * @return array
     */
//    public function rules(): array
//    {
//        // TODO: Implement rules() method.
//
//
//        return[
//
//          'commoditycode' => 'unique:commodities'
//
//        ];
//
//    }
}
