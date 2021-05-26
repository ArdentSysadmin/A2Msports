<link href="<?php echo base_url();?>css/foundation-datepicker.css" rel="stylesheet">
<script src="<?php echo base_url();?>js/foundation-datepicker.js"></script>

<script>
$(document).ready(function(){

var baseurl = "<?php echo base_url();?>";

$('#update_draw').click(function (e) {
	  $.ajax({
		type: 'POST',
		url: baseurl+'league/view_matches',
		data: $('#frm_upd_dates').serialize(),
		success: function() {
		  location.reload();
		}
	  });
	  e.preventDefault();

	});

$('.dis_opp').click(function(){
	var id = $(this).attr("id"); 

	if($('#opp_row'+id).is(':visible')){
		$('#opp_row'+id).hide();
	}
	else
	{
		$('#opp_row'+id).show();
	}

});
});
</script>
<script src="<?php echo base_url();?>js/jquery.accordion.js" type="text/javascript"></script>
<script type="text/javascript">
$(document).ready(function () {
$(function () {
"use strict";
$('.accordion').accordion({ defaultOpen: 'up_match_section' }); //some_id section1 in demoup_tour_section
});
});
</script>

<script language="javascript" type="text/javascript">
function myWin(tid)
{
var path = "<?php echo base_url(); ?>";
var tid = '<?php echo $bracket_id; ?>';
window.open(path+'league/pdf/'+tid,null,"height=1200,width=1400,status=yes,toolbar=no,menubar=no,location=no");
}
</script>

<script>
$(document).ready(function(){

var baseurl = "<?php echo base_url();?>";

	$(".add_comment").click(function(){
		var pid = $(this).attr('name');

		if($("#comment"+pid).css('display')=='none'){
		$("#comment"+pid).show();
		$("#forfeit"+pid).hide();
		$("#score"+pid).hide();
		}
		else{
		$("#forfeit"+pid).hide();
		$("#score"+pid).hide();
		$("#comment"+pid).hide();
		}
	});

	$('.send_comment').on('click', function(e) {

		  var pid = $(this).attr('name');
		  var id  = pid.split('#');
		
		  var Tourn_match_id	= $("#match_id"+id[1]).val();
		  var Comments			= $("#message"+id[1]).val();
		  var Player1			= $("#player1_id"+id[1]).val();
		  var Player1_Partner	= $("#player1_part_id"+id[1]).val();
		  var Player2			= $("#player2_id"+id[1]).val();
		  var Player2_Partner	= $("#player2_part_id"+id[1]).val();
		  var Tourn_id			= $("#tourn_id"+id[1]).val();

	  $.ajax({
		type: 'POST',
		url: baseurl+'league/add_comments',
		data:{com:Comments,match_id:Tourn_match_id,player1:Player1,player1_partner:Player1_Partner,player2:Player2,player2_partner:Player2_Partner,tourn_id:Tourn_id},
		success: function(res) {
		 $("#message"+id[1]).val("");
		 //$("#sub_status").html("<b style='color:blue'>your comments are submitted!</b>");
		 $("#comments_div"+id[1]).html(res);  
		}
	  });
	 
	});

});
</script>

<br />
<input type="button" class="league-form-submit1" name="capture" id="capture" value="Print" style="float:right;" onclick="myWin(<?=$bracket_id;?>)" />
<br />
<br />
<form method="post" id="frm_upd_dates">
<?php
$rr_matches = $get_rr_tourn_matches->result();
//$tourn_id = $get_bracket_details['Tourn_ID'];

$teams = array();

foreach($rr_matches as $m => $match){
	if(!in_array($rr_matches[$m]->Player1, $teams)){
		$teams[] = $rr_matches[$m]->Player1;
	}

	if(!in_array($rr_matches[$m]->Player2, $teams)){
		$teams[] = $rr_matches[$m]->Player2;
	}
}
?>
<!-- Player standing points section start -->

<div class="col-md-12 league-form-bg" style="margin-top:40px; margin-bottom:20px;">
<div class="accordion"  id="up_match_section"  style="background:#f59123; padding:5px; color:white;"><i class="fa fa-arrow-circle-o-right" style="color:white;"> </i>Standings<span></span></div>
<?php
$num_matches = count($teams) - 1;
?>
<div class="tab-content table-responsive">

