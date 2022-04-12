<script>
$(document).ready(function(){


$(document).on('click','.join_now', function(){
	//alert('test');
	
$("#login_modal").modal();
$('#new_member').trigger('click');
});

$(document).on('click','.member_login', function(){
	$('#login_err').html('');
	$("#member_login").trigger('reset');
$('#member_login').show();
$('#frm_signup').hide();

$("#login_modal").modal();
});

$(document).on('click','.reserve-login',function(){
		$('#login_err').html('');
		$("#member_login").trigger('reset');
	$('#aca_page').val('courts/reserve');
	$('#member_login').show();
	$('#frm_signup').hide();

	$("#aca_page").val('courts/reserve');
	$("#login_modal").modal();
});

/*$(document).on('click','#new_member',function(){
$('#member_login').hide();
$('#frm_signup').show();

$("#reg_modal").modal();
}); */

});

</script>

<?php
if(!$this->logged_user){ 
?>
<script>
$(document).ready(function(){
	$(document).on('click', '#user_subscription', function(){
		if($('input[name="c"]:checked').val())
		$('#aca_page').val("subscribe?c="+$('input[name="c"]:checked').val());
		else
		$('#aca_page').val('subscribe');

		$('#member_login').show();
		$('#frm_signup').hide();

		$("#login_modal").modal();
	});
});
</script>
<?php
}
?>


<div class="modal fade" id="login_modal" role="dialog">
<div class="modal-dialog modal-lg">
<div class="modal-content">
<div class="modal-header" style='text-align:center;'>
<!-- Login window content -->
<form id='member_login' method="post" action='<?php echo base_url().$org_details['Aca_URL_ShortCode']; ?>/login/verify_user'>
<!-- <form id='member_login' method="post" action='<?php //echo base_url(); ?>/login/verify_user' class="login-form" style='margin-left:20px;' > --> 
<div class="name" align='left'>
<label for="name_login" id="login_err" style="color:red"></label>
</div>
<div class="name">
<label for="name_login">Username (or) Email</label><br />
<input class='form-control' style='width:60%; margin-bottom:10px; display:inline-block;' id="txt_login" name="name_login" type="text" required />
</div>
<div class="pwd">
<label for="password_login">Password</label><br />
<input class='form-control' style='width:60%; margin-bottom:10px; display:inline-block;' id="password_login" name="password_login" type="password" required />
</div>

<div id="login-submit" style="line-height:25px">
<input name="academy"  type="hidden" value="<?=$org_details['Aca_ID'];?>" />
<input name="shortcode" type="hidden" value="<?=$org_details['Aca_URL_ShortCode'];?>" />
<input name="aca_page" id="aca_page" type="hidden" value="" />

<input type="submit" id='submit_web_login' name='submit_web_login'  value="  Login  " style="display:none;" /> 
<input type="button" id='btn_web_login' name='btn_web_login'  value="  Login  " style="padding: 5px 30px;color: #fff;font-weight: bold; margin-top:10px; border:#ff8a00; background-color:#ff8a00" /> 
&nbsp;&nbsp; | <a href="#" id="new_member">New User?</a>&nbsp;&nbsp; 
<?php //if($org_details['Aca_URL_ShortCode'] == 'testclub9' or $org_details['Aca_URL_ShortCode'] == 'sba'){ ?>
| <a href="#" id="forgot_pwd">Forgot Password?</a>
<?php
//}
?>
<br /> <br /> <h4 style="padding-bottom:10px; padding-top:10px">OR<br /><br />
<div id="phone-login" style="line-height:25px;"> 
<a href="#" id="phone_login" class="btn btn-info" role="button" style="margin-bottom: 20px;background-color: #81a32b;border-color: #81a32b;color:#fff; text-transform:none;">
Login with Mobile Number</a>
</div> 

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
$this->load->view("academy_views/view_phone_login_forms");
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

<!-- Register window content -->
<!-- <form id='frm_signup' name='frm_signup' method='POST'  enctype="multipart/form-data" action='<?=$this->config->item('club_form_url');?>/register/save' style='display:none;'> -->

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
	var base_url = "<?php echo base_url(); ?>";
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
		url:base_url+'academy/get_subscr_list',
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

<div id="login-submit" style="line-height:25px; margin-top:40px;">
<input name="academy"   type="hidden" value="<?=$org_details['Aca_ID'];?>" />
<input name="shortcode" type="hidden" value="<?=$org_details['Aca_URL_ShortCode'];?>" />
<input name="red_uri" type="hidden" value="<?=$this->config->item('club_pr_url');?>" />
<input name="aca_page" id="aca_page" type="hidden" value="" />

<input type="submit" name='reg_user' value=" Register " style="padding: 5px 30px;color: #fff;font-weight: bold; margin-top:10px; border:#ff8a00; background-color:#ff8a00" /> 
</div>

</form>
<input type='hidden' name='temp_uid'		  id='temp_uid'		value='' />
<input type='hidden' name='temp_email'	  id='temp_email'	value='' />

