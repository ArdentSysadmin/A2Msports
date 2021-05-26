<script src="<?php echo base_url();?>js/jquery.accordion.js" type="text/javascript"></script>
<script src="https://code.jquery.com/jquery-1.9.1.js"></script>

<script type="text/javascript">
	$(document).ready(function () {
	$(function () {
	"use strict";
	$('.accordion').accordion({ defaultOpen: 'up_match_section' }); //some_id section1 in demoup_tour_section
	});
	});
</script>

<script>
$(document).ready(function(){
var baseurl = "<?php echo base_url();?>";

$(".add_score").click(function(){
var pid = $(this).attr('name');

if($("#score"+pid).css('display')=='none'){
$("#score"+pid).show();
$("#forfeit"+pid).hide();
$("#comment"+pid).hide();
}
else{
$("#forfeit"+pid).hide();
$("#score"+pid).hide();
$("#comment"+pid).hide();
}
});

$('.wff_score').click(function() {
var pid2 = $(this).attr('name');

if($("#forfeit"+pid2).css('display')=='none'){
$("#forfeit"+pid2).show();
$("#score"+pid2).hide();
$("#comment"+pid).hide();
}
else{
$("#forfeit"+pid2).hide();
$("#score"+pid2).hide();
$("#comment"+pid).hide();
}

});

/*$('.hide_score').on('click',function(){

	if($("#score").css('display')!='none'){
	$("#score").hide();
	//$("#forfeit"+pid).hide();
	}
});*/

});
</script>

<script>
$(document).ready(function(){

var baseurl = "<?php echo base_url();?>";

$('.wff_add').click(function (e) {

var id_val = $(this).attr('id');

//alert(id_val);
	  $.ajax({
		type: 'POST',
		url: baseurl+'league/view_matches',
		data: $('#form-wff'+id_val).serialize(),
		success: function(res) {
		   //location.reload();
		  alert('Result added successfully');
		   $('#tr_'+id_val).html(res);
		   //$('#forfeit'+id_val).style('display','none');
  		   $('#forfeit'+id_val).hide();
		}
	  });
	  e.preventDefault();

	});
});
</script>
<script>
$(document).ready(function(){

var baseurl = "<?php echo base_url();?>";

$('.add_score_ajax').click(function (e) {

var id_val = $(this).attr('id');

	  $.ajax({
		type: 'POST',
		url: baseurl+'league/view_matches',
		data: $('#form-addscore'+id_val).serialize(),
		success: function (res) {
		   //location.reload();
		   alert('Scores were added successfully');
		   $('#tr_'+id_val).html(res);
		   //$('#score'+id_val).style('display','none');
  		   $('#score'+id_val).hide();
		}
	  });
	  e.preventDefault();

	});
});
</script>

<script>
$(document).ready(function(){
var baseurl = "<?php echo base_url();?>";

$('.rr_edit_score_ajax').click(function (e) {

var id_val = $(this).attr('id');

	  $.ajax({
		type: 'POST',
		url: baseurl+'league/view_matches',
		data: $('#form-rr-editscore'+id_val).serialize(),
		success: function (res) {
		   //location.reload();
		   alert('Score were updated successfully');
		   $('#tr_'+id_val).html(res);
		   //$('#rr_escore'+id_val).style('display','none');
  		   $('#rr_escore'+id_val).hide();
		}
	  });
	  e.preventDefault();

	});
});
</script>

<script>
$(document).ready(function(){
var baseurl = "<?php echo base_url();?>";

$('.rr_edit_score').on('click',function(){

var tab_row_id = $(this).attr('name');

if($("#rr_escore"+tab_row_id).css('display')=='none'){
$("#rr_escore"+tab_row_id).show();
}
else{
$("#rr_escore"+tab_row_id).hide();
}

if(tab_row_id!=""){
$.ajax({
type:'POST',
url:baseurl+'league/get_tour_row_info/',
data:{ row_id:tab_row_id},
success:function(html){

 var res = html.split('#');
	res[0] = $.trim(res[0]);
	$('#tourn_match_id').val(res[0]);
	$('#bracket_id').val(res[1]);

	$('#tournid').val(res[2]);
	$('#match_num').val(res[4]);

	$('#player1_user').val(res[5]);
	$('#player2_user').val(res[6]);

	if(res[12] || res[13]){
		var p1= res[10]+"; "+res[12];
		var p2= res[10]+"; "+res[13];
		$('#player1_name').html(p1);
		$('#player2_name').html(p2);
	}else{
		$('#player1_name').html(res[10]);
		$('#player2_name').html(res[11]);
	}
	var p1_score = "";
	var p2_score = "";
	if(res[14] != "" && res[14] != "Bye Match" && res[14] != 'NULL')
	{
		var x = res[14].slice(1, -1);
		var y = res[15].slice(1, -1);

		var p1_score = x.split(',');
		var p2_score = y.split(',');
		
		for($i=0; $i<p1_score.length; $i++){
			$('#set1_'+($i+1)+'_'+res[0]).val(p1_score[$i]);
			//$('#mset1_'+($i+1)+'_'+res[0]).val(p1_score[$i]);
		}

		for($j=0; $j<p2_score.length; $j++){
			$('#set2_'+($j+1)+'_'+res[0]).val(p2_score[$j]);
			//$('#mset2_'+($j+1)+'_'+res[0]).val(p2_score[$j]);
		}
	}
	
	if(res[16]){
	var dateArr = res[16].split('-');
	$('#edate'+res[0]).val(dateArr[1]+"/"+dateArr[2]+"/"+dateArr[0]);
	}
}
}); 
}

});

});
</script>

