<?php
$draw_type_arr = array('Single Elimination' => 'S.E','Round Robin' => 'R.R','Consolation' => 'C.D','Switch Doubles' => 'S.D');
?>
<script>
var tourn_format = "<?php echo $tour_details->tournament_format;?>"; 
var club_baseurl = "<?php echo $club_url; ?>";

$('#delete').click(function(e){
var bracket_ids=[];
var tourn_id=$("#tourn_id").val();
var tourn_format=$("#tourn_format").val();
var count=$('input:checkbox.delete_draws:checked').length;
    if(count==0){
       alert("Please select draws to delete!"); 
       return false;
    }
    $('input[name="tour_draws_delete"]:checked').each(function() {
     bracket_ids.push(this.value);
    });

var r = confirm("Once draws are deleted, can't revert back. Are you sure to delete?");

if(r == false){
e.preventDefault();
return false;	
}
else{
	/* Here Delete Draws code starts*/
	$.ajax({
		type:'POST',
		url:baseurl+'league/delete_draws/',
		data:{ tourn_id:tourn_id,tourn_format:tourn_format,bracket_ids:bracket_ids},
		success:function(res){
	     location.reload();
		}
	});
	/* Here Delete Draws code End*/
//return true;
}
});

$('#btn_publish_draws').click(function(e){
var bracket_ids=[];
var tourn_id=$("#tourn_id").val();
var count=$('input:checkbox.delete_draws:checked').length;
    if(count==0){
       alert("Please select draws to publish!"); 
       return false;
    }
    $('input[name="tour_draws_delete"]:checked').each(function() {
     bracket_ids.push(this.value);
    });

	/* Publish Draws code starts*/
	$.ajax({
		type:'POST',
		url:club_baseurl+'league/publish_draws/',
		data:{ tourn_id:tourn_id, bracket_ids:bracket_ids },
		success:function(res){
	     location.reload();
		}
	});
	/* Publish Draws code End*/
//return true;
});

$('#btn_unpublish_draws').click(function(e){
var bracket_ids=[];
var tourn_id=$("#tourn_id").val();
var count=$('input:checkbox.delete_draws:checked').length;
    if(count==0){
       alert("Please select draws to unpublish!"); 
       return false;
    }
    $('input[name="tour_draws_delete"]:checked').each(function() {
     bracket_ids.push(this.value);
    });

	/* UnPublish Draws code starts*/
	$.ajax({
		type:'POST',
		url:club_baseurl+'league/unpublish_draws/',
		data:{ tourn_id:tourn_id, bracket_ids:bracket_ids },
		success:function(res){
	     location.reload();
		}
	});
	/* UnPublish Draws code End*/
//return true;
});


$('#scorecard').click(function(e){
var bracket_ids=[];
var tourn_id=$("#tourn_id").val();
var tourn_format=$("#tourn_format").val();
var count=$('input:checkbox.delete_draws:checked').length;
    if(count==0){
       alert("Please select draws to Print!"); 
       return false;
    }
    $('input[name="tour_draws_delete"]:checked').each(function() {
     bracket_ids.push(this.value);
    });

	/* Here Delete Draws code starts*/
	$.ajax({
		type:'POST',
		url:baseurl+'league/scorecard4/',
		data:{ tourn_id:tourn_id,tourn_format:tourn_format,bracket_ids:bracket_ids},
		success:function(res){
	    // location.reload();
		var w = window.open('about:blank');
		w.document.open();
		w.document.write(res);
		w.document.close();
		}
	});
	/* Here Delete Draws code End*/
//return true;
});
</script>
<div id='vdrawres' class="table-responsive">
<?php

if($this->logged_user_role == 'Admin'){    /// tournament admin access links
?>
<!-- <a href="<?php //echo base_url();?>league/fixtures/<?php //echo $tour_details->tournament_ID;?>"  style='cursor:pointer;'>
<img width="45px" height="45px" src="<?php //echo base_url();?>icons/create_draw_ico.png" alt="Create" title="Create Draw" style="float:right" />
</a> -->
<?php
}
$is_have_cd = league::check_is_cd($tour_details->tournament_ID);

