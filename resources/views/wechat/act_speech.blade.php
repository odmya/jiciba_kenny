@extends('layouts.wechat_speech_default')
@section('title', '单词列表')

@section('content')


@foreach ($phrasesections as $id => $phrase)
<div><audio id="speech" controls="controls" autoplay="autoplay">
  <source src="/voice/juzi/{{ $phrase->default_url }}" type="audio/mpeg" />
Your browser does not support the audio element.
</audio></div>

<div>{{$phrase->english}}</div>

<div>{{$phrase->chinese}}</div>

<div id='yourspeech'>你的读音,点击播放<img src="/images/laba.jpg" id='laba'></div>

<div>识别结果：<b id="result"></b></div>

<div>识别结果 2：<b id="resulttwo"></b></div>

<div id='record_begin' style='display:none;text-align:center;'><img src="/images/voice.gif"></div>
@endforeach


@stop
