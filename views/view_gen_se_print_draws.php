<?php
$num_teams = $num_of_teams;
$pow_vals = array(2,4,8,16,32,64,128,256,512);
$seed_team = $teams;

$log_val = ceil(log($num_teams, 2));
((in_array($log_val, $pow_vals)) or (in_array($num_teams, $pow_vals))) ? $total_rounds = $log_val : $total_rounds =  floor(log($num_teams, 2)) + 1;

$match_num = 1;
?>
<!doctype html>
<html lang="en">
<head>
<style type="text/css">
  @page { size: A4; }
  @page { margin: 0; }
  body  { font-size: 100%; }
</style>
<title>Document</title>
<link rel="stylesheet" href="<?php echo base_url();?>css/grids/print/grid_<?=$total_rounds;?>.css">
<link href="<?php echo base_url();?>css/foundation-datepicker.css" rel="stylesheet">
<script src="<?php echo base_url();?>js/foundation-datepicker.js"></script>
</head>
<body style="background:url('<?=base_url();?>images/logo-watermark.gif')">

<!-- header -->
<table width="100%" height="100%" border="0" cellspacing="0" cellpadding="0" align="center">
<tr>
<!-- <td style="border:2px solid #ff8a00;background:url('<?=base_url();?>images/logo-watermark.gif')" valign="top">
 --><td style="border:2px solid #ff8a00;" valign="top">

<table width="100%" border="0" cellspacing="0" cellpadding="0">
<tr>
<td width="172" style="padding:3px;">
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
<div class="general general-results players view-brack1">

<!-- LOGIN BOX -->
<div class="top-score-title right-score col-md-12">
<div class="col-md-12 login-page">

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
$process_res = league::cal_c($pow_vals, $num_teams, $teams, $round);
$teams		 = array();
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
<br />
<?php
$x=0;
foreach($process_res[6] as $ab => $game_pl){

$y = 1;
/*	$player1 = explode(";", $process_res[6][$ab][0]);
	$player2 = explode(";", $process_res[6][$ab][1]);*/

	$player1 = $process_res[6][$ab][0];
	$player2 = $process_res[6][$ab][1];
	
$output =  "<span class='teama'>";
	if(!strpos($player1, ')') and $player1 != '---') { 
		$output .= $player1; 
	}
	else if($round == 1 and $player1 == '---') {
		$output .= "Bye"; 
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
	if($player2 != '---') { 
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
	//if($player2 and $player2){ $output .= " - ".$player2; }
	$seed = '';
	if($round == 1 and $player2 != '---') {
	$seed = array_search($player2, $seed_team);
	$output .= " #".($seed+1);
	}
$output .= "</span>";
?>

<div class="bracketbox">
<span class="info"><?php echo $match_num; ?></span>
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

<div style='clear:both;'></div>
</div>
</form>

</div>
</div><!--Close Login-->

</div> 
</section>

<!-- footer -->

<!-- <div style="background:#81a32b; font-size:12px; height:25px; color:#ffffff; text-align:center; position:absolute; bottom:11px; width:99%;">&copy; 2016 a2msports.com. All rights reserved.</div> -->


</td>
</tr>
</table>
</body>
</html>