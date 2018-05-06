<?php

namespace App\Transformers;

use App\Models\WordVoice;
use League\Fractal\TransformerAbstract;

class VoiceTransformer extends TransformerAbstract
{

    public function transform(WordVoice $voice)
    {
        return [
            'id' => $voice->id,
            'symbol' => $voice->symbol,
            'path' => '/uploads/voice/word/'.str_replace('voice/word/',"",$voice->path),
            'created_at' => $voice->created_at->toDateTimeString(),
            'updated_at' => $voice->updated_at->toDateTimeString(),
        ];
    }

}
