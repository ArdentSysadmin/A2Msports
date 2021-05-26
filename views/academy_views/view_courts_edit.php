<script>
var court_count = "<?php echo count($loc_courts); ?>";

$(document).ready(function(){
	$("#cancel_ed_location").click(function(){
		$("#div_add_court").hide();
		$("#div_edit_court").hide();
		$("#div_court_list").show();

		$(".fromtitle").html('Court Details');
	});

	var i = 0;
	var count = court_count;
	$("#div_add_more").click(function () {
		++count;
		var $ctrl = $("<div class='col-md-12 dyn_div'><input type='hidden' class='form-control' name='courts_id[]' /><div class='col-md-3'><input type='text' class='form-control' name='courts[]' placeholder='Court Name/#' value='Court "+(parseInt(count))+"' /></div><div class='col-md-3'><input type='number' class='form-control' name='max_book_hours[]' placeholder='Max Book Hours' value='2' max='10' /></div><div class='col-md-3'><input type='number' class='form-control' name='max_num_players[]' placeholder='Max Players' value='2' max='10' /></div><div class='col-md-3'><select class='form-control' name='status[]'><option value='1'>Active</option><option value='0'>Inactive</option></select><br/></div></div><div class='col-md-12'>Sharable resource?<input type='checkbox' name='is_sharable_"+(parseInt(count)+1)+"' id='isr_"+(parseInt(count)+1)+"' value='1' /> </div><div class='' id='div_peakcharges_"+count+"'><div class='col-md-2'>Start Time   <br/><select class='form-control' name='stime' id='edit_stime_"+count+"' style='width: 108%; !important'><option value=''>Select</option><option value='05:00:00'>5:00 am</option><option value='06:00:00'>6:00 am</option><option value='07:00:00'>7:00 am</option><option value='08:00:00'>8:00 am</option><option value='09:00:00'>9:00 am</option><option value='10:00:00'>10:00 am</option><option value='11:00:00'>11:00 am</option><option value='12:00:00'>12:00 pm</option><option value='13:00:00'>1:00 pm</option><option value='14:00:00'>2:00 pm</option><option value='15:00:00'>3:00 pm</option><option value='16:00:00'>4:00 pm</option><option value='17:00:00'>5:00 pm</option><option value='18:00:00'>6:00 pm</option><option value='19:00:00'>7:00 pm</option><option value='20:00:00'>8:00 pm</option><option value='21:00:00'>9:00 pm</option><option value='22:00:00'>10:00 pm</option></select>	</div>    <div class='col-md-2'>End Time <br/><select class='form-control' name='etime' id='edit_etime_"+count+"' style='width: 108%; !important'><option value=''>Select</option><option value='06:00:00'>6:00 am</option><option value='07:00:00'>7:00 am</option><option value='08:00:00'>8:00 am</option><option value='09:00:00'>9:00 am</option><option value='10:00:00'>10:00 am</option><option value='11:00:00'>11:00 am</option><option value='12:00:00'>12:00 pm</option><option value='13:00:00'>1:00 pm</option><option value='14:00:00'>2:00 pm</option><option value='15:00:00'>3:00 pm</option><option value='16:00:00'>4:00 pm</option><option value='17:00:00'>5:00 pm</option><option value='18:00:00'>6:00 pm</option><option value='19:00:00'>7:00 pm</option><option value='20:00:00'>8:00 pm</option><option value='21:00:00'>9:00 pm</option><option value='22:00:00'>10:00 pm</option><option value='23:00:00'>11:00 pm</option></select></div> <div class='col-md-1'>Sun <br/><input class='form-control' type='text' name='sun' id='edit_sun_"+count+"' value='' placeholder='n/a' style='width:150%; height:100%;'></div><div class='col-md-1'>Mon <br/><input class='form-control' type='text' name='mon' id='edit_mon_"+count+"' value='' placeholder='n/a' style='width:150%; height:100%;'></div><div class='col-md-1'>Tue <br/><input class='form-control' type='text' name='tue' id='edit_tue_"+count+"' value='' placeholder='n/a' style='width:150%; height:100%;'></div><div class='col-md-1'>Wed <br/><input class='form-control' type='text' name='wed' id='edit_wed_"+count+"' value='' placeholder='n/a' style='width:150%; height:100%;'></div><div class='col-md-1'>Thu <br/><input class='form-control' type='text' name='thu' id='edit_thu_"+count+"' value='' placeholder='n/a' style='width:150%; height:100%;'></div><div class='col-md-1'>Fri <br/><input class='form-control' type='text' name='fri' id='edit_fri_"+count+"' value='' placeholder='n/a' style='width:150%; height:100%;'></div><div class='col-md-1'>Sat <br/><input class='form-control' type='text' name='sat' id='edit_sat_"+count+"' value='' placeholder='n/a' style='width:150%; height:100%;'><br/><br/></div><div class='col-md-1'><br/><input type='button' name='add_timings' id='"+count+"' value='Add' class='league-form-submit1 add_timings2' style='width:125%; height:100%;'></div></div><div class='col-md-4'>Add Additional player fee? <input type='checkbox' name='add_addn_fee' id='ad_"+count+"' class='add_addn_fee' value='1' /><br /></div><div class='col-md-1'><input class='form-control addn_fee_"+count+" addn_fee_all' type='text' name='edit_addn_sun' id='edit_addn_sun_"+count+"' value='' placeholder='n/a' style='width:150%; height:100%;'></div><div class='col-md-1'><input class='form-control addn_fee_"+count+" addn_fee_all' type='text' name='edit_addn_mon' id='edit_addn_mon_"+count+"' value='' placeholder='n/a' style='width:150%; height:100%;'></div><div class='col-md-1'><input class='form-control addn_fee_"+count+" addn_fee_all' type='text' name='edit_addn_tue' id='edit_addn_tue_"+count+"' value='' placeholder='n/a' style='width:150%; height:100%;'></div><div class='col-md-1'><input class='form-control addn_fee_"+count+" addn_fee_all' type='text' name='edit_addn_wed' id='edit_addn_wed_"+count+"' value='' placeholder='n/a' style='width:150%; height:100%;'></div><div class='col-md-1'><input class='form-control addn_fee_"+count+" addn_fee_all' type='text' name='edit_addn_thu' id='edit_addn_thu_"+count+"' value='' placeholder='n/a' style='width:150%; height:100%;'></div><div class='col-md-1'><input class='form-control addn_fee_"+count+" addn_fee_all' type='text' name='edit_addn_fri' id='edit_addn_fri_"+count+"' value='' placeholder='n/a' style='width:150%; height:100%;'></div><div class='col-md-1'><input class='form-control addn_fee_"+count+" addn_fee_all' type='text' name='edit_addn_sat' id='edit_addn_sat_"+count+"' value='' placeholder='n/a' style='width:150%; height:100%;'><br/><br/></div><div class='col-md-1'>&nbsp;</div></div><div class='col-md-12' id='edit_show_timings_"+count+"' style='display:none; margin-top: 0px;'><table name='timings_table' id='edit_timings_table_"+count+"' width='' class='score-cont tab-score'><tr><th>Start Time</th><th>End Time</th><th>Sunday</th><th>Monday</th><th>Tuesday</th><th>Wednesday</th><th>Thursday</th><th>Friday</th><th>Saturday</th><th>&nbsp;</th></tr></table><br/></div><div class='col-md-12'><hr style='border-top: 1px solid #191919'></div></div>");

		$("#main_div_courts").append($ctrl);
	});

	$('#courts_update_form').submit(function(){
		$('#update_courts').hide();
		$('#update_courts_wait').show();
	});

});

