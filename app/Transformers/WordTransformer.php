<?php

namespace App\Transformers;

use App\Models\Word;
use App\Models\WordExplain;
use App\Models\WordTip;
use League\Fractal\TransformerAbstract;

class WordTransformer extends TransformerAbstract
{
    protected $availableIncludes = ['explain', 'voice','tip','level','root','sentence'];
    public function transform(Word $word)
    {
        return [
            'id' => $word->id,
            'word' => $word->word,
            'explain_china' => $word->word_explain()->first(),
            'level_star' => str_replace("star","",$word->level_star),
            'created_at' => $word->created_at->toDateTimeString(),
            'updated_at' => $word->updated_at->toDateTimeString(),
        ];
    }


//level base64_encode
public function includeLevel(Word $word)
{


return $this->collection($word->level_base()->get(), new LevelTransformer());
}
    // 解释
    public function includeExplain(Word $word)
    {
      $words = $word->word_explain()->get();
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
if(count($explain_array)){
  $new_explain =new WordExplain;
  $new_explain->explain =$explain_array;
}else{
  return;
}

    //  return $this->response->array($explain_array);
      return $this->item($new_explain, new ExplainTransformer());
    }


public function includeRoot(Word $word)
{
//$aaa=$word->rootcixing_word()->get();
//dd($aaa);
    return $this->collection($word->rootcixing_word()->get(), new RootTransformer());
}
//发音
    public function includeVoice(Word $word)
    {

        return $this->collection($word->word_voice()->get(), new VoiceTransformer());
    }


    public function includeTip(Word $word)
    {
        return $this->collection($word->word_tip()->get(), new TipTransformer());
    }

    public function includeSentence(Word $word){

      $sentences = $word->sentences()->offset(0)->limit(2)->get();

    //  dd($sentences);
      //$sentences = Sentence::where('english', 'like', '%'.$query.'%')->limit(30)->paginate(10);



      return $this->collection($sentences, new SentenceTransformer());
    }

// 例句
/*

transformers z里面不分页 paginator 方法
    public function includeSentence(Word $word)
    {
        return $this->collection($word->sentences()->limit(15)->paginate(10), new SentenceTransformer());
    }

    */
}
