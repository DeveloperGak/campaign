<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Admin_model extends CI_Model {
	const ADMIN  = 'admin';

	function __construct(){
		parent::__construct();
		$this->load->database();
	}

	public function getLoginCheck(){
		$aRtn = array(
			"status" => "FAIL"
			, "msg" => ""
		);
		$vUid = ($this->input->post("user_id")) ? $this->input->post("user_id") : null;
		$vPwd = ($this->input->post("user_pw")) ? $this->input->post("user_pw") : null;
		if($vUid == null || $vPwd == null){
			$aRtn['msg'] = "아이디 또는 비밀번호가 누락 됐습니다.";
			return $aRtn;
			exit;
		}
		$data = $this->db->from(self::ADMIN)
			->where('vUid', $vUid)
			->where('vPwd', $vPwd)
			->get()->row_array();


		if($data){
			$aRtn['status'] = "SUCCESS";
			$aRtn['data'] = $data;
		}
		else{
			$aRtn['status'] = "FAIL";
			$aRtn['msg'] = "아이디 또는 비밀번호를 확인 해주세요.";
		}

		return $aRtn;
	}

    public function getAdminList($param){
        $this->db->from(self::ADMIN);
        $this->db->where('emDelFlag !=','Y');
        if(!empty($param['keyword'])) $this->db->like(self::ADMIN.'.vNickName', $param['keyword'], 'both');
        $this->db->limit($param['limit'], $param['start']);
        $this->db->order_by($param['order'], $param['sort']);
        $aRtn =  $this->db->get()->result_array();
        return $aRtn;
    }

    public function getAdminCount($param){
        $this->db->from(self::ADMIN);
        $this->db->where('emDelFlag !=','Y');
	    if(!empty($param['keyword'])) $this->db->like(self::ADMIN.'.vNickName', $param['keyword'], 'both');
        $aRtn =  $this->db->get()->num_rows();
        return $aRtn;
    }

	public function getAdminInfo($nSeqNo){
		$aRtn = $this->db
			->select('vUid, nLevel, vCall, vNickName')
                            ->where('nSeqNo', $nSeqNo)
                            ->from(self::ADMIN)->get()->row_array();
        return $aRtn;
	}

    public function getAdminExist($param){
        $vResult = $this->db->where('vUid', $param['vUid'])
            ->from(self::ADMIN)->get()->num_rows();
        return $vResult;
    }

	public function postAdmin($param){
	    $isExist = $this->getAdminExist($param);
        if($isExist){
            return "exist";
        }
        else{
            $param['vPwd'] = $this->secret->aes_encrypt($param['vPwd']);
            $this->db->insert(self::ADMIN, $param);
            return "done";
        }
    }
    public function putAdmin($nSeqNo, $param){
        $result = $this->db->where('nSeqNo', $nSeqNo)
                ->update(self::ADMIN, $param);
        if($result){
            return "success";
        }
        else{
            return "error";
        }
    }
	public function putAdminPassword($vUid, $param){
		$result = $this->db->where('vUid', $vUid)
			->update(self::ADMIN, $param);
		if($result){
			return "success";
		}
		else{
			return "error";
		}
	}

}