?>
<table id="Draws_table" class="tab-score">
<thead>
<tr class="top-scrore-table">
<?php if($this->logged_user_role == 'Admin'){ ?>
	<th><input type='checkbox' name='sel_all_draws' id='sel_all_draws' value='all' /></th>
<?php } ?>
	<th><b>Draw Title</b></th>
	<th>Type</th>
	<th>Winner</th>
	<th>Runner-up</th>
	<th>3rd Place</th>
	<th>4th Place</th>
	<?php if($is_have_cd){ ?>
	<th>Consolation<br />Winner</th>
	<?php } ?>
	<th>Date</th>
	<?php if($is_super_admin or $this->logged_user_role == "Admin" or $this->logged_user_role == "TeamCaptain"){ ?>
	<th></th>
	<?php } ?>
</tr>
</thead> 
<tbody>
<?php
$brackets = league::get_bracket_list($tour_details->tournament_ID);

if(count(array_filter($brackets)) > 0){ 
	//echo "<pre>"; print_r($brackets); exit;
foreach($brackets as $i => $bk){

	if($bk->Bracket_Type != 'Round Robin' and $bk->Bracket_Type != 'Switch Doubles'){
	$get_draw_winners = $this->model_league->get_tourn_winners($tour_details->tournament_ID, $bk->BracketID);
	$first_place = ''; $second_place = ''; $third_place = ''; $fourth_place = ''; $cons_winner = ''; 
	$cons_winner_partner = '';

	if($get_draw_winners){
		foreach($get_draw_winners as $res_arr){
			if($res_arr->Round_Num != -1){
				$p1		= $res_arr->Player1;
				$p1_p = $res_arr->Player1_Partner;
				$p2		= $res_arr->Player2;
				$p2_p = $res_arr->Player2_Partner;
				if($res_arr->Winner and $res_arr->Winner == $p1){
					$first_place = $p1;
					$first_place_partner = $p1_p;
					$second_place = $p2;
					$second_place_partner = $p2_p;
				}
				else if($res_arr->Winner and $res_arr->Winner == $p2){
					$first_place = $p2;
					$first_place_partner = $p2_p;
					$second_place = $p1;
					$second_place_partner = $p1_p;
				}
			}
			else if($res_arr->Round_Num == -1){
				$p1		= $res_arr->Player1;
				$p1_p = $res_arr->Player1_Partner;
				$p2		= $res_arr->Player2;
				$p2_p = $res_arr->Player2_Partner;
				if($res_arr->Winner and $res_arr->Winner == $p1){
					$third_place = $p1;
					$third_place_partner = $p1_p;
					$fourth_place = $p2;
					$fourth_place_partner = $p2_p;
				}
				else if($res_arr->Winner and $res_arr->Winner == $p2){
					$third_place = $p2;
					$third_place_partner = $p2_p;
					$fourth_place = $p1;
					$fourth_place_partner = $p1_p;
				}
			}
		}
	}
		if($bk->Bracket_Type == 'Consolation'){
				$get_cons_draw_winners = $this->model_league->get_tourn_cons_winners($tour_details->tournament_ID, $bk->BracketID);
				
				if($get_cons_draw_winners){
					foreach($get_cons_draw_winners as $res_arr){
						$p1		= $res_arr->Player1;
						$p1_p = $res_arr->Player1_Partner;
						$p2		= $res_arr->Player2;
						$p2_p = $res_arr->Player2_Partner;
						if($res_arr->Winner and $res_arr->Winner == $p1){
							$cons_winner = $p1;
							$cons_winner_partner = $p1_p;
						}
						else if($res_arr->Winner and $res_arr->Winner == $p2){
							$cons_winner = $p2;
							$cons_winner_partner = $p2_p;
						}
					}
				}
		}
	}
	else if($bk->Bracket_Type == 'Round Robin'){

				  /*$num_rounds = intval($bk->No_of_rounds-1);*/
				  $rr_tourn_matches = league::get_tourn_rr_matches($bk->BracketID);
				  $players = array();
		$first_place = ''; $second_place = ''; $third_place = ''; $fourth_place = ''; $cons_winner = ''; $cons_winner_partner = '';
		$grid_array = array();
				  //echo "<pre>"; print_r($rr_tourn_matches);
				  foreach($rr_tourn_matches as $i => $rtm){
$p1_sum = 0;
$p2_sum = 0;
$p1		= array();
$p2		= array();

	$p1p2_tot_score = 0;

					  $cur_player1 = $rtm->Player1;
					  
					  if($rtm->Player1_Partner != NULL and $rtm->Player1_Partner != 0){
						$cur_player1 = $rtm->Player1."-".$rtm->Player1_Partner;
					  }

$p1 = json_decode($rtm->Player1_Score);  
$cnt1 = count(array_filter($p1));

if($cnt1 > 0){
	for($i=0; $i<count(array_filter($p1)); $i++){
		$p1_sum = intval($p1_sum) + intval($p1[$i]);
	}
}

$p2 = json_decode($rtm->Player2_Score);  
$cnt2 = count(array_filter($p2));

if($cnt2 > 0){
	for($i=0; $i<count(array_filter($p2)); $i++){
		$p2_sum = intval($p2_sum) + intval($p2[$i]);
	}
}

					  if(!array_key_exists($cur_player1, $players)){			//	Player1 
						$players[$cur_player1]['points']  = ($rtm->Player1_points != NULL) ? $rtm->Player1_points : 0;
						$players[$cur_player1]['win_per'] = $p1_sum;
						$players[$cur_player1]['winper1'] = $p1_sum + $p2_sum;
					  }
					  else{
						$prev_points = $players[$cur_player1]['points'];
						$players[$cur_player1]['points']  = ($rtm->Player1_points != NULL) ? ($prev_points + $rtm->Player1_points) : $prev_points;
						$players[$cur_player1]['win_per'] += $p1_sum;
						$players[$cur_player1]['winper1'] += $p1_sum+$p2_sum;

						$players[$cur_player1]['winper2']  = number_format(($players[$cur_player1]['win_per'] / $players[$cur_player1]['winper1']) * 100, 2);
					  }


					  $cur_player2 = $rtm->Player2;
					  if($rtm->Player2_Partner != NULL and $rtm->Player2_Partner != 0){
						$cur_player2 = $rtm->Player2."-".$rtm->Player2_Partner;
					  }

					  if(!array_key_exists($cur_player2, $players)){			//	Player2 
						$players[$cur_player2]['points'] = ($rtm->Player2_points != NULL) ? $rtm->Player2_points : 0;
						$players[$cur_player2]['win_per']   = $p2_sum;
						$players[$cur_player2]['winper1']	  = $p1_sum + $p2_sum;
					  }
					  else{
						$prev_points = $players[$cur_player2]['points'];
						$players[$cur_player2]['points'] = ($rtm->Player2_points != NULL) ? ($prev_points + $rtm->Player2_points) : $prev_points;
						$players[$cur_player2]['win_per']  += $p2_sum;
						$players[$cur_player2]['winper1']  += $p1_sum+$p2_sum;

						$players[$cur_player2]['winper2']  = number_format(($players[$cur_player2]['win_per'] / $players[$cur_player2]['winper1']) * 100, 2);


					  }



// grid array

$grid_array[$rr_tourn_matches[$i]->Player1]['opponents'][$rr_tourn_matches[$i]->Player2]['sets']   = $p1_set_win.'-'.$p2_set_win;
$grid_array[$rr_tourn_matches[$i]->Player1]['opponents'][$rr_tourn_matches[$i]->Player2]['result'] = $p1_result;
$grid_array[$rr_tourn_matches[$i]->Player1]['player_name']  = $player1['Firstname']." ".$player1['Lastname'];

if($rr_tourn_matches[$i]->Player1_Partner){
$grid_array[$rr_tourn_matches[$i]->Player1]['player_name']  = $player1['Firstname'][0].".".$player1['Lastname'];
$grid_array[$rr_tourn_matches[$i]->Player1]['partner']	  = $rr_tourn_matches[$i]->Player1_Partner;
$grid_array[$rr_tourn_matches[$i]->Player1]['partner_name'] =  "; ".$player1_partner['Firstname'][0].".".$player1_partner['Lastname'];
}

$grid_array[$rr_tourn_matches[$i]->Player1]['won']  += $p1_won;
$grid_array[$rr_tourn_matches[$i]->Player1]['lost'] += $p1_lost;
$grid_array[$rr_tourn_matches[$i]->Player1]['points'] += $rr_tourn_matches[$i]->Player1_points;

$grid_array[$rr_tourn_matches[$i]->Player2]['opponents'][$rr_tourn_matches[$i]->Player1]['sets']   = $p2_set_win.'-'.$p1_set_win;
$grid_array[$rr_tourn_matches[$i]->Player2]['opponents'][$rr_tourn_matches[$i]->Player1]['result'] = $p2_result;
$grid_array[$rr_tourn_matches[$i]->Player2]['player_name']  = $player2['Firstname']." ".$player2['Lastname'];

if($rr_tourn_matches[$i]->Player2_Partner){
$grid_array[$rr_tourn_matches[$i]->Player2]['player_name']  = $player2['Firstname'][0].".".$player2['Lastname'];
$grid_array[$rr_tourn_matches[$i]->Player2]['partner']	  = $rr_tourn_matches[$i]->Player2_Partner;
$grid_array[$rr_tourn_matches[$i]->Player2]['partner_name'] =  "; ".$player2_partner['Firstname'][0].".".$player2_partner['Lastname'];
}

$grid_array[$rr_tourn_matches[$i]->Player2]['won']  += $p2_won;
$grid_array[$rr_tourn_matches[$i]->Player2]['lost'] += $p2_lost;
$grid_array[$rr_tourn_matches[$i]->Player2]['points'] += $rr_tourn_matches[$i]->Player2_points;

// grid array

				  }

			foreach($players as $pl => $x){
				$cnt = 0;
				foreach($players as $pl2 => $x2){
					if($x['points'] == $x2['points'])
						$cnt++;
				}
				$points_count_arr[$x['points']] = $cnt;
			}

			//if($this->logged_user == 240 and $bk->BracketID == 1195){
			//	echo "<pre>"; print_r($points_count_arr);
			//}
						//arsort($players);
				//$sort_func = uasort($players, array('league','compareOrder'));
				$sort_func = uasort($players, array('league','compareOrder4'));
				//if($this->logged_user == 240 and $bk->BracketID == 1793){
				//echo "<pre> "; print_r($players);  echo "______";
				//}

// ----------------------------------
$players_sort = '';
$keys_arr = '';
$players_sort = $players;
$keys_arr  = array_keys($players_sort); 


foreach($players_sort as $player => $tot_score){

	if($players_sort[$temp]['points'] == $tot_score['points']){
		//$last_player	 = str_replace('-', '', $temp);
		//$cur_player	 = str_replace('-', '', $player);
		$last_player	 = explode('-', $temp);
		$cur_player	 = explode('-', $player);

		if($grid_array[$cur_player[0]]['opponents'][$last_player[0]]['result'] == 'W'){
			$key_temp   = array_search($temp, $keys_arr);
			$key_player = array_search($player, $keys_arr);
			$keys_arr[$key_temp]   = $player;
			$keys_arr[$key_player] = $temp;
			$temp = $temp;
		}
		else{
		$temp = $player;
		}
	}
	else{
		$temp = $player;
	}

}


$temp_players_sort = '';
foreach($keys_arr as $player){
	$temp_players_sort[$player] = $players_sort[$player];
	$get_players = explode("-", $player);
	$temp_grid_array[$get_players[0]] = $grid_array[$get_players[0]];
}

$players			= $temp_players_sort;
$grid_array		= $temp_grid_array;
				if($this->logged_user == 240){
				//echo "<pre> "; print_r($players);  echo "______";
				}
//----------------------------------------

				$i = 1;
				foreach($players as $pl => $x){
					$ply = explode('-', $pl);
					if($i == 1 and $x['points'] > 0){
						$first_place = $ply[0];
						$first_place_partner = $ply[1];
					}
					if($i == 2 and $x['points'] > 0){
						$second_place = $ply[0];
						$second_place_partner = $ply[1];
					}
					if($i == 3 and $x['points'] > 0){
						$third_place = $ply[0];
						$third_place_partner = $ply[1];
					}
					if($i == 4 and $x['points'] > 0){
						$fourth_place = $ply[0];
						$fourth_place_partner = $ply[1];
					}
					$i++;
				}
	}
	else if($bk->Bracket_Type == 'Switch Doubles'){
				  /*$num_rounds = intval($bk->No_of_rounds-1);*/
				  $sd_tourn_matches = league::get_tourn_rr_matches($bk->BracketID);
				  $players = array();
				  $first_place = ''; $second_place = ''; $third_place = ''; $fourth_place = ''; 

				  //echo "<pre>"; print_r($sd_tourn_matches);
				  $is_score_added = 0;

				  foreach($sd_tourn_matches as $i => $rtm){
					$p1_sum = 0;
					$p2_sum = 0;
					$p1		= array();
					$p2		= array();

					$p1p2_tot_score = 0;
					
					if($rtm->Winner != NULL and $rtm->Winner != '' and $rtm->Winner != 0){
						$is_score_added = 1;
					}

					$p1 = json_decode($rtm->Player1_Score);  
					$cnt1 = count(array_filter($p1));

					if($cnt1 > 0){
						for($i=0; $i<count(array_filter($p1)); $i++){
							$p1_sum = intval($p1_sum) + intval($p1[$i]);
						}
					}

					$p2 = json_decode($rtm->Player2_Score);  
					$cnt2 = count(array_filter($p2));

					if($cnt2 > 0){
						for($i=0; $i<count(array_filter($p2)); $i++){
							$p2_sum = intval($p2_sum) + intval($p2[$i]);
						}
					}

					  $cur_player1			= $rtm->Player1;
					  $cur_player1_part  = $rtm->Player1_Partner;
					  
					  if(!array_key_exists($cur_player1, $players)){			//	Player1 
						$players[$cur_player1]['points']  = ($rtm->Player1_points != NULL) ? $rtm->Player1_points : 0;
						$players[$cur_player1]['win_per']   = $p1_sum;
						$players[$cur_player1]['winper1'] = $p1_sum + $p2_sum;
					  }
					  else{
						$prev_points = $players[$cur_player1]['points'];
						$players[$cur_player1]['points']  = ($rtm->Player1_points != NULL) ? ($prev_points + $rtm->Player1_points) : $prev_points;
						$players[$cur_player1]['win_per'] += $p1_sum;
						$players[$cur_player1]['winper1'] += $p1_sum+$p2_sum;

						$players[$cur_player1]['winper2']  = number_format(($players[$cur_player1]['win_per'] / $players[$cur_player1]['winper1']) * 100, 2);
					  }

					  if(!array_key_exists($cur_player1_part, $players)){			//	Player1 Partner
						$players[$cur_player1_part]['points']  = ($rtm->Player1_points != NULL) ? $rtm->Player1_points : 0;
						$players[$cur_player1_part]['win_per'] = $p1_sum;
						$players[$cur_player1_part]['winper1'] = $p1_sum + $p2_sum;
					  }
					  else{
						$prev_points = $players[$cur_player1_part]['points'];
						$players[$cur_player1_part]['points']  = ($rtm->Player1_points != NULL) ? ($prev_points + $rtm->Player1_points) : $prev_points;
						$players[$cur_player1_part]['win_per']  += $p1_sum;
						$players[$cur_player1_part]['winper1']  += $p1_sum+$p2_sum;

						$players[$cur_player1_part]['winper2']  = number_format(($players[$cur_player1_part]['win_per'] / $players[$cur_player1_part]['winper1']) * 100, 2);				
					}

					  $cur_player2			= $rtm->Player2;
					  $cur_player2_part  = $rtm->Player2_Partner;
					 
					  if(!array_key_exists($cur_player2, $players)){			//	Player2 
						$players[$cur_player2]['points'] = ($rtm->Player2_points != NULL) ? $rtm->Player2_points : 0;
						$players[$cur_player2]['win_per']   = $p2_sum;
						$players[$cur_player2]['winper1']	  = $p1_sum + $p2_sum;
					  }
					  else{
						$prev_points = $players[$cur_player2]['points'];
						$players[$cur_player2]['points'] = ($rtm->Player2_points != NULL) ? ($prev_points + $rtm->Player2_points) : $prev_points;
						$players[$cur_player2]['win_per']   += $p2_sum;
						$players[$cur_player2]['winper1']  += $p1_sum+$p2_sum;

						$players[$cur_player2]['winper2']  = number_format(($players[$cur_player2]['win_per'] / $players[$cur_player2]['winper1']) * 100, 2);
					  }

					  if(!array_key_exists($cur_player2_part, $players)){			//	Player2 Partner
						$players[$cur_player2_part]['points'] = ($rtm->Player2_points != NULL) ? $rtm->Player2_points : 0;
						$players[$cur_player2_part]['win_per']   = $p2_sum;
						$players[$cur_player2_part]['winper1']	  = $p1_sum + $p2_sum;
					  }
					  else{
						$prev_points = $players[$cur_player2_part]['points'];
						$players[$cur_player2_part]['points'] = ($rtm->Player2_points != NULL) ? ($prev_points + $rtm->Player2_points) : $prev_points;
						$players[$cur_player2_part]['win_per']  += $p2_sum;
						$players[$cur_player2_part]['winper1']  += $p1_sum+$p2_sum;

						$players[$cur_player2_part]['winper2']  = number_format(($players[$cur_player2_part]['win_per'] / $players[$cur_player2_part]['winper1']) * 100, 2);
					  }
				  }

						//arsort($players);
				//$sort_func = uasort($players, array('league','compareOrder'));
				$sort_func = uasort($players, array('league','compareOrder4'));
				//if($this->logged_user == 240){
				//echo "<pre> "; print_r($players);  echo "______";
				//}
				$i = 1;
				foreach($players as $pl => $x){
					$ply = explode('-', $pl);
					if($i == 1 and $x['points'] > 0){
						$first_place = $ply[0];
						$first_place_partner = $ply[1];
					}
					if($i == 2 and $x['points'] > 0){
						$second_place = $ply[0];
						$second_place_partner = $ply[1];
					}
					//if($i == 3 and $x['points'] > 0){
					if($i == 3 and $is_score_added){
						$third_place = $ply[0];
						$third_place_partner = $ply[1];
					}
					//if($i == 4 and $x['points'] > 0){
					if($i == 4 and $is_score_added){
						$fourth_place = $ply[0];
						$fourth_place_partner = $ply[1];
					}
					$i++;
				}
	}

	if(($this->is_super_admin or $this->logged_user_role == "Admin") or $bk->is_Publish){
?>
<tr id="tr_<?=$bk->BracketID;?>">
<?php
$users_id = $this->session->userdata('users_id');
if($this->logged_user_role == 'Admin'){   /// tournament admin access links
	echo '<td><input type="checkbox" name="tour_draws_delete" id="delete_draws_'.$bk->BracketID.'" class="delete_draws" value="'.$bk->BracketID.'" /></td>';
}
?>
<td style="cursor: pointer;" class="show_draws" id="<?php echo $bk->BracketID;?>"><font style="font-size:13px;" color="#03508c"><b><?php echo $bk->Draw_Title; ?></font></b>&nbsp;&nbsp;
<?php 
if($this->logged_user_role == 'Admin'){
echo ($bk->is_Publish == 1) ? "Published" : "Unpublished";
}
?></td>
<td title='<?php echo $bk->Bracket_Type; ?>'><b><?php echo $draw_type_arr[$bk->Bracket_Type]; ?></b></td>
<?php	if($tour_details->tournament_format == 'Teams' or $tour_details->tournament_format == 'TeamSport'){ ?>
<td><b><?php if($first_place) echo league::get_team_name($first_place);  else echo "-";?></b></td>
<td><b><?php if($second_place) echo league::get_team_name($second_place);  else echo "-";?></b></td>
<td><b><?php if($third_place) echo league::get_team_name($third_place);  else echo "-"; ?></b></td>
<td><b><?php if($fourth_place) echo league::get_team_name($fourth_place);  else echo "-"; ?></b></td>
<?php } else { ?>
<td><b><?php if($first_place) echo league::get_player($first_place, $first_place_partner);  else echo "-";?></b></td>
<td><b><?php if($second_place) echo league::get_player($second_place, $second_place_partner);  else echo "-";?></b></td>
<td><b><?php if($third_place) echo league::get_player($third_place, $third_place_partner);  else echo "-"; ?></b></td>
<td><b><?php if($fourth_place) echo league::get_player($fourth_place, $fourth_place_partner);  else echo "-"; ?></b></td>
<?php if($is_have_cd){ ?>
<td><b><?php if($cons_winner) echo league::get_player($cons_winner, $cons_winner_partner);  else echo "-"; ?></b></td>
<?php } ?>

<?php } ?>

<!-- <td><b><?php //echo date('m-d-Y',strtotime($bk->Created_on)); ?></b></td> -->
<td><?php
if($bk->OCCR_ID) {
	$ocr_info		= league :: get_occr_info($bk->OCCR_ID);
	$dis_date		= date('M d, h:i A', strtotime($ocr_info['Game_Date'])); 
	$sort_date	= date('Ymd', strtotime($ocr_info['Game_Date'])); 
}
else {
	$get_first_match = league::get_bracket_firstmatch($bk->BracketID);
	//echo ""; print_r($get_first_match); exit;
	if($get_first_match['Match_DueDate']) {
		$dis_date		= date('M d, h:i A', strtotime($get_first_match['Match_DueDate'])); 
		$sort_date	= date('Ymd', strtotime($get_first_match['Match_DueDate'])); 
	}
	else {
		$dis_date		= date('M d, h:i A', strtotime($tour_details->StartDate)); 
		$sort_date	= date('Ymd', strtotime($tour_details->StartDate)); 
	}
}
?><span style='display:none;'><?=$sort_date;?></span><b><?=$dis_date;?></b></td>
<?php 
if($this->is_super_admin or $this->logged_user_role == "Admin" or $this->logged_user_role == "TeamCaptain"){  
if($bk->Bracket_Type == "Round Robin" or $bk->Bracket_Type == "Switch Doubles") {
	if($tour_details->tournament_format != "Teams"){
?>
<td>
<input style="padding: 5px 1px 5px 1px;" type="button" name="ScoreSheet_<?=$bk->BracketID;?>" id="<?=$bk->BracketID;?>" class="league-form-submit1 br_scoreSheet" value="ScoreSheet" />
</td>
<?php 
	}
	else if($tour_details->tournament_format == "Teams"){
?>
<td>
<input style="padding: 5px 1px 5px 1px;" type="button" name="Team_ScoreSheet_<?=$bk->BracketID;?>" id="<?=$bk->BracketID;?>" class="league-form-submit1 br_team_scoreSheet" value="ScoreSheet" onclick='myWin_scorecard(<?=$tour_details->tournament_ID;?>)' />

</td>
<?php
	}
}
else{
?>
<td>&nbsp;</td>
<?php
}
?>
<!--
<td>
<?php
//$btn_value = ($bk->Bracket_Type == 'Challenge Ladder') ? 'Show Ladder' : 'Show Draw';
?>
<input type="button" class="show_draws league-form-submit1" name="tour_draw_show<?php //echo $bk->BracketID;?>" id='<?php //echo $bk->BracketID;?>' value="<?=$btn_value;?>" />
</td> -->
</tr>
<?php
}

}

}


}
else{
	echo "<tr>";
	if($this->logged_user_role == 'Admin'){ 
	echo"<td>No Draws are available</td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td>";
	}
	else{
	echo "<td>No Draws are available</td><td></td><td></td><td></td><td></td><td></td><td></td><td></td>";
	}
	echo "</tr>";
}

