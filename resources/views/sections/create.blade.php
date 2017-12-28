@extends('admin.default')
@section('title', '注册')

@section('content')
<div >
  <div class="panel panel-default">
    <h1>课程: {{$course->name}}( {{$chapter->name}} )</h1>
    <h2>模块添加</h2>
    <div><a href="{{route('sectioncreate',$chapter->id)}}">添加</a>  | <a href="{{route('chapterindex',$course->id)}}">返回</a></div>

    <div class="panel-body">
      @include('shared._errors')
      {!!Form::open(array('route' => 'sectionstore','method'=> "POST",'enctype'=>"multipart/form-data"))!!}

          <div class="form-group">
            <label for="name">名称</label>
            {!! Form::text('name') !!}
            {!! Form::hidden('chapter_id',$chapter->id) !!}
          </div>

          <div class="form-group">
            <label for="name">类型</label>
            {!! Form::select('type', array('0' => '阅读模式', '1' => '语音模式', '2' =>'角色扮演模式','3' =>'答题模式')) !!}


          </div>


{!! Form::submit('添加',array('class'=>'btn btn-primary')) !!}
      {!! Form::close() !!}
    </div>
  </div>
</div>
@stop
