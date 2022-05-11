<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Main extends CI_Controller{
	public function __construct(){
		parent::__construct();
		$this->load->library('session');
		$this->load->model('Campaign_model');
		$this->load->model('Admin_model');
	}

	public function index(){
		$data = null;
		if(!empty($_GET['campaign_no'])){
			$data['campaign'] = $this->getCampaign($_GET['campaign_no']);
		}
		if ($this->mobileCheck()) {
			$data['device'] = "mo";
		}
		else{
			$data['device'] = "pc";
		}
		$this->response->View("campaign", $data);
	}

	public function getCampaign($nSeqNo){
		$aRtn = $this->Campaign_model->getCampaignInfo($nSeqNo);
		return $aRtn;
	}

	public function mobileCheck(){
		$aAgent = array("iPhone", "iPod", "Android", "Blackberry", "Opera Mini", "Windows ce", "Nokia", "sony");
		$chkMobile = false;
		foreach ($aAgent as $device){
			if (stripos($_SERVER['HTTP_USER_AGENT'], $device) != false) {
				$chkMobile = true;
				break;
			}
		}
		return $chkMobile;
	}

	public function setApplicant(){
		$nCampSeqNo = ($this->input->post("no")) ? $this->input->post("no") : "";
		$vPhone = ($this->input->post("phone")) ? $this->input->post("phone") : "";
		$vName = ($this->input->post("username")) ? $this->input->post("username") : "";
		if($vName){
			$param = array(
				"nCampSeqNo"=>$nCampSeqNo
				,"vPhone"=>$vPhone
				,"vName"=>$vName
				,"vIp"=>$_SERVER["REMOTE_ADDR"]
			);
			$result = $this->Campaign_model->postApplicant($param);
			$capaignInfo = $this->Campaign_model->getCampaignInfo($nCampSeqNo);
			$nAuthorNo = $capaignInfo['nAuthorNo'];
			$adminInfo = $this->Admin_model->getAdminInfo($nAuthorNo);
			echo $result;
			exit;
		}
	}
}