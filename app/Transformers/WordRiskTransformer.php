<?php

namespace App\Transformers;

use App\Models\WordRisk;
use League\Fractal\TransformerAbstract;

class WordRiskTransformer extends TransformerAbstract
{

    public function transform(WordRisk $wordrisk)
    {

      $words = $wordrisk->word->word_explain()->get();
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
            'id' => $wordrisk->id,
            'user_id' => $wordrisk->user_id,
            'word_id' => $wordrisk->word_id,
            'word' => $wordrisk->word->word,
            'tips' => $wordrisk->word->word_tip()->offset(0)->limit(1)->get(),
            'voice' => $wordrisk->word->word_voice,
            'explain' => $explain_array,
            'root' => $wordrisk->word->rootcixing_word,
            'sentences' => $wordrisk->word->sentences()->offset(0)->limit(1)->get(),

            'review' => $wordrisk->review,
            'time' => $wordrisk->time,
            'status' => $wordrisk->status,
            'created_at' => $wordrisk->created_at->toDateTimeString(),
            'updated_at' => $wordrisk->updated_at->toDateTimeString(),
        ];
    }

}