<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Chapter extends Model
{
    //
    protected $fillable = ['course_id','name','lrc','is_explain','voice_path','sub_header','description','notes'];

    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    public function section()
    {

      return $this->hasMany(Section::class);

    }

    public function chapter_entry()
    {

      return $this->hasMany(ChapterEntry::class);

    }

    public function scopeRecent($query)
      {
          // 按照创建时间排序
          return $query->orderBy('created_at', 'desc');
      }



}
