<!DOCTYPE html>
@yield('html')
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
	<meta name="renderer" content="webkit">
	<meta name="_token" content="{{ csrf_token() }}" />
	<title>@yield('title')   PP校园 - 最贴心的校园交易平台</title>
	<link rel="shortcut icon" href="{{asset('/images/favicon.ico')}}" type="image/x-icon" />
	<link href="{{ asset('/css/app.css') }}" rel="stylesheet" />
	<link href="{{ asset('/css/bootstrap.min.css') }}" rel="stylesheet" media="all" />
	<!--[if lt IE 9]>
	  <script src="http://cdn.bootcss.com/html5shiv/3.7.0/html5shiv.min.js"></script>
	  <script src="http://cdn.bootcss.com/respond.js/1.3.0/respond.min.js"></script>
	<![endif]-->
	@yield('css')
	<script>
		var APP = "{{url('/')}}";
		var PUBLIC = "{{asset('/')}}";
	</script>
</head>
<body>
	<nav class="navbar navbar-default navbar-fixed-top">
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
					<li><a href="{{ url('/goods/new') }}">我要发货</a></li>
				</ul>
				<ul class="nav navbar-nav">
					<li><a href="{{ url('/about') }}">关于我们</a></li>
				</ul>
				<ul class="nav navbar-nav">
					<li class="dropdown">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">敬请期待<span class="caret"></span></a>
						<ul class="dropdown-menu" role="menu">
							<li><a href="#"><span class="glyphicon glyphicon-lock" aria-hidden="true"></span>&nbsp;&nbsp;<del>爱心捐赠</del></a></li>
						</ul>
					</li>
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
								<li><a href="{{ url('/goods/mine') }}"><span class="glyphicon glyphicon-gift" aria-hidden="true"></span>&nbsp;&nbsp;我的商品</a></li>
								<!--<li><a href="{{ url('/order/mine') }}"><span class="glyphicon glyphicon-jpy" aria-hidden="true"></span>&nbsp;&nbsp;我的订单</a></li>-->
								<li><a href="{{ url('/verify/default') }}"><span class="glyphicon glyphicon-user" aria-hidden="true"></span>&nbsp;&nbsp;验证手机号</a></li>
								<li><a href="{{ url('/auth/logout') }}"><span class="glyphicon glyphicon-off" aria-hidden="true"></span>&nbsp;&nbsp;退出登录</a></li>
							</ul>
						</li>
					@endif
				</ul>
			</div>
		</div>
	</nav>
	<br/><br/><br/>
	@yield('content')
	<br/>
	<div id="footer" class="navbar-fixed-bottom">
		<img src="{{asset('/images/loading_default.gif')}}" style="display:none;"/>
		<span id="load" class="text-center" style="display:none;"></span>
	@yield('footer')
	2015 &copy; PP校园
	</div>
	<script src="{{ asset('/js/jquery.js')}}"></script>
    <script src="{{ asset('/js/bootstrap.min.js')}}"></script>
    @yield('js')
</body>
</html>
