<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LevelBaseWord extends Model
{
    //
    protected $table = 'level_base_word';
    protected $fillable = ['word_id','level_base_id'];
    //protected $primaryKey = ['word_id', 'level_base_id']; 
}
