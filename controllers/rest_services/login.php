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

		public function iCloud_post(){

		$post_data = json_decode(file_get_contents('php://input'), true);

		/*echo "<pre>";
		print_r($post_data);
		exit;*/

		$apple_id	= $post_data['apple_id'];
		$fname		= $post_data['first_name'];
		$lname		= $post_data['last_name'];
		$email			= $post_data['email'];

		$data['id']				= $post_data['apple_id'];
		$data['first_name'] = $post_data['first_name'];
		$data['last_name']  = $post_data['last_name'];
		$data['gender']		= '';

		$jwt_code				= $post_data['token'];
		$token_email			= '';

		if($jwt_code){
			$exp = explode('.', $jwt_code);

			$arr = json_decode(base64_decode($exp[1]), true);
			$token_email		= $arr['email'];
			//$email_verify = $arr['email_verified'];
		}

		if($email == '')
			$email = $token_email;


		$data['email']	= $email;

		if($post_data['gender'])
			$data['gender']		= $post_data['gender'];

		if($apple_id != ''){
			$get_user  = $this->model_user->check_apple_user_exists($apple_id);
			
			$user_id = 0;
			if(count($get_user) > 0){
				$user_id = $get_user['Users_ID'];
				$fname	 = $get_user['Firstname'];
				$lname	 = $get_user['Lastname'];
			}
			else{
				$check_email = $this->model_user->is_user_email_exists($email);
				
				if($check_email){
					$user_id		= $check_email['Users_ID'];
					$fname		= $check_email['Firstname'];
					$lname		= $check_email['Lastname'];
					$upd_user = $this->model_user->update_icloud($data, $user_id);
				}
				else{
					if($email != ''){
						$ins_user	= $this->model_user->insert_icloud($data);
						$user_id		= $ins_user['Users_ID'];
						$fname		= $ins_user['Firstname'];
						$lname		= $ins_user['Lastname'];
					}
					else{
						$res = array('Error: ' . "Email ID is required!");
						$this->response($res, 400);
						exit;
					}
				}
			}
		
			if($user_id){
				//$res = array('user_id: ' . $user_id);
				$res = array('user_id' => $user_id, 'fname' => $fname, 'lname' => $lname, 'email' => $email);
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

		public function jwtTest_post(){

		$post_data = json_decode(file_get_contents('php://input'), true);
		$jwt_code	= $post_data['token'];
		$exp			= explode('.', $jwt_code);
		$arr				= json_decode(base64_decode($exp[1]), true);
			echo "<pre>";
			print_r($arr);
			exit;
		}

		public function validate_post(){
		$post_data = json_decode(file_get_contents('php://input'), true);
//echo "<pre>"; print_r($post_data); exit;
		$email  = $post_data['email'];
		$pwd	 = $post_data['password'];

		if($email and $pwd){
			$validate_user = $this->model_user->validate_user($email, $pwd);
			if($validate_user){
				$res = array('user_id' => $validate_user['Users_ID'], 'firstname' => $validate_user['Firstname'], 
					'lastname' => $validate_user['Lastname'], 'email' => $validate_user['EmailID']);
				$this->response($res, 200);
				exit;
			}
			else{
				$res = array('Error: ' . "Invalid Login Details");
				$this->response($res, 400);
				exit;
			}
		}
		else{
				$res = array('Error: ' . "Both Email and Password are required");
				$this->response($res, 400);
				exit;
		}



		}

		public function validatePhone_post(){
		$post_data = json_decode(file_get_contents('php://input'), true);

		$token = $post_data['token'];
		$exp	= explode('.', $token);
		$arr		= json_decode(base64_decode($exp[1]), true);
		$exp_time = $arr['exp'];
		$cur_time = strtotime(date('Y-m-d H:i:s'));

		if($cur_time < $exp_time){
			$phone	= $arr['phone_number'];
			$ph			= substr($phone, -10);

			$validate_user = $this->model_user->validate_user_phone($phone, $ph);
			if($validate_user){
				foreach($validate_user as $user_det){
				$res[] = array('user_id' => $user_det['Users_ID'], 'firstname' => $user_det['Firstname'], 
					'lastname' => $user_det['Lastname'], 'email' => $user_det['EmailID']);
				}
				$this->response($res, 200);
				exit;
			}
			else{
				$res = array('Error: ' . "Phone Number Not Registered!");
				$this->response($res, 400);
				exit;
			}
		}
		else{
				$res = array('Error: ' . "Token Expired");
				$this->response($res, 400);
				exit;
		}

		}

}