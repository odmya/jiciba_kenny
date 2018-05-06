<?php

namespace App\Transformers;

use App\Models\WordExplain;
use League\Fractal\TransformerAbstract;

class ExplainTransformer extends TransformerAbstract
{

    public function transform(WordExplain $explain)
    {
        return [
            'explain' => $explain->explain,
        ];
    }

}
