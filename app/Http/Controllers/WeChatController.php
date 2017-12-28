<?php

namespace App\Http\Controllers;

use Log;
use EasyWeChat\Kernel\Messages\Voice;
use Google\Cloud\Translate\TranslateClient;
use Google\Cloud\Speech\SpeechClient;
use Illuminate\Http\Request;
use AipSpeech;

use App\Models\Course;
use App\Models\Section;
use App\Models\Chapter;
use App\Models\Phrase;
use App\Models\PhraseSection;
use App\Models\User;
use App\Models\Record;
use App\Models\Userrecord;

use Redirect;
use Auth;
use Storage;


putenv('GOOGLE_APPLICATION_CREDENTIALS='.public_path().'/google-95003-2d37e7203dfa2017-11-12.json');

class WeChatController extends Controller
{



//  这个是微信小程序验证
    public function weixinmini(Request $request){
      $signature = $request->query('signature');
      $timestamp = $request->query('timestamp');
      $echostr = $request->query('echostr');
      $nonce = $request->query('nonce');
      $token = 'jlkjdf123';
      $tmpArr = array($token, $timestamp, $nonce);
      sort($tmpArr, SORT_STRING);
      $tmpStr = implode( $tmpArr );
      $tmpStr = sha1( $tmpStr );
      if( $tmpStr == $signature ){
        echo  $echostr;
      }else{
        echo  false;
      }
    }


// web outh 微信登录验证后保存数据到本地服务器数据库中
    public function wechatoauth(){


      $user = session('wechat.oauth_user');

$openid =  $user->id;
$email = $user->email;
if($email==false){
  $email = $openid."@jciba.cn";
}

$nickname = $user->nickname;
$name = $user->name;
$avatar = $user->avatar;

$password = 'jciba20171221!@';

      if(User::where('openid',$openid)->count()){


        if ( Auth::attempt(['openid' => $openid,'password' => $password]) ){
          $user_info = User::where('openid',$openid)->first();

          if($user_info->nickname != $nickname){
            $user_info->nickname = $nickname;
            $user_info->save();
          }

          if($user_info->name != $name){
            $user_info->name = $name;
            $user_info->save();
          }

          if($user_info->avatar != $avatar){
            $user_info->avatar = $avatar;
            $user_info->save();
          }
          session(['wechatuser' => $openid]);

          return redirect(route('wechatcourse'));
          //$oauth->redirect()->send();
        }
      }else{
        $data =[
            'name' => $name,
            'email' => $email,
            'nickname' => $nickname,
            'openid' => $openid,
            'avatar' => $avatar,

            'password' => bcrypt('jciba20171221!@'),
        ];

        //dd($data);
        User::create($data);
        session(['wechatuser' => $openid]);

//die("test2");
        return redirect(route('wechatcourse'));
      }


    }


// 显示所有课程

    public function course(){
      $courses = Course::all();
      $user = session('wechat.oauth_user');
      $records = Userrecord::where("openid",$user->id)->orderBy('created_at', 'desc')->paginate(20);

      return view('wechat.courseindex',compact('courses','records','user'));

    }

// 记录录音记录
public function record($speech_unique, Request $request){
  $userrecord = Userrecord::where('speech_unique',trim($speech_unique))->first();
  $user = User::where("openid",$userrecord->openid)->first();
  $records = Record::where("speech_unique",$userrecord->speech_unique)->get();
  //$records = array();



//  $user = session('wechat.oauth_user');
  return view('wechat.record',compact('userrecord','records','user'));
}

