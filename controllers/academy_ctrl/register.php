<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

       session_start(); 

	// Register controller 
	class Register extends CI_Controller {
	
		public $short_code;
		public $academy_id;

		public function __construct()
		{
			parent:: __construct();
			$this->load->helper(array('form', 'url'));

			$this->load->library('form_validation');
			$this->load->library('session');
			//$this->load->model('model_general', 'general');
			$this->load->model('model_register', 'reg_model');
			$this->load->model('model_news');

			$this->load->model('academy_mdl/model_academy');
			$this->load->model('academy_mdl/model_general', 'general');
			$this->load->model('academy_mdl/model_news');

			$this->short_code			= $this->uri->segment(1);
			//$this->academy_admin	= $this->general->get_org_admin($this->short_code);
			$this->academy_id			= $this->general->get_orgid($this->short_code);

			$this->admin_menu_items = array('0'=>'');
			if($this->logged_user != $this->academy_admin)
			$this->admin_menu_items = array('0'=>'8');

			$this->is_club_admin = 0;
			if($this->logged_user == $this->academy_admin){
			$this->is_club_admin = 1;
			}

			if(!$this->logged_user){
			$this->load->library('facebook' ,  array("appId" => FB_APPID, "secret" => FB_KEY, "redirect_url" => FB_REDIRECT ));
			}

		}
		
		public function get_fb_login(){
			//$returnURI = array('redirect' => $_SERVER['HTTP_X_FORWARDED_HOST']."/login/verify_user");
			//$login  = $this->facebook->getLoginUrl($returnURI);
			$login  = $this->facebook->getLoginUrl();
			//echo $login; exit;
			return $login;
		}

		public function get_google_login(){

		// Store values in variables from project created in Google Developer Console
		$client_id			= '170374605326-p02hhgiia6fqncck0982i401madv6n72.apps.googleusercontent.com';
		$client_secret		= 'XyOwkQkScXXca0wG4paTUx6A';
		$redirect_uri		= 'https://a2msports.com/login/auth_check';
		$simple_api_key = 'AIzaSyC0JNMWyyW6t1fSNyrprBJC2bWKG4btytc';

		include_once APPPATH."libraries/google_login_api_HRWNdR/src/Google_Client.php";
		include_once APPPATH."libraries/google_login_api_HRWNdR/src/contrib/Google_Oauth2Service.php";
        
        // Google Project API Credentials
        $clientId	   = $client_id;
        $clientSecret = $client_secret;
        $redirectUrl   = $redirect_uri;
        
        // Google Client Configuration
        $gClient = new Google_Client();
        $gClient->setApplicationName('A2MSports');
        $gClient->setClientId($clientId);
        $gClient->setClientSecret($clientSecret);
        $gClient->setRedirectUri($redirectUrl);

		//$gclient->setDefaultOption('verify', false); // Can be removed
        $google_oauthV2 = new Google_Oauth2Service($gClient);
        $token				 = $this->session->userdata('token');

       // if (!empty($token)) {
        if ($token != "") {
            $gClient->setAccessToken($token);
        }

        $data['authUrl'] = $gClient->createAuthUrl();
      
			return $data['authUrl'];
		}

		public function get_club_menu($org_id){
			$get_menu = $this->general->get_club_menu($org_id);
			$club_menu = array();

			if($get_menu)
				$club_menu = json_decode($get_menu['Active_Menu_Ids'], TRUE);
			return $club_menu;
		}

		
		// load the registration page .... 
		/*public function index()
		{
			//echo "testing"; exit;
			if($this->session->userdata('users_id')){
				redirect('profile');
			}

			$this->session->unset_userdata('redirect_to');

			//$this->load->library('form_validation');
			$data['intrests'] = $this->reg_model->get_intrests();
			//print_r($data);
			$data['results'] = $this->model_news->get_news();
			
			$this->load->view('includes/header_static');
			$this->load->view('view_register',$data);
			$this->load->view('includes/footer_static');
		}*/

		public function get_onerow($table, $column, $val){
			return $this->general->get_onerow($table, $column, $val);
		}

		// load the registration page .... 
		public function index($org_id)
		{
			if($this->session->userdata('users_id')){
				redirect('profile');
			}

			//if(isset($_GET['r'])){

			$data['org_id'] = $org_id;
			//$data['club_results'] = $this->model_academy->get_assoc_clubs($org_id);

			$org_details				= $this->model_academy->get_academy_details($org_id); 
			//$data['sports_list']		= $this->general->get_sports(); 
			$data['org_details']		= $org_details; 


				//$page = $_GET['r'];
				$this->session->unset_userdata('redirect_to');

				$data['intrests'] = $this->reg_model->get_intrests();
				//print_r($data);
				$data['results']  = $this->model_news->get_news();
				
					//$this->load->view('includes/header_static');
				$this->load->view('academy_views/includes/academy_header', $data);

				//if($page == 'player'){
				//	$this->load->view('view_register', $data);
				//}
				//else if($page == 'coach'){
				//	$this->load->view('view_coach_register', $data);
				//}
				//else if($page == 'club-owner'){
					$this->load->view('academy_views/view_club_register', $data);
				//}
				//else {
				//	echo "Invalid Request!";
				//	exit;
				//}

					//$this->load->view('includes/footer_static');
			$this->load->view('academy_views/includes/academy_footer');
			//}
			//else{
			//		$this->load->view('view_reg_popup', $data);
			//}
	
		}


		//register the user into the database ..
		public function save_user_data()
		{
			//echo "Testing"; 
			/*echo "<pre>";
			print_r($_POST);
			exit;*/
			//echo $this->session->userdata('redirect_to');
			//exit;
			if($this->input->post('reg_user')){
		
			$email_id = trim($this->input->post('EmailID'));

			if($email_id == ''){ echo "Please provide Email ID"; exit; }

			$data['aca_id']			= $academy	= $this->input->post('academy');
			$data['shortcode']	= $shortcode	= $this->input->post('shortcode');

			$query  = $this->reg_model->get_email($email_id);
			$status  = '';

 				if($query){
				 	$err_msg = $email_id." is already exists! Please choose another Email ID.";
					$this->session->set_flashdata('err_msg', $err_msg);
					redirect('register');
				}
				else{
				 $filename		= 'Profilepic';
				 $filename2	= 'org_logo';

				 $config = array(
						'upload_path'		=> "./profile_pictures/",
						'allowed_types'	=> "gif|jpg|png|jpeg|pdf",
						'overwrite'		=>	FALSE,
						'max_size'		=> "10000", // Can be set to particular file size , here it is 2 MB(2048 Kb)
						'max_height'	=> "5000",
						'max_width'	=> "8000"
						);
					
				$this->load->library('upload');
				$this->upload->initialize($config); 

				if($this->upload->do_upload($filename)){
					$data['profile_pic_data'] = $this->upload->data();
					$upload_data = $data['profile_pic_data'];

					////image resize code starts....////. 
					$resize_conf = array(
									'upload_path'   => "./profile_pictures/thumbs/",
									'source_image' => $upload_data['full_path'], 
									//'new_image'    => './tour_pictures/$tourn_id/thumbs/'.$upload_data['file_name'],
									'new_image'    => $upload_data['file_path'].'thumbs/'.$upload_data['file_name'],
									'width'			 => '200',
									'height'			 => '239'
									);

					$this->load->library('image_lib');  
					$this->image_lib->initialize($resize_conf);
					
					if(!$this->image_lib->resize()){
						$error['resize'] = $this->image_lib->display_errors();		
					}
					else{
						$data_to_store['userfile'] = $upload_data['file_name'];						
						$data1['userfile']				= $upload_data['file_name'];
					}

							  //// image resize code ends ....  ////
				}

				  //upload picture for academy ...
				   $config = array(
								'upload_path'	=> "./org_logos/",
								'allowed_types' => "gif|jpg|png|jpeg|pdf",
								'overwrite'		=> FALSE,
								'max_size'		=> "10000", // Can be set to particular file size , here it is 2 MB(2048 Kb)
								'max_height'	=> "5000",
								'max_width'	=> "8000"
								);

					$this->upload->initialize($config);

					if($this->upload->do_upload($filename2)){
						$data['org_logo_data'] = $this->upload->data();
					}


					if($this->input->post('CountryName'))
						$data['latt']		= $this->get_lang_latt();
			
					$res	 = $this->reg_model->insert_user($data);

					// --------------------------------------------------------------------------------------------------------------
					if($this->input->post('mem_subscr') == '1' and $this->input->post('mem_plan') != '') {
								//echo "test"; exit;
							$ins_user		= $res['Users_ID'];
							$mem_code  = $this->input->post('mem_plan');
							$mem_det	    = $this->general->get_membership_dets($mem_code);

							if($mem_det){
								$pp_data['Membership_ID']		= $mem_det['Membership_ID'];
								$pp_data['Membership_Type'] = $mem_det['Membership_Type'];
								$pp_data['Frequency']				= $mem_det['Frequency'];
								$pp_data['Frequency_Code']		= $mem_det['Frequency_Code'];
								$pp_data['Fee']								= $mem_det['Fee'];
								$pp_data['Act_Fee']						= $mem_det['ActivationFee'];

								$pp_data['User_ID'] = $ins_user;

							$ins_ot_pay_id = '';
							if($mem_det['ActivationFee'] > 0){
							$data9 = array('Club_ID' => $academy, 'User_ID' => $ins_user, 'Membership_Code' => $mem_det['Membership_ID'], 'Type' => 'OT', 'Pay_Status' => 'NOT PAID', 'Created_On' => date('Y-m-d H:i:s'));

							$ins_ot_pay_id = $this->general->insert_table_data('Membership_PaymentLinks', $data9);
							}

							$data10 = array('Club_ID' => $academy, 'User_ID' => $ins_user, 'Membership_Code' => $mem_det['Membership_ID'], 'Type' => 'SUBSCR', 'Pay_Status' => 'NOT PAID', 'Created_On' => date('Y-m-d H:i:s'));

							$ins_subscr_pay_id = $this->general->insert_table_data('Membership_PaymentLinks', $data10);

								$this->user_email_pp_subscr($res, $pp_data, $ins_ot_pay_id, $ins_subscr_pay_id);
								$this->admin_email_new_user($res, $pp_data, $ins_ot_pay_id, $ins_subscr_pay_id);

								if($ins_ot_pay_id)
								$this->paypal_ot($ins_ot_pay_id);
								else
								$this->paypal_subscr($ins_subscr_pay_id);
								exit;
							}
					}
		// ---------------------------------------------------
					else{
						  $email_stat = $this->user_email($res);
					}

				    $data['results'] = $this->model_news->get_news();
		
					if($this->session->userdata('redirect_to') or $this->input->post('red_uri')){
						/*if($academy and $this->config->item('proxy_url') == ''){
							redirect($shortcode."?st=1");
						}*/
						if($this->input->post('red_uri') != ''){
							redirect($this->input->post('red_uri')."?st=1");
						}
						else{
							$red = $this->session->userdata('redirect_to').'/8';
							redirect($red);
						}
					}
					else{
							$org_details				= $this->model_academy->get_academy_details($academy);
							$data['org_details']	= $org_details; 

							$this->load->view('academy_views/includes/academy_header', $data);
							$this->load->view('academy_views/view_register_complete');
							$this->load->view('academy_views/includes/academy_footer');
					}
				}
			}
			else{
				if($this->session->userdata('users_id')){
					redirect('profile');
				}
				else{
					echo "Invalid Access!";
				}
			}
	}

	public function profile_update(){		
				
		if($this->input->post('ins_prof_update')){		
					
			$query = $this->reg_model->profile_update($email_id);		
			$data['status'] = "Profile Updated. Please login to continue.";		
			if($query){		
				redirect(base_url()."login");		
			}		
		}		
		else{		
			echo "Invalid Access!";		
		}		
	}
	
	public function email_check($email_id = '')
	{
		$email_id =  $this->input->post('email_id');				
			$query = $this->reg_model->get_email($email_id);
			
		$status = $email_id.' '.'is already exists!';
		if($query != 1){
			$status = "";
			}                
		echo $status;

	}

	public function org_url_check($org_url = '')
	{
		$org_url =  $this->input->post('org_url');				
		$query = $this->reg_model->get_org_url($org_url);
			
		$status = $org_url.' '.'is already exists!';
		if($query != 1){
			$status = "";
			}                
		echo $status;

	}
	

	 public function terms_conditions()
	 {	
			$this->load->view('view_terms_conditions');
	 }

	public function get_lang_latt()
	{
	    // $address1 = $this->input->post('UserAddressline1');
		if($this->input->post('UserAddressline2')==""){
		 $address2 = $this->input->post('UserAddressline1');
		} else {
		 $address2 = $this->input->post('UserAddressline2');
		}
		 $country = $this->input->post('CountryName');

		 if($country == 'United States of America') {
					$state = $this->input->post('StateName');
			} else {
					$state = $this->input->post('StateName1');
			}

		 $city		= $this->input->post('CityName');
		 $zipcode	= $this->input->post('Zipcode');


		 //$address =  $address2 . ' ' .  $country . ' ' .  $state . ' ' .  $city ;
		 $address =  $zipcode . ' ' . $country;


			if(!empty($address)){

			//Formatted address
			$formattedAddr = str_replace(' ','+',$address);

			//Send request and receive json data by address
			$geocodeFromAddr = file_get_contents("https://maps.googleapis.com/maps/api/geocode/json?address=".$formattedAddr."&key=".GEO_LOC_KEY); 

			$output1 = json_decode($geocodeFromAddr);
			
			$latitude  = 0.00; 
			$longitude = 0.00;
			
			//Get latitude and longitute from json data
			$latitude  = $output1->results[0]->geometry->location->lat; 
			$longitude = $output1->results[0]->geometry->location->lng;

			return  $latitude  . '@' . $longitude;
			} else {
				return false;
			}
	}
		

		public function user_email($res)
		{
			$first_name = $this->input->post('Firstname');
			$last_name	= $this->input->post('Lastname');
			$email		= $this->input->post('EmailID');

			$xx = $res;
			$activation_code = $xx['auth_code'];
			
			$this->load->library('email');
			$this->email->set_newline("\r\n");
		
			$this->email->from(FROM_EMAIL, 'A2MSports');
			$this->email->to($email); 
			$this->email->subject('Activate your account at A2MSports!');

			$data = array(
             'Firstname'=> $first_name,
			 'Lastname'=> $last_name,
			 'Code' => $activation_code,
			 'page'=> 'New Registration'
			);

			$body = $this->load->view('view_email_template.php',$data,TRUE);
			$this->email->message($body);   
			$stat = $this->email->send();
			
			return $stat;
		}

		public function user_email_pp_subscr($res, $pp_data, $ot_id, $subscr_id)
		{
			$first_name	= $this->input->post('Firstname');
			$last_name	= $this->input->post('Lastname');
			$email				= $this->input->post('EmailID');
			$club_name	= $this->input->post('shortcode');

			$xx = $res;
			$activation_code = $xx['auth_code'];
			
			$this->load->library('email');
			$this->email->set_newline("\r\n");
		
			$this->email->from(FROM_EMAIL, 'A2MSports');
			$this->email->to($email); 
			$this->email->subject($club_name." account activation mail!");

			$data = array(
             'Firstname'=> $first_name,
			 'Lastname'=> $last_name,
			 'Code' => $activation_code,
			 'club_name' => $club_name,
			 'mem_info'		=> $pp_data,
			 'ot_id'		=> $ot_id,
			 'subscr_id'		=> $subscr_id,
			 'page'			=> 'New Club Registration with PayNow');

			$body = $this->load->view('view_email_template.php', $data, TRUE);
			/*echo "<pre>"; 
			print_r($data);
			echo $body; 
			exit;*/
			$this->email->message($body);   
			$stat = $this->email->send();
			
			return $stat;
		}
	

		public function admin_email_new_user($res, $pp_data, $ot_id, $subscr_id)
		{
			$first_name	= $this->input->post('Firstname');
			$last_name	= $this->input->post('Lastname');
			$club_name	= $this->input->post('shortcode');
			
			$get_club_admin = $this->general->get_onerow('Academy_Info', 'Aca_URL_ShortCode', $club_name);
			$get_admin_user = $this->general->get_onerow('Users', 'Users_ID', $get_club_admin['Aca_User_id']);
		
			if($get_admin_user['EmailID'])
				$email	 = $get_admin_user['EmailID'];
			else
				$email	 = $get_admin_user['AlternateEmailID'];

			$xx = $res;
			$activation_code = $xx['auth_code'];
			
			$this->load->library('email');
			$this->email->set_newline("\r\n");
		
			$this->email->from(FROM_EMAIL, 'A2MSports');
			$this->email->to($email); 
			$this->email->subject("New User Registration - ".$club_name);

			$data = array(
             'Firstname'	=> $first_name,
			 'Lastname'	=> $last_name,
			 'Code'			=> $activation_code,
			 'club_name' => $club_name,
			 'mem_info'	=> $pp_data,
			 'ot_id'			=> $ot_id,
			 'subscr_id'		=> $subscr_id,
			 'page'				=> 'New Club Registration - Admin');

			$body = $this->load->view('view_email_template.php', $data, TRUE);
			/*echo "<pre>"; 
			print_r($data);
			echo $body; 
			exit;*/
			$this->email->message($body);   
			$stat = $this->email->send();
			
			return $stat;
		}

		public function custom_activation_mail_send($res)	// Custom function to send activation emails to specific users
		{
	//		echo FROM_EMAIL;
			$first_name = 'Prasad';
			$last_name	= 'Shetye';
			$email		= '';
			$activation_code = 'f5c077e93e872dd2';
			
			$this->load->library('email');
			$this->email->set_newline("\r\n");
		
			$this->email->from('admin@a2msports.com', 'A2MSports');
			$this->email->to($email); 
			$this->email->subject('Activate your account at A2MSports!');

			$data = array(
             'Firstname'=> $first_name,
			 'Lastname'=> $last_name,
			 'Code' => $activation_code,
			 'page'=> 'New Registration'
			);

			$body = $this->load->view('view_email_template.php',$data,TRUE);
			echo $body;
			$this->email->message($body);
			//$this->email->send();
	//		echo "Mail sent.";
		}
	

		public function activate($activation_code){
		
		$this->session->sess_destroy();

		if($activation_code){
		$is_activated = $this->reg_model->is_activated($activation_code);
			
		if($is_activated){
			$this->session->set_flashdata('redirect_page', 'Play');
			redirect('login');
		}
		else{
			$split = explode('_', $activation_code);

			if($split[1] != "" and $split[1] != NULL){
				$validated = $this->reg_model->validate_code($activation_code);
				
				if($split[1] == 'aW5z' and $validated === true){
					$get_user = $this->reg_model->get_user_actcode($activation_code);
					$data['users_id'] = $get_user['Users_ID'];
					$data['act_code'] = $get_user['ActivationCode'];
					$data['results'] = $this->model_news->get_news();

					$this->load->view('includes/header');
					$this->load->view('view_update_instantuser', $data);
					$this->load->view('includes/view_right_column');
					$this->load->view('includes/footer');
				}
				else{
					echo 'Oops, Something went wrong in activating your account. Please contact admin@a2msports.com';
				}
			}
			else{
				$code = trim($activation_code);
				
				$validated = $this->reg_model->validate_code($code);
				$data = array('act_stat' => "Activation Completed. Please login to access the website");
			
				if($validated === true){
					$this->load->view('includes/header');
					$this->load->view('view_login', $data);
					$this->load->view('includes/footer');
				} 
				else{
					// this should never happen 
					echo 'Oops, Something went wrong in activating your account. Please contact admin@a2msports.com';
				}
			}
		  }
		}
		else{
			echo "Invalid Request!";
		}

		}

		
		public function autocomplete()
		{	
			$q = $_POST['name_startsWith'];
	
			$data['key'] = trim($q);
			$result = $this->reg_model->search_autocomplete($data);

			if($result)
			{
				$data_new = array();
				foreach($result as $row)   
				{
					$name = $row->Aca_name.'|'.$row->Aca_ID;
					array_push($data_new, $name);	
				}
			}
				echo json_encode($data_new);
				exit;
		 }

		public function instant_register(){
		//echo "<pre>"; print_r($_POST); exit;
			if($this->input->post('email')){

				$check_user_exists = $this->reg_model->get_email($this->input->post('email'));
				
				if(!$check_user_exists){
                $data['latt'] = $this->get_lang_latt();
			
				$ins_user = $this->reg_model->instant_register($data);

				if(!empty($ins_user)){
					$fname      = $ins_user['firstname'];
					$lame		= $ins_user['lastname'];
					$phone      = $ins_user['phone'];
					$users_id   = $ins_user['users_id'];

					if($this->input->post('tourn_id')){
					   $ins_user['tourn_id'] = $this->input->post('tourn_id');
					}
					
					$this->instant_user_email($ins_user);
					
					$name = $fname.' '.$lame.'|'.$users_id.'|'.$phone;
					echo $name;
				}
				else{
					echo 0;
				}
				}
				else{
					echo "User with this email id already exists!";
					exit;
				}
			}
		}

		public function instant_clubmember(){
		
			if($this->input->post('txt_email')){

				$check_user_exists = $this->reg_model->get_email($this->input->post('txt_email'));
				
				if(!$check_user_exists){

                $data['latt'] = $this->get_lang_latt();
				$ins_user	  = $this->reg_model->instant_clubmember($data);

				if(!empty($ins_user)){

				 $filename = 'Profilepic';
				 $config   = array(
							'upload_path'	=> "./profile_pictures/",
							'allowed_types' => "gif|jpg|png|jpeg|pdf",
							'overwrite'		=>	FALSE,
							'max_size'		=> "10000", // Can be set to particular file size , here it is 2 MB(2048 Kb)
							'max_height'	=> "5000",
							'max_width'		=> "8000"
							);
					
				$this->load->library('upload');
				$this->upload->initialize($config); 

				if($this->upload->do_upload($filename)){
					$data['profile_pic_data'] = $this->upload->data();
					$upload_data = $data['profile_pic_data'];

					////image resize code starts....////. 
					$resize_conf =	array(
									'upload_path'  => "./profile_pictures/thumbs/",
									'source_image' => $upload_data['full_path'], 
									//'new_image'    => './tour_pictures/$tourn_id/thumbs/'.$upload_data['file_name'],
									'new_image'    => $upload_data['file_path'].'thumbs/'.$upload_data['file_name'],
									'width'        => '200',
									'height'       => '239'
									);

					$this->load->library('image_lib');  
					$this->image_lib->initialize($resize_conf);
					
					if (!$this->image_lib->resize()){
						$error['resize'] = $this->image_lib->display_errors();		
					}
					else{
						$data_to_store['userfile']  = $upload_data['file_name'];						
						$data1['userfile']			= $upload_data['file_name'];
					}

				  //// image resize code ends ....  ////
						$data['users_id'] = $ins_user['users_id'];

						$res = $this->reg_model->upd_instant_clubmember($data);
					}


					$fname      = $ins_user['firstname'];
					$lame		= $ins_user['lastname'];
					$phone      = $ins_user['phone'];
					$users_id   = $ins_user['users_id'];

					if($this->input->post('tourn_id')){
					   $ins_user['tourn_id'] = $this->input->post('tourn_id');
					}
					
					$this->instant_user_email($ins_user);
					
					//$name = $fname.' '.$lame.'|'.$users_id.'|'.$phone;
					//echo $name;
					redirect($this->input->post('Ret_URL'));
				}
				else{
					echo "Something went wrong! please contact admin@a2msports.com";
				}
				}
				else{
					echo "User with this email id already exists!";
					exit;
				}
			}
		}
		
		/*public function api_register(){
			//echo "<pre>"; print_r($_POST); exit;
			// Set up and execute the curl process
			$curl_handle = curl_init();
			curl_setopt($curl_handle, CURLOPT_URL, 'http://localhost/site/index.php/example_api');
			curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt($curl_handle, CURLOPT_POST, 1);
			curl_setopt($curl_handle, CURLOPT_POSTFIELDS, array(
				'name' => 'name',
				'email' => 'example@example.com'
			));

			// Optional, delete this line if your API is open
			curl_setopt($curl_handle, CURLOPT_USERPWD);

			$buffer = curl_exec($curl_handle);
			curl_close($curl_handle);

			$result = json_decode($buffer);

			if(isset($result->status) && $result->status == 'success')
			{
				echo 'Record inserted successfully...';
			}

			else
			{
				echo 'Something has gone wrong';
			}

		}*/

		public function instant_user_email($user_det){

			$first_name = $user_det['firstname'];
			$last_name	= $user_det['lastname'];
			$email		= $user_det['email'];
			$act_code	= $user_det['act_code'];

			if(isset($user_det['tourn_id'])){
               $tourn_id = $user_det['tourn_id'];
               $page = "Instant Registration By Admin";
			}else{
				$tourn_id = "";
				$page = "Instant Registration";
			}
			
			$this->load->library('email');
			$this->email->set_newline("\r\n");
		
			$this->email->from(FROM_EMAIL, $this->session->userdata('user'));
			$this->email->to($email); 
			$this->email->subject('Activate your account at A2MSports!');

			$data = array(
					'Firstname' => $first_name,
					'Lastname'  => $last_name,
					'Code'	    => $act_code,
					'page'	    => $page,
					'tourn_id'  => $tourn_id);

			$body = $this->load->view('view_email_template.php',$data,TRUE);
			$this->email->message($body);   
			$stat = $this->email->send();
			
			return $stat;
		}
		
		public function unsubscribe($user ,$status = ''){
            $user_id = base64_decode($user);
		    $data['user_details'] = $this->general->get_user($user_id);
		    $data['intrests']     = $this->reg_model->get_intrests();
		    $data['results']      = $this->model_news->get_news();
		    $data['allsports']    = $this->general->get_sports();
		    $data['status']       = $status;
		    
			$this->load->view('includes/header', $data);
			$this->load->view('view_email_unsubscribe.php', $data);
			$this->load->view('includes/view_right_column.php', $data);
	      	$this->load->view('includes/footer');
		}

		public function Update_email_unsubscribe(){
			
		    $up_res = $this->reg_model->Update_email_unsubscribe();
		    if($up_res){
			   $status = 1;
               $this->unsubscribe(base64_encode($this->input->post('user_id')), $status);
		    }
		    //echo "<pre>";print_r($up_res);exit();

		}

	public function update_missing_geo_users()
	{

		$get_users = $this->reg_model->get_missing_geo_users();
		
		echo "ccc ". count($get_users);
		$c = 0;
		foreach($get_users as $user){
			
			
			$uid = $user->Users_ID;
			$zip = $user->Zipcode;
			$cn  = $user->Country;
	
			$address = $zip;
			if($cn){
			$address .= ' ' . $cn;
			}

			if(!empty($address) and $zip){

			//Formatted address
			$formattedAddr = str_replace(' ','+',$address);

			//Send request and receive json data by address
			$geocodeFromAddr = file_get_contents("https://maps.googleapis.com/maps/api/geocode/json?address=".$formattedAddr."&key=".GEO_LOC_KEY); 

			$output1 = json_decode($geocodeFromAddr);
			
			$latitude  = 0.00; 
			$longitude = 0.00;
			
			//Get latitude and longitute from json data
			$latitude  = $output1->results[0]->geometry->location->lat; 
			$longitude = $output1->results[0]->geometry->location->lng;

			$upd_user = $this->reg_model->update_user_geo($uid, $latitude, $longitude);
			$c++;
			}
			else {
			echo "<br>" . $uid;
			}

		}
		
		echo "<br>tot upd ".$c;
	}

	public function update_tshirt(){		
		$uid = $this->session->userdata('users_id');		
		if($uid){		
			if($this->input->post('ts')){
				$ts	   = $this->input->post('ts');
				$query = $this->reg_model->update_tshirt_size($uid, $ts);
				echo "Successfully Updated! Thank you.";
			}
			else{
				echo "Please select T-Shirt Size!";
			}
		}	
		else{		
			echo "Invalid Request!";		
		}		
	}

	
	public function paypal_subscr_method($pp_data){
	
		if(!empty($pp_data)){
				$this->load->library('paypal_lib');

				$paypal_id			  = SANDBOX_PAYPAL_ID;
				$currency_code = 'USD';
				$paypalURL		  = SANDBOX_PAYPAL_URL; //PayPal api url

				$logo = base_url().'images/logo.png';

				$returnURL = base_url().'paypal/test_success?mem_code='.$pp_data['Membership_ID'].'&reg_user='.$pp_data['User_ID'];

				$cancelURL = base_url().'paypal/test_cancel';		//payment cancel url
				$notifyURL  = base_url().'paypal/test_ipn';			//ipn url

				$this->paypal_lib->add_field('business', $paypal_id);
				$this->paypal_lib->add_field('cmd', "_xclick-subscriptions");
				$this->paypal_lib->add_field('return', $returnURL);
				$this->paypal_lib->add_field('cancel_return', $cancelURL);
				$this->paypal_lib->add_field('currency_code', $currency_code);
				$this->paypal_lib->add_field('notify_url', $notifyURL);
				//$this->paypal_lib->add_field('tourn_id', $tid);
				//$this->paypal_lib->add_field('player', $this->logged_user);
				$this->paypal_lib->add_field('on0', $pp_data['User_ID']);
				$this->paypal_lib->add_field('a3',  $pp_data['Fee']);
				$this->paypal_lib->add_field('t3',  $pp_data['Frequency_Code']);
				$this->paypal_lib->add_field('p3',  1);
				$this->paypal_lib->add_field('src',  1);
				//$this->paypal_lib->add_field('srt',  10);
				$this->paypal_lib->add_field('sra',  2);
				$this->paypal_lib->add_field('item_number',  $pp_data['Membership_ID']);
				$this->paypal_lib->add_field('item_name',  $pp_data['Membership_ID'].'-'.$pp_data['Membership_Type'].'-'.$pp_data['Frequency']);

				$this->paypal_lib->image($logo);
				$this->paypal_lib->test_paypal_auto_form();
			}

	}

			public function paypal_ot($ot_pay_id){
			$get_ot	 = $this->general->get_onerow('Membership_PaymentLinks', 'tab_id', $ot_pay_id);
			$get_pay = $this->general->get_onerow('Membership_Types', 'Membership_ID', $get_ot['Membership_Code']);

			if($get_ot['User_ID'] and $get_pay){
					$this->load->library('paypal_lib');

				$paypal_id				= SANDBOX_PAYPAL_ID;
				$currency_code	= 'USD';
				$paypalURL			= SANDBOX_PAYPAL_URL; //PayPal api url
				$logo = base_url().'images/logo.png';
				$url	   = base_url().$this->uri->segment(1);

				$returnURL = $url.'/paypal/ot_user?sub_type=ot&club_id='.$get_pay['Club_ID'].'&reg_user='.$get_ot['User_ID'];

				$cancelURL = $url.'/paypal/ot_cancel';	//payment cancel url
				$notifyURL  = $url.'/paypal/ot_ipn';			//ipn url
				$this->paypal_lib->add_field('business', $paypal_id);
				//$this->paypal_lib->add_field('cmd', "_xclick-subscriptions");
				$this->paypal_lib->add_field('return', $returnURL);
				$this->paypal_lib->add_field('cancel_return', $cancelURL);
				$this->paypal_lib->add_field('currency_code', $currency_code);
				$this->paypal_lib->add_field('notify_url', $notifyURL);
				$this->paypal_lib->add_field('on0', $get_ot['User_ID']);
				$this->paypal_lib->add_field('item_number',  $get_pay['Membership_ID']);
				$this->paypal_lib->add_field('item_name',  $get_pay['Membership_ID'].'-'.$get_pay['Membership_Type'].'-One Time Setup');
				$this->paypal_lib->add_field('amount', $get_pay['ActivationFee']);
				$this->paypal_lib->image($logo);
				
				$this->paypal_lib->test_paypal_auto_form();		
			}
			else{
				echo "Invalid Access!";
			}
		}
		
		public function paypal_subscr($sub_pay_id){
			$get_subscr	 = $this->general->get_onerow('Membership_PaymentLinks', 'tab_id', $sub_pay_id);
			$get_pay = $this->general->get_onerow('Membership_Types', 'Membership_ID', $get_subscr['Membership_Code']);

			if($get_subscr['User_ID'] and $get_pay){
					$this->load->library('paypal_lib');

				$paypal_id				= SANDBOX_PAYPAL_ID;
				$currency_code	= 'USD';
				$paypalURL			= SANDBOX_PAYPAL_URL; //PayPal api url
				$logo = base_url().'images/logo.png';
				$url	   = base_url().$this->uri->segment(1);

				$returnURL = $url.'/paypal/subscr_success?sub_type=subscr&amt='.$get_pay['Fee'].'&reg_user='.$get_subscr['User_ID'];

				$cancelURL = $url.'/paypal/subscr_cancel';	//payment cancel url
				$notifyURL  = $url.'/paypal/subscr_ipn';		//ipn url

				$this->paypal_lib->add_field('business', $paypal_id);
				$this->paypal_lib->add_field('cmd', "_xclick-subscriptions");
				$this->paypal_lib->add_field('return', $returnURL);
				$this->paypal_lib->add_field('cancel_return', $cancelURL);
				$this->paypal_lib->add_field('currency_code', $currency_code);
				$this->paypal_lib->add_field('notify_url', $notifyURL);
				$this->paypal_lib->add_field('on0', $get_subscr['User_ID']);
				$this->paypal_lib->add_field('custom', $get_subscr['User_ID'].'-'.$this->academy_id);
				$this->paypal_lib->add_field('a3', $get_pay['Fee']);
				$this->paypal_lib->add_field('t3', $get_pay['Frequency_Code']);
				$this->paypal_lib->add_field('p3', 1);
				$this->paypal_lib->add_field('src', 1);
				//$this->paypal_lib->add_field('srt',  10);
				$this->paypal_lib->add_field('sra', 2);
				$this->paypal_lib->add_field('item_number', $get_pay['Membership_ID']);
				$this->paypal_lib->add_field('item_name', $get_pay['Membership_ID'].'-'.$get_pay['Membership_Type']);
				$this->paypal_lib->image($logo);
				$this->paypal_lib->test_paypal_auto_form();
			}
			else{
				echo "Invalid Access!";
			}
		}

}