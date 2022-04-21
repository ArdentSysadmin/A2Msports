<link href="<?php echo base_url(); ?>assets/club_pages/assets/css/popup.css" rel="stylesheet">
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
<script>
var baseurl = "<?php echo base_url(); ?>";

$(document).ready(function(){
$('#txt_login').focus();
}); 
</script>
<section id="login" class="container secondary-page">  
<div class="general general-results players">

<!-- LOGIN BOX -->
<div class=" col-md-4 hidden-xs">&nbsp;</div>
<div class="top-score-title right-score col-md-4">
<h3>Login to A2M<!--<span> Now</span><span class="point-int"> !</span>--></h3>
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

<form id="form-login" method="post" action='<?php echo base_url(); ?>login/verify_user'>            
<div class="name">
<label for="name_login">Username or Email:</label><div class="clear"></div>
<input class='form-control' id="txt_login" name="name_login" type="text" style="margin-bottom:10px;" required />
</div>
<div class="pwd">
<label for="password_login">Password:</label><div class="clear"></div>
<input class='form-control' id="password_login" name="password_login" type="password" required />
</div>
<div class="hdn">
<?php //echo "<pre>"; print_r($GLOBALS );?>
<input class='form-control' id="red_uri" name="red_uri" type="hidden" value="<?php
if($this->config->item('club_pr_url') != 'https://a2msports.com/login')
echo $this->config->item('club_pr_url');
?>" />
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
//echo "<pre>"; print_r($GLOBALS); exit;
$req_uri =  $this->uri->segment(1);

if($req_uri != 'register'){
	$login		 = login::get_fb_login();
	$authUrl = login::get_google_login();
}
//print_r($login); 
if($login){
?>
<br /> <h4 style="padding-bottom:10px; padding-top:10px">Or...<br /><br />
<div id="phone-login" style="line-height:25px;"> 
<a href="#" id="phone_login" class="btn btn-info" role="button" style="margin-bottom: 20px;background-color: #81a32b;border-color: #81a32b;">
Login with Mobile Number</a>
</div>

<a href="<?php echo $login; ?>"><img src="<?php echo base_url(); ?>icons/facebook.jpg" height="40px" width="245px"  /></a><br /><br />
<a href="<?php echo $authUrl; ?>"><img src="<?php echo base_url(); ?>icons/google.jpg" height="40px" width="245px" /></a><br /><br />
<?php
}
?>
</div>
<!--Close Images-->
</div>
</form>



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
</div>
</div>
<div class=" col-md-4 hidden-xs">&nbsp;</div>
<!--Close Login-->
</div> 


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
<br /><span style='margin-left: 18px;'><i>Reach more players, Schedule your classes and communicate with players </i><span>
<div class="clear"></div>
</div>
<div class="name" style='margin-left:60px;margin-bottom: 40px;'>
<label for="txt_asplayer"><input name='regas' id="txt_asplayer" type="radio" value='player'  /> Player </label>
<br /><span style='margin-left: 18px;'><i>Register for tournaments, Reserve courts, Find clubs ad coaches. </i><span>
<div class="clear"></div>
</div>

<div id="login-submit" style="line-height:25px; margin-left:60px; margin-top:10px;">
<input type="button" id='register-as' name='register-as' value="  Continue  "/><br>
</div>
</form>
<!-- Login window content -->
	</div>
	</div>
</div>
</div>

<div class="modal fade" id="phone_users_modal" role="dialog">
<div class="modal-dialog modal-lg mobile-modal-dialog">
<div class="modal-content">
<div class="modal-header" style='border:0px;'>
<!-- Multi Users (Phone Login) window content -->
<div style='margin-bottom:25px;'>
<h4><b>We found that below users are linked with the given mobile number. Please select a profile to continue...</b></h4></div>
<form method="post" id="myform2" action="<?php echo base_url(); ?>login/phone_login" onsubmit="return checkChecked('myform');" class="register-form"> 
<input name="Mobilephone" id="ph_new_reg_mobile" type="hidden" value=''  />
<input name="token" id="ph_new_reg_token" type="hidden" value=''  />
<div id='exist_users_list'></div>

<div class="col-md-12" align="center">
<input name="cont_login" id="cont_login" type="submit" value="Continue" 
style="padding: 10px 30px; font-weight: bold; margin-top:20px; border:#81a32b; background-color:#81a32b" />
</div>
<div class="clear"></div>
</form>
<!-- Multi Users (Phone Login) window content -->
</div>
</div>
</div>
</div>


<div class="modal fade" id="signup_phone_modal" role="dialog">
<div class="modal-dialog modal-lg mobile-modal-dialog">
	<div class="modal-content">
	<div class="modal-header" style='border:0px;'>
