<link href="<?php echo base_url(); ?>css/reserve.css" type="text/css" rel="stylesheet" />
<link href="<?php echo base_url(); ?>css/tabs-reserve.css" type="text/css" rel="stylesheet" />
<link href="<?php echo base_url(); ?>assets/club_pages/css/tabs.css" type="text/css" rel="stylesheet">

<!-- <link type="text/css" href="<?php echo base_url(); ?>css/jquery.simple-dtpicker.css" rel="stylesheet" /> -->
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>css/jquery.datetimepicker_new.css"/>

<script src="<?=base_url();?>js/custom/general.js"></script>
<script>
	var baseurl		= "<?php echo base_url();?>";
	var short_code	= "<?php echo $this->short_code;?>";
	var org_id			= "<?php echo $this->org_id;?>";
	var r_date		= "<?php echo $this->uri->segment(4);?>";

	var disDate;

$(document).ready(function(){

	$('#block_all_day').click(function(){
		var ba = $(this).prop("checked");
		if(ba){
			$("#book_hours").removeAttr('required');
			$("#match_format").removeAttr('required');
			$("#num_players").removeAttr('required');
			$("#book_price").html('0.00');
			$("#book_price_val").val('0.00');
		}
		else{
			$("#book_hours").prop('required',true);
			$("#match_format").prop('required',true);
			$("#num_players").prop('required',true);
		}
	});

	$('#res_court').click(function(){
		$("#res_court_block").toggle();
		//$("#res_grid_block").toggle();
	});

	$('#reserve_cancel').click(function(){
		$('#frm_reserve').get(0).reset();
		$("#res_court_block").toggle();
		//$("#res_grid_block").toggle();
	});

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

	$('#court').change(function(e){
		var loc_id	  = $('#location').val();
		var court_id  = $('#court').val();
//alert('test');
			$.ajax({
				type: 'POST',
				url:baseurl+short_code+'/courts/get_court_durations/',
				data: {loc_id:loc_id, court:court_id},
				success: function(res) {
				   $('#book_hours').html(res);
				}
			});
	});

	//$('#reserve_check').on('click',function(){
	$('.check_price').change(function(e){
		var loc_id	  = $('#location').val();
		var court_id  = $('#court').val();
		var res_date  = $('#res_date').val();
		var hrs		  = $('#book_hours').val();
		//$.get_court_durations(loc_id, court_id);

		if(loc_id && court_id && res_date && hrs){
	
			$.ajax({
				type: 'POST',
				url:baseurl+short_code+'/courts/check_court_availability/',
				//data: $('#frm_reserve').serialize(),
				data: {loc_id:loc_id, court:court_id, res_date:res_date, book_hours:hrs},
				success: function(res) {
					//alert(res);
					var x = res.split('_');
					if(x[0] == 1 && x[1] != -1){
						$('#book_price').html(x[1]);
						$('#book_price_val').val(x[1]);
						//$('#reserve_submit').show();
						//alert('Court is available. Please click on Reserve Court to confirm.');
						//location.reload();
						//var onlyDate = res_date.split(' ');
						//var newdate = onlyDate[0].split("/").reverse().join("-");
						 //window.location.href = baseurl+short_code+"/courts/reserve/"+newdate;
					}
					else if(res == 2){
						alert('Court booking time exceeding to the next day!');
						$('#book_price').html('N/A');
						$('#book_price_val').val('');
					}
					else if(res == 0){
						alert("Court is already reserved!");
						$('#book_price').html('N/A');
						$('#book_price_val').val('');
					}
					else if(res == 3){
						alert("Court is not available for this timing!");
						$('#book_price').html('N/A');
						$('#book_price_val').val('');
					}
					else if(x[1] == -1){
						alert("Court is not available for this timing!");
						$('#book_price').html('N/A');
						$('#book_price_val').val('');
					}
				}
			});
			e.preventDefault();
		}
	});


	$(function(){
		/*$('*[name=res_date]').appendDtpicker({
			"inline": false,
			"futureOnly": true,
			"autodateOnStart": false,
			"dateFormat": "MM/DD/YYYY h:m",
			"closeOnSelected": true
		});*/
		$('.rsDatePickerActivator').appendDtpicker({
			"inline": false,
			"futureOnly": false,
			//"closeOnSelected": true,
			"dateOnly":true,
			"dateFormat": "MM/DD/YYYY",
			"onHide": function(handler){
				var org_id		= "<?php echo $this->org_id;?>";
				var displayDAte = $('.rsDatePickerActivator').handleDtpicker('getDate');
				disDate = displayDAte;

				getRes(org_id,displayDAte);
			}
		});
	});
 
	$(".rsPrevDay").click(function(){
	  var displayDAte = new Date($('.displayDate').first().text())
	  displayDAte.setDate(displayDAte.getDate() - 1);
	  disDate = displayDAte;

	  getRes(org_id,displayDAte);
    });
	
	$(".rsDatePickerActivator").click(function(){
	  var displayDAte = $('.rsDatePickerActivator').handleDtpicker('getDate');
  	  disDate = displayDAte;

	  getRes(org_id,displayDAte);
    });
	
	$(".rsNextDay").click(function(){

      var displayDAte = new Date($('.displayDate').first().text())
	  displayDAte.setDate(displayDAte.getDate() + 1);
  	  disDate = displayDAte;

	  getRes(org_id,displayDAte);
    });
	
	$(".rsToday").click(function(){

      var displayDAte = new Date();
  	  disDate = displayDAte;

	  getRes(org_id,displayDAte);

    });
});


