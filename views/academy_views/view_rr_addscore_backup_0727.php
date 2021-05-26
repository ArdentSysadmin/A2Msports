<script src="<?php echo base_url();?>js/jquery.accordion.js" type="text/javascript"></script>
<script type="text/javascript">
	$(document).ready(function () {
	$(function () {
	"use strict";
	$('.accordion').accordion({ defaultOpen: 'no_section' }); //some_id section1 in demoup_tour_section
	});
	});
</script>

<script>
$(document).ready(function(){
var baseurl = "<?php echo base_url();?>";

$('.add_score').on('click',function(){

	if($("#score").css('display')=='none'){
	$("#score").show();
	//$("#forfeit"+pid).hide();
	}


var tab_row_id = $(this).attr('name');

if(tab_row_id!=""){
$.ajax({
type:'POST',
url:baseurl+'league/get_tour_row_info/',
data:{ row_id:tab_row_id},
success:function(html){

 var res = html.split('#');

	$('#tourn_match_id').val(res[0]);
	$('#bracket_id').val(res[1]);

	$('#tournid').val(res[2]);
	$('#match_num').val(res[4]);

	$('#player1_user').val(res[5]);
	$('#player2_user').val(res[6]);

	if(res[12] || res[13]){
		var p1= res[10]+"; "+res[12];
		var p2= res[10]+"; "+res[13];
		$('#player1_name').html(p1);
		$('#player2_name').html(p2);
	}else{
		$('#player1_name').html(res[10]);
		$('#player2_name').html(res[11]);
	}
}
}); 
}

});


$('.hide_score').on('click',function(){

	if($("#score").css('display')!='none'){
	$("#score").hide();
	//$("#forfeit"+pid).hide();
	}
});

});
</script>

<?php 
$tourn_id = $get_bracket_details['Tourn_ID'];
$rr_matches = $rr_bracket_matches->result();

$players = array();
foreach($rr_matches as $m => $match){

	if(!in_array($rr_matches[$m]->Player1, $players)){
		$players[] = $rr_matches[$m]->Player1;
		$players_partners[$rr_matches[$m]->Player1] = $rr_matches[$m]->Player1_Partner;
	}

	if(!in_array($rr_matches[$m]->Player2, $players)){
		$players[] = $rr_matches[$m]->Player2;
		$players_partners[$rr_matches[$m]->Player2] = $rr_matches[$m]->Player2_Partner;
	}

}
//echo "<pre>";
//print_r($players);

//echo "<pre>";
//print_r($players_partners);
//exit;
?>
   
<div class='tab-content'>
<table class='tab-score'>
<tr class='top-scrore-table'>
<td>Team</td>
<?php
for($i=1; $i<=(count($players)-1); $i++)
{ ?>
<td>Match-<?=$i;?></td>
<?php
}
?>
</tr>
<?php
foreach($players as $player){

	$pl_name = league::get_username(intval($player));
	echo "<tr><td style='padding:5px'><b>$pl_name[Firstname] $pl_name[Lastname]";
	if($players_partners[$player]){
	$pl_part_name = league::get_username(intval($players_partners[$player]));
	echo "; $pl_part_name[Firstname] $pl_part_name[Lastname]";
	}
	echo "</b></td>";

	foreach($rr_matches as $m => $match){

	$p1=array();
	$p2=array();

	if($player == $rr_matches[$m]->Player1)
	{
		$player1 = league::get_username(intval($rr_matches[$m]->Player2));
		if($rr_matches[$m]->Player1_Score !=""){
		$p1 = json_decode($rr_matches[$m]->Player1_Score);
		$p2 = json_decode($rr_matches[$m]->Player2_Score);
		}
	echo "<td style='padding:5px'>";
		echo "<div>$player1[Firstname] $player1[Lastname]";
		if($rr_matches[$m]->Player2_Partner){
			$player1_partner = league::get_username(intval($rr_matches[$m]->Player2_Partner));
			echo "; $player1_partner[Firstname] $player1_partner[Lastname]";
		}
		echo "</div>";

		$cnt = count(array_filter($p1));
		if($cnt > 0){

			if($player == $rr_matches[$m]->Winner){ $points = 3; } else { $points = 0; }
			echo "<div>";
			echo "Points: $points";
			echo "</div>";

			echo "<div>";
			for($i=0; $i<count(array_filter($p1)); $i++)
			{
				echo "($p1[$i]-$p2[$i]) ";
			}
			echo "</div>";
		}
		else if($cnt == 0){
			$tm_id = $rr_matches[$m]->Tourn_match_id;
			echo "<div><a id='add' class='add_score' href='#reg_matches' name='$tm_id'>Add Score</a></div>";
		}
	echo "</td>";
	}
	else if($player == $rr_matches[$m]->Player2)
	{
		$player1 = league::get_username(intval($rr_matches[$m]->Player1));
		if($rr_matches[$m]->Player1_Score !=""){
			$p1 = json_decode($rr_matches[$m]->Player2_Score);
			$p2 = json_decode($rr_matches[$m]->Player1_Score);
		}
	echo "<td style='padding:5px'>";
		echo "<div>$player1[Firstname] $player1[Lastname]";

		if($rr_matches[$m]->Player1_Partner){
			$player1_partner = league::get_username(intval($rr_matches[$m]->Player1_Partner));
			echo "; $player1_partner[Firstname] $player1_partner[Lastname]";
		}
		echo "</div>";


		$cnt = count(array_filter($p1));
		if($cnt > 0){

			if($player == $rr_matches[$m]->Winner){ $points = 3; } else { $points = 0; }
			echo "<div>";
			echo "Points: $points";
			echo "</div>";

			echo "<div>";
			for($i=0; $i<count(array_filter($p1)); $i++)
			{
				echo "($p1[$i]-$p2[$i]) ";
			}
			echo "</div>";

		}
		else if($cnt == 0){
			$tm_id = $rr_matches[$m]->Tourn_match_id;
			echo "<div><a id='add' class='add_score' href='#reg_matches' name='$tm_id'>Add Score</a></div>";
		}
	echo "</td>";
	}
	}	// End of Foreach $rr_matches
	echo "<td></td>";
echo "</tr>";
?>



<?php
}	// End of Foreach $players
?>

