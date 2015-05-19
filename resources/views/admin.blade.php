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
        <a class="navbar-brand" href="__APP__/index/index"><span class="glyphicon glyphicon-cloud" aria-hidden="true"></span>&nbsp;PP校园后台管理系统</a>
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

      <div class="sidebar-scroll">
        <div id="sidebar" class="nav-collapse">
         <div class="navbar-inverse">
            <form class="navbar-search visible-phone">
               <input type="text" class="search-query" placeholder="Search" />
            </form>
         </div>
          <ul class="sidebar-menu">
              <li class="sub-menu active">
                  <a class="" href="{{ url('/admin') }}">
                      <i class="icon-dashboard"></i>
                      <span>控制台</span>
                  </a>
              </li>
              <li class="sub-menu">
                  <a href="javascript:;" class="">
                      <i class="icon-book"></i>
                      <span>用户中心</span>
                      <span class="arrow"></span>
                  </a>
                  <ul class="sub">
                      <li><a class="" href="{{url('/aduser/all')}}">所有用户</a></li>
                      <li><a class="" href="{{url('/aduser/today')}}">今日用户</a></li>
                      <li><a class="" href="{{url('/aduser/member')}}">已认证用户</a></li>
                      <li><a class="" href="{{url('/aduser/pending')}}">未认证用户</a></li>
                  </ul>
              </li>
              <li class="sub-menu">
                  <a href="javascript:;" class="">
                      <i class="icon-cogs"></i>
                      <span>订单</span>
                      <span class="arrow"></span>
                  </a>
                  <ul class="sub">
                      <li><a class="" href="calendar.html">所有订单</a></li>
                      <li><a class="" href="grids.html">最新订单</a></li>
                      <li><a class="" href="chartjs.html">今日订单</a></li>
                      <li><a class="" href="flot_chart.html">Flot图表</a></li>
                      <li><a class="" href="gallery.html">相册</a></li>
                  </ul>
              </li>
              <li class="sub-menu">
                  <a href="javascript:;" class="">
                      <i class="icon-tasks"></i>
                      <span>商品</span>
                      <span class="arrow"></span>
                  </a>
                  <ul class="sub">
                      <li><a class="" href="{{url('/adgoods/all')}}">所有</a></li>
                      <li><a class="" href="{{url('/adgoods/deal')}}">已成交</a></li>
                      <li><a class="" href="{{url('/adgoods/newbie')}}">待审核</a></li>
                      <li><a class="" href="{{url('/adgoods/hide')}}">已隐藏</a></li>
                      <li><a class="" href="{{url('/adgoods/close')}}">已关闭</a></li>
                  </ul>
              </li>
              <li class="sub-menu">
                  <a href="javascript:;" class="">
                      <i class="icon-th"></i>
                      <span>数据表格</span>
                      <span class="arrow"></span>
                  </a>
                  <ul class="sub">
                      <li><a class="" href="basic_table.html">简单表格</a></li>
                      <li><a class="" href="dynamic_table.html">动态表格</a></li>
                      <li><a class="" href="editable_table.html">可编辑表格</a></li>
                  </ul>
              </li>
              <li class="sub-menu">
                  <a href="javascript:;" class="">
                      <i class="icon-fire"></i>
                      <span>Icon图标</span>
                      <span class="arrow"></span>
                  </a>
                  <ul class="sub">
                      <li><a class="" href="font_awesome.html">FontAwesome图标</a></li>
                      <li><a class="" href="glyphicons.html">Glyphicons图标</a></li>
                  </ul>
              </li>
              <li class="sub-menu">
                  <a class="" href="javascript:;">
                      <i class="icon-trophy"></i>
                      <span>代码片段</span>
                      <span class="arrow"></span>
                  </a>
                  <ul class="sub">
                      <li><a href="general_portlet.html" class="">通用片段</a></li>
                      <li><a href="draggable_portlet.html" class="">可拖拽片段</a></li>
                  </ul>
              </li>
              <li class="sub-menu">
                  <a class="" href="javascript:;">
                      <i class="icon-map-marker"></i>
                      <span>地图</span>
                      <span class="arrow"></span>
                  </a>
                  <ul class="sub">
                      <li><a href="vector_map.html" class="">Vector地图</a></li>
                      <li><a href="google_map.html" class="">Google地图</a></li>
                  </ul>
              </li>
              <li class="sub-menu">
                  <a href="javascript:;" class="">
                      <i class="icon-file-alt"></i>
                      <span>基本页面</span>
                      <span class="arrow"></span>
                  </a>
                  <ul class="sub">
                      <li><a class="" href="blank.html">空白页面</a></li>
                      <li><a class="" href="blog.html">博客</a></li>
                      <li><a class="" href="timeline.html">时间轴</a></li>
                      <li><a class="" href="profile.html">个人资料</a></li>
                      <li><a class="" href="about_us.html">关于我们</a></li>
                      <li><a class="" href="contact_us.html">联系我们</a></li>
                  </ul>
              </li>
              <li class="sub-menu">
                  <a href="javascript:;" class="">
                      <i class="icon-glass"></i>
                      <span>其他</span>
                      <span class="arrow"></span>
                  </a>
                  <ul class="sub">
                      <li><a class="" href="lock.html">锁屏</a></li>
                      <li><a class="" href="invoice.html">购物单</a></li>
                      <li><a class="" href="pricing_tables.html">价目单</a></li>
                      <li><a class="" href="search_result.html">搜索展示</a></li>
                      <li><a class="" href="faq.html">帮助页面</a></li>
                      <li><a class="" href="404.html">404错误页面</a></li>
                      <li><a class="" href="500.html">500错误页面</a></li>
                  </ul>
              </li>

              <li>
                  <a class="" href="login.html">
                    <i class="icon-user"></i>
                    <span>登录页面</span>
                  </a>
              </li>
          </ul>
         
      </div>
      </div>
   @yield('content')
   
   <div id="footer">
       2015 &copy; PP校园
   </div>
   <!-- Scripts -->
   
    <script src="{{ asset('/js/jquery.js')}}"></script>
    <script src="{{ asset('/js/bootstrap.min.js')}}"></script>
    <script src="{{ asset('js/dynamic-table.js')}}"></script>
    <script src="{{ asset('/js/jquery.nicescroll.js')}}" type="text/javascript"></script>
    <script src="{{ asset('/js/jquery.slimscroll.min.js')}}"></script>
    <script src="{{ asset('/js/common-scripts.js')}}"></script>
    @yield('js')
</body>
</html>

