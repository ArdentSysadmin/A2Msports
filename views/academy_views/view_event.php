<script src="<?php echo base_url();?>js/jquery-1.10.2.js" type="text/javascript"></script>
<script src="js/jquery.ui.totop.js" type="text/javascript"></script>
<script src="<?php echo base_url();?>js/jquery.accordion.js" type="text/javascript"></script>

<!-- <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
 -->


 <!-- Time related include files -->
<!-- <script type="text/javascript" src="<?php echo base_url();?>js/jtime/jquery.timepicker.js"></script>
<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>css/jtime/jquery.timepicker.css" />

<script type="text/javascript" src="<?php echo base_url();?>js/jtime/bootstrap-datepicker.js"></script>
<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>css/jtime/bootstrap-datepicker.css" />

<script type="text/javascript" src="<?php echo base_url();?>js/jtime/site.js"></script>
<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>css/jtime/site.css" />

<script src="<?php echo base_url();?>js/jtime/datepair.js"></script>
<script src="<?php echo base_url();?>js/jtime/jquery.datepair.js"></script> -->
 <!-- Time related include files -->


<script>
var short_code = "<?php echo $this->short_code; ?>";
$(document).ready(function(){

	$('body').on('focus',".datepicker", function(){
		$(this).datepicker();
	});

	$('#schedule').on('change', function(){

		$('#event_end_date').val("");
		$("#dialy_results").empty();

		if($('#schedule').val() != "singleday"){
			$('#sd_ed').show();

			if($('#schedule').val() == "weekly"){
				$('#sel_weekdays').show();
			} else {
				$('#sel_weekdays').hide();
			}
		}
		else {

			$('#ev_loc1').show();

			var baseurl = "<?php echo base_url();?>";

			$('#sd_ed').hide();
			var diffDays = 0;

				$.ajax({
					type:'POST',
					url:baseurl+short_code+'/events/add_fields/',
					data:{count:diffDays},
					success:function(html){
						var parentDiv = $('#dialy_results');
						parentDiv.html(html);
					}
				}); 
		}

	});
});
</script>

<script>
$(document).ready(function(){
var baseurl = "<?php echo base_url();?>";
		
	$('#ev_loc').autocomplete({
	source: function( request, response ) {
  		$.ajax({
			url: baseurl+short_code+'/events/autocomplete',
  			dataType: "json",
			method: 'post',
			data: {
			   name_startsWith: request.term,
			   type: 'users',
			   row_num : 1
			},
			 success: function( data ) {
				 response( $.map( data, function( item ) {
				 	var code = item.split("|");
					return {
						label: code[0],
						value: code[0],
						data : item
					}
				}));
			}
  		});
  	},
  	autoFocus: true,	      	
  	minLength: 1,
  	select: function( event, ui ) {
		var names = ui.item.data.split("|");						

	/*	$('#shortlist_users').append($('<option/>', { 
			value: names[1],
			text : names[0] 
		}));*/
		
		$('#ev_loc_id').val(names[1]);
	}		      	
	});

	$('#ev_loc').bind('blur', function(){
		 
		 var loc_title = $(this).val();

		var loc_id = $('#ev_loc_id').val();
		
		if(loc_title == ""){
			$('#ev_loc_id').val("");
		}
		
	});

});
</script>

<script>

$(document).ready(function(){

	var baseurl = "<?php echo base_url();?>";

	$('#event_start_date, #event_end_date, #event_st_time, #event_end_time, #change_loc, #ev_loc').on('change', function(){

		$("#dialy_results").empty();

		var sch_type = $("#schedule").val();

		var St_date	 = $("#event_start_date").val();
		var End_date = $("#event_end_date").val();
		var ev_st	 = $("#event_st_time").val();
		var ev_et	 = $("#event_end_time").val();

		var ev_loc_id	 = $("#ev_loc_id").val();
		var ev_loc_title = $("#ev_loc").val();

		//alert(ev_loc_title);

		var loc_stat = 0;

		if($("#change_loc").prop('checked') == true){
			loc_stat = 1;
		}

		var oneDay = 24*60*60*1000; // hours*minutes*seconds*milliseconds
		var firstDate = new Date(St_date);
		var secondDate = new Date(End_date);

		var diffDays = Math.round(Math.abs((firstDate.getTime() - secondDate.getTime())/(oneDay)));

		if(sch_type == 'daily'){

			$.ajax({
                type:'POST',
                url:baseurl+short_code+'/events/add_fields/',
				data:{sch_type:sch_type, 
					count:diffDays, 
					sd:St_date, 
					ed:End_date, 
					st:ev_st, 
					et:ev_et, 
					ev_loc_id:ev_loc_id,
					ev_loc_title:ev_loc_title,
					loc_stat:loc_stat
					},
                success:function(html){
					var parentDiv = $('#dialy_results');
					parentDiv.html(html);
                }
            });

		} else if(sch_type == 'weekly'){

			var sel_weeks = [];
			$("input[name='event_day[]']:checked").each(function(i){
			  sel_weeks[i] = $(this).val() ;
			});

			$.ajax({
                type:'POST',
                url:baseurl+short_code+'/events/add_fields_weekly/',
				data:{sel_weeks: sel_weeks, 
					sch_type:sch_type, 
					count:diffDays, 
					sd:St_date, 
					ed:End_date, 
					st:ev_st, 
					et:ev_et, 
					ev_loc_id:ev_loc_id,
					ev_loc_title:ev_loc_title,
					loc_stat:loc_stat					
				},
                success:function(html){
					var parentDiv = $('#dialy_results');
					parentDiv.html(html);
                }
            });

		}

	});

});
</script>

