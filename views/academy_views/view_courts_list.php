<script>
$(document).ready(function(){
	$('#court_res_download').click(function(){
		var chk_count = $('input[name="sel_loc_ids[]"]:checked').length;
		if(chk_count > 0){
				
				$.ajax({
				url: '/export/court_reservations',
				type: "post",
				data:{},
				success: function(res) {
					//$('#response').html(data);
					alert('Done');
				//	location.reload();
				}
				});
		}
		else
			alert("Select location");
	});

	$("#add_court").click(function(){
		$("#div_add_court").show();
		$("#div_court_list").hide();
		$(".fromtitle").html('Add Court Details');
	});

	$("#cancel_location").click(function(){
		$("#div_add_court").hide();
		$("#div_court_list").show();
		$(".fromtitle").html('Court Details');
	});

	$("[name=is_chargable]").click(function(){
		if($("#chargable").css('display') == 'none'){
		 $("#chargable").css('display', 'block');
		}else{
		 $("#chargable").css('display', 'none');
		}
	});

	/*$('.form-control').focus(function(){
		if($(this).val() == 'n/a'){
			$(this).val('');
		}
	});*/

	$("#court_num").change(function () {

		var count = $("#dyn_courts .div_grp").size();
		var requested = parseInt($("#court_num").val(), 10);

		if (requested > count) {
			for (i = count; i < requested; i++) {
				var $ctrl = $("<div class='col-md-12 div_grp' style='padding-bottom:4px;'><div class='col-md-3'><input type='text' class='form-control' name='courts[]' placeholder='Court Name/#"+(i+1)+"' value='Court "+(i+1)+"' /></div><div class='col-md-3'><select name='slot_duration[]' class='form-control'><option value=''>Select</option><option value='0.50'>30 Mins</option><option value='0.75'>45 Mins</option><option value='1'>1 Hour</option></select></div><div class='col-md-2'><input type='number' class='form-control' name='min_book_hours[]' placeholder='Min Book Sessions' value='1' max='10' /></div><div class='col-md-2'><input type='number' class='form-control' name='max_book_hours[]' placeholder='Max Book Sessions' value='2' max='10' /></div><div class='col-md-2'><input type='number' class='form-control' name='max_num_players[]' placeholder='Max Players' value='4' max='10' /><br/></div><div class='col-md-3'>Sharable Resource? <input type='checkbox' name='is_sharable_"+(i+1)+"' id='isr_"+(i+1)+"' value='1' /></div><div class='col-md-3'>Allow multiple bookings per day? <input type='checkbox' name='is_multi_bookings"+(i+1)+"' id='imb_"+(i+1)+"' value='1' /></div><div class='col-md-3'>Allow same day booking? <input type='checkbox' name='same_day_booking"+(i+1)+"' id='sdb_"+(i+1)+"' value='1' checked /></div><div class='col-md-3'>Max. Advance booking days&nbsp;<input type='number' style='width:30%' name='max_days_adv_bookings"+(i+1)+"'' id='mab_"+(i+1)+"' value='30' /></div></div><div class='col-md-12' id='court_peakcharges_"+i+"'><div class='col-md-2'>Start Time<br/><select class='form-control' name='stime' id='stime_"+i+"' style='width: 108%; !important'><option value=''>Select</option><option value='05:00:00'>5:00 am</option><option value='06:00:00'>6:00 am</option><option value='07:00:00'>7:00 am</option><option value='08:00:00'>8:00 am</option><option value='09:00:00'>9:00 am</option><option value='10:00:00'>10:00 am</option><option value='11:00:00'>11:00 am</option><option value='12:00:00'>12:00 pm</option><option value='13:00:00'>1:00 pm</option><option value='14:00:00'>2:00 pm</option><option value='15:00:00'>3:00 pm</option><option value='16:00:00'>4:00 pm</option><option value='17:00:00'>5:00 pm</option><option value='18:00:00'>6:00 pm</option><option value='19:00:00'>7:00 pm</option><option value='20:00:00'>8:00 pm</option><option value='21:00:00'>9:00 pm</option><option value='22:00:00'>10:00 pm</option></select></div><div class='col-md-2'>End Time <br/><select class='form-control' name='etime' id='etime_"+i+"' style='width: 108%; !important'><option value=''>Select</option><option value='06:00:00'>6:00 am</option><option value='07:00:00'>7:00 am</option><option value='08:00:00'>8:00 am</option><option value='09:00:00'>9:00 am</option><option value='10:00:00'>10:00 am</option><option value='11:00:00'>11:00 am</option><option value='12:00:00'>12:00 pm</option><option value='13:00:00'>1:00 pm</option><option value='14:00:00'>2:00 pm</option><option value='15:00:00'>3:00 pm</option><option value='16:00:00'>4:00 pm</option><option value='17:00:00'>5:00 pm</option><option value='18:00:00'>6:00 pm</option><option value='19:00:00'>7:00 pm</option><option value='20:00:00'>8:00 pm</option><option value='21:00:00'>9:00 pm</option><option value='22:00:00'>10:00 pm</option><option value='23:00:00'>11:00 pm</option></select></div><div class='col-md-1'>Sun <br/><input class='form-control' type='text' name='sun' id='sun_"+i+"' value='' placeholder='n/a' style='width:150%; height:100%;'></div><div class='col-md-1'>Mon <br/><input class='form-control' type='text' name='mon' id='mon_"+i+"' value='' placeholder='n/a' style='width:150%; height:100%;'></div><div class='col-md-1'>Tue <br/><input class='form-control' type='text' name='tue' id='tue_"+i+"' value='' placeholder='n/a' style='width:150%; height:100%;'></div><div class='col-md-1'>Wed <br/><input class='form-control' type='text' name='wed' id='wed_"+i+"' value='' placeholder='n/a' style='width:150%; height:100%;'></div><div class='col-md-1'>Thu <br/><input class='form-control' type='text' name='thu' id='thu_"+i+"' value='' placeholder='n/a' style='width:150%; height:100%;'></div><div class='col-md-1'>Fri <br/><input class='form-control' type='text' name='fri' id='fri_"+i+"' value='' placeholder='n/a' style='width:150%; height:100%;'></div><div class='col-md-1'>Sat <br/><input class='form-control' type='text' name='sat' id='sat_"+i+"' value='' placeholder='n/a' style='width:150%; height:100%;'><br/><br/></div><div class='col-md-1'><br/><input type='button' name='add_timings' id='"+i+"' value='Add' class='league-form-submit1 add_timings' style='width:125%; height:100%;'></div><div class='col-md-4'>Add Additional player fee? <input type='checkbox' name='add_addn_fee' id='ad_"+i+"' class='add_addn_fee' value='1' /><br /></div><div class='col-md-1'><input class='form-control addn_fee_"+i+" addn_fee_all' type='text' name='addn_sun' id='addn_sun_"+i+"' value='' placeholder='n/a' style='width:150%; height:100%;'></div><div class='col-md-1'><input class='form-control addn_fee_"+i+" addn_fee_all' type='text' name='addn_mon' id='addn_mon_"+i+"' value='' placeholder='n/a' style='width:150%; height:100%;'></div><div class='col-md-1'><input class='form-control addn_fee_"+i+" addn_fee_all' type='text' name='addn_tue' id='addn_tue_"+i+"' value='' placeholder='n/a' style='width:150%; height:100%;'></div><div class='col-md-1'><input class='form-control addn_fee_"+i+" addn_fee_all' type='text' name='addn_wed' id='addn_wed_"+i+"' value='' placeholder='n/a' style='width:150%; height:100%;'></div><div class='col-md-1'><input class='form-control addn_fee_"+i+" addn_fee_all' type='text' name='addn_thu' id='addn_thu_"+i+"' value='' placeholder='n/a' style='width:150%; height:100%;'></div><div class='col-md-1'><input class='form-control addn_fee_"+i+" addn_fee_all' type='text' name='addn_fri' id='addn_fri_"+i+"' value='' placeholder='n/a' style='width:150%; height:100%;'></div><div class='col-md-1'><input class='form-control addn_fee_"+i+" addn_fee_all' type='text' name='addn_sat' id='addn_sat_"+i+"' value='' placeholder='n/a' style='width:150%; height:100%;'><br/><br/></div><div class='col-md-1'>&nbsp;</div></div>	<div class='col-md-12 timing-table' id='show_timings_"+i+"' style='display:none; margin-top: 0px;'><table name='timings_table' id='timings_table_"+i+"' width='' class='score-cont tab-score'><tr><th>Start Time</th><th>End Time</th><th>Sunday</th><th>Monday</th><th>Tuesday</th><th>Wednesday</th><th>Thursday</th><th>Friday</th><th>Saturday</th><th>&nbsp;</th></tr></table><br/></div></div>");


				
				$("#dyn_courts").append($ctrl);
				$('.addn_fee_all').prop('disabled', true);
//				$('#dynamic_startEndDates_Fees').append($ctrl1);
	
			}
		} else if (requested < count) {
			var x = requested - 1;
			//alert(x);
			$("#dyn_courts .div_grp:gt(" + x + ")").remove();
		}
	});


/*	$("#myform").validate(
	{
	ignore: [],
	debug: false,
	rules: { 

	description:{
	required: function() 
	{
		CKEDITOR.instances.description.updateElement();
	},

	minlength:10
	}
	},
	messages:
	{
		description:{
		required:"Please enter Text",
		minlength:"Please enter 10 characters"
		}
	}
	});
*/

$('.ed_court').on('touchstart click', function(){
	var loc_id		= $(this).attr('name');
	var baseurl		= "<?php echo base_url();?>";
	var short_code	= "<?php echo $this->short_code;?>";
//alert(loc_id);
	if(loc_id != ""){
		$.ajax({
			type:'POST',
			url:baseurl+short_code+'/courts/get_loc_info',
			data:{ loc_id:loc_id},    //{pt:'7',rngstrt:range1, rngfin:range2},
			success:function(res){
				 $("#div_add_court").hide();
				 $("#div_court_list").hide();
				 $("#div_edit_court").show();
				 $("#div_edit_court").html(res);
				 $(".fromtitle").html('Edit Court Details');
				 //$( "div_edit_court" ).removeClass( "col-md-12" ).addClass( "section-border" );

			}
		}); 
	}
});

	$('#courts_add_form').submit(function(){
		$('#add_courts').hide();
		$('#add_courts_wait').show();
	});

});
</script>
<!-- Breadcromb Wrapper Start -->
<div class="breadcromb-wrapper">
  <div class="breadcromb-overlay"></div>
  <div class="container">
    <div class="row">
      <div class="col-sm-12">
        <div class="breadcromb-left">
          <h3>Manage Courts</h3>
        </div>
      </div>
    </div>
    
  </div>