</script>

<?php
if($_SERVER['HTTP_X_FORWARDED_HOST'] != ''){
?>
<form class="form-horizontal" id='courts_update_form' method='post' role="form" id='courts_edit' action="/courts/update">
<?php
}
else{
?>
<form class="form-horizontal" id='courts_update_form' method='post' role="form" id='courts_edit' action="<?php echo base_url().$this->short_code; ?>/courts/update">
<?php
}
?>
<div class="col-md-9">
<br />
Location
<input type="text" class='form-control' name="location" value="<?php echo $loc_info['location']; ?>" />
</div>

<div id='dyn_edit_courts'><!-- Dynamic Add New Courts Area -->

<div class='col-md-12'>
<div style='float:right; padding-bottom:4px;'><a id='div_add_more' style='cursor:pointer'>Add More +</a></div>
</div>
	<div class='col-md-12' id='div_edit_grp' style='padding-bottom:4px;'>
	<div class='dyn_div'>
		<div class='col-md-3'>Court Name/#</div>
		<div class='col-md-3'>Max Book Hours</div>
		<div class='col-md-3'>Max Players</div>
		<div class='col-md-3'>Status</div>
	</div>
	</div>
</div>	

<div id='main_div_courts'>
<!-- <div> -->
<?php
foreach($loc_courts as $a => $court){ ?>
	<div class='dyn_div'>
		<input type='hidden' class='form-control' name='courts_id[]' value='<?php echo $court->court_id; ?>' />

		<div class='col-md-3'><input type='text' class='form-control' name='courts[]' placeholder='Court Name/# 1' 
		value='<?php echo $court->court_name; ?>' /></div>
		<div class='col-md-3'><input type='number' class='form-control' name='max_book_hours[]' placeholder='Max Book Hours' 
		value='<?php echo $court->max_hours; ?>' max='10' /></div>
		<div class='col-md-3'><input type='number' class='form-control' name='max_num_players[]' placeholder='Max Players' 
		value='<?php echo $court->max_players; ?>' max='10' /></div>
		<div class='col-md-3'><select class='form-control' name='status[]'>
		<option value='1' <?php if($court->status == '1') { echo 'selected'; } ?>>Active</option>
		<option value='0' <?php if($court->status == '0') { echo 'selected'; } ?>>Inactive</option>
		</select><br/></div>
	</div>

	<div class='col-md-12'>Sharable resource? 
	<input type='checkbox' name='is_sharable_<?=($a+1);?>' id='isr_<?=($a+1);?>' value='1' <?php if($court->is_shared_resource) echo "checked"; ?>/> </div>

<!-- ********** Code To Display Hourly Basis Court Reservations Starts Here. ************** -->

<?php $get_courttimes_fees = courts :: getCourtsTimesFees($court->court_id);
$court = $court->court_id;
?>
	<div class="" id="div_peakcharges">
	<div class="col-md-2">
		Start Time   <br/>
		<select class='form-control' name='stime' id='edit_stime_<?=$a; ?>' style="width: 108%; !important">
			<option value=''>Select</option>
			<option value="05:00:00">5:00 am</option>
			<option value="06:00:00">6:00 am</option>
			<option value="07:00:00">7:00 am</option>
			<option value="08:00:00">8:00 am</option>
			<option value="09:00:00">9:00 am</option>
			<option value="10:00:00">10:00 am</option>
			<option value="11:00:00">11:00 am</option>
			<option value="12:00:00">12:00 pm</option>
			<option value="13:00:00">1:00 pm</option>
			<option value="14:00:00">2:00 pm</option>
			<option value="15:00:00">3:00 pm</option>
			<option value="16:00:00">4:00 pm</option>
			<option value="17:00:00">5:00 pm</option>
			<option value="18:00:00">6:00 pm</option>
			<option value="19:00:00">7:00 pm</option>
			<option value="20:00:00">8:00 pm</option>
			<option value="21:00:00">9:00 pm</option>
			<option value="22:00:00">10:00 pm</option>
		</select>	
	</div>

	<div class="col-md-2">
		End Time <br/>
		<select class='form-control' name='etime' id='edit_etime_<?=$a; ?>' style="width: 108%; !important">
			<option value=''>Select</option>
			<option value="06:00:00">6:00 am</option>
			<option value="07:00:00">7:00 am</option>
			<option value="08:00:00">8:00 am</option>
			<option value="09:00:00">9:00 am</option>
			<option value="10:00:00">10:00 am</option>
			<option value="11:00:00">11:00 am</option>
			<option value="12:00:00">12:00 pm</option>
			<option value="13:00:00">1:00 pm</option>
			<option value="14:00:00">2:00 pm</option>
			<option value="15:00:00">3:00 pm</option>
			<option value="16:00:00">4:00 pm</option>
			<option value="17:00:00">5:00 pm</option>
			<option value="18:00:00">6:00 pm</option>
			<option value="19:00:00">7:00 pm</option>
			<option value="20:00:00">8:00 pm</option>
			<option value="21:00:00">9:00 pm</option>
			<option value="22:00:00">10:00 pm</option>
			<option value="23:00:00">11:00 pm</option>
		</select>
	</div>

	<div class="col-md-1">
		Sun <br/>
		<input class='form-control' type='text' name='sun' id='edit_sun_<?=$a; ?>' value='' placeholder='n/a' style='width:150%; height:100%;'>
	</div>
	<div class="col-md-1">
		Mon <br/>
		<input class='form-control' type='text' name='mon' id='edit_mon_<?=$a; ?>' value='' placeholder='n/a' style='width:150%; height:100%;'>
	</div>
	<div class="col-md-1">
		Tue <br/>
		<input class='form-control' type='text' name='tue' id='edit_tue_<?=$a; ?>' value='' placeholder='n/a' style='width:150%; height:100%;'>
	</div>
	<div class="col-md-1">
		Wed <br/>
		<input class='form-control' type='text' name='wed' id='edit_wed_<?=$a; ?>' value='' placeholder='n/a' style='width:150%; height:100%;'>
	</div>
	<div class="col-md-1">
		Thu <br/>
		<input class='form-control' type='text' name='thu' id='edit_thu_<?=$a; ?>' value='' placeholder='n/a' style='width:150%; height:100%;'>
	</div>
	<div class="col-md-1">
		Fri <br/>
		<input class='form-control' type='text' name='fri' id='edit_fri_<?=$a; ?>' value='' placeholder='n/a' style='width:150%; height:100%;'>
	</div>
	<div class="col-md-1">
		Sat <br/>
		<input class='form-control' type='text' name='sat' id='edit_sat_<?=$a; ?>' value='' placeholder='n/a' style='width:150%; height:100%;'>
		<br/><br/>
	</div>
	<div class="col-md-1">
		 <br/>
		<input type='button' name='add_timings' id='<?=$a;?>' value='Add' class="league-form-submit1 add_timings2" style='width:125%; height:100%;'>
	</div>
</div>
<!-- Additional fee section -->
		<div class="col-md-4">
		Add Additional player fee? <input type='checkbox' name='add_addn_fee' id='ad_<?=$a; ?>' class='add_addn_fee' value='1' /><br />
	</div>
	<div class="col-md-1">
		<input class='form-control addn_fee_<?=$a; ?> addn_fee_all' type='text' name='edit_addn_sun' id='edit_addn_sun_<?=$a; ?>' value='' placeholder='n/a' style='width:150%; height:100%;'>
	</div>
	<div class="col-md-1">
		<input class='form-control addn_fee_<?=$a; ?> addn_fee_all' type='text' name='edit_addn_mon' id='edit_addn_mon_<?=$a; ?>' value='' placeholder='n/a' style='width:150%; height:100%;'>
	</div>
	<div class="col-md-1">
		<input class='form-control addn_fee_<?=$a; ?> addn_fee_all' type='text' name='edit_addn_tue' id='edit_addn_tue_<?=$a; ?>' value='' placeholder='n/a' style='width:150%; height:100%;'>
	</div>
	<div class="col-md-1">
		<input class='form-control addn_fee_<?=$a; ?> addn_fee_all' type='text' name='edit_addn_wed' id='edit_addn_wed_<?=$a; ?>' value='' placeholder='n/a' style='width:150%; height:100%;'>
	</div>
	<div class="col-md-1">
		<input class='form-control addn_fee_<?=$a; ?> addn_fee_all' type='text' name='edit_addn_thu' id='edit_addn_thu_<?=$a; ?>' value='' placeholder='n/a' style='width:150%; height:100%;'>
	</div>
	<div class="col-md-1">
		<input class='form-control addn_fee_<?=$a; ?> addn_fee_all' type='text' name='edit_addn_fri' id='edit_addn_fri_<?=$a; ?>' value='' placeholder='n/a' style='width:150%; height:100%;'>
	</div>
	<div class="col-md-1">
		<input class='form-control addn_fee_<?=$a; ?> addn_fee_all' type='text' name='edit_addn_sat' id='edit_addn_sat_<?=$a; ?>' value='' placeholder='n/a' style='width:150%; height:100%;'>
		<br/><br/>
	</div>
	<div class="col-md-1">
		 &nbsp;		
	</div>
	<!-- Additional fee section -->

		<div class='col-md-12 timing-table' id='edit_show_timings' style='display:block; margin-top: -35px;'>
			<table name='edit_timings_table' id='edit_timings_table_<?=$a;?>' width='' class='score-cont tab-score'>
				<tr>
					<th>Start Time</th>
					<th>End Time</th>
					<th>Sunday</th>
					<th>Monday</th>
					<th>Tuesday</th>
					<th>Wednesday</th>
					<th>Thursday</th>
					<th>Friday</th>
					<th>Saturday</th>
					<th>&nbsp;</th>
				</tr>
		<?php foreach($get_courttimes_fees as $i => $get_courttimes_feess) {?>
				<tr id="edit_row_<?=$get_courttimes_feess->Court_Price_ID;?>">
					<td><?php echo date('H:i:s', strtotime($get_courttimes_feess->Start_Time)); ?><input type ="hidden" name="stTime_<?=$a;?>[]" value="<?=date('H:i:s', strtotime($get_courttimes_feess->Start_Time));?>" />
					</td>
					<td>
					<?php echo date('H:i:s', strtotime($get_courttimes_feess->End_Time)); ?>
					<input type ="hidden" name="edTime_<?=$a;?>[]" value="<?=date('H:i:s', strtotime($get_courttimes_feess->End_Time));?>" />					
					</td>
					<td>
					<?php 
					$sun_price = 'n/a';
					if($get_courttimes_feess->Sun_Price != NULL){
					$sun_price = number_format($get_courttimes_feess->Sun_Price,2);
					}
					echo $sun_price;
					?>
					<input type ="hidden" name="sunPrice_<?=$a;?>[]" value="<?=$sun_price;?>" />					
					</td>
					<td>
					<?php
					$mon_price = 'n/a';
					if($get_courttimes_feess->Mon_Price != NULL){
					$mon_price = number_format($get_courttimes_feess->Mon_Price,2);
					}
					echo $mon_price;					
					?>
					<input type ="hidden" name="monPrice_<?=$a;?>[]" value="<?=$mon_price;?>" />					
					</td>
					<td>
					<?php
					$tue_price = 'n/a';
					if($get_courttimes_feess->Tue_Price != NULL){
					$tue_price = number_format($get_courttimes_feess->Tue_Price,2);
					}
					echo $tue_price;
					?>
					<input type ="hidden" name="tuePrice_<?=$a;?>[]" value="<?=$tue_price;?>" />					
					</td>
					<td>
					<?php
					$wed_price = 'n/a';
					if($get_courttimes_feess->Wed_Price != NULL){
					$wed_price = number_format($get_courttimes_feess->Wed_Price,2);
					}
					echo $wed_price;
					?>
					<input type ="hidden" name="wedPrice_<?=$a;?>[]" value="<?=$wed_price;?>" />					
					</td>
					<td>
					<?php
					$thu_price = 'n/a';
					if($get_courttimes_feess->Thu_Price != NULL){
					$thu_price = number_format($get_courttimes_feess->Thu_Price,2);
					}
					echo $thu_price;
					?>
					<input type ="hidden" name="thuPrice_<?=$a;?>[]" value="<?=$thu_price;?>" />					
					</td>
					<td>
					<?php
					$fri_price = 'n/a';
					if($get_courttimes_feess->Fri_Price != NULL){
					$fri_price = number_format($get_courttimes_feess->Fri_Price,2);
					}
					echo $fri_price;
					?>
					<input type ="hidden" name="friPrice_<?=$a;?>[]" value="<?=$fri_price?>" />					
					</td>
					<td>
					<?php
					$sat_price = 'n/a';
					if($get_courttimes_feess->Sat_Price != NULL){
					$sat_price = number_format($get_courttimes_feess->Sat_Price,2);
					}
					echo $sat_price;					
					?>
					<input type ="hidden" name="satPrice_<?=$a;?>[]" value="<?=$sat_price;?>" />					
					</td>
					<td><input type="button" name="del_timings" id="<?php echo $get_courttimes_feess->Court_Price_ID;?>" value=" Delete " class="league-form-submit1 edit_btn_remove" style="width: 90%;height: 100%; margin-left: 5px;"></td></td>
				</tr>
				<!-- Additional Fee section -->
					<tr id="edit_row_addn_<?=$get_courttimes_feess->Court_Price_ID;?>">
					<td colspan='2'>Additional Fee</td>
					<td>
					<?php 
					$sun_addn_price = 'n/a';
					if($get_courttimes_feess->Sun_Addn_Price != NULL){
					$sun_addn_price = number_format($get_courttimes_feess->Sun_Addn_Price, 2);
					}
					echo $sun_addn_price;
					?>
					<input type ="hidden" name="sunAddnPrice_<?=$a;?>[]" value="<?=$sun_addn_price;?>" />					
					</td>
					<td>
					<?php
					$mon_addn_price = 'n/a';
					if($get_courttimes_feess->Mon_Addn_Price != NULL){
					$mon_addn_price = number_format($get_courttimes_feess->Mon_Addn_Price,2);
					}
					echo $mon_addn_price;					
					?>
					<input type ="hidden" name="monAddnPrice_<?=$a;?>[]" value="<?=$mon_addn_price;?>" />					
					</td>
					<td>
					<?php
					$tue_addn_price = 'n/a';
					if($get_courttimes_feess->Tue_Addn_Price != NULL){
					$tue_addn_price = number_format($get_courttimes_feess->Tue_Addn_Price,2);
					}
					echo $tue_addn_price;
					?>
					<input type ="hidden" name="tueAddnPrice_<?=$a;?>[]" value="<?=$tue_addn_price;?>" />					
					</td>
					<td>
					<?php
					$wed_addn_price = 'n/a';
					if($get_courttimes_feess->Wed_Addn_Price != NULL){
					$wed_addn_price = number_format($get_courttimes_feess->Wed_Addn_Price,2);
					}
					echo $wed_addn_price;
					?>
					<input type ="hidden" name="wedAddnPrice_<?=$a;?>[]" value="<?=$wed_addn_price;?>" />					
					</td>
					<td>
					<?php
					$thu_addn_price = 'n/a';
					if($get_courttimes_feess->Thu_Addn_Price != NULL){
					$thu_addn_price = number_format($get_courttimes_feess->Thu_Addn_Price,2);
					}
					echo $thu_addn_price;
					?>
					<input type ="hidden" name="thuAddnPrice_<?=$a;?>[]" value="<?=$thu_addn_price;?>" />					
					</td>
					<td>
					<?php
					$fri_addn_price = 'n/a';
					if($get_courttimes_feess->Fri_Addn_Price != NULL){
					$fri_addn_price = number_format($get_courttimes_feess->Fri_Addn_Price, 2);
					}
					echo $fri_addn_price;
					?>
					<input type ="hidden" name="friAddnPrice_<?=$a;?>[]" value="<?=$fri_addn_price?>" />					
					</td>
					<td>
					<?php
					$sat_addn_price = 'n/a';
					if($get_courttimes_feess->Sat_Addn_Price != NULL){
					$sat_addn_price = number_format($get_courttimes_feess->Sat_Addn_Price, 2);
					}
					echo $sat_addn_price;					
					?>
					<input type ="hidden" name="satAddnPrice_<?=$a;?>[]" value="<?=$sat_addn_price;?>" />					
					</td>
					<td>&nbsp;</td>
				</tr>

				<!-- Additional Fee section -->
		<?php } ?>
			</table>
			<br/>
		</div>

<div class='col-md-12'><hr style="border-top: 1px solid #191919"></div>

<!-- ************ Code To Display Hourly Basis Court Reservations Ends Here. *************** -->

<?php } ?> <!-- To be deleted after if not required. -->  
</div>

