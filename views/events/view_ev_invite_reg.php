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

var baseurl = "<?php echo base_url();?>";
var sp_type = '<?php echo $ev_det["Ev_Sport"];?>'

$('#created_by').autocomplete({

	source: function( request, response ) {
  		$.ajax({
			url: baseurl+'search/autocomplete',
  			dataType: "json",
			method: 'post',
			data: {
			   name_startsWith: request.term,sp_type: sp_type,
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
		//alert(ui.item.data);
		var names = ui.item.data.split("|");						
		//$('#created_users_id').val(names[1]);
		//alert(names);

		var chk_box = '<input class="check_all" type="checkbox" name="sel_user[]" id="sel_player_'+names[1]+'" value="'+names[1]+'" />';
		$('#reg_users_table tr:last').after('<tr><td>'+chk_box+'</td><td>'+names[0]+'</td><td>'+names[2]+'</td><td>'+names[3]+'</td></tr>');
		
		$('#created_by').val('');
		$('#created_by').focus();
	}  	
	});

	});
</script>

<!------------------------------------filters for events section start--------------------------------------->
	
<div class="col-md-12 league-form-bg" style="margin-top:30px; margin-bottom:30px;display:none;" id="div1">

<!----------------------------------------------Invite Players section------------------------------------------------ -->

<div class="accordion"  id="up_match_section"  style="background:#f59123; padding:5px; color:white;">
<i class="fa fa-arrow-circle-o-right" style="color:white;"> </i>Invite Players (Non registered Users)<span></span>
</div>
			
<form class="form-horizontal" id='form-op-users' method='post' role="form" 
action="<?php echo $this->config->item('club_pr_url');?>/events/invite_players"> 

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


<form class='form-horizontal' name='send_email' id='send_email' method="post" action='<?php echo $this->config->item('club_pr_url');?>/events/send_event'>

	<div class='form-group' style='margin-top: 25px;'>
		<label class='control-label col-md-3' for='id_accomodation'>Search Player & Add:</label>
		<div class='col-md-5 form-group internal'>
		<input class='ui-autocomplete-input form-control inwidth' id='created_by' name='created_by' type='text' placeholder="Player Name" value="" />
		</div>
	</div>

<div class='form-group' style='col-md-8'>
<!-- Table view Players section -->

<table id="reg_users_table" class="table tab-score">
<thead>
<tr class="top-scrore-table">
	<th width="10%" class="score-position"><input type='checkbox' name="sel_all" id="sel_all" />Select</th>
	<th>&nbsp;Name</th>
	<th>&nbsp;City</th>
	<th>&nbsp;State</th>
</tr>
</thead>
<tbody></tbody>
</table>
<!-- End of Table view Players section  -->
</div>

	<br />
	<div class='form-group'>
		<label class='control-label col-md-3' for='id_accomodation'>Message to Players </label>
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