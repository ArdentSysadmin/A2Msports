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
class Teams extends REST_Controller {

    public function __construct() {
        // Construct the parent class
        parent::__construct();

		$this->load->model('score/model_team','mteam');
		$this->load->model('score/model_user','muser');
		$this->load->model('score/model_general','general');
		
		$this->load->helper('file');
		$this->load->helper('text');
    }

	public function index_get(){
		$team_id = $this->input->get('team_id');
		if($team_id){
			$team = $this->mteam->get_team_info($team_id);
			if($team){
			$res = $team;
			}
			else{
			$res = array('Error: ' . "Invali Team ID!");
			}
		}
		else{
			$res = array('Error: ' . "Team ID Requied!");
		}

	$this->response($res);
	}
	
	public function user_teams_get() {
		$user_id	= $this->input->get('user_id');
		$get_teams	= $this->mteam->get_user_teams($user_id);
		//$get_cap_teams	= $this->mteam->get_user_captain_teams($user_id);
		
		if(count($get_teams) == 0){
			$this->response("No Teams found!");
			exit;
		}

		foreach($get_teams as $team){
			$revised_team = array();

			$revised_team['Team_name']  = $team->Team_name;
			$revised_team['Sport']		= $team->Sport;
			$revised_team['Created_by'] = $team->Created_by;
			$revised_team['Captain']	= $team->Captain;
			$revised_team['Status']		= $team->Status;
			$revised_team['Team_Logo']	= $team->Team_Logo;

			$players = json_decode($team->Players, TRUE);
			
			$team_players = array();
			foreach($players as $p){
				$get_player = $this->muser->get_user_details(intval($p));
				$team_players[$p]['FirstName']  = $get_player['Firstname'];
				$team_players[$p]['LastName']   = $get_player['Lastname'];
			}

			$revised_team['Team_Players']	= $team_players;

			$get_hl = $this->mteam->get_home_loc($team->Home_loc_id);

			$revised_team['Home_Loc_Title']		= $get_hl['hcl_title'];
			$revised_team['Home_Loc_City']		= $get_hl['hcl_city'];
			$revised_team['Home_Loc_State']		= $get_hl['hcl_state'];
			$revised_team['Home_Loc_Country']	= $get_hl['hcl_country'];
			
			$final_team[$team->Team_ID] = $revised_team;
		}

		$this->response($final_team);
	}

	public function list_get() {

		$user_id   = $this->input->get('user_id');		
		$page      = $this->input->get('page');		

		$limit = 15;
		
		if($page)
		$get_teams = $this->mteam->get_limit_teams($user_id, $page, $limit);
		else
		$get_teams = $this->mteam->get_teams($user_id);

		if($get_teams){
		foreach($get_teams[0] as $team){
			$revised_team = array();

			$revised_team['Team_name']   = $team->Team_name;
			$revised_team['Sport']				= $team->Sport;
			$revised_team['Created_by']	= $team->Created_by;
			$revised_team['Captain']		= $team->Captain;
			$revised_team['Status']		= $team->Status;
			$revised_team['Team_Logo']	= $team->Team_Logo;

			$players = json_decode($team->Players, TRUE);
			
			$team_players = array();
			foreach($players as $p){
				$get_player = $this->muser->get_user_details(intval($p));
				$team_players[$p]['FirstName']  = $get_player['Firstname'];
				$team_players[$p]['LastName']   = $get_player['Lastname'];
			}

			$revised_team['Team_Players']	= $team_players;

			$get_hl = $this->mteam->get_home_loc($team->Home_loc_id);

			$revised_team['Home_Loc_Title']		= $get_hl['hcl_title'];
			$revised_team['Home_Loc_City']		= $get_hl['hcl_city'];
			$revised_team['Home_Loc_State']		= $get_hl['hcl_state'];
			$revised_team['Home_Loc_Country']	= $get_hl['hcl_country'];
			
			$final_team[$team->Team_ID] = $revised_team;
		}
			$final_team['total_pages'] = $get_teams[1];
		}
		else{
			$final_team = array("Success: No Teams found in your location!");
		}

		$this->response($final_team);
	}

