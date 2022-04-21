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

class Events extends REST_Controller {

    public function __construct() {
        // Construct the parent class
        parent::__construct();

		$this->load->model('score/model_event','mevents');
		$this->load->model('score/model_user','muser');
		$this->load->model('score/model_general','general');
    }

	public function list_get(){
		$club_id	= $this->input->get('club_id');
		//$user_id   = $this->input->get('user_id');

		$get_events = $this->mevents->get_events($club_id);
		$data['events'] = $get_events;

		$this->response($data);
	}

	public function listNew_get(){
		$club_id	= $this->input->get('club_id');
		$user_id   = $this->input->get('user_id');

		$get_events = $this->mevents->get_eventsNew($club_id);
		$data['events'] = $get_events;

		$this->response($data);
	}

	public function details_get(){
		$event_id	= $this->input->get('event_id');
		$user_id   = $this->input->get('user_id');

		$event_info		= $this->mevents->event_details($event_id);
		$event_dates	= $this->mevents->event_dates($event_id);


		$data['event_details']							= $event_info;
		$data['event_details']['event_dates']		= $event_dates;
		$data['event_details']['paymethods']		= array('pay_method' => 'paypal', 'reference_id' => 5);
		$data['event_details']['link']					= base_url()."events/".$event_id."/";
		
		if($user_id){
		$user_status = $this->mevents->get_event_userStatus($event_id, $user_id);
		$data['event_details']['status']					= $user_status;
		}

		$this->response($data);
	}

/*
{
	"event_id": 166,
	"user_id": 2440,
	"event_dates": [{
			"Ev_Tab_ID": 830,
			"status": "ACCEPTED"
		},
		{
			"Ev_Tab_ID": 830,
			"status": "TENTATIVE"
		}
	]
        transaction_id: "2341" or null,
        fees: 20 or  null
}
	*/

	public function register_post(){

		$post_data = json_decode(trim(file_get_contents('php://input')), true);

		$event_id		  = $post_data['event_id'];
		$user_id		  = $post_data['user_id'];
		$event_occrs = $post_data['event_dates'];
		$trans_id		  = $post_data['transaction_id'];
		$fees			  = $post_data['fees'];

		if(!$user_id){ echo "Invalid Request!"; exit; }

		$create_inv = '';
		foreach($event_occrs as $occr) {
			$occr_id		  = $occr['Ev_Tab_ID'];
			$occr_status = $occr['status'];
			//print_r($occr);
			$data			= array('Ev_ID' => $event_id, 'Ev_Rep_ID' => $occr_id, 'Users_Id' => $user_id);
			//print_r($data); exit;
			$is_ev_user = $this->mevents->get_event_inv($data);

			if(!$is_ev_user){
				$check_rep_id = $this->mevents->check_event_rep($event_id, $occr_id);
				if($check_rep_id){
					$data['user']			 = $user_id;
					$data['event_id']   = $event_id;
					$data['ev_rep_id'] = $occr_id;
					$data['ev_status'] = $occr_status;

					$create_inv = $this->mevents->ins_ev_invite($data);	
				}
			}
			else{
					$data['Users_Id']		= $user_id;
					$data['Ev_ID']			= $event_id;
					$data['Ev_Rep_ID']	= $occr_id;

					$data2['Ev_status']	= $occr_status;
//echo "<pre>"; print_r($data);print_r($data2); exit;
					$create_inv = $this->mevents->upd_ev_invite($data, $data2);
			}

		}

		if($trans_id){
			$data = array('pay_date' => date("Y-m-d H:i"), 'Users_ID' => $user_id, 'mtype' => 'event', 'mtype_ref' => $event_id, 'Transaction_id' => $trans_id, 'Amount' => number_format($fees, 2), 'Status' => 'Completed');
					$create_pay_trans = $this->mevents->ins_pay_trans($data);	
		}

		if($create_inv)
			$this->response("Success", 200);
		else
			$this->response("Fail", 400);

	}


