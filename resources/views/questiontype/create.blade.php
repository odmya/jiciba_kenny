@extends('admin.default')
@section('title', '添加答题')

@section('content')
<div class="col-md-offset-2 col-md-8">
  <div class="panel panel-default">
    <div class="panel-heading">
      <h5>添加答题类型</h5>
    </div>
    <div class="panel-body">
      @include('shared._errors')
      {!!Form::open(array('route' => 'questiontype.store','method'=> "POST",'enctype'=>"multipart/form-data"))!!}

        {{ csrf_field() }}
          <div class="form-group">
            <label for="name">name</label>
            {!! Form::text('name') !!}
          </div>


          <button type="submit" class="btn btn-primary">添加</button>
      {!! Form::close() !!}
    </div>
  </div>
</div>
@stop
