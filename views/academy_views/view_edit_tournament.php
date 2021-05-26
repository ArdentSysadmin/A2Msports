<script src="<?=base_url();?>assets/tinymce/tinymce.min.js"></script>
<link href="<?php echo base_url();?>css/foundation-datepicker.css" rel="stylesheet">
<link href="<?php echo base_url();?>css/bootstrap-timepicker.min.css" rel="stylesheet">
  
<script>
var tour_format = "<?php echo $tournament_details->tournament_format;?>";
var db_country = "<?php echo $tournament_details->TournamentCountry; ?>";

tinymce.init({
  selector: '#desc',
  height: 500,
  theme: 'modern',
  plugins: [
    'advlist autolink lists link image charmap print preview hr anchor pagebreak',
    'searchreplace wordcount visualblocks visualchars code fullscreen',
    'insertdatetime media nonbreaking save table contextmenu directionality',
    'template paste textcolor colorpicker textpattern imagetools codesample toc help'
  ],
  toolbar1: 'undo redo | insert | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image',
  toolbar2: 'print preview media | forecolor backcolor emoticons | codesample help',
  image_advtab: true,
  templates: [
    { title: 'Test template 1', content: 'Test 1' },
    { title: 'Test template 2', content: 'Test 2' }
  ],
  content_css: [
    '//fonts.googleapis.com/css?family=Lato:300,300i,400,400i',
    '//www.tinymce.com/css/codepen.min.css'
  ]
 });

var multiEvent_indexs = [];
"<?php foreach($multiEvents_keys as $val) { ?>"
 multiEvent_indexs.push("<?php echo $val; ?>");
"<?php } ?>"

	//alert(multiEvent_indexs);
 
</script>
<script>
$(document).ready(function(){

//	$("#Combinations").click(function(){
		//function alertMessage(){
	$("#selected_events").html('');
	

	$("input[name='fee']").click(function () {
		if($("#chkYes").is(":checked")) {
			$("#div_fee_section").show();
			$("#event_fee_section").show();	
		} 
		else {
			$("#div_fee_section").hide();
			$("#event_fee_section").hide();
		}
	});

	$(".x1").click(function (){
		var mtype_id = $(this).attr('id');
		
		var s_stat  = $('#singles').is(":checked");
		var d_stat  = $('#doubles').is(":checked");
		var m_stat  = $('#mixed').is(":checked");

		if(s_stat && (d_stat || m_stat)){	
			if($('input[name^="addn_fee_collect"]').length == 0){
				$('.div_grp').each(function() {
					var $ctrl = $("<div class='col-md-2'><input type='text' class='form-control' name='addn_fee_collect[]' placeholder='Additional Fee' value='0.00' /></div>");
					$(this).append($ctrl);
				});
			}
		}
		else{
			//alert('Additional Fee Not Required');
			$('input[name^="addn_fee_collect"]').each(function() {
				$(this).parent('div').remove();
				$(this).remove();
			});
		}
	
	});

	$(".age").click(function (e){
	//alert(1);
	var ch_id		  = $(this).attr('id');
	var isReadonly = $("#"+ch_id).attr('readonly');
	    if(isReadonly == 'readonly'){
          die();
	    }
   
	var stat		  = $('#' + ch_id).is(":checked");
	var age_grp_label = $('label[for='+ch_id+']').text();
	var is_team		  = $('#tour_format').val();
	
	if(is_team != 'Teams' && is_team != 'TeamSport'){
		if($('#singles').is(":checked") || $('#doubles').is(":checked") || $('#mixed').is(":checked")){
		var	label_text = "<div class='col-md-2' style='padding-top:5px;'>"+age_grp_label+"<input type='hidden' class='form-control' name='age_group[]' value='"+ch_id+"' /></div>";
		}else{
		var label_text = "";
		}

		if($('#singles').is(":checked")){
		var	fee_amount = "<div class='col-md-2'><input type='text' class='form-control' name='fee_collect[]' placeholder='Fee Amount' value='0.00' /></div>";
		}else{
		var fee_amount = "";
		}
	
		if($('#doubles').is(":checked") || $('#mixed').is(":checked")){
		var	add_fee_amount = "<div class='col-md-2'><input type='text' class='form-control' name='addn_fee_collect[]' placeholder='Additional Fee' value='0.00' /></div>";
		}else{
		var add_fee_amount = "";
		}
	}
	else{
		var add_fee_amount = "";
		var	label_text = "<div class='col-md-2' style='padding-top:5px;'>"+age_grp_label+"<input type='hidden' class='form-control' name='age_group[]' value='"+ch_id+"' /></div>";

		var	fee_amount = "<div class='col-md-2'><input type='text' class='form-control' name='fee_collect[]' placeholder='Fee Amount' value='0.00' /></div>";
	}

	if(stat){
	var i = 0;
	var $ctrl = $("<div class='col-md-12 div_grp' id='div_"+ch_id+"' style='padding-bottom:4px;'>"+label_text+fee_amount+add_fee_amount+"</div>");
				$("#dyn_courts").append($ctrl);
	}
	else{
	$("#dyn_courts #div_"+ch_id+"").remove();
	}

	});

	$("#tourn_type").change(function(){
		if($(this).val() == 'Flexible League'){
			$("#addr_group").hide();
			$("#addr_group :input").attr("disabled", true);
		}else{
			$("#addr_group :input").attr("disabled", false);
			$("#addr_group").show();
		}
	});

	var tour_type = "<?php echo $tournament_details->Tournament_type; ?>";

	if(tour_type == 'Flexible League'){
		$("#addr_group").hide();
		$("#addr_group :input").attr("disabled", true);
	}

});
</script>

<script>
$( document ).ready(function() {

  $('#start_time').timepicker();
  $('#end_time').timepicker();
  $('#regs_open_time').timepicker();
  $('#regs_close_time').timepicker();

   $('.eventTime').fdatepicker({
    format: 'mm/dd/yyyy hh:ii',
    disableDblClickSelection: true,
    language: 'en',
    pickTime: true
  });
/* ********************* Date Picker Code For Coupon Codes Starts Here. ********************************* */
  $('body').on('focus','.expiry_date', function(){
    $(this).fdatepicker({
		format: 'mm/dd/yyyy',
		disableDblClickSelection: true,
		language: 'en',
		pickTime: false
    });
  });
});
</script>

<script>
function upperCase(a){
    setTimeout(function(){
        a.value = a.value.toUpperCase();
    }, 1);
}
</script>
<!-- ********************* Date Picker Code For Coupon Codes Ends Here. ********************************* -->

<script type="text/javascript">
function doCompareDate(){
var sdate1 = document.getElementById("start_date").value;
//var edate1 = document.getElementById("edate").value;
var reg_close = document.getElementById("reg_closed_on").value;

var x = new Date(sdate1);
var z = new Date(reg_close);

//if (z > x ) {
if(0){
alert("Registration close date can not be greater than start date");
return false;
}
else{
return true;
}
 
}
</script>

<script>
function CompareDate() {
		var sdate1 = document.getElementById("start_date").value;
		var edate1 = document.getElementById("end_date").value;

		var x = new Date(sdate1);
		var y = new Date(edate1);

		if (x > y){
			alert("Start date can not be greater than End date.");
			return false;
		}
	}
</script>

<script type="text/javascript">
$(function () {
	$("input[name='fee']").click(function () {
		if ($("#chkYes").is(":checked")) {

				/*var checked =  $('#singles:checkbox:checked').length > 0;
				var checked1 =  $('#doubles:checkbox:checked').length > 0;
				var checked2 =  $('#mixed:checkbox:checked').length > 0;

				if ((checked == true && checked1 == true) || (checked1 == true && checked2 == true) || (checked2 == true && checked == true)) {
				
				if ($("#chkYes").is(":checked")) {
					$("#div_fee_section").show();
				}
				} 
				else {
					$("#div_fee_section").hide();
				}*/

			$("#div_fee_section").show();
			$("#couponCode_section").show();
		} 
		else 
		{
			$("#div_fee_section").hide();
			$("#couponCode_section").hide();
		}
	   });

	    $("input[name='event']").click(function () {
		    if ($("#EvntYes").is(":checked")) {
		  	    $("#div_event_section").show();
		    }else{
                $("#div_event_section").hide();
		    }
	    });
  
	/* *************************** JQuery Code For CouponCode Starts Here ********************************* */
		$("input[name='cc']").click(function (){
		if($("#ccYes").is(":checked")) {
			$('#couponCode_details').show();
		}
		else{
			$('#couponCode_details').hide();
		}
	});
	/* *************************** JQuery Code For CouponCode Ends Here ********************************* */
});

</script>

<script type="text/javascript">
$(function () {
	 $(document.body).delegate('[type="checkbox"][readonly="readonly"]', 'click', function(e) {
        e.preventDefault();
    });
		$('input[name="levels[]"]').click(function(){
			 if ($("#EvntYes").is(":checked") || $("#EvntTimeYes").is(":checked") || $("#EvntFeesYes").is(":checked")) {
		    }
		   
		});
		$('input[name="singles[]"]').click(function(){
		     if ($("#EvntYes").is(":checked") || $("#EvntTimeYes").is(":checked") || $("#EvntFeesYes").is(":checked")) {
		    }
		});
		$('input[name="age[]"]').click(function(){
		    if ($("#EvntYes").is(":checked") || $("#EvntTimeYes").is(":checked") || $("#EvntFeesYes").is(":checked")) {
		    }
		});
	
	$("input[name='event_time']").click(function () {
	    if ($("#EvntTimeYes").is(":checked")) {
	  	    $("#div_event_time_section").show();
        }else{
            $("#div_event_time_section").hide();
        }
    });

});

	$(document).ready(function(){
        $('input[type="checkbox"]').click(function(){
		   var checked =  $('#singles:checkbox:checked').length > 0;
		   var checked1 =  $('#doubles:checkbox:checked').length > 0;
		   var checked2 =  $('#mixed:checkbox:checked').length > 0;		
		
		    if ((checked == true && checked1 == true) || (checked1 == true && checked2 == true) || (checked2 == true && checked == true)) {
			 
			    if ($("#chkYes").is(":checked")) {
			        $("#add_event").show();
			    }
		    } 
			else {
			    $("#add_event").hide();
		    }
        });
    });
</script>

<script>
$(document).ready(function(){

	$('#country').on('change', function() {
		if ( this.value == 'United States of America'){
			$("#state_drop").show();
			$("#state_box").hide();
		}
		else{
			$("#state_drop").hide();
			$("#state_box").show();
		}
	});

});
</script>

<script type="text/javascript">
/*$(document).ready(function(){
    $('#open_gender').click(function(){
			$("#mixed").removeAttr("disabled"); 
	});

    $('#male, #female').click(function(){
		 if ($("#mixed").is(":checked")) {
				$('#mixed').attr('checked', false);
			 }
		$("#mixed").attr("disabled", true); 
	});
});*/
</script>

