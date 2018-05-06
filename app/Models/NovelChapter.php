<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NovelChapter extends Model
{
    protected $table = 'novel_chapters';
    protected $fillable = ['novel_id','description','name','english','chinese','audio_path'];
    public function novel()
    {
        return $this->belongsTo(Novel::class);
    }

    public function novel_content()
    {

      return $this->hasMany(NovelContent::class);

    }

}
