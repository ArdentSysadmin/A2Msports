<?php defined('BASEPATH') OR exit('No direct script access allowed');
require(APPPATH.'/libraries/REST_Controller.php');


// This can be removed if you use __autoload() in config.php OR use Modular Extensions
/** @noinspection PhpIncludeInspection */
//require APPPATH . 'libraries/REST_Controller.php';

/**
 * This is an example of a few basic user interaction methods you could use
 * all done with a hardcoded array
 *
 * @package         CodeIgniter
 * @subpackage      Rest Server
 * @category        Controller
 * @author          Phil Sturgeon, Chris Kacerguis
 * @license         MIT
 * @link            https://github.com/chriskacerguis/codeigniter-restserver
 */
//class Scores extends REST_Controller {
class League extends REST_Controller {

    public function __construct() {
        // Construct the parent class
        parent::__construct();

		$this->load->model('score/model_league','mleague');
		$this->load->model('score/model_user','muser');
		$this->load->model('score/model_general','general');
    }
/*
{
	"Registered": 1,
	"Sportname": "Table Tennis",
	"tournament_ID": 1321,
	"TournamentImage": "",
	"StartDate": "2020-05-09T09:00:00.000Z",
	"EndDate": "2020-05-09T20:00:00.000Z",
	"TournamentCountry": "United States of America",
	"TournamentState": "Georgia",
	"TournamentCity": "Cumming",
	"tournament_title": "A2M Table Tennis Open",
	"SportsType": 2,
	"latitude": 0,
	"longitude": 0,
}
*/
	public function is_valid_league($tourn_id){
		$tourn_det = $this->mleague->getonerow($tourn_id);
		if(!$tourn_det){
			$this->response(array('Error: '."Invalid League!"));
			exit;
		}
		else{
			return $tourn_det;
		}
	}

	public function events_get() {
		$tourn_id = $this->input->get('tourn_id');

		if($tourn_id) {
			$get_tourn = $this->mleague->get_league_details($tourn_id);
			if($get_tourn){
				$events	   = $get_tourn['Multi_Events'];
				if($events) {
					$events	= json_decode($events);
					$res = $this->format_events($events);
				}
				else if($get_tourn['tournament_format'] == 'Teams'){
				$res = array('Error: '."Team Leagues doesn't have Events List");
				}
				else {
				$res = array('Error: '."No Events are specified");
				}
			}
			else{
			$res = array('Error: '."Invalid Tournament!");
			}
		}
		else {
			$res = array('Error: '."Tournament ID is required!");
		}

		$this->response($res);
	}