</div> <!-- End of #main_div_courts -->

<div class="col-md-12">
Address
<br />
<input type="text" class='form-control' name="address" value="<?php echo $loc_info['address']; ?>" required />
</div>

<div class="col-md-6">
City
<br />
<input type="text" class='form-control' name="city" value="<?php echo $loc_info['city']; ?>" required />
</div>

<div class="col-md-6">
State
<br />
<input type="text" class='form-control' name="state" value="<?php echo $loc_info['state']; ?>" required />
</div>

<div class="col-md-6">
Country
<br />
<select class='form-control' name='country' id='edit_country' required>
<option value="">Select</option>
<?php
$countries = array("Afghanistan", "Albania", "Algeria", "American Samoa", "Andorra", "Angola", "Anguilla", "Antarctica", "Antigua and Barbuda", "Argentina", "Armenia", "Aruba", "Australia", "Austria", "Azerbaijan", "Bahamas", "Bahrain", "Bangladesh", "Barbados", "Belarus", "Belgium", "Belize", "Benin", "Bermuda", "Bhutan", "Bolivia", "Bosnia and Herzegowina", "Botswana", "Bouvet Island", "Brazil", "British Indian Ocean Territory", "Brunei Darussalam", "Bulgaria", "Burkina Faso", "Burundi", "Cambodia", "Cameroon", "Canada", "Cape Verde", "Cayman Islands", "Central African Republic", "Chad", "Chile", "China", "Christmas Island", "Cocos (Keeling) Islands", "Colombia", "Comoros", "Congo", "Congo, the Democratic Republic of the", "Cook Islands", "Costa Rica", "Cote d'Ivoire", "Croatia (Hrvatska)", "Cuba", "Cyprus", "Czech Republic", "Denmark", "Djibouti", "Dominica", "Dominican Republic", "East Timor", "Ecuador", "Egypt", "El Salvador", "Equatorial Guinea", "Eritrea", "Estonia", "Ethiopia", "Falkland Islands (Malvinas)", "Faroe Islands", "Fiji", "Finland", "France", "France Metropolitan", "French Guiana", "French Polynesia", "French Southern Territories", "Gabon", "Gambia", "Georgia", "Germany", "Ghana", "Gibraltar", "Greece", "Greenland", "Grenada", "Guadeloupe", "Guam", "Guatemala", "Guinea", "Guinea-Bissau", "Guyana", "Haiti", "Heard and Mc Donald Islands", "Holy See (Vatican City State)", "Honduras", "Hong Kong", "Hungary", "Iceland", "India", "Indonesia", "Iran (Islamic Republic of)", "Iraq", "Ireland", "Israel", "Italy", "Jamaica", "Japan", "Jordan", "Kazakhstan", "Kenya", "Kiribati", "Korea, Democratic People's Republic of", "Korea, Republic of", "Kuwait", "Kyrgyzstan", "Lao, People's Democratic Republic", "Latvia", "Lebanon", "Lesotho", "Liberia", "Libyan Arab Jamahiriya", "Liechtenstein", "Lithuania", "Luxembourg", "Macau", "Macedonia, The Former Yugoslav Republic of", "Madagascar", "Malawi", "Malaysia", "Maldives", "Mali", "Malta", "Marshall Islands", "Martinique", "Mauritania", "Mauritius", "Mayotte", "Mexico", "Micronesia, Federated States of", "Moldova, Republic of", "Monaco", "Mongolia", "Montserrat", "Morocco", "Mozambique", "Myanmar", "Namibia", "Nauru", "Nepal", "Netherlands", "Netherlands Antilles", "New Caledonia", "New Zealand", "Nicaragua", "Niger", "Nigeria", "Niue", "Norfolk Island", "Northern Mariana Islands", "Norway", "Oman", "Pakistan", "Palau", "Panama", "Papua New Guinea", "Paraguay", "Peru", "Philippines", "Pitcairn", "Poland", "Portugal", "Puerto Rico", "Qatar", "Reunion", "Romania", "Russian Federation", "Rwanda", "Saint Kitts and Nevis", "Saint Lucia", "Saint Vincent and the Grenadines", "Samoa", "San Marino", "Sao Tome and Principe", "Saudi Arabia", "Senegal", "Seychelles", "Sierra Leone", "Singapore", "Slovakia (Slovak Republic)", "Slovenia", "Solomon Islands", "Somalia", "South Africa", "South Georgia and the South Sandwich Islands", "Spain", "Sri Lanka", "St. Helena", "St. Pierre and Miquelon", "Sudan", "Suriname", "Svalbard and Jan Mayen Islands", "Swaziland", "Sweden", "Switzerland", "Syrian Arab Republic", "Taiwan, Province of China", "Tajikistan", "Tanzania, United Republic of", "Thailand", "Togo", "Tokelau", "Tonga", "Trinidad and Tobago", "Tunisia", "Turkey", "Turkmenistan", "Turks and Caicos Islands", "Tuvalu", "Uganda", "Ukraine", "United Arab Emirates", "United Kingdom", "United States of America", "United States Minor Outlying Islands", "Uruguay", "Uzbekistan", "Vanuatu", "Venezuela", "Vietnam", "Virgin Islands (British)", "Virgin Islands (U.S.)", "Wallis and Futuna Islands", "Western Sahara", "Yemen", "Yugoslavia", "Zambia", "Zimbabwe");

