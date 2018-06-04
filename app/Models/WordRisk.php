<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WordRisk extends Model
{
    protected $table = 'wordrisk';
    protected $fillable = ['user_id','word_id','review','time','status'];

    public function word()
    {
        return $this->belongsTo(Word::class);
    }
    
}
