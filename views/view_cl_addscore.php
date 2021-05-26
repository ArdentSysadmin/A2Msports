<script src="<?php echo base_url();?>js/jquery.accordion.js" type="text/javascript"></script>
<script src="http://code.jquery.com/jquery-1.9.1.js"></script>

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
	//alert("Test");
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

	$('.cl_wff_add').click(function (e){

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
		   $('#forfeit'+id_val).style('display','none');
		}
	  });
	  e.preventDefault();
	});
});
</script>
<script>
$(document).ready(function(){

var baseurl = "<?php echo base_url();?>";

$('.add_cl_score_ajax').click(function (e) {

var id_val = $(this).attr('id');

	  $.ajax({
		type: 'POST',
		url: baseurl+'league/view_matches',
		data: $('#form-addscore'+id_val).serialize(),
		success: function (res) {
		   //location.reload();
		   alert('Scores were added successfully');
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
		   $('#rr_escore'+id_val).style('display','none');
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
			$('#mset1_'+($i+1)+'_'+res[0]).val(p1_score[$i]);
		}

		for($j=0; $j<p2_score.length; $j++){
			$('#set2_'+($j+1)+'_'+res[0]).val(p2_score[$j]);
			$('#mset2_'+($j+1)+'_'+res[0]).val(p2_score[$j]);
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
$tourn_id	= $get_bracket_details['Tourn_ID'];
$rr_matches = $cl_bracket_matches->result();
$sess_id	= $this->session->userdata('users_id');
/*echo "<pre>";
print_r($rr_matches);*/
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
if(!in_array($this->logged_user, $players) and !in_array($this->logged_user, $players_partners) and $this->logged_user != $tourn_det->Usersid){
?>
<tr></td><span style="color:red">No Matches found, as you are not a player in this draw!</span></td></tr>
<?php
}
else {
	$rrr = 0;
foreach($rr_matches as $m=>$rrm){   // Main for loop

	if($rrr != $rr_matches[$m]->Multi_Round_Num)
	{
	$rrr = $rr_matches[$m]->Multi_Round_Num;
?>
<tr style='background:white; font-size:16px;'>
<td align='left' colspan='3'>Round <?=$rr_matches[$m]->Multi_Round_Num;?>
</tr>
<?php
	}
	if($round != $rr_matches[$m]->Round_Num)
	{
	$round = $rr_matches[$m]->Round_Num;
?>

<tr class='top-scrore-table'>
<!-- <td>Match #</td> -->
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
</tr>

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

if($rr_matches[$m]->Player1_Partner){
	$player1_partner = league::get_username(intval($rr_matches[$m]->Player1_Partner));
	$p1_part = "; <a title=".$player1_partner['Mobilephone']." href=".base_url()."player/$player1_partner[Users_ID]>".ucfirst($player1_partner[Firstname])." ".ucfirst($player1_partner[Lastname])."</a>";
}

if($rr_matches[$m]->Player2_Partner)
	{
	$player2_partner = league::get_username(intval($rr_matches[$m]->Player2_Partner));
	//$p2_part = "; $player2_partner[Firstname] $player2_partner[Lastname]";
	$p2_part = "; <a title=".$player2_partner['Mobilephone']." href=".base_url()."player/$player2_partner[Users_ID]>".ucfirst($player2_partner[Firstname])." ".ucfirst($player2_partner[Lastname])."</a>";
}

$tm_id = $rr_matches[$m]->Tourn_match_id;
?>

<tr id='tr_<?=$tm_id;?>'>
	<?php 
	if($sess_id == $rr_matches[$m]->Player1 or $sess_id == $rr_matches[$m]->Player1_Partner or $sess_id == $rr_matches[$m]->Player2 or $sess_id == $rr_matches[$m]->Player2_Partner or $tour_details->Usersid == $sess_id){ ?>
	
	<td style="padding-left:15px;"><a href="<?php echo base_url();?>player/<?php echo $player1['Users_ID'];?>" title="<?php echo $player1['Mobilephone'];?>"><?php echo ucfirst($player1['Firstname'])." ".ucfirst($player1['Lastname'])."</a>" . $p1_part; 
	if($rr_matches[$m]->Winner == $rr_matches[$m]->Player1) {
		echo "<img id='img-winner' src='".base_url()."images/gold_medal_small.png' width='20' height='20'></img>";
	}
	?></td>
	
	 <td style="padding-left:15px;"><a href="<?php echo base_url();?>player/<?php echo $player2['Users_ID'];?>" title="<?php echo $player2['Mobilephone'];?>"><?php echo ucfirst($player2['Firstname'])." ".ucfirst($player2['Lastname'])."</a>".$p2_part;
	if($rr_matches[$m]->Winner == $rr_matches[$m]->Player2) {
		echo "<img id='img-winner' src='".base_url()."images/gold_medal_small.png' width='20' height='20'></img>";
	}
	?></td>

<?php if($tour_details->Tournament_type == 'Flexible League22'){ ?>
<td style="padding-left:15px;"><?php 
	 if($rr_matches[$m]->Match_Location) { $loc_id = $rr_matches[$m]->Match_Location; } 
		$get_loc = league::get_home_location($loc_id);

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
			
		}	else if($cnt == 0 and $rr_matches[$m]->Player1_Score != "Bye Match" and $rr_matches[$m]->Player2_Score != "Bye Match"){
					echo "Win by Forfeit ";
			}

		}
		if($tour_details->Usersid == $sess_id){
		?>
			<?php echo "\t"; ?><img src='<?php echo base_url()."images/ico-images/Edit.png"; ?>' id='img-winner' class='rr_edit_score img-winner' 
			href='#edit_score' name='<?php echo $tm_id; ?>' width='30px' height='30px' style='cursor:pointer' />
		<?php }
		?>
	 </td>
	 <?php 
		}
	$logged_user_matches_count++;
	}
	//if($logged_user_matches_count == 0 and $round_matches != 0){ ?>
	<!-- <td colspan='3' align='center'>---- Got a Bye ----</td> -->
	<?php 
	//}
	?>

</tr>
<?php
$match_num++;

$data['tm_id']		  = $tm_id;
$data['round']		  = $round;
$data['rr_matches']	  = $rr_matches;
$data['m']			  = $m;
$data['tourn_id']	  = $tourn_id;
$data['tour_details'] = $tour_details;

$this->load->view('tournament/cl_addscore', $data);
$this->load->view('tournament/cl_wff',		$data);

}		// End of Main For loop
?>
</table>

</div>

<?php
}
?>