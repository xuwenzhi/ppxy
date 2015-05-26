@extends('app')
@section('html', '<html>')
@section('title', '订单详情')
@section('content')

<div class="container">
	<ol class="breadcrumb">
	  	<li>我的订单</li>
	  	<li class="active">订单详情</li>
	</ol>
	<div class="row">
		<div class="col-md-8">
		<div class="panel panel-success">
			<div class="panel-heading">
				订单信息
			</div>
			<div class="panel-body">
				<ul class="list-group">
					<li class="list-group-item">
						<span class="label label-success">{{$order->goods_type}}</span>
						&nbsp;
						<span class="label label-success">{{$order->status_txt}}</span>
					</li>
					<li class="list-group-item">交易价格 ：¥{{$order->price}}</li>
					<li class="list-group-item">交易地点 ：<mark>{{$order->school_name}}{{$order->deal_place_ext}}</mark></li>
					<li class="list-group-item">下单时间 ：<mark>{{$order->ctime}}</mark></li>
				</ul>
				<div class="jumbotron">
				@if($order->goods_content != '')
				 	<p>{{$order->goods_content}}</p>
				@else
					<p>无其他说明</p>
				@endif
				</div>
			</div>
		</div>
		<div class="panel panel-success">
			<div class="panel-heading">
				@if($belong_buyer)
				卖家信息
				@else
				买家信息
				@endif
			</div>
			<div class="panel-body">
				<ul class="list-group">
					<li class="list-group-item">昵称 ：{{$user->name}}</li>
					<li class="list-group-item">联系方式 ：<mark>{{$user->phone_nu_en}}</mark><a href="#qa_verify_phone" data-toggle="modal"><span class="glyphicon glyphicon-question-sign" aria-hidden="true"></span></a></li>
				</ul>
			</div>
			<!-- Modal -->
	        <div class="modal fade" id="qa_verify_phone" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	          <div class="modal-dialog">
	            <div class="modal-content">
	              <div class="modal-header">
	                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	                <h4 class="modal-title" id="myModalLabel">
	                	提示信息
					</h4>
	              </div>
	              <div class="modal-body">

	              		{{$user->phone_nu}}<br/>
	              		<div class="alert alert-danger" role="alert">
	                  	请您保密
			            @if($belong_buyer)
						卖家
						@else
						买家
						@endif
						的联系方式,不要做与订单无关的其他事情！
						</div>
	              </div>
	              <div class="modal-footer">
	                <button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
	              </div>
	            </div>
	          </div>
	        </div>
		</div>
		</div>
		<div class="col-md-4">
			@if($belong_buyer)
				@include('app.goods.same',['recommend_widget_title' => $recommend_widget_title, 'recommend_widget_body'=>$recommend_widget_body])
			@else
				@include('app.order.otherorder',['recommend_widget_title' => $recommend_widget_title, 'recommend_widget_body'=>$recommend_widget_body])
			@endif
		</div>
	</div>
</div>
<br/>
<br/>

@endsection
@section('footer')
@endsection
@section('js')
@endsection
