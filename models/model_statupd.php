<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

	class Model_statupd extends CI_Model {
		
		public function __construct()
		{
			parent:: __construct();
			$this->load->database();
		}
		
		public function get_users($offset_count)  // Get users offset_count (sent from task schedular reques)t to 300 count
		{
			$query	   = "SELECT * FROM Users ORDER BY Users_ID OFFSET {$offset_count} ROWS FETCH NEXT 300 ROWS ONLY";
			$exe_query = $this->db->query($query);

			return $exe_query->result();
		}
		
		public function get_intrests()
		{
			$query = $this->db->get('SportsType');
			return $query->result();
		}
		
		public function gen_matches($user, $sport)
		{
			$sql = "SELECT * FROM GeneralMatch WHERE Sports = '$sport' AND (users_id = '$user' OR Player1_Partner = '$user')";

			//$sql = "SELECT * FROM GeneralMatch";
			$query = $this->db->query($sql);
			return $query->result();
		}

		public function gen_ind_matches($match_id)
		{
			$sql = "SELECT * FROM IndividualPlay WHERE Winner IS NOT NULL and GeneralMatch_ID = $match_id";
			$query = $this->db->query($sql);
			return $query->result();
		}

		public function gen_match_creator($match_id)
		{
			$sql = "SELECT * FROM GeneralMatch WHERE GeneralMatch_ID = $match_id";
			$query = $this->db->query($sql);
			return $query->row_array();
		}

		public function gen_sport_ind_matches($user, $sport)
		{
			$sql = "SELECT * FROM IndividualPlay WHERE Winner IS NOT NULL AND (Opponent = '$user' OR Player2_Partner = '$user') AND GeneralMatch_ID IN (SELECT GeneralMatch_ID FROM GeneralMatch WHERE Sports = '$sport')";
			$query = $this->db->query($sql);
			return $query->result();
		}

		public function gen_ind_opp_matches($user)
		{
			$sql = "SELECT * FROM IndividualPlay WHERE Winner IS NOT NULL AND (Opponent = '$user' OR Player2_Partner = '$user')";
			$query = $this->db->query($sql);
			return $query->result();
		}

		public function gen_tour_matches_p1($user, $sport)
		{
			$sql = "SELECT * FROM Tournament_Matches WHERE Winner IS NOT NULL AND (Player1 = '$user' OR Player1_Partner = '$user') AND Tourn_ID IN (SELECT tournament_ID FROM tournament WHERE SportsType = '$sport')";
			$query = $this->db->query($sql);
			return $query->result();
		}

		public function gen_tour_matches_p2($user, $sport)
		{
			$sql = "SELECT * FROM Tournament_Matches WHERE Winner IS NOT NULL AND (Player2 = '$user' OR Player2_Partner = '$user') AND Tourn_ID IN (SELECT tournament_ID FROM tournament WHERE SportsType = '$sport')";
			$query = $this->db->query($sql);
			return $query->result();
		}

		public function get_team_line_matches_p1($user, $sport)
		{
			$sql = "SELECT * FROM Tournament_Lines WHERE Winner IS NOT NULL AND (Player1 = '{$user}' OR Player1_Partner = '{$user}') AND Tourn_ID IN (SELECT tournament_ID FROM tournament WHERE SportsType = '{$sport}')";
			$query = $this->db->query($sql);

			return $query->result();
		}

		public function get_team_line_matches_p2($user, $sport)
		{
			$sql = "SELECT * FROM Tournament_Lines WHERE Winner IS NOT NULL AND (Player2 = '$user' OR Player2_Partner = '$user') AND Tourn_ID IN (SELECT tournament_ID FROM tournament WHERE SportsType = '$sport')";
			$query = $this->db->query($sql);
			return $query->result();
		}

		public function update_player_table($data){
			
			$sql = "UPDATE Player_Matches_Count SET Won = $data[won],Lost = $data[lost],Num_Matches = $data[tot_played], Win_Per = $data[win_per],Win_FF = $data[win_ff],Lost_FF = $data[lost_ff],Bye_Matches = $data[bye_m] WHERE Users_ID = $data[player] AND Sport = $data[sport]";

			$query = $this->db->query($sql);

			/*if($query){
				echo "Success: $data[player] - $data[sport]<br>";
			}*/
			
		}


		public function ins_new_a2m($user_id, $sport, $a2m){

			$data = array('Users_ID' => $user_id,
						  'SportsType_ID' => $sport,		
						  'A2MScore' => $a2m);

			$query = $this->db->get_where('A2MScore',$data);
			$exists = $query->result();

			if($query->num_rows() == 0)
			{
				$this->db->insert('A2MScore', $data);
			}

		}


/*
		public function get_count(){
			$sql = "SELECT Opponent FROM IndividualPlay where Winner is not null UNION ALL SELECT Player1 FROM Tournament_Matches where Winner != '0'";
			$query = $this->db->query($sql);
			return $query->result();
		}
*/
}