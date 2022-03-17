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
//class Scores extends REST_Controller {
class Clubs extends REST_Controller {

    public function __construct() {
        // Construct the parent class
        parent::__construct();

		$this->load->model('score/model_club','mclub');
		$this->load->model('score/model_user','muser');
		$this->load->model('score/model_general','general');
    }

	public function index_get(){
		$club_id = $this->input->get('club_id');
		$user_id = $this->input->get('user_id');

		$get_club_loc = $this->mclub->get_clubs_locations($club_id);
		$data	  = array();
		$bookings = null;

		foreach($get_club_loc as $club_loc){

			$get_loc_courts = $this->mclub->get_loc_courts($club_loc->loc_id);
			$data3	  = null;

			foreach($get_loc_courts as $court) {

				$get_court_info		= $this->mclub->get_court_info($court->court_id);				
				$get_court_bookings = $this->mclub->get_user_court_bookings($court->court_id, $user_id);
				if($get_court_bookings){
					foreach($get_court_bookings as $booking) {
						$from		= date('D Y-m-d H:i:s', strtotime($booking->res_date.' '.$booking->from_time));
						$to			= date('D Y-m-d H:i:s', strtotime($booking->res_date.' '.$booking->to_time));
						$numP	= $booking->num_players;
						$pList		= $booking->players;
						$bookings[] = array('booking_id' => $booking->res_id, 
											'court_id'	 => $court->court_id, 
											'loc_id'	 => $club_loc->loc_id, 
											'court_name' => $get_court_info['court_name'], 
											'location'	 => $club_loc->location, 
											'address'	 => $club_loc->address, 
											'city'		 => $club_loc->city, 
											'state'		 => $club_loc->state, 
											'country'	 => $club_loc->country, 
											'numPlayers' => $numP, 
											'Players'	 => $pList, 
											'from'		 => $from, 
											'to'		 => $to);

					}
				//$data3[] = $bookings;
				}
			}
			
			/*if($bookings)
			$data[] = $bookings;*/
		}

		$data2['user_bookings'] = $bookings;

		$this->response($data2);
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

	public function details_get(){
		$club_id = $this->input->get('id');
		$user_id = $this->input->get('user_id');

		$get_club  = $this->mclub->get_club($club_id);
		$is_coach = false;
		if($user_id)
		$is_coach = $this->mclub->is_coach($club_id, $user_id);

			$data = array();
			$data['Club_ID']	= $get_club['Aca_ID'];
			$data['Club_Name']	= $get_club['Aca_name'];
			$data['Address1']	= $get_club['Aca_addr1'];
			$data['Address2']	= $get_club['Aca_addr2'];
			$data['City']		= $get_club['Aca_city'];
			$data['State']		= $get_club['Aca_state'];
			$data['Country']	= $get_club['Aca_country'];
			//$data['Zip']		= $get_club['Aca_zip'];

			$data['Club_URL']	= null;
 			if($get_club['Aca_url'])
			$data['Club_URL']	= $get_club['Aca_url'];

			$data['Club_Logo']	= null;
			if($get_club['Aca_logo'])
			$data['Club_Logo']	= base_url().'org_logos/'.$get_club['Aca_logo'];

			$data['Club_Owner'] = $get_club['Aca_User_id'];
			$data['Is_Coach'] = $is_coach;

			$data['Is_PNP'] = 0;

			if($this->mclub->is_clubs_having_courts($get_club['Aca_ID'])){
				$data['Is_PNP'] = 1;
			}


			$data['Contact_Name']  = null;
			$data['Contact_Phone'] = null;
			$data['Contact_Email'] = null;

			if($get_club['Aca_contact_name'])
			$data['Contact_Name']  = $get_club['Aca_contact_name'];

			if($get_club['Aca_contact_phone'])
			$data['Contact_Phone'] = $get_club['Aca_contact_phone'];

			if($get_club['Aca_contact_email'])
			$data['Contact_Email'] = lcfirst($get_club['Aca_contact_email']);
			$temp = null;

			if($get_club['Aca_sport']){
				$sports = json_decode($get_club['Aca_sport'], true);
				foreach($sports as $sport){
					if($sport){
					$sport_det = $this->general->get_sport($sport);
					$temp[]	   = array('sport_id' =>$sport, 'sport_title'=>$sport_det['sport_title']);
					}
				}
			}
			else{
				if($get_club['Primary_Sport']){
					$sport_det = $this->general->get_sport($get_club['Primary_Sport']);
					$temp[] = array('sport_id' =>$sport, 'sport_title'=>$sport_det['sport_title']);
				}
				else{
					$temp  = null;
				}
			}
			
			$data['Club_Timings'] = null;
			if($get_club['Aca_timings'] != 'null' and $get_club['Aca_timings'] != ''){
			$data['Club_Timings'] = $get_club['Aca_timings'];
			}
			$data['Longitude']	  = $get_club['Longitude'];
			$data['Latitude']	  = $get_club['Latitude'];
			$data['Club_Sports']  = $temp;

			$get_club_ratings = $this->mclub->get_club_ratings($club_id);
			$rating_info = null;
			$s5 = 0; $s4 = 0; $s3 = 0;  $s2 = 0;  $s1 = 0;

			if($get_club_ratings){
				foreach($get_club_ratings as $rating){
					$user_info = $this->general->get_user($rating->User_ID);
					$rating_info[] = array(
									'Rate_ID'   => $rating->Rate_ID,
									'User_ID'   => $rating->User_ID,
									'User_Name' => $user_info['Firstname']." ".$user_info['Lastname'],
									'Rating'	=> $rating->Ratings,
									'Comments'	=> $rating->Comments,
									'Date'		=> date('m-d-Y', strtotime($rating->Rated_On)),
									'Is_Anonymous' => $rating->Rate_Anonymous
									);

					if($rating->Ratings==5)
					$s5+=1;
					
					if($rating->Ratings==4)
					$s4+=1;
					
					if($rating->Ratings==3)
					$s3+=1;
					
					if($rating->Ratings==2)
					$s2+=1;
					
					if($rating->Ratings==1)
					$s1+=1;
					
				}
			}

			$avg_star_rating = ($s5*5 + $s4*4 + $s3*3 + $s2*2 + $s1*1) / ($s5 + $s4 + $s3 + $s2 + $s1);

			$data['Club_Avg_Rating'] = $avg_star_rating;
			$data['Club_Ratings']	 = $rating_info;
			
			/*
			$get_club_members = $this->mclub->get_club_members($club_id);
			
			foreach($get_club_members as $member){
				$mem_id = null;
				if($member->Membership_ID){
					$mem_id = $member->Membership_ID;
				}
				$club_members[] = array(
								'user_id'		=> $member->Users_ID,
								'firstname'		=> $member->Firstname,
								'lastname'		=> $member->Lastname,
								'membership_id' => $mem_id,		
							  );
			}

			$data['Club_Members']	 = $club_members;
			*/

			/*
			$get_club_coaches = $this->mclub->get_club_coaches($club_id);

			foreach($get_club_coaches as $coach){

				$club_coaches[] = array(
								'user_id'		=> $coach->Users_ID,
								'firstname'		=> $coach->Firstname,
								'lastname'		=> $coach->Lastname,
								'coach_profile' => $coach->coach_profile,		
								'coach_website' => $coach->Coach_Website,	
								'coach_sport'	=> trim($coach->coach_sport),	
								'sport_title'	=> $coach->Sportname	
							  );
			}

			$data['Club_Coaches'] = $club_coaches;
			*/

			$temp2  = null;
			$get_club_loc = $this->mclub->get_clubs_locations($club_id);
			
			if($get_club_loc){
				foreach($get_club_loc as $club_loc){
					$data2 = array();
					$data2['loc_id']   = $club_loc->loc_id;
					$data2['location'] = $club_loc->location;
					$data2['address']  = $club_loc->address;
					$data2['city']     = $club_loc->city;
					$data2['state']    = $club_loc->state;
					$data2['longitude'] = $club_loc->longitude;
					$data2['latitude'] = $club_loc->latitude;

					if($this->mclub->is_location_nonmem_visible($club_loc->loc_id)){
						$data2['allow_payn_play'] = true;
					}
					else{
						$data2['allow_payn_play'] = false;
					}

					if(($get_club['Aca_User_id'] == $user_id) or $is_coach)
					$data2['allow_payn_play'] = true;
					$temp2[] = $data2;
				}
			}
			$data['Club_court_locations'] = $temp2;

			$this->benchmark->mark('code_end');
			$response_time = $this->benchmark->elapsed_time('code_start', 'code_end');
			$data['response_time'] = $response_time;

			$data3 = $data;

		$this->response($data3);
	}

	public function listAll_get(){
		$user_id	   = $this->input->get('user_id');
		$get_club_list = $this->mclub->get_clubs($user_id);
		/*$this->response($get_club_list);
		exit;*/
		foreach($get_club_list as $club) {
			$data = array();
			$data['Club_ID']	= $club->Aca_ID;
			$data['Club_Name']	= $club->Aca_name;
			//$data['Address1']	= $club->Aca_addr1;
			//$data['Address2']	= $club->Aca_addr2;
			$data['City']		= $club->Aca_city;
			$data['State']		= $club->Aca_state;
			//$data['Country']	= $club->Aca_country;
			//$data['Zip']		= $club->Aca_zip;

			//$data['Club_URL']	= null;
 			//if($club->Aca_url)
			//$data['Club_URL']	= $club->Aca_url;

			$data['Club_Logo']	= null;
			if($club->Aca_logo)
			$data['Club_Logo']	= base_url().'org_logos/'.$club->Aca_logo;
			$data['Club_Owner'] = $club->Aca_User_id;

			$data['Contact_Name']  = null;
			//$data['Contact_Phone'] = null;
			//$data['Contact_Email'] = null;

			if($club->Aca_contact_name)
			$data['Contact_Name']  = $club->Aca_contact_name;
			$data['Latitude']      = $club->Latitude;
			$data['Longitude']     = $club->Longitude;
			
			$is_enrolled = false;

			$check_enroll = $this->mclub->is_enrolled($user_id, $club->Aca_ID);

			if($check_enroll)
				$is_enrolled = true;

			$data['Enrolled']     = $is_enrolled;
			
			//if($club->Aca_contact_phone)
			//$data['Contact_Phone'] = $club->Aca_contact_phone;

			//if($club->Aca_contact_email)
			//$data['Contact_Email'] = $club->Aca_contact_email;
			$temp = null;

			if($club->Aca_sport){
				$sports = json_decode($club->Aca_sport, true);
				foreach($sports as $sport){
					if($sport){
					$sport_det = $this->general->get_sport($sport);
					$temp[] = array('sport_id' =>$sport,'sport_title'=>$sport_det['sport_title']);
					}
				}
			}
			else{
				if($club->Primary_Sport){
					$sport_det = $this->general->get_sport($club->Primary_Sport);
					$temp[] = array('sport_id' =>$sport,'sport_title'=>$sport_det['sport_title']);
				}
				else{
					$temp  = null;
				}
			}

			$data['Club_Sports'] = $temp;


			$temp1  = null;
			$get_club_loc = $this->mclub->get_clubs_locations($club->Aca_ID);
			
			if($get_club_loc){
				foreach($get_club_loc as $club_loc){
					$data2 = array();
					$data2['loc_id']   = $club_loc->loc_id;
					$data2['location'] = $club_loc->location;
					$data2['address']  = $club_loc->address;
					$data2['city']     = $club_loc->city;
					$data2['state']    = $club_loc->state;
					$data2['longitude'] = $club_loc->longitude;
					$data2['latitude'] = $club_loc->latitude;
					$temp1[] = $data2;
				}
			}
			$data['Club_court_locations'] = $temp1;

			$this->benchmark->mark('code_end');
			$response_time = $this->benchmark->elapsed_time('code_start', 'code_end');
			$data['response_time'] = $response_time;

			$data3[] = $data;
			/*echo "<pre>";
			print_r($data2);*/
			//exit;
		}

		$this->response($data3);
	}

	public function listAllNew_get(){
		$user_id	   = $this->input->get('user_id');
		$page		   = $this->input->get('page');
		$is_pnp	   = $this->input->get('is_pnp');
		$limit		   = 15;

		if($this->input->get('act') == 'search'){

			if($this->input->get('name')){
			$search['name'] = $this->input->get('name');
			}

			if($this->input->get('city')){
			$search['city'] = $this->input->get('city');
			}
		
			if($this->input->get('state')){
			$search['state'] = $this->input->get('state');
			}
		
			if($this->input->get('sport')){
			$search['sport'] = $this->input->get('sport');
			}

			if($this->input->get('distance')){
			$search['distance'] = $this->input->get('distance');
			}
		}

		if($page and !$is_pnp){
		$get_limit_clubs = $this->mclub->get_limit_clubs($user_id, $page, $limit, $search);
		//print_r($get_limit_clubs); exit;
		$get_club_list		= $get_limit_clubs[0]; 
		}
		else if($page and $is_pnp){
		$get_limit_clubs = $this->mclub->get_limit_pnpClubs($user_id, $page, $limit, $search);
		//print_r($get_limit_clubs); exit;
		$get_club_list		= $get_limit_clubs[0]; 
		}
		else{
		$get_club_list = $this->mclub->get_clubs($user_id);
		}

		/*$this->response($get_club_list);
		exit;*/
		foreach($get_club_list as $club) {

		$is_coach = false;
		if($user_id)
		$is_coach = $this->mclub->is_coach($club->Aca_ID, $user_id);

			$data = array();
			$data['Club_ID']	= $club->Aca_ID;
			$data['Club_Name']	= $club->Aca_name;
			//$data['Address1']	= $club->Aca_addr1;
			//$data['Address2']	= $club->Aca_addr2;
			$data['City']		= $club->Aca_city;
			$data['State']		= $club->Aca_state;
			//$data['Country']	= $club->Aca_country;
			//$data['Zip']		= $club->Aca_zip;

			//$data['Club_URL']	= null;
 			//if($club->Aca_url)
			//$data['Club_URL']	= $club->Aca_url;

			$data['Club_Logo']	= null;
			if($club->Aca_logo)
			$data['Club_Logo']	= base_url().'org_logos/'.$club->Aca_logo;
			$data['Club_Owner'] = $club->Aca_User_id;
			$data['Is_Coach']		= $is_coach;

			
			//$data['Contact_Phone'] = null;
			//$data['Contact_Email'] = null;

			/*
			$data['Contact_Name']  = null;
			if($club->Aca_contact_name)
			$data['Contact_Name']  = $club->Aca_contact_name;
			$data['Latitude']			  = $club->Latitude;
			$data['Longitude']		  = $club->Longitude;
			*/
			
			/*$is_enrolled = false;
			$check_enroll = $this->mclub->is_enrolled($user_id, $club->Aca_ID);

			if($check_enroll)
				$is_enrolled = true;

			$data['Enrolled']     = $is_enrolled;
			
			//if($club->Aca_contact_phone)
			//$data['Contact_Phone'] = $club->Aca_contact_phone;

			//if($club->Aca_contact_email)
			//$data['Contact_Email'] = $club->Aca_contact_email;
			*/
			$temp = null;

			if($club->Aca_sport){
				$sports = json_decode($club->Aca_sport, true);
				//echo $club->Aca_sport;
				//echo "<pre>"; print_r($sports);
//				$sports = array_unique($sports);

				foreach($sports as $sport){
					if($sport){
					//$sport_det = $this->general->get_sport($sport);
					//$temp[] = array('sport_id' =>$sport,'sport_title'=>$sport_det['sport_title']);
					$temp[] = intval($sport);
					}
				}
			}
			else{
				if($club->Primary_Sport){
					//$sport_det = $this->general->get_sport($club->Primary_Sport);
					//$temp[] = array('sport_id' =>$sport,'sport_title'=>$sport_det['sport_title']);
					$temp[] = intval($club->Primary_Sport);
				}
				else{
					$temp  = null;
				}
			}

			$data['Club_Sports'] = $temp;


			$temp1  = null;
			$get_club_loc = $this->mclub->get_clubs_locations($club->Aca_ID);
			$blocked_clubs = unserialize (RESERVE_BLOCKED_CLUBS);

			if($get_club_loc){
				foreach($get_club_loc as $club_loc){
					$data2 = array();
					$data2['loc_id']   = $club_loc->loc_id;
					$data2['location'] = $club_loc->location;
					$data2['address']  = $club_loc->address;
					$data2['city']     = $club_loc->city;
					$data2['state']    = $club_loc->state;
					$data2['longitude'] = $club_loc->longitude;
					$data2['latitude'] = $club_loc->latitude;
					if($this->mclub->is_location_nonmem_visible($club_loc->loc_id)){
						$data2['allow_payn_play'] = true;
					}
					else{
						$data2['allow_payn_play'] = false;
					}

					if(($club->Aca_User_id == $user_id) or $is_coach)
					$data2['allow_payn_play'] = true;

						if(in_array($club->Aca_ID, $blocked_clubs))
						$data2['allow_payn_play'] = false;

					$temp1[] = $data2;
				}
			}
			$data['Club_court_locations'] = $temp1;

			$data3[] = $data;
			/*echo "<pre>";
			print_r($data2);*/
			//exit;
		}
			$data4['results'] = $data3;

			if($get_limit_clubs[1])
			$data4['total_pages'] = $get_limit_clubs[1];

			$this->benchmark->mark('code_end');
			$response_time = $this->benchmark->elapsed_time('code_start', 'code_end');
			$data4['response_time'] = $response_time;


		$this->response($data4);
	}

	public function coachList_get() {
		$club_id = $this->input->get('club_id');

			$get_club_coaches = $this->mclub->get_club_coaches($club_id);

			foreach($get_club_coaches as $coach){

				$prof_pic = base_url().'profile_pictures/'.'default-profile.png';
				if($coach->Profilepic){
				$prof_pic = base_url().'profile_pictures/'.$coach->Profilepic;
				}

				$club_coaches[] = array(
								'Users_ID'		=> $coach->Users_ID,
								'Firstname'		=> $coach->Firstname,
								'Lastname'		=> $coach->Lastname,
								'EmailID'		=> $coach->EmailID,
								'AlternateEmailID'	=> $coach->AlternateEmailID,
								'DOB'				=> $coach->DOB,
								'Gender'			=> $coach->Gender,
								'UserAddressline1'	=> $coach->UserAddressline1,
								'UserAddressline2'	=> $coach->UserAddressline2,
								'Country'			=> $coach->Country,
								'State'				=> $coach->State,
								'City'				=> $coach->City,
								'Zipcode'			=> $coach->Zipcode,
								'HomePhone'			=> $coach->HomePhone,
								'Mobilephone'		=> $coach->Mobilephone,
								'IsUserActivation'	=> $coach->IsUserActivation,
								'Profilepic'	=> $prof_pic,
								'Latitude'		=> $coach->Latitude,
								'Longitude'		=> $coach->Longitude,
								'UserAgegroup'	=> $coach->UserAgegroup,
								'Username'		=> $coach->Username,
								'Is_coach'		=> $coach->Is_coach,
								'coach_profile' => $coach->coach_profile,		
								'Coach_Website' => $coach->Coach_Website,	
								'coach_sport'	=> trim($coach->coach_sport),	
								'Sportname'		=> $coach->Sportname	
							    );
			}

		//$data['Club_Coaches'] = $club_coaches;
		$this->response($club_coaches);
	}

	public function membersList_get() {
		$club_id = $this->input->get('club_id');

			$get_club_members = $this->mclub->get_club_members($club_id);
			
			foreach($get_club_members as $member){
				$mem_id = null;
				if($member['Membership_ID']){
					$mem_id = $member['Membership_ID'];
				}

				$prof_pic = base_url().'profile_pictures/'.'default-profile.png';
				if($member["Profilepic"]){
				$prof_pic = base_url().'profile_pictures/'.$member["Profilepic"];
				}

				$sp	  = array();
				$get_user_sp = $this->general->get_user_sp_intrests($member['Users_ID']);

			foreach($get_user_sp as $user_sp){
				$sp[] = array("Sport_id" => trim($user_sp["Sport_id"]), "Level" => trim($user_sp["Level"]));
			}
			/*$sp[] = array("Sport_id" => trim($user["Sport_id"]), "Level" => trim($user["Level"]));*/

			$club_members[$member['Users_ID']] =  
			array(
				"Users_ID"		=> $member['Users_ID'],
				"Firstname"		=> $member['Firstname'],
				"Lastname"		=> $member["Lastname"],
				"EmailID"		=> $member["EmailID"],
				"AlternateEmailID" => $member["AlternateEmailID"],
				"DOB"			=> $member["DOB"],
				"Gender"		=> $member["Gender"],
				"UserAddressline1" => $member["UserAddressline1"],
				"UserAddressline2" => $member["UserAddressline2"],
				"Country"		=> $member["Country"],
				"State"			=> $member["State"],
				"City"			=> $member["City"],
				"Zipcode"		=> $member["Zipcode"],
				"HomePhone"		=> $member["HomePhone"],
				"Mobilephone"	=> $member["Mobilephone"],
				"IsUserActivation" => $member["IsUserActivation"],
				"Profilepic"	=> $prof_pic,
				"Latitude"		=> $member["Latitude"],
				"Longitude"		=> $member["Longitude"],
				"UserAgegroup"	=> $member["UserAgegroup"],
				"Username"		=> $member["Username"],
				"Is_coach"		=> $member["Is_coach"],
				"coach_profile" => $member["coach_profile"],
				"Coach_Website" => $member["Coach_Website"],
				"coach_sport"	=> $member["coach_sport"],
				"membership_id"	=> $mem_id,
				"sports_interests" => $sp
				);

			}

		//$data['Club_Members'] = $club_members;
		$this->response($club_members);
	}

	public function listPNP_get(){
		$user_id = $this->input->get('user_id');
		
		$get_club_list = $this->mclub->get_clubs_having_courts($user_id);
		
		$blocked_clubs = unserialize (RESERVE_BLOCKED_CLUBS);

		foreach($get_club_list as $club){
			if(!in_array($club->Aca_ID, $blocked_clubs)){
			$data = array();
			$temp = array();
			$temp1 = array();
			$data['Club_ID']	= $club->Aca_ID;
			$data['Club_Name']	= $club->Aca_name;
			$data['Address1']	= $club->Aca_addr1;
			$data['Address2']	= $club->Aca_addr2;
			$data['City']		= $club->Aca_city;
			$data['State']		= $club->Aca_state;
			$data['Country']	= $club->Aca_country;
			$data['Zip']		= $club->Aca_zip;

			$data['Club_URL']	= null;
 			if($club->Aca_url)
			$data['Club_URL']	= $club->Aca_url;

			$data['Club_Logo']	= null;
			if($club->Aca_logo)
			$data['Club_Logo']	= base_url().'org_logos/'.$club->Aca_logo;

			$data['Contact_Name']  = null;
			$data['Contact_Phone'] = null;
			$data['Contact_Email'] = null;

			if($club->Aca_contact_name)
			$data['Contact_Name']  = $club->Aca_contact_name;

			if($club->Aca_contact_phone)
			$data['Contact_Phone'] = $club->Aca_contact_phone;

			if($club->Aca_contact_email)
			$data['Contact_Email'] = lcfirst($club->Aca_contact_email);
			$temp = null;

			if($club->Aca_sport){
				$sports = json_decode($club->Aca_sport, true);
				foreach($sports as $sport){
					if($sport){
					$sport_det = $this->general->get_sport($sport);
					$temp[]	   = array('sport_id' =>$sport, 'sport_title'=>$sport_det['sport_title']);
					}
				}
			}
			else{
				if($club->Primary_Sport){
					$sport_det = $this->general->get_sport($club->Primary_Sport);
					$temp[] = array('sport_id' =>$sport, 'sport_title'=>$sport_det['sport_title']);
				}
				else{
					$temp  = null;
				}
			}

			$data['Club_Sports'] = $temp;


			$get_club_loc = $this->mclub->get_clubs_locations($club->Aca_ID);

				foreach($get_club_loc as $club_loc){
					$data2 = array();
					$data2['loc_id']   = $club_loc->loc_id;
					$data2['location'] = $club_loc->location;
					$data2['address']  = $club_loc->address;
					$data2['city']     = $club_loc->city;
					$data2['state']    = $club_loc->state;
					$data2['longitude'] = $club_loc->longitude;
					$data2['latitude'] = $club_loc->latitude;
					$temp1[] = $data2;
				}

			$data['Club_court_locations'] = $temp1;
			$data3[] = $data;
			}
		}

		$this->response($data3);
	}

	public function courts_backup_get(){
// working one before revising the break times 08-OCT-2021
		$loc_id    = $this->input->get('loc_id');
		$user_id = $this->input->get('user_id');

		$club_id = '';
		if($this->input->get('club_id'))
		$club_id = $this->input->get('club_id');
	
		if($loc_id) {
			$is_club_member = $this->mclub->is_club_member($user_id, $loc_id);
			$get_discount		= $this->mclub->get_member_discount($loc_id);
			
			$is_club_admin = false;
			$is_coach		 = false;

			if($club_id){
				$get_club				= $this->mclub->get_club($club_id);
				if($get_club['Aca_User_id'] == $user_id)
				$is_club_admin = true;
			}

			if($user_id and $club_id)
			$is_coach = $this->mclub->is_coach($club_id, $user_id);

				$disc			= 0;
				$is_member = 0;

			if($get_discount['member_discount']){
				$disc = $get_discount['member_discount'];
				if($is_club_member){
				$is_member = 1;
				}
			}

	
			$is_booking_allowed = true;
			if(!$get_discount['access_to_nonmem'] and !$is_coach and !$is_club_admin){
				if($is_club_member)
					$is_booking_allowed = true;
				else
					$is_booking_allowed = false;
			}

			$get_loc_courts = $this->mclub->get_loc_courts($loc_id);
			foreach($get_loc_courts as $court) {
				$data			= array();
				$bookings  = array();

				$get_court_info			= $this->mclub->get_court_info($court->court_id);				
				$get_court_prices		= $this->mclub->get_court_prices($court->court_id);				
				$get_court_bookings	= $this->mclub->get_court_bookings($court->court_id);
				
				$allow_same_day_booking = false;
				if($get_court_info['allow_sameday_booking']){
				$allow_same_day_booking = true;
				}

				$allow_sameday_multi_booking = false;
				if($get_court_info['allow_sameday_multi_booking']){
				$allow_sameday_multi_booking = true;
				}

				//$data = json_decode($get_court_info['court_info_json'], true);
					$is_sharable = 0;

				$mx_adv_days = $get_court_info['max_adv_booking_days'];

				if($is_club_admin or $is_coach){
				$mx_adv_days = 182;
				$allow_sameday_multi_booking = true;
				$allow_same_day_booking		  = true;
				}

				if($get_court_info['is_shared_resource'])
					$is_sharable = 1;
					$data['court_info'] = array(
						'court_id'			=> $get_court_info['court_id'], 
						'court_name'		=> $get_court_info['court_name'], 
						'max_players'	=> (int)$get_court_info['max_players'], 
						'max_adv_booking_days'	 => $mx_adv_days, 
						'allow_sameday_multi_booking' => $allow_sameday_multi_booking, 
						'allow_sameday_booking'  => $allow_same_day_booking, 
						'is_booking_allowed'  => $is_booking_allowed, 
						'is_shareable'	=> $is_sharable);
					$data['court_timings'] = array('open_days' => array('sun','mon','tue','wed','thu','fri','sat'), 'close_days' => null);

				$max_hours	= $get_court_info['max_hours'];
				if($is_club_admin or $is_coach){
				$max_hours	= 10;
				}
				//echo "<pre>"; print_r($get_court_prices); exit;
				/* ********* prices *************/ 
$stTime = array(); $edTime = array(); $sunPrice = array(); $monPrice = array(); $tuePrice = array(); $wedPrice = array(); $thuPrice = array(); $friPrice = array(); $satPrice = array(); $sunAddnPrice = array(); $monAddnPrice = array(); $tueAddnPrice = array(); $wedAddnPrice = array(); $thuAddnPrice = array(); $friAddnPrice = array(); $satAddnPrice = array(); 
				foreach($get_court_prices as $price_info){
					$stTime[]  = $price_info->Start_Time;
					$edTime[] = $price_info->End_Time;
					$sunPrice[] = $price_info->Sun_Price;
					$monPrice[] = $price_info->Mon_Price;
					$tuePrice[] = $price_info->Tue_Price;
					$wedPrice[] = $price_info->Wed_Price;
					$thuPrice[] = $price_info->Thu_Price;
					$friPrice[] = $price_info->Fri_Price;
					$satPrice[] = $price_info->Sat_Price;
					$sunAddnPrice[] = $price_info->Sun_Addn_Price;
					$monAddnPrice[] = $price_info->Mon_Addn_Price;
					$tueAddnPrice[] = $price_info->Tue_Addn_Price;
					$wedAddnPrice[] = $price_info->Wed_Addn_Price;
					$thuAddnPrice[] = $price_info->Thu_Addn_Price;
					$friAddnPrice[] = $price_info->Fri_Addn_Price;
					$satAddnPrice[] = $price_info->Sat_Addn_Price;
				}

				$court_min_time = date("H:i", strtotime(min($stTime)));
				$court_max_time = date("H:i", strtotime(max($edTime)));

				$court_timings = array('start_time' => "{$court_min_time}", 'end_time' => "{$court_max_time}");
				//if($loc_id == 30)
					//echo "<pre>"; print_r($sunPrice); exit;
				foreach($stTime as $j => $st) {
					$st = date("H:i", strtotime($st));
					$ed = date("H:i", strtotime($edTime[$j]));
					for($k = $st; $k < $ed; ) {
						$k  = date("H:i", strtotime($k));
						$kk = date("H:i", strtotime($k."+1 hours"));
						$court_valid_times[] = $k.'-'.$kk;
						$k = $kk;
					}
				}
				/*echo "<pre>";
				print_r($court_valid_times);
				echo "<br>----vt----";*/
				for($m = $court_min_time; $m < $court_max_time; ) {
					$mmm_arr	= '';
					$m				= date("H:i", strtotime($m));
					$mm			= date("H:i", strtotime($m."+1 hours"));
					$mmm		= $m.'-'.$mm;
					$mmm_arr	  = array('start_time' => $m, 'end_time' => $mm);
					$hour_arr[] = $mmm;

					if(!in_array($mmm, $court_valid_times)){
						//$break_times[$i][] = $mmm_arr;
						$break_times[0][] = $mmm_arr;
						$break_times[1][] = $mmm_arr;
						$break_times[2][] = $mmm_arr;
						$break_times[3][] = $mmm_arr;
						$break_times[4][] = $mmm_arr;
						$break_times[5][] = $mmm_arr;
						$break_times[6][] = $mmm_arr;
					}
					$m = $mm;
				}
				/*echo "<pre>";
				print_r($hour_arr);
				echo "<br>---hrs-----";*/
		//echo "test"; exit;
					$pr = array();
				foreach($stTime as $j => $val){
				
					if($sunPrice[$j] != 'n/a' and $sunPrice[$j] != ""){
					$pr['sun'][] = array('price' => number_format($sunPrice[$j], 2),
						'start_time' => date('H:i', strtotime($stTime[$j])),
						'end_time'   => date('H:i', strtotime($edTime[$j])),
						'additional_price_per_player'   => number_format($sunAddnPrice[$j], 2)
						);
					}
					else{
						//$break_times[0][] = array(date('H:i', strtotime($stTime[$j])), date('H:i', strtotime($edTime[$j])));
						$break_times[0][] = array('start_time' => date('H:i', strtotime($stTime[$j])), 'end_time' => date('H:i', strtotime($edTime[$j])));
					}

					if($monPrice[$j] != 'n/a' and $monPrice[$j] != ""){
					$pr['mon'][] = array('price' => number_format($monPrice[$j], 2),
						'start_time' => date('H:i', strtotime($stTime[$j])),
						'end_time'   => date('H:i', strtotime($edTime[$j])),
						'additional_price_per_player'   => number_format($monAddnPrice[$j], 2)
						);
					}
					else{
						//$break_times[1][] = array(date('H:i', strtotime($stTime[$j])), date('H:i', strtotime($edTime[$j])));
						$break_times[1][] = array('start_time' => date('H:i', strtotime($stTime[$j])), 'end_time' => date('H:i', strtotime($edTime[$j])));
					}


					if($tuePrice[$j] != 'n/a' and $tuePrice[$j] != ""){
					$pr['tue'][] = array('price' => number_format($tuePrice[$j], 2),
						'start_time' => date('H:i', strtotime($stTime[$j])),
						'end_time'   => date('H:i', strtotime($edTime[$j])),
						'additional_price_per_player'   => number_format($tueAddnPrice[$j], 2)
						);
					}
					else{
						//$break_times[2][] = array(date('H:i', strtotime($stTime[$j])), date('H:i', strtotime($edTime[$j])));
						$break_times[2][] = array('start_time' => date('H:i', strtotime($stTime[$j])), 'end_time' => date('H:i', strtotime($edTime[$j])));
					}

					if($wedPrice[$j] != 'n/a' and $wedPrice[$j] != ""){
					$pr['wed'][] = array('price' => number_format($wedPrice[$j], 2),
						'start_time' => date('H:i', strtotime($stTime[$j])),
						'end_time'   => date('H:i', strtotime($edTime[$j])),
						'additional_price_per_player'   => number_format($wedAddnPrice[$j], 2)
						);
					}
					else{
						//$break_times[3][] = array(date('H:i', strtotime($stTime[$j])), date('H:i', strtotime($edTime[$j])));
						$break_times[3][] = array('start_time' => date('H:i', strtotime($stTime[$j])), 'end_time' => date('H:i', strtotime($edTime[$j])));
					}

					if($thuPrice[$j] != 'n/a' and $thuPrice[$j] != ""){
					$pr['thu'][] = array('price' => number_format($thuPrice[$j], 2),
						'start_time' => date('H:i', strtotime($stTime[$j])),
						'end_time'   => date('H:i', strtotime($edTime[$j])),
						'additional_price_per_player'   => number_format($thuAddnPrice[$j], 2)
						);
					}
					else{
						//$break_times[4][] = array(date('H:i', strtotime($stTime[$j])), date('H:i', strtotime($edTime[$j])));
						$break_times[4][] = array('start_time' => date('H:i', strtotime($stTime[$j])), 'end_time' => date('H:i', strtotime($edTime[$j])));
					}

					if($friPrice[$j] != 'n/a' and $friPrice[$j] != ""){
					$pr['fri'][] = array('price' => number_format($friPrice[$j], 2),
						'start_time' => date('H:i', strtotime($stTime[$j])),
						'end_time'   => date('H:i', strtotime($edTime[$j])),
						'additional_price_per_player'   => number_format($friAddnPrice[$j], 2)
						);
					}
					else{
						//$break_times[5][] = array(date('H:i', strtotime($stTime[$j])), date('H:i', strtotime($edTime[$j])));
						$break_times[5][] = array('start_time' => date('H:i', strtotime($stTime[$j])), 'end_time' => date('H:i', strtotime($edTime[$j])));
					}

					if($satPrice[$j] != 'n/a' and $satPrice[$j] != ""){
					$pr['sat'][] = array('price' => number_format($satPrice[$j], 2),
						'start_time' => date('H:i', strtotime($stTime[$j])),
						'end_time'   => date('H:i', strtotime($edTime[$j])),
						'additional_price_per_player'   => number_format($satAddnPrice[$j], 2)
						);
					}
					else{
						//break_times[6][] = array(date('H:i', strtotime($stTime[$j])), date('H:i', strtotime($edTime[$j])));
						$break_times[6][] = array('start_time' => date('H:i', strtotime($stTime[$j])), 'end_time' => date('H:i', strtotime($edTime[$j])));
					}

					//$ins_court_price = $this->db->insert('Academy_Courts_Price', $data);
				}


					$court_prices['sun'] = array(
							'actual_timings' => $court_timings, 
							'break'			 => $break_times[0], 
							'step'			 => $get_court_info['slot_duration'], 
							'min_booking_hours' => ($get_court_info['slot_duration'] * $get_court_info['min_book_slots']), 
							'max_booking_hours'	=> "{$max_hours}",
							'prices'		 => $pr['sun']
						   );

					$court_prices['mon'] = array(
							'actual_timings' => $court_timings, 
							'break'			 => $break_times[1], 
							'step'			 => $get_court_info['slot_duration'], 
							'min_booking_hours' => ($get_court_info['slot_duration'] * $get_court_info['min_book_slots']), 
							'max_booking_hours'	=> "{$max_hours}",
							'prices'		 => $pr['mon']
						   );

					$court_prices['tue'] = array(
							'actual_timings' => $court_timings, 
							'break'			 => $break_times[2], 
							'step'			 => $get_court_info['slot_duration'],  
							'min_booking_hours' => ($get_court_info['slot_duration'] * $get_court_info['min_book_slots']), 
							'max_booking_hours'	=> "{$max_hours}",
							'prices'		 => $pr['tue']
						   );

					$court_prices['wed'] = array(
							'actual_timings' => $court_timings, 
							'break'			 => $break_times[3], 
							'step'			 => $get_court_info['slot_duration'], 
							'min_booking_hours' => ($get_court_info['slot_duration'] * $get_court_info['min_book_slots']), 
							'max_booking_hours'	=> "{$max_hours}",
							'prices'		 => $pr['wed']
						   );

					$court_prices['thu'] = array(
							'actual_timings' => $court_timings, 
							'break'			 => $break_times[4], 
							'step'			 => $get_court_info['slot_duration'], 
							'min_booking_hours' => ($get_court_info['slot_duration'] * $get_court_info['min_book_slots']), 
							'max_booking_hours'	=> "{$max_hours}",
							'prices'		 => $pr['thu']
						   );

					$court_prices['fri'] = array(
							'actual_timings' => $court_timings, 
							'break'			 => $break_times[5], 
							'step'			 => $get_court_info['slot_duration'], 
							'min_booking_hours' => ($get_court_info['slot_duration'] * $get_court_info['min_book_slots']), 
							'max_booking_hours'	=> "{$max_hours}",
							'prices'		 => $pr['fri']
						   );

					$court_prices['sat'] = array(
							'actual_timings' => $court_timings, 
							'break'			 => $break_times[6], 
							'step'			 => $get_court_info['slot_duration'], 
							'min_booking_hours' => ($get_court_info['slot_duration'] * $get_court_info['min_book_slots']), 
							'max_booking_hours'	=> "{$max_hours}",
							'prices'		 => $pr['sat']
						   );

				$data['court_prices'] = $court_prices;
				/* ********* prices *************/ 
				$data['paymethods'] = array(array('pay_method'   => $get_court_info['gateway_name'], 'reference_id' => $get_court_info['payment_ref_id']));

				$data['discounts'] = array('is_club_member' => $is_member, 'member_discount_percentage' => $disc);

				$tot_book_arr = array();
				$slot_dur = $get_court_info['slot_duration'];
				//echo "Test"; exit;
				//echo $slot_dur; exit;
				if($is_sharable){
					foreach($get_court_bookings as $booking) {
						//$frTime  = strtotime($booking->from_time);
						//$toTime = strtotime($booking->to_time);
							
							$k	= date("Y-m-d H:i", strtotime($booking->res_date.' '.$booking->from_time));
				//$c = 1;
						for( ;strtotime($k) < strtotime($booking->res_date.' '.$booking->to_time);){

							//$k2  = date("Y-m-d H:i", strtotime('+30 minutes', strtotime($k)));
							$k2  = date("Y-m-d H:i", strtotime('+'.($slot_dur * 60).' minutes', strtotime($k)));

							if($tot_book_arr["'".$k."-".$k2."'"])
								$tot_book_arr["'".$k."-".$k2."'"] += $booking->num_players;
							else
								$tot_book_arr["'".$k."-".$k2."'"] = $booking->num_players;
							/*var_dump($k);
							var_dump($k2);
							echo $c."<br>";
							$c++;*/
							$k = $k2;
						}

					}
				}
//echo "<pre> test "; print_r($tot_book_arr); echo "------<br>";
$temp_arr = array();
				foreach($get_court_bookings as $booking) {
					//$from  = date('D Y-m-d H:i:s', strtotime($booking->res_date.' '.$booking->from_time));
					//$to	     = date('D Y-m-d H:i:s', strtotime($booking->res_date.' '.$booking->to_time));

						$frTime  = strtotime($booking->from_time);
						$toTime = strtotime($booking->to_time);
						
						$actual_from	= date("Y-m-d H:i", strtotime($booking->res_date.' '.$booking->from_time));
						$actual_to		= date("Y-m-d H:i", strtotime($booking->res_date.' '.$booking->to_time));

						$k	= date("Y-m-d H:i", strtotime($booking->res_date.' '.$booking->from_time));
				
						for( ;strtotime($k) < strtotime($booking->res_date.' '.$booking->to_time);){

							//$k2  = date("Y-m-d H:i", strtotime('+30 minutes', strtotime($k)));
							$k2  = date("Y-m-d H:i", strtotime('+'.($slot_dur * 60).' minutes', strtotime($k)));

							/*if(date("H:i", strtotime('+30 minutes', $booking->from_time)) >= date("H:i", strtotime($booking->to_time))){
								echo "test";
							}*/
							//echo $k2." - ".date("H:i", strtotime($booking->to_time)); exit;
							$from  = date('Y-m-d H:i:s', strtotime($k));
							$to	     = date('Y-m-d H:i:s', strtotime($k2));
							$reserved_by  = $booking->reserved_by;
							$numP				= $booking->num_players;
							$tot_bookings  = $booking->num_players;

							if(!empty($tot_book_arr)){
							$tot_bookings  = $tot_book_arr["'".$k."-".$k2."'"];
							}

							if(!in_array($from."-".$to, $temp_arr)){
								if($booking->players)
								$pList = json_decode($booking->players, true);
								else{
									$get_user = $this->general->get_user($booking->reserved_by);
									//echo "<pre>"; print_r($get_user); exit;
									if($get_user)
										$pList = array($get_user['Firstname']." ".$get_user['Lastname']);
								}

								$temp_arr[] = $from."-".$to;
								$temp_plist[$from."-".$to] = $pList;
								$bookings[] = array('from' => $from, 'to' => $to, 'reserved_by' => $reserved_by, 'numPlayers' => $numP, 'playersList' => $pList, 'total_bookings' => $tot_bookings, 'actual_booking_from' => $actual_from, 'actual_booking_to' => $actual_to);
							}
							/*else{
								$pList  = json_decode($booking->players, true);
								$temp = $temp_plist[$from."-".$to]; 
								$pList  = array_merge($pList, $temp);
							}*/

							$k = $k2;
						}

				}

				$data['current_bookings'] = $bookings;

				$data2[] = $data;
			}
			
			$this->response($data2, 200);
		}
		else {
			$res = array('Error: '."Location ID is Missing");
			$this->response($res, 400);
		}

	}

	public function courtsTemp_get(){

		$loc_id    = $this->input->get('loc_id');
		$user_id = $this->input->get('user_id');

		$club_id = '';
		if($this->input->get('club_id'))
		$club_id = $this->input->get('club_id');
	
		if($loc_id) {
			$is_club_member = $this->mclub->is_club_member($user_id, $loc_id);
			$get_discount		= $this->mclub->get_member_discount($loc_id);
			
			$is_club_admin = false;
			$is_coach		 = false;

			if($club_id){
				$get_club				= $this->mclub->get_club($club_id);
				if($get_club['Aca_User_id'] == $user_id)
				$is_club_admin = true;
			}

			if($user_id and $club_id)
			$is_coach = $this->mclub->is_coach($club_id, $user_id);

				$disc			= 0;
				$is_member = 0;

			if($get_discount['member_discount']){
				$disc = $get_discount['member_discount'];
				if($is_club_member){
				$is_member = 1;
				}
			}

	
			$is_booking_allowed = true;
			if(!$get_discount['access_to_nonmem'] and !$is_coach and !$is_club_admin){
				if($is_club_member)
					$is_booking_allowed = true;
				else
					$is_booking_allowed = false;
			}

			$get_loc_courts = $this->mclub->get_loc_courts($loc_id);
			foreach($get_loc_courts as $court) {
				$data			= array();
				$bookings  = array();

				$get_court_info			= $this->mclub->get_court_info($court->court_id);				
				$get_court_prices		= $this->mclub->get_court_prices($court->court_id);				
				$get_court_bookings	= $this->mclub->get_court_bookings($court->court_id);
				
				$allow_same_day_booking = false;
				if($get_court_info['allow_sameday_booking']){
				$allow_same_day_booking = true;
				}

				$allow_sameday_multi_booking = false;
				if($get_court_info['allow_sameday_multi_booking']){
				$allow_sameday_multi_booking = true;
				}

				//$data = json_decode($get_court_info['court_info_json'], true);
					$is_sharable = 0;

				$mx_adv_days = $get_court_info['max_adv_booking_days'];

				if($is_club_admin or $is_coach){
				$mx_adv_days = 182;
				$allow_sameday_multi_booking = true;
				$allow_same_day_booking		  = true;
				}

				if($get_court_info['is_shared_resource'])
					$is_sharable = 1;
					$data['court_info'] = array(
						'court_id'			=> $get_court_info['court_id'], 
						'court_name'		=> $get_court_info['court_name'], 
						'max_players'	=> (int)$get_court_info['max_players'], 
						'max_adv_booking_days'	 => $mx_adv_days, 
						'allow_sameday_multi_booking' => $allow_sameday_multi_booking, 
						'allow_sameday_booking'  => $allow_same_day_booking, 
						'is_booking_allowed'  => $is_booking_allowed, 
						'is_shareable'	=> $is_sharable);
					$data['court_timings'] = array('open_days' => array('sun','mon','tue','wed','thu','fri','sat'), 'close_days' => null);

				$max_hours	= $get_court_info['max_hours'];
				if($is_club_admin or $is_coach){
				$max_hours	= 10;
				}
				//echo "<pre>"; print_r($get_court_prices); exit;
				/* ********* prices *************/ 
$stTime = array(); $edTime = array(); $sunPrice = array(); $monPrice = array(); $tuePrice = array(); $wedPrice = array(); $thuPrice = array(); $friPrice = array(); $satPrice = array(); $sunAddnPrice = array(); $monAddnPrice = array(); $tueAddnPrice = array(); $wedAddnPrice = array(); $thuAddnPrice = array(); $friAddnPrice = array(); $satAddnPrice = array(); 
				foreach($get_court_prices as $price_info){
					$stTime[]  = $price_info->Start_Time;
					$edTime[] = $price_info->End_Time;
					$sunPrice[] = $price_info->Sun_Price;
					$monPrice[] = $price_info->Mon_Price;
					$tuePrice[] = $price_info->Tue_Price;
					$wedPrice[] = $price_info->Wed_Price;
					$thuPrice[] = $price_info->Thu_Price;
					$friPrice[] = $price_info->Fri_Price;
					$satPrice[] = $price_info->Sat_Price;
					$sunAddnPrice[] = $price_info->Sun_Addn_Price;
					$monAddnPrice[] = $price_info->Mon_Addn_Price;
					$tueAddnPrice[] = $price_info->Tue_Addn_Price;
					$wedAddnPrice[] = $price_info->Wed_Addn_Price;
					$thuAddnPrice[] = $price_info->Thu_Addn_Price;
					$friAddnPrice[] = $price_info->Fri_Addn_Price;
					$satAddnPrice[] = $price_info->Sat_Addn_Price;
				}


					$stdt = array();
					$pr	 = array();
				foreach($stTime as $j => $val){
				
					if($sunPrice[$j] != 'n/a' and $sunPrice[$j] != ""){
						//var_dump($sunPrice[$j]); 
						//echo date('H:i', strtotime($edTime[$j]));
						$stdt['sun']['st'][] =  $stTime[$j];
						$stdt['sun']['ed'][] =  $edTime[$j];
					$pr['sun'][] = array('price' => number_format($sunPrice[$j], 2),
						'start_time' => date('H:i', strtotime($stTime[$j])),
						'end_time'   => date('H:i', strtotime($edTime[$j])),
						'additional_price_per_player'   => number_format($sunAddnPrice[$j], 2)
						);
					}
					else{
						//$break_times[0][] = array(date('H:i', strtotime($stTime[$j])), date('H:i', strtotime($edTime[$j])));
						$break_times[0][] = array('start_time' => date('H:i', strtotime($stTime[$j])), 'end_time' => date('H:i', strtotime($edTime[$j])));
					}

					if($monPrice[$j] != 'n/a' and $monPrice[$j] != ""){
						$stdt['mon']['st'][] =  $stTime[$j];
						$stdt['mon']['ed'][] =  $edTime[$j];

					$pr['mon'][] = array('price' => number_format($monPrice[$j], 2),
						'start_time' => date('H:i', strtotime($stTime[$j])),
						'end_time'   => date('H:i', strtotime($edTime[$j])),
						'additional_price_per_player'   => number_format($monAddnPrice[$j], 2)
						);
					}
					else{
						//$break_times[1][] = array(date('H:i', strtotime($stTime[$j])), date('H:i', strtotime($edTime[$j])));
						$break_times[1][] = array('start_time' => date('H:i', strtotime($stTime[$j])), 'end_time' => date('H:i', strtotime($edTime[$j])));
					}


					if($tuePrice[$j] != 'n/a' and $tuePrice[$j] != ""){
						$stdt['tue']['st'][] =  $stTime[$j];
						$stdt['tue']['ed'][] =  $edTime[$j];

					$pr['tue'][] = array('price' => number_format($tuePrice[$j], 2),
						'start_time' => date('H:i', strtotime($stTime[$j])),
						'end_time'   => date('H:i', strtotime($edTime[$j])),
						'additional_price_per_player'   => number_format($tueAddnPrice[$j], 2)
						);
					}
					else{
						//$break_times[2][] = array(date('H:i', strtotime($stTime[$j])), date('H:i', strtotime($edTime[$j])));
						$break_times[2][] = array('start_time' => date('H:i', strtotime($stTime[$j])), 'end_time' => date('H:i', strtotime($edTime[$j])));
					}

					if($wedPrice[$j] != 'n/a' and $wedPrice[$j] != ""){
						$stdt['wed']['st'][] =  $stTime[$j];
						$stdt['wed']['ed'][] =  $edTime[$j];

					$pr['wed'][] = array('price' => number_format($wedPrice[$j], 2),
						'start_time' => date('H:i', strtotime($stTime[$j])),
						'end_time'   => date('H:i', strtotime($edTime[$j])),
						'additional_price_per_player'   => number_format($wedAddnPrice[$j], 2)
						);
					}
					else{
						//$break_times[3][] = array(date('H:i', strtotime($stTime[$j])), date('H:i', strtotime($edTime[$j])));
						$break_times[3][] = array('start_time' => date('H:i', strtotime($stTime[$j])), 'end_time' => date('H:i', strtotime($edTime[$j])));
					}

					if($thuPrice[$j] != 'n/a' and $thuPrice[$j] != ""){
						$stdt['thu']['st'][] =  $stTime[$j];
						$stdt['thu']['ed'][] =  $edTime[$j];

					$pr['thu'][] = array('price' => number_format($thuPrice[$j], 2),
						'start_time' => date('H:i', strtotime($stTime[$j])),
						'end_time'   => date('H:i', strtotime($edTime[$j])),
						'additional_price_per_player'   => number_format($thuAddnPrice[$j], 2)
						);
					}
					else{
						//$break_times[4][] = array(date('H:i', strtotime($stTime[$j])), date('H:i', strtotime($edTime[$j])));
						$break_times[4][] = array('start_time' => date('H:i', strtotime($stTime[$j])), 'end_time' => date('H:i', strtotime($edTime[$j])));
					}

					if($friPrice[$j] != 'n/a' and $friPrice[$j] != ""){
						$stdt['fri']['st'][] =  $stTime[$j];
						$stdt['fri']['ed'][] =  $edTime[$j];

					$pr['fri'][] = array('price' => number_format($friPrice[$j], 2),
						'start_time' => date('H:i', strtotime($stTime[$j])),
						'end_time'   => date('H:i', strtotime($edTime[$j])),
						'additional_price_per_player'   => number_format($friAddnPrice[$j], 2)
						);
					}
					else{
						//$break_times[5][] = array(date('H:i', strtotime($stTime[$j])), date('H:i', strtotime($edTime[$j])));
						$break_times[5][] = array('start_time' => date('H:i', strtotime($stTime[$j])), 'end_time' => date('H:i', strtotime($edTime[$j])));
					}

					if($satPrice[$j] != 'n/a' and $satPrice[$j] != ""){
						$stdt['sat']['st'][] =  $stTime[$j];
						$stdt['sat']['ed'][] =  $edTime[$j];

					$pr['sat'][] = array('price' => number_format($satPrice[$j], 2),
						'start_time' => date('H:i', strtotime($stTime[$j])),
						'end_time'   => date('H:i', strtotime($edTime[$j])),
						'additional_price_per_player'   => number_format($satAddnPrice[$j], 2)
						);
					}
					else{
						//break_times[6][] = array(date('H:i', strtotime($stTime[$j])), date('H:i', strtotime($edTime[$j])));
						$break_times[6][] = array('start_time' => date('H:i', strtotime($stTime[$j])), 'end_time' => date('H:i', strtotime($edTime[$j])));
					}

					//$ins_court_price = $this->db->insert('Academy_Courts_Price', $data);
				}

				
		/* ************************************** */
		//echo "<pre>"; print_r($stdt); exit;
		$court_min_time = array();
		$court_max_time = array();
		$court_timings = array();
		foreach($stdt as $day => $tms){

				$court_min_time[$day] = date("H:i", strtotime(min($tms['st'])));
				$court_max_time[$day] = date("H:i", strtotime(max($tms['ed'])));

				$court_timings[$day] = array('start_time' => "{$court_min_time[$day]}", 'end_time' => "{$court_max_time[$day]}");
				//if($loc_id == 30)
					//echo "<pre>"; print_r($stTime); exit;
					$court_valid_times = array();
				foreach($tms['st'] as $j => $st) {
					$st = date("H:i", strtotime($st));
					$ed = date("H:i", strtotime($tms['ed'][$j]));
					for($k = $st; $k < $ed; ) {
						$k  = date("H:i", strtotime($k));
						$kk = date("H:i", strtotime($k."+1 hours"));
						$court_valid_times[] = $k.'-'.$kk;
						$k = $kk;
					}
				}

				for($m = $court_min_time[$day]; $m < $court_max_time[$day]; ) {
					$mmm_arr	= '';
					$m				= date("H:i", strtotime($m));
					$mm			= date("H:i", strtotime($m."+1 hours"));
					$mmm		= $m.'-'.$mm;
					$mmm_arr	  = array('start_time' => $m, 'end_time' => $mm);
					$hour_arr[] = $mmm;

					if(!in_array($mmm, $court_valid_times)){
						//$break_times[$i][] = $mmm_arr;
						$break_times[$day][] = $mmm_arr;
					}
					$m = $mm;
				}
		}
		/* ************************************** */
		//echo "<pre>"; print_r($court_timings); exit;

					$court_prices['sun'] = array(
							'actual_timings' => $court_timings['sun'], 
							'break'			 => $break_times['sun'], 
							'step'			 => $get_court_info['slot_duration'], 
							'min_booking_hours' => ($get_court_info['slot_duration'] * $get_court_info['min_book_slots']), 
							'max_booking_hours' => ($get_court_info['slot_duration'] * $max_hours), 
							//'max_booking_hours'	=> "{$max_hours}",
							'prices'		 => $pr['sun']
						   );

					$court_prices['mon'] = array(
							'actual_timings' => $court_timings['mon'], 
							'break'			 => $break_times['mon'], 
							'step'			 => $get_court_info['slot_duration'], 
							'min_booking_hours' => ($get_court_info['slot_duration'] * $get_court_info['min_book_slots']), 
							'max_booking_hours' => ($get_court_info['slot_duration'] * $max_hours), 
							//'max_booking_hours'	=> "{$max_hours}",
							'prices'		 => $pr['mon']
						   );

					$court_prices['tue'] = array(
							'actual_timings' => $court_timings['tue'], 
							'break'			 => $break_times['tue'], 
							'step'			 => $get_court_info['slot_duration'],  
							'min_booking_hours' => ($get_court_info['slot_duration'] * $get_court_info['min_book_slots']), 
							'max_booking_hours' => ($get_court_info['slot_duration'] * $max_hours), 
							//'max_booking_hours'	=> "{$max_hours}",
							'prices'		 => $pr['tue']
						   );

					$court_prices['wed'] = array(
							'actual_timings' => $court_timings['wed'], 
							'break'			 => $break_times['wed'], 
							'step'			 => $get_court_info['slot_duration'], 
							'min_booking_hours' => ($get_court_info['slot_duration'] * $get_court_info['min_book_slots']), 
							'max_booking_hours' => ($get_court_info['slot_duration'] * $max_hours), 
							//'max_booking_hours'	=> "{$max_hours}",
							'prices'		 => $pr['wed']
						   );

					$court_prices['thu'] = array(
							'actual_timings' => $court_timings['thu'], 
							'break'			 => $break_times['thu'], 
							'step'			 => $get_court_info['slot_duration'], 
							'min_booking_hours' => ($get_court_info['slot_duration'] * $get_court_info['min_book_slots']), 
							'max_booking_hours' => ($get_court_info['slot_duration'] * $max_hours), 
							//'max_booking_hours'	=> "{$max_hours}",
							'prices'		 => $pr['thu']
						   );

					$court_prices['fri'] = array(
							'actual_timings' => $court_timings['fri'], 
							'break'			 => $break_times['fri'], 
							'step'			 => $get_court_info['slot_duration'], 
							'min_booking_hours' => ($get_court_info['slot_duration'] * $get_court_info['min_book_slots']), 
							'max_booking_hours' => ($get_court_info['slot_duration'] * $max_hours), 
							//'max_booking_hours'	=> "{$max_hours}",
							'prices'		 => $pr['fri']
						   );

					$court_prices['sat'] = array(
							'actual_timings' => $court_timings['sat'], 
							'break'			 => $break_times['sat'], 
							'step'			 => $get_court_info['slot_duration'], 
							'min_booking_hours' => ($get_court_info['slot_duration'] * $get_court_info['min_book_slots']), 
							'max_booking_hours' => ($get_court_info['slot_duration'] * $max_hours), 
							//'max_booking_hours'	=> "{$max_hours}",
							'prices'		 => $pr['sat']
						   );

				$data['court_prices'] = $court_prices;
				/* ********* prices *************/ 
				$data['paymethods'] = array(array('pay_method'   => $get_court_info['gateway_name'], 'reference_id' => $get_court_info['payment_ref_id']));

				$data['discounts'] = array('is_club_member' => $is_member, 'member_discount_percentage' => $disc);

				$tot_book_arr = array();
				$slot_dur = $get_court_info['slot_duration'];
				//echo "Test"; exit;
				//echo $slot_dur; exit;
				if($is_sharable){
					foreach($get_court_bookings as $booking) {
						//$frTime  = strtotime($booking->from_time);
						//$toTime = strtotime($booking->to_time);
							
							$k	= date("Y-m-d H:i", strtotime($booking->res_date.' '.$booking->from_time));
				//$c = 1;
						for( ;strtotime($k) < strtotime($booking->res_date.' '.$booking->to_time);){

							//$k2  = date("Y-m-d H:i", strtotime('+30 minutes', strtotime($k)));
							$k2  = date("Y-m-d H:i", strtotime('+'.($slot_dur * 60).' minutes', strtotime($k)));

							if($tot_book_arr["'".$k."-".$k2."'"])
								$tot_book_arr["'".$k."-".$k2."'"] += $booking->num_players;
							else
								$tot_book_arr["'".$k."-".$k2."'"] = $booking->num_players;
							/*var_dump($k);
							var_dump($k2);
							echo $c."<br>";
							$c++;*/
							$k = $k2;
						}

					}
				}
//echo "<pre> test "; print_r($tot_book_arr); echo "------<br>";
$temp_arr = array();
				foreach($get_court_bookings as $booking) {
					//$from  = date('D Y-m-d H:i:s', strtotime($booking->res_date.' '.$booking->from_time));
					//$to	     = date('D Y-m-d H:i:s', strtotime($booking->res_date.' '.$booking->to_time));

						$frTime  = strtotime($booking->from_time);
						$toTime = strtotime($booking->to_time);
						
						$actual_from	= date("Y-m-d H:i", strtotime($booking->res_date.' '.$booking->from_time));
						$actual_to		= date("Y-m-d H:i", strtotime($booking->res_date.' '.$booking->to_time));

						$k	= date("Y-m-d H:i", strtotime($booking->res_date.' '.$booking->from_time));
				
						for( ;strtotime($k) < strtotime($booking->res_date.' '.$booking->to_time);){

							//$k2  = date("Y-m-d H:i", strtotime('+30 minutes', strtotime($k)));
							$k2  = date("Y-m-d H:i", strtotime('+'.($slot_dur * 60).' minutes', strtotime($k)));

							/*if(date("H:i", strtotime('+30 minutes', $booking->from_time)) >= date("H:i", strtotime($booking->to_time))){
								echo "test";
							}*/
							//echo $k2." - ".date("H:i", strtotime($booking->to_time)); exit;
							$from  = date('Y-m-d H:i:s', strtotime($k));
							$to	     = date('Y-m-d H:i:s', strtotime($k2));
							$reserved_by  = $booking->reserved_by;
							$numP				= $booking->num_players;
							$tot_bookings  = $booking->num_players;

							if(!empty($tot_book_arr)){
							$tot_bookings  = $tot_book_arr["'".$k."-".$k2."'"];
							}

							if(!in_array($from."-".$to, $temp_arr)){
								if($booking->players)
								$pList = json_decode($booking->players, true);
								else{
									$get_user = $this->general->get_user($booking->reserved_by);
									//echo "<pre>"; print_r($get_user); exit;
									if($get_user)
										$pList = array($get_user['Firstname']." ".$get_user['Lastname']);
								}

								$temp_arr[] = $from."-".$to;
								$temp_plist[$from."-".$to] = $pList;
								$bookings[] = array('from' => $from, 'to' => $to, 'reserved_by' => $reserved_by, 'numPlayers' => $numP, 'playersList' => $pList, 'total_bookings' => $tot_bookings, 'actual_booking_from' => $actual_from, 'actual_booking_to' => $actual_to);
							}
							/*else{
								$pList  = json_decode($booking->players, true);
								$temp = $temp_plist[$from."-".$to]; 
								$pList  = array_merge($pList, $temp);
							}*/

							$k = $k2;
						}

				}

				$data['current_bookings'] = $bookings;

				$data2[] = $data;
			}
			
			$this->response($data2, 200);
		}
		else {
			$res = array('Error: '."Location ID is Missing");
			$this->response($res, 400);
		}

	}

	public function courtsOldCode_get(){

		$loc_id  = $this->input->get('loc_id');
		$user_id = $this->input->get('user_id');
	
		if($loc_id) {
			$is_club_member = $this->mclub->is_club_member($user_id, $loc_id);
			$get_discount   = $this->mclub->get_member_discount($loc_id);

				$disc	   = 0;
				$is_member = 0;

			if($get_discount['member_discount']){
				$disc = $get_discount['member_discount'];
				if($is_club_member){
				$is_member = 1;
				}
			}
			$get_loc_courts = $this->mclub->get_loc_courts($loc_id);
			foreach($get_loc_courts as $court) {
				$data	  = array();
				$bookings = array();

				$get_court_info		= $this->mclub->get_court_info($court->court_id);				
				$get_court_bookings = $this->mclub->get_court_bookings($court->court_id);

				foreach($get_court_bookings as $booking) {
					$from  = date('D Y-m-d H:i:s', strtotime($booking->res_date.' '.$booking->from_time));
					$to	   = date('D Y-m-d H:i:s', strtotime($booking->res_date.' '.$booking->to_time));
					$numP  = $booking->num_players;
					$pList = json_decode($booking->players, true);
					$bookings[] = array('from' => $from, 'to' => $to, 'numPlayers' => $numP, 'playersList' => $pList);
				}

				$data = json_decode($get_court_info['court_info_json'], true);
				$data['paymethods'] = array(array('pay_method'   => $get_court_info['gateway_name'], 
											'reference_id' => $get_court_info['payment_ref_id']));

				$data['discounts'] = array('is_club_member' => $is_member, 'member_discount_percentage' => $disc);
				$data['current_bookings'] = $bookings;

				$data2[] = $data;
			}
			
			$this->response($data2, 200);
		}
		else {
			$res = array('Error: '."Location ID is Missing");
			$this->response($res, 400);
		}

	}

	public function reserve_court_post() {

		$post_data = json_decode(trim(file_get_contents('php://input')), true);
		/*echo "<pre>";
		print_r($post_data);
		exit;*/

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
		$data['from_time']	 = $res_from;
		$data['to_time']		 = $res_to;
		$data['created_on']	 = date('Y-m-d H:i:s');
		$data['fee_paid']		 = $post_data['booking_amt'];
		$data['trans_id']		 = $post_data['transaction_id'];
		$data['match_format'] = $post_data['gameFormat'];
		$data['num_players']	 = $post_data['numPlayers'];
		$data['players']		 = json_encode($post_data['playersList']);
		//$data['players']		 = $post_data['playersList'];
		$data['paid_date']		 = date('Y-m-d H:i:s');
		$data['res_status']		 = "Active";

		$is_sharable = $this->mclub->check_sharable($data['court_id']);

		if($is_sharable['is_shared_resource'] > 0){
			$res_court = $this->mclub->reserve_court($data);
		}
		else{
			$res_court = $this->mclub->check_reserve_court($data);
		}

		/*var_dump($res_court);
		exit;*/
		if($res_court and $res_court > 0){
		 $res = array('Success: '."Court Reservation Done");
		 $res_code = 200;
		}
		else if($res_court < 0){
		 $res = array('Error: '."Court is already reserved!");
		 $res_code = 400;
		}
		else{
		 $res = array('Error: '."Undone, Try again!");
		 $res_code = 400;
		}
		$this->response($res, $res_code);
	}


	public function reserveTemp2_court_post() {

		$post_data = json_decode(trim(file_get_contents('php://input')), true);

			if(!$post_data){
			$this->response(array('Error: ' . "Empty!")); 
			}
$bookings = $post_data['bookings'];

		foreach($bookings as $res){
			$dt_from = explode(" ", $res['res_from']);
			$dt_to	   = explode(" ", $res['res_to']);
			$from_date = $dt_from[0];
			$from_time = $dt_from[1];

			$to_date = $dt_to[0];
			$to_time = $dt_to[1];
			echo "t ".$from_date.' - '.$from_time.'; '.$to_date.' - '.$to_time."<br>";
			//exit;
		}
			//echo ""; print_r($post_data); exit;
	}

	public function reserveTemp_court_post() {

		$post_data = json_decode(trim(file_get_contents('php://input')), true);

			if(!$post_data){
			$this->response(array('Error: ' . "Empty!")); 
			}

		$data['court_id']		 = $post_data['court_id'];

		$data['loc_id'] 			 = $post_data['loc_id'];
		$data['reserved_by']	 = $post_data['user_id'];
		$data['bookings']		 = $post_data['bookings'];
		$data['booking_amt']	 = $post_data['booking_amt'];
		$data['trans_id']		 = $post_data['transaction_id'];
		$data['match_format']	= $post_data['gameFormat'];
		$data['num_players']		= $post_data['numPlayers'];
		$data['players']				= json_encode($post_data['playersList']);
//echo "<pre>"; print_r($data); exit;
		$is_sharable = $this->mclub->check_sharable($data['court_id']);
//echo "<pre>"; print_r($is_sharable); exit;
		if($is_sharable['is_shared_resource'] > 0) {
			$res_court = $this->mclub->reserve_courtTemp($data);
		}
		else {
			$res_court = $this->mclub->check_reserve_courtTemp($data);
		}

		//var_dump($res_court);		exit;
		if($res_court and $res_court > 0) {
		 $res = array('Success: '."Court Reservation Done");
		 $res_code = 200;
		}
		else if($res_court < 0) {
		 $res = array('Error: '."Court is already reserved!");
		 $res_code = 400;
		}
		else {
		 $res = array('Error: '."Undone, Try again!");
		 $res_code = 400;
		}

		$this->response($res, $res_code);
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

			if($court_det['gateway_name'] == 'paytm'){
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

		//print_r($checkSum); exit;
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
			$this->response($res, 400);
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
					$bookings[] = array(
						'booking_id' => $booking->res_id, 
						'court_id'   => $booking->court_id, 
						'loc_id'	 => $booking->loc_id, 
						'court_name' => $booking->court_name, 
						'location'	 => $booking->location, 
						'address'	 => $booking->address, 
						'city'		 => $booking->city, 
						'state'		 => $booking->state, 
						'country'	 => $booking->country, 
						'from'		 => $from, 
						'to'		 => $to
						);
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
	
		public function paypalSuccess_post(){

			//$data['item_number']	= $this->input->get('item_number');

			if($this->input->get('tx')){
			$txn_id	= $this->input->get('tx');
			}
			else{
			$txn_id = $this->input->get('token');
			}

			
			if($this->input->get('st') == 'Completed') {
				$txn  = $txn_id;
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

	public function paypalCancel_post(){
		$html = "Last Transaction is cancelled";
		echo $html;
	}
	
		public function paypalChecksum_get(){

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
				$get_det = $this->muser->get_paypal($court_det['payment_ref_id']);
			}
			else{
				$get_det = $this->muser->get_paypal('5');
			}
	
		$this->load->library('paypal_lib');
		
		$paypalID = $get_det['paypal_merch_id'];
		//echo $paypalID; exit;
		$logo = base_url().'images/logo.png';
		$returnURL = 'https://a2msports.com/rest_services/clubs/paypalSuccess';
		$cancelURL = 'https://a2msports.com/rest_services/clubs/paypalCancel';

		$this->paypal_lib->add_field('business', $paypalID);
		$this->paypal_lib->add_field('return', $returnURL);
		$this->paypal_lib->add_field('cancel_return', $cancelURL);
		//$this->paypal_lib->add_field('notify_url', $notifyURL);
		$this->paypal_lib->add_field('court_id', $court_id);
		//$this->paypal_lib->add_field('player', $this->logged_user);
		$this->paypal_lib->add_field('on0', $user_id);
		$this->paypal_lib->add_field('item_number',  $court_id);
		$this->paypal_lib->add_field('item_name',  $court_det['court_name']);
		$this->paypal_lib->add_field('amount', $txn_amount);        
		//$this->paypal_lib->image($logo);
		
		$htmlForm = $this->paypal_lib->paypal_api_form();


		/*$data['MID']		= PAYTM_MERCHANT_MID;
		$data['ORDER_ID']	= $order_id;
		$data['CUST_ID']	= $user_id;
		$data['TXN_AMOUNT'] = $txn_amount;
		$data['CHECKSUMHASH'] = $checkSum;*/
		$data['htmlForm'] = $htmlForm;

		$res = array($data);	
		//$this->response($res);
		echo $htmlForm;
		}
		else{
			$res = array('Error: '."Invalid Court / Court may be inactive!");
			$this->response($res, 400);
		}

	}
	
	public function testpaypalChecksum_get(){

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

		$get_det = $this->muser->get_paypal('8');
			
	
		$this->load->library('paypal_lib');
		
		$paypalID = $get_det['paypal_merch_id'];
		//echo $paypalID; exit;
		$logo = base_url().'images/logo.png';
		$returnURL = 'https://a2msports.com/rest_services/clubs/paypalSuccess';
		$cancelURL = 'https://a2msports.com/rest_services/clubs/paypalCancel';

		$this->paypal_lib->add_field('business', $paypalID);
		$this->paypal_lib->add_field('return', $returnURL);
		$this->paypal_lib->add_field('cancel_return', $cancelURL);
		//$this->paypal_lib->add_field('notify_url', $notifyURL);
		$this->paypal_lib->add_field('court_id', $court_id);
		//$this->paypal_lib->add_field('player', $this->logged_user);
		$this->paypal_lib->add_field('on0', $user_id);
		$this->paypal_lib->add_field('item_number',  $court_id);
		$this->paypal_lib->add_field('item_name',  $court_det['court_name']);
		$this->paypal_lib->add_field('amount', $txn_amount);        
		//$this->paypal_lib->image($logo);
		
		$htmlForm = $this->paypal_lib->sandbox_paypal_api_form();


		/*$data['MID']		= PAYTM_MERCHANT_MID;
		$data['ORDER_ID']	= $order_id;
		$data['CUST_ID']	= $user_id;
		$data['TXN_AMOUNT'] = $txn_amount;
		$data['CHECKSUMHASH'] = $checkSum;*/
		$data['htmlForm'] = $htmlForm;

		$res = array($data);	
		//$this->response($res);
		echo $htmlForm;
		}
		else{
			$res = array('Error: '."Invalid Court / Court may be inactive!");
			$this->response($res, 400);
		}

	}

	public function broadcast_post() {
		$post_data = json_decode(trim(file_get_contents('php://input')), true);

		$from_user	= trim($post_data['sender_id'], '"');
		$club_id		= trim($post_data['club_id'], '"');
		$message		= trim($post_data['message'], '"');
		//$player_ids	= trim($post_data['player_ids'], '"');
		$player_ids	= json_decode($post_data['player_ids'], true);

		if(count($player_ids) > 0){
			$get_club = $this->mclub->get_club($club_id);
			$get_from = $this->mclub->get_user_details($from_user);
			$expo_ids = array();

			foreach($player_ids as $to_user){
				$get_user_token = $this->mclub->get_userToken($to_user);

				if($get_user_token){
						foreach($get_user_token as $exp){
								$expo_ids[$exp->user_id][] = $exp->token;
						}
				}
			}

			$send_status = array();
			if(!empty($expo_ids)){
				$send_status = $this->send_notifs($expo_ids, $get_club['Aca_name'], $message);
			}

			if(!empty($send_status)){
					foreach($send_status as $user => $exp){
						foreach($exp as $token => $status){
								$send_stat = 0;
							if($status == 'ok')
								$send_stat = 1;

				$json_mes = '{"to": "'.$user.'", "title": "'.$get_club['Aca_name'].'", "body": "'.$get_from['Firstname'].' '.$get_from['Lastname'].": ".$message.'", "data": {"message_content": "'.$message.'", "type": "CLUB_NOTIFICATION", "sender_user_id": '.$from_user.'}}';

							$data = array(
								'Sender'		 => $from_user,
								'Recipient'  => $user,
								'Club_ID'	=> $club_id,
								'Message'	=> $message,
								'Json_Message' => $json_mes,
								'Send_Status'	=> $send_stat,
								'Read_Status'	=> 0,
								'Sent_On'			=> date('Y-m-d H:i'),
								'Expo_Token'		=> $token,
								'Notif_Type'		=> 'Notification',
								'MType'		=> 'Club',
								'Ref_ID'		=> $club_id,
								'Sent_Players' => json_encode($player_ids)
								);

							$this->mclub->insert_notif($data);
						}
					}
				}

				$res2 = array('Success: ' . "Message is sent to the players", 200);
		}
		else{
				$res2 = array('Error: ' . "Recipeints shouldn't empty!", 400);
		}

		$this->response($res2);
	}

		public function send_notifs($ids, $title, $message){
			$url = 'https://exp.host/--/api/v2/push/send';
			
			$send_result = array();
			if(!empty($ids)){
				foreach($ids as $user => $list){
				foreach($list as $to){
					$payload = array(
										'to'		  => $to,
										'sound' => 'default',
										'title'=> $title,
										/*'subtitle'=> 'Subtitle Club Notification',*/
										'body'	  => $message,
										);

					$curl = curl_init();

					curl_setopt_array($curl, array(
									CURLOPT_URL => $url,
									CURLOPT_RETURNTRANSFER => true,
									CURLOPT_ENCODING => "",
									CURLOPT_MAXREDIRS => 10,
									CURLOPT_TIMEOUT => 30,
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
					$response = curl_exec($curl);
					$err = curl_error($curl);

					curl_close($curl);
					$res = json_decode($response, true);
						if($response){
							$send_result[$user][$to] = $res['data']['status'];
						}
					}
					}
			}
		
			return $send_result;
		}
		
		public function reserve_hook_post(){
			//$paypalInfo    = $this->input->post();
			$paypalInfo    = json_decode(file_get_contents('php://input'), true);
	 	$dev_email	 = "pradeepkumar.namala@gmail.com";
		$dev_subject  = "A2M Paypal Vals - HOOKS";
		$data		 = array(
									'firstname'	     => "Developer",
									'paypal_vals'   => $paypalInfo,
									'page'	         => 'A2M Paypal values - Developer');

		$this->email_to_player($dev_email, $dev_subject, $data);
		}

	public function email_to_player($to_email, $subject, $data){	
		$this->load->library('email');
		$this->email->set_newline("\r\n"); 
		$this->email->from(FROM_EMAIL, 'A2MSports');
		$this->email->to($to_email);
		$this->email->subject($subject);

		$body = $this->load->view('view_email_template.php', $data, TRUE);

		$this->email->message($body);   
		$this->email->send();
	}

	public function courts_get(){
// REVISED BREAK TIMES ON 08-OCT-2021
		$loc_id    = $this->input->get('loc_id');
		$user_id = $this->input->get('user_id');

		$club_id = '';
		if($this->input->get('club_id'))
		$club_id = $this->input->get('club_id');
	
		if($loc_id) {
			$is_club_member = $this->mclub->is_club_member($user_id, $loc_id);
			$get_discount		= $this->mclub->get_member_discount($loc_id);
			
			$is_club_admin = false;
			$is_coach		 = false;

			if($club_id){
				$get_club				= $this->mclub->get_club($club_id);
				if($get_club['Aca_User_id'] == $user_id)
				$is_club_admin = true;
			}

			if($user_id and $club_id)
			$is_coach = $this->mclub->is_coach($club_id, $user_id);

				$disc			= 0;
				$is_member = 0;

			if($get_discount['member_discount']){
				$disc = $get_discount['member_discount'];
				if($is_club_member){
				$is_member = 1;
				}
			}

	
			$is_booking_allowed = true;
			if(!$get_discount['access_to_nonmem'] and !$is_coach and !$is_club_admin){
				if($is_club_member)
					$is_booking_allowed = true;
				else
					$is_booking_allowed = false;
			}

			$get_loc_courts = $this->mclub->get_loc_courts($loc_id);
			foreach($get_loc_courts as $court) {
				$data			= array();
				$bookings  = array();

				$get_court_info			= $this->mclub->get_court_info($court->court_id);				
				$get_court_prices		= $this->mclub->get_court_prices($court->court_id);				
				$get_court_bookings	= $this->mclub->get_court_bookings($court->court_id);
				
				$allow_same_day_booking = false;
				if($get_court_info['allow_sameday_booking']){
				$allow_same_day_booking = true;
				}

				$allow_sameday_multi_booking = false;
				if($get_court_info['allow_sameday_multi_booking']){
				$allow_sameday_multi_booking = true;
				}

				//$data = json_decode($get_court_info['court_info_json'], true);
					$is_sharable = 0;

				$mx_adv_days = $get_court_info['max_adv_booking_days'];

				if($is_club_admin or $is_coach){
				$mx_adv_days = 182;
				$allow_sameday_multi_booking = true;
				$allow_same_day_booking		  = true;
				}

				if($get_court_info['is_shared_resource'])
					$is_sharable = 1;
					$data['court_info'] = array(
						'court_id'			=> $get_court_info['court_id'], 
						'court_name'		=> $get_court_info['court_name'], 
						'max_players'	=> (int)$get_court_info['max_players'], 
						'max_adv_booking_days'	 => $mx_adv_days, 
						'allow_sameday_multi_booking' => $allow_sameday_multi_booking, 
						'allow_sameday_booking'  => $allow_same_day_booking, 
						'is_booking_allowed'  => $is_booking_allowed, 
						'is_shareable'	=> $is_sharable);
					$data['court_timings'] = array('open_days' => array('sun','mon','tue','wed','thu','fri','sat'), 'close_days' => null);

				$max_hours	= $get_court_info['max_hours'];   //consider this as maximum slots
				if($is_club_admin or $is_coach){
				$max_hours	= 10;
				}
				//echo "<pre>"; print_r($get_court_prices); exit;
				/* ********* prices *************/ 
$stTime = array(); $edTime = array(); $sunPrice = array(); $monPrice = array(); $tuePrice = array(); $wedPrice = array(); $thuPrice = array(); $friPrice = array(); $satPrice = array(); $sunAddnPrice = array(); $monAddnPrice = array(); $tueAddnPrice = array(); $wedAddnPrice = array(); $thuAddnPrice = array(); $friAddnPrice = array(); $satAddnPrice = array(); 
				foreach($get_court_prices as $price_info){
					$stTime[]  = $price_info->Start_Time;
					$edTime[] = $price_info->End_Time;
					$sunPrice[] = $price_info->Sun_Price;
					$monPrice[] = $price_info->Mon_Price;
					$tuePrice[] = $price_info->Tue_Price;
					$wedPrice[] = $price_info->Wed_Price;
					$thuPrice[] = $price_info->Thu_Price;
					$friPrice[] = $price_info->Fri_Price;
					$satPrice[] = $price_info->Sat_Price;
					$sunAddnPrice[] = $price_info->Sun_Addn_Price;
					$monAddnPrice[] = $price_info->Mon_Addn_Price;
					$tueAddnPrice[] = $price_info->Tue_Addn_Price;
					$wedAddnPrice[] = $price_info->Wed_Addn_Price;
					$thuAddnPrice[] = $price_info->Thu_Addn_Price;
					$friAddnPrice[] = $price_info->Fri_Addn_Price;
					$satAddnPrice[] = $price_info->Sat_Addn_Price;
				}

				$court_min_time = date("H:i", strtotime(min($stTime)));
				$court_max_time = date("H:i", strtotime(max($edTime)));

				$court_timings = array('start_time' => "{$court_min_time}", 'end_time' => "{$court_max_time}");
				//if($loc_id == 30)
					//echo "<pre>"; print_r($sunPrice); exit;
				foreach($stTime as $j => $st) {
					$st = date("H:i", strtotime($st));
					$ed = date("H:i", strtotime($edTime[$j]));
					for($k = $st; $k < $ed; ) {
						$k  = date("H:i", strtotime($k));
						$kk = date("H:i", strtotime($k."+1 hours"));
						if(!in_array($k.'-'.$kk, $court_valid_times)){
						$court_valid_times[] = $k.'-'.$kk;
						}
						$k = $kk;
					}
				}
				//echo "<pre>";	print_r($court_valid_times);echo "<br>----vt----";

					$stdt = array();
					$pr = array();
				foreach($stTime as $j => $val){
				
					if($sunPrice[$j] != 'n/a' and $sunPrice[$j] != ""){
					$pr['sun'][] = array('price' => number_format($sunPrice[$j], 2),
						'start_time' => date('H:i', strtotime($stTime[$j])),
						'end_time'   => date('H:i', strtotime($edTime[$j])),
						'additional_price_per_player'   => number_format($sunAddnPrice[$j], 2)
						);
					}
					else{
						//$break_times[0][] = array(date('H:i', strtotime($stTime[$j])), date('H:i', strtotime($edTime[$j])));
						$break_times[0][] = array('start_time' => date('H:i', strtotime($stTime[$j])), 'end_time' => date('H:i', strtotime($edTime[$j])));
					}

					if($monPrice[$j] != 'n/a' and $monPrice[$j] != ""){
					$pr['mon'][] = array('price' => number_format($monPrice[$j], 2),
						'start_time' => date('H:i', strtotime($stTime[$j])),
						'end_time'   => date('H:i', strtotime($edTime[$j])),
						'additional_price_per_player'   => number_format($monAddnPrice[$j], 2)
						);
					}
					else{
						//$break_times[1][] = array(date('H:i', strtotime($stTime[$j])), date('H:i', strtotime($edTime[$j])));
						$break_times[1][] = array('start_time' => date('H:i', strtotime($stTime[$j])), 'end_time' => date('H:i', strtotime($edTime[$j])));
					}


					if($tuePrice[$j] != 'n/a' and $tuePrice[$j] != ""){
					$pr['tue'][] = array('price' => number_format($tuePrice[$j], 2),
						'start_time' => date('H:i', strtotime($stTime[$j])),
						'end_time'   => date('H:i', strtotime($edTime[$j])),
						'additional_price_per_player'   => number_format($tueAddnPrice[$j], 2)
						);
					}
					else{
						//$break_times[2][] = array(date('H:i', strtotime($stTime[$j])), date('H:i', strtotime($edTime[$j])));
						$break_times[2][] = array('start_time' => date('H:i', strtotime($stTime[$j])), 'end_time' => date('H:i', strtotime($edTime[$j])));
					}

					if($wedPrice[$j] != 'n/a' and $wedPrice[$j] != ""){
					$pr['wed'][] = array('price' => number_format($wedPrice[$j], 2),
						'start_time' => date('H:i', strtotime($stTime[$j])),
						'end_time'   => date('H:i', strtotime($edTime[$j])),
						'additional_price_per_player'   => number_format($wedAddnPrice[$j], 2)
						);
					}
					else{
						//$break_times[3][] = array(date('H:i', strtotime($stTime[$j])), date('H:i', strtotime($edTime[$j])));
						$break_times[3][] = array('start_time' => date('H:i', strtotime($stTime[$j])), 'end_time' => date('H:i', strtotime($edTime[$j])));
					}

					if($thuPrice[$j] != 'n/a' and $thuPrice[$j] != ""){
					$pr['thu'][] = array('price' => number_format($thuPrice[$j], 2),
						'start_time' => date('H:i', strtotime($stTime[$j])),
						'end_time'   => date('H:i', strtotime($edTime[$j])),
						'additional_price_per_player'   => number_format($thuAddnPrice[$j], 2)
						);
					}
					else{
						//$break_times[4][] = array(date('H:i', strtotime($stTime[$j])), date('H:i', strtotime($edTime[$j])));
						$break_times[4][] = array('start_time' => date('H:i', strtotime($stTime[$j])), 'end_time' => date('H:i', strtotime($edTime[$j])));
					}

					if($friPrice[$j] != 'n/a' and $friPrice[$j] != ""){
					$pr['fri'][] = array('price' => number_format($friPrice[$j], 2),
						'start_time' => date('H:i', strtotime($stTime[$j])),
						'end_time'   => date('H:i', strtotime($edTime[$j])),
						'additional_price_per_player'   => number_format($friAddnPrice[$j], 2)
						);
					}
					else{
						//$break_times[5][] = array(date('H:i', strtotime($stTime[$j])), date('H:i', strtotime($edTime[$j])));
						$break_times[5][] = array('start_time' => date('H:i', strtotime($stTime[$j])), 'end_time' => date('H:i', strtotime($edTime[$j])));
					}

					if($satPrice[$j] != 'n/a' and $satPrice[$j] != ""){
					$pr['sat'][] = array('price' => number_format($satPrice[$j], 2),
						'start_time' => date('H:i', strtotime($stTime[$j])),
						'end_time'   => date('H:i', strtotime($edTime[$j])),
						'additional_price_per_player'   => number_format($satAddnPrice[$j], 2)
						);
					}
					else{
						//break_times[6][] = array(date('H:i', strtotime($stTime[$j])), date('H:i', strtotime($edTime[$j])));
						$break_times[6][] = array('start_time' => date('H:i', strtotime($stTime[$j])), 'end_time' => date('H:i', strtotime($edTime[$j])));
					}

					//$ins_court_price = $this->db->insert('Academy_Courts_Price', $data);
				}

				/*for($m = $court_min_time; $m < $court_max_time; ) {
					$mmm_arr	= '';
					$m				= date("H:i", strtotime($m));
					$mm				= date("H:i", strtotime($m."+1 hours"));
					$mmm			= $m.'-'.$mm;
					$mmm_arr	= array('start_time' => $m, 'end_time' => $mm);
					$hour_arr[]	= $mmm;
						
					$sun[] = 
					if(!in_array($mmm, $court_valid_times)){
						//$break_times[$i][] = $mmm_arr;
						$break_times[0][] = $mmm_arr;
						$break_times[1][] = $mmm_arr;
						$break_times[2][] = $mmm_arr;
						$break_times[3][] = $mmm_arr;
						$break_times[4][] = $mmm_arr;
						$break_times[5][] = $mmm_arr;
						$break_times[6][] = $mmm_arr;
					}
					$m = $mm;
				}*/
	//$break_times[$day] = NULL;

foreach($court_valid_times as $tm){
	$x		= explode("-", $tm);
	$vt1 = strtotime($x[0]);
	$vt2 = strtotime($x[1]);

	foreach($pr as $day => $vt){
		foreach($vt as $i => $values){
			$st  = strtotime($values['start_time']);
			$ed = strtotime($values['end_time']);
			//if($day == 'sun')
				//echo $vt1." - ".$vt2." - ".$st." - ".$ed."<br>";
			if($st > $vt1 or $ed < $vt2){
				$break_times[$day][] = array('start_time' => $x[0], 'end_time' => $x[1]);
			}

		}
	}

}
//echo "<pre>"; 
//print_r($pr); 
//echo "--------------------------";
//print_r($break_times); 
//exit;

					$court_prices['sun'] = array(
							'actual_timings' => $court_timings, 
							'break'			 => $break_times['sun'], 
							'step'			 => $get_court_info['slot_duration'], 
							'min_booking_hours' => ($get_court_info['slot_duration'] * $get_court_info['min_book_slots']), 
							'max_booking_hours' => ($get_court_info['slot_duration'] * $max_hours), 
							//'max_booking_hours'	=> "{$max_hours}",
							'prices'		 => $pr['sun']
						   );

					$court_prices['mon'] = array(
							'actual_timings' => $court_timings, 
							'break'			 => $break_times['mon'], 
							'step'			 => $get_court_info['slot_duration'], 
							'min_booking_hours' => ($get_court_info['slot_duration'] * $get_court_info['min_book_slots']), 
							'max_booking_hours' => ($get_court_info['slot_duration'] * $max_hours), 
							//'max_booking_hours'	=> "{$max_hours}",
							'prices'		 => $pr['mon']
						   );

					$court_prices['tue'] = array(
							'actual_timings' => $court_timings, 
							'break'			 => $break_times['tue'], 
							'step'			 => $get_court_info['slot_duration'],  
							'min_booking_hours' => ($get_court_info['slot_duration'] * $get_court_info['min_book_slots']), 
							'max_booking_hours' => ($get_court_info['slot_duration'] * $max_hours), 
							//'max_booking_hours'	=> "{$max_hours}",
							'prices'		 => $pr['tue']
						   );

					$court_prices['wed'] = array(
							'actual_timings' => $court_timings, 
							'break'			 => $break_times['wed'], 
							'step'			 => $get_court_info['slot_duration'], 
							'min_booking_hours' => ($get_court_info['slot_duration'] * $get_court_info['min_book_slots']), 
							'max_booking_hours' => ($get_court_info['slot_duration'] * $max_hours), 
							//'max_booking_hours'	=> "{$max_hours}",
							'prices'		 => $pr['wed']
						   );

					$court_prices['thu'] = array(
							'actual_timings' => $court_timings, 
							'break'			 => $break_times['thu'], 
							'step'			 => $get_court_info['slot_duration'], 
							'min_booking_hours'  => ($get_court_info['slot_duration'] * $get_court_info['min_book_slots']), 
							'max_booking_hours' => ($get_court_info['slot_duration'] * $max_hours), 
							//'max_booking_hours'	=> "{$max_hours}",
							'prices'		 => $pr['thu']
						   );

					$court_prices['fri'] = array(
							'actual_timings' => $court_timings, 
							'break'			 => $break_times['fri'], 
							'step'			 => $get_court_info['slot_duration'], 
							'min_booking_hours'  => ($get_court_info['slot_duration'] * $get_court_info['min_book_slots']), 
							'max_booking_hours' => ($get_court_info['slot_duration'] * $max_hours), 
							//'max_booking_hours'	=> "{$max_hours}",
							'prices'		 => $pr['fri']
						   );

					$court_prices['sat'] = array(
							'actual_timings' => $court_timings, 
							'break'			 => $break_times['sat'], 
							'step'			 => $get_court_info['slot_duration'], 
							'min_booking_hours'  => ($get_court_info['slot_duration'] * $get_court_info['min_book_slots']), 
							'max_booking_hours' => ($get_court_info['slot_duration'] * $max_hours), 
							//'max_booking_hours'	=> "{$max_hours}",
							'prices'		 => $pr['sat']
						   );

				$data['court_prices'] = $court_prices;
				/* ********* prices *************/ 
				$data['paymethods'] = array(array('pay_method'   => $get_court_info['gateway_name'], 'reference_id' => $get_court_info['payment_ref_id']));

				$data['discounts'] = array('is_club_member' => $is_member, 'member_discount_percentage' => $disc);

				$tot_book_arr = array();
				$slot_dur = $get_court_info['slot_duration'];
				//echo "Test"; exit;
				//echo $slot_dur; exit;
				if($is_sharable){
					foreach($get_court_bookings as $booking) {
						//$frTime  = strtotime($booking->from_time);
						//$toTime = strtotime($booking->to_time);
							
							$k	= date("Y-m-d H:i", strtotime($booking->res_date.' '.$booking->from_time));
				//$c = 1;
						for( ;strtotime($k) < strtotime($booking->res_date.' '.$booking->to_time);){

							//$k2  = date("Y-m-d H:i", strtotime('+30 minutes', strtotime($k)));
							$k2  = date("Y-m-d H:i", strtotime('+'.($slot_dur * 60).' minutes', strtotime($k)));

							if($tot_book_arr["'".$k."-".$k2."'"])
								$tot_book_arr["'".$k."-".$k2."'"] += $booking->num_players;
							else
								$tot_book_arr["'".$k."-".$k2."'"] = $booking->num_players;
							/*var_dump($k);
							var_dump($k2);
							echo $c."<br>";
							$c++;*/
							$k = $k2;
						}

					}
				}
//echo "<pre> test "; print_r($tot_book_arr); echo "------<br>";
$temp_arr = array();
				foreach($get_court_bookings as $booking) {
					//$from  = date('D Y-m-d H:i:s', strtotime($booking->res_date.' '.$booking->from_time));
					//$to	     = date('D Y-m-d H:i:s', strtotime($booking->res_date.' '.$booking->to_time));

						$frTime  = strtotime($booking->from_time);
						$toTime = strtotime($booking->to_time);
						
						$actual_from	= date("Y-m-d H:i", strtotime($booking->res_date.' '.$booking->from_time));
						$actual_to		= date("Y-m-d H:i", strtotime($booking->res_date.' '.$booking->to_time));

						$k	= date("Y-m-d H:i", strtotime($booking->res_date.' '.$booking->from_time));
				
						for( ;strtotime($k) < strtotime($booking->res_date.' '.$booking->to_time);){

							//$k2  = date("Y-m-d H:i", strtotime('+30 minutes', strtotime($k)));
							$k2  = date("Y-m-d H:i", strtotime('+'.($slot_dur * 60).' minutes', strtotime($k)));

							/*if(date("H:i", strtotime('+30 minutes', $booking->from_time)) >= date("H:i", strtotime($booking->to_time))){
								echo "test";
							}*/
							//echo $k2." - ".date("H:i", strtotime($booking->to_time)); exit;
							$from  = date('Y-m-d H:i:s', strtotime($k));
							$to	     = date('Y-m-d H:i:s', strtotime($k2));
							$reserved_by  = $booking->reserved_by;
							$numP				= $booking->num_players;
							$tot_bookings  = $booking->num_players;

							if(!empty($tot_book_arr)){
							$tot_bookings  = $tot_book_arr["'".$k."-".$k2."'"];
							}

							if(!in_array($from."-".$to, $temp_arr)){
								if($booking->players)
								$pList = json_decode($booking->players, true);
								else{
									$get_user = $this->general->get_user($booking->reserved_by);
									//echo "<pre>"; print_r($get_user); exit;
									if($get_user)
										$pList = array($get_user['Firstname']." ".$get_user['Lastname']);
								}

								$temp_arr[] = $from."-".$to;
								$temp_plist[$from."-".$to] = $pList;
								$bookings[] = array('from' => $from, 'to' => $to, 'reserved_by' => $reserved_by, 'numPlayers' => $numP, 'playersList' => $pList, 'total_bookings' => $tot_bookings, 'actual_booking_from' => $actual_from, 'actual_booking_to' => $actual_to);
							}
							/*else{
								$pList  = json_decode($booking->players, true);
								$temp = $temp_plist[$from."-".$to]; 
								$pList  = array_merge($pList, $temp);
							}*/

							$k = $k2;
						}

				}

				$data['current_bookings'] = $bookings;

				$data2[] = $data;
			}
			
			$this->response($data2, 200);
		}
		else {
			$res = array('Error: '."Location ID is Missing");
			$this->response($res, 400);
		}

	}

	public function coachTimings_get(){
		//error_reporting(-1);
		$coach_id = $this->input->get('coach_id');
		$is_discount_allowed = false;
		$is_club_member		  = false;
		$priv_member_disc	  = NULL;
		$grp_member_disc	  = NULL;

		$get_coach_user = $this->mclub->get_user_details($coach_id);

		if($get_coach_user['Coach_Priv_Members_Disc'] or $get_coach_user['Coach_Grp_Members_Disc']){
			if($this->input->get('club_id') and $this->input->get('user_id')){
				$club_id  = $this->input->get('club_id');
				$user_id = $this->input->get('user_id');
				
				$is_club_mem = $this->mclub->is_club_member2($club_id, $user_id );

				if($is_club_mem)
					$is_club_member = true;
	
			}

			$is_discount_allowed = true;

			if($get_coach_user['Coach_Priv_Members_Disc'])
			$priv_member_disc	  = $get_coach_user['Coach_Priv_Members_Disc'];

			if($get_coach_user['Coach_Grp_Members_Disc'])
			$grp_member_disc	  = $get_coach_user['Coach_Grp_Members_Disc'];
		}


		//echo $user_id; exit;
		if($coach_id) {
			//$is_club_member = $this->mclub->is_club_member($user_id, $loc_id);
			//$get_discount		= $this->mclub->get_member_discount($loc_id);
			
			$is_club_admin = false;
			$is_coach		 = false;

			/*if($club_id){
				$get_club				= $this->mclub->get_club($club_id);
				if($get_club['Aca_User_id'] == $user_id)
				$is_club_admin = true;
			}*/

			$is_coach = $this->mclub->is_coach(0, $coach_id);

	
			$is_booking_allowed = true;
			//$is_discount_allowed = true;


				$data		  = array();
				$bookings  = array();

				$get_court_prices		= $this->mclub->get_coach_prices($coach_id);				
				$get_court_bookings	= $this->mclub->get_coach_bookings($coach_id);
				
				$allow_same_day_booking = true;
				$allow_sameday_multi_booking = true;
				$is_sharable = 1;

					$data['coach_info'] = array(
						'coach_id'			=> $coach_id,
						'max_players'	=> 6, 
						'max_adv_booking_days'	 => 182, 
						'allow_sameday_multi_booking' => $allow_sameday_multi_booking, 
						'allow_sameday_booking'			=> $allow_same_day_booking, 
						'is_booking_allowed'					=> $is_booking_allowed, 
						'is_club_member'						=> $is_club_member, 
						'is_discount_allowed'				=> $is_discount_allowed, 
						'member_private_class_disc'	=> $priv_member_disc, 
						'member_group_class_disc'		=> $grp_member_disc
						);
					$data['court_timings'] = array('open_days' => array('sun','mon','tue','wed','thu','fri','sat'), 'close_days' => null);

				$max_hours	= 10;
				
				//echo "<pre>"; print_r($get_court_bookings); exit;
				/* ********* prices *************/ 
$stTime = array(); $edTime = array(); $sunPrice = array(); $monPrice = array(); $tuePrice = array(); $wedPrice = array(); $thuPrice = array(); $friPrice = array(); $satPrice = array(); $sunAddnPrice = array(); $monAddnPrice = array(); $tueAddnPrice = array(); $wedAddnPrice = array(); $thuAddnPrice = array(); $friAddnPrice = array(); $satAddnPrice = array();

				foreach($get_court_prices as $price_info){
					$stTime[]		= $price_info->Start_Time;
					$edTime[]		= $price_info->End_Time;
					$sunPrice[]	= $price_info->Sun_Price;
					$monPrice[] = $price_info->Mon_Price;
					$tuePrice[]	= $price_info->Tue_Price;
					$wedPrice[]	= $price_info->Wed_Price;
					$thuPrice[]	= $price_info->Thu_Price;
					$friPrice[]		= $price_info->Fri_Price;
					$satPrice[]	= $price_info->Sat_Price;
					$sunAddnPrice[]	= $price_info->Sun_Addn_Price;
					$monAddnPrice[]	= $price_info->Mon_Addn_Price;
					$tueAddnPrice[]	= $price_info->Tue_Addn_Price;
					$wedAddnPrice[]	= $price_info->Wed_Addn_Price;
					$thuAddnPrice[]	= $price_info->Thu_Addn_Price;
					$friAddnPrice[]		= $price_info->Fri_Addn_Price;
					$satAddnPrice[]	= $price_info->Sat_Addn_Price;
				}

				$court_min_time = date("H:i", strtotime(min($stTime)));
				$court_max_time = date("H:i", strtotime(max($edTime)));

				$court_timings = array('start_time' => "{$court_min_time}", 'end_time' => "{$court_max_time}");
 
				foreach($stTime as $j => $st) {
					$st = date("H:i", strtotime($st));
					$ed = date("H:i", strtotime($edTime[$j]));
					for($k = $st; $k < $ed; ) {
						$k  = date("H:i", strtotime($k));
						$kk = date("H:i", strtotime($k."+1 hours"));
						if(!in_array($k.'-'.$kk, $court_valid_times)) {
						$court_valid_times[] = $k.'-'.$kk;
						}
						$k = $kk;
					}
				}
				//echo "<pre>";	print_r($court_valid_times);echo "<br>----vt----";

					$stdt = array();
					$pr	 = array();
				foreach($stTime as $j => $val){
				
					if($sunPrice[$j] != 'n/a' and $sunPrice[$j] != ""){
					$pr['sun'][] = array('price' => number_format($sunPrice[$j], 2),
						'start_time' => date('H:i', strtotime($stTime[$j])),
						'end_time'   => date('H:i', strtotime($edTime[$j])),
						'additional_price_per_player'   => number_format($sunAddnPrice[$j], 2),
						'is_group_class'   => $price_info->Is_Group_Class
						);
					}
					else{
						//$break_times[0][] = array(date('H:i', strtotime($stTime[$j])), date('H:i', strtotime($edTime[$j])));
						$break_times[0][] = array('start_time' => date('H:i', strtotime($stTime[$j])), 'end_time' => date('H:i', strtotime($edTime[$j])));
					}

					if($monPrice[$j] != 'n/a' and $monPrice[$j] != ""){
					$pr['mon'][] = array('price' => number_format($monPrice[$j], 2),
						'start_time' => date('H:i', strtotime($stTime[$j])),
						'end_time'   => date('H:i', strtotime($edTime[$j])),
						'additional_price_per_player'   => number_format($monAddnPrice[$j], 2),
						'is_group_class'   => $price_info->Is_Group_Class
						);
					}
					else{
						//$break_times[1][] = array(date('H:i', strtotime($stTime[$j])), date('H:i', strtotime($edTime[$j])));
						$break_times[1][] = array('start_time' => date('H:i', strtotime($stTime[$j])), 'end_time' => date('H:i', strtotime($edTime[$j])));
					}

					if($tuePrice[$j] != 'n/a' and $tuePrice[$j] != ""){
					$pr['tue'][] = array('price' => number_format($tuePrice[$j], 2),
						'start_time' => date('H:i', strtotime($stTime[$j])),
						'end_time'   => date('H:i', strtotime($edTime[$j])),
						'additional_price_per_player'   => number_format($tueAddnPrice[$j], 2),
						'is_group_class'   => $price_info->Is_Group_Class
						);
					}
					else{
						//$break_times[2][] = array(date('H:i', strtotime($stTime[$j])), date('H:i', strtotime($edTime[$j])));
						$break_times[2][] = array('start_time' => date('H:i', strtotime($stTime[$j])), 'end_time' => date('H:i', strtotime($edTime[$j])));
					}

					if($wedPrice[$j] != 'n/a' and $wedPrice[$j] != ""){
					$pr['wed'][] = array('price' => number_format($wedPrice[$j], 2),
						'start_time' => date('H:i', strtotime($stTime[$j])),
						'end_time'   => date('H:i', strtotime($edTime[$j])),
						'additional_price_per_player'   => number_format($wedAddnPrice[$j], 2),
						'is_group_class'   => $price_info->Is_Group_Class
						);
					}
					else{
						//$break_times[3][] = array(date('H:i', strtotime($stTime[$j])), date('H:i', strtotime($edTime[$j])));
						$break_times[3][] = array('start_time' => date('H:i', strtotime($stTime[$j])), 'end_time' => date('H:i', strtotime($edTime[$j])));
					}

					if($thuPrice[$j] != 'n/a' and $thuPrice[$j] != ""){
					$pr['thu'][] = array('price' => number_format($thuPrice[$j], 2),
						'start_time' => date('H:i', strtotime($stTime[$j])),
						'end_time'   => date('H:i', strtotime($edTime[$j])),
						'additional_price_per_player'   => number_format($thuAddnPrice[$j], 2),
						'is_group_class'   => $price_info->Is_Group_Class
						);
					}
					else{
						//$break_times[4][] = array(date('H:i', strtotime($stTime[$j])), date('H:i', strtotime($edTime[$j])));
						$break_times[4][] = array('start_time' => date('H:i', strtotime($stTime[$j])), 'end_time' => date('H:i', strtotime($edTime[$j])));
					}

					if($friPrice[$j] != 'n/a' and $friPrice[$j] != ""){
					$pr['fri'][] = array('price' => number_format($friPrice[$j], 2),
						'start_time' => date('H:i', strtotime($stTime[$j])),
						'end_time'   => date('H:i', strtotime($edTime[$j])),
						'additional_price_per_player'   => number_format($friAddnPrice[$j], 2),
						'is_group_class'   => $price_info->Is_Group_Class
						);
					}
					else{
						//$break_times[5][] = array(date('H:i', strtotime($stTime[$j])), date('H:i', strtotime($edTime[$j])));
						$break_times[5][] = array('start_time' => date('H:i', strtotime($stTime[$j])), 'end_time' => date('H:i', strtotime($edTime[$j])));
					}

					if($satPrice[$j] != 'n/a' and $satPrice[$j] != ""){
					$pr['sat'][] = array('price' => number_format($satPrice[$j], 2),
						'start_time' => date('H:i', strtotime($stTime[$j])),
						'end_time'   => date('H:i', strtotime($edTime[$j])),
						'additional_price_per_player'   => number_format($satAddnPrice[$j], 2),
						'is_group_class'   => $price_info->Is_Group_Class
						);
					}
					else{
						//break_times[6][] = array(date('H:i', strtotime($stTime[$j])), date('H:i', strtotime($edTime[$j])));
						$break_times[6][] = array('start_time' => date('H:i', strtotime($stTime[$j])), 'end_time' => date('H:i', strtotime($edTime[$j])));
					}

				}

//exit;
foreach($court_valid_times as $tm){
	$x		= explode("-", $tm);
	$vt1 = strtotime($x[0]);
	$vt2 = strtotime($x[1]);
$no_break_times = array();
	foreach($pr as $day => $vt){
		foreach($vt as $i => $values){
			$st  = strtotime($values['start_time']);
			$ed = strtotime($values['end_time']);
			//if($day == 'sun')
				//echo $vt1." - ".$vt2." - ".$st." - ".$ed."<br>";
			if(($st > $vt1 or $ed < $vt2) and (!in_array($vt1, $no_break_times) and !in_array($vt2, $no_break_times))){
				//echo "<pre>";	print_r($no_break_times);
				//echo $day.": ".$values['start_time']." > ".$x[0]." - ".$values['end_time']." < ".$x[1]."<br>";
				//echo $day.": ".$st." > ".$vt1." - ".$ed." < ".$vt2."<br>";
				//exit;
				$break_times[$day][] = array('start_time' => $x[0], 'end_time' => $x[1]);
			}
			else{
				$no_break_times[] = $vt1;
				$no_break_times[] = $vt2;
			}
		}
	}

}
//echo "<pre>"; print_r($pr);
//echo "<pre>"; print_r($break_times); exit;
					$court_prices['sun'] = array(
							'actual_timings' => $court_timings, 
							'break'			 => $break_times['sun'], 
							'step'			 => 0.5, 
							//'min_booking_hours' => (0.5 * $get_court_info['min_book_slots']), 
							'min_booking_hours' => (0.5 * 1), 
							'max_booking_hours'	=> "{$max_hours}",
							'prices'		 => $pr['sun']
						   );

					$court_prices['mon'] = array(
							'actual_timings' => $court_timings, 
							'break'			 => $break_times['mon'], 
							'step'			 => 0.5, 
							'min_booking_hours' => (0.5 * 1), 
							'max_booking_hours'	=> "{$max_hours}",
							'prices'		 => $pr['mon']
						   );

					$court_prices['tue'] = array(
							'actual_timings' => $court_timings, 
							'break'			 => $break_times['tue'], 
							'step'			 => 0.5,  
							'min_booking_hours' => (0.5 * 1), 
							'max_booking_hours'	=> "{$max_hours}",
							'prices'		 => $pr['tue']
						   );

					$court_prices['wed'] = array(
							'actual_timings' => $court_timings, 
							'break'			 => $break_times['wed'], 
							'step'			 => 0.5, 
							'min_booking_hours' => (0.5 * 1), 
							'max_booking_hours'	=> "{$max_hours}",
							'prices'		 => $pr['wed']
						   );

					$court_prices['thu'] = array(
							'actual_timings' => $court_timings, 
							'break'			 => $break_times['thu'], 
							'step'			 => 0.5, 
							'min_booking_hours' => (0.5 * 1), 
							'max_booking_hours'	=> "{$max_hours}",
							'prices'		 => $pr['thu']
						   );

					$court_prices['fri'] = array(
							'actual_timings' => $court_timings, 
							'break'			 => $break_times['fri'], 
							'step'			 => 0.5, 
							'min_booking_hours' => (0.5 * 1), 
							'max_booking_hours'	=> "{$max_hours}",
							'prices'		 => $pr['fri']
						   );

					$court_prices['sat'] = array(
							'actual_timings' => $court_timings, 
							'break'			 => $break_times['sat'], 
							'step'			 => 0.5, 
							'min_booking_hours' => (0.5 * 1), 
							'max_booking_hours'	=> "{$max_hours}",
							'prices'		 => $pr['sat']
						   );

				$data['court_prices'] = $court_prices;
				/* ********* prices *************/ 
				$data['paymethods'] = array(array('pay_method'   => $get_court_info['gateway_name'], 'reference_id' => $get_court_info['payment_ref_id']));

				$data['discounts'] = array('is_club_member' => $is_member, 'member_discount_percentage' => $disc);

				$tot_book_arr = array();
				$slot_dur = 0.5;
				//$slot_dur = $get_court_info['slot_duration'];
				//echo "Test"; exit;
				//echo $slot_dur; exit;
				if($is_sharable){
					foreach($get_court_bookings as $booking) {
						//$frTime  = strtotime($booking->from_time);
						//$toTime = strtotime($booking->to_time);
							
							$k	= date("Y-m-d H:i", strtotime($booking->res_date.' '.$booking->from_time));
				//$c = 1;
						for( ;strtotime($k) < strtotime($booking->res_date.' '.$booking->to_time);){

							//$k2  = date("Y-m-d H:i", strtotime('+30 minutes', strtotime($k)));
							$k2  = date("Y-m-d H:i", strtotime('+'.($slot_dur * 60).' minutes', strtotime($k)));

							if($tot_book_arr["'".$k."-".$k2."'"])
								$tot_book_arr["'".$k."-".$k2."'"] += $booking->num_players;
							else
								$tot_book_arr["'".$k."-".$k2."'"] = $booking->num_players;
							/*var_dump($k);
							var_dump($k2);
							echo $c."<br>";
							$c++;*/
							$k = $k2;
						}

					}
				}
//echo "<pre> test "; print_r($tot_book_arr); echo "------<br>";
$temp_arr = array();
$bookings = NULL;
				foreach($get_court_bookings as $booking) {
					//$from  = date('D Y-m-d H:i:s', strtotime($booking->res_date.' '.$booking->from_time));
					//$to	     = date('D Y-m-d H:i:s', strtotime($booking->res_date.' '.$booking->to_time));

						$frTime  = strtotime($booking->from_time);
						$toTime = strtotime($booking->to_time);
						
						$actual_from	= date("Y-m-d H:i", strtotime($booking->res_date.' '.$booking->from_time));
						$actual_to		= date("Y-m-d H:i", strtotime($booking->res_date.' '.$booking->to_time));

						$k	= date("Y-m-d H:i", strtotime($booking->res_date.' '.$booking->from_time));
				
						for( ;strtotime($k) < strtotime($booking->res_date.' '.$booking->to_time);){

							//$k2  = date("Y-m-d H:i", strtotime('+30 minutes', strtotime($k)));
							$k2  = date("Y-m-d H:i", strtotime('+'.($slot_dur * 60).' minutes', strtotime($k)));

							/*if(date("H:i", strtotime('+30 minutes', $booking->from_time)) >= date("H:i", strtotime($booking->to_time))){
								echo "test";
							}*/
							//echo $k2." - ".date("H:i", strtotime($booking->to_time)); exit;
							$from  = date('Y-m-d H:i:s', strtotime($k));
							$to	     = date('Y-m-d H:i:s', strtotime($k2));
							$reserved_by  = $booking->reserved_by;
							$numP				= $booking->num_players;
							$tot_bookings  = $booking->num_players;

							if(!empty($tot_book_arr)){
							$tot_bookings  = $tot_book_arr["'".$k."-".$k2."'"];
							}

							if(!in_array($from."-".$to, $temp_arr)){
								if($booking->players)
								$pList = json_decode($booking->players, true);
								else{
									$get_user = $this->general->get_user($booking->reserved_by);
									//echo "<pre>"; print_r($get_user); exit;
									if($get_user)
										$pList = array($get_user['Firstname']." ".$get_user['Lastname']);
								}

								$temp_arr[] = $from."-".$to;
								$temp_plist[$from."-".$to] = $pList;
								$bookings[] = array('from' => $from, 'to' => $to, 'reserved_by' => $reserved_by, 'numPlayers' => $numP, 'playersList' => $pList, 'total_bookings' => $tot_bookings, 'actual_booking_from' => $actual_from, 'actual_booking_to' => $actual_to);
							}
							/*else{
								$pList  = json_decode($booking->players, true);
								$temp = $temp_plist[$from."-".$to]; 
								$pList  = array_merge($pList, $temp);
							}*/

							$k = $k2;
						}

				}

				$data['current_bookings'] = $bookings;

			
			$this->response($data, 200);
		}
		else {
			$res = array('Error: '."User ID is Missing");
			$this->response($res, 400);
		}

	}


	public function coachBookings_get(){

		$user_id = $this->input->get('coach_id');
		if($user_id) {
		
			$is_club_admin = false;
			$is_coach		 = false;

			$is_coach = $this->mclub->is_coach(0, $user_id);

			$is_booking_allowed = true;
			$is_discount_allowed = true;


				$data		  = array();
				$bookings  = array();

				$get_court_prices		= $this->mclub->get_coach_prices($user_id);				
				$get_court_bookings	= $this->mclub->get_coach_bookings($user_id);
				
				$allow_same_day_booking = true;
				$allow_sameday_multi_booking = true;
				$is_sharable = 1;

					
				//echo "<pre>"; print_r($get_court_bookings); exit;
				/* ********* prices *************/ 


				$tot_book_arr = array();
				$slot_dur = 0.5;
				//$slot_dur = $get_court_info['slot_duration'];
				//echo "Test"; exit;
				//echo $slot_dur; exit;
//echo "<pre> test "; print_r($tot_book_arr); echo "------<br>";
$temp_arr = array();
$bookings = NULL;
				foreach($get_court_bookings as $booking) {
					//$from  = date('D Y-m-d H:i:s', strtotime($booking->res_date.' '.$booking->from_time));
					//$to	     = date('D Y-m-d H:i:s', strtotime($booking->res_date.' '.$booking->to_time));

						$frTime  = strtotime($booking->from_time);
						$toTime = strtotime($booking->to_time);
						
						$actual_from	= date("Y-m-d H:i", strtotime($booking->res_date.' '.$booking->from_time));
						$actual_to		= date("Y-m-d H:i", strtotime($booking->res_date.' '.$booking->to_time));

						$k	= date("Y-m-d H:i", strtotime($booking->res_date.' '.$booking->from_time));
				
						for( ;strtotime($k) < strtotime($booking->res_date.' '.$booking->to_time);){

							//$k2  = date("Y-m-d H:i", strtotime('+30 minutes', strtotime($k)));
							$k2  = date("Y-m-d H:i", strtotime('+'.($slot_dur * 60).' minutes', strtotime($k)));

							/*if(date("H:i", strtotime('+30 minutes', $booking->from_time)) >= date("H:i", strtotime($booking->to_time))){
								echo "test";
							}*/
							//echo $k2." - ".date("H:i", strtotime($booking->to_time)); exit;
							$from  = date('Y-m-d H:i:s', strtotime($k));
							$to	     = date('Y-m-d H:i:s', strtotime($k2));
							$reserved_by  = $booking->reserved_by;
							$numP				= $booking->num_players;
							$tot_bookings  = $booking->num_players;

							if(!empty($tot_book_arr)){
							$tot_bookings  = $tot_book_arr["'".$k."-".$k2."'"];
							}

							if(!in_array($from."-".$to, $temp_arr)){
								if($booking->players)
								$pList = json_decode($booking->players, true);
								else{
									$get_user = $this->general->get_user($booking->reserved_by);
									//echo "<pre>"; print_r($get_user); exit;
									if($get_user)
										$pList = array($get_user['Firstname']." ".$get_user['Lastname']);
								}

								$temp_arr[] = $from."-".$to;
								$temp_plist[$from."-".$to] = $pList;
								$bookings[] = array('from' => $from, 'to' => $to, 'reserved_by' => $reserved_by, 'numPlayers' => $numP, 'playersList' => $pList, 'total_bookings' => $tot_bookings, 'actual_booking_from' => $actual_from, 'actual_booking_to' => $actual_to);
							}
							/*else{
								$pList  = json_decode($booking->players, true);
								$temp = $temp_plist[$from."-".$to]; 
								$pList  = array_merge($pList, $temp);
							}*/

							$k = $k2;
						}

				}

				$data['current_bookings'] = $bookings;

			
			$this->response($data, 200);
		}
		else {
			$res = array('Error: '."User ID is Missing");
			$this->response($res, 400);
		}

	}


		public function paypalCoachChecksum_get(){

		$coach_id	= $this->input->get('coach_id');
		$user_id	= $this->input->get('user_id');
		$txn_amount = $this->input->get('amount');
		$is_coach = $this->mclub->is_coach(0, $coach_id);

		//$court_det  = $this->mclub->get_coach_info($court_id);
		
		if(!$coach_id or !$user_id or !$txn_amount){
			$res = array('Error: '."Please provide all the information (CoachID, UserID, Amount)");
			$this->response($res);
			exit;
		}
	
		if($is_coach){

			//if($court_det['gateway_name'] == 'paypal'){
			//	$get_det = $this->muser->get_paypal($court_det['payment_ref_id']);
			//}
			//else{
				$get_det = $this->muser->get_paypal('5');
			//}
		$user_det	= $this->mclub->get_user_details($user_id);
		$coach_det  = $this->mclub->get_user_details($coach_id);

		$this->load->library('paypal_lib');
		
		$paypalID = $get_det['paypal_merch_id'];
		//echo $paypalID; exit;
		$logo = base_url().'images/logo.png';
		$returnURL = 'https://a2msports.com/rest_services/clubs/paypalSuccess';
		$cancelURL = 'https://a2msports.com/rest_services/clubs/paypalCancel';

		$this->paypal_lib->add_field('business', $paypalID);
		$this->paypal_lib->add_field('return', $returnURL);
		$this->paypal_lib->add_field('cancel_return', $cancelURL);
		//$this->paypal_lib->add_field('notify_url', $notifyURL);
		$this->paypal_lib->add_field('coach_id', $coach_id);
		//$this->paypal_lib->add_field('player', $this->logged_user);
		$this->paypal_lib->add_field('on0', $user_id);
		$this->paypal_lib->add_field('item_number',  $coach_id);
		$this->paypal_lib->add_field('item_name',  "Coach - ".$coach_det['Firstname']." ".$coach_det['Lastname']);
		$this->paypal_lib->add_field('amount', $txn_amount);        
		//$this->paypal_lib->image($logo);
		
		$htmlForm = $this->paypal_lib->paypal_api_form();


		/*$data['MID']		= PAYTM_MERCHANT_MID;
		$data['ORDER_ID']	= $order_id;
		$data['CUST_ID']	= $user_id;
		$data['TXN_AMOUNT'] = $txn_amount;
		$data['CHECKSUMHASH'] = $checkSum;*/
		$data['htmlForm'] = $htmlForm;

		$res = array($data);	
		//$this->response($res);
		echo $htmlForm;
		}
		else{
			$res = array('Error: '."Invalid Coach ID!");
			$this->response($res, 400);
		}

	}


		public function paypalSandboxCoachChecksum_get(){

		$coach_id	= $this->input->get('coach_id');
		$user_id	= $this->input->get('user_id');
		$txn_amount = $this->input->get('amount');
		$is_coach = $this->mclub->is_coach(0, $coach_id);

		//$court_det  = $this->mclub->get_coach_info($court_id);
		
		if(!$coach_id or !$user_id or !$txn_amount){
			$res = array('Error: '."Please provide all the information (CoachID, UserID, Amount)");
			$this->response($res);
			exit;
		}
	
		if($is_coach){

			//if($court_det['gateway_name'] == 'paypal'){
			//	$get_det = $this->muser->get_paypal($court_det['payment_ref_id']);
			//}
			//else{
				$get_det = $this->muser->get_paypal('8');
			//}
		$user_det = $this->mclub->get_user_details($user_id);
		$coach_det = $this->mclub->get_user_details($coach_id);
		$this->load->library('paypal_lib');
		
		$paypalID = $get_det['paypal_merch_id'];
		//echo $paypalID; exit;
		$logo = base_url().'images/logo.png';
		$returnURL = 'https://a2msports.com/rest_services/clubs/paypalSuccess';
		$cancelURL = 'https://a2msports.com/rest_services/clubs/paypalCancel';

		$this->paypal_lib->add_field('business', $paypalID);
		$this->paypal_lib->add_field('return', $returnURL);
		$this->paypal_lib->add_field('cancel_return', $cancelURL);
		//$this->paypal_lib->add_field('notify_url', $notifyURL);
		$this->paypal_lib->add_field('coach_id', $coach_id);
		//$this->paypal_lib->add_field('player', $this->logged_user);
		$this->paypal_lib->add_field('on0', $user_id);
		$this->paypal_lib->add_field('item_number',  $coach_id);
		$this->paypal_lib->add_field('item_name',  "Coach - ".$coach_det['Firstname']." ".$coach_det['Lastname']);
		$this->paypal_lib->add_field('amount', $txn_amount);        
		//$this->paypal_lib->image($logo);
		
		$htmlForm = $this->paypal_lib->sandbox_paypal_api_form();


		/*$data['MID']		= PAYTM_MERCHANT_MID;
		$data['ORDER_ID']	= $order_id;
		$data['CUST_ID']	= $user_id;
		$data['TXN_AMOUNT'] = $txn_amount;
		$data['CHECKSUMHASH'] = $checkSum;*/
		$data['htmlForm'] = $htmlForm;

		$res = array($data);	
		//$this->response($res);
		echo $htmlForm;
		}
		else{
			$res = array('Error: '."Invalid Coach ID!");
			$this->response($res, 400);
		}

	}

}