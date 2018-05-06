@extends('layouts.default')

@section('title', "怎么记忆单词")

@section('content')


<div>


  @foreach ($words as $word)
  <div class="row">

<div>
  <a href="{{route('query',$word->word)}}"> {{$word->word}} </a>
<span>

  @if(count($word->word_voice))
{{$word->word_voice[0]['symbol']}}
@endif
</<span>


@if(str_replace("star","",$word->level_star))
  <span>
    @for ($i = 0; $i < str_replace("star","",$word->level_star); $i++)
    <img src="/uploads/images/star.png" />
    @endfor
  </span>
  @endif


  @if(count($word->level_base))


@foreach ($word->level_base as $levelbase)
    <span>{{$levelbase['level_bases']}}</span>
@endforeach

@endif

</div>

<div class="explain">
  @if(count($word->word_explain))
  <ul>
    <?php
$tmpcixing=array();
     ?>
    @foreach ($word->word_explain as $explain)
      <?php
        $tmpcixing[$explain['speech']->cixing][]=$explain['explain'];
        ?>
    @endforeach

    @foreach ($tmpcixing as $key => $cixing)
    <li>{{$key}} {{implode(",",$cixing)}}</li>
    @endforeach

  </ul>

@endif


</div>

</div>
  @endforeach

  <div class="row">
{!! $words->render() !!}
</div>
</div>
@stop
