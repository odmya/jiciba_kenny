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
use App\Models\Qestionrecord;
use App\Models\Answer;

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

          return redirect(session("return_web_url"));
          //Redirect::back();
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
  $section = Section::find($userrecord->section_id);
  if($section->type == 1){
    $records = Record::where("speech_unique",$userrecord->speech_unique)->get();
    return view('wechat.record',compact('userrecord','records','user'));
  }elseif($section->type == 3){

    $questions = Qestionrecord::where("speech_unique",$userrecord->speech_unique)->get();
    return view('wechat.questionrecord',compact('userrecord','questions','user'));


  }

  //$records = array();



//  $user = session('wechat.oauth_user');

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


  if($request->question_id){

    $this->validate($request, [
        'answer_id' => 'required',
    ]);

    if(session('exam_unique')){

      $exam_unique= session('exam_unique');

      $records = Qestionrecord::where('speech_unique',$exam_unique)->where('question_id',$request->question_id)->count();


      if($records==false){
        Qestionrecord::create([
        'speech_unique' => $exam_unique,
        'openid' => $user->id,
        'correct' => $request->correct_id,
        'question_id' => $request->question_id,
        'student_answer' => $request->answer_id,

    ]);
      }
    }

  }

  if($nextpageurl){
    $tmp_query = parse_url($nextpageurl)['query'];

    $nextpage = str_replace('page=','',$tmp_query);
  }else{

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
            'course_id' => $course->id,
        ]);

        session()->forget('exam_unique');
       return redirect(route('wechatrecord',$exam_unique));
      //return redirect(route('wechatchapter',$course->id));

          }

      }else{
        return redirect(route('wechatact',$section->id));
      }


    $nextpage =100000;
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
      $english_txt = $request->query('english_txt');
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
$tmp_str1 =str_replace(array(" ",".","!","?","'",","),"",strtolower($test['result'][0]));

$tmp_str2 = str_replace(array(" ",".","!","?","'",","),"",strtolower($english_txt));

      similar_text(trim($tmp_str1), trim($tmp_str2), $percent);

      return $test['result'][0]."本次发音得分: (".round($percent)."分)";


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

    // 游戏
    public function game(Request $request){

    //  $app = app('wechat.official_account');
  //  $test =  $app->jssdk->buildConfig(array $APIs, $debug = false, $beta = false, $json = true);
$app = app('wechat.official_account');
$option = $request->query('degree');
if($option == null){
  $option =0;
}
if($option ==3 ){
  return view('wechat.game2',compact('option','app'));
}else{
  return view('wechat.game',compact('option','app'));
}


    }


    public function jssdk(){

      $app = app('wechat.official_account');
  //  $test =  $app->jssdk->buildConfig(array $APIs, $debug = false, $beta = false, $json = true);


    return view('wechat.course', compact('app'));
    }


    /**
     * 处理微信用户标签
     *
     * @return string
     */

  public function userlabel(){

    $app = app('wechat.official_account');

//$tags = $app->user_tag->list();  //获取所有标签
//var_dump($tags);
$tag = $app->user_tag;

//$tagusers = $tag->usersOfTag(100, $nextOpenId = ''); //获取同一标签下的所有用户

$userlist = User::where('openid',"!=","")->get(); //取得所有微信课程的用户例表
foreach($userlist as $ulist){
  $openIds =array();
  $openIds[]=$ulist->openid;
  //修改用户标签
  //$openIds = [$openId1, $openId2, ...];
  $tag->tagUsers($openIds, 100);
}

//dd($openIds);

$tagusers = $tag->usersOfTag(100, $nextOpenId = ''); //获取同一标签下的所有用户
    dd($tagusers);
  }


  /**
   * 处理微信用户菜单
   *
   */

public function usermenu(){

  $app = app('wechat.official_account');
//  $list = $app->menu->list(); //读取已设置菜单

  //$current = $app->menu->current();
  //dd($current);

  //设置个性菜单
/*
  $buttons = [
    [
        "type" => "view",
        "name" => "我的课程",
        "url"  => "https://www.jciba.cn/wechat/course"
    ],
    [
        "type" => "view",
        "name" => "我的账户",
        "url"  => "https://www.jciba.cn/wechat/course"
    ]
];

  $matchRule = [
    "tag_id" => "100",
];

$app->menu->create($buttons, $matchRule);
*/
  //设置个性菜单 结束

  $list = $app->menu->list(); //读取已设置菜单

  $current = $app->menu->current();
  dd($list);
}


/**
 * 处理微信用户模板消息推送
 *
 */
public function usertemplate(){


//用户kenny的openID olReJv1BsSNRrfoi6bsXZdrJ9JPg
$app = app('wechat.official_account');
$tag = $app->user_tag;
$tagusers = $tag->usersOfTag(100, $nextOpenId = ''); //获取同一标签下的所有用户
$openids = $tagusers['data']['openid'];
//print_r($openids);

//发送模板消息
//$openids=["olReJv1BsSNRrfoi6bsXZdrJ9JPg"];
foreach($openids as $useropenid){


  $app->template_message->send([
          'touser' => $useropenid,
          'template_id' => 'bevD68gJR6wuPnkhKjrVIrBprz0-Fb5c0gXvFS2gsWY',
          'url' => 'https://www.jciba.cn/game?degree=3',
          'data' => [
              'first' => '默写前五单元英语单词！',
              'keyword1' => ["默写前五单元英语单词！", '#F00'],
              'keyword2' => '默写单词',
              'remark' => ["默写前五单元英语单词！", '#F00']
          ],
      ]);

/*
  $app->template_message->send([
          'touser' => $useropenid,
          'template_id' => 'xT9hggF-g_7O2bsG7ilDQhgBLj53gICyi4pTy0a2V9w',
          'url' => 'https://www.jciba.cn/wechat/section/11',
          'data' => [
              'first' => '更新了新的课程，请及时学习',
              'keyword1' => ["Unit 5 Pass me the milk,please!", '#F00'],
              'keyword2' => '口语练习',
              'remark' => ["请及时完成练习！", '#F00']
          ],
      ]);
*/

/*
  $app->template_message->send([
          'touser' => $useropenid,
          'template_id' => 'bevD68gJR6wuPnkhKjrVIrBprz0-Fb5c0gXvFS2gsWY',
          'url' => 'https://www.jciba.cn/game3.html',
          'data' => [
              'first' => '前方遭遇单词速降！',
              'keyword1' => ["前方遭遇单词速降！速来挑战！", '#F00'],
              'keyword2' => '单词速降',
              'remark' => ["前方遭遇单词速降！速来挑战！", '#F00']
          ],
      ]);
*/

}


//die();
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
