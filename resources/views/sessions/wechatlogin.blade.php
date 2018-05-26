<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>@yield('title', 'Sample App')</title>
    <link rel="stylesheet" href="/css/app.css">

<script src="/js/app.js"></script>



<script src="https://res.wx.qq.com/open/js/jweixin-1.0.0.js" type="text/javascript" charset="utf-8"></script>

<script>
wx.config({!! $app->jssdk->buildConfig(array('scanQRCode'), false) !!});

wx.ready(function () {
  wx.scanQRCode({
    desc: 'scanQRCode desc',
    needResult: 0, // 默认为0，扫描结果由微信处理，1则直接返回扫描结果，
    scanType: ["qrCode","barCode"], // 可以指定扫二维码还是一维码，默认二者都有
    success: function (res) {
    var result = res.resultStr; // 当needResult 为 1 时，扫码返回的结果
}
});
});

</script>

  </head>
  <body>
    <div class="container">
      <div class="col-md-offset-1 col-md-10">

        <div id="wechatlogin"></div>
      </div>
    </div>



  </body>


</html>
