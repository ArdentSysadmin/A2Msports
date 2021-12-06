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

		public function get_sport_leagues($sport)
		{
			$current_date = date("Y-m-d h:i:s");		
			$this->db->select('*');
			$this->db->from('tournament');
			$this->db->order_by("StartDate", "DESC");
			//$this->db->where('EndDate >=', $current_date);
			$this->db->where('SportsType =', $sport);
			$query = $this->db->get();
			return $query->result();
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
		
		public function get_level_name($sport_id, $level){
			if($sport_id==''){
               $data = array('SportsLevel_ID' => (int)$level);
			}
			else{
			   $data = array('SportsType_ID' => $sport_id, 'SportsLevel_ID' => (int)$level);
			}
			
			$get_name = $this->db->get_where('SportsLevels',$data);
			return $get_name->row_array();
		}
		
		public function get_sport_levels($sport_id){
			
            $data = array('SportsType_ID'=> $sport_id);
			
			$query = $this->db->get_where('SportsLevels',$data);
			return $query->result();
		}

		public function get_reg_tournment($tourn_id){
			$user_id = $this->logged_user;
			$data = array('Tournament_ID'=>$tourn_id ,'Users_ID'=>$user_id);
			$query = $this->db->get_where('RegisterTournament',$data);
			//echo $this->db->last_query();
			//exit;
			return $query->row_array();
		}

		public function get_team_reg_tournment($tourn_id){		
			$user_id = $this->logged_user;		
				
			/*$qry_get = $this->db->query("SELECT * FROM Teams WHERE Players LIKE '%$user_id%' and Team_ID IN (SELECT Team_id FROM RegisterTournament WHERE Tournament_ID = $tourn_id)");*/		
			$qry_get = $this->db->query("SELECT * FROM RegisterTournament WHERE Team_Players LIKE '%$user_id%' AND Tournament_ID = {$tourn_id}");		
			return $qry_get->num_rows();		
		}

		public function check_is_paid($user, $tourn_id, $team){
			$qry_get = $this->db->query("SELECT * FROM Paytransactions WHERE Users_ID = '{$user}' AND mtype_ref = '{$tourn_id}' AND Team_id = '{$team}'"); // AND status = 'Completed'");
			return $qry_get->num_rows();
		}

		public function get_paytransactions($tourn_id, $user){
			$qry_get = $this->db->query("SELECT * FROM Paytransactions WHERE Users_ID = '{$user}' AND mtype_ref = '{$tourn_id}'"); // AND status = 'Completed'");
			return $qry_get->result();
		}

		public function get_reg_tourn_players($tourn_id, $sport='', $game_day=''){
			//$reg_status='WithDrawn';
			/*
			$qry_check = $this->db->query("SELECT distinct u.Users_ID, u.Firstname, u.Lastname, u.Mobilephone, u.Gender, u.City, u.State, u.UserAgegroup, r.Reg_date, r.Tournament_ID, r.TShirt_Size, a.A2MScore FROM Users u JOIN RegisterTournament r ON u.Users_ID = r.Users_ID JOIN A2MScore a ON a.Users_ID = r.Users_ID WHERE r.Tournament_ID = '{$tourn_id}'AND a.SportsType_ID='{$sport}' ORDER BY u.Firstname ASC; ");
			*/

			/*$qry_check = $this->db->query("SELECT u.Users_ID, u.Firstname, u.Lastname, u.Mobilephone, u.Gender, u.City, u.State, u.UserAgegroup, r.Reg_date, r.Tournament_ID, r.TShirt_Size, r.Reg_Events, a.A2MScore, r.is_checkin FROM Users u JOIN RegisterTournament r ON u.Users_ID = r.Users_ID JOIN A2MScore a ON a.Users_ID = r.Users_ID WHERE r.Tournament_ID = '{$tourn_id}' AND a.SportsType_ID='{$sport}' ORDER BY u.Firstname ASC");*/
			if($game_day){
			$qry_check = $this->db->query("SELECT u.Users_ID, u.Firstname, u.Lastname, u.Mobilephone, u.Gender, u.City, u.State, u.UserAgegroup, r.Reg_date, r.Tournament_ID, r.TShirt_Size, r.Reg_Events, r.is_checkin FROM Users u JOIN RegisterTournament r ON u.Users_ID = r.Users_ID WHERE r.Tournament_ID = '{$tourn_id}' AND RegisterTournament_id IN (SELECT Reg_ID FROM League_OCCR_Regs WHERE OCCR_ID = {$game_day}) ORDER BY u.Firstname ASC");
			}
			else{
			$qry_check = $this->db->query("SELECT u.Users_ID, u.Firstname, u.Lastname, u.Mobilephone, u.Gender, u.City, u.State, u.UserAgegroup, r.Reg_date, r.Tournament_ID, r.TShirt_Size, r.Reg_Events, r.is_checkin FROM Users u JOIN RegisterTournament r ON u.Users_ID = r.Users_ID WHERE r.Tournament_ID = '{$tourn_id}' ORDER BY u.Firstname ASC");
			}
			
			//echo $this->db->last_query();
			return $qry_check->result();
		}

		public function get_tourn_team_players($tourn_id){
			$qry_check = $this->db->query("SELECT * FROM RegisterTournament WHERE Tournament_ID = $tourn_id");
			return $qry_check->result();
		}

		public function get_teams_filter_level($level, $tourn_id){
			if($level != ""){
				$qry_check = $this->db->query("SELECT * FROM RegisterTournament WHERE Tournament_ID = {$tourn_id} AND Reg_Sport_Level = '{$level}'");
			}
			else{
				$qry_check = $this->db->query("SELECT * FROM RegisterTournament WHERE Tournament_ID = {$tourn_id}");
			}
			return $qry_check->result();
		}

		public function get_reg_tourn_player_names($tourn_id){
			$reg_status='WithDrawn';
			$qry_check = $this->db->query("SELECT * FROM RegisterTournament WHERE Tournament_ID = $tourn_id AND (Reg_Status != '$reg_status' OR Reg_Status IS NULL)");
			return $qry_check->result();
		}

		public function get_refund_trans($reg_tourn_id){
			$qry_check = $this->db->query("SELECT * FROM Refund_Transactions WHERE RegisterTournament_ID = $reg_tourn_id");
			return $qry_check->result();
		}

		public function get_reg_tourn_partner_names($tourn_id, $event){
		
			if($event){
				$qry_check = $this->db->query("SELECT U.Users_ID, U.Firstname, U.Lastname, U.Gender, RE.Reg_Events, RE.Partners from Users U JOIN RegisterTournament RE ON RE.Users_ID = U.Users_ID AND RE.Tournament_ID = '$tourn_id' AND Reg_Events LIKE '%$event%'");

				return $qry_check->result();
			}
			else{
				return false;
			}
		}

		public function is_player_reg_tourn($player, $tourn_id, $team)
		{
			$qry_check = $this->db->query("SELECT * FROM RegisterTournament WHERE Tournament_ID = {$tourn_id} AND Team_Players LIKE '%\"{$player}\"%'");
			return $qry_check->num_rows();
		}

		public function bulk_reg_teams()
		{
			$tourn_id	 = $this->input->post('id');
			$age_group	 = $this->input->post('age_group');
			$level		 = $this->input->post('level');

			$reg_date	 = date("Y-m-d h:i:s");
			$sel_teams = $this->input->post('sel_teams');
			$payment_method = $this->input->post('payment_method');
			$status		 = "Free Entry";
			if($payment_method != "Free Entry"){
               $status = 'Paid';
			}
           
            $paid_amnt  = 0.00;
			$paid_amnt  = $this->input->post('paid_amount');
			$paid_amnt  = number_format($paid_amnt, 2);
      
			foreach($sel_teams as $team){

				$check_already_reg = $this->db->query("SELECT * FROM RegisterTournament WHERE Team_ID = $team AND Tournament_ID = $tourn_id");



				if($check_already_reg->num_rows == 0){
					$get_team = $this->db->query("SELECT * FROM Teams WHERE Team_ID = '$team'");
					$team_res =	$get_team->row_array();

					$team_players = json_decode($team_res['Players']);

					foreach($team_players as $player){
						$check_player = $this->is_player_reg_tourn($player, $tourn_id, $team_id);
						if(!$check_player){
							$short_list_players[] = $player;
						}
					}

					$sh_players = json_encode($short_list_players);
					$data = array('Tournament_ID'	=> $tourn_id,
								  'Team_ID'			=> $team,
								  'Reg_date'		=> $reg_date,
								  'Reg_Sport_Level' => $level,
								  'Reg_Age_Group'	=> $age_group,
								  'Fee'				=> $paid_amnt,
								  'Transaction_id'	=> $payment_method,
								  'Team_Players'	=> $sh_players,
								  'Status'			=> $status,
								  );

					$bulk_reg = $this->db->insert('RegisterTournament' ,$data);		
				}
			}
			
			return $bulk_reg;
		}

		public function get_reg_tourn_participants($tourn_id, $sport = ''){
			$reg_status = "WithDrawn";
			if($sport != ''){
			$qry_check = $this->db->query("select rt.* from RegisterTournament as rt join A2MScore as a on rt.Users_ID = a.Users_ID where rt.Tournament_ID = {$tourn_id} and a.SportsType_ID = {$sport} and (rt.Reg_Status != '$reg_status' OR rt.Reg_Status IS NULL) order by a.A2MScore DESC");
			}
			else{	
			$qry_check = $this->db->query("SELECT * FROM RegisterTournament WHERE Tournament_ID = $tourn_id AND (Reg_Status != '$reg_status' OR Reg_Status IS NULL)");
			
			}
			return $qry_check->result();
		}

		public function get_reg_tourn_event_players($tourn_id, $types, $sport = '', $is_checkin = ''){
			$reg_status = "WithDrawn";
			$like_qry	= "";
			$checkin_qry= "";

			foreach($types as $i => $type){
				if($i != 0){ $like_qry .= " OR "; } 
				else{ $like_qry .= "("; }
				$like_qry .= "Reg_Events LIKE '%\"{$type}\"%'";
			}

			if($like_qry != ""){
				$like_qry .= ")";
			}

			if($is_checkin){
				$checkin_qry .= " AND is_checkin = {$is_checkin}";
			}
	
			$qry_check = $this->db->query("SELECT * FROM RegisterTournament WHERE Tournament_ID = $tourn_id AND (Reg_Status != '$reg_status' OR Reg_Status IS NULL) AND {$like_qry}{$checkin_qry}");
			//echo $this->db->last_query();
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
		public function get_tourn_title($tourn_id){
			$data  = array('tournament_ID'=>$tourn_id);
			$query = $this->db->get_where('tournament',$data);
			$res   = $query->row_array();
			return $res['tournament_title'];
		}

		public function tourn_title($tourn_id){
			$data = array('Tournament_ID'=>$tourn_id);
			$query = $this->db->get_where('RegisterTournament',$data);
			return $query->row_array();
		}

		public function get_line_data($line)
		{
			$data = array('Tourn_line_id' => $line);
			$query = $this->db->get_where('Tournament_Lines', $data);
			
			return $query->row_array();
		}

		public function get_tour_row_info($row_id){
			$data = array('Tourn_match_id'=>$row_id);
			$query = $this->db->get_where('Tournament_Matches',$data);
			
			return $query->row_array();
		}

		public function get_pp_merchant($mid){
			$data = array('pp_busi_id' => $mid);
			$query = $this->db->get_where('Paypal_Business_Accounts', $data);
			
			return $query->row_array();
		}

		public function get_paytm_merchant($mid){
			$data = array('paytm_busi_id' => $mid);
			$query = $this->db->get_where('Paytm_Business_Accounts', $data);
			
			return $query->row_array();
		}

		public function check_tourn($tourn_id){
			$data = array('tournament_ID'=>$tourn_id);
			$query = $this->db->get_where('tournament',$data);
			$points = $get_sp_name->row_array();

			if ($query->num_rows() > 0){
					
				$users_id = $this->logged_user;
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
			$users_id	= $this->logged_user;

			if(!$users_id){
				echo "Oops, Session timeout! Please login and try again. Thank you.";
				exit;
			}

			$lat_long	= $data['latt'];
					
			$pieces		= explode("@", $lat_long);
			$latitude	= $pieces[0];
			$longitude	= $pieces[1];

			//$data = $this->upload->data();
			//$filename = $data['file_name'];

			$title		 = $this->input->post('title');
			$short_code	 = $this->input->post('shrt_cde');
			$organizer	 = $this->input->post('organizer');
			$org_contact = $this->input->post('org_contact');

			//$sdate = $this->input->post('sdate');   substr("Hello world",3) lo world
			if($this->input->post('sdate')){
			 $sdate = date('Y-m-d', strtotime($this->input->post('sdate')));	
			}
			else{
			 $sdate = NULL;
			}

			if($this->input->post('stime')){
			 $stime = date('H:i:s', strtotime($this->input->post('stime')));	
			}
			else{
			 $stime = NULL;
			}
			
			if($this->input->post('edate')){
			 $edate = date('Y-m-d',strtotime($this->input->post('edate')));	
			}else{
			 $edate=NULL;
			}

			if($this->input->post('etime')){
			 $etime = date('H:i:s',strtotime($this->input->post('etime')));	
			}else{
			 $etime=NULL;
			}
			$sdate = $sdate.' '.$stime;
			$edate = $edate.' '.$etime;


			if($this->input->post('reg_openson')){
			 $reg_openson = date('Y-m-d',strtotime($this->input->post('reg_openson')));	
			}
			else{
			 $reg_openson = NULL;
			}

			if($this->input->post('regopentime')){
			 $reg_stime = date('H:i:s', strtotime($this->input->post('regopentime')));	
			}
			else{
			 $reg_stime = NULL;
			}

		
			if($this->input->post('reg_closedon')){
			 $reg_closedon = date('Y-m-d',strtotime($this->input->post('reg_closedon')));	
			}
			else{
			 $reg_closedon = NULL;
			}


			if($this->input->post('regclosetime')){
			 $reg_etime = date('H:i:s', strtotime($this->input->post('regclosetime')));	
			}
			else{
			 $reg_etime = NULL;
			}

			$reg_openson  = $reg_openson.' '.$reg_stime;
			$reg_closedon = $reg_closedon.' '.$reg_etime;

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
			
			$city	 = $this->input->post('city');
			$zipcode = $this->input->post('zipcode');
			$desc	 = htmlentities($this->input->post('desc'));
			$fee	 = $this->input->post('fee');
			$amt	 = $this->input->post('amt_one');
			
			$review	 = $this->input->post('recommend');
			$age	 = json_encode($_POST['age']);
			$singles = json_encode($_POST['singles']);
			$gender_type = json_encode($_POST['gender_type']);

			$sport_type		= $this->input->post('sport_type');
			$sport_levels	= json_encode($_POST['level']);
			$tourn_type		= $this->input->post('tourn_type');

			$star_level			= $this->input->post('star_level');
			$is_usatt_approved  = $this->input->post('USATTInfo');

			$extra_amt		= $this->input->post('amt_two');
			$access_group	= $this->input->post('org_id');
			$visibility		= $this->input->post('visible');

			$ch_positions = 0;
			if($this->input->post('ch_ladder_position'))
			$ch_positions	= $this->input->post('ch_ladder_position');
			
			$ch_duration = 0;
			if($this->input->post('ch_duration'))
			$ch_duration	= $this->input->post('ch_duration');

			$keywords="";

			if($title){
               $keywords.=$title;
			}
			if($city){
               $keywords.=", in ".$city;
			}
			if($sport_type){
				$sport_det=$this->get_sport_title($sport_type);
               $keywords.=", ".$sport_det['Sportname'];
			}
			
			$is_academy = 1;

			if($visibility == 'public'){
				$access_group = "";
				$is_academy = 0;
			}
           
			$age_grp_list = $this->input->post('age_group');
			$mult_fee_collect = NULL;
			$addn_mult_fee_collect = NULL;
			$event_reg_fee = NULL;
            $is_event_reg_fee = 0;
            if($this->input->post('event_fee')==1){
                if($this->input->post('fees')){
				  $is_event_reg_fee = 1;
				  $event_reg_fee	= json_encode($this->input->post('fees'));
			    }
            }else{
            	if($this->input->post('fee')==1){
				    $is_mult_fee = 1;
				    $mult_fee_collect		= json_encode($this->input->post('fee_collect'));
				    $addn_mult_fee_collect	= NULL;
				    if($this->input->post('addn_fee_collect')){
				       $addn_mult_fee_collect	= json_encode($this->input->post('addn_fee_collect'));
				    }
			    }
            }
            $event_reg_limit = NULL;
			if($sport_type == 10){
				$tour_format = 'TeamSport';
			}
			else{
				$tour_format = $this->input->post('tour_format');
			}
			$lines = NULL;
			$fee_collect_type = 'Player';
			if($tour_format == "Teams")
			{
				$msgl = $this->input->post('mens_singles_lines');
				$wsgl = $this->input->post('womens_singles_lines');
				$mdbl = $this->input->post('mens_doubles_lines');
				$wdbl = $this->input->post('womens_doubles_lines'); 
				$mxd  = $this->input->post('mixed_lines');
				$osl  = $this->input->post('os_lines');
				$odl  = $this->input->post('od_lines');

				if($msgl or $wsgl or $mdbl or $wdbl or $mxd or $osl or $odl){
					$lines = '[{"MSingles":'.intval($msgl).'},{"WSingles":'.intval($wsgl).'},{"MDoubles":'.intval($mdbl).'},{"WDoubles":'.intval($wdbl).'},{"Mixed":'.intval($mxd).'},{"OSingles":'.intval($osl).'},{"ODoubles":'.intval($odl).'}]';
				}

			$fee_collect_type = $this->input->post('fee_collect_method');
			}
			else if($tour_format == "TeamSport"){
				$fee_collect_type = $this->input->post('fee_collect_method');
			}

			if($this->input->post('event')==1){
			   $event_reg_limit = json_encode($this->input->post('limit'));
			}	
            
			$TShirt		 = $this->input->post('T-Shirt');

			if($sport_type == 2){
				$EligibilityDate = date('Y-m-d',strtotime($this->input->post('eligibility_date')));	
			}else{
				$EligibilityDate = NULL;
			}
			
		
            if($this->input->post('refund_date')){
			 $RefundDate = date('Y-m-d',strtotime($this->input->post('refund_date')));	
			}else{
			 $RefundDate = NULL;
			}
            
			 if($this->input->post('event_time') == 1){

				$event_time	= $this->input->post('time');
                foreach ($event_time as $key => $value){
					if($value != '1969-12-31 07:00:00' and $value != ''){
                	$event_timear[$key] = date('Y-m-d h:i:s',strtotime($value));
					}
					else{
                	$event_timear[$key] = '';
					}
                }
                $multi_event_time = json_encode($event_timear);
               
			}else{
				$multi_event_time = NULL;
			}
			$multi_events = json_encode($this->input->post('mul_events'));
			//echo 'mult '.$multi_event_time;
			//exit;
	
		/* ***************Code To Insert Data Into 'Paypal_Business_Accounts' Starts Here. ******************** */
			$merchant_id = NULL;
			if($this->input->post('pp')){
				if($this->input->post('ppids') == ''){
					$merchant_id = $this->input->post('merchantid');
					$cur_code  = $this->input->post('currency_code');

					$data = array(
						'users_id'        => $this->logged_user,
						'paypal_merch_id' => $merchant_id,
						/*'secret_key'      => $secret_key,*/
						'currency_format'  => $cur_code,
						'status'          => 1
					);

					$this->db->insert('Paypal_Business_Accounts', $data);
					$merchant_id = $this->db->insert_id();
				}
				else{
					$merchant_id = $this->input->post('ppids');
				}

			}
		/* ***************Code To Insert Data Into 'Paypal_Business_Accounts' Ends Here. ******************** */
	
	/* ***************Code To Insert Data Into 'Paytm_Business_Accounts' Starts Here. ******************** */
			$payment_option = $this->input->post('pay_options');
			if($country == 'India' and $payment_option == 'paytm'){
				$paytm_merchant_id = NULL;
				if($this->input->post('petm')){
					if($this->input->post('ptmids') == ''){
						$paytm_merchant_id  = $this->input->post('merchantid');
						$paytm_merchant_key = $this->input->post('merchantKey');

						$data = array(
							'users_id'			=> $this->logged_user,
							'paytm_merch_id'	=> $paytm_merchant_id,
							'paytm_merchant_key'=> $paytm_merchant_key,
							'currency_format'	=> 'INR',
							'status'			=> 1
						);

						$this->db->insert('Paytm_Business_Accounts', $data);
						$paytm_merchant_id = $this->db->insert_id();
					}
					else{
						$paytm_merchant_id = $this->input->post('addptmids');
					}

				}
			}
/* ***************Code To Insert Data Into 'Paytm_Business_Accounts' Ends  Here. ******************** */

				$coupon_check_status = $this->input->post('cc');

				$data = array(
					'Usersid'			=> $users_id,
					'tournament_title'	=> $title,
					'OrganizerName'		=> $organizer,
					'ContactNumber'		=> $org_contact,
					//'TournamentImage'	=> $filename,
					'StartDate'			=> $sdate,
					'EndDate'			=> $edate,
					'Registrationsclosedon' => $reg_closedon,
					'Age'				=> $age,
					'Singleordouble'	=> $singles,
					'Gender'			=> $gender_type,
					'Maxplayertournment' => $max_players,
					'Venue'				=> $venue,
					'TournamentAddress' => $addr1,
					'TournamentCountry' => $country,
					'TournamentState'	=> $state,
					'TournamentCity'	=> $city,
					'TournamentDescription' => $desc,
					'Tournamentfee'		=> $fee,
					'TournamentAmount'	=> $amt,
					'extrafee'			=> $extra_amt,
					'SportsType'		=> $sport_type,
					'Sport_levels'		=> $sport_levels,
					'Tournament_type'	=> $tourn_type,
					'latitude'			=> $latitude,
					'longitude'			=> $longitude,
					'TournmentReview'	=> $review,
					'PostalCode'		=> $zipcode,
					'Access_Groups'		=> $access_group,
					'Visibility'		=> $visibility,
					'is_mult_fee'		=> $is_mult_fee,
					'mult_fee_collect'	=> $mult_fee_collect,
					'addn_mult_fee_collect'	=> $addn_mult_fee_collect,
					'tournament_format'	=> $tour_format,		
					'lines_per_match'	=> $lines,		
					'Fee_collect_type '	=> $fee_collect_type,
					'Short_Code'		=> $short_code,
					'Keywords'			=> $keywords,
					'Event_Reg_Limit'	=> $event_reg_limit,
					'TShirt' 			=> $TShirt,
					'RefundDate'		=> $RefundDate,
					'EligibilityDate'	=> $EligibilityDate,
					'is_event_fee'		=> $is_event_reg_fee,
					'Event_Reg_Fee'		=> $event_reg_fee,
					'Multi_Event_Time'	=> $multi_event_time,
					'Multi_Events'		=> $multi_events,
					'Registrations_Opens_on' => $reg_openson,
					'Merchant_Paypal'	=> $merchant_id,
					'Challenge_Positions'	=> $ch_positions,
					'Challenge_Duration'	=> $ch_duration,
					'Is_Coupon'				=> $coupon_check_status,
					'Star_Level'			=> $star_level,
					'Is_USATT_Approved'		=> $is_usatt_approved,
					'Merchant_Paytm'		=> $paytm_merchant_id
				);
			/*echo "<pre>";
			print_r($data);
			exit;*/

			$this->db->insert('tournament', $data);
		    $insert_id = $this->db->insert_id();


		/* ***************Code To Insert Data Into 'CouponCode Details' Starts Here. ******************** */
			if($this->input->post('cc')){
				$coupon_code		 = $this->input->post('coupon_code');
				$coupon_method		 = $this->input->post('coupon_method');
				$coupon_value		 = $this->input->post('coupon_value');
				$expiry_date		 = $this->input->post('expiry_date');

				foreach($coupon_code as $key => $value){

				if($expiry_date[$key] == ""){
					$exp_date[$key] = date('Y-m-d',strtotime($this->input->post('reg_closedon')));
				}

					$data = array(
						'Coupon_Code'	  => $coupon_code[$key],
						'Discount_Method' => $coupon_method[$key],
						'Coupon_Value'    => $coupon_value[$key],
						'Expiry_Date'	  => $expiry_date[$key],
						'status'          => 1,
						'Ref_ID'		  => $insert_id
					);
				$this->db->insert('Coupon_Codes', $data);
				}

			}
		/* ***************Code To Insert Data Into 'CouponCode Details' Ends Here. ******************** */

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
			
			
			switch (true) {
                case $age <= 10:
                   $age_group = "U10";
                   break;
                case $age == 11:
                   $age_group = "U11";
                   break;
                case $age == 12:
                   $age_group = "U12";
                   break;
                case $age == 13:
                   $age_group = "U13";
                   break;
                case $age == 14:
                   $age_group = "U14";
                   break;
                case $age == 15:
                   $age_group = "U15";
                   break;
                case $age == 16:
	               $age_group = "U16";
	               break;
                case $age == 17:
                   $age_group = "U17";
                   break;
                case $age == 18:
                   $age_group = "U18";
                   break;
                case $age == 19:
                   $age_group = "U19";
                   break;
                default:
                   $age_group = "Adults";
                   break;
			}

			$data = array (
					'DOB'				=> date('Y-m-d', strtotime($dob)),
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
			$data = array_merge($data, $data1);
		}

		$data2 = array();

		if($this->input->post('txt_email')){
			$email	= $this->input->post('txt_email');
			$data2 = array('EmailID' => $email);
			$data	= array_merge($data, $data2);
		}

		if($this->input->post('txt_gender') and ($this->input->post('txt_gender') == '0' or $this->input->post('txt_gender') == '1')){
			$gender	= $this->input->post('txt_gender');
			$data3		= array('Gender' => $gender);
			$data		= array_merge($data, $data3);
		}

		if($this->input->post('txt_mob')){
			$mob	= $this->input->post('txt_mob');
			$data4 = array('Mobilephone' => $mob);
			$data	= array_merge($data, $data4);
		}


		//$data = array_merge($data, $data1, $data2, $data3);

		$this->db->where('Users_ID', $user);
		$res = $this->db->update('Users', $data); 
//echo $this->db->last_query(); exit;
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
				$geocodeFromAddr = file_get_contents('https://maps.googleapis.com/maps/api/geocode/json?address='.$formattedAddr.'&key='.GEO_LOC_KEY); 

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
			//echo "<pre>";print_r($_POST); exit();
			
			$lat_long	= $data['latt']; 
			$img		= $data['up_image'];
					
			$pieces		= explode("@", $lat_long);
			$latitude	= $pieces[0];
			$longitude	= $pieces[1];

			$tourn_id = $data['tourn_id'];
			$users_id = $this->logged_user;

			//$data = $this->upload->data();
			if($img['file_name'] != ""){
			   $filename = $img['file_name'];	
		    }else{
			   $filename = $this->input->post('Image');
		    }
			
			$title		 = $this->input->post('title');
			$organizer	 = $this->input->post('organizer');
			$organizer_id	 = $this->input->post('organizer_id');
			$org_contact = $this->input->post('org_contact');

			 $sdate = NULL;
			 $stime = NULL;
			 $edate = NULL;
			 $etime = NULL;

			if($this->input->post('sdate'))
			 $sdate = date('Y-m-d', strtotime($this->input->post('sdate')));	
			
			if($this->input->post('stime'))
			 $stime = date('H:i:s', strtotime($this->input->post('stime')));	
			
			if($this->input->post('edate'))
			 $edate = date('Y-m-d',strtotime($this->input->post('edate')));	

			if($this->input->post('etime'))
			 $etime = date('H:i:s',strtotime($this->input->post('etime')));	
			
			if($sdate)
			$sdate = $sdate.' '.$stime;

			if($edate)
			$edate = $edate.' '.$etime;

			$reg_openson  = NULL;
			$reg_closedon = NULL;
			$reg_open_time  = NULL;
			$reg_close_time = NULL;

			$refund_date  = NULL;
			$eligibility_date = NULL;

			if($this->input->post('reg_openson'))
				$reg_openson = date('Y-m-d', strtotime($this->input->post('reg_openson')));

			if($this->input->post('regopentime'))
			 $reg_open_time = date('H:i:s', strtotime($this->input->post('regopentime')));	

			if($this->input->post('reg_closedon'))
				$reg_closedon = date('Y-m-d', strtotime($this->input->post('reg_closedon')));	

			if($this->input->post('regclosetime'))
			 $reg_close_time = date('H:i:s', strtotime($this->input->post('regclosetime')));	

			if($reg_open_time)
			$reg_openson  = $reg_openson.' '.$reg_open_time;

			if($reg_close_time)
			$reg_closedon = $reg_closedon.' '.$reg_close_time;


		    if($this->input->post('refund_date'))
				$refund_date = date('Y-m-d h:i:s', strtotime($this->input->post('refund_date')));	

			if($this->input->post('eligibility_date'))
				$eligibility_date = date('Y-m-d h:i:s', strtotime($this->input->post('eligibility_date')));	

			$max_players = $this->input->post('max_players');
			$venue		 = $this->input->post('venue');
			$addr1		 = $this->input->post('addr1');
			$addr2		 = $this->input->post('addr2');
			
			$country = $this->input->post('country');
			if($country =='United States of America'){
				$state = $this->input->post('state');
			}
			else{
				$state = $this->input->post('state1');
			}
			
			$city		 = $this->input->post('city');
			$zipcode	 = $this->input->post('zipcode');
			$desc		 = htmlentities($this->input->post('desc'));
			$amt		 = $this->input->post('amt_one');
			$review		 = $this->input->post('recommend');
			$levels		 = json_encode($_POST['levels']);
			$age		 = json_encode($_POST['age']);
			$singles	 = json_encode($_POST['singles']);
			$gender_type = json_encode($this->input->post('gender_type'));
			$tourn_type	 = $this->input->post('tourn_type');
			$star_level  = $this->input->post('star_level');
			$is_usatt_sancationed = $this->input->post('USATTInfo');
			$extra_amt	 = $this->input->post('amt_two');
			$tshirt_info = $this->input->post('T-Shirt');
			$is_publish = $this->input->post('is_publish');
			
			$reg_users   = $this->get_reg_tourn_participants($tourn_id);

			$mult_fee_collect		= NULL;
			$addn_mult_fee_collect	= NULL;
			$event_reg_fee			= NULL;
            $event_reg_limit		= NULL;
            $multi_event_time		= NULL;
            $multi_events			= NULL;

	        $fee				= 0;
			$is_mult_fee		= 0;
			$is_event_reg_fee	= 0;

			if($this->input->post('fee')){
	            $fee = 1;
	            if($this->input->post('event_fee')){	// Event based Fee
					$is_event_reg_fee = 1;
					$event_fee_txt = $this->input->post('fees');
					$event_reg_fee = json_encode($event_fee_txt);
				}
				else{									// Age Group based fee
					$is_mult_fee		= 1;
					$mult_fee_collect	= json_encode($this->input->post('fee_collect'));

					if($this->input->post('addn_fee_collect')){
					$addn_mult_fee_collect	= json_encode($this->input->post('addn_fee_collect'));
					}
				}
			}

			if($this->input->post('event_time')){
				$event_time	= $this->input->post('time');
				$multi_event_time = json_encode($event_time);
		    }

            if($this->input->post('event')){
				$event_limit	 = $this->input->post('limit');
				$event_reg_limit = json_encode($event_limit);
		    }

            $tour_format = $this->input->post('tour_format');			
			$fee_collect_method = 'Player';

			if($tour_format == 'Teams' or $tour_format == 'TeamSport'){
				$fee_collect_method = $this->input->post('fee_collect_method');
			}

			$lines = NULL;
			if($tour_format == "Teams")
			{
				$msgl = $this->input->post('mens_singles_lines');
				$wsgl = $this->input->post('womens_singles_lines');
				$mdbl = $this->input->post('mens_doubles_lines');
				$wdbl = $this->input->post('womens_doubles_lines'); 
				$mxd  = $this->input->post('mixed_lines');
				$osl  = $this->input->post('open_single_lines');
				$odl  = $this->input->post('open_double_lines');

				if($msgl or $wsgl or $mdbl or $wdbl or $mxd or $osl or $odl){
					$lines = '[{"MSingles":'.intval($msgl).'},{"WSingles":'.intval($wsgl).'},{"MDoubles":'.intval($mdbl).'},{"WDoubles":'.intval($wdbl).'},{"Mixed":'.intval($mxd).'},{"OSingles":'.intval($osl).'},{"ODoubles":'.intval($odl).'}]';
				}
			}

			
			if($this->input->post('mul_events')){
			$m_events		= $this->input->post('mul_events');
			$multi_events	= json_encode($m_events);
			}

	/* ***************Code To Update Data Into 'CouponCode Details' Starts Here. ******************** */
			$coupon_check_status = NULL;

			if($this->input->post('cc')){
			$coupon_check_status = $this->input->post('cc');
					$this->db->where('Ref_ID', $tourn_id);
					$this->db->delete('Coupon_Codes');
				$coupon_code		 = $this->input->post('coupon_code');
				$coupon_method		 = $this->input->post('coupon_method');
				$coupon_value		 = $this->input->post('coupon_value');
				$expiry_date		 = $this->input->post('expiry_date');

				foreach($coupon_code as $key => $value){

					if($coupon_code[$key] != '' and $coupon_value[$key] != ''){
						if($expiry_date[$key] == ""){
						$exp_date[$key] = date('Y-m-d',strtotime($this->input->post('reg_closedon')));
						}

						$data = array(
							'Coupon_Code'	  => $coupon_code[$key],
							'Discount_Method' => $coupon_method[$key],
							'Coupon_Value'    => $coupon_value[$key],
							'Expiry_Date'	  => $expiry_date[$key],
							'status'          => 1,
							'Ref_ID'		  => $tourn_id
						);
						$this->db->insert('Coupon_Codes', $data);
					}
				}

			}
	/* ***************Code To Update Data Into 'CouponCode Details' Ends Here. ******************** */

			$data = array(
					/*'Usersid'			    => $users_id,*/
					'tournament_title'	    => $title,
					'OrganizerName'		    => $organizer,
					'Tournament_Director'	    => $organizer_id,
					'ContactNumber'		    => $org_contact,
					'TournamentImage'	    => $filename,
					'StartDate'			    => $sdate,
					'EndDate'			    => $edate,
					'Registrationsclosedon' => $reg_closedon,
					'Age'				    => $age,
					'Singleordouble'	    => $singles,
					'Gender'			    => $gender_type,
					'Maxplayertournment'    => $max_players,
					'Venue'				    => $venue,
					'TournamentAddress'     => $addr1,
					'TournamentCountry'     => $country,
					'TournamentState'	    => $state,
					'TournamentCity'	    => $city,
					'TournamentDescription' => $desc,
					'Tournamentfee'		    => $fee,
					'TournamentAmount'	    => $amt,
					'extrafee'			    => $extra_amt,
					'Tournament_type'	    => $tourn_type,
					'latitude'			    => $latitude,
					'longitude'			    => $longitude,
					'TournmentReview'	    => $review,
					'PostalCode'		    => $zipcode,
					'Sport_levels'          => $levels,
					'is_mult_fee'		    => $is_mult_fee,
					'mult_fee_collect'	    => $mult_fee_collect,
					'addn_mult_fee_collect'	=> $addn_mult_fee_collect,
					'lines_per_match'		=> $lines,		
					'Fee_collect_type'	    => $fee_collect_method,
					'RefundDate'            => $refund_date,
					'EligibilityDate'       => $eligibility_date,
					'TShirt'				=> $tshirt_info,
					'is_event_fee'          => $is_event_reg_fee,
					'Event_Reg_Fee'         => $event_reg_fee,
					'Multi_Event_Time'      => $multi_event_time,
					'Event_Reg_Limit'       => $event_reg_limit,
					'Multi_Events'			=> $multi_events,
					'Registrations_Opens_on' => $reg_openson,
					'Is_Coupon'				 => $coupon_check_status,
					'Star_Level'			 => $star_level,
					'Is_USATT_Approved'		 => $is_usatt_sancationed,
					'Is_Publish'		 => $is_publish
 				);
			//echo "<pre>";print_r($data);exit();
			$this->db->where('tournament_ID', $tourn_id);
			$result = $this->db->update('tournament', $data);

			
			$game_days = '';
			if($this->input->post('is_league') and $this->input->post('game_days')){
			$game_days = $this->input->post('game_days');
				foreach($game_days as $event => $gd){
					foreach($gd as $i => $game_day){
						if($game_day != ''){
						$gdate = date('Y-m-d H:i:s', strtotime($game_day)).".000";

						$check_gd = $this->db->query("SELECT * FROM League_OCCR WHERE Tourn_ID = {$tourn_id} AND Event = '{$event}' AND Game_Date = '{$gdate}'");
						//echo $this->db->last_query()."<br>";
						if($check_gd->num_rows == 0){
							//echo "Event {$event} ". $gdate."<br>";
							$data = array(
									'Tourn_ID'			 => $tourn_id,
									'Game_Date'	 => date('Y-m-d H:i:s', strtotime($game_day)),
									'Event'				 => $event
									);

						$this->db->insert('League_OCCR', $data);
						}
						}
					}
				}
			}


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
			$this->db->select('DOB');
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
			//$users_id = $this->logged_user;

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
		
	public function get_a2m($user_id, $tourn_id){
		$get_tour = $this->getonerow($tourn_id);
		$data = array('Users_ID'=>$user_id, 'SportsType_ID' =>$get_tour['SportsType'] );
		$query = $this->db->get_where('A2MScore', $data);
		return $query->row_array();
	}

		public function get_user_name($user_id){
			
			$data = array('Users_ID'=>$user_id);
			$get_sp_name = $this->db->get_where('users',$data);
			return $get_sp_name->row_array();
		}

		public function add_tourn_team_player_payment(){

			$players_teams = $this->input->post('sel_players');
			$tourn_id	= $this->input->post('tourn_id');
			$pay_method = $this->input->post('payment_method');
			$pay_amt	= $this->input->post('paid_amount');
			$pay_date   = date('Y-m-d h:i:s');

			foreach($players_teams as $val){
				$exp = explode('_', $val);
				$player = $exp[0];
				$team	= $exp[1];
				$data = array(
						'pay_date'	=> $pay_date,
						'Users_ID'	=> $player,
						'mtype'		=> 'tournament',
						'mtype_ref'	=> $tourn_id,	
						'Team_id'	=> $team,
						'Amount'	=> number_format($pay_amt, 2),
						'Transaction_id' => $pay_method,
						'Status'		 => 'Completed'
						);

				$result = $this->db->insert('PayTransactions', $data);
			}
							
			return true;
		}

		public function reg_team_tourn_no_fee($data)		
		{
			$tourn_id  = $this->input->post('id');
			$team_id   = $this->input->post('team');
			
			$json_levels = $data['json_levels'];
			$json_ag     = $data['json_ag'];

			$data = array('Team_id'=>$team_id, 'Tournament_ID'=>$tourn_id);

			$check_team_is_reg = $this->db->get_where('RegisterTournament', $data);
			$is_reg = $check_team_is_reg->num_rows();

			if(!$is_reg)
			{
				$fee	   = $this->input->post('tour_fee');	
				$age_group = $json_ag;	
				if($this->input->post('hc_loc_id')){
					$home_court_loc = $this->input->post('hc_loc_id');
				} else{
					$home_court_loc = NULL;
				}
				$level = $json_levels;	
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

		public function reg_tourn_no_fee($data)
		{
			$user_id  = $this->logged_user;
			$tourn_id = $this->input->post('id');
			
			$match_types = $data['json_formats'];
			$partners    = $data['json_partners'];
			$age_group   = $data['json_ag'];
			$school_info = $data['school_info'];
			$c_code		 = $data['coup_code'];
			$c_disc		 = $data['coup_disc'];

			$fee = $this->input->post('tour_fee');


			if($this->input->post('hc_loc_id')){
				$home_court_loc = $this->input->post('hc_loc_id');
			} else{
				$home_court_loc = NULL;
			}

			if($this->input->post('tshirt_size')){
				$tsize = $this->input->post('tshirt_size');
			}
			else{
				$tsize = NULL;
			}

			if($this->input->post('events')){
				$reg_events = json_encode($this->input->post('events'));
			}else{
				$reg_events = NULL;
			}

			$level = $data['json_levels'];

			//$level = json_encode($this->input->post('level'));

			$reg_date = date("Y-m-d h:i:s");

			$get_tourn_reg = $this->db->query("SELECT * FROM RegisterTournament WHERE Tournament_ID = {$tourn_id} AND Users_ID={$user_id}");
			$get_res = $get_tourn_reg->row_array();

			if(count($get_res) > 0){
			$last_id = $get_res['RegisterTournament_id'];
			}
			else{
			$data = array(
					'Users_ID'		=> $user_id,
					'Tournament_ID' => $tourn_id,
					'Match_Type'	=> $match_types,
					'Fee'			=> number_format($fee, 2),
					'Reg_Age_Group' => $age_group,
					'Reg_Sport_Level' => $level,
					'Reg_date'		=> $reg_date,
					'hcl_id'		=> $home_court_loc,
					'TShirt_Size'	=> $tsize,
					'Reg_Events'    => $reg_events,
					'Partners'		=> $partners,
					'Coupon_Applied'  => $c_code,
					'Discount_Amount' => $c_disc
					);

			//print_r($data);
			//exit;
			
			$result = $this->db->insert('RegisterTournament', $data);
			$last_id = $this->db->insert_id(); 
			}
			// A2MScore add if not exists for sport
			$tour_det		= $this->getonerow($tourn_id);

			if($tour_det->Is_League == 1){
				$post_occr = $this->input->post('occr_ids');
						if($post_occr){
							foreach($post_occr as $oc){
								$temp = explode(':', $oc);
								$occr_id = $temp[0];

								$data9 = array(
								'Users_ID'		=> $user_id,
								'Reg_ID'		=> $last_id,
								'OCCR_ID'	=> $occr_id,
								'Amount'			=> number_format($fee, 2),
								'OCCR_Reg_Date'		=> $reg_date,
								'Transaction_id' => $trans_id,
								'Status'		=> $status,
								'Currency_Code' => $currency_code
								);

								$result   = $this->db->insert('League_OCCR_Regs', $data9);
							}
						}
			}


			$tour_sport	= $tour_det->SportsType;
			
			$check_user_a2m = $this->get_a2mscore($user_id, $tour_sport);
			if($check_user_a2m->num_rows > 0){

			}
			else{
							$def_score = 100;
						if($tour_sport == '2')
							$def_score = 800;
						if($tour_sport == '7')
							$def_score = 3.0;


					$a2m_ins_data = array(
									'Users_ID'					=> $user_id,
									'SportsType_ID'			=> $tour_sport,
									'A2MScore'				=> $def_score,
									'A2MScore_Doubles' => $def_score,
									'A2MScore_Mixed'		=> $def_score
									);

					$result2 = $this->db->insert('A2MScore', $a2m_ins_data);
			}

			if($this->input->post('usatt_member_id')){
				$mem_id = $this->input->post('usatt_member_id');

				$data = array(
					'Club_id'		=> '139',
					'Users_id'		=> $this->logged_user,
					'Membership_ID'	=> $mem_id,
					'Member_Status'	=> '1',
					'Related_Sport'	=> '2'
					);

				$result2 = $this->db->insert('Academy_users', $data);
			}

			if($school_info != "" or $school_info != NULL){
				$this->db->query("UPDATE Users SET School_Info = '".$school_info."' WHERE Users_ID = '".$user_id."'");
			}

			/*$player_a2m = $this->db->query("SELECT * FROM A2MScore WHERE Users_ID = {$user_id} AND SportsType_ID = {$tour_sport}");

			if($player_a2m->num_rows() > 0){
				$player_a2m = $player_a2m->row_array();
				$init_a2m = max($player_a2m['A2MScore'], $player_a2m['A2MScore_Doubles'], $player_a2m['A2MScore_Mixed']);

				$query = $this->db->query("UPDATE RegisterTournament SET Current_A2M = {$init_a2m} WHERE RegisterTournament_ID = {$last_id}");
			}*/


			return $last_id;
		}

		public function reg_more_tourn_no_fee($data)
		{
			$user_id	 = $this->logged_user;
			$tourn_id	 = $this->input->post('id');
			
			$match_types = $data['json_formats'];
			$age_group	 = $data['json_ag'];
			$level		 = $data['json_levels'];

			$fee = $this->input->post('tour_fee');

			if($this->input->post('events')){
				$reg_events = json_encode($this->input->post('events'));
			}
			else{
				$reg_events = NULL;
			}
			//$partner1  = $this->input->post('created_users_id');
			//$partner2  = $this->input->post('created_users_id1');

			$cur_date = date("Y-m-d h:i:s");

			$data = array(
					'Match_Type'	  => $match_types,
					//'Partner1'	  => $partner1,
					//'Partner2'	  => $partner2,
					'Reg_Age_Group'   => $age_group,
					'Reg_Sport_Level' => $level,
					'Reg_Events'      => $reg_events
					);

			$data1 = array(
					 'Users_ID'		 => $user_id,
					 'Tournament_ID' => $tourn_id
					 );

					    $this->db->where($data1);	
			$result   = $this->db->update('RegisterTournament', $data);

            $last_rec = $this->db->get_where('RegisterTournament', $data1);
			$last_row = $last_rec->row_array();

			return $last_row['RegisterTournament_id'];
		}

		public function del_tour_reg_user($data){
			$this->db->where($data);
			$this->db->delete('RegisterTournament'); 
		}

		public function team_reg_tourn_with_fee($data){

			$user_id		= $data['player'];
			$tourn_id		= $data['tourn_id'];
			$team			= $data['team'];
			$team_captain	= $data['player'];
			$team_players	= $data['team_players'];
			$age_group		= $data['age_group'];
			$level			= $data['level'];
            $coup_code     = $data['coup_code'];
            $coup_disc     = $data['coup_disc'];

			if($data['hc_loc_id']){
				$home_court_loc = $data['hc_loc_id'];
			}
			else{
				$home_court_loc = NULL;
			}

			$fee			= $data['payment_amt'];
			$currency_code	= $data['currency_code'];
			$trans_id		= $data['txn_id'];
			$status			= $data['status'];

			$reg_date = date("Y-m-d h:i:s");

			$data = array(
					'Users_ID'		=> NULL,
					'Tournament_ID' => $tourn_id,
					'Fee'			=> number_format($fee, 2),
					'Reg_Age_Group' => $age_group,
					'Reg_Sport_Level' => $level,
					'Reg_date'		=> $reg_date,
					'Transaction_id'=> $trans_id,
					'Status'		=> $status,
					'Currency_Code' => $currency_code,
					'hcl_id'		=> $home_court_loc,
					'Team_id'		=> $team,
					'Team_Players'	=> $team_players,
					'Coupon_Applied'  => $coup_code,
					'Discount_Amount' => $coup_disc
					);

			$result = $this->db->insert('RegisterTournament', $data);
            $last_id = $this->db->insert_id(); 
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

			return $last_id;
		}

		public function reg_tourn_with_fee($data){

			$user_id	 = $data['player'];
			$tourn_id	 = $data['tourn_id'];
			$match_types = $data['mtypes'];
			$age_group	 = $data['age_group'];
			$partners	 = $data['partners'];
			$level		 = $data['level'];
            $reg_events  = $data['events'];
            $coup_code   = $data['coup_code'];
            $coup_disc   = $data['coup_disc'];

			if($data['hc_loc_id']){
				$home_court_loc = $data['hc_loc_id'];
			}
			else{
				$home_court_loc = NULL;
			}

			if($data['tsize']){
				$tsize = $data['tsize'];
			}
			else{
				$tsize = NULL;
			}

			$fee			= $data['payment_amt'];
			$currency_code	= $data['currency_code'];
			$trans_id		= $data['txn_id'];
			$status			= $data['status'];

			$reg_date = date("Y-m-d h:i:s");

			//return true;

			$get_tourn_reg = $this->db->query("SELECT * FROM RegisterTournament WHERE Tournament_ID = {$tourn_id} AND Users_ID={$user_id}");
			$get_res = $get_tourn_reg->row_array();

			//if($get_tourn_reg->num_rows() > 0){
			if(count($get_res) > 0){
			$reg_id = $get_res['RegisterTournament_id'];
	
			$data	= array(
					'Match_Type'			=> $match_types,
					'Reg_Age_Group'  => $age_group,
					'Reg_Sport_Level' => $level,
					'Reg_date'				=> $reg_date,
					'hcl_id'					=> $home_court_loc,
					'TShirt_Size'			=> $tsize,
					'Reg_Events'			=> $reg_events,
					'Partners'				=> $partners,
					'Coupon_Applied'  => $coup_code,
					'Discount_Amount' => $coup_disc
					);

			$this->db->where('RegisterTournament_id', $reg_id);
			$result	= $this->db->update('RegisterTournament', $data);
			$last_id =  $reg_id;
			}
			//else if($get_tourn_reg->num_rows() == 0){
			else{
			$data = array(
					'Users_ID'		=> $user_id,
					'Tournament_ID' => $tourn_id,
					'Match_Type'	=> $match_types,
					'Fee'			=> number_format($fee, 2),
					'Reg_Age_Group' => $age_group,
					'Reg_Sport_Level' => $level,
					'Reg_date'		=> $reg_date,
					'Transaction_id' => $trans_id,
					'Status'		=> $status,
					'Currency_Code' => $currency_code,
					'hcl_id'		=> $home_court_loc,
					'TShirt_Size'	=> $tsize,
					'Reg_Events'    => $reg_events,
					'Partners'		=> $partners,
					'Coupon_Applied'  => $coup_code,
					'Discount_Amount' => $coup_disc
					);

			$result = $this->db->insert('RegisterTournament', $data);	
			$last_id = $this->db->insert_id;
			}

// A2MScore add if not exists for sport
			$tour_det		= $this->getonerow($tourn_id);
			$tour_sport	= $tour_det->SportsType;
			
			$check_user_a2m = $this->get_a2mscore($user_id, $tour_sport);
			if($check_user_a2m->num_rows > 0){

			}
			else{
				$def_score = 100;
				if($tour_sport == '2') 
				$def_score = 800;
				if($tour_sport == '7') 
				$def_score = 3.0;

					$a2m_ins_data = array(
									'Users_ID'			 => $user_id,
									'SportsType_ID' => $tour_sport,
									'A2MScore'				  => $def_score,
									'A2MScore_Doubles' => $def_score,
									'A2MScore_Mixed'	  => $def_score
									);

					$result2 = $this->db->insert('A2MScore', $a2m_ins_data);
			}

			$school_info	 = $data['school_info'];
			if($school_info != "" or $school_info != NULL){
				$this->db->query("UPDATE Users SET School_Info = '".$school_info."' WHERE Users_ID = '".$user_id."'");
			}

			/*$player_a2m = $this->db->query("SELECT * FROM A2MScore WHERE Users_ID = {$user_id} AND SportsType_ID = {$tour_sport}");

			//if($player_a2m->num_rows() > 0){
			//	$player_a2m = $player_a2m->row_array();
				$init_a2m = max($player_a2m['A2MScore'], $player_a2m['A2MScore_Doubles'], $player_a2m['A2MScore_Mixed']);

				$query = $this->db->query("UPDATE RegisterTournament SET Current_A2M = {$init_a2m} WHERE RegisterTournament_ID = {$last_id}");
			}*/

			return $result;
		}

		public function reg_more_tourn_with_fee($data){

			$user_id		= $data['player'];
			$tourn_id		= $data['tourn_id'];
			$match_types	= $data['mtypes'];
			$age_group		= $data['age_group'];
			//$partner1		= $data['partner1'];
			//$partner2		= $data['partner2'];
			$level			= $data['level'];
			$fee			= $data['payment_amt'];
			$currency_code	= $data['currency_code'];
			$trans_id		= $data['txn_id'];
			$status			= $data['status'];
			$reg_events     = $data['events'];

			$reg_date = date("Y-m-d h:i:s");

			$data = array(
					'Match_Type'	  => $match_types,
					//'Partner1'		=> $partner1,
					//'Partner2'		=> $partner2,
					'Reg_Age_Group'	  => $age_group,
					'Reg_Sport_Level' => $level,
					'Reg_Events'    => $reg_events
					);

			$data1 = array(
					'Users_ID'		=> $user_id,
					'Tournament_ID' => $tourn_id
					);


					  $this->db->where($data1);	
			$result = $this->db->update('RegisterTournament', $data);
			
			$data = array(
					'pay_date'		=> $reg_date,
					'Users_ID'		=> $user_id,
					'mtype'			=> 'tournament',
					'mtype_ref'		=> $tourn_id,
					'Amount'		=> number_format($fee, 2),
					'Transaction_id' => $trans_id,
					'Status'		=> $status
					);

			$result = $this->db->insert('PayTransactions', $data);

			return $result;
			//return true;
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

		public function event_fee_paymet($data){

			$user_id		= $data['user_id'];
			$ev_id			= $data['ev_id'];
			$fee			= $data['payment_amt'];
			$currency_code	= $data['currency_code'];
			$trans_id		= $data['txn_id'];
			$status			= $data['status'];

			$cur_date		= date("Y-m-d h:i:s");

			$data = array(
					'pay_date'		=> $cur_date,
					'Users_ID'		=> $user_id,
					'mtype'			=> 'event',
					'mtype_ref'		=> $ev_id,
					'Amount'		=> number_format($fee, 2),
					'Transaction_id' => $trans_id,
					'Status'		 => $status
					);

			$result = $this->db->insert('PayTransactions', $data);
			return $result;
		}

		public function get_event_dets($ev_id){
			
			$data = array('Ev_ID' => $ev_id);
			$get_sp_name = $this->db->get_where('Events', $data);
			return $get_sp_name->row_array();
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

			$data = array('tournament_ID'=>$tourn_id);
			$get_name = $this->db->get_where('tournament',$data);
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

		/*public function get_reg_tourn_age_usernames($data){

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
            $reg_status='WithDrawn';
			$user_id = $this->logged_user;

			if($match_type == 'Singles'){

			$qry_check = $this->db->query("SELECT u.Users_ID, u.Firstname, u.Lastname, u.City, u.State, u.UserAgegroup,a2m.A2MScore FROM Users u  
			join RegisterTournament t on u.Users_ID = t.Users_ID join A2MScore a2m  on a2m.Users_ID = u.Users_ID 
			WHERE t.Tournament_ID = $tourn_id AND (t.Reg_Status != '$reg_status' OR t.Reg_Status IS NULL) AND  a2m.SportsType_ID = $sport AND t.Match_Type LIKE '%$match_type%' ORDER BY a2m.A2MScore DESC");
			}
			else if($match_type == 'Doubles'){
			
			$qry_check = $this->db->query("SELECT u.Users_ID, u.Firstname, u.Lastname, u.City, u.State, u.UserAgegroup,a2m.A2MScore,t.Partner1 FROM Users u  
			join RegisterTournament t on u.Users_ID = t.Users_ID join A2MScore a2m  on a2m.Users_ID = u.Users_ID 
			WHERE t.Tournament_ID = $tourn_id AND (t.Reg_Status != '$reg_status' OR t.Reg_Status IS NULL) AND  a2m.SportsType_ID = $sport AND t.Match_Type LIKE '%$match_type%' ORDER BY a2m.A2MScore DESC");
			}
			else if($match_type == 'Mixed'){
			
			$qry_check = $this->db->query("SELECT u.Users_ID, u.Firstname, u.Lastname, u.City, u.State, u.UserAgegroup,a2m.A2MScore,t.Partner2 FROM Users u  
			join RegisterTournament t on u.Users_ID = t.Users_ID join A2MScore a2m  on a2m.Users_ID = u.Users_ID 
			WHERE t.Tournament_ID = $tourn_id AND (t.Reg_Status != '$reg_status' OR t.Reg_Status IS NULL) AND  a2m.SportsType_ID = $sport AND t.Match_Type LIKE '%$match_type%' ORDER BY a2m.A2MScore DESC");
			}
			else if($match_type == ''){

			$qry_check = $this->db->query("SELECT u.Users_ID, u.Firstname, u.Lastname, u.City, u.State, u.UserAgegroup,a2m.A2MScore FROM Users u  
			join RegisterTournament t on u.Users_ID = t.Users_ID join A2MScore a2m  on a2m.Users_ID = u.Users_ID 
			WHERE t.Tournament_ID = $tourn_id AND (t.Reg_Status != '$reg_status' OR t.Reg_Status IS NULL) AND  a2m.SportsType_ID = $sport ORDER BY a2m.A2MScore DESC");
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

			$filter_events	 = $this->input->post('filter_events');
			$match_type	  = $this->input->post('match_type');
			$age_group	  = $this->input->post('age_group');
			$tourn_id	  = $this->input->post('tourn_id');
			$draw_title   = $this->input->post('draw_title');
			$bracket_type = $this->input->post('ttype');
			$created_on   = date("Y-m-d H:i:s");

			$game_day = '';
			if($this->input->post('br_game_day')) {
			$game_day = $this->input->post('br_game_day');
			}

			$data = array(
					'Tourn_ID'		=> $tourn_id,
					'Bracket_Type'	=> $bracket_type,
					'Draw_Title'	=> $draw_title,
					'Created_on'	=> $created_on,
					'Match_Type'	=> $match_type,
					'Age_Group'		=> $age_group,
					'Filter_Events' => $filter_events,
					'OCCR_ID'			=> $game_day
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


		public function insert_rr_brackets() {   // Insert Round Robin Tournament Brackets into db
			
            $filter_events	 = $this->input->post('filter_events');
			$matches		 = $this->input->post('match');
			$match_type	 = $this->input->post('match_type');
			$age_group	 = $this->input->post('age_group');
			$tourn_id	= $this->input->post('tourn_id');

			$is_event	= $this->input->post('create_event');

			$rr_matches		  = unserialize($this->input->post('rr_matches'));
			$rr_matches_loc  = unserialize($this->input->post('rr_matches_loc'));
			$teams				  = unserialize($this->input->post('players'));

			$num_rounds = count($rr_matches);

			$tourn_det	= $this->get_fixtures_det($tourn_id);
			$draw_title = $this->input->post('draw_title');
			$is_publish_draw = $this->input->post('is_publish_draw');
			//$bracket_type = $tourn_det['Tournament_type'];

			$bracket_type = $this->input->post('ttype');
			//$num_rounds = count($rounds);
			$created_on = date("Y-m-d H:i:s");

			$game_day = '';
			if($this->input->post('br_game_day')) {
			$game_day = $this->input->post('br_game_day');
			}

			$draw_format = '';
			if($this->input->post('draw_format')) {
			$draw_format = $this->input->post('draw_format');
			}

			$data = array(
					'Tourn_ID'			=> $tourn_id,
					'Bracket_Type'	=> $bracket_type,
					'Draw_Title'			=> $draw_title,
					'No_of_rounds'	=> $num_rounds,
					'Created_on'		=> $created_on,
					'Match_Type'		=> $match_type,
					'Age_Group'		=> $age_group,
					'is_Publish'			=> $is_publish_draw,
					'Filter_Events'		=> $filter_events,
					'OCCR_ID'			=> $game_day,
					'Draw_Format'		=> $draw_format
				);
			

			$this->db->insert('Brackets', $data);	

			$bracket_id = $this->db->insert_id();      
			 
			$ev_start_date = $this->input->post('round_date1');
			$ev_end_date   = $this->input->post('round_date'.$num_rounds);

			if($is_event) {
				foreach($teams as $team) {
				 $ev_id[$team] = $this->generate_tourn_event($tourn_id, $team, $draw_title, $ev_start_date, $ev_end_date);
				}
			}

			 //Tournament_Matches
			$player1_score = "";
			$player2_score = "";
			$winner = "";
			$win_per = "";

			foreach($rr_matches as $i=>$rrm) {
			$round = $i;

				 foreach($rr_matches[$i] as $j=>$match) {

					 $match_num = $j;

					 $rdate				= $this->input->post('round_date'.$i);
					 $mdate			= $this->input->post('match_date'.$j);
					 $assg_court	= $this->input->post('assg_court'.$j);

					 $duedate = NULL;

					if($rdate and !$mdate and $rdate != '') {
						$duedate = date("Y-m-d H:i", strtotime($rdate));
					}
					else if($mdate != '') {
						$duedate = date("Y-m-d H:i", strtotime($mdate));
					}

					$player1_val = explode('-', $rr_matches[$i][$j][0]);
					$player2_val = explode('-', $rr_matches[$i][$j][1]);

					if(isset($ev_id) and is_array($ev_id)) {

						$data = array(
								'Ev_ID'	  => $ev_id[$player1_val[0]],
								'Ev_Date'  => $duedate
								);
						$ins_to	 = $this->db->insert('Ev_Repeat_Schedule', $data);
						$ev_rep  = $this->db->insert_id();

						$get_team	  = $this->db->query("SELECT * FROM RegisterTournament WHERE Tournament_ID = {$tourn_id} AND Team_id = {$player1_val[0]}");
						$team_info	  = $get_team->row_array();
						$team_players = json_decode($team_info['Team_Players']);

							foreach($team_players as $pl) {
								$data = array(
									'Ev_ID'	    => $ev_id[$player1_val[0]],
									'Ev_Rep_ID' => $ev_rep,
									'Users_Id'  => $pl,
									'Ev_status' => 'Pending');

								$ins_to	= $this->db->insert('Ev_Inv_Status', $data);
							}

						$data = array(
								'Ev_ID'	  => $ev_id[$player2_val[0]],
								'Ev_Date' => $duedate
								);
						$ins_to	 = $this->db->insert('Ev_Repeat_Schedule', $data);
						$ev_rep  = $this->db->insert_id();

						$get_team	  = $this->db->query("SELECT * FROM RegisterTournament WHERE Tournament_ID = {$tourn_id} AND Team_id = {$player2_val[0]}");
						$team_info	  = $get_team->row_array();
						$team_players = json_decode($team_info['Team_Players']);

							foreach($team_players as $pl){
								$data = array(
									'Ev_ID'	    => $ev_id[$player2_val[0]],
									'Ev_Rep_ID' => $ev_rep,
									'Users_Id'  => $pl,
									'Ev_status' => 'Pending');

								$ins_to	= $this->db->insert('Ev_Inv_Status', $data);
							}
					}


					//$match_loc = NULL;
					$loc_user = NULL;

					if(!empty($rr_matches_loc))
					{
						$loc_user = $rr_matches_loc[$i][$j]['loc'];

						/*if($tourn_det['tournament_format'] = 'Teams'){
							$get_team_home_loc = $this->db->query("SELECT hcl_id FROM RegisterTournament WHERE Team_id = {$loc_user} AND Tournament_ID = {$tourn_id}");

							$team_home_loc	= $get_team_home_loc->row_array();
							$match_loc		= $team_home_loc['hcl_id'];
						}
						else{
							$get_user_home_loc = $this->db->query("SELECT hcl_id FROM RegisterTournament WHERE Users_ID = {$loc_user} AND Tournament_ID = {$tourn_id}");

							$user_home_loc	= $get_user_home_loc->row_array();
							$match_loc		= $user_home_loc['hcl_id'];
						}*/
					}

					$loc_user_arr = explode('-', $loc_user);
					$data = array(
						'BracketID'		=> $bracket_id,
						'Tourn_ID'		=> $tourn_id,
						'Round_Num'		=> $round,
						'Match_Num'		=> $match_num,
						'Player1'		=> intval($player1_val[0]),
						'Player2'		=> intval($player2_val[0]),
						'Winner'		=> $winner,
						'Win_Per'		=> $win_per,
						'Player1_Partner' => $player1_val[1],
						'Player2_Partner' => $player2_val[1],
						'Draw_Type'		=> $bracket_type,
						'Match_DueDate' => $duedate,
						//'Match_Location'=> $match_loc
						'Match_Location_User' => $loc_user_arr[0],
						'Court_Info' => $assg_court
						);


					$ins_to			= $this->db->insert('Tournament_Matches', $data);
					$tour_match_id  = $this->db->insert_id();

					if($tourn_det['tournament_format'] == 'Individual'){
							if($player1_val[0]){
								$this->insert_init_rating($player1_val[0], $tourn_id, $bracket_id, $draw_format);
							}
							if($player2_val[0]){
								$this->insert_init_rating($player2_val[0], $tourn_id, $bracket_id, $draw_format);
							}
							if($player1_val[1]){
								$this->insert_init_rating($player1_val[1], $tourn_id, $bracket_id, $draw_format);
							}
							if($player2_val[1]){
								$this->insert_init_rating($player2_val[1], $tourn_id, $bracket_id, $draw_format);
							}
					}

					if($tourn_det['tournament_format'] == 'Teams'){
						$lines = json_decode($tourn_det['lines_per_match']);

					    if($lines[0]->MSingles){
							for($a=1; $a<=$lines[0]->MSingles; $a++)
							{
								$data = array(
								'Tourn_match_id'	=> $tour_match_id,
								'Tourn_ID'			=> $tourn_id,
								'BracketID'			=> $bracket_id,
								'Line_num'			=> $a,
								'Draw_Type'			=> $bracket_type,
								'Match_Type'		=> 'MSingles',
								);

							$ins_to = $this->db->insert('Tournament_Lines', $data);
							}
						}

						if($lines[1]->WSingles){
							for($a=1; $a<=$lines[1]->WSingles; $a++)
							{
								$data = array(
								'Tourn_match_id'	=> $tour_match_id,
								'Tourn_ID'			=> $tourn_id,
								'BracketID'			=> $bracket_id,
								'Line_num'			=> $a,
								'Draw_Type'			=> $bracket_type,
								'Match_Type'		=> 'WSingles',
								);

							$ins_to = $this->db->insert('Tournament_Lines', $data);
							}
						}

						if($lines[2]->MDoubles){
							for($b=1; $b<=$lines[2]->MDoubles; $b++)
							{
								$data = array(
								'Tourn_match_id'	=> $tour_match_id,
								'Tourn_ID'			=> $tourn_id,
								'BracketID'			=> $bracket_id,
								'Line_num'			=> $b,
								'Draw_Type'			=> $bracket_type,
								'Match_Type'		=> 'MDoubles',
								);

							$ins_to = $this->db->insert('Tournament_Lines', $data);
							}
						}

						if($lines[3]->WDoubles){
							for($b=1; $b<=$lines[3]->WDoubles; $b++)
							{
								$data = array(
								'Tourn_match_id'	=> $tour_match_id,
								'Tourn_ID'			=> $tourn_id,
								'BracketID'			=> $bracket_id,
								'Line_num'			=> $b,
								'Draw_Type'			=> $bracket_type,
								'Match_Type'		=> 'WDoubles',
								);

							$ins_to = $this->db->insert('Tournament_Lines', $data);
							}
						}

						if($lines[4]->Mixed){
							for($b=1; $b<=$lines[4]->Mixed; $b++)
							{
								$data = array(
								'Tourn_match_id'	=> $tour_match_id,
								'Tourn_ID'			=> $tourn_id,
								'BracketID'			=> $bracket_id,
								'Line_num'			=> $b,
								'Draw_Type'			=> $bracket_type,
								'Match_Type'		=> 'Mixed',
								);

							$ins_to = $this->db->insert('Tournament_Lines', $data);
							}
						}

						if($lines[5]->OSingles){
							for($b=1; $b<=$lines[5]->OSingles; $b++)
							{
								$data = array(
								'Tourn_match_id'	=> $tour_match_id,
								'Tourn_ID'			=> $tourn_id,
								'BracketID'			=> $bracket_id,
								'Line_num'			=> $b,
								'Draw_Type'			=> $bracket_type,
								'Match_Type'		=> 'OSingles',
								);

							$ins_to = $this->db->insert('Tournament_Lines', $data);
							}
						}

						if($lines[6]->ODoubles){
							for($b=1; $b<=$lines[6]->ODoubles; $b++)
							{
								$data = array(
								'Tourn_match_id'	=> $tour_match_id,
								'Tourn_ID'			=> $tourn_id,
								'BracketID'			=> $bracket_id,
								'Line_num'			=> $b,
								'Draw_Type'			=> $bracket_type,
								'Match_Type'		=> 'ODoubles',
								);

							$ins_to = $this->db->insert('Tournament_Lines', $data);
							}
						}
					}
					//echo "<pre>";
					//print_r($data);
				 }
			 }
				//exit;
			if($ins_to){
				return true;
			}
			else{
				return false;
			}
		}


public function insert_sd_brackets() {   // Insert Switch Doubles Tournament Brackets into db
			//echo "<pre>"; print_r($_POST); 
            $filter_events			= $this->input->post('filter_events');
            $rr_multi_rounds	= $this->input->post('rr_multi_rounds');
			$matches				= $this->input->post('match');
			$match_type			= $this->input->post('match_type');
			$age_group			= $this->input->post('age_group');
			$tourn_id				= $this->input->post('tourn_id');
			$is_event				= $this->input->post('create_event');

			$rr_matches			= unserialize($this->input->post('rr_matches'));
			$rr_matches_loc	= unserialize($this->input->post('rr_matches_loc'));
			$teams					= unserialize($this->input->post('players'));

			$num_rounds			= count($rr_matches);

//echo "<pre>";
//print_r($rr_matches);
//exit;
			$tourn_det	 = $this->get_fixtures_det($tourn_id);
			$draw_title = $this->input->post('draw_title');
			//$bracket_type = $tourn_det['Tournament_type'];

			$bracket_type	= $this->input->post('ttype');
			//$num_rounds = count($rounds);
			$created_on		= date("Y-m-d H:i:s");

			$game_day = '';
			if($this->input->post('br_game_day')) {
			$game_day = $this->input->post('br_game_day');
			}

			$draw_format = '';
			if($this->input->post('draw_format')) {
			$draw_format = $this->input->post('draw_format');
			}

			$data = array(
					'Tourn_ID'		=> $tourn_id,
					'Bracket_Type'	=> $bracket_type,
					'Draw_Title'	=> $draw_title,
					'No_of_rounds'	=> $num_rounds,
					'Created_on'	=> $created_on,
					'Match_Type'	=> $match_type,
					'Age_Group'		=> $age_group,
					'Filter_Events' => $filter_events,
					'RR_Multi_Rounds' => $rr_multi_rounds,
					'OCCR_ID'			=> $game_day,
					'Draw_Format'		=> $draw_format
				);
			

			$this->db->insert('Brackets', $data);	

			$bracket_id = $this->db->insert_id();      
			 
			$ev_start_date = $this->input->post('round_date1');
			$ev_end_date   = $this->input->post('round_date'.$num_rounds);

			/*if($is_event){
				foreach($teams as $team){
				 $ev_id[$team] = $this->generate_tourn_event($tourn_id, $team, $draw_title, $ev_start_date, $ev_end_date);
				}
			}*/

			 //Tournament_Matches
			$player1_score = "";
			$player2_score = "";
			$winner = "";
			$win_per = "";
			
			$temp = $this->input->post('match_date');
			$index = 1;
			foreach($rr_matches as $multi_round => $matches){
			$j = 1;
				foreach($matches as $match => $games){

					$round = $multi_round;

				 //foreach($games as $game){

					 $match_num = $j;

					 $rdate = $this->input->post('round_date'.$multi_round);
					// $mdate = $this->input->post('match_date'.$multi_round.'_'.$j);
					 $mdate = $temp[$multi_round.$match][0];
					 $gdate = $this->input->post('game_date'.$index);

					 $duedate = NULL;

					if($rdate and !$mdate and $rdate != ''){
						$duedate = date("Y-m-d H:i", strtotime($rdate));
					}
					else if($mdate != '' and $gdate == ''){
						$duedate = date("Y-m-d H:i", strtotime($mdate));
					}
					else if($gdate != ''){
						$duedate = date("Y-m-d H:i", strtotime($gdate));
					}

					/*$player1_val = explode('-', $game[0]);
					$player2_val = explode('-', $game[1]);*/

					$player1_val			= $games[1][0];
					$player1_partner	= $games[1][1];

					$player2_val			= $games[2][0];
					$player2_partner	= $games[2][1];

					//$match_loc = NULL;
					$loc_user = NULL;

					if(!empty($rr_matches_loc))
					{
						$loc_user = $rr_matches_loc[$i][$j]['loc'];
					}

					$data = array(
						'BracketID'		=> $bracket_id,
						'Tourn_ID'		=> $tourn_id,
						'Round_Num'		=> $round,
						'Match_Num'		=> $match_num,
						'Player1'		=> intval($player1_val),
						'Player2'		=> intval($player2_val),
						'Winner'		=> $winner,
						'Win_Per'		=> $win_per,
						'Player1_Partner' => $player1_partner,
						'Player2_Partner' => $player2_partner,
						'Draw_Type'		=> $bracket_type,
						'Match_DueDate' => $duedate,
						//'Match_Location'=> $match_loc
						'Match_Location_User' => $loc_user,
						'Multi_Round_Num' => $multi_round
						);

					$ins_to			= $this->db->insert('Tournament_Matches', $data);
					$tour_match_id  = $this->db->insert_id();

					if($tourn_det['tournament_format'] == 'Individual'){
							if($player1_val){
								$this->insert_init_rating($player1_val, $tourn_id, $bracket_id, $draw_format);
							}
							if($player2_val){
								$this->insert_init_rating($player2_val, $tourn_id, $bracket_id, $draw_format);
							}
							if($player1_partner){
								$this->insert_init_rating($player1_partner, $tourn_id, $bracket_id, $draw_format);
							}
							if($player2_partner){
								$this->insert_init_rating($player2_partner, $tourn_id, $bracket_id, $draw_format);
							}
					}


					$j++;
					$index;
				// }
				}
			 }
				//exit;
			if($ins_to){
				return true;
			}
			else{
				return false;
			}
		}

public function insert_group_sd_brackets() {   // Insert Group Switch Doubles Tournament Brackets into db
			//echo "<pre>";
			//print_r($_POST);
			//exit;
            $filter_events	 = $this->input->post('filter_events');
            $rr_multi_rounds = $this->input->post('rr_multi_rounds');
			$matches	= $this->input->post('match');
			$match_type = $this->input->post('match_type');
			$age_group	= $this->input->post('age_group');
			$tourn_id	= $this->input->post('tourn_id');

			$is_event	= $this->input->post('create_event');
			$draw_title  = $this->input->post('draw_title');

			$rr_matches_arr		 = $this->input->post('rr_matches');
			$rr_matches_loc_arr  = $this->input->post('rr_matches_loc');

				$tourn_det	= $this->get_fixtures_det($tourn_id);

			$game_day = '';
			if($this->input->post('br_game_day')) {
			$game_day = $this->input->post('br_game_day');
			}

			$draw_format = '';
			if($this->input->post('draw_format')) {
			$draw_format = $this->input->post('draw_format');
			}

foreach($draw_title as $g => $title){

			$rr_matches			= unserialize($rr_matches_arr[$g]);
			$rr_matches_loc	= unserialize($rr_matches_loc_arr[$g]);
			//$teams			= unserialize($this->input->post('players'));

			$num_rounds = count($rr_matches);
/*echo "<pre>";
print_r($rr_matches);
exit;*/

			$is_publish_draw = $this->input->post('is_publish_draw');
			//$bracket_type = $tourn_det['Tournament_type'];

			//$bracket_type = $this->input->post('ttype');
			$bracket_type = "Switch Doubles";
			//$num_rounds = count($rounds);
			$created_on = date("Y-m-d H:i:s");

			$data = array(
					'Tourn_ID'			=> $tourn_id,
					'Bracket_Type'	=> $bracket_type,
					'Draw_Title'			=> $title,
					'No_of_rounds'	=> $num_rounds,
					'Created_on'		=> $created_on,
					'Match_Type'		=> $match_type,
					'Age_Group'		=> $age_group,
					'Filter_Events'		=> $filter_events,
					'is_Publish'			=> $is_publish_draw,
					'RR_Multi_Rounds' => $rr_multi_rounds,
					'OCCR_ID'			=> $game_day,
					'Draw_Format'			=> $draw_format
				);
			//print_r($data);
			//exit;

			$this->db->insert('Brackets', $data);	

			$bracket_id = $this->db->insert_id();      

	 
			$ev_start_date = $this->input->post('round_date1');
			$ev_end_date   = $this->input->post('round_date'.$num_rounds);

			/*if($is_event){
				foreach($teams as $team){
				 $ev_id[$team] = $this->generate_tourn_event($tourn_id, $team, $draw_title, $ev_start_date, $ev_end_date);
				}
			}*/

			 //Tournament_Matches
			$player1_score = "";
			$player2_score = "";
			$winner = "";
			$win_per = "";
			
			$index = 1;
			foreach($rr_matches as $multi_round => $matches){
			$j = 1;
				foreach($matches as $match => $games){

					$round = $match;

				 //foreach($games as $game){

					 $match_num = $j;

					 $rdate = $this->input->post('round_date'.$multi_round);
					 $mdate = $this->input->post('match_date'.$multi_round.'_'.$j);
					 $gdate = $this->input->post('g'.$g.'_game_date'.$multi_round.$match);

					 $duedate = NULL;

					if($rdate and !$mdate and $rdate != ''){
						$duedate = date("Y-m-d H:i", strtotime($rdate));
					}
					else if($mdate != '' and $gdate == ''){
						$duedate = date("Y-m-d H:i", strtotime($mdate));
					}
					else if($gdate != ''){
						$duedate = date("Y-m-d H:i", strtotime($gdate));
					}

					/*$player1_val = explode('-', $game[0]);
					$player2_val = explode('-', $game[1]);*/

					$player1_val	 = $games[1][0];
					$player1_partner = $games[1][1];

					$player2_val	 = $games[2][0];
					$player2_partner = $games[2][1];

					//$match_loc = NULL;
					$loc_user = NULL;

					if(!empty($rr_matches_loc))
					{
						$loc_user = $rr_matches_loc[$i][$j]['loc'];
					}

					$data = array(
						'BracketID'		=> $bracket_id,
						'Tourn_ID'		=> $tourn_id,
						'Round_Num'		=> $round,
						'Match_Num'		=> $match_num,
						'Player1'		=> intval($player1_val),
						'Player2'		=> intval($player2_val),
						'Winner'		=> $winner,
						'Win_Per'		=> $win_per,
						'Player1_Partner' => $player1_partner,
						'Player2_Partner' => $player2_partner,
						'Draw_Type'		=> $bracket_type,
						'Match_DueDate' => $duedate,
						//'Match_Location'=> $match_loc
						'Match_Location_User' => $loc_user,
						'Multi_Round_Num' => $multi_round
						);

					$ins_to			= $this->db->insert('Tournament_Matches', $data);
					$tour_match_id  = $this->db->insert_id();

					$j++;
					$index;
				// }


					if($tourn_det['tournament_format'] == 'Individual'){
							if($player1_val){
								$this->insert_init_rating($player1_val, $tourn_id, $bracket_id, $draw_format);
							}
							if($player2_val){
								$this->insert_init_rating($player2_val, $tourn_id, $bracket_id, $draw_format);
							}
							if($player1_partner){
								$this->insert_init_rating($player1_partner, $tourn_id, $bracket_id, $draw_format);
							}
							if($player2_partner){
								$this->insert_init_rating($player2_partner, $tourn_id, $bracket_id, $draw_format);
							}
					}

				}
			 }

			}
				//exit;
			if($ins_to){
				return true;
			}
			else{
				return false;
			}
		}


		public function insert_group_rr_brackets(){
		/*echo "<pre>";
		print_r($_POST);
		exit;*/
		    $filter_events	 = $this->input->post('filter_events');
			$matches	= $this->input->post('match');
			$match_type = $this->input->post('match_type');
			$age_group	= $this->input->post('age_group');
			$tourn_id	= $this->input->post('tourn_id');

			$is_event	= $this->input->post('create_event');
			$is_event	= $this->input->post('create_event');
			$draw_title = $this->input->post('draw_title');
			$rr_matches_arr		 = $this->input->post('rr_matches');
			$rr_matches_loc_arr  = $this->input->post('rr_matches_loc');
			$rr_multi_rounds = $this->input->post('rr_multi_rounds');
			$is_publish_draw = $this->input->post('is_publish_draw');

/*echo "<pre>";
print_r($rr_matches_arr);*/

			$game_day = '';
			if($this->input->post('br_game_day')) {
			$game_day = $this->input->post('br_game_day');
			}

			$draw_format = '';
			if($this->input->post('draw_format')) {
			$draw_format = $this->input->post('draw_format');
			}

			foreach($draw_title as $g => $title){
			$rr_matches		= unserialize($rr_matches_arr[$g]);
			$rr_matches_loc = unserialize($rr_matches_loc_arr[$g]);
			/*$teams			= unserialize($this->input->post('players'));*/
//echo "<pre>";
//print_r($rr_matches_loc);
//exit;
			$num_rounds = count($rr_matches);

			$tourn_det	= $this->get_fixtures_det($tourn_id);

			$bracket_type = 'Round Robin';
			$created_on = date("Y-m-d H:i:s");

			$data = array(
					'Tourn_ID'		=> $tourn_id,
					'Bracket_Type'	=> $bracket_type,
					'Draw_Title'	=> $title,
					'No_of_rounds'	=> $num_rounds,
					'Created_on'	=> $created_on,
					'is_Publish'	=> $is_publish_draw,
					'RR_Multi_Rounds' => $rr_multi_rounds,
					'OCCR_ID'			=> $game_day,
					'Draw_Format'		=> $draw_format
				
					//'Match_Type'	=> $match_type,
					//'Age_Group'		=> $age_group,
					//'Filter_Events' => $filter_events
				);
			//echo "<pre>";
			//echo "Bracket <br>";
			//print_r($data);
			$this->db->insert('Brackets', $data);	
						//echo "<br>".$this->db->last_query();

			$bracket_id = $this->db->insert_id(); 
			

			foreach($rr_matches as $i=>$rrm){

			$round = $i;

				 foreach($rr_matches[$i] as $j=>$match){

					 $match_num = $j;

					 $rdate = $this->input->post('g'.$g.'_round_date'.$i);
					 $mdate = $this->input->post('g'.$g.'_match_date'.$j);
					$asg_court = NULL;
					 if($this->input->post('g'.$g.'_assg_court'.$j))
					 $asg_court = $this->input->post('g'.$g.'_assg_court'.$j);

					 $duedate = NULL;

					if($rdate and !$mdate and $rdate != ''){
						$duedate = date("Y-m-d H:i", strtotime($rdate));
					}
					else if($mdate != ''){
						$duedate = date("Y-m-d H:i", strtotime($mdate));
					}

					$player1_val = explode('-', $rr_matches[$i][$j][0]);
					$player2_val = explode('-', $rr_matches[$i][$j][1]);

					$loc_user = NULL;

					if(!empty($rr_matches_loc)){
						$loc_user = $rr_matches_loc[$i][$j]['loc'];
					}

					$data = array(
						'BracketID'		=> $bracket_id,
						'Tourn_ID'		=> $tourn_id,
						'Round_Num'		=> $round,
						'Match_Num'		=> $match_num,
						'Player1'		=> intval($player1_val[0]),
						'Player2'		=> intval($player2_val[0]),
						'Player1_Partner' => $player1_val[1],
						'Player2_Partner' => $player2_val[1],
						'Draw_Type'		=> $bracket_type,
						'Match_DueDate' => $duedate,
						//'Match_Location'=> $match_loc
						'Match_Location_User' => $loc_user,
						'Court_Info' => $asg_court
						);
			//echo "Matches <br>";
			//print_r($data);
			//exit;
					$ins_to			= $this->db->insert('Tournament_Matches', $data);
					$tour_match_id  = $this->db->insert_id();

					if($tourn_det['tournament_format'] == 'Individual'){
							if($player1_val[0]){
								$this->insert_init_rating($player1_val[0], $tourn_id, $bracket_id, $draw_format);
							}
							if($player2_val[0]){
								$this->insert_init_rating($player2_val[0], $tourn_id, $bracket_id, $draw_format);
							}
							if($player1_val[1]){
								$this->insert_init_rating($player1_val[1], $tourn_id, $bracket_id, $draw_format);
							}
							if($player2_val[1]){
								$this->insert_init_rating($player2_val[1], $tourn_id, $bracket_id, $draw_format);
							}
					}

					if($tourn_det['tournament_format'] == 'Teams'){
						$lines = json_decode($tourn_det['lines_per_match']);

					    if($lines[0]->MSingles){
							for($a=1; $a<=$lines[0]->MSingles; $a++){
								$data = array(
								'Tourn_match_id'	=> $tour_match_id,
								'Tourn_ID'			=> $tourn_id,
								'BracketID'			=> $bracket_id,
								'Line_num'			=> $a,
								'Draw_Type'			=> $bracket_type,
								'Match_Type'		=> 'MSingles',
								);

							$ins_to = $this->db->insert('Tournament_Lines', $data);
							}
						}

						if($lines[1]->WSingles){
							for($a=1; $a<=$lines[1]->WSingles; $a++){
								$data = array(
								'Tourn_match_id'	=> $tour_match_id,
								'Tourn_ID'			=> $tourn_id,
								'BracketID'			=> $bracket_id,
								'Line_num'			=> $a,
								'Draw_Type'			=> $bracket_type,
								'Match_Type'		=> 'WSingles',
								);

							$ins_to = $this->db->insert('Tournament_Lines', $data);
							}
						}

						if($lines[2]->MDoubles){
							for($b=1; $b<=$lines[2]->MDoubles; $b++){
								$data = array(
								'Tourn_match_id'	=> $tour_match_id,
								'Tourn_ID'			=> $tourn_id,
								'BracketID'			=> $bracket_id,
								'Line_num'			=> $b,
								'Draw_Type'			=> $bracket_type,
								'Match_Type'		=> 'MDoubles',
								);

							$ins_to = $this->db->insert('Tournament_Lines', $data);
							}
						}

						if($lines[3]->WDoubles){
							for($b=1; $b<=$lines[3]->WDoubles; $b++){
								$data = array(
								'Tourn_match_id'	=> $tour_match_id,
								'Tourn_ID'			=> $tourn_id,
								'BracketID'			=> $bracket_id,
								'Line_num'			=> $b,
								'Draw_Type'			=> $bracket_type,
								'Match_Type'		=> 'WDoubles',
								);

							$ins_to = $this->db->insert('Tournament_Lines', $data);
							}
						}

						if($lines[4]->Mixed){
							for($b=1; $b<=$lines[4]->Mixed; $b++){
								$data = array(
								'Tourn_match_id'	=> $tour_match_id,
								'Tourn_ID'			=> $tourn_id,
								'BracketID'			=> $bracket_id,
								'Line_num'			=> $b,
								'Draw_Type'			=> $bracket_type,
								'Match_Type'		=> 'Mixed',
								);

							$ins_to = $this->db->insert('Tournament_Lines', $data);
							}
						}

						if($lines[5]->OSingles){
							for($b=1; $b<=$lines[5]->OSingles; $b++){
								$data = array(
								'Tourn_match_id'	=> $tour_match_id,
								'Tourn_ID'			=> $tourn_id,
								'BracketID'			=> $bracket_id,
								'Line_num'			=> $b,
								'Draw_Type'			=> $bracket_type,
								'Match_Type'		=> 'OSingles',
								);

							$ins_to = $this->db->insert('Tournament_Lines', $data);
							}
						}

						if($lines[6]->ODoubles){
							for($b=1; $b<=$lines[6]->ODoubles; $b++){
								$data = array(
								'Tourn_match_id'	=> $tour_match_id,
								'Tourn_ID'			=> $tourn_id,
								'BracketID'			=> $bracket_id,
								'Line_num'			=> $b,
								'Draw_Type'			=> $bracket_type,
								'Match_Type'		=> 'ODoubles',
								);

							$ins_to = $this->db->insert('Tournament_Lines', $data);
							}
						}
					}
					//echo "<pre>";
					//print_r($data);
				 }
			 }

			} // End of Draw title for loop

			return true;

		}

		public function insert_po_brackets() // Insert Playoff Brackets
		{
			$filter_events	 = $this->input->post('filter_events');
          	$po_list	= unserialize($this->input->post('po_list'));
          	$po_list2	= unserialize($this->input->post('po_list2'));
			$match_type = 'Teams';
			$tourn_id   = $this->input->post('tourn_id');
			$draw_title = $this->input->post('draw_title');
			$is_publish_draw = $this->input->post('is_publish_draw');

			$tourn_det	= $this->get_fixtures_det($tourn_id);

			$bracket_type	= $this->input->post('ttype');
			$num_rounds		= 3;
			$created_on		= date("Y-m-d H:i:s");

			$game_day = '';
			if($this->input->post('br_game_day')) {
			$game_day = $this->input->post('br_game_day');
			}

			$data = array(
					'Tourn_ID'		=> $tourn_id,
					'Bracket_Type'	=> $bracket_type,
					'Draw_Title'	=> $draw_title,
					'No_of_rounds'	=> $num_rounds,
					'Created_on'	=> $created_on,
					'Match_Type'	=> $match_type,
					'is_Publish'	 => $is_publish_draw,
					'Filter_Events' => $filter_events,
					'OCCR_ID'			=> $game_day
					);

			 $this->db->insert('Brackets', $data);	
			 $bracket_id = $this->db->insert_id();  

			foreach($po_list2 as $r => $po){
				foreach($po as $m => $match){
					$player1 = 0;
					$player2 = 0;
				
				if($match[0] != '---'){
					$player1 = $match[0];
				}

				if($match[1] != '---'){
					$player2 = $match[1];
				}


				if($r == 2){
					$player1_source = 2;
					$player2_source = -1;
				}
				
				if($r == 3){
					$player1_source = 3;
					$player2_source = 1;
				}
					$data = array(
						'BracketID' => $bracket_id,
						'Tourn_ID'	=> $tourn_id,
						'Round_Num' => $r,
						'Match_Num' => $m,
						'Player1'	=> $player1,
						'Player2'	=> $player2,
						'Player1_source' => $player1_source,
						'Player2_source' => $player2_source,
						'Draw_Type' => 'Main'
					);

 					$ins_to = $this->db->insert('Tournament_Matches', $data);
					$tour_match_id = $this->db->insert_id();

					if($tourn_det['tournament_format'] == 'Teams'){					// Team League Line Matches Creation
						$lines = json_decode($tourn_det['lines_per_match']);

						if($lines[0]->MSingles){
							for($a=1; $a<=$lines[0]->MSingles; $a++)
							{
								$data = array(
								'Tourn_match_id'	=> $tour_match_id,
								'Tourn_ID'			=> $tourn_id,
								'BracketID'			=> $bracket_id,
								'Line_num'			=> $a,
								'Draw_Type'			=> $bracket_type,
								'Match_Type'		=> 'MSingles',
								);

							$ins_to = $this->db->insert('Tournament_Lines', $data);
							}
						}

						if($lines[1]->WSingles){
							for($a=1; $a<=$lines[1]->WSingles; $a++)
							{
								$data = array(
								'Tourn_match_id'	=> $tour_match_id,
								'Tourn_ID'			=> $tourn_id,
								'BracketID'			=> $bracket_id,
								'Line_num'			=> $a,
								'Draw_Type'			=> $bracket_type,
								'Match_Type'		=> 'WSingles',
								);

							$ins_to = $this->db->insert('Tournament_Lines', $data);
							}
						}

						if($lines[2]->MDoubles){
							for($b=1; $b<=$lines[2]->MDoubles; $b++)
							{
								$data = array(
								'Tourn_match_id'	=> $tour_match_id,
								'Tourn_ID'			=> $tourn_id,
								'BracketID'			=> $bracket_id,
								'Line_num'			=> $b,
								'Draw_Type'			=> $bracket_type,
								'Match_Type'		=> 'MDoubles',
								);

							$ins_to = $this->db->insert('Tournament_Lines', $data);
							}
						}

						if($lines[3]->WDoubles){
							for($b=1; $b<=$lines[3]->WDoubles; $b++)
							{
								$data = array(
								'Tourn_match_id'	=> $tour_match_id,
								'Tourn_ID'			=> $tourn_id,
								'BracketID'			=> $bracket_id,
								'Line_num'			=> $b,
								'Draw_Type'			=> $bracket_type,
								'Match_Type'		=> 'WDoubles',
								);

							$ins_to = $this->db->insert('Tournament_Lines', $data);
							}
						}

						if($lines[4]->Mixed){
							for($b=1; $b<=$lines[4]->Mixed; $b++)
							{
								$data = array(
								'Tourn_match_id'	=> $tour_match_id,
								'Tourn_ID'			=> $tourn_id,
								'BracketID'			=> $bracket_id,
								'Line_num'			=> $b,
								'Draw_Type'			=> $bracket_type,
								'Match_Type'		=> 'Mixed',
								);

							$ins_to = $this->db->insert('Tournament_Lines', $data);
							}
						}

						if($lines[5]->OSingles){
							for($b=1; $b<=$lines[5]->OSingles; $b++){
								$data = array(
								'Tourn_match_id'	=> $tour_match_id,
								'Tourn_ID'			=> $tourn_id,
								'BracketID'			=> $bracket_id,
								'Line_num'			=> $b,
								'Draw_Type'			=> $bracket_type,
								'Match_Type'		=> 'OSingles',
								);

							$ins_to = $this->db->insert('Tournament_Lines', $data);
							}
						}

						if($lines[6]->ODoubles){
							for($b=1; $b<=$lines[6]->ODoubles; $b++){
								$data = array(
								'Tourn_match_id'	=> $tour_match_id,
								'Tourn_ID'			=> $tourn_id,
								'BracketID'			=> $bracket_id,
								'Line_num'			=> $b,
								'Draw_Type'			=> $bracket_type,
								'Match_Type'		=> 'ODoubles',
								);

							$ins_to = $this->db->insert('Tournament_Lines', $data);
							}
						}

					}											// Team League Line Matches Creation

				}
			}
			return true;	
		}

		public function insert_cl_brackets()
		{
			$players    = unserialize($this->input->post('players'));
			$levels     = $this->input->post('levels');
			$draw_title = ucfirst($this->input->post('draw_title'));
			$tourn_id   = $this->input->post('tourn_id');
			$bracket_type  = $this->input->post('ttype');
			$filter_events = $this->input->post('filter_events');
			$ch_pos	  	   = $this->input->post('ch_ladder_position');
			$ch_duration   = $this->input->post('ch_ladder_duration');
			$sdate	  	   = date('Y-m-d', $this->input->post('match_sdate'));
			$edate	  	   = date('Y-m-d', $this->input->post('match_edate'));

			$created_on		= date("Y-m-d H:i:s");

			$game_day = '';
			if($this->input->post('br_game_day')) {
			$game_day = $this->input->post('br_game_day');
			}


			$data = array(
					'Tourn_ID'		=> $tourn_id,
					'Bracket_Type'	=> $bracket_type,
					'Draw_Title'	=> $draw_title,
					'Created_on'	=> $created_on,
					'Filter_Events'	=> $filter_events,
					'No_of_rounds'	=> $ch_pos,
					'SDate'			=> $sdate,
					'EDate'			=> $edate,
					'Ch_Duration'	=> $ch_duration,
					'OCCR_ID'			=> $game_day
					);
			
			 $this->db->insert('Brackets', $data);

			 $bracket_id = $this->db->insert_id();

			 foreach($players as $i => $player){
				 $user = explode("-", $player);

					$data = array(
					'Tourn_ID'	 	=> $tourn_id,
					'Bracket_ID' 	=> $bracket_id,
					'Player'	 	=> $user[0],
					'Player_Partner'=> $user[1],
					'Position'	 	=> $levels[$i],
					'Prev_Position' => 0
					);

				$ins_to = $this->db->insert('CL_Positions', $data);
			 }
		return true;
		}

		public function insert_tourn_brackets() // Insert Single Elimination
	{
			/*echo "<pre>";
			print_r($_POST);
			exit;*/

            $filter_events	 = $this->input->post('filter_events');
			$rounds	 = $this->input->post('round');
			$matches = $this->input->post('match_num');
			$player1 = $this->input->post('player1');
			$player2 = $this->input->post('player2');
            
			$match_type = $this->input->post('match_type');
			$age_group	= $this->input->post('age_group');


			$tourn_id   = $this->input->post('tourn_id');
			$draw_title = $this->input->post('draw_title');
			$squad		= $this->input->post('squad');
			$is_publish_draw		= $this->input->post('is_publish_draw');

			$tourn_det	= $this->get_fixtures_det($tourn_id);
			//$bracket_type = $tourn_det['Tournament_type'];

			$bracket_type	= $this->input->post('ttype');
			if(in_array(-1,$rounds))
				$num_rounds		= count($rounds) - 1;
			else
				$num_rounds		= count($rounds);
			
			$created_on		= date("Y-m-d H:i:s");

			$game_day = '';
			if($this->input->post('br_game_day')) {
			$game_day = $this->input->post('br_game_day');
			}

			$data = array(
					'Tourn_ID'		=> $tourn_id,
					'Bracket_Type'	=> $bracket_type,
					'Draw_Title'	=> $draw_title,
					'No_of_rounds'	=> $num_rounds,
					'Created_on'	=> $created_on,
					'Match_Type'	=> $match_type,
					'Age_Group'		=> $age_group,
					'Filter_Events'	 => $filter_events,
					'is_Publish'	 => $is_publish_draw,
					'Squad'			=> $squad,
					'OCCR_ID'			=> $game_day
					);
			
			 $this->db->insert('Brackets', $data);	
			 //echo $this->db->last_query();

			 $bracket_id = $this->db->insert_id(); 
			/*echo "<pre>";
			echo $bracket_id;
			exit;*/
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
					$player1_score	= "";
					$player2_score	= "";
					$winner			= "";
					$win_per		= "";

					$date_round  = $this->input->post('round_date'.$round);
					$date_match = $this->input->post('match_date'.$match);
					$assg_court  = $this->input->post('assg_court'.$match);

					$match_due_date = "";

					if($date_round != "") {
						$match_due_date = date("Y-m-d H:i",strtotime($date_round));
					} 
					else if($date_match != "") {
						$match_due_date = date("Y-m-d H:i",strtotime($date_match)); 
					}

					$assg_match_court = NULL;

					if($assg_court != "") {
						$assg_match_court = $assg_court;
					} 


					if($player1[$round][$match][0] == "---" or $player1[$round][$match][0] == "----" or $player1[$round][$match][0] == 0)
					{
						$player1_val = "";
						if($round==1){
							$player1_score = 'Bye Match';
							$player2_score = 'Bye Match';
							$winner = intval($player2[$round][$match][0]);
							$win_per = 0;
						}
					}
					else
					{
						$player1_val = intval($player1[$round][$match][0]);
						$player1_partner = explode("-", $player1[$round][$match][0]);
					}


					if($player2[$round][$match][0] == "---" or $player2[$round][$match][0] == "----" or $player2[$round][$match][0] == 0)
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
						$player2_val	 = intval($player2[$round][$match][0]);
						$player2_partner = explode("-", $player2[$round][$match][0]);
					}

					$player1_source = $player1[$round][$match][1];
					$player2_source = $player2[$round][$match][1];

					if($match_due_date == ""){
						$data = array(
							'BracketID' => $bracket_id,
							'Tourn_ID'	=> $tourn_id,
							'Round_Num' => $round,
							'Match_Num' => $match,
							'Player1'	=> $player1_val,
							'Player2'	=> $player2_val,
							'Player1_Score' => $player1_score,
							'Player2_Score' => $player2_score,
							'Winner'	=> $winner,   
							'Win_Per'	=> $win_per,
							'Player1_source' => $player1_source,
							'Player2_source' => $player2_source,
							'Player1_Partner' => intval($player1_partner[1]),
							'Player2_Partner' => intval($player2_partner[1]),
							'Draw_Type' => 'Main',
							'Court_Info' => $assg_match_court
						);
					} else {
						$data = array(
							'BracketID' => $bracket_id,
							'Tourn_ID'	=> $tourn_id,
							'Round_Num' => $round,
							'Match_Num' => $match,
							'Player1' => $player1_val,
							'Player2' => $player2_val,
							'Player1_Score' => $player1_score,
							'Player2_Score' => $player2_score,
							'Winner'	=> $winner,   
							'Win_Per'	=> $win_per,
							'Player1_source' => $player1_source,
							'Player2_source' => $player2_source,
							'Player1_Partner' => intval($player1_partner[1]),
							'Player2_Partner' => intval($player2_partner[1]),
							'Draw_Type' => 'Main',
							'Match_DueDate' => $match_due_date,
							'Court_Info' => $assg_match_court
						);
					}

					
					$ins_to = $this->db->insert('Tournament_Matches', $data);
					$tour_match_id = $this->db->insert_id();

					if($tourn_det['tournament_format'] == 'Teams'){					// Team League Line Matches Creation
						$lines = json_decode($tourn_det['lines_per_match']);

						if($lines[0]->MSingles){
							for($a=1; $a<=$lines[0]->MSingles; $a++)
							{
								$data = array(
								'Tourn_match_id'	=> $tour_match_id,
								'Tourn_ID'			=> $tourn_id,
								'BracketID'			=> $bracket_id,
								'Line_num'			=> $a,
								'Draw_Type'			=> $bracket_type,
								'Match_Type'		=> 'MSingles',
								);

							$ins_to = $this->db->insert('Tournament_Lines', $data);
							}
						}

						if($lines[1]->WSingles){
							for($a=1; $a<=$lines[1]->WSingles; $a++)
							{
								$data = array(
								'Tourn_match_id'	=> $tour_match_id,
								'Tourn_ID'			=> $tourn_id,
								'BracketID'			=> $bracket_id,
								'Line_num'			=> $a,
								'Draw_Type'			=> $bracket_type,
								'Match_Type'		=> 'WSingles',
								);

							$ins_to = $this->db->insert('Tournament_Lines', $data);
							}
						}

						if($lines[2]->MDoubles){
							for($b=1; $b<=$lines[2]->MDoubles; $b++)
							{
								$data = array(
								'Tourn_match_id'	=> $tour_match_id,
								'Tourn_ID'			=> $tourn_id,
								'BracketID'			=> $bracket_id,
								'Line_num'			=> $b,
								'Draw_Type'			=> $bracket_type,
								'Match_Type'		=> 'MDoubles',
								);

							$ins_to = $this->db->insert('Tournament_Lines', $data);
							}
						}

						if($lines[3]->WDoubles){
							for($b=1; $b<=$lines[3]->WDoubles; $b++)
							{
								$data = array(
								'Tourn_match_id'	=> $tour_match_id,
								'Tourn_ID'			=> $tourn_id,
								'BracketID'			=> $bracket_id,
								'Line_num'			=> $b,
								'Draw_Type'			=> $bracket_type,
								'Match_Type'		=> 'WDoubles',
								);

							$ins_to = $this->db->insert('Tournament_Lines', $data);
							}
						}

						if($lines[4]->Mixed){
							for($b=1; $b<=$lines[4]->Mixed; $b++)
							{
								$data = array(
								'Tourn_match_id'	=> $tour_match_id,
								'Tourn_ID'			=> $tourn_id,
								'BracketID'			=> $bracket_id,
								'Line_num'			=> $b,
								'Draw_Type'			=> $bracket_type,
								'Match_Type'		=> 'Mixed',
								);

							$ins_to = $this->db->insert('Tournament_Lines', $data);
							}
						}


						if($lines[5]->OSingles){
							for($b=1; $b<=$lines[5]->OSingles; $b++)
							{
								$data = array(
								'Tourn_match_id'	=> $tour_match_id,
								'Tourn_ID'			=> $tourn_id,
								'BracketID'			=> $bracket_id,
								'Line_num'			=> $b,
								'Draw_Type'			=> $bracket_type,
								'Match_Type'		=> 'OSingles',
								);

							$ins_to = $this->db->insert('Tournament_Lines', $data);
							}
						}

						if($lines[6]->ODoubles){
							for($b=1; $b<=$lines[6]->ODoubles; $b++)
							{
								$data = array(
								'Tourn_match_id'	=> $tour_match_id,
								'Tourn_ID'			=> $tourn_id,
								'BracketID'			=> $bracket_id,
								'Line_num'			=> $b,
								'Draw_Type'			=> $bracket_type,
								'Match_Type'		=> 'ODoubles',
								);

							$ins_to = $this->db->insert('Tournament_Lines', $data);
							}
						}

					}												// Team League Line Matches Creation

					unset($player1_partner);
					unset($player2_partner);
				}
			}
			
// Consolation Draw Save Section Starts here ---------------------------------------------------------------------------------------------------

			if($bracket_type == 'Consolation'){

			$c_rounds  = $this->input->post('c_round');
			$c_matches = $this->input->post('c_match_num');
			$c_player1 = $this->input->post('c_player1');
			$c_player2 = $this->input->post('c_player2');


			$c_player1_score = "";
			$c_player2_score = "";
			$c_winner  = "";
			$c_win_per = "";

			 foreach($c_rounds as $c_round)
			{
					//echo $round."<br>";
				foreach($c_matches[$c_round] as $c_match)
				{
					$c_player1_score = "";
					$c_player2_score = "";
					$c_winner  = "";
					$c_win_per = "";


					$date_cround = $this->input->post('cround_date'.$c_round);
					$date_cmatch = $this->input->post('cmatch_date'.$c_match);
					$cons_assg_court  = $this->input->post('cons_assg_court'.$c_match);
				//($date_cround) ? $c_match_due_date = date("Y-m-d",strtotime($date_cround)) : $c_match_due_date = date("Y-m-d",strtotime($date_cmatch)); 

					$c_match_due_date = "";

					if($date_cround != "") {
						$c_match_due_date = date("Y-m-d H:i",strtotime($date_cround));
					} 
					else if($date_cmatch != "") {
						$c_match_due_date = date("Y-m-d H:i",strtotime($date_cmatch)); 
					}

					$cons_assg_match_court = NULL;

					if($cons_assg_court != "") {
						$cons_assg_match_court = $cons_assg_court;
					} 


					if($c_player1[$c_round][$c_match][0] == "")
					{
						$c_player1_val = "";
					}
					else
					{
						$c_player1_val		= intval($c_player1[$c_round][$c_match][0]);
						$c_player1_partner	= explode("-", $c_player1[$c_round][$c_match][0]);
					}


					if($c_player2[$c_round][$c_match][0] == "")
					{ 
						$c_player2_val = "";
					}
					else if($c_player2[$c_round][$c_match][0] == 0)
					{
						$c_player2_val	 = "";
						$c_player1_score = '';
						$c_player2_score = '';
						$c_winner  = intval($c_player1[$c_round][$c_match][0]);
						$c_win_per = 0;
					}
					else
					{
						$c_player2_val		= intval($c_player2[$c_round][$c_match][0]);
						$c_player2_partner	= explode("-", $c_player2[$c_round][$c_match][0]);
					}

					$c_player1_source = $c_player1[$c_round][$c_match][1];
					$c_player2_source = $c_player2[$c_round][$c_match][1];

					if($c_match_due_date == ""){
					$data = array(
						'BracketID' => $bracket_id,
						'Tourn_ID'	=> $tourn_id,
						'Round_Num' => $c_round,
						'Match_Num' => $c_match,
						'Player1' => $c_player1_val,
						'Player2' => $c_player2_val,
						'Player1_Score' => $c_player1_score,
						'Player2_Score' => $c_player2_score,
						'Winner'	=> $c_winner,
						'Win_Per'	=> $c_win_per,
						'Player1_source' => $c_player1_source,
						'Player2_source' => $c_player2_source,
						'Player1_Partner' => intval($c_player1_partner[1]),
						'Player2_Partner' => intval($c_player2_partner[1]),
						'Draw_Type' => 'Consolation',
						'Court_Info' => $cons_assg_match_court
					);
					} else {

						$data = array(
							'BracketID' => $bracket_id,
							'Tourn_ID'	=> $tourn_id,
							'Round_Num' => $c_round,
							'Match_Num' => $c_match,
							'Player1' => $c_player1_val,
							'Player2' => $c_player2_val,
							'Player1_Score' => $c_player1_score,
							'Player2_Score' => $c_player2_score,
							'Winner'	=> $c_winner,
							'Win_Per'	=> $c_win_per,
							'Player1_source' => $c_player1_source,
							'Player2_source' => $c_player2_source,
							'Player1_Partner' => intval($c_player1_partner[1]),
							'Player2_Partner' => intval($c_player2_partner[1]),
							'Draw_Type' => 'Consolation',
							'Match_DueDate' => $c_match_due_date,
							'Court_Info' => $cons_assg_match_court
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
		

		public function update_tourn_dates(){
			/*echo "Single Elimation Draw";
			echo "<pre>";
			print_r($_POST);
			exit;*/

			$r1_match_count = $this->input->post('mcn');
			$tour_id		= $this->input->post('tour_id');
			$bracket_id		= $this->input->post('bracket_id');

			if($r1_match_count){
				$invalid	= 0;
				$p1_p_array	= array();
				$p2_p_array	= array();

				for($i = 1; $i <= $r1_match_count; $i++){
					$player1_partner = '-1';
					$player2_partner = '-1';

					$player1		 = $this->input->post("p1_{$i}");
					if($this->input->post("p1_p_{$i}")){
						$player1_partner = $this->input->post("p1_p_{$i}");
						$p1_p_array[]	 = $player1_partner;
					}

					$player2		 = $this->input->post("p2_{$i}");
					if($this->input->post("p2_p_{$i}")){
						$player2_partner = $this->input->post("p2_p_{$i}");
						$p2_p_array[]	 = $player2_partner;
					}

					if(($player1 == $player2)
					or ($player1 == '0' and $player2 == '0')
					or ($player1 == '' or $player2 == '')
					or ($player1_partner == $player2_partner and $player1_partner != '-1' and $player2_partner != '-1')
					or ($player1_partner == '0' and $player2_partner == '0')){
					//or ($player1_partner == '' and $player2_partner == '')){

						$invalid = 1;
					}
					$p1_array[] = $player1;
					$p2_array[] = $player2;
				}
						/*echo "<pre>";
						echo $invalid;
						print_r($p1_array);
						print_r($p2_array);
						print_r($p1_p_array);
						print_r($p2_p_array);*/

						$p1_dupe_array = array();
						$p2_dupe_array = array();

						$p1_has_dup = 0;
						$p2_has_dup = 0;

						foreach ($p1_array as $val){
							if($val != 0){
								if(++$p1_dupe_array[$val] > 1){
									$p1_has_dup = 1;
								}
								if(in_array($val, $p2_array) or in_array($val, $p1_p_array) or in_array($val, $p2_p_array)){
									$p1_has_dup = 1;
								}
							}
						}

						foreach ($p2_array as $val){
							if($val != 0){
								if(++$p2_dupe_array[$val] > 1){
									$p2_has_dup = 1;
								}
								if(in_array($val, $p1_array) or in_array($val, $p1_p_array) or in_array($val, $p2_p_array)){
									$p2_has_dup = 1;
								}
							}
						}
						//exit;

					if($invalid or $p1_has_dup or $p2_has_dup){
						echo "Incorrect assigning of Players!";
						exit;
					}
					else{
						$valid_matches_having_players = array();
						for($i=1; $i<=$r1_match_count; $i++){
							$player1 = $this->input->post("p1_{$i}");
							$player2 = $this->input->post("p2_{$i}");
							
							$player1_partner = 0;
							if($this->input->post("p1_p_{$i}") and $player1){
							 $player1_partner = $this->input->post("p1_p_{$i}");
							}
							$player2_partner = 0;
							if($this->input->post("p2_p_{$i}") and $player2){
							 $player2_partner = $this->input->post("p2_p_{$i}");
							}

							$winner = 0;
							$player1_score = '';
							$player2_score = '';

							if($player1 == 0){
								$winner			= $player2;
								$winner_partner = $player2_partner;
								$player1_score	= 'Bye Match';
								$player2_score	= 'Bye Match';
							}
							else if($player2 == 0){
								$winner			= $player1;
								$winner_partner = $player1_partner;
								$player1_score	= 'Bye Match';
								$player2_score	= 'Bye Match';
							}
							
							$data = array(
									'Player1' => $player1,
									'Player2' => $player2,
									'Winner'  => $winner,
									'Player1_Score' => $player1_score,
									'Player2_Score' => $player2_score,
									'Player1_Partner' => $player1_partner,
									'Player2_Partner' => $player2_partner,
									);

							//echo "<pre>";
							//print_r($data);
							$this->db->where('Tourn_ID', $tour_id);
							$this->db->where('BracketID', $bracket_id);
							$this->db->where('Round_Num', '1');
							$this->db->where('Match_Num', $i);
							$this->db->where('Draw_Type', 'Main');
							$result = $this->db->update('Tournament_Matches', $data);

							if($winner != 0){
								$a = $i + ($r1_match_count - floor($i/2));
								$valid_matches_having_players[] = $a;

								$qry_check = $this->db->query("SELECT * FROM Tournament_Matches WHERE Tourn_ID = $tour_id AND BracketID = $bracket_id AND (Player1_source = $i OR Player2_source = $i) AND Draw_Type = 'Main'");
								//echo $qry_check->num_rows();

								if($qry_check->num_rows() > 0){
									$winner_dest = $qry_check->row_array();

									if($winner_dest['Player1_source'] == $i){
										$qry_check = $this->db->query("UPDATE Tournament_Matches SET Player1 = $winner, Player1_Partner = $winner_partner WHERE Tourn_match_id = $winner_dest[Tourn_match_id]");
												//echo $this->db->last_query();
									}
									else if($winner_dest['Player2_source'] == $i){
										$qry_check = $this->db->query("UPDATE Tournament_Matches SET Player2 = $winner, Player2_Partner = $winner_partner WHERE Tourn_match_id = $winner_dest[Tourn_match_id]");
												//echo $this->db->last_query();
									}
								}
							}
							else{
								$valid_matches_having_players[] = $i;
								$qry_check = $this->db->query("SELECT * FROM Tournament_Matches WHERE Tourn_ID = $tour_id AND BracketID = $bracket_id AND (Player1_source = $i OR Player2_source = $i) AND Draw_Type = 'Main'");
								//echo $qry_check->num_rows();

								if($qry_check->num_rows() > 0){
									$winner_dest = $qry_check->row_array();

									if($winner_dest['Player1_source'] == $i){
										$qry_check = $this->db->query("UPDATE Tournament_Matches SET Player1 = 0, Player1_Partner = 0 WHERE Tourn_match_id = $winner_dest[Tourn_match_id]");
												//echo $this->db->last_query();
									}
									else if($winner_dest['Player2_source'] == $i){
										$qry_check = $this->db->query("UPDATE Tournament_Matches SET Player2 = 0, Player2_Partner = 0 WHERE Tourn_match_id = $winner_dest[Tourn_match_id]");
												//echo $this->db->last_query();
									}
								}
							}
						}	// end of for loop
						//print_r($valid_matches_having_players);
						for($j=1; $j<=($r1_match_count/2); $j++){

							($j==1) ? $p1_ind = 0 : $p1_ind += 2;
							$p2_ind = $j;

							$p1_source = $valid_matches_having_players[$p1_ind];
							$p2_source = $valid_matches_having_players[($p2_ind*2)-1];

							$con_p1 = $this->input->post("p1_con_{$j}");
							$con_p2 = $this->input->post("p2_con_{$j}");

							if($p1_source == $p2_source){ $p2_source = 0; }							
								//echo $p1_source." ".$p2_source;	
								$qry_check = $this->db->query("UPDATE Tournament_Matches SET Player1_source = {$p1_source}, Player2_source = {$p2_source} WHERE Tourn_ID = $tour_id AND BracketID = $bracket_id AND Round_Num = 1 AND Match_Num = {$j} AND Draw_Type = 'Consolation'");
						}
					}
				echo "Draws Updated successfully.";
			}
			else
			{
				echo "Something went wrong! Please try again.";
				exit;
			}

			$rounds		= $this->input->post('round');
			$matches	= $this->input->post('match_num');


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
		}


		public function update_con_tourn_dates()
		{
			/*echo "Consolation Draw";
			echo "<pre>";
			print_r($_POST);
			exit;*/

			$r1_match_count = $this->input->post('mcn');
			$tour_id		= $this->input->post('tour_id');
			$bracket_id		= $this->input->post('bracket_id');

			if($r1_match_count){
				$invalid = 0;
				$p1_p_con_array	= array();
				$p2_p_con_array	= array();

					/* **************************** */
					for($i=1; $i<=$r1_match_count/2; $i++){
						$player1_partner = '-1';
						$player2_partner = '-1';

						$player1 = $this->input->post("p1_con_{$i}");
						if($this->input->post("p1_p_con_{$i}")){
						$player1_partner = $this->input->post("p1_p_con_{$i}");
						$p1_p_con_array[] = $player1_partner;
						}
						$player2 = $this->input->post("p2_con_{$i}");
						if($this->input->post("p2_p_con_{$i}")){
						$player2_partner = $this->input->post("p2_p_con_{$i}");
						$p2_p_con_array[] = $player2_partner;
						}

						//echo $player1_partner; echo $player2_partner; echo "<br>";

						if(($player1 == $player2) 
						or ($player1 == '0' and $player2 == '0') 
						or ($player1 == '' or $player2 == '')
						or ($player1_partner == $player2_partner and ($player1_partner > 0) and ($player2_partner > 0))
						or ($player1_partner == '0' and $player2_partner == '0')
						or ($player1_partner == '' or $player2_partner == '')){
							$invalid = 1;
						}
						$p1_con_array[] = $player1;
						$p2_con_array[] = $player2;
						/*echo "<pre>";
						print_r($p1_con_array);
						print_r($p2_con_array);
						print_r($p1_p_con_array);
						print_r($p2_p_con_array);*/
						
					}

					$p1_dupe_array = array();
					$p2_dupe_array = array();

					$p1_con_has_dup = 0;
					$p2_con_has_dup = 0;

					foreach ($p1_con_array as $val){
						if($val != 0){
							if(++$p1_dupe_array[$val] > 1){
								$p1_con_has_dup = 1;
							}
							if(in_array($val, $p2_con_array) or in_array($val, $p1_p_con_array) or in_array($val, $p2_p_con_array)){
								$p1_con_has_dup = 1;
							}
						}
					}

					foreach ($p2_con_array as $val){
						if($val != 0){
							if(++$p2_dupe_array[$val] > 1){
								$p2_con_has_dup = 1;
							}
							if(in_array($val, $p1_con_array) or in_array($val, $p1_p_con_array) or in_array($val, $p2_p_con_array)){
								$p2_con_has_dup = 1;
							}
						}
					}
					/* ********************************** */
					//echo $invalid; exit;
					//exit;
					if($invalid or $p1_con_has_dup or $p2_con_has_dup){
						echo "Incorrect assigning of Players!";
						exit;
					}
					else{

						//print_r($valid_matches_having_players);
						//exit;
						for($j=1; $j<=($r1_match_count/2); $j++){

							$con_p1 = $this->input->post("p1_con_{$j}");
							$con_p1_p = $this->input->post("p1_p_con_{$j}");

							$con_p2 = $this->input->post("p2_con_{$j}");
							$con_p2_p = $this->input->post("p2_p_con_{$j}");

							if(!$con_p1_p){ $con_p1_p = 0; }
							if(!$con_p2_p){ $con_p2_p = 0; }

							$winner = 0;
							$player1_score = '';
							$player2_score = '';
							
							$qry = '';
							if($con_p1 == 0 and $con_p2 != 0){
								$winner			= $con_p2;
								$winner_partner = $con_p2_p;
								$player1_score	= 'Bye Match';
								$player2_score	= 'Bye Match';

							$qry = ", Winner = $winner, Player1_Score = '$player1_score', Player2_Score = '$player2_score'";
							}
							else if($con_p2 == 0 and $con_p1 != 0){
								$winner			= $con_p1;
								$winner_partner = $con_p1_p;
								$player1_score	= 'Bye Match';
								$player2_score	= 'Bye Match';

							$qry = ", Winner = $winner, Player1_Score = '$player1_score', Player2_Score = '$player2_score'";
							}

							//if($p1_source == $p2_source){ $p2_source = 0; }							
								//echo $p1_source." ".$p2_source;	
								$qry_upd = $this->db->query("UPDATE Tournament_Matches SET Player1 = {$con_p1}, Player2 = {$con_p2}, Player1_Partner = {$con_p1_p}, Player2_Partner = {$con_p2_p} {$qry} WHERE Tourn_ID = $tour_id AND BracketID = $bracket_id AND Round_Num = 1 AND Match_Num = {$j} AND Draw_Type = 'Consolation'");
								//echo $this->db->last_query();
								//echo "<br>";

								if($winner != 0){
								/*$a = $i + ($r1_match_count - floor($i/2));
								$valid_matches_having_players[] = $a;*/

								$qry_check = $this->db->query("SELECT * FROM Tournament_Matches WHERE Tourn_ID = $tour_id AND BracketID = $bracket_id AND (Player1_source = $j OR Player2_source = $j) AND Draw_Type = 'Consolation'");
								//echo $qry_check->num_rows();

									if($qry_check->num_rows() > 0){
										$winner_dest = $qry_check->row_array();

										if($winner_dest['Player1_source'] == $j){
											$qry_check = $this->db->query("UPDATE Tournament_Matches SET Player1 = $winner, Player1_Partner = $winner_partner WHERE Tourn_match_id = $winner_dest[Tourn_match_id]");
													//echo $this->db->last_query();
										}
										else if($winner_dest['Player2_source'] == $j){
											$qry_check = $this->db->query("UPDATE Tournament_Matches SET Player2 = $winner, Player2_Partner = $winner_partner WHERE Tourn_match_id = $winner_dest[Tourn_match_id]");
													//echo $this->db->last_query();
										}
									}
								}
						}
						//exit;
					}
				echo "Draws Updated successfully.";
			}
			else
			{
				echo "Something went wrong! Please try again.";
				exit;
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
					//echo "<br>".$this->db->last_query();
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
			$query = $this->db->get_where('Brackets', $data);

			if ($query->num_rows() > 0){
				return 1;
			}
			else{
				return 0;
			}
		}
		
		public function get_tourn_bracket($bid)
		{
			$data  = array('BracketID' => $bid);
			$query = $this->db->get_where('Brackets', $data);

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

			$data1 = array('BracketID' => $bracket_id);
					if($data['reg_page'] != "My_Matches"){
					 $this->db->order_by('Round_Num','ASC');
					}
					 $this->db->order_by('Match_DueDate','ASC');
			$query = $this->db->get_where('Tournament_Matches', $data1);

			return $query;
		}

		public function get_cl_matches($data)
		{
			$bracket_id = $data['bracket_id'];

			$data1 = array('BracketID' => $bracket_id);
					 $this->db->order_by('Tourn_match_id','ASC');
			$query = $this->db->get_where('Tournament_Matches', $data1);

			return $query;
		}

		public function get_sd_matches($data)
		{
			$bracket_id = $data['bracket_id'];

			$data1 = array('BracketID' => $bracket_id);
					 $this->db->order_by('Tourn_match_id','ASC');
			$query = $this->db->get_where('Tournament_Matches', $data1);

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

		public function get_po_tourn_matches($bid)
		{
			$data = array('BracketID' => $bid);
			$query = $this->db->get_where('Tournament_Matches',$data);

			return $query;
		}

		public function get_po_line_matches($bracket_id)
		{
			$data = array('BracketID' => $bracket_id);
			$query = $this->db->get_where('Tournament_Lines',$data);

			return $query;
		}

		public function get_cd_tot_rounds($bid)
		{
			$bracket_id = $bid;

			$qry_check = $this->db->query("SELECT COUNT(DISTINCT Round_Num) AS total_rounds FROM Tournament_Matches WHERE BracketID = {$bracket_id} AND Draw_Type = 'Consolation'");

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

		public function update_cl_tourn_match_score()
		{
			//$tourn_id = $data['tourn_id']; 
			$tourn_id		= $this->input->post('tourn_id');
			$tourn_match_id = $this->input->post('tourn_match_id');

			//$draw_name = $this->input->post('draw_name');
			$round = $this->input->post('round_title');
			$match_date = date('Y-m-d' ,strtotime($this->input->post('match_date')));

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

			$data		   = array('CH_Id' => $match_num);
			$cl_challenge  = $this->db->get_where('CL_Challenges', $data);
			$cl_data	   = $cl_challenge->row_array();

			$challenged_by = $cl_data['Challenged_by'];

			$qry_bracket = $this->db->query("SELECT * FROM Brackets WHERE BracketID = {$bracket_id}");
			$get_backet  = $qry_bracket->row_array();

			if($get_backet){
				if($get_backet['Draw_Format'] == 'singles'){
					$mformat = "Singles";
				}
				else if($get_backet['Draw_Format'] == 'doubles'){
					$mformat = "Doubles";
				}
				else if($get_backet['Draw_Format'] == 'mixed'){
					$mformat = "Mixed";
				}
				else{
					$mformat = $this->calculate_match_format($player1_user, $player1_partner);
				}
			}
			else{
				$mformat = $this->calculate_match_format($player1_user, $player1_partner);
			}

		/* ------------------- A2MScore Calculation Section ---------------- */
		$player1_a2mscore	= $this->get_a2mscore($player1_user, $match_sport, $mformat);
		$player2_a2mscore	= $this->get_a2mscore($opp_user, $match_sport, $mformat);

		$player1_part_a2mscore	= "";
		$player2_part_a2mscore	= "";

			if($player1_partner or $opp_user_partner){			// If the Tournament is Double format
				$player1_part_a2mscore	= $this->get_a2mscore($player1_partner, $match_sport, $mformat);
				$player2_part_a2mscore	= $this->get_a2mscore($opp_user_partner, $match_sport, $mformat);
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

		/* --------------- Evaluate Winner -------------- */
			$eval_winner	= $this->evaluate_winner($player1_user, $opp_user, $player1_partner, $opp_user_partner, $player1_sets_win, $player2_sets_win, $player1_score_total, $player2_score_total);

			$winner				= $eval_winner['Winner'];
			$winner_partner		= $eval_winner['Winner_Partner'];
			$looser				= $eval_winner['Looser'];
			$looser_partner		= $eval_winner['Looser_Partner'];

			/*$p1_points			= $eval_winner['P1_Points'];
			$p2_points			= $eval_winner['P2_Points'];*/

			
		/* --------------- Evaluate Winner -------------- */

		/* --------------- Evaluate CH Points -------------- */

		 if($player1_user == $challenged_by){
			if($player1_user == $winner){
				$p1_points = 10;
				$p2_points = 3;
			}
			else{
				$p1_points = 5;
				$p2_points = 7;
			}
		 }
		 else if($opp_user == $challenged_by){
			if($opp_user == $winner){
				$p1_points = 3;
				$p2_points = 10;
			}
			else{
				$p1_points = 7;
				$p2_points = 5;
			}
		 }

		/* --------------- Evaluate CH Points -------------- */


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

			//$winner_a2mscore_updated		=   intval($winner_add_score_points) +  intval($winner_win_points);
			$winner_a2mscore_updated			=   intval($winner_add_score_points);
			//$winner_part_a2mscore_updated	=   intval($winner_part_add_score_points) +  intval($winner_part_win_points);
			$winner_part_a2mscore_updated	=   intval($winner_part_add_score_points);

			$looser_a2mscore_updated		=  - intval($winner_add_score_points) +  intval($looser_win_points);
			$looser_part_a2mscore_updated	=  - intval($winner_part_add_score_points) +  intval($looser_part_win_points);

			if($match_sport == 7){
				$winner_exc_points = $this->calc_picball_addscore_points($winner_a2m_diff, $winner, $max_a2m_player);
				$winner_partner_exc_points = $this->calc_picball_addscore_points($winner_part_a2m_diff, $winner_partner, $max_a2m_partner); 

				$winner_a2mscore_updated			= $winner_exc_points;
				$winner_part_a2mscore_updated	= $winner_exc_points;

				$looser_a2mscore_updated			= -$winner_exc_points;
				$looser_part_a2mscore_updated	= -$winner_exc_points;
			}

			// A2MScore Table Update 
			$this->a2mscore_update($winner, $winner_a2mscore_updated, $match_sport, $mformat);
			$this->a2mscore_update($winner_partner, $winner_part_a2mscore_updated, $match_sport, $mformat);

			$this->a2mscore_update($looser, $looser_a2mscore_updated, $match_sport, $mformat);
			$this->a2mscore_update($looser_partner, $looser_part_a2mscore_updated, $match_sport, $mformat);

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

			//$winner_a2mscore_updated =   intval($winner_add_score_points) + intval($winner_win_points);
			$winner_a2mscore_updated =   intval($winner_add_score_points);
			$looser_a2mscore_updated = - intval($winner_add_score_points) + intval($looser_win_points);

			if($match_sport == 7){
				$winner_exc_points = $this->calc_picball_addscore_points($winner_a2m_diff, $winner, $max_a2m_player);

				$winner_a2mscore_updated = $winner_exc_points;
				$looser_a2mscore_updated = -$winner_exc_points;
			}

			// A2MScore Table Update 
			$this->a2mscore_update($winner, $winner_a2mscore_updated, $match_sport, $mformat);
			$this->a2mscore_update($looser, $looser_a2mscore_updated, $match_sport, $mformat);
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
		/*if($winner == $player1_user){
			$p1_points = 10;
			$p2_points = 5;
		}
		else if($winner == $opp_user){
			$p1_points = 7;
			$p2_points = 3;
		}*/

		$data = array(
				'Match_Date'	 => $match_date,
				'Player1_Score'  => $player1_score,
				'Player2_Score'  => $player2_score,
				'Player1_points' => $p1_points,
				'Player2_points' => $p2_points,
				'Winner'		 => $winner
			);

		$this->db->where('Tourn_match_id', $tourn_match_id);
		$result = $this->db->update('Tournament_Matches', $data); 

		/* ------------------------------------------------------------------------------- */

			/*$data = array('player1'=>$player1_user, 'player2'=>$opp_user, 'player1_partner'=>$player1_partner, 
				'player2_partner'=>$player2_partner, 'winner' => $winner, 'round_title' => $round,	'tourn_id'=>$tourn_id, 'player1_score'=>$player1_score, 'player2_score'=>$player2_score, 'type'=>'cl');*/

			$p_pos  = $this->get_cl_user_position($bracket_id, $opp_user);
			$ch_pos = $this->get_cl_user_position($bracket_id, $player1_user);

			$data = array('bracket_id'	 => $bracket_id,
						'match_num'		 => $match_num,
						'player'		 => $opp_user,
						'player_partner' => $player2_partner,
						'challeger'		 => $player1_user,
						'challeger_partner'	=> $player1_partner,
						'p_pos'			 => $p_pos,
						'ch_pos'		 => $ch_pos,
						'winner'		 => $winner,
						'winner_partner' => $winner_partner			
					);

			return $data;
		}


		public function update_rr_tourn_match_score()
		{
			//$tourn_id = $data['tourn_id']; 
			$tourn_id			 = $this->input->post('tourn_id');
			$tourn_match_id = $this->input->post('tourn_match_id');

			//$draw_name = $this->input->post('draw_name');
			$round = $this->input->post('round_title');

			$data				= array('tournament_ID' => $tourn_id);
			$macth_init			= $this->db->get_where('tournament', $data);
			$match_init_user	= $macth_init->row_array();

			$player1_user		= $this->input->post('player1_user');
			$player1_partner	= $this->input->post('player1_user_partner');

			$opp_user				= $this->input->post('player2_user');
			$opp_user_partner	= $this->input->post('player2_user_partner');

			$match_sport		= $match_init_user['SportsType'];

			$bracket_id			= $this->input->post('bracket_id');
			$match_num			= $this->input->post('match_num');

			$qry_bracket = $this->db->query("SELECT * FROM Brackets WHERE BracketID = {$bracket_id}");
			$get_backet  = $qry_bracket->row_array();

			if($get_backet){
				if($get_backet['Draw_Format'] == 'singles'){
					$mformat = "Singles";
				}
				else if($get_backet['Draw_Format'] == 'doubles'){
					$mformat = "Doubles";
				}
				else if($get_backet['Draw_Format'] == 'mixed'){
					$mformat = "Mixed";
				}
				else{
					$mformat = $this->calculate_match_format($player1_user, $player1_partner);
				}
			}
			else{
				$mformat = $this->calculate_match_format($player1_user, $player1_partner);
			}

		/* ------------------- A2MScore Calculation Section ---------------- */
		$player1_a2mscore	= $this->get_a2mscore($player1_user, $match_sport, $mformat);
		$player2_a2mscore	= $this->get_a2mscore($opp_user, $match_sport, $mformat);

		$player1_part_a2mscore	= "";
		$player2_part_a2mscore	= "";

			if($player1_partner or $opp_user_partner){			// If the Tournament is Double format
				$player1_part_a2mscore	= $this->get_a2mscore($player1_partner, $match_sport, $mformat);
				$player2_part_a2mscore	= $this->get_a2mscore($opp_user_partner, $match_sport, $mformat);
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

			//$winner_a2mscore_updated		=   intval($winner_add_score_points) +  intval($winner_win_points);
			$winner_a2mscore_updated			=   intval($winner_add_score_points);
			//$winner_part_a2mscore_updated	=   intval($winner_part_add_score_points) +  intval($winner_part_win_points);
			$winner_part_a2mscore_updated	=   intval($winner_part_add_score_points);

			$looser_a2mscore_updated		=  - intval($winner_add_score_points) +  intval($looser_win_points);
			$looser_part_a2mscore_updated	=  - intval($winner_part_add_score_points) +  intval($looser_part_win_points);

			if($match_sport == 7){
				$winner_exc_points = $this->calc_picball_addscore_points($winner_a2m_diff, $winner, $max_a2m_player);
				$winner_partner_exc_points = $this->calc_picball_addscore_points($winner_part_a2m_diff, $winner_partner, $max_a2m_partner); 

				$winner_a2mscore_updated			= $winner_exc_points;
				$winner_part_a2mscore_updated	= $winner_exc_points;

				$looser_a2mscore_updated			= -$winner_exc_points;
				$looser_part_a2mscore_updated	= -$winner_exc_points;
			}

			// A2MScore Table Update 
			$this->a2mscore_update($winner, $winner_a2mscore_updated, $match_sport, $mformat);
			$this->a2mscore_update($winner_partner, $winner_part_a2mscore_updated, $match_sport, $mformat);

			$this->a2mscore_update($looser, $looser_a2mscore_updated, $match_sport, $mformat);
			$this->a2mscore_update($looser_partner, $looser_part_a2mscore_updated, $match_sport, $mformat);

			$this->update_player_standings($winner, $tourn_id, $bracket_id, $winner_a2mscore_updated);
			$this->update_player_standings($winner_partner, $tourn_id, $bracket_id, $winner_part_a2mscore_updated);
			$this->update_player_standings($looser, $tourn_id, $bracket_id, $looser_a2mscore_updated);
			$this->update_player_standings($looser_partner, $tourn_id, $bracket_id, $looser_part_a2mscore_updated);

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

			//$winner_a2mscore_updated	=   intval($winner_add_score_points) +  intval($winner_win_points);
			$winner_a2mscore_updated	=   intval($winner_add_score_points);
			$looser_a2mscore_updated	=  - intval($winner_add_score_points) +  intval($looser_win_points);

			if($match_sport == 7){
				$winner_exc_points = $this->calc_picball_addscore_points($winner_a2m_diff, $winner, $max_a2m_player);

				$winner_a2mscore_updated = $winner_exc_points;
				$looser_a2mscore_updated = -$winner_exc_points;
			}

			// A2MScore Table Update 
			$this->a2mscore_update($winner, $winner_a2mscore_updated, $match_sport, $mformat);
			$this->a2mscore_update($looser, $looser_a2mscore_updated, $match_sport, $mformat);

			$this->update_player_standings($winner, $tourn_id, $bracket_id, $winner_a2mscore_updated);
			$this->update_player_standings($looser, $tourn_id, $bracket_id, $looser_a2mscore_updated);
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

	/*echo "<pre>";
	print_r($data);
	exit;*/

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
						
			//$p1_a2mscore_updated =  intval($player1_a2mscore) +  intval($add_score_points) +  intval($add_win_points_p1);
			$p1_a2mscore_updated =  intval($player1_a2mscore) +  intval($add_score_points);
			$p2_a2mscore_updated =  intval($player2_a2mscore) -  intval($add_score_points) +  intval($add_win_points_p2);

		} 
		else {
			
			$p1_a2mscore_updated =  intval($player1_a2mscore) -  intval($add_score_points) +  intval($add_win_points_p1);
			$p2_a2mscore_updated =  intval($player2_a2mscore) +  intval($add_score_points);
			//$p2_a2mscore_updated =  intval($player2_a2mscore) +  intval($add_score_points) +  intval($add_win_points_p2);
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

				//$data = array ('A2MScore' => $p1_a2mscore_updated);
				
				//$this->db->where('Users_ID', $player1_user);
				//$this->db->where('SportsType_ID', $match_sport);

			//$a2mscore_upd_qry1 = $this->db->update('A2MScore', $data);

				//$data = array ('A2MScore' => $p2_a2mscore_updated);
				
				//$this->db->where('Users_ID', $opp_user);
				//$this->db->where('SportsType_ID', $match_sport);

			//$a2mscore_upd_qry2 = $this->db->update('A2MScore', $data);

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


		public function get_a2mscore($user, $sport, $mformat=''){

			$data					= array('SportsType_ID'=>$sport, 'Users_ID'=>$user);
			$qry_a2mscore	= $this->db->get_where('A2MScore',$data);
			$qry_fetch			= $qry_a2mscore->row_array();

			if($mformat == 'Singles'){
			$user_a2mscore	= $qry_fetch['A2MScore'];
			}
			elseif($mformat == 'Doubles'){
			$user_a2mscore	= $qry_fetch['A2MScore_Doubles'];
			}
			elseif($mformat == 'Mixed'){
			$user_a2mscore	= $qry_fetch['A2MScore_Mixed'];
			}
			else{
			$user_a2mscore	= $qry_fetch['A2MScore'];
			}

			return $user_a2mscore;
		}

		public function get_team_a2mscore($team, $sport){

			$data			= array('Sport' => $sport, 'Team_ID' => $team);
			$qry_a2mscore	= $this->db->get_where('A2MTeamScore', $data);
			$qry_fetch		= $qry_a2mscore->row_array();

			$team_a2mscore	= $qry_fetch['A2MTeamScore'];

			return $team_a2mscore;
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


		/*public function get_a2m_diff($player1_user, $opp_user, $player1_a2mscore, $player1_part_a2mscore, 
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
		}*/

		public function get_a2m_diff($player1_user, $opp_user, $player1_a2mscore, $player1_part_a2mscore, 
			$player2_a2mscore, $player2_part_a2mscore, $winner){

					$p1_avg	=  ($player1_a2mscore + $player1_part_a2mscore) / 2;
					$p2_avg	=  ($player2_a2mscore + $player2_part_a2mscore) / 2;

					$winner_a2m_diff	=  abs($p1_avg - $p2_avg);

		$data = array('winner_a2m_diff'		 => $winner_a2m_diff, 
					  'winner_part_a2m_diff' => $winner_a2m_diff);
//echo "winner_a2m_diff = ".$winner_a2m_diff;
//echo "<br>";
			return $data;
		}

		public function get_max_a2m_players($player1_user, $player1_partner, $opp_user, $opp_user_partner, $player1_a2mscore, $player1_part_a2mscore, $player2_a2mscore, $player2_part_a2mscore){
			
			$p1_a2m = $player1_a2mscore + $player1_part_a2mscore;
			$p2_a2m = $player2_a2mscore + $player2_part_a2mscore;

			if($p1_a2m >= $p2_a2m){
				$max_a2m_player   = $player1_user;
				$max_a2m_partner = $player1_partner;
			}
			else{
				$max_a2m_player   = $player2_user;
				$max_a2m_partner = $player2_partner;
			}

			$data = array('max_a2m_player'	=> $max_a2m_player, 
					  'max_a2m_partner' => $max_a2m_partner);

		return $data;
		
		}

		public function get_max_a2m_players_OLD($player1_user, $player1_partner, $opp_user, $opp_user_partner, $player1_a2mscore, $player1_part_a2mscore, $player2_a2mscore, $player2_part_a2mscore){


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

			$i = 0;
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

					//$player1_score .= "$p1_score_post[$s1]";
					$player1_score		 .= intval($p1_score_post[$s1]);
					$player1_score_total += intval($p1_score_post[$s1]);
					++$i;		
				}
			}

			$player1_score .= "]";
		

			$j=0;
			$player2_score = "[";
			$player2_score_total = 0;
			foreach($p2_score_post as $s2 => $set_score) {
				if($set_score!="") {
					if ($j != 0) {
						$player2_score .= ",";
					}

					//$player2_score		 .= "$set_score";
					$player2_score		 .= intval($set_score);
					$player2_score_total += intval($set_score);
					++$j;
				}
			}
			$player2_score .= "]";

			$tot_score = $player1_score_total + $player2_score_total;

			$p1_win_per = number_format( ( ($player1_score_total * 100) / $tot_score), 2);
			$p2_win_per = number_format( ( ($player2_score_total * 100) / $tot_score), 2);

		$data = array('Player1_Score'	=> $player1_score,
					'Player2_Score'		=> $player2_score, 
					'Player1_Tot'		=> $player1_score_total, 
					'Player2_Tot'		=> $player2_score_total, 
					'Tot_Score'			=> $tot_score,
					'Player1_Sets_Win'	=> $player1_sets_win,
					'Player2_Sets_Win'	=> $player2_sets_win,
					'Player1_Win_Per'	=> $p1_win_per,
					'Player2_Win_Per'	=> $p2_win_per);

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

			//echo "cancel_esclating_looser_cons_backup<br>";


				$qry_check_p1 = $this->db->query("SELECT * FROM Tournament_Matches WHERE Round_Num = 1 AND Player1_source = $match_num AND BracketID = $bracket_id AND Draw_Type = 'Consolation'");

						if($qry_check_p1->num_rows() > 0){

						//echo "1st if<br>";
								$xx = $qry_check_p1->row_array();
								$tid = $xx['Tourn_match_id'];
								$qry_upd_p2 = $this->db->query("UPDATE Tournament_Matches SET Player1 = -1, Player1_Partner = -1 WHERE Tourn_match_id = $tid");  // new

								$cd_player2_source = $xx['Player2_source'];
								$cd_player2 = $xx['Player2'];
								$cd_player2_partner = $xx['Player2_Partner'];
								if($cd_player2_source == 0){

						//echo "2nd if<br>";
									$c_date = date('Y-m-d');
									$qry_upd_p2 = $this->db->query("UPDATE Tournament_Matches SET Player1_Score = 'Canceled Match', Player2_Score = 'Canceled Match', Winner = 0, Match_Date = '$c_date' WHERE Tourn_match_id = $tid");

								$mid = $xx['Match_Num'];

								$cd_qry_check_p1 = $this->db->query("SELECT * FROM Tournament_Matches WHERE Round_Num != 1 AND Player1_source = $mid AND BracketID = $bracket_id AND Draw_Type = 'Consolation'");

									if($cd_qry_check_p1->num_rows() > 0)
									{
						//echo "3rd if<br>";
										$xy = $cd_qry_check_p1->row_array();
										$ttid = $xy['Tourn_match_id'];
										
										if($xy['Player2_source'] != 0 and $xy['Player2'] != 0)  // Make the match as bye and escalate the user
										{
						//echo "4th if<br>";
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
						//echo "5th if<br>";
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
						//echo "4th if-else<br>";
											$cd_qry_upd_p2 = $this->db->query("UPDATE Tournament_Matches SET Player1 = -1, Player1_Partner = -1 WHERE Tourn_match_id = $ttid");
										}
									}
									else
									{
						//echo "1st else<br>";
										$cd_qry_check_p2 = $this->db->query("SELECT * FROM Tournament_Matches WHERE Round_Num != 1 AND Player2_source = $mid AND BracketID = $bracket_id AND Draw_Type = 'Consolation'");

											if($cd_qry_check_p2->num_rows() > 0)
											{
						//echo "2nd else if<br>";
												$xy = $cd_qry_check_p2->row_array();
												$ttid = $xy['Tourn_match_id'];
												
												if($xy['Player1_source'] != 0 and $xy['Player1'] != 0)  // Make the match as bye and escalate the user
												{
						//echo "3rd else if<br>";
													$p1 = $xy['Player1'];
													$p1_part = $xy['Player1_Partner'];

													$cd_qry_upd_p2 = $this->db->query("UPDATE Tournament_Matches SET Player2 = 0, Player2_Partner = 0, Player1_Score = 'Bye Match', Player2_Score = 'Bye Match', Winner = $p1, Match_Date = '$c_date' WHERE Tourn_match_id = $ttid");

													$match_num = $xy['Match_Num'];

													/* escalate the winner to next round */
													
														$qry_check_p1 = $this->db->query("SELECT * FROM Tournament_Matches WHERE Round_Num = 3 AND Player1_source = $match_num AND BracketID = $bracket_id AND Draw_Type = 'Consolation'");

														if($qry_check_p1->num_rows() > 0){
						//echo "4th else if<br>";
															$xx = $qry_check_p1->row_array();
															$tid = $xx['Tourn_match_id'];
															$qry_upd_p2 = $this->db->query("UPDATE Tournament_Matches SET Player1 = $p1, Player1_Partner = $p1_part WHERE Tourn_match_id = $tid");
														}
														else{


						//echo "4th else if else<br>";
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
						//echo "ELSE 1st if<br>";

								$xx = $qry_check_p2->row_array();
								$tid = $xx['Tourn_match_id'];
								$qry_upd_p2 = $this->db->query("UPDATE Tournament_Matches SET Player2 = -1, Player2_Partner = -1 WHERE Tourn_match_id = $tid");  // new

								$cd_player2_source = $xx['Player1_source'];
								$cd_player1 = $xx['Player1'];
								$cd_player1_partner = $xx['Player1_Partner'];

								if($cd_player2_source == 0){

						//echo "ELSE 2nd if<br>";
									$c_date = date('Y-m-d');
									$qry_upd_p2 = $this->db->query("UPDATE Tournament_Matches SET Player1_Score = 'Canceled Match', Player2_Score = 'Canceled Match', Winner = 0, Match_Date = '$c_date' WHERE Tourn_match_id = $tid");

								$mid = $xx['Match_Num'];

								$cd_qry_check_p1 = $this->db->query("SELECT * FROM Tournament_Matches WHERE Round_Num != 1 AND Player1_source = $mid AND BracketID = $bracket_id AND Draw_Type = 'Consolation'");

									if($cd_qry_check_p1->num_rows() > 0)
									{

						//echo "ELSE 3rd if<br>";
										$xy = $cd_qry_check_p1->row_array();
										$ttid = $xy['Tourn_match_id'];
										
										if($xy['Player2_source'] != 0 and $xy['Player2'] != 0)  // Make the match as bye and escalate the user
										{

						//echo "ELSE 4th if<br>";
											$p2 = $xy['Player2'];
											$p2_part = $xy['Player2_Partner'];

											$cd_qry_upd_p2 = $this->db->query("UPDATE Tournament_Matches SET Player1 = 0, Player1_Partner = 0, Player1_Score = 'Bye Match', Player2_Score = 'Bye Match', Winner = $p2, Match_Date = '$c_date' WHERE Tourn_match_id = $ttid");

											$match_num = $xy['Match_Num'];

											/* escalate the winner to next round */
											
												$qry_check_p1 = $this->db->query("SELECT * FROM Tournament_Matches WHERE Round_Num = 3 AND Player1_source = $match_num AND BracketID = $bracket_id AND Draw_Type = 'Consolation'");

												if($qry_check_p1->num_rows() > 0){

						//echo "ELSE 5th if<br>";
													$xx = $qry_check_p1->row_array();
													$tid = $xx['Tourn_match_id'];
													$qry_upd_p2 = $this->db->query("UPDATE Tournament_Matches SET Player1 = $p2, Player1_Partner = $p2_part WHERE Tourn_match_id = $tid");
												}
												else{
						//echo "ELSE 6th if<br>";
													$qry_check_p2 = $this->db->query("SELECT * FROM Tournament_Matches WHERE Player2_source = $match_num AND BracketID = $bracket_id AND Draw_Type = '$draw_name'$qry_string");

													if($qry_check_p2->num_rows() > 0){

						//echo "ELSE 7th if<br>";
														$yy = $qry_check_p2->row_array();
														$tid = $yy['Tourn_match_id'];

														$qry_upd_p2 = $this->db->query("UPDATE Tournament_Matches SET Player2 = $p2, Player2_Partner = $p2_part WHERE Tourn_match_id = $tid");
													}
												}

											/* escalate the winner to next round */




										}
										else			// update the match
										{

						//echo "ELSE 8th if<br>";
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

//---------------------- WFF Functionality for PlayOff Draws -----------------
		public function update_team_po_wff()
		{
			$tourn_id		= $this->input->post('tourn_id');
			$tourn_match_id = intval($this->input->post('tourn_match_id'));
			$line_id		= intval($this->input->post('match_line_id'));
			$bracket_id		= intval($this->input->post('bracket_id'));
			$match_num			= $this->input->post('match_num');

			$draw_name		= $this->input->post('draw_name');
			//if($draw_name == "") { $draw_name = "Main"; }

			//$round_title	= $this->input->post('round_title');
			
			$p1			= $this->input->post('player1_user');
			$p1_partner = $this->input->post('player1_user_partner');

			$p2			= $this->input->post('player2_user');
			$p2_partner = $this->input->post('player2_user_partner');

			$winner		= $this->input->post('win_ff_player');

			if($winner == $p1){
				$p1_points  = 3;
				$p2_points  = 0;
				$looser		= $p2;

				$winner_partner = $p1_partner;
				$loser_partner  = $p2_partner;
			}
			else{
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

				// Code to update the Tournament_Matches

			$line_qry1 = $this->db->query("SELECT count(Tourn_line_id) AS lines_have_winner FROM Tournament_Lines WHERE Tourn_match_id = {$tourn_match_id} AND Tourn_ID = {$tourn_id} AND BracketID = {$bracket_id} AND Winner != '' AND Winner IS NOT NULL");
			$line_res1 = $line_qry1->row_array();
			$total_wins = $line_res1['lines_have_winner'];

			$line_qry2 = $this->db->query("SELECT count(Tourn_line_id) AS total_lines FROM Tournament_Lines WHERE Tourn_match_id = {$tourn_match_id} AND Tourn_ID = {$tourn_id} AND BracketID = {$bracket_id}");
			$line_res2 = $line_qry2->row_array();
			$total_lines = $line_res2['total_lines'];

			if((floor($total_lines / 2) + 1) == $total_wins){	
			
			// Code to update the Tournament_Matches

				$player1_wins = $this->db->query("SELECT count(*) as player1_wins FROM Tournament_Lines A WHERE A.Winner = A.Player1 AND A.Tourn_ID = {$tourn_id} AND A.Tourn_match_id = {$tourn_match_id} AND A.BracketID = {$bracket_id}");

				$player2_wins = $this->db->query("SELECT count(*) as player2_wins FROM Tournament_Lines A WHERE A.Winner = A.Player2 AND A.Tourn_ID = {$tourn_id} AND A.Tourn_match_id = {$tourn_match_id} AND A.BracketID = {$bracket_id}");

				$player1_wins_count = $player1_wins->row_array();
				$player2_wins_count = $player2_wins->row_array();

				// --------------------------------	

				$player_points = $this->db->query("SELECT SUM(Player1_points) AS Tot_P1_points, SUM(Player2_points) AS Tot_P2_points FROM Tournament_Lines WHERE Tourn_match_id = {$tourn_match_id} AND Tourn_ID = {$tourn_id} AND BracketID = {$bracket_id}");

				$tot_points = $player_points->row_array();
			
				// --------------------------------	

				$player_win_per = $this->db->query("SELECT SUM(Player1_Win_Per) AS Tot_P1_wp, SUM(Player2_Win_Per) AS Tot_P2_wp FROM Tournament_Lines WHERE Tourn_match_id = {$tourn_match_id} AND Tourn_ID = {$tourn_id} AND BracketID = {$bracket_id}");

				$tot_wp = $player_win_per->row_array();

				// --------------------------------	

				if($player1_wins_count['player1_wins'] > $player2_wins_count['player2_wins']){
					$winner_player = 'Player1';
				}
				else if($player1_wins_count['player1_wins'] < $player2_wins_count['player2_wins']){
					$winner_player = 'Player2';
				}
				else
				{
					if($tot_points['Tot_P1_points'] > $tot_points['Tot_P2_points']){		//	Player 1 Points are Higher
						$winner_player = 'Player1';
					}
					else if($tot_points['Tot_P1_points'] < $tot_points['Tot_P2_points']){	//	Player 2 Points are Higher
						$winner_player = 'Player2';
					}
					else{
							if($tot_wp['Tot_P1_wp'] > $tot_wp['Tot_P2_wp']){		//	Player 1 Win Percent is Higher
								$winner_player = 'Player1';	
							}
							else if($tot_wp['Tot_P1_wp'] < $tot_wp['Tot_P2_wp']){	//	Player 2 Win Percent is Higher
								$winner_player = 'Player2';	
							}
					}
				}

				if($winner_player){
					$update_winner = $this->db->query("UPDATE Tournament_Matches SET Player1_points = {$tot_points['Tot_P1_points']}, Player2_points = {$tot_points['Tot_P2_points']}, Winner = (SELECT {$winner_player} FROM Tournament_Matches WHERE Tourn_match_id = {$tourn_match_id}) WHERE Tourn_match_id = {$tourn_match_id}");


					if($winner_player == 'Player1'){ $looser_player = 'Player2'; }
					else if($winner_player == 'Player2'){ $looser_player = 'Player1'; }
				
					$get_winner = $this->db->query("SELECT {$winner_player} FROM Tournament_Matches WHERE Tourn_match_id = {$tourn_match_id}");
					$win_p = $get_winner->row_array();


					$get_loser = $this->db->query("SELECT {$looser_player} FROM Tournament_Matches WHERE Tourn_match_id = {$tourn_match_id}");
					$los_p = $get_loser->row_array();


				/* ----------------- Next Level Seeds Update ----------------------*/

					if($match_num == 1)
					{
						$upd_p1 = $this->db->query("UPDATE Tournament_Matches SET Player2 = $win_p[$winner_player] WHERE Match_Num = '4' AND BracketID = '{$bracket_id}' AND Tourn_ID = '{$tourn_id}' AND Round_Num = '3'");

						$upd_p1 = $this->db->query("UPDATE Tournament_Matches SET Player2 = $los_p[$looser_player] WHERE Match_Num = '3' AND BracketID = '{$bracket_id}' AND Tourn_ID = '{$tourn_id}' AND Round_Num = '2'");
					}

					if($match_num == 2)
					{
						$upd_p1 = $this->db->query("UPDATE Tournament_Matches SET Player1 = $win_p[$winner_player] WHERE Match_Num = '3' AND BracketID = '{$bracket_id}' AND Tourn_ID = '{$tourn_id}' AND Round_Num = '2'");
					}

					if($match_num == 3)
					{
						$upd_p1 = $this->db->query("UPDATE Tournament_Matches SET Player1 = $win_p[$winner_player] WHERE Match_Num = '4' AND BracketID = '{$bracket_id}' AND Tourn_ID = '{$tourn_id}' AND Round_Num = '3'");
					}
				
				/* ----------------- Next Level Seeds Update ----------------------*/
				
				}

				// Code to update the Tournament_Matches
			}


		}


//---------------------- Add Score Functionality for PlayOff Draws -----------------

		public function update_team_po_tourn_score()
		{

			$tourn_id		= $this->input->post('tourn_id');
			$tourn_match_id = $this->input->post('tourn_match_id');
			$match_line_id  = $this->input->post('match_line_id');

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

$mformat = $this->calculate_match_format($player1_user, $player1_partner);


		/* ------------------- A2MScore Calculation Section ---------------- */
		$player1_a2mscore	= $this->get_a2mscore($player1_user, $match_sport, $mformat);
		$player2_a2mscore	= $this->get_a2mscore($opp_user, $match_sport, $mformat);

		$player1_part_a2mscore	= "";
		$player2_part_a2mscore	= "";

			if($player1_partner or $opp_user_partner){			// If the Tournament is Double format
				$player1_part_a2mscore	= $this->get_a2mscore($player1_partner, $match_sport, $mformat);
				$player2_part_a2mscore	= $this->get_a2mscore($opp_user_partner, $match_sport, $mformat);
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
			$player1_win_per	 = $eval_player_scores['Player1_Win_Per'];
			$player2_win_per	 = $eval_player_scores['Player2_Win_Per'];

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

			//$winner_a2mscore_updated		=   intval($winner_add_score_points) +  intval($winner_win_points);
			$winner_a2mscore_updated		=   intval($winner_add_score_points);
			//$winner_part_a2mscore_updated	=   intval($winner_part_add_score_points) +  intval($winner_part_win_points);
			$winner_part_a2mscore_updated	=   intval($winner_part_add_score_points);

			$looser_a2mscore_updated		=  - intval($winner_add_score_points) +  intval($looser_win_points);
			$looser_part_a2mscore_updated	=  - intval($winner_part_add_score_points) +  intval($looser_part_win_points);

			if($match_sport == 7){
				$winner_exc_points = $this->calc_picball_addscore_points($winner_a2m_diff, $winner, $max_a2m_player);
				$winner_partner_exc_points = $this->calc_picball_addscore_points($winner_part_a2m_diff, $winner_partner, $max_a2m_partner); 

				$winner_a2mscore_updated			= $winner_exc_points;
				$winner_part_a2mscore_updated	= $winner_exc_points;

				$looser_a2mscore_updated			= -$winner_exc_points;
				$looser_part_a2mscore_updated	= -$winner_exc_points;
			}


			// A2MScore Table Update 
			$this->a2mscore_update($winner, $winner_a2mscore_updated, $match_sport, $mformat);
			$this->a2mscore_update($winner_partner, $winner_part_a2mscore_updated, $match_sport, $mformat);

			$this->a2mscore_update($looser, $looser_a2mscore_updated, $match_sport, $mformat);
			$this->a2mscore_update($looser_partner, $looser_part_a2mscore_updated, $match_sport, $mformat);

			$this->update_player_standings($winner, $tourn_id, $bracket_id, $winner_a2mscore_updated);
			$this->update_player_standings($winner_partner, $tourn_id, $bracket_id, $winner_part_a2mscore_updated);
			$this->update_player_standings($looser, $tourn_id, $bracket_id, $looser_a2mscore_updated);
			$this->update_player_standings($looser_partner, $tourn_id, $bracket_id, $looser_part_a2mscore_updated);

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

			//$winner_a2mscore_updated	=   intval($winner_add_score_points) +  intval($winner_win_points);
			$winner_a2mscore_updated	=   intval($winner_add_score_points);
			$looser_a2mscore_updated	=  - intval($winner_add_score_points) +  intval($looser_win_points);

			if($match_sport == 7){
				$winner_exc_points = $this->calc_picball_addscore_points($winner_a2m_diff, $winner, $max_a2m_player);

				$winner_a2mscore_updated = $winner_exc_points;
				$looser_a2mscore_updated = -$winner_exc_points;
			}

			// A2MScore Table Update 
			$this->a2mscore_update($winner, $winner_a2mscore_updated, $match_sport, $mformat);
			$this->a2mscore_update($looser, $looser_a2mscore_updated, $match_sport, $mformat);

			$this->update_player_standings($winner, $tourn_id, $bracket_id, $winner_a2mscore_updated);
			$this->update_player_standings($looser, $tourn_id, $bracket_id, $looser_a2mscore_updated);
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
				'Winner'		 => $winner,
				'Player1_Win_Per'=> $player1_win_per,
				'Player2_Win_Per'=> $player2_win_per);

		$this->db->where('Tourn_line_id', $match_line_id);
		$result = $this->db->update('Tournament_Lines', $data);

		$line_qry1 = $this->db->query("SELECT count(Tourn_line_id) AS lines_have_winner FROM Tournament_Lines WHERE Tourn_match_id = {$tourn_match_id} AND Tourn_ID = {$tourn_id} AND BracketID = {$bracket_id} AND Winner != '' AND Winner IS NOT NULL");
		$line_res1 = $line_qry1->row_array();
		$total_wins = $line_res1['lines_have_winner'];

		$line_qry2 = $this->db->query("SELECT count(Tourn_line_id) AS total_lines FROM Tournament_Lines WHERE Tourn_match_id = {$tourn_match_id} AND Tourn_ID = {$tourn_id} AND BracketID = {$bracket_id}");
		$line_res2 = $line_qry2->row_array();
		$total_lines = $line_res2['total_lines'];

		if((floor($total_lines / 2) + 1) <= $total_wins){	
			
			// Code to update the Tournament_Matches

				$player1_wins = $this->db->query("SELECT count(*) as player1_wins FROM Tournament_Lines A WHERE A.Winner = A.Player1 AND A.Tourn_ID = {$tourn_id} AND A.Tourn_match_id = {$tourn_match_id} AND A.BracketID = {$bracket_id}");

				$player2_wins = $this->db->query("SELECT count(*) as player2_wins FROM Tournament_Lines A WHERE A.Winner = A.Player2 AND A.Tourn_ID = {$tourn_id} AND A.Tourn_match_id = {$tourn_match_id} AND A.BracketID = {$bracket_id}");

				$player1_wins_count = $player1_wins->row_array();
				$player2_wins_count = $player2_wins->row_array();

				// --------------------------------	

				$player_points = $this->db->query("SELECT SUM(Player1_points) AS Tot_P1_points, SUM(Player2_points) AS Tot_P2_points FROM Tournament_Lines WHERE Tourn_match_id = {$tourn_match_id} AND Tourn_ID = {$tourn_id} AND BracketID = {$bracket_id}");

				$tot_points = $player_points->row_array();
			
				// --------------------------------	

				$player_win_per = $this->db->query("SELECT SUM(Player1_Win_Per) AS Tot_P1_wp, SUM(Player2_Win_Per) AS Tot_P2_wp FROM Tournament_Lines WHERE Tourn_match_id = {$tourn_match_id} AND Tourn_ID = {$tourn_id} AND BracketID = {$bracket_id}");

				$tot_wp = $player_win_per->row_array();

				// --------------------------------	

			if($player1_wins_count['player1_wins'] > $player2_wins_count['player2_wins']){
				$winner_player = 'Player1';
			}
			else if($player1_wins_count['player1_wins'] < $player2_wins_count['player2_wins']){
				$winner_player = 'Player2';
			}
			else
			{
				if($tot_points['Tot_P1_points'] > $tot_points['Tot_P2_points']){		//	Player 1 Points are Higher
					$winner_player = 'Player1';
				}
				else if($tot_points['Tot_P1_points'] < $tot_points['Tot_P2_points']){	//	Player 2 Points are Higher
					$winner_player = 'Player2';
				}
				else{
						if($tot_wp['Tot_P1_wp'] > $tot_wp['Tot_P2_wp']){		//	Player 1 Win Percent is Higher
							$winner_player = 'Player1';	
						}
						else if($tot_wp['Tot_P1_wp'] < $tot_wp['Tot_P2_wp']){	//	Player 2 Win Percent is Higher
							$winner_player = 'Player2';	
						}
				}
			}

				if($winner_player){
					$update_winner = $this->db->query("UPDATE Tournament_Matches SET Player1_points = {$tot_points['Tot_P1_points']}, Player2_points = {$tot_points['Tot_P2_points']}, Winner = (SELECT {$winner_player} FROM Tournament_Matches WHERE Tourn_match_id = {$tourn_match_id}) WHERE Tourn_match_id = {$tourn_match_id}");


					if($winner_player == 'Player1'){ $looser_player = 'Player2'; }
					else if($winner_player == 'Player2'){ $looser_player = 'Player1'; }
				
					$get_winner = $this->db->query("SELECT {$winner_player} FROM Tournament_Matches WHERE Tourn_match_id = {$tourn_match_id}");
					$win_p = $get_winner->row_array();


					$get_loser = $this->db->query("SELECT {$looser_player} FROM Tournament_Matches WHERE Tourn_match_id = {$tourn_match_id}");
					$los_p = $get_loser->row_array();


				/* ----------------- Next Level Seeds Update ----------------------*/

					if($match_num == 1)
					{

						$upd_p1 = $this->db->query("UPDATE Tournament_Matches SET Player2 = $win_p[$winner_player] WHERE Match_Num = '4' AND BracketID = '{$bracket_id}' AND Tourn_ID = '{$tourn_id}' AND Round_Num = '3'");

						$upd_p1 = $this->db->query("UPDATE Tournament_Matches SET Player2 = $los_p[$looser_player] WHERE Match_Num = '3' AND BracketID = '{$bracket_id}' AND Tourn_ID = '{$tourn_id}' AND Round_Num = '2'");

					}

					if($match_num == 2)
					{
						$upd_p1 = $this->db->query("UPDATE Tournament_Matches SET Player1 = $win_p[$winner_player] WHERE Match_Num = '3' AND BracketID = '{$bracket_id}' AND Tourn_ID = '{$tourn_id}' AND Round_Num = '2'");

					}

					if($match_num == 3)
					{
						$upd_p1 = $this->db->query("UPDATE Tournament_Matches SET Player1 = $win_p[$winner_player] WHERE Match_Num = '4' AND BracketID = '{$bracket_id}' AND Tourn_ID = '{$tourn_id}' AND Round_Num = '3'");
					}
				
				/* ----------------- Next Level Seeds Update ----------------------*/
				}

				// Code to update the Tournament_Matches
			}

		}

//---------------------- Add Score Functionality for Single & Consolation Draws -----------------

		public function update_tourn_match_score()
		{

			/* Gather all post variables */
			$tourn_id			= $this->input->post('tourn_id');
			$tourn_match_id		= $this->input->post('tourn_match_id');
			$draw_name			= $this->input->post('draw_name');
			$round_title		= $this->input->post('round_title');
			$round_num			= $this->input->post('round_num');

			$player1_user		= $this->input->post('player1_user');
			$player1_partner	= $this->input->post('player1_user_partner');

			$opp_user			= $this->input->post('player2_user');
			$opp_user_partner	= $this->input->post('player2_user_partner');		
			
			$p1_score_post		= $this->input->post('player1');
			$p2_score_post		= $this->input->post('player2');

			$bracket_id			= $this->input->post('bracket_id');
			$match_num			= $this->input->post('match_num');
			/* Gather all post variables */

			$qry_bracket = $this->db->query("SELECT * FROM Brackets WHERE BracketID = {$bracket_id}");
			$get_backet  = $qry_bracket->row_array();

			if($get_backet){
				if($get_backet['Draw_Format'] == 'singles'){
					$mformat = "Singles";
				}
				else if($get_backet['Draw_Format'] == 'doubles'){
					$mformat = "Doubles";
				}
				else if($get_backet['Draw_Format'] == 'mixed'){
					$mformat = "Mixed";
				}
				else{
					$mformat = $this->calculate_match_format($player1_user, $player1_partner);
				}
			}
			else{
				$mformat = $this->calculate_match_format($player1_user, $player1_partner);
			}


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

			$player1_a2mscore	= $this->get_a2mscore($player1_user, $match_sport, $mformat);
			$player2_a2mscore	= $this->get_a2mscore($opp_user, $match_sport, $mformat);

			$player1_part_a2mscore	= "";
			$player2_part_a2mscore	= "";

			if($player1_partner or $opp_user_partner){			// If the Tournament is Double format
				$player1_part_a2mscore	= $this->get_a2mscore($player1_partner, $match_sport, $mformat);
				$player2_part_a2mscore	= $this->get_a2mscore($opp_user_partner, $match_sport, $mformat);
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

			$winner			= $eval_winner['Winner'];
			$winner_partner = $eval_winner['Winner_Partner'];
			$looser			= $eval_winner['Looser'];
			$looser_partner = $eval_winner['Looser_Partner'];

		/* --------------- Evaluate Winner -------------- */

		$win_per_p1 = ($player1_score_total / $tot_score) * 100;
		$win_per_p2 = ($player2_score_total / $tot_score) * 100;


		/* --------To allowing of adding an extra points based on player win percentile only for LOOSER  ------- */

		//($winner == $player1_user) ? $win_per_p1 = -1 : $win_per_p2 = -1; 

		/* ----------------------------------------------------------------------------------------------------- */


		if($player1_partner or $opp_user_partner){					 // For Doubles Format
		
			$eval_a2m_diff				= $this->get_a2m_diff($player1_user, $opp_user, $player1_a2mscore, $player1_part_a2mscore, $player2_a2mscore, $player2_part_a2mscore, $winner);		// Get A2MScore diff for Doubles Format

				$winner_a2m_diff		= $eval_a2m_diff['winner_a2m_diff'];
				$winner_part_a2m_diff	= $eval_a2m_diff['winner_part_a2m_diff'];

			/*echo "<pre>";
			print_r($eval_a2m_diff);*/

			$eval_max_a2m_players	= $this->get_max_a2m_players($player1_user, $player1_partner, $opp_user, $opp_user_partner, $player1_a2mscore, $player1_part_a2mscore, $player2_a2mscore, $player2_part_a2mscore);  
			// Get Max A2M Players for both Players and their Partners for Doubles Format

			/*echo "<pre>";
			print_r($eval_max_a2m_players);*/

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

			//$winner_a2mscore_updated		=   intval($winner_add_score_points) +  intval($winner_win_points);
			$winner_a2mscore_updated		=   intval($winner_add_score_points);
			//$winner_part_a2mscore_updated	=   intval($winner_part_add_score_points) +  intval($winner_part_win_points);
			$winner_part_a2mscore_updated	=   intval($winner_part_add_score_points);

			$looser_a2mscore_updated		=  - intval($winner_add_score_points) +  intval($looser_win_points);
			$looser_part_a2mscore_updated	=  - intval($winner_part_add_score_points) +  intval($looser_part_win_points);

/*echo "<br>".$winner." - (+)".		  $winner_add_score_points." - ".	  $winner_win_points." - ".     $winner_a2mscore_updated;
echo "<br>".$winner_partner." - (+)".$winner_part_add_score_points." - ".$winner_part_win_points." - ".$winner_part_a2mscore_updated;

echo "<br>".$looser." - (-)".     $winner_add_score_points." - ".	  $looser_win_points." - ".		$looser_a2mscore_updated;
echo "<br>".$looser_partner." - (-)".$winner_part_add_score_points." - ".$looser_part_win_points." - ".$looser_part_a2mscore_updated;*/

//exit;
			if($match_sport == 7){
				$winner_exc_points = $this->calc_picball_addscore_points($winner_a2m_diff, $winner, $max_a2m_player);
				$winner_partner_exc_points = $this->calc_picball_addscore_points($winner_part_a2m_diff, $winner_partner, $max_a2m_partner); 

				$winner_a2mscore_updated			= $winner_exc_points;
				$winner_part_a2mscore_updated	= $winner_exc_points;

				$looser_a2mscore_updated			= -$winner_exc_points;
				$looser_part_a2mscore_updated	= -$winner_exc_points;
			}


			// A2MScore Table Update
			$this->a2mscore_update($winner, $winner_a2mscore_updated, $match_sport, $mformat);
			$this->a2mscore_update($winner_partner, $winner_part_a2mscore_updated, $match_sport, $mformat);

			$this->a2mscore_update($looser, $looser_a2mscore_updated, $match_sport, $mformat);
			$this->a2mscore_update($looser_partner, $looser_part_a2mscore_updated, $match_sport, $mformat);
//exit;
			$this->update_player_standings($winner, $tourn_id, $bracket_id, $winner_a2mscore_updated);
			$this->update_player_standings($winner_partner, $tourn_id, $bracket_id, $winner_part_a2mscore_updated);
			$this->update_player_standings($looser, $tourn_id, $bracket_id, $looser_a2mscore_updated);
			$this->update_player_standings($looser_partner, $tourn_id, $bracket_id, $looser_part_a2mscore_updated);

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

			//$winner_a2mscore_updated =    intval($winner_add_score_points) + intval($winner_win_points);
			$winner_a2mscore_updated =    intval($winner_add_score_points);
			$looser_a2mscore_updated =  - intval($winner_add_score_points) + intval($looser_win_points);

			if($match_sport == 7){
				$winner_exc_points = $this->calc_picball_addscore_points($winner_a2m_diff, $winner, $max_a2m_player);

				$winner_a2mscore_updated = $winner_exc_points;
				$looser_a2mscore_updated = -$winner_exc_points;
			}

			// A2MScore Table Update 
			$this->a2mscore_update($winner, $winner_a2mscore_updated, $match_sport, $mformat);
			$this->a2mscore_update($looser, $looser_a2mscore_updated, $match_sport, $mformat);

			$this->update_player_standings($winner, $tourn_id, $bracket_id, $winner_a2mscore_updated);
			$this->update_player_standings($looser, $tourn_id, $bracket_id, $looser_a2mscore_updated);
		}

		/* ------------------- A2MScore Calculation Section End ---------------- */


		$played_date = $this->input->post('tour_match_date');


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

			/* ------------------------------------------------------------------------------ */


			/* ------- Update player1 and player2 sources --------- */

			$qry_string = "";

			if($draw_name == "Consolation"){
				$qry_string = " AND Round_Num != 1";
			}

			$this->update_source_matches_main($bracket_id, $match_num, $draw_name, $winner, $winner_partner, $qry_string);
		
			/* ------- Update player1 and player2 sources -------- */


			if($draw_name == "Main"){

				$bracket_draw_type = 
					//$this->db->query("SELECT Tournament_type FROM tournament WHERE tournament_ID = $tourn_id AND Tournament_type = 'Consolation'");
					$this->db->query("SELECT Bracket_Type FROM Brackets WHERE Tourn_ID = $tourn_id AND BracketID = $bracket_id AND Bracket_Type = 'Consolation'");

				if($bracket_draw_type->num_rows() > 0 and ($round_num == 1 or $round_num == 2)){

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

			if($round_title == 'Semi-Final'){
				$this->esc_semi_final_losers($bracket_id, $match_num, $looser, $looser_partner);
			}

			$data = array('player1'=>$player1_user, 'player2'=>$opp_user, 'player1_partner'=>$player1_partner, 'player2_partner'=>$opp_user_partner, 'tourn_id'=>$tourn_id, 'winner' => $winner, 'player1_score'=>$player1_score, 'player2_score'=>$player2_score, 'type'=>'se', 'round_title'=>$round_title, 'draw_name'=>$draw_name);

			return $data;
		}

		public function update_cl_wff_winner()
			{

			$tourn_id		= $this->input->post('tourn_id');
			$tourn_match_id = intval($this->input->post('tourn_match_id'));

			/*$draw_name		= $this->input->post('draw_name');
				if($draw_name == "") { $draw_name = "Main"; }*/

			//$round_title	= $this->input->post('round_title');
			
			$qry_check		= $this->db->query("SELECT * FROM Tournament_Matches WHERE Tourn_match_id = $tourn_match_id ");

			if($qry_check->num_rows() > 0){
				$players = $qry_check->row_array();
				$round_num = $players['Round_Num'];

				$p1 = $players['Player1'];
				$p1_partner = $players['Player1_Partner'];

				$p2 = $players['Player2'];
				$p2_partner = $players['Player2_Partner'];
			}

			$winner = $this->input->post('win_ff_player');

			if($winner == $p1){
				$p1_points  = 5;
				$p2_points  = -5;
				$looser		= $p2;

				$winner_partner = $p1_partner;
				$loser_partner  = $p2_partner;
			}
			else{
				$p2_points  = 5;
				$p1_points  = -5;
				$looser		= $p1;

				$winner_partner = $p2_partner;
				$loser_partner  = $p1_partner;
			}

			$player1_score  = "[0]";
			$player2_score  = "[0]";

			$data = array(
				'Player1_Score'  => $player1_score,
				'Player2_Score'	 => $player2_score,
				'Player1_points' => $p1_points,
				'Player2_points' => $p2_points,
				'Winner'		 => $winner);
			
			$this->db->where('Tourn_match_id', $tourn_match_id);
			$result = $this->db->update('Tournament_Matches', $data);


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

			$p1_num_upd		 = $this->player_num_match_update($player1_user, $match_sport, $won, $lost, $win_per_p1);
			$p1_part_num_upd = $this->player_num_match_update($player1_partner, $match_sport, $won, $lost, $win_per_p1);

			if($winner == $opp_user) { $won = 1; $lost = 0; }
			else{ $won = 0; $lost = 1; }
			$win_per_p2 = 0.00;

			$p2_num_upd		 = $this->player_num_match_update($opp_user, $match_sport, $won, $lost, $win_per_p2);
			$p2_part_num_upd = $this->player_num_match_update($player2_partner, $match_sport, $won, $lost, $win_per_p2);

			$bracket_id = $this->input->post('bracket_id');
			$match_num  = $this->input->post('match_num');

			/*$data = array('player1'=>$player1_user, 'player2'=>$opp_user, 'player1_partner'=>$player1_partner, 
				'player2_partner'=>$player2_partner, 'tourn_id'=>$tourn_id, 'winner'=>$winner, 'type'=>'wff', 'round_title'=>$round_title, 'draw_name'=>$draw_name);*/

			$p_pos  = $this->get_cl_user_position($bracket_id, $opp_user);
			$ch_pos = $this->get_cl_user_position($bracket_id, $player1_user);

			$data = array('bracket_id'=> $bracket_id,
						  'match_num' => $match_num,
						  'player'	  => $opp_user,
						  'challeger' => $player1_user,
						  'p_pos'	  => $p_pos,
						  'ch_pos'	  => $ch_pos,
						  'winner'	  => $winner);

			return $data;
		}


		public function update_wff_winner()				// --- Win by Forefiet --------------------------------------------------------------------
		{

			$tourn_id		= $this->input->post('tourn_id');
			$tourn_match_id = intval($this->input->post('tourn_match_id'));
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

			$played_date	= date("Y-m-d h:i:s");
			$player1_score  = "[0]";
			$player2_score  = "[0]";


			$data = array(
				'Match_Date'	 => $played_date,
				'Player1_Score'  => $player1_score,
				'Player2_Score'	 => $player2_score,
				'Player1_points' => $p1_points,
				'Player2_points' => $p2_points,
				'Winner'		 => $winner);
			
			$this->db->where('Tourn_match_id', $tourn_match_id);
			$result = $this->db->update('Tournament_Matches', $data);



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

				$bracket_draw_type = 
					//$this->db->query("SELECT Tournament_type FROM tournament WHERE tournament_ID = $tourn_id AND Tournament_type = 'Consolation'");
					$this->db->query("SELECT Bracket_Type FROM Brackets WHERE Tourn_ID = $tourn_id AND BracketID = $bracket_id AND Bracket_Type = 'Consolation'");

				if($bracket_draw_type->num_rows() > 0 and ($round_num == 1 or $round_num == 2)){

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
			$tourn_id		= $this->input->post('tourn_id');
			$tourn_match_id = intval($this->input->post('tourn_match_id'));
			
			$qry_check		= $this->db->query("SELECT * FROM Tournament_Matches WHERE Tourn_match_id = $tourn_match_id ");
			$match_details  = $qry_check->row_array();

			$round_num		= $match_details['Round_Num'];

			$draw_name		= $this->input->post('draw_name');
			if($draw_name == "") { $draw_name = 'Main'; }

			$round_title = $this->input->post('round_title');
		
			$data		= array('tournament_ID' => $tourn_id);
			$macth_init =  $this->db->get_where('tournament',$data);
			$match_init_user = $macth_init->row_array();

		$player1_user	 = $this->input->post('player1_user');
		$player1_partner = $this->input->post('player1_user_partner');

		$opp_user		  = $this->input->post('player2_user');
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

		//if($this->input->post('player1')){
			$p1_score_post = $this->input->post('player1');
			$p2_score_post = $this->input->post('player2');
		/*}
		else{
			$p1_score_post = $this->input->post('mob_player1');
			$p2_score_post = $this->input->post('mob_player2');
		}*/

		/*echo "<pre>";
		print_r($this->input->post('player1'));
		print_r($this->input->post('mob_player1'));
		print_r($p2_score_post);
		print_r($p2_score_post);
		exit;*/

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

			//echo $this->db->last_query();

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

					$qry_check_draw_type = 
						//$this->db->query("SELECT Tournament_type FROM tournament WHERE tournament_ID = $tourn_id AND Tournament_type = 'Consolation'");
						$this->db->query("SELECT Bracket_Type FROM Brackets WHERE Tourn_ID = $tourn_id AND BracketID = $bracket_id AND Bracket_Type = 'Consolation'");

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



		/* Team League Single Elimination Scores Add */

		public function update_team_se_tourn_score()			// Team SE Add Score 
		{

			$tourn_id		= $this->input->post('tourn_id');
			$tourn_match_id = $this->input->post('tourn_match_id');
			$match_line_id  = $this->input->post('match_line_id');

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

$mformat = $this->calculate_match_format($player1_user, $player1_partner);


		/* ------------------- A2MScore Calculation Section ---------------- */
		$player1_a2mscore	= $this->get_a2mscore($player1_user, $match_sport, $mformat);
		$player2_a2mscore	= $this->get_a2mscore($opp_user, $match_sport, $mformat);

		$player1_part_a2mscore	= "";
		$player2_part_a2mscore	= "";

			if($player1_partner or $opp_user_partner){			// If the Tournament is Double format
				$player1_part_a2mscore	= $this->get_a2mscore($player1_partner, $match_sport, $mformat);
				$player2_part_a2mscore	= $this->get_a2mscore($opp_user_partner, $match_sport, $mformat);
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
			$player1_win_per	 = $eval_player_scores['Player1_Win_Per'];
			$player2_win_per	 = $eval_player_scores['Player2_Win_Per'];

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

			//$winner_a2mscore_updated		=   intval($winner_add_score_points) +  intval($winner_win_points);
			$winner_a2mscore_updated		=   intval($winner_add_score_points);
			//$winner_part_a2mscore_updated	=   intval($winner_part_add_score_points) +  intval($winner_part_win_points);
			$winner_part_a2mscore_updated	=   intval($winner_part_add_score_points);

			$looser_a2mscore_updated		=  - intval($winner_add_score_points) +  intval($looser_win_points);
			$looser_part_a2mscore_updated	=  - intval($winner_part_add_score_points) +  intval($looser_part_win_points);

			if($match_sport == 7){
				$winner_exc_points = $this->calc_picball_addscore_points($winner_a2m_diff, $winner, $max_a2m_player);
				$winner_partner_exc_points = $this->calc_picball_addscore_points($winner_part_a2m_diff, $winner_partner, $max_a2m_partner); 

				$winner_a2mscore_updated			= $winner_exc_points;
				$winner_part_a2mscore_updated	= $winner_exc_points;

				$looser_a2mscore_updated			= -$winner_exc_points;
				$looser_part_a2mscore_updated	= -$winner_exc_points;
			}

			// A2MScore Table Update 
			$this->a2mscore_update($winner, $winner_a2mscore_updated, $match_sport, $mformat);
			$this->a2mscore_update($winner_partner, $winner_part_a2mscore_updated, $match_sport, $mformat);

			$this->a2mscore_update($looser, $looser_a2mscore_updated, $match_sport, $mformat);
			$this->a2mscore_update($looser_partner, $looser_part_a2mscore_updated, $match_sport, $mformat);

			$this->update_player_standings($winner, $tourn_id, $bracket_id, $winner_a2mscore_updated);
			$this->update_player_standings($winner_partner, $tourn_id, $bracket_id, $winner_part_a2mscore_updated);
			$this->update_player_standings($looser, $tourn_id, $bracket_id, $looser_a2mscore_updated);
			$this->update_player_standings($looser_partner, $tourn_id, $bracket_id, $looser_part_a2mscore_updated);

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

			//$winner_a2mscore_updated	=   intval($winner_add_score_points) +  intval($winner_win_points);
			// updated on 09/11/2020
			$winner_a2mscore_updated	=  intval($winner_add_score_points);
			$looser_a2mscore_updated	=  - intval($winner_add_score_points) +  intval($looser_win_points);

			if($match_sport == 7){
				$winner_exc_points = $this->calc_picball_addscore_points($winner_a2m_diff, $winner, $max_a2m_player);

				$winner_a2mscore_updated = $winner_exc_points;
				$looser_a2mscore_updated = -$winner_exc_points;
			}

			// A2MScore Table Update 
			$this->a2mscore_update($winner, $winner_a2mscore_updated, $match_sport, $mformat);
			$this->a2mscore_update($looser, $looser_a2mscore_updated, $match_sport, $mformat);
	
			$this->update_player_standings($winner, $tourn_id, $bracket_id, $winner_a2mscore_updated);
			$this->update_player_standings($looser, $tourn_id, $bracket_id, $looser_a2mscore_updated);
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
				'Winner'		 => $winner,
				'Player1_Win_Per'=> $player1_win_per,
				'Player2_Win_Per'=> $player2_win_per);

		$this->db->where('Tourn_line_id', $match_line_id);
		$result = $this->db->update('Tournament_Lines', $data);

		$last_line_match = $this->db->query("SELECT MAX(Tourn_line_id) AS Max_Line_ID FROM Tournament_Lines WHERE Tourn_match_id = {$tourn_match_id} AND Tourn_ID = {$tourn_id} AND BracketID = {$bracket_id}");

		$last_line_res = $last_line_match->row_array();

		//if($last_line_res['Max_Line_ID'] == $match_line_id){	
			
			// Code to update the Tournament_Matches

				$player1_wins = $this->db->query("SELECT count(*) as player1_wins FROM Tournament_Lines A WHERE A.Winner = A.Player1 AND A.Tourn_ID = {$tourn_id} AND A.Tourn_match_id = {$tourn_match_id} AND A.BracketID = {$bracket_id}");

				$player2_wins = $this->db->query("SELECT count(*) as player2_wins FROM Tournament_Lines A WHERE A.Winner = A.Player2 AND A.Tourn_ID = {$tourn_id} AND A.Tourn_match_id = {$tourn_match_id} AND A.BracketID = {$bracket_id}");

				$player1_wins_count = $player1_wins->row_array();
				$player2_wins_count = $player2_wins->row_array();

				// --------------------------------	

				$player_points = $this->db->query("SELECT SUM(Player1_points) AS Tot_P1_points, SUM(Player2_points) AS Tot_P2_points FROM Tournament_Lines WHERE Tourn_match_id = {$tourn_match_id} AND Tourn_ID = {$tourn_id} AND BracketID = {$bracket_id}");

				$tot_points = $player_points->row_array();
			
				// --------------------------------	

				$player_win_per = $this->db->query("SELECT SUM(Player1_Win_Per) AS Tot_P1_wp, SUM(Player2_Win_Per) AS Tot_P2_wp FROM Tournament_Lines WHERE Tourn_match_id = {$tourn_match_id} AND Tourn_ID = {$tourn_id} AND BracketID = {$bracket_id}");

				$tot_wp = $player_win_per->row_array();

				// --------------------------------	

			if($player1_wins_count['player1_wins'] > $player2_wins_count['player2_wins']){
				$winner_player = 'Player1';
			}
			else if($player1_wins_count['player1_wins'] < $player2_wins_count['player2_wins']){
				$winner_player = 'Player2';
			}
			else
			{
				if($tot_points['Tot_P1_points'] > $tot_points['Tot_P2_points']){		//	Player 1 Points are Higher
					$winner_player = 'Player1';
				}
				else if($tot_points['Tot_P1_points'] < $tot_points['Tot_P2_points']){	//	Player 2 Points are Higher
					$winner_player = 'Player2';
				}
				else{
						if($tot_wp['Tot_P1_wp'] > $tot_wp['Tot_P2_wp']){		//	Player 1 Win Percent is Higher
							$winner_player = 'Player1';	
						}
						else if($tot_wp['Tot_P1_wp'] < $tot_wp['Tot_P2_wp']){	//	Player 2 Win Percent is Higher
							$winner_player = 'Player2';	
						}
				}
			}

				if($winner_player){
					$update_winner = $this->db->query("UPDATE Tournament_Matches SET Player1_points = {$tot_points['Tot_P1_points']}, Player2_points = {$tot_points['Tot_P2_points']}, Winner = (SELECT {$winner_player} FROM Tournament_Matches WHERE Tourn_match_id = {$tourn_match_id}) WHERE Tourn_match_id = {$tourn_match_id}");

					$qry_string = "";
					$winner_p_id  = $this->db->query("SELECT * FROM Tournament_Matches WHERE Tourn_match_id = {$tourn_match_id}");
				    $winner_p_res = $winner_p_id->row_array();
					$winner_player_partner = $winner_player.'_Partner';
					$draw_name = 'Main';

					$this->update_source_matches_main($bracket_id, $match_num, $draw_name, $winner_p_res[$winner_player], $winner_p_res[$winner_player_partner], $qry_string);
				}
		//}

		/* ------------------------------------------------------------------------------- */

			$data = array('player1'=>$player1_user, 'player2'=>$opp_user, 'player1_partner'=>$player1_partner, 
				'player2_partner'=>$player2_partner, 'winner' => $winner, 'round_title' => $round,	'tourn_id'=>$tourn_id, 'player1_score'=>$player1_score, 'player2_score'=>$player2_score, 'type'=>'rr', 'format'=>'Teams');

			return $data;
		}

		/* Team League Single Elimination Scores Add */


		/* Team League Single Elimination WFF */

		public function update_team_se_wff()		// --- RR Win by Forefiet Teams ---------------------------------
		{
			$tourn_id		= $this->input->post('tourn_id');
			$tourn_match_id = intval($this->input->post('tourn_match_id'));
			$match_num		= intval($this->input->post('match_num'));
			$line_id		= intval($this->input->post('match_line_id'));
			$bracket_id		= intval($this->input->post('bracket_id'));

			$draw_name		= $this->input->post('draw_name');
			//if($draw_name == "") { $draw_name = "Main"; }

			//$round_title	= $this->input->post('round_title');
			
			$p1			= $this->input->post('player1_user');
			$p1_partner = $this->input->post('player1_user_partner');

			$p2			= $this->input->post('player2_user');
			$p2_partner = $this->input->post('player2_user_partner');

			$winner		= $this->input->post('win_ff_player');

			if($winner == $p1){
				$p1_points  = 3;
				$p2_points  = 0;
				$looser		= $p2;

				$winner_partner = $p1_partner;
				$loser_partner  = $p2_partner;
			}
			else{
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


			/* ------------------------- Update Tournament Machtes Winner ----------------------------------- */

			$last_line_match = $this->db->query("SELECT MAX(Tourn_line_id) AS Max_Line_ID FROM Tournament_Lines WHERE Tourn_match_id = {$tourn_match_id} AND Tourn_ID = {$tourn_id} AND BracketID = {$bracket_id}");

			$last_line_res = $last_line_match->row_array();

			//if($last_line_res['Max_Line_ID'] == $match_line_id){	
			
			// Code to update the Tournament_Matches

				$player1_wins = $this->db->query("SELECT count(*) as player1_wins FROM Tournament_Lines A WHERE A.Winner = A.Player1 AND A.Tourn_ID = {$tourn_id} AND A.Tourn_match_id = {$tourn_match_id} AND A.BracketID = {$bracket_id}");

				$player2_wins = $this->db->query("SELECT count(*) as player2_wins FROM Tournament_Lines A WHERE A.Winner = A.Player2 AND A.Tourn_ID = {$tourn_id} AND A.Tourn_match_id = {$tourn_match_id} AND A.BracketID = {$bracket_id}");

				$player1_wins_count = $player1_wins->row_array();
				$player2_wins_count = $player2_wins->row_array();

				// --------------------------------	

				$player_points = $this->db->query("SELECT SUM(Player1_points) AS Tot_P1_points, SUM(Player2_points) AS Tot_P2_points FROM Tournament_Lines WHERE Tourn_match_id = {$tourn_match_id} AND Tourn_ID = {$tourn_id} AND BracketID = {$bracket_id}");

				$tot_points = $player_points->row_array();
			
				// --------------------------------	

				$player_win_per = $this->db->query("SELECT SUM(Player1_Win_Per) AS Tot_P1_wp, SUM(Player2_Win_Per) AS Tot_P2_wp FROM Tournament_Lines WHERE Tourn_match_id = {$tourn_match_id} AND Tourn_ID = {$tourn_id} AND BracketID = {$bracket_id}");

				$tot_wp = $player_win_per->row_array();

				// --------------------------------	

			if($player1_wins_count['player1_wins'] > $player2_wins_count['player2_wins']){
				$winner_player = 'Player1';
			}
			else if($player1_wins_count['player1_wins'] < $player2_wins_count['player2_wins']){
				$winner_player = 'Player2';
			}
			else
			{
				if($tot_points['Tot_P1_points'] > $tot_points['Tot_P2_points']){		//	Player 1 Points are Higher
					$winner_player = 'Player1';
				}
				else if($tot_points['Tot_P1_points'] < $tot_points['Tot_P2_points']){	//	Player 2 Points are Higher
					$winner_player = 'Player2';
				}
				else{
						if($tot_wp['Tot_P1_wp'] > $tot_wp['Tot_P2_wp']){		//	Player 1 Win Percent is Higher
							$winner_player = 'Player1';	
						}
						else if($tot_wp['Tot_P1_wp'] < $tot_wp['Tot_P2_wp']){	//	Player 2 Win Percent is Higher
							$winner_player = 'Player2';	
						}
				}
			}
				
				if($winner_player){
					$update_winner = $this->db->query("UPDATE Tournament_Matches SET Player1_points = {$tot_points['Tot_P1_points']}, Player2_points = {$tot_points['Tot_P2_points']}, Winner = (SELECT {$winner_player} FROM Tournament_Matches WHERE Tourn_match_id = {$tourn_match_id}) WHERE Tourn_match_id = {$tourn_match_id}");

					$qry_string = "";
					$winner_p_id  = $this->db->query("SELECT * FROM Tournament_Matches WHERE Tourn_match_id = {$tourn_match_id}");
				    $winner_p_res = $winner_p_id->row_array();
					$winner_player_partner = $winner_player.'_Partner';
					$draw_name = 'Main';

					$this->update_source_matches_main($bracket_id, $match_num, $draw_name, $winner_p_res[$winner_player], $winner_p_res[$winner_player_partner], $qry_string);

				}

			/* ------------------------------------------------------------------------------------------ */


			$data = array('player1'=>$player1_user, 'player2'=>$opp_user, 'player1_partner'=>$player1_partner, 
			'player2_partner'=>$player2_partner, 'tourn_id'=>$tourn_id, 'winner'=>$winner, 'type'=>'wff', 'round_title'=>$round_title, 'draw_name'=>$draw_name);


			return $data;
		}

		/* Team League Single Elimination WFF */


		public function insert_tourn_images($fileName)
		{
				
			$user_id	 = $this->logged_user;
			$tourn_id	 = $this->input->post('tourn_id');
			$upload_date = date("Y-m-d");
	 
			$data = array(
				'Image_file'	=> $fileName,
				'Tournament_id'	=> $tourn_id,
				'Upload_date'	=> $upload_date,
				'Users_id'		=> $user_id
			);
	 
			$this->db->insert('Tournament_Images', $data); 
		}


		/*public function update_doubles_partner()
		{
			$tourn_id	= $this->input->post('tourn_id');
			$ttype		= $this->input->post('ttype');

			$player		= $this->input->post('player');
			$partner	= $this->input->post('partner');
			$mf_filter	= $this->input->post('mf_filter');

			if($mf_filter == 'Doubles'){ $partner_field = 'Partner1'; }
			else if($mf_filter == 'Mixed'){ $partner_field = 'Partner2'; }

				$data		= array('Users_ID'=>$player, 'Tournament_ID'=>$tourn_id);
				$exec_qry1  = $this->db->get_where('RegisterTournament',$data);
				$get_player_partner = $exec_qry1->row_array();

				$player_partner = $get_player_partner["$partner_field"];

				$data		= array('Users_ID'=>$partner, 'Tournament_ID'=>$tourn_id);
				$exec_qry2  = $this->db->get_where('RegisterTournament',$data);
				$get_partner_partner = $exec_qry2->row_array();

				$partner_partner = $get_partner_partner["$partner_field"];
			
			//-----------------------------------

			$data = array("$partner_field" => "");   // update Player's existing partner as empty

			$this->db->where('Tournament_ID', $tourn_id);
			$this->db->where('Users_ID', $player_partner);
			$result = $this->db->update('RegisterTournament', $data);

			$data = array("$partner_field" => "");	// update Partner's existing partner as empty

			$this->db->where('Tournament_ID', $tourn_id);
			$this->db->where('Users_ID', $partner_partner);
			$result = $this->db->update('RegisterTournament', $data);


			//-----------------------------------

			$data = array("$partner_field" => $partner);
			
			$this->db->where('Tournament_ID', $tourn_id);
			$this->db->where('Users_ID', $player);
			$result = $this->db->update('RegisterTournament', $data);

			$data = array("$partner_field" => $player);

			$this->db->where('Tournament_ID', $tourn_id);
			$this->db->where('Users_ID', $partner);
			$result = $this->db->update('RegisterTournament', $data);
			
			//-----------------------------------

			$type = $mf_filter;

				$qry_check = $this->db->query("
				SELECT 
				u.Users_ID as Reg_Users_ID,
				u.Firstname as Reg_Firstname,
				u.Lastname as Reg_Lastname,
				u.Gender as Reg_Gender,
				p1.Users_ID as Partner1_Users_ID,
				p1.Firstname as Partner1_Firstname,
				p1.Lastname as Partner1_Lastname,
				p1.Gender as Partner1_Gender,
				p2.Users_ID as Partner2_Users_ID,
				p2.Firstname as Partner2_Firstname,
				p2.Lastname as Partner2_Lastname,
				p2.Gender as Partner2_Gender,
				rt.*
				FROM RegisterTournament rt
				LEFT JOIN Users u ON rt.Users_ID = u.Users_ID
				LEFT JOIN Users p1 ON rt.Partner1 = p1.Users_ID
				LEFT JOIN Users p2 ON rt.Partner2 = p2.Users_ID 
				WHERE Tournament_ID = $tourn_id AND Reg_Events LIKE '%-$type%'
				");
				return $qry_check->result();
		}*/

		public function update_doubles_partner(){

			$tourn_id	= $this->input->post('tourn_id');
			$ttype		= $this->input->post('ttype');

			$player		= $this->input->post('player');
			$partner	= $this->input->post('partner');
			$event		= $this->input->post('event');

			$get_partner_prev = $this->db->query("SELECT * FROM RegisterTournament WHERE Tournament_ID = '$tourn_id' AND Partners LIKE '%\"$event\":\"$partner\"%'");
			//echo $this->db->last_query();

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
			
				// ------- Player section ---------------------

				$data				= array('Users_ID' => $player, 'Tournament_ID' => $tourn_id);
				$exec_qry1			= $this->db->get_where('RegisterTournament', $data);
				$get_player_partner = $exec_qry1->row_array();

				if($get_player_partner['Partners']){
				$player_partners	= json_decode($get_player_partner['Partners'], true);
				$player_partners[$event] = $partner;
				}
				else{
				$player_partners = array($event => $partner);
				}

				$upd_partners = json_encode($player_partners);

				$data = array("Partners" => $upd_partners );   // update Player's existing partner as empty
				$this->db->where('Tournament_ID', $tourn_id);
				$this->db->where('Users_ID', $player);
				$result = $this->db->update('RegisterTournament', $data);

				// -------- Partner section --------------------

				$data				  = array('Users_ID' => $partner, 'Tournament_ID' => $tourn_id);
				$exec_qry2			  = $this->db->get_where('RegisterTournament', $data);
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

		public function get_bracket_list($tourn_id)
		{	
			$data = array('Tourn_ID'=>$tourn_id);
			$this->db->order_by("Draw_Title", "ASC");
			$names = $this->db->get_where('Brackets',$data);
			//echo $this->db->last_query(); 
			//exit;
			return $names->result();
		}

		public function delete_golf_brackets($bracket_id)
		{	
			$data = array('BracketID' => $bracket_id);
			
			$del_tm = $this->db->query("DELETE FROM Tournament_Matches_Golf WHERE BracketID = $bracket_id");
			$del_br = $this->db->query("DELETE FROM Brackets WHERE BracketID = $bracket_id");

			return $del_br;
		}

		public function delete_brackets($bracket_id)
		{	
			$data = array('BracketID' => $bracket_id);
			$del_tm = $this->db->query("DELETE FROM Tournament_Matches WHERE BracketID = $bracket_id");
			$del_br = $this->db->query("DELETE FROM Brackets WHERE BracketID = $bracket_id");

			return $del_br;
		}

		public function delete_cl_brackets($bracket_id)
		{	
			$data = array('BracketID' => $bracket_id);
			$del_tm = $this->db->query("DELETE FROM Tournament_Matches WHERE BracketID = $bracket_id");
			$del_tm = $this->db->query("DELETE FROM CL_Challenges WHERE Bracket_ID = $bracket_id");
			$del_tm = $this->db->query("DELETE FROM CL_Positions WHERE Bracket_ID = $bracket_id");
			$del_br = $this->db->query("DELETE FROM Brackets WHERE BracketID = $bracket_id");

			return $del_br;
		}

		public function delete_team_brackets($bracket_id)
		{	
			//echo $bracket_id;exit();
			$data = array('BracketID' => $bracket_id);
			
			$del_tm = $this->db->query("DELETE FROM Tournament_Lines WHERE BracketID = $bracket_id");
			$del_tm = $this->db->query("DELETE FROM Tournament_Matches WHERE BracketID = $bracket_id");
			$del_br = $this->db->query("DELETE FROM Brackets WHERE BracketID = $bracket_id");

			return $del_br;
		}

		public function calc_addscore_points($score_diff, $winner, $max_a2mscore_user)
		{
			
			//echo $score_diff." - ".$winner." - ".$max_a2mscore_user."<br>";

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

		//echo "<br>".$player1_user." - ".$opp_user." - ".$win_per_p1." - ".$win_per_p2." - ".$max_a2mscore_user;

					
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

		public function a2mscore_update($user_id, $a2mscore, $sport, $mformat){

			if($user_id){
				$data = array('Users_ID' => $user_id, 'SportsType_ID' => $sport);
				$qry_a2m = $this->db->get_where('A2MScore', $data);
				$get_a2m = $qry_a2m->row_array();

				if($mformat == 'Singles'){
				$exist_a2m = $get_a2m['A2MScore'];
				}
				elseif($mformat == 'Doubles'){
				$exist_a2m	= $get_a2m['A2MScore_Doubles'];
				}
				elseif($mformat == 'Mixed'){
				$exist_a2m	= $get_a2m['A2MScore_Mixed'];
				}
				else{
				$exist_a2m	= $get_a2m['A2MScore'];
				}

				$updated_a2m = $exist_a2m + $a2mscore;

					if($updated_a2m < 75){
						$updated_a2m = 75; 
					}

				if($mformat == 'Singles'){
				$data = array ('A2MScore' => $updated_a2m);
				}
				elseif($mformat == 'Doubles'){
				$data = array ('A2MScore_Doubles' => $updated_a2m);
				}
				elseif($mformat == 'Mixed'){
				$data = array ('A2MScore_Mixed' => $updated_a2m);
				}
				else{
				$data = array ('A2MScore' => $updated_a2m);
				}

				
				$this->db->where('Users_ID', $user_id);
				$this->db->where('SportsType_ID', $sport);

			$a2mscore_upd_qry1 = $this->db->update('A2MScore', $data);
			}

		}

		public function team_a2mscore_update($team_id, $a2mscore, $sport){

			if($team_id){
				$data = array('Team_ID' => $team_id, 'Sport' => $sport);
				$qry_a2m = $this->db->get_where('A2MTeamScore', $data);
				$get_a2m = $qry_a2m->row_array();

				$exist_a2m = $get_a2m['A2MTeamScore'];

				$updated_a2m = $exist_a2m + $a2mscore;

				if($updated_a2m < 75){
					$updated_a2m = 75; 
				}

				$data = array ('A2MTeamScore' => $updated_a2m);
				
				$this->db->where('Team_ID', $team_id);
				$this->db->where('Sport', $sport);

			$a2mscore_upd_qry1 = $this->db->update('A2MTeamScore', $data);
			//echo $this->db->last_query();
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

		public function team_num_match_update($team_id, $sport, $won, $lost, $win_per){
		
			if($team_id){
				$data = array('Team_ID' => $team_id, 'Sport' => $sport);
				$num  = $this->db->get_where('Team_Matches_Count', $data);
				$c	  =  $num->row_array();

				if(empty($c)){				//	Player 1
					$data = array('Num_Matches' => 1, 'Team_ID' => $team_id,'Sport' => $sport,
					'Won' => $won, 'Lost' => $lost, 'Win_Per' => $win_per);

					$exe_query = $this->db->insert('Team_Matches_Count', $data);
				}
				else{
					$total   = $c['Num_Matches'] + 1;
					$prev_wp = ($c['Win_Per'] * $c['Num_Matches']);

					$tot_won  = intval($c['Won']) + $won; 
					$tot_lost = intval($c['Lost']) + $lost;   

					$avg_win_per1 = number_format((($prev_wp + $win_per) / $total), 2); 

					$data = array('Num_Matches' => $total,'Won' => $tot_won, 'Lost' => $tot_lost, 'Win_Per' => $avg_win_per1);

					$this->db->where('Match_Count_ID', $c['Match_Count_ID']);
					$exe_query = $this->db->update('Team_Matches_Count', $data);
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
			$user = $this->logged_user;
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
			$get_ev_usrs = $this->db->get_where('Tournament_Match_Comments', $data);

			return $get_ev_usrs->result();
		}

		public function check_user_exists($tourn_id, $bid, $logged_user, $sport){

			if($sport != 4)
			{
			$qry_check_p2 = $this->db->query("SELECT * FROM Tournament_Matches WHERE (Player1 = $logged_user OR Player2 = $logged_user 
			OR Player1_Partner = $logged_user OR Player2_Partner = $logged_user) AND BracketID = $bid AND Tourn_ID = $tourn_id");
			}
			else
			{
			$qry_check_p2 = $this->db->query("SELECT * FROM Tournament_Matches_Golf WHERE Player = $logged_user AND BracketID = $bid AND Tourn_ID = $tourn_id");
			}

			($qry_check_p2->num_rows() > 0) ? $stat = true : $stat = false;

			return $stat;
		}

		public function check_team_user_exists($tourn_id, $bid, $logged_user, $sport){

			if($sport != 4)
			{
			$qry_check_p2 = $this->db->query("SELECT * FROM Tournament_Matches WHERE 
			(Player1 IN (SELECT Team_id FROM RegisterTournament WHERE Team_Players LIKE '%\"{$logged_user}\"%' AND Tournament_ID = {$tourn_id}) 
			OR 
			Player2 IN (SELECT Team_id FROM RegisterTournament WHERE Team_Players LIKE '%\"{$logged_user}\"%' AND Tournament_ID = {$tourn_id})) 
			AND BracketID = $bid AND Tourn_ID = $tourn_id");
			}
			else
			{
			$qry_check_p2 = $this->db->query("SELECT * FROM Tournament_Matches_Golf WHERE Player = $logged_user AND BracketID = $bid AND Tourn_ID = $tourn_id");
			}

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

			if($uid != '' and $lvl != ''){
				$qry_upd = $this->db->query("UPDATE RegisterTournament SET Reg_Sport_Level = '".$lvl."' WHERE Tournament_ID = '".$tour_id."' AND Users_ID = '".$uid."'");
			}
		}

		public function tour_registered_teams($tid)		
		{		
			$qry_get = $this->db->query("SELECT * FROM Teams where Team_ID IN (SELECT Team_id FROM RegisterTournament WHERE Tournament_id = '$tid')");		
			return $qry_get->result();		
		}

		public function is_tourn_reg_team_captain($uid, $tid)		
		{		
			$qry_get = $this->db->query("SELECT * FROM Teams WHERE (Captain = {$uid} OR Created_by = {$uid}) AND Team_ID IN (SELECT Team_id FROM RegisterTournament WHERE Tournament_id = '$tid')");
			
			return $qry_get->result();		
		}

		public function get_loggeduser_teams()		
		{	
			/*$this->db->like('Players', $this->logged_user);
			$this->db->where('Captain =', $this->logged_user);
			$this->db->or_where('Created_by =', $this->logged_user);
			
			$query = $this->db->get('Teams');*/

			$query = $this->db->query("SELECT * FROM Teams WHERE Captain = {$this->logged_user} OR Created_by = {$this->logged_user} OR Players LIKE '%\"{$this->logged_user}\"%'");

			return $query->result();
		}

		public function get_reg_team_players($tourn_id, $team){
			$qry_check = $this->db->query("SELECT * FROM RegisterTournament WHERE Tournament_ID = {$tourn_id} AND Team_id = {$team}");
			return $qry_check->row_array();
		}

		public function get_team_player_payment_info($user, $tourn_id){
			$qry_check = $this->db->query("SELECT * FROM PayTransactions WHERE mtype_ref = {$tourn_id} AND Users_ID = {$user}");
			return $qry_check->row_array();
		}
		/* -------------------------------------- Team League Score Update Section ----------------------------------- */

		public function update_team_rr_tourn_score()			// RR Add Score 
		{

			$tourn_id		= $this->input->post('tourn_id');
			$tourn_match_id = $this->input->post('tourn_match_id');
			$match_line_id  = $this->input->post('match_line_id');

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

$mformat = $this->calculate_match_format($player1_user, $player1_partner);

		/* ------------------- A2MScore Calculation Section ---------------- */
		$player1_a2mscore	= $this->get_a2mscore($player1_user, $match_sport, $mformat);
		$player2_a2mscore	= $this->get_a2mscore($opp_user, $match_sport, $mformat);

		$player1_part_a2mscore	= "";
		$player2_part_a2mscore	= "";

			if($player1_partner or $opp_user_partner){			// If the Tournament is Double format
				$player1_part_a2mscore	= $this->get_a2mscore($player1_partner, $match_sport, $mformat);
				$player2_part_a2mscore	= $this->get_a2mscore($opp_user_partner, $match_sport, $mformat);
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
			$player1_win_per	 = $eval_player_scores['Player1_Win_Per'];
			$player2_win_per	 = $eval_player_scores['Player2_Win_Per'];

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

			//$winner_a2mscore_updated		=   intval($winner_add_score_points) +  intval($winner_win_points);

			$winner_a2mscore_updated		=   intval($winner_add_score_points);
			//$winner_part_a2mscore_updated	=   intval($winner_part_add_score_points) +  intval($winner_part_win_points);
			$winner_part_a2mscore_updated	=   intval($winner_part_add_score_points);

			$looser_a2mscore_updated		=  - intval($winner_add_score_points) +  intval($looser_win_points);
			$looser_part_a2mscore_updated	=  - intval($winner_part_add_score_points) +  intval($looser_part_win_points);

			if($match_sport == 7){
				$winner_exc_points = $this->calc_picball_addscore_points($winner_a2m_diff, $winner, $max_a2m_player);
				$winner_partner_exc_points = $this->calc_picball_addscore_points($winner_part_a2m_diff, $winner_partner, $max_a2m_partner); 

				$winner_a2mscore_updated			= $winner_exc_points;
				$winner_part_a2mscore_updated	= $winner_exc_points;

				$looser_a2mscore_updated			= -$winner_exc_points;
				$looser_part_a2mscore_updated	= -$winner_exc_points;
			}


			// A2MScore Table Update 
			$this->a2mscore_update($winner, $winner_a2mscore_updated, $match_sport, $mformat);
			$this->a2mscore_update($winner_partner, $winner_part_a2mscore_updated, $match_sport, $mformat);

			$this->a2mscore_update($looser, $looser_a2mscore_updated, $match_sport, $mformat);
			$this->a2mscore_update($looser_partner, $looser_part_a2mscore_updated, $match_sport, $mformat);

			$this->update_player_standings($winner, $tourn_id, $bracket_id, $winner_a2mscore_updated);
			$this->update_player_standings($winner_partner, $tourn_id, $bracket_id, $winner_part_a2mscore_updated);
			$this->update_player_standings($looser, $tourn_id, $bracket_id, $looser_a2mscore_updated);
			$this->update_player_standings($looser_partner, $tourn_id, $bracket_id, $looser_part_a2mscore_updated);

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

			$winner_a2mscore_updated	=   intval($winner_add_score_points);
			//$winner_a2mscore_updated	=   intval($winner_add_score_points) +  intval($winner_win_points);
			$looser_a2mscore_updated	=  - intval($winner_add_score_points) +  intval($looser_win_points);

			if($match_sport == 7){
				$winner_exc_points = $this->calc_picball_addscore_points($winner_a2m_diff, $winner, $max_a2m_player);

				$winner_a2mscore_updated = $winner_exc_points;
				$looser_a2mscore_updated = -$winner_exc_points;
			}


			// A2MScore Table Update 
			$this->a2mscore_update($winner, $winner_a2mscore_updated, $match_sport, $mformat);
			$this->a2mscore_update($looser, $looser_a2mscore_updated, $match_sport, $mformat);
	
			$this->update_player_standings($winner, $tourn_id, $bracket_id, $winner_a2mscore_updated);
			$this->update_player_standings($looser, $tourn_id, $bracket_id, $looser_a2mscore_updated);

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
				'Winner'		 => $winner,
				'Player1_Win_Per'=> $player1_win_per,
				'Player2_Win_Per'=> $player2_win_per);

		$this->db->where('Tourn_line_id', $match_line_id);
		$result = $this->db->update('Tournament_Lines', $data);

		$last_line_match = $this->db->query("SELECT MAX(Tourn_line_id) AS Max_Line_ID FROM Tournament_Lines WHERE Tourn_match_id = {$tourn_match_id} AND Tourn_ID = {$tourn_id} AND BracketID = {$bracket_id}");

		$last_line_res = $last_line_match->row_array();

		//if($last_line_res['Max_Line_ID'] == $match_line_id){	
			
			// Code to update the Tournament_Matches

				$player1_wins = $this->db->query("SELECT count(*) as player1_wins FROM Tournament_Lines A WHERE A.Winner = A.Player1 AND A.Tourn_ID = {$tourn_id} AND A.Tourn_match_id = {$tourn_match_id} AND A.BracketID = {$bracket_id}");

				$player2_wins = $this->db->query("SELECT count(*) as player2_wins FROM Tournament_Lines A WHERE A.Winner = A.Player2 AND A.Tourn_ID = {$tourn_id} AND A.Tourn_match_id = {$tourn_match_id} AND A.BracketID = {$bracket_id}");

				$player1_wins_count = $player1_wins->row_array();
				$player2_wins_count = $player2_wins->row_array();

				// --------------------------------	

				$player_points = $this->db->query("SELECT SUM(Player1_points) AS Tot_P1_points, SUM(Player2_points) AS Tot_P2_points FROM Tournament_Lines WHERE Tourn_match_id = {$tourn_match_id} AND Tourn_ID = {$tourn_id} AND BracketID = {$bracket_id}");

				$tot_points = $player_points->row_array();
			
				// --------------------------------	

				$player_win_per = $this->db->query("SELECT SUM(Player1_Win_Per) AS Tot_P1_wp, SUM(Player2_Win_Per) AS Tot_P2_wp FROM Tournament_Lines WHERE Tourn_match_id = {$tourn_match_id} AND Tourn_ID = {$tourn_id} AND BracketID = {$bracket_id}");

				$tot_wp = $player_win_per->row_array();

				// --------------------------------	

			if($player1_wins_count['player1_wins'] > $player2_wins_count['player2_wins']){
				$winner_player = 'Player1';
			}
			else if($player1_wins_count['player1_wins'] < $player2_wins_count['player2_wins']){
				$winner_player = 'Player2';
			}
			else
			{
				if($tot_points['Tot_P1_points'] > $tot_points['Tot_P2_points']){		//	Player 1 Points are Higher
					$winner_player = 'Player1';
				}
				else if($tot_points['Tot_P1_points'] < $tot_points['Tot_P2_points']){	//	Player 2 Points are Higher
					$winner_player = 'Player2';
				}
				else{
						if($tot_wp['Tot_P1_wp'] > $tot_wp['Tot_P2_wp']){		//	Player 1 Win Percent is Higher
							$winner_player = 'Player1';	
						}
						else if($tot_wp['Tot_P1_wp'] < $tot_wp['Tot_P2_wp']){	//	Player 2 Win Percent is Higher
							$winner_player = 'Player2';	
						}
				}
			}

				if($winner_player){
					$update_winner = $this->db->query("UPDATE Tournament_Matches SET Player1_points = {$tot_points['Tot_P1_points']}, Player2_points = {$tot_points['Tot_P2_points']}, Winner = (SELECT {$winner_player} FROM Tournament_Matches WHERE Tourn_match_id = {$tourn_match_id}) WHERE Tourn_match_id = {$tourn_match_id}");
				}
		//}

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
			$tourn_id		= $this->input->post('tourn_id');
			$tourn_match_id = intval($this->input->post('tourn_match_id'));
			$line_id		= intval($this->input->post('match_line_id'));
			$bracket_id		= intval($this->input->post('bracket_id'));

			$draw_name		= $this->input->post('draw_name');
			//if($draw_name == "") { $draw_name = "Main"; }

			//$round_title	= $this->input->post('round_title');
			
			$p1			= $this->input->post('player1_user');
			$p1_partner = $this->input->post('player1_user_partner');

			$p2			= $this->input->post('player2_user');
			$p2_partner = $this->input->post('player2_user_partner');

			$winner		= $this->input->post('win_ff_player');

			if($winner == $p1){
				$p1_points  = 3;
				$p2_points  = 0;
				$looser		= $p2;

				$winner_partner = $p1_partner;
				$loser_partner  = $p2_partner;
			}
			else{
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


			/* ------------------------- Update Tournament Machtes Winner ----------------------------------- */

			$last_line_match = $this->db->query("SELECT MAX(Tourn_line_id) AS Max_Line_ID FROM Tournament_Lines WHERE Tourn_match_id = {$tourn_match_id} AND Tourn_ID = {$tourn_id} AND BracketID = {$bracket_id}");

			$last_line_res = $last_line_match->row_array();

			//if($last_line_res['Max_Line_ID'] == $match_line_id){	
			
			// Code to update the Tournament_Matches

				$player1_wins = $this->db->query("SELECT count(*) as player1_wins FROM Tournament_Lines A WHERE A.Winner = A.Player1 AND A.Tourn_ID = {$tourn_id} AND A.Tourn_match_id = {$tourn_match_id} AND A.BracketID = {$bracket_id}");

				$player2_wins = $this->db->query("SELECT count(*) as player2_wins FROM Tournament_Lines A WHERE A.Winner = A.Player2 AND A.Tourn_ID = {$tourn_id} AND A.Tourn_match_id = {$tourn_match_id} AND A.BracketID = {$bracket_id}");

				$player1_wins_count = $player1_wins->row_array();
				$player2_wins_count = $player2_wins->row_array();

				// --------------------------------	

				$player_points = $this->db->query("SELECT SUM(Player1_points) AS Tot_P1_points, SUM(Player2_points) AS Tot_P2_points FROM Tournament_Lines WHERE Tourn_match_id = {$tourn_match_id} AND Tourn_ID = {$tourn_id} AND BracketID = {$bracket_id}");

				$tot_points = $player_points->row_array();
			
				// --------------------------------	

				$player_win_per = $this->db->query("SELECT SUM(Player1_Win_Per) AS Tot_P1_wp, SUM(Player2_Win_Per) AS Tot_P2_wp FROM Tournament_Lines WHERE Tourn_match_id = {$tourn_match_id} AND Tourn_ID = {$tourn_id} AND BracketID = {$bracket_id}");

				$tot_wp = $player_win_per->row_array();

				// --------------------------------	

			if($player1_wins_count['player1_wins'] > $player2_wins_count['player2_wins']){
				$winner_player = 'Player1';
			}
			else if($player1_wins_count['player1_wins'] < $player2_wins_count['player2_wins']){
				$winner_player = 'Player2';
			}
			else
			{
				if($tot_points['Tot_P1_points'] > $tot_points['Tot_P2_points']){		//	Player 1 Points are Higher
					$winner_player = 'Player1';
				}
				else if($tot_points['Tot_P1_points'] < $tot_points['Tot_P2_points']){	//	Player 2 Points are Higher
					$winner_player = 'Player2';
				}
				else{
						if($tot_wp['Tot_P1_wp'] > $tot_wp['Tot_P2_wp']){		//	Player 1 Win Percent is Higher
							$winner_player = 'Player1';	
						}
						else if($tot_wp['Tot_P1_wp'] < $tot_wp['Tot_P2_wp']){	//	Player 2 Win Percent is Higher
							$winner_player = 'Player2';	
						}
				}
			}
				
				if($winner_player){
					$update_winner = $this->db->query("UPDATE Tournament_Matches SET Player1_points = {$tot_points['Tot_P1_points']}, Player2_points = {$tot_points['Tot_P2_points']}, Winner = (SELECT {$winner_player} FROM Tournament_Matches WHERE Tourn_match_id = {$tourn_match_id}) WHERE Tourn_match_id = {$tourn_match_id}");
				}

			/* ------------------------------------------------------------------------------------------ */


			$data = array('player1'=>$player1_user, 'player2'=>$opp_user, 'player1_partner'=>$player1_partner, 
			'player2_partner'=>$player2_partner, 'tourn_id'=>$tourn_id, 'winner'=>$winner, 'type'=>'wff', 'round_title'=>$round_title, 'draw_name'=>$draw_name);


			return $data;
		}

		public function get_line_matches($match_id){
			$data = array('Tourn_match_id' => $match_id);
			$query = $this->db->get_where('Tournament_Lines',$data);
			return $query->result();
		}

		public function withdraw_player($player, $tourn_id){
			$rem = $this->db->query("DELETE FROM RegisterTournament WHERE Users_ID = {$player} AND Tournament_ID = {$tourn_id}");
			return $rem;
		}

		public function withdraw_team($team, $tourn_id){
			$rem = $this->db->query("DELETE FROM RegisterTournament WHERE Team_id = {$team} AND Tournament_ID = {$tourn_id}");
			return $rem;
		}

		public function generate_tourn_event($tourn_id, $team, $draw_title, $st_date, $end_date){

			//$get_team	  = $this->db->query("SELECT * FROM Users WHERE Users_ID = (Select Captain from Teams where Team_ID =  {$team})");
			$get_team = $this->db->query("SELECT u.*, t.Team_name AS team_name FROM Users AS u JOIN Teams t ON u.Users_ID = t.Captain AND t.Team_ID = {$team}");

			$captain_info = $get_team->row_array();

			$get_tourn = $this->db->query("SELECT * FROM tournament WHERE tournament_ID = {$tourn_id}");

			$tour_info = $get_tourn->row_array();

			$data = array(
					'Ev_Type_ID'	 => 3,	
					'Ev_Title'		 => "Team Match - {$captain_info['team_name']} - {$tour_info['tournament_title']}",
					'Ev_Organizer'	 => $captain_info['Firstname']." ".$captain_info['Lastname'],
					'Ev_Contact_Num' => $captain_info['Mobilephone'],
					'Ev_Schedule'	 => 'multiple',
					'Ev_Created_by'	 => $captain_info['Users_ID'],
					'Ev_Created_Date'=> date('Y-m-d H:i:s'),
					'Ev_Start_Date'  => date('Y-m-d H:i:s', strtotime($st_date)),
					'Ev_End_Date'	 => date('Y-m-d H:i:s', strtotime($end_date)),
					'Ev_Desc'		 => "Team Availability for League - {$tour_info['tournament_title']} - {$draw_title}"
					);

			$this->db->insert('Events', $data);

			$ev_id = $this->db->insert_id();
			return $ev_id;
		}

		public function insert_tourn_comment()
		{	
			$user	  = $this->logged_user;
			$tourn_id = $this->input->post('tid');
			$comm	  = $this->input->post('message');
			$created  = date('Y-m-d H:i:s');

			$data = array(
					'Tourn_Id'		=> $tourn_id,
					'Users_id'		=> $user,
					'Comments'		=> $comm,
					'Comment_On'	=> $created
					);

			$result = $this->db->insert('Tournament_Comments', $data);

		    return  $result; 
	    }

		public function reset_line_data($line_id)
		{
			$data = array(
				'Match_Date' => NULL,
				'Player1'	 => NULL,
				'Player2'	 => NULL,
				'Player1_Score' => NULL,
				'Player2_Score' => NULL,
				'Winner'	 => NULL,
				'Win_Per'	 => NULL,
				'Player1_points'  => NULL,
				'Player2_points'  => NULL,
				'Player1_Partner' => NULL,
				'Player2_Partner' => NULL);

			$this->db->where('Tourn_line_id', $line_id);
			$res = $this->db->update('Tournament_Lines', $data);
			return $res;
		}

		public function revise_match_data($tourn_match_id, $tourn_id, $player1_points, $player2_points)
		{
			$data		= array('Tourn_ID' => $tourn_id, 'Tourn_match_id' => $tourn_match_id, );
			$get_data	= $this->db->get_where('Tournament_Matches',$data);
			$res		= $get_data->row_array();
			
			$p1_points = intval($res['Player1_points']) - intval($player1_points);
			$p2_points = intval($res['Player2_points']) - intval($player2_points);
			
				$winner = NULL;

			if($p1_points > $p2_points){ 
				$winner = $res['Player1']; 
			}
			else if($p1_points < $p2_points){
				$winner = $res['Player2']; 
			}
				/*echo "<br>res1 = ".$res['Player1_points'];
				echo "<br>res2 = ".$res['Player2_points'];
				echo "<br>p1_points = ".$p1_points;
				echo "<br>p2_points = ".$p2_points;
				echo "<br>winner=".$winner;
				echo "<br>tourn_id=".$tourn_id;*/
				//exit;
			$data = array(
						'Winner'		  => $winner,
						'Player1_points'  => $p1_points,
						'Player2_points'  => $p2_points
					);

			$this->db->where(array('Tourn_match_id' => $tourn_match_id, 'Tourn_ID' => $tourn_id));
			$result = $this->db->update('Tournament_Matches', $data);
			return $result;
		}

		public function insert_sendmail_tmparticipants($data){
			
	    	     $user	       = $this->logged_user;
                 $tourn_id     = $data['tourn_id'];
                 $subject      = $data['subject'];
                 $message      = $data['msg'];
                 $newfile      = $data['file'];    
			     $players      = $data['players'];
			     $is_academy      = $data['is_academy'];
			     $academy_id      = $data['academy_id'];
			     $created_date = date("Y-m-d h:i:s");

                 $array = array('tourn_id' => $tourn_id, 'is_academy' => $is_academy, 'academy_id' => $academy_id, 'users_id' => $user, 'message' => $message, 'subject'=>$subject, 'players' => $players, 'attachments_file'=>$newfile,'is_notified'=>0,'created_on'=>$created_date);
             
            $result = $this->db->insert('TAdmin_Messages_Players', $array);
           
         return $result;
           
	    }

		public function get_team_line_matches($player,$bracket_id,$tourn_id,$rounds)
	    {
		    for($i=1;$i<=$rounds;$i++){
			    $sql="select tl.*,tm.* from Tournament_Lines as tl inner join Tournament_Matches as tm  on tl.Tourn_match_id=tm.Tourn_match_id where (tl.Player1 = '".$player."' or tl.Player2 = '".$player."' or tl.Player1_Partner = '".$player."' or tl.Player2_Partner = '".$player."') and tl.Tourn_ID='".$tourn_id."' and tl.BracketID='".$bracket_id."' and tm.Round_Num='".$i."'";
		        
		            $qr_check = $this->db->query($sql);
		       	    $lines_arry=$qr_check->result();
				    $lines[$i]=$lines_arry;
			}
			
		  return $lines;
	    }
	    
	    public function get_rounds_cnt($tourn_id,$bracket_id){

		    $sql = "select No_of_rounds from Brackets where Tourn_ID='".$tourn_id."' and BracketID='".$bracket_id."'";
		    $qr_check = $this->db->query($sql);

	        return $qr_check->row_array();
	    }

	    public function CheckTorn_ShortCode($short_code){
			$data = array('Short_Code' => $short_code);
			$query = $this->db->get_where('tournament', $data);
			return $query->num_rows();
		}

	    public function is_logged_user_having_memeberhip($sport){
			$data = array('Related_Sport' => $sport, 'Users_id' => $this->logged_user, 'Club_id' => '139');
			$query = $this->db->get_where('User_memberships', $data);
			return $query->num_rows();
		}

	    public function get_user_mem_details($user, $sport){
			$data = array('Related_Sport' => $sport, 'Users_id' => $user, 'Club_id' => '139');
			$query = $this->db->get_where('User_memberships', $data);
			return $query->row_array();
		}

	    public function get_user_usatt_rating($membership_id){
			$data = array('Member_ID' => $membership_id);
			$query = $this->db->get_where('USATTMembership', $data);
			return $query->row_array();
		}

	    public function get_user_usatt_rating1($membership_id){
			$query = $this->db->query("SELECT * FROM USATTMembership WHERE Member_ID = '{$membership_id}'");
			return $query->row_array();
		}

		public function Get_TournamentTeams($tourn_id){
		  $qry_check = $this->db->query("SELECT * FROM Teams where Team_ID IN (SELECT Team_id FROM RegisterTournament WHERE Tournament_id = '$tourn_id')");		
			//print_r($this->db->last_query());
			//exit;
			return $qry_check->result();
		}

		public function get_reg_tourn_participants_levels($tourn_id,$user_id){
			$qry_check = $this->db->query("SELECT * FROM RegisterTournament WHERE Tournament_ID = $tourn_id AND Users_ID={$user_id}");
			 return $qry_check->row_array();
		}

	    public function update_particiapants_levels($data,$user,$tourn_id){
	    		$data1 = array(
					'Match_Type' => $data['json_formats'],
					'Reg_Age_Group'	=> $data['json_ag'],
					'Reg_Sport_Level' => $data['json_levels'],
					'Reg_Events' => $data['reg_events']
					);
			   $this->db->where('Tournament_ID', $tourn_id);
			   $this->db->where('Users_ID', $user);
			   $res = $this->db->update('RegisterTournament', $data1); 
		   return $res;
	    }

	    public function bulk_reg_players($tourn_id){

			$reg_date	= date("Y-m-d h:i:s");
			$team_id = $this->input->post('teams');
			$sel_players = $this->input->post('sel_player');
            $get_players=$this->db->query("SELECT Team_Players FROM RegisterTournament WHERE Tournament_ID = $tourn_id AND Team_id = $team_id");
            $players_json=$get_players->row_array();
            $players_arr=json_decode($players_json['Team_Players']);

			foreach($sel_players as $sp){

				$check_already_reg = $this->db->query("SELECT * FROM RegisterTournament WHERE Tournament_ID = $tourn_id AND Team_Players LIKE '%".'"'.$sp.'"'."%'");

				if($check_already_reg->num_rows == 0)
				{
				   $count=count($players_arr);
                   $players_arr[$count]=$sp;	
				}	
			}

			$playersjson=json_encode($players_arr);
			$data = array('Team_Players' => $playersjson);
                $this->db->where('Tournament_ID', $tourn_id);
                $this->db->where('Team_id', $team_id);
		        $bulk_reg = $this->db->update('RegisterTournament' ,$data);		

			return $bulk_reg;
		}

        public function GetTopTenPlayers($tourn_id,$sport_id){
          
          $get_players  = $this->db->query("SELECT * FROM RegisterTournament WHERE Tournament_ID = $tourn_id");
          $players		= $get_players->result();
          $total_players= array();

            foreach($players as $key => $player){
           	    if($player->Users_ID == NULL){
                   $players_arr[] = json_decode($player->Team_Players);              
                }
				else{
                	$players_arr[] = $player->Users_ID; 
                }
            }

            if($this->is_team_league){
                foreach($players_arr as $key => $player){
		            foreach($player as $keys => $p){
		                $total_players[] = $p;
		            }
                }
            }
			else{
                $total_players = $players_arr; 
            }

            $tot_plyrs = implode(',', $total_players);
				if($tot_plyrs != ""){
				    $check_result = $this->db->query("SELECT TOP 10 * FROM A2MScore WHERE SportsType_ID=$sport_id AND Users_ID IN ($tot_plyrs) ORDER BY A2MScore DESC"); 
				    $player_res = $check_result->result();
				}
				else{
				  	$player_res = array();
				}

         return $player_res;
        }

        public function update_spnsr_images($filenamejson,$tourn_id)
        {
        	  $data = array('Sponsors' => $filenamejson);
              $this->db->where('tournament_ID', $tourn_id);
		   $res = $this->db->update('tournament', $data);
		   return $res;	
        }

        public function upd_paypal_ipn($data)
        {
			$users_id		= $data['users_id'];
			$reg_events			= $data['reg_events'];
			$reg_occrs			= $data['reg_occrs'];

			$tourn_id		= $data["tourn_id"];
			$txn_id			= $data["txn_id"];
			$payment_gross	= $data["payment_gross"];
			$payer_email	= $data["payer_email"];
			$payment_status = $data["payment_status"];
			$payment_date	= $data["payment_date"];
			$cur_code		= $data['currency'];
			$pp_charges		= $data['pp_charges'];

			if($payment_status == 'Completed'){

			$get_tourn_reg = $this->db->query("SELECT * FROM RegisterTournament WHERE Tournament_ID = {$data['tourn_id']} AND Users_ID={$data['users_id']}");
		
			$get_res = $get_tourn_reg->row_array();

				/*$age_group	    = $this->session->userdata('json_ag');
				$match_types    = $this->session->userdata('json_formats');
				$level			= $this->session->userdata('json_levels');
				$partners		= $this->session->userdata('json_partners');
				$hc_loc_id	    = $this->session->userdata('hc_loc_id');
				$events		    = $this->session->userdata('events');
				$tsize			= $this->session->userdata('tshirt_size');
				$coup_code      = $this->session->userdata('coup_code');
				$coup_disc	    = $this->session->userdata('coup_disc');*/

			//if($get_tourn_reg->num_rows() > 0 and ($get_res['Transaction_id'] == 'NULL' or $get_res['Transaction_id'] == '')){
			//if($get_tourn_reg->num_rows() > 0){
			if(count($get_res) > 0){
				$reg_id = $get_res['RegisterTournament_id'];
				$data	= array(
						/*'Match_Type'	=> $match_types,
						'Reg_Age_Group' => $age_group,
						'Reg_Sport_Level' => $level,
						'Reg_date'		=> date('Y-m-d H:i:s'),
						'hcl_id'		=> $hc_loc_id,
						'TShirt_Size'	=> $tsize,
						'Reg_Events'    => $events,
						'Partners'		=> $partners,
						'Coupon_Applied'  => $coup_code,
						'Discount_Amount' => $coup_disc,*/
					'Fee'			 => $payment_gross,
					'Gateway_Charges'=> $pp_charges,
					'Status'		 => $payment_status,
					'Currency_Code'  => $cur_code,
					'Transaction_id' => $txn_id);

				$this->db->where('RegisterTournament_id', $reg_id);
				$res	= $this->db->update('RegisterTournament', $data);
				$ls_qry = $this->db->last_query();
			}
			//else if($get_res['Transaction_id'] == 'NULL' or $get_res['Transaction_id'] == ''){
			//else if(count($get_res) == 0){
			else{
				$data = array(
					'Users_ID'		 => $users_id,
					'Tournament_ID'  => $tourn_id,
						/*'Match_Type'	=> $match_types,
						'Reg_Age_Group' => $age_group,
						'Reg_Sport_Level' => $level,
						'Reg_date'		=> date('Y-m-d H:i:s'),
						'hcl_id'		=> $hc_loc_id,
						'TShirt_Size'	=> $tsize,
						'Reg_Events'    => $events,
						'Partners'		=> $partners,
						'Coupon_Applied'  => $coup_code,
						'Discount_Amount' => $coup_disc,*/
					'Reg_Events'    => $reg_events,
					'Fee'			 => $payment_gross,
					'Gateway_Charges'=> $pp_charges,
					'Status'		 => $payment_status,
					'Currency_Code'  => $cur_code,
					'Transaction_id' => $txn_id);

				$res = $this->db->insert('RegisterTournament', $data);
				$reg_id = $this->db->insert_id;
				$ls_qry = $this->db->last_query();
				}


				if($reg_occrs){
					$rg_ocr = json_decode($reg_occrs, TRUE);
					foreach($rg_ocr as $ocr){
						$data9 = array(
						'Users_ID'		=> $users_id,
						'Reg_ID'		=> $reg_id,
						'OCCR_ID'	=> $ocr,
						'Amount'				 => number_format($payment_gross, 2),
						'OCCR_Reg_Date'	 => date('Y-m-d H:i:s'),
						'Transaction_id'		 => $txn_id,
						'Status'					 => $payment_status,
						'Currency_Code'	 => $cur_code
						);

						$result   = $this->db->insert('League_OCCR_Regs', $data9);
	
					}
				}

				return $ls_qry;

			}
			else{
				return $payment_status;
			}
		}

        public function upd_paypal_ipn_more($data)
        {
			$users_id		= $data['users_id'];
			$tourn_id		= $data["tourn_id"];
			$txn_id			= $data["txn_id"];
			$payment_gross	= $data["payment_gross"];
			$payer_email	= $data["payer_email"];
			$payment_status = $data["payment_status"];
			$payment_date	= $data["payment_date"];
			$cur_code		= $data['currency'];
			$pp_charges		= $data['pp_charges'];

			$get_tourn_reg = $this->db->query("SELECT * FROM PayTransactions WHERE mtype_ref = {$data['tourn_id']} AND Users_ID={$data['users_id']} AND Transaction_id = '{$txn_id}'");
		
			$get_res = $get_tourn_reg->row_array();

			if(count($get_res) > 0){
				$reg_id = $get_res['pay_id'];
				$data	= array(
						'Amount'			 => $payment_gross,
						'Gateway_Charges'=> $pp_charges,
						'Status'		 => $payment_status,
						'Transaction_id' => $txn_id);

						  $this->db->where('pay_id', $reg_id);
				$res    = $this->db->update('PayTransactions', $data);
			 return $this->db->last_query();
			}
			else{
				$data = array(
						'Users_ID'		 => $users_id,
						'mtype_ref'		 => $tourn_id,
						'Amount'		 => $payment_gross,
						'Gateway_Charges'=> $pp_charges,
						'Status'		 => $payment_status,
						'Transaction_id' => $txn_id);

				   $res = $this->db->insert('PayTransactions', $data);
			return $this->db->last_query();
			}
		}

		public function GetWaitlistCount($tourn_id,$event){
			$query = $this->db->query("SELECT * FROM RegistrationWaitList WHERE Tournament_ID='".$tourn_id."' AND Event='".$event."'");
             return $query->num_rows();
		}

		public function InsertWaitlistUsers($register_id,$tourn_id,$event,$wl_order){
            $data = array(
            	    'Register_ID'		 => $register_id,
					'Tournament_ID'  => $tourn_id,
					'Event'			 => $event,
					'WL_Order'       => $wl_order);

				$res = $this->db->insert('RegistrationWaitList', $data);	
		}

		public function GetWaitListUsers($tourn_id){
			$users=array();
            $this->db->select('RegisterTournament.Users_ID,RegistrationWaitList.Event');    
            $this->db->from('RegistrationWaitList');
            $this->db->join('RegisterTournament', 'RegistrationWaitList.Register_ID = RegisterTournament.RegisterTournament_id');
            $this->db->where('RegistrationWaitList.Tournament_ID', $tourn_id);
            $query = $this->db->get();
	        $waitlistusers = $query->result();
	        foreach ($waitlistusers as $key => $value) {
	        	$users[$value->Event]=$value->Users_ID;
	        }
	        return $users;
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

		public function get_reg_participants_by_team($tourn_id,$team_id){
			$qry_check = $this->db->query("SELECT * FROM RegisterTournament WHERE Tournament_ID = $tourn_id AND Team_id = $team_id");
			return $qry_check->result();
		}

		public function upd_refund_status($data1, $data2, $data3){
				    $this->db->where($data1);
			$res  = $this->db->update('RegisterTournament', $data2);
			$res2 = $this->db->insert('Refund_Transactions', $data3);
		}

		public function upd_refund_status2($data1, $data3){
				    $this->db->where($data1);
			//$res  = $this->db->update('RegisterTournament', $data2);
			$res2 = $this->db->insert('Refund_Transactions', $data3);
		}

		public function getTournRegUsers($tourn_id){
				    $data = array('Tournament_ID' => $tourn_id);
			$res  = $this->db->get('RegisterTournament', $data);
			return $res;
		}

		public function upd_withdraw_status($data1, $data2){
				    $this->db->where($data1);
			$res  = $this->db->update('RegisterTournament', $data2);
		}

		public function GetRatingEligibilityTournaments(){
		   $today_date=date('Y-m-d');
		   $qry_check = $this->db->query("select * from tournament where EligibilityDate = '".$today_date."'");
			return $qry_check->result();
		}

		public function get_prev_refunds($reg_id){
		   $qry_check = $this->db->query("SELECT * FROM Refund_Transactions WHERE RegisterTournament_id = '".$reg_id."'");
			return $qry_check->result();
		}

		public function get_more_trans($user, $tourn_id){
		   $qry_check = $this->db->query("SELECT * FROM PayTransactions WHERE Users_ID = '".$user."' AND mtype_ref = '".$tourn_id."'");
			return $qry_check->result();
		}

		public function UpdateEligibilityRating($reg_id,$is_rating_eligible,$rating){
			$data	= array(
					'Is_Rating_Eligible'  => $is_rating_eligible,
					'Rating'              => $rating);

				$this->db->where('RegisterTournament_id', $reg_id);
				$res = $this->db->update('RegisterTournament', $data);
				
		      
		}
		public function get_user_rating($user_id, $tourn_id){
			$qry_check = $this->db->query("SELECT * FROM RegisterTournament WHERE Tournament_ID = $tourn_id AND Users_ID = $user_id");
			return $qry_check->row_array();
		}

		public function getTournRegUsersEvents($tourn_id){
			$reg_status='WithDrawn';
			$qry_check = $this->db->query("SELECT * FROM RegisterTournament WHERE Tournament_ID = $tourn_id AND (Reg_Status != '$reg_status' OR Reg_Status IS NULL)");
			//echo $this->db->last_query(); exit;
			 return $qry_check->result();
		}

		public function UpdateRegPlayerEvents(){
			return $_POST;exit();
		}

		public function get_tourn_final_line_matches($bid, $round_num){
           $data = array('BracketID' => $bid, 'Round_Num' => $round_num);
		   $query = $this->db->get_where('Tournament_Matches',$data);
			return $query->row_array();
		}

		public function search_players_rankings($data){
			$name		= $data['search_uname'];
			$country	= $data['country'];
            $state	    = $data['state'];
			$sport		= $data['sport'];
			$gender		= $data['gender'];
			$age_group  = $data['age_group'];
			$kids_agegroup_arry  = array('U10','U11','U12','U13','U14','U15','U16','U17','U18','U19');
			//print_r($kids_agegroup_arry);exit();
			if(in_array('Kids', $age_group)){
				$imp = "'" . implode( "','", $kids_agegroup_arry ) . "'";
                $agegroup = "IN ({$imp})";
			}else{
				$imp = "'" . implode( "','", $age_group ) . "'";
                $agegroup = "IN ({$imp})";	
			} 

			$name_cond  = "";
			
			if($name != ""){
			$name_arr = explode(' ', $name);
			if(count($name_arr)>1){
                $name_text1 = $name_arr[0];
                $name_text2 = $name_arr[1];
                $name_cond = "(u.Firstname LIKE '%{$name_text1}%' AND u.Lastname LIKE '%{$name_text2}%')";
			}else{
				$name_text1 = $name_arr[0];
                $name_cond = "(u.Firstname LIKE '%{$name_text1}%' OR u.Lastname LIKE '%{$name_text1}%')";
			}
			
			}
			else{
				$name_cond = "";
			}

			$agegroup_cond  = "";

			if($age_group != "" AND $name != ""){
				$agegroup_cond = "AND (u.UserAgegroup {$agegroup})";
			}
			else if($age_group != ""){
                $agegroup_cond = "(u.UserAgegroup {$agegroup})";
			}
			else{
				$agegroup_cond = "";
			}

			if($gender == 'Male'){
               $gender_val = 1;
			}else if($gender == 'Female'){
               $gender_val = 0;
			}else{
			   $gender_val = '';
			}
			

			if($gender != "" AND ($name != "" OR $age_group != "")){
				$gender_cond = "AND (u.Gender = '{$gender_val}')";
			}
			else if($gender != ""){
				$gender_cond = "(u.Gender = '{$gender_val}')";
			}else{
				$gender_cond = "";
			}

			$loc_cond  = "";

			if($name != "" AND $country != "" AND $state != ""){
				$loc_cond = "AND u.Country = '{$country}' AND u.State LIKE '%{$state}%'";
			}
			else if($name != "" AND $country != ""){
                $loc_cond = "AND (u.Country = '{$country}')";
			}
			else if($name != "" AND $state != ""){
                $loc_cond = "AND (u.State LIKE '%{$state}%')";
			}
			else if($age_group != "" AND $country != "" AND $state != ""){
                $loc_cond = "AND u.Country = '{$country}' AND u.State LIKE '%{$state}%'";
			}
			else if($age_group != "" AND $country != ""){
                $loc_cond = "AND (u.Country = '{$country}')";
			}else if($age_group != "" AND $state != ""){
                $loc_cond = "AND (u.State LIKE '%{$state}%')";
			}
			else if($country != "" AND $state != ""){
				$loc_cond = "(u.Country = '{$country}' AND u.State LIKE '%{$state}%')";
			}
			else if($state != ""){
				$loc_cond = "(u.Country = '{$country}' OR u.State LIKE '%{$state}%')";
			}
			else if($country != ""){
				$loc_cond = "(u.Country = '{$country}')";
			}
			else{
				$loc_cond = "";
			}

			if($name != "" OR $country != "" OR $state != "" OR $agegroup_cond != "" OR $gender != ""){
				//$query = $this->db->query(" SELECT * FROM users as u INNER JOIN A2MScore as a ON u.Users_ID = a.Users_ID WHERE {$name_cond} {$agegroup_cond} {$loc_cond} {$sport_cond}");

				$query = $this->db->query("SELECT u.Users_ID, u.FirstName, u.LastName, u.City, u.State, u.UserAgegroup, a.A2MScore, p.Num_Matches, p.Won, p.Lost
				FROM Users AS u 
				JOIN A2MScore AS a ON u.Users_ID = a.Users_ID AND a.SportsType_ID = {$sport}
				JOIN Player_Matches_Count AS p ON u.Users_ID = p.Users_ID AND p.Num_Matches > 0 AND p.Sport = {$sport} 
				WHERE {$name_cond} {$agegroup_cond} {$gender_cond} {$loc_cond} ORDER BY a.A2MScore DESC, p.Won DESC");
			}
			else{
				$query = $this->db->query("SELECT u.Users_ID, u.FirstName, u.LastName, u.City, u.State, u.UserAgegroup, a.A2MScore, p.Num_Matches, p.Won, p.Lost
				FROM Users AS u 
				JOIN A2MScore AS a ON u.Users_ID = a.Users_ID AND a.SportsType_ID = {$sport}
				JOIN Player_Matches_Count AS p ON u.Users_ID = p.Users_ID AND p.Num_Matches > 0 AND p.Sport = {$sport} 
				ORDER BY a.A2MScore DESC, p.Won DESC");
			}
			
			/*print_r($this->db->last_query());
			exit;*/

			return $query->result();
		}

		public function get_user_sport_intrests($user_id,$sport){
			$data = array('users_id'=>$user_id,'Sport_id' => $sport);
			$qry_check = $this->db->get_where('Sports_Interests', $data);
			return $qry_check->result();
		}

		public function get_membership_details($user_id){

			$qr_check = $this->db->query("SELECT * FROM Academy_Users where Users_id = $user_id");
			
			return $qr_check->result();
		}

		public function get_club($org_id){
			$data = array('Org_ID'=>$org_id);
			
			$qry_check = $this->db->get_where('Academy', $data);
			return $qry_check->row_array();
		}

		public function get_user_countries(){
             $qr_check = $this->db->query("SELECT Country FROM Users WHERE Country != 'null' AND Country != '0' AND Country != '' GROUP BY Country");
			  return $qr_check->result();
		}

		public function get_consolation_players($tour_id, $bracket_id){
            /* $qr_check = $this->db->query("SELECT CASE WHEN t1.Winner = t1.Player1 THEN t1.Player2 WHEN t1.Winner = t1.Player2 THEN t1.Player1 ELSE 0 END as Looser FROM Tournament_Matches as t1, Tournament_Matches as t2 where t2.Tourn_ID = {$tour_id} and t2.BracketID = {$bracket_id} and t2.Round_Num = 1 and t2.Draw_Type = 'Consolation' and (t1.Match_Num = t2.Player1_source or t1.Match_Num = t2.Player2_source) and t1.Tourn_ID = {$tour_id} and t1.BracketID = {$bracket_id} and t1.Draw_Type = 'Main'");*/

             /*$qr_check = $this->db->query("SELECT CASE WHEN t1.Winner = t1.Player1 THEN t1.Player2 WHEN t1.Winner = t1.Player2 THEN t1.Player1 ELSE 0 END as Looser, CASE WHEN t1.Winner = t1.Player1 THEN t1.Player2_Partner WHEN t1.Winner = t1.Player2 THEN t1.Player1_Partner ELSE 0 END as Looser_Partner FROM Tournament_Matches as t1, Tournament_Matches as t2 where t2.Tourn_ID = {$tour_id} and t2.BracketID = {$bracket_id} and t2.Round_Num = 1 and t2.Draw_Type = 'Consolation' and (t1.Match_Num = t2.Player1_source or t1.Match_Num = t2.Player2_source) and t1.Tourn_ID = {$tour_id} and t1.BracketID = {$bracket_id} and t1.Draw_Type = 'Main'");*/

			  $qr_check = $this->db->query("SELECT CASE WHEN t1.Winner = t1.Player1 THEN t1.Player2 WHEN t1.Winner = t1.Player2 THEN t1.Player1 ELSE 0 END as Looser, CASE WHEN t1.Winner = t1.Player1 THEN t1.Player2_Partner WHEN t1.Winner = t1.Player2 THEN t1.Player1_Partner ELSE 0 END as Looser_Partner FROM Tournament_Matches as t1, Tournament_Matches as t2 where t2.Tourn_ID = {$tour_id} and t2.BracketID = {$bracket_id} and t2.Round_Num < 4 and (t2.Draw_Type = 'Main' or t2.Draw_Type = 'Consolation') and t1.Tourn_ID = {$tour_id} and t1.BracketID = {$bracket_id} and t1.Draw_Type = 'Main'");


			 return $qr_check->result();
		}

		public function search_coaches($data){
			$name    = $data['coach_name'];
			$sport   = $data['sport'];
			$country = $data['coach_country'];
			$state   = $data['coach_state'];
			
		
			$name_cond  = "";
			
			if($name != "") {
				$name_arr = explode(' ', $name);
				if(count($name_arr)>1) {
					$name_text1 = $name_arr[0];
					$name_text2 = $name_arr[1];
					$name_cond = "(Firstname LIKE '%{$name_text1}%' AND Lastname LIKE '%{$name_text2}%')";
				}
				else {
					$name_text1 = $name_arr[0];
					$name_cond = "(Firstname LIKE '%{$name_text1}%' OR Lastname LIKE '%{$name_text1}%')";
				}
			}
			else {
				$name_cond = "";
			}

			$Sport_cond = "";
			
				if($name !="") {
					$Sport_cond = "AND coach_sport = $sport "; 
				}
				else {
					$Sport_cond = "coach_sport = $sport";
				}

				$loc_cond = '';
			    if($country !="" AND $state != "") {
                     $loc_cond = "AND (Country = '{$country}' AND State LIKE '%{$state}%')";
				}
				else if($country != "") {
					$loc_cond = "AND (Country = '{$country}')";
				}
				else if($state != "") {
                   $loc_cond = "AND (State LIKE '%{$state}%')";
				}
				else {
					$loc_cond = "";
				}

				if($name != "" OR $sport != "" OR $country !="" OR $state != "") {
				$query = $this->db->query(" SELECT * FROM users WHERE {$name_cond} {$Sport_cond} {$loc_cond} AND Is_coach = 1 ");
				}
				else {
				  $query = $this->db->query(" SELECT * FROM users WHERE Is_coach = 1 ");
				}
			  
			/*
			print_r($this->db->last_query());
			exit;*/

			return $query->result();
		}

		public function GetSports(){
			$qry_check = $this->db->query("SELECT * FROM  SportsType");
			return $qry_check->result();
		}

		public function AddClub($data){

            $aca_name          = addslashes($data['club_name']);
			$aca_city          = $data['club_city'];
			$aca_state         = $data['club_state'];
			$aca_country       = $data['club_country'];
			$aca_addr1	       = $data['club_addr1'];
			$aca_addr2		   = $data['club_addr2'];
			$aca_zip	       = $data['club_zipcode'];
			$aca_url           = $data['club_website'];
			$aca_contact_name  = addslashes($data['contact_name']);
			$aca_contact_phone = $data['contact_phone'];
			$aca_contact_email = $data['contact_email'];
			$aca_details       = addslashes($data['club_details']);
			$aca_no_of_courts  = $data['no_of_courts'];
			$aca_sports        = $data['club_sports'];
			$aca_timings       = $data['club_timings'];
			$aca_user_id       = $this->session->userdata('users_id');

			$org_logo		   = $data['club_logo_data'];
			$logo			   = $org_logo['file_name'];

			
			if($aca_user_id){
			$data = array(
						'Aca_name'	        => $aca_name,
						'Aca_city'	        => $aca_city,
						'Aca_state'         => $aca_state,
						'Aca_country'       => $aca_country,	
						'Aca_addr1'			=> $aca_addr1,	
						'Aca_addr2'			=> $aca_addr2,	
						'Aca_zip'			=> $aca_zip,	
						'Aca_url'           => $aca_url,
						'Aca_contact_name'  => $aca_contact_name,
						'Aca_contact_phone'	=> $aca_contact_phone,
						'Aca_contact_email'	=> $aca_contact_email,
						'Aca_logo'          => $logo,
						'Aca_details'       => $aca_details,
						'Aca_no_of_courts'  => $aca_no_of_courts,
						'Aca_sport'         => $aca_sports,
						'Aca_User_id'       => $aca_user_id,
						'Aca_timings'       => $aca_timings
						);

				$result = $this->db->insert('Academy_Info', $data);
			}
				return $data;		
		}

		public function search_clubs($data){

			$club_name   = $data['club_name'];
			$namearr     = explode("'",$club_name);
			$name        = $namearr[0];
			$sport       = $data['sport'];
			$country     = $data['club_country'];
			$state       = $data['club_state'];
			
			$name_cond = "";
			if($name != "")
			{
				$name_cond = "(Aca_name like '%".$name."%')";
			}
			else
			{
				$name_cond = "";
			}

			$Sport_cond = "";
			
				if($name !=""){
					$Sport_cond = "AND Aca_sport LIKE '%".'"'.$sport.'"'."%' "; 
				}
				else
				{
					$Sport_cond = "Aca_sport LIKE '%".'"'.$sport.'"'."%'";
				}
				$loc_cond = '';
			    if($country !="" AND $state != ""){
                     $loc_cond = "AND (Aca_country = '{$country}' AND Aca_state LIKE '%{$state}%')";
				}else if($country != ""){
					$loc_cond = "AND (Aca_country = '{$country}')";
				}else if($state != ""){
                   $loc_cond = "AND (Aca_state LIKE '%{$state}%')";
				}
				else
				{
					$loc_cond = "";
				}
               
				if($name != "" OR $sport != "" OR $country !="" OR $state != ""){
				$query = $this->db->query(" SELECT * FROM Academy_Info WHERE {$name_cond} {$Sport_cond} {$loc_cond} ");
				}
				else
				{
				  $query = $this->db->query(" SELECT * FROM Academy_Info ");
				}

			/*print_r($this->db->last_query());
			exit;*/
        
			return $query->result();
		}
		
		public function get_player_extra_trans($tourn_id){
			
			$player = $this->logged_user;
			$qry_check = $this->db->query("SELECT * FROM  PayTransactions WHERE Users_ID = '{$player}' AND mtype = 'tournament' AND mtype_ref = '{$tourn_id}'");
			return $qry_check->result();
		}

		public function get_player_ref_trans($tourn_id){
			
			$player = $this->logged_user;
			$qry_check = $this->db->query("SELECT * FROM  Refund_Transactions WHERE Users_ID = '{$player}' AND Tournament_ID = '{$tourn_id}'");
			return $qry_check->result();
		}

	    public function AddRating($data){

            $rating        = $data['ratings'];
			$coach_id      = $data['coach_id'];	
			$comments      = $data['comments'];	
			if($data['anonymous']!=""){
              $anonymous     = $data['anonymous'];
			}else{
              $anonymous     = 0;
			}
			
			$user_id       = $this->logged_user;	
			$rated_on      = date("Y-m-d");
			$data = array(						
						'Coach_ID'	     => $coach_id,
						'User_ID'        => $user_id,
						'Ratings'	     => $rating,
						'Comments'	     => $comments,
						'Rate_Anonymous' => $anonymous,
						'Rated_On'       => $rated_on
						);	

			$result = $this->db->insert('Coach_Ratings', $data);			
			return $result;		
		}

		public function UpdateRating($data){

            $rating        = $data['ratings'];
			$coach_id      = $data['coach_id'];	
			$comments      = $data['comments'];	
			if($data['anonymous']!=""){
              $anonymous     = $data['anonymous'];
			}else{
              $anonymous     = 0;
			}
			
			$user_id       = $this->logged_user;	
			$rated_on      = date("Y-m-d");
			$data = array(						
						'Ratings'	     => $rating,
						'Comments'	     => $comments,
						'Rate_Anonymous' => $anonymous,
						'Rated_On'       => $rated_on
						);	
            $this->db->where('Coach_ID', $coach_id);
            $this->db->where('User_ID', $user_id);
			$result = $this->db->update('Coach_Ratings', $data);			
			return $result;		
		}


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

		public function get_tourn_rr_matches($bid){
            $data = array('BracketID' => $bid);
            $query = $this->db->get_where('Tournament_Matches', $data);
            return $query->result();
        }

        public function get_users_bygender($users, $gender){
        	$imp = "'" . implode( "','", $users ) . "'";
			
			$gndr_qry = "";

		    if($gender == 'Men'){
              $gndr_qry = " AND Gender = 1";
            }
			else if($gender == 'Women'){
              $gndr_qry = " AND Gender = 0";
            }

        	$query = $this->db->query(" SELECT Users_ID FROM users WHERE Users_ID IN ({$imp}){$gndr_qry}");

        	/*return $this->db->last_query();
			exit;*/
        	return $query->result(); 
        }

		  public function get_team_participants_count($tourn_id){
				/*$data = array('Tournament_ID' => $tourn_id);
				$query = $this->db->get_where('RegisterTournament', $data);
				$res = $query->result();
				
				$tot_players = 0;
				foreach($res as $i => $r){
					$arr = json_decode($r->Team_Players);
					$tot_players += count($arr);
				}
				return $tot_players;*/

            $data = array('Tournament_ID' => $tourn_id);
            $query = $this->db->get_where('RegisterTournament', $data);
            $res = $query->result();

			return $res;
		 }

		  public function get_indv_participants_count($tourn_id){
				$data = array('Tournament_ID' => $tourn_id);
				$query = $this->db->get_where('RegisterTournament', $data);
				return $query->num_rows();
		  }

		  public function get_bracket_count($tourn_id){
				$data = array('Tourn_ID' => $tourn_id);
				$query = $this->db->get_where('Brackets', $data);
				return $query->num_rows();
		  }

		  public function get_match_info($match_id){
				$qry_check = $this->db->query("SELECT 
				p1.Users_ID as P1_Users_ID,
				p1.Firstname as P1_Firstname,
				p1.Lastname as P1_Lastname,
				p1p.Users_ID as P1P_Users_ID,
				p1p.Firstname as P1P_Firstname,
				p1p.Lastname as P1P_Lastname,
				p2.Users_ID as P2_Users_ID,
				p2.Firstname as P2_Firstname,
				p2.Lastname as P2_Lastname,
				p2p.Users_ID as P2P_Users_ID,
				p2p.Firstname as P2P_Firstname,
				p2p.Lastname as P2P_Lastname,
				tm.*
				FROM Tournament_Matches tm
				LEFT JOIN Users p1 ON tm.Player1 = p1.Users_ID
				LEFT JOIN Users p1p ON tm.Player1_Partner = p1p.Users_ID
				LEFT JOIN Users p2 ON tm.Player2 = p2.Users_ID 
				LEFT JOIN Users p2p ON tm.Player2_Partner = p2p.Users_ID 
				WHERE Tourn_match_id = $match_id");

				return $qry_check->row_array();
		  }

		  public function get_team_match_info($match_id){
			$qry_check = $this->db->query("SELECT 
			t1.Team_ID as P1_Team_ID,
			t1.Team_name as P1_Team_name,
			t2.Team_ID as P2_Team_ID,
			t2.Team_name as P2_Team_name,
			tm.*
			FROM Tournament_Matches tm
			LEFT JOIN Teams t1 ON tm.Player1 = t1.Team_ID
			LEFT JOIN Teams t2 ON tm.Player2 = t2.Team_ID 
			WHERE Tourn_match_id = $match_id");

			return $qry_check->row_array();
		 }

		  public function upd_tourn_desc(){
				$tid   = $this->input->post('tid');
				$tdesc = htmlentities($this->input->post('desc'));

				$data = array('TournamentDescription' => $tdesc);
				$this->db->where('tournament_ID', $tid);
				$query = $this->db->update('tournament', $data);
				return $query;
				/*echo "<pre>";
				print_r($_POST);
				exit;*/
		  }

		public function AddClubRating($data){

            $rating        = $data['ratings'];
			$club_id      = $data['club_id'];	
			$comments      = $data['comments'];	
			if($data['anonymous']!=""){
              $anonymous     = $data['anonymous'];
			}else{
              $anonymous     = 0;
			}
			
			$user_id       = $this->logged_user;	
			$rated_on      = date("Y-m-d");
			$data = array(						
						'Club_ID'	     => $club_id,
						'User_ID'        => $user_id,
						'Ratings'	     => $rating,
						'Comments'	     => $comments,
						'Rate_Anonymous' => $anonymous,
						'Rated_On'       => $rated_on
						);	
 
			$result = $this->db->insert('Club_Ratings', $data);			
			return $result;		
		}

		public function UpdateClubRating($data){

            $rating        = $data['ratings'];
			$club_id      = $data['club_id'];	
			$comments      = $data['comments'];	
			if($data['anonymous']!=""){
              $anonymous     = $data['anonymous'];
			}else{
              $anonymous     = 0;
			}
			
			$user_id       = $this->logged_user;	
			$rated_on      = date("Y-m-d");
			$data = array(						
						'Ratings'	     => $rating,
						'Comments'	     => $comments,
						'Rate_Anonymous' => $anonymous,
						'Rated_On'       => $rated_on
						);	
            $this->db->where('Club_ID', $club_id);
            $this->db->where('User_ID', $user_id);
			$result = $this->db->update('Club_Ratings', $data);			
			return $result;		
		}

		public function getUserClubRatings($club_id){
			$user_id = $this->logged_user;
			$data	 = array('Club_ID' => $club_id, 'User_ID' => $user_id);
			$get_club_ratings = $this->db->get_where('Club_Ratings', $data);
		
			return $get_club_ratings->result();
		}

		public function get_club_Rating($club_id){
			$data = array('Club_ID' => $club_id);
			$get_ratings = $this->db->get_where('Club_Ratings', $data);
			//print_r($get_ratings->result());
			return $get_ratings->result();
		}

		public function update_donations($data){
			$ins = $this->db->insert('Donations', $data);
			return $ins;
		}

		public function insert_ext_sponsor($data){
			$ins = $this->db->insert('Sponsorships', $data);
			return $this->db->insert_id();
		}

		public function update_sponsorships($id, $data){
			$this->db->where('sp_id', $id);
			$query = $this->db->update('Sponsorships', $data);
		}

		public function get_sponsorships($tourn_id){				   
			$data = array('Tourn_ID' => $tourn_id);
			$query = $this->db->get_where('Sponsorships',$data);
			return $query->result();
		}

		public function get_TeamsByCountry($country,$sport){

			if($country == 'United States of America'){
				$qry_str = "(h.hcl_country = '$country' OR h.hcl_country = 'United States' OR h.hcl_country = 'US' OR h.hcl_country = 'U.S.A' OR h.hcl_country = 'USA')";
			}
			else{
				$qry_str = "h.hcl_country = '$country'";
			}

			$qry_check = $this->db->query("SELECT u.Users_ID, u.Firstname,u.Lastname,t.Team_name,t.Captain,t.Created_by,t.Players,t.Team_ID,t.Team_Logo,h.hcl_city,h.hcl_state,a.A2MTeamScore FROM Users u JOIN Teams t ON u.Users_ID = t.Created_by AND t.Sport = '".$sport."' JOIN A2MTeamScore a ON a.Team_ID = t.Team_ID 
			JOIN Home_Court_Locations h ON t.Home_loc_id = h.hcl_id AND {$qry_str} ORDER BY a.A2MTeamScore DESC");

			return $qry_check->result();
		}

/* ******************************** */

	  public function update_teamsport_rr_addscore(){

			$tourn_id		= $this->input->post('tourn_id');
			$tourn_match_id = $this->input->post('tourn_match_id');

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
		$player1_a2mscore	= $this->get_team_a2mscore($player1_user, $match_sport);
		$player2_a2mscore	= $this->get_team_a2mscore($opp_user, $match_sport);

		$player1_part_a2mscore	= "";
		$player2_part_a2mscore	= "";

			if($player1_partner or $opp_user_partner){			// If the Tournament is Double format
				$player1_part_a2mscore	= $this->get_team_a2mscore($player1_partner, $match_sport);
				$player2_part_a2mscore	= $this->get_team_a2mscore($opp_user_partner, $match_sport);
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

		/* --------To allowing of adding an extra points based on player win percentile only for LOOSER  ------- */

		($winner == $player1_user) ? $win_per_p1 = -1 : $win_per_p2 = -1; 

		/* ----------------------------------------------------------------------------------------------------- */

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

			//$winner_a2mscore_updated		=   intval($winner_add_score_points) +  intval($winner_win_points);
			$winner_a2mscore_updated		=   intval($winner_add_score_points);
			//$winner_part_a2mscore_updated	=   intval($winner_part_add_score_points) +  intval($winner_part_win_points);
			$winner_part_a2mscore_updated	=   intval($winner_part_add_score_points);

			$looser_a2mscore_updated		=  - intval($winner_add_score_points) +  intval($looser_win_points);
			$looser_part_a2mscore_updated	=  - intval($winner_part_add_score_points) +  intval($looser_part_win_points);


			// A2MScore Table Update 
			$this->team_a2mscore_update($winner, $winner_a2mscore_updated, $match_sport);
			$this->team_a2mscore_update($winner_partner, $winner_part_a2mscore_updated, $match_sport);

			$this->team_a2mscore_update($looser, $looser_a2mscore_updated, $match_sport);
			$this->team_a2mscore_update($looser_partner, $looser_part_a2mscore_updated, $match_sport);

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

			$winner_a2mscore_updated	=   intval($winner_add_score_points);
			//$winner_a2mscore_updated	=   intval($winner_add_score_points) +  intval($winner_win_points);
			$looser_a2mscore_updated	=  - intval($winner_add_score_points) +  intval($looser_win_points);


			// A2MScore Table Update 
			$this->team_a2mscore_update($winner, $winner_a2mscore_updated, $match_sport);
			$this->team_a2mscore_update($looser, $looser_a2mscore_updated, $match_sport);
		}

		/* ------------------- A2MScore Calculation Section End ---------------- */


		/* ----------Player Number of Matches Update ---------------*/
		if($winner == $player1_user){ $won = 1; $lost = 0; }
		else{ $won = 0; $lost = 1; }

		$p1_num_upd			= $this->team_num_match_update($player1_user, $match_sport, $won, $lost, $win_per_p1);
		$p1_part_num_upd	= $this->team_num_match_update($player1_partner, $match_sport, $won, $lost, $win_per_p1);
//echo "<br>". $player1_user. " ".$match_sport. " ".$won. " ". $lost;
//echo "<br>". $player1_partner. " ".$match_sport. " ".$won. " ". $lost;

		if($winner == $opp_user) { $won = 1; $lost = 0; }
		else{ $won = 0; $lost = 1; }

		$p2_num_upd			= $this->team_num_match_update($opp_user, $match_sport, $won, $lost, $win_per_p2);
		$p2_part_num_upd	= $this->team_num_match_update($opp_user_partner, $match_sport, $won, $lost, $win_per_p2);

//echo "<br>". $opp_user. " ".$match_sport. " ".$won. " ". $lost;
//echo "<br>". $opp_user_partner. " ".$match_sport. " ".$won. " ". $lost;

//exit;

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



public function update_teamsport_addscore(){

/* Gather all post variables */
$tourn_id			= $this->input->post('tourn_id');
$tourn_match_id		= $this->input->post('tourn_match_id');
$draw_name			= $this->input->post('draw_name');
$round_title		= $this->input->post('round_title');
$round_num			= $this->input->post('round_num');

$player1_user		= $this->input->post('player1_user');
$player1_partner	= $this->input->post('player1_user_partner');

$opp_user			= $this->input->post('player2_user');
$opp_user_partner	= $this->input->post('player2_user_partner');		

$p1_score_post		= $this->input->post('player1');
$p2_score_post		= $this->input->post('player2');

$bracket_id			= $this->input->post('bracket_id');
$match_num			= $this->input->post('match_num');
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

$player1_a2mscore	= $this->get_team_a2mscore($player1_user, $match_sport);
$player2_a2mscore	= $this->get_team_a2mscore($opp_user, $match_sport);

$player1_part_a2mscore	= "";
$player2_part_a2mscore	= "";

if($player1_partner or $opp_user_partner){			// If the Tournament is Double format
$player1_part_a2mscore	= $this->get_team_a2mscore($player1_partner, $match_sport);
$player2_part_a2mscore	= $this->get_team_a2mscore($opp_user_partner, $match_sport);
}

/*--------------- Sets score calculation start --------------*/
$p1_score_post = $this->input->post('player1');
$p2_score_post = $this->input->post('player2');

$eval_player_scores = $this->calc_player_scores($p1_score_post, $p2_score_post);

$player1_score		 = $eval_player_scores['Player1_Score'];
$player2_score		 = $eval_player_scores['Player2_Score'];
$player1_score_total = $eval_player_scores['Player1_Tot'];
$player2_score_total = $eval_player_scores['Player2_Tot'];
$player1_sets_win	 = $eval_player_scores['Player1_Sets_Win'];
$player2_sets_win	 = $eval_player_scores['Player2_Sets_Win'];
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

//$winner_a2mscore_updated		=   intval($winner_add_score_points) +  intval($winner_win_points);
$winner_a2mscore_updated		=   intval($winner_add_score_points);
//$winner_part_a2mscore_updated	=   intval($winner_part_add_score_points) +  intval($winner_part_win_points);
$winner_part_a2mscore_updated	=   intval($winner_part_add_score_points);

$looser_a2mscore_updated		=  - intval($winner_add_score_points) +  intval($looser_win_points);
$looser_part_a2mscore_updated	=  - intval($winner_part_add_score_points) +  intval($looser_part_win_points);

//echo "<br>".$winner." - (+)".		  $winner_add_score_points." - ".	  $winner_win_points." - ".     $winner_a2mscore_updated;
//echo "<br>".$winner_partner." - (+)".$winner_part_add_score_points." - ".$winner_part_win_points." - ".$winner_part_a2mscore_updated;

//echo "<br>".$looser." - (-)".     $winner_add_score_points." - ".	  $looser_win_points." - ".		$looser_a2mscore_updated;
//echo "<br>".$looser_partner." - (-)".$winner_part_add_score_points." - ".$looser_part_win_points." - ".$looser_part_a2mscore_updated;

//exit;


// A2MScore Table Update
$this->team_a2mscore_update($winner, $winner_a2mscore_updated, $match_sport);
$this->team_a2mscore_update($winner_partner, $winner_part_a2mscore_updated, $match_sport);

$this->team_a2mscore_update($looser, $looser_a2mscore_updated, $match_sport);
$this->team_a2mscore_update($looser_partner, $looser_part_a2mscore_updated, $match_sport);
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

//$winner_a2mscore_updated =    intval($winner_add_score_points) + intval($winner_win_points);
$winner_a2mscore_updated =    intval($winner_add_score_points);
$looser_a2mscore_updated  =  - intval($winner_add_score_points) + intval($looser_win_points);

// A2MScore Table Update 
$this->team_a2mscore_update($winner, $winner_a2mscore_updated, $match_sport);
$this->team_a2mscore_update($looser, $looser_a2mscore_updated, $match_sport);
}

/* ------------------- A2MScore Calculation Section End ---------------- */


$played_date = $this->input->post('tour_match_date');


/* ----------Player Number of Matches Update ---------------*/
if($winner == $player1_user){ $won = 1; $lost = 0; }
else{ $won = 0; $lost = 1; }


$p1_num_upd			= $this->team_num_match_update($player1_user, $match_sport, $won, $lost, $win_per_p1);
$p1_part_num_upd	= $this->team_num_match_update($player1_partner, $match_sport, $won, $lost, $win_per_p1);

if($winner == $opp_user) { $won = 1; $lost = 0; }
else{ $won = 0; $lost = 1; }

$p2_num_upd			= $this->team_num_match_update($opp_user, $match_sport, $won, $lost, $win_per_p2);
$p2_part_num_upd	= $this->team_num_match_update($opp_user_partner, $match_sport, $won, $lost, $win_per_p2);


/* --------------- Match Result Update ------------------------------------------- */

$data = array(
'Match_Date' => $played_date,
'Player1_Score' => $player1_score,
'Player2_Score' => $player2_score,
'Winner' => $winner);

$this->db->where('Tourn_match_id', $tourn_match_id);
$result = $this->db->update('Tournament_Matches', $data); 

/* ------------------------------------------------------------------------------ */


/* ------- Update player1 and player2 sources --------- */

$qry_string = "";

if($draw_name == "Consolation"){
$qry_string = " AND Round_Num != 1";
}

$this->update_source_matches_main($bracket_id, $match_num, $draw_name, $winner, $winner_partner, $qry_string);

/* ------- Update player1 and player2 sources -------- */


if($draw_name == "Main"){

$bracket_draw_type = 
//$this->db->query("SELECT Tournament_type FROM tournament WHERE tournament_ID = $tourn_id AND Tournament_type = 'Consolation'");
$this->db->query("SELECT Bracket_Type FROM Brackets WHERE Tourn_ID = $tourn_id AND BracketID = $bracket_id AND Bracket_Type = 'Consolation'");

if($bracket_draw_type->num_rows() > 0 and ($round_num == 1 or $round_num == 2)){

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


		public function edit_teamsport_match_score()
{
		/* ------------------- A2MScore Calculation Section ---------------- */
			//$tourn_id = $data['tourn_id']; 
			$tourn_id		= $this->input->post('tourn_id');
			$tourn_match_id = intval($this->input->post('tourn_match_id'));
			
			$qry_check		= $this->db->query("SELECT * FROM Tournament_Matches WHERE Tourn_match_id = $tourn_match_id ");
			$match_details  = $qry_check->row_array();

			$round_num		= $match_details['Round_Num'];

			$draw_name		= $this->input->post('draw_name');
			if($draw_name == "") { $draw_name = 'Main'; }

			$round_title = $this->input->post('round_title');
		
			$data		= array('tournament_ID' => $tourn_id);
			$macth_init =  $this->db->get_where('tournament',$data);
			$match_init_user = $macth_init->row_array();

		$player1_user	 = $this->input->post('player1_user');
		$player1_partner = $this->input->post('player1_user_partner');

		$opp_user		  = $this->input->post('player2_user');
		$opp_user_partner = $this->input->post('player2_user_partner');

		$match_sport = $match_init_user['SportsType'];


			$data = array('Sport'=>$match_sport, 'Team_ID'=>$player1_user);
			$get_a2mscore1 = $this->db->get_where('A2MTeamScore',$data);
			$p1_a2mscore = $get_a2mscore1->row_array();

			$data = array('Sport'=>$match_sport, 'Team_ID'=>$opp_user);
			$get_a2mscore2 = $this->db->get_where('A2MTeamScore',$data);
			$p2_a2mscore = $get_a2mscore2->row_array();


		$player1_a2mscore = $p1_a2mscore['A2MTeamScore'];
		$player2_a2mscore = $p2_a2mscore['A2MTeamScore'];


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

					$qry_check_draw_type = 
						//$this->db->query("SELECT Tournament_type FROM tournament WHERE tournament_ID = $tourn_id AND Tournament_type = 'Consolation'");
						$this->db->query("SELECT Bracket_Type FROM Brackets WHERE Tourn_ID = $tourn_id AND BracketID = $bracket_id AND Bracket_Type = 'Consolation'");

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

		public function update_teamsport_wff(){

			$tourn_id		= $this->input->post('tourn_id');
			$tourn_match_id = intval($this->input->post('tourn_match_id'));
			$draw_name		= $this->input->post('draw_name');
				if($draw_name == "") { $draw_name = "Main"; }

			$round_title	= $this->input->post('round_title');
			$qry_check		= $this->db->query("SELECT * FROM Tournament_Matches WHERE Tourn_match_id = $tourn_match_id ");

			if($qry_check->num_rows() > 0){
					$players = $qry_check->row_array();
					$round_num = $players['Round_Num'];

					$p1 = $players['Player1'];
					$p2 = $players['Player2'];
			}

			$winner = $this->input->post('id');
			if($winner == $p1){
				$p1_points  = 3;
				$p2_points  = 0;
				$looser		= $p2;
			}
			else{
				$p2_points  = 3;
				$p1_points  = 0;
				$looser		= $p1;
			}

			$played_date	= date("Y-m-d h:i:s");
			$player1_score  = "[0]";
			$player2_score  = "[0]";


			$data = array(
				'Match_Date'	 => $played_date,
				'Player1_Score'  => $player1_score,
				'Player2_Score'	 => $player2_score,
				'Player1_points' => $p1_points,
				'Player2_points' => $p2_points,
				'Winner'		 => $winner);
			
			$this->db->where('Tourn_match_id', $tourn_match_id);
			$result = $this->db->update('Tournament_Matches', $data);



			/* ----------Player Number of Matches Update ---------------*/

			$data		= array('tournament_ID'=>$tourn_id);
			$query		= $this->db->get_where('tournament',$data);
			$get_match  =  $query->row_array();

			$player1_user	 = $p1;
			$opp_user		 = $p2;

			$match_sport = $get_match['SportsType'];

			if($winner == $player1_user){ $won = 1; $lost = 0; }
			else{ $won = 0; $lost = 1; }
			$win_per_p1 = 0.00;

			$p1_num_upd = $this->team_num_match_update($player1_user, $match_sport, $won, $lost, $win_per_p1);

			if($winner == $opp_user) { $won = 1; $lost = 0; }
			else{ $won = 0; $lost = 1; }
			$win_per_p2 = 0.00;

			$p2_num_upd	= $this->team_num_match_update($opp_user, $match_sport, $won, $lost, $win_per_p2);

			/* ---------------------------------------------------------- */


			/* --- update player1 and player2 sources ---- */
			$bracket_id = $this->input->post('bracket_id');
			$match_num  = $this->input->post('match_num');


			$qry_string = "";

			if($draw_name == "Consolation"){
				$qry_string = " AND Round_Num != 1";
			}
			
			$winner_partner = '';
			$this->update_source_matches_main($bracket_id, $match_num, $draw_name, $winner, $winner_partner, $qry_string);

			/* --- update player1 and player2 sources ---- */

/* --- Update Consolation Draw Sources ---- */

			if($draw_name == "Main"){

				$bracket_draw_type = 
					//$this->db->query("SELECT Tournament_type FROM tournament WHERE tournament_ID = $tourn_id AND Tournament_type = 'Consolation'");
					$this->db->query("SELECT Bracket_Type FROM Brackets WHERE Tourn_ID = $tourn_id AND BracketID = $bracket_id AND Bracket_Type = 'Consolation'");

				if($bracket_draw_type->num_rows() > 0 and ($round_num == 1 or $round_num == 2)){
				$loser_partner = '';

					if($round_num == 1)
					{ $this->update_cons_sources($bracket_id, $match_num, $looser, $loser_partner); }
					else{
						$check_looser_played_count = 
						$this->db->query("SELECT * FROM Tournament_Matches WHERE 
							((Player1 = $looser AND Player2 = 0) OR 
							(Player2 = $looser AND Player1 = 0)) AND 
							Winner = $looser AND 
							BracketID = $bracket_id AND 
							Draw_Type = 'Main' AND 
							Round_Num = 1");

						if($check_looser_played_count->num_rows() > 0){		// Looser has Bye Match in Round 1
							$this->update_cons_sources($bracket_id, $match_num, $looser, $loser_partner);
						}
						else{
							$this->cancel_esclating_looser_cons($bracket_id, $match_num, $looser, $loser_partner);
						}
					}
				}

			}

/* --- End of update Consolation Draw Sources ---- */

			$data = array('player1'=>$player1_user, 'player2'=>$opp_user, 'tourn_id'=>$tourn_id, 'winner'=>$winner, 'type'=>'wff', 'round_title'=>$round_title, 'draw_name'=>$draw_name);

			return $data;
		}


		public function calculate_match_format($user, $partner){	// Format Calculation Section
			
			$mformat	= "Singles";
			$user_det = $this->get_user_name($user);

			if($partner){
				$partner_det = $this->get_user_name($partner);
				$mformat = ($user_det['Gender'] == $partner_det['Gender']) ? "Doubles" : "Mixed";
			}
		
			return $mformat;
		}

		public function get_team_tourn_matches($team, $tourn, $bid){
			if($bid != ''){
				$query = $this->db->query("SELECT * FROM Tournament_Matches WHERE (Player1 = $team OR Player2 = $team) AND Tourn_ID = $tourn AND BracketID = $bid");
			}
			else{
				$query = $this->db->query("SELECT * FROM Tournament_Matches WHERE (Player1 = $team OR Player2 = $team) AND Tourn_ID = $tourn");
			}
			
			return $query->result();
		}

		public function get_team_tourn_lines($match_id){
			$query = $this->db->query("SELECT * FROM Tournament_Lines WHERE Tourn_match_id = $match_id");
			
			return $query->result();
		}

		public function get_bracket_detailsScoreCard4($bid){
			/*$query = $this->db->query("SELECT b.*,t.tournament_title from Brackets b JOIN tournament t ON 
										b.Tourn_ID = t.tournament_ID JOIN Tournament_Matches tm ON tm.BracketID = b.BracketID WHERE b.BracketID = $bid;");*/

			$query = $this->db->query("SELECT tm.*,b.*,t.tournament_title,t.SportsType from Brackets b JOIN tournament t 
			ON b.Tourn_ID = t.tournament_ID JOIN Tournament_Matches tm ON tm.BracketID = b.BracketID WHERE b.BracketID = $bid;");

		 	return $query->result();
		}

		public function get_level_brackets($tid, $level){
				$cond = "";
			if($level){
				$cond .= " AND Filter_Events LIKE '%{$level}%'";
			}
			$query = $this->db->query("SELECT * FROM Brackets WHERE Tourn_ID = {$tid}{$cond}");
			//echo $this->db->last_query();
			return $query->result();
		}

		public function get_reg_level_teams($tid, $level){
			$query = $this->db->query("SELECT * FROM RegisterTournament WHERE Tournament_ID = {$tid} AND Reg_Sport_Level = '{$level}'");
			//echo $this->db->last_query();
			return $query->result();
		}

		public function update_teams_levels($data2){
		 	$data = array('Reg_Sport_Level' => $data2['level']);
 			$this->db->where('Team_id', $data2['team']);
			$this->db->where('Tournament_ID', $data2['tour_id']);
			$upd_level = $this->db->update('RegisterTournament', $data);

			return $upd_level;
		}

		public function getUserInfo($user, $sport){
			$query = $this->db->query("SELECT * FROM Users u JOIN A2MScore a ON u.Users_ID = a.Users_ID WHERE u.Users_ID ='".$user."' AND a.SportsType_ID ='".$sport."'");
			//echo $this->db->last_query();
			return $query->row_array();
		}

		public function get_usatt_membership_details($user_id){
			$qr_check = $this->db->query("SELECT * FROM User_memberships where Users_id = $user_id AND Club_id = 139");		
			return $qr_check->row_array();
		}

		public function is_user_have_usatt_table_entry($user){
			if(!$user){
				echo "Invalid User!"; 
				exit;
			}

			$get_prof_usatt = $this->get_usatt_membership_details($user);

			if(count($get_prof_usatt) > 0){
				$mem_id = $get_prof_usatt['Membership_ID'];
				$query = $this->db->query("SELECT * FROM USATTMembership WHERE Member_ID = '".$mem_id."'");
			}
			else{

				$get_user = $this->db->query("SELECT * FROM Users WHERE Users_ID = '".$user."'");
				$user_det = $get_user->row_array();
				$user_dob = date('n/j/Y', strtotime($user_det['DOB']));
				//echo $user_dob;
				$fname = substr($user_det['Firstname'], 0, 3);
				$lname = substr($user_det['Lastname'], 0, 3);

				$query = $this->db->query("SELECT * FROM USATTMembership WHERE [First Name] LIKE '".$fname."%' AND [Last Name] LIKE '".$lname."%' AND [Date of Birth] = '".$user_dob."'");
			}
			
			//if($user == '1298'){
			//echo $this->db->last_query();
			//echo "<pre>";
			//print_r($query->result_array);
			//}

			return $query->row_array();
		}

	/* Coupons Code */
		public function get_coupon_codes($id){
				$this->db->select('*');
				$this->db->from('Coupon_Codes');
				$this->db->where('Ref_ID =', $id);
				$query  = $this->db->get();

			 return $query->result_array();
		}
	/* Coupons Code */

	  public function get_currencyCode($country){
			$data = array('country'=>$country);
			$query = $this->db->get_where('Currency',$data);
  			return $query->row_array();
	  }

	  public function get_allCurrencyCodes(){
					 $this->db->distinct();
					 $this->db->select('code');
			$query = $this->db->get('Currency');
			$codes = $query->result(); 
  			return $codes;
	  }

	  public function get_paypalids($userid){
			$query = $this->db->query("SELECT pp_busi_id, paypal_merch_id FROM Paypal_Business_Accounts WHERE users_id = {$userid} AND status = 1");

			return $query->result();
	  }

		public function get_cl_positions($data){
			$bracket_id = $data['bracket_id'];

			$data = array('Bracket_ID' => $bracket_id);

  					 $this->db->order_by("Position", "ASC"); 
			$query = $this->db->get_where('CL_Positions',$data);

			return $query;
		}
	
		public function get_cl_user_position($bracket_id, $player){
			$query = $this->db->query("SELECT * FROM CL_Positions WHERE Bracket_ID = {$bracket_id} AND (Player = {$player} OR Player_Partner = {$player})");
			$res   = $query->row_array();
			return $res['Position'];
		}

		public function add_new_cl_player($data){
			$new_reg = $this->db->insert('CL_Positions', $data);
			return $new_reg;
		}

		public function add_new_challenge($tourn_id, $bracket_id, $user, $ch_player){

			$cond  = array('BracketID' => $bracket_id);
			$query = $this->db->get_where('Brackets', $cond);
			$get_bracket = $query->row_array();
			
			$qry_partner = $this->db->query("SELECT Player_Partner FROM CL_Positions WHERE Player = {$ch_player} AND Bracket_ID = {$bracket_id} AND Tourn_ID = {$tourn_id}");
			$get_player_partner = $qry_partner->row_array();

			$qry_partner2 = $this->db->query("SELECT Player_Partner FROM CL_Positions WHERE Player = {$user} AND Bracket_ID = {$bracket_id} AND Tourn_ID = {$tourn_id}");
			$get_ch_partner = $qry_partner2->row_array();


			$data['Tourn_ID']		= $tourn_id;
			$data['Bracket_ID']		= $bracket_id;
			$data['Challenged_by']  = $user;
			$data['Player']		    = $ch_player;

			$data['Player_Partner'] = NULL;
			if($get_player_partner['Player_Partner']){
			$data['Player_Partner']	= $get_player_partner['Player_Partner'];
			}

			$data['Ch_Partner'] = NULL;
			if($get_ch_partner['Player_Partner']){
			$data['Ch_Partner']	= $get_ch_partner['Player_Partner'];
			}
			else{
				$qry_partner3 = $this->db->query("SELECT Player FROM CL_Positions WHERE Player_Partner = {$user} AND Bracket_ID = {$bracket_id} AND Tourn_ID = {$tourn_id}");
				$get_ch_partner = $qry_partner3->row_array();
				if($get_ch_partner['Player']){
				$data['Ch_Partner']	= $get_ch_partner['Player'];
				}
			}

			$data['Ch_Date']		= date('Y-m-d H:i:s');
			$data['Ch_Expires_On']	= date('Y-m-d', strtotime("+".$get_bracket['Ch_Duration']." day"));
			$data['Status']		    = 'Pending';

			$new_ch = $this->db->insert('CL_Challenges', $data);
			$ch_id	= $this->db->insert_id();

		 	$data3 =  array('Challenged_by' => $user, 'Challenger_Partner' => $data['Ch_Partner']);
					 $this->db->where('Player',			$ch_player);
					 $this->db->where('Bracket_ID',		$bracket_id);
					 $this->db->where('Tourn_ID',		$tourn_id);
			$upd  =  $this->db->update('CL_Positions',  $data3);

			/* Create a Challenge Match */
			$data2 = array();
			$data2['Tourn_ID']		= $tourn_id;
			$data2['BracketID']		= $bracket_id;
			$data2['Round_Num']	    = 1;
			$data2['Match_Num']	    = $ch_id;
			$data2['Player1']		= $user;
			$data2['Player2']		= $ch_player;
			$data2['Winner']		= 0;

			$data2['Player1_Partner'] = NULL;
			if($data['Ch_Partner']){
				$data2['Player1_Partner'] = $data['Ch_Partner'];
			}

			$data2['Player2_Partner'] = NULL;
			if($data['Player_Partner']){
				$data2['Player2_Partner'] = $data['Player_Partner'];
			}
				
			$data2['Match_DueDate']	= date('Y-m-d', strtotime("+".$get_bracket['Ch_Duration']." day"));
			$data2['Draw_Type']		= 'Ladder';
			/*echo "<pre>";
			print_r($data);
			print_r($data2);
			exit;*/
			$new_match = $this->db->insert('Tournament_Matches', $data2);
			/* Create a Challenge Match */

			return $new_ch;
		}

		public function upd_positions($levels){

			if(!empty($levels)){
				foreach($levels as $level){
					$vals  = explode('_', $level);
					$data  = array('Position' => $vals[1]);

							 $this->db->where('CL_Id', $vals[0]);
					$upd  =  $this->db->update('CL_Positions',  $data);
				}
			}

			return $upd;
		}

		public function cancel_ch($cl_id){
			$val		= $this->input->post('cl_id');
			$exp	    = explode('_', $val);

			$cl_id		= $exp[0];
			$player		= $exp[1];
			$cl_by		= $exp[2];
			$tourn_id	= $this->input->post('tourn_id');
			$bracket_id	= $this->input->post('bracket_id');
			$status		= 'Pending';

			
		 	$data =  array('Challenged_by' => NULL);
					 $this->db->where('CL_Id', $cl_id);
			$upd1  =  $this->db->update('CL_Positions',  $data);			// Update Positions table


		 	$data   = array('Tourn_ID' => $tourn_id, 'Bracket_ID' => $bracket_id, 'Challenged_by' => $cl_by, 'Player' => $player);
			$query  = $this->db->get_where('CL_Challenges', $data);
			$get_ch = $query->row_array();								// Get a specific Challenge

			

			$data2 = array('Status' => 'Cancelled');
					 $this->db->where(array('CH_Id' => $get_ch['CH_Id']));
			$upd2  = $this->db->update('CL_Challenges',  $data2);			// Update Challenges table


			$data3 = array('Tourn_ID' => $tourn_id, 'BracketID' => $bracket_id, 'Match_Num' => $get_ch['CH_Id']);
					 $this->db->where($data3);
			$upd3  = $this->db->delete('Tournament_Matches'); 				// Delete a Match

			if($upd1 and $upd2 and $upd3) return true;
			else return false;
		}

		public function update_ladder($data){
		 	$data2 =  array('Challenged_by' => NULL, 'Challenger_Partner' => NULL);
					 $this->db->where('Bracket_ID', $data['bracket_id']);
					 $this->db->where('Player',		$data['player']);
					 $this->db->where('Challenged_by', $data['challeger']);
			$upd1  = $this->db->update('CL_Positions',  $data2);			// Update Positions table
			//echo $this->db->last_query();

		 	$data2 =  array('Status' => 'Completed');
					 $this->db->where(array('CH_Id' => $data['match_num']));
			$upd1  = $this->db->update('CL_Challenges',  $data2);			// Update Challenges table
			//echo $this->db->last_query();
		}

		public function swap_player_positions($data){
			$qry1 = $this->db->query("UPDATE CL_Positions SET Position = {$data['ch_pos']} WHERE Bracket_ID = {$data['bracket_id']} AND (Player = {$data['player']} OR Player_Partner = {$data['player']})");    // Update Player Position

			$qry2 = $this->db->query("UPDATE CL_Positions SET Position = {$data['p_pos']} WHERE Bracket_ID = {$data['bracket_id']} AND (Player = {$data['challeger']} OR Player_Partner = {$data['challeger']})"); // Update Challenger Position
		}

		public function get_player_matches($tourn_id, $player){
			$query = $this->db->query("SELECT * FROM Tournament_Matches WHERE Tourn_ID = {$tourn_id} AND (Player1 = {$player} OR Player2 = {$player} OR Player1_Partner = {$player} OR Player2_Partner = {$player}) AND Winner IS NOT NULL AND Winner != '' AND Player1 != 0 AND Player2 != 0");
			return $query->result_array();
		}

		public function get_player_team_matches($tourn_id, $player){
			$query = $this->db->query("SELECT * FROM Tournament_Lines WHERE Tourn_ID = {$tourn_id} AND (Player1 = {$player} OR Player2 = {$player} OR Player1_Partner = {$player} OR Player2_Partner = {$player}) AND Winner IS NOT NULL AND Winner != '' AND Player1 != 0 AND Player2 != 0");
			return $query->result_array();
		}

		public function get_player_points($bracket_id, $player){
			$query = $this->db->query("SELECT * FROM Tournament_Matches WHERE BracketID = {$bracket_id} AND (Player1 = {$player} OR Player2 = {$player} OR Player1_Partner = {$player} OR Player2_Partner = {$player}) AND Winner IS NOT NULL AND Winner != ''");
			return $query->result_array();
		}

		public function insert_usatt_membership($member_id){
		    $user_id		= $this->logged_user;
			$org_id			= 139;
			$related_sport  = 2;

			$data = array(
					'Club_id'		=> $org_id,
					'Membership_ID' => $member_id,
					'Users_id'		=> $user_id,
					'Related_Sport'	=> $related_sport,
					'Member_Status'	=> 1
				    );

			//$result = $this->db->insert('Academy_users', $data);
			$result = $this->db->insert('User_memberships', $data);

			return $result;
		}

		public function get_bracket_detailsScoreSheet($bid){
			$query = $this->db->query("SELECT tm.*,b.*,t.tournament_title,t.SportsType,t.Singleordouble from Brackets b JOIN tournament t ON b.Tourn_ID = t.tournament_ID JOIN Tournament_Matches tm ON tm.BracketID = b.BracketID WHERE b.BracketID = $bid;");

		 	return $query->result();
		}

		public function update_tourn_attachments($name,$tid){
			$data = array('TournamentImage' => $name[0], 'DetailsRules_pdf' => $name[1], 'MedicalRelease_pdf' => $name[2]);
            $this->db->where('tournament_ID', $tid);
			$this->db->update('tournament' ,$data);	
		}

		public function update_checkIn($uId, $tId, $checkIn){
			$data = array('is_checkin' => $checkIn);
					$this->db->where('Tournament_ID', $tId);
					$this->db->where('Users_ID', $uId);
			$upd  = $this->db->update('RegisterTournament', $data);	

			return $upd;
		}

		public function get_checkIn_players($tid){
			$this->db->select('Users_ID');
			$this->db->from('RegisterTournament');
				$this->db->where('Tournament_ID', $tid);
				$this->db->where('is_checkin', 1);
				$query  = $this->db->get();

			 return $query->result_array();
		}

		public function is_player_checkin($tid, $user_id){
				$this->db->select('is_checkin');
				$this->db->from('RegisterTournament');
				$this->db->where('Users_ID', $user_id);
				$this->db->where('Tournament_ID', $tid);
				$query  = $this->db->get();

				$x = $query->row_array();
				return $x['is_checkin'];
		}

		public function user_usatt_update()
		{
		    $user_id = $this->logged_user;
			
			$org_id = 139;
			$mem_id = $this->input->post('usatt_member_id');
			$related_sport = 2;

			$data = array(
					'Club_id'		=> $org_id,
					'Membership_ID' => $mem_id,
					'Users_id'		=> $user_id,
					'Related_Sport' => $related_sport,
					'Member_Status' => 1
				    );
			$result = $this->db->insert('User_memberships', $data);

			return $result;
		}

		//public function update_user_a2m($user, $sport, $upd_a2m){
		public function update_user_a2m($user, $sport, $sl_a2m, $db_a2m = '',  $mx_a2m = ''){
			if($sl_a2m > 0)
				$data['A2MScore'] = $sl_a2m;
			if($db_a2m > 0)
				$data['A2MScore_Doubles'] = $db_a2m;
			if($mx_a2m > 0)
				$data['A2MScore_Mixed'] = $mx_a2m;

			if($data){
								$this->db->where('Users_ID', $user);
								$this->db->where('SportsType_ID', $sport);
				$query = $this->db->update('A2MScore', $data);
				return $query;
			}
			else{
				return false;
			}
		}

		public function get_rep_events($ev_id){
			
			$data = array('Ev_ID'=>$ev_id);
			$get_sp_name = $this->db->get_where('Ev_Repeat_Schedule',$data);
			return $get_sp_name->result();
		}

		public function ins_ev_invite($data){

			$user_id   = $data['user'];
			$event_id  = $data['event_id'];
			$ev_rep_id = $data['ev_rep_id'];
			$status    = 'Pending';

			if($data['ev_status']){
			$status = $data['ev_status'];
			}

			$data = array(
					'Ev_ID'		=> $event_id,
					'Ev_Rep_ID' => $ev_rep_id,
					'Users_Id'  => $user_id,
					'Ev_status' => $status
					);

			$result = $this->db->insert('Ev_Inv_Status', $data);
		    return  $result; 
	    }

		public function get_event_row($eve_sport_type){
			$data = array('Ev_Sport'=>$eve_sport_type, 'Ev_Type_ID'=>3);
			$get_sp_name = $this->db->get_where('Events',$data);
			return $get_sp_name->result();
		}

		public function getEventLocation($loc_id){
			$data = array('loc_id' => $loc_id);
			$query = $this->db->get_where('Events_Locations',$data);
			return $query->row_array();
		}

		public function get_tourbased_users($tourn_id)
		{
			$query = $this->db->query("SELECT Users_ID FROM users WHERE Users_ID NOT IN (SELECT Users_ID from RegisterTournament WHERE Tournament_ID = '$tourn_id')");

			return $query->result();
		}


		public function publish_draws($bracket_id){
			$data = array('is_Publish' => 1);
							$this->db->where('BracketID', $bracket_id);
			$query = $this->db->update('Brackets', $data);
			return $query;
		}
		public function unpublish_draws($bracket_id){
			$data = array('is_Publish' => 0);
							$this->db->where('BracketID', $bracket_id);
			$query = $this->db->update('Brackets', $data);
			return $query;
		}

		public function upd_team_homeloc($tm, $team){
			$upd_qry = $this->db->query("UPDATE Tournament_Matches SET Match_Location_User = {$team} WHERE Tourn_match_id = {$tm} ");
			//echo $this->db->last_query();
			return $upd_qry;
		}
		public function upd_match_date($tm, $dt){
			$upd_qry = $this->db->query("UPDATE Tournament_Matches SET Match_DueDate = '{$dt}' WHERE Tourn_match_id = {$tm} ");
			//echo $this->db->last_query();
			return $upd_qry;
		}
		public function get_court_matches($tid){
			$get_qry = $this->db->query("SELECT b.Draw_Title, tm.* FROM Tournament_Matches tm join Brackets b 
			ON b.BracketID = tm.BracketID WHERE tm.Tourn_ID = {$tid} AND (tm.Court_Info IS NOT NULL and tm.Court_Info != '0' and tm.Court_Info != '') and (tm.Match_DueDate IS NOT NULL and tm.Match_DueDate != '') and (Draw_Type = 'Main' OR Draw_Type = 'Round Robin') ORDER BY tm.Match_DueDate ASC");
			//echo $this->db->last_query();
			return $get_qry;
		}

		public function insert_init_rating($user_id, $tourn_id, $bracket_id, $draw_format = ''){

			$check_rec  = $this->db->query("SELECT * FROM Users_League_Rating WHERE Users_ID = {$user_id} AND Tourn_ID = {$tourn_id} AND Bracket_ID = {$bracket_id}");
			$ins = 0;
				if($check_rec->num_rows() == 0){

					$tour_det		= $this->db->query("SELECT * FROM tournament WHERE tournament_ID = {$tourn_id}");
					$trd = $tour_det->row_array();
					$sport = $trd['SportsType'];
					$player_a2m  = $this->db->query("SELECT * FROM A2MScore WHERE Users_ID = {$user_id} AND SportsType_ID = {$sport}");

					if($player_a2m->num_rows() > 0){
					$plr = $player_a2m->row_array();

					if($draw_format){
						if($draw_format == 'singles')
							$init_a2m = $plr['A2MScore'];
						if($draw_format == 'doubles')
							$init_a2m = $plr['A2MScore_Doubles'];
						if($draw_format == 'mixed')
							$init_a2m = $plr['A2MScore_Mixed'];
					}
					else{
					$init_a2m = max($plr['A2MScore'], $plr['A2MScore_Doubles'], $plr['A2MScore_Mixed']);
					}
	

					$data = array(
					'Users_ID' => $user_id,
					'Tourn_ID' => $tourn_id,
					'Bracket_ID' => $bracket_id,
					'Init_Rating' => $init_a2m,
					'Upd_Rating' => $init_a2m,
					'Created_On' => date('Y-m-d H:i:s'),
					'Updated_On' => date('Y-m-d H:i:s')				
					);
					$ins = $this->db->insert('Users_League_Rating', $data);
					}
			}

			return $ins;
		}

		public function update_player_standings($user_id, $tourn_id, $bracket_id, $a2m_points){
				$data = array('Users_ID' => $user_id, 'Tourn_ID' => $tourn_id, 'Bracket_ID' => $bracket_id);
				$qry = $this->db->get_where('Users_League_Rating', $data);

				if($qry->num_rows() > 0){
					$get_rec = $qry->row_array();
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

		public function get_lg_std_final_ratings($user_id, $tourn_id, $init_rating){
				$qry  = $this->db->query("SELECT * FROM Users_League_Rating WHERE Users_ID = {$user_id} AND Tourn_ID = {$tourn_id}");

				$res =  $qry->result_array();
				$cm = 0;
				foreach($res as $r){
					$cm += $r['Upd_Rating'] - $r['Init_Rating'];
				}

				return $init_rating+$cm;
		}

		public function get_draw_std_init_ratings($user_id, $bid){
				$qry  = $this->db->query("SELECT * FROM Users_League_Rating WHERE Users_ID = {$user_id} AND Bracket_ID = {$bid}");

				if($qry->num_rows() > 0)
					return $qry->row_array();
				else
					return false;
		}

		public function get_tourn_winners($tourn_id, $bid) {
				$qry = $this->db->query("SELECT tm.Draw_Type, b.Bracket_Type,tm.Winner,tm.Player1,tm.Player2,tm.Player1_Partner,tm.Player2_Partner,* 
				FROM Brackets b JOIN Tournament_Matches tm ON b.BracketID = tm.BracketID WHERE
				(b.No_of_rounds = tm.Round_Num OR tm.Round_Num = '-1') AND tm.Draw_Type = 'Main' AND b.Tourn_ID = {$tourn_id} AND b.BracketID = {$bid}");

				return $qry->result();
		}

		public function get_tourn_cons_winners($tourn_id, $bid) {
				$qry = $this->db->query("SELECT tm.Draw_Type, b.Bracket_Type,tm.Winner,tm.Player1,tm.Player2,tm.Player1_Partner,tm.Player2_Partner,* 
				FROM Brackets b JOIN Tournament_Matches tm ON b.BracketID = tm.BracketID WHERE
				(tm.Round_Num = (SELECT MAX(Round_Num) as RN FROM Tournament_Matches where Draw_Type = 'Consolation' AND Tourn_ID = {$tourn_id} AND BracketID = {$bid})) AND tm.Draw_Type = 'Consolation' AND b.Tourn_ID = {$tourn_id} AND b.BracketID = {$bid}");

				return $qry->result();
		}

		public function get_tourn_rr_winners($bid) {
				$qry1 = $this->db->query("select tm.Player1 as Player, tm.Player1_Partner as Player_Partner, sum(tm.Player1_points) as Points, CONCAT(tm.Player1_Score) as Player_Score from Tournament_Matches tm where BracketID = {$bid} group by Player1,Player1_Partner");

				$res1 = $qry1->result_array();

				$qry2 = $this->db->query("select tm.Player2 as Player, tm.Player2_Partner as Player_Partner, sum(tm.Player2_points) as Points, CONCAT(tm.Player2_Score) as Player_Score from Tournament_Matches tm where BracketID = {$bid} group by Player2,Player2_Partner");

				$res2 = $qry2->result_array();
				return array_merge($res1, $res2);
		}

		public function esc_semi_final_losers($bracket_id, $match_num, $looser, $looser_partner){
			
				$qry_check_p1 = $this->db->query("SELECT * FROM Tournament_Matches WHERE Round_Num = -1 AND Player1_source = $match_num AND BracketID = $bracket_id");
				if($qry_check_p1->num_rows() > 0){
						$get_res = $qry_check_p1->row_array();
						$tid = $get_res['Tourn_match_id'];
						$qry_upd_p1 = $this->db->query("UPDATE Tournament_Matches SET Player1 = {$looser}, Player1_Partner = {$looser_partner} WHERE Tourn_match_id = $tid");  // new

				}
				else{
				$qry_check_p2 = $this->db->query("SELECT * FROM Tournament_Matches WHERE Round_Num = -1 AND Player2_source = $match_num AND BracketID = $bracket_id");
					if($qry_check_p2->num_rows() > 0){
						$get_res2 = $qry_check_p2->row_array();
						$tid = $get_res2['Tourn_match_id'];
						$qry_upd_p1 = $this->db->query("UPDATE Tournament_Matches SET Player2 = {$looser}, Player2_Partner = {$looser_partner} WHERE Tourn_match_id = $tid");  // new
					}
				}
		}

		public function calc_picball_addscore_points($score_diff, $winner, $max_a2mscore_user){
//echo var_dump($score_diff);
//echo $winner."-".$max_a2mscore_user;
//if ($score_diff >= 0 and $score_diff <= 0.05) { echo "test"; }


if($score_diff >= 0 and $score_diff < 0.05){
	($winner == $max_a2mscore_user) ? $add_score_points = 0.008 : $add_score_points = 0.008;
}
else if($score_diff >= 0.05 and $score_diff < 0.10){
	 ($winner == $max_a2mscore_user) ? $add_score_points = 0.007 : $add_score_points = 0.01;
}
else if($score_diff >= 0.10 and $score_diff < 0.15){
	 ($winner == $max_a2mscore_user) ? $add_score_points = 0.006 : $add_score_points = 0.015;
}
else if($score_diff >= 0.15 and $score_diff < 0.20){
	($winner == $max_a2mscore_user) ? $add_score_points = 0.005 : $add_score_points = 0.020;
}
else if($score_diff >= 0.20 and $score_diff < 0.25){
	  ($winner == $max_a2mscore_user) ? $add_score_points = 0.004 : $add_score_points = 0.025;
}
else if($score_diff >= 0.25 and $score_diff < 0.30){
	 ($winner == $max_a2mscore_user) ? $add_score_points = 0.003 : $add_score_points = 0.030;
}
else if($score_diff >= 0.30 and $score_diff < 0.35){
	 ($winner == $max_a2mscore_user) ? $add_score_points = 0.002 : $add_score_points = 0.040;
}
else if($score_diff >= 0.35 and $score_diff < 0.40){
	 ($winner == $max_a2mscore_user) ? $add_score_points = 0.001 : $add_score_points = 0.050;
}
else if($score_diff >=0.40){
	 ($winner == $max_a2mscore_user) ? $add_score_points = 0 : $add_score_points = 0.1;
}

//echo "<br>".$add_score_points; exit;
				return $add_score_points;
		}

		public function get_tourn_reg_players($tourn_id){
			$qry  = $this->db->query("SELECT * FROM Users u JOIN RegisterTournament rt ON u.Users_ID = rt.Users_ID  WHERE rt.Tournament_ID = {$tourn_id}");

			return $qry->result();
		}

		public function get_league_occr($tourn_id){
			$qry = $this->db->query("SELECT * FROM League_OCCR WHERE Tourn_ID = {$tourn_id} ORDER BY Event, Game_Date ASC");
			return $qry->result();
		}

		public function get_occr_info($ocr_id){
			$qry = $this->db->query("SELECT * FROM League_OCCR WHERE OCR_ID = {$ocr_id}");
			return $qry->row_array();
		}

		public function get_event_occrs($tourn_id, $ev){
			$qry = $this->db->query("SELECT * FROM League_OCCR where Tourn_ID = {$tourn_id} AND Event = '{$ev}'");
			//echo $this->db->last_query();
			return $qry->result();
		}

		public function get_user_reg_occrs($tourn_id, $player){
			$qry = $this->db->query("SELECT * FROM League_OCCR_Regs WHERE Users_ID = {$player} AND Reg_ID in (SELECT RegisterTournament_id FROM RegisterTournament WHERE Tournament_ID = {$tourn_id})");
			return $qry->result();
		}

		public function get_reg_tourn_event_occr_players($tourn_id, $types, $sel_occr_ids, $sport = '', $is_checkin = ''){
			$reg_status = "WithDrawn";
			$like_qry	= "";
			$checkin_qry= "";

			/*foreach($types as $i => $type){
				if($i != 0){ $like_qry .= " OR "; } 
				else{ $like_qry .= "("; }
				$like_qry .= "Reg_Events LIKE '%\"{$type}\"%'";
			}*/
			$ocr_qry = '';
			if($sel_occr_ids){
				foreach($sel_occr_ids as $i => $ids){
				 $ocr_ids .= $ids;
				 if(count($sel_occr_ids) != ++$i)
					$ocr_ids .= ", ";

				$ocr_qry = "AND RegisterTournament_id IN (SELECT Reg_ID FROM League_OCCR_Regs WHERE OCCR_ID in ({$ocr_ids}))";

				}
			}


			//if($is_checkin){
			//	$checkin_qry .= " AND is_checkin = {$is_checkin}";
			//}
	
			$qry_check = $this->db->query("SELECT * FROM RegisterTournament WHERE Tournament_ID = $tourn_id AND (Reg_Status != '$reg_status' OR Reg_Status IS NULL) {$ocr_qry}");
			//echo $this->db->last_query();
			return $qry_check->result();
		}

		public function get_game_day($gd){
			if($gd){
				$qry = $this->db->query("SELECT * FROM League_OCCR where OCR_ID = {$gd}");
				$xy  =  $qry->row_array();
				return $xy['Game_Date'];
			}
		}

				public function check_is_cd($tourn_id){
			if($tourn_id){
				$qry = $this->db->query("SELECT * FROM Brackets where Tourn_ID = {$tourn_id} AND Bracket_Type = 'Consolation'");
				return $qry->num_rows();
			}
		}

		public function unpulish_league($tourn_id) {
			$db_qry = $this->db->query("UPDATE tournament SET Is_Publish = 0 WHERE tournament_ID = {$tourn_id}");
			return $db_qry;
		}

		public function pulish_league($tourn_id) {
			$db_qry = $this->db->query("UPDATE tournament SET Is_Publish = 1 WHERE tournament_ID = {$tourn_id}");
			return $db_qry;
		}

		public function is_draw_complete($bid) {
				$qry = $this->db->query("SELECT * from Tournament_Matches tm WHERE tm.BracketID = {$bid} AND (tm.Winner is null or tm.Winner ='' or tm.Winner = 0)");

				return $qry->num_rows();
		}

		public function is_user_reg_event($tid, $event){
				$qry_check = $this->db->query("SELECT * FROM RegisterTournament where Users_ID = {$this->logged_user} AND Tournament_ID = {$tid} AND Reg_Events LIKE '%$event%'");

				if($qry_check->num_rows() > 0)
					return 1;
				else
					return 0;
		}
}