@extends('layouts.default')

@section('title', $seo_meta['title'])

@section('description', $seo_meta['description'])


@section('content')

<script>angular.module("myApp").constant("QUERY_WORD", "{!! $word_obj->word !!}");</script>

<div  ng-controller="mainController">

  <div class="row">

            <div class="col-xs-3  sidebar hidden-xs" id="myScrollspy" >

              <div  bs-affix data-offset-top="200" data-offset-bottom="300" style="width:250px;">
                <ul class=" nav nav-tabs nav-stacked"  >
                    <li spy="overview" bs-affix> <a  ng-click="scrollTo('overview')">基础</a></li>
                    <li ng-show="{{count($word_obj->tip)}}" spy="tips"> <a ng-click="scrollTo('tips')">小贴士</a></li>
                    <li ng-show="words.root.data.length" spy="cixing"> <a ng-click="scrollTo('cixing')">词根</a></li>
                    <li ng-show="{{count($sentences)}}" spy="sentences" ><a ng-click="scrollTo('sentences')">例句</a></li>
                </ul>

                <img src="https://www.jciba.cn/uploads/images/minijciba.jpg"/>
                <p style="text-align:center;">欢迎使用微信小程序</p>
              </div>

          </div>
          <div class="col-xs-9  main-container" bs-affix-target>





              <div id="overview" class="row">
                <div class="col-sm-6 col-md-6 col-lg-6 col-xs-12">
                  <h1 >{{ $word_obj->word }}</h1>
                <div id="voice">

                  <div ng-repeat="voice in words.voice.data">@{{ voice.symbol}}
                    <img src="/uploads/images/sound.png"  ng-click="playvoice(voice.path)"/>
                  </div>
                </div>
                <div class="level " >
                    <div><a href="{{route('querystar',str_replace('star','',$word_obj->level_star))}}" ng-show="words.level_star"><span class="@{{ words.level_star }}" ng-repeat="ls in level_star">
                      <img src="/uploads/images/star.png" /></span> </a>
                      @foreach ($word_obj->level as $level)

                        <span>{{$level->level_bases}}</span>

                      @endforeach
                    </div>

                </div>

                <div id="explain"><ul>

                  @foreach ($explain_array as $key => $explain)
                    <li>{{$key}} {{implode(',',$explain)}}</li>
                  @endforeach


                </ul>
                </div>
              </div>
                <div class="col-sm-6 col-md-6 col-lg-6 col-xs-12">

                  <div class="carousel slide">

                    <!-- 轮播图片 -->
                    <div class="carousel-inner">
                      @foreach ($word_obj->word_image as $key => $wordimage)
                      @if($key==0)
                        <div class="item active" >
                      @else
                        <div class="item">
                      @endif

                          <img src="/uploads/images/words/{{$wordimage->image}}">
                        </div>
                      @endforeach
                    </div>

                  </div>

                </div>
              </div>

              <div id="tips" ng-show="{{count($word_obj->tip)}}">
                <h3>Tips</h3>

                  @foreach ($word_obj->tip as $tip)

                    <p >{{$tip->tip}} </p>

                  @endforeach
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



              <div id="sentences" ng-show="{{count($sentences)}}" >
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
                  @foreach ($sentences as $sentence)
                    <li><div><p >{{$sentence->english}}</p><p>{{$sentence->chinese}}</p><p>{{$sentence->quote}}</p></div></li>
                  @endforeach
                </ul>


                <div id="page">

              </div>
              </div>

            </div>

          </div>
      </div>
</div>






@stop
