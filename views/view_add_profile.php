<script>
$(document).ready(function(){

$(function(){
    yourFunction(); //this calls it on load
    $("select#country").change(yourFunction);
});

function yourFunction() {
$('#country').on('change', function() {
if ( this.value == 'United States of America')
{
$("#state_drop").show();
$("#state_box").hide();
}
else
{
$("#state_drop").hide();
$("#state_box").show();
}
});
}
});

$(function() {
    if($("#country").val() != 'United States of America'){ //I'm supposing the "Other" option value is 0.
         $("#state_box").show();
		 $("#state_drop").hide();
	}
	else
      {
        $("#state_drop").show();
		$("#state_box").hide();
      }
});

</script>
<script>

	$(document).ready(function(){
    $('#CountryName').on('change', function() {
      if ( this.value == 'United States of America')
      {
        $("#state_drop").show();
		$("#state_box").hide();
      }
      else
      {
        $("#state_drop").hide();
		$("#state_box").show();
      }
    });
});
</script>
<script>
 $(document).ready(function (){
   
   $("#page").change(function(){
    var country; var state;var state1; var city; var address1; var address2;var zipcode;var homephone;var cellphone;
	
    if (this.checked) {
        address1 = "<?php echo $user_details['UserAddressline1'];?>";
		address2 = "<?php echo $user_details['UserAddressline2'];?>";
		country = "<?php echo $user_details['Country'];?>";
		city = "<?php echo $user_details['City'];?>";
		state = "<?php echo $user_details['State'];?>";
		state1 = "<?php echo $user_details['State'];?>";
		zipcode = "<?php echo $user_details['Zipcode'];?>";
		homephone = "<?php echo $user_details['HomePhone'];?>";
		cellphone = "<?php echo $user_details['Mobilephone'];?>";

    } else {
        address1 = "";address2 = "";country = "";city = "";state = "";state1 = "";zipcode = "";homephone = "";cellphone = "";
    }
    $("#address1").val(address1);
	$("#address2").val(address2);
	
	$("#CountryName").val(country);
	$("#StateName").val(state);

	$("#StateName1").val(state1);
	$("#CityName").val(city);
	$("#Zipcode").val(zipcode);

	$("#HomePhone").val(homephone);
	$("#Mobilephone").val(cellphone);

});
}); 
</script>
<script>
 $(document).ready(function(){
	$('input[name=confirm_password]').blur(function() {
    var pass = $('input[name=Password]').val();
    var repass = $('input[name=confirm_password]').val();
    if(($('input[name=Password]').val().length == '') || ($('input[name=confirm_password]').val().length == '')) {
        ///$('#Password').addClass('has-error');
    }
    else if (pass != repass) {
		$( ".err" ).show();
		$('#confirm_password').val("");
    }
    else {
		$( ".err" ).hide();
    }

});
});
</script>
<script>
function checkChecked(formname) {
    var anyBoxesChecked = false;
    $('#' + formname + ' input[type="checkbox"]').each(function() {
        if ($(this).is(":checked")) {
            anyBoxesChecked = true;
        }
    });
 
    if (anyBoxesChecked === false) {
      alert('Please select at least one Interested Sport ');
      return false;
    }
}
</script>

<script>
$(document).ready(function(){
$("#username").blur(function(){

	var baseurl = "<?php echo base_url();?>";
    var username = $(this).val();

		if(username!=""){
            $.ajax({
                type:'POST',
                url:baseurl+'profile/check_username/',
                data:'user_name='+username,
                success:function(html){
					var stat = html;
					if(stat!=""){
                    $('#user_stat').html(stat);
					$('#username').val("");
					}
					else {
                    $('#user_stat').html("");
					}
                }
            }); 
        }
    });
 });
 </script>





