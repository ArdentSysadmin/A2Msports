<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

	class model_help extends CI_Model {
		
		public function __construct()
		{
			parent:: __construct();
	
		}

		public function get_details($user_id)
		{
		
			$data = array('Users_ID'=>$user_id);
			$query = $this->db->get_where('Users',$data);
			return $query->row_array();
		
		}
		

	}