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

    public function word_voice()
    {

      return $this->hasMany(WordVoice::class);

    }

    public function word_image()
    {

      return $this->hasMany(WordImage::class);

    }

    public function word_tip()
    {

      return $this->hasMany(WordTip::class);

    }

    public function level_base()
    {

      return $this->belongsToMany(LevelBase::class);

    }

    public function word_description()
    {
        return $this->hasOne(WordDescription::class);
    }



}
