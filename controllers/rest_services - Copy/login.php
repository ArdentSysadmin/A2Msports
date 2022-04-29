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
class login extends REST_Controller {

    public function __construct(){
        // Construct the parent class
        parent::__construct();

		//$this->load->helper(array('form', 'url'));
		$this->load->model('score/model_user','model_user');

    }

	public function fb_post(){

		$fb_id				= $this->input->post('fb_id');
		$fname				= $this->input->post('first_name');
		$lname				= $this->input->post('last_name');

		$data['id']			= $this->input->post('fb_id');
		$data['first_name'] = $this->input->post('first_name');
		$data['last_name']  = $this->input->post('last_name');
		$data['email']		= $this->input->post('email');
		$data['gender']		= $this->input->post('gender');

		if($fb_id > 0 and ($fname != '' or $lname != '')){
			$get_user  = $this->model_user->check_user_exists($fb_id);
			
			$user_id = 0;
			if(count($get_user) > 0){
				$user_id = $get_user['Users_ID'];
			}
			else{	
				$get_user = $this->model_user->insert_fb($data);
				$user_id  = $get_user['Users_ID'];
			}
		

			if($user_id){
				$res = array('user_id: ' . $user_id);
			}
			else{
				$res = array('Error: ' . "Something went wrong! please contact admin");
			}
		}
		else{
			$res = array('Error: ' . "ID, First Name or Last Name are Mandatory!");
		}

	$this->response($res);
	}


	public function google_post(){

		$post_data = json_decode(file_get_contents('php://input'), true);

		/*echo "<pre>";
		print_r($post_data);
		exit;*/

		$google_id			= $post_data['google_id'];
		$fname				= $post_data['first_name'];
		$lname				= $post_data['last_name'];
		$email				= $post_data['email'];

		$data['id']			= $post_data['google_id'];
		$data['first_name'] = $post_data['first_name'];
		$data['last_name']  = $post_data['last_name'];
		$data['email']		= $post_data['email'];
		$data['gender']		= $post_data['gender'];

		if($google_id > 0 and ($fname != '' or $lname != '')){
			$get_user  = $this->model_user->check_google_user_exists($google_id);
			
			$user_id = 0;
			if(count($get_user) > 0){
				$user_id = $get_user['Users_ID'];
			}
			else{
				$check_email = $this->model_user->is_user_email_exists($email);
				
				if($check_email){
					$user_id  = $check_email['Users_ID'];
					$get_user = $this->model_user->update_google($data, $user_id);
				}
				else{
					$get_user = $this->model_user->insert_google($data);
					$user_id  = $get_user['Users_ID'];
				}
			}
		
			if($user_id){
				$res = array('user_id: ' . $user_id);
			}
			else{
				$res = array('Error: ' . "Something went wrong! please contact admin");
			}
		}
		else{
			$res = array('Error: ' . "ID, First Name or Last Name are Mandatory!");
		}

	$this->response($res);
	}
}