<script>
$(function () {
  /* Add Dynamic Sponsors Sections*/
      var i=1;  

      $('#add').click(function(){  
           i++;  
           $('#dynamic_field').append('<tr id="row'+i+'" class="dynamic-added"><td style="border-top: 0px solid #ddd;"><input style="font-size:14px;" type="file" name="spnsr_file_name[]"  /></td><td style="border-top: 0px solid #ddd;"><input class="form-control" type="text" name="spnsr_addr_link[]" placeholder="Enter Sponsor Link"  /></td><td style="border-top: 0px solid #ddd;"><button type="button" name="remove" id="'+i+'" class="btn btn-danger btn_remove">X</button></td></tr>');  
      });


      $(document).on('click', '.btn_remove', function(){  
           var button_id = $(this).attr("id");   
           $('#row'+button_id+'').remove();  
      });
     /* End Dynamic Sponsors Section*/

	 /* *********************JQuery Code To Add Coupons Dynamically ************************************ */

		 var i=1;  
      $('#addCoupons').click(function(){  
           i++;  
           $('#coupons').append('<tr id="row'+i+'" class="dynamic-added"><td style="border-top: 0px solid #ddd;"><input class="form-control" id="coupon_code" name="coupon_code[]" type="text" style="width:95%" placeholder="Coupon Code" pattern="[0-9A-Za-z\\-]+" onkeydown="upperCase(this);" required /></td><td style="border-top: 0px solid #ddd;"><select class="form-control" name="coupon_method[]" id="coupon_method" style="width:100%"> <option value="fixedprice">Fixed Price</option><option value="percentage">Percentage</option></select></td><td>&nbsp;&nbsp;&nbsp;</td><td style="border-top: 0px solid #ddd;"><input class="form-control" id="coupon_value" name="coupon_value[]" type="text" style="width:50%" placeholder="Value" required /></td><td style="border-top: 0px solid #ddd;"><input type="text" class="form-control expiry_date" placeholder="Expiry Date" name="expiry_date[]" style="width:70%" required /> </td><td style="border-top: 0px solid #ddd;"><button type="button" name="remove" id="'+i+'" class="btn btn-danger btn_remove">X</button></td></tr>');  
      });

      $(document).on('click', '.btn_remove', function(){  
           var button_id = $(this).attr("id");   
           $('#row'+button_id+'').remove();  
      });  


     /* *********************JQuery Code To Add Coupons Dynamically Ends Here. ************************************ */


});
</script>

<script>
$(document).ready(function(){
    $('#myform').submit(function() {
      if($("input[name='levels[]']:checked").length == 0 && $('#tour_format').val() != 'Teams'){ 
            alert("Select at least one Sport Level"); 
			return false;
        }
	    else{ return true; }
    });
    $('#myform').submit(function() {
       if($("input[name='age[]']:checked").length == 0){ 
           alert("Select at least one Age group"); 
			return false;
        }
	    else { return true; }
    });
});
</script>

<script>
$(document).ready(function(){
    $('#myform').submit(function() {
       if($("input[name='singles[]']:checked").length == 0 && $('#tour_format').val() != 'Teams' && $('#tour_format').val() != 'TeamSport'){ 
            alert("Select at least one Match type"); 
			return false;
        }
	    else{ return true; }
	    
    });
   

    /* Here Delete Sponsor code Starts*/
    $("#delete_spnsor").click(function () {
    	var baseurl="<?php echo base_url();?>";
    	var tourn_id="<?php echo $tournament_details->tournament_ID;?>";
    	var sponsor=[];
        if($("input[name='sponsor_chk[]']:checked").length == 0)
        { 
            alert("Select at least one Sponsor"); 
		  return false;
        }else
        {
        	$("input:checkbox.sponsor_chk_cls:checked").each(function(){
               sponsor.push($(this).val());  
        	});       	
	        $.ajax({
				type:'POST',
				url:baseurl+'league/delete_sponsor/',
				data:{ tourn_id:tourn_id,sponsor:sponsor},
				success:function(res){
					$("#div_sponser_section").html(res);
				}
		    });
        }
    });
	/* Here Delete Sponsor code End*/

});
</script>

