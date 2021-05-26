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

	public function get_user($user) {
			$data		= array('Users_ID' => $user);
			$query	= $this->db->get_where('Users', $data);
			return $query->row_array();
	}

	public function store_token($det) {
		if($det['club_id']){
			$data = array('user_id' => $det['user_id'], 'club_id' => $det['club_id'], 'token' => $det['token_id']);
			$query = $this->db->query("SELECT * FROM userPushTokens WHERE user_id = ".$det['user_id']." AND club_id = ".$det['club_id']." AND token = '".$det['token_id']."'");
		}
		else{
			$data = array('user_id' => $det['user_id'], 'token' => $det['token_id']);
			$query = $this->db->query("SELECT * FROM userPushTokens WHERE user_id = ".$det['user_id']." AND token = '".$det['token_id']."'");
		}	
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
		if($det['club_id']){
			$data = array('user_id' => $det['user_id'], 'club_id' => $det['club_id'], 'token' => $det['token_id']);
			$query = $this->db->query("SELECT * FROM userPushTokens WHERE user_id = ".$det['user_id']." AND club_id = ".$det['club_id']." AND token = '".$det['token_id']."'");
		}
		else{
			$data = array('user_id' => $det['user_id'], 'token' => $det['token_id']);
			$query = $this->db->query("SELECT * FROM userPushTokens WHERE user_id = ".$det['user_id']." AND token = '".$det['token_id']."'");
		}
		
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

	public function get_userNotifications($user, $club='', $expo='') {
		if($user)
			$this->db->where('Recipient', $user);
		if($club)
			$this->db->where('Club_ID', $club);
		if($expo)
			$this->db->where('Expo_Token', $expo);
			
			//$cur_date = date('Y-m-d');
		  // $this->db->where('Sent_On >=', $cur_date);
		  $this->db->order_by("Sent_On", "DESC");

					 $this->db->select("Notif_ID, Sender, Recipient, Club_ID, Message, Json_Message, Notif_Type, MType, Ref_ID, Sent_Players, Send_Status, Read_Status, Sent_On, Read_On");
			$q = $this->db->get('Mobile_Notifications');

			//echo $this->db->last_query();
			//exit;
			return $q->result();
	}
}