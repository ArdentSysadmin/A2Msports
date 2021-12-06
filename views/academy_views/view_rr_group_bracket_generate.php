<link href="<?php echo base_url();?>css/foundation-datepicker.css" rel="stylesheet">
<script src="<?php echo base_url();?>js/foundation-datepicker.js"></script>


<section id="login" class="container secondary-page">
<!-- LOGIN BOX -->
<div class="top-score-title right-score col-md-12">
<h3>Round Robin Matches</h3>
<div class="col-md-12">

<form method="post" id="myform" action='<?php echo $this->club_form_url; ?>league/bracket_save' class="col-md-12 login-page" style='background-color:#fff'> 

<?php
$pick_time = 1;
	$n = 1;
	//echo date('Y-m-d H:i', '1615744800');
	//echo "<pre>"; print_r($match_timings);

	if($this->input->post('br_game_day') != ''){
		$game_date = league::get_game_day($this->input->post('br_game_day'));
		$draw_title_date = date('M d, Y', strtotime($game_date));	
	}
	else{
		$draw_title_date =  date('M d, Y');	
	}

foreach($groups as $g => $group){
	$draw_title = $draw_title_date." - Group{$g}";
?>
<label>Group-<?=$g;?></label>&nbsp;&nbsp;<span id="title_error" style="color:red"></span>
<input class="form-control" type="text" name="draw_title[<?=$g;?>]" id="draw_title" placeholder='Draw Title'  value="<?=$draw_title;?>" required />

<?php
$robin			= $robins[$g];
$total_matches  = count($robin);

if($total_matches > 3){
	$num_rounds = ($total_matches % 2 == 0) ? ($total_matches / 2) : ($total_matches / 3);

	if($num_rounds > 10 and $num_rounds < 19){
	$num_rounds = ($total_matches % 4 == 0) ? ($total_matches / 4) : ($total_matches / 5);
	}
	else if($num_rounds > 18){
	$num_rounds = ($total_matches % 6 == 0) ? ($total_matches / 6) : ($total_matches / 7);
	}

	$per_round = $total_matches / $num_rounds;
}
else{
$per_round = 1;
$num_rounds = 3;
}


$round_num = 1;
$match_num = 1;
$p1		   = 0;

$per_round_count = 1;


/* *************** Assigning of Home Court Location functionality ******************* */
$player_match_loc = array();

$tour_type = $this->input->post('tour_type');

if($tour_type == 'Flexible League'){
for($k = 1; $k <= $rr_multi_rounds; $k++){
	if($k%2 == 1){
		$home = 'H'; $away = 'A';
	}
	else{
		$home = 'A'; $away = 'H';
	}

	foreach($group as $player){
		foreach($group as $opp){
			if($player != $opp){
				if(!$player_match_loc[$k][$opp][$player]){
				$player_match_loc[$k][$player][$opp] = $home;
				$player_match_loc[$k][$opp][$player] = $away;
				}

				if($rr_multi_rounds == 1){
				$temp = $home;
				$home = $away;
				$away = $temp;
				}
			}
		}
	}
}
}
/* *************** End of Assigning of Home Court Location functionality ******************* */


//print_r($player_match_loc);

$rr_matches_loc = array();

//$players = array();
$check_alternate_stat = array();
//print_r($home_loc_count);
//echo "<pre>";
//print_r($robin);
$rr_matches = array();
$exp_tot_games = (count($group)/2) * (count($group)-1);

foreach($robin as $rr)
{
/* --------Get individual player array-------- */

	$rr_p1 = explode('-',$rr[0]);
	$rr_p2 = explode('-',$rr[1]);

/* --------End of individual player array------ */

	$rr_matches[$round_num][$match_num][] = $rr[0];
	$rr_matches[$round_num][$match_num][] = $rr[1];

	if(!empty($player_match_loc)){

		$m = 1;
		if($match_num > $exp_tot_games){
			$m = 2;
		}

	$home_loc_player = ($player_match_loc[$m][$rr[0]][$rr[1]] == 'H') ? $rr[0] : $rr[1];

	$rr_matches_loc[$round_num][$match_num]['loc'] = $home_loc_player;
	}

	
	if($round_num != $num_rounds && $per_round == $per_round_count){
		$round_num++;
		$per_round_count = 1;
	}
	else{
		$per_round_count++;
	}

$match_num++;
}

/*echo "<pre>";
print_r($rr_matches_loc);*/
?>

<input type='hidden' name='rr_matches[<?=$g;?>]'	 id='rr_matches'	 value="<?php echo htmlentities(serialize($rr_matches)); ?>"	 />
<input type='hidden' name='rr_matches_loc[<?=$g;?>]' id='rr_matches_loc' value="<?php echo htmlentities(serialize($rr_matches_loc)); ?>" />
<div class='tab-content'>
<table class='tab-score'>
<?php

foreach($rr_matches as $i=>$rrm){
	
?>
<tr class='top-scrore-table'>
<td align='center' colspan='2'>Round <?=$i;?></td>
<td>
<div>
<input type="text" placeholder="Date" name="g<?=$g;?>_round_date<?php echo $i; ?>" id="g<?=$g;?>_round_date<?php echo $i; ?>" value="" />
<script>
var rid = "<?php echo $i; ?>";
var gid = "<?php echo $g; ?>";

  $('#g'+gid+'_round_date'+rid).fdatepicker({
		format: 'mm/dd/yyyy hh:ii',
		disableDblClickSelection: true,
		language: 'en',
		pickTime: true
	});
</script>
</div>
 </td>
<?php
if($tour_type == 'Flexible League'){
?>
<td>Home Location of</td>
<?php 
} ?>
</tr>

<?php
$head = 'Player';

if($tformat == 'Teams' or $tformat == 'TeamSport'){
$head = 'Team';
}
echo "<tr align='center'><td><b>Match Date</b></td><td><b>{$head} 1 </b></td><td><b>{$head} 2</b></td>";
if($tour_type == 'Flexible League'){ echo "<td></td>";  }
echo "</tr>";

 foreach($rr_matches[$i] as $j=>$match){
	$rr_p1 = explode('-',$rr_matches[$i][$j][0]);
	$rr_p2 = explode('-',$rr_matches[$i][$j][1]);

$match_dt_time = '';
$court_name = '';
if($match_timings[$n]){
//echo "<br>".$match_timings[$match_num][0] . " - " .date('m/d/Y H:i', (trim($match_timings[$match_num][2])));
$court_name = $match_timings[$pick_time][0];
$match_dt_time = date('m/d/Y H:i', (trim($match_timings[$pick_time][2])));
$pick_time++;
}

$mdate = "<input type='text' placeholder='Date' name='g{$g}_match_date{$j}' id='g{$g}_match_date{$j}' value='{$match_dt_time}' />";

?>
<input type="hidden" id="g<?=$g;?>_assg_court<?=$j;?>" name="g<?=$g;?>_assg_court<?=$j;?>" value="<?php echo $court_name; ?>" />
<?php
if($tformat == 'Teams' or $tformat == 'TeamSport'){
	$player2	= league::get_username(intval($rr_p2[0]));
	$team1		= league::get_team(intval($rr_p1[0]));		
	$team2		= league::get_team(intval($rr_p2[0]));		
	$home_team	= league::get_team(intval($rr_matches_loc[$i][$j]['loc']));		
	echo "<tr align='center'><td>".$mdate."</td><td>".$team1['Team_name']."</td>	
	<td style='font-weight:normal'>".$team2['Team_name']."</td>		
	<td>".$home_team['Team_name']."</td>		
	</tr>";		
}
else if($tformat == 'Individual'){

$player1 = league::get_username(intval($rr_p1[0]));
$player2 = league::get_username(intval($rr_p2[0]));

$p1_part = "";
$p2_part = "";

if($rr_p1[1]){
	$player1_partner = league::get_username(intval($rr_p1[1]));
	$p1_part = "; $player1_partner[Firstname] $player1_partner[Lastname]";
}

if($rr_p2[1]){
	$player2_partner = league::get_username(intval($rr_p2[1]));
	$p2_part = "; $player2_partner[Firstname] $player2_partner[Lastname]";
}

$home_player = league::get_username(intval($rr_matches_loc[$i][$j]['loc']));

	 echo "<tr align='center'><td>".$court_name." ".$mdate."</td>
	 <td>".$player1['Firstname']." ".$player1['Lastname'].$p1_part."</td>
	 <td style='font-weight:normal'>".$player2['Firstname']." ".$player2['Lastname'].$p2_part."</td>";
		if($home_player){ echo "<td>".$home_player['Firstname']." ".$home_player['Lastname']."</td>"; }
	 echo "</tr>";
	}
?>
<script>
var mid = "<?php echo $j; ?>";
var gid = "<?php echo $g; ?>";
  $('#g'+gid+'_match_date'+mid).fdatepicker({
		format: 'mm/dd/yyyy hh:ii',
		disableDblClickSelection: true,
		language: 'en',
		pickTime: true
	});
</script>
<?php
$n++;
 }
}
?>
</table>
</div>
<br />
<br />

<?
$teams = array_map('trim', $group);
// -------------------------------------------------------------------------------------------------------------- ?>
<input type="hidden" name="players[<?=$g;?>]"  id="players" value='<?php echo serialize($teams); ?>' />
<input type="hidden" name="tourn_id" id="tourn_id" value="<?php echo $tourn_id; ?>" />
<input type='hidden' name='match_type' value="<?php echo $this->input->post('types'); ?>" />
<input type='hidden' name='age_group' value="<?php echo $this->input->post('type_gen'); ?>" />
<input type='hidden' name='filter_events' value='<?php if($filter_events != '' and $filter_events != 'null') { echo $filter_events; } 
else if($sport_level != '' and $sport_level != 'null'){ echo $sport_level; } ?>' />
<input type='hidden' name='ttype' value="<?php echo $this->input->post('ttype'); ?>" />
<input type='hidden' name='tformat' value="<?php echo $tformat; ?>" />
<input type="hidden" name="rr_multi_rounds" id="tformat" value='<?=$rr_multi_rounds;?>' />
<input type="hidden" name="is_publish_draw" id="is_publish_draw" value='<?=$is_publish_draw;?>' />
<input type='hidden' name='br_game_day'	value="<?php echo $this->input->post('br_game_day'); ?>" />
<input type='hidden' name='draw_format'	value="<?php echo $this->input->post('draw_format'); ?>" />

<?php
if($tformat == 'Teams'){?>
<input type='checkbox' name='create_event' id='create_event' value='1' />Do you want to create events to track the players availability?
<br /><br />
<?php
}

} //End of Main For (Groups)
?>

<div align='center'>
<input type="submit" style='font-size:15px;' class="league-form-submit1" name="rr_group_bracket_confirm" id="rr_group_bracket_confirm" value=" Confirm & Save" />
</div>
</form>

</div>
</div>	  <!--end div of LOGIN BOX -->  

<!-- </div> -->    <!--end div of general-results players  -->  
</section>