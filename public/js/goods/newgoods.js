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
			url:APP+"goods/subtype",
			type :'post',
			dataType:'json',
			data :{'first_type_code':first_type_code, '_token':$('meta[name="_token"]').attr('content')},
			success:function(data){
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
			}
		});
	});

	$("#goods_title").on('keyup', function(){
		
	});
});
