<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

       session_start(); 

	// Play controller 
	class Play extends CI_Controller {
		public $logged_user;
		public $is_super_admin;
		public $logged_user_role;

		public function __construct()
		{
			parent:: __construct();
			// Load form helper library
			$this->load->helper('form');

			// Load form validation library
			$this->load->library('form_validation');

			// Load session library
			$this->load->library('session');
			if(!$this->session->userdata('user')){
				redirect('login');
			}

			// Load database			
			$this->load->model('model_play');
			$this->load->model('model_general', 'general');
			$this->load->model('model_news');
			//$this->logged_user = $this->session->userdata('users_id');

						$this->is_super_admin = 0;

			if($this->session->userdata('users_id')){
				$this->logged_user = $this->session->userdata('users_id');
				if($this->session->userdata('email') == 'rajkamal.kosaraju@gmail.com' or $this->logged_user == 239){
					$this->logged_user_role = "Admin";
					$this->is_super_admin   = 1;
				}
			}
			else{
				$this->logged_user = "";
				$this->logged_user_role = "Visiter";
			}

		}
		
		// load all the tournments ...... and //load  the nearest tournments to the user 
		public function index($data="")
		{
			$url_seg = $this->uri->segment(1); 
			$last_url = array('redirect_to'=>$url_seg);
			$this->session->set_userdata($last_url);

			if($this->session->userdata('user')!=""){
			
			$data['users_id'] = $this->session->userdata('users_id');
			$data['lat'] = $this->session->userdata('lat');
			$data['long'] = $this->session->userdata('long');
			$data['range'] = 50;
			$data['tour_range'] = 50;

			$data['interests'] = $this->model_play->get_sports();

			// for getting user logged in and nearest tournments....
			
			$user_torn = $this->model_play->get_user_tournments($data);  // Get the Upcoming Tournaments
			$user_torn_visible = $this->model_play->get_user_visible_tournments($data);
			//$data['match_ids'] = $this->model_play->get_reg_match_ids();

			$general_matches = $this->model_play->get_general_matches($data);   // Get the Upcoming Matches
			$general_matches_visible = $this->model_play->get_general_matches_visible($data); 
			$user_reg_matches = $this->model_play->get_user_reg_matches();		// Get the Logged User Registered Matches
			$user_owner_matches = $this->model_play->get_matchowner_matches();  // Get Logged User Created Matches
			
		//	$user_reg_tourn = $this->model_play->get_user_reg_tourns();  // Get Logged User Registered Tournaments Matches

			$user_past_matches	= $this->model_play->get_user_past_matches();    // Get the Logged User Registered Matches that having score entered
			$owner_past_matches	   = $this->model_play->get_owner_past_matches();  // Get the Logged User Registered Matches
			
			$user_created_events   = $this->model_play->get_user_created_events();  // Get the Logged User created events
			$user_invited_events   = $this->model_play->get_user_invited_events();  // Get the Logged User were invited events
			$get_user_due_payments = $this->model_play->get_user_due_payments();
			$get_event_tourn	   = $this->model_play->get_event_tourn();
			
			$data['tournments']		 = $user_torn;
			$data['visiblle_tournments'] = $user_torn_visible;
			$data['matches']		 = $general_matches;
			$data['visible_matches'] = $general_matches_visible;

			$new_arr = array_merge($user_created_events, $user_invited_events);
			$data['user_created_events'] = $new_arr;


			$data['user_reg_matches']   = $user_reg_matches;
			$data['user_owner_matches'] = $user_owner_matches;

			$data['user_past_matches']  = $user_past_matches;
			$data['owner_past_matches'] = $owner_past_matches;

			$data['up_event_tourns'] = $get_event_tourn;

			// for getting user logged in and past  tournments....
			$data['tourn_ids'] = $this->model_play->get_reg_tourn_ids();
			$tourn_ids = $data['tourn_ids'];
			/*echo "<pre>";
			print_r($tourn_ids);
			exit;*/

			$data['created_tourn_ids'] = $this->model_play->get_created_tourn_ids();
			$created_tourn_ids = $data['created_tourn_ids'];

			$new_arr_past_tour = array_merge($data['tourn_ids'], $created_tourn_ids);

			//$data['past_tournments']	= $this->model_play->get_past($tourn_ids, $created_tourn_ids);
			$data['past_tournments']	= $this->model_play->get_past($tourn_ids, $new_arr_past_tour);
			$data['get_user_due_payments']	= $get_user_due_payments;

			$user_reg_tourn_matches = $this->model_play->get_user_reg_tournament_matches($data['tourn_ids']);  
			$data['user_reg_tournament_matches'] = $user_reg_tourn_matches;

			$user_tourn_bracket_matches = $this->model_play->get_user_tourn_bracket_matches($data['tourn_ids']); 
			$data['user_bracket_matches'] = $user_tourn_bracket_matches;

			$user_completed_bracket_matches = $this->model_play->get_user_completed_bracket_matches($data['tourn_ids']); 
			$data['completed_bracket_matches'] = $user_completed_bracket_matches;

			$data['results'] = $this->model_news->get_news();			

		//	$data['reg_matches'] 
			
			$this->load->view('includes/header');
			$this->load->view('view_upcoming_matches',$data);
			$this->load->view('includes/view_right_column',$data);
			$this->load->view('includes/footer');

			}
			else
			{
			  //$data['tournments'] = $this->model_play->get_all();
			  //$data['past_tournments'] = $this->model_play->get_past();

				$data['results'] = $this->model_news->get_news();

				$this->load->view('includes/header');
				$this->load->view('view_upcoming_matches');
				$this->load->view('includes/view_right_column',$data);
				$this->load->view('includes/footer');

			}
			
		}
		
		// load the registration page .... 
		public function register_match()
		{
			$data['results'] = $this->model_news->get_news();
			$this->load->view('includes/header');
			$this->load->view('view_register_match');
			$this->load->view('includes/view_right_column',$data);
			$this->load->view('includes/footer');
			
		}

		public function match($match_id)
		{
			$data['match_id'] = $match_id;
			
			$data['match_det'] = $this->model_play->get_match_det($match_id);
			$data['results'] = $this->model_news->get_news();

			$this->load->view('includes/header');
			$this->load->view('view_match_details_page', $data);
			$this->load->view('includes/view_right_column',$data);
			$this->load->view('includes/footer');
		}

		public function register($match_id)
		{
			if($this->input->post('update')){

				$data['match_id'] = $match_id;

				$res = $this->model_play->update_match_det($data);
				if($res)
				{
					redirect("play/match/$match_id");
				}
			}
			else if($this->input->post('doubles_match'))
			{
				$data['match_id'] = $match_id;
				$data['get_reg_det'] = $this->model_play->get_details_match($data);

				$res = $this->model_play->insert_double_opponent($data);

				$email_status = $this->email_register($res);
				
				$data['results'] = $this->model_news->get_news();
				$data['reg_stat'] = "<b>You have successfully Registered for this Match. Thankyou.</b>";
				$this->load->view('includes/header');
				$this->load->view('view_register_general_match', $data);
				$this->load->view('includes/view_right_column',$data);
				$this->load->view('includes/footer');
				
			}
			else if($this->input->post('singles_match'))
			{
				$data['match_id'] = $match_id;
				$data['get_reg_det'] = $this->model_play->get_details_match($data);

				$res = $this->model_play->insert_opponent($data);

				$email_status = $this->email_register($res);
			
				$data['results'] = $this->model_news->get_news();
				$data['reg_stat'] = "<b>You have successfully Registered for this Match. Thankyou.</b>";
				$this->load->view('includes/header');
				$this->load->view('view_register_general_match', $data);
				$this->load->view('includes/view_right_column',$data);
				$this->load->view('includes/footer');
			}
			else
			{

			if($this->session->userdata('users_id'))
			{
				$data['match_id'] = $match_id;

				$get_reg_det = $this->model_play->get_details_match($data);
				$check_user_reg = $this->model_play->check_user_reg($data);

				$user_id = $this->session->userdata('users_id');
				$match_visible_users = json_decode($get_reg_det['Allowed_Users']);
				$match_visible_status = $get_reg_det['Access_Status'];
				
				$data['player'] = $get_reg_det['users_id'];
				$data['Title'] = $get_reg_det['Match_Title'];
				$data['match_type'] = $get_reg_det['Match_Type'];

				$match_type = $data['match_type'];
				
				if($match_visible_status == 1){
					
					if((in_array($user_id, $match_visible_users)))
					{
						if($check_user_reg == 0 )
						{
							if($match_type == "Doubles"){
								
								$data['results'] = $this->model_news->get_news();
								$data['match_det'] = $this->model_play->get_match_det($match_id);

								$this->load->view('includes/header');
								$this->load->view('view_register_doubles', $data);
								$this->load->view('includes/view_right_column',$data);
								$this->load->view('includes/footer');
								
							}
							else
							{
								$data['results'] = $this->model_news->get_news();
								$data['match_det'] = $this->model_play->get_match_det($match_id);

								$this->load->view('includes/header');
								$this->load->view('view_register_singles', $data);
								$this->load->view('includes/view_right_column',$data);
								$this->load->view('includes/footer');
								
							}
						}
						else
						{
							$data['reg_stat'] = "Hey, You have already registered for this Match! Thankyou.";
							$data['results'] = $this->model_news->get_news();
							$this->load->view('includes/header');
							$this->load->view('view_register_general_match', $data);
							$this->load->view('includes/view_right_column',$data);
							$this->load->view('includes/footer');
						}
					}
					else
					{

						echo "Invalid Access!";
					}
				}
				else
				{
					if($check_user_reg == 0)
					{
						if($match_type == "Doubles"){
								
							$data['results'] = $this->model_news->get_news();
							$data['match_det'] = $this->model_play->get_match_det($match_id);

							$this->load->view('includes/header');
							$this->load->view('view_register_doubles', $data);
							$this->load->view('includes/view_right_column',$data);
							$this->load->view('includes/footer');
						}
						else
						{
							$data['results'] = $this->model_news->get_news();
							$data['match_det'] = $this->model_play->get_match_det($match_id);

							$this->load->view('includes/header');
							$this->load->view('view_register_singles', $data);
							$this->load->view('includes/view_right_column',$data);
							$this->load->view('includes/footer');
						}
					}
					else
					{
						$data['reg_stat'] = "Hey, You have already registered for this Match! Thankyou.";
						$data['results'] = $this->model_news->get_news();
						$this->load->view('includes/header');
						$this->load->view('view_register_general_match', $data);
						$this->load->view('includes/view_right_column',$data);
						$this->load->view('includes/footer');
					}
				
				}

			}
			else
			{
				echo "Invalid Access!";
			}

		   }
		}

		 public function get_username($user_id)
		 {
			return $this->general->get_user($user_id);
		 }

		 public function get_level_name($sport_id,$level)
	     {
	       return $this->model_play->get_level_name($sport_id,$level);
	     }

		 public function email_register($res)
		 {
			$xy = $res;
			$type = $xy['type'];
			if($type == 'Singles'){
				
				$match_id = $xy['match_id'];
				$reg_user = $xy['registered_user'];
				$match_title = $xy['title'];
				$reg_date = $xy['Reg_Date'];
				$creator = $xy['creator'];
				$comments = $xy['comments'];
				
			}else if($type == 'Doubles')
			{
				
				$match_id = $xy['match_id'];
				$reg_user = $xy['registered_user'];
				$match_title = $xy['title'];
				$reg_date = $xy['Reg_Date'];
				$partner = $xy['partner2'];
				$creator = $xy['creator'];
				$comments = $xy['comments'];
				
			}
		
			$split_date = explode(" ",$reg_date);
			$play_date = ($split_date[1] != "00:00:00.000") ?
			date("m-d-Y h:i A", strtotime($reg_date)) : date("m-d-Y", strtotime($reg_date));

			$get_match_details = $this->get_username($creator);
			$creator_email = $get_match_details['EmailID'];
			$creator_alter_email = $get_match_details['AlternateEmailID'];
			if($creator_email != ""){
				$to_mail = $creator_email;	
			}else
			{
				$to_mail = $creator_alter_email;	
			}

			$creator_name = $get_match_details['Firstname'] . " " . $get_match_details['Lastname'];

			$get_reg_user_email = $this->get_username($reg_user);
			$registered_email_id = $get_reg_user_email['EmailID'];
			$reg_user_name = $get_reg_user_email['Firstname'] . " " . $get_reg_user_email['Lastname'];

			$get_partner_details = $this->get_username($partner);
			$partner_name = $get_partner_details['Firstname'] . " " . $get_partner_details['Lastname'];

			$this->load->library('email');
			$this->email->set_newline("\r\n");
			$this->email->from('admin@a2msports.com', 'A2MSports');	
			$this->email->to("$to_mail");  		
			$this->email->subject('Friendly Match Registration');

			
			$data = array(
				'match_id' => $match_id,
				'title' => $match_title,
				'reg_user_name' => $reg_user_name,
				'creator_name' => $creator_name,
				'partner_name' => $partner_name,
				'comments' => $comments,
				'play_date' => $play_date,
				'page'=> 'FM-Register'
				);


			$body = $this->load->view('view_email_template.php',$data,TRUE);

			$this->email->message($body);   

			$stat = $this->email->send();
		
			return $stat;
		 }
		
		 public function check_tourn($tourn_id)
		 {
			$user_id = $this->session->userdata('users_id');
			$reg_details = $this->model_play->get_reg_tournment($tourn_id);

			if((!empty($reg_details['Tournament_ID']) == $tourn_id) && ((!empty($reg_details['Users_ID']) == $user_id)))
			 {
			    return true;
			 }
			else
			{
				return false;
			}
		 }

		 public function check_access_group($access_groups)
		 {		
			return $this->model_play->check_access_group($access_groups);
		 }


		public function invite($tourn_id)
		{
			$data['tourn_id'] = $tourn_id;

			$data['results'] = $this->model_news->get_news();

			$this->load->view('includes/header');
			$this->load->view('view_invitation_users',$data);
			$this->load->view('includes/view_right_column',$data);
			$this->load->view('includes/footer');	
		}

		public function reg_players($tourn_id)
		{
			$details = $this->model_play->getonerow($tourn_id);

			if(!$this->input->post('bulk_register'))
			{
				$data['tourn_id'] = $tourn_id;

				if($details->Usersid == $this->session->userdata('users_id') or $this->is_super_admin){
					$data['r'] = $details;
					$data['results'] = $this->model_news->get_news();
					$data['optimum_users'] = $this->model_play->get_tourbased_users($tourn_id);

					$this->load->view('includes/header');

					if($details->Tournament_type == 'Flexible League')
						$this->load->view('view_reg_players_flex',$data);
					else
						$this->load->view('view_reg_players',$data);

					//$this->load->view('includes/view_right_column',$data);
					$this->load->view('includes/footer');
				}
				else{
					echo "<h4>Unauthorized Access!</h4>";
				}
			}
			else
			{
					if($details->Tournament_type == 'Flexible League')
						$details = $this->model_play->bulk_reg_players_flex();
					else
						$details = $this->model_play->bulk_reg_players();

				redirect("league/$tourn_id");
				//print_r($_POST);
			}
		}
		
		public function invite_email()
		{
			$mes		= $this->input->post('mes');
			$tourn_id	= $this->input->post('tourn_id');

			$tourn_details	= $this->model_play->get_tourn_title($tourn_id);
			$start_date		=  date('m/d/Y',strtotime(substr($tourn_details['StartDate'],0,10))); 
			$close_date		=  date('m/d/Y',strtotime(substr($tourn_details['Registrationsclosedon'],0,10)));
			
			$venue		= $tourn_details['venue'];
			$address	= $tourn_details['TournamentAddress'];
			$city		= $tourn_details['TournamentCity'];
			$state		= $tourn_details['TournamentState'];
			$country	= $tourn_details['TournamentCountry'];

			$title		= $tourn_details['tournament_title'];

			$gen		= $tourn_details['Gender'];
			if($gen == "all"){ $gender = "Open to all"; } else if($gen == "1"){ $gender = "Male"; } else if($gen == "0"){ $gender = "Female"; }else { $gender	  = "Not provided"; }

			$location	= "";

			if($venue != "") { $location .= $venue; }

			if($address != "") { $location .= ", " . $address; } 
			if($city	!= "") { $location .= ", " . $city; } 
			if($state	!= "") { $location .= ", " . $state; } 
			if($country != "") { $location .= ", " . $country . "."; } 

			$name		 = $this->model_play->get_sport_title($tourn_details['SportsType']);
			$sport_title = $name['Sportname'];

			if($tourn_details['is_mult_fee'] == 0 and $tourn_details['Tournamentfee'] == 1){				
				$is_mult	= 0;
				$fee		= $tourn_details['TournamentAmount'];
				$extrafee	= $tourn_details['extrafee'];
			}
			else if($tourn_details['is_mult_fee'] == 1 and $tourn_details['Tournamentfee'] == 1){
				$is_mult	= 1;
				$fee		= $tourn_details['mult_fee_collect'];
				$extrafee	= $tourn_details['addn_mult_fee_collect'];
			}

			//$fee		= $tourn_details['TournamentAmount'];
			//$extrafee	= $tourn_details['extrafee'];

			$emails = $this->input->post('emails');
			
			$explode = preg_split('/[,;]/', $emails);
			
			foreach($explode as $to_email){

			$this->load->library('email');
			$this->email->set_newline("\r\n");

			$this->email->from('admin@a2msports.com', 'A2mSports');
			$this->email->to($to_email);
			
			$this->email->subject( "New Tournament(" . $title . ") Invitation - A2MSports");

			$data = array(
             'message'	=> $mes,
			 'sport'	=> $sport_title,
			 'gender'	=> $gender,
			 'title'	=> $title,
			 'age_groups' => $tourn_details['Age'],
			 'is_mult'	=> $is_mult,
			 'fee'		=> $fee,
			 'extrafee'	=> $extrafee,
			 'start_date' => $start_date,
			 'close_date' => $close_date,
			 'location' => $location,
			 'tourn_id' => $tourn_id,
			 'page'		=> 'New Tournament Invitation'
			);

			$body = $this->load->view('view_email_template.php',$data,TRUE);
			$this->email->message($body);   
			$res = $this->email->send();
			}
			
			//if($res)
			//{
			$data['success'] = "Invitation has been sent successfully.";
			$data['results'] = $this->model_news->get_news();
			$tourn_id = $this->input->post('tourn_id');
			$data['tourn_id'] = $tourn_id;

			$this->load->view('includes/header');
			$this->load->view('view_invitation_users',$data);
			$this->load->view('includes/view_right_column',$data);
			$this->load->view('includes/footer');
			//}
		}

		public function match_search()
		{
			$this->load->view('includes/header');
			$this->load->view('view_search_match');
			$this->load->view('includes/view_right_column');
			$this->load->view('includes/footer');
		}

		public function reg_match($match_id)
    	{
			$data['match_det'] = $this->model_play->get_individual_play($match_id);
			$data['results'] = $this->model_news->get_news();

				$this->load->view('includes/header');
				$this->load->view('view_individual_play_details', $data);
				$this->load->view('includes/view_right_column',$data);
				$this->load->view('includes/footer');
		}
		
		public function get_sport($sport_id)
		{
			return $this->model_play->get_sport_title($sport_id);
		}

		public function get_tourn_title($tourn_id)
		{
			return $this->model_play->get_tourn_title($tourn_id);
		}
		
		public function get_sport_name($gen_match_id)
		{
			return $this->model_play->get_sport_number($gen_match_id);
		}

		public function get_user($user_id)
		{
			return $this->general->get_user($user_id);
		}
		
		public function get_team($team_id)		
		{		
		return $this->general->get_team($team_id);		
		}

		public function update_score_data($play_id)
		{
			$res = $this->model_play->update_match_score($play_id);
				if($res)
				{
					redirect('play');
				}
		}

		public function get_user_det($user_id)
		{
			return $this->general->get_user($user_id);
		}

		public function get_gen_mat_det($gen_match_id)
		{
			return $this->model_play->get_gen_mat_det($gen_match_id);
		}

		public function set_fee_sessions()
		{
			$fee_payable			 = $this->input->post('fp');
			$tid					 = $this->input->post('tid');
			$logged_user_part_team	 = $this->input->post('rteam');

			$this->session->unset_userdata('tour_per_player_fee');
			$this->session->unset_userdata('tourn_id_fee_pay');
			$this->session->unset_userdata('tour_reg_team_id');

			$sess_data = array(
							'tour_per_player_fee' => $fee_payable,
							'tourn_id_fee_pay'	  => $tid,
							'tour_reg_team_id'	  => $logged_user_part_team
							);

			$this->session->set_userdata($sess_data);

			//print_r($this->session->userdata);
		}

	    public function regenerate_events($mult_events){
			$revised_array = array();
			foreach($mult_events as $key => $val){
				if(is_numeric($key)){
				   $arr = explode('-', $val);
				   $ag	= $arr[0];

				   if($arr[1] != 'Mixed'){
					   if(in_array($arr[1], array('Singles','Doubles'))){
						   $gen		= '';
						   $format	= $arr[1];
						   $level	= $arr[2];
					   }
					   else{
						   $gen		= $arr[1];
						   $format	= $arr[2];
						   $level	= $arr[3];
					   }
				   }
				   else{
					   $gen		= $arr[1];
					   $format	= '';
					   $level	= $arr[2];
				   }
					
				   $gen = $this->config->item($arr[0].'-'.$gen, 'age_gender_values');
				   $get_level_label = play::get_level_name('', $level);

				   $revised_array[$val] = $gen.' '.$format.' '.$get_level_label['SportsLevel'];
				}
				else{
				   $arr = explode('-', $key);
				   $ag	= $arr[0];
				   if($arr[1] != 'Mixed'){
					   if(in_array($arr[1], array('Singles','Doubles'))){
						   $gen		= '';
						   $format	= $arr[1];
						   $level	= $arr[2];
					   }
					   else{
						   $gen		= $arr[1];
						   $format	= $arr[2];
						   $level	= $arr[3];
					   }
				   }
				   else{
					   $gen		= $arr[1];
					   $format	= '';
					   $level	= $arr[2];
				   }
				   
				   $gen = $this->config->item($arr[0].'-'.$gen, 'age_gender_values');
				   $get_level_label = play::get_level_name('', $level);

				   $revised_array[$gen.' '.$format.' '.$get_level_label['SportsLevel']] = $val;
				}
			}
			//ksort($revised_array);
			return $revised_array;
		}
		
	}