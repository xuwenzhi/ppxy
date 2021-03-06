$(document).ready(function(){
	$("#goods_first_type").on('change', function(){
		var first_type_code =  $(this).val().trim();
		if(!first_type_code){
			$("#newgoods_info_modal_body").html("页面错误,建议您刷新浏览器重试。");
			$("#newgoods_info_modal").modal({
			  	show: true
			});
		}
		$("#goods_type").empty();
		$.ajax({
			url:APP+"/goods/subtype",
			type :'post',
			dataType:'json',
			data :{'first_type_code':first_type_code, '_token':$('meta[name="_token"]').attr('content')},
			success:function(data){
				$("#goods_type").empty();
				if(data.status == 'success'){
					var second_types = data.data;
					for(var one in second_types) {
						var str = '<option value="'+second_types[one]['code']+'">'+second_types[one]['name']+'</option>';
						$(str).appendTo("#goods_type");
					}
				}else if(data.status == 'failed'){
					$("#newgoods_info_modal_body").html(data.message);
					$("#newgoods_info_modal").modal({
					  	show: true
					});
				}else if(data.status == 'error'){
					$("#newgoods_info_modal_body").html(data.message);
					$("#newgoods_info_modal").modal({
					  	show: true
					});
				}else{
					$("#newgoods_info_modal_body").html(data.message);
					$("#newgoods_info_modal").modal({
					  	show: true
					});
				}
			},beforeSend:function(){
				var str = '<option value="">玩命加载中...</option>';
				$(str).appendTo("#goods_type");
			}
		});
	});

	$("#goods_title").on('keyup', function(){
		var goods_title = $(this).val().trim();
		if(goods_title!=''){
			$(this).css("border", "0px");
			$(this).html("修改好了");
		}else{
			$(this).css("border", "1px solid red");
		}
	});

	$("#goods_price").on('keyup', function(){
		var goods_price = $(this).val().trim();
		if(checkPrice(goods_price)){
			$(this).css("border", "0px");
			$(this).html("修改好了");
		}else{
			$(this).css("border", "1px solid red");
		}
	});

	$("#goods_type").on('keyup', function(){
		var goods_type = $(this).val().trim();
		if(goods_type!=''){
			$(this).css("border", "0px");
			$(this).html("修改好了");
		}else{
			$(this).css("border", "1px solid red");
		}
	});

	$("#modifybtn_sub").on('click', function(){
		var goods_title = $("#goods_title").val().trim();
		var goods_price = $("#goods_price").val().trim();
		var goods_type = $("#goods_type").val().trim();
		if(goods_title == ''){
			$("#goods_title").focus();
			$("#goods_title").css("border", "1px solid red");
			$(this).html("您还没有填写标题呢。");
			return false;
		}
		if(goods_type == ''){
			$("#goods_type").focus();
			$("#goods_type").css("border", "1px solid red");
			$(this).html("您还没有选择商品类别呢。");
			return false;
		}
		if(goods_price == '' || !checkPrice(goods_price)){
			$("#goods_price").focus();
			$("#goods_price").css("border", "1px solid red");
			$(this).html("请输入正确的价格。");
			return false;
		}
		$("#modifyGoodsForm").submit();
	});


	$("#doEditPhotos").on('click', function(){
		$("a[id='do_delete']").each(function(){
			$(this).show();
		});
		$(this).hide();
		$("#exitEditPhoto").show();
	});

	$("#exitEditPhoto").on('click',function(){
		$("a[id='do_delete']").each(function(){
			$(this).hide();
		});
		$(this).hide();
		$("#doEditPhotos").show();
	});

	$("a[id='do_delete']").on('click', function(){
		$("#confirm_do_delete").attr('photos-enid', $(this).attr('photos-enid'));
		$("#delete_photo_modal_body").html('确定删除吗？');
		$("#delete_photo_modal").modal({
		  	show: true,
		  	locked:true
		});
	});

	$("#confirm_do_delete").on('click', function(){
		var photos_enid = $(this).attr('photos-enid');
		if(!photos_enid){
			$("#delete_photo_modal_body").html('读取图片失败,建议您刷新浏览器重试。');
			return false;
		}
		$("#delete_photo_modal").modal({
		  	show: false
		});
		$.ajax({
			url:APP+"/goods/deletephoto",
			type :'post',
			dataType:'json',
			data :{'photo_enid':photos_enid, '_token':$('meta[name="_token"]').attr('content')},
			success:function(data){
				if(data.status == 'success'){
					$("#delete_photo_modal_body").html(data.message);
					$("#delete_photo_modal").modal('hide');
					$("a[photos-enid='"+photos_enid+"']").parent().parent().hide();
				}else if(data.status == 'failed'){
					$("#delete_photo_modal_body").html(data.message);
				}else if(data.status == 'error'){
					$("#delete_photo_modal_body").html(data.message);
				}else{
					$("#delete_photo_modal_body").html(data.message);
				}
			},beforeSend:function(){
				$("#delete_photo_modal_body").html('玩命删除中...');
			}
		});
	});

	$("#mobileUploadBtn").on('click', function(){
		if($("#Filedata").val() == ''){
			alert('请先选择图片');
			return false;
		}
		var options = {
	    	type:"POST",
	    	url:APP+'/goods/h5upload',
	    	data:$("#mobileUploadForm").formSerialize(),
	    	timeout:30000,
	    	beforeSerialize:function(){
	     		
	    	},
	    	beforeSubmit:function(){
	     		$("#mobileUploadBtn").val('图片上传中...');
	     		$("#mobileUploadBtn").attr('disabled', 'disabled');
	    	},
	    	success:function(data){
	    		$("#Filedata").val('');
	    		$("#mobileUploadBtn").attr('disabled', false);
	     		var res = data.split('*');
                if(res[0] == 'success'){
                	$("#mobileUploadBtn").val('上传成功!');
	    			setTimeout(modifyMobileUploadBtn, 2000);
	      			var photo_data = data.data;
	      			var img_path = '<div class="col-sm-6 col-md-3">';
                    img_path += '<a href="#" class="thumbnail" data-toggle="modal" data-target="#goodsPhotoDia'+res[1]+'"><img src="'+PUBLIC+res[2]+'"  alt="..." class="img-responsive img-rounded" alt="Responsive image"></a>';
                    img_path += '<div class="modal fade" id="goodsPhotoDia'+res[1]+'"  role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">';
                    img_path += '<div class="modal-dialog"><div class="modal-content"><div class="modal-body"><img src="'+PUBLIC+res[2]+'" width="80%" class="img-responsive center-block" alt="Responsive image"/></div></div></div></div></div>';
                    $("#upload_photo_block").prepend(img_path);
	      		}else{
	      			$("#mobileUploadBtn").val(res[1]);
	    			setTimeout(modifyMobileUploadBtn, 4000);
	      		}
	    	},error:function(jqXHR, textStatus, errorThrown){   
	    		$("#mobileUploadBtn").attr('disabled', false);
	    		$("#mobileUploadBtn").val('重新上传');
                if(textStatus=="timeout"){
                    alert("网络不好。");  
                    return false;
                }else{
                    alert("很抱歉,您的手机浏览器不支持上传图片,请您更换浏览器重试！"+textStatus);
	      			return false;
                }  
            }
	    };
		$("#mobileUploadForm").ajaxSubmit(options);
		return false;
	});

});

function checkPrice(price){
	if(price == ''){
		return false;
	}
	var re = /^(([1-9][0-9]*\.[0-9][0-9]*)|([0]\.[0-9][0-9]*)|([1-9][0-9]*)|([0]{1}))$/; 
    if(!re.test(price)){
    	return false;
    }
    return true;
}

function modifyMobileUploadBtn(){
	$("#mobileUploadBtn").val('选择图片，继续上传!');
}
