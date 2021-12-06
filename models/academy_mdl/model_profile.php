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

			$month = $this->input->post('db_month');
			$day = $this->input->post('db_day');
			$year = $this->input->post('db_year');

			$dob = $year . '-' . $month . '-' . $day;
			
			$birthdate = new DateTime($dob);
			$today   = new DateTime('today');
			$age = $birthdate->diff($today)->y;
			
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

			$sports = array("1", "2", "3", "4","5","6","7","8");           // these numbers belongs to sport id in the SportType Table

			foreach($sports as $type){
				$def_score = 100;
				if($type == '2') 
				$def_score = 800;
				if($type == '7') 
				$def_score = 3.0;
				$data = array('SportsType_ID'=>$type, 'Users_ID'=>$insert_id, 'A2MScore'=>$def_score, 'A2MScore_Doubles'=>$def_score, 'A2MScore_Mixed'=>$def_score);
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
			$lat_long = $data['latt'];
			$pieces = explode("@", $lat_long);
			
			$latitude = $pieces[0];
			$longitude = $pieces[1];
			
			
			$user_id = $this->session->userdata('users_id');
			
			$firstname = $this->input->post('fname');
			$lastname = $this->input->post('lname');
			
			$alteremail = $this->input->post('alter_email');

			/*$month = $this->input->post('db_month');
			$day = $this->input->post('db_day');
			$year = $this->input->post('db_year');
			
			$dob = $year . '-' . $month . '-' . $day;
			*/

			$dob = $this->input->post('txt_dob');

			$birthdate	= new DateTime($dob);
			$today		= new DateTime('today');
			$age		= $birthdate->diff($today)->y;

			echo $age."<br>";
			
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
			$mphone = $this->input->post('mphone');

			$prefer = json_encode($_POST['pref']);

			$data = array (
					'Firstname'			=> $firstname,
					'Lastname'			=> $lastname,
					'AlternateEmailID'	=> $alteremail,
					'DOB'				=> $dob,
					'HomePhone'			=> $hphone,
					'Mobilephone'		=> $mphone,
					'UserAddressline1'	=> $address1,
					'UserAddressline2'	=> $address2,
					'Country'			=> $country,
					'State'				=> $state,
					'City'				=> $city,
					'Latitude'			=> $latitude,
					'Longitude'			=> $longitude,
					'Zipcode'			=> $zip,
					'UserAgegroup'		=> $age_group,
					'NotifySettings'	=> $prefer
					);
			
			/*echo "<pre>";
			print_r($data);
			exit;*/

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
			
			$user_image = $data['profile_pic_data'];
			$profile_pic = $user_image['file_name'];

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

		public function save_newPass($new_pass)
		{
		    $user_id = $this->session->userdata('users_id');
			$data = array('Password' =>$new_pass);

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
					'Org_id' => $org_id,
					'Membership_ID' => $mem_id,
					'Users_id'=> $user_id,
					'Related_Sport'=> $related_sport,
					'Member_Status'=> 1
				    );

			//print_r($data);
			//exit;

			$result = $this->db->insert('Academy_users', $data);
			
			return $result;
			
		}

		public function update_membership_details()
		{
		    $user_id = $this->session->userdata('users_id');
			
			$org_id = $this->input->post('org_id');
			$mem_id = $this->input->post('member_id');
			$related_sport = $this->input->post('club_sport');

			$tab_id = $this->input->post('tab_id');

			$data = array(
					'Org_id' => $org_id,
					'Membership_ID' => $mem_id,
					'Users_id'=> $user_id,
					'Related_Sport'=> $related_sport,
					'Member_Status'=> 1
				    );

			//print_r($data);
			//exit;
			$this->db->where('tab_id', $tab_id);
			$result = $this->db->update('Academy_users', $data);
			
			return $result;
			
		}

		public function update_coach_details()
		{
		    $user_id = $this->session->userdata('users_id');
			
			$coach_web = $this->input->post('coach_web');
			$coach_profile = $this->input->post('coach_profile');
			$related_sport = $this->input->post('sport_coach');
			$is_coach = 1;

			$data = array(
					'Coach_Website' => $coach_web,
					'Is_coach' => $is_coach,
					'coach_profile'=> $coach_profile,
					'coach_sport'=> $related_sport
				    );

			//print_r($data);
			//exit;

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

			
			//print_r($data);
			//exit;

			$this->db->where('Users_ID', $user_id);
			$result = $this->db->update('Users', $data);
			
			return $result;
			
		}


		public function get_club_details($data)
		{
			$tab_id = $data['tab_id'];
			$user_id = $data['user_id'];

			$data = array('tab_id'=>$tab_id, 'Users_id'=>$user_id);
			$qry_check = $this->db->get_where('Academy_users', $data);
			return $qry_check->row_array();
		
		}



		public function delete_membership()
		{
			
			$user_id = $this->session->userdata('users_id');
			$tab_ids = $this->input->post('sel_org_id');

			
			foreach($tab_ids as $tab_id){
			
				$this->db->where('tab_id', $tab_id);
				$this->db->delete('Academy_Users'); 

			}
			
		}

		public function get_club_name($org_id)
		{
			$data = array('Org_ID'=>$org_id);
			$qry_check = $this->db->get_where('Academy', $data);
			return $qry_check->row_array();
		}
			

		public function get_intrests()
		{
			$query = $this->db->get('SportsType');
			return $query->result();
		}

		public function get_user_sport_intrests()
		{
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
		
			$qr_check = $this->db->query(" SELECT * from Tournament_Matches where (Player1 = $user_id or Player2 = $user_id or Player1_Partner = $user_id or Player2_Partner = $user_id) AND Winner!= 0 ORDER BY Match_Date DESC");

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

			$qr_check = $this->db->query("SELECT * FROM Academy_Users where Users_id = $user_id");
			
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

		public function get_club($org_id)
		{
			$data = array('Org_ID'=>$org_id);
			
			$qry_check = $this->db->get_where('Academy', $data);
			return $qry_check->row_array();
		}

		public function get_a2msocre($sport,$user_id)
		{
			$data = array('SportsType_ID'=>$sport , 'Users_ID'=>$user_id);
			$get_level = $this->db->get_where('A2MScore',$data);
			return $get_level->row_array();
		}
	}