	public function register_get() {

		$tourn_id = $this->input->get('tourn_id');

		if($tourn_id) {
			$tour_details = $this->mleague->get_league_details($tourn_id);
			
			if(count($tour_details) > 0) {

				$now		= time();
				$reg_close  = strtotime(date('Y-m-d',strtotime($tour_details['Registrationsclosedon'])));
				$reg_open   = strtotime(date('Y-m-d',strtotime($tour_details['Registrations_Opens_on'])));

				/*if($now > $reg_close) {
					$res = array('Error: ' . "Registrations are closed for this tournament!");
					$this->response($res);
					exit;
				}
				else if($now <= $reg_open) {
				*/
				
				$data['is_registration_closed'] = false;

				if($now > $reg_close) {
					$data['is_registration_closed'] = true;
				}

				if($now <= $reg_open) {
					$res = array('Error: ' . "Registrations are not yet opened for this tournament!");
					$this->response($res);
					exit;
				}

				$tformat	  = $tour_details['tournament_format'];
				$tourn_events = json_decode($tour_details['Multi_Events'], true);

				if($tformat == 'Individual') {
					$user_id	    = $this->input->get('user_id');
					$check_register = $this->mleague->is_registered($user_id, $tourn_id, 'Indv');

					//if(count($check_register) == 0) {
					$user_reg_events = null;
					if(count($check_register) > 0) {
						$user_reg_events = json_decode($check_register['Reg_Events'], true);
					}

					$user_details = $this->muser->get_user_details($user_id);
					
						if(count($user_details) > 0) {
							$user_db_age_grp  = $user_details['UserAgegroup'];
							$user_gender  = $user_details['Gender'];

/* ****************** */
							$user_dob    = $user_details['DOB'];
							$birthdate	 = new DateTime($user_dob);
							$today		 = new DateTime('today');
							$user_age    = $birthdate->diff($today)->y;
							$user_age_grp = "";

        switch ($user_age) {
                case $user_age <= 10:
                   $user_age_grp = "U10";
                   break;
                case $user_age == 11:
                   $user_age_grp = "U11";
                   break;
                case $user_age == 12:
                   $user_age_grp = "U12";
                   break;
                case $user_age == 13:
                   $user_age_grp = "U13";
                   break;
                case $user_age == 14:
                   $user_age_grp = "U14";
                   break;
                case $user_age == 15:
                   $user_age_grp = "U15";
                   break;
                case $user_age == 16:
	               $user_age_grp = "U16";
	               break;
                case $user_age == 17:
                   $user_age_grp = "U17";
                   break;
                case $user_age == 18:
                   $user_age_grp = "U18";
                   break;
                case $user_age == 19:
                   $user_age_grp = "U19";
                   break;
                case $user_age>19 && $user_age<=29:
                   $user_age_grp = "Adults";
                   break;
                case $user_age>=30 && $user_age<=39:
                   $user_age_grp = "Adults_30p";
                   break;
                case $user_age>=40 && $user_age<=49:
                   $user_age_grp = "Adults_40p";
                   break;
                case $user_age>=50 && $user_age<=60:
                   $user_age_grp = "Adults_50p";
                   break;
        }

/* ****************** */

							if($user_age_grp == NULL) {
								$res = array('Error: ' . "User Date of birth not provided!");
								$this->response($res);
								exit;
							}

							$user_el_events = $this->get_eligible_events($tourn_events, $user_age_grp, $user_db_age_grp, $user_gender);

							$data['Tournament_Title'] = $tour_details['tournament_title'];
							$data['Sport']			  = $tour_details['SportsType'];
							/*$data['Country']		  = ($tour_details['TournamentCountry'] == 'India') 
														? 'IN' : $tour_details['TournamentCountry'];*/

							$data['Country']		  = $tour_details['TournamentCountry'];

							$data['Events']			  = $user_el_events;
							$data['Registered_Events'] = $user_reg_events;

							if($tour_details['SportsType'] == 2){
								//$data['usatt_rating_eligibility_date'] = date('m-d-Y', strtotime($tour_details['EligibilityDate']));
								$get_usatt_id		   = $this->muser->get_usatt_id($user_id);
								$data['usatt_id']	   = $get_usatt_id;
								if($get_usatt_id){
									$get_usatt_rating	   = $this->muser->get_usatt_rating($get_usatt_id);
									$data['usatt_rating']  = $get_usatt_rating;
								}
								else{
									$data['usatt_rating']  = 'n/a';
								}
							}

							$data['is_tshirt']		  = $tour_details['TShirt'];
							$data['is_fee']		      = $tour_details['Tournamentfee'];
							$data['is_agegroup_fee']  = json_decode($tour_details['is_mult_fee'], TRUE);
							$data['age_groups']		  = json_decode($tour_details['Age'], TRUE);

							$data['fee']			  = json_decode($tour_details['mult_fee_collect'], TRUE);
							$data['additional_fee']   = json_decode($tour_details['addn_mult_fee_collect'], TRUE);
							$arr = array();

							foreach($data['age_groups'] as $i => $ag){
								$arr[$ag] = array(
									'fee'			 => $data['fee'][$i],
									'additional_fee' => $data['additional_fee'][$i]
									); 
							}
							
							$data['age_based_fee']	  = $arr;
							$data['is_event_fee']     = $tour_details['is_event_fee'];
							$data['fee_event_based']  = json_decode($tour_details['Event_Reg_Fee'], TRUE);

							$data['is_event_limited'] = ($tour_details['Event_Reg_Limit'] != null) ? 1 : 0;
							$data['event_limits']     = json_decode($tour_details['Event_Reg_Limit'], TRUE);
							//$data['event_time']       = json_decode($tour_details['Multi_Event_Time'], TRUE);

							/*$data['paytm_merchant_id']  = null;
							$data['paypal_merchant_id'] = null;*/

									//$data['payment_method']  = null;

									//if($data['is_fee']){
									//	if($tour_details['TournamentCountry'] == 'India') {
										   /*$get_det = $this->muser->get_paytm($tour_details['Merchant_Paytm']);
											$data['paytm_merchant_id'] = $get_det['paytm_merch_id'];*/
									//		$data['payment_method']  = 3;
									//	}
									//	else {
										   /*$get_det = $this->muser->get_paypal($tour_details['Merchant_Paypal']);
											$data['paypal_merchant_id'] = $get_det['paypal_merch_id'];*/
									//		$data['payment_method']  = 1;
									//	}
									//}

									$$pay_mode		 = null;
									$payment_method  = null;

									if($data['is_fee']) {
										if($tour_details['TournamentCountry'] == 'India') {
											$pay_mode = 'paytm';
											if($tour_details['Merchant_Paytm']){
											 //$get_det = $this->muser->get_paytm($tour_details['Merchant_Paytm']);
											 //$payment_method = $get_det['paytm_merch_id'];
											 $payment_method = $tour_details['Merchant_Paytm'];
											}
											else{
											 $payment_method = 1;
											}
										}
										else {
											$pay_mode = 'paypal';
											if($tour_details['Merchant_Paypal']) {
										     //$get_det = $this->muser->get_paypal($tour_details['Merchant_Paypal']);
											 //$payment_method = $get_det['paypal_merch_id'];
											 $payment_method = $tour_details['Merchant_Paypal'];
											}
											else{
											 $payment_method = 5;
											}
										}


									}

							$data['paymethods'] = array(array('pay_method'	 => $pay_mode, 
															  'reference_id' => $payment_method));
					
							$res = array($data);
						}
						else {
							$res = array('Error: ' . "Invalid User ID!");
						}
					//}
					/*else {
						$res = array('Error: ' . "User is already registered for this tournament!");
					}*/

				}
				else if($tformat == 'Teams') {
					$user_id		= $this->input->get('user_id');
					$check_register = $this->mleague->is_user_team_registered($user_id, $tourn_id, 'Team');

					if(count($check_register) == 0) {
					$get_user_teams_1 = $this->muser->get_user_captain_teams($user_id, $tourn_id, $tour_details['SportsType']);
					
						foreach($get_user_teams_1 as $res){
							$tp = json_decode($res->Players, TRUE);
							foreach($tp as $player){
								$u_det				 = $this->muser->get_user_details($player);
								$tplayers_1[] = array('id' => $player, 'name' => $u_det['Firstname'] . " " . $u_det['Lastname']);
							}

							$user_teams[] = array(
												'Team_ID'	   => $res->Team_ID, 
												'Team_name'	   => $res->Team_name,
												'Role'		   => 'Captain',
												'Team_Players' => $tplayers_1
											);
						}

					$get_user_teams_2 = $this->muser->get_user_non_captain_teams($user_id, $tourn_id, $tour_details['SportsType']);
					
						foreach($get_user_teams_2 as $res){
							
							$u_det				 = $this->muser->get_user_details($user_id);
							$tplayers_2	  = array();
							$tplayers_2[] = array('id' => $user_id, 'name' => $u_det['Firstname'] . " " . $u_det['Lastname']);

							$user_teams[] = array(
												'Team_ID'	   => $res->Team_ID, 
												'Team_name'	   => $res->Team_name,
												'Role'		   => 'Player',
												'Team_Players' => $tplayers_2
											);
						}

						$data['Tournament_Title'] = $tour_details['tournament_title'];
						$data['Sport']			  = $tour_details['SportsType'];
						$data['is_fee']		      = $tour_details['Tournamentfee'];
						$data['user_teams']		  = $user_teams;
						$data['is_agegroup_fee']  = json_decode($tour_details['is_mult_fee'], TRUE);
						$data['age_groups']		  = json_decode($tour_details['Age'], TRUE);
						$level_array			  = json_decode($tour_details['Sport_levels'], TRUE);

						foreach($level_array as $la){
							$level_name = $this->mleague->get_level_name($la);
							$levels[$la] = $level_name['SportsLevel'];
						}
						$data['levels']			  = $levels;

						$data['fee']			  = json_decode($tour_details['mult_fee_collect'], TRUE);
						$data['additional_fee']   = json_decode($tour_details['addn_mult_fee_collect'], TRUE);

						$res = array($data);
					}
					else {
						$res = array('Error: ' . "Player is already registered for this tournament!");
					}
				}
			}
			else {
				$res = array('Error: ' . "Invalid Tournament ID!");
			}
		}
		else {
			$res = array('Error: ' . "Tournament ID is required!");
		}


	$this->response($res);
	}

