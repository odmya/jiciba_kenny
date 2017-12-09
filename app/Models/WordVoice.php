<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WordVoice extends Model
{
    //
    protected $fillable = ['word_id','symbol','path'];
    public function word()
    {
        return $this->belongsTo(Word::class);
    }


}
