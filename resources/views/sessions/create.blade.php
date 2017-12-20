<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>@yield('title', 'Sample App')</title>
    <link rel="stylesheet" href="/css/app.css">

    <!-- MetisMenu CSS -->
    <link href="css/plugins/metisMenu/metisMenu.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="css/sb-admin-2.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="font-awesome-4.1.0/css/font-awesome.min.css" rel="stylesheet" type="text/css">

  </head>
  <body>


    <div class="container">
      <div class="row">
          <div class="col-md-4 col-md-offset-4">
              <div class="login-panel panel panel-default">
                  <div class="panel-heading">
                      <h3 class="panel-title">Please Sign In</h3>
                  </div>
                  <div class="panel-body">
                      {!!Form::open(array('route' => 'login','method'=> "POST",'enctype'=>"multipart/form-data"))!!}
                          <fieldset>
                              <div class="form-group">
                                {!! Form::email('email', $value = '', $attributes = array('class'=>'form-control','placeholder'=>'E-mail')) !!}

                              </div>
                              <div class="form-group">
                                {!! Form::password('password', array('class' => 'form-control','placeholder'=>'password')) !!}

                              </div>
                              <div class="checkbox">
                                  <label>
                                      {!! Form::checkbox('remember', 'Remember Me', true) !!} Remember Me

                                  </label>
                              </div>
                              <!-- Change this to a button or input when using this as a form -->
                            

                              {!! Form::submit('Login',array('class'=>'btn btn-lg btn-success btn-block')) !!}
                          </fieldset>
                      </form>
                  </div>
              </div>
          </div>
      </div>
  </div>


    <script src="/js/app.js"></script>
    <script src="js/plugins/metisMenu/metisMenu.min.js"></script>

<!-- Custom Theme JavaScript -->
<script src="js/sb-admin-2.js"></script>

  </body>


</html>
