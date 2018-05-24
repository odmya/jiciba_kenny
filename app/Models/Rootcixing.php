<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Rootcixing extends Model
{

  protected $fillable = ['root_id','word_speech_id','description'];

  public function root()
  {
      return $this->belongsTo(Root::class);
  }


  public function word_speech()
  {
      return $this->belongsTo(WordSpeech::class);
  }

  public function rootcixing_word()
    {
        return $this->hasMany(RootcixingWord::class);
    }

    public function words()
    {

      return $this->belongsToMany(Word::class)->withPivot('detail', 'explain','root_alias');;

    }

}
