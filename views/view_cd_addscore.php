<script type="text/javascript">
$(document).ready(function () {
$(function () {
"use strict";
$('.accordion').accordion({ defaultOpen: 'section' }); //some_id section1 in demoup_tour_section
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
$("#comment"+pid2).hide();
}
else{
$("#forfeit"+pid2).hide();
$("#score"+pid2).hide();
$("#comment"+pid2).hide();
}

});

//$('.edit_score').on('click',function(){
$(document).on('click', '.edit_score', function(){

var tab_row_id = $(this).attr('name');

	if($("#escore"+tab_row_id).css('display')=='none'){
	$("#escore"+tab_row_id).show();
	//$("#forfeit"+pid).hide();
	}
	else{
	$("#escore"+tab_row_id).hide();
	$("#forfeit"+tab_row_id).hide();
	tab_row_id = '';
	}


//alert (tab_row_id);

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
	}
	else{
		$('#player1_name').html(res[10]);
		$('#player2_name').html(res[11]);
	}
	var p1_score = "";
	var p2_score = "";
	if(res[14] != "" && res[14] != "Bye Match" && res[14] != 'NULL'){
		var x = res[14].slice(1, -1);
		var y = res[15].slice(1, -1);
		var p1_score = x.split(',');
		var p2_score = y.split(',');

		for($i=0; $i<p1_score.length; $i++){
			$('#set1_'+($i+1)+'_'+res[0]).val(p1_score[$i]);
			$('#mset1_'+($i+1)+'_'+res[0]).val(p1_score[$i]);
		}

		for($j=0; $j<p2_score.length; $j++){
			$('#set2_'+($j+1)+'_'+res[0]).val(p2_score[$j]);
			$('#mset2_'+($j+1)+'_'+res[0]).val(p2_score[$j]);
		}
	}
	
	if(res[16]){
	var dateArr = res[16].split('-');

	//var edate = $.format.date(new Date(res[16]), 'mm/dd/yyyy');
	$('#edate'+res[0]).val(dateArr[1]+"/"+dateArr[2]+"/"+dateArr[0]);
	}
}
}); 
}

});


//$('.cd_edit_score').on('click',function(){
$(document).on('click', '.cd_edit_score', function(){

var tab_row_id = $(this).attr('name');

	if($("#cd_escore"+tab_row_id).css('display')=='none'){
	$("#cd_escore"+tab_row_id).show();
	//$("#forfeit"+pid).hide();
	}
	else{
	$("#cd_escore"+tab_row_id).hide();
	$("#forfeit"+tab_row_id).hide();
	tab_row_id = '';
	}

if(tab_row_id!=""){
$.ajax({
type:'POST',
url:baseurl+'league/get_tour_row_info/',
data:{ row_id:tab_row_id},
success:function(html){

 var res = html.split('#');
	$('#cd_escore'+tab_row_id).show();
	$('#cd_tourn_match_id').val(res[0]);
	$('#cd_bracket_id').val(res[1]);

	$('#cd_tournid').val(res[2]);
	$('#cd_match_num').val(res[4]);

	$('#cd_player1_user').val(res[5]);
	$('#cd_player2_user').val(res[6]);

	if(res[12] || res[13]){
		var p1= res[10]+"; "+res[12];
		var p2= res[10]+"; "+res[13];
		$('#cd_player1_name').html(p1);
		$('#cd_player2_name').html(p2);
	}else{
		$('#cd_player1_name').html(res[10]);
		$('#cd_player2_name').html(res[11]);
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
			$('#cd_set1_'+($i+1)+'_'+res[0]).val(p1_score[$i]);
			$('#mcd_set1_'+($i+1)+'_'+res[0]).val(p1_score[$i]);
		}

		for($j=0; $j<p2_score.length; $j++){
			$('#cd_set2_'+($j+1)+'_'+res[0]).val(p2_score[$j]);
			$('#mcd_set2_'+($j+1)+'_'+res[0]).val(p2_score[$j]);
		}
	}
	
	var dateArr = res[16].split('-');


	//var edate = $.format.date(new Date(res[16]), 'mm/dd/yyyy');
		$('#cd_edate'+res[0]).val(dateArr[1]+"/"+dateArr[2]+"/"+dateArr[0]);

	//$('#cd_edate'+res[0]).val(dateArr[2]+"/"+dateArr[1]+"/"+dateArr[0]);
}
}); 
}

});

/*
$('.hide_score').on('click',function(){

	if($("#score").css('display')!='none'){
	$("#score").hide();
	//$("#forfeit"+pid).hide();
	}
});
*/
});
</script>


<!-- ------------------------Add Score without page redirect-------------------------- -->

