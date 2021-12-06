<?php
//$club_url = $this->config->item('club_form_url');
//echo $club_url;
if($club_url == "https://a2msports.com/league"){
	$profile_base = base_url();
}
else{
	$profile_base = $club_url."/";
}


$squad = array();
if($get_bracket['Squad']){
$squad = unserialize($get_bracket['Squad']);
}

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



//	DisableOptions(); //disable selected values

/*$(".swap_player").change(function()
{
	//$id   = $(this).attr('id');

	$(".swap_player option").attr('disabled','disabled').siblings().removeAttr('disabled');

	DisableOptions(); //disable selected values

	$(this).removeAttr('disabled');
	
});*/

/*function DisableOptions()
{
	var arr=[];
	$(".swap_player option:selected").each(function()
	{
		if($(this).val() != ""){
		  arr.push($(this).val());
		}
	});

	$(".swap_player option").filter(function()
	{
		//alert($.inArray($(this).val(),arr));
			if(($.inArray($(this).val(),arr) > -1) && $(this).val() != 0){
				$(this).attr("disabled","disabled");
			}
			else{
				$(this).attr("enabled","enabled");
			}
	});
}*/


});
</script>
<br />
<div id='ShowDraw11'></div>
<form method="post" id="frm_upd_dates" class="login-form" style='width:100%; display:grid; padding-bottom:50px;'>
<script language = "javascript" type = "text/javascript">
function myWin(tid)
{
	var path = "<?php echo base_url(); ?>";
	var tid = '<?php echo $bracket_id; ?>';
	window.open(path+'league/pdf/'+tid, null, "height=1200, width=1400, status=yes, toolbar=no, menubar=no, location=no");
}
</script>

<!-- <input type="button" class="league-form-submit1" name="capture" id="capture" style="float:right;" 
onclick="myWin(<?=$bracket_id;?>)" value="Print" /> -->

<a name='capture' id="capture" style='float:right; cursor:pointer;' onclick="myWin(<?=$bracket_id;?>);"><img src="<?php echo base_url();?>images/print-ico.png" alt="Print Draw" title="Print Draw" /> </a>

<input type="hidden" name="update_draw_status" id="update_draw_status" value="1" />

<?php
$total_rounds	= $get_bracket['No_of_rounds'];
$bracket_id		= $get_bracket['BracketID'];
$tour_id		= $get_bracket['Tourn_ID'];
$filter_events	= json_decode($get_bracket['Filter_Events']);
$is_doubles		= 0;
$events			= array();

if(count($filter_events) >0 ){
	foreach ($filter_events as $key => $event){
		$eventArr = explode('-', $event);
		$events[] = $event;
			//if($eventArr[2]	== 'Doubles' or $eventArr[2] == 'Mixed'){
			if(strpos($event, 'Doubles') or strpos($event, 'Mixed')){
				$is_doubles	= 1;
			}
	}
}
//echo "<pre>"; print_r($squad); exit;

$list_matches	= $get_tourn_matches->result();
/*
if($this->logged_user == 240){
echo "<pre>";
print_r($list_matches);
exit;
}
*/

/*$tourn_reg_players = league::get_reg_tourn_participants($tour_id);

echo '<pre>';
print_r($tourn_reg_players[0]);
print_r($tourn_reg_players[1]);*/ 

/*echo '<pre>';
print_r($tourn_reg_players[0]);
print_r($tourn_reg_players[1]);*/

	if(!empty($events)){		// When Filter_Events field in Brackets is not empty
		$tourn_reg_players = league::get_reg_tourn_participants_withGender($tour_id, $tourn_det->SportsType);
		foreach($events as $key => $evnt){
			$users[$key] = league::in_array_r($evnt, $tourn_reg_players[0]); 
		}

		$players = league::array_flatten($users);
	}
	else{						// When Filter_Events field in Brackets is not empty Loads all reg. players
		$tourn_reg_players = league::get_reg_tourn_participants($tour_id);
			foreach($tourn_reg_players[0] as $key => $val){
				$players[] = $key;
			}
//echo "<pre>"; print_r($tourn_reg_players); exit;
	}
	//echo "<pre>"; print_r($players); exit;

?>

