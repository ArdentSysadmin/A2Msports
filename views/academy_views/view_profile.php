<script>
$(document).ready(function(){

$('input[name=conf_password]').blur(function() {
var pass = $('input[name=new_password]').val();
var repass = $('input[name=conf_password]').val();
if(($('input[name=new_password]').val().length == '') || ($('input[name=conf_password]').val().length == '')) {
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

$("#pic").click(function(){
$("#upload").show();
$("#pic").hide();
$("#password").hide();
$( ".err" ).hide();

});

$("#password").click(function(){
$("#change_pass").show();
$("#password").hide();
$("#pic").hide();
$( ".err" ).hide();

});

$("#cancel").click(function(){
$("#upload").hide();
$("#pic").show();
$("#password").show();
$( ".err" ).hide();
});


$("#cancel_pass").click(function(){
$("#change_pass").hide();
$("#pic").show();
$("#password").show();
$( ".err" ).hide();
});

$("#membership-details").click(function(){
$("#membership").show();
$("#edit_membership").hide();

});

$("#coach-details").click(function(){
$("#edit_coach").show();
$("#coach").hide();
$(".edit-coach-details").hide();
});


$("#add-coach-details").click(function(){
$("#coach").show();
$("#edit_coach").hide();
$(".edit-coach-details").hide();
});

$("#Cancel_mem").click(function(){
$("#membership").hide();
});

$("#Cancel_coach").click(function(){
$("#edit_coach").hide();
$(".edit-coach-details").show();
});


$("#Cancel_coach1").click(function(){
$("#coach").hide();
});




$(".edit-coach-details").click(function(){
	
	var baseurl = "<?php echo base_url();?>";

	$.ajax({
		  type:"post",
		  url:baseurl+'profile/edit_coach/',
		  success:function(html){

			   var res = html.split('#');
			   
			   $("#edit_coach").show();

			   $('#coach_profile').val(res[0]);  
			   $('#coach_web').val(res[2]);
			   $('#c_sport').val(res[1]);
				//$("#sport_xyz select").val(res[2]);
		  }

	 });


});


$(".edit_membership-details").click(function(){
	
	var tab_id = $(this).attr('name');
	
	$("#membership").hide();

	var baseurl = "<?php echo base_url();?>";
	if(tab_id != ""){
	 $.ajax({
		  type:"post",
		  url:baseurl+'profile/edit_club/',
		  data:{id:tab_id},
		  success:function(html){

			   var res = html.split('#');   
			   
			   $("#edit_membership").show();

			   $('#member_id').val(res[0]);  
			   $('#club_name').val(res[1]);
				$('#sport').val(res[2]);
				$('#org_id1').val(res[3]);
				$('#tab_id').val(res[4]);
		  }

	  });

	}

});

$("#Cancel_mem1").click(function(){
$("#edit_membership").hide();
});

$('#form-op-users').on('submit', function (e) {
if ($("input:checkbox[class=checkbox1]:checked").length === 0) {
e.preventDefault();
alert('Select atleast one club name to delete');
return false;
}
});

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


$('*[class^="sport_intr_level"]').click(function(){
	$get_name = $(this).attr('name');
	$gid = $get_name.split('_');

	$('#Sport_intrests_'+$gid[2]).attr('checked', true);   
}); 

$('.sport_intr').click(function(){
	$get_id = $(this).attr('id');
	$gid = $get_id.split('_');

	$(".sport_intr_level_"+$gid[2]).prop('checked', false);
});

});
</script>

<script>
function myFunction() {

	var baseurl = "<?php echo base_url();?>";
if(confirm("Are you sure to delete your coach profile?")){	
	$.ajax({
		  type:"post",
		  url:baseurl+'profile/delete_coach/',
		  success: function( res ) {
			
			if(res == 1)
		    {
				window.location = baseurl+"profile";			
			}
		  }
	 });
}

}
</script>

<script>
$(document).ready(function(){

var baseurl = "<?php echo base_url();?>";

$("#academy").autocomplete({

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
		$('#org_id').val(names[1]);
	}		      	
  });

});

</script>

<script>
$(document).ready(function(){

var baseurl = "<?php echo base_url();?>";

$("#club_name").autocomplete({

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
		$('#org_id1').val(names[1]);
	}		      	
  });

});

</script>



<section id="single_player" class="container secondary-page">
<div class="top-score-title right-score col-md-9">

<h3><?php echo $this->session->userdata('user');?></h3>
<?php 
if(isset($pic)) { ?>
<div class="name" align='left'>
<label for="name_login" style="color:green"><?php //echo $pic; ?></label>
</div>
<?php } ?>
<?php 
if(isset($pass)) { ?>
<div class="name" align='left'>
<label for="name_login" style="color:green"><?php echo $pass; ?></label>
</div>
<?php } ?>
<?php 
if(isset($pass_error)) { ?>
<div class="name" align='left'>
<label for="name_login" style="color:red"><?php echo $pass_error; ?></label>
</div>
<?php } ?>
<div class="col-md-12 atp-single-player">


<div class="col-md-4">

<?php 
    $filename =  "C:\inetpub\wwwroot\a2msports\profile_pictures\thumbs\'".$user_details['Profilepic'];
	$filename1 = "C:\inetpub\wwwroot\a2msports\profile_pictures\'".$user_details['Profilepic'];

if(file_exists($filename)){ ?>
<img  src="<?php echo base_url(); ?>profile_pictures/thumbs/<?php if($user_details['Profilepic']!=""){echo $user_details['Profilepic']; } else { echo "&nbsp;";}?>" alt="" />
<?php } else { ?>
<img  src="<?php echo base_url(); ?>profile_pictures/<?php if($user_details['Profilepic']!=""){echo $user_details['Profilepic']; } else { echo "default-profile.png";}?>" alt="" />
<?php }  ?>

</div>

<div class="col-md-5 profilelist">
<p><b>Location:</b>
<?php if($user_details['City'] or $user_details['State']){ echo $user_details['City'].", ".$user_details['State']; }
else{ echo $user_details['Country']; }
?></p>
<p><b>Member Since:</b> <?php echo date('M, Y',strtotime($user_details['RegistrationDtTm'])); ?></p>

<?php 
if(!empty($user_details['Club_Name'])){
	$i = 0;
	$club_details = $user_details['Club_Name'];
	$club_ids = $user_details['Club_Mem_Id'];

	$details = json_decode($club_details);
	$ids = json_decode($club_ids);

	$cnt = count(array_filter($details));	
	 ?>
		<p><b>Membership:</b><br />
		<?php 

		if($cnt > 0){
			for($i=0; $i<count(array_filter($details)); $i++)
			{
				echo "$details[$i] - $ids[$i]";
				echo "<br />";
			}
		}
		?></p>

<?php } ?>


</div>

<div class="col-md-4 profilelist">
<p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p class="txt-torn"><button class="league-form-submit1" id="password">Change Password</button></p>

<form  method="post"  action="<?php echo base_url(); ?>profile/change_password" role='form'>
<div id="change_pass" style="Display:none">
<label>Change Password</label>
<input class='form-control' id='' type='password' name="old_password" placeholder='Current Password' required> <br />
<input class='form-control' id='' type='password' name="new_password" placeholder='New Password' required> <br />
<input class='form-control' id='id="confirm_password"' type='password' name="conf_password" placeholder='Confirm New Password' required> <br />
<div class="err" style="display: none; color:red">Password mismatch</div>
<input type="submit" value="Update" style="margin-top:10px" class="league-form-submit1" />
<input type="button" value="Cancel" id="cancel_pass" style="margin-top:10px" class="league-form-submit1" />
</div>
</form>

<p class="txt-torn"><button class="league-form-submit1" id="pic">Change Profile Picture</button></p>

<form  method="post" enctype="multipart/form-data" action="<?php echo base_url(); ?>profile/upload_pic" role='form'>
<div id="upload" style="Display:none">
<input type="file" id="fileInput" name="Profilepic"  />
<input type="submit" value="Update" style="margin-top:10px" class="league-form-submit1" />
<input type="button" value="Cancel" id="cancel" style="margin-top:10px" class="league-form-submit1" />
</div>
</form>
</div>

</div>

<div class="col-md-12 atp-single-player skill-content">
<dl class="accordion" style="background:none">
<dt class="accordion__title">Profile</dt>
<dd class="accordion__content">
<form class='form-horizontal' method="post" action="<?php echo base_url(); ?>profile/update_user_data" role='form'>

<div class='form-group'>
<label class='control-label col-md-3' for='id_accomodation'>Name: </label>
<div class='col-md-3 form-group internal'>
<input class='form-control' id='fname' type='text' name="fname" placeholder='First Name' value="<?php if($user_details['Firstname']){ echo $user_details['Firstname']; }?>"> 
</div>
<div class='col-md-3 form-group internal'>
<input class='form-control' id='lname' type='text'  name="lname" placeholder='Last Name' value="<?php if($user_details['Lastname']){ echo $user_details['Lastname']; }?>">
</div>
</div>

<div class='form-group' style="margin-top:10px">
<label class='control-label col-md-3' for='id_accomodation'>Email: </label>
<div class='col-md-6 form-group internal'>
<input class='form-control' id='email' type='text' name="email" style="width:92%" readonly="readonly" value="<?php if($user_details['EmailID']){ echo $user_details['EmailID']; }?>">
</div>
</div>

<div class='form-group' style="margin-top:10px">
<label class='control-label col-md-3' for='id_accomodation'>Altername Email: </label>
<div class='col-md-6 form-group internal'>
<input class='form-control' id='name' type='text' name="alter_email" style="width:92%" value="<?php if($user_details['AlternateEmailID']){ echo $user_details['AlternateEmailID']; }?>">
</div>
</div>

<!--   <div class='form-group' style="margin-top:10px">
<label class='control-label col-md-3' for='id_accomodation'>Gender: </label>
<div class='col-md-6 form-group internal'>
<input name="" type="radio" value="" style="margin-bottom:22px"> Male  <input name="" type="radio" value=""> Female 
</div>
</div> -->
<?php $dob = $user_details['DOB'];
$day = explode("-", $dob);
//echo $day[0]; //yr
//echo $day[1]; //mon
//echo $day[2]; //day
$val = explode(" ", $dob);
// $val[0]; dob value
$new = substr($val[0],-2);
?>

<div class='form-group' style="margin-top:10px">
<label class='control-label col-md-3' for='id_accomodation'>Date of Birth: </label>
<div class='col-md-3 form-group internal' style="margin-right:5px">
<input class='form-control' id="txt_dob" type="date" name="txt_dob" 
value="<?php if($user_details['DOB']){ echo date('Y-m-d',strtotime($user_details['DOB'])); }?>" required />
</div>
</div>



<div class='form-group' style="margin-top:10px">
<label class='control-label col-md-3' for='id_accomodation'>Home Phone: </label>
<div class='col-md-6 form-group internal'>
<input class='form-control' id='name' name="hphone" maxlength="10"  type='text' style="width:92%" value="<?php if($user_details['HomePhone']){ echo $user_details['HomePhone']; }?>">
</div>
</div>

<div class='form-group' style="margin-top:10px">
<label class='control-label col-md-3' for='id_accomodation'>Mobile Phone: </label>
<div class='col-md-6 form-group internal'>
<input class='form-control' id='name' name="mphone" maxlength="10"  type='text' style="width:92%" value="<?php if($user_details['Mobilephone']){ echo $user_details['Mobilephone']; }?>">
</div>
</div>


<div class='form-group'>
<label class='control-label col-md-3' for='id_accomodation'>Address Line1 </label>
<div class='col-md-8 form-group internal'>
<input class='form-control' id='addr1' name='UserAddressline1' type='text' style="width:80%" value="<?php if($user_details['UserAddressline1']){ echo $user_details['UserAddressline1']; }?>" required>
</div>
</div>

<div class='form-group'>
<label class='control-label col-md-3' for='id_accomodation'>Address Line2 </label>
<div class='col-md-8 form-group internal'>
<input class='form-control' id='addr2' name='UserAddressline2' type='text' style="width:80%" value="<?php if($user_details['UserAddressline2']){ echo $user_details['UserAddressline2']; }?>">
</div>
</div>

<div class='form-group'>

<label class='control-label col-md-3' for='id_accomodation'>Country</label>
<div class='col-md-4 form-group internal'>
<select class='form-control' id='country' name='CountryName' required>
<option value="">Select</option>
<?php
$countries = array("Afghanistan", "Albania", "Algeria", "American Samoa", "Andorra", "Angola", "Anguilla", "Antarctica", "Antigua and Barbuda", "Argentina", "Armenia", "Aruba", "Australia", "Austria", "Azerbaijan", "Bahamas", "Bahrain", "Bangladesh", "Barbados", "Belarus", "Belgium", "Belize", "Benin", "Bermuda", "Bhutan", "Bolivia", "Bosnia and Herzegowina", "Botswana", "Bouvet Island", "Brazil", "British Indian Ocean Territory", "Brunei Darussalam", "Bulgaria", "Burkina Faso", "Burundi", "Cambodia", "Cameroon", "Canada", "Cape Verde", "Cayman Islands", "Central African Republic", "Chad", "Chile", "China", "Christmas Island", "Cocos (Keeling) Islands", "Colombia", "Comoros", "Congo", "Congo, the Democratic Republic of the", "Cook Islands", "Costa Rica", "Cote d'Ivoire", "Croatia (Hrvatska)", "Cuba", "Cyprus", "Czech Republic", "Denmark", "Djibouti", "Dominica", "Dominican Republic", "East Timor", "Ecuador", "Egypt", "El Salvador", "Equatorial Guinea", "Eritrea", "Estonia", "Ethiopia", "Falkland Islands (Malvinas)", "Faroe Islands", "Fiji", "Finland", "France", "France Metropolitan", "French Guiana", "French Polynesia", "French Southern Territories", "Gabon", "Gambia", "Georgia", "Germany", "Ghana", "Gibraltar", "Greece", "Greenland", "Grenada", "Guadeloupe", "Guam", "Guatemala", "Guinea", "Guinea-Bissau", "Guyana", "Haiti", "Heard and Mc Donald Islands", "Holy See (Vatican City State)", "Honduras", "Hong Kong", "Hungary", "Iceland", "India", "Indonesia", "Iran (Islamic Republic of)", "Iraq", "Ireland", "Israel", "Italy", "Jamaica", "Japan", "Jordan", "Kazakhstan", "Kenya", "Kiribati", "Korea, Democratic People's Republic of", "Korea, Republic of", "Kuwait", "Kyrgyzstan", "Lao, People's Democratic Republic", "Latvia", "Lebanon", "Lesotho", "Liberia", "Libyan Arab Jamahiriya", "Liechtenstein", "Lithuania", "Luxembourg", "Macau", "Macedonia, The Former Yugoslav Republic of", "Madagascar", "Malawi", "Malaysia", "Maldives", "Mali", "Malta", "Marshall Islands", "Martinique", "Mauritania", "Mauritius", "Mayotte", "Mexico", "Micronesia, Federated States of", "Moldova, Republic of", "Monaco", "Mongolia", "Montserrat", "Morocco", "Mozambique", "Myanmar", "Namibia", "Nauru", "Nepal", "Netherlands", "Netherlands Antilles", "New Caledonia", "New Zealand", "Nicaragua", "Niger", "Nigeria", "Niue", "Norfolk Island", "Northern Mariana Islands", "Norway", "Oman", "Pakistan", "Palau", "Panama", "Papua New Guinea", "Paraguay", "Peru", "Philippines", "Pitcairn", "Poland", "Portugal", "Puerto Rico", "Qatar", "Reunion", "Romania", "Russian Federation", "Rwanda", "Saint Kitts and Nevis", "Saint Lucia", "Saint Vincent and the Grenadines", "Samoa", "San Marino", "Sao Tome and Principe", "Saudi Arabia", "Senegal", "Seychelles", "Sierra Leone", "Singapore", "Slovakia (Slovak Republic)", "Slovenia", "Solomon Islands", "Somalia", "South Africa", "South Georgia and the South Sandwich Islands", "Spain", "Sri Lanka", "St. Helena", "St. Pierre and Miquelon", "Sudan", "Suriname", "Svalbard and Jan Mayen Islands", "Swaziland", "Sweden", "Switzerland", "Syrian Arab Republic", "Taiwan, Province of China", "Tajikistan", "Tanzania, United Republic of", "Thailand", "Togo", "Tokelau", "Tonga", "Trinidad and Tobago", "Tunisia", "Turkey", "Turkmenistan", "Turks and Caicos Islands", "Tuvalu", "Uganda", "Ukraine", "United Arab Emirates", "United Kingdom", "United States of America", "United States Minor Outlying Islands", "Uruguay", "Uzbekistan", "Vanuatu", "Venezuela", "Vietnam", "Virgin Islands (British)", "Virgin Islands (U.S.)", "Wallis and Futuna Islands", "Western Sahara", "Yemen", "Yugoslavia", "Zambia", "Zimbabwe");

foreach($countries as $country)
{
($country==$user_details['Country']) ? $sel = "selected='selected'" : $sel = "";
echo "<option value='$country' $sel>$country</option>";
}
?>
</select>

</div>
</div>

<div class='form-group' id='state_box' style='<?php if($user_details['Country']=="United States of America") { echo "display:none;"; } ?>'>
<label class='control-label col-md-3' for='id_accomodation'> State</label>
<div class='col-md-8 form-group internal'>
<input class='form-control' id='state1' name='StateName1' type='text' style="width:45%" value="<?php if($user_details['State']){ echo $user_details['State']; }?>">
</div>
</div>

<div class='form-group' id="state_drop" style='<?php if($user_details['Country']!="United States of America") { echo "display:none;"; } ?>'>
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
($state==$user_details['State']) ? $sel_state = "selected='selected'" : $sel_state = "";

echo "<option value='$state' $sel_state>$state</option>";
}
?>
</select>
</div>
</div>

