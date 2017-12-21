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

use Redirect;
use Auth;
use Storage;


putenv('GOOGLE_APPLICATION_CREDENTIALS='.public_path().'/google-95003-2d37e7203dfa2017-11-12.json');

class WeChatController extends Controller
{

  public function __construct()
    {
        $this->middleware('wechat', [
            'except' => ['weixinmini', 'serve', 'getsource',  'getsourcetwo','wechatoauth']
        ]);

    }



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

    public function wechatoauth(){

      $app = app('wechat.official_account');
      $user = $app->oauth->user();

      if(User::where('openid',$user->getId()->count())){
        if ( Auth::attempt(['openid' => $user->getId()]) ){
          return redirect(route('wechatcourse'));
        }
      }else{
        User::create([
            'name' => $user->getName(),
            'email' => $user->getEmail(),
            'nickname' => $user->getNickname(),
            'openid' => $user->getId(),
            'avatar' => $user->getAvatar(),

            'password' => bcrypt($user->getId()),
        ]);

        return $app->oauth->redirect()->send();
      }


    }

    public function course(){
      $courses = Course::all();

      return view('wechat.courseindex',compact('courses'));

    }


    public function act(Section $section){

      $app = app('wechat.official_account');

      switch ($section->type) {
        case '0':
        $phrasesections  = $section->phrase()->orderBy('created_at', 'desc');
        $return_blade ="wechat.act_read";
          break;
        case '1':
        $phrasesections  = $section->phrase()->orderBy('created_at')->paginate(1);
        $return_blade ="wechat.act_speech";
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

      if($nextpageurl==false){

        $nextpageurl = route('wechatsection',$chapter->id);

      }
      $itemes = $phrasesections->items();
      $phrase_array =array();


      return view($return_blade, compact('section','chapter','course','phrasesections','phrase_array','nextpageurl','app'));


    }

public function section(Chapter $chapter){

  $course = Course::find($chapter->course_id);

  $sections = Section::where('chapter_id',$chapter->id)->orderBy('created_at', 'desc')
                     ->paginate(30);
  return view('wechat.section', compact('sections','chapter','course'));

}
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


    public function getsource(Request $request){
      $app = app('wechat.official_account');
      $Media_Id = $request->query('Media_Id');
      $stream = $app->media->get($Media_Id); //这里好像不行

      $save_path = public_path(). '/tmp/';
      $stream->save($save_path,md5($Media_Id).".amr");

      $fileName = public_path(). '/tmp/'.md5($Media_Id).".amr";

      $APP_ID=env('APP_ID') ;
      $API_KEY=env('API_KEY') ;
      $SECRET_KEY=env('SECRET_KEY');

      $client = new AipSpeech($APP_ID , $API_KEY, $SECRET_KEY);

        $test = $client->asr(file_get_contents($fileName), 'amr', 8000, array(
          'lan' => 'en',
      ));


      return $test['result'][0];


    }


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
