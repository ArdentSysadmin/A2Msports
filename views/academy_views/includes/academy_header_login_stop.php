<?php 
/*echo $this->session->userdata('user'); 
echo $this->session->userdata('users_id'); 
exit;*/
//error_reporting(-1);
//echo "test";exit;
$cur_class	= $this->router->class; 
if(!$this->logged_user){
	$login		 = $cur_class :: get_fb_login();
	$authUrl = $cur_class :: get_google_login();
}
$club_menu = $cur_class :: get_club_menu($org_details['Aca_ID']);
//echo '<pre>'; print_r($get_club_menu);
//echo $org_details['Aca_ID']; exit;
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta http-equiv="content-type" content="text/html; charset=utf-8">
<title><?=$org_details['Aca_name'];?></title>
<!-- Bootstrap CSS -->
<link href="<?php echo base_url(); ?>css/bootstrap.css" rel="stylesheet">
<!-- Font Awesome CSS-->
<link href="<?php echo base_url(); ?>assets/club_pages/assets/font-awesome/css/font-awesome.min.css" rel="stylesheet">
<!-- Animate CSS -->
<link href="<?php echo base_url(); ?>assets/club_pages/assets/animate/animate.css" rel="stylesheet">
<!-- Mobile Menu Css -->
<link href="<?php echo base_url(); ?>assets/club_pages/assets/css/slicknav.css" rel="stylesheet">
<!-- Owl Carousel -->
<link href="<?php echo base_url(); ?>assets/club_pages/assets/owl-carousel/css/owl.carousel.css" rel="stylesheet">
<link href="<?php echo base_url(); ?>assets/club_pages/assets/owl-carousel/css/owl.theme.css" rel="stylesheet">
<!-- Magnific Popup Css -->
<link href="<?php echo base_url(); ?>assets/club_pages/assets/css/popup.css" rel="stylesheet">
<!-- Custom CSS -->
<link href="<?php echo base_url(); ?>assets/club_pages/css/style.css?ver2" rel="stylesheet">

<link href="<?php echo base_url();?>css/jquery.autocomplete.css" rel="stylesheet">
<link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css" />
<link rel="shortcut icon" type="image/png" href="<?php echo base_url(); ?>org_logos/<?php echo $org_details['Aca_logo']; ?>" />

<?php // style="color:#ef0000;" ?>
<!-- Copied from old header file -->
<script src="https://code.jquery.com/jquery-1.11.1.min.js"></script> 
<script src="https://jqueryvalidation.org/files/dist/jquery.validate.min.js"></script>
<script src="https://jqueryvalidation.org/files/dist/additional-methods.min.js"></script>

<!-- <script src="<?php echo base_url(); ?>assets/club_pages/assests/jquery/jquery-1.11.1.min.js"></script> 
<script src="<?php echo base_url(); ?>assets/club_pages/js/jquery.validate.min.js"></script>
<script src="<?php echo base_url(); ?>assets/club_pages/js/additional-methods.min.js"></script> -->

<!-- end -->

<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
<!--[if lt IE 9]>
<script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
<![endif]-->
<script>
var club_baseurl = "<?php echo $this->config->item('club_form_url'); ?>";
</script>
</head>
<body>
<!-- Pre Loader -->
<!-- <div id="dvLoading"></div> -->
<!-- Header Start -->
<header>
<!-- Navigation Start -->

<nav class="navbar navbar-default main-navigation affix-top" data-offset-top="197" data-spy="affix">
<div class="">
<div class="navbar-header">
<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false"> 
<span class="sr-only">Toggle navigation</span> <span class="icon-bar"></span> 
<span class="icon-bar"></span> <span class="icon-bar"></span> 
</button>
<a class="navbar-brand logotext" href="<?php echo base_url().$org_details['Aca_URL_ShortCode']; ?>">
<img src="<?php echo base_url(); ?>org_logos/<?php echo $org_details['Aca_logo']; ?>" style="width:auto; height:55px;" alt="">
<?php echo addslashes(mb_strtoupper($org_details['Aca_name'])); ?>
</a></div>
<div class="collapse navbar-collapse" id="navbar">
<ul class="nav navbar-nav navbar-right">
<?php if(!in_array('8', $club_menu)){ ?>
<li><a href="<?php echo base_url().$org_details['Aca_URL_ShortCode']; ?>/facility">About Us</a></li>
<?php 
}
if(!in_array('1', $club_menu)){ ?>
<li><a href="<?php echo base_url().$org_details['Aca_URL_ShortCode']; ?>/events">Events</a></li>
<?php
}
if(!in_array('2', $club_menu)){ ?>
<li><a href="<?php echo base_url().$org_details['Aca_URL_ShortCode']; ?>/coaches">Coaches</a></li>
<?php
}
if(!in_array('3', $club_menu)){ ?>
<li><a href="<?php echo base_url().$org_details['Aca_URL_ShortCode']; ?>/pricing">Pricing</a></li>
<?php
}
?>
<?php 
/*echo $this->logged_user." - ".$this->academy_admin;
exit;*/
if($this->academy_admin and ($this->logged_user == $this->academy_admin)){
?>
<li><a href="<?php echo base_url().$org_details['Aca_URL_ShortCode']; ?>/courts/list">Add/Edit Courts</a></li>
<?php
}
?>

