<?php

namespace App\MLO;

use App\Cnfagent;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class MoneyReceipt extends Model
{
    use LogsActivity;
    protected static $logAttributes = ['*'];

    protected $table = 'mlo_money_receipts';

    protected $fillable = ['extensionNo','client_id','payMode','issueDate','bolRef','doNote','fromDate','uptoDate','duration','freeTime','remarks', 'chargeableDays', 'moneyReceiptDetails', 'payNumber', 'freeTimeLeft', 'source_name', 'dated'];

    protected $casts = [
        'moneyReceiptDetails' => 'array',
    ];


    public function mloMoneyReceiptDetails(){
        return $this->hasMany(MoneyReceiptDetails::class, 'moneyReceipt_id');
    }
    public function molblInformations(){
        return $this->belongsTo(Mloblinformation::class, 'bolRef', 'bolreference')->withDefault();
    }

    public function mloMoneyReceiptContainers()
    {
        return $this->hasMany(MoneyReceiptContainer::class, 'moneyReceipt_id');
    }

    public function client()
    {
        return $this->belongsTo(Cnfagent::class, 'client_id')->withDefault();
    }

    public function deliveryOrder(){
        return $this->hasOne(Deliveryorder::class, 'mlo_money_receipt_id', 'id')->withDefault();
    }

}
