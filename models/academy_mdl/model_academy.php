<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

	class model_academy extends CI_Model {
	
		public function __construct()
		{
			parent:: __construct();

		}

		public function get_list()
		{
			$limit = 3;
			$user_id = $this->session->userdata('users_id');
			$this->db->select('*');
			$this->db->from('Sports_News');
			$this->db->where('Org_Id !=', 0);
			$this->db->order_by("Modified_on", "desc");
			$this->db->limit($limit);
			$query = $this->db->get();
			return $query->result();
		}

		public function get_academy_list()
		{
			$this->db->select('*');
			$this->db->from('Academy_Info');
			$this->db->where('Aca_URL_ShortCode is NOT NULL', NULL, FALSE);
			$this->db->where('Aca_URL_ShortCode !=', "");
			$this->db->order_by('Aca_name','ASC');
			$query = $this->db->get();
			return $query->result();
		}

		public function get_menu_list()
		{
			$this->db->select('*');
			$this->db->from('Academy_Menu_List');
			$query = $this->db->get();
			return $query->result();
		}

		public function get_mem_codes($org_id)
		{
			$this->db->select('*');
			$this->db->from('Membership_Types');
			$this->db->where('Club_ID =', $org_id);
			$this->db->where('Status =', 1);
			$query = $this->db->get();
			return $query->result();
		}

		public function get_act_menu_list($org_id)
		{
			$this->db->select('*');
			$this->db->from('Academy_Menu_Settings');
			$this->db->where('Academy_Id =', $org_id);
			$query = $this->db->get();
			return $query->result();
		}

		public function get_menu_all_items()
		{
			$query = $this->db->query("SELECT * FROM Academy_Menu_List WHERE is_Admin_Menu = 0 AND Status = 1");
			return $query->result();
		}

		public function get_menu_show_items($org_id)
		{
			$this->db->select('*');
			$this->db->from('Academy_Menu_Settings');
			$this->db->where('Academy_Id =', $org_id);
			$query = $this->db->get();
			return $query->row_array();
		}

		public function get_org_creator($org_id)
		{
		/*	$data  = array('Menu_ID' => $id);
			$query = $this->db->get_where('Academy_Menu_List', $data);
			return $query->row_array();*/
		}

		public function get_coaches_list($org_id)
		{
			$org_cond = "AND Users_ID IN (SELECT Users_id FROM User_memberships WHERE Club_ID = $org_id)";
			$query	  = $this->db->query("SELECT * FROM users WHERE Is_coach = 1 AND coach_academy = $org_id {$org_cond}");
			return $query->result();
		}

		public function get_top_members_list($org_id)
		{
				$query = $this->db->query("SELECT TOP(15) u.*, um.* FROM users u INNER JOIN User_memberships um ON u.Users_ID = um.Users_id AND um.Club_id = {$org_id} AND um.Member_Status = 1 ORDER BY u.Users_ID DESC");

			return $query->result();
		}

		public function get_members_list($org_id)
		{
			//$academySport = $this->get_academy_details($org_id);

			/*
			$academySport = json_decode($academySport['Aca_sport']);
			$sport_cond = "";
			if($academySport[0]){
			$sport_cond = "AND SportsType_ID = {$academySport[0]}";
			}
			*/

			/*$academySport = $academySport['Primary_Sport'];

			$sport_cond = ""; 
			if($academySport) {
			$sport_cond = "AND a.SportsType_ID = {$academySport}";
			}*/

			/*$org_cond = " u.Users_ID IN (SELECT Users_id FROM User_memberships WHERE Club_ID = $org_id)";
			$query	  = $this->db->query("SELECT u.*, a.*, um.* FROM users u join A2MScore a join User_memberships um on u.users_id = a.Users_ID {$sport_cond} WHERE {$org_cond} Order by A2MScore desc");*/

			/*$query	  = $this->db->query("SELECT u.*, a.*, um.* FROM users u INNER JOIN User_memberships um ON u.users_id = um.Users_id AND um.Club_id = {$org_id} INNER JOIN A2MScore a ON u.users_id = a.Users_ID {$sport_cond} ORDER BY a.A2MScore DESC");*/
			//var_dump($this->input->get('stat'));
			//exit;
			if($this->input->get('stat') === '-1'){
				$query	  = $this->db->query("SELECT u.*, um.* FROM users u INNER JOIN User_memberships um ON u.Users_ID = um.Users_id AND um.Club_id = {$org_id} ORDER BY u.Users_ID DESC");
			}
			else{
				$stat = 1;
				if($this->input->get('stat') === '0')
				$stat = 0;
				//echo $stat; exit;
				$query = $this->db->query("SELECT u.*, um.* FROM users u INNER JOIN User_memberships um ON u.Users_ID = um.Users_id AND um.Club_id = {$org_id} AND um.Member_Status = {$stat} ORDER BY u.Users_ID DESC");
			}

			//echo $this->db->last_query(); exit;
			return $query->result();
		}
		
		public function get_menu_name($id)
		{
			$data  = array('Menu_ID' => $id);
			$query = $this->db->get_where('Academy_Menu_List', $data);
			return $query->row_array();
		}

		public function get_user($id)
		{
			$data  = array('Users_ID' => $id);
			$query = $this->db->get_where('Users', $data);
			return $query->row_array();
		}

		public function update_act_menu($org_id){
			
			$data  = array('Academy_Id' => $org_id);
			$query = $this->db->get_where('Academy_Menu_Settings', $data);

			$menu_list = json_encode($this->input->post('active_menu'));

			
			 if($query->num_rows() > 0){

				$data = array('Active_Menu_Ids' => $menu_list);

				$this->db->where('Academy_Id', $org_id);
				$result = $this->db->update('Academy_Menu_Settings', $data); 

			 } else {

				$data = array(
				'Academy_Id' => $org_id,
				'Active_Menu_Ids' => $menu_list
				);

			   $result = $this->db->insert('Academy_Menu_Settings', $data);

			 }

			return $result;
		}

		public function update_menu($menu_list, $org_id){
			
			$data	  = array('Academy_Id' => $org_id);
			$query = $this->db->get_where('Academy_Menu_Settings', $data);

			 if($query->num_rows() > 0){
				$data   =  array('Active_Menu_Ids' => $menu_list);
								 $this->db->where('Academy_Id', $org_id);
				$result = $this->db->update('Academy_Menu_Settings', $data); 
			 }
			 else {
				$data = array(
								'Academy_Id'		  => $org_id,
								'Active_Menu_Ids' => $menu_list
								);

			   $result = $this->db->insert('Academy_Menu_Settings', $data);
			 }

			return $result;
		}

		public function get_academy_list_news()
		{
			$this->db->select('*');
			$this->db->from('Sports_News');
			$this->db->where('Org_Id !=', 0);
			$this->db->order_by("Modified_on", "desc");
			$query=$this->db->get();
			return $query->result();
		}

		public function get_specific_news($org_id)
		{
			$data = array('Org_Id'=> $org_id);
			$query = $this->db->get_where('Sports_News',$data);
			return $query->result();
		}

		public function get_testimonials($org_id)
		{
			$data = array('club_id'=> $org_id, 'status' => 1);
			$query = $this->db->get_where('Academy_Testimonials',$data);
			return $query->result();
		}

		public function get_academy_details($org_id)
		{
			$data = array('Aca_ID'=>$org_id);
			$query = $this->db->get_where('Academy_Info',$data);
			return $query->row_array();
		}

		public function get_user_membership($org_id, $user_id)
		{
			$data = array('Club_id' => $org_id, 'Users_id' => $user_id);
			$query = $this->db->get_where('User_memberships',$data);
			return $query->row_array();
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

		public function get_sport_id($user_id){
			
			$data = array('users_id'=>$user_id);
			$get_sp_name = $this->db->get_where('Sports_Interests', $data);
			return $get_sp_name->result();
		}

		public function get_a2msocre($sport,$user_id)
		{
			$data = array('SportsType_ID'=>$sport , 'Users_ID'=>$user_id);
			$get_level = $this->db->get_where('A2MScore',$data);
			return $get_level->row_array();
		}


		public function search_details($data)
		{
			$name   = $data['search_fname']; 
			$ag_grp = $data['ag_grp'];
			$level = $data['level'];
			$gend = $data['sel_gend'];

			$sport  = $data['sport'];
			$academy_status = $data['academy_status'];
			$org_id = $data['org_id'];

			if($this->input->post('academy_status') == '1'){
				$org_id = $this->input->post('org_id');
				$academySport= $this->get_academy_details($org_id);
				$academySport= json_decode($academySport['Aca_sport'], true);
			}
			else if($academy_status == 1){
				$org_id = $org_id;
				$academySport= $this->get_academy_details($org_id);
				$academySport= json_decode($academySport['Aca_sport'], true);
			}
			else{
				 $org_id = "";
			}

			//$org_id = $data['org_id'];

		    ($data['lat']=="") ? $lat = 0 : $lat = $data['lat'];
		    ($data['long']=="") ? $long = 0 : $long = $data['long'];

			$name_cond = "";
			if($name != ""){
				$name_cond = "(Firstname like '{$name}%' OR Lastname like '{$name}%')";
			}

			$Sport_cond = "";
			if($sport != ""){
				if($name !=""){
					$Sport_cond = "AND u.Users_ID IN (select users_id from Sports_Interests where Sport_id ={$sport})"; 
				}
				else{
					$Sport_cond = "u.Users_ID IN (select users_id from Sports_Interests where Sport_id ={$sport})";
				}
			}

			$level_cond = "";
			if($level != ""){
				if($name !="" OR $sport != ""){
					$level_cond = "AND u.Users_ID IN (select users_id from Sports_Interests where Sport_id ={$sport} and Level = {$level})"; 
				}
				else{
					$level_cond = "u.Users_ID IN (select users_id from Sports_Interests where Sport_id ={$sport} or Level = {$level})";
				}
			}
	
			$gend_cond = "";
			if($gend != ""){
				if($name !="" OR $sport != "" OR $level != ""){
					$gend_cond = "AND u.Gender = {$gend}"; 
				}
				else{
					$gend_cond = "u.Gender = {$gend}";
				}
			}

			$ag_grp_cond = "";
			if($ag_grp != ""){
				if($ag_grp == 'Kids'){ $ag_grp = "'U9','U10','U11','U12','U13','U14','U15','U16','U17','U18','U19'"; }
				else{ $ag_grp = "'$ag_grp'"; }

				if($name!="" OR $sport != "" OR $level != "" OR $gend != ""){
					$ag_grp_cond = "AND u.UserAgegroup IN ($ag_grp)";
				}
				else{
					$ag_grp_cond = "u.UserAgegroup IN ($ag_grp)";
				}
			}

			$org_cond = "";

			$stat_qry = "";
			if($this->input->get('stat') > -1){
				$stat_qry = "AND Member_Status = ".$this->input->get('stat');
			}
			else if($this->input->post('stat_search') > -1){
				$stat_qry = "AND Member_Status = ".$this->input->post('stat_search');
			}


			if(!empty($org_id)){
				if($name!= "" OR $sport != "" OR  $ag_grp != "" OR  $level != "" OR  $gend != ""){
					$org_cond = " AND u.Users_ID IN (SELECT Users_id FROM User_memberships WHERE Club_id = $org_id {$stat_qry})";
				}
				else{
					$org_cond = "u.Users_ID IN (SELECT Users_id FROM User_memberships WHERE Club_id = $org_id {$stat_qry})";
				}
			}
			else{
				$org_cond .= "";
			}

				if($name != "" OR $sport != "" OR $org_id != "" OR  $ag_grp != "" OR  $level != "" OR  $gend != ""){
					if($sport == "")
					$sport = $academySport[0];

					$query = $this->db->query("SELECT *, 1 as Member_Status FROM users u WHERE {$name_cond} {$Sport_cond} {$level_cond} {$gend_cond} {$ag_grp_cond} {$org_cond}");
				}
				else{
					$query = $this->db->query("SELECT *, 1 as Member_Status FROM users u join A2MScore a on u.users_id = a.Users_ID AND SportsType_ID = {$academySport[0]}  ORDER BY a.A2MScore desc");
				}
			//echo $this->db->last_query(); exit;

			return $query->result();
		}

		public function search_members_list($data) {
			//echo "<pre>"; print_r($data); exit;
			$name   = $data['name']; 
			$ag_grp = $data['ag_grp'];
			$level	 = $data['level'];
			$gend	 = $data['sel_gend'];
			$sport  = $data['sport'];
			$rating_type  = $data['rating_type'];

			//echo $level.' '.$sport; exit;

			$academy_status = $data['academy_status'];
			$org_id = $data['org_id'];

			if($this->input->post('academy_status') == '1'){
				$org_id = $this->input->post('org_id');
				$academySport	= $this->get_academy_details($org_id);
				$academySport	= json_decode($academySport['Aca_sport'], true);
			}
			else if($academy_status == 1){
				$org_id = $org_id;
				$academySport	= $this->get_academy_details($org_id);
				$academySport	= json_decode($academySport['Aca_sport'], true);
			}
			else{
				 $org_id = "";
			}

			//$org_id = $data['org_id'];

		    ($data['lat']=="") ? $lat = 0 : $lat = $data['lat'];
		    ($data['long']=="") ? $long = 0 : $long = $data['long'];

			$name_cond = "";
			if($name != ""){
				$name_cond = "(Firstname like '{$name}%' OR Lastname like '{$name}%')";
			}

			$Sport_cond = "";
			/*if($sport != ""){
				if($name !=""){
					$Sport_cond = "AND u.Users_ID IN (select users_id from Sports_Interests where Sport_id ={$sport})"; 
				}
				else{
					$Sport_cond = "u.Users_ID IN (select users_id from Sports_Interests where Sport_id ={$sport})";
				}
			}*/

			$level_cond = "";
			/*if($level != ""){
				if($name !="" OR $sport != ""){
					$level_cond = "AND u.Users_ID IN (select users_id from Sports_Interests where Sport_id ={$sport} and Level = {$level})"; 
				}
				else{
					$level_cond = "u.Users_ID IN (select users_id from Sports_Interests where Sport_id ={$sport} or Level = {$level})";
				}
			}*/

			if($level != '' and $sport == '7'){
				$query		= $this->db->query("select * from SportsLevels where SportsLevel_ID = {$level}");
				$qry_res	= $query->row_array();
				if($qry_res['SportsLevel'][0] == 'L'){
					$rating_val	   = substr($qry_res['SportsLevel'], -3);
					$min_rating  = $rating_val;
					$max_rating = $rating_val + 0.5;
				}
				else if($qry_res['SportsLevel'] == 'Open'){
					$level = '';
				}
				else if($qry_res['SportsLevel'] == '2.0'){
					$rating_val	   = $qry_res['SportsLevel'];
					$min_rating  = $rating_val;
					$max_rating = $rating_val + 0.5;
				}
				else if($qry_res['SportsLevel'] == '2.5 to 3.5'){
					$min_rating  = 2.5;
					$max_rating = 3.5;
				}
				else if($qry_res['SportsLevel'] == '3.5 and Up'){
					$min_rating  = 3.5;
					$max_rating = 6.0;
				}
			}

			$gend_cond = "";
			if($gend != ""){
				if($name !=""){
					$gend_cond = "AND u.Gender = {$gend}"; 
				}
				else{
					$gend_cond = "u.Gender = {$gend}";
				}
			}

			$ag_grp_cond = "";
			if($ag_grp != ""){
				if($ag_grp == 'Kids'){ $ag_grp = "'U9','U10','U11','U12','U13','U14','U15','U16','U17','U18','U19'"; }
				else{ $ag_grp = "'$ag_grp'"; }

				if($name!="" OR $gend != ""){
					$ag_grp_cond = "AND u.UserAgegroup IN ($ag_grp)";
				}
				else{
					$ag_grp_cond = "u.UserAgegroup IN ($ag_grp)";
				}
			}

			$org_cond = "";

			//$stat_qry = "";
			//if($this->input->get('stat') > -1){
			//	$stat_qry = "AND Member_Status = ".$this->input->get('stat');
			//}

				$stat_qry = "AND Member_Status = 1";

			if(!empty($org_id)){
				if($name!= "" OR  $ag_grp != "" OR  $gend != ""){
					$org_cond = " AND u.Users_ID IN (SELECT Users_id FROM User_memberships WHERE Club_id = $org_id {$stat_qry})";
				}
				else{
					$org_cond = "u.Users_ID IN (SELECT Users_id FROM User_memberships WHERE Club_id = $org_id {$stat_qry})";
				}
			}
			else{
				$org_cond .= "";
			}

			if($level == ""){
				if($name != "" OR $org_id != "" OR  $ag_grp != "" OR  $gend != ""){
					if($sport == "")
					$sport  = $academySport[0];
					$query = $this->db->query("SELECT * FROM Users u WHERE {$name_cond}  {$gend_cond} {$ag_grp_cond} {$org_cond}");
				}
				else{
					$query = $this->db->query("SELECT *, 1 as Member_Status FROM users u join A2MScore a on u.users_id = a.Users_ID AND SportsType_ID = {$academySport[0]} ORDER BY a.A2MScore desc");
				}
			}
			else{
						if($rating_type == 'Doubles')
							$rating_column = 'Doubles_Rating';
						if($rating_type == 'Mixed')
							$rating_column = 'MixedDoubles_Rating';

				if($name != "" OR $ag_grp != "" OR  $gend != ""){
					$query = $this->db->query("SELECT * FROM Users u WHERE {$name_cond}  {$gend_cond} {$ag_grp_cond} AND u.EmailID IN (SELECT Email FROM GPA_Ratings WHERE {$rating_column} >= $min_rating AND {$rating_column} <= $max_rating)  ");
				}
				else{
					$query = $this->db->query("SELECT * FROM Users u WHERE u.EmailID IN (SELECT Email FROM GPA_Ratings WHERE {$rating_column} >= $min_rating AND {$rating_column} <= $max_rating)");
				}
			}

//echo $this->db->last_query(); exit;
			return $query->result();
			}

		public function get_num_matches($user_id, $sport)
		{

			$qr_check = $this->db->query("SELECT n.Users_ID,n.Num_Matches,n.Sport,n.Won, n.Lost,n.Win_Per,a.* from a2mscore a 
			left join Player_Matches_Count n on (n.Users_ID = a.Users_ID and n.Sport = a.SportsType_ID) where a.Users_ID = $user_id and a.SportsType_ID = $sport");
			
			return $qr_check->result();
		}

		public function search_coaches($data){
			$name   = $data['coach_name'];
			$range  = $data['coach_range'];
			$sport  = $data['coach_sport'];
			$org_id = $data['org_id'];

		    ($data['lat']  == "") ? $lat  = 0 : $lat  = $data['lat'];
		    ($data['long'] == "") ? $long = 0 : $long = $data['long'];

			$name_cond = "";
			if($name != ""){
				$name_cond = "(Firstname like '{$name}%' OR Lastname like '{$name}%')";
			}
			else{
				$name_cond = "";
			}

			$Sport_cond = "";
			if($sport != ""){		
				if($name !=""){
				$Sport_cond = "AND coach_sport = $sport "; 
				}
				else{
				$Sport_cond = "coach_sport = $sport";
				}
			}
			else{
				$Sport_cond = "";
			}


			$org_cond = "";
			/*if(!empty($org_id)){
				$org_cond = " AND Users_ID IN (SELECT Users_id FROM User_memberships WHERE Club_id= $org_id)";
			}*/
			
			if($range != ""){
				if($name != "" OR $sport != "" ){
					$range_cond = " AND ACOS( SIN( RADIANS( Latitude )) * SIN( RADIANS( $lat ) ) + COS( RADIANS( Latitude ) ) * COS( RADIANS( $lat )) *  COS( RADIANS( Longitude ) - RADIANS( $long)) ) * 3964.3 < {$range}";
						
					$query = $this->db->query(" SELECT * , ACOS( SIN( RADIANS( Latitude )) * SIN( RADIANS( $lat )) + COS( RADIANS( Latitude ) )
					* COS( RADIANS( $lat )) * COS( RADIANS( Longitude ) - RADIANS( $long )) ) * 3964.3 AS distance FROM users WHERE  {$name_cond}  {$Sport_cond}  {$range_cond} AND Is_coach = 1 AND coach_academy = $org_id {$org_cond}");			
				}
				else{
					$range_cond = "ACOS( SIN( RADIANS( Latitude )) * SIN( RADIANS( $lat )) + COS( RADIANS( Latitude ) ) * COS( RADIANS( $lat )) *  COS( RADIANS( Longitude ) - RADIANS( $long)) ) * 3964.3 < {$range}";

					$query = $this->db->query(" SELECT * , ACOS( SIN( RADIANS( Latitude ) ) * SIN( RADIANS( $lat ) ) + COS( RADIANS( Latitude ) )
					* COS( RADIANS( $lat )) * COS( RADIANS( Longitude ) - RADIANS( $long )) ) * 3964.3 AS distance FROM users WHERE  {$name_cond}  {$Sport_cond}  {$range_cond} AND Is_coach = 1 AND coach_academy = $org_id {$org_cond} ");	
				}
			}
			else{
				if($name != "" OR $sport != "" ){
				  $query = $this->db->query(" SELECT * FROM users WHERE {$name_cond} {$Sport_cond} AND Is_coach = 1 AND coach_academy = $org_id {$org_cond}");
				}
				else{
				  $query = $this->db->query(" SELECT * FROM users WHERE Is_coach = 1 AND coach_academy = $org_id {$org_cond}");
				}
			}
			/*echo $this->db->last_query();
			echo "<pre>";
			print_r($query->result());
			exit;*/
			return $query->result();
		}

		public function get_user_create_tournments($creator){
			if($this->is_club_admin)
			$qry_check = $this->db->query("SELECT * FROM tournament WHERE Usersid = $creator ORDER BY StartDate DESC");
			else
			$qry_check = $this->db->query("SELECT * FROM tournament WHERE Usersid = $creator AND Is_Publish = 1 ORDER BY StartDate DESC");

			/*$qry_check = $this->db->query("SELECT TOP 4 * FROM tournament WHERE Usersid = $creator AND EndDate > cast(GETDATE() as DATE) ORDER BY StartDate DESC");*/
			/*$qry_check = $this->db->query("SELECT * FROM tournament WHERE EndDate > cast(GETDATE() as DATE) ORDER BY StartDate DESC");*/
			
			return $qry_check->result();
		}

		public function get_user_create_events($creator){
			$qry_check = $this->db->query("SELECT * FROM Events WHERE Ev_Created_by = $creator 
			ORDER BY Ev_Start_Date DESC");

			/*$qry_check = $this->db->query("SELECT TOP 4 * FROM tournament WHERE Usersid = $creator AND EndDate > cast(GETDATE() as DATE) ORDER BY StartDate DESC");*/
			/*$qry_check = $this->db->query("SELECT * FROM tournament WHERE EndDate > cast(GETDATE() as DATE) ORDER BY StartDate DESC");*/
			
			return $qry_check->result();
		}

		public function get_user_past_tournments($creator){
			$qry_check = $this->db->query("SELECT TOP 4 * FROM tournament WHERE Usersid = $creator AND StartDate < cast(GETDATE() as DATE) ORDER BY StartDate DESC");
			return $qry_check->result();
		}

		public function get_club_tournments($creator){
			$qry_check = $this->db->query("SELECT * FROM tournament WHERE Usersid = $creator ORDER BY StartDate DESC");
			//echo "<pre>"; print_r($qry_check->result()); exit;
			return $qry_check->result();
		}


		public function get_event_classes($creator){
			$qry_check = $this->db->query("SELECT * FROM Events WHERE Ev_Created_by = $creator AND Ev_Type_ID = 2 ORDER BY Ev_Start_Date DESC");
	
			return $qry_check->result();
		}


		public function get_members($org_id, $sport) {
			/*$sport_cond = "";
			if($sport) {
			$sport_cond = "AND a.SportsType_ID = {$sport}";
			}*/

			$org_cond = " u.Users_ID IN (SELECT Users_id FROM User_memberships WHERE Club_ID = $org_id AND Member_Status = 1)";
			
			/*$query	  = $this->db->query("SELECT TOP 4 u.*, a.* FROM users u join A2MScore a on u.users_id = a.Users_ID WHERE {$org_cond} {$sport_cond} Order by A2MScore desc");*/
			$query	  = $this->db->query("SELECT TOP 4 u.* FROM users u WHERE {$org_cond}");
			
			//echo $this->db->last_query(); exit;
			return $query->result_array();
		}

		public function get_sport_title($sport_id){
			$data = array('SportsType_ID'=>$sport_id);
			$get_sp_name = $this->db->get_where('SportsType',$data);
			return $get_sp_name->row_array();
		}

		public function get_news($org_id)
		{
			$limit = 3;
			$user_id = $this->session->userdata('users_id');
			$this->db->select('*');
			$this->db->from('Sports_News');
			$this->db->where('Org_Id =', $org_id);
			$this->db->order_by("Modified_on", "desc");
			$this->db->limit($limit);
			$query=$this->db->get();
			return $query->result();
		}

		public function get_news_detail($news_id)
		{
			$data = array('News_id'=>$news_id);
			$get_name = $this->db->get_where('Sports_News',$data);
			return $get_name->row_array();
		}

		public function insert_news()
		{
		   $title = $this->input->post('title');
		   $sport = $this->input->post('Sport');
		   $des = addslashes($this->input->post('description'));
		   // $created = date("Y-m-d h:i:s");
		   $created_user  = $this->session->userdata('users_id');
		   $org_id  = $this->input->post('org_id');

			$data = array(
					'News_title' => $title,
					'News_content' => $des,
				    'SportsType_id' => $sport,
					'Created_by' => $created_user,
					'Org_Id' => $org_id
					);

		  $result = $this->db->insert('Sports_News', $data);
		  return $result;
		}

		public function update_news($news_id)
		{
			$message = addslashes($this->input->post('description'));
			$title = $this->input->post('title');
			$sport = $this->input->post('sport');
			$modified = date('Y-m-d H:i:s');

			$data = array('News_content' => $message ,'News_title' => $title,'Modified_on'=>$modified,'SportsType_id'=>$sport);

			$this->db->where('News_id', $news_id);
			$result = $this->db->update('Sports_News', $data); 
		
			return $result;
		}

		public function update_pom($data)
		{
			$pom		= $data['user'];
			$academy	= $data['academy'];
			
			$data = array('POM' => $pom);

						$this->db->where('Aca_ID', $academy);
			$result =	$this->db->update('Academy_Info', $data); 
		}

		public function upd_membership($data , $data2) {
			$this->db->where($data);
			$result = $this->db->update('User_memberships', $data2);
			//echo $this->db->last_query(); exit;
			return $result;
		}

		public function get_club_facility($org_id) {
			$data = array('Aca_ID'=>$org_id);
			$query = $this->db->get_where('Academy_Pages', $data);
			return $query->row_array();
		}

		public function get_club_testimonials($org_id) {
			$data = array('club_id'=>$org_id);
			$query = $this->db->get_where('Academy_Testimonials', $data);
			return $query->result();
		}

		public function update_facility($data)
		{	
			$fac_text  = $data['fac_text'];
			$fac_img  = $data['fac_img'];
			$aca_id	  = $data['aca_id'];
			
			$data2['Facility_Text']	 = trim($fac_text);

			if($fac_img)
			$data2['Facility_Image'] = $fac_img;


			$check_qry = $this->db->query("SELECT * FROM Academy_Pages WHERE Aca_ID = {$aca_id}");
//echo $check_qry->num_rows(); exit;
			if($check_qry->num_rows() > 0){
							  $this->db->where('Aca_ID', $aca_id);
				$result = $this->db->update('Academy_Pages',  $data2); 
			}
			else{
				$data2['Aca_ID'] = $aca_id;
				$result = $this->db->insert('Academy_Pages',  $data2); 
			}
//echo $this->db->last_query(); exit;
			return $result;
		}

		public function update_pricing($data)
		{
			$fac_prc  = $data['fac_prc'];
			$aca_id	  = $data['aca_id'];
			
			if($fac_prc)
			$data2['Pricing_Info'] = $fac_prc;

			$check_qry = $this->db->query("SELECT * FROM Academy_Pages WHERE Aca_ID = {$aca_id}");
/*echo $check_qry->num_rows();
exit;*/
			if($check_qry->num_rows() > 0){
							  $this->db->where('Aca_ID', $aca_id);
				$result = $this->db->update('Academy_Pages',  $data2); 
			}
			else{
				$data2['Aca_ID'] = $aca_id;
				$result = $this->db->insert('Academy_Pages',  $data2); 
			}
			return $result;
		}

		public function update_facility_lt_teams($data){
			$aca_id = $data['Aca_ID'];
			$check_qry = $this->db->query("SELECT * FROM Academy_Pages WHERE Aca_ID = {$aca_id}");

			if($check_qry->num_rows() > 0){
				$data2['Facility_Leadership'] = $data['Facility_Leadership'];
					      $this->db->where('Aca_ID', $aca_id);
			$result = $this->db->update('Academy_Pages',  $data2); 
			}
			else{
			$result = $this->db->insert('Academy_Pages',  $data); 
			}
			return $result;
		}

		public function update_facility_ps_teams($data){
			$aca_id = $data['Aca_ID'];
			$check_qry = $this->db->query("SELECT * FROM Academy_Pages WHERE Aca_ID = {$aca_id}");

			if($check_qry->num_rows() > 0){
				$data2['Facility_Partner_Sponsors'] = $data['Facility_Partner_Sponsors'];
					      $this->db->where('Aca_ID', $aca_id);
			$result = $this->db->update('Academy_Pages',  $data2); 
			}
			else{
			$result = $this->db->insert('Academy_Pages',  $data); 
			}

			return $result;
		}

		public function update_facility_glry_teams($data){
			$aca_id = $data['Aca_ID'];

			$check_qry = $this->db->query("SELECT * FROM Academy_Pages WHERE Aca_ID = {$aca_id}");

			if($check_qry->num_rows() > 0){
				$data2['Facility_Gallery'] = $data['Facility_Gallery'];
					      $this->db->where('Aca_ID', $aca_id);
			$result = $this->db->update('Academy_Pages',  $data2); 
			}
			else{
			$result = $this->db->insert('Academy_Pages',  $data); 
			}

			return $result;
		}

		public function update_facility_videolinks($data){
			$aca_id = $data['Aca_ID'];

			$check_qry = $this->db->query("SELECT * FROM Academy_Pages WHERE Aca_ID = {$aca_id}");

			if($check_qry->num_rows() > 0){
				$data2['VideoLinks'] = $data['VideoLinks'];
					      $this->db->where('Aca_ID', $aca_id);
			$result = $this->db->update('Academy_Pages',  $data2); 
			}
			else{
			$result = $this->db->insert('Academy_Pages',  $data); 
			}

			return $result;
		}

		public function update_banner_images($data){
			$aca_id = $data['Aca_ID'];

			$check_qry = $this->db->query("SELECT * FROM Academy_Pages WHERE Aca_ID = {$aca_id}");

			if($check_qry->num_rows() > 0){
				$data2['Banner_Images'] = $data['Banner_Images'];
					      $this->db->where('Aca_ID', $aca_id);
			$result = $this->db->update('Academy_Pages',  $data2); 
			}
			else{
			$result = $this->db->insert('Academy_Pages',  $data); 
			}
			//echo $this->db->last_query(); exit;
			return $result;
		}
		public function update_home_video($data){
			$aca_id = $data['Aca_ID'];

			$check_qry = $this->db->query("SELECT * FROM Academy_Pages WHERE Aca_ID = {$aca_id}");

			if($check_qry->num_rows() > 0){
				$data2['Home_Video'] = $data['Home_Video'];
					      $this->db->where('Aca_ID', $aca_id);
			$result = $this->db->update('Academy_Pages',  $data2); 
			}
			else{
			$result = $this->db->insert('Academy_Pages',  $data); 
			}
			//echo $this->db->last_query(); exit;
			return $result;
		}

		public function update_facility_pro($data){
			$aca_id = $data['Aca_ID'];

			$check_qry = $this->db->query("SELECT * FROM Academy_Pages WHERE Aca_ID = {$aca_id}");

			if($check_qry->num_rows() > 0){
				$data2['Facility_ProShop'] = $data['Facility_ProShop'];
					      $this->db->where('Aca_ID', $aca_id);
			$result = $this->db->update('Academy_Pages',  $data2); 
			}
			else{
			$result = $this->db->insert('Academy_Pages',  $data); 
			}
			return $result;
		}

		public function update_forms($data, $data2){
			$check_qry = $this->db->query("SELECT * FROM Academy_Pages WHERE Aca_ID = {$data['Aca_ID']}");
			if($check_qry->num_rows() > 0){
								$this->db->where($data);
				$result = $this->db->update('Academy_Pages',  $data2); 
			}
			else{
				$data2['Aca_ID'] = $data['Aca_ID'];
				$result = $this->db->insert('Academy_Pages',  $data2); 
			}
			return $result;
		}


		public function insert_update_aca_pages($data, $data2){
			$check_qry = $this->db->query("SELECT * FROM Academy_Pages WHERE Aca_ID = {$data['Aca_ID']}");
			if($check_qry->num_rows() > 0){
								$this->db->where($data);
				$result = $this->db->update('Academy_Pages',  $data2); 
			}
			else{
				$data2['Aca_ID'] = $data['Aca_ID'];
				$result = $this->db->insert('Academy_Pages',  $data2); 
			}
			return $result;
		}

		public function get_user_expo($user){
			$get_expo = $this->db->query("SELECT * FROM userPushTokens WHERE user_id = {$user} AND status=1 AND token LIKE 'ExponentPushToken%'");
			return $get_expo->result();
		}

		public function insert_notif($data){
			$query = $this->db->insert('Mobile_Notifications', $data);
			return $query;
		}

		public function getUserRatings($coach_id){
			$user_id			= $this->logged_user;
			$data				= array('Coach_ID' => $coach_id, 'User_ID' => $user_id);
			$get_ratings	= $this->db->get_where('Coach_Ratings',$data);
			return $get_ratings->result();
		}

		public function getCoachRatings($coach_id){
			$data = array('Coach_ID' => $coach_id);
			$get_ratings = $this->db->get_where('Coach_Ratings',$data);
			return $get_ratings->result();
		}

		public function get_mem_dets($tab_id){
			$data = array('tab_id' => $tab_id);
			$get_det = $this->db->get_where('Membership_Types', $data);
			return $get_det->row_array();
		}

		public function get_paylink($tab_id){
			$data = array('tab_id' => $tab_id);
			$get_det = $this->db->get_where('Membership_PaymentLinks', $data);
			//echo $this->db->last_query(); exit;
			return $get_det->row_array();
		}

		public function get_user_sport_intrests($user_id, $sport){
			$data = array('users_id'=>$user_id,'Sport_id' => $sport);
			$qry_check = $this->db->get_where('Sports_Interests', $data);
			return $qry_check->result();
		}

		public function get_membership_details($user_id){
			$qr_check = $this->db->query("SELECT * FROM User_memberships where Users_id = $user_id");			
			return $qr_check->result();
		}

		public function get_club($org_id){
			$data = array('Aca_ID'=>$org_id);
			$qry_check = $this->db->get_where('Academy_Info', $data);
			return $qry_check->row_array();
		}

		public function get_assoc_clubs($org_id){
			$data = array('Assoc_Club'=>$org_id);
			$qry_check = $this->db->get_where('Academy_Info', $data);
			return $qry_check->result();
		}

		public function get_club_sports($org_id){
			$data = array('Aca_ID'=>$org_id);
			$qry_check = $this->db->get_where('Academy_Info', $data);
			$get_org = $qry_check->row_array();
			if($get_org['Aca_sport']){
				$sports = json_decode($get_org['Aca_sport'], true);
			}
			else{
				$sports = array($get_org['Primary_Sport']);
			}

			$res = '';
			foreach($sports as $sport){
				$query  = $this->db->query("SELECT * FROM SportsType where SportsType_ID = $sport");
				$res[]   = $query->row_array();
			}
			return $res;
		}

}