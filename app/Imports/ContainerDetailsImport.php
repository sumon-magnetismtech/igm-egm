<?php

namespace App\Imports;

use App\Container;
use Illuminate\Database\QueryException;
use Illuminate\Validation\Rule;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;

class ContainerDetailsImport implements ToModel, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    use Importable;


    public function model(array $row){
        return new Container([
            'contref' => $row['contref'],
            'type' => $row['type'],
            'status' => $row['status'],
            'sealno' => $row['sealno'],
            'pkgno' => $row['pkgno'],
            'grosswt' => $row['grosswt'],
            'imco' => $row['imco'],
            'un' => $row['un'],
            'location' => $row['location'],
            'commodity' => $row['commodity'],
        ]);
    }


}
