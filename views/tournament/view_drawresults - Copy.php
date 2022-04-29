<script>
$('#delete').click(function(e){
var bracket_ids=[];
var tourn_id=$("#tourn_id").val();
var tourn_format=$("#tourn_format").val();
var count=$('input:checkbox.delete_draws:checked').length;
    if(count==0){
       alert("Please select draws to delete!"); 
       return false;
    }
    $('input[name="tour_draws_delete"]:checked').each(function() {
     bracket_ids.push(this.value);
    });

var r = confirm("Once draws are deleted, can't revert back. Are you sure to delete?");

if(r == false){
e.preventDefault();
return false;	
}
else{
	/* Here Delete Draws code starts*/
	$.ajax({
		type:'POST',
		url:baseurl+'league/delete_draws/',
		data:{ tourn_id:tourn_id,tourn_format:tourn_format,bracket_ids:bracket_ids},
		success:function(res){
	     location.reload();
		}
	});
	/* Here Delete Draws code End*/
//return true;
}
});
$('#scorecard').click(function(e){
var bracket_ids=[];
var tourn_id=$("#tourn_id").val();
var tourn_format=$("#tourn_format").val();
var count=$('input:checkbox.delete_draws:checked').length;
    if(count==0){
       alert("Please select draws to Print!"); 
       return false;
    }
    $('input[name="tour_draws_delete"]:checked').each(function() {
     bracket_ids.push(this.value);
    });

	/* Here Delete Draws code starts*/
	$.ajax({
		type:'POST',
		url:baseurl+'league/scorecard4/',
		data:{ tourn_id:tourn_id,tourn_format:tourn_format,bracket_ids:bracket_ids},
		success:function(res){
	    // location.reload();
		var w = window.open('about:blank');
		w.document.open();
		w.document.write(res);
		w.document.close();
		}
	});
	/* Here Delete Draws code End*/
//return true;
});
</script>
<div id='vdrawres' class="table-responsive">
<?php
if($this->logged_user_role == 'Admin'){    /// tournament admin access links
?>
<a href="<?php echo base_url();?>league/fixtures/<?php echo $tour_details->tournament_ID;?>"  style='cursor:pointer;' >
<img width="45px" height="45px" src="<?php echo base_url();?>icons/create_draw_ico.png" alt="Create" title="Create Draw" style="float:right"/>
</a>
<?php
}?>
<table class="tab-score">
<?php 
$brackets = league::get_bracket_list($tour_details->tournament_ID);

if(count(array_filter($brackets)) > 0){ 
foreach($brackets as $bk){
?>
<tr id="tr_<?=$bk->BracketID;?>">
<?php
$users_id = $this->session->userdata('users_id');
if($this->logged_user_role == 'Admin'){   /// tournament admin access links
	echo '<td><input type="checkbox" name="tour_draws_delete" id="delete_draws_'.$bk->BracketID.'" class="delete_draws" value="'.$bk->BracketID.'" /></td>';
}
?>
<td colspan='2'><b><?php echo $bk->Draw_Title; ?></b></td>
<td><b><?php echo $bk->Bracket_Type; ?></b></td>
<td>
<input type="button" class="show_draws league-form-submit1" name="tour_draw_show<?php echo $bk->BracketID;?>" id='<?php echo $bk->BracketID;?>' value="Show Draw" />
&nbsp;&nbsp;
<?php if($is_super_admin or $this->logged_user_role == "Admin") { 
if($bk->Bracket_Type == "Round Robin" or $bk->Bracket_Type == "Switch Doubles") { ?>
<input type="button" name="ScoreSheet_<?=$bk->BracketID;?>" id="<?=$bk->BracketID;?>" class="league-form-submit1 br_scoreSheet" value="ScoreSheet">
<?php }else{ ?>
<input type="button" style="display:none" name="ScoreSheet_<?=$bk->BracketID;?>" id="<?=$bk->BracketID;?>" class="league-form-submit1 br_scoreSheet" value="ScoreSheet">
<?php } ?>

</td>
</tr>
<?php
}
}
}
else{
echo "<tr><td>No Draws are available</td></tr>";
}
?>
</table>

<?php
echo "<br>";
if(count(array_filter($brackets)) > 0){  
	if($this->logged_user_role == 'Admin'){   /// tournament admin access links
		echo '<input type="button" name="tour_draws_delete_button" id="delete" class="league-form-submit1" value="Delete Draws">';
		if($tour_details->tournament_format == 'Individual'){
		echo '&nbsp;&nbsp;<input type="button" name="tour_draws_score_card" id="scorecard" class="league-form-submit1" value="Print ScoreCard">';
		}
		echo '<input type="hidden" name="tourn_format" id="tourn_format" value="'.$tour_details->tournament_format.'">';
	}
}
?>
</div>
<!-- <div id="show_vdrawres" style='display:none; text-align:right'>
<?php //echo '<input type="button" name="vdrawres" id="vdrawres" class="league-form-submit1 close_div" value="Close">'; ?>
</div> -->
<div id="showdraw"></div>
<script>
$('.show_draws').click(function(){

$bracket_id = $(this).attr('id');
var tourn_format = "<?php echo $tour_details->tournament_format;?>"; 

$('.tab-score tr').css('background-color','');
$('#tr_'+$bracket_id).css('background-color','#81a32b');
$('#'+$bracket_id).val('Please wait....');

	$.ajax({
	type:'POST',
	url:baseurl+'league/ShowBracket/'+$bracket_id,
	data:{bracket_id:$bracket_id,tformat:tourn_format},
	success:function(res){
		$('#'+$bracket_id).val('Show Draw');
		$("#showdraw").html(res);

			$('html, body').animate({
			scrollTop: ($('#showdraw').offset().top)
			},500);
	}
	});
});
</script>

<?php
$sport_det = league::get_sport($tour_details->SportsType);

if($sport_det['SportFormat'] != "TeamSport"){
?>
<script>

function load_cl_standings(){
	var tourn_id = $("#tourn_id").val();
	$("#show_cl_standings").html("Please wait, standings are loading/refreshing ......");

	$.ajax({
		type:'POST',
		url:baseurl+'league/get_cl_standings/'+tourn_id,
		success:function(res){
			$("#show_cl_standings").html(res);

				/*$('html, body').animate({
				scrollTop: ($('#showdraw').offset().top)
				},500);*/
		}
	});
}

load_cl_standings(); 
/*setInterval(function(){
    load_cl_standings() 
}, 30000);*/

</script>
<br /><br />
<div id="show_cl_standings"></div>
<?php
}?>

<script>
$(document).ready(function(){
	$('.br_scoreSheet').click(function(){
		var value = $(this).attr('id');
		var bracket_ids = value;
		var tourn_id=$("#tourn_id").val();
		var tourn_id=$("#tourn_id").val();
		var tourn_format=$("#tourn_format").val();

			$.ajax({
				type:'POST',
				url:baseurl+'league/printScoreSheet/',
				data:{tourn_id:tourn_id,tourn_format:tourn_format,bracket_ids:bracket_ids},
				success:function(res){
				var w = window.open('about:blank');
				w.document.open();
				w.document.write(res);
				w.document.close();
				}
			});
	});
});
</script>