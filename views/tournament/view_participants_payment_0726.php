<script>
$(document).ready(function(){

 $('#frm_participants').click(function() {
  var atLeastOneIsChecked = false;
  $('input:checkbox').each(function() {
    if ($(this).is(':checked')) {
      atLeastOneIsChecked = true;
      // Stop .each from processing any more items
      return false;
    }
  });
  if(atLeastOneIsChecked == false){
		alert('Select atlease one player to proceed!');
		e.preventDefault();
		return false;
  }
  // Do something with atLeastOneIsChecked
});
$(".change_level").click(function(){
 var tid=$(this).attr("id");
 var tidarr=tid.split('_');
 var player=tidarr['2'];
  $("#withdrawplayer_"+player).hide();
 //alert(player);
 var tourn_id=tidarr['3'];
    $.ajax({
      type: 'POST',
      url: baseurl+'league/GetUserLevels',
      data:{player:player,tourn_id:tourn_id},
      success: function(res) {
        //console.log(res);die();
       $("#partcipantlevels_"+player).show();
       $("#partcipant_levels_"+player).html(res);
      }
      });
});

$(".withdraw_player").click(function(){
  var tid=$(this).attr("id");
  var tidarr=tid.split('_');
  var player=tidarr['2'];
  $("#partcipantlevels_"+player).hide();
  var tourn_id=tidarr['3'];
  $.ajax({
      type: 'POST',
      url: baseurl+'league/GetUserLevelsExist',
      data:{player:player,tourn_id:tourn_id},
      success: function(res) {
        //alert(res);
        $("#withdrawplayer_"+player).show();
        $("#existing_events_"+player).html(res);
      }
      });
});

$(".cancel").click(function(){
  var tid=$(this).attr("id");
  var tidarr=tid.split('_');
  var player=tidarr['1'];
  $("#withdrawplayer_"+player).hide();
});


$(".sub-proceed").click(function(){
  $(this).val("Please wait...");
});

});

</script>

<style>
.multiselect {
width: 200px;
}
.selectBox {
position: relative;
}
.selectBox select {
width: 100%;
font-weight: bold;
}
.overSelect {
position: absolute;
left: 0; right: 0; top: 0; bottom: 0;
}

#checkboxes {
display: none;
border: 1px #dadada solid;
}
#checkboxes label {
display: block;
}
/*#checkboxes label:hover {
background-color: #1e90ff;
}*/
</style>

<script>
function showCheckboxes($uid){
var elements = document.getElementsByClassName('div_ag_sel')

for (var i = 0; i < elements.length; i++){
elements[i].style.display = "none";
}
var checkboxes = document.getElementById("checkboxes"+$uid);
checkboxes.style.display = "block";
}
</script>

<div class="col-md-12 league-form-bg" style="margin-top:15px; margin-bottom:0px;">
<?php $tourn_reg_names = league::get_reg_tourn_player_names($tour_details->tournament_ID); ?>

<div>
<table class="tab-score">
<tr>
<th width="35%">Name</th>
<th width="15%">Contact#</th>
<th width="20%">Amount Paid($)</th>
<th width="10%">Status</th>
<th width="25%">Date</th>
<?php if($tour_details->Is_Coupon){ ?>
<th width="20%">Coupon Code</th>
<?php } ?>
<th width="20%">Refunds</th>
</tr>

<?php
$check_cond = array('0.00','0','NULL','');
$total		  = 0;
$total_refund = 0;
if(count(array_filter($tourn_reg_names)) > 0){
foreach($tourn_reg_names as $name){
	$add_payments = league::get_paytransactions($tour_details->tournament_ID, $name->Users_ID);
	//echo "<pre>"; print_r($add_payments);

$gross		= number_format($name->Fee, 2);
$pp_charges = 0.00;
$per_pp		= 0.00;
$extra_paid = 0.00;

if($name->Gateway_Charges != NULL and $name->Gateway_Charges != ''){
$pp_charges = $name->Gateway_Charges;

$per_pp = $pp_charges / $gross;
}

$per_pp = $pp_charges / $gross;

	if(count($add_payments) > 0){
		$extra = 0;
		foreach($add_payments as $pay){
			$extra += $pay->Amount;
		}
		$extra_paid = $extra - ($extra * $per_pp);
	}
?>
<tr>
<td style="padding-left:10px">
<?php
$player = league::get_username($name->Users_ID);
echo "<a href='".base_url()."player/".$name->Users_ID."' target='_blank'>" . ucfirst($player['Firstname']) . " " . ucfirst($player['Lastname']) . "</a>";
?>
</td>

<td style="padding-left:10px"><?php echo $player['Mobilephone']; ?></td>

<td style="padding-left:10px">
<div>
<?php
$paid = ($gross - $pp_charges) + $extra_paid;

if($name->Status == 'Completed' or $name->Status == 'Paid'){
$total += $paid;
}
echo number_format($paid, 2);
?>
</div>
</td>
<td style="padding-left:10px">
<div>
<?php
echo $name->Status;
?>
</div>
</td>
<td style="padding-left:10px">
<div>
<?php
echo date('M d, Y H:i', strtotime($name->Reg_date));
?>
</div>
</td>

<?php if($tour_details->Is_Coupon){ ?>

<td style="padding-left:10px">
<div>
<?php
echo $name->Coupon_Applied;
?>
</div>
</td>
<?php } ?>

<td style="padding-left:10px; font-weight:400;">
<div>
<?php
$get_refunds = league::get_refund_trans($name->RegisterTournament_id);
$refund_amt = 0;
foreach($get_refunds as $refund){
	$refund_amt += $refund->Ref_Amt;
}
$total_refund += $refund_amt;
echo number_format($refund_amt, 2);
?>
</div>
</td>
</tr>
<?php
}
?>
<tr>
<td colspan='2' style="padding-right:10px" align='right'>Total Pay</td>
<td colspan='5' style="padding-left:10px">
<div><?=number_format($total, 2); ?></div>
</td>
</tr>
<tr>
<td colspan='2' style="padding-right:10px" align='right'>Refunds</td>
<td colspan='5' style="padding-left:10px">
<div><?echo " - "; echo number_format($total_refund, 2); ?></div>
</td>
</tr>
<tr>
<td colspan='2' style="padding-right:10px" align='right'>Net Pay</td>
<td colspan='5' style="padding-left:10px">
<div><? echo number_format(($total - $total_refund), 2); ?></div>
</td>
</tr>
<?php
}
else {
?>
<tr><td colspan='7'><b>No Players are Registered yet. </b></td></tr>
<?php
}
?>
</table>
</div>  

</div>
<input type='hidden' name='tourn_id' id="tourn_id" value="<?php echo $tour_details->tournament_ID; ?>">
<input type='hidden' name='tourn_type' value = "<?php echo $tour_details->Tournament_type; ?>">
<!-- </div>--></form>