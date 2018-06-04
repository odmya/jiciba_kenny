<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Word extends Model
{
    //
    protected $fillable = ['word','level_star','version'];
    public function word_explain()
    {

      return $this->hasMany(WordExplain::class);

    }

    public function explain()
    {

      return $this->hasMany(WordExplain::class);

    }

    public function voice()
    {

      return $this->hasMany(WordVoice::class);

    }

    public function word_review()
    {

      return $this->hasOne(WordReview::class);

    }

    public function word_voice()
    {

      return $this->hasMany(WordVoice::class);

    }

    public function word_image()
    {

      return $this->hasMany(WordImage::class);

    }


    public function tip()
    {

      return $this->hasMany(WordTip::class);

    }
    public function word_tip()
    {

      return $this->hasMany(WordTip::class);

    }

    public function level()
    {

      return $this->belongsToMany(LevelBase::class);

    }

    public function level_base()
    {

      return $this->belongsToMany(LevelBase::class);

    }

    public function word_description()
    {
        return $this->hasOne(WordDescription::class);
    }

    public function rootcixing()
      {
          return $this->belongsToMany(Rootcixing::class);
      }


      public function root()
      {

        return $this->hasMany(RootcixingWord::class);

      }

      public function rootcixing_word()
      {

        return $this->hasMany(RootcixingWord::class);

      }

      public function sentences()
      {

        return $this->belongsToMany(Sentence::class);

      }


}