</div>
<!-- Breadcromb Wrapper End --> 


<section class="inner-page-wrapper">
<div class="container">
<div class="row">
<div class="col-md-9">


<!-- <section id="single_player" class="container secondary-page">

<div class="top-score-title right-score col-md-9"> -->
<!-- start main body -->

<?php 
if(isset($add_stat)) { ?>
<div class="name" align='left'>
<label for="name_login" style="color:green"><?php echo $add_stat; ?></label>
</div>
<?php } ?>


<div class="col-md-12 league-form-bg" style="margin-top:18px; margin-bottom:20px;">
<div class="section-label">Court Details</div>
<!-- Main Body Section -->

<!-- ---------------------------------------------------------------------------------------------------------------------------------- -->

<div id='div_add_court' class="col-md-12 form-bg" style='display:none;'> <!-- Add a court section -->
<?php
if($_SERVER['HTTP_X_FORWARDED_HOST'] != ''){
?>
<form class="form-horizontal" id='courts_add_form' method='post' role="form"  action="/courts/add"> 
<?php
}
else{
?>
<form class="form-horizontal" id='courts_add_form' method='post' role="form"  action="<?php echo base_url().$this->short_code; ?>/courts/add">
<?php
}
?>
<div class="col-md-6">
Location
<br />
<input type="text" class='form-control' name="location" />
</div>

