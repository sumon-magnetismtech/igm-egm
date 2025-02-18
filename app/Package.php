<?php

namespace App;

use App\MLO\Mloblinformation;
use Illuminate\Database\Eloquent\Model;

class Package extends Model
{
    protected $guarded = [];

    public function mloinformation()
    {
        return $this->hasMany(Mloblinformation::class, 'package_id');
    }
}
