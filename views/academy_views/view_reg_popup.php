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

<script>
$(document).ready(function(){
	
	$("#login_modal").modal();
	
	$('#ok_btn').click(function(){
		window.location.replace(baseurl);
	});
});
</script>

</body>
</html>