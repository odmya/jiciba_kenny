<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Novel extends Model
{

  protected $fillable = ['name','description','image','author','novel_type_id'];
  public function novel_chapter()
  {

    return $this->hasMany(NovelChapter::class);

  }

  public function novel_type()
  {
      return $this->belongsTo(NovelType::class);
  }
}
