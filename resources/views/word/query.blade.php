@extends('layouts.default')

@section('title', $word_obj->word.", 怎么记忆单词".$word_obj->word)

@section('content')
<div class="col-md-offset-2 col-md-8">
  <h1>{{ $word_obj->word }}</h1>
  <ul class="users">

      <div id="voice">@foreach ($voice_array as $voice)

        <div>{{ $voice['symbol'] }}

          <audio controls="controls">
            <source src="{{ $voice['path'] }}" type="audio/mpeg" />
          Your browser does not support the audio element.
          </audio>
        </div>


      @endforeach </div>


      <div id="explain"><ul>@foreach ($explain_array as $cixing => $explain)

        <li>{{$cixing}} {{implode("",$explain)}}</li>

      @endforeach </ul></div>

  </ul>


</div>
@stop
