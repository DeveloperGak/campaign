<?php
	$no = isset($no)?$no:"";
	$keywordText = isset($_GET['keyword'])?$_GET['keyword']:"";

	$nMaxApplicant = "";
	$nTotalCount = "";
	$aLotteryWords = array();
	if(!empty($list[0])){
		$nMaxApplicant = $list[0]['nMaxApplicant'];
		$nTotalCount = $list[0]['nTotalCount'];
		$aLotteryWords = explode(",", $list[0]['vLotteryWords']);
	}
	if(!empty($_GET['page'])){
		$pageText = $_GET['page'] ;
	}
	else {
		$pageText = "";
	}
	if(!empty($_GET['keyword'])){
		$keywordText = $_GET['keyword'] ;
	}
	else {
		$keywordText = "";
	}

?>

	<div class="lp_admin">
		<div class="lp_admin_form">
			<div class="lp_header">
				<h1>캠페인 신청자 목록 (<?=$nTotalCount?> / <?=$nMaxApplicant?>)</h1>
				<a class="lpclose">
					<span></span>
					<span></span>
				</a>
			</div>
			<style>
                .lp-alert.noselect{
                    float: right;
                    color: red;
                    margin-right: 20px;
                }
                .lp-table-search-box{
                    float: left;
                    margin-left: 20px;
					margin-top: 20px;
                }
                .lp-table-search-box img{
                    margin-top: 10px;
                }
                .lp-table-search-box input{
					vertical-align: middle;
                    width: 215px;
                    height: 40px;
                    padding: 10px;
                    line-height: 1.5;
                    color: #333;
                    background-color: #fff;
                    border: 1px solid #ededed;
                    border-radius: 3px;
                    margin-bottom: 15px;
                }
                .lp-table-lottery-box{
                    float: right;
                }
                .lp-table-lottery-box div{
                    margin-top: 19px;
                }
                .lp-table-lottery-box select{
                    min-width: 50px;
                    height: 40px;
                    padding: 10px;
                    line-height: 1.5;
                    color: #333;
                    background-color: #fff;
                    border: 1px solid #ededed;
                    border-radius: 3px;
                    margin-bottom: 15px;
                     -webkit-appearance: listbox;
                    -moz-appearance: listitem;
                     appearance: auto;
                }
				.lp_table_wrap{
					padding: 10px;
				}
                .lp_table_wrap .tablelist thead th {
                    font-size: 16px;
                    border-bottom: none;
                    background-color: #e7e7e7;
                    color: #666;
                    padding: 16px 0px;
                }
                .lp_table_wrap .tablelist tbody tr {
                    height: 39px;
                    font-size: 16px;
                    cursor: default;
                    text-align: center;
                    border-bottom: 1px solid rgb(233, 233, 233);
                }
				.excel-download-box{
					width: 100px;
					float: right;
					margin-right: 33px;
				}
				.excel-download{
                    height: 30px;
					width: 130px;
                    border-radius: 15px;
                    font-size: 1.0rem;
                    color: #555;
                    border: 1px solid #555;
                    background: #fff;
                    margin-right: 20px;
                    margin-top: 20px;
				}
                .excel-download:hover {
                    background: #057b23;
					color: white;
                }
				.ministat-wrap{
					overflow-y: auto;
					height: 133px;
				}
                #lp_admin_join .lp_admin {
                    position: absolute;
                    border-radius: 3px;
                    top: 50%;
                    left: 40%;
                    margin-left: -200px;
                    margin-top: -415px;
                    background: #fff;
                    width: 825px;
                    height: 810px;
                    text-align: center;
                }
				/*컨펌모달 레이어팝업*/
				#lp_modal_confirm{display:none;width:100%; height:100%; position:fixed; top:0; left:0; z-index:100; background: rgba(0,0,0,0.5); }
				#lp_modal_confirm.on{display:block; }
				#lp_modal_confirm .lp_modal {position: absolute;border-radius: 3px;top: 44%;left: 50%;margin-left: -200px;margin-top: -80px;background: #fff;width: 480px;height: 202px;text-align: center;}
				#lp_modal_confirm .lp_modal p{height:80px; line-height: 27px; font-size: 17px;}
				#lp_modal_confirm .lp_modal_btn_box{overflow:hidden; margin-left:14%;margin-top: 42px;}
				#lp_modal_confirm .lp_modal_btn_confirm{display:block; float:left;width:170px; margin:5px auto; border-radius:5px; border:1px solid #555; height:35px; line-height:35px; font-size:1.1rem;  font-weight:700; cursor:pointer; color:#555; margin-right:15px; }
				#lp_modal_confirm .lp_modal_btn_confirm:hover{background:#555; color:#fff;}
				#lp_modal_confirm .lp_modal_btn_cancel{display:block; float:left; width:170px; margin:5px auto; border-radius:5px; border:1px solid #e30000; height:35px; line-height:35px; font-size:1.1rem;  font-weight:700; cursor:pointer; color:#e30000}
				#lp_modal_confirm .lp_modal_btn_cancel:hover{background:#e30000; color:#fff;}

                /*알럿모달 레이어팝업*/
                #lp_modal_alert{display:none;width:100%; height:100%; position:fixed; top:0; left:0; z-index:100; background: rgba(0,0,0,0.5); }
                #lp_modal_alert.on{display:block; }
                #lp_modal_alert .lp_modal {position: absolute;border-radius: 3px;top: 44%;left: 50%;margin-left: -200px;margin-top: -80px;background: #fff;width: 480px;height: 202px;text-align: center;}
                #lp_modal_alert .lp_modal p{height:80px; line-height: 141px; font-size: 18px;}
                #lp_modal_alert .lp_modal_btn_box{overflow:hidden; margin-left:32%;margin-top: 42px;}
                #lp_modal_alert .lp_modal_btn_alert{display:block; float:left;width:170px; margin:5px auto; border-radius:5px; border:1px solid #555; height:35px; line-height:35px; font-size:1.1rem;  font-weight:700; cursor:pointer; color:#555; margin-right:15px; }
                #lp_modal_alert .lp_modal_btn_alert:hover{background:#555; color:#fff;}
                #lp_modal_alert .lp_modal_btn_cancel{display:block; float:left; width:170px; margin:5px auto; border-radius:5px; border:1px solid #e30000; height:35px; line-height:35px; font-size:1.1rem;  font-weight:700; cursor:pointer; color:#e30000}
                #lp_modal_alert .lp_modal_btn_cancel:hover{background:#e30000; color:#fff;}
			</style>
			<article class="lp_table_wrap">
				<div>
					<div class="lp-table-search-box">
						<img src="<?=ADMIN_IMG?>/search.png" class="search-img" width="20px">
						<input type="text" name="lp-keyword" id="lp-keyword" class="search-box-keyword" placeholder="이름, 휴대폰번호 입력" value="<?=$keywordText?>">
						<button type="button" class="search-button lp-search">검색</button>
					</div>
					<div class="lp-table-lottery-box">
						<span class="lp-alert noselect">*당첨형태 미선택시 "미당첨" 으로 분류</span>
						<div>
							<select name="lottery-value" id="lottery-value">
								<?php
									if($aLotteryWords){
										foreach ($aLotteryWords as $lotteryWord){
											$lotteryWord = trim($lotteryWord);
											echo ("<option value='{$lotteryWord}'>{$lotteryWord}</option>");
										}
									}
								?>
							</select>
							<button type="button" class="search-button lp-lottery-save">적용</button>
						</div>
					</div>
				</div>
				<table class="tablelist">
					<thead>
					<tr>
						<th>선택</th>
						<th>이름</th>
						<th>전화번호</th>
						<th>상태</th>
					</tr>
					</thead>
					<?php if(count($list) == 0){?>
						<tr>
							<td colspan="4">캠페인 신청자가 없습니다.</td>
						</tr>
					<?php } else {
						foreach($list as $row){
							$vWinningWord = $row['vWinningWord']?$row['vWinningWord']:"미당첨";
					?>
							<tr>
								<td><input type="checkbox" name="lottery-check" data-no="<?=$row['nCampSeqNo']?>" data-phone="<?=$row['vPhone']?>"></td>
								<td><?=$row['vName']?></td>
								<td><?=$row['vPhone'];?></td>
								<td><?=$vWinningWord?></td>
							</tr>
					<?php
						}
					}
					?>
				</table>
				<?=$paging?>
			</article>
			<article class="lp_table_wrap ministat-wrap">

			</article>
		</div>
	</div>
