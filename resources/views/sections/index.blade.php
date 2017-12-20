@extends('admin.default')
@section('title', '单词列表')

@section('content')
<div class="col-md-12">
  <h1>课程: {{$course->name}}</h1>
  <h2>章节: {{$chapter->name}}</h2>
  <div><a href="{{route('sectioncreate',$chapter->id)}}">添加</a>  | <a href="{{route('chapterindex',$course->id)}}">返回</a></div>
  <table class="table table-striped">
    <tr><td>名称</td><td>类型</td><td>描述</td><td>操作</td></tr>
    @foreach ($sections as $section)
    <tr>
      <td><a href="{{route('sectionadditem',$section->id)}}">{{ $section->name}}</a></td>
      <td>

        @if($section->type==0)
          阅读模式
        @elseif($section->type==1)
          语音模式
          @elseif($section->type==2)
            角色扮演模式
          @endif

    </td>
      <td>{{ $section->description }}</td>
      <td ><a href="{{route('sectionedit',$section->id)}}" class="btn btn-info">编辑</a>


        {!! Form::open(array('url' => route('sectiondestroy',$section->id),'method'=>'delete')) !!}
        {!! Form::submit('删除',array('class' => 'btn btn-info btn-danger')) !!}
        {!! Form::close()!!}

      </td>
    </tr>
    @endforeach
  </table>

  {!! $sections->render() !!}
<div>

</div>
</div>
@stop
