<style>
.form-control {width:75%; margin-bottom:25px;}
</style>
<script>
function check(input){  
    if(input.validity.typeMismatch){  
        input.setCustomValidity(input.value + "' is not a valid email.");  
    }
    else{  
        input.setCustomValidity("");  
    }        
}
</script>
<script type="text/javascript">
$(document).ready(function(){    
$('#EmailID').val("");


$(document).on('click', '#reset_pwd', function() {
	var baseurl	= "<?php echo base_url();?>";
	var email_id = $('#temp_email').val();
	var uid			= $('#temp_uid').val();
	$('#reset_pwd').html("Please wait...");
if(email_id && uid){
	$.ajax({
	type:'POST',
	url:baseurl+'login/reset_email_pwd',
	data:{req_email:email_id, user:uid},
	success:function(res){
		if(res){
			alert("Reset Password link sent to your email.")
			window.location.replace(baseurl+"login");
		}
		else{
			alert("Something wrong! please try after some time.");
			$('#reset_pwd').html("Reset Password ?");
		}
	}
	}); 
}

});

$('#EmailID').blur(function(){
var baseurl	= "<?php echo base_url();?>";
var email_id = $(this).val();

if(email_id!=""){
	$.ajax({
	type:'POST',
	url:baseurl+'register/ajax_email_verify/',
	data:'email_id='+email_id,
	success:function(html){
		var stat = html;
		if(stat!=""){
			var sp = stat.split('-');
			$('#email_stat').html(sp[1] + " already exists! <br />want to <a id='reset_pwd' style='cursor:pointer;'><b>Reset Password</b>?</a>");
			//$('#email_stat').html(stat);
			$('#temp_uid').val(sp[0]);
			$('#temp_email').val(sp[1]);

			$('#EmailID').val("");
		}
		else {
			$('#email_stat').html("");
			$('#temp_uid').val('');
			$('#temp_email').val('');
		}
	}
	}); 
}
});

$('#myform').on('submit',function(){
   //$('#reg_user').val('Please Wait...');
   $( ".addn_sports" ).removeAttr("disabled");

   window.onbeforeunload = function () {
		$("input[type=submit]").attr("disabled", "disabled");
   };
});

$('#primary_sport_type').change(function() {
	var temp1 = $(this).val();
	$( ".addn_sports" ).removeAttr("disabled");
    $( ".addn_sports" ).prop("checked", false);

	$('#ads_'+temp1).prop("checked", true);

	//$('#ads_'+temp1).prop("checked", true);
	if($('#ads_'+temp1).length){
	$('#ads_'+temp1).attr('disabled', 'disabled'); 
	$('#ads_'+temp1).attr('readonly', 'true');
	}

});

$('#org_url').blur(function(){
var baseurl = "<?php echo base_url();?>";
var org_url = $(this).val();

if(org_url!=""){
	$.ajax({
	type:'POST',
	url:baseurl+'register/org_url_check/',
	data:'org_url='+org_url,
	success:function(html){
	var stat = html;
	if(stat!=""){
		$('#url_stat').html(stat);
		$('#org_url').val("");
	}
	else{
		$('#url_stat').html("");
	}
	}
	}); 
}
});

$('#academy0').bind('blur', function(){

var Aca = $(this).val();
var org_id = $('#org_id0').val();
var stat = Aca+ " Club is not in our list.";

if(Aca == ""){
	$('#org_id0').val("");
}
else if(org_id == ""){
	$('#org_stat').html(stat);
	$('#academy0').val("");
}
else if(org_id != ""){
	$('#org_stat').html("");
}

});

$('input[name=confirm_password]').blur(function(){
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
$(document).ready(function () {

$(".organizer").change(function () {
if (this.value == "1") { //check value if it is domicilio
$("#org_details").show();
$("#page_checked1").attr('disabled', false);
$("#page_checked").attr('checked', true);
$("#org_checked").attr('checked', false);  
} else {
$("#org_details").hide();
$("#org_checked1").attr('checked', false);
$("#page_checked1").attr('disabled', true);
$("#page_checked").attr('checked', true);
$('#business').stop(true,true).hide(1000); //else hide
$('.org').val('');
}
});

$(".page").change(function () { //use change event
if (this.value == "1") { //check value if it is domicilio
$('#business').stop(true,true).show(1000); //than show
} else {
$('#business').stop(true,true).hide(1000); //else hide
$('.org').val('');
}
});
});
</script>

<script>
$(document).ready(function () {
$(".club_page").change(function () { //use change event
if (this.value == "1") { //check value if it is domicilio
$('#club').show(); //than show
$('#club1').show();
} else {
$('#club').hide(); //else hide
$('#club1').hide(); 
}
});
$(".coach_page").change(function () { //use change event
if (this.value == "1") { //check value if it is domicilio
$('#coach').show(); //than show
} else {
$('#coach').hide(); //else hide
}
});

});
</script>

<script> 
function checkChecked(formname) {
var anyBoxesChecked = false;

/*$('#' + formname + ' input[name="Sportsintrests"]:checked').each(function() {
if ($(this).is(":checked")) {
anyBoxesChecked = true;
}
});*/
$("input:checkbox[class=sport_class]").each(function () {
if ( $(this).is(":checked")){
anyBoxesChecked = true;
}
});

if (anyBoxesChecked == false){
alert('Please select at least one Interested Sport ');
return false;
} 
}
</script>


<!-- -----------------Terms and conditions--------------------- -->
<script language="javascript" type="text/javascript">

function terms_conditions()
{
var path = "<?php echo base_url(); ?>";
var left  = ($(window).width()/2)-(725/2),
top   = ($(window).height()/2)-(600/2),
popup = window.open (path+'register/terms_conditions/', "popup", "width=725,scrollbars=1,height=600, top="+top+", left="+left);

// popup = window.open (path+'register/terms_conditions/', "popup", "width=725, height=600,scrollbars=1");
// window.open(path+'league/terms_conditions/',null,"height=650,width=700,status=yes,toolbar=no,menubar=no,location=no, top="+top+", left="+left");
}

</script>
<!-- -----------------end of Terms and conditions--------------------- -->

<!-- -----------------Academy autocomplete--------------------- -->
<script>
$(document).ready(function(){

var baseurl = "<?php echo base_url();?>";

$("#academy0").autocomplete({

source: function( request, response ) {
$.ajax({
url: baseurl+'register/autocomplete',
dataType: "json",
method: 'post',
data: {
name_startsWith: request.term,
type: 'Academy',
row_num : 1
},
success: function( data ) {
response( $.map( data, function( item ) {
var code = item.split("|");
return {
label: code[0],
value: code[0],
data : item
}
}));
}
});
},
autoFocus: true,	      	
minLength: 1,
select: function( event, ui ) {
var names = ui.item.data.split("|");						
$('#org_id0').val(names[1]);
}		      	
});

});

</script>

<script type="text/javascript">
$(document).ready(function(){
var count = 0;
$("#add_club").click(function(){
count =count +1;

if(count < 3){ 

//console.log(count);
var sp = "";
sp += "<option value=''>select</option>";
sp += "<option value='1'>Tennis</option>";
sp += "<option value='2'>Table Tennis</option>";
sp += "<option value='3'>Badminton</option>";
sp += "<option value='4'>Golf</option>";
sp += "<option value='5'>Racquetball</option>";
sp += "<option value='6'>Squash</option>";
sp += "<option value='7'>Pickleball</option>";
sp += "<option value='8'>Chess</option>";
sp += "<option value='9'>Carroms</option>";
sp += "<option value='10'>Volleyball</option>";


$("#club").append("<div class='col-md-4'><input class='form-control' id='academy"+count+"' name='club_name[]' class='ui-autocomplete-input col-md-3' type='text' placeholder='USTA / USATT' /> <input class='form-control' id='org_id"+count+"' class='ui-autocomplete-input form-control'  name='org_id[]' type='hidden' placeholder='Org_id' value='' /> <div id='org_stat"+count+"' style='color:red;'></div> </div>  <div class='col-md-4'><input class='form-control' name='club_id[]' class='' type='text'/></div> <div class='col-md-4'><select class='form-control' name='club_sport[]' class='form-control'>"+sp+"</select> </div>");

var baseurl = "<?php echo base_url();?>";

$("#academy1").autocomplete({

source: function( request, response ){

$.ajax({
url: baseurl+'register/autocomplete',
dataType: "json",
method: 'post',
data: {
name_startsWith: request.term,
type: 'Academy',
row_num : 1
},
success: function( data ) {
response( $.map( data, function( item ) {
var code = item.split("|");
return {
label: code[0],
value: code[0],
data : item
}
}));
}
});
},
autoFocus: true,	      	
minLength: 1,
select: function( event, ui ){
var names = ui.item.data.split("|");						
$('#org_id1').val(names[1]);
}		      	
});


$('#academy1').bind('blur', function(){

var Aca	   = $(this).val();
var org_id = $('#org_id1').val();
var stat   = Aca+ " Club is not in our list.";

if(Aca == ""){
	$('#org_id1').val("");
}
else if(org_id == ""){
	$('#org_stat1').html(stat);
	$('#academy1').val("");
}
else if(org_id != ""){
	$('#org_stat1').html("");
}

});

$("#academy2").autocomplete({

source: function( request, response ){

$.ajax({
url: baseurl+'register/autocomplete',
dataType: "json",
method: 'post',
data: {
name_startsWith: request.term,
type: 'Academy',
row_num : 1
},
success: function( data ) {
response( $.map( data, function( item ) {
var code = item.split("|");
return {
label: code[0],
value: code[0],
data : item
}
}));
}
});
},
autoFocus: true,	      	
minLength: 1,
select: function( event, ui ){
var names = ui.item.data.split("|");						
$('#org_id2').val(names[1]);
}		      	
});

$('#academy2').bind('blur', function(){
	var Aca	   = $(this).val();
	var org_id = $('#org_id2').val();
	var stat   = Aca+ " Club is not in our list.";

	if(Aca == ""){
		$('#org_id2').val("");
	}
	else if(org_id == ""){
		$('#org_stat2').html(stat);
		$('#academy2').val("");
	}
	else if(org_id != ""){
		$('#org_stat2').html("");
	}
});

}
else
{
alert("Can't add more");
return false;
}

});

});
</script>
<!-- ----------------end of academy autocomplete--------------------- -->

<section id="login" class="container secondary-page">  
<div class="general general-results players">

<div class="top-score-title col-md-12">
<div class="col-md-6"><h3 style="text-align:left !important">Register <span>Now</span><span class="point-int">!</span></h3></div>
<div class="col-md-6 regfatext">Want to register with Google/Facebook <a href="<?php echo base_url();?>Login">Click here</a></div>
<div class="clear"></div>
<div class="col-md-3">&nbsp;</div> 
<div class="col-md-6 login-page" style="background:#fff">
<?php //echo validation_errors('<p class="error">'); ?>
<?php //echo validation_errors(); ?>

<form method="post" id="myform" enctype="multipart/form-data" action="<?php echo base_url(); ?>register/save_user_data" onsubmit="return checkChecked('myform');" class="register-form"> 

<div class="col-md-12">
<label for="Firstname">* First Name:</label><div class="clear"></div>
<input class='form-control' id="Firstname" name="Firstname" type="text" required />
</div>

<div class="col-md-12">
<label for="Lastname">* Last Name:</label><div class="clear"></div>
<input class='form-control' id="Lastname" name="Lastname" type="text" required />
</div>


<!--<input id="username" name="username" value="<?php echo set_value('username'); ?>"  type="text" />-->

<div class="col-md-12">
<label for="email">* Email:</label><div class="clear"></div>
<input class='form-control' id="EmailID" name="EmailID"  type="email" oninvalid="check(this)" autocomplete="off" required />
<div id="email_stat" style="color:red; margin-bottom:15px;"><?php echo $this->session->flashdata('err_msg');?></div>
</div>

<div class="col-md-12">
<label for="Password">* Password:</label><div class="clear"></div>
<input class='form-control' id="Password" name="Password" type="password" required/>
</div>

<div class="col-md-12">
<label for="lastname">* Mobile Phone:</label><div class="clear"></div>
<input class='form-control' id="playinglevel" name="Mobilephone" maxlength="12"  type="number" placeholder="Enter 10 digit phone number" />
</div>

<div class="col-md-12">
<label for="Profilepic">Profile Picture:</label><div class="clear"></div>
<input id="Profilepic" name="Profilepic" style="margin-bottom:28px" type="file"/>
</div>

<div id='parent-section' style="display:none">
<div class="col-md-12">
<label for="lastname">* Parent/Guardian Name</label><div class="clear"></div>
<input class='form-control' id="parent_name" name="Parentname" type="text"/>
</div>
<div class="col-md-12">
<label for="lastname">* Parent/Guardian Email:</label><div class="clear"></div>
<input class='form-control' id="parent_email" name="Parentemail" type="text"/>
</div>
</div>

<!-- <div class="col-md-6">
<label for="HomePhone">Home phone:</label><div class="clear"></div>
<input id="HomePhone" name="HomePhone" maxlength="10" type="text" maxlength='15' />
</div> -->						

<div class="col-md-12" style="padding-bottom:15px">
<label for="gender">* Gender: </label><div class="clear"></div>
	<select class='form-control' name="Gender" style="width:40%;" required>
	<option value=''>Select</option>
	<option value='1'>Male</option>
	<option value='0'>Female</option>
	</select>
</div>
<!-- <div class="col-md-6">
<label for="lastname">* Address Line1:</label><div class="clear"></div>
<input id="address1" name="UserAddressline1" type="text" required/>
</div>

<div class="col-md-6">
<label for="lastname"> Address Line2:</label><div class="clear"></div>
<input id="address2" name="UserAddressline2" type="text"/>
</div> -->


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


<!-- <div class="col-md-6" style='display:none;' id='state_box'>
<label for="lastname">* State:</label><div class="clear"></div>
<input type='text' name='StateName1' id='StateName1' Placeholder='Enter State' />
</div>
-->						
<!-- <div class="col-md-6" id="state_drop">	
<label for="country">* State:</label><div class="clear"></div>

<select name="StateName" id="StateName">
<option value="">Select State</option>
<option value="Alabama">Alabama</option>
<option value="Alaska">Alaska</option>
<option value="Arizona">Arizona</option>
<option value="Arkansas">Arkansas</option>
<option value="California">California</option>
<option value="Colorado">Colorado</option>
<option value="Connecticut">Connecticut</option>
<option value="Delaware">Delaware</option>
<option value="District Of Columbia">District Of Columbia</option>
<option value="Florida">Florida</option>
<option value="Georgia">Georgia</option>
<option value="Hawaii">Hawaii</option>
<option value="Idaho">Idaho</option>
<option value="Illinois">Illinois</option>
<option value="Indiana">Indiana</option>
<option value="Iowa">Iowa</option>
<option value="Kansas">Kansas</option>
<option value="Kentucky">Kentucky</option>
<option value="Louisiana">Louisiana</option>
<option value="Maine">Maine</option>
<option value="Maryland">Maryland</option>
<option value="Massachusetts">Massachusetts</option>
<option value="Michigan">Michigan</option>
<option value="Minnesota">Minnesota</option>
<option value="Mississippi">Mississippi</option>
<option value="Missouri">Missouri</option>
<option value="Montana">Montana</option>
<option value="Nebraska">Nebraska</option>
<option value="Nevada">Nevada</option>
<option value="New Hampshire">New Hampshire</option>
<option value="New Jersey">New Jersey</option>
<option value="New Mexico">New Mexico</option>
<option value="New York">New York</option>
<option value="North Carolina">North Carolina</option>
<option value="North Dakota">North Dakota</option>
<option value="Ohio">Ohio</option>
<option value="Oklahoma">Oklahoma</option>
<option value="Oregon">Oregon</option>
<option value="Pennsylvania">Pennsylvania</option>
<option value="Rhode Island">Rhode Island</option>
<option value="South Carolina">South Carolina</option>
<option value="South Dakota">South Dakota</option>
<option value="Tennessee">Tennessee</option>
<option value="Texas">Texas</option>
<option value="Utah">Utah</option>
<option value="Vermont">Vermont</option>
<option value="Virginia">Virginia</option>
<option value="Washington">Washington</option>
<option value="West Virginia">West Virginia</option>
<option value="Wisconsin">Wisconsin</option>
<option value="Wyoming">Wyoming</option>
</select>

</div>

<div class="col-md-6">
<label for="lastname">* City:</label><div class="clear"></div>
<input type='text' name='CityName' id='CityName' Placeholder='Enter City' required />
</div>
-->						
<div class="col-md-12">
<label for="zipcode">* Zip/Postal Code:</label><div class="clear"></div>
<input class='form-control' id="zipcode" name="Zipcode" type="text" maxlength='10' required/>
</div>

<div class="col-md-12" style="padding-top:10px">
<label for="Sportsintrests">* Interested in:</label><div class="clear"></div>
<div class='row'>
	<div class='col-md-4'>

<?php 
$x=1;
foreach($intrests as $row) { 
?> 
<input type="checkbox" id="sp<?php echo $row->SportsType_ID;?>" class="sport_class" name="Sportsintrests[]" value="<?php echo $row->SportsType_ID;?>"> &nbsp;<label for="sp<?php echo $row->SportsType_ID;?>"><?php echo $row->Sportname;?> &nbsp;</label><br>
<?php 
if($x%7 == 0)
	echo "	</div>	<div class='col-md-4'>";

$x++;
} ?>
	</div>
</div>



</div>

<!-- <div class="col-md-12" style="margin-bottom: 25px;">
<label for="AddnSports">Additional Sports ?</label><div class="clear"></div>
<div class="row">

	<div class="col-md-2 col-xs-4" style="width:25%">
	<input type="checkbox" class="sport_class" name="Sportsintrests[]" value="1">&nbsp;Tennis<br>
	<input type="checkbox" class="sport_class" name="Sportsintrests[]" value="2" checked="">&nbsp;Table Tennis<br>
	<input type="checkbox" class="sport_class" name="Sportsintrests[]" value="3">&nbsp;Badminton<br>
	<input type="checkbox" class="sport_class" name="Sportsintrests[]" value="4">&nbsp;Golf<br>
	<input type="checkbox" class="sport_class" name="Sportsintrests[]" value="17">&nbsp;General Fitness<br>
	</div>

	<div class="col-md-2 col-xs-4" style="width:25%">
	<input type="checkbox" class="sport_class" name="Sportsintrests[]" value="5">&nbsp;Racquetball<br>
	<input type="checkbox" class="sport_class" name="Sportsintrests[]" value="6">&nbsp;Squash<br>
	<input type="checkbox" class="sport_class" name="Sportsintrests[]" value="7">&nbsp;Pickleball<br>
	<input type="checkbox" class="sport_class" name="Sportsintrests[]" value="8">&nbsp;Chess<br>
	</div>

	<div class="col-md-2 col-xs-4" style="width:25%">
	<input type="checkbox" class="sport_class" name="Sportsintrests[]" value="9">&nbsp;Carroms<br>
	<input type="checkbox" class="sport_class" name="Sportsintrests[]" value="10">&nbsp;Volleyball<br>
	<input type="checkbox" class="sport_class" name="Sportsintrests[]" value="11">&nbsp;Fencing<br>
	<input type="checkbox" class="sport_class" name="Sportsintrests[]" value="12">&nbsp;Bowling<br>
	</div>

	<div class="col-md-2 col-xs-4" style="width:25%">
	<input type="checkbox" class="sport_class" name="Sportsintrests[]" value="13">&nbsp;Soccer<br>
	<input type="checkbox" class="sport_class" name="Sportsintrests[]" value="14">&nbsp;Lacrosse<br>
	<input type="checkbox" class="sport_class" name="Sportsintrests[]" value="15">&nbsp;Throwball<br>
	<input type="checkbox" class="sport_class" name="Sportsintrests[]" value="16">&nbsp;Cricket<br>
	</div>

</div>
 -->
<script>
$(document).ready(function(){
$('#myform').submit(function() {
if (!($('#recommend').is(':checked'))) {
alert("Please accept the Terms & Conditions");
return false;
}
else { return true; }
});
});
</script>

<div class="col-md-12" style="padding-top:40px;">
<input type="checkbox" name="recommend" id="recommend" value="1" />&nbsp;
I accept the <a style='cursor:pointer;' onclick='terms_conditions()'><b>Terms & Conditions</b></a> of A2M Sports.<br />
</div>

<div class="col-md-12" align="center">
<input type='hidden' name='temp_uid'		id='temp_uid'	 value='' />
<input type='hidden' name='temp_email'	id='temp_email' value='' />

<input name="reg_user" id="reg_user" type="submit" value="REGISTER" style="padding: 10px 30px; font-weight: bold; margin-top:20px; border:#81a32b; background-color:#81a32b" />
<span id='wait_txt' style="display:none;"><h3>Please wait....</h3></span>
</div>

</form>

<div class="clear"></div>
</div>
<div class="col-md-3">&nbsp;</div> 

</div>
</div> 
</section>
<script>
/*$(document).ready(function() {
	$('#reg_user').click(function() {
		$(this).hide();
		$('#wait_txt').show();
	});

});*/
</script>