<style>
input:focus::placeholder {
  color: transparent;
}
</style>
<?php
if($club_url == "https://a2msports.com/league"){
	$profile_base = base_url();
}
else{
	$profile_base = $club_url."/";
}
?>
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

$('.change_home_user').click(function(){
var id = $(this).attr('id');
var a = id.split('_');
var tm		= a[0];
var team = a[1];

	if(tm && team){
		if(confirm("Are you sure to change Home Location?")){
	
			$.ajax({
				type:'POST',
				url:baseurl+'league/change_team_homeloc/',
				data:{tm:tm,team:team},
				success:function(res){
					alert("Changes are Done! Refresh the page to reflect the changes");
					//location.reload();
				}
			});		
		}
	}

});

});
</script>
<script src="<?php echo base_url();?>js/jquery.accordion.js" type="text/javascript"></script>
<script type="text/javascript">
/*$(document).ready(function () {
$(function () {
"use strict";
$('.accordion').accordion({ defaultOpen: 'up_match_section' }); //some_id section1 in demoup_tour_section
});
});*/
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
<input type="button" class="league-form-submit1" name="capture" id="capture" value="Print Results" style="float:right;" onclick="myWin(<?=$bracket_id;?>)" />
<br />
<br />
<div id='ShowDraw11'></div>

<form method="post" id="frm_upd_dates">
<?php 
$rr_matches = $get_rr_tourn_matches->result();
$tourn_id	= $get_bracket['Tourn_ID'];
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
<?php
	$player_select = '';
if($tour_details->Usersid == $this->logged_user or $this->is_super_admin){

	if($reg_players){
		//$player_select = "<select>";
		foreach($reg_players as $rp){
			$user_id = $rp->Users_ID;
			$fname = $rp->Firstname;
			$lname = $rp->Lastname;
		$player_select .= "<option value='".$user_id."'>".$fname ." ".$lname."</option>";
		}
		//$player_select .= "</select>";

	}

	if($event_reg_players){
		//$player_select = "<select>";
		foreach($event_reg_players as $rp){
			$user_id = $rp->Users_ID;
			$fname = $rp->Firstname;
			$lname = $rp->Lastname;
		$player_select_opt .= "<option value='".$user_id."'>".$fname ." ".$lname."</option>";
		}
		//$player_select .= "</select>";
//echo "<pre>"; print_r($player_select_opt); exit;
	}
?>
<input class="form-control col-md-5" type="text" name="draw_title" id="draw_title" style="width:25%;margin-bottom: 10px;" value="<?php echo $get_bracket['Draw_Title']; ?>" required />

&nbsp;&nbsp;&nbsp;&nbsp;
<input type="button" id='update_draw' name='update_rr_dates' class='league-form-submit1' value=" Update " />



<?php
}
else{
?>
<p><b><?php echo $get_bracket['Draw_Title']; ?></b></p>
<?php
}
?>

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
<td align='center'>Match Date</td>
<td align='center' colspan='2'>Match <?=$rr_matches[$m]->Round_Num;?>

<?php
if($tour_details->Usersid == $this->logged_user){
?>
<input type='hidden' name='round[]' value="<?php echo $round; ?>" />


<input type="text" placeholder="Date" name="round_date<?php echo $round; ?>" id="round_date<?php echo $round; ?>"
value="<?php if($rr_matches[$m]->Match_DueDate != ""){ 
	if(date('H:i', strtotime($rr_matches[$m]->Match_DueDate)) != "00:00"){ 
		echo date('m/d/Y H:i', strtotime($rr_matches[$m]->Match_DueDate)); } 
	else{ 
		echo date('m/d/Y', strtotime($rr_matches[$m]->Match_DueDate)); } 
	} ?>">
<script>
var rid = "<?php echo $round; ?>";
/*
  $('#round_date'+rid).fdatepicker({
		format: 'mm/dd/yyyy hh:ii',
		disableDblClickSelection: true,
		language: 'en',
		pickTime: true
	});
*/
</script>

<?php
/*if($rr_matches[$m]->Match_DueDate){

 $split_date = explode(" ",$rr_matches[$m]->Match_DueDate);
 $date1 = ($split_date[1] != "00:00:00.000" and $split_date[1] != "") ?
 date("m/d/Y h:i A", strtotime($rr_matches[$m]->Match_DueDate)) : date("m/d/Y", strtotime($rr_matches[$m]->Match_DueDate));

echo "&nbsp;&nbsp;&nbsp;&nbsp;(Play by: ".$date1.")";
}*/
} 
//else {
//		if($rr_matches[$m]->Match_DueDate != "") { echo date("m/d/Y H:i",strtotime($rr_matches[$m]->Match_DueDate)); }
//}
?>
</td>
<?php if($tour_details->Tournament_type == 'Flexible League'){ 
echo "<td align='center'>Location</td>";
 if($this->logged_user_role == 'Admin'){ ?>
<td align='center'>&nbsp;Swap Home<br>Location</td>
<?php 
	}
 }
 ?>