<table class="tab-score">
<tr class="top-scrore-table">
<td class="score-position" valign="center" align="center">Team</td>
<?php
for($i = 1;$i <= $num_matches; $i++){
	echo "<td class='score-position' valign='center' align='center'>Match $i&nbsp;&nbsp;</td>";	
}
?>
<td class="score-position" valign="center" align="center">Total&nbsp;&nbsp;</td>
<td class="score-position" valign="center" align="center">Win%&nbsp;&nbsp;</td>
</tr>
<?php
foreach($teams as $player){
	$tot_p = 0;
	$player_tot_score = 0;
	$p1p2_tot_score = 0;

	foreach($rr_matches2 as $m2 => $match2){
		if($rr_matches2[$m2]->Player1 == $player or $rr_matches2[$m2]->Player2 == $player){

		$p1_sum	= 0;
		$p2_sum = 0;
		$p1		= array();
		$p2		= array();

				if($rr_matches2[$m2]->Player1 == $player) { 
						$tot_p += $rr_matches2[$m2]->Player1_points;

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

				} 
				else { 
						$tot_p += $rr_matches2[$m2]->Player2_points;

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
				}
				$player_tot_score	+= ($p1_sum);
				$p1p2_tot_score		+= ($p1_sum+$p2_sum);
		}
	}
$win_per = ($player_tot_score / $p1p2_tot_score)*100;

$players_sort[$player] = array('points' => $tot_p, 'win_per' => number_format($win_per, 2));
}

$sort_func = uasort($players_sort, array('league','compareOrder'));
?>
<?php
//arsort($players_sort);

foreach($players_sort as $player => $tot_score)
{
?>
<tr>
<td align="left">&nbsp;
<?php
$get_name = league::get_team($player);
	echo "<img id='".$player."' class='dis_opp' src='".base_url()."icons/right.png'"." style=width:25px;height:25px;cursor:pointer"." /><b><a href='#'>".$get_name['Team_name']."</a></b>";
?>
</td>
	<?php

	foreach($rr_matches as $m2 => $match2){
		if($rr_matches[$m2]->Player1 == $player or $rr_matches[$m2]->Player2 == $player){

				if($rr_matches[$m2]->Player1 == $player){ 
					//echo "<td align='center'>".$rr_matches[$m2]->Player1_points."</td>";
					echo "<td align='center'>xx</td>";
				}
				else if($rr_matches[$m2]->Player2 == $player){
					//echo "<td align='center'>".$rr_matches[$m2]->Player2_points."</td>"; 
					echo "<td align='center'>xx</td>"; 
				}

				$player_tot_score += ($p1_sum);
				$p1p2_tot_score   += ($p1_sum+$p2_sum);
		}
		/*else
		{
			echo "<td> - </td>";	
		}*/
	
	}

	?>
<td align='center'><?php echo $tot_score['points']; ?></td>
<td align='center' style='font-weight:400'>
<?php echo $tot_score['win_per']; ?></td>
</tr>

<!-- Opponent Row -->
<tr id='opp_row<?=$player;?>' style='display:none;'>
<td align="left">&nbsp;</td>
<?php
	foreach($rr_matches as $m2 => $match2){
		if($rr_matches[$m2]->Player1 == $player or $rr_matches[$m2]->Player2 == $player){

				if($rr_matches[$m2]->Player1 == $player){ 
					$get_name = league::get_team($rr_matches[$m2]->Player2);
					echo "<td align='center'><b><a href='#'>".$get_name['Team_name']."</a></b></td>";
				}
				else if($rr_matches[$m2]->Player2 == $player){
					$get_name = league::get_team($rr_matches[$m2]->Player1);
					echo "<td align='center'><b><a href='#'>".$get_name['Team_name']."</a></b></td>";
				}

				$player_tot_score += ($p1_sum);
				$p1p2_tot_score	  += ($p1_sum+$p2_sum);
		}
		/*else
		{
			echo "<td> - </td>";	
		}*/
	}
?>
<td align='center'>&nbsp;</td>
<td align='center' style='font-weight:400'>&nbsp;</td>
</tr>
<!-- Opponent Row -->

<?php
}
?>
</table>

</div>
</div>

<!-- End of Team Standing section -->