	public function register_post() {

		//$this->response($this->post());
		//exit;

		$post_data = json_decode(trim(file_get_contents('php://input')), true);

			/*print_r($post_data);
			$this->response($post_data); 
			exit;*/

			if($post_data){
			//print_r($post_data);
			//	$this->response($post_data); 
			}
			else{
			$this->response(array('Error: ' . "Empty!")); 
			//exit;
			}
			//exit;

		$tourn_id		 = $post_data['tourn_id'];
		$user_id		 = $post_data['user_id'];

		$fee_amount		 = $post_data['fee_amount'];
		$gateway_charges = $post_data['gateway_charges'];
		$transaction_id  = $post_data['transaction_id'];
		$currency_code	 = $post_data['currency_code'];
		$status			 = $post_data['status'];
		$tshirt_size	 = $post_data['tshirt_size'];
		$note_to_admin	 = $post_data['note_to_admin'];

		$tourn_id		 = trim($tourn_id, '"');
		$tshirt_size	 = trim($tshirt_size, '"');

		//$tt				 = gettype($tourn_id);

		/*$data['tid']	= $tourn_id;
		$data['ttype']  = $tt;
		$data['tdate']  = date('Y-m-d H:i:s');
			$this->mleague->ins_temp($data);*/
		

		$tour_details	 = $this->mleague->get_league_details($tourn_id);
				//	$this->response($tour_details); exit;

		if(count($tour_details) > 0) {
			$data = array();
			$data['Tournament_ID']	 =  (int)$tourn_id;
			if($fee_amount)
			$data['Fee']			 =  number_format($fee_amount, 2);
			if($transaction_id)
			$data['Transaction_id']  =  $transaction_id;
			if($gateway_charges)
			$data['Gateway_Charges'] =  $gateway_charges;
			if($status)
			$data['Status']			 =  $status;
			if($currency_code)
			$data['Currency_Code']	 =  $currency_code;
			if($tshirt_size)
			$data['TShirt_Size']	 =  $tshirt_size;
			$data['Reg_date']		 =  date("Y-m-d H:i:s");

			$tformat = $tour_details['tournament_format'];
			$ttype	 = $tour_details['Tournament_type'];
			
			if($tformat == "Teams" or $tformat == "TeamSport") {
				$team_id		  = $post_data['team_id'];
				$shortlisted_team = $post_data['shortlisted_team'];
				$reg_ag_group	  = $post_data['reg_ag_group'];
				$reg_sport_level  = $post_data['reg_sport_level'];

				$data['Team_id']		 =  $team_id;
				$data['Team_Players']	 =  json_encode($shortlisted_team);
				$data['Reg_Age_Group']	 =  $reg_ag_group;
				$data['Reg_Sport_Level'] =  $reg_sport_level;
				
				$check_register = $this->mleague->is_registered($team_id, $tourn_id, 'Team');
			}
			else {
				$reg_events	= $post_data['reg_events'];
				if($reg_events){
					$partners			= $post_data['partners'];
					$data['Reg_Events']	=  json_encode($reg_events);
					if($partners)
					$data['Partners']	=  json_encode($partners);
					$data['Users_ID']	=  (int)$user_id;

					$check_register = $this->mleague->is_registered($user_id, $tourn_id, 'Indv');
				}
				else{
					$res = array('Error: ' . "Registered events should not be empty!");
					$this->response($res);
					exit;
				}

			}
			
			if($ttype == 'Flexible League') {
				$hcl_id			= $post_data['hcl_id'];
				$data['hcl_id']	= $hcl_id;
			}
			
			if(count($check_register) == 0) {

			$ins = $this->mleague->inset_reg_tourn($data);
			$res = array('Success: ' . "User / Team successfully registered.");

			$dev_email	 = "pradeepkumar.namala@gmail.com";
			$dev_subject = "A2M Mobile Post variables - Production";
			$data2		 = array(
						'firstname'	=> "Developer",
						'post_vals'	=> print_r($data, true),
						'page'		=> 'A2M Mobile Post');

			$this->email_to_player($dev_email, $dev_subject, $data2);

			//$res = array($data);
			}
			else {
			//res = array('Error: ' . "User / Team already Registered for this tournament!");
			$get_reg_events = $this->mleague->get_reg_events($user_id, $tourn_id);
			
			if($get_reg_events['Reg_Events']){
				$prev_reg_events = json_decode($get_reg_events['Reg_Events'], true);
				foreach($reg_events as $new_ev){
					if(!in_array($new_ev, $prev_reg_events)){
						array_push($prev_reg_events, $new_ev);
					}
				}
			}

			$data3['upd_events']	= json_encode($prev_reg_events);
			$data3['Tournament_ID'] = $data['Tournament_ID'];
			$data3['Users_ID']		= $data['Users_ID'];

			$data2['Tournament_ID'] = $data['Tournament_ID'];
			$data2['pay_date']  = date('Y-m-d H:i:s');
			$data2['pay_date']  = $data['Tournament_ID'];
			$data2['Users_ID']  = $data['Users_ID'];
			$data2['mtype']	    = 'tournament';
			$data2['mtype_ref'] = $data['Tournament_ID'];
			$data2['Amount']	= number_format($fee_amount, 2);;
			$data2['Transaction_id'] = $transaction_id;
			$data2['Status']	= $status;

			$upd	 = $this->mleague->update_reg_tourn($data3);
			$ins_pay = $this->mleague->insert_pay_transaction($data2);

			$res = array('Success: ' . "User / Team successfully registered.");

			}
		}
		else {
			$res = array('Error: ' . "Invalid Tournament ID!");
		}


		if($res) {
			$this->response($res);
		}
	}

