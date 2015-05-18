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
        <a class="navbar-brand" href="__APP__/index/index"><span class="glyphicon glyphicon-cloud" aria-hidden="true"></span>&nbsp;IT联盟信息平台</a>
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
            <li><a href="#">退出</a></li>
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
                      <li><a class="" href="general.html">所有用户</a></li>
                      <li><a class="" href="button.html">今日用户</a></li>
                      <li><a class="" href="slider.html">滑动</a></li>
                      <li><a class="" href="metro_view.html">Metro风格</a></li>
                      <li><a class="" href="tabs_accordion.html">Tab选项卡 & 手风琴</a></li>
                      <li><a class="" href="typography.html">文字排版</a></li>
                      <li><a class="" href="tree_view.html">树菜单</a></li>
                      <li><a class="" href="nestable.html">嵌套列表</a></li>
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
                      <span>表单</span>
                      <span class="arrow"></span>
                  </a>
                  <ul class="sub">
                      <li><a class="" href="form_layout.html">表单布局</a></li>
                      <li><a class="" href="form_component.html">表单组件</a></li>
                      <li><a class="" href="form_wizard.html">表单提示</a></li>
                      <li><a class="" href="form_validation.html">表单验证</a></li>
                      <li><a class="" href="dropzone.html">文件上传</a></li>
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
    
    @yield('js')
</body>
</html>

