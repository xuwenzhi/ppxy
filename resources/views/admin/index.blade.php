@extends('admin')
@section('Css')
@endsection
@section('content')
<div id="container">
      <div id="main-content">
         
         <div class="container-fluid">
               
            <div class="row-fluid">
               <div class="span12">
                   <h3 class="page-title">
                     控制台
                   </h3>
                   <ul class="breadcrumb">
                       <li>
                           <a href="#">首页</a>
                           <span class="divider"></span>
                       </li>                      
                       <li class="active">
                           控制台
                       </li>
                   </ul>
               </div>
            </div>

            <div class="row-fluid">
                
                <div class="metro-nav">
                    <div class="metro-nav-block nav-block-orange">
                        <a data-original-title="" href="#">
                            <i class="icon-user"></i>
                            <div class="info">321</div>
                            <div class="status">新增用户</div>
                        </a>
                    </div>
                    <div class="metro-nav-block nav-olive">
                        <a data-original-title="" href="#">
                            <i class="icon-tags"></i>
                            <div class="info">+970</div>
                            <div class="status">销售数据</div>
                        </a>
                    </div>
                    <div class="metro-nav-block nav-block-yellow">
                        <a data-original-title="" href="#">
                            <i class="icon-comments-alt"></i>
                            <div class="info">49</div>
                            <div class="status">用户评论</div>
                        </a>
                    </div>
                    <div class="metro-nav-block nav-block-green double">
                        <a data-original-title="" href="#">
                            <i class="icon-eye-open"></i>
                            <div class="info">+897</div>
                            <div class="status">UV</div>
                        </a>
                    </div>
                    <div class="metro-nav-block nav-block-red">
                        <a data-original-title="" href="#">
                            <i class="icon-bar-chart"></i>
                            <div class="info">+288</div>
                            <div class="status">更新</div>
                        </a>
                    </div>
                </div>
                <div class="metro-nav">
                    <div class="metro-nav-block nav-light-purple">
                        <a data-original-title="" href="#">
                            <i class="icon-shopping-cart"></i>
                            <div class="info">29</div>
                            <div class="status">新增订单</div>
                        </a>
                    </div>
                    <div class="metro-nav-block nav-light-blue double">
                        <a data-original-title="" href="#">
                            <i class="icon-tasks"></i>
                            <div class="info">$37624</div>
                            <div class="status">库存信息</div>
                        </a>
                    </div>
                    <div class="metro-nav-block nav-light-green">
                        <a data-original-title="" href="#">
                            <i class="icon-envelope"></i>
                            <div class="info">123</div>
                            <div class="status">消息</div>
                        </a>
                    </div>
                    <div class="metro-nav-block nav-light-brown">
                        <a data-original-title="" href="#">
                            <i class="icon-remove-sign"></i>
                            <div class="info">34</div>
                            <div class="status">取消订单</div>
                        </a>
                    </div>
                    <div class="metro-nav-block nav-block-grey ">
                        <a data-original-title="" href="#">
                            <i class="icon-external-link"></i>
                            <div class="info">$53412</div>
                            <div class="status">总利润</div>
                        </a>
                    </div>
                </div>
            </div>
      </div>
        
   </div>
 </div>                                  
@endsection

@section('js')
<script src="{{ asset('/js/jquery.nicescroll.js')}}" type="text/javascript"></script>
<script src="{{ asset('/js/jquery.slimscroll.min.js')}}"></script>
<script src="{{ asset('/js/common-scripts.js')}}"></script>
@endsection
