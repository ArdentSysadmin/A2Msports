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

	public function validate_user($email, $pwd) {
		$pwd = md5($pwd);
		$qry_check = $this->db->query("SELECT * FROM Users WHERE (EmailID = '".$email."' OR UserProfileName = '".$email."' OR Username = '".$email."' ) AND Password = '".$pwd."'");
		return $qry_check->row_array();
	}

	public function validate_user_phone($phone, $ph) {
		//$pwd = md5($pwd);
		$qry_check = 
			$this->db->query("SELECT * FROM Users WHERE Mobilephone = '".$ph."' OR Mobilephone = '".$phone."'");
		return $qry_check->result_array();
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

	public function get_users($user_id, $is_sort='', $sport='') {

		if($user_id != '' and !$is_sort and $sport == ''){
		$qry_check = $this->db->query("SELECT * FROM Users WHERE Country IN (SELECT Country FROM Users WHERE Users_ID = '".$user_id."')");
		}
		else if($user_id != '' and $is_sort and $sport != ''){
		$qry_check = $this->db->query("SELECT (SELECT MAX(MaxValue) FROM (VALUES (a.A2MScore),(a.A2MScore_Doubles),(a.A2MScore_Mixed)) AS Value(MaxValue)) AS A2MScore, u.* FROM Users u JOIN A2MScore a ON u.Users_ID = a.Users_ID AND a.SportsType_ID = '".$sport."' WHERE u.Country IN (SELECT Country FROM Users WHERE Users_ID = '".$user_id."') ORDER BY A2MScore {$is_sort}");
		/*$qry_check = $this->db->query("SELECT * FROM Users WHERE Country IN (SELECT Country FROM Users WHERE Users_ID = '".$user_id."')");*/
		} 
		else{
		$qry_check = $this->db->query("SELECT * FROM Users");
		}
		//echo $this->db->last_query();exit;
		$users				= $qry_check->result_array();
		$revised_arr = array();

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

			$a2mscore = NULL;
			if($user['A2MScore'] != '')
			$a2mscore = $user['A2MScore'];

			$revised_arr[$user['Users_ID']] =  
			array(
				"Users_ID"			=> $user['Users_ID'],
				"Firstname"		=> $user['Firstname'],
				"Lastname"		=> $user["Lastname"],
				"A2MScore"		=> $a2mscore,
				"EmailID"			=> $user["EmailID"],
				"AlternateEmailID" => $user["AlternateEmailID"],
				"DOB"				=> $user["DOB"],
				"Gender"		=> $user["Gender"],
				"UserAddressline1" => $user["UserAddressline1"],
				"UserAddressline2" => $user["UserAddressline2"],
				"Country"		=> $user["Country"],
				"State"			=> $user["State"],
				"City"				=> $user["City"],
				"Zipcode"		=> $user["Zipcode"],
				"HomePhone"		=> $user["HomePhone"],
				"Mobilephone"		=> $user["Mobilephone"],
				"IsUserActivation" => $user["IsUserActivation"],
				"Profilepic"	=> $prof_pic,
				"Latitude"		=> $user["Latitude"],
				"Longitude"			=> $user["Longitude"],
				"UserAgegroup"	=> $user["UserAgegroup"],
				"Username"			=> $user["Username"],
				"Is_coach"				=> $user["Is_coach"],
				"coach_profile" => $user["coach_profile"],
				"Coach_Website" => $user["Coach_Website"],
				"coach_sport"	=> $user["coach_sport"],
				"NotifySettings"	=> $user["NotifySettings"],
				"sports_interests" => $sp
				);

 		}

		return $revised_arr;
	}

	public function get_limit_users($user_id, $page, $limit, $search, $is_sort, $sport) {

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
		if($search['sp_level'])
			$search_cond .= " AND u.Users_ID in (SELECT users_id FROM Sports_Interests WHERE Sport_id = {$search['sport']} AND Level = {$search['sp_level']})";
		else
			$search_cond .= " AND u.Users_ID in (SELECT users_id FROM Sports_Interests WHERE Sport_id = {$search['sport']})";
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

				if($user_id != '' and $is_sort and $sport != ''){
					$qry_check = $this->db->query("SELECT (SELECT MAX(MaxValue) FROM (VALUES (a.A2MScore),(a.A2MScore_Doubles),(a.A2MScore_Mixed)) AS Value(MaxValue)) AS A2MScore, u.* FROM Users u JOIN A2MScore a ON u.Users_ID = a.Users_ID AND a.SportsType_ID = '".$sport."' {$search_cond} ORDER BY A2MScore {$is_sort} OFFSET {$offset} ROWS FETCH NEXT {$limit} ROWS ONLY");

					$tot_users_qry = $this->db->query("SELECT COUNT(*) AS tot_users FROM Users u JOIN A2MScore a ON u.Users_ID = a.Users_ID AND a.SportsType_ID = '".$sport."' {$search_cond}");
				}
				else{
					$qry_check = $this->db->query("SELECT * FROM Users {$search_cond} ORDER BY Users_ID OFFSET {$offset} ROWS FETCH NEXT {$limit} ROWS ONLY");
					$tot_users_qry = $this->db->query("SELECT COUNT(*) AS tot_users FROM Users {$search_cond}");
				}
			}
			else{
				if($user_id != '' and $is_sort and $sport != ''){
					$qry_check = $this->db->query("SELECT (SELECT MAX(MaxValue) FROM (VALUES (a.A2MScore),(a.A2MScore_Doubles),(a.A2MScore_Mixed)) AS Value(MaxValue)) AS A2MScore, u.* FROM Users u JOIN A2MScore a ON u.Users_ID = a.Users_ID AND a.SportsType_ID = '".$sport."' {$search_cond} ORDER BY A2MScore {$is_sort} OFFSET {$offset} ROWS FETCH NEXT {$limit} ROWS ONLY");

					$tot_users_qry = $this->db->query("SELECT COUNT(*) AS tot_users FROM Users u JOIN A2MScore a ON u.Users_ID = a.Users_ID AND a.SportsType_ID = '".$sport."' {$search_cond}");
				}
				else{
					$qry_check = $this->db->query("SELECT * FROM Users WHERE Country IN (SELECT Country FROM Users WHERE Users_ID = '".$user_id."'){$search_cond} ORDER BY Users_ID OFFSET {$offset} ROWS FETCH NEXT {$limit} ROWS ONLY");

					$tot_users_qry = $this->db->query("SELECT COUNT(*) AS tot_users FROM Users WHERE Country IN (SELECT Country FROM Users WHERE Users_ID = '".$user_id."'){$search_cond}");
					//echo $this->db->last_query();
				}
			}
		}
		else{
			if($user_id != '' and $is_sort and $sport != ''){
				$qry_check = $this->db->query("SELECT (SELECT MAX(MaxValue) FROM (VALUES (a.A2MScore),(a.A2MScore_Doubles),(a.A2MScore_Mixed)) AS Value(MaxValue)) AS A2MScore, u.* FROM Users u JOIN A2MScore a ON u.Users_ID = a.Users_ID AND a.SportsType_ID = '".$sport."' ORDER BY A2MScore {$is_sort} OFFSET {$offset} ROWS FETCH NEXT {$limit} ROWS ONLY");

				$tot_users_qry = $this->db->query("SELECT COUNT(*) AS tot_users FROM Users u JOIN A2MScore a ON u.Users_ID = a.Users_ID AND a.SportsType_ID = '".$sport."'");
			}
			else{
				$qry_check = $this->db->query("SELECT * FROM Users ORDER BY Users_ID OFFSET {$offset} ROWS FETCH NEXT {$limit} ROWS ONLY");

				$tot_users_qry = $this->db->query("SELECT COUNT(*) AS tot_users FROM Users");
			}
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

			$a2mscore = NULL;
		if($user['A2MScore'] != '')
			$a2mscore = $user['A2MScore'];

			$revised_arr['results'][] =  
			array(
				"id"				=> $user['Users_ID'],
				"Firstname"	=> $user['Firstname'],
				"Lastname"		=> $user["Lastname"],
				"Profilepic"		=> $prof_pic,
				"A2MScore"		=> $a2mscore,
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

	public function get_limit_coachUsers($user_id, $page, $limit, $search, $is_sort, $sport) {

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

	public function get_club_members($club_id, $page, $limit, $search, $is_sort, $sport) {

$offset_qry = "";

if($page != ''){
$offset = ($page * $limit) - $limit;
$offset_qry = " OFFSET {$offset} ROWS FETCH NEXT {$limit} ROWS ONLY";
}

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
		if($search['sp_level'])
			$search_cond .= " AND u.Users_ID in (SELECT users_id FROM Sports_Interests WHERE Sport_id = {$search['sport']} AND Level = {$search['sp_level']})";
		else
			$search_cond .= " AND u.Users_ID in (SELECT users_id FROM Sports_Interests WHERE Sport_id = {$search['sport']})";
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
		if($club_id != '' and $is_sort and $sport != ''){			
			$qry_check = $this->db->query("SELECT (SELECT MAX(MaxValue) FROM (VALUES (a.A2MScore),(a.A2MScore_Doubles),(a.A2MScore_Mixed)) AS Value(MaxValue)) AS A2MScore, u.* FROM Users u JOIN A2MScore a ON u.Users_ID = a.Users_ID AND a.SportsType_ID = '".$sport."' WHERE u.Users_ID IN (SELECT Users_id FROM User_memberships WHERE Member_Status =1 AND Club_id = {$club_id}){$search_cond} ORDER BY A2MScore {$is_sort} {$offset_qry}");

			$tot_users_qry = $this->db->query("SELECT COUNT(*) AS tot_users FROM Users u WHERE u.Users_ID IN (SELECT Users_id FROM User_memberships WHERE Member_Status =1 AND Club_id = {$club_id}){$search_cond}");
		}
		else if($club_id != ''){			
			/*$qry_check = $this->db->query("SELECT * FROM Users WHERE Users_ID IN (SELECT Users_id FROM User_memberships WHERE Club_id = {$club_id}){$search_cond} ORDER BY Users_ID OFFSET {$offset} ROWS FETCH NEXT {$limit} ROWS ONLY");*/
			$qry_check = $this->db->query("SELECT * FROM Users u WHERE u.Users_ID IN (SELECT Users_id FROM User_memberships WHERE Member_Status =1 AND Club_id = {$club_id}){$search_cond} ORDER BY Users_ID{$offset_qry}");

			$tot_users_qry = $this->db->query("SELECT COUNT(*) AS tot_users FROM Users u WHERE u.Users_ID IN (SELECT Users_id FROM User_memberships WHERE Member_Status =1 AND  Club_id = {$club_id}){$search_cond}");
		}


		//echo $this->db->last_query();
		//exit;
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
			$a2mscore = NULL;
		if($user['A2MScore'] != '')
			$a2mscore = $user['A2MScore'];

			$revised_arr['results'][] =  
			array(
				"id"						=> $user['Users_ID'],
				"Firstname"		=> $user['Firstname'],
				"Lastname"		=> $user["Lastname"],
				"Profilepic"		=> $prof_pic,
				"A2MScore"		=> $a2mscore,
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


	public function get_club_coaches($club_id, $page, $limit, $search, $is_sort, $sport) {

		$offset = ($page * $limit) - $limit;

$search_cond = ' AND Is_coach = 1';

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
		if($club_id != '' and $is_sort and $sport != ''){			
			$qry_check = $this->db->query("SELECT (SELECT MAX(MaxValue) FROM (VALUES (a.A2MScore),(a.A2MScore_Doubles),(a.A2MScore_Mixed)) AS Value(MaxValue)) AS A2MScore, u.* FROM Users u JOIN A2MScore a ON u.Users_ID = a.Users_ID AND a.SportsType_ID = '".$sport."' WHERE coach_academy = {$club_id}{$search_cond} ORDER BY A2MScore {$is_sort} OFFSET {$offset} ROWS FETCH NEXT {$limit} ROWS ONLY");

			$tot_users_qry = $this->db->query("SELECT COUNT(*) AS tot_users FROM Users WHERE coach_academy = {$club_id}{$search_cond}");
		}
		else if($club_id != ''){			
			$qry_check = $this->db->query("SELECT * FROM Users WHERE coach_academy = {$club_id}{$search_cond} ORDER BY Users_ID OFFSET {$offset} ROWS FETCH NEXT {$limit} ROWS ONLY");

			$tot_users_qry = $this->db->query("SELECT COUNT(*) AS tot_users FROM Users WHERE coach_academy = {$club_id}{$search_cond}");
		}


		/*echo $this->db->last_query();
		exit;*/
			$tot_users_res	= $tot_users_qry->result_array();
			$tot_users			= $tot_users_res[0]['tot_users'];

			$tot_pages = ceil($tot_users / $limit);
			//$tot_pages = $tot_users;

		//echo $this->db->last_query();
		$users = $qry_check->result_array();

		$a2mscore = NULL;
		if($user['A2MScore'] != '')
		$a2mscore = $user['A2MScore'];

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
				"id"						=> $user['Users_ID'],
				"Firstname"		=> $user['Firstname'],
				"Lastname"		=> $user["Lastname"],
				"Profilepic"		=> $prof_pic,
				"A2MScore"		=> $a2mscore,
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

	public function get_userToken_team($team_id){
		$qry_team = $this->db->query("SELECT * FROM Teams WHERE Team_ID = {$team_id}");
		$get_team = $qry_team->row_array();
		$team_players = json_decode($get_team['Players'], TRUE);
		if($team_players){
			foreach($team_players as $player){
				if($player){
				$data	= array('user_id' => $player, 'status' => 1, 'club_id' => NULL);
				$query = $this->db->get_where('userPushTokens', $data);
				$user_tokens = $query->result();			

				if($user_tokens){
					foreach($user_tokens as $i => $ut){
						$tokens_arr[] = $ut->token;
					}
				}
				}
			}
			
		}
	
		return $tokens_arr;
	}

	public function get_userToken_tournament($tourn_id){
		$qry_reg_tourn = $this->db->query("SELECT * FROM RegisterTournament WHERE Tournament_ID = {$tourn_id}");
		$get_reg_users = $qry_reg_tourn->result();
//echo "<pre>"; print_r($get_reg_users);
		if($get_reg_users){
			foreach($get_reg_users as $player){
				$data	= array('user_id' => $player->Users_ID, 'status' => 1, 'club_id' => NULL);
				$query = $this->db->get_where('userPushTokens', $data);
				$user_tokens = $query->result();			

				if($user_tokens){
					foreach($user_tokens as $i => $ut){
						$tokens_arr[] = $ut->token;
					}
				}
			}
		}

		$qry_reg_tourn2 = $this->db->query("SELECT * FROM tournament WHERE tournament_ID = {$tourn_id}");
		$get_reg_users2 = $qry_reg_tourn2->row_array();
//echo "<pre>"; print_r($get_reg_users);
		if($get_reg_users2){
				$data	= array('user_id' => $get_reg_users2['Usersid'], 'status' => 1, 'club_id' => NULL);
				$query = $this->db->get_where('userPushTokens', $data);
				$user_tokens2 = $query->result();			

				if($user_tokens2){
					foreach($user_tokens2 as $i => $ut){
						$tokens_arr[] = $ut->token;
					}
				}
		}
	

		return $tokens_arr;
	}

	public function get_userToken_a2m($user_id){
		$data	= array('user_id' => $user_id, 'status' => 1, 'club_id' => NULL);
		$query = $this->db->get_where('userPushTokens', $data);
		return $query->result();
	}

	public function get_userToken($user_id){
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

			$mphone = NULL;
			if($data2['mphone'])
			$mphone	= $data2['mphone'];

			$gender = NULL;
			if($data2['gender'] == '1' or $data2['gender'] == '0')
			$gender	= $data2['gender'];
			
			$email = NULL;
			if($data2['email'])
			$email	= $data2['email'];

			$sp_int		= $data2['sp_int'];
			$club_id		= $data2['club_id'];
			/*$zipcode    = $this->input->post('Zipcode');
			$sportstype = $this->input->post('sportstype');
			
			if(!$sportstype){
				$sportstype = 10;
			}*/
			
			$sportstype = array(1,2,3,7,19,20);
			$str	   = md5($lastname . $email);
			$auth_code = substr($str, 0, 8);
			$sp_code   = substr(base64_encode('instant'), 0, 4);
			
			$code = $auth_code . '_' . $sp_code;

			$data = array(
					'Firstname'		    => $firstname,
					'Lastname'		    => $lastname,
					'Password'		    => $password,
					'EmailID'				=> $email,
					'Mobilephone'	    => $mphone,
					'Gender'				=> $gender,
					//'Zipcode'           => $zipcode ,
					//'Latitude'          => $latitude ,
					//'Longitude'         => $longitude ,
					'IsUserActivation'	=> 1,
					'ActivationCode'		=> $code,
					'RegistrationDtTm' => $reg_date,
					'Reg_Source'			=> "APP"
					);

			$this->db->insert('Users', $data);
		    $insert_id = $this->db->insert_id();

			if($insert_id){
				$user_det = array(
					'firstname'	=> $firstname,
					'lastname'   => $lastname,
					'email'			=> $email,
					//'phone'     => $phone,
					'act_code'  => $code,
					'users_id'	=> $insert_id);

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
							$def_score = 100;
				if($sp == '2') 
				$def_score = 800;
				if($sp == '7' or $sp == '19' or $sp == '20') 
				$def_score = 3.0;

			$data = array(
						'SportsType_ID'  => $sp, 
						'Users_ID'			=> $user, 
						'A2MScore'		    => $def_score,
						'A2MScore_Doubles' => $def_score,
						'A2MScore_Mixed'   => $def_score
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

		public function get_user_gen_stats($user_id){
				$qr_check = $this->db->query("SELECT * FROM GeneralMatch WHERE users_id = {$user_id}");
			return $qr_check->result();
		}

		public function get_user_indv_stats($user_id){
				$qr_check = $this->db->query("SELECT * FROM GeneralMatch WHERE GeneralMatch_id IN 
				(SELECT GeneralMatch_ID FROM IndividualPlay WHERE Opponent = {$user_id})");
			return $qr_check->result();
		}

		public function get_user_indvMatch($match_id){
				$qr_check = $this->db->query("SELECT * FROM IndividualPlay WHERE GeneralMatch_ID = {$match_id}");
			return $qr_check->result();
		}

		public function get_user_single_stats($user_id, $sp_intrests){
			if($sp_intrests != '()'){
				$qr_check = $this->db->query("SELECT t.SportsType,* FROM Tournament_Matches AS tm JOIN tournament AS t ON t.tournament_ID = tm.Tourn_ID WHERE t.SportsType IN {$sp_intrests} AND (tm.Player1 = {$user_id} OR tm.Player1_Partner = {$user_id} OR tm.Player2 = {$user_id} OR tm.Player2_Partner = {$user_id}) ORDER BY t.SportsType");
			}
			else{
				$qr_check = $this->db->query("SELECT t.SportsType,* FROM Tournament_Matches AS tm JOIN tournament AS t ON t.tournament_ID = tm.Tourn_ID WHERE tm.Player1 = {$user_id} OR tm.Player1_Partner = {$user_id} OR tm.Player2 = {$user_id} OR tm.Player2_Partner = {$user_id} ORDER BY t.SportsType");
			//echo $this->db->last_query();
			}
			//echo $this->db->last_query();

	
			return $qr_check->result();
		}


		public function get_user_line_stats($user_id, $sp_intrests){
		
			if($sp_intrests != '()'){
				$qr_check = $this->db->query("SELECT t.SportsType,* FROM Tournament_Lines AS tm JOIN tournament AS t ON t.tournament_ID = tm.Tourn_ID WHERE t.SportsType IN {$sp_intrests} AND (tm.Player1 = {$user_id} OR tm.Player1_Partner = {$user_id} OR tm.Player2 = {$user_id} OR tm.Player2_Partner = {$user_id}) ORDER BY t.SportsType");
			}
			else{
				$qr_check = $this->db->query("SELECT t.SportsType,* FROM Tournament_Lines AS tm JOIN tournament AS t ON t.tournament_ID = tm.Tourn_ID WHERE tm.Player1 = {$user_id} OR tm.Player1_Partner = {$user_id} OR tm.Player2 = {$user_id} OR tm.Player2_Partner = {$user_id} ORDER BY t.SportsType");
			}
			//echo $this->db->last_query();
			return $qr_check->result();
		}

		public function get_user_a2m_ranks($user_id){
				//$qr_check = $this->db->query("select *, RANK() OVER(PARTITION BY SportsType_ID ORDER BY A2MScore DESC) Rank from A2MScore order by A2MScore desc");
				$qr_check = $this->db->query("SELECT *, RANK() OVER(PARTITION BY SportsType_ID ORDER BY A2MScore DESC) Rank from A2MScore 
  where Users_ID in (SELECT Users_ID from Users where State = (SELECT State from Users where Users_ID = {$user_id})) order by A2MScore desc");
				return $qr_check->result_array();
		}

		public function get_user_a2m_ranks_city($user_id){
				//$qr_check = $this->db->query("select *, RANK() OVER(PARTITION BY SportsType_ID ORDER BY A2MScore DESC) Rank from A2MScore order by A2MScore desc");
				$qr_check = $this->db->query("SELECT *, RANK() OVER(PARTITION BY SportsType_ID ORDER BY A2MScore DESC) Rank from A2MScore 
  where Users_ID in (SELECT Users_ID from Users where City = (SELECT City from Users where Users_ID = {$user_id})) order by A2MScore desc");
				return $qr_check->result_array();
		}

	  public function get_winper($sport, $user_id){
			$data	   = array('Sport' => $sport, 'Users_ID' => $user_id);
			$get_level = $this->db->get_where('Player_Matches_Count', $data);
			return $get_level->row_array();
		}

		public function get_user_matches($user_id){
				$qr_check = $this->db->query("select isnull(IIF(pl1.Firstname is null and winner <> 0 , 'BYE', pl1.Firstname) , ' ') as Player1FirstName , 
				isnull(IIF(pl1.LastName is null and winner <> 0 , ' ', pl1.LastName) , ' ') as Player1LastName, isnull(IIF(pl2.Firstname is null and winner <> 0 , 'BYE', pl2.Firstname) , ' ') as Player2FirstName, isnull(IIF(pl2.LastName is null and winner <> 0 , ' ', pl2.LastName) , ' ') as Player2LastName, pr1.Firstname as Partner1FirstName , pr1.LastName as Partner1LastName, pr2.Firstname as Partner2FirstName, pr2.LastName as Partner2LastName ,t.* , tm.* from tournament t inner join RegisterTournament rt on rt.Tournament_ID = t.tournament_ID left outer join Tournament_Matches tm on tm.Tourn_ID = t.tournament_ID left outer join users pl1 on tm.Player1 = pl1.Users_ID left outer join users pl2 on tm.Player2 = pl2.Users_ID left outer join users pr1 on tm.Player1_Partner = pr1.Users_ID left outer join users pr2 on tm.Player2_partner = pr2.Users_ID where (tm.Player1 = '{$user_id}' or tm.Player2 = '{$user_id}' or tm.Player1_Partner = '{$user_id}' or tm.Player2_Partner = '{$user_id}' or tm.Player1 is null ) and rt.users_id = '{$user_id}' order by t.StartDate desc");
				return $qr_check->result_array();
		}

	public function get_past_coach_bookings($user_id, $user_time){
		//$today = date('Y-m-d');
		$time   = date('H:i:s');
		$query = $this->db->query("SELECT * FROM Coach_Bookings WHERE reserved_by = {$user_id} 
		AND (res_date < '".$user_time."') AND res_status = 'Active' ORDER BY res_date DESC");
		//echo $this->db->last_query();exit;
		return $query->result();
	}

	public function get_upc_coach_bookings($user_id, $user_time){
		//$today = date('Y-m-d');
		$time   = date('H:i:s');
		$query = $this->db->query("SELECT * FROM Coach_Bookings WHERE reserved_by = {$user_id} 
		AND ((res_date = '".$user_time."' AND from_time >= '".$time."' ) OR (res_date >= '".$user_time."')) AND res_status = 'Active' ORDER BY res_date DESC");
		//echo $this->db->last_query();exit;
		return $query->result();
	}

	public function get_past_court_bookings($user_id, $user_time){
		//$today = date('Y-m-d');
		$time   = date('H:i:s');
		$query = $this->db->query("SELECT * FROM Academy_Court_Reservations WHERE reserved_by = {$user_id} AND (res_date < '".$user_time."') AND res_status = 'Active' ORDER BY res_date DESC");
		//echo $this->db->last_query();
		return $query->result();
	}

	public function get_upc_court_bookings($user_id, $user_time){
		//$today = date('Y-m-d');
		$time   = date('H:i:s');
		$query = $this->db->query("SELECT * FROM Academy_Court_Reservations WHERE reserved_by = {$user_id} AND ((res_date = '".$user_time."' AND from_time >= '".$time."' ) OR (res_date >= '".$user_time."')) AND res_status = 'Active' ORDER BY res_date DESC");
		//echo $this->db->last_query();
		return $query->result();
	}

	public function get_loc_info($loc_id) {
		$data = array('loc_id' => $loc_id);
		$query = $this->db->get_where('Academy_Court_Locations', $data);
		return $query->row_array();
	}

	public function get_court_info($court_id) {
		$data = array('court_id' => $court_id);
		$query = $this->db->get_where('Academy_Courts', $data);
		return $query->row_array();
	}

	public function get_academy_info($aca_id) {
		$data = array('Aca_ID' => $aca_id);
		$query = $this->db->get_where('Academy_Info', $data);
		return $query->row_array();
	}

	public function check_is_user_exists($type, $value){
		
		switch($type){
			case 'email':
				$res = $this->db->query("SELECT * FROM Users WHERE EmailID = '{$value}'");
			break;
			case 'phone':
				$v1 = substr($value, 2);
				$v2 = substr($value, 1);
				$v3 = substr($value, 0);
				$v4 = substr($value, 3);

			//var_dump($value);
			/*echo "value = ".$value."<br>";
			echo "v1 = ".$v1."<br>";
			echo "v2 = ".$v2."<br>";
			echo "v3 = ".$v3."<br>";
			echo "v4 = ".$v4; 
			exit;*/
				$res = $this->db->query("SELECT * FROM Users WHERE (Mobilephone = '{$value}' OR Mobilephone LIKE '%{$value}' OR Mobilephone LIKE '%{$v1}' OR Mobilephone LIKE '%{$v2}' OR Mobilephone LIKE '%{$v3}' OR Mobilephone LIKE '%{$v4}')");
			break;
			default:
				$res = '';
		}

		if($res->num_rows)
			return true;
		else
			return false;
	}

}