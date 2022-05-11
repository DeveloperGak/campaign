<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Campaign extends CI_Controller {
	public function __construct() {
		parent::__construct();
		$this->load->library('session');
		$this->load->library('Secret');
		$this->load->model('Campaign_model');
	}

	public function index() {
		$this->getCampaignList();
	}

	public function getCampaignList(){
		$limit = 10;
		$page = ($this->input->get("page")) ? $this->input->get("page") : 1;
		$start = ($page - 1) * $limit;
		$keyword = ($this->input->get("keyword")) ? $this->input->get("keyword") : "";
		$startdate = ($this->input->get("startdate")) ? $this->input->get("startdate") : "";
		$enddate = ($this->input->get("enddate")) ? $this->input->get("enddate") : "";

		$param = array(
			"limit" => $limit
			, "page" => $page
			, "start" => $start
			, "order" => "dtRegDate"
			, "sort" => "desc"
			, "total" => 0
		);
		if ($keyword) $param['keyword'] = $keyword;
		if ($startdate) $param['beginStartdate'] = $startdate;
		if ($enddate) $param['beginEnddate'] = $enddate;

		$data['page'] = $page;
		$data['list'] = $this->Campaign_model->getCampaignList($param);
		$data['total'] = !empty($data['list'][0]['nTotalCount'])?$data['list'][0]['nTotalCount']:0;
		if($data['total']) $param['total'] = $data['total'];
		$data['paging'] = $this->paging->pagination($param);
		$this->response->viewAdmin('campaign/list', $data);
	}

	public function detail(){
		$limit = 10;
		$page = ($this->input->get("page")) ? $this->input->get("page") : 1;
		$start = ($page - 1) * $limit;
		$keyword = ($this->input->get("keyword")) ? $this->input->get("keyword") : "";
		$nSeqNo = $this->input->post("no") ?  $this->input->post("no") : null;

		$param = array(
			"limit" => $limit
		, "page" => $page
		, "start" => $start
		, "order" => "a.dtRegDate"
		, "sort" => "desc"
		, "total" => 0
		);
		if ($keyword) $param['keyword'] = $keyword;
		if ($nSeqNo) $param['no'] = $nSeqNo;

		$data['page'] = $page;
		$data['no'] = $nSeqNo;
		$data['list'] = $this->Campaign_model->getApplicantList($param);
		$data['total'] = !empty($data['list'][0]['nTotalCount'])?$data['list'][0]['nTotalCount']:0;
		if($data['total']) $param['total'] = $data['total'];
		$data['paging'] = $this->ajaxpaging->pagination($param);
		$this->load->view('admin/campaign/detail', $data);
	}

	public function ministat(){
		$nSeqNo = $this->input->post("no") ?  $this->input->post("no") : null;
		$param = array(
			"no" => $nSeqNo
			, "order" => "a.dtRegDate"
			, "sort" => "desc"
			, "start" => 0
			,"limit"=>1
		);

		$aRtn = $this->Campaign_model->getApplicantList($param);
		$vLotteryWords = $aRtn?$aRtn[0]['vLotteryWords']:"";
		if($vLotteryWords){
			$aLotteryWords =explode(",",$vLotteryWords);
			$data['list'] = $this->Campaign_model->getApplicantMiniStatList($nSeqNo, $aLotteryWords);
			$this->load->view('admin/campaign/ministat', $data);
		}
	}

	public function postCampaign(){
		$nAuthorNo = !empty($this->session->userdata('nSeqNo')) ?  $this->session->userdata('nSeqNo') : null;
		$vSubject = $this->input->post("campaign-title") ?  $this->input->post("campaign-title") : null;
		$nMaxApplicant = $this->input->post("max-applicant") ?  $this->input->post("max-applicant") : null;
		$vLotteryWords = $this->input->post("lottery-word") ?  $this->input->post("lottery-word") : null;
		$dtStartDate = $this->input->post("start-date") ?  $this->input->post("start-date") : null;
		$dtEndDate = $this->input->post("end-date") ?  $this->input->post("end-date") : null;

		$moFileName = isset($_FILES['mo-upload_file']['name'])?$_FILES['mo-upload_file']['name']:null;
		$moFileSize = isset($_FILES['mo-upload_file']['size'])?$_FILES['mo-upload_file']['size']:null;
		$moFileTmp = $_FILES['mo-upload_file']['tmp_name'];

		$pcFileName = isset($_FILES['pc-upload_file']['name'])?$_FILES['pc-upload_file']['name']:null;
		$pcFileSize = isset($_FILES['pc-upload_file']['size'])?$_FILES['pc-upload_file']['size']:null;
		$pcFileTmp = $_FILES['pc-upload_file']['tmp_name'];

		if ($moFileSize > 5242880 || $pcFileSize > 5242880) {
			echo "error|파일 용량은 5MB를 초과할 수 없습니다.";
			exit;
		}

		$savedMoFileName = "";
		$savedPcFileName = "";
		if($moFileName)  $savedMoFileName = $this->fileSave($moFileName, $moFileTmp,MOIMG_PATH);
		if($pcFileName)  $savedPcFileName = $this->fileSave($pcFileName, $pcFileTmp,PCIMG_PATH);

		if($nAuthorNo){
			$param = array (
				"nAuthorNo" => $nAuthorNo,
				"vSubject" => $vSubject,
				"nMaxApplicant" => $nMaxApplicant,
				"vLotteryWords" => $vLotteryWords,
				"dtStartDate" => $dtStartDate,
				"dtEndDate" => $dtEndDate,
				"vMoFileName" => $moFileName,
				"vPcFileName" => $pcFileName,
				"vMoRealFileName" => $savedMoFileName,
				"vPcRealFileName" => $savedPcFileName,
				"vIp"=> $_SERVER['REMOTE_ADDR']
			);
			$result = $this->Campaign_model->postCampaign($param);
			echo $result;
		}
	}

	public function putCampaign(){
		$nSeqNo = $this->input->post("no") ?  $this->input->post("no") : null;
		$vSubject = $this->input->post("campaign-title") ?  $this->input->post("campaign-title") : null;
		$dtStartDate = $this->input->post("start-date") ?  $this->input->post("start-date") : null;
		$dtEndDate = $this->input->post("end-date") ?  $this->input->post("end-date") : null;
		$emOpenFlag = $this->input->post("is-open") ?  $this->input->post("is-open") : null;

		$moFileName = isset($_FILES['mo-upload_file']['name'])?$_FILES['mo-upload_file']['name']:null;
		$moFileSize = isset($_FILES['mo-upload_file']['size'])?$_FILES['mo-upload_file']['size']:null;
		$moFileTmp = $_FILES['mo-upload_file']['tmp_name'];

		$pcFileName = isset($_FILES['pc-upload_file']['name'])?$_FILES['pc-upload_file']['name']:null;
		$pcFileSize = isset($_FILES['pc-upload_file']['size'])?$_FILES['pc-upload_file']['size']:null;
		$pcFileTmp = $_FILES['pc-upload_file']['tmp_name'];

		if ($moFileSize > 5242880 || $pcFileSize > 5242880) {
			echo "error|파일 용량은 5MB를 초과할 수 없습니다.";
			exit;
		}

		$savedMoFileName = "";
		$savedPcFileName = "";
		if($moFileName)  $savedMoFileName = $this->fileSave($moFileName, $moFileTmp,MOIMG_PATH);
		if($pcFileName)  $savedPcFileName = $this->fileSave($pcFileName, $pcFileTmp,PCIMG_PATH);

		if($nSeqNo){
			$param = array (
				"vSubject" => $vSubject,
				"dtStartDate" => $dtStartDate,
				"dtEndDate" => $dtEndDate,
				"emOpenFlag" => $emOpenFlag,
			);
			if($moFileName) $param['vMoFileName'] = $moFileName;
			if($pcFileName) $param['vPcFileName'] = $pcFileName;
			if($savedMoFileName) $param['vMoRealFileName'] = $savedMoFileName;
			if($savedPcFileName) $param['vPcRealFileName'] = $savedPcFileName;
			$result = $this->Campaign_model->putCampaign($nSeqNo, $param);
			echo $result;
		}
	}

    public function putApplicant(){
        $JSONdataSet = $this->input->post("dataset") ?  $this->input->post("dataset") : null;
        $aDataSet = json_decode($JSONdataSet,TRUE);
        if($aDataSet){
            $result = $this->Campaign_model->putApplicant($aDataSet);
            echo $result;
            exit;
        }
        else{
            echo "error|당첨형태 텍스트가 올바르지 않습니다.";
            exit;
        }
    }

	public function fileSave($baseFileName, $baseFileTmp, $path){
			$fileNameArr = explode(".", $baseFileName);
			$fileName = date("Ymd") . "_" . $this->util->generateRandomString("all", 6) . "." . $fileNameArr[count($fileNameArr) - 1];
			$aFiles['vFileName'] = $fileName;
			if (!move_uploaded_file($baseFileTmp, $path . $fileName)) {
				echo "error|{$baseFileName} 파일 업로드에 실패하였습니다.";
				exit;
			}
			else{
				@unlink($baseFileTmp);
				return $fileName;
			}
	}

	public function rmCampaign(){
		$nSeqNo = $this->input->post("no") ?  $this->input->post("no") : null;
		$param = array (
			"emDelFlag" => 'Y'
		);
		$result = $this->Campaign_model->rmCampaign($nSeqNo, $param);
		echo $result;

	}

	public function write(){
		$data['list'] = null;
		$this->response->viewAdmin('campaign/write', $data);
	}

	public function modify(){
		$nSeqNo = ($this->input->post("no")) ? $this->input->post("no") : null;
		if ($nSeqNo) {
			$param = array(
				"order" => "a.dtRegDate"
				, "sort" => "desc"
				, "no" => $nSeqNo
			);
			$data['list'] = $this->Campaign_model->getCampaignInfo($nSeqNo);
			$data['applicant'] = $this->Campaign_model->getApplicantList($param);
			$this->response->viewAdmin('campaign/modify', $data);
		}
		else{
			header("Location:/admin/campaign");
		}
	}
}
