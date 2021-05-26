<link href="<?php echo base_url(); ?>assets/club_pages/assets/css/popup.css" rel="stylesheet">
<style>

.mobile-modal-dialog{
width:50%;
}

@media only screen and (max-width: 780px) 
{
	.mobile-modal-dialog{
	width:100% !important;
	}
}
</style>
<script>
var baseurl = "<?php echo base_url(); ?>";

$(document).ready(function(){
$('#txt_login').focus();
}); 
</script>
<section id="login" class="container secondary-page">  
<div class="general general-results players">



<!-- LOGIN BOX -->
<div class=" col-md-4 hidden-xs">&nbsp;</div>
<div class="top-score-title right-score col-md-4">
<h3>Login to A2M<!--<span> Now</span><span class="point-int"> !</span>--></h3>
<div class="">
<?php 
//if(isset($this->session->flashdata('err_msg'))) { ?>
<div class="name" align='left'>
<label for="name_login" style="color:red"><?php echo $this->session->flashdata('err_msg'); ?></label>
</div>
<?php //} ?>
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

<form method="post" action='<?php echo base_url(); ?>login/verify_user'>            
<div class="name">
<label for="name_login">Username or Email:</label><div class="clear"></div>
<input class='form-control' id="txt_login" name="name_login" type="text" style="margin-bottom:10px;" required/>
</div>
<div class="pwd">
<label for="password_login">Password:</label><div class="clear"></div>
<input class='form-control' id="password_login" name="password_login" type="password" required/>
</div>
<a href="<?php echo base_url();?>Forgot-password">Forgot Password?</a>
<br />
<div id="login-submit" style="line-height:25px;">
<input type="submit" name='submit_web_login' value="Login" style="padding: 5px 30px;color: #fff;font-weight: bold; margin-top:10px; border:#ff8a00; background-color:#ff8a00" />
&nbsp;&nbsp;
<!--<a href="<?php echo base_url();?>Forgot-password">Forgot Password?</a>-->
| 
<a href="#" class="member_login">Sign up</a>
</div>

<div class="ctn-img1">
<?php
//echo "<pre>"; print_r($GLOBALS); exit;
$req_uri		 =  $this->uri->segment(1);
$cur_class	 = $this->router->class;

if($req_uri != 'register'){
	$login		 = $cur_class :: get_fb_login();
	$authUrl	 = $cur_class :: get_google_login();
}
//print_r($login); 
if($login){
?>
<br /> <h4 style="padding-bottom:10px; padding-top:10px">Or...<br /><br />

<a href="<?php echo $login; ?>"><img src="<?php echo base_url(); ?>icons/facebook.jpg" height="40px" width="245px"  /></a><br /><br />
<a href="<?php echo $authUrl; ?>"><img src="<?php echo base_url(); ?>icons/google.jpg" 
height="40px" width="245px" /></a><br /><br />
<?php
}
?>

<!-- <img src="<?php echo base_url(); ?>images/lgmail.gif" /><br><br>
<img src="<?php echo base_url(); ?>images/ltwitter.gif" /> -->
</div><!--Close Images-->

</div>
</form>
<!-- <div class="ctn-img1">
<h4 style="padding-bottom:10px; padding-top:10px">Or login with your social account</h4>
<a href="<?php echo $login; ?>"><img src="images/lfacebook.gif" /></a><br><br>
<img src="<?php echo base_url();?>images/lgmail.gif" /><br><br>
<img src="<?php echo base_url();?>images/ltwitter.gif" />
</div>Close Images-->


</div>
</div>
<div class=" col-md-4 hidden-xs">&nbsp;</div>
<!--Close Login-->

</div> 


<div class="modal fade" id="login_modal" role="dialog">
<div class="modal-dialog modal-lg mobile-modal-dialog">
	<div class="modal-content">
	<div class="modal-header" style='border:0px;'>
<!-- Login window content -->
<form>          
<div style='margin-bottom:25px;'><h4><b>Register as</b></h4></div>
<div class="name" style='margin-left:60px;margin-bottom: 25px;'>
<label for="txt_asclubowner"><input name='regas' id="txt_asclubowner" type="radio" value='club-owner' /> Club Owner </label>
<br /><span style='margin-left: 18px;'><i>Tournaments, Court Reservations, Membership Engagement and more! </i><span>
<div class="clear"></div>
</div>
<div class="name" style='margin-left:60px;margin-bottom: 25px;'>
<label for="txt_ascoach"><input name='regas' id="txt_ascoach" type="radio" value='coach'  /> Coach </label>
<br /><span style='margin-left: 18px;'><i>Reach more players, Schedule your classes and communicate with players </i><span>
<div class="clear"></div>
</div>
<div class="name" style='margin-left:60px;margin-bottom: 40px;'>
<label for="txt_asplayer"><input name='regas' id="txt_asplayer" type="radio" value='player'  /> Player </label>
<br /><span style='margin-left: 18px;'><i>Register for tournaments, Reserve courts, Find clubs ad coaches. </i><span>
<div class="clear"></div>
</div>


<div id="login-submit" style="line-height:25px; margin-left:60px; margin-top:10px;">
<!-- <input name="academy"  type="hidden" value="<?=$org_details['Aca_ID'];?>" />
<input name="shortcode" type="hidden" value="<?=$org_details['Aca_URL_ShortCode'];?>" />
<input name="aca_page" id="aca_page" type="hidden" value="" />
 -->
<input type="button" id='register-as' name='register-as' value="  Continue  "/><br>
</div>
</form>
<!-- Login window content -->
	</div>
	</div>
</div>
</div>
</section>

<script>
$(document).ready(function(){
	$(document).on('click','.member_login',function(){
		$("#login_modal").modal();
	});

	$('#register-as').click(function(){
		var ras = $("input[name='regas']:checked"). val();
		
		window.location.replace(baseurl+'register?r='+ras);
	});
});
</script>
