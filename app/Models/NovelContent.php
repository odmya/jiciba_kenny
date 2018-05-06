<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NovelContent extends Model
{
    protected $table = 'novel_contents';
    protected $fillable = ['novel_chapter_id','english','chinese','slow_audio_path','audio_path'];
    public function novel_chapter()
    {
        return $this->NovelChapter(Novel::class);
    }
}
