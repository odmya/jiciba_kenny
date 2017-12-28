@extends('layouts.wechat_default')
@section('title', '单词列表')

@section('content')
<div class="col-md-12">
  <h5>课程: {{$course->name}}</h3>
  <h6>章节: {{$chapter->name}}</h6>
  <div><a href="{{route('wechatchapter',$course->id)}}">返回</a></div>
  <table class="table table-striped">
    <tr><td>名称</td></tr>
    @foreach ($sections as $section)
    <tr>
      @if($section->type ==1)
      <td><a href="{{route('wechatact',$section->id)}}">{{ $section->name}}</a></td>
      @elseif($section->type ==3)
      <td><a href="{{route('wechatquestion',$section->id)}}">{{ $section->name}}</a></td>
      @endif
    </tr>
    @endforeach
  </table>

  {!! $sections->render() !!}
<div>

</div>
</div>
@stop
