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
class Clubs extends REST_Controller {

    public function __construct() {
        // Construct the parent class
        parent::__construct();

		$this->load->model('score/model_club','mclub');
		$this->load->model('score/model_user','muser');
		//$this->load->model('score/model_general','general');
    }

	public function add_post() {
		$post_data = json_decode(file_get_contents('php://input'), true);

		$user_id					= trim($post_data['user_id'], '"');
		if($post_data['club_name']) {
			$data['Aca_name']			= addslashes(trim($post_data['club_name'], '"'));
			$data['Aca_addr1']			= trim($post_data['addr1'], '"');
			$data['Aca_addr2']			= trim($post_data['addr2'], '"');
			$data['Aca_zip']			= trim($post_data['zipcode'], '"');
			$data['Aca_city']			= trim($post_data['city'], '"');
			$data['Aca_state']			= trim($post_data['state'], '"');
			$data['Aca_country']		= trim($post_data['country'], '"');
			$data['Aca_url']			= trim($post_data['web_url'], '"');
			if($post_data['cont_name'])
				$data['Aca_contact_name']	= addslashes(trim($post_data['cont_name'], '"'));
			$data['Aca_contact_phone']	= trim($post_data['cont_phone'], '"');
			$data['Aca_contact_email']	= trim($post_data['cont_email'], '"');
			if($post_data['details'])
				$data['Aca_details']	= addslashes(trim($post_data['details'], '"'));
			$data['Aca_no_of_courts']	= trim($post_data['no_of_courts'], '"');
			$data['Aca_sport']			= json_encode(explode(',', $post_data['club_sports']));
			$data['Aca_User_id']		= trim($post_data['user_id'], '"');
			$data['Aca_timings']		= trim($post_data['timings'], '"');
		
			$ins_club  = $this->mclub->AddClub($data);

			if($ins_club) {
				$res = array('Success: ' . "Club details added successfully.");
			}
			else {
				$res = array('Error: ' . "Something went wrong!");
			}
		}
		else {
			$res = array('Success: ' . "Club name missing!");
		}

		$this->response($res);
	}
	public function listAll_get(){
		
		$get_club_list = $this->mclub->get_clubs();
		
		foreach($get_club_list as $club){
			$data = array();
			$data['Club_ID']	= $club->Aca_ID;
			$data['Club_Name']	= $club->Aca_name;
			$data['Address1']	= $club->Aca_addr1;
			$data['Address2']	= $club->Aca_addr2;
			$data['City']		= $club->Aca_city;
			$data['State']		= $club->Aca_state;
			$data['Country']	= $club->Aca_country;
			$data['Zip']		= $club->Aca_zip;
			$data['Club_URL']	= $club->Aca_ID;
			$data['Club_Logo']	= base_url().'org_logos/'.$club->Aca_logo;

			$data2[] = $data;
		}

		$this->response($data2);
	}

	public function listPNP_get(){
		
		$get_club_list = $this->mclub->get_clubs_having_courts();
		
		foreach($get_club_list as $club){
			$data = array();
			$temp = array();
			$data['Club_ID']	= $club->Aca_ID;
			$data['Club_Name']	= $club->Aca_name;
			$data['Address1']	= $club->Aca_addr1;
			$data['Address2']	= $club->Aca_addr2;
			$data['City']		= $club->Aca_city;
			$data['State']		= $club->Aca_state;
			$data['Country']	= $club->Aca_country;
			$data['Zip']		= $club->Aca_zip;
			$data['Club_URL']	= $club->Aca_ID;
			$data['Club_Logo']	= base_url().'org_logos/'.$club->Aca_logo;
		
			$get_club_loc = $this->mclub->get_clubs_locations($club->Aca_ID);

				foreach($get_club_loc as $club_loc){
					$data2 = array();
					$data2['loc_id']   = $club_loc->loc_id;
					$data2['location'] = $club_loc->location;
					$data2['address']  = $club_loc->address;
					$data2['city']     = $club_loc->city;
					$data2['state']    = $club_loc->state;
					$temp[] = $data2;
				}

			$data['Club_court_locations'] = $temp;
			$data3[] = $data;
		}

		$this->response($data3);
	}