<div class='form-group'>
<label class='control-label col-md-3' for='id_accomodation'> City</label>
<div class='col-md-8 form-group internal'>
<input class='form-control' id='city' name='CityName' type='text' style="width:45%" value="<?php if($user_details['City']){ echo $user_details['City']; }?>" />
</div>
</div>

<div class='form-group'>
<label class='control-label col-md-3' for='id_accomodation'>Postal Code</label>
<div class='col-md-8 form-group internal'>
<input class='form-control' id='zipcode' name='zipcode' type='text' style="width:45%" value="<?php if($user_details['Zipcode']){ echo $user_details['Zipcode']; }?>" />
</div>
</div>
<?php 
$pref_array = array();
if($user_details['NotifySettings']!="")
{
$pref_array = json_decode($user_details['NotifySettings']); 
}
?>

<div class='form-group' style="margin:10px">
<label class='control-label col-md-3' for='id_accomodation'>Notification <br>Preferences: </label>
<div class='col-md-9 form-group internal'>
<input type="checkbox" name="pref[]" id="recommend" value="1" <?php  if(in_array("1", $pref_array)){echo "checked = checked"; }?> />  NOTIFY ME WHEN A NEW TOURNAMENT is CREATED IN MY AREA <br />
<input type="checkbox" name="pref[]" id="recommend" value="2" <?php  if(in_array("2", $pref_array)){echo "checked = checked"; }?> />  SEND TOURNAMENT / MATCH UPDATES & NOTIFICATIONS
</div>
</div>

