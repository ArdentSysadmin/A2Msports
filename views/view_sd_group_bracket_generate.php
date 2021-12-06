<link href="<?php echo base_url();?>css/foundation-datepicker.css" rel="stylesheet">
<script src="<?php echo base_url();?>js/foundation-datepicker.js"></script>

<script>
$(document).ready(function(){
var baseurl = "<?php echo base_url();?>";

 $('#myform').submit(function(e) {
	var Draw_Title = $('#draw_title').val();
	var Tourn_id	 = $('#tourn_id').val();

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

<section id="login" class="secondary-page">
<div class='container'>
<div class='row'>
<!-- <div class="general general-results players"> -->
<!-- LOGIN BOX -->
<div class="top-score-title right-score col-md-12">
<h3>Round Robin Matches (Switch Doubles)</h3>
<div class="col-md-12">

<form method="post" id="myform" action='<?php echo base_url(); ?>league/bracket_save' class="col-md-12 login-page">
<?php
	if($this->input->post('br_game_day') != ''){
		$game_date = league::get_game_day($this->input->post('br_game_day'));
		$draw_title_date = date('M d, Y', strtotime($game_date));	
	}
	else{
		$draw_title_date =  date('M d, Y');	
	}

foreach($groups as $g => $group){
	//echo "<pre>";	print_r($group);	exit;
	$draw_title = $draw_title_date." - Group{$g}";

?>
<label>Group-<?=$g;?></label>&nbsp;&nbsp;<span id="title_error" style="color:red"></span>
<input class="form-control" type="text" name="draw_title[<?=$g;?>]" id="draw_title" value="<?=$draw_title;?>" required />
<? //--------------------------------------------------------------------------------------------------------------- 
$sd_matches = $grp_sd_matches[$g];

?>

<input type='hidden' name='rr_matches[<?=$g;?>]' id='sd_matches[<?=$g;?>]' value="<?php echo htmlentities(serialize($sd_matches)); ?>" />
<input type='hidden' name='rr_matches_loc[<?=$g;?>]' id='sd_matches_loc[<?=$g;?>]' value="<?php echo htmlentities(serialize($sd_matches_loc)); ?>" />
<div class='tab-content'>
<table class='tab-score'>
<?php
$head = 'Player';

if($this->input->post('tformat') == 'Teams' or $this->input->post('tformat') == 'TeamSport'){
$head = 'Team';
}
$index = 1;
foreach($sd_matches as $round => $matches){
?>
<tr class='top-scrore-table'>
<td align='center'>#</td>
<td align='center' colspan='2'>Round <?=$round;?></td>
<td></td>
<?php
if($tour_type == 'Flexible League'){
?>
<td>Home Location of</td>
<?php 
} ?>
</tr>
<?php
$index = 1;
foreach($matches as $match => $games){


//echo "<tr align='center'><td colspan='4'><b>Match {$match}</b>&nbsp;&nbsp;<input type='text' placeholder='Date' name='match_date{$round}{$match}' id='match_date{$round}{$match}' value='' />";
?>

</td></tr>

<?php


//foreach($games as $g => $game){
	/*echo "<pre>";
	print_r($game);*/

	$rr_p1  = $games[1][0];
	$rr_p1p = $games[1][1];

	$rr_p2  = $games[2][0];
	$rr_p2p = $games[2][1];

$mdate = "<input type='text' placeholder='Date' name='g{$g}_game_date{$round}{$index}' id='g{$g}_game_date{$round}{$index}' value='' />";

if($tformat == 'Teams' or $tformat == 'TeamSport'){
?>
<script>
var rid = "<?php echo $round.$match; ?>";
var gid = "<?php echo $g; ?>";

$('#g'+gid+'_match_date'+rid).fdatepicker({
	format: 'mm/dd/yyyy hh:ii',
	disableDblClickSelection: true,
	language: 'en',
	pickTime: true
});
</script>
<?php
	$team1   = league :: get_team(intval($rr_p1));		
	$team2 	= league :: get_team(intval($rr_p2));		
	//$home_team	= league::get_team(intval($rr_matches_loc[$i][$j]['loc']));	
	
	echo "<tr align='center'><td>".$match.'-'.$index."</td><td>".$mdate."</td><td>".$team1['Team_name']."</td>	
	<td style='font-weight:normal'>".$team2['Team_name']."</td>";
	if($tour_type == 'Flexible League'){
	echo "<td>".$home_team['Team_name']."</td>";
	}
	echo "</tr>";		
}
else if($tformat == 'Individual'){

$player1 = league :: get_username(intval($rr_p1));
$player2 = league :: get_username(intval($rr_p2));

$p1_part = "";
$p2_part = "";

if($rr_p1p){
	$player1_partner = league::get_username(intval($rr_p1p));
	$p1_part = "; ".ucfirst($player1_partner['Firstname'])." ".ucfirst($player1_partner['Lastname']);
}

if($rr_p2p){
	$player2_partner = league::get_username(intval($rr_p2p));
	$p2_part = "; ".ucfirst($player2_partner['Firstname'])." ".ucfirst($player2_partner['Lastname']);
}

//$home_player = league::get_username(intval($rr_matches_loc[$i][$j]['loc']));

 echo "<tr align='center'><td>".$round.'-'.$index."</td><td>".$mdate."</td><td>".ucfirst($player1['Firstname'])." ".ucfirst($player1['Lastname']).$p1_part."</td><td style='font-weight:normal'>".ucfirst($player2['Firstname'])." ".ucfirst($player2['Lastname']).$p2_part."</td>";

 if($tour_type == 'Flexible League'){
 echo "<td>".ucfirst($home_player['Firstname'])." ".ucfirst($home_player['Lastname'])."</td>";
 }

 echo "</tr>";
}
?>
<script>
var round = "<?php echo $round; ?>";
var mid = "<?php echo $index; ?>";
var gid = "<?php echo $g; ?>";

  $('#g'+gid+'_game_date'+round+mid).fdatepicker({
		format: 'mm/dd/yyyy hh:ii',
		disableDblClickSelection: true,
		language: 'en',
		pickTime: true
	});
</script>
<?php
$index++;
 //}
}
}
?>
</table>
</div>
<br />
<br />

<?
$teams = array_map('trim', $players);
// -------------------------------------------------------------------------------------------------------------- ?>
<input type="hidden" name="players"  id="players" value='<?php echo serialize($teams); ?>' />
<input type="hidden" name="tourn_id" id="tourn_id" value="<?php echo $tourn_id; ?>" />
<input type='hidden' name='match_type' value="<?php echo $this->input->post('types'); ?>" />
<input type='hidden' name='age_group' value="<?php echo $this->input->post('type_gen'); ?>" />
<input type='hidden' name='filter_events' value='<?php
if($filter_events != '' and $filter_events != 'null') { echo $filter_events; } 
else if($sport_level != '' and $sport_level != 'null'){ echo $sport_level; } ?>' />
<input type='hidden' name='ttype' value="<?php echo $this->input->post('ttype'); ?>" />
<input type='hidden' name='tformat' value="<?php echo $this->input->post('tformat'); ?>" />
<input type='hidden' name='is_publish_draw' value="<?php echo $this->input->post('is_publish_draw'); ?>" />
<input type='hidden' name='num_of_sets' value="<?php echo $this->input->post('num_of_sets'); ?>" />
<input type='hidden' name='br_game_day'	value="<?php echo $this->input->post('br_game_day'); ?>" />
<input type='hidden' name='draw_format'	value="<?php echo $this->input->post('draw_format'); ?>" />

<?php
if($this->input->post('tformat') == 'Teams'){?>
<input type='checkbox' name='create_event' id='create_event' value='1' />Do you want to create events to track the players availability?
<br /><br />
<?php
}

} //End of Main For (Groups)
?>

<div align='center'>
<input type="submit" style='font-size:15px;' class="league-form-submit1" name="sd_group_bracket_confirm" id="sd_group_bracket_confirm" value=" Confirm & Save" />
</div>
</form>

</div>
</div>	  <!--end div of LOGIN BOX -->  

<!-- </div> -->    <!--end div of general-results players  -->  
</div>
</div>
</section>