<?php

namespace App\Transformers;

use App\Models\Sentence;
use League\Fractal\TransformerAbstract;

class SentenceTransformer extends TransformerAbstract
{

    public function transform(Sentence $sentence)
    {
        return [
            'id' => $sentence->id,
            'english' => $sentence->english,
            'chinese' => $sentence->chinese,
            'voice_path' => $sentence->voice_path,
            'quote' => $sentence->quote,

        ];
    }

}
