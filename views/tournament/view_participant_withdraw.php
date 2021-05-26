<div class='col-md-8'>
<?php 
$tourn_reg_events			= league::GetPlayerEvents($tour_details->SportsType,$tour_details->tournament_ID);
$tourn_reg_extra_ev_trans   = league::GetPlayerExtraEventTrans($tour_details->tournament_ID);
$tourn_reg_ref_trans		= league::GetPlayerRefTrans($tour_details->tournament_ID);
?>
<form id = 'frm_player_withdraw'>
<div>
<?php
$txn_id = array();

//echo "<pre>";
$player		 = $tourn_reg_events['player'];
$fee		   = $tourn_reg_events['fee'];
if(($tourn_reg_events['Transaction_id'])){
$txn_id[trim($tourn_reg_events['Transaction_id'])] = $tourn_reg_events['fee'];
}
$level_counts  = $tourn_reg_events['level_counts'];
$currency_code = $tourn_reg_events['Currency_Code'];
$tourn_id      = $tourn_reg_events['tourn_id'];

$registertournament_id = $tourn_reg_events['RegisterTournament_id'];

foreach($tourn_reg_extra_ev_trans as $i => $val){
	$txn_id[trim($val->Transaction_id)] = trim($val->Amount);
}

$age_grp	= json_decode($tour_details->Age);
$mult_fee	= json_decode($tour_details->mult_fee_collect);
$addn_fee	= json_decode($tour_details->addn_mult_fee_collect);

foreach($age_grp as $i => $ag){
	$tourn_fee[$ag] = array('fee' => $mult_fee[$i],'extra_fee' => $addn_fee[$i]);
}
//print_r($tourn_fee);

//echo json_encode($level_counts);
?>
<table class="tab-score">
<?php 
$cnt=0;
$totevents = array();
foreach($tourn_reg_events['events'] as $level => $events){
  $cnt+=count($events);
  $event_format = league::regenerate_events($events);
  if($level == 'Singles') 
  {
     $checked = "";
     $class   = "";
     foreach($event_format as $key => $evnt){   

          array_push($totevents,$key); 
?> 
		  <tr>
		  <td style="padding-left:40px;"><input type="checkbox" value="<?php echo $key; ?>" name="sel_events[]" class="GetRefundAmnt singles_matchtype_<?php echo $player; ?>" <?php echo $checked;?>>&nbsp;<?php echo $evnt; ?>
		  </td> 
		  </tr>
		<?php 
	  }
  }
  if ($level=='Doubles') 
  { 
     $checked="";
     $class=""; 
     foreach($event_format as $key=>$evnt){
     	 array_push($totevents,$key); 
        ?>
          <tr>
          <td style="padding-left:40px;"><input type="checkbox"  value="<?php echo $key;?>" name="sel_events[]" class="GetRefundAmnt doubles_matchtype_<?php echo $player; ?>" <?php echo $checked;?>>&nbsp;<?php echo $evnt; ?>
          </td>
          </tr>
      <?php     
    }
  }
  if ($level=='Mixed') 
  {  
     $checked="";
     $class="";
     foreach($event_format as $key=>$evnt){  
      array_push($totevents,$key);          
		?>
		<tr>
		<td style="padding-left:40px;"><input type="checkbox" value="<?php echo $key; ?>" name="sel_events[]" class="GetRefundAmnt mixed_matchtype_<?php echo $player; ?>" <?php echo $checked;?> >&nbsp;<?php echo $evnt; ?>
		</td>
		</tr> 
      <?php  
     }
  }
}
?>
</table>
</div>
<?php
$tot_paid = 0;
if(count(array_filter($tourn_reg_events)) > 0){
?>
<div>
<br />
<label>Payments:</label>&nbsp;
<?php
 if(!empty($txn_id)){
	foreach($txn_id as $tid => $amt){
		echo "<br>".$tid." ($".number_format($amt, 2).")";
		$tot_paid += (float)$amt;
	}
 }
 else{ 
		echo "Not Available";
 }
?>
<?php
$prev_refunds = 0;

if(count(array_filter($tourn_reg_ref_trans)) > 0){
?>
<br />
<label>Prev. Refunds:</label>&nbsp;
<br />
<?php
	foreach($tourn_reg_ref_trans as $i => $pr){
		echo "{$pr->Ref_TxnID} ("."$"."{$pr->Ref_Amt}) - {$pr->Ref_Type} Refund <br>";
		$prev_refunds += $pr->Ref_Amt;
	}
}
?>
<!-- </div> -->
<input type="hidden" name="trans_id" id="trans_id" value='<?php echo json_encode($txn_id); ?>' />
<input type="hidden" name="fee" id="fee" value="<?=number_format($fee,2);?>" /><br /><br />
<input type="hidden" style="width:10%" name="paid_amnt" id="paid_amnt" value="<?php echo $tot_paid; ?>" />
<input type="hidden" style="width:10%" name="pr_ref" id="pr_ref" value="<?php echo $prev_refunds; ?>" />

<label>Refund $</label> <span id='refund_amnt'>0.00</span>
<input type="hidden" style="width:10%" name="refund_amt" id="refund_amnt_val" value="0.00" />

</div>
<?php
//}
}
?>
<!-- </div> -->

  <input type='hidden' name='tourn_fee'    id="tourn_fee"	value='<?php echo json_encode($tourn_fee); ?>'	  />
  <input type='hidden' name='totevents'    id="totevents"   value='<?php echo json_encode($totevents); ?>'	  />
  <input type='hidden' name='level_count'  id="level_count"	value='<?php echo json_encode($level_counts); ?>' />
 
  <input type="hidden" name="refund_type" id="refund_type" value="Full" />
  <input type="hidden" name="currencycode" id="currencycode" value="<?=$currency_code;?>" />
  <input type="hidden" name="ref_info" id="ref_info" value="<?=$tourn_id."_".$player."_".$registertournament_id;?>" />
  <input type='hidden' name='checkbox_cnt' id="checkbox_cnt"  value="<?php echo $cnt; ?>" />

<div class="col-md-4">
<input type="button" name='proceed' value="Proceed" id="proceed_<?=$player;?>_<?=$tourn_id;?>" style="margin-top:10px" class="player_withdraw_btn league-form-submit1" />
<input type="button" value="Cancel" id="player_withdraw_btn_cancel" name="cancel" style="margin-top:10px" class="league-form-submit1" />
</div>
</form>
</div>