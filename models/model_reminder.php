<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

	class model_reminder extends CI_Model {
	
		public function __construct(){
			parent:: __construct();
		}

		public function get_events(){
			$this->db->select('*');
			$query = $this->db->get('Events');
			return $query->result();
		}

		public function get_rep_events(){
			$current_date = strtotime(date("Y-m-d"));
			//$current_time = strtotime(date("H:i"));
			//$pre_date = strtotime("+1 day", $current_date);

			//$event_on = date("Y-m-d",strtotime("+1 day", $current_date)); // +1 day
			$event_on = date("Y-m-d",strtotime("+0 day", $current_date));    // For Today


			//$event_on_time = date("H:i",strtotime("+1 hour", $current_time));
			
			$this->db->select('*');
			$this->db->from('Ev_Repeat_Schedule');
			$this->db->order_by("Ev_Date", "des");
			$this->db->where('Ev_Date =', $event_on);
			//$this->db->where('Ev_Start_Time >=', $current_time);
			//$this->db->where('Ev_Start_Time <=', $event_on_time);
			$query=$this->db->get();
			return $query->result();
		}

		public function get_rep_event_users($ev_id, $ev_rep_id){

			$data = array('Ev_ID' => $ev_id ,'Ev_Rep_ID' => $ev_rep_id, Ev_status => 'Accept');
			//$data = array('Ev_ID' => $ev_id ,'Ev_Rep_ID' => $ev_rep_id);
			$get_users = $this->db->get_where('Ev_Inv_Status',$data);
			return $get_users->result();
		
		}

		public function getonerow($ev_id){
			
			$data = array('Ev_ID'=>$ev_id);
			$get_sp_name = $this->db->get_where('Events',$data);
			return $get_sp_name->row_array();
		}

/* ---------------------------------- League Model Functions ------------------------------------------------------------------- */

		public function get_tourn_matches(){
			$current_date = strtotime(date("Y-m-d"));
			//$current_time = strtotime(date("H:i"));
			//$pre_date = strtotime("+1 day", $current_date);

			$match_due_on = date("Y-m-d", strtotime("+1 day", $current_date)); // +1 day
			//$event_on = date("Y-m-d",strtotime("+0 day", $current_date));    // For Today
			//$event_on_time = date("H:i",strtotime("+1 hour", $current_time));
			
			$this->db->select('*');
			$this->db->from('Tournament_Matches');
			$this->db->order_by("Match_DueDate", "des");
			$this->db->where('Match_DueDate =', $match_due_on." 00:00:00.000");
			$this->db->where('Winner =', 0);
			//$this->db->where('Ev_Start_Time >=', $current_time);
			//$this->db->where('Ev_Start_Time <=', $event_on_time);
			$query=$this->db->get();
			return $query->result();
		}

		public function get_tour_det($tour_id){
			
			$data = array('tournament_ID' => $tour_id);
			$get_tour = $this->db->get_where('Tournament',$data);
			return $get_tour->row_array();
		}

/* ---------------------------------- League Model Functions -------------------------------------------------------------------- */

	}