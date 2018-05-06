<?php

namespace App\Transformers;

use App\Models\LevelBase;
use League\Fractal\TransformerAbstract;

class LevelTransformer extends TransformerAbstract
{

    public function transform(LevelBase $levelbase)
    {
        return [
            'level_base' => $levelbase->level_bases,
        ];
    }

}
