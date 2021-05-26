<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

	class model_export extends CI_Model {
	
		public function __construct()
		{
			parent:: __construct();
		}

		public function get_users()
		{
			$qry = $this->db->query("SELECT * FROM Users WHERE Users_ID < 300");
			return $qry->result();
		}

		public function get_loc_info($loc_id)
		{
			$data  = array('loc_id' => $loc_id);
			$query = $this->db->get_where('Academy_Court_Locations', $data);
			return $query->row_array();
		}

		public function get_court_name($court_id){
			$data  = array('court_id' => $court_id);
			$query = $this->db->get_where('Academy_Courts', $data);
			$get_data = $query->row_array();

			return $get_data['court_name'];
		}

		public function get_user($user)
		{
			$data = array('Users_ID'=>$user);
			$query = $this->db->get_where('Users', $data);
			$res		 = $query->row_array();
			return $res['Firstname']." ".$res['Lastname'];
		}

	}