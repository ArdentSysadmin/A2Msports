<section id="single_player" class="container secondary-page">
<div class="top-score-title right-score col-md-9">
<h3 style="text-align:left">Forgot Password</h3>

<!-- start main body -->
<div class="top-score-title right-score col-md-12">
<div class="col-md-12 login-page">
<?php
if(isset($msg)){ ?>
<div class="name" align='left'>
<label for="name_login" style="color:green"><?php echo $msg; ?></label>
</div>
<?php } ?>

<?php
if(isset($error)){ ?>
<div class="name" align='left'>
<label for="name_login" style="color:red"><?php echo $error; ?></label>
</div>
<?php } ?>

<?php
if(isset($child_accounts)){ 
echo "<h4>We found the given profiles that are linked to your account.<br />Please select the user to which you want to reset the password.</h4><br />";
?>

<form method="post" class="login-form" method="post" action='<?php echo base_url(); ?>login/send_email_activation'> 
<?php foreach($child_accounts as $child){ ?>
<div class="name">
<input type="radio" name="child_user_id" value="<?php echo $child->Users_ID; ?>" /> 
<?php $name = login::get_child_name($child->Users_ID);
echo  $name['Firstname'] . " ". $name['Lastname'] . "<br /><br />";?>
</div>
<?php } ?>

<input type="hidden" name="uid" value="<?php echo $parent_id; ?>"/>
<input type="submit" name="child_account" value="Submit" />
</form>

<?php 
} 
else{
?>
<div id="parent_form">
<form id='forgot_pwd_frm' method="post" class="login-form" method="post" action='<?php echo base_url(); ?>login/ref_accounts'>            
<div class="name">
<label for="name_login">Registered Email:</label><div class="clear"></div>
<input id="email" name="email" class='form-control' type="email" required />
<input id="test" name="test" type="hidden" value='test' />
</div>
<!-- <div id="login-submit" style="line-height:25px">
 --><input type="submit" id='sub_btn' name="submit" value="Submit" />
<!-- </div>
 --></form>
</div>
<?php 
} ?>
</div>

</div><!--Close Login-->
<!-- end main body -->
</div><!--Close Top Match-->
<script>
$(document).ready(function(){ 
$('#sub_btn').on('touchstart', function(){
	$('#forgot_pwd_frm').submit();
});
});
</script>