<script>
$(document).ready(function(){

	$('#btn_location').click(function(){

			var baseurl = "<?php echo base_url();?>";
			
			var Title = $("#loc_title").val();

		if(Title != ""){
			var Add		= $("#loc_add").val();
			var City	= $("#loc_city").val();
			var State	= $("#loc_state").val();
			var Country = $("#loc_country").val();
			var Zip		= $("#loc_zipcode").val();
			
			$.ajax({
					type:'POST',
					url:baseurl+short_code+'/events/location_add/',
					data:{title:Title, add:Add, city:City, state:State, country:Country, zip:Zip},
					success:function(res){
						$('#loc_form').each(function(){
						this.reset();
						});
						$('#location_form').hide();
						$('.loc_section').show();
					}
		   });
		}
		else {	alert("Location Name should not be empty!"); }
	});
});
</script>

<script>
$(document).ready(function(){
	
	
	$('#change_loc').click(function(){
		if($('#ev_loc1').css('display')=='none'){
			$('#ev_loc1').show();
		}
		else{
			$('#ev_loc1').hide();
		}
	});
	

	$('#add_location, #btn_loc_cancel').click(function(){
		if($('#location_form').css('display')=='none'){
			$('#location_form').show();
			$('.loc_section').hide();
		}
		else{
			$('#location_form').hide();
			$('.loc_section').show();
		}
	});
});
</script>

<section id="single_player" class="container secondary-page">

<div class="top-score-title right-score col-md-9">

<!-- start main body -->
<div class="col-md-12 league-form-bg" style="margin-top:40px;">
<div class="fromtitle">Schedule an Event or a League</div>
<p style="line-height:20px; font-size:13px">Whether you are a Team Captain managing the team schedule, a Coach trying to organize classes for different groups or just a player trying to organize practice or a fun event, you can do that here.
<?php if($this->session->userdata('user')=="") { ?>
<br>
Please <a href='<?php echo base_url()."login"; ?>'><b>Login</b> </a>to find players.</p>
<?php } ?>
</div>

