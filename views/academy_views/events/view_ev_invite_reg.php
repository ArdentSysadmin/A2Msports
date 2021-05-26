<script type="text/javascript">
$( document ).ready(function(){

$('#showdiv1').click(function() {
$('div[id^=div]').hide();
$('#div1').show();
});

});
</script>

<script>
$(document).ready(function(){
    $('#send_email').submit(function(){
       if($("input[name='sel_user[]']:checked").length == 0){ 
            alert("Select atleast one player to send invite"); 
			return false;
        }
	    else { return true; }
    });
});
</script>

<script>
	$(document).ready(function(){ 
		$("#sel_all").change(function(){
		  $(".check_all").prop('checked', $(this).prop("checked"));
		  });
	});
</script>


<!------------------------------------filters for events section start--------------------------------------->
	
<div class="col-md-12 league-form-bg" style="margin-top:30px; margin-bottom:30px;display:none;" id="div1">


		<!----------------------------------------------Invite Players section------------------------------------------------ -->


		<div class="accordion"  id="up_match_section"  style="background:#f59123; padding:5px; color:white;"><i class="fa fa-arrow-circle-o-right" style="color:white;"> </i>Invite Players (Non registered Users)<span></span></div>
			
			
			<form class="form-horizontal" id='form-op-users' method='post' role="form"  action="<?php echo base_url();?>events/invite_players"> 
				
					<input type="hidden" id="event_id" name="event_id" value="<?php echo $ev_det['Ev_ID'];?>" /> 
					<br />
					<div class='form-group'>
					<label class='control-label col-md-3' for='id_accomodation'>Invities (Email Addresses) :</label> 
					<div class='col-md-7 form-group internal'>
					<textarea name="emails" class='form-control' id="mes" rows="10" cols="40" required></textarea>
					</div>	
					</div>
					  
					<div class='form-group'>
					<label class='control-label col-md-3' for='id_accomodation'>Message :</label> 
					<div class='col-md-7 form-group internal'>
					<textarea name="mes" class='form-control' id="mes" rows="10" cols="40">Hi, I am conducting a new Event.
					</textarea>
					</div>	
					</div>
					 
					<div class='form-group'>
						<label class='control-label col-md-3' for='id_accomodation'></label>
						 <div class='col-md-7 form-group internal'>
						  <input type="submit" name='event_send' value="Send Invitation" class="league-form-submit"/>
						</div>
				    </div>
					
           	 </form>

		<!---------------------------------------end of -Invite Players section------------------------------------------------ -->
<br /><br />

<div class="accordion"  id="up_match_section1"  style="background:#f59123; padding:5px; color:white;"><i class="fa fa-arrow-circle-o-right" style="color:white;"> </i>Invite Players (Registered Users)<span></span></div>


