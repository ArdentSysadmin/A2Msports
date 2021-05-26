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
var baseurl = "<?php echo base_url(); ?>";
</script>

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
<br /><span style='margin-left: 18px;'><i>Schedule your classes and communicate with players </i><span>
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


<script>
$(document).ready(function(){
	$("#login_modal").modal();

	$('#register-as').click(function(){
		var ras = $("input[name='regas']:checked").val();
		
		window.location.replace(baseurl+'register?r='+ras);
	});
});
</script>
</body>
</html>