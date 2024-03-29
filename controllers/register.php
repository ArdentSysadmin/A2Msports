<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

       session_start(); 

	// Register controller 
	class Register extends CI_Controller {
	
		public function __construct()
		{
			parent:: __construct();
			$this->load->helper(array('form', 'url'));

			$this->load->library('form_validation');
			$this->load->library('session');
			$this->load->model('model_general', 'general');
			$this->load->model('academy_mdl/model_general2', 'aca_general');
			$this->load->model('model_register', 'reg_model');
			$this->load->model('model_news');
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

		// load the registration page .... 
		public function index()
		{

			if($this->session->userdata('users_id')){
				redirect('profile');
			}

			if(isset($_GET['r'])){

				$page = $_GET['r'];
				$this->session->unset_userdata('redirect_to');

				$data['intrests'] = $this->reg_model->get_intrests();
				//print_r($data);
				$data['results']  = $this->model_news->get_news();
				
					$this->load->view('includes/header_static');

				if($page == 'player'){
					$this->load->view('view_register', $data);
				}
				else if($page == 'coach'){
					$this->load->view('view_coach_register', $data);
				}
				else if($page == 'club-owner'){
					$this->load->view('view_club_register', $data);
				}
				else {
					echo "Invalid Request!";
					exit;
				}

					$this->load->view('includes/footer_static');
			}
			else{
					$this->load->view('view_reg_popup', $data);
			}

			//echo "testing"; exit;
			
		}


		//register the user into the database ..
		public function save_mobileuser()
		{
			if($this->input->post('reg_user')){

				if($this->input->post('token')){
						$exp	= explode('.', $this->input->post('token'));
						$arr		= json_decode(base64_decode($exp[1]), true);
						$exp_time = $arr['exp'];
						$cur_time = strtotime(date('Y-m-d H:i:s'));
						//echo "<pre>"; print_r($arr); exit;
						if($cur_time < $exp_time){
						$phone	= $arr['phone_number'];
						$ph			= substr($phone, -10);
							if($phone != $this->input->post('Mobilephone')){
							echo "Invalid Mobile Number. Please contact admin!";
							exit;
							}
						}
						else{
							echo "Token Expired. Please try again!";
							exit;
						}
				}

			/*$data['aca_id']			= $academy	= $this->input->post('academy');
			$data['shortcode']	= $shortcode	= $this->input->post('shortcode');

			$query  = $this->reg_model->get_email($email_id);
			$status  = '';
				*/
 				if($query){
				 	$err_msg = $email_id." is already exists! Please choose another Email ID.";
					$this->session->set_flashdata('err_msg', $err_msg);
					redirect('register');
				}
				else{

			
					if($this->input->post('CountryName'))
					$data['latt'] = $this->get_lang_latt();

					$data['mobileuser'] = 1;
			
					$res = $this->reg_model->insert_user($data);

				    $data['results'] = $this->model_news->get_news();
				
					if($this->session->userdata('redirect_to') and !$this->input->post('token')){
						if($academy){
							redirect($shortcode."?st=1");
						}
						else{
							$red = $this->session->userdata('redirect_to').'/8';
							redirect($red);
						}
					}
					else{
						$this->create_user_session($res['Users_ID'], 1);
						/*$this->load->view('includes/header');
						$this->load->view('view_register_complete');
						$this->load->view('includes/view_right_column' ,$data);
						$this->load->view('includes/footer');*/
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

		public function create_user_session($user, $is_valid){

			if($is_valid == '1') {
				$get_data = $this->general->get_user($user);
				if($get_data) {
					$notify = json_decode($get_data['NotifySettings']);

					if(in_array('2', $notify)) {
					$email_notify = 1;
					}
					else {
					$email_notify = 0;
					}

					$new_user = array(
					'user'				=>	$get_data['Firstname']." ".$get_data['Lastname'], 
					'email'			=>	$get_data['EmailID'],
					'username'		=>	$get_data['Username'],
					'users_id'		=>	$get_data['Users_ID'], 
					'lat'				=>	$get_data['Latitude'],
					'long'				=>	$get_data['Longitude'],
					'role'				=>	$get_data['Role'],
					'admin'			=>	$get_data['Role'],
					'email_notify'	=>	$email_notify);

				$this->session->set_userdata($new_user);

				$data['users_id'] = $this->session->userdata('users_id');
				$data['lat']			 = $this->session->userdata('lat');
				$data['long']		 = $this->session->userdata('long');
				$data['range']	 = 10;

				$this->reg_model->insert_a2mscore();  
				// Insert default score entries for a user if, he doesn't have records in A2MScore table

				$data['interests']	 = $this->reg_model->get_sports();
				$data['tournments'] = $this->reg_model->get_all($data);

				if($this->input->post('academy')) {
					if($this->input->post('aca_page'))
						redirect($this->input->post('shortcode')."/".$this->input->post('aca_page'));
					else
						redirect($this->input->post('shortcode'));
				}

				if(($this->session->userdata('redirect_to'))) {
					$exp = explode('.com', $this->session->userdata('redirect_to'));
					redirect($exp[1]);
				}
				else {
					redirect('Play', $data);
				}
				}
			}
		}

		public function save_user_data()
		{
			//echo $this->session->userdata('redirect_to');
			//exit;
			//echo "Please try again after sometime! Sorry."; echo "<pre>"; print_r($_POST); exit;
			
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

					// image resize code ends ....  ////
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
					$data['latt'] = $this->get_lang_latt();
			
					$res = $this->reg_model->insert_user($data);

				    $email_stat = $this->user_email($res);
				    $data['results'] = $this->model_news->get_news();
				
					if($this->session->userdata('redirect_to')){
						if($academy){
							redirect($shortcode."?st=1");
						}
						else{
							$red = $this->session->userdata('redirect_to').'/8';
							redirect($red);
						}
					}
					else{
						/*$this->load->view('includes/header');
						$this->load->view('view_register_complete');
						$this->load->view('includes/view_right_column' ,$data);
						$this->load->view('includes/footer');*/
						redirect(base_url()."register/success");
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

	public function success(){
			$this->load->view('includes/header');
			$this->load->view('view_register_complete');
			$this->load->view('includes/view_right_column' ,$data);
			$this->load->view('includes/footer');
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

	public function ajax_email_verify($email_id = '')
	{
		$email_id =  $this->input->post('email_id');				
			$query = $this->reg_model->ajax_check_email($email_id);
			
			$status = "";
		if($query){
			$status = $query['Users_ID']."-".$query['EmailID'];
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
			
			if($activation_code != ""){
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
			else{
				return false;
			}
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
			//echo $is_activated; exit;
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

/*
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
*/

		public function instant_register(){
		//echo "<pre>"; print_r($_POST); exit;
			if($this->input->post('email')){
				$check_user_exists = $this->reg_model->get_email($this->input->post('email'));
				if($check_user_exists){
					echo "User with this email id already exists!";
					exit;
				}
			}
				
                $data['latt'] = $this->get_lang_latt();
			
				$ins_user = $this->reg_model->instant_register($data);

				if(!empty($ins_user)){
					$fname			= $ins_user['firstname'];
					$lame			= $ins_user['lastname'];
					$phone			= $ins_user['phone'];
					$users_id		= $ins_user['users_id'];

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


		public function instant_clubmember(){
		
			if($this->input->post('txt_email')){

				$check_user_exists = $this->reg_model->get_email($this->input->post('txt_email'));
				
				if(!$check_user_exists){

                $data['latt'] = $this->get_lang_latt();
				$ins_user	  = $this->reg_model->instant_clubmember($data);

				if(!empty($ins_user)){

// -------------------------------------------------
				$new_user_id = $ins_user['users_id'];

				$cur_date = date('Y-m-d');

				$mem_status = 0;

				$mem_code = $this->input->post('mem_code');

			if($this->input->post('membership_sd'))
				$sdate = date('Y-m-d', strtotime($this->input->post('membership_sd')));

			if($this->input->post('membership_ed'))
				$edate  = date('Y-m-d', strtotime($this->input->post('membership_ed')));


			if($this->input->post('mem_paid')){

					if($cur_date <= $edate)
					$mem_status = 1;
					if($mem_code != ''){
						//$get_user_id = $this->aca_general->get_onerow('User_memberships', 'tab_id', $rec_id);
						$academy = $this->input->post('Aca_ID');
						$club_info = $this->aca_general->get_onerow('Academy_Info', 'Aca_ID', $academy);
						//Send payNow links to User
							//$ins_user		= $get_user_id['Users_id'];
							$mem_det	    = $this->aca_general->get_onerow('Membership_Types', 'tab_id', $mem_code);
//echo "<pre>"; print_r($mem_det); exit;
							if($mem_det){
								$pp_data['Membership_ID']	= $mem_det['Membership_ID'];
								$pp_data['Membership_Type'] = $mem_det['Membership_Type'];
								$pp_data['Frequency'] = $mem_det['Frequency'];
								$pp_data['Frequency_Code'] = $mem_det['Frequency_Code'];
								$pp_data['Fee'] = $mem_det['Fee'];
								$pp_data['Act_Fee'] = $mem_det['ActivationFee'];

								$pp_data['User_ID'] = $new_user_id;

							$ins_ot_pay_id = '';
							if($mem_det['ActivationFee'] > 0){
							$data9 = array('Club_ID' => $academy, 'User_ID' => $new_user_id, 'Membership_Code' => $mem_det['Membership_ID'], 'Type' => 'OT', 'Pay_Status' => 'PAID', 'Created_On' => date('Y-m-d H:i:s'));
								
							//$ins_ot_pay_id = $this->aca_general->insert_table_data('Membership_PaymentLinks', $data9);
							}

							$data10 = array('Club_ID' => $academy, 'User_ID' => $new_user_id, 'Membership_Code' => $mem_det['Membership_ID'], 'Type' => 'SUBSCR', 'Pay_Status' => 'PAID', 'Created_On' => date('Y-m-d H:i:s'));

							//$ins_subscr_pay_id = $this->aca_general->insert_table_data('Membership_PaymentLinks', $data10);
							$user_info = $this->aca_general->get_onerow('Users', 'Users_ID', $new_user_id);
							$club_name = $club_info['Aca_name'];
								$this->user_email_paid_subscr($user_info, $pp_data, $club_name,$club_info['Aca_URL_ShortCode']);
								//exit;
							}
						//Send payNow links to User
					}
				
				}
				else{
					if($mem_code != ''){
						//$get_user_id = $this->aca_general->get_onerow('User_memberships', 'tab_id', $rec_id);
						$academy = $this->input->post('Aca_ID');
						$club_info = $this->aca_general->get_onerow('Academy_Info', 'Aca_ID', $academy);
						//Send payNow links to User
							//$ins_user		= $get_user_id['Users_id'];
							$mem_det	    = $this->aca_general->get_onerow('Membership_Types', 'tab_id', $mem_code);
//echo "<pre>"; print_r($mem_det); exit;
							if($mem_det){
								$pp_data['Membership_ID']	= $mem_det['Membership_ID'];
								$pp_data['Membership_Type'] = $mem_det['Membership_Type'];
								$pp_data['Frequency'] = $mem_det['Frequency'];
								$pp_data['Frequency_Code'] = $mem_det['Frequency_Code'];
								$pp_data['Fee'] = $mem_det['Fee'];
								$pp_data['Act_Fee'] = $mem_det['ActivationFee'];

								$pp_data['User_ID'] = $new_user_id;

							$ins_ot_pay_id = '';
							if($mem_det['ActivationFee'] > 0){
							$data9 = array('Club_ID' => $academy, 'User_ID' => $new_user_id, 'Membership_Code' => $mem_det['Membership_ID'], 'Type' => 'OT', 'Pay_Status' => 'NOT PAID', 'Created_On' => date('Y-m-d H:i:s'));
								
							$ins_ot_pay_id = $this->aca_general->insert_table_data('Membership_PaymentLinks', $data9);
							}

							$data10 = array('Club_ID' => $academy, 'User_ID' => $new_user_id, 'Membership_Code' => $mem_det['Membership_ID'], 'Type' => 'SUBSCR', 'Pay_Status' => 'NOT PAID', 'Created_On' => date('Y-m-d H:i:s'));

							$ins_subscr_pay_id = $this->aca_general->insert_table_data('Membership_PaymentLinks', $data10);
							$user_info = $this->aca_general->get_onerow('Users', 'Users_ID', $new_user_id);
							$club_name = $club_info['Aca_name'];
								$this->user_email_pp_subscr($user_info, $pp_data, $ins_ot_pay_id, $ins_subscr_pay_id, $club_name,$club_info['Aca_URL_ShortCode']);
								//exit;
							}
						//Send payNow links to User
					}
				}

				$data98   = array('Club_id' => $academy, 'Users_id' => $new_user_id, 'Membership_Code' => $mem_code);
				$data99   = array('StartDate' => $sdate, 'EndDate' => $edate, 'Member_Status' => $mem_status);

//echo "<pre>"; print_r($_POST); exit;
			$upd_mem = $this->aca_general->upd_membership($data98, $data99);

// -------------------------------------------------
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

		public function user_email_pp_subscr($res, $pp_data, $ot_id, $subscr_id, $club_name, $club_short_code)
		{
			$first_name	= $res['Firstname'];
			$last_name	= $res['Lastname'];
			$email				= $res['EmailID'];


			$this->load->library('email');
			$this->email->set_newline("\r\n");
		
			$this->email->from(FROM_EMAIL, 'A2MSports');
			$this->email->to($email); 
			$this->email->subject($club_name." Subscription updated!");

			$data = array(
             'Firstname'	=> $first_name,
			 'Lastname'	=> $last_name,
			 'club_name' => $club_name,
			 'club_sc' => $club_short_code,
			 'mem_info'	=> $pp_data,
			 'ot_id'			=> $ot_id,
			 'subscr_id'		=> $subscr_id,
			 'page'				=> 'ClubAdmin Updates Member PayNow');

			$body = $this->load->view('view_email_template.php', $data, TRUE);
			/*echo "<pre>"; 
			print_r($data);
			echo $body; 
			exit;*/
			$this->email->message($body);   
			$stat = $this->email->send();
			
			return $stat;
		}


		public function user_email_paid_subscr($res, $pp_data, $club_name,$club_short_code)
		{
			$first_name	= $res['Firstname'];
			$last_name	= $res['Lastname'];
			$email				= $res['EmailID'];

			$this->load->library('email');
			$this->email->set_newline("\r\n");
		
			$this->email->from(FROM_EMAIL, 'A2MSports');
			$this->email->to($email); 
			$this->email->subject($club_name." Subscription updated!");

			$data = array(
             'Firstname'	=> $first_name,
			 'Lastname'	=> $last_name,
			 'club_name' => $club_name,
			 'club_sc' => $club_short_code,
			 'mem_info'	=> $pp_data,
			 'page'				=> 'ClubAdmin Updates Member SubScr Paid');

			$body = $this->load->view('view_email_template.php', $data, TRUE);
			/*echo "<pre>"; 
			print_r($data);
			echo $body; 
			exit;*/
			$this->email->message($body);   
			$stat = $this->email->send();
			
			return $stat;
		}

}