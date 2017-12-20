<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Phrase;
use Auth;
use Storage;


class PhraseController extends Controller
{
    //
    public function __construct()
      {
          $this->middleware('auth');

      }


      public function query(Request $request)
      {
        # code...
        $word = $request->word;
        $query_word = trim($word);
        $query_word = strtolower($query_word);

        return Phrase::where('english', 'like','%'.$query_word.'%')->first();

      }

    public function index()
    {
      if(Auth::user()->is_admin){
        $phrases = phrase::orderBy('created_at', 'desc')
                           ->paginate(30);
        return view('phrase.index', compact('phrases'));
      }else{
        return redirect('login');
      }


    }


    public function update(Phrase $phrase, Request $request)
      {
          $this->validate($request, [
              'english' => 'required',
          ]);
          $data = [];
          $data['english'] = $request->english;
          $data['chinese'] = $request->chinese;

          $s_url = $request->file('s_url');
          $s_url_filename ="";

          if(isset($s_url)){
          if ($s_url->isValid()) {
                     // 获取文件相关信息


                     $originalName = $s_url->getClientOriginalName(); // 文件原名
                     $ext = $s_url->getClientOriginalExtension();     // 扩展名
                     $realPath = $s_url->getRealPath();   //临时文件的绝对路径
                     $type = $s_url->getClientMimeType();     // image/jpeg
                     // 上传文件
                     $filename = date('Y-m-d-H-i-s') . '-' . uniqid() . '.' . $ext;
                     $s_url_filename =$filename;

                     //var_dump($s_url_filename);

                     // 使用我们新建的uploads本地存储空间（目录）
                     $bool = Storage::disk('phrase_uploads')->put($filename, file_get_contents($realPath));
                     $data['s_url'] = $s_url_filename;

      }
      }
          $n_url = $request->file('n_url');

          //var_dump($s_url);
          $n_url_filename ="";
      if(isset($n_url)){
          if ($n_url->isValid()) {
                     // 获取文件相关信息
                     $originalName = $n_url->getClientOriginalName(); // 文件原名
                     $ext = $n_url->getClientOriginalExtension();     // 扩展名
                     $realPath = $n_url->getRealPath();   //临时文件的绝对路径
                     $type = $n_url->getClientMimeType();     // image/jpeg
                     // 上传文件
                     $filename = date('Y-m-d-H-i-s') . '-' . uniqid() . '.' . $ext;
                     $n_url_filename =$filename;
                     // 使用我们新建的uploads本地存储空间（目录）
                     $bool = Storage::disk('phrase_uploads')->put($filename, file_get_contents($realPath));
                     $data['n_url'] = $n_url_filename;

                 }
            }
          $f_url = $request->file('f_url');
          $f_url_filename ="";

      if(isset($f_url)){
          if ($f_url->isValid()) {
                     // 获取文件相关信息
                     $originalName = $f_url->getClientOriginalName(); // 文件原名
                     $ext = $f_url->getClientOriginalExtension();     // 扩展名
                     $realPath = $f_url->getRealPath();   //临时文件的绝对路径
                     $type = $f_url->getClientMimeType();     // image/jpeg
                     // 上传文件
                     $filename = date('Y-m-d-H-i-s') . '-' . uniqid() . '.' . $ext;
                     $f_url_filename =$filename;
                     // 使用我们新建的uploads本地存储空间（目录）
                     $bool = Storage::disk('phrase_uploads')->put($filename, file_get_contents($realPath));
                     $data['f_url'] = $f_url_filename;

                 }
      }
          $default_url = $request->file('default_url');
          $default_url_filename ="";
        if(isset($default_url)){
          if ($default_url->isValid()) {
                     // 获取文件相关信息
                     $originalName = $default_url->getClientOriginalName(); // 文件原名
                     $ext = $default_url->getClientOriginalExtension();     // 扩展名
                     $realPath = $default_url->getRealPath();   //临时文件的绝对路径
                     $type = $default_url->getClientMimeType();     // image/jpeg
                     // 上传文件
                     $filename = date('Y-m-d-H-i-s') . '-' . uniqid() . '.' . $ext;
                     $default_url_filename =$filename;
                     // 使用我们新建的uploads本地存储空间（目录）
                     $bool = Storage::disk('phrase_uploads')->put($filename, file_get_contents($realPath));
                     $data['default_url'] = $default_url_filename;

                 }
      }


          $phrase->update($data);

          session()->flash('success', '修改成功');

          return redirect()->route('phrase.index');
      }


