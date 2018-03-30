<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WordTip extends Model
{
    //
    protected $fillable = ['word_id','user_id','tip','praise'];
    public function word()
    {
        return $this->belongsTo(Word::class);
    }

}
