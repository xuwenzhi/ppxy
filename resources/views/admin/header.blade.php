<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="utf-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1">
   <title>后台管理</title>
   <link href="{{ asset('/css/bootstrap.min.css') }}" rel="stylesheet" />
   <link href="{{ asset('/css/bootstrap-responsive.min.css') }}" rel="stylesheet" />
   <link href="{{ asset('/css/style.css') }}" rel="stylesheet" />
   <link href="{{ asset('/css/style-responsive.css') }}" rel="stylesheet" />
   <link href="{{ asset('/css/style-default.css') }}" rel="stylesheet" id="style_color" />
   @yield('Css')
</head>
<body class="fixed-top">
<div class="navbar navbar-inverse navbar-fixed-top">
    <div class="container">
      <div class="navbar-header">
        <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target=".navbar-collapse">
          <span class="sr-only">Toggle navigation</span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
        </button>
        <a class="navbar-brand" href="{{ url('/admin/') }}"><span class="glyphicon glyphicon-cloud" aria-hidden="true"></span>&nbsp;PP校园后台管理系统</a>
    </div>
          <!-- Collect the nav links, forms, and other content for toggling -->
    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
      <ul class="nav navbar-nav" id="my_nav">
        
      </ul>
      <ul class="nav navbar-nav navbar-right">
        <li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
            徐文志
          <span class="caret"></span></a>
          <ul class="dropdown-menu" role="menu">
            <li><a href="#">个人中心</a></li>
            <li><a href="{{ url('/auth/logout') }}">退出</a></li>
          </ul>
        </li>
      </ul>
    </div><!-- /.navbar-collapse -->
    </div>
</div>

      
   @yield('content')
   
   <div id="footer">
       2015 &copy; PP校园
   </div>
   <!-- Scripts -->
   
    <script src="{{ asset('/js/jquery.js')}}"></script>
    <script src="{{ asset('/js/bootstrap.min.js')}}"></script>
    @yield('js')
</body>
</html>

