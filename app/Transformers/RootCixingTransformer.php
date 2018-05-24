<?php

namespace App\Transformers;

use App\Models\Rootcixing;
use App\Models\Root;
use App\Models\RootcixingWord;
use League\Fractal\TransformerAbstract;

class RootCixingTransformer extends TransformerAbstract
{

    public function transform(Rootcixing $rootcixing)
    {

        return [
            'id' => $rootcixing->id,
            'cixing' =>$rootcixing->word_speech->cixing,
            'description' =>str_replace(array("&rdquo;","&ldquo;"),"'",$rootcixing->description),
            'words' =>$rootcixing->words,
            'created_at' => $rootcixing->created_at->toDateTimeString(),
            'updated_at' => $rootcixing->updated_at->toDateTimeString(),
        ];
    }

}
