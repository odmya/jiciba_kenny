<!doctype html>
<html lang="{{ app()->getLocale() }}" ng-app="myApp">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>@yield('title', '记词吧')</title>
    <meta name="description" content="@yield('description', '记词吧记词吧')" />
    <link rel="stylesheet" href="/css/app.css">

    <script src="/js/angular/angular.js"></script>
        <script src="/js/app.js"></script>

<style>
input.ng-invalid {
   background-color: lightblue;
}
</style>

  </head>
   <body>




    @include('layouts._header')

    <div class="container">
      <div class="col-md-offset-1 col-md-10 ">
        <p>词汇</p>
        <ul>
          @foreach ($level_bases as $levelbase)
          <li><a href="{{ route('wrodlist',$levelbase->id) }}">{{$levelbase->level_bases}}</a></li>
          @endforeach
        </ul>



        @include('layouts._footer')
      </div>
    </div>

<script src="/js/jcibaController.js"></script>
</html>
