<script src="<?php echo base_url();?>js/jquery.accordion.js" type="text/javascript"></script>

<script src="https://code.jquery.com/jquery-1.9.1.js"></script>

<script type="text/javascript">
$(document).ready(function () {
	
	$('.edit_img').on('click',function(){
		var tid = $(this).attr('id');

		if($('#stat_edit'+tid).css('display')=='none'){
			$('#stat_edit'+tid).show();
			$('#show_stat'+tid).hide();
		}
		else {
			$('#stat_edit'+tid).hide();
			$('#show_stat'+tid).show();
		}
	});


});
</script>

<script>
$(document).ready(function(){
    $('#myform').submit(function(){
		
       if ( $("input[name='sel_players[]']:checked").length === 0 ) { 
            alert("Select atleast one player to send email"); 
			return false;
        }
	    else { return true; }
    });
});
</script>

<script>
$(document).ready(function(){

var baseurl = "<?php echo base_url();?>";

$('#showdiv3').click(function(){
	$('div[id^=div]').hide();
	$('#div3').show();
});

});
</script>

<script>
	$(document).ready(function(){ 
		$("#sel_all3").change(function(){
		  $(".checkbox1").prop('checked', $(this).prop("checked"));
		  });
	});
</script>


<?php 
//$tourn_id = $get_bracket_details['Tourn_ID'];
/*
echo "<pre>";
print_r($ev_rep_schedule);
exit;*/
?>
  
<div class="col-md-12 league-form-bg" style="margin-top:30px; margin-bottom:30px;display:none;" id="div3">

<div class="fromtitle">Invited Players</div>
<?php
if(count($get_ev_users) == 0){ 
	echo "No Players are invited yet."; 
}
else{
?>
<form class='form-horizontal' id='myform' name='form-op-users'  method="post" 
action="<?php echo $this->config->item('club_pr_url'); ?>/events/send_email_reg_players">
<!-- Table Content -->

<div style="overflow-x:scroll; width:807px">
<table class='tab-score' cellpadding='3' cellspacing='3' style="table-layout:fixed;">
<tr class='top-scrore-table'>

<td width="187" style="padding-left:5px">
<b><input type='checkbox' name="sel_all3" id="sel_all3" /> Players</b>
</td>

<?php
foreach($ev_rep_schedule as $rep_sch){
?>
<td width="147" align='center'><b><?php 

	//$get_rep_sch_det = https://www.google.co.in/maps/place/Jamia+Osmania+Railway+Station;

	$get_loc_det = $this->model_event->get_location_name($rep_sch->Ev_Location);
	$lat				= $get_loc_det['loc_lat']; $long = $get_loc_det['loc_long']; 
	
	//$map_url = "http://maps.google.com/maps?q=loc:".$lat.",".$long."";

	$map_url = "https://www.google.co.in/maps/place/".$get_loc_det['loc_address']."+".$get_loc_det['loc_city']."+".$get_loc_det['loc_state']."+".
		$get_loc_det['loc_country'];

	echo "<a href='".$map_url."' title='".$get_loc_det['loc_address'].", ".$get_loc_det['loc_city'].", ".$get_loc_det['loc_state'].", ".$get_loc_det['loc_country']."' target='_blank'>".$get_loc_det['loc_title']."</a><br>";

	echo date('m/d/Y', strtotime($rep_sch->Ev_Date))."<br>";
	echo date('h:i A', strtotime($rep_sch->Ev_Start_Time))." - ".date('h:i A', strtotime($rep_sch->Ev_End_Time));

?>
</b></td>
<?php
}
?>
</tr>


<?php
$i = 1;
foreach($get_ev_users as $ev_user){

	$get_user = events :: get_user_det($ev_user->Users_Id);
	$get_user_sch = events :: get_user_schedule($ev_det['Ev_ID'], $ev_user->Users_Id);
?>

<tr>
<td style='height:45px padding-left:5px'>
<input class='checkbox1' type='checkbox' name='sel_players[]' value='<?=$ev_user->Users_Id;?>' />
<b><a href='<?=base_url();?>player/<?=$ev_user->Users_Id;?>'><?php echo ucfirst($get_user['Firstname'])." ".ucfirst($get_user['Lastname']); ?></a></b>

</td>
<?php

foreach($get_user_sch as $sch){

?>
		<td style='height:45px' align='center'><!-- <b><?php //echo $sch->Ev_status; ?></b> -->
		<!-- <input type='hidden' name='stat_val<?=$i;?>' id='stat_val<?=$i;?>' value='1' /> -->	
		<?php

		switch($sch->Ev_status){

			case 'Pending':
				echo "<img id='img-winner' class='img-winner' name='stat_edit".$i."' src='".base_url()."images/pending.png' width='20px' height='20px' />";
				break;
			case 'Accept':
				echo "<img id='img-winner' class='img-winner' name='stat_edit".$i."' src='".base_url()."images/accept.png' width='20px' height='20px' />";
				break;
			case 'Decline':
				echo "<img id='img-winner' class='img-winner' name='stat_edit".$i."' src='".base_url()."images/decline.png' width='20px' height='20px' />";
				break;
			case 'Tentative':
				echo "<img id='img-winner' class='img-winner' name='stat_edit".$i."' src='".base_url()."images/tentative.png' width='20px' height='20px' />";
				break;
			default:

				break;

		}
		?>
		</td>
<?php
$i++;
}
?>
</tr>
<?php
}
?>

<tr>

<!-- <td style='height:45px margin-left:2px'><b>Players</b></td>
 -->
 <td width="187" style="padding-left:5px"><b>Available Players</b></td>
 <?php
foreach($ev_rep_schedule as $rep_sch){
?>
<td width="147" align='center'><b><?php 

	$get_accpted_count = $this->model_event->get_res_count($rep_sch->Ev_Tab_ID);
	
	echo $get_accpted_count;
?>
</b>
</td>
<?php
}
?>
</tr>

</table>
</div>

	<br /><br />

	<input type='hidden' name='ev_id' id='' value='<?php echo $ev_det['Ev_ID'];?>' />

		<div class='form-group'>
		<label class='control-label col-md-3' for='id_accomodation'>Subject (Optional):</label> 
		<div class='col-md-7 form-group internal'>
			<input type='text' class='form-control' name='subject' id='ev_id' value='' />
		</textarea>
		</div>	
		</div>

		<div class='form-group'>
		<label class='control-label col-md-3' for='id_accomodation'>Message :</label> 
		<div class='col-md-7 form-group internal'>
		<textarea name="mes" class='form-control' id="mes" rows="5" cols="10" required></textarea>
		</div>	
		</div>
		 
		 <div class='form-group'>
			<label class='control-label col-md-3' for='id_accomodation'></label>
			 <div class='col-md-7 form-group internal'>
			  <input type="submit" name='send_invite_email' value="Send Email" class="league-form-submit1"/>
			</div>
		 </div>

	
<!-- table content -->
</form>
<?php
}
?>
</div>