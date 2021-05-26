<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

	class model_clubs extends CI_Model {
	
		public function __construct(){
			parent:: __construct();
		}

		public function get_lat_lang()
		{
			$user_id = $this->session->userdata('users_id');
			$data = array('Users_ID'=>$user_id);

			$this->db->select('Latitude, Longitude');
			$query = $this->db->get_where('Users',$data);
			return $query->row();
		}

		public function is_valid_subscr($mem_code, $user_id)
		{
			$query = $this->db->query("SELECT * FROM User_memberships WHERE Users_id = '{$user_id}' AND  Membership_Code = '".$mem_code."' AND Member_Status = 0");
			return $query->row_array();
		}

		public function get_intrests(){
			$query = $this->db->get('SportsType');
			return $query->result();
		}

		public function get_clubs(){
			$query = $this->db->query("SELECT * FROM Academy_Info WHERE Aca_URL_ShortCode IS NOT NULL AND Aca_ID IN (SELECT org_id FROM Academy_Court_Locations)");
			return $query->result();
		}
	}