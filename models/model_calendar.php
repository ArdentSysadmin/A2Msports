<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

	class model_calendar extends CI_Model {
		
		public function __construct()
		{
			parent:: __construct();
	
		}

		public function get_tournaments()
		{
			if($this->session->userdata('user')){
				$lat  = $this->session->userdata('lat');
				$long = $this->session->userdata('long');
				$range = 100;

				$query = $this->db->query(" SELECT * , ACOS( SIN( RADIANS( Latitude )) * SIN( RADIANS( $lat )) + COS( RADIANS( Latitude ) )
					* COS( RADIANS( $lat )) * COS( RADIANS( Longitude ) - RADIANS( $long )) ) * 3964.3 AS distance FROM tournament WHERE ACOS( SIN( RADIANS( Latitude )) * SIN( RADIANS( $lat )) + COS( RADIANS( Latitude ) ) * COS( RADIANS( $lat )) * COS( RADIANS( Longitude ) - RADIANS( $long )) ) * 3964.3 < {$range}
					OR (latitude = 0 AND longitude = 0)");
			} else {
				$query = $this->db->get('tournament');
			}
			//echo $this->db->last_query();
		return $query->result();
		}

		public function get_events(){	
			$query = $this->db->query("SELECT ev.Ev_Title, ev.ev_id, evs.Ev_Date, evs.Ev_Start_Time, evs.Ev_End_Time FROM Events ev INNER JOIN Ev_Repeat_Schedule evs ON ev.Ev_ID = evs.Ev_ID WHERE ev.Ev_Title NOT LIKE 'Team Match%'");

			return $query->result();
		}

	}