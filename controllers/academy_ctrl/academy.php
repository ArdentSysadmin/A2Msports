<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

	// session_start(); 
	class academy extends CI_Controller {
	
	public $short_code;
	public $academy_admin;
	public $academy_id;
	public $logged_user;
	public $is_club_admin;

		public function __construct()
		{
			parent:: __construct();
			$this->load->helper('form', 'url');
			$this->load->library('form_validation');
			$this->load->library('session');

			//if(!$this->session->userdata('user')){
				//redirect('login');
			//}
			//error_reporting(-1);
			// Load database			
			$this->load->model('academy_mdl/model_academy');
			$this->load->model('academy_mdl/model_general', 'general');
			$this->load->model('academy_mdl/model_news');

			$this->short_code			= $this->uri->segment(1);
			$this->academy_admin	= $this->general->get_org_admin($this->short_code);
			$this->academy_id			= $this->general->get_orgid($this->short_code);
			$this->logged_user			= $this->session->userdata('users_id');
			//echo "L ".$this->logged_user;
//echo "<pre>";print_r( $http_response_header ); exit;
/*print_r($this->session->userdata);
echo "<br>_________________________________";
print_r($this->session);
exit;*/
			$this->admin_menu_items = array('0'=>'');
			if($this->logged_user != $this->academy_admin)
			$this->admin_menu_items = array('0'=>'8');

			$this->is_club_admin = 0;
			if($this->logged_user == $this->academy_admin){
			$this->is_club_admin = 1;
			}
//echo "<pre>"; print_r($_SERVER['HTTP_X_FORWARDED_HOST']); exit;
			if(!$this->logged_user){
			$this->load->library('facebook' ,  array("appId" => FB_APPID, "secret" => FB_KEY, "redirect_url" => FB_REDIRECT ));
			//$this->load->library('facebook');
			}
		//				echo "<pre>"; print_r($GLOBALS); exit;

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

		public function get_onerow($table, $column, $val){
			return $this->general->get_onerow($table, $column, $val);
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
			$org_details				= $this->model_academy->get_academy_details($org_id); 
			$data['org_details']	= $org_details; 

			$data['creator']				= $org_details['Aca_User_id'];

			$data['menu_list']			= $this->model_academy->get_menu_list();
			$data['act_menu_list']	= $this->model_academy->get_act_menu_list($org_id);
			$data['results']				= $this->model_academy->get_news($org_id);
			$data['sport_levels']		= $this->model_academy->get_tennis_levels();

			return $data;
		}

		public function get_org_creator($org_id){
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
			if($_GET['st'] == '1' or $_GET['st'] == '2' or $_GET['st'] == '3' or $_GET['st'] == '4'){
					$org_details			= $this->model_academy->get_academy_details($org_id);
					$data['org_details']	= $org_details;
					$data['pg']				= $_GET['st'];

					$this->load->view('academy_views/view_reg_popup', $data);
			}
			else{

			//error_reporting(-1);
			$data['search_fname']	= "";
			$data['coach_name']		= "";
			$org_details			= $this->model_academy->get_academy_details($org_id);
			//echo "<pre>"; print_r($org_details); exit;
			$data['org_details']	= $org_details; 

			$data['creator']		= $org_details['Aca_User_id'];
			$data['pom_user'] 		= "";
			
			if($org_details['POM'])
			$data['pom_user'] 		= $this->model_academy->get_user($org_details['POM']);
		
			$data['menu_list']			= $this->model_academy->get_menu_list();
			$data['act_menu_list']	= $this->model_academy->get_act_menu_list($org_id);
			$data['tourn_list']			= $this->model_academy->get_user_create_tournments($data['creator']);
			$data['events_list']		= $this->model_academy->get_user_create_events($data['creator']);
			
			//$data['past_tournments'] = $this->model_academy->get_user_past_tournments($data['creator']); 

			$data['club_members']    = $this->model_academy->get_members($org_id, $org_details['Primary_Sport']);
			//echo "<pre>"; print_r($data['club_members']); exit;
			
			//$club_leagues = array_merge($data['tourn_list'], $data['past_tournments']);
			$club_leagues = $data['tourn_list'];
			$club_events	  = $data['events_list'];
			//echo "<pre>"; print_r($club_leagues); exit;
			$data['club_leagues'] = array_splice($club_leagues, 0, 4);
			$data['club_events']   = array_splice($club_events, 0, 4);
			//echo "<pre>"; print_r($data['club_members']); exit;
			//$data['results'] = $this->model_news->get_news();
			$data['results']		 = $this->model_academy->get_news($org_id);
			$data['sport_levels'] = $this->model_academy->get_tennis_levels();
			$data['club_testimonials'] = $this->model_academy->get_testimonials($org_id);
	
			$facility_details				= $this->model_academy->get_club_facility($org_id); 
			$data['facility_details']	= $facility_details;
			$data['org_id']				= $org_id;

			$this->load->view('academy_views/includes/academy_header', $data);
			if($org_id == 1176){
			$data['gpa_members'] = $this->model_academy->get_top_members_list($org_id);
			$this->load->view('academy_views/view_gpa_home', $data);
			}
			else if($org_id == 1166){
			//$data['gpa_members'] = $this->model_academy->get_members_list($org_id);
			$this->load->view('academy_views/view_sreenidhi_home', $data);
			}
			else{
			$this->load->view('academy_views/view_academy_details', $data);
			}
			//$this->load->view('academy_views/includes/academy_right_column',$data);
			$this->load->view('academy_views/includes/academy_footer');
			}
		}

	public function details2($org_id)
		{
			if($_GET['st'] == '1'){
					$org_details			= $this->model_academy->get_academy_details($org_id);
					$data['org_details']	= $org_details;

					$this->load->view('academy_views/view_reg_popup', $data);
			}
			else{

			//error_reporting(-1);
			$data['search_fname']	= "";
			$data['coach_name']		= "";
			$org_details			= $this->model_academy->get_academy_details($org_id);
			//echo "<pre>"; print_r($org_details); exit;
			$data['org_details']	= $org_details; 

			$data['creator']		= $org_details['Aca_User_id'];
			$data['pom_user'] 		= "";
			
			if($org_details['POM'])
			$data['pom_user'] 		= $this->model_academy->get_user($org_details['POM']);
		
			$data['menu_list']		= $this->model_academy->get_menu_list();
			$data['act_menu_list']	= $this->model_academy->get_act_menu_list($org_id);
			$data['tourn_list']		= $this->model_academy->get_user_create_tournments($data['creator']);
			
			$data['past_tournments'] = $this->model_academy->get_user_past_tournments($data['creator']); 

			$data['club_members']    = $this->model_academy->get_members($org_id, $org_details['Primary_Sport']);
			//echo "<pre>"; print_r($data['club_members']); exit;
			
			$club_leagues = array_merge($data['tourn_list'], $data['past_tournments']);
			
			$data['club_leagues'] = array_splice($club_leagues, 0, 4);
			//echo "<pre>"; print_r($data['club_members']); exit;
			//$data['results'] = $this->model_news->get_news();
			$data['results']		 = $this->model_academy->get_news($org_id);
			$data['sport_levels'] = $this->model_academy->get_tennis_levels();
			$data['club_testimonials'] = $this->model_academy->get_testimonials($org_id);
	
			$facility_details					= $this->model_academy->get_club_facility($org_id); 
			$data['facility_details']	= $facility_details;

			$this->load->view('academy_views/includes/academy_header', $data);
			$this->load->view('academy_views/view_academy_details_test', $data);
			//$this->load->view('academy_views/includes/academy_right_column',$data);
			$this->load->view('academy_views/includes/academy_footer');
			}
		}

		public function update_act_menu($org_id)
		{
			if($this->input->post('sbt_menu_links')){
				
				$res = $this->model_academy->update_act_menu($org_id);
				redirect($this->short_code);
			}
			else{ echo "Invalid Access!"; }
		}
		
		public function get_user($user_id){
			return $this->model_academy->get_user($user_id);
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
			$org_id						= $news_id_det['Org_Id'];

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

				$creator = $org_details['Aca_User_id'];
			
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

			$creator = $org_details['Aca_User_id'];
		
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
			
			$this->load->view('academy_views/includes/academy_header', $data);

			if(count($data['coaches_list']) == 1)
			$this->load->view('academy_views/view_coach_profile', $data);
			else
			$this->load->view('academy_views/view_academy_coaches', $data);

			//$this->load->view('academy_views/includes/academy_right_column',$data);
			$this->load->view('academy_views/includes/academy_footer');
		}

		public function coach_profile($short_code, $coach_id){
			$data['coach_name']  = "";
			$org_id = $this->academy_id;
			$data['org_id'] = $org_id;
			$data['coach_id'] = $coach_id;
			$data['coaches_list'] = $this->model_academy->get_coaches_list($org_id);
			
			$org_details = $this->model_academy->get_academy_details($org_id); 
			$data['org_details'] = $org_details; 

			$data['results'] = $this->model_academy->get_news($org_id);
			$data['menu_list'] = $this->model_academy->get_menu_list();
			$data['act_menu_list'] = $this->model_academy->get_act_menu_list($org_id);
			
			$this->load->view('academy_views/includes/academy_header',$data);
			$this->load->view('academy_views/view_coach_profile',$data);
			$this->load->view('academy_views/includes/academy_footer');


		}

		public function get_coachratings($user_id){
			return $this->model_academy->getCoachRatings($user_id);
		}

		public function get_userratings($user_id){
			return $this->model_academy->getUserRatings($user_id);
		}

		public function search_coaches()
		{
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
			//$data['coach_results'] = $this->model_academy->search_coaches($data);
			
			
			$org_details = $this->model_academy->get_academy_details($org_id); 
			$data['org_details'] = $org_details; 

			$data['results'] = $this->model_academy->get_news($org_id);

			$data['menu_list'] = $this->model_academy->get_menu_list();
			$data['act_menu_list'] = $this->model_academy->get_act_menu_list($org_id);
			
			$this->load->view('academy_views/includes/academy_header',$data);
			$this->load->view('academy_views/view_academy_coaches',$data);
			//$this->load->view('academy_views/view_academy_details',$data);
			$this->load->view('academy_views/includes/academy_right_column',$data);
			$this->load->view('academy_views/includes/academy_footer');
			
			}
		}

		public function get_user_membership($org_id, $user_id)
		{
			return $this->model_academy->get_user_membership($org_id, $user_id);
		}

		public function member_list($org_id, $send_stat = '')
		{
			$data['search_fname']  = "";
			$data['org_id'] = $org_id;
			$data['query'] = $this->model_academy->get_members_list($org_id);

			//$data['coaches_list'] = $this->model_academy->get_coaches_list($org_id);
			
			$org_details					= $this->model_academy->get_academy_details($org_id); 
			//$data['sports_list']		= $this->general->get_sports(); 
			$data['sports_list']		= $this->model_academy->get_club_sports($org_id); 
			$data['org_details']		= $org_details; 
			$data['mem_codes']	= $this->model_academy->get_mem_codes($org_id);
			$data['results']				= $this->model_academy->get_news($org_id);
			//echo "<pre>"; print_r($data); exit;
			/*$data['menu_list']		= $this->model_academy->get_menu_list();
			$data['act_menu_list'] = $this->model_academy->get_act_menu_list($org_id);*/

			//$data['sport_levels'] =  $this->model_academy->get_tennis_levels();
			
			$data['ag_grp_list'] = array(
									'U10'	=>'Under 10',
									'U11'	=>'Under 11',
									'U12'	=>'Under 12',
									'U13'	=>'Under 13',
									'U14'	=>'Under 14',
									'U15'	=>'Under 15',
									'U16'	=>'Under 16',
									'U17'	=>'Under 17',
									'U18'	=>'Under 18',
									'U19'	=>'Under 19',
									'U21'	=>'Under 21',
									'Kids'	=>'Kids',		
									'Adults'=>'Adults'		
									);
			//echo "test"; exit;
			if($send_stat != ""){
				$data['user_notif_status'] = $send_stat;
			}

			$data['view_type']	= 'grid';

			$this->load->view('academy_views/includes/academy_header', $data);
			$this->load->view('academy_views/view_academy_members', $data);
			//$this->load->view('academy_views/includes/academy_right_column',$data);
			$this->load->view('academy_views/includes/academy_footer');
		}

		public function rankings($org_id) {
			$data['org_id'] = $org_id;
			//$data['club_results'] = $this->model_academy->get_assoc_clubs($org_id);

			$org_details				= $this->model_academy->get_academy_details($org_id); 
			$data['sports_list']		= $this->general->get_sports(); 
			$data['org_details']		= $org_details; 

			$this->load->view('academy_views/includes/academy_header', $data);
			$this->load->view('academy_views/view_gpa_rankings', $data);
			$this->load->view('academy_views/includes/academy_footer');
		}

		public function rankings2($org_id) {
			$data['org_id']			= $org_id;
			$org_details				= $this->model_academy->get_academy_details($org_id); 
			$data['sports_list']	= $this->general->get_sports(); 
			$data['org_details']	= $org_details; 

			$this->load->view('academy_views/includes/academy_header', $data);
			$this->load->view('academy_views/view_gpa_rankings', $data);
			$this->load->view('academy_views/includes/academy_footer');
		}

		public function places2play($org_id){
			$data['org_id'] = $org_id;
			//$data['club_results'] = $this->model_academy->get_assoc_clubs($org_id);

			$org_details				= $this->model_academy->get_academy_details($org_id); 
			$data['sports_list']		= $this->general->get_sports(); 
			$data['org_details']		= $org_details; 

			$this->load->view('academy_views/includes/academy_header', $data);
			$this->load->view('academy_views/view_coming_soon', $data);
			$this->load->view('academy_views/includes/academy_footer');
		}

		public function club_benefits($org_id){
			$data['org_id'] = $org_id;
			//$data['club_results'] = $this->model_academy->get_assoc_clubs($org_id);

			$org_details				= $this->model_academy->get_academy_details($org_id); 
			$data['sports_list']		= $this->general->get_sports(); 
			$data['org_details']		= $org_details; 

			$this->load->view('academy_views/includes/academy_header', $data);
			$this->load->view('academy_views/view_coming_soon', $data);
			$this->load->view('academy_views/includes/academy_footer');
		}

			public function ratings()
		{
			$org_id = $this->academy_id;
			$data['search_fname']  = "";
			$data['org_id'] = $org_id;

			$org_details				= $this->model_academy->get_academy_details($org_id); 
			$data['sports_list']		= $this->general->get_sports(); 
			$data['org_details']		= $org_details; 
			$data['mem_codes']	= $this->model_academy->get_mem_codes($org_id);
			$data['results']			= $this->model_academy->get_news($org_id);

			//echo "<pre>"; print_r($data); exit;
			/*$data['menu_list']		= $this->model_academy->get_menu_list();
			$data['act_menu_list'] = $this->model_academy->get_act_menu_list($org_id);*/

			//$data['sport_levels'] =  $this->model_academy->get_tennis_levels();
			
			$data['ag_grp_list'] = array(
									'U9'	=>'Under 9',
									'U10'	=>'Under 10',
									'U11'	=>'Under 11',
									'U12'	=>'Under 12',
									'U13'	=>'Under 13',
									'U14'	=>'Under 14',
									'U15'	=>'Under 15',
									'U16'	=>'Under 16',
									'U17'	=>'Under 17',
									'U18'	=>'Under 18',
									'U19'	=>'Under 19',
									'U21'	=>'Under 21',
									'Kids'	=>'Kids',		
									'Adults'=>'Adults'		
									);
			//echo "test"; exit;
			if($send_stat != ""){
				$data['user_notif_status'] = $send_stat;
			}
			
			if($this->input->post('search_mem'))
		    {
				$data['name']					= $this->input->post('name');
				$data['sport']					= 7;
				$data['level']					= $this->input->post('level');
				$data['ag_grp']				= $this->input->post('ag_grp');
				$data['sel_gend']			= $this->input->post('sel_gend');
				$data['rating_type']		= $this->input->post('rating_type');
//echo "<pre>"; print_r($data); exit;
				$data['query'] = $this->model_academy->search_members_list($data);
			}
			else{
				$data['query']				= $this->model_academy->get_members_list($org_id);
				$data['rating_type']	= "Doubles";
			}

			$data['sport_levels']	= $this->model_academy->get_sport_levels(7);
			$data['ag_grp_list'] = array(
									'U10'	=>'Under 10',
									'U11'	=>'Under 11',
									'U12'	=>'Under 12',
									'U13'	=>'Under 13',
									'U14'	=>'Under 14',
									'U15'	=>'Under 15',
									'U16'	=>'Under 16',
									'U17'	=>'Under 17',
									'U18'	=>'Under 18',
									'U19'	=>'Under 19',
									'U21'	=>'Under 21',
									'Kids'	=>'Kids',		
									'Adults'=>'Adults'		
									);
			//echo "test"; exit;
			if($send_stat != ""){
				$data['user_notif_status'] = $send_stat;
			}

			$this->load->view('academy_views/includes/academy_header',$data);
			$this->load->view('academy_views/view_member_ratings',$data);
			$this->load->view('academy_views/includes/academy_footer');
		}

		public function get_mem_dets(){
				$tab_id	= $this->input->post('tab_id');
				$dets		= $this->model_academy->get_mem_dets($tab_id);
				$sport_labels = array('1' => 'Tennis', '2' => 'Table Tennis', '3' => 'Badminton', '4' => 'Golf', '5' => 'Racquetball', '6' => 'Squash', '7' => 'Pickleball');
				echo "<div style='margin-left:15px;'>";
				echo "<b>Membership Type:</b> ". $dets['Membership_Type']."<br />";
				echo "<b>Sport:</b> ". $sport_labels[$dets['Sport_Type']]."<br />";
				echo "<b>Frequency:</b> ". $dets['Frequency']."<br>";
				echo "<b>Fee: </b>". number_format($dets['Fee'], 2)."<br />";
				if($dets['ActivationFee'])
				echo "<b>Activation Fee: </b>";
				echo "<input type='text' name='custom_act_fee' id='custom_act_fee' style='width:12%; text-align:right;' class='' value='".number_format($dets['ActivationFee'], 2)."' /><br />";
				echo "</div>";
		}

		public function member_list_new($org_id)
		{
			$data['search_fname']  = "";
			$data['org_id'] = $org_id;
			$data['query'] = $this->model_academy->get_members_list($org_id);

			//$data['coaches_list'] = $this->model_academy->get_coaches_list($org_id);
			
			$org_details = $this->model_academy->get_academy_details($org_id); 
			$data['sports_list']  = $this->general->get_sports(); 
			$data['org_details'] = $org_details; 

			//$data['results'] = $this->model_academy->get_news($org_id);

			/*$data['menu_list'] = $this->model_academy->get_menu_list();
			$data['act_menu_list'] = $this->model_academy->get_act_menu_list($org_id);*/

			//$data['sport_levels'] =  $this->model_academy->get_tennis_levels();
			
			$data['ag_grp_list'] = array(
									'U10'	=>'Under 10',
									'U11'	=>'Under 11',
									'U12'	=>'Under 12',
									'U13'	=>'Under 13',
									'U14'	=>'Under 14',
									'U15'	=>'Under 15',
									'U16'	=>'Under 16',
									'U17'	=>'Under 17',
									'U18'	=>'Under 18',
									'U19'	=>'Under 19',
									'U21'	=>'Under 21',
									'Kids'	=>'Kids',		
									'Adults'=>'Adults'		
									);
			//echo "test"; exit;
			$this->load->view('academy_views/includes/academy_header',$data);
			$this->load->view('academy_views/view_members_list_new',$data);
			//$this->load->view('academy_views/includes/academy_right_column',$data);
			$this->load->view('academy_views/includes/academy_footer');
		}

		public function search_members()
		{
			//error_reporting(-1);
			//echo "test";
			//echo "<pre>"; echo "test"; print_r($_POST); exit;

			$data['view_type']	= 'grid';
			if($this->input->post('view_type')){
				$data['view_type']	= $this->input->post('view_type');
			}

			if($this->input->post('search_mem'))
		    {
				//echo "test1";
				$data['coach_name']		= "";
				$data['search_fname']	= $this->input->post('name');
				$data['sport']				= $this->input->post('user_sport');
				$data['level']				= $this->input->post('level');
				$data['ag_grp']			= $this->input->post('ag_grp');
				$data['sel_gend']		= $this->input->post('sel_gend');
				$data['range']			= $this->input->post('range');
				$data['stat_search']			= $this->input->post('stat_search');

				$data['lat']			    = $this->session->userdata('lat');
				$data['long']			= $this->session->userdata('long');

				$org_id					= $this->input->post('org_id');
				//echo "<pre>"; print_r($data); exit;
				//echo "pre"; exit;
				$data['query']			= $this->model_academy->search_details($data);
				//$data['results'] = $this->model_news->get_news();
				
				$data['org_details']	= $this->model_academy->get_academy_details($org_id); 

				//$data['org_details']	= $org_details; 
				//$data['results']		= $this->model_academy->get_news($org_id);
				/*$data['menu_list']		= $this->model_academy->get_menu_list();
				$data['act_menu_list']	= $this->model_academy->get_act_menu_list($org_id);*/
 
				$data['search_sport']	= $data['sport'];
				$data['sports_list']		= $this->model_academy->get_club_sports($org_id); 
				//$data['sport_levels']	= $this->model_academy->get_sport_levels($sport);
				if($data['sport']){
				$data['sport_levels']	= $this->model_academy->get_sport_levels($data['sport']);
				}

				$data['ag_grp_list'] = array(
										'U9'	=>'Under 9',
										'U10'	=>'Under 10',
										'U11'	=>'Under 11',
										'U12'	=>'Under 12',
										'U13'	=>'Under 13',
										'U14'	=>'Under 14',
										'U15'	=>'Under 15',
										'U16'	=>'Under 16',
										'U17'	=>'Under 17',
										'U18'	=>'Under 18',
										'U19'	=>'Under 19',
										'U21'	=>'Under 21',
										'Adults'=>'Adults',			
										'Kids'	=>'Kids'			
										);
//echo "<pre>"; echo "test"; print_r($data); exit;
				$this->load->view('academy_views/includes/academy_header',$data);
				$this->load->view('academy_views/view_academy_members',$data);
				//$this->load->view('academy_views/includes/academy_right_column',$data);
				$this->load->view('academy_views/includes/academy_footer');
			}
			else{
				echo "Error: Please contact admin!"; exit;
			}
		}

		public function get_sp_levels() {
			$sport			= $this->input->post('sp');
			$sport_levels	= $this->model_academy->get_sport_levels($sport);
				echo "<option value=''>Level</option>";
			foreach($sport_levels as $sp_level) {
				echo "<option value='$sp_level->SportsLevel_ID'>$sp_level->SportsLevel</option>";
			}
		}

		public function show_res() {
			$data['search_fname']	= '';
			$data['sport']			= '';
			$data['ag_grp']			= '';
			$data['range']			= '';
			$data['academy_status']	= '';

			if($this->uri->segment(3)){
				$data['search_fname']	= $this->uri->segment(3);
			}
			if($this->uri->segment(4)){
				$data['sport']	= $this->uri->segment(4);
			}
			if($this->uri->segment(5)){
				$data['ag_grp']	= $this->uri->segment(5);
			}
			if($this->uri->segment(6)){
				$data['range']	= $this->uri->segment(6);
			}
			if($this->uri->segment(7)){
				$data['org_id']	= $this->uri->segment(7);
			}
			if($this->uri->segment(8)){
				$data['academy_status']	= $this->uri->segment(8);
			}

			$data['lat']		= $this->session->userdata('lat');
			$data['long']	= $this->session->userdata('long');
			$data['query']	= $this->model_academy->search_details($data);

			$this->load->view('academy_views/view_academy_search_print',$data);
		}

		public function get_num_matches($user_id, $sport){

			$data['num_matches'] = $this->model_academy->get_num_matches($user_id, $sport);
			return $data;
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

		public function upd_membership($org_id){
//echo "<pre>"; print_r($_POST); exit;
			$uid		= $this->input->post('id');
			$mem_id	= NULL;
			$mem_code	= NULL;
			$mem_type	= NULL;
			$mem_freq	= NULL;
			$mem_sport	= NULL;
			$sdate	= NULL;
			$edate	= NULL;
			$num_occr	= NULL;

			if($this->input->post('rec_id') == '' or $this->input->post('rec_id') < 1){
				echo "Something went wrong!";
				exit;
			}
			if(!$this->is_club_admin){
				echo "Unauthorised access!";
				exit;
			}

				$rec_id = $this->input->post('rec_id');

			if($this->input->post('mem_id'))
				$mem_id = $this->input->post('mem_id');

			if($this->input->post('mem_code'))
				$mem_code = $this->input->post('mem_code');

			if($this->input->post('mem_type'))
				$mem_type = $this->input->post('mem_type');

			if($this->input->post('mem_freq'))
				$mem_freq = $this->input->post('mem_freq');

			if($this->input->post('mem_sport'))
				$mem_sport = $this->input->post('mem_sport');

			if($this->input->post('mem_start_date'))
				$sdate = date('Y-m-d', strtotime($this->input->post('mem_start_date')));

			if($this->input->post('mem_end_date'))
				$edate = date('Y-m-d', strtotime($this->input->post('mem_end_date')));

			if($this->input->post('num_occr'))
				$num_occr = $this->input->post('num_occr');

				$cur_date = date('Y-m-d');

				$mem_status = 0;
				$pay_status_admin = $this->input->post('mem_paid');
				if($this->input->post('mem_paid') == 1){
					if($cur_date <= $edate)
					$mem_status = 1;
					if($mem_code != ''){
						$get_user_id = $this->general->get_onerow('User_memberships', 'tab_id', $rec_id);
						$club_info = $this->general->get_onerow('Academy_Info', 'Aca_URL_ShortCode', $this->input->post('shortcode'));
						$academy = $club_info['Aca_ID'];
						//Send payNow links to User
							$ins_user		= $get_user_id['Users_id'];
							$mem_det	    = $this->general->get_onerow('Membership_Types', 'tab_id', $mem_code);
//echo "<pre>"; print_r($mem_det); exit;
							if($mem_det){
								$pp_data['Membership_ID']	= $mem_det['Membership_ID'];
								$pp_data['Membership_Type'] = $mem_det['Membership_Type'];
								$pp_data['Frequency'] = $mem_det['Frequency'];
								$pp_data['Frequency_Code'] = $mem_det['Frequency_Code'];
								$pp_data['Fee'] = $mem_det['Fee'];
								$pp_data['Act_Fee'] = $mem_det['ActivationFee'];

								$pp_data['User_ID'] = $ins_user;

							$ins_ot_pay_id = '';
							if($mem_det['ActivationFee'] > 0){
							$data9 = array('Club_ID' => $academy, 'User_ID' => $ins_user, 'Membership_Code' => $mem_det['Membership_ID'], 'Type' => 'OT', 'Pay_Status' => 'PAID', 'Created_On' => date('Y-m-d H:i:s'));
								
							//$ins_ot_pay_id = $this->general->insert_table_data('Membership_PaymentLinks', $data9);
							}

							$data10 = array('Club_ID' => $academy, 'User_ID' => $ins_user, 'Membership_Code' => $mem_det['Membership_ID'], 'Type' => 'SUBSCR', 'Pay_Status' => 'PAID', 'Created_On' => date('Y-m-d H:i:s'));

							//$ins_subscr_pay_id = $this->general->insert_table_data('Membership_PaymentLinks', $data10);
							$user_info = $this->general->get_onerow('Users', 'Users_ID', $ins_user);
							$club_name = $club_info['Aca_name'];
								$this->user_email_paid_subscr($user_info, $pp_data, $club_name);
								//exit;
							}
						//Send payNow links to User
					}
				
				}
				else{
					if($mem_code != ''){
						$get_user_id = $this->general->get_onerow('User_memberships', 'tab_id', $rec_id);
						$club_info = $this->general->get_onerow('Academy_Info', 'Aca_URL_ShortCode', $this->input->post('shortcode'));
						$academy = $club_info['Aca_ID'];
						//Send payNow links to User
							$ins_user		= $get_user_id['Users_id'];
							$mem_det	    = $this->general->get_onerow('Membership_Types', 'tab_id', $mem_code);
//echo "<pre>"; print_r($mem_det); exit;
							if($mem_det){
								$pp_data['Membership_ID']	= $mem_det['Membership_ID'];
								$pp_data['Membership_Type'] = $mem_det['Membership_Type'];
								$pp_data['Frequency'] = $mem_det['Frequency'];
								$pp_data['Frequency_Code'] = $mem_det['Frequency_Code'];
								$pp_data['Fee'] = $mem_det['Fee'];
								$pp_data['Act_Fee'] = $mem_det['ActivationFee'];

								$pp_data['User_ID'] = $ins_user;

							$ins_ot_pay_id = '';
							if($mem_det['ActivationFee'] > 0){
							$data9 = array('Club_ID' => $academy, 'User_ID' => $ins_user, 'Membership_Code' => $mem_det['Membership_ID'], 'Type' => 'OT', 'Pay_Status' => 'NOT PAID', 'Created_On' => date('Y-m-d H:i:s'));
								
							$ins_ot_pay_id = $this->general->insert_table_data('Membership_PaymentLinks', $data9);
							}

							$data10 = array('Club_ID' => $academy, 'User_ID' => $ins_user, 'Membership_Code' => $mem_det['Membership_ID'], 'Type' => 'SUBSCR', 'Pay_Status' => 'NOT PAID', 'Created_On' => date('Y-m-d H:i:s'), 'Occurrence' => $num_occr);

							$ins_subscr_pay_id = $this->general->insert_table_data('Membership_PaymentLinks', $data10);
							$user_info = $this->general->get_onerow('Users', 'Users_ID', $ins_user);
							$club_name = $club_info['Aca_name'];
								$this->user_email_pp_subscr($user_info, $pp_data, $ins_ot_pay_id, $ins_subscr_pay_id, $club_name);
								//exit;
							}
						//Send payNow links to User
					}
				}

				$data   = array('tab_id' => $rec_id);
				$data2 = array('StartDate' => $sdate, 
											'EndDate' => $edate, 
											'Membership_Code' => $mem_code, 
											'Membership_ID' => $mem_id, 
											'Member_type' => $mem_type, 
											'Member_freq' => $mem_freq, 
											'Related_Sport' => $mem_sport, 
											'Member_Status' => $mem_status,
											'Pay_Status'			=> $pay_status_admin
					);

//echo "<pre>"; print_r($_POST); exit;
			$upd_mem = $this->model_academy->upd_membership($data, $data2);

			if($upd_mem)
				echo 1;
			else
				echo 0;
		}

		public function get_membership($org_id){

			if($this->input->post('id')){
				$get_user_mem = $this->model_academy->get_user_membership($org_id, $this->input->post('id'));

				if($get_user_mem){
					//echo "<pre>";
					//print_r($get_user_mem);
					$get_user = $this->general->get_user($this->input->post('id'));
					$get_user_mem['user_name'] = $get_user['Firstname']." ".$get_user['Lastname'];
					//$res = array();
					echo json_encode($get_user_mem);
					/*$mem_id = $get_user_mem['Membership_ID'];
					$mem_id = $get_user_mem['Membership_ID'];
					$mem_id = $get_user_mem['Membership_ID'];
					$mem_id = $get_user_mem['Membership_ID'];*/
				}
				else
					echo 0;
			}
			else{
				echo "Invalid Request!";
			}
			

		}

		public function send_mob_notifications($org_id){
			//error_reporting(-1);
			//echo "<pre>"; print_r($_POST); exit;
			/*    [txt_notif_msg] => dfdsfsdf
					[checked_users] => ["237"]
			*/
			if(!$this->is_club_admin){
				echo "Unauthorised Access!";
				exit;
			}
			$club_details = $this->model_academy->get_academy_details($org_id);
			$message		= $this->input->post('txt_notif_msg');
			$title				= $club_details['Aca_name'];
			$sel_users		= json_decode($this->input->post('checked_users'), true);

			if($message != ""){
				$expo_ids = array();
				foreach($sel_users as $user){
					$user_expo = $this->model_academy->get_user_expo($user);
					
					if($user_expo){
						foreach($user_expo as $exp){
								$expo_ids[$exp->user_id][] = $exp->token;
						}
					}
				}
				//echo "<pre>"; print_r($expo_ids);  exit;
				$send_status = array();
				if(!empty($expo_ids)){
					$send_status = $this->send_notifs($expo_ids, $title, $message);
				}
//echo "<pre>"; print_r($send_status);  exit;
				if(!empty($send_status)){
					foreach($send_status as $user => $exp){
						foreach($exp as $token => $status){
								$send_stat = 0;
							if($status == 'ok')
								$send_stat = 1;

 // data: { [key: string]: unknown };
 // subtitle: "Test Sub-Title"| null;

							/*$json_mes = '{title: "'.$title.'",body: '.$message.',badge: null,sound: default}';*/
							$json_mes = '{"to": "'.$token.'", "title": "'.$title.'", "body": "'.$message.'", "data": {"message_content": "'.$message.'", "type": "CLUB_NOTIFICATION", "sender_user_id": '.$this->logged_user.'}}';

							$data = array(
								'Sender'		 => $this->logged_user,
								'Recipient'  => $user,
								'Club_ID'	=> $org_id,
								'Message'	=> $message,
								'Json_Message' => $json_mes,
								'Send_Status'	=> $send_stat,
								'Read_Status'	=> 0,
								'Sent_On'			=> date('Y-m-d H:i'),
								'Expo_Token'		=> $token,
								'Notif_Type'		=> 'Notification'
								);

							$this->model_academy->insert_notif($data);
						}
					}
				}
				//echo "<pre>"; print_r($send_status); exit;
				$this->member_list($org_id, $send_status);
			}
			else{
				echo "Invalid Access!";
			}
		}

		public function send_notifs($ids, $title, $message){
			$url = 'https://exp.host/--/api/v2/push/send';
			
			$send_result = array();
			if(!empty($ids)){
				foreach($ids as $user => $list){
				foreach($list as $to){
					$payload = array(
										'to'		  => $to,
										'sound' => 'default',
										'title'=> $title,
										/*'subtitle'=> 'Subtitle Club Notification',*/
										'body'	  => $message,
										);

					$curl = curl_init();

					curl_setopt_array($curl, array(
									CURLOPT_URL => $url,
									CURLOPT_RETURNTRANSFER => true,
									CURLOPT_ENCODING => "",
									CURLOPT_MAXREDIRS => 10,
									CURLOPT_TIMEOUT => 30,
									CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
									CURLOPT_CUSTOMREQUEST => "POST",
									CURLOPT_SSL_VERIFYPEER => FALSE,
									CURLOPT_POSTFIELDS => json_encode($payload),
									CURLOPT_HTTPHEADER => array(
									"Accept: application/json",
									"Accept-Encoding: gzip, deflate",
									"Content-Type: application/json",
									"cache-control: no-cache",
									"host: exp.host"
									),
									));
					//curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 1);
					$response = curl_exec($curl);
					$err = curl_error($curl);

					curl_close($curl);
					$res = json_decode($response, true);
						if($response){
							$send_result[$user][$to] = $res['data']['status'];
						}
					}
					}
					//echo "<pre>";  print_r($send_result); exit;
			}
		
			return $send_result;
			/*if ($err) {
			echo "cURL Error #:" . $err;
			} else {
			echo $response;
			}*/
		}

		public function test_notif(){
        $url = 'https://exp.host/--/api/v2/push/send';
		//$to = 'ExponentPushToken[h-wPVoEkKw6yXPMdRwHNoB]';
		//$to = 'ExponentPushToken[8EXpfpPgra85I4aGBnYpwI]';
		//$to = 'ExponentPushToken[1xhiJ9IfYlrmThSBzakZtC]';
		$to = 'ExponentPushToken[XxO5IzPU8NFAPNOuBFlwTB]';
       
	    $payload = array(
        'to' => $to,
        'sound' => 'default',
        'body' => "Hi,  <a href='https://a2msports.com'>Click to open</a>Test Message from A2M Web Test Message from A2M Web Test Message from A2M Web Test Message from A2M Web Test Message from A2M Web Test Message from A2M Web Test Message from A2M Web End",
    );

$curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_URL => "https://exp.host/--/api/v2/push/send",
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => "UTF-8",
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 30,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => "POST",
	CURLOPT_SSL_VERIFYPEER => FALSE,
  CURLOPT_POSTFIELDS => json_encode($payload),
  CURLOPT_HTTPHEADER => array(
    "Accept: application/json",
    "Accept-Encoding: gzip, deflate",
    "Content-Type: application/json",
    "cache-control: no-cache",
    "host: exp.host"
  ),
));
//curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 1);
$response = curl_exec($curl);
$err = curl_error($curl);

curl_close($curl);

if ($err) {
  echo "cURL Error #:" . $err;
} else {
  echo $response;
}
		}

	public function get_subscr_list(){
		//error_reporting(-1);
		if($this->input->post('org_id'))
			$org_id = $this->input->post('org_id');

		if($this->input->post('is_ajax')){
			$get_list = $this->model_academy->get_mem_codes($org_id);
			$output = '';
			
			if(count($get_list) > 0){
				$output .= "<option value=''>Select</option>";
				foreach($get_list as $list){
					if($list->Frequency_Code == 'O')
						$output .= "<option value='" . $list->Membership_ID . "'>" . $list->Membership_ID . ' - ' . $list->Membership_Type . ' - ' . number_format($list->Fee, 2) . "</option>";
					else
						$output .= "<option value='" . $list->Membership_ID . "'>" . $list->Membership_ID . ' - ' . $list->Membership_Type . ' - ' . $list->Frequency . ' - ' . number_format($list->Fee, 2) . "</option>";
				}
			}

			echo $output;
		}
		else
			return $this->model_academy->get_mem_codes($org_id);
	}
	
	public function subscribe($org_id){
		$org_id = $this->general->get_orgid($org_id);
		//echo $org_id; exit;
		//echo $this->input->get('c'); exit;
			if($this->input->get('c') and $this->logged_user){
				$mem_code = $this->input->get('c');
				$check_data = array('Membership_ID' => $mem_code, 'Club_ID' => $org_id, 'Status' => 1);
				$check_valid_code = $this->general->check_row_exists('Membership_Types', $check_data);
				if($check_valid_code){
						$get_mem_code  = $this->general->get_onerow('Membership_Types', 'Membership_ID', $mem_code);
						$check_data2		= array('Club_ID' => $org_id, 'User_ID' => $this->logged_user, 'Type' => 'OT', 'Pay_Status' => 'Completed');
						$check_ot_paid    = $this->general->check_row_exists('Membership_PaymentLinks', $check_data2);

						if(!$check_ot_paid and $get_mem_code['ActivationFee'] > 0){
							// create OT record

								$data9 = array('Club_ID' => $org_id, 'User_ID' => $this->logged_user, 'Membership_Code' => $get_mem_code['Membership_ID'], 'Type' => 'OT', 'Pay_Status' => 'NOT PAID', 'Created_On' => date('Y-m-d H:i:s'));
								
								$ins_ot_pay_id = $this->general->insert_table_data('Membership_PaymentLinks', $data9);
						}
							// create only subscription link
							$data10 = array('Club_ID' => $org_id, 'User_ID' => $this->logged_user, 'Membership_Code' => $get_mem_code['Membership_ID'], 'Type' => 'SUBSCR', 'Pay_Status' => 'NOT PAID', 'Created_On' => date('Y-m-d H:i:s'));

							$ins_subscr_pay_id = $this->general->insert_table_data('Membership_PaymentLinks', $data10);
						//echo "<pre>"; print_r($get_mem_code); exit;
						
						if($ins_ot_pay_id)
							$this->paypal_ot($ins_ot_pay_id);
						else
							$this->paypal_subscr($ins_subscr_pay_id);
				}
				else{
					echo "Invalid Subscription, Please check!"; exit;
				}
			}
			else{
				$data['club_memberships'] = $this->general->get_club_memberships($org_id);
				$org_details							 = $this->model_academy->get_academy_details($org_id); 
				$data['org_details']				 = $org_details; 
				$data['results']						 = $this->model_academy->get_news($org_id);
				$data['user_membership']  = $this->general->get_user_membership($org_id, $this->logged_user);

				$this->load->view('academy_views/includes/academy_header', $data);
				$this->load->view('academy_views/view_subscriptions', $data);
				$this->load->view('academy_views/includes/academy_right_column',$data);
				$this->load->view('academy_views/includes/academy_footer');
			}
		}

		public function subscribe_buy($org_id){
					$org_id = $this->general->get_orgid($org_id);

			echo "<pre>"; print_r($_POST); exit;
		}


		public function subscribe_cancel(){
			$org_id   = $this->academy_id;
			$user_id = $this->logged_user;
			$tab_id   = $_GET['d'];

			if($org_id and $user_id and $tab_id){
				$arr = array('Club_id' => $org_id, 'Users_id' =>$user_id, 'Membership_Code' => $tab_id);
				$check_mem = $this->general->check_row_exists('User_memberships', $arr);
				if($check_mem){
				$get_club = $this->general->get_onerow('Academy_Info', 'Aca_ID', $org_id);
				//echo $this->db->last_query();
				$get_user = $this->general->get_onerow('Users', 'Users_ID', $user_id);
				$get_club_admin = $this->general->get_onerow('Users', 'Users_ID', $get_club['Aca_User_id']);
				$get_mem_type  = $this->general->get_onerow('Membership_Types', 'tab_id', $tab_id);

				$data = array(
							'Username'	=> $get_user['Firstname']." ".$get_user['Lastname'],
							'ClubAdmin'	=> $get_club_admin['Firstname']." ".$get_club_admin['Lastname'],
							'ClubName'	=> $get_club['Aca_name'],
							'Membership' => $get_mem_type['Membership_Type']." - ".$get_mem_type['Membership_ID'],
							'page'				  => 'Subscription Cancel Request to Admin'
							);
				$to_email = $get_club_admin['EmailID'];
				$reply_to  = $get_user['EmailID'];
				$subject    = "Subscription Cancel Request - ".$get_club['Aca_name'];

				$s = $this->send_user_email($to_email, $reply_to, $subject, $data);
				$org_details			= $this->model_academy->get_academy_details($org_id); 
				$data['org_details']	= $org_details; 
			
				$this->load->view('academy_views/includes/academy_header', $data);
				$this->load->view('academy_views/view_membership_subscr_cancel');
				$this->load->view('academy_views/includes/academy_footer');

				}
				else{
					echo "Invalid Access!"; exit;
				}
			}
			else{
				echo "Invalid Request!"; exit;
			}
		}


		public function user_email_pp_subscr($res, $pp_data, $ot_id, $subscr_id, $club_name)
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

		public function send_user_email($email, $reply_to, $subject, $data) {
			$this->load->library('email');
			$this->email->set_newline("\r\n");
		
			$this->email->from(FROM_EMAIL, $data['club']);
			$this->email->to($email); 
			//$this->email->to("pradeepkumar.namala@gmail.com"); 
			$this->email->reply_to($reply_to);
			$this->email->subject($subject);

			$body = $this->load->view('academy_views/view_email_template.php', $data, TRUE);

			$this->email->message($body);   
			$stat = $this->email->send();
			//echo $this->email->print_debugger();
			//exit;
			return $stat;
		}

		public function user_email_paid_subscr($res, $pp_data, $club_name)
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

		public function paypal_ot($ot_pay_id){
			//echo "test"; exit;
			$get_ot	 = $this->general->get_onerow('Membership_PaymentLinks', 'tab_id', $ot_pay_id);
			$get_pay = $this->general->get_onerow('Membership_Types', 'Membership_ID', $get_ot['Membership_Code']);

			if($this->logged_user == $get_ot['User_ID'] and $get_pay){
					$this->load->library('paypal_lib');
				$get_club = $this->general->get_onerow('Academy_Info', 'Aca_ID', $get_pay['Club_ID']);
				//$paypal_id				= SANDBOX_PAYPAL_ID;
				$get_pp = ''; 
				if($get_club['Paypal_ID'])
					$get_pp = $this->general->get_pp_details($get_club['Paypal_ID']);

				if($get_pp['paypal_merch_id'])
					$paypal_id = $get_pp['paypal_merch_id'];
				else
					$paypal_id = PAYPAL_ID;

				$currency_code	= 'USD';
				//$paypalURL			= SANDBOX_PAYPAL_URL; //Sandbox PayPal api url
				$paypalURL			= PAYPAL_URL; //PayPal api url
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
				
				//$this->paypal_lib->test_paypal_auto_form();		
				$this->paypal_lib->paypal_auto_form();
			}
			else{
				echo "Invalid Access!";
			}
		}
		
	public function paypal_subscr($sub_pay_id){
			$get_subscr = $this->general->get_onerow('Membership_PaymentLinks', 'tab_id', $sub_pay_id);
			$get_pay = $this->general->get_onerow('Membership_Types', 'Membership_ID', $get_subscr['Membership_Code']);

			if($this->logged_user == $get_subscr['User_ID'] and $get_pay){
				$this->load->library('paypal_lib');

				$get_club = $this->general->get_onerow('Academy_Info', 'Aca_ID', $get_pay['Club_ID']);

				$get_pp = ''; 
				if($get_club['Paypal_ID'])
					$get_pp = $this->general->get_pp_details($get_club['Paypal_ID']);

				if($get_pp['paypal_merch_id'])
					$paypal_id = $get_pp['paypal_merch_id'];
				else
					$paypal_id = PAYPAL_ID;

//echo $paypal_id;
//exit;
				//$paypal_id				= SANDBOX_PAYPAL_ID;
				$currency_code		= 'USD';
				$paypalURL			= PAYPAL_URL; //PayPal api url
				$logo						= base_url().'images/logo.png';
				$url							= base_url().$this->uri->segment(1);

				$returnURL = $url.'/paypal/subscr_success?sub_type=subscr&amt='.$get_pay['Fee'].'&reg_user='.$get_subscr['User_ID'];

				$cancelURL = $url.'/paypal/subscr_cancel';	//payment cancel url
				$notifyURL  = $url.'/paypal/subscr_ipn';		//ipn url

				if($get_pay['Frequency_Code'] != 'O'){
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
				//echo "<pre>";
				//print_r($get_subscr);
				//exit;
					if($get_subscr['Occurrence'])
					$this->paypal_lib->add_field('srt',  $get_subscr['Occurrence']);
				$this->paypal_lib->add_field('sra', 2);
				$this->paypal_lib->add_field('item_number', $get_pay['Membership_ID']);
				$this->paypal_lib->add_field('item_name', $get_pay['Membership_ID'].'-'.$get_pay['Membership_Type']);
				$this->paypal_lib->image($logo);
				$this->paypal_lib->paypal_auto_form();
				}
				else{
				$this->paypal_lib->add_field('business', $paypal_id);
				//$this->paypal_lib->add_field('cmd', "_xclick-subscriptions");
				$this->paypal_lib->add_field('return', $returnURL);
				$this->paypal_lib->add_field('cancel_return', $cancelURL);
				$this->paypal_lib->add_field('currency_code', $currency_code);
				$this->paypal_lib->add_field('notify_url', $notifyURL);
				$this->paypal_lib->add_field('on0', $get_ot['User_ID']);
				$this->paypal_lib->add_field('custom', $get_subscr['User_ID'].'-'.$this->academy_id);
				$this->paypal_lib->add_field('item_number',  $get_pay['Membership_ID']);
				$this->paypal_lib->add_field('item_name',  $get_pay['Membership_ID'].'-'.$get_pay['Membership_Type']);
				$this->paypal_lib->add_field('amount', $get_pay['Fee']);
				$this->paypal_lib->image($logo);
				
				//$this->paypal_lib->test_paypal_auto_form();		
				$this->paypal_lib->paypal_auto_form();
				}
			}
			else{
				echo "Invalid Access!";
			}
		}


		public function paypal_subscrTemp($sub_pay_id){
			$get_subscr	 = $this->general->get_onerow('Membership_PaymentLinks', 'tab_id', $sub_pay_id);
			$get_pay = $this->general->get_onerow('Membership_Types', 'Membership_ID', $get_subscr['Membership_Code']);

			if($this->logged_user == $get_subscr['User_ID'] and $get_pay){
					$this->load->library('paypal_lib');
				$get_club = $this->general->get_onerow('Academy_Info', 'Aca_ID', $get_pay['Club_ID']);
				$get_pp = ''; 
				if($get_club['Paypal_ID'])
					$get_pp = $this->general->get_pp_details($get_club['Paypal_ID']);

				if($get_pp['paypal_merch_id'])
					$paypal_id = $get_pp['paypal_merch_id'];
				else
					$paypal_id = PAYPAL_ID;
				//echo "<pre>"; print_r($paypal_id); exit;
				$currency_code	= 'USD';
				$paypalURL			= PAYPAL_URL; //PayPal api url
				$logo						= base_url().'images/logo.png';
				$url							= base_url().$this->uri->segment(1);

				$returnURL = $url.'/paypal/subscr_success?sub_type=subscr&amt='.$pp_items['Amount'].'&reg_user='.$pp_items['User_ID'];

				$cancelURL = $url.'/paypal/subscr_cancel';	//payment cancel url
				$notifyURL  = $url.'/paypal/subscr_ipn';		//ipn url

				$this->paypal_lib->add_field('business', $paypal_id);
				//$this->paypal_lib->add_field('cmd', "_xclick-subscriptions");
				$this->paypal_lib->add_field('return', $returnURL);
				$this->paypal_lib->add_field('cancel_return', $cancelURL);
				$this->paypal_lib->add_field('currency_code', $currency_code);
				$this->paypal_lib->add_field('notify_url', $notifyURL);
				$this->paypal_lib->add_field('on0', $get_subscr['User_ID']);
				$this->paypal_lib->add_field('item_number',  $get_pay['Membership_ID']);
				$this->paypal_lib->add_field('item_name',  $get_pay['Membership_ID'].'-'.$get_pay['Membership_Type'].' - Subscription');
				$this->paypal_lib->add_field('amount', $get_pay['Fee']);
				//$this->paypal_lib->add_field('a3', $get_pay['Fee']);
				//$this->paypal_lib->add_field('t3', $get_pay['Frequency_Code']);
				//$this->paypal_lib->add_field('p3', 1);
				//$this->paypal_lib->add_field('src', 1);
				//echo "<pre>";
				//print_r($get_subscr);
				//exit;
					/*if($get_subscr['Occurrence'])
					$this->paypal_lib->add_field('srt',  $get_subscr['Occurrence']);
				$this->paypal_lib->add_field('sra', 2);
				$this->paypal_lib->add_field('item_number', $get_pay['Membership_ID']);
				$this->paypal_lib->add_field('item_name', $get_pay['Membership_ID'].'-'.$get_pay['Membership_Type']);*/
				$this->paypal_lib->image($logo);
				$this->paypal_lib->paypal_auto_form();
			}
			else{
				echo "Invalid Access!";
			}
		}

		public function club_contact_us() {
			$org_id		= $this->academy_id;
			$adm_det	= $this->model_academy->get_user($this->academy_admin);
			$org_details = $this->model_academy->get_academy_details($org_id); 
			$email			= $adm_det['EmailID'];
			$reply_to		= $this->input->post('contactus_email');
			$subject		= "Contact Message - ".$org_details['Aca_name'];

			$user_name =  $this->input->post('contactus_name');
			$user_email =  $this->input->post('contactus_email');
			$user_subj   =  $this->input->post('contactus_subject');
			$user_msg   =  $this->input->post('contactus_msg');

			if($user_name == ""){
				$this->session->set_flashdata('contact_success', 'Please provide us your name');
				redirect($this->input->post('contact_redirect')."#contact");
				exit;
			}
			else if($user_email == ""){
				$this->session->set_flashdata('contact_success', 'Please provide us your email');
				redirect($this->input->post('contact_redirect')."#contact");
				exit;
			}
			else if($user_msg == ""){
				$this->session->set_flashdata('contact_success', 'Please let us know your message');
				redirect($this->input->post('contact_redirect')."#contact");
				exit;
			}

			$data = array('name'		=> $this->input->post('contactus_name'),
								'user_email'	=> $this->input->post('contactus_email'),
								'subject'		=> $this->input->post('contactus_subject'),
								'club'				=> $org_details['Aca_name'],
								'message'		=> $this->input->post('contactus_msg'),
								'page'			=> 'Contact Us - Club');

			$data['aca_logo']			= $org_details['Aca_logo'];
			$data['aca_name']		= $org_details['Aca_name'];
			$data['aca_proxy_url']	= $org_details['A2M_Proxy_URL'];

			$send_mail = $this->send_user_email($email, $reply_to, $subject, $data);
			if($send_mail){
				$this->session->set_flashdata('contact_success', 'Your Message sent to club admin, Thank you.');
			}
			else{
				$this->session->set_flashdata('contact_success', 'Something went wrong! Please try after sometime. Thank you.');
			}

			redirect($this->input->post('contact_redirect'));
		}

		public function send_epf(){
			$org_id			= $this->academy_id;
			$adm_det		= $this->model_academy->get_user($this->academy_admin);
			$org_details = $this->model_academy->get_academy_details($org_id); 
			$email			= $adm_det['EmailID'];
			//$email		= "pradeepkumar.namala@gmail.com";
			$reply_to		= $this->input->post('mail');
			$subject		= "Elite Program Enquiry - ".$org_details['Aca_name'];


			/*if($user_name == ""){
				$this->session->set_flashdata('contact_success', 'Please provide us your name');
				redirect($this->input->post('contact_redirect')."#contact");
				exit;
			}
			else if($user_email == ""){
				$this->session->set_flashdata('contact_success', 'Please provide us your email');
				redirect($this->input->post('contact_redirect')."#contact");
				exit;
			}
			else if($user_msg == ""){
				$this->session->set_flashdata('contact_success', 'Please let us know your message');
				redirect($this->input->post('contact_redirect')."#contact");
				exit;
			}*/

				$data = array(
							'club'				=> $org_details['Aca_name'],
							'page'			=> 'Elite Program - Sreenidhi'
							);

			$data['aca_logo']			= $org_details['Aca_logo'];
			$data['aca_name']		= $org_details['Aca_name'];
			$data['aca_proxy_url']	= $org_details['A2M_Proxy_URL'];

			$data['name']		=  $this->input->post('name');
			$data['gender']		=  $this->input->post('gender');
			$data['mobile']		=  $this->input->post('mobile');
			$data['age']			=  $this->input->post('age');
			$data['user_email']	=  $this->input->post('mail');
			$data['sports']				= implode(', ', $this->input->post('sports'));
			$data['program_level']	=  $this->input->post('program_level');
			$data['message']				=  $this->input->post('notes');


			$send_mail = $this->send_user_email($email, $reply_to, $subject, $data);

			/*if($send_mail){
			$this->session->set_flashdata('contact_success', 'Your Message sent to club admin, Thank you.');
			}
			else{
			$this->session->set_flashdata('contact_success', 'Something went wrong! Please try after sometime. Thank you.');
			}
			redirect($this->input->post('contact_redirect'));*/

		}

		public function get_user_sport_intrests($user_id,$sport){	
			$Sports_Interests = $this->model_academy->get_user_sport_intrests($user_id,$sport);
			return $Sports_Interests;
		}

		public function get_membership_details($user_id){
			$membership_det = $this->model_academy->get_membership_details($user_id);
			return $membership_det;
		}

		public function get_club($org_id){
			return $this->model_academy->get_club($org_id);
		}

		public function clubs($org_id){
			$data['org_id'] = $org_id;
			$data['club_results'] = $this->model_academy->get_assoc_clubs($org_id);
			//echo "<pre>";
			//print_r($data);
			$org_details				= $this->model_academy->get_academy_details($org_id); 
			$data['sports_list']		= $this->general->get_sports(); 
			$data['org_details']		= $org_details; 

			$this->load->view('academy_views/includes/academy_header', $data);
			$this->load->view('academy_views/view_gpa_clubs', $data);
			$this->load->view('academy_views/includes/academy_footer');

		}

		public function benefits($org_id){
			$data['org_id'] = $org_id;
			//$data['club_results'] = $this->model_academy->get_assoc_clubs($org_id);

			$org_details				= $this->model_academy->get_academy_details($org_id); 
			$data['sports_list']		= $this->general->get_sports(); 
			$data['org_details']		= $org_details; 
			$data['results']				= $this->model_academy->get_news($org_id);

			$this->load->view('academy_views/includes/academy_header', $data);
			$this->load->view('academy_views/view_gpa_member_benefits', $data);
			$this->load->view('academy_views/includes/academy_right_column',$data);
			$this->load->view('academy_views/includes/academy_footer');

		}

		 public function get_username($user_id) {
			return $this->general->get_user($user_id);
		 }

		 public function get_user_a2mscore($user_id, $sport_id) {
			return $this->general->get_user_a2mscore($user_id, $sport_id);
		 }

		 public function get_gpa_ratings($email) {
			return $this->general->get_gpa_ratings($email);
		 }

		 public function page1($org_id){
			$data['org_id']			= $org_id;
			$org_details				= $this->model_academy->get_academy_details($org_id); 
			$data['sports_list']		= $this->general->get_sports(); 
			$data['org_details']		= $org_details; 

			$this->load->view('academy_views/includes/academy_header', $data);
			$this->load->view('academy_views/sreenidhi/page1.html');
			$this->load->view('academy_views/includes/academy_footer');
		 }

		 public function page2($org_id){
			$data['org_id']			= $org_id;
			$org_details				= $this->model_academy->get_academy_details($org_id); 
			$data['sports_list']		= $this->general->get_sports(); 
			$data['org_details']		= $org_details; 

			$this->load->view('academy_views/includes/academy_header', $data);
			$this->load->view('academy_views/sreenidhi/etz_plus.html');
			$this->load->view('academy_views/includes/academy_footer');
		 }

		 public function page3($org_id){
			$data['org_id']			= $org_id;
			$org_details				= $this->model_academy->get_academy_details($org_id); 
			$data['sports_list']		= $this->general->get_sports(); 
			$data['org_details']		= $org_details; 

			$this->load->view('academy_views/includes/academy_header', $data);
			$this->load->view('academy_views/sreenidhi/page3.html');
			$this->load->view('academy_views/includes/academy_footer');
		 }

		 public function page4($org_id){
			$data['org_id']			= $org_id;
			$org_details				= $this->model_academy->get_academy_details($org_id); 
			$data['sports_list']		= $this->general->get_sports(); 
			$data['org_details']		= $org_details; 

			$this->load->view('academy_views/includes/academy_header', $data);
			$this->load->view('academy_views/sreenidhi/etz-school');
			$this->load->view('academy_views/includes/academy_footer');
		 }

		 public function page5($org_id){
			$data['org_id']			= $org_id;
			$org_details				= $this->model_academy->get_academy_details($org_id); 
			$data['sports_list']		= $this->general->get_sports(); 
			$data['org_details']		= $org_details; 

			$this->load->view('academy_views/includes/academy_header', $data);
			$this->load->view('academy_views/sreenidhi/page5.html');
			$this->load->view('academy_views/includes/academy_footer');
		 }

		 public function page6($org_id){
			$data['org_id']			= $org_id;
			$org_details				= $this->model_academy->get_academy_details($org_id); 
			$data['sports_list']		= $this->general->get_sports(); 
			$data['org_details']		= $org_details; 

			$this->load->view('academy_views/includes/academy_header', $data);
			$this->load->view('academy_views/sreenidhi/page6.html');
			$this->load->view('academy_views/includes/academy_footer');
		 }

		 public function mha($org_id){
			$data['org_id']			= $org_id;
			$org_details				= $this->model_academy->get_academy_details($org_id); 
			$data['sports_list']		= $this->general->get_sports(); 
			$data['org_details']		= $org_details; 

			$this->load->view('academy_views/includes/academy_header', $data);
			$this->load->view('academy_views/sreenidhi/myhomeavatar.php');
			$this->load->view('academy_views/includes/academy_footer');
		 }

		 public function mhv($org_id){
			$data['org_id']			= $org_id;
			$org_details				= $this->model_academy->get_academy_details($org_id); 
			$data['sports_list']		= $this->general->get_sports(); 
			$data['org_details']		= $org_details; 

			$this->load->view('academy_views/includes/academy_header', $data);
			$this->load->view('academy_views/sreenidhi/myhomevihanga.php');
			$this->load->view('academy_views/includes/academy_footer');
		 }

		 public function pbl($org_id){
			$data['org_id']			= $org_id;
			$org_details				= $this->model_academy->get_academy_details($org_id); 
			$data['sports_list']	= $this->general->get_sports(); 
			$data['org_details']	= $org_details; 

			$this->load->view('academy_views/includes/academy_header', $data);
			$this->load->view('academy_views/sreenidhi/pabel_city.php');
			$this->load->view('academy_views/includes/academy_footer');
		 }

		 public function etz_primary($org_id){
			$data['org_id']			= $org_id;
			$org_details				= $this->model_academy->get_academy_details($org_id); 
			$data['sports_list']		= $this->general->get_sports(); 
			$data['org_details']		= $org_details; 

			$this->load->view('academy_views/includes/academy_header', $data);
			$this->load->view('academy_views/sreenidhi/etz-primary-school.php');
			$this->load->view('academy_views/includes/academy_footer');
		 }

		 public function etz_secondary($org_id){
			$data['org_id']			= $org_id;
			$org_details				= $this->model_academy->get_academy_details($org_id); 
			$data['sports_list']		= $this->general->get_sports(); 
			$data['org_details']		= $org_details; 

			$this->load->view('academy_views/includes/academy_header', $data);
			$this->load->view('academy_views/sreenidhi/etz-secondary-school.php');
			$this->load->view('academy_views/includes/academy_footer');
		 }

		 public function elite_prog($org_id){
			$data['org_id']			= $org_id;
			$org_details				= $this->model_academy->get_academy_details($org_id); 
			$data['sports_list']		= $this->general->get_sports(); 
			$data['org_details']		= $org_details; 

			$this->load->view('academy_views/includes/academy_header', $data);
			$this->load->view('academy_views/sreenidhi/elite_prog');
			$this->load->view('academy_views/includes/academy_footer');
		 }

		 public function virtual_training($org_id){
			$data['org_id']			= $org_id;
			$org_details				= $this->model_academy->get_academy_details($org_id); 
			$data['sports_list']		= $this->general->get_sports(); 
			$data['org_details']		= $org_details; 

			$this->load->view('academy_views/includes/academy_header', $data);
			$this->load->view('academy_views/sreenidhi/virtual_training.html');
			$this->load->view('academy_views/includes/academy_footer');
		 }

		 public function vt_basketball($org_id){
			$data['org_id']			= $org_id;
			$org_details				= $this->model_academy->get_academy_details($org_id); 
			$data['sports_list']		= $this->general->get_sports(); 
			$data['org_details']		= $org_details; 

			$this->load->view('academy_views/includes/academy_header', $data);
			$this->load->view('academy_views/sreenidhi/vt_basketball');
			$this->load->view('academy_views/includes/academy_footer');
		 }

		 public function vt_squash($org_id){
			$data['org_id']			= $org_id;
			$org_details				= $this->model_academy->get_academy_details($org_id); 
			$data['sports_list']		= $this->general->get_sports(); 
			$data['org_details']		= $org_details; 

			$this->load->view('academy_views/includes/academy_header', $data);
			$this->load->view('academy_views/sreenidhi/vt_squash');
			$this->load->view('academy_views/includes/academy_footer');
		 }

		 public function vt_tennis($org_id){
			$data['org_id']			= $org_id;
			$org_details				= $this->model_academy->get_academy_details($org_id); 
			$data['sports_list']		= $this->general->get_sports(); 
			$data['org_details']		= $org_details; 

			$this->load->view('academy_views/includes/academy_header', $data);
			$this->load->view('academy_views/sreenidhi/vt_tennis');
			$this->load->view('academy_views/includes/academy_footer');
		 }

		 public function vt_martialarts($org_id){
			$data['org_id']			= $org_id;
			$org_details				= $this->model_academy->get_academy_details($org_id); 
			$data['sports_list']		= $this->general->get_sports(); 
			$data['org_details']		= $org_details; 

			$this->load->view('academy_views/includes/academy_header', $data);
			$this->load->view('academy_views/sreenidhi/vt_martialarts');
			$this->load->view('academy_views/includes/academy_footer');
		 }

		 public function vt_chess($org_id){
			$data['org_id']			= $org_id;
			$org_details				= $this->model_academy->get_academy_details($org_id); 
			$data['sports_list']		= $this->general->get_sports(); 
			$data['org_details']		= $org_details; 

			$this->load->view('academy_views/includes/academy_header', $data);
			$this->load->view('academy_views/sreenidhi/vt_chess');
			$this->load->view('academy_views/includes/academy_footer');
		 }

		 public function vt_fitness($org_id){
			$data['org_id']			= $org_id;
			$org_details				= $this->model_academy->get_academy_details($org_id); 
			$data['sports_list']		= $this->general->get_sports(); 
			$data['org_details']		= $org_details; 

			$this->load->view('academy_views/includes/academy_header', $data);
			$this->load->view('academy_views/sreenidhi/vt_fitness');
			$this->load->view('academy_views/includes/academy_footer');
		 }

		 public function sn_about_us($org_id){
			$data['org_id']			= $org_id;
			$org_details				= $this->model_academy->get_academy_details($org_id); 
			$data['sports_list']		= $this->general->get_sports(); 
			$data['org_details']		= $org_details; 

			$this->load->view('academy_views/includes/academy_header', $data);
			$this->load->view('academy_views/sreenidhi/about_us');
			$this->load->view('academy_views/includes/academy_footer');
		 }
		
		public function get_location($ev_loc_id){
			return $this->general->get_location_name($ev_loc_id);
		}
	}