		public function join_team_post()
		{
			$post_data = json_decode(trim(file_get_contents('php://input')), true);

			$user_id	= trim($post_data['user_id'], '"');
			$team_id	= trim($post_data['team_id'], '"');
	/*		$this->response($user_id." ".$team_id);
exit;*/
			$check_is_req = $this->mteam->check_is_req($team_id, $user_id);

			if(!$check_is_req){

			$get_team = $this->mteam->get_team_info($team_id);
			$get_user = $this->general->get_user($user_id);
			$get_captain_user = $this->general->get_user($get_team['Created_by']);

				if($get_user['Users_ID'] and $get_team['Team_ID']){
				$player = ucfirst($get_user['Firstname']) . ' ' . ucfirst($get_user['Lastname']);

				$sub = "Player sent a join request to your team - ".$get_team['Team_name'];

				$this->load->library('email');
				$this->email->set_newline("\r\n");
				$this->email->from(FROM_EMAIL, 'A2MSports Teams');
				$this->email->to($get_captain_user['EmailID']);
				//$this->email->to('rajnikar@ardent-india.com');
				$this->email->subject($sub);

				$rand_val = rand(1000, 1000000);
				$md5_code = md5($rand_val);

				$sec_code = substr($md5_code, 1, 16);

				$data = array(
				'team_id'	=> $team_id,
				'user_id'	=> $user_id,
				'player'	=> $player,
				'captain_id'=> $get_team['Created_by'],
				'captain'	=> ucfirst($get_captain_user['Firstname'])." ".ucfirst($get_captain_user['Lastname']),
				'team'		=> $get_team['Team_name'],
				'sec_code'	=> $sec_code,
				'page'		=> 'Join Request in Team'
				);

				$ins_db = $this->mteam->ins_team_req($data);

				$body = $this->load->view('view_email_template.php', $data, TRUE);

				$this->email->message($body);
				
				if($ins_db){
					$this->email->send();
					$res = array('Success: ' . "Thank you, Join request has been sent to the Captain!");
				}
				else{
					$res = array('Error: ' . "Sorry, Request unable to send. Try again after sometime!");
				}
				}
				else{
					$res = array('Error: ' . "Something went wrong!");
				}
			}
			else{
				$res = array('Error: ' . "A Join request has already been sent to the Captain! Please wait..");
			}

			$this->response($res);

		}

		public function withdraw_team_post()
		{
			$post_data = json_decode(trim(file_get_contents('php://input')), true);

			$user_id	= trim($post_data['user_id'], '"');
			$team_id	= trim($post_data['team_id'], '"');

			$withdraw_teams	= $this->mteam->withdraw_from_team($team_id, $user_id);

			if($withdraw_teams){
				$get_team		  = $this->mteam->get_team_info($team_id);
				$get_user		  = $this->general->get_user($user_id);
				$get_captain_user = $this->general->get_user($get_team['Created_by']);

				$player = ucfirst($get_user['Firstname']).' '.ucfirst($get_user['Lastname']);

				$sub = "Player withdraw from your team - ".$get_team['Team_name'];

				$this->load->library('email');
				$this->email->set_newline("\r\n");
				$this->email->from(FROM_EMAIL, 'A2MSports Teams');
				$this->email->to($get_captain_user['EmailID']);
				//$this->email->to('npradkumar@gmail.com');
				$this->email->subject($sub);

				$data = array(
				'team_id'	=> $team_id,
				'player'	=> $player,
				'captain_id'=> $get_team['Created_by'],
				'captain'	=> ucfirst($get_captain_user['Firstname'])." ".ucfirst($get_captain_user['Lastname']),
				'team'		=> $get_team['Team_name'],
				'page'		=> 'Withdraw from Team'
				);

				$body = $this->load->view('view_email_template.php', $data, TRUE);

				$this->email->message($body);
				$this->email->send();
					$res = array('Success: ' . "You have successfully withdrawn from the Team '".$get_team['Team_name']."'");
				}
				else{
					$res = array('Error: ' . "Invalid Request!");
				}				

			$this->response($res);
		}

