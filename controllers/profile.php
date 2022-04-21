<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

session_start();
//Player Profile controller ..
class Profile extends CI_Controller {

	public function __construct()
	{
		parent:: __construct();

			$this->load->helper(array('form', 'url'));
			$this->load->library('form_validation');
			$this->load->library('session');

			$this->load->model('model_profile', 'profile');
			$this->load->model('model_general', 'general');
			$this->load->model('model_news');

		if(!$this->session->userdata('users_id'))
		{
			redirect('login');
		}
	}

	// Profile default page...
	public function index($stat = '')
	{
			$logged_user = $this->session->userdata('users_id');

			if($stat)
				$data = $stat;

			$data['sports_details'] = $sports_details = $this->profile->get_intrests();
			$user_sports_intrests			= $this->profile->get_user_sport_intrests();
			$data['user_sports_intrests']	= $user_sports_intrests;

			$sp_intrests = "(";
			//foreach($user_sports_intrests as $i => $usi){
			foreach($sports_details as $i => $usi){
				//$sp_intrests .= $usi->Sport_id;
				$sp_intrests .= $usi->SportsType_ID;
				if(count($sports_details) != ++$i){
					$sp_intrests .= ", ";
				}
			}
			$sp_intrests .= ")";

			$get_stats1  = $this->profile->get_user_single_stats($logged_user, $sp_intrests);
			$get_stats2  = $this->profile->get_user_line_stats($logged_user, $sp_intrests);
			
			$get_stats = array_merge($get_stats1, $get_stats2);

			$get_clubs = $this->profile->get_clubs();

			$json_clubs = '[';
			foreach($get_clubs as $i => $club){
				$temp = str_replace('"', '', $club->Aca_name);
				$temp = str_replace("'", '', $temp);
				$json_clubs .= '{"label": "'.$temp.'",'.' "value": "'.$club->Aca_ID.'"}';
				if(count($get_clubs) != ($i+1))
					$json_clubs .= ",";
			}
			$json_clubs .= ']';

			

		/*[{label: "Chicago (USA)", value: "Chicago"},
		{label: "Chennai (India)", value: "Chennai"},
		{label: "Cambridge (England)", value: "Cambridge"},
		{label: "USATT (SriLanka)", value: "Colombo"}]*/

			$test = "<script>var clubs = ".$json_clubs.";</script>";
			$data['test']				= $test;
			//$data['json_clubs']			= $json_clubs;

			$data['user_matches']			= $this->profile->get_user_matches();
			$user_tournment_matches			= $this->profile->get_user_tournment_matches();
			$data['user_tournment_matches'] = $user_tournment_matches;
			$user_tournment_team_matches		 = $this->profile->get_user_tournment_team_matches();
			$data['user_tournment_team_matches'] = $user_tournment_team_matches;

			$data['num_matches']		= $this->profile->get_num_matches();
			$data['membership_details'] = $this->profile->get_membership_details();
						
			$played = 0;
			$won    = 0;
			$lost   = 0;
			$points_for     = 0;
			$points_against = 0;
			$stats			= array();
			//echo "<pre>"; print_r($get_stats);
			foreach($get_stats as $utm){
				if($utm->Winner != 0 and $utm->Winner != NULL){

				if($logged_user == $utm->Player1 or $logged_user == $utm->Player1_Partner 
				or $logged_user == $utm->Player2 or $logged_user == $utm->Player2_Partner){
				($stats[$utm->SportsType]['played']) ? 
					$stats[$utm->SportsType]['played']++ : $stats[$utm->SportsType]['played'] = 1;
				}
				if($logged_user == $utm->Winner){
				($stats[$utm->SportsType]['won']) ? 
					$stats[$utm->SportsType]['won']++ : $stats[$utm->SportsType]['won'] = 1;
				}
				else if($logged_user != $utm->Winner and $utm->Winner != NULL){
				($stats[$utm->SportsType]['lost']) ? 
					$stats[$utm->SportsType]['lost']++ : $stats[$utm->SportsType]['lost'] = 1;
				}

				$for_score	   = ($logged_user == $utm->Player1 or $logged_user == $utm->Player1_Partner) ?
								 $utm->Player1_Score : $utm->Player2_Score;

				$against_score = ($logged_user == $utm->Player1 or $logged_user == $utm->Player1_Partner) ?
									 $utm->Player2_Score : $utm->Player1_Score;
					
					if($for_score){
						$for = json_decode($for_score, true);
						$tot = 0;
						foreach($for as $sc)
							$tot += $sc;
						($stats[$utm->SportsType]['points_for']) ? 
							$stats[$utm->SportsType]['points_for'] += $tot : $stats[$utm->SportsType]['points_for'] = $tot;
					}

					if($against_score){
						$against = json_decode($against_score, true);
						$tot = 0;
						foreach($against as $sc)
							$tot += $sc;
						($stats[$utm->SportsType]['points_against']) ? 
							$stats[$utm->SportsType]['points_against'] += $tot : $stats[$utm->SportsType]['points_against'] = $tot;
					}
				}
			}

			$data['user_stats'] = $stats;

		if($this->session->userdata('is_social') != true)
		{

			$data['user_details'] = $this->profile->get_user_data();

			$data['results'] = $this->model_news->get_news();

			$this->load->view('includes/header');
			$this->load->view('view_profile',$data);
			$this->load->view('includes/view_right_column',$data);
			$this->load->view('includes/footer');
		}
		else
		{
			$data['user_details']	= $this->profile->get_social_user_data();
			$data['results']		= $this->model_news->get_news();

			$this->load->view('includes/header');
		   
			if($data['user_details']['IsProfileUpdated']==1) {
				$this->load->view('view_profile',$data);
				$this->load->view('includes/view_right_column',$data);
			} else {
				$this->load->view('view_fb_profile',$data);
			}
			$this->load->view('includes/footer');
		}
	}

