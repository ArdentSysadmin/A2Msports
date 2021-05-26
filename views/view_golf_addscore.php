<script src="<?php echo base_url();?>js/jquery.accordion.js" type="text/javascript"></script>
<script src="http://code.jquery.com/jquery-1.9.1.js"></script>
<style>
input[type=number]{
    width: 60px;
} 
</style>

<?php
$tourn_id		= $get_bracket_details['Tourn_ID'];
$golf_matches	= $golf_bracket_matches->result();
$sess_id		= $this->session->userdata('users_id');

$players = array();
foreach($golf_matches as $m => $match){
	if(!in_array($golf_matches[$m]->Player, $players)){
		$players[] = $golf_matches[$m]->Player;
	}
}
?>
<div class='tab-content' style="background:#fff">

<div class="top-score-title right-score">
<p><b><?php echo $get_bracket_details['Draw_Title']; ?></b></p>
<div class="table-responsive">
<? //--------------------------------------------------------------------------------------------------------------- ?>

<script>
$(document).ready(function(){

$(".add_score").click(function(){
var tid = $(this).attr('name');

if($("#show_score_"+tid).css('display')=='none'){
	$("#show_score_"+tid).show();
	$("#add_score_"+tid).hide();
}
else{
	$("#show_score_"+tid).hide();
	$("#add_score_"+tid).show();
}
});

$(".hide_score").click(function(){
var tid = $(this).attr('name');

if($("#show_score_"+tid).css('display')=='none'){
	$("#show_score_"+tid).show();
	$("#add_score_"+tid).hide();
}
else{
	$("#show_score_"+tid).hide();
	$("#add_score_"+tid).show();
}
});

});
</script>

<script>
$(document).ready(function(){

var baseurl = "<?php echo base_url();?>";

$('.add_score_ajax_web').click(function (e) {

	var id_val = $(this).attr('id');

	  $.ajax({
		type: 'POST',
		url: baseurl+'league/view_matches',
		data: $('#form-addscore-web'+id_val).serialize(),
		success: function () {
		  location.reload();
		}
	  });
	  e.preventDefault();
});

$('.add_score_ajax_mob').click(function (e) {

	var id_val = $(this).attr('id');

	  $.ajax({
		type: 'POST',
		url: baseurl+'league/view_matches',
		data: $('#form-addscore-mob'+id_val).serialize(),
		success: function () {
		  location.reload();
		}
	  });
	  e.preventDefault();
});

});
</script>

