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
}