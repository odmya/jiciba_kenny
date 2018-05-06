<?php

namespace App\Transformers;

use App\Models\RootcixingWord;
use League\Fractal\TransformerAbstract;

class RootTransformer extends TransformerAbstract
{

    public function transform(RootcixingWord $rootcixingword)
    {
        return [
            'id' => $rootcixingword->id,
            'root_id' => $rootcixingword->rootcixing->root->id,
            'root' => $rootcixingword->rootcixing->root->name,
            'root_description' => $rootcixingword->rootcixing->root->description,
            'root_alias' => $rootcixingword->root_alias,
            'detail' => $rootcixingword->detail,
            'created_at' => $rootcixingword->created_at->toDateTimeString(),
            'updated_at' => $rootcixingword->updated_at->toDateTimeString(),
        ];
    }

}