<div class="col-md-6">
No.of courts
<br />
<select id='court_num' name='court_num' class='form-control'>
<?php
//echo "<option value=''>0</option>";	
for($i=1; $i<=15; $i++){ 
echo "<option value='$i'>$i</option>";	
}?>
</select>
</div>
<?php
//echo exit;
?>
<div id='dyn_courts'><!-- Dynamic Add New Courts Area -->
	<div class='col-md-12 div_grp' style='padding-bottom:4px;'>
		<div class='col-md-3'>Court Name/#</div>
		<div class='col-md-3'>Slot Duration</div>
		<div class='col-md-2'>Min. Book Sessions</div>
		<div class='col-md-2'>Max. Book Sessions</div>
		<div class='col-md-2'>Max Players</div>
		<div class='col-md-3'><input type='text' class='form-control' name='courts[]' placeholder='Court Name/# 1' value='Court 1' /></div>
		<div class='col-md-3'><select name='slot_duration[]' class='form-control'><option value=''>Select</option><option value='0.50'>30 Mins</option><option value='0.75'>45 Mins</option><option value='1'>1 Hour</option></select></div>
		<div class='col-md-2'><input type='number' class='form-control' name='min_book_hours[]' placeholder='Min Book Sessions' value='1' max='10' /></div>
		<div class='col-md-2'><input type='number' class='form-control' name='max_book_hours[]' placeholder='Max Book Sessions' value='2' max='10' /></div>
		<div class='col-md-2'><input type='number' class='form-control' name='max_num_players[]' placeholder='Max Players' value='4' max='10' /></div>
		<div class="col-md-3">Sharable Resource? <input type='checkbox' name='is_sharable_1' id='isr_1' value='1' /></div>
		<div class="col-md-3">Allow multiple bookings per day? <input type='checkbox' name='is_multi_bookings1' id='imb_1' value='1' /></div>
		<div class="col-md-3">Allow same day booking? <input type='checkbox' name='same_day_booking1' id='sdb_1' value='1' checked /></div>
		<div class="col-md-3">Max. Advance booking days&nbsp;<input type='number' style='width:30%' name='max_days_adv_bookings1' id='mab_1' value='30' /></div>

		<div class="col-md-12" id="div_peakcharges">

		<div class="col-md-2">
		Start Time   <br/>
		<select class='form-control' name='stime' id='stime_0' style="width: 108%; !important">
			<option value=''>Select</option>
			<option value='05:00:00'>5:00 am</option>
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
			<?php 
	/*			$ampm = 'AM';
			for($i=6;$i<=12;$i++) {
				if($i == 12 ){$ampm  = 'PM';} */
			?>
			<!-- <option value='<?//=$i.' '.$ampm;?>'><?//=$i.' '.$ampm;?></option> -->
			<?php //} 
			//	for($j=1;$j<=9;$j++){
			?>
			<!-- <option value='<?//=$j.' PM'?>'><?//=$j.' PM'?></option> -->
			<?php //} ?>
		<!-- </select> -->
	</div>
	<div class="col-md-2">
		End Time <br/>
		<select class='form-control' name='etime' id='etime_0' style="width: 108%; !important">
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
			<?php 
		/*	$ampm = 'AM';
			for($i=7;$i<=12;$i++) {
				if($i == 12 ){$ampm  = 'PM';} */
			?>
			<!-- <option value='<?//=$i.':00:00 '.$ampm;?>'><?//=$i.' '.$ampm;?></option> -->
			<?php //}
				//for($j=1;$j<=10;$j++){
			?>
			<!-- <option value='<?//=$j.' PM'?>'><?//=$j.' PM'?></option> -->
			<?php// } ?>
		<!-- </select> -->
	</div>
	<div class="col-md-1">
		Sun <br/>
		<input class='form-control' type='text' name='sun' id='sun_0' value='' placeholder='n/a' style='width:150%; height:100%;'>
	</div>
	<div class="col-md-1">
		Mon <br/>
		<input class='form-control' type='text' name='mon' id='mon_0' value='' placeholder='n/a' style='width:150%; height:100%;'>
	</div>
	<div class="col-md-1">
		Tue <br/>
		<input class='form-control' type='text' name='tue' id='tue_0' value='' placeholder='n/a' style='width:150%; height:100%;'>
	</div>
	<div class="col-md-1">
		Wed <br/>
		<input class='form-control' type='text' name='wed' id='wed_0' value='' placeholder='n/a' style='width:150%; height:100%;'>
	</div>
	<div class="col-md-1">
		Thu <br/>
		<input class='form-control' type='text' name='thu' id='thu_0' value='' placeholder='n/a' style='width:150%; height:100%;'>
	</div>
	<div class="col-md-1">
		Fri <br/>
		<input class='form-control' type='text' name='fri' id='fri_0' value='' placeholder='n/a' style='width:150%; height:100%;'>
	</div>
	<div class="col-md-1">
		Sat <br/>
		<input class='form-control' type='text' name='sat' id='sat_0' value='' placeholder='n/a' style='width:150%; height:100%;'>
		<br/><br/>
	</div>
	<div class="col-md-1">
		 <br/>
		<input type='button' name='add_timings' id='0' value='Add' class="league-form-submit1 add_timings" style='width:125%; height:100%;'>		
	</div>

	<!-- Additional fee section -->
		<div class="col-md-4">
		Add Additional player fee? <input type='checkbox' name='add_addn_fee' id='ad_0' class='add_addn_fee' value='1' /><br />
	</div>
	<div class="col-md-1">
		<input class='form-control addn_fee_0 addn_fee_all' type='text' name='addn_sun' id='addn_sun_0' value='' placeholder='n/a' style='width:150%; height:100%;'>
	</div>
	<div class="col-md-1">
		<input class='form-control addn_fee_0 addn_fee_all' type='text' name='addn_mon' id='addn_mon_0' value='' placeholder='n/a' style='width:150%; height:100%;'>
	</div>
	<div class="col-md-1">
		<input class='form-control addn_fee_0 addn_fee_all' type='text' name='addn_tue' id='addn_tue_0' value='' placeholder='n/a' style='width:150%; height:100%;'>
	</div>
	<div class="col-md-1">
		<input class='form-control addn_fee_0 addn_fee_all' type='text' name='addn_wed' id='addn_wed_0' value='' placeholder='n/a' style='width:150%; height:100%;'>
	</div>
	<div class="col-md-1">
		<input class='form-control addn_fee_0 addn_fee_all' type='text' name='addn_thu' id='addn_thu_0' value='' placeholder='n/a' style='width:150%; height:100%;'>
	</div>
	<div class="col-md-1">
		<input class='form-control addn_fee_0 addn_fee_all' type='text' name='addn_fri' id='addn_fri_0' value='' placeholder='n/a' style='width:150%; height:100%;'>
	</div>
	<div class="col-md-1">
		<input class='form-control addn_fee_0 addn_fee_all' type='text' name='addn_sat' id='addn_sat_0' value='' placeholder='n/a' style='width:150%; height:100%;'>
		<br/><br/>
	</div>
	<div class="col-md-1">
		 &nbsp;		
	</div>

	<!-- Additional fee section -->
	<div class='col-md-12 timing-table' id='show_timings_0' style='display:none; margin-top: 0px;'>
		<table name='timings_table' id='timings_table_0' width='' class='score-cont tab-score'>
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
		</table>
		<br/>
	</div>

</div>

		
</div>
</div>


<div class="col-md-12">
Address
<br />
<input type="text" class='form-control' name="address" required />
</div>

<div class="col-md-6">
City
<br />
<input type="text" class='form-control' name="city" required />
</div>

