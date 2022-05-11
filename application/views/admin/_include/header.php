<?php
if(!empty($_GET['dev']) && $_GET['dev'] == "gak"){
	echo "<pre>".print_r($this->session->userdata,TRUE)."</pre>";
}
$isLogin = true;
$nLevel = $this->session->userdata('nLevel');
if($nLevel === "1" || $nLevel === "2" ) $isLogin = false;
if($isLogin) redirect('/admin/login');
$vUserId = $this->session->userdata('vUid');
$isSuperAdmin = null;
if($nLevel === "1"){
    $isSuperAdmin = 'Y';
}

?>

<!DOCTYPE html>
<html lang="ko">
<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>추첨 캠페인 - 관리자</title>
	<link rel="stylesheet" type="text/css" href="<?=ADMIN_CSS?>/common.css">
    <link rel="stylesheet" type="text/css" href="<?=ADMIN_CSS?>/layerpopup.css">
	<link rel="stylesheet" type="text/css" href="<?=ADMIN_CSS?>/list.css">
	<link rel="shortcut icon" type="image/x-icon" href="/asset/img/favicon.ico">
	<script src="<?=JS?>/jquery3.2.js"></script>
</head>
<body>
<style>
    #exchange-password-section.on{display:block; }
    #exchange-password-section {
        display: none;
        width: 100%;
        height: 100%;
        position: fixed;
        top: 0;
        left: 0;
        z-index: 100;
        background: rgba(0,0,0,0.5);
    }
    #exchange-password-section .exchange-password {
        position: absolute;
        border-radius: 3px;
        top: 50%;
        left: 50%;
        margin-left: -200px;
        margin-top: -150px;
        background: #fff;
        width: 480px;
        height: 355px;
        text-align: center;
    }
    #exchange-password-section .exchange-password-header {
        overflow: hidden;
        height: 45px;
        line-height: 45px;
        padding: 0px 20px;
        position: relative;
        border-bottom: 1px solid #ddd;
    }
    #exchange-password-section .exchange-password-header h1 {
        width: 70%;
        font-size: 1.1rem;
        text-align: left;
        color: #000;
    }
    #exchange-password-section .exchange-password-close {
        position: relative;
        width: 30px;
        height: 30px;
        display: block;
        float: right;
        cursor: pointer;
    }

    #exchange-password-section .exchange-password-close span {
        width: 22px;
        height: 2px;
        position: absolute;
        top: 0;
        background: #333;
    }
    #exchange-password-section .exchange-password-close span:nth-of-type(1) {
        top: -44px;
        right: -1px;
        -webkit-transform: translateY (20px) rotate(-45deg);
        transform: translateY(20px) rotate(
                -45deg
        );
    }
    #exchange-password-section .exchange-password-close span:nth-of-type(2) {
        top: -4px;
        right: -1px;
        -webkit-transform: translateY (-20px) rotate(45deg);
        transform: translateY(-20px) rotate(
                45deg
        );
    }

    #exchange-password-section .exchange-password-body {
        height: 204px;
        padding: 20px 22px;
    }
    #exchange-password-section .exchange-password-group {
        font-size: 1.3rem;
        line-height: 40px;
        width: 100%;
        height: 40px;
        margin: 0px 0px 15px;
        overflow: hidden;
    }
    #exchange-password-section .exchange-password-group label {
        display: block;
        width: 30%;
        height: 40px;
        font-weight: 600;
        color: #444;
        line-height: 40px;
        font-size: 1.1rem;
        float: left;
        text-align: left;
    }
    #exchange-password-section .exchange-password-group input {
        display: block;
        float: left;
        width: 70%;
        height: 40px;
        padding: 10px;
        font-size: 1.3rem;
        line-height: 1.5;
        color: #333;
        background-color: #fff;
        border: 1px solid #ededed;
        border-radius: 3px;
    }

    #exchange-password-section .lp_btn_alert {
        text-align: center;
    }
    #exchange-password-section .exchangeepassword {
        display: block;
        width: 170px;
        margin: 5px auto;
        border-radius: 5px;
        border: 1px solid #1daab3;
        height: 35px;
        line-height: 35px;
        font-size: 1.1rem;
        font-weight: 700;
        cursor: pointer;
        color: #1daab3;
    }
    #exchange-password-section .exchangeepassword:hover{
		background:#1daab3; color:#fff;
	}


	/* alert css*/
    #alert-section.on{display:block; }
    #alert-section {
        display: none;
        width: 100%;
        height: 100%;
        position: fixed;
        top: 0;
        left: 0;
        z-index: 100;
        background: rgba(0,0,0,0.5);
    }
    #alert-section .alert {
        position: absolute;
        border-radius: 3px;
        top: 50%;
        left: 50%;
        margin-left: -200px;
        margin-top: -150px;
        background: #fff;
        width: 480px;
        height: 215px;
        text-align: center;
    }

    #alert-section .alert-header h1 {
        width: 70%;
        font-size: 1.1rem;
        text-align: left;
        color: #000;
    }
    #alert-section .alert-body {
        height: 113px;
        padding: 20px 22px;
    }
    #alert-section .alert-group {
        font-size: 1.3rem;
        line-height: 40px;
        width: 100%;
        height: 40px;
        margin-top: 32px;
        overflow: hidden;
    }

    #alert-section .alert-group span {
        display: block;
        /*float: left;*/
        width: 100%;
        height: 40px;
        font-size: 1.3rem;
        line-height: 1.5;
        color: #333;
        background-color: #fff;
        border-radius: 3px;
    }

    #alert-section .confirm-field {
        text-align: center;
    }
    #alert-section .confirm-btn {
        display: block;
        width: 170px;
        margin: 5px auto;
        border-radius: 5px;
        border: 1px solid #1daab3;
        height: 35px;
        line-height: 35px;
        font-size: 1.1rem;
        font-weight: 700;
        cursor: pointer;
        color: #1daab3;
    }
    #alert-section .confirm-btn:hover{
        background:#1daab3; color:#fff;
    }
    #paging_wrap > ul > li > a {
        padding: 2px 10px 3px 10px;
    }
