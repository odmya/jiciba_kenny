<?php

namespace App\Http\Controllers\Api;

use App\Models\Course;
use App\Models\ChapterEntry;
use App\Models\Chapter;
use Illuminate\Http\Request;
use App\Transformers\CourseTransformer;
use App\Transformers\ChapterListTransformer;
use App\Transformers\ChapterEntryTransformer;
use App\Transformers\MachineVoiceTransformer;
use Storage;
use AipSpeech;

class CourseController extends Controller
{
    //

    public function show($course)
    {
      $course = Course::where('id',$course)->first();

      //  return $this->response->item($root_obj->rootcixing()->get(), new RootCiXingTransformer())->setStatusCode(201);
      return $this->response->item($course, new ChapterListTransformer())
          ->setStatusCode(201);

    }


    public function list(){
      $courses = Course::where('is_enable',1)->Recent()->paginate(10);

      return $this->response->paginator($courses, new CourseTransformer());
    }

    public function chaptershow($chapter){
      $chapters = Chapter::find($chapter);

      return $this->response->item($chapters, new ChapterEntryTransformer());
    }

    //chaptershow 获取复读机器发音
    public function machinevoice($chapter){
    //  dd($chapter);
      $machinevoices = ChapterEntry::where('chapter_id',$chapter)->where('enable_read',1)->get();
      return $this->response->item($machinevoices, new MachineVoiceTransformer())->setStatusCode(201);

      //return $this->response->item($chapters, new ChapterEntryTransformer());
    }



