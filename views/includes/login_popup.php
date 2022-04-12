<script>
var club_baseurl = "<?php echo $this->config->item('club_pr_url'); ?>";
</script>

<!-- Login Popup Start -->
<div id="login" class="overlay">

<div class="popup">
<h2 style='padding: 0px;'>Login</h2>
<a class="close" href="#">&times;</a>
<div class="content">
<!-- Login content -->

<div class="top-score-title right-score">
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

<form id="form-login" method="post" action='<?=$this->config->item('club_pr_url');?>/login/verify_user'>            
<div class="name">
<label for="name_login">Username or Email:</label><div class="clear"></div>
<input class='form-control' id="txt_login" name="name_login" type="text" style="margin-bottom:10px;" required/>
</div>
<div class="pwd">
<label for="password_login">Password:</label><div class="clear"></div>
<input class='form-control' id="password_login" name="password_login" type="password" required/>
</div>
<div class="hdn">
<?php //echo "<pre>"; print_r($GLOBALS );?>
<input class='form-control' id="red_uri" name="red_uri" type="hidden" value="<?=$this->config->item('club_pr_url');?>" />
</div>
<a href="<?php echo base_url();?>Forgot-password">Forgot Password?</a>
<br />
<div id="login-submit" style="line-height:25px;">
<input type="submit" name='submit_web_login' value="Login" style="padding: 5px 30px;color: #fff;font-weight: bold; margin-top:10px; border:#ff8a00; background-color:#ff8a00" />
&nbsp;&nbsp;
<!--<a href="<?php echo base_url();?>Forgot-password">Forgot Password?</a>-->
| 
<a class="member_login">Sign up</a>
</div>

<div class="ctn-img1">
<?php
$req_uri =  $this->uri->segment(1);
//echo $this->router->class;
//exit;
if($req_uri != 'register'){
$cur_class	 = $this->router->class; 

$login		 = $cur_class :: get_fb_login();
$authUrl = $cur_class :: get_google_login();
}
//print_r($login); 
if($login){
?>
<br /> <h4 style="padding-bottom:0px; padding-top:0px">Or...<br /><br />
<div id="phone-login" style="line-height:25px;"> 
<a href="#login" id="phone_login" class="btn btn-info" role="button" style="margin-bottom: 20px;background-color: #81a32b;border-color: #81a32b;">
Login with Mobile Number</a>
</div>
<?php
if($login){
$this->session->unset_userdata('redirect_to');
$redirect_to = array('redirect_to' => $this->config->item('club_pr_url'));

$this->session->set_userdata($redirect_to);
}


$this->session->unset_userdata('ph_redirect_to');
$redirect_to2 = array('ph_redirect_to' => $this->config->item('club_pr_url'));

$this->session->set_userdata($redirect_to2);

//echo $this->session->userdata('redirect_to');
?>
<!-- <a href="<?php echo $login; ?>"><img src="<?php echo base_url(); ?>icons/facebook.jpg" height="40px" width="245px"  /></a><br /><br />
<a href="<?php echo $authUrl; ?>"><img src="<?php echo base_url(); ?>icons/google.jpg" 
height="40px" width="245px" /></a><br /><br /> -->
<?php
}
?>
</div>
</div>
</div>
</form>
<!-- End of Login content -->


<?php
$this->load->view("view_phone_login_forms");
?>
<!-- Forgot Password window contents -->
<form id='frm_forgot_pwd' name='frm_forgot_pwd' method="post" action="<?php echo base_url().$org_details['Aca_URL_ShortCode'];?>/login/send_activation/"  style='margin-left:20px;display:none;'>
<!-- <form id='member_login' method="post" action='<?php //echo base_url(); ?>/login/verify_user' class="login-form" style='margin-left:20px;' > --> 
<div class="name" align='left'>
<label for="name_login" id="frg_err" style="color:red"></label>
</div>
<div class="name">
<label for="name_login">Registered Email:</label>
<input class='form-control' style='width:80%; margin-bottom:10px;' id="txt_reg_email" name="txt_reg_email" type="text" required />
</div>
<div style="line-height:25px">
<input name="academy"  type="hidden" value="<?=$org_details['Aca_ID'];?>" />
<input name="shortcode" type="hidden" value="<?=$org_details['Aca_URL_ShortCode'];?>" />
<input name="aca_page" id="aca_page" type="hidden" value="" />


