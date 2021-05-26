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

<link rel="stylesheet" href="<?php echo base_url();?>css/grid.css">

<?php 
$tour_id = $get_bracket['Tourn_ID'];
$title = league::getonerow($tour_id);
?>
<!-- <div style="padding-left:10px; float:left" class='col-md-4'>
<a href="<?php //echo base_url();?>"><img src="<?php //echo base_url();?>images/logo.png" alt="" ></a>
<br />
<br />
<br />

</div> -->
<div style='padding-left:180px; padding-top:20px; float:left'><p style='font-size:20px'><b><?php echo $get_bracket['Draw_Title']; ?></b></p></div> 
<section id="login" class="container secondary-page">  

<!-- LOGIN BOX -->
<div class="top-score-title right-score col-md-12">
<!-- <h3><?php echo $title->tournament_title; ?></h3>
 -->
<div class="col-md-12">

<div class="general water-mark">

<div class="brackets" id="brackets">

<?php  
if(isset($get_tourn_matches)){
$total_rounds =	$get_bracket['No_of_rounds'];
$bracket_id = $get_bracket['BracketID'];  
$tour_id = $get_bracket['Tourn_ID'];

$list_matches = $get_tourn_matches->result();
?>
<div class="group<?php echo $total_rounds+1; ?>" id="b1">

<?php
$nm = 0;
$round_type = array();
for($round = 1; $round <= $total_rounds; $round++) {
	foreach($list_matches as $m => $match){
		if($list_matches[$m]->Round_Num==$round){
			$nm++;
		}
	}
	$round_type[$round] = $nm;
	$nm = 0;
}


for($round = 1; $round <= $total_rounds; $round++) {
?>
<div class="r<?php echo $round; ?>" style="text-align:center">
<br>
<span style="text-align: center"><b>
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
</b></span>
<?php
foreach($list_matches as $m => $match){
	
$get_username = "";
$get_username2 = "";

	if($list_matches[$m]->Round_Num==$round){
	?>
	<div class="bracketbox">
	<span class="info"><?php
	if($list_matches[$m]->Player1 != 0){
		 $get_username = league::get_username(intval($list_matches[$m]->Player1));
	}
	if($list_matches[$m]->Player2 != 0){
		 $get_username2 = league::get_username(intval($list_matches[$m]->Player2));
	}
	
	echo $list_matches[$m]->Match_Num; ?>
	<br />
	<?php if($list_matches[$m]->Match_DueDate != "") { echo date("m-d-Y",strtotime($list_matches[$m]->Match_DueDate)); }?>
	</span>
	<span class="teama"><?php if($get_username){ echo $get_username['Firstname']." ".$get_username['Lastname']; } else { echo "----"; }?>

	<?php if($list_matches[$m]->Round_Num != 1){

		$get_source_scores1 = league::get_match_scores_player1($list_matches[$m]->Player1_source,$bracket_id,$tour_id,$list_matches[$m]->Draw_Type);

		if($get_source_scores1['Player1_Score'] !="" && $get_source_scores1['Player1_Score'] !="Bye Match"){

		$p1 = json_decode($get_source_scores1['Player1_Score']);
		$p2 = json_decode($get_source_scores1['Player2_Score']);
			if(count(array_filter($p1))>0)
			{
				for($i=0; $i<count(array_filter($p1)); $i++)
				{

					echo "($p1[$i] - $p2[$i]) ";
				}
			}

		}
	}
	echo "<br>";
	?>
	
	</span>
	<span class='team2'>&nbsp</span>
	<span class="teamb">
	<?php if($list_matches[$m]->Round_Num != 1){

		$get_source_scores2 = league::get_match_scores_player2($list_matches[$m]->Player2_source,$bracket_id,$tour_id,$list_matches[$m]->Draw_Type);

		if($get_source_scores2['Player1_Score'] !=""){
			$p1 = json_decode($get_source_scores2['Player1_Score']);
			$p2 = json_decode($get_source_scores2['Player2_Score']);

				if(count(array_filter($p1))>0)
				{
					for($i=0; $i<count(array_filter($p1)); $i++)
					{
						echo "($p1[$i] - $p2[$i]) ";
					}
				}

			} 
		}
		echo "<br>";
		?>
	
	<?php if($list_matches[$m]->Round_Num == 1 and $list_matches[$m]->Player2 != 0)
		{ echo $get_username2['Firstname']." ".$get_username2['Lastname']; }
	else if($list_matches[$m]->Round_Num != 1 and $list_matches[$m]->Player2 == 0){ echo "---"; }
	else if($get_username2) { echo $get_username2['Firstname']." ".$get_username2['Lastname']; }
	else { echo "Bye"; }
	?>

	 	
	</span>
	</div>
<?php }
}
?>
</div>
<?php if(($round) == $total_rounds){ ?>
  <div class="r<?php echo $total_rounds+1; ?>">
<!-- 		<span style="text-align:center">Final</span> -->
		<div class="final">
        	<div class="bracketbox">
            	<span class="teamc">
				<?php if($list_matches[$m]->Winner != 0){
				 $get_username = league::get_username(intval($list_matches[$m]->Winner));
				 ($list_matches[$m]->Winner == $list_matches[$m]->Player1) ? 
					 $partner = $list_matches[$m]->Player1_Partner : $partner = $list_matches[$m]->Player2_Partner;
				 $get_partner_name = league::get_username(intval($partner));

				 echo "<h4 style='color:#f59123'><b>".$get_username['Firstname']." ".$get_username['Lastname'];
				 	 if($partner) { echo " - ".$get_partner_name['Firstname']." ".$get_partner_name['Lastname']; }
				 echo "</b></h4>";

					if($list_matches[$m]->Player1_Score !="" and $list_matches[$m]->Winner == $list_matches[$m]->Player1){
					$p1 = json_decode($list_matches[$m]->Player1_Score);
					$p2 = json_decode($list_matches[$m]->Player2_Score);
					} 
					else if($list_matches[$m]->Player2_Score !="" and $list_matches[$m]->Winner == $list_matches[$m]->Player2){
					$p1 = json_decode($list_matches[$m]->Player2_Score);
					$p2 = json_decode($list_matches[$m]->Player1_Score);
					}
						
						if(count(array_filter($p1))>0)
						{
							for($i=0; $i<count(array_filter($p1)); $i++)
							{
							echo "($p1[$i] - $p2[$i]) ";
							}
						}
					}
				
				?>

				</span>
            </div>
        </div>
   </div>
<?php } 
}
?>
</div>
<?php
}
?>



