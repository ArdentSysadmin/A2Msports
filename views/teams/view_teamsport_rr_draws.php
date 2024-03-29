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
<!-- <input type="button" class="league-form-submit1" name="capture" id="capture" value="Print" style="float:right;" onclick="myWin(<?=$bracket_id;?>)" /> -->
<br />
<br />
<form method="post" id="frm_upd_dates">
<?php 
$rr_matches = $get_rr_tourn_matches->result();
//$tourn_id = $get_bracket_details['Tourn_ID'];

$players = array();
foreach($rr_matches as $m => $match){

	if(!in_array($rr_matches[$m]->Player1, $players)){
		$players[] = $rr_matches[$m]->Player1;
		$players_partners[$rr_matches[$m]->Player1] = $rr_matches[$m]->Player1_Partner;
	}

	if(!in_array($rr_matches[$m]->Player2, $players)){
		$players[] = $rr_matches[$m]->Player2;
		$players_partners[$rr_matches[$m]->Player2] = $rr_matches[$m]->Player2_Partner;
	}

}

$grid_array = array();
?>
<div class='tab-content' style='background-color:#ffffff'>
<div>
<p><b><?php echo $get_bracket['Draw_Title']; ?></b></p>
<? //--------------------------------------------------------------------------------------------------------------- ?>
<div class="table-responsive">
<table class='tab-score'>
<?php
$round		= 0;
$match_num  = 1;
foreach($rr_matches as $m => $rrm){   // Main for loop

$p1_won  = 0;
$p2_won  = 0;
$p1_lost = 0;
$p2_lost = 0;
$p1_set_win = 0;
$p2_set_win = 0;
$p1_result  = '-';
$p2_result  = '-';

	if($round != $rr_matches[$m]->Round_Num)
	{
	$round = $rr_matches[$m]->Round_Num;
?>
<tr class='top-scrore-table'>
<td align='center'><?php if($round == 0) { ?>S.No. # <?php } ?></td>
<td align='center' colspan='2'>Match <?=$rr_matches[$m]->Round_Num;?>

<?php
if($tour_details->Usersid == $this->logged_user){
?>
<input type='hidden' name='round[]' value="<?php echo $round; ?>" />

<input type="text" placeholder="Date" name="round_date<?php echo $round; ?>" id="round_date<?php echo $round; ?>"
value="<?php if($rr_matches[$m]->Match_DueDate != "")
{ echo date('m/d/Y H:i', strtotime($rr_matches[$m]->Match_DueDate)); } ?>">
<script>
var rid = "<?php echo $round; ?>";

  $('#round_date'+rid).fdatepicker({
		format: 'mm/dd/yyyy hh:ii',
		disableDblClickSelection: true,
		language: 'en',
		pickTime: true
	});
</script>

<?php
/*if($rr_matches[$m]->Match_DueDate){

 $split_date = explode(" ",$rr_matches[$m]->Match_DueDate);
 $date1 = ($split_date[1] != "00:00:00.000" and $split_date[1] != "") ?
 date("m/d/Y h:i A", strtotime($rr_matches[$m]->Match_DueDate)) : date("m/d/Y", strtotime($rr_matches[$m]->Match_DueDate));

echo "&nbsp;&nbsp;&nbsp;&nbsp;(Play by: ".$date1.")";
}*/
} else {
		if($rr_matches[$m]->Match_DueDate != "") { echo date("m/d/Y H:i",strtotime($rr_matches[$m]->Match_DueDate)); }
}
?>
</td>
<?php if($tour_details->Tournament_type == 'Flexible League'){ 
echo "<td align='center'>Location</td>";
 } ?>
<td align='center'>Scores</td>
<td>&nbsp;</td>
</tr>

<!-- <tr align='center'>
<?php //if($match_type == "Doubles"){ ?>
<td><b>Team1</b></td>
<td><b>Team2</b></td>
<td>&nbsp;</td>
<?php //} else { ?>
<td><b>Player1</b></td>
<td><b>Player2</b></td>
<td>&nbsp;</td>
<?php //} ?>
</tr> -->

<?php
	}
$player1 = league::get_team(intval($rr_matches[$m]->Player1));
$player2 = league::get_team(intval($rr_matches[$m]->Player2));


$tm_id = $rr_matches[$m]->Tourn_match_id;
?>
<tr>
<td align='center'><?php echo $match_num; ?></td>
	<td style="padding-left:15px;"><?php echo "<a href='#'>".$player1['Team_name']."</a>".$p1_part; 
	if($rr_matches[$m]->Winner == $rr_matches[$m]->Player1) {
		echo "<img id='img-winner' src='".base_url()."images/gold_medal_small.png' width='20' height='20'></img>";
		$p1_won  = 1;
		$p2_lost = 1;
		$p1_result = 'W';
		$p2_result = 'L';

	}
	?></td>
	 <td style="padding-left:15px;"><?php echo "<a href='#'>".$player2['Team_name']."</a>".$p2_part;

	if($rr_matches[$m]->Winner == $rr_matches[$m]->Player2) {
		echo "<img id='img-winner' src='".base_url()."images/gold_medal_small.png' width='20' height='20'></img>";
		$p2_won  = 1;
		$p1_lost = 1;
		$p1_result = 'L';
		$p2_result = 'W';
	}
	 ?></td>
	
	<?php if($tour_details->Tournament_type == 'Flexible League'){ ?>
	 <td style="padding-left:15px;">
	 <?php if($rr_matches[$m]->Match_Location) { $loc_id = $rr_matches[$m]->Match_Location; }
		$get_loc = league::get_home_location($loc_id);

		$map_url = "https://www.google.co.in/maps/place/".$get_loc['hcl_address']."+".$get_loc['hcl_city']."+".$get_loc['hcl_state']."+".
		$get_loc['hcl_country'];

		echo "<a href='".$map_url."' title='".$get_loc['hcl_address'].", ".$get_loc['hcl_city'].", ".$get_loc['hcl_state'].", ".$get_loc['hcl_country']."' target='_blank'>".$get_loc['hcl_title']."</a><br>"; ?>
	 </td>
	 <?php } ?>

	 <td style="padding-left:15px;">
	 <?php
		if($rr_matches[$m]->Winner != "") {?>
		<?php
		if($rr_matches[$m]->Player1_Score !=""){
		$p1=array();$p2=array();
		$p1 = json_decode($rr_matches[$m]->Player1_Score);
		$p2 = json_decode($rr_matches[$m]->Player2_Score);

		$cnt = count(array_filter($p1));
		$cnt2 = count(array_filter($p2));
		if($cnt > 0){
				for($i=0; $i<count(array_filter($p1)); $i++)
				{
					echo "($p1[$i] - $p2[$i]) ";
						if($p1[$i] > $p2[$i]){ $p1_set_win++; } 
						else { $p2_set_win++; }
				}
			}
		else if($cnt2 > 0){
				for($i=0; $i<count(array_filter($p2)); $i++)
				{
					echo "($p1[$i] - $p2[$i]) ";
						if($p1[$i] > $p2[$i]){ $p1_set_win++; } 
						else { $p2_set_win++; }
				}
			}
			else if($cnt == 0 and $rr_matches[$m]->Player1_Score != "Bye Match" and $rr_matches[$m]->Player2_Score != "Bye Match"){
					echo "Win by Forfeit ";
			}

		}
		?>
	 <?php } ?>
	 </td>
	
	  <?php if(($rr_matches[$m]->Player1 == $this->session->userdata('users_id') or $rr_matches[$m]->Player2 == $this->session->userdata('users_id') or $rr_matches[$m]->Player1_Partner == $this->session->userdata('users_id') or $rr_matches[$m]->Player2_Partner == $this->session->userdata('users_id') or $this->session->userdata('users_id') == $tour_details->Usersid)) {?>
	 <!-- <td style="padding-left:5px;">
		 <a id="comment_add" class="add_comment" href="#comments" name="<?php echo $tm_id; ?>">Message</a>
	 </td> -->
	 
	 <?php }else {  ?>
		<td> </td>
	 <?php }  ?>
</tr>


<!------------Match Comments-------------------->
<?php if(($rr_matches[$m]->Player1 == $this->session->userdata('users_id') or $rr_matches[$m]->Player2 == $this->session->userdata('users_id') or $rr_matches[$m]->Player1_Partner == $this->session->userdata('users_id') or $rr_matches[$m]->Player2_Partner == $this->session->userdata('users_id') or $this->session->userdata('users_id') == $tour_details->Usersid)) {?>
<tr id="comment<?php echo $rr_matches[$m]->Tourn_match_id; ?>" style="display:none;">
<td colspan='6'>
<br />
<div style='margin-left:50px'>
	<div>	
		<form name="form-comment" id="form-comment<?php echo $rr_matches[$m]->Tourn_match_id;?>">
			<div class='col-md-1 form-group internal' valign='middle' align='left'>
				Message:
			</div>
			<div class='col-md-6 form-group internal'>
				<input type='text' name="message" id="message<?php echo $rr_matches[$m]->Tourn_match_id;?>" class='form-control col-md-9' />
				<input class='form-control' value="<?php echo $rr_matches[$m]->Tourn_match_id;?>" id="match_id<?php echo $rr_matches[$m]->Tourn_match_id;?>" name="tourn_match_id" type='hidden'>

				<input class='form-control' value="<?php echo $rr_matches[$m]->Player1;?>" id="player1_id<?php echo $rr_matches[$m]->Tourn_match_id;?>" name="player1_id" type='hidden'>

				<input class='form-control' value="<?php echo $player1_partner['Users_ID'];?>" id="player1_part_id<?php echo $rr_matches[$m]->Tourn_match_id;?>" name="player1_part_id" type='hidden'>

				<input class='form-control' value="<?php echo $rr_matches[$m]->Player2;?>" id="player2_id<?php echo $rr_matches[$m]->Tourn_match_id;?>" name="player2_id" type='hidden'>

				<input class='form-control' value="<?php echo $player2_partner['Users_ID'];?>" id="player2_part_id<?php echo $rr_matches[$m]->Tourn_match_id;?>" name="player2_part_id" type='hidden'>

				<input class='form-control' value="<?php echo $get_bracket['Tourn_ID'];?>" id="tourn_id<?php echo $rr_matches[$m]->Tourn_match_id;?>" name="tourn_id" type='hidden'>


			</div>
			<div class='col-md-1 form-group internal'>
				<input type="button" name='send_comment#<?php echo $rr_matches[$m]->Tourn_match_id;?>' class='send_comment league-form-submit1' value="Add" />
			</div>
		</form>
	</div>
	<?php
	$get_match_comments = $this->model_league->get_match_comments($rr_matches[$m]->Tourn_match_id);

	if(count($get_match_comments) > 0)
	{
	?>
	<div class="col-md-8" style="overflow-y:scroll;height:200px;">
		
		<div id='comments_div<?php echo $rr_matches[$m]->Tourn_match_id;?>' class="col-md-6">
		
		<?php
		/*foreach($get_match_comments as $comment){ 
		$name = league :: get_team($comment->Users_Id);
		?>
			<div class='pull-left' style="margin-right:20px"><img style="width:50px !important; height:50px !important;" class='img-circle' 
			src='<?php 
			if($name['Profilepic']){
			echo base_url()."profile_pictures/$name[Profilepic]"; }
			else{
			echo base_url()."profile_pictures/default-profile.png"; }
			?>' />
			</div>
			<div style="margin-top:5px">
				<?php echo "<span style='font-weight:bold; color:#464646'>".ucfirst($name['Firstname'])." ".ucfirst($name['Lastname'])."</span>"; ?> <?php echo "<span style='font-size:11px; color:#959595'>".date("m/d/Y H:i", strtotime($comment->Comment_On))."</span>"; ?>
				<div style="margin-top:5px;"><?php echo $comment->Comments; ?></div>
			</div>
			<div style='clear:both; height:20px'></div>
		<?php
		}*/
?>
		</div>
	</div>
<?php
	}
		?>
</div>
</td>
</tr>
<?php }  ?>

<!----------Match Comments-------------------->


<?php
$match_num++;

$grid_array[$rr_matches[$m]->Player1]['opponents'][$rr_matches[$m]->Player2]['sets']   = $p1_set_win.'-'.$p2_set_win;
$grid_array[$rr_matches[$m]->Player1]['opponents'][$rr_matches[$m]->Player2]['result'] = $p1_result;
$grid_array[$rr_matches[$m]->Player1]['team_name'] = $player1['Team_name'];
$grid_array[$rr_matches[$m]->Player1]['won']  += $p1_won;
$grid_array[$rr_matches[$m]->Player1]['lost'] += $p1_lost;

$grid_array[$rr_matches[$m]->Player2]['opponents'][$rr_matches[$m]->Player1]['sets']   = $p2_set_win.'-'.$p1_set_win;
$grid_array[$rr_matches[$m]->Player2]['opponents'][$rr_matches[$m]->Player1]['result'] = $p2_result;
$grid_array[$rr_matches[$m]->Player2]['team_name'] = $player2['Team_name'];
$grid_array[$rr_matches[$m]->Player2]['won']  += $p2_won;
$grid_array[$rr_matches[$m]->Player2]['lost'] += $p2_lost;

} // End of Main For loop
?>
</table>
<br />
<table>
<tr><td>

<input type="hidden" name="update_draw_status" id="update_draw_status" value="3" />
<input type='hidden' name='bracket_id' value="<?php echo $get_bracket['BracketID']; ?>" />
<input type='hidden' name='tour_id'	value="<?php echo $get_bracket['Tourn_ID']; ?>" />
<?php
if($tour_details->Usersid == $this->logged_user){
?>
<div class='col-md-1 form-group internal'>
<input type="button" id='update_draw' name='update_rr_dates' class='league-form-submit1' value=" Update " />
</div>
<?php
} ?>
</td></tr>
</table>
</div>
</form>

<!-- Player standing points section start -->

<div class="col-md-12 league-form-bg" style="margin-top:40px; margin-bottom:20px;">
<div class="accordion"  id="up_match_section"  style="background:#f59123; padding:5px; color:white;"><i class="fa fa-arrow-circle-o-right" style="color:white;"> </i>Player Standings<span></span></div>
<?php
$rr_matches2 = $get_rr_tourn_matches->result();
$list_players = array();

foreach($rr_matches2 as $m2 => $match2){

if(!in_array($rr_matches2[$m2]->Player1, $list_players))
	{	$list_players[] = $rr_matches2[$m2]->Player1."-".$rr_matches2[$m2]->Player1_Partner; }

if(!in_array($rr_matches2[$m2]->Player2, $list_players))
	{	$list_players[] = $rr_matches2[$m2]->Player2."-".$rr_matches2[$m2]->Player2_Partner; }
}

$num_matches = count($list_players) - 1;
//$num_matches = count($list_players);
?>
<div class="tab-content table-responsive">

<table class="tab-score">
<tr class="top-scrore-table">
<td class="score-position" valign="center" align="center">
<?php if($match_type == "Doubles"){ echo "Teams"; } else { echo "Players"; } ?>
</td>
<?php
for($i = 1;$i <= $num_matches; $i++)
{
	echo "<td class='score-position' valign='center' align='center'>Match $i&nbsp;&nbsp;</td>";	
}
?>
<td class="score-position" valign="center" align="center">Total&nbsp;&nbsp;</td>
<td class="score-position" valign="center" align="center">Win%&nbsp;&nbsp;</td>
</tr>
<?php
foreach($list_players as $player){
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

foreach($players_sort as $player => $tot_score){
?>
<tr>
<td align="left">&nbsp;
<?php
	$get_players = explode("-", $player);
	$get_name	 = league::get_team($get_players[0]);
	echo "<b>"."<a href='".base_url()."player/".$get_name['Team_ID']."'>".$get_name['Team_name']."</a>"."</b>";
?>
</td>
	<?php
	foreach($rr_matches2 as $m2 => $match2){

		if($rr_matches2[$m2]->Player1 == $player or $rr_matches2[$m2]->Player2 == $player){
			if($rr_matches2[$m2]->Player1 == $player){ 
				echo "<td align='center'>".$rr_matches2[$m2]->Player1_points."</td>";				
			}
			else if($rr_matches2[$m2]->Player2 == $player){
				echo "<td align='center'>".$rr_matches2[$m2]->Player2_points."</td>"; 
			}

			$player_tot_score += ($p1_sum);
			$p1p2_tot_score	  += ($p1_sum+$p2_sum);
		}
	}
	?>
<td align='center'><?php echo $tot_score['points']; ?></td>
<td align='center' style='font-weight:400'>
<?php echo $tot_score['win_per']; ?></td>
</tr>
<?php
}
?>
</table>

</div>
</div>
<!-- End of Player Standing points section -->

<!-- ------------------ Grid view ------------------------ -->
<div class="col-md-12 league-form-bg" style="margin-top:40px; margin-bottom:20px;">
<div class="accordion"  id="up_match_section"  style="background:#f59123; padding:5px; color:white;"><i class="fa fa-arrow-circle-o-right" style="color:white;"> </i>Result Grid<span></span></div>
<?php
uasort($grid_array, array('league','sortWon'));
$rr_matches2 = $get_rr_tourn_matches->result();
$list_players = array();

foreach($rr_matches2 as $m2 => $match2){

if(!in_array($rr_matches2[$m2]->Player1, $list_players))
	{	$list_players[] = $rr_matches2[$m2]->Player1."-".$rr_matches2[$m2]->Player1_Partner; }

if(!in_array($rr_matches2[$m2]->Player2, $list_players))
	{	$list_players[] = $rr_matches2[$m2]->Player2."-".$rr_matches2[$m2]->Player2_Partner; }
}

$num_matches = count($list_players) - 1;
?>
<div class="tab-content table-responsive">

<table class="tab-score">
<tr class="top-scrore-table">
<td class="score-position" valign="center" align="center">
<?php if($match_type == "Doubles"){ echo "Teams"; } else { echo "Players"; } ?>
</td>
<td class="score-position" valign="center" align="center">Rank</td>
<td class="score-position" valign="center" align="center">W-L</td>
<?php
$new_list = array();
foreach($grid_array as $player => $details){
	echo "<td class='score-position' valign='center' align='center'>$details[team_name]&nbsp;&nbsp;</td>";
	$new_list[] = $player;
}
?>
</tr>
<?php
$count = count($new_list);
$k = 1;
foreach($new_list as $i => $player){
	$exp = explode('-', $player);
	$p1  = $exp[0];
	$p1p = $exp[1];
	//$find_key = array_search($player, $new_list);
?>
<tr>
<td align="center"><?="<b>"."<a href='#'>".$grid_array[$p1]['team_name']."</a>";?></td>
<td align="center"><?=$k;?></td>
<td align="center"><?=$grid_array[$p1]['won'].'-'.$grid_array[$p1]['lost'];?></td>
<?php
//for($j =0; $j < $count; $j++){
foreach($grid_array as $p => $details){
?>
<td align="center" style='font-weight:normal;'><?php
if($p1 != $p){ 
	echo $grid_array[$p1]['opponents'][$p]['result'];
	echo "<br>";
	echo $grid_array[$p1]['opponents'][$p]['sets'];
}
else{ echo 'X'; } ?></td>
<?php
}
?>
</tr>
<?php
$k++;
}
?>
</table>
</div>
</div>
<!-- ------------------ Grid view ------------------------ -->