<section id="login" class="container secondary-page">  
<div class="general general-results players">
<div class="top-score-title col-md-12">
<div class="col-md-6">
<h3 style="text-align:left !important">Add a Child or Spouse</h3>
<!--<h3 style="text-align:left !important">Add New <span>Player</span></h3> -->
</div>

<div class="col-md-12 login-page">

<form method="post" name="myform" id="myform" 
enctype="multipart/form-data" action="<?php echo base_url(); ?>profile/add_player" onsubmit="return checkChecked(this);" class="register-form"> 

<div class="col-md-6">
<label for="name"> First Name:</label><div class="clear"></div>
<input class='form-control' id="name" name="Firstname" type="text" Placeholder="Child or Spouse Firstname" required/>
 </div>
 <br/> 
<div class="col-md-6">
<label for="lastname"> Last Name:</label><div class="clear"></div>
<input class='form-control' id="lastname" name="Lastname" type="text"Placeholder="Child or Spouse Lastname" required/>
</div>
<br/> 
<div class="col-md-6">
<label for="Profilepic">Profile Picture:</label><div class="clear"></div>
<input class='form-control' id="Profilepic" name="Profilepic" style="margin-bottom:28px" type="file"/>
</div>
<br/> 
<div class="col-md-6">
<label for="lastname">* Enter a new User Name:</label><div class="clear"></div>
<input class='form-control' name="user_name" id="username" type="text" Placeholder="Username for Child or Spouse"required />
<span id="user_stat" style="color:red;"></span>
</div>
<br/> 
<div class="col-md-6">
	<label for="Password">* Password:</label><div class="clear"></div>
	<input class='form-control' id="Password" name="Password" type="password" required/>
</div>
<br/> 						
<div class="col-md-6">
	<label for="confirm_password">* Confirm Password:</label><div class="clear"></div>
	<input class='form-control' id="confirm_password" name="confirm_password" type="password" required />
	<div class="err" style="display: none; color:red">Password mismatch</div>
</div> 

<div class="col-md-6 input-group internal">
<label for="lastname">* Date of birth:</label><div class="clear"></div>
<input class='form-control' id="txt_dob" type="date" name="txt_dob" value="" required />
</div>

<div class="col-md-6" style="padding-bottom:15px">
<label for="lastname">* Gender: </label><div class="clear"></div>
<input name="Gender" type="radio" value="1" style="margin-bottom:22px" /> Male  <input name="Gender" type="radio" value="0" /> Female  
</div>

<div class="col-md-6">
<label for="alter_name">Alternate Email:</label><div class="clear"></div>
<input class='form-control' id="AlternateEmailID" name="AlternateEmailID" type="text" value="<?php echo $user_details['EmailID'];?>" />
</div>

<div class="col-md-6" >
<label for="lastname">* Interested in:</label><div class="clear"></div>

<input type="checkbox" name="Sportsintrests[]" value="1" /> Tennis &nbsp;
<input type="checkbox" name="Sportsintrests[]" value="2" /> Table Tennis &nbsp;
<input type="checkbox" name="Sportsintrests[]" value="3" /> Badminton  &nbsp;
<input type="checkbox" name="Sportsintrests[]" value="4" /> Golf  &nbsp;
<input type="checkbox" name="Sportsintrests[]" value="5" /> Racquetball &nbsp;
<input type="checkbox" name="Sportsintrests[]" value="6" /> Squash &nbsp;
<input type="checkbox" name="Sportsintrests[]" value="7" /> Pickleball

</div>

 <!-- click Radio button show details---->
 <div class="col-md-12"><br />
	<input name="details" id="page" type="checkbox" value="" style="margin-bottom:22px"> 
	<label for="">Do you want to use your address details?</label>
</div> 

<div id="parent_details" style="">     <!-- show parent deails section start---->

<div class="col-md-6">
<label for="lastname">Home phone:</label><div class="clear"></div>
<input class='form-control' id="HomePhone" name="HomePhone" type="text" />
</div>
<div class="col-md-6">
<label for="lastname">* Cell phone:</label><div class="clear"></div>
<input class='form-control' id="Mobilephone" name="Mobilephone" type="text" />
</div>

