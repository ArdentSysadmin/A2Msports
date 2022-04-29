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
class Profile extends REST_Controller {

    public function __construct() {
        // Construct the parent class
        parent::__construct();

		$this->load->model('score/model_user','muser');
    }

	public function userdet_post() {
		$post_data = json_decode(file_get_contents('php://input'), true);

			/*if($post_data){
				$this->response($a); 
			}
			exit;*/
		$user_id					= trim($post_data['user_id'], '"');

		$data['Mobilephone']		= trim($post_data['mphone'], '"');
		$data['HomePhone']			= trim($post_data['hphone'], '"');
		$data['UserAddressline1']	= trim($post_data['addr1'], '"');
		$data['UserAddressline2']	= trim($post_data['addr2'], '"');
		$data['Country']			= trim($post_data['country'], '"');
		$data['State']				= trim($post_data['state'], '"');
		$data['City']				= trim($post_data['city'], '"');
		$data['Zipcode']			= trim($post_data['zip_code'], '"');

		$data['NotifySettings']		= json_encode(explode(',', $post_data['notify']));

		$zip_code = $data['Zipcode'];
		$country  = $data['Country'];

        $geo_cord	 = $this->get_lang_latt($zip_code, $country);
		//$ex = explode('@', $geo_code);

		$data['Latitude']  = $geo_cord[0];
		$data['Longitude'] = $geo_cord[1];

		$ins_user	 = $this->muser->user_update($data, $user_id);

		if($ins_user) {
			$res = array('Success: ' . "Profile Updated!");
		}
		else {
			$res = array('Error: ' . "Something went wrong!");
		}

		$this->response($res);
	}

	public function user_coach_post() {
		$post_data = json_decode(trim(file_get_contents('php://input')), true);

		$user_id					= trim($post_data['user_id'], '"');

		$data['Is_coach']			= 1;
		$data['coach_sport']		= trim($post_data['coach_sport'], '"');
		$data['Coach_Website']		= trim($post_data['coach_website'], '"');
		$data['coach_profile']		= trim($post_data['coach_profile'], '"');

		$ins_user	 = $this->muser->user_update($data, $user_id);

		if($ins_user) {
			$res = array('Success: ' . "Coach Profile Updated!");
		}
		else {
			$res = array('Error: ' . "Something went wrong!");
		}

		$this->response($res);
	}

	public function user_sports_post() {
		$post_data		= json_decode(trim(file_get_contents('php://input')), true);
		
		$user_id	    = trim($post_data['user_id'], '"');
		$sport_intrests = $post_data['sport_interests'];

		$this->muser->user_sp_intrests_remove($user_id);

		foreach($sport_intrests as $sport => $level){
			if($level){
			$upd = $this->muser->user_sp_intrests($user_id, $sport, $level);
			}
		}
		
		if($upd) {
			$res = array('Success: ' . "Sport Interests are Updated!");
		}
		else {
			$res = array('Error: ' . "Something went wrong!");
		}

		$this->response($res);
	}

	public function user_membership_post() {
		$post_data = json_decode(trim(file_get_contents('php://input')), true);

		$user_id	= $data['Users_id']  = trim($post_data['user_id'], '"');
		$org_id		= $data['org_id']	 = trim($post_data['org_id'], '"');
		$member_id	= $data['membership_id'] = trim($post_data['membership_id'], '"');
		$sport		= $data['sport'] 	 = trim($post_data['sport'], '"');

		if($user_id) {

			$upd = $this->muser->add_user_membership($data);
		//$this->response(array($upd));
		//exit;

			if($upd){
				$res = array('Success: ' . "Membership  details are {$upd}!");
			}
			else {
				$res = array('Error: ' . "Something went wrong!");
			}
		}
		else {
			$res = array('Error: ' . "User ID required!");
		}

		$this->response($res);
	}

