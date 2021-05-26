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
var team = $('#team_id').val();
var tour = $('#tourn_id').val();

$('#created_by').autocomplete({
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
		$('#team_table').append('<tr><td style="padding-left:20px;"><input type="checkbox" name="sel_team_player[]" class="checkbox1" value="'+names[1]+'" /></td><td style="padding-left:10px"><b><a href="'+baseurl+'player/'+names[1]+'" target="_blank">'+names[0]+'</a></b></td><td style="padding-left:10px">'+names[2]+'</td></tr>');

		$('#sel_team_players').append($('<option/>', { 
			value: names[1],
			text : names[0] 
		}));

		$('#created_by').val(''); 
		$('#created_by').focus();

	}
});

 $('.upd_team_players').click(function (e) {

  var formData  = new FormData($("#frm_manage_team")[0]);
    $.ajax({
    type: 'POST',
    url: baseurl+'teams/update_team',
    data: formData,
    async: false,
    success: function (res) {
    //console.log(res);
    // alert(res);die();
      location.reload();
    },
    cache: false,
        contentType: false,
        processData: false
    });
 
  e.preventDefault();
  });

  $('input[type=text]').focus(function() {
       $(this).val('');
    });
});
</script>
<form name='frm_manage_team' id="frm_manage_team" method='POST'>
<div id='div9' class="fromtitle">Add / Manage Team Players</div>
<input type='hidden' name='team_id' id='team_id' value='<?=$team_id;?>' />
<input type='hidden' name='tourn_id' id='tourn_id' value='<?=$tourn_id;?>' />
<input type='hidden' name='oteam' id='oteam' value='<?php echo htmlentities(serialize($team_players)); ?>' />
<p><label>Search Player & Add:</label>
<input class='ui-autocomplete-input form-control inwidth' id='created_by' name='created_by' type='text' placeholder="Player Name" value="" /></p>
</p>

<br />
<div id="team_players" style=" margin: auto;overflow-y: scroll;overflow-x: scroll;height:auto;width: auto;">
<table id='team_table' class="tab-score">
<tr class="top-scrore-table">
	<th style="padding-left:20px;"><input type='checkbox' name="sel_all" id="sel_all" /></th>
	<th style="padding-left:40px;">Player</th>
	<th style="padding-left:20px;">Contact#</th>
</tr>

<?php
$build_select = "";

if(count($team_players) > 0){
foreach($team_players as $player => $status)
{
?>
<tr>
<td style="padding-left:20px;">
<?php
if($status == 1)
{?>
<img src="<?=base_url();?>/icons/info_ico.png" title="Player is already part of another team for this Tournament" style="width:13px;height:13px" />
<?php
} else {?>
<input type="checkbox" name="sel_team_player[]" class="checkbox1" value="<?php echo $player;?>" <?php if($status == 2) { echo "checked='checked'"; }?> />
<?php
} ?>
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
<p><label>Change Captain:</label>
<select name='team_captain' id='sel_team_players' class='form-control' style='width:30%'>
<option value=''>Select</option>
<?=$build_select;?>
</select>
</p>
</p>
<input type="submit" value="Update Team" name='upd_players' style="margin-top:20px" class="upd_team_players league-form-submit" />
</div>
</form>