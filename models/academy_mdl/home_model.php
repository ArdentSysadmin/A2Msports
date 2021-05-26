<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

	class Home_model extends CI_Model {
		
		public function __construct()
		{
			parent:: __construct();
	
		}

		public function get_specific_sport($game)
		{
		
			$current_date = date("Y-m-d");
			$limit= 1;

			/*$this->db->select('*');
			$this->db->from('tournament');
			$this->db->order_by('StartDate','ASC');
			$this->db->where('SportsType',$game);
			$this->db->where('StartDate >=',$current_date);
			$this->db->limit($limit);
			$query=$this->db->get(); */

		
			  $qry_check = $this->db->query("SELECT TOP 1 * FROM tournament WHERE SportsType = $game AND StartDate >= '$current_date' ORDER BY StartDate ASC");

			  if($qry_check->num_rows() > 0){

				return $qry_check->result();
			  }
			  else{
				//$qry_check = $this->db->query("SELECT TOP 1 * FROM tournament WHERE StartDate in (SELECT MAX (StartDate) FROM tournament where SportsType = $game)");

				$qry_check = $this->db->query("SELECT TOP 1 * FROM tournament WHERE SportsType = $game AND StartDate in (SELECT MAX (StartDate) FROM tournament WHERE SportsType = $game)  ");


				return $qry_check->result();
			  }
		
		}

		public function get_count_members()
		{
			$this->db->select('*');
			$this->db->from('Users');
			$query=$this->db->get();
			return $query->num_rows();
		}

		public function get_count_tourns()
		{
			$this->db->select('*');
			$this->db->from('tournament');
			$query=$this->db->get();
			return $query->num_rows();
		}

		public function get_count_matches()
		{
			$this->db->select('*');
			$this->db->from('GeneralMatch');
			$query=$this->db->get();
			return $query->num_rows();
		}

		public function get_count_tourn_matches()
		{
			$this->db->select('*');
			$this->db->from('Tournament_Matches');
			$query=$this->db->get();
			return $query->num_rows();
		}
	}