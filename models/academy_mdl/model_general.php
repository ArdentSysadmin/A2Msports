<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

	class Model_general extends CI_Model {
	
		public function __construct()
		{
			parent:: __construct();
			
		}

		public function check_is_member($club, $user){
			$data  = array('Club_id' => $club, 'Users_id' => $user);
			$query = $this->db->get_where('User_memberships', $data);
			$res   = $query->row_array();

			return $res;
		}

		public function check_is_clubCoach($club, $user){
			$data  = array('Is_coach' => 1,'Users_ID' => $user, 'coach_academy' => $club);
			$query = $this->db->get_where('Users', $data);
			$res   = $query->row_array();

			return $res;
		}

		public function get_orgid($uid)
		{
			$data  = array('Aca_URL_ShortCode'=>$uid);
			$query = $this->db->get_where('Academy_Info',$data);
			$res   = $query->row_array();

			return $res['Aca_ID'];
		}
		
		public function get_page(){
			
				$get_data = $this->db->get('Academy_Custom_Pages');
			return $get_data->row_array();
		}

		public function put_page($cont){
				$data = array('Page_Content' => $cont);
				$data2 = array('Aca_ID' => 1111);
									$this->db->where($data2);
				$get_data = $this->db->update('Academy_Custom_Pages', $data);
				//echo $this->db->last_query();
			//return $get_data->row_array();
		}
		public function get_user_agegroup()
		{
			$data = array('Users_ID' => $this->logged_user);
			$query = $this->db->get_where('Users', $data);
			return $query->row_array();
		}
		public function get_org_admin($uid)
		{
			$data  = array('Aca_URL_ShortCode' => $uid);
			$query = $this->db->get_where('Academy_Info', $data);
			$res   = $query->row_array();

			return $res['Aca_User_id'];
		}

		public function get_data($table, $field, $tab_id)
		{
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
			//echo $this->db->last_query();exit;

			if($query->num_rows() > 0)
				return $query->row_array();
			else
				return 0;
		}

		public function check_row_exists($table, $where_cond){
			$query = $this->db->get_where($table, $where_cond);

			if($query->num_rows() > 0)
				return $query->row_array();
			else
				return 0;
		}

		public function get_results($table, $where_cond){
			$query = $this->db->get_where($table, $where_cond);
			//echo $this->db->last_query();
			if($query->num_rows() > 0)
				return $query->result();
			else
				return 0;
		}

		public function get_sports(){
			$query = $this->db->get('SportsType');
			return $query->result();
		}

		public function get_user_sport_intrests(){
			$data = array('users_id' => $this->session->userdata('users_id'));
			$query = $this->db->get_where('Sports_Interests',$data);
			return $query->result();
		}

		public function get_user($uid)
		{
			$data = array('Users_ID'=>$uid);
			$query = $this->db->get_where('Users',$data);
			return $query->row_array();
		}

		public function get_team($tid){		
			$data = array('Team_ID'=>$tid);		
			$query = $this->db->get_where('Teams', $data);		
			return $query->row_array();		
		}

		public function is_team_player($tid){		
			$query = $this->db->query("SELECT * FROM Teams WHERE Players LIKE '%{$this->logged_user}%' AND Team_ID = {$tid}");		
			return $query->num_rows();		
		}

		public function is_tourn_reg_player($tid){		
			$query = $this->db->query("SELECT * FROM RegisterTournament WHERE Team_Players LIKE '%{$this->logged_user}%' AND Tournament_ID = {$tid}");		
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

		public function get_gpa_ratings($email){
			$data = array('Email'=>$email);
			$query = $this->db->get_where('GPA_Ratings', $data);
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

		public function get_aca_tour_images()
		{
			$query = $this->db->query("select MAX(Tourn_image_id) as mt,Tournament_id from Tournament_Images where Tournament_id IN (select tournament_ID from tournament where Usersid IN (select Users_ID from Academy group by Users_ID) group by tournament_ID) GROUP BY Tournament_id ORDER BY mt DESC");
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

		public function get_home_location($loc)
		{
			$data = array('hcl_id' => $loc);
			$query = $this->db->get_where('Home_Court_Locations', $data);
			return $query->row_array();
		}

		public function get_location_name($loc_id){
			$data = array('Loc_id' => $loc_id);
			$get_sp_name = $this->db->get_where('Events_Locations',$data);
			return $get_sp_name->row_array();
		}

		public function get_user_created_teams()
		{
			$data = array('Created_by' => $this->logged_user);	
			$query = $this->db->get_where('Teams', $data);
			return $query->result();
		}

		public function get_user_created_sport_teams($sport)
		{
			$data = array('Created_by' => $this->logged_user, 'sport' => $sport);
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

		public function get_user_existed_teams($tourn_id)		
		{
			$query = $this->db->query("SELECT * FROM Teams where Players LIKE '%\"{$this->logged_user}\"%' AND Team_ID IN (SELECT Team_id FROM RegisterTournament WHERE Tournament_id = '$tourn_id')");
			return $query->result();
		}

		public function get_tour_info($tourn_id)
		{
			$data = array('tournament_ID'=>$tourn_id);
			$query = $this->db->get_where('tournament',$data);
			return $query->row_array();
		}

		public function get_today_rating_elig_leagues($rating_elig_date){
			$get_query = $this->db->query("SELECT * FROM tournament WHERE EligibilityDate = '{$rating_elig_date} 12:00:00.000'");
			//echo $this->db->last_query();
			return $get_query->result_array();
		}

		public function get_league_registrations($tourn_id){
			$get_query = $this->db->query("SELECT * FROM RegisterTournament WHERE Tournament_ID = {$tourn_id}");
			return $get_query->result_array();
		}

		public function get_level_name($sport_id, $level){
			if($sport_id==''){
               $data = array('SportsLevel_ID' => (int)$level);
			}
			else{
			   $data = array('SportsType_ID' => $sport_id, 'SportsLevel_ID' => (int)$level);
			}
			
			$get_name = $this->db->get_where('SportsLevels',$data);
			return $get_name->row_array();
		}

		public function get_player_usatt_rating($user_id){
			$query = $this->db->query("SELECT * FROM User_memberships AS u JOIN USATTMembership AS ut ON u.Membership_ID = ut.Member_ID WHERE Users_id = {$user_id}");
			//echo $this->db->last_query(); echo "<br>";
			return $query->row_array();
		}

		public function update_eligible_rating($tourn_id, $user_id, $elig_rating){
			$query = $this->db->query("UPDATE RegisterTournament SET Rating = '{$elig_rating}' WHERE Tournament_ID = '{$tourn_id}' AND Users_ID = '{$user_id}'");
			//echo $this->db->last_query(); echo "<br>";
			return $query;
		}

		public function upd_membership($data , $data2)
		{
			$this->db->where($data);
			$result = $this->db->update('User_memberships', $data2);
			//echo $this->db->last_query(); exit;
			return $result;
		}

		public function upd_user_membership($club_id, $user_id, $mem_code=''){
			$cur_date = date('Y-m-d');
				$add = '';
			if($mem_code)
				$add = ", Membership_Code = '{$mem_code}'";
			$query = $this->db->query("UPDATE User_memberships SET Member_Status = 1, StartDate = '{$cur_date}', EndDate = NULL{$add} WHERE Users_id = '{$user_id}' AND Club_id = '{$club_id}'");
			//echo $this->db->last_query(); exit;
			return $query;
		}

		public function user_activation($user_id){
			$query = $this->db->query("UPDATE Users SET IsUserActivation = 1 WHERE Users_ID = '{$user_id}'");
			//echo $this->db->last_query(); echo "<br>";
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

		public function get_club_memberships($org_id){
			$data = array('Club_ID' => $org_id);
			$get_sp_num = $this->db->get_where('Membership_Types', $data);
			return $get_sp_num->result();
		}

		public function get_membership_dets($mem_code){
			$data	  = array('Membership_ID' => $mem_code);

			$query = $this->db->get_where('Membership_Types', $data);
			return $query->row_array();			
		}

		public function get_user_membership($org_id, $user_id){
			$data = array('Users_id' => $user_id, 'Club_id' => $org_id);

			$query = $this->db->get_where('User_memberships', $data);
			//echo $this->db->last_query();
			return $query->row_array();
		}
}