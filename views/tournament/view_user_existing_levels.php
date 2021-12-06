<script>
$(document).ready(function(){
$(".cancel").on("click", function(){
 var tid=$(this).attr("id");
 var tidarr=tid.split('_');
 var player=tidarr['1'];
  $("#partcipantlevels_"+player).hide();
});
});
</script>

<table class="tab-score">
<?php 
$cnt=0;
$user_db_events = array();
/*echo "<pre>";
print_r($lvlexists);*/
foreach($lvlexists as $level=>$types){
   $event_format = league::regenerate_events($types);
  $cnt+=count($types);
  if ($level=='Singles') 
  {
     $checked="checked";
      $class="";
        foreach($event_format as $key=>$evnt)
        {    
            
				$user_db_events[] = $key;
               ?> 
              <tr>
                   <td style="padding-left:40px;"><input type="checkbox" value="<?php echo $key; ?>" name="match_type_<?php echo $player; ?>[]" class="singles_matchtype_<?php echo $player; ?>"  <?php echo $checked;?>> <?php echo $evnt; ?>
                  </td> 
              </tr>
          <?php 
          }
  }
  else if ($level=='Doubles') 
  { 
      $checked="checked";
      $class="";
    foreach($event_format as $key=>$evnt){
            
		 $user_db_events[] = $key;
		 ?>
          <tr>
          <td style="padding-left:40px;"><input type="checkbox"  value="<?php echo $key; ?>" name="match_type_<?php echo $player; ?>[]" class="doubles_matchtype_<?php echo $player; ?>" <?php echo $checked;?>><?php echo $evnt; ?>
          </td>
          </tr>
      <?php     
    }
  }
  else if ($level=='Mixed') 
  {  
     $checked="checked";
     $class="";
      foreach($event_format as $key=>$evnt){           
			 $user_db_events[] = $key;
			?>
            <tr>
            <td style="padding-left:40px;"><input type="checkbox" value="<?php echo $key; ?>" name="match_type_<?php echo $player; ?>[]" class="mixed_matchtype_<?php echo $player; ?>" <?php echo $checked;?> ><?php echo $evnt; ?>
            </td>
            </tr> 
      <?php  
      }
  }
  else if ($level=='44') 
  {  
     $checked="checked";
     $class="";
      foreach($event_format as $key=>$evnt){           
			 $user_db_events[] = $key;
			?>
            <tr>
            <td style="padding-left:40px;"><input type="checkbox" value="<?php echo $key; ?>" name="match_type_<?php echo $player; ?>[]" class="mixed_matchtype_<?php echo $player; ?>" <?php echo $checked;?> ><?php echo $evnt; ?>
            </td>
            </tr> 
      <?php  
      }
  }
}

?>
</table>
<input type='hidden' name='user_db_events_<?php echo $player; ?>' id="user_db_events" value='<?php echo json_encode($user_db_events); ?>'>
<input type='hidden' name='tourn_id' id="tourn_id" value="<?php echo $tourn_id; ?>">
<input type='hidden' name='participant' id="participant" value="<?php echo $player; ?>">
<input type='hidden' name='checkbox_cnt' id="checkbox_cnt_<?php echo $player; ?>" value="<?php echo $cnt; ?>">
<!-- <input type="button" name='changelvl' value="Update" id="changelvl_<?php echo $player; ?>" class='changelvl league-form-submit'>
<input type="button" name='clear' value="Cancel" id="clear_<?php echo $player; ?>" class='cancel league-form-submit'> -->