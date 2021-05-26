<html>
<head>
<!-- <link href="<?php echo base_url();?>css/bootstrap.css" rel="stylesheet" type="text/css"/> -->
<!-- <link href="<?php echo base_url();?>css/style_dir.css" rel="stylesheet" type="text/css" /> -->
<style>
@media print {
.pagebreak { page-break-after: always; }
}
</style>
</head>
<body style="background:url('<?=base_url();?>images/logo-watermark.gif');">
<section id="login" class="container secondary-page" style="width:100%; margin: 0 auto;">  
<!-- <div class="general general-results players"> -->
<!-- LOGIN BOX -->
<!-- <div class="top-score-title right-score col-md-9" id='bracket_result'><h3>Round Robin Matches</h3><div> -->

<!-- <div class="col-md-6"><h3 style="margin-bottom:0px; margin-top:0px;text-align:left;"><?=$tour_name;?></h3></div> -->
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

<div id='test123' class='tab-content'>
<?php
$head  = 'Player';
$index = 1;

foreach($rr_matches as $round => $matches){
?>
<!-- header -->
<table width="100%" height="100%" border="0" cellspacing="0" cellpadding="0" align="center">
<tr>
<!-- <td style="border:2px solid #ff8a00;background:url('<?=base_url();?>images/logo-watermark.gif')" valign="top"> -->
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

<div>
<table width="100%" cellpadding="1" align="center" class="tab-score" border="1" style="border-collapse:collapse;font-family: 'Open Sans', sans-serif;font-size: 13px;">
<tr height='40'>
<td align='center' valign='bottom'>#</td>
<td align='center' colspan='3' valign='bottom'><b>Round <?=$round;?></b></td>
</tr>
<?php
foreach($matches as $match => $games){
/*echo "<tr align='center'><td colspan='3'><b>Match {$match}</b>&nbsp;&nbsp;
<input type='text' placeholder='Date' name='match_date{$round}{$match}' id='match_date{$round}{$match}' value='' />";*/
//echo "<tr align='center'><td colspan='4'><b>Match {$match}</b>&nbsp;&nbsp;</td></tr>";
echo "<tr align='center' valign='bottom' height='40'>
<td colspan='2' valign='bottom'>&nbsp;</td>
<td valign='bottom'><b>Match {$match}</b>&nbsp;&nbsp;</td>
<td valign='bottom'>&nbsp;</td></tr>";
?>

<?php
foreach($games as $game){
	/*$rr_p1 = explode('-', $game[0]);
	$rr_p2 = explode('-', $game[1]);*/

	$rr_p1 = $game[0];
	$rr_p2 = $game[1];

//$mdate = "<input type='text' placeholder='Date' name='game_date{$index}' id='game_date{$index}' value='' />";

$player1 = (!strpos($rr_p1, ')')) ? $rr_p1 : "______________________";
$player2 = (!strpos($rr_p2, ')')) ? $rr_p2 : "______________________";

$p1_part = "";
$p2_part = "";

/*if($rr_p1){
	$p1_part = "; $rr_p1[1]";
}

if($rr_p2){
	$p2_part = "; $rr_p1[2]";
}*/

 echo "<tr height='40'>
 <td align='center' valign='bottom'>".$index."</td>
 <td align='center' valign='bottom'>".$player1." ".$p1_part."</td>
 <td align='center' valign='bottom' style='font-weight:normal'>_____________________</td>
 <td align='center' valign='bottom' style='font-weight:normal'>".$player2." ".$p2_part."</td>
 </tr>";

?>
<script>
var mid = "<?php echo $index; ?>";
  $('#game_date'+mid).fdatepicker({
		format: 'mm/dd/yyyy hh:ii',
		disableDblClickSelection: true,
		language: 'en',
		pickTime: true
	});
</script>
<?php
$index++;
}
}
echo "</table>";
echo "</div>";
?>
<br />
<br />
<!-- footer -->
<!-- <table width="100%" border="0" cellspacing="0" cellpadding="0">
<tr>
<td style="background:#81a32b; font-size:12px; padding:6px; color:#ffffff; text-align:center">&copy; 2016 a2msports.com. All rights reserved.</td>
</tr>
</table> -->
<!-- footer -->
</table>


<?php
if(count($rr_matches) != $round) {
	echo "<div class='pagebreak'>&nbsp;</div>";
}
?>
<!-- <div style="background:#81a32b; font-size:12px; height:25px; color:#ffffff; text-align:center; position:absolute; bottom:10px; width:98.7%;">&copy; 2016 a2msports.com. All rights reserved.</div>
 -->
 

 
 
<!-- <table width="100%" border="0" cellspacing="0" cellpadding="0">
<tr>
<td style="background:#81a32b; font-size:12px; padding:6px; color:#ffffff; text-align:center">&copy; 2016 a2msports.com. All rights reserved.</td>
</tr>
</table> -->

</td>
</tr>
</table>
<?php
}
?>
</div>

<?php
$teams = array_map('trim', $teams);
// -------------------------------------------------------------------------------------------------------------- 
?>
</div>
</div>				<!--end div of LOGIN BOX -->  
<!-- </div> -->     <!--end div of general-results players  -->  
</section>
</body>
</html>