<div id='div_groups'>
<!-- <link href="<?php //echo base_url();?>css/fSelect.css" rel="stylesheet" type="text/css"> -->
<!-- <script src="<?php //echo base_url();?>js/jquery-1.10.2.js" type="text/javascript"></script> -->
<!-- <script src="https://code.jquery.com/jquery-1.10.2.min.js" type="text/javascript"></script> -->
<!-- <script src="<?php //echo base_url();?>js/fSelect.js" type="text/javascript"></script> -->
<section id="single_player" class="secondary-page" style="padding-top:40px;">
<div class="container">
<div class="row">

<div class="top-score-title right-score col-md-12">
<h3 style="text-align:left">Draw Groups</h3>
<form id='frm_draw_groups' name='frm_draw_groups' method='post' action='<?=$this->club_form_url;?>league/bracket/<?=$tourn_id;?>'>
<!-- start main body -->
<div class="col-md-12 league-form-bg" style="margin-top:10px;">
<div class="fromtitle">Group Users</div>
<input type="hidden" name="groups"		id="groups"    value='<?=serialize($groups);?>' />
<input type="hidden" name="num_grps"  id="num_grps"  value='<?=$num_grps;?>' />
<input type="hidden" name="br_game_day"  id="br_game_day"  value='<?=$br_game_day;?>' />
<input type="hidden" name="draw_format"  id="draw_format"  value='<?=$draw_format;?>' />
<input type="hidden" name="tformat"		id="tformat"   value='<?=$tformat;?>' />
<input type="hidden" name="brc_type"   id="brc_type"   value='<?=$brc_type;?>' />
<input type="hidden" name="sport"			id="sport"     value='<?=$sport;?>' />
<input type="hidden" name="tour_type" id="tour_type" value='<?=$tour_type;?>' />
<input type="hidden" name="num_of_sets"	id="num_of_sets"	  value='<?=$num_of_sets;?>' />
<input type="hidden" name="po_num_of_sets"	id="po_num_of_sets"	value='<?=$po_num_of_sets;?>' />
<input type="hidden" name="is_publish_draw"	id="is_publish_draw" value='<?=$is_publish_draw;?>' />
<input type="hidden" name="rr_multi_rounds"	id="rr_multi_rounds" value='<?=$rr_multi_rounds;?>' />
<input type="hidden" name="courts_new"			id="courts_new"		value='<?=serialize($courts_new);?>'	/>
<input type="hidden" name="match_timings"		id="match_timings"	value='<?=serialize($match_timings);?>' />
<input type="hidden" name="num_crts_grp"		id="num_crts_grp"	value='<?=serialize($num_crts_grp);?>' />

<input type='hidden' name='filter_events' value='<?php if($filter_events != '' and $filter_events != 'null') { echo $filter_events; } 
else if($sport_level != '' and $sport_level != 'null'){ echo $sport_level; } ?>' />

<input type="hidden" name="is_plof"		id="is_plof"		value='<?=$is_plof;?>' />
<input type="hidden" name="plof_size" id="plof_size"	value='<?=$plof_size;?>' />
<input type="hidden" name="plof_size_sel" id="plof_size_sel"	value='<?=$plof_size_sel;?>' />

