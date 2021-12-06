<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

	class model_members extends CI_Model {
		
		public function __construct()
		{
			parent:: __construct();
			$this->load->database();
		}

		public function get_user_data()
		{
			$this->db->select('*');
			$this->db->order_by("RegistrationDtTm","asc");
			$this->db->from('users');
			$query=$this->db->get();
			return $query->result();
		}

		public function get_tennis_levels()
		{
			$data = array('SportsType_ID'=> '1');
			$query = $this->db->get_where('SportsLevels',$data);
			return $query->result();
		}

		public function get_sport_levels($sport_id)
		{
			$data = array('SportsType_ID'=> $sport_id);
			$query = $this->db->get_where('SportsLevels',$data);
			return $query->result();
		}

		public function get_userToken($user_id)
		{
			$data  = array('user_id' => $user_id, 'status' => 1);
			$query = $this->db->get_where('userPushTokens', $data);
			return $query->result();
		}

		public function get_membership_details($user_id)
		{
			$qr_check = $this->db->query("SELECT * FROM User_memberships WHERE Users_id = $user_id");
			return $qr_check->result();
		}

		public function get_club($org_id)
		{
			$data = array('Aca_ID'=>$org_id);
			
			$qry_check = $this->db->get_where('Academy_Info', $data);
			return $qry_check->row_array();
		}

		public function search_loc_details($data)
		{
			$name		= $data['search_uname'];
			$loc_city	= $data['loc_city'];
			$loc_state	= $data['loc_state'];
			$sport		= $data['sport'];

		    ($data['lat'] == "")  ? $lat  = 0 : $lat  = $data['lat'];
		    ($data['long'] == "") ? $long = 0 : $long = $data['long'];
		
			if($name != ""){
			$name_arr = explode(' ', $name);
			if(count($name_arr)>1){
                $name_text1 = $name_arr[0];
                $name_text2 = $name_arr[1];
                $name_cond = "(Firstname LIKE '%{$name_text1}%' AND Lastname LIKE '%{$name_text2}%')";
			}else{
				$name_text1 = $name_arr[0];
                $name_cond = "(Firstname LIKE '%{$name_text1}%' OR Lastname LIKE '%{$name_text1}%')";
			}
			
			}
			else{
				$name_cond = "";
			}

			$loc_cond = "";
			if($name != "" AND ($loc_city != "" OR $loc_state != ""))
			{
				$loc_cond = "AND (City LIKE '%{$loc_city}%' AND State LIKE '%{$loc_state}%')";
			}
			else if($loc_city != "" OR $loc_state != "")
			{
				$loc_cond = "(City LIKE '%{$loc_city}%' AND State LIKE '%{$loc_state}%')";
			}
			else 
			{
				$loc_cond = "";
			}

			$sport_cond = "";
			if($sport != "")
			{
				if($name != "" OR $loc_city != "" OR $loc_state != ""){
					$sport_cond = " AND Users_ID IN (SELECT users_id FROM Sports_Interests WHERE Sport_id = {$sport})"; 
				}
				else{
					$sport_cond = "Users_ID IN (SELECT users_id FROM Sports_Interests WHERE Sport_id = {$sport})";
				}
			}
			else
			{
				$sport_cond = "";
			}

			if($name != "" OR $loc_city != "" OR $loc_state != "" OR $sport != "" OR $org_id != ""){
				$query = $this->db->query(" SELECT * FROM users WHERE {$name_cond} {$loc_cond} {$sport_cond}");
			}
			else
			{
				$query = $this->db->query(" SELECT * FROM users");
			}
			
			//print_r($this->db->last_query());
			//exit;

			return $query->result();
		}

		public function search_details($data)
		{
			$name =  $data['search_fname']; 
			$range = $data['range'];
			$sport = $data['sport'];
			$level = $data['level'];

			if($this->input->post('academy_status') == '1'){
				$org_id = $this->input->post('org_id');
			} else {
				 $org_id = "";
			}

			//$org_id = $data['org_id'];

		    ($data['lat']=="") ? $lat = 0 : $lat = $data['lat'];
		    ($data['long']=="") ? $long = 0 : $long = $data['long'];

			$name_cond = "";
		
			
			if($name != ""){
			$name_arr = explode(' ', $name);
			if(count($name_arr)>1){
                $name_text1 = $name_arr[0];
                $name_text2 = $name_arr[1];
                $name_cond = "(Firstname LIKE '%{$name_text1}%' AND Lastname LIKE '%{$name_text2}%')";
			}else{
				$name_text1 = $name_arr[0];
                $name_cond = "(Firstname LIKE '%{$name_text1}%' OR Lastname LIKE '%{$name_text1}%')";
			}
			
			}
			else{
				$name_cond = "";
			}

			$Sport_cond = "";
			if($sport != "")
			{
				if($name !=""){
					$Sport_cond = "AND Users_ID IN (select users_id from Sports_Interests where Sport_id ={$sport})"; 
				}
				else{
					$Sport_cond = "Users_ID IN (select users_id from Sports_Interests where Sport_id ={$sport})";
				}
			}
			else
			{
				$Sport_cond = "";
			}

			$level_cond = "";
			if($level != "")
			{
				if($name!="" OR  $Sport != "")
				{
					$level_cond = "AND users_id IN (SELECT users_id FROM Sports_Interests WHERE Level IN ($level) AND Sport_id = {$sport})";
				}
				else
				{
					$level_cond = "users_id IN (SELECT users_id FROM Sports_Interests WHERE Level IN ($level) AND Sport_id = {$sport})";
				}
			}else
			{
				$level_cond = "";
			}

			$org_cond = "";

			if(!empty($org_id)){
				if($name!="" OR  $Sport != "" OR  $level != "")
				{
					$org_cond = " AND Users_ID IN (SELECT Users_id FROM Academy_users WHERE Org_ID = $org_id)";
				} 
				else
				{
					$org_cond = "Users_ID IN (SELECT Users_id FROM Academy_users WHERE Org_ID = $org_id)";
				}
			}
			else{
				$org_cond .= "";
			}

			if($range != "")
			{
				if($name != "" OR $sport != "" OR $level != "" OR $org_id != ""){
					$range_cond = " AND ACOS( SIN( RADIANS( Latitude )) * SIN( RADIANS( $lat ) ) + COS( RADIANS( Latitude ) ) * COS( RADIANS( $lat )) *  COS( RADIANS( Longitude ) - RADIANS( $long)) ) * 3964.3 < {$range}";
						
					$query = $this->db->query(" SELECT * , ACOS( SIN( RADIANS( Latitude ) ) * SIN( RADIANS( $lat ) ) + COS( RADIANS( Latitude ) )
					* COS( RADIANS( $lat )) * COS( RADIANS( Longitude ) - RADIANS( $long )) ) * 3964.3 AS distance FROM users WHERE  {$name_cond}  {$Sport_cond} {$level_cond}  {$org_cond} {$range_cond}");			
				}
				else
				{
					$range_cond = "ACOS( SIN( RADIANS( Latitude )) * SIN( RADIANS( $lat )) + COS( RADIANS( Latitude ) ) * COS( RADIANS( $lat )) *  COS( RADIANS( Longitude ) - RADIANS( $long)) ) * 3964.3 < {$range}";

					$query = $this->db->query(" SELECT * , ACOS( SIN( RADIANS( Latitude ) ) * SIN( RADIANS( $lat ) ) + COS( RADIANS( Latitude ) )
					* COS( RADIANS( $lat )) * COS( RADIANS( Longitude ) - RADIANS( $long )) ) * 3964.3 AS distance FROM users WHERE  {$name_cond}  {$Sport_cond} {$level_cond}  {$org_cond} {$range_cond}");	
				}
			}
			else
			{
				if($name != "" OR $sport != "" OR $level != "" OR $org_id != ""){
					$query = $this->db->query(" SELECT * FROM users WHERE {$name_cond} {$Sport_cond} {$level_cond} {$org_cond}");
				}
				else
				{
					$query = $this->db->query(" SELECT * FROM users");
				}
			}
			
			//print_r($this->db->last_query());
			//exit;

			return $query->result();
		}
		
		public function search_coaches($data)
		{

			$name = $data['coach_name'];
			$range = $data['coach_range'];
			$sport = $data['coach_sport'];

		    ($data['lat']=="") ? $lat = 0 : $lat = $data['lat'];
		    ($data['long']=="") ? $long = 0 : $long = $data['long'];

			if($name != ""){
			$name_arr = explode(' ', $name);
			if(count($name_arr)>1){
                $name_text1 = $name_arr[0];
                $name_text2 = $name_arr[1];
                $name_cond = "(Firstname LIKE '%{$name_text1}%' AND Lastname LIKE '%{$name_text2}%')";
			}else{
				$name_text1 = $name_arr[0];
                $name_cond = "(Firstname LIKE '%{$name_text1}%' OR Lastname LIKE '%{$name_text1}%')";
			}
			
			}
			else{
				$name_cond = "";
			}

			$Sport_cond = "";
			if($sport != "")
			{
				
				if($name !=""){
					$Sport_cond = "AND coach_sport = $sport "; 
				}
				else
				{
					$Sport_cond = "coach_sport = $sport";
				}
			}else
			{
				$Sport_cond = "";
			}

			if($range != "")
			{
				
				if($name != "" OR $sport != "" ){
					$range_cond = " AND ACOS( SIN( RADIANS( Latitude )) * SIN( RADIANS( $lat ) ) + COS( RADIANS( Latitude ) ) * COS( RADIANS( $lat )) *  COS( RADIANS( Longitude ) - RADIANS( $long)) ) * 3964.3 < {$range}";
						
					$query = $this->db->query(" SELECT * , ACOS( SIN( RADIANS( Latitude )) * SIN( RADIANS( $lat )) + COS( RADIANS( Latitude ) )
					* COS( RADIANS( $lat )) * COS( RADIANS( Longitude ) - RADIANS( $long )) ) * 3964.3 AS distance FROM users WHERE  {$name_cond}  {$Sport_cond}  {$range_cond} AND Is_coach = 1 ");			
				}
				else
				{
					$range_cond = "ACOS( SIN( RADIANS( Latitude )) * SIN( RADIANS( $lat )) + COS( RADIANS( Latitude ) ) * COS( RADIANS( $lat )) *  COS( RADIANS( Longitude ) - RADIANS( $long)) ) * 3964.3 < {$range}";

					$query = $this->db->query(" SELECT * , ACOS( SIN( RADIANS( Latitude ) ) * SIN( RADIANS( $lat ) ) + COS( RADIANS( Latitude ) )
					* COS( RADIANS( $lat )) * COS( RADIANS( Longitude ) - RADIANS( $long )) ) * 3964.3 AS distance FROM users WHERE  {$name_cond}  {$Sport_cond}  {$range_cond} AND Is_coach = 1 ");	
				}
			}
			else
			{
				if($name != "" OR $sport != "" ){
				$query = $this->db->query(" SELECT * FROM users WHERE {$name_cond} {$Sport_cond} AND Is_coach = 1 ");
				}
				else
				{
				  $query = $this->db->query(" SELECT * FROM users WHERE Is_coach = 1 ");
				}
			}
			
			//print_r($this->db->last_query());
			//exit;

			return $query->result();
		}
		
		
		public function search_matches($data)
		{
			$sport		= $this->input->post('Sport');
			$range		= $this->input->post('range');
			
			($data['lat']  == "") ? $lat  = 0 : $lat  = $data['lat'];
			($data['long'] == "") ? $long = 0 : $long = $data['long'];

			if($sport != "")
			{
				$sport_cond = "Sports = {$sport}";
			}
			else
			{
				$sport_cond = "";
			}

			if($range != "")
			{
				if($sport != ""){
				$range_cond = "AND ACOS( SIN( RADIANS( Latitude )) * SIN( RADIANS( $lat ) ) + COS( RADIANS( Latitude ) ) * COS( RADIANS( $lat )) *  COS( RADIANS( Longitude ) - RADIANS( $long)) ) * 3964.3 < {$range}";
				}
				else
				{
				$range_cond = "ACOS( SIN( RADIANS( Latitude )) * SIN( RADIANS( $lat ) ) + COS( RADIANS( Latitude ) ) * COS( RADIANS( $lat )) *  COS( RADIANS( Longitude ) - RADIANS( $long)) ) * 3964.3 < {$range}";
				}
			}
			else
			{
				if($sport != ""){
				$range_cond = "AND ACOS( SIN( RADIANS( Latitude )) * SIN( RADIANS( $lat ) ) + COS( RADIANS( Latitude ) ) * COS( RADIANS( $lat )) *  COS( RADIANS( Longitude ) - RADIANS( $long)) ) * 3964.3 < 500";
				}
				else
				{
				$range_cond = "ACOS( SIN( RADIANS( Latitude )) * SIN( RADIANS( $lat ) ) + COS( RADIANS( Latitude ) ) * COS( RADIANS( $lat )) *  COS( RADIANS( Longitude ) - RADIANS( $long)) ) * 3964.3 < 500";
				}
			}

			$qry_check = $this->db->query("SELECT * , ACOS( SIN( RADIANS( Latitude ) ) * SIN( RADIANS( $lat ) ) + COS( RADIANS( Latitude ) )
						* COS( RADIANS( $lat )) * COS( RADIANS( Longitude ) - RADIANS( $long )) ) * 3964.3 AS distance FROM GeneralMatch WHERE {$sport_cond} {$range_cond}");

			return $qry_check->result();
		}
		
		public function search_matches1($data)
		{
			$sport		= $this->input->post('Sport');
			$range		= $this->input->post('range');
			
			($data['lat']  == "") ? $lat  = 0 : $lat  = $data['lat'];
			($data['long'] == "") ? $long = 0 : $long = $data['long'];

			if($sport != ""){
				$sport_cond = "Sports = {$sport}";
			}
			else{
				$sport_cond = "";
			}

			if($range != ""){
				if($sport != ""){
				$range_cond = "AND ACOS( SIN( RADIANS( Latitude )) * SIN( RADIANS( $lat ) ) + COS( RADIANS( Latitude ) ) * COS( RADIANS( $lat )) *  COS( RADIANS( Longitude ) - RADIANS( $long)) ) * 3964.3 < {$range}";
				}
				else{
				$range_cond = "ACOS( SIN( RADIANS( Latitude )) * SIN( RADIANS( $lat ) ) + COS( RADIANS( Latitude ) ) * COS( RADIANS( $lat )) *  COS( RADIANS( Longitude ) - RADIANS( $long)) ) * 3964.3 < {$range}";
				}
			}
			else{
				if($sport != ""){
				$range_cond = "AND ACOS( SIN( RADIANS( Latitude )) * SIN( RADIANS( $lat ) ) + COS( RADIANS( Latitude ) ) * COS( RADIANS( $lat )) *  COS( RADIANS( Longitude ) - RADIANS( $long)) ) * 3964.3 < 500";
				}
				else{
				$range_cond = "ACOS( SIN( RADIANS( Latitude )) * SIN( RADIANS( $lat ) ) + COS( RADIANS( Latitude ) ) * COS( RADIANS( $lat )) *  COS( RADIANS( Longitude ) - RADIANS( $long)) ) * 3964.3 < 500";
				}
			}

			$qry_check = $this->db->query(" SELECT * FROM IndividualPlay WHERE GeneralMatch_ID IN (SELECT GeneralMatch_id FROM GeneralMatch WHERE {$sport_cond} {$range_cond})");

			return $qry_check->result();
		}

		public function get_sport_number($gen_match_id){
			$data = array('GeneralMatch_id'=>$gen_match_id);
			$get_sp_num = $this->db->get_where('GeneralMatch',$data);
			return $get_sp_num->row_array();
		}

		public function search_tournaments($data)
		{

			$city  = $this->input->post('search_city');
			$state = $this->input->post('search_state');
			$Sport = $this->input->post('Sport');
			$range = $this->input->post('range');
			
			($data['lat']=="") ? $lat = 0 : $lat = $data['lat'];
			($data['long']=="") ? $long = 0 : $long = $data['long'];

			if($Sport != ""){
				$Sport_cond = "SportsType = {$Sport}";
			}
			else{
				$Sport_cond = "";
			}
			
			if($city != ""){
				if($Sport != ""){
				$city_cond = "AND TournamentCity like '%{$city}%'";
				}
				else{
				$city_cond = "TournamentCity like '%{$city}%'";
				}
			}
			else{
				$city_cond = "";
			}

			if($state != ""){
				if($Sport != "" OR $city != ""){
				$state_cond = "AND TournamentState like '%{$state}%'";
				}
				else
				{
				$state_cond = "TournamentState like '%{$state}%'";
				}
			}
			else{
				$state_cond = "";
			}
			

			if($range != ""){
				if($Sport != "" OR $city != "" OR $state != "") {
				$range_cond = "AND ACOS( SIN( RADIANS( Latitude )) * SIN( RADIANS( $lat ) ) + COS( RADIANS( Latitude ) ) * COS( RADIANS( $lat )) *  COS( RADIANS( Longitude ) - RADIANS( $long)) ) * 3964.3 < {$range}";
				}
				else{
				$range_cond = "ACOS( SIN( RADIANS( Latitude )) * SIN( RADIANS( $lat ) ) + COS( RADIANS( Latitude ) ) * COS( RADIANS( $lat )) *  COS( RADIANS( Longitude ) - RADIANS( $long)) ) * 3964.3 < {$range}";
				}
			}
			else if($city == "" AND $state == ""){
				if($Sport != "" OR $city != "" OR $state != "") {
				$range_cond = "AND ACOS( SIN( RADIANS( Latitude )) * SIN( RADIANS( $lat ) ) + COS( RADIANS( Latitude ) ) * COS( RADIANS( $lat )) *  COS( RADIANS( Longitude ) - RADIANS( $long)) ) * 3964.3 < 500";
				}
				else
				{
				$range_cond = "ACOS( SIN( RADIANS( Latitude )) * SIN( RADIANS( $lat ) ) + COS( RADIANS( Latitude ) ) * COS( RADIANS( $lat )) *  COS( RADIANS( Longitude ) - RADIANS( $long)) ) * 3964.3 < 500";
				}
			}
		
			$qry_check = $this->db->query("SELECT *, ACOS( SIN( RADIANS( Latitude ) ) * SIN( RADIANS( $lat ) ) + COS( RADIANS( Latitude ) )
* COS( RADIANS( $lat )) * COS( RADIANS( Longitude ) - RADIANS( $long )) ) * 3964.3 AS distance FROM tournament WHERE {$Sport_cond} {$city_cond} {$state_cond}{$range_cond} ");

/*			echo "SELECT *, ACOS( SIN( RADIANS( Latitude ) ) * SIN( RADIANS( $lat ) ) + COS( RADIANS( Latitude ) )
* COS( RADIANS( $lat )) * COS( RADIANS( Longitude ) - RADIANS( $long )) ) * 3964.3 AS distance FROM tournament WHERE {$Sport_cond} {$city_cond} {$state_cond}{$range_cond} ";
exit;*/

			return $qry_check->result();
		}
		
		public function get_intrests(){
			$query = $this->db->get('SportsType');
			return $query->result();
		}

		public function get_a2msocre($sport,$user_id){
			$data = array('SportsType_ID'=>$sport , 'Users_ID'=>$user_id);
			$get_level = $this->db->get_where('A2MScore',$data);
			return $get_level->row_array();
		}

		public function get_sport_id($user_id){
			$data = array('users_id'=>$user_id);
			$get_sp_name = $this->db->get_where('Sports_Interests',$data);
			return $get_sp_name->result();
		}

		public function get_sport_title($sport_id){
			$data = array('SportsType_ID'=>$sport_id);
			$get_sp_name = $this->db->get_where('SportsType',$data);
			return $get_sp_name->row_array();
		}

		public function search_autocomplete($data){			
			$key = $data['key'];
			$gender = $data['gender'];
			if($gender === '1' || $gender === '0'){
               $qr_check = $this->db->query("SELECT * FROM users WHERE Gender = $gender AND (Firstname  LIKE '%$key%' OR  Lastname LIKE '%$key%')");
			}
			else{
			   $qr_check = $this->db->query("SELECT * FROM users WHERE Firstname LIKE '%$key%' OR Lastname LIKE '%$key%'");
			}
			
			return $qr_check->result();
		}

		public function search_team_autocomplete($data){			
			$key	  = $data['key'];
			$sport	  = $data['sport'];

			$qr_check = $this->db->query("SELECT * FROM Teams WHERE Team_name LIKE '%$key%' AND sport = $sport");			
			return $qr_check->result();
		}
		
		public function city_autocomplete($data){
			$key = $data['key'];
			
			$this->db->select('*');
			$this->db->from('US_Cities');
			$this->db->like('city', $key); 
			//$this->db->or_like('short_code', $key);
			
			$query = $this->db->get();
			return $query->result();
			//$this->db->like('title', 'match', 'both'); 
		}
		
		public function state_autocomplete($data){
			$key = $data['key'];
			
			$this->db->select('*');
			$this->db->from('US_States');
			$this->db->like('state', $key); 
			$this->db->or_like('short_code', $key);
			
			$query = $this->db->get();
			return $query->result();
			//$this->db->like('title', 'match', 'both'); 
		}
		
		public function search_academy_users($data){
			//$sql = "SELECT Firstname ,Lastname FROM users WHERE player_name LIKE '%$my_data%' ORDER BY player_name";
			
			$key = $data['key'];
			$academy = $data['academy'];

			$qr_check = $this->db->query("SELECT * FROM Users WHERE (Firstname LIKE '%$key%' OR Lastname LIKE '%$key%') AND Users_ID IN (SELECT Users_id FROM User_memberships WHERE Club_id = $academy)");

			return $qr_check->result();
		}
		
		public function update_match_det($match_id){
			$message = $this->input->post('mes');
			$data = array('Message' => $message);
			$this->db->where('GeneralMatch_id', $match_id);
			$result = $this->db->update('GeneralMatch', $data); 
			return $result;
		}

       /// model functions for search user details start code....
		public function get_user_id($user_id){
			$data = array('Users_ID'=>$user_id);
			
			$qry_check = $this->db->get_where('users', $data);
			return $qry_check->row_array();
		}

		public function get_user_sport_intrests($user_id){
			$data = array('users_id'=>$user_id);
			$qry_check = $this->db->get_where('Sports_Interests', $data);
			return $qry_check->result();
		}

		public function get_user_matches($user_id){
			$qr_check = $this->db->query("SELECT * from IndividualPlay where (Opponent = $user_id OR GeneralMatch_ID IN (SELECT GeneralMatch_id FROM GeneralMatch WHERE users_id = $user_id)) AND Winner IS NOT NULL ORDER BY Play_Date DESC");

			return $qr_check->result();
		}

		public function get_gen_mat_det($gen_mat_id){
			$data = array('GeneralMatch_id'=>$gen_mat_id);
			
			$qry_check = $this->db->get_where('GeneralMatch', $data);
			return $qry_check->row_array();
		}

		public function get_num_matches($user_id){
			$qr_check = $this->db->query("SELECT n.Users_ID, n.Num_Matches, n.Bye_Matches, n.Sport, n.Won, n.Lost, n.Win_Per, a.* FROM a2mscore a 
			LEFT JOIN Player_Matches_Count n ON (n.Users_ID = a.Users_ID AND n.Sport = a.SportsType_ID) WHERE a.Users_ID = $user_id");
			
			return $qr_check->result();
		}

		public function get_user_tournment_matches($user_id){
			$qr_check = $this->db->query(" SELECT * from Tournament_Matches where (Player1 = $user_id or Player2 = $user_id or Player1_Partner = $user_id or Player2_Partner = $user_id) AND (Winner != 0 AND Winner IS NOT NULL) ORDER BY Tourn_ID DESC, Match_Date DESC");

			return $qr_check->result();
	    }

		public function get_user_tournment_team_matches($user_id){
			$qr_check = $this->db->query(" SELECT * from Tournament_Lines where (Player1 = $user_id or Player2 = $user_id or Player1_Partner = $user_id or Player2_Partner = $user_id) AND (Winner != 0 AND Winner IS NOT NULL) ORDER BY Match_Date DESC");

			return $qr_check->result();
	    }

		public function get_tourn_name($tourn_id){
			$data = array('tournament_ID'=>$tourn_id);
			
			$qry_check = $this->db->get_where('tournament', $data);
			return $qry_check->row_array();
		}

		public function get_user_single_stats($user_id, $sp_intrests){
			if($sp_intrests != '()'){
				$qr_check = $this->db->query("SELECT t.SportsType,* FROM Tournament_Matches AS tm JOIN tournament AS t ON t.tournament_ID = tm.Tourn_ID WHERE t.SportsType IN {$sp_intrests} AND (tm.Player1 = {$user_id} OR tm.Player1_Partner = {$user_id} OR tm.Player2 = {$user_id} OR tm.Player2_Partner = {$user_id}) ORDER BY t.SportsType");
			}
			else{
				$qr_check = $this->db->query("SELECT t.SportsType,* FROM Tournament_Matches AS tm JOIN tournament AS t ON t.tournament_ID = tm.Tourn_ID WHERE tm.Player1 = {$user_id} OR tm.Player1_Partner = {$user_id} OR tm.Player2 = {$user_id} OR tm.Player2_Partner = {$user_id} ORDER BY t.SportsType");
			//echo $this->db->last_query();
			}
			//echo $this->db->last_query();

	
			return $qr_check->result();
		}


		public function get_user_line_stats($user_id, $sp_intrests){
		
			if($sp_intrests != '()'){
				$qr_check = $this->db->query("SELECT t.SportsType,* FROM Tournament_Lines AS tm JOIN tournament AS t ON t.tournament_ID = tm.Tourn_ID WHERE t.SportsType IN {$sp_intrests} AND (tm.Player1 = {$user_id} OR tm.Player1_Partner = {$user_id} OR tm.Player2 = {$user_id} OR tm.Player2_Partner = {$user_id}) ORDER BY t.SportsType");
			}
			else{
				$qr_check = $this->db->query("SELECT t.SportsType,* FROM Tournament_Lines AS tm JOIN tournament AS t ON t.tournament_ID = tm.Tourn_ID WHERE tm.Player1 = {$user_id} OR tm.Player1_Partner = {$user_id} OR tm.Player2 = {$user_id} OR tm.Player2_Partner = {$user_id} ORDER BY t.SportsType");
			}
			//echo $this->db->last_query();
			return $qr_check->result();
		}

		public function get_winper($sport, $user_id){
			$data	   = array('Sport' => $sport, 'Users_ID' => $user_id);
			$get_level = $this->db->get_where('Player_Matches_Count', $data);
			return $get_level->row_array();
		}
	 // model functions for search user details end code....

	public function basketball_matches($user_id){
		$qr_check = $this->db->query("select * from RegisterTournament where Team_Players like '%".'"'.$user_id.'"'."%' and Tournament_ID in (select tournament_ID from tournament where SportsType = 18)");
		return $qr_check->num_rows();
	}
}