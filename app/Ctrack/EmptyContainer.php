<?php

namespace App\Ctrack;

use App\MLO\Blcontainer;
use Illuminate\Database\Eloquent\Model;

class EmptyContainer extends Model
{
    protected $fillable = ['blcontainer_id', 'contref','bolreference','date','location','depoName','chassisDelivery', 'containerStatus'];

    public function blContainer()
    {
        return $this->belongsTo(Blcontainer::class, 'blcontainer_id');
    }
}
