<html>
<head>
<link href="<?php echo base_url();?>css/bootstrap.css" rel="stylesheet" type="text/css"/>
<link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css" />
<script src="https://code.jquery.com/jquery-1.10.2.min.js" type="text/javascript"></script>
<script src="<?php echo base_url();?>js/bootstrap.min.js"></script>
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
</head>
<body>
<link href="<?php echo base_url(); ?>assets/club_pages/assets/css/popup.css" rel="stylesheet">

<script>
var baseurl = "<?php echo $this->config->item('club_pr_url'); ?>";
var shrt = "<?php echo $org_details['Aca_URL_ShortCode']; ?>";

</script>

<div class="modal fade" id="login_modal" role="dialog">
<div class="modal-dialog modal-lg mobile-modal-dialog">
	<div class="modal-content">
	<div class="modal-header" style='border:0px;'>
<!-- Login window content -->
<form>
	<div style='margin-bottom:5px;'>
	<h5><b>Registration success. Please activate your account by clicking link activation link </b></h5>
	</div>

	<div style='margin-bottom:25px;'>
	<h5><b>that sent to your registered email address. Thank you.</b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type='button' id='ok_btn' value=' Ok ' /></h5>
	</div>
</form>
<!-- Login window content -->
	</div>
	</div>
</div>
</div>


<div class="modal fade" id="act_modal" role="dialog">
<div class="modal-dialog modal-lg mobile-modal-dialog">
	<div class="modal-content">
	<div class="modal-header" style='border:0px;'>
<!-- Login window content -->
<form>
	<div style='margin-bottom:5px;'>
	<h5><b>Account is activated successfully. Please login with your credentials. Thank you </b> &nbsp;&nbsp;&nbsp;&nbsp;<input type='button' id='act_ok_btn' value=' Ok ' /></h5>
	</div>
</form>
<!-- Login window content -->
	</div>
	</div>
</div>
</div>

<div class="modal fade" id="upd_pwd_modal" role="dialog">
<div class="modal-dialog modal-lg mobile-modal-dialog">
	<div class="modal-content">
	<div class="modal-header" style='border:0px;'>
<!-- Login window content -->
<form>
	<div style='margin-bottom:5px;'>
	<h5><b>Password updated successfully. Please login with your credentials. Thank you </b> &nbsp;&nbsp;&nbsp;&nbsp;<input type='button' id='upd_pwd_ok_btn' value=' Ok ' /></h5>
	</div>
</form>
<!-- Login window content -->
	</div>
	</div>
</div>
</div>


<div class="modal fade" id="fr_pwd_modal" role="dialog">
<div class="modal-dialog modal-lg mobile-modal-dialog">
	<div class="modal-content">
	<div class="modal-header" style='border:0px;'>
<!-- Login window content -->
<form>
	<div style='margin-bottom:5px;'>
	<h5><b>Password reset link has sent to your email. Thank you</b>
	&nbsp;&nbsp;&nbsp;&nbsp;<input type='button' id='fr_pwd_ok_btn' value=' Ok ' /></h5>
	</div>
</form>
<!-- Login window content -->
	</div>
	</div>
</div>
</div>


<?php
if($pg == '1'){
?>
<script>
$(document).ready(function(){
	$("#login_modal").modal();
	$('#ok_btn').click(function(){
		window.location.replace(baseurl);
	});
});
</script>
<?php
}
else if($pg == '2'){
?>
<script>
$(document).ready(function(){
	$("#act_modal").modal();
	$('#act_ok_btn').click(function(){
		window.location.replace(baseurl);
	});
});
</script>
<?php
}
else if($pg == '3'){
?>
<script>
$(document).ready(function(){
	$("#upd_pwd_modal").modal();
	$('#upd_pwd_ok_btn').click(function(){
		window.location.replace(baseurl);
	});
});
</script>
<?php
}
else if($pg == '4'){
?>
<script>
$(document).ready(function(){
	$("#fr_pwd_modal").modal();
	$('#fr_pwd_ok_btn').click(function(){
		window.location.replace(baseurl);
	});
});
</script>
<?php
}
?>
</body>
</html>