<div class="brackets-mobile">	<!-- Mobile DIV -->
<div class="brackets-mobile-child"> <!-- Mobile child DIV -->

<div class = "brackets" id="brackets">
	<div>
<?php
if($tour_details->Usersid == $this->logged_user or $tour_details->Tournament_Director == $this->logged_user or $this->is_super_admin){
?>
<input class="form-control" type="text" name="draw_title" id="draw_title" style="width:25%; display:inline;" value="<?php echo $get_bracket['Draw_Title']; ?>" required />
<input type="submit" class="league-form-submit1" style="margin-left: 100px;" name="update_draw" id="update_draw" 
value=" Update " />
<?php
}
else{
?>
<h4 style="color:#f59123"><b><?php echo $get_bracket['Draw_Title']; ?></b></h4>
<?php
}
?>

    </div>
<div class = "group<?php echo $total_rounds+1; ?>" id="b1">
<input type='hidden' name='bracket_id' value="<?php echo $get_bracket['BracketID']; ?>" />
<input type='hidden' name='tour_id'		value="<?php echo $get_bracket['Tourn_ID']; ?>" />

<?php
$nm					 = 0;
$match_count = 0;
$round_type	 = array();
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
//$players = array_unique(array_merge($player1, $player2));
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
<span style="margin-left:40px;"><b>
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
if($tour_details->Usersid == $this->logged_user 
	or $tour_details->Tournament_Director == $this->logged_user 
	or $this->is_super_admin){
?>

<!-- <input type = "text" class = 'form-control' placeholder = "Date" id = "sdate_round<?php echo $round; ?>" name = "round_date<?php echo $round; ?>" value = "<?php if($round_dates[$round] != "")
{ echo date('m/d/Y', strtotime($round_dates[$round])); } ?>" /> -->

<!-- <input type="text" placeholder="Date" name="round_date<?php echo $round; ?>" id="sdate_round<?php echo $round; ?>"
value="<?php if($round_dates[$round] != "")
{ echo date('m/d/Y H:i', strtotime($round_dates[$round])); } ?>" /> -->

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
	if($round_dates[$round] != "") { echo date("M-d H:i",strtotime($round_dates[$round])); }
}


/*echo "<pre>"; 
print_r($player1); 
print_r($player2); 
exit;*/

