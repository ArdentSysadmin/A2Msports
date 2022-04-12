
<!-- Login Popup Start -->
<div id="login" class="overlay">
<div class="popup">
<h2 style='padding: 0px;'>Login</h2>
<a class="close" href="#">&times;</a>
<div class="content">
<!-- Login content -->

<div class="top-score-title right-score">
<div class="">
<?php 
//if(isset($this->session->flashdata('err_msg'))) { ?>
<div class="name" align='left'>
<label for="name_login" style="color:red"><?php echo $this->session->flashdata('err_msg'); ?></label>
</div>
<?php //} ?>
<?php if(isset($act_stat)) { ?>
<div class="name" align='left'>
<label for="name_login" style="color:blue"><?php echo $act_stat; ?></label>
</div>
<?php } ?>

<?php if(isset($update)) { ?>
<div class="name" align='left'>
<label for="name_login" style="color:green"><?php echo $update; ?></label>
</div>
<?php } ?>

<form id="form-login" method="post" action='<?=$this->config->item('club_pr_url');?>/login/verify_user'>            
<div class="name">
<label for="name_login">Username or Email:</label><div class="clear"></div>
<input class='form-control' id="txt_login" name="name_login" type="text" style="margin-bottom:10px;" required/>
</div>
<div class="pwd">
<label for="password_login">Password:</label><div class="clear"></div>
<input class='form-control' id="password_login" name="password_login" type="password" required/>
</div>
<div class="hdn">
<?php //echo "<pre>"; print_r($GLOBALS );?>
<input class='form-control' id="red_uri" name="red_uri" type="hidden" value="<?=$this->config->item('club_pr_url');?>" />
</div>
<a href="<?php echo base_url();?>Forgot-password">Forgot Password?</a>
<br />
<div id="login-submit" style="line-height:25px;">
<input type="submit" name='submit_web_login' value="Login" style="padding: 5px 30px;color: #fff;font-weight: bold; margin-top:10px; border:#ff8a00; background-color:#ff8a00" />
&nbsp;&nbsp;
<!--<a href="<?php echo base_url();?>Forgot-password">Forgot Password?</a>-->
| 
<a href="#" class="member_login">Sign up</a>
</div>

<div class="ctn-img1">
<?php
$req_uri =  $this->uri->segment(1);
//echo $this->router->class;
//exit;
if($req_uri != 'register'){
$cur_class	 = $this->router->class; 

$login		 = $cur_class :: get_fb_login();
$authUrl = $cur_class :: get_google_login();
}
//print_r($login); 
if($login){
?>
<br /> <h4 style="padding-bottom:0px; padding-top:0px">Or...<br /><br />
<div id="phone-login" style="line-height:25px;"> 
<a href="#" id="phone_login" class="btn btn-info" role="button" style="margin-bottom: 20px;background-color: #81a32b;border-color: #81a32b;">
Login with Mobile Number</a>
</div>

<a href="<?php echo $login; ?>"><img src="<?php echo base_url(); ?>icons/facebook.jpg" height="40px" width="245px"  /></a><br /><br />
<a href="<?php echo $authUrl; ?>"><img src="<?php echo base_url(); ?>icons/google.jpg" 
height="40px" width="245px" /></a><br /><br />
<?php
}
?>
</div>
</div>
</div>
</form>
<!-- End of Login content -->

<!-- Mobile number login -->
<form id="form-phone" class="form-signin" accept="#" style="display:none;">
	<h1 class="h3 mb-3 font-weight-normal" style="text-align: center"> Sign in</h1>
	
	<div id='phone-input' style="text-align: center;">

		<div style="display:flex;">
		<select class="form-control" name='ph_country_code' id='ph_country_code' style="width:23%;margin-bottom:10px; margin-right:10px;">
		<option value='+1'>U.S.A</option>
		<option value='+91'>India</option>
		</select>
		<input type="text" id="inputPhone" class="form-control" placeholder="Enter your 10 digits Mobile Number" required="" autofocus="" style="width:75%;" />
		</div>

	<div id="recaptcha-container"></div>
		<div>
		<button class="ph_otp" type="button" id="phoneloginbtn" style="background-color: #ff8a00; margin:15px;"><i class="fas fa-sign-in-alt"></i> SEND OTP</button>
		</div>
	</div>
	<div id='otp-input' style="display:none; text-align: center;">
	<input type="otp" id="inputOtp" style="font-size: 18px !important;" class="form-control" placeholder="Enter One Time Password" required>
	<button class="ph_otp" type="button" id="verifyotp" style="background-color: #ff8a00; margin:15px;"><i class="fas fa-sign-in-alt"></i> VERIFY OTP</button>
	</div>
</form>
<!-- End of Mobile number login -->

</div>
</div>
</div>
<!-- Login Popup End here -->


<!-- ----------------------------------------------------------------------------------------------------------------------------- -->
 <!-- The core Firebase JS SDK is always required and must be listed first -->
<script src="https://www.gstatic.com/firebasejs/7.19.0/firebase-app.js"></script>

<!-- TODO: Add SDKs for Firebase products that you want to use
     https://firebase.google.com/docs/web/setup#available-libraries -->
