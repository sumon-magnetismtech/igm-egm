<?php

namespace App\Imports;

use App\Cnfagent;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;

class CnfagentImport implements ToModel, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new Cnfagent([
            'cnfagent' => $row['cnfagent'],
            'contact' => $row['contact'],
        ]);
    }
}
