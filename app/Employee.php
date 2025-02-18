<?php

namespace App;

use App\Payroll\Attendance;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    protected $fillable = ['name'];

    public function attendances()
    {
        return $this->hasMany(Attendance::class);
    }
}