<td align='center'>Scores&nbsp;&nbsp;</td>
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
$player1 = league::get_username(intval($rr_matches[$m]->Player1));
$player2 = league::get_username(intval($rr_matches[$m]->Player2));

$p1_part = "";
$p2_part = "";

if($rr_matches[$m]->Player1_Partner){
	$player1_partner = league::get_username(intval($rr_matches[$m]->Player1_Partner));
	$p1_part = "; <a href='".$profile_base."player/".$player1_partner['Users_ID']."' target='_blank'>$player1_partner[Firstname] $player1_partner[Lastname]</a>";
}

if($rr_matches[$m]->Player2_Partner){
	$player2_partner = league::get_username(intval($rr_matches[$m]->Player2_Partner));
	$p2_part = "; <a href='".$profile_base."player/".$player2_partner['Users_ID']."' target='_blank'>$player2_partner[Firstname] $player2_partner[Lastname]</a>";
}

$tm_id = $rr_matches[$m]->Tourn_match_id;
$player1_loc_icon = "";
$player2_loc_icon = "";
$home_user = 'player1';
//$away_user = 'player2';

	if($rr_matches[$m]->Match_Location_User and $rr_matches[$m]->Match_Location_User == $rr_matches[$m]->Player1){
		$get_homeloc = league::get_home_location($player1['Home_loc_id']);
		$player1_loc_icon = "<img src='".base_url()."icons/home.png' style='width:24px;height:24px;' />";
		$player2_loc_icon = "<img src='".base_url()."icons/car.png' style='width:24px;height:24px;' />";
		$home_user = 'player1';
		$away_user = $rr_matches[$m]->Player2;
	}
	else if($rr_matches[$m]->Match_Location_User and $rr_matches[$m]->Match_Location_User == $rr_matches[$m]->Player2){
		$get_homeloc = league::get_home_location($player2['Home_loc_id']);
		$player2_loc_icon = "<img src='".base_url()."icons/home.png' style='width:24px;height:24px;' />";
		$player1_loc_icon = "<img src='".base_url()."icons/car.png' style='width:24px;height:24px;' />";
		$home_user = 'player2';
		$away_user = $rr_matches[$m]->Player1;
	}
//echo $home_user;
?>

<tr>
<script>
var mid = "<?php echo $match_num; ?>";

$('#sdate'+mid).fdatepicker({
	format: 'mm/dd/yyyy hh:ii',
	disableDblClickSelection: true,
	language: 'en',
	pickTime: true
});
</script>
<td align='center'><?php echo $match_num; ?></td>
<input type='hidden' name='matches[]' value="<?php echo $match_num; ?>" />
	<td style="padding-left:15px; padding-right:10px;">
	<?php
		if($rr_matches[$m]->Court_Info != NULL and $rr_matches[$m]->Court_Info != ''){
			if($tour_details->Usersid == $this->logged_user or $this->is_super_admin){
				echo "<input type='text' name='match_court{$match_num}' value='{$rr_matches[$m]->Court_Info}' style='width:13%' />";
			}
			else{
				echo $rr_matches[$m]->Court_Info;
			}
		}
		else if($tour_details->Usersid == $this->logged_user or $this->is_super_admin){
				echo "<input type='text' name='match_court{$match_num}' placeholder='Court' value='' style='width:13%' />";
		}


		if($rr_matches[$m]->Match_DueDate != "") { 
				if($tour_details->Usersid == $this->logged_user or $this->is_super_admin){?>
				<input type="text" placeholder="Date" id="sdate<?=$match_num; ?>" name="match_date<?=$match_num; ?>" 
				value = "<?php if($rr_matches[$m]->Match_DueDate != ""){ echo date('m/d/Y H:i', strtotime($rr_matches[$m]->Match_DueDate)); } ?>" />
				<?php 
				}
				else{
					echo " (";
					if(date('H:i', strtotime($rr_matches[$m]->Match_DueDate)) != "00:00"){ 
						echo date('m/d/Y H:i', strtotime($rr_matches[$m]->Match_DueDate)); } 
					else{ 
						echo date('m/d/Y', strtotime($rr_matches[$m]->Match_DueDate)); }
					echo ")&nbsp;&nbsp;&nbsp;&nbsp;";
				}
		}
		else{
				if($tour_details->Usersid == $this->logged_user or $this->is_super_admin){?>
				<input type="text" placeholder="Date" id="sdate<?=$match_num; ?>" name="match_date<?=$match_num; ?>" 
				value = "<?php if($rr_matches[$m]->Match_DueDate != ""){ echo date('m/d/Y H:i', strtotime($rr_matches[$m]->Match_DueDate)); } ?>" />
				<?php 
				}
		}
	?>
