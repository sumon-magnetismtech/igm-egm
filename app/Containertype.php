<?php

namespace App;

use App\MLO\Blcontainer;
use Illuminate\Database\Eloquent\Model;

class Containertype extends Model
{
    protected $guarded=[];

    public function container()
    {
        return $this->hasOne(Blcontainer::class, 'type', 'isocode');

    }
}
