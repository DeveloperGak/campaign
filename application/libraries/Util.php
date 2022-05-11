<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Util
{

	protected $CI;

    function __construct() 
    {
    	$this->CI =& get_instance();
		
		$this->CI->load->library('session');
    }

	public function generateRandomString($type, $length) {
    	if($type == "all") $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    	if($type == "number") $characters = '0123456789';

		$charactersLength = strlen($characters);
		$randomString = '';
		for ($i = 0; $i < $length; $i++) {
			$randomString .= $characters[rand(0, $charactersLength - 1)];
		}
		return $randomString;
	}



}
