@extends('admin.default')
@section('title', '单词列表')

@section('content')
<div class="col-md-offset-2 col-md-8">
  <h1>单词列表</h1>
  <table class="table table-striped">
    <tr><td>单词</td><td>发音</td><td>星级</td><td>等级</td><td>解释</td></tr>

    @foreach ($word as $perword)
      <tr><td>{{ $perword->word }}</td>
      <td>
      @foreach ($perword->word_voice()->get() as $voice)
      {{ $voice->symbol }}
@if ($voice->path)
      <audio controls="controls">
        <source src="{{URL::asset('voice/word/'.$voice->path)}}" type="audio/mpeg" />
      Your browser does not support the audio element.
      </audio>
@endif
      @endforeach
    </td>
      <td>{{ $perword->level_star }}</td>
      <td>
        @foreach ($perword->level_base()->get() as $levelbase)
        {{ $levelbase->level_bases }}
        @endforeach
        </td>
      <td>  @foreach ($perword->word_explain()->get() as $explain)
       {{ $explain->explain }}

        @endforeach</td></tr>
    @endforeach
</table>

  {!! $word->render() !!}
<div>

</div>
</div>
@stop
