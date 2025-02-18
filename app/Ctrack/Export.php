<?php

namespace App\Ctrack;

use App\ExportContainer;
use Illuminate\Database\Eloquent\Model;

class Export extends Model
{
    protected $fillable = ['vesselName','vesselCode','exportDate','voyageNo','rotationNo','sailingDate','etaDate','eStatus','commodity','destination','sealNo','transhipmentPort','remarks'];

    public function exportContainers()
    {
        return $this->hasMany(ExportContainer::class);
    }
}
