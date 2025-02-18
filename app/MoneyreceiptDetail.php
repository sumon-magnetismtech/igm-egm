<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class MoneyreceiptDetail extends Model
{
    use LogsActivity;

    protected static $logAttributes = ['*'];

    protected static $logOnlyDirty = true;

    protected $guarded = [''];

    protected $touches = ['Moneyrecept'];

    public function Moneyrecept (){
        return $this->belongsTo('App\Moneyreceipt');
    }

}