	public function paypalChecksum_get(){

		$ev_id			= $this->input->get('event_id');
		$user_id		= $this->input->get('user_id');
		$txn_amount = $this->input->get('amount');

		$ev_det   = $this->mevents->get_event_info($ev_id);
		
		if(!$ev_id or !$user_id or !$txn_amount){
			$res = array('Error: '."Please provide all the information (EventID, UserID, Amount)");
			$this->response($res);
			exit;
		}
	
		if($ev_det){

			$this->load->library('paypal_lib');

			/*if(($tour_det['Merchant_Paypal'] == NULL or 
				$tour_det['Merchant_Paypal'] == 'NULL') and 
				$tour_det['TournamentCountry'] != 'India'){

				$res = array('Error: '."This league should not be paid with Paytm!");
				$this->response($res);
				exit;
			}*/


			//if($ev_det['Merchant_Paypal']){
			//	$get_det = $this->muser->get_paypal($ev_det['Merchant_Paypal']);
			//}
			//else{
			//	$get_det = $this->muser->get_paypal('5');
			//}

				$get_det = $this->muser->get_paypal('5');

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
				$this->paypal_lib->add_field('event_id', $ev_id);
				//$this->paypal_lib->add_field('player', $this->logged_user);
				$this->paypal_lib->add_field('on0', $user_id);
				$this->paypal_lib->add_field('item_number', $ev_id);
				$this->paypal_lib->add_field('item_name', $ev_det['Ev_Title']);
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
			$res = array('Error: '."Invalid Event!");
			$this->response($res);
		}
	}

	public function participants_get(){

		$ev_id			= $this->input->get('event_id');
		$user_id		= $this->input->get('user_id');
		$participants= $this->mevents->get_participants($ev_id);
		$this->response($participants);
	}

		 public function addEventLocation_post()
		 {
			$post_data = json_decode(trim(file_get_contents('php://input')), true);

			$title		= $data['title'] 	= trim($post_data['title'], '"');
			$address	= $data['add'] 		= trim($post_data['address'], '"');
			$city		= $data['city'] 		= trim($post_data['city'], '"');
			$state		= $data['state'] 	= trim($post_data['state'], '"');
			$country	= $data['country'] 	= trim($post_data['country'], '"');
			$zipcode	= $data['zip'] 		= trim($post_data['zipcode'], '"');
			
			$user_id	= $data['user_id'] 	= trim($post_data['user_id'], '"');
			
			//$event_location = $add . " " .$city . " " . $state . " " . $country;
			if($zipcode)
			$data['latt'] = $this->get_geo_loc($zipcode);
			$ins_loc 	  = $this->mevents->create_event_location($data);
			$location[$ins_loc] = $title;			 
			
			$this->response($location);
			 
		 }
	
		 public function get_geo_loc($zipcode){

			$geocodeFromAddr = file_get_contents("https://maps.googleapis.com/maps/api/geocode/json?address=".$zipcode."&key=".GEO_LOC_KEY);

			$output1 = json_decode($geocodeFromAddr);
	
			//Get latitude and longitute from json data
			$result = array('latitude'  => $output1->results[0]->geometry->location->lat,
							'longitude' => $output1->results[0]->geometry->location->lng);


			return $result;
		}
		
		 public function autocomplete_get() {

			 	$q				  = $this->input->get('q');
				$type		  = $this->input->get('type');
				$club_id	  = $this->input->get('club_id');
				$data_new = array('');

				switch($type) {
				case 'users':
					$data['key']	  = trim($q);
					$data['club_id']	  = trim($club_id);
					$result = $this->mevents->search_autocomplete_users($data);

					if($result) {
						$data_new = array();
						foreach($result as $row) {
							$name = array();
							//$name = $row->Users_ID.'|'.$row->Firstname.' '.$row->Lastname;
							$name[$row->Users_ID] = $row->Firstname.' '.$row->Lastname;
							array_push($data_new, $name);	
						}
					}
				break;
				
				case 'event_locations':
					$data['key']	  = trim($q);
					$result = $this->mevents->search_autocomplete_event_locations($data);

					if($result) {
						$data_new = array();
						foreach($result as $row) {
							$name = array();
							//$name = $row->Users_ID.'|'.$row->Firstname.' '.$row->Lastname;
							$name[$row->loc_id] = $row->loc_title;
							array_push($data_new, $name);	
						}
					}
				break;
				}

			 $this->response($data_new);
			 //return $data_new;
		 }


	public function event_types_get(){
			$get_event_types = $this->mevents->get_event_types();
			 $this->response($get_event_types);
	}

