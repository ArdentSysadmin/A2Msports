<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

	class Model_teams extends CI_Model {
	
		public function __construct()
		{
			parent:: __construct();

		}

		public function create_team()
		{
			$team_name	= $this->input->post('title');
			$sport		= $this->input->post('sport_type');
			
			$home_loc = NULL;

			if($this->input->post('home_court_id'))
			{
				$home_loc = $this->input->post('home_court_id');
			}

			$sel_players	= $this->input->post('sel_player');

			$log_user = (string) $this->logged_user;
			
			array_push($sel_players, $log_user);

			$players	= json_encode($sel_players);

			$data = array(
				'Team_name'	 => $team_name,
				'Sport'		 => $sport,
				'Created_by' => $this->logged_user,
				'Captain'	 => $this->logged_user,
				'Home_loc_id'=> $home_loc,
				'Players'	 => $players,
				'Status'	 => 'Active',
				'Team_Logo'  => NULL
			);

			$this->db->insert('teams', $data);
		    //$insert_id = $this->db->insert_id();
			if($this->db->insert_id()){
				return true;
			}
			else
			{
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
			$team_id	  = $this->input->post('team_id');
			$team_captain = $this->input->post('team_captain');

			$nteam = $this->input->post('sel_team_player');

			$nteam = array_map('strval', $nteam);

			$team_players = json_encode($nteam);
			$data = array('Players' => $team_players,
						  'Captain' => $team_captain);

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
			//$qry_check = $this->db->query("SELECT * FROM Teams WHERE Players NOT LIKE '%\"{$this->logged_user}\"%'");
			$lat	= $this->session->userdata('lat');
			$long	= $this->session->userdata('long');

			$range	= 50;

			$qry_check = $this->db->query("SELECT * FROM Teams WHERE Created_by != '{$this->logged_user}' AND Players NOT LIKE '%\"{$this->logged_user}\"%' AND Created_by IN (SELECT Users_ID FROM Users WHERE ACOS( SIN( RADIANS( Latitude )) * SIN( RADIANS( $lat ) ) + COS( RADIANS( Latitude ) ) * COS( RADIANS( $lat )) * COS( RADIANS( Longitude ) - RADIANS( $long )) ) * 3964.3 < {$range})");

			return $qry_check->result();
		}


	}