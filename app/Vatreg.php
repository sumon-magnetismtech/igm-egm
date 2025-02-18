<?php

namespace App;

use App\MLO\Mloblinformation;
use Illuminate\Database\Eloquent\Model;

class Vatreg extends Model
{
    protected $guarded = [];

    public $timestamps = false;

    public function blInfo()
    {
        return $this->hasOne(Mloblinformation::class, 'notify_id', "BIN");
    }
    public function blInfoConsignee()
    {
        return $this->hasOne(Mloblinformation::class, 'consignee_id', "BIN");
    }
}
