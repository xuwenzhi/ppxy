$(document).ready(function(){
	$("#order_create_btn").on('click', function(){
		$(this).attr("disabled", "disabled");
		$(this).html("正在提交订单...");
		$("#orderCreateForm").submit();
	});
});
