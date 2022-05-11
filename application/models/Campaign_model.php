<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Campaign_model extends CI_Model {
	const CAMPAIGN  = 'campaign';
	const APPLICANT  = 'applicant';
	const ADMIN = 'admin';

	function __construct(){
		parent::__construct();
		$this->load->database();
	}

	public function getCampaignList($param){
		$addWhereQuery = "";
		$addLimitQuery = "";
		if(!empty($this->session->userdata['draw_nLevel']) && $this->session->userdata['draw_nLevel'] == "2")
			$addWhereQuery.= " AND a.nSeqNo = '{$this->session->userdata['draw_nSeqNo']}' ";
		if(!empty($param['startdate']) && !empty($param['enddate']))
			$addWhereQuery.= " AND c.dtStartDate >= '{$param['startdate']}' AND c.dtEndDate <= '{$param['enddate']}' ";
		if(!empty($param['beginStartdate']) && !empty($param['beginEnddate']))
			$addWhereQuery.= " AND c.dtStartDate BETWEEN '{$param['beginStartdate']}' AND '{$param['beginEnddate']}' ";
		if(!empty($param['keyword'])){
			$addWhereQuery .= " AND (a.vNickName LIKE '%{$param['keyword']}%' ) ";
		}
		if(!empty($param['limit']))
			$addLimitQuery.= " LIMIT {$param['start']}, {$param['limit']} ";
		$aRtn = $this->db->query("
								  SELECT (SELECT COUNT(nCampSeqNo) FROM ".self::APPLICANT." WHERE nCampSeqNo = c.nSeqno) AS nApplicantCount
										 ,(SELECT COUNT(nSeqno) FROM ".self::CAMPAIGN." WHERE emDelFlag = 'N') AS nTotalCount
									     ,(SELECT SUM(CASE WHEN vWinningWord IS NOT NULL THEN 1 ELSE 0 END) FROM ".self::APPLICANT." WHERE nCampSeqNo = c.nSeqno) AS nWinningCount 
									     , c.*
									     , a.vNickName, a.vUid
									     ,(CASE WHEN c.emOpenFlag = 'N' THEN 'end'
									            WHEN c.nMaxApplicant <= (SELECT COUNT(nCampSeqNo) FROM ".self::APPLICANT." WHERE nCampSeqNo = c.nSeqno) THEN 'end'
												WHEN NOW() < c.dtStartDate  THEN 'ready'
												WHEN NOW() BETWEEN c.dtStartDate AND c.dtEndDate THEN 'open'
												WHEN NOW() > c.dtEndDate  THEN 'end'
										  END) AS isOpenText
								    FROM ".self::CAMPAIGN." AS c LEFT OUTER JOIN ".self::ADMIN." AS a
								      ON c.nAuthorNo = a.nSeqNo
								   WHERE c.emDelFlag = 'N' 
								   {$addWhereQuery}
								ORDER BY {$param['order']} {$param['sort']}
								   {$addLimitQuery}
							")->result_array();
		return $aRtn;
	}

	public function getApplicantList($param){
		$addWhereQuery = "";
		$addSubWhereQuery = "";
		$addLimitQuery = "";
		if(!empty($param['no']))
			$addWhereQuery.= " AND c.nSeqNo = '{$param['no']}' ";
		if(!empty($param['limit']))
			$addLimitQuery.= " LIMIT {$param['start']}, {$param['limit']} ";
		if(!empty($param['keyword'])){
			$addSubWhereQuery .= " AND (vName LIKE '%{$param['keyword']}%' OR vPhone LIKE '%{$param['keyword']}%' ) ";
			$addWhereQuery .= " AND (a.vName LIKE '%{$param['keyword']}%' OR a.vPhone LIKE '%{$param['keyword']}%' ) ";
		}
		$aRtn = $this->db->query("
								  SELECT (SELECT COUNT(1) FROM ".self::APPLICANT." WHERE nCampSeqNo = a.nCampSeqNo  {$addSubWhereQuery}) AS nTotalCount 
									     , a.*
									     , c.vLotteryWords, c.nMaxApplicant
								    FROM ".self::CAMPAIGN." AS c , ".self::APPLICANT." AS a
								   WHERE c.emDelFlag = 'N' 
								     AND c.nSeqNo = a.nCampSeqNo
								         {$addWhereQuery}
								ORDER BY {$param['order']} {$param['sort']}
								         {$addLimitQuery}
							")->result_array();
		return $aRtn;
	}
	public function getApplicantName($param){
		$aRtn = $this->db
			->select('vName')
			->where('nCampSeqNo', $param['no'])
			->where('vPhone', $param['phone'])
			->where('emDelFlag', 'N')
			->from(self::APPLICANT)->get()->row_array();
		return $aRtn;
	}

	public function getApplicantMiniStatList($nSeqNo, $param){
		$addSelectQuery = "";
		$addWhereQuery = "";
		if($nSeqNo)
			$addWhereQuery.= " AND nCampSeqNo = '{$nSeqNo}' ";
		if(!empty($param) && count($param)){
			foreach ($param as $row){
				$row = trim($row);
				$addSelectQuery.= " SUM(CASE WHEN vWinningWord = '{$row}' THEN 1 ELSE 0 END) AS '{$row}', ";
			}
			$addSelectQuery = substr($addSelectQuery, 0, -2);
		}

		$aRtn = $this->db->query("
							SELECT {$addSelectQuery} 
  							  FROM ".self::APPLICANT."
							 WHERE emDelFlag = 'N' 
							 	  {$addWhereQuery}
						")->row_array();
		return $aRtn;

	}

	public function postApplicant($param){
		$isFinish = $this->getCampaignInfo($param['nCampSeqNo']);
		if($isFinish['isOpenText'] == "end"){
			return "finish";
		}
		else{
			$result = $this->db->insert(self::APPLICANT, $param);
			if ($result) {
				return "success";
			} else {
				return "error";
			}
		}
	}
	public function putApplicant($param){
		$isAlreadyWinnig = $this->isNotApplicantWinning($param);
		if(!$isAlreadyWinnig){
			foreach ($param as $row){
				$result = $this->db
					->where('nCampSeqNo', $row['no'])
					->where('vPhone', $row['phone'])
					->update(self::APPLICANT, array("vWinningWord" => $row['winning']));
				if(!$result) return "error|당첨 처리에 실패하였습니다.";
			}
			return "success";
		}
		else{
			return "error|이미 당첨된 신청자가 선택되었습니다.";
		}
	}

	public function isNotApplicantWinning($param){
		$isWinning = false;
		foreach ($param as $row){
			$isWinning = $this->db
				->where('nCampSeqNo', $row['no'])
				->where('vPhone', $row['phone'])
				->where('vWinningWord IS NOT NULL', null, false)
				->from(self::APPLICANT)
				->get()->num_rows();
			if($isWinning) return true;
		}
		return false;
	}

	public function putCampaign($nSeqNo, $param){
		$result = $this->db
			->where('nSeqNo', $nSeqNo)
			->update(self::CAMPAIGN, $param);
		if($result){
			return "success";
		}
		else{
			return "error";
		}
	}

	public function postCampaign($param){
		$result = $this->db->insert(self::CAMPAIGN, $param);
		if($result){
			return "success";
		}
		else{
			return "error";
		}
	}

	public function getCampaignInfo($nSeqNo){
		$aRtn = $this->db->query("
								  SELECT c.*
									     ,(CASE WHEN c.emOpenFlag = 'N' then 'end'
									         	WHEN c.nMaxApplicant <= (SELECT COUNT(nCampSeqNo) FROM ".self::APPLICANT." WHERE nCampSeqNo = c.nSeqno) THEN 'end'
												WHEN NOW() < c.dtStartDate  THEN 'ready'
												WHEN NOW() BETWEEN c.dtStartDate AND c.dtEndDate THEN 'open'
												WHEN NOW() > c.dtEndDate  THEN 'end'
										  END) AS isOpenText
								    FROM ".self::CAMPAIGN." AS c 
								   WHERE c.emDelFlag = 'N' 
								     AND c.nSeqNo = '{$nSeqNo}' 
							")->row_array();
		return $aRtn;
	}

	public function IsExistApplicant($param){
		$this->db->from(self::APPLICANT);
		$this->db->where('nCampSeqNo', $param['nCampSeqNo']);
		$this->db->where('vPhone', $param['vPhone']);
		$this->db->where('emDelFlag', 'N');
		$reuslt =  $this->db->get()->num_rows();
		return $reuslt;
	}

	public function rmCampaign($nSeqNo, $param){
		$result = $this->db->where('nSeqNo', $nSeqNo)
			->update(self::CAMPAIGN, $param);
		if($result){
			return "success";
		}
		else{
			return "error";
		}
	}
}