<div align="center"><input type="submit" value="Update" style="margin-top:10px" class="league-form-submit" /></div>
</form>

</dd>

<dt class="accordion__title">Sports</dt>
<dd class="accordion__content">     

<!-- 	<form class='form-horizontal' role='form' action="#"> -->

<form class='form-horizontal' method="post" action="<?php echo base_url(); ?>profile/update_user_sports" role='form'>

<div class="col-md-12" style="padding-top:10px">
<label for="Sportsintrests">* Interested in:</label><div class="clear"></div>

<?php
//print_r($user_sports_intrests);
//exit;
//print_r($user_sports_intrests); 
$user_sport = array();
$user_sport_level = array();


foreach($user_sports_intrests as $sp) {
$user_sport[] = $sp->Sport_id;
$user_sport_level[$sp->Sport_id] = $sp->Level;
}


$i=1;
static $j=1;
foreach($sports_details as $row) { ?> 
<div class='form-group' style="margin:20px">
<input type="checkbox" class="sport_intr" name="Sportsintrests[]" id="Sport_intrests_<?php echo $row->SportsType_ID;?>" 
value="<?php echo $row->SportsType_ID;?>"
<?php if(in_array("$row->SportsType_ID", $user_sport)){echo "checked = checked"; } ?> /> 
<?php echo $row->Sportname;?> &nbsp; 
</div>


<div class='form-group' style="margin:45px; margin-top:1px">
<?php
$get_sport_levels = profile::get_sport_levels($row->SportsType_ID);

foreach($get_sport_levels as $sl)
{
?>
<input type="radio" 
class="sport_intr_level_<?php echo $row->SportsType_ID;?>" 
name="sport_level_<?php echo $row->SportsType_ID;?>" 
id="sport_level_<?php echo ($i+$j); $j++; ?>" 
value="<?php echo $sl->SportsLevel_ID; ?>" <?php if($user_sport_level[$row->SportsType_ID]==$sl->SportsLevel_ID){echo "checked = checked"; } ?>/> 
<?php echo $sl->SportsLevel; ?> &nbsp;&nbsp;

<?php
}
?>
</div>
<?php 
$i++; 
} ?>

