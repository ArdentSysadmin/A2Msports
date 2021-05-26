<link href="<?php echo base_url(); ?>css/reserve.css" type="text/css" rel="stylesheet" />
<link href="<?php echo base_url(); ?>css/tabs-reserve.css" type="text/css" rel="stylesheet" />

<script type="text/javascript" src="<?php echo base_url(); ?>js/jquery.simple-dtpicker.js"></script>
<link type="text/css" href="<?php echo base_url(); ?>css/jquery.simple-dtpicker.css" rel="stylesheet" />

<script>
$(document).ready(function(){

	$('#res_court').click(function(){
		$("#res_court_block").toggle();
		//$("#res_grid_block").toggle();
	});

	$('#reserve_cancel').click(function(){
		$('#frm_reserve').get(0).reset();
		$("#res_court_block").toggle();
		//$("#res_grid_block").toggle();
	});


	var baseurl		= "<?php echo base_url();?>";
	var short_code	= "<?php echo $this->short_code;?>";
	var org_id		= "<?php echo $org_details[Org_ID];?>";
	var r_date		= "<?php echo $this->uri->segment(4);?>";
	
	if(r_date){  
		var from = r_date.split("-");
		var rightNow = new Date(from[0], from[2] - 1, from[1]);
	}
	else{ var rightNow	= new Date(); }
	
	//alert(rightNow);
	//var rightNow	= new Date(); 
	
	getRes(org_id,rightNow);

	$('#location').on('change',function(){
		var loc_id = $(this).val();

		if(loc_id != ""){
			$("#court").hide();
			$("#loading").show();
			$.ajax({
				type:'POST',
				url:baseurl+short_code+'/courts/get_loc_courts/',
				data:{ loc_id:loc_id},    //{pt:'7',rngstrt:range1, rngfin:range2},
				success:function(html){
					 $("#loading").hide();
					 $("#court").show();
					 $('#court').html(html);
				}
			}); 
		}
	});

	$('#reserve_submit').on('click',function(){

		var loc_id	 = $('#location').val();
		var court_id = $('#court').val();
		var res_date = $('#res_date').val();
		var hrs		 = $('#book_hours').val();

		//if(loc_id & court_id & res_date & hrs){
			
			$.ajax({
				type: 'POST',
				url:baseurl+short_code+'/courts/block_court/',
				//data: $('#frm_reserve').serialize(),
				data: {loc_id:loc_id, court:court_id, res_date:res_date, book_hours:hrs},
				success: function(res) {
					if(res == 1){
						alert('Court reservation has confirmed.');
						//location.reload();
						var onlyDate = res_date.split(' ');
						var newdate = onlyDate[0].split("/").reverse().join("-");
						 window.location.href = baseurl+short_code+"/courts/reserve/"+newdate;
					}
					else if(res == 2){
						alert('Court booking time exceeding to the next day!');
					}
					else if(res == 0){
						alert("Court is already reserved!");
					}
				}
			});
			//e.preventDefault();
		//}
	});


	$(function(){
		$('*[name=res_date]').appendDtpicker({
			"inline": false,
			"futureOnly": true,
			"autodateOnStart": false,
			"dateFormat": "MM/DD/YYYY h:m",
			"closeOnSelected": true
		});
		$('.rsDatePickerActivator').appendDtpicker({
			"inline": false,
			"futureOnly": false,
			//"closeOnSelected": true,
			"dateOnly":true,
			"dateFormat": "MM/DD/YYYY",
			"onHide": function(handler){
				var org_id		= "<?php echo $org_details[Org_ID];?>";
				var displayDAte = $('.rsDatePickerActivator').handleDtpicker('getDate');
				getRes(org_id,displayDAte);
			}
		});
	});
 
	$(".rsPrevDay").click(function(){
	  var displayDAte = new Date($('.displayDate').first().text())
	  displayDAte.setDate(displayDAte.getDate() - 1);
	  getRes(org_id,displayDAte);

    });
	
	$(".rsDatePickerActivator").click(function(){
	  var displayDAte = $('.rsDatePickerActivator').handleDtpicker('getDate');
	  getRes(org_id,displayDAte);

    });
	
	$(".rsNextDay").click(function(){

      var displayDAte = new Date($('.displayDate').first().text())
	  displayDAte.setDate(displayDAte.getDate() + 1);
	  getRes(org_id,displayDAte);

    });
	
	$(".rsToday").click(function(){

      var displayDAte = new Date()
	  getRes(org_id,displayDAte);

    });
});


