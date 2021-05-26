<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

	class model_calendar extends CI_Model {
		
		public function __construct()
		{
			parent:: __construct();
	
		}
		
		public function get_tournaments($org_id = "")
		{
			$user = '';
			if($org_id){
				$query	  = $this->db->get_where('Academy_Info', array('Aca_ID' => $org_id));
				$get_user = $query->row_array();

				$user = $get_user['Aca_User_id'];
			
			$query = $this->db->get_where('tournament', array('Usersid' => $user));
			}
			else
			{
			$query = $this->db->get_where('tournament');
			}

			return $query->result();
		}
		public function get_events($org_id = "")
		{
			$user = '';
			
			if($org_id){
				$query	  = $this->db->get_where('Academy_Info', array('Aca_ID' => $org_id));
				$get_user = $query->row_array();
				$user = $get_user['Aca_User_id'];
				$query = $this->db->query(" select ev.Ev_Title, ev.ev_id, evs.Ev_Date , evs.Ev_Start_Time , evs.Ev_End_Time from Events ev inner join Ev_Repeat_Schedule evs on ev.Ev_ID = evs.Ev_ID where ev.Ev_Created_by = {$user} ");
			}
			else
			{
				$query = $this->db->query(" select ev.Ev_Title, ev.ev_id, evs.Ev_Date , evs.Ev_Start_Time , evs.Ev_End_Time from Events ev inner join Ev_Repeat_Schedule evs on ev.Ev_ID = evs.Ev_ID ");
			}

			return $query->result();
		}

	}