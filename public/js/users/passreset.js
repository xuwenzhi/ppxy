$(document).ready(function(){
	$("#passreset").on('click', function(){
		var email = $("#email").val().trim();
		var password = $("#password").val().trim();
		var confirmpassword = $("#confirmpassword").val().trim();
		if(email == ''){
			$("#show_reset_issue").html("邮箱还没填写呢~");
			$("#show_reset_issue").show();
			return false;
		}else if(!checkEmail(email)){
			$("#show_reset_issue").html("似乎不是正确的邮箱，换一个吧~");
			$("#show_reset_issue").show();
			return false;
		}else{
			$("#show_reset_issue").hide();
		}

		if(password == ''){
			$("#password").focus();
			$("#show_reset_issue").html("密码还没填写");
			$("#show_reset_issue").show();
			return false;
		} else {
			if(password.length < 6){
				$("#password").focus();
				$("#show_reset_issue").html("密码过短,请保证在6-20位");
				$("#show_reset_issue").show();
				return false;
			}else if(password.length > 20){
				$("#password").focus();
				$("#show_reset_issue").html("密码过长,请保证在6-20位");
				$("#show_reset_issue").show();
				return false;
			}else if(!checkPassword(password)){
				$("#password").focus();
				$("#show_reset_issue").html("请输入有效的密码");
				$("#show_reset_issue").show();
				return false;
			}else{
				$("#show_reset_issue").hide();
			}
			if(confirmpassword == ''){
				$("#confirmpassword").focus();
				$("#show_reset_issue").html("确认密码还没填写");
				$("#show_reset_issue").show();
				return false;
			}
			if(password != confirmpassword){
				$("#confirmpassword").focus();
				$("#show_reset_issue").html("两次密码填写不一致~");
				$("#show_reset_issue").show();
				return false;
			}
		}
		$.ajax({
			url:APP+"/user/updatepass",
			type :'post',
			dataType:'json',
			async:false,
			data :{'email':email, 'password':password,'_token':$('meta[name="_token"]').attr('content')},
			success:function(data){
				if(data.status == 'success'){
					$("#passRestForm").submit();
				}else if(data.status == 'error'){
					$("#show_register_issue").html(data.message);
					$("#show_register_issue").show();
					return false;
				}else{
					$("#show_register_issue").html(data.message);
					$("#show_register_issue").show();
					return false;
				}
			}
		});
	});
});

function checkEmail(email){
	if(email == ''){
		return false;
	}
	var email_pattern = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
	if(!email_pattern.test(email)){
		return false;
	}
	return true;
}

function checkPassword(password){
	if(password == ''){
		return false;
	}
	var password_pattern = /[\w\d]+/;
	if(!password_pattern.test(password)){
		return false;
	}
	return true;
}
