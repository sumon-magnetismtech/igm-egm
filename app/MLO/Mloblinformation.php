<?php

namespace App\MLO;

use App\Package;
use App\Principal;
use App\Vatreg;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class Mloblinformation extends Model
{
    use LogsActivity;
    protected static $logAttributes = ['*'];

    protected $fillable = [ 'feederinformations_id', 'dg', 'line', 'bolreference', 'principal_id','exportername', 'exporteraddress',
        'consignee_id', 'notify_id', 'mlocode','mloname','mloaddress', 'blnaturecode', 'blnaturetype', 'bltypecode', 'bltypename', 'shippingmark',
        'packageno', 'package_id', 'description', 'grosswt', 'measurement', 'containernumber', 'remarks',
        'freightstatus', 'freightvalue', 'coloader', 'note', 'moneyreceiptStatus','pOrigin','pOriginName','PUloding','unloadingName','consolidated', 'qccontainer'];

    public function __get($key)
    {
        if (is_string($this->getAttribute($key))) {
            return strtoupper( $this->getAttribute($key) );
        } else {
            return $this->getAttribute($key);
        }
    }

    public function blcontainers(){
        return $this->hasMany(Blcontainer::class);
    }
    public function mloMoneyReceipt(){
        return $this->hasOne(MoneyReceipt::class, 'bolRef', 'bolreference');
    }
    public function mlofeederInformation(){
        return $this->belongsTo(Feederinformation::class, 'feederinformations_id')->withDefault();
    }

    public function blConsignee()
    {
        return $this->belongsTo(Vatreg::class, 'consignee_id', 'BIN')->withDefault();
    }

    public function blNotify()
    {
        return $this->belongsTo(Vatreg::class, 'notify_id', 'BIN')->withDefault();
    }


    public function package()
    {
        return $this->belongsTo(Package::class, 'package_id')->withDefault();
    }

    public function principal()
    {
        return $this->belongsTo(Principal::class, 'principal_id')->withDefault();
    }

    public function delayreasons(){
        return $this->belongsTo(Delayreason::class)->withDefault();
    }

    public function setbolreferenceAttribute($input)
    {
        !empty($input) ? $this->attributes['bolreference'] = strtoupper($input) : null;
    }

    public function setpOriginAttribute($input)
    {
        !empty($input) ? $this->attributes['pOrigin'] = strtoupper($input) : null;
    }

    public function setPUlodingAttribute($input)
    {
        !empty($input) ? $this->attributes['PUloding'] = strtoupper($input) : null;
    }

    public function setexporternameAttribute($input)
    {
        !empty($input) ? $this->attributes['exportername'] = strtoupper($input) : null;
    }

    public function setexporteraddressAttribute($input)
    {
        !empty($input) ? $this->attributes['exporteraddress'] = strtoupper($input) : null;
    }

    public function setmlocodeAttribute($input)
    {
        !empty($input) ? $this->attributes['mlocode'] = strtoupper($input) : null;
    }

    public function setmlonameAttribute($input)
    {
        !empty($input) ? $this->attributes['mloname'] = strtoupper($input) : null;
    }

    public function setmloaddressAttribute($input)
    {
        !empty($input) ? $this->attributes['mloaddress'] = strtoupper($input) : null;
    }

    public function setremarksAttribute($input)
    {
        !empty($input) ? $this->attributes['remarks'] = strtoupper($input) : null;
    }

    public function setfreightstatusAttribute($input)
    {
        !empty($input) ? $this->attributes['freightstatus'] = strtoupper($input) : null;
    }

    public function setfreightvalueAttribute($input)
    {
        !empty($input) ? $this->attributes['freightvalue'] = strtoupper($input) : null;
    }

    public function setcoloaderAttribute($input)
    {
        !empty($input) ? $this->attributes['coloader'] = strtoupper($input) : null;
    }

}