	public function email_to_player($to_email, $subject, $data){	
		$this->load->library('email');
		$this->email->set_newline("\r\n"); 
		$this->email->from(FROM_EMAIL, 'A2MSports');
		$this->email->to($to_email);
		$this->email->subject($subject);

		$body = $this->load->view('view_email_template.php', $data, TRUE);

		$this->email->message($body);   
		$this->email->send();
	}

	public function format_events($events){
		$processed_events = array();
		foreach($events as $event){
			$exp = explode("-", $event);
			$lv		= end($exp);
			$temp	= $event;

			$level_name  = $this->mleague->get_level_name($lv);
			$level_title = $level_name['SportsLevel'];
			$event_lable = str_replace($lv, $level_title, $temp);
			$event_lable = str_replace("-1-", "-Men's-", $event_lable);
			$event_lable = str_replace("-0-", "-Women's-", $event_lable);
			$event_lable = str_replace("Adults-", "", $event_lable);

			$processed_events[trim($event)] = $event_lable;	
		}

		return $processed_events;
	}

	public function get_eligible_events($tourn_events, $user_ag_grp, $user_db_age_grp, $user_gender) {
		$eligible_events	 = array();
		$non_eligible_events = array();

		foreach($tourn_events as $event) {
			$exp = explode("-", $event);

			$lv		= end($exp);
			$temp	= $event;

			$level_name  = $this->mleague->get_level_name($lv);
			$level_title = $level_name['SportsLevel'];

			$event_lable = str_replace($lv, $level_title, $temp);
			$event_lable = str_replace("Adults-", "", $event_lable);
			$event_lable = str_replace("1-", "Men's-", $event_lable);
			$event_lable = str_replace("0-", "Women's-", $event_lable);

		
			if ((in_array($user_ag_grp, $exp) 
			or in_array($user_db_age_grp, $exp)) 
			and (($exp[0] == $user_ag_grp 
			or $exp[0] == $user_db_age_grp) 
			or $exp[0] == 'Open' 
			or $exp[1] == 'Open')) {
				if(in_array($exp[1], array('0','1'))) {
					if($user_gender == $exp[1] or in_array('Mixed', $exp)) {
						$eligible_events[trim($event)] = $event_lable;	
					}
					else {
						$non_eligible_events[trim($event)] = $event_lable;	
					}
				}
				else {
				  $eligible_events[trim($event)] = $event_lable;
				}
			}
			else if(in_array('Mixed', $exp)) {
				 $eligible_events[trim($event)] = $event_lable;
			}
			else if($user_ag_grp == 'U10' or $user_ag_grp == 'U11' or $user_ag_grp == 'U12' or $user_ag_grp == 'U13' or $user_ag_grp == 'U14' or $user_ag_grp == 'U15' or $user_ag_grp == 'U16' or $user_ag_grp == 'U17' or $user_ag_grp == 'U18' or $user_ag_grp == 'U19' or $user_ag_grp == 'Junior') {
				if($exp[0] == 'Adults'){
				 $eligible_events[trim($event)] = $event_lable;
				}
			}
			else {
				 $non_eligible_events[trim($event)]  = $event_lable;
			}

		}

		return array('eligible' => $eligible_events, 'non_eligible' => $non_eligible_events);
	}

