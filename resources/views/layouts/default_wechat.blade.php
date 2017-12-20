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
    wx.config({!! $app->jssdk->buildConfig(array('startRecord', 'stopRecord','onVoiceRecordEnd','playVoice','pauseVoice','stopVoice','onVoicePlayEnd','uploadVoice','translateVoice'), false) !!});

    var voice = {
      localId: '',
      serverId: ''
    };

  wx.ready(function () {





    $('#stopRecord').on('click', function () {

      wx.stopRecord({
       success: function (res) {
         voice.localId = res.localId;

         wx.uploadVoice({
          localId: res.localId, // 需要上传的音频的本地ID，由stopRecord接口获得
          isShowProgressTips: 1, // 默认为1，显示进度提示
          success: function (res) {
          var serverId = res.serverId; // 返回音频的服务器端ID
                $.ajax({
                 url:"{{route('getsource')}}",
                 type: 'get',
                 data: {
                       'Media_Id': res.serverId
                   },
                 cache:false,//false是不缓存，true为缓存
                 async:true,//true为异步，false为同步

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

  });





      });


</script>

  </head>
  <body>
    @include('layouts._header')

    <div class="container">
      <div class="col-md-offset-1 col-md-10">



<form class="form-inline" method="post" action="{{ route('search') }}">
  <div class="form-group">

    <div class="input-group">

      <input name="query" type="text" class="form-control" id="exampleInputAmount" placeholder="输入搜索的单词">
      {{ csrf_field() }}
    </div>
  </div>

  <button type="submit" class="btn btn-primary">搜索</button>
</form>

        @include('shared._messages')
        @yield('content')
        @include('layouts._footer')
      </div>
    </div>



  </body>


</html>
