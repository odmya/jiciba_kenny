<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>@yield('title', $userrecord->chapter->name)</title>
    <link rel="stylesheet" href="/css/app.css">

<script src="/js/app.js"></script>


  </head>
  <body>
    <div class="container">
      <div class="col-md-offset-1 col-md-10">

        @include('shared._messages')

<div><a href="{{route('wechatcourse')}}">返回我的课程</a></div>





        @foreach ($questions as $question)
        <div style="margin-top:15px;">


<div id="description_en" >{{$question->question->name}}</div>

@if($question->question->type ==2)

<div><audio id="ting" controls="controls" autoplay="autoplay">
  <source src="/{{ $question->question->audio_path }}" type="audio/mpeg" />
Your browser does not support the audio element.
</audio></div>

@else

<div id="description_en">{{$question->question->description_en}}</div>

@endif


<ol>
@foreach ($question->question->answer as $answer)

<li>{{$answer->name}}</li>

@endforeach
</ol>
<div>正确答案:{{$question->Correct['name']}}</div>
@if($question->correct == $question->student_answer)

<div>你选择的答案:{{$question->Student_Answer['name']}}</div>
@else
<div style="color:red">你选择的答案:{{$question->Student_Answer['name']}}</div>
@endif

</div>
        @endforeach

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
