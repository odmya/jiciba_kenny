
@extends('layouts.default')

@section('title', "怎么记忆单词")

@section('content')

<script>

angular.module("myApp").constant("WORD_STAR", "{!! $star !!}");

</script>
<style type="text/css">

.starbackgound{
  background-image: url("/uploads/images/star.png");
  background-repeat: repeat-x;
}
.star5{
  width:68px;
  height:20px;
}

.star4{
  width:56px;
  height:20px;
}

.star3{
  width:43px;
  height:20px;
}

.star2{
  width:29px;
  height:20px;
}

.star1{
  width:15px;
  height:20px;
}

</style>
<div  ng-controller="rootController">

  <div class="row" ng-repeat="word in words">

    <div >
      <div class="col-xs-2"> <a href="/query/@{{word.word}}">@{{word.word}}</a> <div ng-repeat="voice in word.voice.data">@{{ voice.symbol}}
        <img src="/uploads/images/sound.png"  ng-click="playvoice(voice.path)"/>
      </div></div><div class="col-xs-2"> <div class="starbackgound star@{{word.level_star}}">  </div> </div>
      <div class="col-xs-8"><span ng-repeat="level in word.level.data">@{{level.level_base}}</span> </div>

      <div class="col-xs-12" id="explain"><ul>

       <li ng-repeat="(key, explain) in word.explain.data.explain">@{{key}}, @{{explain}}</li>

      </ul>
      </div>
    </div>
  </div>
<div class="row">
<div uib-pagination ng-change="starpages()" total-items="totalItems" ng-model="currentPage" max-size="maxSize"  first-text="第一页" previous-text="上一页" next-text="下一页" last-text="最后页" boundary-links="true" boundary-link-numbers="true"></div>


</div>
</div>
@stop
