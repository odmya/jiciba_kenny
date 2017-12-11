@extends('layouts.default')
@section('title', '单词列表')

@section('content')
<div class="col-md-offset-2 col-md-8">
  <h1>单词列表</h1>
  <ul class="users">
    @foreach ($word as $perword)
      <div>{{ $perword->word }}</div>
    @endforeach
  </ul>

  {!! $word->render() !!}
<div>
  <script>
  function jumpurl(){
    location='{{$nextpageurl}}';
  }
  setTimeout('jumpurl()',2000);
  </script>
</div>
</div>
@stop
