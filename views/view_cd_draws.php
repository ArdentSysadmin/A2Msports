<?php
if($club_url == "https://a2msports.com/league"){
	$profile_base = base_url();
}
else{
	$profile_base = $club_url."/";
}

if($get_bracket['No_of_rounds']){
	$css_num = $get_bracket['No_of_rounds'];

	//if($css_num == 4) $css_num = 5;
?>
<link rel="stylesheet" href="<?php echo base_url();?>css/grids/grid_<?=$css_num;?>.css">
<?php
}
?>
<link href="<?php echo base_url();?>css/foundation-datepicker.css" rel="stylesheet">
<script src="<?php echo base_url();?>js/foundation-datepicker.js"></script>

<script>
$(document).ready(function(){

$('.swap_player').change(function (e) {

$nxt_element = $(this).next(".swap_player").attr('name');

if($(this).val() != 0){
	$('select[name='+$nxt_element+']').removeAttr("disabled");
}
else{
	$('select[name='+$nxt_element+']').val('');
	$('select[name='+$nxt_element+']').attr("disabled", 'true');
}

});
/*var baseurl = "<?php echo base_url();?>";

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

	});*/


var baseurl = "<?php echo base_url();?>";

$('#update_draw').click(function (e) {

$('.swap_player').removeAttr("disabled");

	  $.ajax({
		type: 'POST',
		url: baseurl+'league/view_matches',
		data: $('#frm_upd_dates').serialize(),
		success: function(res) {
			alert(res);
			var str2 = "Updated";
			if(res.indexOf(str2) != -1){
				location.reload();
			}
		}
	  });
	  e.preventDefault();

});

$('#update_con_draw').click(function (e) {

	  $.ajax({
		type: 'POST',
		url: baseurl+'league/view_matches',
		data: $('#con_frm_upd_dates').serialize(),
		success: function(res) {
			alert(res);
			var str2 = "Updated";
			if(res.indexOf(str2) != -1){
				location.reload();
			}
		}
	  });
	  e.preventDefault();

	});

});
</script>
<br />
<!-- <div id='ShowDraw11'></div> -->
<div style="display:grid;">
<form method="post" id="frm_upd_dates" class="login-form" style='width:100%;' autocomplete='off'>
<script language="javascript" type="text/javascript">
function myWin(tid)
{
var path = "<?php echo base_url(); ?>";
var tid = '<?php echo $bracket_id; ?>';
window.open(path+'league/pdf/'+tid,null,"height=1200,width=1400,status=yes,toolbar=no,menubar=no,location=no");
}
function myWinC(tid)
{
var path = "<?php echo base_url(); ?>";
var tid = '<?php echo $bracket_id; ?>';
window.open(path+'league/pdf_c/'+tid,null,"height=1200,width=1400,status=yes,toolbar=no,menubar=no,location=no");
}
</script>

<input type="button" class="league-form-submit1" name="capture" id="capture" value="Print" style="float:right;" onclick="myWin(<?=$bracket_id;?>)" />
<input type="hidden" name="update_draw_status" id="update_draw_status" value="1" />

<?php

//$list_matches = $get_cd_tourn_matches->result();

$is_doubles	= 0;
$total_rounds	= $get_bracket['No_of_rounds'];
$bracket_id		= $get_bracket['BracketID'];
$tour_id		= $get_bracket['Tourn_ID'];
$filter_events	= json_decode($get_bracket['Filter_Events']);
foreach ($filter_events as $key => $event) {
					
	    $eventArr = explode('-', $event);
	    $events[] = $event;
		//if($eventArr[2]	== 'Doubles' or $eventArr[2] == 'Mixed'){
		if(strpos($event, 'Doubles') or strpos($event, 'Mixed')){
			$is_doubles	= 1;
		}
}

$list_matches	= $get_tourn_matches->result();
//echo "<pre>"; print_r($list_matches); exit;
/*$tourn_reg_players = league::get_reg_tourn_participants($tour_id);
foreach($tourn_reg_players[1] as $key => $val){
$players[] = $key;
}*/

	if(!empty($events)){		// When Filter_Events field in Brackets is not empty
		$tourn_reg_players = league::get_reg_tourn_participants_withGender($tour_id, $tourn_det->SportsType);
		foreach($events as $key => $evnt){
			$users[$key] = league::in_array_r($evnt, $tourn_reg_players[0]); 
		}

		$players = league::array_flatten($users);
	}
	else{						// When Filter_Events field in Brackets is not empty Loads all reg. players
		$tourn_reg_players = league::get_reg_tourn_participants($tour_id);
		foreach($tourn_reg_players[1] as $key => $val){
			$players[] = $key;
		}
	}

/*
$tourn_reg_players = league::get_reg_tourn_participants_withGender($tour_id, $tourn_det->SportsType);

foreach($events as $key => $evnt){
	$users[$key] = league::in_array_r($evnt, $tourn_reg_players[0]); 
}
$players = league::array_flatten($users);
*/
?>
<div>

<?php
if($tour_details->Usersid == $this->logged_user or $this->is_super_admin){
?>
<input class="form-control" type="text" name="draw_title" id="draw_title" style="width:25%;" 
value="<?php echo $get_bracket['Draw_Title']; ?>" required />
<input type="submit" class="league-form-submit1" style="margin-left: 100px;" name="update_draw" id="update_draw" value=" Update " />
<?php
}
else{
?>
<h4 style="color:#f59123"><b><?php echo $get_bracket['Draw_Title']; ?></b></h4>
<?php
}
?>
</div>

<div class="brackets-mobile">	<!-- Mobile DIV -->
<div class="brackets-mobile-child"> <!-- Mobile child DIV -->
<div class="brackets" id="brackets">
<div class="group<?php echo $total_rounds+1; ?>" id="b1">
<input type='hidden' name='bracket_id' value="<?php echo $get_bracket['BracketID']; ?>" />
<input type='hidden' name='tour_id'		 value="<?php echo $get_bracket['Tourn_ID']; ?>" />

