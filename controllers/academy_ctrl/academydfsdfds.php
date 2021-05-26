<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

      // session_start(); 

	class academy extends CI_Controller {
	
		public function __construct()
		{
			parent:: __construct();
			// Load form helper library
			$this->load->helper('form', 'url');

			// Load form validation library
			$this->load->library('form_validation');

			// Load session library
			$this->load->library('session');
			//if(!$this->session->userdata('user')){
				//redirect('login');
			//}

			// Load database			
			$this->load->model('model_academy');
			$this->load->model('model_general');
			$this->load->model('model_news');

/* ------------------- league ---------------------- */


			$this->load->library('image_lib');

			$this->load->library('rrobin');
			$this->load->helper('directory');
			$this->load->model('model_league');
			$this->load->model('model_news');
			$this->load->model('model_general', 'general');
			$this->load->library('paypal_lib');

		}

		public function index($data="")
		{
			$url_seg  = $this->uri->segment(1); 
			$last_url = array('redirect_to'=>$url_seg);
			$this->session->set_userdata($last_url);
			
			$data['academy_list'] = $this->model_academy->get_academy_list(); 
			
			$data['results'] = $this->model_academy->get_list();			
			
			$this->load->view('includes/header');
			$this->load->view('view_academy_list',$data);
			$this->load->view('includes/academy_right_column',$data);
			$this->load->view('includes/academy_footer');				
		}
		
		public function get_org_details($org_id)
		{
			$org_details			= $this->model_academy->get_academy_details($org_id); 
			$data['org_details']	= $org_details; 

			$data['creator']		= $org_details['Users_ID'];

			$data['menu_list']		= $this->model_academy->get_menu_list();
			$data['act_menu_list']	= $this->model_academy->get_act_menu_list($org_id);
			$data['results']		= $this->model_academy->get_news($org_id);
			$data['sport_levels']	= $this->model_academy->get_tennis_levels();

			return $data;
		}

		public function get_org_creator($org_id)
		{
			$org_creator = $this->model_academy->get_org_creator($org_id); 
	
		}

		public function league($org_id)
		{

			$data = $this->get_org_details($org_id);
			$data['intrests'] = parent::index();

			$this->load->view('includes/academy_header',$data);
			$this->load->view('view_league',$data);
			$this->load->view('includes/academy_right_column',$data);
			$this->load->view('includes/academy_footer');
		}

/*		public function create_trnmt($org_id)
		{
			$data = $this->get_org_details($org_id);
			parent::create_trnmt();

		}*/

	/*	 public function view_matches($org_id)
		 {
			$data = $this->get_org_details($org_id);
			parent::view_matches($data);	
		 } */

		public function view_trnmt($org_id, $tour_id)
		{
			$data	= $this->get_org_details($org_id);
			$tr_det	= parent::view($tour_id);

			$data['tr_det']		  = $tr_det;
			$data['tour_details'] = $tr_det;
			//$data['reg_suc'] = $stat;

			$this->load->view('includes/academy_header',$data);
			$this->load->view('view_tournament', $data);
			$this->load->view('includes/academy_footer');
		}


		public function details($org_id)
		{
			
			$data['search_fname']	= "";
			$data['coach_name']		= "";
			$org_details			= $this->model_academy->get_academy_details($org_id); 
			$data['org_details']	= $org_details; 

			$data['creator']		= $org_details['Users_ID'];

			$data['menu_list']		= $this->model_academy->get_menu_list();
			$data['act_menu_list']	= $this->model_academy->get_act_menu_list($org_id);
			$data['tourn_list']		= $this->model_academy->get_user_create_tournments($data['creator']);
			$data['past_tournments'] = $this->model_academy->get_user_past_tournments($data['creator']); 
		
			//$data['results'] = $this->model_news->get_news();
			$data['results']		= $this->model_academy->get_news($org_id);
			$data['sport_levels']	= $this->model_academy->get_tennis_levels();
			
			$this->load->view('includes/academy_header',$data);
			$this->load->view('view_academy_details',$data);
			$this->load->view('includes/academy_right_column',$data);
			$this->load->view('includes/academy_footer');

		}

		public function update_act_menu($org_id)
		{
			if($this->input->post('sbt_menu_links')){
				
				$res = $this->model_academy->update_act_menu($org_id);
				redirect("academy/details/$org_id");
			}
			else{ echo "Invalid Access!"; }
		}

		public function news_add($org_id)
		{
		   //$admin_users = array(214,215);
		   //$user_id = $this->session->userdata('users_id'); 
		
		   //if(in_array($user_id, $admin_users)){

			$data['org_id'] = $org_id;
			$data['org_details'] = $this->model_academy->get_academy_details($org_id);

			$data['menu_list'] = $this->model_academy->get_menu_list();
			$data['act_menu_list'] = $this->model_academy->get_act_menu_list($org_id);

			$data['results'] = $this->model_academy->get_news($org_id);

			$path = '../js/ckfinder';
			$width = '780px';
			$this->editor($path, $width);

			$data['sports'] = $this->model_news->get_all_aports();

			$this->load->view('includes/academy_header',$data);
			$this->load->view('view_add_academy_news',$data);
			$this->load->view('includes/academy_right_column',$data);
			$this->load->view('includes/academy_footer');
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

		
		public function add_news($org_id)
		{
			if($this->input->post('add_news'))
			{	
				//$org_id = $this->input->post('org_id');

				$res = $this->model_academy->insert_news();
				
				if($res)
				{
					$data['org_id']			= $org_id;
					$data['results']		= $this->model_academy->get_news($org_id);
					$data['org_details']	= $this->model_academy->get_academy_details($org_id); 
					$data['menu_list']		= $this->model_academy->get_menu_list();
					$data['act_menu_list']	= $this->model_academy->get_act_menu_list($org_id);

					$path  = '../js/ckfinder';
					$width = '780px';
					$this->editor($path, $width);

					$data['add_news']	= "News Successfully added.";
					$data['sports']		= $this->model_news->get_all_aports();

					$this->load->view('includes/academy_header',$data);
					$this->load->view('view_add_academy_news',$data);
					$this->load->view('includes/academy_right_column',$data);
					$this->load->view('includes/academy_footer');		
				}
			}
			else
			{
				echo "<h4>Invalid Access</h4>";
			}
		}

		public function get_news_detail($news_id)
		{
			$news_id_det = $this->model_academy->get_news_detail($news_id);
			$data['news_id_det'] = $news_id_det;
			$org_id = $news_id_det['Org_Id'];

			$data['org_details'] = $this->model_academy->get_academy_details($org_id); 
			$data['menu_list'] = $this->model_academy->get_menu_list();
			$data['act_menu_list'] = $this->model_academy->get_act_menu_list($org_id);

			//$data['results'] = $this->model_news->get_news();
			$data['results'] = $this->model_academy->get_news($org_id);

			$this->load->view('includes/academy_header',$data);
			$this->load->view('view_latest_news' ,$data);
			$this->load->view('includes/academy_right_column',$data);
			$this->load->view('includes/academy_footer');	
		}

		public function edit($news_id)
		{
			$path  = '../js/ckfinder';
			$width = '780px';
			$this->editor($path, $width);
		
			$news_id_det			= $this->model_academy->get_news_detail($news_id);
			$data['news_id_det']	= $news_id_det;
			$org_id					= $news_id_det['Org_Id'];

			$data['org_id']			= $org_id;

			$data['org_details']	= $this->model_academy->get_academy_details($org_id);
			$data['menu_list']		= $this->model_academy->get_menu_list();
			$data['act_menu_list']	= $this->model_academy->get_act_menu_list($org_id);

			$data['results']		= $this->model_academy->get_news($org_id);
			$data['sports']			= $this->model_news->get_all_aports();

			$this->load->view('includes/academy_header',$data);
			$this->load->view('view_academy_news_edit' ,$data);
			$this->load->view('includes/academy_right_column',$data);
			$this->load->view('includes/academy_footer');	
		}

		public function update_news($news_id)
		{
			
			$org_id = $this->input->post('org_id');

			//print_r($_POST);
			//exit;
			$res = $this->model_academy->update_news($news_id);
			if($res)
			{
				
				$data['results'] = $this->model_academy->get_news($org_id);
				$data['org_details'] = $this->model_academy->get_academy_details($org_id); 
				$data['menu_list'] = $this->model_academy->get_menu_list();
			    $data['act_menu_list'] = $this->model_academy->get_act_menu_list($org_id);

				$data['news_id_det'] = $this->model_academy->get_news_detail($news_id);
			
				$this->load->view('includes/academy_header',$data);
				$this->load->view('view_latest_news' ,$data);
				$this->load->view('includes/academy_right_column',$data);
			    $this->load->view('includes/academy_footer');
					
			}
		}


		public function news($org_id)
		{
			
			$data['news_list'] = $this->model_academy->get_specific_news($org_id);

			$data['org_details'] = $this->model_academy->get_academy_details($org_id);
			$data['menu_list'] = $this->model_academy->get_menu_list();
			$data['act_menu_list'] = $this->model_academy->get_act_menu_list($org_id);
			$data['results'] = $this->model_academy->get_news($org_id);

			$this->load->view('includes/academy_header',$data);
			$this->load->view('view_specific_academy_news' ,$data);
			$this->load->view('includes/academy_right_column',$data);
			$this->load->view('includes/academy_footer');	
		
		}


		public function list_news()
		{
			
			$data['news_list'] = $this->model_academy->get_academy_list_news(); 

			//$data['org_details'] = $this->model_academy->get_academy_details($org_id); 
			$data['results'] = $this->model_academy->get_list();
			$data['menu_list'] = $this->model_academy->get_menu_list();
			//$data['act_menu_list'] = $this->model_academy->get_act_menu_list($org_id);

			$this->load->view('includes/academy_header',$data);
			$this->load->view('view_academy_list_news' ,$data);
			$this->load->view('includes/academy_right_column',$data);
			$this->load->view('includes/academy_footer');	
		
		}


		public function Sport_levels($sport_id = '')
		{
			$sport_id = $this->input->post('sport_id');
			$sport_levels = $this->model_academy->get_sport_levels($sport_id);
			
			echo "<select name='level' id='level' class='form-control'>";
			echo "<option value=''>Level</option>";
			
			foreach($sport_levels as $row){ 
				 
				echo "<option value='$row->SportsLevel_ID' $checked_stat>$row->SportsLevel</option>";
			}
			echo "</select>";
		}

		public function get_ac_sport($sport_id)
		{
			return $this->model_academy->get_sport_title($sport_id);
		}

		public function get_details($user_id)
		{
			return $this->model_academy->get_sport_id($user_id);
		}

		public function get_menu_name($id)
		{
			return $this->model_academy->get_menu_name($id);
		}


		public function players()
		{
			
			if($this->input->post('search_mem'))
		    {
				//print_r($_POST);
				//exit;
				
				$data['search_fname'] = $this->input->post('name');
				$data['sport'] = $this->input->post('user_sport');
				$data['level'] = $this->input->post('level');
				$data['range'] = $this->input->post('range');
				
				$data['lat'] = $this->session->userdata('lat');
				$data['long'] = $this->session->userdata('long');
				
				$org_id = $this->input->post('org_id');
				
				$data['query'] = $this->model_academy->search_details($data);
				//$data['results'] = $this->model_news->get_news();
				
				$org_details = $this->model_academy->get_academy_details($org_id); 
				$data['org_details'] = $org_details; 

				$data['results'] = $this->model_academy->get_news($org_id);

				$data['menu_list'] = $this->model_academy->get_menu_list();
				$data['act_menu_list'] = $this->model_academy->get_act_menu_list($org_id);

				$creator = $org_details['Users_ID'];
			
				$data['tourn_list'] = $this->model_academy->get_user_create_tournments($creator);
			
				$data['past_tournments'] = $this->model_academy->get_user_past_tournments($creator); 
				$sport = $data['sport'];
				$data['sport_levels'] = $this->model_academy->get_sport_levels($sport);
				
				$this->load->view('includes/academy_header',$data);
				$this->load->view('view_academy_details',$data);
				$this->load->view('includes/academy_right_column',$data);
				$this->load->view('includes/academy_footer');
			}
		}


		public function coaches()
		{
			
			//print_r($_POST);
			//exit;
			
			if($this->input->post('coach_mem'))
			{

			$data['coach_name'] = $this->input->post('coach_name');
			$data['coach_sport'] = $this->input->post('coach_sport');
			$data['coach_range'] = $this->input->post('coach_range');
			
			$data['lat'] = $this->session->userdata('lat');
			$data['long'] = $this->session->userdata('long');

			$org_id = $this->input->post('org_id');
			
			$data['org_id'] = $org_id;
			$data['coach_results'] = $this->model_academy->search_coaches($data);
			
			
			$org_details = $this->model_academy->get_academy_details($org_id); 
			$data['org_details'] = $org_details; 

			$data['results'] = $this->model_academy->get_news($org_id);

			$data['menu_list'] = $this->model_academy->get_menu_list();
			$data['act_menu_list'] = $this->model_academy->get_act_menu_list($org_id);

			$creator = $org_details['Users_ID'];
		
			$data['tourn_list'] = $this->model_academy->get_user_create_tournments($creator);
		
			$data['past_tournments'] = $this->model_academy->get_user_past_tournments($creator); 
			$sport = $data['sport'];
			$data['sport_levels'] = $this->model_academy->get_sport_levels($sport);

			
			$this->load->view('includes/academy_header',$data);
			$this->load->view('view_academy_details',$data);
			$this->load->view('includes/academy_right_column',$data);
			$this->load->view('includes/academy_footer');
			
			}
		}

		
		public function coaches_list($org_id)
		{
			
			$data['coach_name']  = "";

			$data['org_id'] = $org_id;

			$data['coaches_list'] = $this->model_academy->get_coaches_list($org_id);
			
			$org_details = $this->model_academy->get_academy_details($org_id); 
			$data['org_details'] = $org_details; 

			$data['results'] = $this->model_academy->get_news($org_id);

			$data['menu_list'] = $this->model_academy->get_menu_list();
			$data['act_menu_list'] = $this->model_academy->get_act_menu_list($org_id);
			
			$this->load->view('includes/academy_header',$data);
			$this->load->view('view_academy_coaches',$data);
			$this->load->view('includes/academy_right_column',$data);
			$this->load->view('includes/academy_footer');
			
		}

		public function search_coaches()
		{
			
			//print_r($_POST);
			//exit;
			
			if($this->input->post('coach_mem'))
			{

			$data['coach_name'] = $this->input->post('coach_name');
			$data['coach_sport'] = $this->input->post('coach_sport');
			$data['coach_range'] = $this->input->post('coach_range');
			
			$data['lat'] = $this->session->userdata('lat');
			$data['long'] = $this->session->userdata('long');

			$org_id = $this->input->post('org_id');
			
			$data['org_id'] = $org_id;
			$data['coaches_list'] = $this->model_academy->search_coaches($data);
			
			
			$org_details = $this->model_academy->get_academy_details($org_id); 
			$data['org_details'] = $org_details; 

			$data['results'] = $this->model_academy->get_news($org_id);

			$data['menu_list'] = $this->model_academy->get_menu_list();
			$data['act_menu_list'] = $this->model_academy->get_act_menu_list($org_id);
			
			$this->load->view('includes/academy_header',$data);
			$this->load->view('view_academy_coaches',$data);
			$this->load->view('includes/academy_right_column',$data);
			$this->load->view('includes/academy_footer');
			
			}
		}

		public function member_list($org_id)
		{
			
			$data['search_fname']  = "";

			$data['org_id'] = $org_id;

			$data['query'] = $this->model_academy->get_members_list($org_id);

			//$data['coaches_list'] = $this->model_academy->get_coaches_list($org_id);
			
			$org_details = $this->model_academy->get_academy_details($org_id); 
			$data['org_details'] = $org_details; 

			$data['results'] = $this->model_academy->get_news($org_id);

			$data['menu_list'] = $this->model_academy->get_menu_list();
			$data['act_menu_list'] = $this->model_academy->get_act_menu_list($org_id);

			$data['sport_levels'] =  $this->model_academy->get_tennis_levels();
			
			$this->load->view('includes/academy_header',$data);
			$this->load->view('view_academy_members',$data);
			$this->load->view('includes/academy_right_column',$data);
			$this->load->view('includes/academy_footer');
			
		}

		
		public function search_members()
		{
			
			if($this->input->post('search_mem'))
		    {
				$data['coach_name']		= "";
				$data['search_fname']	= $this->input->post('name');
				$data['sport']			= $this->input->post('user_sport');
				$data['level']			= $this->input->post('level');
				$data['range']			= $this->input->post('range');
				
				$data['lat']			= $this->session->userdata('lat');
				$data['long']			= $this->session->userdata('long');
				
				$org_id					= $this->input->post('org_id');
				
				$data['query']			= $this->model_academy->search_details($data);
				//$data['results'] = $this->model_news->get_news();
				
				$org_details			= $this->model_academy->get_academy_details($org_id); 
				$data['org_details']	= $org_details; 
				$data['results']		= $this->model_academy->get_news($org_id);
				$data['menu_list']		= $this->model_academy->get_menu_list();
				$data['act_menu_list']	= $this->model_academy->get_act_menu_list($org_id);
 
				$sport					= $data['sport'];
				$data['sport_levels']	= $this->model_academy->get_sport_levels($sport);
				
				$this->load->view('includes/academy_header',$data);
				$this->load->view('view_academy_members',$data);
				$this->load->view('includes/academy_right_column',$data);
				$this->load->view('includes/academy_footer');
			}
		}


		public function LoadUsers()
		{
			$search_fname = $this->input->post('name');
			$sport= $this->input->post('sport');
			$level =  $this->input->post('level');
			$range = $this->input->post('range');
			$org_id = $this->input->post('org_id');
			
			$data['query'] = "";
			
			$data['lat'] = $this->session->userdata('lat');
			$data['long'] = $this->session->userdata('long');

			$data['sport'] = $sport;
			$data['level'] = $level;
			$data['range'] = $range;
			$data['org_id'] = $org_id;
			$data['search_fname'] = $search_fname;
			
			$data['query'] = $this->model_academy->search_details($data);
			$this->load->view('view_ajax_academy_users' ,$data);	
		}


		public function update_pom(){

			$data = array('user'  => $this->input->post('txt_ac_pom_id'), 
						'academy' => $this->input->post('txt_org'));

			
			$upd_pom = $this->model_academy->update_pom($data);
		}


/* ------------------------------------------------------------- League Functions -------------------------------------------------------------- */

	
		public function create_trnmt()
	    {
			  
			  $filename = 'TournamentImage';  

				$config = array(
				    'upload_path' => "./tour_pictures/",
					'allowed_types' => "gif|jpg|png|jpeg|pdf",
					'overwrite' => FALSE,
					'max_size' => "10000", // Can be set to particular file size , here it is 2 MB(2048 Kb)
					'max_height' => "5000",
					'max_width' => "8000"
					);
				
				$this->load->library('upload',$config);
				$data = $this->upload->data();
				$this->upload->initialize($config);
				
				if($this->upload->do_upload($filename)) 
				{	
					$data = $this->upload->data();
					$data['latt'] = $this->get_lang_latt();
					$res = $this->model_league->insert_tournament($data);
				}
				else 
				{
					$data['latt'] = $this->get_lang_latt();
					$res = $this->model_league->insert_tournament($data);
				}

				$email_status = $this->email_create_tournament($res);
				$tour_details = $res;
			    $tourn_id = $tour_details['tourn_id'];

				redirect("league/view/$tourn_id");

				//if($email_status)
			    //{ 
				    	
				 //}
				//else
			    //{
				//	echo "Oops, Something went wrong! Please write to us admin@a2msports.com";
				//}

		 }

		 public function email_create_tournament($res)
		 {
			
			$tour_details = $res;

			
			$tourn_id  = $tour_details['tourn_id'];
			$tourn_det = $this->model_league->getonerow($tourn_id);

			$start_date =  date('m/d/Y',strtotime(substr($tourn_det->StartDate,0,10))); 
			$close_date =  date('m/d/Y',strtotime(substr($tourn_det->Registrationsclosedon,0,10)));
			
			$venue		= $tourn_det->venue;
			$address	= $tourn_det->TournamentAddress;
			$city		= $tourn_det->TournamentCity;
			$state		= $tourn_det->TournamentState;
			$country	= $tourn_det->TournamentCountry;

			$title		= $tourn_det->tournament_title;
			$gen		= $tourn_det->Gender;

			if($gen == "all"){ $gender = "Open to all"; } else if($gen == "1"){ $gender = "Male"; } else if($gen == "0"){ $gender = "Female"; }else { $gender = "Not provided"; }

			$location = "";

			if($venue != "") { $location .= $venue;}

			if($address != "") { $location .=  ", " . $address ;} 
			if($city	!= "") { $location .=  ", " . $city;} 
			if($state	!= "") { $location .=  ", " . $state;} 
			if($country != "") { $location .=  ", " . $country . ".";} 

			$sport_id	= $tourn_det->SportsType;
			$name		= $this->model_league->get_sport_title($sport_id);
			$sport_title = $name['Sportname'];

			$organizer	= $tourn_det->OrganizerName;
			$contact	= $tourn_det->ContactNumber;

			$fee		= $tourn_det->TournamentAmount;
			$extrafee	= $tourn_det->extrafee;

			$get_sport_users = $this->model_league->get_sport_users($sport_id,$country,$state);
			
			foreach($get_sport_users as $row){

				$this->load->library('email');
				$this->email->set_newline("\r\n");

				$this->email->from('admin@a2msports.com', 'A2mSports');
				$this->email->to($row->EmailID);

				$subject = "New ".$sport_title."Tournament - A2MSports";
				
				$this->email->subject($subject);

				$data = array(
				 'fname'	=> $row->Firstname,
				 'lname'	=> $row->Lastname,
				 'sport'	=> $sport_title,
				 'gender'	=> $gender,
				 'fee'		=> $fee,
				 'extrafee' => $extrafee,
				 'org'		=> $organizer,
				 'contact'	=> $contact,
				 'title'	=> $title,
				 'start_date' => $start_date,
				 'close_date' => $close_date,
				 'location' => $location,
				 'tourn_id' => $tourn_id,
				 'page'		=> 'New Tournament Creation'
				);

				$body = $this->load->view('view_email_template.php',$data,TRUE);
				$this->email->message($body);   
				$status = $this->email->send();
			}
	
			return $status;
		}


		public function view($tid, $stat = '')
		{
			$tr_det = $this->model_league->getonerow($tid);

			if($tr_det)
			{
				$data['tr_det'] = $tr_det;
				$this->load->view('includes/header', $data);

				$data['tour_details'] = $tr_det;
				$data['results'] = $this->model_news->get_news();
				$data['reg_suc'] = $stat;			
				$this->load->view('view_tournament', $data);
				//$this->load->view('includes/view_right_column',$data);
				$this->load->view('includes/footer');
			}
			else
			{
				echo "Invalid Access!";
			}
		}


		public function edit_tour($tid)
		{
			$data['tour_details'] = $this->model_league->getonerow($tid);
			$details = $data['tour_details'];
			$user_id = $this->session->userdata('users_id');

			if($details->Usersid == $user_id){

				$data['results'] = $this->model_news->get_news();
				$data['intrests'] = $this->model_league->get_intrests();
				
				$this->load->view('includes/header');
				$this->load->view('view_edit_tournament',$data);
				$this->load->view('includes/view_right_column',$data);
				$this->load->view('includes/footer');
			}
			else
			{ echo "<h4>Unauthorized Access</h4>"; }
		}

		public function update_trnmt()
	    {
			$data['tourn_id'] = $this->input->post('tourn_id'); 

			 if(!empty($_FILES['TournamentImage']['name'])){
			    
				$filename = 'TournamentImage'; 
	
				$config = array(
				    'upload_path' => "./tour_pictures/",
					'allowed_types' => "gif|jpg|png|jpeg|pdf",
					'overwrite' => FALSE,
					'max_size' => "10000", // Can be set to particular file size , here it is 2 MB(2048 Kb)
					'max_height' => "5000",
					'max_width' => "8000"
					);
				
				$this->load->library('upload',$config);
				$this->upload->initialize($config);
				
				if($this->upload->do_upload($filename)) 
				{	
					$data['up_image'] = $this->upload->data();

					// Deleting of Old Profile Pic
					$tourn_image = $this->input->post('Image');
					if($tourn_image){
					$data['del_pic'] = $tourn_image;
					$this->load->helper("url");
					
					$path = './tour_pictures/'.$data['del_pic'];
				
					unlink($path);
					}
					else{
					  //
					}

					 $data['latt'] = $this->get_lang_latt();
				     $res = $this->model_league->update_tournament($data);
				}
			 }
			 else 
			 {
				$data['latt'] = $this->get_lang_latt();
				$res = $this->model_league->update_tournament($data);
			 }
				
				$email_status = $this->email_update_tournament($res);
				$tour_details = $res;
			    $tourn_id = $tour_details['tourn_id'];

				redirect("league/view/$tourn_id");
		 }

		 public function email_update_tournament($res)
		 {
			$tour_details = $res;

			$tourn_id = $tour_details['tourn_id'];
			$title = $tour_details['title'];

			$reg_players = $this->model_league->get_reg_players($tourn_id);
	
			foreach($reg_players as $row){

				$this->load->library('email');
				$this->email->set_newline("\r\n");
				
				$player_det = $this->get_username($row->Users_ID);
				$player_name = $player_det['Firstname'] . " " . $player_det['Lastname'];
				$player_email = $player_det['EmailID'];

				$this->email->from('admin@a2msports.com', 'A2mSports');
				$this->email->to($player_email);

				$subject = $title."Tournament - A2MSports";
				
				$this->email->subject($subject);

				$data = array(
				 'name' => $player_name,
				 'title'=> $title,
				 'tourn_id' => $tourn_id,
				 'page'=> 'Update Tournament'
				);

				$body = $this->load->view('view_email_template.php',$data,TRUE);
				$this->email->message($body);   
				$status = $this->email->send();
			}
			return $status;
		}

		public function get_lang_latt()
		{
			 // $address1 = $this->input->post('UserAddressline1');
			if($this->input->post('addr2')==""){
			 $address2 = $this->input->post('addr1');
			} else {
			 $address2 = $this->input->post('addr2');
			}
			 $country = $this->input->post('country');

				if($country == 'United States of America') {
					$state = $this->input->post('state');
				} else {
					$state = $this->input->post('state1');
				}

			 $city = $this->input->post('city');

			 $address =  $address2 . ' ' .  $country . ' ' .  $state . ' ' .  $city;

			if($address!=""){

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
			} 
			else 
			{
				return false;
			}
	  }

		public function get_reg_tourn_player_names($tourn_id)
		{
	    	return $this->model_league->get_reg_tourn_player_names($tourn_id);
		}
		
		public function get_reg_tourn_partner_names($tourn_id)
		{
			/*$chck_bracket = $this->model_league->is_bracket_exists($tourn_id);

			if($chck_bracket)
			{
				return false;			
			}
			else
			{*/
				return $this->model_league->get_reg_tourn_partner_names($tourn_id);
			//}
		}

		 public function get_sport($sport_id)
		 {
			return $this->model_league->get_sport_name($sport_id);
		 }

		 public function get_level_name($sport_id,$level)
		 {
			return $this->model_league->get_level_name($sport_id,$level);
		 }

		 public function getonerow($tourn_id)
		 {
			return $this->model_league->getonerow($tourn_id);
		 }

		 public function user_reg_or_not($user_id,$tourn_id)
		 {
			$res = $this->model_league->user_reg_or_not($user_id,$tourn_id);	
			return $res;
		 }

		 public function get_user($user_id)
		 {
			$user_id = $this->session->userdata('users_id');
			return $this->model_league->get_user_name($user_id);
		 }

		 public function add_tourn_match_score($tourn_match_id)
		 {
			$data['tourn_id'] = $tourn_match_id;
			$res = $this->model_league->update_tourn_match_score($data['tourn_id']);
			
			if($res)
			{
				$data['tourn_id']	= $tourn_match_id;
				$data['tourn_det']	= $this->model_league->getonerow($tourn_id);

				$get_bracket_details = $this->model_league->get_bracket_details();
				
				$data['bracket_id'] = $get_bracket_details['BracketID'];
				$data['get_bracket_details'] = $get_bracket_details;
				
				$data['bracket_matches'] = $this->model_league->get_tourn_matches($data);
				$data['get_match_comments'] = $this->model_league->get_match_comments($tourn_id);
				//echo "<pre>";
				//print_r($data['bracket_matches']->result());
				//exit;

				$data['results'] = $this->model_news->get_news();
				$data['tour_details'] = $data['tourn_det'];

				$this->load->view('includes/header');
				$this->load->view('view_tournament',$data);
				$this->load->view('includes/footer');
			}
		 }

		 public function register_match($tourn_id)
		 {
			
			$tourn_id =  $this->uri->segment(3);
			$details = $this->model_league->getonerow($tourn_id);

			$now =  strtotime("now"); $oneday = 86400;
			$reg_close = strtotime($details->Registrationsclosedon) + $oneday;

			if($now < $reg_close){

				$user_id = $this->session->userdata('users_id');

				$reg_details = $this->model_league->get_reg_tournment($tourn_id);

				if((!empty($reg_details['Tournament_ID']) == $tourn_id) && ((!empty($reg_details['Users_ID']) == $user_id)))
				{
					$data['reg_status'] = "You were already registered for this tournament. Thankyou.";
					
					$details = $this->model_league->getonerow($tourn_id);
					
					$data['r'] = $details;
					$data['results'] = $this->model_news->get_news();
					$this->load->view('includes/header');
					$this->load->view('view_register_match', $data); 
					$this->load->view('includes/view_right_column',$data);
					$this->load->view('includes/footer');

				}
				else
				{
					//$tourn_id =  $this->uri->segment(3);
					//$user_id = $this->session->userdata('users_id');
					$details	= $this->model_league->getonerow($tourn_id);
					$check_dob	= $this->model_league->check_user_dob($user_id);

					($check_dob->DOB != NULL) ? $data['udob'] = 1 : $data['udob'] = 0;
					
					$data['r'] = $details;
					$data['results'] = $this->model_news->get_news();
					$this->load->view('includes/header');
					$this->load->view('view_register_match', $data); 
					$this->load->view('includes/view_right_column',$data);
					$this->load->view('includes/footer');	
				}
			}
			else
			{ echo "<h4>Oops Registrations closed!</h4>"; }
		 
		 }

		public function uprofile(){

			$this->model_league->update_dob();
			$tour_id = $this->input->post('txt_tid');

			redirect("league/register_match/$tour_id");
		}
		 
		 public function fixtures($tourn_id)
		 {
			
			$tourn_id =  $this->uri->segment(3);
			$user_id = $this->session->userdata('users_id');
			
			$data['tourn_id'] = $tourn_id;
			
			$tour_det = $this->model_league->get_fixtures_det($tourn_id);

			$type = json_decode($tour_det['Singleordouble']);
			
			$match_type = $type[0];
			$sport = $tour_det['SportsType'];

			if($match_type == 'Singles'){
				$data['tourn_single_users'] = $this->model_league->tourn_single_users($tourn_id,$match_type,$sport);
			}
			else if($match_type == 'Doubles'){
				$data['tourn_double_users'] = $this->model_league->tourn_single_users($tourn_id,$match_type,$sport);
		    }

			$data['tourn_det'] = $tour_det;
			$data['results'] = $this->model_news->get_news();
			$data['types'] = $this->input->post('types');

			$this->load->view('includes/header');
			$this->load->view('view_fixtures',$data);
			$this->load->view('includes/view_right_column',$data);
			$this->load->view('includes/footer');
		
		 }

		 public function age_group_users($tourn_id = '', $age_group = '', $match_type = '',$gender= '',$sport = '',$level = '')
		 {
		     $age_group = $this->input->post('age_group');
			 $match_type = $this->input->post('match_type');
			 $tourn_id = $this->input->post('tourn_id');
			 $gender = $this->input->post('gender');
			 $sport = $this->input->post('sport');
			 $level = $this->input->post('level');
		 
			 if($match_type != ""){
					$data['tourn_age_group_users'] = "";
					$data['tourn_id'] = $tourn_id;
					$data['age_group'] = $age_group;
					$data['match_type'] = $match_type;
					$data['gender'] = $gender;
					$data['sport'] = $sport;
					$data['level'] = $level;

					if($match_type == 'Singles'){
						$data['tourn_age_group_users'] = $this->model_league->get_reg_tourn_age_usernames($data);
					}
					else if($match_type == 'Doubles'){
						$data['tourn_double_group_users'] = $this->model_league->get_reg_tourn_age_usernames($data);
				    }	
					$data['sport'] = $sport;
					$this->load->view('view_agegroup_users' ,$data);
			}
		 }

		 public function get_reg_tourn_participants($tourn_id)
		 {
			return $this->model_league->get_reg_tourn_participants($tourn_id);
		 }

		 public function registered_players()
		 {
		     $tourn_id = $this->input->post('tourn_id');
			 $match_type = $this->input->post('mtype');
			 $age_type = $this->input->post('age');
			 $tourn_level = $this->input->post('level');
			
			 //if($age_type != ""){
					$data['tourn_reg_names'] = "";
					$data['tourn_id'] = $tourn_id;
					$data['age_group'] = $age_type;
					$data['match_type'] = $match_type;
					$data['level'] = $tourn_level;

					$data['tourn_reg_names'] = $this->model_league->registered_players($data);

					$this->load->view('view_reg_tourn_names',$data);
			 //}
		 }

		 public function participants()
		 {
		     $tourn_id = $this->input->post('tourn_id');
			 $match_type = $this->input->post('mtype');
			 $age_type = $this->input->post('age');
			 $level = $this->input->post('level');
			 $sport_id = $this->input->post('sport_id');
			
			 if($age_type != ""){
					$data['tourn_participants'] = "";
					$data['tourn_id'] = $tourn_id;
					$data['match_type'] = $match_type;
					$data['age_type'] = $age_type;
					$data['level'] = $level;

					$data['tourn_participants'] = $this->model_league->participants($data);
					
					$data['sport_id'] = $sport_id;
					$this->load->view('view_tourn_participants',$data);
			}
		 }
	
		 public function bracket($tourn_id)
		 {

			if($this->input->post('generate'))
			{
				
				$ttype = $this->input->post('ttype');
				$data['results'] = $this->model_news->get_news();


				if($ttype == 'Single Elimination' or $ttype == 'Consolation')
				{
					$data['types'] = $this->input->post('types');
					$data['type_format'] = $this->input->post('type_gen');
					
					 $tourn_id =  $this->uri->segment(3);
					//$data['tourn_id'] = $tourn_id;

					//$bracket_id = $this->model_league->get_bracket_exist($data);
//					$bracket_id = 0;

						/*if($bracket_id){

							$data['exist'] = "Draws are already exists for the slected options. ";

							$data['tourn_id'] = $tourn_id;
							$data['tourn_det'] = $this->model_league->get_fixtures_det($tourn_id);
							$data['tourn_users'] = $this->model_league->get_reg_tourn_usernames($tourn_id);

							$data['results'] = $this->model_news->get_news();

							$this->load->view('includes/header');
							$this->load->view('view_fixtures',$data);
							$this->load->view('includes/view_right_column',$data);
							$this->load->view('includes/footer');

						}
						else { */

						$user_id = $this->session->userdata('users_id');
						
						$data['tourn_id'] = $tourn_id;
					
						$data['teams'] = $this->input->post('users');
						$data['num_of_teams'] = count($data['teams']);

						$this->load->view('includes/header');
						($ttype == 'Single Elimination') ? $this->load->view('view_bracket_generate',$data) : $this->load->view('view_cd_bracket_generate',$data);
						$this->load->view('includes/footer');
				   //}

				}
				else if($ttype == 'Round Robin')
				{
			
					$data['types'] = $this->input->post('types');
					$data['type_format'] = $this->input->post('type_gen');
					$data['tourn_id'] = $tourn_id;

					//$bracket_id = $this->model_league->get_bracket_exist($data);

					/*if($bracket_id){

					$data['exist'] = "Bracket Already generated with the below Criteria.Please select other Agegroup or Type of Bracket Generation. ";

					$data['tourn_id'] = $tourn_id;
					$data['tourn_det'] = $this->model_league->get_fixtures_det($tourn_id);
					$data['tourn_users'] = $this->model_league->get_reg_tourn_usernames($tourn_id);

					$data['results'] = $this->model_news->get_news();

					$this->load->view('includes/header');
					$this->load->view('view_fixtures',$data);
					$this->load->view('includes/view_right_column',$data);
					$this->load->view('includes/footer');

					} else { */
				
					$data['teams'] = $this->input->post('users');
					$data['num_of_teams'] = count($data['teams']);

					$robin = new RRobin();

					$competitors = $this->input->post('users');

					$data['robin_rounds'] = $robin->create($competitors);
					$data['players'] = $competitors;
					$data['robins'] = $robin->tour;
					$data['total_games'] = $robin->tot_games;
				
					$this->load->view('includes/header');
					$this->load->view('view_rr_bracket_generate',$data);
					$this->load->view('includes/footer');
					
					//}
				}
			}
		 }

		 public function check_draw_title()
		 {
			$tourn_id = $this->input->post('tourn_id');
			$draw_title = $this->input->post('draw_title');
			
			 if($draw_title != ""){
				$res = $this->model_league->check_draw_title($tourn_id,$draw_title);
				echo $res;
			 }
		 }

		 public function bracket_save()
		 {
			$tourn_id = $this->input->post('tourn_id');

			if($this->input->post('rr_bracket_confirm')){
				$res = $this->model_league->insert_rr_brackets();
			}
			else if($this->input->post('bracket_confirm')){
				$res = $this->model_league->insert_tourn_brackets();
			}
			if($res){
				 $this->view($tourn_id);
			}
		 }

		 public function get_bracket_list($tourn_id)
		 {
			return $this->model_league->get_bracket_list($tourn_id);
		 }

		 public function pdf($bracket_id)
		 {
			$bracket_id =  $this->uri->segment(3);
			$data['bracket_id'] = $bracket_id;
			$get_bracket = $this->model_league->get_bracket_rounds($data);
			$data['get_bracket'] = $get_bracket;
			$data['match_type'] = $get_bracket['Match_Type'];

			if($get_bracket['Bracket_Type'] == 'Single Elimination'){
				$data['get_tourn_matches'] = $this->model_league->get_tourn_matches($data);
			}
			else if($get_bracket['Bracket_Type'] == 'Consolation')
			{
				$bid = $bracket_id;

				$data['get_tourn_matches'] = $this->model_league->get_tourn_matches_main($bid);
				$data['get_cd_tourn_matches'] = $this->model_league->get_cd_tourn_matches($bid);
				$data['get_cd_num_rounds'] = $this->model_league->get_cd_tot_rounds($bid);
			}
			else if($get_bracket['Bracket_Type'] == 'Round Robin')
			{
				$data['get_rr_tourn_matches'] = $this->model_league->get_tourn_matches($data);
			}

			 $this->load->view('view_se_print_draws', $data);
		 }
		
		public function cal_c($pow_vals,$num_teams,$teams,$round)			// Single Elimination
		{
			global $pow_vals;

			$pow_vals = array(2,4,8,16,32,64,128,256);
			
			foreach($pow_vals as $i=>$pv){
				if($num_teams > $pv)
				{
					$near_pow = $pow_vals[++$i];
				}
				else if($num_teams == $pv)
				{
					$near_pow = $pow_vals[$i];
				}
			}

			$num_p = ($num_teams - ($near_pow - $num_teams));
			$num_g = abs($num_teams - ($near_pow/2));

			$bye_p = $num_teams - $num_p;

			$nxt_r_p = $bye_p + $num_g;

				$temp_teams = $teams;

				$bye_pl_list = array();
				if($bye_p > 0){

					for($i=0;$i<$bye_p;$i++)
					{
						$pl = array_shift($temp_teams);
						$bye_pl_list[$i] = array($pl,'---');
					}
				}

				$game_pl_list = array();
				if($round==1){
					for($i=0,$k=0;$i<$num_g;$i++)
					{
						$fst = reset($temp_teams);
						$lst = end($temp_teams);

						$game_pl_list[$k] = array($fst,$lst);
						array_shift($temp_teams);
						array_pop($temp_teams);
					$k++;
					}
				}
				else{
					for($j=1,$k=0;$j<=count($teams);$j++){
						if($j%2==0){
						$game_pl_list[$k] = array($teams[$j-2],$teams[$j-1]);
						$k++;
						}
					}

				}

			$res = array();

				$res[0] = $num_p;
				$res[1] = $num_g;
				$res[2] = $bye_p;
				$res[3] = $nxt_r_p;
				$res[4] = $num_g + $bye_p;

				if(!empty($bye_pl_list)){
					$res[5] = array_merge($bye_pl_list, $game_pl_list);
				}
				else{
					$res[5] = $game_pl_list;
				}
			

				/*	Disabled the shuffling of Seeds
				if($round==1){
						shuffle($res[5]);
				}*/


				/*	Top seed should not be in same pool */
				if($round==1){

						foreach($res[5] as $i => $seeds){

						if($i < (count($res[5])/2))						// New Code 5-OCT-16
						{
							//echo $i." ".(count($res[5])-($i+1))."<br>";

							$res_1[$i] = $res[5][$i];
							$res_1[count($res[5])-($i+1)] = $res[5][count($res[5])-($i+1)];
						}
							
							/*if($i%2 == 0){							// Old Code Before 5-OCT-16
								$res_2[] = $res[5][$i]; 
							}
							else{
								$res_3[] = $res[5][$i]; 
							}	*/
						}
						//$res[5] = array_merge($res_2, $res_3);		// Old Code Before 5-OCT-16
						$res[5] = $res_1;								// New Code 5-OCT-16

						foreach($res[5] as $i => $seeds){				// New Code 5-OCT-16
						
							if($i%2 == 0){
								$res_2[] = $res[5][$i]; 
							}
							else{
								$res_3[] = $res[5][$i]; 
							}
						}

					$res[5] = array_merge($res_2, $res_3);			// New Code 5-OCT-16

						if(count($res[5]) == 16)					// New Code 7-OCT-16
						{
							$temp4 = $res[5][4];
							$temp5 = $res[5][5];

							$res[5][4] = $res[5][2];
							$res[5][5] = $res[5][3];

							$res[5][2] = $temp4;
							$res[5][3] = $temp5;

								
							$temp10 = $res[5][10];
							$temp11 = $res[5][11]; 

							$res[5][10] = $res[5][12];
							$res[5][11] = $res[5][13];

							$res[5][12] = $temp10;
							$res[5][13] = $temp11;
						}
				
				}


				/* -------------------------------------- */		

				$res[6] = $res[5];

			return $res;
		}


		public function cd_cal_c($pow_vals, $num_teams, $teams, $round, $dt)		// Consolation
		{
			global $pow_vals;

			$pow_vals = array(2,4,8,16,32,64,128,256);
			
			foreach($pow_vals as $i=>$pv){
				if($num_teams > $pv)
				{
					$near_pow = $pow_vals[++$i];
				}
				else if($num_teams == $pv)
				{
					$near_pow = $pow_vals[$i];
				}
			}

			$num_p = ($num_teams - ($near_pow - $num_teams));
			$num_g = abs($num_teams - ($near_pow/2));

			$bye_p = $num_teams - $num_p;

			$nxt_r_p = $bye_p + $num_g;


				$temp_teams = $teams;

				$bye_pl_list = array();
				if($bye_p > 0){

					for($i=0;$i<$bye_p;$i++)
					{
						$pl = array_shift($temp_teams);
						$bye_pl_list[$i] = array($pl,'---');
					}
				}

				$game_pl_list = array();
				if($round==1){
					for($i=0,$k=0;$i<$num_g;$i++)
					{
						$fst = reset($temp_teams);
						$lst = end($temp_teams);

						$game_pl_list[$k] = array($fst,$lst);
						array_shift($temp_teams);
						array_pop($temp_teams);
					$k++;
					}
				}
				else{
					for($j=1,$k=0;$j<=count($teams);$j++){
						if($j%2==0){
							$game_pl_list[$k] = array($teams[$j-2],$teams[$j-1]);
							$k++;
						}
					}
				}

			$res = array();

				$res[0] = $num_p;
				$res[1] = $num_g;
				$res[2] = $bye_p;
				$res[3] = $nxt_r_p;
				$res[4] = $num_g + $bye_p;

				if(!empty($bye_pl_list)){
					$res[5] = array_merge($bye_pl_list, $game_pl_list);
				}
				else{
					$res[5] = $game_pl_list;
				}
			
				/*	Disabled the shuffling of the seed 

					if($round==1 && $dt != 'Consolation'){
						shuffle($res[5]);
					} 
				*/

		
				/*	Top seed should not be in same pool */
				if($round==1){

					foreach($res[5] as $i => $seeds){

						if($i < (count($res[5])/2))					// New Code 5-OCT-16
						{
							//echo $i." ".(count($res[5])-($i+1))."<br>";

							$res_1[$i] = $res[5][$i];
							$res_1[count($res[5])-($i+1)] = $res[5][count($res[5])-($i+1)];
						}
						
						/*if($i%2 == 0){							// Old Code Before 5-OCT-16
							$res_2[] = $res[5][$i]; 
						}
						else{
							$res_3[] = $res[5][$i]; 
						}*/
					}

						//$res[5] = array_merge($res_2, $res_3);	// Old Code Before 5-OCT-16
						$res[5] = $res_1;							// New Code 5-OCT-16

					foreach($res[5] as $i => $seeds){				// New Code 5-OCT-16
						
						if($i%2 == 0){
							$res_2[] = $res[5][$i]; 
						}
						else{
							$res_3[] = $res[5][$i]; 
						}
					}

					$res[5] = array_merge($res_2, $res_3);			// New Code 5-OCT-16

						if(count($res[5]) == 16)					// New Code 7-OCT-16
						{
							$temp4 = $res[5][4];
							$temp5 = $res[5][5];

							$res[5][4] = $res[5][2];
							$res[5][5] = $res[5][3];

							$res[5][2] = $temp4;
							$res[5][3] = $temp5;

								
							$temp10 = $res[5][10];
							$temp11 = $res[5][11]; 

							$res[5][10] = $res[5][12];
							$res[5][11] = $res[5][13];

							$res[5][12] = $temp10;
							$res[5][13] = $temp11;
						}


				}
				/* -------------------------------------- */	
					

				$res[6] = $res[5];

				$res[7] = $num_g + $bye_p;
				$res[8] = $res[5];


			return $res;
		}

		 public function get_username($user_id)
		 {
			return $this->general->get_user($user_id);
		 }

		 public function check_user_emailoption($user_id)
		 {
			return $this->general->check_user_emailoption($user_id);
		 }

		 public function get_a2mscore($user_id, $sport_id)
		 {
			return $this->general->get_user_a2mscore($user_id, $sport_id);
		 }

		 public function register_trnmt()
		 {
	
			$res = $this->model_league->insert_reg__tourn_data();
			$data['reg'] = "Thanks for Registering to this tournment. Details are sent to your email Address";
			
			if($res)
			{
				redirect('play',$data);
			}
		 }

		 public function viewbracket($tourn_id = '')
		 {
			$bid = $this->input->post('bracket_id');
		
			if($tourn_id)
			{
				$data['tourn_det'] = $this->model_league->getonerow($tourn_id);
				$data['brackets'] = $this->model_league->get_bracket_list($tourn_id);
				$data['results'] = $this->model_news->get_news();

				$this->load->view('includes/header');
				$this->load->view('view_tourn_bracket',$data);
				$this->load->view('includes/footer');
			}
			else if($this->input->post('get_bracket') or $this->input->post("tour_draw_show".$bid))
			{

				$tourn_id = $this->input->post('tourn_id');
				$data['tourn_det'] = $this->model_league->getonerow($this->input->post('tourn_id'));
				
				$get_bracket = $this->model_league->get_tourn_bracket($bid);
				$data['bracket_id'] = $get_bracket['BracketID'];
				$data['match_type'] = $get_bracket['Match_Type'];
				$data['get_bracket'] = $get_bracket;

				$data['results'] = $this->model_news->get_news();
				$data['tour_details'] = $data['tourn_det'];

	
				if($this->input->post('tourn_type') == 'Single Elimination')
				{
					if(!$get_bracket['BracketID'])
					{
						$data['no_bracket'] = "Draws are not available for the given criteria.";
					}
					else
					{
						$data['get_tourn_matches'] = $this->model_league->get_tourn_matches($data);
					}
				}

				else if($this->input->post('tourn_type') == 'Round Robin')
				{
					if(!$get_bracket['BracketID'])
					{
						$data['no_bracket'] = "Draws are not available for the given criteria.";
					}
					else
					{
						$data['get_rr_tourn_matches'] = $this->model_league->get_tourn_matches($data);
					}
				}

				else if($this->input->post('tourn_type') == 'Consolation')
				{

					if(!$get_bracket['BracketID'])
					{
						$data['no_bracket'] = "Draws are not available for the given criteria.";
					}
					else
					{
						$data['get_tourn_matches'] = $this->model_league->get_tourn_matches_main($bid);
						$data['get_cd_tourn_matches'] = $this->model_league->get_cd_tourn_matches($bid);
						$data['get_cd_num_rounds'] = $this->model_league->get_cd_tot_rounds($bid);
					}
				}

			$data['brackets'] = $this->model_league->get_bracket_list($tourn_id);

			$match_results = $this->model_league->get_tourn_match_id($bid);
			$match_id = $match_results['Tourn_match_id'];
			$data['get_match_comments'] = $this->model_league->get_match_comments($match_id);

			$this->load->view('includes/header');
			($this->input->post("template")=="view_tournament") ? 
				$this->load->view('view_tournament',$data) : $this->load->view('view_tourn_bracket',$data);
			$this->load->view('includes/footer');

			}
			else if($this->input->post("tour_draw_delete".$bid))
			{
				$tourn_id = $this->input->post('tourn_id');

				$get_tour_admin = $this->model_league->getonerow($tourn_id);
				
				if($get_tour_admin->Usersid == $this->session->userdata('users_id')){
				
					$res = $this->model_league->delete_brackets($bid);
					redirect("league/view/$tourn_id");
				
				} else {
				  echo "<h4>Unauthorized Access!</h4>";
				}
			}
			else
			{
				echo "Invalid Access!";
			}
		 }


		 public function view_matches()
		 {
			$score_type = $this->input->post('score_type');

			switch($score_type){

				case "WFF":
				case "SE_WFF":
				case "CD_WFF":
				case "CD_CD_WFF":
					$res = $this->model_league->update_wff_winner();
					$email_status = $this->email_add_score($res);
				break;

				case "ADDSCORE":		// RR ADDSCORE
					$res = $this->model_league->update_rr_tourn_match_score();
					$email_status = $this->email_add_score($res);
				break;

				case "RR_EDITSCORE":
					$res = $this->model_league->edit_rr_tourn_match_score();
						if($res['type'] == 'rr')
						$email_status = $this->email_add_score($res);
				break;

				case "SE_EDITSCORE":
				case "CD_EDITSCORE":
					$res = $this->model_league->edit_tourn_match_score();
					$email_status = $this->email_add_score($res);
				break;

				case "SE_ADDSCORE":
				case "CD_ADDSCORE":
				case "CD_CD_ADDSCORE":
					$res = $this->model_league->update_tourn_match_score();
					$email_status = $this->email_add_score($res);
				break;

				default:
					break;
			}

			$bid = $this->input->post('bracket_id'); 
			
			if($this->input->post("list_draw_matches".$bid)){
				
				$data['tourn_det'] = $this->model_league->getonerow($this->input->post('tourn_id'));

				$get_bracket_details = $this->model_league->get_tourn_bracket($bid);
				
				$data['bracket_id'] = $get_bracket_details['BracketID'];
				$data['get_bracket_details'] = $get_bracket_details;
				
				$bid = $get_bracket_details['BracketID'];

				$data['results'] = $this->model_news->get_news();
				$data['tour_details'] = $data['tourn_det'];
				$data['match_type'] = $this->input->post('match_type');

				$match_results = $this->model_league->get_tourn_match_id($bid);
				$match_id = $match_results['Tourn_match_id'];
			    $data['get_match_comments'] = $this->model_league->get_match_comments($match_id);
				

				if($this->input->post('tourn_type') == 'Single Elimination')
				{
				$data['bracket_matches'] = $this->model_league->get_tourn_matches($data);

					if($data['bracket_matches']->num_rows() == 0)
					{
						$data['no_matches'] = "Matches are not available for the given criteria.";
					}
				}
				else if($this->input->post('tourn_type') == 'Round Robin')
				{
				$data['rr_bracket_matches'] = $this->model_league->get_tourn_matches($data);

					if($data['rr_bracket_matches']->num_rows() == 0)
					{
						$data['no_matches'] = "Matches are not available for the given criteria.";
					}
				}
				else if($this->input->post('tourn_type') == 'Consolation')
				{
					if(!$get_bracket_details['BracketID'])
					{
						$data['no_matches'] = "Matches are not available for the given criteria.";
					}
					else
					{
						$data['bracket_matches_main'] = $this->model_league->get_tourn_matches_main($bid);
						$data['bracket_matches_cd'] = $this->model_league->get_cd_tourn_matches($bid);
						$data['cd_num_rounds'] = $this->model_league->get_cd_tot_rounds($bid);
					}
				}

				$this->load->view('includes/header');
				$this->load->view('view_tournament',$data);
				$this->load->view('includes/footer');
				
			}
			/*
			else if($this->input->post('add_match_score') or 
					$this->input->post('add_rr_match_score') or 
					$this->input->post('se_add_winner') or 
					$this->input->post('rr_add_winner') or 
					$this->input->post('upd_match_score') or 
					$this->input->post('cd_upd_match_score'))
			{
				if($this->input->post('add_match_score')){
					$res = $this->model_league->update_tourn_match_score();
				}
				else if($this->input->post('upd_match_score') or $this->input->post('cd_upd_match_score')){
					//echo "Functionality under progress!";
					$res = $this->model_league->edit_tourn_match_score();
				}
				else if($this->input->post('add_rr_match_score')){
					$res = $this->model_league->update_rr_tourn_match_score();
				}
				else if($this->input->post('se_add_winner') or $this->input->post('rr_add_winner')){

					$res = $this->model_league->update_wff_winner();
				}
				

			//$email_status = $this->email_add_score($res);
 
			
			//if($email_status)
			//{
				
				//$data['tourn_id'] = $tourn_match_id;
				$data['tourn_det'] = $this->model_league->getonerow($this->input->post('tourn_id'));

				$get_bracket_details = $this->model_league->get_bracket_details();
				
				$data['bracket_id'] = $get_bracket_details['BracketID'];
				$data['get_bracket_details'] = $get_bracket_details;
				
				//$data['bracket_matches'] = $this->model_league->get_tourn_matches($data);

				if($this->input->post('tourn_type') == 'Single Elimination')
				{
					$data['bracket_matches'] = $this->model_league->get_tourn_matches($data);
				}
				else if($this->input->post('tourn_type') == 'Round Robin')
				{
					$data['rr_bracket_matches'] = $this->model_league->get_tourn_matches($data);
				}

				if($this->input->post('tourn_type') == 'Consolation')
				{
					$data['bracket_matches_main'] = $this->model_league->get_tourn_matches_main($data);
					$data['bracket_matches_cd'] = $this->model_league->get_cd_tourn_matches($data);
					$data['cd_num_rounds'] = $this->model_league->get_cd_tot_rounds($data);
				}


				$data['results'] = $this->model_news->get_news();
				$data['tour_details'] = $data['tourn_det'];

				$this->load->view('includes/header');
				$this->load->view('view_tournament',$data);
				$this->load->view('includes/footer');
					
			 //}
			}
			*/
		 }


		 public function email_add_score($res)
		 {
			
			$xy = $res;
			$type = $xy['type'];

				$player1 = $xy['player1'];
				$player2 = $xy['player2'];

				$player1_partner = $xy['player1_partner'];
				$player2_partner = $xy['player2_partner'];

				$tourn_id = $xy['tourn_id'];
				$winner = $xy['winner'];

			if($type == 'se' or $type == 'rr'){

				$player1_score = $xy['player1_score'];
				$player2_score = $xy['player2_score'];
				($xy['draw_name']) ? $draw_name = $xy['draw_name'] : $draw_name = "";
				($xy['round_title']) ? $round_title = $xy['round_title'] : $round_title = "";

			}else if($type == 'wff')
			{
				$draw_name = $xy['draw_name'];
				$round_title = $xy['round_title'];
			}


			$tourn_det = $this->model_league->getonerow($tourn_id);

			$tourn_admin = $tourn_det->Usersid;

			$sess_id = $this->session->userdata('users_id');

			if($sess_id != $tourn_admin){

			$title = $tourn_det->tournament_title;

			$get_email2 = $this->get_username($tourn_admin);
			$tourn_admin_email = ($get_email2['EmailID'] != "") ? $get_email2['EmailID'] : $get_email2['AlternateEmailID'];


			$get_player1_name = $this->check_user_emailoption($player1);

			if($get_player1_name){
			$player1_name = $get_player1_name['Firstname'] . " " . $get_player1_name['Lastname'];
			$player1_email = ($get_player1_name['EmailID'] != "") ? $get_player1_name['EmailID'] : $get_player1_name['AlternateEmailID'];
			}	
			//$player1_email = ($get_player2_details['EmailID'] != "") ? $get_player2_details['EmailID'] : $get_player2_details['AlternateEmailID'];

			$get_player2_name = $this->check_user_emailoption($player2);

			if($get_player2_name){
			$player2_name = $get_player2_name['Firstname'] . " " . $get_player2_name['Lastname'];
			$player2_email = ($get_player2_name['EmailID'] != "") ? $get_player2_name['EmailID'] : $get_player2_name['AlternateEmailID'];
			}

			$get_player1_partner = $this->check_user_emailoption($player1_partner);

			if($get_player1_partner){
			$p1_partner = $get_player1_partner['Firstname'] . " " . $get_player1_partner['Lastname'];
			$p1_partner_email = ($get_player1_partner['EmailID'] != "") ? $get_player1_partner['EmailID'] : $get_player1_partner['AlternateEmailID'];
			}

			$get_player2_partner = $this->check_user_emailoption($player2_partner);
			
			if($get_player2_partner){
			$p2_partner = $get_player2_partner['Firstname'] . " " . $get_player2_partner['Lastname'];
			$p2_partner_email = ($get_player2_partner['EmailID'] != "") ? $get_player2_partner['EmailID'] : $get_player2_partner['AlternateEmailID'];
			}

			$get_winner_name = $this->get_username($winner);
			$winner_name = $get_winner_name['Firstname'] . " " . $get_winner_name['Lastname'];

			$winner_partner = ($winner == $player1) ? $player1_partner : $player2_partner;

			$get_winner_partner_name = $this->get_username($winner_partner);
			$winner_partner_name = $get_winner_partner_name['Firstname'] . " " . $get_winner_partner_name['Lastname'];

			$this->load->library('email');
			$this->email->set_newline("\r\n");
		
			$this->email->from('admin@a2msports.com', 'A2MSports');
			
			$this->email->to("$player1_email,$player2_email,$p1_partner_email,$p2_partner_email,$tourn_admin_email");  
			
			$this->email->subject('Tournament Match Score Update');


			if($type == 'se' or $type == 'rr'){

				$data = array(
					'player1_name' => $player1_name,
					'player2_name' => $player2_name,
					'player1_partner' => $p1_partner,
					'player2_partner' => $p2_partner,
					'winner' => $winner_name,
					'winner_partner_name' => $winner_partner_name,
					'player1_score' => $player1_score,
					'player2_score' => $player2_score,
					'tourn_id' => $tourn_id,
					'title' => $title,
					'draw_name' => $draw_name,
					'round_title' => $round_title,
					'page'=> 'Add-Score-SE-RR'
					);


				$body = $this->load->view('view_email_template.php',$data,TRUE);

				$this->email->message($body);   

				$stat = $this->email->send();
			
				return $stat;
			}
			else if($type == 'wff'){

				$data = array(
					'tourn_id' => $tourn_id,
					'winner' => $winner_name,
					'winner_partner_name' => $winner_partner_name,
					'title' => $title,
					'draw_name' => $draw_name,
					'round_title' => $round_title,
					'page'=> 'Add-Score-WFF'
					);

				$body = $this->load->view('view_email_template.php',$data,TRUE);
				$this->email->message($body);   
				$stat = $this->email->send();
			
			return $stat;
			}

		  } 
		  else{
			return true;
		  }

		 }

		 public function send_email_reg_players()
		 {
		 
			if($this->input->post('send_reg_email'))
			{
				$tourn_id = $this->input->post('tourn_id');

				$tourn_det = $this->model_league->getonerow($tourn_id);

				$tourn_admin = $tourn_det->Usersid;
				$get_name = $this->get_username($tourn_admin);
				$tourn_admin_name = $get_name['Firstname'] . ' ' . $get_name['Lastname'];

				$title = $tourn_det->tournament_title;

				$sub = $this->input->post('txt_sub');

				if($sub == "")
				{
					$sub = 'Message from ' . $title . ' Admin - A2MSports';
				}

				$this->load->library('email');
				$this->email->set_newline("\r\n");

				$email = $this->session->userdata('EmailID');

				foreach($this->input->post('sel_player') as $user_id)
				{
				$sql = "SELECT * FROM users WHERE Users_ID = " .$user_id;
				$result = $this->db->query($sql);
				$row = $result->row();

				$this->email->from('admin@a2msports.com', ' A2mSports');
				$this->email->to($row->EmailID);
			
				$this->email->subject($sub);

				$des = $this->input->post('des');

				$data = array(
				'firstname'=> $row->Firstname,
				'lastname'=> $row->Lastname,
				'tourn_id' => $tourn_id,
				'title' => $title,
				'admin_name' => $tourn_admin_name,
				'des' => $des,
				'page'=> 'Send Email Registered Players'
				);

				$body = $this->load->view('view_email_template.php',$data,TRUE);

				$this->email->message($body);   
				$this->email->send();
				}

				redirect("league/view/$tourn_id");
			}
		 }

		 public function update_players()
		 {
			
			$tourn_id = $this->input->post('tourn_id');
			$res = $this->model_league->update_doubles_partner();

			 if($res)
			 {
				redirect("league/view/$tourn_id");
			
			 }
		 }

		 public function get_match_scores_player1($source, $bracket_id, $tour_id, $draw_type)
		 {
			return $this->model_league->get_match_scores_player1($source, $bracket_id, $tour_id, $draw_type);
		 }

		 public function get_match_scores_player2($source, $bracket_id, $tour_id, $draw_type)
		 {
			return $this->model_league->get_match_scores_player2($source, $bracket_id, $tour_id, $draw_type);
		 }

		 public function autocomplete()
		 {
			
			$q = $_POST['name_startsWith'];
	
			$data['key'] = trim($q);
			$result = $this->model_league->search_autocomplete($data);

			if($result)
			{
				$data_new = array();
				foreach($result as $row)   
				{
					$name = $row->Firstname . ' ' . $row->Lastname . '|' . $row->Users_ID;
					array_push($data_new, $name);	
				}
			}
				echo json_encode($data_new);
		 }

		
		 public function printpdf($bracket_id)
		 {
			if(isset($_POST["print_draw"])) {

				//$data['tourn_det'] = $this->model_league->getonerow($this->input->post('tourn_id'));
		/*		
				//$get_bracket = $this->model_league->get_tourn_bracket();
				
				$data['bracket_id'] = $get_bracket['BracketID'];
				$data['get_bracket'] = $get_bracket;
				$data['get_tourn_matches'] = $this->model_league->get_tourn_matches($data);

				$data['results'] = $this->model_news->get_news();
//print_r($data['get_tourn_matches']);
				if($data['get_tourn_matches']->num_rows() != 0){
			
			$html=$this->load->view('view_bracket_print', $data, true);

			//this the the PDF filename that user will get to download
			$pdfFilePath = "tourn_brakcet.pdf";

			//load mPDF library
			$this->load->library('m_pdf');

			//generate the PDF from the given html
			$this->m_pdf->pdf->WriteHTML($html);

			//download it.
			$this->m_pdf->pdf->Output($pdfFilePath, "D");*/

			}
		 }

		 public function upload_pics_temp(){

			if($this->input->post('upload_image')){
			
				$files = $_FILES;
				$cpt = count($_FILES['userfile']['name']);
				for($i = 0; $i < $cpt; $i++)
				{
					echo $files['userfile']['name'][$i];
					$exif = exif_read_data($files['userfile']['tmp_name'][$i]);
					echo "<pre>";
					print_r($exif);
				}
			}
		 }

		 public function image_rotate_exif($filename){

			// Assuming that you store your file in this variable
				//$filename = "yourimagefile.jpg";
				$config = array();

				// Resize the image
				$this->load->library('image_lib');
				$config['image_library']	= 'gd2';
				$config['source_image']		= $filename;
				$config['new_image']		= $filename;

				// -- Check EXIF
				$exif = exif_read_data($config['source_image']);
				
				//echo "<pre>";
				//print_r($exif);

				if($exif && isset($exif['Orientation']))
				{
					$ort = $exif['Orientation'];

					if ($ort == 6 || $ort == 5)
						$config['rotation_angle'] = '270';
					if ($ort == 3 || $ort == 4)
						$config['rotation_angle'] = '180';
					if ($ort == 8 || $ort == 7)
						$config['rotation_angle'] = '90';
				}

				/*echo "<pre>";
				print_r($config);
				exit;*/

				$this->image_lib->initialize($config); 

				if(!$this->image_lib->rotate())
				{
					// Error Message here
					echo $this->image_lib->display_errors();
					$this->image_lib->clear();
					return 0;
				}
				else
				{
					$this->image_lib->clear();
					return 1;
				}
		 }

		 public function upload_pics()
		 {
		 
			if($this->input->post('upload_image')){

				$this->load->library('upload');
				$tourn_id = $this->input->post('tourn_id');

				$tour_folder = 'C:\inetpub\wwwroot\a2msports\tour_pictures\\'.$tourn_id.'';

				if (!file_exists($tour_folder)) {
					mkdir($tour_folder, 0777, true);
				}

				$files = $_FILES;
				$cpt = count($_FILES['userfile']['name']);
				for($i=0; $i<$cpt; $i++)
				{
				   $rand = md5(uniqid(rand(), true));

				   $format	=	explode('.',$files['userfile']['name'][$i]);
                   $format	=	end($format);
				
				   $re		=	md5($files['userfile']['name'][$i]);
				   $re_name =	time()."_".substr($re, 0, 8); 

				   //echo $re_name;exit;

					$_FILES['userfile']['name']		= $re_name.'.'.$format;
					$_FILES['userfile']['type']		= $files['userfile']['type'][$i];
					$_FILES['userfile']['tmp_name']	= $files['userfile']['tmp_name'][$i];
					$_FILES['userfile']['error']	= $files['userfile']['error'][$i];
					$_FILES['userfile']['size']		= $files['userfile']['size'][$i];

					$fileName = 'userfile';

					$config = array(
				    'upload_path'	=> "./tour_pictures/$tourn_id/",
					'allowed_types' => "gif|jpg|png|jpeg",
					'overwrite'		=> TRUE,
					'max_size'		=> "10000", // Can be set to particular file size , here it is ~10 MB(2048 Kb)
					'max_height'	=> "8000",
					'max_width'		=> "10000");

				   $this->load->library('upload',$config);  
				   $this->upload->initialize($config);

				   //echo $fileName;
				   //exit;

				   if($this->upload->do_upload($fileName)){
				  
					    $upload_data = $this->upload->data();

					    $thumb_folder = 'C:\inetpub\wwwroot\a2msports\tour_pictures\\'.$tourn_id.'\thumbs';

						if (!file_exists($thumb_folder)) {
							mkdir($thumb_folder, 0777, true);
						}

						// orientation
						$this->image_rotate_exif($upload_data['full_path']);

						///resize image code starts ....

                        $resize_conf = array(
							'upload_path'  => "./tour_pictures/$tourn_id/thumbs/",
							'source_image' => $upload_data['full_path'], 
							//'new_image'  => './tour_pictures/$tourn_id/thumbs/'.$upload_data['file_name'],
							'new_image'    => $upload_data['file_path'].'thumbs/'.$upload_data['file_name'],
							'width'        => '200',
							'height'       => '150'
							);

					$this->load->library('image_lib');
					$this->image_lib->initialize($resize_conf);
					
					// do it!
					if (!$this->image_lib->resize()){
						// if got fail.
						$error['resize'] = $this->image_lib->display_errors();
						//echo "error occured";
						//exit;
					}
					else{

						$this->image_rotate_exif($resize_conf['new_image']);

						$data_to_store['userfile']	= $upload_data['file_name'];						
						$data1['userfile']			= $upload_data['file_name'];
						//exit;
					}
				  
				   ///resize image code ends ....

				   //$this->upload->do_upload($fileName);
				   $fileName = $_FILES['userfile']['name'];

				   $this->model_league->insert_tourn_images($fileName);
				}
			 }
			 redirect("league/view/$tourn_id");
		  }
		  else{
			  echo "Invalid Access!";
		  }
		}

		 /* public function upload_pics()
		  {
		 
			if($this->input->post('upload_image')){

				$this->load->library('upload');
				$tourn_id = $this->input->post('tourn_id');

				$tour_folder = 'C:\inetpub\wwwroot\a2msports\tour_pictures\\'.$tourn_id.'';

				if (!file_exists($tour_folder)) {
					mkdir($tour_folder, 0777, true);
				}

				$files = $_FILES;
				$cpt = count($_FILES['userfile']['name']);
				for($i=0; $i<$cpt; $i++)
				{
				 $rand = md5(uniqid(rand(), true));

				$format=explode('.',$files['userfile']['name'][$i]);
                $format=end($format);
				//echo $format;

					$_FILES['userfile']['name']= time().md5($files['userfile']['name'][$i]).'.'.$format;
					$_FILES['userfile']['type']= $files['userfile']['type'][$i];
					$_FILES['userfile']['tmp_name']= $files['userfile']['tmp_name'][$i];
					$_FILES['userfile']['error']= $files['userfile']['error'][$i];
					$_FILES['userfile']['size']= $files['userfile']['size'][$i];

					$fileName = 'userfile';

					$config = array(
				    'upload_path' => "./tour_pictures/$tourn_id/",
					'allowed_types' => "gif|jpg|png|jpeg|pdf",
					'overwrite' => TRUE,
					'max_size' => "10000", // Can be set to particular file size , here it is ~10 MB(2048 Kb)
					'max_height' => "5000",
					'max_width' => "8000");

				$this->load->library('upload',$config);  
				$this->upload->initialize($config);

				//	$this->upload->initialize($this->set_upload_options($tourn_id));
				$this->upload->do_upload($fileName);
				$fileName = $_FILES['userfile']['name'];

				$this->model_league->insert_tourn_images($fileName);
				}
			
				 redirect("league/view/$tourn_id");
			}
		 }*/
 
		
		 public function rotate_image()
		 {

		   if($_POST){
		   //if($this->input->post("rotate$row_id")){

				foreach($_POST as $name => $content) { // Most people refer to $key => $value
				   if($content=="rotate")
					{
					   $row_id = $name;
					   $row_id = substr($row_id,-1);
				    }
				 }
		  
				 $filename	= $this->input->post("filename$row_id");
				 $angle		= $this->input->post("angle$row_id");
				 $tourn_id	= $this->input->post("tourn_id$row_id");
				 $dir		= $this->input->post("dir$row_id");
				 $out		= "";

				 $dir_angle = $dir.$angle;
				
				if($filename != ""){
			
					$data['tour_details']	= $this->model_league->getonerow($tourn_id);
				    $data['results']		= $this->model_news->get_news();
					$data['images']			= $this->model_league->get_individual_tourn_images($tourn_id);

					$image_name = substr(strrchr($filename, "/"), 1);
					//$saveto = $_SERVER['DOCUMENT_ROOT'].'\a2msports\tour_pictures\'.$tourn_id.'"\'.$image_name;

					$saveto =  'C:/inetpub/wwwroot/a2msports/tour_pictures/'.$tourn_id.'/'.$image_name;

					$this->RotateJpg($filename,$dir_angle,$saveto,$tourn_id);
				
				}
			}
		}


		 // Rotate Manipulation.
		public function RotateJpg($filename = '',$angle = 0,$savename = false,$tourn_id = '') {

				$size = getimagesize($filename); 

				//print_r($size);
				//exit;

				switch ($size['mime']){ 
				case "image/gif": 
				 
						header('Content-Type: image/gif');
						// Load
						$source = imagecreatefromgif($filename);

						// Rotate
						$rotate = imagerotate($source, $angle, 0);
						//print_r($rotate);

						// Output
						if($savename == false) {
						imagegif($rotate);
						}
						else
						imagegif($rotate,$savename);
						// Free the memory
						imagedestroy($source);
						imagedestroy($rotate);

						redirect("league/view/$tourn_id","refresh");

				break;
				case "image/jpeg": 
						
						header('Content-type: image/jpeg');
						 
						// Load
						$source = imagecreatefromjpeg($filename);

						// Rotate
						$rotate = imagerotate($source, $angle, 0);
						
						// Output
						if($savename == false) {
							imagejpeg($rotate);
						}
						else
						imagejpeg($rotate,$savename);
						// Free the memory
						imagedestroy($source);
						imagedestroy($rotate);

						redirect("league/view/$tourn_id","refresh");

				break; 


				case "image/png": 
				//echo "Image is a png"; 

						header('Content-Type: image/png');
						
						// Your original file
						$source = imagecreatefrompng($filename);
						// Rotate
						$rotate  = imagerotate($source, $angle, 0);
						// If you have no destination, save to browser
						if($savename == false) {
						imagepng($rotate);
						}
						else
						// Save to a directory with a new filename
						imagepng($rotate,$savename);

						// Standard destroy command
						imagedestroy($source);
						imagedestroy($rotate);

						redirect("league/view/$tourn_id","refresh");

				break; 
				case "image/bmp": 
				//echo "Image is a bmp"; 
						
						header('Content-Type: image/bmp');
						// Your original file
						$source = imagecreatefrombmp($filename);
						// Rotate
						$rotate  = imagerotate($source, $angle, 0);
						// If you have no destination, save to browser
						if($savename == false) {
						
						imagebmp($rotate);
						}
						else
						// Save to a directory with a new filename
						imagebmp($rotate,$savename);

						// Standard destroy command
						imagedestroy($source);
						imagedestroy($rotate);

						redirect("league/view/$tourn_id","refresh");
						
				break;
				default:
					echo "Invalid Image file";
			    break;

				}

		 }
		
		 public function set_upload_options($tourn_id)
		 { 
		 
			//$tour_folder = 'C:\inetpub\wwwroot\a2msports\tour_pictures\\'.$tourn_id.'\\';

			$tour_folder = 'C:/inetpub/wwwroot/a2msports/tour_pictures/'.$tourn_id.'/';

			$this->upload_config['upload_path'] = $tour_folder;
		  // upload an image options
				 $config = array();
				 $config['upload_path'] = $tour_folder; //give the path to upload the image in folder
				 $config['allowed_types'] = 'gif|jpg|png';
				 $config['max_size'] = '20000';
				 $config['overwrite'] = TRUE;
		    
			     return $config;
		 }


		 public function gallery()
		 {
			
			$data['tourn_ids'] = $this->model_league->get_main_tourn_ids();   //from Tournament_images table
			$data['tourn_images'] = $this->model_league->get_admin_tourn_images($data['tourn_ids']);
			$data['results'] = $this->model_news->get_news();

	
			$this->load->view('includes/header');
			$this->load->view('view_tournament_images',$data);
			$this->load->view('includes/view_right_column',$data);
			$this->load->view('includes/footer');
		 }

		
		 public function images($tourn_id)
		 {
			
			$tourn_det = $this->model_league->getonerow($tourn_id);

			$data['tourn_title'] = $tourn_det->tournament_title;
			$data['images'] = $this->model_league->get_individual_tourn_images($tourn_id);
			
			$data['results'] = $this->model_news->get_news();
	
			$this->load->view('includes/header');
			$this->load->view('view_tourn_individual_images',$data);
			$this->load->view('includes/footer');
		 }

		 public function get_tour_row_info()
	     {
			$row_id = $this->input->post('row_id');
			$res = $this->model_league->get_tour_row_info($row_id);

			$get_user1 = $this->general->get_user($res['Player1']);
			$get_user2 = $this->general->get_user($res['Player2']);

			$get_user_part1 = array('Firstname'=>"",'Lastname'=>"");
			$get_user_part2 = array('Firstname'=>"",'Lastname'=>"");

			if($res['Player1_Partner']){
			$get_user_part1 = $this->general->get_user($res['Player1_Partner']);
			$get_user_part2 = $this->general->get_user($res['Player2_Partner']);
			}
			// print_r($res);
			echo $res['Tourn_match_id']."#".$res['BracketID']."#".$res['Tourn_ID']."#".$res['Round_Num']."#".$res['Match_Num']."#".$res['Player1']."#".$res['Player2']."#".$res['Player1_Partner']."#".$res['Player2_Partner']."#".$res['Player2_Partner']."#".$get_user1['Firstname']." ".$get_user1['Lastname']."#".$get_user2['Firstname']." ".$get_user2['Lastname']."#".$get_user_part1['Firstname']." ".$get_user_part1['Lastname']."#".$get_user_part2['Firstname']." ".$get_user_part2['Lastname']."#".$res['Player1_Score']."#".$res['Player2_Score']."#".$res['Match_Date'];
		 }

		 public function get_images($tourn_id)
	     {
			  return $this->model_league->get_individual_tourn_images($tourn_id);
		 }

		 public function get_gallery($tourn_id = '')
	     {
			$tourn_id = $this->input->post("tourn_id");

			$data['tour_details'] = $this->model_league->getonerow($tourn_id);
			$data['results'] = $this->model_news->get_news();
		    $data['get_images'] = $this->model_league->get_individual_tourn_images($tourn_id);

			$this->load->view('view_gallery_tournament',$data);
		 }

		 public function double_players_change()
		 {
			$upd_partners = $this->model_league->update_doubles_partner();
			$data['tourn_partner_names'] = $upd_partners;
			$this->load->view('view_dbl_partner_ajax',$data);
		 }

		 public function flyer($tid)
		 {
			$data['tour_details'] = $this->model_league->getonerow($tid);
			$data['results'] = $this->model_news->get_news();

			//$this->load->library('Qrstr');
			//$qrcode = new QRcode();	
			//$xyz = $qrcode->png('http://a2msports.com', "base_url()org_logos/filename.png");
			
			//echo "dfdsf ".$xyz;
			//exit;
			$this->load->view('flyer',$data);
		 }

		 public function terms_conditions()
		 {	
			$this->load->view('view_terms_conditions');
		 }

		 public function medical_form()
		 {	
			$this->load->view('view_medical_release');
		 }

		 public function buy($tid)
		 {
			  if($this->input->post('tour_fee') > 0){
			
				  $tour_det = $this->model_league->getonerow($tid);

			$reg_userid		= $this->session->userdata('users_id');
			$age_group		= $this->input->post('age_group');
			$match_types	= json_encode($this->input->post('mtype'));
			$db_partner		= $this->input->post('created_users_id');
			$md_partner		= $this->input->post('created_users_id1');
			$level			= $this->input->post('level');


			//Set variables for paypal form
			$paypalURL = 'https://www.sandbox.paypal.com/cgi-bin/webscr'; //test PayPal api url
			$paypalID = 'busi@exitrow.com'; //business email

			//$paypalURL = 'https://www.paypal.com/cgi-bin/webscr'; //test PayPal api url
			//$paypalID = 'admin@a2msports.com'; //business email

			$returnURL = base_url().'paypal/success?tourn_id='.$tid.'&player='.$reg_userid.'&age_group='.$age_group.'&mtypes='.$match_types.'&partner1='.$db_partner.'&partner2='.$md_partner.'&level='.$level; //payment success url
			$cancelURL = base_url().'paypal/cancel'; //payment cancel url
			$notifyURL = base_url().'ipn'; //ipn url
			//get particular product data
			//$product = $this->model_league->getonerow($tid);
			//$userID = 1; //current user id
			$logo = base_url().'images/logo.png';
			
			$this->paypal_lib->add_field('business', $paypalID);
			$this->paypal_lib->add_field('return', $returnURL);
			$this->paypal_lib->add_field('cancel_return', $cancelURL);
			$this->paypal_lib->add_field('notify_url', $notifyURL);
			$this->paypal_lib->add_field('tourn_id', $tid);
			$this->paypal_lib->add_field('player', $this->session->userdata('users_id'));
			$this->paypal_lib->add_field('item_number',  $tid);
			$this->paypal_lib->add_field('item_name',  $tour_det->tournament_title);
			$this->paypal_lib->add_field('amount', $this->input->post('tour_fee'));        
			$this->paypal_lib->image($logo);
			
			$this->paypal_lib->paypal_auto_form();
			
			
	/*		$paypalmode = ($this->config->item('PayPalMode')=='sandbox') ? '.sandbox' : '';
	
		//-----------------------------------
		
	$ItemPrice1		=  $this->input->post('tour_fee');  

	$ItemName 		= $this->session->userdata('users_id'); //Item Name
	$ItemPrice 		= $this->input->post('tour_fee'); //Item Price
	$ItemNumber 	= $tid;							//Item Number
	$ItemDesc 		= $tour_det->tournament_title; //Item Number
	$ItemQty 		= 1; // Item Quantity

	$ItemTotalPrice = ($ItemPrice1); //(Item Price x Quantity = Total) Get total amount of product; 
	
	//$GrandTotal = ($ItemTotalPrice + $TotalTaxAmount + $HandalingCost + $InsuranceCost + $ShippinCost + $ShippinDiscount);
	$GrandTotal = ($ItemTotalPrice);

	
	//Parameters for SetExpressCheckout, which will be sent to PayPal
	$padata = 	'&METHOD=SetExpressCheckout'.
				'&RETURNURL='.urlencode($this->config->item('PayPalReturnURL')).
				'&CANCELURL='.urlencode($this->config->item('PayPalCancelURL')).
				'&PAYMENTREQUEST_0_PAYMENTACTION='.urlencode("Sponsor").
				
				'&L_PAYMENTREQUEST_0_NAME0='.urlencode($ItemName).
				'&L_PAYMENTREQUEST_0_NUMBER0='.urlencode($ItemNumber).
				'&L_PAYMENTREQUEST_0_DESC0='.urlencode($ItemDesc).
				'&L_PAYMENTREQUEST_0_AMT0='.urlencode($ItemPrice).
				'&L_PAYMENTREQUEST_0_QTY0='. urlencode($ItemQty).
				
				'&NOSHIPPING=0'. //set 1 to hide buyer's shipping address, in-case products that does not require shipping
				
				'&PAYMENTREQUEST_0_ITEMAMT='.urlencode($ItemTotalPrice).
				'&PAYMENTREQUEST_0_AMT='.urlencode($GrandTotal).
				'&PAYMENTREQUEST_0_CURRENCYCODE='.urlencode($this->config->item('PayPalCurrencyCode')).
				'&LOCALECODE=GB'. //PayPal pages to match the language on your website.
				'&LOGOIMG=http://centervillehighpto.org/images/logo_paypal.gif'. //site logo
				'&CARTBORDERCOLOR=FFFFFF'. //border color of cart
				'&ALLOWNOTE=1';
				
				
				############# set session variable we need later for "DoExpressCheckoutPayment" #######
				$sess_data = array(
							'ItemName' => $ItemName,	//Item Name
							'ItemPrice' => $ItemPrice,	//Item Price
							'ItemNumber' => $ItemNumber,	//Item Number
							'ItemTotalPrice' => $ItemTotalPrice, //(Item Price x Quantity = Total) Get total amount of product; 
							'GrandTotal' => $GrandTotal,
							'ParentID' => '',
							'tourn_id' => $tid,
							'player' => $reg_userid,
							'age_group' => $age_group,
							'mtypes' => $match_types,
							'partner1' => $db_partner,
							'partner2' => $md_partner,
							'level' => $level);

				$this->session->set_userdata($sess_data);

		//We need to execute the "SetExpressCheckOut" method to obtain paypal token
		$paypal= new CI_MyPayPal();
		$httpParsedResponseAr = $paypal->PPHttpPost('SetExpressCheckout', $padata, $this->config->item('PayPalApiUsername'), $this->config->item('PayPalApiPassword'), $this->config->item('PayPalApiSignature'), $this->config->item('PayPalMode'));
		
					//Respond according to message we receive from Paypal
			if("SUCCESS" == strtoupper($httpParsedResponseAr["ACK"]) || "SUCCESSWITHWARNING" == strtoupper($httpParsedResponseAr["ACK"]))
			{
				//Redirect user to PayPal store with Token received.
				$paypalurl ='https://www'.$paypalmode.'.paypal.com/cgi-bin/webscr?cmd=_express-checkout&token='.$httpParsedResponseAr["TOKEN"].'';
				header('Location: '.$paypalurl);
			}
			else
			{
				//Show error message
				echo '<div style="color:red"><b>Error : </b>'.urldecode($httpParsedResponseAr["L_LONGMESSAGE0"]).'</div>';
				echo '<pre>';
				print_r($httpParsedResponseAr);
				echo '</pre>';
			}		
			
			*/
			
			 } 
			 else if($this->input->post('tour_fee') == 0)   // Register without FEE functionality
			 {
				
				$res = $this->model_league->reg_tourn_no_fee();
				if($res)
				{
					$user_id = $this->session->userdata('users_id');
					
					$tourn_id = $this->input->post('id');
			
					$partner1 = $this->input->post('created_users_id');

					$partner2 = $this->input->post('created_users_id1');

					$match_types = json_encode($this->input->post('mtype'));
					
						$sql = "SELECT * FROM users WHERE Users_ID = " .$user_id;
						$result = $this->db->query($sql);
						$row = $result->row();

						$tourn_det = $this->model_league->getonerow($tourn_id);   //tournament details

						$title = $tourn_det->tournament_title;

						
						$this->load->library('email');
						$this->email->set_newline("\r\n");
						 
						$this->email->from('admin@a2msports.com', ' A2mSports');
						$this->email->to($row->EmailID);

						$this->email->subject('Tournament Registration - A2MSports');

						$data = array(
						'firstname'=> $row->Firstname,
						'lastname'=> $row->Lastname,
						'tourn_id' => $tourn_id,
						'title' => $title,
						'page'=> 'Registration-Singles'
						);

						
						$body = $this->load->view('view_email_template.php',$data,TRUE);

						$this->email->message($body);   

						$this->email->send();

				    if(in_array("Doubles", $this->input->post('mtype')) or in_array("Mixed", $this->input->post('mtype'))){

						$partner1_email="";
						$partner2_email="";
						

						$tourn_det = $this->model_league->getonerow($tourn_id);   //tournament details

						$title = $tourn_det->tournament_title;

						$this->load->library('email');
						$this->email->set_newline("\r\n");
						 
						$this->email->from('admin@a2msports.com', ' A2mSports');

						if($partner1){

							$sess_user = $this->session->userdata('user');
							$get_partner1_details = $this->get_username($partner1);
							$partner1_email = $get_partner1_details['EmailID'];      //doubles partner
							$partner1_name  = $get_partner1_details['Firstname'] . " " . $get_partner1_details['Lastname'];  
							$this->email->to($partner1_email);

							$this->email->subject('Tournament Registration - A2MSports');
							$data = array(
							'tourn_id' => $tourn_id,
							'partner1' => $partner1_name,
							'user' => $sess_user,
							'title' => $title,
							'page'=> 'Tourn-Reg-Doubles'
							);

							$body = $this->load->view('view_email_template.php',$data,TRUE);

							$this->email->message($body);   

							$this->email->send();
	
						}

						if($partner2){
							$sess_user2 = $this->session->userdata('user');
							$get_partner2_details = $this->get_username($partner2);
							$partner2_email = $get_partner2_details['EmailID'];      //Mixed partner
							$partner2_name  = $get_partner2_details['Firstname'] . " " . $get_partner2_details['Lastname'];
							$this->email->to($partner2_email);
							
							$this->email->subject('Tournament Registration - A2MSports');
							$data = array(
							'tourn_id' => $tourn_id,
							'partner2' => $partner2_name,
							'user2' => $sess_user2,
							'title' => $title,
							'page'=> 'Tourn-Reg-Mixed'
							);
							
							$body = $this->load->view('view_email_template.php',$data,TRUE);

							$this->email->message($body);   

							$this->email->send();
						}


					}
						
					//$reg_suc = "You have successfully registered for this tournament.";
					$reg_suc = "5";

				/*	$data['reg_suc'] = "You have successfully registered for this tournament.";
					$data['tour_details'] = $this->model_league->getonerow($tourn_id);
					$data['results'] = $this->model_news->get_news();
				*/
						redirect("league/view/$tourn_id/$reg_suc");
	
				/*	$this->load->view('includes/header');
					$this->load->view('view_tournament', $data); 
					$this->load->view('includes/footer');
				*/					
				}
			 }
			 else
			 {
				echo "Invalid Request!";
			 }
		}

		public function check_edit_match($bracket_id, $match_num, $round, $draw_type, $tour_type){

			return $this->model_league->check_edit_match($bracket_id, $match_num, $round, $draw_type, $tour_type);

		}

		public function cd_check_edit_match($bracket_id, $match_num, $round, $draw_type, $tour_type){

			return $this->model_league->cd_check_edit_match($bracket_id, $match_num, $round, $draw_type, $tour_type);

		}

		public function add_comments()
		{
				
				$comm = $this->input->post('com');
				$res = $this->model_league->insert_comment();

				// send email to players....
				
				if($this->session->userdata('users_id') == $this->input->post('player1'))
				{
					$player1_id = "";
					$player2_id = $this->input->post('player2');
					$player1_partner = $this->input->post('player1_partner');
					$player2_partner = $this->input->post('player2_partner');
				}
				else if($this->session->userdata('users_id') == $this->input->post('player2'))
				{
					$player1_id = $this->input->post('player1');
					$player2_id = "";
					$player1_partner = $this->input->post('player1_partner');
					$player2_partner = $this->input->post('player2_partner');
				}
				else
				{
					$player1_id = $this->input->post('player1');
					$player2_id = $this->input->post('player2');
					$player1_partner = $this->input->post('player1_partner');
					$player2_partner = $this->input->post('player2_partner');
				}
				//echo $player2_id ."p2" .  $player1_partner ."p1_r".  $player2_partner . "p2_r";

		$get_player1_details = $this->get_username($player1_id);
		$player1_email = ($get_player1_details['EmailID'] != "") ? $get_player1_details['EmailID'] : $get_player1_details['AlternateEmailID'];

		$get_player2_details = $this->get_username($player2_id);
		$player2_email = ($get_player2_details['EmailID'] != "") ? $get_player2_details['EmailID'] : $get_player2_details['AlternateEmailID'];
				
		$get_partner1_details = $this->get_username($player1_partner);
		$partner1_email = ($get_partner1_details['EmailID'] != "") ? $get_partner1_details['EmailID'] : $get_partner1_details['AlternateEmailID'];    
							
		$get_partner2_details = $this->get_username($player2_partner);
		$partner2_email = ($get_partner2_details['EmailID'] != "") ?  $get_partner2_details['EmailID'] : $get_partner2_details['AlternateEmailID'];
				

				//echo $player2_email ."p2email    " .  $partner1_email ."p1_remail     ".  $partner2_email . "p2_remail ";
				//exit;
				
				
				$match_id = $this->input->post('match_id');
				$tourn_id = $this->input->post('tourn_id');
				
				$tourn_det = $this->model_league->getonerow($tourn_id);   //tournament details
				$title = $tourn_det->tournament_title;

				$this->load->library('email');
				$this->email->set_newline("\r\n");
						 
				$this->email->from('admin@a2msports.com', ' A2mSports');
				$this->email->to($player1_email,$player2_email,$partner1_email,$partner2_email);

				$this->email->subject("Message (" . $title . ")- A2MSports");
				
				$data = array(
				'title' => $title,
				'message' => $comm,
				'tourn_id' => $tourn_id,
				'page'=> 'Tournament Match Comments'
				);

				$body = $this->load->view('view_email_template.php',$data,TRUE);

				$this->email->message($body);   

				$this->email->send();

           ///  end of send email to players..

				$get_match_comments = $this->model_league->get_match_comments($match_id);

				foreach($get_match_comments as $comment){

					$name = $this->general->get_user($comment->Users_Id);
					$full_name = ucfirst($name['Firstname'])." ".ucfirst($name['Lastname']);

					$op .= "<div class='pull-left' style='margin-right:20px'><img style='width:50px !important; height:50px !important;' class='img-circle' src='".base_url()."profile_pictures/".$name['Profilepic']."' /></div>
					<div style='margin-top:5px'>
						<span style='font-weight:bold; color:#464646'>".$full_name."</span>
						<span style='font-size:11px; color:#959595'>".date("m/d/Y H:i", strtotime($comment->Comment_On))."</span>
						<div style='margin-top:5px;'>$comment->Comments</div>
					</div>
					<div style='clear:both; height:20px'></div>";

				}
				echo $op;

				//redirect("events/view/$ev_id/4");
			
		}



	}