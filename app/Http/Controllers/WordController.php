<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use phpspider\core\phpspider;
use phpspider\core\requests;
use phpspider\core\selector;

use App\Models\Root;
use App\Models\RootcixingWord;
use App\Models\Rootcixing;
use App\Models\Word;
use App\Models\WordTip;
use App\Models\LevelBase;
use App\Models\LevelBaseWord;
use App\Models\WordSpeech;
use App\Models\WordExplain;
use App\Models\WordVoice;
use App\Models\Sentence;

use AipSpeech;

use Google\Cloud\Translate\TranslateClient;
use Google\Cloud\Speech\SpeechClient;

putenv('GOOGLE_APPLICATION_CREDENTIALS='.public_path().'/google-95003-2d37e7203dfa2017-11-12.json');

//use App\Http\Controllers\PaChongController;

class WordController extends Controller
{
    //
    public function crawl($words="test",$version="iciba02"){

     $query_word = trim($words);
     $query_word = strtolower($query_word);
     //dd($query_word);
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
              $local_path =str_replace(" ","_",$query_word)."_".$key.".mp3";
              $save_local_path = public_path()."/uploads/voice/word/".str_replace(" ","_",$query_word)."_".$key.".mp3";
              if(is_array($fayingpath)){
                $path_tmp = str_replace(array("sound('","')"),"",$fayingpath[$key]);
              }else{
                $path_tmp = str_replace(array("sound('","')"),"",$fayingpath);
              }
              if($path_tmp!=false){
                $voice_path = file_get_contents($path_tmp);
                $sign=file_put_contents($save_local_path,$voice_path);
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
            $local_path =str_replace(" ",'_',$query_word).".mp3";
            $save_local_path = public_path()."/uploads/voice/word/".str_replace(" ",'_',$query_word).".mp3";
            $path_tmp = str_replace(array("sound('","')"),"",$fayingpath);
            $voice_path = file_get_contents($path_tmp);
            $sign=file_put_contents($save_local_path,$voice_path);

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
      $this->crawl2($query_word, $version);
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


    public function crawl2($words="test",$version="iciba03"){
      $query_word = trim($words);
      $query_word = strtolower($query_word);
      //$query_word = $words;
       $crawl_version = $version;

       $word = Word::where('word', $query_word)->first();
       $word->version = $crawl_version;
       $word->save();

    for($i=0;$i<10;$i++){




       //$url = "http://dj.iciba.com/".$query_word;
       $url="http://www.jukuu.com/show-".$query_word."-".$i.".html";
       $html = requests::get($url);

       // 抽取星级

       //$selector = "//span[contains(@class,'stc_en_txt ')]";
       //$selector = "//span[contains(@class,'stc_cn_txt')]";

       $selector = "//table[@id='Table1']//table/tr[@class='e']/td";
       $selector2 = "//table[@id='Table1']//table/tr[@class='c']/td";
       $selector3 = "//table[@id='Table1']//table/tr/td[@width='75%']";
       // 提取结果 container1
       $result_en_tmp = selector::select($html, $selector);
       $result_zh_tmp = selector::select($html, $selector2);
       $result_en =array();
       if($result_en_tmp ==false){
         break;
       }

       foreach($result_en_tmp as $k=>$en){
         if($k%2){
            $result_en[] =trim(str_replace(array('<b>','</b>'),'',strip_tags($en)));
         }
       }
        $result_zh =array();
       foreach($result_zh_tmp as $kzh=>$zh){
         if($kzh%2){
            $result_zh[] =trim(str_replace(array('<b>','</b>'),'',strip_tags($zh)));
         }
       }

       $result_from = selector::select($html, $selector3);

       foreach($result_en as $key=>$item){

         $sentence = Sentence::where('english', trim($result_en[$key]))->first();

        //  $words = new Word;
        //  $word = $words->where('word', $query_word)->first();

        //  echo $query_word;

         if($sentence==false&&strlen($result_en[$key])<255&&strlen($result_zh[$key])<255){
           if(trim($result_from[$key]) !="-- 来源 -- 网友提供"){
             $sentence = Sentence::create([
                 'english' => trim($result_en[$key]),
                 'chinese' =>trim($result_zh[$key]),
                 'quote' =>trim($result_from[$key]),
               //  'level_star'=>$level_star
           //      'version' => $crawl_version,
             ]);
             $sentence->words()->attach($word->id);
           }



         }else{
           if( $sentence){
             if($sentence->words()->where("words.id",$word->id)->count()==false){
               $sentence->words()->attach($word->id);
             }
           }

         //  $word = Word::where('word', $query_word)->get();
          continue;
         }


       }

    }
  }

    public function search(Request $request)
    {
      # code...
      $query_word=$request->input('query');

      $query_word = trim($query_word);
      $query_word = strtolower($query_word);
      $word_obj = Word::where('word', $query_word)->first();  //单词

      if($word_obj !=false){

        return redirect()->route('query', $query_word);
      }else{

        $projectId = 'speech@html5-gae.iam.gserviceaccount.com';

        # Instantiates a client
        $translate = new TranslateClient([
          'projectId' => $projectId
        ]);

        # The text to translate
        $text = $query_word;
        # The target language
        $target = 'zh-CN';

        # Translates some text into Russian
        $translation = $translate->translate($text, [
          'target' => $target
        ]);

        echo 'Text: ' . $text . '
        Translation: ' . $translation['text'];
        # [END translate_quickstart]

      }
    }

    public function index(){
      //$word = Word::where("version",'iciba02')->paginate(20);
      $word = Word::paginate(20);
      $curentpage = $word->currentPage();
      $nextpageurl = $word->nextPageUrl();
      $itemes = $word->items();
      //$WordSpeech =New WordSpeech;



      //return redirect('login');
      //die();
      return view('word.index', compact('word','nextpageurl'));


    }

    public function baiduspeech(){
      $fileName = public_path(). '/voice/juzi/wechat01.amr';

      //const APP_ID = '10540641';
      $APP_ID=env('APP_ID') ;
      $API_KEY=env('API_KEY') ;
      $SECRET_KEY=env('SECRET_KEY');

    //  const API_KEY = 'QsfgtEHUUrujYOGrSin8UQgy';
      //const SECRET_KEY = 'bKyrt5qEUUlZvlTt0fch8pDFarTC5ZDt ';

      $client = new AipSpeech($APP_ID , $API_KEY, $SECRET_KEY);

        $test = $client->asr(file_get_contents($fileName), 'amr', 8000, array(
          'lan' => 'en',
      ));


      echo $test['result'][0];
    }

    public function googlespeech(){

      $projectId = 'speech-test@erudite-imprint-186800.iam.gserviceaccount.com';

      # Instantiates a client
      $speech = new SpeechClient([
          'projectId' => $projectId,
          'languageCode' => 'en-US',
      ]);



      # The name of the audio file to transcribe
      $fileName = public_path(). '/voice/juzi/wechat01.amr';

      # The audio file's encoding and sample rate
      $options = [
          'encoding' => 'AMR',
          'sampleRateHertz' => 8000,
      ];
      /*

      # Detects speech in the audio file
      $results = $speech->recognize(fopen($fileName, 'r'), $options);
      $tmp ="";
      foreach ($results as $result) {
          $tmp .= 'google: ' . $result->alternatives()[0]['transcript'] ;
      }
      echo $tmp ;
      */
      $stturl = "https://speech.googleapis.com/v1beta1/speech:syncrecognize?key=AIzaSyAYmeL4hqlvmx0Q7IB-cLuQUlD2Q5Bskvk";
  $upload = file_get_contents($fileName);
  $upload = base64_encode($upload);

  $data = array(
      "config"    =>  array(
          'encoding' => 'AMR',
          'sampleRate' => 8000,
      ),
      "audio"     =>  array(
          "content"       =>  $upload,
      )
  );

  $data_string = json_encode($data);

  $ch = curl_init($stturl);
  curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
  curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($ch, CURLOPT_HTTPHEADER, array(
     'Content-Type: application/json',
     'Content-Length: ' . strlen($data_string))
  );

  $result = curl_exec($ch);
  $result_array = json_decode($result, true);

echo $result_array['results'][0]['alternatives'][0]['transcript'];

    //  echo "test15555555555";

    }

    public function query($word)
    {
      # code...
      $query_word = trim($word);
      $query_word = strtolower($query_word);
      $sentences =array();
      $seo_meta =array();
     //$query_word = $words;
    //  PaChongController::crawl($word);

       $word_obj = Word::where('word', $query_word)->with('level','tip','word_image','explain')->first();  //单词

if($word_obj ==false){
  $this->crawl($query_word,"jukuu05");
$word_obj = Word::where('word', $query_word)->first();
}

$seo_meta['title'] = $word_obj->word."词根词缀, 查看".$word_obj->word."中文翻译 例句 发音 音标 词根 词缀! 记词吧在线免费词典！";
$seo_meta['description'] ="";

foreach($word_obj->voice as $voice){
  $seo_meta['description'] .=$word_obj->word.": ".$voice->symbol." ";;
}

//$this->crawl($query_word);
/*
      $voices =  WordVoice::where('word_id', $word_obj->id)->get();  //单词

      $voice_array = array();
      $tmp_array =array();
      foreach ($voices as $voice) {
        $tmp_array['symbol'] = $voice->symbol;
        $url = '/uploads/voice/word/'.str_replace('voice/word/',"",$voice->path);

        $tmp_array['path'] = $url;
        $voice_array[]=$tmp_array;

    }
*/

      $word_explains =$word_obj->explain;  //单词

      $explain_array = array();
      $tmp_array =array();
      foreach ($word_explains as $word_explain) {
        //$explain_array[WordSpeech::find($word_explain->word_speech_id)->cixing][] = $word_explain->explain;

        if($word_explain->speech->cixing){
          $explain_array[$word_explain->speech->cixing][] = $word_explain->explain;
          $seo_meta['description'] .=$word_explain->speech->cixing." ".$word_explain->explain;
        }else{
          $explain_array[][] = $word_explain['explain'];
        }

        //dd($liju);
      //  echo WordSpeech::find(10)->first()->cixing."<br/>";
        //echo $word_explain->word_speech_id."<br/>";

    }


    $sentences =$word_obj->sentences()->orderBy('updated_at','DESC')->take(10)->get();


    //var_dump($explain_array);
    //$wordimages = $word_obj->word_image;
//die("test");

      return view('word.query', compact('word_obj','explain_array','sentences','seo_meta'));

    }

    public function star($star){
      $seo_meta =array();
      $query_word = "star".$star;

      /*
      $has_star =Word::where('level_star', $query_word)->count();
      if($has_star==false){
        return redirect()->route('home');
      }
      return view('word.starapi', compact('star'));
      */

      $has_star =Word::where('level_star', $query_word)->count();



      if($has_star==false){
        return redirect()->route('home');
      }else{

        $words = Word::where('level_star', $query_word)->paginate(15);
        $seo_meta['title'] =$star."星词频";
        if($words->currentPage()>1){
          $seo_meta['title'].=" - 第".$words->currentPage()."页";
        }

      }
      $seo_meta['description'] = $seo_meta['title'];
      return view('word.star', compact('words','seo_meta'));
    }

    public function list(LevelBase $level_bases){
    $seo_meta =array();

    $words = $level_bases->word()->paginate(15);
    $seo_meta['title'] =str_replace('/','',$level_bases->level_bases)."词汇";
    if($words->currentPage()>1){
      $seo_meta['title'].=" - 第".$words->currentPage()."页";
    }

    $seo_meta['description'] = $seo_meta['title'];

    return view('word.wordslist', compact('words','seo_meta'));


    }

    public function queryapi(Request $request)
    {
      # code...
      $word = $request->word;
      $query_word = trim($word);
      $query_word = strtolower($query_word);
     //$query_word = $words;
    //  PaChongController::crawl($word);

       $word_obj = Word::where('word', $query_word)->first();  //单词

if($word_obj ==false){
  $this->crawl($query_word);
$word_obj = Word::where('word', $query_word)->first();
}

      $voices =  WordVoice::where('word_id', $word_obj->id)->get();  //单词

      $voice_array = array();
      $tmp_array =array();
      foreach ($voices as $voice) {
        $tmp_array['symbol'] = $voice->symbol;
        $url = '/uploads/voice/word/'.str_replace('voice/word/',"",$voice->path);

        $tmp_array['path'] = $url;
        $voice_array[]=$tmp_array;

    }

      $word_explains = WordExplain::where('word_id', $word_obj->id)->get();  //单词

      $explain_array = array();
      $tmp_array =array();
      foreach ($word_explains as $word_explain) {
        //$explain_array[WordSpeech::find($word_explain->word_speech_id)->cixing][] = $word_explain->explain;

        if(WordSpeech::find($word_explain['word_speech_id'])){
          $explain_array[WordSpeech::find($word_explain->word_speech_id)->cixing][] = $word_explain->explain;
        }else{
          $explain_array[][] = $word_explain['explain'];
        }


      //  echo WordSpeech::find(10)->first()->cixing."<br/>";
        //echo $word_explain->word_speech_id."<br/>";

    }
//单词 Tips
$wordtips ="";
$wordtips =WordTip::where('word_id', $word_obj->id)->orderBy('praise')->get();


    // 单词词根....
    $word_cixing_roots = $word_obj->rootcixing_word()->get();

    foreach ($word_cixing_roots as $cixing_roots) {
      //$explain_array[WordSpeech::find($word_explain->word_speech_id)->cixing][] = $word_explain->explain;

$root_cixing_array[Rootcixing::find($cixing_roots->rootcixing_id)->root_id]['cixing_alias']= $cixing_roots->root_alias;
$root_cixing_array[Rootcixing::find($cixing_roots->rootcixing_id)->root_id]['cixing_name']= WordSpeech::find(Rootcixing::find($cixing_roots->rootcixing_id)->word_speech_id)->cixing;
      $root_cixing_array[Rootcixing::find($cixing_roots->rootcixing_id)->root_id]['cixing']= Rootcixing::find($cixing_roots->rootcixing_id);
      $root_cixing_array[Rootcixing::find($cixing_roots->rootcixing_id)->root_id]['root']=Root::find(Rootcixing::find($cixing_roots->rootcixing_id)->root_id);



    //  echo WordSpeech::find(10)->first()->cixing."<br/>";
      //echo $word_explain->word_speech_id."<br/>";

  }



    return response()->success(compact('word_obj','explain_array','voice_array','root_cixing_array','wordtips'));
      //return view('word.query', compact('word_obj','explain_array','voice_array'));

    }
}
