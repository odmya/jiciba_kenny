<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Record extends Model
{
    //
    protected $fillable = ['speech_unique','openid','phrase_id','section_id','chapter_id','course_id','media_serverid','media_path'];
}
