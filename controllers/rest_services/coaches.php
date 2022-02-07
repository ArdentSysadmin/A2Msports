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
class Coaches extends REST_Controller {

    public function __construct() {
        // Construct the parent class
        parent::__construct();

		$this->load->model('score/model_coaches','coaches');
		$this->load->model('score/model_general','general');
    }

	public function index_get(){
		$user_id = $this->input->get('user_id');
		if($user_id){
			$coach_det = $this->coaches->get_coaches($user_id);
			if($coach_det){
					
					foreach($coach_det as $user){
			$prof_pic = base_url().'profile_pictures/'.'default-profile.png';
			if($user["Profilepic"]){
			$prof_pic = base_url().'profile_pictures/'.$user["Profilepic"];
			}

			$res[] =  
			array(
				"Users_ID"		=> $user['Users_ID'],
				"Firstname"		=> $user['Firstname'],
				"Lastname"		=> $user["Lastname"],
				"EmailID"		=> $user["EmailID"],
				"AlternateEmailID" => $user["AlternateEmailID"],
				"DOB"			=> $user["DOB"],
				"Gender"		=> $user["Gender"],
				"UserAddressline1" => $user["UserAddressline1"],
				"UserAddressline2" => $user["UserAddressline2"],
				"Country"		=> $user["Country"],
				"State"			=> $user["State"],
				"City"			=> $user["City"],
				"Zipcode"		=> $user["Zipcode"],
				"HomePhone"		=> $user["HomePhone"],
				"Mobilephone"	=> $user["Mobilephone"],
				"IsUserActivation" => $user["IsUserActivation"],
				"Profilepic"	=> $prof_pic,
				"Latitude"		=> $user["Latitude"],
				"Longitude"		=> $user["Longitude"],
				"UserAgegroup"	=> $user["UserAgegroup"],
				"Username"		=> $user["Username"],
				"Is_coach"		=> $user["Is_coach"],
				"coach_profile" => $user["coach_profile"],
				"Coach_Website" => $user["Coach_Website"],
				"coach_sport"	=> $user["coach_sport"],
				"Sportname"		=> $user["Sportname"]
				//sports_interests" => $sp
				);
					}
			}
			else{
			$res = array('Error: ' . "Invalid User ID!");
			}
		}
		else{
			$res = array('Error: ' . "Team ID Requied!");
		}

	$this->response($res);
	}

	public function details_get(){
		$user_id = $this->input->get('coach_id');
		if($user_id){
			$user = $this->coaches->get_coach_det($user_id);
			
			if($user){
					
					//foreach($coach_det as $user){
			$prof_pic = base_url().'profile_pictures/'.'default-profile.png';
			if($user["Profilepic"]){
			$prof_pic = base_url().'profile_pictures/'.$user["Profilepic"];
			}

			$res[] =  
			array(
				"Users_ID"		=> $user['Users_ID'],
				"Firstname"		=> $user['Firstname'],
				"Lastname"		=> $user["Lastname"],
				"EmailID"		=> $user["EmailID"],
				"AlternateEmailID" => $user["AlternateEmailID"],
				"DOB"			=> $user["DOB"],
				"Gender"		=> $user["Gender"],
				"UserAddressline1" => $user["UserAddressline1"],
				"UserAddressline2" => $user["UserAddressline2"],
				"Country"		=> $user["Country"],
				"State"			=> $user["State"],
				"City"			=> $user["City"],
				"Zipcode"		=> $user["Zipcode"],
				"HomePhone"		=> $user["HomePhone"],
				"Mobilephone"	=> $user["Mobilephone"],
				"IsUserActivation" => $user["IsUserActivation"],
				"Profilepic"	=> $prof_pic,
				"Latitude"		=> $user["Latitude"],
				"Longitude"		=> $user["Longitude"],
				"UserAgegroup"	=> $user["UserAgegroup"],
				"Username"		=> $user["Username"],
				"Is_coach"		=> $user["Is_coach"],
				"coach_profile" => $user["coach_profile"],
				"Coach_Website" => $user["Coach_Website"],
				"coach_sport"	=> $user["coach_sport"],
				"Sportname"		=> $user["Sportname"]
				//sports_interests" => $sp
				);
					//}
			}
			else{
			$res = array('Error: ' . "Invalid User ID!");
			}
		}
		else{
			$res = array('Error: ' . "Team ID Requied!");
		}

	$this->response($res);
	}

	/*public function list_get() {

		$user_id   = $this->input->get('user_id');		
		$get_coaches = $this->mteam->get_coaches($user_id);
		if($get_coaches){
		foreach($get_coaches as $coach){
			$coach_list = array();

			$coach_list['Team_name']  = $team->Team_name;
			$coach_list['Sport']		= $team->Sport;
			$coach_list['Created_by'] = $team->Created_by;
			$coach_list['Captain']	= $team->Captain;
			$coach_list['Status']		= $team->Status;
			$coach_list['Team_Logo']	= $team->Team_Logo;

			
			$final_team[$coach->User_ID] = $revised_team;
		}
		}
		else{
			$final_team = array("Success: No Coaches found in your location!");
		}

		$this->response($final_team);
	}*/


	public function bookCoach_post() {

		$post_data = json_decode(trim(file_get_contents('php://input')), true);

			if(!$post_data){
			$this->response(array('Error: ' . "Empty!")); 
			}

		$data['coach_id']		 = $post_data['coach_id'];

		$data['reserved_by']	 = $post_data['user_id'];
		$data['bookings']		 = $post_data['bookings'];
		$data['booking_amt']	 = $post_data['booking_amt'];
		$data['trans_id']		 = $post_data['transaction_id'];

//echo "<pre>"; print_r($data); exit;
		//$is_sharable = $this->mclub->check_sharable($data['coach_id']);
//echo "<pre>"; print_r($is_sharable); exit;
		//if($is_sharable['is_shared_resource'] > 0) {
		//	$res_court = $this->mclub->reserve_courtTemp($data);
		//}
		//else {
			$res_court = $this->coaches->check_bookCoach($data);
		//}

		//var_dump($res_court);		exit;
		if($res_court and $res_court > 0) {
		 $res = array('Success: '."Coach booking done");
		 $res_code = 200;
		}
		else if($res_court < 0) {
		 $res = array('Error: '."Coach is already booked!");
		 $res_code = 400;
		}
		else {
		 $res = array('Error: '."Undone, Try again!");
		 $res_code = 400;
		}

		$this->response($res, $res_code);
	}



}