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
<div class="top-score-title right-score col-md-12" id='bracket_result'>
<div class="col-md-12 login-page" style="width: 126%;">

<!-- <div class="col-md-9"><h3 style="margin-bottom:30px; margin-top:0px;text-align:left;"><?=$tour_name;?></h3></div>
<div class="col-md-3" style='text-align:right;'>
<input type="hidden" name="temp" id="temp" value='<?=$temp;?>' />
<button type="button" id='print_frm'>Print</button>
</div> -->

<!-- Brackets  -->
<div style="width:100%; top:0px; left:0px">
<div class="brackets1" id="brackets">
<div class="group6" id="b0">
<?php
for($round = 1, $source=1 ; $round <= $total_rounds; $round++) {

//echo $pow_vals."-".$num_teams."-".count($teams)."-".$round."<br>";
	$process_res = league::cal_c($pow_vals, $num_teams, $teams, $round);
	$teams		 = array();
	$rt			 = $process_res[1] + $process_res[2];
/*echo "<pre>";
print_r($teams);
print_r($process_res[6]);
exit;*/

$bracket_right .= "<div class='r{$round}'>";
echo "<div class='r{$round}'>";
$x=0;
	foreach($process_res[6] as $ab => $game_pl){

	$y = 1;

		$player1 = explode(";", $process_res[6][$ab][0]);
		$player2 = explode(";", $process_res[6][$ab][1]);

		$output =  "<span class='teama'>";
			if(!strpos($player1[0], ')') and $player1[0] != '---') {
				$output .= $player1[0]; 
			}
			else if($round == 1 and $player1[0] == '---'){
				$output .= "Bye"; 
			}
			else { 
				$output .= ""; 
			}

			if($player1[1]) {
				$output .= " - ".$player1[1];
			}
			if($round == 1 and $player1[0] != '---'){
			$seed = array_search($player1[0], $seed_team);
			$output .= " #".($seed+1);
			}
		$output .= "</span>";

		$output .=  "<span class='teamb'>";
			if($player2[0] != '---') {
				if(!strpos($player2[0], ')')){
					$output .= $player2[0];
				}
				else {
					$output .= "";
				}
			}
			else { 
				($round == 1) ? $mn = "Bye" : $mn = "";
				$output .= $mn; 
			}
			/*if($player2[0] and $player2[1]){ $output .= " - ".$player2[1]; }*/
			$seed = '';
			if($round == 1 and $player2[0] != '---'){
			$seed = array_search($player2[0], $seed_team);
			$output .= " #".($seed+1);
			}
		$output .= "</span>";
?>
<?php
//echo "r ".$round;
if($ab > (count($process_res[6])/2 - 1) and $round != 6){

	//echo "R ab = ".$ab." count-1 = ".(count($process_res[6])/2 - 1)."<br>";
	if($round != 6) {
		$bracket_right .= "<div>";
		$bracket_right .= "<div class='bracketbox'>";
		$bracket_right .= $output;
		$bracket_right .= "</div>";
		$bracket_right .= "</div>";
	}
	else {
        $bracket_right .= "<div class='final'>";
        $bracket_right .= "<div class='bracketbox'>";
        $bracket_right .= "<span class='teamc'></span>";
        $bracket_right .= "</div>";
        $bracket_right .= "</div>";
	}
}
else{
	//echo "L ab = ".$ab." count-1 = ".(count($process_res[6])/2 - 1)."<br>";

?>
		<?php if($round != 6){?>
            <div>
                <div class="bracketbox">
				<?php echo $output; ?>
				</div>
            </div>
		<?php  
		} 
		else {
		?>
            <div class="final">
                <div class="bracketbox">
					<span class="teamc"></span>
				</div>
            </div>
<?php	}
} // end of bracket cond.. 
?>
<?php
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

$bracket_right .= "</div>";
echo "</div>";

unset($process_res[6]);

$num_teams = $process_res[3];
$prev_round_games = $process_res[1];
($prev_round_games > 1) ? $process_res[1] = $process_res[1]/2: $process_res[1];

}
?>    
</div>
</div>
</div>

<div style="width:100%; position:absolute; top:0px; right:0px">
<div class="brackets" id="brackets">
<div class="group6" id="b0">
<?php echo $bracket_right; ?>
</div>
</div>
</div>

<div style="clear:both"></div>

<!-- Close Brackets  -->

</div>
</div>
<!-- Close LOGIN BOX -->

</div> 
</section>


</td>
</tr>
</table>
</body>
</html>