	public function add_profile()
	{
	  if(!$this->session->userdata('email')){
		redirect('login');
	  }
	  else{
		$data['user_details']	= $this->profile->get_user_data();
		$data['results']		= $this->model_news->get_news();

		$this->load->view('includes/header');
		$this->load->view('view_add_profile',$data);
		$this->load->view('includes/footer');
	  }
	}


	 public function check_username($user_name = '')
	 {
		$user_name =  $this->input->post('user_name');				
			$query = $this->profile->check_username($user_name);
			
		$status = $user_name.' '.'is already exists!';
		if($query != 1){
			$status = "";
			}                
		echo $status;
     }


		public function add_player(){
			if($this->input->post('submit')){
					
				 $filename = 'Profilepic';
				 $config = array(
						'upload_path' => "./profile_pictures/",
						'allowed_types' => "gif|jpg|png|jpeg",
						'overwrite' => FALSE,
						'max_size' => "10000", // Can be set to particular file size , here it is 2 MB(2048 Kb)
						'max_height' => "5000",
						'max_width' => "8000"
						);
				
				$this->load->library('upload');
				$this->upload->initialize($config); 

				if($this->upload->do_upload($filename)){	
					
					$data['profile_pic_data'] = $this->upload->data();
					$upload_data = $data['profile_pic_data'];

					//to resize upload profile picture ...
					$resize_conf =	
						array(
							'upload_path'  => "./profile_pictures/thumbs/",
							'source_image' => $upload_data['full_path'], 
							//'new_image'    => './tour_pictures/$tourn_id/thumbs/'.$upload_data['file_name'],
							'new_image'    => $upload_data['file_path'].'thumbs/'.$upload_data['file_name'],
							'width'        => '200',
							'height'       => '239'
						);

					$this->load->library('image_lib');  
					$this->image_lib->initialize($resize_conf);
					
					// do it!
					if ( ! $this->image_lib->resize()){
						// if got fail.
						$error['resize'] = $this->image_lib->display_errors();		
					}
					else{
						$data_to_store['userfile'] = $upload_data['file_name'];						
						$data1['userfile'] = $upload_data['file_name'];
						//exit;
					}	

					//end resize of profile picture ...

					//$data = $this->upload->data();
					$data['latt'] = $this->get_lang_latt();
					
					$res = $this->profile->insert_player_data($data);
					
				}
				else {
					$data['latt'] = $this->get_lang_latt();
					$res = $this->profile->insert_player_data($data);
				}

				 $email_stat = $this->user_email($res);
						 
				 if($email_stat){
					  $data['results'] = $this->model_news->get_news();
					  //$this->session->set_flashdata('redirect_page', 'Play');

						$this->load->view('includes/header');
						$this->load->view('view_add_player_complete');
						$this->load->view('includes/view_right_column' ,$data);
						$this->load->view('includes/footer');
				 }
				 else{
						echo "New Player creation is not completed. Please contact us info@a2msports.com";
				 }
			}
			else{
				echo "Invalid Request";
			}

		}

