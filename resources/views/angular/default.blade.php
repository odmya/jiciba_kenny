<html lang="en">
<head>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!-- Angular Material style sheet -->

  <link href="{{ asset('/js/angular/1.6.9/angular-material.min.css') }}"  rel="stylesheet" type="text/css">
  <link rel="stylesheet" href="/css/app.css" type="text/css">
    <link href="{{ asset('/css/jciba.css') }}"  rel="stylesheet" type="text/css">
  <script src="{{ asset('/js/angular/1.6.9/angular.min.js') }}"></script>
  <script src="{{ asset('/js/angular/1.6.9/angular-animate.min.js') }}"></script>
  <script src="{{ asset('/js/angular/1.6.9/angular-aria.min.js') }}"></script>
  <script src="{{ asset('/js/angular/1.6.9/angular-messages.min.js') }}"></script>
  <script src="{{ asset('/js/angular/1.6.9/angular-material.min.js') }}"></script>

<script src="{{ asset('/js/angular/ngTouch.min.js') }}"></script>
<script src="{{ asset('/js/jcibaService.js') }}"></script>
  <script src="{{ asset('/js/jciba.js') }}"></script>


</head>

<body ng-app="myApp" ng-cloak>

  @include('angular._header')

<div layout="row" class="container">

      @include('shared._messages')
      @yield('content')
      @include('angular._footer')
</div>


</body>

</html>
