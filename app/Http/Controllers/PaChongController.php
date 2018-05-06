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
use App\Models\WordImage;
use App\Models\WordTip;
use App\Models\Sentence;
use App\Jobs\crawl;
use Storage;
set_time_limit(0);
class PaChongController extends Controller
{
    //
    public function crawl($words="test",$version="iciba03"){
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

       sleep(2);//睡眠
}



    }
    public function crawl2($words="test",$version="iciba02"){

     $query_word = trim($words);
     $query_word = strtolower($query_word);
     $query_word = str_replace("'s","",$query_word);
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
      if($fayingpath!="sound('')"){
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
                $word->word_voice()->create(['word_id' => $word->id,'symbol' => $value, 'path'=>$query_word."_".$key.".mp3"]);
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
              $word->word_voice()->create(['word_id' => $word->id,'symbol' => $yinbiao, 'path'=>$query_word.".mp3"]);
            }

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
      return true;
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

    public function crawl_dicts($words="test",$version="dicts"){

      //$words = "explore";
     $query_word = trim($words);
     $query_word = strtolower($query_word);
    //$query_word = $words;
      $crawl_version = $version;




      $word = Word::where('word', $query_word)->first();
    //  $words = new Word;
    //  $word = $words->where('word', $query_word)->first();

    //  echo $query_word;

      if($word==false){

      //

        return;

      }else{
      //  $word = Word::where('word', $query_word)->get();
      }





      $url = "http://www.dicts.cn/dict/dict/dict!searchhtml3.asp?id=".$query_word;
    //  $tmp_url = curl_get_file_contents($url);

dd($url);
    //  $url_page = "http://sample.app/test.php";
$proxy = "209.88.95.2186:80";    //此处为代理服务器IP和PORT

$tmp_url = curl_string($url);



    //  dd($tmp_url);
      if(  $tmp_url ){
        $tmp_url = trim($tmp_url);

        $crawl_url ="http://www.dicts.cn".$tmp_url;
      }else{
        $word->version = $version;

        $word->save();
        return;
      }


    //  dd($crawl_url);

      $html = requests::get($crawl_url);

      // 抽取图片

      $selector = "//*[@id='cigencizui']/script[1]/text()";
      // 提取结果
      $result = selector::select($html, $selector);
      $matches =array();
      $regex1 = strpos($result,"var img_prefix = new Array");

      $regex2 = strpos($result,"var img_num");

      $tmp_images = substr($result,$regex1,$regex2 -$regex1 );
      $tmp_images = str_replace("var img_prefix = new Array(","",$tmp_images);
      $tmp_images = str_replace('"',"",$tmp_images);
      $tmp_images = str_replace("'","",$tmp_images);
      $tmp_images = str_replace(");","",$tmp_images);
      //echo $tmp_images;
      $tmp_images = explode(",",$tmp_images);
      $tmp_images = array_map('trim', $tmp_images);

      if(is_array($tmp_images)&&count($tmp_images)){

          foreach ($tmp_images as $key => $image) {

            $ext = pathinfo($image,PATHINFO_EXTENSION);
          //  echo $image;
          //echo $image;
          //dd($word->word);
          $tmp_filename = $word->word."_".$word->id."_".$key.".".$ext;
          $tmp_image = WordImage::where("image",$tmp_filename)->first();

          if($tmp_image==false){

              if($image==false)
                continue;

            Storage::disk('word_images')->put($tmp_filename, file_get_contents($image));

            $word_images = WordImage::create([
                'image' => $tmp_filename,
                'word_id' => $word->id
              //  'level_star'=>$level_star
          //      'version' => $crawl_version,
            ]);


          }else{
            continue;
          //  $word = Word::where('word', $query_word)->get();
          }

          //echo $filename;
          }

      }

      // 提取词条
      $selector = "//*[@id='cigencizui-content']/div[@style='font-family:SimSun,serif;']/text()";
        $result = selector::select($html, $selector);
if($result ==false||is_array($result)==false){

  $word->version = $version;

$word->save();
return;
}

    foreach ($result as $key => $tip) {
        if($tip ==false)
        continue;
      $tip =str_replace(array("1.","2.","3.","4.","5.","6.","7.","8.","9.","10.","12.","13.","14.","15.","16.","16."),"",$tip);
      $tip =trim($tip);
      $tmp_tip = WordTip::where("word_id",$word->id)->where("tip",$tip)->first();
      if($tmp_tip==false){

        $word_tip = WordTip::create([
            'tip' => $tip,
            'word_id' => $word->id
          //  'level_star'=>$level_star
      //      'version' => $crawl_version,
        ]);


      }else{

        continue;
      }


  $word->version = $version;

$word->save();
  # code...
}
      //die();

      //$bool = Storage::disk('word_images')->put($filename, file_get_contents($realPath));

      //$tmp_regex = preg_match( $regex, $result, $matches);
      //$result =str_replace("'","",$result);
      //var_dump($tmp_images);
//



    }
    public function cibadb(){
      $word_list = file_get_contents("words2.txt");

      $word_list=array_unique(explode(",",preg_replace("/\n+/",",",$word_list)));

      foreach ($word_list as $key => $value) {
        # code...
        $word = Word::where('word', $value)->first();
        if($word==false){
          $value = trim($value);
          $query_word = strtolower($value);
          $word = Word::create([
              'word' => $value,
            //  'level_star'=>$level_star
        //      'version' => $crawl_version,
          ]);

        }

      }

    }
    public function list(){

      $word = Word::where('version',"!=",'jukuu05')->paginate(20);
      $curentpage = $word->currentPage();
      $nextpageurl = $word->nextPageUrl();
      $itemes = $word->items();

      foreach ($itemes as $key => $perwords) {
        # code...
      //  echo $perwords->word;

      $tmp = 0;
        $this->crawl($perwords->word,'jukuu05');
//die("test");
        sleep(2);//睡眠

      }
      //return redirect('login');
      //die();
      return view('word.list', compact('word','nextpageurl'));

    }
    public function ciba(){

      $configs = array(
    'name' => '爱词霸',
    'domains' => array(
        'iciba.com',
        'www.iciba.com'
    ),
    'scan_urls' => array(
        'http://www.iciba.com/'
    ),
    'content_url_regexes' => array(
        "http://www.iciba.com/[A-Za-z]+"
    ),

    'fields' => array(
        array(
            // 抽取内容页的文章内容
            'name' => "article_content",
            'selector' => "//*[@id='single-next-link']",
            'required' => true
        ),
        array(
            // 抽取内容页的文章作者
            'name' => "article_author",
            'selector' => "//div[contains(@class,'author')]//h2",
            'required' => true
        ),
    ),
);

$word_list = file_get_contents("words.txt");

$word_list=array_unique(explode(",",preg_replace("/\n+/",",",$word_list)));

foreach ($word_list as $key => $value) {
  # code...
  $this->crawl($value);
  sleep(50);//睡眠

  //dispatch(new crawl($value));
  //echo $value."<br/>";
//  sleep(60);
}


    }
}