		public function user_email($res){

			$name = $this->session->userdata('user');
			$username = trim($this->input->post('user_name'));
			$password = trim($this->input->post('Password'));
			$email = $this->session->userdata('email');

			$this->load->library('email');
			$this->email->set_newline("\r\n");
		
			$this->email->from('admin@a2msports.com', 'A2MSports');
			$this->email->to($email); 
			$this->email->subject('New Profile Registration');

			$data = array(
			 'name'=> $name,
			 'username'=> $username,
			 'password'=> $password,
			 'page'=> 'New Add Player'
			);

			$body = $this->load->view('view_email_template.php',$data,TRUE);
			$this->email->message($body);   
			$stat = $this->email->send();
			
			return $stat;
		}


		public function update_fb_user_data()
		{
			//echo "<pre>"; print_r($_POST); exit;
			 $filename = 'Profilepic';

			 $config = array(
					'upload_path' => "./profile_pictures/",
					'allowed_types' => "gif|jpg|png|jpeg|pdf",
					'overwrite' => FALSE,
					'max_size' => "204800", // Can be set to particular file size , here it is 2 MB(2048 Kb)
					'max_height' => "5000",
					'max_width' => "8000"
					);

				$this->load->library('upload', $config);
				$this->upload->initialize($config);

				if($this->upload->do_upload($filename))
				{	
					
					$data['profile_pic_data'] = $this->upload->data();
					$upload_data = $data['profile_pic_data'];

					//to resize upload profile picture 
					$resize_conf =	
						array(
							'upload_path'  => "./profile_pictures/thumbs/",
							'source_image' => $upload_data['full_path'], 
							//'new_image'    => './tour_pictures/$tourn_id/thumbs/'.$upload_data['file_name'],
							'new_image'    => $upload_data['file_path'].'thumbs/'.$upload_data['file_name'],
							'width'        => '200',
							'height'       => '239'
						);

					$this->load->library('image_lib');  
					$this->image_lib->initialize($resize_conf);
					
					// do it!
					if ( ! $this->image_lib->resize()){
						// if got fail.
						$error['resize'] = $this->image_lib->display_errors();		
					}
					else{
						$data_to_store['userfile'] = $upload_data['file_name'];						
						$data1['userfile'] = $upload_data['file_name'];
						//exit;
					}	

					//end resize of profile picture 
					
					///$data = $this->upload->data();
					//$this->upload->initialize($config);

					$data['latt'] = $this->get_lang_latt();

					$lat_long = $data['latt'];
					$pieces = explode("@", $lat_long);
			
					$latitude = $pieces[0];
					$longitude = $pieces[1];
					
					$res = $this->profile->insert_fbprofile_data($data);
					
					$this->session->set_userdata('lat',$latitude );
					$this->session->set_userdata('long',$longitude);

					//print_r($this->session->userdata);
					//exit;
			

					if($res){
						redirect('Play');
					}
				}
				else 
				{
					$data['latt'] = $this->get_lang_latt();
					$lat_long = $data['latt'];
					$pieces = explode("@", $lat_long);
			
					$latitude = $pieces[0];
					$longitude = $pieces[1];

					$res = $this->profile->insert_fbprofile_data($data);

					$this->session->set_userdata('lat',$latitude );
					$this->session->set_userdata('long',$longitude);

					//print_r($this->session->userdata);
					//exit;

					if($res)
					{
						redirect('Play');
					}
				}

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

			 $city = $this->input->post('CityName');


			 $address =  $address2 . ' ' .  $country . ' ' .  $state . ' ' .  $city ;

				if(!empty($address)){

				//Formatted address
				$formattedAddr = str_replace(' ','+',$address);

				//Send request and receive json data by address
				$geocodeFromAddr = file_get_contents('https://maps.googleapis.com/maps/api/geocode/json?address='.$formattedAddr.'&key='.GEO_LOC_KEY); 

				$output1 = json_decode($geocodeFromAddr);
				
				$latitude  = 0.00; 
				$longitude = 0.00;
			
				//Get latitude and longitute from json data
				$latitude  = $output1->results[0]->geometry->location->lat; 
				$longitude = $output1->results[0]->geometry->location->lng;

				return  $latitude  . '@' . $longitude ;
				} else {
					return false;
	 			}

	    }


