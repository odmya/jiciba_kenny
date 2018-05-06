@extends('layouts.default')

@section('title', "怎么记忆单词")

@section('content')


<div  ng-controller="mainController">

<h1>{{$novel->name}}</h1>
<div>章节</div>
@foreach ($novel->novel_chapter as $key=>$chapter)
<div class="row">

<div><a href="{{route('novelChapter',[$novel->id])}}?page={{$key+1}}">{{$chapter->name}}</a></div>

</div>
@endforeach

</div>
@stop
