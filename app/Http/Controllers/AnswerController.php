<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;


use App\Models\Answer;
use Auth;

class AnswerController extends Controller
{
    //

    public function index()
    {
      if(Auth::user()->is_admin){
        $answers = Answer::orderBy('created_at', 'desc')
                           ->paginate(30);
        return view('answer.index', compact('answers'));
      }else{
        return redirect('login');
      }


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


    $answer = Answer::create([
        'name' => $request->name,
        'english' => $request->english,
        'chinese' => $request->chinese,
        'audio_path' => $request->audio_path,
        'image_url' => $s_url_filename,

    ]);

      return redirect(route('answer.index'));
  }


  public function edit(Answer $answer)
  {


      return view('answer.edit', compact('answer'));
  }

  public function update(Answer $answer, Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
        ]);
        $data = [];
        $data['name'] = $request->name;
        $data['english'] = $request->english;
        $data['chinese'] = $request->chinese;
        $data['audio_path'] = $request->audio_path;



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


        $answer->update($data);

        session()->flash('success', '修改成功');

        return redirect()->route('answer.index');
    }



    public function destroy(Answer $answer, Request $request){

      if(Auth::user()->is_admin){
        $answer->delete();
        return redirect(route('answer.index'));
      }else{
        return redirect('login');
      }
    }


      public function create()
        {

            return view('answer.create');
        }

        public function show(Answer $answer)
        {
          //  $this->authorize('update', $phrase);
            return view('answer.show', compact('answer'));
        }



}
