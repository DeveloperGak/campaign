<!DOCTYPE html>
<html lang="ko">
<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" type="text/css" href="<?=ADMIN_CSS?>/common.css">
    <style>
        .login_name{
            width: 100%;
        }
    </style>
	<title>관리자-로그인</title>
</head>
<body>
	<div id="wrap">
		<section class="login_section">
			<div class="login_container">
				<div class="login_name" style="padding: unset;">관리자 로그인</div>
				<div class="login_wrap">
					<div class="header"><h4>LOGIN</h4></div>
					<div class="write_form">
						<div class="form-group">
							<label for="userid">User ID</label>
							<input type="text" class="inputbox" id="userid" name="userid">
						</div>
						<div class="form-group">
							<label for="password">Password</label>
							<input id="passwd" type="password" class="inputbox" name="passwd">
						</div>
						<div class="form-group">
							<div class="custom-control custom-checkbox">
								<input type="checkbox" name="remember" class="checkboxinput" id="remember-me">
								<label class="checkboxlabel" for="remember-me">아이디 기억</label>
							</div>
						</div>
						<div class="form-group">
							<button type="submit" class="loginbtn">LOGIN</button>
						</div>
					</div>
				</div>
			</div>
		</section>
	</div>
</body>
<script src="<?=JS?>/jquery3.2.js"></script>
<script src="<?=ADMIN_JS?>/jquery.cookie.js"></script>
<script>
$(function(){
	$('input').keydown(function(e) {
		var idx = $('input').index(this);
		if (e.keyCode === 13) {
			if(idx === 1){
				$(".loginbtn").click();
			}
			else{
				$('input').eq(idx+1).focus();
			}
		};
	});

    if($.cookie('savedId')){
        $("#remember-me").prop("checked", true);
        $("#userid").val($.cookie('savedId'));
    }
	/*로그인버튼 클릭이벤트*/
	$(".loginbtn").on("click",function(){
    		if($("#userid").val()=="") {
			alert("아이디를 입력해주세요");
			$("#userid").focus();
			return false;
		}

		if($("#passwd").val()=="") {
			alert("비밀번호를 입력해주세요");
			$("#passwd").focus();
			return false;
		}

        var userid = ($("#userid").val()) ? $("#userid").val() : null;
		var passwd = ($("#passwd").val()) ? $("#passwd").val() : null;

    var data = {
        "userid" : userid
      , "passwd": passwd
    };
		var u = "/admin/main/loginCheck";

		$.ajax({
			url:u,
			data:data,
			type:'POST',
			// dataType:'json',
			cache:false,
			success:function(response){
				if(response == "fail"){
                    alert('로그인 정보를 확인해 주세요.');
				}
				if(response == "success"){
					if($("#remember-me").is(":checked")){
						$.cookie('savedId', $("#userid").val());
					}else{
						$.removeCookie('savedId');
					}
					location.href="/admin/campaign";
				}
			}
	});
	});
});
</script>
</html>