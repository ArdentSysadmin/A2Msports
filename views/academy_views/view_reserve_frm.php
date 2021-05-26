<!-- Reservation Block -->
<form id='frm_reserve' name='frm_reserve' method='post' action='<?php echo base_url().$this->short_code."/courts/block_court" ?>'>
<!-- <div class='col-md-6 form-group internal'>
<select name="loc_id" id="location" class='form-control check_price' required>
<option value=''>Select Location</option>
</select>
</div> -->

<input type='hidden' name='loc_id' id='loc_id' value='<?php echo $loc_id; ?>' />
<div class='col-md-6 form-group internal'>
<img src='<?php echo base_url();?>images/ajax_loader.gif' width='30px' height='40px' id='loading' style="display:none;" align="middle" />
<select name="court" id="court1" class='form-control check_price get_durations' required>
<option value=''>Select Court</option>
<?php
foreach($get_courts as $cr){
		$selected = "";
	if($court == $cr->court_id)
		$selected = "selected";

	echo "<option value='$cr->court_id' {$selected}>$cr->court_name</option>";
}
?>
</select>
</div>
<!-- ************************* New Date Format Starts Here. **************************** -->
 <!-- <div class='col-md-6 form-group internal'>
	<div class='input-group date'>
		 <input type="text" class='form-control custom_date' placeholder="MM/DD/YYYY" id="custom_res_date" name="res_date" maxlength="10" value="<?=$date;?>" required /> 
			<span class="input-group-addon custom_datepicker check_price" id='res_date' style="cursor:pointer;">
				<span class="fa fa-calendar"></span> 
			</span>
	</div>
</div> -->
<!-- ************************ New Date Format Ends Here.   ***************************** -->
<?php
$time = $time-1;
$tm   = ($time % 2 == 0) ? ($time/2).":00" : (($time-1)/2).":30";
?>
<div class='col-md-6 form-group internal'>
<input type="text" name="res_date" id="res_date1" class='form-control check_price' 
value="<?=date('m/d/Y H:i', strtotime($date." ".$tm));?>" placeholder='Select Start Date/Time' required />
</div>
<div class='col-md-6 form-group internal'>
<select name="book_hours" id="book_hours1" class='form-control check_price' required>
	<option value=''>Duration</option>
	<?php
			for($hr =1; $hr <= $max_hours; $hr++){
				if($hr == 1)
				echo "<option value='$hr'>$hr hour</option>";
				if($hr > 1)
				echo "<option value='$hr'>$hr hours</option>";
			}
	?>
</select>
</div>
<div class='col-md-6 form-group internal'>
<select name="match_format" id="match_format1" class='form-control' required>
	<option value=''>Game Format</option>
	<option value='Singles'>Singles</option>
	<option value='Doubles'>Doubles</option>
	<option value='Mixed'>Mixed Doubles</option>
	<option value='Training'>Training</option>
</select>
</div>
<div class='col-md-6 form-group internal'>
<select name="num_players" id="num_players1" class='form-control' required>
	<option value=''>Players#</option>
	<option value='1'>1</option>
	<option value='2'>2</option>
	<option value='3'>3</option>
	<option value='4'>4</option>
	<option value='5'>5</option>
	<option value='6'>6</option>
</select>
</div>
<?php if($this->logged_user == $this->academy_admin){ ?>
<div class='col-md-6 form-group internal'>
<input type='checkbox' name='block_all_day' id='block_all_day1' value='1' /> Block all day?
</div>
<?php } ?>
<div class='col-md-12 form-group internal' id='players_section1'></div>
<div class='col-md-6 form-group internal'>
Booking Price: <span id='book_price1'></span>
<input type='hidden' name='book_price_val' id='book_price_val1' value='' />
</div>
<div class='col-md-6 form-group internal'>
<!-- <input type="button" id="reserve_check" name="reserve_check" value="Check Availability" class="league-form-submit1" style="margin:20px 0px"/> -->
<input type="submit" id="reserve_submit1" name="reserve_submit" value="Book" class="book-submit" style="margin:20px 0px;"/>
<!-- &nbsp;&nbsp;&nbsp;
<input type="button" id="reserve_cancel1" name="reserve_cancel" value="Cancel" class="league-form-submit1" style="margin:20px 0px"/> -->
</div>
</form>
<!-- Reservation Block -->

