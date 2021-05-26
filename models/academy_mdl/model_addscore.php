
<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

	class model_addscore extends CI_Model {
		
		public function __construct()
		{
			parent:: __construct();
			$this->load->database();
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

		public function create_new_match_singles($data)
		{
			 $this->db->insert('GeneralMatch', $data);
		     $gen_match_id = $this->db->insert_id(); 


	 /* Match score and points processing section */

		$player1_user = $data['users_id'];
		$opp_user = $this->input->post('player2_user_id');

		$match_sport = $data['Sports'];

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

/*--------------- Sets score calculation start ----------------------------*/
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
				//if(++$i!=count(array_filter($this->input->post('player1'))) and $set_score!="")
				//{
				//	$player1_score .= ",";
				//}

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

		//	$player1_user = $match_init_user['users_id'];
		//	$opp_user = $this->input->post('opp_user');
		//	$match_sport = $match_init_user['Sports'];

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
						

		/* --------------------- */

				$data = array(
				'GeneralMatch_ID' => $gen_match_id,
				'Opponent' => $opp_user,
				'Play_Title' => $this->input->post('match_title'),
				'Reg_Date' =>  date("Y-m-d", strtotime($this->input->post('match_date'))),
				'Play_Date' =>  date("Y-m-d", strtotime($this->input->post('match_date'))),
				'Player1_Score' => $player1_score,
				'Opponent_Score' => $player2_score,
				'Player1_Win_Percent' => round($win_per_p1, 2),
				'Player2_Win_Percent' => round($win_per_p2, 2),
				'Winner' => $winner);
			
			$ins_query = $this->db->insert('IndividualPlay', $data);

			return $ins_query;
		 
			 /* Match score and points processing section */

		}

/* ------------------------------------------------------------------------------------------------------------------------------------------- */
/* ------------------------------------------------------------------------------------------------------------------------------------------- */
/* ------------------------------------------------------------------------------------------------------------------------------------------- */
/* ------------------------------------------------------------------------------------------------------------------------------------------- */

		public function create_new_match_doubles($data)
		{
			 $this->db->insert('GeneralMatch', $data);
		     $gen_match_id = $this->db->insert_id(); 


	 /* Match score and points processing section */

		$player1_user = $data['users_id'];
		$player1_partner = $this->input->post('player1_partner_id');

		$opp_user = $this->input->post('player2_user_id');
		$player2_partner = $this->input->post('player2_user_partner_id');

		$match_sport = $data['Sports'];

			$data = array('SportsType_ID'=>$match_sport, 'Users_ID'=>$player1_user);

			$get_a2mscore1 = $this->db->get_where('A2MScore',$data);
			$p1_a2mscore = $get_a2mscore1->row_array();

			$data = array('SportsType_ID'=>$match_sport, 'Users_ID'=>$player1_partner);

			$get_a2mscore1 = $this->db->get_where('A2MScore',$data);
			$p1_part_a2mscore = $get_a2mscore1->row_array();


			$data = array('SportsType_ID'=>$match_sport, 'Users_ID'=>$opp_user);
			$get_a2mscore2 = $this->db->get_where('A2MScore',$data);
			$p2_part_a2mscore = $get_a2mscore2->row_array();

			$data = array('SportsType_ID'=>$match_sport, 'Users_ID'=>$player2_partner);
			$get_a2mscore2 = $this->db->get_where('A2MScore',$data);
			$p2_part_a2mscore = $get_a2mscore2->row_array();


		$player1_a2mscore = $p1_a2mscore['A2MScore'];
		$player1_part_a2mscore = $p1_part_a2mscore['A2MScore'];

		$player2_a2mscore = $p2_a2mscore['A2MScore'];
		$player2_part_a2mscore = $p2_part_a2mscore['A2MScore'];

		$score_diff = abs($player1_a2mscore - $player2_a2mscore);

		($player1_a2mscore >= $player2_a2mscore) ? $max_a2mscore_user = $player1_user : $max_a2mscore_user = $opp_user;

/*--------------- Sets score calculation start ----------------------------*/
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
				//if(++$i!=count(array_filter($this->input->post('player1'))) and $set_score!="")
				//{
				//	$player1_score .= ",";
				//}

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
		$winner			= $player1_user;
		$winner_part	= $player1_partner;

		$loser			= $opp_user;
		$loser_part		= $player2_partner;
	}
	else{
		$winner			= $opp_user;
		$winner_part	= $player2_partner;

		$loser			= $player1_user;
		$loser_part		= $player1_partner;
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

				$data = array ('A2MScore' => $p1_a2mscore_updated);
				
				$this->db->where('Users_ID', $player1_partner);
				$this->db->where('SportsType_ID', $match_sport);

			$a2mscore_upd_qry2 = $this->db->update('A2MScore', $data);

				$data = array ('A2MScore' => $p2_a2mscore_updated);
				
				$this->db->where('Users_ID', $opp_user);
				$this->db->where('SportsType_ID', $match_sport);

			$a2mscore_upd_qry3 = $this->db->update('A2MScore', $data);

				$data = array ('A2MScore' => $p2_a2mscore_updated);
				
				$this->db->where('Users_ID', $player2_partner);
				$this->db->where('SportsType_ID', $match_sport);

			$a2mscore_upd_qry4 = $this->db->update('A2MScore', $data);

		/* ------------------------------------------------------------- */


		/* --------------------Player Number of Matches Update --------------------*/

			$data = array('Users_ID'=>$player1_user,'Sport' =>$match_sport);			//	Player1 
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
			

			$data = array('Users_ID'=>$player1_partner,'Sport' =>$match_sport);			//	Player1 Partner
			$num = $this->db->get_where('Player_Matches_Count',$data);
			$c =  $num->row_array();

			if(empty($c))
			{
				
				if($winner == $player1_user) { $won = 1; $lost = 0; }  
				else { $won = 0; $lost = 1;  }

				$data = array('Num_Matches' => 1, 'Users_ID' => $player1_partner,'Sport' => $match_sport,
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

				$this->db->where('Users_ID', $player1_partner);
				$this->db->where('Sport', $match_sport);
				$p1_update = $this->db->update('Player_Matches_Count' ,$data);
			}




			$data = array('Users_ID'=>$opp_user,'Sport' =>$match_sport);			//	Player2
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
						
			$data = array('Users_ID'=>$player2_partner,'Sport' =>$match_sport);			//	Player2 Partner
			$num1 = $this->db->get_where('Player_Matches_Count',$data);
			$c1 =  $num1->row_array();

			if(empty($c1))
			{
				if($winner == $opp_user) { $won = 1; $lost = 0; }  
				else { $won = 0; $lost = 1;  }

				$data = array('Num_Matches' => 1, 'Users_ID' => $player2_partner, 'Sport' => $match_sport,
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
				
				$this->db->where('Users_ID', $player2_partner);
				$this->db->where('Sport', $match_sport);
				$p1_update = $this->db->update('Player_Matches_Count' ,$data);
			}
						

		/* --------------------- */

				$data = array(
				'GeneralMatch_ID' => $gen_match_id,
				'Opponent' => $opp_user,
				'Play_Title' => $this->input->post('match_title'),
				'Reg_Date' =>  date("Y-m-d", strtotime($this->input->post('match_date'))),
				'Play_Date' =>  date("Y-m-d", strtotime($this->input->post('match_date'))),
				'Player1_Score' => $player1_score,
				'Opponent_Score' => $player2_score,
				'Player1_Win_Percent' => round($win_per_p1, 2),
				'Player2_Win_Percent' => round($win_per_p2, 2),
				'Player2_Partner' => $player2_partner,
				'Winner' => $winner);
			
			$ins_query = $this->db->insert('IndividualPlay', $data);

			return $ins_query;
		 
			 /* Match score and points processing section */

		}


		public function get_user_tournaments()
		{
			$user_id = $this->session->userdata('users_id');
			$data = array('Users_ID' => $user_id);
			$query = $this->db->get_where('RegisterTournament',$data);
			return $query->result();
		
		}

		public function get_num_matches($bracket_id, $round)
		{

			$data = array('BracketID' => $bracket_id, 'Round_Num' => $round);

			$qry_check = $this->db->query("SELECT COUNT(Tourn_match_id) as count FROM Tournament_Matches WHERE BracketID = $bracket_id AND Round_Num = $round AND Draw_Type = 'Main'");

			return $qry_check->row_array();

		}

		public function get_tournment_title($tourn_id)
		{
			$data = array('tournament_ID' => $tourn_id);
			$query = $this->db->get_where('tournament',$data);
			return $query->row_array();
		}

		public function get_brackets($bracket_id)   // Get Brackets to show matches in AddScore (TopMenu)
		{
			
			$user_id = $this->session->userdata('users_id');

			//$qry_check = $this->db->query("SELECT * FROM Tournament_Matches WHERE (Player1 = $user_id OR Player2 = $user_id OR Player1_Partner = $user_id OR Player2_Partner = $user_id ) AND BracketID = $bracket_id ");
			
			$qry_check = $this->db->query("SELECT * FROM Tournament_Matches WHERE (Player1 = $user_id OR Player2 = $user_id OR Player1_Partner = $user_id OR Player2_Partner = $user_id ) AND BracketID = $bracket_id AND Winner = 0");

			return $qry_check->result();
		}

		public function get_bracket_list($tourn_id)
		{
			$data = array('Tourn_ID' => $tourn_id);
			$query = $this->db->get_where('Brackets',$data);
			return $query->result();
		}

		public function get_bracket_details($tourn_id)
		{
			$data = array('Tourn_ID' => $tourn_id);
			$query = $this->db->get_where('Tournament_Matches',$data);
			return $query->result();
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

	}