function getRes(orgId,resDate){
	var baseurl		= "<?php echo base_url();?>";
	var short_code	= "<?php echo $this->short_code;?>";
    $('.displayDate').text(resDate.toDateString());
	$.ajax({
		type:'POST',
		url:baseurl+short_code+'/courts/get_court_reservations/',
		data:{ org_id:orgId,res_date:resDate.yyyymmdd()},    
		success:function(data){
			$('.contentTD').html('&nbsp;');
			var jsonData = JSON.parse(data)
			for(var i=0;i<jsonData.length;i++){
				populateRes(jsonData[i]);
			}
			
		}
	}); 
}
Date.prototype.yyyymmdd = function() {
  var mm = this.getMonth() + 1; // getMonth() is zero-based
  var dd = this.getDate();

  return [this.getFullYear(),
		  (mm>9 ? '' : '0') + mm,
		  (dd>9 ? '' : '0') + dd
		 ].join('');
};

function populateRes(resData) {
  var name = resData.firstname + " " + resData.lastname;
  var courtId = resData.courtid;
  var startTimeHour = resData.from_time.split(':')[0];
  var startTimeMin = resData.from_time.split(':')[1];
  var EndTimeHour = resData.to_time.split(':')[0];
  var EndTimeMin = resData.to_time.split(':')[1];
  var starttime = new Date (new Date().toDateString() + ' ' + +startTimeHour + ':' + startTimeMin);
  var EndTime = new Date (new Date().toDateString() + ' ' + +EndTimeHour + ':' + EndTimeMin);
  var diff = Math.abs(EndTime - starttime);
  var minutes = Math.floor((diff/1000)/60);
  var height = (minutes/60)* 50 -4
  var TimeRow = (startTimeHour - 5) * 2 + 1
  var startAMPM = (startTimeHour < 12) ? 'AM' : 'PM' ;
  var endAMPM = (EndTimeHour < 12) ? 'AM' : 'PM' ;
  if (EndTimeMin === '30'){
	  TimeRow++;
  }
  var tdId = courtId+'-'+TimeRow;
  var resHtml = "<div class='rsWrap' style='z-index:12;'>"
	resHtml= resHtml+"<div id='ctl00_ContentMain_TennisReservationControl1_RadScheduler1_562_0' class='rsApt rsCategoryGreen' style='height:" + height + "px;width:90%;left:0%;'>"
	resHtml= resHtml+"		<div class='rsAptOut'>"
	resHtml= resHtml+"		<div class='rsAptMid'>"
	resHtml= resHtml+"		<div class='rsAptIn'>"
	resHtml= resHtml+"		<div class='rsAptContent'>"
	resHtml= resHtml+"		<b> "
	resHtml= resHtml+name +"</b><br> "
    resHtml= resHtml+startTimeHour%12+":"+startTimeMin +" " + startAMPM + " to " +EndTimeHour%12+":"+EndTimeMin+ " " + endAMPM + " <br>"
    //resHtml= resHtml+"By:&nbsp;" + name
    resHtml= resHtml+"<a class='rsAptDelete' href='#'>delete</a>"
	resHtml= resHtml+"</div></div></div></div></div></div>"

  $("#" + tdId ).html(resHtml);
  
  return;
};

</script>
<section id="single_player" class="container secondary-page">
<div class="top-score-title right-score col-md-9">

<?php 
if(isset($add_stat)){?>
<div class="name" align='left'>
<label for="name_login" style="color:green"><?php echo $add_stat; ?></label>
</div>
<?php } ?>

<div class="col-md-12 league-form-bg" style="margin-top:18px; margin-bottom:20px;">
<div class="fromtitle">Court Details</div>
<!-- Main Body Section -->

<div id='div_add_court' class="col-md-12" style='display:block;'> <!-- Add a court section -->
<div id='res_court_status' class="col-md-8"><!-- Status of the new court booking will display here --></div>
<div class="col-md-4">
<input type="button" id="res_court" name="res_court" value="Make a Reservation" class="league-form-submit1" style="margin-bottom: 3px" />
</div>
<div style='clear:both'></div>
<br />

