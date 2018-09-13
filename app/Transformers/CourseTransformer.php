<?php

namespace App\Transformers;

use App\Models\Course;
use League\Fractal\TransformerAbstract;

class CourseTransformer extends TransformerAbstract
{

    public function transform(Course $course)
    {
        return [
            'id' => $course->id,
            'name' => $course->name,
            'image' => $course->image,
            'created_at' => $course->created_at->toDateTimeString(),
            'updated_at' => $course->updated_at->toDateTimeString(),
        ];
    }

}
