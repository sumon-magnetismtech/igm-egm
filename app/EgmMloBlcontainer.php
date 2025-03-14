<?php

namespace App;

use App\EgmMloblinformation;
use App\Ctrack\EmptyContainer;
use App\MLO\MoneyReceiptContainer;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class EgmMloBlcontainer extends Model
{
    use LogsActivity;
    protected static $logAttributes = ['*'];
    protected static $logOnlyDirty = true;

    protected $fillable = ['mloblinformations_id', 'contref', 'type', 'status', 'sealno', 'pkgno', 'grosswt', 'verified_gross_mass', 'imco', 'un', 'location', 'commodity', 'containerStatus', 'payment'];

    public function mloblinformation()
    {
        return $this->belongsTo(EgmMloblinformation::class)->withDefault();
    }

    public function emptyContainers()
    {
        return $this->hasMany(EmptyContainer::class, 'blcontainer_id');
    }

    public function mloMoneyReceiptContainers()
    {
        return $this->hasMany(MoneyReceiptContainer::class, 'blcontainer_id');
    }

    public function containerGroup()
    {
        return $this->belongsTo(Containertype::class, 'type', 'isocode')->withDefault();
    }


    public function __get($key)
    {
        if (is_string($this->getAttribute($key))) {
            return strtoupper($this->getAttribute($key));
        } else {
            return $this->getAttribute($key);
        }
    }
}