		//Update the normal user details in profile tab .....

			public function update_user_data()
			{
				$data['latt'] = $this->get_lang_latt();
				
				$res = $this->profile->update_profile_data($data);
				if($res)	{
					redirect('profile');
				}
		    }

			public function update_user_sports()
			{	
	
				$res = $this->profile->update_profile_user_sport();
				if($res)
				{
					redirect('profile');
				}
				
		   }

		   public function add_membership()
		   {	
				
				$res = $this->profile->add_membership_details();
				if($res)
				{
					redirect('profile');
				}

		    }

			public function delete_membership()
		    {	
				
				$this->profile->delete_membership();
				
				redirect('profile');
			
		    }
	

		//change the profile picture 
		public function upload_pic(){

			$status		=	'';
			$msg		=	'';
			$filename =	'Profilepic';

			 $config = array(
					'upload_path'	 => "./profile_pictures/",
					'allowed_types'  => "gif|jpg|png|jpeg|pdf",
					'overwrite'			 => FALSE,
					'max_size'			 => "10000", // Can be set to particular file size , here it is 2 MB(2048 Kb)
					'max_height'		 => "5000",
					'max_width'		 => "8000"
					);

			$this->load->library('upload', $config);
			$data = $this->upload->data();

			$this->upload->initialize($config);
			
			if($this->input->post('Profilepic_ajax') != '') {
				//if($this->upload->do_upload($filename)) {
					$data['file_name'] = $this->input->post('Profilepic_ajax');
					//$data['profile_pic_data'] = $this->upload->data();
					//$upload_data = $data['profile_pic_data'];

					//to resize upload profile picture 
					/*$resize_conf =	
						array(
							'upload_path'	=> "./profile_pictures/thumbs/",
							'source_image' => $upload_data['full_path'], 
							//'new_image'   => './tour_pictures/$tourn_id/thumbs/'.$upload_data['file_name'],
							'new_image'		=> $upload_data['file_path'].'thumbs/'.$upload_data['file_name'],
							'width'				=> '200',
							'height'				=> '239'
							);

						$this->load->library('image_lib');  
						$this->image_lib->initialize($resize_conf);
						
						// do it!
						if (!$this->image_lib->resize()) {
							// if got fail.
							$error['resize'] = $this->image_lib->display_errors();		
						}
						else {
							$data_to_store['userfile'] = $upload_data['file_name'];						
							$data1['userfile']				= $upload_data['file_name'];
							//exit;
						}
					*/
					//end resize of profile picture 
					
					// Deleting of Old Profile Pic
					$get_user			= $this->profile->get_user_data();
					$data['del_pic'] = $get_user['Profilepic'];
					$this->load->helper("url");
					
					$path	= './profile_pictures/'.$data['del_pic'];
					$path1 = './profile_pictures/thumbs/'.$data['del_pic'];
					unlink($path);
					unlink($path1);

					// Update the table with new Profile pic name
					$res = $this->profile->update_picture($data);
					
					if($res) {
						/*$data['user_details'] = $this->profile->get_user_id();
						$data['sports_details'] = $this->profile->get_intrests();
						$data['user_sports_intrests'] = $this->profile->get_user_sport_intrests();
						$data['results'] = $this->model_news->get_news();
						$data['num_matches'] = $this->profile->get_num_matches();

						$data['user_matches'] = $this->profile->get_user_matches();
						$data['user_tournment_matches'] = $this->profile->get_user_tournment_matches();
					
						//$data['pic'] = "Your profile picture Updated Successfully.";
						
						$this->load->view('includes/header');
						$this->load->view('view_profile', $data);
						$this->load->view('includes/view_right_column');
						$this->load->view('includes/footer');*/
						redirect("profile");
					}
					else {
						unlink($data['full_path']);
					}
				//}
			}
			else
			{
				//$data['pic_error'] = "Your profile picture Updated Successfully.";
				$data['user_details'] = $this->profile->get_user_id();
				$data['sports_details'] = $this->profile->get_intrests();
				$data['user_sports_intrests'] = $this->profile->get_user_sport_intrests();
				$data['user_matches'] = $this->profile->get_user_matches();
				$data['user_tournment_matches'] = $this->profile->get_user_tournment_matches();
				$data['num_matches'] = $this->profile->get_num_matches();
				$data['results'] = $this->model_news->get_news();

				$this->load->view('includes/header');
				$this->load->view('view_profile',$data);
				$this->load->view('includes/view_right_column');
				$this->load->view('includes/footer');
			}
		}