<div class="col-md-6">
State
<br />
<input type="text" class='form-control' name="state" required />
</div>

<div class="col-md-6">
Country
<br />
<select class='form-control' name='country' id='country' required>
<option value="">Select</option>
<?php
$countries = array("Afghanistan", "Albania", "Algeria", "American Samoa", "Andorra", "Angola", "Anguilla", "Antarctica", "Antigua and Barbuda", "Argentina", "Armenia", "Aruba", "Australia", "Austria", "Azerbaijan", "Bahamas", "Bahrain", "Bangladesh", "Barbados", "Belarus", "Belgium", "Belize", "Benin", "Bermuda", "Bhutan", "Bolivia", "Bosnia and Herzegowina", "Botswana", "Bouvet Island", "Brazil", "British Indian Ocean Territory", "Brunei Darussalam", "Bulgaria", "Burkina Faso", "Burundi", "Cambodia", "Cameroon", "Canada", "Cape Verde", "Cayman Islands", "Central African Republic", "Chad", "Chile", "China", "Christmas Island", "Cocos (Keeling) Islands", "Colombia", "Comoros", "Congo", "Congo, the Democratic Republic of the", "Cook Islands", "Costa Rica", "Cote d'Ivoire", "Croatia (Hrvatska)", "Cuba", "Cyprus", "Czech Republic", "Denmark", "Djibouti", "Dominica", "Dominican Republic", "East Timor", "Ecuador", "Egypt", "El Salvador", "Equatorial Guinea", "Eritrea", "Estonia", "Ethiopia", "Falkland Islands (Malvinas)", "Faroe Islands", "Fiji", "Finland", "France", "France Metropolitan", "French Guiana", "French Polynesia", "French Southern Territories", "Gabon", "Gambia", "Georgia", "Germany", "Ghana", "Gibraltar", "Greece", "Greenland", "Grenada", "Guadeloupe", "Guam", "Guatemala", "Guinea", "Guinea-Bissau", "Guyana", "Haiti", "Heard and Mc Donald Islands", "Holy See (Vatican City State)", "Honduras", "Hong Kong", "Hungary", "Iceland", "India", "Indonesia", "Iran (Islamic Republic of)", "Iraq", "Ireland", "Israel", "Italy", "Jamaica", "Japan", "Jordan", "Kazakhstan", "Kenya", "Kiribati", "Korea, Democratic People's Republic of", "Korea, Republic of", "Kuwait", "Kyrgyzstan", "Lao, People's Democratic Republic", "Latvia", "Lebanon", "Lesotho", "Liberia", "Libyan Arab Jamahiriya", "Liechtenstein", "Lithuania", "Luxembourg", "Macau", "Macedonia, The Former Yugoslav Republic of", "Madagascar", "Malawi", "Malaysia", "Maldives", "Mali", "Malta", "Marshall Islands", "Martinique", "Mauritania", "Mauritius", "Mayotte", "Mexico", "Micronesia, Federated States of", "Moldova, Republic of", "Monaco", "Mongolia", "Montserrat", "Morocco", "Mozambique", "Myanmar", "Namibia", "Nauru", "Nepal", "Netherlands", "Netherlands Antilles", "New Caledonia", "New Zealand", "Nicaragua", "Niger", "Nigeria", "Niue", "Norfolk Island", "Northern Mariana Islands", "Norway", "Oman", "Pakistan", "Palau", "Panama", "Papua New Guinea", "Paraguay", "Peru", "Philippines", "Pitcairn", "Poland", "Portugal", "Puerto Rico", "Qatar", "Reunion", "Romania", "Russian Federation", "Rwanda", "Saint Kitts and Nevis", "Saint Lucia", "Saint Vincent and the Grenadines", "Samoa", "San Marino", "Sao Tome and Principe", "Saudi Arabia", "Senegal", "Seychelles", "Sierra Leone", "Singapore", "Slovakia (Slovak Republic)", "Slovenia", "Solomon Islands", "Somalia", "South Africa", "South Georgia and the South Sandwich Islands", "Spain", "Sri Lanka", "St. Helena", "St. Pierre and Miquelon", "Sudan", "Suriname", "Svalbard and Jan Mayen Islands", "Swaziland", "Sweden", "Switzerland", "Syrian Arab Republic", "Taiwan, Province of China", "Tajikistan", "Tanzania, United Republic of", "Thailand", "Togo", "Tokelau", "Tonga", "Trinidad and Tobago", "Tunisia", "Turkey", "Turkmenistan", "Turks and Caicos Islands", "Tuvalu", "Uganda", "Ukraine", "United Arab Emirates", "United Kingdom", "United States of America", "United States Minor Outlying Islands", "Uruguay", "Uzbekistan", "Vanuatu", "Venezuela", "Vietnam", "Virgin Islands (British)", "Virgin Islands (U.S.)", "Wallis and Futuna Islands", "Western Sahara", "Yemen", "Yugoslavia", "Zambia", "Zimbabwe");

foreach($countries as $country)
{
($country=="United States of America") ? $sel = "selected='selected'" : $sel = "";
echo "<option value='$country' $sel>$country</option>";
}
?>
</select>
</div>

<div class="col-md-6">
Zipcode
<br />
<input type="text" class='form-control' name="zip" required />
</div>

<div class="col-md-12">
Instructions / Comments
<br />
<textarea class='form-control' name='ins_comments' rows='5'></textarea>
</div>
<br/>
<!--  ************ Discount section  for courts starts here.  ************** -->

<div class="col-md-12">
Do you want to allow bookings for everyone (non members)?  &nbsp;&nbsp;&nbsp;&nbsp;
<input type='radio' name='is_nonmem_book' id='is_nonmem_book_yes' value='1' checked />&nbsp;Yes &nbsp;&nbsp;
<input type='radio' name='is_nonmem_book' id='is_nonmem_book_no' value='0'  />&nbsp;No
<br/><br/>
</div>

<div class="col-md-12">
Do you want to add discount for club members?  &nbsp;&nbsp;&nbsp;&nbsp;
<input type='radio' name='is_discount' id='is_discount_yes' value='1' />&nbsp;Yes &nbsp;&nbsp;
<input type='radio' name='is_discount' id='is_discount_no' value='0' checked />&nbsp;No
<br/><br/>
</div>

<div class='form-group' id="discount_div" style="display:none">
   <label class='col-md-3' for='id_accomodation' style='margin-top: 5px;'>Discount in Percentage: </label>
   <div class='col-md-4 form-group internal'>
   <input class='form-control' id='member_discount' name='member_discount' style='width:30%;' type='number' max='99' />&nbsp; 
   </div>
