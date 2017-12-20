@extends('layouts.wechat_speech_default')
@section('title', '单词列表')

@section('content')


@foreach ($phrase_array as $id => $phrase)
<div><audio controls="controls" autoplay="autoplay">
  <source src="/voice/juzi/{{ $phrase['phrase']->default_url }}" type="audio/mpeg" />
Your browser does not support the audio element.
</audio></div>
<div>{{$phrase['phrase']->english}}</div>

<div>{{$phrase['phrase']->chinese}}</div>

<div>识别结果：<b id="result"></b></div>

<div>识别结果 2：<b id="resulttwo"></b></div>
@endforeach


@stop
