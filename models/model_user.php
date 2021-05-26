
<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

	class model_user extends CI_Model {
		
		public function __construct()
		{
			parent:: __construct();
	
		}

		public function get_users_no_a2m(){
			$qry_check = $this->db->query("select Users_ID from Users where Users_ID not in (select Users_ID from A2MScore)");
			return $qry_check->result();
		}

		public function get_sports(){
			$query = $this->db->get('SportsType');
			return $query->result();
		}

	}