</div>

<!--  ************ Discount section  for courts starts here.  ************** -->


<!--  ************ Fee section  for courts starts here.  ************** -->
<div class="col-md-12">
Do you want to add your own Payment Gateway?  &nbsp;&nbsp;&nbsp;&nbsp;
<input type='radio' name='court_fee' id='court_fee_yes' value='1' />&nbsp;Yes &nbsp;&nbsp;
<input type='radio' name='court_fee' id='court_fee_no' value='0' checked />&nbsp;No
<br/><br/>
</div>

<div class='form-group' id="court_pay_select" style="display:none">
     <label class='col-md-3' for='id_accomodation'>Select payment option:  </label>
       <div class='col-md-4 form-group internal'>
          <select class='form-control' name='court_fee_paytype' id='court_fee_paytype' class="form-control" >
			<option value=''>--Select--</option>
			<option value='paypal'>Paypal</option>
			<option value='paytm'>Paytm</option>
		  </select>
		</div>
</div>
<!--  ************ Fee section  for courts Ends here.  ************** -->
<!--************************* Paypal Details Section Starts Here. *********************** -->
<div id="paypal_details" class="col-md-12 league-form-bg" style="display:none;">
	<div class="col-md-12" style="background: #f59123; color: #fff;
    font-size: 14px; font-weight: bold; padding: 5px; margin-bottom: 20px;">PayPal Details </div>
	<!--	Do you have PayPal Account to receive the fund (Registration charges)?&nbsp;
			<label for="ppYes"><input type="radio" id="ppYes" name="pp" value="1" /> Yes</label>&nbsp;&nbsp;
			<label for="ppNo"><input type="radio" id="ppNo" name="pp" value="0" checked="checked" /> No<br /></label>
	-->		 
			<div id="paypal_ids" style="display:none;">
			Paypal EmailID (Merchant):   
				<select name="ppids" id="ppids">
					<option value="">--Select--</option>
					<?php foreach($paypal_ids as $ppids) { ?>
							<option value="<?=$ppids->pp_busi_id;?>"><?=$ppids->paypal_merch_id;?></option>
					<?php } ?>
				</select>
				&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			<button type="button" name="addppids" id="addppids" class="btn btn-success" style="border-top: 0px solid #ddd; display:none;">Add New ID</button>  
			</div>

   	<div id="ppYesNo" style="display:none;">
			<div class='form-group' style="margin-bottom:0px !important;">
				<label class='control-label col-md-3' for='id_accomodation'><font color='red'>* </font> Merchant ID </label>
				<div class='col-md-4 form-group internal'>
				<input class='form-control' id='paypal_merchantid' name='paypal_merchantid' type='text' />&nbsp; 
				</div>
				<div class="col-md-5">
				<img src="<?=base_url();?>icons/info_ico.png" title="Paypal Business Account EmailID " width="25px" height="25px" />
				</div>
			</div>

		   <!-- <div class='form-group'>
            <label class='control-label col-md-3' for='id_accomodation'>* Secret Key</label>
            <div class='col-md-8 form-group internal'>
              <input class='form-control' id='secretcode' name='secretcode' type='text' style="width:50%">
            </div>
          </div> -->

			<div class='form-group'>
			<label class='control-label col-md-3' for='id_accomodation'><font color='red'>* </font> Currency Type</label>
				<div class='col-md-8 form-group internal'>
					<?php $currency_codes = courts :: get_currency_codes();?>
					<select name="currency_code" id="currency_code" class='form-control' style='width:30%'>
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
	<div id="paytm_details" class="col-md-12 league-form-bg" style="display:none;">
	<div class="col-md-12" style="background: #f59123; color: #fff;
    font-size: 14px; font-weight: bold; padding: 5px; margin-bottom: 20px;">Paytm Details </div>
	<!--	Do you have Paytm Account to receive the fund (Registration charges)?&nbsp;
			<label for="ptmYes"><input type="radio" id="ptmYes" name="petm" value="1" /> Yes</label>&nbsp;&nbsp;
			<label for="ptmNo"><input type="radio" id="ptmNo" name="petm" value="0" checked="checked" /> No<br /></label>
	-->		 
			<div id="paytm_ids" style="display:none;">
			Paytm ID (Merchant):   
				<select name="ptmids" id="ptmids">
					<option value="">--Select--</option>
					<?php foreach($paytm_ids as $petmids) { ?>
							<option value="<?=$petmids->paytm_busi_id;?>"><?=$petmids->paytm_merch_id;?></option>
					<?php } ?>
				</select>
				&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			<button type="button" name="addptmids" id="addptmids" class="btn btn-success" style="border-top: 0px solid #ddd; display:none;">Add New ID</button>  
			</div>

   	<div id="peTmYesNo" style="display:none;">
			<div class='form-group' style="margin-bottom:0px !important;">
				<label class='control-label col-md-3' for='id_accomodation'><font color='red'>* </font> Merchant ID </label>
				<div class='col-md-4 form-group internal'>
				<input class='form-control' id='paytm_merchantid' name='paytm_merchantid' type='text' />&nbsp; 
				</div>
				<div class="col-md-5">
				<img src="<?=base_url();?>icons/info_ico.png" title="Paytm Business AccountID " width="25px" height="25px" />
				</div>
			</div>

		   <!-- <div class='form-group'>
            <label class='control-label col-md-3' for='id_accomodation'>* Secret Key</label>
            <div class='col-md-8 form-group internal'>
              <input class='form-control' id='secretcode' name='secretcode' type='text' style="width:50%">
            </div>
          </div>

			<div class='form-group'>
			<label class='control-label col-md-3' for='id_accomodation'><font color='red'>* </font> Currency Type</label>
				<div class='col-md-8 form-group internal'>
					<select name="currency_code" id="currency_code" class='form-control' style='width:30%'>
					<option value="">--Select--</option>
					<?php foreach($currency_codes as $ccodes)	{ ?>
					<option value="<?=$ccodes->code;?>" <?php if($ccodes->code == 'USD'){ echo "selected"; } ?>><?=$ccodes->code;?></option>
					<?php } ?>
					</select>
				</div>
			</div>  -->
			<div class='form-group' style="margin-bottom:0px !important;">
				<label class='control-label col-md-3' for='id_accomodation'><font color='red'>* </font> Merchant Key </label>
				<div class='col-md-4 form-group internal'>
				<input class='form-control' id='merchantKey' name='paytm_merchantKey' type='text' />&nbsp; 
				</div>
				<div class="col-md-5">
			<!--<img src="<?=base_url();?>icons/info_ico.png" title="Paytm Business Account EmailID " width="25px" height="25px" />-->
				</div>
			</div>

 		</div> 
 	</div>
	<!-- ************************* Paytm Details Section Ends Here. ************************* -->

