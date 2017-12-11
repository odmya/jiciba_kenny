<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use phpspider\core\phpspider;
use phpspider\core\requests;
use phpspider\core\selector;

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
    public function crawl($words="test",$version="iciba02"){

     $query_word = trim($words);
     $query_word = strtolower($query_word);
    //$query_word = $words;
      $crawl_version = $version;




      $word = Word::where('word', $query_word)->first();
    //  $words = new Word;
    //  $word = $words->where('word', $query_word)->first();

    //  echo $query_word;

      if($word==false){

        $word = Word::create([
            'word' => $query_word,
          //  'level_star'=>$level_star
      //      'version' => $crawl_version,
        ]);


      }else{
      //  $word = Word::where('word', $query_word)->get();
      }

      $word->version = $version;



      $url = "http://www.iciba.com/".$query_word;
      $html = requests::get($url);

      // 抽取星级

      $selector = "//div[contains(@class,'word-rate')]/p/@class";
      // 提取结果
      $result = selector::select($html, $selector);
      //$result =str_replace("'","",$result);

      $level_star = str_replace("'","",$result);
      if($level_star){
        $word->level_star = $level_star;
        //$word->save();
      }


      // 抽取级别

      $selector = "//div[contains(@class,'base-level')]//span";
      // 提取结果
      $result = selector::select($html, $selector);
      if(is_array($result)&&$result){
      $result = array_map('trim', $result);
      $level_base = $result;
      foreach ($level_base as $key => $value) {

        $value = preg_replace('/\s(?=\s)/', '', $value);
        $value =strip_tags($value);

        $level_base = LevelBase::where('level_bases', $value)->first();

        if($level_base==false){
          $level_base = LevelBase::create([

              'level_bases' => trim($value),
          ]);

        }

      $tmp_level =  $word->level_base()->where('level_base_id',$level_base->id)->first();

        if($tmp_level==false){

            $LevelBaseWord = LevelBaseWord::create(['word_id' => $word->id,'level_base_id' => $level_base->id]);
        }
      }

      }


      // 抽取音标

      $selector = "//div[contains(@class,'base-speak')]//span/span[1]";
      // 提取结果
      $result = selector::select($html, $selector);
      $yinbiao=$result;

      $selector = "//i[contains(@class,'new-speak-step')]/@ms-on-mouseover";

      $result = selector::select($html, $selector);
      $fayingpath= $result;

      if($yinbiao){
        if(is_array($yinbiao)){
          foreach ($yinbiao as $key => $value) {
            $tmp_yinbiao = $word->word_voice()->where("symbol",$value)->first();
            if($tmp_yinbiao == false){
              $local_path ="voice/word/".$query_word."_".$key.".mp3";
              if(is_array($fayingpath)){
                $path_tmp = str_replace(array("sound('","')"),"",$fayingpath[$key]);
              }else{
                $path_tmp = str_replace(array("sound('","')"),"",$fayingpath);
              }
              if($path_tmp!=false){
                $voice_path = file_get_contents($path_tmp);
                $sign=file_put_contents($local_path,$voice_path);
              }


              if(isset($sign)&&$sign!=false){
                $word->word_voice()->create(['word_id' => $word->id,'symbol' => $value, 'path'=>$local_path]);
              }



            }else{
              //$word->word_voice()->symbol = $value;
            //  $word->word_voice()->save();
            }

          }

        }else{

          $tmp_yinbiao = $word->word_voice()->where("symbol",$yinbiao)->first();
          if($tmp_yinbiao == false){
            $local_path ="voice/word/".$query_word.".mp3";
            $path_tmp = str_replace(array("sound('","')"),"",$fayingpath);
            $voice_path = file_get_contents($path_tmp);
            $sign=file_put_contents($local_path,$voice_path);

            if($sign!=false){
              $word->word_voice()->create(['word_id' => $word->id,'symbol' => $yinbiao, 'path'=>$local_path]);
            }

          }

        }
      }


      // 抽取发音MP3
      /*
      if($fayingpath){
        foreach ($fayingpath as $key => $value) {
          # code...
          $local_path ="voice/word/".$query_word."_".$key.".mp3";

          $tmp_fayin = $word->word_voice()->where("path",$local_path)->first();

          if($tmp_fayin == false){
            $path_tmp = str_replace(array("sound('","')"),"",$value);
            $voice_path = file_get_contents($path_tmp);
            file_put_contents($local_path,$voice_path);

            $word->word_voice()->path = $local_path;
            $word->word_voice()->save();

          }

        }
      }
      */

      // 抽取单词词性
      /*
      $selector = "//ul[contains(@class,'base-list')]//span[contains(@class,'prop')]";
      // 提取结果
      $result = selector::select($html, $selector);
      if(is_array($result)&&$result)
      $result = array_map('trim', $result);
      $cixing = $result;

      var_dump($cixing );
      */
      // 抽取单词

      //$selector = "//ul[contains(@class,'base-list')]//span[not(contains(@class,'prop'))]";

      $selector = "//ul[contains(@class,'base-list')]//span";

      // 提取结果
      $tmp_list=array("n.", "pron.","adj.", "adv.","vt.& vi.","int.","abbr.",'vt.&amp; vi.', "v.","vi.", "vt.", "num.","art.", "prep.","conj.", "interj.");
      foreach ($tmp_list as $key => $value) {
        $word_speech = WordSpeech::where('cixing', $value)->first();
        if($word_speech == false){
          WordSpeech::create(['cixing'=>$value]);
        }
      }

      $result = selector::select($html, $selector);
      if(is_array($result)&&$result)
      $result = array_map('trim', $result);

      $tmp_explate=array();
      if(is_array($result)&&$result){
        foreach($result as $v){
          $v=str_replace("& ","",$v);

        //  $tmp = "vt.& vi.";
          if(in_array(trim($v),$tmp_list)){
            $tmp=$v;
          }else{
            if(isset($tmp)==false){
              continue;
            }

            $tmp_explate[$tmp][] = $v;
          }

        }
      }

      foreach ($tmp_explate  as $key => $explain_arr) {
        # code...
        $cixing = WordSpeech::where('cixing',$key)->first();

        $tmp_explain=WordExplain::where(['word_speech_id'=>$cixing->id,'word_id'=>$word->id])->first();
        if($tmp_explain ==false){
          foreach ($explain_arr as $key1 => $explain_v) {
              WordExplain::create(['word_speech_id'=>$cixing->id,'word_id'=>$word->id,'explain'=>$explain_v]);
          }

        }

      }


      $word->save();

      //return true;
      /*
      die('test');
      // 抽取单词变形

      $selector = "//li[contains(@class,'change')]//span/a";
      // 提取结果
      $result = selector::select($html, $selector);
      if(is_array($result)&&$result)
      $result = array_map('trim', $result);


      // 抽取单词例句 -英文

      $selector = "//*[contains(@class,'sentence-item')]//span";
      // 提取结果
      $result = selector::select($html, $selector);
      //$result = array_map('strip_tags', $result);
      $result = array_map('trim', $result);


      print_r($result);


      // 抽取单词例句 -中文

      $selector = "//div[contains(@class,'collins-section')]//*[contains(@class,'family-chinese')]";
      // 提取结果
      $result = selector::select($html, $selector);
      //$result = array_map('strip_tags', $result);
      $result = array_map('trim', $result);

      print_r($result);

      // 抽取单词例句发音

      $selector = "//div[contains(@class,'sentence-item')]//i/@ms-on-click";
      // 提取结果
      $result = selector::select($html, $selector);
      $result = array_map('strip_tags', $result);
      $result = array_map('trim', $result);


      print_r($result);
      */


    }

    public function query($word)
    {
      # code...
      $query_word = trim($word);
      $query_word = strtolower($query_word);
     //$query_word = $words;
    //  PaChongController::crawl($word);

       $word_obj = Word::where('word', $query_word)->first();  //单词

if(count($word_obj->word_explain()->get())==false){
  $this->crawl($query_word);

}

      $voices =  WordVoice::where('word_id', $word_obj->id)->get();  //单词

      $voice_array = array();
      $tmp_array =array();
      foreach ($voices as $voice) {
        $tmp_array['symbol'] = $voice->symbol;
        $url = 'https://www.jciba.cn/voice/word/'.str_replace('voice/word/',"",$voice->path);

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
