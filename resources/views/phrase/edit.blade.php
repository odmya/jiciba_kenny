@extends('admin.default')
@section('title', '添加例句')

@section('content')
<div class="col-md-12">
  <div class="panel panel-default">
    <div class="panel-heading">
      <h5>添加例句</h5>
    </div>
    <div class="panel-body">
      @include('shared._errors')
      {!!Form::model($phrase, array('url' => route('phrase.update',$phrase->id),'method'=> "PATCH",'enctype'=>"multipart/form-data"))!!}

          <div class="form-group">
            <label for="english">English：</label>
            {!! Form::text('english') !!}

          </div>

          <div class="form-group">
            <label for="chinese">chinese：</label>
            {!! Form::text('chinese') !!}
          </div>

          <div class="form-group">
            <label for="s_url">慢速：</label>
            {!! Form::file('s_url') !!}

          </div>

          <div class="form-group">
            <label for="n_url">中速：</label>
            {!! Form::file('n_url') !!}
          </div>
          <div class="form-group">
            <label for="f_url">快速：</label>
            {!! Form::file('f_url') !!}
          </div>
          <div class="form-group">
            <label for="default_url">默认：</label>
            {!! Form::file('default_url') !!}
          </div>


{!! Form::submit('修改',array('class'=>'btn btn-primary')) !!}
      {!! Form::close() !!}
    </div>
  </div>
</div>
@stop
