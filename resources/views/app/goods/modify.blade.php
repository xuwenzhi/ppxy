@extends('app')
@section('html', "<html>")
@section('title', $goods->title.'-修改')
@section('css')
<link href="{{ asset('/lib/swf_uploadify/uploadify.css') }}" rel="stylesheet" />
@endsection
@section('content')
<div class="container">
	<ol class="breadcrumb">
		<li>首页</li>
		<li class="active">修改我的货</li>
	</ol>
	<div class="row">
		<div class="col-md-12">
			<div class="panel panel-primary">
				<div class="panel-heading">修改我的货</div>
				<div class="panel-body">
					<form action="{{ url('/goods/doModify') }}" method="post" name="modifyGoodsForm" id="modifyGoodsForm">
						<input type="hidden" id="_token" name="_token" value="{{ csrf_token() }}" />
				        <div class="form-group">
				        	<label for="goods_title" class="control-label">标题 &nbsp;&nbsp;<span class="label label-danger">必填</span></label>
				            <input class="form-control" type="text" id="goods_title" value="{{$goods->title}}" name="goods_title" required>
				        </div>
				        <div class="form-group form-inline">
				            <label for="goods_first_type" class="control-label">类别&nbsp;&nbsp;<span class="label label-danger">必选</span></label><br/>
				            <select class="form-control" id="goods_first_type" name="goods_first_type" >
							  	<?php
							  		foreach ($types as $key => $value) {
							  			if($value['code'] == $crt_first_type_code){
							  				echo "<option value='".$value['code']."' selected='selected'>".$value['name']."</option>";
							  			}else{
							  				echo "<option value='".$value['code']."'>".$value['name']."</option>";
							  			}
							  		}
							  	?>
							</select>
							<select class="form-control" id="goods_type" name="goods_type" required>
							  	<?php
							  		foreach ($second_types as $key => $value) {
							  			if($value['code'] == $goods->type){
							  				echo "<option value='".$value['code']."' selected='selected'>".$value['name']."</option>";
							  			} else {
							  				echo "<option value='".$value['code']."'>".$value['name']."</option>";
							  			}
							  		}
							  	?>
							</select>
				        </div>
				        <div class="form-group">
				            <label for="goods_newlevel" class="control-label">几成新?&nbsp;&nbsp;<span class="label label-danger">必选</span></label>
				            <select class="form-control" id="goods_newlevel" name="goods_newlevel" required>
							  	<?php
							  		foreach ($new_level as $key => $value) {
							  			if($key == $goods->new_level){
							  				echo "<option value='".$key."' selected='selected'>".$value."</option>";
							  			} else {
							  				echo "<option value=".$key.">".$value."</option>";
							  			}
							  		}
							  	?>
							</select>
				        </div>
				        <div class="form-group form-inline">
				            <label for="newlevel" class="control-label">交易地点?</label>
				            <input class="form-control" id="goods_dealplace" name="goods_dealplace" 
				            	 disabled="disabled" 
				            	placeholder="哈尔滨理工大学" />
							<input class="form-control" id="goods_dealplace_ext" name="goods_dealplace_ext"  
				            	placeholder="西区 or 东区 or 南区" value="{{$goods->deal_place_ext}}"/>&nbsp;&nbsp;<br/><span class="label label-info">其他学校，敬请期待</span>	
				        </div>
				        <div class="form-group">
				        <label for="goods_price" class="control-label">出个价<span id="size12 gray"></span>&nbsp;&nbsp;<span class="label label-danger">必填</span></label>
				            <input type="text" id="goods_price" class="form-control" name="goods_price" value="{{$goods->price}}" placeholder="(例如:5.20)" required>
				        </div>
				        <div class="form-group">
				            <label for="content" class="control-label">简要介绍:</label>
				            	<textarea class="form-control" id="goods_content" name="goods_content" rows="6">{{$goods->content}}</textarea>
				        </div>
				        <div class="page-header">
						  	<h1>图片写真{{$uid}}</h1>
						</div>
				        @if(!$isMobile || $uid)
				        <div class="form-group form-inline">
				        	<a href="#addPhotos" class="form-control btn-warning" data-backdrop="static" data-toggle="modal" data-target="#editPhotos">添加图片</a>
				        	<a href="#doEditPhotos" class="form-control btn-warning" id="doEditPhotos">编辑图片</a>
				        	<a href="#exitEditPhoto" class="form-control btn-info" id="exitEditPhoto" style="display:none;">退出编辑</a>
				    	</div>
				        <!-- 模态弹出窗内容 -->
		                <div class="modal fade" id="editPhotos"  role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
		                    <div class="modal-dialog">
		                    <div class="modal-content">
		                    	<div class="modal-header">
				                	<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				                	<h4 class="modal-title" id="myModalLabel">添加图片</h4>
				                	<small>上传的图片应小于2M,格式为jpg/png/gif等。</small>
				              	</div>
		                        <div class="modal-content">
		                            <div class="modal-body">
		                                <div class="form-group">
								            <input type="file" name="file_upload" id="file_upload"/>
											<a id="doUploadPhoto" class="btn btn-warning btn-block" 
											href="javascript:$('#file_upload').uploadify('settings', 'formData', {'_token':document.getElementById('_token').value,'goodsenid':document.getElementById('goods_enid').value});$('#file_upload').uploadify('upload','*')">请先选择图片然后点这里上传</a>
											<a id="doAgainUploadPhoto" class="button" style="display:none;" href="#again" onclick="showUploadLink(this)"><font color='white'>再次添加图片</font></a>						
								        </div>
		                            </div>
		                        </div>
		                    </div>
		                	</div>
		            	</div>
		            	<br/>
		            	@else
		            	<div class="alert alert-danger" role="alert">暂时不支持手机添加图片，如需添加，请在个人电脑上进行添加。</div>
		            	<div class="form-group form-inline">
				        	<a href="#doEditPhotos" class="form-control btn-warning" id="doEditPhotos">编辑图片</a>
				        	<a href="#exitEditPhoto" class="form-control btn-info" id="exitEditPhoto" style="display:none;">退出编辑</a>
				    	</div>
				        @endif
				        <div class="row" id="upload_photo_block">
				        	@foreach ($photos as $photo)
							<div class="col-sm-6 col-md-3">
								<div class="center-block text-center">
								<a href="#delete" id="do_delete" class="displaynone" photos-enid="{{$photo->id}}" title="删除图片">
									<img src="{{asset('/images/delete_red.png')}}"  class="center-block img-responsive" width="20px"/>
								</a>
	                        	</div>
						      	<a href="#" class="thumbnail" data-toggle="modal" data-target="#goodsPhotoDia{{$photo->id}}">
						         <img src=" {{asset('/').$photo->thumb}}" alt="..." class="img-responsive img-rounded" />
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
				        </div>
				        <input type="hidden" name="goods_enid" id="goods_enid" value="{{$goods->id}}"/>
				        <div class="modal fade" id="delete_photo_modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
					      <div class="modal-dialog">
					        <div class="modal-content">
					          	<div class="modal-body" id="delete_photo_modal_body">
					            	
					          	</div>
					          	<div class="modal-footer" id="delete_photo_modal_footer">
					          	<button type="button" class="btn btn-default" id="confirm_do_delete" photos-enid="">确定</button>
					            <button type="button" class="btn btn-default" data-dismiss="modal">取消</button>
					          </div>
					        </div>
					      </div>
					    </div>
			        </form>
				</div>
			</div>
		</div>
	</div>
</div>
<br/><br/><br/><br/>
@endsection
@section('footer')
<div class="form-group">
    <button type="button" id="modifybtn_sub" class="btn btn-success btn-block">修改好了</button>
    <button type="button" id="modifybtn_info" class="btn btn-info btn-block" disabled="disabled" style="display:none;">先把上面的填完吧</button>
</div>
@endsection
@section('js')
<script src="{{ asset('/js/goods/modifygoods.js')}}"></script>
<script src="{{ asset('/lib/swf_uploadify/jquery.uploadify-3.1.min.js')}}"></script>
<script src="{{ asset('/js/goods/uploadify.js')}}"></script>
@endsection
