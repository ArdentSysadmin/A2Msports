<html>
<head>
<style>
@media print {
.pagebreak { page-break-after: always; }
}
</style>
<?
//---------------------Calculation section ------------------------------ 
foreach($robins as $round => $games) {

	$total_matches = count($games);
	if($total_matches > 3) {
		$group_matches = ($total_matches % 2 == 0) ? ($total_matches / 2) : ($total_matches / 3);

		if($group_matches > 10)	{
		$group_matches = ($total_matches % 4 == 0) ? ($total_matches / 4) : ($total_matches / 5);
		}

		$per_group_matches = $total_matches / $group_matches;
	}
	else {
		$per_group_matches = 1;
		$group_matches = 3;
	}
	
	$match_num		 = 1;
	$per_round_count = 1;
	foreach($games as $game_num => $game) {

			$rr_p1 = explode('-', $game[0]);
			$rr_p2 = explode('-', $game[1]);

			$rr_matches[$round][$match_num][($game_num+1)][] = $rr_p1[0];
			$rr_matches[$round][$match_num][($game_num+1)][] = $rr_p2[0];
		
		if($match_num != $group_matches && $per_group_matches == $per_round_count){
			$match_num++;
			$per_round_count = 1;
		}
		else{
			$per_round_count++;
		}

	}

}
// ---------------------------------------------------------------------
?>
</head>
<body style="background:url('<?=base_url();?>images/logo-watermark.gif');">
<section id="login" class="container secondary-page" style="width:100%; margin:40 auto;">
<div id='test123' class='tab-content'>
<?php
$head  = 'Player';
$index = 1;
?>
<!-- header -->
<table width="100%" height="100%" border="0" cellspacing="0" cellpadding="0" align="center">
<tr>
<td style="border:2px solid #ff8a00;" valign="top">

<table width="100%" border="0" cellspacing="0" cellpadding="0">
<tr>
<td width="172" style="padding:10px">
<img class="scale_image" src="<?php echo base_url(); ?>images/logo.png" alt="" />
</td>
<td width="524">
<div align="left" style="font-size:18px; font-weight:bold"><h1 style='padding-top:40px;'><?php echo $tour_name; ?></h1></div>
</td>
</tr>
<tr>
<td colspan="2" style="height:6px; background:#81a32b; font-size:6px"></td>
</tr>
</table>
<br />
<!--  /header -->

<br />
<br />
<?php
$teams = array_map('trim', $teams);
// -------------------------------------------------------------------------------------------------------------- 
?>
<!-- </div>
</div>			 -->	<!--end div of LOGIN BOX -->  
<!-- </div> -->     <!--end div of general-results players  -->  


<?php
$w = 100 / (count($teams) + 2);
?>
<div class="top-score-title right-score">
	<table height="100%" width="100%" cellpadding="2" align="center" class="tab-score" border="1" 
	style="border-collapse:collapse;font-family: 'Open Sans', sans-serif;font-size: 13px;">
	<tr align="center" height="40">
	<td>&nbsp;</td>
	<?php 
	foreach($teams as $i => $team) {
		$temp_name = (!strpos($team, ')')) ? $team : "__________";
	echo "<td valign='bottom'><b>$temp_name</b></td>";
	}
	?>
	<td><b>Points</b></td>
	</tr>

	<?php 
	foreach($teams as $j => $team1) { 
	?>
	<tr align="center" height="40">
	<td align="center" valign="bottom" style='margin-bottom:1px;'><b><?php echo (!strpos($team1, ')')) ? $team1 : "_________"; ?></b></td>

	<?php 
	foreach($teams as $k => $team2){
		//echo "<td>";
		if($team1 != $team2)
			echo "<td></td>";
		else
			echo "<td style='background:#CCC;'></td>";
		//echo "</td>";
	}
	?>
	<td>&nbsp;</td>
	</tr>
	<?php
	} ?>
	</table>
	<br /><br />
</div>

<!-- footer -->
<!-- <table width="100%" border="0" cellspacing="0" cellpadding="0">
<tr>
<td style="background:#81a32b; font-size:12px; padding:6px; color:#ffffff; text-align:center">&copy; 2016 a2msports.com. All rights reserved.</td>
</tr>
</table> -->
 

<!-- footer -->
<?php
if(count($rr_matches) != $round) {
	echo "<div class='pagebreak'>&nbsp;</div>";
}
?>
<!-- </div> -->


<?php
$teams = array_map('trim', $teams);
// -------------------------------------------------------------------------------------------------------------- 
?>

<!-- <div style="background:#81a32b; font-size:12px; height:25px; color:#ffffff; text-align:center; position:absolute; bottom:-22px; width:98.6%;">
&copy; 2016 a2msports.com. All rights reserved.
</div> -->

<!-- <table width="100%" border="0" cellspacing="0" cellpadding="0">
<tr>
<td style="background:#81a32b; font-size:12px; padding:6px; color:#ffffff; text-align:center">&copy; 2016 a2msports.com. All rights reserved.</td>
</tr>
</table> -->

</td>
</tr>
</table>
			<!--end div of LOGIN BOX -->  
<!-- </div> -->     <!--end div of general-results players  -->  

</div>
</section>
</body>
</html>