<div class="col-md-6">
<label for="lastname">* Address Line1:</label><div class="clear"></div>
<input class='form-control' id="address1" name="UserAddressline1"  value="" type="text" required />
</div>

<div class="col-md-6">
<label for="lastname"> Address Line2:</label><div class="clear"></div>
<input class='form-control' id="address2"  name="UserAddressline2" value="" type="text" />
</div>

<div class="col-md-6">
<label class='form-control' for="lastname">* Country:</label><div class="clear"></div>

<select name="CountryName" id="CountryName" class="form-control" required>
<option value="">Select Country</option>

<?php
$countries = array("Afghanistan", "Albania", "Algeria", "American Samoa", "Andorra", "Angola", "Anguilla", "Antarctica", "Antigua and Barbuda", "Argentina", "Armenia", "Aruba", "Australia", "Austria", "Azerbaijan", "Bahamas", "Bahrain", "Bangladesh", "Barbados", "Belarus", "Belgium", "Belize", "Benin", "Bermuda", "Bhutan", "Bolivia", "Bosnia and Herzegowina", "Botswana", "Bouvet Island", "Brazil", "British Indian Ocean Territory", "Brunei Darussalam", "Bulgaria", "Burkina Faso", "Burundi", "Cambodia", "Cameroon", "Canada", "Cape Verde", "Cayman Islands", "Central African Republic", "Chad", "Chile", "China", "Christmas Island", "Cocos (Keeling) Islands", "Colombia", "Comoros", "Congo", "Congo, the Democratic Republic of the", "Cook Islands", "Costa Rica", "Cote d'Ivoire", "Croatia (Hrvatska)", "Cuba", "Cyprus", "Czech Republic", "Denmark", "Djibouti", "Dominica", "Dominican Republic", "East Timor", "Ecuador", "Egypt", "El Salvador", "Equatorial Guinea", "Eritrea", "Estonia", "Ethiopia", "Falkland Islands (Malvinas)", "Faroe Islands", "Fiji", "Finland", "France", "France Metropolitan", "French Guiana", "French Polynesia", "French Southern Territories", "Gabon", "Gambia", "Georgia", "Germany", "Ghana", "Gibraltar", "Greece", "Greenland", "Grenada", "Guadeloupe", "Guam", "Guatemala", "Guinea", "Guinea-Bissau", "Guyana", "Haiti", "Heard and Mc Donald Islands", "Holy See (Vatican City State)", "Honduras", "Hong Kong", "Hungary", "Iceland", "India", "Indonesia", "Iran (Islamic Republic of)", "Iraq", "Ireland", "Israel", "Italy", "Jamaica", "Japan", "Jordan", "Kazakhstan", "Kenya", "Kiribati", "Korea, Democratic People's Republic of", "Korea, Republic of", "Kuwait", "Kyrgyzstan", "Lao, People's Democratic Republic", "Latvia", "Lebanon", "Lesotho", "Liberia", "Libyan Arab Jamahiriya", "Liechtenstein", "Lithuania", "Luxembourg", "Macau", "Macedonia, The Former Yugoslav Republic of", "Madagascar", "Malawi", "Malaysia", "Maldives", "Mali", "Malta", "Marshall Islands", "Martinique", "Mauritania", "Mauritius", "Mayotte", "Mexico", "Micronesia, Federated States of", "Moldova, Republic of", "Monaco", "Mongolia", "Montserrat", "Morocco", "Mozambique", "Myanmar", "Namibia", "Nauru", "Nepal", "Netherlands", "Netherlands Antilles", "New Caledonia", "New Zealand", "Nicaragua", "Niger", "Nigeria", "Niue", "Norfolk Island", "Northern Mariana Islands", "Norway", "Oman", "Pakistan", "Palau", "Panama", "Papua New Guinea", "Paraguay", "Peru", "Philippines", "Pitcairn", "Poland", "Portugal", "Puerto Rico", "Qatar", "Reunion", "Romania", "Russian Federation", "Rwanda", "Saint Kitts and Nevis", "Saint Lucia", "Saint Vincent and the Grenadines", "Samoa", "San Marino", "Sao Tome and Principe", "Saudi Arabia", "Senegal", "Seychelles", "Sierra Leone", "Singapore", "Slovakia (Slovak Republic)", "Slovenia", "Solomon Islands", "Somalia", "South Africa", "South Georgia and the South Sandwich Islands", "Spain", "Sri Lanka", "St. Helena", "St. Pierre and Miquelon", "Sudan", "Suriname", "Svalbard and Jan Mayen Islands", "Swaziland", "Sweden", "Switzerland", "Syrian Arab Republic", "Taiwan, Province of China", "Tajikistan", "Tanzania, United Republic of", "Thailand", "Togo", "Tokelau", "Tonga", "Trinidad and Tobago", "Tunisia", "Turkey", "Turkmenistan", "Turks and Caicos Islands", "Tuvalu", "Uganda", "Ukraine", "United Arab Emirates", "United Kingdom", "United States of America", "United States Minor Outlying Islands", "Uruguay", "Uzbekistan", "Vanuatu", "Venezuela", "Vietnam", "Virgin Islands (British)", "Virgin Islands (U.S.)", "Wallis and Futuna Islands", "Western Sahara", "Yemen", "Yugoslavia", "Zambia", "Zimbabwe");

