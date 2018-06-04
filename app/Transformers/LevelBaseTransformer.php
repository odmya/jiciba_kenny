<?php

namespace App\Transformers;

use App\Models\LevelBase;
use League\Fractal\TransformerAbstract;

class LevelBaseTransformer extends TransformerAbstract
{

    public function transform(LevelBase $levelbase)
    {
        return [
            'id' => $levelbase->id,
            'level_bases'=>$levelbase->level_bases,
            'created_at' => $levelbase->created_at->toDateTimeString(),
            'updated_at' => $levelbase->updated_at->toDateTimeString(),
        ];
    }

}