      //上传MP3文件到服务器中
    public function uploadwechat(Request $request){
      $filevoice = $request->file('jciba');
      $enkeywords =$request->query('enkeywords');

      $keywords =explode(" ",$enkeywords);
      $requestString="keywords:[".implode(',',$keywords)."]";
      //$requestString = "keywords:['this','is','our','new','classroom']";


      if ($filevoice->isValid()) {

                // 获取文件相关信息
                $originalName = $filevoice->getClientOriginalName(); // 文件原名
                $ext = $filevoice->getClientOriginalExtension();     // 扩展名
                $realPath = $filevoice->getRealPath();   //临时文件的绝对路径
                $type = $filevoice->getClientMimeType();     // image/jpeg

                // 上传文件
                $filename = date('Y-m-d-H-i-s') . '-' . uniqid() . '.' . $ext;
                $filename_wav = date('Y-m-d-H-i-s') . '-' . uniqid() . '.wav' ;
                $filename_pcm = date('Y-m-d-H-i-s') . '-' . uniqid() . '.pcm' ;
                // 使用我们新建的uploads本地存储空间（目录）
                $bool = Storage::disk('minivoice_uploads')->put($filename, file_get_contents($realPath));



                $source_path = public_path(). '/uploads/voice/minivoice/'.$filename;
                $final_wav_path = public_path(). '/uploads/voice/minivoice/'.$filename_wav;
                $final_pcm_path = public_path(). '/uploads/voice/minivoice/'.$filename_pcm;


//阿里云语音识别实时一句话调用C++
$command = "ffmpeg -i ".$source_path." -f s16be -ar 16000 -ac 1 -acodec pcm_s16be ".$filename_pcm;

exec("ffmpeg -y -i ".$source_path." -acodec pcm_s16le -f s16le -ac 1 -ar 16000 ".$final_pcm_path,$output,$return_var);

exec("/var/www/testvoice/demo/jciba ".$final_pcm_path, $outputarray);

//$tmp_str1 =str_replace(array(" ",".","!","?","'",","),"",strtolower($outputarray[0]));

//$tmp_str2 = str_replace(array(" ",".","!","?","'",","),"",strtolower($enkeywords));

//similar_text(trim($tmp_str1), trim($tmp_str2), $percent);
if(isset($outputarray)){
  return "根据欧美英语标准识别出的文字内容: ".$outputarray[0];
}else{
  return "刚刚出小差了，请您再试一次";
}


//return $outputarray[0];
die();
//阿里云语音识别

                $command = "ffmpeg -i ".$source_path." -f s16be -ar 16000 -ac 1 -acodec pcm_s16be ".$filename_pcm;

                exec("ffmpeg -y -i ".$source_path." -acodec pcm_s16le -f s16le -ac 1 -ar 16000 ".$final_pcm_path,$output,$return_var);

                $audio = $final_pcm_path;
                $accessSecret = env('ACCESS_KEY_SECRET');
                $accessKey = env('ACCESSKEY_ID');

                $date = gmdate("D, d M Y H:i:s \G\M\T");
                $contentType = 'audio/pcm;samplerate=16000';
                $accept = 'application/json';
                $method = 'POST';

                $headers = array( 'Content-type:'.$contentType, 'Accept:'.$accept, 'Content-Length:'.filesize($audio), 'Date:'.$date, 'method:'.$method );

                $body = file_get_contents($audio);
                $md5 = base64_encode(md5($body,true));
                $md52 = base64_encode(md5($md5,true));
                $stringToSign = $method. "\n" . $accept . "\n" . $md52 . "\n" . $contentType . "\n" . $date;
                $sign = base64_encode(hash_hmac('sha1',$stringToSign,$accessSecret,true));
                $headers[] = 'Authorization:Dataplus '.$accessKey.':'.$sign;
                $ch = curl_init('https://nlsapi.aliyun.com/recognize?model=english&version=2.0');
                curl_setopt($ch, CURLOPT_TIMEOUT, 60); //设置超时
                curl_setopt($ch, CURLOPT_POST, TRUE);
                curl_setopt($ch, CURLOPT_POSTFIELDS, $body);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
                curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
                $res = curl_exec($ch);
                curl_close($ch);
                //var_dump($res);

                $tmp_result = json_decode($res);
                return $tmp_result->result;

die();

////阿里云语音识别结束

                //baidu 语音识别

                //$command ='sox '.$source_path.' '.$final_wav_path;

                //exec('sox '.$source_path.' '.$final_wav_path);
                $command = "ffmpeg -i ".$source_path." -f s16be -ar 16000 -ac 1 -acodec pcm_s16be ".$filename_pcm;

                exec("ffmpeg -y -i ".$source_path." -acodec pcm_s16le -f s16le -ac 1 -ar 16000 ".$final_pcm_path,$output,$return_var);

                $APP_ID=env('APP_ID') ;
                $API_KEY=env('API_KEY') ;
                $SECRET_KEY=env('SECRET_KEY');

                $client = new AipSpeech($APP_ID , $API_KEY, $SECRET_KEY);
                //  echo $final_pcm_path;
                  $test = $client->asr(file_get_contents($final_pcm_path), 'pcm', 16000, array(
                    'dev_pid' => 1737,
                ));


                //$tmp_str1 =str_replace(array(" ",".","!","?","'",","),"",strtolower($test['result'][0]));

                //$tmp_str2 = str_replace(array(" ",".","!","?","'",","),"",strtolower($enkeywords));

                //similar_text(trim($tmp_str1), trim($tmp_str2), $percent);
                $outputtmp="";

                if(isset($test['result'])){
                  foreach($test['result'] as $output){
                    $outputtmp.=$output;
                  }
                  return $outputtmp;

                }else{
                  return "刚刚出小差了，请您再试一次";
                }




//IBM语音识别
                $user_name = env('WATSON_USERNAME');
                $user_password = env('WATSON_PASSWORD');
                /*
                        $ch = curl_init();

                         curl_setopt($ch, CURLOPT_URL, "https://stream.watsonplatform.net/speech-to-text/api/v1/recognize");
                         curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                         $data = file_get_contents($source_path);
                         curl_setopt($ch,CURLOPT_HTTPHEADER, ['Content-Type: audio/mp3']);
                         curl_setopt($ch,CURLOPT_BINARYTRANSFER,TRUE);
                         curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
                         curl_setopt($con, CURLOPT_POSTFIELDS, $requestString);
                         curl_setopt($ch, CURLOPT_POST, 1);
                         curl_setopt($ch, CURLOPT_USERPWD, $user_name.":".$user_password);
                        //$headers = array();
                         $headers[] = "keywords: audio/mp3";
                         curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

                         $result = curl_exec($ch);
                        if (curl_errno($ch)) {
                                           echo 'Error:' . curl_error($ch);
                                           }
                        curl_close ($ch);
                        */

                      //  $url = 'https://stream.watsonplatform.net/speech-to-text/api/v1/recognize?keywords_threshold=0.1&keywords='.$requestString;
                        $url = 'https://stream.watsonplatform.net/speech-to-text/api/v1/recognize';
                        $file = fopen($source_path, 'r');
                        $size = filesize($source_path);
                        $fildata = fread($file,$size);

                        $headers = array(    "Content-Type: audio/mp3",
                                             "Transfer-Encoding: chunked");

                        $ch = curl_init();
                        curl_setopt($ch, CURLOPT_URL, $url);
                        curl_setopt($ch, CURLOPT_USERPWD, "$user_name:$user_password");
                        curl_setopt($ch, CURLOPT_POST, TRUE);
                        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
                        curl_setopt($ch, CURLOPT_BINARYTRANSFER, TRUE);
                        curl_setopt($ch, CURLOPT_POSTFIELDS, $fildata);
                        //curl_setopt($ch, CURLOPT_POSTFIELDS, $requestString);
                        curl_setopt($ch, CURLOPT_INFILE, $file);
                        curl_setopt($ch, CURLOPT_INFILESIZE, $size);
                        curl_setopt($ch, CURLOPT_VERBOSE, true);
                        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
                        $result = curl_exec($ch);
                        fclose($file);

          $output_content = "";
          $tmp_result = json_decode($result);
          foreach($tmp_result->results as $output){
            $output_content .=$output->alternatives[0]->transcript;
          }

          return $output_content;

               //return $filename;

    }


      //return $this->response->item($chapters, new ChapterEntryTransformer());
    }



//语音识别

