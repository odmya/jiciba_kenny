@extends('layouts.default')

@section('title', "词根".$root_obj->name)

@section('content')


<div class="col-md-offset-2 col-md-8" ng-controller="cigenController">
<h1 >@{{ roots.root_obj.name }}</h1>
<div ng-bind-html="roots.root_obj.description | trust2Html"></div>

<div class="wordlist" ng-repeat="(key, root_cixing) in roots.array_rootcixing">

<div>
  <p>@{{key}} @{{root_cixing.description}}</p>
  <ul>
    <li ng-repeat="word in root_cixing.wordlist"><p><a href="/query/@{{word.word}}">@{{word.word}}</a>  @{{word.explain}} </p><p>@{{word.detail}}</p></li>
  </ul>
</div>

</div>

</div>
@stop
