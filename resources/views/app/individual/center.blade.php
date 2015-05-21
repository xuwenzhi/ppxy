@extends('app')
@section('html','<html lang="zh-CN" ng-app="newGoodsModule">')
@section('title', '个人中心')
@section('content')
<div class="container">
	<ol class="breadcrumb">
	  	<li>首页</li>
	  	<li class="active">个人中心</li>
	</ol>
<div class="row">
  	<div class="col-md-9">
  		<div class="panel panel-success">
  			<div class="panel-heading">
  				<h4>{{$baseinfo->name}}</h4> <p>造轮子</p>
	  		</div>
  		<table class="table">
  			<tr>
  				<td width="30%" align="center" valign="middle"><img src=" {{asset('/images/product4.png')}}"  alt="..." class="img-responsive img-rounded" alt="" /></td>
  				<td>
  					<table>
  						<tr><td>{{$baseinfo->name}} - </td></tr>
  						<tr><td></td></tr>
  						<tr><td>fdff</td></tr>
  						<tr><td>fdff</td></tr>
  						<tr><td>fdff</td></tr>
  					</table>
  				</td>
  			</tr>
		</table>
		</div>
  	</div>
  	<div class="col-md-3">
  		这里放同类商品
  	</div>
</div>
</div>
@endsection
@section('footer')
2015 &copy; PP校园
@endsection
@section('js')
@endsection