function getRes(orgId,resDate){
	var baseurl		= "<?php echo base_url();?>";
	var short_code	= "<?php echo $this->short_code;?>";
	  	  disDate = resDate.toDateString();

    $('.displayDate').text(resDate.toDateString());
	$.ajax({
		type:'POST',
		url:baseurl+short_code+'/courts/get_court_reservations/',
		data:{ org_id:orgId,res_date:resDate.yyyymmdd()},    
		success:function(data){
			$('.contentTD').html('&nbsp;');
			$('.rowTD').addClass("contentTD");
			$('.rowTD').css('background', 'white');
			$('.rowTD').html('');
			var jsonData = JSON.parse(data);
				//console.log(jsonData);
			/*for(var i=0;i<jsonData.length;i++){
				populateRes(jsonData[i]);
			}*/

			for (var loc in jsonData) {
				for (var court in jsonData[loc]) {
					//console.log(jsonData[loc][court]['reserve']);
					if (jsonData[loc][court]['reserve'])
						populateRes(jsonData[loc][court]['reserve']);

					if (jsonData[loc][court]['break']) {
						for(var i=0; i<jsonData[loc][court]['break'].length; i++) {
						blockRes(court, jsonData[loc][court]['break'][i]);
						}
					}

					if (jsonData[loc][court]['timings']) {
						//console.log('timings '+jsonData[loc][court]['timings']);
						//blockRes2(court, jsonData[loc][court]['timings']);
					}
				}
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
	for (var ind in resData) {
console.log(resData);
  //var name			= resData.firstname + " " + resData.lastname;
  var name				= resData[ind].player;
  var courtId				= resData[ind].courtid;
  var num_players		= resData[ind].num_players;
  var match_format	= resData[ind].match_format;
  var startTimeHour	= resData[ind].from_time.split(':')[0];
  var startTimeMin		= resData[ind].from_time.split(':')[1];
  var EndTimeHour	= resData[ind].to_time.split(':')[0];
  var EndTimeMin	= resData[ind].to_time.split(':')[1];
  var starttime		= new Date (new Date().toDateString() + ' ' + +startTimeHour + ':' + startTimeMin);
  var EndTime		= new Date (new Date().toDateString() + ' ' + +EndTimeHour + ':' + EndTimeMin);
  var diff				= Math.abs(EndTime - starttime);
 // alert(diff);
  var minutes		= Math.floor((diff/1000)/60);
  //var height			= (minutes/60)* 50 -4
  var tmp				= (minutes/60);
  var height			= (tmp * (80))  -4
  /*var TimeRow = (startTimeHour - 5) * 2 + 1*/
  var TimeRow		= (startTimeHour) * 2 + 1
  var startAMPM	= (startTimeHour < 12) ? 'AM' : 'PM' ;
  var endAMPM		= (EndTimeHour < 12) ? 'AM' : 'PM' ;
 // if (EndTimeMin === '30' || EndTimeMin > '30'){
  if (EndTimeMin === '30'){
	  TimeRow++;
  }
  var tdId = courtId+'-'+TimeRow;

  $("#" + tdId ).html('');

  var resHtml = "<div class='rsWrap' style='z-index:12;'>"
	resHtml= resHtml+"<div id='ctl00_ContentMain_TennisReservationControl1_RadScheduler1_562_0' class='rsApt rsCategoryGreen' style='height:" + height + "px;width:90%;left:0%;'>"
	resHtml= resHtml+"		<div class='rsAptOut'>"
	resHtml= resHtml+"		<div class='rsAptMid'>"
	resHtml= resHtml+"		<div class='rsAptIn'>"
	resHtml= resHtml+"		<div class='rsAptContent'>"
	resHtml= resHtml+"		<b> "
	resHtml= resHtml+name +"</b>"
	resHtml= /*resHtml+"&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;"*/
	resHtml= resHtml+"&nbsp(<b>"+num_players+"</b>)&nbsp;"+match_format+"<br> "
    resHtml= resHtml+startTimeHour%12+":"+startTimeMin +" " + startAMPM + " - " +EndTimeHour%12+":"+EndTimeMin+ " " + endAMPM + " <br>"
    //resHtml= resHtml + "" + match_format
		"<?php if($this->logged_user == $this->academy_admin){ ?>"
    resHtml= resHtml+"<a class='rsAptDelete' id='del_"+resData[ind].id+"' style='visibility:visible; cursor:pointer'>delete</a>"
		"<?php } else {?>"
    //resHtml= resHtml+"<a class='rsAptDelete' href='#'>delete</a>"
		"<?php } ?>"

	resHtml= resHtml+"</div></div></div></div></div></div>"


  $("#" + tdId ).removeClass("contentTD");
  $("#" + tdId ).html(resHtml);
	}
  return;
};

function blockRes(court, resData) {

//console.log(resData);
  var courtId		= court;
  var startTimeHour = resData.start_time.split(':')[0];
  //var startTimeMin  = resData.start_time.split(':')[1];
  var EndTimeHour	= resData.end_time.split(':')[0];
  /* var EndTimeMin	= resData.end_time.split(':')[1];
  var starttime		= new Date (new Date().toDateString() + ' ' + +startTimeHour + ':' + startTimeMin);
  var EndTime		= new Date (new Date().toDateString() + ' ' + +EndTimeHour + ':' + EndTimeMin);
  var diff			= Math.abs(EndTime - starttime);
  var minutes		= Math.floor((diff/1000)/60);
  var height		= (minutes/60)* 50 -4*/
  /*var TimeRow = (startTimeHour - 5) * 2 + 1*/


  for(var i = startTimeHour; i < EndTimeHour; i++) {
	  var TimeRow = i * 2 + 1;

	  var tdId  = courtId+'-'+TimeRow;
	  $("#" + tdId ).removeClass("contentTD");
	  $("#" + tdId ).css('background', '#e4e4e4');

	  var tdId2  = courtId+'-'+(TimeRow+1);
	  $("#" + tdId2 ).removeClass("contentTD");
	  $("#" + tdId2 ).css('background', '#e4e4e4');

  }



  /*var startAMPM		= (startTimeHour < 12) ? 'AM' : 'PM' ;
  var endAMPM		= (EndTimeHour < 12) ? 'AM' : 'PM' ;
  if (EndTimeMin === '30'){
	  TimeRow++;
  }*/

  
  return;
};


function blockRes2(court, resData2) {

//console.log('inside '+resData2);
  var courtId		= court;
  var startTimeHour = resData2.start_time.split(':')[0];
  //var startTimeMin  = resData2.start_time.split(':')[1];
  var EndTimeHour	= resData2.end_time.split(':')[0];
  /* var EndTimeMin	= resData2.end_time.split(':')[1];
  var starttime		= new Date (new Date().toDateString() + ' ' + +startTimeHour + ':' + startTimeMin);
  var EndTime		= new Date (new Date().toDateString() + ' ' + +EndTimeHour + ':' + EndTimeMin);
  var diff			= Math.abs(EndTime - starttime);
  var minutes		= Math.floor((diff/1000)/60);
  var height		= (minutes/60)* 50 -4*/
  /*var TimeRow = (startTimeHour - 5) * 2 + 1*/


  for(var i = 0; i <= 23; i++) {
	  var TimeRow = i * 2 + 1;

	  if(i < startTimeHour || i >= EndTimeHour){
		  var tdId  = courtId+'-'+TimeRow;
		  $("#" + tdId ).removeClass("contentTD");
		  $("#" + tdId ).css('background', '#e4e4e4');

		  var tdId2  = courtId+'-'+(TimeRow+1);
		  $("#" + tdId2 ).removeClass("contentTD");
		  $("#" + tdId2 ).css('background', '#e4e4e4');
	  }
  }


  /*var startAMPM		= (startTimeHour < 12) ? 'AM' : 'PM' ;
  var endAMPM		= (EndTimeHour < 12) ? 'AM' : 'PM' ;
  if (EndTimeMin === '30'){
	  TimeRow++;
  }*/

  
  return;
};

$(document).ready(function(){
    $("#myBtn").click(function(){
        $("#myModal").modal();
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
          <h3>Pay and Play</h3>
        </div>
      </div>
    </div>
    
  </div>
</div>
<!-- Breadcromb Wrapper End --> 

<section class="inner-page-wrapper">
  <div class="container">
  
<div class="col-md-12">

<?php 
if(isset($add_stat)){?>
<div class="name" align='left'>
<label for="name_login" style="color:green"><?php echo $add_stat; ?></label>
</div>
<?php } ?>

<div class="col-md-12">
<!-- <div class="fromtitle">Court Details</div> -->
<!-- Main Body Section -->

<div id='div_add_court' style='display:block;'> <!-- Add a court section -->
<div id='res_court_status' class="col-md-8"><!-- Status of the new court booking will display here --></div>
<div class="col-md-4" style='text-align: right;'>
<input type="button" id="res_court" name="res_court" value="Make a Reservation" class="book-submit" style="margin-bottom: 3px; display:none;" />
</div>
<div style='clear:both'></div>
<br />

<div style="margin-bottom: 20px;"><b>Note:</b> Double click on the desired time slot to make a booking.</div>
<div id='res_court_block' style='display:none;'> 
<!-- Reservation Block -->
<!-- <form id='frm_reserve' name='frm_reserve' method='post' action='<?php echo base_url().$this->short_code."/courts/block_court" ?>'>
<div class='col-md-6 form-group internal'>
<select name="loc_id" id="location" class='form-control check_price' required>
<option value=''>Select Location</option>
<?php
foreach($locations as $i => $loc){
?>
<option value='<?php echo $locations[$i]->loc_id; ?>'><?php echo $locations[$i]->location; ?></option>
<?php } ?>
</select>
</div>
<div class='col-md-6 form-group internal'>
<img src='<?php echo base_url();?>images/ajax_loader.gif' width='30px' height='40px' id='loading' style="display:none;" align="middle" />
<select name="court" id="court" class='form-control check_price get_durations' required>
<option value=''>Select Court</option>
</select>
</div>
<div class='col-md-6 form-group internal'>
<input type="text" name="res_date" id="res_date" class='form-control check_price' value="" placeholder='Select Start Date/Time' required />
</div>
<div class='col-md-6 form-group internal'>
<select name="book_hours" id="book_hours" class='form-control check_price' required>
	<option value=''>Duration</option>
</select>
</div>
<div class='col-md-6 form-group internal'>
<select name="match_format" id="match_format" class='form-control' required>
	<option value=''>Game Format</option>
	<option value='Singles'>Singles</option>
	<option value='Doubles'>Doubles</option>
	<option value='Mixed'>Mixed Doubles</option>
	<option value='Training'>Training</option>
</select>
</div>
<div class='col-md-6 form-group internal'>
<select name="num_players" id="num_players" class='form-control' required>
	<option value=''>Players#</option>
	<option value='1'>1</option>
	<option value='2'>2</option>
	<option value='3'>3</option>
	<option value='4'>4</option>
	<option value='5'>5</option>
	<option value='6'>6</option>
</select>
</div>
<div class='col-md-12 form-group internal' id='players_section'></div>
<div class='col-md-6 form-group internal'>
Booking Price: <span id='book_price'></span>
<input type='hidden' name='book_price_val' id='book_price_val' value='' />
</div>
<?php if($this->logged_user == $this->academy_admin){ ?>
<div class='col-md-6 form-group internal'>
<input type='checkbox' name='block_all_day' id='block_all_day' value='1' /> Block all day?
</div>
<?php } ?>
<div class='col-md-12 form-group internal'>
<input type="submit" id="reserve_submit" name="reserve_submit" value="Book" class="book-submit" style="margin:20px 0px;"/>
&nbsp;&nbsp;&nbsp;
<input type="button" id="reserve_cancel" name="reserve_cancel" value="Cancel" class="cancel-submit" style="margin:20px 0px"/>
</div>
</form>-->
<!-- Reservation Block -->
</div>

</div>
<div id='res_grid_block'> 
<?php 
foreach($locations as $i => $loc){
?>
<dt class="accordion__title"><?php echo $locations[$i]->location; ?></dt>

<dd class="accordion__content">
<div style="padding-bottom: 10px; margin-top: 11px;">
<span><b>Total Number of Players Reserved: <?php echo $locations[$i]->res_count; //echo date('Y-m-d H:i:s');?></b></span>
<div class="RadScheduler RadScheduler_Default" style="width: 100%; top: 0px; left: 0px; overflow-y: visible;">
<div class="rsTopWrap rsOverflowExpand">

<div class="rsHeader" style='z-index: 0;'>
<p><a class="rsPrevDay" href="#">previous day</a>
<a class="rsNextDay" href="#">next day</a><em>
<a class="rsToday" href="#">Today</a></em></p>
<!-- <a class="rsDatePickerActivator" href="#">Select date</a> -->
<h2 class="displayDate"></h2>
</div>

<div class="rsContent rsDayView table-responsive">
<table style="width:100%;">
<tbody><tr>
<td class="rsSpacerCell">
<div>
</div></td><td class="rsHorizontalHeaderWrapper">

<div>
<div class="rsInnerFix" style="overflow:hidden;">
<table class="rsHorizontalHeaderTable" style="height:25px;width:100%;">
<tbody><tr>
<?php 
foreach($loc->courts as $i => $court){
?>
<th><div>
<?php echo $court->court_name;
$min_max = courts :: get_min_max_court_time($loc->loc_id);
//$info_arr = json_decode($court->court_info_json, true);
//if($this->logged_user == 240)
	//echo "<pre>"; print_r($min_time); echo intval($min_max['min']); exit;
?>
</div></th>
<?php } ?>
</tr>
</tbody></table>
</div>
</div></td>
</tr>

<tr>
<td class="rsVerticalHeaderWrapper" style="height: 100%;"><div style="overflow: hidden; position: relative; height: 100%;">
<div style="overflow:hidden;height:100%;">
<table class="rsVerticalHeaderTable">
<tbody>
<?php //for ($i = 5; $i < 24; $i++) { ?>
<?php //for ($i = 0; $i < 24; $i++) { ?>
<?php for ($i = intval($min_max['min']); $i < intval($min_max['max']); $i++) { ?>
<tr style="height:40px;">
<th><div>
<?php echo $i % 12 == 0 ? 12 : $i % 12 ?> <span class="rsAmPm"><?php echo $i < 12 ? AM : PM ?></span>
</div></th>
</tr><tr class="rsAlt" style="height:40px;">
<th><div class="rsAlt">
&nbsp;
</div></th>
</tr>
<?php } ?>
</tbody></table>

</div>
</div>
</td>
<td class="rsContentWrapper" style="width: 100%; height: 100%;">
<div class="rsContentScrollArea" style="width: 100%; height: 100%;">
<table class="rsContentTable" style="width:100%; height: 100%;">
<tbody>
<?php  
//for ($i = 1; $i < 39; $i++){
//for ($i = 1; $i < 49; $i++){

for ($i = ((intval($min_max['min']) * 2) +1); $i <=(intval($min_max['max']) * 2); $i++){
?>
<tr style="height:40px;" <?php echo $i % 2 == 0 ? "class='rsAlt'"  : ""  ?>>
<?php 
foreach($loc->courts as $j => $court){
	/*$court_info = json_decode($court->court_info_json, true);
	echo "<pre>"; 
	print_r($court_info['court_prices']);*/
	//exit;
?>
      <td id="<?php echo $court->court_id.'-'.$i ?>" class="contentTD rowTD">&nbsp;</td>
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

<!-- <div id="show_reserve_frm" title="Reserve a Court" style="width:500px;display:none"></div> -->



<!-- aditya -->
  <div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog modal-lg">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header" style="padding:20px !important;">
          
          <h4 class="modal-title">Reserve</h4>
		  <button type="button" class="close" data-dismiss="modal" style='margin-top: -25px !important;'>&times;</button>
        </div>
        <div class="modal-body">
			<div id='show_reserve_frm'>Reserve Popup will load here...</div>
        </div>
        <div class="modal-footer" style='border-top: 0px solid;'>
          &nbsp;<!-- <button type="button" class="btn btn-default green-but" data-dismiss="modal">Close</button> -->
        </div>
      </div>
      
    </div>
  </div><!-- aditya -->
  
<script>
$(document).ready(function(){
	
	/*$('.contentTD').click(function(){
		$("#myModal").modal();
	});*/

	$(document).on('dblclick', '.contentTD', function(){
	
		var id = $(this).attr('id');
		//var displayDAte = $('.rsDatePickerActivator').handleDtpicker('getDate');
		var sp = id.split('-');

		$.ajax({
			type:'POST',
			url:baseurl+short_code+'/courts/get_reserve_popup/',
			data:{ id:id, time: sp[1], date:disDate, court:sp[0]},    //{pt:'7',rngstrt:range1, rngfin:range2},
			success:function(res){
				/*$("#show_reserve_frm").dialog({
				resizable: false,
				modal: true,
				width: 500,
				minheight: 500,
				});*/
				$("#show_reserve_frm").html(res);
				$("#myModal").modal();
			}
		}); 

	});
});
</script>
<script src="js/jquery-1.10.2.js" type="text/javascript"></script>
<script src="js/jquery-migrate-1.2.1.min.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>js/responsive-tabs.js" type="text/javascript"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>js/jquery.simple-dtpicker.js"></script>

<!--MENU-->
<script src="<?php echo base_url(); ?>js/menu/modernizr.custom.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>js/menu/cbpHorizontalMenu.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>js/tabs.js" type="text/javascript"></script>

<!-- Button Anchor Top-->
<script src="<?php echo base_url(); ?>js/jquery.ui.totop.js" type="text/javascript"></script>
<script>
$('.accordion__content:not(:first)').hide();
$('.accordion__title:first-child').addClass('active');
$('.accordion__title').on('click', function () {
$('.accordion__content').hide();
$(this).next().show().prev().addClass('active').siblings().removeClass('active');
});
//@ sourceURL=pen.js
</script>

<script>
$(document).ready(function(){
	var log_user			= "<?php echo $logged_user; ?>";
	var log_user_id	= "<?php echo $this->logged_user; ?>";
	var adm_user		= "<?php echo $this->academy_admin; ?>";
	$('#num_players').change(function(){
		var num = $(this).val();
		$('#players_section').html('');
		for(var i=0; i < num; i++){
			if(i==0 && log_user_id != adm_user){
			$row = $("<div class='col-md-6' style='margin-bottom:1px;'><input type='text' class='form-control' name='players[]' placeholder='Player #"+(i+1)+"' value='"+log_user+"' readonly /></div>");
			}
			else if(i==0 && log_user_id == adm_user){
			$row = $("<div class='col-md-6' style='margin-bottom:1px;'><input type='text' class='form-control' name='players[]' placeholder='Player #"+(i+1)+"' value='"+log_user+"' /></div>");
			}
			else{
			$row = $("<div class='col-md-6' style='margin-bottom:1px;'><input type='text' class='form-control' name='players[]' placeholder='Player #"+(i+1)+"' value='' /></div>");
			}

			$('#players_section').append($row);
			
		}
	});
	$(document).on('change', '#num_players1', function(){
	
		var num = $(this).val();
		$('#players_section1').html('');
		for(var i=0; i < num; i++){
			if(i==0 && log_user_id != adm_user){
			$row = $("<div class='col-md-6' style='margin-bottom:1px;'><input type='text' class='form-control' name='players[]' placeholder='Player #"+(i+1)+"' value='"+log_user+"' readonly /></div>");
			}
			else if(i==0 && log_user_id == adm_user){
			$row = $("<div class='col-md-6' style='margin-bottom:1px;'><input type='text' class='form-control' name='players[]' placeholder='Player #"+(i+1)+"' value='"+log_user+"' /></div>");
			}
			else{
			$row = $("<div class='col-md-6' style='margin-bottom:1px;'><input type='text' class='form-control' name='players[]' placeholder='Player #"+(i+1)+"' value='' /></div>");
			}

			$('#players_section1').append($row);
			
		}
	});

	$(document).on('click', '#reserve_submit', function(){

		if($('#book_price_val').val() == ''){
			alert('Selected booking slot is not available!');
			return false;
		}
	});

	$(document).on('click', '.rsAptDelete', function(){

		if(confirm("Are you sure to delete the booking?")){
		var id = $(this).attr('id');
		var sp = id.split('_');

		$.ajax({
			type:'POST',
			url:baseurl+short_code+'/courts/cancel_booking',
			data:{ rec:sp[1]},    //{pt:'7',rngstrt:range1, rngfin:range2},
			success:function(res){
				alert("Booking is deleted successfully");
				location.reload();
				/*$("#show_reserve_frm").dialog({
				resizable: false,
				modal: true,
				width: 500,
				minheight: 500,
				});*/
				//$("#show_reserve_frm").html(res);
				//$("#myModal").modal();
			}
		}); 

		}

		//alert($(this).attr('id'));
	});
});
</script>

<script src="<?php echo base_url(); ?>js/custom.js" type="text/javascript"></script>

</div> <!-- End of Add a court section -->

<!-- start reserve body -->

<!-- <div id='wrap' class="col-md-11">
<div id='calendar'></div>
</div> -->

<!-- end of reserve body -->

<!-- ---------------------------------------------------------------------------------------------------------------------------------- -->

<!-- End of Main Body Section -->
</div>
<!-- </div> -->

<!-- </div> --><!--Close Top Match-->

</div>
</section>
<script>
$(document).ready(function(){
	$(document).on('change', '#repeat_booking_week',  function(){
		if($('#repeat_booking_days').val() != '0')
		$('#repeat_booking_days').val('0');

		var bd = $('#repeat_booking_week').val();
		var rd = $('#res_date1').val();
		var rt  = $('#res_time1').val();
		var slt  = $('#book_hours1').val();
		var court  = $('#court1').val();

		$('#next_days').html('');

		if(bd != '0' && rd && rt && slt && court){
			get_next_dates(court, bd,rd,rt,slt,'week');
		}
		else if(bd != '0'){
			alert('Select the Court, Date, Time & Duration!');
			$('#repeat_booking_days').val('0');
		}

	});
	$(document).on('change', '#repeat_booking_days',  function(e){
		if($('#repeat_booking_week').val() != '0')
		$('#repeat_booking_week').val('0');

		var bd = $('#repeat_booking_days').val();
		var rd = $('#res_date1').val();
		var rt  = $('#res_time1').val();
		var slt  = $('#book_hours1').val();
		var court  = $('#court1').val();
		
		$('#next_days').html('');

		if(bd != '0' && rd && rt && slt && court){
			get_next_dates(court, bd,rd,rt,slt,'day');
		}
		else if(bd != '0') {
			alert('Select the Court, Date, Time, & Duration!');
			$('#repeat_booking_days').val('0');
		}
	});

	function get_next_dates(court, bd, rd, rt, slt, tp){
			$.ajax({
				type: 'POST',
				url:baseurl+short_code+'/courts/get_next_dates/',
				//data: $('#frm_reserve').serialize(),
				data: {court:court, bd:bd, rd:rd, rt:rt, tp:tp, slt:slt},
				success: function(res) {
					$('#next_days').html('');
					$('#next_days').html(res);
					//alert(res);
					//var x = res.split('_');
					/*if(x[0] == 1 && x[1] != -1){
						$('#book_price1').html(x[1]);
						$('#book_price_val1').val(x[1]);
					}*/
				}
			});
			e.preventDefault();

	}
});
</script>