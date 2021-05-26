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

<form method="post" name='frm_participants' id="frm_participants"  action="<?php echo base_url(); ?>league/adm_withdraw_teams" class="register-form" novalidate> 

<div class='col-md-8'>
<br /><br />

<div class="container2">

<table class="tab-score">
<?php 
$tourn_reg_teams = league::get_reg_tourn_participants($tour_details->tournament_ID);
if(count(array_filter($tourn_reg_teams)) > 0) {
?>
<tr class="top-scrore-table">
<!-- <th width="5%" class="score-position">Select</th> -->
<th width=""></th>
<th style="padding-left:40px;">Team</th>
<th style="padding-left:20px;">Level</th>
<th style="padding-left:20px;">Home Location</th>
</tr>
<?php
foreach($tourn_reg_teams as $name)
{
?>
<tr>
<td>
<input type="checkbox" name="sel_team[]" class="checkbox1" value="<?php echo $name->Team_id;?>" style="margin-left:10px" />
</td>
<td style="padding-left:40px;">
<?php
$team = league::get_team($name->Team_id);


echo "<div class='header'><span style='color:blue;font-size:13px;font-weight:400;'>".$team['Team_name']."</span></div><div class='content'><ul>";

$tour_team_players = json_decode($name->Team_Players);
foreach($tour_team_players as $tp){

	if($tour_details->Tournamentfee == 1 and $tour_details->Fee_collect_type == 'Player'){
		$is_player_paid = league::check_is_player_paid($tp, $tour_details->tournament_ID, $name->Team_id);
	}
	$player = league::get_username($tp);

	$paid_ico	 = '';
	$captain_ico = '';

	if($tp == $team['Captain']){ 
		$captain_ico = "<img src='".base_url()."icons/letter_c.png' title='Captain' style='width:15px; height:15px;' />"; 
	}
	if(!empty($is_player_paid) and $is_player_paid['Transaction_id']){ 
		$paid_ico = "<img src='".base_url()."icons/letter_p.png' title='$".number_format($is_player_paid['Amount'],2)." Paid' style='width:21px; height:21px;' />"; 
	}

	echo "<li style='padding-left:25px;padding-bottom:5px;list-style:none;'>
	<a href='".base_url()."player/".$player['Users_ID']."' target='_blank'>".$player['Firstname']." ".$player['Lastname']."</a>
	&nbsp;{$captain_ico}&nbsp;{$paid_ico}</li>";
}

echo "</ul></div>";
?>
</td>
<td style="padding-left:20px;">
<?php
if($name->Reg_Sport_Level != "")
{
$get_level = league::get_level_name($tour_details->SportsType, $name->Reg_Sport_Level);
echo $get_level['SportsLevel']; 
}
?>
</td>
<td style="padding-left:20px;">
<?php
if($team['Home_loc_id']){
$team_home_loc = league::get_home_location($team['Home_loc_id']);

$map_url = "https://www.google.co.in/maps/place/".$team_home_loc['hcl_address']."+".$team_home_loc['hcl_city']."+".$team_home_loc['hcl_state']."+".
		$team_home_loc['hcl_country'];

echo "<a href='".$map_url."' title='".$team_home_loc['hcl_address'].", ".$team_home_loc['hcl_city'].", ".$team_home_loc['hcl_state'].", ".$team_home_loc['hcl_country']."' target='_blank'>".$team_home_loc['hcl_title']."</a>";
}else{
echo "< None >";
}
?>
</td>

</tr>
<?php 
}
}
else {
?>
<tr><td colspan='6'><b>No Teams are registered yet. </b></td></tr>
<?php } ?>
</table>
</div>
<?php
if(count(array_filter($tourn_reg_teams)) > 0) {
?>
<div>
<br />
<input type="submit" id="withdraw_team" name="withdraw_team" value="Withdraw Team" class="league-form-submit" style="" />

</div>
<?php
}
?>
<!-- </div> -->
<input type='hidden' name='tourn_id' id="tourn_id" value="<?php echo $tour_details->tournament_ID; ?>">
<input type='hidden' name='tourn_type' value = "<?php echo $tour_details->Tournament_type; ?>">

</div>
</form>