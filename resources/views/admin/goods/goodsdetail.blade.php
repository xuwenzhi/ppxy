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
                        
                    </h3>
                    <ul class="breadcrumb">
                       <li>
                           <a href="#">首页</a>
                           <span class="divider"></span>
                       </li>
                       <li class="active">
                           商品详情
                       </li>
                   </ul>
               </div>
            </div>

            <div class="row-fluid">
                <div class="widget blue">
                    <div class="widget-title">
                        <h4><i class="icon-reorder"></i>{{$title}}</h4>
                            <span class="tools">
                                <a href="javascript:;" class="icon-chevron-down"></a>
                                <a href="javascript:;" class="icon-remove"></a>
                            </span>
                    </div>
                    <div class="widget-body">
                        
                    </div>
                </div>
                </div>
            </div>
      </div>
</div>            
@endsection

@section('js')

@endsection
