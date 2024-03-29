<html>
<head>
<link href="<?php echo base_url();?>css/bootstrap.css" rel="stylesheet" type="text/css"/>
<link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css" />
<script src="https://code.jquery.com/jquery-1.10.2.min.js" type="text/javascript"></script>
<script src="<?php echo base_url();?>js/bootstrap.min.js"></script>
<script>
var club_baseurl = "<?php echo $this->config->item('club_form_url'); ?>";
</script>
<style>

.mobile-modal-dialog{
width:50%;
}

@media only screen and (max-width: 780px) {
	.mobile-modal-dialog{
	width:100% !important;
	}
}
</style>
<script>
$(document).ready(function(){

$("#btn_web_login").click(function(e){

	var email	= $('#txt_login').val();
	var pwd		= $('#password_login').val();
	var baseurl = "<?php echo base_url(); ?>";

	$('#login_err').html('');

	//if(email && pwd){
			$.ajax({
			type:'POST',
			url:baseurl+'login/ajax_validate_login/',
			data: {name_login: email, password_login: pwd},
			//context: this,
			success:function(html){
				if(html == '-1'){
					$('#login_err').html('Email Activation not done!');
					return false;
				}
				else if(html == '-2'){
					$('#login_err').html('Invalid Login!');
					return false;
				}
				else if(html == '1'){
					//$("#member_login").serialize();
					$( "#submit_web_login" ).trigger('click');
					//alert('test');
					//$('#txt_login').val(email);
					//$('#password_login').val(pwd);
					//$('#member_login').submit();
					return true;
				}
			}
			});

e.preventDefault(e);
});


});
</script>
</head>
<body>
<link href="<?php echo base_url(); ?>assets/club_pages/assets/css/popup.css" rel="stylesheet">

<script>
var baseurl = "<?php echo base_url(); ?>";
</script>

<div class="modal fade" id="login_modal" role="dialog">
<div class="modal-dialog modal-lg mobile-modal-dialog">
	<div class="modal-content">
	<div class="modal-header" style='border:0px;'>
<!-- Login window content -->
<form id='member_login' method="post" action='<?php echo base_url().$org_details['Aca_URL_ShortCode']; ?>/login/verify_user'  style='margin-left:20px;'>
<!-- <form id='member_login' method="post" action='<?php //echo base_url(); ?>/login/verify_user' class="login-form" style='margin-left:20px;' > --> 
<div class="name" align='left'>
<label for="name_login" id="login_err" style="color:red"></label>
</div>
<div class="name">
<label for="name_login">Username or Email:</label>
<input class='form-control' style='width:60%; margin-bottom:10px;' id="txt_login" name="name_login" type="text" required />
</div>
<div class="pwd">
<label for="password_login">Password:</label>
<input class='form-control' style='width:60%; margin-bottom:10px;' id="password_login" name="password_login" type="password" required />
</div>

<div id="login-submit" style="line-height:25px">
<input name="academy"  type="hidden" value="<?=$org_details['Aca_ID'];?>" />
<input name="shortcode" type="hidden" value="<?=$org_details['Aca_URL_ShortCode'];?>" />
<?php if($ev_id){ ?>
<input name="aca_page" id="aca_page" type="hidden" value="events/<?=$ev_id;?>" />
<?php }
else { ?>
<input name="aca_page" id="aca_page" type="hidden" value="" />
<?php }
?>
<input type="submit" id='submit_web_login' name='submit_web_login'  value="  Login  " style="display:none;" /> 
<input type="button" id='btn_web_login' name='btn_web_login'  value="  Login  " style="padding: 5px 30px;color: #fff;font-weight: bold; margin-top:10px; border:#ff8a00; background-color:#ff8a00" /> 
&nbsp;&nbsp; | <a href="#" id="new_member">New User?</a>&nbsp;&nbsp; 
<?php //if($org_details['Aca_URL_ShortCode'] == 'testclub9' or $org_details['Aca_URL_ShortCode'] == 'sba'){ ?>
| <a href="#" id="forgot_pwd">Forgot Password?</a>
<?php
//}?>
</div>
<!-- <br /> <h4 style="padding-bottom:10px; padding-top:10px">Or...<br /><br />
<div id="phone-login" style="line-height:25px;"> 
<a href="#" id="phone_login" class="btn btn-info" role="button" style="margin-bottom: 20px;background-color: #81a32b;border-color: #81a32b;">
Login with Mobile Number</a>
</div> -->

</div>

<?php
if($login){
$this->session->unset_userdata('redirect_to');
$redirect_to = array('redirect_to' => base_url().$org_details['Aca_URL_ShortCode']);

$this->session->set_userdata($redirect_to);
?>
<!-- <div style="padding-top: 25px;">
<a href="<?php echo $login; ?>"><img src="<?php echo base_url(); ?>icons/facebook.jpg" 
height="40px" width="245px"  /></a><br /><br />
<a href="<?php echo $authUrl; ?>"><img src="<?php echo base_url(); ?>icons/google.jpg" 
height="40px" width="245px" /></a><br /><br />
</div> -->
<?php
}
?>
<!-- <a href="<?php echo base_url();?>Forgot-password">Forgot Password?</a><br><a href="<?php echo base_url(); ?>register/">Register Now!</a> <br> -->

</form>
<!-- Login window content -->

<?php
//$this->load->view("academy_views/view_phone_login_forms");
?>

