<?php
	$startdateText = isset($_GET['startdate'])?$_GET['startdate']:"";
	$enddateText = isset($_GET['enddate'])?$_GET['enddate']:"";
	$keywordText = isset($_GET['keyword'])?$_GET['keyword']:"";
?>
<link rel="stylesheet" type="text/css" href="<?= ADMIN_CSS ?>/jquery-ui-timepicker-addon.css">
<link rel="stylesheet" type="text/css" href="<?= ADMIN_CSS ?>/jquery-ui.css">
<style>
    #portfolioadmin.main_content #delete-portfolio:hover {
        background: #7b0505;
    }
    .table-top-box{
        float: right;
    }
    .table-top-box img{
        margin-top: 10px;
    }
	.list_subejct:hover{
		cursor: pointer;
		color: blue;
	}
    .list_subejct{
        text-decoration-line: underline;
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
	.search-button{
		width: 98px;
		height: 30px;
		border-radius: 15px;
		font-size: 1.0rem;
		color: #555;
		border: 1px solid #555;
		background: #fff;
		margin-right: 20px;
		margin-top: 5px;
	}
	.search-button:hover{
		background:#555;
		color:#fff;
	}
    .table-top-box #keyword {
        display: inline-block;
        width: 200px;
        height: 40px;
        padding: 10px;
        font-size: 1.3rem;
        line-height: 1.5;
        color: #333;
        background-color: #fff;
        border: 1px solid #ededed;
        border-radius: 3px;
        margin-bottom: 15px;
    }
    .search-box-date {
        display: inline-block;
        width: 200px;
        height: 40px;
        padding: 10px;
        font-size: 1.3rem;
        line-height: 1.5;
        color: #333;
        background-color: #fff;
        border: 1px solid #ededed;
        border-radius: 3px;
        margin-bottom: 15px;
    }
</style>
<section id="portfolioadmin" class="main_content">
		<h1>캠페인 관리</h1>
		<div class="table_wrap">
			<div class="table-top-box">
				<img src="<?=ADMIN_IMG?>/calender.png" width="20px">
				<input type="text" name="startdate" class="datetime search-box-date" id="startdate"value="<?=$startdateText?>">
				<img src="<?=ADMIN_IMG?>/oneside.png" width="20px">
				<img src="<?=ADMIN_IMG?>/calender.png" width="20px">
				<input type="text" name="enddate" class="datetime search-box-date" id="enddate" value="<?=$enddateText?>">
				<img src="<?=ADMIN_IMG?>/search.png" width="20px">
				<input type="text" name="keyword" id="keyword" placeholder="닉네임 입력" value="<?=$keywordText?>">
				<button type="button" class="search-button">검색</button>
				<span class="newport" style="cursor: pointer">캠페인 생성</span>
			</div>
			<table class="tablelist">
				<colgroup>
					<col style="width:5%;">
					<col style="width:25%;">
					<col style="width:10%;">
					<col style="width:10%;">
					<col style="width:10%;">
					<col style="width:5%;">
					<col style="width:10%;">
					<col style="width:25%;">
				</colgroup>
				<thead>
					<tr>
						<th>번호</th>
						<th>캠페인명</th>
						<th>생성자</th>
						<th>생성일</th>
						<th>일정</th>
						<th>상태</th>
						<th>신청자수(당첨수)</th>
						<th>작업</th>
					</tr>
				</thead>
				<tbody>
				<?php if(count($list) == 0){?>
                    <tr>
                        <td colspan="8">등록된 캠페인이 없습니다.</td>
                    </tr>
			<?php } else {
				foreach($list as $row){
					$nApplicantCount = isset($row['nApplicantCount'])?$row['nApplicantCount']:0;
					$nWinningCount = isset($row['nWinningCount'])?$row['nWinningCount']:0;
					$isOpenText = "";
					if($row['isOpenText'] == "ready") $isOpenText = "오픈 대기";
					if($row['isOpenText'] == "open") $isOpenText = "오픈";
					if($row['isOpenText'] == "end") $isOpenText = "종료";
					?>

					<tr>
						<td><?=$row['nSeqNo'];?></td>
						<td class="request_title"><a class="list_subejct" data-no="<?=$row['nSeqNo']?>"><?=$row['vSubject']?></td>
						<td><?=$row['vNickName']?><br/>(<?=$row['vUid']?>)</td>
						<td><?=substr($row['dtRegDate'],0,10)?></td>
						<td><?=substr($row['dtStartDate'],0,10)?><br/>~<br/><?=substr($row['dtEndDate'],0,10)?></td>
						<td><?=$isOpenText;?></td>
						<td><?=$nApplicantCount;?>(<?=$nWinningCount?>)/<?=$row['nMaxApplicant']?></td>
                        <td>
                            <button type="button" class="modifyadmin copy-campaign" data-no="<?=$row['nSeqNo']?>"><a href="#">URL 이동</a></button>
                            <button type="button" class="modifyadmin modify-campaign" data-no="<?=$row['nSeqNo']?>"><a href="#">상세</a></button>
                            <button type="button" class="modifyadmin delete-campaign" data-no="<?=$row['nSeqNo']?>"><a href="#">삭제</a></button>
                        </td>
					</tr>
			<?php
				}
			}
			?>
				</tbody>
			</table>
		</div>
		<!--페이징-->
        <?=$paging?>
	</section>
	<section id="lp_admin_join">

	</section>
	<section id="lp_admin_delete">
		<div class="lp_admin">
			<p>캠폐인을 정말 삭제하시겠습니까?</p>
			<p class="lp_btn_alert"><span class="deletebtn_finish">삭제</span><span class="deletebtn_cancel">취소</span></p>
		</div>
	</section>
