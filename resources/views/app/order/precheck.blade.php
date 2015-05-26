@extends('app')
@section('html', '<html>')
@section('title', '创建订单')
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
				<form action="{{ url('order/create') }}" method="post" id="orderCreateForm">
				<input type="hidden" name="_token" value="{{ csrf_token() }}" />
				<input type="hidden" name="enId" value="{{ $goods_info->id }}" />
					<ul class="list-group">
						<li class="list-group-item">
							状态 : <span class="label label-success">{{$goods_info->status_txt}}</span>
						</li>
						<li class="list-group-item">交易金额 : ¥{{$goods_info->price}}</li>
						<li class="list-group-item">交易地点 : <mark>{{$goods_info->school_name}}{{$goods_info->deal_place_ext}}</mark></li>
					</ul>
					<p class="text-right"><input type="button" id="order_create_btn" class="btn btn-danger btn-lg" value="信息确认无误,创建订单"></p>
				</form>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection
@section('js')
<script type="text/javascript" src=" {{asset('/js/order/precheck.js')}}  "></script>
@endsection
