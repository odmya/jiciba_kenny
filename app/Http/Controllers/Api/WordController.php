<?php

namespace App\Http\Controllers\Api;

use App\Models\Word;
use App\Models\Sentence;
use Illuminate\Http\Request;
use App\Http\Requests\Api\WordRequest;
use App\Transformers\WordTransformer;
use App\Transformers\SentenceTransformer;

class WordController extends Controller
{
    //
    public function show(WordRequest $request, Word $word)
    {
      $word = $word->where('word',trim($request->word))->first();
      return $this->response->item($word, new WordTransformer())
          ->setStatusCode(201);
    }


    public function wordsearch(Request $request, Word $word)
    {

      $query = $request->input('query');
      $query = trim($query);

      $query_array=explode(" ",$query);

      $words = Word::where('word', 'like', $query.'%')->take(5)->paginate(5);



      return $this->response->paginator($words, new WordTransformer());
    }

    public function star(Request $request, Word $word){

      $star = $request->star;
      $query_star = "star".$star;
      $words =Word::where('level_star', $query_star)->paginate(10);
      //$sentences = $word_obj->sentences()->limit(30)->paginate(10);

       return $this->response->paginator($words, new WordTransformer());

    }


}