		public function upload_pic_ajax() {

			if($this->input->post('image')) {
				$data = $this->input->post('image');

				$image_array_1 = explode(";", $data);
				$image_array_2 = explode(",", $image_array_1[1]);

				$data = base64_decode($image_array_2[1]);

				$image_name = 'new_' . time() . '.png';
				$path = './profile_pictures/'.$image_name;

				file_put_contents($path, $data);

				echo base_url().'profile_pictures/'.$image_name;
			}

		}

		public function change_password()
	    {
		   
			//$result = $this->profile->check_oldPass(md5($this->input->post('old_password')));
			$result = 1;

			if($result){
				if($this->input->post('email2')){
				$update = $this->profile->save_newEmail($this->input->post('email2'));
				}

				$update = $this->profile->save_newPass(md5($this->input->post('new_password')));
				$data['pass'] = "Password Updated Successfully.";
			}
			else{
			    $data['pass_error'] = "Current Password is wrong";
			}

					/*$data['user_details'] = $this->profile->get_user_id();
					$data['sports_details'] = $this->profile->get_intrests();
					$data['user_sports_intrests'] = $this->profile->get_user_sport_intrests();
					$data['results'] = $this->model_news->get_news();
					$data['user_matches'] = $this->profile->get_user_matches();
					$data['user_tournment_matches'] = $this->profile->get_user_tournment_matches();
					$data['num_matches'] = $this->profile->get_num_matches();
				
					$this->load->view('includes/header');
					$this->load->view('view_profile',$data);
					$this->load->view('includes/view_right_column');
					$this->load->view('includes/footer');*/
					$this->index($data);

		}
		
		public function get_user_det($user_id)
		{
			return $this->general->get_user($user_id);
		}

		public function get_gen_mat_det($gen_match_id)
		{
			return $this->profile->get_gen_mat_det($gen_match_id);
		}

		public function get_sport($sport_id)
		{
			return $this->general->get_sport_title($sport_id);
		}

		public function get_club($org_id)
		{
			return $this->profile->get_club($org_id);
		}

		public function get_tourn_name($tourn_id)
		{
			return $this->profile->get_tourn_name($tourn_id);
		}

		public function get_sport_levels($sport_id)
		{
			return $this->profile->get_sport_levels($sport_id);
		}

		public function edit_club($tab_id = "")
		{
			
			$tab_id = $this->input->post('id');
			$user_id = $this->session->userdata('users_id');
			
			$data['club_details'] = "";
			$data['tab_id'] = $tab_id;
			$data['user_id'] = $user_id;
			
			$res = $this->profile->get_club_details($data);

			$club_name = $this->profile->get_club_name($res['Club_id']);
			$org_name = $club_name['Aca_name'];

			//$sport = $this->get_sport($res['Related_Sport']);
			//$sport_name = $sport['Sportname'];

			$mem_id =  $res['Membership_ID'];
			$sport =  $res['Related_Sport'];
			$org_id =  $res['Club_id'];
			$tab_id =  $res['tab_id'];

			echo $mem_id."#".$org_name."#".$sport."#".$org_id."#".$tab_id;
			
		}

