<?php
$num_teams = $num_of_teams;
$pow_vals  = array(2,4,8,16,32,64,128,256,512);
$seed_team = $teams;

$log_val = ceil(log($num_teams, 2));
((in_array($log_val, $pow_vals)) or (in_array($num_teams, $pow_vals))) ? $total_rounds = $log_val : $total_rounds =  floor(log($num_teams, 2)) + 1;

$match_num = 1;
?>
<link rel="stylesheet" href="<?php echo base_url();?>css/grids/grid_<?=$total_rounds;?>.css">
<link href="<?php echo base_url();?>css/foundation-datepicker.css" rel="stylesheet">
<script src="<?php echo base_url();?>js/foundation-datepicker.js"></script>

<script>
$(document).ready(function(){
var baseurl = "<?php echo base_url();?>";

	$('#print_frm').click(function() {
		var temp = $('#temp').val();
		//var newWindow = window.open("", "_blank");

		 $.ajax({
			type: "POST",
			async:false,
			url:baseurl+'league/print_gen_cd_draws/',
			data:{temp:temp},
			dataType: "html",
			success: function(res){
				var w = window.open('about:blank');
				w.document.open();
				w.document.write(res);
				w.document.close();
		   }
		});
	});
});
</script>

<section id="login" class="container secondary-page">  
<div class="general general-results players view-brack1" style="width: 74%; height: 100%; overflow-x: scroll;">

<!-- LOGIN BOX -->
<div class="top-score-title right-score col-md-12" id='bracket_result'>
<h3>Bracket Generation</h3>
<div class="col-md-12 login-page" style="display:grid">
<div class="row">
<div class="col-md-9"><h3 style="margin-bottom:30px; margin-top:0px;text-align:left;"><?=$tour_name;?></h3></div>
<div class="col-md-3" style='text-align:right;'>
<input type="hidden" name="temp" id="temp" value='<?=$temp;?>' />
<button type="button" id='print_frm' style="background-color:#81a32b">Print</button>
</div>
</div>
<br />

<div class="brackets" id="brackets">

<div class="group<?php echo $total_rounds+1; ?>" id="b1">
<?php
for($round = 1, $source=1 ; $round <= $total_rounds; $round++) {
?>
<div class="r<?php echo $round; ?>" style="text-align:center">

<input type='hidden' name='round[]' value="<?php echo $round; ?>" />
<br />
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
	if(!strpos($player1, ')') and $player1 != '---'){ $output .= $player1; } else { $output .= ""; }

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
	else { ($round == 1) ? $mn = "Bye" : $mn = "";
	$output .= $mn; }

	if($round == 1 and $player2 != '---') {
		$seed	 = array_search($player2, $seed_team);
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

</div>

<!-- ----------------------------- Consolation Draw ---------------------------- -->
<?php
$num_teams = $num_looser_arr;
$pow_vals = array(2,4,8,16,32,64,128,256,512);

$log_val = ceil(log($num_teams, 2));
((in_array($log_val, $pow_vals)) or (in_array($num_teams, $pow_vals))) ? $total_rounds = $log_val : $total_rounds =  floor(log($num_teams, 2)) + 1;

$match_num = 1;
$cd_tr	   = $total_rounds;
?>

<link rel="stylesheet" href="<?php echo base_url();?>css/grids/cr<?=$cd_tr;?>.css">

<div class="brackets1" id="brackets1">
<div class="group<?php echo $total_rounds+1; ?>" id="b1">
<?php
for($round = 1, $source=1; $round <= $total_rounds; $round++) {
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
<br />

<?php
//--------------------------
$x=0;
foreach($process_res[8] as $ab => $game_pl){
	
$y = 1;
?>
<input type='hidden' name="c_match_num[<?php echo $round; ?>][]" value="<?php echo $match_num; ?>" />
<input type='hidden' name="c_player1[<?php echo $round; ?>][<?php echo $match_num; ?>][0]" value="<?php //echo $process_res[6][$ab][0]; ?>" />
<input type='hidden' name="c_player1[<?php echo $round; ?>][<?php echo $match_num; ?>][1]" value="<?php 
	if($round > 1) { $s = $match_num - ($match_num - $source); echo $s; $source++; } else { $s = explode("-", $process_res[8][$ab][0]);
  echo intval($s[1]); } ?>" />

<input type='hidden' name="c_player2[<?php echo $round; ?>][<?php echo $match_num; ?>][0]" value="<?php //echo $process_res[6][$ab][1]; ?>" />
<input type='hidden' name="c_player2[<?php echo $round; ?>][<?php echo $match_num; ?>][1]" value="<?php 
	if($round > 1) { $s = $match_num - ($match_num - $source); echo $s; $source++; } else { $s = explode("-", $process_res[8][$ab][1]);
  echo intval($s[1]); } ?>" />

<div class="bracketbox">
<span class="info"><?php echo $match_num; ?>
<!-- 
<input  type="text" class='form-control' placeholder="Date" id="sdate_c<?php echo $match_num; ?>"  name="cmatch_date<?php echo $match_num; ?>" /> -->
</span>

<span class="teama">
<?php
	if($process_res[8][$ab][0]){

		$double_pl = explode(";", $process_res[8][$ab][0]);

		if($double_pl[0]){ echo $double_pl[0]; } else { echo ""; }
		if($double_pl[1]){ echo "; ".$double_pl[1]; }
	}
	else{
		echo $process_res[8][$ab][0];
	}
?>
</span>
<span class="teamb">
<?php
	if($process_res[8][$ab][1]){

		$double_pl = explode("-", $process_res[8][$ab][1]);

		if($double_pl[0]){ echo $double_pl[0]; } else { echo ""; }
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

	if($process_res[8][$ab][1]=='---'){
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
<!-- <div><input type="submit" class="league-form-submit1" name="bracket_confirm" id="bracket_confirm" value="Confirm & Save" /></div> -->
</div>
</form>

</div><!--Close Login-->

</div> 
</section>
<script>
$('html, body').animate({
scrollTop: ($('#bracket_result').offset().top)
}, 500);
</script>