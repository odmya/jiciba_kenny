<!doctype html>
<html lang="{{ app()->getLocale() }}" ng-app="myApp">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="fragment" content="!">
<meta name="prerender-status-code" content="404">
    <title>@yield('title', '记词吧')</title>
    <link rel="stylesheet" href="/css/app.css">



    <!-- Custom Fonts -->
    <link href="{{ asset('font-awesome-4.1.0/css/font-awesome.min.css') }}"  rel="stylesheet" type="text/css">


<script src="{{ asset('/js/angular/angular.min.js') }}"></script>
<script src="{{ asset('/js/angular/angular-sanitize.min.js') }}"></script>
<script src="{{ asset('/js/angular/angular-animate.min.js') }}"></script>
<script src="{{ asset('/js/angular/ngTouch.min.js') }}"></script>

<script src="{{ asset('/js/angular-ui-bootstrap/dist/ui-bootstrap-tpls.js') }}"></script>

<script src="{{ asset('/js/angular/angular-jquery.min.js') }}"></script>
<script src="{{ asset('/js/angular/angular-bootstrap-affix.min.js') }}"></script>




        <script src="{{ asset('/js/jcibaService.js') }}"></script>
        <script src="{{ asset('/js/jcibaController.js') }}"></script>
        <script src="{{ asset('/js/jcibaApp.js') }}"></script>
<script>angular.module("myApp").constant("CSRF_TOKEN", '{{ csrf_token() }}');</script>


  </head>
  <body>
    @include('layouts._header')

    <div class="container">





        @include('shared._messages')
        @yield('content')
        @include('layouts._footer')

    </div>


  </body>


</html>
