<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>@yield('title', 'Sample App')</title>
    <link rel="stylesheet" href="{{URL::asset('css/app.css')}}">

    <!-- MetisMenu CSS -->
    <link href="{{URL::asset('css/plugins/metisMenu/metisMenu.min.css')}}" rel="stylesheet">

      <!-- Timeline CSS -->
      <link href="{{URL::asset('css/plugins/timeline.css')}}" rel="stylesheet">

      <!-- Custom CSS -->
      <link href="{{URL::asset('css/sb-admin-2.css')}}" rel="stylesheet">

      <!-- Morris Charts CSS -->
      <link href="{{URL::asset('css/plugins/morris.css')}}" rel="stylesheet">

      <!-- Custom Fonts -->
      <link href="{{URL::asset('font-awesome-4.1.0/css/font-awesome.min.css')}}" rel="stylesheet" type="text/css">

      <script src="{{URL::asset('/js/app.js')}}"></script>
      <script src="{{URL::asset('js/plugins/metisMenu/metisMenu.min.js')}}"></script>

  <!-- Custom Theme JavaScript -->
  <script src="{{URL::asset('js/sb-admin-2.js')}}"></script>

  </head>
  <body>
<div id="wrapper" class="container">
@include('admin._header')

<div id="page-wrapper">
  @yield('content')
</div>

</div>


  </body>


</html>
