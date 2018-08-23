<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WordRemember extends Model
{
    protected $table = 'wordremember';
    protected $fillable = ['user_id','word_id'];

    public function word()
    {
        return $this->belongsTo(Word::class);
    }
    
}
