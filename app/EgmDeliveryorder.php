<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class EgmDeliveryorder extends Model
{
    use LogsActivity;
    protected static $logAttributes = ['*'];

    protected $guarded = [''];

    public function moneyReceipt(){
        return $this->belongsTo(EgmMoneyreceipt::class, 'moneyrecept_id')->withDefault();
    }
}
