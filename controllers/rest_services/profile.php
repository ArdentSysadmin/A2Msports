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
		$user_id = trim($post_data['user_id'], '"');
		
		if($post_data['Firstname'])
			$data['Firstname'] = trim($post_data['Firstname'], '"');
		if($post_data['Lastname'])
			$data['Lastname'] = trim($post_data['Lastname'], '"');
		
		$data['Mobilephone']		= NULL;
		if($post_data['mphone']){
			$mphone = trim($post_data['mphone'], '"');
			$mphone = str_replace('(', '', $mphone);
			$mphone = str_replace(')', '', $mphone);
			$mphone = str_replace('-', '', $mphone);

			$data['Mobilephone']	 = $mphone;
		}


		$data['HomePhone']		= trim($post_data['hphone'], '"');
		$data['UserAddressline1']	= trim($post_data['addr1'], '"');
		$data['UserAddressline2']	= trim($post_data['addr2'], '"');
		$data['Country']				= trim($post_data['country'], '"');
		$data['State']					= trim($post_data['state'], '"');
		$data['City']						= trim($post_data['city'], '"');
		$data['Zipcode']				= trim($post_data['zip_code'], '"');
		if($post_data['gender'] == 1 or $post_data['gender'] == 0 or $post_data['gender'] == '1' or $post_data['gender'] == '0'){
		$data['Gender'] = $post_data['gender'];
		}

		if($post_data['dob']){
			$dob				= trim($post_data['dob'], '"');
			$data['DOB']	= $dob;
			$dob				= date('Y-m-d', strtotime($this->input->post('txt_dob')));
			
			$birthdate		= new DateTime($dob);
			$today			= new DateTime('today');
			$age				= $birthdate->diff($today)->y;
			
			switch (true) {
                case $age <= 9:
                   $age_group = "U9";
                   break;
                case $age == 10:
                   $age_group = "U10";
                   break;
                case $age == 11:
                   $age_group = "U11";
                   break;
                case $age == 12:
                   $age_group = "U12";
                   break;
                case $age == 13:
                   $age_group = "U13";
                   break;
                case $age == 14:
                   $age_group = "U14";
                   break;
                case $age == 15:
                   $age_group = "U15";
                   break;
                case $age == 16:
	               $age_group = "U16";
	               break;
                case $age == 17:
                   $age_group = "U17";
                   break;
                case $age == 18:
                   $age_group = "U18";
                   break;
                case $age == 19:
                   $age_group = "U19";
                   break;
				case $age == 21:
                   $age_group = "U21";
                   break;
                default:
                   $age_group = "Adults";
                   break;
			}

			$data['UserAgegroup'] = $age_group;
		}

		$data['NotifySettings'] = json_encode(explode(',', $post_data['notify']));

		$zip_code  = $data['Zipcode'];
		$country		= $data['Country'];

        $geo_cord	 = $this->get_lang_latt($zip_code, $country);
		//$ex = explode('@', $geo_code);

		$data['Latitude']		= $geo_cord[0];
		$data['Longitude']	= $geo_cord[1];

		$ins_user = $this->muser->user_update($data, $user_id);

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
		$data['Coach_Website']  = trim($post_data['coach_website'], '"');
		$data['coach_profile']	  = trim($post_data['coach_profile'], '"');

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

	public function user_profilepic_post() {
		$post_data = json_decode(trim(file_get_contents('php://input')), true);

		$user_id	  = trim($post_data['user_id'], '"');

		if($user_id) {
			$profile_pic	= trim($post_data['profile_pic'], '"');
			$img_format	= trim($post_data['img_format'], '"');
			
			$image 			 = base64_decode($profile_pic);
			$image_name = md5($user_id);
			$re_name 	= time()."_".substr($image_name, 0, 8);
			$filename 	= $data['Profilepic'] = $re_name . '.' . $img_format;
			
			//rename file name with random number
			$path = $_SERVER["DOCUMENT_ROOT"]."\\"."profile_pictures\\";

			//image uploading folder path
			file_put_contents($path . $filename, $image);
			
			$upd = $this->muser->user_update($data, $user_id);
		}

		if($upd){
		$res = array('Success: ' . "Profile Picture updated!");
		}
		else {
		$res = array('Error: ' . "Something went wrong!", 400);
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

				$get_user_token = $this->muser->get_userToken($to_user);
//echo "<pre>"; print_r($get_user_token); exit;
				
			$get_from	= $this->muser->get_user_details($from_user);
			$get_to		= $this->muser->get_user_details($to_user);
			$from_name  = ucfirst($get_from['Firstname'])." ".ucfirst($get_from['Lastname']);

				$is_mob_alert_send = 0;

				if($get_user_token){
					foreach($get_user_token as $i => $ut){
						// echo $ut->token; exit;
						$regId					= $ut->token;
						$mobile_notif	= $this->contactMessage_pushNotif($message, $regId, $from_user, $to_user, $from_name);
						//$r						= json_decode($mobile_notif);
						if($mobile_notif){
							$is_mob_alert_send = 1;
						}
					}
				}

				$send_mail = 0;
				if(!$is_mob_alert_send)
				$send_mail = $this->muser->send_user_email($from_user, $to_user, $message);

				if($is_mob_alert_send){
					$res2 = array('Success: ' . "Contact Message sent to user successfully");
				}
				else if($send_mail){
					$res2 = array('Success: ' . "Contact Message sent over mail");
				}
				else{
					$res2 = array('Error: ' . "Message could not able to send!");
				}
		}
		else{
			$res2 = array('Error: ' . "From / To user ids are required!");
		}

		$this->response($res2);
	}

public function send_user_email($get_from, $get_to, $message){

				$from_email = "admin@a2msports.com";
				$from_name  = ucfirst($get_from['Firstname'])." ".ucfirst($get_from['Lastname']);
				$to_email		 = $get_to['EmailID'];

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

				return $res;
}

public function contactMessage_pushNotif($message, $token, $from, $to, $from_name){
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

					$json_mes = '{"to": "'.$token.'", "title": "'.$title.'", "body": "'.$message.'", "data": {"message_content": "'.$message.'", "type": "USER_MESSAGE", "sender_user_id": '.$from.'}}';

					$data = array(
						'Sender'		 => $from,
						'Recipient'  => $to,
						'Club_ID'	=> NULL,
						'Message'	=> $message,
						'Json_Message' => $json_mes,
						'Send_Status'	=> $send_stat,
						'Read_Status'	=> 0,
						'Sent_On'			=> date('Y-m-d H:i'),
						'Expo_Token'		=> $token,
						'Notif_Type'		=> 'Contact',
						);
//echo "<pre>"; print_r($data); exit;
			$this->muser->insert_notif($data);

			return $send_stat;
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