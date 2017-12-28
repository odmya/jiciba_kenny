<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    //
    protected $fillable = ['name','description_en','description_zh','question_zh','question_en','phrase_list','image_url','correct_answer','audio_path','type','sort','enable'];

    public function section()
    {

      return $this->belongsToMany(Section::class);

    }


    public function answer()
    {

      return $this->belongsToMany(Answer::class);

    }


public function correctanswer()
{

  return $this->hasOne(Answer::class,'id','correct_answer');

}

    public function questiontype()
   {
       return $this->hasOne(QuestionType::class,'id','type');
   }

}