		public function edit_coach()
		{
			
			$data['sports_details'] = $this->profile->get_intrests();
			$user_id = $this->session->userdata('users_id');

			$res = $this->profile->get_user_data();

			$profile =  $res['coach_profile'];
			$website =  $res['Coach_Website'];
			$c_sport =  $res['coach_sport'];
			
			echo $profile."#".$c_sport."#".$website;
			
		}

		public function update_coach()
		{	
			$res = $this->profile->update_coach_details();

			if($res){
				redirect('profile');
			}
		 }

		public function insert_coach()
		{	
				
			$res = $this->profile->update_coach_details();
			if($res)
			{
				redirect('profile');
			}

		 }

		public function delete_coach()
		{	
			$res = $this->profile->delete_coach_details();

			echo $res;
			//if($res)
		//	{
		//		redirect('profile');
		//	}
	
		 }


		 public function update_membership(){		
			 //error_reporting(-1);
				$res = $this->profile->update_membership_details();
				if($res > 0){
					//redirect('profile');
					echo "Successfully Updated";
				}
				else if($res == -1){
					echo "Provided Membership ID is not matching with the details with USATT Data!";
				}
				else{
					echo "Error in update! please contact admin.";
				}
		 }


	public function get_a2msocre($sport, $user_id = ''){
		if(!$user_id)
			$user_id = $this->session->userdata('users_id');
		return $this->profile->get_a2msocre($sport, $user_id);
	}
	public function get_winper($sport, $user_id = ''){
		if(!$user_id)
			$user_id = $this->session->userdata('users_id');
		return $this->profile->get_winper($sport, $user_id);
	}

