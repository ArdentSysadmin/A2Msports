<script>
$(document).ready(function(){
    $('#country').on('change', function() {
      if(this.value == 'United States of America'){
        $("#state_drop").show();
		$("#state_box").hide();
      }
      else{
        $("#state_drop").hide();
		$("#state_box").show();
      }
    });

	
	$('#txt_cpwd').blur(function() {
    var pass = $('#txt_pwd').val();
    var repass = $('#txt_cpwd').val();

	if (pass != repass) {
		$( ".err" ).show();
		$('#txt_cpwd').val("");
    }
    else {
		$( ".err" ).hide();
    }

	});
});
</script>

<section id="single_player" class="container secondary-page">
<div class="top-score-title right-score col-md-9">

<!-- start main body --> 
<div class="col-md-12 league-form-bg" style="margin-top:30px;">
<div class="fromtitle">Update Profile</div>

<form class="form-horizontal" id='myform_dob' method='post' role="form"  action="<?php echo base_url(); ?>register/profile_update">
<div class='col-md-12'>

	<div class='form-group'><label class='col-md-12 form-group internal' for='id_accomodation' style='font-size: 14px;'>
	<b style='color:blue'><?php 
	echo "Welcome to A2MSports. Set your Login Password and Provide us your details. Thankyou"; 
	?></b></label></div>
	
	<input class='form-control' type="hidden" name="user" value="<?=$users_id;?>" />
	<input class='form-control' type="hidden" name="act" value="<?=$act_code;?>" />

	<div class='form-group'>
	<label class='control-label col-md-3 padtop' for='id_accomodation'>Password:</label>
	<div class='col-md-8 form-group internal text1'>
	<input class='form-control' id="txt_pwd" type="password" name="txt_pwd" style='width:50%' value="" required />
	</div>
	</div>

	<div class='form-group'>
	<label class='control-label col-md-3 padtop' for='id_accomodation'>Re-type Password</label>
	<div class='col-md-8 form-group internal text1'>
	<input class='form-control' id="txt_cpwd" type="password" name="txt_cpwd" style='width:50%' value="" required />
		<div class="err" style="display: none; color:red">Passwords mismatch</div>
	</div>
	</div>

	<div class='form-group'>
	<label class='control-label col-md-3 padtop' for='id_accomodation'>Date of Birth:</label>
	<div class='col-md-8 form-group internal text1'>
	<input class='form-control' id="txt_dob" type="date" name="txt_dob" style='width:50%' value="" required />
	</div>
	</div>

	<!-- Gather address info. if not available -->

	<div class='form-group'>
	<label class='control-label col-md-3' for='id_accomodation'>Address Line1 </label>
	<div class='col-md-8 form-group internal'>
	<input class='form-control' id='addr1' name='UserAddressline1' type='text' style="width:80%" value="" required>
	</div>
	</div>

	<div class='form-group'>
	<label class='control-label col-md-3' for='id_accomodation'>Address Line2 </label>
	<div class='col-md-8 form-group internal'>
	<input class='form-control' id='addr2' name='UserAddressline2' type='text' style="width:80%" value="">
	</div>
	</div>

	<div class='form-group'>

	<label class='control-label col-md-3' for='id_accomodation'>Country</label>
	<div class='col-md-6 form-group internal'>
	<select class='form-control' id='country' name='CountryName' required>
	<option value="">Select</option>
	<?php
	$countries = array("Afghanistan", "Albania", "Algeria", "American Samoa", "Andorra", "Angola", "Anguilla", "Antarctica", "Antigua and Barbuda", "Argentina", "Armenia", "Aruba", "Australia", "Austria", "Azerbaijan", "Bahamas", "Bahrain", "Bangladesh", "Barbados", "Belarus", "Belgium", "Belize", "Benin", "Bermuda", "Bhutan", "Bolivia", "Bosnia and Herzegowina", "Botswana", "Bouvet Island", "Brazil", "British Indian Ocean Territory", "Brunei Darussalam", "Bulgaria", "Burkina Faso", "Burundi", "Cambodia", "Cameroon", "Canada", "Cape Verde", "Cayman Islands", "Central African Republic", "Chad", "Chile", "China", "Christmas Island", "Cocos (Keeling) Islands", "Colombia", "Comoros", "Congo", "Congo, the Democratic Republic of the", "Cook Islands", "Costa Rica", "Cote d'Ivoire", "Croatia (Hrvatska)", "Cuba", "Cyprus", "Czech Republic", "Denmark", "Djibouti", "Dominica", "Dominican Republic", "East Timor", "Ecuador", "Egypt", "El Salvador", "Equatorial Guinea", "Eritrea", "Estonia", "Ethiopia", "Falkland Islands (Malvinas)", "Faroe Islands", "Fiji", "Finland", "France", "France Metropolitan", "French Guiana", "French Polynesia", "French Southern Territories", "Gabon", "Gambia", "Georgia", "Germany", "Ghana", "Gibraltar", "Greece", "Greenland", "Grenada", "Guadeloupe", "Guam", "Guatemala", "Guinea", "Guinea-Bissau", "Guyana", "Haiti", "Heard and Mc Donald Islands", "Holy See (Vatican City State)", "Honduras", "Hong Kong", "Hungary", "Iceland", "India", "Indonesia", "Iran (Islamic Republic of)", "Iraq", "Ireland", "Israel", "Italy", "Jamaica", "Japan", "Jordan", "Kazakhstan", "Kenya", "Kiribati", "Korea, Democratic People's Republic of", "Korea, Republic of", "Kuwait", "Kyrgyzstan", "Lao, People's Democratic Republic", "Latvia", "Lebanon", "Lesotho", "Liberia", "Libyan Arab Jamahiriya", "Liechtenstein", "Lithuania", "Luxembourg", "Macau", "Macedonia, The Former Yugoslav Republic of", "Madagascar", "Malawi", "Malaysia", "Maldives", "Mali", "Malta", "Marshall Islands", "Martinique", "Mauritania", "Mauritius", "Mayotte", "Mexico", "Micronesia, Federated States of", "Moldova, Republic of", "Monaco", "Mongolia", "Montserrat", "Morocco", "Mozambique", "Myanmar", "Namibia", "Nauru", "Nepal", "Netherlands", "Netherlands Antilles", "New Caledonia", "New Zealand", "Nicaragua", "Niger", "Nigeria", "Niue", "Norfolk Island", "Northern Mariana Islands", "Norway", "Oman", "Pakistan", "Palau", "Panama", "Papua New Guinea", "Paraguay", "Peru", "Philippines", "Pitcairn", "Poland", "Portugal", "Puerto Rico", "Qatar", "Reunion", "Romania", "Russian Federation", "Rwanda", "Saint Kitts and Nevis", "Saint Lucia", "Saint Vincent and the Grenadines", "Samoa", "San Marino", "Sao Tome and Principe", "Saudi Arabia", "Senegal", "Seychelles", "Sierra Leone", "Singapore", "Slovakia (Slovak Republic)", "Slovenia", "Solomon Islands", "Somalia", "South Africa", "South Georgia and the South Sandwich Islands", "Spain", "Sri Lanka", "St. Helena", "St. Pierre and Miquelon", "Sudan", "Suriname", "Svalbard and Jan Mayen Islands", "Swaziland", "Sweden", "Switzerland", "Syrian Arab Republic", "Taiwan, Province of China", "Tajikistan", "Tanzania, United Republic of", "Thailand", "Togo", "Tokelau", "Tonga", "Trinidad and Tobago", "Tunisia", "Turkey", "Turkmenistan", "Turks and Caicos Islands", "Tuvalu", "Uganda", "Ukraine", "United Arab Emirates", "United Kingdom", "United States of America", "United States Minor Outlying Islands", "Uruguay", "Uzbekistan", "Vanuatu", "Venezuela", "Vietnam", "Virgin Islands (British)", "Virgin Islands (U.S.)", "Wallis and Futuna Islands", "Western Sahara", "Yemen", "Yugoslavia", "Zambia", "Zimbabwe");

	foreach($countries as $country)
	{
	echo "<option value='$country'>$country</option>";
	}?>
	</select>

	</div>
	</div>

	<div class='form-group' id='state_box' style='<?php if($user_info->Country=="United States of America") { echo "display:none;"; } ?>'>
	<label class='control-label col-md-3' for='id_accomodation'> State</label>
	<div class='col-md-8 form-group internal'>
	<input class='form-control' id='state1' name='StateName1' type='text' style="width:45%" value="">
	</div>
	</div>

	<div class='form-group' id="state_drop" style='<?php if($user_info->Country!="United States of America") { echo "display:none;"; } ?>'>
	<label class='control-label col-md-3' for='id_title'>State</label>
	<div class='col-md-4 form-group internal'>
	<select name="StateName" id="state" class='form-control' onChange="stateChange();">
	<option value="">Select</option>
	<?php
	$states = array('Alabama','Alaska','Arizona','Arkansas','California','Colorado','Connecticut','Delaware','District of Columbia','Florida','Georgia',
	'Hawaii','Idaho','Illinois','Indiana','Iowa','Kansas','Kentucky','Louisiana','Maine','Maryland','Massachusetts','Michigan','Minnesota','Mississippi',
	'Missouri','Montana','Nebraska','Nevada','New Hampshire','New Jersey','New Mexico','New York','North Carolina','North Dakota','Ohio','Oklahoma', 'Oregon','Pennsylvania','Rhode Island','South Carolina','South Dakota','Tennessee','Texas','Utah','Vermont','Virginia','Washington','West Virginia',
	'Wisconsin','Wyoming'); 

	foreach($states as $state)
	{
	echo "<option value='$state'>$state</option>";
	}
	?>
	</select>
	</div>
	</div>

	<div class='form-group'>
	<label class='control-label col-md-3' for='id_accomodation'> City</label>
	<div class='col-md-8 form-group internal'>
	<input class='form-control' id='city' name='CityName' type='text' style="width:45%" value="" />
	</div>
	</div>

	<div class='form-group'>
	<label class='control-label col-md-3' for='id_accomodation'>Postal Code</label>
	<div class='col-md-8 form-group internal'>
	<input class='form-control' id='zipcode' name='zipcode' type='text' style="width:45%" value="" />
	</div>
	</div>
	
	<!-- End of address info. -->

<div class='form-group'>
<label class='control-label col-md-4' for='id_accomodation'></label>
	<div class='col-md-7 form-group internal'>
	<input name="ins_prof_update" type="submit" value="Update" class="league-form-submit"/>
	</div>
</div>
</form>	

</div>
</div>
<div style="clear:both"></div>
<!-- end main body -->
</div><!-- Close Top Match -->