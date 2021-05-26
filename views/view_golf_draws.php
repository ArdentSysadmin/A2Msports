<script src="<?php echo base_url();?>js/jquery.accordion.js" type="text/javascript"></script>
<script src="http://code.jquery.com/jquery-1.9.1.js"></script>

<?php
$tourn_id		= $get_bracket['Tourn_ID'];
$golf_matches	= $golf_tourn_matches->result();
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
<p><b><?php echo $get_bracket['Draw_Title']; ?></b></p>
<div class="table-responsive">
<? //--------------------------------------------------------------------------------------------------------------- ?>

<script>
$(document).ready(function(){

var baseurl = "<?php echo base_url();?>";

$('.add_score_ajax').click(function (e) {

var id_val = $(this).attr('id');

//alert(id_val);

	  $.ajax({
		type: 'POST',
		url: baseurl+'league/view_matches',
		data: $('#form-addscore'+id_val).serialize(),
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
<?php if($get_bracket['Bracket_Type'] == 'drive_chip_putt'){ ?>
	<td align='center'>Drive</td>
	<td align='center'>Chip</td>
	<td align='center'>Putt</td>
<?php } else if($get_bracket['Bracket_Type'] == 'conventional'){ ?>
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
	<?php if($get_bracket['Bracket_Type'] == 'drive_chip_putt'){ ?>
	<td align='center'><?php echo $golf_matches[$m]->H1; ?></td>
	<td align='center'><?php echo $golf_matches[$m]->H2; ?></td>
	<td align='center'><?php echo $golf_matches[$m]->H3; ?></td>
	<?php } else if($get_bracket['Bracket_Type'] == 'conventional'){ ?>
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
	<td align='center'>
	<?php if($golf_matches[$m]->Total != NULL) { echo $golf_matches[$m]->Total; } else { echo "---"; }	?>
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