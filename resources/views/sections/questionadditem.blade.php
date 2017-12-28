@extends('admin.default')
@section('title', '单词列表')

@section('content')
<div class="col-md-12">
  <h1>课程: {{$course->name}}</h1>
  <h2>章节: {{$chapter->name}}</h2>
  <div><a href="{{route('sectioncreate',$chapter->id)}}">添加</a>  | <a href="{{route('chapterindex',$course->id)}}">返回</a></div>



  <table class="table table-striped">
    <tr><td>模式({{$section->name}})</td><td>ID</td><td>question</td><td>english</td><td>type</td><td>操作</td></tr>
    @foreach ($questionsections as $id => $question)
    <tr>
      <td>{{ $section->name}}</td>
      <td>{{$question->id}}</td>
      <td>{{ $question->name}}</td>
      <td>{{ $question->description_en}}</td>
      <td>{{ $question->questiontype->name}}</td>
<td>
  {!! Form::open(array('url' => route('sectionadditemremove'),'method'=>'delete')) !!}

  {!! Form::hidden('section_id',$section->id) !!}
  {!! Form::hidden('phrase_id',$question->id) !!}

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