<!-- Register window content -->
</div>
</div>
</div>
</div>

<input type='button' name='btn_frg_success' id='btn_frg_success' style='display:none;' />

<div class="modal fade" id="frg_success_modal" role="dialog">
<div class="modal-dialog modal-lg">
	<div class="modal-content">
	<div class="modal-header">

		<div style='margin-bottom:25px;'>
		<?php echo $this->session->flashdata('frg_pwd_msg'); 
		//unset($this->session->flashdata('frg_pwd_msg'));
		?></div>

	</div>
	</div>
</div>
</div>

<script>
$(document).ready(function(){
$('#new_member').click(function(){
//alert('test2');
$('#member_login').hide();
$('#frm_signup').show();

});

$('#forgot_pwd').click(function(){

$('#member_login').hide();
$('#frm_signup').hide();
$('#frm_forgot_pwd').show();

});

$(document).on('click', '#reset_pwd', function() {
	var baseurl	= "<?php echo base_url();?>";
	var red_url	= "<?php echo $this->config->item('club_pr_url');?>";

	var email_id = $('#temp_email').val();
	var uid			= $('#temp_uid').val();
	$('#reset_pwd').html("Please wait...");
if(email_id && uid){
	$.ajax({
	type:'POST',
	url:baseurl+'login/reset_email_pwd',
	data:{req_email:email_id, user:uid},
	success:function(res){
		if(res){
			alert("Reset Password link sent to your email.")
			window.location.replace(red_url);
		}
		else{
			alert("Something wrong! please try after some time.");
			$('#reset_pwd').html("<b>Reset Password</b> ?");
		}
	}
	}); 
}

});


$('#txtemail').blur(function(){
var baseurl	= "<?php echo base_url();?>";
var email_id = $(this).val();

if(email_id != ""){
$.ajax({
type:'POST',
url:baseurl+'register/ajax_email_verify/',
data:'email_id='+email_id,
success:function(html){
var stat = html;
		if(stat!=""){
			var sp = stat.split('-');
			$('#email_stat').html(sp[1] + " already exists! want to <a id='reset_pwd' style='cursor:pointer;'><b>Reset Password</b>?</a>");
			//$('#email_stat').html(stat);
			$('#temp_uid').val(sp[0]);
			$('#temp_email').val(sp[1]);

			$('#EmailID').val("");
		}
		else {
			$('#email_stat').html("");
			$('#temp_uid').val('');
			$('#temp_email').val('');
		}

}
}); 
}
});

//$('#email_stat').html('');
$('#member_login').on('keyup keypress', function(e) {
  var keyCode = e.keyCode || e.which;
  //alert(keyCode);
  if (keyCode === 13) { 
	  $("#btn_web_login").trigger('click');
    e.preventDefault();
    return false;
  }
});

});

//$('#member_login').submit(function(){
//$('#submit_web_login').click(function(){
$("#btn_web_login").click(function(e){

	var email	= $('#txt_login').val();
	var pwd		= $('#password_login').val();
	var baseurl = "<?php echo base_url(); ?>";

	$('#login_err').html('');

	//if(email && pwd){
			$.ajax({
			type:'POST',
			//url:baseurl+'login/ajax_validate_login/',
			url:base_url+'/login/ajax_validate_login',
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

//var err = "<?php if($this->session->flashdata('err_msg') != '') echo 1; ?>";

	//if(err == '1'){
		//$('.member_login').trigger('click');
		//$("#login_modal").modal('show');
		//alert("<?php echo $this->session->flashdata('err_msg'); ?>");
	//} 
//$(".member_login").modal('show');
//});
</script>
<script>
$(document).ready(function(){
	$(document).on('click','#btn_frg_success',function(){
		//alert('test');
		$("#frg_success_modal").modal();
	});
});
</script>
<?php
if($this->session->flashdata('frg_pwd_msg3333')){
?>
<script>
$(document).ready(function(){
	var al = "<php echo $this->session->flashdata('frg_pwd_msg'); ?>";
	alert("Password reset link has been sent to your email..");
	//$('#btn_frg_success').trigger('click');
});
</script>
<?php
//$this->session->unset_flashdata('frg_pwd_msg')
}
?>

<!-- ----------------------------------------------------------------------------------------------------------------------------- -->
 <!-- The core Firebase JS SDK is always required and must be listed first -->
<script src="https://www.gstatic.com/firebasejs/7.19.0/firebase-app.js"></script>

<!-- TODO: Add SDKs for Firebase products that you want to use
     https://firebase.google.com/docs/web/setup#available-libraries -->
<!-- <script src="https://www.gstatic.com/firebasejs/7.19.0/firebase-analytics.js"></script> -->
<script defer src="https://www.gstatic.com/firebasejs/7.19.0/firebase-auth.js"></script>
<script src="<?=base_url(); ?>js/custom/phone_login.js"></script>