    public function act(Section $section, Request $request){



      $app = app('wechat.official_account');
      $user = session('wechat.oauth_user');
      switch ($section->type) {
        case '0':
        $phrasesections  = $section->phrase()->orderBy('created_at', 'desc');
        $return_blade ="wechat.act_read";
          break;
        case '1':
        $phrasesections  = $section->phrase()->orderBy('created_at')->paginate(1);
        $return_blade ="wechat.act_speech";
        if(isset($request->page)==false||$request->page == 1){
          //session('speech_unique')= uniqid();
          session(['speech_unique'=> uniqid()]);

          //$tt= session('speech_unique');
        //  $tt = uniqid();
          //dd($tt);
        }
          break;
        case '2':
        $phrasesections  = $section->phrase()->orderBy('created_at', 'desc')->paginate(1);
        $return_blade ="wechat.act_two";

          break;
      }
      $chapter_id = $section->chapter_id;

      $chapter = Chapter::find($chapter_id);
      $course_id = $chapter->course_id;
      $course  =Course::find($course_id);

      $curentpage = $phrasesections->currentPage();
      $nextpageurl = $phrasesections->nextPageUrl();
      $next_page = "";



      $itemes = $phrasesections->items();
      $phrase_array =array();
$media_serverid ="";
$media_path ="";

if($request->media_serverid){
  $media_serverid = $request->media_serverid;
  $media_path =md5($media_serverid).".mp3";
}


      if($request->phrase_id){
        if(session('speech_unique')){

          $speech_unique= session('speech_unique');

          $records = Record::where('speech_unique',$speech_unique)->where('phrase_id',$request->phrase_id)->count();


          if($records==false){
            Record::create([
            'speech_unique' => $speech_unique,
            'openid' => $user->id,
            'phrase_id' => $request->phrase_id,
            'section_id' => $section->id,
            'chapter_id' => $section->chapter_id,
            'course_id' => $course->id,
            'media_serverid' => $media_serverid,
            'media_path' => $media_path,
        ]);
          }
        }

      }


      if($nextpageurl==false){
        $speech_unique= session('speech_unique');
          if($speech_unique){
            $nextpageurl = route('wechatsection',$chapter->id);
              $nextpage = 100000;
              if($request->page ==100000){
                Userrecord::create([
                'speech_unique' => $speech_unique,
                'openid' => $user->id,
                'push' => 0,
                'section_id' => $section->id,
                'chapter_id' => $section->chapter_id,
                'course_id' => $course->id,
                'media_serverid' => $media_serverid,
                'media_path' => $media_path,
            ]);

            session()->forget('speech_unique');
           return redirect(route('wechatrecord',$speech_unique));
          //return redirect(route('wechatchapter',$course->id));

              }

          }else{
            return redirect(route('wechatact',$section->id));
          }


      }else{

        $tmp_query = parse_url($nextpageurl)['query'];

        $nextpage = str_replace('page=','',$tmp_query);
      }



      return view($return_blade, compact('section','chapter','course','phrasesections','phrase_array','nextpageurl','app','nextpage'));


    }


public function wechatquestion(Section $section, Request $request)
{
  # 答题模式

  $app = app('wechat.official_account');
  $user = session('wechat.oauth_user');

  $questionsections  = $section->question()->orderBy('created_at', 'desc')->paginate(1);
  $curentpage = $questionsections->currentPage();
  $nextpageurl = $questionsections->nextPageUrl();
  $next_page = "";

  $answers =array();
  foreach($questionsections as $questions){
    $answers = $questions->answer()->get();
  }
  $return_blade ="wechat.act_speech";
  if(isset($request->page)==false||$request->page == 1){
    //session('speech_unique')= uniqid();
    session(['exam_unique'=> uniqid()]);

    //$tt= session('speech_unique');
  //  $tt = uniqid();
    //dd($tt);
  }

  $chapter_id = $section->chapter_id;

  $chapter = Chapter::find($chapter_id);
  $course_id = $chapter->course_id;
  $course  =Course::find($course_id);


  if($nextpageurl){
    $tmp_query = parse_url($nextpageurl)['query'];

    $nextpage = str_replace('page=','',$tmp_query);


    $exam_unique= session('exam_unique');
      if($exam_unique){
        $nextpageurl = route('wechatsection',$chapter->id);
          $nextpage = 100000;
          if($request->page ==100000){
            Userrecord::create([
            'speech_unique' => $exam_unique,
            'openid' => $user->id,
            'push' => 0,
            'section_id' => $section->id,
            'chapter_id' => $section->chapter_id,
            'course_id' => $course->id
        ]);

        session()->forget('speech_unique');
       return redirect(route('wechatrecord',$speech_unique));
      //return redirect(route('wechatchapter',$course->id));

          }

      }else{
        return redirect(route('wechatact',$section->id));
      }

  }else{
    $nextpage =0;
  }






  return view('wechat.question',compact('questionsections','section','nextpage','nextpageurl','answers'));
}

// 章节后面的 功能部分 显示没章节后面的功能
public function section(Chapter $chapter){

  $course = Course::find($chapter->course_id);

  $sections = Section::where('chapter_id',$chapter->id)->orderBy('created_at', 'desc')
                     ->paginate(30);
  return view('wechat.section', compact('sections','chapter','course'));

}


//显示每个课程的章节
  public function chapter(Course $course){

    $chapters = Chapter::where('course_id',$course->id)->orderBy('created_at', 'desc')
                       ->paginate(30);

    return view('wechat.chapter', compact('chapters','course'));

  }