</div>
<input type="submit" id='submit_frg_pwd' name='submit_frg_pwd'  value="  Submit  "/> 
</form>


<!-- Mobile number login -->
<form id="form-phone" class="form-signin" accept="#" style="display:none;">
	<h1 class="h3 mb-3 font-weight-normal" style="text-align: center"> Sign in</h1>
	
	<div id='phone-input' style="text-align: center;">

		<div style="display:flex;">
		<select class="form-control" name='ph_country_code' id='ph_country_code' style="width:23%;margin-bottom:10px; margin-right:10px;">
		<option value='+1'>U.S.A</option>
		<option value='+91'>India</option>
		</select>
		<input type="text" id="inputPhone" class="form-control" placeholder="Enter your 10 digits Mobile Number" required="" autofocus="" style="width:75%;" />
		</div>

	<div id="recaptcha-container"></div>
		<div>
		<button class="ph_otp" type="button" id="phoneloginbtn" style="background-color: #ff8a00; margin:15px;"><i class="fas fa-sign-in-alt"></i> SEND OTP</button>
		</div>
	</div>
	<div id='otp-input' style="display:none; text-align: center;">
	<input type="otp" id="inputOtp" style="font-size: 18px !important;" class="form-control" placeholder="Enter One Time Password" required>
	<button class="ph_otp" type="button" id="verifyotp" style="background-color: #ff8a00; margin:15px;"><i class="fas fa-sign-in-alt"></i> VERIFY OTP</button>
	</div>
</form>
<!-- End of Mobile number login -->

<!-- Signup form -->
<form id='frm_signup' name='frm_signup' method='POST'  enctype="multipart/form-data" action='<?php echo base_url().$org_details['Aca_URL_ShortCode'];?>/register/save' style='display:none;'>
<div class='form-group'>
<label class='control-label col-md-4' for='id_accomodation'>First Name * </label>
<input type="text" id="txtfname" name="Firstname" class='form-control' style="width:60%; margin-bottom:10px;" required  />
</div>

<div class='form-group'>
<label class='control-label col-md-4' for='id_accomodation'>Last Name * </label>
<input type="text" id="txtlname" name="Lastname" class='form-control' style="width:60%; margin-bottom:10px;" required  />
</div>

<div class='form-group'>
<label class='control-label col-md-4' for='id_accomodation'>Phone * </label>
<input type="text" id="txtphone" name="Mobilephone" class='form-control' style="width:60%; margin-bottom:10px;" required  />
</div>

<div class='form-group'>
<label class='control-label col-md-4' for='id_accomodation'>Email * </label>
<input type="text" id="txtemail" name="EmailID" class='form-control txt_email' style="width:60%; margin-bottom:10px;" required  />
<span id='email_stat' style='color:red; margin-left:15px;'></span>
</div>

<div class='form-group'>
<label class='control-label col-md-4' for='id_accomodation'>Password: * </label>
<input class='form-control' id="Password" name="Password" type="password" style="width:60%; margin-bottom:10px;" required />
</div>

<div class='form-group'>
<label class='control-label col-md-4' for='id_accomodation'>Gender </label>
<select class='form-control' name="Gender" style="width:40%;">
<option value=''>Select</option>
<option value='1'>Male</option>
<option value='0'>Female</option>
</select>
</div>

<div class='form-group'>
<label class='control-label col-md-4' for='id_accomodation'>Profile Picture </label>
<input id="Profilepic" name="Profilepic" style="margin-bottom:28px" type="file" />
</div>

<?php
//if($org_details['Aca_ID'] == '1123'){
?>
<div class='form-group' id='div-club-mem'>
<label class='control-label col-md-4' for='id_accomodation'>Want to take any membership?</label>
	&nbsp;<input type='radio' name='mem_subscr' class='mem_subscr' value='1' /> Yes
	&nbsp;&nbsp;<input type='radio' name='mem_subscr' class='mem_subscr' value='0' checked /> Guest User