<?php
$nm = 0;
$match_count = 0;
$round_type = array();
for($round = 1; $round <= $total_rounds; $round++) {
	foreach($list_matches as $m => $match){
		if($round == 1 and $match->Round_Num == 1){
			$match_count++;
		}

		if($list_matches[$m]->Round_Num==$round){
			$round_dates[$round] = $list_matches[$m]->Match_DueDate;
			$nm++;
		}
	}
	$round_type[$round] = $nm;
	$nm = 0;
}
?>
<input type="hidden" name="mcn" id="mcn" value="<?=$match_count;?>" />
<?php
for($round = 1; $round <= $total_rounds; $round++){
?>
<script>/*
$(function() {
 var rid = "<?php echo $round; ?>";
 $('#sdate_round'+rid).datepick();
});*/
</script>
<div class="r<?php echo $round; ?>">
<input type='hidden' name='round[]' value="<?php echo $round; ?>" />

<br>
<span style="text-align: center"><b>
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
</b></span>
<?php
if($tour_details->Usersid == $this->logged_user or $this->is_super_admin){
?>

<!-- <input type = "text" placeholder = "Date" id = "sdate_round<?php //echo $round; ?>" name = "round_date<?php //echo $round; ?>" 
value = "<?php //if($round_dates[$round] != ""){ echo date('m/d/Y H:i', strtotime($round_dates[$round])); } ?>" /> -->

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
	//if($round_dates[$round] != "") { echo date("m-d-Y H:i",strtotime($round_dates[$round])); }
}
//	print_r($list_matches);exit;
foreach($list_matches as $m => $match){
$get_username = "";
$get_username2 = "";

	if($list_matches[$m]->Round_Num==$round){
	?>
	<div class="bracketbox">
	<span class="info" style="color:#169c06; font-weight:bold;left:12%"><?php
	if($list_matches[$m]->Player1 != 0){
		 $get_username = league::get_username(intval($list_matches[$m]->Player1));
		 $get_partner_username = league::get_username(intval($list_matches[$m]->Player1_Partner));
	}
	if($list_matches[$m]->Player2 != 0){
		 $get_username2 = league::get_username(intval($list_matches[$m]->Player2));
		 $get_partner_username2 = league::get_username(intval($list_matches[$m]->Player2_Partner));
	}
	
	$match_num = $list_matches[$m]->Match_Num;

		echo "<label style='color:blue;'>".$match_num."</label>";
	if($tour_details->Usersid == $this->logged_user or $this->is_super_admin) { 
		$sty = '';

if($round == 1)
	$sty = "width:20%;";
else
	$sty = "width:30%;";


		echo "&nbsp;";
		echo "<input type='text'  placeholder='Court' name='match_court{$match_num}' value='{$list_matches[$m]->Court_Info}' style='{$sty}' />";
	}
	else{
	if($list_matches[$m]->Court_Info != "") { echo "&nbsp;&nbsp;&nbsp;(".$list_matches[$m]->Court_Info.")"; }
	}

if($tour_details->Usersid == $this->logged_user or $this->is_super_admin){
			echo "&nbsp;";

	//if($round == 1)
		//echo "&nbsp;";
	//else
		//echo "<br />";
?>
<input type="text" placeholder="Date" id="sdate<?=$match_num; ?>" name="match_date<?=$match_num; ?>" 
value = "<?php if($list_matches[$m]->Match_DueDate != "")
{ echo date('m/d/Y H:i', strtotime($list_matches[$m]->Match_DueDate)); } ?>" 
<?php 
if($round == 1)
	echo "style='width:35%;'";
else
	echo "style='width:45%;'";
?>
 />

<script>
var rid = "<?php echo $match_num; ?>";

$('#sdate'+rid).fdatepicker({
format: 'mm/dd/yyyy hh:ii',
disableDblClickSelection: true,
language: 'en',
pickTime: true
});
</script>
<?php
}
else {
	if($list_matches[$m]->Match_DueDate != "") { echo date("M-d H:i",strtotime($list_matches[$m]->Match_DueDate)); }
}

?>
<br />
	<input type='hidden' name='match_num[<?php echo $round; ?>][]' value="<?php echo $match_num; ?>" />
	<input type='hidden' name='draw[]' value="<?php echo $list_matches[$m]->Draw_Type; ?>" />
	</span>
	<span class="teama">
	
	<?php
	$is_show_user = 1;
	if($round == 1 and ($tour_details->Usersid == $this->logged_user or $this->is_super_admin)){
			$is_show_user = 0;

		echo "<select style='width:110px;' class='swap_player' id='{$list_matches[$m]->Player1}' name='p1_{$list_matches[$m]->Match_Num}'>";
		echo "<option value=''>Player</option>";
		foreach($players as $p1){
		$selected = ($list_matches[$m]->Player1 == $p1) ? "selected" : "";
		$get_player = league::get_username(intval($p1));

		echo "<option value='$p1' $selected>".$get_player['Firstname']." ".$get_player['Lastname']."</option>";
		}
		$selected = ($list_matches[$m]->Player1 == '0') ? "selected" : "";
		echo "<option value='0' $selected>Bye</option>";
		echo "</select>&nbsp;";

		if($is_doubles){		// Loads when the filters in bracket having Mixed or Doubles
			echo "<select style='width:110px;' class='swap_player' id='{$list_matches[$m]->Player1_Partner}' name='p1_p_{$list_matches[$m]->Match_Num}'>";
			echo "<option value=''>Player</option>";
			foreach($players as $p1){
			$selected = ($list_matches[$m]->Player1_Partner == $p1) ? "selected" : "";
			$get_player = league::get_username(intval($p1));

			echo "<option value='$p1' $selected>".$get_player['Firstname']." ".$get_player['Lastname']."</option>";
			}
			$selected = ($list_matches[$m]->Player1_Partner == '0') ? "selected" : "";
			//echo "<option value='0' $selected>Bye</option>";
			echo "</select>";
		}
		echo "<br />";
	}

	if($get_username and $is_show_user){ 
		echo "<a href='".$profile_base."player/".$get_username['Users_ID']."' target='_blank'>".$get_username['Firstname']." ".$get_username['Lastname']."</a>";

		if($get_partner_username and $is_show_user){
			echo " - <a href='".$profile_base."player/".$get_partner_username['Users_ID']."' target='_blank'>".$get_partner_username['Firstname']." ".$get_partner_username['Lastname']."</a>"; 
		}
	}
	else { 
		if($round == 1 and $is_show_user)
			echo "Bye";
		else if($is_show_user)
			echo "---"; 
	}

if($list_matches[$m]->Round_Num != 1){
echo "<br>";
		$get_source_scores1 = league::get_match_scores_player1($list_matches[$m]->Player1_source, $bracket_id, $tour_id, $list_matches[$m]->Draw_Type);

		if($get_source_scores1['Player1_Score'] != "" && $get_source_scores1['Player1_Score'] != "Bye Match"){
			if($get_source_scores1['Player1_Score'] == '[0]' && $get_source_scores1['Player2_Score'] == '[0]'){
				 echo "(Won by Forfeit)";
			}
			else{
				if($get_source_scores1['Player1_Score'] != "" and $get_source_scores1['Winner'] == $get_source_scores1['Player1']){
				$p1 = json_decode($get_source_scores1['Player1_Score']);
				$p2 = json_decode($get_source_scores1['Player2_Score']);
				} 
				else if($get_source_scores1['Player2_Score'] != "" and $get_source_scores1['Winner'] == $get_source_scores1['Player2']){
				$p1 = json_decode($get_source_scores1['Player2_Score']);
				$p2 = json_decode($get_source_scores1['Player1_Score']);
				}

				if(count(array_filter($p1))>0){
					for($i=0; $i<count(array_filter($p1)); $i++){
						echo "($p1[$i] - $p2[$i]) ";
					}
				}
			}
		 }
	}
?>
	
	</span>
	<span class='team2'>&nbsp</span>
	<span class="teamb">
	<?php 
	if($round == 1 and ($tour_details->Usersid == $this->logged_user or $this->is_super_admin)){
		echo "<select style='width:110px;' class='swap_player' id='{$list_matches[$m]->Player2}' name='p2_{$list_matches[$m]->Match_Num}'>";
		echo "<option value=''>Player</option>";
		foreach($players as $p2){
		$selected = ($list_matches[$m]->Player2 == $p2) ? "selected" : "";
		$get_player = league::get_username(intval($p2));
		echo "<option value='$p2' $selected>".$get_player['Firstname']." ".$get_player['Lastname']."</option>";
		}
		$selected = ($list_matches[$m]->Player2 == '0') ? "selected" : "";
		echo "<option value='0' $selected>Bye</option>";
		echo "</select>&nbsp;";

		if($is_doubles){		// Loads when the filters in bracket having Mixed or Doubles
			$disabled = '';
			if($list_matches[$m]->Player2 == 0){
				$disabled = "disabled";
			}
		echo "<select style='width:110px;' class='swap_player' id='{$list_matches[$m]->Player2_Partner}' name='p2_p_{$list_matches[$m]->Match_Num}'  {$disabled}>";
		echo "<option value=''>Player</option>";
		foreach($players as $p2){
		$selected = ($list_matches[$m]->Player2_Partner == $p2) ? "selected" : "";
		$get_player = league::get_username(intval($p2));
		echo "<option value='$p2' $selected>".$get_player['Firstname']." ".$get_player['Lastname']."</option>";
		}
		$selected = ($list_matches[$m]->Player2_Partner == '0') ? "selected" : "";
		//echo "<option value='0' $selected>Bye</option>";
		echo "</select>";
		}
	}
		/* -------------------- */
		// code moved to below 
		/* -------------------- */


		//echo "<br>";
		?>
	
	<?php 
	if($list_matches[$m]->Round_Num == 1 and $list_matches[$m]->Player2 != 0 and $is_show_user)
	{ 
		echo "<a href='".$profile_base."player/".$get_username2['Users_ID']."' target='_blank'>".$get_username2['Firstname']." ".$get_username2['Lastname']."</a>"; 
			if($get_partner_username2){
				echo " - <a href='".$profile_base."player/".$get_partner_username2['Users_ID']."' target='_blank'>".$get_partner_username2['Firstname']." ".$get_partner_username2['Lastname']."</a>"; 
			}
	}
	else if($list_matches[$m]->Round_Num != 1 and $list_matches[$m]->Player2 == 0){ echo "---"; }
	else if($get_username2 and $is_show_user) { 
		echo "<a href='".$profile_base."player/".$get_username2['Users_ID']."' target='_blank'>".$get_username2['Firstname']." ".$get_username2['Lastname']."</a>"; 
			if($get_partner_username2 and $is_show_user){
				echo " - <a href='".$profile_base."player/".$get_partner_username2['Users_ID']."' target='_blank'>".$get_partner_username2['Firstname']." ".$get_partner_username2['Lastname']."</a>"; 
			}

		/* -------------------- */
		echo "<br>";

		//if($list_matches[$m]->Round_Num != 1){

		$get_source_scores2 = league::get_match_scores_player2($list_matches[$m]->Player2_source,$bracket_id,$tour_id,$list_matches[$m]->Draw_Type);

		if($get_source_scores2['Player1_Score'] !=""){
			if($get_source_scores2['Player1_Score'] == '[0]' && $get_source_scores2['Player2_Score'] == '[0]'){
				 echo "(Won by Forfeit)";
			}
			else{ 
				if($get_source_scores2['Player1_Score'] != "" and $get_source_scores2['Winner'] == $get_source_scores2['Player1']){
				$p1 = json_decode($get_source_scores2['Player1_Score']);
				$p2 = json_decode($get_source_scores2['Player2_Score']);
				} 
				else if($get_source_scores2['Player2_Score'] != "" and $get_source_scores2['Winner'] == $get_source_scores2['Player2']){
				$p1 = json_decode($get_source_scores2['Player2_Score']);
				$p2 = json_decode($get_source_scores2['Player1_Score']);
				}

				if(count(array_filter($p1))>0){
					for($i=0; $i<count(array_filter($p1)); $i++){
						echo "($p1[$i] - $p2[$i]) ";
					}
				}
			}

		} 
		//}

		/* -------------------- */


	}
	else if($is_show_user) { echo "Bye"; }
	?>

	</span>
	</div>
<? }
//echo $list_matches[$m]->Round_Num;
/*	if($list_matches[$m]->Round_Num == $total_rounds 
		and $list_matches[0]->Round_Num == -1 
		and $list_matches[$m]->Round_Num == $round) {

	?>
		<input type='hidden' name='round[]' value="<?php echo '-1'; ?>" />
	<div class="third_place bracketbox">
	<span class="info" style="color:#169c06; font-weight:bold;">
	<?php
	if($list_matches[0]->Player1 != 0){
		 $get_username				= league::get_username(intval($list_matches[0]->Player1));
		 $get_partner_username  = league::get_username(intval($list_matches[0]->Player1_Partner));

		 $s_p1 = $list_matches[0]->Player1;
	}

	if($list_matches[0]->Player2 != 0){
		 $get_username2				  = league::get_username(intval($list_matches[0]->Player2));
		 $get_partner_username2  = league::get_username(intval($list_matches[0]->Player2_Partner));

		 $s_p2 = $list_matches[0]->Player2;
	}
	
	$match_num = $list_matches[0]->Match_Num;
	if($match_num == -1)
	echo "3rd Place Match<br>";
		

if($tour_details->Usersid == $this->logged_user or $this->is_super_admin){
?>
<!-- <input  type="text" class='form-control' placeholder="Date" id="sdate<?php echo $match_num; ?>" name="match_date<?php echo $match_num; ?>" 
value = "<?php if($list_matches[0]->Match_DueDate != "")
{ echo date('m/d/Y', strtotime($list_matches[0]->Match_DueDate)); } ?>" /> -->
<script>
//$(function() {
// var spid = "<?php echo $match_num; ?>";
// $('#sdate'+spid).datepick();
//});
</script>

<!-- <input type="text" placeholder="Date" name="match_date<?php echo $match_num; ?>" id="sdate<?php echo $match_num; ?>"
value="<?php if($list_matches[0]->Match_DueDate != "")
{ echo date('m/d/Y H:i', strtotime($list_matches[0]->Match_DueDate)); } ?>" /> -->

<script>
var mid = "<?php echo $match_num; ?>";

  $('#sdate'+mid).fdatepicker({
		format: 'mm/dd/yyyy hh:ii',
		disableDblClickSelection: true,
		language: 'en',
		pickTime: true
	});
</script>
<input type='text' placeholder="Court" name='match_court<?php echo $match_num; ?>' value='<?php echo $list_matches[0]->Court_Info; ?>' style='width:25%' />
<input type="text" placeholder="Date" name="match_date<?php echo $match_num; ?>" 
id="sdate<?php echo $match_num; ?>" value="<?php if($list_matches[0]->Match_DueDate != "")
{ echo date('m/d/Y H:i', strtotime($list_matches[0]->Match_DueDate)); } ?>" style='width:55%' />

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
	//if($list_matches[0]->Match_DueDate != "") { 
	//echo "&nbsp;&nbsp;".date("M-d H:i",strtotime($list_matches[0]->Match_DueDate)); 
	//}
}
else {
	if($list_matches[0]->Court_Info != "") { echo "&nbsp;&nbsp;(".$list_matches[0]->Court_Info.")"; }
	if($list_matches[0]->Match_DueDate != "") { 
		echo "&nbsp;&nbsp;".date("M-d H:i",strtotime($list_matches[0]->Match_DueDate)); 
	}
}
?>
<br />
	<?php // if($list_matches[0]->Match_DueDate != "") { echo date("m-d-Y",strtotime($list_matches[0]->Match_DueDate)); } ?>
	<input type='hidden' name='match_num[<?php echo '-1'; ?>][]' value="<?php echo $match_num; ?>" />
	<input type='hidden' name='draw[]' value="<?php echo $list_matches[0]->Draw_Type; ?>" />

	</span>
	<span class="teama">
	<?php
		if($get_username){ 
		echo "<a  href='".$profile_base."player/".$get_username['Users_ID']."' target='_blank'>".$get_username['Firstname']." ".$get_username['Lastname']."</a>";

			if($get_partner_username){
				echo " - <a href='".$profile_base."player/".$get_partner_username['Users_ID']."' target='_blank'>".$get_partner_username['Firstname']." ".$get_partner_username['Lastname']."</a>"; 
			}
			
		$seed = '';
		if($round == 1 and $s_p1 != '---') {
		$seed = array_search($s_p1, $squad);
		echo " (".($seed+1).") ";
		}
	} else { echo "----"; }?>
	</span>
	<span class='team2'>&nbsp
	</span>
	<span class="teamb">
	<?php
		echo "<br>";
		?>
	
	<?php if($list_matches[0]->Round_Num == -1 and $list_matches[0]->Player2 != 0)
		{ 
		echo "<a href='".$profile_base."player/".$get_username2['Users_ID']."' target='_blank'>".$get_username2['Firstname']." ".$get_username2['Lastname']."</a>"; 
			if($get_partner_username2){
				echo " - <a href='".$profile_base."player/".$get_partner_username2['Users_ID']."' target='_blank'>".$get_partner_username2['Firstname']." ".$get_partner_username2['Lastname']."</a>"; 
			}
		}
	else if($list_matches[0]->Round_Num != -1 and $list_matches[0]->Player2 == 0){ echo "---"; }
	else if($get_username2){ 
		echo "<a href='".$profile_base."player/".$get_username2['Users_ID']."' target='_blank'>".$get_username2['Firstname']." ".$get_username2['Lastname']."</a>"; 
			if($get_partner_username2){
				echo " - <a href='".$profile_base."player/".$get_partner_username2['Users_ID']."' target='_blank'>".$get_partner_username2['Firstname']." ".$get_partner_username2['Lastname']."</a>"; 
			}
	}
	else { echo "---"; }

		$seed = '';
		if($round == 1 and $s_p2 != '---') {
		$seed = array_search($s_p2, $squad);
		echo " (".($seed+1).") ";
		}
	?>
	</span>
	</div>
<? }*/
 }
?>
</div>
<?php if(($round) == $total_rounds){ 
//echo "MC".$match_count;
switch($match_count){
	case 4:
		$box_height = '100px';
	break;

	case 8:
		$box_height = '35px';
	break;

	case 16:
		$box_height = '50px';
	break;
	
	default:
		$box_height = '50px';
	break;
}

?>
  <div class="r<?php echo $total_rounds+1; ?>">
   		<div class="final">
        	<div class="bracketbox" <?php if($match_count > 3) { ?>style='height:<?=$box_height;?>; width:35%;' <?php } ?>>
            	<span class="teamc">
				<?php if($list_matches[$m]->Winner != 0){
				 $get_username = league::get_username(intval($list_matches[$m]->Winner));
				 ($list_matches[$m]->Winner == $list_matches[$m]->Player1) ? 
					 $partner = $list_matches[$m]->Player1_Partner : $partner = $list_matches[$m]->Player2_Partner;
				 $get_partner_name = league::get_username(intval($partner));

				 echo "<b>"."<a href='".$profile_base."player/".$get_username['Users_ID']."' target='_blank'>".$get_username['Firstname']." ".$get_username['Lastname']."</a>";
				 	 if($partner) { echo " - <a href='".$profile_base."player/".$get_partner_name['Users_ID']."' target='_blank'>".$get_partner_name['Firstname']." ".$get_partner_name['Lastname']."</a>"; }
				 echo "</b>";

					if($list_matches[$m]->Player1_Score !="" && $list_matches[$m]->Winner == $list_matches[$m]->Player1){
					$p1 = json_decode($list_matches[$m]->Player1_Score);
					$p2 = json_decode($list_matches[$m]->Player2_Score);
					}
					else if($list_matches[$m]->Player2_Score !="" && $list_matches[$m]->Winner == $list_matches[$m]->Player2){
					$p1 = json_decode($list_matches[$m]->Player2_Score);
					$p2 = json_decode($list_matches[$m]->Player1_Score);
					}
				 echo "<br />";
						if(count(array_filter($p1))>0){
							for($i=0; $i<count(array_filter($p1)); $i++){
							echo "($p1[$i] - $p2[$i]) ";
							}
						}
					}
				
				?>
				</span>
            </div>
        </div>
   </div>
<?php } ?>

<!-- ----------------------------------------------------- -->

<?php 
/*if($round == $total_rounds and $list_matches[0]->Round_Num == -1) { 
?>
  <div class="r<?php echo $total_rounds+1; ?>">
   		<div class="final">
        	<div class="third_final bracketbox">
            	<span class="teamc">
				<?php
				if($list_matches[0]->Winner != 0){

					if($list_matches[0]->Winner == $list_matches[0]->Player1){
						 $get_username					= league::get_username(intval($list_matches[0]->Player1));
						 $get_partner_username	= league::get_username(intval($list_matches[0]->Player1_Partner));
							
							echo "<h5 style='color:#f59123'><b>";
							if($get_username){ 
							echo "<a href='".$profile_base."player/".$get_username['Users_ID']."' target='_blank'>".$get_username['Firstname']." ".$get_username['Lastname']."</a>";

							if($get_partner_username){
							echo " - <a href='".$profile_base."player/".$get_partner_username['Users_ID']."' target='_blank'>".$get_partner_username['Firstname']." ".$get_partner_username['Lastname']."</a>"; 
							}
							}
							echo "</b></h5>";

							if($list_matches[0]->Player1_Score !=""){

								if($list_matches[0]->Player1_Score == '[0]' && $list_matches[0]->Player2_Score == '[0]'){
								 echo "Won by Forfeit";
								}
								else{ 
									$p1 = json_decode($list_matches[0]->Player1_Score);
									$p2 = json_decode($list_matches[0]->Player2_Score);

										if(count(array_filter($p1))>0){
											for($i=0; $i<count(array_filter($p1)); $i++){
												echo "($p1[$i] - $p2[$i]) ";
											}
										}
								}
							} 
					}
					else{
						 $get_username					= league::get_username(intval($list_matches[0]->Player2));
						 $get_partner_username	= league::get_username(intval($list_matches[0]->Player2_Partner));
							
							echo "<h5 style='color:#f59123'><b>";
							if($get_username){ 
							echo "<a href='".$profile_base."player/".$get_username['Users_ID']."' target='_blank'>".$get_username['Firstname']." ".$get_username['Lastname']."</a>";

							if($get_partner_username){
							echo " - <a href='".$profile_base."player/".$get_partner_username['Users_ID']."' target='_blank'>".$get_partner_username['Firstname']." ".$get_partner_username['Lastname']."</a>"; 
							}
							}
							echo "</b></h5>";

							
							if($list_matches[0]->Player1_Score !=""){
                                if($list_matches[0]->Player1_Score == '[0]' && $list_matches[0]->Player2_Score == '[0]'){
								 echo "Won by Forfeit";
								}
								else{ 
									$p1 = json_decode($list_matches[0]->Player1_Score);
									$p2 = json_decode($list_matches[0]->Player2_Score);

									if(count($p2)>0){
										for($i=0; $i<count($p2); $i++){
											echo "($p2[$i] - $p1[$i]) ";
										}
									}
								}
							}
					}
				}
				?>
				</span>
            </div>
        </div>
   </div>

<?php } */
?>



<?
}
?>
</div>


