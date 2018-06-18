<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AutoRecord extends Model
{
    protected $table = 'autorecord';
    protected $fillable = ['user_openid','template_id','miniformid','run_time'];
}