</div>
<div align="left"><input type="submit" value="Update" style="margin-top:10px" class="league-form-submit" /></div>
</form>

</dd>



<dt class="accordion__title">Matches</dt>
<dd class="accordion__content">


<div class="acc-content">
<div class="col-md-3 acc-title">Match</div>
<div class="col-md-2 acc-title">Opponent</div>
<div class="col-md-2 acc-title">Score</div>
<div class="col-md-2 acc-title">Date</div>
<div class="col-md-3 acc-title">Winner</div>


<?php 
if(count($user_matches) == 0 && count($user_tournment_matches) == 0)   
{
?>

<h5>No Played Matches are found.</h5>

<?php
}
else { 
foreach($user_matches as $row) { 
?>

<div class="col-md-3 t9"><p><a href='<?php echo base_url()."Play/reg_match/".$row->Play_id; ?>'><b><?php echo $row->Play_Title; ?></a></b></p> </div>
<div class="col-md-2 t10"><p><?php
$get_opp_name = profile::get_gen_mat_det($row->GeneralMatch_ID);

if($row->Opponent == ($this->session->userdata('users_id')))
{
$get_username = profile::get_user_det($get_opp_name['users_id']); 
echo $get_username['Firstname']." ".$get_username['Lastname'];
}
else
{
$get_username = profile::get_user_det($row->Opponent); 
echo $get_username['Firstname']." ".$get_username['Lastname'];
}

//echo $row->Opponent; ?></p></div>
<div class="col-md-2 t12"><p> 
<?php
if($row->Player1_Score !=""){

$p1 = json_decode($row->Player1_Score);
$p2 = json_decode($row->Opponent_Score);
if(count(array_filter($p1))>0)
{
for($i=0; $i<count(array_filter($p1)); $i++)
{
echo "($p1[$i] - $p2[$i]) ";
}
}

}
?>
</p></div>
<div class="col-md-2 t8"><p><?php echo date('M d, Y',strtotime($row->Play_Date)); ?></p></div>
<div class="col-md-3 t11"><p><?php 
$get_username = profile::get_user_det($row->Winner); 
echo $get_username['Firstname']." ".$get_username['Lastname'];
?></p></div>

<div class="acc-footer"></div>

<?php } 
?>

<!-- User tournament Matches -->
<?php 
foreach($user_tournment_matches as $row) { 
?>

<div class="col-md-3 t9"><p><a href='<?php echo base_url()."league/view/".$row->Tourn_ID; ?>'>
<b><?php 
$get_tourn = profile::get_tourn_name($row->Tourn_ID); 
echo $get_tourn['tournament_title'];
?>
</a></b></p> </div>

<div class="col-md-2 t10"><p><?php
//$get_opp_name = profile::get_gen_mat_det($row->Player2);

if($row->Player2 == ($this->session->userdata('users_id')) or $row->Player2_Partner == ($this->session->userdata('users_id')))
{
$get_username = profile::get_user_det($row->Player1); 
echo $get_username['Firstname']." ".$get_username['Lastname'];

	if($row->Player1_Partner != 0)
	{
	$get_partner = profile::get_user_det($row->Player1_Partner); 
	echo "; ".$get_partner['Firstname']." ".$get_partner['Lastname'];
	}
}
else
{
$get_username = profile::get_user_det($row->Player2); 
echo $get_username['Firstname']." ".$get_username['Lastname'];

	if($row->Player2_Partner != 0)
	{
	$get_partner = profile::get_user_det($row->Player2_Partner); 
	echo "; ".$get_partner['Firstname']." ".$get_partner['Lastname'];
	}
}

?></p></div>
<div class="col-md-2 t12"><p> 

<?php 
if($row->Player1_Score !=""){
$p1=array();$p2=array();
$p1 = json_decode($row->Player1_Score);
$p2 = json_decode($row->Player2_Score);

$cnt = count(array_filter($p1));
if($cnt > 0){
for($i=0; $i<count(array_filter($p1)); $i++)
{
echo "($p1[$i] - $p2[$i]) ";
}
}
else if($cnt == 0 and $row->Player1_Score != "Bye Match" and $row->Player2_Score != "Bye Match"){
echo "Win by Forfeit ";
}

}

if($row->Player1_Score == "Bye Match" or $row->Player2_Score == "Bye Match"){
echo "Bye Match";
}
?>
</p></div>

<div class="col-md-2 t8"><p><?php if($row->Match_Date != ""){echo date('M d, Y',strtotime($row->Match_Date));}else {"";} ?></p></div>
<div class="col-md-3 t11"><p><?php 
$get_username = profile::get_user_det($row->Winner); 
echo $get_username['Firstname']." ".$get_username['Lastname'];

if($row->Winner == $row->Player1 && $row->Player1_Partner != 0)
{
$get_partner = profile::get_user_det($row->Player1_Partner); 
echo "; ".$get_partner['Firstname']." ".$get_partner['Lastname'];
}
else if($row->Winner == $row->Player2 && $row->Player2_Partner != 0)
{
$get_partner = profile::get_user_det($row->Player2_Partner); 
echo "; ".$get_partner['Firstname']." ".$get_partner['Lastname'];
}

?></p></div>
<!-- <div class="col-md-1 t13"><p></p></div> -->
<div class="acc-footer"></div>

<?php }
}
?>
</div>
</dd>