</div><!-- Mobile child DIV -->
</div> <!-- Mobile DIV -->




<div style='clear:both;'></div>
</div>
<?php
//if($tour_details->Usersid == $this->logged_user or $this->is_super_admin){
?>
<!-- <input type="submit" class="league-form-submit1" name="update_draw" id="update_draw" value=" Update " /> -->
<?php
//}
?>
</form>
</div>
<div style='clear:both;'></div>
<br />
<?php
//--------------------------------------- Consolation Draw --------------------------------------------------------------

$total_rounds	= intval($get_cd_num_rounds['total_rounds']);
$bracket_id		= $get_bracket['BracketID'];
$tour_id		= $get_bracket['Tourn_ID'];
?>
<link rel="stylesheet" href="<?php echo base_url();?>css/grids/cr<?=$total_rounds;?>.css">
<input type="button" class="league-form-submit1" name="capture" id="capture" value="Print" style="float:right;" onclick="myWinC(<?=$bracket_id;?>)" />
<div style="display:grid; margin-top: 8%;">
<form method="post" id="con_frm_upd_dates" class="login-form" style='width:100%;' autocomplete='off'>
<div><h4><b><?php echo $get_bracket['Draw_Title']. " - "; ?></b>Consolation
<?php
if($tour_details->Usersid == $this->logged_user or $this->is_super_admin){
?>
<input type="submit" class="league-form-submit1" style="margin-left: 100px;" name="update_con_draw" id="update_con_draw" value="Update" />
<?php
}
?>
</h4></div><br>

