<link href="<?php echo base_url();?>css/minislide/flexslider.css" rel="stylesheet" type="text/css" />
<link href="<?php echo base_url();?>css/component.css" rel="stylesheet" type="text/css" />
<link href="<?php echo base_url();?>css/prettyPhoto.css" rel="stylesheet" type="text/css" />
<link href="<?php echo base_url();?>css/style_dir.css" rel="stylesheet" type="text/css" />

<link href="<?php echo base_url();?>css/responsive.css" rel="stylesheet" type="text/css" />
<link href="<?php echo base_url();?>css/animate.css" rel="stylesheet" type="text/css" />
<link href="<?php echo base_url();?>css/tabs.css" rel="stylesheet" type="text/css" />
<link href="<?php echo base_url(); ?>css/jquery.datepick.css" rel="stylesheet" type="text/css" />
<link href="<?php echo base_url();?>css/jquery.autocomplete.css" rel="stylesheet" type="text/css" />

<link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
<?php
$total_rounds	= $get_bracket['No_of_rounds'];
$bracket_id		= $get_bracket['BracketID'];
$tour_id		= $get_bracket['Tourn_ID'];
$draw_type		= $get_bracket['Bracket_Type'];
?>

<?php
if($get_bracket['No_of_rounds']){
	$css_num = $get_bracket['No_of_rounds'];
?>
<link rel="stylesheet" href="<?php echo base_url();?>css/grids/grid_<?=$css_num;?>.css">
<?php
}
 
$title = league::getonerow($tour_id);
?>
<!-- <div style="padding-left:10px; float:left" class='col-md-4'>
<a href="<?php //echo base_url();?>"><img src="<?php //echo base_url();?>images/logo.png" alt="" ></a>
<br />
<br />
<br />

</div> -->
<div style='padding-left:180px; padding-top:20px; float:left'><p style='font-size:18px'>
<b><?php echo $title->tournament_title." (". $get_bracket['Draw_Title'].")"; ?></b></p></div> 
<section id="login" class="container secondary-page">  

<!-- LOGIN BOX -->
<div class="top-score-title right-score col-md-12">
<!-- <h3><?php echo $title->tournament_title; ?></h3>
 -->
