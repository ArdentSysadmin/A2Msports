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
			url:baseurl+'league/print_gen_rr_draws/',
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

	$('#print_grid').click(function() {
		var temp = $('#temp').val();
		//var newWindow = window.open("", "_blank");

		 $.ajax({
			type: "POST",
			async:false,
			url:baseurl+'league/print_gen_rr_draws_grid/',
			data:{temp:temp},
			dataType: "html",
			success: function(res){
				var w = window.open('test');
				w.document.open();
				w.document.write(res);
				w.document.close();
		   }
		});
	});
});
</script>

<section id="login" class="container secondary-page">  
<!-- <div class="general general-results players"> -->
<!-- LOGIN BOX -->
<div class="top-score-title right-score col-md-9" id='bracket_result'>
<h3>Round Robin Matches</h3>
<div>

<!-- <form method="post" id="myform" action='<?php echo base_url(); ?>league/bracket_save' class="col-md-8 login-page">  -->
<div class="col-md-9"><h3 style="margin-bottom:0px; margin-top:0px;text-align:left;"><?=$tour_name;?></h3></div>
<input type="hidden" name="temp" id="temp" value='<?=$temp;?>' />
<div class="col-md-3" style='text-align:right;'><button type="button" id='print_frm' style="background-color:#81a32b">Print</button></div>
<?
//---------------------Calculation section ------------------------------ 

foreach($robins as $round => $games) {

	$total_matches = count($games);
	if($total_matches > 3) {
		$group_matches = ($total_matches % 2 == 0) ? ($total_matches / 2) : ($total_matches / 3);

		if($group_matches > 10 and $group_matches < 19)	{
		$group_matches = ($total_matches % 4 == 0) ? ($total_matches / 4) : ($total_matches / 5);
		}
		else if($group_matches > 18){
		$group_matches = ($total_matches % 6 == 0) ? ($total_matches / 6) : ($total_matches / 7);
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

			/*$rr_p1 = explode('-', $game[0]);
			$rr_p2 = explode('-', $game[1]);

			$rr_matches[$round][$match_num][($game_num+1)][] = $rr_p1[0];
			$rr_matches[$round][$match_num][($game_num+1)][] = $rr_p2[0];*/
		
			$rr_matches[$round][$match_num][($game_num+1)][] = $game[0];
			$rr_matches[$round][$match_num][($game_num+1)][] = $game[1];

		if($match_num != $group_matches && $per_group_matches == $per_round_count){
			$match_num++;
			$per_round_count = 1;
		}
		else{
			$per_round_count++;
		}

	}

}
//echo "<pre>"; print_r($rr_matches); exit;
// ---------------------------------------------------------------------
?>

<div id='test123' class='tab-content' style='background:#fff;'>

<?php
$head  = 'Player';
$index = 1;

foreach($rr_matches as $round => $matches){
?>
<div>
<table class='tab-score'>
<tr class='top-scrore-table'>
<td align='center'>#</td>
<td align='center' colspan='3'>Round <?=$round;?></td>
<!-- <td align='center'>Score</td> -->
</tr>
<?php
foreach($matches as $match => $games) {
//echo "<tr align='center'><td colspan='4'><b>Match {$match}</b></td></tr>";
echo "<tr align='center'><td colspan='2'>&nbsp;</td><td><b>Match {$match}</b>&nbsp;&nbsp;</td><td>&nbsp;</td></tr>";


foreach($games as $game) {
	/*$rr_p1 = explode('-', $game[0]);
	  $rr_p2 = explode('-', $game[1]);*/

	$rr_p1 = $game[0];
	$rr_p2 = $game[1];

	$mdate = "<input type='text' placeholder='Date' name='game_date{$index}' id='game_date{$index}' value='' />";

	$player1 = (!strpos($rr_p1, ')')) ? $rr_p1 : "______________________";
	$player2 = (!strpos($rr_p2, ')')) ? $rr_p2 : "______________________";

	$p1_part = "";
	$p2_part = "";

	/*if($rr_p1[1]){
		$p1_part = "; $rr_p1[1]";
	}

	if($rr_p2[1]){
		$p2_part = "; $rr_p1[2]";
	}*/

 echo "<tr>
 <td align='center'>".$index."</td>
 <td align='center'>".$player1." ".$p1_part."</td>
 <td align='center' style='font-weight:normal'>_____________________</td>
 <td align='center' style='font-weight:normal'>".$player2." ".$p2_part."</td>
 </tr>";

$index++;
}
}
echo "</table>";
echo "</div>";
echo "<div class='pagebreak'>&nbsp;</div>";
}
?>
</div>
<br />
<br />

<?
$teams = array_map('trim', $teams);

// -------------------------------------------------------------------------------------------------------------- ?>
<input type="hidden" name="players" id="players" value='<?php echo serialize($teams); ?>' />
<input type='hidden' name='ttype'	value="<?php echo $this->input->post('ttype'); ?>"    />
<input type='hidden' name='tformat' value="<?php echo $this->input->post('tformat'); ?>"  />

</div>
</div>				 
<!--end div of LOGIN BOX -->  
<!--end div of general-results players  -->  
</section>

<?php
$w = 100 / (count($teams) + 2);
?>
<div class="col-md-9"><h3 style="margin-bottom:0px; margin-top:0px;text-align:left;"><?=$tour_name;?></h3></div>
<div class="col-md-3" style='text-align:right;'><button type="button" id='print_grid' style="background-color:#81a32b">Print</button></div>

<div class="top-score-title right-score" style="width: 100%;  overflow-x: scroll;">
	<table class="tab-score" border="0">
	<tr align="center" height="40">
	<td style="width:<?=floor($w).'%';?>">&nbsp;</td>
	<?php 
	foreach($teams as $i => $team) {
		$temp_name = (!strpos($team, ')')) ? $team : "______________________";
	echo "<td valign='bottom' style='".floor($w).'%'."'><b>$temp_name</b></td>";
	}
	?>
	<td valign='bottom' style="width:<?=floor($w).'%';?>"><b>Points</b></td>
	</tr>

	<?php 
	foreach($teams as $j => $team1) { 
	?>
	<tr align="center" height="40">
	<td align="center" valign='bottom'><b><?php echo (!strpos($team1, ')')) ? $team1 : "_______________"; ?></b></td>

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
</div>

<script>
$('html, body').animate({
scrollTop: ($('#bracket_result').offset().top)
}, 500);
</script>