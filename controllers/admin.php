<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

	//League controller ..
	class admin extends CI_Controller {
	
		public function __construct(){
			parent:: __construct();
			$this->load->model('model_admin');
			$this->load->model('model_news');
			$this->load->model('model_general', 'general');
		}
		
		// viewing league page ...
		public function index($data=""){
			$admin = $this->session->userdata('admin');
			if($admin){
				$data['results'] = $this->model_news->get_news();

				//$path = '../js/ckfinder';
				$path = base_url().'js/ckfinder';
				$width = '780px';
				$this->editor($path, $width);

				$data['sports'] = $this->model_news->get_all_aports();
				$data['Users'] = $this->model_admin->get_user_data();

				$this->load->view('includes/header');
				$this->load->view('view_admin',$data);
				$this->load->view('includes/view_right_column',$data);
				$this->load->view('includes/footer');
			}
			else{
				echo "<h4>Unauthorized Access</h4>";
			}
		}

		public function editor($path,$width){		
			//Loading Library For Ckeditor
			$this->load->library('ckeditor');
			$this->load->library('ckFinder');
			//configure base path of ckeditor folder 
			$this->ckeditor->basePath = base_url().'js/ckeditor/';
			$this->ckeditor->config['toolbar'] = 'Full';
			$this->ckeditor->config['language'] = 'en';
			$this->ckeditor->config['width'] = $width;
			//configure ckfinder with ckeditor config 
			$this->ckfinder->SetupCKEditor($this->ckeditor,$path); 
		}
		
		public function new_profile(){
			$this->load->view('includes/header');
			$this->load->view('view_add_profile');
			$this->load->view('includes/footer');
		}

		public function get_name($user_id){
			return $this->model_admin->get_name($user_id);
		}

		public function ajax_users($sport = '', $country = '', $state = '', $age_group = '', $gender = ''){
			$sport		 = $this->input->post('spt');
			$country	 = $this->input->post('country');
			$state		 = $this->input->post('state');
			$age_group	 = $this->input->post('age_group');
			$user_status = $this->input->post('user_status');
			$gender		 = $this->input->post('user_gender');

			$data['users']		= "";
			$data['sport']		= $sport;
			$data['country']	= $country;
			$data['state']		= $state;
			$data['age_group']  = $age_group;
			$data['user_status']= $user_status;			
			$data['gender']		= $gender;			

		    $users = $this->model_admin->get_ajax_users($data);	
		    foreach($users as $value){
				$player = $value->Users_ID;
				$user_details = $this->general->get_user($player);
                $get_a2m = $this->model_admin->get_a2mscore($sport, $player);
				
                $notify_sports = array();
				if($user_details['NotifySports'] != NULL and $user_details['NotifySports'] != ''){
					$notify_sports = json_decode($user_details['NotifySports'], true);
				}
                         
				if(!in_array($sport, $notify_sports) || $sport == ""){
				   $arr['Users_ID']	= $value->Users_ID;
				   $arr['Firstname']	= $value->Firstname;
				   $arr['Lastname']	= $value->Lastname;
				   $arr['Mobilephone']= $value->Mobilephone;
				   $arr['A2MScore']	= $get_a2m['A2MScore'];

				   $data['users'][] = $arr;
				}
			}
			echo "Results: <b>".count($data['users'])."</b>";
			$this->load->view('view_admin_ajax_users',$data);		
		}

		public function send_email(){
		/*
		echo "<pre>";
		print_r($_POST);
		exit;
		*/
		/*
		$prev_users = array ("356","258","477","469","345",
		"325","769","949","418","322","458","672","314","712",
		"371","377","381","326","883","1062","853","380","789",
		"317","741");
		*/

		  if($this->input->post('admin_email')){
			 if(!empty($_FILES['attachment']['name'])){
				 $config['upload_path']   = './email_attachments/';
				 $config['allowed_types'] = 'gif|jpg|png|jpeg|pdf|docx|doc';
				 $config['max_size']   = '100000';
				 $config['max_width']  = '9000';
				 $config['max_height'] = '9000';

				 $this->load->library('upload', $config);
				 $this->upload->initialize($config);
				 $this->upload->do_upload('attachment');
				 $upload_data		 = $this->upload->data();
				 $data['attachment'] = $upload_data['full_path'];
			 }
			 else{
				$data['attachment'] = NULL;
			 }
           
			 $subject = $this->input->post('subject');
			 $sub	  = $subject;
		     $body    = htmlentities($this->input->post('description')); 

             $players = $this->input->post('sel_player');

			 /*foreach($players as $player){
				if(!in_array($player, $prev_users)){
					$upd_players[] = $player;
				}
			 }
				echo '<br>players '.count($players);
				echo '<br>prev_users '.count($prev_users);
				echo '<br>upd_players '.count($upd_players);
				exit;*/
             $player_ids_jsn = json_encode($players);
		     $data['subject']  = $sub;
			 $data['msg']      = $body;
			 $data['players']  = $player_ids_jsn;
		    // print_r($data);exit;
		     $res = $this->model_admin->insert_sendmail_players($data);
			 $data['success']  = "Message to users sent successfully.";
			 $this->index($data);
		   }
		}

		public function update_pom(){
			$data	 = array('user' => $this->input->post('txt_ac_pom_id'));
			$upd_pom = $this->model_admin->update_pom($data);
		}
	
		public function get_a2mscore($sport,$userid){
			$data['a2mscore'] = $this->model_admin->get_a2mscore($sport,$userid);
		}
	}