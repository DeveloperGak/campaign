<?php
$startdateText = isset($_GET['startdate'])?$_GET['startdate']:date("Y-m-d");
$enddateText = isset($_GET['enddate'])?$_GET['enddate']:date("Y-m-d", strtotime("+30 days"));

?>
<link rel="stylesheet" type="text/css" href="<?= ADMIN_CSS ?>/jquery-ui-timepicker-addon.css">
<link rel="stylesheet" type="text/css" href="<?= ADMIN_CSS ?>/jquery-ui.css">
<style>
    .table-top-box{
        float: right;
    }
    .table-top-box img{
        margin-top: 10px;
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
<section id="useradmin" class="main_content">
		<h1>통계</h1>
		<div class="table_wrap">
			<div class="table-top-box">
				<img src="<?=ADMIN_IMG?>/calender.png" width="20px">
				<input type="text" name="startdate" class="datetime search-box-date" id="startdate"value="<?=$startdateText?>">
				<img src="<?=ADMIN_IMG?>/oneside.png" width="20px">
				<img src="<?=ADMIN_IMG?>/calender.png" width="20px">
				<input type="text" name="enddate" class="datetime search-box-date" id="enddate" value="<?=$enddateText?>">
				<button type="button" class="search-button">검색</button>
			</div>
			<table class="tablelist">
				<colgroup>
					<col style="width:33%;">
					<col style="width:33%;">
					<col style="width:33%;">
				</colgroup>
				<thead>
					<tr>
						<th>캠페인명</th>
						<th>담당자 닉네임 / ID</th>
						<th>응모자수</th>
					</tr>
				</thead>
				<tbody>
                <?php
                $list = isset($list)?$list:null;
                if($list){
                    foreach ($list as $row){
                        echo ("
                            <tr>
                                <td>{$row['vSubject']}</td>
                                <td>{$row['vNickName']} / {$row['vUid']}</td>
                                <td>{$row['nApplicantCount']}</td>
                            </tr>
                        ");
                    }
                }else{
                	echo ("
                		<tr>
                		<td colspan='3'>해당 기간내에 진행하는 캠페인이 존재하지 않습니다.</td>
                		</tr>
                	");
				}
                ?>
				</tbody>
			</table>
		</div>
		<!--페이징-->
	</section>
</body>
<script src="<?= ADMIN_JS ?>/jquery-ui.min.js"></script>
<script src="<?= ADMIN_JS ?>/jquery-ui-timepicker-addon.js"></script>
<script>
	$(function(){
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

		$('.search-button').on("click", function(){
			search();
		});
	});

	function search(){
		var startdate = $('#startdate').val();
		var enddate = $('#enddate').val();
		var queryString = "";
		if(startdate){
			queryString += "&startdate="+startdate;
		}
		if(enddate){
			queryString += "&enddate="+enddate;
		}
		window.location.href="statistics?1=1"+queryString;
	}
</script>
</html>