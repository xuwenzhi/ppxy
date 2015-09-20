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
                        {{$title}}
                    </h3>
                    <ul class="breadcrumb">
                       <li>
                           <a href="#">首页</a>
                           <span class="divider"></span>
                       </li>
                       <li class="active">
                           {{$title}}
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
                                <th>头像</th>
                                <th>用户名</th>
                                <th>角色</th>
                                <th class="hidden-phone">Email</th>
                                <th class="hidden-phone">手机号</th>
                                <th>性别</th>
                                <th class="hidden-phone">最后登录</th>
                                <th class="hidden-phone">注册时间</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach ($users as $user)
                            <tr class="odd gradex">
                                <td><input type="checkbox" class="checkboxes" value="1" /></td>
                                <td>{{$user->head}}</td>
                                <td class="hidden-phone">{{$user->name}}</td>
                                <td class="hidden-phone"><span class="label label-success">{{$user->role}}</span></td>
                                <td class="center hidden-phone"><a href="mailto:{{$user->email}}">{{$user->email}}</a></td>
                                <td class="hidden-phone">{{$user->phone_nu}}</td>
                                <td class="hidden-phone">{{$user->sex}}</td>
                                <td class="hidden-phone">{{$user->updated_at}}</td>
                                <td class="hidden-phone">{{$user->created_at}}</td>
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
