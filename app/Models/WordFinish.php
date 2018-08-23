<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WordFinish extends Model
{
    protected $table = 'word_finish';
    protected $fillable = ['user_id','date'];
}
