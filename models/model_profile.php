<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

	class Model_profile extends CI_Model {

		public function __construct()
		{
			parent:: __construct();
			$this->load->database();

		//	$this->load->helper(array('form','url'));
		}
		
		public function get_user_data()
		{
			
			$username = $this->session->userdata('username');
			$email_id = $this->session->userdata('email');

			$user_id = $this->session->userdata('users_id');
			// email or username combination
			$query = $this->db->query("SELECT * FROM Users WHERE Users_ID = '$user_id'");
			
			return $query->row_array();

		}

		public function get_user_details($uid)
		{
			$query = $this->db->query("SELECT * FROM Users WHERE Users_ID = '$uid'");	
			return $query->row_array();
		}


		public function get_social_user_data()
		{
			$social_id = $this->session->userdata('social_id');
			$data = array('Socialactid'=>$social_id);
			
			$qry_check = $this->db->get_where('users', $data);
			return $qry_check->row_array();
		}

		public function check_username($user_name)
		{

			$data = array('Username'=> $user_name);
			$result = $this->db->get_where('Users',$data);

			if ($result->num_rows > 0)
			 {
				 return true;
			 }
			else 
			{
				return false;
			}
			
		}

		public function insert_player_data($data)  // Inserting a new player(child) details 
		{
			
			$lat_long = $data['latt'];
			$pieces = explode("@", $lat_long);

			$user_image = $data['profile_pic_data'];
			$profile_pic = $user_image['file_name'];
			
			$latitude = $pieces[0];
			$longitude = $pieces[1];

			//$data = $this->upload->data();
			//$profile_pic = $data['file_name'];
	
			$firstname = $this->input->post('Firstname');
			$lastname = $this->input->post('Lastname');

			$username = $this->input->post('user_name');

			$password = md5($this->input->post('Password'));

			$gender = $this->input->post('Gender');
			$alteremail = $this->input->post('AlternateEmailID');

			/*$month = $this->input->post('db_month');
			$day = $this->input->post('db_day');
			$year = $this->input->post('db_year');

			$dob = $year . '-' . $month . '-' . $day;*/

			$dob = date('Y-m-d', strtotime($this->input->post('txt_dob')));
			
			$birthdate = new DateTime($dob);
			$today   = new DateTime('today');
			$age = $birthdate->diff($today)->y;
			
			switch (true) {
                case $age <= 9:
                   $age_group = "U9";
                   break;
                case $age == 10:
                   $age_group = "U10";
                   break;
                case $age == 11:
                   $age_group = "U11";
                   break;
                case $age == 12:
                   $age_group = "U12";
                   break;
                case $age == 13:
                   $age_group = "U13";
                   break;
                case $age == 14:
                   $age_group = "U14";
                   break;
                case $age == 15:
                   $age_group = "U15";
                   break;
                case $age == 16:
	               $age_group = "U16";
	               break;
                case $age == 17:
                   $age_group = "U17";
                   break;
                case $age == 18:
                   $age_group = "U18";
                   break;
                case $age == 19:
                   $age_group = "U19";
                   break;
				case $age == 21:
                   $age_group = "U21";
                   break;
                default:
                   $age_group = "Adults";
                   break;
			}


			$hphone = $this->input->post('HomePhone');
			$mphone = $this->input->post('Mobilephone');

			$address1 = $this->input->post('UserAddressline1');
			$address2 = $this->input->post('UserAddressline2');

			$country = $this->input->post('CountryName');

			if($country == 'United States of America') {
				$state = $this->input->post('StateName');
			} else {
				$state = $this->input->post('StateName1');
			}

			$city = $this->input->post('CityName');
		
			$zip = $this->input->post('Zipcode');
			
			$reg_date = date("Y-m-d h:i:s");

			$issocial = 0;
			$is_user_activation = 1;
			$is_profile_updated = 1;

			$notify_settings = '["1","2"]';
			
			
			$data = array(
					'Firstname' => $firstname,
					'Lastname' => $lastname,
					'Password' => $password,
					'Username' => $username,
					'Gender' => $gender,
				    'AlternateEmailID' => $alteremail,
					'DOB' => $dob,
					'Profilepic' => $profile_pic,
					'HomePhone' => $hphone,
					'Mobilephone' => $mphone,
					'UserAddressline1' => $address1,
					'UserAddressline2' => $address2,
					'Country' => $country,
					'State' => $state,
					'City' => $city,
					'Zipcode' => $zip,
					'Latitude' => $latitude,
					'Longitude' => $longitude,
					'IsUserActivation' => $is_user_activation,
					'Issociallogin' => $issocial,
					'RegistrationDtTm' => $reg_date ,
					'IsProfileUpdated' => $is_profile_updated,
					'UserAgegroup' => $age_group,
					'NotifySettings' => $notify_settings
				);


			$this->db->insert('Users', $data);

		    $insert_id = $this->db->insert_id();
			
			$types = $this->input->post('Sportsintrests');

			if(sizeof($types) > 0 ){
				foreach($types as $type){

						 $data = array('Sport_id'=>$type,'users_id'=>$insert_id);
						 $this->db->insert('Sports_Interests', $data); 
						
				    }

			}

			$sports = array("1", "2", "3", "4","5","6","7","8","9","19","20");           // these numbers belongs to sport id in the SportType Table

			foreach($sports as $type){
			$def_score = 100;
			if($type == '2')
			$def_score = 800;
			if($type == '7' or $type == '19' or $type == '20')
			$def_score = 3.0;

				$data = array('SportsType_ID' => $type, 
							  'Users_ID'	  => $insert_id, 
							  'A2MScore'	  => $def_score,
							  'A2MScore_Doubles' => $def_score, 
							  'A2MScore_Mixed'   => $def_score
							 );

				$this->db->insert('A2MScore', $data); 
						
		    }

			$user_id = $this->session->userdata('users_id');
			$data = array(
					'Users_ID'=> $insert_id,
					'Ref_ID' => $user_id
			);
			$this->db->insert('Users_ref', $data); 
     
			$data = array('Users_ID'=>$insert_id);
		
			return  $data;
			
		}


		public function insert_fbprofile_data($data)   // Update the user profile ( FACE BOOK User )
		{
			$user_image = $data['profile_pic_data'];
			$filename = $user_image['file_name'];
			
			$social_id = $this->session->userdata('social_id');
			$user_id = $this->session->userdata('users_id');

			$lat_long = $data['latt'];
			$pieces = explode("@", $lat_long);
			
			$latitude = $pieces[0];
			$longitude = $pieces[1];

			//print_r($user_id);
			//exit;
			$username	= $this->input->post('username');
			$firstname	= $this->input->post('Firstname');
			$lastname	= $this->input->post('Lastname');
			$email		= $this->input->post('EmailID');
			$alteremail = $this->input->post('AlternateEmailID');

			$gender		= $this->input->post('Gender');
			
			/*
			$month = $this->input->post('db_month');
			$day = $this->input->post('db_day');
			$year = $this->input->post('db_year');

			$dob = $year . '-' . $month . '-' . $day;
			*/

			$dob		= $this->input->post('txt_dob');

			$birthdate	= new DateTime($dob);
			$today		= new DateTime('today');
			$age		= $birthdate->diff($today)->y;
			
			if ($age <= 12){ 
				$age_group = "U12";
			}
			else if ($age <= 14){
				$age_group = "U14";
			} 
			else if ($age <= 16){
				$age_group = "U16";
			}
			else if($age <= 18){
				$age_group = "U18";
			}
			else{
				$age_group = "Adults";
			}


			$hphone = $this->input->post('HomePhone');
			$mphone = $this->input->post('Mobilephone');

			$address1 = $this->input->post('UserAddressline1');
			$address2 = $this->input->post('UserAddressline2');

			$country = $this->input->post('CountryName');
			if($country == 'United States of America') {
				$state = $this->input->post('StateName');
			} else {
				$state = $this->input->post('StateName1');
			}

			$city	= $this->input->post('CityName');
			$zip	= $this->input->post('Zipcode');


			$types = array();
			$types = $this->input->post('Sportsintrests');

			if(count(array_filter($types)) > 0 ){
				foreach($types as $type){

						 $data = array('Sport_id'=>$type,'users_id'=>$user_id);
						 $this->db->insert('Sports_Interests', $data); 
			    }
			}


			/* Code to check the Basic Required field are filled or not to make status of is_profile_updated to set 1 or 0 */
			$required = array('EmailID', 'UserAddressline1', 'CountryName', 'StateName', 'CityName', 'Zipcode', 'Sportsintrests');

				// Loop over field names, make sure each one exists and is not empty
				$status = true;
				
				foreach($required as $field) {
				  if(empty($this->input->post($field))) {
					$status = false;
				  }
				}

				if($status) {
				  $is_profile_updated = 1;
				} else {
				  $is_profile_updated = 0;
				}

			/*  End of Code to check the Basic Required fields */
			
			//$data = $this->upload->data();
			//$filename = $data['file_name'];

			$notify_settings = '["1","2"]';

			$data = array (
					'UserProfileName'	=> $username,
					'Firstname'			=> $firstname,
					'Lastname'			=> $lastname,
					'EmailID'			=> $email,
					'AlternateEmailID'	=> $alteremail,
					'Gender'			=> $gender,
					'DOB'				=> $dob,
					'Profilepic'		=> $filename,
					'HomePhone'			=> $hphone,
					'Mobilephone'		=> $mphone,
					'UserAddressline1'	=> $address1,
					'UserAddressline2'	=> $address2,
					'Latitude'			=> $latitude,
					'Longitude'			=> $longitude,
					'Country'			=> $country,
					'State'				=> $state,
					'City'				=> $city,
					'Zipcode'			=> $zip,
					'IsProfileUpdated'	=> $is_profile_updated,
					'NotifySettings'	=> $notify_settings
				);

				$this->db->where('Socialactid', $social_id);
			    $res = $this->db->update('Users', $data); 
				
				//$res = array('user'=>$firstname." ".$lastname, 'email'=>$email,
				//				'users_id'=>$user_id, 'lat'=>$latitude,'long'=>$longitude);
		
				return $res;
		}

		
		public function update_profile_data($data)
		{
			$lat_long	= $data['latt'];
			$pieces		= explode("@", $lat_long);
			
			$latitude	= $pieces[0];
			$longitude = $pieces[1];
			
			
			$user_id = $this->session->userdata('users_id');
	
			$firstname = $this->input->post('fname');
			$lastname = $this->input->post('lname');
			
			$email_id		= $this->input->post('email');
			$alteremail	= $this->input->post('alter_email');

			$this->session->set_userdata(array('user' => $firstname." ".$lastname));

			/*$month = $this->input->post('db_month');
			$day = $this->input->post('db_day');
			$year = $this->input->post('db_year');
			
			$dob = $year . '-' . $month . '-' . $day;
			*/
			$user_dob = NULL;
			if($this->input->post('txt_dob')){
				$dob			= $this->input->post('txt_dob');
				$user_dob = date('Y-m-d', strtotime($dob));
				$birthdate	= new DateTime($dob);
				$today		= new DateTime('today');
				$age			= $birthdate->diff($today)->y;

				switch ($age) {
					case $age <= 9:
					   $age_group = "U9";
					   break;
					case $age == 10:
					   $age_group = "U10";
					   break;
					case $age == 11:
					   $age_group = "U11";
					   break;
					case $age == 12:
					   $age_group = "U12";
					   break;
					case $age == 13:
					   $age_group = "U13";
					   break;
					case $age == 14:
					   $age_group = "U14";
					   break;
					case $age == 15:
					   $age_group = "U15";
					   break;
					case $age == 16:
					   $age_group = "U16";
					   break;
					case $age == 17:
					   $age_group = "U17";
					   break;
					case $age == 18:
					   $age_group = "U18";
					   break;
					case $age == 19:
					   $age_group = "U19";
					   break;
					case $age == 21:
					   $age_group = "U21";
					   break;
					case $age > 21:
					   $age_group = "Adults";
					   break;
				}
			}

			$school = "";

			if($this->input->post('txt_school')){
			$school = $this->input->post('txt_school');
			}
			
			$gender = $this->input->post('txt_gender');

			$address1 = $this->input->post('UserAddressline1');
			$address2 = $this->input->post('UserAddressline2');

			$country = $this->input->post('CountryName');

			if($country == 'United States of America') {
				$state = $this->input->post('StateName');
			} else {
				$state = $this->input->post('StateName1');
			}

			$city	= $this->input->post('CityName');
			$zip	= $this->input->post('zipcode');

			$hphone = $this->input->post('hphone');

			$mphone = NULL;
			if($this->input->post('mphone')){
			$mphone = str_replace('(', '', $this->input->post('mphone'));
			$mphone = str_replace(')', '', $mphone);
			$mphone = str_replace('-', '', $mphone);
			}
			$prefer = json_encode($_POST['pref']);

			$data = array(
					'Firstname'			=> $firstname,
					'Lastname'			=> $lastname,
					'AlternateEmailID'	=> $alteremail,
					'Gender'				=> $gender,
					'DOB'					=> $user_dob,
					'HomePhone'		=> $hphone,
					'Mobilephone'		=> $mphone,
					'UserAddressline1'	=> $address1,
					'UserAddressline2'	=> $address2,
					'Country'			=> $country,
					'State'				=> $state,
					'City'					=> $city,
					'Latitude'			=> $latitude,
					'Longitude'		=> $longitude,
					'Zipcode'			=> $zip,
					'UserAgegroup'	=> $age_group,
					'NotifySettings'	=> $prefer,
					'School_Info'		=> $school
					);
			
			/*echo "<pre>";
			print_r($data);
			exit;*/
			$get_user_qry = $this->db->query("SELECT * FROM Users WHERE Users_ID = {$user_id}");
			$get_user			= $get_user_qry->row_array();
			
			if(!$get_user['EmailID']) {
				$data['EmailID'] = $email_id;
			}
//echo "<pre>"; print_r($data); print_r($get_user); exit;
			$this->db->where('Users_ID', $user_id);
			$result = $this->db->update('Users', $data); 
		
			return $result;
		}

		public function update_profile_user_sport()
		{
			
			$user_id = $this->session->userdata('users_id');

			$sports_intrests = $this->input->post('Sportsintrests');


			//print_r($sports_intrests);
			//exit;

			//$data = array('users_id'=>$user_id);

			$this->db->where('users_id', $user_id);
			$this->db->delete('Sports_Interests'); 
			//$query = $this->db->delete('Sports_Interests',$data)
			

			$i=1;
			foreach($sports_intrests as $sp_int)
			{

				$sport_level = $this->input->post("sport_level_$sp_int");

			//	$data = array(
				//	'Sport_id' => $sp_int,
				//	'users_id' => $user_id
				//	);

				//$check_sp = $this->db->get_where('Sports_Interests',$data);

						$data = array (
						'Sport_id' => $sp_int,
						'Level' => $sport_level,
						'users_id' => $user_id);

			//	if($check_sp->num_rows == 0){

					$result = $this->db->insert('Sports_Interests', $data); 
				//}
			//	else
			//	{
			//		$data = array('Level'=>$sport_level);
//
				//	$this->db->where('users_id',$user_id);
			//		$this->db->where('Sport_id',$sp_int);
				//	$result = $this->db->update('Sports_Interests', $data); 
				//}
			$i++;	
			}
		return true;
		}


		public function get_user_id()
		{
			$user_id = $this->session->userdata('users_id');
			$data = array('Users_ID'=>$user_id);
			
			$qry_check = $this->db->get_where('users', $data);
			return $qry_check->row_array();
		}

		public function update_picture($data)
		{
			
			$user_id = $this->session->userdata('users_id');
			
			//$user_image = $data['profile_pic_data'];
			//$profile_pic = $user_image['file_name'];
			
			$profile_pic = $data['file_name'];

			//$data = $this->upload->data();
			//$filename = $data['file_name'];
			
			$data = array('Profilepic'=>$profile_pic);

			$this->db->where('Users_ID', $user_id);
			$result = $this->db->update('Users', $data); 
		
			return $result;
		}

		public function check_oldPass($old_password)
		{
			
			$user_id = $this->session->userdata('users_id');
			$data = array('Users_ID' =>$user_id);

			$qry_check = $this->db->get_where('users', $data);
		
			if($qry_check->num_rows > 0){
			  $row = $qry_check->row();
			  if($old_password == $row->Password){
				return true;
			  }else{
				return false;
			  }
			}
		}

		public function save_newPass($new_pass) {
		    $user_id = $this->session->userdata('users_id');
			$data = array('Password' =>$new_pass);

			$this->db->where('Users_ID', $user_id);
			$result = $this->db->update('Users', $data); 
			
			return $result;
		}

		public function save_newEmail($new_email) {
		    $user_id = $this->session->userdata('users_id');
			$data = array('EmailID' =>$new_email);

			$this->db->where('Users_ID', $user_id);
			$result = $this->db->update('Users', $data); 
			
			return $result;
		}
	
		public function add_membership_details()
		{
		    $user_id = $this->session->userdata('users_id');
			
			$org_id = $this->input->post('org_id');
			$mem_id = $this->input->post('member_id');
			$related_sport = $this->input->post('club_sport');

			$data = array(
					'Club_id'		=> $org_id,
					'Membership_ID' => $mem_id,
					'Users_id'		=> $user_id,
					'Related_Sport'	=> $related_sport,
					'Member_Status'	=> 0
				    );

			$result = $this->db->insert('User_memberships', $data);

			return $result;
		}

	    public function get_user_usatt_rating($membership_id){
			$user_id  = $this->session->userdata('users_id');
			$get_user = $this->get_user_details($user_id);

			$fname = $get_user['Firstname'];
			$lname = $get_user['Lastname'];
			$dob   = date('Y-m-d', strtotime($get_user['DOB']));

			$query = $this->db->query("SELECT * FROM USATTMembership WHERE Member_ID = '{$membership_id}' AND [First Name] = '{$fname}' AND [Last Name] = '{$lname}' AND [Date of Birth] = '{$dob}' ");
//secho $this->db->last_query(); exit;
			return $query->row_array();
		}

		public function update_membership_details()
		{
		    $user_id = $this->session->userdata('users_id');
			
			$org_id			 = $this->input->post('org_id');
			$club_name	 = $this->input->post('club_name');
			$mem_id		 = $this->input->post('member_id');
			$related_sport = $this->input->post('club_sport');

			$tab_id		= $this->input->post('tab_id');

			$query		= $this->db->query("SELECT * FROM Academy_Info WHERE Aca_ID = '{$org_id}'");
			$aca_row	= $query->row_array();
			
			$club_primary_sport = $aca_row['Primary_Sport'];

			if($club_primary_sport){
				$query2 = $this->db->query("SELECT * FROM A2MScore WHERE 
				Users_ID = '{$user_id}' AND 'SportsType_ID' = {$club_primary_sport}");

				//$prev_a2m	= $query2->row_array();
				if ($query2 !== FALSE)
				{
					if($query2->num_rows() == 0) {
						$def_score = 100;
						if($club_primary_sport == '2')
							$def_score = 800;
						if($club_primary_sport == '7' or $club_primary_sport == '19' or $club_primary_sport == '20')
							$def_score = 3.0;

						$data2 = array(
								'Users_ID'				 => $user_id, 
								'SportsType_ID'		 => $club_primary_sport, 
								'A2MScore'				 => $def_score, 
								'A2MScore_Doubles' => $def_score, 
								'A2MScore_Mixed'	 => $def_score
								);

						$ins_a2m = $this->db->insert('A2MScore', $data2);
					}
				}
			}

			$data = array(
						'Club_id'				=> $org_id,
						'Membership_ID'	=> $mem_id,
						'Users_id'				=> $user_id,
						'Related_Sport'		=> $related_sport,
						'Member_Status'	=> 0
						);

			//print_r($data);
			//exit;
			$result = array();

			if($club_name == 'USATT' or $club_name == 'usatt') {
				$result = $this->get_user_usatt_rating($mem_id);
			
				if(count($result) > 0) {
							  $this->db->where('tab_id', $tab_id);
					$res = $this->db->update('User_memberships', $data);
				}
				else {
					$res = -1;
				}
			}
			else {
						  $this->db->where('tab_id', $tab_id);
				$res = $this->db->update('User_memberships', $data);
			}

			return $res;
		}

		public function update_coach_details()
		{
		    $user_id	= $this->session->userdata('users_id');
			
			$coach_web	   = $this->input->post('coach_web');
			$coach_profile = $this->input->post('coach_profile');
			$related_sport = $this->input->post('sport_coach');
			$coach_club	   = $this->input->post('org_id');
			$is_coach	   = 1;

			$data = array(
					'Coach_Website' => $coach_web,
					'Is_coach'		=> $is_coach,
					'coach_profile'	=> $coach_profile,
					'coach_sport'	=> $related_sport,
					'coach_academy'	=> $coach_club
				    );

			$this->db->where('Users_ID', $user_id);
			$result = $this->db->update('Users', $data);

			return $result;
		}

		public function delete_coach_details()
		{
		    $user_id = $this->session->userdata('users_id');
			
			$coach_web = 'NULL';
			$coach = NULL;
			$coach_profile = 'NULL';
			$related_sport = 'NULL';

			$data = array(
					'Is_coach' => $coach,
					'Coach_Website' => $coach_web,
					'coach_profile'=> $coach_profile,
					'coach_sport'=> $related_sport
				    );

			$this->db->where('Users_ID', $user_id);
			$result = $this->db->update('Users', $data);
			
			return $result;
		}

		public function get_club_details($data) {
			$tab_id = $data['tab_id'];
			$user_id = $data['user_id'];

			$data = array('tab_id'=>$tab_id, 'Users_id'=>$user_id);
			$qry_check = $this->db->get_where('User_memberships', $data);
			return $qry_check->row_array();
		
		}

		public function delete_membership() {
			
			$user_id = $this->session->userdata('users_id');
			$tab_ids = $this->input->post('sel_org_id');
	
			foreach($tab_ids as $tab_id) {
				$this->db->where('tab_id', $tab_id);
				$this->db->delete('User_memberships'); 

			}	
		}

		public function get_club_name($org_id)
		{
			$data = array('Aca_ID'=>$org_id);
			$qry_check = $this->db->get_where('Academy_Info', $data);
			return $qry_check->row_array();
		}

		public function get_intrests()
		{
			$query = $this->db->get('SportsType');
			return $query->result();
		}

		public function get_user_sport_intrests($user_id = '')
		{
			if(!$user_id)
			$user_id = $this->session->userdata('users_id');

			$data = array('users_id'=>$user_id);
			$qry_check = $this->db->get_where('Sports_Interests', $data);
			return $qry_check->result();
		}

		public function get_sport_levels($sport_id)
		{
			$data = array('SportsType_ID'=>$sport_id, 'SL_Status'=>1);
			$qry_check = $this->db->get_where('SportsLevels', $data);
			return $qry_check->result();
		}

		
		public function get_user_matches()
		{

			$user_id = $this->session->userdata('users_id');

			//$data = array('users_id'=>$user_id);

			//$qry_check = $this->db->query(" SELECT * FROM IndividualPlay WHERE Opponent = $user_id OR GeneralMatch_ID IN 

			//(SELECT GeneralMatch_id FROM GeneralMatch WHERE users_id = {$user_id}) ORDER BY Play_Date ASC");

			$qr_check = $this->db->query(" SELECT * from IndividualPlay where (Opponent = $user_id OR GeneralMatch_ID IN (SELECT GeneralMatch_id FROM GeneralMatch WHERE users_id = $user_id)) AND  Winner IS NOT NULL ORDER BY Play_Date DESC");

			return $qr_check->result();
		}

		public function get_user_tournment_matches()
		{
		    $user_id = $this->session->userdata('users_id');	
		
			$qr_check = $this->db->query(" SELECT * from Tournament_Matches where (Player1 = $user_id or Player2 = $user_id or Player1_Partner = $user_id or Player2_Partner = $user_id) AND Winner != 0 ORDER BY Match_Date DESC");

			return $qr_check->result();

	    }

		public function get_user_tournment_team_matches()
		{
		    $user_id = $this->session->userdata('users_id');	
		
			$qr_check = $this->db->query(" SELECT * from Tournament_Lines where (Player1 = $user_id or Player2 = $user_id or Player1_Partner = $user_id or Player2_Partner = $user_id) AND Winner != 0 ORDER BY Match_Date DESC");

			return $qr_check->result();
	    }


		public function get_num_matches()
		{

			$user_id = $this->session->userdata('users_id');

			$qr_check = $this->db->query("SELECT n.Users_ID,n.Num_Matches, n.Sport, n.Won, n.Lost, n.Win_Per, a.* from a2mscore a 
			left join Player_Matches_Count n on (n.Users_ID = a.Users_ID and n.Sport = a.SportsType_ID) where a.Users_ID = $user_id");
			
			return $qr_check->result();
		}

		public function get_membership_details()
		{

			$user_id = $this->session->userdata('users_id');

			//$qr_check = $this->db->query("SELECT * FROM Academy_Users where Users_id = $user_id");
			$qr_check = $this->db->query("SELECT * FROM User_memberships where Users_id = $user_id");
			
			return $qr_check->result();
		}


		public function get_gen_mat_det($gen_mat_id)
		{
			$data = array('GeneralMatch_id'=>$gen_mat_id);
			
			$qry_check = $this->db->get_where('GeneralMatch', $data);
			return $qry_check->row_array();
		}

		public function get_tourn_name($tourn_id)
		{
			$data = array('tournament_ID'=>$tourn_id);
			
			$qry_check = $this->db->get_where('tournament', $data);
			return $qry_check->row_array();
		}

		/*public function get_club($org_id)
		{
			$data = array('Org_ID'=>$org_id);
			
			$qry_check = $this->db->get_where('Academy', $data);
			return $qry_check->row_array();
		}*/

		public function get_club($org_id)
		{
			$data = array('Aca_ID'=>$org_id);
			
			$qry_check = $this->db->get_where('Academy_Info', $data);
			return $qry_check->row_array();
		}

		public function get_clubs()
		{		
			$qry_check = $this->db->get('Academy_Info');
			return $qry_check->result();
		}

		public function get_a2msocre($sport,$user_id)
		{
			$data = array('SportsType_ID'=>$sport , 'Users_ID'=>$user_id);
			$get_level = $this->db->get_where('A2MScore',$data);
			return $get_level->row_array();
		}

		public function get_winper($sport, $user_id){
			$data		= array('Sport'=>$sport , 'Users_ID'=>$user_id);
			$get_level  = $this->db->get_where('Player_Matches_Count',$data);
			return $get_level->row_array();
		}

		public function get_user_single_stats($user_id, $sp_intrests){
		
			if($sp_intrests != '()'){
				$qr_check = $this->db->query("SELECT t.SportsType,* FROM Tournament_Matches AS tm JOIN tournament AS t ON t.tournament_ID = tm.Tourn_ID WHERE t.SportsType IN {$sp_intrests} AND (tm.Player1 = {$user_id} OR tm.Player1_Partner = {$user_id} OR tm.Player2 = {$user_id} OR tm.Player2_Partner = {$user_id}) ORDER BY t.SportsType");
			}
			else{
				$qr_check = $this->db->query("SELECT t.SportsType,* FROM Tournament_Matches AS tm JOIN tournament AS t ON t.tournament_ID = tm.Tourn_ID WHERE tm.Player1 = {$user_id} OR tm.Player1_Partner = {$user_id} OR tm.Player2 = {$user_id} OR tm.Player2_Partner = {$user_id} ORDER BY t.SportsType");
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

	public function basketball_matches($user_id){
		$qr_check = $this->db->query("select * from RegisterTournament where Team_Players like '%".'"'.$user_id.'"'."%' and Tournament_ID in (select tournament_ID from tournament where SportsType = 18)");
		return $qr_check->num_rows();
	}

}