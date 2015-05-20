@extends('app')
@section('html','<html ng-app="newGoodsModule">')
@section('title', '上架我的商品')
@section('content')
<style>
	 .my-form {
	   -webkit-transition:all linear 0.5s;
	   transition:all linear 0.5s;
	   background: transparent;
	 }
	 .my-form.ng-invalid {
	   background: red;
	 }
	</style>
<div class="container-fluid">
	<div class="row">
		<div class="col-md-8 col-md-offset-2">
			<div class="panel panel-primary">
				<div class="panel-heading">上架我的商品</div>
				<div class="panel-body">
					<form action="{{ url('/goods/doNew') }}" method="post" name="goodsForm" ng-controller="formController">
						<input type="hidden" name="_token" value="{{ csrf_token() }}" />
				        <div class="form-group">
				        	<label for="goods_title" class="control-label">给你的东东加个标题 &nbsp;&nbsp;<span class="label label-danger">必填</span></label>
				            <input class="form-control" type="text" id="goods_title" name="goods_title" ng-model="goods.goods_title" required>
				        </div>
				        <div class="form-group">
				            <label for="goods_type" class="control-label">你的东东类别是哪种呢&nbsp;&nbsp;<span class="label label-danger">必选</span></label>
				            <select class="form-control" id="goods_type" name="goods_type" ng-model="goods.goods_type" required>
							  	<?php
							  		foreach ($types as $key => $value) {
							  			echo "<option value=".$value['id'].">".$value['name']."</option>";
							  		}
							  	?>
							</select>
				        </div>
				        <div class="form-group">
				            <label for="goods_price" class="control-label">出个价&nbsp;&nbsp;<span class="label label-danger">必填</span></label>
				            <input type="text" id="goods_price" class="form-control" name="goods_price" id="recipient-name" ng-model="goods.goods_price" required>
				        </div>
				        <div class="form-group">
				            <label for="goods_content" class="control-label">来个简要介绍吧:</label>
				            	<textarea class="form-control" id="goods_content" name="goods_content" rows="10" ng-model="goods.goods_content">
				            		
				            	</textarea>
				        </div>
				        <div class="form-group">
				            <button type="submit" class="btn btn-success btn-block" ng-show="goodsForm.$valid">现在就发出去</button>
				            <button type="button" class="btn btn-info btn-block" ng-hide="goodsForm.$valid" disabled="disabled">先把上面的填完吧</button>
				        </div>
			        </form>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection
@section('js')
<script src="{{ asset('/js/goods/newgoods.js')}}"></script>
@endsection
