<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class Response {
	protected $CI;

	# 생성자
	function __construct()  {
		$this->CI =& get_instance();
	}

	function View($viewpage, $data=''){
		$this->CI->load->view('front/_include/header');
		$this->CI->load->view('front/'.$viewpage, $data);
		$this->CI->load->view('front/_include/footer');
	}

	function moView($viewpage, $data=''){
		$this->CI->load->view('front/_include/header');
		$this->CI->load->view('front/mo/'.$viewpage, $data);
		$this->CI->load->view('front/_include/footer');
	}

	function pcView($viewpage, $data=''){
		$this->CI->load->view('front/_include/header');
		$this->CI->load->view('front/pc/'.$viewpage, $data);
		$this->CI->load->view('front/_include/footer');
	}

    function viewAdmin($viewpage, $data=''){
        $this->CI->load->view('admin/_include/header');
        $this->CI->load->view('admin/'.$viewpage, $data);
    }
}
