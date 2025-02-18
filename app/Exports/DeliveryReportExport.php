<?php

namespace App\Exports;

use App\Deliveryorder;
use Maatwebsite\Excel\Concerns\FromCollection;

class DeliveryReportExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Deliveryorder::all();
    }
}