<!--  ************ Fees section  for courts ends here.    ************** -->

<div class="col-md-12" id="add_courts">
<input type="submit" id="submit_location" name="submit_location"  value=" Add Details " class="btn submit-btn" style="margin:20px 0px"/>&nbsp;&nbsp;
<input type="button" id="cancel_location" name="cancel_location"  value=" Cancel " class="league-form-submit1" style="margin:20px 0px"/>
</div>

<div class="col-md-12" id="add_courts_wait" style="display:none;">
<input type="botton"  value="PLEASE WAIT....." class="league-form-submit1" style="margin:20px 0px"/>
</div>
</form>
</div>	 <!-- End of Add a court section -->	

<!-- ---------------------------------------------------------------------------------------------------------------------------------- -->
<div id='div_edit_court' class="col-md-12 form-bg" style='display:none;'>
<!-- Edit court section Loads dynamically through Ajax -->
</div>
<!-- ---------------------------------------------------------------------------------------------------------------------------------- -->

<div id='div_court_list' class="section-border">	<!-- List the courts section -->
<div style='text-align:right'>
<input type="button" id="add_court" name="add_court"  value=" Add Location & Courts " class="btn submit-btn" style="margin:20px 0px" />
</div>
<!-- <div><?php /*if($this->uri->segment(4) == '2') { echo "Location Updated Successfully"; } */?></div> -->
<?php
if(count($courts) == 0)
{
	echo "No Courts were added yet!";
}
else if(count($courts) > 0)
{
?>
<table class='table'>
<tr align='center'>
<td><b>Select</b></td>
<td><b>Location</b></td>
<td><b>Courts#</b></td>
<td><b>City</b></td>
<td><b>Status</b></td>
<td><b>Action</b></td>
</tr>

<?php 
foreach($courts as $row){ 
?>
<tr align='center'>
<td><input type='checkbox' name='sel_loc_ids[]' id='sel_loc_<?=$row->loc_id;?>' value='<?=$row->loc_id;?>' /></td>
<td><?php echo $row->location; ?></td>
<td><?php $get_count = $this->model_courts->get_court_count($row->loc_id); echo $get_count; ?></td>
<td><?php echo $row->city; ?></td>
<td><?php ($row->status == 1) ? $stat = "Active" : $stat = "InActive"; echo $stat;?></td>
<td>
<a href='#' class="ed_court" name="<?php echo $row->loc_id;?>">
<img src="<?php echo base_url();?>images/edit_club.png" align="middle" width="30" height="20" name="<?php echo $row->loc_id;?>" /></a>
</td>
</tr>
<?php } ?>

</table>
<?php
 } ?> 

<?php
// if($this->logged_user == 237){
	?> 
 <tr align='center'><td>
 <form id='frm_download'  name='frm_download' method='POST' action='<?=$this->config->item('club_form_url');?>/export/court_reservations'>
	 <input type='hidden' name='sel_locations' id='sel_locations' value='' />
	 <input type="submit" id="court_res_download" name="court_res_download"  value = " Download Reservations " class="btn submit-btn" style="margin:20px 0px" />
 </form>
 </td></tr>
<?php
//} 
	?>
</div>	<!-- End of List the courts section-->
<!-- End of Main Body Section -->
</div>
<!-- </div> -->
</form>
<script>
$('#frm_download').submit(function() {
	var sList = [];
	var x=0;
	$("input[name='sel_loc_ids[]']:checked").each(function () {
		sList.push($(this).val());
		x++;
	});
	$('#sel_locations').val(JSON.stringify(sList));
});
</script>
<div id="dialog-confirm" title="Pricing">
  <!-- <p><span class="ui-icon ui-icon-alert" style="float:left; margin:12px 12px 20px 0;"></span>
  Do you want to apply this Pricing for all the Courts?</p> -->
</div>
</div><!--Close Top Match-->

