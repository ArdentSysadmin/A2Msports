<script>
$(document).ready(function(){

/*$('.cal_rf_type').blur(function(){
$rev_amt = $(this).val();
$(this).val( $rev_amt.toFixed(2) );
$rev_amt = $(this).val();

$id		 = $(this).attr('id');
$a		 = $id.split('_');
$org_amt = $('#amtp'+$a[2]).val();  
});*/

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
		alert('Select atleast one player to proceed!');
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

/*
$(".proceed").click(function(){
  var tid=$(this).attr("id");
  var tidarr=tid.split('_');
  var player=tidarr['1'];
  var tourn_id=tidarr['2'];
  var cnt=$("#checkbox_cnt_"+player).val();
  var tourn_id=$("#tourn_id").val();
  var singles = [];
  var doubles = [];
  var mixed = [];
 var total=$('input[name="match_type_'+player+'[]"]:checked').length;
  $("input:checkbox.singles_matchtype_"+player+":checked").each(function () {
     var match_type = this.value; 
       singles.push(match_type);
  });
  $("input:checkbox.doubles_matchtype_"+player+":checked").each(function () {
     var match_type = this.value; 
       doubles.push(match_type);
  });
  $("input:checkbox.mixed_matchtype_"+player+":checked").each(function () {
     var match_type = this.value; 
       mixed.push(match_type);
  });

     if(total==0){
      
      }else{
        $.ajax({
        type:'POST',
        url:baseurl+'league/UpdateLevels/',
        data:{singles:singles,doubles:doubles,mixed:mixed,tourn_id:tourn_id,player:player},
        success:function(html){
            if(html==true){ 
               alert("Updated Successfully!");
               location.reload();
              // $("#partcipantlevels_"+player).hide();
              // $("#partcipant_levels_"+player).html('');
            }
        }
      });

     }
  //window.location.href=baseurl+"league/ViewPayPalRefund/"+player+"/"+tourn_id;
  
});
*/

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

<div class='col-md-12'>
<?php $tourn_reg_names = league::get_reg_tourn_player_names($tour_details->tournament_ID);
//echo $this->db->last_query(); exit;
//echo "<pre>";print_r($tourn_reg_names);?>

<!-- <h4>Registered Players (<?php echo count($tourn_reg_names); ?>) [WithDraw Players]</h4> -->
<div id="load-users" style="overflow-y: scroll;" class="tab-content table-responsive">
<table class="tab-score">
<tr class="top-scrore-table">
<!-- <td width="6%" class="score-position"><input type='checkbox' name="sel_all" id="sel_all"/></td> -->
<td width="35%">Name</td>
<td width="15%">Contact#</td>
<?php if($get_sport['Sportname'] != 'Golf'){?>
<!-- <td width="20%">Match Format</td> -->
<td width="20%">Registered Evnets</td>
<?php
}?>
<td width="10%" valign='middle'>Edit Event</td>
<td width="10%" valign='middle'>Withdraw Player</td>
</tr>

<?php
$check_cond = array('0.00','0','NULL','');
if(count(array_filter($tourn_reg_names)) > 0){
foreach($tourn_reg_names as $name){
?>
<tr>

<!--<td>
<input type="checkbox" name="sel_player[]" class="checkbox1" class="withdraw_user"  style="margin-left:10px" value="<?php echo $name->Users_ID;?>"/>
<input type="hidden" style="margin-left:10px"  name="rtid<?php echo $name->Users_ID;?>"  value="<?php echo $name->Users_ID;?>"/> 
</td>-->

<td style="padding-left:10px">
<?php
//$player = league::get_username($name->Users_ID);
echo "<b>" . ucfirst($name->Firstname) . " " . ucfirst($name->Lastname) . "</b>";
?>
</td>

<td style="padding-left:10px">
<?php
if(isset($name->Mobilephone)){ 
	$phone = preg_replace("/^(\d{3})(\d{3})(\d{4})$/", "($1) $2-$3", $name->Mobilephone);
	echo $phone; 
}
?>
</td>

<?php if($get_sport['Sportname'] != 'Golf'){?>
<td style="padding:3px;">
<div id='match_format<?php echo $name->Users_ID;?>'>
<?php
$match_array = array();
if($name->Reg_Events != ""){
//$match_array = json_decode($name->Match_Type);
$reg_events_array1 = json_decode($name->Reg_Events, true);
$numItems		  = count($reg_events_array1);

 $reg_events_array = league::regenerate_events($reg_events_array1);
/*echo "<pre>";
print_r($reg_events_array1);*/

	if($numItems > 0){
		foreach($reg_events_array as $i => $group){
		/*$exp   = explode('-', $group);
		$level = end($exp); 
		$level_name = league::get_level_name('', $level);
		echo str_replace($level, $level_name['SportsLevel'], $group);*/
		echo $group;
			if(++$i != count($reg_events_array)){
			echo "<br /> ";
			}
		}
	}
}
?>
</div>
</td>
<?php
}
?>
<td>
<input type="button" value="Edit Event" style="margin-bottom:0px;padding:5px 14px;" class="change_level league-form-submit" id="chage_level_<?=$name->Users_ID;?>_<?=$name->Tournament_ID;?>" >
</td>
 <td>
 <input type="button"  style="margin-bottom:0px;padding:5px 14px;" id="withdraw_player_<?=$name->Users_ID;?>_<?=$name->Tournament_ID;?>" value="Withdraw" class="withdraw_player league-form-submit">
</td>
</tr>


<!-- WithDraw Form -->
<tr style="display:none;" id="withdrawplayer_<?=$name->Users_ID;?>">
<td colspan='5'>
<form name='frm_<?=$name->Users_ID;?>' method = 'POST' action = '<?=base_url();?>Payments_pro/Refund_transaction'>
<table class="tab-score">
<tr>
  <td id="existing_events_<?=$name->Users_ID;?>">
  <!-- Loads Dynamic Content of Players selected Formats -->
  </td>
  <td>
    <label>Amount Paid:</label> $<?=number_format($name->Fee, 2);?>&nbsp;
	<?php if($name->Transaction_id){ echo "(Trans#: $name->Transaction_id)"; } else { echo "(Trans#: Not Available)"; } ?>
	<input type="hidden" name="amtp" id="amtp<?=$name->Users_ID;?>"	value="<?=number_format($name->Fee, 2);?>" />
	<br />
	<?php
	if(!in_array($name->Fee, $check_cond) and ($name->Transaction_id != '' and $name->Transaction_id != 'NULL')){ ?>
    <label>Refund: $</label>
	<input class='cal_rf_type' type="text" style="width:15%" name="refund_amnt" id="refund_amnt_<?=$name->Users_ID;?>" value="" /><br />
	<?php } else {?>
		<label>Refund: $0.00</label><br />
	<?php } ?>
	<br />
	<?php
	/*
	$get_more_trans = league::get_more_trans($name->Users_ID, $name->Tournament_ID);
	if(count($get_more_trans) > 0){
		foreach($get_more_trans as $i => $pr){
			echo "<label>Amount Paid: $".number_format($pr->Amount, 2)."&nbsp;</label>";
			if($pr->Transaction_id){ echo "(Trans#: $pr->Transaction_id)"; } else { echo "(Trans#: Not Available)"; }
			echo "<br />";
			echo "<label>Refund: $</label>";
			echo "<input class='cal_rf_type' type='text' style='width:15%' name='refund_amnt111' id='refund_amnt_<?=$name->Users_ID;?>' /><br />";
		}
	}
	*/

	$prev_refunds = league::get_prev_refunds($name->RegisterTournament_id);
	if(count($prev_refunds) > 0){
		echo "<label>Previous Refunds:</label><br />";
		foreach($prev_refunds as $i => $pr){
			echo "$ {$pr->Ref_Amt} - {$pr->Ref_TxnID} - {$pr->Ref_Type} Refund <br>";
		}
	}
	?>
<input name="red_uri" type="hidden" value="<?=$this->config->item('club_pr_url');?>" />
	<input type="hidden" name="trans_id"	 id="trans_id<?=$name->Users_ID;?>"		value="<?=$name->Transaction_id;?>" />
	<input type="hidden" name="refund_type"  id="refund_type<?=$name->Users_ID;?>"  value="Full" />
	<input type="hidden" name="currencycode" id="currencycode<?=$name->Users_ID;?>" value="<?=$name->Currency_Code;?>" />
	<input type="hidden" name="ref_info"	 id="ref_info<?=$name->Users_ID;?>" value="<?=$name->Tournament_ID."_".$name->Users_ID."_".$name->RegisterTournament_id;?>" />
  </td>
  </tr>
  <tr>
  <td colspan='3'>
    <input type="submit" class="proceed league-form-submit sub-proceed" style="margin-bottom:0px;padding:5px 14px;" name="proceed" id="proceed_<?=$name->Users_ID;?>_<?=$name->Tournament_ID;?>" value="Proceed" />
    <input type="button" style="margin-bottom:0px;padding:5px 14px;" value="Cancel" name="cancel" id="cancel_<?=$name->Users_ID;?>" class="cancel league-form-submit">
  </td>
</tr >
</table>
</form>

</td>
</tr>

<tr style="display:none;" id="partcipantlevels_<?=$name->Users_ID;?>">
  <td colspan="3">
    <form id="partcipant_levels_<?=$name->Users_ID;?>" method="POST" >
 
    </form>
  </td>
   <td></td>
    <td></td>
</tr>
<?php
}
}
else {
?>
<tr><td colspan='6'><b>No Players Found. </b></td></tr>
<?php
}
?>
</table>
</div>  


</div>

<input type='hidden' name='tourn_id' id="tourn_id" value="<?php echo $tour_details->tournament_ID; ?>">
<input type='hidden' name='tourn_type' value = "<?php echo $tour_details->Tournament_type; ?>">

<!-- </div> -->
</form>