		 public function autocomplete_get()
		 {
			 	$q		  = $this->input->get('q');
				$type	  = $this->input->get('type');
				$data_new = array('');
				switch($type){
				case 'users':
					$data['key']	  = trim($q);
					$result = $this->mteam->search_autocomplete_users($data);

					if($result)
					{
						$data_new = array();
						foreach($result as $row)   
						{
							$name = array();
							//$name = $row->Users_ID.'|'.$row->Firstname.' '.$row->Lastname;
							$name[$row->Users_ID] = $row->Firstname.' '.$row->Lastname;
							array_push($data_new, $name);	
						}
					}
				break;
				
				case 'court_locations':
					$data['key']	  = trim($q);
					$result = $this->mteam->search_autocomplete_court_locations($data);

					if($result)
					{
						$data_new = array();
						foreach($result as $row)   
						{
							$name = array();
							//$name = $row->Users_ID.'|'.$row->Firstname.' '.$row->Lastname;
							$name[$row->hcl_id] = $row->hcl_title;
							array_push($data_new, $name);	
						}
					}
				break;
				}
			 $this->response($data_new);
			 //return $data_new;
		 }
		 
		 public function addCourtLocation_post()
		 {
			$post_data = json_decode(trim(file_get_contents('php://input')), true);

			$title		= $data['title'] 	= trim($post_data['title'], '"');
			$address	= $data['add'] 		= trim($post_data['address'], '"');
			$city		= $data['city'] 		= trim($post_data['city'], '"');
			$state		= $data['state'] 	= trim($post_data['state'], '"');
			$country	= $data['country'] 	= trim($post_data['country'], '"');
			$zipcode	= $data['zip'] 		= trim($post_data['zipcode'], '"');
			
			$user_id	= $data['user_id'] 	= trim($post_data['user_id'], '"');
			
			//$event_location = $add . " " .$city . " " . $state . " " . $country;
			if($zipcode)
			$data['latt'] = $this->get_geo_loc($zipcode);
			$ins_loc 	  = $this->mteam->create_home_location($data);
			$location[$ins_loc] = $title;			 
			
			$this->response($location);
			 
		 }
		 
		 public function get_geo_loc($zipcode){

			$geocodeFromAddr = file_get_contents("https://maps.googleapis.com/maps/api/geocode/json?address=".$zipcode."&key=".GEO_LOC_KEY);

			$output1 = json_decode($geocodeFromAddr);
	
			//Get latitude and longitute from json data
			$result = array('latitude'  => $output1->results[0]->geometry->location->lat,
							'longitude' => $output1->results[0]->geometry->location->lng);


			return $result;
		}
		
		public function createUser_post(){
		//echo "<pre>"; print_r($_POST); exit;
			$post_data = json_decode(trim(file_get_contents('php://input')), true);

			$fname		= $data['fname'] 	= trim($post_data['firstname'], '"');
			$lname		= $data['lname'] 	= trim($post_data['lastname'], '"');
			$gender		= $data['gender'] 	= trim($post_data['gender'], '"');
			$email		= $data['email'] 	= trim($post_data['email'], '"');

			if($email){

				$check_user_exists = $this->general->get_email($email);
				
				if(!$check_user_exists){
                //$data['latt'] = $this->get_lang_latt();
			
				$ins_user = $this->muser->instant_register($data);

				if(!empty($ins_user)){
					$users_id   = $ins_user['users_id'];
					
					//$this->instant_user_email($ins_user);
					
					$res[$users_id] = $fname.' '.$lname;
					$this->response($res);
				}
				else{
					$this->response("Something went wrong!");
				}
				}
				else{
					$this->response("User with this email id already exists!");
					exit;
				}
			}
		}
		