<script>
$(document).ready(function(){

var baseurl = "<?php echo base_url();?>";

$('.wff_add').click(function (e) {

var id_val = $(this).attr('id');

	  $.ajax({
		type: 'POST',
		url: baseurl+'league/view_matches',
		data: $('#form-wff'+id_val).serialize(),
		success: function (res) {
		   //location.reload();
		   alert('Result added successfully');
		   $('#tr_'+id_val).html(res);
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

$('.add_score_ajax').on('click',function (e) {

var id_val = $(this).attr('id');

	  $.ajax({
		type: 'POST',
		url: baseurl+'league/view_matches',
		data: $('#form-addscore'+id_val).serialize(),
		success: function (res) {
			//location.reload();
			alert('Scores are added successfully');
			$('#tr_'+id_val).html(res);
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

$('.cd_wff_add').click(function (e) {

var id_val = $(this).attr('id');

	  $.ajax({
		type: 'POST',
		url: baseurl+'league/view_matches',
		data: $('#cd_form-wff'+id_val).serialize(),
		success: function () {
		   //location.reload();
		  alert('Result added successfully, it will reflect only after page refresh');

		}
	  });
	  e.preventDefault();

	});
});
</script>

<script>
$(document).ready(function(){

var baseurl = "<?php echo base_url();?>";

$('.cd_add_score_ajax').click(function (e) {

var id_val = $(this).attr('id');

	  $.ajax({
		type: 'POST',
		url: baseurl+'league/view_matches',
		data: $('#cd_form-addscore'+id_val).serialize(),
		success: function (res) {
		   //location.reload();
		   alert('Scores are added successfully, it will reflect only after page refresh');
		   $('#score'+id_val).hide();
		   $('#ctr_'+id_val).html(res);
		}
	  });
	  e.preventDefault();

	});
});
</script>


<script>
$(document).ready(function(){

var baseurl = "<?php echo base_url();?>";

$('.edit_score_ajax').on('click', function (e) {

var id_val = $(this).attr('id');

	  $.ajax({
		type: 'POST',
		url: baseurl+'league/view_matches',
		data: $('#form-editscore'+id_val).serialize(),
		success: function(res) {
		   //location.reload();
		   alert("Scores are updated successfully!");
			$('#escore'+id_val).hide();
			$('#tr_'+id_val).html(res);
		}
	  });
	  e.preventDefault();

	});

	$('.cd_edit_score_ajax').on('click', function (e) {

var id_val = $(this).attr('id');

	  $.ajax({
		type: 'POST',
		url: baseurl+'league/view_matches',
		data: $('#form-cd-editscore'+id_val).serialize(),
		success: function(res) {
			//alert(res);
		   //location.reload();
		   alert("Scores are updated successfully!");
			$('#cd_escore'+id_val).hide();
			$('#ctr_'+id_val).html(res);
		}
	  });
	  e.preventDefault();

	});

});
</script>

<!-- -------------------------------------------------------------------------------- -->

<?php
$round_matches = $bracket_matches_main->result();
$total_rounds =	$get_bracket_details['No_of_rounds'];
$tourn_id = $get_bracket_details['Tourn_ID'];
$sess_id = $this->session->userdata('users_id');
/*echo "<pre>";
print_r($bracket_matches_cd->result());
exit;*/
?>
<div>
<h4 style="color:#f59123"><b><?php echo $get_bracket_details['Draw_Title']; ?></b></h4>
</div>

<div class="tab-content">
<?php
if(!empty($round_matches)){

$nm = 0;
$round_type = array();
for($round = 1; $round <= $total_rounds; $round++) {
	foreach($round_matches as $m => $match){
		if($round_matches[$m]->Round_Num==$round){
			$nm++;
		}
	}
	$round_type[$round] = $nm;
	$nm = 0;
}
if($round_matches[0]->Round_Num == -1){
	$round_type[-1] = -1;
}

//for($round = 1; $round <= $total_rounds; $round++) {
foreach($round_type as $round => $round_val){

$rt = $round_type[$round];

if($rt >= pow(2,3)){
	$rrt = $rt*2;

	$rd_type = "Round of $rrt";

	//echo "<b>$rd_type</b>";
}
else{
	switch($rt){
		case 1:
			$rd_type = "Final";
			break;
		case 2:
			$rd_type = "Semi-Final";
			break;
		case 4:
			$rd_type = "Quarter-Final";
			break;
		case -1:
			$rd_type = "3rd Place Match";
			break;
		default:
			$rd_type = "---";
			break;
	}
	//echo "<b>$rd_type</b>";

}

	echo "<div class='accordion' id='section' style='background:#f59123; padding:5px; color:white;'><i class='fa fa-arrow-circle-o-right' style='color:white;'> </i><b>$rd_type</b><span></span></div>";

//echo "<b>Round:" . $round . "</b>";
?>
<table class="tab-score">

<tr class="top-scrore-table">
<?php if($match_type == "Doubles"){ ?>
<td class="score-position" valign="center" align="center">Team1</td>
<td class="score-position" valign="center" align="center">Team2</td>
<?php } else { ?>
<td class="score-position" valign="center" align="center">Player1</td>
<td class="score-position" valign="center" align="center">Player2</td>
<?php } ?>
<td class="score-position" valign="center" align="center">Score</td>
<!-- <td class="score-position" valign="center" align="center">Winner</td> -->
<!-- <td class="score-position" valign="center" align="center">Action</td> -->
</tr>

<?php
foreach($round_matches as $m => $match){
$player1 = "";
$player2 = "";

	if($round_matches[$m]->Round_Num==$round){

	if($round_matches[$m]->Player1 != 0){
		 $player1 = league::get_username(intval($round_matches[$m]->Player1));
		 $partner1 = league::get_username(intval($round_matches[$m]->Player1_Partner));
	}
	if($round_matches[$m]->Player2 != 0){
		 $player2 = league::get_username(intval($round_matches[$m]->Player2));
		 $partner2 = league::get_username(intval($round_matches[$m]->Player2_Partner));
	}
?>

<tr id="tr_<?=$round_matches[$m]->Tourn_match_id?>">

<?php 
$get = league::getonerow($round_matches[$m]->Tourn_ID);
$tourn_admin = $get->Usersid;

	if($sess_id == $round_matches[$m]->Player1 or $sess_id == $round_matches[$m]->Player1_Partner or $sess_id == $round_matches[$m]->Player2 or $sess_id == $round_matches[$m]->Player2_Partner or $tourn_admin == $sess_id or $this->is_super_admin){ ?>


<td valign="center" style="padding-left:15px;"><b>
<?php if($player1){
	echo "<a href='".base_url()."player/".$player1['Users_ID']."'>".$player1['Firstname']." ".$player1['Lastname']."</a>"; 
	if($partner1){ echo "; <a href='".base_url()."player/".$partner1['Users_ID']."'>".$partner1['Firstname']." ".$partner1['Lastname']."</a>"; }
	} else { echo "----"; }
	if($round_matches[$m]->Winner == $round_matches[$m]->Player1 and $round_matches[$m]->Winner != '') {
		echo "<img id='img-winner' src='".base_url()."images/gold_medal_small.png' width='20' height='20'></img>";
	}
?>
</b></td>
<td valign="center" style="padding-left:15px;"><b>
<?php if($player2){ 
		echo "<a href='".base_url()."player/".$player2['Users_ID']."'>".$player2['Firstname']." ".$player2['Lastname']."</a>"; 
	if($partner2){ echo "; <a href='".base_url()."player/".$partner2['Users_ID']."'>".$partner2['Firstname']." ".$partner2['Lastname']."</a>"; }
		} else { echo "----"; }
		if($round_matches[$m]->Winner == $round_matches[$m]->Player2 and $round_matches[$m]->Winner != '') {
		echo "<img id='img-winner' src='".base_url()."images/gold_medal_small.png' width='20' height='20'></img>";
	    }
?>
</b></td>

<?php

 if($round_matches[$m]->Winner == '') {
?>
		<td valign="center" style="padding-left:15px;">
		<div>
		<a id="add" class="add_score" href="#reg_matches" name="<?php echo $round_matches[$m]->Tourn_match_id; ?>">Add score</a> 
		</div>
		</td>
<?php 
} else { ?>
		<td valign="center" style="padding-left:15px;">
	<?php 
		if($round_matches[$m]->Player1_Score !=""){
		$p1=array();$p2=array();
		$p1 = json_decode($round_matches[$m]->Player1_Score);
		$p2 = json_decode($round_matches[$m]->Player2_Score);

		$cnt = count(array_filter($p1));
		$cnt2 = count(array_filter($p2));

			if($cnt > 0){
					for($i=0; $i<count(array_filter($p1)); $i++)
					{
						echo "($p1[$i] - $p2[$i]) ";
					}
			}
			else if($cnt2 > 0)
			{	
					for($i=0; $i<count(array_filter($p2)); $i++)
					{
						echo "($p1[$i] - $p2[$i]) ";
					}
				
			}
			else if($cnt == 0 and $round_matches[$m]->Player1_Score != "Bye Match" and $round_matches[$m]->Player2_Score != "Bye Match"){
						echo "Win by Forfeit ";
			}

		}

		if(($tourn_admin == $sess_id) and ($round_matches[$m]->Player1_Score != "Bye Match" or $round_matches[$m]->Player2_Score != "Bye Match")){
		?>

		<?php echo "\t"; ?><img src='<?php echo base_url()."images/ico-images/Edit.png"; ?>' id='img-winner' class='edit_score img-winner' href='#edit_score' name='<?php echo $round_matches[$m]->Tourn_match_id; ?>' width='30px' height='30px' style='cursor:pointer' />
			

		<?php } else if($round_matches[$m]->Player1_Score == "Bye Match" or $round_matches[$m]->Player2_Score == "Bye Match"){
		
			echo "Bye Match";
		}
		?>
  
		</td>
	   <?php } ?>

	<?php } ?>

</tr>


<!------------Win By forfeit-------------------->
<tr id="forfeit<?php echo $round_matches[$m]->Tourn_match_id; ?>" style="display:none;">
<td colspan='6'>
<!-- <form method="post"  action="<?php echo base_url();?>league/view_matches"> -->
<form name="form-wff" id="form-wff<?php echo $round_matches[$m]->Tourn_match_id; ?>">

<div class='form-group'>
	<div class='col-md-3 form-group internal'>

		<?php
		$get_name = league::get_username($round_matches[$m]->Player1); 
		$player1_name = $get_name['Firstname'] . " " . $get_name['Lastname'];
		?>
		<?php 
		$get_name = league::get_username($round_matches[$m]->Player2);
		 $player2_name =  $get_name['Firstname'] . " " . $get_name['Lastname'];
		?>

		<select name="id" class='form-control'>

		<option value="<?php echo $round_matches[$m]->Player1; ?>">
		<?php echo $player1_name;

			if($partner1){ echo "; ".$partner1['Firstname']." ".$partner1['Lastname']; }
		?></option>

		<option value="<?php echo $round_matches[$m]->Player2; ?>">
		<?php 
		echo $player2_name;

			 if($partner2){ echo "; ".$partner2['Firstname']." ".$partner2['Lastname']; }
		?>	
	    </option>
		</select> 
	</div>
</div>

	  <input class='form-control' value="CD_WFF" name="score_type" type='hidden'> 
	  <input class='form-control' value="<?php echo $round_matches[$m]->Tourn_ID;?>" id="tourn_id" name="tourn_id" type='hidden'> 
	  <input class='form-control' value="<?php echo $round_matches[$m]->BracketID;?>" id="bracket_id" name="bracket_id" type='hidden'>
	  <input class='form-control' value="<?php echo $round_matches[$m]->Match_Num;?>" id="match_num" name="match_num" type='hidden'> 
	  <input class='form-control' value="<?php echo $match_type;?>" id="match_type" name="match_type" type='hidden'> 
	<input class='form-control' value="<?php echo $round_matches[$m]->Tourn_match_id;?>" id="tourn_match_id" name="tourn_match_id" type='hidden'>

	<input class='form-control' value="<?php echo $round_matches[$m]->Player1;?>" id="tourn_match_id" name="player1" type='hidden'>
	<input class='form-control' value="<?php echo $round_matches[$m]->Player1_Partner;?>" id="tourn_match_id" name="player1_partner" type='hidden'>
	<input class='form-control' value="<?php echo $round_matches[$m]->Player2;?>" id="tourn_match_id" name="player2" type='hidden'>
	<input class='form-control' value="<?php echo $round_matches[$m]->Player2_Partner;?>" id="tourn_match_id" name="player2_partner" type='hidden'>

	<input class='form-control' value="<?php echo $rd_type;?>" id="round_title" name="round_title" type='hidden'>
	<input class='form-control' value="<?php echo $round_matches[$m]->Round_Num;?>" id="round_num" name="round_num" type='hidden'>
	<input class='form-control' value="" id="" name="draw_name" type='hidden'>


<div class='form-group'>
	<div class='col-md-1 form-group internal'>
	 <input type="submit" name="se_add_winner" id="<?php echo $round_matches[$m]->Tourn_match_id; ?>" value="Add Winner" class="wff_add league-form-submit1"/>
	</div>
</div>

</form>
</td>
</tr>
 
<!----------End of--Win By forfeit-------------------->

<!-- -------------------------Add score block ------------------------- -->
<tr id="score<?php echo $round_matches[$m]->Tourn_match_id; ?>" class="tourn_match" style="display:none;">
<td colspan='6'>
<div>

<!-- <form method="post" action="<?php echo base_url();?>league/view_matches"> -->
<form name="form-addscore" id="form-addscore<?php echo $round_matches[$m]->Tourn_match_id; ?>">

<div class='form-group'>
<div class='col-md-2 form-group internal'>
<input type="text" class='form-control' placeholder="Date" id="sdate<?php echo $round_matches[$m]->Tourn_match_id; ?>" name="tour_match_date" value="<?php echo date("m/d/Y"); ?>" /> 
</div>
<script>
$(function() {
	var spid = "<?php echo $round_matches[$m]->Tourn_match_id; ?>";
 $('#sdate'+spid).datepick();
});
</script>

	<div class='form-group'>
	<div class='col-md-8 form-group internal scoretable-web'>
	
<input type='checkbox' name="<?php echo $round_matches[$m]->Tourn_match_id; ?>" id='wff_add' class='wff_score' />&nbsp;Declare winner by Win by Forfeit

		<?php
		$get_name = league::get_username($round_matches[$m]->Player1); 
		$player1_name = $get_name['Firstname'] . " " . $get_name['Lastname'];
		?>
		<?php
		$get_name = league::get_username($round_matches[$m]->Player2);
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
					 if($partner1){ echo "; ".$partner1['Firstname']." ".$partner1['Lastname']; }
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
					 if($partner2){ echo "; ".$partner2['Firstname']." ".$partner2['Lastname']; }
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
						<table class="score-cont">
								<tr>
									<th>Players</th>
									<th bgcolor="#fdd7b0"><b><?php echo $player1_name;  if($partner1){ echo "; ".$partner1['Firstname']." ".$partner1['Lastname']; } ?></b></th>
									<th bgcolor="#fdd7b0"><b><?php echo $player2_name; if($partner2){ echo "; ".$partner2['Firstname']." ".$partner2['Lastname']; }?></b></th>
									<?php if($sport_id == 1){
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



	 <input class='form-control' value="CD_ADDSCORE" name="score_type" type='hidden'> 
	 <input class='form-control' value="<?php echo $round_matches[$m]->Player1;?>" id="player1_user" name="player1_user" type='hidden'>

	 <input class='form-control' value="<?php echo $round_matches[$m]->Player1_Partner;?>" id="player1_user_partner" 
	 name="player1_user_partner" type='hidden'>

	 <input class='form-control' value="<?php echo $round_matches[$m]->Player2; ?>" id="player2_user" name="player2_user" type='hidden'>

	 <input class='form-control' value="<?php echo $round_matches[$m]->Player2_Partner; ?>" id="player2_user_partner" 
	 name="player2_user_partner" type='hidden'>


	 <input class='form-control' value="<?php echo $round_matches[$m]->Tourn_ID;?>" id="tourn_id" name="tourn_id" type='hidden'> 
	 <input class='form-control' value="<?php echo $round_matches[$m]->BracketID;?>" id="bracket_id" name="bracket_id" type='hidden'>
	 <input class='form-control' value="<?php echo $round_matches[$m]->Match_Num;?>" id="match_num" name="match_num" type='hidden'>
	 <input class='form-control' value="<?php echo $match_type;?>" id="match_type" name="match_type" type='hidden'>
	 <input class='form-control' value="<?php echo $round_matches[$m]->Tourn_match_id;?>" id="tourn_match_id" name="tourn_match_id" type='hidden'>

	<input class='form-control' value="<?php echo $rd_type;?>" id="round_title" name="round_title" type='hidden'>
	<input class='form-control' value="<?php echo $round_matches[$m]->Round_Num;?>" id="round_num" name="round_num" type='hidden'>
	<input class='form-control' value="" id="" name="draw_name" type='hidden'>


	<div class='form-group'>
	<div class='col-md-1 form-group internal'>
	<input name="add_match_score" id="<?php echo $round_matches[$m]->Tourn_match_id;?>" type="submit" value="Add" class="add_score_ajax league-form-submit"/>
	</div>
	</div>

</form>
</div>
</td>
</tr>
<!-- -------------------------end of add score block ------------------------- -->

<!-- -------------------------Edit score block ------------------------- -->
<tr id="escore<?php echo $round_matches[$m]->Tourn_match_id; ?>" class="tourn_match" style="display:none;">
<td colspan='6'>
<div>

<form name="form-editscore" id="form-editscore<?php echo $round_matches[$m]->Tourn_match_id; ?>">
	<div class='form-group'>
	<div class='col-md-2 form-group internal'>
<input type="text" class='form-control' placeholder="Date" id="edate<?php echo $round_matches[$m]->Tourn_match_id; ?>" name="tour_match_date" /> 
	</div>
<script>
$(function() {
	var spid = "<?php echo $round_matches[$m]->Tourn_match_id; ?>";
 $('#edate'+spid).datepick();
});
</script>

	<div class='form-group'>
	<div class='col-md-8 form-group internal scoretable-web'>

<input type='checkbox' name="<?php echo $round_matches[$m]->Tourn_match_id; ?>" id='wff_add' class='wff_score' />&nbsp;Declare winner by Win by Forfeit
		
		<?php
		$get_name = league::get_username($round_matches[$m]->Player1); 
		$player1_name = $get_name['Firstname'] . " " . $get_name['Lastname'];
		?>
		<?php
		$get_name = league::get_username($round_matches[$m]->Player2);
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
									 if($partner1){ echo "; ".$partner1['Firstname']." ".$partner1['Lastname']; }
									 ?></b></td>
									<td><input id='set1_1_<?php echo $round_matches[$m]->Tourn_match_id; ?>' name='player1[]' style = "width:65%" type='text' maxlength='2' /></td>
                                  	<td><input id='set1_2_<?php echo $round_matches[$m]->Tourn_match_id; ?>' name='player1[]' style = "width:65%" type='text' maxlength='2' /></td>
									<td><input id='set1_3_<?php echo $round_matches[$m]->Tourn_match_id; ?>' name='player1[]' style = "width:65%" type='text' maxlength='2' /></td>
									<td><input id='set1_4_<?php echo $round_matches[$m]->Tourn_match_id; ?>' name='player1[]' style = "width:65%" type='text' maxlength='2' /></td>
                                    <td><input id='set1_5_<?php echo $round_matches[$m]->Tourn_match_id; ?>' name='player1[]' style = "width:65%" type='text' maxlength='2' /></td>
									<!-- <td><input id='set1_6_<?php// echo $round_matches[$m]->Tourn_match_id; ?>' name='player1[]' style = "width:65%" type='text' maxlength='2' /></td>-->
								 </tr>
                                  <tr>
                                  	<td bgcolor="#fdd7b0"><b><?php echo $player2_name; 
									 if($partner2){ echo "; ".$partner2['Firstname']." ".$partner2['Lastname']; }
									?></b></td>
									<td><input id='set2_1_<?php echo $round_matches[$m]->Tourn_match_id; ?>' name='player2[]' style = "width:65%" type='text' maxlength='2' /></td>
                                  	<td><input id='set2_2_<?php echo $round_matches[$m]->Tourn_match_id; ?>' name='player2[]' style = "width:65%" type='text' maxlength='2' /></td>
									<td><input id='set2_3_<?php echo $round_matches[$m]->Tourn_match_id; ?>' name='player2[]' style = "width:65%" type='text' maxlength='2' /></td>
									<td><input id='set2_4_<?php echo $round_matches[$m]->Tourn_match_id; ?>' name='player2[]' style = "width:65%" type='text' maxlength='2' /></td>
                                    <td><input id='set2_5_<?php echo $round_matches[$m]->Tourn_match_id; ?>' name='player2[]' style = "width:65%" type='text' maxlength='2' /></td>
									<!-- <td><input id='set2_6_<?php //echo $round_matches[$m]->Tourn_match_id; ?>' name='player2[]' style = "width:65%" type='text' maxlength='2' /></td> -->
									
								 </tr>
			  </table> 
			
			</div>
			</div>

				<!-- ---------------Mobile view------------------------------------------------------- -->
					<div class="scoretable-mob">
						<table class="score-cont">
								<tr>
									<th>Players</th>
									<th bgcolor="#fdd7b0"><b><?php echo $player1_name;  if($partner1){ echo "; ".$partner1['Firstname']." ".$partner1['Lastname']; } ?></b></th>
									<th bgcolor="#fdd7b0"><b><?php echo $player2_name; if($partner2){ echo "; ".$partner2['Firstname']." ".$partner2['Lastname']; }?></b></th>
									<?php if($sport_id == 1){
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
							<td><input id='mset1_1_<?php echo $round_matches[$m]->Tourn_match_id; ?>' name='mob_player1[]' style = "width:45%" type='text' maxlength='2' /></td>
							<td><input id='mset2_1_<?php echo $round_matches[$m]->Tourn_match_id; ?>' name='mob_player2[]' style = "width:45%" type='text' maxlength='2' /></td>
					   </tr>

						<tr>
						<td>
							<?php echo $set_or_game . "2"; ?>
						</td>
						<td><input id='mset1_2_<?php echo $round_matches[$m]->Tourn_match_id; ?>' name='mob_player1[]' style = "width:45%" type='text' maxlength='2' /></td>
						<td><input id='mset2_2_<?php echo $round_matches[$m]->Tourn_match_id; ?>' name='mob_player2[]' style = "width:45%" type='text' maxlength='2' /></td>
						</tr>
						<tr>
						<td>
							<?php echo $set_or_game . "3"; ?>
						</td>
						<td><input id='mset1_3_<?php echo $round_matches[$m]->Tourn_match_id; ?>' name='mob_player1[]' style = "width:45%" type='text' maxlength='2' /></td>
						<td><input id='mset2_3_<?php echo $round_matches[$m]->Tourn_match_id; ?>' name='mob_player2[]' style = "width:45%" type='text' maxlength='2' /></td>
						</tr>
						<tr>
						<td>
							<?php echo $set_or_game . "4"; ?>
						</td>
						<td><input id='mset1_4_<?php echo $round_matches[$m]->Tourn_match_id; ?>' name='mob_player1[]' style = "width:45%" type='text' maxlength='2' /></td>
						<td><input id='mset2_4_<?php echo $round_matches[$m]->Tourn_match_id; ?>' name='mob_player2[]' style = "width:45%" type='text' maxlength='2' /></td>
						</tr>
						<tr>
						<td>
							<?php echo $set_or_game . "5"; ?>
						</td>
						<td><input id='mset1_5_<?php echo $round_matches[$m]->Tourn_match_id; ?>' name='mob_player1[]' style = "width:45%" type='text' maxlength='2' /></td>
						<td><input id='mset2_5_<?php echo $round_matches[$m]->Tourn_match_id; ?>' name='mob_player2[]' style = "width:45%" type='text' maxlength='2' /></td>
						</tr>

			     </table>
		      </div>
			<!-- --------------- Mobile view ------------------------------------------------------- -->


	
	 <input class='form-control' value="CD_EDITSCORE" name="score_type" type='hidden'> 
	 <input class='form-control' value="<?php echo $round_matches[$m]->Player1;?>" id="player1_user" name="player1_user" type='hidden'>

	 <input class='form-control' value="<?php echo $round_matches[$m]->Player1_Partner;?>" id="player1_user_partner" 
	 name="player1_user_partner" type='hidden'>

	 <input class='form-control' value="<?php echo $round_matches[$m]->Player2; ?>" id="player2_user" name="player2_user" type='hidden'>

	 <input class='form-control' value="<?php echo $round_matches[$m]->Player2_Partner; ?>" id="player2_user_partner" 
	 name="player2_user_partner" type='hidden'>


	 <input class='form-control' value="<?php echo $round_matches[$m]->Tourn_ID;?>" id="tourn_id" name="tourn_id" type='hidden'> 
	 <input class='form-control' value="<?php echo $round_matches[$m]->BracketID;?>" id="bracket_id" name="bracket_id" type='hidden'>
	 <input class='form-control' value="<?php echo $round_matches[$m]->Match_Num;?>" id="match_num" name="match_num" type='hidden'>
	 <input class='form-control' value="<?php echo $match_type;?>" id="match_type" name="match_type" type='hidden'>
	 <input class='form-control' value="<?php echo $round_matches[$m]->Tourn_match_id;?>" id="tourn_match_id" name="tourn_match_id" type='hidden'>

	<input class='form-control' value="<?php echo $rd_type;?>" id="round_title" name="round_title" type='hidden'>
	<input class='form-control' value="<?php echo $round_matches[$m]->Round_Num;?>" id="round_num" name="round_num" type='hidden'>
	<input class='form-control' value="" id="" name="draw_name" type='hidden'>


	<div class='form-group'>
	<div class='col-md-1 form-group internal'>
	<input name="upd_match_score" id="<?php echo $round_matches[$m]->Tourn_match_id;?>" type="submit" value="Update" class="edit_score_ajax league-form-submit"/>
	</div>
	</div>

</form>
</div>
</td>
</tr>
<!-- -------------------------end of edit score block ------------------------- -->


<?php 
}
}
?>
</table>
<?php
}

//-------------------------------------------------------------------------------------------------------------------------------------------------
?>

<table>
<tr><td valign="center" align="center"><br /><h4>Consolation Draw</h4><br /></td></tr>
</table>

<?php
$round_matches = $bracket_matches_cd->result();
$total_rounds =	$cd_num_rounds['total_rounds'];
$sess_id = $this->session->userdata('users_id');

$nm = 0;
$round_type = array();
for($round = 1; $round <= $total_rounds; $round++) {
	foreach($round_matches as $m => $match){
		if($round_matches[$m]->Round_Num==$round){
			$nm++;
		}
	}
	$round_type[$round] = $nm;
	$nm = 0;
}


for($round = 1; $round <= $total_rounds; $round++) {

$rt = $round_type[$round];

if($rt >= pow(2,3)){
	$rrt = $rt*2;

	$rd_type = "Round of $rrt";

	//echo "<b>$rd_type</b>";
}
else{
	switch($rt){
		case 1:
			$rd_type = "Final";
			break;
		case 2:
			$rd_type = "Semi-Final";
			break;
		case 4:
			$rd_type = "Quarter-Final";
			break;
		default:
			$rd_type = "---";
			break;
	}
	//echo "<b>$rd_type</b>";

}
	
	echo "<div class='accordion' id='section' style='background:#f59123; padding:5px; color:white;'><i class='fa fa-arrow-circle-o-right' style='color:white;'> </i><b>$rd_type</b><span></span></div>";
//echo "<b>Round:" . $round . "</b>";

?>
<table class="tab-score">

<tr class="top-scrore-table">
<?php if($match_type == "Doubles"){ ?>
<td class="score-position" valign="center" align="center">Team1</td>
<td class="score-position" valign="center" align="center">Team2</td>
<?php } else { ?>
<td class="score-position" valign="center" align="center">Player1</td>
<td class="score-position" valign="center" align="center">Player2</td>
<?php } ?>
<td class="score-position" valign="center" align="center">Score</td>
<!-- <td class="score-position" valign="center" align="center">Winner</td> -->
<!-- <td class="score-position" valign="center" align="center">Action</td> -->
</tr>

<?php
foreach($round_matches as $m => $match){
$player1 = "";
$player2 = "";

	if($round_matches[$m]->Round_Num==$round){

	if($round_matches[$m]->Player1 != 0){
		 $player1 = league::get_username(intval($round_matches[$m]->Player1));
		 $partner1 = league::get_username(intval($round_matches[$m]->Player1_Partner));
	}
	if($round_matches[$m]->Player2 != 0){
		 $player2 = league::get_username(intval($round_matches[$m]->Player2));
		 $partner2 = league::get_username(intval($round_matches[$m]->Player2_Partner));
	}
?>

<tr id="ctr_<?=$round_matches[$m]->Tourn_match_id;?>">

<?php 
$get = league::getonerow($round_matches[$m]->Tourn_ID);
$tourn_admin = $get->Usersid;

	if($sess_id == $round_matches[$m]->Player1 or $sess_id == $round_matches[$m]->Player1_Partner or $sess_id == $round_matches[$m]->Player2 or $sess_id == $round_matches[$m]->Player2_Partner or $tourn_admin == $sess_id){ ?>

<td valign="center" style="padding-left:15px;"><b>
<?php if($player1){
	echo "<a href='".base_url()."player/".$player1['Users_ID']."'>".$player1['Firstname']." ".$player1['Lastname']."</a>"; 
	if($partner1){ echo "; <a href='".base_url()."player/".$partner1['Users_ID']."'>".$partner1['Firstname']." ".$partner1['Lastname']; }
	} else { echo "----"; }
	
	if($round_matches[$m]->Winner == $round_matches[$m]->Player1 and $round_matches[$m]->Winner != '') {
		echo "<img id='img-winner' src='".base_url()."images/gold_medal_small.png' width='20' height='20'></img>";
    }
	
	?>
</b></td>
<td valign="center" style="padding-left:15px;"><b>
<?php if($player2){ 
		echo "<a href='".base_url()."player/".$player2['Users_ID']."'>".$player2['Firstname']." ".$player2['Lastname']."</a>"; 
	if($partner2){ echo "; <a href='".base_url()."player/".$partner2['Users_ID']."'>".$partner2['Firstname']." ".$partner2['Lastname']; }
		} else { echo "----"; }
		
		if($round_matches[$m]->Winner == $round_matches[$m]->Player2 and $round_matches[$m]->Winner != '') {
		echo "<img id='img-winner' src='".base_url()."images/gold_medal_small.png' width='20' height='20'></img>";
	    }
		?>
</b></td>

  <?php


 if($round_matches[$m]->Winner == '') {
?>
		<td valign="center" style="padding-left:15px;">
		<div>
		<a id="add" class="add_score" href="#reg_matches" name="<?php echo $round_matches[$m]->Tourn_match_id; ?>">Add score</a> 
		</div>
		</td>
<?php 
} else { ?>
		<td valign="center" style="padding-left:15px;">
	<?php 
		if($round_matches[$m]->Player1_Score !="" and $round_matches[$m]->Draw_Type == "Consolation"){
		$p1=array();$p2=array();
		$p1 = json_decode($round_matches[$m]->Player1_Score);
		$p2 = json_decode($round_matches[$m]->Player2_Score);

		$cnt = count(array_filter($p1));
		$cnt2 = count(array_filter($p2));

			if($cnt > 0){
					for($i=0; $i<count(array_filter($p1)); $i++)
					{
						echo "($p1[$i] - $p2[$i]) ";
					}
			}
			else if($cnt2 > 0)
			{	
					for($i=0; $i<count(array_filter($p2)); $i++)
					{
						echo "($p1[$i] - $p2[$i]) ";
					}
				
			}
			else if($cnt == 0 and $round_matches[$m]->Player1_Score != "Bye Match" and $round_matches[$m]->Player2_Score != "Bye Match"){
						echo "Win by Forfeit ";
			}

		}

		if(($tourn_admin  == $sess_id) and ($round_matches[$m]->Player1_Score != "Bye Match" and $round_matches[$m]->Player2_Score != "Bye Match")){
		?>
			<?php echo "\t"; ?><img src='<?php echo base_url()."images/ico-images/Edit.png"; ?>' id='img-winner' class='cd_edit_score img-winner' 
			href='#edit_score' name='<?php echo $round_matches[$m]->Tourn_match_id; ?>' width='30px' height='30px' style='cursor:pointer' />
			
			<!-- <a id="edit" class="cd_edit_score" href="#reg_matches" name="<?php// echo $round_matches[$m]->Tourn_match_id; ?>">Edit score</a> -->

		<?php }else if($round_matches[$m]->Player1_Score == "Bye Match" and $round_matches[$m]->Player2_Score == "Bye Match"){
		
			echo "Bye Match";
		}
		?>
  
		</td>
		<?php } ?>
	 <?php } ?>

</tr>


<!------------Win By forfeit-------------------->
<tr id="forfeit<?php echo $round_matches[$m]->Tourn_match_id; ?>" style="display:none;">
<td colspan='6'>
<!-- <form method="post"  action="<?php echo base_url();?>league/view_matches"> -->
<form name="cd_cd_form-wff" id="cd_form-wff<?php echo $round_matches[$m]->Tourn_match_id; ?>">

<div class='form-group'>
	<div class='col-md-3 form-group internal'>

		<?php
		$get_name = league::get_username($round_matches[$m]->Player1); 
		$player1_name = $get_name['Firstname'] . " " . $get_name['Lastname'];
		?>
		<?php 
		$get_name = league::get_username($round_matches[$m]->Player2);
		 $player2_name =  $get_name['Firstname'] . " " . $get_name['Lastname'];
		?>

		<select name="id" class='form-control'>

		<option value="<?php echo $round_matches[$m]->Player1; ?>">
		<?php echo $player1_name;

			if($partner1){ echo "; ".$partner1['Firstname']." ".$partner1['Lastname']; }
		?></option>

		<option value="<?php echo $round_matches[$m]->Player2; ?>">
		<?php 
		echo $player2_name;

			 if($partner2){ echo "; ".$partner2['Firstname']." ".$partner2['Lastname']; }
		?>	
	    </option>
		</select> 
	</div>
</div>

	  <input class='form-control' value="CD_CD_WFF" name="score_type" type='hidden'> 

	  <input class='form-control' value="<?php echo $round_matches[$m]->Tourn_ID;?>" id="tourn_id" name="tourn_id" type='hidden'> 
	  <input class='form-control' value="<?php echo $round_matches[$m]->BracketID;?>" id="bracket_id" name="bracket_id" type='hidden'>
	  <input class='form-control' value="<?php echo $round_matches[$m]->Match_Num;?>" id="match_num" name="match_num" type='hidden'> 
	  <input class='form-control' value="<?php echo $match_type;?>" id="match_type" name="match_type" type='hidden'> 
	<input class='form-control' value="<?php echo $round_matches[$m]->Tourn_match_id;?>" id="tourn_match_id" name="tourn_match_id" type='hidden'>

	<input class='form-control' value="<?php echo $round_matches[$m]->Player1;?>" id="tourn_match_id" name="player1" type='hidden'>
	<input class='form-control' value="<?php echo $round_matches[$m]->Player1_Partner;?>" id="tourn_match_id" name="player1_partner" type='hidden'>
	<input class='form-control' value="<?php echo $round_matches[$m]->Player2;?>" id="tourn_match_id" name="player2" type='hidden'>
	<input class='form-control' value="<?php echo $round_matches[$m]->Player2_Partner;?>" id="tourn_match_id" name="player2_partner" type='hidden'>

	<input class='form-control' value="<?php echo $rd_type;?>" id="round_title" name="round_title" type='hidden'>
	<input class='form-control' value="Consolation" id="" name="draw_name" type='hidden'>


<div class='form-group'>
	<div class='col-md-1 form-group internal'>
	 <input type="submit" name="se_add_winner" id="<?php echo $round_matches[$m]->Tourn_match_id;?>" value="Add Winner" class="cd_wff_add league-form-submit1"/>
	</div>
</div>

</form>
</td>
</tr>

<!----------End of--Win By forfeit-------------------->


<!-- -------------------------Consolation Edit score block ------------------------- -->
<tr id="cd_escore<?php echo $round_matches[$m]->Tourn_match_id; ?>" class="tourn_match" style="display:none;">
<td colspan='6'>
<div>

<form id="form-cd-editscore<?php echo $round_matches[$m]->Tourn_match_id; ?>">
<!-- <form name="cd_form-addscore" id="form-wff<?php echo $round_matches[$m]->Tourn_match_id; ?>"> -->
	<div class='form-group'>
	<div class='col-md-2 form-group internal'>
<input type="text" class='form-control' placeholder="Date" id="cd_edate<?php echo $round_matches[$m]->Tourn_match_id; ?>" name="tour_match_date" /> 
	</div>
<script>
$(function() {
	var spid = "<?php echo $round_matches[$m]->Tourn_match_id; ?>";
	$('#cd_edate'+spid).datepick();
});
</script>

	<div class='form-group'>
	<div class='col-md-8 form-group internal scoretable-web'>

<input type='checkbox' name="<?php echo $round_matches[$m]->Tourn_match_id; ?>" id='wff_add' class='wff_score' />&nbsp;Declare winner by Win by Forfeit

		<?php
		$get_name = league::get_username($round_matches[$m]->Player1); 
		$player1_name = $get_name['Firstname'] . " " . $get_name['Lastname'];
		?>
		<?php
		$get_name = league::get_username($round_matches[$m]->Player2);
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
			 if($partner1){ echo "; ".$partner1['Firstname']." ".$partner1['Lastname']; }
			 ?></b></td>
			<td><input id='cd_set1_1_<?php echo $round_matches[$m]->Tourn_match_id; ?>' name='player1[]' style = "width:65%" type='text' maxlength='2' /></td>
			<td><input id='cd_set1_2_<?php echo $round_matches[$m]->Tourn_match_id; ?>' name='player1[]' style = "width:65%" type='text' maxlength='2' /></td>
			<td><input id='cd_set1_3_<?php echo $round_matches[$m]->Tourn_match_id; ?>' name='player1[]' style = "width:65%" type='text' maxlength='2' /></td>
			<td><input id='cd_set1_4_<?php echo $round_matches[$m]->Tourn_match_id; ?>' name='player1[]' style = "width:65%" type='text' maxlength='2' /></td>
			<td><input id='cd_set1_5_<?php echo $round_matches[$m]->Tourn_match_id; ?>' name='player1[]' style = "width:65%" type='text' maxlength='2' /></td>
			<!-- <td><input id='cd_set1_6_<?php //echo $round_matches[$m]->Tourn_match_id; ?>' name='player1[]' style = "width:65%" type='text' maxlength='2' /></td> -->

		 </tr>
		  <tr>
			<td bgcolor="#fdd7b0"><b><?php echo $player2_name; 
			 if($partner2){ echo "; ".$partner2['Firstname']." ".$partner2['Lastname']; }
			?></b></td>
			<td><input id='cd_set2_1_<?php echo $round_matches[$m]->Tourn_match_id; ?>' name='player2[]' style = "width:65%" type='text' maxlength='2' /></td>
			<td><input id='cd_set2_2_<?php echo $round_matches[$m]->Tourn_match_id; ?>' name='player2[]' style = "width:65%" type='text' maxlength='2' /></td>
			<td><input id='cd_set2_3_<?php echo $round_matches[$m]->Tourn_match_id; ?>' name='player2[]' style = "width:65%" type='text' maxlength='2' /></td>
			<td><input id='cd_set2_4_<?php echo $round_matches[$m]->Tourn_match_id; ?>' name='player2[]' style = "width:65%" type='text' maxlength='2' /></td>
			<td><input id='cd_set2_5_<?php echo $round_matches[$m]->Tourn_match_id; ?>' name='player2[]' style = "width:65%" type='text' maxlength='2' /></td>
			<!-- <td><input id='cd_set2_6_<?php // echo $round_matches[$m]->Tourn_match_id; ?>' name='player2[]' style = "width:65%" type='text' maxlength='2' /></td> -->
			
		 </tr>
		  </table> 
		
		</div>
		</div>

		
		 <!-- ---------------Mobile view------------------------------------------------------- -->
					<div class="scoretable-mob">
						<table class="score-cont">
								<tr>
									<th>Players</th>
									<th bgcolor="#fdd7b0"><b><?php echo $player1_name;  if($partner1){ echo "; ".$partner1['Firstname']." ".$partner1['Lastname']; } ?></b></th>
									<th bgcolor="#fdd7b0"><b><?php echo $player2_name; if($partner2){ echo "; ".$partner2['Firstname']." ".$partner2['Lastname']; }?></b></th>
									<?php if($sport_id == 1){
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
							<td><input id='mcd_set1_1_<?php echo $round_matches[$m]->Tourn_match_id; ?>' name='mob_player1[]' style = "width:65%" type='text' maxlength='2' /></td>
							<td><input id='mcd_set2_1_<?php echo $round_matches[$m]->Tourn_match_id; ?>' name='mob_player2[]' style = "width:65%" type='text' maxlength='2' /></td>
					   </tr>

						<tr>
						<td>
							<?php echo $set_or_game . "2"; ?>
						</td>
						<td><input id='mcd_set1_2_<?php echo $round_matches[$m]->Tourn_match_id; ?>' name='mob_player1[]' style = "width:65%" type='text' maxlength='2' /></td>
						<td><input id='mcd_set2_2_<?php echo $round_matches[$m]->Tourn_match_id; ?>' name='mob_player2[]' style = "width:65%" type='text' maxlength='2' /></td>
						</tr>
						<tr>
						<td>
							<?php echo $set_or_game . "3"; ?>
						</td>
						<td><input id='mcd_set1_3_<?php echo $round_matches[$m]->Tourn_match_id; ?>' name='mob_player1[]' style = "width:65%" type='text' maxlength='2' /></td>
						<td><input id='mcd_set2_3_<?php echo $round_matches[$m]->Tourn_match_id; ?>' name='mob_player2[]' style = "width:65%" type='text' maxlength='2' /></td>
						</tr>
						<tr>
						<td>
							<?php echo $set_or_game . "4"; ?>
						</td>
						<td><input id='mcd_set1_4_<?php echo $round_matches[$m]->Tourn_match_id; ?>' name='mob_player1[]' style = "width:65%" type='text' maxlength='2' /></td>
						<td><input id='mcd_set2_4_<?php echo $round_matches[$m]->Tourn_match_id; ?>' name='mob_player2[]' style = "width:65%" type='text' maxlength='2' /></td>
						</tr>
						<tr>
						<td>
							<?php echo $set_or_game . "5"; ?>
						</td>
						<td><input id='mcd_set1_5_<?php echo $round_matches[$m]->Tourn_match_id; ?>' name='mob_player1[]' style = "width:65%" type='text' maxlength='2' /></td>
						<td><input id='mcd_set2_5_<?php echo $round_matches[$m]->Tourn_match_id; ?>' name='mob_player2[]' style = "width:65%" type='text' maxlength='2' /></td>
						</tr>

			     </table>
		      </div>
				<!-- ---------------Mobile view------------------------------------------------------- -->

	  <input class='form-control' value="CD_CD_EDITSCORE" name="score_type" type='hidden'> 
	
	 <input class='form-control' value="<?php echo $round_matches[$m]->Player1;?>" id="cd_player1_user" name="player1_user" type='hidden'>

	 <input class='form-control' value="<?php echo $round_matches[$m]->Player1_Partner;?>" id="cd_player1_user_partner" 
	 name="player1_user_partner" type='hidden'>

	 <input class='form-control' value="<?php echo $round_matches[$m]->Player2; ?>" id="cd_player2_user" name="player2_user" type='hidden'>

	 <input class='form-control' value="<?php echo $round_matches[$m]->Player2_Partner; ?>" id="cd_player2_user_partner" 
	 name="player2_user_partner" type='hidden'>


	 <input class='form-control' value="<?php echo $round_matches[$m]->Tourn_ID;?>" id="cd_tourn_id" name="tourn_id" type='hidden'> 
	 <input class='form-control' value="<?php echo $round_matches[$m]->BracketID;?>" id="cd_bracket_id" name="bracket_id" type='hidden'>
	 <input class='form-control' value="<?php echo $round_matches[$m]->Match_Num;?>" id="cd_match_num" name="match_num" type='hidden'>
	 <input class='form-control' value="<?php echo $match_type;?>" id="cd_match_type" name="match_type" type='hidden'>
	 <input class='form-control' value="<?php echo $round_matches[$m]->Tourn_match_id;?>" id="cd_tourn_match_id" name="tourn_match_id" type='hidden'>

	<input class='form-control' value="<?php echo $rd_type;?>" id="cd_round_title" name="round_title" type='hidden'>
	<input class='form-control' value="Consolation" id="" name="draw_name" type='hidden'>


	<div class='form-group'>
	<div class='col-md-1 form-group internal'>
	<input name="cd_upd_match_score" id="<?php echo $round_matches[$m]->Tourn_match_id;?>" type="submit" value="Update" class="cd_edit_score_ajax league-form-submit"/>
	</div>
	</div>

</form>
</div>
</td>
</tr>
<!-- -------------------------End of Consolation edit score block ------------------------- -->



<tr id="score<?php echo $round_matches[$m]->Tourn_match_id; ?>" class="tourn_match" style="display:none;">
<td colspan='6'>
<div>

<!-- <form method="post" action="<?php echo base_url();?>league/view_matches"> -->	

<form name="cd_cd_form-addscore" id="cd_form-addscore<?php echo $round_matches[$m]->Tourn_match_id; ?>">

<div class='form-group'>
	<div class='col-md-2 form-group internal'>
<input type="text" class='form-control' placeholder="Date" id="sdate<?php echo $round_matches[$m]->Tourn_match_id; ?>" name="tour_match_date" value = "<?php echo date("m/d/Y"); ?>" /> 
	</div>
<script>
$(function() {
	var spid = "<?php echo $round_matches[$m]->Tourn_match_id; ?>";
 $('#sdate'+spid).datepick();
});
</script>

	<div class='form-group'>
	<div class='col-md-8 form-group internal scoretable-web'>

<input type='checkbox' name="<?php echo $round_matches[$m]->Tourn_match_id; ?>" id='wff_add' class='wff_score' />
&nbsp;Declare winner by Win by Forfeit

		<?php
		$get_name = league::get_username($round_matches[$m]->Player1); 
		$player1_name = $get_name['Firstname'] . " " . $get_name['Lastname'];
		?>
		<?php
		$get_name = league::get_username($round_matches[$m]->Player2);
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
					 if($partner1){ echo "; ".$partner1['Firstname']." ".$partner1['Lastname']; }
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
					 if($partner2){ echo "; ".$partner2['Firstname']." ".$partner2['Lastname']; }
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
						<table class="score-cont">
								<tr>
									<th>Players</th>
									<th bgcolor="#fdd7b0"><b><?php echo $player1_name;  if($partner1){ echo "; ".$partner1['Firstname']." ".$partner1['Lastname']; } ?></b></th>
									<th bgcolor="#fdd7b0"><b><?php echo $player2_name; if($partner2){ echo "; ".$partner2['Firstname']." ".$partner2['Lastname']; }?></b></th>
									<?php if($sport_id == 1){
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


	
	  <input class='form-control' value="CD_CD_ADDSCORE" name="score_type" type='hidden'> 
	
	 <input class='form-control' value="<?php echo $round_matches[$m]->Player1;?>" id="player1_user" name="player1_user" type='hidden'> 
	 <input class='form-control' value="<?php echo $round_matches[$m]->Player1_Partner;?>" id="player1_user_partner" name="player1_user_partner" type='hidden'> 
	 <input class='form-control' value="<?php echo $round_matches[$m]->Player2;?>" id="player2_user" name="player2_user" type='hidden'>
	 <input class='form-control' value="<?php echo $round_matches[$m]->Player2_Partner; ?>" id="player2_user_partner" name="player2_user_partner" type='hidden'>

	 <input class='form-control' value="<?php echo $round_matches[$m]->Tourn_ID;?>" id="tourn_id" name="tourn_id" type='hidden'> 
	 <input class='form-control' value="<?php echo $round_matches[$m]->BracketID;?>" id="bracket_id" name="bracket_id" type='hidden'>
	 <input class='form-control' value="<?php echo $round_matches[$m]->Match_Num;?>" id="match_num" name="match_num" type='hidden'> 
	 <input class='form-control' value="<?php echo $match_type;?>" id="match_type" name="match_type" type='hidden'> 
	 <input class='form-control' value="<?php echo $round_matches[$m]->Tourn_match_id;?>" id="tourn_match_id" name="tourn_match_id" type='hidden'>

	<input class='form-control' value="<?php echo $rd_type;?>" id="round_title" name="round_title" type='hidden'>
	<input class='form-control' value="Consolation" id="" name="draw_name" type='hidden'>

	<div class='form-group'>
	<div class='col-md-1 form-group internal'>
	 <input name="add_match_score" id="<?php echo $round_matches[$m]->Tourn_match_id;?>" type="submit" value="Add" class="cd_add_score_ajax league-form-submit"/>
	</div>
	</div>

</form>
</div>
</td>
</tr>

<?php
	//} // end of add_score and winF div sections

}
}
?>
</table>
<?php
}


//-------------------------------------------------------------------------------------------------

}
else{
?>
<div>Draws are not generated for this tournament yet! </div>
<?php
}
?>
</div>