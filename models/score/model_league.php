<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class model_league extends CI_Model {

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

	public function get_tournaments($user_id, $country=''){

		$country_cond = "";

		if($country){
			$country_cond = "AND t.TournamentCountry = '{$country}'";
		}

		$today = date('Y-m-d');

		$query = $this->db->query("SELECT 0 as Registered, st.Sportname ,t.* FROM tournament t INNER JOIN SportsType st ON t.SportsType = st.SportsType_ID WHERE t.tournament_ID NOT IN (select b.tournament_ID from RegisterTournament b where b.users_id = '".$user_id."' OR b.Team_Players LIKE '%".$user_id."%') $country_cond
		UNION all
		SELECT 1 as Registered, st.Sportname , t.* FROM tournament t INNER JOIN dbo.SportsType st ON st.SportsType_ID = t.SportsType WHERE tournament_ID IN (select b.tournament_ID from RegisterTournament b where b.users_id = '".$user_id."' or b.Team_Players like '%".$user_id."%') $country_cond ORDER BY t.EndDate DESC");

/*$query = $this->db->query("select 0 as Registered, st.Sportname , t.* from tournament t inner join dbo.SportsType st on st.SportsType_ID = t.SportsType where StartDate > '".$today."'$country_cond and t.tournament_ID not in (select b.tournament_ID from RegisterTournament b where b.users_id = '".$user_id."' or b.Team_Players like '%".$user_id."%')
UNION all
select 1 as Registered, st.Sportname , t.* from tournament t inner join dbo.SportsType st on st.SportsType_ID = t.SportsType where tournament_ID in (select b.tournament_ID from RegisterTournament b where b.users_id = '".$user_id."' or b.Team_Players like '%".$user_id."%')$country_cond");*/

	//echo $this->db->last_query();
//exit;
		return $query->result();
	}

	public function get_limit_tournaments($user_id, $country='', $page, $limit, $search){

		$offset = ($page * $limit) - $limit;
		$search_cond = '';

		$country_cond = "";

		if($country){
			$country_cond = " AND TournamentCountry = '{$country}'";
		}

		$today = date('Y-m-d');
		//var_dump($search);
		if($search != ""){
			//echo "test"; exit;
			if($search['city'] and !$search['state']){
				$search_cond = " AND TournamentCity LIKE '{$search['city']}%'";
			}
			else if(!$search['city'] and $search['state']){
				$search_cond = " AND TournamentState LIKE '{$search['state']}%'";
			}
			else if($search['city'] and $search['state']){
				$search_cond = " AND TournamentCity LIKE '{$search['city']}%' AND TournamentState LIKE '{$search['state']}%'";
			}

			if($search['name']){
				$search_cond .= " AND tournament_title LIKE '%{$search['name']}%'";
			}

			if($search['sport']){
				$search_cond .= " AND SportsType = {$search['sport']}";
			}

			if($search['sdate']){
				$search_cond .= " AND StartDate >= '".$search['sdate']."'";
			}

			if($search['edate']){
				$search_cond .= " AND EndDate <= '".$search['edate']."'";
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

			if($search['name']){
				$query = $this->db->query("SELECT * FROM tournament WHERE tournament_ID > 1000{$search_cond} ORDER BY EndDate DESC OFFSET {$offset} ROWS FETCH NEXT {$limit} ROWS ONLY");
			}
			else{
				$query = $this->db->query("SELECT * FROM tournament WHERE tournament_ID > 1000{$search_cond}{$country_cond} ORDER BY EndDate DESC OFFSET {$offset} ROWS FETCH NEXT {$limit} ROWS ONLY");
			}
		}
		else if($page){
			//echo "Test"; exit;
				$query = $this->db->query("SELECT * FROM tournament WHERE tournament_ID > 1000{$country_cond} ORDER BY EndDate DESC OFFSET {$offset} ROWS FETCH NEXT {$limit} ROWS ONLY");

				//echo $this->db->last_query();
				//echo "Test"; exit;
		}
		else{
			$query = $this->db->query("SELECT 0 as Registered, st.Sportname ,t.* FROM tournament t INNER JOIN SportsType st ON t.SportsType = st.SportsType_ID WHERE t.tournament_ID NOT IN (select b.tournament_ID from RegisterTournament b where b.users_id = '".$user_id."' OR b.Team_Players LIKE '%".$user_id."%')$country_cond
			UNION all
			SELECT 1 as Registered, st.Sportname , t.* FROM tournament t INNER JOIN dbo.SportsType st ON st.SportsType_ID = t.SportsType WHERE tournament_ID IN (select b.tournament_ID from RegisterTournament b where b.users_id = '".$user_id."' or b.Team_Players like '%".$user_id."%')$country_cond ORDER BY t.EndDate DESC");
		}
//echo $this->db->last_query();
//echo "<pre>";
//print_r($query->result());
		$total_query		= '';
		if(!empty($query->result())){
		$last_query	= $this->db->last_query();
		$limit_qry		= " OFFSET {$offset} ROWS FETCH NEXT {$limit} ROWS ONLY";
		$total_query		= str_replace($limit_qry, '', $last_query);
		}

		$results = "";
		if($total_query){
			$qry_total = $this->db->query($total_query);

			$total = $qry_total->num_rows();
			$total_pages = ceil($total / $limit);

			$results[0]  = $query->result();
			$results[1]  = $total_pages;
		}

		return $results;
	}

	public function get_user_details($user_id, $sport_id='') {
		//$qry_check = $this->db->query("SELECT * FROM Users WHERE Users_ID = '".$user_id."'");
		if($sport_id){
			$qry_check = $this->db->query("select * from Users u join A2MScore a on u.Users_ID = a.Users_ID where u.Users_ID = {$user_id} and a.SportsType_ID = {$sport_id}");
			if(count($qry_check->row_array()) > 0){
				return $qry_check->row_array();
			}
			else{
				$qry_check = $this->db->query("SELECT *,A2MScore = null, A2MScore_Doubles = null, A2MScore_Mixed = null FROM Users WHERE Users_ID = {$user_id}");
				return $qry_check->row_array();
			}
		}
		else{
			$qry_check = $this->db->query("SELECT * FROM Users WHERE Users_ID = '".$user_id."'");
			return $qry_check->row_array();
		}

		//return $qry_check->row_array();
	}

	public function getonerow($tourn_id){				   
		$data = array('tournament_ID'=>$tourn_id);
		$query = $this->db->get_where('tournament',$data);
		return $query->row_array();
	}

	public function get_a2m($user_id, $tourn_id){
		$get_tour = $this->getonerow($tourn_id);
		$data = array('Users_ID'=>$user_id, 'SportsType_ID' =>$get_tour['SportsType'] );
		$query = $this->db->get_where('A2MScore', $data);
		return $query->row_array();
	}

	public function get_user_a2m($user_id, $sport){
		$data = array('Users_ID'=>$user_id, 'SportsType_ID' =>$sport );
		$query = $this->db->get_where('A2MScore', $data);
		return $query->row_array();
	}

	public function check_is_admin($user_id, $tourn_id){				   
		$data = array('tournament_ID'=>$tourn_id, 'Usersid'=>$user_id);
		$query = $this->db->get_where('tournament',$data);
		return $query->row_array();
	}

	public function get_league_details($tid){
		$query = $this->db->query("SELECT * FROM tournament WHERE tournament_ID = '".$tid."'");
		return $query->row_array();
	}
	
	public function get_user_reg($tid, $uid){
		$query = $this->db->query("SELECT * FROM RegisterTournament WHERE Tournament_ID = '".$tid."' AND Users_ID = '".$uid."'");
		return $query->row_array();
	}
	
	public function update_reg_tourn($data){
		$tid = $data['Tournament_ID'];
		$uid = $data['Users_ID'];
		$upd_events = $data['upd_events'];

		$query = $this->db->query("UPDATE RegisterTournament SET Reg_Events = '".json_encode($upd_events)."' WHERE 
		Tournament_ID = '".$tid."' AND Users_ID = '".$uid."'");

		return true;
	}
	
	public function inset_reg_tourn($data){
		$res = $this->db->insert('RegisterTournament', $data);
		//echo $this->db->last_query(); exit;
		return $this->db->insert_id();
	}

	public function insert_pay_transaction($data2){
		$res = $this->db->insert('PayTransactions', $data2);
		return $this->db->last_query();
	}

	public function ins_temp($data){
		$res = $this->db->insert('Temp', $data);
		//return $this->db->last_query();
	}

	public function upd_reg_a2m($reg_id, $a2m){
		//$query = $this->db->query("UPDATE RegisterTournament SET Current_A2M = {$a2m} WHERE RegisterTournament_ID = {$reg_id}");
	}

	public function is_registered($id, $tourn_id, $type) {
		if($type == 'Team'){
			$query = $this->db->query("SELECT * FROM RegisterTournament WHERE Tournament_ID = '".$tourn_id."' AND Team_id = '".$id."'");
             return $query->row_array();
		}
		else{
			$query = $this->db->query("SELECT * FROM RegisterTournament WHERE Tournament_ID = '".$tourn_id."' AND Users_ID = '".$id."'");
             return $query->row_array();
		}
	}

	public function is_user_team_registered($id, $tourn_id) {
			$query = $this->db->query("SELECT * FROM RegisterTournament WHERE Tournament_ID = '".$tourn_id."' AND Team_Players LIKE '%".'"'.$id.'"'."%'");
             return $query->row_array();
	}

	public function get_level_name($level_id) {
			$query = $this->db->query("SELECT * FROM SportsLevels WHERE SportsLevel_ID = {$level_id}");
             return $query->row_array();
	}

	public function get_reg_events($user_id, $tourn_id) {
			$query = $this->db->query("SELECT * FROM RegisterTournament WHERE Users_ID = {$user_id} AND Tournament_ID = $tourn_id");
             return $query->row_array();
	}

	public function del_tourn_reguser($user_id, $tourn_id) {
			$query = $this->db->query("DELETE FROM RegisterTournament WHERE Users_ID = {$user_id} AND Tournament_ID = $tourn_id");
	}

	public function update_partner($data){

			$tourn_id	=  $data['tourn_id'];
			//$ttype			=  $data['ttype'];
			$player		=  $data['player'];
			$partner		=  $data['partner'];
			$event		=  $data['event'];

			$get_partner_prev = $this->db->query("SELECT * FROM RegisterTournament WHERE Tournament_ID = '$tourn_id' AND Partners LIKE '%\"$event\":\"$partner\"%'");
		//	echo $this->db->last_query();

			$res = $get_partner_prev->result();

			if(count($res) > 0){
				foreach($res as $r){
					$prev_partners = json_decode($r->Partners, true);
					unset($prev_partners[$event]);
				
					$new_partners = json_encode($prev_partners);
					$data = array("Partners" => $new_partners );   // update Player's existing partner as empty
					$this->db->where('RegisterTournament_id', $r->RegisterTournament_id);
					$result = $this->db->update('RegisterTournament', $data);
				}
			}
	
			// -------------------------------------
			$get_player_partner_prev = $this->db->query("SELECT * FROM RegisterTournament WHERE Tournament_ID = '$tourn_id' AND Partners LIKE '%\"$event\":\"$player\"%'");
		//	echo $this->db->last_query();

			$res2 = $get_player_partner_prev->result();

			if(count($res2) > 0){
				foreach($res2 as $r){
					$prev_partners = json_decode($r->Partners, true);
					unset($prev_partners[$event]);
				
					$new_partners = json_encode($prev_partners);
					$data = array("Partners" => $new_partners );   // update Player's existing partner as empty
					$this->db->where('RegisterTournament_id', $r->RegisterTournament_id);
					$result = $this->db->update('RegisterTournament', $data);
				}
			}

				// -------------------------------------
				// ------- Player section ---------------------

				$data							 = array('Users_ID' => $player, 'Tournament_ID' => $tourn_id);
				$exec_qry1				 = $this->db->get_where('RegisterTournament', $data);
				$get_player_partner = $exec_qry1->row_array();

				if($get_player_partner['Partners']){
					$player_partners				   = json_decode($get_player_partner['Partners'], true);
					$player_partners[$event]  = $partner;
				}
				else{
					$player_partners = array($event => $partner);
				}

				$upd_partners = json_encode($player_partners);

				$data = array("Partners" => $upd_partners );   // update Player's existing partner as empty
								$this->db->where('Tournament_ID', $tourn_id);
								$this->db->where('Users_ID', $player);
				$result = $this->db->update('RegisterTournament', $data);
//echo $this->db->last_query();
				// -------- Partner section --------------------

				$data							= array('Users_ID' => $partner, 'Tournament_ID' => $tourn_id);
				$exec_qry2				= $this->db->get_where('RegisterTournament', $data);
				$get_partners_partner = $exec_qry2->row_array();

				if($get_partners_partner['Partners']){
				$partners_partner	= json_decode($get_partners_partner['Partners'], true);
				$partners_partner[$event] = $player;
				}
				else{
				$partners_partner = array($event => $player);
				}

				$upd_partners2 = json_encode($partners_partner);

				$data = array("Partners" => $upd_partners2 );   // update Partners's existing partner as empty
								$this->db->where('Tournament_ID', $tourn_id);
								$this->db->where('Users_ID', $partner);
				$result = $this->db->update('RegisterTournament', $data);
			
			$qry_check = $this->db->query("SELECT U.Users_ID, U.Firstname, U.Lastname, U.Gender, RE.Reg_Events, RE.Partners from Users U JOIN RegisterTournament RE ON RE.Users_ID = U.Users_ID AND RE.Tournament_ID = '$tourn_id' AND Reg_Events LIKE '%$event%'");
				
			return $qry_check->result();
	}

	public function get_reg_users($tourn_id){
			$qry = $this->db->query("SELECT * FROM RegisterTournament WHERE Tournament_ID = {$tourn_id}");
			return $qry->result();
	}

	public function get_draws($tourn_id){
			$qry = $this->db->query("SELECT * FROM Brackets WHERE Tourn_ID = {$tourn_id} AND is_Publish = 1");
			return $qry->result();
	}

	public function get_team_details($team_id){
			$qry = $this->db->query("SELECT * FROM Teams WHERE Team_ID = {$team_id}");
			return $qry->row_array();
	}

	public function inset_user_a2m($user_id, $sport){
			$check_user_a2m = $this->db->query("SELECT * FROM A2MScore WHERE Users_ID = {$user_id} AND SportsType_ID = {$sport}");
			$prev_a2m = $check_user_a2m->row_array();

			if(count($prev_a2m) == 0){
				$def_score = 100;
				if($sport == '2') 
				$def_score = 800;
				if($sport == '7' or $sport == '19' or $sport == '20') 
				$def_score = 3.0;

				$ins_user_a2m = $this->db->query("INSERT INTO A2MScore(Users_ID,SportsType_ID,A2MScore,A2MScore_Doubles,A2MScore_Mixed) VALUES ({$user_id},{$sport},{$def_score},{$def_score},{$def_score})");
			}
	}

	public function inset_user_si($user_id, $sport){
			$check_user_si = $this->db->query("SELECT * FROM Sports_Interests WHERE users_id = {$user_id} AND Sport_id = {$sport}");
			$prev_si = $check_user_si->row_array();

			if(count($prev_si) == 0){
				$ins_user_si = $this->db->query("INSERT INTO Sports_Interests(users_id,Sport_id) VALUES ({$user_id},{$sport})");
			}
	}

	public function get_onerow($table, $where_col, $where_val){
		$data	  = array($where_col => $where_val);
		$query = $this->db->get_where($table, $data);
		//echo $this->db->last_query();
		if($query->num_rows() > 0)
			return $query->row_array();
		else
			return 0;
	}


	public function get_league_brackets($tid, $format){
/*["Tourn_ID","Team1_Title","Team2_Title","Bracket_Type","Draw_Title","Player1","Player2","Tourn_match_id","BracketID","Round_Num","Match_Num","Winner","Match_Date","Player1_points","Player2_points","Draw_Type","Player1FirstName","Player1LastName","Player2FirstName","Player2LastName","Partner1FirstName","Partner1LastName","Partner2FirstName","Partner2LastName","tournament_title","Player1_Score","Player2_Score","Player1_Partner","Player2_Partner"]*/

		if($format == 'Teams'){
			$get_res = $this->db->query("select tm.Tourn_ID, t.tournament_title as tournament_title, isnull(IIF(u1.Team_name is null and winner <> 0 , 'BYE', u1.Team_name) , ' ') as Team1_Title, CONCAT('".base_url()."team_logos/',u1.Team_Logo) as Team1_Logo, isnull(IIF(u2.Team_name is null and winner <> 0 , 'BYE', u2.Team_name) , ' ') as Team2_Title,  CONCAT('".base_url()."team_logos/',u2.Team_Logo) as Team2_Logo, b.Bracket_Type, b.Draw_Title, b.Match_Type, pr1.Team_name as Team1_Partner ,  pr2.Team_name as Team2_Partner,  tm.Tourn_match_id, tm.BracketID, tm.Round_Num, tm.Match_Num, tm.Winner, tm.Match_DueDate as Match_Date, tm.Player1_points, tm.Player2_points, tm.Draw_Type, tm.Player1_Score, tm.Player2_Score from tournament t inner join Brackets b on b.Tourn_ID = t.tournament_ID AND b.is_Publish = 1 inner join Tournament_Matches tm on tm.BracketID = b.BracketID left outer join Teams u1 on u1.Team_ID = tm.Player1 left outer join Teams u2 on u2.Team_ID = tm.Player2 left outer join Teams pr1 on tm.Player1_Partner = pr1.Team_ID left outer join Teams pr2 on tm.Player2_partner = pr2.Team_ID where t.Tournament_id = {$tid}");
		}
		else{
			$get_res = $this->db->query("select tm.Tourn_ID, t.tournament_title as tournament_title, tm.Player1, isnull(IIF(u1.Firstname is null and winner <> 0 , 'BYE', u1.Firstname) , ' ') as Player1FirstName , 
			isnull(IIF(u1.Lastname is null and winner <> 0, ' ', u1.Lastname) , ' ') as Player1LastName, 
			isnull(IIF(u1.Profilepic is null, null, CONCAT('".base_url()."profile_pictures/',u1.Profilepic)) , null) as Player1_Profilepic, tm.Player2, 
			isnull(IIF(u2.Firstname is null and winner <> 0 , 'BYE', u2.Firstname) , ' ') as Player2FirstName,  
			isnull(IIF(u2.Lastname is null and winner <> 0 , ' ', u2.Lastname) , ' ') as Player2LastName, 
			isnull(IIF(u2.Profilepic is null, null, CONCAT('".base_url()."profile_pictures/',u2.Profilepic)) , null) as Player2_Profilepic,
			b.Bracket_Type, b.Draw_Title, b.Match_Type, tm.Player1_Partner, pr1.Firstname as Partner1FirstName , pr1.LastName as Partner1LastName,
			isnull(IIF(pr1.Profilepic is null, null, CONCAT('".base_url()."profile_pictures/',pr1.Profilepic)) , null) as Partner1_Profilepic, tm.Player2_Partner,	pr2.Firstname as Partner2FirstName , pr2.LastName as Partner2LastName,  
			isnull(IIF(pr2.Profilepic is null, null, CONCAT('".base_url()."profile_pictures/',pr2.Profilepic)) , null) as Partner2_Profilepic,	tm.Tourn_match_id, tm.BracketID, tm.Round_Num, tm.Match_Num, tm.Winner, tm.Match_DueDate as Match_Date, tm.Player1_points, tm.Player2_points, tm.Draw_Type, tm.Player1_Score, tm.Player2_Score from tournament t inner join Brackets b 
			on b.Tourn_ID = t.tournament_ID AND b.is_Publish = 1 inner join Tournament_Matches tm on tm.BracketID = b.BracketID left outer join users u1 
			on u1.users_id = tm.Player1 left outer join users u2 on u2.users_id = tm.Player2 left outer join users pr1 
			on tm.Player1_Partner = pr1.Users_ID left outer join users pr2 on tm.Player2_partner = pr2.Users_ID 
			where t.Tournament_id = {$tid}");
			}

		return $get_res->result();
	}


	public function get_TeamLineMatches($match_id){

			$get_res = $this->db->query("SELECT tl.Tourn_ID, isnull(IIF(u1.Firstname is null and winner <> 0 , 'BYE', u1.Firstname) , ' ') as PlayerFirstName , isnull(IIF(u1.Lastname is null and winner <> 0 , ' ', u1.Lastname) , ' ') as PlayerLastName, isnull(IIF(u1.Profilepic is null, null, CONCAT('".base_url()."profile_pictures/',u1.Profilepic)) , null) as Player1_Profilepic, isnull(IIF(u2.Firstname is null and winner <> 0 , 'BYE', u2.Firstname) , ' ') as PlayerFirstName,  isnull(IIF(u2.Lastname is null and winner <> 0 , ' ', u2.Lastname) , ' ') as PlayerLastName, isnull(IIF(u2.Profilepic is null, null, CONCAT('".base_url()."profile_pictures/',u2.Profilepic)) , null) as Player2_Profilepic, pr1.Firstname as PartnerFirstName , pr1.LastName as PartnerLastName, isnull(IIF(pr1.Profilepic is null, null, CONCAT('".base_url()."profile_pictures/',pr1.Profilepic)) , null) as Partner1_Profilepic, pr2.Firstname as PartnerFirstName , pr2.LastName as PartnerLastName, isnull(IIF(pr2.Profilepic is null, null, CONCAT('".base_url()."profile_pictures/',pr2.Profilepic)) , null) as Partner2_Profilepic, tl.* from Tournament_Lines tl left outer join users u1 on u1.users_id = tl.Player1 left outer join users u2 on u2.users_id = tl.Player2 left outer join users pr1 on tl.Player1_Partner = pr1.Users_ID left outer join users pr2 on tl.Player2_partner = pr2.Users_ID where tl.Tourn_match_id = " . $match_id);

		return $get_res->result();
	}
		
		public function get_event_reg_count($tourn_id, $event){
			$query = $this->db->query("SELECT * FROM RegisterTournament WHERE Tournament_ID='".$tourn_id."' AND Reg_Events LIKE '%".'"'.$event.'"'."%'");
             return $query->num_rows();
		}

		public function get_draw($bid){
			$qry = $this->db->query("SELECT * FROM Brackets WHERE BracketID = {$bid}");
			return $qry->row_array();
		}

		public function get_tourn_matches($bracket_id){
			$data1 = array('BracketID' => $bracket_id);

							//$this->db->order_by('Match_DueDate','ASC');
							$this->db->order_by('Tourn_match_id','asc');
			$query = $this->db->get_where('Tournament_Matches', $data1);

			return $query;
		}

		public function get_reg_players($tourn_id){				   
			$data = array('Tournament_ID'=>$tourn_id);
			$query = $this->db->get_where('RegisterTournament',$data);
			return $query->result();
		}

		public function get_player_matches($tourn_id, $player){
			$query = $this->db->query("SELECT * FROM Tournament_Matches WHERE Tourn_ID = {$tourn_id} AND (Player1 = {$player} OR Player2 = {$player} OR Player1_Partner = {$player} OR Player2_Partner = {$player}) AND Winner IS NOT NULL AND Winner != '' AND Player1 != 0 AND Player2 != 0");
			//echo $this->db->last_query();
			return $query->result_array();
		}

		public function get_user_name($user_id){
			$data = array('Users_ID'=>$user_id);
			$get_sp_name = $this->db->get_where('users',$data);
			return $get_sp_name->row_array();
		}

		public function update_player_standings($user_id, $tourn_id, $bracket_id, $a2m_points){
				$data = array('Users_ID' => $user_id, 'Tourn_ID' => $tourn_id, 'Bracket_ID' => $bracket_id);
				$qry = $this->db->get_where('Users_League_Rating', $data);
				$get_rec = $qry->row_array();

				if($get_rec){
					$upd_points = $get_rec['Upd_Rating'] + $a2m_points;

					$data2 = array('Upd_Rating' => $upd_points,'Updated_On' => date('Y-m-d H:i:s'));
					$this->db->where('Rating_ID', $get_rec['Rating_ID']);
					$a2mscore_upd_qry1 = $this->db->update('Users_League_Rating', $data2);
				}

		}

		public function get_matches($tourn_id){
				$qry  = $this->db->query("SELECT * FROM Tournament_Matches WHERE Tourn_ID = {$tourn_id}");
				return $qry->result();
		}

		public function get_lg_std_init_ratings($user_id, $tourn_id){
				$qry  = $this->db->query("SELECT MIN(Init_Rating) AS Init_Rating FROM Users_League_Rating WHERE Users_ID = {$user_id} AND Tourn_ID = {$tourn_id}");

				if($qry->num_rows() > 0)
					return $qry->row_array();
				else
					return false;
		}

		public function get_draw_std_init_ratings($user_id, $bid){
				$qry  = $this->db->query("SELECT * FROM Users_League_Rating WHERE Users_ID = {$user_id} AND Bracket_ID = {$bid}");

				if($qry->num_rows() > 0)
					return $qry->row_array();
				else
					return false;
		}

		public function get_lg_std_final_ratings($user_id, $tourn_id, $init_rating){
				$qry  = $this->db->query("SELECT * FROM Users_League_Rating WHERE Users_ID = {$user_id} AND Tourn_ID = {$tourn_id}");

				$res =  $qry->result_array();
				$cm = 0;
				foreach($res as $r){
					$cm += $r['Upd_Rating'] - $r['Init_Rating'];
				}

				return $init_rating+$cm;
		}

		public function get_league_occr($tourn_id){
			$qry = $this->db->query("SELECT * FROM League_OCCR WHERE Tourn_ID = {$tourn_id}");
			return $qry->result();
		}

		public function remove_user_game_day($game_day, $user_id){
			$qry = $this->db->query("DELETE FROM League_OCCR_Regs WHERE Users_ID = {$user_id} AND OCCR_ID = {$game_day}");
			return $qry;
		}

		public function get_league_occr_regs($tourn_id, $user_id){
			$qry = $this->db->query("SELECT * FROM League_OCCR_Regs where Users_ID = {$user_id} AND Reg_ID in (SELECT RegisterTournament_id from RegisterTournament where Tournament_ID = {$tourn_id})");
			return $qry->result_array();
		}

		public function get_tourn_coupons($tourn_id=''){
			$qry = $this->db->query("SELECT * FROM Coupon_Codes WHERE Ref_ID = $tourn_id");
			return $qry->result();
		}

		public function validateCoupon($tourn_id, $coupon){
			$qry = $this->db->query("SELECT * FROM Coupon_Codes WHERE Ref_ID = $tourn_id AND  Coupon_Code = '{$coupon}'");
			return $qry->row_array();
		}


		public function ins_game_days($reg_id, $user_id, $game_days){
			if($game_days){
				foreach($game_days as $gd){
						$data9 = array(
						'Users_ID'				 => $user_id,
						'Reg_ID'				 => $reg_id,
						'OCCR_ID'			 => $gd,
						'Amount'				 => NULL,
						'OCCR_Reg_Date'	 => date('Y-m-d H:i:s'),
						'Transaction_id'		 => NULL,
						'Status'					 => NULL,
						'Currency_Code'	 => NULL,
						'Reg_Source'			 => 'APP'
						);

						$result   = $this->db->insert('League_OCCR_Regs', $data9);
				}
			}
		}
}