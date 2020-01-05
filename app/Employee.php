<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    public function files()
    {
        return $this->hasMany('App\EmployeeFile');
    }
}