<!-- <script src="https://www.gstatic.com/firebasejs/7.19.0/firebase-analytics.js"></script> -->
<script defer src="https://www.gstatic.com/firebasejs/7.19.0/firebase-auth.js"></script>
<script>
  // Your web app's Firebase configuration
  var firebaseConfig = {
  apiKey: "AIzaSyCmVrLhO1Wo69C-GjfNEGAL-taGq__TrDU",
  authDomain: "a2msports-1536907453916.firebaseapp.com",
  databaseURL: "https://a2msports-1536907453916.firebaseio.com",
  projectId: "a2msports-1536907453916",
  storageBucket: "a2msports-1536907453916.appspot.com",
  messagingSenderId: "1070980649409",
  appId: "1:1070980649409:web:ebd5383a8d975c16335f40"
};
  // Initialize Firebase
  firebase.initializeApp(firebaseConfig);
  //firebase.analytics();
   //===================Saving Login Details in My Server Using AJAX================
   function sendDatatoServerPhp(email,provider,token,username){
		 $.ajax({
				type:'POST',
				url:baseurl+'logintest/check_phone/',
				data:'provider='+provider+'&username='+username+'&token='+token,
				success:function(res){
					console.log(res);
					var json = $.parseJSON(res);
					if(json.status == 'Phone Number Not Registered!'){
							$("#signup_phone_modal").modal();
							$('#new_reg_token').val(token);
							$('#new_reg_mobile').val(json.mobile);
					}
					else if(json.status == 'Login Successfull'){

							$('#ph_new_reg_token').val(token);
							$('#ph_new_reg_mobile').val(json.mobile);
							var $ctrl = '';
							console.log(json.res);
							$(json.res).each(function(i,val){
								console.log("tot "+json.res.length);
																	//alert('te1');
								if(json.res.length > 1){

								$ctrl = $("<div class='name' style='margin-left:60px;margin-bottom: 25px;'><label for='txt_"+val.user_id+"'><input name='regas' id='txt_"+val.user_id+"' type='radio' value='"+val.user_id+"' /> "+val.firstname+" "+val.lastname+"</label><div class='clear'></div></div>");

								$("#exist_users_list").append($ctrl);
								$("#phone_users_modal").modal();
								}
								else if(json.res.length == 1){
									//alert('te');
								$ctrl = $("<div class='name' style='margin-left:60px;margin-bottom: 25px;'><label for='txt_"+val.user_id+"'><input name='regas' id='txt_"+val.user_id+"' type='radio' value='"+val.user_id+"' checked /> "+val.firstname+" "+val.lastname+"</label><div class='clear'></div></div>");

								$("#exist_users_list").append($ctrl);
								$('#cont_login').trigger('click');
								//location.reload();

								}
							});
					}
					console.log(json.status);
					console.log(json);
		  		}
		});
   }

   //========================= End Saving Details in My Server ===============
   //========================= Login With Phone ==========================
   var loginphone	=document.getElementById("phoneloginbtn");
   var country_code	=document.getElementById("ph_country_code");
   var phoneinput	=document.getElementById("inputPhone");
   var otpinput		=document.getElementById("inputOtp");
   var verifyotp		=document.getElementById("verifyotp");

   loginphone.onclick=function(){

		var xyz = phoneinput.value;
		var abc = country_code.value;

		var mob = abc+xyz;
		//alert(typeof(xyz));
		/*console.log(xyz.length);
		if(xyz.length == 10){
			 $.ajax({
					type:'POST',
					url:baseurl+'logintest/get_country_code/',
					data:'mob_num='+xyz,
					success:function(res){
						console.log(res);
						phoneinput.value = res+xyz;
						document.getElementById("inputPhone").value = res+xyz;
						console.log(phoneinput.value);
			//alert(typeof(phoneinput.value));

					}
			});
		}*/

    window.recaptchaVerifier = new firebase.auth.RecaptchaVerifier('recaptcha-container', {
        'size': 'normal',
        'callback': function(response) {
            // reCAPTCHA solved, allow signInWithPhoneNumber.

            // ...
        },
        'expired-callback': function() {
            // Response expired. Ask user to solve reCAPTCHA again.
            // ...
        }
        });


   
        var cverify=window.recaptchaVerifier;
		//console.log(xyz);

        firebase.auth().signInWithPhoneNumber(mob, cverify).then(function(response){
			//alert("test");
			var x = document.getElementById("phone-input");
			var y = document.getElementById("otp-input");
  if (x.style.display === "none") {    x.style.display = "block";  } else {   x.style.display = "none";  }
  if (y.style.display === "none") {    y.style.display = "block";  } else {   y.style.display = "none";  }
            console.log(response);
            window.confirmationResult=response;
        }).catch(function(error){
            console.log(error);
        })
   }

   verifyotp.onclick=function(){
       confirmationResult.confirm(otpinput.value).then(function(response){
           console.log(response);
            var userobj=response.user;
            var token=userobj.xa;
            var provider="phone";
            var email=phoneinput.value;
            if(token!=null && token!=undefined && token!=""){
            sendDatatoServerPhp(email,provider,token,email);
            }
       })
       .catch(function(error){
           console.log(error);
       })
   }
   //=================End Login With Phone=========================


$(document).ready(function(){
	$('#phone_login').click(function(){
		$('#form-login').toggle();
		$('#form-phone').toggle();
	});
});
</script>
<!-- ----------------------------------------------------------------------------------------------------------------------------------------- -->