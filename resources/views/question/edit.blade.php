@extends('admin.default')
@section('title', '添加答题')

@section('content')
<div class="col-md-offset-2 col-md-8">
  <div class="panel panel-default">
    <div class="panel-heading">
      <h5>修改答题</h5>
    </div>
    <div class="panel-body">
      @include('shared._errors')
      {!!Form::model($question, array('url' => route('question.update',$question->id),'method'=> "PATCH",'enctype'=>"multipart/form-data"))!!}

        {{ csrf_field() }}
        <div class="form-group">
          <label for="name">name</label>
          {!! Form::text('name') !!}
        </div>

        <div class="form-group">

          <label for="name">english</label>
          {!! Form::textarea('description_en') !!}

        </div>

        <div class="form-group">
          <label for="name">chinese</label>
          {!! Form::textarea('description_zh') !!}
        </div>

        <div class="form-group">

          <label for="name">提问中文</label>
          {!! Form::textarea('question_zh') !!}
        </div>

        <div class="form-group">

          <label for="name">提问英文</label>
          {!! Form::textarea('question_en') !!}
        </div>

        <div class="form-group">

          <label for="name">图片</label>
          {!! Form::file('image_url') !!}
        </div>

        <div class="form-group">

          <label for="name">phrase list</label>
          {!! Form::text('phrase_list') !!}
        </div>

        <div class="form-group">
          <label for="name">正确答案</label>
          {!! Form::select('correct_answer',$answer) !!}
        </div>

        <div class="form-group">
          <label for="name">音频路径</label>
          {!! Form::text('audio_path') !!}
        </div>

        <div class="form-group">
          <label for="name">类型</label>
          {!! Form::select('type',$questiontype) !!}
        </div>

        <div class="form-group">
          <label for="name">排序</label>
          {!! Form::text('sort',0) !!}
        </div>
        <div class="form-group">
          <label for="name">enable</label>
          {!! Form::text('enable',1) !!}
        </div>



          <button type="submit" class="btn btn-primary">修改</button>
      {!! Form::close() !!}
    </div>
  </div>
</div>
@stop
