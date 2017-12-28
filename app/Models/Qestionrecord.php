<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Qestionrecord extends Model
{
    //
    protected $fillable = ['speech_unique','openid','question_id','correct','student_answer'];

    public function question()
    {
        return $this->belongsTo(Question::class);
    }

    public function correct()
    {
        return $this->belongsTo(Answer::class,'id','correct');
    }


    public function student_answer()
    {
        return $this->belongsTo(Answer::class,'id','student_answer');
    }


    public function user()
    {
        return $this->belongsTo(User::class,"openid","openid");
    }

}
