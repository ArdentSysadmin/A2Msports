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
	public function index()
	{

			$data['sports_details']			= $this->profile->get_intrests();
			$data['user_sports_intrests']	= $this->profile->get_user_sport_intrests();

			$data['user_matches']			= $this->profile->get_user_matches();

			$data['user_tournment_matches'] = $this->profile->get_user_tournment_matches();

			$data['num_matches']			= $this->profile->get_num_matches();

			$data['membership_details']		= $this->profile->get_membership_details();


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
		  if(!$this->session->userdata('email'))
		  {
			redirect('login');
		  }
		$data['user_details']	= $this->profile->get_user_data();
		$data['results']		= $this->model_news->get_news();

		$this->load->view('includes/header');
		$this->load->view('view_add_profile',$data);
		$this->load->view('includes/footer');
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


		public function add_player()
		{
				
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

			if($this->upload->do_upload($filename))
			{	
				
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
			else 
			{
				$data['latt'] = $this->get_lang_latt();
				$res = $this->profile->insert_player_data($data);
			}

			 $email_stat = $this->user_email($res);
					 
			 if($email_stat)
			  {
				  $data['results'] = $this->model_news->get_news();

					$this->load->view('includes/header');
					$this->load->view('view_add_player_complete');
					$this->load->view('includes/view_right_column' ,$data);
					$this->load->view('includes/footer');
			  }
			  else
			  {
					echo "New Player creation is not completed. Please contact us info@a2msports.com";
			  }
		}

		public function user_email($res)
		{
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
			

					if($res)
					{
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
				$geocodeFromAddr = file_get_contents('http://maps.googleapis.com/maps/api/geocode/json?address='.$formattedAddr.'&sensor=true_or_false'); 

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
				if($res)
				{
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
		public function upload_pic()
		{
			$status='';
			$msg='';
			$filename = 'Profilepic';

			 $config = array(
					'upload_path' => "./profile_pictures/",
					'allowed_types' => "gif|jpg|png|jpeg|pdf",
					'overwrite' => FALSE,
					'max_size' => "10000", // Can be set to particular file size , here it is 2 MB(2048 Kb)
					'max_height' => "5000",
					'max_width' => "8000"
					);

			$this->load->library('upload', $config);
			$data = $this->upload->data();

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
				
				// Deleting of Old Profile Pic
				$get_user = $this->profile->get_user_data();
				$data['del_pic'] = $get_user['Profilepic'];
				$this->load->helper("url");
				
				$path = './profile_pictures/'.$data['del_pic'];
				$path1 = './profile_pictures/thumbs/'.$data['del_pic'];
				unlink($path);
				unlink($path1);

				// Update the table with new Profile pic name
				$res = $this->profile->update_picture($data);
				
				if($res)
				{
					$data['user_details'] = $this->profile->get_user_id();
					$data['sports_details'] = $this->profile->get_intrests();
					$data['user_sports_intrests'] = $this->profile->get_user_sport_intrests();
					$data['results'] = $this->model_news->get_news();
					$data['num_matches'] = $this->profile->get_num_matches();

					$data['user_matches'] = $this->profile->get_user_matches();
					$data['user_tournment_matches'] = $this->profile->get_user_tournment_matches();
				
					//$data['pic'] = "Your profile picture Updated Successfully.";
					
					$this->load->view('includes/header');
					$this->load->view('view_profile',$data);
					$this->load->view('includes/view_right_column');
					$this->load->view('includes/footer');
				}
				else 
				{
					unlink($data['full_path']);
				}
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

		public function change_password()
	    {
			$result = $this->profile->check_oldPass(md5($this->input->post('old_password')));

			if($result){

				$update = $this->profile->save_newPass(md5($this->input->post('new_password')));
				$data['pass'] = "Password Updated Successfully.";

			}
			else
			{
			    $data['pass_error'] = "Current Password is wrong";
			}

					$data['user_details'] = $this->profile->get_user_id();
					$data['sports_details'] = $this->profile->get_intrests();
					$data['user_sports_intrests'] = $this->profile->get_user_sport_intrests();
					$data['results'] = $this->model_news->get_news();
					$data['user_matches'] = $this->profile->get_user_matches();
					$data['user_tournment_matches'] = $this->profile->get_user_tournment_matches();
					$data['num_matches'] = $this->profile->get_num_matches();
				
					
					$this->load->view('includes/header');
					$this->load->view('view_profile',$data);
					$this->load->view('includes/view_right_column');
					$this->load->view('includes/footer');

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

			$club_name = $this->profile->get_club_name($res['Org_id']);
			$org_name = $club_name['Org_name'];

			//$sport = $this->get_sport($res['Related_Sport']);
			//$sport_name = $sport['Sportname'];

			$mem_id =  $res['Membership_ID'];
			$sport =  $res['Related_Sport'];
			$org_id =  $res['Org_id'];
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
			if($res)
			{
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

		 public function update_membership()
		 {	
				$res = $this->profile->update_membership_details();
				if($res)
				{
					redirect('profile');
				}
		 }
}