<div class="col-md-12">
<div class="general water-mark">
<div class="brackets" id="brackets">
<?php
if($draw_type == 'Round Robin'){
?>
<!-- ---------------------------------------------- Round Robin -------------------------------------- -->

<?php
$rr_matches = $get_rr_tourn_matches->result();
//$tourn_id = $get_bracket_details['Tourn_ID'];

$teams			= array();
$play_by_dates  = array();
$r =0;
foreach($rr_matches as $m => $match){
	if(!in_array($rr_matches[$m]->Player1, $teams)){
		$teams[] = $rr_matches[$m]->Player1;
	}

	if(!in_array($rr_matches[$m]->Player2, $teams)){
		$teams[] = $rr_matches[$m]->Player2;
	}

	if($rr_matches[($m+1)]->Round_Num != $rr_matches[$m]->Round_Num){
		$r = $rr_matches[$m]->Round_Num;
		$play_by_dates[$r] = $rr_matches[$m]->Match_DueDate;
	}
}
/*echo "<pre>";
print_r($play_by_dates);
exit;*/

?>
<div class='tab-content'>
<div class="col-md-12">
<? //--------------------------------------------------------------------------------------------------------------- ?>

<table class='tab-score'>
<?php
$round =0;
$match_num = 1;

foreach($rr_matches as $m=>$rrm){   // Main for loop
	
  if($round != $rr_matches[$m]->Round_Num){
	$round = $rr_matches[$m]->Round_Num;
?>

<tr class='top-scrore-table'>
<!-- <td align='center'>S.No. #</td> -->
<td align='center'>Date</td>

<td align='center' colspan='2'>Match <?=$rr_matches[$m]->Round_Num;?>
<?php 
if($play_by_dates[$round]){

 $split_date = explode(" ",$play_by_dates[$round]);
 $date1 = ($split_date[1] != "00:00:00.000" and $split_date[1] != "") ?
 date("m/d/Y h:i A", strtotime($play_by_dates[$round])) : date("m/d/Y", strtotime($play_by_dates[$round]));

echo "&nbsp;&nbsp;&nbsp;&nbsp;(Play by: ".$date1.")"; 

} ?></td>
<td align='center'>Points</td></tr>
<!-- <tr align='center'><td><b>Player 1 / Team 1</b></td><td><b>Player 2 / Team 2</b></td><td>&nbsp;</td></tr> -->
<?php
	}
$player1 = league::get_team(intval($rr_matches[$m]->Player1));
$player2 = league::get_team(intval($rr_matches[$m]->Player2));

$p1_part = "";
$p2_part = "";

$tm_id = $rr_matches[$m]->Tourn_match_id;

$winner_medal	= "";
$get_homeloc	= "";
$loc_icon1		= "";
$loc_icon2		= "";
?>
<tr align='center'>
<!-- <td align='center'><?php echo $match_num; ?></td> -->
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
	<td><?php
	if($rr_matches[$m]->Winner == $rr_matches[$m]->Player1){
		$winner_medal	= "<img id='img-winner' src='".base_url()."images/gold_medal_small.png' width='20' height='20'></img>";
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
	?>
	</td>

	<td style='font-weight:normal'><?php
	if($rr_matches[$m]->Winner == $rr_matches[$m]->Player2){
		$winner_medal	= "<img id='img-winner' src='".base_url()."images/gold_medal_small.png' width='20' height='20'></img>";
	}
	echo ucfirst($player2['Team_name'])."</a>"." ".$loc_icon2.$winner_medal; ;
	?>
	</td>
	 <td>
	 <?php if($rr_matches[$m]->Winner != "" and $rr_matches[$m]->Winner != 'NULL') {
		echo $rr_matches[$m]->Player1_points." - ".$rr_matches[$m]->Player2_points;
	 }
	 else {
		echo '0 - 0';		 
	 }?>
	 </td>
</tr>

<?php
$match_num++;
} // End of Main For loop
?>
</table>


<!-- Team standing points section start -->

<div class="col-md-12 league-form-bg" style="margin-top:40px; margin-bottom:20px;">
<div class="accordion"  id="up_match_section"  style="background:#f59123; padding:5px; color:white;"><i class="fa fa-arrow-circle-o-right" style="color:white;"> </i>Standings<span></span></div>
<?php
$num_matches = count($teams) - 1;
?>
<div class="tab-content table-responsive">

<table class="tab-score">
<tr class="top-scrore-table">
<td class="score-position" valign="center" align="center">Team</td>
<?php
for($i = 1;$i <= $num_matches; $i++){
	echo "<td class='score-position' valign='center' align='center'>Match $i&nbsp;&nbsp;</td>";	
}
?>
<td class="score-position" valign="center" align="center">Total&nbsp;&nbsp;</td>
<!-- <td class="score-position" valign="center" align="center">Win%&nbsp;&nbsp;</td>
 --></tr>
<?php
//print_r($rr_matches2);
//exit;	
foreach($teams as $player){
	$tot_p = 0;
	$player_tot_score = 0;
	$p1p2_tot_score = 0;

	foreach($rr_matches as $m2 => $match2){
		if($rr_matches[$m2]->Player1 == $player or $rr_matches[$m2]->Player2 == $player){

		$p1_sum	= 0;
		$p2_sum = 0;
		$p1		= array();
		$p2		= array();

				if($rr_matches[$m2]->Player1 == $player) { 
						$tot_p += intval($rr_matches[$m2]->Player1_points);
				/*  Win percentage calculation for player when he is listed as PLAYER1 for that match*/

				$p1 = json_decode($rr_matches[$m2]->Player1_Score);  

				$cnt1 = count(array_filter($p1));

				if($cnt1 > 0){
					for($i=0; $i<count(array_filter($p1)); $i++)
					{
						$p1_sum = intval($p1_sum) + intval($p1[$i]);
					}
				}

				$p2 = json_decode($rr_matches[$m2]->Player2_Score);

				$cnt2 = count(array_filter($p2));
	
				if($cnt2 > 0){
					for($i=0; $i<count(array_filter($p2)); $i++)
					{
						$p2_sum = intval($p2_sum) + intval($p2[$i]);
					}
				}

				/*  Win percentage calculation end */	

				} 
				else { 
						$tot_p += intval($rr_matches[$m2]->Player2_points);

					 /*  Win percentage calculation for player when he is listed as PLAYER2 for that match*/	
						$p1 = json_decode($rr_matches[$m2]->Player2_Score);  

						$cnt1 = count(array_filter($p1));

						if($cnt1 > 0){
							for($i=0; $i<count(array_filter($p1)); $i++)
							{
								$p1_sum = intval($p1_sum) + intval($p1[$i]);
							}
						}

						$p2 = json_decode($rr_matches[$m2]->Player1_Score);

						$cnt2 = count(array_filter($p2));
			
						if($cnt2 > 0){
							for($i=0; $i<count(array_filter($p2)); $i++)
							{
								$p2_sum = intval($p2_sum) + intval($p2[$i]);
							}
						}
					 /*  Win percentage calculation end */	
				}
				$player_tot_score	+= ($p1_sum);
				$p1p2_tot_score		+= ($p1_sum+$p2_sum);
		}
	}
$win_per = ($player_tot_score / $p1p2_tot_score)*100;

$players_sort[$player] = array('points' => $tot_p, 'win_per' => number_format($win_per, 2));
}

$sort_func = uasort($players_sort, array('league','compareOrder'));
?>
<?php
//arsort($players_sort);
//print_r($players_sort);
foreach($players_sort as $player => $tot_score)
{
?>
<tr>
<td align="left">&nbsp;
<?php
$get_name = league::get_team($player);
	echo "<img id='".$player."' class='dis_opp' src='".base_url()."icons/right.png'"." style=width:25px;height:25px;cursor:pointer"." /><b><a style='text-decoration: none;'>".$get_name['Team_name']."</a></b>";
?>
</td>
	<?php

	foreach($rr_matches as $m2 => $match2){
		if($rr_matches[$m2]->Player1 == $player or $rr_matches[$m2]->Player2 == $player){

				if($rr_matches[$m2]->Player1 == $player){ 
					echo ($rr_matches[$m2]->Player1_points) ? "<td align='center'>".$rr_matches[$m2]->Player1_points."</td>" : "<td align='center'>xx</td>";
					//echo "<td align='center'>".$rr_matches[$m2]->Player1_points."</td>";
					//echo "<td align='center'>xx</td>";
				}
				else if($rr_matches[$m2]->Player2 == $player){
					echo ($rr_matches[$m2]->Player2_points) ? "<td align='center'>".$rr_matches[$m2]->Player2_points."</td>" : "<td align='center'>xx</td>";
					//echo "<td align='center'>".$rr_matches[$m2]->Player2_points."</td>"; 
					//echo "<td align='center'>xx</td>";

				}

				$player_tot_score += ($p1_sum);
				$p1p2_tot_score   += ($p1_sum+$p2_sum);
		}
		/*else
		{
			echo "<td> - </td>";	
		}*/
	
	}

	?>
<td align='center'><?php echo $tot_score['points']; ?></td>
<!-- <td align='center' style='font-weight:400'>
<?php echo $tot_score['win_per']; ?></td>
 --></tr>

<!-- Opponent Row -->
<tr id='opp_row<?=$player;?>' style='display:none;'>
<td align="left">&nbsp;</td>
<?php
	foreach($rr_matches as $m2 => $match2){
		if($rr_matches[$m2]->Player1 == $player or $rr_matches[$m2]->Player2 == $player){

				if($rr_matches[$m2]->Player1 == $player){ 
					$get_name = league::get_team($rr_matches[$m2]->Player2);
					echo "<td align='center'><b><a style='text-decoration: none;'>".$get_name['Team_name']."</a></b></td>";
				}
				else if($rr_matches[$m2]->Player2 == $player){
					$get_name = league::get_team($rr_matches[$m2]->Player1);
					echo "<td align='center'><b><a style='text-decoration: none;'>".$get_name['Team_name']."</a></b></td>";
				}

				$player_tot_score += ($p1_sum);
				$p1p2_tot_score	  += ($p1_sum+$p2_sum);
		}
		/*else
		{
			echo "<td> - </td>";	
		}*/
	}
?>
<td align='center'>&nbsp;</td>
<td align='center' style='font-weight:400'>&nbsp;</td>
</tr>
<!-- Opponent Row -->

<?php
}
?>
</table>

</div>
</div>


<!-- End of Team standing points section -->

<!-- ----------------------------------End of Round Robin-------------------------------- -->
<?php
}

else if($draw_type == 'Single Elimination'){
?>

<!-- ----------------------------------Single Elimination-------------------------------  -->
<?php
$list_matches	= $get_tourn_matches->result();
?>
<!-- <div class = "brackets" id="brackets"> -->
<div class = "group<?php echo $total_rounds+1; ?>" id="b1">
<input type='hidden' name='bracket_id' value="<?php echo $get_bracket['BracketID']; ?>" />
<input type='hidden' name='tour_id'	value="<?php echo $get_bracket['Tourn_ID']; ?>" />

<?php
$nm = 0;
$round_type = array();
for($round = 1; $round <= $total_rounds; $round++) {
	foreach($list_matches as $m => $match){
		if($list_matches[$m]->Round_Num==$round){
			$round_dates[$round] = $list_matches[$m]->Match_DueDate;
			$nm++;
		}
	}
	$round_type[$round] = $nm;
	$nm = 0;
}

for($round = 1; $round <= $total_rounds; $round++) {
?>
<script>/*
$(function() {
 var rid = "<?php echo $round; ?>";
 $('#sdate_round'+rid).datepick();
});*/
</script>

<div class="r<?php echo $round; ?>">
<br>
<input type='hidden' name='round[]' value="<?php echo $round; ?>" />
<span style="margin-left:10px;"><b>
<?php
	$rt = $round_type[$round];
if($rt >= pow(2,3)){
	$rrt = $rt*2;
	echo "Round of $rrt";
	}
else
	{
		switch($rt)
		{
			case 1:
				echo "Final";
				break;
			case 2:
				echo "Semi-Final";
				break;
			case 4:
				echo "Quarter-Final";
				break;
			default:
				echo "";
				break;
		}
	}
?>
</b><br />
</span>
<br />
<?php
if($tour_details->Usersid == $this->logged_user){
?>

<!-- <input type = "text" class = 'form-control' placeholder = "Date" id = "sdate_round<?php echo $round; ?>" name = "round_date<?php echo $round; ?>" value = "<?php if($round_dates[$round] != "")
{ echo date('m/d/Y', strtotime($round_dates[$round])); } ?>" /> -->

<input type="text" placeholder="Date" name="round_date<?php echo $round; ?>" id="sdate_round<?php echo $round; ?>"
value="<?php if($round_dates[$round] != "")
{ echo date('m/d/Y H:i', strtotime($round_dates[$round])); } ?>" />

<script>
var rid = "<?php echo $round; ?>";

  $('#sdate_round'+rid).fdatepicker({
		format: 'mm/dd/yyyy hh:ii',
		disableDblClickSelection: true,
		language: 'en',
		pickTime: true
	});
</script>


<?php
} else {
	if($round_dates[$round] != "") { echo date("m-d-Y H:i",strtotime($round_dates[$round])); }
}
//print_r($list_matches);exit;
foreach($list_matches as $m => $match){
$get_team1  = "";
$get_team2  = "";

	if($list_matches[$m]->Round_Num == $round){
	?>
	<div class="bracketbox">
	<span class="info">
	<?php
	if($list_matches[$m]->Player1 != 0){
		 $get_team1	= league::get_team(intval($list_matches[$m]->Player1));
	}

	if($list_matches[$m]->Player2 != 0){
		 $get_team2 = league::get_team(intval($list_matches[$m]->Player2));
	}
	
	$match_num = $list_matches[$m]->Match_Num;
	echo $match_num;

	if($list_matches[$m]->Match_DueDate != ""){ echo date("m-d-Y H:i",strtotime($list_matches[$m]->Match_DueDate)); }
?>
<br />
	<input type='hidden' name='match_num[<?php echo $round; ?>][]' value="<?php echo $match_num; ?>" />
	<input type='hidden' name='draw[]' value="<?php echo $list_matches[$m]->Draw_Type; ?>" />

	</span>
	<span class="teama"><?php
		if($get_team1){ 
		echo "<a href='#'>".$get_team1['Team_name']."</a>";
		}
		else { echo "----"; }?>

	<?php if($list_matches[$m]->Round_Num != 1){

		$get_source_scores1 = league::get_match_scores_player1($list_matches[$m]->Player1_source, $bracket_id, $tour_id, $list_matches[$m]->Draw_Type);
	

		//if($get_source_scores1['Player1_Score'] !="" && $get_source_scores1['Player1_Score'] !="Bye Match"){

		$p1 = $get_source_scores1['Player1_points'];
		$p2 = $get_source_scores1['Player2_points'];
		$tourn_match_id = $get_source_scores1['Tourn_match_id'];
		$player1 = $get_source_scores1['Player1'];
		$player2 = $get_source_scores1['Player2'];
             echo '<a href="" class="show_linematch_score" style="cursor:pointer;font-weight:bold;" 
             id="P2_'.$tourn_match_id.'_'.$player1.'_'.$player2.'">';
			  if($get_source_scores1['Winner'] == $get_source_scores1['Player1']){
					echo "($p1 - $p2) ";
			  }
			  else{
					echo "($p2 - $p1) ";
			  }
			  echo "</a>";
		//}
	}
	?>
	</span>
	<span class='team2'>&nbsp
	</span>
	<span class="teamb">
	<?php 
	if($list_matches[$m]->Round_Num == 1 and $list_matches[$m]->Player2 != 0){ 
		echo "<a href='#'>".$get_team2['Team_name']."</a>"; 
	}
	else if($list_matches[$m]->Round_Num != 1 and $list_matches[$m]->Player2 == 0){ 
		echo "---"; 
	}
	else if($get_team2){ 
		echo "<a href='#'>".$get_team2['Team_name']."</a>"; 
	}
	else{ 
		echo "Bye"; 
	}
	?>

<?php if($list_matches[$m]->Round_Num != 1){

		$get_source_scores2 = league::get_match_scores_player2($list_matches[$m]->Player2_source,$bracket_id,$tour_id,$list_matches[$m]->Draw_Type);

		//if($get_source_scores2['Player1_Score'] !=""){
			$p1 = $get_source_scores2['Player1_points'];
			$p2 = $get_source_scores2['Player2_points'];
			$tourn_match_id = $get_source_scores2['Tourn_match_id'];
            $player1 = $get_source_scores2['Player1'];
		    $player2 = $get_source_scores2['Player2'];
             echo '<a href="" class="show_linematch_score" style="cursor:pointer;font-weight:bold;" 
             id="P2_'.$tourn_match_id.'_'.$player1.'_'.$player2.'">';
				  if($get_source_scores2['Winner'] == $get_source_scores2['Player1']){
						echo "($p1 - $p2) ";
				  }
				  else{
						echo "($p2 - $p1) ";
				  }
				  echo "</a>";
			//}
		}
		echo "";
		?>
	</span>
	</div>
<? }
 }
?>
</div>

<?php if(($round) == $total_rounds){ ?>
  <div class="r<?php echo $total_rounds+1; ?>">
   		<div class="final">
        	<div class="bracketbox">
            	<span class="teamc">
				<?php
				if($list_matches[$m]->Winner != 0){

					if($list_matches[$m]->Winner == $list_matches[$m]->Player1){
						 $get_team1			= league::get_team(intval($list_matches[$m]->Player1));
							
							echo "<h5 style='color:#f59123'><b>";
							if($get_team1){ 
							echo "<a href='#'>".$get_team1['Team_name']."</a>";
							}
							echo "</b></h5>";

							//if($list_matches[$m]->Player1_Score !=""){
								$p1 = $list_matches[$m]->Player1_points;
								$p2 = $list_matches[$m]->Player2_points;
                                 $player1 = $list_matches[$m]->Player1;
		                         $player2 = $list_matches[$m]->Player2;
             echo '<a href="" class="show_linematch_score" style="cursor:pointer;font-weight:bold;" 
             id="P2_'.$list_matches[$m]->Tourn_match_id.'_'.$player1.'_'.$player2.'">';
                                 
									echo "($p1 - $p2) ";
									 echo "</a>";
							//} 
					}
					else{
						 $get_team2			= league::get_team(intval($list_matches[$m]->Player2));
							
							echo "<h5 style='color:#f59123'><b>";
							if($get_team2){ 
								echo "<a href=''>".$get_team2['Team_name']."</a>";
							}
							echo "</b></h5>";

							//if($list_matches[$m]->Player1_Score !=""){
								$p1 = $list_matches[$m]->Player1_points;
								$p2 = $list_matches[$m]->Player2_points;
					            $player1 = $list_matches[$m]->Player1;
		                        $player2 = $list_matches[$m]->Player2;
             echo '<a href="" class="show_linematch_score" style="cursor:pointer;font-weight:bold;" 
             id="P2_'.$list_matches[$m]->Tourn_match_id.'_'.$player1.'_'.$player2.'">';
								echo "($p2 - $p1) ";
								 echo "</a>";
							//}
					}
				}
				?>
				</span>
            </div>
        </div>
   </div>

<?php } ?>
<!-- <input type="hidden" id="tourn_id"  name="tourn_id" value="<?php echo $this->input->post('tourn_id'); ?>" />
<input type='hidden' name='match_type'	value="<?php echo $this->input->post('types'); ?>" />
<input type='hidden' name='age_group'	value="<?php echo $this->input->post('type_gen'); ?>" />
<input type='hidden' name='ttype'		value="<?php echo $this->input->post('ttype'); ?>" />
 -->
<?
}
?>

<!-- </div>
 --></div>

<!-- ----------------------------------End of Single Elimination-------------------------------  -->
<?php
}
?>
</div>
</div>
<!--Close Login-->

</div>
</section>