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

    public function Correct()
    {
        return $this->belongsTo(Answer::class,'correct','id');
    }


    public function Student_Answer()
    {
        return $this->belongsTo(Answer::class,'student_answer','id');
    }


    public function user()
    {
        return $this->belongsTo(User::class,"openid","openid");
    }

}
