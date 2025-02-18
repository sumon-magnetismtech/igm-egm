<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class MoneyreceiptLog extends Model
{
//    use LogsActivity;
//    protected static $logAttributes = ['*'];
//    protected static $logOnlyDirty = true;

    protected $guarded = [''];

    public function MoneyreceiptLogDetail (){
        return $this->hasMany('App\MoneyreceiptLogDetail');
    }
}
