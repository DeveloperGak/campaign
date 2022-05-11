$(function(){
	$(".number").on("keyup", function(){
		this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');
	});
	//관리자 등록 버튼 클릭 이벤트
	$(".newadmin").on("click",function(){
		$("body").css("overflow-y","hidden");
		$("#lp_admin_join").addClass("on");
	});

	//관리자등록 레이어팝업 닫기 이벤트
	$(".lpclose").on("click",function(){
		$("body").css("overflow-y","auto");
		$("#lp_admin_join").removeClass("on");
	});

	$(".detail-admin").on("click",function(){
		var no = $(this).data("no");
		var u = "member/getAdminInfo";

		var data = {
			"no" : no
		};
		$.ajax({
			url:u,
			data: data,
			type:'POST',
			cache:false,
			success:function(response){
				var level = response['nLevel'];
				var levelText = "캠페인 담당자";
				if(level === "1"){
					levelText = "전체 관리자";
				}
				$('#modi-userid').val(response['vUid']);
				$('#modi-level').val(levelText);
				$('#modi-call').val(response['vCall']);
				$('#modi-nickname').val(response['vNickName']);
				$('#modi-no').val(no);

				$("body").css("overflow-y","hidden");
				$("#lp_admin_modify").addClass("on");
			}
		});
	});


	$(".registerbtn").on("click",function(){
		if($("#userid").val()=="") {
			alert("아이디를 입력해주세요.");
			$("#userid").focus();
			return false;    	
		}
		if($("#nickname").val()=="") {
			alert("닉네임을를 입력해주세요.");
			$("#nickname").focus();
			return false;    	
		}
		if($("#call").val()=="") {
			alert("전화번호를 입력해주세요.");
			$("#call").focus();
			return false;
		}
		var level = $('input[name=level]:checked').attr('id');
		if(!level) {
			alert("관리자 레벨을 선택해주세요.");
			$("#qualification").focus();
			return false;
		}
		if($("#passwd").val()=="") {
			alert("비밀번호를 입력해주세요.");
			$("#passwd").focus();
			return false;
		}

		else{
			var userid = ($("#userid").val()) ? $("#userid").val() : null;
			var nickname = ($("#nickname").val()) ? $("#nickname").val() : null;
			var call = ($("#call").val()) ? $("#call").val() : null;
			var passwd = ($("#passwd").val()) ? $("#passwd").val() : null;

			var u = "member/postadmin";

			var data = {
				"userid" : userid,
				"nickname" : nickname,
				"call" : call,
				"passwd" : passwd,
				"lavel" : level
			};
			$.ajax({
				url:u,
				data: data,
				type:'POST',
				cache:false,
				success:function(response){
					if(response === 'exist'){
						alert("아이디가 중복 되었습니다.");
					}
					else if(response ===  'done'){
						alert("관리자 생성이 완료되었습니다.");
						location.reload();
					}
				}
			});
		}
	});


	//전문가수정 레이어팝업 닫기 이벤트
	$(".lpclose_modify").on("click",function(){
		$("body").css("overflow-y","auto");
		$("#lp_admin_modify").removeClass("on");
	});
	//
	//전문가수정 - 수정완료
	$(".modifybtn").on("click",function(){
		if($('#modi-passwd').val() !== "" && $('#modi-passwd').val() !== $('#modi-repasswd').val()){
			alert('비밀번호가 일치하지 않습니다.');
			return false;
		}
		if($('#modi-nickname').val() == ""){
			alert('닉네임을 입력해주세요.');
			return false;
		}
		else{
			var modiNo = $('#modi-no').val();
			var modiRePassword = $('#modi-repasswd').val();
			var modiNickName = $('#modi-nickname').val();
			var u = "member/putadmin";

			var data = {
				"modiNo" : modiNo,
				"modiRePassword" : modiRePassword,
				"modiNickName" : modiNickName
			};

			$.ajax({
				url:u,
				data: data,
				type:'POST',
				cache:false,
				success:function(response){
					if(response === "success"){
						alert("정보수정이 완료되었습니다.");
						$("body").css("overflow-y", "auto");
						$("#lp_admin_modify").removeClass("on");
						location.reload();
					}
					else{
						alert('정보 변경도중 오류가 발생하였습니다.')
					}

				}
			});

		}
	});
	//관리자수정 - 관리자삭제
	$(".delete-admin").on("click",function(){
			$("#lp_admin_delete").addClass("on");
			$('.deletebtn_finish').data('no',$(this).data('no'));
		$(".deletebtn_finish").on("click",function() {
				var no = $(this).data('no');
				var u = "member/rmadmin";

				var data = {
					"no" : no
				};
				$.ajax({
					url:u,
					data: data,
					type:'POST',
					cache:false,
					success:function(response){
						if(response === 'error'){
							alert("에러가 발생하였습니다.");
						}
						else if(response === 'success'){
							alert("삭제가 완료되었습니다.");
							location.reload();
						}
					}
				});
		});
		$(".deletebtn_cancel").on("click",function(){
			$("#lp_admin_delete").removeClass("on");
		});
	});
});