<?php
foreach($groups as $i => $group){
?>
<div>
<div class='col-md-6' style='margin-top: 10px;'><h4>Group - <?=$i;?></h4></div>
<div class='col-md-6' align='right'><input class='form-control' style='width:60%;margin-top: 10px;margin-bottom: 5px;' type='text' name='add_user' id='add_user<?=$i;?>' placeholder='Add Player' value='' /><span id='pl_<?=$i;?>' align='left'></span><br /></div>
<?php if(in_array($i, $err_count)){
	echo "<span style='color:red;font-weight:bold;'>Minimum players should be 3</span>";
}

echo "<table id='tbl_{$i}' width='100%' class='imagetable' cellpadding='10' cellspacing = '2' align='center' border='1'>";
echo "<thead>";
echo "<tr class='top-scrore-table'>";

if($this->is_team_league){
echo "<th class=score-position'><b>Team</b></th>";
}
else{
echo "<th class=score-position'><b>Player</b></th>";
echo "<th class='score-position'><b>A2M Score</b></th>";
echo "<th class=score-position'><b>Club</b></th>";
echo "<th class='score-position'><b>City</b></th>";
echo "<th class='score-position'><b>State</b></th>";
}

echo "<th class='score-position'><b>Move To</b></th>";
echo "<th class='score-position'><b>Seed</b></th>";
echo "</tr>";
echo "</thead>";

// when player swap b/w group, need to place him based on the rating.
/*
$temp_plyrs = '';
foreach($group as $user){
		$players = explode('-', $user);
		$userInfo = league::getUserInfo($players[0], $sport);
		if($draw_format == 'doubles'){
			$user_a2m = ($sport != 7) ? $userInfo['A2MScore_Doubles'] : number_format($userInfo['A2MScore_Doubles'], 3);
		}
		else if($draw_format == 'mixed'){
			$user_a2m = ($sport != 7) ? $userInfo['A2MScore_Mixed'] : number_format($userInfo['A2MScore_Doubles'], 3);
		}
		else{
			$user_a2m = ($sport != 7) ? $userInfo['A2MScore'] : number_format($userInfo['A2MScore_Doubles'], 3);
		}
		$temp_plyrs[$user] = $user_a2m;
}

//krsort($temp_plyrs);
//$group = array_values($temp_plyrs);
arsort($temp_plyrs);	
$group = array_keys($temp_plyrs);
*/
// when player swap b/w group, need to place him based on the rating.



foreach($group as $user){

	if($this->is_team_league){
		$team_id = $user;
		$teamInfo = league::get_team($team_id);
		echo "<tr>
		<td>".$teamInfo['Team_name']."</td>";
	}
	else{
		$players = explode('-', $user);
		$userInfo = league::getUserInfo($players[0], $sport);

		$partner = '';
		if($players[1]){
			$partnerInfo1 = league::getUserInfo($players[1], $sport);
			$partner = " - ".$partnerInfo1['Firstname']." ".$partnerInfo1['Lastname'];
		}

		if($draw_format == 'doubles'){
			$user_a2m = ($sport != 7) ? $userInfo['A2MScore_Doubles'] : number_format($userInfo['A2MScore_Doubles'], 3);
		}
		else if($draw_format == 'mixed'){
			$user_a2m = ($sport != 7) ? $userInfo['A2MScore_Mixed'] : number_format($userInfo['A2MScore_Doubles'], 3);
		}
		else{
			$user_a2m = ($sport != 7) ? $userInfo['A2MScore'] : number_format($userInfo['A2MScore_Doubles'], 3);
		}

$del = "<a id='del_{$i}_{$user}' name=''del_{$i}_{$user}' class='remove_user' title='Remove User from this group'><i class='fa fa-times' aria-hidden='true' style='color:red;'></i></a>";

		echo "<tr>
		<td id='plyr_{$user}'>".$userInfo['Firstname']." ".$userInfo['Lastname'].$partner." {$del}</td>
		<td>".$user_a2m."</td>
		<td>".$userInfo['Clubname']."</td>
		<td>".$userInfo['City']."</td>
		<td>".$userInfo['State']."<input type='hidden' class='new_grp' name='new_grp[{$i}][]' value='{$user}' />"."</td>";
	}
	echo "<td id='td_{$user}'><select class='change_grp' id='{$user}'><option value=''>Select</option>";
	foreach($groups as $j => $group){
		if($j != $i)
		echo "<option value='{$j}'>Group - {$j}</option>";
	}
	echo "</select><span></span></td>";
	
	echo "<td><input type='hidden' id='seeded_".$j."' value='".$j."' ><img src='".base_url().'icons/up.png'."' class='up' style='cursor:pointer;width:20px;height:20px;' /><img src='".base_url().'icons/down.png'."' class='down' style='cursor:pointer;width:20px;height:20px;' /></td>";

	echo "</tr>";
}
echo "</table>";
?>
</div>
<script>	
$(document).ready(function(){	
	var gi = "<?php echo $i; ?>";	
	var tid = "<?php echo $tourn_id; ?>";	
	var club_baseurl	= "<?php if($this->config->item('club_form_url') != '') { echo base_url(); } else  { echo $this->config->item('proxy_url').'/';  } ?>";

	$("#add_user"+gi).autocomplete({
		//alert('test');
	source: function( request, response ) {	
  		$.ajax({	
			url: club_baseurl+'league/auto_reg_players',	
  			dataType: "json",	
			method: 'post',	
			data: {	
			   name_startsWith: request.term,	
			   tid: tid,	
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
		/*$('#tbl_'+gi).append($('<tr><td></td></tr>', { 	
			value: names[1],	
			text: names[0] 	
		}));*/	
		if(names[1]){	
			$('#pl_'+gi).html("<span style='color:blue'><b>Please wait ....</b></span>");	
			$('#tbl_'+gi+' tr:last').after('<tr><td><select class="add_newUser" id="'+names[1]+'" style="display:none;"><option value="">Select</option><option value="'+gi+'">Group - '+gi+'</option></select></td></tr>');	
			$('.add_newUser').val(gi).trigger('change');	
		}	
		//$('#ev_loc_id').val(names[1]);	
	}	      		
	});	
});	
</script>

<?php
}
?>
<script>
$(document).ready(function(){

//$(document).on("click", ".up, .down", function(){
$(".up, .down").click(function(){
	var row = $(this).parents("tr:first");
	if ($(this).is(".up")) {
		row.insertBefore(row.prev());
	}
	else {
		row.insertAfter(row.next());
	}
});

});
</script>

<br />
<br />
<br />
<?php
if(count($err_count) == 0){
?>
<div align='center'><input type='submit' class='league-form-submit1' name='groups_cont' id='groupds_cont' value='Continue' /></div>
<?php
}
?>
</div>
<!-- end main body -->
</form>

</div><!--Close Top Match-->
<div style='clear:both; margin-botton:15px;'></div>
</div>

</div>
</div>
</section>