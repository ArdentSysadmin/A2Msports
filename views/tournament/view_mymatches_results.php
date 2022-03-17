<script>
/*$('.show_matches').click(function(){
$bracket_id = $(this).attr('id');

$.ajax({
    type:'POST',
    url:baseurl+'league/ShowMatches/'+$bracket_id,
    data:{bracket_id:$bracket_id},
    success:function(res){
     
      $("#showMatches").html(res);
    }
    });

});*/
</script>
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
//echo "test ".$bk->is_Publish;
//exit;
if($bk->is_Publish){
if(($tour_details->Usersid != $this->logged_user) and $this->logged_user){
	if($this->is_team_league){
		$check_user = league::check_team_is_user_exists($tour_details->tournament_ID, $bk->BracketID, $tour_details->SportsType);
	}
	else{
		$check_user = league::check_is_user_exists($tour_details->tournament_ID, $bk->BracketID, $tour_details->SportsType);
	}
}

if($check_user){
?>
<tr id="tr_td_<?=$bk->BracketID;?>">
<form id="frm_mymatches" method="post">

<td>&nbsp;<b><?php echo $bk->Draw_Title; ?></b></td>
<td>&nbsp;<b><?php echo $bk->Bracket_Type; ?></b></td>
<td>&nbsp;<b><?php echo $bk->Bracket_Type; ?></b></td>

<td><?php
if($bk->OCCR_ID) {
	$ocr_info		= league :: get_occr_info($bk->OCCR_ID);
	$dis_date		= date('M d, h:i A', strtotime($ocr_info['Game_Date'])); 
	//$sort_date	= date('YmdHis', strtotime($ocr_info['Game_Date'])); 
	$sort_date	= strtotime($ocr_info['Game_Date']); 
}
else {
	$get_first_match = league::get_bracket_firstmatch($bk->BracketID);
	//echo ""; print_r($get_first_match); exit;
	if($get_first_match['Match_DueDate']) {
		$dis_date		= date('M d, h:i A', strtotime($get_first_match['Match_DueDate'])); 
		//$sort_date	= date('YmdHis', strtotime($get_first_match['Match_DueDate'])); 
		$sort_date 	= strtotime($get_first_match['Match_DueDate']); 
	}
	else {
		$dis_date		= date('M d, h:i A', strtotime($tour_details->StartDate)); 
		//$sort_date	= date('YmdHis', strtotime($tour_details->StartDate)); 
		$sort_date 	= strtotime($tour_details->StartDate); 
	}
}
?><span style='display:none;'><?=$sort_date;?></span><b><?=$dis_date;?></b></td>
<td>
<input type="button" class="show_matches league-form-submit1" name="list_draw_matches<?php echo $bk->BracketID;?>" 
id='<?php echo $bk->BracketID;?>' value="Show Matches" />
</td>

</form>
</tr>
<?php
$is_no_draws++;
}
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

	$('.show_matches').click(function(){
	$bracket_id = $(this).attr('id');
	$('.tab-score tr').css('background-color','');
	$('#tr_td_'+$bracket_id).css('background-color','#81a32b');
	$('#'+$bracket_id).val('Please wait....');

	$.ajax({
		type:'POST',
		url:club_baseurl+'league/ShowMatches/'+$bracket_id,
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