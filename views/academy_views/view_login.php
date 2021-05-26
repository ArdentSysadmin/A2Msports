<script>
$('#txt_login').focus();
</script>
<section id="login" class="container secondary-page">  
<div class="general general-results players">

<!-- LOGIN BOX -->
<div class="top-score-title right-score col-md-12">
<h3>Login<!--<span> Now</span><span class="point-int"> !</span>--></h3>
<div class="col-md-12 login-page">
<?php 
if(isset($err_msg)) { ?>
<div class="name" align='left'>
<label for="name_login" style="color:red"><?php echo $err_msg; ?></label>
</div>
<?php } ?>
<?php if(isset($act_stat)) { ?>
<div class="name" align='left'>
<label for="name_login" style="color:blue"><?php echo $act_stat; ?></label>
</div>
<?php } ?>

<?php if(isset($update)) { ?>
<div class="name" align='left'>
<label for="name_login" style="color:green"><?php echo $update; ?></label>
</div>
<?php } ?>

<form method="post" action='<?php echo base_url(); ?>login/verify_user' class="login-form">            
<div class="name">
<label for="name_login">Username or Email:</label><div class="clear"></div>
<input id="txt_login" name="name_login" type="text" required/>
</div>
<div class="pwd">
<label for="password_login">Password:</label><div class="clear"></div>
<input id="password_login" name="password_login" type="password" required/>
</div>
<div id="login-submit" style="line-height:25px">
<input type="submit" name='submit_web_login' value="Login"/><br>
<a href="<?php echo base_url();?>Forgot-password">Forgot Password?</a><br><a href="<?php echo base_url(); ?>register/">Register Now!</a> <br></div>
</form>
<!-- <div class="ctn-img1">
<h4 style="padding-bottom:10px; padding-top:10px">Or login with your social account</h4>
<a href="<?php echo $login; ?>"><img src="images/lfacebook.gif" /></a><br><br>
<img src="<?php echo base_url();?>images/lgmail.gif" /><br><br>
<img src="<?php echo base_url();?>images/ltwitter.gif" />
</div>Close Images-->

<div class="ctn-img1">
<br> <h4 style="padding-bottom:10px; padding-top:10px">Or...<br><br> For quicker access...</h4>		

<?php if($login){
?>
<a href="<?php echo $login; ?>"><img src="<?php echo base_url(); ?>images/lfacebook.gif" /></a><br /><br />
<?php }

else 
{
?>
<img src="<?php echo base_url(); ?>images/lfacebook.gif" /><br /><br />
<?php }
?>
<!-- <img src="<?php echo base_url(); ?>images/lgmail.gif" /><br><br>
<img src="<?php echo base_url(); ?>images/ltwitter.gif" /> -->
</div><!--Close Images-->

</div>
</div><!--Close Login-->

</div> 
</section>