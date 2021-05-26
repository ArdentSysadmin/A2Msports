<?php
if($get_bracket['No_of_rounds']){
	$css_num = $get_bracket['No_of_rounds'];
?>
<link rel="stylesheet" href="<?php echo base_url();?>css/grids/grid_<?=$css_num;?>.css">
<?php
}
?>
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


$('.show_linematch_score').click(function (e) {

	var mid = $(this).attr('id');
	var header="show";
	//alert(mid);
	var a = mid.split('_');
	//if(('#lines_div').css('display') != 'none'){
	// $('#linematchscorelp2_'+a[1]).fadeOut(1000);
	//}
		
		  $.ajax({
			type: 'POST',
			url: baseurl+'league/get_line_matches',
			data:{'P':a[0], 'mid':a[1], 'T1':a[2], 'T2':a[3],'header':header},
			success: function(res){
				//console.log(res);
				  $('#linematchscorelp2').show();
				  $('#showlinematchscorelp2').html(res);
				  $('html, body').animate({
			          scrollTop: $("#linematchscorelp2").offset().top
			      }, 1500);
			}
		  });
		
	  e.preventDefault();
});

});

</script>
<form method="post" id="frm_upd_dates" class="login-form" style='width:100%;'>

<script language = "javascript" type = "text/javascript">
function myWin(tid)
{
	var path = "<?php echo base_url(); ?>";
	var tid = '<?php echo $bracket_id; ?>';
	window.open(path+'league/pdf/'+tid, null, "height=1200, width=1400, status=yes, toolbar=no, menubar=no, location=no");
}
</script>
<input type="hidden" name="update_draw_status" id="update_draw_status" value="1" />

<?php
$total_rounds	= $get_bracket['No_of_rounds'];
$bracket_id		= $get_bracket['BracketID'];
$tour_id		= $get_bracket['Tourn_ID'];

$list_matches	= $get_tourn_matches->result();
?>
<div class = "brackets" id="brackets">
<div class = "group<?php echo $total_rounds+1; ?>" id="b1">
<input type='hidden' name='bracket_id' value="<?php echo $get_bracket['BracketID']; ?>" />
<input type='hidden' name='tour_id'	value="<?php echo $get_bracket['Tourn_ID']; ?>" />

<?php
$nm = 0;
$round_type = array();
for($round = 1; $round <= $total_rounds; $round++) {
	foreach($list_matches as $m => $match){
		if($list_matches[$m]->Round_Num==$round){
			$round_dates[$round] = $list_matches[$m]->Match_DueDate;
			$nm++;
		}
	}
	$round_type[$round] = $nm;
	$nm = 0;
}