foreach($countries as $country)
{
	if($user_details['Country']==$country){
		$stat = "selected='selected'";
	}else{
		$stat = "";
	}
 echo "<option value='$country' >$country</option>";
}
?>
</select>
</div>


<div class="col-md-6" style='display:none;' id='state_box'>
<label for="lastname">* State:</label><div class="clear"></div>
<input class='form-control' type="text"  name="StateName1" id="StateName1" Placeholder="Enter State" value="" />
</div>

<div class="col-md-6" id="state_drop">
<label for="lastname">* State:</label><div class="clear"></div>

<select class='form-control' name="StateName" id="StateName">
<option value="">Select State</option>
<?php
$states = array('Alabama','Alaska','Arizona','Arkansas','California','Colorado','Connecticut','Delaware','District of Columbia','Florida','Georgia',
  'Hawaii','Idaho','Illinois','Indiana','Iowa','Kansas','Kentucky','Louisiana','Maine','Maryland','Massachusetts','Michigan','Minnesota','Mississippi',
  'Missouri','Montana','Nebraska','Nevada','New Hampshire','New Jersey','New Mexico','New York','North Carolina','North Dakota','Ohio','Oklahoma', 'Oregon','Pennsylvania','Rhode Island','South Carolina','South Dakota','Tennessee','Texas','Utah','Vermont','Virginia','Washington','West Virginia',
  'Wisconsin','Wyoming'); 
foreach($states as $state)
{
	if($user_details['State']==$state){
		$stat = "selected='selected'";
	}else{
		$stat = "";
	}
 echo "<option value='$state'>$state</option>";
}
?>
</select>

</div>

<div class="col-md-6">
<label for="lastname">* City:</label><div class="clear"></div>
<input class='form-control' type="text" id="CityName" name="CityName" value="" />
</div>

<div class="col-md-6">
<label for="lastname">* Zip Code:</label><div class="clear"></div>
<input class='form-control' id="Zipcode"  name="Zipcode" type="text" value="" required />
</div>

</div>   <!-- show parent deails section end---->

<div class="col-md-12" align="center">
<input type="submit"  name="submit" value=" Create Profile " style="margin-top:20px" />
</div>
</form>
<div class="clear"></div>

</div>
</div>
</div> 
</section>