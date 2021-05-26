<style>
.form-control { width:75%; margin-bottom:15px;}
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

$('#myform').on('submit',function(){
   $('#reg_user').val('Please Wait...');
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

var Aca		= $(this).val();
var org_id  = $('#org_id0').val();
var stat		= Aca + " Club is not in our list.";

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

$(".club_page").change(function () { //use change event
if (this.value == "1") { //check value if it is domicilio
$('#club').show(); //than show
$('#club1').show();
} else {
$('#club').hide(); //else hide
$('#club1').hide(); 
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

	/*if (anyBoxesChecked == false){
	alert('Please select at least one Interested Sport ');
	return false;
	} */
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
<div class="col-md-6 regfatext">&nbsp;</div>
<div class="col-md-12 login-page" style="background:#fff">
<?php //echo validation_errors('<p class="error">'); ?>
<?php //echo validation_errors(); ?>

<form method="post" id="myform" enctype="multipart/form-data" action="<?php echo base_url(); ?>register/save_user_data" onsubmit="return checkChecked('myform');" class="register-form"> 

<input name="organizer"			class="organizer"		 type="hidden" value="1" />
<input name="business_page" class="business_page" type="hidden" value="1" />

<div id="business" style="display:block">
<div class="col-md-6">
<label for="email">* Academy / Club name</label><div class="clear"></div>
<input class='form-control' id="" name="org_name" class="org" type="text" required  />
</div>

<div class="col-md-6">
<label for="Firstname">* Your Name:</label><div class="clear"></div>
<input class='form-control' id="Firstname" name="Firstname" type="text" required />
</div>

<!--<input id="username" name="username" value="<?php echo set_value('username'); ?>"  type="text" />-->

<div class="col-md-6">
<label for="email">* Email:</label><div class="clear"></div>
<input class='form-control' id="EmailID" name="EmailID"  type="email" oninvalid="check(this)" required />
<div id="email_stat" style="color:red;"><?php echo $this->session->flashdata('err_msg');?></div>
</div>

<div class="col-md-6">
<label for="Password">* Login Password:</label><div class="clear"></div>
<input class='form-control' id="Password" name="Password" type="password" required />
</div>


<div class="col-md-6">
<label for="email">* Club ShortCode</label>
&nbsp;<i class="fa fa-question-circle" aria-hidden="true" title="Enter the short form, like 'abc', not the whole URL"></i>
<div class="clear"></div>
<?php //echo base_url();?><input class='form-control' id="org_url" name="org_url" value="" type="text" required />
<div id="url_stat" style="color:red;"></div>
</div>
<div class="col-md-6">
<label for="email">Phone</label><div class="clear"></div>
<input class='form-control' id="org_phone" name="org_phone" class="org" type="text" />
</div>
<div class="col-md-6">
<label for="email">Address Line 1</label><div class="clear"></div>
<input class='form-control' id="org_address" name="org_address" class="org" type="text" />
</div>
<div class="col-md-6">
<label for="email">Address Line 2</label><div class="clear"></div>
<input class='form-control' id="org_address2" name="org_address2" class="org" type="text" />
</div>
<div class="col-md-6">
<label for="email">City</label><div class="clear"></div>
<input class='form-control' id="org_city" name="org_city" class="org" type="text" />
</div>
<div class="col-md-6">
<label for="email">State</label><div class="clear"></div>
<input class='form-control' id="org_state" name="org_state" class="org"  type="text" />
</div>
<div class="col-md-6">
<label for="email">Country</label><div class="clear"></div>
<select class='form-control' name="org_country" id="org_country" required>
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
<option value="United States of America">United States of America</option>
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

<div class="col-md-6">
<label for="email">Zipcode</label><div class="clear"></div>
<input class='form-control' id="org_zip" name="org_zip" class="org" type="text" />
</div>
<div class="col-md-6">
<label for="org_logo">Upload Logo</label><div class="clear"></div>
<input id="org_logo" name="org_logo" type="file" style="margin-bottom:10px;" />
</div>

<div class="col-md-6">
<label for="org_fb">Club's Facebook Page </label>
&nbsp;<i class="fa fa-question-circle" aria-hidden="true" title="Enter the Facebook page name, like 'a2msports', not the whole URL"></i>
<div class="clear"></div>
<input class='form-control' id="org_fb" name="org_fb" class="org" type="text" style="width:74%;" />
</div>

<div class="col-md-6">
<label for="org_fb">Club's Instagram Page</label>
&nbsp;<i class="fa fa-question-circle" aria-hidden="true" title="Enter the Instagram page name, like 'a2msports', not the whole URL"></i>
<div class="clear"></div>
<input class='form-control' id="org_insta" name="org_insta" class="org" type="text" style="width:74%;" />
</div>

<div class="col-md-6">
<label for="org_fb">Club's Twitter Handle</label>
&nbsp;<i class="fa fa-question-circle" aria-hidden="true" title="Enter the Twitter Handle name, like 'a2msports', not the whole URL"></i>
<div class="clear"></div>
<input class='form-control' id="org_twitter" name="org_twitter" class="org" type="text" style="width:74%;" />
</div>


<div class="col-md-6">
<label for="email">Primary Sport of your Academy?</label><div class="clear"></div>
<select name="primary_sport_type" id="primary_sport_type" class='form-control' style="width:45%">
<option value="">Select</option>
<?php foreach($intrests as $row) { ?> 
<option value="<?php echo $row->SportsType_ID;?>"><?php echo $row->Sportname;?></option>
<?php } ?>
</select>
</div>

<div class="col-md-6">
<label for="email">Are you a coach of this club?</label><div class="clear"></div>
	<input type='radio' name='coach_page' id='coach_yes' value='1' /> Yes 
	&nbsp;&nbsp;
	<input type='radio' name='coach_page' id='coach_no' value='0' checked /> No 
</div>

<div class="col-md-7">
<label for="AddnSports">Additional Sports ?</label><div class="clear"></div>
<?php foreach($intrests as $row) { ?> 
<input type="checkbox" class="addn_sports"  id="ads_<?php echo $row->SportsType_ID;?>" name="aca_addn_sports[]" value="<?php echo $row->SportsType_ID;?>"> <?php echo $row->Sportname;?> &nbsp; 
<?php } ?>
</div>

<!-- 
<div class="col-md-12" style="margin-bottom: 25px;">
<label for="AddnSports">Additional Sports ?</label><div class="clear"></div>
<div class="row">
	<div class="col-md-2 col-xs-4" style="width:14%">
	<input type="checkbox" name="aca_addn_sports[]" value="1">&nbsp;Tennis<br>
	<input type="checkbox" name="aca_addn_sports[]" value="2" checked="">&nbsp;Table Tennis<br>
	<input type="checkbox" name="aca_addn_sports[]" value="3">&nbsp;Badminton<br>
	</div>
	<div class="col-md-2 col-xs-4" style="width:14%">
	<input type="checkbox" name="aca_addn_sports[]" value="4">&nbsp;Golf<br>
	<input type="checkbox" name="aca_addn_sports[]" value="5">&nbsp;Racquetball<br>
	<input type="checkbox" name="aca_addn_sports[]" value="6">&nbsp;Squash<br>
	</div>
	<div class="col-md-2 col-xs-4" style="width:14%">
	<input type="checkbox" name="aca_addn_sports[]" value="7">&nbsp;Pickleball<br>
	<input type="checkbox" name="aca_addn_sports[]" value="8">&nbsp;Chess<br>
	<input type="checkbox" name="aca_addn_sports[]" value="9">&nbsp;Carroms<br>
	</div>
	<div class="col-md-2 col-xs-4" style="width:14%">
	<input type="checkbox" name="aca_addn_sports[]" value="10">&nbsp;Volleyball<br>
	<input type="checkbox" name="aca_addn_sports[]" value="11">&nbsp;Fencing<br>
	<input type="checkbox" name="aca_addn_sports[]" value="12">&nbsp;Bowling<br>
	</div>
	<div class="col-md-2 col-xs-4" style="width:14%">
	<input type="checkbox" name="aca_addn_sports[]" value="13">&nbsp;Soccer<br>
	<input type="checkbox" name="aca_addn_sports[]" value="14">&nbsp;Lacrosse<br>
	<input type="checkbox" name="aca_addn_sports[]" value="15">&nbsp;Throwball<br>
	</div>
	<div class="col-md-2 col-xs-4" style="width:14%">
	<input type="checkbox" name="aca_addn_sports[]" value="16">&nbsp;Cricket<br>
	<input type="checkbox" name="aca_addn_sports[]" value="17">&nbsp;General Fitness<br>	</div>
</div>
</div>
 -->


</div>

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

<div class="col-md-12" style="padding-top:10px">
<input type="checkbox" name="recommend" id="recommend" value="1" />&nbsp;
I accept the <a style='cursor:pointer;' onclick='terms_conditions()'><b>Terms & Conditions</b></a> of A2M Sports.<br />
</div>

<div class="col-md-12" align="center">
<input name="reg_user" id="reg_user" type="submit" value="REGISTER" style="padding: 10px 30px; font-weight: bold; margin-top:20px; border:#81a32b; background-color:#81a32b" />
</div>

</form>

<div class="clear"></div>
</div>
</div>
</div> 
</section>