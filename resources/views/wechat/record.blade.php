<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>@yield('title', $userrecord->chapter->name)</title>
    <link rel="stylesheet" href="/css/app.css">

<script src="/js/app.js"></script>

<script src="/audiojs/audio.min.js"></script>

<script>
     $(function() {
       // Setup the player to autoplay the next track
       var a = audiojs.createAll({
         trackEnded: function() {
           var next = $('ol li.playing').next();
           if (!next.length) next = $('ol li').first();
           next.addClass('playing').siblings().removeClass('playing');
           audio.load($('a', next).attr('data-src'));
           audio.play();
         }
       });

       // Load in the first track
       var audio = a[0];
           first = $('ol a').attr('data-src');
       $('ol li').first().addClass('playing');
       audio.load(first);

       // Load in a track on click
       $('ol li').click(function(e) {
         e.preventDefault();
         $(this).addClass('playing').siblings().removeClass('playing');
         audio.load($('a', this).attr('data-src'));
         audio.play();
       });
       // Keyboard shortcuts
       $(document).keydown(function(e) {
         var unicode = e.charCode ? e.charCode : e.keyCode;
            // right arrow
         if (unicode == 39) {
           var next = $('li.playing').next();
           if (!next.length) next = $('ol li').first();
           next.click();
           // back arrow
         } else if (unicode == 37) {
           var prev = $('li.playing').prev();
           if (!prev.length) prev = $('ol li').last();
           prev.click();
           // spacebar
         } else if (unicode == 32) {
           audio.playPause();
         }
       })
     });
   </script>

  </head>
  <body>
    <div class="container">
      <div class="col-md-offset-1 col-md-10">

        @include('shared._messages')

<div><a href="{{route('wechatcourse')}}">返回我的课程</a></div>

            <ol>



        @foreach ($records as $record)


        @if($record->media_path)



            <li><img src="{{$record->user->avatar}}" class="left" width="20" height="20">  {{$record->user->nickname}}<a href="#" data-src="{{URL::asset('voice/uservoice')}}/{{$record->media_path}}">{{$record->phrase->english}}    ( {{$record->phrase->chinese}} )</a></li>


          @else

              <li><a href="#" data-src="{{URL::asset('voice/juzi')}}/{{$record->phrase->default_url}}">{{$record->phrase->english}}    ( {{$record->phrase->chinese}} )</a></li>


          @endif

        @endforeach
  </ol>

<div><a href="{{route('wechatcourse')}}">返回我的课程</a></div>
      </div>


      <div class="col-xs-12">
        <footer class="footer">
          <nav>

              <div class="navbar navbar-default navbar-fixed-bottom">



       <audio preload></audio>


              </div>

            </nav>
        </footer>
      </div>

    </div>



  </body>


</html>
