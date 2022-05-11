<?php
	if($list){
		echo ("
			<div class='ministat-content'>
				<h2 style='margin-bottom: 2px'>당첨자 mini 통계</h2>
				<table class='tablelist'>
					<thead>
					<tr>
						<th>당첨 형태</th>
						<th>당첨자수</th>
					</tr>
					</thead>
					");
			foreach ($list as $rank => $count){
				echo ("<tr>
						   <td>{$rank}</td>
						   <td>{$count}</td>
					   </tr>
					");
			}
		echo ("
				</table>
			</div>
		");
	}
?>