	public function paytmSuccess_post(){
			$paytm_return = $_REQUEST;
			
			if($paytm_return['STATUS'] == 'TXN_SUCCESS') {
				$txn  = $paytm_return['TXNID'];
				$stat = 'true';
			}
			else {
				$txn  = '0';
				$stat = 'false';
			}

			$html  = "<html>";
			$html .= "<title>".$stat.",".$txn."</title>";
			$html .= "</html>";

		echo $html;
	}

	public function paytmChecksum_get(){

		$tid		= $this->input->get('tourn_id');
		$user_id	= $this->input->get('user_id');
		$txn_amount = $this->input->get('amount');

		$tour_det   = $this->mleague->get_league_details($tid);
		
		if(!$tid or !$user_id or !$txn_amount){
			$res = array('Error: '."Please provide all the information (TournID, UserID, Amount)");
			$this->response($res);
			exit;
		}
	
		if($tour_det){

			if(($tour_det['Merchant_Paytm'] == NULL or 
				$tour_det['Merchant_Paytm'] == 'NULL') and 
				$tour_det['TournamentCountry'] != 'India'){

				$res = array('Error: '."This league should not be paid with Paytm!");
				$this->response($res);
				exit;
			}

			if($tour_det['Merchant_Paytm']){
				$get_det = $this->muser->get_paytm($tour_det['Merchant_Paytm']);
			}
			else{
				$get_det = $this->muser->get_paytm('1');
			}
	
		$PAYTM_MERCHANT_MID = $get_det['paytm_merch_id'];
		$PAYTM_MERCHANT_KEY = $get_det['paytm_merchant_key'];

		 require_once(APPPATH . "/third_party/paytm/config_paytm.php");
		 require_once(APPPATH . "/third_party/paytm/encdec_paytm.php");

		 $order_id = $tid.'_'.$user_id.'_'.rand(1,10000000);
		 $merch_id = PAYTM_MERCHANT_MID;

		 $paramList["MID"]		 = $merch_id;
		 $paramList["ORDER_ID"]  = $order_id;
		 $paramList["CUST_ID"]   = $user_id;
		 $paramList["INDUSTRY_TYPE_ID"] = 'Retail';
		 //$paramList["CHANNEL_ID"] = 'WEB';
		 $paramList["CHANNEL_ID"] = 'WAP';
		 $paramList["TXN_AMOUNT"] = $txn_amount;
		 $paramList["WEBSITE"]	    = PAYTM_MERCHANT_WEBSITE;
		 //$paramList["WEBSITE"]	    = 'WEBSTAGING';
		 //$paramList["CALLBACK_URL"] = PAYTM_CALLBACK_URL;
		 $paramList["CALLBACK_URL"] = 'https://a2msports.com/rest_services/league/paytmSuccess';

		 $checkSum = "";
		 $checkSum = getChecksumFromArray($paramList, PAYTM_MERCHANT_KEY);

		  $htmlForm = "<html><head><title>Merchant Check Out Page</title></head><body><center><h1>Please do not refresh this page...</h1></center><form method='post' action='".PAYTM_TXN_URL."' name='f1'><table border='1'><tbody>";

			 foreach($paramList as $name => $value) {
			 $htmlForm .= '<input type="hidden" name="'.$name.'" value="'.$value.'" />';
			 }

$htmlForm .= "<input type='hidden' name='CHECKSUMHASH' value='".$checkSum."' /></tbody></table><script type='text/javascript'>
document.f1.submit();</script></form></body></html>";


		/*$data['MID']		= PAYTM_MERCHANT_MID;
		$data['ORDER_ID']	= $order_id;
		$data['CUST_ID']	= $user_id;
		$data['TXN_AMOUNT'] = $txn_amount;
		$data['CHECKSUMHASH'] = $checkSum;*/
		$data['htmlForm'] = $htmlForm;

		$res = array($data);	
		//$this->response($res);
		echo $htmlForm;
		}
		else{
			$res = array('Error: '."Invalid Tournament!");
			$this->response($res);
		}

	}

