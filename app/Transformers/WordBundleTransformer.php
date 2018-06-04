<?php

namespace App\Transformers;

use App\Models\WordBundle;
use League\Fractal\TransformerAbstract;

class WordBundleTransformer extends TransformerAbstract
{

    public function transform(WordBundle $wordbundle)
    {

        return [
            'id' => $wordbundle->id,
            'user_id' => $wordbundle->user_id,
            'title' => $wordbundle->title,
            'level_base_id'=> $wordbundle->level_base_id,
            'level_base' => $wordbundle->levelbase->level_bases,
            'maxsize' => $wordbundle->maxsize,
            'created_at' => $wordbundle->created_at->toDateTimeString(),
            'updated_at' => $wordbundle->updated_at->toDateTimeString(),
        ];
    }

}
