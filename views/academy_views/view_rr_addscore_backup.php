<script src="<?php echo base_url();?>js/jquery.accordion.js" type="text/javascript"></script>
<script type="text/javascript">
$(document).ready(function () {
$(function () {
"use strict";
$('.accordion').accordion({ defaultOpen: 'no_section' }); //some_id section1 in demoup_tour_section
});
});
</script>
<?php 
$tourn_id = $get_bracket_details['Tourn_ID'];
$rr_matches = $rr_bracket_matches->result();
?>

<div class="tab-content">
<table class="tab-score">

<tr class="top-scrore-table">
<td class="score-position" valign="center" align="center">Match#</td>
<?php if($match_type == "Doubles"){ ?>
<td class="score-position" valign="center" align="center">Team-1</td>
<td class="score-position" valign="center" align="center">Team-2</td>
<?php } else { ?>
<td class="score-position" valign="center" align="center">Player1</td>
<td class="score-position" valign="center" align="center">Player2</td>
<?php } ?>
<td class="score-position" valign="center" align="center">Score</td>
<td class="score-position" valign="center" align="center">Winner</td>
<td class="score-position" valign="center" align="center">Action</td>
</tr>

<?php
foreach($rr_matches as $m => $match){
$player1 = "";
$player2 = "";

	if($rr_matches[$m]->Player1 != 0){
		 $player1 = league::get_username(intval($rr_matches[$m]->Player1));
	}
	if($rr_matches[$m]->Player2 != 0){
		 $player2 = league::get_username(intval($rr_matches[$m]->Player2));
	}

	if($match_type == "Doubles"){
	$get_partner1 = league::get_username(intval($rr_matches[$m]->Player1_Partner));
	$get_partner2 = league::get_username(intval($rr_matches[$m]->Player2_Partner));
	}
?>
<tr>
<td valign="center" align="center" ><b>
<?php echo $rr_matches[$m]->Match_Num; ?>
</b></td>
<td valign="center" align="center" ><b>
<?php
	if($player1){ echo $player1['Firstname']." ".$player1['Lastname']; } else { echo "----"; }
	
	if($match_type == "Doubles"){
		echo "; ".$get_partner1['Firstname']." ".$get_partner1['Lastname']; } else { echo "----";
	}
?>
</b></td>
<td valign="center" align="center" ><b>
<?php
	if($player2){ echo $player2['Firstname']." ".$player2['Lastname']; } else { echo "----"; }

	if($match_type == "Doubles"){
		echo "; ".$get_partner2['Firstname']." ".$get_partner2['Lastname']; } else { echo "----"; 	}
?>
</b></td>

<td valign="center" align="center">
<div>
<?php 
if($rr_matches[$m]->Player1_Score !=""){
$p1=array();$p2=array();
$p1 = json_decode($rr_matches[$m]->Player1_Score);
$p2 = json_decode($rr_matches[$m]->Player2_Score);

$cnt = count(array_filter($p1));
if($cnt > 0)
	{
		for($i=0; $i<count(array_filter($p1)); $i++)
		{
			echo "($p1[$i] - $p2[$i]) ";
		}

	}
	else if($cnt == 0){
			echo "Win by Forfeit ";
	}
}		
?>
</div>  
</td>

<td valign="center" align="center">
<div class="" style="">
<?php
if($rr_matches[$m]->Winner !="")
{
	//$get_user = league::get_username($rr_matches[$m]->Winner);
	//echo $get_user['Firstname']." ".$get_user['Lastname'];
	$wn = ($rr_matches[$m]->Winner == $rr_matches[$m]->Player1) ? "Team-1" : "Team-2";
	echo $wn;
}
?>
</div>
</td>

<?php
$get = league::getonerow($rr_matches[$m]->Tourn_ID);
$tourn_admin = $get->Usersid;

if($rr_matches[$m]->Player1 != '' and  $rr_matches[$m]->Player2 != '')
{
if($tourn_admin ==  $this->session->userdata('users_id') and $rr_matches[$m]->Winner != '')
{
?>
<td valign="center" align="center">
<div>
<!-- <a id="add" class="add_score" href="#reg_matches" name="<?php echo $rr_matches[$m]->Tourn_match_id; ?>">Edit score</a> -->
<a id="edit" class="edit_score" href="#" name="<?php echo $rr_matches[$m]->Tourn_match_id; ?>">Edit score</a>

</div>
</td>
<?php
}
else if((($this->session->userdata('users_id') == $rr_matches[$m]->Player1) or ($this->session->userdata('users_id') == $rr_matches[$m]->Player2) or $tourn_admin == $this->session->userdata('users_id')) and ($rr_matches[$m]->Winner == ''))
{
?>
<td valign="center" align="center">
<div>
<a id="add" class="add_score" href="#reg_matches" name="<?php echo $rr_matches[$m]->Tourn_match_id; ?>">Add score</a> / <a id="wff_add" class="wff_score" href="#reg_matches" name="<?php echo $rr_matches[$m]->Tourn_match_id; ?>">Win by Forfeit</a>

</div>
</td>
<?php 
}
}
?>
<td></td>
</tr>


<!------------Win By forfeit-------------------->
<tr id="forfeit<?php echo $rr_matches[$m]->Tourn_match_id; ?>" style="display:none;">
<td colspan='6'>
<form method="post"  action="<?php echo base_url();?>league/view_matches">
<div class='form-group'>
	<div class='col-md-2 form-group internal'>

		<?php
		$get_name = league::get_username($rr_matches[$m]->Player1);

		$player1_name = $get_name['Firstname'] . "  " . $get_name['Lastname'];
		?>
		<?php 
		$get_name = league::get_username($rr_matches[$m]->Player2);
		 $player2_name =  $get_name['Firstname'] . "  " . $get_name['Lastname'];
		?>

		<select name="id" class='form-control'>

		<option value="<?php echo $rr_matches[$m]->Player1; ?>">
		<?php //echo $player1_name;
		echo "Team-1";
		?></option>

		<option value="<?php echo $rr_matches[$m]->Player2; ?>">
		<?php //echo $player2_name;
		echo "Team-2";
		?>	
	    </option>
		</select> 
	</div>
</div>

	  <input class='form-control' value="<?php echo $rr_matches[$m]->Tourn_ID;?>" id="tourn_id" name="tourn_id" type='hidden'> 
	  <input class='form-control' value="<?php echo $rr_matches[$m]->BracketID;?>" id="bracket_id" name="bracket_id" type='hidden'>
	  <input class='form-control' value="<?php echo $rr_matches[$m]->Match_Num;?>" id="match_num" name="match_num" type='hidden'> 
	  <input class='form-control' value="<?php echo $match_type;?>" id="match_type" name="match_type" type='hidden'> 
	  <input class='form-control' value="<?php echo $rr_matches[$m]->Tourn_match_id;?>" id="tourn_match_id" name="tourn_match_id" type='hidden'>

<div class='form-group'>
	<div class='col-md-1 form-group internal'>
	 <input type="submit" name="rr_add_winner" value="Add Winner" class="league-form-submit1"/>
	</div>
</div>

</form>
</td>
</tr>

<!----------End of--Win By forfeit-------------------->

<tr id="score<?php echo $rr_matches[$m]->Tourn_match_id; ?>" class="tourn_match" style="display:none;">
<td colspan='6'>
<div>

<form method="post"  action="<?php echo base_url();?>league/view_matches">
	<div class='form-group'>
	<div class='col-md-2 form-group internal'>
<input  type="text" class='form-control' placeholder="Date" id="sdate<?php echo $rr_matches[$m]->Tourn_match_id; ?>" name="tour_match_date" required /> 
	</div>
<script>
$(function() {
	var spid = "<?php echo $rr_matches[$m]->Tourn_match_id; ?>";
 $('#sdate'+spid).datepick();
});
</script>

	<div class='form-group'>
	<div class='col-md-6 form-group internal'>
		<?php
		$get_name = league::get_username($rr_matches[$m]->Player1); 
		$player1_name = $get_name['Firstname']." ".$get_name['Lastname'];
		?>
		<?php 
		$get_name = league::get_username($rr_matches[$m]->Player2);
		$player2_name =  $get_name['Firstname']." ".$get_name['Lastname'];
		?>
		<?php 
		$get_sport = league::getonerow($tourn_id);
		$sport_id = $get_sport->SportsType;
		 //$name = league::get_sport($sport_id);
		 //$sport_name =  $name['sportname'];
		?>
			  <table class="score-cont">
								<?php if($sport_id == 1){ ?>
								  <tr>
                                  	<th>Players</th>
									<th>Set1</th>
                                  	<th>Set2</th>
                                  	<th>Set3</th>
                                  	<th>Set4</th>
                                    <th>Set5</th>
									<th>Set6</th>
                                 </tr> 
								 <?php } else { ?>
								 <tr>
                                  	<th>Players</th>
									<th>Game1</th>
                                  	<th>Game2</th>
                                  	<th>Game3</th>
                                  	<th>Game4</th>
                                    <th>Game5</th>
									<th>Game6</th>
                                 </tr> 
								  <?php } ?>
									
                                 <tr>
                                  	<td bgcolor="#fdd7b0"><b><?php echo "Team-1"; //echo $player1_name; ?></b></td>
									<td><input id='set1_1' name='player1[]' style = "width:65%" type='text' maxlength='2' /></td>
                                  	<td><input id='set1_1' name='player1[]' style = "width:65%" type='text' maxlength='2' /></td>
									<td><input id='set1_1' name='player1[]' style = "width:65%" type='text' maxlength='2' /></td>
									<td><input id='set1_1' name='player1[]' style = "width:65%" type='text' maxlength='2' /></td>
                                    <td><input id='set1_1' name='player1[]' style = "width:65%" type='text' maxlength='2' /></td>
									<td><input id='set1_1' name='player1[]' style = "width:65%" type='text' maxlength='2' /></td>
								 </tr>
                                  <tr>
                                  	<td bgcolor="#fdd7b0"><b><?php echo "Team-2"; //echo $player2_name; ?></b></td>
									<td><input id='set1_2' name='player2[]' style = "width:65%" type='text' maxlength='2' /></td>
                                  	<td><input id='set1_2' name='player2[]' style = "width:65%" type='text' maxlength='2' /></td>
									<td><input id='set1_2' name='player2[]' style = "width:65%" type='text' maxlength='2' /></td>
									<td><input id='set1_2' name='player2[]' style = "width:65%" type='text' maxlength='2' /></td>
                                    <td><input id='set1_2' name='player2[]' style = "width:65%" type='text' maxlength='2' /></td>
									<td><input id='set1_2' name='player2[]' style = "width:65%" type='text' maxlength='2' /></td>
								 </tr>
      </table> 

	</div>
	</div>
	 <input class='form-control' value="<?php echo $rr_matches[$m]->Player1;?>" id="player1_user" name="player1_user" type='hidden'> 
	 <input class='form-control' value="<?php echo $rr_matches[$m]->Player2; ?>" id="player2_user" name="player2_user" type='hidden'> 
	 <input class='form-control' value="<?php echo $rr_matches[$m]->Tourn_ID;?>" id="tourn_id" name="tourn_id" type='hidden'> 
	 <input class='form-control' value="<?php echo $rr_matches[$m]->BracketID;?>" id="bracket_id" name="bracket_id" type='hidden'>
	 <input class='form-control' value="<?php echo $rr_matches[$m]->Match_Num;?>" id="match_num" name="match_num" type='hidden'> 
	 <input class='form-control' value="<?php echo $match_type; ?>" id="match_type" name="match_type" type='hidden'> 
	 <input class='form-control' value="<?php echo $rr_matches[$m]->Tourn_match_id; ?>" id="tourn_match_id" name="tourn_match_id" type='hidden'>

	<div class='form-group'>
	<div class='col-md-1 form-group internal'>
	 <input name="add_rr_match_score" type="submit" value="Add" class="league-form-submit"/>
	</div>
	</div>
</form>
</div>
</td>
</tr>

<?php 
}
?>
</table>
</div>

