$(document).ready(function(){
	$("#newOrderGo").on('click', function(){
		$(this).attr("disabled", "disabled");
		$(this).html("正在跳转...");
	});
});
