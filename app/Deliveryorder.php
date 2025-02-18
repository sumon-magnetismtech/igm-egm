<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class Deliveryorder extends Model
{
    use LogsActivity;
    protected static $logAttributes = ['*'];

    protected $guarded = [''];

    public function moneyReceipt(){
        return $this->belongsTo(Moneyreceipt::class, 'moneyrecept_id')->withDefault();
    }
}
