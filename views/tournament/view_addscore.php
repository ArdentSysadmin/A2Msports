<table class="tab-score">
<?php
$brackets = league::get_bracket_list($tour_details->tournament_ID);

if(count(array_filter($brackets)) > 0){  ?>
<!-- <tr class="top-scrore-table">
<th width="15%">Draw Title</th>
<th width="15%">Match Type</th>
<th width="15%">Age Group</th>
<th width="15%">Action</th> 
</tr> -->
<?php
$check_user = 1;
$is_no_draws = 0;
foreach($brackets as $bk)
{

if(($tour_details->Usersid != $users_id and $tour_details->Tournament_Director != $users_id) and $users_id){
	if($this->is_team_league){
	$check_user = league::check_team_is_user_exists($tour_details->tournament_ID, $bk->BracketID, $tour_details->SportsType);
	}
	else{
	$check_user = league::check_is_user_exists($tour_details->tournament_ID, $bk->BracketID, $tour_details->SportsType);
	}
}
//echo 'check_user '.$check_user; exit;

if($check_user and !$this->is_team_league){
?>
<tr id="tr_td_<?=$bk->BracketID;?>">
<form id="frm_mymatches" method="post">

<td>&nbsp;<b><?php echo $bk->Draw_Title; ?></b></td>
<td>&nbsp;<b><?php echo $bk->Bracket_Type; ?></b></td>
<td>
<input type="button" class="show_matches league-form-submit1" name="list_draw_matches<?=$bk->BracketID;?>" 
id='<?=$bk->BracketID;?>' value="Show Matches" />
</td>

<?php
if($this->is_super_admin or $this->logged_user_role == "Admin"){
	$check_draw_complete = league::is_draw_complete($bk->BracketID);

	if(!$check_draw_complete)
		echo "<td><span style='background-color:green; font-size:12px;'>Completed</span></td>";
	else
		echo "<td><span style='background-color:red; font-size:12px;'>Incomplete</span></td>";
}
?>

</form>
</tr>
<?php
$is_no_draws++;
}
else if($check_user and $this->is_team_league){
?>
<tr id="tr_td_<?=$bk->BracketID;?>">
<form id="frm_mymatches" method="post">

<td>&nbsp;<b><?php echo $bk->Draw_Title; ?></b></td>
<td>&nbsp;<b><?php echo $bk->Bracket_Type; ?></b></td>
<td>
<input type="button" class="show_team_matches league-form-submit1" name="list_team_draw_matches<?=$bk->BracketID;?>" 
id='<?=$bk->BracketID;?>' value="Show Matches" />
</td>

</form>
</tr>
<?php
}

}

if($is_no_draws == 0)
{
echo "<tr><td>You are not part of any Draws to Add Score!</td></tr>";
}
}
else
{
echo "<tr><td>No Draws are available</td></tr>";
}
?>
</table>

<div id="showMatches11">
<div id="showMatches">
<!-- Load Dynamic Matches here -->
</div>
</div>

<script>
$(document).ready(function(){
var club_baseurl = "<?php echo $club_url.'/'; ?>";

	$('.show_matches').click(function(){
	$bracket_id = $(this).attr('id');
	$('.tab-score tr').css('background-color','');
	$('#tr_td_'+$bracket_id).css('background-color','#81a32b');
	$('#'+$bracket_id).val('Please wait....');

	$.ajax({
		type:'POST',
		url:club_baseurl+'league/ShowMatches/'+$bracket_id,
		data:{bracket_id:$bracket_id,club_url:club_baseurl},
		success:function(res){
		 $('#'+$bracket_id).val('Show Matches');
		 $("#showMatches").html(res);
			$('html, body').animate({
			scrollTop: ($('#showMatches11').offset().top)
			},500);
		}
		});

	});


	$('.show_team_matches').click(function(){
	$bracket_id = $(this).attr('id');
	$('.tab-score tr').css('background-color','');
	$('#tr_td_'+$bracket_id).css('background-color','#81a32b');
	$('#'+$bracket_id).val('Please wait....');

	$.ajax({
		type:'POST',
		url:baseurl+'league/ShowTeamMatches/'+$bracket_id,
		data:{bracket_id:$bracket_id},
		success:function(res){
		 $('#'+$bracket_id).val('Show Matches');
		 $("#showMatches").html(res);
			$('html, body').animate({
			scrollTop: ($('#showMatches11').offset().top)
			},500);
		}
		});

	});

});
</script>