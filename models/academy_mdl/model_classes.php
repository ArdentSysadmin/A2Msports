<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

	class model_classes extends CI_Model {
	
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
			$lat =$this->session->userdata('lat');
			$lat =$this->session->userdata('long');
			$sport_id = 1;

			$current_user = $this->session->userdata('users_id');

			//$qry_check = $this->db->query("SELECT * FROM Users WHERE ACOS( SIN( RADIANS( Latitude ) ) * SIN( RADIANS( $lat ) ) + COS( RADIANS( Latitude ) ) * COS( RADIANS( $lat )) * COS( RADIANS( Longitude ) - RADIANS( $long )) ) * 3964.3 < $range AND Users_ID ! = {$current_user} AND Users_ID IN (SELECT users_id FROM Sports_Interests WHERE Sport_id = {$sport_id})");
		
			//$qry_check = $this->db->query("SELECT * FROM Users WHERE Users_ID ! = {$current_user} AND Users_ID IN (SELECT users_id FROM Sports_Interests WHERE Sport_id = {$sport_id})");

			$qry_check = $this->db->query("SELECT * FROM Users WHERE Users_ID ! = {$current_user}");
			
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

		public function create_event($data)
		{
			
			//print_r($data);
			
			$data = $this->upload->data();
			$filename = $data['file_name'];
			
			$event_title = $this->input->post('event_name');
			$event_type = $this->input->post('event_type');
			$event_org = $this->input->post('event_org');
			$event_contact = $this->input->post('event_contact');
			$event_location = $this->input->post('ev_loc_id');
			
			
			$start_date = $this->input->post('event_start_date');
			if($start_date)				  
				$start_date = date("Y-m-d", strtotime($start_date));
			   
				
			$end_date = $this->input->post('event_end_date');
			if($end_date)
				$end_date = date("Y-m-d", strtotime($end_date));
		


			$event_created_date = date("Y-m-d h:i:s");
			$event_schedule = $this->input->post('schedule');
			$message = $this->input->post('ev_message');

			if($event_schedule == 'singleday')
			{
				$ed = $this->input->post('ev_dt');
				foreach($ed as $i => $evd){
					$start_date = date('Y-m-d',strtotime($ed[$i]));
					$end_date = date('Y-m-d',strtotime($ed[$i]));
				}
			}


			$data = array(
					'Ev_Type_ID' => $event_type,
					'EventImage' => $filename,
				    'Ev_Title' => $event_title,
					'Ev_Location' => $event_location,
					'Ev_Organizer' => $event_org,
					'Ev_Contact_Num' => $event_contact,
					'Ev_Schedule' => $event_schedule,
					'Ev_Start_Date' => $start_date,
					'Ev_End_Date' => $end_date,
					'Ev_Created_by' => $this->session->userdata('users_id'),
					'Ev_Created_Date' => $event_created_date,
					'Ev_Desc' => $message
					);

			//echo "<pre>";
			//print_r($data);
			//exit;
				
			 $result = $this->db->insert('Events', $data);
			 $ev_id = $this->db->insert_id();


			 $ev_date = $this->input->post('ev_dt');
			 $ev_start_time = $this->input->post('ev_st');
			 $ev_end_time = $this->input->post('ev_et');
			 $ev_loc = $this->input->post('ev_rploc_id');


			foreach($ev_date as $i => $evd){

				$ev_locid = ($ev_loc[$i] == "") ? $event_location : $ev_loc[$i];

				$data = array(
						'Ev_ID' => $ev_id,
						'Ev_Date' => date('Y-m-d',strtotime($ev_date[$i])),
						'Ev_Start_Time' => date('H:i',strtotime($ev_start_time[$i])),
						'Ev_End_Time' => date('H:i',strtotime($ev_end_time[$i])),
						'Ev_Location' => $ev_locid
						);

				 $ins_event_repeat = $this->db->insert('Ev_Repeat_Schedule', $data);
			}

		     return  $ev_id; 
		}

		public function create_location($data)
		{
			
			$points = $data['latt'];

			$values = explode('@',$points);
			$loc_lat = $values[0];
			$loc_long = $values[1];
			
			$title = $data['title'];
		    $add = $data['add'];
			$city = $data['city'];
			$state = $data['state'];
			$country = $data['country'];
		    $zip = $data['zip'];

			$data = array(
					'loc_title' => $title,
					'loc_address' => $add,
					'loc_city' => $city,
					'loc_state' => $state,
					'loc_country' => $country,
					'loc_zipcode' => $zip,
					'loc_created_by' => $this->session->userdata('users_id'),
					'loc_lat' => $loc_lat,
					'loc_long' => $loc_long
				);

			//echo "<pre>";
			//print_r($data);
			//exit;
				
			$result = $this->db->insert('Events_Locations', $data);
		    return  $result; 
			
	    }

		public function insert_comment()
		{
			
			$user = $this->session->userdata('users_id');
			$event_id = $this->input->post('event_id');
			$comm = $this->input->post('message');
			$created = date('Y-m-d H:i:s');

			$data = array(
					'Ev_Id' => $event_id,
					'Users_id' => $user,
					'Comments' => $comm,
					'Comment_date' => $created
				);

			$result = $this->db->insert('Ev_User_Comments', $data);


		    return  $result; 
			
	    }
		
		public function ins_ev_invite($data)
		{
			$user_id		= $data['user'];
			$event_id		= $data['event_id'];
			$ev_rep_id	= $data['ev_rep_id'];
			$status			= 'Pending';

			if($data['ev_status']){
			$status = $data['ev_status'];
			}

			$data = array(
					'Ev_ID'			=> $event_id,
					'Ev_Rep_ID'  => $ev_rep_id,
					'Users_Id'		=> $user_id,
					'Ev_status'		=> $status
					);

			$result = $this->db->insert('Ev_Inv_Status', $data);
		    return  $result; 
	    }

		public function update_non_reg_user_status($ev_id, $act_code)
		{
			
			$updateData = array(
			'Act_Status' => 1
			);

			$this->db->where('Act_Code', $act_code);
			$this->db->update('Ev_Inv_List', $updateData);

		    return  $result; 
	    }

		public function insert_non_reg_users($data)
		{
			
			$email = $data['email'];
			$event_id = $data['ev_id'];
			$act_status = 0;
			$act_code = $data['act_code'];

			$data = array(
					'Ev_ID' => $event_id,
					'Ev_Email' => $email,
					'Act_Code' => $act_code,
					'Act_Status' => $act_status
			 );

			$result = $this->db->insert('Ev_Inv_List', $data);
		    return  $result; 
	    }
		
		public function get_event_types(){
			$data = array('Ev_Type_Status' => 1);
			$get_sp_name = $this->db->get_where('Events_Type', $data);
			return $get_sp_name->result();
		}

		public function getonerow($ev_id){
			
			$data = array('Ev_ID'=>$ev_id);
			$get_sp_name = $this->db->get_where('Events',$data);
			return $get_sp_name->row_array();
		}

		public function get_rep_events($ev_id){
			
			$data = array('Ev_ID'=>$ev_id);
			$get_sp_name = $this->db->get_where('Ev_Repeat_Schedule',$data);
			return $get_sp_name->result();
		}

		public function get_res_count($ev_rep_id){
			
			$data = array('Ev_Rep_ID'=>$ev_rep_id, 'Ev_status' => 'Accept');
			$get_sp_name = $this->db->get_where('Ev_Inv_Status',$data);
			return $get_sp_name->num_rows();
		}


		public function get_event_name($ev_id){
			
			$data = array('Ev_Type_ID'=>$ev_id);
			$get_sp_name = $this->db->get_where('Events_Type',$data);
			return $get_sp_name->row_array();
		}

		public function get_location_name($loc_id){
			
			$data = array('Loc_id'=>$loc_id);
			$get_sp_name = $this->db->get_where('Events_Locations',$data);
			return $get_sp_name->row_array();
		}


		public function get_sport_title($sport_id){
			
			$data = array('SportsType_ID'=>$sport_id);
			$get_sp_name = $this->db->get_where('SportsType',$data);
			return $get_sp_name->row_array();
		}

		public function upd_status(){

			$user = $this->session->userdata('users_id');
			$event_id = $this->input->post('event_id');

			$rep_id = $this->input->post('ev_rep_ids');
			$stat = $this->input->post('upd_avail_list');

		/*	$user = $this->session->userdata('users_id');
			$event_id = $this->input->post('event_id');

			$rep_id = $this->input->post('ev_rep');
			$stat = $this->input->post('stat_val');*/


			foreach($rep_id as $i=>$rp){

				switch($stat[$i]){

				case 1: $status = 'Accept'; break;
				case 2: $status = 'Decline'; break;
				case 3: $status = 'Tentative'; break;
				case 4: $status = 'Pending'; break;

				}
				
			$data = array('Ev_status' => $status);
			$this->db->where(array('Ev_Rep_ID'=>$rep_id[$i], 'Users_Id'=>$user));
			$exe_qry = $this->db->update('Ev_Inv_Status', $data);
			}

			return $exe_qry;

		}

		public function search_sport_users($data){

			$lat = $data['latitude'];
			$long = $data['longitude'];

			$sport_id = $data['sport_id'];
			$gender = $data['gender'];
			$age_group = $data['age_group'];
			$level = $data['level'];
			$range = $data['range'];
			$org_id = $data['org_id'];

			$gend_cond = "";
			if($gender=='M'){
				$gend_cond .= " AND Gender = '1'";
			}
			else if($gender=='F'){
				$gend_cond .= " AND Gender = '0'";
			}else if($gender=='all'){
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
		public function get_rep_sch_det($ev_rep_id)
		{
			$data = array('Ev_Tab_ID'=>$ev_rep_id);
			$get_level = $this->db->get_where('Ev_Repeat_Schedule',$data);
			return $get_level->row_array();
		}

		public function check_is_invited($ev_id){
			
			$data = array('Ev_ID' => $ev_id, 'Users_Id' => $this->session->userdata('users_id'));

			$get_ev_rep = $this->db->get_where('Ev_Inv_Status',$data);
			return $get_ev_rep->result();
		}

		public function check_is_valid_actcode($act_code){
			
			$data = array('Act_Code' => $act_code);
			$get_ev = $this->db->get_where('Ev_Inv_List',$data);
			return $get_ev->row_array();
		}

		public function get_children($user_id)
		{

			$data = array('Users_ID'=>$user_id ,'Issociallogin'=>0);
			$query = $this->db->get_where('users',$data);
			return $query->result();
			
		}

		public function get_child_accounts($user_id)
		{

			$qry = $this->db->query("select * from Users where Users_ID in (select Users_ID from Users_ref where Ref_ID = $user_id)");

			return $qry->result();
		}

		public function check_is_invited_user($data){
			
			$user_id = $data['user'];
			$event_id = $data['event_id'];

			$data = array('Ev_ID' => $event_id, 'Users_Id' => $user_id);
			$get_ev_rep = $this->db->get_where('Ev_Inv_Status',$data);
			return $get_ev_rep->result();
		}

		public function is_have_players($ev_id){

			$data = array('Ev_ID' => $ev_id);

			$get_ev_rep = $this->db->get_where('Ev_Inv_Status',$data);
			
			return $get_ev_rep->num_rows;

		}

		public function get_user_sch($ev_id, $user_id){
			
			$data = array('Ev_ID' => $ev_id, 'Users_Id' => $user_id);

			$get_ev_rep = $this->db->get_where('Ev_Inv_Status',$data);
			return $get_ev_rep->result();
		}

		public function get_ev_users($ev_id){
			
			$data = array('Ev_ID' => $ev_id);

			$this->db->select('Users_Id');
			$this->db->group_by("Users_Id");
			$get_ev_usrs = $this->db->get_where('Ev_Inv_Status',$data);

			return $get_ev_usrs->result();
		}

		public function get_ev_comments($ev_id){
			
			$data = array('Ev_Id' => $ev_id);

			$this->db->select('*');
			$this->db->order_by("Comment_date",'desc');
			$get_ev_usrs = $this->db->get_where('Ev_User_Comments',$data);

			return $get_ev_usrs->result();
		}

		public function get_ev_reps($ev_id){
			
			$data = array('Ev_ID' => $ev_id);

			$get_ev_rep = $this->db->get_where('Ev_Repeat_Schedule',$data);

			return $get_ev_rep->result();
		}

		public function search_autocomplete($data)
		{
			
			$key = $data['key'];
			
			$this->db->select('*');
			$this->db->from('Events_Locations');
			$this->db->like('loc_title', $key); 
			
			$query = $this->db->get();
			return $query->result();
			
		}

		public function insert_event_images($fileName)
		{
				
			$user_id = $this->session->userdata('users_id');
			$ev_id = $this->input->post('ev_id');
			$upload_date = date("Y-m-d");
	 
			$data = array(

				'Image_file '	=> $fileName,
				'Ev_id'	=> $ev_id,
				'Upload_date'	=> $upload_date,
				'Users_id'	=> $user_id
			);
	 
			$this->db->insert('Event_Images', $data); 
		}

		public function get_individual_event_images($ev_id){
			$data = array('Ev_id'=>$ev_id);
			$query = $this->db->get_where('Event_Images',$data);
			return $query->result();
		}

		public function get_pay_status($ev_id, $users_id){
			$data = array('mtype_ref'=>$ev_id, 'Users_ID' => $users_id);
			$query = $this->db->get_where('PayTransactions', $data);
			return $query->row_array();
		}
	
		public function get_ts_count($ts, $ev_id){
			$qry = $this->db->query("SELECT count(*) as ts_count FROM Users WHERE TShirt_Size = {$ts} AND Users_ID IN (SELECT Users_Id from Ev_Inv_Status WHERE Ev_ID = $ev_id)");
			return $qry->row_array();
		}
	
}