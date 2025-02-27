<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Contracts\Activity;
use Spatie\Activitylog\Traits\LogsActivity;

class EgmMoneyreceipt extends Model
{
    use LogsActivity;
    protected static $logAttributes = ['*'];

    protected $guarded = [''];

    public function MoneyreceiptDetail(){
         return $this->hasMany(EgmMoneyreceiptDetail::class, 'moneyreceipt_id');
    }

    public function houseBl(){
         return $this->belongsTo(EgmHouseBl::class, 'hblno')->withDefault();
    }

    public function deliveryOrder(){
         return $this->hasOne(EgmDeliveryorder::class, 'moneyrecept_id');
    }

    protected $casts = [
        'mr_details' => 'array',
    ];
}
