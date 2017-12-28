<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Answer extends Model
{
    //
    protected $fillable = ['name','english','chinese','audio_path','image_url'];

    public function question()
    {

      return $this->belongsToMany(Question::class);

    }

}
