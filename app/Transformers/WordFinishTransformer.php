<?php

namespace App\Transformers;

use App\Models\WordFinish;
use League\Fractal\TransformerAbstract;

class WordFinishTransformer extends TransformerAbstract
{

    public function transform($user)
    {
      $wordfinish = WordFinish::where('user_id', $user->id)->pluck('date');
        return [
            'user_id' => $user->id,
            'date' => $wordfinish,

        ];
    }

}
