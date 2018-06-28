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

    <div id="app-7">
      <ol>
        <!--
          现在我们为每个 todo-item 提供 todo 对象
          todo 对象是变量，即其内容可以是动态的。
          我们也需要为每个组件提供一个“key”，稍后再
          作详细解释。
        -->
        <todo-item
          v-for="item in groceryList"
          v-bind:todo="item"
          v-bind:key="item.id">
        </todo-item>
      </ol>
    </div>

    </div>


<script src="/js/jcibaController.js"></script>
</div>


</html>
