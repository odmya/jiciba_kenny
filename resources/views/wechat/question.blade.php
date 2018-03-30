<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>@yield('title', 'Sample App')</title>
    <link rel="stylesheet" href="/css/app.css">

<script src="/js/app.js"></script>


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

  </script>

  </head>
  <body>
    <div class="container">
      <div class="col-md-offset-1 col-md-10">

        @include('shared._messages')

 {!!Form::open(array(route('wechatquestion',$section->id),'method'=> "get"))!!}

        @foreach ($questionsections as $id => $question)

<div>{{$question->name}}</div>



@if($question->type ==2)

<div><audio id="ting" controls="controls" autoplay="autoplay">
  <source src="/{{ $question->audio_path }}" type="audio/mpeg" />
Your browser does not support the audio element.
</audio></div>

@else

<div>{{$question->description_en}}</div>

@endif

           <input name="page" type="hidden" value="{{$nextpage}}">

            <input name="question_id" type="hidden" value="{{$question->id}}">

            <input name="correct_id" type="hidden" value="{{$question->correct_answer}}">



            @endforeach

            @foreach ($answers as $answer)

              <div>{!! Form::radio('answer_id',$answer->id),$answer->name !!}</div>

            @endforeach




        </div>
<div class="navbar navbar-default navbar-fixed-bottom">
   <button type="submit" class="btn col-xs-12">继续</button>
</div>
      </nav>
  </footer>
</div>

{!! Form::close() !!}
      </div>
    </div>



  </body>


</html>
