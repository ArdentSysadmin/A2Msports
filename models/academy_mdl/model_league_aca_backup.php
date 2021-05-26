<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

	class model_league extends CI_Model {

		public $req_method;

		public function __construct(){
			parent:: __construct();
			$this->load->database();
			//$this->$req_method = 'get';

			if($this->input->server('REQUEST_METHOD') == 'GET'){
				$this->req_method = 'get';
			}
			else if($this->input->server('REQUEST_METHOD') == 'POST'){
				$this->req_method = 'post';
			}
		}

		public function is_logged_user_reg($tid){
			
			$user = $this->logged_user;
			$query = $this->db->query("SELECT * FROM RegisterTournament WHERE Users_ID = '{$user}' AND Tournament_ID = {$tid}");
			return $query->num_rows();
		}

		public function get_team_reg($user, $tour_id){
			$query = $this->db->query("SELECT * FROM RegisterTournament WHERE Team_Players LIKE '%\"{$user}\"%' AND Tournament_ID = {$tour_id}");
			return $query->row_array();
		}

		public function get_intrests(){
			$query = $this->db->get('SportsType');
			return $query->result();
		}
		
		public function get_level_name($sport_id,$level){
			$data = array('SportsType_ID'=>$sport_id,'SportsLevel_ID'=>$level);
			$get_name = $this->db->get_where('SportsLevels',$data);
			return $get_name->row_array();
		}
		
		public function get_sport_levels($sport_id){
			$data = array('SportsType_ID'=> $sport_id);
			$query = $this->db->get_where('SportsLevels',$data);
			return $query->result();
		}

		public function get_reg_tournment($tourn_id){
			$user_id = $this->session->userdata('users_id');
			$data = array('Tournament_ID'=>$tourn_id ,'Users_ID'=>$user_id);
			$query = $this->db->get_where('RegisterTournament',$data);
			return $query->row_array();
		}

		public function get_team_reg_tournment($tourn_id){		
			$user_id = $this->logged_user;		
				
			/*$qry_get = $this->db->query("SELECT * FROM Teams WHERE Players LIKE '%$user_id%' and Team_ID IN (SELECT Team_id FROM RegisterTournament WHERE Tournament_ID = $tourn_id)");*/		
			$qry_get = $this->db->query("SELECT * FROM RegisterTournament WHERE Team_Players LIKE '%$user_id%' AND Tournament_ID = {$tourn_id}");		
			return $qry_get->num_rows();		
		}

		public function check_is_paid($user, $tourn_id, $team){
			$qry_get = $this->db->query("SELECT * FROM Paytransactions WHERE Users_ID = '{$user}' AND mtype_ref = '{$tourn_id}' AND Team_id = '{$team}' AND status = 'Completed'");
			return $qry_get->num_rows();
		}

		public function get_reg_tourn_player_names($tourn_id){
			$data = array('Tournament_ID'=>$tourn_id);
			$get_tourn_names = $this->db->get_where('RegisterTournament',$data);
			return $get_tourn_names->result();
		}

		public function get_reg_tourn_partner_names($tourn_id, $get_mf_type){
			$type	= $get_mf_type;
			
			if($type){
			$qry_check = $this->db->query("SELECT * FROM RegisterTournament WHERE Tournament_ID = $tourn_id AND Match_Type LIKE '%$type%'");
			return $qry_check->result();
			}
			else{
			return false;
			}
		}

		public function get_reg_tourn_participants($tourn_id, $sport = ''){
			if($sport != ''){
			$qry_check = $this->db->query("select rt.* from RegisterTournament as rt join A2MScore as a on rt.Users_ID = a.Users_ID where rt.Tournament_ID = {$tourn_id} and a.SportsType_ID = {$sport} order by a.A2MScore DESC");
			}
			else{
			$qry_check = $this->db->query("SELECT * FROM RegisterTournament WHERE Tournament_ID = $tourn_id");
			}
			return $qry_check->result();
		}

		public function get_rr_round_matches($bracket_id, $round_num){
			$qry_check = $this->db->query("SELECT * FROM Tournament_Matches WHERE BracketID = $bracket_id AND Round_Num = $round_num");
			return $qry_check->result();
		}

		public function is_bracket_exists($tourn_id){
			$data = array('Tourn_ID'=>$tourn_id, 'Match_Type'=>'Doubles', 'Bracket_Type'=>'Round Robin');
			$query = $this->db->get_where('Brackets',$data);
			
			if ($query->num_rows() > 0){
				return true;
			} else {
				return false;
			}
		}
		public function tourn_title($tourn_id){
			$data = array('Tournament_ID'=>$tourn_id);
			$query = $this->db->get_where('RegisterTournament',$data);
			return $query->row_array();
		}

		public function get_tour_row_info($row_id){
			$data = array('Tourn_match_id'=>$row_id);
			$query = $this->db->get_where('Tournament_Matches',$data);
			
			return $query->row_array();
		}

		public function GetWaitListUsersNew($tourn_id){
			$users=array();
            $this->db->select('RegisterTournament.Users_ID,RegistrationWaitList.Event');    
            $this->db->from('RegistrationWaitList');
            $this->db->join('RegisterTournament', 'RegistrationWaitList.Register_ID = RegisterTournament.RegisterTournament_id');
            $this->db->where('RegistrationWaitList.Tournament_ID', $tourn_id);
            $query = $this->db->get();
	        $waitlistusers = $query->result();
	        foreach ($waitlistusers as $key => $value) {
	        	$users[$value->Users_ID][]=$value->Event;
	        }
	        return $users;
		}


		public function check_tourn($tourn_id){
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


		public function insert_tournament($data){
			$lat_long  = $data['latt'];
					
			$pieces	   = explode("@", $lat_long);
			$latitude  = $pieces[0];
			$longitude = $pieces[1];
		
			$users_id  = $this->logged_user;;

			$data = $this->upload->data();
			$filename = $data['file_name'];

			$title			= $this->input->post('title');
			$organizer		= $this->input->post('organizer');
			$org_contact	= $this->input->post('org_contact');

			//$sdate = $this->input->post('sdate');   substr("Hello world",3) lo world
			
			$sdate = date('Y-m-d', strtotime($this->input->post('sdate')));
			$edate = date('Y-m-d', strtotime($this->input->post('edate')));

			$reg_closedon = date('Y-m-d', strtotime($this->input->post('reg_closedon')));
			
			$max_players = $this->input->post('max_players');
			$venue		 = $this->input->post('venue');
			$addr1		 = $this->input->post('addr1');
			$addr2		 = $this->input->post('addr2');
			
		//	$addr = $addr1 . ',' .$addr2;


			$country = $this->input->post('country');
			if($country =='United States of America') {
				$state = $this->input->post('state');
			}
			else {
				$state = $this->input->post('state1');
			}
			
			$city	 = $this->input->post('city');
			$zipcode = $this->input->post('zipcode');
			$desc	 = htmlentities($this->input->post('desc'));
			$fee	 = $this->input->post('fee');
			$amt	 = $this->input->post('amt_one');
			
			$review = $this->input->post('recommend');
			$age	= json_encode($_POST['age']);
			$singles = json_encode($_POST['singles']);
			//$gender_type = json_encode($_POST['gender_type']);

			$gender_type  = $this->input->post('gender_type');
			$sport_type   = $this->input->post('sport_type');
			$sport_levels = json_encode($_POST['level']);
			$tourn_type	  = $this->input->post('tourn_type');
			$extra_amt	  = $this->input->post('amt_two');
			$access_group = $this->input->post('org_id');
			$visibility	  = $this->input->post('visible');		
					
			$is_academy   = 1;

			if($visibility == 'public'){
				$access_group = "";
			}
			
			//$reg_date = date("Y-m-d h:i:s");

			$age_grp_list = $this->input->post('age_group');					
			$is_mult_fee = 1;		
			$mult_fee_collect		= json_encode($this->input->post('fee_collect'));		
			$addn_mult_fee_collect	= NULL;		
			if($this->input->post('addn_fee_collect')){		
			$addn_mult_fee_collect	= json_encode($this->input->post('addn_fee_collect'));		
			}		
			$tour_format = $this->input->post('tour_format');		
			$lines = NULL;		
			$fee_collect_type = 'Player';		
			if($tour_format == "Teams")		
			{		
				$sgl = $this->input->post('singles_lines');		
				$dbl = $this->input->post('doubles_lines');		
				if($sgl or $dbl){		
					$lines = '[{"Singles":'.intval($sgl).'},{"Doubles":'.intval($dbl).'}]';		
				}		
			$fee_collect_type = $this->input->post('fee_collect_method');		
			}

			$data = array(
					'Usersid' => $users_id,
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
					'Sport_levels' => $sport_levels,
					'Tournament_type' => $tourn_type,
					'latitude' => $latitude,
					'longitude'=> $longitude,
					'TournmentReview' => $review,
					'PostalCode' => $zipcode,
					'Access_Groups' => $access_group,
					'Visibility' => $visibility,
					'is_mult_fee'		=> $is_mult_fee,
					'mult_fee_collect'	=> $mult_fee_collect,
					'addn_mult_fee_collect'	=> $addn_mult_fee_collect,
					'tournament_format'	=> $tour_format,		
					'lines_per_match'	=> $lines,		
					'Fee_collect_type '	=> $fee_collect_type
				);

			$this->db->insert('tournament', $data);
		    $insert_id = $this->db->insert_id();

			$data = array(
				'mtype'		  => 'Tournament',
				'rel_id'	  => $insert_id,
				'is_academy'  => $is_academy,
				'is_notified' => 1,
				'created_on'  => date('Y-m-d H:i'),
				'notified_on' => NULL
				);

		     $this->db->insert('Notification_Alerts', $data);

			$data = array('sport_id' => $sport_type, 'tourn_id' => $insert_id);
			
			return $data;
		}

		public function update_dob(){

		$user = $this->logged_user;
		$data = array();

		if($this->input->post('txt_dob'))
		{
			$dob		= $this->input->post('txt_dob');

			$birthdate	= new DateTime($dob);
			$today		= new DateTime('today');
			$age		= $birthdate->diff($today)->y;
			
			if ($age <= 12){ 
				$age_group = "U12";
			}
			else if ($age <= 14){
				$age_group = "U14";
			}
			else if ($age <= 16){
				$age_group = "U16";
			}
			else if($age <= 18){
				$age_group = "U18";
			}
			else{
				$age_group = "Adults";
			}

			$data = array (
					'DOB'				=> $dob,
					'UserAgegroup'		=> $age_group
					);
		}

		$data1 = array();

		if($this->input->post('CityName') or $this->input->post('zipcode'))
		{
		
			$addr1 = $this->input->post('UserAddressline1');
			$addr2 = $this->input->post('UserAddressline2');
			$country = $this->input->post('CountryName');

			$state = $this->input->post('StateName1');

			if($country == 'United States of America')
			{ $state = $this->input->post('StateName'); }

			$city = $this->input->post('CityName');
			$zip  = $this->input->post('zipcode');

			$lat_long	= $this->get_lang_latt();
			$pieces		= explode("@", $lat_long);
			
			$latitude	= $pieces[0];
			$longitude	= $pieces[1];

			$data1 = array(
					'UserAddressline1'	=> $addr1,
					'UserAddressline2'	=> $addr2,
					'Country'			=> $country,
					'State'				=> $state,
					'City'				=> $city,
					'Zipcode'			=> $zip,
					'Latitude'			=> $latitude,
					'Longitude'			=> $longitude
					);
		}

		$data2 = array();

		if($this->input->post('txt_email'))
		{
			$email = $this->input->post('txt_email');
			$data2 = array('EmailID' => $email);
		}

		$data = array_merge($data, $data1, $data2);

		$this->db->where('Users_ID', $user);
		$res = $this->db->update('Users', $data); 

		return $res;
		}


		public function get_lang_latt()
		{
			// $address1 = $this->input->post('UserAddressline1');
			if($this->input->post('UserAddressline2')==""){
			 $address2 = $this->input->post('UserAddressline1');
			} else {
			 $address2 = $this->input->post('UserAddressline2');
			}
			 $country = $this->input->post('CountryName');

			 if($country == 'United States of America') {
						$state = $this->input->post('StateName');
				} else {
						$state = $this->input->post('StateName1');
				}

			 $city		= $this->input->post('CityName');
			 $zipcode	= $this->input->post('Zipcode');


			 //$address =  $address2 . ' ' .  $country . ' ' .  $state . ' ' .  $city ;
			 $address =  $address2.' '.$country.' '.$state.' '.$city.' ' .$zipcode;


				if(!empty($address)){

				//Formatted address
				$formattedAddr = str_replace(' ','+',$address);

				//Send request and receive json data by address
				$geocodeFromAddr = file_get_contents('http://maps.googleapis.com/maps/api/geocode/json?address='.$formattedAddr.'&sensor=true_or_false'); 

				$output1 = json_decode($geocodeFromAddr);
				
				$latitude  = 0.00; 
				$longitude = 0.00;
			
				//Get latitude and longitute from json data
				$latitude  = $output1->results[0]->geometry->location->lat; 
				$longitude = $output1->results[0]->geometry->location->lng;

				return  $latitude  . '@' . $longitude ;
				} else {
					return false;
				}
		}


		public function update_tournament($data){
			
			$lat_long	= $data['latt']; 
			$img		= $data['up_image'];
					
			$pieces		= explode("@", $lat_long);
			$latitude	= $pieces[0];
			$longitude	= $pieces[1];

			$tourn_id = $data['tourn_id'];
			$users_id = $this->logged_user;

			//$data = $this->upload->data();
			$filename = $img['file_name'];

			$title		 = $this->input->post('title');
			$organizer	 = $this->input->post('organizer');
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
			if($country =='United States of America'){
				$state = $this->input->post('state');
			}
			else {
				$state = $this->input->post('state1');
			}
			
			$city		= $this->input->post('city');
			$zipcode	= $this->input->post('zipcode');
			$desc		= $this->input->post('desc');
			$fee		= $this->input->post('fee');
			$amt		= $this->input->post('amt_one');
			
			$review		= $this->input->post('recommend');
			$age		= json_encode($_POST['age']);
			$singles	= json_encode($_POST['singles']);
			//$gender_type = json_encode($_POST['gender_type']);

			$gender_type = $this->input->post('gender_type');
			$tourn_type = $this->input->post('tourn_type');
			$extra_amt = $this->input->post('amt_two');
			
			//$reg_date = date("Y-m-d h:i:s");

			$is_mult_fee = 1;
			$mult_fee_collect		= NULL;
			$addn_mult_fee_collect	= NULL;

			$fee_collect_method = 'Player';

			if($this->input->post('tour_format') == 'Teams'){
				$fee_collect_method = $this->input->post('fee_collect_method');
			}

			if($fee){
				//$is_mult_fee = 1;
				$mult_fee_collect		= json_encode($this->input->post('fee_collect'));
				$addn_mult_fee_collect	= json_encode($this->input->post('addn_fee_collect'));
			}

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
					'PostalCode' => $zipcode,
					'is_mult_fee'		=> $is_mult_fee,
					'mult_fee_collect'	=> $mult_fee_collect,
					'addn_mult_fee_collect'	=> $addn_mult_fee_collect,
					'Fee_collect_type'	=> $fee_collect_method
				);
			
			$this->db->where('tournament_ID', $tourn_id);
			$result = $this->db->update('tournament', $data);

			$data = array('tourn_id'=>$tourn_id,'title'=>$title);
			
			return $data;
		}

		public function get_reg_players($tourn_id){				   
			$data = array('Tournament_ID'=>$tourn_id);
			$query = $this->db->get_where('RegisterTournament',$data);
			return $query->result();
		}

		public function getonerow($tourn_id){				   
			$data = array('tournament_ID'=>$tourn_id);
			$query = $this->db->get_where('tournament',$data);
			return $query->row();
		}

		public function check_user_dob($user){				   
			$data = array('Users_ID'=>$user);
			$query = $this->db->get_where('Users',$data);
			return $query->row();
		}

		public function check_user_addr($user){				   
			$data = array('Users_ID'=>$user);
			//$this->db->select('Latitude');
			$query = $this->db->get_where('Users',$data);
			return $query->row();
		}

		public function get_sport_users($sport_id,$country,$state){  

			$qry_check = $this->db->query("SELECT u.Users_ID,u.Firstname,u.Lastname, u.EmailID FROM Users u inner join Sports_Interests s on u.Users_ID = s.users_id WHERE u.Country = '$country' AND u.State = '$state' AND s.Sport_id = $sport_id AND u.NotifySettings like '%1%' ");
			
			return $qry_check->result();
		}


		public function get_main_tourn_ids(){
			//$users_id = $this->session->userdata('users_id');

			$this->db->distinct();
			$this->db->select('Tournament_id');
			$this->db->from('Tournament_Images');
			//$this->db->where('Users_id',$users_id);
			$query=$this->db->get();
			return $query->result();
		}

		public function get_admin_tourn_images($data){
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

		public function get_individual_tourn_images($tourn_id){
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

		public function reg_team_tourn_no_fee()		
		{
			$tourn_id  = $this->input->post('id');		
			$team_id   = $this->input->post('team');		

			$data = array('Team_id'=>$team_id, 'Tournament_ID'=>$tourn_id);

			$check_team_is_reg = $this->db->get_where('RegisterTournament', $data);
			$is_reg = $check_team_is_reg->num_rows();

			if(!$is_reg)
			{
				$fee	   = $this->input->post('tour_fee');		
				$age_group = $this->input->post('age_group');		
				if($this->input->post('hc_loc_id')){		
					$home_court_loc = $this->input->post('hc_loc_id');		
				} else{		
					$home_court_loc = NULL;		
				}		
				$level = $this->input->post('level');		
				$reg_date = date("Y-m-d h:i:s");		
				$short_list_players = json_encode($this->input->post('sel_team_player'));		
				$data = array(		
						'Team_id'		=> $team_id,		
						'Team_Players'	=> $short_list_players,		
						'Tournament_ID' => $tourn_id,		
						'Fee'			=> number_format($fee, 2),		
						'Reg_Age_Group' => $age_group,		
						'Reg_Sport_Level' => $level,		
						'Reg_date'		=> $reg_date,		
						'hcl_id'		=> $home_court_loc		
						);		
				$result = $this->db->insert('RegisterTournament', $data);			
				return $result;		
			}
			else
			{
				$get_reg = $check_team_is_reg->row_array();
				$reg_players = json_decode($get_reg['Team_Players']);		

				if(!in_array($this->logged_user, $reg_players))
				{
					$ins_user = (string)$this->logged_user;
					array_push($reg_players, $ins_user);

					$upd_players = json_encode($reg_players);

					$data = array('Team_Players' => $upd_players);
					
						   $this->db->where('RegisterTournament_id', $get_reg['RegisterTournament_id']);
					$upd = $this->db->update('RegisterTournament', $data);
					return $upd;
				}
			}
		}

		public function reg_tourn_no_fee()
		{
			$user_id = $this->logged_user;
			$tourn_id = $this->input->post('id');
			
			$match_types = json_encode($this->input->post('mtype'));
			$fee = $this->input->post('tour_fee');
			$age_group = $this->input->post('age_group');
			$partner1 = $this->input->post('created_users_id');
			$partner2 = $this->input->post('created_users_id1');
	
			if($this->input->post('hc_loc_id')){
				$home_court_loc = $this->input->post('hc_loc_id');
			} else{
				$home_court_loc = NULL;
			}

			$level = $this->input->post('level');

			//$level = json_encode($this->input->post('level'));

			$reg_date = date("Y-m-d h:i:s");  

			$data = array(
					'Users_ID' => $user_id,
					'Tournament_ID' => $tourn_id,
					'Match_Type' => $match_types,
					'Fee' => $fee,
					'Partner1' => $partner1,
					'Partner2' => $partner2,
					'Reg_Age_Group' => $age_group,
					'Reg_Sport_Level' => $level,
					'Reg_date' => $reg_date,
					'hcl_id'		=> $home_court_loc
					);

			//print_r($data);
			//exit;
			
			$result = $this->db->insert('RegisterTournament', $data);	
			return $result;
		}

		public function reg_tourn_with_fee($data){

			$user_id		= $data['player'];
			$tourn_id		= $data['tourn_id'];
			$match_types	= $data['mtypes'];
			$age_group		= $data['age_group'];
			$partner1		= $data['partner1'];
			$partner2		= $data['partner2'];
			$level			= $data['level'];

			if($data['hc_loc_id']){
				$home_court_loc = $data['hc_loc_id'];
			} else{
				$home_court_loc = NULL;
			}

			$fee			= $data['payment_amt'];
			$currency_code	= $data['currency_code'];
			$trans_id		= $data['txn_id'];
			$status			= $data['status'];

			$reg_date = date("Y-m-d h:i:s");

			$data = array (
					'Users_ID' => $user_id,
					'Tournament_ID' => $tourn_id,
					'Match_Type' => $match_types,
					'Fee' => $fee,
					'Partner1' => $partner1,
					'Partner2' => $partner2,
					'Reg_Age_Group' => $age_group,
					'Reg_Sport_Level' => $level,
					'Reg_date' => $reg_date,
					'Transaction_id' => $trans_id,
					'Status' => $status,
					'Currency_Code' => $currency_code,
					'hcl_id'		=> $home_court_loc
					);

			//print_r($data);
			//exit;
		
			$result = $this->db->insert('RegisterTournament', $data);	
			return $result;
		}

		public function team_player_fee_paymet($data){

			$user_id		= $data['player'];
			$tourn_id		= $data['league'];
			$team			= $data['team'];

			$fee			= $data['payment_amt'];
			$currency_code	= $data['currency_code'];
			$trans_id		= $data['txn_id'];
			$status			= $data['status'];

			$reg_date		= date("Y-m-d h:i:s");

			$data = array(
					'pay_date'		=> $reg_date,
					'Users_ID'		=> $user_id,
					'mtype'			=> 'tournament',
					'mtype_ref'		=> $tourn_id,
					'Team_id'		=> $team,
					'Amount'		=> number_format($fee, 2),
					'Transaction_id' => $trans_id,
					'Status'		=> $status
					);

			$result = $this->db->insert('PayTransactions', $data);	
			return $result;
		}

		public function search_autocomplete($data){
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

		public function autocomplete_hloc($data)
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

			$values = explode('@',$points);
			$loc_lat = $values[0];
			$loc_long = $values[1];
			
			$title	= $data['title'];
		    $add	= $data['add'];
			$city	= $data['city'];
			$state	= $data['state'];
			$country = $data['country'];
		    $zip	= $data['zip'];

			$data = array(
					'hcl_title' => $title,
					'hcl_address' => $add,
					'hcl_city' => $city,
					'hcl_state' => $state,
					'hcl_country' => $country,
					'hcl_zipcode' => $zip,
					'hcl_created_by' => $this->session->userdata('users_id'),
					'hcl_lat' => $loc_lat,
					'hcl_long' => $loc_long
				);

			$result = $this->db->insert('Home_Court_Locations', $data);
		    return  $result; 	
	    }

		public function get_fixtures_det($tourn_id){

			$data		= array('tournament_ID' => $tourn_id);
			$get_name	= $this->db->get_where('tournament',$data);
			return $get_name->row_array();
		}

		public function get_sport_title($sport_id){
			
			$data = array('SportsType_ID'=>$sport_id);
			$get_sp_name = $this->db->get_where('SportsType',$data);
			return $get_sp_name->row_array();
		}

		public function get_reg_tourn_users($tourn_id){
		
			
			//$type = $data['types'];
			
			//$data = array('Tournament_ID'=>$tourn_id,'Match_Type' =>$type);
			//$data = array('Tournament_ID'=>$tourn_id);
			//print_r($data);
			//exit;
			//$get_name = $this->db->get_where('RegisterTournament',$data);
			//return $get_name->result();
		
		}
		public function get_reg_tourn_usernames($tourn_id){

			$qry_check = $this->db->query("SELECT u.Users_ID,u.Firstname,u.Lastname FROM RegisterTournament t inner join Users u on u.Users_ID = t.Users_ID WHERE Tournament_ID = $tourn_id");

			return $qry_check->result();
		}

		/*
		public function get_reg_tourn_age_usernames($data){

			$tourn_id = $data['tourn_id'];
			$age_group = $data['age_group'];
			$match_type= $data['match_type'];
			$gender = $data['gender'];
			$sport = $data['sport'];
			$level = $data['level'];
			
			$gender_count = count($gender);
			$i = 0;
			if($gender_count > 0){
				$gender_in = "";
				$gender_in = implode(',',$gender);
				$gender_qry = "AND Gender IN ($gender_in)";
			}
			else {
				$gender_qry = "";
			}

			$age_group_count = count(array_filter($age_group));

			$i = 0;
			if($age_group_count > 0){
				$age_group_in = "";
				foreach($age_group as $row3)
				{
					$age_group_in .= "'$row3'";

						if(++$i != $age_group_count) {
							$age_group_in .= ",";
						}
				}
				$age_group_qry = "AND t.Reg_Age_Group IN ($age_group_in)";
			}
			else {
				$age_group_qry = "";
			}


			$level_count = count(array_filter($level));
			$i = 0;
			if($level_count > 0 ){
			
				$level_in = "";
				foreach($level as $l)
				{
					$level_in .= "'$l'";
						if(++$i != $level_count){
							$level_in .= ",";
						}
				}
			   $level_query = "AND t.Reg_Sport_Level IN ($level_in)";
			   
			 //u.Users_ID IN (SELECT users_id FROM Sports_Interests WHERE Level IN ($level_in) AND Sport_id = {$sport})";
			}
			else
			{
				$level_query = "";
			}

			$s = "";

			if(!empty($level)){

			$s .=  "{$level_query}";
			}

			if(!empty($age_group)){

			$s .=  "{$age_group_qry}";
			}

			if (!empty($gender))
			{
			  $s .=  "{$gender_qry}";
			}

			
			$user_id = $this->session->userdata('users_id');

			if($match_type == 'Singles'){

				//$qry_check = $this->db->query("SELECT u.Users_ID, u.Firstname, u.Lastname, u.UserAgegroup FROM Users u inner join RegisterTournament t on u.Users_ID = t.Users_ID WHERE t.Tournament_ID = $tourn_id AND t.Match_Type LIKE '%$match_type%' $s");

				$qry_check = $this->db->query("SELECT u.Users_ID, u.Firstname, u.Lastname, u.UserAgegroup,a2m.A2MScore FROM Users u  
			join RegisterTournament t on u.Users_ID = t.Users_ID join A2MScore a2m  on a2m.Users_ID = u.Users_ID 
			WHERE t.Tournament_ID = $tourn_id AND  a2m.SportsType_ID = $sport AND t.Match_Type LIKE '%$match_type%' $s order by a2m.A2MScore desc");

			}
			else if($match_type == 'Doubles'){

			//$qry_check = $this->db->query("SELECT u.Users_ID, u.Firstname, u.Lastname, u.UserAgegroup,t.Partner1 FROM Users u inner join RegisterTournament t on u.Users_ID = t.Users_ID WHERE t.Tournament_ID = $tourn_id AND t.Match_Type LIKE '%$match_type%' $s");

			$qry_check = $this->db->query("SELECT u.Users_ID, u.Firstname, u.Lastname, u.UserAgegroup,a2m.A2MScore,t.Partner1 FROM Users u  
			join RegisterTournament t on u.Users_ID = t.Users_ID join A2MScore a2m  on a2m.Users_ID = u.Users_ID 
			WHERE t.Tournament_ID = $tourn_id AND  a2m.SportsType_ID = $sport AND t.Match_Type LIKE '%$match_type%' $s order by a2m.A2MScore desc");
			}
			else if($match_type == 'Mixed'){
			
			//$qry_check = $this->db->query("SELECT u.Users_ID, u.Firstname, u.Lastname, u.UserAgegroup FROM Users u inner join RegisterTournament t on u.Users_ID = t.Partner2 WHERE t.Tournament_ID = $tourn_id AND t.Match_Type LIKE '%$match_type%' $s");

			$qry_check = $this->db->query("SELECT u.Users_ID, u.Firstname, u.Lastname, u.UserAgegroup,a2m.A2MScore,t.Partner2 FROM Users u  
			join RegisterTournament t on u.Users_ID = t.Users_ID join A2MScore a2m  on a2m.Users_ID = u.Users_ID 
			WHERE t.Tournament_ID = $tourn_id AND  a2m.SportsType_ID = $sport AND t.Match_Type LIKE '%$match_type%' $s order by a2m.A2MScore desc");
			}

			//print_r($this->db->last_query());
			//exit;

			return $qry_check->result();
		}
		*/

		public function get_tourn_reg_teams($data){
			$tourn_id	= $data['tourn_id'];
			$age_group	= $data['age_group'];
			$sport		= $data['sport'];
			$level		= $data['level'];


			$age_group_count = count(array_filter($age_group));
			$i = 0;
			if($age_group_count > 0){
				$age_group_in = "";
				foreach($age_group as $row3)
				{
					$age_group_in .= "'$row3'";

						if(++$i != $age_group_count) {
							$age_group_in .= ",";
						}
				}
				$age_group_qry = "Reg_Age_Group IN ($age_group_in)";
			}
			else {
				$age_group_qry = "";
			}



			$level_count = count(array_filter($level));
			$i = 0;
			if($level_count > 0 ){
			
				$level_in = "";
				foreach($level as $l)
				{
					$level_in .= "'$l'";
						if(++$i != $level_count){
							$level_in .= ",";
						}
				}
			   $level_query = "Reg_Sport_Level IN ($level_in)";
			   
			 //u.Users_ID IN (SELECT users_id FROM Sports_Interests WHERE Level IN ($level_in) AND Sport_id = {$sport})";
			}
			else{
				$level_query = "";
			}



			if(!empty($level)){
				$s .=  "{$level_query}";
			}

			if(!empty($age_group) and !empty($level)){
				$s .=  "AND {$age_group_qry}";
			}else{
				$s .=  "{$age_group_qry}";
			}


		
			//$qry_check = $this->db->query("SELECT u.Users_ID, u.Firstname, u.Lastname, u.UserAgegroup FROM Users u inner join RegisterTournament t on u.Users_ID = t.Partner2 WHERE t.Tournament_ID = $tourn_id AND t.Match_Type LIKE '%$match_type%' $s");
			$qry_check = $this->db->query("SELECT * FROM Teams where Team_ID IN (SELECT Team_id FROM RegisterTournament WHERE {$s} AND Tournament_id = '$tourn_id')");		


			//print_r($this->db->last_query());
			//exit;

			return $qry_check->result();


		}

		public function get_reg_tourn_age_usernames($data){

			$tourn_id	= $data['tourn_id'];
			$age_group	= $data['age_group'];
			$match_type	= $data['match_type'];
			$gender		= $data['gender'];
			$sport		= $data['sport'];
			$level		= $data['level'];
			
			$gender_count = count($gender);
			$i = 0;

			if($gender_count > 0){
				$gender_in = "";
				/*foreach($gender as $row2)
				{
					$gender_in .= intval($row2);

						if(++$i != $gender_count) {
							$gender_in .= ",";
						}
				}*/
				$gender_in = implode(',',$gender);
				$gender_qry = "AND Gender IN ($gender_in)";
			}
			else {
				$gender_qry = "";
			}

			$age_group_count = count(array_filter($age_group));

			$i = 0;
			if($age_group_count > 0){
				$age_group_in = "";
				foreach($age_group as $row3)
				{
					$age_group_in .= "'$row3'";

						if(++$i != $age_group_count) {
							$age_group_in .= ",";
						}
				}
				$age_group_qry = "AND t.Reg_Age_Group IN ($age_group_in)";
			}
			else {
				$age_group_qry = "";
			}


			$level_count = count(array_filter($level));
			$i = 0;
			if($level_count > 0 ){
			
				$level_in = "";
				foreach($level as $l)
				{
					$level_in .= "'$l'";
						if(++$i != $level_count){
							$level_in .= ",";
						}
				}
			   $level_query = "AND t.Reg_Sport_Level IN ($level_in)";
			   
			 //u.Users_ID IN (SELECT users_id FROM Sports_Interests WHERE Level IN ($level_in) AND Sport_id = {$sport})";
			}
			else{
				$level_query = "";
			}

			if(!empty($level)){
				$s .=  "{$level_query}";
			}

			if(!empty($age_group)){
				$s .=  "{$age_group_qry}";
			}

			if (!empty($gender)){
				$s .=  "{$gender_qry}";
			}

			
			$user_id = $this->logged_user;

			if($match_type == 'Singles'){

				//$qry_check = $this->db->query("SELECT u.Users_ID, u.Firstname, u.Lastname, u.UserAgegroup FROM Users u inner join RegisterTournament t on u.Users_ID = t.Users_ID WHERE t.Tournament_ID = $tourn_id AND t.Match_Type LIKE '%$match_type%' $s");

				$qry_check = $this->db->query("SELECT u.Users_ID, u.Firstname, u.Lastname, u.UserAgegroup,a2m.A2MScore FROM Users u  
			join RegisterTournament t on u.Users_ID = t.Users_ID join A2MScore a2m  on a2m.Users_ID = u.Users_ID 
			WHERE t.Tournament_ID = $tourn_id AND  a2m.SportsType_ID = $sport AND t.Match_Type LIKE '%$match_type%' $s order by a2m.A2MScore desc");

			}
			else if($match_type == 'Doubles'){

			//$qry_check = $this->db->query("SELECT u.Users_ID, u.Firstname, u.Lastname, u.UserAgegroup,t.Partner1 FROM Users u inner join RegisterTournament t on u.Users_ID = t.Users_ID WHERE t.Tournament_ID = $tourn_id AND t.Match_Type LIKE '%$match_type%' $s");

			$qry_check = $this->db->query("SELECT u.Users_ID, u.Firstname, u.Lastname, u.UserAgegroup,a2m.A2MScore,t.Partner1 FROM Users u  
			join RegisterTournament t on u.Users_ID = t.Users_ID join A2MScore a2m  on a2m.Users_ID = u.Users_ID 
			WHERE t.Tournament_ID = $tourn_id AND  a2m.SportsType_ID = $sport AND t.Match_Type LIKE '%$match_type%' $s order by a2m.A2MScore desc");
			}
			else if($match_type == 'Mixed'){
			
			//$qry_check = $this->db->query("SELECT u.Users_ID, u.Firstname, u.Lastname, u.UserAgegroup FROM Users u inner join RegisterTournament t on u.Users_ID = t.Partner2 WHERE t.Tournament_ID = $tourn_id AND t.Match_Type LIKE '%$match_type%' $s");

			$qry_check = $this->db->query("SELECT u.Users_ID, u.Firstname, u.Lastname, u.UserAgegroup,a2m.A2MScore,t.Partner2 FROM Users u  
			join RegisterTournament t on u.Users_ID = t.Users_ID join A2MScore a2m  on a2m.Users_ID = u.Users_ID 
			WHERE t.Tournament_ID = $tourn_id AND  a2m.SportsType_ID = $sport AND t.Match_Type LIKE '%$match_type%' $s order by a2m.A2MScore desc");
			}

			else if($match_type == ''){
			
			//$qry_check = $this->db->query("SELECT u.Users_ID, u.Firstname, u.Lastname, u.UserAgegroup FROM Users u inner join RegisterTournament t on u.Users_ID = t.Partner2 WHERE t.Tournament_ID = $tourn_id AND t.Match_Type LIKE '%$match_type%' $s");

			$qry_check = $this->db->query("SELECT u.Users_ID, u.Firstname, u.Lastname, u.UserAgegroup,a2m.A2MScore,t.Partner2 FROM Users u  
			join RegisterTournament t on u.Users_ID = t.Users_ID join A2MScore a2m  on a2m.Users_ID = u.Users_ID 
			WHERE t.Tournament_ID = $tourn_id AND  a2m.SportsType_ID = $sport $s order by a2m.A2MScore desc");
			}

			//print_r($this->db->last_query());
			//exit;

			return $qry_check->result();
		}

		public function tourn_single_users($tourn_id,$match_type,$sport){

			$user_id = $this->logged_user;

			if($match_type == 'Singles'){

			//$qry_check = $this->db->query("SELECT u.Users_ID, u.Firstname, u.Lastname, u.UserAgegroup FROM Users u inner join RegisterTournament t on u.Users_ID = t.Users_ID WHERE t.Tournament_ID = $tourn_id AND t.Match_Type LIKE '%$match_type%'");

			$qry_check = $this->db->query("SELECT u.Users_ID, u.Firstname, u.Lastname, u.UserAgegroup,a2m.A2MScore FROM Users u  
			join RegisterTournament t on u.Users_ID = t.Users_ID join A2MScore a2m  on a2m.Users_ID = u.Users_ID 
			WHERE t.Tournament_ID = $tourn_id AND  a2m.SportsType_ID = $sport AND t.Match_Type LIKE '%$match_type%' order by a2m.A2MScore desc");
			}
			else if($match_type == 'Doubles'){
			
			//$qry_check = $this->db->query("SELECT Users_ID ,Partner1 FROM RegisterTournament WHERE Tournament_ID = $tourn_id AND Match_Type LIKE '%$match_type%'");

			$qry_check = $this->db->query("SELECT u.Users_ID, u.Firstname, u.Lastname, u.UserAgegroup,a2m.A2MScore,t.Partner1 FROM Users u  
			join RegisterTournament t on u.Users_ID = t.Users_ID join A2MScore a2m  on a2m.Users_ID = u.Users_ID 
			WHERE t.Tournament_ID = $tourn_id AND  a2m.SportsType_ID = $sport AND t.Match_Type LIKE '%$match_type%' order by a2m.A2MScore desc");

			}
			else if($match_type == 'Mixed'){
			
			$qry_check = $this->db->query("SELECT u.Users_ID, u.Firstname, u.Lastname, u.UserAgegroup,a2m.A2MScore,t.Partner2 FROM Users u  
			join RegisterTournament t on u.Users_ID = t.Users_ID join A2MScore a2m  on a2m.Users_ID = u.Users_ID 
			WHERE t.Tournament_ID = $tourn_id AND  a2m.SportsType_ID = $sport AND t.Match_Type LIKE '%$match_type%' order by a2m.A2MScore desc");

			}
			
			return $qry_check->result();

		} 

		public function registered_players($data){
				
			$tourn_id = $data['tourn_id'];
			$match_type= $data['match_type'];
			$age_group = $data['age_group'];
			$level = $data['level'];
			
			if($level != "" and $match_type == 'Singles' or $match_type == 'Mixed')
			{
				$level_query = "AND t.Reg_Sport_Level = $level";
			}
			else if($level != "" and $match_type == 'Doubles')
			{
				$level_query = "AND Reg_Sport_Level = $level";
			}
			else
			{
				$level_query = "";
			}

			if($age_group == "Adults"){
				$age_group = "'Adults','Adults_30p','Adults_40p','Adults_50p','Adults_veteran'";
			} else {
				$age_group = "'$age_group'";
			}


			if($match_type == 'Singles'){

				$qry_check = $this->db->query("SELECT t.Match_Type,t.Reg_Age_Group,t.Reg_Sport_Level,t.Tournament_ID,u.Users_ID, u.Firstname, u.Lastname, u.UserAgegroup FROM Users u inner join RegisterTournament t on u.Users_ID = t.Users_ID WHERE t.Tournament_ID = $tourn_id AND t.Match_Type LIKE '%$match_type%' AND t.Reg_Age_Group IN ($age_group) {$level_query}");
			}
			else if($match_type == 'Doubles'){
			
			$qry_check = $this->db->query("SELECT Users_ID,Tournament_ID,Partner1 ,Match_Type,Reg_Sport_Level,Reg_Age_Group FROM RegisterTournament WHERE Tournament_ID = $tourn_id AND Match_Type LIKE '%$match_type%' AND Reg_Age_Group IN ($age_group) {$level_query}");
			}
			else if($match_type == 'Mixed'){
			
			$qry_check = $this->db->query("SELECT t.Match_Type,t.Tournament_ID,t.Reg_Age_Group,t.Reg_Sport_Level, u.Users_ID, u.Firstname, u.Lastname, u.UserAgegroup FROM Users u inner join RegisterTournament t on u.Users_ID = t.Partner2 WHERE t.Tournament_ID = $tourn_id AND t.Match_Type LIKE '%$match_type%' AND t.Reg_Age_Group IN ($age_group) {$level_query}");
			}

			//print_r($this->db->last_query());
			//echo "<pre>";
			//sprint_r($qry_check->result());

			return $qry_check->result();
		}


		public function participants($data){
		
			$tourn_id = intval($data['tourn_id']);
			$match_type= $data['match_type'];
			$age_group = $data['age_type'];
			$level = $data['level'];
			
			if($level != "" and $match_type == 'Singles' or $match_type == 'Mixed')
			{
				$level_query = "AND t.Reg_Sport_Level = $level";
			}
			else if($level != "" and $match_type == 'Doubles')
			{
				$level_query = "AND Reg_Sport_Level = $level";
			}
			else
			{
				$level_query = "";
			}

			if($age_group == "Adults"){
				$age_group = "'Adults','Adults_30p','Adults_40p','Adults_50p','Adults_veteran'";
			} else {
				$age_group = "'$age_group'";
			}


			if($match_type == 'Singles'){

				$qry_check = $this->db->query("SELECT t.Match_Type,t.Reg_Age_Group,t.Reg_Sport_Level,t.Tournament_ID,u.Users_ID, u.Firstname, u.Lastname, u.UserAgegroup FROM Users u inner join RegisterTournament t on u.Users_ID = t.Users_ID WHERE t.Tournament_ID = $tourn_id AND t.Match_Type LIKE '%$match_type%' AND t.Reg_Age_Group IN ($age_group) {$level_query}");
			}
			else if($match_type == 'Doubles'){
			
			$qry_check = $this->db->query("SELECT Users_ID,Tournament_ID,Partner1 ,Match_Type,Reg_Sport_Level,Reg_Age_Group FROM RegisterTournament WHERE Tournament_ID = $tourn_id AND Match_Type LIKE '%$match_type%' AND Reg_Age_Group IN ($age_group) {$level_query}");
			}
			else if($match_type == 'Mixed'){
			
			$qry_check = $this->db->query("SELECT t.Match_Type,t.Tournament_ID,t.Reg_Age_Group,t.Reg_Sport_Level, u.Users_ID, u.Firstname, u.Lastname, u.UserAgegroup FROM Users u inner join RegisterTournament t on u.Users_ID = t.Partner2 WHERE t.Tournament_ID = $tourn_id AND t.Match_Type LIKE '%$match_type%' AND t.Reg_Age_Group IN ($age_group) {$level_query}");
			}

			 //print_r($this->db->last_query());
			 //exit;
			return $qry_check->result();

		}

		

		public function get_match_types($tourn_id){

			$data = array('Tournament_ID'=>$tourn_id);
			$get_tourn_ids = $this->db->get_where('RegisterTournament',$data);
			return $get_tourn_ids->result();
		
		}

		public function insert_golf_brackets(){   // Insert Golf Tournament Brackets into db

			$match_type	  = $this->input->post('match_type');
			$age_group	  = $this->input->post('age_group');
			$tourn_id	  = $this->input->post('tourn_id');
			$draw_title   = $this->input->post('draw_title');
			$bracket_type = $this->input->post('ttype');
			$created_on   = date("Y-m-d H:i:s");

			$data = array(
					'Tourn_ID'		=> $tourn_id,
					'Bracket_Type'	=> $bracket_type,
					'Draw_Title'	=> $draw_title,
					'Created_on'	=> $created_on,
					'Match_Type'	=> $match_type,
					'Age_Group'		=> $age_group
					);
			

			$this->db->insert('Brackets', $data);	
			$bracket_id = $this->db->insert_id();    
			
			$golf_players = $this->input->post('players');

			foreach($golf_players as $player){

				$data = array(
					'BracketID'	=> $bracket_id,
					'Tourn_ID'	=> $tourn_id,
					'Player'	=> $player,
					'Draw_Type'	=> $bracket_type
					);

			   $ins_to = $this->db->insert('Tournament_Matches_Golf', $data);
			}

			if($ins_to){
				return true;
			}
			else{
				return false;
			}

		}

		public function insert_rr_brackets(){   // Insert Round Robin Tournament Brackets into db
		
			$matches = $this->input->post('match');
			            
			$match_type = $this->input->post('match_type');
			$age_group = $this->input->post('age_group');
			$tourn_id = $this->input->post('tourn_id');

			$rr_matches = unserialize($this->input->post('rr_matches'));
			$rr_matches_loc = unserialize($this->input->post('rr_matches_loc'));

			$num_rounds = count($rr_matches);

			$tourn_det = $this->get_fixtures_det($tourn_id);
			$draw_title = $this->input->post('draw_title');

			$bracket_type = $this->input->post('ttype');
			//$num_rounds = count($rounds);
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
			
		/*	echo "<pre>";
		print_r($data);
		echo "-----------------------";
		exit;*/

			$this->db->insert('Brackets', $data);	

			$bracket_id = $this->db->insert_id();      
			 
			 //Tournament_Matches
			$player1_score = "";
			$player2_score = "";
			$winner = "";
			$win_per = "";

			foreach($rr_matches as $i=>$rrm){

			$round = $i;

				 foreach($rr_matches[$i] as $j=>$match){

					 $match_num = $j;

					 $rdate = $this->input->post('round_date'.$i);
					 $round_duedate = NULL;

					if($rdate){
						$time_hr = $this->input->post('match_time_hr'.$i);

						 if($time_hr){
							 
							$time_mm = ($this->input->post('match_time_mm'.$i != "")) ? 
								 $this->input->post('match_time_mm'.$i) : "00";

							 $time_am = $this->input->post('match_time_am'.$i);

							 $time = $time_hr.":".$time_mm." ".$time_am;
							 $date_time = $rdate." ".$time;
							 $round_duedate = date("Y-m-d H:i", strtotime($date_time));
						 }
						 else{
							 $round_duedate = date("Y-m-d", strtotime($rdate));
						 }
					}
					$player1_val = explode('-',$rr_matches[$i][$j][0]);
					$player2_val = explode('-',$rr_matches[$i][$j][1]);

					$data = array(
						'BracketID' => $bracket_id,
						'Tourn_ID' => $tourn_id,
						'Round_Num' => $round,
						'Match_Num' => $match_num,
						'Player1' => intval($player1_val[0]),
						'Player2' => intval($player2_val[0]),
						'Winner' => $winner,
						'Win_Per' => $win_per,
						'Player1_Partner' => $player1_val[1],
						'Player2_Partner' => $player2_val[1],
						'Draw_Type' => $bracket_type,
						'Match_DueDate' => $round_duedate,
						'Match_Location'=> $match_loc
					);
					
					$ins_to = $this->db->insert('Tournament_Matches', $data);
					$tour_match_id = $this->db->insert_id();

					if($tourn_det['tournament_format'] = 'Teams'){
						$lines = json_decode($tourn_det['lines_per_match']);

						if($lines[0]->Singles){
							for($a=1; $a<=$lines[0]->Singles; $a++)
							{
								$data = array(
								'Tourn_match_id'	=> $tour_match_id,
								'Tourn_ID'			=> $tourn_id,
								'BracketID'			=> $bracket_id,
								'Line_num'			=> $a,
								'Draw_Type'			=> $bracket_type,
								'Match_Type'		=> 'Singles',
								);

							$ins_to = $this->db->insert('Tournament_Lines', $data);
							}
						}

						if($lines[1]->Doubles){
							for($b=1; $b<=$lines[1]->Doubles; $b++)
							{
								$data = array(
								'Tourn_match_id'	=> $tour_match_id,
								'Tourn_ID'			=> $tourn_id,
								'BracketID'			=> $bracket_id,
								'Line_num'			=> $b,
								'Draw_Type'			=> $bracket_type,
								'Match_Type'		=> 'Doubles',
								);

							$ins_to = $this->db->insert('Tournament_Lines', $data);
							}
						}
					}

				 }
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
/*			echo "<pre>";
			print_r($this->input->post('player1'));
			print_r($this->input->post('player2'));
			exit;
*/
			$rounds  = $this->input->post('round');
			$matches = $this->input->post('match_num');
			$player1 = $this->input->post('player1');
			$player2 = $this->input->post('player2');
            
			$match_type = $this->input->post('match_type');
			$age_group  = $this->input->post('age_group');


			$tourn_id = $this->input->post('tourn_id');
			$draw_title = $this->input->post('draw_title');

			$tourn_det = $this->get_fixtures_det($tourn_id);

			$bracket_type	= $this->input->post('ttype');
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

					if($player1[$round][$match][0] == "---" or $player1[$round][$match][0] == "----")
					{
						$player1_val = "";
					}
					else
					{
						$player1_val = intval($player1[$round][$match][0]);
						$player1_partner = explode("-", $player1[$round][$match][0]);
					}


					if($player2[$round][$match][0] == "---" or $player2[$round][$match][0] == "----")
					{ 
						$player2_val = "";
						if($round==1){
							$player1_score = 'Bye Match';
							$player2_score = 'Bye Match';
							$winner = intval($player1[$round][$match][0]);
							$win_per = 0;
						}
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

		public function update_tourn_dates()
		{
		/*	echo "<pre>";
			print_r($_POST);
			exit;*/

			$rounds		= $this->input->post('round');
			$matches	= $this->input->post('match_num');
			$tour_id	= $this->input->post('tour_id');
			$bracket_id = $this->input->post('bracket_id');

			 foreach($rounds as $round)
			{
					//echo $round."<br>";
				foreach($matches[$round] as $match)
				{
					
					$date_round = $this->input->post('round_date'.$round);
					$date_match = $this->input->post('match_date'.$match);

					$match_due_date = NULL;

					if($date_round != ""){
						$match_due_date = date("Y-m-d H:i",strtotime($date_round));
					}
					else if($date_match != ""){
						$match_due_date = date("Y-m-d H:i",strtotime($date_match)); 
					}

					$data = array(
					'Match_DueDate' => $match_due_date
					);

					$this->db->where('BracketID', $bracket_id);
					$this->db->where('Tourn_ID',  $tour_id);
					$this->db->where('Round_Num', $round);
					$this->db->where('Match_Num', $match);

					$this->db->update('Tournament_Matches', $data); 
					//echo "<br>".$this->db->last_query();
				}
			}

			$draw_type = $this->input->post('update_draw_status');

			if($draw_type == 2){

			$rounds			= $this->input->post('cround');
			$matches		= $this->input->post('cmatch_num');
			$tour_id		= $this->input->post('tour_id');
			$bracket_id		= $this->input->post('bracket_id');
			$bracket_type	= 'Consolation';

			 foreach($rounds as $round)
			{
					//echo $round."<br>";
				foreach($matches[$round] as $match)
				{
					
					$date_round = $this->input->post('cround_date'.$round);
					$date_match = $this->input->post('cons_match_date'.$match);

					$match_due_date = NULL;

					if($date_round != ""){
						$match_due_date = date("Y-m-d H:i",strtotime($date_round));
					}
					else if($date_match != ""){
						$match_due_date = date("Y-m-d H:i",strtotime($date_match)); 
					}

					$data = array(
					'Match_DueDate' => $match_due_date
					);

					$this->db->where('BracketID', $bracket_id);
					$this->db->where('Tourn_ID',  $tour_id);
					$this->db->where('Round_Num', $round);
					$this->db->where('Match_Num', $match);
					$this->db->where('Draw_Type', $bracket_type);

					$this->db->update('Tournament_Matches', $data); 
					echo "<br>".$this->db->last_query();
				}
			}

			}
		}

		public function update_rr_tourn_dates(){

			$rounds			= $this->input->post('round');
			//$matches		= $this->input->post('cmatch_num');
			$tour_id		= $this->input->post('tour_id');
			$bracket_id		= $this->input->post('bracket_id');
			$bracket_type	= 'Round Robin';

			foreach($rounds as $round)
			{
					//echo $this->input->post('round_date'.$round)."<br>";
					
					$date_round = $this->input->post('round_date'.$round);
					//$date_match = $this->input->post('cons_match_date'.$match);

					$match_due_date = NULL;

					if($date_round != ""){
						$match_due_date = date("Y-m-d H:i:s",strtotime($date_round));
					}
					
					$data = array(
					'Match_DueDate' => $match_due_date
					);

					$this->db->where('BracketID', $bracket_id);
					$this->db->where('Tourn_ID',  $tour_id);
					$this->db->where('Round_Num', $round);
					//$this->db->where('Match_Num', $match);
					$this->db->where('Draw_Type', $bracket_type);

					$this->db->update('Tournament_Matches', $data); 
					//echo "<br>".$this->db->last_query();
			}

		}


		public function user_reg_or_not($user_id,$tourn_id)
		{
		
			$query = $this->db->query("SELECT * FROM RegisterTournament WHERE Tournament_ID = '$tourn_id' AND Users_ID = '$user_id'");
		
			if ($query->num_rows() > 0){
				return true;
			}
			else{
				return false;
			}
		}


		public function check_draw_title($tourn_id, $draw_title)
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

		public function get_tourn_match_id($bid)
		{

			$data = array('BracketID' => $bid);
			$query = $this->db->get_where('Tournament_Matches',$data);

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

		public function get_match_scores_player1($source, $bracket_id, $tour_id, $draw_type)
		{
			
			$data = array('Match_Num'=>$source,'BracketID'=>$bracket_id,'Tourn_ID'=>$tour_id,'Draw_Type'=>$draw_type);
			$get_sp_name = $this->db->get_where('Tournament_Matches',$data);
			return $get_sp_name->row_array();
		}

		public function get_match_scores_player2($source, $bracket_id, $tour_id, $draw_type)
		{
			
			$data = array('Match_Num'=>$source,'BracketID'=>$bracket_id,'Tourn_ID'=>$tour_id,'Draw_Type'=>$draw_type);
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

		public function get_tourn_line_matches($data)
		{
			$bracket_id = $data['bracket_id'];

			$data = array('BracketID' => $bracket_id);
			$query = $this->db->get_where('Tournament_Lines',$data);

			return $query;
		}

		public function get_golf_tourn_matches($data)
		{
			$bracket_id = $data['bracket_id'];

			$data = array('BracketID' => $bracket_id);

  					 $this->db->order_by("Total", "ASC"); 
			$query = $this->db->get_where('Tournament_Matches_Golf',$data);

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

		public function golf_update_a2m($tourn_id, $bracket_id)
		{

			$data  = array('Tourn_ID' => $tourn_id, 'BracketID' => $bracket_id, 'Player >' => 0);

					 $this->db->order_by("Total", "ASC"); 
			$query = $this->db->get_where('Tournament_Matches_Golf', $data);
			$query_data = $query->result();
			
			$is_skip_update = 0;
			foreach($query_data as $res){
				$tot	= $res->Total;
				$player = $res->Player;

				$golf_scores[$player] = $tot;
				if(!$tot){
					$is_skip_update = 1;
				}
			}
			
			if(!$is_skip_update)
			{	
				$tot_players = count($golf_scores);
				$a2m_score   = ($tot_players * 20);

				$i = 0;
				foreach($golf_scores as $player => $tot){
					
					$player_a2mscore = $this->get_a2mscore($player, '4');
					
					if($tot_players != ++$i){
						//echo $player." - ".$tot." - ".$player_a2mscore." -".$a2m_score."<br>";
						$a2m_score = ceil($a2m_score / 2);
						//$player_new_a2m = $player_a2mscore + $a2m_score;
						$player_new_a2m = $a2m_score;

						$this->a2mscore_update($player, $player_new_a2m, '4');
					}
				}

			}

		}

		public function update_golf_match_score()
		{
			$cur_date			= date('Y-m-d');
			
			$tourn_id			= $this->input->post('tourn_id');
			$tourn_match_id		= $this->input->post('tourn_match_id');

			$data				= array('tournament_ID' => $tourn_id);
			$macth_init			= $this->db->get_where('tournament', $data);
			$match_init_user	= $macth_init->row_array();

			$player				= $this->input->post('player');
			$match_sport		= $match_init_user['SportsType'];

			$bracket_id			= $this->input->post('bracket_id');
			$match_num			= $this->input->post('match_num');
			$bracket_type		= $this->input->post('bracket_type');

			if($bracket_type == 'conventional'){
				
				$h1 = $this->input->post('h1');
				$h2 = $this->input->post('h2');
				$h3 = $this->input->post('h3');
				$h4 = $this->input->post('h4');
				$h5 = $this->input->post('h5');
				$h6 = $this->input->post('h6');
				$h7 = $this->input->post('h7');
				$h8 = $this->input->post('h8');
				$h9 = $this->input->post('h9');

				$total = "";

				if($h1 and $h2 and $h3 and $h4 and $h5 and $h6 and $h7 and $h8 and $h9){
					$total = $h1 + $h2 + $h3 + $h4 + $h5 + $h6 + $h7 + $h8 + $h9;
				}

				$data = array(
					'H1'		 => $h1, 
					'H2'		 => $h2, 
					'H3'		 => $h3,
					'H4'		 => $h4,
					'H5'		 => $h5,
					'H6'		 => $h6,
					'H7'		 => $h7,
					'H8'		 => $h8,
					'H9'		 => $h9,
					'Total'		 => $total,
					'Match_Date' => $cur_date
					);
			}
			else if($bracket_type == 'drive_chip_putt'){

				$drive = $this->input->post('drive');
				$chip  = $this->input->post('chip');
				$putt  = $this->input->post('putt');
				$total = "";

				if($drive and $chip and $putt){
					$total = $drive + $chip + $putt;
				}

				$data = array(
					'H1'		 => $drive, 
					'H2'		 => $chip, 
					'H3'		 => $putt,
					'Total'		 => $total,
					'Match_Date' => $cur_date
					);
			}

			$this->db->where('Tourn_match_id', $tourn_match_id);
			$this->db->update('Tournament_Matches_Golf', $data);

			if($total){ $this->golf_update_a2m($tourn_id, $bracket_id); }
		}

		public function update_rr_tourn_match_score()
		{
			//$tourn_id = $data['tourn_id']; 
			$tourn_id		= $this->input->post('tourn_id');
			$tourn_match_id = $this->input->post('tourn_match_id');

			//$draw_name = $this->input->post('draw_name');
			$round = $this->input->post('round_title');

			$data				= array('tournament_ID' => $tourn_id);
			$macth_init			= $this->db->get_where('tournament', $data);
			$match_init_user	= $macth_init->row_array();

			$player1_user		= $this->input->post('player1_user');
			$player1_partner	= $this->input->post('player1_user_partner');

			$opp_user			= $this->input->post('player2_user');
			$opp_user_partner	= $this->input->post('player2_user_partner');

			$match_sport		= $match_init_user['SportsType'];

			$bracket_id			= $this->input->post('bracket_id');
			$match_num			= $this->input->post('match_num');


		/* ------------------- A2MScore Calculation Section ---------------- */
		$player1_a2mscore	= $this->get_a2mscore($player1_user, $match_sport);
		$player2_a2mscore	= $this->get_a2mscore($opp_user, $match_sport);

		$player1_part_a2mscore	= "";
		$player2_part_a2mscore	= "";

			if($player1_partner or $opp_user_partner){			// If the Tournament is Double format
				$player1_part_a2mscore	= $this->get_a2mscore($player1_partner, $match_sport);
				$player2_part_a2mscore	= $this->get_a2mscore($opp_user_partner, $match_sport);
			}


		/*--------------- Sets score calculation start --------------*/
		$p1_score_post = $this->input->post('player1');
		$p2_score_post = $this->input->post('player2');

		$eval_player_scores = $this->calc_player_scores($p1_score_post, $p2_score_post);

			$player1_score		 = $eval_player_scores['Player1_Score'];
			$player2_score		 = $eval_player_scores['Player2_Score'];
			$player1_score_total = $eval_player_scores['Player1_Tot'];
			$player2_score_total = $eval_player_scores['Player2_Tot'];
			$tot_score			 = $eval_player_scores['Tot_Score'];
			$player1_sets_win	 = $eval_player_scores['Player1_Sets_Win'];
			$player2_sets_win	 = $eval_player_scores['Player2_Sets_Win'];

		/*-------------- Sets score calculation end ------------*/

		/* --------------- Evaluate Winner -------------- */
			$eval_winner	= $this->evaluate_winner($player1_user, $opp_user, $player1_partner, $opp_user_partner, $player1_sets_win, $player2_sets_win, $player1_score_total, $player2_score_total);

			$winner				= $eval_winner['Winner'];
			$winner_partner		= $eval_winner['Winner_Partner'];
			$looser				= $eval_winner['Looser'];
			$looser_partner		= $eval_winner['Looser_Partner'];

			$p1_points			= $eval_winner['P1_Points'];
			$p2_points			= $eval_winner['P2_Points'];
		/* --------------- Evaluate Winner -------------- */


		$win_per_p1 = ($player1_score_total / $tot_score) * 100;
		$win_per_p2 = ($player2_score_total / $tot_score) * 100;


		if($player1_partner or $opp_user_partner){			// For Doubles Format
		
			$eval_a2m_diff = $this->get_a2m_diff($player1_user, $opp_user, $player1_a2mscore, $player1_part_a2mscore, $player2_a2mscore, $player2_part_a2mscore, $winner);  // Get a2m score diff for doubles format

				$winner_a2m_diff		= $eval_a2m_diff['winner_a2m_diff'];
				$winner_part_a2m_diff	= $eval_a2m_diff['winner_part_a2m_diff'];


			$eval_max_a2m_players = $this->get_max_a2m_players($player1_user, $player1_partner, $opp_user, $opp_user_partner, $player1_a2mscore, $player1_part_a2mscore, $player2_a2mscore, $player2_part_a2mscore);  
			// Get Max A2M Players for both Players and their Partners for doubles format

				$max_a2m_player		= $eval_max_a2m_players['max_a2m_player'];
				$max_a2m_partner	= $eval_max_a2m_players['max_a2m_partner'];

		$winner_add_score_points		= $this->calc_addscore_points($winner_a2m_diff, $winner, $max_a2m_player);     
		$winner_part_add_score_points	= $this->calc_addscore_points($winner_part_a2m_diff, $winner_partner, $max_a2m_partner);     


		$get_win_points	= $this->calc_win_percent($player1_user, $opp_user, $win_per_p1, $win_per_p2, $max_a2m_player);

			$add_win_points_p1		= $get_win_points[0];
			$add_win_points_p2		= $get_win_points[1];
	
		$get_win_points_part = $this->calc_win_percent($player1_partner, $opp_user_partner, $win_per_p1, $win_per_p2, $max_a2m_partner);

			$add_win_points_part1	= $get_win_points_part[0];
			$add_win_points_part2	= $get_win_points_part[1];


			if($winner == $player1_user){
				$winner_win_points = $add_win_points_p1;
				$looser_win_points = $add_win_points_p2;

				$winner_part_win_points = $add_win_points_part1;
				$looser_part_win_points = $add_win_points_part2;
			}
			else{
				$winner_win_points = $add_win_points_p2;
				$looser_win_points = $add_win_points_p1;

				$winner_part_win_points = $add_win_points_part2;
				$looser_part_win_points = $add_win_points_part1;
			}

			$winner_a2mscore_updated		=   intval($winner_add_score_points) +  intval($winner_win_points);
			$winner_part_a2mscore_updated	=   intval($winner_part_add_score_points) +  intval($winner_part_win_points);

			$looser_a2mscore_updated		=  - intval($winner_add_score_points) +  intval($looser_win_points);
			$looser_part_a2mscore_updated	=  - intval($winner_part_add_score_points) +  intval($looser_part_win_points);


			// A2MScore Table Update 
			$this->a2mscore_update($winner, $winner_a2mscore_updated, $match_sport);
			$this->a2mscore_update($winner_partner, $winner_part_a2mscore_updated, $match_sport);

			$this->a2mscore_update($looser, $looser_a2mscore_updated, $match_sport);
			$this->a2mscore_update($looser_partner, $looser_part_a2mscore_updated, $match_sport);

		}
		else			// For Singles Format
		{
				$winner_a2m_diff	= abs($player1_a2mscore - $player2_a2mscore);
				($player1_a2mscore >= $player2_a2mscore) ? $max_a2m_player = $player1_user : $max_a2m_player = $opp_user;

				$winner_add_score_points = $this->calc_addscore_points($winner_a2m_diff, $winner, $max_a2m_player);  
				
				$get_win_points = $this->calc_win_percent($player1_user, $opp_user, $win_per_p1, $win_per_p2, $max_a2m_player);

				$add_win_points_p1 = $get_win_points[0];
				$add_win_points_p2 = $get_win_points[1];


			if($winner == $player1_user){
				$winner_win_points = $add_win_points_p1;
				$looser_win_points = $add_win_points_p2;
			}
			else{
				$winner_win_points = $add_win_points_p2;
				$looser_win_points = $add_win_points_p1;
			}

			$winner_a2mscore_updated	=   intval($winner_add_score_points) +  intval($winner_win_points);
			$looser_a2mscore_updated	=  - intval($winner_add_score_points) +  intval($looser_win_points);


			// A2MScore Table Update 
			$this->a2mscore_update($winner, $winner_a2mscore_updated, $match_sport);
			$this->a2mscore_update($looser, $looser_a2mscore_updated, $match_sport);
		}

		/* ------------------- A2MScore Calculation Section End ---------------- */


		/* ----------Player Number of Matches Update ---------------*/
		if($winner == $player1_user){ $won = 1; $lost = 0; }
		else{ $won = 0; $lost = 1; }


		$p1_num_upd			= $this->player_num_match_update($player1_user, $match_sport, $won, $lost, $win_per_p1);
		$p1_part_num_upd	= $this->player_num_match_update($player1_partner, $match_sport, $won, $lost, $win_per_p1);

		if($winner == $opp_user) { $won = 1; $lost = 0; }
		else{ $won = 0; $lost = 1; }

		$p2_num_upd			= $this->player_num_match_update($opp_user, $match_sport, $won, $lost, $win_per_p2);
		$p2_part_num_upd	= $this->player_num_match_update($opp_user_partner, $match_sport, $won, $lost, $win_per_p2);

		/* ----------End of Player Number of Matches Update ---------------*/

		/* --------------- Match Result Update ------------------------------------------- */

		$data = array(
				'Match_Date'	 => $played_date,
				'Player1_Score'  => $player1_score,
				'Player2_Score'  => $player2_score,
				'Player1_points' => $p1_points,
				'Player2_points' => $p2_points,
				'Winner'		 => $winner);

		$this->db->where('Tourn_match_id', $tourn_match_id);
		$result = $this->db->update('Tournament_Matches', $data); 

		/* ------------------------------------------------------------------------------- */


			$data = array('player1'=>$player1_user, 'player2'=>$opp_user, 'player1_partner'=>$player1_partner, 
				'player2_partner'=>$player2_partner, 'winner' => $winner, 'round_title' => $round,	'tourn_id'=>$tourn_id, 'player1_score'=>$player1_score, 'player2_score'=>$player2_score, 'type'=>'rr');

			return $data;

		}

//------------------------------------------------------------------------------------------------------


//-------------------------------------- Edit RR Match Score -------------------------------------------


		public function edit_rr_tourn_match_score()
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
/*	if($player1_score_total >= $player2_score_total){
		$winner = $player1_user;
	}
	else{
		$winner = $opp_user;
	}
*/

		/*--------------- Evaluate Winner --------------*/

		
			if($p1_sets_win > $p2_sets_win){
				$winner = $player1_user;
				$looser = $opp_user;
			}
			else if($p1_sets_win < $p2_sets_win){
				$winner = $opp_user;
				$looser = $player1_user;
			}
			else
			{
				if($player1_score_total > $player2_score_total)
				{
					$winner = $player1_user;
					$looser = $opp_user;
					$p1_points = 3;
					($p2_sets_win > 0) ? $p2_points = 1 : $p2_points = 0;
				}
				else
				{
					if($max_a2mscore_user == $player1_user)
					{
						$winner = $player1_user;
						$looser = $opp_user;

						$p1_points = 3;
						($p2_sets_win > 0) ? $p2_points = 1 : $p2_points = 0;
					}
					else
					{
						$winner = $opp_user;
						$looser = $player1_user;

						$p2_points = 3;
						($p1_sets_win > 0) ? $p1_points = 1 : $p1_points = 0;
					}
				}
			}
		/* -------------------- End of Evaluate Winner ------------------------- */


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


		/* Player Win or Loss count Update */


		/* End of Player Win or Loss count Update */
				

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


			$data = array('player1'=>$player1_user, 'player2'=>$opp_user, 'player1_partner'=>$player1_partner, 
				'player2_partner'=>$player2_partner, 'winner' => $winner, 'round_title' => $round_num,	'tourn_id'=>$tourn_id, 'player1_score'=>$player1_score, 'player2_score'=>$player2_score, 'type'=>'rr_update');

			return $data;


		}
//------------------------------------------------------------------------------------------------------


		public function get_a2mscore($user, $sport){

			$data			= array('SportsType_ID'=>$sport, 'Users_ID'=>$user);
			$qry_a2mscore	= $this->db->get_where('A2MScore',$data);
			$qry_fetch		= $qry_a2mscore->row_array();

			$user_a2mscore	= $qry_fetch['A2MScore'];

				return $user_a2mscore;
		}

		public function evaluate_winner($player1_user, $opp_user, $player1_partner, 
								$opp_user_partner,$player1_sets_win, $player2_sets_win, $player1_score_total, $player2_score_total){

		$p1_points = 0;
		$p2_points = 0;
		
			if($player1_sets_win > $player2_sets_win){
				$winner = $player1_user;
				$winner_partner = $player1_partner;

				$looser = $opp_user;
				$looser_partner = $opp_user_partner;

			$p1_points = 3;
			($player2_sets_win > 0) ? $p2_points = 1 : $p2_points = 0;

			}
			else if($player1_sets_win < $player2_sets_win){
				$winner = $opp_user;
				$winner_partner = $opp_user_partner;

				$looser = $player1_user;
				$looser_partner = $player1_partner;

			$p2_points = 3;
			($player1_sets_win > 0) ? $p1_points = 1 : $p1_points = 0;

			}
			else
			{
				if($player1_score_total > $player2_score_total)
				{
					$winner = $player1_user;
					$winner_partner = $player1_partner;

					$looser = $opp_user;
					$looser_partner = $opp_user_partner;

					$p1_points = 3;
					$p2_points = 1;
				}
				else
				{
					$winner = $opp_user;
					$winner_partner = $opp_user_partner;

					$looser = $player1_user;
					$looser_partner = $player1_partner;

					$p2_points = 3;
					$p1_points = 1;
				}
			}


		$data = array('Winner' => $winner, 
					'Winner_Partner' => $winner_partner, 
					'Looser' => $looser, 
					'Looser_Partner' => $looser_partner,
					'P1_Points' => $p1_points, 
					'P2_Points' => $p2_points);

		return $data;
		}


		public function get_a2m_diff($player1_user, $opp_user, $player1_a2mscore, $player1_part_a2mscore, 
			$player2_a2mscore, $player2_part_a2mscore, $winner){

			if($winner == $player1_user){

				if($player1_a2mscore > $player1_part_a2mscore){

					($player2_a2mscore > $player2_part_a2mscore) ? 
								$winner_a2m_diff	= abs($player1_a2mscore - $player2_a2mscore) :
								$winner_a2m_diff	= abs($player1_a2mscore - $player2_part_a2mscore);

					($player2_a2mscore > $player2_part_a2mscore) ? 
								$winner_part_a2m_diff = abs($player1_part_a2mscore - $player2_part_a2mscore) :
								$winner_part_a2m_diff = abs($player1_part_a2mscore - $player2_a2mscore);
				}
				else {

					($player2_a2mscore < $player2_part_a2mscore) ? 
								$winner_a2m_diff = abs($player1_a2mscore - $player2_a2mscore) :
								$winner_a2m_diff = abs($player1_a2mscore - $player2_part_a2mscore);

					($player2_a2mscore < $player2_part_a2mscore) ? 
								$winner_part_a2m_diff = abs($player1_part_a2mscore - $player2_part_a2mscore) :
								$winner_part_a2m_diff = abs($player1_part_a2mscore - $player2_a2mscore);
				}

			}

			else if($winner == $opp_user){

				if($player2_a2mscore > $player2_part_a2mscore){

					($player1_a2mscore > $player1_part_a2mscore) ? 
								$winner_a2m_diff	= abs($player2_a2mscore - $player1_a2mscore) :
								$winner_a2m_diff	= abs($player2_a2mscore - $player1_part_a2mscore);

					($player1_a2mscore > $player1_part_a2mscore) ? 
								$winner_part_a2m_diff = abs($player2_part_a2mscore - $player1_part_a2mscore) :
								$winner_part_a2m_diff = abs($player2_part_a2mscore - $player1_a2mscore);
				}
				else {

					($player1_a2mscore < $player1_part_a2mscore) ? 
								$winner_a2m_diff = abs($player2_a2mscore - $player1_a2mscore) :
								$winner_a2m_diff = abs($player2_a2mscore - $player1_part_a2mscore);

					($player1_a2mscore < $player1_part_a2mscore) ? 
								$winner_part_a2m_diff = abs($player2_part_a2mscore - $player1_part_a2mscore) :
								$winner_part_a2m_diff = abs($player2_part_a2mscore - $player1_a2mscore);
				}
			}


		$data = array('winner_a2m_diff'		 => $winner_a2m_diff, 
					  'winner_part_a2m_diff' => $winner_part_a2m_diff);

		return $data;
		}

		public function get_max_a2m_players($player1_user, $player1_partner, $opp_user, $opp_user_partner, $player1_a2mscore, $player1_part_a2mscore, $player2_a2mscore, $player2_part_a2mscore){


		if($player1_a2mscore > $player1_part_a2mscore){
			$max_a2m_p1			= $player1_user;
			$max_a2m_p1_score	= $player1_a2mscore;

			$min_a2m_p1			= $player1_partner;
			$min_a2m_p1_score	= $player1_part_a2mscore;
		}
		else{
			$max_a2m_p1			= $player1_partner;
			$max_a2m_p1_score	= $player1_part_a2mscore;

			$min_a2m_p1			= $player1_user;
			$min_a2m_p1_score	= $player1_a2mscore;
		}


		if($player2_a2mscore > $player2_part_a2mscore){
			$max_a2m_p2			= $opp_user;
			$max_a2m_p2_score	= $player2_a2mscore;

			$min_a2m_p2			= $opp_user_partner;
			$min_a2m_p2_score	= $player2_part_a2mscore;
		}
		else{
			$max_a2m_p2			= $opp_user_partner;
			$max_a2m_p2_score	= $player2_part_a2mscore;

			$min_a2m_p2			= $opp_user;
			$min_a2m_p2_score	= $player2_a2mscore;
		}


		($max_a2m_p1_score > $max_a2m_p2_score) ?
			$max_a2m_player = $max_a2m_p1 : $max_a2m_player = $max_a2m_p2;


		($min_a2m_p1_score > $min_a2m_p2_score) ?
			$max_a2m_partner = $min_a2m_p1 : $max_a2m_partner = $min_a2m_p2;


		$data = array('max_a2m_player'	=> $max_a2m_player, 
					  'max_a2m_partner' => $max_a2m_partner);

		return $data;
		}


		public function calc_player_scores($p1_score_post, $p2_score_post){

			$i=0;
			$player1_score = "[";
			$player1_score_total = 0;

			$player1_sets_win = 0;
			$player2_sets_win = 0;

			foreach($p1_score_post as $s1 => $set_score){
				if($p1_score_post[$s1] != "")
				{
					if ($i != 0)
					{
						$player1_score .= ",";
					}
					if($p1_score_post[$s1] > $p2_score_post[$s1]){

						$player1_sets_win++;
					}
					if($p1_score_post[$s1] < $p2_score_post[$s1]){
		
						$player2_sets_win++;
					}

					$player1_score .= "$p1_score_post[$s1]";
					$player1_score_total += intval($p1_score_post[$s1]);
					++$i;		
				}
			}

			$player1_score .= "]";
		

			$j=0;
			$player2_score = "[";
			$player2_score_total = 0;
			foreach($p2_score_post as $s2 => $set_score){
				if($set_score!="")
				{
					if ($j != 0)
					{
						$player2_score .= ",";
					}
					$player2_score .= "$set_score";
					$player2_score_total += intval($set_score);
					++$j;
				}
			}
			$player2_score .= "]";

			$tot_score = $player1_score_total + $player2_score_total;

		$data = array('Player1_Score'	=> $player1_score,
					'Player2_Score'		=> $player2_score, 
					'Player1_Tot'		=> $player1_score_total, 
					'Player2_Tot'		=> $player2_score_total, 
					'Tot_Score'			=> $tot_score,
					'Player1_Sets_Win'	=> $player1_sets_win,
					'Player2_Sets_Win'	=> $player2_sets_win);

		return $data;

		}

		public function update_source_matches_main($bracket_id, $match_num, $draw_name, $winner, $winner_partner, $qry_string){

			$qry_check_p1 = $this->db->query("SELECT * FROM Tournament_Matches WHERE Player1_source = $match_num AND BracketID = $bracket_id AND Draw_Type = '$draw_name'$qry_string");

				if($qry_check_p1->num_rows() > 0){
						$xx = $qry_check_p1->row_array();
						$tid = $xx['Tourn_match_id'];

						if($xx['Player2'] == -1)
						{
							$qry_upd_p2 = $this->db->query("UPDATE Tournament_Matches SET Player1_Score = 'Bye Match', Player2_Score = 'Bye Match', Player1 = $winner, Player1_Partner = $winner_partner WHERE Tourn_match_id = $tid");

							$mid = $xx['Match_Num'];

								$qry_check_p1 = $this->db->query("SELECT * FROM Tournament_Matches WHERE (Player1_source = $mid OR Player2_source = $mid) AND BracketID = $bracket_id AND Draw_Type = '$draw_name'$qry_string");

								if($qry_check_p1->num_rows() > 0){
								
								$yy = $qry_check_p1->row_array();
								
								$ttid = $yy['Tourn_match_id'];

									if($yy['Player1_source'] == $mid)
									{
										$qry_upd_p3 = $this->db->query("UPDATE Tournament_Matches SET Player1 = $winner, Player1_Partner = $winner_partner WHERE Tourn_match_id = $ttid");
									}
									else if($yy['Player2_source'] == $mid)
									{
										$qry_upd_p3 = $this->db->query("UPDATE Tournament_Matches SET Player2 = $winner, Player2_Partner = $winner_partner WHERE Tourn_match_id = $ttid");
									}
								}
						}
						else
						{
							$qry_upd_p2 = $this->db->query("UPDATE Tournament_Matches SET Player1 = $winner, Player1_Partner = $winner_partner WHERE Tourn_match_id = $tid");
						}
				}
				else{

						$qry_check_p2 = $this->db->query("SELECT * FROM Tournament_Matches WHERE Player2_source = $match_num AND BracketID = $bracket_id AND Draw_Type = '$draw_name'$qry_string");
					
						if($qry_check_p2->num_rows() > 0){
							$yy = $qry_check_p2->row_array();
							$tid = $yy['Tourn_match_id'];

						if($yy['Player1'] == -1)
						{
							$qry_upd_p2 = $this->db->query("UPDATE Tournament_Matches SET Player1_Score = 'Bye Match', Player2_Score = 'Bye Match', Player2 = $winner, Player2_Partner = $winner_partner WHERE Tourn_match_id = $tid");

							$mid = $yy['Match_Num'];

								$qry_check_p1 = $this->db->query("SELECT * FROM Tournament_Matches WHERE (Player1_source = $mid OR Player2_source = $mid) AND BracketID = $bracket_id AND Draw_Type = '$draw_name'$qry_string");

								if($qry_check_p1->num_rows() > 0){
								
								$yy = $qry_check_p1->row_array();
								
								$ttid = $yy['Tourn_match_id'];

									if($yy['Player1_source'] == $mid)
									{
										$qry_upd_p3 = $this->db->query("UPDATE Tournament_Matches SET Player1 = $winner, Player1_Partner = $winner_partner WHERE Tourn_match_id = $ttid");
									}
									else if($yy['Player2_source'] == $mid)
									{
										$qry_upd_p3 = $this->db->query("UPDATE Tournament_Matches SET Player2 = $winner, Player2_Partner = $winner_partner WHERE Tourn_match_id = $ttid");
									}
								}
						}
						else
						{
						$qry_upd_p2 = $this->db->query("UPDATE Tournament_Matches SET Player2 = $winner, Player2_Partner = $winner_partner WHERE Tourn_match_id = $tid");
						}
					}
				}
		}

		public function update_cons_sources($bracket_id, $match_num, $looser, $looser_partner){

				$qry_check_p1 = $this->db->query("SELECT * FROM Tournament_Matches WHERE Round_Num = 1 AND Player1_source = $match_num AND BracketID = $bracket_id AND Draw_Type = 'Consolation'");

						if($qry_check_p1->num_rows() > 0){
								$xx = $qry_check_p1->row_array();
								$tid = $xx['Tourn_match_id'];
								$qry_upd_p2 = $this->db->query("UPDATE Tournament_Matches SET Player1 = $looser, Player1_Partner = $looser_partner WHERE Tourn_match_id = $tid");

								$cd_player2_source = $xx['Player2_source'];
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
						else{
						$qry_check_p2 = $this->db->query("SELECT * FROM Tournament_Matches WHERE Round_Num = 1 AND Player2_source = $match_num AND BracketID = $bracket_id AND Draw_Type = 'Consolation'");

							if($qry_check_p2->num_rows() > 0){
								$yy = $qry_check_p2->row_array();
								$tid = $yy['Tourn_match_id'];
								$qry_upd_p2 = $this->db->query("UPDATE Tournament_Matches SET Player2 = $looser, Player2_Partner = $looser_partner WHERE Tourn_match_id = $tid");


// --- --- --- --- --- --- --- --- ---

								$cd_player1 = $yy['Player1'];
								$p2 = $yy['Player2'];
								
								if($cd_player1 == -1){
									$c_date = date('Y-m-d');
									$qry_upd_p2 = $this->db->query("UPDATE Tournament_Matches SET Player1_Score = 'Bye Match', Player2_Score = 'Bye Match', Winner = $p2, Match_Date = '$c_date' WHERE Tourn_match_id = $tid");

								$mid = $yy['Match_Num'];

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



//-----------------






							}
						}
						
		}


//**************************************

		public function cancel_esclating_looser_cons($bracket_id, $match_num, $looser, $looser_partner){

			echo "cancel_esclating_looser_cons_backup<br>";


				$qry_check_p1 = $this->db->query("SELECT * FROM Tournament_Matches WHERE Round_Num = 1 AND Player1_source = $match_num AND BracketID = $bracket_id AND Draw_Type = 'Consolation'");

						if($qry_check_p1->num_rows() > 0){

						echo "1st if<br>";
								$xx = $qry_check_p1->row_array();
								$tid = $xx['Tourn_match_id'];
								$qry_upd_p2 = $this->db->query("UPDATE Tournament_Matches SET Player1 = -1, Player1_Partner = -1 WHERE Tourn_match_id = $tid");  // new

								$cd_player2_source = $xx['Player2_source'];
								$cd_player2 = $xx['Player2'];
								$cd_player2_partner = $xx['Player2_Partner'];
								if($cd_player2_source == 0){

						echo "2nd if<br>";
									$c_date = date('Y-m-d');
									$qry_upd_p2 = $this->db->query("UPDATE Tournament_Matches SET Player1_Score = 'Canceled Match', Player2_Score = 'Canceled Match', Winner = 0, Match_Date = '$c_date' WHERE Tourn_match_id = $tid");

								$mid = $xx['Match_Num'];

								$cd_qry_check_p1 = $this->db->query("SELECT * FROM Tournament_Matches WHERE Round_Num != 1 AND Player1_source = $mid AND BracketID = $bracket_id AND Draw_Type = 'Consolation'");

									if($cd_qry_check_p1->num_rows() > 0)
									{
						echo "3rd if<br>";
										$xy = $cd_qry_check_p1->row_array();
										$ttid = $xy['Tourn_match_id'];
										
										if($xy['Player2_source'] != 0 and $xy['Player2'] != 0)  // Make the match as bye and escalate the user
										{
						echo "4th if<br>";
											$p2 = $xy['Player2'];
											$p2_part = $xy['Player2_Partner'];

											$cd_qry_upd_p2 = $this->db->query("UPDATE Tournament_Matches SET Player1 = 0, Player1_Partner = 0, Player1_Score = 'Bye Match', Player2_Score = 'Bye Match', Winner = $p2, Match_Date = '$c_date' WHERE Tourn_match_id = $ttid");

											$match_num = $xy['Match_Num'];

											/* escalate the winner to next round */
											
												$qry_check_p1 = $this->db->query("SELECT * FROM Tournament_Matches WHERE Round_Num = 3 AND Player1_source = $match_num AND BracketID = $bracket_id AND Draw_Type = 'Consolation'");

												if($qry_check_p1->num_rows() > 0){
													$xx = $qry_check_p1->row_array();
													$tid = $xx['Tourn_match_id'];
													$qry_upd_p2 = $this->db->query("UPDATE Tournament_Matches SET Player1 = $p2, Player1_Partner = $p2_part WHERE Tourn_match_id = $tid");
						echo "5th if<br>";
												}
												else{

													$qry_check_p2 = $this->db->query("SELECT * FROM Tournament_Matches WHERE Player2_source = $match_num AND BracketID = $bracket_id AND Draw_Type = '$draw_name'$qry_string");

													if($qry_check_p2->num_rows() > 0){
														$yy = $qry_check_p2->row_array();
														$tid = $yy['Tourn_match_id'];

														$qry_upd_p2 = $this->db->query("UPDATE Tournament_Matches SET Player2 = $p2, Player2_Partner = $p2_part WHERE Tourn_match_id = $tid");
													}
												}

											/* escalate the winner to next round */




										}
										else			// update the match
										{
						echo "4th if-else<br>";
											$cd_qry_upd_p2 = $this->db->query("UPDATE Tournament_Matches SET Player1 = -1, Player1_Partner = -1 WHERE Tourn_match_id = $ttid");
										}
									}
									else
									{
						echo "1st else<br>";
										$cd_qry_check_p2 = $this->db->query("SELECT * FROM Tournament_Matches WHERE Round_Num != 1 AND Player2_source = $mid AND BracketID = $bracket_id AND Draw_Type = 'Consolation'");

											if($cd_qry_check_p2->num_rows() > 0)
											{
						echo "2nd else if<br>";
												$xy = $cd_qry_check_p2->row_array();
												$ttid = $xy['Tourn_match_id'];
												
												if($xy['Player1_source'] != 0 and $xy['Player1'] != 0)  // Make the match as bye and escalate the user
												{
						echo "3rd else if<br>";
													$p1 = $xy['Player1'];
													$p1_part = $xy['Player1_Partner'];

													$cd_qry_upd_p2 = $this->db->query("UPDATE Tournament_Matches SET Player2 = 0, Player2_Partner = 0, Player1_Score = 'Bye Match', Player2_Score = 'Bye Match', Winner = $p1, Match_Date = '$c_date' WHERE Tourn_match_id = $ttid");

													$match_num = $xy['Match_Num'];

													/* escalate the winner to next round */
													
														$qry_check_p1 = $this->db->query("SELECT * FROM Tournament_Matches WHERE Round_Num = 3 AND Player1_source = $match_num AND BracketID = $bracket_id AND Draw_Type = 'Consolation'");

														if($qry_check_p1->num_rows() > 0){
						echo "4th else if<br>";
															$xx = $qry_check_p1->row_array();
															$tid = $xx['Tourn_match_id'];
															$qry_upd_p2 = $this->db->query("UPDATE Tournament_Matches SET Player1 = $p1, Player1_Partner = $p1_part WHERE Tourn_match_id = $tid");
														}
														else{


						echo "4th else if else<br>";
															$qry_check_p2 = $this->db->query("SELECT * FROM Tournament_Matches WHERE Player2_source = $match_num AND BracketID = $bracket_id AND Draw_Type = '$draw_name'$qry_string");

															if($qry_check_p2->num_rows() > 0){
																$yy = $qry_check_p2->row_array();
																$tid = $yy['Tourn_match_id'];

																$qry_upd_p2 = $this->db->query("UPDATE Tournament_Matches SET Player2 = $p1, Player2_Partner = $p1_part WHERE Tourn_match_id = $tid");
															}
														}

													/* escalate the winner to next round */


												}
												else			// update the match
												{
													$cd_qry_upd_p2 = $this->db->query("UPDATE Tournament_Matches SET Player1 = -1, Player1_Partner = -1 WHERE Tourn_match_id = $ttid");
												}
											}

									}
								}
								else if($cd_player2 != -1 OR $cd_player2 != 0){

									$mid = $xx['Match_Num'];


									$qry_check_p2 = $this->db->query("SELECT * FROM Tournament_Matches WHERE Round_Num != 1 AND (Player1_source = $mid OR Player2_source = $mid) AND BracketID = $bracket_id AND Draw_Type = 'Consolation'");

									if($qry_check_p2->num_rows() > 0){

											$zz = $qry_check_p2->row_array();
											$tid = $zz['Tourn_match_id'];

										if($zz['Player1_source'] == $mid)
										{
											$qry_upd_p2 = $this->db->query("UPDATE Tournament_Matches SET Player1 = $cd_player2, Player1_Partner = $cd_player2_partner WHERE Tourn_match_id = $tid");  // new

										} else if($zz['Player2_source'] == $mid)
										{
											$qry_upd_p2 = $this->db->query("UPDATE Tournament_Matches SET Player2 = $cd_player2, Player2_Partner = $cd_player2_partner WHERE Tourn_match_id = $tid");  // new
										}
								}
							}
						}
						else{			// Player2 Source
						$qry_check_p2 = $this->db->query("SELECT * FROM Tournament_Matches WHERE Round_Num = 1 AND Player2_source = $match_num AND BracketID = $bracket_id AND Draw_Type = 'Consolation'");
//*****************************************
						if($qry_check_p2->num_rows() > 0){
						echo "ELSE 1st if<br>";

								$xx = $qry_check_p2->row_array();
								$tid = $xx['Tourn_match_id'];
								$qry_upd_p2 = $this->db->query("UPDATE Tournament_Matches SET Player2 = -1, Player2_Partner = -1 WHERE Tourn_match_id = $tid");  // new

								$cd_player2_source = $xx['Player1_source'];
								$cd_player1 = $xx['Player1'];
								$cd_player1_partner = $xx['Player1_Partner'];

								if($cd_player2_source == 0){

						echo "ELSE 2nd if<br>";
									$c_date = date('Y-m-d');
									$qry_upd_p2 = $this->db->query("UPDATE Tournament_Matches SET Player1_Score = 'Canceled Match', Player2_Score = 'Canceled Match', Winner = 0, Match_Date = '$c_date' WHERE Tourn_match_id = $tid");

								$mid = $xx['Match_Num'];

								$cd_qry_check_p1 = $this->db->query("SELECT * FROM Tournament_Matches WHERE Round_Num != 1 AND Player1_source = $mid AND BracketID = $bracket_id AND Draw_Type = 'Consolation'");

									if($cd_qry_check_p1->num_rows() > 0)
									{

						echo "ELSE 3rd if<br>";
										$xy = $cd_qry_check_p1->row_array();
										$ttid = $xy['Tourn_match_id'];
										
										if($xy['Player2_source'] != 0 and $xy['Player2'] != 0)  // Make the match as bye and escalate the user
										{

						echo "ELSE 4th if<br>";
											$p2 = $xy['Player2'];
											$p2_part = $xy['Player2_Partner'];

											$cd_qry_upd_p2 = $this->db->query("UPDATE Tournament_Matches SET Player1 = 0, Player1_Partner = 0, Player1_Score = 'Bye Match', Player2_Score = 'Bye Match', Winner = $p2, Match_Date = '$c_date' WHERE Tourn_match_id = $ttid");

											$match_num = $xy['Match_Num'];

											/* escalate the winner to next round */
											
												$qry_check_p1 = $this->db->query("SELECT * FROM Tournament_Matches WHERE Round_Num = 3 AND Player1_source = $match_num AND BracketID = $bracket_id AND Draw_Type = 'Consolation'");

												if($qry_check_p1->num_rows() > 0){

						echo "ELSE 5th if<br>";
													$xx = $qry_check_p1->row_array();
													$tid = $xx['Tourn_match_id'];
													$qry_upd_p2 = $this->db->query("UPDATE Tournament_Matches SET Player1 = $p2, Player1_Partner = $p2_part WHERE Tourn_match_id = $tid");
												}
												else{
						echo "ELSE 6th if<br>";
													$qry_check_p2 = $this->db->query("SELECT * FROM Tournament_Matches WHERE Player2_source = $match_num AND BracketID = $bracket_id AND Draw_Type = '$draw_name'$qry_string");

													if($qry_check_p2->num_rows() > 0){

						echo "ELSE 7th if<br>";
														$yy = $qry_check_p2->row_array();
														$tid = $yy['Tourn_match_id'];

														$qry_upd_p2 = $this->db->query("UPDATE Tournament_Matches SET Player2 = $p2, Player2_Partner = $p2_part WHERE Tourn_match_id = $tid");
													}
												}

											/* escalate the winner to next round */




										}
										else			// update the match
										{

						echo "ELSE 8th if<br>";
											$cd_qry_upd_p2 = $this->db->query("UPDATE Tournament_Matches SET Player1 = -1, Player1_Partner = -1 WHERE Tourn_match_id = $ttid");
										}
									}
									else
									{

										$cd_qry_check_p2 = $this->db->query("SELECT * FROM Tournament_Matches WHERE Round_Num != 1 AND Player2_source = $mid AND BracketID = $bracket_id AND Draw_Type = 'Consolation'");

											if($cd_qry_check_p2->num_rows() > 0)
											{
												$xy = $cd_qry_check_p2->row_array();
												$ttid = $xy['Tourn_match_id'];
												
												if($xy['Player1_source'] != 0 and $xy['Player1'] != 0)  // Make the match as bye and escalate the user
												{
													$p1 = $xy['Player1'];
													$p1_part = $xy['Player1_Partner'];

													$cd_qry_upd_p2 = $this->db->query("UPDATE Tournament_Matches SET Player2 = 0, Player2_Partner = 0, Player1_Score = 'Bye Match', Player2_Score = 'Bye Match', Winner = $p1, Match_Date = '$c_date' WHERE Tourn_match_id = $ttid");

													$match_num = $xy['Match_Num'];

													/* escalate the winner to next round */
													
														$qry_check_p1 = $this->db->query("SELECT * FROM Tournament_Matches WHERE Round_Num = 3 AND Player1_source = $match_num AND BracketID = $bracket_id AND Draw_Type = 'Consolation'");

														if($qry_check_p1->num_rows() > 0){
															$xx = $qry_check_p1->row_array();
															$tid = $xx['Tourn_match_id'];
															$qry_upd_p2 = $this->db->query("UPDATE Tournament_Matches SET Player1 = $p1, Player1_Partner = $p1_part WHERE Tourn_match_id = $tid");
														}
														else{

															$qry_check_p2 = $this->db->query("SELECT * FROM Tournament_Matches WHERE Player2_source = $match_num AND BracketID = $bracket_id AND Draw_Type = '$draw_name'$qry_string");

															if($qry_check_p2->num_rows() > 0){
																$yy = $qry_check_p2->row_array();
																$tid = $yy['Tourn_match_id'];

																$qry_upd_p2 = $this->db->query("UPDATE Tournament_Matches SET Player2 = $p1, Player2_Partner = $p1_part WHERE Tourn_match_id = $tid");
															}
														}

													/* escalate the winner to next round */


												}
												else			// update the match
												{
													$cd_qry_upd_p2 = $this->db->query("UPDATE Tournament_Matches SET Player1 = -1, Player1_Partner = -1 WHERE Tourn_match_id = $ttid");
												}
											}

									}
								}

								//----
								else if($cd_player1 != -1 OR $cd_player1 != 0){

									$mid = $xx['Match_Num'];


									$qry_check_p2 = $this->db->query("SELECT * FROM Tournament_Matches WHERE Round_Num != 1 AND (Player1_source = $mid OR Player2_source = $mid) AND BracketID = $bracket_id AND Draw_Type = 'Consolation'");

									if($qry_check_p2->num_rows() > 0){

											$zz = $qry_check_p2->row_array();
											$tid = $zz['Tourn_match_id'];

										if($zz['Player1_source'] == $mid)
										{
											$qry_upd_p2 = $this->db->query("UPDATE Tournament_Matches SET Player1 = $cd_player1, Player1_Partner = $cd_player1_partner WHERE Tourn_match_id = $tid");  // new

										} else if($zz['Player2_source'] == $mid)
										{
											$qry_upd_p2 = $this->db->query("UPDATE Tournament_Matches SET Player2 = $cd_player1, Player2_Partner = $cd_player1_partner WHERE Tourn_match_id = $tid");  // new
										}
								}
							}

								//----
						}


//**********************************************************************************************
				}   // Player 2 source end

		}

//-------------------------------------- Add Score Functionality for Single & Consolation Draws ---------------------------------------

		public function update_tourn_match_score()
		{

			$rm = $this->req_method;
		

			/* Gather all post variables */
			$tourn_id			= $this->input->$rm('tourn_id');
			$tourn_match_id		= $this->input->$rm('tourn_match_id');
			$draw_name			= $this->input->$rm('draw_name');
			$round_title		= $this->input->$rm('round_title');
			$round_num			= $this->input->$rm('round_num');

			$player1_user		= $this->input->$rm('player1_user');
			$player1_partner	= $this->input->$rm('player1_user_partner');

			$opp_user			= $this->input->$rm('player2_user');
			$opp_user_partner	= $this->input->$rm('player2_user_partner');		
			
			$p1_score_post		= $this->input->$rm('player1');
			$p2_score_post		= $this->input->$rm('player2');

			$bracket_id			= $this->input->$rm('bracket_id');
			$match_num			= $this->input->$rm('match_num');
			/* Gather all post variables */


		/* ------------------- A2MScore Calculation Section ---------------- */
			//$tourn_id = $data['tourn_id']; 
			
			$qry_check		= $this->db->query("SELECT * FROM Tournament_Matches WHERE Tourn_match_id = $tourn_match_id ");
			$match_details	= $qry_check->row_array();

			$round_num		= $match_details['Round_Num'];

			if($draw_name == "") { $draw_name = 'Main'; }

			$data				= array('tournament_ID' => $tourn_id);
			$macth_init			= $this->db->get_where('tournament',$data);
			$match_init_user	= $macth_init->row_array();

			$match_sport		= $match_init_user['SportsType'];

			$player1_a2mscore	= $this->get_a2mscore($player1_user, $match_sport);
			$player2_a2mscore	= $this->get_a2mscore($opp_user, $match_sport);

			$player1_part_a2mscore	= "";
			$player2_part_a2mscore	= "";

			if($player1_partner or $opp_user_partner){			// If the Tournament is Double format
				$player1_part_a2mscore	= $this->get_a2mscore($player1_partner, $match_sport);
				$player2_part_a2mscore	= $this->get_a2mscore($opp_user_partner, $match_sport);
			}
			
		/*--------------- Sets score calculation start --------------*/
		$p1_score_post = $this->input->$rm('player1');
		$p2_score_post = $this->input->$rm('player2');

		$eval_player_scores = $this->calc_player_scores($p1_score_post, $p2_score_post);

			$player1_score		 = $eval_player_scores['Player1_Score'];
			$player2_score		 = $eval_player_scores['Player2_Score'];
			$player1_score_total = $eval_player_scores['Player1_Tot'];
			$player2_score_total = $eval_player_scores['Player2_Tot'];
			$tot_score			 = $eval_player_scores['Tot_Score'];

		/*-------------- Sets score calculation end ------------*/


		/* --------------- Evaluate Winner -------------- */
			$eval_winner	= $this->evaluate_winner($player1_user, $opp_user, $player1_partner, $opp_user_partner, $player1_sets_win, $player2_sets_win, $player1_score_total, $player2_score_total);

			$winner			= $eval_winner['Winner'];
			$winner_partner = $eval_winner['Winner_Partner'];
			$looser			= $eval_winner['Looser'];
			$looser_partner = $eval_winner['Looser_Partner'];

		/* --------------- Evaluate Winner -------------- */

		$win_per_p1 = ($player1_score_total / $tot_score) * 100;
		$win_per_p2 = ($player2_score_total / $tot_score) * 100;


		/* --------To allowing of adding an extra points based on player win percentile only for LOOSER  ------- */

		($winner == $player1_user) ? $win_per_p1 = -1 : $win_per_p2 = -1; 

		/* ----------------------------------------------------------------------------------------------------- */


		if($player1_partner or $opp_user_partner){					 // For Doubles Format
		
			$eval_a2m_diff				= $this->get_a2m_diff($player1_user, $opp_user, $player1_a2mscore, $player1_part_a2mscore, $player2_a2mscore, $player2_part_a2mscore, $winner);		// Get A2MScore diff for Doubles Format

				$winner_a2m_diff		= $eval_a2m_diff['winner_a2m_diff'];
				$winner_part_a2m_diff	= $eval_a2m_diff['winner_part_a2m_diff'];

			//echo "<pre>";
			//print_r($eval_a2m_diff);

			$eval_max_a2m_players	= $this->get_max_a2m_players($player1_user, $player1_partner, $opp_user, $opp_user_partner, $player1_a2mscore, $player1_part_a2mscore, $player2_a2mscore, $player2_part_a2mscore);  
			// Get Max A2M Players for both Players and their Partners for Doubles Format

			//echo "<pre>";
			//print_r($eval_max_a2m_players);

				$max_a2m_player		= $eval_max_a2m_players['max_a2m_player'];
				$max_a2m_partner	= $eval_max_a2m_players['max_a2m_partner'];



		$winner_add_score_points		= $this->calc_addscore_points($winner_a2m_diff, $winner, $max_a2m_player);     
		$winner_part_add_score_points	= $this->calc_addscore_points($winner_part_a2m_diff, $winner_partner, $max_a2m_partner); 
		

		$get_win_points	= $this->calc_win_percent($player1_user, $opp_user, $win_per_p1, $win_per_p2, $max_a2m_player);

			$add_win_points_p1 = $get_win_points[0];
			$add_win_points_p2 = $get_win_points[1];
	
		$get_win_points_part = $this->calc_win_percent($player1_partner, $opp_user_partner, $win_per_p1, $win_per_p2, $max_a2m_partner);

			$add_win_points_part1 = $get_win_points_part[0];
			$add_win_points_part2 = $get_win_points_part[1];


			if($winner == $player1_user){
				$winner_win_points = $add_win_points_p1;
				$looser_win_points = $add_win_points_p2;

				$winner_part_win_points = $add_win_points_part1;
				$looser_part_win_points = $add_win_points_part2;
			}
			else{
				$winner_win_points = $add_win_points_p2;
				$looser_win_points = $add_win_points_p1;

				$winner_part_win_points = $add_win_points_part2;
				$looser_part_win_points = $add_win_points_part1;
			}

			$winner_a2mscore_updated		=   intval($winner_add_score_points) +  intval($winner_win_points);
			$winner_part_a2mscore_updated	=   intval($winner_part_add_score_points) +  intval($winner_part_win_points);

			$looser_a2mscore_updated		=  - intval($winner_add_score_points) +  intval($looser_win_points);
			$looser_part_a2mscore_updated	=  - intval($winner_part_add_score_points) +  intval($looser_part_win_points);

//echo "<br>".$winner." - (+)".		  $winner_add_score_points." - ".	  $winner_win_points." - ".     $winner_a2mscore_updated;
//echo "<br>".$winner_partner." - (+)".$winner_part_add_score_points." - ".$winner_part_win_points." - ".$winner_part_a2mscore_updated;

//echo "<br>".$looser." - (-)".     $winner_add_score_points." - ".	  $looser_win_points." - ".		$looser_a2mscore_updated;
//echo "<br>".$looser_partner." - (-)".$winner_part_add_score_points." - ".$looser_part_win_points." - ".$looser_part_a2mscore_updated;

//exit;


			// A2MScore Table Update
			$this->a2mscore_update($winner, $winner_a2mscore_updated, $match_sport);
			$this->a2mscore_update($winner_partner, $winner_part_a2mscore_updated, $match_sport);

			$this->a2mscore_update($looser, $looser_a2mscore_updated, $match_sport);
			$this->a2mscore_update($looser_partner, $looser_part_a2mscore_updated, $match_sport);
//exit;

		}
		else			// For Singles Format
		{
				$winner_a2m_diff	= abs($player1_a2mscore - $player2_a2mscore);
				($player1_a2mscore >= $player2_a2mscore) ? $max_a2m_player = $player1_user : $max_a2m_player = $opp_user;

				$winner_add_score_points = $this->calc_addscore_points($winner_a2m_diff, $winner, $max_a2m_player);  
				
				$get_win_points = $this->calc_win_percent($player1_user, $opp_user, $win_per_p1, $win_per_p2, $max_a2m_player);

				$add_win_points_p1 = $get_win_points[0];
				$add_win_points_p2 = $get_win_points[1];

			if($winner == $player1_user){
				$winner_win_points = $add_win_points_p1;
				$looser_win_points = $add_win_points_p2;
			}
			else{
				$winner_win_points = $add_win_points_p2;
				$looser_win_points = $add_win_points_p1;
			}
//echo "<br>".$winner_win_points." - ".$looser_win_points;
//exit;

			$winner_a2mscore_updated =    intval($winner_add_score_points) + intval($winner_win_points);
			$looser_a2mscore_updated =  - intval($winner_add_score_points) + intval($looser_win_points);

			// A2MScore Table Update 
			$this->a2mscore_update($winner, $winner_a2mscore_updated, $match_sport);
			$this->a2mscore_update($looser, $looser_a2mscore_updated, $match_sport);
		}

		/* ------------------- A2MScore Calculation Section End ---------------- */


		$played_date = $this->input->$rm('tour_match_date');


			/* ----------Player Number of Matches Update ---------------*/
			if($winner == $player1_user){ $won = 1; $lost = 0; }
			else{ $won = 0; $lost = 1; }


			$p1_num_upd			= $this->player_num_match_update($player1_user, $match_sport, $won, $lost, $win_per_p1);
			$p1_part_num_upd	= $this->player_num_match_update($player1_partner, $match_sport, $won, $lost, $win_per_p1);

			if($winner == $opp_user) { $won = 1; $lost = 0; }
			else{ $won = 0; $lost = 1; }

			$p2_num_upd			= $this->player_num_match_update($opp_user, $match_sport, $won, $lost, $win_per_p2);
			$p2_part_num_upd	= $this->player_num_match_update($opp_user_partner, $match_sport, $won, $lost, $win_per_p2);
			
			
			/* --------------- Match Result Update ------------------------------------------- */

			$data = array(
					'Match_Date' => $played_date,
					'Player1_Score' => $player1_score,
					'Player2_Score' => $player2_score,
					'Winner' => $winner);

			$this->db->where('Tourn_match_id', $tourn_match_id);
			$result = $this->db->update('Tournament_Matches', $data); 

			/* ----------------------------------------------------------------------------------------------------------------- */


			/* ------- Update player1 and player2 sources --------- */

			$qry_string = "";

			if($draw_name == "Consolation"){
				$qry_string = " AND Round_Num != 1";
			}

			$this->update_source_matches_main($bracket_id, $match_num, $draw_name, $winner, $winner_partner, $qry_string);
		
			/* ------- Update player1 and player2 sources -------- */


			if($draw_name == "Main"){

				$tour_draw_type = 
					$this->db->query("SELECT Tournament_type FROM tournament WHERE tournament_ID = $tourn_id AND Tournament_type = 'Consolation'");

				if($tour_draw_type->num_rows() > 0 and ($round_num == 1 or $round_num == 2)){

					if($round_num == 1)
					{ $this->update_cons_sources($bracket_id, $match_num, $looser, $looser_partner); }
					else
					{
						$check_looser_played_count = 
						$this->db->query("SELECT * FROM Tournament_Matches WHERE 
							((Player1 = $looser AND Player2 = 0) OR 
							(Player2 = $looser AND Player1 = 0)) AND 
							Winner = $looser AND 
							BracketID = $bracket_id AND 
							Draw_Type = 'Main' AND 
							Round_Num = 1");

						if($check_looser_played_count->num_rows() > 0)		// Looser has Bye Match in Round 1
						{
							$this->update_cons_sources($bracket_id, $match_num, $looser, $looser_partner);
						}
						else
						{
							$this->cancel_esclating_looser_cons($bracket_id, $match_num, $looser, $looser_partner);
						}

					}
					}

			}


			$data = array('player1'=>$player1_user, 'player2'=>$opp_user, 'player1_partner'=>$player1_partner, 'player2_partner'=>$opp_user_partner, 'tourn_id'=>$tourn_id, 'winner' => $winner, 'player1_score'=>$player1_score, 'player2_score'=>$player2_score, 'type'=>'se', 'round_title'=>$round_title, 'draw_name'=>$draw_name);

			return $data;
		}


		public function update_wff_winner()				// --- Win by Forefiet --------------------------------------------------------------------
		{

			$tourn_id		= $this->input->post('tourn_id');
			$tourn_match_id = $this->input->post('tourn_match_id');
			$draw_name		= $this->input->post('draw_name');
				if($draw_name == "") { $draw_name = "Main"; }

			$round_title	= $this->input->post('round_title');
			
			$qry_check		= $this->db->query("SELECT * FROM Tournament_Matches WHERE Tourn_match_id = $tourn_match_id ");

			if($qry_check->num_rows() > 0)
			{
					$players = $qry_check->row_array();
					$round_num = $players['Round_Num'];

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



			/* ----------Player Number of Matches Update ---------------*/

			$data = array('tournament_ID'=>$tourn_id);
			$query = $this->db->get_where('tournament',$data);
			$get_match =  $query->row_array();

			$player1_user = $p1;
			$opp_user = $p2;
			$player1_partner = $p1_partner;
			$player2_partner = $p2_partner;

			$match_sport = $get_match['SportsType'];

			if($winner == $player1_user){ $won = 1; $lost = 0; }
			else{ $won = 0; $lost = 1; }
			$win_per_p1 = 0.00;

			$p1_num_upd = $this->player_num_match_update($player1_user, $match_sport, $won, $lost, $win_per_p1);
			$p1_part_num_upd = $this->player_num_match_update($player1_partner, $match_sport, $won, $lost, $win_per_p1);


			if($winner == $opp_user) { $won = 1; $lost = 0; }
			else{ $won = 0; $lost = 1; }
			$win_per_p2 = 0.00;

			$p2_num_upd = $this->player_num_match_update($opp_user, $match_sport, $won, $lost, $win_per_p2);
			$p2_part_num_upd = $this->player_num_match_update($player2_partner, $match_sport, $won, $lost, $win_per_p2);

			/* ---------------------------------------------------------- */


			/* --- update player1 and player2 sources ---- */
			$bracket_id = $this->input->post('bracket_id');
			$match_num = $this->input->post('match_num');


			$qry_string = "";

			if($draw_name == "Consolation"){
				$qry_string = " AND Round_Num != 1";
			}

			$this->update_source_matches_main($bracket_id, $match_num, $draw_name, $winner, $winner_partner, $qry_string);


			/* --- update player1 and player2 sources ---- */


/* --- Update Consolation Draw Sources ---- */

if($draw_name == "Main"){

				$tour_draw_type = 
					$this->db->query("SELECT Tournament_type FROM tournament WHERE tournament_ID = $tourn_id AND Tournament_type = 'Consolation'");

				if($tour_draw_type->num_rows() > 0 and ($round_num == 1 or $round_num == 2)){

					if($round_num == 1)
					{ $this->update_cons_sources($bracket_id, $match_num, $looser, $loser_partner); }
					else
					{
						$check_looser_played_count = 
						$this->db->query("SELECT * FROM Tournament_Matches WHERE 
							((Player1 = $looser AND Player2 = 0) OR 
							(Player2 = $looser AND Player1 = 0)) AND 
							Winner = $looser AND 
							BracketID = $bracket_id AND 
							Draw_Type = 'Main' AND 
							Round_Num = 1");

						if($check_looser_played_count->num_rows() > 0)		// Looser has Bye Match in Round 1
						{
							$this->update_cons_sources($bracket_id, $match_num, $looser, $loser_partner);
						}
						else
						{
							$this->cancel_esclating_looser_cons($bracket_id, $match_num, $looser, $loser_partner);
						}

					}
					}

			}

/* --- End of update Consolation Draw Sources ---- */

			$data = array('player1'=>$player1_user, 'player2'=>$opp_user, 'player1_partner'=>$player1_partner, 
				'player2_partner'=>$player2_partner, 'tourn_id'=>$tourn_id, 'winner'=>$winner, 'type'=>'wff', 'round_title'=>$round_title, 'draw_name'=>$draw_name);


			return $data;
		}


		//-------------------------------------- Edit / Update Score Functionality ---------------------------------------

		public function edit_tourn_match_score()
		{

		/* ------------------- A2MScore Calculation Section ---------------- */
			//$tourn_id = $data['tourn_id']; 
			$tourn_id = $this->input->post('tourn_id');
			$tourn_match_id = $this->input->post('tourn_match_id');
			
			$qry_check = $this->db->query("SELECT * FROM Tournament_Matches WHERE Tourn_match_id = $tourn_match_id ");
			$match_details = $qry_check->row_array();

			$round_num = $match_details['Round_Num'];

			$draw_name = $this->input->post('draw_name');
			if($draw_name == "") { $draw_name = 'Main'; }

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
		$p1_score_post = $this->input->post('player1');
		$p2_score_post = $this->input->post('player2');

		$i=0;
		$player1_score = "[";
		$player1_score_total = 0;

		$player1_sets_win = 0;
		$player2_sets_win = 0;

		foreach($p1_score_post as $s1 => $set_score){
			if($p1_score_post[$s1] != "")
			{
				if ($i != 0)
				{
					$player1_score .= ",";
				}
				if($p1_score_post[$s1] > $p2_score_post[$s1]){

					$player1_sets_win++;
				}
				if($p1_score_post[$s1] < $p2_score_post[$s1]){
	
					$player2_sets_win++;
				}

				$player1_score .= "$p1_score_post[$s1]";
				$player1_score_total += intval($p1_score_post[$s1]);
				++$i;		
			}
		}

		$player1_score .= "]";
	

		$j=0;
		$player2_score = "[";
		$player2_score_total = 0;
		foreach($p2_score_post as $s2 => $set_score){
			if($set_score!="")
			{
				if ($j != 0)
				{
					$player2_score .= ",";
				}
				$player2_score .= "$set_score";
				$player2_score_total += intval($set_score);
				++$j;
			}
		}
		$player2_score .= "]";

		$tot_score = $player1_score_total + $player2_score_total;

		/*--------------- Sets score calculation end --------------*/


		/*--------------- Evaluate Winner --------------*/

		
			if($player1_sets_win > $player2_sets_win){
				$winner = $player1_user;
				$winner_partner = $player1_partner;

				$looser = $opp_user;
				$looser_partner = $opp_user_partner;
			}
			else if($player1_sets_win < $player2_sets_win){
				$winner = $opp_user;
				$winner_partner = $opp_user_partner;

				$looser = $player1_user;
				$looser_partner = $player1_partner;
			}
			else
			{
				if($player1_score_total > $player2_score_total)
				{
					$winner = $player1_user;
					$winner_partner = $player1_partner;

					$looser = $opp_user;
					$looser_partner = $opp_user_partner;
				}
				else
				{
					$winner = $opp_user;
					$winner_partner = $opp_user_partner;

					$looser = $player1_user;
					$looser_partner = $player1_partner;
				}
			}
		/* -------------------- End of Evaluate Winner ------------------------- */


			$played_date = $this->input->post('tour_match_date');

			$data = array(
					'Match_Date' => $played_date,
					'Player1_Score' => $player1_score,
					'Player2_Score' => $player2_score,
					'Winner' => $winner);

			$this->db->where('Tourn_match_id', $tourn_match_id);
			$result = $this->db->update('Tournament_Matches', $data); 

			/* ---------------------------------------------------------- */


			/* ------- Update player1 and player2 sources --------- */

			$bracket_id = $this->input->post('bracket_id');
			$match_num = $this->input->post('match_num');

				if($draw_name != "Consolation"){
					$qry_check_p1 = $this->db->query("SELECT * FROM Tournament_Matches WHERE Player1_source = $match_num AND BracketID = $bracket_id AND Draw_Type = '$draw_name'");
				} else {
					$qry_check_p1 = $this->db->query("SELECT * FROM Tournament_Matches WHERE Player1_source = $match_num AND BracketID = $bracket_id AND Draw_Type = '$draw_name' AND Round_Num != 1");
				}

				if($qry_check_p1->num_rows() > 0){
						$xx = $qry_check_p1->row_array();
						$tid = $xx['Tourn_match_id'];
						$qry_upd_p2 = $this->db->query("UPDATE Tournament_Matches SET Player1 = $winner, Player1_Partner = $winner_partner WHERE Tourn_match_id = $tid");
				}
				else{

					if($draw_name != "Consolation"){
						$qry_check_p2 = $this->db->query("SELECT * FROM Tournament_Matches WHERE Player2_source = $match_num AND BracketID = $bracket_id AND Draw_Type = '$draw_name'");
					} else {
						$qry_check_p2 = $this->db->query("SELECT * FROM Tournament_Matches WHERE Player2_source = $match_num AND BracketID = $bracket_id AND Draw_Type = '$draw_name' AND Round_Num != 1");
					}

					if($qry_check_p2->num_rows() > 0){
						$yy = $qry_check_p2->row_array();
						$tid = $yy['Tourn_match_id'];

						$qry_upd_p2 = $this->db->query("UPDATE Tournament_Matches SET Player2 = $winner, Player2_Partner = $winner_partner WHERE Tourn_match_id = $tid");
					}
				}

			/* --------- Update player1 and player2 sources -------- */

			/* --------- Update Consolation Draw Sources --------- */

		if($draw_name != "Consolation"){

					$qry_check_draw_type = $this->db->query("SELECT Tournament_type FROM tournament WHERE tournament_ID = $tourn_id AND Tournament_type = 'Consolation'");

					if($qry_check_draw_type->num_rows() > 0){

						$qry_check_p1 = $this->db->query("SELECT * FROM Tournament_Matches WHERE Round_Num = 1 AND Player1_source = $match_num AND BracketID = $bracket_id AND Draw_Type = 'Consolation'");

						if($qry_check_p1->num_rows() > 0){
								$xx = $qry_check_p1->row_array();
								$tid = $xx['Tourn_match_id'];
								$qry_upd_p2 = $this->db->query("UPDATE Tournament_Matches SET Player1 = $looser, Player1_Partner = $looser_partner WHERE Tourn_match_id = $tid");

								$cd_player2_source = $xx['Player2_source'];
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
						else{
						$qry_check_p2 = $this->db->query("SELECT * FROM Tournament_Matches WHERE Round_Num = 1 AND Player2_source = $match_num AND BracketID = $bracket_id AND Draw_Type = 'Consolation'");

							if($qry_check_p2->num_rows() > 0){
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

		public function delete_team_brackets($bracket_id)
		{	
			$data = array('BracketID' => $bracket_id);
			
			$del_tm = $this->db->query("DELETE FROM Tournament_Lines WHERE BracketID = $bracket_id");
			$del_tm = $this->db->query("DELETE FROM Tournament_Matches WHERE BracketID = $bracket_id");
			$del_br = $this->db->query("DELETE FROM Brackets WHERE BracketID = $bracket_id");

			return $del_br;
		}

		public function calc_addscore_points($score_diff, $winner, $max_a2mscore_user)
		{
			
			// echo $score_diff." - ".$winner." - ".$max_a2mscore_user."<br>";

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

				return $add_score_points;
		}

		public function calc_win_percent($player1_user, $opp_user, $win_per_p1, $win_per_p2, $max_a2mscore_user){

					$win_per_p1 = round($win_per_p1);
					$win_per_p2 = round($win_per_p2);

		// echo "<br>".$player1_user." - ".$opp_user." - ".$win_per_p1." - ".$win_per_p2." - ".$max_a2mscore_user;

					
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

			return array('0'=>$add_win_points_p1, '1'=>$add_win_points_p2);		
		}

		public function a2mscore_update($user_id, $a2mscore, $sport){

			if($user_id){
				$data = array('Users_ID' => $user_id, 'SportsType_ID' => $sport);
				$qry_a2m = $this->db->get_where('A2MScore', $data);
				$get_a2m = $qry_a2m->row_array();

				$exist_a2m = $get_a2m['A2MScore'];

				$updated_a2m = $exist_a2m + $a2mscore;

					if($updated_a2m < 75){
						$updated_a2m = 75; 
					}

					// echo "<br>".$user_id." - ".$updated_a2m;

				$data = array ('A2MScore' => $updated_a2m);
				
				$this->db->where('Users_ID', $user_id);
				$this->db->where('SportsType_ID', $sport);

			$a2mscore_upd_qry1 = $this->db->update('A2MScore', $data);
			}

		}

		public function player_num_match_update($user_id, $sport, $won, $lost, $win_per){
		
			if($user_id){
				$data = array('Users_ID'=>$user_id,'Sport' =>$sport);
				$num = $this->db->get_where('Player_Matches_Count', $data);
				$c =  $num->row_array();

				if(empty($c))				//	Player 1
				{
					$data = array('Num_Matches' => 1, 'Users_ID' => $user_id,'Sport' => $sport,
					'Won' => $won, 'Lost' => $lost, 'Win_Per' => $win_per);

					$exe_query = $this->db->insert('Player_Matches_Count', $data);
				}
				else
				{
					$total = $c['Num_Matches'] + 1;

					$prev_wp = ($c['Win_Per'] * $c['Num_Matches']);

						$tot_won  = intval($c['Won']) + $won; 
						$tot_lost = intval($c['Lost']) + $lost;   

						$avg_win_per1 = number_format((($prev_wp + $win_per) / $total), 2); 

					$data = array('Num_Matches' => $total,'Won' => $tot_won, 'Lost' => $tot_lost, 'Win_Per' => $avg_win_per1);

					$this->db->where('Match_Count_ID', $c['Match_Count_ID']);
					$exe_query = $this->db->update('Player_Matches_Count', $data);
				}

			return $exe_query;
			}
		}

		public function check_edit_match($bracket_id, $match_num, $round, $draw_type, $tour_type){
			
			$qry_check = $this->db->query("SELECT * FROM Tournament_Matches WHERE (Player1_source = $match_num OR Player2_source = $match_num) AND BracketID = $bracket_id AND Draw_Type = '$draw_type' AND Winner != 0");

			if($tour_type == 'Consolation' and $round == 1){

				$qry_check2 = $this->db->query("SELECT * FROM Tournament_Matches WHERE (Player1_source = $match_num OR Player2_source = $match_num) AND BracketID = $bracket_id AND Round_Num = 1 AND Draw_Type = '$tour_type' AND Winner != 0");

				if($qry_check->num_rows() > 0 or $qry_check2->num_rows() > 0){
					$stat = 0;
				}
				else{
					$stat = 1;
				}
			}
			else{
					if($qry_check->num_rows() > 0){
						$stat = 0;
					}
					else{
						$stat = 1;
					}
			}
		return $stat;
		}

		public function cd_check_edit_match($bracket_id, $match_num, $round, $draw_type, $tour_type){
			
			$qry_check = $this->db->query("SELECT * FROM Tournament_Matches WHERE (Player1_source = $match_num OR Player2_source = $match_num) AND BracketID = $bracket_id AND Draw_Type = '$draw_type' AND Round_Num > 1 AND Winner != 0");
			
			if($qry_check->num_rows() > 0){
				$stat = 0;
			}
			else{
				$stat = 1;
			}

		return $stat;
		}


		public function insert_comment()
		{
			$user = $this->session->userdata('users_id');
			$match_id = $this->input->post('match_id');
			$comm = $this->input->post('com');
			$created = date('Y-m-d H:i:s');

			$data = array(
					'Tourn_Match_Id' => $match_id,
					'Users_Id' => $user,
					'Comments' => $comm,
					'Comment_On' => $created
				);

			$result = $this->db->insert('Tournament_Match_Comments', $data);
		    return  $result; 	
	    }

		public function get_match_comments($match_id){
			
			$data = array('Tourn_Match_Id' => $match_id);

			$this->db->select('*');
			$this->db->order_by("Comment_On",'desc');
			$get_ev_usrs = $this->db->get_where('Tournament_Match_Comments',$data);

			return $get_ev_usrs->result();
		}

		public function check_user_exists($tourn_id, $bid, $logged_user){

			$qry_check_p2 = $this->db->query("SELECT * FROM Tournament_Matches WHERE (Player1 = $logged_user OR Player2 = $logged_user 
			OR Player1_Partner = $logged_user OR Player2_Partner = $logged_user) AND BracketID = $bid AND Tourn_ID = $tourn_id");

			($qry_check_p2->num_rows() > 0) ? $stat = true : $stat = false;

			return $stat;
		}

		public function update_player_match_formats(){
			$tour_id	= $this->input->post('mf_tourn_id');
			$user_id	= $this->input->post('mf_user_id');
			$mf_selects = $this->input->post('mf_checks');
			
				$mf = json_encode($mf_selects);
				$qry_upd = $this->db->query("UPDATE RegisterTournament SET Match_Type = '".$mf."' WHERE Tournament_ID = '".$tour_id."' AND Users_ID = '".$user_id."'");

			return $mf;
		}

		public function update_player_levels(){

			$uid	 = $this->input->post('uid');
			$lvl	 = $this->input->post('lvl');
			$tour_id = $this->input->post('tid');

			if($uid != '' and $lvl != '')
			{
				$qry_upd = $this->db->query("UPDATE RegisterTournament SET Reg_Sport_Level = '".$lvl."' WHERE Tournament_ID = '".$tour_id."' AND Users_ID = '".$uid."'");
			}
		}

		public function tour_registered_teams($tid)		
		{		
			$qry_get = $this->db->query("SELECT * FROM Teams where Team_ID IN (SELECT Team_id FROM RegisterTournament WHERE Tournament_id = '$tid')");		
			return $qry_get->result();		
		}

		public function get_loggeduser_teams()		
		{		

			$this->db->where('Captain =', $this->logged_user);
			$this->db->or_where('Created_by =', $this->logged_user);
			
			$query = $this->db->get('Teams');

			return $query->result();	
		}

		public function get_reg_team_players($tourn_id, $team)
		{
			$qry_check = $this->db->query("SELECT * FROM RegisterTournament WHERE Tournament_ID = {$tourn_id} AND Team_id = {$team}");
			return $qry_check->row_array();
		}


		/* -------------------------------------- Team League Score Update Section ----------------------------------- */

		public function update_team_rr_tourn_score()			// RR Add Score 
		{

			//echo "<pre>";
			//print_r($_POST);
			//exit;

			$tourn_id		= $this->input->post('tourn_id');
			$tourn_match_id = $this->input->post('tourn_match_id');
			$match_line_id  = $this->input->post('match_line_id');

			//$draw_name = $this->input->post('draw_name');
			//$round = $this->input->post('round_title');

			$data				= array('tournament_ID' => $tourn_id);
			$get_qry			= $this->db->get_where('tournament', $data);
			$tour_det			= $get_qry->row_array();
			$match_sport		= $tour_det['SportsType'];

			$player1_user		= $this->input->post('player1_user');
			$player1_partner	= $this->input->post('player1_user_partner');

			$opp_user			= $this->input->post('player2_user');
			$opp_user_partner	= $this->input->post('player2_user_partner');


			$bracket_id			= $this->input->post('bracket_id');
			$match_num			= $this->input->post('match_num');
			$played_date		= date('Y-m-d', strtotime($this->input->post('line_match_date')));


		/* ------------------- A2MScore Calculation Section ---------------- */
		$player1_a2mscore	= $this->get_a2mscore($player1_user, $match_sport);
		$player2_a2mscore	= $this->get_a2mscore($opp_user, $match_sport);

		$player1_part_a2mscore	= "";
		$player2_part_a2mscore	= "";

			if($player1_partner or $opp_user_partner){			// If the Tournament is Double format
				$player1_part_a2mscore	= $this->get_a2mscore($player1_partner, $match_sport);
				$player2_part_a2mscore	= $this->get_a2mscore($opp_user_partner, $match_sport);
			}


		/*--------------- Sets score calculation start --------------*/
		$p1_score_post = $this->input->post('player1');
		$p2_score_post = $this->input->post('player2');

		$eval_player_scores = $this->calc_player_scores($p1_score_post, $p2_score_post);

			$player1_score		 = $eval_player_scores['Player1_Score'];
			$player2_score		 = $eval_player_scores['Player2_Score'];
			$player1_score_total = $eval_player_scores['Player1_Tot'];
			$player2_score_total = $eval_player_scores['Player2_Tot'];
			$tot_score			 = $eval_player_scores['Tot_Score'];
			$player1_sets_win	 = $eval_player_scores['Player1_Sets_Win'];
			$player2_sets_win	 = $eval_player_scores['Player2_Sets_Win'];

		/*--------------- Sets score calculation end ------------*/

		//print_r($eval_player_scores);

		/* --------------- Evaluate Winner -------------- */
			$eval_winner	= $this->evaluate_winner($player1_user, $opp_user, $player1_partner, $opp_user_partner, $player1_sets_win, $player2_sets_win, $player1_score_total, $player2_score_total);

			$winner				= $eval_winner['Winner'];
			$winner_partner		= $eval_winner['Winner_Partner'];
			$looser				= $eval_winner['Looser'];
			$looser_partner		= $eval_winner['Looser_Partner'];

			$p1_points			= $eval_winner['P1_Points'];
			$p2_points			= $eval_winner['P2_Points'];
		/* --------------- Evaluate Winner -------------- */

		//print_r($eval_winner);

		$win_per_p1 = ($player1_score_total / $tot_score) * 100;
		$win_per_p2 = ($player2_score_total / $tot_score) * 100;


		if($player1_partner or $opp_user_partner){			// For Doubles Format
		
			$eval_a2m_diff = $this->get_a2m_diff($player1_user, $opp_user, $player1_a2mscore, $player1_part_a2mscore, $player2_a2mscore, $player2_part_a2mscore, $winner);  // Get a2m score diff for doubles format

				$winner_a2m_diff		= $eval_a2m_diff['winner_a2m_diff'];
				$winner_part_a2m_diff	= $eval_a2m_diff['winner_part_a2m_diff'];


			$eval_max_a2m_players = $this->get_max_a2m_players($player1_user, $player1_partner, $opp_user, $opp_user_partner, $player1_a2mscore, $player1_part_a2mscore, $player2_a2mscore, $player2_part_a2mscore);  
			// Get Max A2M Players for both Players and their Partners for doubles format

				$max_a2m_player		= $eval_max_a2m_players['max_a2m_player'];
				$max_a2m_partner	= $eval_max_a2m_players['max_a2m_partner'];

		$winner_add_score_points		= $this->calc_addscore_points($winner_a2m_diff, $winner, $max_a2m_player);     
		$winner_part_add_score_points	= $this->calc_addscore_points($winner_part_a2m_diff, $winner_partner, $max_a2m_partner);     


		$get_win_points	= $this->calc_win_percent($player1_user, $opp_user, $win_per_p1, $win_per_p2, $max_a2m_player);

			$add_win_points_p1		= $get_win_points[0];
			$add_win_points_p2		= $get_win_points[1];
	
		$get_win_points_part = $this->calc_win_percent($player1_partner, $opp_user_partner, $win_per_p1, $win_per_p2, $max_a2m_partner);

			$add_win_points_part1	= $get_win_points_part[0];
			$add_win_points_part2	= $get_win_points_part[1];


			if($winner == $player1_user){
				$winner_win_points = $add_win_points_p1;
				$looser_win_points = $add_win_points_p2;

				$winner_part_win_points = $add_win_points_part1;
				$looser_part_win_points = $add_win_points_part2;
			}
			else{
				$winner_win_points = $add_win_points_p2;
				$looser_win_points = $add_win_points_p1;

				$winner_part_win_points = $add_win_points_part2;
				$looser_part_win_points = $add_win_points_part1;
			}

			$winner_a2mscore_updated		=   intval($winner_add_score_points) +  intval($winner_win_points);
			$winner_part_a2mscore_updated	=   intval($winner_part_add_score_points) +  intval($winner_part_win_points);

			$looser_a2mscore_updated		=  - intval($winner_add_score_points) +  intval($looser_win_points);
			$looser_part_a2mscore_updated	=  - intval($winner_part_add_score_points) +  intval($looser_part_win_points);


			// A2MScore Table Update 
			$this->a2mscore_update($winner, $winner_a2mscore_updated, $match_sport);
			$this->a2mscore_update($winner_partner, $winner_part_a2mscore_updated, $match_sport);

			$this->a2mscore_update($looser, $looser_a2mscore_updated, $match_sport);
			$this->a2mscore_update($looser_partner, $looser_part_a2mscore_updated, $match_sport);

		}
		else			// For Singles Format
		{
				$winner_a2m_diff	= abs($player1_a2mscore - $player2_a2mscore);
				($player1_a2mscore >= $player2_a2mscore) ? $max_a2m_player = $player1_user : $max_a2m_player = $opp_user;

				$winner_add_score_points = $this->calc_addscore_points($winner_a2m_diff, $winner, $max_a2m_player);  
				
				$get_win_points = $this->calc_win_percent($player1_user, $opp_user, $win_per_p1, $win_per_p2, $max_a2m_player);

				$add_win_points_p1 = $get_win_points[0];
				$add_win_points_p2 = $get_win_points[1];


			if($winner == $player1_user){
				$winner_win_points = $add_win_points_p1;
				$looser_win_points = $add_win_points_p2;
			}
			else{
				$winner_win_points = $add_win_points_p2;
				$looser_win_points = $add_win_points_p1;
			}

			$winner_a2mscore_updated	=   intval($winner_add_score_points) +  intval($winner_win_points);
			$looser_a2mscore_updated	=  - intval($winner_add_score_points) +  intval($looser_win_points);


			// A2MScore Table Update 
			$this->a2mscore_update($winner, $winner_a2mscore_updated, $match_sport);
			$this->a2mscore_update($looser, $looser_a2mscore_updated, $match_sport);
		}

		/* ------------------- A2MScore Calculation Section End ---------------- */


		/* ----------Player Number of Matches Update ---------------*/
		if($winner == $player1_user){ $won = 1; $lost = 0; }
		else{ $won = 0; $lost = 1; }

		$p1_num_upd			= $this->player_num_match_update($player1_user, $match_sport, $won, $lost, $win_per_p1);
		$p1_part_num_upd	= $this->player_num_match_update($player1_partner, $match_sport, $won, $lost, $win_per_p1);
//echo "<br>". $player1_user. " ".$match_sport. " ".$won. " ". $lost;
//echo "<br>". $player1_partner. " ".$match_sport. " ".$won. " ". $lost;

		if($winner == $opp_user) { $won = 1; $lost = 0; }
		else{ $won = 0; $lost = 1; }

		$p2_num_upd			= $this->player_num_match_update($opp_user, $match_sport, $won, $lost, $win_per_p2);
		$p2_part_num_upd	= $this->player_num_match_update($opp_user_partner, $match_sport, $won, $lost, $win_per_p2);

//echo "<br>". $opp_user. " ".$match_sport. " ".$won. " ". $lost;
//echo "<br>". $opp_user_partner. " ".$match_sport. " ".$won. " ". $lost;

//exit;

		/* ----------End of Player Number of Matches Update ---------------*/

		/* --------------- Line Match Result Update ------------------------------------------- */

		$data = array(
				'Match_Date'	 => $played_date,
				'Player1'		 => $player1_user,
				'Player1_Partner'=> $player1_partner,
				'Player2'		 => $opp_user,
				'Player2_Partner'=> $opp_user_partner,
				'Player1_Score'  => $player1_score,
				'Player2_Score'  => $player2_score,
				'Player1_points' => $p1_points,
				'Player2_points' => $p2_points,
				'Winner'		 => $winner);

		$this->db->where('Tourn_line_id', $match_line_id);
		$result = $this->db->update('Tournament_Lines', $data); 

		/* ------------------------------------------------------------------------------- */


		/* --------------- Match Result Update ------------------------------------------- */

		
/*		
		$data = array(
				//'Match_Date'	 => $played_date,
				//'Player1_Score'  => $player1_score,
				//'Player2_Score'  => $player2_score,
				'Player1_points' => $p1_points,
				'Player2_points' => $p2_points,
				'Winner'		 => $winner);

		$this->db->where('Tourn_match_id', $tourn_match_id);
		$result = $this->db->update('Tournament_Matches', $data);

*/
		/* ------------------------------------------------------------------------------- */

			$data = array('player1'=>$player1_user, 'player2'=>$opp_user, 'player1_partner'=>$player1_partner, 
				'player2_partner'=>$player2_partner, 'winner' => $winner, 'round_title' => $round,	'tourn_id'=>$tourn_id, 'player1_score'=>$player1_score, 'player2_score'=>$player2_score, 'type'=>'rr', 'format'=>'Teams');

			return $data;

		}

		public function update_team_wff()		// --- RR Win by Forefiet ---------------------------------
		{
			/*echo "<pre>";
			print_r($_POST);
			exit; */

			$tourn_id		= $this->input->post('tourn_id');
			$tourn_match_id = intval($this->input->post('tourn_match_id'));
			$line_id		= intval($this->input->post('match_line_id'));

			$draw_name		= $this->input->post('draw_name');
			//if($draw_name == "") { $draw_name = "Main"; }

			//$round_title	= $this->input->post('round_title');
			
			$p1			= $this->input->post('player1_user');
			$p1_partner = $this->input->post('player1_user_partner');

			$p2			= $this->input->post('player2_user');
			$p2_partner = $this->input->post('player2_user_partner');

			$winner		= $this->input->post('win_ff_player');

			if($winner == $p1)
			{
				$p1_points  = 3;
				$p2_points  = 0;
				$looser		= $p2;

				$winner_partner = $p1_partner;
				$loser_partner  = $p2_partner;
			}
			else
			{
				$p2_points  = 3;
				$p1_points  = 0;
				$looser		= $p1;

				$winner_partner = $p2_partner;
				$loser_partner  = $p1_partner;
			}

			$played_date	= date("Y-m-d");
			$player1_score  = "[0]";
			$player2_score  = "[0]";

			$data = array(
				'Match_Date'	 => $played_date,
				'Player1'		 => $p1,
				'Player2'		 => $p2,
				'Player1_Partner'=> $p1_partner,
				'Player2_Partner'=> $p2_partner,
				'Player1_Score'  => $player1_score,
				'Player2_Score'	 => $player2_score,
				'Player1_points' => $p1_points,
				'Player2_points' => $p2_points,
				'Winner'		 => $winner);

			$this->db->where('Tourn_line_id', $line_id);
			$result = $this->db->update('Tournament_Lines', $data); 


			/* ----------Player Number of Matches Update ---------------*/

			$data		= array('tournament_ID'=>$tourn_id);
			$query		= $this->db->get_where('tournament',$data);
			$get_match  =  $query->row_array();

			$player1_user	 = $p1;
			$opp_user		 = $p2;
			$player1_partner = $p1_partner;
			$player2_partner = $p2_partner;

			$match_sport = $get_match['SportsType'];

			if($winner == $player1_user){ $won = 1; $lost = 0; }
			else{ $won = 0; $lost = 1; }
			$win_per_p1 = 0.00;

			$p1_num_upd = $this->player_num_match_update($player1_user, $match_sport, $won, $lost, $win_per_p1);
			$p1_part_num_upd = $this->player_num_match_update($player1_partner, $match_sport, $won, $lost, $win_per_p1);


			if($winner == $opp_user) { $won = 1; $lost = 0; }
			else{ $won = 0; $lost = 1; }
			$win_per_p2 = 0.00;

			$p2_num_upd		 = $this->player_num_match_update($opp_user, $match_sport, $won, $lost, $win_per_p2);
			$p2_part_num_upd = $this->player_num_match_update($player2_partner, $match_sport, $won, $lost, $win_per_p2);

			/* ---------------------------------------------------------- */


			/* --- update player1 and player2 sources ---- */
			$bracket_id = $this->input->post('bracket_id');
			$match_num  = $this->input->post('match_num');


			$qry_string = "";

			if($draw_name == "Consolation"){
				$qry_string = " AND Round_Num != 1";
			}

			$this->update_source_matches_main($bracket_id, $match_num, $draw_name, $winner, $winner_partner, $qry_string);


			/* --- update player1 and player2 sources ---- */


			/* --- Update Consolation Draw Sources ---- */

			if($draw_name == "Main"){

				$tour_draw_type = 
					$this->db->query("SELECT Tournament_type FROM tournament WHERE tournament_ID = $tourn_id AND Tournament_type = 'Consolation'");

				if($tour_draw_type->num_rows() > 0 and ($round_num == 1 or $round_num == 2)){

					if($round_num == 1)
					{ $this->update_cons_sources($bracket_id, $match_num, $looser, $loser_partner); }
					else
					{
						$check_looser_played_count = 
						$this->db->query("SELECT * FROM Tournament_Matches WHERE 
							((Player1 = $looser AND Player2 = 0) OR 
							(Player2 = $looser AND Player1 = 0)) AND 
							Winner = $looser AND 
							BracketID = $bracket_id AND 
							Draw_Type = 'Main' AND 
							Round_Num = 1");

						if($check_looser_played_count->num_rows() > 0)		// Looser has Bye Match in Round 1
						{
							$this->update_cons_sources($bracket_id, $match_num, $looser, $loser_partner);
						}
						else
						{
							$this->cancel_esclating_looser_cons($bracket_id, $match_num, $looser, $loser_partner);
						}

					}
					}

			}

			/* --- End of update Consolation Draw Sources ---- */

			$data = array('player1'=>$player1_user, 'player2'=>$opp_user, 'player1_partner'=>$player1_partner, 
			'player2_partner'=>$player2_partner, 'tourn_id'=>$tourn_id, 'winner'=>$winner, 'type'=>'wff', 'round_title'=>$round_title, 'draw_name'=>$draw_name);


			return $data;
		}
/* ***************************************************************************** */
		public function getUserRatings($coach_id)
		{
			$user_id       = $this->logged_user;
			$data = array('Coach_ID' => $coach_id, 'User_ID' => $user_id);
			$get_ratings = $this->db->get_where('Coach_Ratings',$data);
			return $get_ratings->result();

		}
		public function getCoachRatings($coach_id)
		{
			$data = array('Coach_ID' => $coach_id);
			$get_ratings = $this->db->get_where('Coach_Ratings',$data);
			//echo $this->db->last_query();
			return $get_ratings->result();
			//return $get_ratings->result();

		}
	}