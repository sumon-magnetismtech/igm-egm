<?php

namespace App;

use App\EgmMloMoneyReceipt;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class EgmMloMoneyReceiptDetails extends Model
{
    use LogsActivity;
    protected static $logAttributes = ['*'];
    protected static $logOnlyDirty = true;

    protected $table = 'egm_mlo_money_receipt_details';
    protected $fillable = ['moneyReceipt_id', 'particular', 'amount'];

    public function moneyReceipt()
    {
        return $this->belongsTo(EgmMloMoneyReceipt::class, 'moneyReceipt_id')->withDefault();
    }
}
