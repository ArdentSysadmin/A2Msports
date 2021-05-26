<script>
$(document).ready(function(){
	var tourn_id   = "<?php echo $get_bracket['Tourn_ID']; ?>";
	var bracket_id = "<?php echo $get_bracket['BracketID']; ?>";

	$('.ch_a_player').click(function(){
		if(confirm("Are you sure to Challenge?")){
		 var id = $(this).attr("id");
		 var x  = id.split('_');
		 var pl	= x[1];

			 $.ajax({
				type: "POST",
				async:false,
				url:baseurl+'league/challenge_a_player/',
				data:{ch_player:pl, tourn_id:tourn_id, bracket_id:bracket_id},
				dataType: "html",
				success: function(msg){
					if(msg){ alert('Challenge is successful!');		   }
					else   { alert('Something went wrong! Try again'); }
					$('#'+bracket_id).trigger('click');
			   }
			});
		}
	});

	$('.cancel_a_ch').click(function(){
		 var cl_id = $(this).attr("id");
		if(confirm("Are you sure to Cancel this Challenge?")){
			$.ajax({
				type: "POST",
				async:false,
				url:baseurl+'league/cancel_a_challenge/',
				data:{cl_id:cl_id,tourn_id:tourn_id, bracket_id:bracket_id},
				dataType: "html",
				success: function(msg){
					if(msg){ alert('Challenge is cancelled!');		   } 
					else   { alert('Something went wrong! Try again'); }
					$('#'+bracket_id).trigger('click');
			   }
			});
		}
	});

	$('#ladder_frm').submit(function(e){
		e.preventDefault();
		var form = $(this);

		$.ajax({
           type: "POST",
		   url: baseurl+'league/update_ladder_levels/',
           data: form.serialize(), // serializes the form's elements.
           success: function(res){
               if(res){ alert("Levels Updated Successfully!");	  }
			   else	  { alert('Something went wrong! Try again'); }
			   $('#'+bracket_id).trigger('click');
           }
         });
	});
});
</script>
<?php
$result = $cl_positions->result_array();
?>
<div class='tab-content' style='background-color:#ffffff'>
<div>
<p><b><?php echo $get_bracket['Draw_Title']; ?></b></p>
<? //--------------------------------------------------------------------------------------------------------------- ?>
<div class="table-responsive">
<form id="ladder_frm" name="ladder_frm">
<table class='tab-score' id='cl_draw'>
<thead>
<tr class='top-scrore-table'>
<td align='center'><b>Level</b></td>
<td align='center'><b>Player</b></td>
<td align='center'><b>Challenged by</b></td>
<td align='center'><b>Points</b></td>
</tr>
</thead>
<?php
$draw_ch_positions	  = $get_bracket['No_of_rounds'];
$logged_user_position = 0;
if($this->logged_user){
$logged_user_position = league::get_cl_user_position($get_bracket['BracketID'], $this->logged_user);
}

$temp = $logged_user_position;

for($i=1; $i<=($draw_ch_positions+1); $i++){
	$challengable_positons[] = $temp;
	$temp--;
}
$draw_exist_players = array();

foreach($result as $res){
	$draw_exist_players[] = $res['Player'];
	if($res['Player_Partner']){
	$draw_exist_players[] = $res['Player_Partner'];
	}
?>
<tr>
<td align='center'><?php
if($tour_details->Usersid == $this->logged_user or $this->is_super_admin){
?>
<span style="display:none;"><?=$res['Position'];?></span>
<select class='form-control' style='width:35%' id='ch_player_level' name='ch_player_level[]'>
<?php
for($i=1; $i<11; $i++){
	$sel = '';
	if($i == $res['Position']) $sel = "selected = 'selected'";
echo "<option value='".$res['CL_Id']."_".$i."' {$sel}>".$i."</option>";
}
?>
</select>
<?php
}
else{
	echo $res['Position'];
}
?></td>
<td align='center'>
<?php 
$player	= league::get_username($res['Player']);
$player_label = ucfirst($player['Firstname'])." ".ucfirst($player['Lastname']);

if($res['Player_Partner']){
$player_partner	= league::get_username($res['Player_Partner']);
$player_label .= "; ".ucfirst($player_partner['Firstname'])." ".ucfirst($player_partner['Lastname']);
}

echo $player_label; 
//echo "<pre>";
//print_r($challengable_positons);
if(!$res['Challenged_by']){
	if(in_array($res['Position'], $challengable_positons) 
		and $this->logged_user != $res['Player'] 
		and $this->logged_user != $res['Player_Partner']){
	echo "&nbsp;&nbsp;"."<img class='ch_a_player' id='ch_".$res['Player']."' src='".base_url()."icons/thumb.png' style='width:20px; height:20px; cursor:pointer' title='Create a Challenge' />";
	}
}
?>
</td>
<td align='center' style='font-weight: 400;'>
<?php
if($res['Challenged_by']){
	$ch_by = league::get_username($res['Challenged_by']);
	echo ucfirst($ch_by['Firstname'])." ".ucfirst($ch_by['Lastname']);
}

if(($tour_details->Usersid == $this->logged_user or $this->is_super_admin) and $res['Challenged_by']){
	echo "&nbsp;&nbsp;"."<img class='cancel_a_ch' id='".$res['CL_Id']."_".$res['Player']."_".$res['Challenged_by']."' src='".base_url()."icons/cancel.png' style='width:20px; height:20px; cursor:pointer' title='Cancel this challenge' />";
}
?>
</td>
<td align='center'>
<?php
$get_player_points = league::get_player_points($get_bracket['BracketID'], $res['Player']);
$tot_points = 0;
if(count($get_player_points) > 0){
	foreach($get_player_points as $player_points){
		if($res['Player'] == $player_points['Player1'] or $res['Player'] == $player_points['Player1_Partner']){
			$tot_points += $player_points['Player1_points'];
		}
		else if($res['Player'] == $player_points['Player2'] or $res['Player'] == $player_points['Player2_Partner']){
			$tot_points += $player_points['Player2_points'];
		}
	}
}

if($tot_points) echo $tot_points;
else echo "-";
?>
</td>
</tr>
<?php
}
?>
</table>
<?php
if($tour_details->Usersid == $this->logged_user or $this->is_super_admin){
?>
<br />
<div>
<div align='left'><input type="submit" class="league-form-submit1" name="update_levels" id="update_levels" value=" Update " /></div>
</div>
<br />
<?php
}?>

