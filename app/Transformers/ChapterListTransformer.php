<?php

namespace App\Transformers;

use App\Models\Course;
use League\Fractal\TransformerAbstract;

class ChapterListTransformer extends TransformerAbstract
{

    public function transform(Course $course)
    {
        return [
            'id' => $course->id,
            'name' => $course->name,
            'image' => $course->image,
            'chapters' => $course->chapter,
            'created_at' => $course->created_at->toDateTimeString(),
            'updated_at' => $course->updated_at->toDateTimeString(),
        ];
    }

}
