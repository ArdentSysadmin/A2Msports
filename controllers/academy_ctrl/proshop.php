<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

	class Proshop extends CI_Controller {

	public $short_code;
	public $academy_admin;
	public $logged_user;
	public $is_club_admin;
		
		public function __construct()
		{
			parent:: __construct();
			$this->load->helper('form', 'url');
			$this->load->library('form_validation');
			$this->load->library('session');		
			$this->load->model('academy_mdl/model_news');
			$this->load->model('academy_mdl/model_general', 'general');
			$this->load->model('academy_mdl/model_academy', 'model_academy');

			$this->short_code		= $this->uri->segment(1);
			$this->academy_admin	= $this->general->get_org_admin($this->short_code);
			$this->logged_user		= $this->session->userdata('users_id');

			$this->is_club_admin = 0;
			if($this->logged_user == $this->academy_admin){
			$this->is_club_admin = 1;
			}
//error_reporting(-1);
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
		  //echo $org_id;
		  $org_details				= $this->model_academy->get_academy_details($org_id); 
		  $facility_details			= $this->model_academy->get_club_facility($org_id); 
		  $data['org_id']			= $org_id;
		  $data['org_details']	= $org_details;
		  $data['facility_details']	= $facility_details;
		  
		  $this->load->view('academy_views/includes/academy_header', $data);
		  $this->load->view('academy_views/view_proshop');
		  $this->load->view('academy_views/includes/academy_footer', $data);	 	
		}

		public function add_proshop_items($org_id){

			if(!$org_id){
				echo "Something went wrong!";
				exit;
			}
			/*echo "<pre>";			print_r($_POST);			print_r($_FILES);*/

			$prod_title		    = $this->input->post('prod_title');
			$prod_price      = $this->input->post('prod_price');
			$prod_desc		= $this->input->post('prod_desc');
			$pre_proshop_items  = $this->input->post('pre_proshop_items');
			$files				    = $_FILES;
			$prod_up_img  = '';

			//foreach($lt_name as $i => $mem){
			$doc_root = $_SERVER['DOCUMENT_ROOT'];

			$filename = 'prog_img';
			if($_FILES['prog_img']['name']){
			
			$club_dir = $doc_root.'\assets\club_facility\\'.$org_id;
			
			if (!file_exists($club_dir)){
				mkdir($club_dir, 0777, true);
			}

			$club_lt_dir = $doc_root.'\assets\club_facility\\'.$org_id.'\proshop';
			//echo $club_lt_dir; exit;
			if (!file_exists($club_lt_dir)){
				mkdir($club_lt_dir, 0777, true);
			}
	/* ***************** Code to upload Tournment Image Form Starts Here. *********************** */
			$config = array(
				'upload_path'	=> $club_lt_dir,
				'allowed_types' => "gif|jpg|png|jpeg",
				'overwrite'		=> FALSE,
				'max_size'		=> "10000", // Can be set to particular file size , here it is 2 MB(2048 Kb)
				'max_height'	=> "5000",
				'max_width'	=> "8000"
				);
			
			$this->load->library('upload');
			$this->upload->initialize($config);

				if($this->upload->do_upload($filename)){
					$upd_info		 = $this->upload->data();
					$prod_up_img = $upd_info['file_name'];
				}
			}

				$new_prod[] = array(
								'title'=>$prod_title, 
								'price'=>$prod_price, 
								'desc'=>$prod_desc, 
								'img'=>$prod_up_img, 
							);

			if($pre_proshop_items != null and $pre_proshop_items != 'null'){
				$prev_arr   = json_decode($pre_proshop_items, true);
				$upd_imgs = array_merge($prev_arr, $new_prod);
				$glry_imgs = json_encode($upd_imgs);
			}
			else{
				$glry_imgs = json_encode($new_prod);
			}

			/*echo "<pre>";		print_r($revised_teams);*/
			$data['Aca_ID']					= $org_id;
			$data['Facility_ProShop']= $glry_imgs;
			$upd_details						= $this->model_academy->update_facility_pro($data); 

			redirect($this->input->post('redirect_page'));
		}

		public function delete_product($org_id){

			if(!$org_id){
				echo "Something went wrong!";
				exit;
			}
		
		$del_images  = $this->input->post('sel_images');
		$all_images   = $this->input->post('all_imgs');

		$prev_all_imgs  = json_decode($all_images, true);

		/*echo "<pre>";
			print_r($_POST);
			print_r($prev_all_imgs);
			exit;*/
		
			//$upd_imgs = array_diff($prev_all_imgs, $del_images);

			foreach($del_images as $index){
				unset($prev_all_imgs[$index]);
			}

			$data['Aca_ID'] = $org_id;

			if(!empty($prev_all_imgs)){
				$prev_all_imgs = array_values($prev_all_imgs);
				$data['Facility_ProShop']  = json_encode($prev_all_imgs);
			}
			else{
				$data['Facility_ProShop']  = NULL;
			}
			/*	echo "<pre>";
			print_r($data);
			exit;*/
			$upd_details = $this->model_academy->update_facility_pro($data); 
		}
	}
?>