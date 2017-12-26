@extends('admin.default')
@section('title', '用户训练记录')

@section('content')
<div class="col-md-12">
  <h1>课程列表</h1>

  <table class="table table-striped">
    <tr><td>唯一标识</td><td>用户昵称</td><td>部分</td><td>章节</td><td>课程</td><td>是否已经推送</td></tr>
    @foreach ($records as $record)
    <tr>
      <td><a href="{{route('wechatrecord',$record->speech_unique)}}">{{ $record->speech_unique }}</a></td>
      <td>{{ $record->user->nickname }}</td>
      <td>{{ $record->section->name }}</td>
      <td>{{ $record->chapter->name }}</td>
      <td>{{ $record->course->name }}</td>
      <td>{{ $record->push }}</td>

    </tr>
    @endforeach
  </table>

  {!! $records->render() !!}
<div>

</div>
</div>
@stop
