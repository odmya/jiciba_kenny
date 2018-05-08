


<div layout="column" class="container">
  <div layout="row" >
    <div id="logo" flex="20"><a href="/" id="logo">记词吧</a></div>
    <div flex="60" layout-align="end start"> <a href="{{route('novelList')}}">英语小说</a></div>

    <div flex="20">

    </div>
  </div>

  <div layout="column">

    <form class="form-horizontal" method="post" action="{{ route('search') }}">
    <div layout="row" layout-align="center start">
      <div layout="column" flex="60">
        <input name="query" type="text" class="form-control " id="exampleInputAmount" placeholder="输入搜索的单词">
        {{ csrf_field() }}
      </div>

      <div layout="column">
        <button type="submit" class="btn btn-info"><span class="glyphicon glyphicon-search"></span> 搜索</button>
      </div>
    </div>
</form>

  </div>

</div>
