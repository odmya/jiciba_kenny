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
          $cixingword_array =array();
          $rootcixingwords = $wordrisk->word->rootcixing_word()->get();

          foreach($rootcixingwords as $cixingword){
            $cixingword->rootcixing->root['description'] = str_replace(array("&rdquo;","&ldquo;"),"'",$cixingword->rootcixing->root['description']);
            $cixingword['root'] =$cixingword->rootcixing->root;
            $cixingword_array[]= $cixingword;
          }

        return [
            'id' => $wordrisk->id,
            'user_id' => $wordrisk->user_id,
            'word_id' => $wordrisk->word_id,
            'word' => $wordrisk->word->word,
            'image' => $wordrisk->word->word_image()->first(),
            'tips' => $wordrisk->word->word_tip()->orderBy('updated_at','DESC')->offset(0)->limit(1)->get(),
            'voice' => $wordrisk->word->word_voice,
            'explain' => $explain_array,
            'root' => $cixingword_array,
            'sentences' => $wordrisk->word->sentences()->limit(1)->get(),

            'review' => $wordrisk->review,
            'time' => $wordrisk->time,
            'status' => $wordrisk->status,
            'created_at' => $wordrisk->created_at->toDateTimeString(),
            'updated_at' => $wordrisk->updated_at->toDateTimeString(),
        ];
    }

}
