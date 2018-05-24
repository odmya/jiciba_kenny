<?php

namespace App\Transformers;

use App\Models\Rootcixing;
use App\Models\Root;
use App\Models\RootcixingWord;
use League\Fractal\TransformerAbstract;

class RootCigenTransformer extends TransformerAbstract
{
    protected $availableIncludes = ['cixing'];
    public function transform(Root $root)
    {
        return [
            'id' => $root->id,
            'name' => $root->name,
            'description' =>str_replace(array("&rdquo;","&ldquo;"),"'",$root->description),
            'created_at' => $root->created_at->toDateTimeString(),
            'updated_at' => $root->updated_at->toDateTimeString(),
        ];
    }

    public function includeCixing(Root $root)
    {

    return $this->collection($root->rootcixing()->get(), new RootCixingTransformer());
    }
}
