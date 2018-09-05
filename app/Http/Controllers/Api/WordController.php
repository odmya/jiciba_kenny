<?php

namespace App\Http\Controllers\Api;

use App\Models\Word;
use App\Models\WordSearch;
use App\Models\WordBundle;
use App\Models\LevelBaseWord;
use App\Models\WordRemember;
use App\Models\WordRisk;
use App\Models\User;
use App\Models\WordReview;
use App\Models\WordStrange;

use App\Models\Sentence;
use Illuminate\Http\Request;
use App\Http\Requests\Api\WordRequest;
use App\Transformers\WordTransformer;
use App\Transformers\SentenceTransformer;
use App\Transformers\WordRiskTransformer;
use App\Transformers\WordStrangeListTransformer;
use Illuminate\Support\Facades\DB;

class WordController extends Controller
{
    //
    public function show(WordRequest $request, Word $word)
    {
      $word = $word->where('word',trim($request->word))->first();
      return $this->response->item($word, new WordTransformer())
          ->setStatusCode(201);
    }

    //查询单词是不是已经在已经背过单词例表中



    public function wordremember(WordRequest $request, Word $word)
    {
      $user_id = $request->input('user_id');
      $word_id = $request->input('word_id');


      $wordremember =WordRemember::where('word_id',$word_id)->where('user_id',$user_id)->first();
      $wordreview =WordReview::where('word_id',$word_id)->where('user_id',$user_id)->first();

      $wordstrange =WordStrange::where('word_id',$word_id)->where('user_id',$user_id)->first();
      if($wordremember || $wordstrange ||$wordreview){
        $return_array =['has_remember'=>true];
        return $this->response->array($return_array);
      }else{
        $return_array =['has_remember'=>false];
        return $this->response->array($return_array);
      }

    }

//添加单词到生词本中

public function wordstrange(WordRequest $request, Word $word)
{
  $user_id = $request->input('user_id');
  $word_id = $request->input('word_id');


  $wordstrange =WordStrange::where('word_id',$word_id)->where('user_id',$user_id)->first();
  if($wordstrange){
    $return_array =['add_word'=>false];
    return $this->response->array($return_array);
  }else{
    $return_array =['add_word'=>true];
    $wordremember = WordStrange::create([
        'word_id' => $word_id,
        'user_id' => $user_id

      //  'level_star'=>$level_star
  //      'version' => $crawl_version,
    ]);
    return $this->response->array($return_array);
  }

}


//从记忆单词表中或者生词本中删除

public function removeremember(WordRequest $request, Word $word)
{
  $user_id = $request->input('user_id');
  $word_id = $request->input('word_id');


  $wordstrange =WordStrange::where('word_id',$word_id)->where('user_id',$user_id)->first();
  WordReview::where('word_id',$word_id)->where('user_id',$user_id)->delete();
  WordRisk::where('word_id',$word_id)->where('user_id',$user_id)->delete();
  WordStrange::where('word_id',$word_id)->where('user_id',$user_id)->delete();
  WordRemember::where('word_id',$word_id)->where('user_id',$user_id)->delete();
  $return_array =array();
  $return_array =['remove_word'=>true];
  return $this->response->array($return_array);


}


//生词本例表 wordstranglist

public function wordstrangelist(Request $request){
  $user_id = $request->input('user_id');

  $wordremember =WordStrange::where('user_id',$user_id)->orderBy('updated_at','DESC')->paginate(11);


  return $this->response->paginator($wordremember, new WordStrangeListTransformer());

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

    public function dancizhan(Request $request, Word $word){

      $user_id = $request->input('user_id');
      $word_id = $request->input('word_id');

      $wordremember =WordRemember::where('word_id',$word_id)->where('user_id',$user_id)->first();
      if($wordremember == false){
              $wordremember = WordRemember::create([
                  'word_id' => $word_id,
                  'user_id' => $user_id

                //  'level_star'=>$level_star
            //      'version' => $crawl_version,
              ]);

      }
      WordStrange::where('word_id',$word_id)->where('user_id',$user_id)->delete();
      WordReview::where('word_id',$word_id)->where('user_id',$user_id)->delete();
      WordRisk::where('word_id',$word_id)->where('user_id',$user_id)->delete();
      return $this->response->noContent()->setStatusCode(200);


    }

    public function wordsearchcache(Request $request){

      $word_id = $request->input('word_id');
      $user_id = $request->input('user_id');

      $wordsearch =WordSearch::where('word_id', $word_id)->where("user_id",$user_id)->first();

      if($wordsearch==false){
        $wordsearch = WordSearch::create([
            'word_id' => $word_id,
            'user_id' => $user_id,

          //  'level_star'=>$level_star
      //      'version' => $crawl_version,
        ]);
      }
      $wordsearch->count +=1;
     $wordsearch->save();

      //$words_ids =WordSearch::select('id')->where('user_id', $user_id)->get()->all();
      /*
      $words_ids = DB::table('wordsearch')
      ->select('word_id')
->where('user_id', $user_id)
->limit(5)
->orderBy('count', 'DESC')
->orderBy('updated_at','DESC')
->get()->all();//->toArray();
*/
$words_ids = WordSearch::where('user_id', '=', $user_id)->orderBy('count', 'DESC')->orderBy('updated_at','DESC')->limit(5)->pluck('word_id');
    //  $words = Word::where('word', 'like', $query.'%')->take(5)->paginate(5);


      $words = Word::whereIn('id', $words_ids)->paginate(5);

      return $this->response->paginator($words, new WordTransformer());


    }
    public function answerlist(Request $request){
      $user_id = $request->input('user_id');
      $newwords= WordBundle::where('user_id',$user_id)->first();
      $words_ids = WordRisk::where('user_id', '=', $user_id)->pluck('word_id');

      $words_reviews = WordReview::where('user_id', '=', $user_id)->pluck('word_id');

      $words_id = LevelBaseWord::where('level_base_id',$newwords->level_base_id)->whereNotIn('word_id',$words_ids)->whereNotIn('word_id',$words_reviews)->orderByRaw('RAND()')->paginate(50);

      $words_array_id =array();
      foreach($words_id as $word){
        $words_array_id [] = $word->word_id;
      }


      if(count($words_array_id)==false){
          return $this->response->error('当前木有单词', 422);

      }else{

        $words = Word::whereIn('id', $words_array_id)->get();
        $answer_list =array();
        foreach($words as $word){
          $WordExplain = $word->word_explain()->limit(3)->get();

          $explain_array =array();
          foreach ($WordExplain as $word_explain) {
            //$explain_array[WordSpeech::find($word_explain->word_speech_id)->cixing][] = $word_explain->explain;

            if($word_explain->speech->id){
              //$explain_array[$word_explain->speech->cixing][] = $word_explain->explain;
              if($word_explain->explain)
                $explain_array[] = $word_explain->explain;
            }else{
              if($word_explain['explain'])
              $explain_array[][] = $word_explain['explain'];
            }


          //  echo WordSpeech::find(10)->first()->cixing."<br/>";
            //echo $word_explain->word_speech_id."<br/>";

          }
          if(count($explain_array))
          $tmparr =array();
          $tmparr['id']= $word->id;
          $tmparr['explain'] =implode("",$explain_array);
          $tmparr['checked'] = false;
          $answer_list[] =$tmparr;
        }


      }



      return $this->response->array($answer_list);

    }
    public function newwords(Request $request){
      $user_id = $request->input('user_id');
      $newwords= WordBundle::where('user_id',$user_id)->first();
      if($newwords){
        $maxsize = $newwords->maxsize;
        $wordorder = $newwords->order;
        if($maxsize>=100){
          $maxsize = 100;
        }
        //$sql="select * from level_base_word where level_base_id='".$newwords->level_base_id."' and word_id NOT IN(select word_id from wordremember where user_id=".$user_id.")";
        //$words = DB::select($sql,[1]);
        //dd($words);

        $words_ids = WordRemember::where('user_id', '=', $user_id)->pluck('word_id');

        $words_reviews = WordReview::where('user_id', '=', $user_id)->pluck('word_id');
        $words_array_id =array();

        $wordstrange= WordStrange::whereNotIn('word_id',$words_reviews)->pluck('word_id');

        if(count($wordstrange)){
            foreach($wordstrange as $tmp_word_id){
              $words_array_id [] = $tmp_word_id;
            }

        }


        //$words_array =$words_ids->toArray();

      //  dd($words_array);
        if($wordorder==true){
          $words_id = LevelBaseWord::where('level_base_id',$newwords->level_base_id)->whereNotIn('word_id',$words_ids)->whereNotIn('word_id',$words_reviews)->orderBy('created_at')->paginate($maxsize, ['word_id'], 'uPage');

        }else{
          $words_id = LevelBaseWord::where('level_base_id',$newwords->level_base_id)->whereNotIn('word_id',$words_ids)->whereNotIn('word_id',$words_reviews)->orderByRaw('RAND()')->paginate($maxsize, ['word_id'], 'uPage');

        }
      //  $words_array_id =array();
        foreach($words_id as $word){
          $words_array_id [] = $word->word_id;
        }

        $words_array_id = array_slice($words_array_id,0, $maxsize);

        //$words = Word::whereIn('id', $words_array_id)->get();
        $datastuf = strtotime(date('Y-m-d'));


        if(WordRisk::where('user_id', $user_id)->where('time',$datastuf)->count()==false){
        $wordrisk =WordRisk::where('user_id', $user_id)->where('time',"<",$datastuf)->delete(); //delete old data
          foreach($words_array_id as $word_id){
            WordRisk::create([
                'user_id' => $user_id,
                'word_id' =>$word_id,
                'review' =>0,
                'status' =>0,
                'time' =>$datastuf,
              //  'level_star'=>$level_star
          //      'version' => $crawl_version,
            ]);
          }

        }

        //$wordrisk =WordRisk::where('time',$datastuf)->where('status',0)->pluck('word_id');

        $wordrisk =WordRisk::where('user_id', $user_id)->where('time',$datastuf)->where('status',0)->paginate(5);


        return $this->response->paginator($wordrisk, new WordRiskTransformer());
      }else{
        return $this->response->error('需要添加单词本', 422);
      }

      //return $this->response->collection($words, new WordTransformer());
    }


    public function updateformid(Request $request)
    {
        $user_id = $request->input('user_id');
        $miniformid = $request->input('formid');

        $formid =User::find($user_id);
        if($formid){
          $formid->miniformid = $miniformid;
          $formid->save();
        }else{
          return $this->response->error('参数错误', 422);
        }


        return $this->response->noContent()->setStatusCode(200);
    }

}
