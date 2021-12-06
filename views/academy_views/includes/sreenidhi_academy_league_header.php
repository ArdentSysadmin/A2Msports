<?php
$cur_class	= $this->router->class; 
if(!$this->logged_user){
$login			= $cur_class::get_fb_login();
$authUrl		= $cur_class ::get_google_login();
}
$club_menu	= $cur_class :: get_club_menu($org_details['Aca_ID']);
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<?php
if($this->is_league_page OR $noIndex){
?>
<meta name="ROBOTS" content="NOINDEX, NOFOLLOW" />
<?php
}
?>
<meta name="viewport" content="width=device-width, initial-scale=1">
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


<?php
//echo "test"; exit;
if($is_academy_league){
?>

<link href="<?php echo base_url();?>css/fonts/font-awesome-4.1.0/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
<!--Clients-->

<link href="<?php echo base_url();?>css/jquery.bxslider.css"		rel="stylesheet" type="text/css" />
<link href="<?php echo base_url();?>css/jquery.jscrollpane.css"  rel="stylesheet" type="text/css" />

<link href="<?php echo base_url();?>css/minislide/flexslider.css" rel="stylesheet" type="text/css" />
<link href="<?php echo base_url();?>css/component.css"			rel="stylesheet" type="text/css" />
<link href="<?php echo base_url();?>css/prettyPhoto.css"			rel="stylesheet" type="text/css" />
<link href="<?php echo base_url();?>css/style_dir.css"				rel="stylesheet" type="text/css" />
<link rel="shortcut icon" type="image/png" href="<?php echo base_url(); ?>org_logos/<?php echo $org_details['Aca_logo']; ?>" />
<link href="<?php echo base_url();?>css/responsive.css"			rel="stylesheet" type="text/css" />
<link href="<?php echo base_url();?>css/animate.css"				rel="stylesheet" type="text/css" />
<link href="<?php echo base_url();?>css/tabs.css"						rel="stylesheet" type="text/css" />
<link href="<?php echo base_url();?>css/jquery.datepick.css"		rel="stylesheet" type="text/css" />
<link href="<?php echo base_url();?>css/bootsnav.css"				rel="stylesheet" />

<link href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css" rel="stylesheet" />
<?php
}
?>
<!-- Copied from old header file -->
<script src="https://code.jquery.com/jquery-1.11.1.min.js"></script> 
<script src="https://jqueryvalidation.org/files/dist/jquery.validate.min.js"></script>
<script src="https://jqueryvalidation.org/files/dist/additional-methods.min.js"></script>
<!-- end -->

<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
<!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
<script>
/*
var isMobile = false; //initiate as false
// device detection
if(/(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|ipad|iris|kindle|Android|Silk|lge |maemo|midp|mmp|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows (ce|phone)|xda|xiino/i.test(navigator.userAgent) 
    || /1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i.test(navigator.userAgent.substr(0,4))) { 
    isMobile = true;
}
//alert(isMobile);

if(isMobile){
var pathname = window.location.pathname; // Returns path only (/path/example.html)
var url      = window.location.href;						// Returns full URL (https://example.com/path/example.html)
var origin   = window.location.origin;				// Returns base URL (https://example.com)

    var path = window.location.pathname.split("/");
	if(path[1] == 'league'){
	alert("a2msports:/"+ path[1]+"/"+path[2] );
    window.location.href = "a2msports:/"+ path[1]+"/"+path[2] ;

	setTimeout(function(){ window.location.href = window.location.origin+path }, 2000);
	}
} */
</script>
<script>
var club_baseurl = "<?php echo $this->config->item('club_pr_url'); ?>";
</script>
</head>
<body>
<!-- Pre Loader -->
<div id="dvLoading"></div>
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
<?php
if(!in_array('8', $club_menu)){ ?>
<li><a href="<?php echo base_url().$org_details['Aca_URL_ShortCode']; ?>/about-us">About Us</a></li>
<li><a href="<?php echo base_url().$org_details['Aca_URL_ShortCode']; ?>/#our_programs">Programs</a></li>
<?php 
}


if(!in_array('1', $club_menu)){ ?>
<li><a href="<?php echo base_url().$org_details['Aca_URL_ShortCode']; ?>/events">Events</a></li>
<?php
}
?>
<li class="dropdown dropdown-toggle">
<a href="#">SNSA TV <i class="fa fa-angle-down"></i></a>
	<ul class="dropdown-menu">
	<li><a href="/news">News</a></li>
	<li><a href="https://www.youtube.com/channel/UCNyZ7mlc_JB1QRbLggrduZQ" target='_blank'>Training Series</a></li>
	<li><a href="<?php echo base_url().$org_details['Aca_URL_ShortCode']; ?>/#">Press & Media</a></li> 
	<li><a href="/facility#gallery">Gallery</a></li> 
	</ul>
