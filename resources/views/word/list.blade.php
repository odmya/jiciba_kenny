@extends('layouts.default')
@section('title', '单词列表')

@section('content')
<div class="col-md-offset-2 col-md-8">
  <h1>单词列表</h1>
  <ul class="users">
    @foreach ($words as $perword)
      <div>{{ $perword->word }}</div>
    @endforeach
  </ul>

<div>
  <script>
  function jumpurl(){

    location='{{(env("APP_URL"))}}/ciba/list';
  }
  setTimeout('jumpurl()',3000);
  </script>
</div>
</div>
@stop