</td>
<td>&nbsp;
<?php
if($home_user == 'player1'){
				 $bold_start = ""; $bold_end = ""; 

		if($rr_matches[$m]->Winner == $rr_matches[$m]->Player1) {
				 $bold_start = "<b>"; $bold_end = "</b>"; 
		}

//if($tour_details->Usersid == $this->logged_user or $this->is_super_admin and $rr_matches[$m]->Winner == ''){
//	echo "<select class='ch_player' id='ch_{$tm_id}_p1_".$player1['Users_ID']."'>".$player_select."</select>"; 
//}
//else{
echo "<a href='".$profile_base."player/".$player1['Users_ID']."' target='_blank'>".$bold_start.$player1['Firstname']." ".$player1['Lastname']."</a>".$p1_part.$bold_end." ".$player1_loc_icon; 
//}

	if($rr_matches[$m]->Winner == $rr_matches[$m]->Player1) {
		echo "<img id='img-winner' src='".base_url()."images/gold_medal_small.png' width='20' height='20'></img>";
		$p1_won  = 1;
		$p2_lost = 1;
		$p1_result = 'W';
		$p2_result = 'L';
	}
}
else{
		$bold_start = ""; $bold_end = ""; 

		if($rr_matches[$m]->Winner == $rr_matches[$m]->Player2) {
				 $bold_start = "<b>"; $bold_end = "</b>"; 
		}

echo "<a href='".$profile_base."player/".$player2['Users_ID']."' target='_blank'>".$bold_start.$player2['Firstname']." ".$player2['Lastname']."</a>".$p2_part.$bold_end." ".$player2_loc_icon;

	if($rr_matches[$m]->Winner == $rr_matches[$m]->Player2) {
		echo "<img id='img-winner' src='".base_url()."images/gold_medal_small.png' width='20' height='20'></img>";
		$p2_won  = 1;
		$p1_lost = 1;
		$p1_result = 'L';
		$p2_result = 'W';
	}
}
	?>
	<br />
	<?php
	if($tour_details->Usersid == $this->logged_user or $this->is_super_admin){
		echo "<select id='p1_{$rr_matches[$m]->Tourn_match_id}' name='player1' class='rr_ch_player'>";
		echo "<option value=''>Player1</option>";
		echo $player_select_opt;
		echo "</select>";

			$is_disable = "";
			$title = "";

		if(!$rr_matches[$m]->Player1){
			$is_disable = "disabled";
			$title = "title = 'Update Player1'";
		}

		echo "&nbsp;&nbsp;";
		echo "<select id='p1p_{$rr_matches[$m]->Tourn_match_id}' name='player1partner' class='rr_ch_player' $is_disable $title>";
		echo "<option value=''>Player1 Partner</option>";
		echo $player_select_opt;
		echo "</select>";
	}
	?>

	</td>
	 <td style="padding-left:15px;">
	 <?php 
	 $bold_start = ""; $bold_end = ""; 
	if($home_user != 'player1'){
		if($rr_matches[$m]->Winner == $rr_matches[$m]->Player1) {
				 $bold_start = "<b>"; $bold_end = "</b>"; 
		}

echo "<a href='".$profile_base."player/".$player1['Users_ID']."' target='_blank'>". $bold_start.$player1['Firstname']." ".$player1['Lastname']."</a>".$p1_part. $bold_end." ".$player1_loc_icon; 
	if($rr_matches[$m]->Winner == $rr_matches[$m]->Player1) {
		echo "<img id='img-winner' src='".base_url()."images/gold_medal_small.png' width='20' height='20'></img>";
		$p1_won  = 1;
		$p2_lost = 1;
		$p1_result = 'W';
		$p2_result = 'L';
	}
	}
	else{
			 $bold_start = ""; $bold_end = ""; 

		if($rr_matches[$m]->Winner == $rr_matches[$m]->Player2) {
				 $bold_start = "<b>"; $bold_end = "</b>"; 
		}

	echo "<a href='".$profile_base."player/".$player2['Users_ID']."' target='_blank'>".$bold_start.$player2['Firstname']." ".$player2['Lastname']."</a>".$p2_part.$bold_end." ".$player2_loc_icon;

	if($rr_matches[$m]->Winner == $rr_matches[$m]->Player2) {
		echo "<img id='img-winner' src='".base_url()."images/gold_medal_small.png' width='20' height='20'></img>";
		$p2_won  = 1;
		$p1_lost = 1;
		$p1_result = 'L';
		$p2_result = 'W';
	}
	}
	 ?>
	 	<br />
	<?php
	if($tour_details->Usersid == $this->logged_user or $this->is_super_admin){
		echo "<select id='p2_{$rr_matches[$m]->Tourn_match_id}' name='player2' class='rr_ch_player'>";
		echo "<option value=''>Player2</option>";
		echo $player_select_opt;
		echo "</select>";
			$is_disable = "";
			$title = "";
		if(!$rr_matches[$m]->Player2){
			$is_disable = "disabled";
			$title = "title = 'Update Player2'";
		}

		echo "&nbsp;&nbsp;";
		echo "<select id='p2p_{$rr_matches[$m]->Tourn_match_id}' name='player2partner' class='rr_ch_player' $is_disable $title>";
		echo "<option value=''>Player2 Partner</option>";
		echo $player_select_opt;
		echo "</select>";
	}
	?>
	<!-- <input style="padding:2px;" type="button" id='update_players_<?=$rr_matches[$m]->Tourn_match_id;?>' name='update_players' class='league-form-submit1 update_players' value=" Update " /> -->
	 </td>
	
	<?php if($tour_details->Tournament_type == 'Flexible League'){ ?>
	 <td style="padding-left:15px;">
	 <?php if($rr_matches[$m]->Match_Location_User) { $loc_user_id = $rr_matches[$m]->Match_Location_User; }
		$get_loc_id = league::get_user_home_location($tourn_id, $loc_user_id);
		$get_loc	  = league::get_home_location($get_loc_id['hcl_id']);

		$map_url =  "https://www.google.co.in/maps/place/".$get_loc['hcl_address']."+".$get_loc['hcl_city']."+".$get_loc['hcl_state']."+".$get_loc['hcl_country'];

		echo "<a href='".$map_url."' title='".$get_loc['hcl_address'].", ".$get_loc['hcl_city'].", ".$get_loc['hcl_state'].", ".$get_loc['hcl_country']."' target='_blank'>".$get_loc['hcl_title']."</a><br>"; ?>
	 </td>

	 <?php if($this->logged_user_role == 'Admin' and $rr_matches[$m]->Winner == ""){ ?>
	<td style='padding-left:55px;'>
	 <?php echo "<a href='#' title='Change Home Location' id='".$rr_matches[$m]->Tourn_match_id."_".$away_user."' class='change_home_user'>"."<img src='".base_url()."icons/swap.png' style='width:24px;height:24px;' />"."</a>";?>
	</td>
	<?php }
	} ?>
	 <td style="padding-left:15px;">
	 <?php
		if($rr_matches[$m]->Winner != "") {?>
		<?php
		if($rr_matches[$m]->Player1_Score !=""){
		$p1 = array(); $p2 = array();
		$p1 = json_decode($rr_matches[$m]->Player1_Score);
		$p2 = json_decode($rr_matches[$m]->Player2_Score);

		$cnt  = count(array_filter($p1));
		$cnt2 = count(array_filter($p2));
		if($cnt > 0){
			 if($rr_matches[$m]->Player1 == $rr_matches[$m]->Winner){
				for($i=0; $i<count($p1); $i++){
					echo "($p1[$i]-$p2[$i]) ";
						if($p1[$i] > $p2[$i]){ $p1_set_win++; } 
						else { $p2_set_win++; }
				}
			 }
	    	 else{
				for($i=0; $i<count($p1); $i++){
					echo "($p2[$i]-$p1[$i]) ";
						if($p1[$i] > $p2[$i]){ $p1_set_win++; } 
						else { $p2_set_win++; }
				}
			 }
		}
		else if($cnt2 > 0){
			 if($rr_matches[$m]->Player1 == $rr_matches[$m]->Winner){
				for($i=0; $i<count($p2); $i++){
					echo "($p1[$i]-$p2[$i]) ";
						if($p1[$i] > $p2[$i]){ $p1_set_win++; } 
						else { $p2_set_win++; }
				}
			 }
	    	 else{
				for($i=0; $i<count($p2); $i++){
					echo "($p2[$i]-$p1[$i]) ";
						if($p1[$i] > $p2[$i]){ $p1_set_win++; } 
						else { $p2_set_win++; }
				}
			 }
		}
		else if($cnt == 0 and $rr_matches[$m]->Player1_Score != "Bye Match" and $rr_matches[$m]->Player2_Score != "Bye Match"){
					echo "Won by Forfeit ";
		}

		}
		?>
	 <?php } ?>
	 </td>
	
	  <?php if(($rr_matches[$m]->Player1 == $this->session->userdata('users_id') or $rr_matches[$m]->Player2 == $this->session->userdata('users_id') or $rr_matches[$m]->Player1_Partner == $this->session->userdata('users_id') or $rr_matches[$m]->Player2_Partner == $this->session->userdata('users_id') or $this->session->userdata('users_id') == $tour_details->Usersid)) {?>
	 <td style="padding-left:5px;">
		 <a id="comment_add" class="add_comment" href="#comments" name="<?php echo $tm_id; ?>">Message</a>
		<!-- <a id="ch_player_<?=$tm_id;?>" class="change_player" title="Change Player">Edit</a> -->
	 </td>
	 
	 <?php }
	 else {  ?>
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
		foreach($get_match_comments as $comment){ 
		$name = league :: get_username($comment->Users_Id);
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
		}
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
$grid_array[$rr_matches[$m]->Player1]['player_name']  = $player1['Firstname']." ".$player1['Lastname'];

if($rr_matches[$m]->Player1_Partner){
$grid_array[$rr_matches[$m]->Player1]['player_name']  = $player1['Firstname'][0].".".$player1['Lastname'];
$grid_array[$rr_matches[$m]->Player1]['partner']	  = $rr_matches[$m]->Player1_Partner;
$grid_array[$rr_matches[$m]->Player1]['partner_name'] =  "; ".$player1_partner['Firstname'][0].".".$player1_partner['Lastname'];
}

$grid_array[$rr_matches[$m]->Player1]['won']  += $p1_won;
$grid_array[$rr_matches[$m]->Player1]['lost'] += $p1_lost;
$grid_array[$rr_matches[$m]->Player1]['points'] += $rr_matches[$m]->Player1_points;

$grid_array[$rr_matches[$m]->Player2]['opponents'][$rr_matches[$m]->Player1]['sets']   = $p2_set_win.'-'.$p1_set_win;
$grid_array[$rr_matches[$m]->Player2]['opponents'][$rr_matches[$m]->Player1]['result'] = $p2_result;
$grid_array[$rr_matches[$m]->Player2]['player_name']  = $player2['Firstname']." ".$player2['Lastname'];

if($rr_matches[$m]->Player2_Partner){
$grid_array[$rr_matches[$m]->Player2]['player_name']  = $player2['Firstname'][0].".".$player2['Lastname'];
$grid_array[$rr_matches[$m]->Player2]['partner']	  = $rr_matches[$m]->Player2_Partner;
$grid_array[$rr_matches[$m]->Player2]['partner_name'] =  "; ".$player2_partner['Firstname'][0].".".$player2_partner['Lastname'];
}

$grid_array[$rr_matches[$m]->Player2]['won']  += $p2_won;
$grid_array[$rr_matches[$m]->Player2]['lost'] += $p2_lost;
$grid_array[$rr_matches[$m]->Player2]['points'] += $rr_matches[$m]->Player2_points;

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
<!-- <div class='col-md-1 form-group internal'>
<input type="button" id='update_draw' name='update_rr_dates' class='league-form-submit1' value=" Update " />
</div> -->
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
$temp = 1;
$m		= array();
$arr		= array();
foreach($rr_matches2 as $m2 => $match2){
//echo $m2."<br>";
if($temp != $rr_matches2[$m2]->Round_Num){
	// echo $temp." temp<br>";
	$m[$temp] = $arr;
	$temp	  = $rr_matches2[$m2]->Round_Num;
	$arr  = array();
}
$arr[] = $rr_matches2[$m2]->Player1;
$arr[] = $rr_matches2[$m2]->Player2;

if($temp == $get_bracket['No_of_rounds'] and ($m2+1) == count($rr_matches2)){
	$m[$temp]	= $arr;
	$temp			= $rr_matches2[$m2]->Round_Num;
	$arr				= array();
}
	//echo $rr_matches2[$m2]->Player1."-".$rr_matches2[$m2]->Player1_Partner." ";
	if(!in_array($rr_matches2[$m2]->Player1."-".$rr_matches2[$m2]->Player1_Partner, $list_players))
	{	$list_players[] = $rr_matches2[$m2]->Player1."-".$rr_matches2[$m2]->Player1_Partner; }

	if(!in_array($rr_matches2[$m2]->Player2."-".$rr_matches2[$m2]->Player2_Partner, $list_players))
	{	$list_players[] = $rr_matches2[$m2]->Player2."-".$rr_matches2[$m2]->Player2_Partner; }
}

/*if($this->logged_user == 240){
echo "<pre>";
print_r($m);
print_r($list_players);
exit;
}*/
$players_count = count($list_players);
$num_matches = ($players_count % 2 == 0) ? $players_count-1 : $players_count;

//$num_matches = count($list_players) - 1;
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
<td class="score-position" valign="center" align="center">Init Rating&nbsp;&nbsp;</td>
<td class="score-position" valign="center" align="center">Final Rating&nbsp;&nbsp;</td>
<td class="score-position" valign="center" align="center">Change&nbsp;&nbsp;</td>

</tr>
<?php
//echo "<pre>"; print_r($list_players); exit;

foreach($list_players as $ind => $player){
	$tot_p = 0;
	$player_tot_score = 0;
	$p1p2_tot_score = 0;

	foreach($rr_matches2 as $m2 => $match2){
		if($rr_matches2[$m2]->Player1_Partner)
			$match_player1 = $rr_matches2[$m2]->Player1."-".$rr_matches2[$m2]->Player1_Partner;
		else
			$match_player1 = $rr_matches2[$m2]->Player1;

		if($rr_matches2[$m2]->Player2_Partner)
			$match_player2 = $rr_matches2[$m2]->Player2."-".$rr_matches2[$m2]->Player2_Partner;
		else
			$match_player2 = $rr_matches2[$m2]->Player2;

		//if($rr_matches2[$m2]->Player1 == $player or $rr_matches2[$m2]->Player2 == $player){
		if($match_player1 == $player or $match_player2 == $player){

		$p1_sum	= 0;
		$p2_sum = 0;
		$p1		= array();
		$p2		= array();

				if($match_player1 == $player) { 
						$tot_p += $rr_matches2[$m2]->Player1_points;

				/*  Win percentage calculation for player when he is listed as PLAYER1 for that match*/

				$p1		= json_decode($rr_matches2[$m2]->Player1_Score);  
				$cnt1	= count(array_filter($p1));

				if($cnt1 > 0) {
					for($i=0; $i<count(array_filter($p1)); $i++) {
						$p1_sum = intval($p1_sum) + intval($p1[$i]);
					}
				}

				$p2		= json_decode($rr_matches2[$m2]->Player2_Score);
				$cnt2	= count(array_filter($p2));
	
				if($cnt2 > 0) {
					for($i=0; $i<count(array_filter($p2)); $i++) {
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
							for($i=0; $i<count(array_filter($p1)); $i++){
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
				$p1p2_tot_score		+= ($p1_sum + $p2_sum);
		}
	}
$win_per = ($player_tot_score / $p1p2_tot_score) * 100;

//$players_sort[$player] = array('points' => $tot_p, 'win_per' => number_format($win_per, 2));
$players_sort[$player] = array('points' => $tot_p, 'win_per' => $player_tot_score, 'win_per2' => number_format($win_per, 2));
}


			foreach($players_sort as $pl => $x){
				$cnt = 0;
				$temp = '';
				if(!in_array($pl, $temp))
					$temp[] = $pl;

				foreach($players_sort as $pl2 => $x2){
					if($x['points'] == $x2['points']){
						$cnt++;
							if(!in_array($pl2, $temp))
							$temp[] = $pl2;
					}
				}
				$points_count_arr[$x['points']]['count'] = $cnt;
				//$points_count_arr[$x['points']][] = $temp;
			}


$sort_func = uasort($players_sort, array('league', 'compareOrder'));
$keys_arr  = array_keys($players_sort); 

//echo "<pre>";
//print_r($keys_arr);
//if($this->logged_user == 240){
//echo "<pre>"; print_r($players_sort); //exit;
//echo "<pre>----------------------------------"; print_r($grid_array); exit;
//}
foreach($players_sort as $player => $tot_score){

	if($players_sort[$temp]['points'] == $tot_score['points'] and $points_count_arr[$tot_score['points']]['count'] == 2){
		//$last_player	 = str_replace('-', '', $temp);
		//$cur_player	 = str_replace('-', '', $player);
		$last_player	 = explode('-', $temp);
		$cur_player	 = explode('-', $player);

		if($grid_array[$cur_player[0]]['opponents'][$last_player[0]]['result'] == 'W'){
			$key_temp   = array_search($temp, $keys_arr);
			$key_player = array_search($player, $keys_arr);
			$keys_arr[$key_temp]   = $player;
			$keys_arr[$key_player] = $temp;
			$temp = $temp;
		}
		else{
		$temp = $player;
		}
	}
	else{
		$temp = $player;
	}

}

				//if($this->logged_user == 240 and ($get_bracket['BracketID'] == 1201 or $get_bracket['BracketID'] == 1195)){
				//	echo "Keys";
				//  echo "<pre> "; print_r($keys_arr);  echo "______";
				//}
foreach($keys_arr as $player){
	$temp_players_sort[$player] = $players_sort[$player];
	$get_players = explode("-", $player);
	$temp_grid_array[$get_players[0]] = $grid_array[$get_players[0]];
}
				if($this->logged_user == 240 and $get_bracket['BracketID'] == 1201){
					//echo "Keys";
				//echo "<pre> "; print_r($grid_array); print_r($keys_arr);  echo "______";
				}
$players_sort = $temp_players_sort;
$grid_array     = $temp_grid_array;


foreach($players_sort as $player => $tot_score){
?>
<tr>
<td align="left">&nbsp;
<?php
		$get_players = explode("-", $player);

		$get_name					= league::get_username($get_players[0]);
		$get_name_partner	= league::get_username($get_players[1]);
		
		if($get_name_partner){
			echo "<b>"."<a href='".$profile_base."player/".$get_name['Users_ID']."' target='_blank'>".$get_name['Firstname'][0]." ".$get_name['Lastname']."</a>";
			echo "; <a href='".$profile_base."player/".$get_name_partner['Users_ID']."' target='_blank'>".$get_name_partner['Firstname'][0].".".$get_name_partner['Lastname']."</a></b>";
		}
		else{
			echo "<b>"."<a href='".$profile_base."player/".$get_name['Users_ID']."' target='_blank'>".$get_name['Firstname']." ".$get_name['Lastname']."</a></b>";
		}
?>
</td>
<?php
	foreach($rr_matches2 as $m2 => $match2){
//echo $match_player." ";
		if($rr_matches2[$m2]->Player1_Partner)
			$pp1 = $rr_matches2[$m2]->Player1."-".$rr_matches2[$m2]->Player1_Partner;
		else
			$pp1 = $rr_matches2[$m2]->Player1;

		if($rr_matches2[$m2]->Player2_Partner)
			$pp2 = $rr_matches2[$m2]->Player2."-".$rr_matches2[$m2]->Player2_Partner;
		else
			$pp2 = $rr_matches2[$m2]->Player2;

		//if(($rr_matches2[$m2]->Player1 == $player or $rr_matches2[$m2]->Player2 == $player) and $i == $rr_matches2[$m2]->Round_Num){
		if($pp1 == $player or $pp2 == $player){

			if($pp1 == $player){ 
				//echo "<td align='center'>".$rr_matches2[$m2]->Player1_points."<br>".$rr_matches2[$m2]->Player1_Score."<br>".$p1_sum."<br>1</td>";
				echo "<td align='center'>".$rr_matches2[$m2]->Player1_points."</td>";
				}
				else if($pp2 == $player){
					//echo "<td align='center'>".$rr_matches2[$m2]->Player2_points."<br>".$rr_matches2[$m2]->Player2_Score."<br>".$p2_sum."<br>2</td>"; 
					echo "<td align='center'>".$rr_matches2[$m2]->Player2_points."</td>"; 
				}

				$player_tot_score += ($p1_sum);
				$p1p2_tot_score	  += ($p1_sum + $p2_sum);

				//echo "<br>tots= ".$player_tot_score;
		}
		else if(!in_array($get_players[0], $m[$rr_matches2[$m2]->Round_Num])){
			echo "<td align='center'>Bye</td>";
			array_push($m[$rr_matches2[$m2]->Round_Num], $get_players[0]);
		}
	}


// -----------------------------------------------------------
$res_ratings = league :: get_draw_init_ratings($get_players[0], $rr_matches2[0]->BracketID, $rr_matches2[0]->Tourn_ID);

	$init			= $res_ratings['init'];
	$final		= $res_ratings['final'];
	$change = $res_ratings['change'];

if($get_players[1]){
$res_ratings2 = league :: get_draw_init_ratings($get_players[1], $rr_matches2[0]->BracketID, $rr_matches2[0]->Tourn_ID);
	if($res_ratings2['init']){
		$init2			= $res_ratings2['init'];
		$final2			= $res_ratings2['final'];
		$change2	= $res_ratings2['change'];
		//echo $init2;
	}

	$init		 = ($init + $init2) / 2;
	$final		 = ($final + $final2) / 2;
	$change = ($change + $change2) / 2;
}

// -----------------------------------------------------------

?>
<td align='center'><?php echo $tot_score['points']; ?></td>
<td align='center'><?php echo $tot_score['win_per2']; ?></td>
<td align='center'><?php echo $init; ?></td>
<td align='center'><?php echo $final; ?></td>
<td align='center'><?php echo number_format($change, 3); ?></td>
</tr>
<?php
}
?>
</table>

</div>
</div>

<!-- End of Player Standing points section -->
<!--  Grid view -->

<div class="col-md-12 league-form-bg" style="margin-top:40px; margin-bottom:20px;">
<div class="accordion"  id="up_match_section"  style="background:#f59123; padding:5px; color:white;">
<i class="fa fa-arrow-circle-o-right" style="color:white;"> </i>Result Grid<span></span></div>
<?php
//uasort($grid_array, array('league','compareOrder3'));    // Disabled this for the grid_array sorted in line #650

$rr_matches2 = $get_rr_tourn_matches->result();
$list_players = array();

foreach($rr_matches2 as $m2 => $match2){
	if(!in_array($rr_matches2[$m2]->Player1, $list_players)) 
		{ $list_players[] = $rr_matches2[$m2]->Player1."-".$rr_matches2[$m2]->Player1_Partner; }

	if(!in_array($rr_matches2[$m2]->Player2, $list_players))
		{ $list_players[] = $rr_matches2[$m2]->Player2."-".$rr_matches2[$m2]->Player2_Partner; }
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
	echo "<td class='score-position' valign='center' align='center'>$details[player_name]$details[partner_name]&nbsp;&nbsp;</td>";
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
?>
<tr>
<td align="center"><?="<b>"."<a href='".$profile_base."player/".$p1."' target='_blank'>".$grid_array[$p1]['player_name']."</a>"."<a href='".$profile_base."player/".$grid_array[$p1]['partner']."' target='_blank'>".$grid_array[$p1]['partner_name']."</a>";?></td>
<td align="center"><?=$k;?></td>
<td align="center"><?=$grid_array[$p1]['won'].'-'.$grid_array[$p1]['lost'];?></td>
<?php
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

<!--  Grid view -->
<link href="<?php echo base_url();?>css/foundation-datepicker.css" rel="stylesheet">
<script src="<?php echo base_url();?>js/foundation-datepicker.js"></script>
<script>
$(document).ready(function() {
	/*$('.update_players').click(function(){
		var this_id = $(this).attr('id');
		var id_split	= this_id.split('_');
		var mid		= id_split[2];
		var tourn_id = "<?php echo $tourn_id; ?>";

		var p1	= $("#p1_"+mid).val();
		var p1p = $("#p1p_"+mid).val();
		var p2	= $("#p2_"+mid).val();
		var p2p = $("#p2p_"+mid).val();
		if((p1 || p1p) && (p2 || p2p)){
			$.ajax({
				type:'POST',
				url:club_baseurl+'league/upd_rr_players/',
				data:{tourn_id:tourn_id, mid:mid, p1:p1, p1p:p1p, p2:p2, p2p:p2p},
				success:function(res){
					alert(res);
				}
			});
		}
		else{
			alert("select the players!");
		}
	});*/
	
	$('.rr_ch_player').change(function(e){
		if($(this).val() != ''){
			if(confirm("All the applicable matches will be updated with this player! \n Are you sure to update the player?")){
				var this_id = $(this).attr('id');
				var new_pl = $(this).val();
				var id_split	= this_id.split('_');
				var pl_pos	= id_split[0];
				var mid		= id_split[1];
				var tourn_id = "<?php echo $tourn_id; ?>";

			$.ajax({
				type:'POST',
				url:club_baseurl+'league/upd_rr_players/',
				data:{tourn_id:tourn_id, mid:mid, new_pl:new_pl, pl_pos:pl_pos},
				success:function(res){
					alert(res);
				}
			});

			}
			else{
				$(this).val('').trigger('change');
			}
		}
	});
});
</script>