<!-- Player standing points section start -->

<div class="col-md-12 league-form-bg" style="margin-top:40px; margin-bottom:20px;">
<div class="accordion"  id="up_match_section"  style="background:#f59123; padding:5px; color:white;"><i class="fa fa-arrow-circle-o-right" style="color:white;"> </i>Player Standings<span></span></div>
<?php
$rr_matches2 = $rr_bracket_matches->result();
$list_players = array();

foreach($rr_matches2 as $m2 => $match2){

if(!in_array($rr_matches2[$m2]->Player1, $list_players))
	{	$list_players[] = $rr_matches2[$m2]->Player1."-".$rr_matches2[$m2]->Player1_Partner; }

if(!in_array($rr_matches2[$m2]->Player2, $list_players))
	{	$list_players[] = $rr_matches2[$m2]->Player2."-".$rr_matches2[$m2]->Player2_Partner; }
}

$num_matches = count($list_players) - 1;
?>
<div class="tab-content">

<table class="tab-score">
<tr class="top-scrore-table">
<td class="score-position" valign="center" align="center">Team</td>
<?php
for($i = 1;$i <= $num_matches; $i++)
{
	echo "<td class='score-position' valign='center' align='center'>Match $i</td>";	
}
?>
<!--
<td class="score-position" valign="center" align="center">Match 1</td>
<td class="score-position" valign="center" align="center">2</td>
<td class="score-position" valign="center" align="center">3</td>
<td class="score-position" valign="center" align="center">4</td>
<td class="score-position" valign="center" align="center">5</td>
<td class="score-position" valign="center" align="center">6</td>
-->
<td class="score-position" valign="center" align="center">Total</td>
</tr>
<?php
foreach($list_players as $player)
{
	$tot_p = 0;
?>
<tr>
<td align="left">&nbsp;
<?php
		$get_players = explode("-", $player);

		$get_name = league::get_username($get_players[0]);
		$get_name_partner = league::get_username($get_players[1]);
		echo $get_name['Firstname']." ".$get_name['Lastname']."; ".$get_name_partner['Firstname']." ".$get_name_partner['Lastname'];
?>
</td>
	<?php
	foreach($rr_matches2 as $m2 => $match2){
		if($rr_matches2[$m2]->Player1 == $player or $rr_matches2[$m2]->Player2 == $player){
				if($rr_matches2[$m2]->Player1 == $player) { 
					//($rr_matches2[$m2]->Player1_points != "NULL") ? $p = $rr_matches2[$m2]->Player1_points : $p = "-";
						echo "<td align='center'>".$rr_matches2[$m2]->Player1_points."</td>";
						$tot_p += $rr_matches2[$m2]->Player1_points;
				} 
				else { 
					//($rr_matches2[$m2]->Player2_points != "NULL") ? $p1 = $rr_matches2[$m2]->Player2_points : $p1 = "-";
						echo "<td align='center'>".$rr_matches2[$m2]->Player2_points."</td>"; 
						$tot_p += $rr_matches2[$m2]->Player2_points;
				} 
		}
	}
	?>
<td align='center'><?php echo $tot_p; ?></td>
</tr>
<?php
}
?>
</table>
</div>
</div>
<!-- End of Player Standing points section -->