<?php if($this->session->userdata('user')!="") { ?>	

	<div class="col-md-12 league-form-bg" style="margin-top:30px; margin-bottom:30px">
	<div class="fromtitle">Create an Event/ Schedule a League</div>

	<form class='form-horizontal' enctype="multipart/form-data" name='form-op-users' id='form-op-users' method="post" action='<?php echo base_url().$this->short_code;?>/events/create'>

	<div class='form-group'>
		<label class='control-label col-md-4' for='id_accomodation'><span style="color:red">* </span>Event Name </label>
		<div class='col-md-5 form-group internal'>
		<input type="text" id="" name="event_name" class='form-control' required />
		</div>
	</div>

	<div class='form-group'>
		<label class='control-label col-md-4' for='id_title'><span style="color:red">* </span>Event Type </label>
		<div class='col-md-3 form-group internal'>
		<select name="event_type" id="" class='form-control' required>
		<option value="">Select</option>
		<?php foreach($event_types as $type){?>
			<option value="<?php echo $type->Ev_Type_ID; ?>"><?php echo $type->Ev_Type; ?></option>
		<?php } ?>	
		</select>
		</div>
	</div> 

	<div class='form-group'>
		<label class='control-label col-md-4' for='id_accomodation'><span style="color:red">* </span>Event Organizer </label>
		<div class='col-md-5 form-group internal'>
		<input type="text" id="" name="event_org" class='form-control' value="<?php echo $this->session->userdata('user') ?>" />
		</div>
	</div>

	<div class='form-group'>
		<label class='control-label col-md-4' for='id_accomodation'><span style="color:red">* </span>Event Contact Number </label>
		<div class='col-md-5 form-group internal'>
		<input type="text" id="" name="event_contact" class='form-control'  />
		</div>
	</div>

	<div class="form-group">  
			<label class="control-label col-md-4" for="id_accomodation">Event Image </label>
            <div class="col-md-5 form-group internal">
			   <input id="" name="EventImage" style="margin-bottom:8px" type="file">
            </div>
    </div>
	<div class='form-group loc_section'>
		<label class='control-label col-md-4' for='id_accomodation'></label>
		<div class='col-md-8 form-group internal'><span style="font-size:12px"><b>Note:</b> Preferable file size (200 * 200 pixels).</span></div>
	</div>

	<div class='form-group loc_section' id='ev_loc1'>
		<label class='control-label col-md-4' for='id_accomodation'><span style="color:red">* </span>Location Name</label>
		<div class='col-md-5 form-group internal'>
		<input class='ui-autocomplete-input form-control inwidth' id='ev_loc' name='ev_loc' type='text' placeholder="Start Typing and Select" value='' />
		<input id='ev_loc_id' name='ev_loc_id' type='hidden' value="" />
		</div>
	</div>

	<div class='form-group loc_section'>
		<label class='control-label col-md-4' for='id_accomodation'></label>
		<div class='col-md-8 form-group internal'><b>Note:</b> Click <b><input type="button" id="add_location" value="Add New" class="league-form-submit1"></b> if your location didn't auto populate.</div>
	</div>

	

	<div class='form-group' id="location_form" style="display:none">
		<!-- <form name='loc_form' id='loc_form' method="post" action='<?php echo base_url();?>events/location_add'>  -->			
		<div class='form-group'>
			<label class='control-label col-md-4' for='id_accomodation'>Location Name </label>
			<div class='col-md-5 form-group internal'>
			<input type="text" id="loc_title" name="loc_title" class='form-control'  />
			</div>
		</div>

		<div class='form-group'>
			<label class='control-label col-md-4' for='id_accomodation'>Address </label>
			<div class='col-md-5 form-group internal'>
			<input type="text" id="loc_add" name="loc_add" class='form-control'  />
			</div>
		</div>

		<div class='form-group'>
			<label class='control-label col-md-4' for='id_accomodation'>City </label>
			<div class='col-md-5 form-group internal'>
			<input type="text" id="loc_city" name="loc_city" class='form-control'  />
			</div>
		</div>

		<div class='form-group'>
			<label class='control-label col-md-4' for='id_accomodation'>State </label>
			<div class='col-md-5 form-group internal'>
			<input type="text" id="loc_state" name="loc_state" class='form-control'  />
			</div>
		</div>

		<div class='form-group'>
			<label class='control-label col-md-4' for='id_accomodation'>Country </label>
			<div class='col-md-5 form-group internal'>
			<input type="text" id="loc_country" name="loc_country" class='form-control'  />
			</div>
		</div>

		<div class='form-group'>
			<label class='control-label col-md-4' for='id_accomodation'>Zip Code </label>
			<div class='col-md-5 form-group internal'>
			<input type="text" id="loc_zipcode" name="loc_zipcode" class='form-control'  />
			</div>
		</div>
		
		<div class='form-group'>
			<label class='control-label col-md-4' for='id_accomodation'></label>
			<div class='col-md-8 form-group internal'>
			<input type="button" id="btn_location" name="btn_location"  value=" Add " class="league-form-submit1" />
			<input type="button" id="btn_loc_cancel" name="btn_location_cancel"  value=" Cancel " class="league-form-submit1" />
			</div>
		</div>

		<!-- </form> -->
	</div>
	
	<div class='form-group'>
		<label class='control-label col-md-4' for='id_title'><span style="color:red">* </span>Schedule </label>
		<div class='col-md-3 form-group internal'>
		<select name="schedule" id="schedule" class='form-control' required>
			<option value="">Select</option>
			<option value="singleday">One Time</option>
			<option value="daily">Daily</option>
			<option value="weekly">Weekly</option>
			<!-- <option value="monthly">Monthly</option> -->		
		</select>
		</div>
	 </div> 

	<div id="sd_ed" style="display:none;">
		<div class='form-group' id="sel_weekdays"  style="display:none;">
			<label class='control-label col-md-4'>Week Days</label>
			<div class='col-md-8 form-group internal'>
			<table>
			<tr>
				<td>
					<input  type="checkbox" id="event_day1" class="sel_w" name="event_day[]" value='1' />Mon&nbsp;
					<input  type="checkbox" id="event_day2" class="sel_w" name="event_day[]" value='2' />Tue&nbsp;
					<input  type="checkbox" id="event_day3" class="sel_w" name="event_day[]" value='3' />Wed&nbsp;
					<input  type="checkbox" id="event_day4" class="sel_w" name="event_day[]" value='4' />Thu&nbsp;
					<input  type="checkbox" id="event_day5" class="sel_w" name="event_day[]" value='5' />Fri&nbsp;
					<input  type="checkbox" id="event_day6" class="sel_w" name="event_day[]" value='6' />Sat&nbsp;
					<input  type="checkbox" id="event_day7" class="sel_w" name="event_day[]" value='7' />Sun&nbsp;
				</td>
			</tr>
			</table>
			</div>
		</div>
		<div class='form-group' id="start_date">
			<label class='control-label col-md-4' for='id_title'>Strat & End Date</label>
			<div class='col-md-8 form-group internal'>
			<table>
			<tr>
			<td><input  type="text" class='form-control datepicker' id="event_start_date"  name="event_start_date" placeholder="MM/DD/YYYY" value="<?php echo date('m/d/Y'); ?>" /></td>
			<td>&nbsp;</td>
			<td><input  type="text" class='form-control datepicker' id="event_end_date"  name="event_end_date" placeholder="MM/DD/YYYY" /></td>
			</tr>
			</table>
			</div>
		</div>
		<div class='form-group' id="start_date">
			<label class='control-label col-md-4' for='id_title'>Start & End Time</label>
			<div class='col-md-8 form-group internal'>
			<table>
			<tr>
			<td>
				<select class='form-control' name="ev_st" id="event_st_time">
				<?php for($i = 0; $i < 24; $i++):?>
				  <option value="<?= $i % 12 ? $i % 12 : 12 ?>:00 <?= $i >= 12 ? 'pm' : 'am' ?>">
				  <?= $i % 12 ? $i % 12 : 12 ?>:00 <?= $i >= 12 ? 'pm' : 'am' ?>
				  </option>
				<?php endfor ?>
				</select>		
			</td>
			<td>&nbsp;</td>
			<td>
				<select class='form-control' name="ev_et" id="event_end_time">
				<?php for($i = 0; $i < 24; $i++):?>
				  <option value="<?= $i % 12 ? $i % 12 : 12 ?>:00 <?= $i >= 12 ? 'pm' : 'am' ?>">
				  <?= $i % 12 ? $i % 12 : 12 ?>:00 <?= $i >= 12 ? 'pm' : 'am' ?>
				  </option>
				<?php endfor ?>
				</select>
				<!-- <p id="datepairExample">
                    <input type="text" name="ev_st" class="time start" /> to 
					<input type="text" name="ev_et" class="time end" />
                </p>
				  <script>
					$('#datepairExample .time').timepicker({
						'showDuration': true,
						'timeFormat': 'g:ia'
					});

					$('#datepairExample').datepair();
				</script> -->

			</td>
			</tr>
			</table>
			</div>
		</div>

		<div class='form-group loc_section'>
			<label class='control-label col-md-4' for='id_accomodation'></label>
			<div class='col-md-8 form-group internal'>
			<input  type="checkbox" id="change_loc" class="ch_loc" name="change_loc" value='1' />&nbsp;&nbsp;&nbsp;Do you play at multiple locations for this event? </div>
		</div>
	</div>


	<div class='form-group' id="dialy_results"></div>
	
	<div class='form-group'>
		<label class='control-label col-md-4' for='id_title'>Description / Summary </label>
		<div class='col-md-5 form-group internal'>
		<textarea name="ev_message" class="form-control txt-area" id="" cols="30" rows="4"></textarea>
		</div>
	</div>

	<div class='form-group' align="center">
	<input type="submit" id="btn_create_event" name="btn_create_event"  value="Create Event" class="league-form-submit" style="margin-bottom:0px;"/>
	</div>

	
	</form> <!-- End of Form -->
	</div>
	
<?php } ?>
</div>
<!-- end main body -->

</div><!--Close Top Match-->