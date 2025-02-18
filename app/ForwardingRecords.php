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
}
