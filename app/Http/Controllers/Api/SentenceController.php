<?php

namespace App\Http\Controllers\Api;

use App\Models\Sentence;
use App\Models\Word;
use Illuminate\Http\Request;
use App\Transformers\SentenceTransformer;


class SentenceController extends Controller
{
    //
    public function show(Request $request, Word $word)
    {

      $query = $request->input('query');
      $query = trim($query);

      $word_obj = $word->where('word', $query)->first();

     $sentences = $word_obj->sentences()->limit(30)->paginate(10);

      return $this->response->paginator($sentences, new SentenceTransformer());
    }



    public function search(Request $request, Sentence $sentence)
    {

      $query = $request->input('query');
      $query = trim($query);

      $query_array=explode(" ",$query);

      $sentences = Sentence::where('english', 'like', '%'.$query.'%')->limit(30)->paginate(10);



      return $this->response->paginator($sentences, new SentenceTransformer());
    }

}
