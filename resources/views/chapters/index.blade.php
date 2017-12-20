@extends('admin.default')
@section('title', '课程章节')

@section('content')
<div class="col-md-12">
  <h1>{{ $course->name}} 章节</h1>


  <div><a href="{{route('chaptercreate',$course->id)}}">添加</a> | <a href="{{route('course.index')}}">返回</a></div>
  <table class="table table-striped">
    <tr><td>名称</td><td>描述</td><td>操作</td></tr>
    @foreach ($chapters as $chapter)
    <tr>
      <td><a href="{{route('sectionindex',$chapter->id)}}">{{ $chapter->name}}</a></td>
      <td>{{ $chapter->description }}</td>
      <td ><a href="{{route('chapteredit',$chapter->id)}}" class="btn btn-info">编辑</a>


        {!! Form::open(array('url' => route('chapterdestroy',$chapter->id),'method'=>'delete')) !!}
        {!! Form::submit('删除',array('class' => 'btn btn-info btn-danger')) !!}
        {!! Form::close()!!}

      </td>
    </tr>
    @endforeach
  </table>

  {!! $chapters->render() !!}


<div>

</div>
</div>
@stop
