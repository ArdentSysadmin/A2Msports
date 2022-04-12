<?php defined('BASEPATH') OR exit('No direct script access allowed');
require(APPPATH.'/libraries/REST_Controller.php');
//error_reporting(-1);
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

class Messages extends REST_Controller {

		public $tourn_def_imgs;

    public function __construct() {
        // Construct the parent class
        parent::__construct();

		$this->load->model('score/model_message', 'message');
		$this->load->model('score/model_user', 'muser');
		$this->load->model('score/model_general', 'general');

		$this->tourn_def_imgs = unserialize(TOURN_DEF_IMGS);

    }

	public function index_get(){
		$user_id	= $data['user_id'] = $this->input->get('user_id');
		$type		= $data['type'] = $this->input->get('type');
		$type_id	= $data['type_id'] = $this->input->get('type_id');

		$page = $data['page'] = 1;
		if($this->input->get('page'))
		$page = $data['page'] = $this->input->get('page');

		$limit = $data['limit'] = 25;
		if($this->input->get('is_web'))
		$limit = $data['limit'] = 1000;

		$get_msgs  = $this->message->get_messages($data);

		echo $this->response($get_msgs);
	}

	public function send2_post() {
		$post_data = json_decode(file_get_contents('php://input'), true);
		$image			= $data['image']	= '';
		$from_user  = $data['sender']	= trim($post_data['sender'], '"');
		$type		= $data['type']			= trim($post_data['type'], '"');
		$to_user	= $data['recipient']	= trim($post_data['recipient'], '"');
		$content  = $data['content']		= utf8_encode(trim($post_data['content'], '"'));

		$reply_to  = $data['reply_to']	= NULL;
		if($post_data['repliedTo'])
		$reply_to  = $data['reply_to']	= trim($post_data['repliedTo'], '"');

		//$image  = $post_data['image']		= trim($post_data['image'], '"');
		if(!$from_user or !$to_user or !$type){
			$res = array('Error: ' . "Some inputs are missing!", 400);
			$this->response($res);
			exit;
		}

		if($content or $image)
			$ins_msg  = $this->message->insert_message2($data);

					$this->response("done");

	}

	public function send_post() {
		$post_data = json_decode(file_get_contents('php://input'), true);
		$image			= $data['image']	= '';
		$from_user  = $data['sender']	= trim($post_data['sender'], '"');
		$type		= $data['type']			= trim($post_data['type'], '"');
		$to_user	= $data['recipient']	= trim($post_data['recipient'], '"');
		$content  = $data['content']		= trim($post_data['content'], '"');

		$reply_to  = $data['reply_to']	= NULL;
		if($post_data['repliedTo'])
		$reply_to  = $data['reply_to']	= trim($post_data['repliedTo'], '"');

		//$image  = $post_data['image']		= trim($post_data['image'], '"');
		if(!$from_user or !$to_user or !$type){
			$res = array('Error: ' . "Some inputs are missing!", 400);
			$this->response($res);
			exit;
		}

		if($content or $image){
			$ins_msg  = $this->message->insert_message($data);
			//$ins_msg  = 1;

			if($ins_msg) {
				$res = $ins_msg;

// --- push notifications

		$tokens_arr = array();
		$get_from_user    = $this->muser->get_user_details($from_user);
		$from_name			= $get_from_user['Firstname']." ".$get_from_user['Lastname'];

if($type == 'One2One' or $type == 'one2one'){
		$get_user_token = $this->muser->get_userToken_a2m($to_user);

		if($get_user_token){
			foreach($get_user_token as $i => $ut){
				$tokens_arr[] = $ut->token;
			}
		}
}
else if($type == 'Team' or $type == 'team'){
		$tokens_arr = $this->muser->get_userToken_team($to_user);
}
else if($type == 'Tournament' or $type == 'tournament'){
		$tokens_arr = $this->muser->get_userToken_tournament($to_user);
}
//echo "<pre>"; print_r($tokens_arr); exit;
				if(count($tokens_arr) > 0){
						$mobile_notif	= $this->contactMessage_pushNotif($content, $tokens_arr, $from_user, $to_user, $from_name, $type);
						//$r						= json_decode($mobile_notif);
						//if($mobile_notif){
						//	$is_mob_alert_send = 1;
						//}	
				}
// --- push notifications

			}
			else {
				$res = array('Error: ' . "Something went wrong!", 400);
			}
		}
		else {
			$res = array('Error: ' . "Message content empty!", 400);
		}

		$this->response($res);
	}

	public function getAll_get(){
		
		$user_id	= $this->input->get('user_id');
		$type		= $this->input->get('type');
		
		$page = 1;
		if($this->input->get('page'))
		$page = $this->input->get('page');

		if($user_id){
		$get_msgs  = $this->message->get_all_messages($user_id, $type, $page);

			if($get_msgs)
				echo $this->response($get_msgs);
			else
				echo $this->response('Success: No Messages found', 200);
		}
		else{
			echo $this->response('Error: User ID is missing!', 400);
		}

	}

	public function search_recom_get(){

		$user_id	= $this->input->get('user_id');
		$q				= $this->input->get('q');

		$page = 1;
		if($this->input->get('page'))
		$page = $this->input->get('page');

		if($q){
			//if($user_id)
			//$get_msgs  = $this->message->get_search_recom($user_id);
			//else if($q)
			$get_msgs  = $this->message->get_search_recom2($q, $user_id, $page);

			if($get_msgs)
				echo $this->response($get_msgs);
			else
				echo $this->response('Success: No recent msgs found', 200);
		}
		else{
			echo $this->response('Error: Search keyword is missing!', 400);
		}
	}

public function contactMessage_pushNotif($message, $token, $from, $to, $from_name, $type){
					$url		= 'https://exp.host/--/api/v2/push/send';
					$title	=	$from_name;
					$payload = array(
										'to'		  => $token,
										'sound'	=> 'default',
										'title'		=> $title,
										'body'	  => $message,
										'data'	  => array('type' =>$type, 'recipientId' => (int)$from)
						);

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

			return $send_stat;
	}

	//public function test_post(){

	//	echo "<pre>"; print_r($_POST);

	//}

}