foreach($list_matches as $m => $match){
$get_username  = "";
$get_username2 = "";

	if($list_matches[$m]->Round_Num == $round){
	?>
	<div class="bracketbox">
	<span class="info" style="color:#169c06; font-weight:bold;">
	<?php
	if($list_matches[$m]->Player1 != 0){
		 $get_username					= league::get_username(intval($list_matches[$m]->Player1));
		 $get_partner_username  = league::get_username(intval($list_matches[$m]->Player1_Partner));

		 $s_p1 = $list_matches[$m]->Player1;
	}

	if($list_matches[$m]->Player2 != 0){
		 $get_username2				  = league::get_username(intval($list_matches[$m]->Player2));
		 $get_partner_username2  = league::get_username(intval($list_matches[$m]->Player2_Partner));

		 $s_p2 = $list_matches[$m]->Player2;
	}
	
	$match_num = $list_matches[$m]->Match_Num;
	echo $match_num;
		

if($tour_details->Usersid == $this->logged_user 
	or $tour_details->Tournament_Director == $this->logged_user 
	or $this->is_super_admin){
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
<input type='text' placeholder="Court" name='match_court<?php echo $match_num; ?>' value='<?php echo $list_matches[$m]->Court_Info; ?>' style='width:25%' />
<input type="text" placeholder="Date" name="match_date<?php echo $match_num; ?>" id="sdate<?php echo $match_num; ?>"
value="<?php if($list_matches[$m]->Match_DueDate != "")
{ echo date('m/d/Y H:i', strtotime($list_matches[$m]->Match_DueDate)); } ?>" style='width:55%' />

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
	//if($list_matches[$m]->Match_DueDate != "") { 
	//echo "&nbsp;&nbsp;".date("M-d H:i",strtotime($list_matches[$m]->Match_DueDate)); 
	//}
}
else {
	if($list_matches[$m]->Court_Info != "") { echo "&nbsp;&nbsp;&nbsp;(".$list_matches[$m]->Court_Info.")"; }
	if($list_matches[$m]->Match_DueDate != "") { 
		echo "&nbsp;&nbsp;".date("M-d H:i",strtotime($list_matches[$m]->Match_DueDate)); 
	}
}
?>
<br />
	<?php // if($list_matches[$m]->Match_DueDate != "") { echo date("m-d-Y",strtotime($list_matches[$m]->Match_DueDate)); } ?>
	<input type='hidden' name='match_num[<?php echo $round; ?>][]' value="<?php echo $match_num; ?>" />
	<input type='hidden' name='draw[]' value="<?php echo $list_matches[$m]->Draw_Type; ?>" />

	</span>
	<span class="teama">
	<?php
	$sp = 1;
	if($round == 1 and ($tour_details->Usersid == $this->logged_user or $tour_details->Tournament_Director == $this->logged_user or $this->is_super_admin)){
		echo "<select style='width:110px;' class='swap_player' id='{$list_matches[$m]->Player1}' name='p1_{$list_matches[$m]->Match_Num}'>";
		echo "<option value=''>Player</option>";
		foreach($players as $p1){
		$selected = ($list_matches[$m]->Player1 == $p1) ? "selected" : "";
		$get_player = league::get_username(intval($p1));

		echo "<option value='$p1' $selected>".ucfirst(strtolower($get_player['Firstname']))." ".ucfirst(strtolower($get_player['Lastname']))."</option>";
		}
		$selected = ($list_matches[$m]->Player1 == '0') ? "selected" : "";
		echo "<option value='0' $selected>Bye</option>";
		echo "</select>";

		if($is_doubles){		// Loads when the filters in bracket having Mixed or Doubles
		echo "&nbsp;<select style='width:110px;' class='swap_player' id='{$list_matches[$m]->Player1_Partner}' name='p1_p_{$list_matches[$m]->Match_Num}'>";
		echo "<option value=''>Partner</option>";
		foreach($players as $p1){
		$selected = ($list_matches[$m]->Player1_Partner == $p1) ? "selected" : "";
		$get_player = league::get_username(intval($p1));

		echo "<option value='$p1' $selected>".ucfirst(strtolower($get_player['Firstname']))." ".ucfirst(strtolower($get_player['Lastname']))."</option>";
		}
		$selected = ($list_matches[$m]->Player1_Partner == '0') ? "selected" : "";
		//echo "<option value='0' $selected>Bye</option>";
		echo "</select>";
		}
		echo "<br />";
		$sp = 0;
	}
		if($get_username and $sp){ 
		echo "<a  href='".$profile_base."player/".$get_username['Users_ID']."' target='_blank'>".ucfirst(strtolower($get_username['Firstname']))." ".ucfirst(strtolower($get_username['Lastname']))."</a>";

			if($get_partner_username){
				echo " - <a href='".$profile_base."player/".$get_partner_username['Users_ID']."' target='_blank'>".ucfirst(strtolower($get_partner_username['Firstname']))." ".ucfirst(strtolower($get_partner_username['Lastname']))."</a>"; 
			}
			
		
	} else if($sp) { if($round == 1) echo "Bye"; else echo "----"; }
	
	$seed = '';
		if($round == 1 and $s_p1 != '---') {
		$seed = array_search($s_p1, $squad);
		echo " (".($seed+1).") ";
		}

	?>

	<?php if($list_matches[$m]->Round_Num != 1){

		$get_source_scores1 = league::get_match_scores_player1($list_matches[$m]->Player1_source,$bracket_id,$tour_id,$list_matches[$m]->Draw_Type);

		if($get_source_scores1['Player1_Score'] !="" && $get_source_scores1['Player1_Score'] !="Bye Match"){
				if($get_source_scores1['Player1_Score'] == '[0]' && $get_source_scores1['Player2_Score'] == '[0]')
				{
					echo "Won by Forfeit";

				}else{ 

				    $p1 = json_decode($get_source_scores1['Player1_Score']);
				    $p2 = json_decode($get_source_scores1['Player2_Score']);
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
	   ?>
	</span>
	<span class='team2'>&nbsp
	</span>
	<span class="teamb">
	<?php
	if($round == 1 and ($tour_details->Usersid == $this->logged_user or $tour_details->Tournament_Director == $this->logged_user or $this->is_super_admin)){
		echo "<select style='width:110px;' class='swap_player' id='{$list_matches[$m]->Player2}' name='p2_{$list_matches[$m]->Match_Num}'>";
		echo "<option value=''>Player</option>";
		foreach($players as $p2){
		$selected = ($list_matches[$m]->Player2 == $p2) ? "selected" : "";
		$get_player = league::get_username(intval($p2));
		echo "<option value='$p2' $selected>".ucfirst(strtolower($get_player['Firstname']))." ".ucfirst(strtolower($get_player['Lastname']))."</option>";
		}
		$selected = ($list_matches[$m]->Player2 == '0') ? "selected" : "";
		echo "<option value='0' $selected>Bye</option>";
		echo "</select>";

		if($is_doubles){		// Loads when the filters in bracket having Mixed or Doubles
			$disabled = '';
			if($list_matches[$m]->Player2 == 0){
				$disabled = "disabled";
			}
		echo "&nbsp;<select style='width:110px;' class='swap_player' id='{$list_matches[$m]->Player2_Partner}' name='p2_p_{$list_matches[$m]->Match_Num}' {$disabled}>";
		echo "<option value=''>Partner</option>";
		foreach($players as $p1){
		$selected = ($list_matches[$m]->Player2_Partner == $p1) ? "selected" : "";
		$get_player = league::get_username(intval($p1));

		echo "<option value='$p1' $selected>".ucfirst(strtolower($get_player['Firstname']))." ".ucfirst(strtolower($get_player['Lastname']))."</option>";
		}
		$selected = ($list_matches[$m]->Player2_Partner == '0') ? "selected" : "";
		//echo "<option value='0' $selected>Bye</option>";
		echo "</select>";
		}
	}

	if($list_matches[$m]->Round_Num != 1){

		$get_source_scores2 = league::get_match_scores_player2($list_matches[$m]->Player2_source, $bracket_id, $tour_id, $list_matches[$m]->Draw_Type);

		if($get_source_scores2['Player1_Score'] !=""){
			if($get_source_scores2['Player1_Score'] == '[0]' && $get_source_scores2['Player2_Score'] == '[0]')
				{
					
				 echo "Won by Forfeit";

				}else{ 
					$p1 = json_decode($get_source_scores2['Player1_Score']);
					$p2 = json_decode($get_source_scores2['Player2_Score']);

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
	
	<?php if($list_matches[$m]->Round_Num == 1 and $list_matches[$m]->Player2 != 0 and $sp)
		{ 
		echo "<a href='".$profile_base."player/".$get_username2['Users_ID']."' target='_blank'>".ucfirst(strtolower($get_username2['Firstname']))." ".ucfirst(strtolower($get_username2['Lastname']))."</a>"; 
			if($get_partner_username2){
				echo " - <a href='".$profile_base."player/".$get_partner_username2['Users_ID']."' target='_blank'>".ucfirst(strtolower($get_partner_username2['Firstname']))." ".ucfirst(strtolower($get_partner_username2['Lastname']))."</a>"; 
			}
		}
	else if($list_matches[$m]->Round_Num != 1 and $list_matches[$m]->Player2 == 0){ echo "---"; }
	else if($get_username2 and $sp){ 
		echo "<a href='".$profile_base."player/".$get_username2['Users_ID']."' target='_blank'>".ucfirst(strtolower($get_username2['Firstname']))." ".ucfirst(strtolower($get_username2['Lastname']))."</a>"; 
			if($get_partner_username2){
				echo " - <a href='".$profile_base."player/".$get_partner_username2['Users_ID']."' target='_blank'>".ucfirst(strtolower($get_partner_username2['Firstname']))." ".ucfirst(strtolower($get_partner_username2['Lastname']))."</a>"; 
			}
	}
	else if($sp){ echo "Bye"; }

		$seed = '';
		if($round == 1 and $s_p2 != '---') {
		$seed = array_search($s_p2, $squad);
		echo " (".($seed+1).") ";
		}
	?>
	</span>
	</div>
<? }

	if($list_matches[$m]->Round_Num == $total_rounds 
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
		
if($tour_details->Usersid == $this->logged_user or $tour_details->Tournament_Director == $this->logged_user or $this->is_super_admin){
?>
<!-- <input  type="text" class='form-control' placeholder="Date" id="sdate<?php echo $match_num; ?>" name="match_date<?php echo $match_num; ?>" 
value = "<?php if($list_matches[0]->Match_DueDate != "")
{ echo date('m/d/Y', strtotime($list_matches[0]->Match_DueDate)); } ?>" /> -->
<script>
/*$(function() {
 var spid = "<?php echo $match_num; ?>";
 $('#sdate'+spid).datepick();
});*/
</script>
<input type='text' placeholder="Court" name='match_court<?php echo $match_num; ?>' value='<?php echo $list_matches[0]->Court_Info; ?>' style='width:25%' />
<input type="text" placeholder="Date" name="match_date<?php echo $match_num; ?>" id="sdate<?php echo $match_num; ?>"
value="<?php if($list_matches[0]->Match_DueDate != "")
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
	if($list_matches[0]->Court_Info != "") { echo "&nbsp;&nbsp;&nbsp;(".$list_matches[0]->Court_Info.")"; }
	if($list_matches[0]->Match_DueDate != "") { echo "&nbsp;&nbsp;".date("M-d H:i",strtotime($list_matches[0]->Match_DueDate));
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
	if($round == 1 and ($tour_details->Usersid == $this->logged_user or $tour_details->Tournament_Director == $this->logged_user or $this->is_super_admin)){
		echo "<select style='width:110px;' class='swap_player' id='{$list_matches[0]->Player1}' name='p1_{$list_matches[0]->Match_Num}'>";
		echo "<option value=''>Player</option>";
		foreach($players as $p1){
		$selected = ($list_matches[0]->Player1 == $p1) ? "selected" : "";
		$get_player = league::get_username(intval($p1));

		echo "<option value='$p1' $selected>".$get_player['Firstname']." ".$get_player['Lastname']."</option>";
		}
		$selected = ($list_matches[0]->Player1 == '0') ? "selected" : "";
		echo "<option value='0' $selected>Bye</option>";
		echo "</select>";

		if($is_doubles){		// Loads when the filters in bracket having Mixed or Doubles
		echo "&nbsp;<select style='width:110px;' class='swap_player' id='{$list_matches[0]->Player1_Partner}' name='p1_p_{$list_matches[0]->Match_Num}'>";
		echo "<option value=''>Partner</option>";
		foreach($players as $p1){
		$selected = ($list_matches[0]->Player1_Partner == $p1) ? "selected" : "";
		$get_player = league::get_username(intval($p1));

		echo "<option value='$p1' $selected>".$get_player['Firstname']." ".$get_player['Lastname']."</option>";
		}
		$selected = ($list_matches[0]->Player1_Partner == '0') ? "selected" : "";
		//echo "<option value='0' $selected>Bye</option>";
		echo "</select>";
		}
		echo "<br />";
	}
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
	if($round == 1 and ($tour_details->Usersid == $this->logged_user or $tour_details->Tournament_Director == $this->logged_user or $this->is_super_admin)){
		echo "<select style='width:110px;' class='swap_player' id='{$list_matches[0]->Player2}' name='p2_{$list_matches[0]->Match_Num}'>";
		echo "<option value=''>Player</option>";
		foreach($players as $p2){
		$selected = ($list_matches[0]->Player2 == $p2) ? "selected" : "";
		$get_player = league::get_username(intval($p2));
		echo "<option value='$p2' $selected>".$get_player['Firstname']." ".$get_player['Lastname']."</option>";
		}
		$selected = ($list_matches[0]->Player2 == '0') ? "selected" : "";
		echo "<option value='0' $selected>Bye</option>";
		echo "</select>";

		if($is_doubles){		// Loads when the filters in bracket having Mixed or Doubles
			$disabled = '';
			if($list_matches[0]->Player2 == 0){
				$disabled = "disabled";
			}
		echo "&nbsp;<select style='width:110px;' class='swap_player' id='{$list_matches[0]->Player2_Partner}' name='p2_p_{$list_matches[0]->Match_Num}' {$disabled}>";
		echo "<option value=''>Partner</option>";
		foreach($players as $p1){
		$selected = ($list_matches[0]->Player2_Partner == $p1) ? "selected" : "";
		$get_player = league::get_username(intval($p1));

		echo "<option value='$p1' $selected>".$get_player['Firstname']." ".$get_player['Lastname']."</option>";
		}
		$selected = ($list_matches[0]->Player2_Partner == '0') ? "selected" : "";
		//echo "<option value='0' $selected>Bye</option>";
		echo "</select>";
		}
	}
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
<? }
 }
?>
</div>

<?php if(($round) == $total_rounds){ ?>
  <div class="r<?php echo $total_rounds+1; ?>">
   		<div class="final">
        	<div class="bracketbox">
            	<span class="teamc">
				<?php
				if($list_matches[$m]->Winner != 0){

					if($list_matches[$m]->Winner == $list_matches[$m]->Player1){
						 $get_username				= league::get_username(intval($list_matches[$m]->Player1));
						 $get_partner_username	= league::get_username(intval($list_matches[$m]->Player1_Partner));
							
							echo "<h5 style='color:#f59123'><b>";
							if($get_username){ 
							echo "<a href='".$profile_base."player/".$get_username['Users_ID']."' target='_blank'>".$get_username['Firstname']." ".$get_username['Lastname']."</a>";

							if($get_partner_username){
							echo " - <a href='".$profile_base."player/".$get_partner_username['Users_ID']."' target='_blank'>".$get_partner_username['Firstname']." ".$get_partner_username['Lastname']."</a>"; 
							}
							}
							echo "</b></h5>";

							if($list_matches[$m]->Player1_Score !=""){

								if($list_matches[$m]->Player1_Score == '[0]' && $list_matches[$m]->Player2_Score == '[0]'){
									
								 echo "Won by Forfeit";

								}
								else{ 
									$p1 = json_decode($list_matches[$m]->Player1_Score);
									$p2 = json_decode($list_matches[$m]->Player2_Score);

										if(count(array_filter($p1))>0){
											for($i=0; $i<count(array_filter($p1)); $i++){
												echo "($p1[$i] - $p2[$i]) ";
											}
										}
								}
							} 
					}
					else{
						 $get_username			= league::get_username(intval($list_matches[$m]->Player2));
						 $get_partner_username	= league::get_username(intval($list_matches[$m]->Player2_Partner));
							
							echo "<h5 style='color:#f59123'><b>";
							if($get_username){ 
							echo "<a href='".$profile_base."player/".$get_username['Users_ID']."' target='_blank'>".$get_username['Firstname']." ".$get_username['Lastname']."</a>";

							if($get_partner_username){
							echo " - <a href='".$profile_base."player/".$get_partner_username['Users_ID']."' target='_blank'>".$get_partner_username['Firstname']." ".$get_partner_username['Lastname']."</a>"; 
							}
							}
							echo "</b></h5>";

							
							if($list_matches[$m]->Player1_Score !=""){
                                if($list_matches[$m]->Player1_Score == '[0]' && $list_matches[$m]->Player2_Score == '[0]'){
								 echo "Won by Forfeit";
								}
								else{ 
									$p1 = json_decode($list_matches[$m]->Player1_Score);
									$p2 = json_decode($list_matches[$m]->Player2_Score);

									if(count(array_filter($p2))>0){
										for($i=0; $i<count(array_filter($p2)); $i++){
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

<?php } ?>

<!-- ----------------------------------------------------- -->

<?php if($round == $total_rounds and $list_matches[0]->Round_Num == -1){ ?>
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

<?php } ?>


<!-- <input type="hidden" id="tourn_id"  name="tourn_id" value="<?php echo $this->input->post('tourn_id'); ?>" />
<input type='hidden' name='match_type'	value="<?php echo $this->input->post('types'); ?>" />
<input type='hidden' name='age_group'	value="<?php echo $this->input->post('type_gen'); ?>" />
<input type='hidden' name='ttype'		value="<?php echo $this->input->post('ttype'); ?>" />
 -->
<?
}
//if($tour_details->Usersid == $this->logged_user or $this->is_super_admin){
?>
<!-- <input type="submit" class="league-form-submit1" name="update_draw" id="update_draw" value=" Update " /> -->
<?php
//}
?>
</div>
</div>

</div> <!-- Child Mobile DIV -->
</div>	<!-- Mobile DIV -->

</form>