<dt class="accordion__title">Tournaments</dt>
<dd class="accordion__content">
<!-- 	<h4>Content will be Updated soon</h4> -->

<div class="acc-content">
<div class="col-md-3 acc-title">Tournament</div>
<div class="col-md-2 acc-title">Opponent</div>
<div class="col-md-2 acc-title">Score</div>
<div class="col-md-2 acc-title">Date</div>
<div class="col-md-3 acc-title">Winner</div>
<!-- <div class="col-md-1 acc-title">Win%</div> -->

<?php 
if(count($user_tournment_matches) == 0)   
{
?>
<h5>No Tournaments Matches are found.</h5>

<?php
}
else {
?>
<!-- User tournament Matches -->
<?php 
foreach($user_tournment_matches as $row) { 
?>

<div class="col-md-3 t9"><p><a href='<?php echo base_url()."league/view/".$row->Tourn_ID; ?>'>
<b><?php 
$get_tourn = profile::get_tourn_name($row->Tourn_ID); 
echo $get_tourn['tournament_title'];
?>
</a></b></p> </div>

<div class="col-md-2 t10"><p><?php
//$get_opp_name = profile::get_gen_mat_det($row->Player2);

if($row->Player2 == ($this->session->userdata('users_id')) or $row->Player2_Partner == ($this->session->userdata('users_id')))
{
$get_username = profile::get_user_det($row->Player1); 
echo $get_username['Firstname']." ".$get_username['Lastname'];

	if($row->Player1_Partner != 0)
	{
	$get_partner = profile::get_user_det($row->Player1_Partner); 
	echo "; ".$get_partner['Firstname']." ".$get_partner['Lastname'];
	}
}
else
{
$get_username = profile::get_user_det($row->Player2); 
echo $get_username['Firstname']." ".$get_username['Lastname'];

	if($row->Player2_Partner != 0)
	{
	$get_partner = profile::get_user_det($row->Player2_Partner); 
	echo "; ".$get_partner['Firstname']." ".$get_partner['Lastname'];
	}
}

?></p></div>
<div class="col-md-2 t12"><p> 

<?php 
if($row->Player1_Score !=""){
$p1=array();$p2=array();
$p1 = json_decode($row->Player1_Score);
$p2 = json_decode($row->Player2_Score);

$cnt = count(array_filter($p1));
if($cnt > 0){
	for($i=0; $i<count(array_filter($p1)); $i++)
	{
	echo "($p1[$i] - $p2[$i]) ";
	}
}
else if($cnt == 0 and $row->Player1_Score != "Bye Match" and $row->Player2_Score != "Bye Match"){
	echo "Win by Forfeit ";
}

}

if($row->Player1_Score == "Bye Match" or $row->Player2_Score == "Bye Match"){
echo "Bye Match";
}
?>
</p></div>

<div class="col-md-2 t8"><p><?php if($row->Match_Date != ""){echo date('M d, Y',strtotime($row->Match_Date));}else {"";} ?></p></div>
<div class="col-md-3 t11"><p><?php 
$get_username = profile::get_user_det($row->Winner); 
echo $get_username['Firstname']." ".$get_username['Lastname'];

if($row->Winner == $row->Player1 && $row->Player1_Partner != 0)
{
	$get_partner = profile::get_user_det($row->Player1_Partner); 
	echo "; ".$get_partner['Firstname']." ".$get_partner['Lastname'];
}
else if($row->Winner == $row->Player2 && $row->Player2_Partner != 0)
{
	$get_partner = profile::get_user_det($row->Player2_Partner); 
	echo "; ".$get_partner['Firstname']." ".$get_partner['Lastname'];
}

?></p></div>
<!-- <div class="col-md-1 t13"><p></p></div> -->
<div class="acc-footer"></div>
<?php }
}
?>