<!-- view start -->
<section id="single_player" class="secondary-page" style="padding-top:0px;">
<div class='container'>
<div class='row'>
           <div class="col-md-9">

		   <?php if($this->session->userdata('user')!="") { ?>		           
		  <form class="form-horizontal" id='myform' method='post' role="form" enctype="multipart/form-data" action="<?php echo $this->config->item('club_form_url'); ?>/league/update_trnmt"  onsubmit="return doCompareDate()">  
		   <input type="hidden" value="<?php echo $tournament_details->Tournamentfee;?>" name="tourn_fee">
		   <div class="col-md-12 league-form-bg" style="margin-top:30px;">
           		<div class="fromtitle"><?php echo $tournament_details->tournament_title; ?></div>

		<input class='form-control' id='' name='tourn_id' type='hidden' value="<?php echo $tournament_details->tournament_ID; ?>" />

		  <div class='form-group'>
            <label class='control-label col-md-3' for='id_accomodation'>Sport Type:</label>
            <div class='col-md-8 form-group internal'>
			<p style="margin-top:8px; font-weight:bold"><?php $sport = league::get_sport($tournament_details->SportsType);
			echo $sport['Sportname'];
			?>	</p>
            </div>
          </div>
			<?php 
			if($tournament_details->tournament_format == 'Teams'){
			$lines = json_decode($tournament_details->lines_per_match, true);
			/*echo "<pre>";print_r($lines);
			echo $lines[0]['WSingles'];*/
			?>
		   <div class='form-group' id='num_lines_div'>
            <label class='control-label col-md-3' for='id_accomodation'>Select Lines# (Men's Singles)</label>
			<div class='col-md-8 form-group internal'>
			<select name="mens_singles_lines" id="mens_singles_lines" class='form-control' style="width:45%" />
			<?php for($i=0; $i<11; $i++){ ?>
			<option value="<?=$i;?>" <?php echo ($lines[0]['MSingles'] == $i) ? 'selected' : ''; ?>><?=$i;?></option>
			<?php } ?>
			</select>
            </div>
              <label class='control-label col-md-3' for='id_accomodation'>Women's Singles </label>
			<div class='col-md-8 form-group internal'>
			<select name="womens_singles_lines" id="womens_singles_lines" class='form-control' style="width:45%" />
			<?php for($i=0; $i<11; $i++){ ?>
			<option value="<?=$i;?>" <?php echo ($lines[1]['WSingles'] == $i) ? 'selected' : ''; ?>><?=$i;?></option>
			<?php } ?>
			</select>
            </div>

            <label class='control-label col-md-3' for='id_accomodation'>Men's Doubles</label>
			<div class='col-md-8 form-group internal'>
			<select name="mens_doubles_lines" id="mens_doubles_lines" class='form-control' style="width:45%" />
			<?php for($i=0; $i<11; $i++){ ?>
			<option value="<?=$i;?>" <?php echo ($lines[2]['MDoubles'] == $i) ? 'selected' : ''; ?>><?=$i;?></option>
			<?php } ?>
			</select>
            </div>

            <label class='control-label col-md-3' for='id_accomodation'>Women's Doubles</label>
			<div class='col-md-8 form-group internal'>
			<select name="womens_doubles_lines" id="womens_doubles_lines" class='form-control' style="width:45%" />
			<?php for($i=0; $i<11; $i++){ ?>
			<option value="<?=$i;?>" <?php echo ($lines[3]['WDoubles'] == $i) ? 'selected' : ''; ?>><?=$i;?></option>
			<?php } ?>
			</select>
            </div>
			
            <label class='control-label col-md-3' for='id_accomodation'>Mixed Doubles</label>
			<div class='col-md-8 form-group internal'>
			<select name="mixed_lines" id="mixed_lines" class='form-control' style="width:45%" />
			<?php for($i=0; $i<11; $i++){ ?>
			<option value="<?=$i;?>" <?php echo ($lines[4]['Mixed'] == $i) ? 'selected' : ''; ?>><?=$i;?></option>
			<?php } ?>
			</select>
            </div>

            <label class='control-label col-md-3' for='id_accomodation'>Open Singles</label>
			<div class='col-md-8 form-group internal'>
			<select name="open_single_lines" id="open_single_lines" class='form-control' style="width:45%" />
			<?php for($i=0; $i<11; $i++){ ?>
			<option value="<?=$i;?>" <?php echo ($lines[5]['OSingles'] == $i) ? 'selected' : ''; ?>><?=$i;?></option>
			<?php } ?>
			</select>
            </div>
			
            <label class='control-label col-md-3' for='id_accomodation'>Open Doubles</label>
			<div class='col-md-8 form-group internal'>
			<select name="open_double_lines" id="open_double_lines" class='form-control' style="width:45%" />
			<?php for($i=0; $i<11; $i++){ ?>
			<option value="<?=$i;?>" <?php echo ($lines[6]['ODoubles'] == $i) ? 'selected' : ''; ?>><?=$i;?></option>
			<?php } ?>
			</select>
            </div>  
		  </div>
		  <?php
			} ?>
		  <div class='form-group'>
            <label class='control-label col-md-3' for='id_accomodation'>Tournament Type</label>
            <div class='col-md-8 form-group internal'>

			<select id="tourn_type" name="tourn_type" class='form-control' style="width:45%" required>
				<option value="">Select</option>
				<?php if($tournament_details->SportsType == 4) {
						$tourn_types = array("conventional" => 'Conventional', "drive_chip_putt" => 'Drive, Chip & Putt'); } 
						else{
						$tourn_types = array("Single Elimination", "Consolation", "Round Robin", "Challenge Ladder", "Flexible League"); }
				?>
				<?php foreach($tourn_types as $i=>$type){ ?> 
				 <option value='<?php echo $type ;?>'<?php echo trim($type) == $tournament_details->Tournament_type ? 'selected="selected"' : '' ?>><?php echo $type ; ?></option>
				<?php } ?>
			</select>
            </div>
          </div>

	<!-- Level Of The Tournament Starts Here. -->	
		<div class='form-group'>
            <label class='control-label col-md-3' for='id_accomodation'> Level of the tournament</label>
            <div class='col-md-8 form-group internal'>
			<select id="star_level" name="star_level" class='form-control' style="width:45%" />
				<?php 
					$stars_level = array(0 => "No Star", 1 => "One Star (*)", 2 => "Two Star (**)", 3 => "Three Star (***)", 4 => "Four Star (****)", 5 => "Five Star (*****)");
				?>
				<?php foreach($stars_level as $i => $stlevel) { ?> 
				 <option value='<?php echo $i ;?>'<?php echo trim($i) == $tournament_details->Star_Level ? 'selected="selected"' : '' ?>><?php echo $stlevel ; ?></option>
				<?php } ?>
			</select>
            </div>
        </div>
	<!-- Level Of The Tournament Ends Here. -->

          <div class='form-group'>
            <label class='control-label col-md-3' for='id_accomodation'>Tournament Title </label>
            <div class='col-md-6 form-group internal'>
              <input class='form-control' id='title' name='title' type='text' value="<?php echo $tournament_details->tournament_title; ?>" required />
            </div>
          </div>
		  
          <div class='form-group'>
            <label class='control-label col-md-3' for='id_accomodation'><font color='red'>* </font> Organizer Name<br />(Company / Individual) </label>
            <div class='col-md-6 form-group internal'>
              <input class='form-control' id='organizer' name='organizer' type='text' value="<?php echo $tournament_details->OrganizerName;?>" required />
            </div>
          </div>
          <div class='form-group'>
            <label class='control-label col-md-3' for='id_accomodation'><font color='red'>* </font> Contact Number </label>
            <div class='col-md-6 form-group internal'>
              <input class='form-control' id='org_contact' name='org_contact' maxlength="12" type='text' style="width:64%;" 
			  value="<?php echo $tournament_details->ContactNumber;?>" required />
            </div>
          </div>
		  
		 <input type='hidden' name="tour_format" id="tour_format" value='<?php echo $tournament_details->tournament_format;?>' />

		  <div class="form-group"> 
			<label class='control-label col-md-3' for='id_accomodation'>Tournament Image </label>
            <div class='col-md-6 form-group internal'>
			   <input id="playinglevel" name="TournamentImage" style="margin-bottom:28px" type="file"/>
			   <input id="image" name="Image" style="margin-bottom:28px" type="hidden" value="<?php echo $tournament_details->TournamentImage;?>" /> 
			   <?php if($tournament_details->TournamentImage!=""){ ?>
               <span><img src="<?php echo base_url();?>tour_pictures/<?php echo $tournament_details->TournamentImage;?>" alt="" ></span>  
			  <?php } ?>
            </div>
          </div>
		  
          <div class='form-group'>
            <label class='control-label col-md-3' for='id_title'> <font color='red'>* </font>Start Date</label>
            <div class='col-md-3 form-group internal'>
                  <!-- <input class='form-control datepicker' id='id_checkin' name='sdate' required> --> 
				<div class='input-group date'>
				  <input type="text" class='form-control custom_date' placeholder="MM/DD/YYYY" id="custom_start_date" value="<?php if($tournament_details->StartDate){echo date('m/d/Y',strtotime($tournament_details->StartDate));} ?>" 				  name="sdate" maxlength="10" required /> 
				    <span class="input-group-addon custom_datepicker" id='start_date' style="cursor:pointer;">
						<span class="fa fa-calendar"></span> 
					</span>
				</div>
            </div>
            <label class='control-label col-md-3' for='id_title'> Start Time</label>
            <div class='col-md-3 form-group internal input-group bootstrap-timepicker timepicker'>
                  <input type="text" class='form-control' placeholder="H:i" id="start_time" name="stime" value="<?php if($tournament_details->StartDate){echo date('h:i a',strtotime($tournament_details->StartDate)); }?>" /> 

              </div>
          </div>
          <div class='form-group'>
            <label class='control-label col-md-3' for='id_title'> <font color='red'>* </font>End Date</label>
            <div class='col-md-3 form-group internal'>
                  <!-- <input class='form-control datepicker' id='id_checkin' name='sdate' required> --> 
				  
				<div class='input-group date'>
				 <input type="text" class='form-control custom_date' placeholder="MM/DD/YYYY" id="custom_end_date" value="<?php if($tournament_details->EndDate){echo date('m/d/Y',strtotime($tournament_details->EndDate));} ?>" name="edate" maxlength="10" required /> 
				<span class="input-group-addon custom_datepicker" id='end_date' style="cursor:pointer;">
				   <span class="fa fa-calendar"></span> 
				</span>
				</div> 
			</div>
            <label class='control-label col-md-3' for='id_title'> End Time</label>
            <div class='col-md-3 input-group bootstrap-timepicker timepicker'>
                  <input type="text" class='form-control' placeholder="hh:ii" id="end_time" name="etime" value="<?php if($tournament_details->EndDate){echo date('h:i a',strtotime($tournament_details->EndDate)); }?>" /> 

              </div>
          </div>
		  <div class='form-group'>
            <label class='control-label col-md-3' for='id_title'> <font color='red'>* </font>Registration opens on</label>
            <div class='col-md-3 form-group internal'> 
				  <!-- <input  type="text" class='form-control' placeholder="MM/DD/YYYY" id="reg_opens_on" name="reg_openson" value="<?php //if($tournament_details->Registrations_Opens_on){echo date('m/d/Y',strtotime($tournament_details->Registrations_Opens_on));} ?>" onblur="return CompareDate1()" required /> -->

				<div class='input-group date'>
				  <input  type="text" class='form-control custom_date' placeholder="MM/DD/YYYY" id="custom_reg_opens_on" name="reg_openson"  value="<?php if($tournament_details->Registrations_Opens_on){echo date('m/d/Y',strtotime($tournament_details->Registrations_Opens_on));} ?>" maxlength="10" required />
				    <span class="input-group-addon custom_datepicker" id='reg_opens_on' style="cursor:pointer;">
                       <span class="fa fa-calendar"></span> 
                    </span>
				</div>
            </div>
             <label class='control-label col-md-3' for='id_title'> Start Time</label>
            <div class='col-md-3 form-group internal input-group bootstrap-timepicker timepicker'>
                  <input type="text" class='form-control' placeholder="hh:ii" id="regs_open_time" name="regopentime"
				   value="<?php if($tournament_details->Registrations_Opens_on){echo date('h:i a',strtotime($tournament_details->Registrations_Opens_on)); }?>" /> 
            </div>
          </div>
		  
          <div class='form-group'>  
            <label class='control-label col-md-3' for='id_title'> Registrations closed on</label>
            <div class='col-md-3 form-group internal'> 
				  <!-- <input  type="text" class='form-control' placeholder="MM/DD/YYYY" id="reg_closed_on" name="reg_closedon" value="<?php //if($tournament_details->Registrationsclosedon){echo date('m/d/Y',strtotime($tournament_details->Registrationsclosedon));} ?>" onblur="CompareDate()"  /> -->

				<div class='input-group date'>
				<input type="text" class='form-control custom_date' placeholder="MM/DD/YYYY" id="custom_reg_closed_on" name="reg_closedon" maxlength="10" value="<?php if($tournament_details->Registrationsclosedon){echo date('m/d/Y',strtotime($tournament_details->Registrationsclosedon));} ?>" required />
				<span class="input-group-addon custom_datepicker" id='reg_closed_on' style="cursor:pointer;">
				<span class="fa fa-calendar"></span> 
				</span>
				</div>
				</div>
            <label class='control-label col-md-3' for='id_title'> End Time</label>
            <div class='col-md-3 input-group bootstrap-timepicker timepicker'>
                  <input type="text" class='form-control' placeholder="hh:ii" id="regs_close_time" name="regclosetime" value="<?php if($tournament_details->Registrationsclosedon){echo date('h:i a',strtotime($tournament_details->Registrationsclosedon)); }?>" /> 
            </div>
          </div>
          <?php if($tournament_details->RefundDate!=NULL){?>
           <div class='form-group'>  
            <label class='control-label col-md-3' for='id_title'> <font color='red'>* </font>WithDraw or Refund Date</label>
            <div class='col-md-3 form-group internal'>
				<div class='input-group date'>
				<input  type="text" class='form-control custom_date' placeholder="MM/DD/YYYY" id="custom_refund_date" name="refund_date" maxlength="10"  value="<?php if($tournament_details->RefundDate){echo date('m/d/Y',strtotime($tournament_details->RefundDate));} ?>" required />
				<span class="input-group-addon custom_datepicker" id='refund_date' style="cursor:pointer;">
				   <span class="fa fa-calendar"></span> 
				</span>
				</div>
            </div>
          </div>
          <?php }?>
           <?php if($tournament_details->SportsType==2 and $tournament_details->EligibilityDate!=NULL){?>
           <div class='form-group'>  
            <label class='control-label col-md-3' for='id_title'> Rating Eligibility Date</label>
            <div class='col-md-4 form-group internal'> 

			 <div class='input-group date'>
             <input  type='text' class='form-control custom_date' placeholder='MM/DD/YYYY' id='custom_eligibility_date' maxlength="10" name='eligibility_date' value="<?php if($tournament_details->EligibilityDate){ echo date('m/d/Y',strtotime($tournament_details->EligibilityDate));} ?>" />

			 <span class="input-group-addon custom_datepicker" id='eligibility_date' style="cursor:pointer;">
			   <span class="fa fa-calendar"></span> 
			 </span>
			 </div>

            </div>
          </div>
          <?php }?>

		  <div id='addr_group'>
          <div class='form-group'>
            <label class='control-label col-md-3' for='id_accomodation'><font color='red'>* </font> Venue </label>
            <div class='col-md-6 form-group internal'>
              <input class='form-control' id='venue' name='venue' type='text' value="<?php echo $tournament_details->venue;?>" style="width:80%" required>
            </div>
            <!-- <div class='col-md-3 form-group internal' style="margin-top:6px; margin-left:1px">
              <input type="submit" value="Search.." style="padding:2px 10px"/>
            </div> -->
          </div>
          
         <div class='form-group'>
            <label class='control-label col-md-3' for='id_accomodation'><font color='red'>* </font> Address Line1 </label>
            <div class='col-md-8 form-group internal'>
              <input class='form-control' id='addr1' name='addr1' type='text' value="<?php echo $tournament_details->TournamentAddress;?>" style="width:80%" required>
            </div>
          </div>

		   <div class='form-group'>
            <label class='control-label col-md-3' for='id_accomodation'>Address Line2 </label>
            <div class='col-md-8 form-group internal'>
              <input class='form-control' id='addr2' name='addr2' type='text' style="width:80%">
            </div>
          </div>
		  </div>
		  
		  
		  <div class='form-group'>
          
            <label class='control-label col-md-3' for='id_accomodation'><font color='red'>* </font> Country</label>
            <div class='col-md-4 form-group internal'>
              <select class='form-control' id='country' name='country' required>
                <option value="">Select</option>
				<?php
$countries = array("Afghanistan", "Albania", "Algeria", "American Samoa", "Andorra", "Angola", "Anguilla", "Antarctica", "Antigua and Barbuda", "Argentina", "Armenia", "Aruba", "Australia", "Austria", "Azerbaijan", "Bahamas", "Bahrain", "Bangladesh", "Barbados", "Belarus", "Belgium", "Belize", "Benin", "Bermuda", "Bhutan", "Bolivia", "Bosnia and Herzegowina", "Botswana", "Bouvet Island", "Brazil", "British Indian Ocean Territory", "Brunei Darussalam", "Bulgaria", "Burkina Faso", "Burundi", "Cambodia", "Cameroon", "Canada", "Cape Verde", "Cayman Islands", "Central African Republic", "Chad", "Chile", "China", "Christmas Island", "Cocos (Keeling) Islands", "Colombia", "Comoros", "Congo", "Congo, the Democratic Republic of the", "Cook Islands", "Costa Rica", "Cote d'Ivoire", "Croatia (Hrvatska)", "Cuba", "Cyprus", "Czech Republic", "Denmark", "Djibouti", "Dominica", "Dominican Republic", "East Timor", "Ecuador", "Egypt", "El Salvador", "Equatorial Guinea", "Eritrea", "Estonia", "Ethiopia", "Falkland Islands (Malvinas)", "Faroe Islands", "Fiji", "Finland", "France", "France Metropolitan", "French Guiana", "French Polynesia", "French Southern Territories", "Gabon", "Gambia", "Georgia", "Germany", "Ghana", "Gibraltar", "Greece", "Greenland", "Grenada", "Guadeloupe", "Guam", "Guatemala", "Guinea", "Guinea-Bissau", "Guyana", "Haiti", "Heard and Mc Donald Islands", "Holy See (Vatican City State)", "Honduras", "Hong Kong", "Hungary", "Iceland", "India", "Indonesia", "Iran (Islamic Republic of)", "Iraq", "Ireland", "Israel", "Italy", "Jamaica", "Japan", "Jordan", "Kazakhstan", "Kenya", "Kiribati", "Korea, Democratic People's Republic of", "Korea, Republic of", "Kuwait", "Kyrgyzstan", "Lao, People's Democratic Republic", "Latvia", "Lebanon", "Lesotho", "Liberia", "Libyan Arab Jamahiriya", "Liechtenstein", "Lithuania", "Luxembourg", "Macau", "Macedonia, The Former Yugoslav Republic of", "Madagascar", "Malawi", "Malaysia", "Maldives", "Mali", "Malta", "Marshall Islands", "Martinique", "Mauritania", "Mauritius", "Mayotte", "Mexico", "Micronesia, Federated States of", "Moldova, Republic of", "Monaco", "Mongolia", "Montserrat", "Morocco", "Mozambique", "Myanmar", "Namibia", "Nauru", "Nepal", "Netherlands", "Netherlands Antilles", "New Caledonia", "New Zealand", "Nicaragua", "Niger", "Nigeria", "Niue", "Norfolk Island", "Northern Mariana Islands", "Norway", "Oman", "Pakistan", "Palau", "Panama", "Papua New Guinea", "Paraguay", "Peru", "Philippines", "Pitcairn", "Poland", "Portugal", "Puerto Rico", "Qatar", "Reunion", "Romania", "Russian Federation", "Rwanda", "Saint Kitts and Nevis", "Saint Lucia", "Saint Vincent and the Grenadines", "Samoa", "San Marino", "Sao Tome and Principe", "Saudi Arabia", "Senegal", "Seychelles", "Sierra Leone", "Singapore", "Slovakia (Slovak Republic)", "Slovenia", "Solomon Islands", "Somalia", "South Africa", "South Georgia and the South Sandwich Islands", "Spain", "Sri Lanka", "St. Helena", "St. Pierre and Miquelon", "Sudan", "Suriname", "Svalbard and Jan Mayen Islands", "Swaziland", "Sweden", "Switzerland", "Syrian Arab Republic", "Taiwan, Province of China", "Tajikistan", "Tanzania, United Republic of", "Thailand", "Togo", "Tokelau", "Tonga", "Trinidad and Tobago", "Tunisia", "Turkey", "Turkmenistan", "Turks and Caicos Islands", "Tuvalu", "Uganda", "Ukraine", "United Arab Emirates", "United Kingdom", "United States of America", "United States Minor Outlying Islands", "Uruguay", "Uzbekistan", "Vanuatu", "Venezuela", "Vietnam", "Virgin Islands (British)", "Virgin Islands (U.S.)", "Wallis and Futuna Islands", "Western Sahara", "Yemen", "Yugoslavia", "Zambia", "Zimbabwe");

foreach($countries as $country)
{ ?>
 
  <option value='<?php echo $country ;?>'<?php //echo trim($country) == $tournament_details->TournamentCountry ? 'selected="selected"' : '' ?>><?php echo $country ; ?></option>

<?php }
?>
</select>

		</div>
	   </div>
          
	<div class='form-group' style='display:none;' id='state_box'>
	<label class='control-label col-md-3' for='id_accomodation'><font color='red'>* </font> State</label>
	<div class='col-md-8 form-group internal'>
	<input class='form-control' id='state1' name='state1' type='text' value="<?php echo $tournament_details->TournamentState;?>" style="width:45%">
	</div>
	</div>

	<div class='form-group' id="state_drop">
	<label class='control-label col-md-3' for='id_title'><font color='red'>* </font> State</label>
	<div class='col-md-4 form-group internal'>
	<select name="state" id="state" class='form-control' onChange="stateChange();">
	<option value="">Select</option>
	<?php
	$states = array('Alabama','Alaska','Arizona','Arkansas','California','Colorado','Connecticut','Delaware','District of Columbia','Florida','Georgia',
	'Hawaii','Idaho','Illinois','Indiana','Iowa','Kansas','Kentucky','Louisiana','Maine','Maryland','Massachusetts','Michigan','Minnesota','Mississippi',
	'Missouri','Montana','Nebraska','Nevada','New Hampshire','New Jersey','New Mexico','New York','North Carolina','North Dakota','Ohio','Oklahoma', 'Oregon','Pennsylvania','Rhode Island','South Carolina','South Dakota','Tennessee','Texas','Utah','Vermont','Virginia','Washington','West Virginia',
	'Wisconsin','Wyoming'); 
	foreach($states as $state)
	{
		if($tournament_details->TournamentState == $state){
		$stat = "selected='selected'";
		}else{
			$stat = "";
		}
		
		echo "<option value='$state' $stat>$state</option>";
	}
	?>
	</select>
	</div>
	</div>

	<div class='form-group'>
	<label class='control-label col-md-3' for='id_accomodation'><font color='red'>* </font> City</label>
	<div class='col-md-8 form-group internal'>
	<input class='form-control' id='city' name='city' type='text' value="<?php echo $tournament_details->TournamentCity;?>" style="width:45%" required>
	</div>
	</div>

	<div class='form-group'>
	<label class='control-label col-md-3' for='id_accomodation'><font color='red'>* </font> Postal Code</label>
	<div class='col-md-8 form-group internal'>
	<input class='form-control' id='zipcode' name="zipcode" type='text' value="<?php echo $tournament_details->PostalCode;?>" style="width:45%" required>
	</div>
	</div>

	<div class='form-group'>
	<label class='control-label col-md-3' for='id_accomodation'>Tournament Description</label>
	<div class='col-md-7 form-group internal'>
	<textarea name="desc" class="txt-area" id="desc" cols="20" rows="2"><?php echo $tournament_details->TournamentDescription;?></textarea>
	</div>
	</div>
	</div>
  

  <!-------------------------- New Functionality Starts Here & Added By Me------------------------------------------->
<div class="col-md-12 league-form-bg" style="margin-top:30px;" id="event_section"> 
<div class="fromtitle">Events</div>	
			<div class='form-group'>
			<label class='control-label col-md-3' for='id_accomodation'>Sport Levels:</label>
			<div class='col-md-8 form-group internal'>
			<?php 
			$sportlevels = json_decode($tournament_details->Sport_levels);

			foreach ($sport_levels as $key => $level) {
			if(in_array($level->SportsLevel_ID, $sportlevels)){
			$checked  = "checked";     
			}
			else{
			$checked  = "";
			$readonly = "";
			}
			if(in_array($level->SportsLevel_ID, $reg_levels)){
			$readonly = " readonly";
			}
			else{
			$readonly = "";
			}  
			?>
			<input type="checkbox" class='sp_levels' name="levels[]" value="<?php echo $level->SportsLevel_ID;?>" <?=$checked.$readonly;?> />
			<span for='<?php echo $level->SportsLevel_ID;?>'><?php echo trim($level->SportsLevel);?></span>
			<?php } ?>
			</div>
			</div>
		  
		            <?php if($tournament_details->tournament_format != 'Teams'){ ?>

          <div class='form-group' id='mtype'>
		  <?php $type_array = json_decode($tournament_details->Singleordouble); ?>

            <label class='control-label col-md-3' for='id_accomodation'><font color='red'>* </font> Match Type</label>
            <div class='col-md-5 form-group internal' id='mtype_check'>
             	<input type="checkbox" class='x1' name="singles[]" id="singles" value="Singles" <?php if(in_array("Singles", $type_array)){echo 'checked'; if(in_array('Singles', $reg_format)){ echo " readonly"; } }?> />
				<label class='control-label' for='singles'> Singles &nbsp;</label>

				<input type="checkbox" class='x1' name="singles[]" id="doubles" value="Doubles" <?php if(in_array("Doubles", $type_array)){echo 'checked'; if(in_array('Doubles', $reg_format)){ echo " readonly"; } }?> /> 
				<label class='control-label' for='doubles'>Doubles &nbsp;</label>

				<input type="checkbox" class='x1' name="singles[]" id="mixed" value="Mixed" <?php if(in_array("Mixed", $type_array)){echo 'checked'; if(in_array('Mixed', $reg_format)){ echo " readonly"; } }?> /> 
				<label class='control-label' for='mixed'>Mixed Doubles </label>
            </div>
          </div>

		 <?php } ?>
		  <div class='form-group'>
            <label class='control-label col-md-3' for='id_title'><font color='red'>* </font> Age Group</label>
            <div class='col-md-7 form-group internal'>
				<?php 
				$age_array = json_decode($tournament_details->Age); 
				
				$agegroups_arry  = array('U10','U11','U12','U13','U14','U15','U16','U17','U18','U19','Adults','Adults_30p','Adults_40p','Adults_50p','Adults_veteran','Junior');

                $checked_age	  = "";
                $readonly_age_grp = "";

				foreach ($agegroups_arry as $key => $value){
                	if(in_array($value, $age_array)){
                		$checked_age = "checked"; 
                	}
					else{
                		$checked_age = "";
                	}

                	if(in_array($value, $reg_agegroups)){
                	    $readonly_age_grp = " readonly";           
          		    }
					else{
          		    	$readonly_age_grp = "";
          		    }

          		    if($value == "Adults"){
                       $id    = "age_adults";
                       $for   = "age_adults";
                       $title = "Adults";
          		    }
          		    else if($value == "Adults_30p"){
                       $id    = "age_30p";
                       $for   = "age_30p";
                       $title = "30s";
          		    }
          		    else if($value == "Adults_40p"){
                       $id    = "age_40p";
                       $for   = "age_40p";
                       $title = "40s";
          		    }
          		    else if($value == "Adults_50p"){
                       $id    = "age_50p";
                       $for   = "age_50p";
                       $title = "50s";
          		    }
          		    else if($value == "Adults_veteran"){
                       $id    = "veteran";
                       $for   = "veteran";
                       $title = "Veteran";
          		    }
          		    else if($value == "Junior"){
                       $id    = "junior";
                       $for   = "junior";
                       $title = "Junior";
          		    }
          		    else if($value == "Senior"){
                       $id    = "senior";
                       $for   = "senior";
                       $title = "Senior";
          		    }
					else{
          			   $val	  = explode('U', $value);
          		    
                       $id    = "age_u".$val[1];
                       $for   = "age_u".$val[1];
                       $title = "Under ".$val[1];
          		    }

                	echo "<input type='checkbox' class='age' id='".$id."' name='age[]' value='".$value."' ".$checked_age." ".$readonly_age_grp.">";
                	echo "<label class='control-label' for='".$for."'> ".$title." </label>&nbsp;";
					if(($key + 1) % 6 == 0) {
						echo "<br />";
					}
                }
				?>		

            </div>
          </div>

          <div class='form-group'>
            <label class='control-label col-md-3' for='id_accomodation'><font color='red'>* </font> Events for</label>
            <div class='col-md-8 form-group internal'>
			<?php $gen_vals = json_decode($tournament_details->Gender, true); ?>
			  <input type="checkbox" class="gender" name="gender_type[]" id="male" value="1" 
			  <?php if(in_array("1",$gen_vals) or $tournament_details->Gender == "All"){ echo "checked"; if(in_array('1', $reg_gender)){ echo " readonly"; } }?> />
			  <label class='control-label' for='male'> Men's/Boy's Only&nbsp;&nbsp;</label>

			  <input type="checkbox" class="gender" name="gender_type[]" id="female" value="0" 
			  <?php if(in_array("0",$gen_vals) or $tournament_details->Gender == "All"){ echo "checked"; if(in_array('0', $reg_gender)){ echo " readonly"; } }?> />
			  <label class='control-label' for='female'> Women's/Girl's Only</label>

			  <input type="checkbox" class="gender" name="gender_type[]" id="open_gender" value="Open" 
			  <?php if(in_array("Open",$gen_vals) or $tournament_details->Gender == "All" or $tournament_details->Gender == "Open"){ echo "checked"; if(in_array('Open', $reg_gender)){ echo " readonly"; } }?> /> 
			  <label class='control-label' for='open_gender'>Open to All&nbsp;&nbsp; </label>
            </div>
          </div>

	<!-- <div class='form-group' id='mtype'>
            <label class='control-label col-md-3' for='id_accomodation'><font color="red">* </font> Match Type</label>
            <div class='col-md-5 form-group internal' id='mtype_check'>
            	<input type="checkbox" class='x1' name="singles[]" id="singles" value="Singles"><label class='control-label' for='singles'>Singles&nbsp;</label>
				<input type="checkbox" class='x1' name="singles[]" id="doubles" value="Doubles"> <label class='control-label' for='doubles'>Doubles&nbsp;</label>
				<input type="checkbox" class='x1' name="singles[]" id="mixed" value="Mixed"> <label class='control-label' for='mixed'>Mixed Doubles</label>
            </div>
    </div>
	
	<div class='form-group'>
            <label class='control-label col-md-3' for='id_title'><font color="red">* </font> Age Group</label>
            <div class='col-md-7 form-group internal'>
				<input type="checkbox" class='age' id='age_u10' name="age[]" value="U10"><label class='control-label' for='age_u10'>Under 10 &nbsp;</label>
				<input type="checkbox" class='age' id='age_u11' name="age[]" value="U11"><label class='control-label' for='age_u11'>Under 11 &nbsp;</label>
				<input type="checkbox" class='age' id='age_u12' name="age[]" value="U12"><label class='control-label' for='age_u12'>Under 12 &nbsp;</label>
				<input type="checkbox" class='age' id='age_u13' name="age[]" value="U13"><label class='control-label' for='age_u13'>Under 13 &nbsp;</label><br/>
				<input type="checkbox" class='age' id='age_u14' name="age[]" value="U14"> <label class='control-label' for='age_u14'>Under 14 &nbsp;</label>
				<input type="checkbox" class='age' id='age_u15' name="age[]" value="U15"><label class='control-label' for='age_u15'>Under 15 &nbsp;</label>
				<input type="checkbox" class='age' id='age_u16' name="age[]" value="U16"> <label class='control-label' for='age_u16'>Under 16 &nbsp;</label>
				<input type="checkbox" class='age' id='age_u17' name="age[]" value="U17"><label class='control-label' for='age_u17'>Under 17 &nbsp;</label><br/>
				<input type="checkbox" class='age' id='age_u18' name="age[]" value="U18"> <label class='control-label' for='age_u18'>Under 18 &nbsp;</label><br />
				<input type="checkbox" class='age' id='age_u19' name="age[]" value="U19"><label class='control-label' for='age_u19'>Under 19 &nbsp;</label>
				<input type="checkbox" class='age' id='age_adults' name="age[]" value="Adults"> <label class='control-label' for='age_adults'>Adults&nbsp;</label>
				<input type="checkbox" class='age' id='age_30p' name="age[]" value="Adults_30p"> <label class='control-label' for='age_30p'>30s&nbsp;&nbsp;</label>
				<input type="checkbox" class='age' id='age_40p' name="age[]" value="Adults_40p"> <label class='control-label' for='age_40p'>40s&nbsp;&nbsp;</label>
				<input type="checkbox" class='age' id='age_50p' name="age[]" value="Adults_50p"> <label class='control-label' for='age_50p'>50s&nbsp;&nbsp;</label>
				<input type="checkbox" class='age' id='veteran' name="age[]" value="Adults_veteran"> <label class='control-label' for='veteran'>Veteran</label>
            </div>
    </div>
	
	<div class='form-group'>
            <label class='control-label col-md-3' for='id_accomodation'> <font color="red">* </font> Gender</label>
            <div class='col-md-8 form-group internal'>
			  <input type="radio" name="gender_type" id="male" value="1" required> <label class='control-label' for='male'> Male Only&nbsp;&nbsp;</label>
			  <input type="radio" name="gender_type" id="female" value="0" required><label class='control-label' for='female'> Female Only</label>
			  <input type="radio" name="gender_type" id="open_gender" value="All" required> <label class='control-label' for='open_gender'>  Open to All&nbsp;&nbsp; </label>
            </div>
    </div> -->
	
	<input type="button" value="Generate Events" name='create_tourn' id="Combinations" style="margin-top:20px" class="league-form-submit"/>&nbsp;&nbsp;&nbsp;
	<div id='div_reg_events'></div>

	<font color='red'><br />
	
	<b><span id='EventsID'></span></b></font>
  
	<div class='form-group' id="combinationsResult"></div>
	<div class='form-group' id="combinationsCount"></div>
	<br />
	  <font color='blue'><b><span id='ListCount'></span></b></font>
	<div id="selected_events" align="center"></div>

	<div align="center">
	<input type="button" name="confirm_proceed" id="confirm_proceed" value="Confirm & Proceed" style="margin-top:20px" class="league-form-submit" disabled>
    </div>
  
</div>  

<!--  </div>  -->
<!--  ------------------------ New Functionality Ends Here -------------------------------------------------------  --->	
	<div id="limitsdiv" style="display:block">
		
    <div class="col-md-12 league-form-bg" style="margin-top:30px;" id="limits_section">
	    <div class="fromtitle">Limits</div>
    <?php
        if($tournament_details->Event_Reg_Limit == NULL){
        	$display_limit     = "display:none;";
        	$limit_chck        = "";
        	$limit_default_chk = "checked";
        }else{
        	$display_limit     = "display:block;";
        	$limit_chck        = "checked";
        	$limit_default_chk = "";
        }
       ?>
	        Do you want to add limit to Events&nbsp;
			<label for="EvntYes"><input type="radio" id="EvntYes" name="event" value="1" <?php echo $limit_chck;?>/> Yes</label>&nbsp;&nbsp;
			<label for="EvntNo"><input type="radio" id="EvntNo" name="event" value="0" <?php echo $limit_default_chk;?> /> No<br /></label>
	
	<div class='form-group' id="div_event_section" style="<?php echo $display_limit;?>">
	   <div id='Events' >
<?php
    if($tournament_details->Event_Reg_Limit != NULL){
		$Event_Reg_Limit = json_decode($tournament_details->Event_Reg_Limit, true);
		
	    foreach ($Event_Reg_Limit as $event => $limit) {
			$label = $revised_events[$event];
	  	?>
		  <br> <label class="control-label col-md-3" for="id_accomodation"><?php echo $label;?></label> <div class="col-md-8 form-group internal"><input type="text" style="width:40%;" class="form-control eventLimit" name="limit[<?php echo $event;?>]" value="<?php echo $limit;?>"></div>
	    
	  <?php
	   } 
       }
	   else{
		if($tournament_details->Multi_Events != NULL){
			$multi_events = json_decode($tournament_details->Multi_Events, true);
			foreach ($multi_events as $i => $event) {
				$label = $revised_events[$event];
			?>
			  <br> <label class="control-label col-md-3" for="id_accomodation"><?php echo $label;?></label> <div class="col-md-8 form-group internal">
			  <input type="text" style="width:40%;" class="form-control eventLimit" name="limit[<?php echo $event;?>]" value=""></div>
			<?php
			}
		}
	   }
       ?>
		
	   </div>	
	   </div> 												<!-- Event Fees Section end -->
	</div>

   <div class="col-md-12 league-form-bg" style="margin-top:30px;" id="event_time_section">
	<div class="fromtitle">Event Time</div>
	<?php 
	 if($tournament_details->Multi_Event_Time == NULL){
	    $display          = "display:none;";
	    $time_chk         = ""; 
	    $time_default_chk = "checked"; 
	  }else{
		$display          = "display:block;";
		$time_chk         = "checked"; 
	    $time_default_chk = "";
	} ?>
      Do you want to add start time for different events?&nbsp;
	<label for="EvntTimeYes"><input type="radio" id="EvntTimeYes" name="event_time" value="1" <?php echo $time_chk;?>/> Yes</label>&nbsp;&nbsp;
	<label for="EvntTimeNo"><input type="radio" id="EvntTimeNo" name="event_time" value="0" <?php echo $time_default_chk;?> /> No<br /></label>
	
	   <div class='form-group' id="div_event_time_section" style="<?php echo $display;?>">
	   <div id='Event_time' >
	   <?php  
	  if($tournament_details->Multi_Event_Time != NULL){
	   $Multi_Event_Time=json_decode($tournament_details->Multi_Event_Time);
	  
      foreach ($Multi_Event_Time as $event => $time){
  				$label = $revised_events[$event];
	  	?> 
		<br> 
		<label class="control-label col-md-3" for="id_accomodation"><?php echo $label;?></label> 
		    <div class="col-md-8 form-group internal">
		        <input type="text" style="width:40%;" class="form-control eventTime" name="time[<?php echo $event;?>]" value="<?php echo date('m/d/Y h:i',strtotime($time));?>">
		    </div>
    
	  <?php 
	    } 
	  }
	else{
		if($tournament_details->Multi_Events != NULL){
		$Multi_Events = json_decode($tournament_details->Multi_Events, true);
			foreach ($Multi_Events as $i => $event) {
				$label = $revised_events[$event];
			?>
			  <br> <label class="control-label col-md-3" for="id_accomodation"><?php echo $label;?></label> <div class="col-md-8 form-group internal">
			  <input type="text" style="width:40%;" class="form-control eventTime" name="time[<?php echo $event;?>]" value=""></div>
			<?php
			}
		}
	}
	   ?>
		</div>
	
		</div> 												<!-- Event Fees Section end -->
	</div>
	<div class="col-md-12 league-form-bg" style="margin-top:30px;">
	<div class="fromtitle">Fees</div>

	 <?php 		
		$checked_fee = "";
        $default_chk = "checked";

		if($tournament_details->Tournamentfee == 1){
          $checked_fee = "checked";
          $default_chk = "";
		}
	 ?>
	   Do you want to collect a fee from players to participate in the tournament&nbsp; <label for="chkYes">
		<input type="radio" id="chkYes" name="fee" value="1" <?php echo $checked_fee;?> />
		Yes
		</label>&nbsp;&nbsp;
		<label for="chkNo">
		<input type="radio" id="chkNo" name="fee" value="0" <?php echo $default_chk;?>/>
		No
		<br />
		</label>
	<?php
		$mult_fee_collect = json_decode($tournament_details->mult_fee_collect);

	    $mult_age_fee = "display:none;";          
	    if($tournament_details->is_mult_fee){
	       $mult_age_fee="display:block;";      
	    }
	  ?>
	<div id="div_fee_section" style="<?php echo $mult_age_fee;?>">
		<?php 
		if($tournament_details->tournament_format == 'Teams' || $tournament_details->tournament_format == 'TeamSport'){ ?>
			<div id='fee_type' style="display:block;">
			Fee to be paid per Team or Player?&nbsp;
			<label for="perTeam"><input type="radio" id="perTeam" name="fee_collect_method" value="Team" 
			<?php echo ($tournament_details->Fee_collect_type == 'Team') ? "checked" : "";?> /> Per Team</label>&nbsp;&nbsp;

			<label for="perPlayer"><input type="radio" id="perPlayer" name="fee_collect_method" value="Player" 
			<?php echo ($tournament_details->Fee_collect_type == 'Player') ? "checked" : "";?> /> Per Player<br /></label>
			</div>
		<?php } ?>
	<?php
		$age_grp_list			= json_decode($tournament_details->Age, true);
		$play_format			= json_decode($tournament_details->Singleordouble);

	    $mult_fee_collect		= json_decode($tournament_details->mult_fee_collect);
	    $addn_mult_fee_collect	= json_decode($tournament_details->addn_mult_fee_collect);
	?>
	<!-- <div id="div_fee_section" style="display: none"> -->	<!-- Fee Section -->
	<div class='col-md-12' style='padding-bottom:4px;'>
		<div class='col-md-2' style='padding-top:5px;'>&nbsp;</div>
		<div class='col-md-2'>Fee Amount</div>
		<?php
		//if(in_array('Singles', $play_format) and (in_array('Doubles', $play_format) or in_array('Mixed', $play_format))) {
		if(in_array('Singles', $play_format) or in_array('Doubles', $play_format) or in_array('Mixed', $play_format)) { 
		?>
		<div class='col-md-2'>Additional Fee</div>
		<?php } ?>
	</div>

	<div id='dyn_courts'><!-- Dynamic Add New Courts Area -->
	<?php
	foreach($age_grp_list as $ag){ 
	$index	= array_search($ag, $age_grp_list);
	if($ag == "Adults"){
		$id    = "age_adults";	
	}
	else if($ag == "Adults_30p"){
		$id    = "age_30p";
	}
	else if($ag == "Adults_40p"){
		$id    = "age_40p";
	}
	else if($ag == "Adults_50p"){
		$id    = "age_50p";
	}
	else if($ag == "Adults_veteran"){
		$id    = "veteran";
	}
	else{
		$val = explode('U', $ag);
		$id    = "age_u".$val[1];
	}

	?>
	<div class='col-md-12 div_grp' id='div_<?php echo $id; ?>' style='padding-bottom:4px;'>
	<div class='col-md-2' style='padding-top:5px;'><?php echo $ag; ?>
	<input type='hidden' class='form-control' name='age_group[]' value='<?php echo $ag; ?>' /></div>

	<div class='col-md-2'><input type='text' class='form-control' name='fee_collect[]' placeholder='Fee Amount' 
	value='<?php echo number_format($mult_fee_collect[$index], 2); ?>' /></div>
	
	<?php 
	/* if(in_array('Singles', $play_format) and (in_array('Doubles', $play_format) or in_array('Mixed', $play_format))) { */  if(in_array('Singles', $play_format) or in_array('Doubles', $play_format) or in_array('Mixed', $play_format)) {
	?>
	<div class='col-md-2'><input type='text' class='form-control' name='addn_fee_collect[]' placeholder='Additional Fee' 
	value='<?php echo number_format($addn_mult_fee_collect[$index], 2); ?>' /></div>
	<?php } ?>
	</div>
	<?php } ?>
	</div>
	<!-- </div> -->	<!-- Fee Section end -->
	
	</div>
       <?php
	    $default = "checked";
	    $cheked = "";
		$multi_event_fee = "display:none;";          
	    if($tournament_details->is_event_fee){
		   $default			= "";
	       $cheked			= "checked";
	       $multi_event_fee	= "display:block;";      
	    }
	   ?>
	   <div id="event_fee_section" style="<?php echo $multi_event_fee;?>">
	   <?php
        if($tournament_details->tournament_format != 'Teams' && $tournament_details->tournament_format != 'TeamSport'){ 
	    ?>
           Do you want to collect different amounts for different events?&nbsp;
			<label for="EvntFeesYes"><input type="radio" id="EvntFeesYes" name="event_fee" value="1" <?=$cheked;?> /> Yes</label>&nbsp;&nbsp;
			<label for="EvntFeesNo"><input type="radio" id="EvntFeesNo" name="event_fee" value="0" <?=$default;?>
			 /> No<br /></label>
	    <?php
		}
		?>
	   <div class='form-group' id="div_event_fee_section"  style="<?php echo $multi_event_fee;?>">
	   <div id='Event_fees' >
	    <?php 
    if($tournament_details->is_mult_fee == NULL and $tournament_details->Tournamentfee == 1 and $tournament_details->is_event_fee == 1 and $tournament_details->Event_Reg_Fee!=NULL){ 
	   $event_reg_fee=json_decode($tournament_details->Event_Reg_Fee);
	  
	  foreach ($event_reg_fee as $event => $fees) {
		$label = $revised_events[$event];
	?>
		  <br> <label class="control-label col-md-3" for="id_accomodation"><?php echo $label;?></label> <div class="col-md-8 form-group internal"><input type="text" style="width:40%;" class="form-control eventFee" name="fees[<?php echo $event;?>]" value="<?php echo $fees;?>"></div>
	    
	  <?php } }
	  	else{
		if($tournament_details->Multi_Events != NULL){
		$Multi_Events = json_decode($tournament_details->Multi_Events, true);
			foreach ($Multi_Events as $i => $event) {
				$label = $revised_events[$event];
			?>
			  <br> <label class="control-label col-md-3" for="id_accomodation"><?php echo $label;?></label> <div class="col-md-8 form-group internal">
			  <input type="text" style="width:40%;" class="form-control eventFee" name="fees[<?php echo $event;?>]" value=""></div>
			<?php
			}
		}
	}
	  ?>
		
		</div>
		</div> 	
		<!-- Event Fees Section end -->
	</div>

	</div>

		<!-- ********************** CouponCode Section Starts Here. ******************************* -->
	<?php
	    $default = "checked";
	    $cheked  = "";
		$coupon_code_display = "display:none;"; 
		$coupon_code_section = "display:none;"; 
		
	    if($tournament_details->Is_Coupon){
		   $default			= "";
	       $cheked			= "checked";
		   $coupon_code_section = "display:block;"; 
		}
		if($tournament_details->Tournamentfee == 1){
	       $coupon_code_display	= "display:block;";      
	    }
	?>
	<div id="couponCode_section" class="col-md-12 league-form-bg" style="margin-top:30px; <?php echo $coupon_code_display;?>">
	<div class="fromtitle">CouponCode Details </div>
		Do you want to provide coupon codes?&nbsp;
	<label for="ccYes"><input type="radio" id="ccYes" name="cc" value="1" <?=$cheked;?> /> Yes</label>&nbsp;&nbsp;
	<label for="ccNo"><input type="radio" id="ccNo" name="cc" value="0" <?=$default;?> /> No<br /></label>

		<div id="couponCode_details" name="couponCode_details" style="<?php echo $coupon_code_section;?>">
			<div id='CouponCodes' style="display:block;">
				<table id="coupons">  
				<?php
				if(count($coupon_codes) > 0){
				foreach ($coupon_codes as $i => $coupon){
				?>
                   <tr>  
					<td style="border-top: 0px solid #ddd;">
					<input class='form-control' id="coupon_code" name="coupon_code[]" type="text" style="width:95%" placeholder="Coupon Code" pattern="[0-9A-Za-z\\-]+" value="<?php echo $coupon['Coupon_Code'];?>" onkeydown="upperCase(this)"  />
					</td>  
					<td style="border-top: 0px solid #ddd;">
					<select class="form-control" name="coupon_method[]" id="coupon_method" style="width:100%"> 
					<option value="fixedprice" <?php if($coupon['Discount_Method'] == "fixedprice") echo 'selected="selected"'; ?>>
					Fixed Price</option>
					<option value="percentage" <?php if($coupon['Discount_Method'] == "percentage") echo 'selected="selected"'; ?>> Percentage</option>
					</select>
					</td>
					<td>&nbsp;&nbsp;&nbsp;</td>
					<td style="border-top: 0px solid #ddd;">
					<input class='form-control' id="coupon_value" name="coupon_value[]" type="text" style="width:50%" placeholder="Value" value="<?php echo $coupon['Coupon_Value'];?>"  /> 
					</td>
					<td style="border-top: 0px solid #ddd;">
					<input type="text" class='form-control expiry_date' placeholder="Expiry Date" name="expiry_date[]" style="width:70%" value="<?php echo date('m/d/Y', strtotime($coupon['Expiry_Date']));?>"  /> 
					</td>
					<td style="border-top: 0px solid #ddd;">
					<button type="button" name="addCoupons" id="addCoupons" class="btn btn-success">Add More</button>
					</td>
                  </tr>  
				 <?php }
				  }
				  else{
				 ?>
                   <tr>  
					<td style="border-top: 0px solid #ddd;">
					<input class='form-control' id="coupon_code" name="coupon_code[]" type="text" style="width:95%" placeholder="Coupon Code" pattern="[0-9A-Za-z\\-]+" value="" onkeydown="upperCase(this)"  />
					</td>  
					<td style="border-top: 0px solid #ddd;">
					<select class="form-control" name="coupon_method[]" id="coupon_method" style="width:100%"> 
					<option value="fixedprice">Fixed Price</option>
					<option value="percentage">Percentage</option>
					</select>
					</td>
					<td>&nbsp;&nbsp;&nbsp;</td>
					<td style="border-top: 0px solid #ddd;">
					<input class='form-control' id="coupon_value" name="coupon_value[]" type="text" style="width:50%" placeholder="Value" value=""  /> 
					</td>
					<td style="border-top: 0px solid #ddd;">
					<input type="text" class='form-control expiry_date' placeholder="Expiry Date" name="expiry_date[]" style="width:70%" value=""  /> 
					</td>
					<td style="border-top: 0px solid #ddd;">
					<button type="button" name="addCoupons" id="addCoupons" class="btn btn-success">Add More</button>
					</td>
                  </tr>  
				 <?php
				  }?>
				</table>
			</div>
		</div>
	</div>
	<!-- ********************** CouponCode Section Ends Here. ******************************* -->

	<div class="col-md-12 league-form-bg" style="margin-top:30px;"> <!-- Sponser Section Start -->
	<div class="fromtitle">Sponsors</div>	
	<!-- Sponser Section -->
	<div id="div_sponser_section">	
	<?php if($tournament_details->Sponsors != "" && $tournament_details->Sponsors != NULL && $tournament_details->Sponsors != 'null'){
	$sponsors_arr=json_decode($tournament_details->Sponsors);
	foreach ($sponsors_arr as $sponsor => $sponsor_addr_link){?>
	<input type="checkbox" name="sponsor_chk[]" class="sponsor_chk_cls"  value="<?php echo $sponsor;?>">
	<img width="200px" height="200px" src="<?php echo base_url().'tour_pictures/'.$tournament_details->tournament_ID.'/sponsors/'.$sponsor;?>">	
	<?php
	}?>
	<br>
	<input type="button" name="delete_spnsr" id="delete_spnsor" class="league-form-submit" value="Delete Sponsor"><br>
	<?php
	}?></div>

	<div id='Sponsors'>
	<table id="dynamic_field">  
	<tr>
	<td colspan="3" style="border-top: 0px solid #ddd;"><button type="button" name="add" id="add" class="btn btn-success">Add More</button></td>  
	</tr>  
	</table> 
	</div>
	</div>	<!-- Sponser Section end -->											

	<div class="col-md-12 league-form-bg" style="margin-top:30px;">    <!-- T-Shirt Section Start -->	
	<div class="fromtitle">T-Shirts</div>
	Do you want to collect T-Shirt Information&nbsp;
	<label for="T-ShirtYes"><input type="radio" id="T-ShirtYes" name="T-Shirt" value="1" <?php if($tournament_details->TShirt==1){ echo "checked";}?>/> Yes</label>&nbsp;&nbsp;
	<label for="T-ShirtNo"><input type="radio" id="T-ShirtNo" name="T-Shirt" value="0" <?php if($tournament_details->TShirt==0){ echo "checked";}?>/> No
	<br /></label>
	</div>    <!-- T-Shirt Section end -->

	<!-- USAAT Section Start -->
	<?php if($tournament_details->SportsType == 2){ ?>
	<div class="col-md-12 league-form-bg" style="margin-top:30px;" id="USAAT_Info" style="display:none">
	<div class="fromtitle">USATT</div>
	Is this USATT sanctioned tournament? &nbsp;
	<label for="USATTYes"><input type="radio" id="USATTYes" name="USATTInfo" value="1" <?php if($tournament_details->Is_USATT_Approved==1){ echo "checked";}?>/> Yes</label>&nbsp;&nbsp;
	<label for="USATTNo"><input type="radio" id="USATTNo" name="USATTInfo" value="0" <?php if($tournament_details->Is_USATT_Approved==0){ echo "checked";}?>/> No<br /></label>
	</div>
	<?php } ?>
    <!-- USAAT Section end -->

<script>
$(document).ready(function(){
    $('#myform').submit(function() {
        if (!($('#recommend').is(':checked'))) {
            alert("Please accept the Terms & Conditions");
			return false;
        }
	    else { return true; }
    });
});
</script>

<div class="col-md-12 league-form-bg" style="margin-top:30px; margin-bottom:20px;">
<div class="fromtitle">Review & Submit</div>

<div class='form-group'>
<div class='col-md-12 form-group internal input-group' style="font-size:13px; margin-left:25px">

<br><input type="checkbox" name="recommend" id="recommend" value="1" />  I accept the Terms & Conditions of A2MSports. I'm responsible for conducting the tournament and accept full responsibility that for any personnel, financial and legal issues that may arise.<br />

<input type="submit" value="Update" name='create_tourn' style="margin-top:20px" class="league-form-submit" />
</div>
</div>
</div>

</div>

</form>
<?php }
?>
</div><!--Close Top Match-->

