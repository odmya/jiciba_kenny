@extends('layouts.default')

@section('title', "怎么记忆单词")

@section('content')


<div ng-controller="rovelController">
  <script type="text/ng-template" id="myModalContent.html">
    <div class="modal-header">
        <form class="form-horizontal" ng-submit="queryword()">
          <div class="form-group col-xs-11 col-sm-11 col-md-10 col-lg-11">

            <div class="input-group col-md-offset-3 col-lg-offset-3 col-sm-offset-3" >

              <input ng-model="query" type="text" class="form-control " size="100" id="exampleInputAmount" placeholder="输入搜索的单词">
              {{ csrf_field() }}
            </div>
          </div>

          <div class="form-group col-xs-1 col-sm-1 col-md-1 col-lg-1">
              <div class="col-sm-offset-1 ">
                <button type="submit" class="btn btn-info"><span class="glyphicon glyphicon-search"></span> 搜索</button>
              </div>
            </div>

        </form>
    </div>
    <div class="modal-body" ng-show="sentences">
      <div uib-collapse="isCollapsed">


      <ul>
        <li ng-repeat="item in sentences.data"><div><p ng-mouseleave="mouseleaveEvent()" ng-mouseup="mouseUpEvent()"  ng-mousedown="mousedownEvent()" ng-bind-html="item.english | highlight:search"></p><p>@{{item.chinese}}</p><p>@{{item.quote}}</p></div></li>
      </ul>


      <div id="page">
        <div uib-pagination ng-change="sentencespage()" total-items="totalItems" ng-model="currentPage" max-size="maxSize"  first-text="第一页" previous-text="上一页" next-text="下一页" last-text="最后页" boundary-links="true" boundary-link-numbers="true"></div>

    </div>
    </div>
    </div>
    <div class="modal-body" ng-show="words">
      <div id="overview">
          <h1 >@{{ words.word }}</h1>
        <div id="voice">

          <div ng-repeat="voice in words.voice.data">@{{ voice.symbol}}
            <img src="/uploads/images/sound.png"  ng-click="playvoice(voice.path)"/>
          </div>
        </div>
        <div class="level " ng-show="words.level_star">
            <div><a href=""><span class="@{{ words.level_star }}" ng-repeat="ls in level_star"><img src="/uploads/images/star.png" /></span> </a><span ng-repeat="level in words.level.data">@{{level.level_base}}</span></div>

        </div>

        <div id="explain"><ul>

         <li ng-repeat="(key, explain) in words.explain.data.explain">@{{key}}, @{{explain}}</li>

        </ul>
        </div>
      </div>

      <div id="tips" ng-show="words.tip.data.length">
        <h3>Tips</h3>

        <p ng-init="tippraise =tip.praise" ng-repeat="tip in words.tip.data">@{{tip.tip}}  <img ng-click="like(tip.id)();" src="/uploads/images/like.jpg"> <span >@{{tip.praise}}</span></p>
      </div>



      <div id="cixing" ng-show="words.root.data.length">
        <hr>
        <h3>词根</h3>
        <ul>
        <li>
          <div class="root_word" ng-repeat="rootword in words.root.data">
            <div>
                <p ng-if="rootword.root_alias !=null" ><a href="/cigen/@{{rootword.root_id}}" >@{{rootword.root_alias}}</a></p>
                <p ng-if="rootword.root_alias ==null"><a href="/cigen/@{{rootword.root_id}}">@{{rootword.root}}</a></p>
                <p ng-bind-html="rootword.detail|trust2Html"></p>

                <div ng-bind-html="rootword.root_description|trust2Html"></div>
            </div>
          </div>
        </li>
      </ul>
        </div>

    </div>
    <div class="modal-footer">
      <button class="btn btn-primary" type="button" ng-click="cancel()">OK</button>
  </div>
  </script>


@foreach ($chapters as $chapter)
<div class="row">

<h3>{{$chapter->name}}</h3>
<div ><div ng-mouseleave="mouseleaveEvent()" ng-mouseup="mouseUpEvent()"  ng-mousedown="mousedownEvent()" >{!!$chapter->english!!}</a></div>
</div>
@endforeach

<div class="row">
{!! $chapters->render() !!}
</div>

</div>
@stop
