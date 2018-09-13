<?php

namespace App\Transformers;

use App\Models\ChapterEntry;
use App\Models\Chapter;
use League\Fractal\TransformerAbstract;

class ChapterEntryTransformer extends TransformerAbstract
{

    public function transform(Chapter $chapter)
    {
        return [
            'id' => $chapter->id,
            'name' => $chapter->name,
            'course_name' => $chapter->course->name,
            'course_id' => $chapter->course->id,
            'chapter_list' => $chapter->course->chapter,
            'voice_path' => $chapter->voice_path,
            'chapter_entry' => $chapter->chapter_entry,
            'created_at' => $chapter->created_at->toDateTimeString(),
            'updated_at' => $chapter->updated_at->toDateTimeString(),
        ];
    }

}
