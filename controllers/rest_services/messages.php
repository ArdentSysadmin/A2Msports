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

    public function __construct() {
        // Construct the parent class
        parent::__construct();

		$this->load->model('score/model_message', 'message');
		$this->load->model('score/model_user', 'muser');
		$this->load->model('score/model_general', 'general');
    }

	public function index_get(){
		$user_id	= $data['user_id'] = $this->input->get('user_id');
		$type		= $data['type'] = $this->input->get('type');
		$type_id	= $data['type_id'] = $this->input->get('type_id');

		$get_msgs  = $this->message->get_messages($data);

		echo $this->response($get_msgs);
	}

	public function send_post() {
		$post_data = json_decode(file_get_contents('php://input'), true);
		$image    = $data['image']			= '';
		$user_id  = $data['sender']	= trim($post_data['sender'], '"');
		$conv_id = $data['type']			= trim($post_data['type'], '"');
		$conv_id = $data['recipient']		= trim($post_data['recipient'], '"');
		$content  = $data['content']		= trim($post_data['content'], '"');

		$reply_to  = $data['reply_to']		= NULL;
		if($post_data['reply_to'])
		$reply_to  = $data['reply_to']		= trim($post_data['reply_to'], '"');

		//$image  = $post_data['image']		= trim($post_data['image'], '"');
		
		if($content or $image){
			$ins_msg  = $this->message->insert_message($data);

			if($ins_msg) {
				$res = $ins_msg;
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
		
		if($user_id){
		$get_msgs  = $this->message->get_all_messages($user_id);

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
		
		if($user_id or $q){
			if($user_id)
			$get_msgs  = $this->message->get_search_recom($user_id);
			else if($q)
			$get_msgs  = $this->message->get_search_recom2($q);

			if($get_msgs)
				echo $this->response($get_msgs);
			else
				echo $this->response('Success: No recent msgs found', 200);
		}
		else{
			echo $this->response('Error: User ID is missing!', 400);
		}
	}
}