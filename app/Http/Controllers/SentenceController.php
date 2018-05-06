<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Word;

class SentenceController extends Controller
{
    //
    
    public function queryapi(Request $request){
        # code...
        $word = $request->input('query');
      $word = trim($word);

      $word_obj = Word::where('word', $word)->first();

     $sentences = $word_obj->sentences()->limit(15)->paginate(10);

//$sentences = $word_obj->sentences()->limit(50)->paginate(5);

      return response()->success(compact('sentences'));


    }
}
