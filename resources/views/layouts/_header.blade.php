

<header class="navbar navbar-default ">
  <div class="container">

    <nav class="navbar navbar-default" role="navigation">
        <div class="container-fluid">
        <div class="navbar-header " id="logo">
            <a href="/" id="logo">记词吧</a>
        </div>
        <div>
            <ul class="nav navbar-nav">
              <li><a href="{{route('novelList')}}">英语小说</a></li>
              @if (Auth::check())
              @if(Auth::user()->is_admin)
                <li><a href="{{ route('users.index') }}">用户列表</a></li>
                @endif
                <li class="dropdown">
                  <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                    {{ Auth::user()->name }} <b class="caret"></b>
                  </a>
                  <ul class="dropdown-menu">
                    <li><a href="{{ route('users.show', Auth::user()->id) }}">个人中心</a></li>
                    <li><a href="{{ route('users.edit', Auth::user()->id) }}">编辑资料</a></li>
                    <li class="divider"></li>
                    <li>
                      <a id="logout" href="#">
                        <form action="{{ route('logout') }}" method="POST">
                          {{ csrf_field() }}
                          {{ method_field('DELETE') }}
                          <button class="btn btn-block btn-danger" type="submit" name="button">退出</button>
                        </form>
                      </a>
                    </li>
                  </ul>
                </li>
              @else
                <li><a href="{{ route('help') }}">帮助</a></li>
                <li><a href="{{ route('login') }}">登录</a></li>
              @endif
            </ul>
        </div>
        </div>
    </nav>


    <div class=" text-center row">
      <form class="form-horizontal" method="post" action="{{ route('search') }}">
        <div class="form-group col-xs-11 col-sm-11 col-md-10 col-lg-11">

          <div class="input-group col-md-offset-3 col-lg-offset-3 col-sm-offset-3" >

            <input name="query" type="text" class="form-control " size="100" id="exampleInputAmount" placeholder="输入搜索的单词">
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


  </div>

</header>
