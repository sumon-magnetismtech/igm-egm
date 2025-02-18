<?php

namespace App\MLO;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class Deliveryorder extends Model
{
    use LogsActivity;
    protected static $logAttributes = ['*'];

    protected $table = 'mlo_deliveryorders';
    protected $fillable = ['mlo_money_receipt_id','DO_Date','BE_No','BE_Date',];

    public function moneyReceipt()
    {
        return $this->belongsTo(MoneyReceipt::class, 'mlo_money_receipt_id')->withDefault();
    }
}
