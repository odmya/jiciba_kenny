@extends('admin.default')
@section('title', '课程列表')

@section('content')
<div class="col-md-12">
  <h1>课程列表</h1>
  <div><a href="{{route('course.create')}}">添加</a></div>
  <table class="table table-striped">
    <tr><td>名称</td><td>副标题</td><td>Chinese</td><td>图片</td><td>价格</td><td>折扣价</td><td>免费课时</td><td>描述</td></tr>
    @foreach ($courses as $course)
    <tr>
      <td><a href="{{route('chapterindex',$course->id)}}">{{ $course->name}}</a></td>
      <td>{{ $course->sub_header }}</td>
      <td>{{ $course->image }}</td>
      <td>{{ $course->price }}</td>
      <td>{{ $course->discount_price }}</td>
      <td>{{ $course->free }}</td>
      <td>{{ $course->description }}</td>
      <td ><a href="{{route('course.edit',$course->id)}}" class="btn btn-info">编辑</a>


        {!! Form::open(array('url' => route('course.destroy',$course->id),'method'=>'delete')) !!}
        {!! Form::submit('删除',array('class' => 'btn btn-info btn-danger')) !!}
        {!! Form::close()!!}

      </td>
    </tr>
    @endforeach
  </table>

  {!! $courses->render() !!}
<div>

</div>
</div>
@stop
