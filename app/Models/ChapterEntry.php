<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ChapterEntry extends Model
{
    protected $table = 'chapter_entry';

    protected $fillable = ['chapter_id','english','chinese','startTime','endTime','machine_audio'];

    public function chapter()
    {
        return $this->belongsTo(Chapter::class);
    }


}
