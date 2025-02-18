<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;

class Masterbl extends Model
{
    use LogsActivity;
    protected static $logAttributes = ['*'];

    use SoftDeletes;
    protected $fillable =['noc','cofficecode','cofficename','mblno','blnaturecode','blnaturetype','bltypecode','bltypename','fvessel','voyage','rotno','principal','departure','arrival','berthing','freetime','pocode','poname','pucode','puname','carrier','carrieraddress','depot','mv','mlocode','mloname','mloaddress','mloemail', 'mloLineNo', 'mloCommodity', 'contMode', 'jetty', 'remarks'];


    protected $dates = ['deleted_at', 'arrival', 'departure', 'berthing'];

    public function __get($key)
    {
        if (is_string($this->getAttribute($key))) {
            return strtoupper( $this->getAttribute($key) );
        } else {
            return $this->getAttribute($key);
        }
    }

    public function housebls(){
        return $this->hasMany(Housebl::class, 'igm');
    }

    public function forwarding()
    {
        return $this->hasOne(ForwardingRecords::class, 'mblno', 'mblno');
    }

    public function containers()
    {
        return $this->hasManyThrough(Container::class, Housebl::class, 'igm', 'housebl_id');
    }
}