<?php
if($login){
$this->session->unset_userdata('redirect_to');
$redirect_to = array('redirect_to' => base_url().$org_details['Aca_URL_ShortCode']);

$this->session->set_userdata($redirect_to);
?>
<!-- <div style="padding-top: 25px;">
<a href="<?php echo $login; ?>"><img src="<?php echo base_url(); ?>icons/facebook.jpg" 
height="40px" width="245px"  /></a><br /><br />
<a href="<?php echo $authUrl; ?>"><img src="<?php echo base_url(); ?>icons/google.jpg" 
height="40px" width="245px" /></a><br /><br />
</div> -->
<?php
}
?>
<!-- <a href="<?php echo base_url();?>Forgot-password">Forgot Password?</a><br><a href="<?php echo base_url(); ?>register/">Register Now!</a> <br> -->

</form>
<!-- Login window content -->
<!-- Forgot Password window content -->
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

<!-- Register window content -->
<form id='frm_signup' name='frm_signup' method='POST'  enctype="multipart/form-data"
action='<?=$this->config->item('club_form_url');?>/register/save' style='display:none;'>
<div class='form-group'>
<label class='control-label col-md-4' for='id_accomodation'>First Name * </label>
<input type="text" id="txtfname" name="Firstname" class='form-control' style="width:60%; margin-bottom:10px;" required pattern=".*\S+." />
</div>

<div class='form-group'>
<label class='control-label col-md-4' for='id_accomodation'>Last Name * </label>
<input type="text" id="txtlname" name="Lastname" class='form-control' style="width:60%; margin-bottom:10px;" required pattern=".*\S+." />
</div>

<div class='form-group'>
<label class='control-label col-md-4' for='id_accomodation'>Phone * </label>
<input type="text" id="txtphone" name="Mobilephone" class='form-control' style="width:60%; margin-bottom:10px;" required pattern=".*\S+." />
</div>

<div class='form-group'>
<label class='control-label col-md-4' for='id_accomodation'>Email * </label>
<input type="text" id="txtemail" name="EmailID" class='form-control txt_email' style="width:60%; margin-bottom:10px;" required pattern=".*\S+." />
<span id='email_stat' style='color:red; margin-left:15px;'></span>
</div>

<div class='form-group'>
<label class='control-label col-md-4' for='id_accomodation'>Password: * </label>
<input class='form-control' id="Password" name="Password" type="password" style="width:60%; margin-bottom:10px;" required pattern="\S+" />
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

		$.ajax({
		type:'POST',
		url:club_baseurl+'/academy/get_subscr_list',
		data: {org_id:club_id, is_ajax:1},
			success: function(res) {
				//$('#div_mem_scr').show();
				//alert(res);
				if(res != '')
					$('#mem_plan').append(res);
				else
					$('#div-club-mem').hide();
			}
		});
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
$prv_pol_link	= "Privacy Policy";
//echo $aca_forms['terms_cond']; exit;
if($aca_forms['terms_cond'] != ''){
$terms_link = "<a href='".base_url().'/assets/club_facility/'.$org_details['Aca_ID']."/forms/".
$aca_forms['terms_cond']."' target='_blank'>Terms & Conditions</a>";
}
if($aca_forms['priv_polic'] != ''){
$prv_pol_link = "<a href='".base_url().'/assets/club_facility/'.$org_details['Aca_ID']."/forms/".
$aca_forms['priv_polic']."' target='_blank'>Privacy Policy</a>";
}
?>
I Accept the club <?=$terms_link;?> and <?=$prv_pol_link;?>. 
</label>
</div>

<div id="login-submit" style="line-height:25px; margin-left:33%; margin-top:40px;">
<input name="academy"   type="hidden" value="<?=$org_details['Aca_ID'];?>" />
<input name="shortcode" type="hidden" value="<?=$org_details['Aca_URL_ShortCode'];?>" />
<input name="red_uri" type="hidden" value="<?=$this->config->item('club_pr_url');?>" />
<input name="aca_page" id="aca_page" type="hidden" value="" />

<input type="submit" name='reg_user' value=" Register " style="padding: 5px 30px;color: #fff;font-weight: bold; margin-top:10px; border:#ff8a00; background-color:#ff8a00" /> 
</div>

</form>
<!-- Register window content -->

	</div>
	</div>
</div>
</div>


<script>
$(document).ready(function(){
	$("#login_modal").modal();

	$('#register-as').click(function(){
		var ras = $("input[name='regas']:checked").val();
		
		window.location.replace(baseurl+'register?r='+ras);
	});

$('#new_member').click(function(){

$('#member_login').hide();
$('#frm_signup').show();

});

$('#forgot_pwd').click(function(){

$('#member_login').hide();
$('#frm_signup').hide();
$('#frm_forgot_pwd').show();

});

$('#txtemail').blur(function(){
var baseurl	 = "<?php echo base_url();?>";
var email_id = $(this).val();

if(email_id!=""){
$.ajax({
type:'POST',
url:baseurl+'register/email_check/',
data:'email_id='+email_id,
success:function(html){
var stat = html;
if(stat!=""){
$('#email_stat').html(stat);
$('#txtemail').val("");
$('#txtemail').focus();
}
else {
$('#email_stat').html("");
}
}
}); 
}
});


});
</script>

<!-- ----------------------------------------------------------------------------------------------------------------------------- -->
 <!-- The core Firebase JS SDK is always required and must be listed first -->
<script src="https://www.gstatic.com/firebasejs/7.19.0/firebase-app.js"></script>

<!-- TODO: Add SDKs for Firebase products that you want to use
     https://firebase.google.com/docs/web/setup#available-libraries -->
<!-- <script src="https://www.gstatic.com/firebasejs/7.19.0/firebase-analytics.js"></script> -->
<script defer src="https://www.gstatic.com/firebasejs/7.19.0/firebase-auth.js"></script>
<script src="<?=base_url(); ?>js/custom/phone_login.js"></script>
</body>
</html>