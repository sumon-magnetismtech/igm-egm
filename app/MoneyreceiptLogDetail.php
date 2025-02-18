<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class MoneyreceiptLogDetail extends Model
{
    protected $guarded = [''];

    public function MoneyreceiptLog (){
        return $this->belongsTo('App\MoneyreceiptLog');
    }
}
