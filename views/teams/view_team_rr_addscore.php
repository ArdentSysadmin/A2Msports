<script>
$(document).ready(function(){

var baseurl = "<?php echo base_url();?>";

$('.wff_add').click(function (e) {

var id_val = $(this).attr('id');
$("#"+id_val).attr("disabled", "disabled");

//alert(id_val);
	  $.ajax({
		type: 'POST',
		url: baseurl+'league/view_matches',
		data: $('#form-wff'+id_val).serialize(),
		success: function () {
		   //location.reload();
			alert('Result added successfully!');
			$("#forfeit"+id_val).hide();
		}
	  });
	  e.preventDefault();

});

var baseurl = "<?php echo base_url();?>";

$('.add_score_ajax').click(function (e) {
	var id_val = $(this).attr('id');

	  $.ajax({
		type: 'POST',
		url: baseurl+'league/view_matches',
		data: $('#form-addscore'+id_val).serialize(),
		success: function (){
			alert('Score added successfully!');
			$("#score"+id_val).hide();
		   //location.reload();
		}
	  });
	  e.preventDefault();
});

$(".add_team_score").click(function(){
	var pid			= $(this).attr('name');
	var tm1_player	= $("#t1_p1_"+pid).val();
	var tm2_player	= $("#t2_p1_"+pid).val();
	var Class		= $("#t1_p1_"+pid).attr('class');

	if(Class.indexOf('doubles') !== -1 || Class.indexOf('mixed') !== -1){
		var tm1_p_partner = $("#t1_p1p_"+pid).val();
		var tm2_p_partner = $("#t2_p1p_"+pid).val();
		var cond = tm1_player == "" || tm2_player == "" || tm1_p_partner == "" || tm2_p_partner == "";
	}
	else{
		var cond = tm1_player == "" || tm2_player == "";
	}

	if(cond){
		alert("Choose players to add score!");
		return false;
	}

	if($("#score"+pid).css('display')=='none'){
		$("#score"+pid).show();
		$("#forfeit"+pid).hide();
		$("#comment"+pid).hide();
	}
	else{
		$("#forfeit"+pid).hide();
		$("#score"+pid).hide();
		$("#comment"+pid).hide();
	}
});

});
</script>

<script>
$(document).ready(function(){

$('.show_lines').click(function(){
var tid = $(this).attr('name');

	if($('.match_lines_'+tid).is(':visible')){
		$('.match_lines_'+tid).hide();
	}
	else{
		$('.match_lines_'+tid).show();
	}
});


$("select").change(function()
{
	$cname = $(this).attr('class');
	if($cname != 'wff_sel')		// to skip for WFF select box
	{
	$ids   = $(this).attr('id');
	$user  = $(this).val();
	$temp  = $ids.split('_');

	$line  = $temp[2];	
	$ptype = $temp[0]+'_'+$temp[1];


	if($ptype === 't1_p1'){
	$('#player1_user_'+$line).val($user);
	$('#wf_player1_user_'+$line).val($user);
	}
	else if($ptype === 't1_p1p'){
	$('#player1_user_partner_'+$line).val($user);
	$('#wf_player1_user_partner_'+$line).val($user);
	}
	else if($ptype === 't2_p1'){
	$('#player2_user_'+$line).val($user);
	$('#wf_player2_user_'+$line).val($user);
	}
	else if($ptype === 't2_p1p'){
	$('#player2_user_partner_'+$line).val($user);
	$('#wf_player2_user_partner_'+$line).val($user);
	}

	var selectedText = $(this).find('option:selected').text();
	    $('#div_'+$temp[0]+'_'+$temp[1]+'_'+$line).html(selectedText);
	$('#div_mob_'+$temp[0]+'_'+$temp[1]+'_'+$line).html(selectedText);

	
	if($temp[1] == 'p1p')
	{
		$get_html = $('#div_'+$temp[0]+'_p1_'+$line).html();
		$temp2	  = $get_html.split(';');
	
		if($temp2[0]){
			    $('#div_'+$temp[0]+'_p1_'+$line).html($temp2[0]+'; '+selectedText);
			$('#div_mob_'+$temp[0]+'_p1_'+$line).html($temp2[0]+'; '+selectedText);
		}
		else{
			    $('#div_'+$temp[0]+'_p1_'+$line).append('; '+selectedText);
			$('#div_mob_'+$temp[0]+'_p1_'+$line).append('; '+selectedText);
		}
	}
	else
	{
		$('#win_ff_team'+$line).append($('<option>', {
			value: $user,
			text: selectedText
		}));
	}

	$("."+$cname+" option").attr('disabled','disabled').siblings().removeAttr('disabled');

	DisableOptions(); //disable selected values
	}
});


function DisableOptions()
{
	var arr=[];
	$("."+$cname+" option:selected").each(function()
	{
		if($(this).val() != ""){
		  arr.push($(this).val());
		}
	});

	$("."+$cname+" option").filter(function()
	{
		//alert($.inArray($(this).val(),arr));
			if($.inArray($(this).val(),arr) > -1){
				$(this).attr("disabled","disabled");
			}
			else{
				$(this).attr("enabled","enabled");
			}
	});
}

var baseurl = "<?php echo base_url();?>";

$(".team_edit_score").click(function(){
var line = $(this).attr('name');

if(line){
	if(confirm('Are you sure to drop the line match score?')){
		  $.ajax({
			type:'POST',
			url:baseurl+'league/drop_line_matchscore',
			data:{'line':line},
			success: function(res){
			   location.reload();
			}
		  });
		  //e.preventDefault();
	}
	else{
		//alert('cancelled');
	}

}

});

$('.wff_score').click(function() {
var pid2 = $(this).attr('name');

if($("#forfeit"+pid2).css('display')=='none'){
$("#forfeit"+pid2).show();
$("#score"+pid2).hide();
/*$("#comment"+pid).hide();*/
}
else{
$("#forfeit"+pid2).hide();
$("#score"+pid2).hide();
/*$("#comment"+pid).hide();*/
}

});

});
</script>

<?php 
$now	 = time();

$tourn_id		= $get_bracket_details['Tourn_ID'];
$rr_matches		= $rr_bracket_matches->result();
$line_matches	= $rr_line_matches->result();
$logged_user	= $this->logged_user;
$tourn_admin	= $tour_details->Usersid;
$logged_user_teams = league :: get_loggeduser_teams();

$user_teams	= array();
foreach($logged_user_teams as $log_user_team){
	$user_teams[] = $log_user_team->Team_ID;
}

$teams	= array();
$play_by_dates  = array();
$r =0;
foreach($rr_matches as $m => $match){
	if(!in_array($rr_matches[$m]->Player1, $teams)){
		$teams[] = $rr_matches[$m]->Player1;
	}

	if(!in_array($rr_matches[$m]->Player2, $teams)){
		$teams[] = $rr_matches[$m]->Player2;
	}

	if($rr_matches[($m+1)]->Round_Num != $rr_matches[$m]->Round_Num)
	{
		$r = $rr_matches[$m]->Round_Num;
		$play_by_dates[$r] = $rr_matches[$m]->Match_DueDate;
	}

}
/*echo "<pre>";
print_r($line_matches);
echo "<hr>";
print_r($user_teams);
echo "<hr>";
print_r($logged_user_teams);
echo "<hr>";*/


$logged_user_teams = array_intersect($teams, $user_teams);
?>


<div class='tab-content mob-view-padding' style="background:#fff">

<div class="top-score-title right-score">
<p><b><?php echo $get_bracket_details['Draw_Title']; ?></b></p>
<div class="table-responsive">

