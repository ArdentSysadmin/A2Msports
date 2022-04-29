<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

	class Model_teams extends CI_Model {
	
		public function __construct()
		{
			parent:: __construct();

		}

		public function create_team()
		{
			$data = $this->upload->data();

			if($data['file_name'] != ""){
               $filename = $data['file_name'];
			}
			else{
			   $filename = '';
			}

			$team_name	= $this->input->post('title');
			$sport		= $this->input->post('sport_type');
			$home_loc	= NULL;

			if($this->input->post('home_court_id')){
				$home_loc = $this->input->post('home_court_id');
			}

			$sel_players	= $this->input->post('sel_player');
			$log_user		= (string) $this->logged_user;
			
			array_push($sel_players, $log_user);

			$players		= json_encode($sel_players);

			$data = array(
				'Team_name'	 => $team_name,
				'Sport'		 => $sport,
				'Created_by' => $this->logged_user,
				'Captain'	 => $this->logged_user,
				'Home_loc_id'=> $home_loc,
				'Players'	 => $players,
				'Status'	 => 'Active',
				'Team_Logo'  => $filename
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

		public function ins_team_req($data)
		{
			
			$data = array(
				'Team_ID'	 => $data['team_id'],
				'Captain'	 => $data['captain_id'],
				'Users_id'	 => $this->logged_user,
				'Req_code'	 => $data['sec_code'],
				'Req_on'	 => date('Y-m-d H:i:s'),
				'Response'   => 'Pending'
				);
			
			$this->db->insert('Team_Join_Reqs', $data);
			
			return true;		
		}

		public function process_join_req()
		{
			$code		= $this->input->post('sec_code');
			$action		= $this->input->post('act_type');
			$comments	= $this->input->post('comments');

			$data = array('Req_code' => $code);
			$query = $this->db->get_where('Team_Join_Reqs', $data);
			$get_req_det = $query->row_array();

			if($action == 'Accept' and $get_req_det)
			{
				$ins_user = (string)$get_req_det['Users_id'];
				$ins_team = $get_req_det['Team_ID'];

				$data	  = array('Team_ID' => $ins_team);
				$qry	  = $this->db->get_where('Teams', $data);
				$get_team = $qry->row_array();

				$players	= json_decode($get_team['Players']);
				
				if(!in_array($ins_user, $players))
				{
					array_push($players, $ins_user);

					$upd_players = json_encode($players);

					$data = array('Players' => $upd_players);
					
						   $this->db->where('Team_ID', $ins_team);
					$upd = $this->db->update('Teams', $data);
				}
			}

			$data = array(
					'Response' => $action,
					'Res_on'   => date('Y-m-d'),
					'Comments' => $comments
					);

			$this->db->where('Req_code', $code);

			$upd = $this->db->update('Team_Join_Reqs', $data);

			return $upd;
		}

		public function update_teams()
		{
			$team_id  = $this->input->post('team_id');
			$tourn_id = $this->input->post('tourn_id');
			$team_captain = $this->input->post('team_captain');

			$nteam = $this->input->post('sel_team_player');
			$oteam = unserialize($this->input->post('oteam'));
			$oteam = array_keys($oteam);

			$new_tour_team_player = array_diff($nteam, $oteam);
				foreach($new_tour_team_player as $new_player){
					array_push($oteam, $new_player);
				}
			$oteam = array_map('strval', $oteam);

			$team_players = json_encode($oteam);
			$data = array('Players' => $team_players,
						  'Captain' => $team_captain);
			
			//echo "<pre>";
			//print_r($data);
		
						$this->db->where('Team_ID', $team_id);
			$upd_team = $this->db->update('Teams', $data);


			$tourn_team_players = json_encode($nteam);
			$data = array('Team_Players' => $tourn_team_players);
			
			//echo "<pre>";
			//print_r($data);

		//exit;
							$this->db->where(array('Tournament_ID' => $tourn_id,'Team_ID' => $team_id));
			$upd_register = $this->db->update('RegisterTournament', $data);
			
			return true;
		}
			
		public function update_team_players()
		{
			$team_id = $this->input->post('team_id');
			
			if($_FILES['team_logo_'.$team_id]['name'] != ""){
				$data = $this->upload->data();
                $filename = $data['file_name'];
			}else{
				$filename = $this->input->post('team_old_logo_'.$team_id);
			}

			$team_name	  = $this->input->post('team_name');
			$team_captain = $this->input->post('team_captain');

			$nteam		  = $this->input->post('sel_team_player');
			$nteam		  = array_map('strval', $nteam);

			$team_players = json_encode($nteam);
			$data = array('Players'	  => $team_players,
						  'Team_name' => $team_name,
						  'Captain'   => $team_captain,
						  'Team_Logo' => $filename);

						$this->db->where('Team_ID', $team_id);
			$upd_team = $this->db->update('Teams', $data);
			
			return true;
		}

		public function withdraw_from_team($team_id)
		{
				$team		  = $this->get_team_info($team_id);

				$players	  = "";
				$players	  = json_decode($team['Players']);
				$key		  = array_search($this->logged_user, $players);
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
					$key		  = array_search($this->logged_user, $players);
					unset($players[$key]);
					$players	  = array_values($players);
					$players	  = array_map('strval', $players);
					$team_players = json_encode($players);

					$data = array('Team_Players' => $team_players);
							$this->db->where('RegisterTournament_id', $rt->RegisterTournament_id);
				$upd_team = $this->db->update('RegisterTournament', $data);
				}

			return true;
		}

		public function update_team_name()
		{
			$team_id   = $this->input->post('team_id');
			$team_name = $this->input->post('team_name_'.$team_id);

			$data = array('Team_name' => $team_name);

						$this->db->where('Team_ID', $team_id);
			$upd_team = $this->db->update('Teams', $data);
			
			return true;
		}

		public function search_autocomplete($data)
		{			
			$key = $data['key'];
			
			$this->db->select('*');
			$this->db->from('users');
			$this->db->like('Firstname', $key); 
			$this->db->or_like('Lastname', $key);
			
			$query = $this->db->get();
			return $query->result();
		

	/*		$qry_check = $this->db->query("SELECT * FROM Users WHERE (Firstname LIKE '%\"{$key}\"%' OR Lastname LIKE '%\"{$key}\"%') AND Users_ID NOT LIKE (SELECT Team_Players RegisterTournament WHERE Tournament_ID = {$tourn_id} AND Team_id != {$team} AND Team_Players LIKE '%\"{$player}\"%'");
			return $qry_check->result();*/

		}

		public function check_is_req($team_id)
		{
			$qry_check = $this->db->query("SELECT * FROM Team_Join_Reqs WHERE Team_ID = {$team_id} AND Users_id = {$this->logged_user} AND Response NOT IN ('Hold')");
			return $qry_check->num_rows();
		}

		public function get_team_info($tid)
		{
			$data = array('Team_ID' => $tid);
			$query = $this->db->get_where('Teams', $data);
			return $query->row_array();
		}

		public function is_player_reg_tourn($player, $tourn_id, $team)
		{
			$qry_check = $this->db->query("SELECT * FROM RegisterTournament WHERE Tournament_ID = {$tourn_id} AND Team_Players LIKE '%\"{$player}\"%'");
			return $qry_check->num_rows();
		}

		public function check_is_player_locked($player, $tourn_id, $team)
		{
			$qry_check = $this->db->query("SELECT * FROM RegisterTournament WHERE Tournament_ID = {$tourn_id} AND Team_id != {$team} AND Team_Players LIKE '%\"{$player}\"%'");
			return $qry_check->num_rows();
		}

		public function get_tour_team_info($tourn_id, $team)
		{
			$qry_check = $this->db->query("SELECT * FROM RegisterTournament WHERE Tournament_ID = {$tourn_id} AND Team_id = {$team}");
			return $qry_check->row_array();
		}

		public function get_joinreq_info($sec_code)
		{
			$qry_check = $this->db->query("SELECT * FROM Team_Join_Reqs WHERE Req_code = '{$sec_code}'");
			return $qry_check->row_array();
		}

		public function get_user_created()
		{
			$qry_check = $this->db->query("SELECT * FROM Teams WHERE Created_by = '{$this->logged_user}'");
			return $qry_check->result();
		}

		public function get_user_part()
		{
			$qry_check = $this->db->query("SELECT * FROM Teams WHERE Created_by != '{$this->logged_user}' AND Players LIKE '%\"{$this->logged_user}\"%'");
			return $qry_check->result();
		}

		public function get_user_non_part()
		{
			$user = $this->logged_user;
			//$qry_check = $this->db->query("SELECT * FROM Teams WHERE Players NOT LIKE '%\"{$this->logged_user}\"%'");
			//$lat	= number_format($this->session->userdata('lat'), 2);
			//$long	= number_format($this->session->userdata('long'), 2);

			//$range	= 50;

			/*$qry_check = $this->db->query("SELECT * FROM Teams WHERE Created_by != '{$this->logged_user}' AND Players NOT LIKE '%\"{$this->logged_user}\"%' AND Sport IN (SELECT Sport_id FROM Sports_Interests WHERE users_id = {$this->logged_user}) AND Created_by IN (SELECT Users_ID FROM Users WHERE ACOS( SIN( RADIANS( Latitude )) * SIN( RADIANS( $lat ) ) + COS( RADIANS( Latitude ) ) * COS( RADIANS( $lat )) * COS( RADIANS( Longitude ) - RADIANS( $long )) ) * 3964.3 < {$range})");*/

			$qry_check	= $this->db->query("SELECT * FROM Users WHERE Users_ID = $user");
			$res		= $qry_check->row_array();
			$country	= $res['Country'];

			if($country == 'United States of America'){
				$qry_str = "h.hcl_country = '$country' OR h.hcl_country = 'United States' OR h.hcl_country = 'US' OR h.hcl_country = 'U.S.A' OR h.hcl_country = 'USA'";
			}
			else{
				$qry_str = "h.hcl_country = '$country'";
			}
			
			$qry_check1 = $this->db->query("SELECT * FROM Teams WHERE Home_loc_id IN(SELECT hcl_id FROM Home_Court_Locations as h WHERE {$qry_str})");

			return $qry_check1->result();
		}

		public function get_user_sport_intrests()
		{
			$data		= array('users_id' => $this->logged_user);
			$qry_check	= $this->db->get_where('Sports_Interests', $data);
			return $qry_check->result();
		}

		public function update_tourn_team_players()
		{
			$team_id  = $this->input->post('team_id');
			$tourn_id = $this->input->post('tourn_id');

			if($_FILES['team_logo_'.$team_id]['name'] != ""){
				$data = $this->upload->data();
                $filename = $data['file_name'];
			}else{
				$filename = $this->input->post('team_old_logo_'.$team_id);
			}
			
			//$team_name	  = $this->input->post('team_name');
			$team_captain = $this->input->post('team_captain');

			$nteam		  = $this->input->post('sel_team_player');
			$nteam		  = array_map('strval', $nteam);

			$sel_players = $nteam;
            $playersjson = json_encode($sel_players);

			$data = array('Players'	  => $playersjson,
						  'Captain'   => $team_captain,	
						  'Team_Logo' => $filename);

			$this->db->where('Team_ID', $team_id);
			$upd_team = $this->db->update('Teams', $data);


			$data = array('Team_Players' => $playersjson);
			
              $this->db->where('Tournament_ID', $tourn_id);
              $this->db->where('Team_id', $team_id);
		      $up_reg = $this->db->update('RegisterTournament' ,$data);		
			
		      return true;
		}

		public function get_TeamsByCountry($country, $sport){
			$qry_check = $this->db->query("SELECT u.Users_ID,u.Firstname,u.Lastname,t.Team_name,t.Captain,h.hcl_city,h.hcl_state,t.Team_ID FROM Users u JOIN Teams t ON u.Users_ID = t.Created_by AND t.Sport = '".$sport."' JOIN Home_Court_Locations h ON t.Home_loc_id = h.hcl_id AND h.hcl_country = '".$country."'");
 
			return $qry_check->result();
		}

	}