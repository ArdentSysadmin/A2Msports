<script>
$(document).ready(function(){
	$('#country1')
    .val('United States of America')
    .trigger('change');
});
</script>

<div id='TeamsRanking'>
<div class="fromtitle">Search for Team Rankings</div>

<form method="post" id="myform"  action="<?php echo base_url();?><?php echo $sport_segment;?>#MembersLoc"> 
<!-- <div class='col-md-4 form-group internal' style="padding-left:0px">
<input class='form-control' id='name' name='name' type='text' placeholder="Team Name" value="<?php echo $search_uname; ?>"  size="25" />
</div> -->
<div class='col-md-4 form-group internal' style="padding-left:0px">  
<select class='form-control' id='country1' name='country'>
		<option value="">Select Country</option>
		<?php
		$countries = array("Afghanistan", "Albania", "Algeria", "American Samoa", "Andorra", "Angola", "Anguilla", "Antarctica", "Antigua and Barbuda", "Argentina", "Armenia", "Aruba", "Australia", "Austria", "Azerbaijan", "Bahamas", "Bahrain", "Bangladesh", "Barbados", "Belarus", "Belgium", "Belize", "Benin", "Bermuda", "Bhutan", "Bolivia", "Bosnia and Herzegowina", "Botswana", "Bouvet Island", "Brazil", "British Indian Ocean Territory", "Brunei Darussalam", "Bulgaria", "Burkina Faso", "Burundi", "Cambodia", "Cameroon", "Canada", "Cape Verde", "Cayman Islands", "Central African Republic", "Chad", "Chile", "China", "Christmas Island", "Cocos (Keeling) Islands", "Colombia", "Comoros", "Congo", "Congo, the Democratic Republic of the", "Cook Islands", "Costa Rica", "Cote d'Ivoire", "Croatia (Hrvatska)", "Cuba", "Cyprus", "Czech Republic", "Denmark", "Djibouti", "Dominica", "Dominican Republic", "East Timor", "Ecuador", "Egypt", "El Salvador", "Equatorial Guinea", "Eritrea", "Estonia", "Ethiopia", "Falkland Islands (Malvinas)", "Faroe Islands", "Fiji", "Finland", "France", "France Metropolitan", "French Guiana", "French Polynesia", "French Southern Territories", "Gabon", "Gambia", "Georgia", "Germany", "Ghana", "Gibraltar", "Greece", "Greenland", "Grenada", "Guadeloupe", "Guam", "Guatemala", "Guinea", "Guinea-Bissau", "Guyana", "Haiti", "Heard and Mc Donald Islands", "Holy See (Vatican City State)", "Honduras", "Hong Kong", "Hungary", "Iceland", "India", "Indonesia", "Iran (Islamic Republic of)", "Iraq", "Ireland", "Israel", "Italy", "Jamaica", "Japan", "Jordan", "Kazakhstan", "Kenya", "Kiribati", "Korea, Democratic People's Republic of", "Korea, Republic of", "Kuwait", "Kyrgyzstan", "Lao, People's Democratic Republic", "Latvia", "Lebanon", "Lesotho", "Liberia", "Libyan Arab Jamahiriya", "Liechtenstein", "Lithuania", "Luxembourg", "Macau", "Macedonia, The Former Yugoslav Republic of", "Madagascar", "Malawi", "Malaysia", "Maldives", "Mali", "Malta", "Marshall Islands", "Martinique", "Mauritania", "Mauritius", "Mayotte", "Mexico", "Micronesia, Federated States of", "Moldova, Republic of", "Monaco", "Mongolia", "Montserrat", "Morocco", "Mozambique", "Myanmar", "Namibia", "Nauru", "Nepal", "Netherlands", "Netherlands Antilles", "New Caledonia", "New Zealand", "Nicaragua", "Niger", "Nigeria", "Niue", "Norfolk Island", "Northern Mariana Islands", "Norway", "Oman", "Pakistan", "Palau", "Panama", "Papua New Guinea", "Paraguay", "Peru", "Philippines", "Pitcairn", "Poland", "Portugal", "Puerto Rico", "Qatar", "Reunion", "Romania", "Russian Federation", "Rwanda", "Saint Kitts and Nevis", "Saint Lucia", "Saint Vincent and the Grenadines", "Samoa", "San Marino", "Sao Tome and Principe", "Saudi Arabia", "Senegal", "Seychelles", "Sierra Leone", "Singapore", "Slovakia (Slovak Republic)", "Slovenia", "Solomon Islands", "Somalia", "South Africa", "South Georgia and the South Sandwich Islands", "Spain", "Sri Lanka", "St. Helena", "St. Pierre and Miquelon", "Sudan", "Suriname", "Svalbard and Jan Mayen Islands", "Swaziland", "Sweden", "Switzerland", "Syrian Arab Republic", "Taiwan, Province of China", "Tajikistan", "Tanzania, United Republic of", "Thailand", "Togo", "Tokelau", "Tonga", "Trinidad and Tobago", "Tunisia", "Turkey", "Turkmenistan", "Turks and Caicos Islands", "Tuvalu", "Uganda", "Ukraine", "United Arab Emirates", "United Kingdom", "United States of America", "United States Minor Outlying Islands", "Uruguay", "Uzbekistan", "Vanuatu", "Venezuela", "Vietnam", "Virgin Islands (British)", "Virgin Islands (U.S.)", "Wallis and Futuna Islands", "Western Sahara", "Yemen", "Yugoslavia", "Zambia", "Zimbabwe");

		foreach($countries as $country){
			$selected = '';
			if($country == 'United States of America'){ $selected = 'selected'; }
		 echo "<option value='$country' $selected>$country</option>";
		}
		?>
	</select>	
	</div>