</div>
</dd>


<dt class="accordion__title">Statistics</dt>
<dd class="accordion__content">

<div class="acc-content">
<div class="col-md-2 acc-title" style="font-size: 12px;">Sport</div>
<div class="col-md-2 acc-title" style="font-size: 12px;">A2MScore</div>
<div class="col-md-2 acc-title" style="font-size: 12px;"># of Matches</div>
<div class="col-md-2 acc-title" style="font-size: 12px;">Win - Loss</div>
<div class="col-md-2 acc-title" style="font-size: 12px;">AVG. Win %</div>
<br /><br /><br />
<?php 
if(count($num_matches) == 0)
{
?>
<h5>You Have not Added any Match Score yet.</h5>
<?php
}
else { 
foreach($num_matches as $row) { 
?>

<div class="col-md-2 t1"><p>
<?php $get_sport = profile::get_sport($row->SportsType_ID);
echo $get_sport['Sportname'];?></p></div>

<div class="col-md-2 t2"><p><?php echo $row->A2MScore; ?></p></div>

<div class="col-md-2 t3"><p> <?php if($row->Num_Matches != ""){echo $row->Num_Matches;}
else { echo "0" ;}?></p></div>

<div class="col-md-2 t4"><p><?php echo $row->Won . " - " . $row->Lost; ?></p></div>

<div class="col-md-2 t5"><p><?php echo number_format($row->Win_Per,2); ?></p></div>

<div class="acc-footer"></div>
<?php } } ?>