	public function get_user_opponent_stats(){
		$opp_user	 = $this->input->post('opp');
		$logged_user = $this->session->userdata('users_id');

		if($opp_user == -1){
			$opp_user = $logged_user;
		}
		if($logged_user){
			$user_sports_intrests = $this->profile->get_user_sport_intrests();
			$sp_intrests = "(";
			foreach($user_sports_intrests as $i => $usi){
				$sp_intrests .= $usi->Sport_id;
				if(count($user_sports_intrests) != ++$i){
					$sp_intrests .= ", ";
				}
			}
			$sp_intrests .= ")";


			$get_stats = $this->profile->get_user_single_stats($logged_user, $sp_intrests);
			$played = 0;
			$won    = 0;
			$lost   = 0;
			$points_for     = 0;
			$points_against = 0;
			$user_stats			= array();

			foreach($get_stats as $utm){
				if($utm->Winner != 0 and $utm->Winner != NULL 
					and ($opp_user == $utm->Player1 or $opp_user == $utm->Player1_Partner 
				or $opp_user == $utm->Player2 or $opp_user == $utm->Player2_Partner)){

				if($logged_user == $utm->Player1 or $logged_user == $utm->Player1_Partner 
				or $logged_user == $utm->Player2 or $logged_user == $utm->Player2_Partner){
				($user_stats[$utm->SportsType]['played']) ? 
					$user_stats[$utm->SportsType]['played']++ : $user_stats[$utm->SportsType]['played'] = 1;
				}
				if($logged_user == $utm->Winner){
				($user_stats[$utm->SportsType]['won']) ? 
					$user_stats[$utm->SportsType]['won']++ : $user_stats[$utm->SportsType]['won'] = 1;
				}
				else if($logged_user != $utm->Winner and $utm->Winner != NULL){
				($user_stats[$utm->SportsType]['lost']) ? 
					$user_stats[$utm->SportsType]['lost']++ : $user_stats[$utm->SportsType]['lost'] = 1;
				}

				$for_score	   = ($logged_user == $utm->Player1 or $logged_user == $utm->Player1_Partner) ?
								 $utm->Player1_Score : $utm->Player2_Score;

				$against_score = ($logged_user == $utm->Player1 or $logged_user == $utm->Player1_Partner) ?
								 $utm->Player2_Score : $utm->Player1_Score;
					
					if($for_score){
						$for = json_decode($for_score, true);
						$tot = 0;
						foreach($for as $sc)
							$tot += $sc;
						($user_stats[$utm->SportsType]['points_for']) ? 
							$user_stats[$utm->SportsType]['points_for'] += $tot : $user_stats[$utm->SportsType]['points_for'] = $tot;
					}

					if($against_score){
						$against = json_decode($against_score, true);
						$tot = 0;
						foreach($against as $sc)
							$tot += $sc;
						($user_stats[$utm->SportsType]['points_against']) ? 
							$user_stats[$utm->SportsType]['points_against'] += $tot : $user_stats[$utm->SportsType]['points_against'] = $tot;
					}
				}
			}
			
			/* Output in Table format */
			$opt = "<thead>
					<tr class='top-scrore-table' style='background-color: #f68b1c; color:#fff; font-size:14px; padding:3px'>
					<th class='text-center'>Sport</th>
					<th class='text-center'>A2M (S)</th>
					<th class='text-center'>A2M (D)</th>
					<th class='text-center'>A2M (M)</th>
					<th class='text-center'>Matches<br>Played</th>
					<th class='text-center'>Win - Loss</th>
					<th class='text-center'>Matches<br>Win%</th>
					<th class='text-center'>Scores</th>
					<th class='text-center'>Score<br>Differential</th>
					<th class='text-center'>Win%</th>
					<th class='text-center'>SD/MP</th>
					<th class='text-center'>SD/MP<br>+Win%</th>
					</tr>
					</thead>";

if(count($user_stats) > 0){
	foreach($user_stats as $sport => $stats){
	$get_sport   = profile::get_sport($sport);
	$get_a2m	 = profile::get_a2msocre($sport, $opp_user);
	$get_winper  = profile::get_winper($sport, $opp_user);
	$win_per	= ($stats['won'] / $stats['played']) * 100;
	$diff		= ($stats['points_for'] - $stats['points_against']);
	$pd			= $diff / $stats['played'];
	$pd_win_per = $pd + $win_per;

$opt .= "<tr>
<td>&nbsp;<b>{$get_sport['Sportname']}</b></td>
<td align='center'>{$get_a2m['A2MScore']}</td>
<td align='center'>{$get_a2m['A2MScore_Doubles']}</td>
<td align='center'>{$get_a2m['A2MScore_Mixed']}</td>
<td align='center'>{$stats['played']}</td>
<td align='center'>{$stats['won']}-{$stats['lost']}</td>
<td align='center'>".number_format($win_per, 2)."</td>
<td align='center'>{$stats['points_for']}-{$stats['points_against']}</td>
<td align='center'>{$diff}</td>
<td align='center'>{$get_winper[Win_Per]}</td>
<td align='center'>".number_format($pd, 2)."</td>
<td align='center' style='font-weight:400;'>".number_format($pd_win_per, 2)."</td>
</tr>";

	}
}
else{
$opt .= "<tr>
<td align='right'>No</td>
<td>Standings</td>
<td>Available</td>
<td>yet!</td>
<td>&nbsp;</td>
<td>&nbsp;</td>
<td>&nbsp;</td>
<td>&nbsp;</td>
<td>&nbsp;</td>
<td>&nbsp;</td>
</tr>";
}
			/* Output in Table format */

echo $opt;
		}
		else{
			echo "Invalid Request!";
		}
	}
	
	public function crop_img(){
		echo $this->load->view('view_img_process');

	}

	public function upload_crop_profimg(){
		if($this->input->post('image')){
			$data = $this->input->post('image');

			$image_array_1 = explode(";", $data);
			$image_array_2 = explode(",", $image_array_1[1]);

			$data = base64_decode($image_array_2[1]);
			$fn = rand(1,1000) . '_'.time() . '.png';
			$image_name = './profile_pictures/' . $fn;

			file_put_contents($image_name, $data);

			echo $fn;
		}
	}

	public function basketball_matches($user_id){
		$bskball_mtches = $this->profile->basketball_matches($user_id);
		return $bskball_mtches;
	}

}