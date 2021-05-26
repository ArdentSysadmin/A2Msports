<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class model_coaches extends CI_Model {

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

	public function get_coaches($user_id) {
		$qry_check = $this->db->query("select s.Sportname, u.* from users u inner join SportsType s on s.SportsType_ID = u.coach_sport where u.Is_coach = 1 and u.Country = (SELECT Country FROM Users WHERE Users_ID = '".$user_id."')");
		return $qry_check->result_array();
	}
}
