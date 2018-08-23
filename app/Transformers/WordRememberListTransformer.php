<?php

namespace App\Transformers;

use App\Models\WordRemember;
use League\Fractal\TransformerAbstract;

class WordRememberListTransformer extends TransformerAbstract
{

    public function transform(WordRemember $wordremember)
    {

      $words = $wordremember->word->word_explain()->get();
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
            'id' => $wordremember->id,
            'user_id' => $wordremember->user_id,
            'word_id' => $wordremember->word_id,
            'word' => $wordremember->word->word,
            'explain' => $explain_array,
        ];
    }

}
