<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

	class test_model extends CI_Model {
		
		public function __construct()
		{
			parent:: __construct();
			$this->load->database();
		}
		
		public function get_users()
		{
			$query = $this->db->select('Users_ID');
			//$query = $this->db->get('Users');
			$query = $this->db->get_where('Users',array('Users_ID'=>'381'));
			return $query->result();
		}
		
		public function get_intrests()
		{
			$query = $this->db->get('SportsType');
			return $query->result();
		}
		
	

		public function gen_matches($user)
		{
		//	$sql = "SELECT * FROM GeneralMatch WHERE Winner IS NOT NULL AND (Opponent = '$user' OR Player2_Partner = '$user')";

			$sql = "SELECT * FROM GeneralMatch";
			$query = $this->db->query($sql);
			return $query->result();
		}


		public function gen_ind_matches($match_id)
		{

			$sql = "SELECT * FROM IndividualPlay WHERE Winner IS NOT NULL and GeneralMatch_ID = $match_id";
			$query = $this->db->query($sql);
			return $query->result();

		}

		public function gen_ind_opp_matches($user)
		{

			$sql = "SELECT * FROM IndividualPlay WHERE Winner IS NOT NULL AND (Opponent = '$user' OR Player2_Partner = '$user')";
			$query = $this->db->query($sql);
			return $query->result();

		}

		public function tour_matches($user)
		{

			$sql = "SELECT * FROM Tournament_Matches WHERE Winner IS NOT NULL AND (Player1 = '$user' OR Player1_Partner = '$user' OR Player2 = '$user' OR Player2_Partner = '$user')";
			$query = $this->db->query($sql);
			return $query->result();

		}

		public function get_tourn_users()
		{
			//$sql = "select * from IndividualPlay";
			//$query = $this->db->query($sql);
			//return $query->result();select * from 

			$this->db->where('Winner !=', '0');
			//$this->db->group_by('Play_id');
			$get_name = $this->db->get_where('Tournament_Matches');
			return $get_name->result();

		}

		public function get_count()
		{
			
			$sql = "SELECT Opponent FROM IndividualPlay where Winner is not null UNION ALL SELECT Player1 FROM Tournament_Matches where Winner != '0'";
			$query = $this->db->query($sql);
			return $query->result();
		}



		
			
	}