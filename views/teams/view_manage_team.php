<script>
$(document).ready(function(){ 
	$("#sel_all").change(function(){
		$(".checkbox1").prop('checked', $(this).prop("checked"));
	});
});
</script>

<script>
$(document).ready(function(){
var baseurl = "<?php echo base_url();?>";
var team = "<?php echo $team_id; ?>";
var tour = $('#tourn_id').val();

$('#tm_'+team).autocomplete({
	source: function( request, response ) {
  		$.ajax({
			url: baseurl+'teams/autocomplete',
  			dataType: "json",
			method: 'post',
			data: {
			   name_startsWith: request.term,
			   tour_id: tour,
			   team_id: team,
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
		//$('#created_users_id').val(names[1]);
		//alert(names);
		$('#team_table_'+team).append('<tr><td style="padding-left:20px;"><input type="checkbox" name="sel_team_player[]" class="checkbox1" value="'+names[1]+'" /></td><td style="padding-left:10px"><b><a href="'+baseurl+'player/'+names[1]+'" target="_blank">'+names[0]+'</a></b></td><td style="padding-left:10px">'+names[2]+'</td></tr>');

		$('#sel_team_players_'+team).append($('<option/>', { 
			value: names[1],
			text : names[0] 
		}));

		$('#tm_'+team).val(''); 
		$('#tm_'+team).focus();

	}
});

  /*$('input[type=text]').focus(function() {
       $(this).val('');
  });*/
});
</script>
<form name='frm_manage_team' id='frm_manage_team_<?=$team_id;?>' style='padding-left:20px;padding-right:20px;padding-top:5px;' enctype='multipart/form-data'>

<input type='hidden' name='team_id' id='team_id' value='<?=$team_id;?>' />

<p><input style='width:40%' class='form-control' name='team_name' type='text' placeholder="Team Name" value="<?=$team_name;?>" /></p>

<p><input style='width:40%' class='ui-autocomplete-input form-control inwidth created_by' id='tm_<?=$team_id;?>' name='created_by' type='text' placeholder="Search Player & Add" value="" /></p>

<p><label>Team Logo</label>
<?php if($team_logo!=''){?>
<img src="<?=base_url();?>team_logos/cropped/<?=$team_logo;?>">
<?php } ?>
<input type="hidden" value="<?=$team_logo;?>" name="team_old_logo_<?=$team_id;?>" id="team_old_logo_<?=$team_id;?>">
<input name='team_logo_<?=$team_id;?>' id="team_logo_<?=$team_id;?>" type='file' />	
</p>

<br />
<!-- <div id="team_players" style=" margin:auto;overflow-y:scroll;overflow-x:scroll;height:auto;width: auto;"> -->
<div id="team_players" style=" margin:auto;height:auto;width: auto;">
<table id='team_table_<?=$team_id;?>' class="tab-score" style='width:80%'>
<tr>
	<th style="padding-left:20px;"><input type='checkbox' name="sel_all" id="sel_all" /></th>
	<th style="padding-left:40px;">Player</th>
	<th style="padding-left:20px;">Contact#</th>
</tr>

<?php
$build_select = "";

if(count($team_players) > 0){
foreach($team_players as $player)
{
?>
<tr>
<td style="padding-left:20px;">
<input type="checkbox" name="sel_team_player[]" class="checkbox1" value="<?php echo $player;?>" checked='checked' />
</td>

<td style="padding-left:10px">
<?php
$user = teams::get_username($player);
$selected = '';
$captain_ico = "";
if($player == $team_captain){
	$selected = 'selected';
	$captain_ico = "<img src='".base_url()."icons/letter_c.png' title='Captain' style='width:15px; height:15px;' />";
	}

echo "<b><a href='".base_url()."player/".$user['Users_ID']."' target='_blank'>" . ucfirst($user['Firstname']) . " " . ucfirst($user['Lastname']) . "</a></b> &nbsp;{$captain_ico}";
?>
</td>

<td style="padding-left:10px"><?php 
$phone = preg_replace("/^(\d{3})(\d{3})(\d{4})$/", "($1) $2-$3", $user['Mobilephone']);
echo $phone; ?></td>
</tr>
<?php

$build_select .= "<option value='".$player."'".$selected.">".$user['Firstname']." ".$user['Lastname']."</option>";
}
}
else
{
?>
<tr><td colspan='3'>No Players found in your team!</td></tr>
<?php
}
?>
</table>
</div>
<!-- Register a new Player by team captain -->

<p><b>Note:</b> Click <b>
	<input type="button" id="rp_<?=$team_id;?>" value="Register Player" class="reg_player league-form-submit1"></b> if you want to add a new player to our site.

	<div class='form-group' id="rpform_<?=$team_id;?>" style="display:none">
		<!-- <form name='loc_form' id='loc_form' method="post" action='<?php echo base_url();?>events/location_add'> -->			
		<div class='form-group'>
			<label class='control-label col-md-4' for='id_accomodation'>First Name </label>
			<div class='col-md-5 form-group internal'>
			<input type="text" id="txtfname_<?=$team_id;?>" name="txt_fname" class='form-control' />
			</div>
		</div>

		<div class='form-group'>
			<label class='control-label col-md-4' for='id_accomodation'>Last Name </label>
			<div class='col-md-5 form-group internal'>
			<input type="text" id="txtlname_<?=$team_id;?>" name="txt_lname" class='form-control' />
			</div>
		</div>

		<div class='form-group'>
			<label class='control-label col-md-4' for='id_accomodation'>Gender </label>
			<div class='col-md-5 form-group internal'>
			<input type="radio" name="gender_<?=$team_id;?>" value="1" checked/> Male&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			<input type="radio" name="gender_<?=$team_id;?>" value="0" /> Female
			</div>
		</div>

		<div class='form-group'>
			<label class='control-label col-md-4' for='id_accomodation'>Email </label>
			<div class='col-md-5 form-group internal'>
			<input type="text" id="txtemail_<?=$team_id;?>" name="txt_email" class='form-control txt_email' />
			<span id='email_stat_<?=$team_id;?>' style='color:red'></span>
			</div>
		</div>

		<!-- <div class='form-group'>
			<label class='control-label col-md-4' for='id_accomodation'>Phone </label>
			<div class='col-md-5 form-group internal'> -->
			<input type="hidden" id="txtphone_<?=$team_id;?>" name="txt_phone" class='form-control' />
			<!-- </div>
		</div> -->

		<!-- <div class='form-group'>
			<label class='control-label col-md-4' for='id_accomodation'>Zip/Postal Code </label>
			<div class='col-md-5 form-group internal'> -->
			<input type="hidden" id="zipcode_<?=$team_id;?>" name="Zipcode" class='form-control' />
			<!-- </div>
		</div> -->

		<div class='form-group'>
			<label class='control-label col-md-4' for='id_accomodation'></label>
			<div class='col-md-8 form-group internal'>
			<input type="hidden" id="sportstype_<?=$team_id;?>" name="sportstype" value="<?=$Sport;?>"/>
			<input type="button" id="<?=$team_id;?>" name="btn_register" value=" Register " class="btn_register league-form-submit1" />
			<input type="button" id="cancel_<?=$team_id;?>" name="btn_register_cancel" value=" Cancel " class="league-form-submit1 btn_register_cancel" />
			</div>
		</div>
		<!-- </form> -->
	</div>
	</p>

<!-- Register a new Player by team captain -->
<br />
<p><select name='team_captain' id='sel_team_players_<?=$team_id;?>' class='form-control' style='width:30%;display:inline;'>
<option value=''>Change Captain</option>
<?=$build_select;?>
</select>&nbsp;&nbsp;&nbsp;
<input type="submit" id='<?=$team_id;?>' value="Update Team" name='upd_players' style="margin-top:10px;padding:8px;" class="upd_players league-form-submit" />
</p>
</form>