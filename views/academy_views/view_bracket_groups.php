<div id='div_groups'>
<!-- <link href="<?php //echo base_url();?>css/fSelect.css" rel="stylesheet" type="text/css"> -->
<!-- <script src="<?php //echo base_url();?>js/jquery-1.10.2.js" type="text/javascript"></script> -->
<!-- <script src="https://code.jquery.com/jquery-1.10.2.min.js" type="text/javascript"></script> -->
<!-- <script src="<?php //echo base_url();?>js/fSelect.js" type="text/javascript"></script> -->
<script>
$(document).ready(function(){
var baseurl  = "<?php echo base_url();?>";
var tourn_id = "<?php echo $tourn_id;?>";
 $('.change_grp').change(function() {
	var target_group = $(this).val();
	var groups		 = $('#groups').val();
	var tformat		 = $('#tformat').val();
	var brc_type		 = $('#brc_type').val();
	var sport		 = $('#sport').val();
	var rr_multi_rounds = $('#rr_multi_rounds').val();
	var user		 = $(this).attr('id');
	$('#td_'+user).html("<span style='color:blue'><b>Please wait......</b></span>");
	setTimeout( function(){ 
		 $.ajax({
			type: "POST",
			async:false,
			url:baseurl+'league/swap_group_players/',
			data:{user:user,sport:sport,groups:groups,tourn_id:tourn_id,brc_type:brc_type,tformat:tformat,target_group:target_group,rr_multi_rounds:rr_multi_rounds},
			dataType: "html",
			success: function(res){
				$('#div_groups').html(res);
		    }
		});
	 }  , 1000 );
	});

});
</script>
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
<input type="hidden" name="is_publish_draw"	id="is_publish_draw" value='<?=$is_publish_draw;?>' />
<input type="hidden" name="rr_multi_rounds"	id="rr_multi_rounds" value='<?=$rr_multi_rounds;?>' />
<input type="hidden" name="courts_new"			id="courts_new"		 value='<?=serialize($courts_new);?>'		 />
<input type="hidden" name="match_timings"		id="match_timings" value='<?=serialize($match_timings);?>' />
<?php
foreach($groups as $i => $group){
?>
<div>
<h4>Group - <?=$i;?></h4>
<?php if(in_array($i, $err_count)){
	echo "<span style='color:red;font-weight:bold;'>Minimum players should be 3</span>";
}

echo "<table width='100%' class='imagetable' cellpadding='10' cellspacing = '2' align='center' border='1'>";
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
echo "</tr>";
echo "</thead>";

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

		echo "<tr>
		<td>".$userInfo['Firstname']." ".$userInfo['Lastname'].$partner."</td>
		<td>".$user_a2m."</td>
		<td>".$userInfo['Clubname']."</td>
		<td>".$userInfo['City']."</td>
		<td>".$userInfo['State']."</td>";
	}
	echo "<td id='td_{$user}'><select class='change_grp' id='{$user}'><option value=''>Select</option>";
	foreach($groups as $j => $group){
		if($j != $i)
		echo "<option value='{$j}'>Group - {$j}</option>";
	}
	echo "</select><span></span></td></tr>";
}
echo "</table>";
?>
</div>
<?php
}
?>
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