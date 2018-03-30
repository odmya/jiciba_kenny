<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>@yield('title', 'Sample App')</title>
    <link rel="stylesheet" href="/css/app.css">

<script src="/js/app.js"></script>



    <script src="https://res.wx.qq.com/open/js/jweixin-1.0.0.js" type="text/javascript" charset="utf-8"></script>
<script type="text/javascript" charset="utf-8">

var useragent = navigator.userAgent;
if (useragent.match(/MicroMessenger/i) != 'MicroMessenger') {
    // 这里警告框会阻塞当前页面继续加载
   alert('已禁止本次访问：您必须使用微信内置浏览器访问本页面！');
    // 以下代码是用javascript强行关闭当前页面
    var opened = window.open('about:blank', '_self');
    opened.opener = null;
    opened.close();
}

    wx.config({!! $app->jssdk->buildConfig(array('startRecord', 'stopRecord','onVoiceRecordEnd','playVoice','pauseVoice','stopVoice','onVoicePlayEnd','uploadVoice','translateVoice'), false) !!});

    var voice = {
      localId: '',
      serverId: ''
    };

  wx.ready(function () {





    $('#stopRecord').on('click', function () {

      $("#record_begin").css('display','none');

	  $("#stopRecord").hide();
	  $("#startRecord").show();

      wx.stopRecord({
       success: function (res) {
         voice.localId = res.localId;

         wx.uploadVoice({
          localId: res.localId, // 需要上传的音频的本地ID，由stopRecord接口获得
        //  isShowProgressTips: 1, // 默认为1，显示进度提示
          success: function (res) {
          var serverId = res.serverId; // 返回音频的服务器端ID
          $("#yourspeech").css('display','block');
          $("#laba").bind("click",function(){
                    wx.playVoice({
                   localId:  voice.localId
                });
          })

          $("#media_serverid").val(res.serverId);

                $.ajax({
                 url:"{{route('getsource')}}",
                 type: 'get',
                 data: {
                       'Media_Id': res.serverId,
                       'english_txt': $("#english_txt").text()
                   },
                 cache:false,//false是不缓存，true为缓存
                 async:true,//true为异步，false为同步

                 beforeSend:function(result){
                     //请求成功时
                    // alert(result);
                     $("#result").html("我们正在为您评分！请稍后。")
                 },

                 success:function(result){
                     //请求成功时
                    // alert(result);
                     $("#result").html(result)
                 },

                 error:function(){
                     //请求失败时
                 }
             })



          }
          });




       },
       fail: function (res) {
         alert(JSON.stringify(res));
       }
     });
   });

   $('#startRecord').on('click', function () {

$("#stopRecord").show();
	  $("#startRecord").hide();

     wx.startRecord({
      cancel: function () {
        alert('用户拒绝授权录音');
      }
    });

$("#record_begin").css('display','block');

  });





      });






$(function(){

$("#stopRecord").hide();
  function audioAutoPlay(id){
      var audio = document.getElementById(id);
    //  audio.play();
      document.addEventListener("WeixinJSBridgeReady", function () {
              audio.play();
      }, false);
  }



      audioAutoPlay('speech');

$("#yourspeech").css('display','none');

$(".btn1").click(function() {
  var audio = $("#speech")[0];
  audio.playbackRate = 0.5;
  audio.defaultPlaybackRate = 0.5;
  audio.play();

})
$(".btn2").click(function() {
  var audio = $("#speech")[0];
  audio.playbackRate = 1;
  audio.defaultPlaybackRate = 1;
  audio.play();

})

$(".btn4").click(function() {
  var audio = $("#speech")[0];
  audio.playbackRate = 2;
  audio.defaultPlaybackRate = 2;
  audio.play();

});

})
</script>

  </head>
  <body>
    <div class="container">
      <div class="col-md-offset-1 col-md-10">

        @include('shared._messages')

 {!!Form::open(array(route('wechatact',$section->id),'method'=> "get"))!!}

        @foreach ($phrasesections as $id => $phrase)
<div>
  <button type="button" class="btn1">慢速</button>
<button type="button" class="btn2">正常</button>

  <audio id="speech" controls="controls" autoplay="autoplay">
  <source src="/voice/juzi/{{ $phrase->default_url }}" type="audio/mpeg" />
Your browser does not support the audio element.
</audio>

@if($phrase->f_url)


<div><span style="color:green;">对比机器读音，点击播放</span><audio id="speechmachine" controls="controls" >
<source src="/voice/juzi/{{ $phrase->f_url }}" type="audio/mpeg" />
Your browser does not support the audio element.
</audio></div>

 @endif


</div>

<div id="english_txt">{{$phrase->english}}</div>

<div>{{$phrase->chinese}}</div>

<div id='yourspeech'>你的读音,点击播放<img src="/images/laba.jpg" id='laba'></div>

<div><b style="color:red">尽量在安静的环境中跟读，可以练习并提高英语发音水平！</b><br/><b id="result"></b> </div>

<div id='record_begin' style='display:none;text-align:center;'><img src="/images/voice.gif"></div>


<div class="col-xs-12">
  <footer class="footer">
    <nav>

        <div class="navbar navbar-default navbar-fixed-bottom">



          <button type="button" id="startRecord" data-loading-text="Loading..." class="btn btn-primary col-xs-12 btn-lg" autocomplete="off">开始</button>
           <button type="button" id="stopRecord" data-loading-text="Loading..." class="btn btn-primary col-xs-12 btn-lg" autocomplete="off">点击结束</button>


           <input name="page" type="hidden" value="{{$nextpage}}">

            <input name="phrase_id" type="hidden" value="{{$phrase->id}}">

            <input name="media_serverid" type="hidden" value="" id="media_serverid">


           @endforeach


                     <button type="submit" class="btn btn-danger col-xs-12 btn-lg">下一句</button>



        </div>

      </nav>
  </footer>
</div>

{!! Form::close() !!}
      </div>
    </div>



  </body>


</html>