<section id="lp_modal_confirm">
	<div class="lp_modal">
		<p class="lp_modal_text confirm_text"></p>
		<p class="lp_modal_btn_box"><span class="lp_modal_btn_confirm">확인</span><span class="lp_modal_btn_cancel">취소</span></p>
	</div>
</section>
<section id="lp_modal_alert">
	<div class="lp_modal">
		<p class="lp_modal_text alert_text"></p>
		<p class="lp_modal_btn_box"><span class="lp_modal_btn_alert">확인</span></p>
	</div>
</section>
<input type="hidden" name="no" id="no" value="<?=$no?>">
<input type="hidden" name="page" id="page" value="<?=$pageText?>">
<input type="hidden" name="keyword" id="keyword" value="<?=$keywordText?>">
<script>
	loadMiniStat();

	$('.lp_modal_btn_cancel').on("click", function (){
		$('#lp_modal_confirm').removeClass('on');
	});
	$('.lp_modal_btn_alert').on("click", function (){
		$('#lp_modal_alert').removeClass('on');
	});
	$(".lp-lottery-save").on("click", function (){
		var confirmText = "당첨처리 하시겠습니까?";
		modalConfirm(confirmText, 'putapplicant');
	});
	$('.lp_modal_btn_confirm').on("click", function(){
		putapplicant();
	});

	$(".lpclose").on("click",function(){
		$("body").css("overflow-y","auto");
		$("#lp_admin_join").removeClass("on");
	});
	function loadPage(queryString){
		var no = $('#no').val();
		var addString = "";
		if(queryString) addString += '&page='+queryString;
		$('#lp_admin_join').load("/admin/campaign/detail?1=1"+addString,{"no":no});
	}

	function ReloadPage(){
		var page = $('#page').val();
		var keyword = $('#keyword').val();
		var queryString = "";
		if(page) queryString +=page;
		if(keyword) queryString +="&keyword="+keyword;
		loadPage(queryString);
	}
	function loadMiniStat(){
		var no = $('#no').val();
		$('.ministat-wrap').load('/admin/campaign/ministat',{"no":no})
	}
	$(".lp-search").on("click", function (){
		var no = $('#no').val();
		var keyword = $('#lp-keyword').val();
		var queryString = "";
		if(keyword){
			queryString += "&keyword="+keyword;
		}
		$('#lp_admin_join').load("/admin/campaign/detail?1=1"+queryString,{"no":no});
	});

	function modalConfirm(text){
		$('.confirm_text').html(text);
		$('#lp_modal_confirm').addClass("on");
	}

	function modalAlert(text){
		$('.alert_text').html(text);
		$('#lp_modal_alert').addClass("on");
	}


	function putapplicant(){
		var lotteryValue = $('#lottery-value').val();
		var data = [];
		$('input[name=lottery-check]:checked').each(function (i,v){
			if(lotteryValue){
				var no = v.dataset.no;
				var phone = v.dataset.phone;
				data.push({
					"no": no
					,"phone": phone
					,"winning": lotteryValue
				});
			}
		});
		var url = "/admin/campaign/putapplicant";

		var dataset = JSON.stringify(data);
		$.ajax({
			url:url,
			data: {"dataset": dataset},
			type:'POST',
			cache:false,
			success:function(response){
				$('#lp_modal_confirm').removeClass("on");
				loadMiniStat();
				if(response === "success"){
					ReloadPage();
				}
				else if(response.indexOf("|") !== -1){
					$('#lp_modal_confirm').removeClass("on");
					modalAlert(response.split("|")[1]);
				}
				else{
					alert("오류가 발생하였습니다.");
				}
			}
		});
	}

</script>