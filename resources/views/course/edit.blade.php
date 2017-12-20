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
      {!!Form::model($course, array('url' => route('course.update',$course->id),'method'=> "PATCH",'enctype'=>"multipart/form-data"))!!}

      <div class="form-group">
        <label for="name">课件名称</label>
        {!! Form::text('name') !!}
      </div>


      <div class="form-group">
        <label for="name">副标题</label>
        {!! Form::text('sub_header') !!}
      </div>


      <div class="form-group">
        <label for="name">图片</label>
        {!! Form::file('image') !!}
      </div>

      <div class="form-group">
        <label for="name">价格</label>
        {!! Form::text('price') !!}
      </div>

      <div class="form-group">
        <label for="name">折扣价</label>
        {!! Form::text('discount_price') !!}
      </div>
      <div class="form-group">
        <label for="name">免费课时</label>
        {!! Form::text('free') !!}
      </div>
      <div class="form-group">
        <label for="name">描述</label>
      {!! Form::textarea('description') !!}
      </div>


{!! Form::submit('修改',array('class'=>'btn btn-primary')) !!}
      {!! Form::close() !!}
    </div>
  </div>
</div>
@stop
