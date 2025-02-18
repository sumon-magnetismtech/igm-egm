<?php

namespace App\Payroll;

use App\Employee;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class Attendance extends Model
{
    protected $fillable = ['date','employee_id','status','in_time','out_time','late','early'];

    protected $with = 'employee';

    public function employee()
    {
        return $this->belongsTo(Employee::class)->withDefault();
    }

//    public function setDateAttribute($input)
//    {
//        $this->attributes['date'] = Carbon::createFromFormat('d/m/Y', $input)->format('Y-m-d');
//    }

    public function getDateAttribute($input)
    {
        return Carbon::createFromFormat('Y-m-d', $input)->format('d/m/Y');
    }




}
