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
      {!!Form::model($questiontype, array('url' => route('questiontype.update',$questiontype->id),'method'=> "PATCH",'enctype'=>"multipart/form-data"))!!}

        {{ csrf_field() }}
          <div class="form-group">
            <label for="name">name</label>
            {!! Form::text('name') !!}
          </div>

          <button type="submit" class="btn btn-primary">修改</button>
      {!! Form::close() !!}
    </div>
  </div>
</div>
@stop
