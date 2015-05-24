@extends('app')
@section('html', '<html>')
@section('title', '我的货')
@section('content')
<div class="container">
	<ol class="breadcrumb">
		<li>首页</li>
		<li class="active">我的货</li>
	</ol>
	<div class="row">
		<div class="col-md-8 col-md-offset-2">
		@foreach($baselist as $list)
		<a class="btn form-control" href="{{ url('/goods/detail/').'/'.$list->id }}">{{$list->title}}</a>
		@endforeach
		</div>
	</div>
</div>
@endsection
@section('footer')
@endsection
@section('js')
<script src="{{ asset('/js/goods/newgoods.js')}}"></script>
@endsection