<!-- <script src="<?=base_url();?>js/jquery-1.10.2.js" type="text/javascript"></script>
 -->
<!-- <script type="text/javascript" src="<?php echo base_url(); ?>js/jquery.simple-dtpicker.js"></script> -->
<script>

		/*$('*[name=res_date]').appendDtpicker({
			"inline": false,
			"futureOnly": true,
			"autodateOnStart": false,
			"dateFormat": "MM/DD/YYYY h:m",
			"closeOnSelected": true
		});*/

				//$('#reserve_check').on('click',function(){
	$('.check_price').change(function(e){
		var loc_id	  = "<?php echo $loc_id; ?>";
		var court_id  = $('#court1').val();
		var res_date  = $('#res_date1').val();
		var hrs		  = $('#book_hours1').val();
		//$.get_court_durations(loc_id, court_id);
	//alert(court_id);

		if(loc_id && court_id && res_date && hrs){
	//alert('test');
			$.ajax({
				type: 'POST',
				url:baseurl+short_code+'/courts/check_court_availability/',
				//data: $('#frm_reserve').serialize(),
				data: {loc_id:loc_id, court:court_id, res_date:res_date, book_hours:hrs},
				success: function(res) {
					//alert(res);
					var x = res.split('_');
					if(x[0] == 1 && x[1] != -1){
						$('#book_price1').html(x[1]);
						$('#book_price_val1').val(x[1]);
						//$('#reserve_submit').show();
						//alert('Court is available. Please click on Reserve Court to confirm.');
						//location.reload();
						//var onlyDate = res_date.split(' ');
						//var newdate = onlyDate[0].split("/").reverse().join("-");
						 //window.location.href = baseurl+short_code+"/courts/reserve/"+newdate;
					}
					else if(res == 2){
						alert('Court booking time exceeding to the next day!');
						$('#book_price1').html('N/A');
						$('#book_price_val1').val('');
					}
					else if(res == 0){
						alert("Court is already reserved!");
						$('#book_price1').html('N/A');
						$('#book_price_val1').val('');
					}
					else if(res == 3){
						alert("Court is not available for this timing!");
						$('#book_price1').html('N/A');
						$('#book_price_val1').val('');
					}
					else if(x[1] == -1){
						alert("Court is not available for this timing!");
						$('#book_price1').html('N/A');
						$('#book_price_val1').val('');
					}
				}
			});
			e.preventDefault();
		}
	});

	$('#reserve_cancel1').click(function(){
		$(this).closest('#show_reserve_frm').dialog('close'); 
	});

	$(document).on('click', '#reserve_submit1', function(){

		if($('#book_price_val1').val() == ''){
			alert('Selected booking slot is N/A');
			return false;
		}
	});

	$('#block_all_day1').click(function(){
		var ba = $(this).prop("checked");
		//alert(ba);
		if(ba){
			$("#book_hours1").removeAttr('required');
			$("#match_format1").removeAttr('required');
			$("#num_players1").removeAttr('required');
			$("#book_price1").html('0.00');
			$("#book_price_val1").val('0.00');
		}
		else{
			$("#book_hours1").prop('required',true);
			$("#match_format1").prop('required',true);
			$("#num_players1").prop('required',true);
		}
	});

</script>
<script src="<?php echo base_url(); ?>js/jquery.datetimepicker.full.js"></script>
<script>
/*jslint browser:true*/
/*global jQuery, document*/

$(document).ready(function () {
	'use strict';

	$('#res_date1, #search-from-date, #search-to-date').datetimepicker();

});
</script>