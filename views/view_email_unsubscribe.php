<script type="text/javascript">
	function Unsubscribe(){
		
		var len = $('input[name="sports[]"]:checked').length;
		
		if(len == 9){
          var x = confirm("Are you sure you want to unsubscribe from all notifications?");
          if(x == true){
              return true;
          }
		  else{
              return false;
          }
		}
		else if(len < 9 && len != 0){
		  var sports = [];
          $("input[name='sports[]']:checked").each(function () {
               
                var label = $(this).closest("label");  
                var text = $(label).text();
                sports.push(text);
     
            });
          
            alert("You will not get any notifications for the sports: " + sports.join(", "));
            return true;
		}
		else if(len == 0){
            alert("Select atleast one sport to unsubscribe!");
            return false;
		}
		
	}
  </script>
  <script type="text/javascript">
 $( document ).ready(function() {
  $( "#select_all_sports").click(function() {
  if ($("#select_all_sports").prop('checked')==true){
     $(".sports_cls").prop('checked', true);
    }else{
     $(".sports_cls").prop('checked', false);
    }
});
  });
</script>
<section id="single_player" class="container secondary-page">
<div class="col-md-9 league-form-bg" style="margin-top:40px; background:#fff; margin-bottom:20px">
<?php
//$notify_settings = json_decode($user_details['NotifySettings'], true);
$notify_sports   = json_decode($user_details['NotifySports'], true);
$user_id		 = $user_details['Users_ID'];
?>
<div class="fromtitle">Unsubscribe</div>

<?php
if($status == 1){
?>
<div><h4>Thank you, you were successfully unsubscribed. </h4></div>
<?php
}
else{?>
<form class='form-horizontal' method="post" action="<?php echo base_url(); ?>register/Update_email_unsubscribe" role='form' onsubmit="return Unsubscribe()">
<div class='form-group' style="margin:10px">
<label class='control-label col-md-3' for='id_accomodation'>Select to unsubscribe from the following sports notifications</label>
<div class='col-md-9 form-group internal'>
<input type="checkbox" id="select_all_sports"> Select All <br />
<!-- <input type="checkbox" name="notify_settings[NT]" id="nt_notify"  value="<?php echo $notify_settings['NT'];?>" <?php  if($notify_settings['NT']){echo "checked = checked"; }?> /> Notify me new Tournament is created <br />
<input type="checkbox" name="notify_settings[Admin]" id="admin_notify"  value="<?php echo $notify_settings['Admin'];?>" <?php  if($notify_settings['Admin']){echo "checked = checked"; }?> /> Send admin notifications  <br />
<input type="checkbox" name="notify_settings[News]" id="news_notify"   value="<?php echo $notify_settings['News'];?>" <?php  if($notify_settings['News']){echo "checked = checked"; }?> /> Send notification A2MSports admin news <br /> -->
<?php 

foreach($allsports as $key => $value){
?>
 <label><input type="checkbox" name="sports[]" class="sports_cls" id="<?php echo $value->SportsType_ID;?>"  value="<?php echo $value->SportsType_ID;?>" <?php if(in_array($value->SportsType_ID, $notify_sports)){echo "checked = checked"; }?> /> <?php echo $value->Sportname;?></label><br />
 <?php
 }
 ?> <br /> 
 <input type="hidden" value="<?php echo $user_id;?>" name="user_id">
</div>
</div>
<div align="center"><input type="submit" value="Unsubscribe" style="margin-top:10px" class="league-form-submit" /></div>
</form>
<?php
}?>
</div>