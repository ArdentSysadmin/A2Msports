<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
//error_reporting(-1);
      // session_start(); 

	class Courts extends CI_Controller {
	
	 	public $header_tpl	   = "academy_views/includes/academy_header";
		public $reserve_tpl    = "academy_views/includes/academy_reserve";
	 	public $right_col_tpl  = "academy_views/includes/academy_right_column";
	 	public $footer_tpl	   = "academy_views/includes/academy_footer";

		public $logged_user;
		public $is_club_member;
		public $is_club_coach;
		public $short_code;
		public $org_id;
		public $academy_admin;

		public function __construct()
		{
			parent:: __construct();
			$this->load->helper('form', 'url');
			$this->load->library('form_validation');
			$this->load->library('session');

			/*if(!$this->session->userdata('user')){

				$url_seg1 = $this->uri->segment(1);
				$url_seg2 = $this->uri->segment(2);
				$url_seg3 = $this->uri->segment(3);
				$url_seg4 = $this->uri->segment(4);
				
				$last_url = array('redirect_to' => $url_seg1."/".$url_seg2."/".$url_seg3."/".$url_seg4);
				$this->session->set_userdata($last_url);

				redirect('login');
			}*/

			// Load database			
			$this->load->model('academy_mdl/model_courts',  'model_courts');
			$this->load->model('academy_mdl/model_news',	'model_news');
			$this->load->model('academy_mdl/model_general', 'general');
			$this->load->model('academy_mdl/model_academy', 'model_academy');
			$this->load->library('paypal_lib');

			$this->short_code    = $this->uri->segment(1);
			$this->logged_user   = $this->session->userdata('users_id');
			$this->org_id	     = $this->general->get_orgid($this->short_code);
			$this->academy_admin = $this->general->get_org_admin($this->short_code);

			$det = $this->general->check_is_member($this->org_id, $this->logged_user);
			$this->is_club_member = ($det['tab_id'] and $det['Member_Status']) ? 1 : 0;

			$det2 = $this->general->check_is_clubCoach($this->org_id, $this->logged_user);
			$this->is_club_coach = ($det2['Users_ID']) ? 1 : 0;


			$this->admin_menu_items = array('0'=>'');
			if($this->logged_user != $this->academy_admin)
			$this->admin_menu_items = array('0'=>'8');
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

		public function check_log_status(){

			if(!$this->logged_user){
				$url_seg1 = $this->uri->segment(1);
				$url_seg2 = $this->uri->segment(2);
				$url_seg3 = $this->uri->segment(3);
				$url_seg4 = $this->uri->segment(4);
				
				$last_url = array('redirect_to' => $url_seg1."/".$url_seg2."/".$url_seg3."/".$url_seg4);
				$this->session->set_userdata($last_url);

				redirect($this->short_code.'/login');
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

		public function reserve($data = "")
		{	
			//error_reporting(-1);
			$this->check_log_status();

			$data			   = $this->get_org_details($this->org_id);
			//$data['results']   = $this->model_news->get_news($this->org_id);
			$data['locations'] = $this->model_courts->get_locations_and_courts($this->org_id);
			$user_det		   = $this->general->get_user($this->logged_user);
			$data['logged_user'] = $user_det['Firstname']." ".$user_det['Lastname'];
			$this->load->view($this->header_tpl, $data);
			//$this->load->view($this->reserve_tpl, $data);
			$this->load->view('academy_views/view_reserve', $data);
			//$this->load->view($this->right_col_tpl, $data);
			$this->load->view($this->footer_tpl);
		}

		public function get_min_max_court_time($loc_id){
			$min_max = $this->model_courts->get_min_max_court_time($loc_id);
			return $min_max;
		}

		public function courts_list($data = "")
		{	
			$this->check_log_status();
			$data			 = $this->get_org_details($this->org_id);
			$data['results'] = $this->model_news->get_news($this->org_id);
			$data['courts']  = $this->model_courts->get_locations($this->org_id);

			/********* Code to get paypalID's & paytmID's ************/
			$user_id = $this->session->userdata('users_id');

			if($data['creator'] != $user_id){ 
				echo "Unauthorised Access!"; 
				exit; 
			}

			$data['paypal_ids'] = $this->model_courts->get_paypalIDs($user_id);
			$data['paytm_ids'] = $this->model_courts->get_paytmIDs($user_id);

			$this->load->view($this->header_tpl, $data);
			$this->load->view('academy_views/view_courts_list', $data);
			$this->load->view($this->right_col_tpl, $data);
			$this->load->view($this->footer_tpl);
		}


		public function add_court()
		{
			//echo "<pre>"; print_r($_POST); exit;

			if($this->input->post('submit_location')){
				$get_long				= $this->get_lang_latt();
				$data['long_latt']	= $get_long;
				
				$ins_data				= $this->model_courts->add_court($data);
				//$ins_data			= $this->model_courts->add_court_test($data);

				$data				= $this->get_org_details($this->org_id);
				$data['results']	= $this->model_news->get_news($this->org_id);
				$data['courts']	= $this->model_courts->get_locations($this->org_id);

				$this->load->view($this->header_tpl, $data);
				$this->load->view('academy_views/view_courts_list', $data);
				$this->load->view($this->right_col_tpl, $data);
				$this->load->view($this->footer_tpl);
			}
			else{
				echo "Invalid Request!";
			}
		}

		public function update_court()
		{
			// echo "<pre>";	print_r($_POST);exit;
			if($this->input->post('submit_upd_location')){		
				$get_long			= $this->get_lang_latt();
				$data['long_latt']	= $get_long;
				
				$ins_data			= $this->model_courts->update_court($data);

				redirect($this->short_code.'/courts/list');
			}
			else{
				echo "Invalid Request!";
			}
		}

		public function check_court_availability()
		{
			/*echo "<pre>"; print_r($_POST); 
			echo date('Y-m-d H:i:s', strtotime($_POST['res_date']));
			exit;*/
			$stat = $this->model_courts->check_court_avail();

			if($stat == 1){
			  $get_price = $this->model_courts->get_court_price();
			  echo $stat.'_'.$get_price;
			}
			else{
			  echo $stat;
			}
		}

		public function get_court_durations()
		{
			$loc_id = $this->input->post('loc_id');
			$court_id = $this->input->post('court');

			$data = $this->model_courts->get_court_durations($loc_id, $court_id);

			$max_hours = $data['max_hours'];

				echo "<option value=''>Duration</option>";
			for($hr =1; $hr <= $max_hours; $hr++){
				if($hr == 1)
				echo "<option value='$hr'>$hr hour</option>";
				if($hr > 1)
				echo "<option value='$hr'>$hr hours</option>";
			}

		}

public function get_next_dates(){
		$court = $this->input->post('court'); // court id
		$rd = $this->input->post('rd'); // reserve date
		$from_time = $this->input->post('rt');	// time
		$bd = $this->input->post('bd'); // number of days / weeks
		$tp =  $this->input->post('tp'); // is it a days / weeks
		$slt =  $this->input->post('slt');	// duration

		$court_det = $this->model_courts->get_court_det($court);
		$mins = ($duration * 60) * $court_det['slot_duration'];
		$to_time	= date('H:i', strtotime('+'.$mins.' minutes', strtotime($from_time))); 

		$str = '';
		for($i = 1; $i<=$bd; $i++){
			$nxt = date('M d, Y', strtotime('+'.$i." {$tp}", strtotime($rd)));
			$nxt_date = date('Y-m-d', strtotime($nxt));
			$check_avail = $this->model_courts->is_nxt_avail($court, $nxt_date, $from_time, $to_time);
			if($check_avail)
				$str .= "<b style='color:#012a75'>" . $nxt . "</b>";
			else
				$str .= "<i class='fa fa-exclamation-triangle' aria-hidden='true' title='Bookings are exists on this date & slot!'></i><b style='color:red'>" . $nxt . "</b>";

			if($i != $bd)
				$str .= '; ';
		}

		echo "<b style='color:red'>Note:</b> Additional booking dates will be: ".$str;
}

		public function block_court()
		{
			/*if($this->logged_user == 240){
				echo "<pre>";
				print_r($court_name);
				print_r($_POST);
				echo "Testing";
				exit;
			}*/

			$stat  = $this->model_courts->check_court_avail();
			$price = $this->input->post('book_price_val');
			if($price == ''){
				echo "Something went wrong! Please try again!";
				exit;
			}
			$block_all_day	= $this->input->post('block_all_day');
			if($block_all_day)
				$stat = 1;
			
			 if($stat == 1 and $price != '')
			 {
				$court_id  = $this->input->post('court');
				$loc_id		= $this->input->post('loc_id');

				$check_is_payable = $this->model_courts->check_payable($court_id);

				//$fee = number_format($check_is_payable['book_price_val'],2);
				$fee = number_format($this->input->post('book_price_val'),2);
//echo $fee;
//exit;

			$court_durations		= $this->model_courts->get_court_durations($loc_id, $court_id);
			$sd	= $court_durations['slot_duration'];
			
			$res_date	 = explode(" ",$this->input->post('res_date'));
			$res_time	 = $this->input->post('res_time');
			
			//if(!$res_date[1]){
			//$res_date = explode("T", $this->input->post('res_date'));
			//}
					if($block_all_day and ($this->logged_user == $this->academy_admin)){
						$get_court_times = $this->model_courts->getCourtsTimesFees($court_id);
						//echo "<pre>"; print_r($get_court_times[0]->Start_Time); exit;
						$hrs				= $this->input->post('book_hours');
			
						$rdate			= date('Y-m-d', strtotime($res_date[0]));
						$min_time	= $this->model_courts->get_min_time($court_id);
						$max_time	= $this->model_courts->get_max_time($court_id);

						//$from_time	= date('H:i', strtotime($get_court_times[0]->Start_Time)); 
						//$to_time		= date('H:i', strtotime($get_court_times[0]->End_Time)); 
						
						$from_time	= date('H:i', strtotime($min_time)); 
						$to_time		= date('H:i', strtotime($max_time)); 
					}
					else{
						//$hrs				= $this->input->post('book_hours');
						$mins				= ($this->input->post('book_hours') * 60) * $sd;
//echo $mins;
						$rdate			= date('Y-m-d', strtotime($res_date[0]));
						$from_time	= date('H:i', strtotime($res_time)); 

						/*if($hrs > 19){
						$to_time		= date('H:i', strtotime('+'.$hrs.' minutes', strtotime($res_date[1]))); 
						}
						else{
						$to_time		= date('H:i', strtotime('+'.$hrs.' hours', strtotime($res_date[1])));
						}*/
						$to_time		= date('H:i', strtotime('+'.$mins.' minutes', strtotime($res_time))); 

					}
					//echo $rdate."-".$from_time."-".$to_time;
					//exit;
					$loc_name		= $this->model_courts->get_loc_name($loc_id);
					$court_name	= $this->model_courts->get_court_name($court_id);
					$reserved_by	= $this->logged_user;

					$match_format	= $this->input->post('match_format');
					$num_players	= $this->input->post('num_players');
					$players		= NULL;
					if($num_players > 0)
					$players		= json_encode($this->input->post('players'));


				if($fee != '0.00'){
					/* ------------------------------------------------------------------------------ */
					//set variables for paypal form
					//$paypalURL = 'https://www.sandbox.paypal.com/cgi-bin/webscr'; //test PayPal api url
					//$paypalID = 'busi@exitrow.com'; //business email

					//$get_court_det = 
					$payment_info = $this->model_courts->get_court_det($court_id);
					$gateway	 = 'paypal';
					if($payment_info){
						$gateway		= $payment_info['gateway_name'];
						$pay_ref_id  = $payment_info['payment_ref_id'];
						
						if($gateway == 'paypal'){
							$get_paypal_info = $this->model_courts->get_paypal_info($pay_ref_id);
							
							if($get_paypal_info){
								$paypalID = $get_paypal_info['paypal_merch_id'];	 //business email
							}
							else{
								$paypalID = 'admin@a2msports.com';						 //business email
							}
						}
						else if($gateway == 'paytm'){
							$get_paytm_info = $this->model_courts->get_paytm_info($pay_ref_id);

							$PAYTM_MERCHANT_MID = "{$get_paytm_info['paytm_merch_id']}";
							$PAYTM_MERCHANT_KEY = "{$get_paytm_info['paytm_merchant_key']}"; 
						}
						else{
							$paypalID = 'admin@a2msports.com';						//business email
						}
					}

					$sess_vals = array('num_players' => $num_players, 
										'match_format' => $match_format, 
										'players' => $players);

					$this->session->set_userdata($sess_vals);

if($gateway == 'paypal'){
					$paypalURL = 'https://www.paypal.com/cgi-bin/webscr';   //test PayPal api url
					//$paypalID = 'admin@a2msports.com';						//business email

					$returnURL = base_url().$this->short_code.'/courts/paypal_success?loc_id='.$loc_id.'&court_id='.$court_id.'&rdate='.$rdate.'&f_time='.$from_time.'&t_time='.$to_time; //payment success url
					$cancelURL = base_url().$this->short_code.'/courts/paypal_cancel'; //payment cancel url
					$notifyURL = base_url().'ipn'; //ipn url

					$logo = base_url().'images/logo.png';
					
					$this->paypal_lib->add_field('business', $paypalID);
					$this->paypal_lib->add_field('return', $returnURL);
					$this->paypal_lib->add_field('cancel_return', $cancelURL);
					$this->paypal_lib->add_field('notify_url', $notifyURL);
					$this->paypal_lib->add_field('location', $loc_id);
					$this->paypal_lib->add_field('player', $this->logged_user);
					$this->paypal_lib->add_field('item_number',  $court);
					$this->paypal_lib->add_field('item_name',  $court_name);
					$this->paypal_lib->add_field('amount', $fee);        
					$this->paypal_lib->add_field('quantity', 1);        
					$this->paypal_lib->image($logo);
					
					$this->paypal_lib->paypal_auto_form();
}
else if($gateway == 'paytm'){

		// redirect('league/test_func1/'.$tid);
		 require_once(APPPATH . "/third_party/paytm/config_paytm.php");
		 require_once(APPPATH . "/third_party/paytm/encdec_paytm.php");

		 $paramList["MID"]		 = PAYTM_MERCHANT_MID;
		 $paramList["ORDER_ID"] = $court_id.'_'.$this->logged_user.'_'.rand(1,10000000);
		// $paramList["ORDER_ID"]  = $tid.'_'.$this->logged_user;
		 $paramList["CUST_ID"]   = $this->logged_user;
		 $paramList["INDUSTRY_TYPE_ID"] = 'Retail';
		 $paramList["CHANNEL_ID"] = 'WEB';
		 $paramList["TXN_AMOUNT"] = $fee;
		 $paramList["WEBSITE"]	  = PAYTM_MERCHANT_WEBSITE;
		 $paramList["CALLBACK_URL"] = PAYTM_CALLBACK_URL;

/* ***************************** */
 header("Pragma: no-cache");
 header("Cache-Control: no-cache");
 header("Expires: 0");

 // following files need to be included

 $checkSum  = "";
// $paramList = array();

 $CUST_ID    = $this->logged_user;
 $TXN_AMOUNT = $fee;

// Create an array having all required parameters for creating checksum.

 /*
 $paramList["MSISDN"] = $MSISDN; //Mobile number of customer
 $paramList["EMAIL"] = $EMAIL; //Email ID of customer
 $paramList["VERIFIED_BY"] = "EMAIL"; //
 $paramList["IS_USER_VERIFIED"] = "YES"; //
 */

//Here checksum string will return by getChecksumFromArray() function.
/*echo "<pre>";
print_r($paramList);
exit;*/
 $checkSum = getChecksumFromArray($paramList, PAYTM_MERCHANT_KEY);
//echo $checkSum;
//exit;

/*echo "<pre>";
print_r($this->session->all_userdata());
exit;*/

 echo "<html>
<head>
<title>Merchant Check Out Page</title>
</head>
<body>
    <center><h1>Please do not refresh this page...</h1></center>
        <form method='post' action='".PAYTM_TXN_URL."' name='f1'>
<table border='1'>
 <tbody>";

 foreach($paramList as $name => $value) {
 echo '<input type="hidden" name="'.$name.'" value="'.$value.'" />';
 }

 echo "<input type='hidden' name='CHECKSUMHASH' value='".$checkSum."' />
 </tbody>
</table>
<script type='text/javascript'>
document.f1.submit();
</script>
</form>
</body>
</html>";

}
else{
	echo "Error in Payment Gateway! Please contact admin.";
	exit;
}

					/* ------------------------------------------------------------------------------ */
				 }
				 else
				 {
					 $is_multi_occr = 0;
					 $multi_weeks = 0;
					 $multi_days = 0;

					 if($this->input->post('repeat_booking_week')){
						 $is_multi_occr = 1;
						 $multi_weeks	 = $this->input->post('repeat_booking_week');
					 }
					 else if($this->input->post('repeat_booking_days')){
						 $is_multi_occr = 1;
						 $multi_days	 = $this->input->post('repeat_booking_days');
					 }
					
					$data = array('court_id'	=> $court_id,
								'loc_id'					=> $loc_id,
								'reserved_by'		=> $reserved_by,
								'res_date'			=> $rdate,
								'from_time'			=> $from_time,
								'to_time'				=> $to_time,
								'created_on'		=> date('Y-m-d H:i:s'),
								'res_status'			=> 'Active',
								'match_format'	=> $match_format,
								'num_players'		=> $num_players,
								'players'				=> $players,
								'is_repeat'			=> $is_multi_occr
								);	

					$res_id = $this->model_courts->confirm_court($data);

					if($is_multi_occr and $multi_weeks){
						for($i = 1; $i <= $multi_weeks; $i++){
							$nxt_date = date('Y-m-d', strtotime('+'.$i.' week', strtotime($rdate)));
	
							$temp = array('res_date' => $nxt_date, 'loc_id' => $loc_id, 'court_id' => $court_id, 'from_time' => $from_time, 'to_time' => $to_time);

							if($this->model_courts->check_court_booking($temp)){
					$data = array('court_id'	=> $court_id,
								'loc_id'					=> $loc_id,
								'reserved_by'		=> $reserved_by,
								'res_date'				=> $nxt_date,
								'from_time'			=> $from_time,
								'to_time'				=> $to_time,
								'created_on'			=> date('Y-m-d H:i:s'),
								'res_status'			=> 'Active',
								'match_format'		=> $match_format,
								'num_players'		=> $num_players,
								'players'				=> $players,
								'is_repeat'				=> 1,
								'is_repeat_ref'		=> $res_id
								);	

					$cofrm_booking = $this->model_courts->confirm_court($data);
							}

						}
					}

					if($is_multi_occr and $multi_days){
						for($i = 1; $i <= $multi_days; $i++){
							$nxt_date = date('Y-m-d', strtotime('+'.$i.' day', strtotime($rdate)));

							$temp = array('res_date' => $nxt_date, 'loc_id' => $loc_id, 'court_id' => $court_id, 'from_time' => $from_time, 'to_time' => $to_time);
							if($this->model_courts->check_court_booking($temp)){
							$data = array('court_id'	=> $court_id,
										'loc_id'					=> $loc_id,
										'reserved_by'		=> $reserved_by,
										'res_date'				=> $nxt_date,
										'from_time'			=> $from_time,
										'to_time'				=> $to_time,
										'created_on'			=> date('Y-m-d H:i:s'),
										'res_status'			=> 'Active',
										'match_format'		=> $match_format,
										'num_players'		=> $num_players,
										'players'				=> $players,
										'is_repeat'				=> 1,
										'is_repeat_ref'		=> $res_id
										);	

							$cofrm_booking = $this->model_courts->confirm_court($data);
							}

						}
					}


					$send_conf_mail = $this->send_conf_email($court_id, $loc_id, $reserved_by, $rdate, $from_time, $to_time);

					redirect($this->short_code.'/courts/reserve/'.date('Y-d-m', strtotime($rdate)));

				 }
			 }
			 else
			 {
				echo "Sorry, Something went wrong! Please try again.";
			 }
		}
			
		public function paypal_success(){

			$paypalInfo = $this->input->get();

			$num_players  = $this->session->userdata('num_players');	
			$match_format = $this->session->userdata('match_format');
			$players	  = $this->session->userdata('players');

			$data = array('court_id'	=> $paypalInfo['court_id'],
						'loc_id'		=> $paypalInfo['loc_id'],
						'reserved_by'	=> $this->logged_user,
						'res_date'		=> $paypalInfo['rdate'],
						'from_time'		=> $paypalInfo['f_time'],
						'to_time'		=> $paypalInfo['t_time'],
						'created_on'	=> date('Y-m-d'),
						'fee_paid'		=> $paypalInfo['amt'],
						'trans_id'		=> $paypalInfo['tx'],
						'paid_date'		=> date('Y-m-d'),
						'res_status'	=> 'Active',
						'match_format'	=> $match_format,
						'num_players'	=> $num_players,
						'players'		=> $players
						);	

			$cofrm_booking = $this->model_courts->confirm_court($data);
			
			$this->session->unset_userdata('match_format');
			$this->session->unset_userdata('num_players');
			$this->session->unset_userdata('players');


			$send_conf_mail = $this->send_conf_email($paypalInfo['court_id'], $paypalInfo['loc_id'], $this->logged_user, $paypalInfo['rdate'], $paypalInfo['f_time'], $paypalInfo['t_time']);

			redirect($this->short_code.'/courts/reserve/'.date('Y-d-m', strtotime($paypalInfo['rdate'])));
		}

		public function paypal_cancel(){
			echo "Transaction Cancelled! <a href='".base_url().$this->short_code."/courts/reserve'>Click Here</a> to return to the site.";
		}

		public function send_conf_email($court_id, $loc_id, $reserved_by, $rdate, $from_time, $to_time)
		{
			
				$loc_name	= $this->model_courts->get_loc_name($loc_id);
				$court_name	= $this->model_courts->get_court_name($court_id);

				$this->load->library('email');
				$this->email->set_newline("\r\n");
				
				$player_det = $this->get_username($reserved_by);
				$player_name = $player_det['Firstname'] . " " . $player_det['Lastname'];
				$player_email = $player_det['EmailID'];

				$this->email->from('admin@a2msports.com', 'A2MSports');
				$this->email->to($player_email);

				$subject = "Court (".$loc_name."/".$court_name.") Reservation - A2MSports";
				
				$this->email->subject($subject);

				$data = array(
				 'name'		  => $player_name,
				 'loc_name'	  => $loc_name,
				 'court_name' => $court_name,
				 'rdate'	  => $rdate,
				 'from_time'  => $from_time,
				 'to_time'	  => $to_time,
				 'page'		  => 'Reserve Court Confirmation'
				 );

				$body = $this->load->view('academy_views/view_email_template.php', $data, TRUE);
				$this->email->message($body);   

				/*echo "<pre>"; print_r($data);
				echo $body;

				exit;*/
				$status = $this->email->send();
				
			return $status;
		}

		public function get_username($user_id)
		{
			return $this->general->get_user($user_id);
		}

		public function get_lang_latt()
		{
			$address	= $this->input->post('address');
			$city		= $this->input->post('city');
			$state		= $this->input->post('state');
			$country	= $this->input->post('country');
			$zipcode	= $this->input->post('zip');

			$addr = $address.' '.$city.' '.$state.' '.$country.' '.$zipcode;

			if(!empty($addr)){
			$formattedAddr	 = str_replace(' ','+',$addr);
			$geocodeFromAddr = file_get_contents('http://maps.googleapis.com/maps/api/geocode/json?address='.$formattedAddr.'&sensor=true_or_false'); 

			$output1   = json_decode($geocodeFromAddr);
			$latitude  = 0.00; 
			$longitude = 0.00;

			$latitude  = $output1->results[0]->geometry->location->lat; 
			$longitude = $output1->results[0]->geometry->location->lng;

			return $latitude.'@'.$longitude;
			}
			else{
			return false;
			}
		}

		public function get_loc_courts(){
			$loc_id		= $this->input->post('loc_id');
			$get_courts = $this->model_courts->get_loc_courts($loc_id);

				echo "<option value=''>Select Court</option>";
			foreach($get_courts as $court){
				$charge = "";
				/*if($court->fee_per_hour != ".0000")
					{ $charge = "&nbsp;&nbsp;&nbsp;&nbsp; Fee $".number_format($court->fee_per_hour, 2)."/hr"; }*/
				echo "<option value='$court->court_id'>$court->court_name $charge</option>";
			}
		}

		public function get_loc_info($loc_id = ''){
	
			$loc_id			  = $this->input->post('loc_id');
			$get_loc_info	  = $this->model_courts->get_loc_info($loc_id);
			$get_loc_courts	  = $this->model_courts->get_loc_courts_all($loc_id);
			// Added to get paymentgateway Info.	
			/* ******************* Code to get paypalID's & paytmID's ********************** */
			$user_id = $this->session->userdata('users_id');
			$data['paypal_ids'] = $this->model_courts->get_paypalIDs($user_id);
			$data['paytm_ids'] = $this->model_courts->get_paytmIDs($user_id);
			/* ******************* Code to get paypalID's & paytmID's ********************** */
			$payment_info     = $this->model_courts->get_payment_info($loc_id);
			//
			$data['pay_info']	= $payment_info;
			$data['loc_info']	= $get_loc_info;
			$data['loc_courts'] = $get_loc_courts;
			$this->load->view('academy_views/view_courts_edit',$data);
		}

		public function get_court_reservations(){
	
			$org_id		= $this->input->post('org_id');
			$res_date	= $this->input->post('res_date');
			$day		= lcfirst(date('D', strtotime($res_date)));
			$events = array();
			$query  = $this->model_courts->get_court_reservations_by_date($org_id, $res_date);

			$courts_info = $this->model_courts->get_court_timings($org_id, $day);

			//echo "<pre>";
			//echo $day;
			//print_r($courts_info);

			foreach($query as $fetch)
			{
				$e = array();
				$plrs = json_decode($fetch->players, true);
				$player = $plrs[0];
				if(!$plrs[0]){
				$player = $fetch->firstname." ".$fetch->lastname;
				}
				$e['id']					= $fetch->res_id;
				$e['firstname']		= $fetch->firstname;
				$e['lastname']		= $fetch->lastname;
				$e['player']			= $player;
				$e['courtid']			= $fetch->court_id;
				//$e['courtid'][]		= $courts_info[$org_id][$fetch->court_id];
				$e['locid']			= $fetch->loc_id;
				$e['date']				= $fetch->res_date;
				$e['from_time']		= $fetch->from_time;
				$e['to_time']			= $fetch->to_time;
				$e['num_players']	= $fetch->num_players;
				$e['match_format']	= $fetch->match_format;
				$e['is_repeat']			= $fetch->is_repeat;
				$e['repeat_ref']		= $fetch->is_repeat_ref;
				
				$courts_info[$fetch->loc_id][$fetch->court_id]['reserve'][] = $e;
			}
			//echo json_encode($events);
			//echo "<pre>"; print_r($courts_info); 
			echo json_encode($courts_info);
		}

		public function get_currency_codes(){
			$currency_codes = $this->model_courts->get_currency_codes();
			return $currency_codes;
		}

		public function get_selected_values($payment_id,$gateway,$uid){
			$selected_value = $this->model_courts->get_selected_values($payment_id,$gateway,$uid);

			return $selected_value;
		}

		public function getCourtsTimesFees($courtID){
			$courts_dates_fees = $this->model_courts->getCourtsTimesFees($courtID);
			return $courts_dates_fees;
		}

		public function get_reserve_popup(){
			$data['date']  = $book_date = $this->input->post('date');
			$data['time']  = $this->input->post('time');
			$data['court'] = $court_id = $this->input->post('court');

			$loc							= $this->model_courts->get_loc_id($court_id);
			$loc_id						= $data['loc_id'] = $loc['loc_id'];
			$data['get_courts']	= $this->model_courts->get_loc_courts($loc_id);
			$data['get_loc_info']	= $get_loc_info = $this->model_courts->get_loc_info($loc_id);

			$court_durations		= $this->model_courts->get_court_durations($loc_id, $court_id);
			$data['max_hours']	= $court_durations['max_hours'];
			$data['max_adv']		= $court_durations['max_adv_booking_days'];
			$data['is_sdb_allowed']		= $court_durations['allow_sameday_booking'];
			$data['is_smb_allowed']		= $court_durations['allow_sameday_multi_booking'];
			$data['slot_duration']	= $court_durations['slot_duration'];
			$data['court_price']		= $this->model_courts->get_courtPrice($court_id);
			$data['min_time']		= $this->model_courts->get_min_time($court_id);
			$data['max_time']		= $this->model_courts->get_max_time($court_id);
			
			$data['is_nonmem_book'] = $get_loc_info['access_to_nonmem'];

			if(!$data['is_nonmem_book']){
			$data['is_user_member'] = $this->model_courts->is_club_member($this->logged_user, $this->org_id);
			}

			$data['is_club_admin'] = $this->model_courts->is_club_admin($this->logged_user, $this->org_id);
			$data['is_club_coach'] = $this->model_courts->is_club_coach($this->logged_user, $this->org_id);

			$data['is_user_have_bookings'] = 0;		

			if(!$is_smb_allowed and ($this->logged_user != $this->academy_admin)) {
				$check		= $this->model_courts->is_same_day_booking($court_id, $this->logged_user, $book_date);
				$check2	= $this->model_courts->is_same_day_othercourt_booking($loc_id, $court_id, $this->logged_user, $book_date);
				//echo $check; exit;
				if($check > 0)
					$data['is_user_have_bookings'] = 1;		
				if($check2 > 0)
					$data['is_user_have_othercourt_bookings'] = 1;		
			}

//echo "<pre>"; print_r($data); exit;
			$this->load->view('academy_views/view_reserve_frm', $data);
		}

		public function paytm_gateway($tid){
			$tour_det  = $this->model_league->getonerow($tid);
			
			$tsize	    = $this->input->post('tshirt_size');
			$coup_code  = $this->input->post('coup_code');
			$coup_disc  = $this->input->post('coup_disc');
			$txt_amount = $this->input->post('tour_fee');

			if($tour_det->tournament_format != 'Teams' and $tour_det->tournament_format != 'TeamSport'){
			    $data				   = $this->Get_Events(); 
				$partners			   = $this->input->post('partners');
				$data['json_partners'] = json_encode($partners);
			}
			else{
				 $levels  = $this->input->post('level');
				 $age_grp = $this->input->post('age_group');
				 $data['json_levels'] = $levels;
				 $data['json_ag']	  = $age_grp;
			}

			$note_to_admin = $this->input->post('note_to_admin');
	
		   if($tour_det->Merchant_Paytm){
			 $get_merchant=$this->model_league->get_paytm_merchant($tour_det->Merchant_Paytm);

						if($get_merchant){
							$paypal_id		= $get_merchant['paytm_merch_id'];
							if($get_merchant['currency_format']){
							$currency_code  = $get_merchant['currency_format'];
							}
						}
						/*echo $get_merchant['paytm_merchant_key'];
						exit;*/
						/*define('PAYTM_MERCHANT_KEY', $get_merchant['paytm_merchant_key']); 
						define('PAYTM_MERCHANT_MID', $get_merchant['paytm_merch_id']);*/
						$PAYTM_MERCHANT_MID = "{$get_merchant['paytm_merch_id']}";
						$PAYTM_MERCHANT_KEY = "{$get_merchant['paytm_merchant_key']}"; 
			}
				//session_start();

				if($tour_det->tournament_format == 'Teams' || $tour_det->tournament_format == 'TeamSport'){
					$ttype			= 'Teams';
					$reg_user		= $this->logged_user;
					$reg_team		= $this->input->post('team');
					$reg_team_players = json_encode($this->input->post('sel_team_player'));

					$age_group		= json_encode($age_grp);
					$level			= json_encode($levels);
					$hc_loc_id		= $this->input->post('hc_loc_id');

					$arr = array('paytm_session' => 
								array('tourn_id' => $tid,
									  'team'	 => $reg_team,
									  'reg_user' => $reg_user,
									  'team_players' => $reg_team_players,
									  'age_group' => $age_group,
									  'level'	  => $level,
									  'hc_loc'	  => $hc_loc_id,
									  'ttype'	  => $ttype,
									  'tsize'	  => $tsize,
									  'coup_code' => $coup_code,
									  'coup_disc' => $coup_disc,
									  'note_to_admin' => $note_to_admin
								)
						   );
					$temp_arr = array('paytm_session1' => 'test');
					//$this->session->unset_userdata('paytm_session');
					$this->session->set_userdata($arr);
					$this->session->set_userdata($temp_arr);
					//$_SESSION['paytm_session'] = '3432';
				}
				else{
					$ttype			= 'Indv';
					$reg_userid		= $this->logged_user;
					$age_group		= $data['json_ag'];
					$match_types	= $data['json_formats'];
					$db_partner		= $this->input->post('created_users_id');
					$md_partner		= $this->input->post('created_users_id1');
					$level			= $data['json_levels'];
					$partners		= $data['json_partners'];
					$hc_loc_id		= $this->input->post('hc_loc_id');
                    $reg_events     = json_encode($this->input->post('events'));
					//Set variables for paypal form
				//echo $level;
				//exit;
					$arr = array('paytm_session' => 
								array('tourn_id'  => $tid,
									  'player'	  => $reg_userid,
									  'age_group' => $age_group,
									  'mtypes'	  => $match_types,
									  'partners'  => $partners,
									  'level'	  => $level,
									  'hc_loc'	  => $hc_loc_id,
									  'ttype'	  => $ttype,
									  'tsize'	  => $tsize,
									  'coup_code' => $coup_code,
									  'coup_disc' => $coup_disc,
									  'events'    => $reg_events,
									  'note_to_admin' => $note_to_admin
								)
						   );

					$this->session->unset_userdata('paytm_session');
					$this->session->unset_userdata('menu_items');

					$this->session->set_userdata($arr);
					//$this->session->set_userdata($arr1);
					//$this->session->set_userdata($temp_arr);
					//$_SESSION['paytm_session'] = '888788';
				}
				/*echo "<pre>";
				print_r(json_decode($this->session->userdata('paytm_session')));
				exit;*/
				//$PAYTM_CALLBACK_URL = $returnURL;

		// redirect('league/test_func1/'.$tid);
		 require_once(APPPATH . "/third_party/paytm/config_paytm.php");
		 require_once(APPPATH . "/third_party/paytm/encdec_paytm.php");

		 $paramList["MID"]		 = PAYTM_MERCHANT_MID;
		 $paramList["ORDER_ID"] = $tid.'_'.$this->logged_user.'_'.rand(1,10000000);
		// $paramList["ORDER_ID"]  = $tid.'_'.$this->logged_user;
		 $paramList["CUST_ID"]   = $this->logged_user;
		 $paramList["INDUSTRY_TYPE_ID"] = 'Retail';
		 $paramList["CHANNEL_ID"] = 'WEB';
		 $paramList["TXN_AMOUNT"] = $txt_amount;
		 $paramList["WEBSITE"]	  = PAYTM_MERCHANT_WEBSITE;
		 $paramList["CALLBACK_URL"] = PAYTM_CALLBACK_URL;

/* ***************************** */
 header("Pragma: no-cache");
 header("Cache-Control: no-cache");
 header("Expires: 0");

 // following files need to be included

 $checkSum  = "";
// $paramList = array();

 $CUST_ID    = $this->logged_user;
 $TXN_AMOUNT = $this->input->post('tour_fee');

// Create an array having all required parameters for creating checksum.

 /*
 $paramList["MSISDN"] = $MSISDN; //Mobile number of customer
 $paramList["EMAIL"] = $EMAIL; //Email ID of customer
 $paramList["VERIFIED_BY"] = "EMAIL"; //
 $paramList["IS_USER_VERIFIED"] = "YES"; //
 */

//Here checksum string will return by getChecksumFromArray() function.
/*echo "<pre>";
print_r($paramList);
exit;*/
 $checkSum = getChecksumFromArray($paramList, PAYTM_MERCHANT_KEY);
//echo $checkSum;
//exit;

/*echo "<pre>";
print_r($this->session->all_userdata());
exit;*/

 echo "<html>
<head>
<title>Merchant Check Out Page</title>
</head>
<body>
    <center><h1>Please do not refresh this page...</h1></center>
        <form method='post' action='".PAYTM_TXN_URL."' name='f1'>
<table border='1'>
 <tbody>";

 foreach($paramList as $name => $value) {
 echo '<input type="hidden" name="'.$name.'" value="'.$value.'" />';
 }

 echo "<input type='hidden' name='CHECKSUMHASH' value='".$checkSum."' />
 </tbody>
</table>
<script type='text/javascript'>
document.f1.submit();
</script>
</form>
</body>
</html>";

		}

		public function check_is_repeat(){
			$rec_id = $this->input->post('rec');
				$booking_info = $this->model_courts->check_is_repeat($rec_id);
				$is_repeat = 0;
			if($booking_info and $booking_info['is_repeat']){
				$is_repeat = 1;
			}

			echo $is_repeat;
		}

		public function cancel_booking(){
			$rec_id = $this->input->post('rec');
			//$del_all = $this->input->post('del_all');

			//echo $rec_id."-  ".$del_all; 			exit;
			//echo $this->logged_user. ' '.$this->academy_admin;
			if($rec_id and ($this->logged_user == $this->academy_admin)){
				$booking_info = $this->model_courts->delete_booking($rec_id);

				if($booking_info){
					$get_loc			= $this->general->get_onerow('Academy_Court_Locations', 'loc_id', $booking_info['loc_id']);
					$get_court		= $this->general->get_onerow('Academy_Courts', 'court_id', $booking_info['court_id']);
					$get_club		= $this->general->get_onerow('Academy_Info', 'Aca_ID', $get_loc['org_id']);
					$get_user		= $this->general->get_onerow('Users', 'Users_ID', $booking_info['reserved_by']);
					$get_club_admin = $this->general->get_onerow('Users', 'Users_ID', $get_club['Aca_User_id']);
	
				$mes = "This is to inform you that, your court reservation at (<b>".$get_court['court_name']."</b>) on (<b>".date('m-d-Y H:i', strtotime($booking_info['from_time']))." - ".date('m-d-Y H:i', strtotime($booking_info['from_to']))."</b>) has been canceled by Admin.";

				$notif_mes = "This is to inform you that, your court reservation at (".$get_court['court_name'].") on (".date('m-d-Y H:i', strtotime($booking_info['from_time']))." - ".date('m-d-Y H:i', strtotime($booking_info['to_time'])).") has been canceled by Admin.";

					$data = array(
								'to_name'		=> $get_user['Firstname']." ".$get_user['Lastname'],
								'from_name'	=> $get_club['Aca_name'],
								'to_email'		=> $get_user['EmailID'],
								'reply_to'	 => $get_club_admin['EmailID'],
								'message'	 => $mes,
								'page'			 => 'Court booking Cancel - Admin'
								);
					//echo "<pre>"; print_r($data);
					$send_mail = $this->send_email_notif($data);

					//Mobile Notifications
					$get_user_token = $this->model_courts->get_userToken($booking_info['reserved_by']);
//echo "<pre>"; print_r($get_user_token); exit;
					if($get_user_token){
						foreach($get_user_token as $i => $ut){
							// echo $ut->token; exit;
							$regId					= $ut->token;
							$mobile_notif	= $this->contactMessage_pushNotif($notif_mes, $regId, $get_club['Aca_User_id'], $booking_info['reserved_by'], $get_club['Aca_name'], $get_loc['org_id']);
							//$r						= json_decode($mobile_notif);
						}
					}

				}
				else{
					echo "Something went wrong!";
				}
			}
			else{
				echo "Invalid Access!";
				exit;
			}
		}

		public function send_email_notif($data){
				$from_email = "admin@a2msports.com";
				$from_name  = $data['from_name'];
		
				$sender_email	= $data['reply_to'];
				$to_email			= $data['to_email'];

				//$sender
				$this->load->library('email');
				$this->email->set_newline("\r\n");
				$this->email->from($from_email, $from_name);
				$this->email->reply_to($sender_email);
				$this->email->to($to_email);				
				$this->email->subject('Court Cancelation Update - '.$from_name);
				$body = $this->load->view('view_email_template.php', $data, TRUE);
				$this->email->message($body);   
				$res = $this->email->send();
		}

	
public function contactMessage_pushNotif($message, $token, $from, $to, $from_name, $club_id){
					$url		= 'https://exp.host/--/api/v2/push/send';
					$title	=	$from_name;
					$payload = array(
										'to'		  => $token,
										'sound' => 'default',
										'title'	  => $title,
										/*'subtitle'=> 'Subtitle Club Notification',*/
										'body'	  => $message);

//echo "<pre>"; print_r($payload); exit;
					$curl = curl_init();

					curl_setopt_array($curl, array(
									CURLOPT_URL => $url,
									CURLOPT_RETURNTRANSFER => true,
									CURLOPT_ENCODING	 => "",
									CURLOPT_MAXREDIRS => 10,
									CURLOPT_TIMEOUT		 => 30,
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
					$response  = curl_exec($curl);
					$err				= curl_error($curl);

					curl_close($curl);
					$res = json_decode($response, true);

						$send_stat = 0;
					if($res['data']['status'] == 'ok')
						$send_stat = 1;

					$json_mes = '{"to": "'.$token.'", "title": "'.$title.'", "body": "'.$message.'", "data": {"message_content": "'.$message.'", "type": "CLUB_NOTIFICATION", "sender_user_id": '.$from.'}}';

					$data = array(
						'Sender'		 => $from,
						'Recipient'  => $to,
						'Club_ID'	=> $club_id,
						'Message'	=> $message,
						'Json_Message' => $json_mes,
						'Send_Status'	=> $send_stat,
						'Read_Status'	=> 0,
						'Sent_On'			=> date('Y-m-d H:i'),
						'Expo_Token'		=> $token,
						'Notif_Type'		=> 'Notification',
						);
//echo "<pre>"; print_r($data); exit;
			$this->model_courts->insert_notif($data);
	}

	}