    public function apispeech(Request $request){

      $tmpurl = $request->query('tmpurl');
      $file_name= str_replace('.mp3','',$tmpurl);

      //$page_content = file_get_contents($tmpurl);
      $save_path = public_path(). '/uploads/voice/minivoice/'.md5($file_name).".wav";
      $source_path = public_path(). '/uploads/voice/minivoice/'.$tmpurl;
      $user_name = env('WATSON_USERNAME');
      $user_password = env('WATSON_PASSWORD');

              $ch = curl_init();

               curl_setopt($ch, CURLOPT_URL, "https://stream.watsonplatform.net/speech-to-text/api/v1/recognize");
               curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
               $data = file_get_contents($source_path);
               curl_setopt($ch,CURLOPT_HTTPHEADER, ['Content-Type: audio/mp3']);
               curl_setopt($ch,CURLOPT_BINARYTRANSFER,TRUE);
               curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
               curl_setopt($ch, CURLOPT_POST, 1);
               curl_setopt($ch, CURLOPT_USERPWD, $user_name.":".$user_password);
                $headers = array();
               $headers[] = "Content-Type: audio/mp3";
               curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

               $result = curl_exec($ch);
              if (curl_errno($ch)) {
                                 echo 'Error:' . curl_error($ch);
                                 }
              curl_close ($ch);

$tmp_result = json_decode($result);
return $tmp_result->results[0]->alternatives[0]->transcript;
dd();
    //  file_put_contents($save_path,$page_content);




      //$english_txt = $request->query('english_txt');
    //  $stream = $app->media->get($Media_Id); //这里好像不行

      //$save_path = public_path(). '/tmp/';
    //  $stream->save($save_path,md5($Media_Id).".amr");

    //  $fileName = public_path(). '/tmp/'.md5($Media_Id).".amr";

    //  $userfilename = public_path(). '/voice/uservoice/'.md5($Media_Id).".mp3";
//dd('sox '.$source_path.' '.$save_path);
      //exec('sox '.$source_path.' '.$save_path);
    //  $command ='sox '.$fileName.' '.$userfilename;


      $APP_ID=env('APP_ID') ;
      $API_KEY=env('API_KEY') ;
      $SECRET_KEY=env('SECRET_KEY');

      $client = new AipSpeech($APP_ID , $API_KEY, $SECRET_KEY);

        $test = $client->asr(file_get_contents($source_path), 'wav', 16000, array(
          'dev_pid' => 1737,
      ));

      dd($test);
      $tmp_str1 =str_replace(array(" ",".","!","?","'",","),"",strtolower($test['result'][0]));

      $tmp_str2 = str_replace(array(" ",".","!","?","'",","),"",strtolower($english_txt));

      similar_text(trim($tmp_str1), trim($tmp_str2), $percent);

      return $test['result'][0]."本次发音得分: (".round($percent)."分)";


    }




}
