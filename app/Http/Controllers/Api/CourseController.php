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

      if ($file->isValid()) {

                // 获取文件相关信息
                $originalName = $file->getClientOriginalName(); // 文件原名
                $ext = $file->getClientOriginalExtension();     // 扩展名
                $realPath = $file->getRealPath();   //临时文件的绝对路径
                $type = $file->getClientMimeType();     // image/jpeg

                // 上传文件
                $filename = date('Y-m-d-H-i-s') . '-' . uniqid() . '.' . $ext;
                // 使用我们新建的uploads本地存储空间（目录）
                $bool = Storage::disk('minivoice_uploads')->put($filename, file_get_contents($realPath));
              //  var_dump($bool);

    }


      //return $this->response->item($chapters, new ChapterEntryTransformer());
    }



//语音识别

    public function apispeech(Request $request){

      $tmpurl = $request->query('tmpurl');

      $page_content = file_get_contents($tmpurl);
      $save_path = public_path(). '/tmp/'.md5($tmpurl).".mp3";

      file_put_contents($save_path,$page_content);



      die("test...");
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




}
