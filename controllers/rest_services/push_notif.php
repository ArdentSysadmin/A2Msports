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
class Push_notif extends REST_Controller {
	
		public function __construct(){
			parent:: __construct();

			$this->load->helper(array('form', 'url'));

			$this->load->library('form_validation');
			$this->load->library('session');
			$this->load->model('score/model_push_notif','pnotif');
		}

		public function userToken_post(){
			$post_data  = json_decode(trim(file_get_contents('php://input')), true);
			$user_id		= $data['user_id']  = trim($post_data['user_id'], '"');
			$token_id	= $data['token_id']	= trim($post_data['token_id'], '"');
			$club_id		= $data['club_id']	= NULL;

			if($post_data['club_id'])
				$club_id = $data['club_id']	= trim($post_data['club_id'], '"'); 
		
			if($user_id and $token_id){
				$put_token = $this->pnotif->store_token($data);

				if($put_token){
					$res = array('Success: ' . "User token captured!");
				}
				else{
					$res = array('Error: ' . "Something went wrong!");
				}
			}
			else{
					$res = array('Error: ' . "User ID and Token are mandatory!");
			}
		$this->response($res);
		}

		public function unset_userToken_post(){
			$post_data  = json_decode(trim(file_get_contents('php://input')), true);
			$user_id	= $data['user_id']  = trim($post_data['user_id'], '"');
			$token_id	= $data['token_id']	= trim($post_data['token_id'], '"');
			$club_id		= $data['club_id']	= NULL;

			if($post_data['club_id'])
				$club_id = $data['club_id']	= trim($post_data['club_id'], '"'); 

			if($user_id and $token_id){
				$put_token = $this->pnotif->unset_token($data);

				if($put_token){
					$res = array('Success: ' . "User token unset!");
				}
				else{
					$res = array('Error: ' . "Something went wrong!");
				}
			}
			else{
					$res = array('Error: ' . "User ID and Token are mandatory!");
			}
		$this->response($res);
		}

		public function userNotifications_get(){
			//error_reporting(-1);
			$club_id = ''; $user_id = ''; $expo_id= '';
			if($this->input->get('club_id'))
				$club_id = $this->input->get('club_id');
			if($this->input->get('user_id'))
				$user_id = $this->input->get('user_id');
			if($this->input->get('token'))
				$expo_id= $this->input->get('token');

			$get_notifs = $this->pnotif->get_userNotifications($user_id, $club_id, $expo_id);

			if($get_notifs){
				foreach($get_notifs as $i => $notif){
						//$tz = date("Z") / 3600;
						$get_notifs[$i]->Sent_On 
							= date("Y-m-d H:i:s.u P", strtotime($get_notifs[$i]->Sent_On)); //." ". $tz.':00';

						$get_user = $this->pnotif->get_user($get_notifs[$i]->Sender);
						$prof_pic = null;
						if($get_user['Profilepic'])
						$prof_pic = base_url()."profile_pictures/".$get_user['Profilepic'];
						$get_notifs[$i]->Sender_Pic = $prof_pic ;
				}
				$res = $get_notifs;
			}
			else{
					$res = array('');
			}

				$this->response($res);
		}
	}