?>
</tbody>
</table>
<?php
echo "<br>";

if(count(array_filter($brackets)) > 0){  

	if($this->logged_user_role == 'Admin'){   /// tournament admin access links
		echo '<input type="button" name="tour_draws_delete_button" id="delete" class="league-form-submit1" value="Delete Draws">';
		if($tour_details->tournament_format == 'Individual'){
		echo '&nbsp;&nbsp;<input type="button" name="tour_draws_score_card" id="scorecard" class="league-form-submit1" value="Print ScoreCard">';
		}

		echo '<input type="hidden" name="tourn_format" id="tourn_format" value="'.$tour_details->tournament_format.'">';
		//if($this->logged_user ==240){
		//echo '&nbsp;&nbsp;<input type="button" name="btn_assign_courts" id="btn_assign_courts" class="league-form-submit1" value="Assign Courts">';
		//}
		echo '&nbsp;&nbsp;<input type="button" name="btn_publish_draws" id="btn_publish_draws" class="league-form-submit1" value=" Publish ">';
		echo '&nbsp;&nbsp;<input type="button" name="btn_unpublish_draws" id="btn_unpublish_draws" class="league-form-submit1" value=" UnPublish ">';
		//if($this->logged_user == 240){
		echo '&nbsp;&nbsp;<input type="button" name="btn_court_assgn" id="btn_court_assgn" class="league-form-submit1" value=" Show Court Assignments ">';		
		echo '&nbsp;&nbsp;<input type="button" name="btn_hide_court_assgn" id="btn_hide_court_assgn" class="league-form-submit1" value=" Hide Court Assignments " style="display:none;">';
		//}

?>
		<div id='asg_courts_ip' style='display:none;'>
			<div class='col-md-12'>
				No. of Courts:&nbsp;<input type="number" name="num_courts" id="num_courts" value="" min='1' max='99' />
			</div>
			<div class='col-md-6'>
				Match Duration&nbsp;<input type="number" name="num_courts" id="num_courts" value="" min='1' max='99' />
			</div>
			<div class='col-md-6'>
				Break Time&nbsp;<input type="number" name="num_courts" id="num_courts" value="" min='1' max='99' />
			</div>
			<div class='col-md-12'>
				<input type="button" name="btn_calc_timings" id="btn_calc_timings" class="league-form-submit1" value="Calculate Match Timings" />
				<input type="button" name="cancel_assign_courts" id="cancel_assign_courts" class="league-form-submit1" value="Cancel" />
			</div>
		</div>
<?php

	}
}
?>
</div>


