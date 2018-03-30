<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WordDescription extends Model
{
    //
    protected $fillable = ['word_id','description','story'];
    public function word()
    {
        return $this->belongsTo(Word::class);
    }
}