</li>
<?php
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
<li><a href="<?php echo base_url().$org_details['Aca_URL_ShortCode']; ?>/settings">Settings</a></li>
<?php
}?>
<li><a href="<?php echo base_url().'profile'; ?>">A2M Profile</a></li>
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
<?php 
if($org_details['Aca_URL_ShortCode'] == 'sreenidhi'){
	if(!in_array('8', $club_menu)){ ?>
<li><a href="<?php echo base_url().$org_details['Aca_URL_ShortCode']; ?>/about-us">About Us</a></li>
<li><a href="<?php echo base_url().$org_details['Aca_URL_ShortCode']; ?>/#our_programs">Programs</a></li>
<?php 
	}
}
else{
	if(!in_array('8', $club_menu)){
?>
<li><a href="<?php echo base_url().$org_details['Aca_URL_ShortCode']; ?>/facility">About Us</a></li>
<?php
	}
}
if(!in_array('1', $club_menu)){ ?>
<li><a href="<?php echo base_url().$org_details['Aca_URL_ShortCode']; ?>/events">Events</a></li>
<?php
}
?>
<li><a href="#">SNSA TV</a>
	<ul>
	<li style="padding-left:10px;"><a href="/news">News</a></li>
	<li style="padding-left:10px;"><a href="https://www.youtube.com/channel/UCNyZ7mlc_JB1QRbLggrduZQ" target='_blank'>Training Series</a></li>
	<li style="padding-left:10px;"><a href="<?php echo base_url().$org_details['Aca_URL_ShortCode']; ?>/#">Press & Media</a></li> 
	<li style="padding-left:10px;"><a href="/facility#gallery">Gallery</a></li> 
	</ul>
</li>
<?php
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
	<?php 
	//echo "test"; exit;
	/*if($this->logged_user == $this->academy_admin) {
	?>
	<li><a href="<?php echo base_url().$org_details['Aca_URL_ShortCode']; ?>/settings">Settings</a></li>
	<?php
	}*/?>
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
</nav>
<!-- Navigation End --> 

<script>
$(document).ready(function(){
$(document).on('click','.member_login',function(){
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


<div class="modal fade" id="login_modal" role="dialog">
<div class="modal-dialog modal-lg">
<div class="modal-content">
<div class="modal-header">
<!-- Login window content -->
<form id='member_login' method="post" action='<?php echo base_url().$org_details['Aca_URL_ShortCode']; ?>/login/verify_user'  style='margin-left:20px;' >
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

<input type="submit" id='submit_web_login' name='submit_web_login'  value="  Login  " style="display:none;" /> 
<input type="button" id='btn_web_login' name='btn_web_login'  value="  Login  " style="padding: 5px 30px;color: #fff;font-weight: bold; margin-top:10px; border:#ff8a00; background-color:#ff8a00" /> 

&nbsp;&nbsp; | <a href="#" id="new_member">New User?</a>&nbsp;&nbsp; 
<?php //if($org_details['Aca_URL_ShortCode'] == 'testclub9' or $org_details['Aca_URL_ShortCode'] == 'sba'){ ?>
| <a href="#" id="forgot_pwd">Forgot Password?</a>
<?php
//}
?>
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
$this->load->view("academy_views/view_phone_login_forms");
?>
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
//alert(club_baseurl);
var club_baseurl = "<?php echo $this->config->item('club_pr_url'); ?>";

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


<div id="login-submit" style="line-height:25px; margin-left:33%;">
<input name="academy"  type="hidden" value="<?=$org_details['Aca_ID'];?>" />
<input name="shortcode" type="hidden" value="<?=$org_details['Aca_URL_ShortCode'];?>" />
<input name="red_uri" type="hidden" value="<?=$this->config->item('club_pr_url');?>" />

<input name="aca_page" id="aca_page" type="hidden" value="" />
<input type="submit" name='reg_user' value=" Register " style="padding: 5px 30px;color: #fff;font-weight: bold; margin-top:10px; border:#ff8a00; background-color:#ff8a00" /> 
</div>

</form>
<input type='hidden' name='temp_uid'		id='temp_uid'	 value='' />
<input type='hidden' name='temp_email'	id='temp_email' value='' />

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

$('#member_login').hide();
$('#frm_signup').show();

});


$('#forgot_pwd').click(function(){

$('#member_login').hide();
$('#frm_signup').hide();
$('#frm_forgot_pwd').show();

});

$(document).on('click', '#reset_pwd', function() {
	var baseurl = "<?php echo base_url();?>";
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
var baseurl = "<?php echo base_url();?>";
var email_id = $(this).val();

if(email_id!=""){
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
if($this->session->flashdata('frg_pwd_msg')){
?>
<script>
$(document).ready(function(){
	var al = "<php echo $this->session->flashdata('frg_pwd_msg'); ?>";
	alert("Password reset link has been sent to your email.");
	//$('#btn_frg_success').trigger('click');
});
</script>
<?php
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