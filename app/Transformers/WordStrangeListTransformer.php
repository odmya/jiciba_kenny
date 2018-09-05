<?php

namespace App\Transformers;

use App\Models\WordStrange;
use League\Fractal\TransformerAbstract;

class WordStrangeListTransformer extends TransformerAbstract
{

    public function transform(WordStrange $wordstrange)
    {
      $words = $wordstrange->word->word_explain()->get();
// 合并数组
      $explain_array =array();
            foreach ($words as $word_explain) {
              //$explain_array[WordSpeech::find($word_explain->word_speech_id)->cixing][] = $word_explain->explain;

              if($word_explain->speech->id){
                $explain_array[$word_explain->speech->cixing][] = $word_explain->explain;
              }else{
                $explain_array[][] = $word_explain['explain'];
              }


            //  echo WordSpeech::find(10)->first()->cixing."<br/>";
              //echo $word_explain->word_speech_id."<br/>";

          }

        return [
            'id' => $wordstrange->id,
            'user_id' => $wordstrange->user_id,
            'word_id' => $wordstrange->word_id,
            'word' => $wordstrange->word->word,
            'explain' => $explain_array,

            'created_at' => $wordstrange->created_at->toDateTimeString(),
            'updated_at' => $wordstrange->updated_at->toDateTimeString(),
        ];
    }

}
