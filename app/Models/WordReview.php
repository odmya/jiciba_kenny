<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WordReview extends Model
{
    protected $table = 'wordreview';
    protected $fillable = ['user_id','word_id','status','remember_time','next_time'];

    public function word()
    {
        return $this->belongsTo(Word::class);
    }
    
}
