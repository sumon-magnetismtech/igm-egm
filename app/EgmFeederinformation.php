<?php

namespace App;

use App\Country;
use App\EgmMloblinformation;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\SoftDeletes;

class EgmFeederinformation extends Model
{
    use LogsActivity;
    protected static $logAttributes = ['*'];

    use SoftDeletes;
    protected $fillable = [
        'feederVessel',
        'voyageNumber',
        'COCode',
        'COName',
        'departureDate',
        'arrivalDate',
        'berthingDate',
        'rotationNo',
        'careerName',
        'careerAddress',
        'depPortCode',
        'depPortName',
        'desPortCode',
        'desPortName',
        'mtCode',
        'mtType',
        'transportNationality',
        'depot',
        'user_id'
    ];


    public function __get($key)
    {
        if (is_string($this->getAttribute($key))) {
            return strtoupper($this->getAttribute($key));
        } else {
            return $this->getAttribute($key);
        }
    }

    public function mloblInformation()
    {
        return $this->hasMany(EgmMloblinformation::class, 'feederinformations_id');
    }

    public function country()
    {
        return $this->belongsTo(Country::class, 'transportNationality', 'iso');
    }

    public function getFeederVesselAttribute($input)
    {
        return "MV. $input";
    }
}