<!-- Add Score div block section starts here -->

<tr id="score<?php //echo $tm_id; ?>" class="tourn_match" style="display:none;">
<td colspan='5'>
<div>

<form method="post"  action="<?php echo base_url();?>league/view_matches">
	<div class='form-group'>
	<div class='col-md-2 form-group internal'>
<input  type="text" class='form-control' placeholder="Date" id="sdate<?php //echo $rr_matches[$m]->Tourn_match_id; ?>" name="tour_match_date" required /> 
	</div>
<script>
$(function() {
	//var spid = "<?php echo $rr_matches[$m]->Tourn_match_id; ?>";
 $('#sdate').datepick();
});
</script>

	<div class='form-group'>
	<div class='col-md-8 form-group internal'>
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
		<td bgcolor="#fdd7b0"><b><p id='player1_name'></p></b></td>
		<td><input id='set1_1' name='player1[]' style = "width:65%" type='text' maxlength='2' /></td>
		<td><input id='set1_1' name='player1[]' style = "width:65%" type='text' maxlength='2' /></td>
		<td><input id='set1_1' name='player1[]' style = "width:65%" type='text' maxlength='2' /></td>
		<td><input id='set1_1' name='player1[]' style = "width:65%" type='text' maxlength='2' /></td>
		<td><input id='set1_1' name='player1[]' style = "width:65%" type='text' maxlength='2' /></td>
		<td><input id='set1_1' name='player1[]' style = "width:65%" type='text' maxlength='2' /></td>
	 </tr>
	  <tr>
		<td bgcolor="#fdd7b0"><b><p id='player2_name'></p></b></td>
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
	 <input class='form-control' value="" id="player1_user" name="player1_user" type='hidden'> 
	 <input class='form-control' value="" id="player2_user" name="player2_user" type='hidden'> 
	 <input class='form-control' value="" id="tournid" name="tourn_id" type='hidden'> 
	 <input class='form-control' value="" id="bracket_id" name="bracket_id" type='hidden'>
	 <input class='form-control' value="" id="match_num" name="match_num" type='hidden'> 
	 <input class='form-control' value="<?php echo $match_type; ?>" id="match_type" name="match_type" type='hidden'> 
	 <input class='form-control' value="" id="tourn_match_id" name="tourn_match_id" type='hidden'>

	<div class='form-group'>
	<div class='col-md-1 form-group internal'>
	 <input name="add_rr_match_score" type="submit" value="Add" class="league-form-submit"/>
	</div>	
	<div>
	 <a style='float:right;margin-right:40px;cursor:pointer' id='hide' class='hide_score'>Hide</a>
	</div>
	</div>
</form>
</div>
</td>
</tr>

<!-- Add Score div block section starts here -->
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
	echo "<td class='score-position' valign='center' align='center'>Match $i&nbsp;&nbsp;</td>";	
}
?>
<td class="score-position" valign="center" align="center">Total&nbsp;&nbsp;</td>
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
		echo "<b>".$get_name['Firstname']." ".$get_name['Lastname'];
		
		if($get_name_partner){
			echo "; $get_name_partner[Firstname] $get_name_partner[Lastname]";
		}
		echo "</b>";
	
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