foreach($countries as $country)
{
?>
<option value='<?php echo $country ;?>'<?php echo (strtolower(trim($country)) == strtolower($loc_info['country'])) ? 'selected="selected"' : '' ?>><?php echo $country ; ?></option>
<?php }
?>
</select>
</div>

<div class="col-md-6">
Zipcode
<br />
<input type="text" class='form-control' name="zip" value="<?php echo $loc_info['zipcode']; ?>" required />
</div>

<div class="col-md-12">
Instructions / Comments
<br />
<textarea class='form-control' name='ins_comments' rows='5'><?php echo $loc_info['instructions_comments']; ?></textarea>
</div>
<!--  ************ Discount section  for courts starts here.  ************** -->
<?php
$checked_yes = ''; 
$checked_no	 = ''; 
if($loc_info['member_discount'] > 0){
$checked_yes = 'checked'; 
$display     = 'block';
}
else{
$checked_no = 'checked';
$display	= 'none';
}
?>

<div class="col-md-12">
Do you want to add discount for club members?  &nbsp;&nbsp;&nbsp;&nbsp;
<input type='radio' name='edit_is_discount' id='is_discount_yes' value='1' <?=$checked_yes;?> />&nbsp;Yes &nbsp;&nbsp;
<input type='radio' name='edit_is_discount' id='is_discount_no' value='0' <?=$checked_no;?> />&nbsp;No
<br/><br/>
</div>

