<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Userrecord extends Model
{
    //
    protected $fillable = ['speech_unique','openid','push','section_id','chapter_id','course_id'];
}
