<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EmailConfirmCode extends Model
{
    protected $table = 'email_confirm_codes';

    protected $fillable = ['code', 'user_id'];

    public $timestamps = false;
}