<!--------------------------Start of Multi Event Script------------------------------------------> 

<script>
function allPossibleCases(arr){
  if (arr.length === 0){
    return [];
  }
else if (arr.length ===1){
	return arr[0];
}
else{
	document.getElementById('combinationsResult').innerHTML = '';

	var result = []; 
	var allCasesOfRest = allPossibleCases(arr.slice(1)); 
	//alert(allCasesOfRest);
	for (var c in allCasesOfRest){
	  for (var i = 0; i < arr[0].length; i++){
			result.push(arr[0][i] +"-"+allCasesOfRest[c]);
	  }
	}
		//alert(result);

	return result;
  }
}
</script>

<?php
if($tournament_details->tournament_format != "Teams"){
?>
<script type="text/javascript">
$(document).ready(function() {

var selectedEventsList = new Array();
var registerEventsList = new Array();

<?php foreach($reg_events_list as $ev){ ?>
registerEventsList.push("<?php echo $ev; ?>");
<?php } ?>

$("#Combinations").click(function(){

	$('#selected_events').html('');

var mev = '<?php echo $tournament_details->Multi_Events;?>';
var mel = '<?php echo $tournament_details->Event_Reg_Limit; ?>';
var met = '<?php echo $tournament_details->Multi_Event_Time; ?>';
var mef = '<?php echo $tournament_details->Event_Reg_Fee; ?>';

	var mev_a = '';
	var mel_a = '';
	var met_a = '';
	var mef_a = '';

	if(mev)
		mev_a = JSON.parse(mev);
	if(mel)
		mel_a = JSON.parse(mel);
	if(met)
		met_a = JSON.parse(met);
	if(mef)
		mef_a = JSON.parse(mef);

		 	var favourite1 = []; var favourite5 = [];
			var x = new Array();
	         $.each($('.sp_levels:checked'), function(){
			 var level=$(this).val();
			 var leveltext=$("span[for='"+level+"']").text();
				favourite1.push(leveltext);
				favourite5.push($(this).val());
			//	alert('favourite5 Is :: '+favourite5);
            });
		
			var favourite2 = [];
			if($('#Sport').val() == 4){
				favourite2.push('[ ]');
			}
			else{
				$.each($('.x1:checked'), function(){ 
				favourite2.push($(this).val());
			 });
			}
			
            var favourite3 = [];
	         $.each($('.age:checked'), function(){    
				favourite3.push($(this).val());
             });
			
			var favourite4 = [];
			 $.each($('.gender:checked'), function(){    
				favourite4.push($(this).val());
             });

x.push(favourite3); x.push(favourite4); x.push(favourite2); x.push(favourite5);


//x.push(favourite3); x.push(favourite4); x.push(favourite2); x.push(favourite1);

var r  =  allPossibleCases(x);

/* To Eliminate 1-Mixed/0-Mixed values */
var uniqueEvents = [];				
//var uniqueEvents2 = [];
	for (var i = 0; i < r.length; i++){
		var a_temp  = r[i];
		//var aa_temp = rr[i];

if(r[i].indexOf("Open-Mixed") > -1){
var a	= a_temp.replace('Open-Mixed','Mixed');
r[i] = a;
}

/* ************************ */

if(r[i].indexOf("U10-Open-Singles") > -1){
//r[i]  = 'U10-Open-Singles';
r[i]  = r[i].replace("U10-Open-Singles","U10-Singles");
}
else if(r[i].indexOf("U11-Open-Singles") > -1){
//r[i]  = 'U11-Open-Singles';
r[i]  = r[i].replace("U11-Open-Singles","U11-Singles");
}
else if(r[i].indexOf("U12-Open-Singles") > -1){
//r[i]  = 'U12-Open-Singles';
r[i]  = r[i].replace("U12-Open-Singles","U12-Singles");
}
else if(r[i].indexOf("U13-Open-Singles") > -1){
//r[i]  = 'U13-Open-Singles';
r[i]  = r[i].replace("U13-Open-Singles","U13-Singles");
}
else if(r[i].indexOf("U14-Open-Singles") > -1){
//r[i]  = 'U14-Open-Singles';
r[i]  = r[i].replace("U14-Open-Singles","U14-Singles");
}
else if(r[i].indexOf("U15-Open-Singles") > -1){
//r[i]  = 'U15-Open-Singles';
r[i]  = r[i].replace("U15-Open-Singles","U15-Singles");
}
else if(r[i].indexOf("U16-Open-Singles") > -1){
//r[i]  = 'U16-Open-Singles';
r[i]  = r[i].replace("U16-Open-Singles","U16-Singles");
}
else if(r[i].indexOf("U17-Open-Singles") > -1){
//r[i]  = 'U17-Open-Singles';
r[i]  = r[i].replace("U17-Open-Singles","U17-Singles");
}
else if(r[i].indexOf("U18-Open-Singles") > -1){
//r[i]  = 'U18-Open-Singles';
r[i]  = r[i].replace("U18-Open-Singles","U18-Singles");
}
else if(r[i].indexOf("U19-Open-Singles") > -1){
//r[i]  = 'U19-Open-Singles';
r[i]  = r[i].replace("U19-Open-Singles","U19-Singles");
}
else if(r[i].indexOf("Adults-Open-Singles") > -1){
//r[i]  = 'Open-Singles';
r[i]  = r[i].replace("Adults-Open-Singles","Adults-Singles");
}
else if(r[i].indexOf("Junior-Open-Singles") > -1){
r[i]  = r[i].replace("Junior-Open-Singles","Junior-Singles");
}
else if(r[i].indexOf("Senior-Open-Singles") > -1){
r[i]  = r[i].replace("Senior-Open-Singles","Senior-Singles");
}



if(r[i].indexOf("U10-Open-Doubles") > -1){
//r[i]  = 'U10-Open-Doubles';
r[i]  = r[i].replace("U10-Open-Doubles","U10-Doubles");
}
else if(r[i].indexOf("U11-Open-Doubles") > -1){
//r[i]  = 'U11-Open-Doubles';
r[i]  = r[i].replace("U11-Open-Doubles","U11-Doubles");
}
else if(r[i].indexOf("U12-Open-Doubles") > -1){
//r[i]  = 'U12-Open-Doubles';
r[i]  = r[i].replace("U12-Open-Doubles","U12-Doubles");
}
else if(r[i].indexOf("U13-Open-Doubles") > -1){
//r[i]  = 'U13-Open-Doubles';
r[i]  = r[i].replace("U13-Open-Doubles","U13-Doubles");
}
else if(r[i].indexOf("U14-Open-Doubles") > -1){
//r[i]  = 'U14-Open-Doubles';
r[i]  = r[i].replace("U14-Open-Doubles","U14-Doubles");
}
else if(r[i].indexOf("U15-Open-Doubles") > -1){
//r[i]  = 'U15-Open-Doubles';
r[i]  = r[i].replace("U15-Open-Doubles","U15-Doubles");
}
else if(r[i].indexOf("U16-Open-Doubles") > -1){
//r[i]  = 'U16-Open-Doubles';
r[i]  = r[i].replace("U16-Open-Doubles","U16-Doubles");
}
else if(r[i].indexOf("U17-Open-Doubles") > -1){
//r[i]  = 'U17-Open-Doubles';
r[i]  = r[i].replace("U17-Open-Doubles","U17-Doubles");
}
else if(r[i].indexOf("U18-Open-Doubles") > -1){
//r[i]  = 'U18-Open-Doubles';
r[i]  = r[i].replace("U18-Open-Doubles","U18-Doubles");
}
else if(r[i].indexOf("U19-Open-Doubles") > -1){
//r[i]  = 'U19-Open-Doubles';
r[i]  = r[i].replace("U19-Open-Doubles","U19-Doubles");
}
else if(r[i].indexOf("Adults-Open-Doubles") > -1){
//r[i]  = 'Open-Doubles';
r[i]  = r[i].replace("Adults-Open-Doubles","Adults-Doubles");
}
else if(r[i].indexOf("Junior-Open-Doubles") > -1){
r[i]  = r[i].replace("Junior-Open-Doubles","Junior-Doubles");
}
else if(r[i].indexOf("Senior-Open-Doubles") > -1){
r[i]  = r[i].replace("Senior-Open-Doubles","Senior-Doubles");
}

/* *********************** */
	    if(r[i].indexOf("1-Mixed") > -1){
			var a  = a_temp.replace('1-Mixed','Mixed');
				r[i]  = a;
		}
		else if(r[i].indexOf("0-Mixed") > -1){
			var a  = a_temp.replace('0-Mixed','Mixed');
				r[i]  = a;
		}
		/*else if(r[i].indexOf("2-Mixed") > -1){
			var a  = a_temp.replace('2-Mixed','2-Mixed');
				r[i]  = a;
		}*/
		if($.inArray(r[i], uniqueEvents) === -1) uniqueEvents.push(r[i]);
	}

r  = uniqueEvents.sort();
var events_html1 = "";
/* To Eliminate 1-Mixed/0-Mixed values */
var events_html = "<div><div class='col-md-6'>";
var count = 0;
selectedEventsList = [];

	for (var i = 0; i < r.length; i++) {
		var label;
		var lbl_temp = r[i];
		var a = lbl_temp.split("-");

		if(a[3]){
			var level_text = $("span[for='"+a[3]+"']").text();
			lbl_temp = lbl_temp.replace(a[3],level_text);
		}
		else if($.isNumeric(a[2])){
			var level_text = $("span[for='"+a[2]+"']").text();
			lbl_temp = lbl_temp.replace(a[2],level_text);
		}


		if(r[i].indexOf("U10-1") > -1){
			label = lbl_temp.replace("U10-1","U10-Boy's");
		}
		else if(r[i].indexOf("U11-1") > -1){
			label = lbl_temp.replace("U11-1","U11-Boy's");
		}
		else if(r[i].indexOf("U12-1") > -1){
			label = lbl_temp.replace("U12-1","U12-Boy's");
		}
		else if(r[i].indexOf("U13-1") > -1){
			label = lbl_temp.replace("U13-1","U13-Boy's");
		}
		else if(r[i].indexOf("U14-1") > -1){
			label = lbl_temp.replace("U14-1","U14-Boy's");
		}
		else if(r[i].indexOf("U15-1") > -1){
			label = lbl_temp.replace("U15-1","U15-Boy's");
		}
		else if(r[i].indexOf("U16-1") > -1){
			label = lbl_temp.replace("U16-1","U16-Boy's");
		}
		else if(r[i].indexOf("U17-1") > -1){
			label = lbl_temp.replace("U17-1","U17-Boy's");
		}
		else if(r[i].indexOf("U18-1") > -1){
			label = lbl_temp.replace("U18-1","U18-Boy's");
		}
		else if(r[i].indexOf("U19-1") > -1){
			label = lbl_temp.replace("U19-1","U19-Boy's");
		}
		else if(r[i].indexOf("Adults-Singles") > -1){
			label = lbl_temp.replace("Adults-Singles","Singles");
		}
		else if(r[i].indexOf("Adults-1") > -1){
			label = lbl_temp.replace("Adults-1","Men's");
		}
		else if(r[i].indexOf("Adults_30p-1") > -1){
			label = lbl_temp.replace("Adults_30p-1",'30p-Men');
		}
		else if(r[i].indexOf("Adults_40p-1") > -1){
			label = lbl_temp.replace("Adults_40p-1",'40p-Men');
		}
		else if(r[i].indexOf("Adults_50p-1") > -1){
			label = lbl_temp.replace("Adults_50p-1",'50p-Men');
		}
		else if(r[i].indexOf("Adults_veteran-1") > -1){
			label = lbl_temp.replace("Adults_veteran-1",'Veteran-Men');
		}
		else if(r[i].indexOf("Junior-1") > -1){
			label = lbl_temp.replace("Junior-1","Junior-Boy's");
		}
		else if(r[i].indexOf("Senior-1") > -1){
			label = lbl_temp.replace("Senior-1",'Senior-Men');
		}



		else if(r[i].indexOf("U10-0") > -1){
			label = lbl_temp.replace("U10-0","U10-Girl's");
		}
		else if(r[i].indexOf("U11-0") > -1){
			label = lbl_temp.replace("U11-0","U11-Girl's");
		}
		else if(r[i].indexOf("U12-0") > -1){
			label = lbl_temp.replace("U12-0","U12-Girl's");
		}
		else if(r[i].indexOf("U13-0") > -1){
			label = lbl_temp.replace("U13-0","U13-Girl's");
		}
		else if(r[i].indexOf("U14-0") > -1){
			label = lbl_temp.replace("U14-0","U14-Girl's");
		}
		else if(r[i].indexOf("U15-0") > -1){
			label = lbl_temp.replace("U15-0","U15-Girl's");
		}
		else if(r[i].indexOf("U16-0") > -1){
			label = lbl_temp.replace("U16-0","U16-Girl's");
		}
		else if(r[i].indexOf("U17-0") > -1){
			label = lbl_temp.replace("U17-0","U17-Girl's");
		}
		else if(r[i].indexOf("U18-0") > -1){
			label = lbl_temp.replace("U18-0","U18-Girl's");
		}
		else if(r[i].indexOf("U19-0") > -1){
			label = lbl_temp.replace("U19-0","U19-Girl's");
		}
		else if(r[i].indexOf("Adults-Doubles") > -1){
			label = lbl_temp.replace("Adults-Doubles","Doubles");
		}
		else if(r[i].indexOf("Adults-0") > -1){
			label = lbl_temp.replace("Adults-0","Women's");
		}
		else if(r[i].indexOf("Adults_30p-0") > -1){
			label = lbl_temp.replace("Adults_30p-0",'30p-Women');
		}
		else if(r[i].indexOf("Adults_40p-0") > -1){
			label = lbl_temp.replace("Adults_40p-0",'40p-Women');
		}
		else if(r[i].indexOf("Adults_50p-0") > -1){
			label = lbl_temp.replace("Adults_50p-0",'50p-Women');
		}
		else if(r[i].indexOf("Adults_veteran-0") > -1){
			label = lbl_temp.replace("Adults_veteran-0",'Veteran-Women');
		}
		else if(r[i].indexOf("Mixed") > -1){
			label = lbl_temp.replace("Mixed",'Mixed Doubles');
		}
		else if(r[i].indexOf("Junior-0") > -1){
			label = lbl_temp.replace("Junior-0","Junior-Girl's");
		}
		else if(r[i].indexOf("Senior-0") > -1){
			label = lbl_temp.replace("Senior-0",'Senior-Women');
		}
		else{
			label = lbl_temp;
		}

		var checked = '';
		if(mev_a){
			if(mev_a.indexOf(r[i]) > -1){
				checked = 'checked';
			}
		}
		
		var limit_val = '';
	    if(mel_a != '' && mel_a[r[i]])
			limit_val = mel_a[r[i]];

		var time_val = '';
	    if(met_a != '' && met_a[r[i]])
			time_val = met_a[r[i]];

		var fee_val = '';
	    if(mef_a != '' && mef_a[r[i]])
			fee_val = mef_a[r[i]];


		if(Math.round(r.length/2) == count){
			events_html += "</div><div class='col-md-6'>";
		}

	 var counter = selectedEventsList.length;

		var readonly = '';
		var checked  = '';
		var info_ico = '';
		var chk_hide = "display:block;";

		if($.inArray(r[i], registerEventsList) !== -1 || $.inArray(r[i],multiEvent_indexs) !== -1){
			events_html1 += "<div style='padding-bottom:5px;'> <span>"+label+"</span></div>";
		}

		if($.inArray(r[i], registerEventsList) !== -1){
			checked  = "checked='checked' ";
			readonly = "readonly";	
			chk_hide = "display:none;";
			info_ico = "&nbsp;<img src='<?php echo base_url(); ?>icons/info_ico.png' title='Event has registered players' width='16px' height='16px' />";

			selectedEventsList.push({
			item  : label,
			value : r[i]
			});
			//events_html1 += "<div style='padding-bottom:5px;'> <span>"+label+"</span></div>";
		}

	 if($.inArray(r[i],multiEvent_indexs) !== -1){
		$('#SelectAll').prop('checked',true);
		selectedEventsList.push({
		item  : label,
		value : r[i]
		});
		
		checked = "checked='checked' ";

	 	events_html += "<div style='padding-bottom:5px;'><input style='"+chk_hide+"' type='checkbox' id='"+r[i]+"' class='CombiChecked' name='mul_events[]' value='"+r[i]+"'"+checked+readonly+"/> <span>"+label+info_ico+"</span></div>";
		//events_html1 += "<div style='padding-bottom:5px;'> <span>"+label+"</span></div>";
	 }
	 else{
		events_html += "<div style='padding-bottom:5px;'><input type='checkbox' id='"+r[i]+"' class='CombiChecked' name='mul_events[]' value='"+r[i]+"'"+checked+readonly+" /> <span>"+label+info_ico+"</span> </div>";
	 }
	
	count++;
	}

		events_html += "</div></div>";
		$('#combinationsResult').append(events_html);
		$('#selected_events').append(events_html1);
		 
		//if($.inArray(r[i],multiEvent_indexs) !== -1 ){ 
		//}

	if(count == 0){
		$('#EventsID').text("Please select at least one Combination / Sports Level.");
	}
	else{
		$('#EventsID').text("These are the list of events based on your inputs. Please select the events you want to keep for this tournament");
 	}

if(multiEvent_indexs.length == 0 && registerEventsList.length == 0){
	$('#confirm_proceed').hide();
	$('#limitsdiv').hide();
}

if(multiEvent_indexs.length == 0 && registerEventsList.length != 0){
	$('#limitsdiv').hide();
}

 multiEvent_indexs = [];

	$('#ListCount').html('Selected List of Events are: ('+selectedEventsList.length+')');
	$('#SelectAll').prop('checked',false);

});

	$('#combinationsResult').on('click', '.CombiChecked', function(){
			if($(this).prop('checked') === true){
				//	alert($(this).next('span').html());
				selectedEventsList.push({
					item : $(this).next('span').html(),
					value : $(this).val()
				});
			}
			else{
				var removeItem = $(this).val();
				selectedEventsList = $.grep(selectedEventsList, function(data) {
				return data.value != removeItem;
				});
			}
		
					if(selectedEventsList.length > 0){
						$('#confirm_proceed').attr('disabled',false);
						$('#confirm_proceed').show();
					}
					else{
						$('#confirm_proceed').attr('disabled',true);
						//	 $("#limitsdiv").hide();
						$('#confirm_proceed').hide();
						$("#limitsdiv").hide();

					}

		 $('#selected_events').html('');
		 $('#ListCount').html('Selected List of Events are: ('+selectedEventsList.length+')');
		 $.each(selectedEventsList, function(index, values){
				$('#selected_events').append(values.item);
				$('#selected_events').append("<br />");
		  });

		$('#limitsdiv').hide();
	});
 

	$("#confirm_proceed").click(function() {
				 
			$('#div_event_section').empty();
			$('#div_event_time_section').empty();
			$('#div_event_fee_section').empty();
			$("#limitsdiv").show();

 		$.each(selectedEventsList, function(index, values1){
				
			// Event Limits Section
			   $('#div_event_section').append('<div class="col-md-1 form-group internal"></div><label class="control-label col-md-3" for="id_accomodation">'+values1.item+'</label><div class="col-md-8 form-group internal"><input type="text" style="width:40%;" class="form-control eventLimit txt_'+values1.value+'" name="limit['+values1.value+']" placeholder="Enter Limit" /></div>');
			// Event Time Section
			   $('#div_event_time_section').append('<div class="col-md-1 form-group internal"></div><label class="control-label col-md-3" for="'+values1.value+'">'+values1.item+'</label> <div class="col-md-8 form-group internal"><input type="text" style="width:40%;" class="form-control eventTime txt_'+values1.value+'" name="time['+values1.value+']" placeholder="Enter DateTime" /></div>');

			// Event Multi Fee Section
			   $('#div_event_fee_section').append("<div class='col-md-1 form-group internal'></div><label class='control-label col-md-3' for='"+values1.value+"'>"+values1.item+"</label> <div class='col-md-8 form-group internal'><input type='text' style='width:40%;' class='form-control eventFee txt_"+values1.value+"' name='fees["+values1.value+"]' placeholder='Enter Fee' /></div>");

 		});
 	});

	/*	$('#SelectAll').click(function(){
  		//	$('#selected_events').html('');
 	  	if($(this).prop('checked')){
			selectedEventsList.length = 0;
		  	$(".CombiChecked").each(function () {
				$(this).prop('checked', true);
			  		selectedEventsList.push({
						item : $(this).next('span').html(),
						value : $(this).val()
					});
			 });
		}
		else{
			$(".CombiChecked").each(function () {
				$(this).prop('checked', false);
			 	var removeItem = $(this).val();
				selectedEventsList = jQuery.grep(selectedEventsList, function(data){
					return data.value != removeItem;
				});
			});
	  	}
			$('#selected_events').html('');
 		//if(selectedEventsList.length > 0) {
			$('#ListCount').html('Selected List of Events are: ('+selectedEventsList.length+')');
		//}

 		$.each(selectedEventsList, function(index, values){
		  	$('#selected_events').append(values.item);
		  	$('#selected_events').append("<br />");
		});
 
		if(selectedEventsList.length > 0) {
		  //$('#confirm_proceed').attr('disabled',false);
			$('#confirm_proceed').show();
		}
		else{
		//$('#confirm_proceed').attr('disabled',true);
			$('#confirm_proceed').hide();
			$("#second_section").hide();
		}
	});		// End of Select All functionality
	*/
});		// close of document ready

</script>

<?php
}
?>

