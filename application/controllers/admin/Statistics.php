<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Statistics extends CI_Controller {

	public function __construct() {
		parent::__construct();
        $this->load->model('Campaign_model');
	}

	public function index(){
        if($this->session->userdata('nLevel') === "2"){
            redirect('/admin/campaign');
        }
        else if($this->session->userdata('nLevel') === "1"){
            $this->getStatisticsList();
        }
        else{
            redirect('/admin/login');
        }
	}

	public function getStatisticsList(){
		$startdate = ($this->input->get("startdate")) ? $this->input->get("startdate") : date("Y-m-d");
		$enddate = ($this->input->get("enddate")) ? $this->input->get("enddate") : date("Y-m-d", strtotime("+30 days"));
        $param = array(
             "order" => "nApplicantCount"
            , "sort"  => "desc"
            , "startdate"  => $startdate
            , "enddate"  => $enddate
        );


        $data['list'] = $this->Campaign_model->getCampaignList($param);

        $this->response->viewAdmin('statistics/list', $data);
	}
}