for($round = 1; $round <= $total_rounds; $round++) {
?>
<script>/*
$(function() {
 var rid = "<?php echo $round; ?>";
 $('#sdate_round'+rid).datepick();
});*/
</script>

<div class="r<?php echo $round; ?>">
<br>
<input type='hidden' name='round[]' value="<?php echo $round; ?>" />
<span style="margin-left:10px;"><b>
<?php
	$rt = $round_type[$round];
if($rt >= pow(2,3)){
	$rrt = $rt*2;
	echo "Round of $rrt";
	}
else
	{
		switch($rt)
		{
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
</b><br />
</span>
<br />
<?php
if($tour_details->Usersid == $this->logged_user){
?>

<!-- <input type = "text" class = 'form-control' placeholder = "Date" id = "sdate_round<?php echo $round; ?>" name = "round_date<?php echo $round; ?>" value = "<?php if($round_dates[$round] != "")
{ echo date('m/d/Y', strtotime($round_dates[$round])); } ?>" /> -->

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
} else {
	if($round_dates[$round] != "") { echo date("m-d-Y H:i",strtotime($round_dates[$round])); }
}
//print_r($list_matches);exit;
foreach($list_matches as $m => $match){
$get_team1  = "";
$get_team2  = "";

	if($list_matches[$m]->Round_Num == $round){
	?>
	<div class="bracketbox">
	<span class="info">
	<?php
	if($list_matches[$m]->Player1 != 0){
		 $get_team1	= league::get_team(intval($list_matches[$m]->Player1));
	}

	if($list_matches[$m]->Player2 != 0){
		 $get_team2 = league::get_team(intval($list_matches[$m]->Player2));
	}
	
	$match_num = $list_matches[$m]->Match_Num;
	echo $match_num;

if($tour_details->Usersid == $this->logged_user){
?>
<!-- <input  type="text" class='form-control' placeholder="Date" id="sdate<?php echo $match_num; ?>" name="match_date<?php echo $match_num; ?>" 
value = "<?php if($list_matches[$m]->Match_DueDate != "")
{ echo date('m/d/Y', strtotime($list_matches[$m]->Match_DueDate)); } ?>" /> -->
<script>/*
$(function() {
 var spid = "<?php echo $match_num; ?>";
 $('#sdate'+spid).datepick();
});*/
</script>


<script>
var mid = "<?php echo $match_num; ?>";

  $('#sdate'+mid).fdatepicker({
		format: 'mm/dd/yyyy hh:ii',
		disableDblClickSelection: true,
		language: 'en',
		pickTime: true
	});
</script>

<?php
} else {
	if($list_matches[$m]->Match_DueDate != "") { echo date("m-d-Y H:i",strtotime($list_matches[$m]->Match_DueDate)); }
}
?>
<br />
	<?php // if($list_matches[$m]->Match_DueDate != "") { echo date("m-d-Y",strtotime($list_matches[$m]->Match_DueDate)); } ?>
	<input type='hidden' name='match_num[<?php echo $round; ?>][]' value="<?php echo $match_num; ?>" />
	<input type='hidden' name='draw[]' value="<?php echo $list_matches[$m]->Draw_Type; ?>" />

	</span>
	<span class="teama"><?php
		if($get_team1){ 
		echo "<a href='#'>".$get_team1['Team_name']."</a>";
		}
		else { echo "----"; }?>

	<?php if($list_matches[$m]->Round_Num != 1){

		$get_source_scores1 = league::get_match_scores_player1($list_matches[$m]->Player1_source, $bracket_id, $tour_id, $list_matches[$m]->Draw_Type);
	

		//if($get_source_scores1['Player1_Score'] !="" && $get_source_scores1['Player1_Score'] !="Bye Match"){

		$p1 = $get_source_scores1['Player1_points'];
		$p2 = $get_source_scores1['Player2_points'];
		$tourn_match_id = $get_source_scores1['Tourn_match_id'];
		$player1 = $get_source_scores1['Player1'];
		$player2 = $get_source_scores1['Player2'];
             echo '<a href="" class="show_linematch_score" style="cursor:pointer;font-weight:bold;" 
             id="P2_'.$tourn_match_id.'_'.$player1.'_'.$player2.'">';
			  if($get_source_scores1['Winner'] == $get_source_scores1['Player1']){
					echo "($p1 - $p2) ";
			  }
			  else{
					echo "($p2 - $p1) ";
			  }
			  echo "</a>";
		//}
	}
	?>
	</span>
	<span class='team2'>&nbsp
	</span>
	<span class="teamb">
	<?php 
	if($list_matches[$m]->Round_Num == 1 and $list_matches[$m]->Player2 != 0){ 
		echo "<a href='#'>".$get_team2['Team_name']."</a>"; 
	}
	else if($list_matches[$m]->Round_Num != 1 and $list_matches[$m]->Player2 == 0){ 
		echo "---"; 
	}
	else if($get_team2){ 
		echo "<a href='#'>".$get_team2['Team_name']."</a>"; 
	}
	else{ 
		echo "Bye"; 
	}
	?>

<?php if($list_matches[$m]->Round_Num != 1){

		$get_source_scores2 = league::get_match_scores_player2($list_matches[$m]->Player2_source,$bracket_id,$tour_id,$list_matches[$m]->Draw_Type);

		//if($get_source_scores2['Player1_Score'] !=""){
			$p1 = $get_source_scores2['Player1_points'];
			$p2 = $get_source_scores2['Player2_points'];
			$tourn_match_id = $get_source_scores2['Tourn_match_id'];
            $player1 = $get_source_scores2['Player1'];
		    $player2 = $get_source_scores2['Player2'];
             echo '<a href="" class="show_linematch_score" style="cursor:pointer;font-weight:bold;" 
             id="P2_'.$tourn_match_id.'_'.$player1.'_'.$player2.'">';
				  if($get_source_scores2['Winner'] == $get_source_scores2['Player1']){
						echo "($p1 - $p2) ";
				  }
				  else{
						echo "($p2 - $p1) ";
				  }
				  echo "</a>";
			//}
		}
		echo "";
		?>
	</span>
	</div>
<? }
 }
?>
</div>

<?php if(($round) == $total_rounds){ ?>
  <div class="r<?php echo $total_rounds+1; ?>">
   		<div class="final" <?php if($round == 2){ echo "style='margin:84px 0 224px 0'"; } ?>>
        	<div class="bracketbox">
            	<span class="teamc">
				<?php
				if($list_matches[$m]->Winner != 0){

					if($list_matches[$m]->Winner == $list_matches[$m]->Player1){
						 $get_team1			= league::get_team(intval($list_matches[$m]->Player1));
							
							echo "<h5 style='color:#f59123'><b>";
							if($get_team1){ 
							echo "<a href='#'>".$get_team1['Team_name']."</a>";
							}
							echo "</b></h5>";

							//if($list_matches[$m]->Player1_Score !=""){
								$p1 = $list_matches[$m]->Player1_points;
								$p2 = $list_matches[$m]->Player2_points;
                                 $player1 = $list_matches[$m]->Player1;
		                         $player2 = $list_matches[$m]->Player2;
             echo '<a href="" class="show_linematch_score" style="cursor:pointer;font-weight:bold;" 
             id="P2_'.$list_matches[$m]->Tourn_match_id.'_'.$player1.'_'.$player2.'">';
                                 
									echo "($p1 - $p2) ";
									 echo "</a>";
							//} 
					}
					else{
						 $get_team2			= league::get_team(intval($list_matches[$m]->Player2));
							
							echo "<h5 style='color:#f59123'><b>";
							if($get_team2){ 
								echo "<a href=''>".$get_team2['Team_name']."</a>";
							}
							echo "</b></h5>";

							//if($list_matches[$m]->Player1_Score !=""){
								$p1 = $list_matches[$m]->Player1_points;
								$p2 = $list_matches[$m]->Player2_points;
					            $player1 = $list_matches[$m]->Player1;
		                        $player2 = $list_matches[$m]->Player2;
             echo '<a href="" class="show_linematch_score" style="cursor:pointer;font-weight:bold;" 
             id="P2_'.$list_matches[$m]->Tourn_match_id.'_'.$player1.'_'.$player2.'">';
								echo "($p2 - $p1) ";
								 echo "</a>";
							//}
					}
				}
				?>
				</span>
            </div>
        </div>
   </div>

<?php } ?>
<!-- <input type="hidden" id="tourn_id"  name="tourn_id" value="<?php echo $this->input->post('tourn_id'); ?>" />
<input type='hidden' name='match_type'	value="<?php echo $this->input->post('types'); ?>" />
<input type='hidden' name='age_group'	value="<?php echo $this->input->post('type_gen'); ?>" />
<input type='hidden' name='ttype'		value="<?php echo $this->input->post('ttype'); ?>" />
 -->
<?
}
?>
</div>
</div>
</form>
<div id="linematchscorelp2" style="display:none;"> 
<table class='tab-score' id="showlinematchscorelp2">
<!-- Dynamic Lines Data loads from AJAX -->
</table>
</div>