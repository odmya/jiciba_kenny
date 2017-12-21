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

                $.ajax({
                 url:"{{route('getsource')}}",
                 type: 'get',
                 data: {
                       'Media_Id': res.serverId
                   },
                 cache:false,//false是不缓存，true为缓存
                 async:true,//true为异步，false为同步

                 beforeSend:function(result){
                     //请求成功时
                    // alert(result);
                     $("#result").html("请稍后，我们正在理解您的语音！")
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


			 $.ajax({
                 url:"{{route('getsourcetwo')}}",
                 type: 'get',
                 data: {
                       'Media_Id': res.serverId
                   },
                 cache:false,//false是不缓存，true为缓存
                 async:true,//true为异步，false为同步
                beforeSend:function(result){
                    //请求成功时
                   // alert(result);
                    $("#resulttwo").html("请稍后，我们正在理解您的语音！")
                },
                 success:function(result){
                     //请求成功时
                    // alert(result);
                     $("#resulttwo").html(result)
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


     wx.startRecord({
      cancel: function () {
        alert('用户拒绝授权录音');
      }
    });

$("#record_begin").css('display','block');

  });





      });






$(function(){


  function audioAutoPlay(id){
      var audio = document.getElementById(id);
    //  audio.play();
      document.addEventListener("WeixinJSBridgeReady", function () {
              audio.play();
      }, false);
  }



      audioAutoPlay('speech');

$("#yourspeech").css('display','none');
})
</script>

  </head>
  <body>
    <div class="container">
      <div class="col-md-offset-1 col-md-10">

        @include('shared._messages')
        @yield('content')
        @include('layouts.wechat_speech_footer')
      </div>
    </div>



  </body>


</html>
