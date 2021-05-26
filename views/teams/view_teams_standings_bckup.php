<script>
/ ------------------------- Collapse and Expand in Participants ---------------------- /
$(".header").click(function () {

    $header = $(this);
    //getting the next element
    $content = $header.next();
    //open up the content needed - toggle the slide- if visible, slide up, if not slidedown.
    $content.slideToggle(500, function () {
        //execute this after slideToggle is done
        //change text of header based on visibility of content div
        $header.text(function () {
            //change text based on condition
            //return $content.is(":visible") ? 'Text1' : 'Text2';
        });
    });

});
/ ------------------------- Collapse and Expand in Participants ---------------------- /

</script>

</script>
<style>
.container2 .header {
    #background-color:#d3d3d3;
    padding: 2px;
    cursor: pointer;
    #font-weight: bold;
}
.container2 .content {
    display: none;
    padding : 5px;
}
</style>

<div class='container2'>
<div class='col-md-4'>
<select id='standing_sel_draw' name='sel_draw' class='form-control'>
<?php
$levels = json_decode($tourn_levels);

foreach($levels as $level){
	$level_name = league::get_level_name('',$level);
?>
<option value='<?=$level;?>' <?php if($sel_level == $level){ echo "selected"; } ?>><?=$level_name['SportsLevel'];?></option>
<?php
}

if($sel_level == ""){
	$sel_level = $levels[0];
}
?>
</select>
<br />
</div>

<table id="standings" cellpadding="0" border="0" class="tab-score">
<tr class='top-scrore-table'>
<td class="text-center" style='padding-left:0px;'>Pos</td>
<td>Team</td>
<td class="text-center" style='padding-left:1px;'>Played</td>
<td class="text-center" style='padding-left:1px;'>Won</td>
<td class="text-center" style='padding-left:1px;'>Lost</td>
<td class="text-center" style='padding-left:1px;'>Total Points</td>
</tr>

<?php
$team_stat = array();

$get_level_brackets = league::get_level_brackets($tourn_id, $sel_level);

foreach($tourn_reg_teams as $team){
$played	= 0;
$won	= 0;
$lost	= 0;
$tp		= 0;
	foreach($get_level_brackets as $bracket){
	$tourn_matches = league::get_team_tourn_matches($team->Team_id, $tourn_id, $bracket->BracketID);

	if($tourn_format != 'TeamSport'){
		foreach($tourn_matches as $match){
		$source = '';
		if($match->Player1 == $team->Team_id){
		$line_matches = league::get_team_tourn_lines($match->Tourn_match_id);
		$source = 'Player1';
		$source_points = 'Player1_points';
		}
		else if($match->Player2 == $team->Team_id){
		$line_matches = league::get_team_tourn_lines($match->Tourn_match_id);
		$source = 'Player2';
		$source_points = 'Player2_points';
		}

		foreach($line_matches as $line){
		if($line->Winner != '' and $line->Winner != 0 and $line->Winner != NULL and $source){
		$played++;

		if($line->{$source} == $line->Winner){
		$won++;
		}
		else{
		$lost++;
		}

		$tp = $tp + $line->{$source_points};
		}

		}
		}
	}
	else{
		foreach($tourn_matches as $match){
		$source = '';
		if($match->Player1 == $team->Team_id){
		$source = 'Player1';
		$source_points = 'Player1_points';
		}
		else if($match->Player2 == $team->Team_id){
		$source = 'Player2';
		$source_points = 'Player2_points';
		}

		if($match->Winner != '' and $match->Winner != 0 and $match->Winner != NULL and $source){
		$played++;

		if($match->{$source} == $match->Winner){
		$won++;
		}
		else{
		$lost++;
		}

		$tp = $tp + $match->{$source_points};
		}

		}
	}
	}
	if($played){
		$team_stat[$team->Team_id]['played'] = $played;
		$team_stat[$team->Team_id]['won']    = $won;
		$team_stat[$team->Team_id]['lost']   = $lost;
		$team_stat[$team->Team_id]['tp']	 = $tp;
	}
}





$sort_func = uasort($team_stat, array('league','compareOrder2'));
$i = 1;

foreach($team_stat as $team => $standing){
$tm	= league::get_team($team);?>
	<tr>
	<td align='center'><?php echo $i; ?></td>
	<td>
	<?php
	if($tm['Team_Logo'] != NULL and $tm['Team_Logo'] != ""){
	$team_logo = "<img style='width:45px;height:40px' src='".base_url()."team_logos/".$tm['Team_Logo']."' alt='".$tm['Team_name']."' />";
	}
	else{ 
	$team_logo = "<img style='width:45px;height:40px' src='".base_url()."team_logos/default_team_logo.png' alt='".$tm['Team_name']."' />";
	}

	$team = league::get_team($tm['Team_ID']);
	echo "<div class='header'>{$team_logo}&nbsp;<span style='color:#03508c;font-size:13px;font-weight:bold;'>".$tm['Team_name']."</span>
	</div><div class='content'><ul>";

	$tour_team_players = json_decode($tm['Players']);
	foreach($tour_team_players as $tp){

		if($tour_details->Tournamentfee == 1 and $tour_details->Fee_collect_type == 'Player'){
			$is_player_paid = league::check_is_player_paid($tp, $tour_details->tournament_ID, $tm->Team_id);
		}
		$player = league::get_username($tp);

		$paid_ico	 = '';
		$captain_ico = '';
		if($player['Gender'] == 1){
			$gender = "(M)";
		}
		else if($player['Gender'] == 0){
			$gender = "(F)";
		}
		if($tp == $team['Captain']){ 
			$captain_ico = "<img src='".base_url()."icons/letter_c.png' title='Captain' style='width:15px; height:15px;' />"; 
		}

		echo "<li style='padding-left:25px;padding-bottom:5px;list-style:none;'></li>";
		echo "<li style='padding-left:25px;padding-bottom:5px;list-style:none;'>
		<a href='".base_url()."player/".$player['Users_ID']."' target='_blank' title='".$player['Mobilephone']."'>".$player['Firstname']." ".$player['Lastname']."</a> ".$gender."
		&nbsp;{$captain_ico}&nbsp;{$paid_ico}</li>";
	}

	echo "</ul></div>";
	?>
 	</td>
	<td align='center'><?php echo $standing['played']; ?></td>
	<td align='center'><?php echo $standing['won']; ?></td>
	<td align='center'><?php echo $standing['lost']; ?></td>
	<td align='center'><?php echo $standing['tp']; ?></td>
	</tr>
<?php 
$i++;
} ?>
</table>
</div>