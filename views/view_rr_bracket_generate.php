<link href="<?php echo base_url();?>css/foundation-datepicker.css" rel="stylesheet">
<script src="<?php echo base_url();?>js/foundation-datepicker.js"></script>
<?php
//echo "<pre>"; print_r($courts_new);print_r($match_timings); exit;
?>
<script>
$(document).ready(function(){
var baseurl = "<?php echo base_url();?>";

 $('#myform').submit(function(e) {
	var Draw_Title = $('#draw_title').val();
	var Tourn_id = $('#tourn_id').val();

	//alert(Tourn_id);
		 $.ajax({
			type: "POST",
			async:false,
			url:baseurl+'league/check_draw_title/',
			data:{tourn_id:Tourn_id,draw_title:Draw_Title},
			dataType: "html",
			success: function(msg){
				if(msg == 1){
					$err_msg = Draw_Title + " is already existed!";
					$("#title_error").html($err_msg);
					$("#draw_title").val("");
					 e.preventDefault();
				     return false;
				}
				else{
						if($('#create_event').prop('checked') == true){
							$count = 0;
							$("#myform input[type=text]").each(function() {
								if(this.value == '') {
									$count++;
								}
							});

							if($count > 0){
								alert('To create Events, we require dates for all rounds!');
							e.preventDefault();
							return false;
							}
						}
				}
		   }
		});
	});
});
</script>

<section id="login" class="container secondary-page">  
<!-- <div class="general general-results players"> -->
<!-- LOGIN BOX -->
<div class="top-score-title right-score col-md-12">
<h3>Round Robin Matches</h3>
<div class="col-md-12">

<form method="post" id="myform" action='<?php echo $this->club_form_url; ?>league/bracket_save' class="col-md-12 login-page"> 

<label>Draw Title*</label>&nbsp;&nbsp;<span id="title_error" style="color:red"></span>
<input class="form-control" type="text" name="draw_title" id="draw_title" required />
<? //--------------------------------------------------------------------------------------------------------------- ?>
<?php

$robin = $robins;
//echo "<pre>";

//echo "<pre>";
//print_r($robin);
//exit;

$total_matches = count($robin);
$num_players   = count($players);
//echo count($players);
if($total_matches > 3){
	$num_rounds = ($num_players % 2 == 0) ? $num_players-1 : $num_players;

	/*$num_rounds = ($total_matches % 2 == 0) ? ($total_matches / 2) : ($total_matches / 3);

	if($num_rounds > 10)
	{
	$num_rounds = ($total_matches % 4 == 0) ? ($total_matches / 4) : ($total_matches / 5);
	}*/

	$per_round = $total_matches / $num_rounds;
}
else{
$per_round = 1;
$num_rounds = 3;
}


$round_num = 1;
$match_num = 1;
$p1 = 0;

/*echo "<br>total_matches= ".$total_matches;
echo "<br>per_round=	 ".$per_round;
echo "<br>num_rounds=	 ".$num_rounds;
exit;*/


$per_round_count = 1;

//$home_loc_count = array();
/*
foreach($robin as $rr){

	$rr_p1 = explode('-',$rr[0]);
	$rr_p2 = explode('-',$rr[1]);

	if(in_array($rr_p1[0], $players)){
		$home_loc_count[$rr_p1[0]] = floor((($total_matches-2)/2)/2);
		array_pop($rr_p1[0]);
	}

	if(in_array($rr_p2[0], $players)){
		$home_loc_count[$rr_p2[0]] = floor((($total_matches-2)/2)/2);
		array_pop($rr_p2[0]);
	}
}
*/

/* *************** Assigning of Home Court Location functionality ******************* */
$player_match_loc = array();

$tour_type = $this->input->post('tour_type');

