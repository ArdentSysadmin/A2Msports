<?php
$num_teams = $num_of_teams;
$pow_vals = array(2,4,8,16,32,64,128,256,512);
$seed_team = $teams;

$log_val = ceil(log($num_teams, 2));
((in_array($log_val, $pow_vals)) or (in_array($num_teams, $pow_vals))) ? $total_rounds = $log_val : $total_rounds =  floor(log($num_teams, 2)) + 1;

$match_num = 1;
?>
<html>
<head>
<link rel="stylesheet" href="<?php echo base_url();?>css/grids/print/grid_<?=$total_rounds;?>.css">
<link href="<?php echo base_url();?>css/foundation-datepicker.css" rel="stylesheet">
<script src="<?php echo base_url();?>js/foundation-datepicker.js"></script>
<!-- <script src="<?php echo base_url();?>js/printThis.js"></script> -->
</head>
<body style="background:url('<?=base_url();?>images/logo-watermark.gif');">
<!-- header -->
<table width="100%" border="0" cellspacing="0" cellpadding="0" align="center">
<tr>
<td style="border:2px solid #ff8a00">

<table width="100%" border="0" cellspacing="0" cellpadding="0">
<tr>
<td width="172" style="padding:10px">
<img class="scale_image" src="<?php echo base_url(); ?>images/logo.png" alt="" style="width:100px;" />
</td>
<td width="524">
<div align="center" style="font-size:18px; font-weight:bold"><?php echo $tour_name; ?></div>
</td>
</tr>
<tr>
<td colspan="2" style="height:6px; background:#81a32b; font-size:6px"></td>
</tr>
</table>
<!--  /header -->

<section id="login" class="container secondary-page">  
<!-- <div class="general general-results players view-brack1" style="background:url('<?=base_url();?>images/logo-watermark.gif'); width:100%; height:100%;"> -->
<div class="general general-results players view-brack1" style="width:100%; height:100%;">

<!-- LOGIN BOX -->
<div class="top-score-title right-score col-md-12" id='bracket_result'>
<!-- <h3>Bracket Generation</h3> -->
<div class="col-md-12 login-page">
<!-- <form method="post" id="myform" action='' class="login-form" style="width:100%;"> -->

<!-- <div class="col-md-9"><h3 style="margin-bottom:30px; margin-top:0px;text-align:left;"><?=$tour_name;?></h3></div>
<div class="col-md-3" style='text-align:right;'></div>
<br /> -->

<div class="brackets" id="brackets">

