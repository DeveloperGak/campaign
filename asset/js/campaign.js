$(function(){
	$(".number").on("keyup", function(){
		this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');
	});

	$('#usertel').on("keyup",function(){
		if($(this).val().length > 10){
			$('.authbtn').addClass("on");
		}
		else{
			$('.authbtn').removeClass("on");
		}
	})

	$(".authconfirmbtn").click(function(){
		if($(this).attr('class') !== "authconfirmbtn"){
			var u = "certification";
			var data = {
				"no": $('#no').val()
				,"phone": $('#sent-number').val()
				,"code": $('#userauth').val()
			};
			$.post(u, data, function(response){
				if(response == "success"){
					alterAlertTextAndPopup("인증이 완료되었습니다.");
					$(".authconfirmbtn").removeClass('on');
					$('.authbtn').removeClass('on');
					$('#usertel').prop('disabled',true);
					$('#userauth').prop('disabled',true);
				}
				else {
					alterAlertTextAndPopup("오류가 발생하였습니다.");
				}
			});

		}
	});

	$(".alert_close_layer").on("click", function() {
		$(".layer_alert_wrap").hide();
	});

	$(".submitbtn").on("click", function() {
		var serviceagree = !$('#serviceagree').prop("checked");
		var isValidate = true;
		if($('#username').val() == ""){
			// alterAlertTextAndPopup("성명을 입력해 주세요.");
			isValidate = false;
			// return false;
		}
		if(serviceagree){
			isValidate = false;
			// return false;
		}
		if(isValidate){
			var u = "apply";
			var data = {
				"no": $('#no').val()
				,"phone": $('#sent-number').val()
				,"username": $('#username').val()
			};
			$.post(u, data, function(response){
				if(response == "success"){
					$('.form_write_wrap').hide();
					$('.form_write_finish').show();
				}
				else if(response == "finish"){
					window.location.reload();
				}
				else {
					alterAlertTextAndPopup("오류가 발생하였습니다.");
				}
			});
		}
		else{
			alterAlertTextAndPopup("필수정보를 모두 입력/동의 해주세요.");
		}
	});

});

function alterAlertTextAndPopup(text){
	$('.layer_alert_contain > .content').html(text);
	$(".layer_alert_wrap").show();
}