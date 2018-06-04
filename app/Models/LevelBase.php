<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LevelBase extends Model
{
    //
    protected $fillable = ['level_bases'];
    public function word()
    {
        return $this->belongsToMany(Word::class);
    }

    public function wordbundle()
    {

      return $this->hasMany(WordBundle::class);

    }



}
