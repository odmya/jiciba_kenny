<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sentence extends Model
{
  protected $fillable = ['english','chinese','voice_path','quote'];

  public function words()
  {

    return $this->belongsToMany(Word::class);

  }


}
