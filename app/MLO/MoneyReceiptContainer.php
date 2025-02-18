<?php

namespace App\MLO;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class MoneyReceiptContainer extends Model
{
    use LogsActivity;
    protected static $logAttributes = ['*'];
    protected static $logOnlyDirty = true;

    protected $fillable = ['moneyReceipt_id', 'blcontainer_id'];

    public function mloMoneyReceipt(){
        return $this->belongsTo(MoneyReceipt::class);
    }

    public function mloBlContainer(){
        return $this->belongsTo(Blcontainer::class, 'blcontainer_id');
    }
}