</div>

</dd>


<dt class="accordion__title">Memberships</dt>
<dd class="accordion__content">

<div class="acc-content">
<div class="col-md-1 acc-title" style="font-size: 12px;">&nbsp;&nbsp;&nbsp;</div>
<div class="col-md-4 acc-title" style="font-size: 12px;">Club Name</div>
<div class="col-md-3 acc-title" style="font-size: 12px;">MembershipID</div>
<div class="col-md-2 acc-title" style="font-size: 12px;">Sport</div>
<div class="col-md-2 acc-title" style="font-size: 12px;">Action</div>

<br /><br /><br />


<?php 
if(count($membership_details) == 0)
{
?>
<h5>You Have not Added any Membership Details yet.</h5>
<div>
<input type="button" class="league-form-submit1" value="Add new" id="membership-details" /> </div>
<?php
}
else {
?>
<form  method="post" id="form-op-users" action="<?php echo base_url();?>profile/delete_membership" role='form'>

<?php 
foreach($membership_details as $row){ 
?>


<div class="col-md-1 t1"><p>
 <input class="checkbox1" type="checkbox" name="sel_org_id[]" value="<?php echo $row->tab_id;?>" /></p>
 </div>


<div class="col-md-4 t9"><p>
<?php  $get_club = profile::get_club($row->Org_id);
echo $get_club['Org_name'];  ?></p></div>

<div class="col-md-3 t3"><p> 

<?php if($get_club['Org_name'] == "USTA")
{ 
	echo "<a href='https://tennislink.usta.com/tournaments/Rankings/RankingHome.aspx?RankingPlayerName=".$this->session->userdata('user')."' target='_blank'>$row->Membership_ID</a>";
}
else
{
	echo $row->Membership_ID;
}
?> </p>



</div>

<div class="col-md-2 t4"><p>
<?php $get_sport = profile::get_sport($row->Related_Sport);
echo $get_sport['Sportname'];?></p></div>

<div class="col-md-2 t4" style="cursor:pointer"><p>
<img src="<?php echo base_url();?>images/edit_club.png" align="middle" width="30" height="20"  class="edit_membership-details" name="<?php echo $row->tab_id;?>" /></p></div>

<div style="clear:both"></div>

<div class="acc-footer"></div>
<?php } ?>
<div><input type="button" class="league-form-submit1" value="Add new" id="membership-details" /> <input type="submit" name="delete_membership" value="Delete"  class="league-form-submit1" /></div>

</form>
<?php
 } ?>
</div>


<br />

<form  method="post"  action="<?php echo base_url();?>profile/add_membership" role='form'>
<div id="membership" style="Display:none">
		
		<div class="col-md-4">
		<label for="email">Club name</label>
		<input id='academy' name="club_name" class='ui-autocomplete-input form-control' type="text" placeholder="USTA / USATT" />
		<input class='form-control' id='org_id' name='org_id' type='hidden' placeholder="Org_id" value=""  />
		<!-- <div id="org_stat" style="color:red;"></div> -->
		</div>

		<div class="col-md-4">
		<label for="email">MemberShip ID</label><div class="clear"></div>
		<input id="" name="member_id" class="form-control" type="text" />
		</div>

		<div class="col-md-4">
		<label for="email">Related to Sport?</label><div class="clear"></div>
		<select name="club_sport" class="form-control">
		<option value="">select</option>
			<?php foreach($sports_details as $row) { ?> 
			<option value="<?php echo $row->SportsType_ID;?>"><?php echo $row->Sportname;?></option>
			<?php } ?>
		</select>
		</div>
		<div class="col-md-4">
		<input type="submit" value="Add" style="margin-top:10px" class="league-form-submit1" />
		<input type="button" value="Cancel" id="Cancel_mem" style="margin-top:10px" class="league-form-submit1" />
		</div>
</div>
</form>


