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
else if($line->Match_Type == 'mixed'){
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
//echo $logged_user;
//echo $tourn_admin;

if(($line->Winner == NULL or $line->Winner == 0 or $line->Winner == "") and ($player1['Captain'] == $logged_user or $player2['Captain'] == $logged_user or $tourn_admin == $logged_user)){
?>
<tr id="match_lines_<?=$tm_id;?>" class="match_lines_<?=$tm_id;?>" style="display:none;">

<td style="padding-left:15px;"><?php echo $line->Line_num." (dd".$label.")";?></td>
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
<?php
}
?>
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

<?php if($line->Match_Type == 'OSingles'){
?>
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
<?php
}?>

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
<?php
}?>

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
<a id='add_score' class='add_team_score' href='#reg_matches' name='<?=$line_id; ?>' style='text-decoration:none;' >Add Score</a></td>
</tr>
<?php
}
else{								//If the Line Match having a score and result
	${'team1_block_players_'.$block_type}[] = $line->Player1;
	${'team2_block_players_'.$block_type}[] = $line->Player2;

 if(($line->Match_Type == 'Doubles' or $line->Match_Type == 'ODoubles') and $line->Player1_Partner){
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

	if($line->Match_Type == 'Doubles' or $line->Match_Type == 'ODoubles' or $line->Match_Type == 'Mixed')
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
	echo "<img id='img-winner' src='".base_url()."images/gold_medal_small.png' width='20' height='20'></img>";
}?>
</td>
<td style="padding-left:15px;">
<?php
echo $player2_user.$player2_partner;
if($line->Winner == $line->Player2 and $line->Player2 != NULL){
	echo "<img id='img-winner' src='".base_url()."images/gold_medal_small.png' width='20' height='20'></img>";
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
}

$data['line_id']	  = $line_id;
$data['round']		  = $round;
$data['rr_matches']	  = $rr_matches;
$data['line']		  = $line;
$data['m']			  = $m;
$data['tourn_id']	  = $tourn_id;
$data['tour_details'] = $tour_details;

$this->load->view('scores/add_score', $data);
$this->load->view('scores/add_wff', $data);

} // Match Id If Condition
} // Line Matches For Loop 

?>

<!-- Lines Tables End here -->