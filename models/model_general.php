<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

	class Model_general extends CI_Model {
	
		public function __construct(){
			parent:: __construct();
			
		}

		public function get_data($table, $field, $tab_id){
			
			if($field != ""){
				$data = array($field => $tab_id);
				$this->db->where($data);
			}

			$get_data = $this->db->get($table);
			return $get_data->row_array();
		}
		
		public function insert_table_data($table, $data){
			if($table != '' and !empty($data)){
				$qry = $this->db->insert($table, $data);
				$ins_id = $this->db->insert_id();
				return $ins_id;
			}
			else{
				return false;
			}
		}

		public function get_onerow($table, $where_col, $where_val){
			$data	  = array($where_col => $where_val);
			$query = $this->db->get_where($table, $data);
			//echo $this->db->last_query();
			if($query->num_rows() > 0)
				return $query->row_array();
			else
				return 0;
		}

		public function get_sports(){
			$query = $this->db->get('SportsType');
			return $query->result();
		}

		public function get_aca_details($org){
			$data	  = array('Aca_ID' => $org);

			$query = $this->db->get_where('Academy_Info', $data);
			return $query->row_array();			
		}

		public function get_users_a2m(){
			$query = $this->db->get('A2MScore');
			return $query->result();
		}

		public function get_membership_dets($mem_code){
			$data	  = array('Membership_ID' => $mem_code);

			$query = $this->db->get_where('Membership_Types', $data);
			return $query->row_array();			
		}

		public function get_a2m_user($user_id,$sport=''){
			if($sport)
				$data	  = array('Users_ID' => $user_id, 'SportsType_ID' => $sport);
			else
				$data	  = array('Users_ID' => $user_id);

			$query = $this->db->get_where('A2MScore', $data);
			return $query->result();			
		}

		public function get_a2m_sport($sport){
			if($sport)
				$data	  = array('SportsType_ID' => $sport);

			$query = $this->db->get_where('A2MScore', $data);
			return $query->result();			
		}

		public function del_a2m_user($ref_id){
			if($ref_id){
			$query = $this->db->query("DELETE FROM A2MScore WHERE A2MScore_ID = {$ref_id}");
			return $query;
			}
		}

		public function get_users_mobile(){
			$query = $this->db->query("select * from Users where Mobilephone like '% %';");
			return $query->result();
		}

		public function upd_user_mobNum($user_id, $mob){
			$query = $this->db->query("UPDATE Users set Mobilephone = '{$mob}' WHERE Users_ID = {$user_id} ");
			//return $query->result();
		}

		public function upd_user_a2m_usatt($user_id, $rating){
			$query = $this->db->query("UPDATE A2MScore SET A2MScore={$rating},A2MScore_Doubles={$rating},A2MScore_Mixed={$rating} WHERE Users_ID = {$user_id} AND SportsType_ID = 2");
			echo $this->db->last_query();
			echo "<br>";
		}

		public function get_query_res($query){
			$query = $this->db->query($query);
			return $query->result();
		}

		public function update_a2m_backup($upd_id, $upd_a2m){
			$data = array('Backup_A2MScores' => $upd_a2m);

						 $this->db->where('A2MScore_ID', $upd_id);
			$res  = $this->db->update('A2MScore', $data);

			return $res;	
		}

		public function upd_tt_a2m($upd_id, $data){
						 $this->db->where('A2MScore_ID', $upd_id);
			$res  = $this->db->update('A2MScore', $data);

			return $res;	
		}

		public function get_user_sport_intrests(){
			$data = array('users_id'=>$this->session->userdata('users_id'));
			$query = $this->db->get_where('Sports_Interests',$data);
			//echo "test";
			//echo $this->db->last_query();
			return $query->result();
		}


		public function get_user($uid){
			$data = array('Users_ID' => $uid);
			$query = $this->db->get_where('Users', $data);
			return $query->row_array();
		}

		public function get_player($uid){
			$data = array('Users_ID'=>$uid);
			$query = $this->db->get_where('Users',$data);
			$p = $query->row_array();
			//echo $this->config->item('club_pr_url'); exit;
			if($_SERVER['HTTP_X_FORWARDED_HOST'] != ''){
				$url = $_SERVER['HTTP_X_REQUEST_SCHEME']."://".$_SERVER['HTTP_X_FORWARDED_HOST'].'/';
			}
			else{
				$url = base_url();
			}
				$name = "<a href='".$url."player/{$p['Users_ID']}'>".ucfirst($p['Firstname'])." ".ucfirst($p['Lastname'])."</a>";

			return $name;
		}

		public function get_player_partner($uid, $pid){
			$data = array('Users_ID'=>$uid);
			$query = $this->db->get_where('Users',$data);
			$p = $query->row_array();

			$data		= array('Users_ID'=>$pid);
			$query2	= $this->db->get_where('Users',$data);
			$pp			= $query2->row_array();

			if($_SERVER['HTTP_X_FORWARDED_HOST'] != ''){
				$url = $_SERVER['HTTP_X_REQUEST_SCHEME']."://".$_SERVER['HTTP_X_FORWARDED_HOST'].'/';
			}
			else{
				$url = base_url();
			}

			$name		= "<a href='".$url."player/{$p['Users_ID']}'>".ucfirst($p['Firstname'])." ".ucfirst($p['Lastname'])."</a>; "."<a href='".$url."player/{$pp['Users_ID']}'>".ucfirst($pp['Firstname'])." ".ucfirst($pp['Lastname'])."</a>";
			return $name;
		}

		public function get_users(){
			$query = $this->db->get('Users');
			return $query->result();
		}

		public function get_tshirt_sizes(){
			$data  = array('Status'=>'1');
			$query = $this->db->get_where('TShirtSize', $data);
			return $query->result();
		}

		public function get_coupon_code($gc, $ref_id){
			$query = $this->db->query("SELECT * FROM Coupon_Codes WHERE Coupon_Code = '$gc' AND Ref_ID = '$ref_id' AND Status = 1");
			return $query->row_array();
		}

		public function is_user_having_spint($user, $sport){
			$query = $this->db->query("SELECT * FROM Sports_Interests WHERE Sport_id = $sport AND users_id = $user");
			//echo $this->db->last_query(); exit;
			return $query->row_array();
		}

		public function get_bracket_firstmatch($bid){
			$query = $this->db->query("select * from Tournament_Matches WHERE BracketID = {$bid} and Match_DueDate IS NOT NULL");
			//echo $this->db->last_query(); exit;
			return $query->row_array();
		}

		public function get_teams(){
			$query = $this->db->get('Teams');
			return $query->result();
		}

		public function get_team($tid){
			$data = array('Team_ID'=>$tid);
			$query = $this->db->get_where('Teams', $data);
			return $query->row_array();
		}
		public function get_team_name($tid){
			$data = array('Team_ID'=>$tid);
			$query = $this->db->get_where('Teams', $data);
			$res = $query->row_array();
			return ucfirst($res[Team_name]);
		}

		public function is_team_player($tid){
			$query = $this->db->query("SELECT * FROM Teams WHERE Players LIKE '%{$this->logged_user}%' AND Team_ID = {$tid}");
			return $query->num_rows();
		}

		public function is_tourn_reg_player($tid){
			$query = $this->db->query("SELECT * FROM RegisterTournament WHERE Team_Players LIKE '%\"{$this->logged_user}\"%' AND Tournament_ID = {$tid}");
			//echo $this->db->last_query();
			return $query->num_rows();
		}

		public function get_pom(){
			$query = $this->db->get_where('Site_Info');
			return $query->row_array();
		}

		public function check_user_emailoption($uid){
			$qry_check = $this->db->query("SELECT * FROM Users WHERE Users_ID = '$uid' AND NotifySettings like '%2%' ");
			return $qry_check->row_array();
		}

		public function get_user_a2mscore($uid, $sport_id){
			$data = array('Users_ID'=>$uid, 'SportsType_ID'=>$sport_id);
			$query = $this->db->get_where('A2MScore',$data);
			return $query->row_array();
		}

		public function get_addr()
		{
			$data = array('Users_ID'=>$this->session->userdata('users_id'));
			$query = $this->db->get_where('Users',$data);
			return $query->row();
		}

		public function get_venue()
		{
			$uid = $this->session->userdata('users_id');
			$data = array('users_id'=>$uid);
			$query = $this->db->get_where('UserVenues',$data);
			return $query->result();
		}

		public function get_sport_title($sport_id)
		{
			$data = array('SportsType_ID'=>$sport_id);
			$get_sp_name = $this->db->get_where('SportsType',$data);
			return $get_sp_name->row_array();
		}

		public function get_tour_images()
		{
			$query = $this->db->query("select MAX(Tourn_image_id) as mt,Tournament_id from Tournament_Images GROUP BY Tournament_id ORDER BY mt DESC");
			return $query->result();
		}

		public function get_images($id)
		{
			$data = array('Tourn_image_id'=>$id);
			$query = $this->db->get_where('Tournament_Images',$data);
			return $query->row_array();
		}

		public function get_tour_sport($tid)
		{
			$data = array('tournament_ID' => $tid);
			$this->db->select('TournamentImage, SportsType');
			$query = $this->db->get_where('tournament',$data);
			return $query->row_array();
		}

		public function get_tourn_comments($tourn_id){
			$data = array('Tourn_Id' => $tourn_id);
			$this->db->select('*');
			$this->db->order_by("Comment_On",'desc');
			$get_ev_usrs = $this->db->get_where('Tournament_Comments',$data);
			return $get_ev_usrs->result();
		}

		public function get_home_location($loc)
		{
			$data = array('hcl_id' => $loc);
			$query = $this->db->get_where('Home_Court_Locations', $data);
			return $query->row_array();
		}

		public function get_user_home_location($tourn_id, $user_id)
		{
			$data = array('Tournament_ID' => $tourn_id, 'Users_ID' => $user_id);
			$query = $this->db->get_where('RegisterTournament', $data);
			return $query->row_array();
		}

		public function get_user_agegroup()
		{
			$data = array('Users_ID' => $this->logged_user);
			$query = $this->db->get_where('Users', $data);
			return $query->row_array();
		}

		public function get_user_created_teams()
		{
			$data = array('Created_by' => $this->logged_user);
			$query = $this->db->get_where('Teams', $data);
			return $query->result();
		}

		public function check_is_player_paid($player, $tourn_id, $team_id)		
		{		
			$data = array('Users_ID'	=> $player, 		
						'mtype'		=> 'tournament', 		
						'mtype_ref' => $tourn_id,		
						'Team_id'	=> $team_id);		
			$query = $this->db->get_where('Paytransactions', $data);		
			return $query->row_array();		
		}

		public function get_user_created_sport_teams($sport)
		{
			$data = array('Captain' => $this->logged_user, 'sport' => $sport);
			$query = $this->db->get_where('Teams', $data);
			return $query->result();
		}

		public function get_user_existed_teams($tourn_id, $sport)
		{
			$query = $this->db->query("SELECT * FROM Teams WHERE Players LIKE '%\"{$this->logged_user}\"%' AND Captain != $this->logged_user AND Sport = {$sport} AND Team_ID NOT IN (SELECT Team_id FROM RegisterTournament WHERE Tournament_id = '$tourn_id')");

			return $query->result();
		}

		public function get_team_track_event($tourn_title)
		{
			$query = $this->db->query("SELECT * FROM Events WHERE Ev_Created_by = {$this->logged_user} AND Ev_Desc LIKE '%{$tourn_title}%'");

			return $query->row_array();
		}

		public function get_tour_info($tourn_id)
		{				   
			$data = array('tournament_ID'=>$tourn_id);
			$query = $this->db->get_where('tournament',$data);
			return $query->row_array();
		}

		public function get_team_participant_player_count($tourn_id)
		{				   
			$query = $this->db->query("SELECT * FROM RegisterTournament WHERE Tournament_id = '$tourn_id'");
			$res = $query->result();
			$total = 0;
			foreach($res as $i => $data){
				$team_p = json_decode($data->Team_Players);
				$total += count($team_p);
			}

			return $total;
		}

		public function get_tournImages_bySportsType($sportsType, $limit='')
		{
			$cond = "";
			if($limit)
			$cond = " OFFSET 0 ROWS FETCH NEXT {$limit} ROWS ONLY";

			$query = $this->db->query("SELECT * FROM Tournament_Images WHERE tournament_ID IN (SELECT t.tournament_ID FROM tournament as t INNER JOIN Sports_News as sn ON t.SportsType=sn.SportsType_id WHERE t.SportsType={$sportsType}) ORDER BY tournament_ID DESC{$cond}");
			//return $this->db->last_query();
			//echo $this->db->last_query(); exit;
			return $query->result();
		}

		public function get_matches_cnt($user_id, $sport_id){
			    $data = array('Users_ID'=>$user_id,'Sport' =>$sport_id);
				$num = $this->db->get_where('Player_Matches_Count', $data);
				//return $this->db->last_query();
				$c =  $num->row_array();
				return $c;
		}

		public function update_a2m_teamscore($team){
			$score	 = 100;
			$team_id = $team->Team_ID;
			$sport   = $team->Sport;

			$query = $this->db->query("SELECT * FROM A2MTeamScore WHERE Team_ID = '$team_id'");
			$res = $query->row_array();
	
			if(!$res){
				$data = array(
				'Team_ID'		=> $team_id,
				'Sport'			=> $sport,
				'A2MTeamScore'  => $score);

				$res  = $this->db->insert('A2MTeamScore', $data);
				echo $team_id. "<br>";
			}
		}

		public function ins_users_json($val){
			$res = 0;
			$upd_on = date('Y-m-d H:i:s');
			if($val){
				$res = $this->db->query("UPDATE Users_JSON SET json_val = '{$val}', updated_on = '{$upd_on}' WHERE tab_id = 1");
			}
			//echo $this->db->last_query(); exit;
			return $res;
		}

		public function get_all_users(){
			$qr_check = $this->db->query("SELECT * FROM users");
			return $qr_check->result();
		}

		public function get_users_json(){
			$qr_check = $this->db->query("SELECT * FROM Users_JSON");
			$res = $qr_check->row_array();
			return $res['json_val'];
		}

		public function a2mscore_doubles_update(){

			$query = $this->db->query("SELECT * FROM A2MScore");
			$res = $query->result();
			$i = 0;
			foreach($res as $a2m){
				$upd_query = $this->db->query("UPDATE A2MScore SET A2MScore_Doubles = {$a2m->A2MScore}, A2MScore_Mixed = {$a2m->A2MScore} WHERE A2MScore_ID = {$a2m->A2MScore_ID}");
				$i++;
			}
			echo $i;
			
		}

		public function get_sponsors(){
			$query = $this->db->query("SELECT * FROM tournament WHERE Sponsors IS NOT NULL");
			return $query->result();
		}
	
		public function get_missing_geo_users(){
			$query = $this->db->query("select * from Users where (Zipcode is not null and Zipcode != '') and (Longitude is null or Longitude = '0')");
			return $query->result();
		}
	
		public function update_user_geo($user, $geo){
			$query = $this->db->query("UPDATE Users SET Latitude = '".$geo['latitude']."', Longitude = '".$geo['longitude']."' WHERE Users_ID = '".$user."'");

			if($query)
				return true;
			else
				return false;
		}
	
		/*public function get_academy_10(){
			$query = $this->db->query("select * from Academy where Org_ID = 10");
			return $query->result_array();
		}*/
		
		public function get_academy(){
			$query = $this->db->query("select * from Academy where Org_name not in (select Aca_name from Academy_Info)");
			return $query->result_array();
		}
		
		/*public function get_academy_temp(){
			$query = $this->db->query("select * from Academy where Org_name in (select Aca_name from Academy_Info)");
			return $query->result_array();
		}*/
		
		public function get_academy_users($org_id){
			$query = $this->db->query("select * from Academy_users where Org_id = {$org_id}");
			return $query->result_array();
		}
		
		public function get_tournaments(){
			$query = $this->db->query("select * from tournament");
			return $query->result();
		}
		
		public function get_tourn_reg_users($tid){
			$query = $this->db->query("select * from RegisterTournament where Tournament_ID={$tid}");
			return $query->result();
		}
		
		public function ins_academy_info($data){
			$query = $this->db->insert('Academy_Info', $data);
			return $this->db->insert_id();
		}

		public function migrate_aca_users($data){
			$query = $this->db->insert('User_memberships', $data);
			return $query;
		}

		public function update_menu($new_id, $old_id){
			$query = $this->db->query("UPDATE Academy_Menu_Settings SET Academy_Id = {$new_id} WHERE Academy_Id = {$old_id}");
			return $query;
		}

		public function get_club_menu($org_id){
			$query = $this->db->query("SELECT * FROM Academy_Menu_Settings WHERE Academy_Id = {$org_id}");
			//echo $this->db->last_query(); echo "<br>";

			if($query)
				return $query->row_array();
			else
				return 0;
		}

		public function correction_in_gpa_a2m(){
			$gpa_users = $this->db->query("SELECT * FROM GPA_Ratings");
			$gpa_users_list = $gpa_users->result();
			$sno = 1;
			foreach($gpa_users_list as $gpa_usr){
					$email = $gpa_usr->Email;

					if($email){
						$get_a2m_user = $this->db->query("SELECT * FROM Users WHERE EmailID = '".$email."'");
						$a2m_user = $get_a2m_user->row_array();

						$get_user_a2m = $this->db->query("select * from A2MScore where Users_ID = '".$a2m_user['Users_ID']."'");
						$a2m = $get_user_a2m->row_array();
						$st = '';

						//$upd = $this->db->query("UPDATE A2MScore SET A2MScore=".$a2m['A2MScore_Doubles'].",A2MScore_Doubles=".$a2m['A2MScore']."  WHERE A2MScore_ID = '".$a2m['A2MScore_ID']."'");

						//if($upd)
						//	$st = "Done";
						//else
						//	$st = "Fail";

						echo $sno." - ".$email. " ".$a2m_user['Users_ID']. " ".$a2m['A2MScore']. " ". $a2m['A2MScore_Doubles']." ------ {$st}<br>";
						
						

						$sno++;
					}
					else{
						echo "No Account found! <br>";
					}
	
			}

		}

		public function upd_tbl(){

$upd_arr = array('22309','
22310','
22311','
22312','
22313','
22314','
22315','
22316','
22317','
22318','
22319','
22320','
22354','
22355','
22332','
22333','
22334','
22335','
22356','
22357','
22358','
22359','
22336','
22337','
22338','
22360','
22388','
22396','
22391','
22392','
22393');

foreach($upd_arr as $ar){
		$get_qry = $this->db->query("SELECT * FROM Tournament_Matches WHERE Tourn_match_id = $ar");
		$data_arr = $get_qry->row_array();

		$prev_dt = date('Y-m-d', strtotime($data_arr['Match_DueDate']));
		$prev_tm = date('H:i', strtotime($data_arr['Match_DueDate']));
		$new_dt  = date('Y-m-d H:i', strtotime('2021-07-09 '.$prev_tm));
		echo $new_dt." = ". $prev_dt." ".$prev_tm."<br>";
		$get_qry = $this->db->query("UPDATE Tournament_Matches SET Match_DueDate = '{$new_dt}' WHERE Tourn_match_id = $ar");
		}
		}

		public function get_a2msocre($sport, $user_id){
			$data = array('SportsType_ID'=>$sport , 'Users_ID'=>$user_id);
			$get_level = $this->db->get_where('A2MScore',$data);
			return $get_level->row_array();
		}

		public function search_autocomplete($data){			
			$key = $data['key'];
			$gender = $data['gender'];
			$tid = $data['tid'];
			if($tid){
				   $qr_check = $this->db->query("SELECT * FROM Users WHERE (Firstname LIKE '%$key%' OR Lastname LIKE '%$key%') AND Users_ID IN (SELECT Users_ID FROM RegisterTournament WHERE Tournament_ID = {$tid}) ");
			}
			else{
				if($gender === '1' || $gender === '0'){
				   $qr_check = $this->db->query("SELECT * FROM Users WHERE Gender = $gender AND (Firstname  LIKE '%$key%' OR  Lastname LIKE '%$key%')");
				}
				else{
				   $qr_check = $this->db->query("SELECT * FROM Users WHERE Firstname LIKE '%$key%' OR Lastname LIKE '%$key%'");
				}
			}
			
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


}	