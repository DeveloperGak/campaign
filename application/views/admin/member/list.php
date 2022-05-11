<?php
$keywordText = isset($_GET['keyword'])?$_GET['keyword']:"";
?>
<style>
	#delete-admin:hover {
		background: #7b0505;
	}
	.table-top-box{
		float: right;
	}
	.table-top-box img{
		margin-top: 10px;
	}
	.table-top-box .search-button{
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
	.table-top-box .search-button:hover{
		background:#555;
		color:#fff;
	}
	.table-top-box .search-button a{
		padding: 20px;
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

	#lp_admin_join .lp_admin {
		margin-left: -194px;
		height: 407px;
	}
	#lp_admin_join .form_wrap {
		height: 258px;
	}
	#lp_admin_join .form-group input[name=level] {
		display: block;
		width: 15px;
		height: 40px;
		padding: 10px;
		font-size: 1.3rem;
		line-height: 1.5;
		color: #333;
		background-color: #fff;
		border: 1px solid #ededed;
		border-radius: 3px;
		margin-top: 1px;
	}
	#lp_admin_join .form-group .level-label{
		width: 100px;
		font-size: 15px;
		font-weight: 100;
		margin-left: 10px;
	}
	#lp_admin_modify .lp_admin {
		margin-top: -212px;
		height: 459px;
	}
	#lp_admin_modify .form_wrap {
		height: 308px;
	}
	#lp_admin_modify .modifybtn {
		float: unset;
		margin-right: 150px;
	}
	#lp_admin_modify .form-group label {
		font-size: 14px;
	}
	#lp_admin_modify .form-group input.disabled{
		border: unset;
	}
</style>
<section id="useradmin" class="main_content">
		<h1>관리자 관리</h1>
		<div class="table_wrap">
			<div class="table-top-box">
				<img src="<?=ADMIN_IMG?>/search.png" width="20px">
				<input type="text" name="keyword" id="keyword" placeholder="닉네임 입력" value="<?=$keywordText?>">
				<button type="button" class="search-button">검색</button>
				<button type="button" class="newadmin">신규 관리자 등록</button>
			</div>
			<table class="tablelist">
				<colgroup>
					<col style="width:20%;">
					<col style="width:20%;">
					<col style="width:20%;">
					<col style="width:20%;">
					<col style="width:20%;">
				</colgroup>
				<thead>
					<tr>
						<th>번호</th>
						<th>닉네임 / ID</th>
						<th>관리자 레벨</th>
						<th>계정 생성일</th>
						<th>비고</th>
					</tr>
				</thead>
				<tbody>
                <?php
                $list = isset($list)?$list:null;
				$i= $total;
                $paging = isset($paging)?$paging:null;
                
                if($list){
                    foreach ($list as $adminInfo){
                        $dtRegDate = substr($adminInfo['dtRegDate'],0,10);
	                    $adminLevelText = "캠페인 담당자";
                        if($adminInfo['nLevel'] == "1"){
	                        $adminLevelText = "전체 관리자";
						}
                        echo ("
                            <tr>
                                <td>{$i}</td>
                                <td>{$adminInfo['vNickName']} / {$adminInfo['vUid']}</td>
                                <td>{$adminLevelText}</td>
                                <td>{$dtRegDate}</td>
                                <td>
									<button type='button' data-no='{$adminInfo['nSeqNo']}' class='modifyadmin detail-admin'>상세</button>
									<button type='button' data-no='{$adminInfo['nSeqNo']}' class='modifyadmin delete-admin'>삭제</button>
                                </td>
                            </tr>
                        ");
						$i--;
                    }
                }else{
                	echo ("
                		<tr>
                		<td colspan='5'>관리자가 존재하지 않습니다.</td>
                		</tr>
                	");
				}
                ?>
				</tbody>
			</table>
		</div>
		<!--페이징-->
        <?=$paging?>
	</section>	
	<!--신규관리자등록-->
	<section id="lp_admin_join">
		<div class="lp_admin">
			<div class="lp_admin_form">
				<div class="lp_header">
					<h1>관리자 생성</h1>
					<a class="lpclose">
						<span></span>
						<span></span>
					</a>
				</div>
				<article class="form_wrap">
					<div class="form-group">
						<label for="userid">관리자 ID</label>
						<input type="text" class="inputbox" id="userid" name="userid">
					</div>
					<div class="form-group">
						<label for="userid">관리자 닉네임</label>
						<input type="text" class="inputbox" id="nickname" name="nickname">
					</div>
					<div class="form-group">
						<label for="userid">전화번호</label>
						<input type="text" class="inputbox number" id="call" name="call">
					</div>
					<div class="form-group">
						<label>관리자 레벨</label>
						<input type="radio" class="inputbox" id="super" name="level">
						<label for="super" class="level-label">전체 관리자</label>
						<input type="radio" class="inputbox" id="manager" name="level">
						<label for="manager" class="level-label">캠페인 담당자</label>
					</div>
					<div class="form-group">
						<label for="password">비밀번호</label>
						<input id="passwd" type="password" class="inputbox" name="passwd">
					</div>
				</article>
				<p class="lp_btn_alert"><span class="registerbtn">생성 완료</span></p>
			</div>
		</div>
	</section>
	<!--관리자 수정-->
	<section id="lp_admin_modify">
		<div class="lp_admin">
			<div class="lp_admin_form">
				<div class="lp_header">
					<h1>관리자 수정</h1>
					<a class="lpclose_modify">
						<span></span>
						<span></span>
					</a>
				</div>
				<article class="form_wrap">
					<div class="form-group">
						<label for="modi-userid">관리자 ID</label>
						<input type="text" class="inputbox disabled" id="modi-userid" name="modi-userid" disabled>
					</div>
					<div class="form-group">
						<label for="modi-level">관리자 레벨</label>
						<input type="text" class="inputbox disabled" id="modi-level" name="modi-level" disabled>
					</div>
					<div class="form-group">
						<label for="modi-call">관리자 전화번호</label>
						<input type="text" class="inputbox disabled" id="modi-call" name="modi-call" disabled>
					</div>
					<div class="form-group">
						<label for="modi-nickname">관리자 닉네임</label>
						<input type="text" class="inputbox" id="modi-nickname" name="modi-nickname">
					</div>
					<div class="form-group">
						<label for="modi-passwd">변경 비밀번호</label>
						<input  type="password" class="inputbox" id="modi-passwd" name="modi-passwd">
					</div>
					<div class="form-group">
						<label for="modi-repasswd">변경 비밀번호 확인</label>
						<input type="password" class="inputbox" id="modi-repasswd" name="modi-repasswd">
					</div>
				</article>
				<input type="hidden" name="modi-no" id="modi-no">
			</div>
			<p class="lp_btn_alert"><span class="modifybtn">수정완료</span></p>
		</div>
	</section>
	<!--관리자 삭제-->
	<section id="lp_admin_delete">
		<div class="lp_admin">
			<p>관리자를 삭제하시겠습니까?</p>
			<p class="lp_btn_alert"><span class="deletebtn_finish">확인</span><span class="deletebtn_cancel">취소</span></p>
		</div>
	</section>
</body>
<script src="<?=ADMIN_JS?>/list.js"></script>
<script src="<?=ADMIN_JS?>/menu.js"></script>
<script>
	$(function(){
		$('.search-button').on("click", function(){
			search();
		});
	});
	function search(){
		var keyword = $('#keyword').val();
		var queryString = "";
		if(keyword){
			queryString += "&keyword="+keyword;
		}
		window.location.href="member?1=1"+queryString;
	}
</script>
</html>