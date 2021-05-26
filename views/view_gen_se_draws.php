<?php
$num_teams = $num_of_teams;
$pow_vals  = array(2,4,8,16,32,64,128,256,512);
$seed_team = $teams;

$log_val = ceil(log($num_teams, 2));
((in_array($log_val, $pow_vals)) or (in_array($num_teams, $pow_vals))) ? $total_rounds = $log_val : $total_rounds =  floor(log($num_teams, 2)) + 1;

$match_num = 1;
?>
<script src="https://docraptor.com/docraptor-1.0.0.js"></script>
<link rel="stylesheet" href="<?php echo base_url();?>css/grids/grid_<?=$total_rounds;?>.css">
<link rel="stylesheet" href="<?php echo base_url();?>css/grids/grid_<?=$total_rounds;?>.css">
<link href="<?php echo base_url();?>css/foundation-datepicker.css" rel="stylesheet">
<script src="<?php echo base_url();?>js/foundation-datepicker.js"></script>
<script>
$(document).ready(function(){
	var baseurl = "<?php echo base_url();?>";

	$('#print_frm').click(function() {
		var temp = $('#temp').val();

	 	 $.ajax({
			type: "POST",
			async:false,
			url:baseurl+'league/print_gen_se_draws/',
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
</b>
</span>
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
foreach($process_res[6] as $ab => $game_pl) {
$y		 = 1;
/*$player1 = explode(";", $process_res[6][$ab][0]);
$player2 = explode(";", $process_res[6][$ab][1]);*/

$player1 = $process_res[6][$ab][0];
$player2 = $process_res[6][$ab][1];

$output  = "<span class='teama'>";
	if(!strpos($player1, ')') and $player1 != '---') {
		$output .= $player1; 
	}
	else if($round == 1 and $player1 == '---') {
		$output .= "Bye"; 
	}
	else { 
		$output .= ""; 
	}

	/*if($player1) {
		$output .= " - ".$player1;
	}*/

	if($round == 1 and $player1 != '---') {
		$seed	 = array_search($player1, $seed_team);
		//$output .= " #".($seed+1);
	}
$output .= "</span>";

$output .=  "<span class='teamb'>";
	if($player2 != '---') {
		if(!strpos($player2, ')')){
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
	/*if($player2 and $player2){ $output .= " - ".$player2; }*/
	$seed = '';
	if($round == 1 and $player2 != '---') {
	$seed = array_search($player2, $seed_team);
	//$output .= " #".($seed+1);
	}
$output .= "</span>";
?>

<div class="bracketbox">
<span class="info"><?php echo $match_num; ?>
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
<?=$output;?>
</div>
<?php
$y++;

	if($process_res[6][$ab][1]=='---') {

		if($round < 2){
		$teams[$x] = $process_res[6][$ab][0];
		}
		else{
		$teams[$x] = "---";
		}
		$x++;
	}
	else {

		$teams[$x] = '---';
		$x++;
	}

$match_num++;
}

unset($process_res[6]);
?>
</div>
<?php
if($num_teams == 2){
?>
<div class="r<?php echo $total_rounds+1; ?>">
<div class="final">
	<div class="bracketbox">
		<span class="teamc"></span>
	</div>
</div>
</div>
<?php
}
$num_teams		  = $process_res[3];
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
<script>

$('html, body').animate({
scrollTop: ($('#bracket_result').offset().top)
}, 500);

</script>