<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Contracts\Activity;
use Spatie\Activitylog\Traits\LogsActivity;

class Moneyreceipt extends Model
{
    use LogsActivity;
    protected static $logAttributes = ['*'];

    protected $guarded = [''];

    public function MoneyreceiptDetail(){
         return $this->hasMany('App\MoneyreceiptDetail');
    }

    public function houseBl(){
         return $this->belongsTo(Housebl::class, 'hblno')->withDefault();
    }

    public function deliveryOrder(){
         return $this->hasOne(Deliveryorder::class, 'moneyrecept_id');
    }

    protected $casts = [
        'mr_details' => 'array',
    ];

}
