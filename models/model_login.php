<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

	class Model_login extends CI_Model {
		
		public function __construct()
		{
			parent:: __construct();
			$this->load->database();
			$this->load->helper(array('form','url'));
		}

		public function check_user_exists($user_email){
			$data = array('EmailID'=>$user_email);
			$query = $this->db->get_where('Users', $data);
			//echo $this->db->last_query();
			return $query->row_array();
		}
		public function insert_a2mscore(){

			$data = array('Users_ID'=> $this->session->userdata('users_id'));
			$result = $this->db->get_where('A2MScore',$data);
			$qry = 0;
				if (!$result->num_rows > 0)
				{
					for($i=1;$i<=9;$i++)
					{
						$def_score = 100;
						if($i == 2)
							$def_score = 800;
						if($i == 7)
							$def_score = 3.0;

						$data = array('Users_ID'=>$this->session->userdata('users_id'), 'SportsType_ID'=>$i, 'A2MScore'=>$def_score, 'A2MScore_Doubles'=>$def_score, 'A2MScore_Mixed'=>$def_score);
						$qry = $this->db->insert('A2MScore', $data);
					}
				}
			return $qry;
		}

		
		public function get_reg_tourn_ids()
		{
			$users_id = $this->session->userdata('users_id');
			$data = array('Users_ID'=>$users_id);
			$get_tourn_ids = $this->db->get_where('RegisterTournament',$data);
			return $get_tourn_ids->result();
		
		}

		public function get_past($data)
		{
			
			$xyz = 0;		
		  if(isset($data['tourn_ids']))
		  {
			$trnm_ids = $data['tourn_ids'];
			$trnm_ids = array();
			$items = count(array_filter($trnm_ids));

			print_r($items);
			exit;

			$i = 0;
			if($items > 0)
			{
				$xyz = "";
				foreach($trnm_ids as $row)
				{
					$xyz .= "'$row->Tournament_ID'";

						if(++$i != $items) {
							$xyz .= ",";
						}
				}
			} 
		
		  }
			
			
			//$current_date = date("Y-m-d h:i:s");
			
			$users_id = $this->session->userdata('users_id');

			$qry_check = $this->db->query("SELECT * FROM tournament WHERE Usersid = $users_id AND  tournament_ID IN ($xyz)");

			return $qry_check->result();
		
		}

		public function get_sports(){
			$users_id = $this->session->userdata('users_id');
			$data = array('users_id'=>$users_id);
			$get_name = $this->db->get_where('Sports_Interests',$data);
			return $get_name->result();
		}

		public function get_all($data){
			($data['lat']=="") ? $lat = 0 : $lat = $data['lat'];
			($data['long']=="") ? $long = 0 : $long = $data['long'];
			
			$range = $data['range'];

			$sports = array();
			$sports = $data['interests'];
			$items = count(array_filter($sports));

			$i = 0;
			if($items > 0)
			{
				$xyz = "";
				foreach($sports as $row){
					$xyz .= "'$row->Sport_id'";

						if(++$i != $items) {
							$xyz .= ",";
						}
				}

				$qry_check = $this->db->query("SELECT *, ACOS( SIN( RADIANS( Latitude ) ) * SIN( RADIANS( $lat ) ) + COS( RADIANS( Latitude ) )
				* COS( RADIANS( $lat )) * COS( RADIANS( Longitude ) - RADIANS( $long )) ) * 3964.3 AS distance FROM tournament WHERE ACOS( SIN( RADIANS( Latitude )) * SIN( RADIANS( $lat ) ) + COS( RADIANS( Latitude ) ) * COS( RADIANS( $lat )) * COS( RADIANS( Longitude ) - RADIANS( $long )) ) * 3964.3 < 10  AND  SportsType IN ($xyz) ORDER BY distance");
			} 
			else{
				$qry_check = $this->db->query("SELECT *, ACOS( SIN( RADIANS( Latitude ) ) * SIN( RADIANS( $lat ) ) + COS( RADIANS( Latitude ) )
				* COS( RADIANS( $lat )) * COS( RADIANS( Longitude ) - RADIANS( $long )) ) * 3964.3 AS distance FROM tournament WHERE ACOS( SIN( RADIANS( Latitude )) * SIN( RADIANS( $lat ) ) + COS( RADIANS( Latitude ) ) * COS( RADIANS( $lat )) * COS( RADIANS( Longitude ) - RADIANS( $long )) ) * 3964.3 < 10 ORDER BY distance , StartDate ASC");
			}

			return $qry_check->result();
		}
		
		public function check_user()
		{
			$un = $this->input->post('name_login');
			$pw = md5($this->input->post('password_login'));

			// email & password combination
			/*$query = $this->db->query("SELECT * FROM Users WHERE (EmailID = '$un' OR UserProfileName = '$un' OR Username = '$un') AND Password = '$pw' AND IsUserActivation = 1");*/
			$query = $this->db->query("SELECT * FROM Users WHERE (EmailID = '$un' OR UserProfileName = '$un' OR Username = '$un') AND Password = '$pw'");
			//echo $this->db->last_query(); 
			return $query->row_array();
		}

		public function child_user()
		{
			
			$users_id = $this->session->userdata('users_id');
			$data = array('Users_ID'=>$users_id);
			$get_name = $this->db->get_where('Users_ref',$data);
			return $get_name->row_array();
		}

		public function is_social_user($data)
		{
			$fb =  $data['public_profile'];
			$fb_id = $fb['id'];

			$data = array('Socialactid'=>$fb_id,'Socialweb'=>'FB');
			
			$qry_check = $this->db->get_where('users', $data);
				return $qry_check->row_array();
		}

		public function insert_fb($data)
		{

			$fb =  $data['public_profile'];

			$fb_id = $fb['id'];


			$fb_first_name = $fb['first_name'];
			$fb_last_name  = $fb['last_name'];
			if(isset($fb['email']))
			{
			$fb_email = $fb['email'];
			}else
			{
				$fb_email = "";
			}
			$fb_gender = $fb['gender'];

			$gender = NULL;
			if($fb_gender != ''){
				if($fb_gender == 'male')
					$gender = '1';
				else
					$gender = '0';
			}

			$issocial = 1;
			$web = 'FB';
			$reg_date = date("Y-m-d h:i:s");
			$is_user_activation = 1 ;
			$act_dt = date("Y-m-d h:i:s");
			$is_user_activation = 1 ;
			$is_profile_updated = 0 ;
			$latitude = 0;
			$longitude = 0;

			$data = array (

				 'Firstname' => $fb_first_name,
				 'Lastname' => $fb_last_name,
				 'EmailID' =>  $fb_email,
				 'Gender' => $gender,
				 'Socialactid' => $fb_id,
				 'Issociallogin' => $issocial,
				 'RegistrationDtTm' => $reg_date ,
			     'ActivatedDtTm' => $act_dt,
				 'IsUserActivation' => $is_user_activation,
				  'Latitude' => $latitude,
				 'Longitude' => $longitude,
				 'Socialweb' => $web ,
				'IsProfileUpdated' => $is_profile_updated 

				);

			$this->db->insert('users', $data);
			$insert_id = $this->db->insert_id();

			$data['Users_ID'] = $insert_id;
			
		
			return $data;	
		}

		public function email_exists($email){
			$email = $this->input->post('email');

			//$query = $this->db->query("SELECT * FROM Users WHERE EmailID = '".$email."' AND (Issociallogin != 1 OR Issociallogin IS NULL)");
			$query = $this->db->query("SELECT * FROM Users WHERE EmailID = '".$email."'");
			//echo $this->db->last_query();
			return $query->result();
		}

		public function checkGoogleUser($email){

			$query = $this->db->query("SELECT * FROM Users WHERE EmailID = '".$email."'");
			//echo $this->db->last_query();
			return $query->row_array();
		}

		public function updateGoogleUser($user_data, $uid)
		{
			$data = array ('IsGoogleLogin' => '1', 'Google_AuthID' => $user_data['oauth_uid']);

			$this->db->where('Users_ID', $uid);
			$result = $this->db->update('Users', $data); 
		
			return $result;
		}

		public function createGoogleUser($google_info){

			$google_authid = $google_info['oauth_uid'];
			$google_fname  = $google_info['first_name'];
			$google_lname  = $google_info['last_name'];

			if(isset($google_info['email'])){
				$google_email = $google_info['email'];
			}
			else{
				$google_email = "";
			}

			$gender = NULL;

			if($google_info['gender']){
				if($google_gender == 'male')
					$gender = '1';
				else
					$gender = '0';
			}

			$isGoogle = 1;

			$reg_date	= date("Y-m-d h:i:s");
			$act_dt		= date("Y-m-d h:i:s");

			$is_user_activation	 = 1;
			$is_profile_updated = 0;
			$latitude						 = 0;
			$longitude					 = 0;

			$data = array (
				'Firstname' => $google_fname,
				'Lastname' => $google_lname,
				'EmailID' =>  $google_email,
				'Gender' => $gender,
				'Google_AuthID' => $google_authid,
				'IsGoogleLogin' => $isGoogle,
				'RegistrationDtTm' => $reg_date ,
				'ActivatedDtTm' => $act_dt,
				'IsUserActivation' => $is_user_activation,
				'Latitude' => $latitude,
				'Longitude' => $longitude,
				'IsProfileUpdated' => $is_profile_updated 
				);

			$this->db->insert('users', $data);
			$insert_id = $this->db->insert_id();
			
			$types = $this->input->post('Sportsintrests');

			if(sizeof($types) > 0 ){
				foreach($types as $type){
						 $data = array('Sport_id'=>$type, 'users_id'=>$insert_id);
						 $this->db->insert('Sports_Interests', $data); 
				    }
			}

			$sports = array("1", "2", "3", "4","5","6","7","8","9","11","12","17"); 
			// these numbers belongs to sport id in the SportType Table

			foreach($sports as $type){
						$def_score = 100;
						if($type == '2')
							$def_score = 800;
						if($type == '7')
							$def_score = 3.0;
				$data = array('SportsType_ID'	 => $type,
							  'Users_ID'		 => $insert_id,
							  'A2MScore'		 => $def_score,
							  'A2MScore_Doubles' => $def_score,
							  'A2MScore_Mixed'   => $def_score);

				$this->db->insert('A2MScore', $data); 
		    }

			$query = $this->db->query("SELECT * FROM Users WHERE Users_ID = '".$insert_id."'");
			return $query->row_array();
		}

		public function check_act_code($user_id){
			$data = array('Users_ID'=>$user_id);
			$query = $this->db->get_where('users',$data);

			return $query->row_array();
		}

		public function child_accounts($user_id){
			$qry = $this->db->query("select * from Users where Users_ID in (select Users_ID from Users_ref where Ref_ID = $user_id)");
			return $qry->result();
		}

		public function get_child_name($user_id){
			$data = array('Users_ID'=>$user_id);
			$query = $this->db->get_where('Users',$data);
			return $query->row_array();
		}

		public function verify_reset_password_code($code){
			$data = array('ActivationCode'=>$code);

			$query = $this->db->get_where('users',$data);
			return $query->row_array();
		}

		public function get_parent($user_id){

			$data = array('Users_ID'=>$user_id);
			$query = $this->db->get_where('Users_ref',$data);
			return $query->row_array();
		}

		public function update_password(){
			$password = md5($this->input->post('Password'));
			$user_id =  $this->input->post('Users_ID');
			
			$data = array ('Password'=>$password);

			$this->db->where('Users_ID', $user_id);
			$result = $this->db->update('Users', $data); 
		
			return $result;
		}

		public function aca_update_password(){
			$password = md5($this->input->post('upd_password'));
			$user_id =  $this->input->post('Users_ID');
			
			$data = array ('Password'=>$password);

			$this->db->where('Users_ID', $user_id);
			$result = $this->db->update('Users', $data); 
		
			return $result;
		}

		public function upd_child_act_code($user_id, $auth_code){
			$data = array('ActivationCode' => $auth_code);
			$this->db->where('Users_ID', $user_id);
			$result = $this->db->update('Users', $data); 
		
			return $result;
		}

		public function validate_token($token){
			$data = array('Ext_token'=>$token);
			$query = $this->db->get_where('Users',$data);

			return $query->row_array();
		}

		public function validate_user_phone($phone, $ph, $ph2) {
			//$qry_check = $this->db->query("SELECT * FROM Users WHERE Mobilephone = '".$ph."' OR Mobilephone = '".$phone."'");
			$qry_check = $this->db->query("SELECT * FROM Users WHERE Mobilephone = '".$ph."' OR Mobilephone = '".$phone."' OR Mobilephone = '".$ph2."'");
			return $qry_check->result_array();
		}

		public function check_user_phone($phone) {
			$qry_check = $this->db->query("SELECT * FROM Users WHERE Mobilephone like '%".$phone."%'");
			return $qry_check->row_array();
		}

	}