</style>
<section id="exchange-password-section">
	<div class="exchange-password">
		<div class="exchange-password-windows">
			<div class="exchange-password-header">
				<h1 id="exchange-password-title">비밀번호 변경</h1>
				<a class="exchange-password-close">
					<span></span>
					<span></span>
				</a>
			</div>
			<article class="exchange-password-body">
				<div class="exchange-password-group">
					<label for="login-id">ID</label>
					<input type="text" class="inputbox" id="login-id" name="login-id" value="<?=$vUserId?>" disabled>
				</div>
				<div class="exchange-password-group">
					<label for="login-password">비밀번호</label>
					<input id="login-password" type="password" class="inputbox" name="login-password">
				</div>
				<div class="exchange-password-group">
					<label for="login-password-confirm">비밀번호확인</label>
					<input id="login-password-confirm" type="password" class="inputbox" name="login-password-confirm">
				</div>
			</article>
			<p class="lp_btn_alert"><span class="exchangeepassword">변경하기</span></p>
		</div>
	</div>
</section>
<section id="alert-section">
	<div class="alert">
		<div class="alert-windows">
			<article class="alert-body">
				<div class="alert-group">
					<span id="alert-content">test</span>
				</div>
			</article>
			<p class="confirm-field"><span class="confirm-btn">확인</span></p>
		</div>
	</div>
</section>
	<header>
		<nav class="sidebar_wrapper">
			<span class="userid"><?=$vUserId?></span>
			<button type="submit" class="loginoutbtn">로그아웃</button>
			<ul class="menu_list">
				<li class="menu-header">MENU</li>
<?php
                function getPage($vRequestURL){
                    $aResquestURLs = explode('/',$vRequestURL);
                    $vThisPage = $aResquestURLs[2];
                    return $vThisPage;
                }

                $aMenuSet = array();
                if($isSuperAdmin) $aMenuSet['member'] = '관리자 관리';
                $aMenuSet['campaign'] = '캠페인 관리';
				if($isSuperAdmin) $aMenuSet['statistics'] = '통계';


                foreach ($aMenuSet as $pageName =>$menuText){
                    $isOn = null;
                    if(getPage($_SERVER["REQUEST_URI"]) == $pageName){
                        $isOn = 'class = "on" ';
                    }
                    echo ("<li {$isOn}><a href='/admin/{$pageName}'>{$menuText}</a></li>");
                }
?>

			</ul>
		</nav>
		<div class="navbar_bg"></div>
		<div class="right_info">
			<span class="right_info_txt"><span class="userid"><?=$vUserId?></span>님, 반갑습니다!</span>
			<ul class="dropdownmenu">
				<li><a href="/admin/logout">Logout</a></li>
			</ul>	
		</div>
		<a class="menu-trigger">
			<span></span>
			<span></span>
			<span></span>
		</a>
	</header>
<script>

    $(".password-change").on("click",function(){
        $("body").css("overflow-y","hidden");
        $("#exchange-password-section").addClass("on");
    });
	$(".exchange-password-close").on("click",function(){
		$("body").css("overflow-y","auto");
		$("#exchange-password-section").removeClass("on");
	});

	$(".exchangeepassword").on("click",function(){
		if($("#login-password").val()=="") {
			alert("비밀번호를 입력해주세요.");
			$("#login-password").focus();
			return false;
		}
		else if($("#login-password-confirm").val()=="") {
			alert("비밀번호확인을 입력해주세요.");
			$("#login-password-confirm").focus();
			return false;
		}
		else if($("#login-password").val()  !=  $("#login-password-confirm").val()) {
			alert("비밀번호가 일치하지 않습니다.확인해주세요");
			$("#login-password-confirm").focus();
			return false;
		}
		else{
			var loginid = ($("#login-id").val()) ? $("#login-id").val() : null;
			var passwd = ($("#login-password").val()) ? $("#login-password").val() : null;

			var u = "/admin/member/putAdmin";

			var data = {
				"loginid" : loginid,
				"passwd" : passwd,
			};
			$.ajax({
				url:u,
				data: data,
				type:'POST',
				cache:false,
				success:function(response){
					if(response === 'success'){
						alert("비밀번호가 변경되었습니다.");

						$(".exchange-password-close").click();
						$("#login-password").val('');
						$("#login-password-confirm").val('');
					}
					else if(response ===  'error'){
						alert("오류가 발생하였습니다. 새로고침후 다시 시도해주세요.");
					}
				}
			});
		}
	});
</script>