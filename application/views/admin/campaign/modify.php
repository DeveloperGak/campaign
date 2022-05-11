<link rel="stylesheet" type="text/css" href="<?= ADMIN_CSS ?>/detail.css">
<link rel="stylesheet" type="text/css" href="<?= ADMIN_CSS ?>/jquery-ui-timepicker-addon.css">
<link rel="stylesheet" type="text/css" href="<?= ADMIN_CSS ?>/jquery-ui.css">
<?php
//	echo "<pre>".print_r($list,TRUE)."</pre>";
	$vSubject = null;
	$nMaxApplicant = null;
	$vLotteryWords = null;
	$vMoFileName = null;
	$vPcFileName = null;
	$dtStartDate = null;
	$dtEndDate = null;
	$emOpenFlag = null;
	$applicantTotalCount = 0;
	if(!empty($list['vSubject'])) $vSubject = $list['vSubject'];
	if(!empty($list['nMaxApplicant'])) $nMaxApplicant = $list['nMaxApplicant'];
	if(!empty($list['vLotteryWords'])) $vLotteryWords = $list['vLotteryWords'];
	if(!empty($list['vMoFileName'])) $vMoFileName = $list['vMoFileName'];
	if(!empty($list['vPcFileName'])) $vPcFileName = $list['vPcFileName'];
	if(!empty($list['dtStartDate'])) $dtStartDate = $list['dtStartDate'];
	if(!empty($list['dtEndDate'])) $dtEndDate = $list['dtEndDate'];
	if(!empty($list['emOpenFlag'])) $emOpenFlag = $list['emOpenFlag'];
	if(!empty($applicant[0]['nTotalCount'])) $applicantTotalCount = $applicant[0]['nTotalCount'];
?>
<style>
    #portdetail .datetime  {
        border: 1px solid #ddd;
        padding-left: 5px;
        border-radius: 5px;
        font-size: 1.2rem;
        height: 37px;
		width: 18%;
        line-height: 37px;
        margin-left: 3%;
    }
	#max-applicant{
		width: 100px;
	}
	.write-content-td{
		margin-left: 3%;
	}
	.notice-text{
		color: red;
		padding: 10px;
	}
	.campagin-button {
        width: 220px;
        height: 35px;
        border-radius: 15px;
        font-size: 1.1rem;
        color: #555;
        border: 1px solid #555;
        background: #fff;
        position: absolute;
        margin-left: 16px;
        text-align: center;
    }
    .campagin-button div{
        margin-top: 8px;
    }
    .campagin-button div:hover{
        cursor: pointer;
    }
    .campagin-button:hover{
        cursor: pointer;
        background:#555;
        color:#fff;
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
</style>
<section id="portdetail" class="main_content">
    <h1>캠페인 상세</h1>
    <div class="table_wrap">
        <a href="/admin/campaign" class="listpage">목록으로</a>
        <table class="detail_table">
            <form name="campaign-form" id="campaign-form" method="post" action="/admin/campaign/putcampaign" enctype="multipart/form-data">
                <tbody>
                <tr>
                    <th>캠페인 명</th>
                    <td><input type="text" class="detail_input" id="campaign-title" name="campaign-title" value="<?=$vSubject?>"></td>
                </tr>
				<tr>
					<th>기간</th>
					<td>
						<input type='text' name='start-date' id='start-date' class='datetime' autocomplete="off" value='<?=$dtStartDate?>' />
						<span>~</span>
						<input type='text' name='end-date' id='end-date' class='datetime endtime' autocomplete="off" value='<?=$dtEndDate?>' />
					</td>
				</tr>
				<tr>
					<th>최대 신청자 수</th>
					<td>
						<input type="text" class="detail_input number" id="max-applicant" name="max-applicant" maxlength="5" value="<?=$nMaxApplicant?>" disabled style="width: 15%">
						<span class="campagin-button"><div>신청자 목록 (<?=$applicantTotalCount?>/<?=$nMaxApplicant?>)</div></span>
						<div class="write-content-td notice-text">
							<span>*캠페인 생성 후에 신청자수 수정은 불가능합니다.</span>
						</div>
					</td>

				</tr>
                <tr>
                    <th>이미지 등록(PC)</th>
                    <td>
						<div class="write-content-td">
							<img id="pc-uploaded-img" name="pc-uploaded-img" src="<?=PCIMG_WEB_PATH.$list['vPcRealFileName'];?>" alt="" width="300px">
							<br/>
							<input type="file" class="pc-upload_file" name="pc-upload_file" >
						</div>
                    </td>
                </tr>
				<tr>
					<th>이미지 등록(MO)</th>
					<td>
						<div class="write-content-td">
							<img id="uploaded-img" name="uploaded-img" src="<?=MOIMG_WEB_PATH.$list['vMoRealFileName'];?>" alt="" width="300px">
							<br/>
							<input type="file" class="mo-upload_file" name="mo-upload_file" >
						</div>
					</td>
				</tr>
				<tr>
					<th>캠페인 상태 변경</th>
					<td>
						<div class="write-content-td">
							<input type="radio" name="is-open" id="open" value="Y" <?php if($emOpenFlag == "Y") echo "checked";?>><label for="open">오픈</label>
							<input type="radio" name="is-open" id="close" value="N" <?php if($emOpenFlag == "N") echo "checked";?>><label for="close">종료</label>
						</div>
					</td>
				</tr>
                </tbody>
				<input type="hidden" name="no" id="no" value="<?=$list['nSeqNo']?>">
            </form>
        </table>
        <button type="submit" class="savebtn">생성 완료</button>
    </div>
</section>
<section id="lp_admin_join">

</section>
</body>
<!--네이버 스마트 에디터-->
<script src="<?= ADMIN_JS ?>/menu.js"></script>
<script src="<?= ADMIN_JS ?>/jquery-ui.min.js"></script>
<script src="<?= ADMIN_JS ?>/jquery-ui-timepicker-addon.js"></script>
<script>
    $(function () {
    	$(".campagin-button").on("click", function (){
			$('#lp_admin_join').load("/admin/campaign/detail",{"no":'<?=$list['nSeqNo']?>'});
			$('#lp_admin_join').addClass("on");
		});
		$(".number").on("keyup", function(){
			this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');
		});
		$(".datetime").datetimepicker({
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

        $(".endtime").on("change", function () {
            $(this).val($(this).val().substring(0,10) + " 23:59:59");
        });

        $(".savebtn").on("click", function () {
            var url = "/admin/campaign/putcampaign";
            var aForm = $('#campaign-form');
            var formData = new FormData(aForm[0]);

			$.ajax({
				url:url,
				data:formData,
				type:'POST',
				processData:false,
				contentType:false,
				cache:false,
				success:function(response){
					if(response === "success"){
						alert('등록되었습니다');
						$(location).attr('href','/admin/campaign');
					}
					else if(response.indexOf("|") !== -1){
						alert(response.split('|')[1]);
					}
					else{
						alert("오류가 발생하였습니다.");
					}
				}
			})
        });

    });
</script>
</html>