<?php

namespace App\Transformers;

use App\Models\WordBundle;
use App\Models\LevelBaseWord;
use App\Models\WordRemember;
use League\Fractal\TransformerAbstract;

class WordBundleTransformer extends TransformerAbstract
{

    public function transform(WordBundle $wordbundle)
    {
        $words_ids = WordRemember::where('user_id', '=', $wordbundle->user_id)->pluck('word_id');

        return [
            'id' => $wordbundle->id,
            'user_id' => $wordbundle->user_id,
            'title' => $wordbundle->title,
            'level_base_id'=> $wordbundle->level_base_id,
            'level_base' => $wordbundle->levelbase->level_bases,
            'wordcounts' => LevelBaseWord::where('level_base_id',$wordbundle->level_base_id)->count(),
            'rememberwords' => LevelBaseWord::where('level_base_id',$wordbundle->level_base_id)->whereIn('word_id',$words_ids)->count(),
            'maxsize' => $wordbundle->maxsize,
            'created_at' => $wordbundle->created_at->toDateTimeString(),
            'updated_at' => $wordbundle->updated_at->toDateTimeString(),
        ];
    }

}
