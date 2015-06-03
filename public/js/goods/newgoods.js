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
		var goods_price = $("#goods_price").val().trim();
		var goods_title = $(this).val().trim();
		var goods_type = $("#goods_type").val().trim();
		if(goods_title!='' && checkPrice(goods_price) && goods_type != ''){
			$("#newgoods_btn_info").hide();
			$("#newgoods_btn_sub").show();
		}else{
			$("#newgoods_btn_info").show();
			$("#newgoods_btn_sub").hide();
		}
	});
	$("#goods_price").on('keyup', function(){
		var goods_title = $("#goods_title").val().trim();
		var goods_price = $(this).val().trim();
		var goods_type = $("#goods_type").val().trim();
		if(goods_title != '' && checkPrice(goods_price) && goods_type != ''){
			$("#newgoods_btn_info").hide();
			$("#newgoods_btn_sub").show();
		}else{
			$("#newgoods_btn_info").show();
			$("#newgoods_btn_sub").hide();
		}
	});

	$("#goods_type").on('change', function(){
		var goods_title = $("#goods_title").val().trim();
		var goods_price = $("#goods_price").val().trim();
		var goods_type = $(this).val().trim();
		if(goods_title != '' && checkPrice(goods_price) && goods_type != ''){
			$("#newgoods_btn_info").hide();
			$("#newgoods_btn_sub").show();
			$("#newgoods_btn_sub").html('现在就发出去');
		}else{
			$("#newgoods_btn_info").show();
			$("#newgoods_btn_sub").hide();
		}
	});

	$("#newgoods_btn_sub").on('click', function(){
		var goods_title = $("#goods_title").val().trim();
		var goods_price = $("#goods_price").val().trim();
		var goods_type = $("#goods_type").val().trim();
		if(goods_title == ''){
			$(this).html("您还没有填写标题呢。");
			return false;
		}
		if(goods_type == ''){
			$(this).html("您还没有选择商品类别呢。");
			return false;
		}
		if(goods_price == '' || !checkPrice(goods_price)){
			$(this).html("请输入正确的价格。");
			return false;
		}
		$(this).html("正在提交...");
		$(this).attr("disabled", "disabled");
		$("#newGoodsForm").submit();
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
