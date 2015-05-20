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
                           商品列表
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
                        <table class="table table-striped table-bordered" id="sample_1">
                            <thead>
                            <tr>
                                <th style="width:8px;">
                                    <input type="checkbox" class="group-checkable" data-set="#sample_1 .checkboxes" />
                                </th>
                                <th>状态</th>
                                <th>名称</th>
                                <th>用户</th>
                                <th>上架时间</th>
                                <th class="hidden-phone">是否推荐</th>
                                <th class="hidden-phone">类别</th>
                                <th>日租价</th>
                                <th>出售/出租</th>
                                <th>额外附加</th>
                                <th>简要介绍</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach ($goods as $good)
                            <tr class="odd gradex">
                                <td><input type="checkbox" class="checkboxes" value="1" /></td>
                                <td><span class="center label label-success">{{$good->status_txt}}</span></td>
                                <td class="center hidden-phone"><a href="{{ url('/adgoods/detail').'/'.$good->id }}">{{$good->title}}</a></td>
                                <td class="center hidden-phone"><a href="{{url('/aduser/detail').'/'.$good->uid}}">{{$good->username}}</a></td>
                                <td class="center hidden-phone">{{$good->ctime}}</td>
                                <td class="center hidden-phone">{{$good->special_txt}}</td>
                                <td class="hidden-phone">{{$good->type}}</td>
                                <td class="center hidden-phone">{{$good->price_daily}}</td>
                                <td class="center hidden-phone">{{$good->destination_txt}}</td>
                                <td class="hidden-phone">{{$good->extra_welfare}}</td>
                                <td class="hidden-phone">{{$good->content}}</td>
                            </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                </div>
            </div>
      </div>
</div>            
@endsection

@section('js')

@endsection
