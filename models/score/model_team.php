<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class model_team extends CI_Model {

	public $req_method;

	public function __construct(){
		parent:: __construct();
		$this->load->database();

		if($this->input->server('REQUEST_METHOD') == 'GET'){
			$this->req_method = 'get';
		}
		else if($this->input->server('REQUEST_METHOD') == 'POST'){
			$this->req_method = 'post';
		}
	}

	public function get_teams($user_id='') {

		if($user_id){
		$get_user =	$this->db->query("SELECT Country FROM Users WHERE Users_ID = {$user_id}");
		$det	  = $get_user->row_array();

			$sel_country = "'".$det['Country']."'";
			if($det['Country'] == 'United States of America'){
				$sel_country = "'United States','USA','United States of America','US','U.S','U.S.A'";
			}
		
			$qry_check = $this->db->query("SELECT * FROM Teams AS tm JOIN Home_Court_Locations AS hc ON tm.Home_loc_id = hc.hcl_id
			WHERE hc.hcl_country IN ({$sel_country}) ORDER BY Team_name");
			}
			else{
			$qry_check = $this->db->query("SELECT * FROM Teams ORDER BY Team_name ASC");
			}

		$results[0]  = $qry_check->result();

		return $results;
	}

	public function get_limit_teams($user_id='', $page, $limit, $search) {
		$offset = ($page * $limit) - $limit;

		$search_cond = '';

		if(count($search) > 0){

			if($search['city'] and !$search['state']){
				$search_cond = " WHERE tm.Home_loc_id IN (SELECT hcl_id FROM Home_Court_Locations WHERE hcl_city IN ('".$search['city']."'))";
			}
			else if(!$search['city'] and $search['state']){
				$search_cond = " WHERE tm.Home_loc_id IN (SELECT hcl_id FROM Home_Court_Locations WHERE hcl_state IN ('".$search['state']."'))";
			}
			else if($search['city'] and $search['state']){
				$search_cond = " WHERE tm.Home_loc_id IN (SELECT hcl_id FROM Home_Court_Locations WHERE hcl_city IN ('".$search['city']."') AND hcl_state IN ('".$search['state']."'))";
			}

			if(($search['city'] or $search['state']) and $search['name']){
				$search_cond .= " AND tm.Team_name LIKE '%{$search['name']}%'";
			}
			else if($search['name']){
				$search_cond .= " WHERE tm.Team_name LIKE '%{$search['name']}%'";
			}

			if(($search['city'] or $search['state'] or $search['name']) and $search['sport']){
				$search_cond .= " AND tm.Sport = {$search['sport']}";
			}
			else if($search['sport']){
				$search_cond .= " WHERE tm.Sport = {$search['sport']}";
			}

		}

		if($user_id and $search_cond == ''){
			$get_user  = $this->db->query("SELECT Country FROM Users WHERE Users_ID = {$user_id}");
			$det			= $get_user->row_array();

			$sel_country = "'".$det['Country']."'";
			if($det['Country'] == 'United States of America' or $det['Country'] == 'United States Of America'){
				$sel_country = "'United States','USA','United States of America','United States Of America','US','U.S','U.S.A'";
			}

			$sport_intr = '(';
			$get_user_sp  = $this->db->query("SELECT * FROM Sports_Interests WHERE users_id = {$user_id}");
			$sp_int			= $get_user_sp->result();
			
			if($get_user_sp->num_rows() > 0){
				$i = 1;
				foreach($sp_int as $int){
					$sport_intr .= $int->Sport_id;
					if(count($sp_int) != $i)
					$sport_intr .= ", ";
					$i++;
				}
			}

			$sport_intr .= ')';
//echo $sport_intr; exit;
			$qry_check = $this->db->query("SELECT * FROM Teams AS tm WHERE tm.Home_loc_id IN (SELECT hcl_id FROM Home_Court_Locations WHERE hcl_country IN ($sel_country)) AND Sport IN {$sport_intr} ORDER BY Team_name ASC OFFSET {$offset} ROWS FETCH NEXT {$limit} ROWS ONLY");

			$qry_total = $this->db->query("SELECT * FROM Teams AS tm WHERE tm.Home_loc_id IN (SELECT hcl_id FROM Home_Court_Locations WHERE hcl_country IN ($sel_country)) ORDER BY Team_name ASC");
		}
		else if($search_cond != ''){
			$qry_check = $this->db->query("SELECT * FROM Teams AS tm{$search_cond} ORDER BY Team_name ASC OFFSET {$offset} ROWS FETCH NEXT {$limit} ROWS ONLY");

			$qry_total = $this->db->query("SELECT * FROM Teams AS tm{$search_cond} ORDER BY Team_name ASC");
		}
		else{
			$qry_check = $this->db->query("SELECT * FROM Teams ORDER BY Team_name ASC OFFSET {$offset} ROWS FETCH NEXT {$limit} ROWS ONLY");

			$qry_total = $this->db->query("SELECT * FROM Teams ORDER BY Team_name ASC");
		}
		//echo $this->db->last_query();
		$total = $qry_total->num_rows();
		$total_pages = ceil($total / $limit);

		$results[0]  = $qry_check->result();
		$results[1]  = $total_pages;

		return $results;
	}

	public function get_user_teams($user_id) {
		/*$qry_check = $this->db->query("SELECT * FROM Teams WHERE Created_by = {$user_id} OR Captain = {$user_id} OR Players LIKE '".'%"'.$user_id.'"%'."'ORDER BY Team_name ASC");*/
		$qry_check = $this->db->query("SELECT * FROM Teams WHERE Players LIKE '".'%"'.$user_id.'"%'."'ORDER BY Team_name ASC");
		return $qry_check->result();
	}

	public function get_team_info($team_id) {
		$qry_check = $this->db->query("SELECT * FROM Teams WHERE Team_ID = '".$team_id."'");
		return $qry_check->row_array();
	}

	public function is_team_auth($team_id, $user_id) {
		$qry_check = $this->db->query("SELECT * FROM Teams WHERE Team_ID = ".$team_id." AND (Created_by = ".$user_id." OR Captain = ".$user_id.")");
		return $qry_check->row_array();
	}

	public function get_home_loc($loc) {
		$qry_check = $this->db->query("SELECT * FROM Home_Court_Locations WHERE hcl_id = '".$loc."'");
		//echo $this->db->last_query();
		return $qry_check->row_array();
	}

	public function check_is_req($team_id, $user_id) {
		$qry_check = $this->db->query("SELECT * FROM Team_Join_Reqs WHERE Team_ID = {$team_id} AND Users_id = {$user_id} AND Response NOT IN ('Hold')");
		return $qry_check->num_rows();
	}

	public function ins_team_req($data)
	{
		
		$data = array(
			'Team_ID'	 => $data['team_id'],
			'Captain'	 => $data['captain_id'],
			'Users_id'	 => $data['user_id'],
			'Req_code'	 => $data['sec_code'],
			'Req_on'	 => date('Y-m-d H:i:s'),
			'Response'   => 'Pending'
			);
		
		$ins = $this->db->insert('Team_Join_Reqs', $data);
		
		return $ins;		
	}
	
	public function update_team($data, $team_id){
			$this->db->where('Team_ID', $team_id);
			$upd_team = $this->db->update('Teams', $data);
		return $upd_team;
	}

	public function withdraw_from_team($team_id, $user_id)
	{
		$team	   = $this->get_team_info($team_id);
		$players   = "";
		$players   = json_decode($team['Players']);
		$key	   = array_search($user_id, $players);

		if($key and $key != "null"){
			unset($players[$key]);
			$players	  = array_values($players);
			$players	  = array_map('strval', $players);
			$team_players = json_encode($players);
			$data		  = array('Players' => $team_players);

							$this->db->where('Team_ID', $team_id);
			$upd_team	  = $this->db->update('Teams', $data);

			$qry_get_tourns = $this->db->query("SELECT * FROM RegisterTournament WHERE Team_id = {$team_id}");
			$reg_team		= $qry_get_tourns->result();
			
			foreach($reg_team as $i => $rt){
				$players	  = $rt->Team_Players;
				$players	  = json_decode($players);
				$key		  = array_search($user_id, $players);
				unset($players[$key]);
				$players	  = array_values($players);
				$players	  = array_map('strval', $players);
				$team_players = json_encode($players);

				$data = array('Team_Players' => $team_players);
						$this->db->where('RegisterTournament_id', $rt->RegisterTournament_id);
			$upd_team = $this->db->update('RegisterTournament', $data);
			}

			return 1;
		}
		else{
			return 0;
		}
	}
	
		public function search_autocomplete_users($data)
		{			
			$key = $data['key'];
			$club_id = $data['club_id'];
			
			/*$this->db->select('*');
			$this->db->from('users');
			$this->db->like('Firstname', $key); 
			$this->db->or_like('Lastname', $key);
			$this->db->or_like(CONCAT('Firstname' + ' ' + 'Lastname') AS fullname, $key);
			
			$query = $this->db->get();*/
			if($club_id){
			$query = $this->db->query("SELECT * FROM Users u WHERE u.Firstname+' '+u.Lastname LIKE '%{$key}%' AND Users_ID IN (SELECT Users_id FROM User_memberships WHERE Club_id = {$club_id} AND Member_Status = 1)");
			}
			else{
			$query = $this->db->query("SELECT * FROM Users u WHERE u.Firstname+' '+u.Lastname LIKE '%{$key}%'");
			}
			return $query->result();
		}
		
		public function search_autocomplete_court_locations($data)
		{			
			$key = $data['key'];
			
			$this->db->select('*');
			$this->db->from('Home_Court_Locations');
			$this->db->like('hcl_title', $key); 
			
			$query = $this->db->get();
			return $query->result();
		}
		
		public function create_home_location($data)
		{	
			$points = $data['latt'];

			//$values = explode('@',$points);
			$loc_lat  = $points['latitude'];
			$loc_long = $points['longitude'];
			
			$title	 = $data['title'];
		    $add	 = $data['add'];
			$city	 = $data['city'];
			$state	 = $data['state'];
			$country = $data['country'];
		    $zip	 = $data['zip'];
			$user_id = $data['user_id'];

			$data = array(
					'hcl_title'   => $title,
					'hcl_address' => $add,
					'hcl_city' 	  => $city,
					'hcl_state'   => $state,
					'hcl_country' => $country,
					'hcl_zipcode' => $zip,
					'hcl_created_by' => $user_id,
					'hcl_lat' 		 => $loc_lat,
					'hcl_long' 		 => $loc_long
				);

			$result = $this->db->insert('Home_Court_Locations', $data);
		    return  $this->db->insert_id(); 	
	    }
		public function create_team($data)
		{
			//echo "<pre>";print_r($data);exit();
			$team_name	= $data['team_name'];
			$sport		= $data['sport'];
			$created_by	= $data['created_user'];
			$players	= $data['team_players'];
			
			$team_logo	= $data['team_logo_name'];
			
			$home_loc = NULL;

			if($data['home_location']){
				$home_loc = $data['home_location'];
			}

			$data = array(
				'Team_name'	 => $team_name,
				'Sport'		 => $sport,
				'Created_by' => $created_by,
				'Captain'	 => $created_by,
				'Home_loc_id'=> $home_loc,
				'Players'	 => $players,
				'Status'	 => 'Active',
				'Team_Logo'  => $team_logo
			);

			$this->db->insert('teams', $data);
		    $insert_id = $this->db->insert_id();

			if($insert_id){
				$data = array(
					'Team_ID'		=> $insert_id,
					'Sport'			=> $sport,
					'A2MTeamScore'  => 100
				);
			
			$this->db->insert('A2MTeamScore', $data);

			return true;
			}
			else{
			return false;
			}
		}

	public function get_userToken($user_id) {
		$data  = array('user_id' => $user_id, 'status' => 1);
		$query = $this->db->get_where('userPushTokens', $data);
		return $query->result();
	}

	public function get_user_details($user_id) {
		$qry_check = $this->db->query("SELECT * FROM Users WHERE Users_ID = '".$user_id."'");
		return $qry_check->row_array();
	}

	public function insert_notif($data){
		$query = $this->db->insert('Mobile_Notifications', $data);
		return $query;
	}

}