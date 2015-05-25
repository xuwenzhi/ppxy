@extends('app')
@section('html', '<html>')
@section('title', '创建订单')
@section('css')
<link href="{{ asset('/lib/swf_uploadify/uploadify.css') }}" rel="stylesheet" />
@endsection
@section('content')
<div class="container">
	<ol class="breadcrumb">
		<li>首页</li>
		<li class="active">创建订单</li>
	</ol>
	<div class="row">
		<div class="col-md-12">
			<div class="panel panel-success">
				<div class="panel-heading">您即将对"{{$goods_info->title}}"进行下单</div>
				<div class="panel-body">
					<ul class="list-group">
						<li class="list-group-item">交易金额 : ¥{{$goods_info->price}}</li>
						<li class="list-group-item">交易地点 : <mark>{{$goods_info->school_name}}{{$goods_info->deal_place_ext}}</mark></li>
					</ul>
					<a href="#">创建订单</a>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection
@section('js')
<script src="{{ asset('/js/goods/modifygoods.js')}}"></script>
<script src="{{ asset('/lib/swf_uploadify/jquery.uploadify-3.1.min.js')}}"></script>
<script src="{{ asset('/js/goods/uploadify.js')}}"></script>
@endsection
