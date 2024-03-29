<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class model_user extends CI_Model {

	public $req_method;

	public function __construct() {
		parent:: __construct();
		$this->load->database();

		/*if($this->input->server('REQUEST_METHOD') == 'GET') {
			$this->req_method = 'get';
		}
		else if($this->input->server('REQUEST_METHOD') == 'POST') {
			$this->req_method = 'post';
		}*/
	}

	public function check_user_exists($fb_id) {
		$data = array('Socialactid' => $fb_id, 'Socialweb' => 'FB');
		
		$query = $this->db->get_where('Users', $data);
		//echo $this->db->last_query();
		return $query->row_array();
	}

	public function check_google_user_exists($google_id) {
		$data = array('Google_AuthID' => $google_id, 'IsGoogleLogin' => 1);
		
		$query = $this->db->get_where('Users', $data);
		//echo $this->db->last_query();
		return $query->row_array();
	}

	public function check_apple_user_exists($google_id) {
		$data = array('iCloud_AuthID' => $google_id, 'IsiCloudLogin' => 1);
		
		$query = $this->db->get_where('Users', $data);
		//echo $this->db->last_query();
		return $query->row_array();
	}

	public function get_user_details($user_id) {
		$qry_check = $this->db->query("SELECT * FROM Users WHERE Users_ID = '".$user_id."'");
		return $qry_check->row_array();
	}

	public function get_paytm($id) {
		$qry_check = $this->db->query("SELECT * FROM Paytm_Business_Accounts WHERE paytm_busi_id = '".$id."'");
		return $qry_check->row_array();
	}

	public function get_paypal($id) {
		$qry_check = $this->db->query("SELECT * FROM Paypal_Business_Accounts WHERE pp_busi_id = '".$id."'");
		return $qry_check->row_array();
	}

	/*
	public function get_users() {
		$qry_check = $this->db->query("SELECT * FROM Users");
		$users = $qry_check->result_array();

		$revised_arr = array();

		foreach($users as $user){
			$get_sports = $this->db->query("SELECT Sport_id, Level FROM Sports_Interests WHERE users_id = '".$user['Users_ID']."'");
			$revised_arr[$user['Users_ID']] = $user; 
			$sp = $get_sports->result_array();

			$revised_arr[$user['Users_ID']]['Sports_Interests'] = $sp;
 		}

		return $revised_arr;
	}
	*/

	public function get_users($user_id) {

		if($user_id != ''){
		$qry_check = $this->db->query("SELECT * FROM Users WHERE Country IN (SELECT Country FROM Users WHERE Users_ID = '".$user_id."')");
		}
		else{
		$qry_check = $this->db->query("SELECT * FROM Users");
		}
		//echo $this->db->last_query();
		$users = $qry_check->result_array();

		$revised_arr     = array();

		foreach($users as $user){

			$spi_query = $this->db->query("SELECT * FROM Sports_Interests WHERE users_id = '".$user['Users_ID']."'");
			$spi_result = $spi_query->result_array();
			$sp = array();
			foreach($spi_result as $res){
				$sp[] = array("Sport_id" => trim($res["Sport_id"]), "Level" => trim($res["Level"]));
			}

			//$sp[] = array("Sport_id" => trim($user["Sport_id"]), "Level" => trim($user["Level"]));

			$prof_pic = base_url().'profile_pictures/'.'default-profile.png';
			if($user["Profilepic"]){
			$prof_pic = base_url().'profile_pictures/'.$user["Profilepic"];
			}
			$revised_arr[$user['Users_ID']] =  
			array(
				"Users_ID"			=> $user['Users_ID'],
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
				"sports_interests" => $sp
				);

 		}

		return $revised_arr;
	}

	public function get_limit_users($user_id, $page, $limit, $search) {

		$offset = ($page * $limit) - $limit;

$search_cond = '';

if(count($search) > 0){

	if($search['name']){
		$search_cond .= " AND (Firstname LIKE '%{$search['name']}%' 
		OR Lastname LIKE '%{$search['name']}%' 
		OR Firstname+' '+Lastname LIKE '%{$search['name']}%')";
	}

	if($search['sport']){
		if($search['sp_level'])
			$search_cond .= " AND Users_ID in (SELECT users_id FROM Sports_Interests WHERE Sport_id = {$search['sport']} AND Level = {$search['sp_level']})";
		else
			$search_cond .= " AND Users_ID in (SELECT users_id FROM Sports_Interests WHERE Sport_id = {$search['sport']})";
	}

	$lat   = 0;
	$long = 0;

	if($search['latitude'] and $search['longitude']){
		$lat   = $search['latitude'];
		$long = $search['longitude'];
	}
	else if($user_id != ''){
		$get_user = $this->get_user_details($user_id);

		if($get_user){
			$lat   = $get_user['Latitude'];
			$long = $get_user['Longitude'];
		}
	}

		if($search['distance']){
			$search_cond .= " AND ACOS( SIN( RADIANS( Latitude )) * SIN( RADIANS( {$lat} ) ) + COS( RADIANS( Latitude ) ) * COS( RADIANS( {$lat} )) *  COS( RADIANS( Longitude ) - RADIANS( {$long})) ) * 3964.3 < ".$search['distance'];
		}

}
		if($user_id != ''){
			if(($search['latitude'] and $search['longitude']) or $search['name']){
			//echo "ss ".$search_cond;
			$search_cond = substr($search_cond, 4);
			$search_cond = "WHERE".$search_cond;
			$qry_check = $this->db->query("SELECT * FROM Users {$search_cond} ORDER BY Users_ID OFFSET {$offset} ROWS FETCH NEXT {$limit} ROWS ONLY");

			$tot_users_qry = $this->db->query("SELECT COUNT(*) AS tot_users FROM Users {$search_cond}");

			}
			else{
			$qry_check = $this->db->query("SELECT * FROM Users WHERE Country IN (SELECT Country FROM Users WHERE Users_ID = '".$user_id."'){$search_cond} ORDER BY Users_ID OFFSET {$offset} ROWS FETCH NEXT {$limit} ROWS ONLY");

			$tot_users_qry = $this->db->query("SELECT COUNT(*) AS tot_users FROM Users WHERE Country IN (SELECT Country FROM Users WHERE Users_ID = '".$user_id."'){$search_cond}");
			}
		}
		else{
			$qry_check = $this->db->query("SELECT * FROM Users ORDER BY Users_ID OFFSET {$offset} ROWS FETCH NEXT {$limit} ROWS ONLY");

			$tot_users_qry = $this->db->query("SELECT COUNT(*) AS tot_users FROM Users");
		}

		/*echo $this->db->last_query();
		exit;*/
			$tot_users_res = $tot_users_qry->result_array();
		
			$tot_users = $tot_users_res[0]['tot_users'];

			$tot_pages = ceil($tot_users / $limit);
			//$tot_pages = $tot_users;

		//echo $this->db->last_query();
		$users = $qry_check->result_array();

		$revised_arr = array();

		foreach($users as $user) {

			$spi_query = $this->db->query("SELECT * FROM Sports_Interests WHERE users_id = '".$user['Users_ID']."'");
			$spi_result = $spi_query->result_array();
			$sp = array();
			foreach($spi_result as $res){
				//$sp[] = array("Sport_id" => trim($res["Sport_id"]), "Level" => trim($res["Level"]));
				$sp[] = intval(trim($res["Sport_id"]));
			}

			$prof_pic = base_url().'profile_pictures/'.'default-profile.png';
			if($user["Profilepic"]) {
			$prof_pic = base_url().'profile_pictures/'.$user["Profilepic"];
			}

			$revised_arr['results'][] =  
			array(
				"id"				=> $user['Users_ID'],
				"Firstname"	=> $user['Firstname'],
				"Lastname"		=> $user["Lastname"],
				"Profilepic"		=> $prof_pic,
				/*"EmailID"		=> $user["EmailID"],
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
				"coach_sport"	=> $user["coach_sport"],*/
				"sports_interests" => $sp
				);

 		}

		$revised_arr['total_pages'] = $tot_pages;
		return $revised_arr;
	}

	public function get_limit_coachUsers($user_id, $page, $limit, $search) {

		$offset = ($page * $limit) - $limit;

$search_cond = '';

if(count($search) > 0){


if($search['city'] or $search['state']){
	if($search['city'] and !$search['state']){
		$search_cond = " AND City LIKE '%{$search['city']}%'";
	}
	else if(!$search['city'] and $search['state']){
		$search_cond = " AND State LIKE '%{$search['state']}%'";
	}
	else if($search['city'] and $search['state']){
		$search_cond = " AND City LIKE '%{$search['city']}%' AND State LIKE '%{$search['state']}%'";
	}
}

	if($search['name']){
		$search_cond .= " AND (Firstname LIKE '%{$search['name']}%' 
		OR Lastname LIKE '%{$search['name']}%' 
		OR Firstname+' '+Lastname LIKE '%{$search['name']}%')";
	}

	if($search['sport']){
		$search_cond .= " AND Users_ID in (SELECT users_id FROM Sports_Interests WHERE Sport_id = {$search['sport']})";
	}

	$lat   = 0;
	$long = 0;

	if($search['latitude'] and $search['longitude']){
		$lat   = $search['latitude'];
		$long = $search['longitude'];
	}
	else if($user_id != ''){
		$get_user = $this->get_user_details($user_id);

		if($get_user){
			$lat   = $get_user['Latitude'];
			$long = $get_user['Longitude'];
		}
	}

		if($search['distance']){
			$search_cond .= " AND ACOS( SIN( RADIANS( Latitude )) * SIN( RADIANS( {$lat} ) ) + COS( RADIANS( Latitude ) ) * COS( RADIANS( {$lat} )) *  COS( RADIANS( Longitude ) - RADIANS( {$long})) ) * 3964.3 < ".$search['distance'];
		}

}

		if($user_id != '' and $search_cond != ''){
			$qry_check = $this->db->query("SELECT * FROM Users WHERE Is_coach = 1{$search_cond} ORDER BY Users_ID OFFSET {$offset} ROWS FETCH NEXT {$limit} ROWS ONLY");

			$tot_users_qry = $this->db->query("SELECT COUNT(*) AS tot_users FROM Users WHERE Is_coach = 1{$search_cond}");
		}
		else{
			$qry_check = $this->db->query("SELECT * FROM Users WHERE Is_coach = 1 ORDER BY Users_ID OFFSET {$offset} ROWS FETCH NEXT {$limit} ROWS ONLY");

			$tot_users_qry = $this->db->query("SELECT COUNT(*) AS tot_users FROM Users WHERE Is_coach = 1");
		}

		/*echo $this->db->last_query();
		exit;*/
			$tot_users_res = $tot_users_qry->result_array();
		
			$tot_users = $tot_users_res[0]['tot_users'];

			$tot_pages = ceil($tot_users / $limit);
			//$tot_pages = $tot_users;

		//echo $this->db->last_query();
		$users = $qry_check->result_array();

		$revised_arr = array();

		foreach($users as $user) {

			$spi_query = $this->db->query("SELECT * FROM Sports_Interests WHERE users_id = '".$user['Users_ID']."'");
			$spi_result = $spi_query->result_array();
			$sp = array();
			foreach($spi_result as $res){
				//$sp[] = array("Sport_id" => trim($res["Sport_id"]), "Level" => trim($res["Level"]));
				$sp[] = intval(trim($res["Sport_id"]));
			}

			$prof_pic = base_url().'profile_pictures/'.'default-profile.png';
			if($user["Profilepic"]) {
			$prof_pic = base_url().'profile_pictures/'.$user["Profilepic"];
			}

			$revised_arr['results'][] =  
			array(
				"id"						=> $user['Users_ID'],
				"Firstname"		=> $user['Firstname'],
				"Lastname"		=> $user["Lastname"],
				"Profilepic"		=> $prof_pic,
				/*"EmailID"		=> $user["EmailID"],
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
				"Username"		=> $user["Username"],*/
				"Is_coach"			 => $user["Is_coach"],
				"coach_profile"	 => $user["coach_profile"],
				"Coach_Website"  => $user["Coach_Website"],
				"coach_sport"		  => trim($user["coach_sport"]),
				"sports_interests" => $sp
				);

 		}

		$revised_arr['total_pages'] = $tot_pages;
		return $revised_arr;
	}

	public function get_club_members($club_id, $page, $limit, $search) {

$offset_qry = "";

if($page != ''){
$offset = ($page * $limit) - $limit;
$offset_qry = " OFFSET {$offset} ROWS FETCH NEXT {$limit} ROWS ONLY";
}

$search_cond = '';

if(count($search) > 0){

	if($search['name']){
		$search_cond .= " AND (Firstname LIKE '%{$search['name']}%' 
		OR Lastname LIKE '%{$search['name']}%' 
		OR Firstname+' '+Lastname LIKE '%{$search['name']}%')";
	}

	if($search['sport']){
		if($search['sp_level'])
			$search_cond .= " AND Users_ID in (SELECT users_id FROM Sports_Interests WHERE Sport_id = {$search['sport']} AND Level = {$search['sp_level']})";
		else
			$search_cond .= " AND Users_ID in (SELECT users_id FROM Sports_Interests WHERE Sport_id = {$search['sport']})";
	}

	$lat   = 0;
	$long = 0;

	if($search['latitude'] and $search['longitude']){
		$lat   = $search['latitude'];
		$long = $search['longitude'];
	}

		if($lat and $long and $search['distance']){
			$search_cond .= " AND ACOS( SIN( RADIANS( Latitude )) * SIN( RADIANS( {$lat} ) ) + COS( RADIANS( Latitude ) ) * COS( RADIANS( {$lat} )) *  COS( RADIANS( Longitude ) - RADIANS( {$long})) ) * 3964.3 < ".$search['distance'];
		}

}
		if($club_id != ''){			
			/*$qry_check = $this->db->query("SELECT * FROM Users WHERE Users_ID IN (SELECT Users_id FROM User_memberships WHERE Club_id = {$club_id}){$search_cond} ORDER BY Users_ID OFFSET {$offset} ROWS FETCH NEXT {$limit} ROWS ONLY");*/
			$qry_check = $this->db->query("SELECT * FROM Users WHERE Users_ID IN (SELECT Users_id FROM User_memberships WHERE Club_id = {$club_id}){$search_cond} ORDER BY Users_ID{$offset_qry}");

			$tot_users_qry = $this->db->query("SELECT COUNT(*) AS tot_users FROM Users WHERE Users_ID IN (SELECT Users_id FROM User_memberships WHERE Club_id = {$club_id}){$search_cond}");
		}


		/*echo $this->db->last_query();
		exit;*/
			$tot_users_res = $tot_users_qry->result_array();
		
			$tot_users = $tot_users_res[0]['tot_users'];

			$tot_pages = ceil($tot_users / $limit);
			//$tot_pages = $tot_users;

		//echo $this->db->last_query();
		$users = $qry_check->result_array();

		$revised_arr = array();

		foreach($users as $user) {

			$spi_query = $this->db->query("SELECT * FROM Sports_Interests WHERE users_id = '".$user['Users_ID']."'");
			$spi_result = $spi_query->result_array();
			$sp = array();
			foreach($spi_result as $res){
				//$sp[] = array("Sport_id" => trim($res["Sport_id"]), "Level" => trim($res["Level"]));
				$sp[] = intval(trim($res["Sport_id"]));
			}

			$prof_pic = base_url().'profile_pictures/'.'default-profile.png';
			if($user["Profilepic"]) {
			$prof_pic = base_url().'profile_pictures/'.$user["Profilepic"];
			}

			$is_active = 0;

			$mem_status = $this->db->query("SELECT Member_Status FROM User_memberships WHERE Club_id = {$club_id} AND Users_id = {$user['Users_ID']}");

			if($mem_status->num_rows > 0){
				$mem_res = $mem_status->row_array();
				if($mem_res['Member_Status'])
					$is_active = $mem_res['Member_Status'];
			}
			//echo "test"; exit;
			$revised_arr['results'][] =  
			array(
				"id"				=> $user['Users_ID'],
				"Firstname"	=> $user['Firstname'],
				"Lastname"		=> $user["Lastname"],
				"Profilepic"		=> $prof_pic,
				/*"EmailID"		=> $user["EmailID"],
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
				"coach_sport"	=> $user["coach_sport"],*/
				"sports_interests" => $sp,
				"member_status" => $is_active
				);

 		}

		$revised_arr['total_pages'] = $tot_pages;
		return $revised_arr;
	}


	public function get_club_coaches($club_id, $page, $limit, $search) {

		$offset = ($page * $limit) - $limit;

$search_cond = ' AND Is_coach = 1';

if(count($search) > 0){

	if($search['name']){
		$search_cond .= " AND (Firstname LIKE '%{$search['name']}%' 
		OR Lastname LIKE '%{$search['name']}%' 
		OR Firstname+' '+Lastname LIKE '%{$search['name']}%')";
	}

	if($search['sport']){
		if($search['sp_level'])
			$search_cond .= " AND Users_ID in (SELECT users_id FROM Sports_Interests WHERE Sport_id = {$search['sport']} AND Level = {$search['sp_level']})";
		else
			$search_cond .= " AND Users_ID in (SELECT users_id FROM Sports_Interests WHERE Sport_id = {$search['sport']})";
	}

	$lat   = 0;
	$long = 0;

	if($search['latitude'] and $search['longitude']){
		$lat   = $search['latitude'];
		$long = $search['longitude'];
	}

		if($lat and $long and $search['distance']){
			$search_cond .= " AND ACOS( SIN( RADIANS( Latitude )) * SIN( RADIANS( {$lat} ) ) + COS( RADIANS( Latitude ) ) * COS( RADIANS( {$lat} )) *  COS( RADIANS( Longitude ) - RADIANS( {$long})) ) * 3964.3 < ".$search['distance'];
		}

}
		if($club_id != ''){			
			/*$qry_check = $this->db->query("SELECT * FROM Users WHERE Users_ID IN (SELECT Users_id FROM User_memberships WHERE Club_id = {$club_id}){$search_cond} ORDER BY Users_ID OFFSET {$offset} ROWS FETCH NEXT {$limit} ROWS ONLY");

			$tot_users_qry = $this->db->query("SELECT COUNT(*) AS tot_users FROM Users WHERE Users_ID IN (SELECT Users_id FROM User_memberships WHERE Club_id = {$club_id}){$search_cond}");*/

			$qry_check = $this->db->query("SELECT * FROM Users WHERE coach_academy = {$club_id}{$search_cond} ORDER BY Users_ID OFFSET {$offset} ROWS FETCH NEXT {$limit} ROWS ONLY");

			$tot_users_qry = $this->db->query("SELECT COUNT(*) AS tot_users FROM Users WHERE coach_academy = {$club_id}{$search_cond}");
		}


		/*echo $this->db->last_query();
		exit;*/
			$tot_users_res = $tot_users_qry->result_array();
		
			$tot_users = $tot_users_res[0]['tot_users'];

			$tot_pages = ceil($tot_users / $limit);
			//$tot_pages = $tot_users;

		//echo $this->db->last_query();
		$users = $qry_check->result_array();

		$revised_arr = array();

		foreach($users as $user) {

			$spi_query = $this->db->query("SELECT * FROM Sports_Interests WHERE users_id = '".$user['Users_ID']."'");
			$spi_result = $spi_query->result_array();
			$sp = array();
			if($spi_result){
				foreach($spi_result as $res){
					//$sp[] = array("Sport_id" => trim($res["Sport_id"]), "Level" => trim($res["Level"]));
					$sp[] = intval(trim($res["Sport_id"]));
				}
			}

			$prof_pic = base_url().'profile_pictures/'.'default-profile.png';
			if($user["Profilepic"]) {
			$prof_pic = base_url().'profile_pictures/'.$user["Profilepic"];
			}

			$revised_arr['results'][] =  
			array(
				"id"				=> $user['Users_ID'],
				"Firstname"	=> $user['Firstname'],
				"Lastname"		=> $user["Lastname"],
				"Profilepic"		=> $prof_pic,
				/*"EmailID"		=> $user["EmailID"],
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
				"Username"		=> $user["Username"],*/
				"Is_coach"		=> $user["Is_coach"],
				"coach_profile" => $user["coach_profile"],
				"Coach_Website" => $user["Coach_Website"],
				"coach_sport"	=> $user["coach_sport"],
				"sports_interests" => $sp
				);

 		}

		$revised_arr['total_pages'] = $tot_pages;
		return $revised_arr;
	}

	public function get_usatt_id($user_id) {
		$query = $this->db->query("SELECT * FROM Academy_users WHERE Org_id = '19' AND Users_id = '".$user_id."'");
		$res   = $query->row_array();

		if($res['Membership_ID']){
			return $res['Membership_ID'];
		}
		else{
			return 0;
		}
	}

	public function get_usatt_rating($member_id) {
		$query = $this->db->query("SELECT * FROM USATTMembership WHERE Member_ID = '".$member_id."'");
		$res   = $query->row_array();

		if($res['Rating']){
			return $res['Rating'];
		}
		else{
			return 'n/a';
		}
	}

	public function get_user_captain_teams($user_id, $tourn_id, $sport) {
		$query = $this->db->query("SELECT * FROM Teams WHERE Sport = '".$sport."' AND (Created_by = '".$user_id."' OR Captain = '".$user_id."') AND Team_ID NOT IN (SELECT Team_id FROM RegisterTournament WHERE Tournament_ID = '{$tourn_id}')");

		return $query->result();
	}

	public function get_user_non_captain_teams($user_id, $tourn_id, $sport) {
		$query = $this->db->query("SELECT * FROM Teams WHERE Sport = '".$sport."' AND (Created_by != '".$user_id."' AND Captain != '".$user_id."') AND Players LIKE '%".$user_id."%' AND Team_ID NOT IN (SELECT Team_id FROM RegisterTournament WHERE Tournament_ID = '{$tourn_id}')");

		return $query->result();
	}

	public function insert_fb($fb) {
		$fb_id		   = $fb['id'];
		$fb_first_name = $fb['first_name'];
		$fb_last_name  = $fb['last_name'];

		if(isset($fb['email'])) {
			$fb_email = $fb['email'];

			$is_email_exists = $this->is_email_exists($fb_email);

			if($is_email_exists > 0) {
			$fb_email = "";
			}
		}
		else {
			$fb_email = "";
		}

		$fb_gender = $fb['gender'];
		$gender = NULL;
		/*if($fb_gender == 'male' or $fb_gender == '1') {
			$gender = '1';
		}
		else if($fb_gender == 'female' or $fb_gender == '0') {
			$gender = '0';
		}*/

		$issocial			= 1;
		$web				= 'FB';
		$reg_date			= date("Y-m-d h:i:s");
		$is_user_activation = 1;
		$act_dt				= date("Y-m-d h:i:s");
		$is_user_activation = 1;
		$is_profile_updated = 0;
		$latitude			= 0;
		$longitude			= 0;

		$data = array (
			 'Firstname'		=> $fb_first_name,
			 'Lastname'			=> $fb_last_name,
			 'EmailID'			=> $fb_email,
			 'Gender'			=> $gender,
			 'Socialactid'		=> $fb_id,
			 'Issociallogin'	=> $issocial,
			 'RegistrationDtTm' => $reg_date,
			 'ActivatedDtTm'	=> $act_dt,
			 'IsUserActivation' => $is_user_activation,
			 'Latitude'			=> $latitude,
			 'Longitude'		=> $longitude,
			 'Socialweb'		=> $web,
			 'IsProfileUpdated'	=> $is_profile_updated 
			);

		$this->db->insert('users', $data);
		$insert_id = $this->db->insert_id();

		$data['Users_ID'] = $insert_id;
		
	
		return $data;	
	}

