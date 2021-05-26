<style type="text/css">
.tab-score{
width:100% !important;
}
.pagination {
margin: 2px 0;
}
.pagepad {
padding-left: 0px;
padding-right: 0px;
padding-top: 8px;
}
.tab-score td:last-child {
font-weight: 400;
}
.tab-content {
padding: 0;
border-radius: 1px;
background: #fff!important; 
}

.tab-content .tab-score thead .sorting_asc {
background-image: url("<?php echo base_url(); ?>js/DataTables-1.10.16/images/sort_asc.png");
}
.tab-content .tab-score thead .sorting {
background-image: url("<?php echo base_url(); ?>js/DataTables-1.10.16/images/sort_both.png");
}
.tab-content .tab-score thead .sorting_desc {
background-image: url("<?php echo base_url(); ?>js/DataTables-1.10.16/images/sort_desc.png");
}
.tab-content .tab-score thead .sorting, .tab-content .tab-score thead .sorting_asc, .tab-content .tab-score thead .sorting_desc, .tab-content .tab-score thead .sorting_asc_disabled, .tab-content .tab-score thead .sorting_desc_disabled {
cursor: pointer;
background-repeat: no-repeat;
background-position: center right;
}
</style>

<script>
var admin_table;
$(document).ready(function(){ 
	$("#sel_all").change(function(){
	$(".checkbox1").prop('checked', $(this).prop("checked"));
	});

	$('#myform').on('submit', function (e) {
		if ($("input[type=checkbox]:checked").length === 0) {
		e.preventDefault();
		alert('Select atleast one player to send message');
		return false;
		}
	});
});
</script>

<!-- -----------------------------------Registered Players start code-------------------------------------------------- -->
<script>
$(document).ready(function(){ 

    $('#admin_filter_table').DataTable({
        "paging":   false,
        "ordering": true,
        "info":     false,
		"search":   true
    });


//	admin_table = $('#admin_filter_table').DataTable({"pageLength": 25});

	/*$("#myform").on('submit', function(e){
	var $form = $(this);

	// Iterate over all checkboxes in the table
	admin_table.$('input[type="checkbox"]').each(function(){
	// If checkbox doesn't exist in DOM
	if(!$.contains(document, this)){
	 // If checkbox is checked
	 if(this.checked){
		// Create a hidden element 
		$form.append(
		   $('<input>')
			  .attr('type', 'hidden')
			  .attr('name', this.name)
			  .val(this.value)
		);
	 }
	} 
	});          
	});*/

});

$(document).ready(function(){
var baseurl = "<?php echo base_url();?>";

$('.filter_opt').on('change',function(){
var Sport       = $('#sport').val();
var Country     = $('#CountryName').val();
var age_group   = $('#sel_age_group').val();
var user_status = $('#user_status').val();
var user_gender = $('#user_gender').val();

if(Country == 'United States of America'){
var State = $('#StateName').val();
}
else{
var State = "";
}


//admin_table.clear();


$('#load-users').html('');

$.ajax({
type:'POST',
url:baseurl+'admin/ajax_users/',
data:{spt:Sport,country:Country,state:State,age_group:age_group,user_status:user_status,user_gender:user_gender},
success:function(html){
$('#load-users').html(html);
}
});
});
});
</script>

<!-- -----------------------------------Registered Players end code-------------------------------------------------- -->

<!-- -----------------------------------Country on change code-------------------------------------------------- -->
<script>
$(document).ready(function(){
	$('#CountryName').on('change', function() {
		if ( this.value == 'United States of America'){
			$("#state_drop").show();
		}
		else{
			$("#state_drop").hide();
			$("#StateName").val("");
		}
	});
});
</script>
<!-- -----------------------------------Country on change code end -------------------------------------------------- -->

<section id="single_player" class="container secondary-page">

<div class="top-score-title right-score col-md-9">
<!-- start main body -->
<h3></h3>

<?php 
if(isset($success)){ 
?>
<div class="name" align='left'>
<label for="name_login" style="color:green"><?php echo $success; ?></label>
</div>
<?php
}
?>
<form class="form-horizontal" id='myform' method='post' role="form" action="<?php echo base_url(); ?>admin/send_email" enctype='multipart/form-data'>

<div class="col-md-12 league-form-bg" style="margin-bottom:20px;">
<div class="fromtitle">Admin page</div>

<div class="col-md-12">
<div class="form-group">
<div class="col-md-3">

