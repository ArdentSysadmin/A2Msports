<!--  <section id="single_player" class="container secondary-page">
<div class="top-score-title right-score col-md-9">

<h3><?php echo $this->session->userdata('user'); ?></h3>
<h4><b>Name:</b>  <?php echo $res['Firstname']." ".$res['Lastname']; ?> </h4>        
<h4><b>Email:</b> <?php echo $res['EmailID']; ?> </h4>  

<a href="<?php echo $logout; ?>"> Log Out</a>


</div>
</section>          -->


<script src="<?php echo base_url();?>js/jquery-1.10.2.js" type="text/javascript"></script>



<script type="text/javascript">

$(document).ready(function(){
/*	
var baseurl = "<?php echo base_url();?>";

$('#CountryName').on('change',function(){

var countryID = $(this).val();
if(countryID=='1'){
//alert("hello");
$.ajax({
type:'POST',
url:baseurl+'register/ajaxLoc/',
data:'country_id='+countryID,
success:function(html){

//var str = "html";

//var res = str.split(" ");
//	alert(html.indexOf('@'));

var xx = html.split("@");

$('#state_div').html(xx[0]);
//$('#city_div').html(xx[1]);
$('#city_div').html("<input type = 'text' name = 'CityName' id = 'CityName' Placeholder='Enter City' />");
}
}); 
}else{
$('#state_div').html("<input type = 'text' name = 'StateName' id = 'StateName' Placeholder='Enter State' />");
$('#city_div').html("<input type = 'text' name = 'CityName' id = 'CityName' Placeholder='Enter City' />"); 
}
});
*/

$('#EmailID').blur(function(){

var baseurl = "<?php echo base_url();?>";
var email_id = $(this).val();

if(email_id!=""){
$.ajax({
type:'POST',
url:baseurl+'register/email_check/',
data:'email_id='+email_id,
success:function(html){
var stat = html;
if(stat!=""){
$('#email_stat').html(stat);
$('#EmailID').val("");
}
else {
$('#email_stat').html("");
}
}
}); 
}
});


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

$(document).ready(function(){

var country = "<?php echo $user_details['Country']; ?>";

if(country=='United States of America')
	{
	$("#state_drop").show();
	}
	else
	{
	$("#state_box").show();
	}

$(function () {
    yourFunction(); //this calls it on load
    $("select#CountryName").change(yourFunction);
});

function yourFunction() {
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
}


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
 
    if (anyBoxesChecked == false) {
      alert('Please select at least one Interested Sport ');
      return false;
    } 
}
</script>



<section id="login" class="container secondary-page">  
<div class="general general-results players">

<div class="top-score-title col-md-12">
<div class="col-md-6"><h3 style="text-align:left !important">Update Your Profile <span>Now</span><span class="point-int">!</span></h3></div>

<div class="col-md-12 login-page">



<form method="post" id="myform" enctype="multipart/form-data" action="<?php echo base_url(); ?>profile/update_fb_user_data" 
onsubmit="return checkChecked('myform');" class="register-form"> 

<div class="col-md-6">
<label for="username">Dispaly Name:</label><div class="clear"></div>
<input id="username" name="username" value="<?php echo $user_details['UserProfileName']; ?>"  type="text" />
</div>

<!--<input id="username" name="username" value="<?php echo set_value('username'); ?>"  type="text" />-->

<div class="col-md-6">
<label for="email">* Email:</label><div class="clear"></div>

<input id="EmailID" name="EmailID" value="<?php echo $user_details['EmailID']; ?>" type="text" required />
<div id="email_stat" style="color:red;"></div>
</div>

<div class="col-md-6">
<label for="Firstname">* Player's First Name:</label><div class="clear"></div>
<input id="Firstname" name="Firstname" type="text" value="<?php echo $user_details['Firstname'] ?>" required/>
</div>

<div class="col-md-6">
<label for="Lastname">* Player's Last Name:</label><div class="clear"></div>
<input id="Lastname" name="Lastname" type="text" value="<?php echo $user_details['Lastname']; ?>" required/>
</div>


<div class="col-md-6">
<label for="alter_name">Alternate Email:</label><div class="clear"></div>
<input id="AlternateEmailID" name="AlternateEmailID" value="<?php echo $user_details['AlternateEmailID']; ?>" type="text" />
</div>

<div class="col-md-6" style="padding-bottom:15px">
<label for="gender">* Gender: </label><div class="clear"></div>
<input name="Gender" type="radio" value="1" style="margin-bottom:22px" <?php if($user_details['Gender']==1){echo "checked='checked'"; } ?>> Male  <input name="Gender" type="radio" value="0" <?php if($user_details['Gender']==0){echo "checked='checked'"; }?>> Female  
</div>

<div class="col-md-6 input-group internal">
<label for="lastname">* Date of birth:</label><div class="clear"></div>
<input class='form-control' id="txt_dob" type="date" name="txt_dob" 
value="<?php if($user_details['DOB']){ echo date('Y-m-d',strtotime($user_details['DOB'])); }?>" required />
</div>

<div class="col-md-6">
<label for="Profilepic">Profile Picture:</label><div class="clear"></div>
<input id="Profilepic" name="Profilepic" style="margin-bottom:28px" value="<?php echo $user_details['Profilepic']; ?>"  type="file"/>
</div>

<!--
<div id='parent-section' style="display:none">
<div class="col-md-6">
<label for="lastname">* Parent/Guardian Name</label><div class="clear"></div>
<input id="parent_name" name="Parentname" type="text" value="<?php echo $user_details['Parentname']; ?>"/>
</div>
<div class="col-md-6">
<label for="lastname">* Parent/Guardian Email:</label><div class="clear"></div>
<input id="parent_email" name="Parentemail" type="text" value="<?php echo $user_details['Parentemail']; ?>"/>
</div>
</div>  -->

<div class="col-md-6">
<label for="HomePhone">Home phone:</label><div class="clear"></div>
<input id="HomePhone" name="HomePhone"  maxlength="10" type="text" value="<?php echo $user_details['HomePhone']; ?>" maxlength='15' />
</div>

<div class="col-md-6">
<label for="lastname">* Cell phone:</label><div class="clear"></div>
<input id="playinglevel" name="Mobilephone"  maxlength="10"  type="text" value="<?php echo $user_details['Mobilephone']; ?>" maxlength='15' />
</div>

<div class="col-md-6">
<label for="lastname">* Address Line1:</label><div class="clear"></div>
<input id="address1" name="UserAddressline1" type="text" value="<?php echo $user_details['UserAddressline1']; ?>" required/>
</div>

<div class="col-md-6">
<label for="lastname"> Address Line2:</label><div class="clear"></div>
<input id="address2" name="UserAddressline2" type="text" value="<?php echo $user_details['UserAddressline2']; ?>"/>
</div>


<div class="col-md-6">
<label for="country">* Country:</label><div class="clear"></div>

<?php  /*echo '<select name="CountryName" id="CountryName">
<option value="">Select Country</option>';

foreach($countries as $row) {  */ ?>

<!-- <option value='<?php //echo $row->Country_ID; ?>'><?php //echo $row->CountryName ; ?></option> -->

<?php //}	echo '</select>'; ?>


<select name="CountryName" id="CountryName" required>
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
 echo "<option value='$country' $stat>$country</option>";
}
?>
</select>
</div>

<!--
<div id='country-section' style="display:none">
<div class="col-md-6">
<label for="lastname">* State</label><div class="clear"></div>
<input id="state_name" name="state_ID" type="text"/>
</div>
<div class="col-md-6">
<label for="lastname">* City:</label><div class="clear"></div>
<input id="city_name" name="City_ID" type="text"/>
</div>
</div>
-->

<div class="col-md-6" style='display:none;' id='state_box'>
<label for="lastname">* State:</label><div class="clear"></div>
<input type='text' name='StateName1' id='StateName' Placeholder='Enter State' value="<?php echo $user_details['State']; ?>"  />
</div>

<div class="col-md-6" id="state_drop" style='display:none;'>	
<label for="country">* State:</label><div class="clear"></div>
<select name="StateName" id="StateName">

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
 echo "<option value='$state' $stat>$state</option>";
}
?>

</select>
</div>

<div class="col-md-6">
<label for="lastname">* City:</label><div class="clear"></div>
<input type='text' name='CityName' id='CityName' Placeholder='Enter City'  value="<?php echo $user_details['City']; ?>" required />
</div>

<div class="col-md-6">
<label for="zipcode">* Postal Code:</label><div class="clear"></div>
<input id="zipcode" name="Zipcode" type="text" maxlength='10'  value="<?php echo $user_details['Zipcode']; ?>"required/>
</div>

<div class="col-md-12" style="padding-top:10px">
<label for="Sportsintrests">* Interested in:</label><div class="clear"></div>

<?php 
$option_array = array();
//if(//$user_details['Sportsintrests']!="")
//{
//$option_array = json_decode($user_details['Sportsintrests']);  
//}
?>

<input type="checkbox" name="Sportsintrests[]" value="1">Tennis &nbsp;
<input type="checkbox" name="Sportsintrests[]" value="2">Table Tennis &nbsp;
<input type="checkbox" name="Sportsintrests[]" value="3">Badminton &nbsp;
<input type="checkbox" name="Sportsintrests[]" value="4">Golf &nbsp;
<input type="checkbox" name="Sportsintrests[]" value="5">Racquetball &nbsp;
<input type="checkbox" name="Sportsintrests[]" value="6"> Squash &nbsp;

</div>
<div class="col-md-12" align="center">
<input name="submit" type="submit" value="Update Profile" style="margin-top:20px"/>
</div>

</form>

<div class="clear"></div>
</div>
</div>

</div> 
</section>