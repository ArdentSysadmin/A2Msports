<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class model_push_notif extends CI_Model {

	public $req_method;

	public function __construct() {
		parent:: __construct();
		$this->load->database();

		if($this->input->server('REQUEST_METHOD') == 'GET') {
			$this->req_method = 'get';
		}
		else if($this->input->server('REQUEST_METHOD') == 'POST') {
			$this->req_method = 'post';
		}
	}

	public function store_token($det) {
		$data = array('user_id' => $det['user_id'], 'token' => $det['token_id']);

		$query = $this->db->query("SELECT * FROM userPushTokens WHERE user_id = ".$det['user_id']." AND token = '".$det['token_id']."'");
		
		//return $this->db->last_query();

		//$query  = $qry_check->row_array();

		if($query->num_rows() == 0){
			$data['status'] = 1;
			$result = $this->db->insert('userPushTokens', $data);
			if($result){ return "Inserted"; }
		}
		else if($query->num_rows() > 0){
			$data2['status'] = 1;

					  $this->db->where($data);
			$result = $this->db->update('userPushTokens', $data2);
			if($result){ return "Updated"; }
		}
		else{
			return 0;
		}
	}

	public function unset_token($det) {
		$data = array('user_id' => $det['user_id'], 'token' => $det['token_id']);

		$query = $this->db->query("SELECT * FROM userPushTokens WHERE user_id = ".$det['user_id']." AND token = '".$det['token_id']."'");
		
		//return $this->db->last_query();

		//$query  = $qry_check->row_array();

		if($query->num_rows() == 0){
			$data['status'] = 0;
			$result = $this->db->insert('userPushTokens', $data);
			if($result){ return "Unset Done"; }
		}
		else if($query->num_rows() > 0){
			$data2['status'] = 0;

					  $this->db->where($data);
			$result = $this->db->update('userPushTokens', $data2);
			if($result){ return "Unset Done"; }
		}
		else{
			return 0;
		}
	}

}