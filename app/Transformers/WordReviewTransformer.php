<?php

namespace App\Transformers;

use App\Models\WordReview;
use League\Fractal\TransformerAbstract;

class WordReviewTransformer extends TransformerAbstract
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

          $rootcixingwords = $wordreview->word->rootcixing_word()->get();

          foreach($rootcixingwords as $cixingword){
            $cixingword->rootcixing->root['description'] = str_replace(array("&rdquo;","&ldquo;"),"'",$cixingword->rootcixing->root['description']);
            $cixingword['root'] =$cixingword->rootcixing->root;
            $cixingword_array[]= $cixingword;
          }



        return [
            'id' => $wordreview->id,
            'user_id' => $wordreview->user_id,
            'word_id' => $wordreview->word_id,
            'word' => $wordreview->word->word,
            'image'=>$wordreview->word->word_image()->first(),
            'word_review' => $wordreview->word->word_review,
            'tips' => $wordreview->word->word_tip()->orderBy('updated_at','DESC')->offset(0)->limit(1)->get(),
            'root' => $cixingword_array,
            'voice' => $wordreview->word->word_voice,
            'explain' => $explain_tmp,
            'sentences' => $wordreview->word->sentences()->orderBy('updated_at','DESC')->offset(0)->limit(1)->get(),

            'review' => $wordreview->review,
            'time' => $wordreview->time,
            'status' => $wordreview->status,
            'created_at' => $wordreview->created_at->toDateTimeString(),
            'updated_at' => $wordreview->updated_at->toDateTimeString(),
        ];
    }

}