<!-- Login window content -->
<div style='margin-bottom:25px;'><h4><b>Please provide the below details to complete the registration</b></h4></div>
<form method="post" id="myform" enctype="multipart/form-data" action="<?php echo base_url(); ?>register/save_mobileuser" onsubmit="return checkChecked('myform');" class="register-form"> 

<input name="Mobilephone" id="new_reg_mobile" type="hidden" value=''  />
<input name="token" id="new_reg_token" type="hidden" value=''  />

<div class="col-md-12">
<label for="Firstname">* First Name:</label><div class="clear"></div>
<input class='form-control' id="Firstname" name="Firstname" type="text" required />
</div>

<div class="col-md-12">
<label for="Lastname">* Last Name:</label><div class="clear"></div>
<input class='form-control' id="Lastname" name="Lastname" type="text" required />
</div>

<div class="col-md-12" style="padding-bottom:15px">
<label for="gender">* Gender: </label><div class="clear"></div>
	<select class='form-control' name="Gender" style="width:40%;" required>
	<option value=''>Select</option>
	<option value='1'>Male</option>
	<option value='0'>Female</option>
	</select>
</div>

<div class="col-md-12">
<label for="country">* Country:</label><div class="clear"></div>

<select class='form-control' name="CountryName" id="CountryName" required>
<option value="">Select Country</option>
<option value="Afganistan">Afghanistan</option>
<option value="Albania">Albania</option>
<option value="Algeria">Algeria</option>
<option value="American Samoa">American Samoa</option>
<option value="Andorra">Andorra</option>
<option value="Angola">Angola</option>
<option value="Anguilla">Anguilla</option>
<option value="Antigua &amp; Barbuda">Antigua &amp; Barbuda</option>
<option value="Argentina">Argentina</option>
<option value="Armenia">Armenia</option>
<option value="Aruba">Aruba</option>
<option value="Australia">Australia</option>
<option value="Austria">Austria</option>
<option value="Azerbaijan">Azerbaijan</option>
<option value="Bahamas">Bahamas</option>
<option value="Bahrain">Bahrain</option>
<option value="Bangladesh">Bangladesh</option>
<option value="Barbados">Barbados</option>
<option value="Belarus">Belarus</option>
<option value="Belgium">Belgium</option>
<option value="Belize">Belize</option>
<option value="Benin">Benin</option>
<option value="Bermuda">Bermuda</option>
<option value="Bhutan">Bhutan</option>
<option value="Bolivia">Bolivia</option>
<option value="Bonaire">Bonaire</option>
<option value="Bosnia &amp; Herzegovina">Bosnia &amp; Herzegovina</option>
<option value="Botswana">Botswana</option>
<option value="Brazil">Brazil</option>
<option value="British Indian Ocean Ter">British Indian Ocean Ter</option>
<option value="Brunei">Brunei</option>
<option value="Bulgaria">Bulgaria</option>
<option value="Burkina Faso">Burkina Faso</option>
<option value="Burundi">Burundi</option>
<option value="Cambodia">Cambodia</option>
<option value="Cameroon">Cameroon</option>
<option value="Canada">Canada</option>
<option value="Canary Islands">Canary Islands</option>
<option value="Cape Verde">Cape Verde</option>
<option value="Cayman Islands">Cayman Islands</option>
<option value="Central African Republic">Central African Republic</option>
<option value="Chad">Chad</option>
<option value="Channel Islands">Channel Islands</option>
<option value="Chile">Chile</option>
<option value="China">China</option>
<option value="Christmas Island">Christmas Island</option>
<option value="Cocos Island">Cocos Island</option>
<option value="Colombia">Colombia</option>
<option value="Comoros">Comoros</option>
<option value="Congo">Congo</option>
<option value="Cook Islands">Cook Islands</option>
<option value="Costa Rica">Costa Rica</option>
<option value="Cote DIvoire">Cote D'Ivoire</option>
<option value="Croatia">Croatia</option>
<option value="Cuba">Cuba</option>
<option value="Curaco">Curacao</option>
<option value="Cyprus">Cyprus</option>
<option value="Czech Republic">Czech Republic</option>
<option value="Denmark">Denmark</option>
<option value="Djibouti">Djibouti</option>
<option value="Dominica">Dominica</option>
<option value="Dominican Republic">Dominican Republic</option>
<option value="East Timor">East Timor</option>
<option value="Ecuador">Ecuador</option>
<option value="Egypt">Egypt</option>
<option value="El Salvador">El Salvador</option>
<option value="Equatorial Guinea">Equatorial Guinea</option>
<option value="Eritrea">Eritrea</option>
<option value="Estonia">Estonia</option>
<option value="Ethiopia">Ethiopia</option>
<option value="Falkland Islands">Falkland Islands</option>
<option value="Faroe Islands">Faroe Islands</option>
<option value="Fiji">Fiji</option>
<option value="Finland">Finland</option>
<option value="France">France</option>
<option value="French Guiana">French Guiana</option>
<option value="French Polynesia">French Polynesia</option>
<option value="French Southern Ter">French Southern Ter</option>
<option value="Gabon">Gabon</option>
<option value="Gambia">Gambia</option>
<option value="Georgia">Georgia</option>
<option value="Germany">Germany</option>
<option value="Ghana">Ghana</option>
<option value="Gibraltar">Gibraltar</option>
<option value="Great Britain">Great Britain</option>
<option value="Greece">Greece</option>
<option value="Greenland">Greenland</option>
<option value="Grenada">Grenada</option>
<option value="Guadeloupe">Guadeloupe</option>
<option value="Guam">Guam</option>
<option value="Guatemala">Guatemala</option>
<option value="Guinea">Guinea</option>
<option value="Guyana">Guyana</option>
<option value="Haiti">Haiti</option>
<option value="Hawaii">Hawaii</option>
<option value="Honduras">Honduras</option>
<option value="Hong Kong">Hong Kong</option>
<option value="Hungary">Hungary</option>
<option value="Iceland">Iceland</option>
<option value="India">India</option>
<option value="Indonesia">Indonesia</option>
<option value="Iran">Iran</option>
<option value="Iraq">Iraq</option>
<option value="Ireland">Ireland</option>
<option value="Isle of Man">Isle of Man</option>
<option value="Israel">Israel</option>
<option value="Italy">Italy</option>
<option value="Jamaica">Jamaica</option>
<option value="Japan">Japan</option>
<option value="Jordan">Jordan</option>
<option value="Kazakhstan">Kazakhstan</option>
<option value="Kenya">Kenya</option>
<option value="Kiribati">Kiribati</option>
<option value="Korea North">Korea North</option>
<option value="Korea Sout">Korea South</option>
<option value="Kuwait">Kuwait</option>
<option value="Kyrgyzstan">Kyrgyzstan</option>
<option value="Laos">Laos</option>
<option value="Latvia">Latvia</option>
<option value="Lebanon">Lebanon</option>
<option value="Lesotho">Lesotho</option>
<option value="Liberia">Liberia</option>
<option value="Libya">Libya</option>
<option value="Liechtenstein">Liechtenstein</option>
<option value="Lithuania">Lithuania</option>
<option value="Luxembourg">Luxembourg</option>
<option value="Macau">Macau</option>
<option value="Macedonia">Macedonia</option>
<option value="Madagascar">Madagascar</option>
<option value="Malaysia">Malaysia</option>
<option value="Malawi">Malawi</option>
<option value="Maldives">Maldives</option>
<option value="Mali">Mali</option>
<option value="Malta">Malta</option>
<option value="Marshall Islands">Marshall Islands</option>
<option value="Martinique">Martinique</option>
<option value="Mauritania">Mauritania</option>
<option value="Mauritius">Mauritius</option>
<option value="Mayotte">Mayotte</option>
<option value="Mexico">Mexico</option>
<option value="Midway Islands">Midway Islands</option>
<option value="Moldova">Moldova</option>
<option value="Monaco">Monaco</option>
<option value="Mongolia">Mongolia</option>
<option value="Montserrat">Montserrat</option>
<option value="Morocco">Morocco</option>
<option value="Mozambique">Mozambique</option>
<option value="Myanmar">Myanmar</option>
<option value="Nambia">Nambia</option>
<option value="Nauru">Nauru</option>
<option value="Nepal">Nepal</option>
<option value="Netherland Antilles">Netherland Antilles</option>
<option value="Netherlands">Netherlands (Holland, Europe)</option>
<option value="Nevis">Nevis</option>
<option value="New Caledonia">New Caledonia</option>
<option value="New Zealand">New Zealand</option>
<option value="Nicaragua">Nicaragua</option>
<option value="Niger">Niger</option>
<option value="Nigeria">Nigeria</option>
<option value="Niue">Niue</option>
<option value="Norfolk Island">Norfolk Island</option>
<option value="Norway">Norway</option>
<option value="Oman">Oman</option>
<option value="Pakistan">Pakistan</option>
<option value="Palau Island">Palau Island</option>
<option value="Palestine">Palestine</option>
<option value="Panama">Panama</option>
<option value="Papua New Guinea">Papua New Guinea</option>
<option value="Paraguay">Paraguay</option>
<option value="Peru">Peru</option>
<option value="Phillipines">Philippines</option>
<option value="Pitcairn Island">Pitcairn Island</option>
<option value="Poland">Poland</option>
<option value="Portugal">Portugal</option>
<option value="Puerto Rico">Puerto Rico</option>
<option value="Qatar">Qatar</option>
<option value="Republic of Montenegro">Republic of Montenegro</option>
<option value="Republic of Serbia">Republic of Serbia</option>
<option value="Reunion">Reunion</option>
<option value="Romania">Romania</option>
<option value="Russia">Russia</option>
<option value="Rwanda">Rwanda</option>
<option value="St Barthelemy">St Barthelemy</option>
<option value="St Eustatius">St Eustatius</option>
<option value="St Helena">St Helena</option>
<option value="St Kitts-Nevis">St Kitts-Nevis</option>
<option value="St Lucia">St Lucia</option>
<option value="St Maarten">St Maarten</option>
<option value="St Pierre &amp; Miquelon">St Pierre &amp; Miquelon</option>
<option value="St Vincent &amp; Grenadines">St Vincent &amp; Grenadines</option>
<option value="Saipan">Saipan</option>
<option value="Samoa">Samoa</option>
<option value="Samoa American">Samoa American</option>
<option value="San Marino">San Marino</option>
<option value="Sao Tome &amp; Principe">Sao Tome &amp; Principe</option>
<option value="Saudi Arabia">Saudi Arabia</option>
<option value="Senegal">Senegal</option>
<option value="Serbia">Serbia</option>
<option value="Seychelles">Seychelles</option>
<option value="Sierra Leone">Sierra Leone</option>
<option value="Singapore">Singapore</option>
<option value="Slovakia">Slovakia</option>
<option value="Slovenia">Slovenia</option>
<option value="Solomon Islands">Solomon Islands</option>
<option value="Somalia">Somalia</option>
<option value="South Africa">South Africa</option>
<option value="Spain">Spain</option>
<option value="Sri Lanka">Sri Lanka</option>
<option value="Sudan">Sudan</option>
<option value="Suriname">Suriname</option>
<option value="Swaziland">Swaziland</option>
<option value="Sweden">Sweden</option>
<option value="Switzerland">Switzerland</option>
<option value="Syria">Syria</option>
<option value="Tahiti">Tahiti</option>
<option value="Taiwan">Taiwan</option>
<option value="Tajikistan">Tajikistan</option>
<option value="Tanzania">Tanzania</option>
<option value="Thailand">Thailand</option>
<option value="Togo">Togo</option>
<option value="Tokelau">Tokelau</option>
<option value="Tonga">Tonga</option>
<option value="Trinidad &amp; Tobago">Trinidad &amp; Tobago</option>
<option value="Tunisia">Tunisia</option>
<option value="Turkey">Turkey</option>
<option value="Turkmenistan">Turkmenistan</option>
<option value="Turks &amp; Caicos Is">Turks &amp; Caicos Is</option>
<option value="Tuvalu">Tuvalu</option>
<option value="Uganda">Uganda</option>
<option value="Ukraine">Ukraine</option>
<option value="United Arab Erimates">United Arab Emirates</option>
<option value="United Kingdom">United Kingdom</option>
<option value="United States of America" selected='selected'>United States of America</option>
<option value="Uraguay">Uruguay</option>
<option value="Uzbekistan">Uzbekistan</option>
<option value="Vanuatu">Vanuatu</option>
<option value="Vatican City State">Vatican City State</option>
<option value="Venezuela">Venezuela</option>
<option value="Vietnam">Vietnam</option>
<option value="Virgin Islands (Brit)">Virgin Islands (Brit)</option>
<option value="Virgin Islands (USA)">Virgin Islands (USA)</option>
<option value="Wake Island">Wake Island</option>
<option value="Wallis &amp; Futana Is">Wallis &amp; Futana Is</option>
<option value="Yemen">Yemen</option>
<option value="Zaire">Zaire</option>
<option value="Zambia">Zambia</option>
<option value="Zimbabwe">Zimbabwe</option>
</select>
</div>

<div class="col-md-12">
<label for="zipcode">* Zip/Postal Code:</label><div class="clear"></div>
<input class='form-control' id="zipcode" name="Zipcode" type="text" maxlength='10' required/>
</div>


<div class="col-md-12" style="padding-top:40px;">
<input type="checkbox" name="recommend" id="recommend" value="1" />&nbsp;
I accept the <a style='cursor:pointer;' onclick='terms_conditions()'><b>Terms & Conditions</b></a> of A2M Sports.<br />
</div>

<div class="col-md-12" align="center">
<input name="reg_user" id="reg_user" type="submit" value="REGISTER" style="padding: 10px 30px; font-weight: bold; margin-top:20px; border:#81a32b; background-color:#81a32b" />
</div>

<div class="clear"></div>
</form>
<!-- Login window content -->
	</div>
	</div>
</div>
</div>

</section>

<script>
$(document).ready(function(){
	$(document).on('click','.member_login',function(){
		$("#login_modal").modal();
	});
//$("#signup_phone_modal").modal();
	$('#register-as').click(function(){
		var ras = $("input[name='regas']:checked"). val();
		
		window.location.replace(baseurl+'register?r='+ras);
	});
});
</script>

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