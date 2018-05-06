<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WordExplain extends Model
{
    //
    protected $fillable = ['word_id','explain','word_speech_id'];
    public function word()
    {
        return $this->belongsTo(Word::class);
    }

    public function word_speech()
    {

      return $this->hasMany(WordSpeech::class);

    }

    public function speech()
    {

      return $this->belongsTo(WordSpeech::class,'word_speech_id');

    }
}