	public function get_lang_latt($zipcode, $country)
	{
		 $address =  $zipcode . ' ' . $country;

			if(!empty($address)) {
				//Formatted address
				$formattedAddr = str_replace(' ','+',$address);

				//Send request and receive json data by address
				$geocodeFromAddr = file_get_contents("https://maps.googleapis.com/maps/api/geocode/json?address=".$formattedAddr."&key=".GEO_LOC_KEY); 

				$output1 = json_decode($geocodeFromAddr);
				
				$latitude  = 0.00; 
				$longitude = 0.00;

				//Get latitude and longitute from json data
				$latitude  = $output1->results[0]->geometry->location->lat;
				$longitude = $output1->results[0]->geometry->location->lng;

				return array($latitude, $longitude);
			}
			else {
				return false;
			}
	}

	public function contact_player_post(){

		$post_data = json_decode(trim(file_get_contents('php://input')), true);

		$from_user	= trim($post_data['from_user'], '"');
		$to_user	= trim($post_data['to_user'], '"');
		$message	= trim($post_data['message'], '"');

		if($from_user and $to_user) {

			$get_from = $this->muser->get_user_details($from_user);
			$get_to   = $this->muser->get_user_details($to_user);

				$from_email = "admin@a2msports.com";

				$from_name  = $get_from['Firstname']." ".$get_from['Lastname'];
				$to_email = $get_to['EmailID'];

				if(empty($to_email)){
					$to_email = $get_to['AlternateEmailID'];
				}

				$this->load->library('email');
				$this->email->set_newline("\r\n");
				$this->email->from($from_email, $from_name);
				$this->email->to($to_email);				
				$this->email->subject('Contact Message - '.$from_name.'/A2MSports');

				$data = array(
				  'fname'	 => $get_to['Firstname'],
				  'lname'	 => $get_to['Lastname'],
				  'from_name'=> $from_name,
				  'from_id'	 => $from_user,
				  'message'	 => $message,
				  'page'	 => 'Contact Player'
				);

				$body = $this->load->view('view_email_template.php', $data, TRUE);
				$this->email->message($body);   
				$res = $this->email->send();
				
				$get_user_token = $this->muser->get_userToken($to_user);

				if($get_user_token){
					$msg_payload = array (
						'title' => 'Contact Message from '.$from_name,
						'body'  => $message
						);

					foreach($get_user_token as $i => $ut){
						$regId		  = $ut->token;
						$mobile_notif = $this->android($msg_payload, $regId);
						$r = json_decode($mobile_notif);
					}
				}

				if($res){
					$res2 = array('Success: ' . "Contact Message sent to user successfully");
				}
				else{
					$res2 = array('Error: ' . "Mail not able to sent!");
				}
		}
		else{
			$res2 = array('Error: ' . "From / To user ids are required!");
		}

		$this->response($res2);
	}

		        // Sends Push notification for Android users
		public function android($data, $reg_id) {
	        $url = 'https://fcm.googleapis.com/fcm/send';
	        /*$message = array(
	            'body'	 => $data['mdesc'],
	            'title'	 => $data['mtitle']
	        );*/
	        $api_key = "AAAA-Vtr0cE:APA91bGa3Xoh5vcEbSRmmMqLE9MuNwhCqUeMSR8vZSwyMinus3Bexdjg5HTt864bjqyLHoqG6tA9Tbx5eap3GsGBnWvNXdR_8gp4_GBDYHRtutdxHUY0sOuFDn93KW3Wc4bnv2LiGZy0";

	        $headers = array(
	        	'Content-Type : application/json',
	        	'Authorization: key='.$api_key
	        );
	
	        $fields = array(
	            'registration_ids'  => array($reg_id),
				'notification'		=> $data
	          //  'data' => $message,
	        );
			//echo json_encode($fields);exit;
	    	return $this->useCurl($url, $headers, json_encode($fields));
    	}

	// Curl 
	public function useCurl($url, $headers, $fields = null) {
	        // Open connection
	        $ch = curl_init();
	        if ($url) {
	            // Set the url, number of POST vars, POST data
	            curl_setopt($ch, CURLOPT_URL, $url);
	            curl_setopt($ch, CURLOPT_POST, true);
	            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
	            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	     
	            // Disabling SSL Certificate support temporarly
	            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
	            if ($fields) {
	                curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
	            }
	     
	            // Execute post
	            $result = curl_exec($ch);
	            if ($result === FALSE) {
	                die('Curl failed: ' . curl_error($ch));
	            }
				// echo $result;
	            // Close connection
	            curl_close($ch);
	
	            return $result;
        }
    }
}