<!-- <div id="show_vdrawres" style='display:none; text-align:right'>
<?php //echo '<input type="button" name="vdrawres" id="vdrawres" class="league-form-submit1 close_div" value="Close">'; ?>
</div> -->
<div id="showdraw"></div>
<script>
$('.show_draws').click(function(){

$bracket_id = $(this).attr('id');
var tourn_format = "<?php echo $tour_details->tournament_format;?>"; 
var club_baseurl = "<?php echo $club_url; ?>";
var usr = "<?php echo $this->logged_user; ?>";

$('.tab-score tr').css('background-color','');
$('#tr_'+$bracket_id).css('background-color','#81a32b');
$('#'+$bracket_id).val('Please wait....');

	$.ajax({
	type:'POST',
	url:baseurl+'league/ShowBracket/'+$bracket_id,
	data:{bracket_id:$bracket_id,tformat:tourn_format,club_url:club_baseurl,usr:usr},
	success:function(res){
		$('#'+$bracket_id).val('Show Draw');
		$("#showdraw").html(res);

			$('html, body').animate({
			scrollTop: ($('#showdraw').offset().top)
			},500);
	}
	});
});

$('#btn_hide_court_assgn').click(function(){
$("#btn_court_assgn").show();
$(this).hide();
$("#showdraw").html('');
});

