<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WordSearch extends Model
{
    protected $table = 'wordsearch';
    protected $fillable = ['word_id','user_id'];
}
