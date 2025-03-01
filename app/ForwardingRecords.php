<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ForwardingRecords extends Model
{
    protected $guarded = [];

    public function masterbl()
    {
        return $this->belongsTo(Masterbl::class, 'mblno', 'mblno');
    }

    public function egmmasterbl()
    {
        return $this->belongsTo(EgmMasterBl::class, 'mblno', 'mblno');
    }
}
