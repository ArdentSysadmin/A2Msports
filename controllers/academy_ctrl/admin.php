<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

	//League controller ..
	class admin extends CI_Controller {
	
	public $short_code;
	public $academy_admin;
	public $logged_user;
	public $is_club_admin;
	public $academy_id;

		public function __construct()
		{
			parent:: __construct();
			$this->load->helper('form', 'url');
			$this->load->library('form_validation');
			$this->load->library('session');

			// Load database			
			$this->load->model('academy_mdl/model_academy');
			$this->load->model('academy_mdl/model_admin', 'admin');
			$this->load->model('academy_mdl/model_general', 'general');
			$this->load->model('academy_mdl/model_news');
//echo "test"; $this->uri->segment(0); exit;
			$this->short_code			= $this->config->item('club_short_code');
			$this->academy_admin	= $this->general->get_org_admin($this->short_code);
			$this->academy_id			= $this->general->get_orgid($this->short_code);
			$this->logged_user			= $this->session->userdata('users_id');
			
			/*$this->admin_menu_items = array('0'=>'');
			if($this->logged_user != $this->academy_admin){
			$this->admin_menu_items = array('0'=>'8');
			$this->is_academy_admin = 1;*/
			$this->logged_user			= $this->session->userdata('users_id');
			$this->academy_admin	= $this->general->get_org_admin($this->short_code);

			$this->is_club_admin = 0;
			if($this->logged_user == $this->academy_admin){
			$this->is_club_admin = 1;
			}

			if(!$this->logged_user){
			$this->load->library('facebook' ,  array("appId" => FB_APPID, "secret" => FB_KEY, "redirect_url" => FB_REDIRECT ));
			//$this->load->library('facebook');
			}
			//error_reporting(-1);
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

		public function get_onerow($table, $column, $val){
			return $this->general->get_onerow($table, $column, $val);
		}

		// viewing league page ...
		public function index($org_id)
		{
			$org_details			= $this->model_academy->get_academy_details($org_id); 
			$data['org_details']	= $org_details; 

			$data['creator']		= $org_details['Users_ID'];

			//if($this->is_academy_admin){
				$this->load->view('academy_views/includes/academy_header', $data);
				$this->load->view('academy_views/view_admin_dashboard', $data);
				$this->load->view('academy_views/includes/academy_footer', $data);				
			//}
			/*else {
				echo "<h4>Unauthorized Access</h4>";
			}*/
		}

		public function menu_settings($org_id)
		{
			$org_details				= $this->model_academy->get_academy_details($org_id); 
			$data['org_details']	= $org_details; 
			$data['creator']			= $org_details['Users_ID'];
			$data['club_menu_all']		= $this->model_academy->get_menu_all_items(); 
			$data['club_menu_show']	= $this->model_academy->get_menu_show_items($org_id); 
			$data['facility_details']		= $this->model_academy->get_club_facility($org_id); 
			$data['testim_details']		= $this->model_academy->get_club_testimonials($org_id); 

			//if($this->is_academy_admin){
				$this->load->view('academy_views/includes/academy_header', $data);
				$this->load->view('academy_views/view_menu_settings', $data);
				$this->load->view('academy_views/includes/academy_footer', $data);				
			//}
			/*else {
				echo "<h4>Unauthorized Access</h4>";
			}*/
		}

		public function update_menu($org_id){
			//echo "<pre>";
			//print_r($_POST);
			if($this->academy_admin != $this->logged_user){
				echo "Unauthorised Access!"; exit;
			}

		    $club_menu			= $this->input->post('club_menu_items');
		    $menu_all_items = json_decode($this->input->post('menu_all_items'), TRUE);
			$non_selected_items = array_diff($menu_all_items, $club_menu);
/*echo "<pre>";
print_r($menu_all_items);
print_r($club_menu);
print_r($non_selected_items);
exit;*/
			if(!empty($club_menu)){
				$json_menu = json_encode($non_selected_items);
				//echo $json_menu; 
				$upd_menu = $this->model_academy->update_menu($json_menu, $org_id);
				//echo $this->config->item('club_short_code'); exit;
				redirect($this->short_code . '/settings');
			}
			else{
				echo "Menu items should not be empty!"; 
				exit;				
			}
		}
		
		public function show_forms(){
			$org_id = $this->academy_id;
			$get_forms	= $this->general->get_onerow('Academy_Pages', 'Aca_ID', $org_id);
		    $org_details	= $this->model_academy->get_academy_details($org_id); 
			  $data['org_id']			= $org_id;
			  $data['org_details']	= $org_details;

			  $data['forms'] = array();
			if($get_forms['Academy_Forms'])
				$data['forms'] = json_decode($get_forms['Academy_Forms'], true);

			  $this->load->view('academy_views/includes/academy_header', $data);
			  $this->load->view('academy_views/view_club_forms', $data);
			  //$this->load->view('includes/view_right_column',$data);
			  $this->load->view('academy_views/includes/academy_footer', $data);	 
		}

		public function update_forms(){
			if($this->academy_admin != $this->logged_user){
				echo "Unauthorised Access!"; exit;
			}
			else{
				$org_id = $this->academy_id;
				//echo "<pre>"; print_r($_FILES); exit;
			if($_FILES['terms_cond']['name'] != ''){

				$filename		 = 'terms_cond';
				$doc_root		 = $_SERVER['DOCUMENT_ROOT'];
				$club_fac_dir = $doc_root.'\assets\club_facility\\'.$org_id;
				
				if (!file_exists($club_fac_dir)){ mkdir($club_fac_dir, 0777, true); 	}
				$club_forms_dir = $doc_root.'\assets\club_facility\\'.$org_id.'\forms';
				if (!file_exists($club_forms_dir)){ mkdir($club_forms_dir, 0777, true); }
				
				if($this->input->post('terms_cond_prev'))
				unlink($doc_root.'\assets\club_facility\\'.$org_id.'\forms\\'.$this->input->post('terms_cond_prev'));
				/* ***************** Code to upload Tournment Image Form Starts Here. *********************** */
				$config = array(
					'upload_path'	 => $club_forms_dir,
					'allowed_types' => "pdf|doc|docx",
					'overwrite'		=> FALSE,
					'max_size'		=> "10000", // Can be set to particular file size , here it is 2 MB(2048 Kb)
					'max_height'	=> "5000",
					'max_width'	=> "8000"
					);
				
				$this->load->library('upload');
				$this->upload->initialize($config);

					if($this->upload->do_upload($filename)){
						$upd_info		 = $this->upload->data();
						$terms_cond	 = $upd_info['file_name'];
					}
				}
				else{
					$terms_cond = $this->input->post('terms_cond_prev');
				}

				if($_FILES['priv_polic']['name'] != ''){
				$filename		 = 'priv_polic';
				$doc_root		 = $_SERVER['DOCUMENT_ROOT'];
				$club_fac_dir = $doc_root.'\assets\club_facility\\'.$org_id;
				
				if (!file_exists($club_fac_dir)){ mkdir($club_fac_dir, 0777, true); 	}
				$club_forms_dir = $doc_root.'\assets\club_facility\\'.$org_id.'\forms';
				if (!file_exists($club_forms_dir)){ mkdir($club_forms_dir, 0777, true); }

				//if($this->input->post('terms_cond_prev'))
				//unlink($doc_root.'\assets\club_facility\\'.$org_id.'\forms\\'.$this->input->post('terms_cond_prev'));

				/* ***************** Code to upload Tournment Image Form Starts Here. *********************** */
				$config = array(
					'upload_path'	 => $club_forms_dir,
					'allowed_types' => "pdf|doc|docx",
					'overwrite'		=> FALSE,
					'max_size'		=> "10000", // Can be set to particular file size , here it is 2 MB(2048 Kb)
					'max_height'	=> "5000",
					'max_width'	=> "8000"
					);
				
				$this->load->library('upload');
				$this->upload->initialize($config);

					if($this->upload->do_upload($filename)){
						$upd_info		 = $this->upload->data();
						$priv_polic	 = $upd_info['file_name'];
					}
				}
				else{
					$priv_polic = $this->input->post('priv_polic_prev');
				}

				if($_FILES['waiver_form']['name'] != ''){
				$filename		 = 'waiver_form';
				$doc_root		 = $_SERVER['DOCUMENT_ROOT'];
				$club_fac_dir = $doc_root.'\assets\club_facility\\'.$org_id;
				
				if (!file_exists($club_fac_dir)){ mkdir($club_fac_dir, 0777, true); 	}
				$club_forms_dir = $doc_root.'\assets\club_facility\\'.$org_id.'\forms';
				if (!file_exists($club_forms_dir)){ mkdir($club_forms_dir, 0777, true); }

				/* ***************** Code to upload Tournment Image Form Starts Here. *********************** */
				$config = array(
					'upload_path'	 => $club_forms_dir,
					'allowed_types' => "pdf|doc|docx",
					'overwrite'		=> FALSE,
					'max_size'		=> "10000", // Can be set to particular file size , here it is 2 MB(2048 Kb)
					'max_height'	=> "5000",
					'max_width'	=> "8000"
					);
				
				$this->load->library('upload');
				$this->upload->initialize($config);

					if($this->upload->do_upload($filename)){
						$upd_info		 = $this->upload->data();
						$waiver_form	 = $upd_info['file_name'];
					}
				}
				else{
					$waiver_form = $this->input->post('waiver_form_prev');
				}

			$forms_arr['terms_cond']  = $terms_cond;
			$forms_arr['priv_polic']	   = $priv_polic;
			$forms_arr['waiver_form'] = $waiver_form;

			$forms_arr_json = json_encode($forms_arr);

			$data['Aca_ID'] = $org_id;
			$data2['Academy_Forms'] = $forms_arr_json;
			//echo "<pre>"; print_r($data); print_r($data2); exit;
		    $org_details	  = $this->model_academy->update_forms($data, $data2);
			redirect($this->input->post('redirect_page'));
			}

		}
		public function memberships($org_id){
			$data			 = $this->get_org_details($org_id);
			$user_id		 = $this->session->userdata('users_id');

			if($data['creator'] != $user_id){ 
				echo "Unauthorised Access!"; 
				exit; 
			}

			$data['club_memberships'] = $this->admin->get_club_memberships($org_id);
			//$data['club_sports'] = $this->general->get_club_sports($org_id);

			$this->load->view("academy_views/includes/academy_header", $data);
			$this->load->view('academy_views/view_memberships', $data);
			$this->load->view("academy_views/includes/academy_footer");

		}

		public function get_club_menu($org_id){
			$get_menu = $this->general->get_club_menu($org_id);
			$club_menu = array();

			if($get_menu)
				$club_menu = json_decode($get_menu['Active_Menu_Ids'], TRUE);

			return $club_menu;
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
		
		public function update_message(){
			$mes		= $this->input->post('alert_message');
			$org_id	= $this->academy_id;
			if(trim($mes) != ''){
				$data   = array('Aca_ID' => $org_id);
				$data2 = array('Alert_Message' => $mes);
				$upd_mes = $this->model_academy->insert_update_aca_pages($data, $data2);
				if($upd_mes)
					redirect($this->input->post('redirect_page'));
				else
					echo "Something went wrong, please contact admin!"; 
			}
		}
		
		public function add_testimonial(){
			//echo "<pre>"; print_r($_POST); print_r($_FILES); exit;
			if($this->logged_user != $this->academy_admin){
				echo "Unauthorised Access!"; exit;
			}

			$testim_msg		= $data['testimonial'] = $this->input->post('testim_message');
			$testim_by			= $data['user_name'] =  $this->input->post('testim_by');
			$club_id				= $data['club_id'] =  $this->academy_id;
			$added_on		= $data['added_on'] =  date('Y-m-d H:i:s');
			$added_by			= $data['added_by'] =  $this->logged_user;
			$status				= $data['status']		 =  1;

			if($_FILES['testim_by_img']['name']){

			$filename = 'testim_by_img';
			$doc_root = $_SERVER['DOCUMENT_ROOT'];
			$club_fac_dir = $doc_root.'\assets\club_facility\\'.$club_id;

			if (!file_exists($club_fac_dir)){
			mkdir($club_fac_dir, 0777, true);
			}

			$club_testim_dir = $doc_root.'\assets\club_facility\\'.$club_id.'\testimonial_users';
			//echo $club_lt_dir; exit;
			if (!file_exists($club_testim_dir)){
			mkdir($club_testim_dir, 0777, true);
			}

			/* ***************** Code to upload Tournment Image Form Starts Here. *********************** */
			$config = array(
			'upload_path'	=> $club_testim_dir,
			'allowed_types' => "gif|jpg|png|jpeg",
			'overwrite'		=> FALSE,
			'max_size'		=> "10000", // Can be set to particular file size , here it is 2 MB(2048 Kb)
			'max_height'	=> "5000",
			'max_width'	=> "8000"
			);

			$this->load->library('upload');
			$this->upload->initialize($config);

			if($this->upload->do_upload($filename)){
				$this->load->library('image_lib');

			$upd_info		    = $this->upload->data();
			//echo "<pre>"; print_r($upd_info); exit;
			$data['user_img'] = $upd_info['file_name'];
				
				if($upd_info['image_width'] > 200 and $upd_info['image_height'] > 200){
							$configer =  array(
									  'image_library'	 => 'gd2',
									  'source_image'    =>  $upd_info['full_path'],
									  'maintain_ratio'  =>  FALSE,
									  'width'           =>  170,
									  'height'          =>  170
									  //'quality'		 =>  100
									);
				$this->image_lib->clear();
				$this->image_lib->initialize($configer);
				$this->image_lib->resize();
				}
			}
			}

			$ins = $this->admin->insert_testimonial($data); 

			if($ins)
				redirect($this->input->post('redirect_page'));
			else
				echo "Something went wrong, please contact admin!"; 
		}
		
		public function new_profile()
		{
			$this->load->view('includes/header');
			$this->load->view('view_add_profile');
			$this->load->view('includes/footer');
		}

		public function get_name($user_id)
		{
			return $this->model_admin->get_name($user_id);
		}

		public function ajax_users($sport = '',$country = '',$state='')
		{
			$sport = $this->input->post('spt');
			$country = $this->input->post('country');
			$state = $this->input->post('state');

			$data['users'] = "";
			$data['sport'] = $sport;
			$data['country'] = $country;
			$data['state'] = $state;
			//print_r($data);
			//exit;
			
			$data['users'] = $this->model_admin->get_ajax_users($data);
			$this->load->view('view_admin_ajax_users',$data);
			
		
		}

		public function send_email()
		{
		  
		  if($this->input->post('admin_email')){

			  $this->load->library('email');
			  $this->email->set_newline("\r\n");
			  
			  $subject = $this->input->post('subject');

			  $sub = ($subject != "") ? $subject : "Message from A2MSports Admin";

			  $mes = $this->input->post('description');

			  foreach($this->input->post('sel_player') as $user_id)
			  {

			    $sql = "SELECT * FROM users WHERE Users_ID = " .$user_id;
				$result = $this->db->query($sql);
				$row = $result->row();

				$this->email->from('admin@a2msports.com', ' A2mSports');
				$this->email->to($row->EmailID);
				
				$this->email->subject($sub);

				$data = array(
					 'firstname'=> $row->Firstname,
					 'lastname'=> $row->Lastname,
					 'mes'=> $mes,
					 'page'=> 'Admin Notification'
					);

				$body = $this->load->view('view_email_template.php',$data,TRUE);

				$this->email->message($body);   

				$this->email->send();

			  }
			  $data['success'] = "Message to users sent successfully.";
			   $this->index($data);
		   }
		}

		public function update_pom(){
			$data = array('user' => $this->input->post('txt_ac_pom_id'));
			$upd_pom = $this->model_admin->update_pom($data);
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
		
		public function check_membership_type($mem_type='', $org_id=''){
			if($this->input->post('mtype'))
				$mem_type = $this->input->post('mtype');
			if($this->input->post('org_id'))
				$org_id = $this->input->post('org_id');

			$stat = $this->admin->check_membership_type($mem_type, $org_id);
			echo $stat;
		}

		public function check_membership_id($mem_id='', $org_id=''){
			if($this->input->post('mem_id'))
				$mem_id = strtoupper($this->input->post('mem_id'));
			if($this->input->post('org_id'))
				$org_id = $this->input->post('org_id');

			$stat = $this->admin->check_membership_id($mem_id, $org_id);
			echo $stat;
		}

		public function add_memberships($org_id){
			
			if($this->logged_user != $this->academy_admin){
				echo "Unauthorised Access!";
				exit;
			}

			if($this->input->post('submit_membership')){
				//echo "<pre>"; print_r($_POST); exit;

				switch($this->input->post('frequency')){
					case "O":
						$freq_type = "OneTimeCharge";
					break;
					case "D":
						$freq_type = "Daily";
					break;
					case "W":
						$freq_type = "Weekly";
					break;
					case "M":
						$freq_type = "Monthly";
					break;
					case "Y":
						$freq_type = "Yearly";
					break;
					default:
						$freq_type = NULL;
					break;
				}

					$data['Membership_ID']		 = strtoupper($this->input->post('membership_id'));
					$data['Membership_Type'] = $this->input->post('membership_type');
					$data['Club_ID']				  = $org_id;
					$data['Sport_Type']			  = $this->input->post('sport_type');
					$data['Frequency']			  = $freq_type;
					$data['Frequency_Code'] = $this->input->post('frequency');
					$data['ActivationFee']			  = $this->input->post('membership_acc_fee');
					$data['Fee']					= $this->input->post('membership_fee');
					$data['Status']				= 1;
					$data['CreatedOn']		= date('Y-m-d H:i:s');
					$data['LastUpdated']	= date('Y-m-d H:i:s');
					$exp_date = NULL;
					if($this->input->post('expire_date') != '')
						$exp_date = date('Y-m-d H:i:s', strtotime($this->input->post('expire_date')));

					$data['Expire_Date']			= $exp_date;

					//echo "<pre>"; print_r($data); exit;
					$ins_data = $this->admin->add_memberships($data);
			
					if($ins_data)
						redirect($this->short_code.'/memberships');
					else
						echo "Something went wrong, please contact Admin!";
					exit;
			}
			else{
				echo "Invalid Access!";
				exit;
			}

		}

		public function upd_memberships($org_id){
			
			if($this->logged_user != $this->academy_admin){
				echo "Unauthorized Access!";
				exit;
			}

			if($this->input->post('submit_edit_membership')){

			if($this->input->post('tab_row_id') == ''){
				echo "Invalid Data!"; 
				exit;
			}
				//echo "<pre>"; print_r($_POST); exit;
			$tab_id = $this->input->post('tab_row_id');

				switch($this->input->post('upd_frequency')){
					case "O":
						$freq_type = "OneTimeCharge";
					break;
					case "D":
						$freq_type = "Daily";
					break;
					case "W":
						$freq_type = "Weekly";
					break;
					case "M":
						$freq_type = "Monthly";
					break;
					case "Y":
						$freq_type = "Yearly";
					break;
					default:
						$freq_type = NULL;
					break;
				}

					//$data['Membership_ID']		 = strtoupper($this->input->post('upd_membership_id'));
					$data['Membership_Type'] = $this->input->post('upd_membership_type');
					$data['Club_ID']				  = $org_id;
					$data['Sport_Type']			  = $this->input->post('upd_sport_type');
					$data['Frequency']			  = $freq_type;
					$data['Frequency_Code'] = $this->input->post('upd_frequency');
					$data['Fee']							= $this->input->post('upd_membership_fee');
					$data['ActivationFee']			= $this->input->post('upd_membership_acc_fee');
					$data['Status']						= $this->input->post('upd_membership_status');
					//$data['Occurrence']				= $this->input->post('num_occr');
					$data['LastUpdated']			= date('Y-m-d H:i:s');
					$exp_date = NULL;
					if($this->input->post('expire_date') != '')
						$exp_date = date('Y-m-d H:i:s', strtotime($this->input->post('expire_date')));

					$data['Expire_Date']			= $exp_date;
					//echo "<pre>"; print_r($data); exit;
					$ins_data = $this->admin->upd_memberships($data, $tab_id);
			
					if($ins_data)
						redirect($this->short_code.'/memberships');
					else
						echo "Something went wrong, please contact Admin!";
					exit;
			}
			else{
				echo "Invalid Access!";
				exit;
			}

		}

		public function get_membership_det(){
			$tab_id				= $this->input->post('tab_id');
			$mem_details	= $this->admin->get_membership_det($tab_id);
			echo json_encode(array_values($mem_details));
		}

		public function get_testim(){
			$tab_id = $this->input->post('id');
				$data['det']	= $this->admin->get_testim($tab_id);			
				//echo "<pre>"; print_r($data);
				$this->load->view('academy_views/view_edit_testim_section', $data);
		}

		public function delete_testim(){
			$tab_id = $this->input->post('id');
			if($this->academy_admin == $this->logged_user and $tab_id){
				$del	= $this->admin->del_testim($tab_id);			
				echo "Success";
			}
			else{
				echo "Invalid Access!";
			}
		}

		public function update_testim(){
			$tab_id = $this->input->post('testim_id');
			$club_id	 =  $this->academy_id;

			if($this->academy_admin == $this->logged_user and $tab_id){

			if($_FILES['testim_by_img']['name']){

			$filename = 'testim_by_img';
			$doc_root = $_SERVER['DOCUMENT_ROOT'];
			$club_fac_dir = $doc_root.'\assets\club_facility\\'.$club_id;

			if (!file_exists($club_fac_dir)){
			mkdir($club_fac_dir, 0777, true);
			}

			$club_testim_dir = $doc_root.'\assets\club_facility\\'.$club_id.'\testimonial_users';
			//echo $club_lt_dir; exit;
			if (!file_exists($club_testim_dir)){
			mkdir($club_testim_dir, 0777, true);
			}

			/* ***************** Code to upload Tournment Image Form Starts Here. *********************** */
			$config = array(
			'upload_path'	=> $club_testim_dir,
			'allowed_types' => "gif|jpg|png|jpeg",
			'overwrite'		=> FALSE,
			'max_size'		=> "10000", // Can be set to particular file size , here it is 2 MB(2048 Kb)
			'max_height'	=> "5000",
			'max_width'	=> "8000"
			);

			$this->load->library('upload');
			$this->upload->initialize($config);

			if($this->upload->do_upload($filename)){
				$this->load->library('image_lib');

			$upd_info		    = $this->upload->data();
			//echo "<pre>"; print_r($upd_info); exit;
			$data['user_img'] = $upd_info['file_name'];
				
				if($upd_info['image_width'] > 200 and $upd_info['image_height'] > 200){
							$configer =  array(
									  'image_library'	 => 'gd2',
									  'source_image'    =>  $upd_info['full_path'],
									  'maintain_ratio'  =>  FALSE,
									  'width'           =>  170,
									  'height'          =>  170
									  //'quality'		 =>  100
									);
				$this->image_lib->clear();
				$this->image_lib->initialize($configer);
				$this->image_lib->resize();
				}
			}
			}
			else{
			$data['user_img'] = $this->input->post('prev_user_img');
			}
			$data['user_name'] = $this->input->post('testim_by');
			$data['testimonial'] = $this->input->post('testim_message');

				$upd	= $this->admin->upd_testim($tab_id, $data);			
			if($upd)
				redirect($this->input->post('redirect_page'));
			else
				echo "Something went wrong, please contact admin!"; 

			}
			else{
				echo "Invalid Access!";
			}
		}

		public function swtich_layout(){
			$club_id = $this->academy_id;
			$layout   = $this->input->post('swt');
			if($this->academy_admin == $this->logged_user){
				$data				 = array('Home_Layout' => $layout);
				$upd_academy = $this->admin->upd_club_layout($club_id, $data);
				echo $upd_academy;
			}
			else{
				echo 0;
			}

		}

	}