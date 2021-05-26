<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class model_club extends CI_Model {

	public $req_method;
	public $country_arr;
	public $country_str;

	public function __construct(){
		parent:: __construct();
		$this->load->database();

		if($this->input->server('REQUEST_METHOD') == 'GET'){
			$this->req_method = 'get';
		}
		else if($this->input->server('REQUEST_METHOD') == 'POST'){
			$this->req_method = 'post';
		}

		$this->country_arr = array('United States of America', 'USA', 'US', 'United States');
		$this->country_str = "('United States of America', 'USA', 'US', 'United States')";
	}

	public function AddClub($data){
		$ins = $this->db->insert('Academy_Info', $data);			
		return $ins;		
	}

	public function check_reserve_court($data){
		$query = $this->db->query("SELECT * FROM Academy_Court_Reservations WHERE court_id = {$data['court_id']} 
		AND res_date = '".$data['res_date']."' AND (from_time = '".$data['from_time']."' OR to_time = '".$data['to_time']."') AND res_status = 'Active'");
		if($query->num_rows() > 0){
			return -1;
			exit;
		}
	
		$res = $this->db->insert('Academy_Court_Reservations', $data);
		return $res;
	}

	public function reserve_court($data){
		$res = $this->db->insert('Academy_Court_Reservations', $data);
		return $res;
	}

	public function check_sharable($court){
		$get_court =	$this->db->query("SELECT * FROM Academy_Courts WHERE court_id = {$court}");
		$det			= $get_court->row_array();
		return $det;
	}

	public function get_clubs($user_id=''){

		if($user_id){
		$get_user =	$this->db->query("SELECT Country FROM Users WHERE Users_ID = {$user_id}");
		$det	  = $get_user->row_array();
		}

		if($user_id and $det['Country']){
			if(in_array($det['Country'], $this->country_arr)){
				$query = $this->db->query("SELECT * FROM Academy_Info WHERE Aca_country IN {$this->country_str}");
			}
			else{
				$query = $this->db->query("SELECT * FROM Academy_Info WHERE Aca_country = '{$det['Country']}'");
			}
		}
		else{
			$query = $this->db->query("SELECT * FROM Academy_Info");
		}
		return $query->result();
	}

	public function get_limit_clubs($user_id='', $page, $limit, $search){
		$offset = ($page * $limit) - $limit;
		$search_cond = '';

		if(count($search) > 0){

			if($search['city'] and !$search['state']){
				$search_cond = " WHERE Aca_city LIKE '{$search['city']}%'";
			}
			else if(!$search['city'] and $search['state']){
				$search_cond = " WHERE Aca_state LIKE '{$search['state']}%'";
			}
			else if($search['city'] and $search['state']){
				$search_cond = " WHERE Aca_city LIKE '{$search['city']}%' AND Aca_state LIKE '{$search['state']}%'";
			}

			if(($search['city'] or $search['state']) and $search['name']){
				$search_cond .= " AND Aca_name LIKE '%{$search['name']}%'";
			}
			else if($search['name']){
				$search_cond .= " WHERE Aca_name LIKE '%{$search['name']}%'";
			}

			if(($search['city'] or $search['state'] or $search['name']) and $search['sport']){
				$search_cond .= " AND Aca_sport LIKE '%".'"'.$search['sport'].'"'."%'";
			}
			else if($search['sport']){
				$search_cond .= " WHERE Aca_sport LIKE '%".'"'.$search['sport'].'"'."%'";
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

			if(($search['city'] or $search['state'] or $search['name'] or $search['sport']) and $search['distance']){
				$search_cond .= " AND ACOS( SIN( RADIANS( Latitude )) * SIN( RADIANS( {$lat} ) ) + COS( RADIANS( Latitude ) ) * COS( RADIANS( {$lat} )) *  COS( RADIANS( Longitude ) - RADIANS( {$long})) ) * 3964.3 < ".$search['distance'];
			}
			else if($search['distance']){
				$search_cond .= " WHERE ACOS( SIN( RADIANS( Latitude )) * SIN( RADIANS( {$lat} ) ) + COS( RADIANS( Latitude ) ) * COS( RADIANS( {$lat} )) *  COS( RADIANS( Longitude ) - RADIANS( {$long})) ) * 3964.3 < ".$search['distance'];
			}

		}



		if($user_id and $search_cond == ''){
			if($user_id){
			$get_user =	$this->db->query("SELECT Country FROM Users WHERE Users_ID = {$user_id}");
			$det	  = $get_user->row_array();
			}


			if(in_array($det['Country'], $this->country_arr)){
				//$query = $this->db->query("SELECT * FROM Academy_Info WHERE Aca_country IN {$this->country_str}");
				$query = $this->db->query("SELECT * FROM Academy_Info WHERE Aca_country IN {$this->country_str} ORDER BY Aca_name 
				OFFSET {$offset} ROWS FETCH NEXT {$limit} ROWS ONLY");

				$qry_total = $this->db->query("SELECT * FROM Academy_Info WHERE Aca_country IN {$this->country_str} ORDER BY Aca_name");
			}
			else{
				$query = $this->db->query("SELECT * FROM Academy_Info WHERE Aca_country = '{$det['Country']}' ORDER BY Aca_name 
				OFFSET {$offset} ROWS FETCH NEXT {$limit} ROWS ONLY");

				$qry_total = $this->db->query("SELECT * FROM Academy_Info WHERE Aca_country = '{$det['Country']}' ORDER BY Aca_name");
			}
		}
		/*else if($user_id and $search_cond != ''){
			$query = $this->db->query("SELECT * FROM Academy_Info{$search_cond} ORDER BY Aca_name OFFSET {$offset} ROWS FETCH NEXT {$limit} ROWS ONLY");

			$qry_total = $this->db->query("SELECT * FROM Academy_Info{$search_cond} ORDER BY Aca_name OFFSET {$offset} ROWS FETCH NEXT {$limit} ROWS ONLY");
		}*/
		else if($user_id and $search_cond != ''){
			if($user_id){
			$get_user =	$this->db->query("SELECT Country FROM Users WHERE Users_ID = {$user_id}");
			$det	  = $get_user->row_array();
			}

			if(in_array($det['Country'], $this->country_arr)){
				//$query = $this->db->query("SELECT * FROM Academy_Info WHERE Aca_country IN {$this->country_str}");
				$query = $this->db->query("SELECT * FROM Academy_Info{$search_cond} AND Aca_country IN {$this->country_str} ORDER BY Aca_name OFFSET {$offset} ROWS FETCH NEXT {$limit} ROWS ONLY");

				$qry_total = $this->db->query("SELECT * FROM Academy_Info{$search_cond} AND Aca_country IN {$this->country_str} ORDER BY Aca_name");
			}
			else{
				$query = $this->db->query("SELECT * FROM Academy_Info{$search_cond} AND Aca_country = '{$det['Country']}' ORDER BY Aca_name OFFSET {$offset} ROWS FETCH NEXT {$limit} ROWS ONLY");

				$qry_total = $this->db->query("SELECT * FROM Academy_Info{$search_cond} AND Aca_country = '{$det['Country']}' ORDER BY Aca_name");
			}
		}
		else{
			$query	   = $this->db->query("SELECT * FROM Academy_Info ORDER BY Aca_name OFFSET {$offset} ROWS FETCH NEXT {$limit} ROWS ONLY");
			$qry_total = $this->db->query("SELECT * FROM Academy_Info ORDER BY Aca_name");
		}

		$total = $qry_total->num_rows();
		$total_pages = ceil($total / $limit);

		$results[0]  = $query->result();
		$results[1] = $total_pages;
/*echo "<pre>";
echo $this->db->last_query();
//print_r($qry_total->num_rows());
exit;*/
		return $results;
	}

	public function get_limit_pnpClubs($user_id='', $page, $limit, $search){
		$offset = ($page * $limit) - $limit;
		$search_cond = '';

		if(count($search) > 0){

			if($search['city'] and !$search['state']){
				$search_cond = " AND Aca_city LIKE '{$search['city']}%'";
			}
			else if(!$search['city'] and $search['state']){
				$search_cond = " AND Aca_state LIKE '{$search['state']}%'";
			}
			else if($search['city'] and $search['state']){
				$search_cond = " AND Aca_city LIKE '{$search['city']}%' AND Aca_state LIKE '{$search['state']}%'";
			}

			if($search['name']){
				$search_cond .= " AND Aca_name LIKE '%{$search['name']}%'";
			}

			if($search['sport']){
				$search_cond .= " AND Aca_sport LIKE '%".'"'.$search['sport'].'"'."%'";
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


		if($user_id and $search_cond == ''){
			if($user_id){
				$get_user  = $this->db->query("SELECT Country FROM Users WHERE Users_ID = {$user_id}");
				$det			= $get_user->row_array();
			}

			if(in_array($det['Country'], $this->country_arr)){
				$query = $this->db->query("SELECT * FROM Academy_Info WHERE Aca_country IN {$this->country_str} AND Aca_ID IN (SELECT org_id FROM Academy_Court_Locations) ORDER BY Aca_name OFFSET {$offset} ROWS FETCH NEXT {$limit} ROWS ONLY");

				$qry_total = $this->db->query("SELECT * FROM Academy_Info WHERE Aca_country IN {$this->country_str} AND Aca_ID IN (SELECT org_id FROM Academy_Court_Locations) ORDER BY Aca_name");
			}
			else{
				$query = $this->db->query("SELECT * FROM Academy_Info WHERE Aca_country = '{$det['Country']}' AND Aca_ID IN (SELECT org_id FROM Academy_Court_Locations) ORDER BY Aca_name OFFSET {$offset} ROWS FETCH NEXT {$limit} ROWS ONLY");

				$qry_total = $this->db->query("SELECT * FROM Academy_Info WHERE Aca_country = '{$det['Country']}' AND Aca_ID IN (SELECT org_id FROM Academy_Court_Locations) ORDER BY Aca_name");
			}
		}
		/*else if($user_id and $search_cond != ''){
			$query = $this->db->query("SELECT * FROM Academy_Info{$search_cond} ORDER BY Aca_name OFFSET {$offset} ROWS FETCH NEXT {$limit} ROWS ONLY");

			$qry_total = $this->db->query("SELECT * FROM Academy_Info{$search_cond} ORDER BY Aca_name OFFSET {$offset} ROWS FETCH NEXT {$limit} ROWS ONLY");
		}*/
		else if($user_id and $search_cond != ''){
			if($user_id){
			$get_user =	$this->db->query("SELECT Country FROM Users WHERE Users_ID = {$user_id}");
			$det	  = $get_user->row_array();
			}

			if(in_array($det['Country'], $this->country_arr)){
				//$query = $this->db->query("SELECT * FROM Academy_Info WHERE Aca_country IN {$this->country_str}");
				$query = $this->db->query("SELECT * FROM Academy_Info WHERE Aca_ID IN (SELECT org_id FROM Academy_Court_Locations){$search_cond} AND Aca_country IN {$this->country_str} ORDER BY Aca_name OFFSET {$offset} ROWS FETCH NEXT {$limit} ROWS ONLY");

				$qry_total = $this->db->query("SELECT * FROM Academy_Info WHERE Aca_ID IN (SELECT org_id FROM Academy_Court_Locations){$search_cond} AND Aca_country IN {$this->country_str} ORDER BY Aca_name");
			}
			else{
				$query = $this->db->query("SELECT * FROM Academy_Info WHERE Aca_ID IN (SELECT org_id FROM Academy_Court_Locations){$search_cond} AND Aca_country = '{$det['Country']}' ORDER BY Aca_name OFFSET {$offset} ROWS FETCH NEXT {$limit} ROWS ONLY");

				$qry_total = $this->db->query("SELECT * FROM Academy_Info WHERE Aca_ID IN (SELECT org_id FROM Academy_Court_Locations){$search_cond} AND Aca_country = '{$det['Country']}' ORDER BY Aca_name");
			}
		}
		else{
			$query	   = $this->db->query("SELECT * FROM Academy_Info ORDER BY Aca_name OFFSET {$offset} ROWS FETCH NEXT {$limit} ROWS ONLY");
			$qry_total = $this->db->query("SELECT * FROM Academy_Info ORDER BY Aca_name");
		}

		$total = $qry_total->num_rows();
		$total_pages = ceil($total / $limit);

		$results[0]  = $query->result();
		$results[1]  = $total_pages;
/*
//echo "<pre>";
echo $this->db->last_query();
//print_r($qry_total->num_rows());
exit;
*/
		return $results;
	}

	public function get_user_details($user_id) {
		$qry_check = $this->db->query("SELECT * FROM Users WHERE Users_ID = '".$user_id."'");
		return $qry_check->row_array();
	}

	public function get_clubs_having_courts($user_id = ''){

		if($user_id){
		$get_user =	$this->db->query("SELECT Country FROM Users WHERE Users_ID = {$user_id}");
		$det	  = $get_user->row_array();
		}

		if($user_id and $det['Country']){
			if(in_array($det['Country'], $this->country_arr)){
				//$query = $this->db->query("SELECT * FROM Academy_Info WHERE Aca_country IN {$this->country_str}");
			$query = $this->db->query("SELECT * FROM Academy_Info WHERE Aca_country IN {$this->country_str} AND Aca_URL_ShortCode IS NOT NULL AND Aca_ID IN (SELECT org_id FROM Academy_Court_Locations)");
			}
			else{
			$query = $this->db->query("SELECT * FROM Academy_Info WHERE Aca_country = '{$det['Country']}' AND Aca_URL_ShortCode IS NOT NULL AND Aca_ID IN (SELECT org_id FROM Academy_Court_Locations)");
			}
		}
		else{
			$query = $this->db->query("SELECT * FROM Academy_Info WHERE Aca_URL_ShortCode IS NOT NULL AND Aca_ID IN (SELECT org_id FROM Academy_Court_Locations)");
		}

		//echo $this->db->last_query();
		return $query->result();
	}

	public function is_clubs_having_courts($club_id){
			$query = $this->db->query("SELECT * FROM Academy_Info WHERE Aca_URL_ShortCode IS NOT NULL AND Aca_ID = {$club_id}");

			return $query->num_rows();
	}

	public function get_clubs_locations($club_id){
		$query = $this->db->query("SELECT * FROM Academy_Court_Locations WHERE org_id = {$club_id} AND status = 1");
		return $query->result();
	}

	public function get_club($club_id){
		$query = $this->db->query("SELECT * FROM Academy_Info WHERE Aca_ID = {$club_id}");
		return $query->row_array();
	}

	public function get_club_ratings($club_id){
		$query = $this->db->query("SELECT * FROM Club_Ratings WHERE Club_ID = {$club_id}");
		return $query->result();
	}

	public function get_loc_courts($loc_id){
		$query = $this->db->query("SELECT * FROM Academy_Courts WHERE loc_id = {$loc_id} AND status = 1");
		return $query->result();
	}

	public function get_member_discount($loc_id){
		$query = $this->db->query("SELECT * FROM Academy_Court_Locations WHERE loc_id = {$loc_id}");
		return $query->row_array();
	}

	public function get_court_info($court_id){
		$query = $this->db->query("SELECT * FROM Academy_Courts WHERE court_id = {$court_id} AND status = 1");
		return $query->row_array();
	}

	public function get_court_prices($court_id){
		$query = $this->db->query("SELECT * FROM Academy_Courts_Price WHERE Aca_Court_ID = {$court_id}");
		//echo $this->db->last_query();
		return $query->result();
	}

	public function get_court_bookings($court_id){
		$today = date('Y-m-d');
		$time   = date('H:i:s');
		$query = $this->db->query("SELECT * FROM Academy_Court_Reservations WHERE court_id = {$court_id} 
		AND ((res_date = '".$today."' AND from_time >= '".$time."' ) OR (res_date >= '".$today."')) AND res_status = 'Active'");
		//echo $this->db->last_query();
		return $query->result();
	}

	public function get_user_court_bookings($court_id, $user_id){
		$today = date('Y-m-d');
		$time  = date('H:i:s');
		$query = $this->db->query("SELECT * FROM Academy_Court_Reservations WHERE court_id = {$court_id} 
		AND reserved_by = {$user_id} AND res_date >= '".$today."' AND from_time >= '".$time."' AND res_status = 'Active'");
		//echo $this->db->last_query();
		return $query->result();
	}

	public function get_user_bookings($user_id){
		$today = date('Y-m-d');
		$time  = date('H');
		$time = $time.':00:00';
		/*$query = $this->db->query("SELECT * FROM Academy_Court_Reservations WHERE reserved_by = {$user_id} 
		AND res_date >= '".$today."' AND from_time >= '".$time."'");*/

$query = $this->db->query("SELECT ac.court_name,acl.location,acl.address,acl.city,acl.state,acl.country,acr.* FROM 
Academy_Court_Reservations as acr 
JOIN 
Academy_Court_Locations as acl 
ON 
acr.loc_id = acl.loc_id 
JOIN Academy_Courts as ac
ON 
acr.court_id = ac.court_id
WHERE acr.reserved_by = {$user_id} 
AND acr.res_date >= '".$today."' AND res_status != 'Canceled' ORDER BY
acr.res_date ASC");

		//echo $this->db->last_query();
		return $query->result();
	}

	public function is_club_member($user_id, $club_id){
		$query1 = $this->db->query("SELECT * FROM Academy_Court_Locations WHERE loc_id = {$club_id}");
		$res	= $query1->row_array();
		if($res){
			$org_id = $res['org_id'];
			$query2 = $this->db->query("SELECT * FROM User_memberships WHERE Club_id = {$org_id} AND Users_id = {$user_id} AND Member_Status = 1");
			return $query2->num_rows();
		}
		else{
			return 0;
		}
	}

	public function cancel_res($booking_id){
		$query = $this->db->query("UPDATE Academy_Court_Reservations SET res_status = 'Canceled' WHERE res_id = {$booking_id}");
		//echo $this->db->last_query();
		return $query;
	}

	public function get_club_members($club_id){
		$query = $this->db->query("SELECT * FROM User_memberships as um JOIN Users as u ON um.Users_id = u.Users_ID WHERE um.Club_id = {$club_id}");
		return $query->result_array();
	}

	public function get_club_coaches($club_id){
		$query = $this->db->query("SELECT * FROM Users as u JOIN SportsType as st on u.coach_sport = st.SportsType_ID WHERE u.coach_academy = {$club_id}");
		return $query->result();
	}

	public function is_enrolled($user_id, $club_id){
		$query = $this->db->query("SELECT * FROM User_memberships WHERE Users_id = {$user_id} AND Club_id = {$club_id}");
		return $query->row_array();
	}

	public function insert_notif($data){
		$query = $this->db->insert('Mobile_Notifications', $data);
		return $query;
	}

	public function get_userToken($user_id) {
		$data  = array('user_id' => $user_id, 'status' => 1);
		$query = $this->db->get_where('userPushTokens', $data);
		return $query->result();
	}

}