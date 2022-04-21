<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

//Classes controller ..
class classes extends CI_Controller {

	public $header_tpl		= "academy_views/includes/academy_header";
	public $right_col_tpl		= "academy_views/includes/academy_right_column";
	public $footer_tpl			= "academy_views/includes/academy_footer";

	public $logged_user;
	public $short_code;
	public $academy_admin;

	public function __construct()
	{
		parent:: __construct();

		$this->load->helper(array('form', 'url'));
		
		// Load session library
		$this->load->library('session');
		/*if(!$this->session->userdata('user')){
			redirect('login');
		}*/

		$this->load->model('academy_mdl/model_classes', 'model_classes');
		$this->load->model('academy_mdl/model_general', 'general');
		$this->load->model('academy_mdl/model_news', 'model_news');
		$this->load->model('academy_mdl/model_academy', 'model_academy');

		$this->short_code				= $this->uri->segment(1);
		$this->academy_admin	= $this->general->get_org_admin($this->short_code);
		$this->academy_id			= $this->general->get_orgid($this->short_code);
		$this->logged_user			= $this->session->userdata('users_id');

		$this->admin_menu_items = array('0'=>'');
		 if($this->logged_user != $this->academy_admin)
		$this->admin_menu_items = array('0'=>'8');

			if(!$this->logged_user){
			$this->load->library('facebook' ,  array("appId" => FB_APPID, "secret" => FB_KEY, "redirect_url" => FB_REDIRECT));
			}
		}
		
		public function get_fb_login(){
			$login  = $this->facebook->getLoginUrl();
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

	public function index($org_id)
	{
		/*$url_seg = $this->uri->segment(1); 
		$last_url = array('redirect_to'=>$url_seg);
		$this->session->set_userdata($last_url);*/
		//$data = $this->get_org_details($org_id);
			$org_details			= $this->model_academy->get_academy_details($org_id);
			//echo "<pre>"; print_r($org_details); exit;
			$data['org_details']	= $org_details; 

			$data['creator']		= $org_details['Aca_User_id'];
			$data['pom_user'] 		= "";
			
		if($org_details['POM'])
		$data['pom_user'] 		= $this->model_academy->get_user($org_details['POM']);

	//echo "<pre>"; print_r($data); exit;
		$data['event_types']		= $this->model_classes->get_event_types();
		//$data['club_leagues']	= $this->model_academy->get_club_tournments($data['creator']);
		$data['club_event_classes']		= $this->model_academy->get_event_classes($data['creator']);

		$data['results']				= $this->model_news->get_news();
	//echo "<pre>"; print_r($data['club_event_classes']); exit;

		$this->load->view($this->header_tpl, $data);
		$this->load->view('academy_views/view_classes_list',  $data);
		//$this->load->view('includes/view_right_column',$data);
		$this->load->view($this->footer_tpl);
	}


	public function get_sport($sport_id){
		return $this->model_classes->get_sport_title($sport_id);
	}

	public function get_location($ev_loc_id){
		return $this->general->get_location_name($ev_loc_id);
	}

}