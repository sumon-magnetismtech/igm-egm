<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MoneyReceiptHead extends Model
{

    protected $fillable = ['name', 'description'];

    public function setNameAttribute($input)
    {
        $this->attributes['name'] = strtoupper($input);
    }
}
