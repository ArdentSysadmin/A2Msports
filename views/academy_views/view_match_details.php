
<Script>
$(document).ready(function(){
	$("#update").hide();
	$("#cancel").hide();
$("#edit").click(function(){
        $("#mes").show();
		$("#edit").hide();
		$("#mes1").hide();
		$("#update").show();
		$("#cancel").show();
    });

	$("#cancel").click(function(){
        $("#mes").hide();
		$("#edit").show();
		$("#mes1").show();
		$("#update").hide();
		$("#cancel").hide();
    });
  });
</script>


<section id="single_player" class="container secondary-page" style="background:#fff;">

<div class="top-score-title right-score col-md-9" style="background:#fff;">  

<div class="col-md-12 league-form-bg" style="margin-top:40px; background:#fff; margin-bottom:20px">
<div class="fromtitle">Match Details</div>

<?php
if($match_det)
{ 
?>
<form class="form-horizontal" id='myform' method='post' role="form"  action="<?php echo base_url(); ?>play/register/<?php echo $match_det['GeneralMatch_id'] ;?>"> 

<input type="hidden" name="id" value="<?php echo $match_det['GeneralMatch_id'] ;?>" /> 


		  <div class='form-group'>
            <label class='control-label col-md-3' for='id_accomodation' align='center'>Match Title -</label>
            <div class='col-md-8 form-group internal'>
			<?php echo $match_det['Match_Title']; ?>

            </div>
          </div>
		  <div class='form-group'>
            <label class='control-label col-md-3' for='id_accomodation' align='center'>Sport -</label>
            <div class='col-md-8 form-group internal'>
			<?php $sport_name = play::get_sport($match_det['Sports']);
             echo $sport_name['Sportname'];
			?>
            </div>
          </div>
		  <div class='form-group'>
            <label class='control-label col-md-3' for='id_accomodation' align='center'>Initiator -</label>
            <div class='col-md-8 form-group internal'>
			<?php $match_init_name = play::get_user($match_det['users_id']);
             echo $match_init_name['Firstname']." ".$match_init_name['Lastname'];
			 ?>
            </div>
          </div>
		  <div class='form-group'>
            <label class='control-label col-md-3' for='id_accomodation' align='center'>Message - </label>
            <div class='col-md-8 form-group internal'>
			<span id="mes1"><?php echo $match_det['Message']; ?></span>
			<textarea name="mes" id="mes" rows="4" cols="50" style="display:none;"><?php echo $match_det['Message']; ?></textarea>
            </div>
          </div>

		  <div class='form-group'>
			<label class='control-label col-md-3' for='id_accomodation'></label>
			<div class='col-md-7 form-group internal'>
			<?php if($match_det['users_id'] == $this->session->userdata('users_id')){ ?>
			
		
			<input type="button" id="edit" value="EDIT" class="league-form-submit">

			<input type="submit" id="update" name="update"  value="UPDATE" class="league-form-submit"/>

			<input type="button" id="cancel" name="cancel"  value="CANCEL" class="league-form-submit"/>

			<?php } else { ?>
			
			<input name="register_match" type="submit" value="Register" class="league-form-submit"/>

			<?php } ?>
			</div>
			</div>
</form>
<?php 
}
else
{ 
?>
	<p style="line-height:20px; font-size:13px"><h5>Oops! Invalid Access. Please contact admin@a2msports.com</h5></p>
<?php
}
?>

</div>
<div style="clear:both"></div>

</div>