<select class="form-control filter_opt" name="sport" id="sport" >
<option value="">Sport</option>
<?php
foreach($sports as $row){ ?>
<option value="<?=$row->SportsType_ID;?>">
<?=$row->Sportname;?> 
</option>
<?php 
} ?>
</select>
</div>

<div class="col-md-3">
<select class="form-control filter_opt"  name="CountryName" id="CountryName" >
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

<div class="col-md-3" id="state_drop" style="display:none">
<select class="form-control filter_opt" name="StateName" id="StateName">
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

<div class="col-md-3" id="age_group">
<select class="form-control filter_opt" name="age_group" id="sel_age_group">
<option value="">Age Group (All)</option>
<option value="kids">Kids</option>
<option value="adults">Adults</option>
</select>
</div>

<div class="col-md-3" id="active">
<select class="form-control filter_opt" name="user_status" id="user_status">
<option value="">User Status</option>
<option value="1">Active</option>
<option value="0">Inactive</option>
</select>
</div>

<div class="col-md-3" id="active">
<select class="form-control filter_opt" name="user_gender" id="user_gender">
<option value="">Gender</option>
<option value="1">Male</option>
<option value="0">Female</option>
</select>
</div>
</div>

<div>
<br />						
<div id="load-users" class="tab-content table-responsive" style="overflow-y: scroll; height:400px;">
<table id="admin_filter_table" class="table tab-score">
<thead>
<tr class="top-scrore-table">
<td class="score-position"><input type='checkbox' name="sel_all" id="sel_all" /></td>
<td class="score-position">Name</td>
<td class="score-position">Phone #</td>
</tr>
</thead>
<?php
if(count(array_filter($Users)) > 0){
foreach($Users as $name)
{
?>
<tr>
<td><input class="checkbox1" type="checkbox" name="sel_player[]" value="<?php echo $name->Users_ID;?>"  style="margin-left:10px" /></td>

<td><?php
$player = admin::get_name($name->Users_ID);
if(isset($player)){
	//$gender = 'N/A';
	//if($player['Gender'] != 'NULL'){
	$gender = ($player['Gender']) ? '(M)' : '(F)';
	//}

	echo "<b><a href='".base_url()."player/".$player['Users_ID']."'>" . ucfirst(strtolower($player['Firstname']))." ".ucfirst(strtolower($player['Lastname'])) ." ".$gender. "</a></b>";
}
?></td>
<td>
<?php
if(isset($player)){ 
		$phone = preg_replace("/^(\d{3})(\d{3})(\d{4})$/", "($1) $2-$3", $player['Mobilephone']);
		echo "<b>".$phone."</b>"; 
} ?>
</td>
</tr>
<?php 
}
}	else {
?>
<tr><td colspan='6'><b>No Users Found. </b></td></tr>
<?php
}
?>
</table>
</div>

</div>                     
<br /><br />
<div>
<input type="text" class='form-control' value="" name="subject" placeholder='Type your subject here' required />
<br />
</div>

<div>
<b>Attach File (Optional):</b>
<br />

<div class="form-group">
  <input type="file" id="file_attachment" name="attachment">
</div>

<div>
<b>Message</b>
<br />

<?php echo $this->ckeditor->editor('description', @$default_value);?> 
</div>

<input type="submit" name="admin_email" value="Send" class="league-form-submit1" style="margin:20px 0px; padding:10px 45px;" />

</div>
</div>
</div>

</form>
<div style="clear:both"></div>
</div><!--Close Top Match-->
<!-- -------------------------- Code To Select All Check Boxes Of The DataTables. ----------------------------- -->
<script>
 	$(document).ready(function (){   
	   $('#sel_all').on('click', function(){
		  var rows = admin_table.rows({ 'search': 'applied' }).nodes();
		  $('input[type="checkbox"]', rows).prop('checked', this.checked);
	   });
 	   
	   $('#admin_filter_table tbody').on('change', 'input[type="checkbox"]', function(){
		  if(!this.checked){
			 var el = $('#sel_all').get(0);
			  if(el && el.checked && ('indeterminate' in el)){
				 el.indeterminate = true;
			 }
		  }
	   });
	}); 
</script>
<script>
	$(document).ready(function (){
		$('#myform').on('submit', function(e){
		var message = CKEDITOR.instances['description'].getData();
			if(message == ''){
				e.preventDefault();
				alert('Email message should not be empty!');
				return false;
			}
		});
	});
</script>