<div class='form-group' id="edit_discount_div" style="display:<?=$display;?>">
   <label class='col-md-3' for='id_accomodation' style='margin-top: 7px;'>Discount in Percentage: </label>
   <div class='col-md-4 form-group internal'>
   <input class='form-control' id='edit_member_discount' name='edit_member_discount' style='width:30%;' type='number' max='100' value='<?=$loc_info['member_discount'];?>'/>&nbsp; 
   </div>
</div>

<!--  ************ Discount section  for courts starts here.  ************** -->

<!--  ************ Fee section  for courts starts here.  ************** -->
<div class="col-md-12">
Do you want to add your own Payment Gateway?  &nbsp;&nbsp;&nbsp;&nbsp;
<input type='radio' name='edit_court_fee' id='edit_court_fee_yes' value='1' <?php if($pay_info['payment_ref_id'] != 0){echo "checked";} ?>>&nbsp;Yes &nbsp;&nbsp;
<input type='radio' name='edit_court_fee' id='edit_court_fee_no' value='0' <?php if($pay_info['payment_ref_id'] == 0){echo "checked";} ?>>&nbsp;No
<br/><br/>
</div>
<div class='form-group' id="edit_court_pay_select">
     <label class='col-md-3' for='id_accomodation'>Select payment option:  </label>
       <div class='col-md-4 form-group internal'>
          <select class='form-control' name='edit_court_fee_paytype' id='edit_court_fee_paytype' class="form-control" >
			<option value=''>--Select--</option>
			<option value='paypal'>Paypal</option>
			<option value='paytm'>Paytm</option>
		  </select>
		</div>
</div>
<!--  *********************** Fee section  for courts Ends here.  *********************** -->
<!--************************* Paypal Details Section Starts Here. *********************** -->
<div id="edit_paypal_details" class="col-md-12 league-form-bg" style="display:none;">
	<div class="col-md-12" style="background: #f59123; color: #fff;
    font-size: 14px; font-weight: bold; padding: 5px; margin-bottom: 20px;">PayPal Details </div>
			<?php 
			$sel_ppids = courts :: get_selected_values($pay_info['payment_ref_id'],$pay_info['gateway_name'],$this->logged_user);?>
			<div id="edit_paypal_ids" style="display:none;">
			Paypal EmailID (Merchant):   
				<select name="edit_ppids" id="edit_ppids">
					<option value="">--Select--</option>
					<?php if($sel_ppids['pp_busi_id'] != '') {?>
					<option value="<?=$sel_ppids['pp_busi_id'];?>" 
							<?php echo ($pay_info['payment_ref_id'] == $sel_ppids['pp_busi_id']) ? 'selected' : '';?>><?=$sel_ppids['paypal_merch_id'];?>
					</option>
					<?php } else {
						foreach($paypal_ids as $ppids) { 
					?>
					<option value="<?=$ppids->pp_busi_id;?>"><?=$ppids->paypal_merch_id;?></option>	
					<?php } }?>
				</select>
				&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			<button type="button" name="edit_addppids" id="edit_addppids" class="btn btn-success" style="border-top: 0px solid #ddd; display:none;">Add New ID</button>  
			</div>

   	<div id="edit_ppYesNo" style="display:none;">
			<div class='form-group' style="margin-bottom:0px !important;">
				<label class='control-label col-md-3' for='id_accomodation'><font color='red'>* </font> Merchant ID </label>
				<div class='col-md-4 form-group internal'>
				<input class='form-control' id='edit_paypal_merchantid' name='edit_paypal_merchantid' type='text' />&nbsp; 
				</div>
				<div class="col-md-5">
				<img src="<?=base_url();?>icons/info_ico.png" title="Paypal Business Account EmailID " width="25px" height="25px" />
				</div>
			</div>

			<div class='form-group'>
			<label class='control-label col-md-3' for='id_accomodation'><font color='red'>* </font> Currency Type</label>
				<div class='col-md-8 form-group internal'>
					<?php $currency_codes = courts :: get_currency_codes();?>
					<select name="edit_currency_code" id="edit_currency_code" class='form-control' style='width:30%'>
					<option value="">--Select--</option>
					<?php foreach($currency_codes as $ccodes)	{ ?>
					<option value="<?=$ccodes->code;?>" <?php if($ccodes->code == 'USD'){ echo "selected"; } ?>><?=$ccodes->code;?></option>
					<?php } ?>
					</select>
				</div>
			</div>
 		</div> 
 	</div>  
	<!--************************* Paypal Details Section Ends Here. *********************** -->
	<!-- ************************* Paytm Details Section Starts Here. *********************** -->
	<div id="edit_paytm_details" class="col-md-12 league-form-bg" style="display:none;">
	<div class="col-md-12" style="background: #f59123; color: #fff;
    font-size: 14px; font-weight: bold; padding: 5px; margin-bottom: 20px;">Paytm Details </div>
	 
	<?php
			$sel_petmids = courts :: get_selected_values($pay_info['payment_ref_id'],$pay_info['gateway_name'],$this->logged_user);
	?>
			<div id="edit_paytm_ids" style="display:none;">
			Paytm ID (Merchant):   
				<select name="edit_ptmids" id="edit_ptmids">
					<option value="">--Select--</option>
						<?php if($sel_ppids['paytm_busi_id'] != '') {?>
						<option value="<?=$sel_petmids['pp_busi_id'];?>" 
							<?php echo ($pay_info['payment_ref_id'] == $sel_petmids['paytm_busi_id']) ? 'selected' : '';?>
							><?=$sel_petmids['paytm_merch_id'];?>
						</option>
					<?php } else {
						foreach($paytm_ids as $petmids) { 
					?>
					<option value="<?=$petmids->paytm_busi_id;?>"><?=$petmids->paytm_merch_id;?></option>	
					<?php } }?>
				</select>
				&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			<button type="button" name="edit_addptmids" id="edit_addptmids" class="btn btn-success" style="border-top: 0px solid #ddd; display:none;">Add New ID</button>  
			</div>

   	<div id="edit_peTmYesNo" style="display:none;">
			<div class='form-group' style="margin-bottom:0px !important;">
				<label class='control-label col-md-3' for='id_accomodation'><font color='red'>* </font> Merchant ID </label>
				<div class='col-md-4 form-group internal'>
				<input class='form-control' id='edit_paytm_merchantid' name='edit_paytm_merchantid' type='text' />&nbsp; 
				</div>
				<div class="col-md-5">
				<img src="<?=base_url();?>icons/info_ico.png" title="Paytm Business AccountID " width="25px" height="25px" />
				</div>
			</div>

			<div class='form-group' style="margin-bottom:0px !important;">
				<label class='control-label col-md-3' for='id_accomodation'><font color='red'>* </font> Merchant Key </label>
				<div class='col-md-4 form-group internal'>
				<input class='form-control' id='edit_merchantKey' name='edit_paytm_merchantKey' type='text' />&nbsp; 
				</div>
				<div class="col-md-5">
			<!--<img src="<?=base_url();?>icons/info_ico.png" title="Paytm Business Account EmailID " width="25px" height="25px" />-->
				</div>
			</div>

 		</div> 
 	</div>
