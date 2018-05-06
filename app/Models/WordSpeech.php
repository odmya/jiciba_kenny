<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WordSpeech extends Model
{
    //
    protected $fillable = ['cixing'];
    public function word_explain()
    {
        return $this->belongsTo(WordExplain::class);
    }

    public function explain()
    {
        return $this->hasMany(WordExplain::class);
    }
}