<?php
//echo $this->logged_user;
//exit;
$tourn_id = $get_bracket_details['Tourn_ID'];
$rr_matches = $rr_bracket_matches->result();
$sess_id = $this->session->userdata('users_id');

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
?>

<div class='tab-content' style="background:#fff">

<div class="top-score-title right-score">
<p><b><?php echo $get_bracket_details['Draw_Title']; ?></b></p>
<div class="table-responsive">
<? //--------------------------------------------------------------------------------------------------------------- ?>

<table class='tab-score'>
<?php
$round =0;
$match_num = 1;
//if(!in_array($sess_id, $players) and $tour_details->Usersid != $sess_id)
//echo $this->is_super_admin;
if(!in_array($this->logged_user, $players) and !in_array($this->logged_user, $players_partners) and $this->logged_user != $tourn_det->Usersid and !$this->is_super_admin)
{
?>
<tr></td><span style="color:red">No Matches found, as you are not a player in this draw!</span></td></tr>
<?php
}
else 
{
foreach($rr_matches as $m=>$rrm){   // Main for loop

/*if(($sess_id != $rr_matches[$m]->Player1 and 
	$sess_id != $rr_matches[$m]->Player1_Partner and 
	$sess_id != $rr_matches[$m]->Player2 and 
	$sess_id != $rr_matches[$m]->Player2_Partner and 
	$tour_details->Usersid != $sess_id))
{

echo "<tr><td>Bye Match</td></tr>";

}*/
//else
//{
	if($round != $rr_matches[$m]->Round_Num)
	{
	$round = $rr_matches[$m]->Round_Num;
?>

<tr class='top-scrore-table'>
<!-- <td>Match #</td> -->
<td align='center'>#</td>
<td align='center' colspan='2'>Match <?=$rr_matches[$m]->Round_Num;?></td>

<?php if($tour_details->Tournament_type == 'Flexible League'){ 
echo "<td align='center'>Location</td>";
 } ?>

<td><?php 
if($rr_matches[$m]->Match_DueDate){
 $split_date = explode(" ",$rr_matches[$m]->Match_DueDate);
 $date1 = ($split_date[1] != "00:00:00.000" and $split_date[1] != "") ?
 date("m/d/Y h:i A", strtotime($rr_matches[$m]->Match_DueDate)) : date("m/d/Y", strtotime($rr_matches[$m]->Match_DueDate));

 echo "Play by: ".$date1; 
}
?></td>
<!-- <td>&nbsp;</td> -->
</tr>
<!-- <tr align='center'>
<?php //if($match_type == "Doubles"){ ?>

<td><b>Team1</b></td>
<td><b>Team2</b></td>
<?php //} else //{ ?>
<td><b>Player1</b></td>
<td><b>Player2</b></td>
<?php //} ?>
<td>&nbsp;</td>
</tr> -->

<?php
	$logged_user_matches_count = 0;
	$round_matches = 0;
}
else{
$round_matches++;
}

$player1 = league::get_username(intval($rr_matches[$m]->Player1));
$player2 = league::get_username(intval($rr_matches[$m]->Player2));

$p1_part = "";
$p2_part = "";
$player1_partner = '';
$player2_partner = '';
if($rr_matches[$m]->Player1_Partner){
	$player1_partner = league::get_username(intval($rr_matches[$m]->Player1_Partner));
	$p1_part = "; <a title=".$player1_partner['Mobilephone']." href=tel:".$player1_partner['Mobilephone'].">".ucfirst($player1_partner[Firstname])." ".ucfirst($player1_partner[Lastname])."</a>";
}

if($rr_matches[$m]->Player2_Partner)
	{
	$player2_partner = league::get_username(intval($rr_matches[$m]->Player2_Partner));
	//$p2_part = "; $player2_partner[Firstname] $player2_partner[Lastname]";
	$p2_part = "; <a title=".$player2_partner['Mobilephone']." href=tel:".$player2_partner['Mobilephone'].">".ucfirst($player2_partner[Firstname])." ".ucfirst($player2_partner[Lastname])."</a>";
}

$tm_id = $rr_matches[$m]->Tourn_match_id;
?>



	<?php 
	if($sess_id == $rr_matches[$m]->Player1 or $sess_id == $rr_matches[$m]->Player1_Partner or $sess_id == $rr_matches[$m]->Player2 or $sess_id == $rr_matches[$m]->Player2_Partner or $tour_details->Usersid == $sess_id or $this->is_super_admin){ ?>

	<tr id='tr_<?=$tm_id;?>'>
	<td align='center'><?=$rr_matches[$m]->Match_Num;?></td>

	<td style="padding-left:15px;"><a href="tel:<?php echo $player1['Mobilephone'];?> " title="<?php echo $player1['Mobilephone'];?>"><?php echo ucfirst($player1['Firstname'])." ".ucfirst($player1['Lastname'])."</a>" . $p1_part; 
	if($rr_matches[$m]->Winner == $rr_matches[$m]->Player1) {
		echo "<img id='img-winner' src='".base_url()."images/gold_medal_small.png' width='20' height='20'></img>";
	}
	?></td>
	
	 <td style="padding-left:15px;"><a href="tel: <?php echo $player2['Mobilephone'];?>" title="<?php echo $player2['Mobilephone'];?>"><?php echo ucfirst($player2['Firstname'])." ".ucfirst($player2['Lastname'])."</a>".$p2_part;
	if($rr_matches[$m]->Winner == $rr_matches[$m]->Player2) {
		echo "<img id='img-winner' src='".base_url()."images/gold_medal_small.png' width='20' height='20'></img>";
	}
	?></td>

<?php if($tour_details->Tournament_type == 'Flexible League'){ ?>
<td style="padding-left:15px;"><?php 
	 if($rr_matches[$m]->Match_Location_User) { $loc_user_id = $rr_matches[$m]->Match_Location_User; } 
		$get_loc_id = league::get_user_home_location($tourn_id, $loc_user_id);
		$get_loc	= league::get_home_location($get_loc_id['hcl_id']);

		$map_url = "https://www.google.co.in/maps/place/".$get_loc['hcl_address']."+".$get_loc['hcl_city']."+".$get_loc['hcl_state']."+".
		$get_loc['hcl_country'];

		echo "<a href='".$map_url."' title='".$get_loc['hcl_address'].", ".$get_loc['hcl_city'].", ".$get_loc['hcl_state'].", ".$get_loc['hcl_country']."' target='_blank'>".$get_loc['hcl_title']."</a><br>";?>
</td>
<?php } 

if($rr_matches[$m]->Winner == ""){?>

	 <td style="padding-left:15px;">
	 <a id='add' class='add_score' href='#reg_matches' name='<?php echo $tm_id; ?>'>Add Score </a><!-- / 
	 <a id="wff_add" class="wff_score" href="#reg_matches" name="<?php echo $tm_id; ?>">Win by Forfeit</a> -->
	 </td>
	 <?php } else { ?>
	 <td style="padding-left:15px;">
		<?php
		if($rr_matches[$m]->Player1_Score !=""){
		$p1=array();$p2=array();
		$p1 = json_decode($rr_matches[$m]->Player1_Score);
		$p2 = json_decode($rr_matches[$m]->Player2_Score);

		$cnt = count(array_filter($p1));
		$cnt2 = count(array_filter($p2));
		if($cnt > 0){
				for($i=0; $i<count($p1); $i++){
					echo "($p1[$i] - $p2[$i]) ";
				}
			}
			else if($cnt2 > 0){	
				for($i=0; $i<count($p2); $i++){
					echo "($p1[$i] - $p2[$i]) ";
				}
			
		}
		else if($cnt == 0 and $rr_matches[$m]->Player1_Score != "Bye Match" and $rr_matches[$m]->Player2_Score != "Bye Match"){
					echo "Win by Forfeit ";
			}

		}
		if($tour_details->Usersid == $sess_id or $this->is_super_admin){
		?>
			<?php echo "\t"; ?><img src='<?php echo base_url()."images/ico-images/Edit.png"; ?>' id='img-winner' class='rr_edit_score img-winner' 
			href='#edit_score' name='<?php echo $tm_id; ?>' width='30px' height='30px' style='cursor:pointer' />
		<?php }
		?>
	 </td>
	 <?php 
		} ?>
	
	<?php 
	$logged_user_matches_count++;
	}
	echo "</tr>";
	if($logged_user_matches_count == 0 and $round_matches != 0){ ?>
	<!-- <tr id='tr_<?//=$tm_id;?>'>
	<td align='center'><?//=$rr_matches[$m]->Match_Num;?></td>
	<td colspan='3' align='center'>---- Got a Bye ----</td>
	</tr> -->
	<?php 
	}
	?>


<?php
/*
$this->load->view('view_rr_addscore_blocks',$data);   // view file for win forfiet and addscore sections

$this->load->view('view_rr_editscore_blocks');   // view file for win forfiet and addscore sections
*/
?>


<!------------Win By forfeit-------------------->
<tr id="forfeit<?php echo $rr_matches[$m]->Tourn_match_id; ?>" style="display:none;">
<td colspan='6'>
<!-- <form method="post" name="form-wff" action="<?php echo base_url();?>league/view_matches"> -->
 <form name="form-wff" id="form-wff<?php echo $rr_matches[$m]->Tourn_match_id; ?>">
 <div class='form-group'>
	<div class='col-md-3 form-group internal'>

		<?php
		$get_name = league::get_username($rr_matches[$m]->Player1); 
		$player1_name = $get_name['Firstname'] . "  " . $get_name['Lastname'];
		?>
		<?php 
		$get_name = league::get_username($rr_matches[$m]->Player2);
		 $player2_name =  $get_name['Firstname'] . "  " . $get_name['Lastname'];
		?>

		<select name="id" class='form-control'>

		<option value="<?php echo $rr_matches[$m]->Player1; ?>">
		<?php echo $player1_name;

			if($player1_partner){ echo "; ".$player1_partner['Firstname']." ".$player1_partner['Lastname']; }
		?></option>

		<option value="<?php echo $rr_matches[$m]->Player2; ?>">
		<?php 
		echo $player2_name;

			 if($player2_partner){ echo "; ".$player2_partner['Firstname']." ".$player2_partner['Lastname']; }
		?>	
	    </option>
		</select> 
	</div>
</div>

</div>

	  <input class='form-control' value="WFF" name="score_type" type='hidden'> 
	  <input class='form-control' value="<?php echo $rr_matches[$m]->Tourn_ID;?>" id="tourn_id" name="tourn_id" type='hidden'> 
	  <input class='form-control' value="<?php echo $rr_matches[$m]->BracketID;?>" id="bracket_id" name="bracket_id" type='hidden'>
	  <input class='form-control' value="<?php echo $rr_matches[$m]->Match_Num;?>" id="match_num" name="match_num" type='hidden'> 
	  <input class='form-control' value="<?php echo $match_type;?>" id="match_type" name="match_type" type='hidden'> 
	<input class='form-control' value="<?php echo $rr_matches[$m]->Tourn_match_id;?>" id="tourn_match_id" name="tourn_match_id" type='hidden'>
	<input class='form-control' value="<?php echo $rd_type;?>" id="round_title" name="round_title" type='hidden'>
	<input class='form-control' value="" id="" name="draw_name" type='hidden'>

	<input class='form-control' value="<?php echo $rr_matches[$m]->Player1;?>" id="tourn_match_id" name="player1" type='hidden'>
	<input class='form-control' value="<?php echo $rr_matches[$m]->Player1_Partner;?>" id="tourn_match_id" name="player1_partner" type='hidden'>
	<input class='form-control' value="<?php echo $rr_matches[$m]->Player2;?>" id="tourn_match_id" name="player2" type='hidden'>
	<input class='form-control' value="<?php echo $rr_matches[$m]->Player2_Partner;?>" id="tourn_match_id" name="player2_partner" type='hidden'>

<div class='form-group'>
	<div class='col-md-1 form-group internal'>
	 <input type="submit" name="rr_add_winner" id="<?php echo $rr_matches[$m]->Tourn_match_id; ?>" value="Add Winner" class="wff_add league-form-submit1"/>
	</div>
</div>

</form>
</td>
</tr>

<!----------End of--Win By forfeit-------------------->

<tr id="score<?php echo $rr_matches[$m]->Tourn_match_id; ?>" class="tourn_match" style="display:none;">
<td colspan='6'>
<div>

<!-- <form method="post" name="form-addscore" action="<?php echo base_url();?>league/view_matches"> -->


<form name="form-addscore" id="form-addscore<?php echo $rr_matches[$m]->Tourn_match_id; ?>">

<div class='form-group'>
	<div class='col-md-2 form-group internal'>
<input type="text" class='form-control' placeholder="Date" id="sdate<?php echo $rr_matches[$m]->Tourn_match_id; ?>" 
name="tour_match_date" value="<?php echo date('m/d/Y');  ?>" required />
	</div>
<script>
$(function() {
	var spid = "<?php echo $rr_matches[$m]->Tourn_match_id; ?>";
 $('#sdate'+spid).datepick();
});
</script>

	<div class='form-group'>
	<div class='col-md-8 form-group internal scoretable-web'>

	<input type='checkbox' name="<?php echo $rr_matches[$m]->Tourn_match_id; ?>" id='wff_add' class='wff_score' />&nbsp;Declare winner by Win by Forfeit
	
		<?php
		$get_name = league::get_username($rr_matches[$m]->Player1); 
		$player1_name = $get_name['Firstname'] . "  " . $get_name['Lastname'];
		?>
		<?php
		$get_name = league::get_username($rr_matches[$m]->Player2);
		 $player2_name =  $get_name['Firstname'] . "  " . $get_name['Lastname'];
		?>
		<?php
		$get_sport = league::getonerow($tourn_id);
		$sport_id = $get_sport->SportsType;
		?>
		<table class="score-cont">
		  <?php if($sport_id == 1){ ?>
		  <tr>
			<th>Players</th>
			<th>Set1</th>
			<th>Set2</th>
			<th>Set3</th>
			<th>Set4</th>
			<th>Set5</th>
			<!-- <th>Set6</th> -->
		 </tr> 
		 <?php } else { ?>
		 <tr>
			<th>Players</th>
			<th>Game1</th>
			<th>Game2</th>
			<th>Game3</th>
			<th>Game4</th>
			<th>Game5</th>
			<!-- <th>Game6</th> -->
		 </tr> 
		  <?php } ?>

		 <tr>
			<td bgcolor="#fdd7b0"><b><?php echo $player1_name; 
			 if($player1_partner){ echo "; ".$player1_partner['Firstname']." ".$player1_partner['Lastname']; }
			 ?></b></td>
			<td><input id='set1_1' name='player1[]' style = "width:65%" type='text' maxlength='2' /></td>
			<td><input id='set1_1' name='player1[]' style = "width:65%" type='text' maxlength='2' /></td>
			<td><input id='set1_1' name='player1[]' style = "width:65%" type='text' maxlength='2' /></td>
			<td><input id='set1_1' name='player1[]' style = "width:65%" type='text' maxlength='2' /></td>
			<td><input id='set1_1' name='player1[]' style = "width:65%" type='text' maxlength='2' /></td>
			<!-- <td><input id='set1_1' name='player1[]' style = "width:65%" type='text' maxlength='2' /></td> -->

		 </tr>
		  <tr>
			<td bgcolor="#fdd7b0"><b><?php echo $player2_name; 
			 if($player2_partner){ echo "; ".$player2_partner['Firstname']." ".$player2_partner['Lastname']; }
			?></b></td>
			<td><input id='set1_2' name='player2[]' style = "width:65%" type='text' maxlength='2' /></td>
			<td><input id='set1_2' name='player2[]' style = "width:65%" type='text' maxlength='2' /></td>
			<td><input id='set1_2' name='player2[]' style = "width:65%" type='text' maxlength='2' /></td>
			<td><input id='set1_2' name='player2[]' style = "width:65%" type='text' maxlength='2' /></td>
			<td><input id='set1_2' name='player2[]' style = "width:65%" type='text' maxlength='2' /></td>
			<!-- <td><input id='set1_2' name='player2[]' style = "width:65%" type='text' maxlength='2' /></td> -->
			
			 </tr>
		 </table> 
	
		</div>
		</div>

		 <!-- ---------------Mobile view------------------------------------------------------- -->
					<div class="scoretable-mob">
					<input type='checkbox' name="<?php echo $rr_matches[$m]->Tourn_match_id; ?>" id='wff_add' class='wff_score' />&nbsp;
					Declare winner by Win by Forfeit

						<table class="score-cont">
								<tr>
									<th>Players</th>
									<th bgcolor="#fdd7b0"><b><?php echo $player1_name;  if($player1_partner){ echo "; ".$player1_partner['Firstname']." ".$player1_partner['Lastname']; } ?></b></th>
									<th bgcolor="#fdd7b0"><b><?php echo $player2_name; if($player2_partner){ echo "; ".$player2_partner['Firstname']." ".$player2_partner['Lastname']; }?></b></th>
									<?php 
										if($sport_id == 1){
										$set_or_game = 'Set';
										}
										else
										{
										$set_or_game = 'Game';
										}
									?>
					           </tr>
					  <tr>
						<td>
							<?php echo $set_or_game . "1"; ?>
						</td>
						<td><input id='set1_1' name='player1[]' style = "width:45%" type='text' maxlength='2' /></td>
						<td><input id='set1_2' name='player2[]' style = "width:45%" type='text' maxlength='2' /></td>
						</tr>
						<tr>
						<td>
							<?php echo $set_or_game . "2"; ?>
						</td>
						<td><input id='set2_1' name='player1[]' style = "width:45%" type='text' maxlength='2' /></td>
						<td><input id='set2_2' name='player2[]' style = "width:45%" type='text' maxlength='2' /></td>
						</tr>
						<tr>
						<td>
							<?php echo $set_or_game . "3"; ?>
						</td>
						<td><input id='set3_1' name='player1[]' style = "width:45%" type='text' maxlength='2' /></td>
						<td><input id='set3_2' name='player2[]' style = "width:45%" type='text' maxlength='2' /></td>
						</tr>
						<tr>
						<td>
							<?php echo $set_or_game . "4"; ?>
						</td>
						<td><input id='set4_1' name='player1[]' style = "width:45%" type='text' maxlength='2' /></td>
						<td><input id='set4_2' name='player2[]' style = "width:45%" type='text' maxlength='2' /></td>
						</tr>
						<tr>
						<td>
							<?php echo $set_or_game . "5"; ?>
						</td>
						<td><input id='set5_1' name='player1[]' style = "width:45%" type='text' maxlength='2' /></td>
						<td><input id='set5_2' name='player2[]' style = "width:45%" type='text' maxlength='2' /></td>
						</tr>

			     </table>
		      </div>
				<!-- ---------------Mobile view------------------------------------------------------- -->




	 <input class='form-control' value="ADDSCORE" name="score_type" type='hidden'> 
	 <input class='form-control' value="<?php echo $rr_matches[$m]->Player1;?>" id="player1_user" name="player1_user" type='hidden'>
	 <input class='form-control' value="<?php echo $rr_matches[$m]->Player1_Partner;?>" id="player1_user_partner" name="player1_user_partner" type='hidden'>

	 <input class='form-control' value="<?php echo $rr_matches[$m]->Player2; ?>" id="player2_user" name="player2_user" type='hidden'>
	 <input class='form-control' value="<?php echo $rr_matches[$m]->Player2_Partner; ?>" id="player2_user_partner" name="player2_user_partner" type='hidden'>

	 <input class='form-control' value="<?php echo $rr_matches[$m]->Tourn_ID;?>" id="tourn_id" name="tourn_id" type='hidden'>
	 <input class='form-control' value="<?php echo $rr_matches[$m]->BracketID;?>" id="bracket_id" name="bracket_id" type='hidden'>
	 <input class='form-control' value="<?php echo $rr_matches[$m]->Match_Num;?>" id="match_num" name="match_num" type='hidden'>
	 <input class='form-control' value="<?php echo $match_type;?>" id="match_type" name="match_type" type='hidden'>
	 <input class='form-control' value="<?php echo $rr_matches[$m]->Tourn_match_id;?>" id="tourn_match_id" name="tourn_match_id" type='hidden'>
	 <input class='form-control' value="<?php echo $round;?>" id="round_title" name="round_title" type='hidden'>
	 <input class='form-control' value="" id="" name="draw_name" type='hidden'>

	<div class='form-group'>
	<div class='col-md-1 form-group internal'>
	 <input name="add_rr_match_score" id="<?php echo $rr_matches[$m]->Tourn_match_id;?>" type="submit" value="Add" class="add_score_ajax league-form-submit"/>
	</div>
	</div>

</form>
</div>
</td>
</tr>

<!-- -------------------------Edit score block ------------------------- -->
<tr id="rr_escore<?php echo $rr_matches[$m]->Tourn_match_id; ?>" class="tourn_match" style="display:none;">
<td colspan='6'>
<div>
<form name="form-rr-editscore" id="form-rr-editscore<?php echo $rr_matches[$m]->Tourn_match_id; ?>">
<div class='form-group'>
	<div class='col-md-2 form-group internal'>
	<input type="text" class='form-control' placeholder="Date" id="edate<?php echo $rr_matches[$m]->Tourn_match_id; ?>" name="tour_match_date" /> 
	</div>
	<script>
	$(function() {
		var spid = "<?php echo $rr_matches[$m]->Tourn_match_id; ?>";
	 $('#edate'+spid).datepick();
	});
	</script>

	<div class='form-group'>
	<div class='col-md-8 form-group internal scoretable-web'>
		
		<?php
		$get_name = league::get_username($rr_matches[$m]->Player1); 
		$player1_name = $get_name['Firstname'] . " " . $get_name['Lastname'];
		?>
		<?php
		$get_name = league::get_username($rr_matches[$m]->Player2);
		 $player2_name =  $get_name['Firstname'] . " " . $get_name['Lastname'];
		?>
		<?php
		$get_sport = league::getonerow($tourn_id);
		$sport_id = $get_sport->SportsType;
		?>
		<table class="score-cont">
					 <?php if($sport_id == 1){ ?>
					 <tr>
						<th>Players</th><th>Set1</th><th>Set2</th><th>Set3</th><th>Set4</th><th>Set5</th><!-- <th>Set6</th> -->
					 </tr> 
					 <?php } else { ?>
					 <tr>
						<th>Players</th><th>Game1</th><th>Game2</th><th>Game3</th><th>Game4</th><th>Game5</th><!-- <th>Game6</th> -->
					 </tr> 
					 <?php } ?>						  

					 <tr>
						<td bgcolor="#fdd7b0"><b><?php echo $player1_name; 
						 if($player1_partner){ echo "; ".$player1_partner['Firstname']." ".$player1_partner['Lastname']; }
						 ?></b></td>
						<td><input id='set1_1_<?php echo $rr_matches[$m]->Tourn_match_id; ?>' name='player1[]' style = "width:65%" type='text' maxlength='2' /></td>
						<td><input id='set1_2_<?php echo $rr_matches[$m]->Tourn_match_id; ?>' name='player1[]' style = "width:65%" type='text' maxlength='2' /></td>
						<td><input id='set1_3_<?php echo $rr_matches[$m]->Tourn_match_id; ?>' name='player1[]' style = "width:65%" type='text' maxlength='2' /></td>
						<td><input id='set1_4_<?php echo $rr_matches[$m]->Tourn_match_id; ?>' name='player1[]' style = "width:65%" type='text' maxlength='2' /></td>
						<td><input id='set1_5_<?php echo $rr_matches[$m]->Tourn_match_id; ?>' name='player1[]' style = "width:65%" type='text' maxlength='2' /></td>
						<!-- <td><input id='set1_6_<?php //echo $rr_matches[$m]->Tourn_match_id; ?>' name='player1[]' style = "width:65%" type='text' maxlength='2' /></td> -->

					 </tr>
					  <tr>
						<td bgcolor="#fdd7b0"><b><?php echo $player2_name; 
						 if($player2_partner){ echo "; ".$player2_partner['Firstname']." ".$player2_partner['Lastname']; }
						?></b></td>
						<td><input id='set2_1_<?php echo $rr_matches[$m]->Tourn_match_id; ?>' name='player2[]' style = "width:65%" type='text' maxlength='2' /></td>
						<td><input id='set2_2_<?php echo $rr_matches[$m]->Tourn_match_id; ?>' name='player2[]' style = "width:65%" type='text' maxlength='2' /></td>
						<td><input id='set2_3_<?php echo $rr_matches[$m]->Tourn_match_id; ?>' name='player2[]' style = "width:65%" type='text' maxlength='2' /></td>
						<td><input id='set2_4_<?php echo $rr_matches[$m]->Tourn_match_id; ?>' name='player2[]' style = "width:65%" type='text' maxlength='2' /></td>
						<td><input id='set2_5_<?php echo $rr_matches[$m]->Tourn_match_id; ?>' name='player2[]' style = "width:65%" type='text' maxlength='2' /></td>
						<!-- <td><input id='set2_6_<?php //echo $rr_matches[$m]->Tourn_match_id; ?>' name='player2[]' style = "width:65%" type='text' maxlength='2' /></td> -->
						
					 </tr>
			  </table> 
			
			</div>
			</div>


			 <!-- ---------------Mobile view------------------------------------------------------- -->
					<div class="scoretable-mob">
					<input type='checkbox' name="<?php echo $rr_matches[$m]->Tourn_match_id; ?>" id='wff_add' class='wff_score' />&nbsp;
					Declare winner by Win by Forfeit

						<table class="score-cont">
								<tr>
									<th>Players</th>
									<th bgcolor="#fdd7b0"><b><?php echo $player1_name;  if($player1_partner){ echo "; ".$player1_partner['Firstname']." ".$player1_partner['Lastname']; } ?></b></th>
									<th bgcolor="#fdd7b0"><b><?php echo $player2_name; if($player2_partner){ echo "; ".$player2_partner['Firstname']." ".$player2_partner['Lastname']; }?></b></th>
									<?php if($sport_id == 1){
											$set_or_game = 'Set';
										   }
										  else
										  {
											  $set_or_game = 'Game';
										  }

										  $tm_id = $rr_matches[$m]->Tourn_match_id;
									?>
					           </tr>
					    <tr>
						<td>
							<?php echo $set_or_game . "1"; ?>
						</td>
						<td><input id='mset1_1_<?php echo $tm_id; ?>' name='player1[]' style = "width:45%" type='text' maxlength='2' /></td>
						<td><input id='mset2_1_<?php echo $tm_id; ?>' name='player2[]' style = "width:45%" type='text' maxlength='2' /></td>
					   </tr>

						<tr>
						<td>
							<?php echo $set_or_game . "2"; ?>
						</td>
						<td><input id='mset1_2_<?php echo $tm_id; ?>' name='player1[]' style = "width:45%" type='text' maxlength='2' /></td>
						<td><input id='mset2_2_<?php echo $tm_id; ?>' name='player2[]' style = "width:45%" type='text' maxlength='2' /></td>
						</tr>
						<tr>
						<td>
							<?php echo $set_or_game . "3"; ?>
						</td>
						<td><input id='mset1_3_<?php echo $tm_id; ?>' name='player1[]' style = "width:45%" type='text' maxlength='2' /></td>
						<td><input id='mset2_3_<?php echo $tm_id; ?>' name='player2[]' style = "width:45%" type='text' maxlength='2' /></td>
						</tr>
						<tr>
						<td>
							<?php echo $set_or_game . "4"; ?>
						</td>
						<td><input id='mset1_4_<?php echo $tm_id; ?>' name='player1[]' style = "width:45%" type='text' maxlength='2' /></td>
						<td><input id='mset2_4_<?php echo $tm_id; ?>' name='player2[]' style = "width:45%" type='text' maxlength='2' /></td>
						</tr>
						<tr>
						<td>
							<?php echo $set_or_game . "5"; ?>
						</td>
						<td><input id='mset1_5_<?php echo $tm_id; ?>' name='player1[]' style = "width:45%" type='text' maxlength='2' /></td>
						<td><input id='mset2_5_<?php echo $tm_id; ?>' name='player2[]' style = "width:45%" type='text' maxlength='2' /></td>
						</tr>

			     </table>
		      </div>
				<!-- ---------------Mobile view------------------------------------------------------- -->

	
	 <input class='form-control' value="RR_EDITSCORE" name="score_type" type='hidden'> 
	 <input class='form-control' value="<?php echo $rr_matches[$m]->Player1;?>" id="player1_user" name="player1_user" type='hidden'>

	 <input class='form-control' value="<?php echo $rr_matches[$m]->Player1_Partner;?>" id="player1_user_partner" 
	 name="player1_user_partner" type='hidden'>

	 <input class='form-control' value="<?php echo $rr_matches[$m]->Player2; ?>" id="player2_user" name="player2_user" type='hidden'>

	 <input class='form-control' value="<?php echo $rr_matches[$m]->Player2_Partner; ?>" id="player2_user_partner" 
	 name="player2_user_partner" type='hidden'>


	 <input class='form-control' value="<?php echo $rr_matches[$m]->Tourn_ID;?>" id="tourn_id" name="tourn_id" type='hidden'> 
	 <input class='form-control' value="<?php echo $rr_matches[$m]->BracketID;?>" id="bracket_id" name="bracket_id" type='hidden'>
	 <input class='form-control' value="<?php echo $rr_matches[$m]->Match_Num;?>" id="match_num" name="match_num" type='hidden'>
	 <input class='form-control' value="<?php echo $match_type;?>" id="match_type" name="match_type" type='hidden'>
	 <input class='form-control' value="<?php echo $rr_matches[$m]->Tourn_match_id;?>" id="tourn_match_id" name="tourn_match_id" type='hidden'>

	 <input class='form-control' value="<?php echo $round;?>" id="round_title" name="round_title" type='hidden'>
	 <input class='form-control' value="" id="" name="draw_name" type='hidden'>


	<div class='form-group'>
	<div class='col-md-1 form-group internal'>
	<input name="upd_match_score" id="<?php echo $rr_matches[$m]->Tourn_match_id;?>" type="submit" value="Update" class="rr_edit_score_ajax league-form-submit"/>
	</div>
	</div>

</form>
</div>
</td>
</tr>
<!-- -------------------------End of edit score block ------------------------- -->



<?php
$match_num++;
} // End of Main For loop
//}
?>
</table>

</div>

<!-- Player standing points section start -->

<div class="col-md-12 league-form-bg" style="margin-top:40px; margin-bottom:20px;">
<div class="accordion"  id="up_match_section"  style="background:#f59123; padding:5px; color:white;"><i class="fa fa-arrow-circle-o-right" style="color:white;"> </i>Player Standings<span></span></div>
<?php
$rr_matches2 = $rr_bracket_matches->result();
$list_players = array();

foreach($rr_matches2 as $m2 => $match2){

if(!in_array($rr_matches2[$m2]->Player1."-".$rr_matches2[$m2]->Player1_Partner, $list_players))
	{	$list_players[] = $rr_matches2[$m2]->Player1."-".$rr_matches2[$m2]->Player1_Partner; }

if(!in_array($rr_matches2[$m2]->Player2."-".$rr_matches2[$m2]->Player2_Partner, $list_players))
	{	$list_players[] = $rr_matches2[$m2]->Player2."-".$rr_matches2[$m2]->Player2_Partner; }
}

//$num_matches = count($list_players) - 1;
$players_count = count($list_players);
$num_matches = ($players_count % 2 == 0) ? $players_count-1 : $players_count;
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
?>

<?php
//arsort($players_sort);
$sort_func = uasort($players_sort, array('league','compareOrder'));

foreach($players_sort as $player => $tot_score){
?>
<tr>
<td align="left">&nbsp;
<?php
		$get_players = explode("-", $player);

		$get_name = league::get_username($get_players[0]);
		$get_name_partner = league::get_username($get_players[1]);
		echo "<b>".ucfirst($get_name['Firstname'])." ".ucfirst($get_name['Lastname']);
		
		if($get_name_partner){
			echo "; ".ucfirst($get_name_partner['Firstname'])." ".ucfirst($get_name_partner['Lastname']);
		}
		echo "</b>";
?>
</td>
	<?php
	$player_tot_score = 0;
	$p1p2_tot_score = 0;

	foreach($rr_matches2 as $m2 => $match2){

		if($rr_matches2[$m2]->Player1_Partner)
			$pp1 = $rr_matches2[$m2]->Player1."-".$rr_matches2[$m2]->Player1_Partner;
		else
			$pp1 = $rr_matches2[$m2]->Player1;

		if($rr_matches2[$m2]->Player2_Partner)
			$pp2 = $rr_matches2[$m2]->Player2."-".$rr_matches2[$m2]->Player2_Partner;
		else
			$pp2 = $rr_matches2[$m2]->Player2;

		if($pp1 == $player or $pp2 == $player){

			if($pp1 == $player){ 
				echo "<td align='center'>".$rr_matches2[$m2]->Player1_points."</td>";
			}
			else if($pp2 == $player){
				echo "<td align='center'>".$rr_matches2[$m2]->Player2_points."</td>"; 
			}

				$player_tot_score	+= ($p1_sum);
				$p1p2_tot_score		+= ($p1_sum+$p2_sum);
		}
	}
?>
<td align='center'><?php echo $tot_score['points']; ?></td>
<td align='center' style='font-weight:400'>
<?php echo $tot_score['win_per']; ?></td>
</tr>
<?php
}
}
?>
</table>
</div>
<br />
<br />

<?
// -------------------------------------------------------------------------------------------------------------- ?>
</div>
</div>

<!-- End of Player Standing points section -->