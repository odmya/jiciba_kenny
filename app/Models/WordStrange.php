<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WordStrange extends Model
{
    protected $table = 'word_strange';
    protected $fillable = ['user_id','word_id'];

    public function word()
    {
        return $this->belongsTo(Word::class);
    }
}
