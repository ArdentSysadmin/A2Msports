<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
//error_reporting(-1);
	session_start(); 
	//League controller ..
	class League extends CI_Controller {

		public $logged_user;
		public $is_super_admin;
		public $is_tourn_director;
		public $is_team_league;
		public $logged_user_role;
		public $sports_dets;
		public $is_league_page;
		public $club_form_url;

		public function __construct()
		{
			parent:: __construct();

		//$this->config->load('paypal_sandbox_config');	// Paypal Live Settings   dev a2msports
		//$this->config->load('paypal_live_config');	// Paypal Live Settings   live a2msports
		//$this->load->library('mypaypal');

			$this->load->helper(array('form', 'url'));

			$this->load->library('form_validation');
			$this->load->library('session');
			$this->load->library('image_lib');

				/*if(!$this->session->userdata('user')){

					$url_seg1 = $this->uri->segment(1);
					$url_seg2 = $this->uri->segment(2);
					$url_seg3 = $this->uri->segment(3);
					
					$last_url = array('redirect_to'=>$url_seg1."/".$url_seg2."/".$url_seg3);
					$this->session->set_userdata($last_url);

					redirect('login');
				}*/

			$this->load->library('rrobin');
			$this->load->helper('directory');
			$this->load->model('model_league');
			$this->load->model('model_news');
			$this->load->model('model_general', 'general');
			$this->load->library('paypal_lib');

			$this->is_super_admin		= 0;
			$this->is_tourn_director	= 0;
			$this->is_league_page		= 1;
			$this->club_form_url			= base_url();

			if($this->session->userdata('users_id')){
				$this->logged_user = $this->session->userdata('users_id');
				if($this->session->userdata('email') == 'rajkamal.kosaraju@gmail.com' or $this->logged_user == 239){
					$this->logged_user_role = "Admin";
					$this->is_super_admin   = 1;
				}
				else if($this->session->userdata('users_id') == 3380 and $this->uri->segment(2) == 2383){
					$this->logged_user_role = "Admin";
					$this->is_super_admin   = 1;
				}
				else if($this->session->userdata('users_id') == 3380 and $this->uri->segment(3) == 2383){
					$this->logged_user_role = "Admin";
					$this->is_super_admin   = 1;
				}
			}
			else{
				$this->logged_user = "";
				$this->logged_user_role = "Visiter";

			}
				$this->sports_dets = $this->session->userdata('menu_items');
		}
		
		// viewing league page ...
		public function new_league()
		{
			//$url_seg = $this->uri->segment(1); 
			//$last_url = array('redirect_to'=>$url_seg);
			//$this->session->set_userdata($last_url);

			$data['intrests'] = $this->model_league->get_intrests();
			$data['results'] = $this->model_news->get_news();

			$sport_id = $this->input->post('sport_type');
			$data['sport_levels'] =  $this->model_league->get_sport_levels($sport_id);

			$data['currency_codes'] = $this->get_allCurrencyCodes();
			if($this->logged_user){
			$data['paypal_ids']		= $this->get_paypalids($this->logged_user);
			$data['user_details']		= $this->general->get_user($this->logged_user);
			}
			
			$this->load->view('includes/header');
			$this->load->view('view_create_league',$data);
			$this->load->view('includes/view_right_column',$data);
			$this->load->view('includes/footer');
		}

		// viewing tournament page ...
		public function index()
		{
			//$url_seg = $this->uri->segment(1); 
			//$last_url = array('redirect_to'=>$url_seg);
			//$this->session->set_userdata($last_url);

			$data['intrests'] = $this->model_league->get_intrests();
			$data['results'] = $this->model_news->get_news();

			$sport_id = $this->input->post('sport_type');
			$data['sport_levels'] =  $this->model_league->get_sport_levels($sport_id);

			$data['currency_codes'] = $this->get_allCurrencyCodes();
			if($this->logged_user){
			$data['paypal_ids']		= $this->get_paypalids($this->logged_user);
			$data['user_details']		= $this->general->get_user($this->logged_user);
			}
			
			$this->load->view('includes/header');
			$this->load->view('view_create_tournament',$data);
			$this->load->view('includes/view_right_column',$data);
			$this->load->view('includes/footer');
		}

		public function Sport_levels($sport_id = '')
		{
			$sport_id = $this->input->post('sport_id');
			$sport_levels = $this->model_league->get_sport_levels($sport_id);

			$sp_level = array();
			echo "<label class='control-label col-md-3' for='id_accomodation'><font color='red'>* </font> <b>Levels:</b> </label>";
			echo "<div class='col-md-9 form-group internal' id='mtype_check' style='padding-bottom: 10px;'>";
			echo "<div class='row'>";
			$cols = 4;
			if(count($sport_levels) > 4){
				$cols = ceil(count($sport_levels) / 3);
			}
			//echo $cols;
			$i = 1;
			foreach($sport_levels as $row){ 
			//if(in_array($row->SportsLevel_ID, $sp_level)){ $checked_stat = 'checked = checked'; }
				if($i == 1){
					echo "<div class='col-md-3 col-xs-4'>";
				}

				echo "<input type='checkbox' class='sp_levels' name='level[]' id='$row->SportsLevel_ID' value='$row->SportsLevel_ID'><span class='control-label' for='$row->SportsLevel_ID'>&nbsp;".trim($row->SportsLevel)."</span>";
				echo "<br>";

				if($i == $cols) {
					echo "</div>";
					$i = 1;
				}
				else {			
					$i++;
				}
			}
			echo "</div>";
		}

		/*public function create_trnmt()
	    {
			if(!$this->logged_user){
				echo "Unauthorised access (or) Session Timeout! Please login and try again.";
				exit;
			}
			else if($this->input->post('title') == ""){
				echo "Invalid data! please contact admin@a2msports.com";
				exit;
			}
	    	//echo "<pre>";print_r($_POST);exit();
	    	
			  $filename = 'TournamentImage';  

				$config = array(
				    'upload_path'	=> "./tour_pictures/",
					'allowed_types' => "gif|jpg|png|jpeg|pdf",
					'overwrite'		=> FALSE,
					'max_size'		=> "10000", // Can be set to particular file size , here it is 2 MB(2048 Kb)
					'max_height'	=> "5000",
					'max_width'		=> "8000"
					);
				
				$this->load->library('upload',$config);
				$data = $this->upload->data();
				$this->upload->initialize($config);
				
				if($this->upload->do_upload($filename)) 
				{	
					$data = $this->upload->data();
					$data['latt'] = $this->get_lang_latt();
					$res = $this->model_league->insert_tournament($data);
				}
				else 
				{
					$data['latt'] = $this->get_lang_latt();
					$res = $this->model_league->insert_tournament($data);
				}
				$tour_details = $res;
			    $tourn_id = $tour_details['tourn_id'];
				$spnsr_filename='spnsr_file_name';
			   
				$tour_folder = 'C:\inetpub\wwwroot\a2msports\tour_pictures\\'.$tourn_id.'';
                
				if (!file_exists($tour_folder)) {
					mkdir($tour_folder, 0777, true);
				}
				$spnsr_folder = 'C:\inetpub\wwwroot\a2msports\tour_pictures\\'.$tourn_id.'\sponsors';
				if (!file_exists($spnsr_folder)) {
					mkdir($spnsr_folder, 0777, true);
				}

				$files = $_FILES;
				$cpt = count($_FILES['spnsr_file_name']['name']);
				$spnsr_addr_link=$_POST['spnsr_addr_link'];
				for($i=0; $i<$cpt; $i++)
				{
				   $rand = md5(uniqid(rand(), true));
				   $format	=	explode('.',$files['spnsr_file_name']['name'][$i]);
                   $format	=	end($format);
				   $re		=	md5($files['spnsr_file_name']['name'][$i]);
				   $re_name =	time()."_".substr($re, 0, 8); 

				   //echo $re_name;exit;
					$_FILES['spnsr_file_name']['name']		= $re_name.'.'.$format;
					$_FILES['spnsr_file_name']['type']		= $files['spnsr_file_name']['type'][$i];
					$_FILES['spnsr_file_name']['tmp_name']	= $files['spnsr_file_name']['tmp_name'][$i];
					$_FILES['spnsr_file_name']['error']	= $files['spnsr_file_name']['error'][$i];
					$_FILES['spnsr_file_name']['size']		= $files['spnsr_file_name']['size'][$i];

					$fileName = 'spnsr_file_name';

					$config = array(
				    'upload_path'	=> "./tour_pictures/$tourn_id/sponsors/",
					'allowed_types' => "gif|jpg|png|jpeg",
					'overwrite'		=> TRUE,
					'max_size'		=> "10000", // Can be set to particular file size , here it is ~10 MB(2048 Kb)
					'max_height'	=> "8000",
					'max_width'		=> "10000");

				   $this->load->library('upload',$config);  
				   $this->upload->initialize($config);
				   if($this->upload->do_upload($fileName)){
					    $upload_data = $this->upload->data();
					    $file_name_arr[$upload_data['file_name']]=$spnsr_addr_link[$i];
					}
				}
				if(!empty($file_name_arr)){
                   $filenames_json=json_encode($file_name_arr);				
                   $this->model_league->update_spnsr_images($filenames_json,$tourn_id);
				}				
				//$email_status = $this->email_create_tournament($res);
                $tourn_det = $this->model_league->getonerow($tourn_id);
                if($tourn_det->Short_Code!=""){
                   redirect("$tourn_det->Short_Code");
                }else{
                   redirect("league/$tourn_id");
                }				
		 }*/

	public function create_trnmt()
	{
/*
if($this->logged_user == 240 and $this->input->post('is_league') == 1){
		echo "<pre>League<br>"; print_r($_POST); 

				$game = $this->input->post('game_dt');
				$stime = $this->input->post('game_st');
				$res = array();
				foreach($game as $event => $gm){
					foreach($gm as $i => $dt){
					$occr_date = date('Y-m-d H:i', strtotime($gm[$i]." ".$stime[$event][$i]));
					$res[$occr_date][] = $event;
					}
				}

				 ksort($res);
				foreach($res as $dt => $ocr){
					echo $dt." - ".json_encode($ocr)."<br>";
				}		
		exit;
}
else if($this->logged_user == 240){
		echo "<pre>Testing ELSE"; print_r($_POST); exit;
}
*/


			if(!$this->logged_user){
				echo "Unauthorised access (or) Session Timeout! Please login and try again.";
				exit;
			}
			else if($this->input->post('title') == ""){
				echo "Invalid data! please contact admin@a2msports.com";
				exit;
			}


			$filename				= 'TournamentImage';  
			$rules_attachment = 'details_rules_pdf';
			$medi_attachment = 'medical_form_pdf';

			$data['latt'] = $this->get_lang_latt();
	
			$res		  = $this->model_league->insert_tournament($data);
			$tour_details = $res;
			$tourn_id	  = $tour_details['tourn_id'];
			$doc_root	  = $_SERVER['DOCUMENT_ROOT'];

			$details_rules_pdf_folder = $doc_root.'\tour_pictures\\'.$tourn_id;
			$attachments_array = array();
			if (!file_exists($details_rules_pdf_folder)){
				mkdir($details_rules_pdf_folder, 0777, true);
			}
	/* ***************** Code to upload Tournment Image Form Starts Here. *********************** */
			$config = array(
				'upload_path'	=> $_SERVER['DOCUMENT_ROOT'].'\a2msports\tour_pictures',
				'allowed_types' => "gif|jpg|png|jpeg",
				'overwrite'		=> FALSE,
				'max_size'		=> "10000", // Can be set to particular file size , here it is 2 MB(2048 Kb)
				'max_height'	=> "5000",
				'max_width'		=> "8000"
				);
			
			$this->load->library('upload');
			$this->upload->initialize($config);

			if($this->upload->do_upload($filename)){
				$data['tourn_image'] = $this->upload->data();
				array_push($attachments_array, $data['tourn_image']['file_name']);
			}
			else{
				array_push($attachments_array, "");
			}
	/* ***************** Code to upload Tournment Image Form Ends Here. *********************** */

	/* ***************** Code to upload Details Rules & Medical Release Form Starts Here. *********************** */
			$config = array(
				'upload_path'	=> $details_rules_pdf_folder,
				'allowed_types' => "pdf",
				'overwrite'		=> TRUE,
				'max_size'		=> "10240" // Can be set to particular file size , here it is ~10 MB(2048 Kb)
			);

			$this->load->library('upload', $config); 
			$this->upload->initialize($config);
			if($this->upload->do_upload($rules_attachment)){
				$data['rules_attach'] = $this->upload->data();
				array_push($attachments_array,$data['rules_attach']['file_name']);
			}
			else{
				array_push($attachments_array, "");
			}
	
			if($this->upload->do_upload($medi_attachment)){
				$data['medical_attach'] = $this->upload->data();
				array_push($attachments_array,$data['medical_attach']['file_name']);
			}
			else{
				array_push($attachments_array, "");
			}

			$this->model_league->update_tourn_attachments($attachments_array,$tourn_id);
		/*	echo "<pre>";
			print_r($attachments_array);
			exit;*/
    /* ****************** Code to upload Details Rules & Medical Release Form Ends Here. *********************** */

				$spnsr_filename='spnsr_file_name';
			   $doc_root = $_SERVER['DOCUMENT_ROOT'];

				$tour_folder = $doc_root.'\tour_pictures\\'.$tourn_id.'';
                
				if (!file_exists($tour_folder)){
					mkdir($tour_folder, 0777, true);
				}
				$spnsr_folder = $doc_root.'\tour_pictures\\'.$tourn_id.'\sponsors';
				if (!file_exists($spnsr_folder)){
					mkdir($spnsr_folder, 0777, true);
				}

				$files = $_FILES;
				$cpt = count($_FILES['spnsr_file_name']['name']);
				$spnsr_addr_link=$_POST['spnsr_addr_link'];
				for($i=0; $i<$cpt; $i++){
				   $rand = md5(uniqid(rand(), true));
				   $format	=	explode('.',$files['spnsr_file_name']['name'][$i]);
                   $format	=	end($format);
				   $re		=	md5($files['spnsr_file_name']['name'][$i]);
				   $re_name =	time()."_".substr($re, 0, 8); 

				   //echo $re_name;exit;
					$_FILES['spnsr_file_name']['name']		= $re_name.'.'.$format;
					$_FILES['spnsr_file_name']['type']		= $files['spnsr_file_name']['type'][$i];
					$_FILES['spnsr_file_name']['tmp_name']	= $files['spnsr_file_name']['tmp_name'][$i];
					$_FILES['spnsr_file_name']['error']	= $files['spnsr_file_name']['error'][$i];
					$_FILES['spnsr_file_name']['size']		= $files['spnsr_file_name']['size'][$i];

					$fileName = 'spnsr_file_name';

					$config = array(
									'upload_path'	=> "./tour_pictures/$tourn_id/sponsors/",
									'allowed_types' => "gif|jpg|png|jpeg",
									'overwrite'			=> TRUE,
									'max_size'			=> "10000", 
									// Can be set to particular file size, here it is ~10 MB(2048 Kb)
									'max_height'		=> "8000",
									'max_width'		=> "10000");

				   $this->load->library('upload',$config);  
				   $this->upload->initialize($config);
				   if($this->upload->do_upload($fileName)){
					    $upload_data = $this->upload->data();
					    $file_name_arr[$upload_data['file_name']]=$spnsr_addr_link[$i];
					}

				}

				if(!empty($file_name_arr)){
                   $filenames_json=json_encode($file_name_arr);				
                   $this->model_league->update_spnsr_images($filenames_json,$tourn_id);
				}	
				//$email_status = $this->email_create_tournament($res);
                $tourn_det = $this->model_league->getonerow($tourn_id);

						$userdat							=	$this->get_username('240');
		                $tourn_admin_email			=	$userdat['EmailID'];
		                $tourn_admin_firstname	=	$userdat['Firstname'];
		                $tourn_admin_lastname	=	$userdat['Lastname'];

						$tourn_admin_data = array(
														'admin_firstname'	=> $tourn_admin_firstname,
														'admin_lastname'	=> $tourn_admin_lastname,
														'tourn_id'				=> $tourn_id,
														'title'						=> $tourn_det->tournament_title,
														'page'					=> 'Tournament Creation Admin Notif'
														);
					$subject = "Tournament Creation Notification!";
				$this->email_to_player($tourn_admin_email, $subject, $tourn_admin_data);

                if($tourn_det->Short_Code!=""){
                   redirect("$tourn_det->Short_Code");
                }
				else{
                   redirect("league/$tourn_id");
                }	
	}

		 public function email_create_tournament($res)
		 {
			
			$tour_details = $res;

			
			$tourn_id  = $tour_details['tourn_id'];
			$tourn_det = $this->model_league->getonerow($tourn_id);

			$start_date =  date('m/d/Y',strtotime(substr($tourn_det->StartDate,0,10))); 
			$close_date =  date('m/d/Y',strtotime(substr($tourn_det->Registrationsclosedon,0,10)));
			
			$venue		= $tourn_det->venue;
			$address	= $tourn_det->TournamentAddress;
			$city		= $tourn_det->TournamentCity;
			$state		= $tourn_det->TournamentState;
			$country	= $tourn_det->TournamentCountry;

			$title		= $tourn_det->tournament_title;
			$gen		= $tourn_det->Gender;

			if($gen == "all"){ $gender = "Open to all"; } else if($gen == "1"){ $gender = "Male"; } else if($gen == "0"){ $gender = "Female"; }else { $gender = "Not provided"; }

			$location = "";

			if($venue != "") { $location .= $venue;}

			if($address != "") { $location .=  ", " . $address ;} 
			if($city	!= "") { $location .=  ", " . $city;} 
			if($state	!= "") { $location .=  ", " . $state;} 
			if($country != "") { $location .=  ", " . $country . ".";} 

			$sport_id	= $tourn_det->SportsType;
			$name		= $this->model_league->get_sport_title($sport_id);
			$sport_title = $name['Sportname'];

			$organizer	= $tourn_det->OrganizerName;
			$contact	= $tourn_det->ContactNumber;

			$fee		= $tourn_det->TournamentAmount;
			$extrafee	= $tourn_det->extrafee;

			$get_sport_users = $this->model_league->get_sport_users($sport_id,$country,$state);
			
			foreach($get_sport_users as $row){

				$this->load->library('email');
				$this->email->set_newline("\r\n");

				$this->email->from(FROM_EMAIL, 'A2MSports');
				$this->email->to($row->EmailID);

				$subject = "New ".$sport_title."Tournament - A2MSports";
				
				$this->email->subject($subject);

				$data = array(
				 'fname'	=> $row->Firstname,
				 'lname'	=> $row->Lastname,
				 'sport'	=> $sport_title,
				 'gender'	=> $gender,
				 'fee'		=> $fee,
				  'extrafee'=> $extrafee,
				  'org'		=> $organizer,
				 'contact'	=> $contact,
				 'title'	=> $title,
				 'start_date' => $start_date,
				 'close_date' => $close_date,
				 'location' => $location,
				 'tourn_id' => $tourn_id,
				 'page'		=> 'New Tournament Creation'
				);

				$body = $this->load->view('view_email_template.php',$data,TRUE);
				$this->email->message($body);   
				$status = $this->email->send();
			}
	
			return $status;
		}

		public function tourn_land($tid, $stat = ''){
			if(!is_numeric($tid)){ echo "Invalid Request!"; exit; }
			$tr_det = $this->model_league->getonerow($tid);

			if($tr_det) {
				$this->is_team_league = ($tr_det->tournament_format  == 'Teams' or $tr_det->tournament_format  == 'TeamSport') ? 1 : 0;
                $top_players=$this->model_league->GetTopTenPlayers($tid,$tr_det->SportsType);
                $data['get_images'] = $this->model_league->get_individual_tourn_images($tid);
                $data['brackets'] = league::get_bracket_list($tid);

				$data['tr_det'] = $tr_det;
				$this->load->view('includes/header_land', $data);
               // echo "<pre>";print_r($tr_det);exit();
				$data['tour_details']	= $tr_det;
				$data['top_players']	= $top_players;
				$data['results']		= $this->model_news->get_news();
				$data['reg_suc']		= $stat;
				$this->load->view('view_tourn_land_latest', $data);
				$this->load->view('includes/footer_land');
			}
			else {
				echo "Invalid Access!";
			}
		}

		public function view($tid, $stat = '')
		{
			if(!is_numeric($tid)){ echo "Invalid Request!"; exit; }

			$tr_det = $this->model_league->getonerow($tid);

			if($tr_det) {
				$is_reg	= $this->user_reg_or_not($this->logged_user, $tid);

				if($tr_det->Usersid == $this->logged_user or $tr_det->Tournament_Director == $this->logged_user or $this->is_super_admin){    /// tournament admin access links
				$this->logged_user_role = 'Admin';
				}
				else if($is_reg){
				$this->logged_user_role = 'RegPlayer';
				}

				$this->is_team_league = ($tr_det->tournament_format  == 'Teams') ? 1 : 0;

				$data['tr_det'] = $tr_det;
				$this->load->view('includes/header', $data);

				$data['tour_details']	= $tr_det;
				$data['results']			= $this->model_news->get_news();
				$data['reg_suc']			= $stat;
				
				/* Filtering MyMatches */
				$count = 0;
				$data['valid_draws_count']	= $count;
				$data['show_draw_bid']			= 0;

				if(($this->logged_user) and ($tr_det->Usersid != $this->logged_user and $tr_det->Tournament_Director != $this->logged_user )){
					$brackets = $this->get_bracket_list($tid);
					if(count(array_filter($brackets)) > 0){
						foreach($brackets as $bk)
						{
							if($this->is_team_league){
							$check_user = $this->check_team_is_user_exists($tid, $bk->BracketID, $tr_det->SportsType);
							}
							else{
							$check_user = $this->check_is_user_exists($tid, $bk->BracketID, $tr_det->SportsType);
							}

							if($check_user){
								$show_bid = $bk->BracketID;
								$count++; 
							}
						}
					}
				$data['valid_draws_count']	= $count;
				$data['show_draw_bid']			= $show_bid;
				}
				/* Filtering MyMatches */

				$data['is_logged_user_reg'] = $this->model_league->is_logged_user_reg($tid);

				if($this->is_team_league){
				$team_fee_type = $tr_det->Fee_collect_type;
				$data['fee_payable'] = '';

				//$data['is_logged_user_reg'] = $this->model_league->get_team_reg_tournment($tourn_id);		

				$user_reg_team = $this->model_league->get_team_reg($this->logged_user, $tid);
				$data['is_logged_user_reg'] = $user_reg_team;

				 $cur_date = date('Y-m-d');
				 $reg_closed_on = date('Y-m-d', strtotime($tr_det->Registrationsclosedon));

				 if(!empty($user_reg_team) and $team_fee_type == 'Player' and ($tr_det->Usersid != $this->logged_user and $tr_det->Tournament_Director != $this->logged_user ) and $reg_closed_on >= $cur_date){
					
					$team_reg_age_group		= $user_reg_team['Reg_Age_Group'];
					$logged_user_part_team	= $user_reg_team['Team_id'];
			
					$is_paid = $this->model_league->check_is_paid($this->logged_user, $tid, $logged_user_part_team);
					if(!$is_paid){
					$tr_age_group = json_decode($tr_det->Age);
					$tr_fee		  = json_decode($tr_det->mult_fee_collect);

					$key = array_search($team_reg_age_group, $tr_age_group);

					$fee_payable = $tr_fee[$key];
					$data['fee_payable'] = number_format($fee_payable, 2);
					//echo $fee_payable;
					$data['my_reg_team'] = $logged_user_part_team;

					$this->session->unset_userdata('tour_per_player_fee');
					$this->session->unset_userdata('tourn_id_fee_pay');
					$this->session->unset_userdata('tour_reg_team_id');

					$sess_data = array('tour_per_player_fee'=>number_format($fee_payable, 2), 'tourn_id_fee_pay'=>$tid, 'tour_reg_team_id'=>$logged_user_part_team);

					$this->session->set_userdata($sess_data);
					}
				  }
				}

				if((is_array($data['is_logged_user_reg']) or $data['is_logged_user_reg'] == '1') and $this->logged_user != ""){
					$check_addr	= $this->model_league->check_user_addr($this->logged_user);
					$data['user_info'] = $check_addr;

					($check_addr->DOB != NULL) 
						? $data['udob'] = 1 : $data['udob'] = 0;

					(($check_addr->UserAddressline1 != NULL and $check_addr->UserAddressline1 != '') 
					or 
					($check_addr->UserAddressline2 != NULL and $check_addr->UserAddressline2 != '')) 
						? $data['uaddr'] = 1 : $data['uaddr'] = 0;

					($check_addr->EmailID != NULL or $check_addr->AlternateEmailID != NULL) 
						? $data['uemail'] = 1 : $data['uemail'] = 0;	
				}

				if($data['udob'] == '0' or $data['uaddr'] == '0' or $data['uemail'] == '0'){
					$data['r'] = $tr_det;
					$data['results'] = $this->model_news->get_news();
					$this->load->view('tournament/view_update_basic_profile', $data); 
					$this->load->view('includes/view_right_column',$data);
					$this->load->view('includes/footer');	
				}
				else{
					$data['show_landing_page'] = 1;
					$data['tourn_comments']	= $this->general->get_tourn_comments($tid);
					$data['tourn_teams']	= $this->model_league->Get_TournamentTeams($tid);
					$this->load->view('view_tournament', $data);
					$this->load->view('includes/footer');
				}
			}
			else
			{
				echo "Invalid Access!";
			}
		}

		public function edit_bck($tid)
		{
			$sport_id="";
			$data['tour_details'] = $this->model_league->getonerow($tid);
			$data['reg_users']	  = $this->model_league->get_reg_tourn_participants($tid);
			$total_agegroups      = array();
		    $total_sprt_lvls      = array();

		    foreach ($data['reg_users'] as $keys => $value) {
		    	$age_groups = array_unique(json_decode($value->Reg_Age_Group));
		        foreach ($age_groups[0] as $key => $val) {		    		
		    		
		    		array_push($total_agegroups,$val);
		    	}
		    
		    }
		    foreach ($data['reg_users'] as $keys => $value) {
		    
		    	$sport_lvels = json_decode($value->Reg_Sport_Level);
		    	foreach ($sport_lvels[0] as $key => $val) {		    		
		    		foreach ($val as $k => $vl) {		    		
		    		  array_push($total_sprt_lvls,$vl);
		    	    }	
		    	}
		    }

		    $total_agegroups          = array_unique($total_agegroups);
		    $data['regusers_agegrps'] = $total_agegroups;
		    $data['regusers_sportlevls'] = array_unique($total_sprt_lvls);
			$data['sport_levels'] =  $this->model_league->get_sport_levels($data['tour_details']->SportsType);
			$details = $data['tour_details'];
			$user_id = $this->logged_user;

			if($details->Usersid == $user_id or $details->Tournament_Director == $user_id){

				$data['results'] = $this->model_news->get_news();
				$data['intrests'] = $this->model_league->get_intrests();
				
				$this->load->view('includes/header');
				$this->load->view('view_edit_tournament',$data);
				$this->load->view('includes/view_right_column',$data);
				$this->load->view('includes/footer');
			}
			else
			{ echo "<h4>Unauthorized Access</h4>"; }
		}

		public function update_trnmt()
			{
				//echo "<pre>"; print_r($_POST);	exit;

			  // $sdate = date('h:i', strtotime($this->input->post('stime')));echo $sdate;exit();
	  
				$data['tourn_id'] = $this->input->post('tourn_id'); 
				$tourn_id=$data['tourn_id'];

				 if(!empty($_FILES['TournamentImage']['name'])){
					
					$filename = 'TournamentImage'; 
		
					$config = array(
						'upload_path' => "./tour_pictures/",
						'allowed_types' => "gif|jpg|png|jpeg|pdf",
						'overwrite' => FALSE,
						'max_size' => "10000", // Can be set to particular file size , here it is 2 MB(2048 Kb)
						'max_height' => "5000",
						'max_width' => "8000"
						);
					
					$this->load->library('upload',$config);
					$this->upload->initialize($config);

					if($this->upload->do_upload($filename)) 
					{	
						$data['up_image'] = $this->upload->data();
						// Deleting of Old Profile Pic
						$tourn_image = $this->input->post('Image');

						if($tourn_image){
							$data['del_pic'] = $tourn_image;
							$this->load->helper("url");
							$path = './tour_pictures/'.$data['del_pic'];
							unlink($path);
						}
						else{
						  //
						}

						$data['latt'] = $this->get_lang_latt();
						$res = $this->model_league->update_tournament($data);
					}
				 }
				 else{
					$data['latt'] = $this->get_lang_latt();
					$res		  = $this->model_league->update_tournament($data);
				 }

				 $tourn_det = $this->model_league->getonerow($tourn_id);

				 if($tourn_det->Sponsors != ''){
					 $spnsr_arr = json_decode($tourn_det->Sponsors, true);
				 }
				 else{
					$spnsr_arr = array();
				 }
				
				 $files = $_FILES;
				 $cpt = count($_FILES['spnsr_file_name']['name']);
				 $spnsr_addr_link=$_POST['spnsr_addr_link'];
				 if($cpt>0){
					$spnsr_filename = 'spnsr_file_name';
					$doc_root			  = $_SERVER['DOCUMENT_ROOT'];
					$tour_folder = $doc_root.'\tour_pictures\\'.$tourn_id.'';
					if (!file_exists($tour_folder)) {
						mkdir($tour_folder, 0777, true);
					}
					$spnsr_folder = $doc_root.'\tour_pictures\\'.$tourn_id.'\sponsors';
					if (!file_exists($spnsr_folder)) {
						mkdir($spnsr_folder, 0777, true);
					}
					for($i=0; $i<$cpt; $i++)
					{
					   $rand = md5(uniqid(rand(), true));
					   $format	=	explode('.',$files['spnsr_file_name']['name'][$i]);
					   $format	=	end($format);
					   $re		=	md5($files['spnsr_file_name']['name'][$i]);
					   $re_name =	time()."_".substr($re, 0, 8); 

					   //echo $re_name;exit;
						$_FILES['spnsr_file_name']['name']		= $re_name.'.'.$format;
						$_FILES['spnsr_file_name']['type']		= $files['spnsr_file_name']['type'][$i];
						$_FILES['spnsr_file_name']['tmp_name']	= $files['spnsr_file_name']['tmp_name'][$i];
						$_FILES['spnsr_file_name']['error']		= $files['spnsr_file_name']['error'][$i];
						$_FILES['spnsr_file_name']['size']		= $files['spnsr_file_name']['size'][$i];

						$fileName = 'spnsr_file_name';

						$config = array(
						'upload_path'	=> "./tour_pictures/$tourn_id/sponsors/",
						'allowed_types' => "gif|jpg|png|jpeg",
						'overwrite'		=> TRUE,
						'max_size'		=> "10000", // Can be set to particular file size , here it is ~10 MB(2048 Kb)
						'max_height'	=> "8000",
						'max_width'		=> "10000");

					   $this->load->library('upload',$config);  
					   $this->upload->initialize($config);

						if($this->upload->do_upload($fileName)){
							$upload_data = $this->upload->data();
							$file_name_arr[$upload_data['file_name']]=$spnsr_addr_link[$i];
						}
					}

					if(count($file_name_arr) > 0){
						if(count($spnsr_arr) > 0){
						 $spnsr = array_merge($spnsr_arr,$file_name_arr);
						}
						else{
						 $spnsr = $file_name_arr;
						}
						$filenames_json=json_encode($spnsr);

						$this->model_league->update_spnsr_images($filenames_json, $tourn_id);
					}
				 }
					
					//$email_status = $this->email_update_tournament($res);
					$tour_details = $res;
					$tourn_id = $tour_details['tourn_id'];
					
					redirect("league/$tourn_id");
			 }

		 public function email_update_tournament($res)
		 {
			
			$tour_details = $res;

			$tourn_id = $tour_details['tourn_id'];
			$title = $tour_details['title'];

			$reg_players = $this->model_league->get_reg_players($tourn_id);
	
			foreach($reg_players as $row){

				$this->load->library('email');
				$this->email->set_newline("\r\n");
				
				$player_det = $this->get_username($row->Users_ID);
				$player_name = $player_det['Firstname'] . " " . $player_det['Lastname'];
				$player_email = $player_det['EmailID'];

				$this->email->from(FROM_EMAIL, 'A2MSports');
				$this->email->to($player_email);

				$subject = $title."Tournament - A2MSports";
				
				$this->email->subject($subject);

				$data = array(
				 'name' => $player_name,
				 'title'=> $title,
				 'tourn_id' => $tourn_id,
				 'page'=> 'Update Tournament'
				);

				$body = $this->load->view('view_email_template.php',$data,TRUE);
				$this->email->message($body);   
				$status = $this->email->send();
			}
	
			return $status;
		}

		public function get_lang_latt()
		{
			 // $address1 = $this->input->post('UserAddressline1');
			if($this->input->post('addr2')==""){
			 $address2 = $this->input->post('addr1');
			} else {
			 $address2 = $this->input->post('addr2');
			}
			 $country = $this->input->post('country');

				if($country == 'United States of America') {
					$state = $this->input->post('state');
				} else {
					$state = $this->input->post('state1');
				}

			 $city = $this->input->post('city');
			 if($address2 != ""){
				 $address =  $address2 . ' ' .  $country . ' ' .  $state . ' ' .  $city;
			 } else {
				 $address =  $country . ' ' .  $state . ' ' .  $city;
			 }

			if($address!=""){
		//echo "<pre>"; print_r($address); 

			//Formatted address
			$formattedAddr = str_replace(' ','+',$address);
			//echo "<pre>"; print_r($formattedAddr); 

			//Send request and receive json data by address
			/*$geocodeFromAddr = file_get_contents('http://maps.googleapis.com/maps/api/geocode/json?address='.$formattedAddr.'&sensor=true_or_false');*/
			//$geocodeFromAddr = file_get_contents("https://maps.googleapis.com/maps/api/geocode/json?key=AIzaSyCOccaanEfTkqgx-MhxKDLyzpOpg_gYJiQ&address=".$formattedAddr."&sensor=true");
			$geocodeFromAddr = file_get_contents("https://maps.googleapis.com/maps/api/geocode/json?address=".$formattedAddr."&key=".GEO_LOC_KEY);


			/*$url= 'https://maps.googleapis.com/maps/api/geocode/json?address=1600+Amphitheatre+Parkway,+Mountain+View,+CA&key=AIzaSyCttpLTu7qGmQ37-_AyodCKO4Ca5BHJopE';
			$arrContextOptions=array(
				  "ssl"=>array(
						"verify_peer"=>false,
						"verify_peer_name"=>false,
					),
				);  
			$response = file_get_contents($url, false, stream_context_create($arrContextOptions));
			*/

			$output1 = json_decode($geocodeFromAddr);
			//echo "<pre>"; print_r($geocodeFromAddr); 
	
			$latitude  = 0.00; 
			$longitude = 0.00;

		/*echo "<pre>"; 
		print_r($response);
		print_r($output1);
		exit;*/
			//Get latitude and longitute from json data
			$latitude  = $output1->results[0]->geometry->location->lat; 
			$longitude = $output1->results[0]->geometry->location->lng;

			return  $latitude  . '@' . $longitude ;
			} 
			else 
			{
				return false;
			}
	  }

		public function get_reg_tourn_player_names($tourn_id){
	    	return $this->model_league->get_reg_tourn_player_names($tourn_id);
		}
		
		public function get_reg_players($tourn_id, $sport){
	    	return $this->model_league->get_reg_tourn_players($tourn_id, $sport);
		}
		
		public function get_paytransactions($tourn_id, $user){
	    	return $this->model_league->get_paytransactions($tourn_id, $user);
		}
		
		public function get_refund_trans($reg_tourn_id){
	    	return $this->model_league->get_refund_trans($reg_tourn_id);
		}
		
		public function get_tourn_team_players($tourn_id){
	    	$reg_teams		  = $this->model_league->get_tourn_team_players($tourn_id);
			$reg_team_players = array();

			foreach($reg_teams as $team){
				$team_players = json_decode($team->Team_Players, true);
				foreach($team_players as $player){
					$reg_team_players[$team->Team_id][Reg_Date] = $team->Reg_date;
					$reg_team_players[$team->Team_id][Users][] = $player;
				}
			}

			//echo "<pre>"; print_r($reg_team_players); exit;
			return $reg_team_players;
		}
		
		public function get_team_player_payment_info($user, $tourn_id){

			$get_payment = $this->model_league->get_team_player_payment_info($user, $tourn_id);
			/*echo "<pre>";
			print_r($get_payment);*/
			return $get_payment;
		}

		public function get_reg_tourn_partner_names($tourn_id, $event){
			if($tourn_id == "" and $event == "") {
				$tourn_id = $this->input->post('tourn_id');
				$event	  = $this->input->post('event');
				
				$data['tourn_partner_names'] = $this->model_league->get_reg_tourn_partner_names($tourn_id, $event);
				$data['event']		 = $event;

				$this->load->view('view_dbl_partner_ajax', $data);
			}
			else {
				return $this->model_league->get_reg_tourn_partner_names($tourn_id, $event);
			}
		}

		 public function get_sport($sport_id)
		 {
			return $this->model_league->get_sport_name($sport_id);
		 }

		 public function get_level_name($sport_id,$level)
		 {
			return $this->model_league->get_level_name($sport_id, (int)$level);
		 }

		 public function getonerow($tourn_id)
		 {
			return $this->model_league->getonerow($tourn_id);
		 }

		 public function user_reg_or_not($user_id,$tourn_id)
		 {
			$res = $this->model_league->user_reg_or_not($user_id,$tourn_id);	
			return $res;
		 }

		 public function get_user($user_id) {
			return $this->model_league->get_user_name($user_id);
		 }

		 public function apply_gc($gc = '') {
			$gc			 = $this->input->post('gc');
			$tourn_id	 = $this->input->post('tid');
			$tot_reg_fee = $this->session->userdata('tour_reg_fee');
			
			if($gc){
				$res = $this->calc_discount_amt($gc, $tot_reg_fee, $tourn_id);

				if($res['total_after_gc'] > -1){
					$this->session->unset_userdata('tour_reg_fee');
					$sess_data = array('tour_reg_fee' => number_format($total_fee, 2));

					$this->session->set_userdata($sess_data);
				}

				echo $res['total_after_gc'] . "#" . $res['discount'] . "#" . $res['coupon_id'];
			}
			else{
				echo "Error!";
			}
		 }

		 public function calc_discount_amt($gc, $tot_reg_fee, $ref_id){
			$get_gc	= $this->general->get_coupon_code($gc, $ref_id);
			$cid			= $get_gc['Coupon_ID'];

			if($get_gc['Discount_Method'] == 'percentage'){
				$disc_amt	  = number_format(($get_gc['Coupon_Value'] * $tot_reg_fee) / 100, 2);
				$tot_after_gc = $tot_reg_fee - $disc_amt;
			}
			else if($get_gc['Discount_Method'] == 'fixedprice'){
				$disc_amt	  = $get_gc['Coupon_Value'];
				$tot_after_gc = number_format(($tot_reg_fee - $get_gc['Coupon_Value']), 2);
			}
			else{
				$cid		  = "";
				$disc_amt	  = 0;
				$tot_after_gc = -1;
			}

			$res = array('coupon_id' => $cid, 'discount' => $disc_amt, 'total_after_gc' => $tot_after_gc);
			return $res;
		 }

		 public function get_tour_fee()
		 {
			/*echo "<pre>";
			 print_r($_POST);
			exit;*/
/*
Array
(
[tour_id] => 1330
[ag_grp] => Array
(
[0] => Adults
[1] => Adults
)

[format] => Array
(
[0] => Doubles
[1] => Doubles
)

[is_flag_age] => 0
[user_age_grp] => Adults
[coupon] => 
)
*/

			$this->session->unset_userdata('tour_reg_fee');
			$this->session->unset_userdata('reg_tour_id');

			$tour_id  = $this->input->post('tour_id');
			$ag_grp  = $this->input->post('ag_grp');
			$is_flag_age    = $this->input->post('is_flag_age');
			$user_age_grp = $this->input->post('user_age_grp');
			$sg		 = $this->input->post('sg');
			$db		 = $this->input->post('db');
			$mx		 = $this->input->post('mx');
			$coupon = $this->input->post('coupon');

			$get_tour_info = $this->model_league->getonerow($tour_id);

			if($get_tour_info->Tournamentfee == 1)
			{
				$db_ag_grp    = json_decode($get_tour_info->Age);
				$db_levels		 = json_decode($get_tour_info->Sport_levels);
				$db_fee			 = json_decode($get_tour_info->mult_fee_collect);
				$db_addn_fee = json_decode($get_tour_info->addn_mult_fee_collect);
				$exis_ag		 = array();
				$total_fee		 = 0.00;
				
				foreach($ag_grp as $i => $ag){

					if($is_flag_age==1){
                       $index = array_search($user_age_grp, $db_ag_grp);        
				    }
					else{
					   $index = array_search($ag_grp[0], $db_ag_grp);
				    }
				    //echo $is_flag_age;exit;
					//echo "<pre>"; print_r($db_fee);
					//echo $coupon; exit;
					//$index	= array_search($ag, $db_ag_grp);
					$fee		= 0.00;
					$extra_fee  = 0.00;

					if(!in_array($ag_grp[0], $exis_ag)){
						  $fee = number_format($db_fee[$index], 2);
						if($fee == 0.00){
	                      $fee = number_format($db_fee[array_search($ag_grp[0], $db_ag_grp)], 2);  
						}
					}
					else{
					 $extra_fee	= number_format($db_addn_fee[$index], 2);
					}

					$exis_ag[] = $ag;
					//echo $fee." ".$extra_fee."<br>";
				   $total_fee += ($fee + $extra_fee);
				}

				$disc = 0;

				if($coupon){
					$res		= $this->calc_discount_amt($coupon, $total_fee, $tour_id);
					$total_fee  = $res['total_after_gc'];
					$disc		= $res['discount'];
				}                 
				/*foreach($ag_grp as $i => $ag){

					if(in_array($ag, array('30s','40s','50s'))){
					$a = 'Adults_'.rtrim($ag,'s').'p';
					$index	= array_search($a, $db_ag_grp);
					}
					else{
					$index	= array_search($ag, $db_ag_grp);
					}

					//$index	= array_search($ag, $db_ag_grp);
					$fee		= 0.00;
					$extra_fee  = 0.00;

					if(!in_array($ag, $exis_ag)){
					 $fee		= number_format($db_fee[$index], 2);
					}
					else{
					 $extra_fee	= number_format($db_addn_fee[$index], 2);
					}

					$exis_ag[] = $ag;

				$total_fee += ($fee + $extra_fee);
				}*/
			}
			else{
				$total_fee = 0.00;
			}

			$sess_data = array('tour_reg_fee'=>number_format($total_fee, 2), 'reg_tour_id'=>$tour_id);
//echo "<pre>".print_r($sess_data);
//30.00#0#
			$this->session->set_userdata($sess_data);

			/*if($this->logged_user == 237){
			echo number_format('1',2);
			}
			else{*/
			//echo number_format($total_fee, 2);    // Returns the Total Payable price to the view 

			echo number_format($total_fee, 2)."#".$disc."#".$coupon;    // Returns the Total Payable price to the view 
			exit;
		 }

		 public function get_team_reg_fee()
		 {

			$this->session->unset_userdata('tour_reg_fee');
			$this->session->unset_userdata('reg_tour_id');

			$tour_id = $this->input->post('tour_id');
			$ag_grp  = $this->input->post('ag_grp');

			$get_tour_info = $this->model_league->getonerow($tour_id);

			if($get_tour_info->Tournamentfee == 1){
				$db_ag_grp   = json_decode($get_tour_info->Age);
				$db_fee		 = json_decode($get_tour_info->mult_fee_collect);

				$total_fee	 = 0.00;
				
                   $index	= array_search($ag_grp, $db_ag_grp); 
				   //if($index !== ""){
					   $fee			= number_format($db_fee[$index], 2);
					   $total_fee	= $fee;
				   //}
			}
			else{
				$total_fee = 0.00;
			}

			$sess_data = array('tour_reg_fee'=>number_format($total_fee, 2), 'reg_tour_id'=>$tour_id);

			$this->session->set_userdata($sess_data);

			echo number_format($total_fee, 2);    // Returns the Total Payable price to the view 
		 }

		 public function get_tour_fee_teamleague()
		 {
			$this->session->unset_userdata('tour_reg_fee');
			$this->session->unset_userdata('reg_tour_id');

			$tour_id = $this->input->post('tour_id');
			$ag		 = $this->input->post('ag_grp');
			$level	 = $this->input->post('level');

			$get_tour_info = $this->model_league->getonerow($tour_id);

			if($get_tour_info->Tournamentfee == 1)
			{
				$db_ag_grp   = json_decode($get_tour_info->Age);
				$db_levels   = json_decode($get_tour_info->Sport_levels);
				$db_fee		 = json_decode($get_tour_info->mult_fee_collect);

				$total_fee	 = 0.00;

					if(in_array($ag, array('30s','40s','50s'))){
					$a = 'Adults_'.rtrim($ag,'s').'p';
					$index	= array_search($a, $db_ag_grp);
					}
					else{
					$index	= array_search($ag, $db_ag_grp);
					}

					$fee = 0.00;
					$fee = number_format($db_fee[$index], 2);
					
				$total_fee += ($fee);
			}
			else{
				$total_fee = 0.00;
			}

			$sess_data = array('tour_reg_fee'=>number_format($total_fee, 2), 'reg_tour_id'=>$tour_id);

			$this->session->set_userdata($sess_data);

			echo number_format($total_fee, 2);    // Returns the Total Payable price to the view 
		 }

		 public function add_tourn_match_score($tourn_match_id)
		 {
			$data['tourn_id'] = $tourn_match_id;
			$res = $this->model_league->update_tourn_match_score($data['tourn_id']);
			
			if($res)
			{
				$data['tourn_id']	= $tourn_match_id;
				$data['tourn_det']	= $this->model_league->getonerow($tourn_id);

				$get_bracket_details = $this->model_league->get_bracket_details();
				
				$data['bracket_id'] = $get_bracket_details['BracketID'];
				$data['get_bracket_details'] = $get_bracket_details;
				
				$data['bracket_matches'] = $this->model_league->get_tourn_matches($data);
				$data['get_match_comments'] = $this->model_league->get_match_comments($tourn_id);
				//echo "<pre>";
				//print_r($data['bracket_matches']->result());
				//exit;

				$data['results'] = $this->model_news->get_news();
				$data['tour_details'] = $data['tourn_det'];

				$this->load->view('includes/header');
				$this->load->view('view_tournament',$data);
				$this->load->view('includes/footer');
			}
		 }

		 public function is_team_player($tid){		
			return $this->general->is_team_player($tid);		
		 }		

		 public function is_tourn_reg_player($tid){		
			return $this->general->is_tourn_reg_player($tid);		
		 }		

		 public function check_is_player_paid($player, $tourn_id, $team_id){		
			return $this->general->check_is_player_paid($player, $tourn_id, $team_id);		
		 }

		 public function register_match($tourn_id, $org_id = '')
		{
			$this->session->unset_userdata('json_ag');
			$this->session->unset_userdata('json_formats');
			$this->session->unset_userdata('json_levels');
			$this->session->unset_userdata('json_partners');
			$this->session->unset_userdata('hc_loc_id');
			$this->session->unset_userdata('events');
			$this->session->unset_userdata('tshirt_size');
			$this->session->unset_userdata('coup_code');
			$this->session->unset_userdata('coup_disc');
			$this->session->unset_userdata('occr_json');

			if(!$this->logged_user){
				redirect('login');
			}

			$data['org_url_key'] = "";

			if($org_id){
				$this->load->model('academy_mdl/model_academy');
				$org_details			 = $this->model_academy->get_academy_details($org_id);
				$data['org_details']	 = $org_details;
				$data['org_url_key'] = $org_details['Aca_URL_ShortCode']."/";
				$data['is_academy_league'] = 1;
			}

			//$tourn_id	 = $this->uri->segment(3);

			$details	 = $this->model_league->getonerow($tourn_id);
			$now		 = strtotime("now"); $oneday = 86400;

			if($details->Tournament_type == "Challenge Ladder"){
			$reg_close	 = strtotime($details->EndDate) - $oneday;
			}
			else{
			$reg_close	 = strtotime($details->Registrationsclosedon) + $oneday;
			}

			$reg_open	= strtotime($details->Registrations_Opens_on);

			$tourn_sport	 = $details->SportsType;
			$is_reg = 0;
			
			if($details->tournament_format == 'Teams' or $details->tournament_format == 'TeamSport'){					
				$is_reg = $this->model_league->get_team_reg_tournment($tourn_id);		
			}
			else{					
				$is_reg = $this->model_league->get_reg_tournment($tourn_id);
				if($details->Is_League){
					$reg_occr = $this->model_league->get_user_reg_occrs($tourn_id, $this->logged_user);
					$data['reg_occr'] = $reg_occr;
				}
			}

			$data['tourn_id']	= $tourn_id;

			//if(!in_array($this->logged_user, array(237, 239, 240))){
				if($now < $reg_open){
					echo "<h3>Registration will open on ".
						date('M d, Y H:i', strtotime($details->Registrations_Opens_on))."<h3>"; exit;
				}
			//}


			if($is_reg or $now < $reg_close){

				$user_id	 = $this->logged_user;
				$reg_details = $this->model_league->get_reg_tournment($tourn_id);
				$ag_group    = $this->general->get_user_agegroup();

				if((!empty($reg_details['Tournament_ID']) == $tourn_id) && ((!empty($reg_details['Users_ID']) == $user_id)) or $is_reg)
				{
					$data['reg_status'] = "You were already registered for this tournament. Thankyou.";
					$details				= $this->model_league->getonerow($tourn_id);
					$data['r']			= $details;
					$data['results']	= $this->model_news->get_news();


				if($org_id)
					$this->load->view('academy_views/includes/academy_league_header', $data);
				else
					$this->load->view('includes/header', $data);

					if($details->Is_League)
						$this->load->view('view_lg_register_match', $data);
					else
						$this->load->view('view_register_match', $data);

					$this->load->view('includes/view_right_column',$data);

				if($org_id)
					$this->load->view('academy_views/includes/academy_league_footer');
				else
					$this->load->view('includes/footer');
				}
				else
				{
					$data['new_usatt_opt']    = 0;
					$data['est_usatt_rating']  = '';

					if($this->input->post('btn_proceed')){
					$data['new_usatt_opt']    = 1;
					$data['est_usatt_rating'] = $this->input->post('est_user_usatt');
					}
					$result = $this->general->get_all_users();
					//$data	= array();

					$data['ag_grp']		  = $ag_group['UserAgegroup'];
					$data['user_age_dat'] = $ag_group;

					if(!empty($result)) {
							$returnStr = '[';
						foreach($result as $row){
							$returnStr .= '{';
							$returnStr .= 'label:'.'"'.trim($row->Firstname).' '.trim($row->Lastname).'",';
							$returnStr .= 'value:'.'"'.trim($row->Firstname).' '.trim($row->Lastname).'",';
							$returnStr .= 'value2:'.'"'.$row->Users_ID.'"';
							$returnStr .= '},';
						}
							$returnStr .= ']';
					}

					$data['users'] = $returnStr;

					$details				= $this->model_league->getonerow($tourn_id);
					$check_dob			= $this->model_league->check_user_dob($user_id);
					$check_addr		= $this->model_league->check_user_addr($user_id);
					$data['user_info']	= $check_addr;

					//$data['user_created_teams'] = $this->general->get_user_created_teams();		
					$data['user_created_teams'] = $this->general->get_user_created_sport_teams($tourn_sport);		
					$data['user_existed_teams']  = $this->general->get_user_existed_teams($tourn_id, $tourn_sport);		
					//$data['tour_reg_teams']	= $this->model_league->tour_registered_teams($tourn_id);

				($check_dob->DOB != NULL) ? $data['udob'] = 1 : $data['udob'] = 0;
				
					$data['school_info_req'] = 0;
				$age_array = array('U9','U10','U11','U12','U13','U14','U15','U16','U17','U18');
				if(in_array($check_addr->UserAgegroup, $age_array)){
					$data['school_info_req'] = 1;
				}

				($check_addr->School_Info != NULL and $check_addr->School_Info != "") ? $data['is_school_info'] = 1 : $data['is_school_info'] = 0;

				//($check_addr->Latitude != NULL and $check_addr->Latitude != 0) ? $data['uaddr'] = 1 : $data['uaddr'] = 0;
				(($check_addr->UserAddressline1 != NULL and $check_addr->UserAddressline1 != '') 
					or 
				($check_addr->UserAddressline2 != NULL and $check_addr->UserAddressline2 != '')) ? $data['uaddr'] = 1 : $data['uaddr'] = 0;

				($check_addr->Mobilephone != NULL and $check_addr->Mobilephone != '') ? $data['umob'] = 1 : $data['umob'] = 0;
					
				($check_addr->EmailID != NULL or $check_addr->AlternateEmailID != NULL) ? $data['uemail'] = 1 : $data['uemail'] = 0;

				($check_addr->Gender === 0 or $check_addr->Gender === 1) ? $data['ugender'] = 1 : $data['ugender'] = 0;

					$data['r']		 = $details;
					$data['results'] = $this->model_news->get_news();

				//echo "<pre>"; print_r($data); exit;
				/*$get_reg = $this->model_league->get_reg_partners($tourn_id, $user_id);
				$plyr_partners = array();

				if($get_reg){
					foreach($get_reg as $i => $val){
						$partners = json_decode($val->Partners, TRUE);

						foreach($partners as $ev => $prt){
							if($prt == $user_id)
							$plyr_partners[$ev] = $val->Users_ID;
						}
					}		
				}
				//echo "<pre>"; print_r($plyr_partners); exit;
					$data['being_partner'] = json_encode($plyr_partners);
			*/
				if($org_id)
					$this->load->view('academy_views/includes/academy_league_header', $data);
				else
					$this->load->view('includes/header', $data);

					if($details->Is_League){

							$show_whole_league = 0;
						if($details->lg_Event_Reg_Fee)
							$show_whole_league = 1;


						$lg_occr = $this->model_league->get_league_occr($tourn_id);
						foreach($lg_occr as $ocr){
							$ev_occr[$ocr->Event][] = array($ocr->OCR_ID, $ocr->Game_Date);
						}
						//echo "<pre>"; print_r($ev_occr);
						$data['lg_occr'] = $ev_occr;
						$data['show_wh_league'] = $show_whole_league;

						$this->load->view('view_lg_register_match', $data);
					}
					else{
						$this->load->view('view_register_match', $data);
					}

					$this->load->view('includes/view_right_column',$data);

				if($org_id)
					$this->load->view('academy_views/includes/academy_league_footer');
				else
					$this->load->view('includes/footer');
				}
			}
			else
			{ echo "<h4>Oops Registrations closed!</h4>"; }
		 
		 }

		 public function register_match123($tourn_id, $org_id = '')
		{
			$this->session->unset_userdata('json_ag');
			$this->session->unset_userdata('json_formats');
			$this->session->unset_userdata('json_levels');
			$this->session->unset_userdata('json_partners');
			$this->session->unset_userdata('hc_loc_id');
			$this->session->unset_userdata('events');
			$this->session->unset_userdata('tshirt_size');
			$this->session->unset_userdata('coup_code');
			$this->session->unset_userdata('coup_disc');
			$this->session->unset_userdata('occr_json');

			if(!$this->logged_user){
				redirect('login');
			}

			$data['org_url_key'] = "";

			if($org_id){
				$this->load->model('academy_mdl/model_academy');
				$org_details			 = $this->model_academy->get_academy_details($org_id);
				$data['org_details']	 = $org_details;
				$data['org_url_key'] = $org_details['Aca_URL_ShortCode']."/";
				$data['is_academy_league'] = 1;
			}

			//$tourn_id	 = $this->uri->segment(3);

			$details	 = $this->model_league->getonerow($tourn_id);
			$now		 = strtotime("now"); $oneday = 86400;

			if($details->Tournament_type == "Challenge Ladder"){
			$reg_close	 = strtotime($details->EndDate) - $oneday;
			}
			else{
			$reg_close	 = strtotime($details->Registrationsclosedon) + $oneday;
			}

			$reg_open		 = strtotime($details->Registrations_Opens_on);

			$tourn_sport	 = $details->SportsType;
			$is_reg = 0;
			
			if($details->tournament_format == 'Teams' or $details->tournament_format == 'TeamSport'){					
				$is_reg = $this->model_league->get_team_reg_tournment($tourn_id);		
			}
			else{					
				$is_reg = $this->model_league->get_reg_tournment($tourn_id);
				if($details->Is_League){
					$reg_occr = $this->model_league->get_user_reg_occrs($tourn_id, $this->logged_user);
					$data['reg_occr'] = $reg_occr;
				}
			}

			$data['tourn_id']	= $tourn_id;

			if($now < $reg_open){
				echo "<h3>Registration will open on ".date('m-d-Y H:i', strtotime($details->Registrations_Opens_on))."<h3>"; exit;
			}


			if($is_reg or $now < $reg_close){

				$user_id	 = $this->logged_user;
				$reg_details = $this->model_league->get_reg_tournment($tourn_id);
				$ag_group    = $this->general->get_user_agegroup();

				if((!empty($reg_details['Tournament_ID']) == $tourn_id) && ((!empty($reg_details['Users_ID']) == $user_id)) or $is_reg)
				{
					$data['reg_status'] = "You were already registered for this tournament. Thankyou.";
					$details				= $this->model_league->getonerow($tourn_id);
					$data['r']			= $details;
					$data['results']	= $this->model_news->get_news();


				if($org_id)
					$this->load->view('academy_views/includes/academy_league_header', $data);
				else
					$this->load->view('includes/header', $data);

					if($details->Is_League)
						$this->load->view('view_lg_register_match', $data);
					else
						$this->load->view('view_register_match', $data);

					$this->load->view('includes/view_right_column',$data);

				if($org_id)
					$this->load->view('academy_views/includes/academy_league_footer');
				else
					$this->load->view('includes/footer');
				}
				else
				{
					$result = $this->general->get_all_users();
					//$data	= array();

					$data['ag_grp']		  = $ag_group['UserAgegroup'];
					$data['user_age_dat'] = $ag_group;

					if(!empty($result)) {
							$returnStr = '[';
						foreach($result as $row){
							$returnStr .= '{';
							$returnStr .= 'label:'.'"'.trim($row->Firstname).' '.trim($row->Lastname).'",';
							$returnStr .= 'value:'.'"'.trim($row->Firstname).' '.trim($row->Lastname).'",';
							$returnStr .= 'value2:'.'"'.$row->Users_ID.'"';
							$returnStr .= '},';
						}
							$returnStr .= ']';
					}

					$data['users'] = $returnStr;

					$details			= $this->model_league->getonerow($tourn_id);
					$check_dob			= $this->model_league->check_user_dob($user_id);
					$check_addr			= $this->model_league->check_user_addr($user_id);
					$data['user_info']	= $check_addr;

					//$data['user_created_teams'] = $this->general->get_user_created_teams();		
					$data['user_created_teams'] = $this->general->get_user_created_sport_teams($tourn_sport);		
					$data['user_existed_teams']  = $this->general->get_user_existed_teams($tourn_id, $tourn_sport);		
					//$data['tour_reg_teams']	= $this->model_league->tour_registered_teams($tourn_id);

				($check_dob->DOB != NULL) ? $data['udob'] = 1 : $data['udob'] = 0;
				
					$data['school_info_req'] = 0;
				$age_array = array('U9','U10','U11','U12','U13','U14','U15','U16','U17','U18');
				if(in_array($check_addr->UserAgegroup, $age_array)){
					$data['school_info_req'] = 1;
				}

				($check_addr->School_Info != NULL and $check_addr->School_Info != "") ? $data['is_school_info'] = 1 : $data['is_school_info'] = 0;

				//($check_addr->Latitude != NULL and $check_addr->Latitude != 0) ? $data['uaddr'] = 1 : $data['uaddr'] = 0;
				(($check_addr->UserAddressline1 != NULL and $check_addr->UserAddressline1 != '') 
					or 
				($check_addr->UserAddressline2 != NULL and $check_addr->UserAddressline2 != '')) ? $data['uaddr'] = 1 : $data['uaddr'] = 0;
					
				($check_addr->EmailID != NULL or $check_addr->AlternateEmailID != NULL) ? $data['uemail'] = 1 : $data['uemail'] = 0;

				($check_addr->Gender === 0 or $check_addr->Gender === 1) ? $data['ugender'] = 1 : $data['ugender'] = 0;

					$data['r']		 = $details;
					$data['results'] = $this->model_news->get_news();

				if($org_id)
					$this->load->view('academy_views/includes/academy_league_header', $data);
				else
					$this->load->view('includes/header', $data);

					if($details->Is_League){

							$show_whole_league = 0;
						if($details->lg_Event_Reg_Fee)
							$show_whole_league = 1;


						$lg_occr = $this->model_league->get_league_occr($tourn_id);
						foreach($lg_occr as $ocr){
							$ev_occr[$ocr->Event][] = array($ocr->OCR_ID, $ocr->Game_Date);
						}
						//echo "<pre>"; print_r($ev_occr);
						$data['lg_occr'] = $ev_occr;
						$data['show_wh_league'] = $show_whole_league;

						$this->load->view('view_lg_register_match', $data);
					}
					else{
						$this->load->view('view_register_match', $data);
					}

					$this->load->view('includes/view_right_column',$data);

				if($org_id)
					$this->load->view('academy_views/includes/academy_league_footer');
				else
					$this->load->view('includes/footer');
				}
			}
			else
			{ echo "<h4>Oops Registrations closed!</h4>"; }
		 
		 }

		 public function register($tourn_id)
		 {
			$this->session->unset_userdata('json_ag');
			$this->session->unset_userdata('json_formats');
			$this->session->unset_userdata('json_levels');
			$this->session->unset_userdata('json_partners');
			$this->session->unset_userdata('hc_loc_id');
			$this->session->unset_userdata('events');
			$this->session->unset_userdata('tshirt_size');
			$this->session->unset_userdata('coup_code');
			$this->session->unset_userdata('coup_disc');

			if(!$this->logged_user){
				redirect('login');
			}

			$tourn_id	 = $this->uri->segment(3);
			$details	 = $this->model_league->getonerow($tourn_id);
			$now		 = strtotime("now"); $oneday = 86400;

			if(!$details->Is_Publish and !$this->is_super_admin and $this->logged_user != $details->Usersid and $this->logged_user != $details->Tournament_Director) {
					echo "<h3>Invalid Tournament!</h3>"; exit;
			}

			if($details->Tournament_type == "Challenge Ladder"){
			$reg_close	 = strtotime($details->EndDate) - $oneday;
			}
			else{
			$reg_close	 = strtotime($details->Registrationsclosedon) + $oneday;
			}

			$tourn_sport = $details->SportsType;
			$is_reg = 0;
			
			if($details->tournament_format == 'Teams' or $details->tournament_format == 'TeamSport'){					
				$is_reg = $this->model_league->get_team_reg_tournment($tourn_id);		
			}
			else{					
				$is_reg = $this->model_league->get_reg_tournment($tourn_id);		
			}

			if($is_reg or $now < $reg_close){

				$user_id	 = $this->logged_user;
				$reg_details = $this->model_league->get_reg_tournment($tourn_id);
				$ag_group    = $this->general->get_user_agegroup();

				if((!empty($reg_details['Tournament_ID']) == $tourn_id) && ((!empty($reg_details['Users_ID']) == $user_id)) or $is_reg)
				{
					$data['reg_status'] = "You were already registered for this tournament. Thankyou.";
					$details			= $this->model_league->getonerow($tourn_id);
					$data['r']			= $details;
					$data['results']	= $this->model_news->get_news();

					$this->load->view('includes/header');
					$this->load->view('view_register_match', $data); 
					$this->load->view('includes/view_right_column',$data);
					$this->load->view('includes/footer');
				}
				else
				{
					$result = $this->general->get_all_users();
					$data	= array();

					$data['ag_grp']		  = $ag_group['UserAgegroup'];
					$data['user_age_dat'] = $ag_group;

					if(!empty($result)) {
							$returnStr = '[';
						foreach($result as $row){
							$returnStr .= '{';
							$returnStr .= 'label:'.'"'.trim($row->Firstname).' '.trim($row->Lastname).'",';
							$returnStr .= 'value:'.'"'.trim($row->Firstname).' '.trim($row->Lastname).'",';
							$returnStr .= 'value2:'.'"'.$row->Users_ID.'"';
							$returnStr .= '},';
						}
							$returnStr .= ']';
					}

					$data['users'] = $returnStr;

					$details			= $this->model_league->getonerow($tourn_id);
					$check_dob			= $this->model_league->check_user_dob($user_id);
					$check_addr			= $this->model_league->check_user_addr($user_id);
					$data['user_info']	= $check_addr;

					//$data['user_created_teams'] = $this->general->get_user_created_teams();		
					$data['user_created_teams'] = $this->general->get_user_created_sport_teams($tourn_sport);		
					$data['user_existed_teams'] = $this->general->get_user_existed_teams($tourn_id, $tourn_sport);		
					//$data['tour_reg_teams']	= $this->model_league->tour_registered_teams($tourn_id);

				($check_dob->DOB != NULL) ? $data['udob'] = 1 : $data['udob'] = 0;
				
					$data['school_info_req'] = 0;
				$age_array = array('U9','U10','U11','U12','U13','U14','U15','U16','U17','U18');
				if(in_array($check_addr->UserAgegroup, $age_array)){
					$data['school_info_req'] = 1;
				}

				($check_addr->School_Info != NULL and $check_addr->School_Info != "") ? $data['is_school_info'] = 1 : $data['is_school_info'] = 0;

				//($check_addr->Latitude != NULL and $check_addr->Latitude != 0) ? $data['uaddr'] = 1 : $data['uaddr'] = 0;
				(($check_addr->UserAddressline1 != NULL and $check_addr->UserAddressline1 != '') 
					or 
				($check_addr->UserAddressline2 != NULL and $check_addr->UserAddressline2 != '')) ? $data['uaddr'] = 1 : $data['uaddr'] = 0;
					
				($check_addr->EmailID != NULL or $check_addr->AlternateEmailID != NULL) ? $data['uemail'] = 1 : $data['uemail'] = 0;

					$data['r']		 = $details;
					$data['results'] = $this->model_news->get_news();

					$this->load->view('includes/header');
					$this->load->view('view_register_match', $data); 
					$this->load->view('includes/view_right_column',$data);
					$this->load->view('includes/footer');	
				}
			}
			else
			{ echo "<h4>Oops Registrations closed!</h4>"; }
		 
		 }

		public function uprofile(){

			$this->model_league->update_dob();
			$tour_id = $this->input->post('txt_tid');

			$redirect = $this->input->post('txt_red');

			if($redirect == 'league_view'){
				redirect("league/$tour_id");
			}
			else{
				redirect("league/register_match/$tour_id");
			}
		}
		 

		 public function fixtures($tourn_id)
		 {
		 	if(!$this->session->userdata('user')){ redirect('login'); }

			$tourn_id =  $this->uri->segment(3);
			$user_id = $this->logged_user;
			$res = $this->model_league->getTournRegUsersEvents($tourn_id);
		    $tour_det  = $this->model_league->getonerow($tourn_id);
		    $tourn_det = $this->model_league->get_fixtures_det($tourn_id);

		    if(($user_id != $tour_det->Usersid and $user_id != $tour_det->Tournament_Director) and !$this->is_super_admin){
               echo "Invalid Access!";
               exit();
		    }

			$type = json_decode($tour_det->Singleordouble);
			$match_type = $type[0];
			$sport = $tour_det->SportsType;

			if($tour_det->Gender == 'all' || $tour_det->Gender == 'All'){
			    $tourn_gender = "";
			}else if ($tour_det->Gender == '1') {
				$tourn_gender = 1;
			}else if ($tour_det->Gender == '0') {
			    $tourn_gender = 0;
			}

			if($match_type == 'Singles' and $tour_det->tournament_format == 'Individual'){
				$data['tourn_single_users'] = $this->model_league->tourn_single_users($tourn_id, $match_type, $sport, $tourn_gender);
				$data['tourn_single_users'] = array_map('unserialize', array_unique(array_map('serialize', $data['tourn_single_users'])));
			}
			else if($match_type == 'Doubles' and $tour_det->tournament_format == 'Individual'){
				$data['tourn_double_users'] = $this->model_league->tourn_single_users($tourn_id, $match_type, $sport, $tourn_gender);
				$data['tourn_double_users'] = array_map('unserialize', array_unique(array_map('serialize', $data['tourn_double_users'])));
		    }		
			else if($tour_det->tournament_format == 'Teams' || $tour_det->tournament_format == 'TeamSport'){		
				$data['tourn_reg_teams'] = $this->model_league->tour_registered_teams($tourn_id);	
				$data['tourn_reg_teams'] = array_map('unserialize', array_unique(array_map('serialize', $data['tourn_reg_teams'])));	
		    }

			$events = array();

			if($tour_det->Multi_Events != NULL){
				$multi_events = json_decode($tour_det->Multi_Events);

				foreach ($multi_events as $key => $event) {
				   $arr = explode('-', $event);
				   $ag  = $arr[0];

				   $events[$ag][] = $event;
				}
			}
			else{
			   $events = $this->GetTournamentEvents($tour_det);
			}

		    $data['tourn_id']  = $tourn_id;
		 	$data['tourn_det'] = $tourn_det;
		 	$data['events']    = $events;
			$data['results']   = $this->model_news->get_news();
			$data['types']     = $this->input->post('types');
	//echo "<pre>"; print_r($data); 
			$this->load->view('includes/header');
			$this->load->view('view_fixturestabs',$data);
			$this->load->view('includes/view_right_column',$data);
			$this->load->view('includes/footer');
		}

		 public function fixtures_test($tourn_id)
		  {
			 //$this->session->unset_userdata('draw');

		 	if(!$this->session->userdata('user')){ redirect('login'); }

			$tourn_id =  $this->uri->segment(3);
			$user_id = $this->logged_user;
			$res = $this->model_league->getTournRegUsersEvents($tourn_id);
		    $tour_det  = $this->model_league->getonerow($tourn_id);
		    $tourn_det = $this->model_league->get_fixtures_det($tourn_id);

		    if($user_id != $tour_det->Usersid and !$this->is_super_admin){
               echo "Invalid Access!";
               exit();
		    }

			$type = json_decode($tour_det->Singleordouble);
			$match_type = $type[0];
			$sport = $tour_det->SportsType;

			if($tour_det->Gender == 'all' || $tour_det->Gender == 'All'){
			    $tourn_gender = "";
			}else if ($tour_det->Gender == '1') {
				$tourn_gender = 1;
			}else if ($tour_det->Gender == '0') {
			    $tourn_gender = 0;
			}

			if($match_type == 'Singles' and $tour_det->tournament_format == 'Individual'){
				$data['tourn_single_users'] = $this->model_league->tourn_single_users($tourn_id, $match_type, $sport, $tourn_gender);
				$data['tourn_single_users'] = array_map('unserialize', array_unique(array_map('serialize', $data['tourn_single_users'])));
			}
			else if($match_type == 'Doubles' and $tour_det->tournament_format == 'Individual'){
				$data['tourn_double_users'] = $this->model_league->tourn_single_users($tourn_id, $match_type, $sport, $tourn_gender);
				$data['tourn_double_users'] = array_map('unserialize', array_unique(array_map('serialize', $data['tourn_double_users'])));
		    }		
			else if($tour_det->tournament_format == 'Teams' || $tour_det->tournament_format == 'TeamSport'){		
				$data['tourn_reg_teams'] = $this->model_league->tour_registered_teams($tourn_id);	
				$data['tourn_reg_teams'] = array_map('unserialize', array_unique(array_map('serialize', $data['tourn_reg_teams'])));	
		    }

			$events = array();

			if($tour_det->Multi_Events != NULL){
				$multi_events = json_decode($tour_det->Multi_Events);

				foreach ($multi_events as $key => $event) {
				   $arr = explode('-', $event);
				   $ag  = $arr[0];

				   $events[$ag][] = $event;
				}
			}
			else{
			   $events = $this->GetTournamentEvents($tour_det);
			}

		    $data['tourn_id']  = $tourn_id;
		 	$data['tourn_det'] = $tourn_det;
		 	$data['events']    = $events;
			$data['results']   = $this->model_news->get_news();
			$data['types']     = $this->input->post('types');
	//echo "<pre>"; print_r($data); 
			$this->load->view('includes/header');
			$this->load->view('view_fixturestabs_test',$data);
			$this->load->view('includes/view_right_column',$data);
			$this->load->view('includes/footer');
		}

		/*public function getusers()
		{
		 	$format     = $this->input->post('format');
            $types      = $this->input->post('types');
            $tour_id    = $this->input->post('tour_id');
            $SportsType = $this->input->post('sport');
            $is_event	= $this->input->post('is_event');
            $is_checkin	= $this->input->post('is_checkin');

			if($is_event){
            $users = $this->get_reg_tourn_event_players($tour_id, $types, $SportsType, $is_checkin);
			}
			else{
            $users = $this->get_reg_tourn_players($tour_id, $SportsType);
			}
            foreach ($types as $key => $value) {
                foreach ($users as $user_id => $level) {
            	    if(in_array($value, $level)){
                     $users_id[] = $user_id;
            	    }
                }   
            }

            $users_id = array_unique($users_id);

            $usersdropdown='';
            foreach ($users_id as $key => $value) {
            	if (strpos($value, '-') !== false) {
                    $userArr=explode('-', $value);
                    $user=$this->model_league->get_user_name($userArr[0]);
                    $user_a2msocre = $this->get_a2mscore($userArr[0], $SportsType);
                    $user_score = $user_a2msocre['A2MScore']; 
                    $username=$user['Firstname'].' '.$user['Lastname'];
          	        $userid=$user['Users_ID'];
                    $opp=$this->model_league->get_user_name($userArr[1]);
                    $opp_name=$opp['Firstname'].' '.$opp['Lastname'];
                    $opp_id=$opp['Users_ID'];
                    $opp_a2msocre = $this->get_a2mscore($userArr[1], $SportsType);
                    $opp_score = $opp_a2msocre['A2MScore'];
                    $usersdropdown.='<option id='.$user_score.' value='.$userid.'-'.$opp_id.'>'.$username.' ('.$user_score.') - '.$opp_name.' ('.$opp_score.')'.'</option>';
                    
            	 }
				 else{
            	 	$user=$this->model_league->get_user_name($value);
                    $username=$user['Firstname'].' '.$user['Lastname'];
          	        $userid=$user['Users_ID'];
          	        $user_a2msocre = $this->get_a2mscore($value, $SportsType);
                    $user_score = $user_a2msocre['A2MScore']; 
            	 	$usersdropdown.='<option id='.$user_score.' value='.$userid.'>'.$username.' ('.$user_score.')</option>';
            	 }
            }
            echo $usersdropdown;exit();
		}*/

		public function getusers()
		{
		 	//print_r($_POST);exit();
		 	$format     = $this->input->post('format');
            $types      = $this->input->post('types');
            $tour_id    = $this->input->post('tour_id');
            $SportsType = $this->input->post('sport');
            $is_event	= $this->input->post('is_event');
            $is_checkin	= $this->input->post('is_checkin');

			$draw_type	= '';
			if($this->input->post('draw_type'))
            $draw_type	= $this->input->post('draw_type');


			if($is_event){
            $users = $this->get_reg_tourn_event_players($tour_id, $types, $SportsType, $is_checkin);
			}
			else{
            $users = $this->get_reg_tourn_players($tour_id, $SportsType, $is_checkin);
			}
           //echo "<pre>";print_r($users);exit();
            foreach ($types as $key => $value) {
                foreach ($users as $user_id => $level) {
            	    if(in_array($value, $level)){
                     $users_id[] = $user_id;
            	    }
                }   
            }
            $users_id=array_unique($users_id);
           //echo "<pre>";print_r($users_id);exit();

            $usersdropdown  = '';
			$add_col		= "";
			if($SportsType == 2){
			$add_col = "<th class='score-position'>Rating</th>";
			}

			$output = "<table id='reg_users_table' class='table tab-score'>
						<thead>
						<tr class='top-scrore-table' style='background-color:#f68b1c'>
						<th class='score-position'>Select <input type='checkbox' name='userSelectAll' id='userSelectAll' value='1' /></th>
						<th class='score-position'>Player/Team</th>
						<th class='score-position'>City</th>
						<th class='score-position'>State</th>
						<th class='score-position'>A2MScore</th>
						{$add_col}
						<th class='score-position'>Seed</th>
						</tr>
						</thead>";
			$output .= "<tbody>";
//echo "<pre>"; print_r($users_id);

			// Keep the Seedings of Draw page when user comeback
			
			$temp_arr = array();
			if($this->session->userdata('draw')['users']){
				$sess_draws_users = $this->session->userdata('draw')['users'];
				foreach ($users_id as $k => $value) {

					$xyz = explode('-', $value);
					if(!$xyz[1])
						$value = trim($value,'-'); // removing - if the value is no having partner but having - in the string

					$key = array_search ($value, $sess_draws_users);
					if($key > -1)
						$temp_arr[$key] = $value;
					else
						$temp_arr[$k]		= $value;
				}
				$x = ksort($temp_arr);
				$users_id = $temp_arr;
			}

			// Keep the Seedings of Draw page when user comeback

            foreach ($users_id as $key => $value) {
				$avg_a2m = '';
            	if (strpos($value, '-') !== false) {
                    $userArr		= explode('-', $value);

                    $user			= $this->model_league->get_user_name($userArr[0]);
                    $user_a2msocre  = $this->get_a2mscore($userArr[0], $SportsType);

                    $opp			= $this->model_league->get_user_name($userArr[1]);
                    $opp_a2msocre	= $this->get_a2mscore($userArr[1], $SportsType);

					$users_list[$value]['UID']			=  $user['Users_ID'];
					$users_list[$value]['Name']		=  $user['Firstname'].' '.$user['Lastname'];
					$users_list[$value]['City']			=  $user['City'];
					$users_list[$value]['State']			=  $user['State'];
	
					if($draw_type != ''){
						if($draw_type == 'doubles')
							$users_list[$value]['A2MScore']		= $user_a2msocre['A2MScore_Doubles'];
						else if($draw_type == 'mixed')
							$users_list[$value]['A2MScore']		= $user_a2msocre['A2MScore_Mixed'];
						else
							$users_list[$value]['A2MScore']		=  $user_a2msocre['A2MScore'];
					}
					else{
						if($format == 'Doubles')
						$users_list[$value]['A2MScore']		= $user_a2msocre['A2MScore_Doubles'];
						else if($format == 'Mixed')
						$users_list[$value]['A2MScore']		= $user_a2msocre['A2MScore_Mixed'];
						else
						$users_list[$value]['A2MScore']		=  $user_a2msocre['A2MScore'];
					}

					$users_list[$value]['PUID']	  	    =  $opp['Users_ID'];
					$users_list[$value]['PartnerName']	=  $opp['Firstname'].' '.$opp['Lastname'];
					$users_list[$value]['PCity']		=  $opp['City'];
					$users_list[$value]['PState']		=  $opp['State'];

					if($format == 'Doubles')
					$users_list[$value]['PA2MScore']	  = $opp_a2msocre['A2MScore_Doubles'];
					else if($format == 'Mixed')
                    $users_list[$value]['PA2MScore']	  = $opp_a2msocre['A2MScore_Mixed'];
					else
					$users_list[$value]['PA2MScore']    = $opp_a2msocre['A2MScore'];
					
					if($users_list[$value]['A2MScore'] and $users_list[$value]['PA2MScore'])
						$avg_a2m = ($users_list[$value]['A2MScore'] + $users_list[$value]['PA2MScore']) / 2;
					else if($users_list[$value]['A2MScore'])
						$avg_a2m = $users_list[$value]['A2MScore'];
					else if($users_list[$value]['PA2MScore'])
						$avg_a2m = $users_list[$value]['PA2MScore'];

					$users_list[$value]['A2M_AVG'] = $avg_a2m;
            	 }
				 else{
            	 	$user		= $this->model_league->get_user_name($value);
                    $username	= $user['Firstname'].' '.$user['Lastname'];
          	        $userid		= $user['Users_ID'];
          	        $user_a2msocre  = $this->get_a2mscore($value, $SportsType);

					if($draw_type != ''){
						if($draw_type == 'doubles')
							$user_score		= $user_a2msocre['A2MScore_Doubles'];
						else if($draw_type == 'mixed')
							$user_score		= $user_a2msocre['A2MScore_Mixed'];
						else
							$user_score		=  $user_a2msocre['A2MScore'];
					}
					else{
						if($format == 'Doubles')
						$user_score		= $user_a2msocre['A2MScore_Doubles'];
						else if($format == 'Mixed')
						$user_score		= $user_a2msocre['A2MScore_Mixed'];
						else
						$user_score		= $user_a2msocre['A2MScore'];
					}
					$rating		 = "N/A";
					if($SportsType == 2){
						$user_membership = $this->get_user_mem_details($user['Users_ID'], $SportsType);
						if($user_membership['Membership_ID']){
						$user_rating = $this->get_user_usatt_rating1($user_membership['Membership_ID']);
						$rating		 = $user_rating['Rating'];
						}
					}


					$users_list[$value]['UID']		=  $user['Users_ID'];
					$users_list[$value]['Name']	=  $user['Firstname'].' '.$user['Lastname'];
					$users_list[$value]['City']		=  $user['City'];
					$users_list[$value]['State']		=  $user['State'];
					$users_list[$value]['A2MScore'] =  $user_score;
					$users_list[$value]['A2M_AVG'] =  $user_score;
					
					if($SportsType == 2)
					$users_list[$value]['Rating'] = $rating;

            	 }
          	   // $userslist[]=$this->model_league->get_user_name($value);
            }

			/////////////usort($users_list, "cmp_a2m");
			
			if(!$this->session->userdata('draw')['users']){
				array_multisort(array_map(function($element){ return $element['A2MScore']; }, $users_list), SORT_DESC, $users_list);
			}
			// commented this to make session sort work

            //echo "<pre>";print_r($users_list);exit();
			$j = 1;
			foreach($users_list as $user => $details){
			
			  /* $seeding = "<select class='form-control' name='sel_groups[$value][]' id='sel_groups' style='width:100%'>";
						for($i = 1; $i <= count($users_list); $i++){
							$sel = "";
							if($j == $i) { $sel = "selected"; }
						 $seeding .= "<option value='$i' $sel>$i</option>";
						}
			   $seeding .= "</select>";*/
				
			   $uid = $details['UID'];
			   if($details['PUID'])
				 $uid .= "-".$details['PUID'];

			   $seeding = "<input type='checkbox' class='user_select' name='users[]' id='seeded_".$uid."' value='".$uid."' checked />";

			   $player = "";
			   $player .= $details['Name'];
			   if($details['PartnerName'] != ""){
			   $player .= "; ".$details['PartnerName'];
			   }

				$new_col = "";
			   if($SportsType == 2){
				$new_col = "<td>&nbsp;".$details['Rating']."</td>";
			   }

			   $output .= "<tr>
						<td align='center'>".$seeding." <input type='hidden' id='seeded_".$uid."' value='".$uid."' ></td>
						<td>&nbsp;".$player."</td>
						<td>&nbsp;".$details['City']."</td>
						<td>&nbsp;".$details['State']."</td>
						<td>&nbsp;".$details['A2M_AVG']."</td>
						{$new_col}
						<td><input type='hidden' id='seeded_".$uid."' value='".$uid."' >
						<img src='".base_url().'icons/up.png'."' class='up' style='cursor:pointer;width:20px;height:20px;' />
						<img src='".base_url().'icons/down.png'."' class='down' style='cursor:pointer;width:20px;height:20px;' />
						</td>
						</tr>";
				$j++;
			}

		    $output .= "</tbody>";
		    $output .= "</table>";

            echo $output;
			exit();
		}


		public function getusers_occr()
		{
		 	//print_r($_POST);exit();
		 	$format				= $this->input->post('format');
            $types				= $this->input->post('types');
            $sel_occr_ids  = $this->input->post('sel_occr_ids');
            $tour_id			= $this->input->post('tour_id');
            $SportsType = $this->input->post('sport');
            $is_event		= $this->input->post('is_event');
            $is_checkin	= $this->input->post('is_checkin');

			$draw_type	= '';
			if($this->input->post('draw_type'))
            $draw_type	= $this->input->post('draw_type');

			if($is_event){
            $users = $this->get_reg_tourn_event_occr_players($tour_id, $types, $sel_occr_ids, $SportsType, $is_checkin);
			}
			else{
            $users = $this->get_reg_tourn_players($tour_id, $SportsType, $is_checkin);
			}
           //echo "<pre>";print_r($users);exit();
            foreach ($types as $key => $value) {
                foreach ($users as $user_id => $level) {
            	    if(in_array($value, $level)){
                     $users_id[] = $user_id;
            	    }
                }   
            }
            $users_id=array_unique($users_id);
           //echo "<pre>";print_r($users_id);exit();

            $usersdropdown  = '';
			$add_col		= "";
			if($SportsType == 2){
			$add_col = "<th class='score-position'>Rating</th>";
			}

			$output = "<table id='reg_users_table' class='table tab-score'>
						<thead>
						<tr class='top-scrore-table' style='background-color:#f68b1c'>
						<th class='score-position'>Select <input type='checkbox' name='userSelectAll' id='userSelectAll' value='1' /></th>
						<th class='score-position'>Player/Team</th>
						<th class='score-position'>City</th>
						<th class='score-position'>State</th>
						<th class='score-position'>A2MScore</th>
						{$add_col}
						<th class='score-position'>Seed</th>
						</tr>
						</thead>";
			$output .= "<tbody>";

			// Keep the Seedings of Draw page when user comeback
			
			$temp_arr = array();
			if($this->session->userdata('draw')['users']){
				$sess_draws_users = $this->session->userdata('draw')['users'];
				foreach ($users_id as $k => $value) {
					$xyz = explode('-', $value);
					if(!$xyz[1])
						$value = trim($value,'-'); // removing - if the value is no having partner but having - in the string

					$key = array_search($value, $sess_draws_users);
					if($key > -1)
						$temp_arr[$key] = $value;
					else
						$temp_arr[$k]		= $value;
				}
				$x = ksort($temp_arr);
				$users_id = $temp_arr;
			}

			// Keep the Seedings of Draw page when user comeback


            foreach ($users_id as $key => $value) {
				$avg_a2m = '';
				$userArr = explode('-', $value);

            	if (strpos($value, '-') !== false and $userArr[1]) {
					$value = $userArr[0];
                    $user			= $this->model_league->get_user_name($userArr[0]);
                    $user_a2msocre  = $this->get_a2mscore($userArr[0], $SportsType);

                    $opp			= $this->model_league->get_user_name($userArr[1]);
                    $opp_a2msocre	= $this->get_a2mscore($userArr[1], $SportsType);

					$users_list[$value]['UID']			=  $user['Users_ID'];
					$users_list[$value]['Name']		=  $user['Firstname'].' '.$user['Lastname'];
					$users_list[$value]['City']		=  $user['City'];
					$users_list[$value]['State']		=  $user['State'];
					
					if($draw_type != ''){
						if($draw_type == 'doubles')
							$users_list[$value]['A2MScore']		= $user_a2msocre['A2MScore_Doubles'];
						else if($draw_type == 'mixed')
							$users_list[$value]['A2MScore']		= $user_a2msocre['A2MScore_Mixed'];
						else
							$users_list[$value]['A2MScore']		=  $user_a2msocre['A2MScore'];
					}
					else{
						if($format == 'Doubles')
							$users_list[$value]['A2MScore']		= $user_a2msocre['A2MScore_Doubles'];
						else if($format == 'Mixed')
							$users_list[$value]['A2MScore']		= $user_a2msocre['A2MScore_Mixed'];
						else
							$users_list[$value]['A2MScore']		=  $user_a2msocre['A2MScore'];
					}
					
					$users_list[$value]['PUID']	  	    =  $opp['Users_ID'];
					$users_list[$value]['PartnerName']	=  $opp['Firstname'].' '.$opp['Lastname'];
					$users_list[$value]['PCity']		=  $opp['City'];
					$users_list[$value]['PState']		=  $opp['State'];

					if($format == 'Doubles')
						$users_list[$value]['PA2MScore']	  = $opp_a2msocre['A2MScore_Doubles'];
					else if($format == 'Mixed')
						$users_list[$value]['PA2MScore']	  = $opp_a2msocre['A2MScore_Mixed'];
					else
						$users_list[$value]['PA2MScore']  = $opp_a2msocre['A2MScore'];
	
			if($SportsType != 7)
				$max_score	 = max($user_a2msocre['A2MScore'], $user_a2msocre['A2MScore_Doubles'], $user_a2msocre['A2MScore_Mixed']);
			else
				$max_score	 = number_format(max($user_a2msocre['A2MScore'], $user_a2msocre['A2MScore_Doubles'], $user_a2msocre['A2MScore_Mixed']), 3);


					if($users_list[$value]['A2MScore'] and $users_list[$value]['PA2MScore'])
						$avg_a2m = ($users_list[$value]['A2MScore'] + $users_list[$value]['PA2MScore']) / 2;
					else if($users_list[$value]['A2MScore'])
						$avg_a2m = $users_list[$value]['A2MScore'];
					else if($users_list[$value]['PA2MScore'])
						$avg_a2m = $users_list[$value]['PA2MScore'];

					$users_list[$value]['A2M_AVG'] = $avg_a2m;
					$users_list[$value]['A2M_MAX'] = $max_score;
            	 }
				 else{
					$value = $userArr[0];					 
            	 	$user		= $this->model_league->get_user_name($value);
                    $username	= $user['Firstname'].' '.$user['Lastname'];
          	        $userid		= $user['Users_ID'];
          	        $user_a2msocre  = $this->get_a2mscore($value, $SportsType);
					if($format == 'Doubles')
						$user_score		= $user_a2msocre['A2MScore_Doubles'];
					else if($format == 'Mixed')
						$user_score		= $user_a2msocre['A2MScore_Mixed'];
					else
						$user_score		= $user_a2msocre['A2MScore'];

					$rating		 = "N/A";
					if($SportsType == 2){
						$user_membership = $this->get_user_mem_details($user['Users_ID'], $SportsType);
						if($user_membership['Membership_ID']){
						$user_rating = $this->get_user_usatt_rating1($user_membership['Membership_ID']);
						$rating		 = $user_rating['Rating'];
						}
					}

		if($SportsType != 7)
			$max_score	 = max($user_a2msocre['A2MScore'], $user_a2msocre['A2MScore_Doubles'], $user_a2msocre['A2MScore_Mixed']);
		else
			$max_score	 = number_format(max($user_a2msocre['A2MScore'], $user_a2msocre['A2MScore_Doubles'], $user_a2msocre['A2MScore_Mixed']), 3);

					if($draw_type != ''){
						if($draw_type == 'doubles')
						$new_a2m		= $user_a2msocre['A2MScore_Doubles'];
						else if($draw_type == 'mixed')
						$new_a2m		= $user_a2msocre['A2MScore_Mixed'];
						else
						$new_a2m		=  $user_a2msocre['A2MScore'];

						if($SportsType != 7)
							$max_score	 = $new_a2m;
						else
							$max_score	 = number_format($new_a2m, 3);
					}

					$users_list[$value]['UID']		=  $user['Users_ID'];
					$users_list[$value]['Name']	=  $user['Firstname'].' '.$user['Lastname'];
					$users_list[$value]['City']		=  $user['City'];
					$users_list[$value]['State']		=  $user['State'];
					$users_list[$value]['A2MScore'] =  $user_score;
					$users_list[$value]['A2M_AVG'] =  $user_score;
					$users_list[$value]['A2M_MAX'] =  $max_score;
					
					if($SportsType == 2)
					$users_list[$value]['Rating'] = $rating;

            	 }
          	   // $userslist[]=$this->model_league->get_user_name($value);
            }

			//usort($users_list, "cmp_a2m");
			if(!$this->session->userdata('draw')['users']){
				array_multisort(array_map(function($element) { 
					return $element['A2M_MAX']; }, $users_list), SORT_DESC, $users_list);
			}

            //echo "<pre>";print_r($users_list);exit();
			$j = 1;
			foreach($users_list as $user => $details){
			
			  /* $seeding = "<select class='form-control' name='sel_groups[$value][]' id='sel_groups' style='width:100%'>";
						for($i = 1; $i <= count($users_list); $i++){
							$sel = "";
							if($j == $i) { $sel = "selected"; }
						 $seeding .= "<option value='$i' $sel>$i</option>";
						}
			   $seeding .= "</select>";*/
				
			   $uid = $details['UID'];
			   if($details['PUID'])
				 $uid .= "-".$details['PUID'];

			   $seeding = "<input type='checkbox' class='user_select' name='users[]' id='seeded_".$uid."' value='".$uid."' checked />";

			   $player = "";
			   $player .= $details['Name'];
			   if($details['PartnerName'] != ""){
			   $player .= "; ".$details['PartnerName'];
			   }

				$new_col = "";
			   if($SportsType == 2){
				$new_col = "<td>&nbsp;".$details['Rating']."</td>";
			   }

			   $output .= "<tr>
						<td align='center'>".$seeding." <input type='hidden' id='seeded_".$uid."' value='".$uid."' ></td>
						<td>&nbsp;".$player."</td>
						<td>&nbsp;".$details['City']."</td>
						<td>&nbsp;".$details['State']."</td>
						<td>&nbsp;".$details['A2M_MAX']."</td>
						{$new_col}
						<td> <input type='hidden' id='seeded_".$uid."' value='".$uid."' >
						<img src='".base_url().'icons/up.png'."' class='up' style='cursor:pointer;width:20px;height:20px;' />
						<img src='".base_url().'icons/down.png'."' class='down' style='cursor:pointer;width:20px;height:20px;' />
						</td>
						</tr>";
				$j++;
			}

		    $output .= "</tbody>";
		    $output .= "</table>";

            echo $output;
			exit();
		}


		 public function age_group_users($tourn_id = '', $age_group = '', $match_type = '',$gender= '',$sport = '',$level = '')
		 {
			// echo "<pre>"; print_r($_POST); exit;
		     $age_group  = $this->input->post('age_group');
		   	 $match_type = $this->input->post('match_type');
			 $tourn_id	 = $this->input->post('tourn_id');
			 $gender	 = $this->input->post('gender');
			 $sport		 = $this->input->post('sport');
			 $level		 = $this->input->post('level');
			 $tformat	 = $this->input->post('tformat');
		 
			 //if($match_type != "" or $match_type == ""){
					//$data['tourn_age_group_users'] = "";
					$data['tourn_id'] = $tourn_id;
					$data['age_group'] = $age_group;
					$data['match_type'] = $match_type;
					$data['gender'] = $gender;
					$data['sport'] = $sport;
					$data['level'] = $level;

					if(($match_type == 'Singles' or $match_type == '') and $tformat != 'Teams'){
						$data['tourn_age_group_users']	  = $this->model_league->get_reg_tourn_age_usernames($data);
					}
					else if($match_type == 'Doubles' or $match_type == 'Mixed'){
						$data['tourn_double_group_users'] = $this->model_league->get_reg_tourn_age_usernames($data);
				    }
					else if($tformat == 'Teams'){
						$data['tourn_reg_teams'] = $this->model_league->get_tourn_reg_teams($data);
					}

					$data['sport'] = $sport;
					$this->load->view('view_agegroup_users' ,$data);
			//}
		 }

		public function reg_teams($tourn_id)
		{
			$details = $this->model_league->getonerow($tourn_id);

			if(!$this->input->post('bulk_register')){
				$data['tourn_id'] = $tourn_id;

				if($details->Usersid == $this->session->userdata('users_id') or $details->Tournament_Director == $this->session->userdata('users_id')){
					$data['r']		 = $details;
					$data['results'] = $this->model_news->get_news();

						$this->load->view('includes/header');

					if($details->Tournament_type == 'Flexible League')
					{ $this->load->view('view_reg_teams', $data); }
					else
					{ $this->load->view('view_reg_teams', $data); }

						$this->load->view('includes/footer');
				}
				else{
					echo "<h4>Unauthorized Access!</h4>";
				}
			}
			else{
				/*echo "<pre>";
				print_r($_POST);
				exit;*/
				if($details->Tournament_type == 'Flexible League')
					//$details = $this->model_play->bulk_reg_players_flex();
					$details = $this->model_league->bulk_reg_teams();
				else
					$details = $this->model_league->bulk_reg_teams();

				redirect("league/$tourn_id");
				//print_r($_POST);
			}
		}

		 public function get_reg_team_participants($tourn_id)
		 {
			//return $this->model_league->get_reg_team_tourn_participants($tourn_id);
			return $this->model_league->get_reg_tourn_participants($tourn_id);
		 }

		  public function get_reg_tourn_players($tourn_id, $sport = '')
		 {
			$res = $this->model_league->get_reg_tourn_participants($tourn_id, $sport);
		 // return $res;exit();
				$reg_users = array();
				$dbl_partner_arr = array();
                $mx_partner_arr = array();
                $dbl_arr = array();
                $mx_arr = array();

		   foreach($res as $r){
				$formats    = json_decode($r->Match_Type);
				$ag_group   = json_decode($r->Reg_Age_Group);
				$sp_levels  = json_decode($r->Reg_Sport_Level);

				foreach($formats as $i => $fr){
					foreach($ag_group[$i] as $j => $ag){
						foreach($sp_levels[$i][$j] as $lv){
						    if($fr == 'Singles'){
                                $usersid = $r->Users_ID;
                                $player=$this->general->get_user($r->Users_ID);

                                $gender_key = $player['Gender'];

                               $reg_users[$usersid][] = $ag."-".$gender_key."-".$fr."-".$lv;
							}
							if($fr == 'Doubles'){
								$player = $this->general->get_user($r->Users_ID);

                                	$gender_key = $player['Gender']; 
									
								if($r->Partner1!=NULL || $r->Partner1!=""){
                                    $dbl_partner_arr[] = $r->Partner1;
							        if(!in_array($r->Users_ID, $dbl_partner_arr)){
							           $usersid = $r->Users_ID.'-'.$r->Partner1;
							           
							           $reg_users[$usersid][] = $ag."-".$gender_key."-".$fr."-".$lv;
							        }
								}else{

								   $usersid = $r->Users_ID;

								   $reg_users[$usersid][] = $ag."-".$gender_key."-".$fr."-".$lv;
								}
								
							}
							if($fr == 'Mixed'){
								$gender_key = 2; 
								if($r->Partner2!=NULL || $r->Partner2!=""){
                                   	$mx_partner_arr[] = $r->Partner2;
							        if(!in_array($r->Users_ID, $mx_partner_arr)){
							           $usersid = $r->Users_ID.'-'.$r->Partner2;
							           $reg_users[$usersid][] = $ag."-".$gender_key."-".$fr."-".$lv;
							        }
								}else{
								   $usersid = $r->Users_ID;
								   $reg_users[$usersid][] = $ag."-".$gender_key."-".$fr."-".$lv;
								}
							}
							//$reg_users[$usersid][] = $fr."-".$ag."-".$lv;
						}
					}
				}
			}
			return $reg_users;
		 }

		 public function get_reg_tourn_event_players($tourn_id, $types, $sport='', $is_checkin=''){

			$res = $this->model_league->get_reg_tourn_event_players($tourn_id, $types, $sport, $is_checkin);
			$reg_users = array();
			$single_user_array    = array();
			$double_partner_array = array();
			$comb_partner_array = array();
			$mixed_partner_array  = array();

			   foreach($res as $r){
					$usersid = $r->Users_ID;
					$user_reg_events   = json_decode($r->Reg_Events, true);
					$user_sel_partners = json_decode($r->Partners, true);


					if(!empty($user_reg_events)){
						foreach($user_reg_events as $event){

							if (stripos(strtolower($event), 'Singles') !== false) {
								if($r->Users_ID){ //and !in_array($r->Users_ID, $single_user_array)){
								$user_id = $r->Users_ID;
								$reg_users[$user_id][] = $event;
								$single_user_array[] = $r->Users_ID;
								}
							}

							if (stripos(strtolower($event), 'Doubles') !== false and stripos(strtolower($event), 'Adults') === true) {
								if(!in_array($r->Users_ID, $double_partner_array[$event]) and (!in_array($user_sel_partners[$event], $double_partner_array[$event]) or $user_sel_partners[$event] == "")){
									//if($user_sel_partners[$event]){
										$dbl_partner = $r->Users_ID.'-'.$user_sel_partners[$event];
										$reg_users[$dbl_partner][] = $event;

										$double_partner_array[$event][] = $r->Users_ID;
										$double_partner_array[$event][] = $user_sel_partners[$event];
									//}
								}
							}

							if (stripos(strtolower($event), 'Doubles') !== false and stripos(strtolower($event), 'Adults') !== true) {
								if(!in_array($r->Users_ID, $comb_partner_array[$event]) and (!in_array($user_sel_partners[$event], $comb_partner_array[$event]) or $user_sel_partners[$event] == "")){
									//if($user_sel_partners[$event]){
										$dbl_partner = $r->Users_ID.'-'.$user_sel_partners[$event];
										$reg_users[$dbl_partner][] = $event;

										$comb_partner_array[$event][] = $r->Users_ID;
										$comb_partner_array[$event][] = $user_sel_partners[$event];
									//}
								}
							}

							if (stripos(strtolower($event), 'Mixed') !== false) {
								if(!in_array($r->Users_ID, $mixed_partner_array[$event]) and (!in_array($user_sel_partners[$event], $mixed_partner_array[$event]) or $user_sel_partners[$event] == "")){
									//if($user_sel_partners[$event]){
								$mx_partner = $r->Users_ID.'-'.$user_sel_partners[$event];
								$reg_users[$mx_partner][] = $event;

								$mixed_partner_array[$event][] = $r->Users_ID;
								$mixed_partner_array[$event][] = $user_sel_partners[$event];
									//}
								}
							}
							//echo "<pre>";print_r($double_partner_array);
						}
					}
				}
			//echo "<pre>"; print_r($reg_users);
			return $reg_users;
		 }

		 public function get_reg_tourn_event_occr_players($tourn_id, $types, $sel_occr_ids, $sport='', $is_checkin='') {

			$res = $this->model_league->get_reg_tourn_event_occr_players($tourn_id, $types, $sel_occr_ids, $sport, $is_checkin);
			$reg_users = array();
			$single_user_array    = array();
			$double_partner_array = array();
			$comb_partner_array = array();
			$mixed_partner_array  = array();

			   foreach($res as $r){
					$usersid = $r->Users_ID;
					$user_reg_events   = json_decode($r->Reg_Events, true);
					$user_sel_partners = json_decode($r->Partners, true);


					if(!empty($user_reg_events)){
						foreach($user_reg_events as $event){

							if (stripos(strtolower($event), 'Singles') !== false) {
								if($r->Users_ID){ //and !in_array($r->Users_ID, $single_user_array)){
								$user_id = $r->Users_ID;
								$reg_users[$user_id][] = $event;
								$single_user_array[] = $r->Users_ID;
								}
							}

							if (stripos(strtolower($event), 'Doubles') !== false and stripos(strtolower($event), 'Adults') === true) {
								if(!in_array($r->Users_ID, $double_partner_array[$event]) and (!in_array($user_sel_partners[$event], $double_partner_array[$event]) or $user_sel_partners[$event] == "")){
									//if($user_sel_partners[$event]){
										$dbl_partner = $r->Users_ID.'-'.$user_sel_partners[$event];
										$reg_users[$dbl_partner][] = $event;

										$double_partner_array[$event][] = $r->Users_ID;
										$double_partner_array[$event][] = $user_sel_partners[$event];
									//}
								}
							}

							if (stripos(strtolower($event), 'Doubles') !== false and stripos(strtolower($event), 'Adults') !== true) {
								if(!in_array($r->Users_ID, $comb_partner_array[$event]) and (!in_array($user_sel_partners[$event], $comb_partner_array[$event]) or $user_sel_partners[$event] == "")){
									//if($user_sel_partners[$event]){
										$dbl_partner = $r->Users_ID.'-'.$user_sel_partners[$event];
										$reg_users[$dbl_partner][] = $event;

										$comb_partner_array[$event][] = $r->Users_ID;
										$comb_partner_array[$event][] = $user_sel_partners[$event];
									//}
								}
							}

							if (stripos(strtolower($event), 'Mixed') !== false) {
								if(!in_array($r->Users_ID, $mixed_partner_array[$event]) and (!in_array($user_sel_partners[$event], $mixed_partner_array[$event]) or $user_sel_partners[$event] == "")){
									//if($user_sel_partners[$event]){
								$mx_partner = $r->Users_ID.'-'.$user_sel_partners[$event];
								$reg_users[$mx_partner][] = $event;

								$mixed_partner_array[$event][] = $r->Users_ID;
								$mixed_partner_array[$event][] = $user_sel_partners[$event];
									//}
								}
							}
							//echo "<pre>";print_r($double_partner_array);
						}
					}
				}
			//echo "<pre>"; print_r($reg_users);
			return $reg_users;
		 }

		 public function get_reg_tourn_participants($tourn_id)
		 {
			$res = $this->model_league->get_reg_tourn_participants($tourn_id);
			
				$reg_users = array();
				$user_tsize = array();

		   foreach($res as $r){
				$formats    = json_decode($r->Match_Type);
				$ag_group  = json_decode($r->Reg_Age_Group);
				$sp_levels = json_decode($r->Reg_Sport_Level);
				
				if($formats and $ag_group and $sp_levels){
				foreach($formats as $i => $fr){
					foreach($ag_group[$i] as $j => $ag){
						foreach($sp_levels[$i][$j] as $lv){
							$reg_users[$r->Users_ID][] = $fr."-".$ag."-".$lv;
						}
					}
				}
				}
				else{
							$reg_users[$r->Users_ID][] = '';
				}

				$user_tsize[$r->Users_ID] = $r->TShirt_Size;
			}

			$res = array($reg_users, $user_tsize);
			return $res;
		 }

		 public function registered_players()
		 {
		     $tourn_id = $this->input->post('tourn_id');
			 $match_type = $this->input->post('mtype');
			 $age_type = $this->input->post('age');
			 $tourn_level = $this->input->post('level');
			
			 //if($age_type != ""){
					$data['tourn_reg_names'] = "";
					$data['tourn_id'] = $tourn_id;
					$data['age_group'] = $age_type;
					$data['match_type'] = $match_type;
					$data['level'] = $tourn_level;

					$data['tourn_reg_names'] = $this->model_league->registered_players($data);

					$this->load->view('view_reg_tourn_names',$data);
			 //}
		 }

		 public function participants()
		 {
		     $tourn_id = $this->input->post('tourn_id');
			 $match_type = $this->input->post('mtype');
			 $age_type = $this->input->post('age');
			 $level = $this->input->post('level');
			 $sport_id = $this->input->post('sport_id');
			
			 if($age_type != ""){
					$data['tourn_participants'] = "";
					$data['tourn_id'] = $tourn_id;
					$data['match_type'] = $match_type;
					$data['age_type'] = $age_type;
					$data['level'] = $level;

					$data['tourn_participants'] = $this->model_league->participants($data);
					
					$data['sport_id'] = $sport_id;
					$this->load->view('view_tourn_participants',$data);
			}
		 }
	
		public function bracket($tourn_id)
		{
		//echo "<pre>"; print_r($_POST); exit;
		$data['courts_new']			= "";
		$data['match_timings']		= "";

		$data['br_game_day']		= $this->input->post('br_game_day');
		$data['draw_format']			= $this->input->post('draw_format');
		$data['is_publish_draw']	= $this->input->post('is_publish_draw');
		$data['num_of_sets']		= $this->input->post('num_of_sets');

		$data['is_plof']			= $this->input->post('is_plof');
		$data['plof_size']		= $this->input->post('plof_size');

		//if($this->input->post('is_testing'))
		if($this->input->post('generate')){
			$this->set_bracket_session();
		}

		if($this->input->post('is_sch_courts')){
			$num_courts	= $this->input->post('num_courts');
			$crts					= $this->input->post('courts');
			$match_dates	= $this->input->post('match_date');
			$start_time		= $this->input->post('stime');
			$end_time		= $this->input->post('etime');
			$duration			= $this->input->post('match_duration');
			$break				= $this->input->post('match_break');

				/*$num_grps   = $this->input->post('sel_groups');
				$is_groups   = $this->input->post('is_groups');
				$crts_count  = count($crts);

				if($is_groups and $num_grps > 1 and $crts_count > 1){
					$per_gr = ceil($crts_count / $num_grps);
				}*/


			$tot_match_duration = $duration + $break;

					foreach($crts as $i => $court){
						$start_time[$i] = str_replace(' ', '', $start_time[$i]);
						$end_time[$i]  = str_replace(' ', '', $end_time[$i]);

					$start  = date('Y-m-d H:i', strtotime($match_dates[$i] . " " . $start_time[$i]));
					$end   = date('Y-m-d H:i', strtotime($match_dates[$i] . " " . $end_time[$i]));
								//echo $match_dates[$i]." ".$start_time[$i]." ".$start; exit;
								//$start  = strtotime('-5 hours', strtotime($match_dates[$i] . " " . $start_time[$i]));
					$start  = strtotime($match_dates[$i] . " " . $start_time[$i]);
								//$end   = strtotime('-5 hours', strtotime($match_dates[$i] . " " . $end_time[$i]));
					$end   = strtotime($match_dates[$i] . " " . $end_time[$i]);

					$currentdate	= $start;
					$time_arr		= array();

					$minus_match = strtotime('-'.$tot_match_duration.' minutes', $end);

					//while($currentdate <= $end)
					while($currentdate <= $minus_match)
					{
					  //echo date('m-d-Y H:i', $currentdate)."<br>";
					  //$matches_times[$m] = ($i+1)."-".$currentdate;
					  //$time_arr[($i+1)][] = $currentdate;
					  $time_arr[] = $currentdate;

					  $currentdate = strtotime('+'.$tot_match_duration.' minutes', $currentdate);
					  //do what you want here
					}

						$courts_new[$i] = array('name'	=> $court, 
															'timings'	=> array('sd' => $match_dates[$i],
																					  'st'  => $start_time[$i],
																					  'ed' => $end_time[$i]
																					),
															'time_breaks'	=> $time_arr,
															'duration'		=> $this->input->post('match_duration'),
															'break'			=> $this->input->post('match_break')
															);
					}
					//echo "<pre>";
					//print_r($courts_new); 
					//echo "test";	

					$crt = 0;
					$tm_index = 0;
					$mt = 1;
					for($m = 1; $m < 180; $m++){
						if($courts_new[$crt]['time_breaks'][$tm_index]){
							$match_timings[$mt] = array($courts_new[$crt]['name'], $courts_new[$crt]['timings']['sd'], $courts_new[$crt]['time_breaks'][$tm_index]);
							$mt++;
						}

						if($crt == ($num_courts - 1))
							$crt = 0;
						else
							$crt++;

						if(($m%$num_courts) == 0){
							$tm_index++;
						}
					}

					//print_r($match_timings); 
					//exit;

					$data['courts_new']		= $courts_new;
					$data['match_timings']	= $match_timings;
			}
	/*if($this->logged_user==240)
	echo "<pre>"; print_r($courts_new);
	echo "<pre>"; print_r($match_timings); 
	exit;*/

			if($this->input->post('generate'))
			{
				if($this->input->post('tformat') == 'Teams'){
					$this->is_team_league = 1;
				}

				$users			= $this->input->post('users');
				$num_grps   = $this->input->post('sel_groups');
				$is_groups   = $this->input->post('is_groups');
				$sport			= $this->input->post('sport');
				$grp_top_players = $this->input->post('is_group_top_players');
				$ttype					= $this->input->post('ttype');

				$match_type = $this->input->post('match_type');

				$data['sport_level'] = '';
				if($this->input->post('sport_level')){
				$sport_level = $this->input->post('sport_level');
                $data['sport_level'] = '["'.$sport_level.'"]';
				}

				foreach($match_type as $key => $event){		
					$filter_events[] = $event;
				}

                $data['filter_events']	= json_encode($filter_events);



				if($is_groups){
					$per_grp = round(count($this->input->post('users')) / $num_grps);
					$groups  = array();
					$i				= 1;

					foreach($users as $u){
						$groups[$i][] = $u;
						if(!$grp_top_players){
							//echo $i." ".$u."<br>";
							if($i == $num_grps){ $i = 1; }
							else{ $i++; }
						}
						else{
							//echo $i." ".$u."<br>";
							if(count($groups[$i]) == $per_grp and $i < $num_grps){ $i++; }
						}
					}
					$data['groups']		 = $groups;
					$data['num_grps']  = $num_grps;
					$data['tourn_id']	 = $tourn_id;
					$data['sport']		 = $sport;
					$data['brc_type']	 = $ttype;

					$data['err_count']				= array();
					$data['tformat']					= $this->input->post('tformat');
					$data['rr_multi_rounds']	= $this->input->post('num_of_times');
					$data['tour_type']				= $this->input->post('tour_type');

					$data['grp_top_players']	= $this->input->post('is_group_top_players');

					//echo "<pre>"; print_r($data); exit;

					$this->load->view('includes/header');
					$this->load->view('view_bracket_groups_js', $data);
					$this->load->view('view_bracket_groups', $data);
					$this->load->view('includes/footer');
				}
				else{

				$sel_users_count = count($this->input->post('users'));

				if($sel_users_count == 2 and $ttype != 'Switch Doubles'){
				$ttype = 'Single Elimination';
				}
				
				$data['ttype']    = $ttype;
				$data['results'] = $this->model_news->get_news();

				$tourn_id		= $this->uri->segment(3);
				$user_id		= $this->logged_user;


				if($ttype == 'Single Elimination' or $ttype == 'Consolation'){
					$data['types']		  = $this->input->post('types');
					$data['type_format']  = $this->input->post('type_gen');
					$data['tourn_id']	  = $tourn_id;
					$data['teams']		  = $this->input->post('users');
					$data['num_of_teams'] = count($data['teams']);

					$this->load->view('includes/header');
					($ttype == 'Single Elimination') ? 
					$this->load->view('view_bracket_generate', $data) : $this->load->view('view_cd_bracket_generate', $data);
					$this->load->view('includes/footer');
				}
				else if($ttype == 'Play Off'){
					$data['types']		  = $this->input->post('types');
					$data['type_format']  = $this->input->post('type_gen');
					$data['tourn_id']	  = $tourn_id;
					$data['teams']		  = $this->input->post('users');
					$data['num_of_teams'] = count($data['teams']);

					$this->load->view('includes/header');
					$this->load->view('view_playoff_bracket_generate', $data);
					$this->load->view('includes/footer');
				}
				else if($ttype == 'conventional' or $ttype == 'drive_chip_putt'){
					$data['types'] = $this->input->post('types');
					$data['type_format'] = $this->input->post('type_gen');
						
					$data['tourn_id']		= $tourn_id;
					$data['players']		= $this->input->post('users');
					$data['num_of_players']	= count($data['players']);

					$this->load->view('includes/header');
					$this->load->view('view_golf_bracket_generate', $data);
					$this->load->view('includes/footer');
				}
				else if($ttype == 'Round Robin'){
					$data['types']		 = $this->input->post('types');
					$data['type_format'] = $this->input->post('type_gen');
					$data['tourn_id']	 = $tourn_id;
					$data['teams']		 = array_map('trim', $this->input->post('users'));
					$data['num_of_teams'] = count($data['teams']);

					$robin = new RRobin();

					$competitors = $this->input->post('users');
					$competitors = array_reverse($competitors);

					$data['robin_rounds'] = $robin->create($competitors);
					$data['players']	  = $this->input->post('users');
					//$data['robins']	  = $robin->tour;

// New code for order of matches
$temp	  = "";
$temp2	  = "";
$pop_temp = "";
$temp	  = $robin->tour;

$total_matches = count($temp);
if($total_matches > 3) {
	$group_matches = ($total_matches % 2 == 0) ? ($total_matches / 2) : ($total_matches / 3);

	if($group_matches > 10)	{
	$group_matches = ($total_matches % 4 == 0) ? ($total_matches / 4) : ($total_matches / 5);
	}

	$per_group_matches = $total_matches / $group_matches;
}
else {
	$per_group_matches = 1;
	$group_matches	   = 3;
}

$pop_temp  = array_splice($temp, 0, $per_group_matches);
$temp2	   = array_merge($temp, $pop_temp);
$robins	   = $temp2;
// New code for order of matches ends here

					$data['robins']		 = $robins;
					$data['total_games'] = $robin->tot_games;

					$this->load->view('includes/header');
					$this->load->view('view_rr_bracket_generate',$data);
					$this->load->view('includes/footer');
				}
				else if($ttype == 'Challenge Ladder'){
					$data['tformat']			= $this->input->post('tformat');
					$data['tour_type']		= "Ladder";
					$data['types']				= $this->input->post('types');
					$data['type_format']	= $this->input->post('type_gen');
					$data['tourn_id']			= $tourn_id;			
					$data['players']			= array_map('trim', $this->input->post('users'));

					$get_tour = $this->model_league->getonerow($tourn_id);

					$data['ch_positions']  = $get_tour->Challenge_Positions;			
					$data['sdate']				= $get_tour->StartDate;			
					$data['edate']				= $get_tour->EndDate;			


					$this->load->view('includes/header');
					$this->load->view('view_cl_bracket_generate', $data);
					$this->load->view('includes/footer');
				}
				else if($ttype == 'Switch Doubles'){		// ----------------------- SWITCH DOUBLES ------------------------

					$data['tformat']			= $this->input->post('tformat');
					$data['tour_type']		= "SwitchDoubles";
					$data['types']				= $this->input->post('types');
					$data['type_format']	= $this->input->post('type_gen');
					$data['tourn_id']	 = $tourn_id;			
					$data['players']	 = array_map('trim', $this->input->post('users'));

//					$data['players'] = array(1,2,3,4,5,6,7,8);
//					$data['players'] = array(A,B,C,D,E,F,G,H);
					$players_count = 0;
					$temp = array();

					foreach($data['players'] as $pp){
						$pl = explode('-', $pp);

						if($pl[0]){
							$players_count++;
							$temp[] = $pl[0];
						}
						if($pl[1]){
							$players_count++;
							$temp[] = $pl[1];
						}
						

					}

					$data['players'] = $temp;
					
					/*echo "<pre>";
					print_r($temp);
					print_r($data['players']);
					echo $players_count;*/
					//$players_count = count($data['players']);
					//$temp	= $data['players'];


					if(($players_count % 4) == 0){
						$limit  = $players_count - 1;
						$quot = $players_count / 4;
					}
					else{
						$limit = $players_count;
						$rem = $players_count % 4;
					}

					$i = 1;

					if($players_count == 5){
						while($i <= $limit){
							$bridge[$i] = $temp;
							/*$temp1		= $temp;
							foreach($temp1 as $pos => $player){
								if($pos == count($temp1) - 1){
									$pos = 0;
									$temp[$pos] = $player;
								}
								else{
									$y = $player;
									$z = $temp1[$pos+];
									$temp[$pos] = $player;
								}
							}*/

							$removed = array_shift($temp);						
							array_push($temp, $removed);

						$i++;
						}
					}
					else if($players_count == 8 or $players_count == 4){
						while($i <= $limit){
							$bridge[$i] = $temp;
							$temp1		= $temp;
							foreach($temp1 as $pos => $player){
								if(++$pos == count($temp1))
									$pos = 1;

								$temp[$pos] = $player;
							}
						$i++;
						}
					}
					else{
						echo "<b>Error:</b> Can't proceed. One of the group contains {$players_count}. Please note that switch doubles will support players count only 4 or 5 or 8";
						exit;
					}
/*echo "<pre>";
//print_r($temp);
echo "-----------<br>";
print_r($bridge);*/

					$sd_matches = array();
					foreach($bridge as $m => $matches){
						//echo "Round ".$m."<br>";
						if($quot == 1){
							//echo $bridge[$m][2].'; '.$bridge[$m][3].'  vs  '.$bridge[$m][0].'; '.$bridge[$m][1]."<br>";
							$sd_matches[$m][1][1] = array($bridge[$m][2], $bridge[$m][3]);
							$sd_matches[$m][1][2] = array($bridge[$m][0], $bridge[$m][1]);
						}
						else if($quot == 2){		// 2 and 3 vs. 4 and 6     5 and 1 vs. 7 and 0
							//echo $bridge[$m][2].'; '.$bridge[$m][3].'  vs  '.$bridge[$m][4].'; '.$bridge[$m][6]."<br>";
							$sd_matches[$m][1][1] = array($bridge[$m][2], $bridge[$m][3]);
							$sd_matches[$m][1][2] = array($bridge[$m][4], $bridge[$m][6]);

							//echo $bridge[$m][5].'; '.$bridge[$m][1].'  vs  '.$bridge[$m][7].'; '.$bridge[$m][0]."<br>";
							$sd_matches[$m][2][1] = array($bridge[$m][5], $bridge[$m][1]);
							$sd_matches[$m][2][2] = array($bridge[$m][7], $bridge[$m][0]);
						}
						else if($quot == 3){		//2 and 3  vs.  1 and 6   8 and 10 vs.  4 and 7   5 and 9  vs. 11 and 0
							//echo $bridge[$m][2].'; '.$bridge[$m][3] .'  vs  '.$bridge[$m][1] .'; '.$bridge[$m][6]."<br>";
							$sd_matches[$m][3][1] = array($bridge[$m][2], $bridge[$m][3]);
							$sd_matches[$m][3][2] = array($bridge[$m][1], $bridge[$m][6]);

							//echo $bridge[$m][8].'; '.$bridge[$m][10].'  vs  '.$bridge[$m][4] .'; '.$bridge[$m][7]."<br>";
							$sd_matches[$m][3][1] = array($bridge[$m][8], $bridge[$m][10]);
							$sd_matches[$m][3][2] = array($bridge[$m][4], $bridge[$m][7]);

							//echo $bridge[$m][5].'; '.$bridge[$m][9] .'  vs  '.$bridge[$m][11].'; '.$bridge[$m][0]."<br>";
							$sd_matches[$m][3][1] = array($bridge[$m][5], $bridge[$m][9]);
							$sd_matches[$m][3][2] = array($bridge[$m][11], $bridge[$m][0]);

						}
						else if(in_array($rem, array(1,2,3))){
							//echo $bridge[$m][2].'; '.$bridge[$m][3].'  vs  '.$bridge[$m][4].'; '.$bridge[$m][1]."<br>";
							$sd_matches[$m][1][1] = array($bridge[$m][2], $bridge[$m][3]);
							$sd_matches[$m][1][2] = array($bridge[$m][4], $bridge[$m][1]);
						}
						//echo "<br>";
					}

					$data['sd_matches'] = $sd_matches;

/*echo "<pre>";
print_r($sd_matches);
exit;*/
					$this->load->view('includes/header');
					$this->load->view('view_sd_bracket_generate', $data);
					$this->load->view('includes/footer');
				}
			  }
			}
			else if($this->input->post('groups_cont')){
				//if($this->logged_user == 240){
				//echo "<pre>"; print_r($_POST);  exit;
				//}
				$data['filter_events']	  = $this->input->post('filter_events');

				if($this->input->post('brc_type') == 'Round Robin'){
				//$groups						= unserialize($this->input->post('groups'));
				$groups						= $this->input->post('new_grp');

				$data['courts_new']		= unserialize($this->input->post('courts_new'));
				$data['match_timings']	= unserialize($this->input->post('match_timings'));
				$data['types']	  = $this->input->post('types');
				$data['tformat'] = $this->input->post('tformat');
				$data['is_publish_draw'] = $this->input->post('is_publish_draw');
				$data['num_of_sets'] = $this->input->post('num_of_sets');
				$data['rr_multi_rounds'] = $this->input->post('num_grps');
				$rounds_per_team = $this->input->post('rr_multi_rounds');
	
				foreach($groups as $i => $group){
					for($j=0; $j<$rounds_per_team; $j++){
						$robin = new RRobin();

						$competitors		= $group;
							if($j%2 == 1){
								$competitors = array_reverse($competitors);
							}
						$robin_rounds[$i]	= $robin->create($competitors);
						//$robins[$j]			= $robin->tour;

						// New code for order of matches
						$temp		= "";
						$temp2		= "";
						$pop_temp	= "";

						$temp	    = $robin->tour;
//echo "<pre>"; print_r($temp);  exit;
	$total_matches = count($temp);
	if($total_matches > 3) {
		$group_matches = ($total_matches % 2 == 0) ? ($total_matches / 2) : ($total_matches / 3);

		if($group_matches > 10)	{
		$group_matches = ($total_matches % 4 == 0) ? ($total_matches / 4) : ($total_matches / 5);
		}

		$per_group_matches = $total_matches / $group_matches;
	}
	else {
		$per_group_matches = 1;
		$group_matches = 3;
	}

						$pop_temp   = array_splice($temp, 0, $per_group_matches);
						$temp2	    = array_merge($temp, $pop_temp);
						$robins[$j]	= $temp2;
						// New code for order of matches ends here


						$total_games[$i]	= $robin->tot_games;
					}
				
				//echo "<pre>";
				//print_r($robins);
					foreach($robins as $k => $robin){
						foreach($robin as $r){
						$temp_arr[$i][] = $r;
						}
					}
					//$data['robins']	 = $temp_arr;
				}
				
				//if($this->logged_user == 240)
				//echo "<pre>"; print_r($temp_arr); exit;
				
				$data['tourn_id']		= $tourn_id;
				$data['groups']			= $groups;
				$data['robin_rounds']	= $robin_rounds;
				$data['players']		= $competitors;
				$data['robins']			= $temp_arr;
				$data['total_games']	= $total_games;

				$data['rr_multi_rounds']	= $rounds_per_team;
				
				/*echo "<pre>";
				print_r($data);
				exit;*/
				$this->load->view('includes/header');
				$this->load->view('view_rr_group_bracket_generate',$data);
				$this->load->view('includes/footer');
			}
			else if($this->input->post('brc_type') == 'Switch Doubles'){

				// Switch doubles Grouing continue
				//$data['groups'] = $groups = unserialize($this->input->post('groups'));
				$data['groups'] = $groups	= $this->input->post('new_grp');

				$data['courts_new']		= unserialize($this->input->post('courts_new'));
				$data['match_timings']	= unserialize($this->input->post('match_timings'));
//echo "<pre>"; print_r($data); exit;

					$data['tformat']	 = $this->input->post('tformat');
					$data['tour_type']	 = "SwitchDoubles";
					$data['types']		 = $this->input->post('types');
					$data['type_format'] = $this->input->post('type_gen');
					$data['tourn_id']	 = $tourn_id;			
					$data['players']	 = array_map('trim', $this->input->post('users'));

//					$data['players'] = array(1,2,3,4,5,6,7,8);
//					$data['players'] = array(A,B,C,D,E,F,G,H);
					$temp = array();

foreach($groups as $g => $group){
					$players_count = 0;
					$temp	= array();
					$temp1 = array();
					$bridge = array();
					foreach($group as $pp){
						$pl = explode('-', $pp);

						if($pl[0]){
							$players_count++;
							$temp[] = $pl[0];
						}
						if($pl[1]){
							$players_count++;
							$temp[] = $pl[1];
						}
					}

					$data['players'] = $temp;

					if(($players_count % 4) == 0){
						$limit  = $players_count - 1;
						$quot = $players_count / 4;
					}
					else{
						$limit = $players_count;
						$rem = $players_count % 4;
					}

					//echo $limit."<br>";

					$i = 1;

					if($players_count == 5){
						while($i <= $limit){
							$bridge[$i] = $temp;
							/*$temp1	   = $temp;
							foreach($temp1 as $pos => $player){
								if(++$pos == count($temp1))
									$pos = 0;

								$temp[$pos] = $player;
							}*/
							$removed = array_shift($temp);						
							array_push($temp, $removed);

						$i++;
						}
					}
					else if($players_count == 8 or $players_count == 4){
						//echo $i."<br>";
						while($i <= $limit){
							$bridge[$i]  = $temp;
							//echo "<pre>"; print_r($bridge[$i]); 

							$temp1		= $temp;
							foreach($temp1 as $pos => $player){
								if(++$pos == count($temp1))
									$pos = 1;

								$temp[$pos] = $player;
							}
						$i++;
						}
					}
					else{
						echo "<b>Error:</b> Can't proceed. One of the group contains {$players_count}. Please note that switch doubles will support players count only 4 or 5 or 8";
						exit;
					}
		
//echo "<pre>"; print_r($bridge); 
				$sd_matches = array();
					foreach($bridge as $m => $matches){
						//echo "Round ".$m."<br>";
						if($quot == 1){
							//echo $bridge[$m][2].'; '.$bridge[$m][3].'  vs  '.$bridge[$m][0].'; '.$bridge[$m][1]."<br>";
							$sd_matches[$m][1][1] = array($bridge[$m][2], $bridge[$m][3]);
							$sd_matches[$m][1][2] = array($bridge[$m][0], $bridge[$m][1]);
						}
						else if($quot == 2){		// 2 and 3 vs. 4 and 6     5 and 1 vs. 7 and 0
							//echo $bridge[$m][2].'; '.$bridge[$m][3].'  vs  '.$bridge[$m][4].'; '.$bridge[$m][6]."<br>";
							$sd_matches[$m][1][1] = array($bridge[$m][2], $bridge[$m][3]);
							$sd_matches[$m][1][2] = array($bridge[$m][4], $bridge[$m][6]);

							//echo $bridge[$m][5].'; '.$bridge[$m][1].'  vs  '.$bridge[$m][7].'; '.$bridge[$m][0]."<br>";
							$sd_matches[$m][2][1] = array($bridge[$m][5], $bridge[$m][1]);
							$sd_matches[$m][2][2] = array($bridge[$m][7], $bridge[$m][0]);
						}
						else if($quot == 3){		//2 and 3  vs.  1 and 6   8 and 10 vs.  4 and 7   5 and 9  vs. 11 and 0
							//echo $bridge[$m][2].'; '.$bridge[$m][3] .'  vs  '.$bridge[$m][1] .'; '.$bridge[$m][6]."<br>";
							$sd_matches[$m][3][1] = array($bridge[$m][2], $bridge[$m][3]);
							$sd_matches[$m][3][2] = array($bridge[$m][1], $bridge[$m][6]);

							//echo $bridge[$m][8].'; '.$bridge[$m][10].'  vs  '.$bridge[$m][4] .'; '.$bridge[$m][7]."<br>";
							$sd_matches[$m][3][1] = array($bridge[$m][8], $bridge[$m][10]);
							$sd_matches[$m][3][2] = array($bridge[$m][4], $bridge[$m][7]);

							//echo $bridge[$m][5].'; '.$bridge[$m][9] .'  vs  '.$bridge[$m][11].'; '.$bridge[$m][0]."<br>";
							$sd_matches[$m][3][1] = array($bridge[$m][5], $bridge[$m][9]);
							$sd_matches[$m][3][2] = array($bridge[$m][11], $bridge[$m][0]);

						}
						else if(in_array($rem, array(1,2,3))){
							//echo $bridge[$m][2].'; '.$bridge[$m][3].'  vs  '.$bridge[$m][4].'; '.$bridge[$m][1]."<br>";
							$sd_matches[$m][1][1] = array($bridge[$m][2], $bridge[$m][3]);
							$sd_matches[$m][1][2] = array($bridge[$m][4], $bridge[$m][1]);
						}
						//echo "<br>";
					}

					$temp_sd_matches[$g] = $sd_matches;

}
					//echo "<pre>";
					$data['grp_sd_matches'] = $temp_sd_matches;
					//print_r($data);

				$this->load->view('includes/header');
				$this->load->view('view_sd_group_bracket_generate', $data);
				$this->load->view('includes/footer');
			}
			}
		 }

		 public function check_draw_title()
		 {
			$tourn_id   = $this->input->post('tourn_id');
			$draw_title = $this->input->post('draw_title');
			
			 if($draw_title != ""){
				$res = $this->model_league->check_draw_title($tourn_id, $draw_title);
				echo $res;
			 }
		 }

		 public function get_reg_level_teams($tourn_id, $sel_level){
			$get_reg_teams = $this->model_league->get_reg_level_teams($tourn_id, $sel_level);
			return $get_reg_teams;	
		 }

		 public function bracket_save()
		 {	
			 	//			echo "<pre>"; print_r($_POST); exit;

			$tourn_id = $this->input->post('tourn_id');
//echo "<pre>"; print_r($_POST); exit;
			if($this->input->post('rr_bracket_confirm')){
				//echo "<pre>"; print_r($_POST); exit;
				$res = $this->model_league->insert_rr_brackets();
			}
			else if($this->input->post('bracket_confirm')){
				$res = $this->model_league->insert_tourn_brackets();
			}
			else if($this->input->post('golf_bracket_confirm')){
				$res = $this->model_league->insert_golf_brackets();
			}
			else if($this->input->post('po_bracket_confirm')){
				$res = $this->model_league->insert_po_brackets();
			}
			else if($this->input->post('rr_group_bracket_confirm')){
				$res = $this->model_league->insert_group_rr_brackets();
			}
			else if($this->input->post('sd_group_bracket_confirm')){
				$res = $this->model_league->insert_group_sd_brackets();
			}
			else if($this->input->post('cl_bracket_confirm')){
				$res = $this->model_league->insert_cl_brackets();
			}
			else if($this->input->post('sd_bracket_confirm')){
				$res = $this->model_league->insert_sd_brackets();
			}
			
			if($res){
				 redirect(base_url()."league/".$tourn_id);
			}
		 }

		 public function get_bracket_list($tourn_id){
			return $this->model_league->get_bracket_list($tourn_id);
		 }

		 public function check_is_cd($tourn_id){
			return $this->model_league->check_is_cd($tourn_id);
		 }

		 public function get_player($uid, $pid=''){
			if($pid){
				return $this->general->get_player_partner($uid, $pid);
			}
			else{
				return $this->general->get_player($uid);
			}
		 }
		 public function get_team_name($tid){
				return $this->general->get_team_name($tid);
		 }

		 public function pdf($bracket_id)
		 { #Tourn_ID;
			$bracket_id			  =  $this->uri->segment(3);
			$data['bracket_id']  = $bracket_id;
			$get_bracket = $this->model_league->get_bracket_rounds($data);
			$data['get_bracket'] = $get_bracket;
			$data['match_type']  = $get_bracket['Match_Type'];
			$tr_id				 = $get_bracket['Tourn_ID'];
			
			$tourn_det = $this->model_league->getonerow($tr_id);

			if($get_bracket['Bracket_Type'] == 'Single Elimination'){
				$data['get_tourn_matches'] = $this->model_league->get_tourn_matches($data);
			}
			else if($get_bracket['Bracket_Type'] == 'Consolation'){
				$bid = $bracket_id;

				$data['get_tourn_matches'] = $this->model_league->get_tourn_matches_main($bid);
				$data['get_cd_tourn_matches'] = $this->model_league->get_cd_tourn_matches($bid);
				$data['get_cd_num_rounds'] = $this->model_league->get_cd_tot_rounds($bid);
			}
			else if($get_bracket['Bracket_Type'] == 'Round Robin' or $get_bracket['Bracket_Type'] == 'Switch Doubles'){
				$data['get_rr_tourn_matches'] = $this->model_league->get_tourn_matches($data);
			
			}
				if($tourn_det->tournament_format=='Teams'){
					$this->load->view('view_team_print_draws', $data);
					//$this->load->view('teams/view_team_se_draws_print', $data);
				}
				else{
					if($get_bracket['No_of_rounds'] != 6)
						$this->load->view('view_se_print_draws', $data);
					else
						$this->load->view('view_se_64_print_draws', $data);
				}
		 }

		 public function pdf_c($bracket_id)
		 {
			$bracket_id =  $this->uri->segment(3);
			$data['bracket_id'] = $bracket_id;
			$get_bracket		 = $this->model_league->get_bracket_rounds($data);
			$data['get_bracket'] = $get_bracket;
			$data['match_type']  = $get_bracket['Match_Type'];
			$tr_id				 = $get_bracket['Tourn_ID'];
			
			$tourn_det = $this->model_league->getonerow($tr_id);

			if($get_bracket['Bracket_Type'] == 'Consolation'){
				$bid = $bracket_id;

				$data['get_tourn_matches'] = $this->model_league->get_tourn_matches_main($bid);
				$data['get_cd_tourn_matches'] = $this->model_league->get_cd_tourn_matches($bid);
				$data['get_cd_num_rounds'] = $this->model_league->get_cd_tot_rounds($bid);
			}

			if($tourn_det->tournament_format=='Teams'){
				$this->load->view('view_team_print_draws', $data);
			}
			else{
				$this->load->view('view_cd_print_draws', $data);
			}
		 }

		public function cal_c($pow_vals, $num_teams, $teams, $round)			// Single Elimination
		{
			global $pow_vals;

			$pow_vals = array(2,4,8,16,32,64,128,256);
			
			foreach($pow_vals as $i=>$pv){
				if($num_teams > $pv){
					$near_pow = $pow_vals[++$i];
				}
				else if($num_teams == $pv){
					$near_pow = $pow_vals[$i];
				}
			}

			$num_p = ($num_teams - ($near_pow - $num_teams));
			$num_g = abs($num_teams - ($near_pow/2));

			$bye_p = $num_teams - $num_p;

			$nxt_r_p = $bye_p + $num_g;

				$temp_teams = $teams;

				$bye_pl_list = array();
				if($bye_p > 0){

					for($i=0;$i<$bye_p;$i++){
						$pl = array_shift($temp_teams);
						$bye_pl_list[$i] = array($pl,'---');
					}
				}

				$game_pl_list = array();
				if($round==1){
					for($i=0,$k=0;$i<$num_g;$i++){
						$fst = reset($temp_teams);
						$lst = end($temp_teams);

						$game_pl_list[$k] = array($fst,$lst);
						array_shift($temp_teams);
						array_pop($temp_teams);
					$k++;
					}
				}
				else{
					for($j=1,$k=0;$j<=count($teams);$j++){
						if($j%2==0){
						$game_pl_list[$k] = array($teams[$j-2],$teams[$j-1]);
						$k++;
						}
					}

				}

			$res = array();

				$res[0] = $num_p;
				$res[1] = $num_g;
				$res[2] = $bye_p;
				$res[3] = $nxt_r_p;
				$res[4] = $num_g + $bye_p;

				if(!empty($bye_pl_list)){
					$res[5] = array_merge($bye_pl_list, $game_pl_list);
				}
				else{
					$res[5] = $game_pl_list;
				}
			

				/*	Disabled the shuffling of Seeds
				if($round==1){
						shuffle($res[5]);
				}*/


				/*	Top seed should not be in same pool */
				if($round == 1 and $num_teams != 2){
					// New Code 18-March-2019
					$res[5] = league::getBracket($teams);
				}

				/* -------------------------------------- */		

				$res[6] = $res[5];

			return $res;
		}


		public function cd_cal_c($pow_vals, $num_teams, $teams, $round, $dt)		// Consolation
		{
			global $pow_vals;

			$pow_vals = array(2,4,8,16,32,64,128,256);
			
			foreach($pow_vals as $i=>$pv){
				if($num_teams > $pv)
				{
					$near_pow = $pow_vals[++$i];
				}
				else if($num_teams == $pv)
				{
					$near_pow = $pow_vals[$i];
				}
			}

			$num_p = ($num_teams - ($near_pow - $num_teams));
			$num_g = abs($num_teams - ($near_pow/2));

			$bye_p = $num_teams - $num_p;

			$nxt_r_p = $bye_p + $num_g;


				$temp_teams = $teams;

				$bye_pl_list = array();
				if($bye_p > 0){

					for($i=0;$i<$bye_p;$i++)
					{
						$pl = array_shift($temp_teams);
						$bye_pl_list[$i] = array($pl,'---');
					}
				}

				$game_pl_list = array();
				if($round==1){
					for($i=0,$k=0;$i<$num_g;$i++)
					{
						$fst = reset($temp_teams);
						$lst = end($temp_teams);

						$game_pl_list[$k] = array($fst,$lst);
						array_shift($temp_teams);
						array_pop($temp_teams);
					$k++;
					}
				}
				else{
					for($j=1,$k=0;$j<=count($teams);$j++){
						if($j%2==0){
							$game_pl_list[$k] = array($teams[$j-2],$teams[$j-1]);
							$k++;
						}
					}
				}

			$res = array();

				$res[0] = $num_p;
				$res[1] = $num_g;
				$res[2] = $bye_p;
				$res[3] = $nxt_r_p;
				$res[4] = $num_g + $bye_p;

				if(!empty($bye_pl_list)){
					$res[5] = array_merge($bye_pl_list, $game_pl_list);
				}
				else{
					$res[5] = $game_pl_list;
				}
			
				/*	Disabled the shuffling of the seed 
					if($round==1 && $dt != 'Consolation'){
						shuffle($res[5]);
					}
				*/

		
				/*	Top seed should not be in same pool */
					//code removed here
				/* -------------------------------------- */	
					

				/*	Top seed should not be in same pool */
				if($round == 1 and $num_teams != 2){
					// New Code 18-March-2019
					$res[5] = league::getBracket($teams);
				}

				$res[6] = $res[5];

				$res[7] = $num_g + $bye_p;
				$res[8] = $res[5];

			/*echo "<pre>";
			print_r($res);
			exit;*/

			return $res;
		}

		public function play_offs($pow_vals, $num_teams, $teams, $round, $dt)		// Consolation
		{
			global $pow_vals;

			$pow_vals = array(2,4,8,16,32,64,128,256);
			
			foreach($pow_vals as $i=>$pv){
				if($num_teams > $pv)
				{
					$near_pow = $pow_vals[++$i];
				}
				else if($num_teams == $pv)
				{
					$near_pow = $pow_vals[$i];
				}
			}

			$num_p = ($num_teams - ($near_pow - $num_teams));
			$num_g = abs($num_teams - ($near_pow/2));

			$bye_p = $num_teams - $num_p;

			$nxt_r_p = $bye_p + $num_g;


				$temp_teams = $teams;

				$bye_pl_list = array();
				if($bye_p > 0){

					for($i=0;$i<$bye_p;$i++)
					{
						$pl = array_shift($temp_teams);
						$bye_pl_list[$i] = array($pl,'---');
					}
				}

				$game_pl_list = array();
				if($round==1){
					for($i=0,$k=0;$i<$num_g;$i++)
					{
						$fst = reset($temp_teams);
						$lst = end($temp_teams);

						$game_pl_list[$k] = array($fst,$lst);
						array_shift($temp_teams);
						array_pop($temp_teams);
					$k++;
					}
				}
				else{
					for($j=1,$k=0;$j<=count($teams);$j++){
						if($j%2==0){
							$game_pl_list[$k] = array($teams[$j-2],$teams[$j-1]);
							$k++;
						}
					}
				}

			$res = array();

				$res[0] = $num_p;
				$res[1] = $num_g;
				$res[2] = $bye_p;
				$res[3] = $nxt_r_p;
				$res[4] = $num_g + $bye_p;

				if(!empty($bye_pl_list)){
					$res[5] = array_merge($bye_pl_list, $game_pl_list);
				}
				else{
					$res[5] = $game_pl_list;
				}
			
				/*	Disabled the shuffling of the seed 

					if($round==1 && $dt != 'Consolation'){
						shuffle($res[5]);
					} 
				*/

		
				/*	Top seed should not be in same pool */
				if($round==1){

					foreach($res[5] as $i => $seeds){

						if($i < (count($res[5])/2))					// New Code 5-OCT-16
						{
							//echo $i." ".(count($res[5])-($i+1))."<br>";

							$res_1[$i] = $res[5][$i];
							$res_1[count($res[5])-($i+1)] = $res[5][count($res[5])-($i+1)];
						}
						
						/*if($i%2 == 0){							// Old Code Before 5-OCT-16
							$res_2[] = $res[5][$i]; 
						}
						else{
							$res_3[] = $res[5][$i]; 
						}*/
					}

						//$res[5] = array_merge($res_2, $res_3);	// Old Code Before 5-OCT-16
						$res[5] = $res_1;							// New Code 5-OCT-16

					foreach($res[5] as $i => $seeds){				// New Code 5-OCT-16
						
						if($i%2 == 0){
							$res_2[] = $res[5][$i]; 
						}
						else{
							$res_3[] = $res[5][$i]; 
						}
					}

					$res[5] = array_merge($res_2, $res_3);			// New Code 5-OCT-16

						if(count($res[5]) == 16)					// New Code 7-OCT-16
						{
							$temp4 = $res[5][4];
							$temp5 = $res[5][5];

							$res[5][4] = $res[5][2];
							$res[5][5] = $res[5][3];

							$res[5][2] = $temp4;
							$res[5][3] = $temp5;

								
							$temp10 = $res[5][10];
							$temp11 = $res[5][11]; 

							$res[5][10] = $res[5][12];
							$res[5][11] = $res[5][13];

							$res[5][12] = $temp10;
							$res[5][13] = $temp11;
						}


				}
				/* -------------------------------------- */	
					

				$res[6] = $res[5];

				$res[7] = $num_g + $bye_p;
				$res[8] = $res[5];


			return $res;
		}

		 public function get_username($user_id) {
			return $this->general->get_user($user_id);
		 }

		 public function get_team($team_id) {
			return $this->general->get_team($team_id);
		 }

		 public function get_participant_count($tourn_id) {
			return $this->general->get_team_participant_player_count($tourn_id);
		 }

		 public function get_team_track_event($tourn_title) {
			return $this->general->get_team_track_event($tourn_title);
		 }

		 public function check_user_emailoption($user_id) {
			return $this->general->check_user_emailoption($user_id);
		 }

		 public function get_a2mscore($user_id, $sport_id) {
			return $this->general->get_user_a2mscore($user_id, $sport_id);
		 }

		 public function register_trnmt() {

			$res				= $this->model_league->insert_reg__tourn_data();
			$data['reg']	= "Thanks for Registering to this tournment. Details are sent to your email Address";
			
			if($res) {
				redirect('play',$data);
			}
		 }

		public function viewbracket($tourn_id = '') {
		
		$bid = $this->input->post('bracket_id');
		/*echo "<pre>";
		print_r($_POST);
		*/
			if($tourn_id){
				$data['tourn_det']	= $this->model_league->getonerow($tourn_id);
				$data['brackets']	= $this->model_league->get_bracket_list($tourn_id);
				$data['results']	= $this->model_news->get_news();

				$this->load->view('includes/header');
				$this->load->view('view_tourn_bracket',$data);
				$this->load->view('includes/footer');
			}
			else if($this->input->post('get_bracket') or $this->input->post("tour_draw_show".$bid)){
				$tourn_id			 = $this->input->post('tourn_id');
				$tr_det				= $this->model_league->getonerow($this->input->post('tourn_id'));
				$data['tourn_det']	= $tr_det;

				$this->is_team_league = ($tr_det->tournament_format  == 'Teams') ? 1 : 0;

				$get_bracket		 = $this->model_league->get_tourn_bracket($bid);
				$data['bracket_id']  = $get_bracket['BracketID'];
				$data['match_type']  = $get_bracket['Match_Type'];
				$data['get_bracket'] = $get_bracket;

				$data['results']	 = $this->model_news->get_news();
				$data['tour_details'] = $data['tourn_det'];

	
				if($this->input->post('tourn_type') == 'Single Elimination')
				{
					if(!$get_bracket['BracketID']){
						$data['no_bracket'] = "Draws are not available for the given criteria.";
					}
					else{
						$data['get_tourn_matches'] = $this->model_league->get_tourn_matches($data);

						if($this->input->post('tformat') == "Teams"){
							$data['get_se_line_matches'] = $this->model_league->get_tourn_line_matches($data);
						}
					}
				}
				else if($this->input->post('tourn_type') == 'Round Robin')
				{
					if(!$get_bracket['BracketID']){
						$data['no_bracket'] = "Draws are not available for the given criteria.";
					}
					else{
						$data['get_rr_tourn_matches'] = $this->model_league->get_tourn_matches($data);

						if($this->input->post('tformat') == "Teams"){
							$data['get_rr_line_matches'] = $this->model_league->get_tourn_line_matches($data);
						}
					}
				}
				else if($this->input->post('tourn_type') == 'Consolation')
				{
					if(!$get_bracket['BracketID'])
					{
						$data['no_bracket'] = "Draws are not available for the given criteria.";
					}
					else
					{
						$data['get_tourn_matches']	  = $this->model_league->get_tourn_matches_main($bid);
						$data['get_cd_tourn_matches'] = $this->model_league->get_cd_tourn_matches($bid);
						$data['get_cd_num_rounds']	  = $this->model_league->get_cd_tot_rounds($bid);
					}
				}
				else if($this->input->post('tourn_type') == 'Play Off')
				{
					if(!$get_bracket['BracketID'])
					{
						$data['no_bracket'] = "Draws are not available for the given criteria.";
					}
					else
					{
						$data['get_po_tourn_matches']	= $this->model_league->get_po_tourn_matches($bid);
						$data['get_po_line_matches']	= $this->model_league->get_po_line_matches($bid);
					}
				}
				else if($this->input->post('tourn_type') == 'drive_chip_putt' or $this->input->post('tourn_type') == 'conventional')
				{
					$data['golf_tourn_matches'] = $this->model_league->get_golf_tourn_matches($data);

					if($data['golf_tourn_matches']->num_rows() == 0)
					{
						$data['no_matches'] = "Matches are not available for the given criteria.";
					}
				}


			$data['brackets'] = $this->model_league->get_bracket_list($tourn_id);

			$match_results  = $this->model_league->get_tourn_match_id($bid);
			$match_id		= $match_results['Tourn_match_id'];
			$data['get_match_comments'] = $this->model_league->get_match_comments($match_id);

			$this->load->view('includes/header');

				/* Filtering MyMatches */
				$count = 0;
				$data['valid_draws_count']  = $count;
				$data['show_draw_bid']		= 0;

				$tid		= $data['tourn_det']->tournament_ID;
				$tour_admin = $data['tourn_det']->Usersid;
				$sport		= $data['tourn_det']->SportsType;

				if(($tour_admin != $this->logged_user and $data['tourn_det']->Tournament_Director != $this->logged_user) and $this->logged_user){
					$brackets = $this->get_bracket_list($tid);
					if(count(array_filter($brackets)) > 0){
						foreach($brackets as $bk)
						{
							//$check_user = $this->check_is_user_exists($tid, $bk->BracketID);
							if($this->is_team_league){
								$check_user = $this->check_team_is_user_exists($tid, $bk->BracketID, $sport);
							}
							else{
								$check_user = $this->check_is_user_exists($tid, $bk->BracketID, $sport);
							}
							if($check_user){
								$show_bid = $bk->BracketID;
								$count++;
							}
						}
					}
				$data['valid_draws_count'] = $count;
				$data['show_draw_bid']	   = $show_bid;
				}  
				/* Filtering MyMatches */

				$data['is_logged_user_reg'] = $this->model_league->is_logged_user_reg($tid);

				if($this->is_team_league){
				$team_fee_type = $tr_det->Fee_collect_type;
				$fee_payable = '';

				//$data['is_logged_user_reg'] = $this->model_league->get_team_reg_tournment($tourn_id);		

				$user_reg_team = $this->model_league->get_team_reg($this->logged_user, $tid);
				$data['is_logged_user_reg'] = $user_reg_team;

				 if(!empty($user_reg_team) and $team_fee_type == 'Player' and $tr_det->Usersid != $this->logged_user){
					
					$team_reg_age_group		= $user_reg_team['Reg_Age_Group'];
					$logged_user_part_team	= $user_reg_team['Team_id'];
			
					$is_paid = $this->model_league->check_is_paid($this->logged_user, $tid, $logged_user_part_team);
					if(!$is_paid){
					$tr_age_group = json_decode($tr_det->Age);
					$tr_fee		  = json_decode($tr_det->mult_fee_collect);

					$key = array_search($team_reg_age_group, $tr_age_group);

					$fee_payable = $tr_fee[$key];
					$data['fee_payable'] = number_format($fee_payable, 2);
					//echo $fee_payable;
					$data['my_reg_team'] = $logged_user_part_team;

					$this->session->unset_userdata('tour_per_player_fee');
					$this->session->unset_userdata('tourn_id_fee_pay');
					$this->session->unset_userdata('tour_reg_team_id');

					$sess_data = array('tour_per_player_fee'=>number_format($fee_payable, 2), 'tourn_id_fee_pay'=>$tid, 'tour_reg_team_id'=>$logged_user_part_team);

					$this->session->set_userdata($sess_data);
					}
				  }
				}

			$data['tourn_comments'] = $this->general->get_tourn_comments($tid);

			($this->input->post("template")=="view_tournament") ? 
				$this->load->view('view_tournament', $data) : $this->load->view('view_tourn_bracket', $data);
			$this->load->view('includes/footer');

			}
			else if($this->input->post("tour_draw_delete" . $bid)) 	{
				$tourn_id = $this->input->post('tourn_id');
				$get_tour_admin = $this->model_league->getonerow($tourn_id);
				
				if($get_tour_admin->Usersid == $this->logged_user or $get_tour_admin->Tournament_Director == $this->logged_user) {
				
					if($get_tour_admin->SportsType == '4') {
					$res = $this->model_league->delete_golf_brackets($bid);
					}
					else {
						if($this->input->post('tformat') == "Teams"){
							$res = $this->model_league->delete_team_brackets($bid);
						}
						else {
							$res = $this->model_league->delete_brackets($bid);
						}
					}
					redirect("league/$tourn_id");
				}
				else {
				  echo "<h4>Unauthorized Access!</h4>";
				}
			}
			else {
				echo "Invalid Access!";
			}
		 }


		 public function view_matches()
		 {
			//echo "<pre>"; print_r($_POST); exit;
			$score_type = $this->input->post('score_type');

			switch($score_type){

				case "WFF":
				case "SE_WFF":
				case "SD_WFF":
				case "CD_WFF":
				case "CD_CD_WFF":
					$res = $this->model_league->update_wff_winner();
					$email_status = $this->email_add_score($res);
				break;

				case "ADDSCORE":		// RR ADDSCORE
				case "SD_ADDSCORE":		// SD ADDSCORE
					$res = $this->model_league->update_rr_tourn_match_score();
					$email_status = $this->email_add_score($res);
				break;

				case "CL_ADDSCORE":		// CL ADDSCORE
					$res = $this->model_league->update_cl_tourn_match_score();
					$swap_pos = $this->swap_positions($res);
					//$email_status = $this->email_add_score($res);
				break;

				case "CL_WFF":			// CL WFF
					$res = $this->model_league->update_cl_wff_winner();
					$swap_pos = $this->swap_positions($res);
					//$email_status = $this->email_add_score($res);
				break;

				case "RR_EDITSCORE":
				case "SD_EDITSCORE":
					$res = $this->model_league->edit_rr_tourn_match_score();
						if($res['type'] == 'rr')
						$email_status = $this->email_add_score($res);
				break;

				case "SE_EDITSCORE":
				case "CD_EDITSCORE":
				case "CD_CD_EDITSCORE":
					//$res = $this->model_league->edit_tourn_match_score();
					$res = $this->model_league->update_tourn_match_score();
					$email_status = $this->email_add_score($res);
				break;

				case "SE_ADDSCORE":
				case "CD_ADDSCORE":
				case "CD_CD_ADDSCORE":
					$res = $this->model_league->update_tourn_match_score();
					$email_status = $this->email_add_score($res);
				break;

				case "GOLF_ADDSCORE":
					$res = $this->model_league->update_golf_match_score();
					$email_status = $this->email_add_score($res);
				break;

				/* **************** Teams ******************** */

				case "TEAM_ADDSCORE":		// RR Teams ADDSCORE
					$res = $this->model_league->update_team_rr_tourn_score();
					//$email_status = $this->email_add_score($res);
				break;

				case "TEAM_SE_ADDSCORE":		// RR Teams ADDSCORE
					$res = $this->model_league->update_team_se_tourn_score();
					//$email_status = $this->email_add_score($res);
				break;

				case "TEAM_WFF":		// RR Teams WFF
					$res = $this->model_league->update_team_wff();
					//$email_status = $this->email_add_score($res);
				break;

				case "TEAM_SE_WFF":		// RR Teams WFF
					$res = $this->model_league->update_team_se_wff();
					//$email_status = $this->email_add_score($res);
				break;

				case "TEAM_ADDSCORE_PO":		// PO Teams ADDSCORE
					$res = $this->model_league->update_team_po_tourn_score();
					//$email_status = $this->email_add_score($res);
				break;

				case "TEAM_WFF_PO":		// PO Teams WFF
					$res = $this->model_league->update_team_po_wff();
					//$email_status = $this->email_add_score($res);
				break;

/* **************** TeamSport ******************** */

				case "TS_ADDSCORE":		// RR Teams ADDSCORE
					$res = $this->model_league->update_teamsport_rr_addscore();
					//$email_status = $this->email_add_score($res);
				break;

				case "TS_SE_ADDSCORE":		// RR Teams ADDSCORE
					$res = $this->model_league->update_teamsport_addscore();
					//$email_status = $this->email_add_score($res);
				break;

				case "TS_SE_EDITSCORE":		// RR Teams ADDSCORE
					$res = $this->model_league->edit_teamsport_match_score();
					//$email_status = $this->email_add_score($res);
				break;

				case "TS_WFF":		// RR Teams WFF
					$res = $this->model_league->update_teamsport_wff();
					//$email_status = $this->email_add_score($res);
				break;

				case "TS_SE_WFF":		// RR Teams WFF
					$res = $this->model_league->update_teamsport_wff();
					//$email_status = $this->email_add_score($res);
				break;

				case "TS_ADDSCORE_PO":		// PO Teams ADDSCORE
					$res = $this->model_league->update_team_po_tourn_score();
					//$email_status = $this->email_add_score($res);
				break;

				case "TS_WFF_PO":		// PO Teams WFF
					$res = $this->model_league->update_team_po_wff();
					//$email_status = $this->email_add_score($res);
				break;

				case "TS_ADDSTATS":		// Add Match Player Stats
					$res = $this->model_league->update_match_player_stats();
					//$email_status = $this->email_add_score($res);
				break;

				default:
					break;
			}

			if($score_type){
				$tr_det = $this->model_league->getonerow($this->input->post('tourn_id'));
			
				if($tr_det->tournament_format == 'TeamSport'){
					$tourn_id		= $this->input->post('tourn_id');
					$tourn_match_id	= $this->input->post('tourn_match_id');

					$get_row_info = $this->model_league->get_team_match_info($tourn_match_id);
					$data['match_details'] = $get_row_info;

					$this->load->view('teams/view_team_addscore_row', $data);
				}
				else{
					$tourn_id		= $this->input->post('tourn_id');
					$tourn_match_id	= $this->input->post('tourn_match_id');

					$get_row_info = $this->model_league->get_match_info($tourn_match_id);
					$data['match_details'] = $get_row_info;

					$this->get_logged_user_role($tourn_id);
					if($get_row_info['Draw_Type'] == 'Consolation')
						$this->load->view('tournament/view_cons_addscore_row', $data);
					else
						$this->load->view('tournament/view_addscore_row', $data);
				}
			}

			//$is_change_dates = $this->input->post('update_draw');

			if($this->input->post('update_draw_status')){

				$draw_type = $this->input->post('update_draw_status');

				if($draw_type == 1) {
					$this->model_league->update_tourn_dates();
				}
				else if($draw_type == 2) {
					$this->model_league->update_con_tourn_dates();
				}
				else if($draw_type == 3) {
					$this->model_league->update_rr_tourn_dates();
				}
				else if($draw_type == 4) {
					$this->model_league->update_sd_tourn_dates();
				}
				else{
					echo "Invalid Request!";
				}
			}

			$bid = $this->input->post('bracket_id'); 
			
			if($this->input->post("list_draw_matches".$bid)){

				$tr_det = $this->model_league->getonerow($this->input->post('tourn_id'));
				$data['tourn_det']	  = $tr_det;
				$data['tourn_admin']  = $tr_det->Usersid;

				$this->is_team_league = ($tr_det->tournament_format  == 'Teams') ? 1 : 0;
				$get_bracket_details  = $this->model_league->get_tourn_bracket($bid);

				$data['bracket_id']	  = $get_bracket_details['BracketID'];
				$data['get_bracket_details'] = $get_bracket_details;
				
				$bid = $get_bracket_details['BracketID'];

				$data['results']	  = $this->model_news->get_news();
				$data['tour_details'] = $data['tourn_det'];
				$data['match_type']	  = $this->input->post('match_type');

				$match_results = $this->model_league->get_tourn_match_id($bid);
				$match_id	   = $match_results['Tourn_match_id'];
			    $data['get_match_comments'] = $this->model_league->get_match_comments($match_id);
				$data['tourn_comments']		= $this->general->get_tourn_comments($tr_det->tournament_ID);

				if($this->input->post('tourn_type') == 'Single Elimination')
				{
				$data['bracket_matches'] = $this->model_league->get_tourn_matches($data);

					if($data['bracket_matches']->num_rows() == 0)
					{
						$data['no_matches'] = "Matches are not available for the given criteria.";
					}

					if($this->input->post('tformat') == "Teams"){
						$data['se_line_matches'] = $this->model_league->get_tourn_line_matches($data);
					}
				}
				else if($this->input->post('tourn_type') == 'Play Off')
				{
				$data['po_bracket_matches'] = $this->model_league->get_tourn_matches($data);

					if($data['po_bracket_matches']->num_rows() == 0){
						$data['no_matches'] = "Matches are not available for the given criteria.";
					}

					if($this->input->post('tformat') == "Teams"){
						$data['po_line_matches'] = $this->model_league->get_tourn_line_matches($data);
					}
					//echo "<pre>"; print_r($data['po_bracket_matches']); print_r($data['po_line_matches']); exit;
				}
				else if($this->input->post('tourn_type') == 'Round Robin')
				{
					$data['reg_page']	  = "My_Matches";
				//echo $data['reg_page']; exit;
				$data['rr_bracket_matches'] = $this->model_league->get_tourn_matches($data);

					if($data['rr_bracket_matches']->num_rows() == 0)
					{
						$data['no_matches'] = "Matches are not available for the given criteria.";
					}

					if($this->input->post('tformat') == "Teams"){
						$data['rr_line_matches'] = $this->model_league->get_tourn_line_matches($data);
					}

				}
				else if($this->input->post('tourn_type') == 'Consolation')
				{
					if(!$get_bracket_details['BracketID'])
					{
						$data['no_matches'] = "Matches are not available for the given criteria.";
					}
					else
					{
						$data['bracket_matches_main'] = $this->model_league->get_tourn_matches_main($bid);
						$data['bracket_matches_cd']	  = $this->model_league->get_cd_tourn_matches($bid);
						$data['cd_num_rounds']		  = $this->model_league->get_cd_tot_rounds($bid);
					}
				}

				else if($this->input->post('tourn_type') == 'drive_chip_putt' or $this->input->post('tourn_type') == 'conventional')
				{
					$data['golf_bracket_matches'] = $this->model_league->get_golf_tourn_matches($data);

					if($data['golf_bracket_matches']->num_rows() == 0)
					{
						$data['no_matches'] = "Matches are not available for the given criteria.";
					}
				}

				/* Filtering MyMatches */
				$count = 0;
				$data['valid_draws_count']  = $count;
				$data['show_draw_bid']		= 0;

				$tid		= $data['tourn_det']->tournament_ID;
				$tour_admin = $data['tourn_det']->Usersid;
				$tour_director = $data['tourn_det']->Tournament_Director;
				$sport		= $data['tourn_det']->SportsType;

				if($tour_admin != $this->logged_user and $tour_director != $this->logged_user){
					$brackets = $this->get_bracket_list($tid);
					if(count(array_filter($brackets)) > 0){
						foreach($brackets as $bk)
						{
							if($this->is_team_league){
							$check_user = $this->check_team_is_user_exists($tid, $bk->BracketID, $sport);
								$user_reg_team = $this->model_league->get_team_reg($this->logged_user, $tid);
								$data['is_logged_user_reg'] = $user_reg_team;
							} else{
							$check_user = $this->check_is_user_exists($tid, $bk->BracketID, $sport);
							}
							if($check_user){
								$show_bid = $bk->BracketID;
								$count++;
							}
						}
					}
				$data['valid_draws_count'] = $count;
				$data['show_draw_bid']	   = $show_bid;
				}
				/*echo "<pre>";
				print_r($data);
				exit;*/
				/* Filtering MyMatches */
				//echo "<script>console.log( 'Debug Objects: " . print_r($data). "' );</script>";
				$this->load->view('includes/header');
				$this->load->view('view_tournament', $data);
				$this->load->view('includes/footer');
			}
		 }

		 public function email_add_score($res)
		 {
			$xy = $res;
			$type = $xy['type'];

				$player1 = $xy['player1'];
				$player2 = $xy['player2'];

				$player1_partner = $xy['player1_partner'];
				$player2_partner = $xy['player2_partner'];

				$tourn_id = $xy['tourn_id'];
				$winner = $xy['winner'];

			if($type == 'se' or $type == 'rr'){
				$player1_score = $xy['player1_score'];
				$player2_score = $xy['player2_score'];
				($xy['draw_name']) ? $draw_name = $xy['draw_name'] : $draw_name = "";
				($xy['round_title']) ? $round_title = $xy['round_title'] : $round_title = "";

			}
			else if($type == 'wff'){
				$draw_name = $xy['draw_name'];
				$round_title = $xy['round_title'];
			}

			$tourn_det	 = $this->model_league->getonerow($tourn_id);
			$tourn_admin = $tourn_det->Usersid;
			$tour_director = $tourn_det->Tournament_Director;
			$sess_id	 = $this->logged_user;;

			if($sess_id != $tourn_admin and $sess_id != $tour_director){
// done so far here
			$title = $tourn_det->tournament_title;

			$get_email2 = $this->get_username($tourn_admin);
			$tourn_admin_email = ($get_email2['EmailID'] != "") ? $get_email2['EmailID'] : $get_email2['AlternateEmailID'];

			$get_player1_name = $this->check_user_emailoption($player1);

			if($get_player1_name){
			$player1_name = $get_player1_name['Firstname'] . " " . $get_player1_name['Lastname'];
			$player1_email = ($get_player1_name['EmailID'] != "") ? $get_player1_name['EmailID'] : $get_player1_name['AlternateEmailID'];
			}	
			//$player1_email = ($get_player2_details['EmailID'] != "") ? $get_player2_details['EmailID'] : $get_player2_details['AlternateEmailID'];

			$get_player2_name = $this->check_user_emailoption($player2);

			if($get_player2_name){
			$player2_name = $get_player2_name['Firstname'] . " " . $get_player2_name['Lastname'];
			$player2_email = ($get_player2_name['EmailID'] != "") ? $get_player2_name['EmailID'] : $get_player2_name['AlternateEmailID'];
			}

			$get_player1_partner = $this->check_user_emailoption($player1_partner);

			if($get_player1_partner){
			$p1_partner = $get_player1_partner['Firstname'] . " " . $get_player1_partner['Lastname'];
			$p1_partner_email = ($get_player1_partner['EmailID'] != "") ? $get_player1_partner['EmailID'] : $get_player1_partner['AlternateEmailID'];
			}

			$get_player2_partner = $this->check_user_emailoption($player2_partner);
			
			if($get_player2_partner){
			$p2_partner = $get_player2_partner['Firstname'] . " " . $get_player2_partner['Lastname'];
			$p2_partner_email = ($get_player2_partner['EmailID'] != "") ? $get_player2_partner['EmailID'] : $get_player2_partner['AlternateEmailID'];
			}

			$get_winner_name = $this->get_username($winner);
			$winner_name = $get_winner_name['Firstname'] . " " . $get_winner_name['Lastname'];

			$winner_partner = ($winner == $player1) ? $player1_partner : $player2_partner;

			$get_winner_partner_name = $this->get_username($winner_partner);
			$winner_partner_name = $get_winner_partner_name['Firstname'] . " " . $get_winner_partner_name['Lastname'];

			$this->load->library('email');
			$this->email->set_newline("\r\n");
		
			$this->email->from(FROM_EMAIL, 'A2MSports');	
			$this->email->to("$player1_email, $player2_email, $p1_partner_email, $p2_partner_email, $tourn_admin_email");  
			$this->email->subject('Tournament Match Score Update');


			if($type == 'se' or $type == 'rr') {

				$data = array(
					'player1_name' => $player1_name,
					'player2_name' => $player2_name,
					'player1_partner' => $p1_partner,
					'player2_partner' => $p2_partner,
					'winner' => $winner_name,
					'winner_partner_name' => $winner_partner_name,
					'player1_score' => $player1_score,
					'player2_score' => $player2_score,
					'tourn_id'		=> $tourn_id,
					'title'			=> $title,
					'draw_name'		=> $draw_name,
					'round_title'	=> $round_title,
					'type'			=> $type,
					'page'			=> 'Add-Score-SE-RR'
					);

				/*echo "<pre>";
				print_r($data);
				exit;*/

				$body = $this->load->view('view_email_template.php',$data,TRUE);
						$this->email->message($body);   
				//$stat = $this->email->send();
			
				return $stat;
			}
			else if($type == 'wff') {

				$data = array(
						'tourn_id'		=> $tourn_id,
						'winner'		=> $winner_name,
						'winner_partner_name' => $winner_partner_name,
						'title'			=> $title,
						'draw_name'		=> $draw_name,
						'round_title'	=> $round_title,
						'page'			=> 'Add-Score-WFF'
						);

				$body = $this->load->view('view_email_template.php',$data,TRUE);
				$this->email->message($body);   
				//$stat = $this->email->send();
			
			return $stat;
			}
		  } 
		  else{
			return true;
		  }

		 }

		 public function send_email_reg_players()
		 {
			if($this->input->post('send_reg_email'))
			{
				$tourn_id  = $this->input->post('tourn_id');
				$tourn_det = $this->model_league->getonerow($tourn_id);

				$tourn_admin = $tourn_det->Usersid;
				$get_name	 = $this->get_username($tourn_admin);
				$tourn_admin_name = $get_name['Firstname'] . ' ' . $get_name['Lastname'];

				$title = $tourn_det->tournament_title;

				$sub = $this->input->post('txt_sub');

				if($sub == ""){
					$sub = 'Message from ' . $title . ' Admin - A2MSports';
				}

				$this->load->library('email');
				$this->email->set_newline("\r\n");

				$email = $this->session->userdata('EmailID');

				foreach($this->input->post('sel_player') as $user_id)
				{
				$sql = "SELECT * FROM users WHERE Users_ID = " .$user_id;
				$result = $this->db->query($sql);
				$row = $result->row();

				$this->email->from(FROM_EMAIL, 'A2MSports');
				$this->email->to($row->EmailID);
			
				$this->email->subject($sub);

				$des = htmlentities($this->input->post('des'));

				$data = array(
				'firstname'=> $row->Firstname,
				'lastname'=> $row->Lastname,
				'tourn_id' => $tourn_id,
				'title' => $title,
				'admin_name' => $tourn_admin_name,
				'des' => $des,
				'page'=> 'Send Email Registered Players'
				);

				$body = $this->load->view('view_email_template.php',$data,TRUE);

				$this->email->message($body);   
				$this->email->send();
				}

				redirect("league/$tourn_id");
			}
		 }

		 public function update_players()
		 {
			$tourn_id = $this->input->post('tourn_id');
			$res = $this->model_league->update_doubles_partner();

			 if($res){
				redirect("league/$tourn_id");
			 }
		 }

		 public function get_match_scores_player1($source, $bracket_id, $tour_id, $draw_type)
		 {
			return $this->model_league->get_match_scores_player1($source, $bracket_id, $tour_id, $draw_type);
		 }

		 public function get_match_scores_player2($source, $bracket_id, $tour_id, $draw_type)
		 {
			return $this->model_league->get_match_scores_player2($source, $bracket_id, $tour_id, $draw_type);
		 }

		 public function autocomplete()
		 {
			$q = $_POST['name_startsWith'];
	
			$data['key'] = trim($q);
			$result = $this->model_league->search_autocomplete($data);

			if($result){
				$data_new = array();
				foreach($result as $row){
					$name = $row->Firstname . ' ' . $row->Lastname . '|' . $row->Users_ID;
					array_push($data_new, $name);	
				}
			}
				echo json_encode($data_new);
				exit;
		 }

		 public function autocomplete_hloc()
		 {
			$q = $_POST['name_startsWith'];
	
			$data['key'] = trim($q);
			$result = $this->model_league->autocomplete_hloc($data);
			
			$data_new = array();
			if($result){
				foreach($result as $row){
					$name = $row->hcl_title.'|'.$row->hcl_id;
					array_push($data_new, $name);	
				}
			}
				echo json_encode($data_new);
				exit;
		 }

		public function homeloc_add()
		{
			$title	= $this->input->post('title');
			$add	= $this->input->post('add');
			$city	= $this->input->post('city');
			$state	= $this->input->post('state');
			$country = $this->input->post('country');
			$zip	= $this->input->post('zip');

			$data['title'] = $title;
			$data['add']   =   $add;
			$data['city']  =  $city;
			$data['state'] = $state;
			$data['country'] = $country;
			$data['zip']   = $zip;

			$event_location = $add . " " .$city . " " . $state . " " . $country;
			$data['latt']	= $this->get_lang_latt($event_location);
			$ins_location = $this->model_league->create_home_location($data);
			 
			echo $ins_location;
		}

		 public function printpdf($bracket_id)
		 {
			if(isset($_POST["print_draw"])) {

				//$data['tourn_det'] = $this->model_league->getonerow($this->input->post('tourn_id'));
		/*		
				//$get_bracket = $this->model_league->get_tourn_bracket();
				
				$data['bracket_id'] = $get_bracket['BracketID'];
				$data['get_bracket'] = $get_bracket;
				$data['get_tourn_matches'] = $this->model_league->get_tourn_matches($data);

				$data['results'] = $this->model_news->get_news();
//print_r($data['get_tourn_matches']);
				if($data['get_tourn_matches']->num_rows() != 0){
			
			$html=$this->load->view('view_bracket_print', $data, true);

			//this the the PDF filename that user will get to download
			$pdfFilePath = "tourn_brakcet.pdf";

			//load mPDF library
			$this->load->library('m_pdf');

			//generate the PDF from the given html
			$this->m_pdf->pdf->WriteHTML($html);

			//download it.
			$this->m_pdf->pdf->Output($pdfFilePath, "D");*/

			}
		 }

		 public function upload_pics_temp(){

			if($this->input->post('upload_image')){
			
				$files = $_FILES;
				$cpt = count($_FILES['userfile']['name']);
				for($i = 0; $i < $cpt; $i++)
				{
					echo $files['userfile']['name'][$i];
					$exif = exif_read_data($files['userfile']['tmp_name'][$i]);
					echo "<pre>";
					print_r($exif);
				}
			}
		 }

		 public function image_rotate_exif($filename){

			// Assuming that you store your file in this variable
				//$filename = "yourimagefile.jpg";
				$config = array();

				// Resize the image
				$this->load->library('image_lib');
				$config['image_library']	= 'gd2';
				$config['source_image']		= $filename;
				$config['new_image']		= $filename;

				// -- Check EXIF
				$exif = exif_read_data($config['source_image']);
				
				//echo "<pre>";
				//print_r($exif);

				if($exif && isset($exif['Orientation']))
				{
					$ort = $exif['Orientation'];

					if ($ort == 6 || $ort == 5)
						$config['rotation_angle'] = '270';
					if ($ort == 3 || $ort == 4)
						$config['rotation_angle'] = '180';
					if ($ort == 8 || $ort == 7)
						$config['rotation_angle'] = '90';
				}

				/*echo "<pre>";
				print_r($config);
				exit;*/

				$this->image_lib->initialize($config); 

				if(!$this->image_lib->rotate())
				{
					// Error Message here
					echo $this->image_lib->display_errors();
					$this->image_lib->clear();
					return 0;
				}
				else
				{
					$this->image_lib->clear();
					return 1;
				}
		 }

		 public function upload_pics()
		 {
			if($this->input->post('tourn_id')){
				$doc_root		= $_SERVER['DOCUMENT_ROOT'];

				$this->load->library('upload');
				$tourn_id		= $this->input->post('tourn_id');
				$tour_folder = $doc_root.'\tour_pictures\\'.$tourn_id.'';

				if (!file_exists($tour_folder)) {
					mkdir($tour_folder, 0777, true);
				}

				$files	= $_FILES;
				$cpt		= count($_FILES['userfile']['name']);
				for($i=0; $i<$cpt; $i++) {
				   $rand = md5(uniqid(rand(), true));

				   $format	=	explode('.',$files['userfile']['name'][$i]);
                   $format	=	end($format);
				
				   $re		=	md5($files['userfile']['name'][$i]);
				   $re_name =	time()."_".substr($re, 0, 8); 

				   //echo $re_name;exit;

					$_FILES['userfile']['name']		= $re_name.'.'.$format;
					$_FILES['userfile']['type']			= $files['userfile']['type'][$i];
					$_FILES['userfile']['tmp_name']	= $files['userfile']['tmp_name'][$i];
					$_FILES['userfile']['error']			= $files['userfile']['error'][$i];
					$_FILES['userfile']['size']			= $files['userfile']['size'][$i];
					//echo $files['userfile']['width'][$i]."<br>";
					//echo $files['userfile']['height'][$i]; exit;
					$fileName = 'userfile';

					$config = array(
				    'upload_path'		=> "./tour_pictures/$tourn_id/",
					'allowed_types'		=> "gif|jpg|png|jpeg",
					'overwrite'				=> TRUE,
					'max_size'				=> "10000", // Can be set to particular file size, here it is ~10 MB(2048 Kb)
					'max_height'			=> "8000",
					'max_width'			=> "10000");

				   $this->load->library('upload',$config);  
				   $this->upload->initialize($config);

				   //echo $fileName;
				   //exit;

				   if($this->upload->do_upload($fileName)){
					    $upload_data  = $this->upload->data();
					    $thumb_folder = $doc_root.'\tour_pictures\\'.$tourn_id.'\thumbs';

						if (!file_exists($thumb_folder)) {
							mkdir($thumb_folder, 0777, true);
						}
					//	echo "<pre>"; print_r($upload_data);
					//echo "wdith: ".$upload_data['image_width']."<br>";
					//echo "height: ".$upload_data['image_height']."<br>"; 
					//echo "full_path: ".$upload_data['full_path']."<br>"; 
					
					//exit;

						// orientation
						$this->image_rotate_exif($upload_data['full_path']);

						///resize image code starts ....
                        $resize_conf = array(
											'image_library'	=> 'gd2',
											'maintain_ratio' =>  FALSE,
											'upload_path'	=> "./tour_pictures/$tourn_id/thumbs/",
											'source_image' => $upload_data['full_path'], 
											//'new_image'	=> './tour_pictures/$tourn_id/thumbs/'.$upload_data['file_name'],
											'new_image'		=> $upload_data['file_path'].'thumbs/'.$upload_data['file_name'],
											'quality'				=> '30%',
											'width'				=> $upload_data['image_width'],
											'height'				=> $upload_data['image_height']
											/*'maintain_ratio' => TRUE*/
											);

					$this->load->library('image_lib');
					$this->image_lib->initialize($resize_conf);
					
					// do it!
					if (!$this->image_lib->resize()){
						// if got fail.
						$error['resize'] = $this->image_lib->display_errors();
						//echo "error occured";
						//exit;
					}
					else{
						$this->image_rotate_exif($resize_conf['new_image']);

						$data_to_store['userfile']	= $upload_data['file_name'];						
						$data1['userfile']			= $upload_data['file_name'];
						//exit;
					}
				  
				   ///resize image code ends ....

				   //$this->upload->do_upload($fileName);
				   $fileName = $_FILES['userfile']['name'];

				   $this->model_league->insert_tourn_images($fileName);
				}
			 }
			 redirect("league/$tourn_id");
			 //echo "Success";
		  }
		  else{
			  echo "Invalid Access!";
		  }
		}

		 /* public function upload_pics()
		  {
		 
			if($this->input->post('upload_image')){

				$this->load->library('upload');
				$tourn_id = $this->input->post('tourn_id');

				$tour_folder = 'C:\inetpub\wwwroot\a2msports\tour_pictures\\'.$tourn_id.'';

				if (!file_exists($tour_folder)) {
					mkdir($tour_folder, 0777, true);
				}

				$files = $_FILES;
				$cpt = count($_FILES['userfile']['name']);
				for($i=0; $i<$cpt; $i++)
				{
				 $rand = md5(uniqid(rand(), true));

				$format=explode('.',$files['userfile']['name'][$i]);
                $format=end($format);
				//echo $format;

					$_FILES['userfile']['name']= time().md5($files['userfile']['name'][$i]).'.'.$format;
					$_FILES['userfile']['type']= $files['userfile']['type'][$i];
					$_FILES['userfile']['tmp_name']= $files['userfile']['tmp_name'][$i];
					$_FILES['userfile']['error']= $files['userfile']['error'][$i];
					$_FILES['userfile']['size']= $files['userfile']['size'][$i];

					$fileName = 'userfile';

					$config = array(
				    'upload_path' => "./tour_pictures/$tourn_id/",
					'allowed_types' => "gif|jpg|png|jpeg|pdf",
					'overwrite' => TRUE,
					'max_size' => "10000", // Can be set to particular file size , here it is ~10 MB(2048 Kb)
					'max_height' => "5000",
					'max_width' => "8000");

				$this->load->library('upload',$config);  
				$this->upload->initialize($config);

				//	$this->upload->initialize($this->set_upload_options($tourn_id));
				$this->upload->do_upload($fileName);
				$fileName = $_FILES['userfile']['name'];

				$this->model_league->insert_tourn_images($fileName);
				}
			
				 redirect("league/view/$tourn_id");
			}
		 }*/
 
		
		 public function rotate_image()
		 {

		   if($_POST){
		   //if($this->input->post("rotate$row_id")){

				foreach($_POST as $name => $content) { // Most people refer to $key => $value
				   if($content=="rotate")
					{
					   $row_id = $name;
					   $row_id = substr($row_id,-1);
				    }
				 }
		  
				 $filename	= $this->input->post("filename$row_id");
				 $angle		= $this->input->post("angle$row_id");
				 $tourn_id	= $this->input->post("tourn_id$row_id");
				 $dir		= $this->input->post("dir$row_id");
				 $out		= "";

				 $dir_angle = $dir.$angle;
				
				if($filename != ""){
			
					$data['tour_details']	= $this->model_league->getonerow($tourn_id);
				    $data['results']		= $this->model_news->get_news();
					$data['images']			= $this->model_league->get_individual_tourn_images($tourn_id);

					$image_name = substr(strrchr($filename, "/"), 1);
					//$saveto = $_SERVER['DOCUMENT_ROOT'].'\a2msports\tour_pictures\'.$tourn_id.'"\'.$image_name;
					$doc_root = $_SERVER['DOCUMENT_ROOT'];

					$saveto =  $doc_root.'/tour_pictures/'.$tourn_id.'/'.$image_name;

					$this->RotateJpg($filename,$dir_angle,$saveto,$tourn_id);
				
				}
			}
		}


		 // Rotate Manipulation.
		public function RotateJpg($filename = '',$angle = 0,$savename = false,$tourn_id = '') {

				$size = getimagesize($filename); 

				switch ($size['mime']) { 
				case "image/gif": 
				 
						header('Content-Type: image/gif');
						// Load
						$source = imagecreatefromgif($filename);

						// Rotate
						$rotate = imagerotate($source, $angle, 0);
						//print_r($rotate);

						// Output
						if($savename == false) {
						imagegif($rotate);
						}
						else
						imagegif($rotate,$savename);
						// Free the memory
						imagedestroy($source);
						imagedestroy($rotate);

						redirect("league/$tourn_id","refresh");

				break;
				case "image/jpeg": 
						
						header('Content-type: image/jpeg');
						 
						// Load
						$source = imagecreatefromjpeg($filename);

						// Rotate
						$rotate = imagerotate($source, $angle, 0);
						
						// Output
						if($savename == false) {
							imagejpeg($rotate);
						}
						else
						imagejpeg($rotate,$savename);
						// Free the memory
						imagedestroy($source);
						imagedestroy($rotate);

						redirect("league/$tourn_id","refresh");

				break; 


				case "image/png": 
				//echo "Image is a png"; 

						header('Content-Type: image/png');
						
						// Your original file
						$source = imagecreatefrompng($filename);
						// Rotate
						$rotate  = imagerotate($source, $angle, 0);
						// If you have no destination, save to browser
						if($savename == false) {
						imagepng($rotate);
						}
						else
						// Save to a directory with a new filename
						imagepng($rotate,$savename);

						// Standard destroy command
						imagedestroy($source);
						imagedestroy($rotate);

						redirect("league/$tourn_id","refresh");

				break; 
				case "image/bmp": 
				//echo "Image is a bmp"; 
						
						header('Content-Type: image/bmp');
						// Your original file
						$source = imagecreatefrombmp($filename);
						// Rotate
						$rotate  = imagerotate($source, $angle, 0);
						// If you have no destination, save to browser
						if($savename == false) {
						
						imagebmp($rotate);
						}
						else
						// Save to a directory with a new filename
						imagebmp($rotate,$savename);

						// Standard destroy command
						imagedestroy($source);
						imagedestroy($rotate);

						redirect("league/$tourn_id","refresh");
						
				break;
				default:
					echo "Invalid Image file";
			    break;

			 }
		 }
		
		 public function set_upload_options($tourn_id)
		 { 
		 
			//$tour_folder = 'C:\inetpub\wwwroot\a2msports\tour_pictures\\'.$tourn_id.'\\';
			$doc_root = $_SERVER['DOCUMENT_ROOT'];
			$tour_folder = $doc_root.'/tour_pictures/'.$tourn_id.'/';

			$this->upload_config['upload_path'] = $tour_folder;
		  // upload an image options
				 $config = array();
				 $config['upload_path'] = $tour_folder; //give the path to upload the image in folder
				 $config['allowed_types'] = 'gif|jpg|png';
				 $config['max_size'] = '20000';
				 $config['overwrite'] = TRUE;
		    
			     return $config;
		 }


		 public function gallery()
		 {
			
			$data['tourn_ids'] = $this->model_league->get_main_tourn_ids();   //from Tournament_images table
			$data['tourn_images'] = $this->model_league->get_admin_tourn_images($data['tourn_ids']);
			$data['results'] = $this->model_news->get_news();

	
			$this->load->view('includes/header');
			$this->load->view('view_tournament_images',$data);
			$this->load->view('includes/view_right_column',$data);
			$this->load->view('includes/footer');
		 }

		
		 public function images($tourn_id)
		 {
			
			$tourn_det = $this->model_league->getonerow($tourn_id);

			$data['tourn_title'] = $tourn_det->tournament_title;
			$data['images'] = $this->model_league->get_individual_tourn_images($tourn_id);
			
			$data['results'] = $this->model_news->get_news();
	
			$this->load->view('includes/header');
			$this->load->view('view_tourn_individual_images',$data);
			$this->load->view('includes/footer');
		 }

		public function get_tour_row_info(){
		$row_id = $this->input->post('row_id');
		$res = $this->model_league->get_tour_row_info($row_id);

		$get_user1 = $this->general->get_user($res['Player1']);
		$get_user2 = $this->general->get_user($res['Player2']);

		$get_user_part1 = array('Firstname'=>"",'Lastname'=>"");
		$get_user_part2 = array('Firstname'=>"",'Lastname'=>"");

		if($res['Player1_Partner']){
		$get_user_part1 = $this->general->get_user($res['Player1_Partner']);
		$get_user_part2 = $this->general->get_user($res['Player2_Partner']);
		}

		echo $res['Tourn_match_id']."#".$res['BracketID']."#".$res['Tourn_ID']."#".$res['Round_Num']."#".$res['Match_Num']."#".$res['Player1']."#".$res['Player2']."#".$res['Player1_Partner']."#".$res['Player2_Partner']."#".$res['Player2_Partner']."#".$get_user1['Firstname']." ".$get_user1['Lastname']."#".$get_user2['Firstname']." ".$get_user2['Lastname']."#".$get_user_part1['Firstname']." ".$get_user_part1['Lastname']."#".$get_user_part2['Firstname']." ".$get_user_part2['Lastname']."#".$res['Player1_Score']."#".$res['Player2_Score']."#".$res['Match_Date'];
		}

		 public function get_images($tourn_id){
			  return $this->model_league->get_individual_tourn_images($tourn_id);
		 }

		 public function get_gallery($tourn_id = '')
	     {
			$tourn_id = $this->input->post("tourn_id");

			$data['tour_details'] = $this->model_league->getonerow($tourn_id);
			$data['results'] = $this->model_news->get_news();
		    $data['get_images'] = $this->model_league->get_individual_tourn_images($tourn_id);

			$this->load->view('view_gallery_tournament',$data);
		 }

		 public function double_players_change()
		 {
			$upd_partners = $this->model_league->update_doubles_partner();

			$data['tourn_partner_names'] = $upd_partners;
			$data['event']				 = $this->input->post('event');

			$this->load->view('view_dbl_partner_ajax',$data);
			exit;
		 }

		 public function double_players_change_nopartner()
		 {
			$upd_partners = $this->model_league->update_doubles_partner_nopartner();

			$data['tourn_partner_names'] = $upd_partners;
			$data['event']				 = $this->input->post('event');

			$this->load->view('view_dbl_partner_ajax',$data);
			exit;
		 }

		 public function flyer($tid)
		 {
			$data['tour_details'] = $this->model_league->getonerow($tid);
			$data['results'] = $this->model_news->get_news();

			//$this->load->library('Qrstr');
			//$qrcode = new QRcode();	
			//$xyz = $qrcode->png('http://a2msports.com', "base_url()org_logos/filename.png");
			
			//echo "dfdsf ".$xyz;
			//exit;
			$this->load->view('flyer',$data);
		 }

		 public function scorecard($tid)
		 {
			$data['tour_details']	= $this->model_league->getonerow($tid);
			$data['team_info']		= $this->model_league->get_team_reg($this->logged_user, $tid);
			$this->load->view('scorecard', $data);
		 }

		 public function terms_conditions()
		 {	
			$this->load->view('view_terms_conditions');
		 }

		 public function medical_form()
		 {	
			$this->load->view('view_medical_release');
		 }

		 public function fee_pay($tid)
		 {
			// echo "<pre>"; print_r($this->session->userdata); exit;
			 if($tid != $this->session->userdata('tourn_id_fee_pay') 
				 and !$this->session->userdata('tour_per_player_fee') 
				 and !$this->session->userdata('tour_reg_team_id')){
						echo "Oops, Something went wrong! Please contact admin@a2msports.com";
						exit;
			 }

			 $tour_det = $this->model_league->getonerow($tid);

			if($this->session->userdata('tour_per_player_fee') > 0){
				$reg_userid		= $this->logged_user;
				$reg_teamid		= $this->session->userdata('tour_reg_team_id');
				
			$paypal_id		= PAYPAL_ID;
			$currency_code  = 'USD';

			if($tour_det->Merchant_Paypal){
				$get_merchant = $this->model_league->get_pp_merchant($tour_det->Merchant_Paypal);

				if($get_merchant){
					$paypal_id		= $get_merchant['paypal_merch_id'];
					if($get_merchant['currency_format']){
					$currency_code  = $get_merchant['currency_format'];
					}
				}
			}

				//Set variables for paypal form
				$paypalURL = PAYPAL_URL; //test PayPal api url
				$paypalID  = $paypal_id; //business email

				$returnURL = base_url().'paypal/pay_success?league='.$tid.'&team='.$reg_teamid.'&player='.$reg_userid; //payment success url
				$cancelURL = base_url().'paypal/pay_cancel'; //payment cancel url
				$notifyURL = base_url().'ipn'; //ipn url
				//get particular product data
				//$product = $this->model_league->getonerow($tid);
				//$userID = 1; //current user id
				$logo = base_url().'images/logo.png';
				
				$this->paypal_lib->add_field('business', $paypalID);
				$this->paypal_lib->add_field('return', $returnURL);
				$this->paypal_lib->add_field('cancel_return', $cancelURL);
				$this->paypal_lib->add_field('notify_url', $notifyURL);
				$this->paypal_lib->add_field('tourn_id', $tid);
				$this->paypal_lib->add_field('player', $reg_userid);
				$this->paypal_lib->add_field('item_number',  $reg_teamid);
				$this->paypal_lib->add_field('item_name',  $tour_det->tournament_title);
				$this->paypal_lib->add_field('amount', $this->session->userdata('tour_per_player_fee'));        
				$this->paypal_lib->image($logo);
				
				$this->paypal_lib->paypal_auto_form();
			}
			else{
				echo "Invalid Request!";
				exit;
			}
		 }


		 public function paytm_paynow($tid)
		 {
			// echo "<pre>"; print_r($this->session->userdata); exit;
			 if($tid != $this->session->userdata('tourn_id_fee_pay') 
				 and !$this->session->userdata('tour_per_player_fee') 
				 and !$this->session->userdata('tour_reg_team_id')){
						echo "Oops, Something went wrong! Please contact admin@a2msports.com";
						exit;
			 }

			$tour_det  = $this->model_league->getonerow($tid);

			if($tour_det->Merchant_Paytm){
				$get_merchant = $this->model_league->get_paytm_merchant($tour_det->Merchant_Paytm);

				$PAYTM_MERCHANT_MID = "{$get_merchant['paytm_merch_id']}";
				$PAYTM_MERCHANT_KEY = "{$get_merchant['paytm_merchant_key']}"; 
				$PAYTM_CALLBACK_URL_UPDATED = base_url()."paytm/pay_success"; 
			}

			if($this->session->userdata('tour_per_player_fee') > 0){
				$reg_team		= $this->session->userdata('tour_reg_team_id');
				$reg_user		= $this->logged_user;

				$arr = array('paytm_session' => 
							array('tourn_id' => $tid,
								  'team'	 => $reg_team,
								  'reg_user' => $reg_user
							)
					   );
					$this->session->unset_userdata('paytm_session');
					$this->session->set_userdata($arr);

		/* ********************************* */
		 require_once(APPPATH . "/third_party/paytm/config_paytm.php");
		 require_once(APPPATH . "/third_party/paytm/encdec_paytm.php");

		 $paramList["MID"]			= PAYTM_MERCHANT_MID;
		 $paramList["ORDER_ID"]		= $tid.'_'.$reg_team.'_'.$reg_user.'_'.rand(1,10000000);
		 $paramList["CUST_ID"]		= $this->logged_user;
		 $paramList["INDUSTRY_TYPE_ID"] = 'Retail';
		 $paramList["CHANNEL_ID"]	= 'WEB';
		 $paramList["TXN_AMOUNT"]	= $this->session->userdata('tour_per_player_fee');
		 $paramList["WEBSITE"]		= PAYTM_MERCHANT_WEBSITE;
		 $paramList["CALLBACK_URL"] = PAYTM_CALLBACK_URL;

/* ***************************** */
 header("Pragma: no-cache");
 header("Cache-Control: no-cache");
 header("Expires: 0");

 // following files need to be included

 $checkSum  = "";
// $paramList = array();

// Create an array having all required parameters for creating checksum.

 /*
 $paramList["MSISDN"] = $MSISDN; //Mobile number of customer
 $paramList["EMAIL"] = $EMAIL; //Email ID of customer
 $paramList["VERIFIED_BY"] = "EMAIL"; //
 $paramList["IS_USER_VERIFIED"] = "YES"; //
 */

//Here checksum string will return by getChecksumFromArray() function.
/*echo "<pre>";
print_r($paramList);
exit;*/
 $checkSum = getChecksumFromArray($paramList, PAYTM_MERCHANT_KEY);
//echo $checkSum;
//exit;
 echo "<html>
<head>
<title>Merchant Check Out Page</title>
</head>
<body>
    <center><h1>Please do not refresh this page...</h1></center>
        <form method='post' action='".PAYTM_TXN_URL."' name='f1'>
<table border='1'>
 <tbody>";

 foreach($paramList as $name => $value) {
 echo '<input type="hidden" name="'.$name.'" value="'.$value.'" />';
 }

 echo "<input type='hidden' name='CHECKSUMHASH' value='".$checkSum."' />
 </tbody>
</table>
<script type='text/javascript'>
document.f1.submit();
</script>
</form>
</body>
</html>";

		/* ********************************* */
			}
			else{
				echo "Invalid Request!";
				exit;
			}
		 }


		public function test_func1($tid){
			/*echo "<pre>";
			echo "test";
			print_r($this->session->all_userdata());
			exit;*/
		}

		public function test_func($tid){
			$tour_det  = $this->model_league->getonerow($tid);
			
			$tsize	    = $this->input->post('tshirt_size');
			$coup_code  = $this->input->post('coup_code');
			$coup_disc  = $this->input->post('coup_disc');
			$txt_amount = $this->input->post('tour_fee');

			if($tour_det->tournament_format != 'Teams' and $tour_det->tournament_format != 'TeamSport'){
			    $data				   = $this->Get_Events(); 
				$partners			   = $this->input->post('partners');
				$data['json_partners'] = json_encode($partners);
			}
			else{
				 $levels  = $this->input->post('level');
				 $age_grp = $this->input->post('age_group');
				 $data['json_levels'] = $levels;
				 $data['json_ag']	  = $age_grp;
			}

			$note_to_admin = $this->input->post('note_to_admin');
	
		   if($tour_det->Merchant_Paytm){
				$merch_paytm_id = $tour_det->Merchant_Paytm;
		   }
		   else{
				$merch_paytm_id = 1;
		   }
			 $get_merchant=$this->model_league->get_paytm_merchant($merch_paytm_id);

						if($get_merchant){
							$paypal_id		= $get_merchant['paytm_merch_id'];
							if($get_merchant['currency_format']){
							$currency_code  = $get_merchant['currency_format'];
							}
						}
						/*echo $get_merchant['paytm_merchant_key'];
						exit;*/
						/*define('PAYTM_MERCHANT_KEY', $get_merchant['paytm_merchant_key']); 
						define('PAYTM_MERCHANT_MID', $get_merchant['paytm_merch_id']);*/
						$PAYTM_MERCHANT_MID = "{$get_merchant['paytm_merch_id']}";
						$PAYTM_MERCHANT_KEY = "{$get_merchant['paytm_merchant_key']}"; 
			
				//session_start();

				if($tour_det->tournament_format == 'Teams' || $tour_det->tournament_format == 'TeamSport'){
					$ttype			= 'Teams';
					$reg_user		= $this->logged_user;
					$reg_team		= $this->input->post('team');
					$reg_team_players = json_encode($this->input->post('sel_team_player'));

					$age_group		= json_encode($age_grp);
					$level			= json_encode($levels);
					$hc_loc_id		= $this->input->post('hc_loc_id');

					$arr = array('paytm_session' => 
								array('tourn_id' => $tid,
									  'team'	 => $reg_team,
									  'reg_user' => $reg_user,
									  'team_players' => $reg_team_players,
									  'age_group' => $age_group,
									  'level'	  => $level,
									  'hc_loc'	  => $hc_loc_id,
									  'ttype'	  => $ttype,
									  'tsize'	  => $tsize,
									  'coup_code' => $coup_code,
									  'coup_disc' => $coup_disc,
									  'note_to_admin' => $note_to_admin
								)
						   );
					$temp_arr = array('paytm_session1' => 'test');
					//$this->session->unset_userdata('paytm_session');
					$this->session->set_userdata($arr);
					$this->session->set_userdata($temp_arr);
					//$_SESSION['paytm_session'] = '3432';
				}
				else{
					$ttype			= 'Indv';
					$reg_userid		= $this->logged_user;
					$age_group		= $data['json_ag'];
					$match_types	= $data['json_formats'];
					$db_partner		= $this->input->post('created_users_id');
					$md_partner		= $this->input->post('created_users_id1');
					$level			= $data['json_levels'];
					$partners		= $data['json_partners'];
					$hc_loc_id		= $this->input->post('hc_loc_id');
                    $reg_events     = json_encode($this->input->post('events'));
					//Set variables for paypal form
				//echo $level;
				//exit;
					$arr = array('paytm_session' => 
								array('tourn_id'  => $tid,
									  'player'	  => $reg_userid,
									  'age_group' => $age_group,
									  'mtypes'	  => $match_types,
									  'partners'  => $partners,
									  'level'	  => $level,
									  'hc_loc'	  => $hc_loc_id,
									  'ttype'	  => $ttype,
									  'tsize'	  => $tsize,
									  'coup_code' => $coup_code,
									  'coup_disc' => $coup_disc,
									  'events'    => $reg_events,
									  'note_to_admin' => $note_to_admin
								)
						   );

					$this->session->unset_userdata('paytm_session');
					$this->session->unset_userdata('menu_items');

					$this->session->set_userdata($arr);
					//$this->session->set_userdata($arr1);
					//$this->session->set_userdata($temp_arr);
					//$_SESSION['paytm_session'] = '888788';
				}
				/*echo "<pre>";
				print_r(json_decode($this->session->userdata('paytm_session')));
				exit;*/
				//$PAYTM_CALLBACK_URL = $returnURL;

		// redirect('league/test_func1/'.$tid);
		 require_once(APPPATH . "/third_party/paytm/config_paytm.php");
		 require_once(APPPATH . "/third_party/paytm/encdec_paytm.php");

		 $paramList["MID"]		 = PAYTM_MERCHANT_MID;
		 $paramList["ORDER_ID"] = $tid.'_'.$this->logged_user.'_'.rand(1,10000000);
		// $paramList["ORDER_ID"]  = $tid.'_'.$this->logged_user;
		 $paramList["CUST_ID"]   = $this->logged_user;
		 $paramList["INDUSTRY_TYPE_ID"] = 'Retail';
		 $paramList["CHANNEL_ID"] = 'WEB';
		 $paramList["TXN_AMOUNT"] = $txt_amount;
		 $paramList["WEBSITE"]	  = PAYTM_MERCHANT_WEBSITE;
		 $paramList["CALLBACK_URL"] = PAYTM_CALLBACK_URL;

/* ***************************** */
 header("Pragma: no-cache");
 header("Cache-Control: no-cache");
 header("Expires: 0");

 // following files need to be included

 $checkSum  = "";
// $paramList = array();

 $CUST_ID    = $this->logged_user;
 $TXN_AMOUNT = $this->input->post('tour_fee');

// Create an array having all required parameters for creating checksum.

 /*
 $paramList["MSISDN"] = $MSISDN; //Mobile number of customer
 $paramList["EMAIL"] = $EMAIL; //Email ID of customer
 $paramList["VERIFIED_BY"] = "EMAIL"; //
 $paramList["IS_USER_VERIFIED"] = "YES"; //
 */

//Here checksum string will return by getChecksumFromArray() function.
/*echo "<pre>";
print_r($paramList);
exit;*/
 $checkSum = getChecksumFromArray($paramList, PAYTM_MERCHANT_KEY);
//echo $checkSum;
//exit;

/*echo "<pre>";
print_r($this->session->all_userdata());
exit;*/

 echo "<html>
<head>
<title>Merchant Check Out Page</title>
</head>
<body>
    <center><h1>Please do not refresh this page...</h1></center>
        <form method='post' action='".PAYTM_TXN_URL."' name='f1'>
<table border='1'>
 <tbody>";

 foreach($paramList as $name => $value) {
 echo '<input type="hidden" name="'.$name.'" value="'.$value.'" />';
 }

 echo "<input type='hidden' name='CHECKSUMHASH' value='".$checkSum."' />
 </tbody>
</table>
<script type='text/javascript'>
document.f1.submit();
</script>
</form>
</body>
</html>";

		}

		 public function buy($tid)
		 {
			$tour_det  = $this->model_league->getonerow($tid);
			//if($tid == 3483){
			//	echo "<pre>"; print_r($_POST); exit;
			//}
			if($this->input->post('tour_fee') == '' and $tour_det->Tournamentfee == 1){
					echo "Sorry, something went wrong! Please contact <a href='mailto:admin@a2msports.com'> Admin </a>. Thank you";
					exit;
			}

			 if($this->input->post('tour_fee') != $this->session->userdata('tour_reg_fee') and 
				 ($tid == $this->session->userdata('reg_tour_id')) and $this->input->post('tour_fee') == ''){
				echo "Sorry, something went wrong! Please contact <a href='mailto:admin@a2msports.com'> Admin </a>. Thank you";
				exit;
			 }

			 if(!$this->logged_user){
				echo "Your Logged Session Timeout! Please <a href='".base_url()."login'>Login</a> and Register again. Thank you.";
				exit;
			 }

			if($tour_det->Is_League == 1){
				//echo "<pre>"; print_r($_POST);	//exit;
			}


			if($this->input->post('usatt_member_id')){
				$member_id  = $this->input->post('usatt_member_id');
				//$rating	= $this->input->post('usatt_member_rating');

				$this->model_league->insert_usatt_membership($member_id);
			}

			//$tour_det  = $this->model_league->getonerow($tid);

			if($tour_det->Merchant_Paytm != '' and $tour_det->Merchant_Paytm != NULL and $this->input->post('tour_fee') > 0) {
				$this->test_func($tid);
				exit;
			}

			$paypal_id = PAYPAL_ID;
			$currency_code = 'USD';

			if($tour_det->Merchant_Paypal){
				$get_merchant = $this->model_league->get_pp_merchant($tour_det->Merchant_Paypal);

				if($get_merchant){
					$paypal_id		= $get_merchant['paypal_merch_id'];
					if($get_merchant['currency_format']){
					$currency_code  = $get_merchant['currency_format'];
					}
				}
			}
			else if($tour_det->TournamentCountry == 'India' and $this->input->post('tour_fee') > 0){
				$this->test_func($tid);
				exit;
			}
			
			//if($tour_det->TournamentCountry == 'India')
			//$currency_code = 'INR';


			$tsize			= $this->input->post('tshirt_size');
			$coup_code	= $this->input->post('coup_code');
			$coup_disc	= $this->input->post('coup_disc');

			if($tour_det->tournament_format != 'Teams' and $tour_det->tournament_format != 'TeamSport'){
			    $data				    = $this->Get_Events(); 
				$partners			= $this->input->post('partners');
				$data['json_partners'] = json_encode($partners);
			}
			else{
				 $levels		= $this->input->post('level');
				 $age_grp	= $this->input->post('age_group');

				 $data['json_levels'] = $levels;
				 $data['json_ag']		= $age_grp;
			}
		
			$data['coup_code']	= $coup_code;
			$data['coup_disc']	= $coup_disc;

			$data['school_info'] = $school_info = ($this->input->post('txt_school')) ? $this->input->post('txt_school') : "";

			$note_to_admin = $this->input->post('note_to_admin');

			if($this->input->post('tour_fee') > 0){
			
				if($tour_det->tournament_format == 'Teams' || $tour_det->tournament_format == 'TeamSport'){
					$ttype			= 'Teams';
					$reg_user		= $this->logged_user;
					$reg_team		= $this->input->post('team');
					$reg_team_players = json_encode($this->input->post('sel_team_player'));

					$age_group		= json_encode($age_grp);
					$level			= json_encode($levels);
					$hc_loc_id		= $this->input->post('hc_loc_id');

					//Set variables for paypal form
					$paypalURL = PAYPAL_URL; //PayPal api url
					$paypalID  = $paypal_id;  //business email

					$returnURL = base_url().'paypal/success?tourn_id='.$tid.'&team='.$reg_team.'&reg_user='.$reg_user.'&team_players='.$reg_team_players.'&age_group='.$age_group.'&level='.$level.'&hc_loc='.$hc_loc_id.'&ttype='.$ttype.'&tsize='.$tsize.'&coup_code='.$coup_code.'&coup_disc='.$coup_disc.'&nte_to_admin='.$note_to_admin; 
					//payment success url

					$cancelURL = base_url().'paypal/cancel'; //payment cancel url
					$notifyURL = base_url().'paypal/ipn';	 //ipn url
				}
				else{
					$sess_data = array();
					
					$ttype			= 'Indv';
					$reg_userid		= $this->logged_user;
					$age_group		= $sess_data['json_ag']			= $data['json_ag'];
					$match_types	= $sess_data['json_formats']	= $data['json_formats'];
					$db_partner		= $this->input->post('created_users_id');
					$md_partner		= $this->input->post('created_users_id1');
					$level			= $sess_data['json_levels']		= $data['json_levels'];
					$partners		= $sess_data['json_partners']	= $data['json_partners'];
					$hc_loc_id		= $sess_data['hc_loc_id']		= $this->input->post('hc_loc_id');
                    $reg_events  = $sess_data['events']			= json_encode($this->input->post('events'));
					$tsize			= $sess_data['tshirt_size']		= $this->input->post('tshirt_size');
					$coup_code	= $sess_data['coup_code']		= $this->input->post('coup_code');
					$coup_disc	= $sess_data['coup_disc']		= $this->input->post('coup_disc');

					if($tour_det->Is_League == 1){
						$occr_ids = array();

						$post_occr = $this->input->post('occr_ids');
						if($post_occr){
							foreach($post_occr as $oc){
								$temp = explode(':', $oc);
								$occr_ids[] = $temp[0];
							}
						}

					$occr_json = $sess_data['occr_json'] = json_encode($occr_ids);
						$this->session->unset_userdata('occr_json');
					}

					//Set variables for paypal form
					$paypalURL = PAYPAL_URL; //PayPal api url
					$paypalID  = $paypal_id;  //business email

						$this->session->unset_userdata('json_ag');
						$this->session->unset_userdata('json_formats');
						$this->session->unset_userdata('json_levels');
						$this->session->unset_userdata('json_partners');
						$this->session->unset_userdata('hc_loc_id');
						$this->session->unset_userdata('events');
						$this->session->unset_userdata('tshirt_size');
						$this->session->unset_userdata('coup_code');
						$this->session->unset_userdata('coup_disc');

					$this->session->set_userdata($sess_data);

					/*echo "<pre>";
					print_r($this->session->userdata('events'));
					exit;*/

				$est_usatt_rating = "";
				if($this->input->post('new_usatt_opt')){
				$est_usatt_rating = $this->input->post('est_usatt_rating');
				}

					$returnURL = base_url().'paypal/success?tourn_id='.$tid.'&player='.$reg_userid.'&age_group='.$age_group.'&mtypes='.$match_types.'&partners='.$partners.'&level='.$level.'&hc_loc='.$hc_loc_id.'&ttype='.$ttype.'&tsize='.$tsize.'&coup_code='.$coup_code.'&coup_disc='.$coup_disc.'&events='.$reg_events.'&occr='.$occr_json.'&nte_to_admin='.$note_to_admin.'&school_info='.$school_info.'&est_usatt_rating='.$est_usatt_rating;  
					//payment success url
					//echo $returnURL;
					//exit;
					$cancelURL = base_url().'paypal/cancel'; //payment cancel url
					$notifyURL = base_url().'paypal/ipn';	 //ipn url
				}

				$logo = base_url().'images/logo.png';
				
				$this->paypal_lib->add_field('business', $paypalID);
				$this->paypal_lib->add_field('return', $returnURL);
				$this->paypal_lib->add_field('cancel_return', $cancelURL);
				$this->paypal_lib->add_field('currency_code', $currency_code);
				$this->paypal_lib->add_field('notify_url', $notifyURL);
				$this->paypal_lib->add_field('tourn_id', $tid);
				//$this->paypal_lib->add_field('player', $this->logged_user);
				$this->paypal_lib->add_field('on0', $this->logged_user);
				$this->paypal_lib->add_field('on1', $reg_events);

				if($tour_det->Is_League == 1){
				$this->paypal_lib->add_field('on2', $occr_json);
				}
				else if($this->input->post('new_usatt_opt')){
				$this->paypal_lib->add_field('on2', $this->input->post('est_usatt_rating'));
				}

				$this->paypal_lib->add_field('item_number',  $tid);
				$this->paypal_lib->add_field('item_name',  $tour_det->tournament_title);
				$this->paypal_lib->add_field('amount', $this->input->post('tour_fee'));        
				$this->paypal_lib->image($logo);
				
				$this->paypal_lib->paypal_auto_form();

			 }
			 else if($this->input->post('tour_fee') == 0)   // Register Team or Player without Fee 
			 {
				if($tour_det->tournament_format == 'Teams' || $tour_det->tournament_format == 'TeamSport'){						
					$res = $this->model_league->reg_team_tourn_no_fee($data);
				}
				else{
					$res = $this->model_league->reg_tourn_no_fee($data);
				}

				if($res){

					$user_id	 = $this->logged_user;				
					$tourn_id	 = $this->input->post('id');		
					$partners	 = $this->input->post('partners');
					
						$sql = "SELECT * FROM users WHERE Users_ID = " . $user_id;
						$result = $this->db->query($sql);
						$row = $result->row();

						$user_categories = $this->model_league->get_reg_tourn_participants_levels($tourn_id,$user_id);

						$regevents = json_decode($user_categories['Reg_Events']);
						$event_format = $this->regenerate_events($regevents);

		                $categories = array();
                        $selected_events = array();
		        		//		echo "<pre>";print_r($ag_group1);
						//echo "<pre>";print_r($sp_levels1);		        
						foreach($event_format as $k => $val){
							$arr = explode('-', $k);
							$fr = $arr[2];
					      $categories[$fr][]=$val;
					      $selected_events[]=$k;
							    								
						}

					// Get WaitList Number //

			//echo "<pre>";print_r($selected_events);exit();
			if($tour_det->tournament_format != 'Teams' and $tour_det->tournament_format != 'TeamSport'){

			$tour_det	 = $this->model_league->getonerow($tourn_id);
			$reg_users = $this->get_reg_tourn_participants_new($tourn_id);
				foreach($selected_events as $evnt){
				   $users						= $this->in_array_r($evnt, $reg_users[0]);
				   $users_cnt[$evnt]	=	count($users);
				}

			$tourn_events_limit=json_decode($tour_det->Event_Reg_Limit, true);

				foreach ($tourn_events_limit as $event => $limit) {
					//$limits[]=array_key_exists($event, $users_cnt);
					if(array_key_exists($event, $users_cnt)){
						if($limit!=="" || $limit!=NULL){
			
							if($users_cnt[$event] > $limit){
								$waitlistres  = $this->model_league->GetWaitlistCount($tourn_id, $event);
								$waitlist		 =$waitlistres+1;
								$insert_res = $this->model_league->InsertWaitlistUsers($res, $tourn_id, $event, $waitlist);
							}
						}
					}
				}
			}
						//echo "<pre>";print_r($user_categories);	exit();
						$title		= $tour_det->tournament_title;
						$subject  = "Tournament Registration - A2MSports";
                        $user_reg_date=$user_categories['Reg_date'];
                        //$reg_date = date('d-m-Y', strtotime($user_reg_date));
                        $reg_date = date('m-d-Y h:i:s');
                        $data = array(
						'firstname'	=> $row->Firstname,
						'lastname'	=> $row->Lastname,
						'tourn_id'	=> $tourn_id,
						'date'      => $reg_date,
						'title'		=> $title,
						'categories' => $categories,
						'page'		=> 'Registration-Singles'
						);

						$userdat				= $this->get_username($tour_det->Usersid);
		                $tourn_admin_email		= $userdat['EmailID'];
		                $tourn_admin_firstname  = $userdat['Firstname'];
		                $tourn_admin_lastname   = $userdat['Lastname'];

						$tourn_admin_data = array(
						'firstname'			=> $row->Firstname,
						'lastname'			=> $row->Lastname,
						'admin_firstname'	=> $tourn_admin_firstname,
						'admin_lastname'	=> $tourn_admin_lastname,
						'date'				=> $reg_date,
						'tourn_id'			=> $tourn_id,
						'title'				=> $title,
						'categories'		=> $categories,
						'note_to_admin'		=> $note_to_admin,
						'page'				=> 'Send mail to tournament admin once user registration'
						);
						
						if($tourn_id != 3513){
						$this->email_to_player($row->EmailID, $subject, $data);
						$this->email_to_player($tourn_admin_email, $subject, $tourn_admin_data);
						}


				    if(in_array("Doubles", $this->input->post('mtype')) or in_array("Mixed", $this->input->post('mtype'))){

						$partner1_email="";
						$partner2_email="";
						
						$title = $tour_det->tournament_title;
                        $subject="Tournament Registration - A2MSports";

						if(!empty($partners)){
							foreach($partners as $event => $partner){
									$partner1_email			= "";
									$sess_user				= $this->session->userdata('user');
									$get_partner1_details	= $this->get_username($partner);
									$partner1_email			= $get_partner1_details['EmailID'];   //doubles partner
									$partner1_name			= $get_partner1_details['Firstname'] . " " . $get_partner1_details['Lastname'];  
									
									$data = array(
										'tourn_id'	=> $tourn_id,
										'partner1'	=> $partner1_name,
										'user'		=> $sess_user,
										'title'		=> $title,
										'event'		=> $event,
										'page'		=> 'Tourn-Reg-Doubles'
										);
									if($tourn_id != 3513){
									$this->email_to_player($partner1_email, $subject, $data);
									}
							}
						}

					}
						
					//$reg_suc = "You have successfully registered for this tournament.";
					$reg_suc = "5";

					$this->session->unset_userdata('tour_reg_fee');
					$this->session->unset_userdata('reg_tour_id');

						redirect("league/$tourn_id/$reg_suc");	

				}
			 }
			 else{
				echo "Invalid Request!";
			 }
		}

		 public function buy_more($tid)
		 {

			 if($this->input->post('tour_fee') != $this->session->userdata('tour_reg_fee') and ($tid == $this->session->userdata('reg_tour_id'))){
				echo "Sorry, something went wrong! Please contact <a href='mailto:admin@a2msports.com'> Admin </a>. Thank you";
				exit;
			 }

						$this->session->unset_userdata('json_ag');
						$this->session->unset_userdata('json_formats');
						$this->session->unset_userdata('json_levels');
						$this->session->unset_userdata('json_partners');
						$this->session->unset_userdata('hc_loc_id');
						$this->session->unset_userdata('events');
						$this->session->unset_userdata('tshirt_size');
						$this->session->unset_userdata('coup_code');
						$this->session->unset_userdata('coup_disc');

			$tour_det = $this->model_league->getonerow($tid);

			if($tour_det->tournament_format != 'Teams'){
			    $data = $this->Get_Events(); 
			  //  echo "<pre>"; print_r($data);exit();
			}

			if($this->input->post('tour_fee') > 0){
					$ttype			= 'Indv';
					$reg_userid		= $this->logged_user;
					$age_group		= $data['json_ag'];
					$match_types	= $data['json_formats'];
					//$db_partner		= $this->input->post('created_users_id');
					//$md_partner		= $this->input->post('created_users_id1');
					$level			= $data['json_levels'];
					$reg_events     = json_encode($this->input->post('events'));
					//$hc_loc_id		= $this->input->post('hc_loc_id');

					//Set variables for paypal form
					$paypalURL = PAYPAL_URL; //PayPal api url
					$paypalID = PAYPAL_ID;   //business email
					$currency_code = 'USD';

					if($tour_det->Merchant_Paypal){
						$get_merchant = $this->model_league->get_pp_merchant($tour_det->Merchant_Paypal);

						if($get_merchant){
							$paypalID		= $get_merchant['paypal_merch_id'];
							if($get_merchant['currency_format']){
							$currency_code  = $get_merchant['currency_format'];
							}
						}
					}

					/*$returnURL = base_url().'paypal/success?tourn_id='.$tid.'&player='.$reg_userid.'&age_group='.$age_group.'&mtypes='.$match_types.'&partner1='.$db_partner.'&partner2='.$md_partner.'&level='.$level.'&hc_loc='.$hc_loc_id.'&ttype='.$ttype.'&tsize='.$tsize;*/

					$returnURL = base_url().'paypal/msuccess?tourn_id='.$tid.'&player='.$reg_userid.'&age_group='.$age_group.'&mtypes='.$match_types.'&level='.$level.'&ttype='.$ttype.'&events='.$reg_events; 					
					//echo $this->input->post('tour_fee');
					//echo $returnURL;exit();
					//payment success url

					$cancelURL = base_url().'paypal/cancel'; //payment cancel url
					$notifyURL = base_url().'paypal/ipn_more';	 //ipn url
				

			$logo = base_url().'images/logo.png';
			
			$this->paypal_lib->add_field('business', $paypalID);
			$this->paypal_lib->add_field('return', $returnURL);
			$this->paypal_lib->add_field('cancel_return', $cancelURL);
			$this->paypal_lib->add_field('notify_url', $notifyURL);
			$this->paypal_lib->add_field('on0', $this->logged_user);
			$this->paypal_lib->add_field('on1', $reg_events);
			$this->paypal_lib->add_field('item_number',  $tid);
			$this->paypal_lib->add_field('item_name',  $tour_det->tournament_title);
			$this->paypal_lib->add_field('amount', $this->input->post('tour_fee'));        
			$this->paypal_lib->image($logo);
			
			$this->paypal_lib->paypal_auto_form();
			}
			 else if($this->input->post('tour_fee') == 0)   // Register without FEE functionality
			 {
				$res = $this->model_league->reg_more_tourn_no_fee($data);

				if($res){

					$user_id	 = $this->logged_user;				
					$tourn_id	 = $this->input->post('id');		
					//$match_types = json_encode($this->input->post('mtype'));
					
						$sql = "SELECT * FROM users WHERE Users_ID = " . $user_id;
						$result = $this->db->query($sql);
						$row = $result->row();

						$user_categories = $this->model_league->get_reg_tourn_participants_levels($tourn_id,$user_id);

			
		                $categories = array();
                        $selected_events = array();
		        		$regevents = json_decode($user_categories['Reg_Events']);
						$event_format = $this->regenerate_events($regevents);
                        foreach($event_format as $k => $val){
							$arr = explode('-', $k);
							$fr = $arr[2];
					        $categories[$fr][]=$val;
					        $selected_events[]=$k;
							    								
						}

					// Get WaitList Number //

			//echo "<pre>";print_r($selected_events);exit();

			$tour_det  = $this->model_league->getonerow($tourn_id);
			$reg_users = $this->get_reg_tourn_participants_new($tourn_id);

			foreach($selected_events as $evnt){
               $users = $this->in_array_r($evnt, $reg_users[0]);
               $users_cnt[$evnt]=count($users);
			}
			$tourn_events_limit = json_decode($tour_det->Event_Reg_Limit, true);

			foreach ($tourn_events_limit as $event => $limit) {
				//$limits[]=array_key_exists($event, $users_cnt);
				if(array_key_exists($event, $users_cnt)){
					if($limit!=="" || $limit!=NULL){
						if($users_cnt[$event] > $limit){
							$waitlistres = $this->model_league->GetWaitlistCount($tourn_id, $event);
							$waitlist=$waitlistres+1;
							$insert_res = $this->model_league->InsertWaitlistUsers($res, $tourn_id, $event, $waitlist);
						}
					}
				}
			}
						//echo "<pre>";print_r($user_categories);	exit();
						$title			= $tour_det->tournament_title;
						$subject	    = "Tournament Registration - A2MSports";
                        $user_reg_date  = $user_categories['Reg_date'];
                        //$reg_date = date('d-m-Y', strtotime($user_reg_date));
                        $reg_date		= date('m-d-Y h:i:s');

                        $data = array(
						'firstname'	=> $row->Firstname,
						'lastname'	=> $row->Lastname,
						'tourn_id'	=> $tourn_id,
						'date'      => $reg_date,
						'title'		=> $title,
						'categories' => $categories,
						'page'		 => 'Registration-Singles'
						);

						$userdat=$this->get_username($tour_det->Usersid);
		                $tourn_admin_email=$userdat['EmailID'];
		                $tourn_admin_firstname=$userdat['Firstname'];
		                $tourn_admin_lastname=$userdat['Lastname'];

						$tourn_admin_data = array(
						'firstname'	=> $row->Firstname,
						'lastname'	=> $row->Lastname,
						'admin_firstname'	=> $tourn_admin_firstname,
						'admin_lastname'	=> $tourn_admin_lastname,
						'date'      => $reg_date,
						'tourn_id'	=> $tourn_id,
						'title'		=> $title,
						'categories' => $categories,
						'note_to_admin' => $this->input->post('note_to_admin'),
						'page'		=> 'Send mail to tournament admin once user registration'
						);
						
						$this->email_to_player($row->EmailID, $subject, $data);
						$this->email_to_player($tourn_admin_email, $subject, $tourn_admin_data);

				    if(in_array("Doubles", $this->input->post('mtype')) or in_array("Mixed", $this->input->post('mtype'))){

						$partner1_email="";
						$partner2_email="";
						
						$title = $tour_det->tournament_title;
                        $subject="Tournament Registration - A2MSports";

						if($partner1){
							$sess_user				= $this->session->userdata('user');
							$get_partner1_details	= $this->get_username($partner1);
							$partner1_email			= $get_partner1_details['EmailID'];      //doubles partner
							$partner1_name			= $get_partner1_details['Firstname'] . " " . $get_partner1_details['Lastname'];  
							
							$data = array(
								'tourn_id'	=> $tourn_id,
								'partner1'	=> $partner1_name,
								'user'		=> $sess_user,
								'title'		=> $title,
								'page'		=> 'Tourn-Reg-Doubles'
							);
							
							$this->email_to_player($partner1_email, $subject, $data);
						}

						if($partner2){
							$sess_user2			  = $this->session->userdata('user');
							$get_partner2_details = $this->get_username($partner2);
							$partner2_email		  = $get_partner2_details['EmailID']; 
							$partner2_name		  = $get_partner2_details['Firstname'] . " " . $get_partner2_details['Lastname'];

							$data = array(
								'tourn_id' => $tourn_id,
								'partner2' => $partner2_name,
								'user2'	   => $sess_user2,
								'title'	   => $title,
								'page'	   => 'Tourn-Reg-Mixed'
							);
							
							$this->email_to_player($partner2_email, $subject, $data);
						}
					}
						
					//$reg_suc = "You have successfully registered for this tournament.";
					$reg_suc = "5";

					$this->session->unset_userdata('tour_reg_fee');
					$this->session->unset_userdata('reg_tour_id');

				/*	$data['reg_suc'] = "You have successfully registered for this tournament.";
					$data['tour_details'] = $this->model_league->getonerow($tourn_id);
					$data['results'] = $this->model_news->get_news();  */
				
					redirect("league/$tourn_id/$reg_suc");	
				}
			 }
			 else{
				echo "Invalid Request!";
			 }
		}

		public function check_edit_match($bracket_id, $match_num, $round, $draw_type, $tour_type)
		{
			return $this->model_league->check_edit_match($bracket_id, $match_num, $round, $draw_type, $tour_type);
		}

		public function cd_check_edit_match($bracket_id, $match_num, $round, $draw_type, $tour_type)
		{
			return $this->model_league->cd_check_edit_match($bracket_id, $match_num, $round, $draw_type, $tour_type);
		}

		/*public function compare_points_winp($a, $b)
		{
			if($a['points'] == $b['points']){
			  return $b['win_per'] - $a['win_per'];
			}
			else{
			  return $b['points'] - $a['points'];
			}
		}*/

	/*	private function sortCB(array $a, array $b)
		{//the array type hinting in arguments is optional
			$i = array_keys($a);//but highly recommended 
			$j = array_keys($b);
			if (end($i) === end($j))
			{
				return 0;
			}
			//replace '>' with '<' if you want to sort descending
			return (end($i) > end($j) ? 1 : -1);//this is ascending
		}*/

//		public function compareOrder($a, $b)
//		{
			/*if($a['points'] == $b['points']){
			  return $b['win_per'] - $a['win_per'];
			}
			else{
			  return $b['points'] - $a['points'];
			}*/
//			return number_format($b['win_per'], 2) - number_format($a['win_per'], 2);
//		}

/*
function compareOrder($a, $b) {  // commented to fix the 3460 issue
	$result = 0;
		if($a['points'] == $b['points']){
			if ($b['win_per'] > $a['win_per']) {
				$result = 1;
			}
			elseif ($b['win_per'] < $a['win_per']) {
				$result = -1;
			}
		}
		else{
			if ($b['points'] > $a['points']) {
				$result = 1;
			}
			elseif ($b['points'] < $a['points']) {
				$result = -1;
			}
		}

   return $result; 
   }
*/

function compareOrder($a, $b) {
	$result = 0;
		if($a['points'] == $b['points']){
			if ($b['win_per2'] > $a['win_per2']) {
				$result = 1;
			}
			elseif ($b['win_per2'] < $a['win_per2']) {
				$result = -1;
			}
		}
		else{
			if ($b['points'] > $a['points']) {
				$result = 1;
			}
			elseif ($b['points'] < $a['points']) {
				$result = -1;
			}
		}

   return $result; 
   }

		public function compareOrder2($a, $b)
		{
			if($a['tp'] == $b['tp']){
			  return $b['won'] - $a['won'];
			}
			else{
			  return $b['tp'] - $a['tp'];
			}
		}

		public function compareOrder3($a, $b)
		{
			if($a['points'] == $b['points']){
			  return $b['won'] - $a['won'];
			}
			else{
			  return $b['points'] - $a['points'];
			}
		}


function compareOrder4($a, $b) {
	$result = 0;
		if($a['points'] == $b['points']){
			if ($b['winper2'] > $a['winper2']) {
				$result = 1;
			}
			elseif ($b['winper2'] < $a['winper2']) {
				$result = -1;
			}
		}
		else{
			if ($b['points'] > $a['points']) {
				$result = 1;
			}
			elseif ($b['points'] < $a['points']) {
				$result = -1;
			}
		}

   return $result; 
   }

   public function compareDates($date1, $date2){
      if (strtotime($date1) < strtotime($date2))
         return 1;
      else if (strtotime($date1) > strtotime($date2))
         return -1;
      else
         return 0;
   }


		public function add_comments()
		{
				$comm = $this->input->post('com');
				$res = $this->model_league->insert_comment();

				// send email to players....	
				if($this->logged_user == $this->input->post('player1')){
					$player1_id = "";
					$player2_id = $this->input->post('player2');
					$player1_partner = $this->input->post('player1_partner');
					$player2_partner = $this->input->post('player2_partner');
				}
				else if($this->logged_user == $this->input->post('player2')){
					$player1_id = $this->input->post('player1');
					$player2_id = "";
					$player1_partner = $this->input->post('player1_partner');
					$player2_partner = $this->input->post('player2_partner');
				}
				else{
					$player1_id = $this->input->post('player1');
					$player2_id = $this->input->post('player2');
					$player1_partner = $this->input->post('player1_partner');
					$player2_partner = $this->input->post('player2_partner');
				}
				//echo $player2_id ."p2" .  $player1_partner ."p1_r".  $player2_partner . "p2_r";

				$get_player1_details = $this->get_username($player1_id);
				$player1_email = ($get_player1_details['EmailID'] != "") ? $get_player1_details['EmailID'] : $get_player1_details['AlternateEmailID'];

				$get_player2_details = $this->get_username($player2_id);
				$player2_email = ($get_player2_details['EmailID'] != "") ? $get_player2_details['EmailID'] : $get_player2_details['AlternateEmailID'];
						
				$get_partner1_details = $this->get_username($player1_partner);
				$partner1_email = ($get_partner1_details['EmailID'] != "") ? $get_partner1_details['EmailID'] : $get_partner1_details['AlternateEmailID'];    
									
				$get_partner2_details = $this->get_username($player2_partner);
				$partner2_email = ($get_partner2_details['EmailID'] != "") ?  $get_partner2_details['EmailID'] : $get_partner2_details['AlternateEmailID'];
				
				//echo $player2_email ."p2email    " .  $partner1_email ."p1_remail     ".  $partner2_email . "p2_remail ";
				//exit;

				$log_user = $this->get_username($this->logged_user);
				$reply_to = ($log_user['EmailID'] != "") ?  $log_user['EmailID'] : $log_user['AlternateEmailID'];
	
				$match_id	= $this->input->post('match_id');
				$tourn_id		= $this->input->post('tourn_id');
				
				$tourn_det	= $this->model_league->getonerow($tourn_id);   //tournament details
				$title			= $tourn_det->tournament_title;

				$this->load->library('email');
				$this->email->set_newline("\r\n");
						 
				$this->email->from(FROM_EMAIL, 'A2MSports');
				
				$to_addr = '';

				if($player1_email)
					$to_addr = $player1_email;

				if($player2_email)
					$to_addr .= " ".$player2_email;

				if($partner1_email)
					$to_addr .= " ".$partner1_email;

				if($partner2_email)
					$to_addr .= " ".$partner2_email;

					$to_addr = str_replace(" ", ",", trim($to_addr));
					
				$this->email->to($to_addr);
				$this->email->reply_to($reply_to);
				$this->email->subject("Message (" . $title . ") - A2MSports");

				$data = array(
							'title'				=> $title,
							'message'	=> $comm,
							'tourn_id'		=> $tourn_id,
							'page'			=> 'Tournament Match Comments'
							);

				$body = $this->load->view('view_email_template.php', $data, TRUE);

				$this->email->message($body);   

				if($to_addr)
				$this->email->send();

           ///  end of send email to players..

				$get_match_comments = $this->model_league->get_match_comments($match_id);

				foreach($get_match_comments as $comment){

					$name = $this->general->get_user($comment->Users_Id);
					$full_name = ucfirst($name['Firstname'])." ".ucfirst($name['Lastname']);

					$op .= "<div class='pull-left' style='margin-right:20px'><img style='width:50px !important; height:50px !important;' class='img-circle' src='".base_url()."profile_pictures/".$name['Profilepic']."' /></div>
					<div style='margin-top:5px'>
					<span style='font-weight:bold; color:#464646'>".$full_name."</span>
					<span style='font-size:11px; color:#959595'>".date("m/d/Y H:i", strtotime($comment->Comment_On))."</span>
					<div style='margin-top:5px;'>$comment->Comments</div>
					</div>
					<div style='clear:both; height:20px'></div>";
				}

				echo $op;
				//redirect("events/view/$ev_id/4");
		}

		public function check_is_user_exists($tourn_id, $bid, $sport)
		{
			return $this->model_league->check_user_exists($tourn_id, $bid, $this->logged_user, $sport);
		}

		public function check_team_is_user_exists($tourn_id, $bid, $sport)
		{
			return $this->model_league->check_team_user_exists($tourn_id, $bid, $this->logged_user, $sport);
		}

		public function update_player_match_formats()
		{
			$mtype = $this->model_league->update_player_match_formats();

				$match_array = array();
				if($mtype != "")
				{
				$match_array = json_decode($mtype);
				$numItems	 = count($match_array);

					if($numItems > 0)
					{
						foreach($match_array as $i => $group)
						{
						echo $group;
							if(++$i != count($match_array)){
							echo ", ";
							}
						}
					}
				}
		}

		public function update_player_levels()
		{
			//echo "<pre>"; print_r($_POST); exit;
			$this->model_league->update_player_levels();
			
			$sp_type = $this->input->post('sp_type');
			$level	 = $this->input->post('lvl');

			$get_level = $this->get_level_name($sp_type, $level);
			echo $get_level['SportsLevel'];
		}

		public function get_home_location($loc)
		{
			return $this->general->get_home_location($loc);
		}

		public function get_user_home_location($tourn_id, $user_id)
		{
			return $this->general->get_user_home_location($tourn_id, $user_id);
		}

		public function get_tour_registered_teams($tourn_id)
		{
			return $this->model_league->tour_registered_teams($tourn_id);
		}

		public function get_loggeduser_teams()
		{
			return $this->model_league->get_loggeduser_teams();
		}

		public function get_reg_team_players($tourn_id, $team_id)
		{
			return $this->model_league->get_reg_team_players($tourn_id, $team_id);
		}

		public function get_line_matches()
		{
			$match_id  = $this->input->post('mid');
			$p		   = $this->input->post('P');
			$team1	   = $this->input->post('T1');
			$team2	   = $this->input->post('T2');
			$header    = $this->input->post('header');
			$get_lines = $this->model_league->get_line_matches($match_id);

			$get_team1 = $this->general->get_team($team1);
			$get_team2 = $this->general->get_team($team2);

			$opt_1 = "<tr class='top-scrore-table'>
					<td style='padding-left:15px;'><b>Line#</b></td>
					<td style='padding-left:15px;'><b>{$get_team1['Team_name']}</b></td>
					<td style='padding-left:15px;'><b>{$get_team2['Team_name']}</b></td>
					<td style='padding-left:15px;'><b>Scores</b></td>
					</tr>";

			if($header){
				echo $opt_1;
			}

			foreach($get_lines as $m => $line){

				if($line->Winner != NULL)
				{

				$get_user	  = league::get_username($line->Player1); 
				$player1	  = "<a href='".base_url()."player/".$get_user['Users_ID']."' title=''>"
				.$get_user['Firstname']." ".$get_user['Lastname']."</a>";

				$get_user	  = league::get_username($line->Player2); 
				$player2	  = "<a href='".base_url()."player/".$get_user['Users_ID']."' title=''>"
				.$get_user['Firstname']." ".$get_user['Lastname']."</a>";

				$get_user	  = league::get_username($line->Winner); 
				$winner		  = "<a href='".base_url()."player/".$get_user['Users_ID']."' title=''>"
				.$get_user['Firstname']." ".$get_user['Lastname']."</a>";

				$player1_partner = '';
				$player2_partner = '';

				if($line->Match_Type == 'MDoubles' or $line->Match_Type == 'WDoubles' or $line->Match_Type == 'Mixed' or $line->Match_Type == 'OSingles' or $line->Match_Type == 'ODoubles'){
					if($line->Player1_Partner){
						$get_user		 = league::get_username($line->Player1_Partner);
						$player1_partner	  = "; <a href='".base_url()."player/".$get_user['Users_ID']."' title=''>"
						.$get_user['Firstname']." ".$get_user['Lastname']."</a>";
					}
					if($line->Player1_Partner){
						$get_user		 = league::get_username($line->Player2_Partner);
						$player2_partner	  = "; <a href='".base_url()."player/".$get_user['Users_ID']."' title=''>"
						.$get_user['Firstname']." ".$get_user['Lastname']."</a>";
					}
				}

				$p1_winner = '';
				$p2_winner = '';

				if($line->Winner == $line->Player1){
					$p1_winner = "<img id='img-winner' src='".base_url()."images/gold_medal_small.png' width='20' height='20'></img>";
				}
				elseif($line->Winner == $line->Player2){
					$p2_winner = "<img id='img-winner' src='".base_url()."images/gold_medal_small.png' width='20' height='20'></img>";
				}

					$opt_2 = "<tr>";
					$opt_2 .= "<td style='padding-left:15px;'>".$line->Line_num." (".$line->Match_Type.")"."</td>";
					if($p == 'P1'){
					$opt_2 .= "<td style='padding-left:15px;'>".$player2.$player2_partner.$p2_winner."</td>";
					$opt_2 .= "<td style='padding-left:15px;'>".$player1.$player1_partner.$p1_winner."</td>";
					}
					elseif($p == 'P2'){
					$opt_2 .= "<td style='padding-left:15px;'>".$player1.$player1_partner.$p1_winner."</td>";
					$opt_2 .= "<td style='padding-left:15px;'>".$player2.$player2_partner.$p2_winner."</td>";
					}
					$opt_2 .= "<td style='padding-left:15px;'>";

				if($line->Player1_Score !="[0]" and $line->Winner != NULL){
					$p1=array();$p2=array();
					$p1 = json_decode($line->Player1_Score);
					$p2 = json_decode($line->Player2_Score);

					$cnt = count(array_filter($p1));
					$cnt2 = count(array_filter($p2));
					if($cnt > 0){
						for($i=0; $i<count(array_filter($p1)); $i++){
							$opt_2 .= ($line->Winner == $line->Player1) ? "($p1[$i] - $p2[$i]) " : "($p2[$i] - $p1[$i]) ";
						}
					}
					else if($cnt2 > 0){
						for($i=0; $i<count(array_filter($p2)); $i++){
							$opt_2 .= ($line->Winner == $line->Player1) ? "($p1[$i] - $p2[$i]) " : "($p2[$i] - $p1[$i]) ";
						}
					}
				}
				else if($line->Player1_Score =="[0]" and $line->Winner != NULL){
						$opt_2 .= "Win by Forfeit ";
				}

				
				$opt_2 .= "</td>
			</tr>";

				echo $opt_2;
				}
				else
				{
					echo "<tr>
					<td style='padding-left:15px;'>".$line->Line_num." (".$line->Match_Type.")"."</td>
					<td style='padding-left:5px;' colspan='3'>Score Not Entered</td></tr>";
				}
			}
		}
		
		public function drop_line_matchscore(){
			
			$line_id = $this->input->post('line');

			if($line_id){
				$get_line_data	= $this->model_league->get_line_data($line_id);

				$player1_points = $get_line_data['Player1_points'];
				$player2_points = $get_line_data['Player2_points'];
				$tourn_match_id = $get_line_data['Tourn_match_id'];
				$tourn_id		= $get_line_data['Tourn_ID'];
				$bracket_id		= $get_line_data['BracketID'];
				/*echo "<br>player1_points=".$player1_points;
				echo "<br>player2_points=".$player2_points;
				echo "<br>tourn_match_id=".$tourn_match_id;
				echo "<br>tourn_id=".$tourn_id;
				echo "<br>bracket_id=".$bracket_id;*/
				//exit;

				$upd_line  = $this->model_league->reset_line_data($line_id);

				$upd_match = $this->model_league->revise_match_data($tourn_match_id, $tourn_id, $player1_points, $player2_points);

				echo "Done";
			}
			else{
				echo "Invalid Request!";
			}

		}

		public function adm_withdraw_players(){

			if($this->input->post('sel_player')){

				$sel_players = $this->input->post('sel_player');
				$tourn_id	 = $this->input->post('tourn_id');

				foreach($sel_players as $player){

					$rem_player = $this->model_league->withdraw_player($player, $tourn_id);
					
					if($rem_player){
						$get_user		= $this->general->get_user($player);
						$tourn_details  = $this->model_league->getonerow($tourn_id);

						$subject  = "UnRegistered from Tournament {$tourn_details->tournament_title} - A2MSports";

						$data = array(
							'player'	=> $get_user->Firstname." ".$get_user->Lastname,
							'tourn_id'	=> $tourn_id,
							'title'		=> $tourn_details->tournament_title,
							'page'		=> 'UnRegister by Admin'
							);

						$this->email_to_player($get_user->Email, $subject, $data);
						redirect('league/' . $tourn_id);
					}
				}
			}
			else{
				echo "No players were selected to withdraw!";
			}
		}

		public function adm_withdraw_teams(){

			if($this->input->post('sel_team')){

				$sel_teams = $this->input->post('sel_team');
				$tourn_id	 = $this->input->post('tourn_id');

				foreach($sel_teams as $team){

					$rem_team = $this->model_league->withdraw_team($team, $tourn_id);
					
					if($rem_team){
						$get_team		  = $this->general->get_team($team);
						$get_captain_user = $this->general->get_user($get_team->Captain);
						$tourn_details    = $this->model_league->getonerow($tourn_id);

						$subject  = "UnRegistered from Tournament {$tourn_details->tournament_title} - A2MSports";

						$data = array(
							'captain'	=> $get_captain_user->Firstname." ".$get_captain_user->Lastname,
							'tourn_id'	=> $tourn_id,
							'team'		=> $get_team->Team_name,
							'title'		=> $tourn_details->tournament_title,
							'page'		=> 'UnRegister Team by Admin'
							);

						$this->email_to_player($get_captain_user->Email, $subject, $data);
						redirect('league/' . $tourn_id);
					}
				}
			}
			else{
				echo "No players were selected to withdraw!";
			}
		}

		public function email_to_player($to_email, $subject, $data){
			
			$this->load->library('email');
			$this->email->set_newline("\r\n"); 
			$this->email->from(FROM_EMAIL, 'A2MSports');
			$this->email->to($to_email);
			$this->email->subject($subject);

			$body = $this->load->view('view_email_template', $data, TRUE);

			$this->email->message($body);   
			$snd_email = $this->email->send();

			/*if($snd_email){ 
				echo "Success<br/>";
			}
			else{ 
				echo $this->email->print_debugger();
				echo "Fail<br/>";
			}
exit;*/

		}

		 public function add_comment()
		 {
			if($this->input->post('message'))
			{
				$res				= $this->model_league->insert_tourn_comment();
				$tourn_id			= $this->input->post('tid');
				$get_tourn_comments = $this->general->get_tourn_comments($tourn_id);

				foreach($get_tourn_comments as $comment){
					$name = $this->get_user($comment->Users_Id);
					$full_name = ucfirst($name['Firstname'])." ".ucfirst($name['Lastname']);
						if($name['Profilepic'] != "" and $name['Profilepic'] != 'NULL'){
						$prof_picture = base_url()."profile_pictures/$name[Profilepic]"; }
						else{
						$prof_picture = base_url()."profile_pictures/default-profile.png"; }


					$op .= "<div class='pull-left' style='margin-right:20px'><img class='img-circle' src='{$prof_picture}' width='50px' height='50px' /></div>
					<div style='margin-top:5px'>
						<span style='font-weight:bold; color:#464646'>".$full_name."</span>
						<span style='font-size:11px; color:#959595'>".date("m/d/Y H:i", strtotime($comment->Comment_On))."</span>
						<div style='margin-top:5px;'>$comment->Comments</div>
					</div>
					<div style='clear:both; height:20px'></div>";

				}
				echo $op;

				//redirect("events/view/$ev_id/4");
			}
		 }

		public function league_list($sport)
		{
			//echo "<pre>"; print_r($_POST);exit();
			$data['req_tab'] = 'tournaments';
			if($_REQUEST['p']){
				$data['req_tab'] = $_REQUEST['p'];
			}

            $data['sport']         = $sport;	
            $data['loc_query']	   = $this->model_league->search_players_rankings($data);
            $data['coach_results'] = $this->model_league->search_coaches($data);
            $data['club_results']  = $this->model_league->search_clubs($data);
			$country = 'United States of America';
			$data['teams_result'] = $this->model_league->get_TeamsByCountry($country, $sport);

			if($this->input->post('search_mem_loc')) {
				$data['search_uname'] = $this->input->post('name');
				$data['country']	  = $this->input->post('country');
				$data['state']	      = $this->input->post('state');
				$data['age_group']	  = $this->input->post('age_group');
				$data['gender']	      = $this->input->post('gender');
				//$data['state1']	      = $this->input->post('state1');
				$data['sport']		  = $this->input->post('sport');
				$sport                = $data['sport'];
				$data['loc_query']	  = $this->model_league->search_players_rankings($data);
				//echo "<pre>";print_r($data['countries']);exit();
				$data['leagues']      = $this->model_league->get_sport_leagues($sport);
			    $data['results']      = $this->model_news->getNews_By_SportsType($sport);
			}
			else if($this->input->post('coach_mem')) {
				$data['coach_name']    = $this->input->post('coach_name');
				$data['sport']   = $this->input->post('sport');
			    $data['coach_country'] = $this->input->post('coach_country');
				$data['coach_state']   = $this->input->post('coach_state');
				$sport                 = $data['sport'];
				$data['coach_results'] = $this->model_league->search_coaches($data);			
				$data['leagues']       = $this->model_league->get_sport_leagues($sport);
			    $data['results']       = $this->model_news->getNews_By_SportsType($sport);	
			}
			else if($this->input->post('addclub')) {

			    $club_timings    = $this->input->post('clubTimings');
			    $club_time_from  = $this->input->post('club_time_from');
			    $club_time_to    = $this->input->post('club_time_to');

				foreach($club_timings as $ind => $day){
					$revised[$day] = array(0 => $club_time_from[$ind], 1 => $club_time_to[$ind]);
				}
				
				/*echo json_encode($revised);
				echo "<pre>"; print_r($revised); print_r($_POST); print_r($_FILES); exit;*/
				
				$data['sport']				= $this->input->post('sport');
				$sport							= $data['sport'];
				$data['club_name']       = $this->input->post('clubname');
			    $data['club_country']    = $this->input->post('clubcountry');
			    $data['club_addr1']      = $this->input->post('addr_line1');
			    $data['club_addr2']      = $this->input->post('addr_line2');
			    $data['club_zipcode']   = $this->input->post('zipcode');
				$data['club_state']		= $this->input->post('addclub_state');
				$data['club_city']			= $this->input->post('clubcity');
				$data['club_website']    = $this->input->post('club_website');
				$data['club_details']		= $this->input->post('club_details');
				$data['contact_name']  = $this->input->post('contact_name');
				$data['contact_email']	= $this->input->post('contact_email');
				$data['contact_phone'] = $this->input->post('contact_phone');
				$club_sports             = json_encode($this->input->post('clubsport'));
				$data['club_sports']     = $club_sports;
				$data['no_of_courts']    = $this->input->post('no_of_courts');
				$data['club_timings']    = json_encode($revised);

				/* logo section */
				$filename2 = 'club_logo';
				$this->load->library('upload');

			    $config = array(
						'upload_path'	=> "./org_logos/",
						'allowed_types' => "gif|jpg|png|jpeg|pdf",
						'overwrite'		=> FALSE,
						'max_size'		=> "10000", // Can be set to particular file size , here it is 2 MB(2048 Kb)
						'max_height'	=> "5000",
						'max_width'		=> "8000"
						);

				$this->upload->initialize($config);

				if($this->upload->do_upload($filename2)){
					$data['club_logo_data'] = $this->upload->data();
				}

				/* logo section */

				$data['add_clubs']       = $this->model_league->AddClub($data);
				$data['leagues']         = $this->model_league->get_sport_leagues($sport);
			    $data['results']         = $this->model_news->getNews_By_SportsType($sport);
			}
			else if($this->input->post('club_mem')) {
				//print_r($_POST);exit();
				$data['sport']           = $this->input->post('sport');
				$sport                   = $data['sport'];
				$data['club_name']       = $this->input->post('club_name');

			    $data['club_country']    = $this->input->post('club_country');
				$data['club_state']      = $this->input->post('club_state');
				$data['club_results']    = $this->model_league->search_clubs($data);
				$data['leagues']         = $this->model_league->get_sport_leagues($sport);
			    $data['results']         = $this->model_news->getNews_By_SportsType($sport);
			}
			else {
				$sport                 = $data['sport'];
				$data['leagues']       = $this->model_league->get_sport_leagues($sport);
				$data['results']       = $this->model_news->getNews_By_SportsType($sport);
				$data['events']        = $this->model_league->get_event_row($sport);
			}

			$data['sports'] = $this->model_league->GetSports();
             //echo "<pre>";print_r($data);exit();

			$data['sports_feeds_array'] = array(1,2,3,4,7,8,10); 
			 switch($sport) {
					case 1:
					$rss_feed_url = "https://www.espn.com/espn/rss/tennis/news";
					break;
					case 2:
					//$rss_feed_url = "https://www.teamusa.org/USA-Table-Tennis/Features?rss=1";
					$rss_feed_url = "https://www.ittf.com/feed/";
					break;
					case 3:
					$rss_feed_url = "https://www.espn.com/espn/rss/badminton/news";
					break;
					case 4:
					$rss_feed_url = "https://www.espn.com/espn/rss/golf/news";
					break;
					case 7:
					$rss_feed_url = "https://pickleballnews.com/feed/podcast/";
					break;
					case 8:
					$rss_feed_url = "https://www.espn.com/espn/rss/chess/news";
					break;
					case 10:
					$rss_feed_url = "https://volleycountry.com/feed";
					break;
					default:
					$rss_feed_url = "";
			 }

				$data['rss_feed_url']   = $rss_feed_url;
                //echo $data['rss_feed_url'];exit;
                $data['countries'] = $this->model_league->get_user_countries();
				$this->load->view('includes/header_sports_specific');
				//var_dump($data['isMobile']);
				//exit;
				//$this->load->view('includes/header');
				$this->load->view('view_league_list', $data);
				$this->load->view('includes/view_sports_right_column',$data);
				$this->load->view('includes/footer_sports_specific', $data);
		}


		public function sport_page($sport)
		{
			
			//echo "<pre>"; print_r($_POST);exit();
			$data['req_tab'] = 'tournaments';
			if($_REQUEST['p']){
				$data['req_tab'] = $_REQUEST['p'];
			}

            $data['sport']         = $sport;	
			$data['club_results']	 = $this->model_league->get_clubs($data);

            $data['loc_query']	   = $this->model_league->sport_top_players($data);
            $data['coach_results'] = $this->model_league->search_coaches($data);
           // $data['club_results']  = $this->model_league->search_clubs($data);
			$country = 'United States of America';
			$data['teams_result'] = $this->model_league->get_TeamsByCountry2($country, $sport);

			if($this->input->post('search_mem_loc')) {
				$data['search_uname'] = $this->input->post('name');
				$data['country']	  = $this->input->post('country');
				$data['state']	      = $this->input->post('state');
				$data['age_group']	  = $this->input->post('age_group');
				$data['gender']	      = $this->input->post('gender');
				//$data['state1']	      = $this->input->post('state1');
				$data['sport']		  = $this->input->post('sport');
				$sport                = $data['sport'];
				$data['loc_query']	  = $this->model_league->sport_top_players($data);
				//echo "<pre>";print_r($data['countries']);exit();
				$data['leagues']      = $this->model_league->get_sport_leagues2($sport);
			    $data['results']      = $this->model_news->getNews_By_SportsType($sport);
			}
			else if($this->input->post('coach_mem')) {
				$data['coach_name']    = $this->input->post('coach_name');
				$data['sport']   = $this->input->post('sport');
			    $data['coach_country'] = $this->input->post('coach_country');
				$data['coach_state']   = $this->input->post('coach_state');
				$sport                 = $data['sport'];
				$data['coach_results'] = $this->model_league->search_coaches($data);			
				$data['leagues']       = $this->model_league->get_sport_leagues2($sport);
			    $data['results']       = $this->model_news->getNews_By_SportsType($sport);	
			}
			else if($this->input->post('addclub')) {

			    $club_timings    = $this->input->post('clubTimings');
			    $club_time_from  = $this->input->post('club_time_from');
			    $club_time_to    = $this->input->post('club_time_to');

				foreach($club_timings as $ind => $day) {
					$revised[$day] = array(0 => $club_time_from[$ind], 1 => $club_time_to[$ind]);
				}
				
				/*echo json_encode($revised);
				echo "<pre>"; print_r($revised); print_r($_POST); print_r($_FILES); exit;*/
				
				$data['sport']				= $this->input->post('sport');
				$sport							= $data['sport'];
				$data['club_name']       = $this->input->post('clubname');
			    $data['club_country']    = $this->input->post('clubcountry');
			    $data['club_addr1']       = $this->input->post('addr_line1');
			    $data['club_addr2']       = $this->input->post('addr_line2');
			    $data['club_zipcode']    = $this->input->post('zipcode');
				$data['club_state']		= $this->input->post('addclub_state');
				$data['club_city']			= $this->input->post('clubcity');
				$data['club_website']    = $this->input->post('club_website');
				$data['club_details']		= $this->input->post('club_details');
				$data['contact_name']  = $this->input->post('contact_name');
				$data['contact_email']	= $this->input->post('contact_email');
				$data['contact_phone'] = $this->input->post('contact_phone');
				$club_sports             = json_encode($this->input->post('clubsport'));
				$data['club_sports']     = $club_sports;
				$data['no_of_courts']    = $this->input->post('no_of_courts');
				$data['club_timings']    = json_encode($revised);

				/* logo section */
				$filename2 = 'club_logo';
				$this->load->library('upload');

			    $config = array(
						'upload_path'	=> "./org_logos/",
						'allowed_types' => "gif|jpg|png|jpeg|pdf",
						'overwrite'		=> FALSE,
						'max_size'		=> "10000", // Can be set to particular file size , here it is 2 MB(2048 Kb)
						'max_height'	=> "5000",
						'max_width'		=> "8000"
						);

				$this->upload->initialize($config);

				if($this->upload->do_upload($filename2)){
					$data['club_logo_data'] = $this->upload->data();
				}

				/* logo section */

				$data['add_clubs']    = $this->model_league->AddClub($data);
				$data['leagues']       = $this->model_league->get_sport_leagues2($sport);
			    $data['results']         = $this->model_news->getNews_By_SportsType($sport);
			}
			else if($this->input->post('club_mem')) {
				//print_r($_POST);exit();
				$data['sport']			= $this->input->post('sport');
				$sport						= $data['sport'];
				$data['club_name']   = $this->input->post('club_name');

			    $data['club_country']   = $this->input->post('club_country');
				$data['club_state']       = $this->input->post('club_state');
				$data['club_results']    = $this->model_league->search_clubs($data);
				$data['leagues']          = $this->model_league->get_sport_leagues2($sport);
			    $data['results']         = $this->model_news->getNews_By_SportsType($sport);
			}
			else {
				$sport                 = $data['sport'];
				$data['leagues']       = $this->model_league->get_sport_leagues2($sport);
				$data['results']       = $this->model_news->getNews_By_SportsType($sport);
				$data['events']        = $this->model_league->get_event_row($sport);
			}

			$data['sports'] = $this->model_league->GetSports();
             //echo "<pre>";print_r($data);exit();
			 //echo "<pre>"; print_r($data['leagues']); exit;

			$data['sports_feeds_array'] = array(1,2,3,4,7,8,10); 
			 switch($sport) {
					case 1:
					$rss_feed_url = "https://www.espn.com/espn/rss/tennis/news";
					break;
					case 2:
					//$rss_feed_url = "https://www.teamusa.org/USA-Table-Tennis/Features?rss=1";
					$rss_feed_url = "https://www.ittf.com/feed/";
					break;
					case 3:
					$rss_feed_url = "https://www.espn.com/espn/rss/badminton/news";
					break;
					case 4:
					$rss_feed_url = "https://www.espn.com/espn/rss/golf/news";
					break;
					case 7:
					$rss_feed_url = "https://pickleballnews.com/feed/podcast/";
					break;
					case 8:
					$rss_feed_url = "https://www.espn.com/espn/rss/chess/news";
					break;
					case 10:
					$rss_feed_url = "https://volleycountry.com/feed";
					break;
					default:
					$rss_feed_url = "";
			 }

				$data['rss_feed_url']   = $rss_feed_url;
                //echo "<pre>"; print_r($data); exit;
                $data['countries'] = $this->model_league->get_user_countries();
				//$this->load->view('includes/header_sports_specific');
				//var_dump($data['isMobile']);
				//exit;
				//$this->load->view('includes/header');
				$this->load->view('view_sport_page', $data);
				//$this->load->view('includes/view_sports_right_column',$data);
				//$this->load->view('includes/footer_sports_specific', $data);
		}

		public function get_tourn_reg_team_lines()
		{
			$team_id		= $this->input->post('team_id');
			$tourn_id		= $this->input->post('tourn_id');
			$bracket_id		= $this->input->post('bracket_id');

			$team_info		= $this->general->get_team($team_id);
			$teams			= $this->model_league->Get_TournamentTeams($tourn_id);
            $brackets		= $this->get_bracket_list($tourn_id);
			$team_players	= json_decode($team_info['Players']);
			
					$data['brackets']	  = $brackets;
					$data['teams']	      = $teams;
					$data['bracket_id']	  = $bracket_id;
					$data['team_id']	  = $team_id;
					$data['tourn_id']	  = $tourn_id;
					$data['team_captain'] = $team_info['Captain'];
					$rounds_cnt			  = $this->model_league->get_rounds_cnt($tourn_id,$bracket_id);
					$data['rounds_cnt']	  = $rounds_cnt['No_of_rounds'];
					$rounds				  = $rounds_cnt['No_of_rounds'];

			if(count($team_players) > 0){
				$lines = array();
				foreach($team_players as $key => $player){
		          $lines[$player] = $this->model_league->get_team_line_matches($player, $bracket_id, $tourn_id, $rounds);   
			    }
	        }
	            $data['lines'] = $lines;             

			$this->load->view('teams/view_tour_team_line_matches', $data);
		}

		/*public function in_array_r($needle, $haystack, $strict = false){
			foreach($haystack as $i => $item){
				if(($strict ? $item === $needle : $item == $needle) || (is_array($item) && league::in_array_r($needle, $item, $strict))){
					//echo $i;
					return $i;
				}
			}

			return false;
		}*/
		public function in_array_r($find, $source){
			$u = array();
			foreach($source as $i => $item){
				foreach($item as $j => $str){
					if($find == $str)
					{
						$u[] = $i;
					}				
				}
			}
			return $u;
		}

		public function in_array_r_sort($find, $source, $partners=''){
			$u = array();
			$u_np = array();
			foreach($source as $i => $item){
				foreach($item as $j => $str){
					if($find == $str)
					{
						if($partners[$i][$str] != '' and $partners != '')
							$u[] = $i;
						else
							$u_np[] = $i;
					}				
				}
			}
			//echo "<pre>"; print_r($u);print_r($u_np);
			$upd = array_merge($u, $u_np);
			return $upd;
		}

		public function CheckTorn_ShortCode(){
			$short_code = $this->input->post('short_code');
            $check=$this->model_league->CheckTorn_ShortCode($short_code); 
            echo $check;
		}

		public function is_logged_user_having_memeberhip($sport){
			$check = $this->model_league->is_logged_user_having_memeberhip($sport); 
            return $check;
		}

		public function get_user_mem_details($user, $sport){
			$res = $this->model_league->get_user_mem_details($user, $sport); 
            return $res;
		}

		public function get_user_usatt_rating($membership_id){
			$res = $this->model_league->get_user_usatt_rating($membership_id); 
            return $res;
		}

		public function get_user_usatt_rating1($membership_id){
			$res = $this->model_league->get_user_usatt_rating1($membership_id); 
            return $res;
		}

		public function GetUserLevels(){

			//if(!$this->session->userdata('user')){ redirect('login'); }
          
			$tourn_id = $_POST['tourn_id'];
			$player   = $_POST['player'];

			$tour_details = $this->model_league->getonerow($tourn_id);
            $tourn_gender_check = array();
            $events = array();
			//$events = $this->GetTournamentEvents($tour_details);
			if($tour_details->Multi_Events != NULL){
		        $multi_events = json_decode($tour_details->Multi_Events);
	            foreach ($multi_events as $key => $event) {
	               $arr = explode('-', $event);
				   //echo "<pre>"; print_r($arr);
				   if($arr[0] == 'Open'){
			 	   $fr  = 'Open';
				   }
				   /*else if($arr[1] == 'Mixed'){
			 	   $fr  = 'Mixed';
				   }*/
				   else if(in_array($arr[1], array('Singles','Doubles','Mixed'))){
			 	   $fr  = $arr[1];
				   }
				   else{
			 	   $fr  = $arr[2];
				   }
			       $events[$fr][] = $event;
	            }
			}else{

				$formats   = json_decode($tour_details->Singleordouble);
	            $age_group = json_decode($tour_details->Age);
	            $levels    = json_decode($tour_details->Sport_levels);

			    if($tour_details->Gender=='all' || $tour_details->Gender=='All'){
				    $tourn_gender_check[0]=1;
				    $tourn_gender_check[1]=0;
				}elseif ($tour_details->Gender=='1') {
				    $tourn_gender_check[0]=1;
				}elseif ($tour_details->Gender=='0') {
				    $tourn_gender_check[0]=0;
				}

			    foreach ($tourn_gender_check as $key => $gender) 
			    {
				    if($gender == 1){
				          $gender_key = 1;
				    }else{
				          $gender_key = 0;
				    }

			        $show_mixed = 1;

				    foreach($formats as $fr){
				     if($fr == 'Mixed' and $gender_key == 1){ $show_mixed = 0; }
				      foreach($age_group as $ag){
				        foreach($levels as $key=>$lv){
				            if($fr != 'Mixed' or  $show_mixed == 1){ 

				               if($fr == 'Mixed'){ $gender_key = 2; }
				       
				                  if($gender_key == 1){
				                    $genderkey = 1;
				                  }else if($gender_key == 0){
				                    $genderkey = 0;
				                  }else if($gender_key == 2){
				                     $genderkey = 2;
				                  }            

				                 $val = $ag."-".$genderkey."-".$fr."-".$lv;
				                 $events[$fr][] = $val;

				            }
				        }
				      }
				    }
			    }

			}
			
				$levelsexist = $this->model_league->get_reg_tourn_participants_levels($tourn_id,$player);

				$formats1   = json_decode($levelsexist['Match_Type']);
				$ag_group1  = json_decode($levelsexist['Reg_Age_Group']);
				$sp_levels1 = json_decode($levelsexist['Reg_Sport_Level']);
                $lvlexists = array();
        		//echo "<pre>";print_r($ag_group1);
				//echo "<pre>";print_r($sp_levels1);
                if($levelsexist['Reg_Events'] != NULL){
                    $reg_events = json_decode($levelsexist['Reg_Events']);
		            foreach ($reg_events as $key => $event) {
		               $arr = explode('-', $event);
				       $lvlexists[] = $event;
		            }
                }
				else{

	                foreach($formats1 as $i => $fr){
						foreach($ag_group1[$i] as $j => $ag1){
							foreach($sp_levels1[$i][$j] as $k => $lv1){
								$player_det = $this->general->get_user($player);	
			                        if($fr == 'Singles' || $fr == 'Doubles'){
			                           $gender = $player_det['Gender'];
									}else
									{
									   $gender = 2;
									}
							    $lvlexists[]=$ag1.'-'.$gender.'-'.$fr.'-'.$lv1;
						    }
							
						}
					}
                }
			
				//echo "<pre>";print_r($ag_group1);	exit();
				//echo "<pre>";print_r($ag_group);
				$tourn_occrs = '';
				if($tour_details->Is_League){
					$get_occrs = $this->model_league->get_league_occr($tourn_id);
					foreach($get_occrs as $occr){
						$tourn_occrs[$occr->Event][$occr->OCR_ID] = $occr->Game_Date;  
					}

					$get_user_reg_occrs = $this->model_league->get_user_reg_occrs($tourn_id, $player);
					foreach($get_user_reg_occrs as $occr){
						$user_reg_occrs[] = $occr->OCCR_ID;  
					}



				}
				//echo "<pre>";print_r($tourn_occrs);	exit();
				$data['lvlexists'] = $lvlexists;
			    $data['tourn_id']  = $tourn_id;
			    $data['player']    = $player;
				$data['levels']    = $events;
				$data['tourn_occrs']    = $tourn_occrs;
				$data['user_reg_occrs']    = $user_reg_occrs;
				//echo"<pre>"; print_r($data);
				$this->load->view('tournament/view_user_levels', $data);

		}

		public function UpdateLevels(){
			//echo "<pre>";  print_r($_POST);exit();
			$singles  = $_POST['singles'];
			$doubles  = $_POST['doubles'];
			$mixed    = $_POST['mixed'];
            $tourn_id = $_POST['tourn_id'];
            $player   = $_POST['player'];
            $selected_ocrs   = $_POST['selected_ocrs'];
            $none_ocr_ids   = $_POST['not_selected_ocrs'];
           
            //echo "<pre>";  print_r($_POST);exit();
      //  echo "<pre>";  print_r($doubles);exit();
            $f  = array();
			$ag = array();
			$lv = array();
            $i  = 0;
            $formats = array();
            $reg_events = array();
			 if($singles){
			        array_push($formats,"Singles");
					$f[] = $i++;
					$x   = array();

					foreach($singles as $j => $sg){
						$ex = explode('-', $sg);
                        array_push($reg_events,$sg);
						if(!in_array($ex[0], $s_ag)){
							$s_ag[]  = $ex[0];
							if(!empty($x)){ $s_lvl[] = $x; }
							$x		 = array();
						}
						$x[] = $ex[3];

						if(++$j == count($singles)){
							if(!empty($x)){ $s_lvl[] = $x; }
						}
					}
						$ag[] = $s_ag;
						$lv[] = $s_lvl;

			 }

			if($doubles){
			        array_push($formats,"Doubles");
					$f[] = $i++;
					$x   = array();

					foreach($doubles as $j => $dg){
						array_push($reg_events,$dg);
						$ex = explode('-', $dg);

						if(!in_array($ex[0], $d_ag)){
							$d_ag[]  = $ex[0];
							if(!empty($x)){ $d_lvl[] = $x; }
							$x		 = array();
						}
						$x[] = $ex[3];

						if(++$j == count($doubles)){
							if(!empty($x)){ $d_lvl[] = $x; }
						}
					}
						$ag[] = $d_ag;
						$lv[] = $d_lvl;
			 }

			if($mixed){
				array_push($formats,"Mixed");

					$f[] = $i++;
					$x   = array();

					foreach($mixed as $j => $mg){
						array_push($reg_events,$mg);
						$ex = explode('-', $mg);

						if(!in_array($ex[0], $m_ag)){
							$m_ag[]  = $ex[0];
							if(!empty($x)){ $m_lvl[] = $x; }
							$x		 = array();
						}
						$x[] = $ex[3];

						if(++$j == count($mixed)){
							if(!empty($x)){ $m_lvl[] = $x; }
						}
					}
						$ag[] = $m_ag;
						$lv[] = $m_lvl;
			 }
			  $levels		= array_combine($f, $lv);
			  $age_grp  = array_combine($f, $ag);
      
             $data['json_formats'] = json_encode($formats);
             $data['json_levels']  = json_encode($levels);
			 $data['json_ag']	   = json_encode($age_grp);
			 $data['reg_events']   = json_encode($reg_events);
			
			 $res		 = $this->model_league->update_particiapants_levels($data,$player,$tourn_id);

			 if($selected_ocrs){
			 $res_ocr = $this->model_league->update_particiapants_ocr($selected_ocrs,$player,$tourn_id);
			 }
			 if($none_ocr_ids){
			 $rem_ocr = $this->model_league->remove_particiapants_ocr($none_ocr_ids,$player,$tourn_id);
			 }

			 echo $res;
			 //print_r($res); exit();
			 exit;
		}

		public function user_tourn_reg_details($player,$tourn_id){
			 $res = $this->model_league->get_reg_tourn_participants_levels($tourn_id,$player);
			 return $res;
		}

		public function add_players($tourn_id)
		{
			$details = $this->model_league->getonerow($tourn_id);

				$data['tourn_id'] = $tourn_id;
				if($details->Usersid == $this->session->userdata('users_id') 
					or $details->Tournament_Director == $this->session->userdata('users_id')){
					$data['r'] = $details;
					$data['results'] = $this->model_news->get_news();
					$data['teams'] = $this->model_league->Get_TournamentTeams($tourn_id);
                //  echo "<pre>"; print_r($data['teams']);exit();
					$this->load->view('includes/header');
				    $this->load->view('view_add_players',$data);
					$this->load->view('includes/footer');
				}
				else{
					echo "<h4>Unauthorized Access!</h4>";
				}	
			
		}

		public function AddPlayersToTeam($tourn_id)
		{
			$details = $this->model_league->bulk_reg_players($tourn_id);
			//echo "<pre>";print_r($details);
			redirect("league/$tourn_id");
		}

		public function get_matches_cnt($user_id, $sport_id)
		{
			return $this->general->get_matches_cnt($user_id, $sport_id);
		}

		 public function delete_draws()
		 {
            if(isset($_POST['bracket_ids']))
			{
				$bracket_ids=$_POST['bracket_ids'];
				//print_r($bracket_ids);exit();
				$tourn_id = $_POST['tourn_id'];
				$get_tour_admin = $this->get_logged_user_role($tourn_id);
				//$get_tour_admin = $this->model_league->getonerow($tourn_id);
				//echo $get_tour_admin->SportsType;exit();
				if($get_tour_admin->Usersid == $this->logged_user or $get_tour_admin->Tournament_Director == $this->logged_user or $this->is_super_admin or 1){
				
					if($get_tour_admin->SportsType == '4'){
						foreach ($bracket_ids as $key => $bid) {
							$res = $this->model_league->delete_golf_brackets($bid);
						}
					}else{

						if($_POST['tourn_format'] == "Teams")
						{

							foreach ($bracket_ids as $key => $bid) 
							{
								
							    $res = $this->model_league->delete_team_brackets($bid);  
						    }
							
						}
						else
						{
							foreach ($bracket_ids as $key => $bid)
							{
								$get_bracket = $this->model_league->get_tourn_bracket($bid); 

								if($get_bracket['Bracket_Type'] != 'Challenge Ladder'){
								   $res = $this->model_league->delete_brackets($bid);
								}
								else{
								   $res = $this->model_league->delete_cl_brackets($bid);
								}
						    }
							
						}
					}
					
				}
				
				//echo "<pre>";print_r($_POST);exit();
			}
			echo $res; exit();

         }

		 public function publish_draws()
		 {
            if(isset($_POST['bracket_ids']))
			{
				$bracket_ids	= $_POST['bracket_ids'];
				$tourn_id		= $_POST['tourn_id'];
				
				$get_tour_admin = $this->get_logged_user_role($tourn_id);
				//$get_tour_admin = $this->model_league->getonerow($tourn_id);
				//echo $get_tour_admin->SportsType;exit();
				if($get_tour_admin->Usersid == $this->logged_user 
					or $get_tour_admin->Tournament_Director == $this->logged_user 
					or $this->is_super_admin){
						foreach ($bracket_ids as $key => $bid) {
							$res = $this->model_league->publish_draws($bid);
						}
				}
			}
			echo $res; exit();
         }

		 public function unpublish_draws()
		 {
            if(isset($_POST['bracket_ids']))
			{
				$bracket_ids	= $_POST['bracket_ids'];
				$tourn_id		= $_POST['tourn_id'];
				$get_tour_admin = $this->get_logged_user_role($tourn_id);
				//$get_tour_admin = $this->model_league->getonerow($tourn_id);
				//echo $get_tour_admin->SportsType;exit();
				if($get_tour_admin->Usersid == $this->logged_user 
					or $get_tour_admin->Tournament_Director == $this->logged_user 
					or $this->is_super_admin){
						foreach ($bracket_ids as $key => $bid) {
							$res = $this->model_league->unpublish_draws($bid);
						}
				}
			}
			echo $res; exit();
         }

		 public function Getteamplayers()
		 {
		 	$tourn_id=$_POST['tourn_id'];
		 	$team_id=$_POST['team_id'];
			$res = $this->model_league->get_reg_participants_by_team($tourn_id,$team_id);

			foreach ($res as $key => $r) {
				$team_players=json_decode($r->Team_Players);	
			}
			$users="";

            foreach ($team_players as $key => $usr) {
                 $user_det = league::get_username($usr);
            echo "<div class='col-md-3 namespadd'><a target='_blank' href='".base_url()."player/".$usr."'>".$user_det['Firstname'].' '.$user_det['Lastname']."</a></div>";
            }    
			exit();
		 }

		 public function get_user_rating($user_id, $tourn_id){
            $res = $this->model_league->get_user_rating($user_id, $tourn_id);
			return $res;
		 }

		 public function get_event_fee(){
		 	$this->session->unset_userdata('tour_reg_fee');
			$this->session->unset_userdata('reg_tour_id');	

		 	$fee		 = 0.00;
		 	$tour_id = $this->input->post('tour_id');
			$events  = $this->input->post('events');

				$usatt_fee = 0;;
			if($this->input->post('new_usatt_opt'))
				$usatt_fee = 25.00;

			//print_r($events);exit();
            $get_tour_info   = $this->model_league->getonerow($tour_id);
            $event_reg_fee = json_decode($get_tour_info->Event_Reg_Fee, true);
           
		   if($get_tour_info->Is_League){

				$lg_sel_events	= $this->input->post('lg_events');
	            $lg_event_reg_fee = json_decode($get_tour_info->lg_Event_Reg_Fee, true);
				//echo "<pre>";
			    //print_r($events);
			    //print_r($lg_event_reg_fee);
				//exit;
				foreach ($events as $key => $value) {
					if (array_key_exists($value, $event_reg_fee) and !in_array($value, $lg_sel_events)){
					 $fee += $event_reg_fee[$value];
					}
					//else{
					// $fee += $lg_event_reg_fee[$value];
					//}
				}

				foreach ($lg_sel_events as $key => $value) {
					if (array_key_exists($value, $lg_event_reg_fee)){
					 $fee += $lg_event_reg_fee[$value];
					}
					//else{
					// $fee += $lg_event_reg_fee[$value];
					//}
				}

		   }
		   else{
				foreach ($events as $key => $value) {
					if (array_key_exists($value, $event_reg_fee)){
					 $fee += $event_reg_fee[$value];
					}
				}
		   }
           
		   if($fee > 0)
		   $fee += $usatt_fee;

            $sess_data = array('tour_reg_fee'=>number_format($fee, 2), 'reg_tour_id'=>$tour_id);

			$this->session->set_userdata($sess_data);

				echo number_format($fee, 2); 
				exit();
		 }


         public function delete_sponsor(){
         	if(isset($_POST['tourn_id']))
			{
				$sponsors=array();
				$tourn_id=$_POST['tourn_id'];
				//print_r($bracket_ids);exit();
				$sponsor = $_POST['sponsor'];

				$tour_det = $this->model_league->getonerow($tourn_id);
				//print_r($tour_det);exit();
				$sponsors_arr=json_decode($tour_det->Sponsors, true);
				
				foreach($sponsors_arr as $sponsr => $spnsr_addr_link){
                  if(!in_array($sponsr, $sponsor)){
                     $sponsors[$sponsr]=$spnsr_addr_link;
                  }
				}
				
				if(!empty($sponsors)){
                  $sponsors_jsn=json_encode($sponsors);
				}else{
				  $sponsors_jsn="";
				}
				$res=$this->model_league->update_spnsr_images($sponsors_jsn,$tourn_id);
		
				if($res==1){
					foreach ($sponsor as $key => $spnsr) {
						$path = $_SERVER['DOCUMENT_ROOT'].'\a2msports\tour_pictures\\'.$tourn_id.'\sponsors\\'.$spnsr;
						//$path = $_SERVER['tour_pictures/'.$tourn_id.'/sponsers/'.$spnsr;
						//echo $path;
						unlink($path);  
					  }
				
	               if($sponsors_jsn!="")
		           {
		           	$sponsors_arry=array();
				    $sponsors_arry=json_decode($sponsors_jsn, true);
				    $ajax="";
					foreach ($sponsors_arry as $sponsor => $spnsr_addr_link)
						{
						  $ajax.='<input type="checkbox" name="sponsor_chk[]" class="sponsor_chk_cls" value="'.$sponsor.'">';
						 $ajax.='<img width="200px" height="200px" src="'.base_url().'tour_pictures/'.$tourn_id.'/sponsors/'.$sponsor.'">';	
			            }
	           
	                    $ajax.='<br><input type="button" name="delete_spnsr" id="delete_spnsor" class="league-form-submit" value="Delete Sponsor">';   
	                   
		            }

		            echo $ajax;exit();
		          
				}
				
			}
         }

         public function GetUserLevelsExist() {
			//if(!$this->session->userdata('user')){ redirect('login'); }
          
			$tourn_id = $_POST['tourn_id'];
			$player	  = $_POST['player'];
			
				$levelsexist = $this->model_league->get_reg_tourn_participants_levels($tourn_id,$player);

				$formats   = json_decode($levelsexist['Match_Type']);
				$ag_group  = json_decode($levelsexist['Reg_Age_Group']);
				$sp_levels = json_decode($levelsexist['Reg_Sport_Level']);
                $lvlexists = array();
        		//	echo "<pre>"; print_r($ag_group1);
				//	echo "<pre>"; print_r($sp_levels1);
        
				 if($levelsexist['Reg_Events'] != NULL) {
                    $reg_events = json_decode($levelsexist['Reg_Events']);
		            foreach ($reg_events as $key => $event) {
		               $arr = explode('-', $event);
		               //$fr = $arr[2];
						if($arr[1] == 'Singles' or $arr[1] == 'Doubles' or $arr[1] == 'Mixed') {
							$fr = $arr[1];
						}
						else {
							$fr = $arr[2]; 
						}

				       $lvlexists[$fr][] = $event;
		            }
                }
				else {
	                foreach($formats as $i => $fr) {
						foreach($ag_group[$i] as $j => $ag1) {
							foreach($sp_levels[$i][$j] as $k => $lv1) {
								$player_det = $this->general->get_user($player);	

			                        if($fr == 'Singles' || $fr == 'Doubles') {
				                       $gender = $player_det['Gender'];
									}
									else {
									   $gender = 2;
								    }
							    $lvlexists[$fr][] = $ag1.'-'.$gender.'-'.$fr.'-'.$lv1;
						    }
						}
					}
                }
				//echo "<pre>"; print_r($lvlexists); exit();
				//echo "<pre>";print_r($ag_group);
				$data['lvlexists']	=	$lvlexists;
			    $data['tourn_id']	=	$tourn_id;
			    $data['player']		=	$player;

				$this->load->view('tournament/view_user_existing_levels', $data);
		}

		 public function GetPlayerEvents($SportsType, $tourn_id){
		 	//echo $SportsType;exit();
			if(!$this->session->userdata('user')){ redirect('login'); }
			    $player      = $this->session->userdata('users_id');
				$levelsexist = $this->model_league->get_reg_tourn_participants_levels($tourn_id,$player);

				$formats     = json_decode($levelsexist['Match_Type']);
				$ag_group    = json_decode($levelsexist['Reg_Age_Group']);
				$sp_levels   = json_decode($levelsexist['Reg_Sport_Level']);
                $lvlexists   = array();

				if($levelsexist['Reg_Events'] != NULL){
                    $reg_events = json_decode($levelsexist['Reg_Events']);
                    
		            foreach ($reg_events as $key => $event) {
		               $arr = explode('-', $event);
		               $ag = $arr[0];
		               //$fr = $arr[2];
						if($arr[1] == 'Singles' or $arr[1] == 'Doubles' or $arr[1] == 'Mixed') {
							$fr = $arr[1];
						}
						else {
							$fr = $arr[2]; 
						}

				       $lvlexists[$fr][] = $event;
				       $lvl_counts[$ag][] = $event;
		            }

		        
		            foreach ($lvl_counts as $ag => $evnts) {
		            	$c = 0;
		            	 foreach ($evnts as $key => $evnt) {
		            	 	
		            	 	  $c++;
		            	 }
		            	 $lvl_count[$ag] += $c; 
		            	
		            }
		           
                }else{
                	
	                foreach($formats as $i => $fr){
						foreach($ag_group[$i] as $j => $ag1){
							$c = 0;
							foreach($sp_levels[$i][$j] as $k => $lv1){
								$player_det = $this->general->get_user($player);	

			                        if($fr == 'Singles' || $fr == 'Doubles'){
				                       $gender = $player_det['Gender'];
									}else
									{
									   $gender = 2;
								    }
							    $lvlexists[$fr][]=$ag1.'-'.$gender.'-'.$fr.'-'.$lv1;
							    
							    $c++;
						    }
						    $lvl_count[$ag1] += $c;
							
						}
					}
                }
				
				$data['events']		           = $lvlexists;
				$data['level_counts']          = $lvl_count;
			    $data['tourn_id']	           = $tourn_id;
			    $data['player']		           = $player;
			    $data['fee']		           = $levelsexist['Fee'];
			    $data['Transaction_id']        = $levelsexist['Transaction_id'];
			    $data['Currency_Code']         = $levelsexist['Currency_Code'];
			    $data['Status']		           = $levelsexist['Status'];
			    $data['RegisterTournament_id'] = $levelsexist['RegisterTournament_id'];

		return $data;
		}

		 public function GetPlayerExtraEventTrans($tourn_id){
			if(!$this->session->userdata('user')){ redirect('login'); }
			    
				$extra_trans = $this->model_league->get_player_extra_trans($tourn_id);
				return $extra_trans;
		 }

		 public function GetPlayerRefTrans($tourn_id){
			if(!$this->session->userdata('user')){ redirect('login'); }
			    
				$extra_trans = $this->model_league->get_player_ref_trans($tourn_id);
				return $extra_trans;
		 }

		 public function Get_Events(){
		 	$events = $_POST['events'];
		 	//print_r($events);exit();
		 	$formats=array();
		 	foreach ($events as $key => $value) {
		 		$evntsarr  = explode('-', $value);
		 		if(!in_array($evntsarr[2], $formats)){
		 		   $formats[] = $evntsarr[2];
		 		}
		 		if($evntsarr[2]=="Singles"){
                   $singles[]=$value;
		 		}
		 		if($evntsarr[2]=="Doubles"){
                   $doubles[]=$value;
		 		}
		 		if($evntsarr[2]=="Mixed"){
                   $mixed[]=$value;
		 		}
		 	}
		 	$f = array();
			$ag = array();
			$lv = array();
            $i = 0;
           // return $formats;exit();
			 if($singles){
					$f[] = $i++;
					$x   = array();

					foreach($singles as $j => $sg){
						$ex = explode('-', $sg);

						if(!in_array($ex[0], $s_ag)){
							$s_ag[]  = $ex[0];
							if(!empty($x)){ $s_lvl[] = $x; }
							$x		 = array();
						}
						$x[] = $ex[3];

						if(++$j == count($singles)){
							if(!empty($x)){ $s_lvl[] = $x; }
						}
					}
						$ag[] = $s_ag;
						$lv[] = $s_lvl;

			 }

			if($doubles){
					$f[] = $i++;
					$x   = array();

					foreach($doubles as $j => $dg){
						$ex = explode('-', $dg);

						if(!in_array($ex[0], $d_ag)){
							$d_ag[]  = $ex[0];
							if(!empty($x)){ $d_lvl[] = $x; }
							$x		 = array();
						}
						$x[] = $ex[3];

						if(++$j == count($doubles)){
							if(!empty($x)){ $d_lvl[] = $x; }
						}
					}
						$ag[] = $d_ag;
						$lv[] = $d_lvl;
			 }

			if($mixed){
				
					$f[] = $i++;
					$x   = array();

					foreach($mixed as $j => $mg){
						$ex = explode('-', $mg);

						if(!in_array($ex[0], $m_ag)){
							$m_ag[]  = $ex[0];
							if(!empty($x)){ $m_lvl[] = $x; }
							$x		 = array();
						}
						$x[] = $ex[3];

						if(++$j == count($mixed)){
							if(!empty($x)){ $m_lvl[] = $x; }
						}
					}
						$ag[] = $m_ag;
						$lv[] = $m_lvl;
			 }
			  $levels  = array_combine($f, $lv);
			  $age_grp = array_combine($f, $ag);
              $data['json_formats'] = json_encode($formats);
              $data['json_levels']  = json_encode($levels);
			  $data['json_ag']	   = json_encode($age_grp);
		 	return $data;
		 }

		 public function getEventTime(){
			$tourn_id=$_POST['tourn_id'];
			$selected_events=$_POST['events'];
			$time=array();
			//echo "<pre>";print_r($selected_events);exit();
			$tour_det = $this->model_league->getonerow($tourn_id);

		    $multi_event_timejsn=json_decode($tour_det->Multi_Event_Time,true);

			foreach($selected_events as $evnt){
			   if (array_key_exists($evnt,$multi_event_timejsn)){
                   $time[$evnt]=$multi_event_timejsn[$evnt];
                }
              
			}
			$cnt=array_count_values($time);
					//a new array
		    $newArray = array();
		    //loop over existing array
		    foreach($time as $k=>$v){
		       //if the count for this value is more than 1 (meaning value has a duplicate)
		        if($cnt[$v] > 1){
		         //add to the new array
		           $newArray[$k] = $v;
		        }
		    }
             echo json_encode($newArray);
			exit();

		}

		public function get_tour_details(){
			$tourn_id=$_POST['tourn_id'];
			$selected_events=$_POST['events'];
			//echo "<pre>";print_r($selected_events);exit();
			$tour_det = $this->model_league->getonerow($tourn_id);
			$res = $this->get_reg_tourn_participants_new($tourn_id);
			$reg_users = $res[0];
			foreach($selected_events as $evnt){
               $users = $this->in_array_r($evnt, $reg_users);

               $users_cnt[$evnt]=count($users);
			}
			
			//echo "<pre>";print_r($reg_tourn_events);exit();
			$tourn_events_limit=json_decode($tour_det->Event_Reg_Limit, true);
			//echo "<pre>";print_r($users_cnt);
			//echo "<pre>";print_r($tourn_events_limit);
			//exit();
			$limits=array();
			foreach ($tourn_events_limit as $event => $limit) {
				        $eventarr=explode('-', $event);
						if(is_numeric($eventarr[2]))
							$num=$eventarr[2];
						else
							$num=$eventarr[3];
                        $getlevel = $this->get_level_name('', $num);
                        $level_name=trim($getlevel['SportsLevel']);
						if($eventarr[1] == '0' or $eventarr[1] == '1'){
							$ages=$eventarr[0];            
							$gen = $this->config->item($ages.'-'.$eventarr[1], 'age_gender_values');
						}
						else{
							$gen=$eventarr[1];            
						}
			            $evnt=$gen.' '.$level_name;
				   
				//$limits[]=array_key_exists($event, $users_cnt);
				//if(array_key_exists($event, $users_cnt)){

				if($limit!=="" || $limit!=NULL){

				 	if($users_cnt[$event] >= $limit and array_key_exists($event, $users_cnt) and in_array($event, $selected_events)){
				 		$waitlistres = $this->model_league->GetWaitlistCount($tourn_id,$event);
				 		$waitlist=$waitlistres+1;
				 		
			   
                        $limits[$evnt]="<span style='color:red; font-size: 13px !important'>You will be in waitlist: ".$waitlist."</span>";
				 	}
					else if(in_array($event, $selected_events)){
				 		$limits[$evnt]="<span style='color:green; font-size: 13px !important''>Available</span>";
				 	} 
				}
				else{
                   //$limits[$evnt]="<span style='color:green;'>Available</span>";
				}
				//}
			}
            echo json_encode($limits);
			exit();

		}


		public function GetWaitListUsers($tourn_id){
             $waitlistres=$this->model_league->GetWaitListUsers($tourn_id);
             return $waitlistres;
		}

		public function get_reg_tourn_participants_withGender($tourn_id, $sport = ''){
        	$res = $this->model_league->get_reg_tourn_participants($tourn_id, $sport);
		  //echo "<pre>";print_r($res);exit();
 				$reg_users  = array();
				$user_tsize = array();

		    foreach($res as $r){
				$event_partners = array();
				if($r->Partners != NULL){
				   $event_partners = json_decode($r->Partners, true);
				}

				if($r->Reg_Events != NULL){
                    $multi_events = json_decode($r->Reg_Events);
	                    foreach ($multi_events as $key => $value){
	                        $reg_users[$r->Users_ID][] = $value;
							if(!empty($event_partners)){
								$user_partners[$r->Users_ID][$value] = $event_partners[$value];
							}
						}
				}
				else{
				    $formats   = json_decode($r->Match_Type);
					$ag_group  = json_decode($r->Reg_Age_Group);
					$sp_levels = json_decode($r->Reg_Sport_Level);

						foreach($formats as $i => $fr){
						    foreach($ag_group[$i] as $j => $ag){
							    foreach($sp_levels[$i][$j] as $lv){
								    $player = $this->general->get_user($r->Users_ID);
								    
								    if($fr == 'Singles' || $fr == 'Doubles'){
		                               $gender = $player['Gender'];
									}
									else{
									   $gender = 2;
									}
								
	      						    $reg_users[$r->Users_ID][] = $ag."-".$gender."-".$fr."-".$lv;
							    }
						    }
					    }
				}
				
				if($r->Partners != NULL){
				   $event_partners = json_decode($r->Partners, true);
				}

				$user_tsize[$r->Users_ID] = $r->TShirt_Size;
			}

			$res = array($reg_users, $user_tsize, $user_partners);

//if($this->logged_user == 240){
//echo "<pre>"; print_r($res); exit;
//}
			return $res;
		 }

		public function GetWaitListUsersNew($tourn_id){
             $waitlistres=$this->model_league->GetWaitListUsersNew($tourn_id);
             return $waitlistres;
		}

		public function sendmail_tm_participants(){
			$player_id		= $this->input->post('player_id');

			if($player_id != ''){
		 	$player_id_arr  = explode(',', $player_id);
			foreach($player_id_arr as $temp){
				$exp = explode('-', $temp);
				$new_arr[] = $exp[0];
				if($exp[1])
				$new_arr[] = $exp[1];
			}
			//echo "<pre>"; print_r($new_arr); 
//exit;
		 	$player_id_arr  = array_values(array_unique($new_arr));
		 	$player_ids_jsn = json_encode($player_id_arr);
			//echo $player_ids_jsn; exit;
		    $subject        = $_POST['sub'];
		    $body           = htmlentities($_POST['msg']);

		    //echo $message;exit();    
            /*if(!empty($_FILES['attach_file']['name'])){		
            	 $file_name=$_FILES['attach_file']['name'];
                 $file_array = explode('.', $file_name);
                 $fileName=$file_array[0];
                 $fileExt=$file_array[1];
                 $newfile=$fileName."_".time().".".$fileExt;	
                 $_FILES['attach_file']['name']		= $newfile;    
				 $filename = 'attach_file'; 
				 $config = array(
				    'upload_path' => "./email_attachments/",
					'allowed_types' => "pdf|txt|doc|docx|jpg|png|gif|csv|xlsx|xls",
					'overwrite' => FALSE,
					'max_size' => "10000" 
					);
				
				
				// Mail with attachment 
				 $this->load->library('upload',$config);
				   $this->upload->initialize($config);
				if($this->upload->do_upload($filename)) 
				{	
			       $data['tourn_id'] = $_POST['tourn_id'];
			       $data['message']  = $message;
			       $data['file']     = $newfile;
			       $data['players']  = $player_ids_jsn;
			     
				   $res = $this->model_league->insert_sendmail_tmparticipants($data);
				   echo $res;
				   exit();
				}
                } */
				// Mail without attachment 
				 $data['tourn_id'] = $_POST['tourn_id'];
				 $data['subject']  = $subject;
			     $data['msg']      = $body;
			     $data['players']  = $player_ids_jsn;
			     //echo "<pre>"; print_r($data); exit;
				 $res = $this->model_league->insert_sendmail_tmparticipants($data);
				 echo $res;
			}
		}

		public function get_prev_refunds($reg_id){
			return $this->model_league->get_prev_refunds($reg_id);
		}

		public function get_tourn_final_line_matches($bid, $round_num){
           return $this->model_league->get_tourn_final_line_matches($bid, $round_num);
		}

		public function get_tourn_rr_matches($bid){
           return $this->model_league->get_tourn_rr_matches($bid);
		}

		public function get_tourn_winners($bid){
           return $this->model_league->get_tourn_winners($bid);
		}

        public function get_users_bygender($users, $gender){

          $res = $this->model_league->get_users_bygender($users, $gender);
            
			return $res;
        }

        public function array_flatten($array) { 
			  if (!is_array($array)) { 
			    return FALSE; 
			  } 
			  $result = array(); 
			  foreach ($array as $key => $value) { 
			    if (is_array($value)) { 
			      $result = array_merge($result, league::array_flatten($value)); 
			    } 
			    else { 
			      $result[$key] = $value; 
			    } 
			  } 
			  return $result; 
        }

		public function ShowDraw($bracket_id)
		{
			$data['bracket_id']  = $bracket_id;
			$get_bracket		 = $this->model_league->get_bracket_rounds($data);
			$data['get_bracket'] = $get_bracket;
			$data['match_type']  = $get_bracket['Match_Type'];
			$tr_id				 = $get_bracket['Tourn_ID'];
			
			$tourn_det = $this->model_league->getonerow($tr_id);
			$data['tour_details']  = $get_bracket['Match_Type'];


			if($get_bracket['Bracket_Type'] == 'Single Elimination'){
				$data['get_tourn_matches'] = $this->model_league->get_tourn_matches($data);
			}
			else if($get_bracket['Bracket_Type'] == 'Consolation'){
				$data['get_tourn_matches'] = $this->model_league->get_tourn_matches_main($bracket_id);
				$data['get_cd_tourn_matches'] = $this->model_league->get_cd_tourn_matches($bracket_id);
				$data['get_cd_num_rounds'] = $this->model_league->get_cd_tot_rounds($bracket_id);
			}
			else if($get_bracket['Bracket_Type'] == 'Round Robin'){
				$data['get_rr_tourn_matches'] = $this->model_league->get_tourn_matches($data);
			}
			else if($get_bracket['Bracket_Type'] == 'Play Off'){
				$data['get_po_tourn_matches']	= $this->model_league->get_po_tourn_matches($bracket_id);
				$data['get_po_line_matches']	= $this->model_league->get_po_line_matches($bracket_id);
			}

				if($tourn_det->tournament_format == 'Teams' and $get_bracket['Bracket_Type'] == 'Play Off'){
					return $this->load->view('teams/view_team_po_draws', $data);
				}
				else if($tourn_det->tournament_format == 'Teams' and $get_bracket['Bracket_Type'] == 'Single Elimination'){
					return $this->load->view('teams/view_team_se_draws_print', $data);
				}
				else if($tourn_det->tournament_format == 'Teams'){
					return $this->load->view('view_team_print_draws', $data);
				}
				else if($tourn_det->tournament_format == "TeamSport" and $get_bracket['Bracket_Type'] == 'Single Elimination'){
					$this->load->view('teams/view_teamsport_se_draws', $data);
				}
				else if($tourn_det->tournament_format == "TeamSport" and $get_bracket['Bracket_Type'] == 'Round Robin'){
					$this->load->view('teams/view_teamsport_rr_draws', $data);
				}
				else{
					return $this->load->view('view_se_print_draws', $data);
				}

		}

		public function get_user_sport_intrests($user_id,$sport){	
			$Sports_Interests = $this->model_league->get_user_sport_intrests($user_id,$sport);
			return $Sports_Interests;
		}

		public function get_membership_details($user_id){
			$membership_det = $this->model_league->get_membership_details($user_id);
			return $membership_det;
		}

		public function get_club($org_id){
			return $this->model_league->get_club($org_id);
		}

		public function GetStates(){
        	if($this->input->post('coach_country')){
        		$country = $this->input->post('coach_country');
        		$id   = "coachstates";
        		$name = "coach_state";
        	}else if($this->input->post('club_country')){
        		$country = $this->input->post('club_country');
        		$id   = "clubstates";
        		$name = "club_state";
        	}else if($this->input->post('clubcountry')){
        		$country = $this->input->post('clubcountry');
        		$id   = "addclubstates";
        		$name = "addclub_state";
        	}else{
        		$country = $this->input->post('country');
        		$id   = "states";
        		$name = "state";
        	}
        	
        if($country == 'United States of America'){
        	$states = array('Alabama','Alaska','Arizona','Arkansas','California','Colorado','Connecticut','Delaware','District of Columbia','Florida','Georgia','Hawaii','Idaho','Illinois','Indiana','Iowa','Kansas','Kentucky','Louisiana','Maine','Maryland','Massachusetts','Michigan','Minnesota','Mississippi','Missouri','Montana','Nebraska','Nevada','New Hampshire','New Jersey','New Mexico','New York','North Carolina','North Dakota','Ohio','Oklahoma', 'Oregon','Pennsylvania','Rhode Island','South Carolina','South Dakota','Tennessee','Texas','Utah','Vermont','Virginia','Washington','West Virginia','Wisconsin','Wyoming'); 
        }else if($country == 'India'){
            $states = array('Andhra Pradesh','Arunachal Pradesh','Assam','Bihar','Chhattisgarh','Goa','Gujarat','Haryana','Himachal Pradesh','Jammu and Kashmir','Jharkhand','Karnataka','Kerala','Madhya Pradesh','Maharashtra','Manipur','Meghalaya','Mizoram','Nagaland','Odisha','Punjab','Rajasthan','Sikkim','Tamil Nadu','Telangana','Tripura','Uttar Pradesh','Uttarakhand','West Bengal');
        }else{
        	$states = array();
        }

		$dropdown="";
		$dropdown.='<input class="form-control" placeholder="State" list="'.$id.'" name="'.$name.'" />';
		$dropdown.='<datalist id="'.$id.'">';

        foreach ($states as $key => $state) {
        	$dropdown.='<option value="'.$state.'">';
        }
        $dropdown.='</datalist>';
	
         	echo $dropdown; exit;
        }

        public function players_rankings_print($params = ''){
	       $params = json_decode($_GET['params']);

			if($params[0]) {

				$data['search_uname'] = $params[0]->name;
				$data['country']	  = $params[0]->country;
				$data['state']	      = $params[0]->state;
				$age_group            = json_decode($params[0]->age_group);
                $data['age_group']    = $age_group;
                $data['gender']       = $params[0]->gender;
				$data['sport']		  = $params[0]->sport;

				$data['loc_query']	  = $this->model_league->search_players_rankings($data);

				$this->load->view('view_players_rankings_print', $data);
			}
		}

		public function get_consolation_players($tour_id, $bracket_id){
			$res = $this->model_league->get_consolation_players($tour_id, $bracket_id);

			return $res;
		}

	    public function AddRating(){
	    	
			if($this->logged_user){
			$data['ratings']       = $this->input->post('rating');
		 	$data['coach_id']      = $this->input->post('coach_id');
		    $data['comments']      = $this->input->post('comments');
		    $data['anonymous']     = $this->input->post('anonymous');
		 	$res    = $this->model_league->AddRating($data);
			if($res){
               redirect('player/'.$this->input->post('coach_id')); 
			}
			}
			else{
				echo "Invalid Access!";
			}
		}

		public function EditRating(){
			if($this->logged_user){
				$data['ratings']       = $this->input->post('rating');
				$data['coach_id']      = $this->input->post('coach_id');
				$data['comments']      = $this->input->post('comments');
				$data['anonymous']     = $this->input->post('anonymous');
				$res    = $this->model_league->UpdateRating($data);
				if($res){
				   redirect('player/'.$this->input->post('coach_id')); 
				}
			}
			else{
				echo "Invalid Access!";
			}
		}

		public function getUserRatings($coach_id){
            $res = $this->model_league->getUserRatings($coach_id);
			return $res;
		}

		public function getCoachRatings($coach_id){
            $res = $this->model_league->getCoachRatings($coach_id);
            
			return $res;
		}

		public function getTournRegUsers($tourn_id){
			return $this->model_league->getTournRegUsers($tourn_id);
		}

		public function GetRefundAmnt(){

		 $reg_level_count = json_decode($this->input->post('level_count'), true);
		 $tourn_fee   = json_decode($this->input->post('tourn_fee'), true);
		 $sel_events  = $this->input->post('sel_events');
		 $ag_grp	  = array();
		 $s			  = 0;

		 foreach($sel_events as $event){
			$arr = explode('-', $event);
			   if(!array_key_exists($arr[0], $ag_grp)){
					$ag_grp[$arr[0]] = 1;
			   }
			   else{
					$ag_grp[$arr[0]] += 1;
			   }
		 }
		/* echo "<pre>";
		 print_r($ag_grp);
		  echo "<pre>";
		 
		 print_r($reg_level_count);
		 exit();*/
		 //print_r($tourn_fee);

			$sub_tot = 0;
				foreach($ag_grp as $g => $grp){
				$ref_tot = 0;

					for($i = 1; $i <= $grp; $i++){
						if($grp == $reg_level_count[$g] and $i == $reg_level_count[$g]){
							$ref_tot += $tourn_fee[$g]['fee'];
						}
						else{
							$ref_tot += $tourn_fee[$g]['extra_fee'];
						}
						//echo 'ref_tot '.$ref_tot."<br>";
					}
						$sub_tot += $ref_tot;
				}
				//echo 'sub_tot '.$sub_tot."<br>";

				$x	 = (10/100)*$sub_tot;
				$rem = $sub_tot - $x;

			//echo number_format($sub_tot,2);
			echo number_format($rem, 2);
		}

/*
			public function regenerate_events($mult_events){
			$revised_array = array();
//echo "<pre>";
//print_r($mult_events);

			foreach($mult_events as $key => $val){
				if(is_numeric($key)){
				   $arr = explode('-', $val);
				   $ag		= $arr[0];
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

				   if( $arr[1] != 'Open')
				   $get_level_label = league::get_level_name('', $level);

					$lbl = '';
					if($get_level_label['SportsLevel'] != 'Open')
						$lbl = ' '.$get_level_label['SportsLevel'];

					if($ag == 'Adults')
				   $revised_array[$val] = $gen.' '.$format.$lbl;
					else if($ag[0] != 'A')
				   $revised_array[$val] = $gen.' '.$format.$lbl;
					else
				   $revised_array[$val] = $gen;
				  // $revised_array[$val] = $gen.' '.$format.' '.$level;
				  // ksort($revised_array);
				}
				else{
				   $arr = explode('-', $key);
				   $ag		= $arr[0];
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

				   if( $arr[1] != 'Open')
				   $get_level_label = league::get_level_name('', $level);

					$lbl = '';
					if($get_level_label['SportsLevel'] != 'Open')
						$lbl = ' '.$get_level_label['SportsLevel'];


					if(is_numeric($val)){
						if($ag == 'Adults')
						$revised_array[$gen.' '.$format.$lbl] = number_format($val, 2);
						else if($ag[0] != 'A')
						$revised_array[$gen.' '.$format.$lbl] = number_format($val, 2);
						else
						$revised_array[$gen.' '.$format.' '.$level] = number_format($val, 2);
					}
					else{
						if($ag == 'Adults')
						$revised_array[$gen.' '.$format.$lbl] = $val."+".$arr[1];
						else if($ag[0] != 'A')
						$revised_array[$gen.' '.$format.$lbl] = $val."+".$arr[1];
						else
						$revised_array[$gen.' '.$format.' '.$level] = $val."+".$arr[1];
					}
				   //ksort($revised_array);
				}
			}
			
			//print_r($revised_array);
			return $revised_array;
		}
*/


			public function regenerate_events($mult_events){
			$revised_array = array();
/*echo "<pre>";
print_r($mult_events);*/

			foreach($mult_events as $key => $val){
				if(is_numeric($key)){
				   $arr = explode('-', $val);
				   $ag		= $arr[0];
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

				   if( $arr[1] != 'Open')
				   $get_level_label = league::get_level_name('', $level);

					$lbl = '';
					//if($get_level_label['SportsLevel'] != 'Open') // uncomment this if wants to hide the Open label in level section

						$lbl = ' '.$get_level_label['SportsLevel'];
				   $revised_array[$val] = $gen.' '.$format.$lbl;
				  // ksort($revised_array);
				}
				else{
				   $arr = explode('-', $key);
				   $ag		= $arr[0];
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

				   if( $arr[1] != 'Open')
				   $get_level_label = league::get_level_name('', $level);

						$lbl = '';

					//if($get_level_label['SportsLevel'] != 'Open')
						$lbl = ' '.$get_level_label['SportsLevel'];


					if(is_numeric($val)){
					$revised_array[$gen.' '.$format.$lbl] = number_format($val, 2);
					}
					else{
					$revised_array[$gen.' '.$format.$lbl] = $val."+".$arr[1];
					}
				   //ksort($revised_array);
				}
			}
			
			//print_r($revised_array);
			return $revised_array;
		}

	    public function get_reg_tourn_participants_new($tourn_id){
			$res = $this->model_league->get_reg_tourn_participants($tourn_id);
			//print_r($res);exit();
				$reg_users  = array();
				$user_tsize = array();
			foreach($res as $r){	
			    if($r->Reg_Events != NULL){
	               $reg_events = json_decode($r->Reg_Events);
	                foreach ($reg_events as $key => $value){
	               	    $reg_users[$r->Users_ID][] = $value;
	                }
			    }
				else{
				    $formats   = json_decode($r->Match_Type);
					$ag_group  = json_decode($r->Reg_Age_Group);
					$sp_levels = json_decode($r->Reg_Sport_Level);

					foreach($formats as $i => $fr){
						foreach($ag_group[$i] as $j => $ag){
							foreach($sp_levels[$i][$j] as $lv){

								$player=$this->general->get_user($r->Users_ID);

								if($fr == 'Singles' || $fr == 'Doubles'){
	                               $gender = $player['Gender'];
								}else
								{
								   $gender = 2;
								}
	      						$reg_users[$r->Users_ID][] = $ag."-".$gender."-".$fr."-".$lv;
							}
						}
					}

			    }

				$user_tsize[$r->Users_ID] = $r->TShirt_Size;
			}

			$res = array($reg_users, $user_tsize);
			return $res;
		}

		public function get_logged_user_role($tid){

			$tr_det = $this->model_league->getonerow($tid);

			if($this->logged_user){
				$is_reg	= $this->user_reg_or_not($this->logged_user, $tid);			

				if($tr_det->Usersid == $this->logged_user or $tr_det->Tournament_Director == $this->logged_user or $this->is_super_admin){    /// tournament admin access links
				$this->logged_user_role = 'Admin';
				}
				else if($this->session->userdata('users_id') == 3380 and $tid == 2383){
					$this->logged_user_role = "Admin";
					$this->is_super_admin   = 1;
				}

				else if($is_reg){
				$this->logged_user_role = 'RegPlayer';
				}
				else{
					$is_team_capt = $this->model_league->is_tourn_reg_team_captain($this->logged_user, $tid);
					if($is_team_capt){
						$this->logged_user_role = 'TeamCaptain';
					}
				}
			}
			else{
				$this->logged_user_role = 'Visitor';
			}

			return $tr_det;
		}

		public function viewtournament($tid, $stat = '', $org_id = '')
		{
			$this->session->unset_userdata('draw');
			
			$data['org_url_key'] = "";

			if($org_id){
				$this->load->model('academy_mdl/model_academy');
				$org_details			 = $this->model_academy->get_academy_details($org_id);
				$data['org_details']	 = $org_details;
				$data['org_url_key'] = $org_details['Aca_URL_ShortCode']."/";
				$data['is_academy_league'] = 1;
			}

			if(!is_numeric($tid)){ echo "Invalid Request!"; exit; }

			$tr_det = $this->model_league->getonerow($tid);
			if($tr_det)
			{

				$is_reg	= $this->user_reg_or_not($this->logged_user, $tid);

				if($tr_det->Tournament_Director == $this->logged_user 
					or $tr_det->Usersid == $this->logged_user 
					or $this->is_super_admin){    // tournament admin access links
				$this->logged_user_role = 'Admin';
				}
				else if($is_reg){
				$this->logged_user_role = 'RegPlayer';
				}

				if($this->logged_user_role != 'Admin' and !$this->is_super_admin and !$tr_det->Is_Publish){
					echo "<h3>Invalid Tournament!</h3>"; exit;
				}

				$this->is_team_league = ($tr_det->tournament_format  == 'Teams' || $tr_det->tournament_format  == 'TeamSport') ? 1 : 0;

				$data['tr_det'] = $tr_det;
				if($org_id)
					$this->load->view('academy_views/includes/academy_league_header', $data);
				else
					$this->load->view('includes/header', $data);

				$data['tour_details']	= $tr_det;
				$data['results']		= $this->model_news->get_news();
				$data['reg_suc']		= $stat;
				
				/* Filtering MyMatches */
				$count = 0;
				$data['valid_draws_count']  = $count;
				$data['show_draw_bid']		= 0;
               
				if($this->logged_user and ($tr_det->Usersid != $this->logged_user and $tr_det->Tournament_Director != $this->logged_user)){


					$brackets = $this->get_bracket_list($tid);
					if(count(array_filter($brackets)) > 0){
						foreach($brackets as $bk)
						{
							if($this->is_team_league){
							$check_user = $this->check_team_is_user_exists($tid, $bk->BracketID, $tr_det->SportsType);
							} else{
							$check_user = $this->check_is_user_exists($tid, $bk->BracketID, $tr_det->SportsType);
							}
							if($check_user){
							$show_bid = $bk->BracketID;
								$count++; 
							}
						}
					}
				$data['valid_draws_count'] = $count;
				$data['show_draw_bid']	   = $show_bid;

				}
				/* Filtering MyMatches */
              
				$data['is_logged_user_reg'] = $this->model_league->is_logged_user_reg($tid);
				$data['participants_count'] = 0;

				if($this->is_team_league){

				$team_fee_type = $tr_det->Fee_collect_type;
				$data['fee_payable'] = '';

				//$data['is_logged_user_reg'] = $this->model_league->get_team_reg_tournment($tourn_id);		

				$user_reg_team = $this->model_league->get_team_reg($this->logged_user, $tid);
				//echo "<pre>";print_r($user_reg_team);exit;
				$data['is_logged_user_reg'] = $user_reg_team;

				 $cur_date = date('Y-m-d');
				 $reg_closed_on = date('Y-m-d', strtotime($tr_det->Registrationsclosedon));

				 /*if(!empty($user_reg_team) and $team_fee_type == 'Player' and $tr_det->Usersid != $this->logged_user and $reg_closed_on >= $cur_date){*/
				 if(!empty($user_reg_team) and $team_fee_type == 'Player' and $reg_closed_on >= $cur_date){
					 
					$team_reg_age_group		= $user_reg_team['Reg_Age_Group'];
					$logged_user_part_team	= $user_reg_team['Team_id'];
			
					$is_paid = $this->model_league->check_is_paid($this->logged_user, $tid, $logged_user_part_team);

					if(!$is_paid){
					$tr_age_group = json_decode($tr_det->Age);
					$tr_fee		  = json_decode($tr_det->mult_fee_collect);

					$key = array_search($team_reg_age_group, $tr_age_group);

					$fee_payable = $tr_fee[$key];
					$data['fee_payable'] = number_format($fee_payable, 2);
					$data['my_reg_team'] = $logged_user_part_team;

					$this->session->unset_userdata('tour_per_player_fee');
					$this->session->unset_userdata('tourn_id_fee_pay');
					$this->session->unset_userdata('tour_reg_team_id');

					$sess_data = array('tour_per_player_fee'=>number_format($fee_payable, 2), 'tourn_id_fee_pay'=>$tid, 'tour_reg_team_id'=>$logged_user_part_team);

					$this->session->set_userdata($sess_data);
					}
				  }
				    $res = $this->model_league->get_team_participants_count($tid);

					/*$tot_players = 0;
					foreach($res as $i => $r){
					$arr = json_decode($r->Team_Players);
					$tot_players += count($arr);
					}*/

				  $data['teams_count'] = count($res);
				}
				else{
               	  $data['participants_count'] = $this->model_league->get_indv_participants_count($tid);
				}

				if($data['is_logged_user_reg'] == '1' and $this->logged_user != ""){

					$check_addr	= $this->model_league->check_user_addr($this->logged_user);
					$data['user_info'] = $check_addr;

					($check_addr->DOB != NULL) 
						? $data['udob'] = 1 : $data['udob'] = 0;

					(($check_addr->UserAddressline1 != NULL and $check_addr->UserAddressline1 != '') 
					or 
					($check_addr->UserAddressline2 != NULL and $check_addr->UserAddressline2 != '')) 
						? $data['uaddr'] = 1 : $data['uaddr'] = 0;

					($check_addr->EmailID != NULL or $check_addr->AlternateEmailID != NULL) 
						? $data['uemail'] = 1 : $data['uemail'] = 0;	
				}
				//echo "<pre>";print_r($data); exit;

				//echo 'ddd'.$data['uaddr'];
				if($data['udob'] == '0' or $data['uaddr'] == '0' or $data['uemail'] == '0'){
					$data['r']		   = $tr_det;
					$data['results']  = $this->model_news->get_news();
					$this->load->view('tournament/view_update_basic_profile', $data); 
					$this->load->view('includes/view_right_column',$data);
				}
				else{
					$data['show_landing_page'] = 1;
					$data['tourn_comments'] = $this->general->get_tourn_comments($tid);
					$data['no_of_brackets']	 = $this->model_league->get_bracket_count($tid);
					$data['tourn_teams']		 = $this->model_league->Get_TournamentTeams($tid);
					$data['sponsor_details']  = $this->model_league->get_sponsorships($tid);
					$data['is_check_in']		 = $this->model_league->is_player_checkin($tid, $this->logged_user);

					$this->load->view('view_tournament_new', $data);
				}

				if($org_id)
					$this->load->view('academy_views/includes/academy_league_footer');
				else
					$this->load->view('includes/footer');


			}
			else
			{
				echo "Invalid Access!";
			}
		}

		public function GetTournamentEvents($tour_details){

            $formats   = json_decode($tour_details->Singleordouble);
            $age_group = json_decode($tour_details->Age);
            $levels    = json_decode($tour_details->Sport_levels);

            $tourn_gender_check = array();

		    if($tour_details->Gender=='all' || $tour_details->Gender=='All'){
			    $tourn_gender_check[0]=1;
			    $tourn_gender_check[1]=0;
			}elseif ($tour_details->Gender=='1') {
			    $tourn_gender_check[0]=1;
			}elseif ($tour_details->Gender=='0') {
			    $tourn_gender_check[0]=0;
			}

		    foreach ($tourn_gender_check as $key => $gender) 
		    {
			    if($gender == 1){
			          $gender_key = 1;
			    }else{
			          $gender_key = 0;
			    }

		        $show_mixed = 1;

			    foreach($formats as $fr){
			     if($fr == 'Mixed' and $gender_key == 1){ $show_mixed = 0; }
			      foreach($age_group as $ag){
			        foreach($levels as $key=>$lv){
			            if($fr != 'Mixed' or  $show_mixed == 1){ 

			               if($fr == 'Mixed'){ $gender_key = 2; }
			       
			                  if($gender_key == 1){
			                    $genderkey = 1;
			                  }else if($gender_key == 0){
			                    $genderkey = 0;
			                  }else if($gender_key == 2){
			                     $genderkey = 2;
			                  }            

			                 $val = $ag."-".$genderkey."-".$fr."-".$lv;
			                 $events[$ag][] = $val;

			            }
			        }
			      }
			    }
		    }

		    return $events;
		}

		public function ShowBracket($bracket_id){

			$data['bracket_id']    = $bracket_id;
			$get_bracket			   = $this->model_league->get_bracket_rounds($data);
			$data['get_bracket']  = $get_bracket;
			$data['match_type']  = $get_bracket['Match_Type'];
			$tr_id						   = $get_bracket['Tourn_ID'];
			$data['club_url']		   = $this->input->post('club_url');
			$data['usr']				= $this->input->post('usr');
			

			$tourn_det = $this->model_league->getonerow($tr_id);

			if($this->input->post('usr') and ($tourn_det->Usersid == $this->input->post('usr') or $tourn_det->Tournament_Director == $this->input->post('usr') or $this->input->post('usr') == 240)){
					$this->logged_user_role = "Admin";
					$this->is_super_admin   = 1;
			}

            $data['tour_details'] = $tourn_det;
            $data['tourn_det'] = $tourn_det;
			if($get_bracket['Bracket_Type'] == 'Single Elimination'){
				$data['get_tourn_matches'] = $this->model_league->get_tourn_matches($data);

				if($this->input->post('tformat') == "Teams"){
			        $data['get_se_line_matches'] = $this->model_league->get_tourn_line_matches($data);
			        $this->load->view('teams/view_team_se_draws', $data);
				}
				else if($this->input->post('tformat') == "TeamSport"){
					$this->load->view('teams/view_teamsport_se_draws', $data);
				}
				else{
					$this->load->view('view_se_draws', $data);
				}
			}
			else if($get_bracket['Bracket_Type'] == 'Consolation'){
				$data['get_tourn_matches'] = $this->model_league->get_tourn_matches_main($bracket_id);
				$data['get_cd_tourn_matches'] = $this->model_league->get_cd_tourn_matches($bracket_id);
				$data['get_cd_num_rounds'] = $this->model_league->get_cd_tot_rounds($bracket_id);
				$this->load->view('view_cd_draws', $data);
			}
			else if($get_bracket['Bracket_Type'] == 'Round Robin'){
				 $data['get_rr_tourn_matches'] = $this->model_league->get_tourn_matches($data);
				 $data['reg_players'] = $this->model_league->get_tourn_reg_players($get_bracket['Tourn_ID']);

				if($tourn_det->tournament_format == 'Teams'){
				  $data['get_rr_line_matches'] = $this->model_league->get_tourn_line_matches($data);
				 // echo "<pre>"; print_r($data); 
				   $this->load->view('teams/view_team_rr_draws', $data);
			    }
				else if($this->input->post('tformat') == "TeamSport"){
					$this->load->view('teams/view_teamsport_rr_draws', $data);
				}
				else{

				   $this->load->view('view_rr_draws', $data);
				}
			}
			else if($get_bracket['Bracket_Type'] == 'Play Off'){
				$data['get_po_tourn_matches']	= $this->model_league->get_po_tourn_matches($bracket_id);
                if($tourn_det->tournament_format == 'Teams'){
				   $data['get_po_line_matches']	= $this->model_league->get_po_line_matches($bracket_id);
				   $this->load->view('teams/view_team_po_draws', $data);
			    }
			}
			else if($get_bracket['Bracket_Type'] == 'drive_chip_putt' or $get_bracket['Bracket_Type'] == 'conventional'){
				$data['golf_tourn_matches'] = $this->model_league->get_golf_tourn_matches($data);
                $this->load->view('view_golf_draws', $data);
			}
			else if($get_bracket['Bracket_Type'] == 'Challenge Ladder'){
				$data['cl_positions'] = $this->model_league->get_cl_positions($data);

				$events = array();

				if($tourn_det->Multi_Events != NULL){
					$multi_events = json_decode($tourn_det->Multi_Events);

					foreach($multi_events as $key => $event) {
					$arr = explode('-', $event);
					$ag  = $arr[0];

					$events[$ag][] = $event;
					}
				}
				else{
					$events = $this->GetTournamentEvents($tour_det);
				}

				$data['events'] = $events;

                $this->load->view('view_cl_draws', $data);
			}
			else if($get_bracket['Bracket_Type'] == 'Switch Doubles'){
				 $data['get_rr_tourn_matches'] = $this->model_league->get_tourn_matches($data);
				 $this->load->view('view_sd_draws', $data);
			}
		}

		public function ShowTeamMatches($bracket_id){
			$data['bracket_id']  = $bracket_id;
			$get_bracket_details = $data['get_bracket_details'] = $this->model_league->get_tourn_bracket($bracket_id);
			$data['match_type']  = $get_bracket_details['Match_Type'];
			$tourn_det = $this->model_league->getonerow($get_bracket_details['Tourn_ID']);
            $data['tour_details'] = $tourn_det;
			$data['reg_page']			 = '';

			switch($get_bracket_details['Bracket_Type']){
				case 'Round Robin':
					$data['reg_page']	  = "My_Matches";
					$data['rr_bracket_matches'] = $this->model_league->get_tourn_matches($data);

					if($data['rr_bracket_matches']->num_rows() == 0){
						$data['no_matches'] = "Matches are not available for the given criteria.";
					}

					if($tourn_det->tournament_format == "Teams"){
						$data['rr_line_matches'] = $this->model_league->get_tourn_line_matches($data);
						$this->load->view('teams/view_team_rr_addscore', $data);
					}
					else if($tourn_det->tournament_format == "TeamSport"){
						$this->load->view('teams/view_teamsport_rr_addscore', $data);
					}
				break;

				case 'Single Elimination':
				    $data['bracket_matches'] = $this->model_league->get_tourn_matches($data);

					if($data['bracket_matches']->num_rows() == 0){
						$data['no_matches']  = "Matches are not available for the given criteria.";
					}

					//echo "<pre>"; print_r($data['bracket_matches']); 
					if($tourn_det->tournament_format == "Teams"){
						$data['se_line_matches'] = $this->model_league->get_tourn_line_matches($data);
						$this->load->view('teams/view_team_se_addscore', $data);
					}
					else if($tourn_det->tournament_format == "TeamSport"){
						$this->load->view('teams/view_teamsport_se_addscore', $data);
					}
					else{
						$this->load->view('view_se_addscore', $data);
					}

					break;

				case 'Play Off':
				    $data['po_bracket_matches'] = $this->model_league->get_tourn_matches($data);

					if($data['po_bracket_matches']->num_rows() == 0){
						$data['no_matches'] = "Matches are not available for the given criteria.";
					}

					if($tourn_det->tournament_format == "Teams"){
						$data['po_line_matches'] = $this->model_league->get_tourn_line_matches($data);
						$this->load->view('teams/view_team_po_addscore', $data);
					}
					//echo "<pre>"; print_r($data['po_bracket_matches']); print_r($data['po_line_matches']); exit;
				break;

				case 'Consolation':
					if(!$get_bracket_details['BracketID']){
						$data['no_matches'] = "Matches are not available for the given criteria.";
					}
					else{
						$data['bracket_matches_main'] = $this->model_league->get_tourn_matches_main($bracket_id);
						$data['bracket_matches_cd']	  = $this->model_league->get_cd_tourn_matches($bracket_id);
						$data['cd_num_rounds']		  = $this->model_league->get_cd_tot_rounds($bracket_id);
					}

					if($tourn_det->tournament_format == "Teams"){
						/*$data['rr_line_matches'] = $this->model_league->get_tourn_line_matches($data);
						$this->load->view('view_team_rr_addscore', $data);*/
					}
					else{
						$this->load->view('view_cd_addscore', $data);
					}
				break;

				case 'drive_chip_putt':
				case 'conventional':
					$data['golf_bracket_matches'] = $this->model_league->get_golf_tourn_matches($data);

					if($data['golf_bracket_matches']->num_rows() == 0){
						$data['no_matches'] = "Matches are not available for the given criteria.";
					}
				break;

				case 'Challenge Ladder':
					$data['cl_bracket_matches'] = $this->model_league->get_cl_matches($data);
					$this->load->view('view_cl_addscore', $data);
				break;

				case 'Switch Doubles':
					$data['sd_bracket_matches'] = $this->model_league->get_sd_matches($data);
					$this->load->view('view_sd_addscore', $data);
				break;
			}
		}

		public function ShowMatches($bracket_id){

			$data['bracket_id']		= $bracket_id;
			$get_bracket_details	= $this->model_league->get_tourn_bracket($bracket_id);
			$data['match_type']		= $get_bracket_details['Match_Type'];
			$tr_id							= $get_bracket_details['Tourn_ID'];
	
			if($this->session->userdata('users_id') == 3380 and $tr_id == 2383){
			$this->logged_user_role = "Admin";
			$this->is_super_admin   = 1;
			}

			$tourn_det = $this->model_league->getonerow($tr_id);
			$this->is_team_league = ($tourn_det->tournament_format  == 'Teams') ? 1 : 0;
			
			//$data['bracket_id']			 = $get_bracket_details['BracketID'];
			$data['get_bracket_details'] = $get_bracket_details;
            $data['tour_details']		 = $tourn_det;
            $data['tourn_det']			 = $tourn_det;
			$data['reg_page']			 = '';

				if($get_bracket_details['Bracket_Type'] == 'Round Robin')
				{
					$data['reg_page']	  = "My_Matches";

				    $data['rr_bracket_matches'] = $this->model_league->get_tourn_matches($data);

					if($data['rr_bracket_matches']->num_rows() == 0){
						$data['no_matches'] = "Matches are not available for the given criteria.";
					}

					if($tourn_det->tournament_format == "Teams"){
						$data['rr_line_matches'] = $this->model_league->get_tourn_line_matches($data);
//echo "<pre>"; print_r($data); exit;
						$this->load->view('teams/view_team_rr_addscore', $data);
					}
					else if($tourn_det->tournament_format == "TeamSport"){
						$this->load->view('teams/view_teamsport_rr_addscore', $data);
					}
					else{
						$this->load->view('view_rr_addscore', $data);
					}
				}
				else if($get_bracket_details['Bracket_Type'] == 'Single Elimination')
				{
				    $data['bracket_matches'] = $this->model_league->get_tourn_matches($data);

					if($data['bracket_matches']->num_rows() == 0){
						$data['no_matches']  = "Matches are not available for the given criteria.";
					}

					//echo "<pre>"; print_r($data['bracket_matches']); 
					if($tourn_det->tournament_format == "Teams"){
						$data['se_line_matches'] = $this->model_league->get_tourn_line_matches($data);
						$this->load->view('teams/view_team_se_addscore', $data);
					}
					else if($tourn_det->tournament_format == "TeamSport"){
						$this->load->view('teams/view_teamsport_se_addscore', $data);
					}
					else{
						$this->load->view('view_se_addscore', $data);
					}
				}
				else if($get_bracket_details['Bracket_Type'] == 'Play Off')
				{
				    $data['po_bracket_matches'] = $this->model_league->get_tourn_matches($data);

					if($data['po_bracket_matches']->num_rows() == 0){
						$data['no_matches'] = "Matches are not available for the given criteria.";
					}

					if($tourn_det->tournament_format == "Teams"){
						$data['po_line_matches'] = $this->model_league->get_tourn_line_matches($data);
						$this->load->view('teams/view_team_po_addscore', $data);
					}
					//echo "<pre>"; print_r($data['po_bracket_matches']); print_r($data['po_line_matches']); exit;
				}
				else if($get_bracket_details['Bracket_Type'] == 'Consolation')
				{
					if(!$get_bracket_details['BracketID']){
						$data['no_matches'] = "Matches are not available for the given criteria.";
					}
					else{
						$data['bracket_matches_main'] = $this->model_league->get_tourn_matches_main($bracket_id);
						$data['bracket_matches_cd']	  = $this->model_league->get_cd_tourn_matches($bracket_id);
						$data['cd_num_rounds']		  = $this->model_league->get_cd_tot_rounds($bracket_id);
					}

					if($tourn_det->tournament_format == "Teams"){
						/*$data['rr_line_matches'] = $this->model_league->get_tourn_line_matches($data);
						$this->load->view('view_team_rr_addscore', $data);*/
					}
					else{
						$this->load->view('view_cd_addscore', $data);
					}
				}
				else if($get_bracket_details['Bracket_Type'] == 'drive_chip_putt' or $get_bracket_details['Bracket_Type'] == 'conventional'){
					$data['golf_bracket_matches'] = $this->model_league->get_golf_tourn_matches($data);

					if($data['golf_bracket_matches']->num_rows() == 0){
						$data['no_matches'] = "Matches are not available for the given criteria.";
					}
				}
				else if($get_bracket_details['Bracket_Type'] == 'Challenge Ladder'){
					$data['cl_bracket_matches'] = $this->model_league->get_cl_matches($data);
					$this->load->view('view_cl_addscore', $data);
				}
				else if($get_bracket_details['Bracket_Type'] == 'Switch Doubles'){
					$data['sd_bracket_matches'] = $this->model_league->get_sd_matches($data);
					$this->load->view('view_sd_addscore', $data);
				}
		}

		 public function register_more($tourn_id)
		 {
			if(!$this->logged_user){
				redirect('login');
			}

			$tourn_id	 = $this->uri->segment(3);
            //echo $tourn_id;
			$details	 = $this->model_league->getonerow($tourn_id);
			$now		 =  strtotime("now"); $oneday = 86400;
			$reg_close	 = strtotime($details->Registrationsclosedon) + $oneday;
			$tourn_sport = $details->SportsType;
			$is_reg		 = 0;
		
			if(!$details->Is_Publish and !$this->is_super_admin and $this->logged_user != $details->Usersid and $this->logged_user != $details->Tournament_Director) {
					echo "<h3>Invalid Tournament!</h3>"; exit;
			}

				$is_reg = $this->model_league->get_reg_tournment($tourn_id);	

			//if($now < $reg_close or $is_reg){

				$user_id = $this->logged_user;
				$res = $this->model_league->get_reg_tournment($tourn_id);
			   
				$ag_group    = $this->general->get_user_agegroup();

				$data['ag_grp'] = $ag_group['UserAgegroup'];
				$data['user_age_dat'] = $ag_group;
				
				if(($res['Tournament_ID'] == $tourn_id && $res['Users_ID'] == $user_id) or $is_reg)
				{
					$results   = array();              
					$user_reg_ag_grps   = array();  

					if($res['Reg_Events'] != NULL){

                        $reg_events = json_decode($res['Reg_Events']);

						foreach ($reg_events as $key => $event) {
							$results[] = $event;
							$arr = explode('-', $event);
							$user_reg_ag_grps[] = $arr[0];
						}

					}else{

	                    $formats   = json_decode($res['Match_Type']);
						$ag_group  = json_decode($res['Reg_Age_Group']);
						$sp_levels = json_decode($res['Reg_Sport_Level']);

					    foreach($formats as $i => $fr){
							foreach($ag_group[$i] as $j => $ag1){
								foreach($sp_levels[$i][$j] as $k => $lv1){
							        $player=$this->general->get_user($res['Users_ID']);

                                    $gender_key = $player['Gender'];
		      						$results[] = $ag1."-".$gender_key."-".$fr."-".$lv1;
									$user_reg_ag_grps[] = $ag1;
									  
								}
								
							}
						}

					}     
					//if($this->logged_user == 237)
	               //  echo "<pre>"; print_r($user_reg_ag_grps); exit;
				
					$details	= $this->model_league->getonerow($tourn_id);
					$check_dob	= $this->model_league->check_user_dob($user_id);
					$check_addr	= $this->model_league->check_user_addr($user_id);
					$data['user_info'] = $check_addr;

					($check_dob->DOB != NULL) ? $data['udob'] = 1 : $data['udob'] = 0;

					(($check_addr->UserAddressline1 != NULL and $check_addr->UserAddressline1 != '') 
						or 
					 ($check_addr->UserAddressline2 != NULL and $check_addr->UserAddressline2 != '')) ? $data['uaddr'] = 1 : $data['uaddr'] = 0;
					
					($check_addr->EmailID != NULL or $check_addr->AlternateEmailID != NULL) ? $data['uemail'] = 1 : $data['uemail'] = 0;

					$data['r'] = $details;
					$data['regdata'] = $results;
					$data['results'] = $this->model_news->get_news();
					$data['user_reg_ag_grps'] = $user_reg_ag_grps;


					$this->load->view('includes/header');
					$this->load->view('view_register_more_matches', $data); 
					$this->load->view('includes/view_right_column',$data);
					$this->load->view('includes/footer');	
				}
				else{
				    echo "Oops! Something went wrong, Please contact admin@a2msports.com";
				}
			//}
			/*else{
				echo "Sorry, Registrations are closed!";
			}*/
		 }

		 public function get_tour_fee_more_events()
		 {
			/*echo "<pre>";
			 print_r($_POST);
			exit;*/

			$this->session->unset_userdata('tour_reg_fee');
			$this->session->unset_userdata('reg_tour_id');

			$tour_id = $this->input->post('tour_id');
			$ag_grp  = $this->input->post('ag_grp');
			$is_flag_age  = $this->input->post('is_flag_age');
			$user_age_grp = $this->input->post('user_age_grp');
			$sg		 = $this->input->post('sg');
			$db		 = $this->input->post('db');
			$mx		 = $this->input->post('mx');

			$user_reg_age_grps = json_decode($this->input->post('user_reg_age_grps'));

			// -------------------
			foreach($user_reg_age_grps as $reg_ag_grp){
				if(strpos($reg_ag_grp, 'dults_') and !in_array('Adults', $user_reg_age_grps)){
					$user_reg_age_grps[] = 'Adults';
				}
			}
			// -------------------

			$get_tour_info = $this->model_league->getonerow($tour_id);

			if($get_tour_info->Tournamentfee == 1){
				$db_ag_grp   = json_decode($get_tour_info->Age);
				$db_levels   = json_decode($get_tour_info->Sport_levels);
				$db_fee		 = json_decode($get_tour_info->mult_fee_collect);
				$db_addn_fee = json_decode($get_tour_info->addn_mult_fee_collect);
				$exis_ag	 = array();
				$total_fee = 0.00;
				
				foreach($ag_grp as $i => $ag){

					/*if($is_flag_age==1){
                       $index = array_search($user_age_grp, $db_ag_grp);        
				    }else{*/
					   $index = array_search($ag, $db_ag_grp);
				    //}
				    //echo $is_flag_age;exit;

					//$index	= array_search($ag, $db_ag_grp);
					$fee		= 0.00;
					$extra_fee  = 0.00;

					if(!in_array($ag, $user_reg_age_grps) and !in_array($ag, $exis_ag)){
					    $fee		= number_format($db_fee[$index], 2);
						/*if($fee == 0.00){
	                      $fee		= number_format($db_fee[array_search($ag_grp[0], $db_ag_grp)], 2);  
						}*/
					}
					else{
						$extra_fee	= number_format($db_addn_fee[$index], 2);
					}
					$exis_ag[] = $ag;
					
				   $total_fee += ($fee + $extra_fee);
				}
			}
			else{
				$total_fee = 0.00;
			}

			$sess_data = array('tour_reg_fee'=>number_format($total_fee, 2), 'reg_tour_id'=>$tour_id);
			$this->session->set_userdata($sess_data);

			echo number_format($total_fee, 2);    // Returns the Total Payable price to the view 
		 }

		public function load_adm_participants($tid){
			$tid	= $this->input->post('tid');
			$tr_det = $this->get_logged_user_role($tid);
			$this->is_team_league = ($tr_det->tournament_format  == 'Teams' || $tr_det->tournament_format  == 'TeamSport') ? 1 : 0;

			$data['tour_details'] = $tr_det;
			if($this->is_team_league){
				echo $this->load->view('teams/view_adm_team_participants', $data);
			}
			else{
				echo $this->load->view('tournament/view_adm_participants', $data);
			}
		}

		public function load_participants($tid){
			//error_reporting(-1);
			$tid	= $this->input->post('tid');
			$tr_det = $this->get_logged_user_role($tid);
			$this->is_team_league = ($tr_det->tournament_format  == 'Teams' || $tr_det->tournament_format  == 'TeamSport') ? 1 : 0;

			$data['tour_details'] = $tr_det;
			if($this->is_team_league){
				echo $this->load->view('teams/view_team_participants', $data);
			}
			else{
				echo $this->load->view('tournament/view_participants', $data);
			}
		}

		public function load_draws_results($tid=''){
			$tid	= $this->input->post('tid');
			$data['club_url'] = $this->input->post('club_url');
			$tr_det = $this->get_logged_user_role($tid);
			$data['tour_details'] = $tr_det;

			echo $this->load->view('tournament/view_drawresults', $data);
		}

		public function load_reg_team_players($tid){
			$tid	= $this->input->post('tid');
			$tr_det = $this->get_logged_user_role($tid);
			$data['tour_details'] = $tr_det;
			echo $this->load->view('teams/view_team_players', $data);
		}

		public function load_sponsors_results(){
			$tid	= $this->input->post('tid');
			$tr_det = $this->get_logged_user_role($tid);
			$data['tour_details'] = $this->model_league->getonerow($tid);
			$data['sponsor_details'] = $this->model_league->get_sponsorships($tid);
 
  			echo $this->load->view('tournament/view_sponsorsresults', $data);
		}

		public function load_mymatches_results($tid){
			$tid	= $this->input->post('tid');
			$tr_det = $this->get_logged_user_role($tid);
			$this->is_team_league = ($tr_det->tournament_format  == 'Teams') ? 1 : 0;
			$data['tour_details'] = $tr_det;
			echo $this->load->view('tournament/view_mymatches_results', $data);
		}

		public function load_change_partners($tid){
			//error_reporting(-1);
			$tid	= $this->input->post('tid');
			$tr_det = $this->get_logged_user_role($tid);
			$data['tour_details'] = $tr_det;
			echo $this->load->view('tournament/view_change_partners', $data);
		}

		public function load_adm_edit_withdraw($tid){
			$tid	= $this->input->post('tid');
			$tr_det = $this->get_logged_user_role($tid);
			$data['tour_details'] = $tr_det;
			echo $this->load->view('tournament/view_adm_withdrawnew', $data);
		}

		public function load_adm_addscore($tid){
			$tid	= $this->input->post('tid');
			$data['club_url'] = $this->input->post('club_url');
			$tr_det = $this->get_logged_user_role($tid);
			$data['tour_details'] = $tr_det;

			echo $this->load->view('tournament/view_addscore', $data);
		}

		public function load_gallery(){
			$tid	= $this->input->post('tid');
			$data['club_url'] = $this->input->post('club_url');
			$tr_det = $this->get_logged_user_role($tid);
			$data['tour_details'] = $tr_det;
            $data['get_images'] = $this->model_league->get_individual_tourn_images($tid);
			echo $this->load->view('tournament/view_gallery', $data);
		}

		public function load_editdesc(){
			$tid = $this->input->post('tid');
			$data['club_url'] = $this->input->post('club_url');
            $res = $this->model_league->getonerow($tid);
			$data['tourn_id']  = $res->tournament_ID;
			$data['tour_desc'] = $res->TournamentDescription;
			echo $this->load->view('tournament/view_edit_desc', $data);
		}

		public function load_standings(){
			$tid    = $this->input->post('tid');
			$level  = $this->input->post('level');
            $res	= $this->model_league->getonerow($tid);
			$data['tourn_id']		 = $res->tournament_ID;
			$data['sel_level']		 = $level;
			$data['tourn_reg_teams'] = $this->get_reg_team_participants($tid);
			$data['tourn_levels']	 = $res->Sport_levels;
			$data['tourn_format']	 = $res->tournament_format;

			echo $this->load->view('teams/view_team_standings', $data);
		}

		public function get_level_brackets($tid, $level){
			$get_brackets = $this->model_league->get_level_brackets($tid, $level);
			return $get_brackets;
		}

		public function upd_desc(){
			$tid = $this->input->post('tid');	
            $res = $this->model_league->upd_tourn_desc();
			redirect("league/$tid");
		}

		 public function AddClubRating(){
			if($this->input->post('rate_to_club')){
				$data['ratings']   = $this->input->post('rating');
				$data['club_id']   = $this->input->post('club_id');
				$data['comments']  = $this->input->post('comments');
				$data['anonymous'] = $this->input->post('anonymous');
				$sportname  = $this->input->post('sportname');

		 		$res = $this->model_league->AddClubRating($data);
				if($res){
				    redirect(strtolower($sportname)); 
				}
			}
			else{
				echo "Invalid Request!";
			}
		 }

		public function EditClubRating(){			 
			if($this->input->post('rate_to_club')){
				$data['ratings']   = $this->input->post('rating');
				$data['club_id']   = $this->input->post('club_id');
				$data['comments']  = $this->input->post('comments');
				$data['anonymous'] = $this->input->post('anonymous');
				$sportname  = $this->input->post('sportname');

				$res = $this->model_league->UpdateClubRating($data);
				if($res){
				   redirect(strtolower($sportname)); 
				}
			}
			else{
				echo "Invalid Request!";
			}
		}

		public function getClubRatings(){
			$club_id = $this->input->post('clubid');
			$sp_id   = $this->input->post('sport');
			$sport_name = $this->model_league->get_sport_title($sp_id); 
			
			$get_club_ratings	   = $this->model_league->get_club_Rating($club_id);
			$get_user_club_ratings = $this->model_league->getUserClubRatings($club_id);

			/* **** */	
			   $s1=0; $s2=0; $s3=0; $s4=0; $s5=0;
			   foreach ($get_club_ratings as $key => $value) {
                if($value->Ratings==5){
                  $s5+=1;
                } 
                if($value->Ratings==4){
                  $s4+=1;
                } 
                if($value->Ratings==3){
                  $s3+=1;
                } 
                if($value->Ratings==2){
                  $s2+=1;
                }
                if($value->Ratings==1){
                  $s1+=1;
                }
			   }
			   $avg_star_rating = ($s5*5 + $s4*4 + $s3*3 + $s2*2 + $s1*1) / ($s5 + $s4 + $s3 + $s2 + $s1);
			   $data['avg_star_rating'] = $avg_star_rating;
			/* **** */	
			$data['club_ratings']		=  $get_club_ratings; 
			$data['user_club_ratings']  =  $get_user_club_ratings; 
			$data['club_id']			=  $club_id; 
			$data['sport_name']			= $sport_name[Sportname];

   			$this->load->view('clubs/view_show_club_reviews', $data);
		}

		public function get_club_Rating($club_id){
 			$get_ratings = $this->model_league->get_club_Rating($club_id);
		 	return $get_ratings;
		}

		/*public function edit($tourn_id){
			echo "<h3>Page is under maintenance! please check after sometime. Thank you</h3>";
			exit;
		}*/

		public function edit($tourn_id, $org_id = ''){
			 $tournament_details = $this->model_league->getonerow($tourn_id);
			 $reg_users = $this->model_league->get_reg_tourn_participants($tourn_id);
			  $user_id = $this->logged_user;

			$data['org_url_key'] = "";

			if($org_id){
				$this->load->model('academy_mdl/model_academy');
				$org_details			 = $this->model_academy->get_academy_details($org_id);
				$data['org_details']	 = $org_details;
				$data['org_url_key'] = $org_details['Aca_URL_ShortCode']."/";
				$data['is_academy_league'] = 1;
			}

			 if($tournament_details->Usersid == $user_id or $tournament_details->Tournament_Director == $user_id or $this->is_super_admin){
				 		$total_agegroups  = array();
						$total_sprt_lvls  = array();
						$multiEvents_keys = array();
						$reg_events_list  = array();

				foreach ($reg_users as $keys => $value) {
		    		$age_groups = array_unique(json_decode($value->Reg_Age_Group));
					foreach ($age_groups[0] as $key => $val) {		    		
						array_push($total_agegroups, $val);
					}

		     		$sport_lvels = json_decode($value->Reg_Sport_Level);
					foreach ($sport_lvels[0] as $key => $val) {		    		
						foreach ($val as $k => $vl) {		    		
						array_push($total_sprt_lvls, $vl);
						}
					}
					
					$reg_events	 = json_decode($value->Reg_Events, true);
					$reg_age_groups  = array();
					$reg_gender  = array();
					$reg_format  = array();
					$reg_levels  = array();

					foreach($reg_events as $ev){
						$exp = explode('-', $ev);

						if(!in_array($exp[0], $reg_age_groups)){
						array_push($reg_age_groups, trim($exp[0]));
						}

						if(!in_array($exp[1], $reg_gender) and (is_numeric($exp[1]) or $exp[1] == 'Open')){
						array_push($reg_gender, trim($exp[1]));
						}
						else{
						array_push($reg_format, trim($exp[1]));
						}

						if(!in_array($exp[2], $reg_format) and !is_numeric($exp[2])){
						array_push($reg_format, trim($exp[2]));
						}
						else if(!in_array($exp[2], $reg_levels)){
						array_push($reg_levels, trim($exp[2]));
						}

						if(!in_array($exp[3], $reg_levels)){
						array_push($reg_levels, trim($exp[3]));
						}

						if(!in_array($ev, $reg_events_list)){
						array_push($reg_events_list, trim($ev));
						}
					}
		     	}

					$total_agegroups = array_unique($total_agegroups);
					$data['regusers_agegrps'] = $total_agegroups;
					$data['regusers_sportlevls'] = array_unique($total_sprt_lvls);
					$data['sport_levels'] = $this->model_league->get_sport_levels($tournament_details ->SportsType);
					$data['tournament_details'] = $tournament_details;
					$multi_events = json_decode($tournament_details->Multi_Events, true);
					$revised_events = $this->regenerate_events($multi_events);
 

					$data['multiEvents_keys'] = $multi_events;
					$data['revised_events']   = $revised_events;
					$data['reg_events_list']  = $reg_events_list;

					$data['reg_agegroups']	 = $reg_age_groups;
					$data['reg_gender']		 = $reg_gender;
					$data['reg_format']		 = $reg_format;
					$data['reg_levels']		 = $reg_levels;
					/* ***************************** CouponCode code ************************************* */
					$data['coupon_codes'] = $this->model_league->get_coupon_codes($tournament_details->tournament_ID);
					/* ***************************** CouponCode code ************************************* */

				if($tournament_details->Is_League == 1){
					$data['game_days'] = $this->model_league->get_league_occr($tournament_details->tournament_ID);

				}
//if($this->logged_user == 240){
//echo "<pre>"; print_r($data); exit;
//}
				if($org_id)
					$this->load->view('academy_views/includes/academy_league_header', $data);
				else
					$this->load->view('includes/header', $data);

				if($tournament_details->Is_League == 1)
					$this->load->view('view_edit_league', $data);
				else
					$this->load->view('view_edit_tournament', $data);

					$this->load->view('includes/view_right_column', $data);

				if($org_id)
					$this->load->view('academy_views/includes/academy_league_footer');
				else
					$this->load->view('includes/footer');
			 }
			 else{
				  echo "<h4>Unauthorized Access</h4>";  
			 }
 		}

/* Function To Change Partners.*/
		public function load_events(){
			$tid		  =	$this->input->post('tid');
			$tr_det		  = $this->get_logged_user_role($tid);
			$tour_details = $this->model_league->getonerow($tid);
			
		 	$data['tour_details'] = $tour_details;
			$multi_events		  = json_decode($tour_details->Multi_Events, true);

  		//	$revised_events = $this->regenerate_events($multi_events);
 
			$doubles_events = array();
				foreach($multi_events as $key){
				$events_array = explode('-', $key);
					if($events_array[1] == "Doubles" || $events_array[2] == "Doubles"){
						$doubles_events[] = $key;
					}
				 }

			$mixed_events = array();
			foreach($multi_events as $key){
			$events_array = explode('-', $key);
				if($events_array[1] == "Mixed" || $events_array[2] == "Mixed"){
					$mixed_events[] = $key;
				}
			 }

			$revised_doubles_events			= $this->regenerate_events($doubles_events);
			$data['revised_doubles_events'] = $revised_doubles_events;
			$revised_mixed_events			= $this->regenerate_events($mixed_events);
			$data['revised_mixed_events']   = $revised_mixed_events;
			if(!empty($revised_doubles_events)){
				$event = key($revised_doubles_events);
			}
			else if(!empty($revised_mixed_events)){
				$event = key($revised_mixed_events);
			}
			//echo $event;exit;

			$data['tourn_partner_names'] = $this->model_league->get_reg_tourn_partner_names($tourn_id, $event);
			$data['event']				 = $event;

			  $this->load->view('tournament/view_change_partners', $data);
		}

		public function get_TeamsByCountry(){
			$country = $this->input->post('country');
			$sport   = $this->input->post('sport');

			$data['teams_result'] = $this->model_league->get_TeamsByCountry($country,$sport);
			$this->load->view('teams/view_teams_search', $data);
		}

		public function get_TeamsByCountry1(){
			$country = $this->input->post('country');
			$sport   = $this->input->post('sport');

			$data['teams_result'] = $this->model_league->get_TeamsByCountry($country,$sport);
			$this->load->view('sports/view_teams_rankings_ajax', $data);
		}

		public function get_teams_filter_level(){
			$level	  = $this->input->post('level_id');
			$tourn_id = $this->input->post('tour_id');
			
			$get_reg_teams = $this->model_league->get_teams_filter_level($level, $tourn_id);

            $level_teams = '';

			$output = "<table id='reg_users_table' class='table tab-score'>
						<thead>
						<tr class='top-scrore-table' style='background-color:#f68b1c'>
						<th class='score-position'>Select <input type='checkbox' name='userSelectAll' id='userSelectAll' value='1' /></th>
						<th class='score-position'>Team</th>
						<th class='score-position'>Seed</th>
						</tr>
						</thead>";
			$output .= "<tbody>";

            foreach ($get_reg_teams as $key => $value) {
  
            	 	$team		= $this->get_team($value->Team_id);
                    $team_name	= $team['Team_name'];
          	        $team_id	= $team['Team_ID'];

            	 	//$level_teams .= '<option id='.$team_id.' value='.$team_id.'>'.$team_name.'</option>';
            	 	$output .= "<tr>
					<td><input type='checkbox' class='user_select' name='users[]' id='seeded_".$team_id."' value='".$team_id."' checked /></td>
					<td>$team_name</td>
					<td>
					<img src='".base_url().'icons/up.png'."' class='up' style='cursor:pointer;width:20px;height:20px;' />
					&nbsp;&nbsp;
					<img src='".base_url().'icons/down.png'."' class='down' style='cursor:pointer;width:20px;height:20px;' />
					</td>
					</tr>";

            }

            echo $output;
			exit();

		}

		public function get_team_tourn_matches($team, $tourn, $bid=''){
			return $this->model_league->get_team_tourn_matches($team, $tourn, $bid);
		}

		public function get_team_tourn_lines($match_id){
			return $this->model_league->get_team_tourn_lines($match_id);
		}

		public function cmp($a, $b){
			if ($a["won"] == $b["won"]) {
			return 0;
			}
		return ($a["won"] < $b["won"]) ? -1 : 1;
		}

		public function scorecard4(){
			$bk_ids = $this->input->post('bracket_ids');

			foreach($bk_ids as $bid){
			$result[] = $this->model_league->get_bracket_detailsScoreCard4($bid);
			}

			$data['res_result'] = $result;
			$this->load->view('scorecard4', $data);
		}

		public function update_team_player_payment(){

			if($this->input->post('update_payment')){
				$tourn_id	= $this->input->post('tourn_id');
				$upd		= $this->model_league->add_tourn_team_player_payment();
				redirect("league/$tourn_id/8");
			}
			else{
				echo "Invalid Request!";
			}
		}

		public function update_teams_levels(){
			$data['level'] = $this->input->post('reg_levels');
			$data['team'] = $this->input->post('team_id');
			$data['tour_id'] = $this->input->post('tourn_id');

			$res = $this->model_league->update_teams_levels($data);
			echo $res;
		}

		public function getUserInfo($user, $sport=''){
			$user_info = $this->model_league->getUserInfo($user, $sport);
			return $user_info;
		}

		public function is_user_have_usatt_table_entry($user){
			$user_info = $this->model_league->is_user_have_usatt_table_entry($user);
			return $user_info;
		}

		public function swap_group_players(){
			//echo "<pre>";
			$user			= $this->input->post('user');
			$tformat		= $this->input->post('tformat');
			$sport			= $this->input->post('sport');
			$target_group	= $this->input->post('target_group');
			$tourn_id			= $this->input->post('tourn_id');
			$groups			= unserialize($this->input->post('groups'));

				if($tformat == 'Teams'){
					$this->is_team_league = 1;
				}
			
			$num_grps		= 0;
			$err_count		= array();
			foreach($groups as $i => $group){
			$key = '';
			$key = array_search($user, $group);

				if(is_numeric($key)){
					//echo 'k'.$key;
					unset($groups[$i][$key]);
					$groups[$i] = array_values($groups[$i]);
				}
				$num_grps++;
			}

			$groups[$target_group][] = $user;
			foreach($groups as $i => $group){
				if(count($groups[$i]) < 3){
					if(count($groups[$i]) == 0)
						unset($groups[$i]);
					else
						$err_count[] = $i;
				}
			}

// when player swap b/w group, need to place him based on the rating.
$temp_groups = '';

foreach($groups as $i => $group){

$temp_plyrs = '';
foreach($group as $user){
		$players = explode('-', $user);
		$userInfo = $this->getUserInfo($players[0], $sport);
		if($draw_format == 'doubles'){
			$user_a2m = ($sport != 7) ? $userInfo['A2MScore_Doubles'] : number_format($userInfo['A2MScore_Doubles'], 3);
		}
		else if($draw_format == 'mixed'){
			$user_a2m = ($sport != 7) ? $userInfo['A2MScore_Mixed'] : number_format($userInfo['A2MScore_Doubles'], 3);
		}
		else{
			$user_a2m = ($sport != 7) ? $userInfo['A2MScore'] : number_format($userInfo['A2MScore_Doubles'], 3);
		}
		$temp_plyrs[$user] = $user_a2m;
}

//krsort($temp_plyrs);
//$group = array_values($temp_plyrs);
arsort($temp_plyrs);	
$group = array_keys($temp_plyrs);
$temp_groups[$i] = $group;
}
$groups = $temp_groups;
// when player swap b/w group, need to place him based on the rating.


		//echo "<pre>";
		//print_r($groups);
			$data['groups']	   = $groups;
			$data['num_grps']  = $num_grps;
			$data['tourn_id']  = $tourn_id;
			$data['tformat']   = $tformat;
			$data['sport']	   = $sport;
			$data['err_count'] = $err_count;
			$data['rr_multi_rounds'] = $this->input->post('rr_multi_rounds');
			$data['draw_format']		= $this->input->post('draw_format');
			$data['br_game_day']	= $this->input->post('br_game_day');
			$data['is_publish_draw'] = $this->input->post('is_publish_draw');
			$data['brc_type']			= $this->input->post('brc_type');
			$data['courts_new']		= $this->input->post('courts_new');
			$data['match_timings']	= $this->input->post('match_timings');

			echo $this->load->view('view_bracket_groups', $data);
		}


			public function remove_group_players(){
			//echo "<pre>";
			$user			= $this->input->post('user');
			$tformat		= $this->input->post('tformat');
			$brc_type		= $this->input->post('brc_type');
			$sport			= $this->input->post('sport');
			$target_group	= $this->input->post('group_id');
			$tourn_id		= $this->input->post('tourn_id');
			$groups		= unserialize($this->input->post('groups'));
			//$groups		= $this->input->post('new_grp');

			if($tformat == 'Teams'){
				$this->is_team_league = 1;
			}
			
			$num_grps		= 0;
			$err_count		= array();
			foreach($groups as $i => $group){
			$key = '';
			$key = array_search($user, $group);

				if(is_numeric($key)){
					//echo 'k'.$key;
					unset($groups[$i][$key]);
					$groups[$i] = array_values($groups[$i]);
				}
				$num_grps++;
			}

			//$groups[$target_group][] = $user;
			foreach($groups as $i => $group){
				if(count($groups[$i]) < 3){
					if(count($groups[$i]) == 0)
						unset($groups[$i]);
					else
						$err_count[] = $i;
				}
			}
		//	echo "<pre>";		print_r($groups);

			$data['groups']		= $groups;
			$data['num_grps']  = $num_grps;
			$data['tourn_id']  = $tourn_id;
			$data['tformat']   = $tformat;
			$data['brc_type']   = $brc_type;
			$data['sport']			= $sport;
			$data['err_count'] = $err_count;
			$data['rr_multi_rounds'] = $this->input->post('rr_multi_rounds');
			$data['draw_format']		= $this->input->post('draw_format');
			$data['br_game_day']	= $this->input->post('br_game_day');
			$data['is_publish_draw'] = $this->input->post('is_publish_draw');
			$data['brc_type']			= $this->input->post('brc_type');
			$data['courts_new']		= $this->input->post('courts_new');
			$data['match_timings']	= $this->input->post('match_timings');

			echo $this->load->view('view_bracket_groups', $data);
		}


/* **************** */

		public function bracket_generator() {

			$data['results'] = $this->model_news->get_news();

			if($this->input->post('generate')) {

				$tour_name		  = $this->input->post('tour_name');
				$draw_type		  = $this->input->post('tour_type');
				$list_type		  = $this->input->post('bracket_size');

				if($list_type == 'participants'){
					$participants	  = $this->input->post('tournament_participants');
					$players		  = explode("\n", str_replace("\r", "", $participants));
				}
				else {
					$num_participants = $this->input->post('no_of_participants');
					$players		  = array();
					
					for($i = 0; $i < $num_participants; $i++) {
						$players[$i] = ($i+1).")"; 
					}
				}
				
				$players = array_filter($players);

				if($draw_type == 'Single Elimination') {
					$data['tour_name']	  = $tour_name;
					$data['type_format']  = $draw_type;
					//$data['tourn_id']	  = $tourn_id;
					$data['teams']		  = $players;
					$data['num_of_teams'] = count($players);
				}
				else if($draw_type == 'Round Robin') {
					$data['tour_name']	  = $tour_name;
					$data['type_format']  = $draw_type;
					$rounds_per_team	  = $this->input->post('rr_rounds');
					$data['teams']		  = $players;
					$data['num_of_teams'] = count($players);
					
					for($j=1; $j<=$rounds_per_team; $j++) {
						$robin = new RRobin();

						$competitors		= $players;
							if($j%2 == 1) {
								$competitors = array_reverse($competitors);
							}
						$robin_rounds[$j] = $robin->create($competitors);
						$robins[$j]		  = $robin->tour;
						$total_games	  = $robin->tot_games;
					}

					$data['robin_rounds']	= $robin_rounds;
					$data['robins']			= $robins;
					$data['total_games']	= $total_games;

					$data['rr_multi_rounds'] = $rounds_per_team;
				}
				else if($draw_type == 'Consolation') {
					$data['tour_name']	  = $tour_name;
					$data['type_format']  = $draw_type;
					//$data['tourn_id']	  = $tourn_id;
					$data['teams']		  = $players;
					$data['num_of_teams'] = count($players);
				}
			
			}
		
			$this->load->view('includes/header');
			$this->load->view('view_gen_bracket_generator', $data);
			$this->load->view('includes/view_right_column', $data);
			$this->load->view('includes/footer', $data);
		}

		public function print_gen_se_draws(){
			
			$post_data = unserialize($this->input->post('temp'));

			$data['tour_name']	  = $post_data['tour_name'];
			$data['type_format']  = $post_data['type_format'];
			$data['teams']		  = $post_data['teams'];
			$data['num_of_teams'] = count($post_data['teams']);
			
			$this->load->view('view_gen_se_print_draws', $data);
		}

		public function print_gen_se64_draws(){
			
			$post_data = unserialize($this->input->post('temp'));

			$data['tour_name']	  = $post_data['tour_name'];
			$data['type_format']  = $post_data['type_format'];
			$data['teams']		  = $post_data['teams'];
			$data['num_of_teams'] = count($post_data['teams']);
			
			$this->load->view('view_gen_se64_print_draws', $data);
		}

		public function print_gen_cd_draws(){
			
			$post_data = unserialize($this->input->post('temp'));

			$data['tour_name']	  = $post_data['tour_name'];
			$data['type_format']  = $post_data['type_format'];
			$data['teams']		  = $post_data['teams'];
			$data['num_of_teams'] = count($post_data['teams']);
			
			$this->load->view('view_gen_cd_print_draws', $data);
		}

		public function print_gen_rr_draws(){
			
			$post_data = unserialize($this->input->post('temp'));

			$data['tour_name']	  = $post_data['tour_name'];
			$data['type_format']  = $post_data['type_format'];
			$data['teams']		  = $post_data['teams'];
			$data['num_of_teams'] = $post_data['num_of_teams'];
		
			$data['robin_rounds'] = $post_data['robin_rounds'];
			$data['robins']		  = $post_data['robins'];
			$data['total_games']  = $post_data['total_games'];

			$data['rr_multi_rounds'] = $post_data['rr_multi_rounds'];	
		
			$this->load->view('view_gen_rr_print_draws', $data);
		}

		public function print_gen_rr_draws_grid(){
			
			$post_data = unserialize($this->input->post('temp'));

			$data['tour_name']	  = $post_data['tour_name'];
			$data['type_format']  = $post_data['type_format'];
			$data['teams']		  = $post_data['teams'];
			$data['num_of_teams'] = $post_data['num_of_teams'];
		
			$data['robin_rounds'] = $post_data['robin_rounds'];
			$data['robins']		  = $post_data['robins'];
			$data['total_games']  = $post_data['total_games'];

			$data['rr_multi_rounds'] = $post_data['rr_multi_rounds'];	
		
			$this->load->view('view_gen_rr_print_draws_grid', $data);
		}

		function getBracket($participants)
		{
			$participantsCount	= count($participants);  
			$rounds				= ceil(log($participantsCount)/log(2));
			$bracketSize		= pow(2, $rounds);
			$requiredByes		= $bracketSize - $participantsCount;

			/*echo sprintf('Number of participants: %d<br/>%s', $participantsCount, PHP_EOL);
			echo sprintf('Number of rounds: %d<br/>%s', $rounds, PHP_EOL);
			echo sprintf('Bracket size: %d<br/>%s', $bracketSize, PHP_EOL);
			echo sprintf('Required number of byes: %d<br/>%s', $requiredByes, PHP_EOL);    */

			if($participantsCount < 2) {
				return array();
			}

			$matches = array(array(1,2));
			/*echo "<pre>";
			print_r($matches);*/

			for($round=1; $round < $rounds; $round++)
			{
				$roundMatches = array();
				$sum = pow(2, $round + 1) + 1;
				foreach($matches as $match)
				{
					$home = league::changeIntoBye($match[0], $participantsCount);
					$away = league::changeIntoBye($sum - $match[0], $participantsCount);
					$roundMatches[] = array($home, $away);
					$home = league::changeIntoBye($sum - $match[1], $participantsCount);
					$away = league::changeIntoBye($match[1], $participantsCount);
					$roundMatches[] = array($home, $away);
				}
				$matches = $roundMatches;
			}
			/*echo "<pre>";
			print_r($matches);*/
			foreach($matches as $m => $mt){

				$fil_mats[$m][] = ($mt[0] != "") ? $participants[($mt[0]-1)] : '---';
				$fil_mats[$m][] = ($mt[1] != "") ? $participants[($mt[1]-1)] : '---';
			}
			return $fil_mats;

		}

		public function changeIntoBye($seed, $participantsCount)
		{
			//return $seed <= $participantsCount ?  $seed : sprintf('%d (= bye)', $seed);  
			return $seed <= $participantsCount ?  $seed : null;
		   return $seed;
		}


		public function ladder(){
			$data['intrests'] = $this->model_league->get_intrests();
			$data['results']  = $this->model_news->get_news();

			$sport_id			  = $this->input->post('sport_type');
			$data['sport_levels'] = $this->model_league->get_sport_levels($sport_id);
			
			$this->load->view('includes/header');
			$this->load->view('view_create_ch_ladder',$data);
			$this->load->view('includes/view_right_column',$data);
			$this->load->view('includes/footer');
		}

		public function get_cl_user_position($bracket_id, $user){
			$position = $this->model_league->get_cl_user_position($bracket_id, $user);
			return $position;
		}

		public function add_new_cl_player(){

			$data['Tourn_ID']	= $this->input->post('tourn_id');
			$data['Bracket_ID']	= $this->input->post('bracket_id');
			$data['Player']		= $this->input->post('new_player');
			$data['Player_Partner'] = NULL;
			$data['Position']		= $this->input->post('new_player_level');
			$data['Prev_Position']	= 0;

			if($this->input->post('new_player_2')){
			$data['Player_Partner']	= $this->input->post('new_player_2');
			}
			$add_new = $this->model_league->add_new_cl_player($data);

			if($add_new){ 
				echo true; 
				
			}
			else { echo false; }
		}

		public function challenge_a_player(){
			$tourn_id	= $this->input->post('tourn_id');
			$bracket_id = $this->input->post('bracket_id');
			$user		= $this->logged_user;
			$ch_player	= $this->input->post('ch_player');

			$add_new = $this->model_league->add_new_challenge($tourn_id, $bracket_id, $user, $ch_player);
			
			/* ******** */
			/*$player_det   = $this->model_league->get_user_name($ch_player);
			$user_det     = $this->model_league->get_user_name($user);
			$tour_details = $this->model_league->getonerow($tourn_id);

					$to_email = "npradkumar@gmail.com";
					$subject  = "New Challenge - {$tour_details['tournament_title']}";
					$data	  = array(
									'tourn_id'	 => $tourn_id,
									'player'	 => $player_det['Firstname']." ".$player_det['Lastname'],
									'challenger' => $user_det['Firstname']." ".$user_det['Lastname'],
									'tourn_name' => $tour_details['tournament_title'],
									'page'		 => 'Challenge Notif - Player'
								);

					$this->email_to_player($to_email, $subject, $data);*/
			/* ******** */

			/* Push Notifications */
			/*$get_user_token = $this->model_general->get_userToken($ch_player);

				if($get_user_token){
					$msg_payload = array (
									'title' => 'New Challenge - '.$tour_details['tournament_title'],
									'body'  => 'You were challenged by '.$user_det['Firstname']  ." ".$user_det['Lastname'].' in league '.$tour_details['tournament_title']
									);

					foreach($get_user_token as $i => $ut){
						$regId		  = $ut->token;
						$mobile_notif = $this->android($msg_payload, $regId);
						$r = json_decode($mobile_notif);
					}
				}*/
			/* Push Notifications */

			if($add_new){ 
				echo true; 
			}
			else{ echo false; }
		}

		public function update_ladder_levels(){
			$levels		= $this->input->post('ch_player_level');
			$upd_levels = $this->model_league->upd_positions($levels);

			echo $upd_levels;
		}

		public function cancel_a_challenge(){
			$cancel_ch  = $this->model_league->cancel_ch($cl_id);

			echo $cancel_ch;
		}

		public function swap_positions($data){
			/*
			$bracket_id	= $data['bracket_id'];
			$match_num	= $data['match_num'];
			$player		= $data['player'];
			$p_pos		= $data['p_pos'];
			$ch_pos		= $data['ch_pos'];
			*/

			$opp	   = $data['player'];
			$challeger = $data['challeger'];
			$winner	   = $data['winner'];

			if($data['ch_pos'] == $data['p_pos'] and $data['ch_pos'] > 1){
				if($challeger == $winner){
					$data['p_pos']  = --$data['p_pos'];
				}
				else{
					$data['ch_pos'] = --$data['ch_pos'];
				}

				$this->model_league->swap_player_positions($data);
			}
			else if($challeger == $winner and $data['ch_pos'] > $data['p_pos']){
				$this->model_league->swap_player_positions($data);
			}
			else if($opp == $winner and $data['ch_pos'] < $data['p_pos']){
				$this->model_league->swap_player_positions($data);
			}
				$this->model_league->update_ladder($data);			 

			return true;
		}

		public function get_cl_standings($tourn_id){
			$reg_players = $this->model_league->get_reg_players($tourn_id);
			$report		 = array();
			$data['club_url'] = $this->input->post('club_url');
			$format = $this->input->post('df');

			foreach($reg_players as $reg_pl){
				$player				 = $reg_pl->Users_ID;
				$get_player_matches  = $this->model_league->get_player_matches($tourn_id, $player, $format);
				
				if(count($get_player_matches) > 0){
					$player_det = $this->model_league->get_user_name($player);

				
					$get_init_rating = $this->model_league->get_lg_std_init_ratings($player, $tourn_id, $format);
			
					if($get_init_rating['Init_Rating'] != NULL and $get_init_rating['Init_Rating'] != 'NULL' and $get_init_rating['Init_Rating'] != ''){
						//echo "testing ".$get_init_rating['Init_Rating']; exit;
						$init_a2m   = $get_init_rating['Init_Rating'];
						$final_a2m = $this->model_league->get_lg_std_final_ratings($player, $tourn_id, $format);
						$change = $final_a2m - $init_a2m;
					}
					else{
										//	echo "testing {$player}"; exit;
						$player_a2m = $this->model_league->get_a2m($player, $tourn_id);

						$init_a2m   = $reg_pl->Current_A2M;
						$final_a2m = NULL;

						if($player_a2m){
							$final_a2m = max($player_a2m['A2MScore'], $player_a2m['A2MScore_Doubles'], $player_a2m['A2MScore_Mixed']);
						}

						if($init_a2m == NULL or $init_a2m == ""){
							$init_a2m  =  $final_a2m;				
						}
						
						$change = $final_a2m - $init_a2m;
					}


				$report[$player]['fname']			= $player_det['Firstname'];
				$report[$player]['lname']			= $player_det['Lastname'];

				$report[$player]['init_a2m']		= $init_a2m;
				$report[$player]['final_a2m']	= $final_a2m;
				$report[$player]['change']		= $change;

				$report[$player]['played']		= 0;
				$report[$player]['won']			= 0;
				$report[$player]['lost']			= 0;
				$report[$player]['points_for']	= 0;
				$report[$player]['points_against']  = 0;

				foreach($get_player_matches as $match){

					$report[$player]['played'] += 1;

					if($match['Winner'] == $match['Player1']){
						$report[$player]['won'] += ($player == $match['Player1'] or $player == $match['Player1_Partner']) ? 1 : 0;
						$report[$player]['lost'] += ($player != $match['Player1'] and $player != $match['Player1_Partner']) ? 1 : 0;
					}
					else if($match['Winner'] == $match['Player2']){
						$report[$player]['won'] += ($player == $match['Player2'] or  $player == $match['Player2_Partner']) ? 1 : 0;
						$report[$player]['lost'] += ($player != $match['Player2'] and $player != $match['Player2_Partner']) ? 1 : 0;
					}
					
					$for_score	   = ($player == $match['Player1'] or $player == $match['Player1_Partner']) ?
									 $match['Player1_Score'] : $match['Player2_Score'];

					$against_score = ($player == $match['Player1'] or $player == $match['Player1_Partner']) ?
									 $match['Player2_Score'] : $match['Player1_Score'];
					
					if($for_score){
						$for = json_decode($for_score, true);
						$tot = 0;
						foreach($for as $sc)
							$tot += $sc;
						$report[$player]['points_for'] += $tot;
					}

					if($against_score){
						$against = json_decode($against_score, true);
						$tot = 0;
						foreach($against as $sc)
							$tot += $sc;
						$report[$player]['points_against'] += $tot;
					}
				}
				}
			}

			$data['standings']	= $report;
			//echo "<pre>"; print_r($data); exit;
			$data['tour_det']		= $this->model_league->getonerow($tourn_id);
			echo $this->load->view('tournament/view_cl_standings', $data);
		}

		public function get_cl_team_standings($tourn_id){
			//$reg_players = $this->model_league->get_reg_players($tourn_id);
			$reg_players = $this->get_tourn_team_players($tourn_id);
			$report		 = array();
		//echo "<pre>"; print_r($reg_players); 
		foreach($reg_players as $team => $team_players){
			foreach($team_players['Users'] as $reg_pl){

			//foreach($reg_players as $reg_pl){
				$player				 = $reg_pl;
				$get_player_matches  = $this->model_league->get_player_team_matches($tourn_id, $player);
				
				if(count($get_player_matches) > 0){
					$player_det = $this->model_league->get_user_name($player);

				$report[$player]['fname']			= $player_det['Firstname'];
				$report[$player]['lname']			= $player_det['Lastname'];
				$report[$player]['played']			= 0;
				$report[$player]['won']				= 0;
				$report[$player]['lost']			= 0;
				$report[$player]['points_for']		= 0;
				$report[$player]['points_against']  = 0;

				foreach($get_player_matches as $match){

					$report[$player]['played'] += 1;

					if($match['Winner'] == $match['Player1']){
						$report[$player]['won']  += ($player == $match['Player1'] or  $player == $match['Player1_Partner']) ? 1 : 0;
						$report[$player]['lost'] += ($player != $match['Player1'] and $player != $match['Player1_Partner']) ? 1 : 0;
					}
					else if($match['Winner'] == $match['Player2']){
						$report[$player]['won']  += ($player == $match['Player2'] or  $player == $match['Player2_Partner']) ? 1 : 0;
						$report[$player]['lost'] += ($player != $match['Player2'] and $player != $match['Player2_Partner']) ? 1 : 0;
					}
					
					$for_score	   = ($player == $match['Player1'] or $player == $match['Player1_Partner']) ?
									 $match['Player1_Score'] : $match['Player2_Score'];

					$against_score = ($player == $match['Player1'] or $player == $match['Player1_Partner']) ?
									 $match['Player2_Score'] : $match['Player1_Score'];
					
					if($for_score){
						$for = json_decode($for_score, true);
						$tot = 0;
						foreach($for as $sc)
							$tot += $sc;
						$report[$player]['points_for'] += $tot;
					}

					if($against_score){
						$against = json_decode($against_score, true);
						$tot = 0;
						foreach($against as $sc)
							$tot += $sc;
						$report[$player]['points_against'] += $tot;
					}
				}
				}
			  }
			}

			$data['standings'] = $report;
			$this->is_team_league = 1;
			echo $this->load->view('tournament/view_cl_standings', $data);
		}

		public function player_name($player, $partner = '', $uri=''){
			if($uri == '')
				$uri = $this->config->item('club_pr_url').'/';

			$get_player	   = $this->model_league->get_user_name($player);
			$player_name  = "";
			$player_name .= "<a href='".$uri."player/".$player."' target='_blank'>";
			$player_name .= ucfirst($get_player['Firstname'])." ".ucfirst($get_player['Lastname']);
			$player_name .= "</a>";

			if($partner){
				$get_partner	   = $this->model_league->get_user_name($partner);
				$player_name .= "<a href='".$uri."player/".$partner."' target='_blank'>";
				$player_name .= "; ".ucfirst($get_partner['Firstname'])." ".ucfirst($get_partner['Lastname']);
				$player_name .= "</a>";
			}

			return $player_name;
		}

		public function get_cl_player_matches(){
			$player   = $this->input->post('player');
			$tourn_id = $this->input->post('tourn_id');
			$club_url = $this->input->post('club_url');
	
			$get_player_matches  = $this->model_league->get_player_matches($tourn_id, $player);
			//echo "</br>";
			echo "<b>Matches</b>";
			echo "<table class='tab-score'>";
			foreach($get_player_matches as $match){
				$winner = $match['Winner'];

				echo "<tr>";	
				echo "<td align='center'>";
					if($match['Player1_Partner'])
						echo $this->player_name($match['Player1'], $match['Player1_Partner'], $club_url);
					else
						echo $this->player_name($match['Player1'], $club_url);

					echo "&nbsp;&nbsp;Vs&nbsp;&nbsp;";

					if($match['Player2_Partner'])
						echo $this->player_name($match['Player2'], $match['Player2_Partner'], $club_url);
					else
						echo $this->player_name($match['Player2'], $club_url);
				echo "</td>";

				echo "<td>&nbsp;";
					if($match['Player1'] == $match['Winner']){

						if($match['Player1_Partner'])
							echo $this->player_name($match['Player1'], $match['Player1_Partner'], $club_url);
						else
							echo $this->player_name($match['Player1'], $club_url);
					}
					else{
						if($match['Player2_Partner'])
							echo $this->player_name($match['Player2'], $match['Player2_Partner'], $club_url);
						else
							echo $this->player_name($match['Player2'], $club_url);
					}

					if($match['Winner']){
						echo "&nbsp;"."<img src='".base_url()."images/gold_medal_small.png' style='width:20px;height:20px;'></img>";
					}
				echo "</td>";

				echo "<td>&nbsp;";
				if($match['Player1_Score'] == '[0]'){
					echo "Win by Forfiet";
				}
				else{
					$p1_score = json_decode($match['Player1_Score']);
					$p2_score = json_decode($match['Player2_Score']);

					if($match['Player1'] == $match['Winner']){
						foreach($p1_score as $i => $score){
							echo "(".$p1_score[$i]."-".$p2_score[$i].") ";
						}
					}
					else if($match['Player2'] == $match['Winner']){
						foreach($p1_score as $i => $score){
							echo "(".$p2_score[$i]."-".$p1_score[$i].") ";
						}
					}
				}
				echo "</td>";
				echo "</tr>";
			}
			echo "</table>";
		}

		public function get_cl_player_team_matches(){
			$player   = $this->input->post('player');
			$tourn_id = $this->input->post('tourn_id');
			
			$get_player_matches  = $this->model_league->get_player_team_matches($tourn_id, $player);
			//echo "</br>";
			echo "<b>Matches</b>";
			echo "<table class='tab-score'>";
			foreach($get_player_matches as $match){
				$winner = $match['Winner'];

				echo "<tr>";	
				echo "<td align='center'>";
					if($match['Player1_Partner'])
						echo $this->player_name($match['Player1'], $match['Player1_Partner']);
					else
						echo $this->player_name($match['Player1']);

					echo "&nbsp;&nbsp;Vs&nbsp;&nbsp;";

					if($match['Player2_Partner'])
						echo $this->player_name($match['Player2'], $match['Player2_Partner']);
					else
						echo $this->player_name($match['Player2']);
				echo "</td>";

				echo "<td>&nbsp;";
					if($match['Player1'] == $match['Winner']){

						if($match['Player1_Partner'])
							echo $this->player_name($match['Player1'], $match['Player1_Partner']);
						else
							echo $this->player_name($match['Player1']);
					}
					else{
						if($match['Player2_Partner'])
							echo $this->player_name($match['Player2'], $match['Player2_Partner']);
						else
							echo $this->player_name($match['Player2']);
					}

					if($match['Winner']){
						echo "&nbsp;"."<img src='".base_url()."images/gold_medal_small.png' style='width:20px;height:20px;'></img>";
					}
				echo "</td>";

				echo "<td>&nbsp;";
				if($match['Player1_Score'] == '[0]'){
					echo "Win by Forfiet";
				}
				else{
					$p1_score = json_decode($match['Player1_Score']);
					$p2_score = json_decode($match['Player2_Score']);

					if($match['Player1'] == $match['Winner']){
						foreach($p1_score as $i => $score){
							echo "(".$p1_score[$i]."-".$p2_score[$i].") ";
						}
					}
					else if($match['Player2'] == $match['Winner']){
						foreach($p1_score as $i => $score){
							echo "(".$p2_score[$i]."-".$p1_score[$i].") ";
						}
					}
				}
				echo "</td>";
				echo "</tr>";
			}
			echo "</table>";
		}

  		public function get_currencyCode(){
			$country = $this->input->post('ctry');
	 	  	$result = $this->model_league->get_currencyCode($country);
  			echo $result['code']; 
		}

		public function get_allCurrencyCodes(){
			$codes = $this->model_league->get_allCurrencyCodes();
  			return $codes;
		}

		public function get_paypalids($userid){
			$paypalids = $this->model_league->get_paypalids($userid);
			return $paypalids;
		}

		public function get_player_points($bracket_id, $player){
			return $this->model_league->get_player_points($bracket_id, $player);
		}

		public function view_more_sports(){
			$this->load->view('includes/header');
			$this->load->view('view_more_sports');
			$this->load->view('includes/view_right_column',$data);
			$this->load->view('includes/footer');
		}

		public function printScoreSheet(){
			$tid = $this->input->post('tourn_id');
			$bk_ids = $this->input->post('bracket_ids');

			$result[] = $this->model_league->get_bracket_detailsScoreSheet($bk_ids);

			$data['res_result1'] = $result;
			$this->load->view('print_scoresheet', $data);
		}

		public function update_checkIn(){
			$user_id  = $this->input->post('player');
			$tourn_id = $this->input->post('tourn_id');
			$checkin  = $this->input->post('checkin');

			$upd = $this->model_league->update_checkIn($user_id, $tourn_id, $checkin);
			
			return $upd;
		}

		public function get_checkIn_players(){
			$tourn_id = $this->input->post('tourn_id');
			$res = $this->model_league->get_checkIn_players($tourn_id);	
			return $res;

		}

		public function user_usatt_update(){

			$stat = $this->model_league->user_usatt_update();
			$tour_id = $this->input->post('txt_tid');

			$redirect = $this->input->post('txt_red');
			if(!$stat){
				$this->session->set_flashdata('err_msg', "Given ID(#".$this->input->post('usatt_member_id').") is not matching with USATT Records. Please contact Tournament Director.");
			}
//echo $this->session->flashdata('err_msg'); exit;

			if($redirect == 'league_view'){
				redirect("league/$tour_id");
			}
			if($redirect == '-1'){
				echo "Done";
			}
			else{
				redirect("league/register_match/$tour_id");
			}
		}

		public function edit_user_a2m(){

			$user	 = $this->input->post('user');
			$tid	 = $this->input->post('tourn_id');
			//$up_a2m  = $this->input->post('uval');
			$sl_val     = $this->input->post('sl_val');
			$db_val   = $this->input->post('db_val');
			$mx_val   = $this->input->post('mx_val');
			
			if($user){
				$tour_details = $this->model_league->getonerow($tid);
				if($this->logged_user == $tour_details->Usersid or $this->logged_user == $tour_details->Tournament_Director or $this->is_super_admin){
					$upd = $this->model_league->update_user_a2m($user, $tour_details->SportsType, $sl_val, $db_val, $mx_val);

					if($tour_details->SportsType != 7){
					$user_a2m = max($sl_val, $db_val, $mx_val);
					}
					else{
					$user_a2m = number_format(max($sl_val, $db_val, $mx_val), 3);
					}

					if($upd)
						echo $user_a2m;
					else
						echo "Something went wrong!";
				}
				else{
					echo "Unauthorised Access!";
				}
			}
			else{
				echo "Invalid Request!";
			}
		}


			public function getEventLocation($loc_id){
		$loc_details = $this->model_league->getEventLocation($loc_id);
		return $loc_details;
	}


			 public function bracket_test($tourn_id)
		 {
		//echo "<pre>";print_r($_POST);	exit;

		if($this->input->post('is_sch_courts')){
			$num_courts					= $this->input->post('num_courts');
			$crts					= $this->input->post('courts');
			$match_dates	= $this->input->post('match_date');
			$start_time		= $this->input->post('stime');
			$end_time			= $this->input->post('etime');
			$duration				= $this->input->post('match_duration');
			$break					= $this->input->post('match_break');
			$tot_match_duration = $duration + $break;
					foreach($crts as $i => $court){
					$start  = date('Y-m-d H:i',strtotime($match_dates[$i] . " " . $start_time[$i]));
					$end   = date('Y-m-d H:i',strtotime($match_dates[$i] . " " . $end_time[$i]));

					//$start  = strtotime('-5 hours', strtotime($match_dates[$i] . " " . $start_time[$i]));
					$start  = strtotime($match_dates[$i] . " " . $start_time[$i]);
					//$end   = strtotime('-5 hours', strtotime($match_dates[$i] . " " . $end_time[$i]));
					$end   = strtotime($match_dates[$i] . " " . $end_time[$i]);

					$currentdate	= $start;
					$time_arr		= array();

					while($currentdate <= $end)
					{
					  //echo date('m-d-Y H:i', $currentdate)."<br>";
					  //$matches_times[$m] = ($i+1)."-".$currentdate;
						//$time_arr[($i+1)][] = $currentdate;
						$time_arr[] = $currentdate;

					  $currentdate = strtotime('+'.$tot_match_duration.' minutes', $currentdate);
					  //do what you want here
					}

						$courts_new[$i] = array('name'	=> $court, 
															'timings'	=> array('sd' => $match_dates[$i],
																					  'st'  => $start_time[$i],
																					  'ed' => $end_time[$i]
																					),
															'time_breaks'	=> $time_arr,
															'duration'		=> $this->input->post('match_duration'),
															'break'			=> $this->input->post('match_break')
															);
					}
		}
//echo "<pre>";
//print_r($courts_new); 
//echo "test";	
$crt = 0;
$tm_index = 0;
for($m = 1; $m < 64; $m++){

	$match_timings[$m] = array($courts_new[$crt]['name'], $courts_new[$crt]['timings']['sd'], $courts_new[$crt]['time_breaks'][$tm_index]);

	if($crt == ($num_courts - 1))
		$crt = 0;
	else
		$crt++;

	if(($m%$num_courts) == 0){
		$tm_index++;
	}
}
//print_r($match_timings); 

//exit;

$data['courts_new']		= $courts_new;
$data['match_timings']	= $match_timings;

			if($this->input->post('generate'))
			{
				if($this->input->post('tformat') == 'Teams'){
					$this->is_team_league = 1;
				}

				$users	   = $this->input->post('users');
				$num_grps  = $this->input->post('sel_groups');
				$is_groups = $this->input->post('is_groups');
				$sport	   = $this->input->post('sport');
				$grp_top_players = $this->input->post('is_group_top_players');

				if($is_groups){
					$per_grp = round(count($this->input->post('users')) / $num_grps);
					$groups  = array();
					$i		 = 1;
					foreach($users as $u){
						$groups[$i][] = $u;
						if(!$grp_top_players){
							//echo $i." ".$u."<br>";
							if($i == $num_grps){ $i = 1; }
							else{ $i++; }
						}
						else{
							//echo $i." ".$u."<br>";
							if(count($groups[$i]) == $per_grp and $i < $num_grps){ $i++; }
						}
					}
					$data['groups']	   = $groups;
					$data['num_grps']  = $num_grps;
					$data['tourn_id']  = $tourn_id;
					$data['sport']	   = $sport;
					$data['err_count'] = array();
					$data['tformat']   = $this->input->post('tformat');
					$data['rr_multi_rounds'] = $this->input->post('num_of_times');
					$data['tour_type'] = $this->input->post('tour_type');
					$data['is_publish_draw'] = $this->input->post('is_publish_draw');
					$data['grp_top_players'] = $this->input->post('is_group_top_players');

		//print_r($data);
		//exit;

					$this->load->view('includes/header');
					$this->load->view('view_bracket_groups', $data);
					$this->load->view('includes/footer');
				}
				else{

				$sel_users_count = count($this->input->post('users'));
				$ttype = $this->input->post('ttype');

				if($sel_users_count == 2 and $ttype != 'Switch Doubles'){
				$ttype = 'Single Elimination';
				}
				
				$data['ttype']   = $ttype;
				$data['results'] = $this->model_news->get_news();

				$tourn_id	= $this->uri->segment(3);
				$user_id	= $this->logged_user;
				$match_type = $this->input->post('match_type');

				$data['sport_level'] = '';
				if($this->input->post('sport_level')){
				$sport_level = $this->input->post('sport_level');
                $data['sport_level'] = '["'.$sport_level.'"]';
				}

				foreach($match_type as $key => $event){		
					$filter_events[] = $event;
				}

                $data['filter_events']	= json_encode($filter_events);

				if($ttype == 'Single Elimination' or $ttype == 'Consolation'){
					$data['types']		  = $this->input->post('types');
					$data['type_format']  = $this->input->post('type_gen');
					$data['tourn_id']	  = $tourn_id;
					$data['teams']		  = $this->input->post('users');
					$data['num_of_teams'] = count($data['teams']);

					$this->load->view('includes/header');
					($ttype == 'Single Elimination') ? 
						$this->load->view('view_bracket_generate', $data) : $this->load->view('view_cd_bracket_generate', $data);
					$this->load->view('includes/footer');
				}
				else if($ttype == 'Play Off'){
					$data['types']		  = $this->input->post('types');
					$data['type_format']  = $this->input->post('type_gen');
					$data['tourn_id']	  = $tourn_id;
					$data['teams']		  = $this->input->post('users');
					$data['num_of_teams'] = count($data['teams']);

					$this->load->view('includes/header');
					$this->load->view('view_playoff_bracket_generate', $data);
					$this->load->view('includes/footer');
				}
				else if($ttype == 'conventional' or $ttype == 'drive_chip_putt'){
					$data['types'] = $this->input->post('types');
					$data['type_format'] = $this->input->post('type_gen');
						
					$data['tourn_id']		= $tourn_id;
					$data['players']		= $this->input->post('users');
					$data['num_of_players']	= count($data['players']);

					$this->load->view('includes/header');
					$this->load->view('view_golf_bracket_generate', $data);
					$this->load->view('includes/footer');

				}
				else if($ttype == 'Round Robin'){
					$data['types']		 = $this->input->post('types');
					$data['type_format'] = $this->input->post('type_gen');
					$data['tourn_id']	 = $tourn_id;
					$data['teams']		 = array_map('trim', $this->input->post('users'));
					$data['num_of_teams'] = count($data['teams']);

					$robin = new RRobin();

					$competitors = $this->input->post('users');
					$competitors = array_reverse($competitors);

					$data['robin_rounds'] = $robin->create($competitors);
					$data['players']	  = $this->input->post('users');
					//$data['robins']	  = $robin->tour;

// New code for order of matches
$temp	  = "";
$temp2	  = "";
$pop_temp = "";
$temp	  = $robin->tour;

$total_matches = count($temp);
if($total_matches > 3) {
	$group_matches = ($total_matches % 2 == 0) ? ($total_matches / 2) : ($total_matches / 3);

	if($group_matches > 10)	{
	$group_matches = ($total_matches % 4 == 0) ? ($total_matches / 4) : ($total_matches / 5);
	}

	$per_group_matches = $total_matches / $group_matches;
}
else {
	$per_group_matches = 1;
	$group_matches	   = 3;
}

$pop_temp  = array_splice($temp, 0, $per_group_matches);
$temp2	   = array_merge($temp, $pop_temp);
$robins	   = $temp2;
// New code for order of matches ends here

					$data['robins']		 = $robins;
					$data['total_games'] = $robin->tot_games;

					$this->load->view('includes/header');
					$this->load->view('view_rr_bracket_generate',$data);
					$this->load->view('includes/footer');
				}
				else if($ttype == 'Challenge Ladder'){
					$data['tformat']	 = $this->input->post('tformat');
					$data['tour_type']	 = "Ladder";
					$data['types']		 = $this->input->post('types');
					$data['type_format'] = $this->input->post('type_gen');
					$data['tourn_id']	 = $tourn_id;			
					$data['players']	 = array_map('trim', $this->input->post('users'));

					$get_tour = $this->model_league->getonerow($tourn_id);

					$data['ch_positions'] = $get_tour->Challenge_Positions;			
					$data['sdate']		  = $get_tour->StartDate;			
					$data['edate']		  = $get_tour->EndDate;			


					$this->load->view('includes/header');
					$this->load->view('view_cl_bracket_generate', $data);
					$this->load->view('includes/footer');
				}
				else if($ttype == 'Switch Doubles'){		// ----------------------- SWITCH DOUBLES

					$data['tformat']	 = $this->input->post('tformat');
					$data['tour_type']	 = "SwitchDoubles";
					$data['types']		 = $this->input->post('types');
					$data['type_format'] = $this->input->post('type_gen');
					$data['tourn_id']	 = $tourn_id;			
					$data['players']	 = array_map('trim', $this->input->post('users'));

//					$data['players'] = array(1,2,3,4,5,6,7,8);
//					$data['players'] = array(A,B,C,D,E,F,G,H);
					$players_count = 0;
					$temp = array();

					foreach($data['players'] as $pp){
						$pl = explode('-', $pp);

						if($pl[0]){
							$players_count++;
							$temp[] = $pl[0];
						}
						if($pl[1]){
							$players_count++;
							$temp[] = $pl[1];
						}
						

					}

					$data['players'] = $temp;
					
					/*echo "<pre>";
					print_r($temp);
					print_r($data['players']);
					echo $players_count;*/
					//$players_count = count($data['players']);
					//$temp	= $data['players'];


					if(($players_count % 4) == 0){
						$limit = $players_count - 1;
						$quot  = $players_count / 4;
					}
					else{
						$limit = $players_count;
						$rem   = $players_count % 4;
					}

					$i = 1;

					if($players_count == 5){
						while($i <= $limit){
							$bridge[$i] = $temp;
							$temp1		= $temp;
							foreach($temp1 as $pos => $player){
								if(++$pos == count($temp1))
									$pos = 0;

								$temp[$pos] = $player;
							}
						$i++;
						}
					}
					else if($players_count == 8 or $players_count == 4){
						while($i <= $limit){
							$bridge[$i] = $temp;
							$temp1		= $temp;
							foreach($temp1 as $pos => $player){
								if(++$pos == count($temp1))
									$pos = 1;

								$temp[$pos] = $player;
							}
						$i++;
						}
					}
				
/*echo "<pre>";
//print_r($temp);
echo "-----------<br>";
print_r($bridge);*/

					$sd_matches = array();
					foreach($bridge as $m => $matches){
						//echo "Round ".$m."<br>";
						if($quot == 1){
							//echo $bridge[$m][2].'; '.$bridge[$m][3].'  vs  '.$bridge[$m][0].'; '.$bridge[$m][1]."<br>";
							$sd_matches[$m][1][1] = array($bridge[$m][2], $bridge[$m][3]);
							$sd_matches[$m][1][2] = array($bridge[$m][0], $bridge[$m][1]);
						}
						else if($quot == 2){		// 2 and 3 vs. 4 and 6     5 and 1 vs. 7 and 0
							//echo $bridge[$m][2].'; '.$bridge[$m][3].'  vs  '.$bridge[$m][4].'; '.$bridge[$m][6]."<br>";
							$sd_matches[$m][1][1] = array($bridge[$m][2], $bridge[$m][3]);
							$sd_matches[$m][1][2] = array($bridge[$m][4], $bridge[$m][6]);

							//echo $bridge[$m][5].'; '.$bridge[$m][1].'  vs  '.$bridge[$m][7].'; '.$bridge[$m][0]."<br>";
							$sd_matches[$m][2][1] = array($bridge[$m][5], $bridge[$m][1]);
							$sd_matches[$m][2][2] = array($bridge[$m][7], $bridge[$m][0]);
						}
						else if($quot == 3){		//2 and 3  vs.  1 and 6   8 and 10 vs.  4 and 7   5 and 9  vs. 11 and 0
							//echo $bridge[$m][2].'; '.$bridge[$m][3] .'  vs  '.$bridge[$m][1] .'; '.$bridge[$m][6]."<br>";
							$sd_matches[$m][3][1] = array($bridge[$m][2], $bridge[$m][3]);
							$sd_matches[$m][3][2] = array($bridge[$m][1], $bridge[$m][6]);

							//echo $bridge[$m][8].'; '.$bridge[$m][10].'  vs  '.$bridge[$m][4] .'; '.$bridge[$m][7]."<br>";
							$sd_matches[$m][3][1] = array($bridge[$m][8], $bridge[$m][10]);
							$sd_matches[$m][3][2] = array($bridge[$m][4], $bridge[$m][7]);

							//echo $bridge[$m][5].'; '.$bridge[$m][9] .'  vs  '.$bridge[$m][11].'; '.$bridge[$m][0]."<br>";
							$sd_matches[$m][3][1] = array($bridge[$m][5], $bridge[$m][9]);
							$sd_matches[$m][3][2] = array($bridge[$m][11], $bridge[$m][0]);

						}
						else if(in_array($rem, array(1,2,3))){
							//echo $bridge[$m][2].'; '.$bridge[$m][3].'  vs  '.$bridge[$m][4].'; '.$bridge[$m][1]."<br>";
							$sd_matches[$m][1][1] = array($bridge[$m][2], $bridge[$m][3]);
							$sd_matches[$m][1][2] = array($bridge[$m][4], $bridge[$m][1]);
						}
						//echo "<br>";
					}

					$data['sd_matches'] = $sd_matches;

/*echo "<pre>";
print_r($sd_matches);
exit;*/
					$this->load->view('includes/header');
					$this->load->view('view_sd_bracket_generate', $data);
					$this->load->view('includes/footer');
				}
			  }
			}
			else if($this->input->post('groups_cont')){

				$groups			 = unserialize($this->input->post('groups'));
				$data['types']	 = $this->input->post('types');
				$data['tformat'] = $this->input->post('tformat');
				$data['is_publish_draw'] = $this->input->post('is_publish_draw');
				$data['rr_multi_rounds'] = $this->input->post('num_grps');
				$rounds_per_team = $this->input->post('rr_multi_rounds');
	
				foreach($groups as $i => $group){
					for($j=0; $j<$rounds_per_team; $j++){
						$robin = new RRobin();

						$competitors		= $group;
							if($j%2 == 1){
								$competitors = array_reverse($competitors);
							}
						$robin_rounds[$i]	= $robin->create($competitors);
						//$robins[$j]			= $robin->tour;

						// New code for order of matches
						$temp		= "";
						$temp2		= "";
						$pop_temp	= "";

						$temp	    = $robin->tour;

	$total_matches = count($temp);
	if($total_matches > 3) {
		$group_matches = ($total_matches % 2 == 0) ? ($total_matches / 2) : ($total_matches / 3);

		if($group_matches > 10)	{
		$group_matches = ($total_matches % 4 == 0) ? ($total_matches / 4) : ($total_matches / 5);
		}

		$per_group_matches = $total_matches / $group_matches;
	}
	else {
		$per_group_matches = 1;
		$group_matches = 3;
	}

						$pop_temp   = array_splice($temp, 0, $per_group_matches);
						$temp2	    = array_merge($temp, $pop_temp);
						$robins[$j]	= $temp2;
						// New code for order of matches ends here


						$total_games[$i]	= $robin->tot_games;
					}
				
				//echo "<pre>";
				//print_r($robins);
					foreach($robins as $k => $robin){
						foreach($robin as $r){
						$temp_arr[$i][] = $r;
						}
					}
					//$data['robins']	 = $temp_arr;
				}
				
				$data['tourn_id']		= $tourn_id;
				$data['groups']			= $groups;
				$data['robin_rounds']	= $robin_rounds;
				$data['players']		= $competitors;
				$data['robins']			= $temp_arr;
				$data['total_games']	= $total_games;

				$data['rr_multi_rounds']	= $rounds_per_team;
				
				/*echo "<pre>";
				print_r($data);
				exit;*/
				$this->load->view('includes/header');
				$this->load->view('view_rr_group_bracket_generate',$data);
				$this->load->view('includes/footer');
			}
		 }

		public function change_team_homeloc(){
			$tourn_match_id = $this->input->post('tm');
			$team_id = $this->input->post('team');
				if($tourn_match_id and $team_id and ($this->is_super_admin or $logged_user)){
					$upd = $this->model_league->upd_team_homeloc($tourn_match_id, $team_id);
				}
		}

		public function change_match_date(){
			$tourn_match_id = $this->input->post('tm');
			$match_date			= date('Y-m-d', strtotime($this->input->post('dt')));
				if($tourn_match_id and $match_date and ($this->is_super_admin or $logged_user)){
					$upd = $this->model_league->upd_match_date($tourn_match_id, $match_date);
				}
		}

		public function getCourtInfo(){
			$tourn_id = $this->input->post('tourn_id');
			$get_matches	= $this->model_league->get_court_matches($tourn_id);
			//echo $tourn_id; exit;
			if($get_matches){
				$data['matches'] = $get_matches;
				$data['tourn_id'] = $tourn_id;
				$this->load->view('view_court_assignments', $data);
			}
			else{
				echo "No court assignments found!";
			}
		}		
		
		public function courts_print($tourn_id){
			$get_matches	= $this->model_league->get_court_matches($tourn_id);
			
			if($get_matches){
				$data['matches'] = $get_matches;
				$this->load->view('print_court_assignments', $data);
			}
			else{
				echo "No court assignments found!";
			}
		}

		public function get_bracket_firstmatch($bid){
			return $this->general->get_bracket_firstmatch($bid);
		}

		public function shareBracket($bid){
						$data['bracket_id']  = $bid;
			$get_bracket		 = $this->model_league->get_bracket_rounds($data);
			$data['get_bracket'] = $get_bracket;
			$data['match_type']  = $get_bracket['Match_Type'];
			$tr_id				 = $get_bracket['Tourn_ID'];
			
			$tourn_det = $this->model_league->getonerow($tr_id);
			$data['tour_details']  = $get_bracket['Match_Type'];


			if($get_bracket['Bracket_Type'] == 'Single Elimination'){
				$data['get_tourn_matches'] = $this->model_league->get_tourn_matches($data);
			}
			else if($get_bracket['Bracket_Type'] == 'Consolation'){
				$data['get_tourn_matches'] = $this->model_league->get_tourn_matches_main($bracket_id);
				$data['get_cd_tourn_matches'] = $this->model_league->get_cd_tourn_matches($bracket_id);
				$data['get_cd_num_rounds'] = $this->model_league->get_cd_tot_rounds($bracket_id);
			}
			else if($get_bracket['Bracket_Type'] == 'Round Robin'){
				$data['get_rr_tourn_matches'] = $this->model_league->get_tourn_matches($data);
			}
			else if($get_bracket['Bracket_Type'] == 'Play Off'){
				$data['get_po_tourn_matches']	= $this->model_league->get_po_tourn_matches($bracket_id);
				$data['get_po_line_matches']	= $this->model_league->get_po_line_matches($bracket_id);
			}

				if($tourn_det->tournament_format == 'Teams' and $get_bracket['Bracket_Type'] == 'Play Off'){
					return $this->load->view('teams/view_team_po_draws', $data);
				}
				else if($tourn_det->tournament_format == 'Teams' and $get_bracket['Bracket_Type'] == 'Single Elimination'){
					return $this->load->view('teams/view_team_se_draws_print', $data);
				}
				else if($tourn_det->tournament_format == 'Teams'){
					return $this->load->view('view_team_print_draws', $data);
				}
				else if($tourn_det->tournament_format == "TeamSport" and $get_bracket['Bracket_Type'] == 'Single Elimination'){
					$this->load->view('teams/view_teamsport_se_draws', $data);
				}
				else if($tourn_det->tournament_format == "TeamSport" and $get_bracket['Bracket_Type'] == 'Round Robin'){
					$this->load->view('teams/view_teamsport_rr_draws', $data);
				}
				else{
					return $this->load->view('view_se_print_draws', $data);
				}

		}

		public function league_ratings_ins_manually(){
			$tourn_id = 3433;

			//$tourn_matches = $this->model_league->get_matches($tourn_id);

			foreach($tourn_matches as $match){
				$p1   = $match->Player1;
				$p1p = $match->Player1_Partner;
				$p2   = $match->Player2;
				$p2p = $match->Player2_Partner;

				if($p1){
						$st = $this->model_league->insert_init_rating($p1, $tourn_id, $match->BracketID);
						if($st)
							echo $p1. " - Success<br>"; 
				}
				if($p1p){
						$st = $this->model_league->insert_init_rating($p1p, $tourn_id, $match->BracketID);
						if($st)
							echo $p1. " - Success<br>"; 
				}
				if($p2){
						$st = $this->model_league->insert_init_rating($p2, $tourn_id, $match->BracketID);
						if($st)
							echo $p1. " - Success<br>"; 
				}
				if($p2p){
						$st = $this->model_league->insert_init_rating($p2p, $tourn_id, $match->BracketID);
						if($st)
							echo $p1. " - Success<br>"; 
				}

			}

		}

		public function get_draw_init_ratings($uid, $bracket_id,$tourn_id){

$get_init_rating = $this->model_league->get_draw_std_init_ratings($uid, $bracket_id);
			
					if($get_init_rating){
						//echo "testing ".$get_init_rating['Init_Rating']; exit;
						$init_a2m   = $get_init_rating['Init_Rating'];
						$final_a2m = $get_init_rating['Upd_Rating'];
						$change = $final_a2m - $init_a2m;
					}
					else{
								$player_a2m = $this->model_league->get_a2m($uid, $tourn_id);

							$init_a2m   = 0;
							$final_a2m = NULL;

							if($player_a2m){
								$final_a2m = max($player_a2m['A2MScore'], $player_a2m['A2MScore_Doubles'], $player_a2m['A2MScore_Mixed']);
							}

							if(!$init_a2m){
								$init_a2m  =  $final_a2m;				
							}
							
							$change =  $final_a2m -$init_a2m;
					}
				return array('init' => $init_a2m,'final' => $final_a2m,'change' => $change);
		}

	public function add_fields_weekly()
	{
		$count = $this->input->post('count');
		$sd = $this->input->post('sd');
		$ed = $this->input->post('ed');
		$st  = $this->input->post('st');
		$et  = $this->input->post('et');
		$event  = $this->input->post('event');

		$sel_weeks = $this->input->post('sel_weeks');

		$op = "";
		$ev_date = date('m/d/Y', strtotime($sd));
		$sno = 1;
		for($x = 1; $x <= $count+1; $x++){

			$day_ev_date = strtotime($ev_date);
			$day				  = date('N',$day_ev_date);
			
			if(in_array($day, $sel_weeks)){
			
			$options1 = ""; $options2 = "";
			for($i = 0; $i < 24; $i++){
				$sel1 = ""; $sel2 = "";
				$sel_st1 = ($i % 12) ? ($i % 12).":00" : '12:00'; 
				$sel_st1 .= ($i >= 12) ? ' PM' : ' AM';

				if($sel_st1 == $st) { $sel1 = "selected"; }
				//if($sel_st1 == $et) { $sel2 = "selected"; }

				$options1 .= "<option value='".$sel_st1."' ".$sel1.">".$sel_st1."</option>";
				//$options2 .= "<option value='".$sel_st1."' ".$sel2.">".$sel_st1."</option>";
			}
	
			
			$op .= "<div class='form-group' align='center'>
						<label class='control-label col-md-2' for='id_accomodation' align='right'></label>
						<div class='col-md-6'>
						<table><tr>
						<td> #".$sno."&nbsp;&nbsp;</td>
						<td><input type='hidden' name='game_dt[$event][]' value = '".$ev_date."'>".date('m-d-Y', strtotime($ev_date))."</td>
						<td><select class='form-control' name='game_st[$event][]' id='ev_st'>".$options1."</select></td>
						</tr></table>
						</div></div><br>";
$sno++;
			}
			$ev_date = date('m/d/Y', strtotime('+1 day', strtotime($ev_date)));

		}
		echo $op;
	}

	public function get_event_occrs($tourn_id, $evnt){
		$get_ev_occrs = $this->model_league->get_event_occrs($tourn_id, $evnt);
		return $get_ev_occrs;
	}

		public function get_league_occr($tourn_id){
			return $this->model_league->get_league_occr($tourn_id);
		}

		public function get_occr_info($ocr_id){
			return $this->model_league->get_occr_info($ocr_id);
		}


		public function get_ocr_players(){
			$ocr = $this->input->post('ocr_id');
			$tourn_id = $this->input->post('tourn_id');
			$tourn_det = $this->model_league->getonerow($tourn_id);

			$res = $this->model_league->get_reg_tourn_players($tourn_id, '', $ocr);
				$data2['tour_details']				= $tourn_det;
				$data2['tourn_reg_names']	= $res;
				$data2['parent_class']			= 'league';

				echo $this->load->view('academy_views/tournament/view_players_section', $data2);
		}

		public function check_in(){
			$tourn_id = $this->input->post('tourn_id');
			$this->model_league->update_checkIn($this->logged_user, $tourn_id, 1);
			//$this->session->set_flashdata('check_in_success', 'Successfully Checked In');
			echo "Successfully Checked In. Thank you";
		}

		public function set_bracket_session(){
			$sess_data							= array();
			$sess_data['draw']['format']	= $this->input->post('draw_format');
			$sess_data['draw']['is_checkin']	= $this->input->post('is_checkin');
			$sess_data['draw']['ttype']	= $this->input->post('ttype');
			$sess_data['draw']['filters']	= array_unique($this->input->post('match_type'));
			$sess_data['draw']['users']	= $this->input->post('users');
			$sess_data['draw']['is_groups']	= $this->input->post('is_groups');
			$sess_data['draw']['sel_groups']	= $this->input->post('sel_groups');
			$sess_data['draw']['sel_game_days']			= $this->input->post('sel_game_days');
			$sess_data['draw']['draw_format']	= $this->input->post('draw_format');
			$sess_data['draw']['is_group_top_players']	= $this->input->post('is_group_top_players');
			$sess_data['draw']['is_sch_courts']	= $this->input->post('is_sch_courts');

			$this->session->set_userdata($sess_data);
			
			/*echo "<pre>";
			print_r($this->session->userdata('draw'));
			echo "<br>------";
			print_r($_POST);
			exit;*/
		}
		
		public function get_game_day($gd){
			return $this->model_league->get_game_day($gd);
		}

		 public function auto_reg_players($param = ''){
			$q	   = $_POST['name_startsWith'];
			$tid  = $data['tid'] = $_POST['tid'];

			$data['key'] = trim($q);

			$result = $this->general->search_autocomplete($data);

				if($result){
					$data_new = array();
					foreach($result as $row){
						//$get_a2m = $this->general->get_a2msocre($sp_type, $row->Users_ID);
						//$name = $row->Firstname.' '.$row->Lastname.'|'.$row->Users_ID.'|'.$row->City.'|'.$row->State			.'|'.$get_a2m['A2MScore'].'|'.$row->Gender;
						$name = $row->Firstname.' '.$row->Lastname.'|'.$row->Users_ID.'|'.$row->City.'|'.$row->State.'|'.$row->Gender;
						array_push($data_new, $name);	
					}
				}
				else{
					$data_new = array();
					$name = "No match found!";
					array_push($data_new, $name);	
				}
			 
			 echo json_encode($data_new);
			 exit;
		 }

		 public function get_event_title($event_id){
			$event_title = "";

				   $arr = explode('-', $event_id);
				   $ag		= $arr[0];
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

				   if( $arr[1] != 'Open')
				   $get_level_label = league::get_level_name('', $level);

					$lbl = '';
					$lbl = ' '.$get_level_label['SportsLevel'];

					$event_title = $gen.' '.$format.$lbl;

			return $event_title;
		}

		public function delete_tourn($tourn_id){


			$check_tourn = $this->model_league->check_scores($tourn_id);

			if($check_tourn > 0){
				echo "<h3><b>This tournament can not be deleted!</b></h3>";
				exit;
			}
			else{
				echo "<h1><b>This tournament can be deleted!</b></h1>";
				exit;
			}
		}

		public function test_tourn_email($tourn_id){
                $tourn_det = $this->model_league->getonerow($tourn_id);

				$userdat							=	$this->get_username('10891');
				$tourn_admin_email			=	$userdat['EmailID'];
				$tourn_admin_firstname	=	$userdat['Firstname'];
				$tourn_admin_lastname	=	$userdat['Lastname'];

				$tourn_admin_data = array(
												'admin_firstname'	=> $tourn_admin_firstname,
												'admin_lastname'	=> $tourn_admin_lastname,
												'tourn_id'				=> $tourn_id,
												'title'						=> $tourn_det->tournament_title,
												'page'					=> 'Tournament Creation Admin Notif'
												);

				$subject	= "Tournament Creation Notification!";

				$s_email  =	$this->email_to_player($tourn_admin_email, $subject, $tourn_admin_data);

                if($tourn_det->Short_Code!="")
                   redirect("$tourn_det->Short_Code");
				else
                   redirect("league/$tourn_id");
		}

		public function unpublish($tourn_id) {
			$this->get_logged_user_role($tourn_id);

			if($this->logged_user_role == "Admin" or $this->is_super_admin){
				$this->model_league->unpulish_league($tourn_id);
				redirect("league/$tourn_id");
			}
			else{
				echo "Invalid Request!"; exit;
			}			
		}

		public function publish($tourn_id) {
			$this->get_logged_user_role($tourn_id);

			if($this->logged_user_role == "Admin" or $this->is_super_admin){
				$this->model_league->pulish_league($tourn_id);
				redirect("league/$tourn_id");
			}
			else{
				echo "Invalid Request!"; exit;
			}
		}

		public function is_draw_complete($bracket_id){
			return $this->model_league->is_draw_complete($bracket_id);
		}

		//public function get_player_standings($bracket_id){
		//}
		public function is_user_reg_event($tid, $event){
			$check_reg = $this->model_league->is_user_reg_event($tid, $event);
			return $check_reg;
		}

		/*public function get_user($user_id){
			$get_user = $this->model_league->get_user($user_id);
			return $get_user;
		}*/
}