<div id="edit_membership" style="Display:none">
<form  method="post"  action="<?php echo base_url();?>profile/update_membership" role='form'>
		
		<div class="col-md-4">
		<label for="email">Club name</label>
		<input id='club_name' name="club_name" class='ui-autocomplete-input form-control' type="text" placeholder="" value="<?php echo $org_name; ?>" />
		<input class='form-control' id='org_id1' name='org_id' type='hidden' placeholder="Org_id" value="<?php echo $org_id; ?>"  />
		<!-- <div id="org_stat" style="color:red;"></div> -->
		</div>

		<div class="col-md-4">
		<label for="email">MemberShip ID</label><div class="clear"></div>
		<input id="member_id" name="member_id" class="form-control" type="text" value="<?php echo $mem_id; ?>" />
		</div>

		<div class="col-md-4">
		<label for="email">Related to Sport?</label><div class="clear"></div>
		
		<?php 
		 echo "<select class='form-control' name='club_sport' id='sport'>";
		 foreach($sports_details as $row)
		 { 
			?>
		 <option value='<?php echo $row->SportsType_ID ;?>'<?php echo trim($row->SportsType_ID) == $sport ? 'selected="selected"' : ''; ?>><?php echo $row->Sportname ; ?></option>
		<?php 
		 }
		 echo "</select>";
		?>

		</div>

		<input id='tab_id' name="tab_id" class='' type="hidden"  value="<?php echo $tab_id; ?>" />


		<div class="col-md-4">
		<input type="submit" value="Update" style="margin-top:10px" class="league-form-submit1" />
		<input type="button" value="Cancel" id="Cancel_mem1" style="margin-top:10px" class="league-form-submit1" />
		</div>

</form>
</div>

</dd>



<dt class="accordion__title">Coach Profile</dt>
<dd class="accordion__content">
<div class="acc-content">

<?php if($user_details['Is_coach'] == 1){ ?>

<div style="text-transform:none"><p><b>SPORT:</b>

<?php $get_sport = profile::get_sport($user_details['coach_sport']);
echo $get_sport['Sportname'];?></p></div><br />

<div style="text-transform:none"><p> <b>COACH PROFILE :</b><?php echo $user_details['coach_profile']; ?></p></div><br />

<div style="text-transform:none">
<p><b>COACH WEBSITE: </b> 
<?php
if($user_details['Coach_Website'] != ""){
 $check = "http";
$pos = strpos($user_details['Coach_Website'],$check);
if($pos){ ?>
 
 <a target="_blank" href="<?php echo $user_details['Coach_Website'];?>"><?php echo $user_details['Coach_Website'];?></a> 
 
<?php } else { ?>
 <a target="_blank" href="<?php echo "http://".$user_details['Coach_Website'];?>"><?php echo $user_details['Coach_Website'];?></a>  

<?php } 
} ?>

</p>
</div><br />
<?php } else { ?>
<p style="text-transform:none">Are you a professional coach? please  <a href="#coach" id="add-coach-details" >CLICK HERE</a> to add info.</p>
<div>
</div>
<?php } ?>

<div style="clear:both"></div>

<div class="acc-footer"></div>

<?php
if($user_details['Is_coach'] == 1) { ?>
<div style=""><input type="button" class="league-form-submit1 edit-coach-details" value="Edit" id="coach-details" /> 
<input type="button" name="delete_coach" id="delete_coach" value="Delete" onclick="myFunction()" class="league-form-submit1 edit-coach-details" /></div>
<?php }  ?>
</div>


<div id="coach" style="Display:none">
<form  method="post"  action="<?php echo base_url();?>profile/insert_coach" role='form'>

		
		<div class="col-md-4">
		<label for="email">Related to Sport?</label><div class="clear"></div>
		<select name="sport_coach" class="form-control">
		<option value="">select</option>
			<?php foreach($sports_details as $row) { ?> 
			<option value="<?php echo $row->SportsType_ID;?>"><?php echo $row->Sportname;?></option>
			<?php } ?>
		</select>
		</div>

		<div class="col-md-4">
		<label for="email">Coach Website</label><div class="clear"></div>
		<input name="coach_web" class="form-control" type="text" value="" />
		</div>
		

		<div class="col-md-12">
		<label for="email">Coach Profile</label><div class="clear"></div>
		<textarea cols="30" rows="10" name="coach_profile" class="form-control"></textarea>
		</div>
		
		<div class="col-md-4">
		<input type="submit" value="Submit" style="margin-top:10px" class="league-form-submit1" />
		<input type="button" value="Cancel" id="Cancel_coach1" style="margin-top:10px" class="league-form-submit1" />
		</div>

</form>
</div>

<div id="edit_coach" style="display:none">
<form  method="post"  action="<?php echo base_url();?>profile/update_coach" role="form">

		<div class="col-md-4">
		<label for="email">Related to Sport?</label>
		<select  class="form-control" name="sport_coach" id="c_sport">
		<option value="select">select</option>
		<?php 
		 echo "";
		 foreach($sports_details as $row)
		 { 
			?>
		 <option value='<?php echo $row->SportsType_ID ;?>' <?php if($row->SportsType_ID == $c_sport) { echo "selected='selected'"; } ?>><?php echo $row->Sportname ; ?></option>
		 
		<?php 
		 }
		
		?>
		</select>
		</div>


		<div class="col-md-4">
		<label for="email">Coach Website</label><div class="clear"></div>
		<input id="coach_web" name="coach_web" class="form-control" type="text" value="<?php echo $website; ?>" />
		</div>
		
		<div class="col-md-12">
		<label for="email">Coach Profile</label><div class="clear"></div>
		<textarea cols="30" rows="10" id="coach_profile" name="coach_profile" class="form-control"><?php echo $profile; ?></textarea>
		</div>

		<div class="col-md-4">
		<input type="submit" value="Update" style="margin-top:10px" class="league-form-submit1" />
		<input type="button" value="Cancel" id="Cancel_coach" style="margin-top:10px" class="league-form-submit1" />
		</div>

</form>
</div>


</dd>





</dl>

</div>

</div><!--Close Top Match-->