</body>
<script src="<?=ADMIN_JS?>/menu.js"></script>
<script src="<?= ADMIN_JS ?>/jquery-ui.min.js"></script>
<script src="<?= ADMIN_JS ?>/jquery-ui-timepicker-addon.js"></script>
<script>
	$(".datetime").datepicker({
		dateFormat: 'yy-mm-dd',
		prevText: '이전 달',
		nextText: '다음 달',
		monthNames: ['1월','2월','3월','4월','5월','6월','7월','8월','9월','10월','11월','12월'],
		monthNamesShort: ['1월','2월','3월','4월','5월','6월','7월','8월','9월','10월','11월','12월'],
		dayNames: ['일','월','화','수','목','금','토'],
		dayNamesShort: ['일','월','화','수','목','금','토'],
		dayNamesMin: ['일','월','화','수','목','금','토'],
		showMonthAfterYear: true,
		yearSuffix: '년',
		timeFormat:'HH:mm',
		controlType:'select',
		oneLine:true
	});

	$(".list_subejct").on("click", function(){
		$('#lp_admin_join').load("/admin/campaign/detail",{"no":$(this).data('no')});
		$('#lp_admin_join').addClass("on");
	});

	$(".copy-campaign").on("click", function(){
		var http = window.location.protocol;
		var url = window.location.hostname;
		var port = window.location.port;
		var urlString = "";
		if(http) urlString += http+"//";
		if(url) urlString += url;
		if(port) urlString += ":"+port;
		window.open(urlString+"?campaign_no="+$(this).data("no"));
	});

	$(".delete-campaign").on("click",function(){
		$("#lp_admin_delete").addClass("on");
		$('.deletebtn_finish').data('no',$(this).data('no'));
		$(".deletebtn_finish").on("click",function() {
			var no = $(this).data('no');
			var u = "campaign/rmcampaign";

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

    $(".newport").on("click", function(e){
        $(location).attr('href','/admin/campaign/write');
    });

	$('.search-button').on("click", function(){
		search();
	});

	$('.modify-campaign').on("click", function(){
		var form = document.createElement('form');
		var objs;
		objs = document.createElement('input');
		objs.setAttribute('type', 'hidden');
		objs.setAttribute('name', 'no');
		objs.setAttribute('value', $(this).data('no'));
		form.appendChild(objs);
		form.setAttribute('method', 'post');
		form.setAttribute('action', "campaign/modify");
		document.body.appendChild(form);
		form.submit();
	});

	function search(){
		var keyword = $('#keyword').val();
		var startdate = $('#startdate').val();
		var enddate = $('#enddate').val();
		var queryString = "";
		if(startdate){
			queryString += "&startdate="+startdate;
		}
		if(enddate){
			queryString += "&enddate="+enddate;
		}
		if(keyword){
			queryString += "&keyword="+keyword;
		}
		window.location.href="campaign?1=1"+queryString;
	}

	function saveClipboard(string){
		var textarea = document.createElement('textarea');
		textarea.value = string;

		document.body.appendChild(textarea);
		textarea.select();
		textarea.setSelectionRange(0, 9999);

		document.execCommand('copy');
		document.body.removeChild(textarea);
	}

</script>
</html>