<!-- ********************** JQuery Code Of Fee Section Starts Here *********************** -->
<script>
$(document).ready(function(){
	$("[name=is_discount]").click(function(){
		var dis = $(this).val();

		if(dis == 1){
			$('#discount_div').show();
		}
		else{
			$('#discount_div').hide();
		}
	});


	$("[name=court_fee]").click(function(){
		var radio_val = $(this).val();
		var fee_val = $("input[name='fee_per_hour[]']").map(function(){
			return $(this).val();}).get();

		var country_val = $('#country').val();

	/*	if(radio_val == 1 && fee_val == 0.00){
			alert('Payble amount sholud not be 0');	
			return false;
		}
	*/
	//	if(radio_val == 1 && fee_val != 0.00){
		if(radio_val == 1){
			if(country_val != 'India'){
				 $("#court_pay_select").hide();
				 $('#paypal_details').show();
				 $('#paypal_ids').show();
				 $('#addppids').show();
			}
			else {
				$("#court_pay_select").show();
				$('#paypal_details').hide();
			}
		}else{
//		alert('Payble amount sholud not be 0');	
		$('#court_fee_no').prop('checked',true);
		 $("#court_pay_select").hide();
		 $('#ppYesNo').hide();
		 $('#paypal_details').hide();
		 $('#paytm_details').hide(); 
		 $('#court_fee_paytype').val('');
		}
	});

	$("#court_fee_paytype").change(function(){
		var opt_val = $(this).val();
		if(opt_val == 'paypal'){
				$('#paypal_ids').show();
				$('#addppids').show();
			/*	$("input[name='pp']").trigger('click');
				$('#ppYes').prop('checked', true);*/
				$('#paypal_details').show();
				$('#paytm_details').hide();
				$('#ppYesNo').hide();
			}
			if(opt_val == 'paytm'){
				$('#paytm_ids').show();
				$('#addptmids').show();
			/*	$("input[name='petm']").trigger('click');
				$('#ptmYes').prop('checked', true);*/
				$('#paypal_details').hide();
				$('#paytm_details').show();
				$('#peTmYesNo').hide();
			}
			if(opt_val == ''){
				$('#paytm_details').hide();
				$('#paypal_details').hide();
			}
		
	});

	$("#addppids").click(function (){
		$('#paypal_ids').hide();
		$('#ppYesNo').show();
	});

	$("#addptmids").click(function (){
		$('#paytm_ids').hide();
		$('#peTmYesNo').show();
	});

	$('#country').change(function(){
		$('#court_fee_no').trigger('click');
	});
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

	function yes_apply(btn_id) {
		i++;
		// default values
		var sun_val = 'n/a'; var mon_val = 'n/a';	var tue_val = 'n/a';	var wed_val = 'n/a';	var thu_val = 'n/a'; var fri_val = 'n/a'; var sat_val = 'n/a';
		var addn_sun_val = 'n/a'; var addn_mon_val = 'n/a';	 var addn_tue_val = 'n/a';	var addn_wed_val = 'n/a';	var addn_thu_val = 'n/a'; var addn_fri_val = 'n/a'; var addn_sat_val = 'n/a';

		var stTime = $('#stime_'+btn_id).val();
		var edTime = $('#etime_'+btn_id).val();

		if($('#sun_'+btn_id).val() != '')	var sun_val = $('#sun_'+btn_id).val();
		if($('#mon_'+btn_id).val() != '')	var mon_val = $('#mon_'+btn_id).val();
		if($('#tue_'+btn_id).val() != '')	var tue_val = $('#tue_'+btn_id).val();
		if($('#wed_'+btn_id).val() != '')	var wed_val = $('#wed_'+btn_id).val();
		if($('#thu_'+btn_id).val() != '')	var thu_val = $('#thu_'+btn_id).val();
		if($('#fri_'+btn_id).val() != '')		var fri_val = $('#fri_'+btn_id).val();
		if($('#sat_'+btn_id).val() != '')		var sat_val = $('#sat_'+btn_id).val();

		if($('#addn_sun_'+btn_id).val() != '')		var addn_sun_val = $('#addn_sun_'+btn_id).val();
		if($('#addn_mon_'+btn_id).val() != '')	var addn_mon_val = $('#addn_mon_'+btn_id).val();
		if($('#addn_tue_'+btn_id).val() != '')		var addn_tue_val = $('#addn_tue_'+btn_id).val();
		if($('#addn_wed_'+btn_id).val() != '')	var addn_wed_val = $('#addn_wed_'+btn_id).val();
		if($('#addn_thu_'+btn_id).val() != '')		var addn_thu_val = $('#addn_thu_'+btn_id).val();
		if($('#addn_fri_'+btn_id).val() != '')		var addn_fri_val = $('#addn_fri_'+btn_id).val();
		if($('#addn_sat_'+btn_id).val() != '')		var addn_sat_val = $('#addn_sat_'+btn_id).val();

		if(stTime == '' || edTime == ''){
			//alert('Please select Start & End Timings');
			return false;
		}
		else{
		//$('#show_timings_'+btn_id).show();

			var ct = parseInt($("#court_num").val(), 10);
			for (j = 0; j < ct; j++) {
			$('#timings_table_'+j).append('<tr id="row'+i+'"><td>'+stTime+'<input type ="hidden" name="stTime_'+j+'[]" value="'+stTime+'" /></td><td>'+edTime+'<input type ="hidden" name="edTime_'+j+'[]" value="'+edTime+'" /></td><td>'+sun_val+'<input type ="hidden" name="sunPrice_'+j+'[]" value="'+sun_val+'" /></td><td>'+mon_val+'<input type ="hidden" name="monPrice_'+j+'[]" value="'+mon_val+'" /></td><td>'+tue_val+'<input type ="hidden" name="tuePrice_'+j+'[]" value="'+tue_val+'" /></td><td>'+wed_val+'<input type ="hidden" name="wedPrice_'+j+'[]" value="'+wed_val+'" /></td><td>'+thu_val+'<input type ="hidden" name="thuPrice_'+j+'[]" value="'+thu_val+'" /></td><td>'+fri_val+'<input type ="hidden" name="friPrice_'+j+'[]" value="'+fri_val+'" /></td><td>'+sat_val+'<input type ="hidden" name="satPrice_'+j+'[]" value="'+sat_val+'" /></td><td><input type="button" name="del_timings" id="'+i+'" value="Delete" class="league-form-submit1 btn_remove" style="width: 90%;height: 100%; margin-left: 5px;"></td></tr>');

			$('#timings_table_'+j).append('<tr id="addn_row'+i+'"><td colspan="2">Additional fee per player</td><td>'+addn_sun_val+'<input type ="hidden" name="addn_sunPrice_'+j+'[]" value="'+addn_sun_val+'" /></td><td>'+addn_mon_val+'<input type ="hidden" name="addn_monPrice_'+j+'[]" value="'+addn_mon_val+'" /></td><td>'+addn_tue_val+'<input type ="hidden" name="addn_tuePrice_'+j+'[]" value="'+addn_tue_val+'" /></td><td>'+addn_wed_val+'<input type ="hidden" name="addn_wedPrice_'+j+'[]" value="'+addn_wed_val+'" /></td><td>'+addn_thu_val+'<input type ="hidden" name="addn_thuPrice_'+j+'[]" value="'+addn_thu_val+'" /></td><td>'+addn_fri_val+'<input type ="hidden" name="addn_friPrice_'+j+'[]" value="'+addn_fri_val+'" /></td><td>'+addn_sat_val+'<input type ="hidden" name="addn_satPrice_'+j+'[]" value="'+addn_sat_val+'" /></td><td>&nbsp;</td></tr>');

			$('#stime_'+j).val(''); $('#etime_'+j).val(''); $('#sun_'+j).val(''); $('#mon_'+j).val(''); $('#tue_'+j).val(''); $('#wed_'+j).val(''); $('#thu_'+j).val(''); $('#fri_'+j).val(''); $('#sat_'+j).val('');
			
			$('#show_timings_'+j).show();
			i++;
			}
		}
	}

	function no_apply(btn_id) {
		i++;
		// default values
		var sun_val = 'n/a'; var mon_val = 'n/a';	var tue_val = 'n/a';	var wed_val = 'n/a';	var thu_val = 'n/a'; var fri_val = 'n/a'; var sat_val = 'n/a';
		var addn_sun_val = 'n/a'; var addn_mon_val = 'n/a';	 var addn_tue_val = 'n/a';	var addn_wed_val = 'n/a';	var addn_thu_val = 'n/a'; var addn_fri_val = 'n/a'; var addn_sat_val = 'n/a';

		var stTime = $('#stime_'+btn_id).val();
		var edTime = $('#etime_'+btn_id).val();

		if($('#sun_'+btn_id).val() != '')	var sun_val = $('#sun_'+btn_id).val();
		if($('#mon_'+btn_id).val() != '')	var mon_val = $('#mon_'+btn_id).val();
		if($('#tue_'+btn_id).val() != '')	var tue_val = $('#tue_'+btn_id).val();
		if($('#wed_'+btn_id).val() != '')	var wed_val = $('#wed_'+btn_id).val();
		if($('#thu_'+btn_id).val() != '')	var thu_val = $('#thu_'+btn_id).val();
		if($('#fri_'+btn_id).val() != '')		var fri_val = $('#fri_'+btn_id).val();
		if($('#sat_'+btn_id).val() != '')		var sat_val = $('#sat_'+btn_id).val();

		if($('#addn_sun_'+btn_id).val() != '')		var addn_sun_val = $('#addn_sun_'+btn_id).val();
		if($('#addn_mon_'+btn_id).val() != '')	var addn_mon_val = $('#addn_mon_'+btn_id).val();
		if($('#addn_tue_'+btn_id).val() != '')		var addn_tue_val = $('#addn_tue_'+btn_id).val();
		if($('#addn_wed_'+btn_id).val() != '')	var addn_wed_val = $('#addn_wed_'+btn_id).val();
		if($('#addn_thu_'+btn_id).val() != '')		var addn_thu_val = $('#addn_thu_'+btn_id).val();
		if($('#addn_fri_'+btn_id).val() != '')		var addn_fri_val = $('#addn_fri_'+btn_id).val();
		if($('#addn_sat_'+btn_id).val() != '')		var addn_sat_val = $('#addn_sat_'+btn_id).val();

		if(stTime == '' || edTime == ''){
			//alert('Please select Start & End Timings');
			return false;
		}
		else{
		//$('#show_timings_'+btn_id).show();

			$('#timings_table_'+btn_id).append('<tr id="row'+i+'"><td>'+stTime+'<input type ="hidden" name="stTime_'+btn_id+'[]" value="'+stTime+'" /></td><td>'+edTime+'<input type ="hidden" name="edTime_'+btn_id+'[]" value="'+edTime+'" /></td><td>'+sun_val+'<input type ="hidden" name="sunPrice_'+btn_id+'[]" value="'+sun_val+'" /></td><td>'+mon_val+'<input type ="hidden" name="monPrice_'+btn_id+'[]" value="'+mon_val+'" /></td><td>'+tue_val+'<input type ="hidden" name="tuePrice_'+btn_id+'[]" value="'+tue_val+'" /></td><td>'+wed_val+'<input type ="hidden" name="wedPrice_'+btn_id+'[]" value="'+wed_val+'" /></td><td>'+thu_val+'<input type ="hidden" name="thuPrice_'+btn_id+'[]" value="'+thu_val+'" /></td><td>'+fri_val+'<input type ="hidden" name="friPrice_'+btn_id+'[]" value="'+fri_val+'" /></td><td>'+sat_val+'<input type ="hidden" name="satPrice_'+btn_id+'[]" value="'+sat_val+'" /></td><td><input type="button" name="del_timings" id="'+i+'" value="Delete" class="league-form-submit1 btn_remove" style="width: 90%;height: 100%; margin-left: 5px;"></td></tr>');

			$('#timings_table_'+btn_id).append('<tr id="addn_row'+i+'"><td colspan="2">Additional fee per player</td><td>'+addn_sun_val+'<input type ="hidden" name="addn_sunPrice_'+btn_id+'[]" value="'+addn_sun_val+'" /></td><td>'+addn_mon_val+'<input type ="hidden" name="addn_monPrice_'+btn_id+'[]" value="'+addn_mon_val+'" /></td><td>'+addn_tue_val+'<input type ="hidden" name="addn_tuePrice_'+btn_id+'[]" value="'+addn_tue_val+'" /></td><td>'+addn_wed_val+'<input type ="hidden" name="addn_wedPrice_'+btn_id+'[]" value="'+addn_wed_val+'" /></td><td>'+addn_thu_val+'<input type ="hidden" name="addn_thuPrice_'+btn_id+'[]" value="'+addn_thu_val+'" /></td><td>'+addn_fri_val+'<input type ="hidden" name="addn_friPrice_'+btn_id+'[]" value="'+addn_fri_val+'" /></td><td>'+addn_sat_val+'<input type ="hidden" name="addn_satPrice_'+btn_id+'[]" value="'+addn_sat_val+'" /></td><td>&nbsp;</td></tr>');

			$('#stime_'+btn_id).val(''); $('#etime_'+btn_id).val(''); $('#sun_'+btn_id).val(''); $('#mon_'+btn_id).val(''); $('#tue_'+btn_id).val(''); $('#wed_'+btn_id).val(''); $('#thu_'+btn_id).val(''); $('#fri_'+btn_id).val(''); $('#sat_'+btn_id).val('');
			
			$('#show_timings_'+btn_id).show();
		}
	}


	$(document).ready(function(){

	//var i=0;
		//	$('.add_timings').click(function(){
		$(document).on('click', '.add_timings', function(){
			var btn_id = $(this).attr('id');
			//alert(btn_id);
			show_dialog('Do you want to apply this Pricing for all the Courts?', 'Yes', yes_apply, 'No', no_apply, btn_id);
		});
		
		$('#etime').change(function(){
			/*var valuestart = $("#stime").val();
			var valuestop = $("#etime").val();
			var timeStart = new Date("01/01/2007 " + valuestart).getHours();
			var timeEnd = new Date("01/01/2007 " + valuestop).getHours();
			var hourDiff = timeEnd - timeStart;  
			  if(hourDiff < 0){
				alert('End time must be greater than Start time.');
				$("#stime, #etime").val('');
				return false;
			  }else{ return true; }*/
		});

		$(document).on('click', '.add_addn_fee', function(){
			var id = $(this).attr('id');
			var x = id.split('_');
			if($(this).prop("checked") == true){
				$('.addn_fee_'+x[1]).prop( "disabled", false );
			}
			else{
				$('.addn_fee_'+x[1]).val('');
				$('.addn_fee_'+x[1]).prop( "disabled", true );
			}

		});
	});

	$(document).on('click', '.btn_remove', function(){  
           var button_id = $(this).attr("id"); 
		   var rowCount = $('#timings_table tr').not('thead tr').length;
		   if(rowCount == 1 && button_id == 1){
			$('#show_timings').hide();
			$('#timings_table').hide();
		   }else{
           $('#row'+button_id).remove();  
           $('#addn_row'+button_id).remove();  
		   }
    });

	$(document).ready(function(){
		$('.addn_fee_all').prop('disabled', true);
	});

	/*$(document).on('click', '.add_timings', function(){
		var id = $(this).attr("id"); 
		//alert("Clicked Add Button ID Is :: "+id);
		//alert('#show_timings_'+id);
 		$('#show_timings_'+id).show();
	});*/
</script>