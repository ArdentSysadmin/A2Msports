<script type="text/javascript">

// Ajax post for refresh captcha image.
$(document).ready(function() {

$("#reload").click(function() {
jQuery.ajax({
type: "POST",
url: "<?php echo base_url(); ?>" + "help/captcha_refresh",
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
		var topic = $("#topic").val();
		var desc = $("#des").val();
		
		if(topic != "" && desc != "" && enter_cap_word != ""){

			$.ajax({
			  type: "POST",
			  url: "<?php echo base_url(); ?>" + "help/send_email",
			  data: {enter_captcha:enter_cap_word},
			  success: function(res){
						if(res == "Equal"){
							location.href = "<?php echo base_url(); ?>" + "help/thanks";
						}
						else if(res == "UnEqual"){
							alert("Incorrect code entered.");
							return false;
						}
						else {
							alert("Error!.");
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

		   <form method="post" id="myform" class='form-horizontal'  action=""> 
           		
			<div class="fromtitle">Contact us</div>
			
			<?php if($this->session->userdata('user') ==""){  ?>
	
          <div class='form-group'>
            <label class='control-label col-md-3' for='id_accomodation'>Name </label>
            <div class='col-md-6 form-group internal'>
              <input class='form-control' id='name' name='name' type='text' required>
            </div>
          </div>
          
          <div class='form-group'>
            <label class='control-label col-md-3' for='id_accomodation'>Email </label>
            <div class='col-md-6 form-group internal'>
              <input class='form-control' id='user_email' name='user_email' type='text' required>
            </div>
          </div>
          
          <div class='form-group'>
            <label class='control-label col-md-3' for='id_accomodation'>Phone </label>
            <div class='col-md-6 form-group internal'>
              <input class='form-control' id='phone' name='phone'  type='text' required>
            </div>
          </div>

		<?php } ?>
          
          <div class='form-group'>
            <label class='control-label col-md-3' for='id_accomodation'>Topic </label>
            <div class='col-md-6 form-group internal'>
              <input class='form-control' id='topic' name='topic'  type='text' required>
            </div>
          </div>
          
          <div class='form-group'>
            <label class='control-label col-md-3' for='id_accomodation'>Description</label>
            <div class='col-md-7 form-group internal'>
              <textarea name="des" class="txt-area" id="des" cols="20" rows="2" required></textarea>
            </div>
          </div>
			
		   <div class='form-group'>
		    <label class='control-label col-md-3' for='id_accomodation'>Captcha</label>
			 <div class='col-md-7 form-group internal' >
				<div class="image" style="float:left">
				<?php echo $image; ?>   
				</div>
				&nbsp;&nbsp;<img id="reload" src="<?php echo base_url();?>images/refresh.png">
			
		   </div> 
		   
		  </div>

			 <div class='form-group'>
            <label class='control-label col-md-3' for='id_accomodation'>Enter the above Code</label>
            <div class='col-md-6 form-group internal'>
			  <input type="text" name="captcha" value=""  class="form-control" placeholder="" id="captcha" required>
            </div>
          </div>

			
          <div class='form-group'>
            <label class='control-label col-md-3' for='id_accomodation'></label>
            <div class='col-md-7 form-group internal'>
              <input type="button" id="submit" value="Send" class="league-form-submit"/>
            </div>
          </div>


        </div>

           	 </form>
           </div><!--Close Top Match--> 