	public function paypalChecksum_get(){

		$tid		= $this->input->get('tourn_id');
		$user_id	= $this->input->get('user_id');
		$txn_amount = $this->input->get('amount');

		$tour_det   = $this->mleague->get_league_details($tid);
		
		if(!$tid or !$user_id or !$txn_amount){
			$res = array('Error: '."Please provide all the information (TournID, UserID, Amount)");
			$this->response($res);
			exit;
		}
	
		if($tour_det){

			$this->load->library('paypal_lib');

			/*if(($tour_det['Merchant_Paypal'] == NULL or 
				$tour_det['Merchant_Paypal'] == 'NULL') and 
				$tour_det['TournamentCountry'] != 'India'){

				$res = array('Error: '."This league should not be paid with Paytm!");
				$this->response($res);
				exit;
			}*/

			if($tour_det['Merchant_Paypal']){
				$get_det = $this->muser->get_paypal($tour_det['Merchant_Paypal']);
			}
			else{
				$get_det = $this->muser->get_paypal('5');
			}
				$paypalID = $get_det['paypal_merch_id'];
				$logo = base_url().'images/logo.png';
				$returnURL = 'https://a2msports.com/rest_services/league/paypalSuccess';
				$cancelURL = 'https://a2msports.com/rest_services/league/paypalCancel';
	
				$this->paypal_lib->add_field('business', $paypalID);
				$this->paypal_lib->add_field('return', $returnURL);
				$this->paypal_lib->add_field('cancel_return', $cancelURL);
				//$this->paypal_lib->add_field('notify_url', $notifyURL);
				$this->paypal_lib->add_field('tourn_id', $tid);
				//$this->paypal_lib->add_field('player', $this->logged_user);
				$this->paypal_lib->add_field('on0', $user_id);
				$this->paypal_lib->add_field('item_number',  $tid);
				$this->paypal_lib->add_field('item_name',  $tour_det['tournament_title']);
				$this->paypal_lib->add_field('amount', $txn_amount);        
				//$this->paypal_lib->image($logo);
				
				$htmlForm = $this->paypal_lib->paypal_api_form();


		/*$data['MID']		= PAYTM_MERCHANT_MID;
		$data['ORDER_ID']	= $order_id;
		$data['CUST_ID']	= $user_id;
		$data['TXN_AMOUNT'] = $txn_amount;
		$data['CHECKSUMHASH'] = $checkSum;*/
		$data['htmlForm'] = $htmlForm;

		$res = array($data);	
		//$this->response($res);
		echo $htmlForm;
		}
		else{
			$res = array('Error: '."Invalid Tournament!");
			$this->response($res);
		}
	}