		/*public function instant_user_email($user_det){

			$first_name = $user_det['firstname'];
			$last_name	= $user_det['lastname'];
			$email		= $user_det['email'];
			$act_code	= $user_det['act_code'];

			if(isset($user_det['tourn_id'])){
               $tourn_id = $user_det['tourn_id'];
               $page = "Instant Registration By Admin";
			}else{
				$tourn_id = "";
				$page = "Instant Registration";
			}
			
			$this->load->library('email');
			$this->email->set_newline("\r\n");
		
			$this->email->from(FROM_EMAIL, $this->session->userdata('user'));
			$this->email->to($email); 
			$this->email->subject('Activate your account at A2MSports!');

			$data = array(
					'Firstname' => $first_name,
					'Lastname'  => $last_name,
					'Code'	    => $act_code,
					'page'	    => $page,
					'tourn_id'  => $tourn_id);

			$body = $this->load->view('view_email_template.php',$data,TRUE);
			$this->email->message($body);   
			$stat = $this->email->send();
			
			return $stat;
		}*/
		
		public function createTeam_post(){
			$post_data = json_decode(trim(file_get_contents('php://input')), true);
			
			$team_name		= $data['team_name'] 	 = trim($post_data['team_name'], '"');
			$sport			= $data['sport'] 		 = trim($post_data['sport'], '"');
			$home_location	= $data['home_location'] = trim($post_data['home_location'], '"');
			$created_user	= $data['created_user']  = trim($post_data['created_user'], '"');
			
			if($post_data['team_players']){
				$team_players = $post_data['team_players'];
				array_push($team_players, $created_user);
				$data['team_players'] = json_encode($team_players, true);
			}
			else{
				$data['team_players'] = array();
			}
			
			$team_logo		= trim($post_data['team_logo'], '"');
			$logo_format	= trim($post_data['logo_format'], '"');
			
			$image 		= base64_decode($team_logo);
			$image_name = md5($team_name);
			$re_name 	= time()."_".substr($image_name, 0, 8);
			$filename 	= $data['team_logo_name'] = $re_name . '.' . $logo_format;
			
			//rename file name with random number
			$path = $_SERVER["DOCUMENT_ROOT"]."\\"."team_logos\\";
			
			//echo "<pre>";print_r($data);exit();
			//echo $path1; exit;
			//image uploading folder path
			file_put_contents($path . $filename, $image);
			
			$create = $this->mteam->create_team($data);
			
			if($create)
				$res = 'Success';
			else
				$res = 'Fail';	
			
			$this->response($res);
		}
		
		public function testLogoUpload_post(){
			
			$post_data  = json_decode(trim(file_get_contents('php://input')), true);
			$team_logo  = $data['logo'] = trim($post_data['team_logo'], '"');
			
			$image 		= base64_decode($team_logo);
			$image_name = md5(uniqid(rand(), true));
			$filename 	= $image_name . '.' . 'jpg';
			
			//rename file name with random number
			$path = $_SERVER["DOCUMENT_ROOT"]."\\"."team_logos\\";
			
			
			//echo $path1; exit;
			//image uploading folder path
			file_put_contents($path . $filename, $image);
			
			
			/*$path = $_SERVER["DOCUMENT_ROOT"]."\\"."team_logos\\";
$this->load->library('image_lib');
$imageData = base64_decode($team_logo);
$source = imagecreatefromstring($imageData);
$angle = 90;
//$rotate = imagerotate($source, $angle, 0); // if want to rotate the image
$imageName = "hello1.png";
$imageSave = imagejpeg($source,$path.$imageName.'.jpg',100);
imagedestroy($source);*/

			// image is bind and upload to respective folde
			$data_insert = array('front_img' => $filename);

			//$success = $this->add_model->insert_img($data_insert);
			if(1){
				$b = "User Registered Successfully..";
				$this->response(array($path));
			}
			else{
				$b = "Some Error Occured. Please Try Again..";
				$this->response($b);
			}

		}
		
		
}