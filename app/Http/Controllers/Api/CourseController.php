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



}
