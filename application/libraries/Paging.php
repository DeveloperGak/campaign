<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Paging {
	public function pagination($param) {
		$limit = $param['limit'];
		$total = $param['total'];
		$page = $param['page'];

		$keyword = isset($_GET['keyword'])?"&keyword=".$_GET['keyword']:"";
		$startdate = isset($_GET['startdate'])?"&startdate=".$_GET['startdate']:"";
		$enddate = isset($_GET['enddate'])?"&enddate=".$_GET['enddate']:"";

		$addQueryString = $keyword.$startdate.$enddate;

		$page_num = 10;
		$total_page = ceil($total / $limit);


		$page_block = ceil($total_page / $page_num);
		$block = ceil($page / $page_num);
		$first = ($block - 1) * $page_num;
		$last = $block * $page_num;
		$pageStr = "";
		if($page_block){
			$pageStr .= '<div id="paging_wrap">';
			$pageStr .= '<div class="pagebtn start"><a href="?page=1" class="first_page pbtn">처음으로</a>';
		}

		if ($block >= $page_block) {
			$last = $total_page;
		}

		if ($page > 1) {
			$go_page = $page - 1;
			$pageStr .= '<a href="?page='.$go_page.$addQueryString.'" class="prev_page pbtn">이전</a>';
		}
		if($page_block) {
			$pageStr .= '</div>';
			$pageStr .= '<ul class="pagenum">';
		}

		for ($page_link = $first + 1; $page_link <= $last; $page_link++) {
			if ($page_link == $page) {
				$pageStr .= '<li class="on"><a>' . $page_link . '</a></li>';
			} else {
				$pageStr .= '<li><a href="?page='.$page_link.$addQueryString.'">' . $page_link . '</a></li>';
			}
		}
		if($page_block) {
			$pageStr .= '</ul>';
			$pageStr .= '<div class="pagebtn end">';
		}

		if ($total_page > $page) {
			$go_page = $page + 1;
			$pageStr .= '<a href="?page='.$go_page.$addQueryString.'" class="next_page pbtn">다음</a>';
		}
		if($page_block) {
			$pageStr .= '<a href="?page=' . $total_page.$addQueryString . '" class="end_page pbtn">마지막으로</a></div>';
			$pageStr .= '</div>';
		}

		return $pageStr;
	}


}