<div id='res_court_block' style='display:none;'> 
<!-- Reservation Block -->
<!-- <form id='frm_reserve' name='frm_reserve' method='post'> -->
<div class='col-md-6 form-group internal'>
<select name="location" id="location" class='form-control' required>
<option value=''>Select Location</option>
<?php //echo "<pre>"; print_r($locations); 
foreach($locations as $i => $loc){
?>
<option value='<?php echo $locations[$i]->loc_id; ?>'><?php echo $locations[$i]->location; ?></option>
<?php } ?>
</select>
</div>
<div class='col-md-6 form-group internal'>
<img src='<?php echo base_url();?>images/ajax_loader.gif' width='30px' height='40px' id='loading' style="display:none;" align="middle" />
<select name="court" id="court" class='form-control' required>
<option value=''>Select Court</option>
</select>
</div>
<div class='col-md-6 form-group internal'>
<input type="text" name="res_date" id="res_date" class='form-control' value="" placeholder='Select Start Date/Time' required />
</div>
<div class='col-md-6 form-group internal'>
<select name="book_hours" id="book_hours" class='form-control' required>
	<option value=''>No. of Hours</option>
	<option value='1'>1</option>
	<option value='2'>2</option>
	<option value='3'>3</option>
	<option value='4'>4</option>
	<option value='5'>5</option>
</select>
</div>
<div class='col-md-12 form-group internal'>
<input type="button" id="reserve_submit" name="reserve_submit" value="Reserve" class="league-form-submit1" style="margin:20px 0px"/>
&nbsp;&nbsp;&nbsp;
<input type="button" id="reserve_cancel" name="reserve_cancel" value="Cancel" class="league-form-submit1" style="margin:20px 0px"/>
</div>
<!-- </form> -->
<!-- Reservation Block -->
</div>


</div>
<div id='res_grid_block'> 
<?php 
foreach($locations as $i => $loc){
?>



<dt class="accordion__title"><?php echo $locations[$i]->location; ?></dt>

<dd class="accordion__content">
<div style="float: left; padding-bottom: 10px;">
<div class="RadScheduler RadScheduler_Default" style="width: 800px; top: 0px; left: 0px; overflow-y: visible;">
<div class="rsTopWrap rsOverflowExpand" style="width: 800px;">

<div class="rsHeader">
<p><a class="rsPrevDay" href="#">previous day</a>
<a class="rsNextDay" href="#">next day</a><em>
<a class="rsToday" href="#">today</a></em></p>
<a class="rsDatePickerActivator" href="#">Select date</a>
<h2 class="displayDate"></h2>
</div>

<div class="rsContent rsDayView">
<table style="width:100%;">
<tbody><tr>
<td class="rsSpacerCell">
<div>
</div></td><td class="rsHorizontalHeaderWrapper">

<div style="width: 674px;">
<div class="rsInnerFix" style="overflow:hidden;">
<table class="rsHorizontalHeaderTable" style="height:25px;width:100%;">
<tbody><tr>
<?php 
foreach($loc->courts as $i => $court){
?>
<th><div>
<?php echo $court->court_name ?>
</div></th>
<?php } ?>
</tr>
</tbody></table>
</div>
</div></td>
</tr>

<tr>
<td class="rsVerticalHeaderWrapper" style="height: 950px;"><div style="overflow: hidden; position: relative; height: 950px;">
<div style="overflow:hidden;height:100%;">
<table class="rsVerticalHeaderTable">
<tbody>
<?php for ($i = 5; $i < 24; $i++) { ?>
<tr style="height:25px;">
<th><div>
<?php echo $i % 12 == 0 ? 12 : $i % 12 ?> <span class="rsAmPm"><?php echo $i < 12 ? AM : PM ?></span>
</div></th>
</tr><tr class="rsAlt" style="height:25px;">
<th><div class="rsAlt">
&nbsp;
</div></th>
</tr>
<?php } ?>
</tbody></table>

</div>
</div></td><td class="rsContentWrapper" style="width: 674px; height: 950px;"><div class="rsContentScrollArea" style="width: 674px; height: 950px;">
<table class="rsContentTable" style="width:100%;">
<tbody>
<?php  
for ($i = 1; $i < 39; $i++){
?>
<tr style="height:25px;" <?php echo $i % 2 == 0 ? "class='rsAlt'"  : ""  ?>>
<?php 
foreach($loc->courts as $j => $court){
?>
	
      <td id="<?php echo $court->court_id.'-'.$i ?>" class="contentTD">&nbsp;</td>
  
   
<?php }?>
</tr>
<?php }?>

</tbody></table>
</div></td>
</tr>
</tbody></table>
</div><div class="rsFooter">

</div>
</div>

</div>
</div>
</dd>

<?php } ?>



</div>




</div> <!-- End of Add a court section -->

<!-- start reserve body -->

<!-- <div id='wrap' class="col-md-11">
<div id='calendar'></div>
</div> -->

<!-- end of reserve body -->

<!-- ---------------------------------------------------------------------------------------------------------------------------------- -->

<!-- End of Main Body Section -->
</div>
</div>


</div><!--Close Top Match-->