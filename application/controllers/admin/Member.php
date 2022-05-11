<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Member extends CI_Controller {
	public function __construct() {
		parent::__construct();
        $this->load->model('Admin_model');
	}

	// 메인페이지
	public function index(){
        if($this->session->userdata('nLevel') === "2"){
            redirect('/admin/campaign');
        }
        else if($this->session->userdata('nLevel') === "1"){
            $this->getAdminList();
        }
        else{
            redirect('/admin/login');
        }
	}

	public function getAdminList(){
        $limit = 10;
        $page = ($this->input->get("page")) ? $this->input->get("page") : 1;
        $keyword = ($this->input->get("keyword")) ? $this->input->get("keyword") : "";
        $start = ($page - 1) * $limit;

        $param = array(
            "limit"   => $limit
            , "page"  => $page
            , "start" => $start
            , "order" => "dtRegDate"
            , "sort"  => "desc"
        );

		if ($keyword) $param['keyword'] = $keyword;

        $data['total'] = $this->Admin_model->getAdminCount($param);
        $data['page'] = $page;
        $param['total'] = $data['total'];
        $data['list'] = $this->Admin_model->getAdminList($param);
        $data['paging'] = $this->paging->pagination($param);

        $this->response->viewAdmin('member/list', $data);
	}

    public function getAdminInfo(){
        $nSeqNo = $this->input->post("no") ?  $this->input->post("no") : null;
        $jData = $this->Admin_model->getAdminInfo($nSeqNo);
        header('Content-Type: application/json;charset=utf-8');
        print json_encode($jData, JSON_UNESCAPED_SLASHES|JSON_UNESCAPED_UNICODE);
    }


	 public function postAdmin(){
         $vUid = $this->input->post("userid") ?  $this->input->post("userid") : null;
         $vNickName = $this->input->post("nickname") ?  $this->input->post("nickname") : null;
         $vCall = $this->input->post("call") ?  $this->input->post("call") : null;
         $vPwd = $this->input->post("passwd") ?  $this->input->post("passwd") : null;
         $nLevel = $this->input->post("level") ?  $this->input->post("level") : 2;
         if($nLevel == "super") $nLevel = 1;
         $param = array (
             "vUid" => $vUid,
             "vNickName" => $vNickName,
             "vCall" => $vCall,
             "vPwd" => $vPwd,
             "nLevel" => $nLevel
         );
	 	$result = $this->Admin_model->postAdmin($param);
	 	echo $result;
	 }

    public function putAdmin(){
        $nSeqNo = $this->input->post("modiNo") ?  $this->input->post("modiNo") : null;
        $vNicName = $this->input->post("modiNickName") ?  $this->input->post("modiNickName") : null;
        $vPwd = $this->input->post("modiRePassword") ?  $this->input->post("modiRePassword") : null;

		if($vNicName && $vPwd){
			$param = array (
				"vNickName"  => $vNicName
				, "vPwd"  => $this->secret->aes_encrypt($vPwd)
			);
		}
		$result = $this->Admin_model->putAdmin($nSeqNo, $param);
        echo $result;
    }

    public function rmAdmin(){
	    $nSeqNo = $this->input->post("no") ?  $this->input->post("no") : null;
	    $param = array (
		    "emDelFlag" => 'Y'
	    );
	    $result = $this->Admin_model->putAdmin($nSeqNo, $param);
	    echo $result;
    }
}
