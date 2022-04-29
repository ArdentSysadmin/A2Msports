<?php defined('BASEPATH') OR exit('No direct script access allowed');
require(APPPATH.'/libraries/REST_Controller.php');
error_reporting(0);

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

		$this->load->model('score/model_league', 'mleague');
		$this->load->model('score/model_user', 'muser');
		$this->load->model('score/model_general', 'general');
    }

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
		$user_id  = $this->input->get('user_id');

		if($tourn_id) {
			$tour_details = $this->mleague->get_league_details($tourn_id);
			//echo "<pre>"; print_r($tour_details['Event_Reg_Limit']); exit;
			if(count($tour_details) > 0) {

				$now		= time();
				$reg_close   = strtotime(date('Y-m-d', strtotime($tour_details['Registrationsclosedon'])));
				$reg_open   = strtotime(date('Y-m-d', strtotime($tour_details['Registrations_Opens_on'])));
				$ref_date     = strtotime(date('Y-m-d', strtotime($tour_details['RefundDate'])));

				$reg_close  = strtotime(date('Y-m-d', strtotime($tour_details['Registrationsclosedon'])));
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
					/*$res = array('Error: ' . "Registrations are not yet opened for this tournament!");
					$this->response($res);
					exit;*/
					$data['is_registration_closed'] = true;
				}

				$data['is_withdraw_closed'] = false;

				if($now > $ref_date) {
					$data['is_withdraw_closed'] = true;
				}

				//	$is_tourn_admin = 0;
			//	if($this->input->get('user_id') == $tour_details['Usersid'])
			//		$is_tourn_admin = 1;

					//$data['is_TournAdmin'] = $is_tourn_admin;

				$tformat	  = $tour_details['tournament_format'];
				$tourn_events = json_decode($tour_details['Multi_Events'], true);

				if($tformat == 'Individual') {
					$check_register = $this->mleague->is_registered($user_id, $tourn_id, 'Indv');

					//if(count($check_register) == 0) {
					$user_reg_events = null;
					$user_partners		 = null;

					if(count($check_register) > 0) {
						$user_reg_events = json_decode($check_register['Reg_Events'], true);
						//$user_reg_events = $this->regenerate_events($user_reg_events);
						if($check_register['Partners']){
						$temp = json_decode($check_register['Partners'], true);
						
						foreach($user_reg_events as $ev => $label){
							$user = $temp[$ev];
							$temp_user = null;
							if($user){
								$det = $this->mleague->get_user_details($user);
								$temp_user = array('Firstname' => $det['Firstname'], 'Lastname' => $det['Lastname'], 'ID' => $det['Users_ID']);
							}

							$user_partners[$ev] = $temp_user;
						}
						}
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
                case $user_age <= 9:
                   $user_age_grp = "U9";
                   break;
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
								$res = array('Error: ' . "User Date of birth is not provided!");
								$this->response($res);
								exit;
							}
							$is_event_limit	   = 0;
							$get_event_limits = '';
							$events_limit_arr  = '';

							if($tour_details['Event_Reg_Limit'] != '' and $tour_details['Event_Reg_Limit'] != NULL){
							$is_event_limit	  = 1;
							$events_limit_arr = json_decode($tour_details['Event_Reg_Limit'], TRUE);
							foreach($tourn_events as $ev){
							$get_event_limits[$ev] = $this->mleague->get_event_reg_count($tourn_id, $ev);
							}
							//echo "test"; exit;
							//echo "<pre>"; print_r($get_event_limits); print_r($events_limit_arr); exit;
							//$tour_details['Event_Reg_Limit']
							}

							$user_el_events = $this->get_eligible_events($tourn_events, $user_age_grp, $user_db_age_grp, $user_gender, $user_age, $get_event_limits, $events_limit_arr);

							//StartDate, TournamentAddress, RegistrationCloseDate

							$data['Tournament_Title']  = $tour_details['tournament_title'];
							$data['Organizer']					= $tour_details['OrganizerName'];
							$data['Contact_Num']			= $tour_details['ContactNumber'];
							$data['Details']						= $tour_details['TournamentDescription'];
							$data['Sport']						= $tour_details['SportsType'];
							if($tour_details['StartDate'])
							$data['StartDate'] = date('Y-m-d', strtotime($tour_details['StartDate']))."T".date('H:i:s', strtotime($tour_details['StartDate'])).".000Z";
							else 
							$data['StartDate']					= NULL;

							if($tour_details['EndDate'])
							$data['EndDate'] = date('Y-m-d', strtotime($tour_details['EndDate']))."T".date('H:i:s', strtotime($tour_details['EndDate'])).".000Z";
							else 
							$data['EndDate']					= NULL;

							if($tour_details['Registrationsclosedon'])
							$data['RegistrationCloseDate'] = date('Y-m-d', strtotime($tour_details['Registrationsclosedon']))."T".date('H:i:s', strtotime($tour_details['Registrationsclosedon'])).".000Z";
							else 
							$data['RegistrationCloseDate'] = NULL;

	
								if($tour_details['venue'])
								$taddress = $tour_details['venue'];

							if($tour_details['TournamentAddress'] and $tour_details['venue'])
								$taddress .= ', ' . $tour_details['TournamentAddress'];
							else if($tour_details['TournamentAddress'])
								$taddress .= $tour_details['TournamentAddress'];

							if($tour_details['TournamentAddress'] and $tour_details['venue'] != $tour_details['TournamentAddress'])
								$taddress .= ", ".$tour_details['TournamentAddress'];

							if($tour_details['TournamentAddress'] and $tour_details['TournamentCity'])
								$taddress .= ", ".$tour_details['TournamentCity'];
							else
								$taddress .= $tour_details['TournamentCity'];

							if($tour_details['TournamentState'])
								$taddress .= ", ".$tour_details['TournamentState'];
							if($tour_details['TournamentCountry'])
								$taddress .= ", ".$tour_details['TournamentCountry'];
							if($tour_details['PostalCode'])
								$taddress .= ", ".$tour_details['PostalCode'];

							$data['TournamentAddress']	= $taddress;

							$data['Tournament_Format']	= $tour_details['tournament_format'];
							$data['Tournament_Type']		= $tour_details['Tournament_type'];
							$data['is_TournAdmin']			= 0;
							//if($user_id == $data['Usersid'] or $user_id == 240)
							if($user_id == $tour_details['Usersid'] or $user_id == 240)
							$data['is_TournAdmin']			= 1;

/*$data['Country']		  = ($tour_details['TournamentCountry'] == 'India') ? 'IN' : $tour_details['TournamentCountry'];*/

							$data['Country']					= $tour_details['TournamentCountry'];
							$data['Events']						= $user_el_events;
							$data['Registered_Events'] = $user_reg_events;
							$data['Partners'] = $user_partners;

							if($tour_details['SportsType'] == 2){
								//$data['usatt_rating_eligibility_date'] = date('m-d-Y', strtotime($tour_details['EligibilityDate']));
								$get_usatt_id		   = $this->muser->get_usatt_id($user_id);
								$data['usatt_id']	   = $get_usatt_id;
								if($get_usatt_id){
									$get_usatt_rating		  = $this->muser->get_usatt_rating($get_usatt_id);
									$data['usatt_rating']  = $get_usatt_rating;
								}
								else{
									$data['usatt_rating']  = 'n/a';
								}
							}

							$data['is_tshirt']				 = $tour_details['TShirt'];
							$data['is_fee']					 = $tour_details['Tournamentfee'];
							$data['is_agegroup_fee']	 = json_decode($tour_details['is_mult_fee'], TRUE);

							$data['age_groups']			= json_decode($tour_details['Age'], TRUE);
							$data['fee']						= json_decode($tour_details['mult_fee_collect'], TRUE);
							$data['additional_fee']	= json_decode($tour_details['addn_mult_fee_collect'], TRUE);

							$arr = array();

							foreach($data['age_groups'] as $i => $ag){
								$arr[$ag] = array(
													'fee'						 => $data['fee'][$i],
													'additional_fee' => $data['additional_fee'][$i]
													); 
							}
							
							$data['age_based_fee']		= $arr;
							$data['is_event_fee']			= $tour_details['is_event_fee'];
							$data['fee_event_based']	= json_decode($tour_details['Event_Reg_Fee'], TRUE);
							$data['is_event_limited']	= ($tour_details['Event_Reg_Limit'] != null) ? 1 : 0;
							$data['event_limits']			= json_decode($tour_details['Event_Reg_Limit'], TRUE);
							//$data['event_time']          = json_decode($tour_details['Multi_Event_Time'], TRUE);

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

									$pay_mode		 = null;
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
							$data['link'] = base_url()."league/".$tourn_id."/";

						if($tour_details['MedicalRelease_pdf'] != NULL or $tour_details['MedicalRelease_pdf'] != '') { 
							$url = base_url()."tour_pictures/".$tourn_id."/".$tour_details['MedicalRelease_pdf'];
						}
						else{
							$url = base_url().'medical_form/';
						}

						$data['medical_form'] = $url;

						$tc = base_url().'terms_conditions/';
						$data['terms_conditions'] = $tc;

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
					//$check_register = $this->mleague->is_user_team_registered($user_id, $tourn_id, 'Team');

					//if(count($check_register) == 0) {
					$get_user_teams_1 = $this->muser->get_user_captain_teams($user_id, $tourn_id, $tour_details['SportsType']);
					
						foreach($get_user_teams_1 as $res){
							$tp = json_decode($res->Players, TRUE);
							$tplayers_1 = array();
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
							$data['Organizer']					= $tour_details['OrganizerName'];
							$data['Contact_Num']			= $tour_details['ContactNumber'];
							$data['Details']						= $tour_details['TournamentDescription'];
							$data['Sport']						= $tour_details['SportsType'];
							$data['Tournament_Format']	= $tour_details['tournament_format'];
							$data['Tournament_Type']		= $tour_details['Tournament_type'];

							$data['is_TournAdmin']			= 0;
							//if($user_id == $data['Usersid'] or $user_id == 240)
							if($user_id == $tour_details['Usersid'] or $user_id == 240)
							$data['is_TournAdmin']			= 1;

							if($tour_details['StartDate'])
							$data['StartDate'] = date('Y-m-d', strtotime($tour_details['StartDate']))."T".date('H:i:s', strtotime($tour_details['StartDate'])).".000Z";
							else 
							$data['StartDate']					= NULL;

							if($tour_details['EndDate'])
							$data['EndDate'] = date('Y-m-d', strtotime($tour_details['EndDate']))."T".date('H:i:s', strtotime($tour_details['EndDate'])).".000Z";
							else 
							$data['EndDate']					= NULL;

							if($tour_details['Registrationsclosedon'])
							$data['RegistrationCloseDate'] = date('Y-m-d', strtotime($tour_details['Registrationsclosedon']))."T".date('H:i:s', strtotime($tour_details['Registrationsclosedon'])).".000Z";
							else 
							$data['RegistrationCloseDate'] = NULL;

							if($tour_details['venue'])
								$taddress = $tour_details['venue'];

							if($tour_details['TournamentAddress'] and $tour_details['venue'])
								$taddress .= ', ' . $tour_details['TournamentAddress'];
							else if($tour_details['TournamentAddress'])
								$taddress .= $tour_details['TournamentAddress'];

							if($tour_details['TournamentAddress'] and $tour_details['venue'] != $tour_details['TournamentAddress'])
								$taddress .= ", ".$tour_details['TournamentAddress'];

							if($tour_details['TournamentAddress'] and $tour_details['TournamentCity'])
								$taddress .= ", ".$tour_details['TournamentCity'];
							else
								$taddress .= $tour_details['TournamentCity'];

							if($tour_details['TournamentState'])
								$taddress .= ", ".$tour_details['TournamentState'];
							if($tour_details['TournamentCountry'])
								$taddress .= ", ".$tour_details['TournamentCountry'];
							if($tour_details['PostalCode'])
								$taddress .= ", ".$tour_details['PostalCode'];

								$data['TournamentAddress']	= $taddress;

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

									$pay_mode		 = null;
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
						$data['link']							= base_url()."league/".$tourn_id."/";
						$data['terms_conditions']  = base_url()."terms_conditions/";
						$res = array($data);
					//}
					/*else {
						$res = array('Error: ' . "Player is already registered for this tournament!");
					}*/
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

		$post_data = json_decode(trim(file_get_contents('php://input')), true);

			/*print_r($post_data);
			$this->response($post_data); 
			exit;*/

		$tourn_id		 = $post_data['tourn_id'];
		$user_id		 = $post_data['user_id'];

		$fee_amount			 = $post_data['fee_amount'];
		$gateway_charges = $post_data['gateway_charges'];
		$transaction_id		 = $post_data['transaction_id'];
		$currency_code		 = $post_data['currency_code'];
		$status				 = $post_data['status'];
		$tshirt_size		 = $post_data['tshirt_size'];
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
			$is_league	 = $tour_details['Is_League'];
			
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
			$ins_a2m	= $this->mleague->inset_user_a2m($user_id, $tour_details['SportsType']);
			$ins_si		= $this->mleague->inset_user_si($user_id, $tour_details['SportsType']);

			if($tformat != "Teams" or $tformat != "TeamSport") {
					$get_a2m = $this->mleague->get_user_a2m($user_id, $tour_details['SportsType']);
					if($get_a2m){
						$init_a2m = max($get_a2m['A2MScore'], $get_a2m['A2MScore_Doubles'], $get_a2m['A2MScore_Mixed']);
						$upd_reg_a2m = $this->mleague->upd_reg_a2m($ins, $init_a2m);
					}
			}

			$res				= array('Success: ' . "User / Team successfully registered.");

			$dev_email	 = "pradeepkumar.namala@gmail.com";
			$dev_subject = "A2M Mobile Post variables - Production";
			$data2		 = array('firstname'	=> "Developer",
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

			$data3['upd_events']			= $prev_reg_events;
			$data3['Tournament_ID']	= $data['Tournament_ID'];
			$data3['Users_ID']				= $data['Users_ID'];

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

			if($exp[0] != 'Adults' and $exp[0][0] == 'A'){
			//$event_lable = str_replace($lv, $level_title, $temp);
			}
			else{
			$level_name  = $this->mleague->get_level_name($lv);
			$level_title = $level_name['SportsLevel'];
			$event_lable = str_replace($lv, $level_title, $temp);
			}

			$event_lable = str_replace("-1-", "-Men's-", $event_lable);
			$event_lable = str_replace("-0-", "-Women's-", $event_lable);
			$event_lable = str_replace("Adults-", "", $event_lable);

			$processed_events[trim($event)] = $event_lable;	
		}

		return $processed_events;
	}

	public function get_eligible_events($tourn_events, $user_ag_grp, $user_db_age_grp, $user_gender, $user_age='', $get_event_limits = '', $events_limit_arr = '') {
		$eligible_events	 = array();
		$non_eligible_events = array();

		foreach($tourn_events as $event) {
			$exp = explode("-", $event);

			$lv		= end($exp);
			$temp	= $event;

			if($exp[0] != 'Adults' and $exp[0][0] == 'A'){
			$event_lable = $this->config->item($exp[0], 'age_values');
			}
			else{
			$level_name  = $this->mleague->get_level_name($lv);
			$level_title = $level_name['SportsLevel'];
			$event_lable = str_replace($lv, $level_title, $temp);
			}

			$event_lable = str_replace("Adults-", "",			$event_lable);
			$event_lable = str_replace("-1-", "-Men's-",		$event_lable);
			$event_lable = str_replace("1-", "Men's-",		$event_lable);
			$event_lable = str_replace("-0-", "-Women's-", $event_lable);
			$event_lable = str_replace("0-", "Women's-", $event_lable);

			if($events_limit_arr[$event] and $get_event_limits[$event] >= $events_limit_arr[$event]){
				$non_eligible_events[trim($event)]  = $event_lable;
			}
			else{

			if ((in_array($user_ag_grp, $exp) or in_array($user_db_age_grp, $exp)) and (($exp[0] == $user_ag_grp or $exp[0] == $user_db_age_grp) or $exp[0] == 'Open' or $exp[1] == 'Open')) {
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
			else if($exp[0] != 'Adults' and $exp[0][0] == 'A'){
					if($user_age >= $lv)
						$eligible_events[trim($event)] = $event_lable;
					else
						$non_eligible_events[trim($event)]  = $event_lable;

			}
			else if(in_array('Mixed', $exp)) {
				 $eligible_events[trim($event)] = $event_lable;
			}
			else if($user_ag_grp == 'U9' or $user_ag_grp == 'U10' or $user_ag_grp == 'U11' or $user_ag_grp == 'U12' or $user_ag_grp == 'U13' or $user_ag_grp == 'U14' or $user_ag_grp == 'U15' or $user_ag_grp == 'U16' or $user_ag_grp == 'U17' or $user_ag_grp == 'U18' or $user_ag_grp == 'U19' or $user_ag_grp == 'Junior') {
				if($exp[0] == 'Adults'){
				 $eligible_events[trim($event)] = $event_lable;
				}
			}
			else {
				 $non_eligible_events[trim($event)]  = $event_lable;
			}
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
				$paypalID  = $get_det['paypal_merch_id'];
				$cur_code = $get_det['currency_format'];
				$logo = base_url().'images/logo.png';
				$returnURL = 'https://a2msports.com/rest_services/league/paypalSuccess';
				$cancelURL = 'https://a2msports.com/rest_services/league/paypalCancel';
	
				$this->paypal_lib->add_field('business', $paypalID);
				$this->paypal_lib->add_field('return', $returnURL);
				$this->paypal_lib->add_field('cancel_return', $cancelURL);
				$this->paypal_lib->add_field('currency_code', $cur_code);
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
						//echo $pos;
						unset($reg_events[$pos]);
					}
				}

				if(!empty($reg_events)){
				$reg_events = array_values($reg_events);
				$data2['upd_events']	= $reg_events;
				$data2['Tournament_ID'] = $tourn_id;
				$data2['Users_ID']		= $user_id;
				
				//echo "<pre>"; print_r($data2); exit;
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

	public function withdrawTemp_post(){

		$post_data = json_decode(trim(file_get_contents('php://input')), true);

			/*print_r($post_data);
			$this->response($post_data); 
			exit;*/

		if(!$post_data){
			$this->response(array('Error: '."Missing Input data")); 
			exit;
		}

		$tourn_id		= $post_data['tourn_id'];
		$user_id		= $post_data['user_id'];
		$wd_events = $post_data['withdraw_events'];

		$tourn_det	= $this->is_valid_league($tourn_id);
		
		if($tourn_det){
			
			if($wd_events){
				
				$get_user_reg = $this->mleague->get_user_reg($tourn_id, $user_id);
				$reg_events   = json_decode($get_user_reg['Reg_Events'], true);
				$rem_gd = NULL;

				if($reg_events){
					foreach($wd_events as $ev => $game_days){				
						$pos = array_search($ev, $reg_events);
						//echo $pos;
						unset($reg_events[$pos]);

						if($game_days){
							foreach($game_days as $gd){
								$rem_gd[] = $gd;
							}
						}
					}
				}

				if($rem_gd){
					foreach($rem_gd as $game_day){
						$upd_events = $this->mleague->remove_user_game_day($game_day, $user_id);
					}
				}

				if(!empty($reg_events)){
					$reg_events						= array_values($reg_events);
					$data2['upd_events']		= $reg_events;
					$data2['Tournament_ID']	= $tourn_id;
					$data2['Users_ID']			= $user_id;
					
					//echo "<pre>"; print_r($data2); exit;
					$upd_events = $this->mleague->update_reg_tourn($data2);
				}
				else{
					$del_events = $this->mleague->del_tourn_reguser($user_id, $tourn_id);
				}

				if($upd_events)
					$this->response(array('Success: '."User is successfully withdrawn from the events")); 
				else if($del_events)
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
//error_reporting(-1);
//exit;
		$user_id = $this->input->get('user_id');

		if($this->input->get('page'))
		$page = $this->input->get('page');

		$limit  = 20;
		$search = '';

		if($this->input->get('act') == 'search'){

			if($this->input->get('name')){
			$search['name'] = $this->input->get('name');
			}

			if($this->input->get('city')){
			$search['city'] = $this->input->get('city');
			}
		
			if($this->input->get('state')){
			$search['state'] = $this->input->get('state');
			}
		
			if($this->input->get('sport')){
			$search['sport'] = $this->input->get('sport');
			}

			if($this->input->get('distance')){
			$search['distance'] = $this->input->get('distance');
			}

			if($this->input->get('sdate')){
			$search['sdate'] = $this->input->get('sdate');
			}

			if($this->input->get('edate')){
			$search['edate'] = $this->input->get('edate');
			}
		}
//print_r($search); exit;
		if($user_id){
			$user_details	 = $this->general->get_user($user_id);
			if($page){
			$get_results		  = $this->mleague->get_limit_tournaments($user_id, $user_details['Country'], $page, $limit, $search);
			$get_tournaments = $get_results[0];
			}
			else{
			$get_tournaments = $this->mleague->get_tournaments($user_id, $user_details['Country']);
			}
			$tourn_list		 = null;

			if($get_tournaments){
			foreach($get_tournaments as $tr){
				$reg = 0;
				if($tr->tournament_format == 'Individual')
					$is_reg = $this->mleague->get_user_reg($tr->tournament_ID, $user_id);
				else
					$is_reg = $this->mleague->is_user_team_registered($user_id, $tr->tournament_ID);

				if(count($is_reg)>0)
				$reg = 1;

				
			$get_sport = $this->general->get_sport($tr->SportsType);

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

				$now = time();
				$reg_close = strtotime(date('Y-m-d',strtotime($tr->Registrationsclosedon)));
				$is_registration_closed = false;

				if($now > $reg_close) {
					$is_registration_closed = true;
				}
					$is_tourn_admin = 0;
				if($user_id == $tr->Usersid)
					$is_tourn_admin = 1;
				$temp = '';
				$temp = array(
				'Registered'		=> $reg,
				'is_TournAdmin'		=> $is_tourn_admin,
				'tournament_ID'		=> $tr->tournament_ID,
				'tournament_title'  => $tr->tournament_title,
				'StartDate'			=> $tr->StartDate,
				'EndDate'			=> $tr->EndDate,
				'is_registration_closed'	 => $is_registration_closed,
				'SportsType'		=> $tr->SportsType,
				'Sportname'			=> $get_sport['sport_title'],
				'TournamentImage'	=> base_url()."tour_pictures/".$img,
				'Tournament_Format'	=> $tr->tournament_format,
				'Tournament_Type'	=> $tr->Tournament_type,
				'TournamentCity'	=> $tr->TournamentCity,
				'TournamentState'	=> $tr->TournamentState,
				'TournamentCountry' => $tr->TournamentCountry,
				/*'latitude'			=> $tr->latitude,
				'longitude'			=> $tr->longitude*/
				);
				
				$tourn_list[] = $temp;
			}
			$data['results'] = $tourn_list;
			if($get_results[1])
			$data['total_pages'] = $get_results[1];

			}
			else{
				$data['results'] = array();
			}
	
			$this->benchmark->mark('code_end');
		$response_time = $this->benchmark->elapsed_time('code_start', 'code_end');
		$data['response_time'] = $response_time;


			$this->response($data);	
		}
		else{
			$this->response(array('Error: '."User ID Required!"));
			exit;
		}

	}

	public function broadcast_post(){
		$post_data = json_decode(trim(file_get_contents('php://input')), true);

		$from_user	= trim($post_data['sender_id'], '"');
		$tourn_id		= trim($post_data['tourn_id'], '"');
		$message		= trim($post_data['message'], '"');
		//$player_ids	= trim($post_data['player_ids'], '"');
		$player_ids	= json_decode($post_data['player_ids'], true);

		//$check_is_tourn_admin = $this->mleague->check_is_admin($from_user, $tourn_id);

		/*if(count($check_is_tourn_admin) == 0){
			$this->response(array('Error: '."Unauthorised Access!"));
			exit;
		}*/

		if(count($player_ids) > 0){
			$get_tourn = $this->general->get_tour_info($tourn_id);
			$get_from = $this->mteam->get_user_details($from_user);
			$expo_ids = array();

			foreach($player_ids as $to_user){
				$get_user_token = $this->general->get_userToken($to_user);

				if($get_user_token){
						foreach($get_user_token as $exp){
								$expo_ids[$exp->user_id][] = $exp->token;
						}
				}
			}

			$send_status = array();
			if(!empty($expo_ids)){
				$send_status = $this->send_notifs($expo_ids, $get_tourn['tournament_title'], $message);
			}

			if(!empty($send_status)){
					foreach($send_status as $user => $exp){
						foreach($exp as $token => $status){
								$send_stat = 0;
							if($status == 'ok')
								$send_stat = 1;

				$json_mes = '{"to": "'.$user.'", "title": "'.$get_tourn['tournament_title'].' '.$get_from['Lastname'].'", "body": "'.$get_from['Firstname'].' '.$get_from['Lastname'].": ".$message.'", "data": {"message_content": "'.$message.'", "type": "TOURN_NOTIFICATION", "sender_user_id": '.$from_user.'}}';

							$data = array(
								'Sender'		 => $from_user,
								'Recipient'  => $user,
								//'Club_ID'	=> $org_id,
								'Message'	=> $message,
								'Json_Message' => $json_mes,
								'Send_Status'	=> $send_stat,
								'Read_Status'	=> 0,
								'Sent_On'			=> date('Y-m-d H:i'),
								'Expo_Token'		=> $token,
								'Notif_Type'		=> 'Notification',
								'MType'		=> 'League',
								'Ref_ID'		=> $tourn_id,
								'Sent_Players' => json_encode($player_ids)
								);

							$this->general->insert_notif($data);
						}
					}
				}

					$res2 = array('Success: ' . "Message is sent to the players", 200);
		}
		else{
					$res2 = array('Error: ' . "Recipeints shouldn't empty!", 400);
		}

		$this->response($res2);
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
			}
		
			return $send_result;
		}

		public function update_partner_post(){

			$post_data = json_decode(file_get_contents('php://input'), true);
		echo "<pre>"; print_r($post_data); exit;
		}

		public function updatePartner_post(){

		$post_data = json_decode(trim(file_get_contents('php://input')), true);
		//echo "<pre>"; print_r($post_data); exit;
			$data['tourn_id']	=  $post_data['tourn_id'];
			//$data['ttype']			=  $post_data['ttype'];

			$data['player']		=  $post_data['player'];
			$data['partner']	=  $post_data['partner'];
			$data['event']		=  $post_data['event'];

			$upd = $this->mleague->update_partner($data);

			if($upd){
				$res = array('Success: ' . "Update Done");
			}
			else{
				$res = array('Error: ' . "Update Not Done");
			}
			$this->response($res);
			
		}

		public function participants_get() {
			$tourn_id	 = $this->input->get('tourn_id');
			$tourn_det = $this->mleague->getonerow($tourn_id);
	//exit;
			if(!$tourn_det) {
				$this->response(array('Error: '."Invalid League!"));
				exit;
			}
			else {
				$tformat			= $tourn_det['tournament_format'];
				$tourn_events	= json_decode($tourn_det['Multi_Events'], true);

			foreach($tourn_events as $event) {
				$exp		= explode("-", $event);
				$lv		= end($exp);
				$temp	= $event;
//echo $exp[0];
//exit;
				if($exp[0] != 'Adults' and $exp[0][0] == 'A'){
					$event_lable_temp = $this->config->item($exp[0], 'age_values');
					$event_lable = str_replace($exp[0], $event_lable_temp, $temp);

					$level_name  = $this->mleague->get_level_name($lv);
					$level_title = $level_name['SportsLevel'];
					$event_lable = str_replace($lv, $level_title, $event_lable);
				}
				else{
					$level_name  = $this->mleague->get_level_name($lv);
					$level_title = $level_name['SportsLevel'];
					$event_lable = str_replace($lv, $level_title, $temp);
				}

				$event_lable = str_replace("Adults-", "",		$event_lable);
				$event_lable = str_replace("-1-", "-Men's-",	$event_lable);
				$event_lable = str_replace("1-", "Men's-",		$event_lable);
				$event_lable = str_replace("-0-", "-Women's-", $event_lable);
				$event_lable = str_replace("0-", "Women's-", $event_lable);
				$event_lable = str_replace("Mixed-", "Mixed-Doubles-", $event_lable);

				$formated_events[$event] = $event_lable;
			}

					if($tformat == 'Individual') {
					//$tourn_events = json_decode($tourn_det['Multi_Events'], true);

					$reg_users = $this->mleague->get_reg_users($tourn_id);
					//echo "<pre>"; print_r($reg_users);exit;
					$shown_users = array();
					if(count($reg_users) > 0) {
						foreach($reg_users as $user) {
							$get_user = $this->mleague->get_user_details($user->Users_ID, $tourn_det['SportsType']);
							$events	  = json_decode($user->Reg_Events, TRUE);
//echo "<pre>"; print_r($get_user);

							if($events) {
								$user_ev_partners = array();
								$partners  = json_decode($user->Partners, TRUE);
								
								foreach($events as $ev) {
									$a2m_param = '';
									if(strpos($ev, 'oubles') > 0){
										$a2m_param = '_Doubles';
									}
									else if(strpos($ev, 'ixed') > 0){
										$a2m_param = '_Mixed';
									}
								
									//echo $partners[$ev]; exit;
									if($partners[$ev] and $partners[$ev] != '' and !in_array($user->Users_ID, $shown_users[$ev])) {
										//echo $partners[$ev]; exit;
										$get_pr = $this->mleague->get_user_details($partners[$ev], $tourn_det['SportsType']);
										//echo "<pre>"; print_r($get_pr);
										$ev_reg_user[$ev][] = array(
											'user_id'					=>	$user->Users_ID,
											'user_name'			=>	ucfirst($get_user['Firstname'])." ".ucfirst($get_user['Lastname']), 
											'user_a2mscore'	=>	$get_user['A2MScore'.$a2m_param], 
											'partner_id'			=>	$partners[$ev], 
											'partner_name'		=>	ucfirst($get_pr['Firstname'])." ".ucfirst($get_pr['Lastname']),
											'partner_a2mscore'	=>	$get_pr['A2MScore'.$a2m_param], 
											);

										$shown_users[$ev][] = $partners[$ev];
										$shown_users[$ev][] = $user->Users_ID;
									}
									else if(!in_array($user->Users_ID, $shown_users[$ev])){
										$ev_reg_user[$ev][] = array(
											'user_id'					=>	$user->Users_ID,
											'user_name'			=>	ucfirst($get_user['Firstname'])." ".ucfirst($get_user['Lastname']),
											'user_a2mscore'	=>	$get_user['A2MScore'.$a2m_param], 
											'partner_id'			=>	null, 
											'partner_name'		=>	null,
											'partner_a2mscore' => null,
											);
										$shown_users[$ev][] = $user->Users_ID;
									}
									//echo "<pre>";
									//print_r($shown_users);
								}
							}

							/*$reg_user[] = array(
													'user_id'			 => $user->Users_ID,
													'name'			 => $get_user['Firstname']." ".$get_user['Lastname'],
													'events'			 => json_decode($user->Reg_Events, TRUE),
													'partners'		 => $user_ev_partners	
													);*/
						}
						$data['registered_users'] = $ev_reg_user;
						$data['events']					 = $formated_events;
						//$data['draws']					 = $this->get_league_draws($tourn_id);
						$res = $data;
					}
					else{
						$res = array('Error: '."No Participants found!");
					}
				}
				else if($tformat == 'Teams') {
					$reg_teams = $this->mleague->get_reg_users($tourn_id);
					//echo "<pre>"; print_r($reg_teams);exit;
					if(count($reg_teams) > 0) {
						foreach($reg_teams as $team) {
							$get_team	= $this->mleague->get_team_details($team->Team_id);
							$team_city	= null;
							$team_state	= null;

							if($get_team['Home_loc_id']){
							$get_hcl 			= $this->mleague->get_onerow('Home_Court_Locations', 'hcl_id', $get_team['Home_loc_id']);
							$team_city		= $get_hcl['hcl_city'];
							$team_state		= $get_hcl['hcl_state'];
							}
							//echo "<pre>"; print_r($get_hcl);exit;
							$team_players  = json_decode($team->Team_Players, TRUE);
							$players = array();
							foreach($team_players as $tp) {
								$get_tp = $this->mleague->get_user_details($tp);
								$players[] = array('user_id' => $tp, 'name' => ucfirst($get_tp['Firstname'])." ".ucfirst($get_tp['Lastname']));
							}

							if($get_team['Team_Logo'] != "" and $get_team['Team_Logo'] != NULL)
								$tm_logo = base_url()."team_logos/".$get_team['Team_Logo'];
							else
								$tm_logo = base_url()."team_logos/default_team_logo.png";

							$reg_user[] = array(
													'team_id'  => $team->Team_id, 
													'name'		=> $get_team['Team_name'],
													'logo'			=> $tm_logo,
													'city'			=> $team_city,
													'state'		=> $team_state,
													'players'	=> $players
													);

						}
						$data['registered_teams'] = $reg_user;
						$res = $data;
					}
				}
				$this->response($res);
				exit;

			}
		}

		public function get_league_draws($tourn_id){
				$get_draws = $this->mleague->get_draws($tourn_id);
				$res = array();
				if(count($get_draws) > 0){
					foreach($get_draws as $draw){
						$res[$draw->BracketID] = $draw->Draw_Title;
					}
				}
			return $res;
		}

		public function brackets_get(){
			$tourn_id	 = $this->input->get('tourn_id');
			$tourn_det = $this->mleague->getonerow($tourn_id);
			if(!$tourn_id) {
				$this->response(array('Error: '."Provide Tournament ID!"));
				exit;
			}
			else {
				$format			= $tourn_det['tournament_format'];
				$get_draws  = $this->mleague->get_league_brackets($tourn_id, $format);

				$res = array('Success: '."No Brackets are available!");
				if(count($get_draws) > 0){
					$res = $get_draws;
					$this->response($res);
				}
				else{
					$this->response($res, 400);
				}
			}
		}

		public function tournamentTeamLines_get(){
			$match_id		= $this->input->get('match_id');
			if(!$match_id) {
				$this->response(array('Error: '."Provide Match ID!"));
				exit;
			}
			else {
				$get_draws  = $this->mleague->get_TeamLineMatches($match_id);
				$res = array('Success: '."No Brackets are available!");

				if(count($get_draws) > 0){
					$res = $get_draws;
					$this->response($res);
				}
				else{
					$this->response($res, 400);
				}
			}
		}

		public function playerStandings_get(){	
			$bracket_id = $this->input->get('draw_id');
			
			if($bracket_id){
					$get_draw		 = $this->mleague->get_draw($bracket_id);
					if($get_draw['Bracket_Type'] == 'Round Robin'){
						$rr_matches  = $this->mleague->get_tourn_matches($bracket_id);
						$standings	  = $this->get_standings($rr_matches, $get_draw['Tourn_ID']);
						//$res['standings'] = $standings;
						$this->response($standings);
					}
					else if($get_draw['Bracket_Type'] == 'Switch Doubles'){
						$rr_matches  = $this->mleague->get_tourn_matches($bracket_id);
						$standings	  = $this->get_standings($rr_matches, $get_draw['Tourn_ID']);
						//$res['standings'] = $standings;
						$this->response($standings);
					}
					else{
						$res = array('Error: '."Draw is not a Round Robin");
						$this->response($res);
					}

					$this->response($res);
			}
			else{
					$res = array('Error: '."Draw ID is required!");
					$this->response($res);
			}
	
		}

/*
public function get_sd_standings($get_sd_tourn_matches, $tourn_id = ''){

$get_tourny = $this->mleague->getonerow($tourn_id);
$tourn_format = $get_tourny['tournament_format'];

$rr_matches2 = $get_sd_tourn_matches->result();

$list_players = array();
$temp = 1;
$m	  = array();
$arr  = array();
foreach($rr_matches2 as $m2 => $match2){
//echo $m2."<br>";
$bracket_id = $rr_matches2[$m2]->BracketID; 
if($temp != $rr_matches2[$m2]->Round_Num){
	// echo $temp." temp<br>";
	$m[$temp] = $arr;
	$temp	  = $rr_matches2[$m2]->Round_Num;
	$arr  = array();
}

$arr[] = $rr_matches2[$m2]->Player1;
$arr[] = $rr_matches2[$m2]->Player2;

if($temp == $get_bracket['No_of_rounds'] and ($m2+1) == count($rr_matches2)){
	$m[$temp]	= $arr;
	$temp			= $rr_matches2[$m2]->Round_Num;
	$arr				= array();
}

	if(!in_array($rr_matches2[$m2]->Player1, $list_players))
	{	$list_players[] = $rr_matches2[$m2]->Player1; }

	if(!in_array($rr_matches2[$m2]->Player1_Partner, $list_players))
	{	$list_players[] = $rr_matches2[$m2]->Player1_Partner; }

	if(!in_array($rr_matches2[$m2]->Player2, $list_players))
	{	$list_players[] = $rr_matches2[$m2]->Player2; }

	if(!in_array($rr_matches2[$m2]->Player2_Partner, $list_players))
	{	$list_players[] = $rr_matches2[$m2]->Player2_Partner; }
}


}
*/

public function get_standings($get_rr_tourn_matches, $tourn_id=''){

$get_tourny = $this->mleague->getonerow($tourn_id);
$tourn_format = $get_tourny['tournament_format'];
$rr_matches2 = $get_rr_tourn_matches->result();
$list_players = array();
$temp = 1;
$m	  = array();
$arr  = array();
foreach($rr_matches2 as $m2 => $match2){
//echo $m2."<br>";
$bracket_id = $rr_matches2[$m2]->BracketID; 
if($temp != $rr_matches2[$m2]->Round_Num){
	// echo $temp." temp<br>";
	$m[$temp] = $arr;
	$temp	  = $rr_matches2[$m2]->Round_Num;
	$arr  = array();
}
$arr[] = $rr_matches2[$m2]->Player1;
$arr[] = $rr_matches2[$m2]->Player2;

if($temp == $get_bracket['No_of_rounds'] and ($m2+1) == count($rr_matches2)){
	$m[$temp] = $arr;
	$temp	  = $rr_matches2[$m2]->Round_Num;
	$arr  = array();
}
	if(!in_array($rr_matches2[$m2]->Player1, $list_players))
	{	$list_players[] = $rr_matches2[$m2]->Player1."-".$rr_matches2[$m2]->Player1_Partner; }

	if(!in_array($rr_matches2[$m2]->Player2, $list_players))
	{	$list_players[] = $rr_matches2[$m2]->Player2."-".$rr_matches2[$m2]->Player2_Partner; }
}

//echo "<pre>";
//print_r($m);

$players_count = count($list_players);
$num_matches = ($players_count % 2 == 0) ? $players_count-1 : $players_count;

//$num_matches = count($list_players) - 1;


 if($match_type == "Doubles"){ 
	 //echo "Teams"; 
 }
 else { 
	 //echo "Players"; 
} 


//for($i = 1;$i <= $num_matches; $i++)
//{
//	echo "<td class='score-position' valign='center' align='center'>Match $i&nbsp;&nbsp;</td>";	
//}



//echo "<pre>"; print_r($rr_matches2); exit;

foreach($list_players as $ind => $player){
	$tot_p = 0;
	$player_tot_score = 0;
	$p1p2_tot_score = 0;

	foreach($rr_matches2 as $m2 => $match2){

		if($rr_matches2[$m2]->Player1 == $player or $rr_matches2[$m2]->Player2 == $player){

		$p1_sum	= 0;
		$p2_sum = 0;
		$p1		= array();
		$p2		= array();

				if($rr_matches2[$m2]->Player1 == $player) { 
						$tot_p += $rr_matches2[$m2]->Player1_points;

				/*  Win percentage calculation for player when he is listed as PLAYER1 for that match*/

				$p1 = json_decode($rr_matches2[$m2]->Player1_Score);  

				$cnt1 = count(array_filter($p1));

				if($cnt1 > 0){
					for($i=0; $i<count(array_filter($p1)); $i++)
					{
						$p1_sum = intval($p1_sum) + intval($p1[$i]);
					}
				}

				$p2 = json_decode($rr_matches2[$m2]->Player2_Score);

				$cnt2 = count(array_filter($p2));
	
				if($cnt2 > 0){
					for($i=0; $i<count(array_filter($p2)); $i++)
					{
						$p2_sum = intval($p2_sum) + intval($p2[$i]);
					}
				}

				/*  Win percentage calculation end */	

				} 
				else { 
						$tot_p += $rr_matches2[$m2]->Player2_points;

					 /*  Win percentage calculation for player when he is listed as PLAYER2 for that match*/	
						$p1 = json_decode($rr_matches2[$m2]->Player2_Score);  

						$cnt1 = count(array_filter($p1));

						if($cnt1 > 0){
							for($i=0; $i<count(array_filter($p1)); $i++){
								$p1_sum = intval($p1_sum) + intval($p1[$i]);
							}
						}

						$p2 = json_decode($rr_matches2[$m2]->Player1_Score);

						$cnt2 = count(array_filter($p2));
			
						if($cnt2 > 0){
							for($i=0; $i<count(array_filter($p2)); $i++)
							{
								$p2_sum = intval($p2_sum) + intval($p2[$i]);
							}
						}
					 /*  Win percentage calculation end */	
				}
				$player_tot_score	+= ($p1_sum);
				$p1p2_tot_score		+= ($p1_sum+$p2_sum);
		}
	}
$win_per = ($player_tot_score / $p1p2_tot_score) * 100;

//$players_sort[$player] = array('points' => $tot_p, 'win_per' => number_format($win_per, 2));
$players_sort[$player] = array('points' => $tot_p, 'win_per' => $player_tot_score, 'win_per2' => number_format($win_per, 2));
}

$sort_func = uasort($players_sort, array('league','compareOrder'));
$keys_arr = array_keys($players_sort); 

//echo "<pre>";
//print_r($keys_arr);

foreach($players_sort as $player => $tot_score){
	
	if($players_sort[$temp]['points'] == $tot_score['points'])
	{
		$last_player	 = str_replace('-', '', $temp);
		$cur_player		 = str_replace('-', '', $player);

		if($grid_array[$cur_player]['opponents'][$last_player]['result'] == 'W'){
			$key_temp   = array_search($temp, $keys_arr);
			$key_player = array_search($player, $keys_arr);
			$keys_arr[$key_temp]   = $player;
			$keys_arr[$key_player] = $temp;
			$temp = $temp;
		}
		else{
		$temp = $player;
		}
	}
	else{
		$temp = $player;
	}

//$last_player	 = str_replace('-','',end(array_keys($players_sort)));
//$cur_player		 = str_replace('-','',$player);

	/*if($last_player_arr['points'] == $tot_p and ($grid_array[$last_player]['opponents'][$cur_player]['result'] == 'L')){
			unset($players_sort[$last_player]);
			$players_sort[$player]		= array('points' => $tot_p, 'win_per' => number_format($win_per, 2));
			$players_sort[$last_player] = $last_player_arr;
			echo "<pre>";
			print_r($players_sort);
	}
	else{
		$players_sort[$player] = array('points' => $tot_p, 'win_per' => number_format($win_per, 2));
	}*/
	
}


foreach($keys_arr as $player){
	$temp_players_sort[$player] = $players_sort[$player];
	$get_players = explode("-", $player);
	$temp_grid_array[$get_players[0]] = $grid_array[$get_players[0]];
}

$players_sort = $temp_players_sort;
$grid_array     = $temp_grid_array;

//echo "<pre>"; print_r($players_sort); exit;

foreach($players_sort as $player => $tot_score){

		$get_players = explode("-", $player);
$new_arr = array();
		$get_name					= $this->get_username($get_players[0]);
		$get_name_partner	= $this->get_username($get_players[1]);
		$player	 = '';
		$partner	 = NULL;
		if($get_name_partner){
			//echo "<b>"."<a href='".base_url()."player/".$get_name['Users_ID']."'>".$get_name['Firstname'][0]." ".$get_name['Lastname']."</a>";
		//	echo "; <a href='".base_url()."player/".$get_name_partner['Users_ID']."'>".$get_name_partner['Firstname'][0].".".$get_name_partner['Lastname']."</a>";
		$player = trim($get_name['Firstname'])." ".trim($get_name['Lastname']);
		$partner = trim($get_name_partner['Firstname'])." ".trim($get_name_partner['Lastname']);
		}
		else{
			//echo "<b>"."<a href='".base_url()."player/".$get_name['Users_ID']."'>".$get_name['Firstname']." ".$get_name['Lastname']."</a>";
			//echo $tourn_format;
			//exit;
			if($tourn_format != 'Individual'){
			$get_team = $this->get_team($get_players[0]);
			$player = trim($get_team['Team_name']);
			}
			else{
			$player = trim($get_name['Firstname'])." ".trim($get_name['Lastname']);
			}
		}
		//echo "</b>";
	$new_arr['user_id']	= $get_players[0];
	$new_arr['name']	= $player;
	$new_arr['partner'] = $partner;
	foreach($rr_matches2 as $m2 => $match2){

		//if(($rr_matches2[$m2]->Player1 == $player or $rr_matches2[$m2]->Player2 == $player) and $i == $rr_matches2[$m2]->Round_Num){
		if($rr_matches2[$m2]->Player1 == $get_players[0] or $rr_matches2[$m2]->Player2 == $get_players[0]){

			if($rr_matches2[$m2]->Player1 == $get_players[0]){ 
				//echo "<td align='center'>".$rr_matches2[$m2]->Player1_points."<br>".$rr_matches2[$m2]->Player1_Score."<br>".$p1_sum."<br>1</td>";
				//echo "<td align='center'>".$rr_matches2[$m2]->Player1_points."</td>";
				$new_arr['matches'][] = $rr_matches2[$m2]->Player1_points;
				}
				else if($rr_matches2[$m2]->Player2 == $get_players[0]){
					//echo "<td align='center'>".$rr_matches2[$m2]->Player2_points."<br>".$rr_matches2[$m2]->Player2_Score."<br>".$p2_sum."<br>2</td>"; 
					//echo "<td align='center'>".$rr_matches2[$m2]->Player2_points."</td>"; 
					$new_arr['matches'][] = $rr_matches2[$m2]->Player2_points;

				}

				$player_tot_score += ($p1_sum);
				$p1p2_tot_score	  += ($p1_sum + $p2_sum);

				//echo "<br>tots= ".$player_tot_score;
		}
		else if(!in_array($get_players[0], $m[$rr_matches2[$m2]->Round_Num])){
			//echo "<td align='center'>Bye</td>";
			array_push($m[$rr_matches2[$m2]->Round_Num], $get_players[0]);
			//$new_arr['matches'][] = array('Points' => 'Bye');
		}
		
	}
 //echo $tot_score['points']; 
			$new_arr['Total_Points'] = $tot_score['points'];
			$new_arr['Win_Per']		 = $tot_score['win_per2'];

$uid = $get_players[0];

$get_init_rating = $this->mleague->get_draw_std_init_ratings($uid, $bracket_id);
			
					if($get_init_rating){
						//echo "testing ".$get_init_rating['Init_Rating']; exit;
						$init_a2m   = $get_init_rating['Init_Rating'];
						$final_a2m = $get_init_rating['Upd_Rating'];
						$change = $final_a2m - $init_a2m;
					}
					else{
								$player_a2m = $this->mleague->get_a2m($uid, $tourn_id);

							$init_a2m   = 0;
							$final_a2m = NULL;

							if($player_a2m){
								$final_a2m = max($player_a2m['A2MScore'], $player_a2m['A2MScore_Doubles'], $player_a2m['A2MScore_Mixed']);
							}

							if(!$init_a2m){
								$init_a2m  =  $final_a2m;				
							}
							
							$change =  $final_a2m -$init_a2m;
					}


			$new_arr['init_a2m']		 = $init_a2m;
			$new_arr['final_a2m']		 = $final_a2m;
			$new_arr['change']			 = $change;

//echo $tot_score['win_per2']; 
 
 $new_arr1[] = $new_arr;
}


return $new_arr1;
		}

		 public function get_username($user_id) {
			return $this->general->get_user($user_id);
		 }

		 public function get_team($team_id) {
			return $this->general->get_team($team_id);
		 }

		 function compareOrder($a, $b) {
	$result = 0;
		if($a['points'] == $b['points']){
			if ($b['win_per'] > $a['win_per']) {
				$result = 1;
			}
			elseif ($b['win_per'] < $a['win_per']) {
				$result = -1;
			}
		}
		else{
			if ($b['points'] > $a['points']) {
				$result = 1;
			}
			elseif ($b['points'] < $a['points']) {
				$result = -1;
			}
		}

   return $result; 
   }

	 function compareOrder2($a, $b) {
	$result = 0;
		if($a['win_per'] == $b['win_per']){
			if ($b['sd_mp_win_per'] > $a['sd_mp_win_per']) {
				$result = 1;
			}
			elseif ($b['sd_mp_win_per'] < $a['sd_mp_win_per']) {
				$result = -1;
			}
		}
		else{
			if ($b['win_per'] > $a['win_per']) {
				$result = 1;
			}
			elseif ($b['win_per'] < $a['win_per']) {
				$result = -1;
			}
		}

   return $result; 
   }

	
		public function leagueStandings_get(){
			$tourn_id		 = $this->input->get('tourn_id');
			$reg_players  = $this->mleague->get_reg_players($tourn_id);
			$report			 = array();

			foreach($reg_players as $reg_pl){
				//echo $reg_pl->Users_ID."<br>";
				$player				 = $reg_pl->Users_ID;
				$get_player_matches  = $this->mleague->get_player_matches($tourn_id, $player);
				
				//if(count($get_player_matches) > 0 and !in_array($player, $captured_players)){
				if(count($get_player_matches) > 0){
					$player_det   = $this->mleague->get_user_name($player);

					$get_init_rating = $this->mleague->get_lg_std_init_ratings($player, $tourn_id);
			
					if($get_init_rating['Init_Rating'] != NULL and $get_init_rating['Init_Rating'] != 'NULL' and $get_init_rating['Init_Rating'] != ''){
						//echo "testing ".$get_init_rating['Init_Rating']; exit;
						$init_a2m   = $get_init_rating['Init_Rating'];
						$final_a2m = $this->mleague->get_lg_std_final_ratings($player, $tourn_id, $init_a2m);
						$change = $final_a2m - $init_a2m;
					}
					else{
								$player_a2m = $this->mleague->get_a2m($player, $tourn_id);

							$init_a2m   = $reg_pl->Current_A2M;
							$final_a2m = NULL;

							if($player_a2m){
								$final_a2m = max($player_a2m['A2MScore'], $player_a2m['A2MScore_Doubles'], $player_a2m['A2MScore_Mixed']);
							}

							if(!$init_a2m){
								$init_a2m  =  $final_a2m;				
							}
							
							$change =  $final_a2m -$init_a2m;
					}



				$report = array(
					'user_id' => $reg_pl->Users_ID,
					'name' => ucfirst($player_det['Firstname'])." ".ucfirst($player_det['Lastname']),
					'init_a2m'   => $init_a2m,
					'final_a2m' => $final_a2m,
					'change'		 => $change,
					'played' => 0,
					'won' => 0,
					'lost' => 0,
					'points_for' => 0,
					'points_against' => 0
					);

				foreach($get_player_matches as $match){

					$report['played'] += 1;

					if($match['Winner'] == $match['Player1']){
						$report['won']  += ($player == $match['Player1'] or  $player == $match['Player1_Partner']) ? 1 : 0;
						$report['lost'] += ($player != $match['Player1'] and $player != $match['Player1_Partner']) ? 1 : 0;
					}
					else if($match['Winner'] == $match['Player2']){
						$report['won']  += ($player == $match['Player2'] or  $player == $match['Player2_Partner']) ? 1 : 0;
						$report['lost'] += ($player != $match['Player2'] and $player != $match['Player2_Partner']) ? 1 : 0;
					}
					
					$for_score	   = ($player == $match['Player1'] or $player == $match['Player1_Partner']) ?
									 $match['Player1_Score'] : $match['Player2_Score'];

					$against_score = ($player == $match['Player1'] or $player == $match['Player1_Partner']) ?
									 $match['Player2_Score'] : $match['Player1_Score'];
					
					if($for_score){
						$for = json_decode($for_score, true);
						$tot = 0;
						foreach($for as $sc)
							$tot += $sc;
						$report['points_for'] += $tot;
					}

					if($against_score){
						$against = json_decode($against_score, true);
						$tot = 0;
						foreach($against as $sc)
							$tot += $sc;
						$report['points_against'] += $tot;
					}
				}
					// --------------------
				$win_per = ($report['won'] / $report['played']) * 100;
				$report['win_per'] = number_format($win_per, 2);
				$diff = ($report['points_for'] - $report['points_against']);
				$report['score_diff'] = $diff;

				$pd = $diff / $report['played']; 
				$report['sd_mp'] = number_format($pd, 2);

				$pd_win_per = $pd + $win_per;
				$report['sd_mp_win_per'] = number_format($pd_win_per, 2);

					// --------------------
				}
				if(count($report) > 0)
				$report1[] = $report;
				$report = '';
				//$captured_players[] = $reg_pl->Users_ID;
			}

			//echo $this->load->view('tournament/view_cl_standings', $data);
			//echo "<pre>"; print_r($report1);
			uasort($report1, array('league','compareOrder2'));
			//$data['standings'] = $report;
			//echo "<pre>"; print_r($report1); exit;
			foreach($report1 as $a => $res){
					$new_arr[] = $res;
			}
			//$data = json_encode($data);
			//$data = json_decode($data, true);
			$this->response($new_arr);

		}


	public function get_eligible_events_Temp($tourn_events, $user_ag_grp, $user_db_age_grp, $user_gender, $user_age='', $get_event_limits = '', $events_limit_arr = '', $league_occrs = '', $event_reg_fee, $lg_whole_fee, $user_reg_events, $league_occrs_regs) {
		$eligible_events				= array();
		$non_eligible_events	= array();

		foreach($tourn_events as $event) {
			$exp = explode("-", $event);

			$lv		= end($exp);
			$temp	= $event;
			$ag_grp   = $exp[0];

			if($exp[0] != 'Adults' and $exp[0][0] == 'A'){

			//$event_lable = $this->config->item($exp[0], 'age_values');
			
			// Added on 03-01-2022 to fix 50+ events
				$gen = $this->config->item($exp[0]."-".$exp[1], 'age_gender_values');
				
				$level_name   = $this->mleague->get_level_name($lv);
				$level_title		= $level_name['SportsLevel'];
				$event_lable	= $gen." ".$exp[2]." ".$level_title;
			// Added on 03-01-2022 to fix 50+ events

			}
			else{
			$level_name  = $this->mleague->get_level_name($lv);
			$level_title = $level_name['SportsLevel'];
			$event_lable = str_replace($lv, $level_title, $temp);
			}

			$event_lable = str_replace("Adults-", "",			 $event_lable);
			$event_lable = str_replace("-1-", "-Men's-",		 $event_lable);
			$event_lable = str_replace("1-", "Men's-",		 $event_lable);
			$event_lable = str_replace("-0-", "-Women's-", $event_lable);
			$event_lable = str_replace("0-", "Women's-",	 $event_lable);

			$is_eligible = -1;

			if($events_limit_arr[$event] and $get_event_limits[$event] >= $events_limit_arr[$event]){
				//$non_eligible_events[trim($event)]  = $event_lable;
				$is_eligible = 0;
			}
			else{

			if ((in_array($user_ag_grp, $exp) or in_array($user_db_age_grp, $exp)) and (($exp[0] == $user_ag_grp or $exp[0] == $user_db_age_grp) or $exp[0] == 'Open' or $exp[1] == 'Open')) {
				if(in_array($exp[1], array('0','1'))) {
					if($user_gender == $exp[1] or in_array('Mixed', $exp)) {
						//$eligible_events[trim($event)] = $event_lable;	
						 $is_eligible = 1;
					}
					else {
						//$non_eligible_events[trim($event)] = $event_lable;
						$is_eligible = 0;
					}
				}
				else {
				  //$eligible_events[trim($event)] = $event_lable;
				  $is_eligible = 1;
				}
			}
			else if($exp[0] != 'Adults' and $exp[0][0] == 'A'){
					if($user_age >= $lv){
						//$eligible_events[trim($event)] = $event_lable;
						 $is_eligible = 1;
					}
					else{
						//$non_eligible_events[trim($event)]  = $event_lable;
						$is_eligible = 0;
					}
			}
			else if(in_array('Mixed', $exp)) {
				 //$eligible_events[trim($event)] = $event_lable;
				 $is_eligible = 1;
			}
			else if($user_ag_grp == 'U9' or $user_ag_grp == 'U10' or $user_ag_grp == 'U11' or $user_ag_grp == 'U12' or $user_ag_grp == 'U13' or $user_ag_grp == 'U14' or $user_ag_grp == 'U15' or $user_ag_grp == 'U16' or $user_ag_grp == 'U17' or $user_ag_grp == 'U18' or $user_ag_grp == 'U19' or $user_ag_grp == 'Junior') {
				if($exp[0] == 'Adults'){
				 //$eligible_events[trim($event)] = $event_lable;
				 $is_eligible = 1;
				}
			}
			else {
				 //$non_eligible_events[trim($event)]  = $event_lable;
				 $is_eligible = 0;
			}

//echo "<pre>"; print_r($league_occrs_regs); exit;
					$fee = json_decode($event_reg_fee, TRUE);
					$lg_wh_fee = json_decode($lg_whole_fee, TRUE);
					if($is_eligible == 0){
						$non_eligible_events[trim($event)]['title'] = $event_lable;
					}
					else if($is_eligible == 1){
							$eligible_events[trim($event)]['title'] = $event_lable;
							$eligible_events[trim($event)]['ageGroup'] = $ag_grp;
							//echo "<pre>"; print_r($league_occrs_regs);exit;

						if($league_occrs){
							$reg_ocrs = NULL;
							foreach($league_occrs_regs as $ocr_reg) {
								$reg_ocrs[] = $ocr_reg['OCCR_ID'];
							}
							//echo "<pre>"; print_r($reg_ocrs);exit;

							foreach($league_occrs as $occr) {
								$gd		= date('Y-m-d H:i', strtotime($occr->Game_Date));
								$is_reg = false;
								if(in_array($occr->OCR_ID, $reg_ocrs)){
									$is_reg = true;
								}

								if($occr->Event == $event){
									$eligible_events[trim($event)]['gameDays'][] =	array('id' =>$occr->OCR_ID, 'title' =>$gd, 'fees' => (float) $fee[$event], 'registered' => $is_reg);
								}
							}

							$eligible_events[trim($event)]['discountFees'] = (float) $lg_wh_fee[$event];

						}
						else{
							$eligible_events[trim($event)]['registered']	 = (in_array($event, $user_reg_events)) ? true : false;
							$eligible_events[trim($event)]['totalFees']	 = (float) $fee[$event];
							$eligible_events[trim($event)]['gameDays']  = null;
						}
					}


		  }
		} // end of FOR

		//return array('eligible' => $eligible_events, 'non_eligible' => $non_eligible_events);
		//return array('eligible' => $eligible_events);
		return $eligible_events;
	}



	public function registerTemp_get() {

		$tourn_id = $this->input->get('tourn_id');
		$user_id  = $this->input->get('user_id');

		if($tourn_id) {
			$tour_details = $this->mleague->get_league_details($tourn_id);
			//echo "<pre>"; print_r($tour_details['Event_Reg_Limit']); exit;
			if(count($tour_details) > 0) {

				$now		= time();
				$reg_close   = strtotime(date('Y-m-d', strtotime($tour_details['Registrationsclosedon'])));
				$reg_open   = strtotime(date('Y-m-d', strtotime($tour_details['Registrations_Opens_on'])));
				$ref_date     = strtotime(date('Y-m-d', strtotime($tour_details['RefundDate'])));

				$reg_close  = strtotime(date('Y-m-d', strtotime($tour_details['Registrationsclosedon'])));
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
					/*$res = array('Error: ' . "Registrations are not yet opened for this tournament!");
					$this->response($res);
					exit;*/
					$data['is_registration_closed'] = true;
				}

				$data['is_withdraw_closed'] = false;

				if($now > $ref_date) {
					$data['is_withdraw_closed'] = true;
				}

				//	$is_tourn_admin = 0;
			//	if($this->input->get('user_id') == $tour_details['Usersid'])
			//		$is_tourn_admin = 1;

					//$data['is_TournAdmin'] = $is_tourn_admin;

				$tformat	  = $tour_details['tournament_format'];
				$tourn_events = json_decode($tour_details['Multi_Events'], true);

				if($tformat == 'Individual') {
					$check_register = $this->mleague->is_registered($user_id, $tourn_id, 'Indv');
//echo "<pre>"; print_r($check_register); exit;
					//if(count($check_register) == 0) {
					$user_reg_events = null;
					$user_partners		 = null;

					if(count($check_register) > 0) {
						$user_reg_events = json_decode($check_register['Reg_Events'], true);
						//echo "<pre>"; print_r($user_reg_events); exit;
						if($check_register['Partners']){
						$temp = json_decode($check_register['Partners'], true);
						
						foreach($user_reg_events as $ev){
							$user = $temp[$ev];
							$temp_user = null;
							if($user){
								$det = $this->mleague->get_user_details($user);
								$temp_user = array('Firstname' => $det['Firstname'], 'Lastname' => $det['Lastname'], 'ID' => $det['Users_ID']);
							}


							$user_partners[$ev] = $temp_user;
						}
						//$user_partners[]
						}
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
                case $user_age <= 9:
                   $user_age_grp = "U9";
                   break;
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
								$res = array('Error: ' . "User Date of birth is not provided!");
								$this->response($res);
								exit;
							}
							$is_event_limit	   = 0;
							$get_event_limits = '';
							$events_limit_arr  = '';

							if($tour_details['Event_Reg_Limit'] != '' and $tour_details['Event_Reg_Limit'] != NULL){
							$is_event_limit	  = 1;
							$events_limit_arr = json_decode($tour_details['Event_Reg_Limit'], TRUE);
							foreach($tourn_events as $ev){
							$get_event_limits[$ev] = $this->mleague->get_event_reg_count($tourn_id, $ev);
							}
							//echo "test"; exit;
							//echo "<pre>"; print_r($get_event_limits); print_r($events_limit_arr); exit;
							//$tour_details['Event_Reg_Limit']
							}
							$is_league					= 0;
							$league_occrs			= NULL;
							$league_occrs_regs	= NULL;

							if($tour_details['Is_League']){
								$is_league					= 1;
								$league_occrs			= $this->mleague->get_league_occr($tourn_id);
								$league_occrs_regs	= $this->mleague->get_league_occr_regs($tourn_id, $user_id);
							}

							$user_el_events = $this->get_eligible_events_Temp($tourn_events, $user_age_grp, $user_db_age_grp, $user_gender, $user_age, $get_event_limits, $events_limit_arr, $league_occrs, $tour_details['Event_Reg_Fee'], $tour_details['lg_Event_Reg_Fee'], $user_reg_events, $league_occrs_regs);

							//StartDate, TournamentAddress, RegistrationCloseDate

							$data['Tournament_Title']    = $tour_details['tournament_title'];
							$data['Organizer']				= $tour_details['OrganizerName'];
							$data['Contact_Num']			= $tour_details['ContactNumber'];
							$data['Details']					= $tour_details['TournamentDescription'];
							$data['Sport']						= $tour_details['SportsType'];
							if($tour_details['StartDate'])
							$data['StartDate'] = date('Y-m-d', strtotime($tour_details['StartDate']))."T".date('H:i:s', strtotime($tour_details['StartDate'])).".000Z";
							else 
							$data['StartDate']					= NULL;

							if($tour_details['EndDate'])
							$data['EndDate'] = date('Y-m-d', strtotime($tour_details['EndDate']))."T".date('H:i:s', strtotime($tour_details['EndDate'])).".000Z";
							else 
							$data['EndDate']					= NULL;

							if($tour_details['Registrationsclosedon'])
							$data['RegistrationCloseDate'] = date('Y-m-d', strtotime($tour_details['Registrationsclosedon']))."T".date('H:i:s', strtotime($tour_details['Registrationsclosedon'])).".000Z";
							else 
							$data['RegistrationCloseDate'] = NULL;

	
								if($tour_details['venue'])
								$taddress = $tour_details['venue'];

							if($tour_details['TournamentAddress'] and $tour_details['venue'])
								$taddress .= ', ' . $tour_details['TournamentAddress'];
							else if($tour_details['TournamentAddress'])
								$taddress .= $tour_details['TournamentAddress'];

							if($tour_details['TournamentAddress'] and $tour_details['venue'] != $tour_details['TournamentAddress'])
								$taddress .= ", ".$tour_details['TournamentAddress'];

							if($tour_details['TournamentAddress'] and $tour_details['TournamentCity'])
								$taddress .= ", ".$tour_details['TournamentCity'];
							else
								$taddress .= $tour_details['TournamentCity'];

							if($tour_details['TournamentState'])
								$taddress .= ", ".$tour_details['TournamentState'];
							if($tour_details['TournamentCountry'])
								$taddress .= ", ".$tour_details['TournamentCountry'];
							if($tour_details['PostalCode'])
								$taddress .= ", ".$tour_details['PostalCode'];

							$data['TournamentAddress']	= $taddress;

							$data['Tournament_Format']	= $tour_details['tournament_format'];
							$data['Tournament_Type']		= $tour_details['Tournament_type'];
							$data['is_TournAdmin']			= 0;
							//if($user_id == $data['Usersid'] or $user_id == 240)
							if($user_id == $tour_details['Usersid'] or $user_id == 240)
							$data['is_TournAdmin']			= 1;

/*$data['Country']		  = ($tour_details['TournamentCountry'] == 'India') ? 'IN' : $tour_details['TournamentCountry'];*/

							$data['Country']					= $tour_details['TournamentCountry'];
							$data['userAgeGroup']		= $user_db_age_grp;
							$data['Events']					= $user_el_events;
							
							$data['Registered_Events'] = $user_reg_events;
							$data['Partners'] = $user_partners;

$now = time();

//Coupons
/*
$coupons = NULL;
if($tour_details['Is_Coupon']){
	$get_coupons = $this->mleague->get_tourn_coupons($tourn_id);

	foreach($get_coupons as $coupon){
		$exp = strtotime($coupon->Expiry_Date);
		//if($coupon->Status and $coupon->Discount_Method == 'percentage' and $now <= $exp){
		if($coupon->Status and $coupon->Discount_Method == 'percentage'){
			$coupons['percentage'][$coupon->Coupon_Code] = (float) $coupon->Coupon_Value;
		}
		//if($coupon->Status and $coupon->Discount_Method == 'fixedprice' and $now <= $exp){
		if($coupon->Status and $coupon->Discount_Method == 'fixedprice'){
			$coupons['price'][$coupon->Coupon_Code] = (float) $coupon->Coupon_Value;
		}
	}
}
$data['couponCodes'] = $coupons;
*/
//Coupons
							if($tour_details['SportsType'] == 2){
								//$data['usatt_rating_eligibility_date'] = date('m-d-Y', strtotime($tour_details['EligibilityDate']));
								$get_usatt_id		   = $this->muser->get_usatt_id($user_id);
								$data['usatt_id']	   = $get_usatt_id;
								if($get_usatt_id){
									$get_usatt_rating		  = $this->muser->get_usatt_rating($get_usatt_id);
									$data['usatt_rating']  = $get_usatt_rating;
								}
								else{
									$data['usatt_rating']  = 'n/a';
								}
							}

							$data['is_tshirt']				 = $tour_details['TShirt'];
							$data['is_fee']					 = $tour_details['Tournamentfee'];
							$data['is_agegroup_fee']	 = json_decode($tour_details['is_mult_fee'], TRUE);

							$age_groups			= json_decode($tour_details['Age'], TRUE);
							$fee						= json_decode($tour_details['mult_fee_collect'], TRUE);
							$additional_fee		= json_decode($tour_details['addn_mult_fee_collect'], TRUE);
							//$data['age_groups']			= json_decode($tour_details['Age'], TRUE);
							//$data['fee']						= json_decode($tour_details['mult_fee_collect'], TRUE);
							//$data['additional_fee']	= json_decode($tour_details['addn_mult_fee_collect'], TRUE);

							$arr = array();

							foreach($age_groups as $i => $ag){
								$arr[$ag] = array(
													'fee'				   => (float) $fee[$i],
													'additional_fee' => (float) $additional_fee[$i]
													); 
							}
							
							$data['age_based_fee']		= $arr;

							$data['is_event_fee']			= $tour_details['is_event_fee'];
							//$data['fee_event_based']	= json_decode($tour_details['Event_Reg_Fee'], TRUE);
							$data['is_event_limited']	= ($tour_details['Event_Reg_Limit'] != null) ? 1 : 0;
							$data['event_limits']			= json_decode($tour_details['Event_Reg_Limit'], TRUE);
							//$data['event_time']          = json_decode($tour_details['Multi_Event_Time'], TRUE);

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

									$pay_mode		 = null;
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
							$data['link'] = base_url()."league/".$tourn_id."/";


						if($tour_details['MedicalRelease_pdf'] != NULL or $tour_details['MedicalRelease_pdf'] != '') { 
							$url = base_url()."tour_pictures/".$tourn_id."/".$tour_details['MedicalRelease_pdf'];
						}
						else{
							$url = base_url().'medical_form/';
						}

						$data['medical_form'] = $url;

						$tc = base_url().'terms_conditions/';
						$data['terms_conditions'] = $tc;

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
					//$check_register = $this->mleague->is_user_team_registered($user_id, $tourn_id, 'Team');

					//if(count($check_register) == 0) {
					$get_user_teams_1 = $this->muser->get_user_captain_teams($user_id, $tourn_id, $tour_details['SportsType']);
					
						foreach($get_user_teams_1 as $res){
							$tp = json_decode($res->Players, TRUE);
							$tplayers_1 = array();
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
							$data['Organizer']					= $tour_details['OrganizerName'];
							$data['Contact_Num']			= $tour_details['ContactNumber'];
							$data['Details']						= $tour_details['TournamentDescription'];
							$data['Sport']						= $tour_details['SportsType'];
							$data['Tournament_Format']	= $tour_details['tournament_format'];
							$data['Tournament_Type']		= $tour_details['Tournament_type'];

							$data['is_TournAdmin']			= 0;
							//if($user_id == $data['Usersid'] or $user_id == 240)
							if($user_id == $tour_details['Usersid'] or $user_id == 240)
							$data['is_TournAdmin']			= 1;

							if($tour_details['StartDate'])
							$data['StartDate'] = date('Y-m-d', strtotime($tour_details['StartDate']))."T".date('H:i:s', strtotime($tour_details['StartDate'])).".000Z";
							else 
							$data['StartDate']					= NULL;

							if($tour_details['EndDate'])
							$data['EndDate'] = date('Y-m-d', strtotime($tour_details['EndDate']))."T".date('H:i:s', strtotime($tour_details['EndDate'])).".000Z";
							else 
							$data['EndDate']					= NULL;

							if($tour_details['Registrationsclosedon'])
							$data['RegistrationCloseDate'] = date('Y-m-d', strtotime($tour_details['Registrationsclosedon']))."T".date('H:i:s', strtotime($tour_details['Registrationsclosedon'])).".000Z";
							else 
							$data['RegistrationCloseDate'] = NULL;

							if($tour_details['venue'])
								$taddress = $tour_details['venue'];

							if($tour_details['TournamentAddress'] and $tour_details['venue'])
								$taddress .= ', ' . $tour_details['TournamentAddress'];
							else if($tour_details['TournamentAddress'])
								$taddress .= $tour_details['TournamentAddress'];

							if($tour_details['TournamentAddress'] and $tour_details['venue'] != $tour_details['TournamentAddress'])
								$taddress .= ", ".$tour_details['TournamentAddress'];

							if($tour_details['TournamentAddress'] and $tour_details['TournamentCity'])
								$taddress .= ", ".$tour_details['TournamentCity'];
							else
								$taddress .= $tour_details['TournamentCity'];

							if($tour_details['TournamentState'])
								$taddress .= ", ".$tour_details['TournamentState'];
							if($tour_details['TournamentCountry'])
								$taddress .= ", ".$tour_details['TournamentCountry'];
							if($tour_details['PostalCode'])
								$taddress .= ", ".$tour_details['PostalCode'];

								$data['TournamentAddress']	= $taddress;

						$data['Sport']					= $tour_details['SportsType'];
						$data['is_fee']				= $tour_details['Tournamentfee'];
						$data['user_teams']		  = $user_teams;
						$data['is_agegroup_fee']  = json_decode($tour_details['is_mult_fee'], TRUE);
						//$data['age_groups']		  = json_decode($tour_details['Age'], TRUE);
						$age_groups			= json_decode($tour_details['Age'], TRUE);
						$fee						= json_decode($tour_details['mult_fee_collect'], TRUE);
						$additional_fee		= json_decode($tour_details['addn_mult_fee_collect'], TRUE);

						$level_array					  = json_decode($tour_details['Sport_levels'], TRUE);
						$arr = array();

							foreach($age_groups as $i => $ag){
								$arr[$ag] = array(
													'fee'				   => (float) $fee[$i],
													'additional_fee' => (float) $additional_fee[$i]
													); 
							}
							
							$data['age_based_fee']		= $arr;


						foreach($level_array as $la){
							$level_name = $this->mleague->get_level_name($la);
							$levels[$la] = $level_name['SportsLevel'];
						}
						$data['levels']			  = $levels;

						//$data['fee']			  = json_decode($tour_details['mult_fee_collect'], TRUE);
						//$data['additional_fee']   = json_decode($tour_details['addn_mult_fee_collect'], TRUE);

									$pay_mode		 = null;
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
						$data['link'] = base_url()."league/".$tourn_id."/";

						if($tour_details['MedicalRelease_pdf'] != NULL or $tour_details['MedicalRelease_pdf'] != '') { 
							$url = base_url()."tour_pictures/".$tourn_id."/".$tour_details['MedicalRelease_pdf'];
						}
						else{
							$url = base_url().'medical_form/';
						}

						$data['medical_form'] = $url;

						$tc = base_url().'terms_conditions/';
						$data['terms_conditions'] = $tc;


						$res = array($data);
					//}
					/*else {
						$res = array('Error: ' . "Player is already registered for this tournament!");
					}*/
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

	public function validateCoupon_get(){
		$tourn_id			= $this->input->get('tourn_id');
		$couponCode	= $this->input->get('couponCode');
		
		if($tourn_id and $couponCode) {
			$get_coupon = $this->mleague->validateCoupon($tourn_id, $couponCode);

			if($get_coupon){
				if($get_coupon['Status'] == 1 and time() <= strtotime($get_coupon['Expiry_Date']))
					$res = array('type'  => $get_coupon['Discount_Method'], 
										'price' => (float) $get_coupon['Coupon_Value']);

					/*$res = array('type'  => $get_coupon['Discount_Method'], 
										'price' => $get_coupon['Coupon_Value'], 
										'now'  => time(), 
										'exp'	 => strtotime($get_coupon['Expiry_Date']));*/
				else
					$res = array('Error: '."Coupon Expired!", 400);
					//$res = array('now' => time(), 'exp' => (strtotime($get_coupon['Expiry_Date']) + 86399));
			}
			else{
				$res = array('Error: '."Invalid Coupon!", 400);
			}
		}
		else{
			$res = array('Error: '."Provide all inputs!", 400);
		}

		$this->response($res);
	}


	public function registerTemp_post() {
		$post_data = json_decode(trim(file_get_contents('php://input')), true);

		$tourn_id		 = $post_data['tourn_id'];
		$user_id		 = $post_data['user_id'];

		$fee_amount			 = $post_data['fee_amount'];
		$gateway_charges = $post_data['gateway_charges'];
		$transaction_id		 = $post_data['transaction_id'];
		$currency_code		 = $post_data['currency_code'];
		$status					 = $post_data['status'];
		$tshirt_size				 = $post_data['tshirt_size'];
		$note_to_admin		 = $post_data['note_to_admin'];

		$tourn_id		 = trim($tourn_id, '"');
		$tshirt_size	 = trim($tshirt_size, '"');

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

			$tformat		= $tour_details['tournament_format'];
			$ttype			= $tour_details['Tournament_type'];
			$is_league	= $tour_details['Is_League'];
			
			if($tformat == "Teams" or $tformat == "TeamSport") {
				$team_id						= $post_data['team_id'];
				$shortlisted_team		= $post_data['shortlisted_team'];
				$reg_ag_group			= $post_data['reg_ag_group'];
				$reg_sport_level		= $post_data['reg_sport_level'];

				$data['Team_id']					=  $team_id;
				$data['Team_Players']		=  json_encode($shortlisted_team);
				$data['Reg_Age_Group']	 =  $reg_ag_group;
				$data['Reg_Sport_Level']  =  $reg_sport_level;
				
				$check_register = $this->mleague->is_registered($team_id, $tourn_id, 'Team');
			}
			else {
				$reg_events	= $post_data['reg_events'];
				if($reg_events){
					$partners	= $post_data['partners'];
					$game_days = NULL;
					$sp_events   = NULL;

					if($is_league){
						foreach($reg_events as $event => $game_day){
							foreach($game_day as $gm){
								if(!in_array($gm, $game_days)){
								$game_days[] = $gm;
								}
							}
							$sp_events[] = $event;
						}
					}
					else{
						$data['Reg_Events']	=  json_encode($reg_events);
					}

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
			//echo "<pre>"; print_r($sp_events); exit;
			if($ttype == 'Flexible League') {
				$hcl_id			= $post_data['hcl_id'];
				$data['hcl_id']	= $hcl_id;
			}
			
//echo count($check_register); exit;

			if(count($check_register) == 0) {

					if($sp_events){
						$data['Reg_Events']	=  json_encode($sp_events);
					}
					
					//echo "<pre>"; print_r($data); exit;

					$ins			= $this->mleague->inset_reg_tourn($data);
					$ins_a2m	= $this->mleague->inset_user_a2m($user_id, $tour_details['SportsType']);
					$ins_si		= $this->mleague->inset_user_si($user_id, $tour_details['SportsType']);

					if($tformat != "Teams" or $tformat != "TeamSport") {
							$get_a2m = $this->mleague->get_user_a2m($user_id, $tour_details['SportsType']);
							if($get_a2m){
								$init_a2m = max($get_a2m['A2MScore'], $get_a2m['A2MScore_Doubles'], $get_a2m['A2MScore_Mixed']);
								$upd_reg_a2m = $this->mleague->upd_reg_a2m($ins, $init_a2m);
							}
					}

					$res				= array('Success: ' . "User / Team successfully registered.");

					$dev_email	 = "pradeepkumar.namala@gmail.com";
					$dev_subject = "A2M Mobile Post variables - Production";
					$data2		 = array('firstname'	=> "Developer",
												'post_vals'	=> print_r($data, true),
												'page'		=> 'A2M Mobile Post');

					$this->email_to_player($dev_email, $dev_subject, $data2);

			//$res = array($data);
			}
			else {
					//res = array('Error: ' . "User / Team already Registered for this tournament!");
					$get_reg_events  = $this->mleague->get_reg_events($user_id, $tourn_id);
					$ins					  = $get_reg_events['RegisterTournament_id'];

					if($get_reg_events['Reg_Events']){

						$prev_reg_events  = json_decode($get_reg_events['Reg_Events'], true);

						foreach($sp_events as $new_ev){
							if(!in_array($new_ev, $prev_reg_events)){
								array_push($prev_reg_events, $new_ev);
							}
						}
					}

					$data3['upd_events']			= $prev_reg_events;
					$data3['Tournament_ID']	= $data['Tournament_ID'];
					$data3['Users_ID']				= $data['Users_ID'];

					$data2['Tournament_ID'] = $data['Tournament_ID'];
					$data2['pay_date']  = date('Y-m-d H:i:s');
					$data2['pay_date']  = $data['Tournament_ID'];
					$data2['Users_ID']  = $data['Users_ID'];
					$data2['mtype']	    = 'tournament';
					$data2['mtype_ref'] = $data['Tournament_ID'];
					$data2['Amount']	= number_format($fee_amount, 2);
					$data2['Transaction_id'] = $transaction_id;
					$data2['Status']	= $status;

					$upd	 = $this->mleague->update_reg_tourn($data3);
					$ins_pay = $this->mleague->insert_pay_transaction($data2);

					$res = array('Success: ' . "User / Team successfully registered.");

			}
			if($game_days){
				$ins_game_days = $this->mleague->ins_game_days($ins, $user_id, $game_days);
			}
		}
		else {
			$res = array('Error: ' . "Invalid Tournament ID!");
		}


		if($res) {
			$this->response($res);
		}
	}

	public function regenerate_events($mult_events){
			$revised_array = array();

			foreach($mult_events as $key => $val){
				if(is_numeric($key)){
				   $arr = explode('-', $val);
				   $ag		= $arr[0];
				   if($arr[1] != 'Mixed'){
					   if(in_array($arr[1], array('Singles','Doubles'))){
						   $gen		= '';
						   $format	= $arr[1];
						   $level	= $arr[2];
					   }
					   else{
						   $gen		= $arr[1];
						   $format	= $arr[2];
						   $level	= $arr[3];
					   }
				   }
				   else{
					   $gen		= $arr[1];
					   $format	= '';
					   $level	= $arr[2];
				   }
					
				   $gen = $this->config->item($arr[0].'-'.$gen, 'age_gender_values');

				   if( $arr[1] != 'Open')
				   $get_level_label = $this->mleague->get_level_name($level);

					$lbl = '';
					$lbl = ' '.$get_level_label['SportsLevel'];
				   $revised_array[$val] = $gen.' '.$format.$lbl;
				}
			}
			return $revised_array;
	}


}