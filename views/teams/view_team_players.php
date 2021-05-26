<link href="//cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css" rel="stylesheet" type="text/css" />
<script>
$(document).ready(function(){


$('form').on('submit', function(e){
   var $form = $(this);

   // Iterate over all checkboxes in the table
   table.$('input[type="checkbox"]').each(function(){
      // If checkbox doesn't exist in DOM
      if(!$.contains(document, this)){
         // If checkbox is checked
         if(this.checked){
            // Create a hidden element 
            $form.append(
               $('<input>')
                  .attr('type', 'hidden')
                  .attr('name', this.name)
                  .val(this.value)
            );
         }
      } 
   });          
});

	$('.fee_div').hide();
	//$('.payment_method').hide();
	var tr_id = '';
	$('.mark_paid').click(function(){
		tr_id = $(this).attr('id');
		$('.fee_div').hide();
		$('#fee_div_'+tr_id).show();
	});

	$('.cancel').click(function(){
		$('#fee_div_'+tr_id).hide();
	});

	$('.payment_method').change(function() {
           var payment_method = $(this).find(":selected").val();
           if(payment_method != 'Free Entry'){
            $("#paid_amount_p_"+tr_id).show();
            $("#paid_amount").val('');
           }
		   else{
           	$("#paid_amount").val('0.00');
           	$("#paid_amount_p_"+tr_id).hide();
           }
    });

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

$(".upd_pay").click(function(){
  var tid	 = $(this).attr("id");
  var tidarr = tid.split('_');

  var player	 = tidarr['1'];
  var team_id	 = $('#team_id_'+player).val();
  var pay_method = $('#pay_method_'+player).val();
  var pay_amt	 = $('#amount_'+player).val();
  var tourn_id	 = $('#tourn_id').val();

  $.ajax({
      type: 'POST',
      url: baseurl+'league/update_team_player_payment',
      data:{player:player, tourn_id:tourn_id, team_id:team_id, pay_method:pay_method, pay_amt:pay_amt},
      success: function(res) {
        alert('Payment details added successfully.');
		$('#p_'+player).html(res);
        $("#fee_div_"+player).hide();
        //$("#existing_events_"+player).html(res);
      }
      });
});




$(".sub-proceed").click(function(){
  $(this).val("Please wait...");
});


/*****************/

$('.edit_a2m').click(function(){
	var uid = $(this).attr('id');
	$('#edit_sec_'+uid).show();
	$('#a2m_dis_'+uid).hide();
	$('#'+uid).hide();
});

$('.cancel_a2m').click(function(){
	var id = $(this).attr('id');
	var x  = id.split('_');
	var uid = x[1];

	$('#edit_sec_'+uid).hide();
	$('#a2m_dis_'+uid).show();
	$('#'+uid).show();
});

$('.upd_a2m_btn').click(function(){
	var id   = $(this).attr('id');
	var x    = id.split('_');
	var uid  = x[1];
	var tid  = $('#tourn_id').val();
	var uval   = $('#txt_'+uid).val();
	var mx_a2m = $('#temp_a2m').val();

	if(mx_a2m > uval || mx_a2m == 0){
		$.ajax({
		  type: 'POST',
		  url: baseurl+'league/edit_user_a2m',
		  data:{user:uid,tourn_id:tid,uval:uval},
		  success: function(res) {
			  if ($.isNumeric(res)) {
			  $('#a2m_dis_'+uid).html(res);
			  }
			  else {
			  alert(res);
			  }
			  $('#edit_sec_'+uid).hide();
			  $('#a2m_dis_'+uid).show();
		  }
		});
	}
	else{
		alert("Score shouldn't exceed "+(mx_a2m-1));
	}
});


var table = $('#tourn_team_players').DataTable();

});

</script>

<style>
/*table#tourn_team_players tr td input.button { display:none;}
table#tourn_team_players tr:hover td input.button { display:inline-block;}*/

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

<form name='' id='' method='POST' action='<?php echo base_url()."league/update_payment"; ?>'>
<div class="col-md-12 league-form-bg" style="margin-top:15px; margin-bottom:0px;">
<?php
$reg_players = league::get_tourn_team_players($tour_details->tournament_ID); 
?>
<div class="tab-content table-responsive">
<table class="table tab-score" id="tourn_team_players">
<thead>
<tr class="top-scrore-table" style='background-color:#f68b1c'>
<th class="score-position" valign="center" align="center">Name</th>
<th class="score-position" valign="center" align="center">Mobile#</th>
<th class="score-position" valign="center" align="center">Team</th>
<th class="score-position" valign="center" align="center">City</th>
<th class="score-position" valign="center" align="center">State</th>
<!-- <th class="score-position" valign="center" align="center">Pay Status</th> -->
<th class="score-position" valign="center" align="center">A2M Rating</th>
<th class="score-position" valign="center" align="center">Registered on</th>
</tr>
</thead>
<tbody>

