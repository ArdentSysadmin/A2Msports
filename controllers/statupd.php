<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


//League controller ..
	class Statupd extends CI_Controller {
	
		public function __construct()
		{
			parent:: __construct();

			$this->load->helper(array('form', 'url'));

			$this->load->library('form_validation');
			$this->load->library('session');
			$this->load->model('model_statupd','test_model');
			$this->load->model('model_news');
			$this->load->model('model_general');
		}
		
		// viewing league page ...
		public function index()
		{

			$data['gen_users']	 = $this->test_model->get_match_users();
			$data['tourn_users'] = $this->test_model->get_tourn_users();

			$match_count = $this->test_model->get_count();

		
			//print_r($match_count);
			//print_r($gen_users);
			//print_r($tourn_users);
			
			$this->load->view('includes/header');
			$this->load->view('view_test',$data);
			$this->load->view('includes/view_right_column',$data);
			$this->load->view('includes/footer');
		}

		
		 public function get_sport($sport_id)
		 {
		 
			return $this->test_model->get_sport_name($sport_id);
		 
		 }

		 public function get_user($user_id)
		 {
		 
			$user_id = $this->session->userdata('users_id');
			return $this->test_model->get_user_name($user_id);
		 
		 }

		 public function register_match($tourn_id)
		 {
			
			$tourn_id =  $this->uri->segment(3);

			$user_id = $this->session->userdata('users_id');

			$reg_details = $this->test_model->get_reg_tournment($tourn_id);

			

			if((!empty($reg_details['Tournament_ID']) == $tourn_id) && ((!empty($reg_details['Users_ID']) == $user_id)))
			{
				
				$data['reg_status'] = "You were already registered for this tournament. Thankyou.";
				
				$details = $this->test_model->getonerow($tourn_id);
				
				$data['r'] = $details;
				$data['results'] = $this->model_news->get_news();
				$this->load->view('includes/header');
				$this->load->view('view_register_match', $data); 
				$this->load->view('includes/view_right_column',$data);
				$this->load->view('includes/footer');

			}
			else
			{
				
				//$tourn_id =  $this->uri->segment(3);
				//$user_id = $this->session->userdata('users_id');
				$details = $this->test_model->getonerow($tourn_id);
				
				$data['r'] = $details;
				//print_r($data['r']);
				//exit;
				$data['results'] = $this->model_news->get_news();
				$this->load->view('includes/header');
				$this->load->view('view_register_match', $data); 
				$this->load->view('includes/view_right_column',$data);
				$this->load->view('includes/footer');	
			}
		 
		 
		 }

		 
		 public function fixtures($tourn_id)
		 {
			
			$tourn_id =  $this->uri->segment(3);
			$user_id = $this->session->userdata('users_id');
			
			$data['tourn_id'] = $tourn_id;
			
			$data['tourn_det'] = $this->test_model->get_fixtures_det($tourn_id);
			$data['tourn_users'] = $this->test_model->get_reg_tourn_usernames($tourn_id);
			$data['results'] = $this->model_news->get_news();
			$data['types'] = $this->input->post('types');
			
			$data['srch_res'] = $this->test_model->get_reg_tourn_users($data);

			$this->load->view('includes/header');
			$this->load->view('test_view',$data);
			$this->load->view('includes/view_right_column',$data);
			$this->load->view('includes/footer');
		
		 }

		 public function calc_win_per($player1,$player2)
		{
			$p1 = json_decode($player1);  

				$cnt1 = count(array_filter($p1));
				$p1_sum = 0;

				if($cnt1 > 0){
					for($i=0; $i<count(array_filter($p1)); $i++)
					{
						$p1_sum = intval($p1_sum) + intval($p1[$i]);
					}
				}

			$p2 = json_decode($player2);  

				$cnt2 = count(array_filter($p2));
				$p2_sum = 0;

				if($cnt2 > 0){
					for($i=0; $i<count(array_filter($p2)); $i++)
					{
						$p2_sum = intval($p2_sum) + intval($p2[$i]);
					}
				}

			$tot_sum = intval($p1_sum + $p2_sum);

			$p1_win = ($p1_sum/$tot_sum)*100;
			$p2_win = ($p2_sum/$tot_sum)*100;


			return array(0 => number_format($p1_win,2), 1 => number_format($p2_win,2));
		}

		public function upd_player_standings($row)
		{

			$get_users = $this->test_model->get_users($row);		// Get all Players from Users table
			/*echo "<table border=1>";
			echo "<tr align='center'>";
			echo "<th>Sport</th><th>User</th><th style='background:green'>Won</th><th style='background:yellow'>Lost</th><th>WF-Won</th>
			<th>WF-Lost</th><th>Bye Matches</th><th>Yet to Play</th><th style='background:red'>Total</th><th style='background:gray'>Valid Matches</th>
			<th>User Win%</th><th>Opp. Win%</th><th>User Avg. Win%</th>";
			echo "</tr>";*/

			$user_id = "";
			foreach($get_users as $user){
			$a = 1;

				for($i=1; $i<10; $i++){			// Sports for loop

					$user_id		= $user->Users_ID;
					$tot_matches	= 0;
					$won			= 0;
					$lost			= 0;
					$win_forfiet	= 0;
					$lost_forfiet	= 0;
					$bye_matches	= 0;
					$np				= 0;
					$user_wp		= 0.00;
					$opp_wp			= 0.00;


					$get_gen_matches = $this->test_model->gen_matches($user_id, $i);

					if(count($get_gen_matches) > 0)
					{
						foreach($get_gen_matches as $ggm)
						{
							$gen_match_user		= $ggm->users_id;
							$gen_match_partner	= $ggm->Player1_Partner;

							$get_ind_matches = $this->test_model->gen_ind_matches($ggm->GeneralMatch_id);

							if(count($get_ind_matches) > 0){
							
								foreach($get_ind_matches as $gim)
								{

									$get_win_per = $this->calc_win_per($gim->Player1_Score, $gim->Opponent_Score);

									$user_wp += $get_win_per[0];
									$opp_wp  += $get_win_per[1];

									$tot_matches++;
									if($gim->Winner == $gen_match_user OR $gim->Winner == $gen_match_partner) { $won++; }
									if($gim->Winner == 0) { $win_forfiet++; }
									if(($gim->Winner != $gen_match_user AND $gim->Winner != $gen_match_partner) and $gim->Winner != 0) { $lost++; }
									if($gim->Winner == '' or $gim->Winner = NULL) { $np++; }
								}
							}
						}
					}

					$get_sp_ind_matches = $this->test_model->gen_sport_ind_matches($user_id, $i);

					if(count($get_sp_ind_matches) > 0)
					{
						foreach($get_sp_ind_matches as $gsim)
						{

							$gen_ind_user		= $gsim->Opponent;
							$gen_ind_partner	= $gsim->Player2_Partner;

							$get_gen_userid = $this->test_model->gen_match_creator($gsim->GeneralMatch_ID);

								$get_win_per = $this->calc_win_per($gsim->Opponent_Score, $gsim->Player1_Score);

									$user_wp += $get_win_per[0];
									$opp_wp  += $get_win_per[1];
									
									$tot_matches++;
									if($gsim->Winner == $gen_ind_user OR $gsim->Winner == $gen_ind_partner) { $won++; }
									if($gsim->Winner == 0) { $win_forfiet++; }
									if(($gsim->Winner != $gen_ind_user AND $gsim->Winner != $gen_ind_partner) and $gsim->Winner != 0) { $lost++; }
									if($gsim->Winner == '' or $gsim->Winner = NULL) { $np++; }
						}
					}
			
					$get_tourn_matches_p1 = $this->test_model->gen_tour_matches_p1($user_id, $i);

					if(count($get_tourn_matches_p1) > 0)
					{
						foreach($get_tourn_matches_p1 as $gtm1)
						{
							$tour_p1_user		= $gtm1->Player1;
							$tour_p1_partner	= $gtm1->Player1_Partner;

								$get_win_per = $this->calc_win_per($gtm1->Player1_Score, $gtm1->Player2_Score);
							
									$user_wp += $get_win_per[0];
									$opp_wp  += $get_win_per[1];
									
									$tot_matches++;
									if($gtm1->Winner != 0 AND ($gtm1->Winner == $tour_p1_user OR $gtm1->Winner == $tour_p1_partner)) { $won++; }
									if($gtm1->Player1_Score == 'Bye Match') { $bye_matches++; }
									if($gtm1->Player1_Score == '[0]' and ($gtm1->Winner == $tour_p1_user OR $gtm1->Winner == $tour_p1_partner))
										{ $win_forfiet++; }
									if($gtm1->Player1_Score == '[0]' and ($gtm1->Winner != $tour_p1_user AND $gtm1->Winner != $tour_p1_partner))
										{ $lost_forfiet++; }
									if(($gtm1->Winner != $tour_p1_user AND $gtm1->Winner != $tour_p1_partner) and $gtm1->Winner != 0) { $lost++; }
									if($gtm1->Winner == '' or $gtm1->Winner = NULL) { $np++; }
						}
					}
			
					$get_tourn_matches_p2 = $this->test_model->gen_tour_matches_p2($user_id, $i);

					if(count($get_tourn_matches_p2) > 0)
					{
						foreach($get_tourn_matches_p2 as $gtm2)
						{

							$tour_p2_user		= $gtm2->Player2;
							$tour_p2_partner	= $gtm2->Player2_Partner;

								$get_win_per = $this->calc_win_per($gtm2->Player2_Score, $gtm2->Player1_Score);
							
									$user_wp += $get_win_per[0];
									$opp_wp  += $get_win_per[1];
									
									/*echo "<tr>";
									echo "<td>".$get_win_per[0]." - ".$get_win_per[1]."<br></td>";
									echo "</tr>";*/

									$tot_matches++;
									if($gtm2->Winner != 0 AND ($gtm2->Winner == $tour_p2_user OR $gtm2->Winner == $tour_p2_partner)) { $won++; }
									if($gtm2->Player1_Score == 'Bye Match') { $bye_matches++; }
									if($gtm2->Player1_Score == '[0]' AND ($gtm2->Winner == $tour_p2_user OR $gtm2->Winner == $tour_p2_partner))
										{ $win_forfiet++; }
									if($gtm2->Player1_Score == '[0]' AND ($gtm2->Winner != $tour_p2_user AND $gtm2->Winner != $tour_p2_partner))
										{ $lost_forfiet++; }
									if(($gtm2->Winner != $tour_p2_user AND $gtm2->Winner != $tour_p2_partner) AND $gtm2->Winner != 0) { $lost++; }
									if($gtm2->Winner == '' or $gtm2->Winner = NULL) { $np++; }
						}
							
					}


					$get_team_line_matches_p1 = $this->test_model->get_team_line_matches_p1($user_id, $i);


					if(count($get_team_line_matches_p1) > 0)
					{
						foreach($get_team_line_matches_p1 as $gtm1)
						{
							$tour_p1_user		= $gtm1->Player1;
							$tour_p1_partner	= $gtm1->Player1_Partner;

								$get_win_per = $this->calc_win_per($gtm1->Player1_Score, $gtm1->Player2_Score);
							
									$user_wp += $get_win_per[0];
									$opp_wp  += $get_win_per[1];
									
									$tot_matches++;
									if($gtm1->Winner != 0 AND ($gtm1->Winner == $tour_p1_user OR $gtm1->Winner == $tour_p1_partner)) { $won++; }
									if($gtm1->Player1_Score == 'Bye Match') { $bye_matches++; }
									if($gtm1->Player1_Score == '[0]' and ($gtm1->Winner == $tour_p1_user OR $gtm1->Winner == $tour_p1_partner))
										{ $win_forfiet++; }
									if($gtm1->Player1_Score == '[0]' and ($gtm1->Winner != $tour_p1_user AND $gtm1->Winner != $tour_p1_partner))
										{ $lost_forfiet++; }
									if(($gtm1->Winner != $tour_p1_user AND $gtm1->Winner != $tour_p1_partner) and $gtm1->Winner != 0) { $lost++; }
									if($gtm1->Winner == '' or $gtm1->Winner = NULL) { $np++; }
						}
					}

					$get_team_line_matches_p2 = $this->test_model->get_team_line_matches_p2($user_id, $i);

					if(count($get_team_line_matches_p2) > 0)
					{
						foreach($get_team_line_matches_p2 as $gtm2)
						{
							$tour_p2_user	 = $gtm2->Player2;
							$tour_p2_partner = $gtm2->Player2_Partner;

								$get_win_per = $this->calc_win_per($gtm2->Player2_Score, $gtm2->Player1_Score);
							
									$user_wp += $get_win_per[0];
									$opp_wp  += $get_win_per[1];
									
									$tot_matches++;
									if($gtm2->Winner != 0 AND ($gtm2->Winner == $tour_p2_user OR $gtm2->Winner == $tour_p2_partner)) { $won++; }
									if($gtm2->Player1_Score == 'Bye Match') { $bye_matches++; }
									if($gtm2->Player1_Score == '[0]' AND ($gtm2->Winner == $tour_p2_user OR $gtm2->Winner == $tour_p2_partner))
										{ $win_forfiet++; }
									if($gtm2->Player1_Score == '[0]' AND ($gtm2->Winner != $tour_p2_user AND $gtm2->Winner != $tour_p2_partner))
										{ $lost_forfiet++; }
									if(($gtm2->Winner != $tour_p2_user AND $gtm2->Winner != $tour_p2_partner) AND $gtm2->Winner != 0) { $lost++; }
									if($gtm2->Winner == '' or $gtm2->Winner = NULL) { $np++; }
						}
							
					}
					
					/*if($tot_matches	> 0 OR
					$won > 0 OR
					$lost > 0 OR
					$win_forfiet > 0 OR
					$bye_matches > 0) {*/

					$valid_matches = intval($won + $lost) - intval($win_forfiet + $lost_forfiet + $bye_matches);
					$user_avg_wp   = number_format($user_wp / $valid_matches, 2);

					$data = array(
						'player'	=>	$user_id,
						'sport'		=>	$i,
						'won'		=>	$won,
						'lost'		=>	$lost,
						'win_ff'	=>	$win_forfiet,
						'lost_ff'	=>	$lost_forfiet,
						'bye_m'		=>	$bye_matches,
						'tot_played'=>	($won + $lost),
						'win_per'	=>	$user_avg_wp
						);

					$upd_player = $this->test_model->update_player_table($data);

					/*echo "<tr align='center'>";
					echo "<td>$i</td>
						<td>$user_id</td>
						<td style='background:green'>$won</td>
						<td style='background:yellow'>$lost</td>
						<td>$win_forfiet</td>
						<td>$lost_forfiet</td>
						<td>$bye_matches</td>
						<td>$np</td>
						<td style='background:red'>$tot_matches</td>
						<td style='background:gray'>$valid_matches</td>
						<td>$user_wp</td>
						<td>$opp_wp</td>
						<td style='background:skyblue'>$user_avg_wp</td>";
					echo "</tr>";*/
					//}
			

				}   // End of sports for loop


			}		// End of the Players table for loop
			//echo "</table>";

			echo "Updation Done!";
		}
	
	public function add_new_sport_a2m(){

			$get_users = $this->test_model->get_users();

			$user_id = "";
			foreach($get_users as $user){

				$user_id = $user->Users_ID;

				$ins_new_a2m = $this->test_model->ins_new_a2m($user_id,7,100);


			}
			
			echo "Done";

	}
	public function test_phpinfo()
	{
		echo phpinfo();
	}

	}
?>