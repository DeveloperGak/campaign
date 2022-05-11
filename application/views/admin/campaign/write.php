<link rel="stylesheet" type="text/css" href="<?= ADMIN_CSS ?>/detail.css">
<link rel="stylesheet" type="text/css" href="<?= ADMIN_CSS ?>/jquery-ui-timepicker-addon.css">
<link rel="stylesheet" type="text/css" href="<?= ADMIN_CSS ?>/jquery-ui.css">
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
</style>
<section id="portdetail" class="main_content">
    <h1>캠페인 생성</h1>
    <div class="table_wrap">
        <a href="/admin/campaign" class="listpage">목록으로</a>
        <?php
//        $porfolio =  isset($list[0])?$list[0]:null;
//        $porfolio['vSubject'] = isset($porfolio['vSubject'])?$porfolio['vSubject']:null;
//        $porfolio['txIntroduce'] = isset($porfolio['txIntroduce'])?$porfolio['txIntroduce']:null;
//        $porfolio['txContent'] = isset($porfolio['txContent'])?$porfolio['txContent']:null;
//        $porfolio['vRealFileName'] = isset($porfolio['vRealFileName'])?$porfolio['vRealFileName']:null;
//        $porfolio['vFileName'] = isset($porfolio['vFileName'])?$porfolio['vFileName']:null;
//        $porfolio['nSeqNo'] = isset($porfolio['nSeqNo'])?$porfolio['nSeqNo']:null;
//        $vField = isset($porfolio['vField'])?$porfolio['vField']:"";
//        $vCategory = isset($porfolio['vCategory'])?$porfolio['vCategory']:"";
//        //            echo "<pre>".print_r($porfolio,TRUE)."</pre>";
//
//        $img = "";
//        if($porfolio['vRealFileName']){
//            $img = "{$porfolio['vPath']}{$porfolio['vFileName']}";
//        }
        ?>
        <table class="detail_table">
            <form name="portfolio-form" id="portfolio-form" method="post" action="/admin/campaign/postcampaign" enctype="multipart/form-data">
                <tbody>
                <tr>
                    <th>캠페인 명</th>
                    <td><input type="text" class="detail_input" id="campaign-title" name="campaign-title" value=""></td>
                </tr>
				<tr>
					<th>기간</th>
					<td>
						<input type='text' name='start-date' id='start-date' class='datetime' autocomplete="off" value='' />
						<span>~</span>
						<input type='text' name='end-date' id='end-date' class='datetime endtime' autocomplete="off" value='' />
					</td>
				</tr>
				<tr>
					<th>최대 신청자 수</th>
					<td><input type="text" class="detail_input number" id="max-applicant" name="max-applicant" maxlength="5" value=""></td>
				</tr>
                <tr>
                    <th>이미지 등록(PC)</th>
                    <td>
						<div class="write-content-td">
							<img id="pc-uploaded-img" name="pc-uploaded-img" src="" alt="">
							<br/>
							<input type="file" class="pc-upload_file" name="pc-upload_file" >
						</div>
                    </td>
                </tr>
				<tr>
					<th>이미지 등록(MO)</th>
					<td>
						<div class="write-content-td">
							<img id="uploaded-img" name="uploaded-img" src="" alt="">
							<br/>
							<input type="file" class="mo-upload_file" name="mo-upload_file" >
						</div>
					</td>
				</tr>
				<tr>
					<th>당첨 형태 지정</th>
					<td>
						<input type="text" class="detail_input" id="lottery-word" name="lottery-word" placeholder="1등, 2등, 3등 ... 형태로 입력해주세요." value="">
						<br/>
						<div class="write-content-td notice-text">
							<span class="">*당첨 형태 구분은 ',' 표로 가능하며, 캠페인 생성 후에 수정은 불가능합니다.</span>
						</div>
					</td>
				</tr>
                </tbody>
            </form>
        </table>
        <button type="submit" class="savebtn">생성 완료</button>
    </div>
</section>
</body>
<!--네이버 스마트 에디터-->
<script src="<?= ADMIN_JS ?>/menu.js"></script>
<script src="<?= ADMIN_JS ?>/jquery-ui.min.js"></script>
<script src="<?= ADMIN_JS ?>/jquery-ui-timepicker-addon.js"></script>
<script>
    $(function () {
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
            var url = "/admin/campaign/postcampaign";
            var aForm = $('#portfolio-form');
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