function curl_string ($url){

$proxy_list = array("47.104.155.76:1080","101.132.152.144:80","47.74.134.234:80","47.88.175.178:1080","120.26.51.101:8118","47.89.249.110:8118","47.94.107.71:8080","47.52.24.132:8118","139.196.17.196:8118","47.88.156.143:8118","47.94.230.42:9999","120.76.77.152:9999","47.88.32.46:3128","47.89.41.164:80","59.110.221.78:80","182.92.242.11:80","119.23.63.152:8118","47.90.2.253:8118","47.89.249.110:80","106.14.209.135:80","114.215.174.227:8080","47.89.241.103:8080","47.52.142.42:8118","47.52.62.110:8080","120.79.162.100:1080","39.108.171.142:80","121.196.226.246:84","118.178.227.171:80","115.29.170.58:8118","47.52.41.254:8118","120.76.79.21:80","39.106.97.102:8080","101.132.146.103:8080","120.25.253.234:8118","120.27.220.218:80","120.55.61.182:80","121.41.175.199:80","114.215.102.168:8081","39.106.19.230:3389","120.27.49.85:8090","47.90.87.225:88","101.201.79.172:808","120.77.201.46:8080","106.14.51.145:8118","47.52.231.140:8080","47.52.29.64:80","120.25.164.134:8118","47.96.250.208:3128","47.52.61.212:8080","101.200.89.170:8888","101.132.148.7:8080","47.88.20.189:80","115.28.229.65:80","47.93.3.242:80","47.52.98.198:8118","47.90.62.177:8080","120.27.10.38:8090","47.88.156.143:80","47.52.3.230:443","106.14.12.240:8082","120.27.195.59:9999","47.52.112.218:3128","47.88.226.56:80","47.52.58.163:80","121.40.108.76:80","47.52.41.254:80","121.40.164.232:8118","106.14.165.136:8118","47.90.62.177:8080","47.52.61.212:8080","47.52.231.140:8080","47.90.87.225:88","150.95.190.102:80","45.32.52.17:3128","118.193.107.174:80","118.193.107.190:80","118.193.107.99:80","106.39.179.248:80","118.193.107.36:80","118.193.107.207:80","118.193.107.37:80");
  //$proxy ="118.193.107.207:80";
$ch = curl_init();
$headers = randIp();
$useragent = array(
            'Mozilla/4.0 (compatible; MSIE 8.0; Windows NT 6.0)',
            'Mozilla/4.0 (compatible; MSIE 7.0; Windows NT 5.2)',
            'Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1)',
            'Mozilla/5.0 (Windows; U; Windows NT 5.2) Gecko/2008070208 Firefox/3.0.1',
            'Opera/9.27 (Windows NT 5.2; U; zh-cn)',
            'Opera/8.0 (Macintosh; PPC Mac OS X; U; en)',
            'Mozilla/5.0 (Windows; U; Windows NT 5.2) AppleWebKit/525.13 (KHTML, like Gecko) Chrome/0.2.149.27 Safari/525.13 ',
            'Mozilla/5.0 (Windows; U; Windows NT 5.2) AppleWebKit/525.13 (KHTML, like Gecko) Version/3.1 Safari/525.13'

        );
//curl_setopt ($ch, CURLOPT_PROXY, $proxy);
$proxy =array_rand($proxy_list);

$proxy = $proxy_list[$proxy];

curl_setopt ($ch, CURLOPT_PROXY, $proxy);
curl_setopt ($ch, CURLOPT_URL, $url);
curl_setopt ($ch, CURLOPT_USERAGENT, "Mozilla/4.0");
//curl_setopt ($ch, CURLOPT_COOKIEJAR, "d:\cookies.txt");
curl_setopt ($ch, CURLOPT_HEADER, 0);
curl_setopt ($ch, CURLOPT_HTTPHEADER, $headers);  //此处可以改为任意假IP
curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt ($ch, CURLOPT_FOLLOWLOCATION, 1);
curl_setopt ($ch, CURLOPT_TIMEOUT, 120);

$result = curl_exec ($ch);
curl_close($ch);
return $result;
}


