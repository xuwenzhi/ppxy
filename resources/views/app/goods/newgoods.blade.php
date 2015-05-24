@extends('app')
@section('html','<html>')
@section('title', '上架我的商品')
@section('content')
<div class="container-fluid">
	<div class="row">
		<div class="col-md-8 col-md-offset-2">
			<div class="panel panel-primary">
				<div class="panel-heading">上架我的商品</div>
				<div class="panel-body">
					<form action="{{ url('/goods/doNew') }}" method="post" name="goodsForm" id="newGoodsForm">
						<input type="hidden" name="_token" value="{{ csrf_token() }}" />
				        <div class="form-group">
				        	<label for="goods_title" class="control-label">给你的东东加个标题 &nbsp;&nbsp;<span class="label label-danger">必填</span></label>
				            <input class="form-control" type="text" id="goods_title" name="goods_title" ng-model="goods.goods_title" required>
				        </div>
				        <div class="form-group form-inline">
				            <label for="goods_first_type" class="control-label">你的东东类别是哪种呢&nbsp;&nbsp;<span class="label label-danger">必选</span></label><br/>
				            <select class="form-control" id="goods_first_type" name="goods_first_type" ng-model="goods.goods_first_type">
							  	<?php
							  		foreach ($types as $key => $value) {
							  			echo "<option value=".$value['code'].">".$value['name']."</option>";
							  		}
							  	?>
							</select>
							<select class="form-control" id="goods_type" name="goods_type" ng-model="goods.goods_type" required>
							  	<?php
							  		foreach ($second_types as $key => $value) {
							  			echo "<option value=".$value['code'].">".$value['name']."</option>";
							  		}
							  	?>
							</select>
				        </div>
				        <div class="form-group">
				            <label for="goods_newlevel" class="control-label">几成新?&nbsp;&nbsp;<span class="label label-danger">必选</span></label>
				            <select class="form-control" id="goods_newlevel" name="goods_newlevel" ng-model="goods.goods_newlevel" required>
							  	<?php
							  		foreach ($new_level as $key => $value) {
							  			echo "<option value=".$key.">".$value."</option>";
							  		}
							  	?>
							</select>
				        </div>
				        <div class="form-group form-inline">
				            <label for="goods_newlevel" class="control-label">交易地点?</label>
				            <input class="form-control" id="goods_dealplace" name="goods_dealplace" 
				            	ng-model="goods.goods_dealplace" disabled="disabled" 
				            	placeholder="哈尔滨理工大学" />
							<input class="form-control" id="goods_dealplace_ext" name="goods_dealplace_ext" 
				            	ng-model="goods.goods_dealplace_ext"  
				            	placeholder="西区 or 东区 or 南区"/>&nbsp;&nbsp;<br/><span class="label label-info">其他学校，敬请期待</span>
				        </div>
				        <div class="form-group">
				        <label for="goods_price" class="control-label">出个价<span id="size12 gray"></span>&nbsp;&nbsp;<span class="label label-danger">必填</span></label>
				            <input type="text" id="goods_price" class="form-control" name="goods_price" ng-model="goods.goods_price" placeholder="(例如:5.20)" required>
				        </div>
				        <div class="form-group">
				            <label for="goods_content" class="control-label">来个简要介绍吧:</label>
				            	<textarea class="form-control" id="goods_content" name="goods_content" rows="6"></textarea>
				        </div>
			        </form>
				</div>
			</div>
		</div>
	</div>
	<div class="modal fade" id="newgoods_info_modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-body" id="newgoods_info_modal_body">
              
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
          </div>
        </div>
      </div>
    </div>
</div>
<br/>
<br/>
@endsection
@section('footer')
<div class="form-group">
    <button type="button" id="newgoods_btn_sub" class="btn btn-success btn-block" style="display:none;">现在就发出去</button>
    <button type="button" id="newgoods_btn_info" class="btn btn-info btn-block" disabled="disabled">先把上面的填完吧</button>
</div>
@endsection
@section('js')
<script src="{{ asset('/js/goods/newgoods.js')}}"></script>
@endsection
