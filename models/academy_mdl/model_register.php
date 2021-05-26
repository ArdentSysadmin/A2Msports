<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

	class Model_register extends CI_Model {
	
		public function __construct()
		{
			parent:: __construct();
	
		}
		
		private $email_code;  //has value set within set_session method
		
		//insert into database of registered user ..
		public function insert_user($data)
		{

			$lat_long	= $data['latt'];
			$pieces		= explode("@", $lat_long);
			
			$latitude	= $pieces[0];
			$longitude	= $pieces[1];

		/*	echo "<pre>";
			print_r($data);
			exit;*/

			$user_image = $data['profile_pic_data'];
			$org_logo	= $data['org_logo_data'];

			$profile_pic	= $user_image['file_name'];
			$logo			= $org_logo['file_name'];

			
			$firstname	= $this->input->post('Firstname');
			$lastname	= $this->input->post('Lastname');

			$email		= $this->input->post('EmailID');
			$password	= md5( $this->input->post('Password'));

			//$alteremail = $this->input->post('AlternateEmailID');
			$gender		= $this->input->post('Gender');

			/*
			$month = $this->input->post('db_month');
			$day = $this->input->post('db_day');
			$year = $this->input->post('db_year');

			$dob = $year . '-' . $month . '-' . $day;
			*/

			//$dob = $this->input->post('txt_dob');
			
			/*
			$birthdate	= new DateTime($dob);
			$today		= new DateTime('today');
			$age		= $birthdate->diff($today)->y;

			if($age <= 12){ 
				$age_group = "U12";
			}
			else if($age <= 14){
				$age_group = "U14";
			}
			else if($age <= 16){
				$age_group = "U16";
			}
			else if($age <= 18){
				$age_group = "U18";
			}
			else{
				$age_group = "Adults";
			}
			*/


			//$parentname = $this->input->post('Parentname');
			//$parentemail = $this->input->post('Parentemail');

			//$hphone = $this->input->post('HomePhone');
			$mphone = $this->input->post('Mobilephone');

			//$address1 = $this->input->post('UserAddressline1');
			//$address2 = $this->input->post('UserAddressline2');

			$country = $this->input->post('CountryName');

			/*if($country == 'United States of America') {
				$state = $this->input->post('StateName');
			} else {
				$state = $this->input->post('StateName1');
			}*/

			
			//$city = $this->input->post('CityName');
		
			$zip = $this->input->post('Zipcode');
			
			$reg_date = date("Y-m-d h:i:s");

			$code = md5($lastname . $email);

			$auth_code = substr($code, 0, 16);

			$issocial = 0 ;
			$is_user_activation = 0 ;
			$is_profile_updated = 1 ;

			$org_admin		= $this->input->post('organizer');
			$org_business	= $this->input->post('business_page');
			$org_name		= $this->input->post('org_name');
			$org_phone		= $this->input->post('org_phone');
			$org_address	= $this->input->post('org_address');
			$org_city		= $this->input->post('org_city');
			$org_state		= $this->input->post('org_state');
			$org_country	= $this->input->post('org_country');
			$url_shortcode	= strtolower($this->input->post('org_url'));
			
			$Is_club_member = $this->input->post('club_page');    
			
		/*
			$club_name = $this->input->post('club_name');
			$club_id = $this->input->post('club_id');

			$cn_result = "[";
			$cn_id_result = "[";

			for($i=0;$i<count($club_name); $i++)
			{

				if($club_name[$i] != ""){
				$cn_result .= '"'.$club_name[$i].'"';

					($club_id[$i]=="") ? $cn_id_result .= '"0"' : $cn_id_result .= '"'.$club_id[$i].'"';
				}	
				
				$j = $i;
				if(++$j != count($club_name) and $club_name[$i] != "") {
					
					$cn_result .= ",";
					$cn_id_result .= ",";
				}

				$j = $i;
				if(++$j == (count($club_name))){
					$cn_result .= "]";
					$cn_id_result .= "]";
				}
			}
			*/
		
			$Is_coach		= $this->input->post('coach_page');  
			$coach_profile	= $this->input->post('coach_profile');
			$coach_website	= $this->input->post('coach_website');
			$coach_sport	= $this->input->post('coach_sport');
			
			$notify_settings = '["1","2"]';

			$data = array(
					'Firstname' => $firstname ,
					'Lastname' => $lastname ,
					'EmailID' => $email ,
					'Password' => $password ,
					//'AlternateEmailID' => $alteremail ,
					'Gender' => $gender ,
					//'DOB' => $dob ,
					'Profilepic' => $profile_pic ,
					//'Parentname' => $parentname ,
					//'Parentemail' => $parentemail ,
					//'HomePhone' => $hphone ,
					'Mobilephone' => $mphone ,
					//'UserAddressline1' => $address1 ,
					//'UserAddressline2' => $address2 ,
					'Country' => $country ,
					//'State' => $state ,
					//'City' => $city ,
					'Zipcode' => $zip ,
					'Latitude' => $latitude ,
					'Longitude' => $longitude ,
					'ActivationCode' => $auth_code ,
					'IsUserActivation' => $is_user_activation,
					'Issociallogin' => $issocial,
					'RegistrationDtTm' => $reg_date ,
					'IsProfileUpdated' => $is_profile_updated,
					//'UserAgegroup' => $age_group,
					'Is_org_admin ' => $org_admin,
					'Req_business_page ' => $org_business,
					'Is_ClubMember' => $Is_club_member,
					'Is_coach' => $Is_coach,
					'coach_profile' => $coach_profile,
					'coach_website' => $coach_website,
					'coach_sport' => $coach_sport,
					'NotifySettings' => $notify_settings
				);

			//echo "<pre>";
			//print_r($data);
			//exit;

			$this->db->insert('Users', $data);

		    $insert_id = $this->db->insert_id();
			
			if(!$insert_id){
					echo "Something went wrong! Please contact admin.";
					exit;
			}

			$types = $this->input->post('Sportsintrests');

			if(sizeof($types) > 0 ){
				foreach($types as $type){
						 $data = array('Sport_id'=>$type,'users_id'=>$insert_id);
						 $this->db->insert('Sports_Interests', $data); 
				    }
			}

			$sports = array("1", "2", "3", "4","5","6","7","8");           // these numbers belongs to sport id in the SportType Table

			foreach($sports as $type){
				$data = array('SportsType_ID'=>$type,'Users_ID'=>$insert_id ,'A2MScore'=>100);
				$this->db->insert('A2MScore', $data); 
		    }

			if($org_business == 1){
			
				if($org_name != ""){
					$data = array(
						'Org_name ' => $org_name,
						'Org_phone ' => $org_phone,
						'Org_address' => $org_address,
						'Org_city' => $org_city,
						'Org_state ' => $org_state,
						'Org_country ' => $org_country,
						'Org_logo'=> $logo,
						'Url_Shortcode'=> $url_shortcode,
						'Users_ID'=> $insert_id
						);
					
					$this->db->insert('Academy', $data);
				}
			}

			if($Is_club_member == 1){

				$club_name = $this->input->post('club_name');
				$org_id = $this->input->post('org_id');
				$mem_id = $this->input->post('club_id');
				$related_sport = $this->input->post('club_sport');
			
				foreach($club_name as $i=>$cb){

					if($org_id[$i] != ""){
						$data = array(
							'Org_id' => $org_id[$i],
							'Membership_ID' => $mem_id[$i],
							'Users_id'=> $insert_id,
							'Related_Sport'=> $related_sport[$i],
							'Member_Status'=> 1
						);

						$this->db->insert('Academy_users', $data);
					}
				}
			}

			$data = array('auth_code'=>$auth_code, 'Users_ID'=>$insert_id);
		
			return  $data;


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

		public function insert_third_party_user($data)
		{
			$lat_long = $data['latt'];
			$pieces = explode("@", $lat_long);
			
			$latitude = $pieces[0];
			$longitude = $pieces[1];

			$firstname = $data['fname'];
			$lastname = $data['lname'];
			$email = $data['email'];
			if($data['gender'] == "M" or $data['gender'] == "Male" or $data['gender'] == "male" or $data['gender'] == "1"){
			$gender = 1;
			}
			else if($data['gender'] == "F" or $data['gender'] == "Female" or $data['gender'] == "female" or $data['gender'] == "0"){
			$gender = 0;
			}
			$dob = $data['dob'];
			
			$birthdate = date('Y-m-d',strtotime($dob));

			$birth = new DateTime($birthdate);
			$today   = new DateTime('today');
			$age = $birth->diff($today)->y;
			
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

			$mphone = $data['phone'];
			
			$add = $data['address'];
		    $city = $data['city'];
		    $state = $data['state'];
		    $country = $data['country'];
		
			$zip = $data['zipcode'];
			
			$reg_date = date("Y-m-d h:i:s");

			$code = md5($email);

			$token_code = substr($code, 0, 16);

			$issocial = 0 ;
			$is_user_activation = 1 ;
			$is_profile_updated = 1 ;
			
			$data = array(
					'Firstname' => $firstname,
					'Lastname' => $lastname,
					'EmailID' => $email,
					'Gender' => $gender,
					'DOB' => $dob,
					'Mobilephone' => $mphone,
					'UserAddressline1' => $add,
					'Country' => $country,
					'State' => $state,
					'City' => $city,
					'Zipcode' => $zip ,
					'Latitude' => $latitude ,
					'Longitude' => $longitude ,
					'Ext_token' => $token_code,
					'IsUserActivation' => $is_user_activation,
					'Issociallogin' => $issocial,
					'RegistrationDtTm' => $reg_date ,
					'IsProfileUpdated' => $is_profile_updated,
					'UserAgegroup' => $age_group
				);

			$check_email = $this->check_email($email);

			if($check_email){
				
				$exist = "A Player account with this EmailID ($email) is already exist!";
				
				//$data = array('exist_result'=>$exist);
				return $exist;

			}else{
				
			$this->db->insert('Users', $data);
		    $insert_id = $this->db->insert_id();
			
			$sports = array("1", "2", "3", "4","5","6","7","8");           // these numbers belongs to sport id in the SportType Table
			foreach($sports as $type){

				$data = array('SportsType_ID'=>$type,'Users_ID'=>$insert_id ,'A2MScore'=>100);
				$this->db->insert('A2MScore', $data); 
						
		    }
     
			//$data = array('token'=>$token_code, 'Users_ID'=>$insert_id);
			return $token_code;
			}
		}

		public function check_email($email)
		{
			
			$data = array('EmailID'=> $email);
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

		public function get_intrests()
		{
			$query = $this->db->get('SportsType');
			return $query->result();
		
		}

		public function get_email($email)
		{
//echo "<alert>$email</alert>";
			$data = array('EmailID'=> $email);
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
	
		public function get_org_url($org_url)
		{

			$data = array('Url_Shortcode'=> $org_url);
			$result = $this->db->get_where('Academy',$data);

			if ($result->num_rows > 0)
			{
				return true;
			}
			else 
			{
				return false;
			}
			
		}
	
		public function get_countries()
		{
			$query = $this->db->get('Country');
			return $query->result();
		}

		public function get_states($country_id)
		{
			$data = array('countryID'=>$country_id,'StatusID'=>1);
			$query = $this->db->get_where('state',$data);
			//$query = $this->db->get_where('StatusID',$data);
			return $query->result();
		}
		
		public function get_cities($country_id)
		{
			$data = array('countryID'=>$country_id);
			$query = $this->db->get_where('City',$data);
			return $query->result();
		}


		// registered user ,get the validation email link ... 
		private function send_validation_email() {
		
			$this->load->library('email');
			$this->email->set_newline("\r\n");
			
			$email = $this->session->userdata('EmailID');
		
			$sql = "SELECT Users_ID , RegistrationDtTm FROM users WHERE EmailID = '" .$email . "' LIMIT 1";
			$result = $this->db->query($sql);
			$row = $result->row();
		//	$this->email_code = md5((string)$row->reg_time);
		
		//	$email_code = $this->email_code ;

			$email_code = md5((string)$row->RegistrationDtTm);
			
			$this->email->set_mailtype('html');
			$this->email->from('Pradeep@ardent-india.com' , ' A2mSports');
			$this->email->to($email);
			$this->email->subject('Please activate your account at our website');
			
			$message = '<!DOCTYPE HTML>
						<html>
						<head>
						<meta http-equiv = "Content-type" content="text/html" charset=utf-8" />
						</head><body>';
		    $message .= '<p>Dear ' . $this->session->userdata('username') . ',</p>';
			
			//link we will send look like  register/validate_email/johnson@.com/6778dfknjkfgldfjgg
			
			$message .= '<p> Thanks for registering on our website ! .Please <strong><a href="' . base_url() .'register/validate_email/' . $email . '/' . $email_code . '">click here</a></strong> to activate your account .After you have activated your account , you will be log into website and start doing  business| </p>'; 
			
			$message .= '<p> Thank You !</p>';
			$message .= '<p> The team at A2msports</p>';
			$message .= '</body></html>';
			
			$this->email->message($message) ;
			$this->email->send();
			
		}

		
		public function validate_code123($code) {
		
			$sql = "SELECT EmailID  FROM Users WHERE ActivationCode = '" .$code . "' ";
			$result = $this->db->query($sql);
			$row = $result->row();
			
			if($result->num_rows() === 1 && $row->EmailID) {
				if(md5((string)$row->reg_time) === $email_code ) {
					$result = $this->activate_account($email_address);
				} else {
					$result = false;
				}
				if($result === true ) {
					return true;
				} else {
				// this should never happen
				echo ' There was an error when activating your account .Please contact the admin at  ' . $this->config->item('admin_email');
				return false;
				}
			} else {
			// this should never happen
			echo ' There was an error validating your email .Please contact admin at  ' . $this->config->item('admin_email');
			}
		}
			
		// set the session variables ...
	/*	private function set_session($username , $email ) {
		
			$sql = "SELECT user_id , reg_time FROM users WHERE email = '" .$email . "' LIMIT 1";
			$result = $this->db->query($sql);
			$row = $result->row();
			
			$sess_data = array(
					'user_id' => $row->user_id ,
					'username' => $row->username ,
					'email' => $row->email ,
					'logged_in' => 0
					
					);
			$this->email_code = md5((string)$row->reg_time);
			$this->session->set_userdata($sess_data);
		}*/
		
		
		//checking  the registered user ,when email address is same in the validation email link and then  activated the account  ...
		public function validate_code($code) {

		$act_dt = date("Y-m-d h:i:s");
			$data = array('IsUserActivation' => '1',
				'ActivatedDtTm' => $act_dt);
				$this->db->where('ActivationCode', $code);
				$this->db->update('Users', $data);

			return true;
		}
	
	}