<!-- ************************* Paytm Details Section Ends Here. ************************* -->
<!--  ************ Fees section  for courts ends here.    ************** -->

<input type="hidden" name="loc_id" value="<?php echo $loc_info['loc_id']; ?>" />
<div class="col-md-12" id="update_courts">
<input type="submit" id="submit_upd_location" name="submit_upd_location"  value=" Update " class="btn submit-btn" style="margin:20px 0px"/>&nbsp;&nbsp;
<input type="button" id="cancel_ed_location"	name="cancel_location"			value=" Cancel "  class="league-form-submit1"
style="margin:20px 0px"/>
</div>

<div class="col-md-12" id="update_courts_wait" style="display:none;">
<input type="botton"  value="PLEASE WAIT....." class="league-form-submit1" style="margin:20px 0px"/>
</div>
</form>

	<!-- 
	[loc_id] [int] IDENTITY(1,1) NOT NULL,
	[org_id] [int] NULL,
	[Users_id] [int] NULL,
	[location] [nvarchar](250) NULL,
	[address] [nvarchar](100) NULL,
	[city] [nvarchar](80) NULL,
	[state] [nvarchar](80) NULL,
	[country] [nvarchar](80) NULL,
	[zipcode] [nvarchar](15) NULL,
	[instructions_comments] [nvarchar](max) NULL,
	[court_image] [nvarchar](150) NULL,
	[longitude] [float] NULL,
	[latitude] [float] NULL,
	[created_on] [datetime] NULL,
	[modified_on] [datetime] NULL,
	[status] [bit] NULL, 
	-->

<!-- ********************** JQuery Code Of Fee Section Starts Here *********************** -->

<?php if(($pay_info['payment_ref_id'] != 0) and ($loc_info['country'] == 'India')) {
//echo "test"; exit;
?>
<script>
$('#edit_court_pay_select').show();
</script>
<?php } else { ?>
<script>
$('#edit_court_pay_select').hide();
$('#edit_court_fee_paytype').val('paypal');
</script><?php } ?>



<script>
$(document).ready(function(){

	var fee_status_value;
		fee_status_value = "<?php if($pay_info['payment_ref_id'] != 0 || $pay_info['payment_ref_id'] != NULL) { echo '1'; } else { echo '0'; } ?>";

	var fee_val = $("input[name='fee_per_hour[]']").map(function(){
			return $(this).val();}).get();


		if(fee_status_value == 0){
			$('#edit_court_fee_no').trigger('click');
		}

});
</script>

<!-- ********************** JQuery Code Of Fee Section Ends Here *********************** -->

