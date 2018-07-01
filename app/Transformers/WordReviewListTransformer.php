<?php

namespace App\Transformers;

use App\Models\WordReview;
use League\Fractal\TransformerAbstract;

class WordReviewListTransformer extends TransformerAbstract
{

    public function transform(WordReview $wordreview)
    {

      $words = $wordreview->word->word_explain()->get();
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
          $explain_tmp =array();
          $cixingword_array =array();
          foreach($explain_array as $cixing => $explain){
              $explain_tmp[$cixing] = implode("",$explain);
          }


        return [
            'id' => $wordreview->id,
            'user_id' => $wordreview->user_id,
            'word_id' => $wordreview->word_id,
            'word' => $wordreview->word->word,
            'explain' => $explain_tmp,
        ];
    }

}