<script type="text/javascript">
$(document).ready(function(){

	var mev_status = "<?php if($tournament_details->Multi_Events != NULL) { echo '1'; } else { echo '0'; } ?>";

	if(mev_status)
	$('#Combinations').trigger('click');

	$("input[name='event_fee']").click(function () {
		  if ($("#EvntFeesYes").is(":checked")) {
		  	$("#div_event_fee_section").show();
		  	$("#div_fee_section").hide();	
		  }else{
		  	$("#div_fee_section").show();
		  	$("#event_fee_section").show();
		  	$("#div_event_fee_section").hide();
		  	
		  }
	});

/*EvntYes
EvntNo

EvntTimeYes
EvntTimeNo

EvntFeesYes
EvntFeesNo*/

$('#EvntYes').click(function(){
	$('.eventLimit').prop('required', true);
});

$('#EvntNo').click(function(){
	$('.eventLimit').prop('required', false);
});

$('#EvntTimeYes').click(function(){
	$('.eventTime').prop('required', true);
});

$('#EvntTimeNo').click(function(){
	$('.eventTime').prop('required', false);
});

$('#EvntFeesYes').click(function(){
	$('.eventFee').prop('required', true);
});

$('#EvntFeesNo').click(function(){
	$('.eventFee').prop('required', false);
});

if(tour_format == 'Teams' || tour_format == 'TeamSport' ){
//$('.age').attr('disabled', false);
//$(".age").prop("checked", false);
//$("#dyn_courts").html('');
$('#num_lines_div').show();
$('#mtype').hide();
$('#mtype_check').hide();
$('#addl_fee_div').hide();
$('#limits_section').hide();
$('#generate_events').hide();
//$('#team_event_section').show();
$('#event_fee_section').hide();
$('#event_time_section').hide();
$("#fee_type").show();
$(".x1").attr("disabled", true);
$("#limitsdiv").show();
$("#Combinations").hide();
$("#confirm_proceed").hide();
$('#select').hide();
}
else{
//$(".age").prop("checked", false);
//$("#dyn_courts").html('');
$('#num_lines').val('');
$('#lines_section').html('');
$('#num_lines_div').hide();
$('#lines_div').hide();
$('#event_section').show();
$('#generate_events').show();
//$('#team_event_section').hide();
$('#event_fee_section').show();
$('#event_time_section').show();
$('#mtype').show();
$('#addl_fee_div').show();
$("#fee_type").hide();
$(".x1").attr("disabled", false);
}

if(tour_format == 'TeamSport'){
	$('#EventsID').hide();
	$('#ListCount').hide();
//	$('#select').hide();
}

if(db_country != '')
$('#country').val(db_country).trigger('change');

});
</script>
<!----------------------------End of Multi Event Script------------------------------------------> 