$('#btn_court_assgn').click(function(){
var tourn_id = $("#tourn_id").val();

	$.ajax({
	type:'POST',
	url:baseurl+'league/getCourtInfo',
	data:{tourn_id:tourn_id},
	success:function(res){
		//$('#'+$tourn_id).val('Show Draw');
		$("#showdraw").html(res);
		$("#btn_court_assgn").hide();
		$("#btn_hide_court_assgn").show();

			$('html, body').animate({
			scrollTop: ($('#showdraw').offset().top)
			},500);
	}
	});
});
</script>

<?php
$sport_det = league::get_sport($tour_details->SportsType);

if($sport_det['SportFormat'] != "TeamSport" and $tour_details->tournament_format != "Teams"){
?>
<script>

function load_cl_standings(){

	if( !$.trim( $('#show_cl_standings').html() ).length ){
		var tourn_id = $("#tourn_id").val();
		$("#show_cl_standings").html("Please wait, standings are loading/refreshing ......");
		$.ajax({
			type:'POST',
			url:baseurl+'league/get_cl_standings/'+tourn_id,
			data:{club_url:club_baseurl},
			success:function(res){
				$("#show_cl_standings").html(res);

					/*$('html, body').animate({
					scrollTop: ($('#showdraw').offset().top)
					},500);*/
			}
		});
	}
}

if( !$.trim( $('#show_cl_standings').html() ).length ){
	load_cl_standings(); 
}
/*setInterval(function(){
    load_cl_standings() 
}, 30000);*/

</script>
<br /><br />

<?php
}
else if($tour_details->tournament_format == "Teams"){
?>
<script>
function load_cl_team_standings(){
	if( !$.trim( $('#show_cl_standings').html() ).length ){
		var tourn_id = $("#tourn_id").val();
		$("#show_cl_standings").html("Please wait, standings are loading/refreshing ......");

		$.ajax({
			type:'POST',
			url:baseurl+'league/get_cl_team_standings/'+tourn_id,
			success:function(res){
				$("#show_cl_standings").html(res);

					/*$('html, body').animate({
					scrollTop: ($('#showdraw').offset().top)
					},500);*/
			}
		});
	}
}

if( !$.trim( $('#show_cl_standings').html() ).length ){
	load_cl_team_standings();
}
/*setInterval(function(){
    load_cl_standings() 
}, 30000);*/

</script>
<br /><br />


<?php
}
?>
<script>
$(document).ready(function(){
	$('.br_scoreSheet').click(function(){
		var value		 = $(this).attr('id');
		var bracket_ids  = value;
		var tourn_id	 = $("#tourn_id").val();
		var tourn_format = $("#tourn_format").val();

			$.ajax({
				type:'POST',
				url:club_baseurl+'league/printScoreSheet/',
				data:{tourn_id:tourn_id,tourn_format:tourn_format,bracket_ids:bracket_ids},
				success:function(res){
				var w = window.open('about:blank');
					w.document.open();
					w.document.write(res);
					w.document.close();
				}
			});
	});
});
</script>
<script> 
	//$(document).ready(function(){
		$('#Draws_table').DataTable({
				searching: false, 
				paging: false, 
				lengthMenu: false,
				//sDom	  : '<"clear">t<"H"p><"F"p>'
		});
	//});
</script>
<div style="padding-top:20px;"><b>Tournament/League Standings</b></div>
<div id="show_cl_standings"></div>