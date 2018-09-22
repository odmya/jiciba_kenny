<?php

namespace App\Transformers;

use App\Models\ChapterEntry;
use App\Models\Chapter;
use League\Fractal\TransformerAbstract;

class MachineVoiceTransformer extends TransformerAbstract
{

    public function transform(ChapterEntry $chapterentry)
    {
        return [
            'id' => $chapterentry->id,
            'english' => $chapterentry->english,
            'chinese' => $chapterentry->chinese,
            'startTime' => $chapterentry->startTime,
            'machine_normal' => $chapterentry->machine_normal,
            'machine_slow' => $chapterentry->machine_slow,
            'created_at' => $chapterentry->created_at->toDateTimeString(),
            'updated_at' => $chapterentry->updated_at->toDateTimeString()
        ];
    }

}
