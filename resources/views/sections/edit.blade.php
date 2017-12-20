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
      {!!Form::model($section, array('url' => route('sectionupdate',$section->id),'method'=> "PATCH",'enctype'=>"multipart/form-data"))!!}

      <div class="form-group">
        <label for="name">名称</label>
        {!! Form::text('name') !!}
      </div>


      <div class="form-group">
        <label for="name">类型</label>
        {!! Form::select('type', array('0' => '阅读模式', '1' => '语音模式', '3' =>'角色扮演模式')) !!}


      </div>



{!! Form::submit('修改',array('class'=>'btn btn-primary')) !!}
      {!! Form::close() !!}
    </div>
  </div>
</div>
@stop
