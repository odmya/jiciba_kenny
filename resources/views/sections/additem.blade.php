@extends('admin.default')
@section('title', '单词列表')

@section('content')
<div class="col-md-12">
  <h1>课程: {{$course->name}}</h1>
  <h2>章节: {{$chapter->name}}</h2>
  <div><a href="{{route('sectioncreate',$chapter->id)}}">添加</a>  | <a href="{{route('chapterindex',$course->id)}}">返回</a></div>



  <table class="table table-striped">
    <tr><td>模式({{$section->name}})</td><td>ID</td><td>短语</td><td>语音</td><td>操作</td></tr>
    @foreach ($phrasesections as $id => $phrase)
    <tr>
      <td>{{ $section->name}}</td>
      <td>{{$phrase->id}}</td>
      <td>{{ $phrase->english}}</td>
      <td>{{ $phrase->default_url}}</td>
<td>
  {!! Form::open(array('url' => route('sectionadditemremove',$id),'method'=>'delete')) !!}
  {!! Form::submit('删除',array('class' => 'btn btn-info btn-danger')) !!}
  {!! Form::close()!!}

</td>
    </tr>
    @endforeach
  </table>


{!!Form::open(array('route' => 'sectionadditemsave','method'=> "POST",'enctype'=>"multipart/form-data"))!!}

      <div class="form-group">
        <label for="name">词条</label>

        {!! Form::text('id',"") !!}
        {!! Form::hidden('section_id',$section->id) !!}
      </div>
{!! Form::submit('添加',array('class'=>'btn btn-primary')) !!}

{!! Form::close() !!}




</div>
@stop
