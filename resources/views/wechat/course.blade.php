@extends('layouts.default_wechat')
@section('title', '微信课程')

@section('content')
<div class="col-md-offset-2 col-md-8">

  <script type="text/javascript" charset="utf-8">


</script>

  <h1>测试</h1>

  <div>
    <h3 id="menu-voice">音频接口</h3>
         <span class="desc">开始录音接口</span>

         <button type="button" id="startRecord" data-loading-text="Loading..." class="btn btn-primary" autocomplete="off">startRecord</button>
          <button type="button" id="stopRecord" data-loading-text="Loading..." class="btn btn-primary" autocomplete="off">stopRecord</button>


  </div>
  <div>识别结果：<b id="result"></b></div>
  
  <div>识别结果 2：<b id="resulttwo"></b></div>

</div>

@stop