<!-- List of Scheduled Matches Table Start Here	 -->

<table class='tab-score'>
<?php
if(empty($logged_user_teams) and $tourn_admin != $logged_user)
{
?>
<tr><td><span style="color:red">No Matches found, as your team is not participating in this draw!</span></td></tr>
<?php
}
else
{
$round		= 0;
$match_num	= 1;

foreach($rr_matches as $m=>$rrm){   // Main for loop

/* Table header section */
if($round != $rr_matches[$m]->Round_Num and (in_array($rr_matches[$m]->Player1, $logged_user_teams) or in_array($rr_matches[$m]->Player2, $logged_user_teams) or $tourn_admin == $logged_user) and false)
{
$round = $rr_matches[$m]->Round_Num;
?>
<tr class='top-scrore-table'>
<!-- <td>Match #</td> -->
<td align='center' colspan='2'>Match <?=$rr_matches[$m]->Round_Num;?></td>
<td colspan='2'>
<?php 
if($play_by_dates[$round] and $tourn_admin == $logged_user){

 $split_date = explode(" ",$play_by_dates[$round]);
 $date1 = ($split_date[1] != "00:00:00.000" and $split_date[1] != "") ?
 date("m/d/Y h:i A", strtotime($play_by_dates[$round])) : date("m/d/Y", strtotime($play_by_dates[$round]));

	echo "Play by: ".$date1; 
}
?>
</td>
</tr>
<?php
	$logged_user_team_matches = 0;
	$round_matches = 0;
}
else{
$round_matches++;
}
/* End of Table header section */


/* Table List of Matches section */

$player1 = league::get_team(intval($rr_matches[$m]->Player1));
$player2 = league::get_team(intval($rr_matches[$m]->Player2));


$tm_id = $rr_matches[$m]->Tourn_match_id;
?>
<tr>
	<?php 
	if(in_array($rr_matches[$m]->Player1, $logged_user_teams) or in_array($rr_matches[$m]->Player2, $logged_user_teams) or $tourn_admin == $logged_user){ ?>
	
	<td style="padding-left:15px;">
	<?php 
	if($rr_matches[$m]->Match_DueDate){
		$split_date = explode(" ",$rr_matches[$m]->Match_DueDate);
		$date2 = ($split_date[1] != "00:00:00.000" and $split_date[1] != "") ?
		date("m/d/Y h:i A", strtotime($rr_matches[$m]->Match_DueDate)) : date("m/d/Y", strtotime($rr_matches[$m]->Match_DueDate));

		echo $date2; 
	}
	?>
	</td>
	<td style="padding-left:15px;"><a style='text-decoration:none;'>
	<?php
	$winner_medal	= "";
	$get_homeloc	= "";
	$loc_icon1		= "";
	$loc_icon2		= "";

	if($rr_matches[$m]->Winner == $rr_matches[$m]->Player1) {
		$winner_medal	= "<img id='img-winner' src='".base_url()."images/gold_medal_small.png' width='20' height='20' />";
	}

	if($rr_matches[$m]->Match_Location_User == $rr_matches[$m]->Player1){
		$get_homeloc = league::get_home_location($player1['Home_loc_id']);
		$player1_loc_icon = 'home.png';
		$player2_loc_icon = 'car.png';
	}
	else if($rr_matches[$m]->Match_Location_User == $rr_matches[$m]->Player2){
		$get_homeloc = league::get_home_location($player2['Home_loc_id']);
		$player2_loc_icon = 'home.png';
		$player1_loc_icon = 'car.png';
	}
		$map_url = "https://www.google.com/maps/place/".$get_homeloc['hcl_address']."+".$get_homeloc['hcl_city']."+".$get_homeloc['hcl_state']."+".$get_homeloc['hcl_country'];

		if($get_homeloc){
		$loc_icon1 = "<a href='".$map_url."' title='".$get_homeloc['hcl_address'].", ".$get_homeloc['hcl_city'].", ".$get_homeloc['hcl_state'].", ".$get_homeloc['hcl_country']."' target='_blank'>"
		."<img src='".base_url()."icons/{$player1_loc_icon}' style='width:24px;height:24px;' />"
		."</a> ";

		$loc_icon2 = "<a href='".$map_url."' title='".$get_homeloc['hcl_address'].", ".$get_homeloc['hcl_city'].", ".$get_homeloc['hcl_state'].", ".$get_homeloc['hcl_country']."' target='_blank'>"
		."<img src='".base_url()."icons/{$player2_loc_icon}' style='width:24px;height:24px;' />"
		."</a> ";
		}


	echo ucfirst($player1['Team_name'])."</a>"." ".$loc_icon1.$winner_medal; ; 

	?></td>
	
	 <td style="padding-left:15px;"><a style='text-decoration:none;'>
	 <?php

	$winner_medal	= "";
	if($rr_matches[$m]->Winner == $rr_matches[$m]->Player2) {
		$winner_medal	= "<img id='img-winner' src='".base_url()."images/gold_medal_small.png' width='20' height='20' />";
	}
	
	echo ucfirst($player2['Team_name'])."</a>"." ".$loc_icon2.$winner_medal; ;
	?></td>

<?php //if($tour_details->Tournament_type == 'Flexible League'){ ?>
<!-- <td style="padding-left:15px;"><?php 
	/* if($rr_matches[$m]->Match_Location) { $loc_id = $rr_matches[$m]->Match_Location; } 
		$get_loc = league::get_home_location($loc_id);

		$map_url = "https://www.google.co.in/maps/place/".$get_loc['hcl_address']."+".$get_loc['hcl_city']."+".$get_loc['hcl_state']."+".
		$get_loc['hcl_country'];

		echo "<a href='".$map_url."' title='".$get_loc['hcl_address'].", ".$get_loc['hcl_city'].", ".$get_loc['hcl_state'].", ".$get_loc['hcl_country']."' target='_blank'>".$get_loc['hcl_title']."</a><br>";
	*/	?>
</td> -->
<?php //} ?>

<?php //if($rr_matches[$m]->Winner == "") {?>
<td style="padding-left:15px;" colspan='2'>
<a id='show_lines' class='show_lines' href='#reg_matches' name='<?php echo $tm_id; ?>' style='text-decoration:none;'>Show Lines </a></td>
<?php //}
$logged_user_team_matches++;
}
if($logged_user_team_matches == 0 and $round_matches != 0){ ?>
<!-- <td colspan='4' align='center'>---- Got a Bye ----</td>
 --><?php 
}
?>
</tr>

<!-- Lines Tables Start here -->
<tr id="match_lines_<?=$tm_id;?>" class="match_lines_<?=$tm_id;?>" style="display:none;">
<td style="padding-left:15px;">#</td>
<td style="padding-left:15px;">Player (<?=ucfirst($player1['Team_name']);?>)</td>
<td style="padding-left:15px;">Player (<?=ucfirst($player2['Team_name']);?>)</td>
<td style="padding-left:15px;">&nbsp;</td>
</tr>

<?php
$team1_block_players_singles = array();
$team2_block_players_singles = array();

$team1_block_players_msingles = array();
$team2_block_players_msingles = array();

$team1_block_players_wsingles = array();
$team2_block_players_wsingles = array();

$team1_block_players_osingles = array();
$team2_block_players_osingles = array();

$team1_block_players_doubles = array();
$team2_block_players_doubles = array();

$team1_block_players_mdoubles = array();
$team2_block_players_mdoubles = array();

$team1_block_players_wdoubles = array();
$team2_block_players_wdoubles = array();

$team1_block_players_odoubles = array();
$team2_block_players_odoubles = array();

$team1_block_players_mixed = array();
$team2_block_players_mixed = array();


foreach($line_matches as $line){
$line_id = $line->Tourn_line_id;
if($line->Tourn_match_id == $tm_id)
{
?>
<script>
$(function() {
	var line_id = "<?php echo $line_id; ?>";
 $('#sdate'+line_id).datepick();
});
</script>

<?php
if($line->Match_Type == 'Doubles'){
	$sel_class ='doubles';
	$block_type='doubles';
	$label ='Doubles';
}
else if($line->Match_Type == 'MDoubles'){
  	$sel_class ='mdoubles';
	$block_type='mdoubles';
	$label ='MDoubles';
}
else if($line->Match_Type == 'WDoubles'){
	$sel_class ='wdoubles';
	$block_type='wdoubles';
	$label ='WDoubles';
}
else if($line->Match_Type == 'MSingles'){
  	$sel_class ='msingles';
	$block_type='msingles';
	$label ='MSingles';
}
else if($line->Match_Type == 'WSingles'){
	$sel_class ='wsingles';
	$block_type='wsingles';
	$label ='WSingles';
}
else if($line->Match_Type == 'Mixed'){
	$sel_class ='mixed';
	$block_type='mixed';
	$label ='Mixed';
}
else if($line->Match_Type == 'OSingles'){
	$sel_class ='osingles';
	$block_type='osingles';
	$label ='Singles';
}
else if($line->Match_Type == 'ODoubles'){
	$sel_class ='odoubles';
	$block_type='odoubles';
	$label ='Doubles';
}
else {
	$sel_class ='singles';
	$block_type='singles';
	$label ='Singles';
}

if(($line->Winner == NULL or $line->Winner == 0 or $line->Winner == "") and ($player1['Captain'] == $logged_user or $player2['Captain'] == $logged_user or $tourn_admin == $logged_user)){
?>
<tr id="match_lines_<?=$tm_id;?>" class="match_lines_<?=$tm_id;?>" style="display:none;">

<td style="padding-left:15px;"><?php echo $line->Line_num." (".$label.")";?></td>
<td style="padding-left:15px;">

<?php if($line->Match_Type == 'Singles'){ ?>
<select id='t1_p1_<?=$line_id;?>' name='<?=$rr_matches[$m]->Player1;?>' class='<?=$sel_class?>_<?=$tm_id;?>_<?=$rr_matches[$m]->Player1;?>'><!-- Team 1 Players -->
<option value=''>Player</option>
<?php 
$get_reg_players1	= league::get_reg_team_players($tourn_id, $rr_matches[$m]->Player1);
$team1_players		= json_decode($get_reg_players1['Team_Players']);

foreach($team1_players as $player){

	  if(!in_array($player, ${'team1_block_players_'.$block_type}))
	  {
$get_name = league::get_username($player); 
$team1_player = $get_name['Firstname'] . "  " . $get_name['Lastname'];
?>
<option value='<?=$player;?>'><?=$team1_player;?></option>
<?php }
} ?>
</select>
<?php } ?>
<?php if($line->Match_Type == 'Doubles'){ ?>
	<select id='t1_p1_<?=$line_id;?>' name='<?=$rr_matches[$m]->Player1;?>' class='<?=$sel_class?>_<?=$tm_id;?>_<?=$rr_matches[$m]->Player1;?>'><!-- Team 1 Players -->
<option value=''>Player</option>
<?php 
$get_reg_players1	= league::get_reg_team_players($tourn_id, $rr_matches[$m]->Player1);
$team1_players		= json_decode($get_reg_players1['Team_Players']);

foreach($team1_players as $player){

	  if(!in_array($player, ${'team1_block_players_'.$block_type}))
	  {
$get_name = league::get_username($player); 
$team1_player = $get_name['Firstname'] . "  " . $get_name['Lastname'];
?>
<option value='<?=$player;?>'><?=$team1_player;?></option>
<?php }
} ?>
</select>
<select id='t1_p1p_<?=$line_id;?>' name='<?=$rr_matches[$m]->Player1;?>' class='<?=$sel_class?>_<?=$tm_id;?>_<?=$rr_matches[$m]->Player1;?>'>
<!-- Team 1 Player Partner -->
<option value=''>Player</option>
<?php 
$get_reg_players1 = league::get_reg_team_players($tourn_id, $rr_matches[$m]->Player1);
$team1_players = json_decode($get_reg_players1['Team_Players']);

foreach($team1_players as $player){
	  if(!in_array($player, ${'team1_block_players_'.$block_type}))
	  {
$get_name = league::get_username($player); 
$team1_player = $get_name['Firstname'] . "  " . $get_name['Lastname'];
?>
<option value='<?=$player;?>'><?=$team1_player;?></option>
<?php }
} ?>
</select>
<?php } ?>

<?php if($line->Match_Type == 'MSingles'){ ?>
<select id='t1_p1_<?=$line_id;?>' name='<?=$rr_matches[$m]->Player1;?>' class='<?=$sel_class?>_<?=$tm_id;?>_<?=$rr_matches[$m]->Player1;?>'><!-- Team 1 Players -->
<option value=''>Player</option>
<?php 
$get_reg_players1	= league::get_reg_team_players($tourn_id, $rr_matches[$m]->Player1);

$team1_players		= json_decode($get_reg_players1['Team_Players']);
$get_users_bygender = league::get_users_bygender($team1_players, 'Men');


foreach($get_users_bygender as $player){

	  if(!in_array($player->Users_ID, ${'team1_block_players_'.$block_type}))
	  {
$get_name = league::get_username($player->Users_ID); 	
$team1_player = $get_name['Firstname'] . "  " . $get_name['Lastname'];
?>
<option value='<?=$player->Users_ID;?>'><?=$team1_player;?></option>
<?php }
} ?>
</select>
<?php } ?>

<?php if($line->Match_Type == 'MDoubles'){ ?>
<select id='t1_p1_<?=$line_id;?>' name='<?=$rr_matches[$m]->Player1;?>' class='<?=$sel_class?>_<?=$tm_id;?>_<?=$rr_matches[$m]->Player1;?>'><!-- Team 1 Players -->
<option value=''>Player</option>
<?php 
$get_reg_players1	= league::get_reg_team_players($tourn_id, $rr_matches[$m]->Player1);
$team1_players		= json_decode($get_reg_players1['Team_Players']);
$get_users_bygender = league::get_users_bygender($team1_players, 'Men');

foreach($get_users_bygender as $player){

	  if(!in_array($player->Users_ID, ${'team1_block_players_'.$block_type}))
	  {
$get_name = league::get_username($player->Users_ID); 
$team1_player = $get_name['Firstname'] . "  " . $get_name['Lastname'];
?>
<option value='<?=$player->Users_ID;?>'><?=$team1_player;?></option>
<?php }
} ?>
</select>
<select id='t1_p1p_<?=$line_id;?>' name='<?=$rr_matches[$m]->Player1;?>' class='<?=$sel_class?>_<?=$tm_id;?>_<?=$rr_matches[$m]->Player1;?>'>
<!-- Team 1 Player Partner -->
<option value=''>Player</option>
<?php 
$get_reg_players1 = league::get_reg_team_players($tourn_id, $rr_matches[$m]->Player1);
$team1_players = json_decode($get_reg_players1['Team_Players']);
$get_users_bygender = league::get_users_bygender($team1_players, 'Men');

foreach($get_users_bygender as $player){

	  if(!in_array($player->Users_ID, ${'team1_block_players_'.$block_type}))
	  {
$get_name = league::get_username($player->Users_ID); 
$team1_player = $get_name['Firstname'] . "  " . $get_name['Lastname'];
?>
<option value='<?=$player->Users_ID;?>'><?=$team1_player;?></option>
<?php }
} ?>
</select>
<?php } ?>

<?php if($line->Match_Type == 'WSingles'){ ?>
<select id='t1_p1_<?=$line_id;?>' name='<?=$rr_matches[$m]->Player1;?>' class='<?=$sel_class?>_<?=$tm_id;?>_<?=$rr_matches[$m]->Player1;?>'><!-- Team 1 Players -->
<option value=''>Player</option>
<?php 
$get_reg_players1	= league::get_reg_team_players($tourn_id, $rr_matches[$m]->Player1);
$team1_players		= json_decode($get_reg_players1['Team_Players']);
$get_users_bygender = league::get_users_bygender($team1_players, 'Women');

foreach($get_users_bygender as $player){

	  if(!in_array($player->Users_ID, ${'team1_block_players_'.$block_type}))
	  {
$get_name = league::get_username($player->Users_ID); 
$team1_player = $get_name['Firstname'] . "  " . $get_name['Lastname'];
?>
<option value='<?=$player->Users_ID;?>'><?=$team1_player;?></option>
<?php }
} ?>
</select>
<?php } ?>

<?php if($line->Match_Type == 'WDoubles'){ ?>
<select id='t1_p1_<?=$line_id;?>' name='<?=$rr_matches[$m]->Player1;?>' class='<?=$sel_class?>_<?=$tm_id;?>_<?=$rr_matches[$m]->Player1;?>'><!-- Team 1 Players -->
<option value=''>Player</option>
<?php 
$get_reg_players1	= league::get_reg_team_players($tourn_id, $rr_matches[$m]->Player1);
$team1_players		= json_decode($get_reg_players1['Team_Players']);
$get_users_bygender = league::get_users_bygender($team1_players, 'Women');

foreach($get_users_bygender as $player){

	  if(!in_array($player->Users_ID, ${'team1_block_players_'.$block_type}))
	  {
$get_name = league::get_username($player->Users_ID); 
$team1_player = $get_name['Firstname'] . "  " . $get_name['Lastname'];
?>
<option value='<?=$player->Users_ID;?>'><?=$team1_player;?></option>
<?php }
} ?>
</select>
<select id='t1_p1p_<?=$line_id;?>' name='<?=$rr_matches[$m]->Player1;?>' class='<?=$sel_class?>_<?=$tm_id;?>_<?=$rr_matches[$m]->Player1;?>'>
<!-- Team 1 Player Partner -->
<option value=''>Player</option>
<?php 
$get_reg_players1 = league::get_reg_team_players($tourn_id, $rr_matches[$m]->Player1);
$team1_players = json_decode($get_reg_players1['Team_Players']);
$get_users_bygender = league::get_users_bygender($team1_players, 'Women');

foreach($get_users_bygender as $player){

	  if(!in_array($player->Users_ID, ${'team1_block_players_'.$block_type}))
	  {
$get_name = league::get_username($player->Users_ID); 
$team1_player = $get_name['Firstname'] . "  " . $get_name['Lastname'];
?>
<option value='<?=$player->Users_ID;?>'><?=$team1_player;?></option>
<?php }
} ?>
</select>
<?php } ?>

<?php if($line->Match_Type == 'Mixed'){ ?>
<select id='t1_p1_<?=$line_id;?>' name='<?=$rr_matches[$m]->Player1;?>' class='<?=$sel_class?>_<?=$tm_id;?>_<?=$rr_matches[$m]->Player1;?>'><!-- Team 1 Players -->
<option value=''>Player</option>
<?php 
$get_reg_players1	= league::get_reg_team_players($tourn_id, $rr_matches[$m]->Player1);
$team1_players		= json_decode($get_reg_players1['Team_Players']);
$get_users_bygender = league::get_users_bygender($team1_players, 'Men');

foreach($get_users_bygender as $player){

	  if(!in_array($player->Users_ID, ${'team1_block_players_'.$block_type}))
	  {
$get_name = league::get_username($player->Users_ID); 
$team1_player = $get_name['Firstname'] . "  " . $get_name['Lastname'];
?>
<option value='<?=$player->Users_ID;?>'><?=$team1_player;?></option>
<?php }
} ?>
</select>
<select id='t1_p1p_<?=$line_id;?>' name='<?=$rr_matches[$m]->Player1;?>' class='<?=$sel_class?>_<?=$tm_id;?>_<?=$rr_matches[$m]->Player1;?>'>
<!-- Team 1 Player Partner -->
<option value=''>Player</option>
<?php 
$get_reg_players1 = league::get_reg_team_players($tourn_id, $rr_matches[$m]->Player1);
$team1_players = json_decode($get_reg_players1['Team_Players']);
$get_users_bygender = league::get_users_bygender($team1_players, 'Women');

foreach($get_users_bygender as $player){
	  if(!in_array($player->Users_ID, ${'team1_block_players_'.$block_type})){
$get_name = league::get_username($player->Users_ID); 
$team1_player = $get_name['Firstname'] . "  " . $get_name['Lastname'];
?>
<option value='<?=$player->Users_ID;?>'><?=$team1_player;?></option>
<?php }
} ?>
</select>
<?php } ?>

<?php if($line->Match_Type == 'OSingles'){ ?>
<select id='t1_p1_<?=$line_id;?>' name='<?=$rr_matches[$m]->Player1;?>' class='<?=$sel_class?>_<?=$tm_id;?>_<?=$rr_matches[$m]->Player1;?>'><!-- Team 1 Players -->
<option value=''>Player</option>
<?php 
$get_reg_players1	= league::get_reg_team_players($tourn_id, $rr_matches[$m]->Player1);

$team1_players		= json_decode($get_reg_players1['Team_Players']);
$get_users_bygender = league::get_users_bygender($team1_players, 'Open');


foreach($get_users_bygender as $player){

	  if(!in_array($player->Users_ID, ${'team1_block_players_'.$block_type})){
$get_name = league::get_username($player->Users_ID); 	
$team1_player = $get_name['Firstname'] . "  " . $get_name['Lastname'];
?>
<option value='<?=$player->Users_ID;?>'><?=$team1_player;?></option>
<?php }
} ?>
</select>
<?php } ?>

<?php if($line->Match_Type == 'ODoubles'){ ?>
<select id='t1_p1_<?=$line_id;?>' name='<?=$rr_matches[$m]->Player1;?>' class='<?=$sel_class?>_<?=$tm_id;?>_<?=$rr_matches[$m]->Player1;?>'><!-- Team 1 Players -->
<option value=''>Player</option>
<?php 
$get_reg_players1	= league::get_reg_team_players($tourn_id, $rr_matches[$m]->Player1);
$team1_players		= json_decode($get_reg_players1['Team_Players']);
$get_users_bygender = league::get_users_bygender($team1_players, 'Open');

foreach($get_users_bygender as $player){
	  if(!in_array($player->Users_ID, ${'team1_block_players_'.$block_type})){
$get_name = league::get_username($player->Users_ID); 
$team1_player = $get_name['Firstname'] . "  " . $get_name['Lastname'];
?>
<option value='<?=$player->Users_ID;?>'><?=$team1_player;?></option>
<?php }
} ?>
</select>
<select id='t1_p1p_<?=$line_id;?>' name='<?=$rr_matches[$m]->Player1;?>' class='<?=$sel_class?>_<?=$tm_id;?>_<?=$rr_matches[$m]->Player1;?>'>
<!-- Team 1 Player Partner -->
<option value=''>Player</option>
<?php 
$get_reg_players1 = league::get_reg_team_players($tourn_id, $rr_matches[$m]->Player1);
$team1_players = json_decode($get_reg_players1['Team_Players']);
$get_users_bygender = league::get_users_bygender($team1_players, 'Open');

foreach($get_users_bygender as $player){

	  if(!in_array($player->Users_ID, ${'team1_block_players_'.$block_type})){
$get_name = league::get_username($player->Users_ID); 
$team1_player = $get_name['Firstname'] . "  " . $get_name['Lastname'];
?>
<option value='<?=$player->Users_ID;?>'><?=$team1_player;?></option>
<?php }
} ?>
</select>
<?php } ?>

</td>

<td style="padding-left:15px;">
<?php if($line->Match_Type == 'Singles'){ ?>
<select id='t2_p1_<?=$line_id;?>' name='<?=$rr_matches[$m]->Player2;?>' class='<?=$sel_class?>_<?=$tm_id;?>_<?=$rr_matches[$m]->Player2;?>'><!-- Team 2 Players -->
<option value=''>Player</option>
<?php 
$get_reg_players2 = league::get_reg_team_players($tourn_id, $rr_matches[$m]->Player2);
$team2_players = json_decode($get_reg_players2['Team_Players']);

foreach($team2_players as $player){
	  if(!in_array($player, ${'team2_block_players_'.$block_type}))
	  {
$get_name	  = league::get_username($player); 
$team2_player = $get_name['Firstname'] . "  " . $get_name['Lastname'];?>
<option value='<?=$player;?>'><?=$team2_player;?></option>
<?php }
}?>
</select>
<?php } ?>
<?php if($line->Match_Type == 'Doubles'){ ?>
<select id='t2_p1_<?=$line_id;?>' name='<?=$rr_matches[$m]->Player2;?>' class='<?=$sel_class?>_<?=$tm_id;?>_<?=$rr_matches[$m]->Player2;?>'><!-- Team 2 Players -->
<option value=''>Player</option>
<?php 
$get_reg_players2 = league::get_reg_team_players($tourn_id, $rr_matches[$m]->Player2);
$team2_players = json_decode($get_reg_players2['Team_Players']);

foreach($team2_players as $player){
	  if(!in_array($player, ${'team2_block_players_'.$block_type}))
	  {
$get_name	  = league::get_username($player); 
$team2_player = $get_name['Firstname'] . "  " . $get_name['Lastname'];?>
<option value='<?=$player;?>'><?=$team2_player;?></option>
<?php }
}?>
</select>
<select id='t2_p1p_<?=$line_id;?>' name='<?=$rr_matches[$m]->Player2;?>' class='<?=$sel_class?>_<?=$tm_id;?>_<?=$rr_matches[$m]->Player2;?>'><!-- Team 2 Player Partner -->
<option value=''>Player</option>
<?php 
$get_reg_players1 = league::get_reg_team_players($tourn_id, $rr_matches[$m]->Player2);
$team1_players = json_decode($get_reg_players1['Team_Players']);

foreach($team1_players as $player){
	  if(!in_array($player, ${'team2_block_players_'.$block_type}))
	  {
	$get_name	  = league::get_username($player); 
	$team1_player = $get_name['Firstname'] . "  " . $get_name['Lastname'];
?>
<option value='<?=$player;?>'><?=$team1_player;?></option>
<?php }
}?>
</select>
<?php } ?>

<?php if($line->Match_Type == 'MSingles'){ ?>
<select id='t2_p1_<?=$line_id;?>' name='<?=$rr_matches[$m]->Player2;?>' class='<?=$sel_class?>_<?=$tm_id;?>_<?=$rr_matches[$m]->Player2;?>'><!-- Team 2 Players -->
<option value=''>Player</option>
<?php 
$get_reg_players2 = league::get_reg_team_players($tourn_id, $rr_matches[$m]->Player2);
$team2_players = json_decode($get_reg_players2['Team_Players']);
$get_users_bygender = league::get_users_bygender($team2_players, 'Men');

foreach($get_users_bygender as $player){
	  if(!in_array($player->Users_ID, ${'team2_block_players_'.$block_type}))
	  {
$get_name	  = league::get_username($player->Users_ID); 
$team2_player = $get_name['Firstname'] . "  " . $get_name['Lastname'];?>
<option value='<?=$player->Users_ID;?>'><?=$team2_player;?></option>
<?php }
}?>
</select>
<?php } ?>

<?php if($line->Match_Type == 'MDoubles'){ ?>
<select id='t2_p1_<?=$line_id;?>' name='<?=$rr_matches[$m]->Player2;?>' class='<?=$sel_class?>_<?=$tm_id;?>_<?=$rr_matches[$m]->Player2;?>'><!-- Team 2 Players -->
<option value=''>Player</option>
<?php 
$get_reg_players2 = league::get_reg_team_players($tourn_id, $rr_matches[$m]->Player2);
$team2_players = json_decode($get_reg_players2['Team_Players']);
$get_users_bygender = league::get_users_bygender($team2_players, 'Men');

foreach($get_users_bygender as $player){
	  if(!in_array($player->Users_ID, ${'team2_block_players_'.$block_type}))
	  {
$get_name	  = league::get_username($player->Users_ID); 
$team2_player = $get_name['Firstname'] . "  " . $get_name['Lastname'];?>
<option value='<?=$player->Users_ID;?>'><?=$team2_player;?></option>
<?php }
}?>
</select>
<select id='t2_p1p_<?=$line_id;?>' name='<?=$rr_matches[$m]->Player2;?>' class='<?=$sel_class?>_<?=$tm_id;?>_<?=$rr_matches[$m]->Player2;?>'><!-- Team 2 Player Partner -->
<option value=''>Player</option>
<?php 
$get_reg_players1 = league::get_reg_team_players($tourn_id, $rr_matches[$m]->Player2);
$team1_players = json_decode($get_reg_players1['Team_Players']);
$get_users_bygender = league::get_users_bygender($team1_players, 'Men');

foreach($get_users_bygender as $player){
	  if(!in_array($player->Users_ID, ${'team2_block_players_'.$block_type}))
	  {
	$get_name	  = league::get_username($player->Users_ID); 
	$team1_player = $get_name['Firstname'] . "  " . $get_name['Lastname'];
?>
<option value='<?=$player->Users_ID;?>'><?=$team1_player;?></option>
<?php }
}?>
</select>
<?php } ?>

<?php if($line->Match_Type == 'WSingles'){ ?>
<select id='t2_p1_<?=$line_id;?>' name='<?=$rr_matches[$m]->Player2;?>' class='<?=$sel_class?>_<?=$tm_id;?>_<?=$rr_matches[$m]->Player2;?>'><!-- Team 2 Players -->
<option value=''>Player</option>
<?php 
$get_reg_players2 = league::get_reg_team_players($tourn_id, $rr_matches[$m]->Player2);
$team2_players = json_decode($get_reg_players2['Team_Players']);
$get_users_bygender = league::get_users_bygender($team2_players, 'Women');

foreach($get_users_bygender as $player){
	  if(!in_array($player->Users_ID, ${'team2_block_players_'.$block_type}))
	  {
$get_name	  = league::get_username($player->Users_ID); 
$team2_player = $get_name['Firstname'] . "  " . $get_name['Lastname'];?>
<option value='<?=$player->Users_ID;?>'><?=$team2_player;?></option>
<?php }
}?>
</select>
<?php } ?>

<?php if($line->Match_Type == 'WDoubles'){ ?>
<select id='t2_p1_<?=$line_id;?>' name='<?=$rr_matches[$m]->Player2;?>' class='<?=$sel_class?>_<?=$tm_id;?>_<?=$rr_matches[$m]->Player2;?>'><!-- Team 2 Players -->
<option value=''>Player</option>
<?php 
$get_reg_players2 = league::get_reg_team_players($tourn_id, $rr_matches[$m]->Player2);
$team2_players = json_decode($get_reg_players2['Team_Players']);
$get_users_bygender = league::get_users_bygender($team2_players, 'Women');

foreach($get_users_bygender as $player){
	  if(!in_array($player->Users_ID, ${'team2_block_players_'.$block_type}))
	  {
$get_name	  = league::get_username($player->Users_ID); 
$team2_player = $get_name['Firstname'] . "  " . $get_name['Lastname'];?>
<option value='<?=$player->Users_ID;?>'><?=$team2_player;?></option>
<?php }
}?>
</select>
<select id='t2_p1p_<?=$line_id;?>' name='<?=$rr_matches[$m]->Player2;?>' class='<?=$sel_class?>_<?=$tm_id;?>_<?=$rr_matches[$m]->Player2;?>'><!-- Team 2 Player Partner -->
<option value=''>Player</option>
<?php 
$get_reg_players1 = league::get_reg_team_players($tourn_id, $rr_matches[$m]->Player2);
$team1_players = json_decode($get_reg_players1['Team_Players']);
$get_users_bygender = league::get_users_bygender($team1_players, 'Women');

foreach($get_users_bygender as $player){
	  if(!in_array($player->Users_ID, ${'team2_block_players_'.$block_type}))
	  {
	$get_name	  = league::get_username($player->Users_ID); 
	$team1_player = $get_name['Firstname'] . "  " . $get_name['Lastname'];
?>
<option value='<?=$player->Users_ID;?>'><?=$team1_player;?></option>
<?php }
}?>
</select>
<?php } ?>

<?php if($line->Match_Type == 'Mixed'){ ?>
<select id='t2_p1_<?=$line_id;?>' name='<?=$rr_matches[$m]->Player2;?>' class='<?=$sel_class?>_<?=$tm_id;?>_<?=$rr_matches[$m]->Player2;?>'><!-- Team 2 Players -->
<option value=''>Player</option>
<?php 
$get_reg_players2	= league::get_reg_team_players($tourn_id, $rr_matches[$m]->Player2);
$team2_players		= json_decode($get_reg_players2['Team_Players']);
$get_users_bygender = league::get_users_bygender($team2_players, 'Men');

foreach($get_users_bygender as $player){
	  if(!in_array($player->Users_ID, ${'team2_block_players_'.$block_type}))
	  {
$get_name	  = league::get_username($player->Users_ID); 
$team2_player = $get_name['Firstname'] . "  " . $get_name['Lastname'];?>
<option value='<?=$player->Users_ID;?>'><?=$team2_player;?></option>
<?php }
}?>
</select>
<select id='t2_p1p_<?=$line_id;?>' name='<?=$rr_matches[$m]->Player2;?>' class='<?=$sel_class?>_<?=$tm_id;?>_<?=$rr_matches[$m]->Player2;?>'><!-- Team 2 Player Partner -->
<option value=''>Player</option>
<?php 
$get_reg_players2 = league::get_reg_team_players($tourn_id, $rr_matches[$m]->Player2);
$team2_players = json_decode($get_reg_players2['Team_Players']);
$get_users_bygender = league::get_users_bygender($team2_players, 'Women');
foreach($get_users_bygender as $player){
	  if(!in_array($player->Users_ID, ${'team2_block_players_'.$block_type}))
	  {
	$get_name	  = league::get_username($player->Users_ID); 
	$team2_player = $get_name['Firstname'] . "  " . $get_name['Lastname'];
?>
<option value='<?=$player->Users_ID;?>'><?=$team2_player;?></option>
<?php }
}?>
</select>
<?php } ?>


<?php if($line->Match_Type == 'OSingles'){ ?>
<select id='t2_p1_<?=$line_id;?>' name='<?=$rr_matches[$m]->Player2;?>' class='<?=$sel_class?>_<?=$tm_id;?>_<?=$rr_matches[$m]->Player2;?>'><!-- Team 2 Players -->
<option value=''>Player</option>
<?php 
$get_reg_players2 = league::get_reg_team_players($tourn_id, $rr_matches[$m]->Player2);
$team2_players = json_decode($get_reg_players2['Team_Players']);
$get_users_bygender = league::get_users_bygender($team2_players, 'Open');

foreach($get_users_bygender as $player){
	  if(!in_array($player->Users_ID, ${'team2_block_players_'.$block_type}))
	  {
$get_name	  = league::get_username($player->Users_ID); 
$team2_player = $get_name['Firstname'] . "  " . $get_name['Lastname'];?>
<option value='<?=$player->Users_ID;?>'><?=$team2_player;?></option>
<?php }
}?>
</select>
<?php } ?>

<?php if($line->Match_Type == 'ODoubles'){ ?>
<select id='t2_p1_<?=$line_id;?>' name='<?=$rr_matches[$m]->Player2;?>' class='<?=$sel_class?>_<?=$tm_id;?>_<?=$rr_matches[$m]->Player2;?>'><!-- Team 2 Players -->
<option value=''>Player</option>
<?php 
$get_reg_players2 = league::get_reg_team_players($tourn_id, $rr_matches[$m]->Player2);
$team2_players = json_decode($get_reg_players2['Team_Players']);
$get_users_bygender = league::get_users_bygender($team2_players, 'Open');

foreach($get_users_bygender as $player){
	  if(!in_array($player->Users_ID, ${'team2_block_players_'.$block_type}))
	  {
$get_name	  = league::get_username($player->Users_ID); 
$team2_player = $get_name['Firstname'] . "  " . $get_name['Lastname'];?>
<option value='<?=$player->Users_ID;?>'><?=$team2_player;?></option>
<?php }
}?>
</select>
<select id='t2_p1p_<?=$line_id;?>' name='<?=$rr_matches[$m]->Player2;?>' class='<?=$sel_class?>_<?=$tm_id;?>_<?=$rr_matches[$m]->Player2;?>'><!-- Team 2 Player Partner -->
<option value=''>Player</option>
<?php 
$get_reg_players1 = league::get_reg_team_players($tourn_id, $rr_matches[$m]->Player2);
$team1_players = json_decode($get_reg_players1['Team_Players']);
$get_users_bygender = league::get_users_bygender($team1_players, 'Open');

foreach($get_users_bygender as $player){
	  if(!in_array($player->Users_ID, ${'team2_block_players_'.$block_type}))
	  {
	$get_name	  = league::get_username($player->Users_ID); 
	$team1_player = $get_name['Firstname'] . "  " . $get_name['Lastname'];
?>
<option value='<?=$player->Users_ID;?>'><?=$team1_player;?></option>
<?php }
}?>
</select>
<?php } ?>
</td>
<td style="padding-left:15px;">
<?php
$match_date = strtotime(date('Y-m-d H:i:s',strtotime($rr_matches[$m]->Match_DueDate)));

//echo $now." ".$match_date;
$oneday	 = 86400;

if($now <= ($match_date + $oneday) or $this->is_super_admin){
?>
<a id='add_score' class='add_team_score' href='#reg_matches' name='<?=$line_id; ?>' style='text-decoration:none;' >Add Score</a>
<?php
}
?>
</td>
</tr>
<?php
}
else{								//If the Line Match having a score and result
	${'team1_block_players_'.$block_type}[] = $line->Player1;
	${'team2_block_players_'.$block_type}[] = $line->Player2;

 if(($line->Match_Type == 'MDoubles' or $line->Match_Type == 'WDoubles' or $line->Match_Type == 'ODoubles') and $line->Player1_Partner){
	${'team1_block_players_'.$block_type}[] = $line->Player1_Partner;
	${'team2_block_players_'.$block_type}[] = $line->Player2_Partner;
}

//print_r(${'team1_block_players_'.$block_type});

/*$team1_block_players[] = $line->Player1;
if($line->Player1_Partner){
	$team1_block_players[] = $line->Player1_Partner;
}
$team2_block_players[] = $line->Player2;
if($line->Player2_Partner){
	$team2_block_players[] = $line->Player2_Partner;
}*/


$get_user	  = league::get_username($line->Player1); 
$player1_user = "<a href='".base_url()."player/".$get_user['Users_ID']."' title='".$get_user['Mobilephone']."'>"
.$get_user['Firstname']." ".$get_user['Lastname']."</a>";

$get_user	  = league::get_username($line->Player2); 
$player2_user = "<a href='".base_url()."player/".$get_user['Users_ID']."' title='".$get_user['Mobilephone']."'>"
.$get_user['Firstname']." ".$get_user['Lastname']."</a>";

$get_user	  = league::get_username($line->Winner); 
$winner		  = "<a href='".base_url()."player/".$get_user['Users_ID']."' title='".$get_user['Mobilephone']."'>"
.$get_user['Firstname']." ".$get_user['Lastname']."</a>";


$player1_partner = '';
$player2_partner = '';

	if($line->Match_Type == 'WDoubles' or $line->Match_Type == 'MDoubles' 
	or $line->Match_Type == 'Mixed'	   or $line->Match_Type == 'ODoubles')
	{
		$get_user = league::get_username($line->Player1_Partner);
		if($get_user['Users_ID']){
			$player1_partner	  = "; <a href='".base_url()."player/".$get_user['Users_ID']."' title='".$get_user['Mobilephone']."'>"
			.$get_user['Firstname']." ".$get_user['Lastname']."</a>";
		}

		$get_user = league::get_username($line->Player2_Partner);
		if($get_user['Users_ID']){
			$player2_partner	  = "; <a href='".base_url()."player/".$get_user['Users_ID']."' title='".$get_user['Mobilephone']."'>"
			.$get_user['Firstname']." ".$get_user['Lastname']."</a>";
		}
	}
?>

<tr id="match_lines_<?=$tm_id;?>" class="match_lines_<?=$tm_id;?>" style="display:none;">
<td style="padding-left:15px;"><?php
 echo $line->Line_num." (".$label.")";?></td>
<td style="padding-left:15px;">
<?php
echo $player1_user.$player1_partner;
if($line->Winner == $line->Player1 and $line->Player1 != NULL){
	echo "<img id='img-winner' src='".base_url()."images/gold_medal_small.png' width='20' height='20' />";
}?>
</td>
<td style="padding-left:15px;">
<?php
echo $player2_user.$player2_partner;
if($line->Winner == $line->Player2 and $line->Player2 != NULL){
	echo "<img id='img-winner' src='".base_url()."images/gold_medal_small.png' width='20' height='20' />";
}?>
&nbsp;&nbsp;&nbsp;
<?php
if($line->Player1_Score !="[0]" and $line->Winner != NULL){

$p1=array();$p2=array();
$p1 = json_decode($line->Player1_Score);
$p2 = json_decode($line->Player2_Score);

$cnt = count(array_filter($p1));
$cnt2 = count(array_filter($p2));
	if($cnt > 0){
		for($i=0; $i<count(array_filter($p1)); $i++){
			echo "($p1[$i] - $p2[$i]) ";
		}
	}
	else if($cnt2 > 0){
		for($i=0; $i<count(array_filter($p2)); $i++){
			echo "($p1[$i] - $p2[$i]) ";
		}
	}

}
else if($line->Player1_Score =="[0]" and $line->Winner != NULL){
		echo "Win by Forfeit ";
}

?>
</td>
<td style="padding-left:15px;"><?php
if($tourn_admin == $this->logged_user){
		 echo "<a id='team_edit_score' class='team_edit_score' href='#reg_matches' name='".$line_id."' style='text-decoration:none;'>Delete Score</a></td>";
} ?></td>
</tr>
<?php
}?>
<!------------Win By forfeit-------------------->
<tr id="forfeit<?=$line_id; ?>" style="display:none;">
<td colspan='4'>
<!-- <form method="post" name="form-wff" action="<?php echo base_url();?>league/view_matches"> -->
 <form name="form-wff" id="form-wff<?=$line_id; ?>">
 <div class='form-group'>
	<div class='col-md-3 form-group internal'>
		<select id="win_ff_team<?=$line_id; ?>" name="win_ff_player" class='wff_sel form-control'></select> 
	</div>
</div>

</div>
	 <input class='form-control' value="TEAM_WFF" name="score_type" type='hidden' /> 
	 <input class='form-control' value="" id="wf_player1_user_<?=$line_id;?>"			name="player1_user"			type='hidden' />
	 <input class='form-control' value="" id="wf_player1_user_partner_<?=$line_id;?>"	name="player1_user_partner" type='hidden' />

	 <input class='form-control' value="" id="wf_player2_user_<?=$line_id;?>"			name="player2_user"			type='hidden' />
	 <input class='form-control' value="" id="wf_player2_user_partner_<?=$line_id;?>"	name="player2_user_partner"	type='hidden' />

	 <input class='form-control' value='<?=$rr_matches[$m]->Player1;?>' id="player1_team_<?=$line_id;?>" name="player1_team" type='hidden' />
	 <input class='form-control' value='<?=$rr_matches[$m]->Player2;?>' id="player2_team_<?=$line_id;?>" name="player2_team" type='hidden' />

	 <input class='form-control' value="<?php echo $rr_matches[$m]->Tourn_ID;?>"	id="tourn_id"		name="tourn_id"		type='hidden' />
	 <input class='form-control' value="<?php echo $rr_matches[$m]->BracketID;?>"	id="bracket_id"		name="bracket_id"	type='hidden' />
	 <input class='form-control' value="<?php echo $rr_matches[$m]->Match_Num;?>"	id="match_num"		name="match_num"	type='hidden' />
	 <input class='form-control' value="<?php echo $line->Match_Type;?>"			id="match_type"		name="match_type"	type='hidden' />
	 <input class='form-control' value="<?php echo $rr_matches[$m]->Tourn_match_id;?>" id="tourn_match_id" name="tourn_match_id" type='hidden' />
	 <input class='form-control' value="<?php echo $line_id;?>"						id="match_line_id" name="match_line_id" type='hidden' />
	 <input class='form-control' value="<?php echo $round;?>"						id="round_title"	name="round_title"	type='hidden' />
	 <input class='form-control' value="" id="" name="draw_name" type='hidden' />

<div class='form-group'>
	<div class='col-md-1 form-group internal'>
	 <input type="submit" name="team_rr_add_winner" id="<?=$line_id; ?>" value="Add Winner" class="wff_add league-form-submit1"/>
	</div>
</div>

</form>
</td>
</tr>

<!----------End of--Win By forfeit-------------------->

<!--  -------------  Add Score Section	---------------------	  -->

<tr id="score<?=$line_id; ?>" class="tourn_match" style="display:none;">
<td colspan='4'>
<div>

<form name="form-addscore" id="form-addscore<?=$line_id; ?>">

<div class='form-group'>

<div class='col-md-2 form-group internal'>
<input type="text" class='form-control' placeholder="Date" id="sdate<?=$line_id;?>" name="line_match_date" value="<?php echo date('m/d/Y');?>" required />
</div>

	<div class='form-group'>
	<div class='col-md-8 form-group internal scoretable-web'>

	<input type='checkbox' name="<?=$line_id;?>" id='wff_add' class='wff_score' />&nbsp;Declare winner by Win by Forfeit
	
		<?php $sport_id = $tour_details->SportsType; ?>
		<table class="score-cont">
		  <?php if($sport_id == 1){ ?>
		 <tr>
			<th>Players</th><th>Set1</th><th>Set2</th><th>Set3</th><th>Set4</th><th>Set5</th>
		 </tr> 
		 <?php } else{ ?>
		 <tr>
			<th>Players</th><th>Game1</th><th>Game2</th><th>Game3</th><th>Game4</th><th>Game5</th>
		 </tr> 
		  <?php } ?>

		 <tr>
			<td bgcolor="#fdd7b0"><b><div id='div_t1_p1_<?=$line_id;?>'></div></b></td>
			<td><input id='set1_1' name='player1[]' style = "width:65%" type='text' maxlength='2' /></td>
			<td><input id='set1_1' name='player1[]' style = "width:65%" type='text' maxlength='2' /></td>
			<td><input id='set1_1' name='player1[]' style = "width:65%" type='text' maxlength='2' /></td>
			<td><input id='set1_1' name='player1[]' style = "width:65%" type='text' maxlength='2' /></td>
			<td><input id='set1_1' name='player1[]' style = "width:65%" type='text' maxlength='2' /></td>
			<!-- <td><input id='set1_1' name='player1[]' style = "width:65%" type='text' maxlength='2' /></td> -->
		 </tr>
		 <tr>
			<td bgcolor="#fdd7b0"><b><div id='div_t2_p1_<?=$line_id;?>'></div></b></td>
			<td><input id='set1_2' name='player2[]' style = "width:65%" type='text' maxlength='2' /></td>
			<td><input id='set1_2' name='player2[]' style = "width:65%" type='text' maxlength='2' /></td>
			<td><input id='set1_2' name='player2[]' style = "width:65%" type='text' maxlength='2' /></td>
			<td><input id='set1_2' name='player2[]' style = "width:65%" type='text' maxlength='2' /></td>
			<td><input id='set1_2' name='player2[]' style = "width:65%" type='text' maxlength='2' /></td>
			<!-- <td><input id='set1_2' name='player2[]' style = "width:65%" type='text' maxlength='2' /></td> -->	
		 </tr>
		 </table> 
	
		</div>
		</div>

		 <!-- ---------------Mobile view------------------------------------------------------- -->
		<div class="scoretable-mob">
		<input type='checkbox' name="<?=$line_id; ?>" id='wff_add' class='wff_score' />&nbsp;
		Declare winner by Win by Forfeit

			<table class="score-cont">
					<tr>
						<th>Players</th>
						<th bgcolor="#fdd7b0"><b><div id='div_mob_<?=$line_id;?>'></div></b></th>
						<th bgcolor="#fdd7b0"><b><div id='div_mob_<?=$line_id;?>'></div></b></th>
						<?php 
							if($sport_id == 1){
							$set_or_game = 'Set';
							}
							else{
							$set_or_game = 'Game';
							}
						?>
				   </tr>
		  <tr>
			<td>
				<?php echo $set_or_game . "1"; ?>
			</td>
			<td><input id='set1_1' name='player1[]' style = "width:45%" type='text' maxlength='2' /></td>
			<td><input id='set1_2' name='player2[]' style = "width:45%" type='text' maxlength='2' /></td>
			</tr>
			<tr>
			<td>
				<?php echo $set_or_game . "2"; ?>
			</td>
			<td><input id='set2_1' name='player1[]' style = "width:45%" type='text' maxlength='2' /></td>
			<td><input id='set2_2' name='player2[]' style = "width:45%" type='text' maxlength='2' /></td>
			</tr>
			<tr>
			<td>
				<?php echo $set_or_game . "3"; ?>
			</td>
			<td><input id='set3_1' name='player1[]' style = "width:45%" type='text' maxlength='2' /></td>
			<td><input id='set3_2' name='player2[]' style = "width:45%" type='text' maxlength='2' /></td>
			</tr>
			<tr>
			<td>
				<?php echo $set_or_game . "4"; ?>
			</td>
			<td><input id='set4_1' name='player1[]' style = "width:45%" type='text' maxlength='2' /></td>
			<td><input id='set4_2' name='player2[]' style = "width:45%" type='text' maxlength='2' /></td>
			</tr>
			<tr>
			<td>
				<?php echo $set_or_game . "5"; ?>
			</td>
			<td><input id='set5_1' name='player1[]' style = "width:45%" type='text' maxlength='2' /></td>
			<td><input id='set5_2' name='player2[]' style = "width:45%" type='text' maxlength='2' /></td>
			</tr>

	 </table>
	</div>
			<!-- ---------------End of Mobile view------------------------------------------------------- -->

	 <input class='form-control' value="TEAM_ADDSCORE" name="score_type" type='hidden' /> 
	 <input class='form-control' value="" id="player1_user_<?=$line_id;?>"			name="player1_user"			type='hidden' />
	 <input class='form-control' value="" id="player1_user_partner_<?=$line_id;?>"	name="player1_user_partner" type='hidden' />

	 <input class='form-control' value="" id="player2_user_<?=$line_id;?>"			name="player2_user"			type='hidden' />
	 <input class='form-control' value="" id="player2_user_partner_<?=$line_id;?>"	name="player2_user_partner"	type='hidden' />

	 <input class='form-control' value='<?=$rr_matches[$m]->Player1;?>' id="player1_team_<?=$line_id;?>" name="player1_team" type='hidden' />
	 <input class='form-control' value='<?=$rr_matches[$m]->Player2;?>' id="player2_team_<?=$line_id;?>" name="player2_team" type='hidden' />

	 <input class='form-control' value="<?php echo $rr_matches[$m]->Tourn_ID;?>"	id="tourn_id"		name="tourn_id"		type='hidden' />
	 <input class='form-control' value="<?php echo $rr_matches[$m]->BracketID;?>"	id="bracket_id"		name="bracket_id"	type='hidden' />
	 <input class='form-control' value="<?php echo $rr_matches[$m]->Match_Num;?>"	id="match_num"		name="match_num"	type='hidden' />
	 <input class='form-control' value="<?php echo $line->Match_Type;?>"			id="match_type"		name="match_type"	type='hidden' />
	 <input class='form-control' value="<?php echo $rr_matches[$m]->Tourn_match_id;?>" id="tourn_match_id" name="tourn_match_id" type='hidden' />
	 <input class='form-control' value="<?php echo $line_id;?>"						id="match_line_id" name="match_line_id" type='hidden' />
	 <input class='form-control' value="<?php echo $round;?>"						id="round_title"	name="round_title"	type='hidden' />
	 <input class='form-control' value="" id="" name="draw_name" type='hidden' />

	<div class='form-group'>
	<div class='col-md-1 form-group internal'>
	 <input name="team_aad_rr_match_score" id="<?=$line_id; ?>" type="submit" value="Add" class="add_score_ajax league-form-submit" />
	</div>
	</div>

</form>
</div>
</td>
</tr>
<!-- End of Add Score Section -->

<?php 
} // Match Id If Condition
} // Line Matches For Loop 

?>
<!-- Lines Tables End here -->

<?php /* End of Table List of Matches section */ ?>

<?php
} // Close of Main for loop
} // Close of Else condition that check for empty entires or not
?>
</table>
<!-- List of Scheduled Matches Table End Here	 -->
</div>
<br /><br />
</div>
</div>