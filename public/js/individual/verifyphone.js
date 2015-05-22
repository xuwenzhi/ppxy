$(document).ready(function(){
	$("#veryfy_phone").keyup(function(){
		var verifyphone = $(this).val().trim();
		if(checkPhoneNu(verifyphone)){
			$("#get_verify_button").attr("disabled", false);
		}else{
			$("#get_verify_button").attr("disabled", "disabled");
		}
	});

	$("#get_verify_button").on('click', function(){
		var verifyphone = $('#veryfy_phone').val().trim();
		if(checkPhoneNu(verifyphone)){
			$(this).attr('disabled', 'disabled');
			$("#time_flee").html('60秒');
			$("#verify_code_block").show();
			$("#get_verify_button_txt").html('等待验证码');
			$("#time_flee").show();
			setInterval(showTimeFlee, 1000);
			$.ajax({
				url:APP+"/verifyphone",
				type :'post',
				dataType:'json',
				data :{phone_nu:$("#veryfy_phone").val().trim(), '_token':$('meta[name="_token"]').attr('content')},
				success:function(data){
					$("#verify_modal").modal({
					  	show: false
					});
					if(data.status == 'success'){
						$("#verify_button").attr("disabled", "disabled");
						$("#verify_button").show();
						$("#verify_code").val('');
					}else{
						$("#verify_modal_body").html(data.message);
						$("#verify_modal").modal({
						  	show: true
						});
						$(this).attr('disabled', false);
					}
				}
			});
		}else {
			$(this).attr('disabled', false);
			$("#verify_modal_body").html("手机号格式错误，请重试!");
			$("#verify_modal").modal({
			  	show: true
			})
		}
	});
	$("#verify_code").on('keyup', function(){
		var code = $(this).val().trim();
		if(checkCode(code)){
			$("#verify_button").attr("disabled", false);
		}else{
			$("#verify_button").attr("disabled", "disabled");
		}
	});

	$("#verify_button").on('click', function(){
		var verify_code = $("#verify_code").val().trim();
		if(!checkCode(verify_code)){
			$("#verify").attr("placeholder", "请输入正确的验证码");
			return false;
		}
		$.ajax({
			url:APP+"/doverifyphone",
			type :'post',
			dataType:'json',
			data :{phone_nu:$("#veryfy_phone").val().trim(), 'verify_code':verify_code, '_token':$('meta[name="_token"]').attr('content')},
			success:function(data){
				if(data.status == 'success'){
					$("#verify_modal_body").html(data.message);
					$("#verify_modal").modal({
						show: true
					});
				}else if(data.status == 'repeat'){
					$("#verify_modal_body").html(data.message);
					$("#verify_modal").modal({
						show: true
					});
				}else{
					$("#verify_error_modal_body").html(data.message);
					$("#verify_error_modal").modal({
						show: true
					});
				}
			},beforeSend:function(){
				$(this).html("正在验证...");
			}
		});
	});
	$('#verify_modal').on('hidden.bs.modal', function (e) {
	  	window.location.reload();
	})
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
		$("#time_flee").html('60秒');
		$("#get_verify_button_txt").html("没有收到?点击重新获取");
		$("#get_verify_button").attr("disabled", false);
		$("#time_flee").hide();
		clearInterval(showTimeFlee);
	}
	$("#time_flee").html(crt_time-1+"秒");
}

function checkCode(code){
	if(code.length != 6){
		return false;
	}
	var codeParttern =  /\d{6}/;
	if(!codeParttern.test(code)){
		return false;
	}
	return true;
}


