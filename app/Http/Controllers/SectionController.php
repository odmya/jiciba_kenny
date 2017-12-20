<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Course;
use App\Models\Section;
use App\Models\Chapter;
use App\Models\Phrase;
use App\Models\PhraseSection;

use Redirect;
use Auth;
use Storage;

class SectionController extends Controller
{
    //
    public function __construct()
      {
          $this->middleware('auth');

      }

      public function index($chapter_id)
      {
        if(Auth::user()->is_admin){
          $chapter = Chapter::find($chapter_id);
          $course = Course::find($chapter->course_id);

          $sections = Section::where('chapter_id',$chapter_id)->orderBy('created_at', 'desc')
                             ->paginate(30);
          return view('sections.index', compact('sections','chapter','course'));
        }else{
          return redirect('login');
        }


      }

      public function additemremove(PhraseSection $phrasesection, Request $request){

        if(Auth::user()->is_admin){


          $phrasesection->delete();
          return Redirect::back();

        }else{
          return redirect('login');
        }



      }

      public function additemsave(Request $request){
        /*
        $word = $request->name;

        $query_word = trim($word);
        $query_word = strtolower($query_word);

        $phrase =    Phrase::where('english', 'like','%'.$query_word.'%')->first();
        */
        $id = trim($request->id);
        $phrase =    Phrase::find($id);

          if($phrase !=null){
                PhraseSection::create(['phrase_id'=>$phrase->id,'section_id'=>$request->section_id]);
          }

          $section = Section::find($request->section_id);

          $chapter_id = $section->chapter_id;




        return Redirect::back();
      }

      public function additem(Section $section)
      {

        $chapter_id = $section->chapter_id;

        $chapter = Chapter::find($chapter_id);
        $course_id = $chapter->course_id;
        $course  =Course::find($course_id);
        $phrasesections  = PhraseSection::where('section_id',$section->id)->orderBy('created_at', 'desc')->paginate(100);

        $curentpage = $phrasesections->currentPage();
        $nextpageurl = $phrasesections->nextPageUrl();
        $itemes = $phrasesections->items();
        $phrase_array =array();
        foreach ($itemes as $key => $perwords) {

          $phrase_array[$perwords->id]= array('phrase'=>Phrase::find($perwords->phrase_id),'section'=>Section::find($perwords->section_id));

          # code...
        //  echo $perwords->word;


        }


        return view('sections.additem', compact('section','chapter','course','phrasesections','phrase_array'));
      }


      public function edit(Section $section)
      {
          return view('sections.edit', compact('section'));
      }


      public function update(Section $section, Request $request)
        {
            $this->validate($request, [
                'name' => 'required',
            ]);
            $data = [];
            $data['name'] = $request->name;
            $data['type'] = $request->type;

            $section->update($data);

            session()->flash('success', '修改成功');

            return redirect()->route('sectionindex',$section->chapter_id);
        }



      public function destroy(Section $section, Request $request){

        if(Auth::user()->is_admin){

          $chapter_id = $section->chapter_id;

          $chapter = Chapter::find($chapter_id);
          $course_id = $chapter->course_id;

          $section->delete();
          return redirect(route('sectionindex',$chapter->id));
        }else{
          return redirect('login');
        }


      }

      public function store(Request $request){

        $this->validate($request, [
         'name' => 'required|max:255',
       ]);
       $section = Section::create([
           'name' => $request->name,
           'chapter_id' => $request->chapter_id,
           'type' => $request->type,
       ]);

         return redirect(route('sectionindex',$request->chapter_id));


      }


      public function create(Chapter $chapter)
        {

          $course = Course::find($chapter->course_id);
            return view('sections.create',compact('chapter','course'));
        }

}
