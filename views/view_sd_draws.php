<link href="<?php echo base_url();?>css/foundation-datepicker.css" rel="stylesheet">
<script src="<?php echo base_url();?>js/foundation-datepicker.js"></script>

<script>
$(document).ready(function(){

var baseurl = "<?php echo base_url();?>";


$('#update_draw').click(function (e) {
		if(confirm("Are you sure to update the Draw?")){
			  $.ajax({
				type: 'POST',
				url: baseurl+'league/view_matches',
				data: $('#frm_upd_dates').serialize(),
				success: function() {
				  location.reload();
				}
			  });
			  e.preventDefault();
		}
});

	$('#edit_draw_title').click(function() {
			var dtitle = $('#draw_title').val();
			var bid = $(this).attr('class');

		if(bid && dtitle){
			$.ajax({
						type: 'POST',
						url: baseurl+'league/update_draw_title',
						data: {bid:bid,dtitle:dtitle},
						success: function(res) {
							alert(res);
						}
			});
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
<div id='ShowDraw11'></div>

<form method="post" id="frm_upd_dates">
<?php 
$rr_matches = $get_rr_tourn_matches->result();
//$tourn_id = $get_bracket_details['Tourn_ID'];

$players = array();
/*foreach($rr_matches as $m => $match){

	if(!in_array($rr_matches[$m]->Player1, $players)){
		$players[] = $rr_matches[$m]->Player1;
		$players_partners[$rr_matches[$m]->Player1] = $rr_matches[$m]->Player1_Partner;
	}

	if(!in_array($rr_matches[$m]->Player2, $players)){
		$players[] = $rr_matches[$m]->Player2;
		$players_partners[$rr_matches[$m]->Player2] = $rr_matches[$m]->Player2_Partner;
	}
// Commented on 02/12/2022 on Raj request to show all registered players
}*/

$get_reg_players = league :: get_reg_players($get_bracket['Tourn_ID']);

foreach($get_reg_players as $m => $player){
		$players[] = $player->Users_ID;
}

$grid_array = array();
?>
<div class='tab-content' style='background-color:#ffffff'>
<div>
<?php
if($this->logged_user_role == 'Admin' or $this->is_super_admin){
?>
<input class="form-control" type="text" name="draw_title" id="draw_title" style="width:25%;" value="<?php echo $get_bracket['Draw_Title']; ?>" required />

<input type="button" class="<?=$get_bracket['BracketID']; ?>" style="margin-left: 20px; border: 1px solid #e78315;
    background-color: #f59123;    padding: 5px 10px;    font-size: 13px;    text-transform: uppercase;
    color: #fff;    margin-bottom: 13px;" name="edit_draw_title" id="edit_draw_title" value="Update Title" />
<?php
}
else{
?>
<p><b><?php echo $get_bracket['Draw_Title']; ?></b></p>
<? 
}
//--------------------------------------------------------------------------------------------------------------- ?>
<div class="table-responsive">
<table class='tab-score'>
<?php
$round		= 0;
$match_num  = 0;
$game_num   = 1;
//echo count($rr_matches);
foreach($rr_matches as $m => $rrm){   // Main for loop

$p1_won  = 0;
$p2_won  = 0;
$p1_lost = 0;
$p2_lost = 0;
$p1_set_win = 0;
$p2_set_win = 0;
$p1_result  = '-';
$p2_result  = '-';

	if($round != $rr_matches[$m]->Multi_Round_Num)
	{
	$round = $rr_matches[$m]->Multi_Round_Num;
?>
<tr class='top-scrore-table'>
<td align='center'><?php if($round == 0) { ?>S.No. # <?php } ?></td>
<td align='center' colspan='2'>Round <?=$rr_matches[$m]->Multi_Round_Num;?>

<?php
if($tour_details->Usersid == $this->logged_user or $this->is_super_admin){
?>
<input type='hidden' name='round[]' value="<?php echo $round; ?>" />

<input type="text" placeholder="Date" name="round_date<?php echo $round; ?>" id="round_date<?php echo $round; ?>" value="<?php if($rr_matches[$m]->Match_DueDate != ""){ echo date('m/d/Y H:i', strtotime($rr_matches[$m]->Match_DueDate)); } ?>" style="width: 35%;">
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
<?php /*if($tour_details->Tournament_type == 'Flexible League'){ 
echo "<td align='center'>Location</td>";
 } */?>
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
	//if($match_num != $rr_matches[$m]->Round_Num)
	//{
	//$match_num = $rr_matches[$m]->Round_Num;
?>
<!-- <tr style="background:#ffd8ab;">
<td align='center'>&nbsp;</td>
<td align='center' colspan='2'>Match <?//=$match_num;?></td>
<td align='center' colspan='2'>&nbsp;</td>
</tr> -->
<?php
	//}
$player1 = league::get_username(intval($rr_matches[$m]->Player1));
$player2 = league::get_username(intval($rr_matches[$m]->Player2));

$p1_part = "";
$p2_part = "";

	$get_homeloc	= "";
	$loc_icon1		= "";
	$loc_icon2		= "";

	if($rr_matches[$m]->Match_Location_User == $rr_matches[$m]->Player1){
		$get_reg_homeloc = league::get_reg_home_location($rr_matches[$m]->Player1, $get_bracket['Tourn_ID']);
		if($get_reg_homeloc['hcl_id']){
		$get_homeloc = league::get_home_location($get_reg_homeloc['hcl_id']);
		}
		$player1_loc_icon = 'home.png';
		$player2_loc_icon = 'car.png';
	}
	else if($rr_matches[$m]->Match_Location_User == $rr_matches[$m]->Player2){
		$get_reg_homeloc = league::get_reg_home_location($rr_matches[$m]->Player2, $get_bracket['Tourn_ID']);
		if($get_reg_homeloc['hcl_id']){
		$get_homeloc = league::get_home_location($get_reg_homeloc['hcl_id']);
		}
		$player2_loc_icon = 'home.png';
		$player1_loc_icon = 'car.png';
	}

if($rr_matches[$m]->Player1_Partner){
	$player1_partner = league::get_username(intval($rr_matches[$m]->Player1_Partner));
	$p1_part = "; <a href='".$club_url."player/".$player1_partner['Users_ID']."' target='_blank'>$player1_partner[Firstname] $player1_partner[Lastname]</a>";
}

if($rr_matches[$m]->Player2_Partner){
	$player2_partner = league::get_username(intval($rr_matches[$m]->Player2_Partner));
	$p2_part = "; <a href='".$club_url."player/".$player2_partner['Users_ID']."' target='_blank'>$player2_partner[Firstname] $player2_partner[Lastname]</a>";
}

$tm_id = $rr_matches[$m]->Tourn_match_id;



$map_url = "https://www.google.com/maps/place/".$get_homeloc['hcl_address']."+".$get_homeloc['hcl_city']."+".$get_homeloc['hcl_state']."+".$get_homeloc['hcl_country'];

	if($get_homeloc){
	$loc_icon1 = "<a href='".$map_url."' title='".$get_homeloc['hcl_address'].", ".$get_homeloc['hcl_city'].", ".$get_homeloc['hcl_state'].", ".$get_homeloc['hcl_country']."' target='_blank'>"
	."<img src='".base_url()."icons/{$player1_loc_icon}' style='width:24px;height:24px;' />"
	."</a> ";

	$loc_icon2 = "<a href='".$map_url."' title='".$get_homeloc['hcl_address'].", ".$get_homeloc['hcl_city'].", ".$get_homeloc['hcl_state'].", ".$get_homeloc['hcl_country']."' target='_blank'>"
	."<img src='".base_url()."icons/{$player2_loc_icon}' style='width:24px;height:24px;' />"
	."</a> ";
	}

?>
<tr>
<td align='center'>
<?php
echo $game_num."&nbsp;&nbsp;"; 

$match_date = "";
if($rr_matches[$m]->Match_DueDate){

 $split_date = explode(" ",$rr_matches[$m]->Match_DueDate);
 $match_date = ($split_date[1] != "00:00:00.000" and $split_date[1] != "") ?
 date("m/d/Y H:i", strtotime($rr_matches[$m]->Match_DueDate)) : date("m/d/Y", strtotime($rr_matches[$m]->Match_DueDate));
}

if($this->logged_user_role == 'Admin' or $tour_details->Usersid == $this->logged_user){
	?>
<input type="text" placeholder="Date" name="match_date<?php echo $rr_matches[$m]->Tourn_match_id; ?>" id="match_date<?php echo $rr_matches[$m]->Tourn_match_id; ?>" value="<?php echo $match_date; ?>" autocomplete="off">
<input type='hidden' name='matches_id[]' value="<?php echo $rr_matches[$m]->Tourn_match_id; ?>" />
<script>
var gid = "<?php echo $rr_matches[$m]->Tourn_match_id; ?>";

$('#match_date'+gid).fdatepicker({
	format: 'mm/dd/yyyy hh:ii',
	disableDblClickSelection: true,
	language: 'en',
	pickTime: true
});
</script>
<?php
}
else{
echo $match_date;
}
?>
</td>
	<td style="padding-left:15px;"><?php echo "<a href='".$club_url."player/".$player1['Users_ID']."' target='_blank'>".$player1['Firstname']." ".$player1['Lastname']."</a>".$p1_part." ".$loc_icon1; 
	if($rr_matches[$m]->Winner == $rr_matches[$m]->Player1) {
		echo "<img id='img-winner' src='".base_url()."images/gold_medal_small.png' width='20' height='20'></img>";
		$p1_won  = 1;
		$p2_lost = 1;
		$p1_result = 'W';
		$p2_result = 'L';
	}
	
			if($tour_details->Usersid == $this->logged_user or $this->is_super_admin){
				echo "<br>";
				echo "<select style='width:110px; margin-top:15px; margin-bottom:15px;' class='swap_player' id='p1_{$rr_matches[$m]->Player1}' name='p1[{$rr_matches[$m]->Tourn_match_id}]'>";
				echo "<option value=''>Player</option>";
				foreach($players as $p2){
				$selected = ($rr_matches[$m]->Player1 == $p2) ? "selected" : "";
				$get_player = league::get_username(intval($p2));
				echo "<option value='$p2' $selected>".ucfirst(strtolower($get_player['Firstname']))." ".ucfirst(strtolower($get_player['Lastname']))."</option>";
				}
				$selected = ($rr_matches[$m]->Player1 == '0') ? "selected" : "";
				//echo "<option value='0' $selected>Bye</option>";
				echo "</select>";

					$disabled = '';

				echo "&nbsp;<select style='width:110px;' class='swap_player' id='{$rr_matches[$m]->Player1_Partner}' name='p1p[{$rr_matches[$m]->Tourn_match_id}]'>";
				echo "<option value=''>Partner</option>";
				foreach($players as $p1){
				$selected = ($rr_matches[$m]->Player1_Partner == $p1) ? "selected" : "";
				$get_player = league::get_username(intval($p1));

				echo "<option value='$p1' $selected>".ucfirst(strtolower($get_player['Firstname']))." ".ucfirst(strtolower($get_player['Lastname']))."</option>";
				}
				$selected = ($rr_matches[$m]->Player1_Partner == '0') ? "selected" : "";
				//echo "<option value='0' $selected>Bye</option>";
				echo "</select>";
				
			}


	?></td>
	 <td style="padding-left:15px;"><?php echo "<a href='".$club_url."player/".$player2['Users_ID']."' target='_blank'>".$player2['Firstname']." ".$player2['Lastname']."</a>".$p2_part." ".$loc_icon2;

	if($rr_matches[$m]->Winner == $rr_matches[$m]->Player2) {
		echo "<img id='img-winner' src='".base_url()."images/gold_medal_small.png' width='20' height='20'></img>";
		$p2_won  = 1;
		$p1_lost = 1;
		$p1_result = 'L';
		$p2_result = 'W';
	}

	if($tour_details->Usersid == $this->logged_user or $this->is_super_admin){
		echo "<br>";
		echo "<select style='width:110px; margin-top:15px; margin-bottom:15px;' class='swap_player' id='{$rr_matches[$m]->Player2}' name='p2[{$rr_matches[$m]->Tourn_match_id}]'>";
		echo "<option value=''>Player</option>";
		foreach($players as $p2){
		$selected = ($rr_matches[$m]->Player2 == $p2) ? "selected" : "";
		$get_player = league::get_username(intval($p2));
		echo "<option value='$p2' $selected>".ucfirst(strtolower($get_player['Firstname']))." ".ucfirst(strtolower($get_player['Lastname']))."</option>";
		}
		$selected = ($rr_matches[$m]->Player2 == '0') ? "selected" : "";
		//echo "<option value='0' $selected>Bye</option>";
		echo "</select>";

		
			$disabled = '';
		echo "&nbsp;<select style='width:110px;' class='swap_player' id='{$rr_matches[$m]->Player2_Partner}' name='p2p[{$rr_matches[$m]->Tourn_match_id}]' {$disabled}>";
		echo "<option value=''>Partner</option>";
		foreach($players as $p1){
		$selected = ($rr_matches[$m]->Player2_Partner == $p1) ? "selected" : "";
		$get_player = league::get_username(intval($p1));

		echo "<option value='$p1' $selected>".ucfirst(strtolower($get_player['Firstname']))." ".ucfirst(strtolower($get_player['Lastname']))."</option>";
		}
		$selected = ($rr_matches[$m]->Player2_Partner == '0') ? "selected" : "";
		//echo "<option value='0' $selected>Bye</option>";
		echo "</select>";
		
	}


	 ?></td>
	
	<?php //if($tour_details->Tournament_type == 'Flexible League'){ ?>
	 <!-- <td style="padding-left:15px;">
	 <?php //if($rr_matches[$m]->Match_Location) { $loc_id = $rr_matches[$m]->Match_Location; }
		//$get_loc = league::get_home_location($loc_id);

		//$map_url = "https://www.google.co.in/maps/place/".$get_loc['hcl_address']."+".$get_loc['hcl_city']."+".$get_loc['hcl_state']."+".
		//$get_loc['hcl_country'];

		//echo "<a href='".$map_url."' title='".$get_loc['hcl_address'].", ".$get_loc['hcl_city'].", ".$get_loc['hcl_state'].", //".$get_loc['hcl_country']."' target='_blank'>".$get_loc['hcl_title']."</a><br>"; ?>
	 </td> -->
	 <?php //} ?>

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
				for($i=0; $i<count(array_filter($p1)); $i++){
					echo "($p1[$i] - $p2[$i]) ";
						if($p1[$i] > $p2[$i]){ $p1_set_win++; } 
						else { $p2_set_win++; }
				}
			 }
	    	 else{
				for($i=0; $i<count(array_filter($p1)); $i++){
					echo "($p2[$i] - $p1[$i]) ";
						if($p1[$i] > $p2[$i]){ $p1_set_win++; } 
						else { $p2_set_win++; }
				}
			 }
		}
		else if($cnt2 > 0){
			 if($rr_matches[$m]->Player1 == $rr_matches[$m]->Winner){
				for($i=0; $i<count(array_filter($p2)); $i++){
					echo "($p1[$i] - $p2[$i]) ";
						if($p1[$i] > $p2[$i]){ $p1_set_win++; } 
						else { $p2_set_win++; }
				}
			 }
	    	 else{
				for($i=0; $i<count(array_filter($p2)); $i++){
					echo "($p2[$i] - $p1[$i]) ";
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
	 </td>
	 
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

	if(count($get_match_comments) > 0){
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
$game_num++;

/*echo $p1_set_win." - <br>";
echo $p2_set_win." -- <br>";
echo $p1_result." -- <br>";
echo $p2_result." -- <br>";
*/

$grid_array[$rr_matches[$m]->Multi_Round_Num][$rr_matches[$m]->Player1]['opponents'][$rr_matches[$m]->Player2]['sets']   = $p1_set_win.'-'.$p2_set_win;
$grid_array[$rr_matches[$m]->Multi_Round_Num][$rr_matches[$m]->Player1]['opponents'][$rr_matches[$m]->Player2]['result'] = $p1_result;
$grid_array[$rr_matches[$m]->Multi_Round_Num][$rr_matches[$m]->Player1]['player_name'] = $player1['Firstname']." ".$player1['Lastname'];
$grid_array[$rr_matches[$m]->Multi_Round_Num][$rr_matches[$m]->Player1]['won']  += $p1_won;
$grid_array[$rr_matches[$m]->Multi_Round_Num][$rr_matches[$m]->Player1]['lost'] += $p1_lost;

$grid_array[$rr_matches[$m]->Multi_Round_Num][$rr_matches[$m]->Player2]['opponents'][$rr_matches[$m]->Player1]['sets']   = $p2_set_win.'-'.$p1_set_win;
$grid_array[$rr_matches[$m]->Multi_Round_Num][$rr_matches[$m]->Player2]['opponents'][$rr_matches[$m]->Player1]['result'] = $p2_result;
$grid_array[$rr_matches[$m]->Multi_Round_Num][$rr_matches[$m]->Player2]['player_name'] = $player2['Firstname']." ".$player2['Lastname'];
$grid_array[$rr_matches[$m]->Multi_Round_Num][$rr_matches[$m]->Player2]['won']  += $p2_won;
$grid_array[$rr_matches[$m]->Multi_Round_Num][$rr_matches[$m]->Player2]['lost'] += $p2_lost;

//echo "<pre>";
//print_r($grid_array);
} // End of Main For loop

//echo "<pre>";
//print_r($grid_array);
?>
</table>



<!-- ----------------------------------------------------------------------------------------------- -->
<br />
<table>
<tr><td>
<input type="hidden" name="update_draw_status" id="update_draw_status" value="4" />
<input type='hidden' name='bracket_id' value="<?php echo $get_bracket['BracketID']; ?>" />
<input type='hidden' name='tour_id'	value="<?php echo $get_bracket['Tourn_ID']; ?>" />
<?php
if($this->logged_user_role == 'Admin' or $tour_details->Usersid == $this->logged_user or $this->is_super_admin){
?>
<div class='col-md-1 form-group internal'>
<input type="button" id='update_draw' name='update_sd_dates' class='league-form-submit1' value=" Update " />
</div>
<?php
}
?>
</td></tr>
</table>
</div>
</form>



<!-- Player standing points section start -->

<div class="col-md-12 league-form-bg" style="margin-top:40px; margin-bottom:20px;">
<div class="accordion"  id="up_match_section"  style="background:#f59123; padding:5px; color:white;"><i class="fa fa-arrow-circle-o-right" style="color:white;"> </i>Draw Standings<span></span></div>
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
$arr[] = $rr_matches2[$m2]->Player1_Partner;
$arr[] = $rr_matches2[$m2]->Player2;
$arr[] = $rr_matches2[$m2]->Player2_Partner;

if($temp == $get_bracket['No_of_rounds'] and ($m2+1) == count($rr_matches2)){
	$m[$temp]	= $arr;
	$temp			= $rr_matches2[$m2]->Round_Num;
	$arr				= array();
}
	//echo $rr_matches2[$m2]->Player1."-".$rr_matches2[$m2]->Player1_Partner." ";
	if(!in_array($rr_matches2[$m2]->Player1, $list_players))
	{	$list_players[] = $rr_matches2[$m2]->Player1; }

	if(!in_array($rr_matches2[$m2]->Player2, $list_players))
	{	$list_players[] = $rr_matches2[$m2]->Player2; }

	if(!in_array($rr_matches2[$m2]->Player1_Partner, $list_players))
	{	$list_players[] = $rr_matches2[$m2]->Player1_Partner; }

	if(!in_array($rr_matches2[$m2]->Player2_Partner, $list_players))
	{	$list_players[] = $rr_matches2[$m2]->Player2_Partner; }
}

//if($this->logged_user == 240){
//echo "<pre>";
//print_r($m);
//print_r($rr_matches2);
//print_r($list_players);
//exit;
//}
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
<td class="score-position" valign="center" align="center">Score<br>For&nbsp;&nbsp;</td>
<td class="score-position" valign="center" align="center">Score<br>Against&nbsp;&nbsp;</td>
<td class="score-position" valign="center" align="center">Score<br>Diff.&nbsp;&nbsp;</td>
<td class="score-position" valign="center" align="center">Win%&nbsp;&nbsp;</td>
<td class="score-position" valign="center" align="center">Init Rating&nbsp;&nbsp;</td>
<td class="score-position" valign="center" align="center">Final Rating&nbsp;&nbsp;</td>
<td class="score-position" valign="center" align="center">Change&nbsp;&nbsp;</td>

</tr>
<?php
//echo "<pre>"; print_r($list_players); exit;

foreach($list_players as $ind => $player){
	$tot_p					= 0;
	$player_tot_score	= 0;
	$p1p2_tot_score	= 0;

	foreach($rr_matches2 as $m2 => $match2){
		
			$match_player1			= $rr_matches2[$m2]->Player1;
			$match_player1part	= $rr_matches2[$m2]->Player1_Partner;

			$match_player2			= $rr_matches2[$m2]->Player2;
			$match_player2part	= $rr_matches2[$m2]->Player2_Partner;

		//if($rr_matches2[$m2]->Player1 == $player or $rr_matches2[$m2]->Player2 == $player){
		if($match_player1 == $player or $match_player2 == $player or $match_player1part == $player or $match_player2part == $player){

		$p1_sum	= 0;
		$p2_sum = 0;
		$p1		= array();
		$p2		= array();

				if($match_player1 == $player or $match_player1part == $player) { 
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
			
						if($cnt2 > 0) {
							for($i=0; $i<count(array_filter($p2)); $i++) {
								$p2_sum = intval($p2_sum) + intval($p2[$i]);
							}
						}
					 /*  Win percentage calculation end */	
				}
				$player_tot_score	+= ($p1_sum);
				$p1p2_tot_score	+= ($p1_sum+$p2_sum);
		}
	}
$win_per = ($player_tot_score / $p1p2_tot_score) * 100;

//$players_sort[$player] = array('points' => $tot_p, 'win_per' => number_format($win_per, 2));
$players_sort[$player] = array('points' => $tot_p, 'win_per' => $player_tot_score, 'win_per2' => number_format($win_per, 2));
}

$sort_func = uasort($players_sort, array('league','compareOrder'));
$keys_arr = array_keys($players_sort); 

//echo "<pre>";
//print_r($keys_arr);
//if($this->logged_user == 240){
//echo "<pre>"; print_r($players_sort); //exit;
//echo "<pre>----------------------------------"; print_r($grid_array); //exit;
//}

foreach($players_sort as $player => $tot_score){
	
	if($players_sort[$temp]['points'] == $tot_score['points'])
	{
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

//$last_player	 = str_replace('-','',end(array_keys($players_sort)));
//$cur_player		 = str_replace('-','',$player);

	/*if($last_player_arr['points'] == $tot_p and ($grid_array[$last_player]['opponents'][$cur_player]['result'] == 'L')){
			unset($players_sort[$last_player]);
			$players_sort[$player]		= array('points' => $tot_p, 'win_per' => number_format($win_per, 2));
			$players_sort[$last_player] = $last_player_arr;
			echo "<pre>";
			print_r($players_sort);
	}
	else{
		$players_sort[$player] = array('points' => $tot_p, 'win_per' => number_format($win_per, 2));
	}*/
	
}

//if($this->logged_user == 240){
//echo "<pre>"; print_r($players_sort);
//}
foreach($keys_arr as $player){
	$temp_players_sort[$player] = $players_sort[$player];
	$get_players = explode("-", $player);
	$temp_grid_array[$get_players[0]] = $grid_array[$get_players[0]];
}

$players_sort  = $temp_players_sort;
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
			echo "<b>"."<a href='".$club_url."player/".$get_name['Users_ID']."' target='_blank'>".$get_name['Firstname'][0]." ".$get_name['Lastname']."</a>";
			echo "; <a href='".$club_url."player/".$get_name_partner['Users_ID']."' target='_blank'>".$get_name_partner['Firstname'][0].".".$get_name_partner['Lastname']."</a></b>";
		}
		else{
			echo "<b>"."<a href='".$club_url."player/".$get_name['Users_ID']."' target='_blank'>".$get_name['Firstname']." ".$get_name['Lastname']."</a></b>";
		}
?>
</td>
<?php
$points_for = 0;
$points_against = 0;
	foreach($rr_matches2 as $m2 => $match2){
//echo $match_player." ";

			$pp1		= $rr_matches2[$m2]->Player1;
			$pp1pr = $rr_matches2[$m2]->Player1_Partner;

			$pp2		= $rr_matches2[$m2]->Player2;
			$pp2pr	= $rr_matches2[$m2]->Player2_Partner;

		//if(($rr_matches2[$m2]->Player1 == $player or $rr_matches2[$m2]->Player2 == $player) and $i == $rr_matches2[$m2]->Round_Num){
		if($pp1 == $player or $pp2 == $player or $pp1pr == $player or $pp2pr == $player){

			if($pp1 == $player or $pp1pr == $player){ 
				//echo "<td align='center'>".$rr_matches2[$m2]->Player1_points."<br>".$rr_matches2[$m2]->Player1_Score."<br>".$p1_sum."<br>1</td>";
				echo "<td align='center'>".$rr_matches2[$m2]->Player1_points."</td>";
				$for_score			=  $rr_matches2[$m2]->Player1_Score;
				$against_score  =  $rr_matches2[$m2]->Player2_Score;
				}
				else if($pp2 == $player or $pp2pr == $player){
					//echo "<td align='center'>".$rr_matches2[$m2]->Player2_points."<br>".$rr_matches2[$m2]->Player2_Score."<br>".$p2_sum."<br>2</td>"; 
					echo "<td align='center'>".$rr_matches2[$m2]->Player2_points."</td>"; 
				$for_score			=  $rr_matches2[$m2]->Player2_Score;
				$against_score  =  $rr_matches2[$m2]->Player1_Score;
				}

					if($for_score){
						$for = json_decode($for_score, true);
						$tot = 0;
						foreach($for as $sc)
							$tot += $sc;
						$points_for += $tot;
					}

					if($against_score){
						$against = json_decode($against_score, true);
						$tot = 0;
						foreach($against as $sc)
							$tot += $sc;
						$points_against += $tot;
					}

				$player_tot_score += ($p1_sum);
				$p1p2_tot_score	  += ($p1_sum + $p2_sum);

				//echo "<br>tots= ".$player_tot_score;
		}
		else if(!in_array($get_players[0], $m[$rr_matches2[$m2]->Round_Num])){
			//echo "<td align='center'>Bye</td>";
			echo "<td align='center'></td>";
			array_push($m[$rr_matches2[$m2]->Round_Num], $get_players[0]);
		}
	}


// -----------------------------------------------------------
$res_ratings = league :: get_draw_init_ratings($get_players[0], $rr_matches2[0]->BracketID, $rr_matches2[0]->Tourn_ID);

	$init		  = $res_ratings['init'];
	$final		  = $res_ratings['final'];
	$change  = $res_ratings['change'];

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
<td align='center'><?php echo $points_for; ?></td>
<td align='center'><?php echo $points_against; ?></td>
<td align='center'><?php echo ($points_for - $points_against); ?></td>
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