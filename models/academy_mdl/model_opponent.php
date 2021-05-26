<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

	class model_opponent extends CI_Model {
	
		public function __construct()
		{
			parent:: __construct();
		}

		public function get_lat_lang()
		{
			$user_id = $this->session->userdata('users_id');
			$data = array('Users_ID'=>$user_id);

			$this->db->select('Latitude, Longitude');
			$query = $this->db->get_where('Users',$data);
			return $query->row();
		}


		public function get_optimum_users($data)  
		{
			$lat = $data['latitude'];
			$long = $data['longitude'];
			$range = $data['range'];
			$sport_id = 1;


			$current_user = $this->session->userdata('users_id');

			$qry_check = $this->db->query("SELECT * FROM Users WHERE ACOS( SIN( RADIANS( Latitude ) ) * SIN( RADIANS( $lat ) ) + COS( RADIANS( Latitude ) ) * COS( RADIANS( $lat )) * COS( RADIANS( Longitude ) - RADIANS( $long )) ) * 3964.3 < $range AND Users_ID ! = {$current_user} AND Users_ID IN (SELECT users_id FROM Sports_Interests WHERE Sport_id = {$sport_id})");
		
			//$qry_check = $this->db->query("SELECT * FROM Users WHERE Users_ID ! = {$current_user} AND Users_ID IN (SELECT users_id FROM Sports_Interests WHERE Sport_id = {$sport_id})");

			//$qry_check = $this->db->query("SELECT * FROM Users WHERE Users_ID ! = {$current_user} ");

			
			//echo "<pre>";
			//print_r($qry_check->result());
			//exit;

			return $qry_check;
		}

		public function get_sport_users($data)  
		{
			$sport_id = $data['sport_id'];

			$lat = $data['latitude'];
			$long = $data['longitude'];
			$range = $data['range'];

			$current_user = $this->session->userdata('users_id');

			$qry_check = $this->db->query("SELECT *, ACOS( SIN( RADIANS( Latitude ) ) * SIN( RADIANS( $lat ) ) + COS( RADIANS( Latitude ) )
* COS( RADIANS( $lat )) * COS( RADIANS( Longitude ) - RADIANS( $long )) ) * 3964.3 AS distance FROM Users WHERE ACOS( SIN( RADIANS( Latitude ) ) * SIN( RADIANS( $lat ) ) + COS( RADIANS( Latitude ) ) * COS( RADIANS( $lat )) * COS( RADIANS( Longitude ) - RADIANS( $long )) ) * 3964.3 < $range AND Users_ID ! = {$current_user} ORDER BY distance");

			return $qry_check;
		}



		
		public function search_users($data)   // Advance Search in Opponent Page
		{

			$intrests = $data['Sportsintrests'];

			$intrests_count = count(array_filter($intrests));
			$i = 0;

			if($intrests_count > 0)	{
				$intrests_in = "";
				foreach($intrests as $row)
				{
					$intrests_in .= "'$row'";

						if(++$i != $intrests_count) {
							$intrests_in .= ",";
						}
				}
				$intrested_qry = "WHERE Sport_id IN ($intrests_in)";

			}
			else {
				$intrested_qry = "";
			}

			/* Getting Users that are intrested in selected Sports */

			$qry_get_users = $this->db->query("SELECT users_id FROM Sports_Interests $intrested_qry GROUP BY users_id");

			$qry_get_users_count = count(array_filter($qry_get_users->result()));
			$i = 0; 
			$j=0;

			if($qry_get_users_count > 0) {
				$users_in = "";
				foreach($qry_get_users->result() as $row2)
				{
					$users_in .= "'$row2->users_id'";

						if(++$i != $qry_get_users_count) {
							$users_in .= ",";
						}
						$j++;
				}
				$users_in_qry = "AND Users_ID IN ($users_in)";
			}
			else {
					$users_in_qry = "";
			}

			/* End of Getting Users that are intrested in selected Sports  */

			$age_group = $data['age_group'];

			$age_group_count = count(array_filter($age_group));

			$i = 0;
			if($age_group_count > 0){
				$age_group_in = "";
				foreach($age_group as $row3)
				{
					$age_group_in .= "'$row3'";

						if(++$i != $age_group_count) {
							$age_group_in .= ",";
						}
				}
				$age_group_qry = "AND UserAgegroup IN ($age_group_in)";
			}
			else {
				$age_group_qry = "";
			}
		
			//$level = $data['level'];
			$gend = $data['gend'];

			if($gend=='all' or $gend==""){
				$gend_cond = "";
			}
			else {
				$gend_cond = "AND Gender = '$gend'";
			}

			$lat = $data['latitude'];
			$long = $data['longitude'];

			$range = $data['range'];

			$current_user = $this->session->userdata('users_id');

			$qry_check = $this->db->query("SELECT *, ACOS( SIN( RADIANS( Latitude ) ) * SIN( RADIANS( $lat ) ) + COS( RADIANS( Latitude ) )
* COS( RADIANS( $lat )) * COS( RADIANS( Longitude ) - RADIANS( $long )) ) * 3964.3 AS distance FROM Users WHERE ACOS( SIN( RADIANS( Latitude ) ) * SIN( RADIANS( $lat ) ) + COS( RADIANS( Latitude ) ) * COS( RADIANS( $lat )) * COS( RADIANS( Longitude ) - RADIANS( $long )) ) * 3964.3 < {$range} {$age_group_qry} {$users_in_qry} AND Users_ID ! = '$current_user' $gend_cond ORDER BY distance");


			return $qry_check;
		}

		public function create_match()
		{
			$latitude = $this->session->userdata('lat');
			$longitude = $this->session->userdata('long');

			$match_title = $this->input->post('match_title');
			
			$sport = $this->input->post('Sport');
			//$date =  date("Y-m-d" ,strtotime($match_date)) ." " . date("H:i", strtotime($time));

			$match_date_upd = NULL;
			$match_date = $this->input->post('match_date');
			if($match_date){
				  
				$time_hr = $this->input->post('match_time_hr');

			    if($time_hr){
					
					($this->input->post('match_time_mm') != "") ? $time_mm = $this->input->post('match_time_mm')  : $time_mm = "00";
					$time_am = $this->input->post('match_time_am');

					$time = $time_hr.":".$time_mm." ".$time_am;
					$date_time = $match_date." ".$time;
					$match_date_upd = date("Y-m-d H:i", strtotime($date_time));
			    }
			   else{
					$match_date_upd = date("Y-m-d", strtotime($match_date));
			   }
			}
			
			$match_date_upd1 = NULL;
			$match_date1 = $this->input->post('match_date1');
			if($match_date1){
				  
				$time_hr = $this->input->post('match_time_hr1');

			    if($time_hr){

					($this->input->post('match_time_mm1') != "") ? $time_mm = $this->input->post('match_time_mm1') : $time_mm = "00";
					$time_am = $this->input->post('match_time_am1');

					$time1 = $time_hr.":".$time_mm." ".$time_am;
					$date_time = $match_date1." ".$time1;
					$match_date_upd1 = date("Y-m-d H:i", strtotime($date_time));
			    }
			   else{
					$match_date_upd1 = date("Y-m-d", strtotime($match_date1));
			   }
			}

			
			$match_date_upd2 = NULL;
			$match_date2 = $this->input->post('match_date2');
			if($match_date2){
				  
				$time_hr = $this->input->post('match_time_hr2');

			    if($time_hr){
					($this->input->post('match_time_mm2') != "") ? $time_mm = $this->input->post('match_time_mm2')  : $time_mm = "00";
					$time_am = $this->input->post('match_time_am2');

					$time2 = $time_hr.":".$time_mm." ".$time_am;
					$date_time = $match_date2." ".$time2;
					$match_date_upd2 = date("Y-m-d H:i", strtotime($date_time));
			    }
			   else{
					$match_date_upd2 = date("Y-m-d", strtotime($match_date2));
			   }
			}

			//echo $match_date2;echo "<br />";

			$cur_date = date("Y-m-d h:i:s");

			$message = $this->input->post('message');

			$visible_status = $this->input->post('visible_status');
			if($visible_status == "1"){
			$allowed_users = json_encode($this->input->post('sel_player'));
			}
			else{
				$allowed_users = "";
			}
			
			$player1_partner = "";

			$match_type = $this->input->post('match_type');

			if($this->input->post('player1_partner') and ($match_type == "Doubles")){
			$player1_partner = $this->input->post('player1_partner');
			}

			$data = array(
					'Match_Title' => $match_title,
					'users_id' => $this->session->userdata('users_id'),
					'Sports' => $sport,
					'Match_Date' => $match_date_upd,
					'Match_Date2' => $match_date_upd1,
					'Match_Date3' => $match_date_upd2,
					'Message' => $message,
					'Match_created_on' => $cur_date,
					'Status' => 'Not Completed',
					'Access_Status' => $visible_status,
					'Allowed_Users' => $allowed_users,
					'Latitude' => $latitude,
					'Longitude' => $longitude,
					'Match_Type' => $match_type,
					'Player1_Partner' => $player1_partner
				);
				
			 $this->db->insert('GeneralMatch', $data);

		     return  $this->db->insert_id(); 
		}

		public function get_sport_title($sport_id){
			
			$data = array('SportsType_ID'=>$sport_id);
			$get_sp_name = $this->db->get_where('SportsType',$data);
			return $get_sp_name->row_array();
		}

		public function search_sport_users($data){

			$lat		= $data['latitude'];
			$long		= $data['longitude'];

			$sport_id	= $data['sport_id'];
			$gender		= $data['gender'];
			$age_group	= $data['age_group'];
			$level		= $data['level'];
			$range		= $data['range'];
			$org_id		= $data['org_id'];

			$gend_cond = "";
			if($gender == 'M'){
				$gend_cond .= " AND Gender = '1'";
			}
			else if($gender	== 'F'){
				$gend_cond .= " AND Gender = '0'";
			}
			else if($gender == 'all'){
				$gend_cond .= "";
			}

			$age_group_count = count(array_filter($age_group));

			$i = 0;
			if($age_group_count > 0){
				$age_group_in = "";
				foreach($age_group as $row3)
				{
					$age_group_in .= "'$row3'";

						if(++$i != $age_group_count) {
							$age_group_in .= ",";
						}
				}
				$age_group_qry = "AND UserAgegroup IN ($age_group_in)";
			}
			else {
				$age_group_qry = "";
			}

			$level_cond = "";
			$level_count = count(array_filter($level));
			$i = 0;
			if($level_count > 0 ){
			
				$level_in = "";
				foreach($level as $l)
				{
					$level_in .= "'$l'";
						if(++$i != $level_count){
							$level_in .= ",";
						}
				}
			   $level_query = "AND users_id IN (SELECT users_id FROM Sports_Interests WHERE Level IN ($level_in) AND Sport_id = {$sport_id})";
			}
			else
			{
				$level_query = "";
			}
		
			//print_r($level_query);
			//exit;
			
			$range_cond = "";
			if(!empty($range)){
				$range_cond = " AND ACOS( SIN( RADIANS( Latitude )) * SIN( RADIANS( $lat ) ) + COS( RADIANS( Latitude ) ) * COS( RADIANS( $lat )) *  COS( RADIANS( Longitude ) - RADIANS( $long)) ) * 3964.3 < {$range}";
			}
			else{
				$range_cond .= "";
			}

			$org_cond = "";

			if(!empty($org_id)){
				$org_cond = " AND Users_ID IN (SELECT Users_id FROM Academy_users WHERE Org_ID = $org_id)";
			}
			else{
				$org_cond .= "";
			}
			

			$current_user = $this->session->userdata('users_id');
			 
			$r = "";
		    $s = "";

			if(isset($sport_id)){
			  $r =  "Sport_id = {$sport_id}";
			}

			if(!empty($org_id)){
				$s .=  "{$org_cond} ";
			}

			if (isset($gender))
			{
			  $s .=  "{$gend_cond} ";
			}

			if(!empty($range)){
				$s .=  "{$range_cond} ";
			}

			if(!empty($age_group)){

			$s .=  "{$age_group_qry} ";
			}

			if(!empty($level)){

			$s .=  "{$level_query}";
			}
		
		
			$qry_check = $this->db->query("SELECT * FROM Users WHERE  Users_ID ! = {$current_user} AND Users_ID IN (SELECT users_id FROM Sports_Interests WHERE $r ) $s");

			//print_r($this->db->last_query());
			//exit;

			return $qry_check;

		}

		public function get_user_sport_level($sport,$user_id)
		{

			$data = array('Sport_id'=>$sport , 'users_id'=>$user_id);
			$get_level = $this->db->get_where('Sports_Interests',$data);
			return $get_level->row_array();
		
		}

		public function get_sport_level_title($level,$sport)
		{
			$data = array('SportsType_ID'=>$sport,'SportsLevel_ID'=>$level);
			$get_level = $this->db->get_where('SportsLevels',$data);
			return $get_level->row_array();
		}

		public function get_sport_levels()
		{
			$data = array('SportsType_ID'=> '1');
			$query = $this->db->get_where('SportsLevels',$data);
			return $query->result();
		}

		public function get_specific_levels($sport_id)
		{
			$data = array('SportsType_ID'=> $sport_id);
			$query = $this->db->get_where('SportsLevels',$data);
			return $query->result();
		}
		
		public function get_a2msocre($sport,$user_id)
		{
			$data = array('SportsType_ID'=>$sport , 'Users_ID'=>$user_id);
			$get_level = $this->db->get_where('A2MScore',$data);
			return $get_level->row_array();
		}


		public function search_autocomplete($data)
		{
			
			$key = $data['key'];
			
			$this->db->select('*');
			$this->db->from('Academy');
			$this->db->like('Org_name', $key); 
			
			$query = $this->db->get();
			return $query->result();
			
		}
		
	
}