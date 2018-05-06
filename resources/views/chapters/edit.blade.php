@extends('admin.default')
@section('title', '注册')

@section('content')
<div >
  <div class="panel panel-default">

    <div class="panel-body">
      @include('shared._errors')

      {!!Form::model($chapter, array('url' => route('chapterupdate',$chapter->id),'method'=> "PATCH",'enctype'=>"multipart/form-data"))!!}


          <div class="form-group">
            <label for="name">名称</label>
            {!! Form::text('name') !!}
          </div>

          <div class="form-group">
            <label for="name">描述</label>
          {!! Form::textarea('description') !!}

          </div>


{!! Form::submit('添加',array('class'=>'btn btn-primary')) !!}
      {!! Form::close() !!}
    </div>
  </div>
</div>
@stop
