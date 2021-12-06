<script type="text/javascript">
$(document).ready(function(){
$('input[name=confirm_password]').blur(function() {
    var pass   = $('input[name=Password]').val();
    var repass = $('input[name=confirm_password]').val();

    if(($('input[name=Password]').val().length == '') || ($('input[name=confirm_password]').val().length == '')) {
        ///$('#Password').addClass('has-error');
    }
    else if (pass != repass) {
		$( ".err" ).show();
		$('#confirm_password').val("");
    }
    else {
		$( ".err" ).hide();
    }
});

});
</script>

<section id="single_player" class="container secondary-page">

<div class="top-score-title right-score col-md-9">
<h3 style="text-align:left">Update Password</h3>

<!-- start main body -->
<div class="top-score-title right-score col-md-12">
<div class="col-md-12 login-page" style='padding:30px;'>
<?php
if(isset($act_stat)) {
?>
<div class="name" align='left'>
<label for="name_login" style="color:green"><?php echo $act_stat; ?></label>
</div>
<?php
} ?>

<form method="post" class="login-form" method="post" 
action='<?php echo base_url(); ?>login/update_password' style='float:none;'>           

<div class="name" style="margin-top: 10px;">
<label for="Password">* New Password:</label><div class="clear"></div>
<input id="Password" name="Password" type="password" class='form-control'  required />
</div>

<div class="name" style="margin-top: 25px;">
<label for="confirm_password">* Confirm Password:</label><div class="clear"></div>
<input id="confirm_password" name="confirm_password" type="password" class='form-control' required />
<div class="err" style="display: none; color:red">Password mismatch</div>
</div>

<input id="Users_ID" name="Users_ID" value="<?php echo $user_details['Users_ID']; ?>" type="hidden" />
<br />
<br />
<div id="login-submit" style="line-height:25px">
<input type="submit" name="submit" value="Update" />
</div>

</form>
</div>

</div><!--Close Login-->
<!-- end main body -->

</div><!--Close Top Match-->
<!-- <div style='clear:both'></div> -->