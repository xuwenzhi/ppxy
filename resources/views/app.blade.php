<!DOCTYPE html>
@yield('html')
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>@yield('title') - PP校园</title>
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
	<meta name="_token" content="{{ csrf_token() }}" />
	<link href="{{ asset('/css/app.css') }}" rel="stylesheet" />
	<link href="{{ asset('/css/bootstrap.min.css') }}" rel="stylesheet" />
	<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
	<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
	<!--[if lt IE 9]>
		<script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
		<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
	<![endif]-->
	@yield('css')
	<script>
		var APP = "{{url('/')}}";
		var PUBLIC = "{{asset('/')}}";
	</script>
</head>
<body>
	<nav class="navbar navbar-default">
		<div class="container-fluid">
			<div class="navbar-header">
				<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
					<span class="sr-only">Toggle Navigation</span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>
				<a class="navbar-brand" href="{{ url('/') }}">PP校园</a>
			</div>

			<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
				<ul class="nav navbar-nav">
					<li><a href="{{ url('/') }}">首页</a></li>
				</ul>

				<ul class="nav navbar-nav">
					<li><a href="{{ url('/goods/find') }}">发现</a></li>
				</ul>

				<ul class="nav navbar-nav">
					<li><a href="{{ url('/goods/new') }}">我要发货</a></li>
				</ul>
				<ul class="nav navbar-nav navbar-right">
					@if (Auth::guest())
						<li><a href="{{ url('/auth/login') }}">登录</a></li>
						<li><a href="{{ url('/auth/register') }}">注册</a></li>
					@else
						<li class="dropdown">
							<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">{{ Auth::user()->name }} <span class="caret"></span></a>
							<ul class="dropdown-menu" role="menu">
								<!--<li><a href="{{ url('/people').'/'.Auth::user()->name  }}">个人中心</a></li> -->
								<li><a href="{{ url('/goods/mine') }}"><span class="glyphicon glyphicon-jpy" aria-hidden="true"></span>&nbsp;&nbsp;我的商品</a></li>
								<li><a href="{{ url('/setting') }}"><span class="glyphicon glyphicon-user" aria-hidden="true"></span>&nbsp;&nbsp;验证手机号</a></li>
								<li><a href="{{ url('/auth/logout') }}"><span class="glyphicon glyphicon-off" aria-hidden="true"></span>&nbsp;&nbsp;退出登录</a></li>
							</ul>
						</li>
					@endif
				</ul>
			</div>
		</div>
	</nav>

	@yield('content')
	<div id="footer" class="navbar-fixed-bottom">
	@yield('footer')
	2015 &copy; PP校园
	</div>
       
   
	<!-- Scripts -->
	<script src="{{ asset('/js/jquery.js')}}"></script>
    <script src="{{ asset('/js/bootstrap.min.js')}}"></script>
    <script src="{{ asset('/js/angular.js')}}"></script>
    @yield('js')
</body>
</html>