<form class='form-horizontal' name='send_email' id='send_email' method="post" action='<?php echo base_url();?>events/send_event'>

	<br />
	<div class='form-group'>
		<label class='control-label col-md-3' for='id_title'>Sport Type</label>
		<div class='col-md-4 form-group internal'>
		
		<!-- <?php// foreach($sport_intrests as $row){ ?>
		<input type="checkbox" class="ajax_click" name="Sport[]" value="<?php// echo $row->Sport_id;?>"> <?php// $sport_name = events::get_sport($row->Sport_id); echo $sport_name['Sportname']; ?> &nbsp;
		<?php// } ?> -->

		<select name="Sport" id="Sport" class='form-control ajax_change'>
		<?php foreach($sport_intrests as $row) { ?>
		<option value="<?php echo $row->Sport_id;?>">
		<?php $sport_name = events::get_sport($row->Sport_id);

		echo $sport_name['Sportname'];
		?> 
		</option>
		<?php } ?>
		</select>

		</div>
	</div>

	<div class='form-group'>
		<label class='control-label col-md-3' for='id_accomodation'>Age Group</label>
		<div class='col-md-6 form-group internal'>
		<input type="checkbox" class="ajax_click" id="age" name="age_group[]" value="U10"> U10 &nbsp;
		<input type="checkbox" class="ajax_click" id="age" name="age_group[]" value="U12"> U12 &nbsp;
		<input type="checkbox" class="ajax_click" id="age" name="age_group[]" value="U14"> U14 &nbsp;
		<input type="checkbox" class="ajax_click" id="age" name="age_group[]" value="U16"> U16 &nbsp;
		<input type="checkbox" class="ajax_click" id="age" name="age_group[]" value="U18"> U18 &nbsp;
		<input type="checkbox" class="ajax_click" id="age" name="age_group[]" value="Adults"> Adults
		</div>
	</div>

	<div class='form-group'>
		<label class='control-label col-md-3' for='id_accomodation'>Level </label>
		<div id='sport_levels_div' class='col-md-6 form-group internal'>
		<?php foreach($sport_levels as $row){ ?>
		<input type="checkbox" class="ajax_click" name="level[]" value="<?php echo $row->SportsLevel_ID;?>"> <?php echo $row->SportsLevel;?> &nbsp;
		<?php } ?>
		</div>
	</div>

	<div class='form-group'>
		<label class='control-label col-md-3' for='id_accomodation'>Gender</label>
		<div class='col-md-6 form-group internal'>
		<input type="radio" class="ajax_click" name="gend" id="gend" value="M"> Male Only&nbsp;&nbsp;
		<input type="radio" class="ajax_click" name="gend" id="gend" value="F" > Female Only
		<input type="radio" class="ajax_click" name="gend" id="gend" value="all"> Open to All
		</div>
	</div>

	<div class='form-group'>
		<label class='control-label col-md-3' for='id_accomodation'>Near By</label>
		<div class='col-md-2 form-group internal'>
		<select name="range" class="form-control ajax_mile_change" id="range">
		<option value="">Miles</option>
		<option value="10">10</option>
		<option value="20">20</option>
		<option value="30">30</option>
		<option value="40">40</option>
		<option value="50">50</option>
		</select>
		</div>
   </div>

	<div class='form-group'>
		<label class='control-label col-md-3' for='id_accomodation'>Academy / Club </label>
		<div class='col-md-5 form-group internal'>
		<input id='academy' name="club_name" class='ui-autocomplete-input col-md-3 form-control ajax_blur' type="text" placeholder="USTA / USATT" />
		<input class='form-control' id='org_id' name='org_id' type='hidden' placeholder="Org_id" value=""  />
		</div>
	</div>

	<?php  if(isset($users)) { ?>
	<div id="load-users">
	<div style="overflow-y:scroll;<?php if($users->num_rows() > 15) { echo "height:350px"; } else if($users->num_rows() == 0){ echo "height:100px"; } ?>">

		<table class="tab-score-m">
		<tr>
		<th width="10%" class="score-position"><input type='checkbox' name="sel_all" id="sel_all" />Select</th>
		<th width="22%">Name</th>
		<th width="6%">Gender</th>
		<th width="30%">Location</th>
		<th width="15%">Level</th>
		<th width="11%">A2M Score</th>
		</tr>

		<?php
		if(count(array_filter($users->result())) > 0) {
			foreach($users->result() as $array)
			{
			?>
		<tr>
		<td><input class='check_all' type="checkbox" name="sel_user[]" value="<?php echo $array->Users_ID;?>" /></td>
		<td><a href="<?php echo base_url();?>player/<?php echo $array->Users_ID;?>"><?php echo $array->Firstname." ".$array->Lastname;?></a></td>
		<td><?php if($array->Gender == 1) { echo "Male"; } else { echo "Female"; } ?></td>
		<td><?php echo $array->City;?>, <?php echo $array->State; ?></td>
		<td>
		<?php    
		$user_id = $array->Users_ID;
		$sport = 1;
		$get_level = $this->model_event->get_user_sport_level($sport,$user_id);	
		$level = $get_level['Level'];
		$level_name = $this->model_event->get_sport_level_title($level,$sport);
		echo $level_name['SportsLevel'];
		?>
		</td>

		<td align='right'>
		<?php
		$user_a2mscore ="";
		$user_a2mscore = $this->model_event->get_a2msocre($sport,$user_id);
		if(isset($user_a2mscore)){echo $user_a2mscore['A2MScore'];}else{echo "none";}
		?>
		</td>
		</tr>
		<?php
		}
	  ?>
	<?php } else { ?>
	<tr><td colspan='6'><b>No Players Found. </b></td></tr>
	<?php } ?>
	</table>

	</div>
	</div>
	<?php } ?>
	<br />
	<div class='form-group'>
		<label class='control-label col-md-4' for='id_accomodation'>Message to Players </label>
		<div class='col-md-5 form-group internal'>
		<textarea rows="4" cols="15" class="form-control" name="ev_message"></textarea>
		</div>
	</div>

	<input type="hidden" name="ev_id" value="<?php echo $ev_det['Ev_ID'];?>" /> 

	<div class='form-group' align="center">
		<input type="submit" id="btn_event_match" name="btn_event_match"  value="Send Invite(s)" class="league-form-submit" style="margin-bottom:0px;"/>
	</div>


</form>
</div>

<!------------------------------------ Filters for events section end ------------------------------------------->