	public function paypalSuccess_post(){

			//$data['item_number']	= $this->input->get('item_number');

			if($this->input->get('tx')){
			$txn_id	= $this->input->get('tx');
			}
			else{
			$txn_id = $this->input->get('token');
			}

			
			if($this->input->get('st') == 'Completed') {
				$txn  = $txn_id;
				$stat = 'true';
			}
			else {
				$txn  = '0';
				$stat = 'false';
			}

			$html  = "<html>";
			$html .= "<title>".$stat.",".$txn."</title>";
			$html .= "</html>";

		echo $html;
	}

	public function paypalCancel_post(){
		$html = "Last Transaction is cancelled";
		echo $html;
	}

public function testpaypalChecksum_get(){

		$tid		= $this->input->get('tourn_id');
		$user_id	= $this->input->get('user_id');
		$txn_amount = $this->input->get('amount');

		$tour_det   = $this->mleague->get_league_details($tid);
		
		if(!$tid or !$user_id or !$txn_amount){
			$res = array('Error: '."Please provide all the information (TournID, UserID, Amount)");
			$this->response($res);
			exit;
		}
	
		if($tour_det){

			$this->load->library('paypal_lib');

			/*if(($tour_det['Merchant_Paypal'] == NULL or 
				$tour_det['Merchant_Paypal'] == 'NULL') and 
				$tour_det['TournamentCountry'] != 'India'){

				$res = array('Error: '."This league should not be paid with Paytm!");
				$this->response($res);
				exit;
			}*/

				$get_det = $this->muser->get_paypal('8');
			
				$paypalID = $get_det['paypal_merch_id'];
				$logo = base_url().'images/logo.png';
				$returnURL = 'https://a2msports.com/rest_services/league/paypalSuccess';
				$cancelURL = 'https://a2msports.com/rest_services/league/paypalCancel';
	
				$this->paypal_lib->add_field('business', $paypalID);
				$this->paypal_lib->add_field('return', $returnURL);
				$this->paypal_lib->add_field('cancel_return', $cancelURL);
				//$this->paypal_lib->add_field('notify_url', $notifyURL);
				$this->paypal_lib->add_field('tourn_id', $tid);
				//$this->paypal_lib->add_field('player', $this->logged_user);
				$this->paypal_lib->add_field('on0', $user_id);
				$this->paypal_lib->add_field('item_number',  $tid);
				$this->paypal_lib->add_field('item_name',  $tour_det['tournament_title']);
				$this->paypal_lib->add_field('amount', $txn_amount);        
				//$this->paypal_lib->image($logo);
				
				$htmlForm = $this->paypal_lib->sandbox_paypal_api_form();


		/*$data['MID']		= PAYTM_MERCHANT_MID;
		$data['ORDER_ID']	= $order_id;
		$data['CUST_ID']	= $user_id;
		$data['TXN_AMOUNT'] = $txn_amount;
		$data['CHECKSUMHASH'] = $checkSum;*/
		$data['htmlForm'] = $htmlForm;

		$res = array($data);	
		//$this->response($res);
		echo $htmlForm;
		}
		else{
			$res = array('Error: '."Invalid Tournament!");
			$this->response($res);
		}
	}
	
