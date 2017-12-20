@extends('layouts.wechat_default')
@section('title', '微信课程')

@section('content')
<div class="col-md-offset-2 col-md-8">

  <script type="text/javascript" charset="utf-8">


</script>

  <h3>选择课程</h3>
<ul>

  @foreach ($courses as $course)
<li><a href="{{route('wechatchapter',$course->id)}}">{{ $course->name}}</a></li>
  @endforeach


</ul>
  <div>



  </div>


</div>

@stop
