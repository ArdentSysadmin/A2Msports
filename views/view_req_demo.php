<script type="text/javascript">

// Ajax post for refresh captcha image.
$(document).ready(function() {

$("#reload").click(function()	{
	
jQuery.ajax({
type: "POST",
url: "<?php echo base_url(); ?>" + "help/req_captcha_refresh",
success: function(res) {
if(res)
{
jQuery("div.image").html(res);
}
}
});
});
});
</script>

<script>
/*$(document).ready(function(){
    $('#myform').submit(function() {

		//$.session.remove("$_SESSION['captchaWord']");

		var cap_word = "<?php echo $_SESSION['captchaWord'];?>";
		var enter_cap_word = $("#captcha").val();

		alert(cap_word);
		alert(enter_cap_word);

        if((cap_word == $('#captcha').val())){
            return true;
        }
	    else{ 
		  alert("Invalid Captcha entered"); 
		  return false; 
		 }
    });<?php echo base_url(); ?>help/send_email
});*/
</script>

<script>
$(document).ready(function(){
    $('#submit').click(function() {

		var enter_cap_word = $("#captcha").val();
		var logged_user = "<?php echo $this->session->userdata('user'); ?>";

		if(logged_user == ""){
			var name  = $("#txt_name").val();
			var email = $("#txt_email").val();
			var phone = $("#txt_phone").val();
		}
		else{
			var name  = "";
			var email = "";
			var phone = "";
		}

		if(enter_cap_word != ""){

			 $("#submit").hide();
			 $("#loading").show();

			$.ajax({
			  type: "POST",
			  url: "<?php echo base_url(); ?>" + "help/req_demo",
			  //data: {enter_captcha:enter_cap_word},
			  data: $('#req_form').serialize(),
			  success: function(res){
				  //alert(res);
						if(res == "Success"){
							location.href = "<?php echo base_url(); ?>" + "help/thanks";
						}
						else if(res == "UnEqual"){
							$("#loading").hide();
							$("#submit").show();
							alert("Incorrect code entered.");
							return false;
						}
						else {
							$("#loading").hide();
							$("#submit").show();
							alert("Sorry, something went wrong!");
							return false;
						}
					}
			  });
        }
		else{
			alert("Please provide all the details");
			return false;
		}
    });
});
</script>

<style>
img#reload{
cursor: pointer;
}
</style>

<section id="single_player" class="container secondary-page">

<div class="top-score-title right-score col-md-9">
<div class="col-md-12 league-form-bg" style="margin-top:30px;">

<form id="req_form" class='form-horizontal'>        		
<div class="fromtitle">Request a Demo</div>

<?php if($this->session->userdata('users_id') == ""){ ?>

<div class='form-group'>
<label class='control-label col-md-3' for='id_accomodation'>Name </label>
<div class='col-md-6 form-group internal'>
  <input class='form-control' id='txt_name' name='txt_name' type='text' required />
</div>
</div>

<div class='form-group'>
<label class='control-label col-md-3' for='id_accomodation'>Email </label>
<div class='col-md-6 form-group internal'>
  <input class='form-control' id='txt_email' name='txt_email' type='text' required />
</div>
</div>

<div class='form-group'>
<label class='control-label col-md-3' for='id_accomodation'>Phone </label>
<div class='col-md-6 form-group internal'>
  <input class='form-control' id='txt_phone' name='txt_phone'  type='text' required />
</div>
</div>

<?php } ?>

<div class='form-group'>
<label class='control-label col-md-3' for='id_accomodation'>Comments </label>
<div class='col-md-7 form-group internal'>
  <textarea name="txt_comments" class="txt-area" id="txt_comments" cols="20" rows="2" required></textarea>
</div>
</div>

<div class='form-group'>
<label class='control-label col-md-3' for='id_accomodation'>Captcha</label>
 <div class='col-md-7 form-group internal' >
	<div class="image" style="float:left">
	<?php echo $captcha['image']; ?>  
	</div>
	&nbsp;&nbsp;<img id="reload" src="<?php echo base_url();?>images/refresh.png" />
</div>
</div>

 <div class='form-group'>
<label class='control-label col-md-3' for='id_accomodation'>Enter the above Code</label>
<div class='col-md-6 form-group internal'>
  <input type="text" name="txt_captcha" value="" class="form-control" placeholder="" id="txt_captcha" required />
</div>
</div>

<div class='form-group'>
<label class='control-label col-md-3' for='id_accomodation'></label>
<div class='col-md-7 form-group internal'>
  <input type="button" name="req_demo_submit" value=" Submit " class="league-form-submit" id="submit" />
  <div id='loading' style="display:none;">
  <img src='<?php echo base_url();?>images/ajax_loader.gif' width='30px' height='40px' id='' style="display:block;margin-left:10px;" /> Please wait..
  </div>
</div>
</div>

</div>

 </form>
</div><!--Close Top Match--> 