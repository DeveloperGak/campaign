<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Main extends CI_Controller{
	const ADMIN = 'admin';

	function __construct(){
		parent::__construct();
		$this->load->database();
		$this->load->library('Util');
		$this->load->library('Secret');
	}

	# main / login
	public function index(){
		redirect('admin/login');
		exit;
	}

	public function login(){
		$this->load->view('admin/login');
	}

	public function loginCheck(){
		$vUserId = $this->input->post('userid');
		$vUserPwd = $this->input->post('passwd');
		$this->db->from(self::ADMIN);
		$this->db->where('vUid', $vUserId);
		$this->db->where('vPwd', $this->secret->aes_encrypt($vUserPwd));
		$this->db->where('emDelFlag', 'N');

		$query=$this->db->get();

		if ($query->num_rows() > 0){
			$data = $query->result_array()[0];
			$sessionData = array(
				'nLevel'	  => $data['nLevel']
				, 'vUid'   => $vUserId
				, 'nSeqNo'   => $data['nSeqNo']
			);
			$this->session->set_userdata($sessionData);
			echo "success";
		}
		else{
			echo "fail";
		}
	}

	public function logOut(){
		session_destroy();
		redirect('/admin');
	}
}