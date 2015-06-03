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

                        @foreach ($photos as $photo)
                            <div class="row">
                                <div class="col-sm-6 col-md-4">
                                <div class="thumbnail">
                                  <img src="{{$photo->address}}" data-toggle="modal" data-target="#goodsPhotoDia{{$photo->id}}" type="button" alt="...">
                                </div>
                                </div>
                            </div>
                            <!-- 模态弹出窗内容 -->
                            <div class="modal fade" id="goodsPhotoDia{{$photo->id}}" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">

                                        <div class="modal-body">
                                            <p>{{$photo->address}}</p>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
                </div>
            </div>
      </div>
</div>            
@endsection

@section('js')

@endsection
