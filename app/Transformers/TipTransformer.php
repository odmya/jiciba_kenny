<?php

namespace App\Transformers;

use App\Models\WordTip;
use League\Fractal\TransformerAbstract;

class TipTransformer extends TransformerAbstract
{

    public function transform(WordTip $tip)
    {
        return [
            'tip' => $tip->tip,
            'praise'=>$tip->praise,
            'created_at' => $tip->created_at->toDateTimeString(),
            'updated_at' => $tip->updated_at->toDateTimeString(),
        ];
    }

}
