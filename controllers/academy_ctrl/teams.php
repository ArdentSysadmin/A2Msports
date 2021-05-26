<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


	//League controller ..
	class Teams extends CI_Controller {

	 	public $header_tpl	   = "academy_views/includes/academy_header";
	 	public $right_col_tpl  = "academy_views/includes/academy_right_column";
	 	public $footer_tpl	   = "academy_views/includes/academy_footer";

		public $logged_user;
		public $short_code;
		public $academy_admin;
		public $org_id;

		public function __construct()
		{
			parent:: __construct();
			$this->load->model('model_news');
			$this->load->model('academy_mdl/model_general', 'general');
			$this->load->model('academy_mdl/model_academy', 'model_academy');
			$this->load->model('academy_mdl/model_teams', 'teams');
			$this->load->helper(array('form', 'url'));
			$this->load->library('session');

			$this->short_code    = $this->uri->segment(1);
			$this->org_id	     = $this->general->get_orgid($this->short_code);
			$this->academy_admin = $this->general->get_org_admin($this->short_code);
			$this->logged_user	 = $this->session->userdata('users_id');

			$this->admin_menu_items = array('0'=>'');
			 if($this->logged_user != $this->academy_admin)
			$this->admin_menu_items = array('0'=>'8');
		}
		
		// viewing league page ...
		public function index($tid='')
		{
			echo "Teams";
	    }

		public function get_org_details($org_id)
		{
			$org_details			= $this->model_academy->get_academy_details($org_id); 
			$data['org_details']	= $org_details; 

			$data['creator']		= $org_details['Users_ID'];

			$data['menu_list']		= $this->model_academy->get_menu_list();
			$data['act_menu_list']	= $this->model_academy->get_act_menu_list($org_id);
			$data['results']		= $this->model_academy->get_news($org_id);
			$data['sport_levels']	= $this->model_academy->get_tennis_levels();

			return $data;
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

			$this->load->view($this->header_tpl,$data);
			$this->load->view('academy_views/teams/view_team_page',$data);
			$this->load->view($this->right_col_tpl,$data);
			$this->load->view($this->footer_tpl);
	    }

		public function addnew()
		{
			$data = $this->get_org_details($this->org_id);

			$data['sports']		 = $this->general->get_sports();
			/*$data['news_id_det'] = $this->model_news->get_news_detail($news_id);
			$data['results']	 = $this->model_news->get_news();*/

			$this->load->view($this->header_tpl,$data);
			$this->load->view('academy_views/teams/view_create_team',$data);
			$this->load->view($this->right_col_tpl,$data);
			$this->load->view($this->footer_tpl);
		}

		public function create()
		{
			if($this->input->post('bulk_register')){
				$team_reg = $this->teams->create_team();

				$red_url = $this->input->post('id');

				if($team_reg and $red_url){ redirect($red_url); }
				else{ redirect(base_url().'Play'); }
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

					$this->load->view('academy_views/teams/view_sel_team_players', $data);
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

			$this->load->view('academy_views/teams/view_manage_tour_team', $data);
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

					$this->load->view($this->header_tpl,$data);
					$this->load->view('academy_views/teams/view_approve_joinreq', $data);
					//$this->load->view($this->right_col_tpl,$data);
					$this->load->view($this->footer_tpl);
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

					$body = $this->load->view('academy_views/view_email_template.php', $data, TRUE);

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

				$body = $this->load->view('academy_views/view_email_template.php', $data, TRUE);

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

				$body = $this->load->view('academy_views/view_email_template.php', $data, TRUE);

				$this->email->message($body);
				$this->email->send();

				echo '1';
		}

		public function withdraw()
		{
			$team_id = $this->input->post('tid');

			//$check_is_req_wd = $this->teams->check_is_req_wd($team_id);

			//if(!$check_is_req_wd){

			$get_team		  = $this->teams->get_team_info($team_id);
			$get_user		  = $this->general->get_user($this->logged_user);
			$get_captain_user = $this->general->get_user($get_team['Created_by']);

				$player = ucfirst($get_user['Firstname']).' '.ucfirst($get_user['Lastname']);

				$sub = "Player sent a request to withdraw from your team - ".$get_team['Team_name'];

				$this->load->library('email');
				$this->email->set_newline("\r\n");
				$this->email->from(FROM_EMAIL, 'A2MSports Teams');
				$this->email->to($get_captain_user['EmailID']);
				//$this->email->to('npradkumar@gmail.com');
				$this->email->subject($sub);

				//$rand_val = rand(1000, 1000000);
				//$md5_code = md5($rand_val);

				//$sec_code = substr($md5_code, 1, 16);

				$data = array(
				'team_id'	=> $team_id,
				'player'	=> $player,
				'captain_id'=> $get_team['Created_by'],
				'captain'	=> ucfirst($get_captain_user['Firstname'])." ".ucfirst($get_captain_user['Lastname']),
				//'tourn_id'	=> $tour_id,
				//'title'		=> $title,
				'team'		=> $get_team['Team_name'],
				//'sec_code'	=> $sec_code,
				'page'		=> 'Withdraw Request from Team'
				);

				//$ins_db = $this->teams->ins_team_req($data);

				$body = $this->load->view('academy_views/view_email_template.php', $data, TRUE);

				$this->email->message($body);
				$this->email->send();

				echo '1';
			//}
			//else{
			//	echo '0';
			//}
		}

		public function update_team()
		{
			if($this->input->post('upd_players')){

				$tourn_id	 = $this->input->post('tourn_id');
				$update_team = $this->teams->update_teams();

				if($update_team) { redirect(base_url().$this->short_code."/league/view/".$tourn_id); }
			}
			else{
				echo "Invalid Request";
			}
		}

		public function update()
		{
			//echo "<pre>"; print_r($_POST); exit;
			if($this->input->post('sel_team_player')){

				$team_id	 = $this->input->post('team_id');
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

			$this->load->view($this->header_tpl,$data);
			$this->load->view('academy_views/view_thanks', $data);
			$this->load->view($this->right_col_tpl,$data);
			$this->load->view($this->footer_tpl);
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
	}