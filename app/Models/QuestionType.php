<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class QuestionType extends Model
{
    //

    protected $fillable = ['name'];

    public function question()
   {
       return $this->belongsTo(Question::class,'id','type');
   }

}
