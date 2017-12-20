@extends('layouts.wechat_default')
@section('title', '课程章节')

@section('content')
<div class="col-md-12">
  <h3>{{ $course->name}}</h3>


  <div><a href="{{route('wechatcourse')}}">返回</a></div>
  <table class="table table-striped">
    <tr><td>名称</td></tr>
    @foreach ($chapters as $chapter)
    <tr>
      <td><a href="{{route('wechatsection',$chapter->id)}}">{{ $chapter->name}}</a></td>
    </tr>
    @endforeach
  </table>

  {!! $chapters->render() !!}


<div>

</div>
</div>
@stop