	public function withdraw_post(){

		$post_data = json_decode(trim(file_get_contents('php://input')), true);

			/*print_r($post_data);
			$this->response($post_data); 
			exit;*/

		if(!$post_data){
			$this->response(array('Error: '."Missing Input data")); 
			exit;
		}

		$tourn_id  = $post_data['tourn_id'];
		$user_id   = $post_data['user_id'];
		$wd_events = $post_data['withdraw_events'];

		$tourn_det = $this->is_valid_league($tourn_id);
		
		if($tourn_det){
			
			if($wd_events){
				
				$get_user_reg = $this->mleague->get_user_reg($tourn_id, $user_id);
				$reg_events   = json_decode($get_user_reg['Reg_Events'], true);

				if($reg_events){
					foreach($wd_events as $ev){				
						$pos = array_search($ev, $reg_events);
						unset($reg_events[$pos]);
					}
				}

				if(!empty($reg_events)){
				$data2['upd_events']	= json_encode($reg_events);
				$data2['Tournament_ID'] = $tourn_id;
				$data2['Users_ID']		= $user_id;

				$upd_events = $this->mleague->update_reg_tourn($data2);
				}
				else{
				$del_events = $this->mleague->del_tourn_reguser($user_id, $tourn_id);
				}

				if($upd_events)
					$this->response(array('Success: '."User is successfully withdrawn from the events")); 
				else if($upd_events)
					$this->response(array('Success: '."User is successfully withdrawn from the league")); 

				//$this->response($reg_events);
			}
			else{
				$this->response(array('Error: '."Withdraw Events are missing")); 
				exit;
			}
			//$this->response(array($data)); 

		}
	}

	public function list_get(){

		$user_id = $this->input->get('user_id');
		
		if($user_id){
			$user_details	 = $this->general->get_user($user_id);
			$get_tournaments = $this->mleague->get_tournaments($user_id, $user_details['Country']);
			$tourn_list		 = null;

			if($get_tournaments){
			foreach($get_tournaments as $tr){

			if($tr->TournamentImage!=""){ $img = $tr->TournamentImage; }
			else{
				switch($tr->SportsType){
					case 1:
						$img = "default_tennis.jpg";
						break;
					case 2:
						$img = "default_table_tennis.jpg";
						break;
					case 3:
						$img = "default_badminton.jpg";
						break;
					case 4:
						$img = "default_golf.jpg";
						break;
					case 5:
						$img = "default_racquet_ball.jpg";
						break;
					case 6:
						$img = "default_squash.jpg";
						break;
					case 7:
						$img = "default_pickleball.jpg";
						break;
					case 8:
						$img = "default_chess.jpg";
						break;
					case 9:
						$img = "default_carroms.jpg";
						break;
					case 10:
						$img = "default_volleyball.jpg";
						break;
					case 11:
						$img = "default_fencing.jpg";
						break;
					case 12:
						$img = "default_bowling.jpg";
						break;
					case 16:
						$img = "default_cricket.jpg";
						break;
					default:
						//$img = "No Image";
					}
				}

				$temp = '';
				$temp = array(
				'Registered'		=> $tr->Registered,
				'tournament_ID'		=> $tr->tournament_ID,
				'tournament_title'  => $tr->tournament_title,
				'StartDate'			=> $tr->StartDate,
				'EndDate'			=> $tr->EndDate,
				'SportsType'		=> $tr->SportsType,
				'Sportname'			=> $tr->Sportname,
				'TournamentImage'	=> base_url()."tour_pictures/".$img,
				'Tournament_Format'	=> $tr->tournament_format,
				'TournamentCity'	=> $tr->TournamentCity,
				'TournamentState'	=> $tr->TournamentState,
				'TournamentCountry' => $tr->TournamentCountry,
				'latitude'			=> $tr->latitude,
				'longitude'			=> $tr->longitude
				);
				
				$tourn_list[] = $temp;
			}
			}
	
			$this->response($tourn_list);	
		}
		else{
			$this->response(array('Error: '."User ID Required!"));
			exit;
		}

	}

}