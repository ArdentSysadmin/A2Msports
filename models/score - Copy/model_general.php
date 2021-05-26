<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class model_general extends CI_Model {

	public $req_method;

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

	public function get_sports(){
		$qry_check = $this->db->query("SELECT SportsType_ID as sport_id, Sportname as sport_title FROM SportsType");
		return $qry_check->result();
	}

	public function get_sport($sport){
		$qry_check = $this->db->query("SELECT SportsType_ID as sport_id, Sportname as sport_title FROM SportsType WHERE SportsType_ID = $sport");
		//echo $this->db->last_query();
		return $qry_check->row_array();
	}

	public function get_sport_levels(){
		$qry_check = $this->db->query("SELECT SportsLevel_ID as sport_level_id, SportsType_ID as sport_id, SportsLevel as sport_level FROM SportsLevels");
		return $qry_check->result();
	}

	public function get_tour_info($tourn_id){				   
		$data = array('tournament_ID'=>$tourn_id);
		$query = $this->db->get_where('tournament',$data);
		return $query->row_array();
	}

	public function get_user($uid){
		$data = array('Users_ID' => $uid);
		$query = $this->db->get_where('Users', $data);
		return $query->row_array();
	}

	public function get_user_sp_intrests($uid){
		$data = array('users_id' => $uid);
		$query = $this->db->get_where('Sports_Interests', $data);
		return $query->result_array();
	}

	public function get_email($email)
	{
		$data   = array('EmailID' => $email);
		$result = $this->db->get_where('Users',$data);

		if ($result->num_rows > 0){
			return true;
		}
		else{
			return false;
		}
	}
}