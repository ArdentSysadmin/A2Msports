<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

	class model_play extends CI_Model {
	
		public function __construct()
		{
			parent:: __construct();
			
		}

		public function get_all()
		{
			$current_date = date("Y-m-d h:i:s");
			
			$this->db->select('*');
			$this->db->from('tournament');
			$this->db->order_by("StartDate","des");
			$this->db->where('EndDate >=',$current_date);
			$query=$this->db->get();
			return $query->result();
		}

		public function get_reg_tourn_ids()
		{
			$users_id = $this->session->userdata('users_id');
			$data = array('Users_ID'=>$users_id);
			$get_tourn_ids = $this->db->get_where('RegisterTournament',$data);
			return $get_tourn_ids->result();

		}

		public function get_created_tourn_ids()
		{
			$users_id = $this->session->userdata('users_id');
			$data = array('Usersid'=>$users_id);
			$get_tourn_ids = $this->db->get_where('tournament',$data);
			return $get_tourn_ids->result();

		}

	/*	public function get_reg_match_ids()
		{
			$users_id = $this->session->userdata('users_id');
			$data = array('Users_ID'=>$users_id);
			$get_tourn_ids = $this->db->get_where('IndividualPlay',$data);
			return $get_tourn_ids->result();
		}
*/

		public function get_tourn_title($tourn_id)
		{
			$data = array('tournament_ID'=>$tourn_id);
			$get_name = $this->db->get_where('tournament',$data);
			return $get_name->row_array();
		}

		public function get_level_name($sport_id,$level){
			$data = array('SportsType_ID'=>$sport_id,'SportsLevel_ID'=>$level);
			$get_name = $this->db->get_where('SportsLevels',$data);
			return $get_name->row_array();
		}
		
		

		public function check_user_reg($data)
		{
			
			$match_id = $data['match_id'];
			$data = array('Opponent'=> $this->session->userdata('users_id'), 'GeneralMatch_ID'=>$match_id);
			$chk_match = $this->db->get_where('IndividualPlay',$data);

			if($chk_match->num_rows() > 0){
				return 1;
			}
			else {
				return 0;
			}
		} 

		public function get_details_match($data)
		{
			$match_id = $data['match_id'] ;
			$data = array('GeneralMatch_id'=>$match_id);
			$det_match = $this->db->get_where('GeneralMatch',$data);
			return $det_match->row_array();
		}

	  

		public function get_individual_play($match_id)
		{
			$data = array('Play_id'=>$match_id);
			$get_name = $this->db->get_where('IndividualPlay',$data);
			return $get_name->row_array();
		}

		public function get_past($tourn_ids,$created_tourn_ids)
		{

			
			/*
			($data['lat']=="") ? $lat = 0 : $lat = $data['lat'];
			($data['long']=="") ? $long = 0 : $long = $data['long'];
			
			$range = $data['tour_range'];

			$sports = array();
			$sports = $data['interests'];

			$items = count(array_filter($sports));

			$i = 0;
			if($items > 0)
			{
				$xyz = "";
				foreach($sports as $row)
				{
					$xyz .= "'$row->Sport_id'";

						if(++$i != $items){
							$xyz .= ",";
						}
				}

			$qry_check = $this->db->query("SELECT *, ACOS( SIN( RADIANS( Latitude ) ) * SIN( RADIANS( $lat ) ) + COS( RADIANS( Latitude ) )
* COS( RADIANS( $lat )) * COS( RADIANS( Longitude ) - RADIANS( $long )) ) * 3964.3 AS distance FROM tournament WHERE ACOS( SIN( RADIANS( Latitude )) * SIN( RADIANS( $lat ) ) + COS( RADIANS( Latitude ) ) * COS( RADIANS( $lat )) * COS( RADIANS( Longitude ) - RADIANS( $long )) ) * 3964.3 < {$range}  AND  SportsType IN ($xyz) AND StartDate < cast(GETDATE() as DATE) ORDER BY distance, StartDate DESC");

			} 
			else
			{
			$qry_check = $this->db->query("SELECT *, ACOS( SIN( RADIANS( Latitude ) ) * SIN( RADIANS( $lat ) ) + COS( RADIANS( Latitude ) )
* COS( RADIANS( $lat )) * COS( RADIANS( Longitude ) - RADIANS( $long )) ) * 3964.3 AS distance FROM tournament WHERE ACOS( SIN( RADIANS( Latitude )) * SIN( RADIANS( $lat ) ) + COS( RADIANS( Latitude ) ) * COS( RADIANS( $lat )) * COS( RADIANS( Longitude ) - RADIANS( $long )) ) * 3964.3 < {$range} AND StartDate < cast(GETDATE() as DATE) ORDER BY distance, StartDate DESC");
			}

			return $qry_check->result();

			*/

			
			$xyz = 0;		

			$trnm_ids = array();

			$trnm_ids = $tourn_ids;
			$items = count(array_filter($trnm_ids));
			
			$i = 0;
			if($items > 0)
			{
				$xyz = "";
				foreach($trnm_ids as $row)  
				{
					$xyz .= "'$row->Tournament_ID'";

					if(++$i != $items) {
						$xyz .= ",";
					}
				}
			}
				
		
		  $xy = 0; 
			$created_tour_ids = array();
		    $created_ids = $created_tourn_ids;
			$items1 = count(array_filter($created_ids));
			
			$i = 0;
			if($items1 > 0)
			{
				$xy = "";
				foreach($created_ids as $row)  
				{
					$xy .= "'$row->tournament_ID'";

					if(++$i != $items1) {
						$xy .= ",";
					}
				}
			} 

			
			$res_string = $xyz.", ".$xy;

			$users_id = $this->session->userdata('users_id');
			$qry_check = $this->db->query("SELECT * FROM tournament WHERE Usersid = '$users_id' AND StartDate < cast(GETDATE() as DATE) AND tournament_ID IN ($res_string)");


			return $qry_check->result();
		}

		public function get_sport_title($sport_id){
			
			$data = array('SportsType_ID'=>$sport_id);
			$get_sp_name = $this->db->get_where('SportsType',$data);
			return $get_sp_name->row_array();
		}
		
		public function get_sport_number($gen_match_id){
			
			$data = array('GeneralMatch_id'=>$gen_match_id);
			$get_sp_num = $this->db->get_where('GeneralMatch',$data);
			return $get_sp_num->row_array();
		}

		public function get_user_tournments($data)
		{
			($data['lat']=="") ? $lat = 0 : $lat = $data['lat'];
			($data['long']=="") ? $long = 0 : $long = $data['long'];
			
			$range = $data['tour_range'];

			$sports = array();
			$sports = $data['interests'];
			$visible = 'private';

			$items = count(array_filter($sports));

			$i = 0;
			if($items > 0)
			{
				$xyz = "";
				foreach($sports as $row)
				{
					$xyz .= "'$row->Sport_id'";

						if(++$i != $items){
							$xyz .= ",";
						}
				}

			$qry_check = $this->db->query("SELECT *, ACOS( SIN( RADIANS( Latitude ) ) * SIN( RADIANS( $lat ) ) + COS( RADIANS( Latitude ) )
* COS( RADIANS( $lat )) * COS( RADIANS( Longitude ) - RADIANS( $long )) ) * 3964.3 AS distance FROM tournament WHERE ACOS( SIN( RADIANS( Latitude )) * SIN( RADIANS( $lat ) ) + COS( RADIANS( Latitude ) ) * COS( RADIANS( $lat )) * COS( RADIANS( Longitude ) - RADIANS( $long )) ) * 3964.3 < {$range}  AND  SportsType IN ($xyz) AND Visibility != '$visible' AND StartDate > cast(GETDATE() as DATE) ORDER BY distance, StartDate DESC");

			} 
			else
			{
			$qry_check = $this->db->query("SELECT *, ACOS( SIN( RADIANS( Latitude ) ) * SIN( RADIANS( $lat ) ) + COS( RADIANS( Latitude ) )
* COS( RADIANS( $lat )) * COS( RADIANS( Longitude ) - RADIANS( $long )) ) * 3964.3 AS distance FROM tournament WHERE ACOS( SIN( RADIANS( Latitude )) * SIN( RADIANS( $lat ) ) + COS( RADIANS( Latitude ) ) * COS( RADIANS( $lat )) * COS( RADIANS( Longitude ) - RADIANS( $long )) ) * 3964.3 < {$range}  AND Visibility != '$visible' AND StartDate > cast(GETDATE() as DATE) ORDER BY distance, StartDate DESC");
			}

			return $qry_check->result();
		}

		public function get_user_visible_tournments($data)
		{
			($data['lat']=="") ? $lat = 0 : $lat = $data['lat'];
			($data['long']=="") ? $long = 0 : $long = $data['long'];
			
			$range = $data['tour_range'];
			$visible = 'private';

			$sports = array();
			$sports = $data['interests'];
			$items = count(array_filter($sports));
			$i = 0;
			if($items > 0)
			{
				$xyz = "";
				foreach($sports as $row)
				{
					$xyz .= "'$row->Sport_id'";

						if(++$i != $items){
							$xyz .= ",";
						}
				}

			$qry_check = $this->db->query("SELECT * FROM tournament WHERE Visibility = '$visible' AND StartDate > cast(GETDATE() as DATE) ORDER BY StartDate DESC");
			} 
			//else
			//{
			//$qry_check = $this->db->query("SELECT * FROM tournament WHERE Visibility = '$visible' AND StartDate > cast(GETDATE() as DATE) ORDER BY  StartDate DESC");
			//}
			if($qry_check->num_rows > 0){
			return $qry_check->result();
			}
			else{ return 0; }

		}


		public function get_reg_tournment($tourn_id)
		{
			$user_id = $this->session->userdata('users_id');
			$data = array('Tournament_ID'=>$tourn_id ,'Users_ID'=>$user_id);
			$query = $this->db->get_where('RegisterTournament',$data);
			return $query->row_array();
		}

		public function check_access_group($access_groups)
		{
			
			$qry_check = $this->db->query("SELECT Users_id FROM Academy_users WHERE Org_id in {$access_groups} ");
			return $qry_check->result();
		}

		public function get_general_matches($data)
		{

		$user_id = $this->session->userdata('users_id');
		($data['lat']=="") ? $lat = 0 : $lat = $data['lat'];
		($data['long']=="") ? $long = 0 : $long = $data['long'];
			
			$range = $data['range'];

			$current_date = date("Y-m-d h:i:s");
			$date = date('Y-m-d',strtotime($current_date));

			$sports = array();
			$sports = $data['interests'];

			$access_users = "NULL";
			if($access_users == "NULL"){
				$st = "0";
			}else{
				$st = "0";
			}
			$items = count(array_filter($sports));

			$i = 0;
			if($items > 0)
			{
				$xyz = "";
				foreach($sports as $row)
				{
				
					$xyz .= "'$row->Sport_id'";

						if(++$i != $items) {
							$xyz .= ",";
						}
				}


			/*$qry_check = $this->db->query("SELECT *, ACOS( SIN( RADIANS( Latitude ) ) * SIN( RADIANS( $lat ) ) + COS( RADIANS( Latitude ) )
* COS( RADIANS( $lat )) * COS( RADIANS( Longitude ) - RADIANS( $long )) ) * 3964.3 AS distance FROM GeneralMatch WHERE ACOS( SIN( RADIANS( Latitude )) * SIN( RADIANS( $lat ) ) + COS( RADIANS( Latitude ) ) * COS( RADIANS( $lat )) * COS( RADIANS( Longitude ) - RADIANS( $long )) ) * 3964.3 < {$range} AND Sports IN ($xyz) ORDER BY distance, Match_created_on ASC");

			} */
		
			$qry_check = $this->db->query(" SELECT *, ACOS( SIN( RADIANS( Latitude ) ) * SIN( RADIANS( $lat ) ) + COS( RADIANS( Latitude ) )
* COS( RADIANS( $lat )) * COS( RADIANS( Longitude ) - RADIANS( $long )) ) * 3964.3 AS distance FROM GeneralMatch

 WHERE ACOS( SIN( RADIANS( Latitude )) * SIN( RADIANS( $lat ) ) + COS( RADIANS( Latitude ) ) * COS( RADIANS( $lat )) * 
 COS( RADIANS( Longitude ) - RADIANS( $long)) ) * 3964.3 < {$range} AND Sports IN ($xyz) AND  Access_Status = {$st} AND Match_Date >= cast(GETDATE() as DATE)  AND GeneralMatch_id NOT IN 

  (SELECT GeneralMatch_ID FROM IndividualPlay WHERE Opponent = {$user_id} )
   ORDER BY distance,
  Match_created_on DESC");
			} 
			else
			{
				
			/*$qry_check = $this->db->query("SELECT *, ACOS( SIN( RADIANS( Latitude ) ) * SIN( RADIANS( $lat ) ) + COS( RADIANS( Latitude ) )
* COS( RADIANS( $lat )) * COS( RADIANS( Longitude ) - RADIANS( $long )) ) * 3964.3 AS distance FROM GeneralMatch WHERE ACOS( SIN( RADIANS( Latitude )) * SIN( RADIANS( $lat ) ) + COS( RADIANS( Latitude ) ) * COS( RADIANS( $lat )) * COS( RADIANS( Longitude ) - RADIANS( $long )) ) * 3964.3 < {$range} ORDER BY distance , Match_created_on ASC"); */
			
			$qry_check = $this->db->query(" SELECT *, ACOS( SIN( RADIANS( Latitude ) ) * SIN( RADIANS( $lat ) ) + COS( RADIANS( Latitude ) )
* COS( RADIANS( $lat )) * COS( RADIANS( Longitude ) - RADIANS( $long )) ) * 3964.3 AS distance FROM GeneralMatch

 WHERE ACOS( SIN( RADIANS( Latitude )) * SIN( RADIANS( $lat ) ) + COS( RADIANS( Latitude ) ) * COS( RADIANS( $lat )) * 
 COS( RADIANS( Longitude ) - RADIANS( $long)) ) * 3964.3 < {$range}  AND Access_Status = {$st} AND Match_Date >= cast(GETDATE() as DATE) AND GeneralMatch_id NOT IN 

  (SELECT GeneralMatch_ID FROM IndividualPlay WHERE Opponent = {$user_id})
   ORDER BY distance,
  Match_created_on DESC");

			}
			return $qry_check->result();
		}

		public function get_general_matches_visible($data)
		{

		$user_id = $this->session->userdata('users_id');
		($data['lat']=="") ? $lat = 0 : $lat = $data['lat'];
		($data['long']=="") ? $long = 0 : $long = $data['long'];
			
			$range = $data['range'];

			$current_date = date("Y-m-d h:i:s");
			$date = date('Y-m-d',strtotime($current_date));

			$sports = array();
			$sports = $data['interests'];

			$access_users = "1";

			$items = count(array_filter($sports));

			$i = 0;
			if($items > 0)
			{
				$xyz = "";
				foreach($sports as $row)
				{
				
					$xyz .= "'$row->Sport_id'";

						if(++$i != $items) {
							$xyz .= ",";
						}
				}

			$qry_check = $this->db->query(" SELECT *, ACOS( SIN( RADIANS( Latitude ) ) * SIN( RADIANS( $lat ) ) + COS( RADIANS( Latitude ) )
* COS( RADIANS( $lat )) * COS( RADIANS( Longitude ) - RADIANS( $long )) ) * 3964.3 AS distance FROM GeneralMatch

 WHERE ACOS( SIN( RADIANS( Latitude )) * SIN( RADIANS( $lat ) ) + COS( RADIANS( Latitude ) ) * COS( RADIANS( $lat )) * 
 COS( RADIANS( Longitude ) - RADIANS( $long)) ) * 3964.3 < {$range} AND Sports IN ($xyz) AND Access_Status = {$access_users} AND Match_Date >= cast(GETDATE() as DATE)  AND GeneralMatch_id NOT IN 

  (SELECT GeneralMatch_ID FROM IndividualPlay WHERE Opponent = {$user_id} )
   ORDER BY distance,
  Match_created_on DESC");
			} 
			else
			{
			
			$qry_check = $this->db->query(" SELECT *, ACOS( SIN( RADIANS( Latitude ) ) * SIN( RADIANS( $lat ) ) + COS( RADIANS( Latitude ) )
* COS( RADIANS( $lat )) * COS( RADIANS( Longitude ) - RADIANS( $long )) ) * 3964.3 AS distance FROM GeneralMatch

 WHERE ACOS( SIN( RADIANS( Latitude )) * SIN( RADIANS( $lat ) ) + COS( RADIANS( Latitude ) ) * COS( RADIANS( $lat )) * 
 COS( RADIANS( Longitude ) - RADIANS( $long)) ) * 3964.3 < {$range} AND  Match_Date >= cast(GETDATE() as DATE) AND Access_Status = {$access_users} AND GeneralMatch_id NOT IN 

  (SELECT GeneralMatch_ID FROM IndividualPlay WHERE Opponent = {$user_id})
   ORDER BY distance,
  Match_created_on DESC");

			}
			return $qry_check->result();
		}

		public function get_user_reg_matches()
		{
			$users_id = $this->session->userdata('users_id');
			$data = array('Opponent'=>$users_id ,'Winner'=>NULL);
			$this->db->order_by("Play_Date","DESC"); 
			$get_name = $this->db->get_where('IndividualPlay',$data);
			return $get_name->result();
		}

		public function getonerow($tourn_id)
		{				   
			$data = array('tournament_ID'=>$tourn_id);
			$query = $this->db->get_where('tournament',$data);
			return $query->row();
		}

		public function get_user_tourn_bracket_matches($data)
		{
			
			  $xyz = 0;		
			  if(isset($data))
			  {
				$trnm_ids = array();

				$trnm_ids = $data;
				//echo "<pre>";
				//print_r($trnm_ids);
				//exit;
				$items = count(array_filter($trnm_ids));
				
				$i = 0;
				if($items > 0)
				{
					$xyz = "";
					foreach($trnm_ids as $row)  
					{
						$xyz .= "'$row->Tournament_ID'";

						if(++$i != $items) {
							$xyz .= ",";
						}
					}
				} 
			
			  }
				
			
			$users_id = $this->session->userdata('users_id');
			$qry_check = $this->db->query("SELECT * FROM Tournament_Matches WHERE Tourn_ID IN ($xyz) AND Winner = 0 AND (Player1 = $users_id or Player2 = $users_id) AND Player2 != 0");

			//$qry_check = $this->db->query("SELECT * FROM tournament WHERE Usersid = '$users_id' AND tournament_ID IN ($xyz)");
			
			//echo "<pre>";
			//print_r($qry_check->result());
			//exit;
			return $qry_check->result();

		}


		public function get_user_reg_tournament_matches($data)
		{
			$xyz = 0;		
		  if(isset($data))
		  {
			$trnm_ids = array();

			$trnm_ids = $data;
			//echo "<pre>";
			//print_r($trnm_ids);
			//exit;
			$items = count(array_filter($trnm_ids));
			
			$i = 0;
			if($items > 0)
			{
				$xyz = "";
				foreach($trnm_ids as $row)  
				{
					$xyz .= "'$row->Tournament_ID'";

					if(++$i != $items) {
						$xyz .= ",";
					}
				}
			} 
		
		  }

			$users_id = $this->session->userdata('users_id');
			$qry_check = $this->db->query("SELECT * FROM tournament WHERE tournament_ID IN ($xyz)");
			//$qry_check = $this->db->query("SELECT * FROM tournament WHERE Usersid = '$users_id' AND tournament_ID IN ($xyz)");

			return $qry_check->result();
			
		}


		public function get_matchowner_matches()
		{
			$users_id = $this->session->userdata('users_id');
			$qry_check = $this->db->query("SELECT * FROM IndividualPlay WHERE GeneralMatch_ID IN (SELECT GeneralMatch_id FROM GeneralMatch WHERE users_id = $users_id) AND Winner IS NULL ORDER BY Play_Date DESC");

			return $qry_check->result();
		}

		public function get_user_created_events()
		{
			$users_id = $this->session->userdata('users_id');
			$qry_check = $this->db->query("SELECT * FROM Events WHERE Ev_Created_by = $users_id ORDER BY Ev_Start_Date DESC");

			return $qry_check->result();
		}

		public function get_user_invited_events()
		{
			$users_id = $this->session->userdata('users_id');
			$qry_check = $this->db->query("SELECT * FROM Events WHERE Ev_ID IN (SELECT Ev_ID FROM Ev_Inv_Status WHERE Users_Id = '$users_id')");

			return $qry_check->result();
		}

		public function get_gen_mat_det($gen_mat_id)
		{
			$data = array('GeneralMatch_id'=>$gen_mat_id);
			
			$qry_check = $this->db->get_where('GeneralMatch', $data);
			return $qry_check->row_array();
		}

		public function get_user_past_matches()
		{
			
			$users_id = $this->session->userdata('users_id');
			$data = array('Opponent'=>$users_id );
			$this->db->where('Winner is not null');
			$this->db->order_by("Play_Date","DESC");  
			$get_name = $this->db->get_where('IndividualPlay',$data);
			return $get_name->result();
		}

		public function get_owner_past_matches()
		{
			$users_id = $this->session->userdata('users_id');
			$qry_check = $this->db->query("SELECT * FROM IndividualPlay WHERE GeneralMatch_ID IN (SELECT GeneralMatch_ID FROM GeneralMatch WHERE users_id = $users_id) AND Winner != '' ORDER BY Play_Date DESC ");

			return $qry_check->result();
		}


		public function get_user_completed_bracket_matches($data)
		{
			 $xyz = 0;		
			  if(isset($data))
			  {
				$trnm_ids = array();

				$trnm_ids = $data;
				//echo "<pre>";
				//print_r($trnm_ids);
				//exit;
				$items = count(array_filter($trnm_ids));
				
				$i = 0;
				if($items > 0)
				{
					$xyz = "";
					foreach($trnm_ids as $row)  
					{
						$xyz .= "'$row->Tournament_ID'";

						if(++$i != $items) {
							$xyz .= ",";
						}
					}
				} 
			
			  }
				
			$users_id = $this->session->userdata('users_id');
			$qry_check = $this->db->query("SELECT * FROM Tournament_Matches WHERE Tourn_ID IN ($xyz) AND Winner != '0' AND Player1 = $users_id or Player2 = $users_id ");

			
			return $qry_check->result();
		}


		public function get_match_det($match_id)
		{
			$data = array('GeneralMatch_id'=>$match_id);
			$get_name = $this->db->get_where('GeneralMatch',$data);
			return $get_name->row_array();
		}

		public function get_sports()
		{
			$users_id = $this->session->userdata('users_id');
			$data = array('users_id'=>$users_id);
			$get_name = $this->db->get_where('Sports_Interests',$data);
			return $get_name->result();
		}
		
		public function get_intrests()
		{
			$query = $this->db->get('SportsType');
			return $query->result();
		}

		public function insert_opponent($data)
		{
			
			$match_id = $data['match_id'];
			
			$details = $data['get_reg_det'];

			$title  = $details['Match_Title'];

			$creator  = $details['users_id'];
			
			$data['opp'] = $this->session->userdata('user'); 
			
			$last = $data['opp'];
			$pieces = explode(" ", $last);
			$last_name = $pieces[1];

			$play_title = $title . " - " . $last_name ;
			$reg_date = $this->input->post('reg_date');
			$comments = $this->input->post('comments');
			$registered_user = $this->session->userdata('users_id');

			$data = array(
				'GeneralMatch_ID' => $match_id,
				'Opponent' => $registered_user,
				'Play_Title' => $play_title,
				'Comments' => $comments,
				'Reg_Date' => $reg_date
				);

			//print_r($data);
			//exit;

			$ins_query = $this->db->insert('IndividualPlay', $data);

			$data  = array('match_id' => $match_id,'registered_user' => $registered_user,'title' => $play_title,'comments' => $comments,
		    'Reg_Date' => $reg_date,'creator' => $creator,'type' =>'Singles');

			return $data;
			
		}

		public function insert_double_opponent($data)
		{
			
			$match_id = $data['match_id'];
			$details = $data['get_reg_det'];

			$title = $details['Match_Title'];

			$creator  = $details['users_id'];

			$partner2 = $this->input->post('created_users_id');
			
			$reg_date = $this->input->post('reg_date');
			$comments = $this->input->post('comments');
			
			$data['opp'] = $this->session->userdata('user'); 
			
			$last = $data['opp'];
			$pieces = explode(" ", $last);
			
			$last_name = $pieces[1];

			$play_title = $title . " - " . $last_name ;

			$registered_user = $this->session->userdata('users_id');

			$data = array(
				'GeneralMatch_ID' => $match_id,
				'Opponent' => $registered_user,
				'Play_Title' => $play_title,
				'Player2_Partner' => $partner2,
				'Comments' => $comments,
				'Reg_Date' => $reg_date
				);

			//print_r($data);
			//exit;

			$ins_query = $this->db->insert('IndividualPlay', $data);

			$data  = array('match_id' => $match_id,'registered_user' => $registered_user,'title' => $play_title,'comments' => $comments,
		    'Reg_Date' => $reg_date,'creator' => $creator, 'partner2' => $partner2,'type' =>'Doubles');
			
			return $data;
		}


		public function update_match_score($play_id)
		{

		/* ------------------- A2MScore Get & Comaparission Section ---------------- */

			$data = array('GeneralMatch_id' => $this->input->post('gen_match_id'));
			$macth_init =  $this->db->get_where('GeneralMatch',$data);
			$match_init_user = $macth_init->row_array();

		$player1_user = $match_init_user['users_id'];
		$opp_user = $this->input->post('opp_user');
		$match_sport = $match_init_user['Sports'];

			$data = array('SportsType_ID'=>$match_sport , 'Users_ID'=>$player1_user);
			$get_a2mscore1 = $this->db->get_where('A2MScore',$data);
			$p1_a2mscore = $get_a2mscore1->row_array();

			$data = array('SportsType_ID'=>$match_sport , 'Users_ID'=>$opp_user);
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

	
		$played_date = $this->input->post('match_date');

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

	/*		$player1_user = $match_init_user['users_id'];
			$opp_user = $this->input->post('opp_user');
			$match_sport = $match_init_user['Sports'];*/

			$data = array('Users_ID'=>$player1_user,'Sport' =>$match_sport);
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

				$total = intval($c['Num_Matches']) + 1;

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

			if(empty($c1))
			{
				if($winner == $opp_user) { $won = 1; $lost = 0; }  
				else { $won = 0; $lost = 1;  }

				$data = array('Num_Matches' => 1, 'Users_ID' => $opp_user,'Sport' => $match_sport,
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
			
				

		/* --------------------- */

					$data = array(
							'Play_Date' => $played_date,
							'Player1_Score' => $player1_score,
							'Opponent_Score' => $player2_score,
							'Player1_Win_Percent' => round($win_per_p1, 2),
							'Player2_Win_Percent' => round($win_per_p2, 2),
							'Winner' => $winner);
			
			$this->db->where('Play_id', $play_id);
			$result = $this->db->update('IndividualPlay', $data); 
			return $result;
		}

		//-----------------------------
		
		public function Add_tourn_match_score($tourn_match_id)
		{

		/* ------------------- A2MScore Calculation Section ---------------- */

			$data = array('tournament_ID' => $this->input->post('tourn_id'));
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

			$data = array('Users_ID'=>$player1_user,'Sport' =>$match_sport);
			$num = $this->db->get_where('Player_Matches_Count',$data);
			$c =  $num->row_array();

			if(empty($c))
			{
				$data = array('Num_Matches' => 1, 'Users_ID' => $player1_user,'Sport' => $match_sport);
				$p1_insert = $this->db->insert('Player_Matches_Count' ,$data);
			}
			else
			{
				$total = $c['Num_Matches'] + 1;
				$data = array('Num_Matches' => $total);
				$this->db->where('Users_ID', $player1_user);
				$this->db->where('Sport', $match_sport);
				$p1_update = $this->db->update('Player_Matches_Count' ,$data);
			}
			

			$data = array('Users_ID'=>$opp_user,'Sport' =>$match_sport);
			$num1 = $this->db->get_where('Player_Matches_Count',$data);
			$c1 =  $num1->row_array();

			if(empty($c1))
			{
				$data = array('Num_Matches' => 1, 'Users_ID' => $opp_user,'Sport' => $match_sport);
				$p1_insert = $this->db->insert('Player_Matches_Count' ,$data);
			}
			else
			{
				$total_1 = $c['Num_Matches'] + 1;
				
				$data = array('Num_Matches' => $total_1);
				$this->db->where('Users_ID', $opp_user);
				$this->db->where('Sport', $match_sport);
				$p1_update = $this->db->update('Player_Matches_Count' ,$data);
			}
			
				

		/* --------------------- */

					$data = array(
							'Match_Date' => $played_date,
							'Player1_Score' => $player1_score,
							'Player2_Score' => $player2_score,
							'Winner' => $winner);
			
			$this->db->where('Tourn_match_id', $tourn_match_id);
			$result = $this->db->update('Tournament_Matches', $data); 

/* --- update player1 and player2 sources ---- */
			$bracket_id = $this->input->post('bracket_id');
			$match_num = $this->input->post('match_num');

			$qry_check_p1 = $this->db->query("SELECT * FROM Tournament_Matches WHERE Player1_source = $match_num AND BracketID = $bracket_id");

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
/* --- update player1 and player2 sources ---- */

			return $result;
		}


		public function update_match_det($data)
		{
			
			$match_id = $data['match_id'];
			$message = $this->input->post('mes');
			
			$match_date_upd = "";
			$match_date = $this->input->post('match_date');
			if($match_date){
				  
				$time_hr = $this->input->post('match_time_hr');

			    if($time_hr){
					
					($this->input->post('match_time_mm') != "") ? $time_mm = $this->input->post('match_time_mm')  : $time_mm = "00";
					$time_am = $this->input->post('match_time_am');

					$time = $time_hr.":".$time_mm." ".$time_am;
					$date_time = $match_date." ".$time;
					$match_date_upd = date("Y-m-d H:i", strtotime($date_time));
			    }
			   else{
					$match_date_upd = date("Y-m-d", strtotime($match_date));
			   }
			}
			
			$match_date_upd1 = NULL;
			$match_date1 = $this->input->post('match_date1');
			if($match_date1){
				  
				$time_hr = $this->input->post('match_time_hr1');

			    if($time_hr){

					($this->input->post('match_time_mm1') != "") ? $time_mm = $this->input->post('match_time_mm1') : $time_mm = "00";
					$time_am = $this->input->post('match_time_am1');

					$time1 = $time_hr.":".$time_mm." ".$time_am;
					$date_time = $match_date1." ".$time1;
					$match_date_upd1 = date("Y-m-d H:i", strtotime($date_time));
			    }
			   else{
					$match_date_upd1 = date("Y-m-d", strtotime($match_date1));
			   }
			}

			
			$match_date_upd2 = NULL;
			$match_date2 = $this->input->post('match_date2');
			if($match_date2){
				  
				$time_hr = $this->input->post('match_time_hr2');

			    if($time_hr){
					($this->input->post('match_time_mm2') != "") ? $time_mm = $this->input->post('match_time_mm2')  : $time_mm = "00";
					$time_am = $this->input->post('match_time_am2');

					$time2 = $time_hr.":".$time_mm." ".$time_am;
					$date_time = $match_date2." ".$time2;
					$match_date_upd2 = date("Y-m-d H:i", strtotime($date_time));
			    }
			   else{
					$match_date_upd2 = date("Y-m-d", strtotime($match_date2));
			   }
			}

			$data = array(
					'Match_Date' => $match_date_upd,
					'Match_Date2' => $match_date_upd1,
					'Match_Date3' => $match_date_upd2,
					'Message' => $message
				);

			//print_r($data);
			//exit;

			$this->db->where('GeneralMatch_id', $match_id);
			$result = $this->db->update('GeneralMatch', $data); 
		
			return $result;
		
		}

		public function get_a2msocre($sport,$user_id)
		{
			$data = array('SportsType_ID'=>$sport , 'Users_ID'=>$user_id);
			$get_level = $this->db->get_where('A2MScore',$data);
			return $get_level->row_array();
		}

		public function get_tourbased_users($tourn_id)
		{
			$query = $this->db->query("SELECT Users_ID FROM users WHERE Users_ID NOT IN (SELECT Users_ID from RegisterTournament WHERE Tournament_ID = '$tourn_id')");

			return $query->result();
		}

		public function bulk_reg_players()
		{
			$tourn_id = $this->input->post('id');
			$age_group = $this->input->post('age_group');
			$level = $this->input->post('level');
			$mtype = json_encode($this->input->post('mtype'));

			$reg_date = date("Y-m-d h:i:s");
			$sel_players = $this->input->post('sel_player');

			foreach($sel_players as $sp){

				$check_already_reg = $this->db->query("SELECT * FROM RegisterTournament WHERE Users_ID = $sp AND Match_Type LIKE '%".$mtype."%' AND 
						Reg_Sport_Level = '".$level."' AND Reg_Age_Group = '".$age_group."'");

				if($check_already_reg->num_rows == 0)
				{
				$data = array('Tournament_ID' => $tourn_id,
						'Users_ID' => $sp,
						'Reg_date' => $reg_date,
						'Match_Type' => $mtype,
						'Reg_Sport_Level' => $level,
						'Reg_Age_Group' => $age_group);

				$bulk_reg = $this->db->insert('RegisterTournament' ,$data);
				}
			}

			return $bulk_reg;
		}
	
	}