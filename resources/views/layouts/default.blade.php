<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>@yield('title', '记词吧')</title>
    <link rel="stylesheet" href="/css/app.css">

    <!-- MetisMenu CSS -->
    <link href="css/plugins/metisMenu/metisMenu.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="css/sb-admin-2.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="font-awesome-4.1.0/css/font-awesome.min.css" rel="stylesheet" type="text/css">

  </head>
  <body>
    @include('layouts._header')

    <div class="container">
      <div class="col-md-offset-1 col-md-10">



<form class="form-inline" method="post" action="{{ route('search') }}">
  <div class="form-group">

    <div class="input-group">

      <input name="query" type="text" class="form-control" id="exampleInputAmount" placeholder="输入搜索的单词">
      {{ csrf_field() }}
    </div>
  </div>

  <button type="submit" class="btn btn-primary">搜索</button>
</form>

        @include('shared._messages')
        @yield('content')
        @include('layouts._footer')
      </div>
    </div>

    <script src="/js/app.js"></script>
    <script src="js/plugins/metisMenu/metisMenu.min.js"></script>

<!-- Custom Theme JavaScript -->
<script src="js/sb-admin-2.js"></script>

  </body>


</html>