	public function courts_get(){

		$loc_id = $this->input->get('loc_id');
	
		if($loc_id) {
			$get_loc_courts = $this->mclub->get_loc_courts($loc_id);
			foreach($get_loc_courts as $court){
				$data		  = array();
				$court_prices = array();

				$data['court_id']		= $court->court_id;
				$data['court_name']		= $court->court_name;

				$c_timings = array(
					'actual_timings'=>json_decode($court->court_timings, true),
					'break'=>json_decode($court->break_timings, true),
					'step'=>'0.5',
					'min_booking_hours'=>'0.5',
					'max_booking_hours'=>$court->max_hours,
					'open_days' =>json_decode($court->open_days, true),
					'close_days'=>json_decode($court->close_days, true),
					);
				$data['court_timings']	=$c_timings;

				$get_court_prices = $this->mclub->get_court_prices($court->court_id);
	//echo "<pre>"; print_r($get_court_prices); 
				$prices = array();
				
				$i = 1;
				foreach($get_court_prices as $court_price){

					
					//if(!in_array($court_price->Start_Time, $comp_timings)){
					 $prices["sun"][$i] = array( 
											 "price"		 => number_format($court_price->Sun_Price, 2),
											 "start_time"	 => date('H:i', strtotime($court_price->Start_Time)), 
											 "end_time"	     => date('H:i', strtotime($court_price->End_Time)), 
											 "pricing_range" => "{$i}"
											 );

					 $prices["mon"][$i] = array( 
											 "price"		 => number_format($court_price->Mon_Price, 2),
											 "start_time"	 => date('H:i', strtotime($court_price->Start_Time)), 
											 "end_time"	     => date('H:i', strtotime($court_price->End_Time)), 
											 "pricing_range" => "{$i}"
											 );

					 $prices["tue"][$i] = array( 
											 "price"		 => number_format($court_price->Tue_Price, 2),
											 "start_time"	 => date('H:i', strtotime($court_price->Start_Time)), 
											 "end_time"	     => date('H:i', strtotime($court_price->End_Time)), 
											 "pricing_range" => "{$i}"
											 );

					 $prices["wed"][$i] = array( 
											 "price"		 => number_format($court_price->Wed_Price, 2),
											 "start_time"	 => date('H:i', strtotime($court_price->Start_Time)), 
											 "end_time"	     => date('H:i', strtotime($court_price->End_Time)), 
											 "pricing_range" => "{$i}"
											 );

					 $prices["thu"][$i] = array( 
											 "price"		 => number_format($court_price->Thu_Price, 2),
											 "start_time"	 => date('H:i', strtotime($court_price->Start_Time)), 
											 "end_time"	     => date('H:i', strtotime($court_price->End_Time)), 
											 "pricing_range" => "{$i}"
											 );

					 $prices["fri"][$i] = array( 
											 "price"		 => number_format($court_price->Fri_Price, 2),
											 "start_time"	 => date('H:i', strtotime($court_price->Start_Time)), 
											 "end_time"	     => date('H:i', strtotime($court_price->End_Time)), 
											 "pricing_range" => "{$i}"
											 );

					 $prices["sat"][$i] = array( 
											 "price"		 => number_format($court_price->Sat_Price, 2),
											 "start_time"	 => date('H:i', strtotime($court_price->Start_Time)), 
											 "end_time"	     => date('H:i', strtotime($court_price->End_Time)), 
											 "pricing_range" => "{$i}"
											 );

					//}
					//$comp_timings[] = $court_price->Start_Time;
					$i++;

					
				}
				$court_prices[] = $prices;
				
				$data['court_prices'] = $court_prices;

				$get_court_bookings = $this->mclub->get_court_bookings($court->court_id);
				$bookings = array();
				foreach($get_court_bookings as $booking) {
						$from = date('D Y-m-d H:i:s', strtotime($booking->res_date.' '.$booking->from_time));
						$to	  = date('D Y-m-d H:i:s', strtotime($booking->res_date.' '.$booking->to_time));
						$bookings[] = array('from' => $from, 'to' => $to);
				}
				$data['current_bookings'] = $bookings;

				$data2[] = $data;
			}
			
			$this->response($data2);
		}
		else {
			$res = array('Success: ' . "Missing Location ID");
			$this->response($res);
		}

	}

