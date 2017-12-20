@extends('layouts.default')
@section('title', '注册')

@section('content')
<div class="col-md-offset-2 col-md-8">
  <div class="panel panel-default">
    <div class="panel-heading">
      <h5>添加例句</h5>
    </div>
    <div class="panel-body">
      @include('shared._errors')
      {!!Form::open(array('route' => 'phrase.store','method'=> "POST",'enctype'=>"multipart/form-data"))!!}

        {{ csrf_field() }}
          <div class="form-group">
            <label for="name">English：</label>
            <input type="text" name="english" class="form-control" value="{{ old('english') }}">
          </div>

          <div class="form-group">
            <label for="name">chinese：</label>
            <input type="text" name="chinese" class="form-control" value="{{ old('chinese') }}">
          </div>

          <div class="form-group">
            <label for="name">慢速：</label>
            <input type="file" name="s_url" class="form-control" value="{{ old('s_url') }}">
          </div>

          <div class="form-group">
            <label for="name">中速：</label>
            <input type="file" name="n_url" class="form-control" value="{{ old('n_url') }}">
          </div>
          <div class="form-group">
            <label for="name">快速：</label>
            <input type="file" name="f_url" class="form-control" value="{{ old('f_url') }}">
          </div>
          <div class="form-group">
            <label for="name">默认：</label>
            <input type="file" name="default_url" class="form-control" value="{{ old('default_url') }}">
          </div>



          <button type="submit" class="btn btn-primary">添加</button>
      {!! Form::close() !!}
    </div>
  </div>
</div>
@stop
