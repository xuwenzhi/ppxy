@extends('app')
@section('html', '<html>')
@section('title', '我的订单')
@section('content')
<div class="container">
	<ol class="breadcrumb">
		<li>首页</li>
		<li class="active">我的订单</li>
	</ol>
	<div class="row">
		<div class="col-md-12">
		<div class="panel panel-primary">
			<div class="panel-heading">我的订单</div>
			<div class="panel-body">
				@foreach($baselist as $list)
				<a class="btn form-control" href="{{ url('/order/'.$list->id.'/detail/') }}">{{$list->title}}</a>
				@endforeach
			</div>
		</div>
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
