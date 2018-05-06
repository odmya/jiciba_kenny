@extends('layouts.default')

@section('title', $word_obj->word.", 怎么记忆单词".$word_obj->word)

@section('content')

<script>angular.module("myApp").constant("QUERY_WORD", "{!! $word_obj->word !!}");</script>





<div  ng-controller="mainController">



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
              <div><a href="{{route('querystar',str_replace('star','',$word_obj->level_star))}}"><span class="@{{ words.level_star }}" ng-repeat="ls in level_star"><img src="/uploads/images/star.png" /></span> </a><span ng-repeat="level in words.level.data">@{{level.level_base}}</span></div>

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




  <div class="row">

            <div class="col-xs-3 sidebar hidden-xs" id="myScrollspy" >

              <div  bs-affix data-offset-top="200" data-offset-bottom="300" style="width:250px;">
                <ul class=" nav nav-tabs nav-stacked"  >
                    <li spy="overview" bs-affix> <a  ng-click="scrollTo('overview')">基础</a></li>
                    <li ng-show="words.tip.data.length" spy="tips"> <a ng-click="scrollTo('tips')">小贴士</a></li>
                    <li ng-show="words.root.data.length" spy="cixing"> <a ng-click="scrollTo('cixing')">词根</a></li>
                    <li ng-show="sentences.data.length" spy="sentences" ><a ng-click="scrollTo('sentences')">例句</a></li>
                </ul>
              </div>

          </div>
          <div class="col-xs-9 main-container" bs-affix-target>





              <div id="overview">
                  <h1 >@{{ words.word }}</h1>
                <div id="voice">

                  <div ng-repeat="voice in words.voice.data">@{{ voice.symbol}}
                    <img src="/uploads/images/sound.png"  ng-click="playvoice(voice.path)"/>
                  </div>
                </div>
                <div class="level " ng-show="words.level_star">
                    <div><a href="{{route('querystar',str_replace('star','',$word_obj->level_star))}}"><span class="@{{ words.level_star }}" ng-repeat="ls in level_star"><img src="/uploads/images/star.png" /></span> </a><span ng-repeat="level in words.level.data">@{{level.level_base}}</span></div>

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



              <div id="sentences" ng-show="sentences.data.length" >
                <hr>
                <div class="row">
                  <p class="col-xs-3" > 例句</p>
                  <p ng-bind-html="search_result"></p>
                  <div id="search_result" ng-show="frameShow" ng-bind-html="word_search_result" style="border:1px solid red;"></div>
                  <p class="col-xs-6"></p>
                    <p class="col-xs-3" ng-click="isCollapsed = !isCollapsed"><span class="glyphicon glyphicon-align-justify"></span></p>
                </div>
                <div uib-collapse="isCollapsed">


                <ul>
                  <li ng-repeat="item in sentences.data"><div><p ng-mouseleave="mouseleaveEvent()" ng-mouseup="mouseUpEvent()"  ng-mousedown="mousedownEvent()" ng-bind-html="item.english | highlight:search"></p><p>@{{item.chinese}}</p><p>@{{item.quote}}</p></div></li>
                </ul>


                <div id="page">
                  <div uib-pagination ng-change="sentencespage()" total-items="totalItems" ng-model="currentPage" max-size="maxSize"  first-text="第一页" previous-text="上一页" next-text="下一页" last-text="最后页" boundary-links="true" boundary-link-numbers="true"></div>

              </div>
              </div>

            </div>

          </div>
      </div>
</div>






@stop
