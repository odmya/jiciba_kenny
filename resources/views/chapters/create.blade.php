@extends('admin.default')
@section('title', '注册')

@section('content')
<div >
  <div class="panel panel-default">
    <div class="panel-heading">
      <h5>添加章节( {{ $course->name}} ) | <a href="{{route('chapterindex',$course->id)}}">返回</a></h5>
    </div>
    <div class="panel-body">
      @include('shared._errors')
      {!!Form::open(array('route' => 'chapterstore','method'=> "POST",'enctype'=>"multipart/form-data"))!!}

          <div class="form-group">
            <label for="name">名称</label>
            {!! Form::text('name') !!}
          </div>

          <div class="form-group">
            <label for="name">描述</label>
          {!! Form::textarea('description') !!}

          {!! Form::hidden('course_id',$course->id) !!}

          </div>


{!! Form::submit('添加',array('class'=>'btn btn-primary')) !!}
      {!! Form::close() !!}
    </div>
  </div>
</div>
@stop