</form>
<?php
if($tour_details->Usersid == $this->logged_user or $this->is_super_admin){
?>
<script>
	$('#div_add_player').hide();

$(document).ready(function(){
	var tourn_id   = "<?php echo $get_bracket['Tourn_ID']; ?>";
	var bracket_id = "<?php echo $get_bracket['BracketID']; ?>";

	$('#add_player').click(function(){
		($(this).prop("checked") == true) ? $('#div_add_player').show() : $('#div_add_player').hide();
	});

	$('#add_new_player').click(function(){
		if($('#new_player').val()){
		     var new_player		  = $('#new_player').val();
		     var new_player_2	  = $('#new_player_2').val();
		     var new_player_level = $('#new_player_level').val();
				
			 if(new_player == new_player_2){
				alert("Both, Player & Partners are same!");
				return false;
			 }

			 $.ajax({
				type: "POST",
				async:false,
				url:baseurl+'league/add_new_cl_player/',
				data:{new_player:new_player, new_player_2:new_player_2, new_player_level:new_player_level, tourn_id:tourn_id, bracket_id:bracket_id},
				dataType: "html",
				success: function(msg){
					if(msg){ alert('Player added successfully!'); } else { alert('Something went wrong! Try again'); }
					$('#'+bracket_id).trigger('click');
					$('#div_add_player').hide();
					$('#add_player').prop("checked", false);
			   }
			});
		}
		else{
			alert("Select a Player!");
		}
	});
});
</script>
<input type='checkbox' name='add_player' id='add_player' />&nbsp;Do you want to add a player?
<div id='div_add_player'>
<select class='form-control col-md-6' style='width:20%;margin-right: 5px;' id='new_player' name='new_player'>
<option value=''>Player</option>
<?php
$reg_players = league::get_reg_tourn_player_names($get_bracket['Tourn_ID']); 
$count = 0;
foreach($reg_players as $i => $user){
	if(!in_array($user->Users_ID, $draw_exist_players)){
		$player_info = league::get_username($user->Users_ID);
		echo "<option value='{$user->Users_ID}'>".ucfirst($player_info['Firstname'])." ".ucfirst($player_info['Lastname'])."</option>";
		$count++;
	}
}

if($count == 0){
	echo "<option value=''>No Players are left!</option>";
}
?>
</select>&nbsp;
<select class='form-control col-md-6' style='width:20%;margin-right: 5px;' id='new_player_2' name='new_player_2'>
<option value=''>Player (Doubles)</option>
<?php
//$reg_players = league::get_reg_tourn_player_names($get_bracket['Tourn_ID']); 
$count = 0;
foreach($reg_players as $i => $user){
	if(!in_array($user->Users_ID, $draw_exist_players)){
		$player_info = league::get_username($user->Users_ID);
		echo "<option value='{$user->Users_ID}'>".ucfirst($player_info['Firstname'])." ".ucfirst($player_info['Lastname'])."</option>";
		$count++;
	}
}

if($count == 0){
	echo "<option value=''>No Players are left!</option>";
}
?>
</select>&nbsp;
<select class='form-control col-md-3' style='width:15%' id='new_player_level' name='new_player_level'>
<option value=''>Level</option>
<?php
for($i=1; $i<11; $i++){
echo "<option value='{$i}'>{$i}</option>";
}
?>
</select>
&nbsp;&nbsp;
<input class='league-form-submit1' type='button' name='add_new_player' id='add_new_player' value='Add Player' />
</div>
<?php
}
?>
</div>
<div>&nbsp;</div>
<div style='font-size: 16px;'><b>Note:</b> Player can challenge upto <?=$get_bracket['No_of_rounds'];?> Levels and challenge is valid for <?=$get_bracket['Ch_Duration'];?> days</div>

<script>
$(document).ready(function() {

$('#cl_draw').dataTable({"order": [[ 3, "desc" ]], dom: "<'row'<'col-sm-3'l><'col-sm-5'p><'col-sm-4'f>>" +
"<'row'<'col-sm-12'tr>>", searching: false, paging: false, lengthMenu: false, aoColumns: [  null,null,null,null  ], language: {"search":"", "searchPlaceholder":"Search"} });
});
//$('#cl_draw').dataTable().clear();
</script>