/*
	public function insert_google($google) {
		$google_id		   = $google['id'];
		$google_first_name = $google['first_name'];
		$google_last_name  = $google['last_name'];

		if(isset($google['email'])) {
			$google_email = $google['email'];

			$is_email_exists = $this->is_email_exists($google_email);

			if($is_email_exists > 0) {
			$google_email = "";
			}
		}
		else {
			$google_email = "";
		}

		$google_gender = $google['gender'];

		if($google_gender == 'male') {
			$gender = '1';
		}
		else {
			$gender = '0';
		}

		$issocial			= 1;
		//$web				= 'FB';
		$reg_date			= date("Y-m-d h:i:s");
		$is_user_activation = 1;
		$act_dt				= date("Y-m-d h:i:s");
		$is_user_activation = 1;
		$is_profile_updated = 0;
		$latitude			= 0;
		$longitude			= 0;

		$data = array (
			 'Firstname'		=> $google_first_name,
			 'Lastname'			=> $google_last_name,
			 'EmailID'			=> $google_email,
			 'Gender'			=> $gender,
			 'Google_AuthID'	=> $google_id,
			 'IsGoogleLogin'	=> 1,
			 'RegistrationDtTm' => $reg_date,
			 'ActivatedDtTm'	=> $act_dt,
			 'IsUserActivation' => $is_user_activation,
			 'Latitude'			=> $latitude,
			 'Longitude'		=> $longitude,
			 //'Socialweb'		=> $web,
			 'IsProfileUpdated'	=> $is_profile_updated 
			);

		$this->db->insert('users', $data);
		$insert_id = $this->db->insert_id();

		$data['Users_ID'] = $insert_id;
		
	
		return $data;	
	}
*/

	public function insert_google($google) {
		$google_id		   = $google['id'];
		$google_first_name = $google['first_name'];
		$google_last_name  = $google['last_name'];
		$google_email	   = $google['email'];
		$google_gender	   = $google['gender'];
			$gender = NULL;
		/*if($google_gender == 'male') {
			$gender = '1';
		}
		else if($google_gender == 'female') {
			$gender = '0';
		}*/

		$issocial			= 1;
		//$web				= 'FB';
		$reg_date			= date("Y-m-d h:i:s");
		$is_user_activation = 1;
		$act_dt				= date("Y-m-d h:i:s");
		$is_profile_updated = 0;
		$latitude			= 0;
		$longitude			= 0;

		$data = array (
			 'Firstname'		=> $google_first_name,
			 'Lastname'			=> $google_last_name,
			 'EmailID'			=> $google_email,
			 'Gender'			=> $gender,
			 'Google_AuthID'	=> $google_id,
			 'IsGoogleLogin'	=> 1,
			 'RegistrationDtTm' => $reg_date,
			 'ActivatedDtTm'	=> $act_dt,
			 'IsUserActivation' => $is_user_activation,
			 'Latitude'			=> $latitude,
			 'Longitude'		=> $longitude,
			 //'Socialweb'		=> $web,
			 'IsProfileUpdated'	=> $is_profile_updated 
			);

		$this->db->insert('users', $data);
		$insert_id = $this->db->insert_id();

		$data['Users_ID'] = $insert_id;
		
		return $data;	
	}

	public function update_google($google, $user_id) {

		$google_id = $google['id'];

		$data = array (
				 'Google_AuthID' => $google_id,
				 'IsGoogleLogin' => 1,
				);

		$this->db->where('Users_ID', $user_id);
		$this->db->update('Users', $data);		
	
		return $user_id;
	}

	public function is_email_exists($email) {
		if($email != '') {
			$data  = array('EmailID' => $email);
			$query = $this->db->get_where('users', $data);

			return $query->num_rows();
		}
		else {
			return 0;
		}
	}


	public function insert_icloud($apple) {

		$apple_id					= $apple['id'];
		$apple_first_name  = $apple['first_name'];
		$apple_last_name   = $apple['last_name'];
		$apple_email				= $apple['email'];
		$apple_gender			= $apple['gender'];
		$gender						= NULL;

		/*if($apple_gender == 'male') {
			$gender = '1';
		}
		else if($apple_gender == 'female') {
			$gender = '0';
		}*/

		$issocial			= 1;
		//$web				= 'FB';
		$reg_date			= date("Y-m-d h:i:s");
		$is_user_activation = 1;
		$act_dt				= date("Y-m-d h:i:s");
		$is_profile_updated = 0;
		$latitude			= 0;
		$longitude		= 0;

		$data = array (
			 'Firstname'		=> $apple_first_name,
			 'Lastname'		=> $apple_last_name,
			 'EmailID'			=> $apple_email,
			 'Gender'			=> $gender,
			 'iCloud_AuthID'	=> $apple_id,
			 'IsiCloudLogin'		=> 1,
			 'RegistrationDtTm'	=> $reg_date,
			 'ActivatedDtTm'		=> $act_dt,
			 'IsUserActivation' => $is_user_activation,
			 'Latitude'				 => $latitude,
			 'Longitude'			 => $longitude,
			 //'Socialweb'		=> $web,
			 'IsProfileUpdated' => $is_profile_updated 
			);

		$this->db->insert('users', $data);
		$insert_id = $this->db->insert_id();

		$data['Users_ID']  = $insert_id;
		$data['Firstname'] = $apple_first_name;
		$data['Lastname']  = $apple_last_name;
		
		return $data;	
	}

	public function update_icloud($apple, $user_id) {

		$apple_id = $apple['id'];

		$data = array (
				 'iCloud_AuthID' => $apple_id,
				 'IsiCloudLogin' => 1,
				);

		$this->db->where('Users_ID', $user_id);
		$this->db->update('Users', $data);		
	
		return $user_id;
	}

	public function is_user_email_exists($email) {
		if($email != '') {
			$data  = array('EmailID' => $email);
			$query = $this->db->get_where('users', $data);

			return $query->row_array();
		}
		else {
			return 0;
		}
	}

	public function user_update($data, $user_id) {

			$this->db->where('Users_ID', $user_id);
			$result = $this->db->update('Users', $data); 
			
			//return $this->db->last_query();
			return $result;
	}

	public function user_sp_intrests_remove($user_id){
		$query = $this->db->query("DELETE FROM Sports_Interests WHERE users_id = '{$user_id}'");
		return 1;
	}

	public function user_sp_intrests($user_id, $sport, $level) {
		$cond = array('users_id' => $user_id, 'Sport_id' => $sport);

			$query = $this->db->query("SELECT * FROM Sports_Interests WHERE users_id = '{$user_id}' AND Sport_id = '{$sport}'");
			$res   = $query->num_rows();

			if($res){
				$data	= array('Level' => $level);
						  $this->db->where($cond);
				$result = $this->db->update('Sports_Interests', $data); 
			}
			else{
				$data	= array('users_id' => $user_id, 'Sport_id' => $sport, 'Level' => $level);
				$result = $this->db->insert('Sports_Interests', $data); 
			}

		return $result;
	}

	public function add_user_membership($data){

		$query = $this->db->query("SELECT * FROM User_memberships WHERE Users_id = ".$data['Users_id']." AND Related_Sport = '".$data['sport']."' AND Club_id = ".$data['org_id']);

		$res   = $query->num_rows();

			if($res){
					$data2['Users_id']		= $data['Users_id'];
					$data2['Related_Sport']	= $data['sport'];
					$data2['Club_id']		= $data['org_id'];

					$data3['Membership_ID']	= $data['membership_id'];
	
						  $this->db->where($data2);
				$result = $this->db->update('User_memberships', $data3);

				if($result){ return "Updated"; }
				else{ return 0; }
			}
			else{
					$data2['Users_id']		= (int)$data['Users_id'];
					$data2['Related_Sport']	= $data['sport'];
					$data2['Club_id']		= (int)$data['org_id'];
					$data2['Membership_ID']	= $data['membership_id'];
					$data2['Member_Status']	= 0;
				$result = $this->db->insert('User_memberships', $data2);

				if($result){ return "Added"; }
				else{ return 0; }
			}
	}

	public function get_userToken($user_id)
	{
		$data  = array('user_id' => $user_id, 'status' => 1);
		$query = $this->db->get_where('userPushTokens', $data);
		return $query->result();
	}

	public function insert_notif($data){
		$query = $this->db->insert('Mobile_Notifications', $data);
		//echo $this->db->last_query();
		return $query;
	}

	public function instant_register($data2){
			/*$lat_long	= $data['latt'];
			$pieces		= explode("@", $lat_long);
			
			$latitude	= $pieces[0];
			$longitude	= $pieces[1];*/

			$reg_date	= date("Y-m-d h:i:s");

			$firstname	= $data2['fname'];
			$lastname	= $data2['lname'];
			$password = NULL;
			if($data2['password'])
			$password	= md5($data2['password']);

			$email		= $data2['email'];
			//$phone		= $this->input->post('phone');
			$gender		= $data2['gender'];
			$sp_int		= $data2['sp_int'];
			$club_id		= $data2['club_id'];
			/*$zipcode    = $this->input->post('Zipcode');
			$sportstype = $this->input->post('sportstype');
			
			if(!$sportstype){
				$sportstype = 10;
			}*/
			
			$sportstype = array(1,2,3,7);
			$str	   = md5($lastname . $email);
			$auth_code = substr($str, 0, 8);
			$sp_code   = substr(base64_encode('instant'), 0, 4);
			
			$code = $auth_code . '_' . $sp_code;

			$data = array(
					'Firstname'		    => $firstname,
					'Lastname'		    => $lastname,
					'Password'		    => $password,
					'EmailID'		    => $email,
					//'Mobilephone'	    => $phone,
					'Gender'            => $gender,
					//'Zipcode'           => $zipcode ,
					//'Latitude'          => $latitude ,
					//'Longitude'         => $longitude ,
					'IsUserActivation'	=> 1,
					'ActivationCode'	=> $code,
					'RegistrationDtTm'  => $reg_date
					);

			$this->db->insert('Users', $data);
		    $insert_id = $this->db->insert_id();

			if($insert_id){
				$user_det = array(
					'firstname' => $firstname,
					'lastname'  => $lastname,
					'email'		=> $email,
					//'phone'     => $phone,
					'act_code'  => $code,
					'users_id'  => $insert_id);

				if($club_id){
					$get_club_info = $this->db->query("SELECT Primary_Sport FROM Academy_Info WHERE Aca_ID = {$club_id}");
					$row = $get_club_info->row_array();
					
					if(!in_array($row['Primary_Sport'], $sportstype))
						$sportstype[] = $row['Primary_Sport'];

						$data3 = array('Club_id' => $club_id,
												'Users_id'  => $insert_id,
												'Member_Status' => 0);
					
					$this->db->insert('User_memberships', $data3); 
				}

				if($sp_int){
					foreach($sp_int as $sp){
					$data = array('Sport_id' => $sp, 'users_id' => $insert_id);
					$this->db->insert('Sports_Interests', $data); 
					$this->ins_user_a2mscore($sp, $insert_id);
					}
				}
				else{
					foreach($sportstype as $sp){
					$data = array('Sport_id' => $sp, 'users_id' => $insert_id);
					$this->db->insert('Sports_Interests', $data); 
					$this->ins_user_a2mscore($sp, $insert_id);
					}
				}
			}
			else{
				$user_det = 0;
			}

			return $user_det;
	}
	
	public function get_intrests()
	{
		$query = $this->db->get('SportsType');
		return $query->result();
	}

	public function ins_user_a2mscore($sp, $user){
		if($user and $sp){
			$data = array(
						'SportsType_ID'  => $sp, 
						'Users_ID'			=> $user, 
						'A2MScore'		    => 100,
						'A2MScore_Doubles' => 100,
						'A2MScore_Mixed'   => 100
						);
			$ins = $this->db->insert('A2MScore', $data);
			return $ins;
		}
		else 
			return false;
	}

	public function get_users_temp($user_id) {

		if($user_id != ''){
		$qry_check = $this->db->query("SELECT * FROM Users WHERE Country IN (SELECT Country FROM Users WHERE Users_ID = '".$user_id."') ORDER BY Users_ID OFFSET 1 ROWS FETCH NEXT 15 ROWS ONLY");
		}
		else{
		$qry_check = $this->db->query("SELECT * FROM Users ORDER BY Users_ID OFFSET 1 ROWS FETCH NEXT 15 ROWS ONLY");
		}
		//echo $this->db->last_query();
		$users = $qry_check->result_array();

		return $users;
	}

}