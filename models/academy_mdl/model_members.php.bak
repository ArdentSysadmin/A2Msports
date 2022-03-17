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
			if($name != "")
			{
				$name_cond = "(Firstname like '%{$name}%' OR Lastname like '%{$name}%')";
			}else
			{
				$name_cond = "";
			}

			$Sport_cond = "";
			if($sport != "")
			{
				
				if($name !=""){
				$Sport_cond = "AND Users_ID IN (select users_id from Sports_Interests where Sport_id ={$sport})"; 
				}
				else
				{
				$Sport_cond = "Users_ID IN (select users_id from Sports_Interests where Sport_id ={$sport})";
				}
			}else
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
				$org_cond = " AND Users_ID IN (SELECT Users_id FROM user_memberships WHERE Org_ID = $org_id)";
				}else
				{
					$org_cond = "Users_ID IN (SELECT Users_id FROM user_memberships WHERE Org_ID = $org_id)";
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

			$name_cond = "";
			if($name != "")
			{
				$name_cond = "(Firstname like '%{$name}%' OR Lastname like '%{$name}%')";
			}
			else
			{
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

			$title = $this->input->post('search_title');
			$creator = intval($this->input->post('created_users_id'));
			$Sport = $this->input->post('Sport');
			$range = $this->input->post('range');
			
			
		($data['lat']=="") ? $lat = 0 : $lat = $data['lat'];
		($data['long']=="") ? $long = 0 : $long = $data['long'];


			if($title != "")
			{
				$title_cond = "Match_Title like '%{$title}%' ";
			}else
			{
				$title_cond = "";
			}
		
			if($creator != "")
			{
				if($title !=""){
				$creator_cond = "AND users_id = {$creator}";
				}
				else
				{
				$creator_cond = "users_id = {$creator}";
				}
			}else
			{
				$creator_cond = "";
			}

			if($Sport != "")
			{
				
				if($title !="" OR $creator != ""){
				$Sport_cond = "AND Sports = {$Sport}";
				}
				else
				{
				$Sport_cond = "Sports = {$Sport}";
				}
			}else
			{
				$Sport_cond = "";
			}

			if($range != "")
			{
				if($title !="" OR $creator != "" OR $Sport != ""){
				$range_cond = "AND ACOS( SIN( RADIANS( Latitude )) * SIN( RADIANS( $lat ) ) + COS( RADIANS( Latitude ) ) * COS( RADIANS( $lat )) *  COS( RADIANS( Longitude ) - RADIANS( $long)) ) * 3964.3 < {$range}";
				}
				else
				{
				$range_cond = "ACOS( SIN( RADIANS( Latitude )) * SIN( RADIANS( $lat ) ) + COS( RADIANS( Latitude ) ) * COS( RADIANS( $lat )) *  COS( RADIANS( Longitude ) - RADIANS( $long)) ) * 3964.3 < {$range}";
				}

			}else
			{
				if($title !="" OR $creator != "" OR $Sport != ""){
				$range_cond = "AND ACOS( SIN( RADIANS( Latitude )) * SIN( RADIANS( $lat ) ) + COS( RADIANS( Latitude ) ) * COS( RADIANS( $lat )) *  COS( RADIANS( Longitude ) - RADIANS( $long)) ) * 3964.3 < 500";
				}
				else
				{
				$range_cond = "ACOS( SIN( RADIANS( Latitude )) * SIN( RADIANS( $lat ) ) + COS( RADIANS( Latitude ) ) * COS( RADIANS( $lat )) *  COS( RADIANS( Longitude ) - RADIANS( $long)) ) * 3964.3 < 500";
				}

			}

			
			$qry_check = $this->db->query(" SELECT * , ACOS( SIN( RADIANS( Latitude ) ) * SIN( RADIANS( $lat ) ) + COS( RADIANS( Latitude ) )
* COS( RADIANS( $lat )) * COS( RADIANS( Longitude ) - RADIANS( $long )) ) * 3964.3 AS distance FROM GeneralMatch WHERE  {$title_cond}  {$creator_cond}  {$Sport_cond} {$range_cond}"
			);
	
			return $qry_check->result();
		}
		
		public function search_matches1($data)
		{

			$title = $this->input->post('search_title');
			$creator = intval($this->input->post('created_users_id'));
			$range = $this->input->post('range');
			$Sport = $this->input->post('Sport');
			
		($data['lat']=="") ? $lat = 0 : $lat = $data['lat'];
		($data['long']=="") ? $long = 0 : $long = $data['long'];

			if($title != "")
			{
				$title_cond = "Play_Title like '%{$title}%' AND ";
			}else
			{
				$title_cond = "";
			}
		
			
			if($creator != "")
			{
				if($title !=""){
				$creator_cond = "Opponent = {$creator} AND ";
				}
				else
				{
				$creator_cond = "Opponent = {$creator} AND ";
				}
			}else
			{
				$creator_cond = "";
			}
			
			if($Sport != "")
			{
				
				if($title != "" OR $creator != ""){
				$Sport_cond = " Sports = {$Sport} AND ";
				}
				else
				{
				$Sport_cond = "Sports = {$Sport} AND ";
				}
			}
			else
			{
				$Sport_cond = "";
			}

			if($range != "")
			{

				if($title !="" OR $creator != "" OR $Sport != ""){
				$range_cond = "AND ACOS( SIN( RADIANS( Latitude )) * SIN( RADIANS( $lat ) ) + COS( RADIANS( Latitude ) ) * COS( RADIANS( $lat )) *  COS( RADIANS( Longitude ) - RADIANS( $long)) ) * 3964.3 < {$range}";
				}else
				{
				$range_cond = " ACOS( SIN( RADIANS( Latitude )) * SIN( RADIANS( $lat ) ) + COS( RADIANS( Latitude ) ) * COS( RADIANS( $lat )) *  COS( RADIANS( Longitude ) - RADIANS( $long)) ) * 3964.3 < {$range}";
				}
				
			}else
			{
				if($title !="" AND $creator != "" AND  $Sport != ""){
				$range_cond = " AND ACOS( SIN( RADIANS( Latitude )) * SIN( RADIANS( $lat ) ) + COS( RADIANS( Latitude ) ) * COS( RADIANS( $lat )) *  COS( RADIANS( Longitude ) - RADIANS( $long)) ) * 3964.3 < 500";
				}
				else
				{
				$range_cond = " ACOS( SIN( RADIANS( Latitude )) * SIN( RADIANS( $lat ) ) + COS( RADIANS( Latitude ) ) * COS( RADIANS( $lat )) *  COS( RADIANS( Longitude ) - RADIANS( $long)) ) * 3964.3 < 500";
				}
				
			}

			
			$qry_check = $this->db->query(" SELECT * FROM IndividualPlay WHERE {$title_cond} {$creator_cond}  GeneralMatch_ID IN ( SELECT GeneralMatch_id FROM GeneralMatch WHERE {$creator_cond}{$Sport_cond}{$range_cond} )");

	
			return $qry_check->result();
		}



		public function get_sport_number($gen_match_id){
			
			$data = array('GeneralMatch_id'=>$gen_match_id);
			$get_sp_num = $this->db->get_where('GeneralMatch',$data);
			return $get_sp_num->row_array();
		}




		public function search_tournaments($data)
		{

			$city = $this->input->post('search_city');
			$state = $this->input->post('search_state');
			$Sport = $this->input->post('Sport');
			$range = $this->input->post('range');

			//print_r($_POST);
			//exit;
			
		($data['lat']=="") ? $lat = 0 : $lat = $data['lat'];
		($data['long']=="") ? $long = 0 : $long = $data['long'];

			if($Sport != "")
			{
				$Sport_cond = "SportsType = {$Sport}";
			}else
			{
				$Sport_cond = "";
			}
			
			if($city != "")
			{
				if($Sport != ""){
				$city_cond = "AND TournamentCity like '%{$city}%'";
				}
				else{
				$city_cond = "TournamentCity like '%{$city}%'";
				}
			}
			else
			{
				$city_cond = "";
			}

			if($state != "")
			{
				if($Sport != "" OR $city != ""){
				$state_cond = "AND TournamentState like '%{$state}%'";
				}
				else
				{
				$state_cond = "TournamentState like '%{$state}%'";
				}
			}else
			{
				$state_cond = "";
			}
			

			if($range != "")
			{
				if($Sport != "" OR $city != "" OR $state != "") {
				$range_cond = "AND ACOS( SIN( RADIANS( Latitude )) * SIN( RADIANS( $lat ) ) + COS( RADIANS( Latitude ) ) * COS( RADIANS( $lat )) *  COS( RADIANS( Longitude ) - RADIANS( $long)) ) * 3964.3 < {$range}";
				}
				else{
				$range_cond = "ACOS( SIN( RADIANS( Latitude )) * SIN( RADIANS( $lat ) ) + COS( RADIANS( Latitude ) ) * COS( RADIANS( $lat )) *  COS( RADIANS( Longitude ) - RADIANS( $long)) ) * 3964.3 < {$range}";
				}
			}else
			{
				if($Sport != "" OR $city != "" OR $state != "") {
				$range_cond = "AND ACOS( SIN( RADIANS( Latitude )) * SIN( RADIANS( $lat ) ) + COS( RADIANS( Latitude ) ) * COS( RADIANS( $lat )) *  COS( RADIANS( Longitude ) - RADIANS( $long)) ) * 3964.3 < 500";
				}
				else
				{
				$range_cond = "ACOS( SIN( RADIANS( Latitude )) * SIN( RADIANS( $lat ) ) + COS( RADIANS( Latitude ) ) * COS( RADIANS( $lat )) *  COS( RADIANS( Longitude ) - RADIANS( $long)) ) * 3964.3 < 500";
				}

			}
		
			$qry_check = $this->db->query("SELECT *, ACOS( SIN( RADIANS( Latitude ) ) * SIN( RADIANS( $lat ) ) + COS( RADIANS( Latitude ) )
* COS( RADIANS( $lat )) * COS( RADIANS( Longitude ) - RADIANS( $long )) ) * 3964.3 AS distance FROM tournament WHERE  {$Sport_cond} {$city_cond} {$state_cond}{$range_cond} ");

			
			return $qry_check->result();
		}
		
		public function get_intrests()
		{
			$query = $this->db->get('SportsType');
			return $query->result();
		}

		public function get_a2msocre($sport,$user_id)
		{
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

		public function search_autocomplete($data)
		{
			//$sql = "SELECT Firstname ,Lastname FROM users WHERE player_name LIKE '%$my_data%' ORDER BY player_name";
			
			$key = $data['key'];
			
			$this->db->select('*');
			$this->db->from('users');
			$this->db->like('Firstname', $key); 
			$this->db->or_like('Lastname', $key);
			
			$query = $this->db->get();
			return $query->result();
			//$this->db->like('title', 'match', 'both'); 
		}
		
		public function search_academy_users($data)
		{
			//$sql = "SELECT Firstname ,Lastname FROM users WHERE player_name LIKE '%$my_data%' ORDER BY player_name";
			
			$key = $data['key'];
			$academy = $data['academy'];

			$qr_check = $this->db->query("SELECT * from users WHERE (Firstname LIKE '%$key%' OR Lastname LIKE '%$key%') AND Users_ID IN (SELECT Users_id FROM user_memberships WHERE Org_id = $academy)");

			return $qr_check->result();
		}
		
		public function update_match_det($match_id)
		{
			$message = $this->input->post('mes');
			$data = array('Message' => $message);
			$this->db->where('GeneralMatch_id', $match_id);
			$result = $this->db->update('GeneralMatch', $data); 
			return $result;
		}

       /// model functions for search user details start code....
		public function get_user_id($user_id)
		{
			$data = array('Users_ID'=>$user_id);
			
			$qry_check = $this->db->get_where('users', $data);
			return $qry_check->row_array();
		}


		public function get_user_sport_intrests($user_id)
		{

			$data = array('users_id'=>$user_id);
			$qry_check = $this->db->get_where('Sports_Interests', $data);
			return $qry_check->result();
		}

		public function get_user_matches($user_id)
		{

			$qr_check = $this->db->query("SELECT * from IndividualPlay where (Opponent = $user_id OR GeneralMatch_ID IN (SELECT GeneralMatch_id FROM GeneralMatch WHERE users_id = $user_id)) AND  Winner IS NOT NULL ORDER BY Play_Date DESC");

			return $qr_check->result();
		}

		public function get_gen_mat_det($gen_mat_id)
		{
			$data = array('GeneralMatch_id'=>$gen_mat_id);
			
			$qry_check = $this->db->get_where('GeneralMatch', $data);
			return $qry_check->row_array();
		}

		public function get_num_matches($user_id)
		{

			$qr_check = $this->db->query("SELECT n.Users_ID,n.Num_Matches,n.Sport,n.Won, n.Lost,n.Win_Per,a.* from a2mscore a 
			left join Player_Matches_Count n on (n.Users_ID = a.Users_ID and n.Sport = a.SportsType_ID) where a.Users_ID = $user_id");
			
			return $qr_check->result();
		}

		public function get_user_tournment_matches($user_id){
			$qr_check = $this->db->query(" SELECT * from Tournament_Matches where (Player1 = $user_id or Player2 = $user_id or Player1_Partner = $user_id or Player2_Partner = $user_id) AND (Winner != 0 AND Winner IS NOT NULL) ORDER BY Match_Date DESC");

			return $qr_check->result();
	    }

		public function get_user_tournment_team_matches($user_id){
			//echo "test"; exit;
			$qr_check = $this->db->query(" SELECT * from Tournament_Lines where (Player1 = $user_id or Player2 = $user_id or Player1_Partner = $user_id or Player2_Partner = $user_id) AND (Winner != 0 AND Winner IS NOT NULL) ORDER BY Match_Date DESC");

			return $qr_check->result();
	    }

		public function get_tourn_name($tourn_id)
		{
			$data = array('tournament_ID'=>$tourn_id);
			
			$qry_check = $this->db->get_where('tournament', $data);
			return $qry_check->row_array();
		}

		public function get_membership_details($user_id)
		{
			$qr_check = $this->db->query("SELECT * FROM User_memberships WHERE Users_id = $user_id");
			return $qr_check->result();
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

		public function get_club($org_id)
		{
			$data = array('Aca_ID'=>$org_id);
			
			$qry_check = $this->db->get_where('Academy_Info', $data);
			return $qry_check->row_array();
		}
	 /// model functions for search user details end code....
}