<script>
var i=0;

	function show_dialog(text, button1, callback1, button2, callback2, btn) {
		  var buttons = {};
		  buttons[button1] = function() {
				$(this).dialog('close');
				if (callback1) {
					  callback1(btn);
				}
		  };
		  buttons[button2] = function() {
				$(this).dialog('close');
				if (callback2) {
					  callback2(btn);
				}
		  };
		  $('#dialog-confirm').html(text).dialog({buttons: buttons, modal: true});
	}

	function yes_apply(tbl_id) {
		i++;
		// default values
		var edit_sun_val = 'n/a';		var edit_mon_val = 'n/a';		var edit_tue_val = 'n/a';		var edit_wed_val = 'n/a';
		var edit_thu_val = 'n/a';		var edit_fri_val = 'n/a';		var edit_sat_val = 'n/a';

		var edit_addn_sun_val = 'n/a';		var edit_addn_mon_val = 'n/a';		var edit_addn_tue_val = 'n/a';		var edit_addn_wed_val = 'n/a';
		var edit_addn_thu_val = 'n/a';		var edit_addn_fri_val = 'n/a';		var edit_addn_sat_val = 'n/a';

		var edit_stTime = $('#edit_stime_'+tbl_id).val();
		var edit_edTime = $('#edit_etime_'+tbl_id).val();

		if($('#edit_sun_'+tbl_id).val() != '')			var edit_sun_val = $('#edit_sun_'+tbl_id).val();
		if($('#edit_mon_'+tbl_id).val() != '')			var edit_mon_val = $('#edit_mon_'+tbl_id).val();
		if($('#edit_tue_'+tbl_id).val() != '')			var edit_tue_val = $('#edit_tue_'+tbl_id).val();
		if($('#edit_wed_'+tbl_id).val() != '')			var edit_wed_val = $('#edit_wed_'+tbl_id).val();
		if($('#edit_thu_'+tbl_id).val() != '')			var edit_thu_val = $('#edit_thu_'+tbl_id).val();
		if($('#edit_fri_'+tbl_id).val() != '')			var edit_fri_val = $('#edit_fri_'+tbl_id).val();
		if($('#edit_sat_'+tbl_id).val() != '')			var edit_sat_val = $('#edit_sat_'+tbl_id).val();

		if($('#edit_addn_sun_'+tbl_id).val() != '')			var edit_addn_sun_val = $('#edit_addn_sun_'+tbl_id).val();
		if($('#edit_addn_mon_'+tbl_id).val() != '')		var edit_addn_mon_val = $('#edit_addn_mon_'+tbl_id).val();
		if($('#edit_addn_tue_'+tbl_id).val() != '')			var edit_addn_tue_val = $('#edit_addn_tue_'+tbl_id).val();
		if($('#edit_addn_wed_'+tbl_id).val() != '')		var edit_addn_wed_val = $('#edit_addn_wed_'+tbl_id).val();
		if($('#edit_addn_thu_'+tbl_id).val() != '')			var edit_addn_thu_val = $('#edit_addn_thu_'+tbl_id).val();
		if($('#edit_addn_fri_'+tbl_id).val() != '')			var edit_addn_fri_val = $('#edit_addn_fri_'+tbl_id).val();
		if($('#edit_addn_sat_'+tbl_id).val() != '')			var edit_addn_sat_val = $('#edit_addn_sat_'+tbl_id).val();


		if(edit_stTime == '' || edit_edTime == ''){
			//alert('Please select Start & End Timings');
			return false;
		}
		else{
		//$('#show_timings_'+btn_id).show();
			for (j = 0; j < court_count; j++) {
				$('#edit_show_timings_'+j).show();

				$('#edit_timings_table_'+j).append('<tr id="edit_row_'+i+'"><td>'+edit_stTime+'<input type ="hidden" name="stTime_'+j+'[]" value="'+edit_stTime+'" /></td><td>'+edit_edTime+'<input type ="hidden" name="edTime_'+j+'[]" value="'+edit_edTime+'" /></td><td>'+edit_sun_val+'<input type ="hidden" name="sunPrice_'+j+'[]" value="'+edit_sun_val+'" /></td><td>'+edit_mon_val+'<input type ="hidden" name="monPrice_'+j+'[]" value="'+edit_mon_val+'" /></td><td>'+edit_tue_val+'<input type ="hidden" name="tuePrice_'+j+'[]" value="'+edit_tue_val+'" /></td><td>'+edit_wed_val+'<input type ="hidden" name="wedPrice_'+j+'[]" value="'+edit_wed_val+'" /></td><td>'+edit_thu_val+'<input type ="hidden" name="thuPrice_'+j+'[]" value="'+edit_thu_val+'" /></td><td>'+edit_fri_val+'<input type ="hidden" name="friPrice_'+j+'[]" value="'+edit_fri_val+'" /></td><td>'+edit_sat_val+'<input type ="hidden" name="satPrice_'+j+'[]" value="'+edit_sat_val+'" /></td><td><input type="button" name="edit_del_timings" id="'+i+'" value="Delete" class="league-form-submit1 edit_btn_remove" style="width: 90%;height: 100%; margin-left: 5px;"></td></tr>');

				$('#edit_timings_table_'+j).append('<tr id="edit_row_addn_'+i+'"><td colspan="2">Additional fee per player</td><td>'+edit_addn_sun_val+'<input type ="hidden" name="sunAddnPrice_'+j+'[]" value="'+edit_addn_sun_val+'" /></td><td>'+edit_addn_mon_val+'<input type ="hidden" name="monAddnPrice_'+j+'[]" value="'+edit_addn_mon_val+'" /></td><td>'+edit_addn_tue_val+'<input type ="hidden" name="tueAddnPrice_'+j+'[]" value="'+edit_addn_tue_val+'" /></td><td>'+edit_addn_wed_val+'<input type ="hidden" name="wedAddnPrice_'+j+'[]" value="'+edit_addn_wed_val+'" /></td><td>'+edit_addn_thu_val+'<input type ="hidden" name="thuAddnPrice_'+j+'[]" value="'+edit_addn_thu_val+'" /></td><td>'+edit_addn_fri_val+'<input type ="hidden" name="friAddnPrice_'+j+'[]" value="'+edit_addn_fri_val+'" /></td><td>'+edit_addn_sat_val+'<input type ="hidden" name="satAddnPrice_'+j+'[]" value="'+edit_addn_sat_val+'" /></td><td>&nbsp;</td></tr>');

				$('#edit_stime_'+j).val(''); $('#edit_etime_'+j).val(''); $('#edit_sun_'+j).val(''); $('#edit_mon_'+j).val(''); $('#edit_tue_'+j).val(''); $('#edit_wed_'+j).val(''); $('#edit_thu_'+j).val(''); $('#edit_fri_'+j).val(''); $('#edit_sat_'+j).val('');
			}
		}
	}

	function no_apply(tbl_id) {
		i++;
		// default values
		var edit_sun_val = 'n/a'; var edit_mon_val = 'n/a'; var edit_tue_val = 'n/a'; var edit_wed_val = 'n/a'; 
		var edit_thu_val = 'n/a'; var edit_fri_val = 'n/a'; var edit_sat_val = 'n/a';

		var edit_addn_sun_val = 'n/a'; var edit_addn_mon_val = 'n/a'; var edit_addn_tue_val = 'n/a'; var edit_addn_wed_val = 'n/a'; 
		var edit_addn_thu_val = 'n/a'; var edit_addn_fri_val = 'n/a'; var edit_addn_sat_val = 'n/a';

		var edit_stTime = $('#edit_stime_'+tbl_id).val();
		var edit_edTime = $('#edit_etime_'+tbl_id).val();

		if($('#edit_sun_'+tbl_id).val() != '') var edit_sun_val = $('#edit_sun_'+tbl_id).val();
		if($('#edit_mon_'+tbl_id).val() != '') var edit_mon_val = $('#edit_mon_'+tbl_id).val();
		if($('#edit_tue_'+tbl_id).val() != '') var edit_tue_val = $('#edit_tue_'+tbl_id).val();
		if($('#edit_wed_'+tbl_id).val() != '') var edit_wed_val = $('#edit_wed_'+tbl_id).val();
		if($('#edit_thu_'+tbl_id).val() != '') var edit_thu_val = $('#edit_thu_'+tbl_id).val();
		if($('#edit_fri_'+tbl_id).val() != '') var edit_fri_val = $('#edit_fri_'+tbl_id).val();
		if($('#edit_sat_'+tbl_id).val() != '') var edit_sat_val = $('#edit_sat_'+tbl_id).val();

		if($('#edit_addn_sun_'+tbl_id).val() != '') var edit_addn_sun_val = $('#edit_addn_sun_'+tbl_id).val();
		if($('#edit_addn_mon_'+tbl_id).val() != '') var edit_addn_mon_val = $('#edit_addn_mon_'+tbl_id).val();
		if($('#edit_addn_tue_'+tbl_id).val() != '') var edit_addn_tue_val = $('#edit_addn_tue_'+tbl_id).val();
		if($('#edit_addn_wed_'+tbl_id).val() != '') var edit_addn_wed_val = $('#edit_addn_wed_'+tbl_id).val();
		if($('#edit_addn_thu_'+tbl_id).val() != '') var edit_addn_thu_val = $('#edit_addn_thu_'+tbl_id).val();
		if($('#edit_addn_fri_'+tbl_id).val() != '') var edit_addn_fri_val = $('#edit_addn_fri_'+tbl_id).val();
		if($('#edit_addn_sat_'+tbl_id).val() != '') var edit_addn_sat_val = $('#edit_addn_sat_'+tbl_id).val();


		if(edit_stTime == '' || edit_edTime == ''){
			//alert('Please select Start & End Timings');
			return false;
		}
		else{
		//$('#show_timings_'+btn_id).show();

			$('#edit_show_timings_'+tbl_id).show();

			$('#edit_timings_table_'+tbl_id).append('<tr id="edit_row_'+i+'"><td>'+edit_stTime+'<input type ="hidden" name="stTime_'+tbl_id+'[]" value="'+edit_stTime+'" /></td><td>'+edit_edTime+'<input type ="hidden" name="edTime_'+tbl_id+'[]" value="'+edit_edTime+'" /></td><td>'+edit_sun_val+'<input type ="hidden" name="sunPrice_'+tbl_id+'[]" value="'+edit_sun_val+'" /></td><td>'+edit_mon_val+'<input type ="hidden" name="monPrice_'+tbl_id+'[]" value="'+edit_mon_val+'" /></td><td>'+edit_tue_val+'<input type ="hidden" name="tuePrice_'+tbl_id+'[]" value="'+edit_tue_val+'" /></td><td>'+edit_wed_val+'<input type ="hidden" name="wedPrice_'+tbl_id+'[]" value="'+edit_wed_val+'" /></td><td>'+edit_thu_val+'<input type ="hidden" name="thuPrice_'+tbl_id+'[]" value="'+edit_thu_val+'" /></td><td>'+edit_fri_val+'<input type ="hidden" name="friPrice_'+tbl_id+'[]" value="'+edit_fri_val+'" /></td><td>'+edit_sat_val+'<input type ="hidden" name="satPrice_'+tbl_id+'[]" value="'+edit_sat_val+'" /></td><td><input type="button" name="edit_del_timings" id="'+i+'" value="Delete" class="league-form-submit1 edit_btn_remove" style="width: 90%;height: 100%; margin-left: 5px;"></td></tr>');

			$('#edit_timings_table_'+tbl_id).append('<tr id="edit_row_addn_'+i+'"><td colspan="2">Additional fee per player</td><td>'+edit_addn_sun_val+'<input type ="hidden" name="sunAddnPrice_'+tbl_id+'[]" value="'+edit_addn_sun_val+'" /></td><td>'+edit_addn_mon_val+'<input type ="hidden" name="monAddnPrice_'+tbl_id+'[]" value="'+edit_addn_mon_val+'" /></td><td>'+edit_addn_tue_val+'<input type ="hidden" name="tueAddnPrice_'+tbl_id+'[]" value="'+edit_addn_tue_val+'" /></td><td>'+edit_addn_wed_val+'<input type ="hidden" name="wedAddnPrice_'+tbl_id+'[]" value="'+edit_addn_wed_val+'" /></td><td>'+edit_addn_thu_val+'<input type ="hidden" name="thuAddnPrice_'+tbl_id+'[]" value="'+edit_addn_thu_val+'" /></td><td>'+edit_addn_fri_val+'<input type ="hidden" name="friAddnPrice_'+tbl_id+'[]" value="'+edit_addn_fri_val+'" /></td><td>'+edit_addn_sat_val+'<input type ="hidden" name="satAddnPrice_'+tbl_id+'[]" value="'+edit_addn_sat_val+'" /></td><td>&nbsp;</td></tr>');

			$('#edit_stime_'+tbl_id).val(''); $('#edit_etime_'+tbl_id).val(''); $('#edit_sun_'+tbl_id).val(''); $('#edit_mon_'+tbl_id).val(''); $('#edit_tue_'+tbl_id).val(''); $('#edit_wed_'+tbl_id).val(''); $('#edit_thu_'+tbl_id).val(''); $('#edit_fri_'+tbl_id).val(''); $('#edit_sat_'+tbl_id).val('');
		}
	}


	$(document).on('click','.add_timings2',function(){
		i++;
		var tbl_id = $(this).attr('id');
		show_dialog('Do you want to apply this Pricing for all the Courts?', 'Yes', yes_apply, 'No', no_apply, tbl_id);
	});