    public function edit(Phrase $phrase)
    {
        return view('phrase.edit', compact('phrase'));
    }

    public function destroy(Phrase $phrase, Request $request){

      if(Auth::user()->is_admin){
        $phrase->delete();
        return redirect(route('phrase.index'));
      }else{
        return redirect('login');
      }


    }
    public function store(Request $request)
  {

    $this->validate($request, [
     'english' => 'required|max:255',
   ]);

    $s_url = $request->file('s_url');
    $s_url_filename ="";

    if(isset($s_url)){
    if ($s_url->isValid()) {
               // 获取文件相关信息


               $originalName = $s_url->getClientOriginalName(); // 文件原名
               $ext = $s_url->getClientOriginalExtension();     // 扩展名
               $realPath = $s_url->getRealPath();   //临时文件的绝对路径
               $type = $s_url->getClientMimeType();     // image/jpeg
               // 上传文件
               $filename = date('Y-m-d-H-i-s') . '-' . uniqid() . '.' . $ext;
               $s_url_filename =$filename;

               //var_dump($s_url_filename);

               // 使用我们新建的uploads本地存储空间（目录）
               $bool = Storage::disk('phrase_uploads')->put($filename, file_get_contents($realPath));

}
}
    $n_url = $request->file('n_url');

    //var_dump($s_url);
    $n_url_filename ="";
if(isset($n_url)){
    if ($n_url->isValid()) {
               // 获取文件相关信息
               $originalName = $n_url->getClientOriginalName(); // 文件原名
               $ext = $n_url->getClientOriginalExtension();     // 扩展名
               $realPath = $n_url->getRealPath();   //临时文件的绝对路径
               $type = $n_url->getClientMimeType();     // image/jpeg
               // 上传文件
               $filename = date('Y-m-d-H-i-s') . '-' . uniqid() . '.' . $ext;
               $n_url_filename =$filename;
               // 使用我们新建的uploads本地存储空间（目录）
               $bool = Storage::disk('phrase_uploads')->put($filename, file_get_contents($realPath));

           }
      }
    $f_url = $request->file('f_url');
    $f_url_filename ="";

if(isset($f_url)){
    if ($f_url->isValid()) {
               // 获取文件相关信息
               $originalName = $f_url->getClientOriginalName(); // 文件原名
               $ext = $f_url->getClientOriginalExtension();     // 扩展名
               $realPath = $f_url->getRealPath();   //临时文件的绝对路径
               $type = $f_url->getClientMimeType();     // image/jpeg
               // 上传文件
               $filename = date('Y-m-d-H-i-s') . '-' . uniqid() . '.' . $ext;
               $f_url_filename =$filename;
               // 使用我们新建的uploads本地存储空间（目录）
               $bool = Storage::disk('phrase_uploads')->put($filename, file_get_contents($realPath));

           }
}
    $default_url = $request->file('default_url');
    $default_url_filename ="";
  if(isset($default_url)){
    if ($default_url->isValid()) {
               // 获取文件相关信息
               $originalName = $default_url->getClientOriginalName(); // 文件原名
               $ext = $default_url->getClientOriginalExtension();     // 扩展名
               $realPath = $default_url->getRealPath();   //临时文件的绝对路径
               $type = $default_url->getClientMimeType();     // image/jpeg
               // 上传文件
               $filename = date('Y-m-d-H-i-s') . '-' . uniqid() . '.' . $ext;
               $default_url_filename =$filename;
               // 使用我们新建的uploads本地存储空间（目录）
               $bool = Storage::disk('phrase_uploads')->put($filename, file_get_contents($realPath));

           }
}

    $phrase = Phrase::create([
        'english' => $request->english,
        'chinese' => $request->chinese,
        's_url' => $s_url_filename,
        's_url' => $n_url_filename,
        'f_url' => $f_url_filename,
        'default_url' => $default_url_filename,
    ]);

      return redirect(route('phrase.index'));
  }

    public function create()
      {
          return view('phrase.create');
      }

      public function show(Phrase $phrases)
      {
        //  $this->authorize('update', $phrase);
          return view('phrase.show', compact('phrases'));
      }



}
