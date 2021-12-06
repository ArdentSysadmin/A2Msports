<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class model_log extends CI_Model {

	public $req_method;
	public $country_arr;
	public $country_str;

	public function __construct(){
		parent:: __construct();
		$this->load->database();

		if($this->input->server('REQUEST_METHOD') == 'GET'){
			$this->req_method = 'get';
		}
		else if($this->input->server('REQUEST_METHOD') == 'POST'){
			$this->req_method = 'post';
		}

	}

	public function ins_log($data){
		$result = $this->db->insert('App_ErrorLog', $data);
		return  $result; 
	}

	public function get_logs($user_id = ''){
		$error_logs = '';

		if($user_id)
			$get_log	= $this->db->query("SELECT arl.* FROM App_ErrorLog arl WHERE User_ID = {$user_id}");	
		else
			$get_log	= $this->db->query("SELECT arl.* FROM App_ErrorLog arl");
		
		$error_logs	= $get_log->result();
		return $error_logs;	
	}

}