<?php
/*echo "<pre>";
print_r($reg_players);
exit;*/
$check_cond = array('0.00','0','NULL','');
$total		= 0;
if(count(array_filter($reg_players)) > 0){
$max_a2m = 0;

foreach($reg_players as $team => $team_players){
	foreach($team_players['Users'] as $player){
		$get_user		  = league::get_user($player);
		$get_payment_info = league::get_team_player_payment_info($player, $tour_details->tournament_ID);
		$get_a2m		  = league::get_a2mscore($player, $tour_details->SportsType);

		$paid_ico	 = '';
		$paid_status = '';
		$check_box = '';
		if(!empty($get_payment_info)){
			$paid_ico	 = "<img src='".base_url()."icons/letter_p.png' title='Paid' style='width:21px; height:21px;' />"; 
			$paid_status = '<b>Paid</b>';
		}
		else{
			$check_box = "<input type='checkbox' class='mark_paid league-form-submit1' name='sel_players[]' id='{$player}' value='{$player}_{$team}' />"; 
		}
		$gend = '';
		if($get_user['Gender'] == '1'){ $gend = 'M'; }
		else if($get_user['Gender'] == '0'){ $gend = 'F'; }

		$team_name = league::get_team($team);
?>
<tr id='p_<?=$player;?>'>
<td style="padding-left:10px">
<?php
echo "{$check_box} &nbsp;<a href='".base_url()."player/".$get_user['Users_ID']."' target='_blank'>" . ucfirst($get_user['Firstname']) . " " . ucfirst($get_user['Lastname']) . "</a> ($gend)&nbsp;&nbsp;{$paid_ico}";
?>
</td>
<td style="padding-left:10px"><?=$get_user['Mobilephone']; ?></td>
<td style="padding-left:10px"><?=$team_name['Team_name']; ?></td>
<td style="padding-left:10px"><?=$get_user['City']; ?></td>
<td style="padding-left:10px"><?=$get_user['State']; ?></td>
<!-- <td style="padding-left:10px"><?=$paid_status; ?><?=$paid_button;?></td> -->
<td style="padding-left:10px">
<span id='a2m_dis_<?=$player;?>' style='color:#000;font-size:13px;font-weight:normal;'><?=$get_a2m['A2MScore']; ?></span>
<?php
if(($tour_details->Usersid == $this->logged_user or $this->is_super_admin) and $get_a2m['A2MScore'] == 100){
?>
<img src='<?=base_url();?>images/edit.png' class='edit_a2m' name='edit_a2m' id='<?=$player;?>' style='width:18px;height:18px;cursor:pointer;' />

<div id='edit_sec_<?=$player;?>' style='display:none;'>
	<input type='text' name='upd_a2m_val_<?=$player;?>' id='txt_<?=$player;?>' value='<?=$get_a2m['A2MScore'];?>' style='width:50px;' maxlength='3' /><br /><br />
	<input class="upd_a2m_btn a2m-button-small" type='button' name='upd_a2m' id='btn_<?=$player;?>' value='Update' />
	<a class='cancel_a2m' id='cancel_<?=$player;?>' style='cursor:pointer;'>Cancel</a>
</div>
<?php
}
?>
</td>
<td style="padding-left:10px"><?php echo date('m/d/Y', strtotime($team_players['Reg_Date'])); ?></td>
</tr>

<!-- <tr id='fee_div_<?=$player;?>' class='fee_div' style='background-color:white'>
<td>
<span style="font-size:14px;color:black;">
Payment Method:
<select name="payment_method" class="payment_method" id="pay_method_<?=$player;?>">
<option value="Free Entry" selected>Free Entry</option>
<option value="Cash">By Cash</option>
<option value="Check">Check</option>
<option value="Paypal Direct">Paypal Direct</option>
<option value="Cash App">Cash App</option>
</select>
</span>
</td>
<td id="paid_amount_p_<?=$player;?>" style="display:none">
<span style="font-size:14px;color:black;">
Paid Amount:
<input type="text" name="paid_amount" id="amount_<?=$player;?>" placeholder="Enter Amount" value="0.00" />
</span>
</td>
<td>
<input type="hidden" name="team_id_<?=$player;?>" id="team_id_<?=$player;?>" value="<?=$team;?>" />
<input type="button" class="upd_pay league-form-submit1" name="update_payment" id="btn_<?=$player;?>" value=" Update " />
<span class='cancel' style="font-size:13px;color:black;cursor:pointer;">Cancel?</span>
</td>
<td>&nbsp;</td>
<td>&nbsp;</td>
</tr> -->
<?php
			if($max_a2m < $get_a2m['A2MScore']){
				$max_a2m = $get_a2m['A2MScore'];
			}
	}
}

}
else{
?>
<tr>
<td><b>No Players are Registered yet. </b></td>
<td>&nbsp;</td>
<td>&nbsp;</td>
<td>&nbsp;</td>
<td>&nbsp;</td>
</tr>
<?php
}
?>
</tbody>
</table>
</div>  
<div class="col-md-4">
<span style="font-size:14px;color:black;">
Payment Method:
<select name="payment_method" class="payment_method form-control inwidth" id="pay_method_<?=$player;?>">
<option value="Free Entry" selected>Free Entry</option>
<option value="Cash">By Cash</option>
<option value="Check">Check</option>
<option value="Paypal Direct">Paypal Direct</option>
<option value="Cash App">Cash App</option>
</select>
</span>
<span style="font-size:14px;color:black;">
Paid Amount:
<input type="text" name="paid_amount" class="form-control inwidth" id="amount_<?=$player;?>" placeholder="Enter Amount" value="0.00" />
</span>
<br />
<input type="submit" class="upd_pay league-form-submit" name="update_payment" value=" Update " />
</div>
</div>
<input type='hidden' name='tourn_id' id="tourn_id" value="<?php echo $tour_details->tournament_ID; ?>" />
<input type='hidden' name='tourn_type' value = "<?php echo $tour_details->Tournament_type; ?>" />
<input type='hidden' name='temp_a2m' id="temp_a2m" value="<?=$max_a2m;?>" />

<!-- </div>--></form>