</div>
<script>
$(document).ready(function(){
	var club_id = "<?php echo $org_details['Aca_ID']; ?>";
$('#div_mem_scr').hide();
	$('.mem_subscr').click(function(){
		if($(this).val() == '1'){
			$('#div_mem_scr').show();
		}
		else{
			$('#div_mem_scr').hide();
		}
	});

		/*$.ajax({
		type:'POST',
		url:club_baseurl+'/academy/get_subscr_list',
		data: {org_id:club_id, is_ajax:1},
			success: function(res) {
				if(res != '')
					$('#mem_plan').append(res);
				else
					$('#div-club-mem').hide();
			}
		});*/
});
</script>
<div class='form-group' id='div_mem_scr' style="margin-top:20px;margin-bottom:20px;">
<label class='control-label col-md-4' for='id_accomodation'>Choose a Membership: </label>
<select name='mem_plan' id='mem_plan' class='form-control' style='width:auto;'>
</select>
</div>
<?php
//}
?>
<div class='form-group'>
<label class='control-label col-md-12' for='id_accomodation'>
<input type='checkbox' name='terms_prv' id='terms_prv' style='margin-left: 40px;' value='1' required /> 
<?php
$terms_link		= "Terms & Conditions";
$prv_pol_link		= "Privacy Policy";
//echo $aca_forms['terms_cond']; exit;

if($aca_forms['terms_cond'] != ''){
	$terms_link = "<a href='".base_url().'/assets/club_facility/'.$org_details['Aca_ID']."/forms/".$aca_forms['terms_cond']."' target='_blank'>Terms & Conditions</a>";
}

if($aca_forms['priv_polic'] != ''){
	$prv_pol_link = "<a href='".base_url().'/assets/club_facility/'.$org_details['Aca_ID']."/forms/".$aca_forms['priv_polic']."' target='_blank'>Privacy Policy</a>";
}
?>
I Accept the club <?=$terms_link;?> and <?=$prv_pol_link;?>. 
</label>
</div>

<div id="login-submit" style="line-height:25px; margin-top:40px;">
<input name="academy"   type="hidden" value="<?=$org_details['Aca_ID'];?>" />
<input name="shortcode" type="hidden" value="<?=$org_details['Aca_URL_ShortCode'];?>" />
<input name="red_uri" type="hidden" value="<?=$this->config->item('club_pr_url');?>" />
<input name="aca_page" id="aca_page" type="hidden" value="" />

<input type="submit" name='reg_user' value=" Register " style="padding: 5px 30px;color: #fff;font-weight: bold; margin-top:10px; border:#ff8a00; background-color:#ff8a00" /> 
</div>

</form>
<!-- Signup form -->

</div>
</div>
</div>
<!-- Login Popup End here -->


<!-- ----------------------------------------------------------------------------------------------------------------------------- -->
 <!-- The core Firebase JS SDK is always required and must be listed first -->
<script src="https://www.gstatic.com/firebasejs/7.19.0/firebase-app.js"></script>

<!-- TODO: Add SDKs for Firebase products that you want to use
     https://firebase.google.com/docs/web/setup#available-libraries -->
<!-- <script src="https://www.gstatic.com/firebasejs/7.19.0/firebase-analytics.js"></script> -->
<script defer src="https://www.gstatic.com/firebasejs/7.19.0/firebase-auth.js"></script>
<script src="<?=base_url(); ?>js/custom/phone_login.js"></script>

<script>
$(document).ready(function(){
	$(document).on('click','.member_login', function(){
		//alert('signup clicked');
		$('#login_err').html('');
		$("#form-login").trigger('reset');
	$('#form-login').hide();
	$('#frm_signup').show();

	//$("#login_modal").modal();
	});

	$(document).on('click', '.log_btn', function(){
		$("#frm_signup").trigger('reset');
		$('#form-login').show();
		$('#frm_signup').hide();
		$('#form-phone').hide();
	});
});
</script>
<!-- ----------------------------------------------------------------------------------------------------------------------------------------- -->