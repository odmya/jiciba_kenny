<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Word;
use App\Models\LevelBase;
use App\Models\LevelBaseWord;
use App\Models\WordSpeech;
use App\Models\WordExplain;
use App\Models\WordVoice;
//use App\Http\Controllers\PaChongController;

class WordController extends Controller
{
    //
    public function query($word)
    {
      # code...
      $query_word = trim($word);
      $query_word = strtolower($query_word);
     //$query_word = $words;
    //  PaChongController::crawl($word);
       $word_obj = Word::where('word', $query_word)->first();  //单词

      $voices =  WordVoice::where('word_id', $word_obj->id)->get();  //单词

      $voice_array = array();
      $tmp_array =array();
      foreach ($voices as $voice) {
        $tmp_array['symbol'] = $voice->symbol;
        $url = 'http://sample.app/voice/word/'.str_replace('voice/word/',"",$voice->path);

        $tmp_array['path'] = $url;
        $voice_array[]=$tmp_array;

    }

      $word_explains = WordExplain::where('word_id', $word_obj->id)->get();  //单词

      $explain_array = array();
      $tmp_array =array();
      foreach ($word_explains as $word_explain) {
        $explain_array[WordSpeech::find($word_explain->word_speech_id)->cixing][] = $word_explain->explain;
      //  echo WordSpeech::find(10)->first()->cixing."<br/>";
        //echo $word_explain->word_speech_id."<br/>";

    }



      return view('word.query', compact('word_obj','explain_array','voice_array'));

    }
}
