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

    public function level_base()
    {

      return $this->belongsToMany(LevelBase::class);

    }



}