<?php
if($this->session->userdata('user') != "" and !in_array('5', $club_menu)) {
?>
<li><a href="<?php echo base_url().$org_details['Aca_URL_ShortCode']; ?>/courts/reserve">Reserve</a></li>
<?php
}
else if(!in_array('5', $club_menu)){
?>
<li><a href="#" class='reserve-login'>Reserve</a></li>
<?php
}
if(!in_array('6', $club_menu)){ 
?>
<li><a href="<?php echo base_url().$org_details['Aca_URL_ShortCode']; ?>/#contact">Contact</a></li>
<?php
}
?>
<?php
if(!in_array('7', $club_menu) or  
!in_array('9', $club_menu) or 
!in_array('10', $club_menu) or 
!in_array('11', $club_menu)){
?>
<li class="dropdown dropdown-toggle">
<a href="<?php echo base_url().$org_details['Aca_URL_ShortCode']; ?>/#about">More <i class="fa fa-angle-down"></i></a>

	<ul class="dropdown-menu">
<?php
	if(!in_array('9', $club_menu)){ ?>
	<li><a href="<?php echo base_url().$org_details['Aca_URL_ShortCode']; ?>/members">Members</a></li>
	<?php
	}
	//if($org_details['Aca_ID'] == '1123'){ ?>
	<!-- <li>
	<a href="<?php echo base_url().$org_details['Aca_URL_ShortCode']; ?>/subscribe">Subscribe</a>
	</li> -->
	<?php
	//}
	if(!in_array('10', $club_menu)){ ?>
	<li><a href="<?php echo base_url().$org_details['Aca_URL_ShortCode']; ?>/news">News</a></li>
	<?php 
	}
	if(!in_array('11', $club_menu)){ ?>
	<li><a href="<?php echo base_url().$org_details['Aca_URL_ShortCode']; ?>/proshop">Pro Shop</a></li> 
	<?php
	}
	?>
	</ul>
</li>
<?php
}
?>

<?php
//echo "<pre>"; print_r($this->session); exit;
//echo "test".$this->session->userdata('user');
if($this->session->userdata('user') != "") {?>
<li class="dropdown dropdown-toggle">
<a>
<?php 
$get_fname = explode(' ', $this->session->userdata('user'));
echo $get_fname[0];
?>
<i class="fa fa-angle-down"></i>
</a>
<ul class="dropdown-menu" style="right: 0;left: auto;">
<?php 
if($this->logged_user == $this->academy_admin) {
?>
<li>
<a href="<?php echo base_url().$org_details['Aca_URL_ShortCode']; ?>/settings">Settings</a>
</li>
<?php 
//if($this->logged_user == 237 or $this->logged_user == 240) {
?>
<li>
<a href="<?php echo base_url().$org_details['Aca_URL_ShortCode']; ?>/memberships">Memberships</a>
</li>
<?php
//}
}?>
<li><a href="<?php echo base_url().$org_details['Aca_URL_ShortCode']; ?>/subscribe">Subscribe</a></li>
<li><a href="<?php echo base_url().'profile'; ?>" target='_blank'>A2M Profile</a></li>
<li><a href="<?php echo base_url().$org_details['Aca_URL_ShortCode']; ?>/logout">Logout</a></li>
</ul>
</li>
<?php
}
else {
?>
<li><a href="#" class="member_login">Login</a></li>
<?php
}
?>