if($tour_type == 'Flexible League'){

if(count($players) % 2 == 1) { $start = 'A'; $end = 'H'; } else { $start = 'H'; $end = 'A';}
foreach($players as $player){
	$i = 0;
	foreach($players as $opp){
	

			if($i%2 == 0){
				if(!$player_match_loc[$opp][$player]){
					$player_match_loc[$player][$opp] = ($player != $opp) ? $start : '0';
				}
				else
				{
					if($player_match_loc[$opp][$player] == $start){
						$player_match_loc[$player][$opp] = ($player != $opp) ? $end : '0';
					} else {

						if(end($player_match_loc[$player]) == 'A'){
							//echo 'test1';
						$start	= 'H';
						$end	= 'A';
						}

						$player_match_loc[$player][$opp] = ($player != $opp) ? $start : '0';
					}
				}
			}
			else{
				if(!$player_match_loc[$opp][$player]){
					$player_match_loc[$player][$opp] = ($player != $opp) ? $end : '0';
				}
				else
				{
					if($player_match_loc[$opp][$player] == $end){
						$player_match_loc[$player][$opp] = ($player != $opp) ? $start : '0';
					} else {

						if(end($player_match_loc[$player]) == 'A'){
							//echo 'test2';
						$start	= 'A';
						$end	= 'H';
						}

						$player_match_loc[$player][$opp] = ($player != $opp) ? $end : '0';
					}
				}
			}

		
			$i++;
	}

if(count($players) % 2 == 1){
	$temp	= $start;
	$start	= $end;
	$end	= $temp;
}

}

}
/* *************** End of Assigning of Home Court Location functionality ******************* */


//print_r($player_match_loc);

$rr_matches_loc = array();

$players = array();
$check_alternate_stat = array();
//print_r($home_loc_count);

