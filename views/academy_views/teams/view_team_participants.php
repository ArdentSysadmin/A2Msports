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

<script>
/* ------------------------- Collapse and Expand in Participants ---------------------- */
/* ------------------------- Collapse and Expand in Participants ---------------------- */
</script>

<div class='col-md-8'>
<br /><br />
<div id="participants-users" style=" margin: auto;overflow-y: scroll;overflow-x: scroll;height:500px;width: auto;">
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
<th style="padding-left:30px;">&nbsp;</th>
</tr>

<?php
foreach($tourn_reg_teams as $name)
{
?>
<tr>
<td></td>
<td style="padding-left:40px;">
<?php
$team = league::get_team($name->Team_id);

echo "<div class='header'><span style='color:blue;font-size:13px;font-weight:400;'>".$team['Team_name']."</span></div><div class='content'><ul>";

$tour_team_players = json_decode($name->Team_Players);
foreach($tour_team_players as $tp){
	$player = league::get_username($tp);
	$captain_ico = '';
	if($tp == $team['Captain']){ $captain_ico = "<img src='".base_url()."icons/letter_c.png' title='Captain' style='width:15px; height:15px;' />"; }

	echo "<li style='padding-left:25px;padding-bottom:5px;list-style:none;'>
	<a href='".base_url()."player/".$player['Users_ID']."' target='_blank'>".$player['Firstname']." ".$player['Lastname']."</a>
	&nbsp;{$captain_ico}</li>";
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

<td style="padding-left:40px;">
<?php
$is_tourn_player = league::is_tourn_reg_player($tour_details->tournament_ID);
if(!$is_tourn_player){
?>
<input name="join_submit" id="<?=$name->Team_id;?>" type="button" value="Request Join" class="league-form-submit join_submit" style="margin-bottom:2px;"/>
<div id="join_err_<?=$name->Team_id;?>" style='color:red'></div>
<?php
} ?>
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
</div>
</div>