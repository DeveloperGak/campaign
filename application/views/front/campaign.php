<?php
	if(isset($campaign)){
		if($device == "mo"){
			$css = MO_CSS;
			$img = MO_IMG;
			$eventImage = $campaign['vMoRealFileName'];
		}
		else if ($device == "pc"){
			$css = PC_CSS;
			$img = PC_IMG;
			$eventImage = $campaign['vPcRealFileName'];
		}
		$eventImagePath = IMG_WEB_PATH."{$device}/{$eventImage}";
	}
	else{
		echo "캠페인을 찾을수 없습니다.";
		exit;
	}

?>
<title><?=$campaign['vSubject']?></title>
<link rel="stylesheet" type="text/css" href="<?=$css?>/common.css?<?=VERSION?>">
<link rel="stylesheet" type="text/css" href="<?=$css?>/main.css?<?=VERSION?>">
<section>
	<div class="img_wrap">
		<img src='<?=$eventImagePath?>' alt='이벤트이미지'>
	</div>
	<!--이벤트응모-->
	<?php
	if($campaign['isOpenText'] == "end"){
		echo ("
			<div class='event_end'>
				<img src='{$img}/event_end.jpg' alt='이벤트기간종료'>
			</div>
		");
	}
	else{
		echo("
			<div class='form_write_wrap'>
			<p class='name_form'>
				<label for='username'>성명</label>
				<input type='text' id='username' placeholder='성명을 입력해주세요.'>
			</p>
			<p class='tel_form'>
				<label for='usertel'>휴대전화</label>
				<input type='text' class='number' id='usertel' placeholder='휴대전화를 입력해주세요.' maxlength='11'>
			</p>
			<p class='auth_form'>
			</p>
			<p class='check_form'>
				<input type='checkbox' name='chk' class='chk' id='serviceagree'>
				<label for='serviceagree' class='chkbox type_agree'>이벤트 응모를 위한 개인 정보 제공에 동의합니다.</label>
			</p>
			<div class='btn_wrap'>
				<button class='submitbtn'>이벤트 응모하기</button>
			</div>
			<input type='hidden' name='no' id='no' value='{$campaign['nSeqNo']}'>
			<input type='hidden' name='sent-number' id='sent-number' value=''>
	
			<div class='layer_alert_wrap'>
				<div class='layer_alert_contain'>
					<div class='content'>
						
					</div>
					<button class='alert_close_layer'>확인</button>
				</div>
			</div>
		</div>
		<div class='form_write_finish' style='display: none;'>
			<img src='{$img}/event_finish.jpg' alt='이벤트응모완료'>
		</div>
		");
	}
	?>

</section>
<script type="text/javascript" src="<?=JS?>/campaign.js"></script>
