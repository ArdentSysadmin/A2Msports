<?php
$num_teams = $num_of_teams;
$pow_vals = array(2,4,8,16,32,64,128,256,512);
$seed_team = $teams;

$log_val = ceil(log($num_teams, 2));
((in_array($log_val, $pow_vals)) or (in_array($num_teams, $pow_vals))) ? $total_rounds = $log_val : $total_rounds =  floor(log($num_teams, 2)) + 1;

$c = $total_rounds;

if($num_of_teams > 32)
	$c = 64;

$match_num = 1;
?>
<!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.5.3/jspdf.min.js"></script> -->
<script src="https://docraptor.com/docraptor-1.0.0.js"></script>
<link rel="stylesheet" href="<?php echo base_url();?>css/grids/grid_<?=$c;?>.css">
<link href="<?php echo base_url();?>css/foundation-datepicker.css" rel="stylesheet">
<script src="<?php echo base_url();?>js/foundation-datepicker.js"></script>
<!-- <script src="<?php echo base_url();?>js/printThis.js"></script> -->

<script>
$(document).ready(function(){
var baseurl = "<?php echo base_url();?>";

	$('#print_frm').click(function() {
		var temp = $('#temp').val();
		//var newWindow = window.open("", "_blank");
	 	 $.ajax({
			type: "POST",
			async:false,
			url:baseurl+'league/print_gen_se64_draws/',
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
<div class="general general-results players view-brack1">

<!-- LOGIN BOX -->
<div class="top-score-title right-score col-md-12" id='bracket_result' style="width: 74%; overflow-x: scroll;">
<h3>Bracket Generation</h3>
<!-- <div class="col-md-3" style='text-align:right;'>
<input type="hidden" name="temp" id="temp" value='<?=$temp;?>' />
<button type="button" id='print_frm' style="background-color:#81a32b">Print Draw</button>
</div> -->
<div class="col-md-12 login-page" style="width: 126%;">

<div class="col-md-9"><h3 style="margin-bottom:30px; margin-top:0px;text-align:left;"><?=$tour_name;?></h3></div>

<!-- <div class="col-md-3" style='text-align:right;'>
<input type="hidden" name="temp" id="temp" value='<?=$temp;?>' />
<button type="button" id='print_frm' style="background-color:#81a32b">Print Draw</button>
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


<script>
$('html, body').animate({
scrollTop: ($('#bracket_result').offset().top)
}, 500);
</script>