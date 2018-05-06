@extends('layouts.default')

@section('title', "怎么记忆单词")

@section('content')


<div  ng-controller="mainController">


  @foreach ($novels as $novel)
  <div class="row">

<div><a href="{{route('novelShow',$novel->id)}}">{{$novel->name}}</a></div>
<div>{!!$novel->description!!}</a></div>
</div>
  @endforeach

  <div class="row">
{!! $novels->render() !!}
</div>
</div>
@stop
