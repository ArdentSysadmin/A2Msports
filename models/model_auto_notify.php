<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

	class model_auto_notify extends CI_Model {
	
		public function __construct(){
			parent:: __construct();
		}

		public function get_tour_notifications(){

			$this->db->select('*');
			$this->db->where('mtype =', 'Tournament');
			$this->db->where('is_notified =', 0);

			$query = $this->db->get('Notification_Alerts');
			return $query->result();
		}

		public function get_news_notifications(){

			$this->db->select('*');
			$this->db->where('mtype =', 'News');
			$this->db->where('is_notified =', 0);

			$query = $this->db->get('Notification_Alerts');
			return $query->result();
		}

		public function update_notif_stat($nid){
			$cur_date = date('Y-m-d H:i');
			$data = array('is_notified' => 1,
						  'notified_on' => $cur_date);

			$this->db->where('nid', $nid);
			$result = $this->db->update('Notification_Alerts', $data); 
		}

		public function UpdateDOB($user_id, $agegroup){
			
			$data = array('UserAgegroup' => $agegroup);

			$this->db->where('Users_ID', $user_id);
			$result = $this->db->update('Users', $data); 
		}

		public function get_rel_users($sport){

			/* Getting Users that are intrested in selected Sports */
			
			//$notify_set_cond = " WHERE NotifySettings LIKE '["1"]'";
			
			$sport_cond = "";
			
			if(intval($sport) != -1)
			{ $sport_cond = " WHERE Sport_id = $sport"; }
			else
			{ $sport_cond = " GROUP BY users_id"; }
			  
			 $qry_get_users = $this->db->query("SELECT users_id FROM Sports_Interests".$sport_cond);

			 return $qry_get_users->result();
		}

		public function get_aca_users($org_id){
			$data = array('Org_id' => $org_id);
			$get_users = $this->db->get_where('Academy_users', $data);
			return $get_users->result();
		}

		/*public function get_sport_users($sport_id, $country, $state){  

			$qry_check = $this->db->query("SELECT u.Users_ID,u.Firstname,u.Lastname, u.EmailID FROM Users u inner join Sports_Interests s on u.Users_ID = s.users_id WHERE u.Country = '$country' AND u.State IS NULL AND s.Sport_id = $sport_id AND u.NotifySettings like '%1%' ");
			
			return $qry_check->result();
		}*/

		public function get_sport_users($data){

			$lat	  = $data['lat'];
			$long	  = $data['long'];
			$range	  = number_format($data['range'], 2);
			$sport_id = $data['sport'];
			$country  = $data['country'];
			$state	  = $data['state'];

			if($lat == 0 or $long == 0){
				$qry_check = $this->db->query("SELECT u.Users_ID,u.Firstname,u.Lastname, u.EmailID FROM Users u inner join Sports_Interests s on u.Users_ID = s.users_id WHERE u.Country = '$country' AND u.State = '$state' AND s.Sport_id = $sport_id AND u.NotifySettings like '%1%' ");
			}
			else{
				/*$qry_check = $this->db->query("SELECT * FROM Users WHERE Users_ID IN (SELECT users_id FROM Sports_Interests WHERE Sport_id = {$sport_id})");*/

				$qry_check = $this->db->query("SELECT * FROM Users WHERE ACOS( SIN( RADIANS( Latitude )) * SIN( RADIANS( $lat ) ) + COS( RADIANS( Latitude ) ) * COS( RADIANS( $lat )) * COS( RADIANS( Longitude ) - RADIANS( $long )) ) * 3964.3 < {$range} AND Users_ID IN (SELECT users_id FROM Sports_Interests WHERE Sport_id = {$sport_id})");
			}

			//echo $this->db->last_query();
			return $qry_check->result();
		}

		public function get_rep_events(){
			$current_date = strtotime(date("Y-m-d"));
			//$current_time = strtotime(date("H:i"));
			//$pre_date = strtotime("+1 day", $current_date);

			//$event_on = date("Y-m-d",strtotime("+1 day", $current_date)); // +1 day
			$event_on = date("Y-m-d",strtotime("+0 day", $current_date));    // For Today


			//$event_on_time = date("H:i",strtotime("+1 hour", $current_time));
			
			$this->db->select('*');
			$this->db->from('Ev_Repeat_Schedule');
			$this->db->order_by("Ev_Date", "des");
			$this->db->where('Ev_Date =', $event_on);
			//$this->db->where('Ev_Start_Time >=', $current_time);
			//$this->db->where('Ev_Start_Time <=', $event_on_time);
			$query=$this->db->get();
			return $query->result();
		}

		public function get_rep_event_users($ev_id, $ev_rep_id){

			$data = array('Ev_ID' => $ev_id ,'Ev_Rep_ID' => $ev_rep_id, Ev_status => 'Accept');
			//$data = array('Ev_ID' => $ev_id ,'Ev_Rep_ID' => $ev_rep_id);
			$get_users = $this->db->get_where('Ev_Inv_Status',$data);
			return $get_users->result();
		
		}

		public function getonerow($ev_id){
			
			$data = array('Ev_ID'=>$ev_id);
			$get_sp_name = $this->db->get_where('Events',$data);
			return $get_sp_name->row_array();
		}

/* ---------------------------------- League Model Functions ------------------------------------------- */

		public function get_tourn_matches(){
			$current_date = strtotime(date("Y-m-d"));
			//$current_time = strtotime(date("H:i"));
			//$pre_date = strtotime("+1 day", $current_date);

			$match_due_on = date("Y-m-d", strtotime("+1 day", $current_date)); // +1 day
			//$event_on = date("Y-m-d",strtotime("+0 day", $current_date));    // For Today
			//$event_on_time = date("H:i",strtotime("+1 hour", $current_time));
			
			$this->db->select('*');
			$this->db->from('Tournament_Matches');
			$this->db->order_by("Match_DueDate", "des");
			$this->db->where('Match_DueDate =', $match_due_on." 00:00:00.000");
			$this->db->where('Winner =', 0);
			//$this->db->where('Ev_Start_Time >=', $current_time);
			//$this->db->where('Ev_Start_Time <=', $event_on_time);
			$query=$this->db->get();
			return $query->result();
		}

		public function get_tour_det($tour_id){
			
			$data = array('tournament_ID' => $tour_id);
			$get_tour = $this->db->get_where('Tournament',$data);
			return $get_tour->row_array();
		}

	/* ---------------------------------- League Model Functions ------------------------------------------------- */

		public function InsertUsersDetails($user_data){

						$data = array('EmailID' => "$user_data[2]");
			$check_user_exists = $this->db->get_where('Users', $data);

			if($check_user_exists->num_rows == 0)
			{
			$data = array('Firstname'        => $user_data[0], 
				          'Lastname'         => $user_data[1], 
				          'Password'         => '1c595da78501e4f2b5d18daa842418a7', 
				          'EmailID'          => $user_data[2], 
				          'Zipcode'          => '30024',
				          'Mobilephone'      => $user_data[3],
				          'Gender'           => $user_data[4],
				          'Issociallogin'    => '0',
				          'IsUserActivation' => '1',
				          'Latitude'         => '34.0425',
				          'Longitude'        => '-84.0262',
				          'IsProfileUpdated' => '0');
			
			echo "New User - ". $user_data[2]. "<br>";
			$result = $this->db->insert('Users', $data); 
			}
			else
			{
			echo "Existed User - ". $user_data[2]. "<br>";
			}
		}

		public function InsertChildDetails($user_data){

			$data = array('EmailID' => "$user_data[2]");
			$check_user_exists = $this->db->get_where('Users', $data);

			if($check_user_exists->num_rows == 0)
			{
			$data = array('Firstname'        => $user_data[0], 
				          'Lastname'         => $user_data[1], 
				          'Password'         => '1c595da78501e4f2b5d18daa842418a7', 
				          'EmailID'          => $user_data[2], 
				          'Zipcode'          => '30024',
				          'Mobilephone'      => $user_data[3],
				          'Gender'           => $user_data[4],
				          'Issociallogin'    => '0',
				          'IsUserActivation' => '1',
				          'Latitude'         => '34.0425',
				          'Longitude'        => '-84.0262',
				          'IsProfileUpdated' => '0');
			
			echo "New User - ". $user_data[2]. "<br>";
			$result = $this->db->insert('Users', $data); 
			}
			else
			{
				$get_user = $check_user_exists->row_array();
				$exist_user = $get_user['Users_ID'];

			$data = array('Firstname'        => $user_data[0], 
				          'Lastname'         => $user_data[1], 
				          'Password'         => '1c595da78501e4f2b5d18daa842418a7',
				          'AlternateEmailID' => $user_data[2], 
				          'Zipcode'          => '30024',
				          'Mobilephone'      => $user_data[3],
				          'Gender'           => $user_data[4],
				          'Issociallogin'    => '0',
				          'IsUserActivation' => '1',
						  'UserProfileName'  => $user_data[5],
				          'Latitude'         => '34.0425',
				          'Longitude'        => '-84.0262',
				          'IsProfileUpdated' => '0');
			
			$result  = $this->db->insert('Users', $data); 
			$last_id = $this->db->insert_id();

			$data	 = array('Users_ID' => $last_id, 
						     'Ref_ID'   => $exist_user);

			$result1 = $this->db->insert('Users_ref', $data); 
			 
			echo "Existed User $exist_user - ". $last_id. "<br>";
			}
		}

		public function InsertChildDetails2($user_data){

			$data = array('Firstname'        => $user_data[0], 
				          'Lastname'         => $user_data[1], 
				          'Password'         => '1c595da78501e4f2b5d18daa842418a7',
				          'AlternateEmailID' => $user_data[2], 
				          'Zipcode'          => '30024',
				          'Mobilephone'      => $user_data[3],
				          'Gender'           => $user_data[4],
				          'Issociallogin'    => '0',
				          'IsUserActivation' => '1',
						  'UserProfileName'  => $user_data[5],
				          'Latitude'         => '34.0425',
				          'Longitude'        => '-84.0262',
				          'IsProfileUpdated' => '0');
			//echo "<pre>"; print_r($data);
			//echo "New User - ". $user_data[2]. "<br>";
			$result  = $this->db->insert('Users', $data);
			$last_id = $this->db->insert_id();

			echo $user_data[0]." ".$user_data[1]." - ".$last_id;
		}


		public function InsertChildParentInfo($user_data){
			$data = array('Users_ID' => $user_data[0],
						  'Ref_ID'   => $user_data[1]);

			$result1  = $this->db->insert('Users_ref', $data); 
		}


		public function Get_tournmnetpartcpnts_Notfy(){
			$this->db->select('*');
			$this->db->where('is_notified =', 0);
			$query = $this->db->get('TAdmin_Messages_Players');
			return $query->result();
		}

		public function update_tm_prtcpnts_notif_stat($mid){
			$cur_date = date('Y-m-d H:i');
			$data = array('is_notified' => 1,
						  'notified_on' => $cur_date);

			$this->db->where('mid', $mid);
			$result = $this->db->update('TAdmin_Messages_Players', $data); 
		}

		public function GetPortal_AdmUsersNotfy(){
			$this->db->select('*');
			$this->db->where('is_notified =', 0);
			$query = $this->db->get('Portal_Admin_Messages');
			return $query->result();
		}

		/*public function UpdatePortal_AdmUsers_NotifyStat($mid, $success_arr, $is_notified){
			$cur_date = date('Y-m-d H:i');
			$notified_users = NULL;
			if(!empty($success_arr)){
				$notified_users = json_encode($success_arr);
			}
			$data = array('is_notified'			=> $is_notified,
						  'notified_to_players' => $notified_users,
						  'notified_on'			=> $cur_date);

			$this->db->where('mid', $mid);
			$result = $this->db->update('Portal_Admin_Messages', $data); 
		}*/

		public function UpdatePortal_AdmUsers_NotifyStat($data, $mid){
			$this->db->where('mid', $mid);
			$result = $this->db->update('Portal_Admin_Messages', $data); 
		}

	}