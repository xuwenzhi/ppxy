$(document).ready(function(){
	$("#veryfy_phone").keyup(function(){
		var verifyphone = $(this).val().trim();
		if(checkPhoneNu(verifyphone)){
			$("#verify_button").attr("disabled", false);
		}else{
			$("#verify_button").attr("disabled", "disabled");
		}
	});

	$("#verify_button").on('click', function(){
		var verifyphone = $('#veryfy_phone').val().trim();
		if(checkPhoneNu(verifyphone)){
			$("#verify_button_txt").html('提交');
			$("#verify_code_block").show();
			$("#time_flee").show();
			setInterval(showTimeFlee,1000);
			$.ajax({
				url:"/jquery/test1.txt",
				async:false,
				success:function(data){
					
				}
			});
		}
	});
});


function checkPhoneNu(phone_nu){
	if(phone_nu.length != 11){
		return false;
	}
	var myreg = /^(((13[0-9]{1})|(15[0-9]{1})|(18[0-9]{1})|(13[0-9]{1})|(14[0-9]{1})|(19[0-9]{1}))+\d{8})$/; 
	if(!myreg.test(phone_nu)) { 
	    return false; 
	}
	return true;
}

function showTimeFlee(){
	var crt_time = parseInt($("#time_flee").html());
	if(crt_time == 0){
		$("#time_flee").html('');
		$("#verify_button").html("没有收到?点击重新获取");
		
	}
	$("#time_flee").html(crt_time-1+"秒");
}