</ul>
</div>
<ul class="wpb-mobile-menu">
<?php if(!in_array('8', $club_menu)){ ?>
<li><a href="<?php echo base_url().$org_details['Aca_URL_ShortCode']; ?>/facility">About Us</a></li>
<?php 
}
if(!in_array('1', $club_menu)){ ?>
<li><a href="<?php echo base_url().$org_details['Aca_URL_ShortCode']; ?>/events">Events</a></li>
<?php
}
if(!in_array('2', $club_menu)){ ?>
<li><a href="<?php echo base_url().$org_details['Aca_URL_ShortCode']; ?>/coaches">Coaches</a></li>
<?php
}
if(!in_array('3', $club_menu)){ ?>
<li><a href="<?php echo base_url().$org_details['Aca_URL_ShortCode']; ?>/pricing">Pricing</a></li>
<?php
}
?>
<?php
if($this->session->userdata('user') != "" and !in_array('5', $club_menu)) {
?>
<li><a href="<?php echo base_url().$org_details['Aca_URL_ShortCode']; ?>/courts/reserve">Reserve</a></li>
<?php
}
else if(!in_array('5', $club_menu)){
?>
<li><a href="#" class='reserve-login'>Reserve</a></li>
<?php
}
if(!in_array('6', $club_menu)){ 
?>
<li><a href="<?php echo base_url().$org_details['Aca_URL_ShortCode']; ?>/#contact">Contact</a></li>
<?php
}
?>
<?php
if(!in_array('7', $club_menu) or 
!in_array('9', $club_menu) or 
!in_array('10', $club_menu) or 
!in_array('11', $club_menu)){
?>
<li><a href="<?php echo base_url().$org_details['Aca_URL_ShortCode']; ?>/#about">More</a>
<!-- <i class="fa fa-angle-down"></i> --></a>
	<ul>
		<?php
	if(!in_array('9', $club_menu)){ ?>
	<li style="padding-left:10px;"><a href="<?php echo base_url().$org_details['Aca_URL_ShortCode']; ?>/members">Members</a></li>
	<?php
	}
	if(!in_array('10', $club_menu)){ ?>
	<li style="padding-left:10px;"><a href="<?php echo base_url().$org_details['Aca_URL_ShortCode']; ?>/news">News</a></li>
	<?php 
	}
	if(!in_array('11', $club_menu)){ ?>
	<li style="padding-left:10px;"><a href="<?php echo base_url().$org_details['Aca_URL_ShortCode']; ?>/proshop">Pro Shop</a></li>
	<?php
	}
	?>
	</ul>
</li>
<?php
}
?>

<?php
if($this->session->userdata('user') != "") {?>
<li class="dropdown dropdown-toggle">
<a>
<?php 
$get_fname = explode(' ', $this->session->userdata('user'));
echo $get_fname[0];
?>
<!-- <i class="fa fa-angle-down"></i> -->
</a>
<ul>
<li><a href="<?php echo base_url().$org_details['Aca_URL_ShortCode']; ?>/logout">Logout</a></li>
</ul>
</li>
<?php
}
else {
?>
<li><a href="#" class="member_login">Login</a></li>
<?php
}
?>

</ul>
</div>
</nav>
<!-- Navigation End --> 

<script>
$(document).ready(function(){

$(document).on('click','.member_login',function(){
$('#member_login').show();
$('#frm_signup').hide();

$("#login_modal").modal();
});

$(document).on('click','.reserve-login',function(){
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
<div class="modal-header">
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
<input name="aca_page" id="aca_page" type="hidden" value="" />

<input type="submit" id='submit_web_login' name='submit_web_login'  value="  Login  " style="padding: 5px 30px;color: #fff;font-weight: bold; margin-top:10px; border:#ff8a00; background-color:#ff8a00" onclick="return valid_lo();" /> 
&nbsp;&nbsp; | <a href="#" id="new_member">New User?</a>
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

<div id="login-submit" style="line-height:25px; margin-left:33%; margin-top:40px;">
<input name="academy"  type="hidden" value="<?=$org_details['Aca_ID'];?>" />
<input name="shortcode" type="hidden" value="<?=$org_details['Aca_URL_ShortCode'];?>" />
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
$('#new_member').click(function(){

$('#member_login').hide();
$('#frm_signup').show();

});

$('#txtemail').blur(function(){
var baseurl = "<?php echo base_url();?>";
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

//$('#email_stat').html('');
});

//$('#member_login').submit(function(){
//$('#submit_web_login').click(function(){
function valid_lo(){

	var email	= $('#txt_login').val();
	var pwd		= $('#password_login').val();
	var baseurl = "<?php echo base_url(); ?>";

	$('#login_err').html('');

	//if(email && pwd){
			return $.ajax({
			type:'POST',
			url:baseurl+'login/ajax_validate_login/',
			data: {name_login: email, password_login: pwd},
			//context: this,
			success:function(html){
				if(html == '-1'){
					$('#login_err').html('Email Activation not done!');
					false;
				}
				else if(html == '-2'){
					$('#login_err').html('Invalid Login!');
					false;
				}
				else if(html == '1'){
					//alert('test');
					//$('#txt_login').val(email);
					//$('#password_login').val(pwd);
					//$('#member_login').submit();
					true;
				}
			}
			});

//	return false;
}

//var err = "<?php if($this->session->flashdata('err_msg') != '') echo 1; ?>";

	//if(err == '1'){
		//$('.member_login').trigger('click');
		//$("#login_modal").modal('show');
		//alert("<?php echo $this->session->flashdata('err_msg'); ?>");
	//} 
//$(".member_login").modal('show');
//});
</script>
<?php
//if($this->session->flashdata('err_msg') != ""){
   // unset($this->session->flashdata('err_msg'));
//   $this->session->sess_destroy();
//}
//$this->session->unset_flashdata('err_msg');
?>