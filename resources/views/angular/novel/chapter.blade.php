@extends('angular.default')

@section('title', "怎么记忆单词")

@section('content')


<div ng-controller="rovelController" class="md-padding dialogdemoBasicUsage" id="popupContainer" ng-cloak="">


  <script type="text/ng-template" id="tabDialog.tmpl.html"><md-dialog aria-label="Mango (Fruit)">
  <form>
    <md-toolbar>
      <div class="md-toolbar-tools">
        <h2>@{{ words.word }}</h2>
        <span flex></span>
        <md-button class="md-icon-button" ng-click="cancel()">
          <md-icon md-svg-src="{{ asset('/images/ic_close_24px.svg') }}" aria-label="Close dialog"></md-icon>
        </md-button>
      </div>
    </md-toolbar>
    <md-dialog-content style="max-width:800px;max-height:810px; ">
      <md-tabs md-dynamic-height md-border-bottom>
        <md-tab label="基础知识">
          <md-content class="md-padding">
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


          </md-content>
        </md-tab>
        <md-tab label="记忆窍门" ng-disabled="words.tip.data.length==false">
          <md-content class="md-padding">
            <h1>Tips</h1>

            <p ng-init="tippraise =tip.praise" ng-repeat="tip in words.tip.data">@{{tip.tip}}  <img ng-click="like(tip.id)();" src="/uploads/images/like.jpg"> <span >@{{tip.praise}}</span></p>

          </md-content>
        </md-tab>
        <md-tab label="词根" ng-disabled="words.root.data.length==false">
          <md-content class="md-padding">
            <h1 class="md-display-2">Tab Three</h1>
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

          </md-content>
        </md-tab>
      </md-tabs>
    </md-dialog-content>

    <md-dialog-actions layout="row">
      <span flex></span>
      <md-button ng-click="answer('not useful')" >
        没有帮助
      </md-button>
      <md-button ng-click="answer('useful')" style="margin-right:20px;" >
        有帮助
      </md-button>
    </md-dialog-actions>
  </form>
</md-dialog>
</script>

@foreach ($chapters as $chapter)
<div layout="column">

<h3 layout="row">{{$chapter->name}}</h3>
<div layout="row"><div ng-mouseleave="mouseleaveEvent($event)" ng-mouseup="mouseUpEvent($event)"  ng-mousedown="mousedownEvent($event)" ng-touchstart="mousedownEvent($event)" ng-touchend="mouseUpEvent($event)"  >{!!$chapter->english!!}</a></div>
</div>
@endforeach

<div layout="row">
{!! $chapters->render() !!}
</div>

</div>
@stop
