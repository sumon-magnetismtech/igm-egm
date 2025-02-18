<?php

namespace App\MLO;

use App\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class Delayreason extends Model
{
    protected $fillable = ['mloblinformation_id','reason','noted_date','noted_by'];

    public function mloblinformation(){
        return $this->belongsTo(Mloblinformation::class)->withDefault();
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'noted_by')->withDefault();
    }

    public function setNotedDateAttribute($input)
    {
        $this->attributes['noted_date'] = Carbon::createFromFormat('d/m/Y', $input)->format('Y-m-d');
    }

    public function getNotedDateAttribute($input)
    {
        return Carbon::createFromFormat('Y-m-d', $input)->format('d/m/Y');
    }
}
