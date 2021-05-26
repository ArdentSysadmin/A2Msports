<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

	class Pricing extends CI_Controller {

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
		  //echo "<pre>"; print_r($data); 
		  //$data['results'] = $this->model_news->get_news();
		  
		  $this->load->view('academy_views/includes/academy_header', $data);
		  $this->load->view('academy_views/view_pricing');
		  //$this->load->view('includes/view_right_column',$data);
		  $this->load->view('academy_views/includes/academy_footer', $data);	 	
		}


		public function update_pricing($org_id){
			/*echo $org_id; 
			echo "<pre>"; 
			print_r($_POST);
			print_r($_FILES); 
			echo $this->is_club_admin; exit;*/

//if($this->session->userdata('users_id') == $org_details['Aca_User_id']){
			
			if(!$this->is_club_admin){
				echo "Unauthorised Access!";
				exit;
			}

			$fac_prc = $this->input->post('pre_prc_file');
			$desc		 = "";

			if($this->input->post('pricing_desc'))
				$desc	= addslashes($this->input->post('pricing_desc'));

			if($_FILES['fa_pricing']['name']){
			
			$filename = 'fa_pricing';
			$doc_root = $_SERVER['DOCUMENT_ROOT'];

			$club_fac_dir = $doc_root.'\assets\club_facility\\'.$org_id;
			
			if (!file_exists($club_fac_dir)){
				mkdir($club_fac_dir, 0777, true);
			}

			$club_price_dir = $doc_root.'\assets\club_facility\\'.$org_id.'\pricing';
			//echo $club_price_dir; exit;
			if (!file_exists($club_price_dir)){
				mkdir($club_price_dir, 0777, true);
			}

	/* ***************** Code to upload Tournment Image Form Starts Here. *********************** */
			$config = array(
				'upload_path'	=> $club_price_dir,
				'allowed_types' => "pdf|doc|docx|jpg|jpeg|png",
				'overwrite'		=> FALSE,
				'max_size'		=> "10000", // Can be set to particular file size , here it is 2 MB(2048 Kb)
				'max_height'	=> "5000",
				'max_width'	=> "8000"
				);
			
			$this->load->library('upload');
			$this->upload->initialize($config);

				if($this->upload->do_upload($filename)){
					$upd_info	= $this->upload->data();
					$fac_prc		= $upd_info['file_name'];
				}
			}

			$data['aca_id'] = $org_id;
			$arr = array('src' => $fac_prc, 'desc' => $desc);

			$str = json_encode($arr);

			$data['fac_prc'] = $str;
			//echo "<pre>"; print_r($data); exit;
		    $org_details	  = $this->model_academy->update_pricing($data); 

			redirect($this->input->post('redirect_page'));
		}

		
		public function delete_glry($org_id){
			if(!$this->is_club_admin){ echo "Unauthorised Access!"; exit; }
			if(!$org_id){
				echo "Something went wrong!";
				exit;
			}
		
		$del_images  = $this->input->post('sel_images');
		$all_images   = $this->input->post('all_imgs');

		$prev_all_imgs  = json_decode($all_images, true);

			$upd_imgs = array_diff($prev_all_imgs, $del_images);

			/*echo "<pre>";
			print_r($_POST);
			print_r($this->input->post('sel_images'));
			print_r($prev_all_imgs);
			print_r($upd_imgs);
			exit;*/

			$data['Aca_ID']			   = $org_id;
			$data['Facility_Gallery']  = json_encode($upd_imgs);
			$upd_details				   = $this->model_academy->update_facility_glry_teams($data); 

		}
	}
?>