    public function speechtotext(Request $request){
      $fileName = public_path(). '/tmp/'.$request->query('filename');;

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



// 从微信服务器上下载临时素材保持到本地服务器，并且把.amr 格式转换成H5可用的MP3格式
// 百度语言识别并保存
    public function getsource(Request $request){
      $app = app('wechat.official_account');
      $Media_Id = $request->query('Media_Id');
      $stream = $app->media->get($Media_Id); //这里好像不行

      $save_path = public_path(). '/tmp/';
      $stream->save($save_path,md5($Media_Id).".amr");

      $fileName = public_path(). '/tmp/'.md5($Media_Id).".amr";

      $userfilename = public_path(). '/voice/uservoice/'.md5($Media_Id).".mp3";

      exec('sox '.$fileName.' '.$userfilename);
    //  $command ='sox '.$fileName.' '.$userfilename;


      $APP_ID=env('APP_ID') ;
      $API_KEY=env('API_KEY') ;
      $SECRET_KEY=env('SECRET_KEY');

      $client = new AipSpeech($APP_ID , $API_KEY, $SECRET_KEY);

        $test = $client->asr(file_get_contents($fileName), 'amr', 8000, array(
          'lan' => 'en',
      ));


      return $test['result'][0];


    }


// google 语言识别
    public function getsourcetwo(Request $request){
      $app = app('wechat.official_account');
       $Media_Id = $request->query('Media_Id');


       $save_path = public_path(). '/tmp/';

       $fileName = public_path(). '/tmp/'.md5($Media_Id).".amr";

       if(file_exists($fileName)==false){
         $stream = $app->media->get($Media_Id); //这里好像不行
          $stream->save($save_path,md5($Media_Id).".amr");
       }


 	    $projectId = 'speech-test@erudite-imprint-186800.iam.gserviceaccount.com';

                     # Instantiates a client
                     $speech = new SpeechClient([
                         'projectId' => $projectId,
                         'languageCode' => 'en-US',
                     ]);

 	   $options = [
                         'encoding' => 'AMR',
                         'sampleRateHertz' => 8000,
                     ];

                     # Detects speech in the audio file
                     $results = $speech->recognize(fopen($fileName, 'r'), $options);
                     $tmp ="";
                     foreach ($results as $result) {
                         $tmp .= $result->alternatives()[0]['transcript'] ;
                     }
                 return $tmp ;


    }

    public function jssdk(){

      $app = app('wechat.official_account');
  //  $test =  $app->jssdk->buildConfig(array $APIs, $debug = false, $beta = false, $json = true);


    return view('wechat.course', compact('app'));
    }

    /**
     * 处理微信的请求消息
     *
     * @return string
     */
    public function serve()
    {
      //  Log::info('request arrived.'); # 注意：Log 为 Laravel 组件，所以它记的日志去 Laravel 日志看，而不是 EasyWeChat 日志

        $app = app('wechat.official_account');
        $app->server->push(function ($message) use ($app){

          switch ($message['MsgType']) {

                case 'voice':
                    $ToUserName = $message['ToUserName'];
                    $FromUserName = $message['FromUserName'];
                    $CreateTime = $message['CreateTime'];
                    $MsgId = $message['MsgId'];
                    $Format = $message['Format'];
                    $Media_Id = $message['MediaId'];




                  //  $Recognition = $message['Recognition'];
                  /*
                    $stream = $app->media->get($Media_Id); //这里好像不行
                    $save_path = public_path(). '/tmp/';
                    $stream->save($save_path,md5($Media_Id).".amr");

                    //google Speech

                    $projectId = 'speech-test@erudite-imprint-186800.iam.gserviceaccount.com';

                    # Instantiates a client
                    $speech = new SpeechClient([
                        'projectId' => $projectId,
                        'languageCode' => 'en-US',
                    ]);



                    # The name of the audio file to transcribe
                    $fileName = public_path(). '/tmp/'.md5($Media_Id).".amr";

                    # The audio file's encoding and sample rate
                    $options = [
                        'encoding' => 'AMR',
                        'sampleRateHertz' => 8000,
                    ];

                    # Detects speech in the audio file
                    $results = $speech->recognize(fopen($fileName, 'r'), $options);
                    $tmp ="";
                    foreach ($results as $result) {
                        $tmp .= 'google: ' . $result->alternatives()[0]['transcript'] ;
                    }
                    echo $tmp ;


                    //end google speech
                    */

                    $stream = $app->media->get($Media_Id); //这里好像不行
                    $save_path = public_path(). '/tmp/';
                    $stream->save($save_path,md5($Media_Id).".amr");

                    $fileName = public_path(). '/tmp/'.md5($Media_Id).".amr";

                    $userfilename = public_path(). '/voice/uservoice/'.md5($Media_Id).".mp3";

                  //  exec('sox '.$fileName.' '.$userfilename);
                //  $command ='sox '.$fileName.' '.$userfilename;
                //  exec($command);




                    $APP_ID=env('APP_ID') ;
                    $API_KEY=env('API_KEY') ;
                    $SECRET_KEY=env('SECRET_KEY');

                  //  const API_KEY = 'QsfgtEHUUrujYOGrSin8UQgy';
                    //const SECRET_KEY = 'bKyrt5qEUUlZvlTt0fch8pDFarTC5ZDt ';

                    $client = new AipSpeech($APP_ID , $API_KEY, $SECRET_KEY);

                      $test = $client->asr(file_get_contents($fileName), 'amr', 8000, array(
                        'lan' => 'en',
                    ));

                    unlink($fileName);
                    //echo $test['result'][0];

                    return '你说的是：'.$test['result'][0];
                    break;

            }

            return "欢迎关注佳和超市";
        });

        return $app->server->serve();
    }
}
