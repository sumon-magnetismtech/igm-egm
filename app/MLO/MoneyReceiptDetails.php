<?php

namespace App\MLO;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class MoneyReceiptDetails extends Model
{
    use LogsActivity;
    protected static $logAttributes = ['*'];
    protected static $logOnlyDirty = true;

    protected $table = 'mlo_money_receipt_details';
    protected $fillable = ['moneyReceipt_id','particular','amount'];

    public function moneyReceipt(){
        return $this->belongsTo(MoneyReceipt::class, 'moneyReceipt_id')->withDefault();
    }


}