<!-- ---------------------------------------------- Consolation ---------------------- -->
<?php  
if(isset($get_cd_tourn_matches)){

$total_rounds =	intval($get_cd_num_rounds['total_rounds']);
$bracket_id = $get_bracket['BracketID'];
$tour_id = $get_bracket['Tourn_ID'];

$list_matches = $get_cd_tourn_matches->result();
?>
<div class="group<?php echo $total_rounds+1; ?>" id="b1">

<?php
$nm = 0;
$round_type = array();
for($round = 1; $round <= $total_rounds; $round++) {
	foreach($list_matches as $m => $match){
		if($list_matches[$m]->Round_Num==$round){
			$nm++;
		}
	}
	$round_type[$round] = $nm;
	$nm = 0;
}

for($round = 1; $round <= $total_rounds; $round++) {
?>
<div class="r<?php echo $round; ?>">
<br>
<span style="text-align: center"><b>
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
</b></span>
<?php
//	print_r($list_matches);exit;
foreach($list_matches as $m => $match){
$get_username = "";
$get_username2 = "";

	if($list_matches[$m]->Round_Num==$round){
	?>
	<div class="bracketbox">
	<span class="info"><?php
	if($list_matches[$m]->Player1 != 0){
		 $get_username = league::get_username(intval($list_matches[$m]->Player1));
		 $get_partner_username = league::get_username(intval($list_matches[$m]->Player1_Partner));
	}
	
	if($list_matches[$m]->Player2 != 0){
		 $get_username2 = league::get_username(intval($list_matches[$m]->Player2));
		 $get_partner_username2 = league::get_username(intval($list_matches[$m]->Player2_Partner));
	}
	
	echo $list_matches[$m]->Match_Num; ?>
	<br />
	<?php if($list_matches[$m]->Match_DueDate != "") { echo date("m-d-Y",strtotime($list_matches[$m]->Match_DueDate)); }?>
	</span>
	<span class="teama"><?php
		if($get_username){ 
			echo $get_username['Firstname']." ".$get_username['Lastname'];

				if($get_partner_username){
					echo " - ".$get_partner_username['Firstname']." ".$get_partner_username['Lastname']; 
				}
		} 
		else {
			//echo "----"; 
			if($list_matches[$m]->Player1_source && $round == 1){ $src = "Looser of Match - ".$list_matches[$m]->Player1_source; } 
			else if($list_matches[$m]->Player1_source && $round > 1) { $src = "---"; }
			else { $src = "Bye"; }

			echo $src;
		}
	?>

	<?php if($list_matches[$m]->Round_Num != 1){

		$get_source_scores1 = league::get_match_scores_player1($list_matches[$m]->Player1_source,$bracket_id,$tour_id,$list_matches[$m]->Draw_Type);

		if($get_source_scores1['Player1_Score'] !="" && $get_source_scores1['Player1_Score'] !="Bye Match"){

		$p1 = json_decode($get_source_scores1['Player1_Score']);
		$p2 = json_decode($get_source_scores1['Player2_Score']);
			if(count(array_filter($p1))>0)
			{
				for($i=0; $i<count(array_filter($p1)); $i++)
				{
					echo "($p1[$i] - $p2[$i]) ";
				}
			}
		}
	}
	?>
	</span>
	<span class='team2'>&nbsp
	</span>
	<span class="teamb">
	<?php if($list_matches[$m]->Round_Num != 1){

		$get_source_scores2 = league::get_match_scores_player2($list_matches[$m]->Player2_source,$bracket_id,$tour_id,$list_matches[$m]->Draw_Type);

		if($get_source_scores2['Player1_Score'] !=""){
			$p1 = json_decode($get_source_scores2['Player1_Score']);
			$p2 = json_decode($get_source_scores2['Player2_Score']);

				if(count(array_filter($p1))>0)
				{
					for($i=0; $i<count(array_filter($p1)); $i++)
					{
						echo "($p1[$i] - $p2[$i]) ";
					}
				}
			} 
		}
		echo "<br>";
		?>
	
	<?php
		if($list_matches[$m]->Round_Num == 1 and $list_matches[$m]->Player2 != 0)
		{ 
		echo $get_username2['Firstname']." ".$get_username2['Lastname']; 
			if($get_partner_username2){
				echo " - ".$get_partner_username2['Firstname']." ".$get_partner_username2['Lastname']; 
			}
		}
		else if($list_matches[$m]->Round_Num != 1 and $list_matches[$m]->Player2 == 0){ echo "---"; }
		else if($get_username2) { 
			echo $get_username2['Firstname']." ".$get_username2['Lastname']; 
				if($get_partner_username2){
					echo " - ".$get_partner_username2['Firstname']." ".$get_partner_username2['Lastname']; 
				}
		}
		else {
			//echo "Bye"; 
				if($list_matches[$m]->Player2_source && $round == 1){ $src = "Looser of Match - ".$list_matches[$m]->Player2_source; } 
				else if($list_matches[$m]->Player2_source && $round > 1) { $src = "---"; }
				else { $src = "Bye"; }

				echo $src;
			}
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
				<?php if($list_matches[$m]->Winner != 0){
				 $get_username = league::get_username(intval($list_matches[$m]->Winner));
				 ($list_matches[$m]->Winner == $list_matches[$m]->Player1) ? 
					 $partner = $list_matches[$m]->Player1_Partner : $partner = $list_matches[$m]->Player2_Partner;
				 $get_partner_name = league::get_username(intval($partner));

				 echo "<h4 style='color:#f59123'><b>".$get_username['Firstname']." ".$get_username['Lastname'];
				 	 if($partner) { echo " - ".$get_partner_name['Firstname']." ".$get_partner_name['Lastname']; }
				 echo "</b></h4>";

					if($list_matches[$m]->Player1_Score !="" and $list_matches[$m]->Winner == $list_matches[$m]->Player1){
					$p1 = json_decode($list_matches[$m]->Player1_Score);
					$p2 = json_decode($list_matches[$m]->Player2_Score);
					} 
					else if($list_matches[$m]->Player2_Score !="" and $list_matches[$m]->Winner == $list_matches[$m]->Player2){
					$p1 = json_decode($list_matches[$m]->Player2_Score);
					$p2 = json_decode($list_matches[$m]->Player1_Score);
					}
						
						if(count(array_filter($p1))>0)
						{
							for($i=0; $i<count(array_filter($p1)); $i++)
							{
							echo "($p1[$i] - $p2[$i]) ";
							}
						}
					}
				
				?>

				</span>
            </div>
        </div>
   </div>
<?php } ?>

<?
}
?>
</div>
<?php
}
?>
</div>
<!-- <form id="your_form" action="<?php echo base_url(); ?>league/pdf/<?php echo $tourn_id; ?>" method="post">
<input type='hidden' name='users[]' value="<?php print_r($this->input->post('users'));?>">
<input type="submit" class="league-form-submit1" name="capture" id="restore" value="Print" />
</form>
 -->

<!-- ----------------------------------------------Round Robin---------------------- -->

<?php 
if(isset($get_rr_tourn_matches)){
$rr_matches = $get_rr_tourn_matches->result();


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
?>
<div class='tab-content'>
<div class="col-md-12">
<? //--------------------------------------------------------------------------------------------------------------- ?>

<table class='tab-score'>
<?php
$round =0;
$match_num = 1;

foreach($rr_matches as $m=>$rrm){   // Main for loop
	
	if($round != $rr_matches[$m]->Round_Num)
	{
	$round = $rr_matches[$m]->Round_Num;
?>

<tr class='top-scrore-table'>
<td align='center'>S.No. #</td>

<td align='center' colspan='2'>Match <?=$rr_matches[$m]->Round_Num;?>
<?php 
if($rr_matches[$m]->Match_DueDate){

 $split_date = explode(" ",$rr_matches[$m]->Match_DueDate);
 $date1 = ($split_date[1] != "00:00:00.000" and $split_date[1] != "") ?
 date("m/d/Y h:i A", strtotime($rr_matches[$m]->Match_DueDate)) : date("m/d/Y", strtotime($rr_matches[$m]->Match_DueDate));

echo "&nbsp;&nbsp;&nbsp;&nbsp;(Play by: ".$date1.")"; 

} ?></td>
<td align='center'>Score</td></tr>
<!-- <tr align='center'><td><b>Player 1 / Team 1</b></td><td><b>Player 2 / Team 2</b></td><td>&nbsp;</td></tr> -->
<?php
	}
$player1 = league::get_username(intval($rr_matches[$m]->Player1));
$player2 = league::get_username(intval($rr_matches[$m]->Player2));

$p1_part = "";
$p2_part = "";

if($rr_matches[$m]->Player1_Partner){
	$player1_partner = league::get_username(intval($rr_matches[$m]->Player1_Partner));
	$p1_part = "; $player1_partner[Firstname] $player1_partner[Lastname]";
}

if($rr_matches[$m]->Player2_Partner){
	$player2_partner = league::get_username(intval($rr_matches[$m]->Player2_Partner));
	$p2_part = "; $player2_partner[Firstname] $player2_partner[Lastname]";
}

$tm_id = $rr_matches[$m]->Tourn_match_id;
?>
<tr align='center'>
<td align='center'><?php echo $match_num; ?></td>
	<td><?php echo $player1['Firstname']." ".$player1['Lastname'].$p1_part; 
	if($rr_matches[$m]->Winner == $rr_matches[$m]->Player1) {
		echo "<img id='img-winner' src='".base_url()."images/gold_medal_small.png' width='20' height='20'></img>";
	}
	?></td>
	 <td style='font-weight:normal'><?php echo $player2['Firstname']." ".$player2['Lastname'].$p2_part; 
	if($rr_matches[$m]->Winner == $rr_matches[$m]->Player2) {
		echo "<img id='img-winner' src='".base_url()."images/gold_medal_small.png' width='20' height='20'></img>";
	}
	 ?></td>
	 <td>
	 <?php if($rr_matches[$m]->Winner != "") {?>
		<?php
		if($rr_matches[$m]->Player1_Score !=""){
		$p1=array();$p2=array();
		$p1 = json_decode($rr_matches[$m]->Player1_Score);
		$p2 = json_decode($rr_matches[$m]->Player2_Score);

		$cnt = count(array_filter($p1));
		$cnt2 = count(array_filter($p2));

		if($cnt > 0){
				for($i=0; $i<count(array_filter($p1)); $i++)
				{
					echo "($p1[$i] - $p2[$i]) ";
				}
			}
		else if($cnt2 > 0){
				for($i=0; $i<count(array_filter($p2)); $i++)
				{
					echo "($p1[$i] - $p2[$i]) ";
				}
			}
			else if($cnt == 0 and $rr_matches[$m]->Player1_Score != "Bye Match" and $rr_matches[$m]->Player2_Score != "Bye Match"){
					echo "Win by Forfeit ";
			}

		}
		?>
	 <?php } ?>
	 </td>
</tr>

<?php
$match_num++;
} // End of Main For loop
?>
</table>


<!-- Player standing points section start -->

<div class="col-md-12 league-form-bg" style="margin-top:40px; margin-bottom:20px;">
<div class="accordion"  id="up_match_section"  style="background:#f59123; padding:5px; color:white;"><i class="fa fa-arrow-circle-o-right" style="color:white;"> </i>Player Standings<span></span></div>
<?php
$rr_matches2 = $get_rr_tourn_matches->result();
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
<td class="score-position" valign="center" align="center">
<?php if($match_type == "Doubles"){ echo "Teams"; } else { echo "Players"; } ?>
</td>
<?php
for($i = 1;$i <= $num_matches; $i++)
{
	echo "<td class='score-position' valign='center' align='center'>Match $i&nbsp;&nbsp;</td>";	
}
?>
<td class="score-position" valign="center" align="center">Total&nbsp;&nbsp;</td>
<td class="score-position" valign="center" align="center">Win%&nbsp;&nbsp;</td>
</tr>

<?php
foreach($list_players as $player){
	$tot_p = 0;
	foreach($rr_matches2 as $m2 => $match2){
		if($rr_matches2[$m2]->Player1 == $player or $rr_matches2[$m2]->Player2 == $player){
				if($rr_matches2[$m2]->Player1 == $player) { 
						$tot_p += $rr_matches2[$m2]->Player1_points;
				} 
				else { 
						$tot_p += $rr_matches2[$m2]->Player2_points;
				}
		}
	}
$players_sort[$player] = $tot_p;
}
?>

<?php
arsort($players_sort);

foreach($players_sort as $player => $tot_score)
{
?>
<tr>
<td align="left">&nbsp;
<?php
		$get_players = explode("-", $player);

		$get_name = league::get_username($get_players[0]);
		$get_name_partner = league::get_username($get_players[1]);
		echo "<b>".$get_name['Firstname']." ".$get_name['Lastname'];
		
		if($get_name_partner){
			echo "; ".ucfirst($get_name_partner['Firstname'])." ".ucfirst($get_name_partner['Lastname']);
		}
		echo "</b>";
	
?>
</td>
	<?php
	$player_tot_score = 0;
	$p1p2_tot_score = 0;

	foreach($rr_matches2 as $m2 => $match2){
		if($rr_matches2[$m2]->Player1 == $player or $rr_matches2[$m2]->Player2 == $player){

		$p1_sum	= 0;
		$p2_sum = 0;
		$p1		= array();
		$p2		= array();

				if($rr_matches2[$m2]->Player1 == $player) { 

					/*  Win percentage calculation for player when he is listed as PLAYER1 for that match*/

				$p1 = json_decode($rr_matches2[$m2]->Player1_Score);  

				$cnt1 = count(array_filter($p1));

				if($cnt1 > 0){
					for($i=0; $i<count(array_filter($p1)); $i++)
					{
						$p1_sum = intval($p1_sum) + intval($p1[$i]);
					}
				}

				$p2 = json_decode($rr_matches2[$m2]->Player2_Score);

				$cnt2 = count(array_filter($p2));
	
				if($cnt2 > 0){
					for($i=0; $i<count(array_filter($p2)); $i++)
					{
						$p2_sum = intval($p2_sum) + intval($p2[$i]);
					}
				}

				/*  Win percentage calculation end */	

						echo "<td align='center'>".$rr_matches2[$m2]->Player1_points."</td>";
				} 
				else { 

					/*  Win percentage calculation for player when he is listed as PLAYER2 for that match*/	
						$p1 = json_decode($rr_matches2[$m2]->Player2_Score);  

						$cnt1 = count(array_filter($p1));

						if($cnt1 > 0){
							for($i=0; $i<count(array_filter($p1)); $i++)
							{
								$p1_sum = intval($p1_sum) + intval($p1[$i]);
							}
						}

						$p2 = json_decode($rr_matches2[$m2]->Player1_Score);

						$cnt2 = count(array_filter($p2));
			
						if($cnt2 > 0){
							for($i=0; $i<count(array_filter($p2)); $i++)
							{
								$p2_sum = intval($p2_sum) + intval($p2[$i]);
							}
						}
					 /*  Win percentage calculation end */	

						echo "<td align='center'>".$rr_matches2[$m2]->Player2_points."</td>"; 
				}
				
				$player_tot_score	+= ($p1_sum);
				$p1p2_tot_score		+= ($p1_sum+$p2_sum);

		}
	}
	?>
<td align='center'><?php echo $tot_score; ?></td>
<td align='center' style='font-weight:400'>
<?php
	$win_per = ($player_tot_score / $p1p2_tot_score)*100;
	echo number_format($win_per, 2);
?>
</td>

</tr>
<?php
}
?>
</table>
</div>

</div>

<!-- End of Player Standing points section -->




<?php
}
?>

<!-- ----------------------------------End of Round Robin-------------------------------- -->

</div>

</div>
<!--Close Login-->

</div>
</section>