	public function create_post(){

		$post_data = json_decode(trim(file_get_contents('php://input')), true);
		/*
		{
			"title": "Raj’s Birthday Bash",
			"type": "Birthday",
			"startTime": 1649489400,
			"endTime": 1649493000,
			"noOfSessions": 1,
			"cron": null,
			"occurenceType": "ONE_TIME",
			"invitees": {
				"users": [237, 2440, 240]
			},
			"location": "Atlanta Badminton Club, Suwanee, Georgia",
			"description": "Some Description about the event",
			"private": false,
			"fees": {
				"oneTimeFee": 25
			},
			"notes": "Get your own cakes",
			"organizedBy": {
				"id": 240,
				"name": "Raj Kosaraju",
				"contact": "+16786543778",
			}
		}
		*/
//echo "<pre>"; print_r($post_data); exit;
		$ev_title				= $data['ev_title']	 = $post_data['title'];
		$ev_type			= $data['ev_type'] = $post_data['type'];

		$ev_st_time		= $data['ev_st_time']	 = $post_data['startTime'];
		$ev_ed_time		= $data['ev_ed_time']	 = $post_data['endTime'];

		$ev_reps[] = $data['ev_reps'][] =  array('startTime' => $ev_st_time, 'endTime' => $ev_ed_time);

		if($post_data['sessionDates']){
			foreach($post_data['sessionDates'] as $i => $sesdt){
				$ev_reps[] = $data['ev_reps'][] = $sesdt;
			}
		}

		if($post_data['occurenceType'] == 'ONE_TIME')
			$ev_schedule			 = $data['ev_schedule']	 = 'singleday';
		else
			$ev_schedule			 = $data['ev_schedule']	 = 'multiple';


		$ev_invitees_users		 = $data['ev_invitees_users']		= NULL;
		$ev_invitees_clubs		 = $data['ev_invitees_clubs']		= NULL;
		$ev_invitees_teams		 = $data['ev_invitees_teams']		= NULL;
		$ev_invitees_leagues	 = $data['ev_invitees_leagues']	= NULL;

		if($post_data['invitees']['users'])
		$ev_invitees_users	 = $data['ev_invitees_users']		= $post_data['invitees']['users'];

		if($post_data['invitees']['clubs'])
		$ev_invitees_clubs	 = $data['ev_invitees_clubs']	= json_encode($post_data['invitees']['clubs']);

		if($post_data['invitees']['teams'])
		$ev_invitees_teams	 = $data['ev_invitees_teams']	= json_encode($post_data['invitees']['teams']);

		if($post_data['invitees']['leagues'])
		$ev_invitees_leagues	 = $data['ev_invitees_leagues']	= json_encode($post_data['invitees']['leagues']);


		$ev_loc				 = $data['ev_loc']				= $post_data['location'];
		$ev_desc			= $data['ev_desc']				= $post_data['description'];

		if($post_data['private'])
			$is_private			= $data['is_private']	 = 1;
		else
			$is_private			= $data['is_private']	 = 0;

		$ev_img				= $data['ev_img']				= $post_data['coverPhoto'];
		$ev_fee				= $data['ev_fee']				= $post_data['fees']['oneTimeFee'];
		$ev_notes			= $data['ev_notes']			= $post_data['notes'];

		$ev_created_by		= $data['ev_created_by']		= $post_data['organizedBy']['id'];
		$ev_organizer		= $data['ev_organizer']			= $post_data['organizedBy']['name'];
		$ev_org_contact	= $data['ev_org_contact']	= $post_data['organizedBy']['contact'];

		//	 echo "<pre>"; print_r($data); exit;

		$cr_event = $this->mevents->create_event($data);
		
		if($cr_event)
			 $this->response(array('Success'), 200);
		else
			 $this->response(array('Something went wrong!'), 400);

	}

	public function imgUpload_post() {
		 $filename = 'EventImage';  

		 $config = array(
			'upload_path'	=> "./events_pictures/",
			'allowed_types' => "gif|jpg|png|jpeg",
			'overwrite'			=> FALSE,
			'max_size'			=> "10000", // Can be set to particular file size , here it is 2 MB(2048 Kb)
			'max_height'		=> "5000",
			'max_width'		=> "8000"
		 );
		
		$this->load->library('upload', $config);
		$data = $this->upload->data();
		$this->upload->initialize($config);

		if($this->upload->do_upload($filename)) {
		    $data			= $this->upload->data();
			$filename	= $data['file_name'];
			$this->response(array('Filename' => $filename), 200);
		}
		else {
			$this->response(array('Error: File not saved!'), 400);
		}
	}

}