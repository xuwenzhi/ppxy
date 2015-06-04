@extends('app')
@section('html','<html lang="zh-CN">')
@section('title', $title)
@section('content')
<div class="container">
	<ol class="breadcrumb">
	  	<li>商品列表</li>
	  	<li class="active">商品详情</li>
	</ol>
@if ($belong_crt_user == true)
@if ($photo_count == 0)
    <div class="alert alert-warning" role="alert">
    	@if($isMobile == 1)
    	暂时不支持手机加图，如需加图，请使用个人电脑添加。如需修改，<a href="{{ url('/goods/modify').'/'.$goods->id }}">戳这里。</a>
    	@else
    		您还没有为它上图噢,如需加图,<a class="alert-link" href="{{ url('/goods/modify').'/'.$goods->id }}">戳这里。</a>
    	@endif
    	<br/>
    	<a class="alert-link" href="{{url('/goods/mine')}}">去看看我的商品</a>
    </div>
@elseif($photo_count != 0)
	<div class="alert alert-warning" role="alert">
		如需修改它,请<a  class="alert-link" href="{{ url('/goods/modify').'/'.$goods->id }}">戳这里</a>
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
					<li class="list-group-item">
						@if($goods->status == 'sell')
						<span class="label label-success">{{$goods->status_txt}}</span>
						@else
						<span class="label label-danger">{{$goods->status_txt}}</span>
						@endif
						<span class="label label-success">{{$goods->type}}</span>
						<span class="label label-success">{{$goods->new_level}}</span>
					</li>
					<li class="list-group-item">¥{{$goods->price}}</li>
					<li class="list-group-item"><mark>{{$goods->school_name}}{{$goods->deal_place_ext}}</mark>交易噢~</li>
					<li class="list-group-item">它被查看了<mark>{{$view_times}}</mark>次</li>
					<li class="list-group-item">{{$goods->username}}发布于{{$goods->trans_time}}</li>
				</ul>
				<div class="page-header">
				  	<h1>主人寄语</h1>
				</div>
				<div class="jumbotron">
				  	<p>
				  		@if($goods->content != '')
				  			{{$goods->content}}
				  		@else
				  			主人没有为它填写描述~
				  		@endif
				  	</p>
				</div>
				<div class="page-header">
				  	<h1>图片写真</h1>
				</div>
				<div class="row">
				@if($photo_count != 0)
					@foreach ($photos as $photo)
					<div class="col-sm-6 col-md-3">
				      	<a href="#" class="thumbnail" data-toggle="modal" data-target="#goodsPhotoDia{{$photo->id}}">
				         <img src=" {{asset('/').$photo->thumb}}"  alt="..." class="img-responsive img-rounded" alt="Responsive image">
				      	</a>
				      	<!-- 模态弹出窗内容 -->
		                <div class="modal fade" id="goodsPhotoDia{{$photo->id}}"  role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
		                    <div class="modal-dialog">
		                        <div class="modal-content">
		                            <div class="modal-body">
		                                @if(!$isMobile)
		                                <img src="{{asset('/').'/'.$photo->address}}" class="img-responsive center-block" alt="Responsive image"/>
		                                @else
		                                <img src="{{asset('/').'/'.$photo->thumb}}" class="img-responsive center-block" alt="Responsive image"/>
		                                @endif
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
  		@include('app.goods.same',['recommend_widget_title' => $recommend_widget_title, 'recommend_widget_body'=>$recommend_widget_body])
  	</div>
</div>
</div>
<br/>
<br/>
<br/>
@endsection
@section('footer')
@if ($belong_crt_user == false)
@if($goods->status == 'sell')
<a href="{{ asset('order/'.$goods->id.'/precheck') }}" class="btn btn-success btn-lg btn-block">{{$footer_show_txt}}</a>
@else
<a href="#" class="btn btn-success btn-lg btn-block" disabled="disabled">已经在交易中,不可下单。</a>
@endif
@endif
@endsection
@section('js')
<script type="text/javascript" src="{{ asset('/js/goods/detail.js') }}"></script>
@endsection