<!-- <div class='col-md-3 form-group internal' style="padding-left:0px" id="usa_state_drop">
	<select name="state" id="usa_state" class='form-control' onChange="stateChange();">
	<option value="">Select</option>
	<?php
	$states = array('Alabama','Alaska','Arizona','Arkansas','California','Colorado','Connecticut','Delaware','District of Columbia','Florida','Georgia',
	'Hawaii','Idaho','Illinois','Indiana','Iowa','Kansas','Kentucky','Louisiana','Maine','Maryland','Massachusetts','Michigan','Minnesota','Mississippi',
	'Missouri','Montana','Nebraska','Nevada','New Hampshire','New Jersey','New Mexico','New York','North Carolina','North Dakota','Ohio','Oklahoma', 'Oregon','Pennsylvania','Rhode Island','South Carolina','South Dakota','Tennessee','Texas','Utah','Vermont','Virginia','Washington','West Virginia',
	'Wisconsin','Wyoming'); 
	
	foreach($states as $stat)
	{
		if($stat == $state){
            echo "<option value='$stat' selected>$stat</option>";
		}else{
			echo "<option value='$stat'>$stat</option>";
		}
		
	}
	?>
	</select>
</div>

<div class='col-md-3 form-group internal' style="padding-left:0px;display:none;" id="india_state_drop">
	<select name="state" id="india_state" class='form-control' onChange="stateChange();">
	<option value="">Select</option>
	<?php
	 $states = array('Andhra Pradesh','Arunachal Pradesh','Assam','Bihar','Chhattisgarh','Goa','Gujarat','Haryana','Himachal Pradesh','Jammu and Kashmir','Jharkhand','Karnataka','Kerala','Madhya Pradesh','Maharashtra','Manipur','Meghalaya','Mizoram','Nagaland','Odisha','Punjab','Rajasthan','Sikkim','Tamil Nadu','Telangana','Tripura','Uttar Pradesh','Uttarakhand','West Bengal');
	foreach($states as $stat)
	{
		if($stat == $state){
            echo "<option value='$stat' selected>$stat</option>";
		}else{
			echo "<option value='$stat'>$stat</option>";
		}
		
	}
	?>
	</select>
</div>
 -->
<!-- <div class='col-md-2 form-group internal' style="display:none;" id='state_box'>
	<input class='form-control' id='state1' name='state1' type='text' value="<?php if($state1!=""){echo $state1;}?>" placeholder="State"  size="45">
</div> -->
<div id="register-submit" class="col-md-2 form-group internal" style="padding-left:15px">
<input  id='age_group_post' name='age_group_post' type='hidden' value='<?php echo json_encode($age_group);?>'>
<input  id='sport' name='sport' type='hidden' value="<?php echo $sport;?>">
<input  id='tab'   name='tab'	type='hidden' value="Rankings">
<?php if($sport != '10'){?>
<input type = "submit" name = "search_mem_loc" id = "search_mem_loc" value = " Search " />
<?php } ?>
</div>
</form>
<div class="clear"></div>
<?php
if(count($loc_query) > 0){
?>
<input type="button" class="league-form-submit1" name="capture" id="capture" value="Print" style="float:right;" onclick="print('<?=$sport;?>','<?=$search_uname;?>','<?=$country;?>','<?=$state;?>','<?=$gender;?>')" />
<?php
}?>

<div id="teams_rankings_ajax_div" class="tab-content table-responsive container2">
<!-- Results Load from Ajax request -->
</div>

<div class="clear"></div>