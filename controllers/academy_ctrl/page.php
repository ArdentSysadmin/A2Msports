<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

	// session_start(); 
	class page extends CI_Controller {
	
	public $short_code;
	public $academy_admin;
	public $academy_id;
	public $logged_user;
	public $is_club_admin;
	public $org_id;

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
			$this->logged_user		= $this->session->userdata('users_id');
			$this->org_id					= $this->general->get_orgid($this->short_code);

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
			$org_details			= $this->model_academy->get_academy_details($org_id); 
			$data['org_details']	= $org_details; 

			$data['creator']		= $org_details['Aca_User_id'];

			$data['menu_list']		= $this->model_academy->get_menu_list();
			$data['act_menu_list']	= $this->model_academy->get_act_menu_list($org_id);
			$data['results']		= $this->model_academy->get_news($org_id);
			$data['sport_levels']	= $this->model_academy->get_tennis_levels();

			return $data;
		}

		public function get_org_creator($org_id){
			$org_creator = $this->model_academy->get_org_creator($org_id); 
		}

		public function testpage(){
			$org_id = $this->org_id;
			$org_details			= $this->model_academy->get_academy_details($org_id);
			//echo "<pre>"; print_r($org_details); exit;
			$data['org_details']	= $org_details; 

			$data['creator']		= $org_details['Aca_User_id'];
			$data['pom_user'] 		= "";
			
			if($org_details['POM'])
			$data['pom_user'] 		= $this->model_academy->get_user($org_details['POM']);
		
			$data['menu_list']		= $this->model_academy->get_menu_list();
			$data['act_menu_list']	= $this->model_academy->get_act_menu_list($org_id);
			$data['results']		 = $this->model_academy->get_news($org_id);

			$this->load->view('academy_views/includes/academy_header', $data);
			$this->load->view('academy_views/add_page', $data);
			//$this->load->view('academy_views/includes/academy_right_column',$data);
			$this->load->view('academy_views/includes/academy_footer');
		}

		public function post_page(){
			echo "<pre>";
			print_r($_POST);

		}
	}