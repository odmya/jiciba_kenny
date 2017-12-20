<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Course;
use App\Models\Chapter;
use App\Models\Section;
use Auth;
use Storage;

class CourseController extends Controller
{
    //
    public function __construct()
      {
          $this->middleware('auth');

      }

      public function index()
      {
        if(Auth::user()->is_admin){
          $courses = Course::orderBy('created_at', 'desc')
                             ->paginate(30);
          return view('course.index', compact('courses'));
        }else{
          return redirect('login');
        }


      }

      public function edit(Course $course)
      {
          return view('course.edit', compact('course'));
      }


      public function create()
        {
            return view('course.create');
        }


        public function update(Course $course, Request $request)
          {
              $this->validate($request, [
                  'name' => 'required',
              ]);
              $data = [];
              $data['name'] = $request->name;
              $data['sub_header'] = $request->sub_header;
              $data['price'] = $request->price;
              $data['discount_price'] = $request->discount_price;
              $data['free'] = $request->free;
              $data['description'] = $request->description;

              $image = $request->file('image');
              $image_filename ="";

              if(isset($image)){
                if ($image->isValid()) {
                           // 获取文件相关信息


                           $originalName = $image->getClientOriginalName(); // 文件原名
                           $ext = $image->getClientOriginalExtension();     // 扩展名
                           $realPath = $image->getRealPath();   //临时文件的绝对路径
                           $type = $image->getClientMimeType();     // image/jpeg
                           // 上传文件
                           $filename = date('Y-m-d-H-i-s') . '-' . uniqid() . '.' . $ext;
                           $image_filename =$filename;
                            $data['image'] = $image_filename;
                           //var_dump($s_url_filename);

                           // 使用我们新建的uploads本地存储空间（目录）
                           $bool = Storage::disk('phrase_uploads')->put($filename, file_get_contents($realPath));

              }
            }



              $course->update($data);

              session()->flash('success', '修改成功');

              return redirect()->route('course.index');
          }

          public function destroy(Course $course, Request $request){

            if(Auth::user()->is_admin){

              $chapter =Chapter::where('course_id',$course->id)->first();
              if($chapter){
                $section =Section::where('chapter_id',$chapter->id)->first();
              }


              if(isset($section)&&$section==true){
                $section->delete();
              }

              if($chapter){
                $chapter->delete();
              }
            //  Section::where->('chapter_id',);

              $course->delete();
              return redirect(route('course.index'));
            }else{
              return redirect('login');
            }


          }


        public function store(Request $request)
      {

        $this->validate($request, [
         'name' => 'required|unique:courses|max:255',
       ]);

        $image = $request->file('image');
        $image_filename ="";

        if(isset($image)){
        if ($image->isValid()) {
                   // 获取文件相关信息


                   $originalName = $image->getClientOriginalName(); // 文件原名
                   $ext = $image->getClientOriginalExtension();     // 扩展名
                   $realPath = $image->getRealPath();   //临时文件的绝对路径
                   $type = $image->getClientMimeType();     // image/jpeg
                   // 上传文件
                   $filename = date('Y-m-d-H-i-s') . '-' . uniqid() . '.' . $ext;
                   $image_filename =$filename;

                   //var_dump($s_url_filename);

                   // 使用我们新建的uploads本地存储空间（目录）
                   $bool = Storage::disk('phrase_uploads')->put($filename, file_get_contents($realPath));

      }
      }


        $course = Course::create([
            'name' => $request->name,
            'sub_header' => $request->sub_header,
            'image' => $image_filename,
            'price' => $request->price,
            'discount_price' => $request->discount_price,
            'free' => $request->free,
            'description' => $request->description
        ]);

          return redirect(route('course.index'));
      }


}