foreach($robin as $rr)
{
/* --------Get individual player array-------- */

	$rr_p1 = explode('-',$rr[0]);
	$rr_p2 = explode('-',$rr[1]);


	/*if(!in_array($rr_p1[0], $players)){
		$players[] = $rr_p1[0];
		$players_partners[$rr_p1[0]] = $rr_p1[1];
	}

	if(!in_array($rr_p2[0], $players)){
		$players[] = $rr_p2[0];
		$players_partners[$rr_p2[0]] = $rr_p2[1];
	}*/

/* --------End of individual player array------ */

	$rr_matches[$round_num][$match_num][] = $rr[0];
	$rr_matches[$round_num][$match_num][] = $rr[1];

	if(!empty($player_match_loc)){

	$home_loc_player = ($player_match_loc[$rr[0]][$rr[1]] == 'H') ? $rr[0] : $rr[1];

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


//print_r($home_loc_count);

/*
echo "<pre>";
print_r($players_partners);
exit;*/
?>
<script>/*
$(document).ready(function(){

 $('body').on('focus',".datepicker", function(){
    $(this).datepicker();
});

});
*/
</script>
<input type='hidden' name='rr_matches' id='rr_matches' value="<?php echo htmlentities(serialize($rr_matches)); ?>" />
<input type='hidden' name='rr_matches_loc' id='rr_matches_loc' value="<?php echo htmlentities(serialize($rr_matches_loc)); ?>" />
<div class='tab-content'>
<table class='tab-score'>
<?php
/*echo "<pre>";
print_r($rr_matches);
exit;*/
$n = 1;
$pick_time = 1;
foreach($rr_matches as $i=>$rrm){
?>
<tr class='top-scrore-table'>
<td align='center' colspan='2'>Match <?=$i;?></td>
<td>
<div>
<input type="text" placeholder="Date" name="round_date<?php echo $i; ?>" id="round_date<?php echo $i; ?>" value="" />
<script>
var rid = "<?php echo $i; ?>";

  $('#round_date'+rid).fdatepicker({
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

if($this->input->post('tformat') == 'Teams' or $this->input->post('tformat') == 'TeamSport'){
$head = 'Team';
}
echo "<tr align='center'><td><b>Match Date</b></td><td><b>{$head} 1 </b></td><td><b>{$head} 2</b></td><td></td></tr>";

 foreach($rr_matches[$i] as $j=>$match){
	$rr_p1 = explode('-',$rr_matches[$i][$j][0]);
	$rr_p2 = explode('-',$rr_matches[$i][$j][1]);

$match_dt_time = '';
$court_name = '';
//if($match_timings[$n] and $is_bye == 0){
	
if($match_timings[$n]){
//echo "<br>".$match_timings[$match_num][0] . " - " .date('m/d/Y H:i', (trim($match_timings[$match_num][2])));
$court_name = $match_timings[$pick_time][0];
$match_dt_time = date('m/d/Y H:i', (trim($match_timings[$pick_time][2])));
$pick_time++;
}

$mdate = "<input type='text' placeholder='Date' name='match_date{$j}' id='match_date{$j}' value='{$match_dt_time}' />";
?>
<input type="hidden" id="court_<?php echo $n; ?>" name="assg_court<?php echo $n; ?>" 
value="<?php echo $court_name; ?>" />
<?php
if($this->input->post('tformat') == 'Teams' or $this->input->post('tformat') == 'TeamSport'){
	$player2	= league::get_username(intval($rr_p2[0]));
	$team1		= league::get_team(intval($rr_p1[0]));		
	$team2		= league::get_team(intval($rr_p2[0]));		
	$home_team	= league::get_team(intval($rr_matches_loc[$i][$j]['loc']));		
	echo "<tr align='center'><td>".$mdate."</td><td>".$team1['Team_name']."</td>	
	<td style='font-weight:normal'>".$team2['Team_name']."</td>		
	<td>".$home_team['Team_name']."</td>		
	</tr>";		
}
else if($this->input->post('tformat') == 'Individual'){

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
	 <td style='font-weight:normal'>".$player2['Firstname']." ".$player2['Lastname'].$p2_part."</td>
	 <td>".$home_player['Firstname']." ".$home_player['Lastname']."</td>
	 </tr>";
	}
?>
<script>
var mid = "<?php echo $j; ?>";
  $('#match_date'+mid).fdatepicker({
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
$teams = array_map('trim', $teams);
// -------------------------------------------------------------------------------------------------------------- ?>
<input type="hidden" name="players"  id="players" value='<?php echo serialize($teams); ?>' />
<input type="hidden" name="tourn_id" id="tourn_id" value="<?php echo $tourn_id; ?>" />
<input type='hidden' name='match_type' value="<?php echo $this->input->post('types'); ?>" />
<input type='hidden' name='age_group' value="<?php echo $this->input->post('type_gen'); ?>" />
<input type='hidden' name='filter_events' value='<?php if($filter_events != '' and $filter_events != 'null') { echo $filter_events; } 
else if($sport_level != '' and $sport_level != 'null'){ echo $sport_level; } ?>' />
<input type='hidden' name='ttype' value="<?php echo $this->input->post('ttype'); ?>" />
<input type='hidden' name='tformat' value="<?php echo $this->input->post('tformat'); ?>" />
<input type='hidden' name='is_publish_draw' value="<?php echo $this->input->post('is_publish_draw'); ?>" />
<input type='hidden' name='num_of_sets' value="<?php echo $this->input->post('num_of_sets'); ?>" />
<input type='hidden' name='br_game_day'	value="<?php echo $br_game_day; ?>" />
<input type="hidden" name="draw_format"  id="draw_format"  value='<?=$draw_format;?>' />
<input type='hidden' name='is_plof' value="<?php echo $this->input->post('is_plof'); ?>" />
<input type='hidden' name='plof_size' value="<?php echo $this->input->post('plof_size'); ?>" />
<input type='hidden' name='plof_size_sel' value="<?php echo $this->input->post('plof_size_sel'); ?>" />


<?php
if($this->input->post('tformat') == 'Teams'){?>
<input type='checkbox' name='create_event' id='create_event' value='1' />Do you want to create events to track the players availability?
<br /><br />
<?php
}
?>

<input type="submit" class="league-form-submit1" name="rr_bracket_confirm" id="rr_bracket_confirm" value=" Confirm & Save" />
</form>

</div>
</div>	  <!--end div of LOGIN BOX -->  

<!-- </div> -->    <!--end div of general-results players  -->  
</section>