<div class="group<?php echo $total_rounds+1; ?>" id="b1">
<?php
for($round = 1, $source=1 ; $round <= $total_rounds; $round++) {
?>
<div class="r<?php echo $round; ?>" style="text-align:center">

<input type='hidden' name='round[]' value="<?php echo $round; ?>" />
<br>
<span style="text-align: center">
<b>
<?php
$process_res = league::cd_cal_c($pow_vals, $num_teams, $teams, $round, 'Main');
$teams		 = array();
$lteams		 = array();
$lteams_bye  = array();
$lteams_game = array();

$rt			 = $process_res[1] + $process_res[2];

if($rt >= pow(2,3)) {
	$rrt = $rt*2;
	echo "Round of $rrt";
}
else {
	switch($rt)	{
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
<br>
<!-- <input type="text" placeholder="Date" name="round_date<?php echo $round; ?>" id="sdate_round<?php echo $round; ?>" value="" /> -->
<?php
$x=0;
$cnt = count($process_res[6]);

foreach($process_res[6] as $ab => $game_pl){

	if($round == 1){
	if($process_res[6][$ab][1]=="---")
	{
		$ind = $cnt + $match_num;
		if(!in_array("M-$ind", $lteams)) {
			//echo 'cnt = '.$cnt." match# ". $match_num. "ind ".$ind."<br>";
			//$lteams_bye[] = "M-$ind";
			$lteams_game[] = "M-$ind";
		}
			if($match_num % 3 == 0 or $match_num == 1 or $match_num == 5 or $match_num == 14)
			$cnt--;
	}
	else
	{
		if(!in_array("M-$match_num", $lteams)) {
			//$lteams_game[] = "M-$match_num";
			$lteams_bye[] = "M-$match_num";
		}
			if($match_num % 3 == 0 or $match_num == 1 or $match_num == 5 or $match_num == 14)
			$cnt--;
	}


		$lteams = array_merge($lteams_game,$lteams_bye);
		$num_looser_arr = count($lteams);
		$looser_arr = $lteams;
	}

$y = 1;
	/*$player1 = explode(";", $process_res[6][$ab][0]);
	$player2 = explode(";", $process_res[6][$ab][1]);*/
	
	$player1 = $process_res[6][$ab][0];
	$player2 = $process_res[6][$ab][1];
	
$output =  "<span class='teama'>";
	if(!strpos($player1, ')') and $player1 != '---') { 
		$output .= $player1;
	}
	else { 
		$output .= "";
	}
	//if($player1[1]){ $output .= " - ".$player1[1]; }

		if($round == 1 and $player1 != '---') {
		$seed	 = array_search($player1, $seed_team);
		$output .= " #".($seed+1);
		}

$output .= "</span>";

$output .=  "<span class='teamb'>";
	if($player2 != '---'){ 
		if(!strpos($player2, ')')) {
			$output .= $player2;
		}
		else {
			$output .= "";
		}
	}
	else { 
		($round == 1) ? $mn = "Bye" : $mn = "";
		$output .= $mn; 
	}

		if($round == 1 and $player2 != '---') {
		$seed	 = array_search($player2, $seed_team);
		$output .= " #".($seed+1);
		}

	//if($player2[0] and $player2[1]){ $output .= " - ".$player2[1]; }
$output .= "</span>";
?>

<div class="bracketbox">
<span class="info"><?php echo $match_num; ?>
<!-- <input type="text" placeholder="Date" id="sdate<?php echo $match_num; ?>" name="match_date<?php echo $match_num; ?>" value="" /> -->

<script>
var rid = "<?php echo $match_num; ?>";

$('#sdate'+rid).fdatepicker({
		format: 'mm/dd/yyyy hh:ii',
		disableDblClickSelection: true,
		language: 'en',
		pickTime: true
});
</script>

</span>
<?php
echo $output;
?>
</div>

<?php
//$match_num++;

$y++;

	if($process_res[6][$ab][1]=='---'){

		if($round < 2){
		$teams[$x] = $process_res[6][$ab][0];
		}
		else{
		$teams[$x] = "---";
		}
		$x++;
	}
	else{

		$teams[$x] = '---';
		$x++;
	}

$match_num++;
}

unset($process_res[6]);
//print_r($teams);
//exit;

?>
</div>
<?php if($num_teams == 2){ ?>
  <div class="r<?php echo $total_rounds+1; ?>">
   		<div class="final">
        	<div class="bracketbox">
            	<span class="teamc"></span>
            </div>
        </div>
   </div>
<?php } ?>
<?php
$num_teams = $process_res[3];
$prev_round_games = $process_res[1];
($prev_round_games > 1) ? $process_res[1] = $process_res[1]/2: $process_res[1];
}
?>
</div>

</div>

<!-- ----------------------------- Consolation Draw ---------------------------- -->
<?php
$num_teams = $num_looser_arr;
$pow_vals = array(2,4,8,16,32,64,128,256,512);

$log_val = ceil(log($num_teams, 2));
((in_array($log_val, $pow_vals)) or (in_array($num_teams, $pow_vals))) ? $total_rounds = $log_val : $total_rounds =  floor(log($num_teams, 2)) + 1;

$match_num = 1;
?>
<link rel="stylesheet" href="<?php echo base_url();?>css/grids/print/cr<?=$total_rounds;?>.css">

<div class="brackets1" id="brackets1">
<div class="group<?php echo $total_rounds+1; ?>" id="b1">
<?php
for($round = 1, $source=1 ; $round <= $total_rounds; $round++) {
?>
<div class="r<?php echo $round; ?>" style="text-align:center">
<!-- <input type='hidden' name='c_round[]' value="<?php echo $round; ?>" /> -->
<br>
<script>
$(function() {
 var rid = "<?php echo $round; ?>";
 $('#sdate_cround'+rid).datepick();
});
</script>

<span style="text-align: center"><b>
<?php

$process_res = league::cd_cal_c($pow_vals, $num_teams, $lteams, $round, 'Consolation');
$lteams = array();

$rt = $process_res[1] + $process_res[2];
//--------------------------
if($rt >= pow(2,3)){
	$rrt = $rt*2;
	//echo "Round of $rrt";
	}
else {
		switch($rt)
		{
			case 1:
				echo "Consolation Draw";
				//echo "Final";
				break;
			case 2:
				//echo "Semi-Final";
				break;
			case 4:
				//echo "Quarter-Final";
				break;
			default:
				//echo "";
				break;
		}
	}
?>
</b></span>
<br>
<!-- <input  type="text" class='form-control' placeholder="Date" id="sdate_cround<?php echo $round; ?>"  name="cround_date<?php echo $round; ?>" /> -->

<?php
//--------------------------
$x=0;
foreach($process_res[8] as $ab => $game_pl){
$y = 1;
?>

<div class="bracketbox">
<span class="info"><?php echo $match_num; ?></span>

<span class="teama">
<?php
	if($process_res[8][$ab][0]){

		$double_pl = explode(";", $process_res[8][$ab][0]);

		if($double_pl[0]){ echo $double_pl[0]; }  else { echo ""; }
		if($double_pl[1]){ echo "; ".$double_pl[1]; }
	}
	else{
		echo $process_res[8][$ab][0];
	}
?>
</span>
<span class="teamb"><?php
	if($process_res[8][$ab][1]){

		$double_pl = explode("-", $process_res[8][$ab][1]);

		if($double_pl[0]){ echo $double_pl[0]; }  else { echo ""; }
		if($double_pl[1]){ echo "; ".$double_pl[1]; }
	}
	else{
		echo $process_res[8][$ab][1];
	}
?>
</span>
</div>
<?php
//$match_num++;

$y++;

	if($process_res[8][$ab][1] == '---'){
		if($round < 2){
		$lteams[$x] = $process_res[8][$ab][0];
		}
		else{
		$lteams[$x] = "";
		}
		$x++;
	}
	else{
		$lteams[$x] = "";
		$x++;
	}

$match_num++;
}

unset($process_res[8]);
?>
</div>
<?php if($num_teams == 2){ ?>
  <div class="r<?php echo $total_rounds+1; ?>">
   		 <div class="final final1">
        	<div class="bracketbox">
            	<span class="teamc"></span>
            </div>
     </div>
   </div>
<?php } ?>
<?php
$num_teams = $process_res[3];
$prev_round_games = $process_res[1];
($prev_round_games > 1) ? $process_res[1] = $process_res[1]/2: $process_res[1];
}
?>
</div>
<!--  ----------------------------  End of consolation draw ------------------------------- -->
<div style='clear:both;'></div>
</div>
</form>


</div><!--Close Login-->

</div> 
</section>

<!-- footer -->
<!-- <table width="100%" border="0" cellspacing="0" cellpadding="0">
<tr>
<td style="background:#81a32b; font-size:12px; padding:6px; color:#ffffff; text-align:center">&copy; 2016 a2msports.com. All rights reserved.</td>
</tr>
</table> -->
</body>
</html>