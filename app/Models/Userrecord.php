<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Userrecord extends Model
{
    //
    protected $fillable = ['speech_unique','openid','push','section_id','chapter_id','course_id'];

    public function section()
    {
        return $this->belongsTo(Section::class);
    }

    public function chapter()
    {
        return $this->belongsTo(Chapter::class);
    }

    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class,"openid","openid");
    }

}
