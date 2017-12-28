<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\QuestionType;
use App\Models\Question;
use App\Models\Answer;
use Auth;
use Storage;
use Redirect;

class QuestionController extends Controller
{
    //

    public function index()
    {
      if(Auth::user()->is_admin){
        $questions = Question::orderBy('created_at', 'desc')
                           ->paginate(30);

        return view('question.index', compact('questions'));
      }else{
        return redirect('login');
      }


    }

  public function add(Question $question){

    $answers  = $question->answer()->orderBy('created_at', 'desc')->get();

    return view('question.add', compact('question','answers'));

  }

  public function questionaddsave(Request $request){

    $id = trim($request->id);
    $answer =    Answer::find($id);
    $question = Question::find($request->question_id);
      if($answer !=null){
            //PhraseSection::create(['phrase_id'=>$phrase->id,'section_id'=>$request->section_id]);
            $question->answer()->attach([$answer->id]);

      }


    return Redirect::back();

  }

    public function store(Request $request)
  {

    $this->validate($request, [
     'name' => 'required|max:255',
   ]);

    $image_url = $request->file('image_url');
    $s_url_filename ="";

    if(isset($image_url)){
    if ($image_url->isValid()) {
               // 获取文件相关信息


               $originalName = $image_url->getClientOriginalName(); // 文件原名
               $ext = $image_url->getClientOriginalExtension();     // 扩展名
               $realPath = $image_url->getRealPath();   //临时文件的绝对路径
               $type = $image_url->getClientMimeType();     // image/jpeg
               // 上传文件
               $filename = date('Y-m-d-H-i-s') . '-' . uniqid() . '.' . $ext;
               $s_url_filename =$filename;

               //var_dump($s_url_filename);

               // 使用我们新建的uploads本地存储空间（目录）
               $bool = Storage::disk('question_uploads')->put($filename, file_get_contents($realPath));

}
}


    $question = Question::create([
        'name' => $request->name,
        'description_en' => $request->description_en,
        'description_zh' => $request->description_zh,
        'question_zh' => $request->question_zh,
        'question_en' => $request->question_en,
        'image_url' => $s_url_filename,
        'phrase_list' => $request->phrase_list,
        'correct_answer' => $request->correct_answer,
        'audio_path' => $request->audio_path,
        'type' => $request->type,
        'sort' => $request->sort,
        'enable' => $request->enable,

    ]);

      return redirect(route('question.index'));
  }



  public function update(Question $question, Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
        ]);
        $data = [];
        $data['name'] = $request->name;
        $data['description_en'] = $request->description_en;
        $data['description_zh'] = $request->description_zh;

        $data['question_zh'] = $request->question_zh;
        $data['question_en'] = $request->question_en;

        $data['phrase_list'] = $request->phrase_list;

        $data['correct_answer'] = $request->correct_answer;
        $data['audio_path'] = $request->audio_path;
        $data['type'] = $request->type;
        $data['sort'] = $request->sort;
        $data['enable'] = $request->enable;

        $image_url = $request->file('image_url');
        $s_url_filename ="";

        if(isset($image_url)){
        if ($image_url->isValid()) {
                   // 获取文件相关信息


                   $originalName = $image_url->getClientOriginalName(); // 文件原名
                   $ext = $image_url->getClientOriginalExtension();     // 扩展名
                   $realPath = $image_url->getRealPath();   //临时文件的绝对路径
                   $type = $image_url->getClientMimeType();     // image/jpeg
                   // 上传文件
                   $filename = date('Y-m-d-H-i-s') . '-' . uniqid() . '.' . $ext;
                   $s_url_filename =$filename;

                   //var_dump($s_url_filename);

                   // 使用我们新建的uploads本地存储空间（目录）
                   $bool = Storage::disk('question_uploads')->put($filename, file_get_contents($realPath));
                   $data['image_url'] = $s_url_filename;

    }
    }


        $question->update($data);

        session()->flash('success', '修改成功');

        return redirect()->route('question.index');
    }

  public function edit(Question $question)
  {

    $questiontypes = QuestionType::all();
    $questiontype =array();
    foreach($questiontypes as $k => $v){
      $questiontype[$v->id]=$v->name;
    }

    $answers  = $question->answer()->orderBy('created_at', 'desc')->get();
    $answer =array();
    foreach($answers as $k => $v){
      $answer[$v->id]=$v->name;
    }



      return view('question.edit', compact('question','questiontype','answer'));
  }


  public function destroy(Question $question, Request $request){

    if(Auth::user()->is_admin){
      $question->delete();
      return redirect(route('question.index'));
    }else{
      return redirect('login');
    }
  }


    public function create()
      {
        $questiontypes = QuestionType::all();
        foreach($questiontypes as $k => $v){
          $questiontype[$v->id]=$v->name;
        }
          return view('question.create',compact('questiontype'));
      }

      public function show(Phrase $phrases)
      {
        //  $this->authorize('update', $phrase);
          return view('question.show', compact('phrases'));
      }



}