	public function reserve_court_post() {

		$post_data = json_decode(trim(file_get_contents('php://input')), true);

			if(!$post_data){
			$this->response(array('Error: ' . "Empty!")); 
			}

		$data['court_id']		 = $post_data['court_id'];
		$data['loc_id'] 		 = $post_data['loc_id'];
		$data['reserved_by']	 = $post_data['user_id'];
		$res_date				 = date('Y-m-d', strtotime($post_data['res_from']));
		$res_from				 = date('H:i:s', strtotime($post_data['res_from']));
		$res_to					 = date('H:i:s', strtotime($post_data['res_to']));

		$data['res_date']		 = $res_date;
		$data['from_time']		 = $res_from;
		$data['to_time']		 = $res_to;
		$data['created_on']		 = date('Y-m-d H:i:s');
		$data['fee_paid']		 = $post_data['booking_amt'];
		$data['trans_id']		 = $post_data['transaction_id'];
		$data['paid_date']		 = date('Y-m-d H:i:s');
		$data['res_status']		 = "Active";

		$res_court = $this->mclub->reserve_court($data);

		if($res_court)
		 $res = array('Success: '."Court Reservation Done");
		else
		 $res = array('Error: '."Undone, Try again!");

		$this->response($res);
	}

	public function paytmChecksum_get(){

		$court_id	= $this->input->get('court_id');
		$user_id	= $this->input->get('user_id');
		$txn_amount = $this->input->get('amount');

		$court_det  = $this->mclub->get_court_info($court_id);
		
		if(!$court_id or !$user_id or !$txn_amount){
			$res = array('Error: '."Please provide all the information (CourtID, UserID, Amount)");
			$this->response($res);
			exit;
		}
	
		if($court_det){

			if($court_det['gateway_name'] == 'paypal'){
				$get_det = $this->muser->get_paytm($court_det['payment_ref_id']);
			}
			else{
				$get_det = $this->muser->get_paytm('1');
			}
	
		$PAYTM_MERCHANT_MID = $get_det['paytm_merch_id'];
		$PAYTM_MERCHANT_KEY = $get_det['paytm_merchant_key'];

		 require_once(APPPATH . "/third_party/paytm/config_paytm.php");
		 require_once(APPPATH . "/third_party/paytm/encdec_paytm.php");

		 $order_id = $court_id.'_'.$user_id.'_'.rand(1,10000000);
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
		 $paramList["CALLBACK_URL"] = 'https://a2msports.com/rest_services/clubs/paytmSuccess';

		 $checkSum = "";
		 $checkSum = getChecksumFromArray($paramList, PAYTM_MERCHANT_KEY);

		  $htmlForm = "<html><head><title>Merchant Check Out Page</title></head><body><center><h1>Please do not refresh this page...</h1></center><form method='post' action='".PAYTM_TXN_URL."' name='f1'><table border='1'><tbody>";

			 foreach($paramList as $name => $value) {
			 $htmlForm .= '<input type="hidden" name="'.$name.'" value="'.$value.'" />';
			 }

		$htmlForm .= "<input type='hidden' name='CHECKSUMHASH' value='".$checkSum."' /></tbody></table><script type='text/javascript'>
		document.f1.submit();</script></form></body></html>";

		$data['htmlForm'] = $htmlForm;
		echo $htmlForm;
		}
		else{
			$res = array('Error: '."Invalid Court / Court may be inactive!");
			$this->response($res);
		}

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

	public function user_bookings_get(){

		$user_id	= $this->input->get('user_id');
		
		if($user_id){
			$res_court = $this->mclub->get_user_bookings($user_id);
			
			foreach($res_court as $booking) {
					$from = date('D Y-m-d H:i:s', strtotime($booking->res_date.' '.$booking->from_time));
					$to	  = date('D Y-m-d H:i:s', strtotime($booking->res_date.' '.$booking->to_time));
					$bookings[] = array('booking_id' => $booking->res_date, 'from' => $from, 'to' => $to);
			}
			$data['user_bookings'] = $bookings;

			$this->response($data);
		}
	}

	public function reserve_cancel_post(){
		$post_data = json_decode(trim(file_get_contents('php://input')), true);

			if(!$post_data){
			$this->response(array('Error: ' . "Empty!")); 
			}

		//$data['court_id']	 = $post_data['court_id'];
		$booking_id	= $post_data['booking_id'];
		//$data['reserved_by'] = $post_data['user_id'];
		

		$cancel_res = $this->mclub->cancel_res($booking_id);
		if($cancel_res){
			$this->response(array('Success: '."Reservation has canceled.")); 
		}
		else{
			$this->response(array('Error: '."Something went wrong. please contact admin.")); 
		}


	}
}