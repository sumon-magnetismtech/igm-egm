<?php

namespace App\Imports;

use App\MLO\Blcontainer;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class BlcontainerImport implements ToModel, WithHeadingRow
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        return new Blcontainer([
            'contref'               => $row['contref'],
            'type'                  => $row['type'],
            'status'                => $row['status'],
            'sealno'                => $row['sealno'],
            'pkgno'                 => $row['pkgno'],
            'grosswt'               => $row['grosswt'],
            'verified_gross_mass'   => $row['verified_gross_mass'],
            'imco'                  => $row['imco'],
            'un'                    => $row['un'],
            'location'              => $row['location'],
            'commodity'             => $row['commodity'],
        ]);
    }
}
