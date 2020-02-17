<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    public function files()
    {
        return $this->hasMany('App\EmployeeFile', 'iin', 'iin');
    }
    public function citizenships()
    {
        return $this->belongsTo('App\Citizenship');
    }
    public function positions()
    {
        return $this->belongsTo('App\Position');
    }
    public function statuses()
    {
        return $this->belongsTo('App\EmployeeStatus');
    }
}
