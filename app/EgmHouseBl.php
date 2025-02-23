<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;


class EgmHouseBl extends Model
{
    use LogsActivity;
    protected static $logAttributes = ['*'];


    protected $guarded = [];

    public function __get($key)
    {
        if (is_string($this->getAttribute($key))) {
            return strtoupper( $this->getAttribute($key) );
        } else {
            return $this->getAttribute($key);
        }
    }

    public function containers(){
        return $this->hasMany(EgmHouseBlContainers::class, 'housebl_id');
    }

    public function masterbl(){
        return $this->belongsTo(EgmMasterBl::class, 'igm')->withDefault();
    }

    public function moneyReceipt(){
        return $this->hasOne(EgmMoneyreceipt::class, 'hblno');
    }
}
