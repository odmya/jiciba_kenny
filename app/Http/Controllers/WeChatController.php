<?php

namespace App\Http\Controllers;

use Log;
use EasyWeChat\Kernel\Messages\Voice;
use Google\Cloud\Translate\TranslateClient;
use Google\Cloud\Speech\SpeechClient;
use Illuminate\Http\Request;
use AipSpeech;

putenv('GOOGLE_APPLICATION_CREDENTIALS='.public_path().'/google-95003-2d37e7203dfa2017-11-12.json');

class WeChatController extends Controller
{

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

                    return 'Google 英文语音识别：'.$test['result'][0];
                    break;

            }

            return "欢迎关注佳和超市";
        });

        return $app->server->serve();
    }
}
