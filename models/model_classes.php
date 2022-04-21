<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

	class model_classes extends CI_Model {
	
		public function __construct(){
			parent:: __construct();
		}

		public function get_event_types(){
			$data = array('Ev_Type_Status' => 1);
			$get_sp_name = $this->db->get_where('Events_Type', $data);
			return $get_sp_name->result();
		}

	}