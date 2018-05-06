<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Root;
use App\Models\RootcixingWord;
use App\Models\Rootcixing;
use App\Models\Word;
use App\Models\WordSpeech;


class RootController extends Controller
{
    //
    public function query($root_id){
      $query_id = trim($root_id);
      $root_obj =Root::find($query_id);
      $root_cixing = Root::find($query_id)->rootcixing()->get();

      foreach($root_cixing as $cixing){
          $speech = WordSpeech::find($cixing->word_speech_id);

         $array_rootcixing[$speech->cixing]['description'] = $cixing->description;
         $wordroots =$cixing->rootcixing_word()->get();
         $wordlist = array();
         foreach ($wordroots as $word_root) {
           // code...
           $tmpword =Word::find($word_root->word_id);
           $wordlist['word'] =$tmpword->word;
           $wordlist['detail'] =$word_root->detail;
           $wordlist['explain'] =$word_root->explain;
         }
         $array_rootcixing[$speech->cixing]['wordlist'] = $wordlist;

      }


      return view('root.query', compact('root_obj','array_rootcixing'));


    }


    public function queryapi(Request $request){
        # code...
        $root_id = $request->input('query');
      $query_id = trim($root_id);
      $root_obj =Root::find($query_id);
      $root_cixing = Root::find($query_id)->rootcixing()->get();

      foreach($root_cixing as $cixing){
          $speech = WordSpeech::find($cixing->word_speech_id);

         $array_rootcixing[$speech->cixing]['description'] = $cixing->description;
         $wordroots =$cixing->rootcixing_word()->get();
         $wordlist = array();
         foreach ($wordroots as $word_root) {
           // code...
           $tmpword =Word::find($word_root->word_id);
           $wordlist[$tmpword->word]['word'] =$tmpword->word;
           $wordlist[$tmpword->word]['detail'] =$word_root->detail;
           $wordlist[$tmpword->word]['explain'] =$word_root->explain;
         }
         $array_rootcixing[$speech->cixing]['wordlist'] = $wordlist;

      }


      return response()->success(compact('root_obj','array_rootcixing'));


    }
}