<div class="brackets-mobile">	<!-- Mobile DIV -->
<div class="brackets-mobile-child"> <!-- Mobile child DIV -->
<div class = "brackets1" id="brackets1">

<input type="hidden" name="update_draw_status" id="update_draw_status" value="2" />
<input type='hidden' name='bracket_id' value="<?php echo $get_bracket['BracketID']; ?>" />
<input type='hidden' name='tour_id'	value="<?php echo $get_bracket['Tourn_ID']; ?>" />
<input type="hidden" name="mcn" id="mcn" value="<?=$match_count;?>" />
<?php

$list_matches	= $get_cd_tourn_matches->result();
$con_players	= league::get_consolation_players($tour_id, $bracket_id);
//echo "<pre>"; print_r($con_players); 

foreach($con_players as $k => $match){
	if($match->Looser){ $looser_players[] = $match->Looser; }
	if($match->Looser_Partner){ $looser_players[] = $match->Looser_Partner; }
}
$looser_players = array_unique($looser_players);
//echo "<pre>"; print_r($looser_players); 
?>
<div class="group<?php echo $total_rounds+1; ?>" id="b1">

<?php
$nm = 0;
$round_type = array();
for($round = 1; $round <= $total_rounds; $round++) {
	foreach($list_matches as $m => $match){
		if($list_matches[$m]->Round_Num==$round){
			$cround_dates[$round] = $list_matches[$m]->Match_DueDate;
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
 $('#cdate_round'+rid).datepick();
});*/
</script>
<div class="r<?php echo $round; ?>">
<input type='hidden' name='cround[]' value="<?php echo $round; ?>" />

<br>
<span style="text-align: center"><b>
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
</b></span>
<?php
if($tour_details->Usersid == $this->logged_user or $this->is_super_admin){
?>

<!-- <input type = "text" placeholder = "Date" id = "cdate_round<?php //echo $round; ?>" name = "cround_date<?php //echo $round; ?>" 
value = "<?php //if($cround_dates[$round] != ""){ echo date('m/d/Y H:i', strtotime($cround_dates[$round])); } ?>" /> -->

<script>
var rid = "<?php echo $round; ?>";

  $('#cdate_round'+rid).fdatepicker({
		format: 'mm/dd/yyyy hh:ii',
		disableDblClickSelection: true,
		language: 'en',
		pickTime: true
	});
</script>

<?php
} else {
	if($cround_dates[$round] != "") { echo date("m-d-Y H:i", strtotime($cround_dates[$round])); }
}
//	print_r($list_matches);exit;
foreach($list_matches as $m => $match){
$get_username = "";
$get_username2 = "";

	if($list_matches[$m]->Round_Num==$round){
	?>
	<div class="bracketbox">
	<span class="info"><?php
	if($list_matches[$m]->Player1 != 0){
		 $get_username = league::get_username(intval($list_matches[$m]->Player1));
		 $get_partner_username = league::get_username(intval($list_matches[$m]->Player1_Partner));
	}
	
	if($list_matches[$m]->Player2 != 0){
		 $get_username2				 = league::get_username(intval($list_matches[$m]->Player2));
		 $get_partner_username2 = league::get_username(intval($list_matches[$m]->Player2_Partner));
	}
	
	$match_num = $list_matches[$m]->Match_Num;
	echo $match_num;
	if($list_matches[$m]->Court_Info != "") { echo "&nbsp;&nbsp;&nbsp;(".$list_matches[$m]->Court_Info.")"; }
	if($list_matches[$m]->Match_DueDate != "") { echo "&nbsp;&nbsp;".date("M-d H:i",strtotime($list_matches[$m]->Match_DueDate)); }

	if($tour_details->Usersid == $this->logged_user or $this->is_super_admin){
	?>
	<!-- <input  type="text" placeholder="Date" id="csdate<?php //echo $match_num; ?>" name="cons_match_date<?php //echo $match_num; ?>" 
	value = "<?php //if($list_matches[$m]->Match_DueDate != ""){ echo date('m/d/Y H:i', strtotime($list_matches[$m]->Match_DueDate)); } ?>" /> -->

	<script>
	var rid = "<?php echo $match_num; ?>";

	  $('#csdate'+rid).fdatepicker({
			format: 'mm/dd/yyyy hh:ii',
			disableDblClickSelection: true,
			language: 'en',
			pickTime: true
		});
	</script>

	<script>/*
	$(function() {
	 var spid = "<?php echo $match_num; ?>";
	 $('#csdate'+spid).datepick();
	});*/
	</script>

	<?php
	} else {
		if($list_matches[$m]->Match_DueDate != "") { echo date("m-d-Y H:i",strtotime($list_matches[$m]->Match_DueDate)); }
	}
	?>
	<br />
	<input type='hidden' name='cmatch_num[<?php echo $round; ?>][]' value="<?php echo $match_num; ?>" />
	<input type='hidden' name='cdraw[]' value="<?php echo $list_matches[$m]->Draw_Type; ?>" />
	</span>
	<span class="teama"><?php
	if($round == 1 and ($tour_details->Usersid == $this->logged_user or $this->is_super_admin)){
		echo "<select style='width:110px;' class='swap_player_con' id='{$list_matches[$m]->Player1}' name='p1_con_{$list_matches[$m]->Match_Num}'>";
		echo "<option value=''>Player</option>";
		foreach($looser_players as $p1){
		$selected = ($list_matches[$m]->Player1 == $p1) ? "selected" : "";
		$get_player = league::get_username(intval($p1));

		echo "<option value='$p1' $selected>".$get_player['Firstname']." ".$get_player['Lastname']."</option>";
		}
		$selected = ($list_matches[$m]->Player1 == '0') ? "selected" : "";
		//echo "<option value='0' $selected>Bye</option>";
		echo "</select>&nbsp;";

		if($is_doubles){		// Loads when the filters in bracket having Mixed or Doubles
		echo "<select style='width:110px;' class='swap_player_con' id='{$list_matches[$m]->Player1_Partner}' name='p1_p_con_{$list_matches[$m]->Match_Num}'>";
		echo "<option value=''>Player</option>";
		foreach($looser_players as $p1){
		$selected = ($list_matches[$m]->Player1_Partner == $p1) ? "selected" : "";
		$get_player = league::get_username(intval($p1));

		echo "<option value='$p1' $selected>".$get_player['Firstname']." ".$get_player['Lastname']."</option>";
		}
		$selected = ($list_matches[$m]->Player1_Partner == '0') ? "selected" : "";
		echo "</select>";
		}

	}
		if($get_username){ 
			echo "<a target='_blank' href='".$profile_base."player/".$get_username['Users_ID']."'>".$get_username['Firstname']." ".$get_username['Lastname']."</a>";

				if($get_partner_username){
					echo " - <a target='_blank' href='".$profile_base."player/".$get_partner_username['Users_ID']."'>".$get_partner_username['Firstname']." ".$get_partner_username['Lastname']."</a>"; 
				}
		} 
		else {
			//echo "----"; 
			if($list_matches[$m]->Player1_source AND $round == 1 AND $list_matches[$m]->Player1_Score != "Canceled Match" AND $list_matches[$m]->Player1 != "-1"){ $src = "<br>Loser of Match - ".$list_matches[$m]->Player1_source; }
			else if($list_matches[$m]->Player1_Score == "Canceled Match" OR $list_matches[$m]->Player1 == "-1") { $src = "Bye"; }
			else if($list_matches[$m]->Player1_source AND $round > 1) { $src = "---"; }
			else { $src = "Bye"; }

			echo $src;
		}
	?>

	<?php if($list_matches[$m]->Round_Num != 1 AND $list_matches[$m]->Draw_Type == "Consolation"){

		$get_source_scores1 = league::get_match_scores_player1($list_matches[$m]->Player1_source,$bracket_id,$tour_id,$list_matches[$m]->Draw_Type);

		if($get_source_scores1['Player1_Score'] != "" AND $get_source_scores1['Player1_Score'] != "Bye Match" AND $get_source_scores1['Player1_Score'] != "Canceled Match"){

			if($get_source_scores1['Player1_Score'] == '[0]' && $get_source_scores1['Player2_Score'] == '[0]'){
				 echo "(Won by Forfeit)";
			}
			else{
			if($get_source_scores1['Player1_Score'] != "" and $get_source_scores1['Winner'] == $get_source_scores1['Player1']){
			$p1 = json_decode($get_source_scores1['Player1_Score']);
			$p2 = json_decode($get_source_scores1['Player2_Score']);
			} 
			else if($get_source_scores1['Player2_Score'] != "" and $get_source_scores1['Winner'] == $get_source_scores1['Player2']){
			$p1 = json_decode($get_source_scores1['Player2_Score']);
			$p2 = json_decode($get_source_scores1['Player1_Score']);
			}

			if(count(array_filter($p1))>0)
			{
				for($i=0; $i<count(array_filter($p1)); $i++)
				{
					echo "($p1[$i] - $p2[$i]) ";
				}
			}
		}
		}
		else if($get_source_scores1['Player1_Score'] == "Canceled Match")
		{
					echo "Match Canceled";

		}
	}
	?>
	</span>
	<span class='team2'>&nbsp;</span>
	<span class="teamb">
	<?php 
	if($round == 1 and ($tour_details->Usersid == $this->logged_user or $this->is_super_admin)){
		echo "<select style='width:110px;' class='swap_player_con' id='{$list_matches[$m]->Player2}' name='p2_con_{$list_matches[$m]->Match_Num}'>";
		echo "<option value=''>Player</option>";
		foreach($looser_players as $p2){
		$selected = ($list_matches[$m]->Player2 == $p2) ? "selected" : "";
		$get_player = league::get_username(intval($p2));

		echo "<option value='$p2' $selected>".$get_player['Firstname']." ".$get_player['Lastname']."</option>";
		}
		$selected = ($list_matches[$m]->Player2 == '0') ? "selected" : "";
		echo "<option value='0' $selected>Bye</option>";
		echo "</select>&nbsp;";


		if($is_doubles){		// Loads when the filters in bracket having Mixed or Doubles
			$disabled = '';
			if($list_matches[$m]->Player2 == 0){
				$disabled = "disabled";
			}
		echo "<select style='width:110px;' class='swap_player_con' id='{$list_matches[$m]->Player2_Partner}' name='p2_p_con_{$list_matches[$m]->Match_Num}' {$disabled}>";
		echo "<option value=''>Player</option>";
		foreach($looser_players as $p2){
		$selected = ($list_matches[$m]->Player2_Partner == $p2) ? "selected" : "";
		$get_player = league::get_username(intval($p2));

		echo "<option value='$p2' $selected>".$get_player['Firstname']." ".$get_player['Lastname']."</option>";
		}
		$selected = ($list_matches[$m]->Player2_Partner == '0') ? "selected" : "";
		//echo "<option value='0' $selected>Bye</option>";
		echo "</select>";
		}
	}

	
	if($list_matches[$m]->Round_Num != 1 and $list_matches[$m]->Draw_Type == "Consolation"){

		$get_source_scores2 = league::get_match_scores_player2($list_matches[$m]->Player2_source,$bracket_id,$tour_id,$list_matches[$m]->Draw_Type);

		if($get_source_scores2['Player1_Score'] !=""){
			if($get_source_scores2['Player1_Score'] == '[0]' && $get_source_scores2['Player2_Score'] == '[0]'){
				 echo "(Won by Forfeit)";
			}
			else{ 
			if($get_source_scores2['Player1_Score'] != "" and $get_source_scores2['Winner'] == $get_source_scores2['Player1']){
			$p1 = json_decode($get_source_scores2['Player1_Score']);
			$p2 = json_decode($get_source_scores2['Player2_Score']);
			}
			else if($get_source_scores2['Player2_Score'] != "" and $get_source_scores2['Winner'] == $get_source_scores2['Player2']){
			$p1 = json_decode($get_source_scores2['Player2_Score']);
			$p2 = json_decode($get_source_scores2['Player1_Score']);
			}

				if(count(array_filter($p1))>0)
				{
					for($i=0; $i<count(array_filter($p1)); $i++)
					{
						echo "($p1[$i] - $p2[$i]) ";
					}
				}
		}
			} 
		}
		echo "<br>";
		?>
	
	<?php
		if($list_matches[$m]->Round_Num == 1 and $list_matches[$m]->Player2 != 0)
		{ 
		echo "<a target='_blank' href='".$profile_base."player/".$get_username2['Users_ID']."'>".$get_username2['Firstname']." ".$get_username2['Lastname']."</a>"; 
			if($get_partner_username2){
				echo " - <a target='_blank' href='".$profile_base."player/".$get_partner_username2['Users_ID']."'>".$get_partner_username2['Firstname']." ".$get_partner_username2['Lastname']."</a>"; 
			}
		}
		else if($list_matches[$m]->Round_Num != 1 and $list_matches[$m]->Player2 == 0){ echo "---"; }
		else if($get_username2) { 
			echo "<a target='_blank' href='".$profile_base."player/".$get_username2['Users_ID']."'>".$get_username2['Firstname']." ".$get_username2['Lastname']."</a>"; 
				if($get_partner_username2){
					echo " - <a target='_blank' href='".$profile_base."player/".$get_partner_username2['Users_ID']."'>".$get_partner_username2['Firstname']." ".$get_partner_username2['Lastname']."</a>"; 
				}
		}
		else {
			//echo "Bye"; 
				if($list_matches[$m]->Player2_source and $round == 1 AND $list_matches[$m]->Player2_Score != "Canceled Match" AND $list_matches[$m]->Player2 != "-1"){ $src = "<br>Loser of Match - ".$list_matches[$m]->Player2_source; }
				else if($list_matches[$m]->Player2_Score == "Canceled Match" OR $list_matches[$m]->Player2 == "-1") { $src = "Bye"; }
				else if($list_matches[$m]->Player2_source AND $round > 1) { $src = "---"; }
				else { $src = "Bye"; }

				echo $src;
			}
	?>

		
	</span>
	</div>
<? }
 }
?>
</div>
<?php if(($round) == $total_rounds){ 
switch($match_count){
	case 4:
		$box_height = '45px';
	break;

	case 8:
		$box_height = '35px';
	break;

	case 16:
		$box_height = '50px';
	break;
	
	default:
		$box_height = '50px';
	break;
}
?>
  <div class="r<?php echo $total_rounds+1; ?>">
   		<div class="final">
        	<div class="bracketbox" style='height:<?=$box_height;?>;'>
            	<span class="teamc">
				<?php if($list_matches[$m]->Winner != 0){
				 $get_username = league::get_username(intval($list_matches[$m]->Winner));
				 ($list_matches[$m]->Winner == $list_matches[$m]->Player1) ? 
					 $partner = $list_matches[$m]->Player1_Partner : $partner = $list_matches[$m]->Player2_Partner;
				 $get_partner_name = league::get_username(intval($partner));

				 echo "<h5 style='color:#f59123'><b><a target='_blank' href='".$profile_base."player/".$get_username['Users_ID']."'>".$get_username['Firstname']." ".$get_username['Lastname']."</a>";
				 	 if($partner) { echo " - <a target='_blank' href='".$profile_base."player/".$get_partner_name['Users_ID']."'>".$get_partner_name['Firstname']." ".$get_partner_name['Lastname']."</a>"; }
				 echo "</b></h5>";

					if($list_matches[$m]->Player1_Score !="" and $list_matches[$m]->Winner == $list_matches[$m]->Player1){
					$p1 = json_decode($list_matches[$m]->Player1_Score);
					$p2 = json_decode($list_matches[$m]->Player2_Score);
					} 
					else if($list_matches[$m]->Player2_Score !="" and $list_matches[$m]->Winner == $list_matches[$m]->Player2){
					$p1 = json_decode($list_matches[$m]->Player2_Score);
					$p2 = json_decode($list_matches[$m]->Player1_Score);
					}
						
						if(count(array_filter($p1))>0){
							for($i=0; $i<count(array_filter($p1)); $i++){
								echo "($p1[$i] - $p2[$i]) ";
							}
						}
					}
				?>
				</span>
            </div>
        </div>
   </div>
<?php }
}
?>
</div>
</div>


</div>	<!-- Consolation Mobile Child DIV -->
</div>	<!-- Consolation Mobile DIV -->


</form>

<?php
//if($tour_details->Usersid == $this->logged_user or $this->is_super_admin){
?>
<!-- <div class='col-md-6' style='margin-top:25px;'>
<input type="submit" class="league-form-submit1 col-md-3" name="update_con_draw" id="update_con_draw" value="Update" />
</div> -->
<?php
//}
?>
</div>