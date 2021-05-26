<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

	//League controller ..
	class AddScore extends CI_Controller {
	
		public function __construct()
		{
			parent:: __construct();
			$this->load->model('model_opponent','opponent');
			$this->load->model('model_general','general');
			$this->load->model('model_news','news');
			$this->load->model('model_addscore');
		}

		// viewing league page ...
		public function index(){

			if(!$this->session->userdata('user')){
				$last_url = array('return_to' => base_url().'addscore');
				$this->session->set_userdata($last_url);
				redirect('login');
			}

		    $data['sports']		 = $this->general->get_sports();
			$data['tournaments'] = $this->model_addscore->get_user_tournaments();
		    $data['results']	 = $this->news->get_news();

			$this->load->view('includes/header');
			$this->load->view('view_addscore', $data);    //view_addscore_newmatch.php
			$this->load->view('includes/view_right_column', $data);
			$this->load->view('includes/footer');
	    }

		public function autocomplete(){
			$q = $_POST['name_startsWith'];
	
			$data['key'] = trim($q);
			$result = $this->model_addscore->search_autocomplete($data);

			if($result){
				$data_new = array();
				foreach($result as $row){
					$name = $row->Firstname.' '.$row->Lastname.'|'.$row->Users_ID;
					array_push($data_new, $name);	
				}
			}
				echo json_encode($data_new);
		}

		public function get_name($uid){
			$get_uname = $this->general->get_user($uid);
			return $get_uname;
		}

		public function add()
		{
		/*	echo "<pre>";
			print_r($_POST);
			exit;*/
			if($this->input->post('player2_user_id') != "")
			{
			$match_date = date("Y-m-d", strtotime($this->input->post('match_date')));
			$cur_date = date("Y-m-d h:i:s");
			$match_type = $this->input->post('match_type');

			if($match_type == "Doubles"){
			$player1_partner = $this->input->post('player1_partner_id');
				$data = array('users_id' => $this->session->userdata('users_id'),
						  'Match_Title' => $this->input->post('match_title'),
						  'Match_Date' => $match_date,
						  'Sports' => $this->input->post('Sport'),
						  'Latitude' => $this->session->userdata('lat'),
						  'Longitude' => $this->session->userdata('long'),
						  'Match_created_on' => $cur_date,
						  'Status' => 'Completed',
						  'Match_Type' => $match_type,
						  'Player1_Partner' => $player1_partner);

				$res = $this->model_addscore->create_new_match_doubles($data);
			}
			else{
				$data = array('users_id' => $this->session->userdata('users_id'),
						  'Match_Title' => $this->input->post('match_title'),
						  'Match_Date' => $match_date,
						  'Sports' => $this->input->post('Sport'),
						  'Latitude' => $this->session->userdata('lat'),
						  'Longitude' => $this->session->userdata('long'),
						  'Match_created_on' => $cur_date,
						  'Match_Type' => $match_type,
						  'Status' => 'Completed');

				$res = $this->model_addscore->create_new_match_singles($data);
			}
				
				if($res){
					redirect('play');
				}
				else{
					echo "Issue Occurred! ";
				}
			}
			else
			{
				echo "<h3>Non Registered Player entered for Player-2.</h3>";

			}
		}

		public function table_view()
		{

			$sport_id = $this->input->post('sport_id');
			$player1 = $this->session->userdata('users_id');
			$player2 = $this->input->post('p2');
			$player1_partner = $this->input->post('p1_r');
			$player2_partner = $this->input->post('p2_r');
			$mt = $this->input->post('mt');

			//echo $player1.'---1---';  echo $player2.'---2----';  echo $player1_partner.'--r1---'; echo $player2_partner.'--r2--'; echo $mt;

			$p1 = $this->get_name($player1);
			$player1_name = $p1['Firstname'] . $p1['Lastname'];
			$p2 = $this->get_name($player2);
			$player2_name = $p2['Firstname'] . $p2['Lastname'];
			$p1_r = $this->get_name($player1_partner);
			$player1_partner_name = $p1_r['Firstname'] . $p1_r['Lastname'];
			$p2_r = $this->get_name($player2_partner);
			$player2_partner_name = $p2_r['Firstname'] . $p2_r['Lastname'];

			
			if($mt == "Doubles"){
			$name = $player1_name . " - " . $player1_partner_name;
			$name1 = $player2_name . " - " . $player2_partner_name;
			}
			else
			{
				$name = $player1_name;
				$name1 = (!empty($player2_name) ?  $player2_name : "player2");
			}

			$ex = "";
			

			if($sport_id == 1)
			{	
				$ex .= "<table class='score-cont'>
							<tr>
							<th>Players</th>
							<th>Set1</th>
							<th>Set2</th>
							<th>Set3</th>
							<th>Set4</th>
							<th>Set5</th>
							<th>Set6</th>
						   </tr>"; 
			}else {

				$ex .= "<table class='score-cont'>			  
							<tr>
							<th>Players</th>
							<th>Game1</th>
							<th>Game2</th>
							<th>Game3</th>
							<th>Game4</th>
							<th>Game5</th>
							<th>Game6</th>
						   </tr>";
			    }

				$ex .= 	
						"<tr>
							<td bgcolor='#fdd7b0' style = 'width:10%'><b>$name</b></td>
							<td><input id='set1_1' name='player1[]' style = 'width:65%' type='text' maxlength='2' /></td>
							<td><input id='set1_1' name='player1[]' style = 'width:65%' type='text' maxlength='2' /></td>
							<td><input id='set1_1' name='player1[]' style = 'width:65%' type='text' maxlength='2' /></td>
							<td><input id='set1_1' name='player1[]' style = 'width:65%' type='text' maxlength='2' /></td>
							<td><input id='set1_1' name='player1[]' style = 'width:65%' type='text' maxlength='2' /></td>
							<td><input id='set1_1' name='player1[]' style = 'width:65%' type='text' maxlength='2' /></td>

						 </tr>
						  <tr>
							<td bgcolor='#fdd7b0'><b><span id='player2'>$name1</span></b></td>
							<td><input id='set1_2' name='player2[]' style = 'width:65%' type='text' maxlength='2' /></td>
							<td><input id='set1_2' name='player2[]' style = 'width:65%' type='text' maxlength='2' /></td>
							<td><input id='set1_2' name='player2[]' style = 'width:65%' type='text' maxlength='2' /></td>
							<td><input id='set1_2' name='player2[]' style = 'width:65%' type='text' maxlength='2' /></td>
							<td><input id='set1_2' name='player2[]' style = 'width:65%' type='text' maxlength='2' /></td>
							<td><input id='set1_2' name='player2[]' style = 'width:65%' type='text' maxlength='2' /></td>
							
						 </tr>
						</table>";

			echo $ex;
			
		
		}

		public function draws_view($tourn_id = '')
		{	
			$tourn_id = $this->input->post('tourn_id');
			//$user_draws = $this->model_addscore->get_brackets($tourn_id);
			$user_draws = $this->model_addscore->get_bracket_list($tourn_id);
			//$bracket_details = $this->model_addscore->get_bracket_details($tourn_id);
			
			$data['user_draws'] = $user_draws;		
			$this->load->view('view_addscore_tournament_matches',$data);
		}

		public function get_brackets($bracket_id = '')
		{	
			return $this->model_addscore->get_brackets($bracket_id);
		}

		public function check_edit_match($bracket_id, $match_num, $round, $draw_type, $tour_type){

			return $this->model_addscore->check_edit_match($bracket_id, $match_num, $round, $draw_type, $tour_type);

		}
	
	
	}
