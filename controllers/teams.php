<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
error_reporting(0);
	//League controller ..
	class Teams extends CI_Controller {

	public $logged_user;

		public function __construct()
		{
			parent:: __construct();
			$this->load->model('model_news');
			$this->load->model('model_general', 'general');
			$this->load->model('model_teams', 'teams');
			$this->load->helper(array('form', 'url'));
			$this->load->library('session');
			$this->load->library('image_lib');

			$this->logged_user = $this->session->userdata('users_id');
		}
		
		// viewing league page ...
		public function index($team_id=''){
			$data = '';
			$data['team_info']   = $this->teams->get_team_info($team_id);
			$data['team_stats'] = $this->teams->get_team_stats($team_id);

				$this->load->view('includes/view_sports_header');
				$this->load->view('view_team_page', $data);
				$this->load->view('includes/view_home_footer');
	    }

		public function view()
		{
			$data['results']		= $this->model_news->get_news();
			$data['sports']			= $this->general->get_sports();

			if($this->logged_user)
			{
				$data['user_created']	= $this->teams->get_user_created();
				$data['user_part']		= $this->teams->get_user_part();
				$data['user_non_part']	= $this->teams->get_user_non_part();
			}

			$this->load->view('includes/header');
			$this->load->view('teams/view_team_page', $data);
			$this->load->view('includes/view_right_column', $data);
			$this->load->view('includes/footer');
	    }

		public function addnew()
		{
			$data['sports']		 = $this->general->get_sports();
			$data['news_id_det'] = $this->model_news->get_news_detail($news_id);
			$data['results']	 = $this->model_news->get_news();

			$this->load->view('includes/header');
			$this->load->view('teams/view_create_team', $data);
			$this->load->view('includes/view_right_column', $data);
			$this->load->view('includes/footer');
		}

		public function create()
		{
			if($this->input->post('bulk_register')){
			    $format	 =	explode('.',$_FILES['team_logo']['name']);
			    $format	 =	end($format);
			    $re		 =	md5($_FILES['team_logo']['name']);
			    $re_name =	time()."_".substr($re, 0, 8); 

				$_FILES['team_logo']['name'] = $re_name.'.'.$format;
				$filename = 'team_logo';  

				$config = array(
				    'upload_path'	=> "./team_logos/",
					'allowed_types' => "gif|jpg|png|jpeg",
					'overwrite'		=> FALSE,
					'max_size'		=> "10000", // Can be set to particular file size , here it is 2 MB(2048 Kb)
					//'max_height'	=> "100",
					//'max_width'		=> "100"
					);
				
				$this->load->library('upload',$config);
				$data = $this->upload->data();
				$this->upload->initialize($config);		
				if($this->upload->do_upload($filename)) 
				{	
					//echo "<pre>";print_r($data);exit();
					$data = $this->upload->data();	
                    $resize_conf = array(
							'upload_path'  => "./team_logos/cropped/",
							'source_image' => $data['full_path'],  
							//'new_image'  => './tour_pictures/$tourn_id/thumbs/'.$upload_data['file_name'],
							'new_image'    => $data['file_path'].'cropped/'.$data['file_name'],
							'width'        => '150',
							'height'       => '150'
							);
					
					$this->load->library('image_lib');
					$this->image_lib->initialize($resize_conf);
					
					// do it!
					if(!$this->image_lib->resize()){
						// if got fail.
						$error['resize'] = $this->image_lib->display_errors();
						//echo "error occured";exit();
						//echo "<pre>"; print_r($error);
						//echo "<pre>"; print_r($error);exit();
						//exit;
					}
					else{
						 //print_r($resize_conf);exit();
					}

				}else{
				  echo $this->upload->display_errors();  
				}	
                $team_reg = $this->teams->create_team();
				$red_url = $this->input->post('id');

				if($team_reg and $red_url){ redirect($red_url); }
				else{ redirect(base_url().'Play'); }
			}
			else{
				echo "Invalid Request!";
			}
		}

		public function update_team_name()
		{
			if($this->input->post('team_id')){
				$upd_team = $this->teams->update_team_name();
			}
			else{
				echo "Invalid Request!";
			}
		}

		public function get_team()
		{
				$team_id   = $this->input->post('team_id');
				$tourn_id  = $this->input->post('tourn_id');
				$team_info = $this->teams->get_team_info($team_id);

				if($team_info['Captain'] == $this->logged_user)
				{	

					$team_players = json_decode($team_info['Players']);

					foreach($team_players as $player)
					{
						$check_player = $this->teams->is_player_reg_tourn($player, $tourn_id, $team_id);
						$avail_players[$player] = $check_player;
						$data['team_players'] = $avail_players;
					}

					$this->load->view('teams/view_sel_team_players', $data);
				}
		}

		public function get_tour_reg_team()
		{
			$team_id   = $this->input->post('team_id');
			$tourn_id  = $this->input->post('tourn_id');

			$team_info			= $this->teams->get_team_info($team_id);
			$tour_team_info		= $this->teams->get_tour_team_info($tourn_id, $team_id);

			$team_players		= json_decode($team_info['Players']);
			$tour_team_players	= json_decode($tour_team_info['Team_Players']);

				foreach($team_players as $player)
				{
					$is_player_locked   = $this->teams->check_is_player_locked($player, $tourn_id, $team_id);
						$check_player = 0;
					if(in_array($player, $tour_team_players)){
						$check_player = 2;
					}
					else if($is_player_locked){
						$check_player = $is_player_locked;
					}

					$avail_players[$player] = $check_player;
					$data['team_players']	= $avail_players;
					$data['team_id']		= $team_id;
					$data['tourn_id']		= $tourn_id;
					$data['team_captain']	= $team_info['Captain'];
				}

			$this->load->view('teams/view_manage_tour_team', $data);
		}

		public function approve($sec_code)
		{

			if($sec_code != '' and strlen($sec_code) == 16)
			{
				$get_req_info = $this->teams->get_joinreq_info($sec_code);

				if($get_req_info) // and ($get_req_info['Captain'] == $this->logged_user))
				{
					$data['req_team']	 = $get_req_info['Team_ID'];
					$data['req_user']	 = $get_req_info['Users_id'];
					$data['prev_status'] = $get_req_info['Response'];

					$this->load->view('includes/header');
					$this->load->view('teams/view_approve_joinreq', $data);
					//$this->load->view('includes/view_right_column');
					$this->load->view('includes/footer');
				}
				else{ echo "Oops, Something went wrong! Please contact admin@a2msports.com. Thanks."; }
			}
			else if($this->input->post('act_join'))
			{
				$proc_req = $this->teams->process_join_req();

				if($proc_req){
					
					/* --------- Notification mail to the receipient ------------ */
					$user			= $this->input->post('req_player');
					$team			= $this->input->post('req_team');
					$comments		= $this->input->post('comments');
					$action_taken   = $this->input->post('act_type');

					$get_team = $this->teams->get_team_info($team);
					$get_user = $this->general->get_user($user);

					$sub = "Response for your request to join in team - ".$req_team;

					$this->load->library('email');
					$this->email->set_newline("\r\n");
					$this->email->from(FROM_EMAIL, 'A2MSports Teams');
					$this->email->to($get_user['EmailID']);
					$this->email->subject($sub);

					$data = array(
					'player_name'	=> ucfirst($get_user['Firstname'])." ".ucfirst($get_user['Lastname']),
					'comments'		=> $comments,
					'action_taken'	=> $action_taken,
					'team'			=> $get_team['Team_name'],
					'page'			=> 'Response for Join Request in Team'
					);

					$body = $this->load->view('view_email_template.php', $data, TRUE);

					$this->email->message($body);
					$this->email->send();
					/* --------- Notification mail to the receipient ------------ */
					
					redirect(base_url()."/teams/thanks/2"); 
				}
				else{ echo "Sorry, Something went wrong! Please try again."; }
			}
			else{ echo "Invalid Request"; }
		}

		public function join_request()
		{
			$team_id = $this->input->post('team_id');
			$tour_id = $this->input->post('tourn_id');

			$check_is_req = $this->teams->check_is_req($team_id);

			if(!$check_is_req){

			$get_team = $this->teams->get_team_info($team_id);
			$get_tour = $this->general->get_tour_info($tour_id);

			$get_user = $this->general->get_user($this->logged_user);
			$get_captain_user = $this->general->get_user($get_team['Created_by']);

				$player = ucfirst($get_user['Firstname']) . ' ' . ucfirst($get_user['Lastname']);
				$title	= $get_tour['tournament_title'];

				$sub = "Player sent a join request in your team - ".$get_team['Team_name'];

				$this->load->library('email');
				$this->email->set_newline("\r\n");
				$this->email->from(FROM_EMAIL, 'A2MSports Teams');
				$this->email->to($get_captain_user['EmailID']);
				//$this->email->to('rajnikar@ardent-india.com');
				$this->email->subject($sub);

				$rand_val = rand(1000, 1000000);
				$md5_code = md5($rand_val);

				$sec_code = substr($md5_code, 1, 16);

				$data = array(
				'team_id'	=> $team_id,
				'player'	=> $player,
				'captain_id'=> $get_team['Created_by'],
				'captain'	=> ucfirst($get_captain_user['Firstname'])." ".ucfirst($get_captain_user['Lastname']),
				'tourn_id'	=> $tour_id,
				'title'		=> $title,
				'team'		=> $get_team['Team_name'],
				'sec_code'	=> $sec_code,
				'page'		=> 'Team Join Request from Player'
				);

				$ins_db = $this->teams->ins_team_req($data);

				$body = $this->load->view('view_email_template.php', $data, TRUE);

				$this->email->message($body);
				$this->email->send();

				echo '1';
			}
			else{
				echo '0';
			}
		}

		public function join_req()
		{
			$team_id = $this->input->post('tid');

			$get_team = $this->teams->get_team_info($team_id);
			$get_user = $this->general->get_user($this->logged_user);
			$get_captain_user = $this->general->get_user($get_team['Created_by']);

				$player = ucfirst($get_user['Firstname']) . ' ' . ucfirst($get_user['Lastname']);

				$sub = "Player sent a request to join in your team - ".$get_team['Team_name'];

				$this->load->library('email');
				$this->email->set_newline("\r\n");
				$this->email->from(FROM_EMAIL, 'A2MSports Teams');
				$this->email->to($get_captain_user['EmailID']);
				//$this->email->to('npradkumar@gmail.com');
				$this->email->subject($sub);

				$rand_val = rand(1000, 1000000);
				$md5_code = md5($rand_val);

				$sec_code = substr($md5_code, 1, 16);

				$data = array(
				'team_id'	=> $team_id,
				'player'	=> $player,
				'captain_id'=> $get_team['Created_by'],
				'captain'	=> ucfirst($get_captain_user['Firstname'])." ".ucfirst($get_captain_user['Lastname']),
				'team'		=> $get_team['Team_name'],
				'sec_code'	=> $sec_code,
				'page'		=> 'Join Request in Team'
				);

				$ins_db = $this->teams->ins_team_req($data);

				$body = $this->load->view('view_email_template.php', $data, TRUE);

				$this->email->message($body);
				$this->email->send();

				echo '1';
		}

		public function withdraw()
		{
			$team_id = $this->input->post('tid');

			$withdraw_teams	  = $this->teams->withdraw_from_team($team_id);

			$get_team		  = $this->teams->get_team_info($team_id);
			$get_user		  = $this->general->get_user($this->logged_user);
			$get_captain_user = $this->general->get_user($get_team['Created_by']);

				$player = ucfirst($get_user['Firstname']).' '.ucfirst($get_user['Lastname']);

				$sub = "Player withdraw from your team - ".$get_team['Team_name'];

				$this->load->library('email');
				$this->email->set_newline("\r\n");
				$this->email->from(FROM_EMAIL, 'A2MSports Teams');
				$this->email->to($get_captain_user['EmailID']);
				//$this->email->to('npradkumar@gmail.com');
				$this->email->subject($sub);

				$data = array(
				'team_id'	=> $team_id,
				'player'	=> $player,
				'captain_id'=> $get_team['Created_by'],
				'captain'	=> ucfirst($get_captain_user['Firstname'])." ".ucfirst($get_captain_user['Lastname']),
				'team'		=> $get_team['Team_name'],
				'page'		=> 'Withdraw from Team'
				);

				$body = $this->load->view('view_email_template.php', $data, TRUE);

				$this->email->message($body);
				$this->email->send();

				echo '1';
		}

		public function update_team()
		{
					//	echo "<pre>"; print_r($_POST); exit;

			if($this->input->post('upd_players') or $this->input->post('team_id')){
			//echo "<pre>"; print_r($_POST); exit;
				$tourn_id	 = $this->input->post('tourn_id');
				$update_team = $this->teams->update_teams();

				if($update_team) { redirect(base_url()."/league/".$tourn_id); }
			}
			else{
				echo "Invalid Request";
			}
		}

		public function update()
		{
			if($this->input->post('sel_team_player')){
   
                $team_id	= $this->input->post('team_id');
                if($_FILES['team_logo_'.$team_id]['name'] != ""){

				    $format	=	explode('.',$_FILES['team_logo_'.$team_id]['name']);
                    $format	=	end($format);
				    $re		=	md5($_FILES['team_logo_'.$team_id]['name']);
				    $re_name =	time()."_".substr($re, 0, 8); 

				    //echo $re_name;exit;
					$_FILES['team_logo_'.$team_id]['name']		= $re_name.'.'.$format;
					$filename = 'team_logo_'.$team_id; 
					$old_file = $this->input->post('team_old_logo_'.$team_id); 

				$config = array(
				    'upload_path'	=> "./team_logos/",
					'allowed_types' => "gif|jpg|png|jpeg",
					'overwrite'		=> FALSE,
					'max_size'		=> "10000", // Can be set to particular file size , here it is 2 MB(2048 Kb)
					//'max_height'	=> "100",
					//'max_width'		=> "100"
					);
				
				$this->load->library('upload',$config);
				$data = $this->upload->data();
				$this->upload->initialize($config);
				
				if($this->upload->do_upload($filename)) 
				{	
					
					$data = $this->upload->data();

					if($old_file){
                      $path = './team_logos/'.$old_file;
                      $crop_path = './team_logos/cropped/'.$old_file;
					  unlink($path);
					  unlink($crop_path);
					}else{
						
					}

					 $resize_conf = array(
							'upload_path'  => "./team_logos/cropped/",
							'source_image' => $data['full_path'],  
							//'new_image'  => './tour_pictures/$tourn_id/thumbs/'.$upload_data['file_name'],
							'new_image'    => $data['file_path'].'cropped/'.$data['file_name'],
							'width'        => '150',
							'height'       => '150'
							);
					

					$this->load->library('image_lib');
					$this->image_lib->initialize($resize_conf);
					
					// do it!
					if (!$this->image_lib->resize()){
						// if got fail.
						$error['resize'] = $this->image_lib->display_errors();
						//echo "error occured";exit();
						echo "<pre>"; print_r($error);
						//echo "<pre>"; print_r($error);exit();
						//exit;
					}else{
						 //print_r($resize_conf);exit();
					}
					
					
				}else{
				   echo $this->upload->display_errors();  
				}	
			}
			
				$update_team = $this->teams->update_team_players();
				//if($update_team) { redirect(base_url()."/league/view/".$tourn_id); }
			}
			else{
				echo "Invalid Request";
			}
		}

		public function thanks($type)
		{
			if($type == 1)
			{
				$data['msg']		= "Thankyou for your interest to join. Please wait for Captain's Approval. ";
				$data['page_title'] = "Join Team";	
			}
			else if($type == 2)
			{
				$data['msg']		= "Thankyou for your Action. We will update the player. ";
				$data['page_title'] = "Join Team";	
			}

				$data['results']	= $this->model_news->get_news();

			$this->load->view('includes/header');
			$this->load->view('view_thanks', $data);
			$this->load->view('includes/view_right_column', $data);
			$this->load->view('includes/footer');

		}

		/* ************************************************************* */
		 public function autocomplete($param = '')
		 {
			 	$q		  = $_POST['name_startsWith'];
			 	$team_id  = $_POST['team_id'];
			 	$tourn_id = $_POST['tourn_id'];

				$data['key']	  = trim($q);
				$data['team_id']  = trim($team_id);
				$data['tourn_id'] = trim($tourn_id);

			// if($q and $team_id and $tourn_id)
			// {
				$result = $this->teams->search_autocomplete($data);

				if($result)
				{
					$data_new = array();
					foreach($result as $row)   
					{
						$name = $row->Firstname.' '.$row->Lastname.'|'.$row->Users_ID.'|'.$row->Mobilephone;
						array_push($data_new, $name);	
					}
				}
			// }
			 echo json_encode($data_new);
			 exit;
		 }

		 public function get_username($user_id)
		 {
			return $this->general->get_user($user_id);
		 }

		 public function get_team_info($team_id)
		 {
			return $this->general->get_team($team_id);
		 }

		 public function get_home_location($loc)
		 {
			return $this->general->get_home_location($loc);
		 }

		 public function get_sport($sport_id)
		 {
			return $this->general->get_sport_title($sport_id);
		 }

		 public function get_team_details()
		{
			$team_id   = $this->input->post('team_id');
			$tourn_id  = $this->input->post('tourn_id');

			$team_info			= $this->teams->get_team_info($team_id);
			
			$tour_team_info		= $this->teams->get_tour_team_info($tourn_id, $team_id);

			$team_players		= json_decode($team_info['Players']);
			$tour_team_players	= json_decode($tour_team_info['Team_Players']);

				foreach($team_players as $player)
				{
					$is_player_locked   = $this->teams->check_is_player_locked($player, $tourn_id, $team_id);
						$check_player = 0;
					if(in_array($player, $tour_team_players)){
						$check_player = 2;
					}
					else if($is_player_locked){
						$check_player = $is_player_locked;
					}

					$avail_players[$player] = $check_player;
					$data['team_players']	= $avail_players;
					$data['team_id']		= $team_id;
					$data['tourn_id']		= $tourn_id;
					$data['team_captain']	= $team_info['Captain'];
					$data['team_name']	    = $team_info['Team_name'];
					$data['team_logo']      = $team_info['Team_Logo'];
				}

			$this->load->view('teams/view_manage_team_byadmin', $data);
		}


		public function update_byadmin()
		{
			if($this->input->post('sel_team_player')){
   
                $team_id	= $this->input->post('team_id');
                if($_FILES['team_logo_'.$team_id]['name'] != ""){

				    $format	=	explode('.',$_FILES['team_logo_'.$team_id]['name']);
                    $format	=	end($format);
				    $re		=	md5($_FILES['team_logo_'.$team_id]['name']);
				    $re_name =	time()."_".substr($re, 0, 8); 

				    //echo $re_name;exit;
					$_FILES['team_logo_'.$team_id]['name']		= $re_name.'.'.$format;
					$filename = 'team_logo_'.$team_id; 
					$old_file = $this->input->post('team_old_logo_'.$team_id); 

				$config = array(
				    'upload_path'	=> "./team_logos/",
					'allowed_types' => "gif|jpg|png|jpeg",
					'overwrite'		=> FALSE,
					'max_size'		=> "10000", // Can be set to particular file size , here it is 2 MB(2048 Kb)
					//'max_height'	=> "100",
					//'max_width'		=> "100"
					);
				
				$this->load->library('upload',$config);
				$data = $this->upload->data();
				$this->upload->initialize($config);
				
				if($this->upload->do_upload($filename)) 
				{	
					
					$data = $this->upload->data();

					if($old_file){
                      $path = './team_logos/'.$old_file;
                      $crop_path = './team_logos/cropped/'.$old_file;
					  unlink($path);
					  unlink($crop_path);
					}else{
						
					}

					 $resize_conf = array(
							'upload_path'  => "./team_logos/cropped/",
							'source_image' => $data['full_path'],  
							//'new_image'  => './tour_pictures/$tourn_id/thumbs/'.$upload_data['file_name'],
							'new_image'    => $data['file_path'].'cropped/'.$data['file_name'],
							'width'        => '150',
							'height'       => '150'
							);
					

					$this->load->library('image_lib');
					$this->image_lib->initialize($resize_conf);
					
					// do it!
					if (!$this->image_lib->resize()){
						// if got fail.
						$error['resize'] = $this->image_lib->display_errors();
						//echo "error occured";exit();
						echo "<pre>"; print_r($error);
						//echo "<pre>"; print_r($error);exit();
						//exit;
					}else{
						 //print_r($resize_conf);exit();
					}
					
					
				}else{
				   echo $this->upload->display_errors();  
				}	
			}

				$update_tourn_team = $this->teams->update_tourn_team_players();
			 
				if($update_tourn_team) { redirect(base_url()."/league/view/".$tourn_id); }
			}
			else{
				echo "Invalid Request";
			}
		}

	/*	public function get_TeamsByCountry(){
 			$country = $this->input->post('country');
			$sport   = $this->input->post('sport');

			$data['teams_result'] = $this->teams->get_TeamsByCountry($country,$sport);
			$this->load->view('teams/view_teams_search', $data);
		}*/

		public function manageTeam(){
			$team_id	= $this->input->post('teamId');
			$team_info  = $this->teams->get_team_info($team_id);
			//$data['team_info'] = $team_info;
			$team_players = json_decode($team_info['Players'], true);

			$data['team_id']	  = $team_info['Team_ID'];
			$data['team_name']	  = $team_info['Team_name'];
			$data['team_captain'] = $team_info['Captain'];
			$data['team_players'] = $team_players;
			$data['team_logo']	  = $team_info['Team_Logo'];
			$data['Sport']		  = $team_info['Sport'];

			$this->load->view("teams/view_manage_team_2", $data);
		}

	}