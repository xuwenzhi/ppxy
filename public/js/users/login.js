$(document).ready(function(){
	$("#login_btn").on('click', function(){
		var email = $("#email").val().trim();
		var password = $("#password").val().trim();		
		if(email == ''){
			$("#show_login_issue").html("邮箱还没填写呢~");
			$("#show_login_issue").show();
			return false;
		}
		if(!checkEmail(email)){
			$("#show_login_issue").html("您填写的邮箱格式似乎不对噢~");
			$("#show_login_issue").show();
			return false;
		}
		if(password == ''){
			$("#show_login_issue").html("密码还没填写呢~");
			$("#show_login_issue").show();
			return false;
		}
		$("#loginForm").submit();
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
