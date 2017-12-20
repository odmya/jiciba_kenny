<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Course;
use App\Models\Section;
use App\Models\Chapter;

use Auth;
use Storage;


class ChapterController extends Controller
{
    //

    public function __construct()
      {
          $this->middleware('auth');

      }

      public function index($couse_id)
      {
        if(Auth::user()->is_admin){
          $course = Course::find($couse_id);
          $chapters = Chapter::where('course_id',$couse_id)->orderBy('created_at', 'desc')
                             ->paginate(30);

          return view('chapters.index', compact('chapters','course'));
        }else{
          return redirect('login');
        }


      }

      public function edit(Chapter $chapter)
      {
          return view('chapter.edit', compact('phrase'));
      }


      public function destroy(Chapter $chapter, Request $request){

        if(Auth::user()->is_admin){

          $course_id = $chapter->course_id;

          $chapter->delete();
          return redirect(route('chapterindex',$course_id));
        }else{
          return redirect('login');
        }


      }


      public function create($couse_id)
        {
          $course = Course::find($couse_id);
            return view('chapters.create',compact('course'));
        }

      public function store(Request $request){
        $this->validate($request, [
         'name' => 'required|max:255',
       ]);

       $chapter = Chapter::create([
           'name' => $request->name,
           'description' => $request->description,
           'course_id' => $request->course_id,
       ]);

         return redirect(route('chapterindex',$request->course_id));


      }

}
