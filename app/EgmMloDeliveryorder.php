<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class EgmMloDeliveryorder extends Model
{
    use LogsActivity;
    protected static $logAttributes = ['*'];

    protected $table = 'egm_mlo_deliveryorders';
    protected $fillable = ['mlo_money_receipt_id','DO_Date','BE_No','BE_Date',];

    public function moneyReceipt()
    {
        return $this->belongsTo(EgmMloMoneyReceipt::class, 'mlo_money_receipt_id')->withDefault();
    }
}
