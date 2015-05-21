@extends('app')
@section('html','<html lang="zh-CN" ng-app="newGoodsModule">')
@section('title', $title)
@section('content')
<div class="container">
	<ol class="breadcrumb">
	  	<li><a href="" onclick="history.go(-1)">商品列表</a></li>
	  	<li class="active">商品详情</li>
	</ol>
@if ($belong_crt_user == true)
@if ($photo_count == 0)
    <div class="alert alert-success" role="alert">
    	您还没有为它上图噢,如需添加，<a class="alert-link" href="{{ url('/goods/update').'/'.$goods->id }}">戳这里</a>
    </div>
@elseif($photo_count != 0)
	<div class="alert alert-success" role="alert">
		如需修改它,请<a  class="alert-link" href="{{ url('/goods/update').'/'.$goods->id }}">戳这里</a>
    </div>
@endif
@endif
<div class="row">
  	<div class="col-md-9">
  		
  		<div class="panel panel-success">
	  		<div class="panel-heading">
	  			<h5>{{$title}}</h5><span class="label label-danger">{{$goods->special == $special_recommend ? '推荐' : ''}}</span>
	  		</div>
			<div class="panel-body">
				<ul class="list-group">
					<li class="list-group-item"><span class="label label-success">{{$goods->status_txt}}</span></li>
					<li class="list-group-item">¥{{$goods->price}}</li>
					<li class="list-group-item">{{$goods->username}}发布于{{$goods->trans_time}}</li>
					<li class="list-group-item">它被查看了<mark>{{$view_times}}</mark>次</li>
				</ul>
				<div class="jumbotron">
				  	<p>{{$goods->content}}</p>
				</div>
				<div class="page-header">
				  	<h1>图片写真</h1>
				</div>
				<div class="row">
				@if($photo_count != 0)
					@foreach ($photos as $photo)
					<div class="col-sm-6 col-md-3">
				      	<a href="#" class="thumbnail" data-toggle="modal" data-target="#goodsPhotoDia{{$photo->id}}">
				         <img src=" {{asset('/images/product4.png')}}"  alt="..." class="img-responsive img-rounded" alt="Responsive image">
				      	</a>
				      	<!-- 模态弹出窗内容 -->
		                <div class="modal fade" id="goodsPhotoDia{{$photo->id}}"  role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
		                    <div class="modal-dialog">
		                        <div class="modal-content">
		                            <div class="modal-body">
		                                <img src="{{asset('/images/product4.png')}}" width="80%" class="img-responsive center-block" alt="Responsive image"/>
		                            </div>
		                        </div>
		                	</div>
		            	</div>
				    </div>
				    @endforeach
				@else
					<div class="col-sm-12 col-md-12">
					<div class="jumbotron">
					 	<p>主人没有给它上图噢~</p>
					</div>
					</div>
				@endif
				</div>
			</div>
		</div>
  	</div>
  	<div class="col-md-3">
  		这里放同类商品
  	</div>
</div>
</div>
@endsection
@section('footer')
<button type="button" class="btn btn-success btn-lg btn-block">{{$footer_show_txt}}</button>
@endsection
@section('js')
<script src="{{ asset('/js/goods/newgoods.js')}}"></script>
@endsection