function curl_get_file_contents($URL)
{
  $URL = "http://sample.app/test.php";
$curl = curl_init();
$headers = randIp();

$r = rand(80,255);
$useragent = array(
            'Mozilla/4.0 (compatible; MSIE 8.0; Windows NT 6.0)',
            'Mozilla/4.0 (compatible; MSIE 7.0; Windows NT 5.2)',
            'Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1)',
            'Mozilla/5.0 (Windows; U; Windows NT 5.2) Gecko/2008070208 Firefox/3.0.1',
            'Opera/9.27 (Windows NT 5.2; U; zh-cn)',
            'Opera/8.0 (Macintosh; PPC Mac OS X; U; en)',
            'Mozilla/5.0 (Windows; U; Windows NT 5.2) AppleWebKit/525.13 (KHTML, like Gecko) Chrome/0.2.149.27 Safari/525.13 ',
            'Mozilla/5.0 (Windows; U; Windows NT 5.2) AppleWebKit/525.13 (KHTML, like Gecko) Version/3.1 Safari/525.13'

        );


      //  curl_setopt($curl, CURLOPT_REFERER, "http://www.baidu.com");   //构造来路
        //curl_setopt($curl, CURLOPT_USERAGENT, array_rand($useragent));
$proxy = "120.198.224.104:8080";
$proxy = explode(':', $proxy);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
//curl_setopt($curl, CURLOPT_POST, 1);
//curl_setopt($curl, CURLOPT_PROXY, $proxy[0]);
//curl_setopt($curl, CURLOPT_PROXYPORT, $proxy[1]);

curl_setopt($curl, CURLOPT_HEADER, 1);//输出远程服务器的header信息
curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);  //构造IP
//curl_setopt($curl, CURLOPT_USERAGENT, 'Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1; SV1; .NET CLR 2.0.50727;http://www.baidu.com)');
  curl_setopt($curl, CURLOPT_USERAGENT, array_rand($useragent));

//  curl_setopt($curl, CURLOPT_NOBODY, true);

  curl_setopt($curl, CURLOPT_REFERER, "http://www.baidu.com");

curl_setopt($curl, CURLOPT_URL, $URL);


$contents = curl_exec($curl);
$info = curl_getinfo($curl);

curl_close($curl);
dd($contents);
if ($contents) {return $contents;}
else {return FALSE;}
}


function randIP(){
       $ip_long = array(
           array('607649792', '608174079'), //36.56.0.0-36.63.255.255
           array('1038614528', '1039007743'), //61.232.0.0-61.237.255.255
           array('1783627776', '1784676351'), //106.80.0.0-106.95.255.255
           array('2035023872', '2035154943'), //121.76.0.0-121.77.255.255
           array('2078801920', '2079064063'), //123.232.0.0-123.235.255.255
           array('-1950089216', '-1948778497'), //139.196.0.0-139.215.255.255
           array('-1425539072', '-1425014785'), //171.8.0.0-171.15.255.255
           array('-1236271104', '-1235419137'), //182.80.0.0-182.92.255.255
           array('-770113536', '-768606209'), //210.25.0.0-210.47.255.255
           array('-569376768', '-564133889'), //222.16.0.0-222.95.255.255
       );
       $rand_key = mt_rand(0, 9);
       $ip= long2ip(mt_rand($ip_long[$rand_key][0], $ip_long[$rand_key][1]));
       $headers['CLIENT-IP'] = $ip;
       $headers['X-FORWARDED-FOR'] = $ip;

       $headerArr = array();
       foreach( $headers as $n => $v ) {
           $headerArr[] = $n .':' . $v;
       }
       return $headerArr;
   }
