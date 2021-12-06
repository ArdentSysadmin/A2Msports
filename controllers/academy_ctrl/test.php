<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
//error_reporting(-1);

	//League controller ..
	class Test extends CI_Controller {

	public $logged_user;
	public $org_id;
	public $short_code;
	public $academy_admin;

		public function __construct()
		{
			parent:: __construct();
			//$this->load->model('model_general', 'general');
			$this->load->model('academy_mdl/model_academy', 'model_academy');
			$this->load->model('academy_mdl/model_general', 'general');

			$this->load->helper(array('form', 'url'));
			$this->load->library('session');

			$this->logged_user	= $this->session->userdata('users_id');
			$this->short_code    = $this->uri->segment(1);
			$this->org_id			= $this->general->get_orgid($this->short_code);
			$this->academy_admin = $this->general->get_org_admin($this->short_code);
			$det = $this->general->check_is_member($this->org_id, $this->logged_user);
			$this->is_club_member = ($det['tab_id']) ? 1 : 0;
			
			$this->admin_menu_items = array('0'=>'');
			if($this->logged_user != $this->academy_admin)
			$this->admin_menu_items = array('0'=>'8');

			if($this->logged_user != 237 and $this->logged_user != 240){
				echo "Unauthorised Access!";
				if($this->logged_user)
				echo "<a href='/logout'><h3>Logout & Login</h3></a>";
				else
				echo "<a href='/login'><h3>Login</h3></a>";
				exit;
			}
		}
		
		// viewing league page ...
		public function index($tid='')
		{
			$this->CI =&get_instance();
        $dbobject1 = $this->CI->load->database('default',TRUE);
if(FALSE === $dbobject1->conn_id)
{
  echo 'No connection established!';
}
else{
	echo 'Successfully connected';
}
//echo "<pre>";
//print_r($dbobject1);
			//echo "Teams";
			if(!class_exists("model_general")){
				echo "test";
			}		
	    }

	public function test_timez(){
		$x = date('Z');
		echo  date('Y-m-d H:i:s Z');
		echo "<br>".$x/3600;
		//echo gmdate(DATE_W3C);
	}

	public function server_vars(){
		echo "<pre><h1>Session Info</h1><br>"; 
		//$_SESSION['test_name']	= 'Hamid';

		$this->session->set_userdata('test_name', 'Moni');
		echo( $_SESSION['test_name'] );
		print_r($this->session);
		echo "<br>--------------------------------------------------------<h1>Server Info</h1><br>";
		//print_r($_SERVER);
		echo "<br>--------------------------------------------------------<h1>Globals Info</h1><br>";
		//print_r($GLOBALS);
	}

		public function rewrite_routes(){

$short_code = 'pradeep';  $club_id='999';

$data = './application/config/routes.php';	// it is the path of the text files 
//$show = file_get_contents($data);			// here $data is called for fetching the files message

$txt  = "\n".'$route["'.$short_code.'"] = "academy_ctrl/academy/details/'.$club_id.'";';
$txt .= "\n".'$route["'.$short_code.'/admin"]	 = "academy_ctrl/admin/'.$club_id.'";';

$txt .= "\n".'$route["'.$short_code.'/courts/reserve"] = "academy_ctrl/courts/reserve/'.$club_id.'";';
$txt .= "\n".'$route["'.$short_code.'/courts/reserve/(:any)"] = "academy_ctrl/courts/reserve/'.$club_id.'";';
$txt .= "\n".'$route["'.$short_code.'/courts/list"] = "academy_ctrl/courts/courts_list/'.$club_id.'";';
$txt .= "\n".'$route["'.$short_code.'/courts/add"] = "academy_ctrl/courts/add_court/'.$club_id.'";';
$txt .= "\n".'$route["'.$short_code.'/courts/update"] = "academy_ctrl/courts/update_court/'.$club_id.'";';
$txt .= "\n".'$route["'.$short_code.'/courts/get_loc_courts"] = "academy_ctrl/courts/get_loc_courts";';
$txt .= "\n".'$route["'.$short_code.'/courts/get_loc_info"]	  = "academy_ctrl/courts/get_loc_info";';
$txt .= "\n".'$route["'.$short_code.'/courts/get_court_reservations"]   = "academy_ctrl/courts/get_court_reservations";';
$txt .= "\n".'$route["'.$short_code.'/courts/get_reserve_popup"]   = "academy_ctrl/courts/get_reserve_popup";';
$txt .= "\n".'$route["'.$short_code.'/courts/get_court_durations"]   = "academy_ctrl/courts/get_court_durations";';
$txt .= "\n".'$route["'.$short_code.'/courts/check_court_availability"]	= "academy_ctrl/courts/check_court_availability";';
$txt .= "\n".'$route["'.$short_code.'/courts/block_court"]	  = "academy_ctrl/courts/block_court";';
$txt .= "\n".'$route["'.$short_code.'/courts/paypal_success"]	  = "academy_ctrl/courts/paypal_success";';
$txt .= "\n".'$route["'.$short_code.'/courts/paypal_cancel"]	  = "academy_ctrl/courts/paypal_cancel";';

$txt .= "\n".'$route["'.$short_code.'/league"]				  = "league/index";';
$txt .= "\n".'$route["'.$short_code.'/league/(:num)"]		  = "academy_ctrl/league/'.$club_id.'";';
$txt .= "\n".'$route["'.$short_code.'/league/create_trnmt"]	  = "academy_ctrl/league/create_trnmt/'.$club_id.'";';
$txt .= "\n".'$route["'.$short_code.'/league/register_match/(:num)"] = "league/register_match/$1/'.$club_id.'";';

$txt .= "\n".'$route["'.$short_code.'/league/(:num)"]				= "league/viewtournament/$1";';
$txt .= "\n".'$route["'.$short_code.'/league/(:num)/(:num)"] = "league/viewtournament/$1";';
$txt .= "\n".'$route["'.$short_code.'/league/view_matches"]	  = "academy_ctrl/league/view_matches/'.$club_id.'";';
$txt .= "\n".'$route["'.$short_code.'/league/fixtures/(:num)"] = "academy_ctrl/league/fixtures/$1/'.$club_id.'";';
$txt .= "\n".'$route["'.$short_code.'/league/bracket/(:num)"]  = "academy_ctrl/league/bracket/$1/'.$club_id.'";';
$txt .= "\n".'$route["'.$short_code.'/league/bracket_save"]	  = "academy_ctrl/league/bracket_save/'.$club_id.'";';
$txt .= "\n".'$route["'.$short_code.'/league/send_email_reg_players"] = "academy_ctrl/league/send_email_reg_players";';
$txt .= "\n".'$route["'.$short_code.'/league/upload_pics"]	  = "academy_ctrl/league/upload_pics";';
$txt .= "\n".'$route["'.$short_code.'/league/get_gallery"]	  = "academy_ctrl/league/get_gallery";';
$txt .= "\n".'$route["'.$short_code.'/league/buy/(:num)"]	  = "academy_ctrl/league/buy/$1/'.$club_id.'";';
$txt .= "\n".'$route["'.$short_code.'/league/uprofile"]		  = "academy_ctrl/league/uprofile/'.$club_id.'";';
$txt .= "\n".'$route["'.$short_code.'/league/get_tour_fee/"]	  = "academy_ctrl/league/get_tour_fee/'.$club_id.'";';

$txt .= "\n".'$route["'.$short_code.'/events/create"]					 = "academy_ctrl/events/create/'.$club_id.'";';
$txt .= "\n".'$route["'.$short_code.'/facility"]		  					 = "academy_ctrl/facility/index/'.$club_id.'";';
$txt .= "\n".'$route["'.$short_code.'/facility/update_facility"]		 = "academy_ctrl/facility/update_facility/'.$club_id.'";';
$txt .= "\n".'$route["'.$short_code.'/facility/update_lt_team"]	 = "academy_ctrl/facility/update_lt_team/'.$club_id.'";';
$txt .= "\n".'$route["'.$short_code.'/facility/update_ps_team"]	 = "academy_ctrl/facility/update_ps_team/'.$club_id.'";';
$txt .= "\n".'$route["'.$short_code.'/facility/add_glry_images"]	 = "academy_ctrl/facility/add_glry_images/'.$club_id.'";';
$txt .= "\n".'$route["'.$short_code.'/facility/delete_glry"]			 = "academy_ctrl/facility/delete_glry/'.$club_id.'";';

$txt .= "\n".'$route["'.$short_code.'/proshop"]		  				 = "academy_ctrl/proshop/index/'.$club_id.'";';
$txt .= "\n".'$route["'.$short_code.'/proshop/add_proshop_items"]	 = "academy_ctrl/proshop/add_proshop_items/'.$club_id.'";';
$txt .= "\n".'$route["'.$short_code.'/proshop/delete_product"]	 = "academy_ctrl/proshop/delete_product/'.$club_id.'";';

$txt .= "\n".'$route["'.$short_code.'/teams/addnew"]					= "academy_ctrl/teams/addnew/'.$club_id.'";';
$txt .= "\n".'$route["'.$short_code.'/teams/get_tour_reg_team"]	= "academy_ctrl/teams/get_tour_reg_team/'.$club_id.'";';

$txt .= "\n".'$route["'.$short_code.'/paypal/success"]  = "academy_ctrl/paypal/success";';
$txt .= "\n".'$route["'.$short_code.'/paypal/cancel"]   = "academy_ctrl/paypal/cancel";';

$txt .= "\n".'$route["'.$short_code.'/viewbracket"]	   = "academy_ctrl/league/viewbracket/'.$club_id.'";';

$txt .= "\n".'$route["'.$short_code.'/coaches"]				 = "academy_ctrl/academy/coaches_list/'.$club_id.'";';
$txt .= "\n".'$route["'.$short_code.'/search_coaches"]		 = "academy_ctrl/academy/search_coaches";';
$txt .= "\n".'$route["'.$short_code.'/members"]				 = "academy_ctrl/academy/member_list/'.$club_id.'";';
$txt .= "\n".'$route["'.$short_code.'/search_member"]		 = "academy_ctrl/academy/players";';
$txt .= "\n".'$route["'.$short_code.'/search_members"]		 = "academy_ctrl/academy/search_members";';
$txt .= "\n".'$route["'.$short_code.'/search/autocomplete"]	 = "academy_ctrl/search/autocomplete";';

$txt .= "\n".'$route["'.$short_code.'/show_res/(:any)"]	 = "academy_ctrl/academy/show_res/'.$club_id.'/$1";';

$txt .= "\n".'$route["'.$short_code.'/calendar"]					 = "academy_ctrl/calendar/index/'.$club_id.'";';
$txt .= "\n".'$route["'.$short_code.'/calendar/process/(:num)"]	 = "academy_ctrl/calendar/process/$1";';

$txt .= "\n".'$route["'.$short_code.'/opponent"]			 = "academy_ctrl/opponent/index/'.$club_id.'";';
$txt .= "\n".'$route["'.$short_code.'/opponent/create"]	 = "academy_ctrl/opponent/create/'.$club_id.'";';

$txt .= "\n".'$route["'.$short_code.'/play/reg_players/(:num)"]	= "academy_ctrl/play/reg_players/$1/'.$club_id.'";';
$txt .= "\n".'$route["'.$short_code.'/play/invite/(:num)"]		= "academy_ctrl/play/invite/$1/'.$club_id.'";';
$txt .= "\n".'$route["'.$short_code.'/play/invite_email"]		= "academy_ctrl/play/invite_email/'.$club_id.'";';

$txt .= "\n".'$route["'.$short_code.'/events/add"]			 = "academy_ctrl/events/add/'.$club_id.'";';
$txt .= "\n".'$route["'.$short_code.'/events/view/(:num)/(:num)"] = "academy_ctrl/events/view/$1/$1/'.$club_id.'";';
$txt .= "\n".'$route["'.$short_code.'/events/view/(:num)"]	 = "academy_ctrl/events/view/$1/'.$club_id.'";';
$txt .= "\n".'$route["'.$short_code.'/events"]			  = "academy_ctrl/events/index/'.$club_id.'";';
$txt .= "\n".'$route["'.$short_code.'/events"]			  = "academy_ctrl/events/index/'.$club_id.'";';
$txt .= "\n".'$route["'.$short_code.'/events/autocomplete"]	 = "academy_ctrl/events/autocomplete/'.$club_id.'";';
$txt .= "\n".'$route["'.$short_code.'/events/add_fields"]		 = "academy_ctrl/events/add_fields/'.$club_id.'";';
$txt .= "\n".'$route["'.$short_code.'/events/add_fields_weekly"]	 = "academy_ctrl/events/add_fields_weekly/'.$club_id.'";';

$txt .= "\n".'$route["'.$short_code.'/news"]				 = "academy_ctrl/news/index";';
$txt .= "\n".'$route["'.$short_code.'/news/add"]			 = "academy_ctrl/news/add";';
$txt .= "\n".'$route["'.$short_code.'/news/add_news"]		 = "academy_ctrl/news/add_news";';
$txt .= "\n".'$route["'.$short_code.'/news/edit/(:num)"]	 = "academy_ctrl/news/edit/$1";';
$txt .= "\n".'$route["'.$short_code.'/news/view/(:num)"]	 = "academy_ctrl/news/get_news_detail/$1";';
$txt .= "\n".'$route["'.$short_code.'/news/update/(:num)"]= "academy_ctrl/news/update_news/$1";';

$txt .= "\n".'$route["'.$short_code.'/update_menu"]		 = "academy_ctrl/academy/update_act_menu/'.$club_id.'";';
$txt .= "\n"."/**********************************************************************************/";

//echo $txt;
//exit;
			 $myfile = file_put_contents($data, $txt.PHP_EOL , FILE_APPEND | LOCK_EX);
			 //echo $show;
		}

		public function php_inf(){
			echo phpinfo();
		}


		public function check_db(){

			$serverName = "S198-12-249-197\A2MSPORTS"; //serverName\instanceName
			$connectionInfo = array( "Database"=>"a2msports", "UID"=>"sa", "PWD"=>"Hd8%*GE2Li");
			$conn = sqlsrv_connect( $serverName, $connectionInfo);

			if( $conn ) {
				 echo "Connection established.<br />";
			}else{
				 echo "Connection could not be established.<br />";
				 echo "<pre>";
				 die( print_r( sqlsrv_errors(), true));
			}
	
			
		}
	/*
	<metals>
<AED>
<gold>
<bid>213.38925460577</bid>
<ask>213.50734429792</ask>
</gold>
<silver>
<bid>2.2814928522717</bid>
<ask>2.2933018214864</ask>
</silver>
<platinum>
<bid>97.193721121235</bid>
<ask>98.374618042701</ask>
</platinum>
<palladium>
<bid>225.43794589549</bid>
<ask>240.19915741381</ask>
</palladium>
*/
		public function comm(){

			//$feed_url = "http://metal-feed.ignitewoo.com/api.php?key=IGN-9d024a6a-1f42-495c-884e-7445fd27f7ca";	
			//$xml = simplexml_load_file($feed_url);

			/*echo "Gold&nbsp;&nbsp;&nbsp;".$xml->USD->gold->ask."<br>";
			echo "Silver &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$xml->USD->silver->ask."<br>";
			echo "Platinum&nbsp;&nbsp;".$xml->USD->platinum->ask."<br>";
			echo "Palladium&nbsp;&nbsp;".$xml->USD->palladium->ask."<br>";*/

		}

		public function a2m_backup_update(){
			
			$res = $this->general->get_users_a2m();
			$count = 0;

			foreach($res as $i => $a2m){
				if($a2m->Backup_A2MScores)
					$prev_a2m		= json_decode($a2m->Backup_A2MScores, true);

				$md						 = date('m-Y', strtotime('-1 month', time()));
				$prev_a2m[$md]  = $a2m->A2MScore;

				$upd_a2m = json_encode($prev_a2m);
				$upd_id		= $a2m->A2MScore_ID;

				$upd = $this->general->update_a2m_backup($upd_id, $upd_a2m);

				if($upd){
					$count++;
				}

				/*echo $a2m->Users_ID. " - " .$a2m->A2MScore;
				echo json_encode($prev_a2m);
				echo "<br>";*/
				//exit;
			}
			echo "Total updated Users ({$count})";
		}

		public function alp($text){
			echo "<pre>";
			print_r($_SERVER);
			exit;

			if (preg_match('/[A-Za-z].*[0-9]|[0-9].*[A-Za-z]/', $text))
			{
				echo "Alphanumeric";
			}
			else
			{
				echo "Non alphanumeric";
			}
		}

		public function a2m_team_score_update(){

			$res = $this->general->get_teams();

			foreach($res as $i => $team){
				//$this->general->update_a2m_teamscore($team);
			}
		}

		public function a2m_score_update(){

			//$res = $this->general->a2mscore_doubles_update();

		}

		public function test_send_email(){
			$user_email = 'pradeepkumar.namala@gmail.com';
			$subj		= 'Testing 123';
			$page		= 'Test-Email';
			$message	= "Test body message";

			$data = array(
			 'firstname'=> 'N ',
			 'lastname'	=> 'Pradeep ',
			 'title'	=> 'test title',
			 'tourn_id' => '111',
			 'mes'		=> $message,
			 'tadmin'	=> 'Test',
			 'page'		=> $page
			);
			$this->load->library('email');
			$this->email->clear();
			$this->email->set_newline("\r\n");
			$this->email->set_crlf("\r\n");
			$this->email->from(FROM_EMAIL, 'A2M Sports');
			$this->email->to($user_email);
			$this->email->subject($subj);

			$body = $this->load->view('view_email_template', $data);
			$this->email->message($body);
			$s_email = $this->email->send();

			if($s_email){ 
				echo "Success<br/>";
			}
			else{ 
				echo $this->email->print_debugger();
				echo "Fail<br/>";
			}
		}

		public function merge_aca_clubs(){
		
		echo "Expired!";
		exit;

			$get_academy = $this->general->get_academy();
			//$get_academy = $this->general->get_academy_temp();

			foreach($get_academy as $aca){

			$data = array(
					'Aca_name'	=> $aca['Org_name'],
					'Aca_addr1' => $aca['Org_address'],
					'Aca_city'	=> $aca['Org_city'],
					'Aca_state' => $aca['Org_state'],
					'Aca_country'		=> $aca['Org_country'],
					'Aca_contact_phone' => $aca['Org_phone'],
					'Aca_sport'			=> json_encode(array("{$aca['primary_sport']}")),
					'Aca_User_id'		=> $aca['Users_ID'],
					'Aca_logo'			=> $aca['Org_logo'],
					'Aca_URL_ShortCode' => $aca['Url_Shortcode'],
					'POM'				=> $aca['POM']
					);

			$aca_new_id = $this->general->ins_academy_info($data);
			
			$upd_menu = $this->general->update_menu($aca_new_id, $aca['Org_ID']);

			$get_academy_users = $this->general->get_academy_users($aca['Org_ID']);
			$u = 0;
			if($get_academy_users){
				
				foreach($get_academy_users as $usr){
				$data = array(
						'Club_id'  => $aca_new_id,
						'Users_id' => $usr['Users_id'],
						'Membership_ID' => $usr['Membership_ID'],
						'Member_Status' => $usr['Member_Status'],
						'Related_Sport' => $usr['Related_Sport']
						);

				$migrate_users = $this->general->migrate_aca_users($data);
				$u++;
				}
			}

				echo $aca['Org_name']. "(".$aca_new_id.") - ".$u."<br>";
			}

		}

		public function update_geo(){
			//Longitude,Latitude,Zipcode

			$get_users = $this->general->get_missing_geo_users();
			
				$i = 1;
			foreach($get_users as $user){

				if($i == 25)
				break;

				$zipcode = $user->Zipcode;
			
				if($zipcode > 0){
					$res = $this->get_geo_loc($zipcode);
					$upd = $this->general->update_user_geo($user->Users_ID, $res);
					
					if($upd){
						echo $i." ".$user->Users_ID." ".$res['latitude']." ".$res['longitude']."<br>";
					}
					$i++;
				}
			}


		}

		public function get_geo_loc($zipcode){

			$geocodeFromAddr = file_get_contents("https://maps.googleapis.com/maps/api/geocode/json?address=".$zipcode."&key=".GEO_LOC_KEY);

			$output1 = json_decode($geocodeFromAddr);
	
			//Get latitude and longitute from json data
			$result = array('latitude'  => $output1->results[0]->geometry->location->lat,
							'longitude' => $output1->results[0]->geometry->location->lng);


			return $result;
		}

		public function slides(){
			//$this->load->view('slides');
		}
		
		public function srv_name(){
			echo "<pre>";
			print_r($_SERVER);
			//echo "<br>".$_SERVER['HTTP_REFERER'];
		}

		public function phInfo(){
			echo phpinfo();
		}

		public function pp_subscr(){
			//error_reporting(-1);

			if($this->input->post('submit_pp')){
							$this->load->library('paypal_lib');

				//echo "<pre>"; print_r($_POST); exit;
				$paypal_id = SANDBOX_PAYPAL_ID;
				$currency_code = 'USD';
				$paypalURL = SANDBOX_PAYPAL_URL; //PayPal api url
//echo $paypalURL; exit;
				$logo = base_url().'images/logo.png';

				$returnURL = base_url().'paypal/test_success?sub_type='.$this->input->post('pp_t3').'&amt='.$this->input->post('pp_a3').'&reg_user='.$this->input->post('user_name');

				$cancelURL = base_url().'paypal/test_cancel';		//payment cancel url
				$notifyURL  = base_url().'paypal/test_ipn';			//ipn url

				$this->paypal_lib->add_field('business', $paypal_id);
				$this->paypal_lib->add_field('cmd', "_xclick-subscriptions");
				$this->paypal_lib->add_field('return', $returnURL);
				$this->paypal_lib->add_field('cancel_return', $cancelURL);
				$this->paypal_lib->add_field('currency_code', $currency_code);
				$this->paypal_lib->add_field('notify_url', $notifyURL);
				//$this->paypal_lib->add_field('tourn_id', $tid);
				//$this->paypal_lib->add_field('player', $this->logged_user);
				$this->paypal_lib->add_field('on0', $this->logged_user);
				$this->paypal_lib->add_field('a3',  $this->input->post('pp_a3'));
				$this->paypal_lib->add_field('t3',  $this->input->post('pp_t3'));
				$this->paypal_lib->add_field('p3',  1);
				$this->paypal_lib->add_field('src',  1);
				//$this->paypal_lib->add_field('srt',  10);
				$this->paypal_lib->add_field('sra',  2);
				$this->paypal_lib->add_field('item_number',  123);
				$this->paypal_lib->add_field('item_name',  'pp subscription');

				//$this->paypal_lib->add_field('amount', $this->input->post('pp_a3'));        
				$this->paypal_lib->image($logo);
				
				$this->paypal_lib->test_paypal_auto_form();

			}
			else{
				echo $this->load->view('view_pp_subscr');
			}

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

		public function get_club_menu($org_id){
			$get_menu = $this->general->get_club_menu($org_id);
			$club_menu = array();

			if($get_menu)
				$club_menu = json_decode($get_menu['Active_Menu_Ids'], TRUE);
			return $club_menu;
		}


		public function custom_page(){

			if($this->input->post('save_page')){
				$cont = $this->input->post('editor1');
				$this->general->put_page($cont);
			}

			$get_page	 = $this->general->get_page();
			$data			 = $this->get_org_details($this->org_id);
			$data['page'] = $get_page;
			$this->load->view('academy_views/includes/academy_header', $data);
			$this->load->view('academy_views/view_custom_page', $data);
			$this->load->view('academy_views/includes/academy_footer', $data);
		}
		
		public function sess_test(){
		print_r($this->session->userdata);
		}

// ----------------------

		public function test_form(){
			$this->load->view('academy_views/test_form');
		}

		public function sess_store(){
			session_start();
			
			$_SESSION['temp_name'] = $this->input->post('test_name');
			
			$temp = array('temp_name' => $this->input->post('test_name'));
			
			$this->session->set_userdata($temp);
			
			//echo "PHP Session = ";
			
			//print_r($_SESSION['temp_name']);
			
			echo "<br>Codeigniter Session = ";
			
			print_r($this->session->userdata('temp_name'));

			print_r($this->session);
			
			//print_r( $_COOKIE );
			
			echo "<br><br><a href='/test/check_sess'>Click to Next page</a>";
		}

		public function check_sess(){
			session_start();
			
			echo "Session in next page <br> <br>PHP Session = ";
			print_r($_SESSION['temp_name']);
			echo "<br>Codeigniter Session = ";
			print_r($this->session->userdata('temp_name'));
			print_r($this->session);
			//print_r( $_COOKIE );

		}

}