

<script type="text/javascript">

$(document).ready(function(){

$('input[name=confirm_upd_password]').blur(function() {
    var pass = $('#upd_password').val();
    var repass = $('#confirm_upd_password').val();
	//alert(pass+ ' '+repass);
    if(($('input[name=upd_password]').val().length == '') || ($('input[name=confirm_upd_password]').val().length == '')) {
        ///$('#Password').addClass('has-error');
    }
    else if (pass != repass) {
		$( ".err" ).show();
		$('#confirm_upd_password').val("");
    }
    else {
		$( ".err" ).hide();
    }

});

});
</script>

<div class='container'>
<div class='row'>
<section id="single_player" class="secondary-page">

           <div class="top-score-title right-score col-md-9">
             <h3 style="text-align:left">Update Password</h3>

			 <!-- start main body -->
           <div class="top-score-title right-score col-md-12">
                <div class="col-md-12 login-page">
				<?php

				if(isset($act_stat)) { ?>
                       <div class="name" align='left'>
                            <label for="name_login" style="color:green"><?php echo $act_stat; ?></label>
						</div>
				<?php } ?>


                  <form method="post" class="login-form" method="post" action='<?php echo $this->config->item('club_pr_url'); ?>/login/update_password' autocomplete='off'>            
                        <div class="name">
                            <label for="Password">* Password:</label><div class="clear"></div>
                            <input id="upd_password" class='form-control' name="upd_password" type="password" style="width:40%" required  autocomplete="off" />
                        </div>

						<div class="name">
                            <label for="confirm_password">* Confirm Password:</label><div class="clear"></div>
                            <input id="confirm_upd_password" class='form-control' name="confirm_upd_password" type="password"  style="width:40%" required  autocomplete="off" />
							<div class="err" style="display: none; color:red">Password mismatch</div>
                        </div>
						<input id="Users_ID" name="Users_ID" value="<?php echo $user_details['Users_ID']; ?>" type="hidden" />

                    <div id="login-submit" style="line-height:25px">
					<br />
                            <input type="submit" name="submit" value="Update"/>
					</div>
                  </form>
                </div>
                
           </div><!--Close Login-->
			 <!-- end main body -->
             
           </div><!--Close Top Match-->