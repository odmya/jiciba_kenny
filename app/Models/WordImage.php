<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WordImage extends Model
{
    //

    protected $fillable = ['word_id','image'];
    public function word()
    {
        return $this->belongsTo(Word::class);
    }


}
