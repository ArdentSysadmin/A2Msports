<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

      // session_start(); 

	class academy extends CI_Controller {
	
	public $short_code;
	public $academy_admin;
	public $logged_user;
	public $is_academy_admin;

		public function __construct()
		{
			parent:: __construct();
			$this->load->helper('form', 'url');
			$this->load->library('form_validation');
			$this->load->library('session');

			//if(!$this->session->userdata('user')){
				//redirect('login');
			//}

			// Load database			
			$this->load->model('academy_mdl/model_academy');
			$this->load->model('academy_mdl/model_general', 'general');
			$this->load->model('academy_mdl/model_news');

			$this->short_code		= $this->uri->segment(1);
			$this->academy_admin	= $this->general->get_org_admin($this->short_code);
			$this->logged_user		= $this->session->userdata('users_id');

			$this->admin_menu_items = array('0'=>'');
			if($this->logged_user != $this->academy_admin){
			$this->admin_menu_items = array('0'=>'8');
			$this->is_academy_admin = 1;
			}
		}

		public function get_club_menu($org_id){
			$get_menu = $this->general->get_club_menu($org_id);
			$club_menu = array();

			if($get_menu)
				$club_menu = json_decode($get_menu, TRUE);
			return $club_menu;
		}

		public function index($data="")
		{
			$url_seg  = $this->uri->segment(1); 
			$last_url = array('redirect_to'=>$url_seg);
			$this->session->set_userdata($last_url);
			
			$data['academy_list'] = $this->model_academy->get_academy_list(); 
			
			//$data['results'] = $this->model_academy->get_list();
			$data['results'] = $this->model_news->get_news();
			
			$this->load->view('academy_views/includes/header');
			$this->load->view('academy_views/view_academy_list',$data);
			$this->load->view('academy_views/includes/view_right_column.php',$data);
			$this->load->view('academy_views/includes/academy_footer');				
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

/*		public function league($org_id)
		{

			$data = $this->get_org_details($org_id);
			$data['intrests'] = parent::index();

			$this->load->view('includes/academy_header',$data);
			$this->load->view('view_league',$data);
			$this->load->view('includes/academy_right_column',$data);
			$this->load->view('includes/academy_footer');
		}*/

/*		public function view_trnmt($org_id, $tour_id)
		{
			$data	= $this->get_org_details($org_id);
			$tr_det	= parent::view($tour_id);

			$data['tr_det']		  = $tr_det;
			$data['tour_details'] = $tr_det;
			//$data['reg_suc'] = $stat;

			$this->load->view('includes/academy_header',$data);
			$this->load->view('view_tournament', $data);
			$this->load->view('includes/academy_footer');
		}*/

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
			
			$this->load->view('academy_views/includes/academy_header',$data);
			$this->load->view('academy_views/view_academy_details',$data);
			$this->load->view('academy_views/includes/academy_right_column',$data);
			$this->load->view('academy_views/includes/academy_footer');
		}

		public function update_act_menu($org_id)
		{
			if($this->input->post('sbt_menu_links')){
				
				$res = $this->model_academy->update_act_menu($org_id);
				redirect($this->short_code);
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

			$this->load->view('academy_views/includes/academy_header',$data);
			$this->load->view('academy_views/view_add_academy_news',$data);
			$this->load->view('academy_views/includes/academy_right_column',$data);
			$this->load->view('academy_views/includes/academy_footer');
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

					$this->load->view('academy_views/includes/academy_header',$data);
					$this->load->view('academy_views/view_add_academy_news',$data);
					$this->load->view('academy_views/includes/academy_right_column',$data);
					$this->load->view('academy_views/includes/academy_footer');		
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

			$this->load->view('academy_views/includes/academy_header',$data);
			$this->load->view('academy_views/view_latest_news' ,$data);
			$this->load->view('academy_views/includes/academy_right_column',$data);
			$this->load->view('academy_views/includes/academy_footer');	
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

			$this->load->view('academy_views/includes/academy_header',$data);
			$this->load->view('academy_views/view_academy_news_edit' ,$data);
			$this->load->view('academy_views/includes/academy_right_column',$data);
			$this->load->view('academy_views/includes/academy_footer');	
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
			
				$this->load->view('academy_views/includes/academy_header',$data);
				$this->load->view('academy_views/view_latest_news' ,$data);
				$this->load->view('academy_views/includes/academy_right_column',$data);
			    $this->load->view('academy_views/includes/academy_footer');
					
			}
		}

		public function news($org_id)
		{
			$data['news_list'] = $this->model_academy->get_specific_news($org_id);

			$data['org_details'] = $this->model_academy->get_academy_details($org_id);
			$data['menu_list'] = $this->model_academy->get_menu_list();
			$data['act_menu_list'] = $this->model_academy->get_act_menu_list($org_id);
			$data['results'] = $this->model_academy->get_news($org_id);

			$this->load->view('academy_views/includes/academy_header',$data);
			$this->load->view('academy_views/view_specific_academy_news' ,$data);
			$this->load->view('academy_views/includes/academy_right_column',$data);
			$this->load->view('academy_views/includes/academy_footer');	
		}

		public function list_news()
		{
			$data['news_list'] = $this->model_academy->get_academy_list_news(); 

			//$data['org_details'] = $this->model_academy->get_academy_details($org_id); 
			$data['results'] = $this->model_academy->get_list();
			$data['menu_list'] = $this->model_academy->get_menu_list();
			//$data['act_menu_list'] = $this->model_academy->get_act_menu_list($org_id);

			$this->load->view('academy_views/includes/academy_header',$data);
			$this->load->view('academy_views/view_academy_list_news' ,$data);
			$this->load->view('academy_views/includes/academy_right_column',$data);
			$this->load->view('academy_views/includes/academy_footer');	
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

		public function get_sport($sport_id)
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
				
				$this->load->view('academy_views/includes/academy_header',$data);
				$this->load->view('academy_views/view_academy_details',$data);
				$this->load->view('academy_views/includes/academy_right_column',$data);
				$this->load->view('academy_views/includes/academy_footer');
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

			
			$this->load->view('academy_views/includes/academy_header',$data);
			$this->load->view('academy_views/view_academy_details',$data);
			$this->load->view('academy_views/includes/academy_right_column',$data);
			$this->load->view('academy_views/includes/academy_footer');
			
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
			
			$this->load->view('academy_views/includes/academy_header',$data);
			$this->load->view('academy_views/view_academy_coaches',$data);
			$this->load->view('academy_views/includes/academy_right_column',$data);
			$this->load->view('academy_views/includes/academy_footer');
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
			
			$this->load->view('academy_views/includes/academy_header',$data);
			$this->load->view('academy_views/view_academy_coaches',$data);
			$this->load->view('academy_views/includes/academy_right_column',$data);
			$this->load->view('academy_views/includes/academy_footer');
			
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
			
			$this->load->view('academy_views/includes/academy_header',$data);
			$this->load->view('academy_views/view_academy_members',$data);
			$this->load->view('academy_views/includes/academy_right_column',$data);
			$this->load->view('academy_views/includes/academy_footer');
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
				
				$this->load->view('academy_views/includes/academy_header',$data);
				$this->load->view('academy_views/view_academy_members',$data);
				$this->load->view('academy_views/includes/academy_right_column',$data);
				$this->load->view('academy_views/includes/academy_footer');
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
			$this->load->view('academy_views/view_ajax_academy_users' ,$data);	
		}


		public function update_pom(){

			$data = array('user'  => $this->input->post('txt_ac_pom_id'), 
						'academy' => $this->input->post('txt_org'));

			$upd_pom = $this->model_academy->update_pom($data);
		}


	}