//	});
		
		$('#edit_etime').change(function(){
			var edit_valuestart = $("#edit_stime").val();
			var edit_valuestop = $("#edit_etime").val();
			var edit_timeStart = new Date("01/01/2007 " + edit_valuestart).getHours();
			var edit_timeEnd = new Date("01/01/2007 " + edit_valuestop).getHours();
			var edit_hourDiff = edit_timeEnd - edit_timeStart;  
			  if(edit_hourDiff < 0){
				alert('End time must be greater than Start time.');
				$("#edit_stime_"+tbl_id, "#edit_etime_"+tbl_id).val('');
				return false;
			  }else{ return true; }
		});

	$(document).on('click', '.edit_btn_remove', function(){  
	   var button_id = $(this).attr("id");   
	   // $('#edit_row_'+button_id).hide();  

	   var rowCount = $('#edit_timings_table_ tr').not('thead tr').length;
	   if(rowCount == 1 && button_id == 1){
			$('#edit_show_timings_').hide();
			$('#edit_timings_table_').hide();
	   }
	   else{
		   $('#edit_row_'+button_id).remove();  
		   $('#edit_row_addn_'+button_id).remove();  
	   }
    });

	$("[name=edit_is_discount]").click(function(){
		var dis = $(this).val();

		if(dis == 1){
			$('#edit_discount_div').show();
		}
		else{
			$('#edit_discount_div').hide();
		}
	});

			$("[name=edit_court_fee]").click(function(){
			var radio_val = $(this).val();
			var country_val = $('#edit_country').val();

			if(radio_val == 0){
				$('#edit_paypal_details').hide();
				$('#edit_paytm_details').hide();
				$('#edit_court_pay_select').hide();
			}

			if(radio_val == 1 && country_val != 'India'){
				$('#edit_paypal_details').show();
				$('#edit_paypal_ids').show();
				$('#edit_addppids').show();
				$('#edit_ppYesNo').hide();
			}

			if(radio_val == 1 && country_val == 'India'){
				$('#edit_court_pay_select').show();
				$('#edit_paypal_details').hide();
			}

			$("#edit_addppids").click(function (){
				$('#edit_paypal_ids').hide();
				$('#edit_ppYesNo').show();
			});

			$("#edit_addptmids").click(function (){
				$('#edit_paytm_ids').hide();
				$('#edit_peTmYesNo').show();
			});

		$("#edit_court_fee_paytype").change(function(){
			var opt_val = $(this).val();
			if(opt_val == 'paypal'){
				$('#edit_paypal_ids').show();
				$('#edit_addppids').show();
				$('#edit_paypal_details').show();
				$('#edit_paytm_details').hide();
				$('#edit_ppYesNo').hide();
			}
			else if(opt_val == 'paytm'){
				$('#edit_paytm_ids').show();
				$('#edit_addptmids').show();
				$('#edit_paypal_details').hide();
				$('#edit_paytm_details').show();
				$('#edit_peTmYesNo').hide();
			}
			else if(opt_val == ''){
				$('#edit_paytm_details').hide();
				$('#edit_paypal_details').hide();
			}
		
		});

		$('#edit_country').change(function(){
			$('#edit_court_fee_no').trigger('click');
			$('#edit_court_fee_paytype').val('');
		});

		});

</script>
<?php
//if($pay_info['gateway_name'] == 'paypal' or $pay_info['gateway_name'] == 'paytm'){
?>
<script>
$(document).ready(function(){
	//alert('test');
	var gateway_select = "<?php echo $pay_info['gateway_name']; ?>";

	if(gateway_select != ''){
	$('#edit_court_fee_yes').trigger('click');
	$('#edit_court_fee_paytype').val(gateway_select).trigger('change');
	}
});
	$(document).ready(function(){
		$('.addn_fee_all').prop('disabled', true);
	});

</script>
<?php
//}
?>