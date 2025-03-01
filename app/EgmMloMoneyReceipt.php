<?php

namespace App;

use App\MLO\MoneyReceiptContainer;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class EgmMloMoneyReceipt extends Model
{
    use LogsActivity;
    protected static $logAttributes = ['*'];

    protected $table = 'egm_mlo_money_receipts';

    protected $fillable = ['extensionNo', 'client_id', 'payMode', 'issueDate', 'bolRef', 'doNote', 'fromDate', 'uptoDate', 'duration', 'freeTime', 'remarks', 'chargeableDays', 'moneyReceiptDetails', 'payNumber', 'freeTimeLeft', 'source_name', 'dated'];

    protected $casts = [
        'moneyReceiptDetails' => 'array',
    ];


    public function mloMoneyReceiptDetails()
    {
        return $this->hasMany(EgmMloMoneyReceiptDetails::class, 'moneyReceipt_id');
    }
    public function molblInformations()
    {
        return $this->belongsTo(EgmMloblinformation::class, 'bolRef', 'bolreference')->withDefault();
    }

    public function mloMoneyReceiptContainers()
    {
        return $this->hasMany(MoneyReceiptContainer::class, 'moneyReceipt_id');
    }

    public function client()
    {
        return $this->belongsTo(Cnfagent::class, 'client_id')->withDefault();
    }

    public function deliveryOrder()
    {
        return $this->hasOne(EgmMloDeliveryorder::class, 'mlo_money_receipt_id', 'id')->withDefault();
    }
}