<table id='golf_score_table' class='tab-score' style="display:none;">
<?php
$match_num = 1;
if(!in_array($sess_id, $players) and $tour_details->Usersid != $sess_id)
{
?>
<tr></td><span style="color:red">No Matches found, as you are not a player in this draw!</span></td></tr>
<?php
}
else
{
?>
<tr class='top-scrore-table'>
	<td align='center'>S.No</td>
	<td style="padding-left:15px;">Player</td>
<?php if($get_bracket_details['Bracket_Type'] == 'drive_chip_putt'){ ?>
	<td align='center'>Drive</td>
	<td align='center'>Chip</td>
	<td align='center'>Putt</td>
<?php } else if($get_bracket_details['Bracket_Type'] == 'conventional'){ ?>
	<td align='center'>H-1</td>
	<td align='center'>H-2</td>
	<td align='center'>H-3</td>
	<td align='center'>H-4</td>
	<td align='center'>H-5</td>
	<td align='center'>H-6</td>
	<td align='center'>H-7</td>
	<td align='center'>H-8</td>
	<td align='center'>H-9</td>
<?php } ?>
	<td align='center'>Total</td>
</tr>

<?php
$sno = 1;
foreach($golf_matches as $m => $gm){   // Main for loop

	$logged_user_matches_count = 0;
	$round_matches = 0;

	if($golf_matches[$m]->Player > 0){
	$player_det = league::get_username(intval($golf_matches[$m]->Player));
	}
	else{
	$player_det['Firstname'] = "Par";
	$player_det['Lastname']  = "Value";
	}

	$tm_id = $golf_matches[$m]->Tourn_match_id;
?>

<tr id="show_score_<?=$tm_id; ?>" <?php if($golf_matches[$m]->Player < 0){ echo "class = 'top_row'"; } ?>>
	<td align='center'><?php if($golf_matches[$m]->Player > 0){ echo $sno; } ?></td>
	<td style="padding-left:15px;">
	<?php if($golf_matches[$m]->Player > 0){ ?>
		<a href="<?php echo base_url();?>player/<?php echo $player_det['Users_ID'];?>" title="<?php echo $player_det['Mobilephone'];?>">
		<?php echo ucfirst($player_det['Firstname'])." ".ucfirst($player_det['Lastname'])."</a>"; ?>
	<?php } else {?>
		<?php echo "<h5><b>".ucfirst($player_det['Firstname'])." ".ucfirst($player_det['Lastname'])."</b></h5>"; ?>
	<?php } ?>
	</td>
	<?php if($get_bracket_details['Bracket_Type'] == 'drive_chip_putt'){ $colspan = 6;?>
	<td align='center'><?php echo $golf_matches[$m]->H1; ?></td>
	<td align='center'><?php echo $golf_matches[$m]->H2; ?></td>
	<td align='center'><?php echo $golf_matches[$m]->H3; ?></td>
	<?php } else if($get_bracket_details['Bracket_Type'] == 'conventional'){ $colspan = 12;?>
	<td align='center'><?php echo $golf_matches[$m]->H1; ?></td>
	<td align='center'><?php echo $golf_matches[$m]->H2; ?></td>
	<td align='center'><?php echo $golf_matches[$m]->H3; ?></td>
	<td align='center'><?php echo $golf_matches[$m]->H4; ?></td>
	<td align='center'><?php echo $golf_matches[$m]->H5; ?></td>
	<td align='center'><?php echo $golf_matches[$m]->H6; ?></td>
	<td align='center'><?php echo $golf_matches[$m]->H7; ?></td>
	<td align='center'><?php echo $golf_matches[$m]->H8; ?></td>
	<td align='center'><?php echo $golf_matches[$m]->H9; ?></td>
	<?php } ?>
	<td align='center'><?php if($golf_matches[$m]->Total != NULL) { echo $golf_matches[$m]->Total; } else { echo "---"; }
	if($sess_id == $tour_details->Usersid or $sess_id == $golf_matches[$m]->Player){ 
		if($golf_matches[$m]->Total == NULL) {
		echo "&nbsp;&nbsp;&nbsp;<a class='add_score' id='$tm_id' name='$tm_id' href='#r'>Add</a>";
		} else {
		echo "&nbsp;&nbsp;&nbsp;<a class='add_score' id='$tm_id' name='$tm_id' href='#r'>Edit</a>";
		}
	}
	?>
	</td>
</tr>

<tr id="add_score_<?=$tm_id; ?>" style="display:none;" <?php if($golf_matches[$m]->Player < 0){ echo "class = 'top_row'"; } ?>>
<td colspan='<?=$colspan; ?>'>
<!-- -------------------- Web View ----------------------------- -->
<div class='scoretable-web'>
<form name="form-addscore-web<?=$tm_id; ?>" id="form-addscore-web<?=$tm_id; ?>">

<table class='tab-score'>
<tr>
	<td align='center' style='width:133px;'><?php if($golf_matches[$m]->Player > 0){ echo $sno; } ?></td>
	<td style="padding-left:15px; width:387px;">
	<?php if($golf_matches[$m]->Player > 0){ ?>
		<a href="<?php echo base_url();?>player/<?php echo $player_det['Users_ID'];?>" title="<?php echo $player_det['Mobilephone'];?>">
		<?php echo ucfirst($player_det['Firstname'])." ".ucfirst($player_det['Lastname'])."</a>"; ?>
	<?php } else {?>
		<?php echo "<h5><b>".ucfirst($player_det['Firstname'])." ".ucfirst($player_det['Lastname'])."</b></h5>"; ?>
	<?php } ?>
	</td>
<?php if($get_bracket_details['Bracket_Type'] == 'drive_chip_putt'){ ?>
	<td align='center' style='width:152px;'><input type='number' min='0' name='drive' id='drive' value='<?php echo $golf_matches[$m]->H1; ?>' /></td>
	<td align='center' style='width:140px;'><input type='number' min='0' name='chip'  id='chip'  value='<?php echo $golf_matches[$m]->H2; ?>' /></td>
	<td align='center' style='width:133px;'><input type='number' min='0' name='putt'  id='putt'  value='<?php echo $golf_matches[$m]->H3; ?>' /></td>
<?php } else if($get_bracket_details['Bracket_Type'] == 'conventional'){ ?>
	<td align='center'><input type='number' min='0' name='h1'	id='h1' value='<?php echo $golf_matches[$m]->H1; ?>' /></td>
	<td align='center'><input type='number' min='0' name='h2' id='h2' value='<?php echo $golf_matches[$m]->H2; ?>' /></td>
	<td align='center'><input type='number' min='0' name='h3' id='h3' value='<?php echo $golf_matches[$m]->H3; ?>' /></td>
	<td align='center'><input type='number' min='0' name='h4' id='h4' value='<?php echo $golf_matches[$m]->H4; ?>' /></td>
	<td align='center'><input type='number' min='0' name='h5' id='h5' value='<?php echo $golf_matches[$m]->H5; ?>' /></td>
	<td align='center'><input type='number' min='0' name='h6' id='h6' value='<?php echo $golf_matches[$m]->H6; ?>' /></td>
	<td align='center'><input type='number' min='0' name='h7' id='h7' value='<?php echo $golf_matches[$m]->H7; ?>' /></td>
	<td align='center'><input type='number' min='0' name='h8' id='h8' value='<?php echo $golf_matches[$m]->H8; ?>' /></td>
	<td align='center'><input type='number' min='0' name='h9' id='h9' value='<?php echo $golf_matches[$m]->H9; ?>' /></td>
<?php } ?>

	<input class='form-control' value="GOLF_ADDSCORE" name="score_type" type='hidden' /> 
	<input class='form-control' value="<?php echo $golf_matches[$m]->Player;?>" id="player" name="player" type='hidden' />
	<input class='form-control' value="<?php echo $get_bracket_details['Bracket_Type'];?>" id="bracket_type" name="bracket_type" type='hidden' />

	<input class='form-control' value="<?php echo $golf_matches[$m]->Tourn_ID;?>" id="tourn_id" name="tourn_id" type='hidden' />
	<input class='form-control' value="<?php echo $golf_matches[$m]->BracketID;?>" id="bracket_id" name="bracket_id" type='hidden' />
	<input class='form-control' value="<?php echo $golf_matches[$m]->Match_Num;?>" id="match_num" name="match_num" type='hidden' />
	<input class='form-control' value="<?php echo $golf_matches[$m]->Tourn_match_id;?>" id="tourn_match_id" name="tourn_match_id" type='hidden' />

	<td align='center'>
	<?php if($golf_matches[$m]->Total == NULL) { ?>
	<input type="submit" name="btn_add_score" id="<?=$tm_id; ?>" value="Add" class="league-form-submit1 add_score_ajax_web" />&nbsp; 
	<?php } else {?>
	<input type="submit" name="btn_add_score" id="<?=$tm_id; ?>" value="Update" class="league-form-submit1 add_score_ajax_web" />&nbsp; 
	<?php } ?>
	<a class='hide_score' id='cancel_<?=$tm_id;?>' name='<?=$tm_id;?>' href='#add'>Cancel</a></td>
</tr>
</table>
</form>
</div>
<!-- -------------------- End of Web View ----------------------------- -->

 <!-- ---------------Mobile view------------------------------------------------------- -->
<div class="scoretable-mob">
<form name="form-addscore-mob<?=$tm_id; ?>" id="form-addscore-mob<?=$tm_id; ?>">

	<table class="score-cont">
	<tr>
		<th>Players</th>
		<th bgcolor="#fdd7b0"><b>
			<?php if($golf_matches[$m]->Player > 0){ ?>
			<a href="<?php echo base_url();?>player/<?php echo $player_det['Users_ID'];?>" title="<?php echo $player_det['Mobilephone'];?>">
			<?php echo ucfirst($player_det['Firstname'])." ".ucfirst($player_det['Lastname'])."</a>"; ?>
			<?php } else {?>
			<?php echo "<h5><b>".ucfirst($player_det['Firstname'])." ".ucfirst($player_det['Lastname'])."</b></h5>"; ?>
			<?php } ?>
		</b></th>
   </tr>

<?php if($get_bracket_details['Bracket_Type'] == 'drive_chip_putt'){ ?>
	<tr>
		<td><?php echo "Drive"; ?></td>
		<td><input type='number' min='0' name='drive' id='drive' value='<?php echo $golf_matches[$m]->H1; ?>' /></td>
	</tr>
	<tr>
		<td><?php echo "Chip"; ?></td>
		<td><input type='number' min='0' name='chip'  id='chip'  value='<?php echo $golf_matches[$m]->H2; ?>' /></td>
	</tr>
	<tr>
		<td><?php echo "Putt"; ?></td>
		<td><input type='number' min='0' name='putt'  id='putt'  value='<?php echo $golf_matches[$m]->H3; ?>' /></td>
	</tr>

<?php } else if($get_bracket_details['Bracket_Type'] == 'conventional'){ ?>

	<tr>
		<td><?php echo "H1"; ?></td>
		<td><input type='number' min='0' name='h1' id='h1' value='<?php echo $golf_matches[$m]->H1; ?>' /></td>
	</tr>
	<tr>
		<td><?php echo "H2"; ?></td>
		<td><input type='number' min='0' name='h2' id='h2' value='<?php echo $golf_matches[$m]->H2; ?>' /></td>
	</tr>
	<tr>
		<td><?php echo "H3"; ?></td>
		<td><input type='number' min='0' name='h3' id='h3' value='<?php echo $golf_matches[$m]->H3; ?>' /></td>
	</tr>
	<tr>
		<td><?php echo "H4"; ?></td>
		<td><input type='number' min='0' name='h4' id='h4' value='<?php echo $golf_matches[$m]->H4; ?>' /></td>
	</tr>
	<tr>
		<td><?php echo "H5"; ?></td>
		<td><input type='number' min='0' name='h5' id='h5' value='<?php echo $golf_matches[$m]->H5; ?>' /></td>
	</tr>
	<tr>
		<td><?php echo "H6"; ?></td>
		<td><input type='number' min='0' name='h6' id='h6' value='<?php echo $golf_matches[$m]->H6; ?>' /></td>
	</tr>
	<tr>
		<td><?php echo "H7"; ?></td>
		<td><input type='number' min='0' name='h7' id='h7' value='<?php echo $golf_matches[$m]->H7; ?>' /></td>
	</tr>
	<tr>
		<td><?php echo "H8"; ?></td>
		<td><input type='number' min='0' name='h8' id='h8' value='<?php echo $golf_matches[$m]->H8; ?>' /></td>
	</tr>
	<tr>
		<td><?php echo "H9"; ?></td>
		<td><input type='number' min='0' name='h9' id='h9' value='<?php echo $golf_matches[$m]->H9; ?>' /></td>
	</tr>

<?php } ?>

	<input class='form-control' value="GOLF_ADDSCORE" name="score_type" type='hidden' /> 
	<input class='form-control' value="<?php echo $golf_matches[$m]->Player;?>" id="player" name="player" type='hidden' />
	<input class='form-control' value="<?php echo $get_bracket_details['Bracket_Type'];?>" id="bracket_type" name="bracket_type" type='hidden' />

	<input class='form-control' value="<?php echo $golf_matches[$m]->Tourn_ID;?>" id="tourn_id" name="tourn_id" type='hidden' />
	<input class='form-control' value="<?php echo $golf_matches[$m]->BracketID;?>" id="bracket_id" name="bracket_id" type='hidden' />
	<input class='form-control' value="<?php echo $golf_matches[$m]->Match_Num;?>" id="match_num" name="match_num" type='hidden' />
	<input class='form-control' value="<?php echo $golf_matches[$m]->Tourn_match_id;?>" id="tourn_match_id" name="tourn_match_id" type='hidden' />

	<tr>
	<td>
	<?php if($golf_matches[$m]->Total == NULL) { ?>
	<input type="submit" name="btn_add_score" id="<?=$tm_id; ?>" value="Add" class="league-form-submit1 add_score_ajax_mob" />&nbsp; 
	<?php } else {?>
	<input type="submit" name="btn_add_score" id="<?=$tm_id; ?>" value="Update" class="league-form-submit1 add_score_ajax_mob" />&nbsp; 
	<?php } ?>
	</td>
	<td><a class='hide_score' id='cancel_<?=$tm_id;?>' name='<?=$tm_id;?>' href='#add'>Cancel</a></td>
	</tr>
</table>
</form>
</div>

<!-- ------------------------------------------------------- Mobile view ------------------------------------------------------------- -->

</td>
</tr>

<?php
if($golf_matches[$m]->Player > 0){ $sno++; }
} // End of Main For loop

}
?>
</table>

</div>

<script>
$(document).ready(function(){
    //$('.top_row').prependTo("#golf_score_table");
	$tr = $('.top_row');
	$('#golf_score_table tr:first').after($tr);
	$("#golf_score_table").show();
});
</script>

<!-- Player standing points section start -->


<!-- End of Player Standing points section -->