<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

error_reporting(0);

	//League controller ..
	class Test extends CI_Controller {

	public $logged_user;

		public function __construct()
		{
			parent:: __construct();
			$this->load->model('model_general', 'general');
			$this->load->model('model_league');
			$this->load->helper(array('form', 'url'));
			$this->load->library('session');
//echo $this->uri->segment(2);
//exit;
			$this->logged_user = $this->session->userdata('users_id');
			//if($this->uri->segment(2) != 'php_inf'){
				if($this->logged_user != 237 and $this->logged_user != 240){
					echo "Unauthorised Access!";
					if($this->logged_user)
					echo "<a href='/logout'><h3>Logout & Login</h3></a>";
					else
					echo "<a href='/login'><h3>Login</h3></a>";
					exit;
				}
			//}
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
echo "<pre>";
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
		echo "<pre>"; 
		print_r($_SERVER);
		echo "--------------------------------------------------------";
		print_r($GLOBALS);
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
			//print_r($_SERVER);
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
			$user_email = 'rajnikar.bandari@fintinc.com, sunil@fintinc.com, pradeep.namala@fintinc.com';
			$subj		= 'Testing 15032021';
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
			$this->load->library('email_test');
			$this->email_test->clear();
			$this->email_test->set_newline("\r\n");
			$this->email_test->set_crlf("\r\n");
			$this->email_test->from(TEST_FINT_EMAIL, 'Fint Solutions');
			$this->email_test->to($user_email);
			$this->email_test->subject($subj);

			//$body = $this->load->view('view_email_template', $data);
			$body = "Testing";
			$this->email_test->message($body);
			$s_email = $this->email_test->send();

			if($s_email){ 
				echo "Success<br/>";
			}
			else{ 
				echo $this->email_test->print_debugger();
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
			//echo "<pre>";
			//print_r($_SERVER);
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

		public function duplicate_a2m(){
			$get_users = $this->general->get_all_users();
			foreach($get_users as $user){
				$get_a2m = $this->general->get_a2m_user($user->Users_ID);
					$user_a2m_sports = array();
					echo $user->Users_ID."------------------<br />";
					foreach($get_a2m as $a2m){
						if(in_array($a2m->SportsType_ID, $user_a2m_sports)){
							echo "Del ".$a2m->A2MScore_ID." ".$a2m->SportsType_ID."<br>";
							//$this->general->del_a2m_user($a2m->A2MScore_ID);
						}
						else{
						$user_a2m_sports[] = $a2m->SportsType_ID;
						}
					}
					echo " --------------------------- <br />";
			}
		}

		public function insert_user_a2m(){
			$sport = 2;
			$users_arr = array(5819,5892,5891,5897,5817,6082,5926,6155,5887,6225,6238,6313,6314,6315,6320);
			$count = 0;
			foreach($users_arr as $user){
				$data = array('Users_ID' => $user, 'SportsType_ID' => 2, 'A2MScore' => 100, 'A2MScore_Doubles' => 100, 'A2MScore_Mixed' => 100);
				$ins = $this->general->insert_table_data('A2MScore', $data);
				if($ins) $count++;
			}
			echo "Total Inserted = ".$count;
		}

		public function delete_dup_a2m(){
			//$sports = array(1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18);
			//foreach($sports as $sp){
				$get_users = $this->general->get_users();
				$count = 0;
				foreach($get_users as $user){
						$user_id = $user->Users_ID;

						$get_a2m = $this->general->get_a2m_user($user_id);
						$uniq_sp_a2m = array();
						$dup_sp_a2m = array();
						foreach($get_a2m as $user_a2m){
								if(!in_array($user_a2m->SportsType_ID, $uniq_sp_a2m)){
									$uniq_sp_a2m[] = $user_a2m->SportsType_ID;
								}
								else{
									$dup_sp_a2m[] = $user_a2m->A2MScore_ID;
								}
						}

						if(!empty($dup_sp_a2m)){
							echo $user_id."-------<br>";
							//print_r($dup_sp_a2m);
							//echo "-------<br>";
							foreach($dup_sp_a2m as $del){
								//$del_a2m = $this->general->del_a2m_user($del);
								echo $del."<br>";
								$count++;
							}
						}

				}
					if($count == 0){
						echo "No Duplicates Found!";
					}
			//}
		}

		public function insert_sp_intrests() {
			$get_tourns = $this->general->get_tournaments();
			$validated_users = array();
			foreach($get_tourns as $tourn) {
				$tid = $tourn->tournament_ID;
				
				if($tourn->tournament_format == 'Individual') {
				$get_reg_users =  $this->general->get_tourn_reg_users($tid);
					foreach($get_reg_users as $users) {
						$user_id = $users->Users_ID;

						if(!in_array($user_id, $validated_users)){
							$get_sp_int = $this->general->is_user_having_spint($user_id, $tourn->SportsType);
							if(count($get_sp_int) == 0){
								$data = array('users_id' => $user_id, 'Sport_id' => $tourn->SportsType);
								//$ins_sp = $this->general->insert_table_data('Sports_Interests', $data);
								$ins_users[] = $user_id;
							}
						}
						$validated_users[] = $user_id;
					}
				}
			}
			echo "<pre>"; print_r($ins_users);
		}

		public function phone_login(){

$this->load->view('login');
		}

		public function check_phone(){
			//echo "<pre>"; print_r($_REQUEST);
			$email			= $_REQUEST['email'];
			$provider	= $_REQUEST['provider'];
			$username = $_REQUEST['username'];
			$token			= $_REQUEST['token'];

		$exp	= explode('.', $token);
		$arr		= json_decode(base64_decode($exp[1]), true);

		echo "<pre>"; print_r($arr); exit;

			$curl = curl_init();

			curl_setopt_array($curl, array(
				CURLOPT_URL => "https://identitytoolkit.googleapis.com/v1/accounts:lookup?key=AIzaSyCmVrLhO1Wo69C-GjfNEGAL-taGq__TrDU&idToken=" . $token,
				CURLOPT_RETURNTRANSFER => true,
				CURLOPT_ENCODING => "",
				CURLOPT_MAXREDIRS => 10,
				CURLOPT_TIMEOUT => 0,
				CURLOPT_FOLLOWLOCATION => true,
				CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
				CURLOPT_CUSTOMREQUEST => "POST",
				CURLOPT_HTTPHEADER => array(
					"Content-length:0"
				)
			));

			$response = curl_exec($curl);
			curl_close($curl);
			echo "testing 123<br>";
			echo $response;
print_r($response);
			$array_response = json_decode($response, true);
			print_r($array_response);
		}

		public function upd_tt_a2m(){
			$get_a2m = $this->general->get_a2m_sport('2');
			//echo count($get_a2m)."<br>";
			foreach($get_a2m as $a2m_res){
				//echo $a2m_res->Users_ID." - ".$a2m_res->A2MScore."-".$a2m_res->A2MScore_Doubles."-".$a2m_res->A2MScore_Mixed."<br>";
				$row_id = $a2m_res->A2MScore_ID;
				$user_a2m		   = $a2m_res->A2MScore;
				$user_a2m_db = $a2m_res->A2MScore_Doubles;
				$user_a2m_mx = $a2m_res->A2MScore_Mixed;

				if($a2m_res->A2MScore == 100){
					$upd_a2m = 800; $upd_db_a2m = 800; $upd_mx_a2m = 800; 
				}
				else if($a2m_res->A2MScore < 100){
					$upd_a2m = $user_a2m + 800; 
					$upd_db_a2m = $user_a2m_db + 800; 
					$upd_mx_a2m = $user_a2m_mx + 800; 
				}
				else if($a2m_res->A2MScore > 100){
					$upd_a2m = $user_a2m + 1000; 
					$upd_db_a2m = $user_a2m_db + 1000; 
					$upd_mx_a2m = $user_a2m_mx + 1000; 
				}
				if($upd_a2m){
					$data = array('A2MScore' => $upd_a2m,'A2MScore_Doubles' => $upd_db_a2m,
						'A2MScore_Mixed' => $upd_mx_a2m);
					//$upd_a2m = $this->general->upd_tt_a2m($row_id, $data);
				}
				else{
					echo "F ".$row_id."<br>";
				}
			}
		}

		public function upd_ut_ratings_user_a2m(){
			$query = "select * from User_memberships um JOIN USATTMembership ut on um.Membership_ID = ut.Member_ID where um.Club_id = 139";
			$get_res = $this->general->get_query_res($query);

			foreach($get_res as $res){
				$user_id = $res->Users_id;
				$rating		= $res->Rating;

				//$this->general->upd_user_a2m_usatt($user_id, $rating);
			}

		}

		public function test_st(){

$arr = Array
        (
            [6330] => Array
                (
                    ['fname'] => 'Robert',
                     ['lname'] => 'Jones',
                     ['played'] => 3,
                     ['won'] => 1,
                     ['lost'] => 2,
                     ['points_for'] => 9,
                     ['points_against'] => 22,
                     ['win_per'] => 33.33,
                     ['score_diff'] => -13,
                     ['sd_mp'] => -4.33,
                     ['sd_mp_win_per'] => 29.00
                ),

            [6333] => Array
                (
                     ['fname'] => 'Brian',
                     ['lname'] => 'Wesnofske',
                     ['played'] => 3,
                     ['won'] => 1,
                     ['lost'] => 2,
                     ['points_for'] => 9,
                     ['points_against'] => 22,
                     ['win_per'] => 33.33,
                     ['score_diff'] => -13,
                     ['sd_mp'] => -4.33,
                     ['sd_mp_win_per'] => 29.00
                ),

            [6332] => Array
                (
                     ['fname'] => 'Scott',
                     ['lname'] => 'Wood',
                     ['played'] => 5,
                     ['won'] => 5,
                     ['lost'] => 0,
                     ['points_for'] => 78,
                     ['points_against'] => 34,
                     ['win_per'] => 100.00,
                     ['score_diff'] => 44,
                     ['sd_mp'] => 8.80,
                     ['sd_mp_win_per'] => 108.80
                )
        );

uasort($arr, function($a,$b){
    return strcmp($a['win_per'], $b['win_per']);
});
print_r($arr);

		}

		public function test_insert_init_rating(){
			$user_id = 237;
			$tourn_id = 2386;
			$bracket_id = 1447;

			$this->model_league->insert_init_rating2($user_id, $tourn_id, $bracket_id);

		}

		public function correction_in_gpa_a2m(){
			//$this->general->correction_in_gpa_a2m();
		}

		public function upd_tbl(){
$this->general->upd_tbl();

		}



//this function is for handling post call requests
public function make_post_call($url, $postdata) {
    global $token;
	//$token = get_access_token($url,$postArgs); //works and returns a valid access token
    $curl = curl_init($url); 
    curl_setopt($curl, CURLOPT_POST, true);
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, true);
    curl_setopt($curl, CURLOPT_SSLVERSION , 6);
    curl_setopt($curl, CURLOPT_HEADER, false);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_HTTPHEADER, array(
                'Authorization: Bearer '.$token,
                'Accept: application/json',
                'Content-Type: application/json'
                ));

    curl_setopt($curl, CURLOPT_POSTFIELDS, $postdata); 
    $response = curl_exec( $curl );
    print_r($response); //IM NOW RECEIVING OUTPUT, however symbols are now being replaced by placeholders such as '%40', how can i prevent this?
    if (empty($response)) {
        die(curl_error($curl)); //close due to error
        curl_close($curl); 
    } else {
        $info = curl_getinfo($curl);
        echo "Time took: " . $info['total_time']*1000 . "ms\n";
        curl_close($curl); // close cURL handler
        if($info['http_code'] != 200 && $info['http_code'] != 201 ) {
            echo "Received error: " . $info['http_code']. "\n";
            echo "Raw response:".$response."\n";
            die();
        }
    }
    // Convert the result from JSON format to a PHP array 
    $jsonResponse = json_decode($response, TRUE);
    return $jsonResponse;
}

		public function get_paypal_info(){

//$token = get_access_token($url,$postArgs); //works and returns a valid access token

//This is the URL for the call
$url = 'https://api-3t.sandbox.paypal.com/nvp';

//This is the data to be sent in the call 
$postdata = array(
'USER' => 'admin_api1.a2msports.com', 
'PWD' => '728KLXR5QWS9URBW', 
'SIGNATURE' => 'ADfSJQMOTfIywNttfIXyG-eEEiNwAdDynxyQeY.Pg.mMmpioaCUsSEuZ', 
'METHOD' => 'GetTransactionDetails', 
'VERSION' => '123', 
'TransactionID' => '7CL87153CJ6684029'
);

$postdata = http_build_query($postdata); 
//$postdata = json_encode($postdata); //Is this the correct way of formatting? 

$transactionInfo = $this->make_post_call($url, $postdata); //get transaction details NOT WORKING

print_r($transactionInfo); //does not print anything


		}

public function get_transaction_details($trans_id) { 
    $api_request = 'USER=' . urlencode( 'admin_api1.a2msports.com' )
                .  '&PWD=' . urlencode( '728KLXR5QWS9URBW' )
                .  '&SIGNATURE=' . urlencode( 'ADfSJQMOTfIywNttfIXyG-eEEiNwAdDynxyQeY.Pg.mMmpioaCUsSEuZ' )
                .  '&VERSION=76.0'
                .  '&METHOD=GetTransactionDetails'
                .  '&TransactionID=' . $trans_id;

    $ch = curl_init();
    curl_setopt( $ch, CURLOPT_URL, 'https://api-3t.paypal.com/nvp' ); // For live transactions, change to 'https://api-3t.paypal.com/nvp'
    curl_setopt( $ch, CURLOPT_VERBOSE, 1 );

    // Uncomment these to turn off server and peer verification
     curl_setopt( $ch, CURLOPT_SSL_VERIFYPEER, FALSE );
    // curl_setopt( $ch, CURLOPT_SSL_VERIFYHOST, FALSE );
    curl_setopt( $ch, CURLOPT_RETURNTRANSFER, 1 );
    curl_setopt( $ch, CURLOPT_POST, 1 );

    // Set the API parameters for this transaction
    curl_setopt( $ch, CURLOPT_POSTFIELDS, $api_request );

    // Request response from PayPal
    $response = curl_exec( $ch );
    // print_r($response);

    // If no response was received from PayPal there is no point parsing the response
    if( ! $response )
        die( 'Calling PayPal to change_subscription_status failed: ' . curl_error( $ch ) . '(' . curl_errno( $ch ) . ')' );

    curl_close( $ch );

    // An associative array is more usable than a parameter string
    parse_str( $response, $parsed_response );

echo "<pre>"; print_r($parsed_response);
	}

	public function test_se($tourn_id=''){
error_reporting(0);
?>
		<html>
		<head><title>Processing Draws...</title>
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<script>
			window.onload = function(){
			//document.forms['se_auto_form'].submit();
			document.getElementById('bracket_confirm').click();
			}
		</script>
		</head>
		<body style="text-align:center;">
		<p style="text-align:center;">Please wait, your order is being processed and you will be redirected to the paypal website.</p>
		
		<form method="post" action='<?php echo base_url(); ?>league/bracket_save' name="se_auto_form">
<?php
		$num_players = 4;
		$teams = array('','','','');
		$num_teams = $num_players;
$pow_vals  = array(2,4,8,16,32,64,128,256,512);
$seed_team = $teams;

$log_val = ceil(log($num_teams, 2));
((in_array($log_val, $pow_vals)) or (in_array($num_teams, $pow_vals))) ? $total_rounds = $log_val : $total_rounds =  floor(log($num_teams, 2)) + 1;

$match_num = 1;

for($round = 1, $source=1 ; $round <= $total_rounds; $round++) {
?>
<input type='hidden' name='round[]' value="<?php echo $round; ?>" />
<?php
$process_res = $this->cal_c($pow_vals, $num_teams, $teams, $round);
$teams = array();

$rt = $process_res[1] + $process_res[2];
//-------------------------
//echo "<pre>"; print_r($process_res);
$x=0;
foreach($process_res[6] as $ab => $game_pl){
$is_bye = 0;
?>
<input type='hidden' name="match_num[<?php echo $round; ?>][]" value="<?php echo $match_num; ?>" />
<input type='hidden' name="player1[<?php echo $round; ?>][<?php echo $match_num; ?>][0]" value="<?php echo $process_res[6][$ab][0]; ?>" />
<input type='hidden' name="player1[<?php echo $round; ?>][<?php echo $match_num; ?>][1]" value="<?php 
	if($round > 1) { $s = $match_num - ($match_num - $source); echo $s; $source++; } else { echo "0"; } ?>" />
<?php
if($round > 1){ $prv_match1 = $s; }
?>
<input type='hidden' name="player2[<?php echo $round; ?>][<?php echo $match_num; ?>][0]" value="<?php echo $process_res[6][$ab][1]; ?>" />
<input type='hidden' name="player2[<?php echo $round; ?>][<?php echo $match_num; ?>][1]" value="<?php 
	if($round > 1) { $s = $match_num - ($match_num - $source); echo $s; $source++; } else { echo "0"; } ?>" />
<?php
if($round > 1){ $prv_match2 = $s; }


$match_dt_time = '';
$court_name = '';
if($match_timings[$match_num] and $is_bye == 0){
//echo "<br>".$match_timings[$match_num][0] . " - " .date('m/d/Y H:i', (trim($match_timings[$match_num][2])));
	$i = 1;
	while($i <= 10 and ($new_match_timings[$prv_match1][2] == $match_timings[$pick_time][2] or $new_match_timings[$prv_match2][2] == $match_timings[$pick_time][2])) {
		$pick_time++;
	$i++;
	}

$court_name = $match_timings[$pick_time][0];
echo "&nbsp;&nbsp;&nbsp;".$court_name;
$match_dt_time = date('m/d/Y H:i', (trim($match_timings[$pick_time][2])));
$new_match_timings[$match_num] = array('1' => $court_name, '2' => $match_timings[$pick_time][2]);

$pick_time++;
}
?>
<input type="hidden" id="court_<?php echo $match_num; ?>" name="assg_court<?php echo $match_num; ?>" 
value="<?php echo $court_name; ?>" />
<input type="hidden" id="sdate<?php echo $match_num; ?>" name="match_date<?php echo $match_num; ?>" value="<?php echo $match_dt_time; ?>" />
<?php


if($round == ($total_rounds)){
	$match_num++;
$round2 = -1;

$match_dt_time = '';
$court_name = '';
if($match_timings[$match_num] and $is_bye == 0){
//echo "<br>".$match_timings[$match_num][0] . " - " .date('m/d/Y H:i', (trim($match_timings[$match_num][2])));
	$i = 1;
	while($i <= 10 and ($new_match_timings[$prv_match1][2] == $match_timings[$pick_time][2] or $new_match_timings[$prv_match2][2] == $match_timings[$pick_time][2])) {
		$pick_time++;
	$i++;
	}

$court_name = $match_timings[$pick_time][0];
//echo "&nbsp;&nbsp;&nbsp;".$court_name;
$match_dt_time = date('m/d/Y H:i', (trim($match_timings[$pick_time][2])));
$new_match_timings[$match_num] = array('1' => $court_name, '2' => $match_timings[$pick_time][2]);

$pick_time++;
}
?>
<input type="hidden" id="court_<?php echo $match_num; ?>" name="assg_court<?php echo $round2; ?>" 
value="<?php echo $court_name; ?>" />
<input type="hidden" placeholder="Date" id="sdate<?php echo $match_num; ?>" name="match_date<?php echo $round2; ?>" value="<?php echo $match_dt_time; ?>" style="width: 62%;" />

<input type='hidden' name='round[]' value="<?php echo $round2; ?>" />

<input type='hidden' name="match_num[<?php echo $round2; ?>][]" value="<?php echo '-1'; ?>" />
<input type='hidden' name="player1[<?php echo $round2; ?>][<?php echo '-1'; ?>][0]" value="<?php echo $process_res[6][$ab][0]; ?>" />
<input type='hidden' name="player1[<?php echo $round2; ?>][<?php echo '-1'; ?>][1]" value="<?php 
	if($round > 1) { $s = ($match_num-2) - (($match_num-2) - ($source-2)); echo $s; /*$source++; */} else { echo "0"; } ?>" />
<?php
if($round > 1){ $prv_match1 = $s; }
?>
<input type='hidden' name="player2[<?php echo $round2; ?>][<?php echo '-1'; ?>][0]" value="<?php echo $process_res[6][$ab][1]; ?>" />
<input type='hidden' name="player2[<?php echo $round2; ?>][<?php echo '-1'; ?>][1]" value="<?php 
	if($round > 1) { $s = ($match_num-1) - (($match_num-1) - ($source-1)); echo $s; /*$source++; */} else { echo "0"; } ?>" />

<?php
}


$y++;

	if($process_res[6][$ab][1] == '---') {

		if($round < 2){
		$teams[$x] = $process_res[6][$ab][0];
		}
		else{
		$teams[$x] = "---";
		}
		$x++;
	}
	else if($process_res[6][$ab][0] == '---') {
		if($round < 2){
		$teams[$x] = $process_res[6][$ab][1];
		}
		else{
		$teams[$x] = "---";
		}
		$x++;
	}
	else {
		$teams[$x] = '---';
		$x++;
	}
//print_r($teams);
$match_num++;
//echo $match_num; exit;
}

unset($process_res[6]);
//print_r($teams);
//exit;
$num_teams = $process_res[3];
$prev_round_games = $process_res[1];
($prev_round_games > 1) ? $process_res[1] = $process_res[1]/2: $process_res[1];
	}
?>
<input type="hidden" id="tourn_id" name="tourn_id" value="<?php echo $tourn_id; ?>" />
<input type='hidden' name='match_type' value="<?php echo $this->input->post('types'); ?>" />
<input type='hidden' name='filter_events' value='<?php if($filter_events != '' and $filter_events != 'null') { echo $filter_events; }
else if($sport_level != '' and $sport_level != 'null'){ echo $sport_level; } ?>' />
<input type='hidden' name='age_group' value="<?php echo $this->input->post('type_gen'); ?>" />
<input type='hidden' name='ttype' value="<?php echo "Single Elimination"; ?>" />
<input type='hidden' name='is_publish_draw'	value="<?php echo '0'; ?>" />
<input type='hidden' name='num_of_sets'			value="<?php echo $num_of_sets; ?>" />
<input type='hidden' name='br_game_day' value="<?php echo $br_game_day; ?>" />
<input type="hidden" name="draw_format"  id="draw_format"  value='<?=$draw_format;?>' />

<input type='hidden' name='squad' value='<?php echo serialize($seed_team); ?>' />

<input type="submit" class="league-form-submit1" name="bracket_confirm" id="bracket_confirm" value="Confirm & Save" />

</form>
</html>
<?php
}



		public function cal_c($pow_vals, $num_teams, $teams, $round)			// Single Elimination
		{
			global $pow_vals;

			$pow_vals = array(2,4,8,16,32,64,128,256);
			
			foreach($pow_vals as $i=>$pv){
				if($num_teams > $pv){
					$near_pow = $pow_vals[++$i];
				}
				else if($num_teams == $pv){
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

					for($i=0;$i<$bye_p;$i++){
						$pl = array_shift($temp_teams);
						$bye_pl_list[$i] = array($pl,'---');
					}
				}

				$game_pl_list = array();
				if($round==1){
					for($i=0,$k=0;$i<$num_g;$i++){
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
				//if($round == 1 and $num_teams != 2){
					// New Code 18-March-2019
				//	$res[5] = league::getBracket($teams);
				//}

				/* -------------------------------------- */		

				$res[6] = $res[5];

			return $res;
		}

public function test_cn(){
	echo $this->load->view('includes/header');
	echo $this->load->view('view_calender_test');
}

	public function test_mobileNum(){
		// Check mobile numbers and remove space and  - 
		echo "Check mobile numbers and remove space and  -";
		exit;

			$res = $this->general->get_users_mobile();
			$count = 0;
echo "Count: ".count($res)."<br>";

			foreach($res as $i => $a2m){
				$rem_dash = str_replace('-','',$a2m->Mobilephone);
				$rem_br1	= str_replace('(','',$rem_dash);
				$rem_br2	= str_replace(')','',$rem_br1);
				$rem_sp	= str_replace(' ','',$rem_br2);
				$rem_sp1	= str_replace('+6','6',$rem_sp);
				$rem_sp2	= str_replace('+3','3',$rem_sp1);
				$rem_sp3	= str_replace('.','',$rem_sp2);
				$rem_sp4	= str_replace('+1+','+',$rem_sp3);

				echo $a2m->Users_ID." - ".$a2m->Mobilephone." = ".$rem_sp4."<br>";
				//$this->general->upd_user_mobNum($a2m->Users_ID, $rem_sp4);
			$count ++;
			}
echo "Total: ".$count."<br>";


	}

	public function update_user_json(){
		$result = $this->general->get_all_users();

					if(!empty($result)) {
							$returnStr = '[';
						foreach($result as $row){
							$returnStr .= '{';
							$fname = str_replace("'",'',$row->Firstname);
							$fname = str_replace('"','',$fname);

							$lname = str_replace("'",'',$row->Lastname);
							$lname = str_replace('"','',$lname);

							$returnStr .= 'label:'.'"'.trim($fname).' '.trim($lname).'",';
							$returnStr .= 'value:'.'"'.trim($fname).' '.trim($lname).'",';
							$returnStr .= 'value2:'.'"'.$row->Users_ID.'"';
							$returnStr .= '},';
						}
							$returnStr .= ']';
					}

		$result = $this->general->ins_users_json($returnStr);

		if($result) 
			echo "Updation Done.";
		else 
			echo "Updation Failed!";
	}

	function parse_crontab($time, $crontab){
		$time=explode(' ', date('i G j n w', strtotime($time)));
          $crontab=explode(' ', $crontab);
          foreach ($crontab as $k=>&$v)
                  {$time[$k]=intval($time[$k]);
                   $v=explode(',', $v);
                   foreach ($v as &$v1)
                           {$v1=preg_replace(array('/^\*$/', '/^\d+$/', '/^(\d+)\-(\d+)$/', '/^\*\/(\d+)$/'),
                                             array('true', $time[$k].'===\0', '(\1<='.$time[$k].' and '.$time[$k].'<=\2)', $time[$k].'%\1===0'),
                                             $v1
                                            );
                           }
                   $v='('.implode(' or ', $v).')';
                  }
          $crontab=implode(' and ', $crontab);
          return eval('return '.$crontab.';');
   }

		 public function test_crontab(){
			//var_export($this->parse_crontab('2022-05-04 02:08:03', '*/2,3-5,9 2 3-5 */2 *'));
			//var_export($this->parse_crontab('2022-05-04 02:08:03', '*/8 */2 */4 */5 *'));
			//30 9   0
			$config = array('i' => 30, 'H' => 9, 'd' => 0, 'm' => 0);
			$x = $this->getNextRunTime($config);

			echo date('Y-m-d H:i:s', strtotime($x));
		 }


function getNextRunTime($config) {
    $minute = $config['i'];
    $hour   = $config['H'];
    $day    = $config['d'];
    $month  = $config['m'];

    // Get minute
    switch($minute) {
        case 90 :
            $nextMinute = date('i', strtotime('now + 1 minute'));
            break;
        default :
            $nextMinute = $minute;
    }

    // Get hour
    switch($hour) {
        case 90 :
            if($minute == 90 || $nextMinute > date('i')) {
                $nextHour = date('H');
            } else {
                $nextHour = date('H', strtotime('now + 1 hour'));
            }
            break;
        default :
            $nextHour = $hour;
    }

    // Get day
    switch($day) {
        case 90 :
            if($hour == 90 && $nextHour > date('H')) {
                $nextDay = date('d');
            } elseif($hour <> 90 && $nextHour <= date('H')) {
                $nextDay = date('d', strtotime('now + 1 day'));
            } else {
                if($nextHour > date('H')) {
                    $nextDay = date('d');
                } else {
                    if ($nextMinute > date('i')) {
                        $nextDay = date('d');
                    } else {
                        $nextDay = date('d', strtotime('now + 1 day'));
                    }
                }
            }
            break;
        case 91 :
            if(date('t') == date('d')) {
                if($nextHour > date('H')) {
                    $nextDay = date('d');
                } elseif($nextHour == date('H') && $nextMinute > date('i')) {
                    $nextDay = date('d');
                } else {
                    $nextDay = date('t', strtotime('now + 1 month'));
                }
            } else {
                $nextDay = date('t');
            }
            break;
        default :
            $nextDay = $day;
    }

    // Get month
    switch($month) {
        case 90 :
            if($day == 90 || $nextDay > date('d')) {
                $nextMonth = date('m');
            } elseif($nextDay == date('d')) {
                if($hour == 90 || $nextHour > date('H')) {
                    $nextMonth = date('m');
                } elseif($nextHour == date('H')) {
                    if($minute == 90 || $nextMinute > date('i')) {
                        $nextMonth = date('m');
                    } else {
                        $nextMonth = date('m', strtotime('now + 1 month'));
                    }
                } else {
                    $nextMonth = date('m', strtotime('now + 1 month'));
                }
            } else {
                $nextMonth = date('m', strtotime('now + 1 month'));
            }
            break;
        default :
            $nextMonth = $month;
    }

    // Get year
    if($month == 90 || $nextMonth > date('m')) {
        $nextYear = date('Y');
    } elseif($nextMonth == date('m')) {
        if($day == 90 || $nextDay > date('d')) {
            $nextYear = date('Y');
        } elseif($nextDay == date('m')) {
            if($hour == 90 || $nextHour > date('H')) {
                $nextYear = date('Y');
            } elseif($nextHour == date('H')) {
                if($minute == 90 || $nextMinute > date('i')) {
                    $nextYear = date('Y');
                } else {
                    $nextYear = date('Y') + 1;
                }
            } else {
                $nextYear = date('Y') + 1;
            }
        } else {
            $nextYear = date('Y') + 1;
        }
    } else {
        $nextYear = date('Y') + 1;
    }

    // Create the timestamp for the 'Next Run Time'
    $nextRunTime = mktime($nextHour, $nextMinute, 0, $nextMonth, $nextDay, $nextYear);

    // Check if the job has to run every minute, maybe a reset to d-m-Y h:00 is possible
    if($nextRunTime > time() && $minute == 90) {
        $tempNextRunTime = mktime($nextHour, 0, 0, $nextMonth, $nextDay, $nextYear);

        if($tempNextRunTime > time()) {
            $nextMinute  = 0;
            $nextRunTime = $tempNextRunTime;
        }
    }

    // Check if the job has to run every hour, maybe a reset to d-m-Y 00:i is possible
    if($nextRunTime > time() && $hour == 90) {
        $tempNextRunTime = mktime(0, $nextMinute, 0, $nextMonth, $nextDay, $nextYear);

        if($tempNextRunTime > time()) {
            $nextHour    = 0;
            $nextRunTime = $tempNextRunTime;
        }
    }

    // Check if the job has to run every day, maybe a reset to 1-m-Y H:i is possible
    if($nextRunTime > time() && $day == 90) {
        $tempNextRunTime = mktime($nextHour, $nextMinute, 0, $nextMonth, 1, $nextYear);

        if($tempNextRunTime > time()) {
            $nextRunTime = $tempNextRunTime;
        }
    }

    // Return the Next Run Time timestamp
    return $nextRunTime;
}

public function test_duplicates(){

$failed = array(13883,14284,15006,12752,14963,11046,13868,11517,14766,13893,13894,14748,14801,14957,12641,12690,12688,14855,14839,14535,14536,12606,10756,12485,13970,14569,13862,11256,10659,14680,11454,14539,13901,14683,14721,14665,14787,1790,14465,14478,14704,12114,14580,12557,11080,14972,14993,14817,14820,14948,14991,14997,14999,10736,14193,14941,14743,14379,14376,14582,12644,14897,14707,14276,14232,14476,11198,11197,14355,14356,14369,14372,11228,15002,12078,12549,14288,14815,15007,11122,10968,14190,12358,13866,10695,14825,12717,12741,13955,14842,14213,14151,14214,14215,13934,13936,14678,14679,14394,15003,14932,14798,14392,12062,12065,14285,14901,14906,14377,13864,10807,12294,14570,14382,14608,14613,14614,14322,14098,13451,14996,11186,14870,14705,14802,12650,12320,14964,12669,14727,14826,239,14536,12606,10756,12485,13970,14569,13862,11256,10659,14680,11454,14539,13901,14683,14721,14665,14787,1790,14465,14478,14704,12114,14580,12557,11080,14972,14993,14817,14820,14948,14991,14997,14999,10736,14193,14941,14743,14379,14376,14582,12644,14897,14707,14276,14232,14476,11198,11197,14355,14356,14369,14372,11228,15002,12078,12549,14288,14815,15007,11122,10968,14190,12358,13866,10695,14825,12717,12741,13955,14842,14213,14151,14214,14215,13934,13936,14678,14679,14394,15003,14932,14798,14392,12062,12065,14285,14901,14906,14377,13864,10807,12294,14570,14382,14608,14613,14614,14322,14098,13451,14996,11186,14870,14705,14802,12650,12320,14964,12669,14727,14826,239,14704,12114,14580,12557,11080,14972,14993,14817,14820,14948,14991,14997,14999,10736,14193,14941,14743,14379,14376,14582,12644,14897,14707,14276,14232,14476,11198,11197,14355,14356,14369,14372,11228,15002,12078,12549,14288,14815,15007,11122,10968,14190,12358,13866,10695,14825,12717,12741,13955,14842,14213,14151,14214,14215,13934,13936,14678,14679,14394,15003,14932,14798,14392,12062,12065,14285,14901,14906,14377,13864,10807,12294,14570,14382,14608,14613,14614,14322,14098,13451,14996,11186,14870,14705,14802,12650,12320,14964,12669,14727,14826,239,12644,14897,14707,14276,14232,14476,11198,11197,14355,14356,14369,14372,11228,15002,12078,12549,14288,14815,15007,11122,10968,14190,12358,13866,10695,14825,12717,12741,13955,14842,14213,14151,14214,14215,13934,13936,14678,14679,14394,15003,14932,14798,14392,12062,12065,14285,14901,14906,14377,13864,10807,12294,14570,14382,14608,14613,14614,14322,14098,13451,14996,11186,14870,14705,14802,12650,12320,14964,12669,14727,14826,239,10968,14190,12358,13866,10695,14825,12717,12741,13955,14842,14213,14151,14214,14215,13934,13936,14678,14679,14394,15003,14932,14798,14392,12062,12065,14285,14901,14906,14377,13864,10807,12294,14570,14382,14608,14613,14614,14322,14098,13451,14996,11186,14870,14705,14802,12650,12320,14964,12669,14727,14826,239,14932,14798,14392,12062,12065,14285,14901,14906,14377,13864,10807,12294,14570,14382,14608,14613,14614,14322,14098,13451,14996,11186,14870,14705,14802,12650,12320,14964,12669,14727,14826,239,13451,14996,11186,14870,14705,14802,12650,12320,14964,12669,14727,14826,239);
$temp = array();

foreach($failed as $f){
	if(!in_array($f, $temp)){
		$no_dup[] = $f;
	}
	$temp[] = $f;
}


  echo "<pre>";
  echo count($failed);
  echo count($temp);
  echo "<br>";
  //print_r($no_dup);

echo json_encode($no_dup);

}

public function test_compare(){
 $notified = array(12642,12626,13872,13877,12107,14621,14390,14391,14294,14363,11627,13949,12102,14345,11314,13870,10068,14086,11064,14509,13883,14284,15006,12752,14963,11046,13868,11517,14766,13893,13894,14748,14801,14957,12641,12690,12688,14855,14839,14535,14536,12606,10756,12485,13970,14569,13862,11256,10659,14680,11454,14539,13901,14683,14721,14665,14787,1790,14465,14478,14704,12114,14580,12557,11080,14972,14993,14817,14820,14948,14991,14997,14999,10736,14193,14941,14743,14379,14376,14582,12644,14897,14707,14276,14232,14476,11198,11197,14355,14356,14369,14372,11228,15002,12078,12549,14288,14815,15007,11122,10968,14190,12358,13866,10695,14825,12717,12741,13955,14842,14213,14151,14214,14215,13934,13936,14678,14679,14394,15003,14932,14798,14392,12062,12065,14285,14901,14906,14377,13864,10807,12294,14570,14382,14608,14613,14614,14322,14098,13451,14996,11186,14870,14705,14802,12650,12320,14964,12669,14727,14826,239);
 $failed = array(13883,14284,15006,12752,14963,11046,13868,11517,14766,13893,13894,14748,14801,14957,12641,12690,12688,14855,14839,14535,14536,12606,10756,12485,13970,14569,13862,11256,10659,14680,11454,14539,13901,14683,14721,14665,14787,1790,14465,14478,14704,12114,14580,12557,11080,14972,14993,14817,14820,14948,14991,14997,14999,10736,14193,14941,14743,14379,14376,14582,12644,14897,14707,14276,14232,14476,11198,11197,14355,14356,14369,14372,11228,15002,12078,12549,14288,14815,15007,11122,10968,14190,12358,13866,10695,14825,12717,12741,13955,14842,14213,14151,14214,14215,13934,13936,14678,14679,14394,15003,14932,14798,14392,12062,12065,14285,14901,14906,14377,13864,10807,12294,14570,14382,14608,14613,14614,14322,14098,13451,14996,11186,14870,14705,14802,12650,12320,14964,12669,14727,14826,239,14536,12606,10756,12485,13970,14569,13862,11256,10659,14680,11454,14539,13901,14683,14721,14665,14787,1790,14465,14478,14704,12114,14580,12557,11080,14972,14993,14817,14820,14948,14991,14997,14999,10736,14193,14941,14743,14379,14376,14582,12644,14897,14707,14276,14232,14476,11198,11197,14355,14356,14369,14372,11228,15002,12078,12549,14288,14815,15007,11122,10968,14190,12358,13866,10695,14825,12717,12741,13955,14842,14213,14151,14214,14215,13934,13936,14678,14679,14394,15003,14932,14798,14392,12062,12065,14285,14901,14906,14377,13864,10807,12294,14570,14382,14608,14613,14614,14322,14098,13451,14996,11186,14870,14705,14802,12650,12320,14964,12669,14727,14826,239,14704,12114,14580,12557,11080,14972,14993,14817,14820,14948,14991,14997,14999,10736,14193,14941,14743,14379,14376,14582,12644,14897,14707,14276,14232,14476,11198,11197,14355,14356,14369,14372,11228,15002,12078,12549,14288,14815,15007,11122,10968,14190,12358,13866,10695,14825,12717,12741,13955,14842,14213,14151,14214,14215,13934,13936,14678,14679,14394,15003,14932,14798,14392,12062,12065,14285,14901,14906,14377,13864,10807,12294,14570,14382,14608,14613,14614,14322,14098,13451,14996,11186,14870,14705,14802,12650,12320,14964,12669,14727,14826,239,12644,14897,14707,14276,14232,14476,11198,11197,14355,14356,14369,14372,11228,15002,12078,12549,14288,14815,15007,11122,10968,14190,12358,13866,10695,14825,12717,12741,13955,14842,14213,14151,14214,14215,13934,13936,14678,14679,14394,15003,14932,14798,14392,12062,12065,14285,14901,14906,14377,13864,10807,12294,14570,14382,14608,14613,14614,14322,14098,13451,14996,11186,14870,14705,14802,12650,12320,14964,12669,14727,14826,239,10968,14190,12358,13866,10695,14825,12717,12741,13955,14842,14213,14151,14214,14215,13934,13936,14678,14679,14394,15003,14932,14798,14392,12062,12065,14285,14901,14906,14377,13864,10807,12294,14570,14382,14608,14613,14614,14322,14098,13451,14996,11186,14870,14705,14802,12650,12320,14964,12669,14727,14826,239,14932,14798,14392,12062,12065,14285,14901,14906,14377,13864,10807,12294,14570,14382,14608,14613,14614,14322,14098,13451,14996,11186,14870,14705,14802,12650,12320,14964,12669,14727,14826,239,13451,14996,11186,14870,14705,14802,12650,12320,14964,12669,14727,14826,239);

 foreach($notified as $n){
	if(!in_array($n, $failed))
		$success_arr[] = $n;
 }
  echo "<pre>";
  echo count($notified);
  echo "<br>";
  print_r($success_arr);
}

}