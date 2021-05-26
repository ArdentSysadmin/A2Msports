<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

	class model_league extends CI_Model {
		
		public function __construct()
		{
			parent:: __construct();
			$this->load->database();
		}

		/*public function get_intrests()
		{

			$user_id = $this->session->userdata('users_id');
			$data = array('Users_ID'=>$user_id);
			
			$qry_check = $this->db->get_where('Sports_Interests', $data);
			return $qry_check->result();
		
		}*/
		
		public function get_intrests()
		{
			$query = $this->db->get('SportsType');
			return $query->result();
		}
		
		public function get_reg_tournment($tourn_id)
		{
			$user_id = $this->session->userdata('users_id');
			$data = array('Tournament_ID'=>$tourn_id ,'Users_ID'=>$user_id);
			$query = $this->db->get_where('RegisterTournament',$data);
			return $query->row_array();
		}

		public function get_reg_tourn_player_names($tourn_id)
		{
			$data = array('Tournament_ID'=>$tourn_id);
			$get_tourn_names = $this->db->get_where('RegisterTournament',$data);
			return $get_tourn_names->result();
		}

		public function get_reg_tourn_partner_names($tourn_id)
		{
			$type = 'Doubles';
			$qry_check = $this->db->query("SELECT * FROM RegisterTournament WHERE Tournament_ID = $tourn_id AND Match_Type  LIKE '%$type%'");
			return $qry_check->result();
		}

		public function get_reg_tourn_participants($tourn_id)
		{
			
			$qry_check = $this->db->query("SELECT * FROM RegisterTournament WHERE Tournament_ID = $tourn_id");
			return $qry_check->result();
		}

		public function is_bracket_exists($tourn_id)
		{
			
			$data = array('Tourn_ID'=>$tourn_id, 'Match_Type'=>'Doubles', 'Bracket_Type'=>'Round Robin');
			$query = $this->db->get_where('Brackets',$data);
			
			if ($query->num_rows() > 0){
				return true;
			} else {
				return false;
			}

		}
		public function tourn_title($tourn_id)
		{
			
			$data = array('Tournament_ID'=>$tourn_id);
			$query = $this->db->get_where('RegisterTournament',$data);
			return $query->row_array();
		}

		public function get_tour_row_info($row_id)
		{
			$data = array('Tourn_match_id'=>$row_id);
			$query = $this->db->get_where('Tournament_Matches',$data);
			
			return $query->row_array();
		}

		public function check_tourn($tourn_id)
		{
			$data = array('tournament_ID'=>$tourn_id);
			$query = $this->db->get_where('tournament',$data);
			$points = $get_sp_name->row_array();

			if ($query->num_rows() > 0){
					
				$users_id = $this->session->userdata('users_id');
				$lat = $this->session->userdata('lat');
				$long = $this->session->userdata('long');
				$range = 50;

				$qry_check = $this->db->query("SELECT *, ACOS( SIN( RADIANS( Latitude ) ) * SIN( RADIANS( $lat ) ) + COS( RADIANS( Latitude ) )
* COS( RADIANS( $lat )) * COS( RADIANS( Longitude ) - RADIANS( $long )) ) * 3964.3 AS distance FROM tournament WHERE ACOS( SIN( RADIANS( Latitude )) * SIN( RADIANS( $lat ) ) + COS( RADIANS( Latitude ) ) * COS( RADIANS( $lat )) * COS( RADIANS( Longitude ) - RADIANS( $long )) ) * 3964.3 < {$range} AND Usersid = $users_id ");

				$res = $qry_check->result();
			
				if(count($res) > 0){
					return true;
				}
				else{
					return false;
				}
			}
			else{
				return false;
			}
		}


		public function insert_tournament($data)
		{
			$lat_long = $data['latt'];
					
			$pieces = explode("@", $lat_long);
			$latitude = $pieces[0];
			$longitude = $pieces[1];
		
			$users_id = $this->session->userdata('users_id');

			$data = $this->upload->data();
			$filename = $data['file_name'];

			$title = $this->input->post('title');
			$organizer = $this->input->post('organizer');
			$org_contact = $this->input->post('org_contact');

			//$sdate = $this->input->post('sdate');   substr("Hello world",3) lo world
			
			$sdate = date('Y-m-d', strtotime($this->input->post('sdate')));
			$edate = date('Y-m-d',strtotime($this->input->post('edate')));

			$reg_closedon = date('Y-m-d',strtotime($this->input->post('reg_closedon')));
			
			$max_players = $this->input->post('max_players');
			$venue = $this->input->post('venue');
			$addr1 = $this->input->post('addr1');
			$addr2 = $this->input->post('addr2');
			
		//	$addr = $addr1 . ',' .$addr2;


			$country = $this->input->post('country');
			if($country =='United States of America') {
				$state = $this->input->post('state');
			}
			else {
				$state = $this->input->post('state1');
			}
			
			$city = $this->input->post('city');
			$zipcode = $this->input->post('zipcode');
			$desc = $this->input->post('desc');
			$fee = $this->input->post('fee');
			$amt = $this->input->post('amt_one');
			
			$review = $this->input->post('recommend');
			$age = json_encode($_POST['age']);
			$singles = json_encode($_POST['singles']);
			//$gender_type = json_encode($_POST['gender_type']);

			$gender_type = $this->input->post('gender_type');

			$sport_type = $this->input->post('sport_type');

			$tourn_type = $this->input->post('tourn_type');

			$extra_amt = $this->input->post('amt_two');
			
			//$reg_date = date("Y-m-d h:i:s");

			

			$data = array(
					'Usersid' => $users_id,
					//'Userdetailprofileid' => $lname,
					'tournament_title' => $title,
					'OrganizerName' => $organizer,
					'ContactNumber' => $org_contact,
					'TournamentImage'=>$filename,
					'StartDate' => $sdate,
					'EndDate' => $edate,
					'Registrationsclosedon' => $reg_closedon,
					'Age' => $age,
					'Singleordouble' => $singles,
					'Gender' => $gender_type,
					'Maxplayertournment' => $max_players,
					'Venue' => $venue,
					'TournamentAddress' => $addr1,
					'TournamentCountry' => $country,
					'TournamentState' => $state,
					'TournamentCity' => $city,
					'TournamentDescription' => $desc,
					'Tournamentfee' => $fee,
					'TournamentAmount' => $amt,
					'extrafee' => $extra_amt,
					'SportsType' => $sport_type,
					'Tournament_type' => $tourn_type,
					'latitude' => $latitude,
					'longitude'=> $longitude,
					'TournmentReview' => $review,
					'PostalCode' => $zipcode
				);
		

			$this->db->insert('tournament', $data);

		    $insert_id = $this->db->insert_id();

			$data = array('sport_id'=>$sport_type,'tourn_id'=>$insert_id);
			
			return $data;
		}


		public function update_tournament($data)
		{
			
			$lat_long = $data['latt']; 
			$img = $data['up_image'];
					
			$pieces = explode("@", $lat_long);
			$latitude = $pieces[0];
			$longitude = $pieces[1];

			$tourn_id = $data['tourn_id'];
		
			$users_id = $this->session->userdata('users_id');

			//$data = $this->upload->data();
			$filename = $img['file_name'];

			$title = $this->input->post('title');
			$organizer = $this->input->post('organizer');
			$org_contact = $this->input->post('org_contact');

			//$sdate = $this->input->post('sdate');   substr("Hello world",3) lo world
			
			$sdate = date('Y-m-d', strtotime($this->input->post('sdate')));
			$edate = date('Y-m-d',strtotime($this->input->post('edate')));

			$reg_closedon = date('Y-m-d',strtotime($this->input->post('reg_closedon')));
			
			$max_players = $this->input->post('max_players');
			$venue = $this->input->post('venue');
			$addr1 = $this->input->post('addr1');
			$addr2 = $this->input->post('addr2');
			
		//	$addr = $addr1 . ',' .$addr2;


			$country = $this->input->post('country');
			if($country =='United States of America') {
				$state = $this->input->post('state');
			}
			else {
				$state = $this->input->post('state1');
			}
			
			$city = $this->input->post('city');
			$zipcode = $this->input->post('zipcode');
			$desc = $this->input->post('desc');
			$fee = $this->input->post('fee');
			$amt = $this->input->post('amt_one');
			
			$review = $this->input->post('recommend');
			$age = json_encode($_POST['age']);
			$singles = json_encode($_POST['singles']);
			//$gender_type = json_encode($_POST['gender_type']);

			$gender_type = $this->input->post('gender_type');

			//$sport_type = $this->input->post('sport_type');

			$tourn_type = $this->input->post('tourn_type');

			$extra_amt = $this->input->post('amt_two');
			
			//$reg_date = date("Y-m-d h:i:s");

			

			$data = array(
					'Usersid' => $users_id,
					//'Userdetailprofileid' => $lname,
					'tournament_title' => $title,
					'OrganizerName' => $organizer,
					'ContactNumber' => $org_contact,
					'TournamentImage'=>$filename,
					'StartDate' => $sdate,
					'EndDate' => $edate,
					'Registrationsclosedon' => $reg_closedon,
					'Age' => $age,
					'Singleordouble' => $singles,
					'Gender' => $gender_type,
					'Maxplayertournment' => $max_players,
					'Venue' => $venue,
					'TournamentAddress' => $addr1,
					'TournamentCountry' => $country,
					'TournamentState' => $state,
					'TournamentCity' => $city,
					'TournamentDescription' => $desc,
					'Tournamentfee' => $fee,
					'TournamentAmount' => $amt,
					'extrafee' => $extra_amt,
					'Tournament_type' => $tourn_type,
					'latitude' => $latitude,
					'longitude'=> $longitude,
					'TournmentReview' => $review,
					'PostalCode' => $zipcode
				);
			
			//echo "<pre>";
			//print_r($data);
			//exit;
			$this->db->where('tournament_ID', $tourn_id);

			$result = $this->db->update('tournament', $data);

			$data = array('tourn_id'=>$tourn_id,'title'=>$title);
			
			return $data;
		}

		public function get_reg_players($tourn_id)
		{				   
			$data = array('Tournament_ID'=>$tourn_id);
			$query = $this->db->get_where('RegisterTournament',$data);
			return $query->result();
		}

		public function getonerow($tourn_id)
		{				   
			$data = array('tournament_ID'=>$tourn_id);
			$query = $this->db->get_where('tournament',$data);
			return $query->row();
		}

		public function get_sport_users($sport_id,$country,$state)
		{
			
			$qry_check = $this->db->query("SELECT u.Users_ID,u.Firstname,u.Lastname, u.EmailID FROM Users u inner join Sports_Interests s on u.Users_ID = s.users_id WHERE u.Country = '$country' AND u.State = '$state' AND s.Sport_id = $sport_id");
			
			return $qry_check->result();
		
		}


		public function get_main_tourn_ids()
		{
			
			//$users_id = $this->session->userdata('users_id');

			$this->db->distinct();
			$this->db->select('Tournament_id');
			$this->db->from('Tournament_Images');
			//$this->db->where('Users_id',$users_id);
			$query=$this->db->get();
			return $query->result();
			
		}

		public function get_admin_tourn_images($data)
		{
			
			  $xyz = 0;		
			  if(isset($data))
			  {
				$trnm_ids = array();

				$trnm_ids = $data;
				
				$items = count(array_filter($trnm_ids));
				
				$i = 0;
				if($items > 0)
				{
					$xyz = "";
					foreach($trnm_ids as $row)  
					{
						$xyz .= "'$row->Tournament_id'";

						if(++$i != $items) {
							$xyz .= ",";
						}
					}
				} 
			
			  }


			$qry_check = $this->db->query("SELECT * FROM tournament WHERE tournament_ID IN ($xyz)");
			return $qry_check->result();

		}

		public function get_individual_tourn_images($tourn_id)
		{
		
			$data = array('Tournament_id'=>$tourn_id);
			$query = $this->db->get_where('Tournament_Images',$data);
			return $query->result();
	
		}

		public function get_sport_name($sport_id){
			
			$data = array('SportsType_ID'=>$sport_id);
			$get_sp_name = $this->db->get_where('SportsType',$data);
			return $get_sp_name->row_array();
		}
		

		public function get_user_name($user_id){
			
			$data = array('Users_ID'=>$user_id);
			$get_sp_name = $this->db->get_where('users',$data);
			return $get_sp_name->row_array();
		}

		public function reg_tourn_no_fee()
		{
			$user_id = $this->session->userdata('users_id');
			$tourn_id = $this->input->post('id');
			
			$match_types = json_encode($this->input->post('mtype'));
			
			$fee = $this->input->post('tour_fee');

			$age_group = $this->input->post('age_group');

			$partner1 = $this->input->post('created_users_id');

			$partner2 = $this->input->post('created_users_id1');
			
			$reg_date = date("Y-m-d h:i:s");

			$data = array (
					'Users_ID' => $user_id,
					'Tournament_ID' => $tourn_id,
					'Match_Type' => $match_types,
					'Fee' => $fee,
					'Partner1' => $partner1,
					'Partner2' => $partner2,
					'Reg_Age_Group' => $age_group,
					'Reg_date' => $reg_date
					);
			
			$result = $this->db->insert('RegisterTournament', $data);	
			return $result;
		}

		public function reg_tourn_with_fee($data)
		{
			$user_id = $this->input->get('player');
			$tourn_id = $this->input->get('tourn_id');
		
			$match_types = $this->input->get('mtypes');
			
			$fee = $data['payment_amt'];

			$currency_code = $data['currency_code'];

			$age_group = $this->input->get('age_group');

			$partner1 = $this->input->get('partner1');
			$partner2 = $this->input->get('partner2');

			$trans_id = $data['txn_id'];
			$status = $data['status'];

			$reg_date = date("Y-m-d h:i:s");

			$data = array (
					'Users_ID' => $user_id,
					'Tournament_ID' => $tourn_id,
					'Match_Type' => $match_types,
					'Fee' => $fee,
					'Partner1' => $partner1,
					'Partner2' => $partner2,
					'Reg_Age_Group' => $age_group,
					'Reg_date' => $reg_date,
					'Transaction_id' => $trans_id,
					'Status' => $status,
					'Currency_Code' => $currency_code
					);
		
			$result = $this->db->insert('RegisterTournament', $data);	
			return $result;
		}

		public function search_autocomplete($data)
		{
			//$sql = "SELECT Firstname ,Lastname FROM users WHERE player_name LIKE '%$my_data%' ORDER BY player_name";
			
			$key = $data['key'];
			
			$this->db->select('*');
			$this->db->from('users');
			$this->db->like('Firstname', $key); 
			$this->db->or_like('Lastname', $key);
			
			$query = $this->db->get();
			return $query->result();
			//$this->db->like('title', 'match', 'both'); 
		}

		public function get_fixtures_det($tourn_id)
		{
			$data = array('tournament_ID'=>$tourn_id);
			$get_name = $this->db->get_where('tournament',$data);
			return $get_name->row_array();
		}

		public function get_sport_title($sport_id){
			
			$data = array('SportsType_ID'=>$sport_id);
			$get_sp_name = $this->db->get_where('SportsType',$data);
			return $get_sp_name->row_array();
		}

		public function get_reg_tourn_users($tourn_id)
		{
		
			
			//$type = $data['types'];
			
			//$data = array('Tournament_ID'=>$tourn_id,'Match_Type' =>$type);
			//$data = array('Tournament_ID'=>$tourn_id);
			//print_r($data);
			//exit;
			//$get_name = $this->db->get_where('RegisterTournament',$data);
			//return $get_name->result();
		
		}
		public function get_reg_tourn_usernames($tourn_id)
		{
			$qry_check = $this->db->query("SELECT u.Users_ID,u.Firstname,u.Lastname FROM RegisterTournament t inner join Users u on u.Users_ID = t.Users_ID WHERE Tournament_ID = $tourn_id");

			return $qry_check->result();
		}

		public function get_reg_tourn_age_usernames($data)
		{
			$tourn_id = $data['tourn_id'];
			$age_group = $data['age_group'];
			$match_type= $data['match_type'];

			$user_id = $this->session->userdata('users_id');

			if($match_type == 'Singles'){

				$qry_check = $this->db->query("SELECT u.Users_ID, u.Firstname, u.Lastname, u.UserAgegroup FROM Users u inner join RegisterTournament t on u.Users_ID = t.Users_ID WHERE t.Tournament_ID = $tourn_id AND t.Match_Type LIKE '%$match_type%' AND t.Reg_Age_Group ='$age_group'");
			}
			else if($match_type == 'Doubles'){
			
			$qry_check = $this->db->query("SELECT Users_ID ,Partner1 FROM RegisterTournament WHERE Tournament_ID = $tourn_id AND Match_Type LIKE '%$match_type%' AND Reg_Age_Group ='$age_group'");
			}
			else if($match_type == 'Mixed'){
			
			$qry_check = $this->db->query("SELECT u.Users_ID, u.Firstname, u.Lastname, u.UserAgegroup FROM Users u inner join RegisterTournament t on u.Users_ID = t.Partner2 WHERE t.Tournament_ID = $tourn_id AND t.Match_Type LIKE '%$match_type%' AND t.Reg_Age_Group ='$age_group'");
			}

			return $qry_check->result();
		}

		public function get_single_users($data)
		{

			$tourn_id = $data['tourn_id'];
			$age_group = $data['age_group'];
			$match_type= 'Singles';
			$user_id = $this->session->userdata('users_id');

			$qry_check = $this->db->query("SELECT u.Users_ID,u.Firstname,u.Lastname,u.A2MScore ,u.UserAgegroup FROM Users u inner join RegisterTournament t on u.Users_ID = t.Users_ID WHERE t.Tournament_ID = $tourn_id AND t.Match_Type  LIKE '%$match_type%'  AND t.Reg_Age_Group ='$age_group' order by u.A2MScore desc");

			return $qry_check->result();

		}

		public function registered_players($data)
		{
	
			$tourn_id = $data['tourn_id'];
			$match_type= $data['match_type'];
			$age_group = $data['age_group'];

			if($match_type == 'Singles'){

				$qry_check = $this->db->query("SELECT t.Match_Type,t.Reg_Age_Group, u.Users_ID, u.Firstname, u.Lastname, u.UserAgegroup FROM Users u inner join RegisterTournament t on u.Users_ID = t.Users_ID WHERE t.Tournament_ID = $tourn_id AND t.Match_Type LIKE '%$match_type%' AND t.Reg_Age_Group ='$age_group'");
			}
			else if($match_type == 'Doubles'){
			
			$qry_check = $this->db->query("SELECT Users_ID ,Partner1 ,Match_Type,Reg_Age_Group FROM RegisterTournament WHERE Tournament_ID = $tourn_id AND Match_Type LIKE '%$match_type%' AND Reg_Age_Group ='$age_group'");
			}
			else if($match_type == 'Mixed'){
			
			$qry_check = $this->db->query("SELECT t.Match_Type, t.Reg_Age_Group, u.Users_ID, u.Firstname, u.Lastname, u.UserAgegroup FROM Users u inner join RegisterTournament t on u.Users_ID = t.Partner2 WHERE t.Tournament_ID = $tourn_id AND t.Match_Type LIKE '%$match_type%' AND t.Reg_Age_Group ='$age_group'");
			}

			return $qry_check->result();

		}

		public function participants($data)
		{
		
			$tourn_id = intval($data['tourn_id']);
			$match_type= $data['match_type'];
			$age_group = $data['age_type'];

			if($match_type == 'Singles'){

				$qry_check = $this->db->query("SELECT u.Users_ID, u.Firstname, u.Lastname, u.UserAgegroup FROM Users u inner join RegisterTournament t on u.Users_ID = t.Users_ID WHERE t.Tournament_ID = $tourn_id AND t.Match_Type LIKE '%$match_type%' AND t.Reg_Age_Group ='$age_group'");
			}
			else if($match_type == 'Doubles'){
			
			//$qry_check = $this->db->query("SELECT Users_ID, Partner1 FROM RegisterTournament WHERE Tournament_ID = $tourn_id AND Match_Type LIKE '%$match_type%' AND Reg_Age_Group ='$age_group'");
			
			$qry_check = $this->db->query("SELECT u.Users_ID, u.Firstname, u.Lastname, u.UserAgegroup,t.Partner1 FROM Users u inner join RegisterTournament t on u.Users_ID = t.Users_ID WHERE t.Tournament_ID = $tourn_id AND t.Match_Type LIKE '%$match_type%' AND t.Reg_Age_Group ='$age_group'");

			}
			else if($match_type == 'Mixed'){
			
			$qry_check = $this->db->query("SELECT u.Users_ID, u.Firstname, u.Lastname, u.UserAgegroup FROM Users u inner join RegisterTournament t on u.Users_ID = t.Partner2 WHERE t.Tournament_ID = $tourn_id AND t.Match_Type LIKE '%$match_type%' AND t.Reg_Age_Group ='$age_group'");
			}

			 //print_r($this->db->last_query());
			 //exit;
			return $qry_check->result();

		}

		

		public function get_match_types($tourn_id)
		{
			$data = array('Tournament_ID'=>$tourn_id);
			$get_tourn_ids = $this->db->get_where('RegisterTournament',$data);
			return $get_tourn_ids->result();
		
		}

		public function insert_rr_brackets()   // Insert Round Robin Tournament Brackets into db
		{

			$matches = $this->input->post('match');
			            
			$match_type = $this->input->post('match_type');
			$age_group = $this->input->post('age_group');
			$tourn_id = $this->input->post('tourn_id');

			$tourn_det = $this->get_fixtures_det($tourn_id);
			$draw_title = $this->input->post('draw_title');

			$bracket_type = $tourn_det['Tournament_type'];
			//$num_rounds = count($rounds);
			$created_on = date("Y-m-d h:i:s");

			$data = array (
					'Tourn_ID' => $tourn_id,
					'Bracket_Type' => $bracket_type,
					'Draw_Title' => $draw_title,
					'Created_on' => $created_on,
					'Match_Type' => $match_type,
					'Age_Group' => $age_group
					);
			
			 $this->db->insert('Brackets', $data);	

			 $bracket_id = $this->db->insert_id();      
			 
			 //Tournament_Matches
			$round = 1;
			$player1_score = "";
			$player2_score = "";
			$winner = "";
			$win_per = "";

	
				foreach($matches as $i => $match)
				{
					$player1_val = explode("-", $matches[$i][0]);
					$player2_val = explode("-", $matches[$i][1]);

				//	$player1_val = $matches[$i][0];
				//	$player2_val = $matches[$i][1];

					$data = array(
						'BracketID' => $bracket_id,
						'Tourn_ID' => $tourn_id,
						'Round_Num' => $round,
						'Match_Num' => $i,
						'Player1' => intval($player1_val[0]),
						'Player2' => intval($player2_val[0]),
						'Winner' => $winner,
						'Win_Per' => $win_per,
						'Player1_Partner' => $player1_val[1],
						'Player2_Partner' => $player2_val[1],
						'Draw_Type' => $bracket_type
					);
					
					$ins_to = $this->db->insert('Tournament_Matches', $data);
				}	
			
			if($ins_to){
				return true;
			}
			else{
				return false;
			}

		}


		public function insert_tourn_brackets() // Insert Single Elimination Tournament Brackets into db
		{

		/*	echo "<pre>";
			print_r($this->input->post('player1'));
			print_r($this->input->post('player2'));
			exit;
*/
			$rounds = $this->input->post('round');
			$matches = $this->input->post('match_num');
			$player1 = $this->input->post('player1');
			$player2 = $this->input->post('player2');
            
			$match_type = $this->input->post('match_type');
			$age_group = $this->input->post('age_group');


			$tourn_id = $this->input->post('tourn_id');
			$draw_title = $this->input->post('draw_title');

			$tourn_det = $this->get_fixtures_det($tourn_id);

			$bracket_type = $tourn_det['Tournament_type'];
			$num_rounds = count($rounds);
			$created_on = date("Y-m-d h:i:s");

			$data = array (
					'Tourn_ID' => $tourn_id,
					'Bracket_Type' => $bracket_type,
					'Draw_Title' => $draw_title,
					'No_of_rounds' => $num_rounds,
					'Created_on' => $created_on,
					'Match_Type' => $match_type,
					'Age_Group' => $age_group
					);
			
			 $this->db->insert('Brackets', $data);	

			 $bracket_id = $this->db->insert_id();      
			 
			 //Tournament_Matches
			$player1_score = "";
			$player2_score = "";
			$winner = "";
			$win_per = "";

			 foreach($rounds as $round)
			{
					//echo $round."<br>";
				foreach($matches[$round] as $match)
				{
					$player1_score = "";
					$player2_score = "";
					$winner = "";
					$win_per = "";

					$date_round = $this->input->post('round_date'.$round);
					$date_match = $this->input->post('match_date'.$match);

					$match_due_date = "";

					if($date_round != "") {
						$match_due_date = date("Y-m-d",strtotime($date_round));
					} 
					else if($date_match != "") {
						$match_due_date = date("Y-m-d",strtotime($date_match)); 
					}

					if($player1[$round][$match][0] == "---")
					{
						$player1_val = "";
					}
					else
					{
						$player1_val = intval($player1[$round][$match][0]);
						$player1_partner = explode("-", $player1[$round][$match][0]);
					}


					if($player2[$round][$match][0] == "---")
					{ 
						$player2_val = "";
					}
					else if($player2[$round][$match][0] == 0)
					{
						$player2_val = "";
						if($round==1){
							$player1_score = 'Bye Match';
							$player2_score = 'Bye Match';
							$winner = intval($player1[$round][$match][0]);
							$win_per = 0;
						}
					}
					else
					{
						$player2_val = intval($player2[$round][$match][0]);
						$player2_partner = explode("-", $player2[$round][$match][0]);
					}

					$player1_source = $player1[$round][$match][1];
					$player2_source = $player2[$round][$match][1];

					if($match_due_date == ""){
						$data = array(
							'BracketID' => $bracket_id,
							'Tourn_ID' => $tourn_id,
							'Round_Num' => $round,
							'Match_Num' => $match,
							'Player1' => $player1_val,
							'Player2' => $player2_val,
							'Player1_Score' => $player1_score,
							'Player2_Score' => $player2_score,
							'Winner' => $winner,   
							'Win_Per' => $win_per,
							'Player1_source' => $player1_source,
							'Player2_source' => $player2_source,
							'Player1_Partner' => intval($player1_partner[1]),
							'Player2_Partner' => intval($player2_partner[1]),
							'Draw_Type' => 'Main'
						);
					} else {
						$data = array(
							'BracketID' => $bracket_id,
							'Tourn_ID' => $tourn_id,
							'Round_Num' => $round,
							'Match_Num' => $match,
							'Player1' => $player1_val,
							'Player2' => $player2_val,
							'Player1_Score' => $player1_score,
							'Player2_Score' => $player2_score,
							'Winner' => $winner,   
							'Win_Per' => $win_per,
							'Player1_source' => $player1_source,
							'Player2_source' => $player2_source,
							'Player1_Partner' => intval($player1_partner[1]),
							'Player2_Partner' => intval($player2_partner[1]),
							'Draw_Type' => 'Main',
							'Match_DueDate' => $match_due_date
						);
					}

					
					$ins_to = $this->db->insert('Tournament_Matches', $data);
					unset($player1_partner);
					unset($player2_partner);
				}	
			}
			
// Consolation Draw Save Section Starts here ---------------------------------------------------------------------------------------------------

			if($bracket_type == 'Consolation'){

			$c_rounds = $this->input->post('c_round');
			$c_matches = $this->input->post('c_match_num');
			$c_player1 = $this->input->post('c_player1');
			$c_player2 = $this->input->post('c_player2');


			$c_player1_score = "";
			$c_player2_score = "";
			$c_winner = "";
			$c_win_per = "";

			 foreach($c_rounds as $c_round)
			{
					//echo $round."<br>";
				foreach($c_matches[$c_round] as $c_match)
				{
					$c_player1_score = "";
					$c_player2_score = "";
					$c_winner = "";
					$c_win_per = "";


					$date_cround = $this->input->post('cround_date'.$c_round);
					$date_cmatch = $this->input->post('cmatch_date'.$c_match);
					
				//($date_cround) ? $c_match_due_date = date("Y-m-d",strtotime($date_cround)) : $c_match_due_date = date("Y-m-d",strtotime($date_cmatch)); 

					$c_match_due_date = "";

					if($date_cround != "") {
						$c_match_due_date = date("Y-m-d",strtotime($date_cround));
					} 
					else if($date_cmatch != "") {
						$c_match_due_date = date("Y-m-d",strtotime($date_cmatch)); 
					}


					if($c_player1[$c_round][$c_match][0] == "")
					{
						$c_player1_val = "";
					}
					else
					{
						$c_player1_val = intval($c_player1[$c_round][$c_match][0]);
						$c_player1_partner = explode("-", $c_player1[$c_round][$c_match][0]);
					}


					if($c_player2[$c_round][$c_match][0] == "")
					{ 
						$c_player2_val = "";
					}
					else if($c_player2[$c_round][$c_match][0] == 0)
					{
						$c_player2_val = "";
						$c_player1_score = '';
						$c_player2_score = '';
						$c_winner = intval($c_player1[$c_round][$c_match][0]);
						$c_win_per = 0;
					}
					else
					{
						$c_player2_val = intval($c_player2[$c_round][$c_match][0]);
						$c_player2_partner = explode("-", $c_player2[$c_round][$c_match][0]);
					}

					$c_player1_source = $c_player1[$c_round][$c_match][1];
					$c_player2_source = $c_player2[$c_round][$c_match][1];

					if($c_match_due_date == ""){
					$data = array(
						'BracketID' => $bracket_id,
						'Tourn_ID' => $tourn_id,
						'Round_Num' => $c_round,
						'Match_Num' => $c_match,
						'Player1' => $c_player1_val,
						'Player2' => $c_player2_val,
						'Player1_Score' => $c_player1_score,
						'Player2_Score' => $c_player2_score,
						'Winner' => $c_winner,
						'Win_Per' => $c_win_per,
						'Player1_source' => $c_player1_source,
						'Player2_source' => $c_player2_source,
						'Player1_Partner' => intval($c_player1_partner[1]),
						'Player2_Partner' => intval($c_player2_partner[1]),
						'Draw_Type' => 'Consolation'
					);
					} else {

						$data = array(
							'BracketID' => $bracket_id,
							'Tourn_ID' => $tourn_id,
							'Round_Num' => $c_round,
							'Match_Num' => $c_match,
							'Player1' => $c_player1_val,
							'Player2' => $c_player2_val,
							'Player1_Score' => $c_player1_score,
							'Player2_Score' => $c_player2_score,
							'Winner' => $c_winner,
							'Win_Per' => $c_win_per,
							'Player1_source' => $c_player1_source,
							'Player2_source' => $c_player2_source,
							'Player1_Partner' => intval($c_player1_partner[1]),
							'Player2_Partner' => intval($c_player2_partner[1]),
							'Draw_Type' => 'Consolation',
							'Match_DueDate' => $c_match_due_date
						);

					}
					
					$ins_to = $this->db->insert('Tournament_Matches', $data);
					}	
				}		
			}

// Consolation Draw Save Section END here ---------------------------------------------------------------------------------------------------
		
			if($ins_to){
				return true;
			}
			else{
				return false;
			}
		}


		public function user_reg_or_not($user_id,$tourn_id)
		{
			$data = array('Tournament_ID'=>$tourn_id ,'Users_ID'=>$user_id);
			$query = $this->db->get_where('RegisterTournament',$data);

			if ($query->num_rows() > 0){
				return true;
			}
			else{
				return false;
			}
		}


		public function check_draw_title($tourn_id,$draw_title)
		{
			$data = array('Tourn_ID'=>$tourn_id ,'Draw_Title'=>$draw_title);
			$query = $this->db->get_where('Brackets',$data);

			if ($query->num_rows() > 0){
				return 1;
				
			}
			else{
				return 0;
				
			}
		}
		
		public function get_tourn_bracket($bid)
		{

			$data = array('BracketID' => $bid);
			$query = $this->db->get_where('Brackets',$data);

				return $query->row_array();
		}

		public function get_bracket_details()
		{
			$tourn_id = $this->input->post('tourn_id');
			$match_type = $this->input->post('match_type');
	
			$data = array('Tourn_ID' => $tourn_id, 'Match_Type' => $match_type);
			$query = $this->db->get_where('Brackets',$data);

			return $query->row_array();
		}

		public function get_match_scores_player1($source,$bracket_id,$tour_id)
		{
			
			$data = array('Match_Num'=>$source,'BracketID'=>$bracket_id,'Tourn_ID'=>$tour_id);
			$get_sp_name = $this->db->get_where('Tournament_Matches',$data);
			return $get_sp_name->row_array();
		}

		public function get_match_scores_player2($source,$bracket_id,$tour_id)
		{
			
			$data = array('Match_Num'=>$source,'BracketID'=>$bracket_id,'Tourn_ID'=>$tour_id);
			$get_sp_name = $this->db->get_where('Tournament_Matches',$data);
			return $get_sp_name->row_array();
		}

		public function get_bracket_exist($data)
		{
			$tourn_id = $data['tourn_id'];
			$match_type = $data['types'];
			$age_group = $data['type_format'];

			$data = array('Tourn_ID' => $tourn_id, 'Match_Type' => $match_type, 'Age_Group' => $age_group);
			$query = $this->db->get_where('Brackets',$data);

			//print_r($query);
			//exit;

			if ($query->num_rows() > 0){
				return true;
			}
			else{
				return false;
			}
		}

		public function get_bracket_rounds($data)
		{
			$bracket_id = $data['bracket_id'];
			$data = array('BracketID' => $bracket_id);
			$query = $this->db->get_where('Brackets',$data);
			return $query->row_array();
		}

		public function get_tourn_matches($data)
		{

			$bracket_id = $data['bracket_id'];

			$data = array('BracketID' => $bracket_id);
			$query = $this->db->get_where('Tournament_Matches',$data);

			return $query;
		}

		public function get_tourn_matches_main($bid)
		{
			$data = array('Draw_Type' => 'Main', 'BracketID' => $bid);
			$query = $this->db->get_where('Tournament_Matches',$data);

			return $query;
		}

		public function get_cd_tourn_matches($bid)
		{
			$data = array('Draw_Type' => 'Consolation', 'BracketID' => $bid);
			$query = $this->db->get_where('Tournament_Matches',$data);

			return $query;
		}

		public function get_cd_tot_rounds($bid)
		{
			$bracket_id = $bid;

			$qry_check = $this->db->query("SELECT COUNT(DISTINCT Round_Num) AS total_rounds FROM Tournament_Matches where BracketID = {$bracket_id} and Draw_Type = 'Consolation'");

			return $qry_check->row_array();
		}


		public function update_rr_tourn_match_score()
		{
					/* ------------------- A2MScore Calculation Section ---------------- */
			//$tourn_id = $data['tourn_id']; 
			$tourn_id = $this->input->post('tourn_id');
			$tourn_match_id = $this->input->post('tourn_match_id');

			//$draw_name = $this->input->post('draw_name');
			//$round_title = $this->input->post('round_title');

			$data = array('tournament_ID' => $tourn_id);
			$macth_init =  $this->db->get_where('tournament',$data);
			$match_init_user = $macth_init->row_array();

		$player1_user = $this->input->post('player1_user');
		$opp_user = $this->input->post('player2_user');
		$match_sport = $match_init_user['SportsType'];


			$data = array('SportsType_ID'=>$match_sport, 'Users_ID'=>$player1_user);
			$get_a2mscore1 = $this->db->get_where('A2MScore',$data);
			$p1_a2mscore = $get_a2mscore1->row_array();

			$data = array('SportsType_ID'=>$match_sport, 'Users_ID'=>$opp_user);
			$get_a2mscore2 = $this->db->get_where('A2MScore',$data);
			$p2_a2mscore = $get_a2mscore2->row_array();


		$player1_a2mscore = $p1_a2mscore['A2MScore'];
		$player2_a2mscore = $p2_a2mscore['A2MScore'];

		$score_diff = abs($player1_a2mscore - $player2_a2mscore);

		($player1_a2mscore >= $player2_a2mscore) ? $max_a2mscore_user = $player1_user : $max_a2mscore_user = $opp_user;

/*--------------- Sets score calculation start --------------*/
		$i=0;
		$player1_score = "[";
		$player1_score_total = 0;

		$player1_scr_inp = $this->input->post('player1');
		$player2_scr_inp = $this->input->post('player2');

		$p1_sets_win = 0;
		$p2_sets_win = 0;

		$p1_points = 0;
		$p2_points = 0;

		foreach($player1_scr_inp as $s => $set_score)
			{

				if($set_score!="")
				{
					if ($i != 0)
					{
						$player1_score .= ",";
					}
						if($player1_scr_inp[$s] > $player2_scr_inp[$s])
						{
							$p1_sets_win++;
						}
						else if($player1_scr_inp[$s] < $player2_scr_inp[$s])
						{
							$p2_sets_win++;
						}

					$player1_score .= "$set_score";
					$player1_score_total += intval($set_score);
					++$i;		
				}
				

			}
		$player1_score .= "]";
	
		if($p1_sets_win > $p2_sets_win){
			$p1_points = 3;
			($p2_sets_win > 0) ? $p2_points = 1 : $p2_points = 0;
		}
		else if($p2_sets_win > $p1_sets_win){
			$p2_points = 3;
			($p1_sets_win > 0) ? $p1_points = 1 : $p1_points = 0;
		}

		$j=0;
		$player2_score = "[";
		$player2_score_total = 0;
		foreach($player2_scr_inp as $set_score)
			{

				if($set_score!="")
				{
					if ($j !=0)
					{
						$player2_score .= ",";
					}
					$player2_score .= "$set_score";
					$player2_score_total += intval($set_score);
					++$j;
				}
				//if(++$j!=count(array_filter($this->input->post('player2'))) and $set_score!="")
				//{
				//	$player2_score .= ",";
				//}

			}
		$player2_score .= "]";

		$tot_score = $player1_score_total + $player2_score_total;

/*--------------- Sets score calculation end --------------*/


	//	$winner = $this->input->post('id');
	if($player1_score_total >= $player2_score_total){
		$winner = $player1_user;
	}
	else{
		$winner = $opp_user;
	}

		($winner == $player1_user) ? $loser = $opp_user : $loser = $player1_user;

				$i=0;$j=12;
				while($i<=238)
				{
				 if(($score_diff >= $i) && ($score_diff <= $j))
				 { 
					 switch($score_diff)
					 {
						 case ($score_diff >= 0) && ($score_diff <= 12):
							 ($winner == $max_a2mscore_user) ? $add_score_points = 8 : $add_score_points = 8;
							break;
						 case ($score_diff >= 13) && ($score_diff <= 37):
							 ($winner == $max_a2mscore_user) ? $add_score_points = 7 : $add_score_points = 10;
							break;
						 case ($score_diff >= 38) && ($score_diff <= 62):
							 ($winner == $max_a2mscore_user) ? $add_score_points = 6 : $add_score_points = 13;
							break;
						 case ($score_diff >= 63) && ($score_diff <= 87):
							 ($winner == $max_a2mscore_user) ? $add_score_points = 5 : $add_score_points = 16;
							break;
						 case ($score_diff >= 88) && ($score_diff <= 112):
							 ($winner == $max_a2mscore_user) ? $add_score_points = 4 : $add_score_points = 20;
							break;
						 case ($score_diff >= 113) && ($score_diff <= 137):
							 ($winner == $max_a2mscore_user) ? $add_score_points = 3 : $add_score_points = 25;
							break;
						 case ($score_diff >= 138) && ($score_diff <= 162):
							 ($winner == $max_a2mscore_user) ? $add_score_points = 2 : $add_score_points = 30;
							break;
						 case ($score_diff >= 163) && ($score_diff <= 187):
							 ($winner == $max_a2mscore_user) ? $add_score_points = 2 : $add_score_points = 35;
							break;
						 case ($score_diff >= 188) && ($score_diff <= 212):
							 ($winner == $max_a2mscore_user) ? $add_score_points = 1 : $add_score_points = 40;
							break;
						 case ($score_diff >= 213) && ($score_diff <= 237):
							 ($winner == $max_a2mscore_user) ? $add_score_points = 1 : $add_score_points = 45;
							break;
						 case ($score_diff >= 238):
							 ($winner == $max_a2mscore_user) ? $add_score_points = 0 : $add_score_points = 50;
							break;
					 }
				   }
				$i = $j + 1;
				$j = $i + 24;
				}

/* ------------------- A2MScore Calculation Section End ---------------- */


	
		$win_per_p1 = ($player1_score_total / $tot_score) * 100;
		
		$win_per_p2 = ($player2_score_total / $tot_score) * 100;
	

					 switch($win_per_p1)
					 {
						 case ($win_per_p1 >= 0) && ($win_per_p1 <= 9):
							 ($player1_user == $max_a2mscore_user) ? $add_win_points_p1 = 0 : $add_win_points_p1 = 1;
							break;
						 case ($win_per_p1 >= 10) && ($win_per_p1 <= 19):
							 ($player1_user == $max_a2mscore_user) ? $add_win_points_p1 = 0 : $add_win_points_p1 = 1;
							break;
						 case ($win_per_p1 >= 20) && ($win_per_p1 <= 29):
							 ($player1_user == $max_a2mscore_user) ? $add_win_points_p1 = 1 : $add_win_points_p1 = 2;
							break;
						 case ($win_per_p1 >= 30) && ($win_per_p1 <= 39):
							 ($player1_user == $max_a2mscore_user) ? $add_win_points_p1 = 3 : $add_win_points_p1 = 4;
							break;
						 case ($win_per_p1 >= 40) && ($win_per_p1 <= 49):
							 ($player1_user == $max_a2mscore_user) ? $add_win_points_p1 = 4 : $add_win_points_p1 = 6;
							break;
						 case ($win_per_p1 >= 50) && ($win_per_p1 <= 59):
							 ($player1_user == $max_a2mscore_user) ? $add_win_points_p1 = 6 : $add_win_points_p1 = 8;
							break;
						 case ($win_per_p1 >= 60) && ($win_per_p1 <= 69):
							 ($player1_user == $max_a2mscore_user) ? $add_win_points_p1 = 7 : $add_win_points_p1 = 10;
							break;
						 case ($win_per_p1 >= 70) && ($win_per_p1 <= 79):
							 ($player1_user == $max_a2mscore_user) ? $add_win_points_p1 = 8 : $add_win_points_p1 = 14;
							break;
						 case ($win_per_p1 >= 80) && ($win_per_p1 <= 89):
							 ($player1_user == $max_a2mscore_user) ? $add_win_points_p1 = 9 : $add_win_points_p1 = 17;
							break;
						 case ($win_per_p1 >= 90):
							 ($player1_user == $max_a2mscore_user) ? $add_win_points_p1 = 10 : $add_win_points_p1 = 20;
							break;
						default:
							 $add_win_points_p1 = 0;
						    break;
					 }


					 switch($win_per_p2)
					 {
						 case ($win_per_p2 >= 0) && ($win_per_p2 <= 9):
							 ($opp_user == $max_a2mscore_user) ? $add_win_points_p2 = 0 : $add_win_points_p2 = 1;
							break;
						 case ($win_per_p2 >= 10) && ($win_per_p2 <= 19):
							 ($opp_user == $max_a2mscore_user) ? $add_win_points_p2 = 0 : $add_win_points_p2 = 1;
							break;
						 case ($win_per_p2 >= 20) && ($win_per_p2 <= 29):
							 ($opp_user == $max_a2mscore_user) ? $add_win_points_p2 = 1 : $add_win_points_p2 = 2;
							break;
						 case ($win_per_p2 >= 30) && ($win_per_p2 <= 39):
							 ($opp_user == $max_a2mscore_user) ? $add_win_points_p2 = 3 : $add_win_points_p2 = 4;
							break;
						 case ($win_per_p2 >= 40) && ($win_per_p2 <= 49):
							 ($opp_user == $max_a2mscore_user) ? $add_win_points_p2 = 4 : $add_win_points_p2 = 6;
							break;
						 case ($win_per_p2 >= 50) && ($win_per_p2 <= 59):
							 ($opp_user == $max_a2mscore_user) ? $add_win_points_p2 = 6 : $add_win_points_p2 = 8;
							break;
						 case ($win_per_p2 >= 60) && ($win_per_p2 <= 69):
							 ($opp_user == $max_a2mscore_user) ? $add_win_points_p2 = 7 : $add_win_points_p2 = 10;
							break;
						 case ($win_per_p2 >= 70) && ($win_per_p2 <= 79):
							 ($opp_user == $max_a2mscore_user) ? $add_win_points_p2 = 8 : $add_win_points_p2 = 14;
							break;
						 case ($win_per_p2 >= 80) && ($win_per_p2 <= 89):
							 ($opp_user == $max_a2mscore_user) ? $add_win_points_p2 = 9 : $add_win_points_p2 = 17;
							break;
						 case ($win_per_p2 >= 90):
							 ($opp_user == $max_a2mscore_user) ? $add_win_points_p2 = 10 : $add_win_points_p2 = 20;
							break;
						default:
							 $add_win_points_p2 = 0;
						    break;
					 }

		//$a2mscore_add =  intval($add_score_points) + intval($add_score_points2);
		//$a2mscore_sub =  intval($add_score_points);


		// Winner score update
		if($winner == $player1_user) {
						
			$p1_a2mscore_updated =  intval($player1_a2mscore) +  intval($add_score_points) +  intval($add_win_points_p1);
			$p2_a2mscore_updated =  intval($player2_a2mscore) -  intval($add_score_points) +  intval($add_win_points_p2);

		} 
		else {
			
			$p1_a2mscore_updated =  intval($player1_a2mscore) -  intval($add_score_points) +  intval($add_win_points_p1);
			$p2_a2mscore_updated =  intval($player2_a2mscore) +  intval($add_score_points) +  intval($add_win_points_p2);
			}

	
		$played_date = $this->input->post('tour_match_date');

		/* A2MScore Table Update */
/*
echo "PLAYER 1<br><br>";

echo "ID -".$player1_user."<br>";
echo "A2MScore - ".$player1_a2mscore."<br>";
echo "Score - ".$player1_score_total."<br>";
echo "Win% - ".$win_per_p1."<br>";
echo "Win% points(+) = ".$add_win_points_p1."<br>";
echo "player1 -". $p1_a2mscore_updated."<br><br>";
echo "player1_points -". $p1_points."<br><br>";

echo "PLAYER 2<br><br>";

echo "ID -".$opp_user."<br>";
echo "A2MScore - ".$player2_a2mscore."<br>";
echo "Score - ".$player2_score_total."<br>";
echo "Win% - ".$win_per_p2."<br>";
echo "Win% points(+) = ".$add_win_points_p2."<br>";
echo "player2 -". $p2_a2mscore_updated."<br><br>";
echo "player2_points -". $p2_points."<br><br>";

echo "--------------"."<br>";

echo "Winner -". $winner."<br>";
echo "Score Diff -". $score_diff."<br>";
echo "Winner AddScore -". $add_score_points."<br>";
*/
//exit;

				$data = array ('A2MScore' => $p1_a2mscore_updated);
				
				$this->db->where('Users_ID', $player1_user);
				$this->db->where('SportsType_ID', $match_sport);

			$a2mscore_upd_qry1 = $this->db->update('A2MScore', $data);

				$data = array ('A2MScore' => $p2_a2mscore_updated);
				
				$this->db->where('Users_ID', $opp_user);
				$this->db->where('SportsType_ID', $match_sport);

			$a2mscore_upd_qry2 = $this->db->update('A2MScore', $data);

		/* --------------------- */


		/* Player Number of Matches Update */

		/*	$player1_user = $match_init_user['users_id'];
			$opp_user = $this->input->post('opp_user');
			$match_sport = $match_init_user['Sports'];*/

			$data = array('Users_ID'=>$player1_user,'Sport' =>$match_sport);   // Player 1
			$num = $this->db->get_where('Player_Matches_Count',$data);
			$c =  $num->row_array();

			if(empty($c))
			{
				if($winner == $player1_user) { $won = 1; $lost = 0; }  
				else { $won = 0; $lost = 1;  }

				$data = array('Num_Matches' => 1, 'Users_ID' => $player1_user,'Sport' => $match_sport,
				'Won' => $won, 'Lost' => $lost, 'Win_Per' => $win_per_p1);

				$p1_insert = $this->db->insert('Player_Matches_Count' ,$data);
			}
			else
			{
				$total = $c['Num_Matches'] + 1;

				$prev_wp = ($c['Win_Per'] * $c['Num_Matches']);

					if($winner == $player1_user) { 
					$won = intval($c['Won'])+1; 
					$lost = intval($c['Lost']);
					}  
				else { 
					$won = intval($c['Won']);   
					$lost = intval($c['Lost'])+1;   
					}

					$avg_win_per1 = number_format((($prev_wp + $win_per_p1) / $total), 2); 

				$data = array('Num_Matches' => $total,'Won' => $won, 'Lost' => $lost, 'Win_Per' => $avg_win_per1);

				$this->db->where('Users_ID', $player1_user);
				$this->db->where('Sport', $match_sport);
				$p1_update = $this->db->update('Player_Matches_Count' ,$data);
			}
			

			$data = array('Users_ID'=>$opp_user,'Sport' =>$match_sport);	// Player 2
			$num1 = $this->db->get_where('Player_Matches_Count',$data);
			$c1 =  $num1->row_array();

			if(empty($c1))
			{

				if($winner == $opp_user) { $won = 1; $lost = 0; }  
				else { $won = 0; $lost = 1;  }

				$data = array('Num_Matches' => 1, 'Users_ID' => $opp_user, 'Sport' => $match_sport,
					'Won' => $won, 'Lost' => $lost, 'Win_Per' => $win_per_p2);

				$p1_insert = $this->db->insert('Player_Matches_Count' ,$data);
			}
			else
			{
				$total_1 = $c1['Num_Matches'] + 1;

				$prev_wp = ($c1['Win_Per'] * $c1['Num_Matches']);

					if($winner == $opp_user) { 
						$won = intval($c1['Won'])+1; 
						$lost = intval($c1['Lost']); 
					}  
					else { 
						$won = intval($c1['Won']);
						$lost = intval($c1['Lost'])+1;   
					}

				$avg_win_per2 = number_format((($prev_wp + $win_per_p2) / $total_1),2); 

				$data = array('Num_Matches' => $total_1,'Won' => $won, 'Lost' => $lost, 'Win_Per' => $avg_win_per2);

				$this->db->where('Users_ID', $opp_user);
				$this->db->where('Sport', $match_sport);
				$p1_update = $this->db->update('Player_Matches_Count' ,$data);
			}


			$this->db->where('Tourn_match_id', $tourn_match_id);
			$result = $this->db->get_where('Tournament_Matches');

			$tm_data = $result->row_array();

			if($tm_data['Player1_Partner'] != 0){				// ----------- Player1 Partner --------------------------

				$data = array('Users_ID'=>$tm_data['Player1_Partner'],'Sport' =>$match_sport);	
				$num1 = $this->db->get_where('Player_Matches_Count',$data);
				$c1 =  $num1->row_array();

				if(empty($c1))
				{

					if($winner == $player1_user) { $won = 1; $lost = 0; }  
					else { $won = 0; $lost = 1;  }

					$data = array('Num_Matches' => 1, 'Users_ID' => $tm_data['Player1_Partner'], 'Sport' => $match_sport,
						'Won' => $won, 'Lost' => $lost, 'Win_Per' => $win_per_p1);

					$p1_insert = $this->db->insert('Player_Matches_Count' ,$data);
				}
				else
				{
					$total_1 = $c1['Num_Matches'] + 1;

					$prev_wp = ($c1['Win_Per'] * $c1['Num_Matches']);

						if($winner == $player1_user) { 
							$won = intval($c1['Won'])+1; 
							$lost = intval($c1['Lost']); 
						}  
						else { 
							$won = intval($c1['Won']);
							$lost = intval($c1['Lost'])+1;   
						}

					$avg_win_per1 = number_format((($prev_wp + $win_per_p1) / $total_1),2); 

					$data = array('Num_Matches' => $total_1,'Won' => $won, 'Lost' => $lost, 'Win_Per' => $avg_win_per1);

					$this->db->where('Users_ID', $tm_data['Player1_Partner']);
					$this->db->where('Sport', $match_sport);
					$p1_update = $this->db->update('Player_Matches_Count' ,$data);
				}
			}
			
			
			if($tm_data['Player2_Partner'] != 0){				// ----------- Player2 Partner --------------------------

				$data = array('Users_ID'=>$tm_data['Player2_Partner'],'Sport' =>$match_sport);	
				$num1 = $this->db->get_where('Player_Matches_Count',$data);
				$c1 =  $num1->row_array();

				if(empty($c1))
				{

					if($winner == $opp_user) { $won = 1; $lost = 0; }  
					else { $won = 0; $lost = 1;  }

					$data = array('Num_Matches' => 1, 'Users_ID' => $tm_data['Player2_Partner'], 'Sport' => $match_sport,
						'Won' => $won, 'Lost' => $lost, 'Win_Per' => $win_per_p2);

					$p1_insert = $this->db->insert('Player_Matches_Count' ,$data);
				}
				else
				{
					$total_1 = $c1['Num_Matches'] + 1;

					$prev_wp = ($c1['Win_Per'] * $c1['Num_Matches']);

						if($winner == $player1_user) { 
							$won = intval($c1['Won'])+1; 
							$lost = intval($c1['Lost']); 
						}  
						else { 
							$won = intval($c1['Won']);
							$lost = intval($c1['Lost'])+1;   
						}

					$avg_win_per2 = number_format((($prev_wp + $win_per_p2) / $total_1),2); 

					$data = array('Num_Matches' => $total_1,'Won' => $won, 'Lost' => $lost, 'Win_Per' => $avg_win_per2);

					$this->db->where('Users_ID', $tm_data['Player2_Partner']);
					$this->db->where('Sport', $match_sport);
					$p1_update = $this->db->update('Player_Matches_Count' ,$data);
				}
			}

				

		/* --------------------- */

					$data = array(
							'Match_Date' => $played_date,
							'Player1_Score' => $player1_score,
							'Player2_Score' => $player2_score,
							'Winner' => $winner,
							'Player1_points' => $p1_points,
							'Player2_points' => $p2_points
					);
			
			$this->db->where('Tourn_match_id', $tourn_match_id);
			$result = $this->db->update('Tournament_Matches', $data); 

/* --- update player1 and player2 sources ---- */
			$bracket_id = $this->input->post('bracket_id');
			$match_num = $this->input->post('match_num');

	/*		$qry_check_p1 = $this->db->query("SELECT * FROM Tournament_Matches WHERE Player1_source = $match_num AND BracketID = $bracket_id");

			if($qry_check_p1->num_rows() > 0)
			{
					$xx = $qry_check_p1->row_array();
					$tid = $xx['Tourn_match_id'];
					$qry_upd_p2 = $this->db->query("UPDATE Tournament_Matches SET Player1 = $winner WHERE Tourn_match_id = $tid");
			}
			else
			{
			$qry_check_p2 = $this->db->query("SELECT * FROM Tournament_Matches WHERE Player2_source = $match_num AND BracketID = $bracket_id");

				if($qry_check_p2->num_rows() > 0)
				{
					$yy = $qry_check_p2->row_array();
					$tid = $yy['Tourn_match_id'];
					$qry_upd_p2 = $this->db->query("UPDATE Tournament_Matches SET Player2 = $winner WHERE Tourn_match_id = $tid");
				}
			}
	*/
/* --- update player1 and player2 sources ---- */


			$data = array('player1'=>$player1_user, 'player2'=>$opp_user,'tourn_id'=>$tourn_id,
				'player1_score'=>$player1_score,'player2_score'=>$player2_score, 'type'=>'rr');

			return $data;

		}

//------------------------------------------------------------------------------------------------------

//-------------------------------------- Add Score Functionality ---------------------------------------

		public function update_tourn_match_score()
		{

		/* ------------------- A2MScore Calculation Section ---------------- */
			//$tourn_id = $data['tourn_id']; 
			$tourn_id = $this->input->post('tourn_id');
			$tourn_match_id = $this->input->post('tourn_match_id');

			$draw_name = $this->input->post('draw_name');
			$round_title = $this->input->post('round_title');
		
			$data = array('tournament_ID' => $tourn_id);
			$macth_init =  $this->db->get_where('tournament',$data);
			$match_init_user = $macth_init->row_array();

		$player1_user = $this->input->post('player1_user');
		$player1_partner = $this->input->post('player1_user_partner');

		$opp_user = $this->input->post('player2_user');
		$opp_user_partner = $this->input->post('player2_user_partner');

		$match_sport = $match_init_user['SportsType'];


			$data = array('SportsType_ID'=>$match_sport, 'Users_ID'=>$player1_user);
			$get_a2mscore1 = $this->db->get_where('A2MScore',$data);
			$p1_a2mscore = $get_a2mscore1->row_array();

			$data = array('SportsType_ID'=>$match_sport, 'Users_ID'=>$opp_user);
			$get_a2mscore2 = $this->db->get_where('A2MScore',$data);
			$p2_a2mscore = $get_a2mscore2->row_array();


		$player1_a2mscore = $p1_a2mscore['A2MScore'];
		$player2_a2mscore = $p2_a2mscore['A2MScore'];

			if($player1_partner or $opp_user_partner){

				$data = array('SportsType_ID'=>$match_sport, 'Users_ID'=>$player1_partner);
				$get_part_a2mscore1 = $this->db->get_where('A2MScore',$data);
				$p1_part_a2mscore = $get_part_a2mscore1->row_array();

				$data = array('SportsType_ID'=>$match_sport, 'Users_ID'=>$opp_user_partner);
				$get_part_a2mscore2 = $this->db->get_where('A2MScore',$data);
				$p2_part_a2mscore = $get_part_a2mscore2->row_array();

			$player1_part_a2mscore = $p1_part_a2mscore['A2MScore'];
			$player2_part_a2mscore = $p2_part_a2mscore['A2MScore'];
			}



		$score_diff = abs($player1_a2mscore - $player2_a2mscore);

		($player1_a2mscore >= $player2_a2mscore) ? $max_a2mscore_user = $player1_user : $max_a2mscore_user = $opp_user;

/*--------------- Sets score calculation start --------------*/
		$i=0;
		$player1_score = "[";
		$player1_score_total = 0;
		foreach($this->input->post('player1') as $set_score)
			{

				if($set_score!="")
				{
					if ($i !=0)
					{
						$player1_score .= ",";
					}
					$player1_score .= "$set_score";
					$player1_score_total += intval($set_score);
					++$i;		
				}
				

			}
		$player1_score .= "]";
	

		$j=0;
		$player2_score = "[";
		$player2_score_total = 0;
		foreach($this->input->post('player2') as $set_score)
			{

				if($set_score!="")
				{
					if ($j !=0)
					{
						$player2_score .= ",";
					}
					$player2_score .= "$set_score";
					$player2_score_total += intval($set_score);
					++$j;
				}
				//if(++$j!=count(array_filter($this->input->post('player2'))) and $set_score!="")
				//{
				//	$player2_score .= ",";
				//}

			}
		$player2_score .= "]";

		$tot_score = $player1_score_total + $player2_score_total;

/*--------------- Sets score calculation end --------------*/


	//	$winner = $this->input->post('id');
	if($player1_score_total >= $player2_score_total){
		$winner = $player1_user;
		$winner_partner = $player1_partner;

		$looser = $opp_user;
		$looser_partner = $opp_user_partner;
	}
	else{
		$winner = $opp_user;
		$winner_partner = $opp_user_partner;

		$looser = $player1_user;
		$looser_partner = $player1_partner;
	}

	//	($winner == $player1_user) ? $loser = $opp_user : $loser = $player1_user;

				$i=0;$j=12;
				while($i<=238)
				{
				 if(($score_diff >= $i) && ($score_diff <= $j))
				 { 
					 switch($score_diff)
					 {
						 case ($score_diff >= 0) && ($score_diff <= 12):
							 ($winner == $max_a2mscore_user) ? $add_score_points = 8 : $add_score_points = 8;
							break;
						 case ($score_diff >= 13) && ($score_diff <= 37):
							 ($winner == $max_a2mscore_user) ? $add_score_points = 7 : $add_score_points = 10;
							break;
						 case ($score_diff >= 38) && ($score_diff <= 62):
							 ($winner == $max_a2mscore_user) ? $add_score_points = 6 : $add_score_points = 13;
							break;
						 case ($score_diff >= 63) && ($score_diff <= 87):
							 ($winner == $max_a2mscore_user) ? $add_score_points = 5 : $add_score_points = 16;
							break;
						 case ($score_diff >= 88) && ($score_diff <= 112):
							 ($winner == $max_a2mscore_user) ? $add_score_points = 4 : $add_score_points = 20;
							break;
						 case ($score_diff >= 113) && ($score_diff <= 137):
							 ($winner == $max_a2mscore_user) ? $add_score_points = 3 : $add_score_points = 25;
							break;
						 case ($score_diff >= 138) && ($score_diff <= 162):
							 ($winner == $max_a2mscore_user) ? $add_score_points = 2 : $add_score_points = 30;
							break;
						 case ($score_diff >= 163) && ($score_diff <= 187):
							 ($winner == $max_a2mscore_user) ? $add_score_points = 2 : $add_score_points = 35;
							break;
						 case ($score_diff >= 188) && ($score_diff <= 212):
							 ($winner == $max_a2mscore_user) ? $add_score_points = 1 : $add_score_points = 40;
							break;
						 case ($score_diff >= 213) && ($score_diff <= 237):
							 ($winner == $max_a2mscore_user) ? $add_score_points = 1 : $add_score_points = 45;
							break;
						 case ($score_diff >= 238):
							 ($winner == $max_a2mscore_user) ? $add_score_points = 0 : $add_score_points = 50;
							break;
					 }
				   }
				$i = $j + 1;
				$j = $i + 24;
				}

/* ------------------- A2MScore Calculation Section End ---------------- */


	
		$win_per_p1 = ($player1_score_total / $tot_score) * 100;
		
		$win_per_p2 = ($player2_score_total / $tot_score) * 100;
	

					 switch($win_per_p1)
					 {
						 case ($win_per_p1 >= 0) && ($win_per_p1 <= 9):
							 ($player1_user == $max_a2mscore_user) ? $add_win_points_p1 = 0 : $add_win_points_p1 = 1;
							break;
						 case ($win_per_p1 >= 10) && ($win_per_p1 <= 19):
							 ($player1_user == $max_a2mscore_user) ? $add_win_points_p1 = 0 : $add_win_points_p1 = 1;
							break;
						 case ($win_per_p1 >= 20) && ($win_per_p1 <= 29):
							 ($player1_user == $max_a2mscore_user) ? $add_win_points_p1 = 1 : $add_win_points_p1 = 2;
							break;
						 case ($win_per_p1 >= 30) && ($win_per_p1 <= 39):
							 ($player1_user == $max_a2mscore_user) ? $add_win_points_p1 = 3 : $add_win_points_p1 = 4;
							break;
						 case ($win_per_p1 >= 40) && ($win_per_p1 <= 49):
							 ($player1_user == $max_a2mscore_user) ? $add_win_points_p1 = 4 : $add_win_points_p1 = 6;
							break;
						 case ($win_per_p1 >= 50) && ($win_per_p1 <= 59):
							 ($player1_user == $max_a2mscore_user) ? $add_win_points_p1 = 6 : $add_win_points_p1 = 8;
							break;
						 case ($win_per_p1 >= 60) && ($win_per_p1 <= 69):
							 ($player1_user == $max_a2mscore_user) ? $add_win_points_p1 = 7 : $add_win_points_p1 = 10;
							break;
						 case ($win_per_p1 >= 70) && ($win_per_p1 <= 79):
							 ($player1_user == $max_a2mscore_user) ? $add_win_points_p1 = 8 : $add_win_points_p1 = 14;
							break;
						 case ($win_per_p1 >= 80) && ($win_per_p1 <= 89):
							 ($player1_user == $max_a2mscore_user) ? $add_win_points_p1 = 9 : $add_win_points_p1 = 17;
							break;
						 case ($win_per_p1 >= 90):
							 ($player1_user == $max_a2mscore_user) ? $add_win_points_p1 = 10 : $add_win_points_p1 = 20;
							break;
						default:
							 $add_win_points_p1 = 0;
						    break;
					 }


					 switch($win_per_p2)
					 {
						 case ($win_per_p2 >= 0) && ($win_per_p2 <= 9):
							 ($opp_user == $max_a2mscore_user) ? $add_win_points_p2 = 0 : $add_win_points_p2 = 1;
							break;
						 case ($win_per_p2 >= 10) && ($win_per_p2 <= 19):
							 ($opp_user == $max_a2mscore_user) ? $add_win_points_p2 = 0 : $add_win_points_p2 = 1;
							break;
						 case ($win_per_p2 >= 20) && ($win_per_p2 <= 29):
							 ($opp_user == $max_a2mscore_user) ? $add_win_points_p2 = 1 : $add_win_points_p2 = 2;
							break;
						 case ($win_per_p2 >= 30) && ($win_per_p2 <= 39):
							 ($opp_user == $max_a2mscore_user) ? $add_win_points_p2 = 3 : $add_win_points_p2 = 4;
							break;
						 case ($win_per_p2 >= 40) && ($win_per_p2 <= 49):
							 ($opp_user == $max_a2mscore_user) ? $add_win_points_p2 = 4 : $add_win_points_p2 = 6;
							break;
						 case ($win_per_p2 >= 50) && ($win_per_p2 <= 59):
							 ($opp_user == $max_a2mscore_user) ? $add_win_points_p2 = 6 : $add_win_points_p2 = 8;
							break;
						 case ($win_per_p2 >= 60) && ($win_per_p2 <= 69):
							 ($opp_user == $max_a2mscore_user) ? $add_win_points_p2 = 7 : $add_win_points_p2 = 10;
							break;
						 case ($win_per_p2 >= 70) && ($win_per_p2 <= 79):
							 ($opp_user == $max_a2mscore_user) ? $add_win_points_p2 = 8 : $add_win_points_p2 = 14;
							break;
						 case ($win_per_p2 >= 80) && ($win_per_p2 <= 89):
							 ($opp_user == $max_a2mscore_user) ? $add_win_points_p2 = 9 : $add_win_points_p2 = 17;
							break;
						 case ($win_per_p2 >= 90):
							 ($opp_user == $max_a2mscore_user) ? $add_win_points_p2 = 10 : $add_win_points_p2 = 20;
							break;
						default:
							 $add_win_points_p2 = 0;
						    break;
					 }

		//$a2mscore_add =  intval($add_score_points) + intval($add_score_points2);
		//$a2mscore_sub =  intval($add_score_points);


		// Winner score update
		if($winner == $player1_user) {
						
			$p1_a2mscore_updated =  intval($player1_a2mscore) +  intval($add_score_points) +  intval($add_win_points_p1);
			$p1_part_a2mscore_updated =  intval($player1_part_a2mscore) +  intval($add_score_points) +  intval($add_win_points_p1);

			$p2_a2mscore_updated =  intval($player2_a2mscore) -  intval($add_score_points) +  intval($add_win_points_p2);
			$p2_part_a2mscore_updated =  intval($player2_part_a2mscore) -  intval($add_score_points) +  intval($add_win_points_p2);
		} 
		else {
			
			$p1_a2mscore_updated =  intval($player1_a2mscore) -  intval($add_score_points) +  intval($add_win_points_p1);
			$p1_part_a2mscore_updated =  intval($player1_part_a2mscore) -  intval($add_score_points) +  intval($add_win_points_p1);

			$p2_a2mscore_updated =  intval($player2_a2mscore) +  intval($add_score_points) +  intval($add_win_points_p2);
			$p2_part_a2mscore_updated =  intval($player2_part_a2mscore) +  intval($add_score_points) +  intval($add_win_points_p2);
		}

		$played_date = $this->input->post('tour_match_date');

		/* A2MScore Table Update */
/*
echo "PLAYER 1<br><br>";

echo "ID -".$player1_user."<br>";
echo "A2MScore - ".$player1_a2mscore."<br>";
echo "Score - ".$player1_score_total."<br>";
echo "Win% - ".$win_per_p1."<br>";
echo "Win% points(+) = ".$add_win_points_p1."<br>";
echo "player1 -". $p1_a2mscore_updated."<br><br>";

echo "PLAYER 2<br><br>";

echo "ID -".$opp_user."<br>";
echo "A2MScore - ".$player2_a2mscore."<br>";
echo "Score - ".$player2_score_total."<br>";
echo "Win% - ".$win_per_p2."<br>";
echo "Win% points(+) = ".$add_win_points_p2."<br>";
echo "player2 -". $p2_a2mscore_updated."<br><br>";

echo "--------------"."<br>";

echo "Winner -". $winner."<br>";
echo "Score Diff -". $score_diff."<br>";
echo "Winner AddScore -". $add_score_points."<br>";
*/

				$data = array ('A2MScore' => $p1_a2mscore_updated);		// Player1 A2MScore update
				
				$this->db->where('Users_ID', $player1_user);
				$this->db->where('SportsType_ID', $match_sport);

			$a2mscore_upd_qry1 = $this->db->update('A2MScore', $data);

				$data = array ('A2MScore' => $p1_part_a2mscore_updated);		// Player1_Partner A2MScore update
				
				$this->db->where('Users_ID', $player1_partner);
				$this->db->where('SportsType_ID', $match_sport);

			$a2mscore_upd_qry1 = $this->db->update('A2MScore', $data);

				$data = array ('A2MScore' => $p2_a2mscore_updated);		// Opponent A2MScore update
				
				$this->db->where('Users_ID', $opp_user);
				$this->db->where('SportsType_ID', $match_sport);

			$a2mscore_upd_qry2 = $this->db->update('A2MScore', $data);

				$data = array ('A2MScore' => $p2_part_a2mscore_updated);   // Opponent_Partner A2MScore update
				
				$this->db->where('Users_ID', $opp_user_partner);
				$this->db->where('SportsType_ID', $match_sport);

			$a2mscore_upd_qry2 = $this->db->update('A2MScore', $data);

		/* --------------------- */


		/* Player Number of Matches Update */

		/*	$player1_user = $match_init_user['users_id'];
			$opp_user = $this->input->post('opp_user');
			$match_sport = $match_init_user['Sports'];*/

			$data = array('Users_ID'=>$player1_user,'Sport' =>$match_sport);
			$num = $this->db->get_where('Player_Matches_Count',$data);
			$c =  $num->row_array();

			if(empty($c))				//	Player 1
			{

				if($winner == $player1_user) { $won = 1; $lost = 0; }  
				else { $won = 0; $lost = 1;  }

				$data = array('Num_Matches' => 1, 'Users_ID' => $player1_user,'Sport' => $match_sport,
				'Won' => $won, 'Lost' => $lost, 'Win_Per' => $win_per_p1);

				$p1_insert = $this->db->insert('Player_Matches_Count' ,$data);
			}
			else
			{
				$total = $c['Num_Matches'] + 1;

				$prev_wp = ($c['Win_Per'] * $c['Num_Matches']);

				if($winner == $player1_user) { 
					$won = intval($c['Won'])+1; 
					$lost = intval($c['Lost']);
					}  
				else { 
					$won = intval($c['Won']);   
					$lost = intval($c['Lost'])+1;   
					}

					$avg_win_per1 = number_format((($prev_wp + $win_per_p1) / $total), 2); 

				$data = array('Num_Matches' => $total,'Won' => $won, 'Lost' => $lost, 'Win_Per' => $avg_win_per1);
				$this->db->where('Users_ID', $player1_user);
				$this->db->where('Sport', $match_sport);
				$p1_update = $this->db->update('Player_Matches_Count' ,$data);
			}
			

			$data = array('Users_ID'=>$opp_user,'Sport' =>$match_sport);
			$num1 = $this->db->get_where('Player_Matches_Count',$data);
			$c1 =  $num1->row_array();

			if(empty($c1))				//	Player 2
			{
				if($winner == $opp_user) { $won = 1; $lost = 0; }  
				else { $won = 0; $lost = 1;  }

				$data = array('Num_Matches' => 1, 'Users_ID' => $opp_user, 'Sport' => $match_sport,
					'Won' => $won, 'Lost' => $lost, 'Win_Per' => $win_per_p2);

				$p1_insert = $this->db->insert('Player_Matches_Count' ,$data);
			}
			else
			{
				$total_1 = $c1['Num_Matches'] + 1;

				$prev_wp = ($c1['Win_Per'] * $c1['Num_Matches']);

					if($winner == $opp_user) { 
						$won = intval($c1['Won'])+1; 
						$lost = intval($c1['Lost']); 
					}  
					else { 
						$won = intval($c1['Won']);
						$lost = intval($c1['Lost'])+1;   
					}

				$avg_win_per2 = number_format((($prev_wp + $win_per_p2) / $total_1),2); 


				$data = array('Num_Matches' => $total_1,'Won' => $won, 'Lost' => $lost, 'Win_Per' => $avg_win_per2);

				$this->db->where('Users_ID', $opp_user);
				$this->db->where('Sport', $match_sport);
				$p1_update = $this->db->update('Player_Matches_Count' ,$data);
			}




			$this->db->where('Tourn_match_id', $tourn_match_id);
			$result = $this->db->get_where('Tournament_Matches');

			$tm_data = $result->row_array();

			if($tm_data['Player1_Partner'] != 0){				// ----------- Player1 Partner --------------------------

				$data = array('Users_ID'=>$tm_data['Player1_Partner'],'Sport' =>$match_sport);	
				$num1 = $this->db->get_where('Player_Matches_Count',$data);
				$c1 =  $num1->row_array();

				if(empty($c1))
				{

					if($winner == $player1_user) { $won = 1; $lost = 0; }  
					else { $won = 0; $lost = 1;  }

					$data = array('Num_Matches' => 1, 'Users_ID' => $tm_data['Player1_Partner'], 'Sport' => $match_sport,
						'Won' => $won, 'Lost' => $lost, 'Win_Per' => $win_per_p1);

					$p1_insert = $this->db->insert('Player_Matches_Count' ,$data);
				}
				else
				{
					$total_1 = $c1['Num_Matches'] + 1;

					$prev_wp = ($c1['Win_Per'] * $c1['Num_Matches']);

						if($winner == $player1_user) { 
							$won = intval($c1['Won'])+1; 
							$lost = intval($c1['Lost']); 
						}  
						else { 
							$won = intval($c1['Won']);
							$lost = intval($c1['Lost'])+1;   
						}

					$avg_win_per1 = number_format((($prev_wp + $win_per_p1) / $total_1),2); 

					$data = array('Num_Matches' => $total_1,'Won' => $won, 'Lost' => $lost, 'Win_Per' => $avg_win_per1);

					$this->db->where('Users_ID', $tm_data['Player1_Partner']);
					$this->db->where('Sport', $match_sport);
					$p1_update = $this->db->update('Player_Matches_Count' ,$data);
				}
			}
			
			
			if($tm_data['Player2_Partner'] != 0){			// -----------	 Player2 Partner --------------------------

				$data = array('Users_ID'=>$tm_data['Player2_Partner'],'Sport' =>$match_sport);	
				$num1 = $this->db->get_where('Player_Matches_Count',$data);
				$c1 =  $num1->row_array();

				if(empty($c1))
				{

					if($winner == $opp_user) { $won = 1; $lost = 0; }  
					else { $won = 0; $lost = 1;  }

					$data = array('Num_Matches' => 1, 'Users_ID' => $tm_data['Player2_Partner'], 'Sport' => $match_sport,
						'Won' => $won, 'Lost' => $lost, 'Win_Per' => $win_per_p2);

					$p1_insert = $this->db->insert('Player_Matches_Count' ,$data);
				}
				else
				{
					$total_1 = $c1['Num_Matches'] + 1;

					$prev_wp = ($c1['Win_Per'] * $c1['Num_Matches']);

						if($winner == $player1_user) { 
							$won = intval($c1['Won'])+1; 
							$lost = intval($c1['Lost']); 
						}  
						else { 
							$won = intval($c1['Won']);
							$lost = intval($c1['Lost'])+1;   
						}

					$avg_win_per2 = number_format((($prev_wp + $win_per_p2) / $total_1),2); 

					$data = array('Num_Matches' => $total_1,'Won' => $won, 'Lost' => $lost, 'Win_Per' => $avg_win_per2);

					$this->db->where('Users_ID', $tm_data['Player2_Partner']);
					$this->db->where('Sport', $match_sport);
					$p1_update = $this->db->update('Player_Matches_Count' ,$data);
				}
			}


			
/* ---------------------------------------------------------------------- */

					$data = array(
							'Match_Date' => $played_date,
							'Player1_Score' => $player1_score,
							'Player2_Score' => $player2_score,
							'Winner' => $winner);
			
			$this->db->where('Tourn_match_id', $tourn_match_id);
			$result = $this->db->update('Tournament_Matches', $data); 

/* --- update player1 and player2 sources ---- */

			$data = array('Tourn_match_id' => $tourn_match_id);
			$get_tour_match = $this->db->get_where('Tournament_Matches', $data); 
			$get_tour_match_row = $get_tour_match->row_array();

			$bracket_id = $this->input->post('bracket_id');
			$match_num = $this->input->post('match_num');

			$qry_check_p1 = $this->db->query("SELECT * FROM Tournament_Matches WHERE Player1_source = $match_num AND BracketID = $bracket_id AND Draw_Type = '$get_tour_match_row[Draw_Type]'");

			if($qry_check_p1->num_rows() > 0)
			{
					$xx = $qry_check_p1->row_array();
					$tid = $xx['Tourn_match_id'];
					$qry_upd_p2 = $this->db->query("UPDATE Tournament_Matches SET Player1 = $winner, Player1_Partner = $winner_partner WHERE Tourn_match_id = $tid");
			}
			else
			{
			$qry_check_p2 = $this->db->query("SELECT * FROM Tournament_Matches WHERE Player2_source = $match_num AND BracketID = $bracket_id AND Draw_Type = '$get_tour_match_row[Draw_Type]'");

				if($qry_check_p2->num_rows() > 0)
				{
					$yy = $qry_check_p2->row_array();
					$tid = $yy['Tourn_match_id'];
					$qry_upd_p2 = $this->db->query("UPDATE Tournament_Matches SET Player2 = $winner, Player2_Partner = $winner_partner WHERE Tourn_match_id = $tid");
				}
			}
/* --- update player1 and player2 sources ---- */

/* --- Update Consolation Draw Sources ---- */

if($draw_name != "Consolation")
{
			$qry_check_draw_type = $this->db->query("SELECT Tournament_type FROM tournament WHERE tournament_ID = $tourn_id AND Tournament_type = 'Consolation'");

			if($qry_check_draw_type->num_rows() > 0)
			{

			$bracket_id = $this->input->post('bracket_id');
			$match_num = $this->input->post('match_num');

			$qry_check_p1 = $this->db->query("SELECT * FROM Tournament_Matches WHERE Round_Num = 1 AND Player1_source = $match_num AND BracketID = $bracket_id AND Draw_Type = 'Consolation'");

			if($qry_check_p1->num_rows() > 0)
			{
					$xx = $qry_check_p1->row_array();
					$tid = $xx['Tourn_match_id'];
					$cd_player2_source = $xx['Player2_source'];
					$qry_upd_p2 = $this->db->query("UPDATE Tournament_Matches SET Player1 = $looser, Player1_Partner = $looser_partner WHERE Tourn_match_id = $tid");

					if($cd_player2_source == 0){

					$c_date = date('Y-m-d');
						$qry_upd_p2 = $this->db->query("UPDATE Tournament_Matches SET Player1_Score = 'Bye Match', Player2_Score = 'Bye Match', Winner = $looser, Match_Date = '$c_date' WHERE Tourn_match_id = $tid");

					$mid = $xx['Match_Num'];

					$cd_qry_check_p1 = $this->db->query("SELECT * FROM Tournament_Matches WHERE Round_Num != 1 AND Player1_source = $mid AND BracketID = $bracket_id AND Draw_Type = 'Consolation'");

								if($cd_qry_check_p1->num_rows() > 0)
								{
									$xy = $cd_qry_check_p1->row_array();
	 								$ttid = $xy['Tourn_match_id'];
									$cd_qry_upd_p2 = $this->db->query("UPDATE Tournament_Matches SET Player1 = $looser, Player1_Partner = $looser_partner WHERE Tourn_match_id = $ttid");
								}
								else
								{
									$cd_qry_check_p2 = $this->db->query("SELECT * FROM Tournament_Matches WHERE Round_Num != 1 AND Player2_source = $mid AND BracketID = $bracket_id AND Draw_Type = 'Consolation'");

									if($cd_qry_check_p2->num_rows() > 0)
									{
										$yz = $cd_qry_check_p2->row_array();
										$ttid = $yz['Tourn_match_id'];
										$cd_qry_upd_p2 = $this->db->query("UPDATE Tournament_Matches SET Player2 = $looser, Player2_Partner = $looser_partner WHERE Tourn_match_id = $ttid");
									}
								}
						}
				}
				else
				{
				$qry_check_p2 = $this->db->query("SELECT * FROM Tournament_Matches WHERE Round_Num = 1 AND Player2_source = $match_num AND BracketID = $bracket_id AND Draw_Type = 'Consolation'");

					if($qry_check_p2->num_rows() > 0)
					{
						$yy = $qry_check_p2->row_array();
						$tid = $yy['Tourn_match_id'];
						$qry_upd_p2 = $this->db->query("UPDATE Tournament_Matches SET Player2 = $looser, Player2_Partner = $looser_partner WHERE Tourn_match_id = $tid");
					}
				}
			
		}

}
/* --- End of update Consolation Draw Sources ---- */

				
			$data = array('player1'=>$player1_user, 'player2'=>$opp_user, 'tourn_id'=>$tourn_id, 'winner' => $winner, 'player1_score'=>$player1_score, 'player2_score'=>$player2_score, 'type'=>'se', 'round_title'=>$round_title, 'draw_name'=>$draw_name);

			return $data;
		}


		public function update_wff_winner()				// --- Win by Forefiet --------------------------------------------------------------------
		{

			$tourn_id = $this->input->post('tourn_id');
			$tourn_match_id = $this->input->post('tourn_match_id');
			$draw_name = $this->input->post('draw_name');
			$round_title = $this->input->post('round_title');
			
			$qry_check = $this->db->query("SELECT * FROM Tournament_Matches WHERE Tourn_match_id = $tourn_match_id ");

			if($qry_check->num_rows() > 0)
			{
					$players = $qry_check->row_array();

					$p1 = $players['Player1'];
					$p1_partner = $players['Player1_Partner'];

					$p2 = $players['Player2'];
					$p2_partner = $players['Player2_Partner'];
			}
			$winner = $this->input->post('id');
			if($winner == $p1)
			{
				$p1_points = 3;
				$p2_points = 0;
				$looser = $p2;

				$winner_partner = $p1_partner;
				$loser_partner = $p2_partner;
			}
			else
			{
				$p2_points = 3;
				$p1_points = 0;
				$looser = $p1;

				$winner_partner = $p2_partner;
				$loser_partner = $p1_partner;
			}

			$played_date = date("Y-m-d h:i:s");
			$player1_score = "[0]";
			$player2_score = "[0]";


			$data = array(
							'Match_Date' => $played_date,
							'Player1_Score' => $player1_score,
							'Player2_Score' => $player2_score,
							'Player1_points' => $p1_points,
							'Player2_points' => $p2_points,
							'Winner' => $winner);
			
			$this->db->where('Tourn_match_id', $tourn_match_id);
			$result = $this->db->update('Tournament_Matches', $data);

/*  ------------ Update player matches count table ------------ */

			$data = array('tournament_ID'=>$tourn_id);
			$query = $this->db->get_where('tournament',$data);
			$get_match =  $query->row_array();

			$player1_user = $p1;
			$opp_user = $p2;
			$match_sport = $get_match['SportsType'];

			$data = array('Users_ID'=>$player1_user,'Sport' =>$match_sport);	// PLAYER - 1
			$num = $this->db->get_where('Player_Matches_Count',$data);
			$c =  $num->row_array();

			if(empty($c))
			{
				$win_per_p1 = 0.00;
					if($winner == $player1_user) { $won = 1; $lost = 0; }  
					else { $won = 0; $lost = 1;  }

					$data = array('Num_Matches' => 1, 'Users_ID' => $player1_user,'Sport' => $match_sport,
					'Won' => $won, 'Lost' => $lost, 'Win_Per' => $win_per_p1);

				$p1_insert = $this->db->insert('Player_Matches_Count' ,$data);
			}
			else
			{

				$total = intval($c['Num_Matches']) + 1;
			
				if($winner == $player1_user) { 
					$won = intval($c['Won'])+1; 
					$lost = intval($c['Lost']);
					}  
				else { 
					$won = intval($c['Won']);   
					$lost = intval($c['Lost'])+1;   
					}

					//$avg_win_per1 = number_format(($c['Win_Per'] / $total), 2);

				$data = array('Num_Matches' => $total,'Won' => $won, 'Lost' => $lost); //, 'Win_Per' => $avg_win_per1);
				$this->db->where('Users_ID', $player1_user);
				$this->db->where('Sport', $match_sport);
				$p1_update = $this->db->update('Player_Matches_Count' ,$data);
			}


			$data = array('Users_ID'=>$opp_user,'Sport' =>$match_sport);    // PLAYER - 2
			$num1 = $this->db->get_where('Player_Matches_Count',$data);
			$c1 =  $num1->row_array();

			if(empty($c1))
			{
				if($winner == $opp_user) { $won = 1; $lost = 0; }  
				else { $won = 0; $lost = 1;  }

				$win_per_p2 = 0.00;

				$data = array('Num_Matches' => 1, 'Users_ID' => $opp_user,'Sport' => $match_sport,
							'Won' => $won, 'Lost' => $lost, 'Win_Per' => $win_per_p2);

				$p1_insert = $this->db->insert('Player_Matches_Count' ,$data);
			}
			else
			{
				$total_1 = $c1['Num_Matches'] + 1;
				
					if($winner == $opp_user) { 
						$won = intval($c1['Won'])+1; 
						$lost = intval($c1['Lost']); 
					}  
					else { 
						$won = intval($c1['Won']);
						$lost = intval($c1['Lost'])+1;   
					}

				//$avg_win_per2 = number_format(($c1['Win_Per'] / $total_1),2); 


				$data = array('Num_Matches' => $total_1,'Won' => $won, 'Lost' => $lost); //, 'Win_Per' => $avg_win_per2);
				$this->db->where('Users_ID', $opp_user);
				$this->db->where('Sport', $match_sport);
				$p1_update = $this->db->update('Player_Matches_Count' ,$data);
			}

//-------------------------------------------------------------

			$this->db->where('Tourn_match_id', $tourn_match_id);
			$result = $this->db->get_where('Tournament_Matches');

			$tm_data = $result->row_array();

			if($tm_data['Player1_Partner'] != 0){			// -----------	Player1 Partner --------------------------

				$data = array('Users_ID'=>$tm_data['Player1_Partner'],'Sport' =>$match_sport);	
				$num1 = $this->db->get_where('Player_Matches_Count',$data);
				$c1 =  $num1->row_array();

				if(empty($c))
				{
					$win_per_p1 = 0.00;
						if($winner == $player1_user) { $won = 1; $lost = 0; }  
						else { $won = 0; $lost = 1;  }

						$data = array('Num_Matches' => 1, 'Users_ID' => $tm_data['Player1_Partner'],'Sport' => $match_sport,
						'Won' => $won, 'Lost' => $lost, 'Win_Per' => $win_per_p1);

					$p1_insert = $this->db->insert('Player_Matches_Count' ,$data);
				}
				else
				{

					$total = intval($c['Num_Matches']) + 1;
				
					if($winner == $player1_user) { 
						$won = intval($c['Won'])+1; 
						$lost = intval($c['Lost']);
						}  
					else { 
						$won = intval($c['Won']);   
						$lost = intval($c['Lost'])+1;   
						}

						//$avg_win_per1 = number_format(($c['Win_Per'] / $total), 2);

					$data = array('Num_Matches' => $total,'Won' => $won, 'Lost' => $lost); //, 'Win_Per' => $avg_win_per1);
					$this->db->where('Users_ID', $tm_data['Player1_Partner']);
					$this->db->where('Sport', $match_sport);
					$p1_update = $this->db->update('Player_Matches_Count' ,$data);
				}
			}
			
			
			if($tm_data['Player2_Partner'] != 0){			// -----------	 Player2 Partner --------------------------

				$data = array('Users_ID'=>$tm_data['Player2_Partner'],'Sport' =>$match_sport);	
				$num1 = $this->db->get_where('Player_Matches_Count',$data);
				$c1 =  $num1->row_array();

				if(empty($c1))
				{
					if($winner == $opp_user) { $won = 1; $lost = 0; }  
					else { $won = 0; $lost = 1;  }

					$win_per_p2 = 0.00;

					$data = array('Num_Matches' => 1, 'Users_ID' => $tm_data['Player2_Partner'],'Sport' => $match_sport,
								'Won' => $won, 'Lost' => $lost, 'Win_Per' => $win_per_p2);

					$p1_insert = $this->db->insert('Player_Matches_Count' ,$data);
				}
				else
				{
					$total_1 = $c1['Num_Matches'] + 1;
					
						if($winner == $opp_user) { 
							$won = intval($c1['Won'])+1; 
							$lost = intval($c1['Lost']); 
						}  
						else { 
							$won = intval($c1['Won']);
							$lost = intval($c1['Lost'])+1;   
						}

					//$avg_win_per2 = number_format(($c1['Win_Per'] / $total_1),2); 


					$data = array('Num_Matches' => $total_1,'Won' => $won, 'Lost' => $lost); //, 'Win_Per' => $avg_win_per2);
					$this->db->where('Users_ID', $tm_data['Player2_Partner']);
					$this->db->where('Sport', $match_sport);
					$p1_update = $this->db->update('Player_Matches_Count' ,$data);
				}
			}


/*  ------------------------------ End of update player matches count table ------------------------------------------------------------- */


			/* --- update player1 and player2 sources ---- */
			$bracket_id = $this->input->post('bracket_id');
			$match_num = $this->input->post('match_num');

			$qry_check_p1 = $this->db->query("SELECT * FROM Tournament_Matches WHERE Player1_source = $match_num AND BracketID = $bracket_id");

			if($qry_check_p1->num_rows() > 0)
			{
					$xx = $qry_check_p1->row_array();
					$tid = $xx['Tourn_match_id'];
					$qry_upd_p2 = $this->db->query("UPDATE Tournament_Matches SET Player1 = $winner, Player1_Partner = $winner_partner WHERE Tourn_match_id = $tid");
			}
			else
			{
			$qry_check_p2 = $this->db->query("SELECT * FROM Tournament_Matches WHERE Player2_source = $match_num AND BracketID = $bracket_id");

				if($qry_check_p2->num_rows() > 0)
				{
					$yy = $qry_check_p2->row_array();
					$tid = $yy['Tourn_match_id'];
					$qry_upd_p2 = $this->db->query("UPDATE Tournament_Matches SET Player2 = $winner, Player2_Partner = $winner_partner WHERE Tourn_match_id = $tid");
				}
			}
		/* --- update player1 and player2 sources ---- */


/* --- Update Consolation Draw Sources ---- */


			$qry_check_draw_type = $this->db->query("SELECT Tournament_type FROM tournament WHERE tournament_ID = $tourn_id AND Tournament_type = 'Consolation'");

			if($qry_check_draw_type->num_rows() > 0)
			{

			$bracket_id = $this->input->post('bracket_id');
			$match_num = $this->input->post('match_num');

			$qry_check_p1 = $this->db->query("SELECT * FROM Tournament_Matches WHERE Round_Num = 1 AND Player1_source = $match_num AND BracketID = $bracket_id AND Draw_Type = 'Consolation'");

			if($qry_check_p1->num_rows() > 0)
			{
					$xx = $qry_check_p1->row_array();
					$tid = $xx['Tourn_match_id'];
					$cd_player2_source = $xx['Player2_source'];
					$qry_upd_p2 = $this->db->query("UPDATE Tournament_Matches SET Player1 = $looser, Player1_Partner = $loser_partner WHERE Tourn_match_id = $tid");

					if($cd_player2_source == 0){

					$c_date = date('Y-m-d');
						$qry_upd_p2 = $this->db->query("UPDATE Tournament_Matches SET Player1_Score = 'Bye Match', Player2_Score = 'Bye Match', Winner = $looser, Match_Date = '$c_date' WHERE Tourn_match_id = $tid");

					$mid = $xx['Match_Num'];

					$cd_qry_check_p1 = $this->db->query("SELECT * FROM Tournament_Matches WHERE Round_Num != 1 AND Player1_source = $mid AND BracketID = $bracket_id AND Draw_Type = 'Consolation'");

								if($cd_qry_check_p1->num_rows() > 0)
								{
									$xy = $cd_qry_check_p1->row_array();
	 								$ttid = $xy['Tourn_match_id'];
									$cd_qry_upd_p2 = $this->db->query("UPDATE Tournament_Matches SET Player1 = $looser, Player1_Partner = $loser_partner WHERE Tourn_match_id = $ttid");
								}
								else
								{
									$cd_qry_check_p2 = $this->db->query("SELECT * FROM Tournament_Matches WHERE Round_Num != 1 AND Player2_source = $mid AND BracketID = $bracket_id AND Draw_Type = 'Consolation'");

									if($cd_qry_check_p2->num_rows() > 0)
									{
										$yz = $cd_qry_check_p2->row_array();
										$ttid = $yz['Tourn_match_id'];
										$cd_qry_upd_p2 = $this->db->query("UPDATE Tournament_Matches SET Player2 = $looser, Player2_Partner = $loser_partner WHERE Tourn_match_id = $ttid");
									}
								}
						}
				}
				else
				{
				$qry_check_p2 = $this->db->query("SELECT * FROM Tournament_Matches WHERE Round_Num = 1 AND Player2_source = $match_num AND BracketID = $bracket_id AND Draw_Type = 'Consolation'");

					if($qry_check_p2->num_rows() > 0)
					{
						$yy = $qry_check_p2->row_array();
						$tid = $yy['Tourn_match_id'];
						$qry_upd_p2 = $this->db->query("UPDATE Tournament_Matches SET Player2 = $looser, Player2_Partner = $loser_partner WHERE Tourn_match_id = $tid");
					}
				}
			
		}


/* --- End of update Consolation Draw Sources ---- */

			$data = array('player1'=>$player1_user, 'player2'=>$opp_user, 'tourn_id'=>$tourn_id, 'winner'=>$winner, 'type'=>'wff', 'round_title'=>$round_title, 'draw_name'=>$draw_name);

			return $data;
		}

		public function insert_tourn_images($fileName)
		{
				
			$user_id = $this->session->userdata('users_id');
			$tourn_id = $this->input->post('tourn_id');
			$upload_date = date("Y-m-d");
	 
			$data = array(

				'Image_file'	=> $fileName,
				'Tournament_id'	=> $tourn_id,
				'Upload_date'	=> $upload_date,
				'Users_id'	=> $user_id
			);
	 
			$this->db->insert('Tournament_Images', $data); 
		}


		public function update_doubles_partner()
		{
			$tourn_id = $this->input->post('tourn_id');
			$ttype = $this->input->post('ttype');

			$player = $this->input->post('player');
			$partner = $this->input->post('partner');

				$data = array('Users_ID'=>$player, 'Tournament_ID'=>$tourn_id);
				$exec_qry1 = $this->db->get_where('RegisterTournament',$data);
				$get_player_partner = $exec_qry1->row_array();

				$player_partner = $get_player_partner['Partner1'];

				$data = array('Users_ID'=>$partner, 'Tournament_ID'=>$tourn_id);
				$exec_qry2 = $this->db->get_where('RegisterTournament',$data);
				$get_partner_partner = $exec_qry2->row_array();

				$partner_partner = $get_partner_partner['Partner1'];
			
			//-----------------------------------

			$data = array('Partner1' => "");   // update Player's existing partner as empty

			$this->db->where('Tournament_ID', $tourn_id);
			$this->db->where('Users_ID', $player_partner);
			$result = $this->db->update('RegisterTournament', $data);

			$data = array('Partner1' => "");	// update Partner's existing partner as empty

			$this->db->where('Tournament_ID', $tourn_id);
			$this->db->where('Users_ID', $partner_partner);
			$result = $this->db->update('RegisterTournament', $data);


			//-----------------------------------

			$data = array('Partner1' => $partner);
			
			$this->db->where('Tournament_ID', $tourn_id);
			$this->db->where('Users_ID', $player);
			$result = $this->db->update('RegisterTournament', $data);

			$data = array('Partner1' => $player);

			$this->db->where('Tournament_ID', $tourn_id);
			$this->db->where('Users_ID', $partner);
			$result = $this->db->update('RegisterTournament', $data);
			
			//-----------------------------------

			$type = 'Doubles';
			$qry_check = $this->db->query("SELECT * FROM RegisterTournament WHERE Tournament_ID = $tourn_id AND Match_Type LIKE '%$type%'");
			return $qry_check->result();
		}


		public function get_bracket_list($tourn_id)
		{	
			$data = array('Tourn_ID'=>$tourn_id);
			$names = $this->db->get_where('Brackets',$data);
			return $names->result();
		}

		public function delete_brackets($bracket_id)
		{	
			$data = array('BracketID'=>$bracket_id);
			
			$del_tm = $this->db->query("DELETE FROM Tournament_Matches WHERE BracketID = $bracket_id");
			$del_br = $this->db->query("DELETE FROM Brackets WHERE BracketID = $bracket_id");

			return $del_br;
		}
	}