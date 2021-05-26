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


  $('input[type=text]').focus(function() {
       $(this).val('');
    });
});
</script>
<form name='frm_manage_team' id='frm_manage_team_<?=$team_id;?>' style='padding-left:20px;padding-right:20px;padding-top:5px;'>

<input type='hidden' name='team_id' id='team_id' value='<?=$team_id;?>' />
<p><input style='width:40%' class='ui-autocomplete-input form-control inwidth created_by' id='tm_<?=$team_id;?>' name='created_by' type='text' placeholder="Search Player & Add" value="" /></p>

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

echo "<b><a href='".base_url()."player/".$user['Users_ID']."' target='_blank'>" . $user['Firstname'] . " " . $user['Lastname'] . "</a></b> &nbsp;{$captain_ico}";
?>
</td>

<td style="padding-left:10px"><?php echo $user['Mobilephone']; ?></td>
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
<br />
<p><select name='team_captain' id='sel_team_players_<?=$team_id;?>' class='form-control' style='width:30%;display:inline;'>
<option value=''>Change Captain</option>
<?=$build_select;?>
</select>&nbsp;&nbsp;&nbsp;
<input type="submit" id='<?=$team_id;?>' value="Update Team" name='upd_players' style="margin-top:10px;padding:8px;" class="upd_players league-form-submit" />
</p>
</form>