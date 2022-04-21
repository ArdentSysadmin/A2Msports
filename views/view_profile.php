<?php
echo $test;
echo "<br />";
//exit;
?>
<script src="<?=base_url();?>assets/tinymce/tinymce.min.js"></script>
<script>
var baseurl = "<?php echo base_url();?>";

tinymce.init({
  selector: 'textarea',
  height: 300,
  theme: 'modern',
  plugins: [
    'advlist autolink lists link image charmap print preview hr anchor pagebreak',
    'searchreplace wordcount visualblocks visualchars code fullscreen',
    'insertdatetime media nonbreaking save table contextmenu directionality',
    'template paste textcolor colorpicker textpattern imagetools codesample toc help'
  ],
  toolbar1: 'undo redo | insert | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image',
  toolbar2: 'print preview media | forecolor backcolor emoticons | codesample help',
  image_advtab: true,
  templates: [
    { title: 'Test template 1', content: 'Test 1' },
    { title: 'Test template 2', content: 'Test 2' }
  ],
  content_css: [
    '//fonts.googleapis.com/css?family=Lato:300,300i,400,400i',
    '//www.tinymce.com/css/codepen.min.css'
  ]
 });
</script>
<script>
 //var clubs = jQuery.parseJSON("<?php echo $json_clubs; ?>");

$(document).ready(function() {

	$('#academy').autocomplete({
		source: clubs,
		/*focus: function(event, ui) {
			// prevent autocomplete from updating the textbox
			event.preventDefault();
			// manually update the textbox
			$(this).val(ui.item.label);
		},*/
	  	autoFocus: true,
		minLength: 1,
		select: function( event, ui ) {		
			// prevent autocomplete from updating the textbox
			
			$(this).val(ui.item.label);
			$('#org_id').val(ui.item.value);
			event.preventDefault();
		}
	});

	$('#club_name').autocomplete({
		source: clubs,
		/*focus: function(event, ui) {
			// prevent autocomplete from updating the textbox
			event.preventDefault();
			// manually update the textbox
			$(this).val(ui.item.label);
		},*/
	  	autoFocus: true,
		minLength: 1,
		select: function( event, ui ) {		
			// prevent autocomplete from updating the textbox
			event.preventDefault();
			$(this).val(ui.item.label);
			$('#org_id1').val(ui.item.value);
		}
	});

	$('#coach_club').autocomplete({
		source: clubs,
		/*focus: function(event, ui) {
			// prevent autocomplete from updating the textbox
			event.preventDefault();
			// manually update the textbox
			$(this).val(ui.item.label);
		},*/
	  	autoFocus: true,
		minLength: 1,
		select: function( event, ui ) {		
			// prevent autocomplete from updating the textbox
			event.preventDefault();
			$(this).val(ui.item.label);
			$('#org_id2').val(ui.item.value);
		}
	});

	$('#edit_coach_club').autocomplete({
		source: clubs,
		/*focus: function(event, ui) {
			// prevent autocomplete from updating the textbox
			event.preventDefault();
			// manually update the textbox
			$(this).val(ui.item.label);
		},*/
	  	autoFocus: true,
		minLength: 1,
		select: function( event, ui ) {		
			// prevent autocomplete from updating the textbox
			event.preventDefault();
			$(this).val(ui.item.label);
			$('#org_id3').val(ui.item.value);
		}
	});


$('#email').blur(function(){
var baseurl	= "<?php echo base_url();?>";
var email_id = $(this).val();

if(email_id!=""){
	$.ajax({
	type:'POST',
	url:baseurl+'register/ajax_email_verify/',
	data:'email_id='+email_id,
	success:function(html){
		var stat = html;
		if(stat != ""){
			var sp = stat.split('-');
			$('#email_stat').html(sp[1] + " already exists! <br />Please choose another.");
			$("#email_stat").css("text-transform", "lowercase");
			$('#email').val("");
		}
		else {
			$('#email_stat').html("");
		}
	}
	}); 
}
});

$('#email2').blur(function(){
var baseurl	= "<?php echo base_url();?>";
var email_id = $(this).val();

if(email_id!=""){
	$.ajax({
	type:'POST',
	url:baseurl+'register/ajax_email_verify/',
	data:'email_id='+email_id,
	success:function(html){
		var stat = html;
		if(stat != ""){
			var sp = stat.split('-');
			$('#email_stat2').html(sp[1] + " already exists! <br />Please choose another.");
			$("#email_stat2").css("text-transform", "lowercase");
			$('#email2').val("");
		}
		else {
			$('#email_stat2').html("");
		}
	}
	}); 
}
});


});

$(document).ready(function(){
/*$('input[name=conf_password]').blur(function() {
	var pass   = $('input[name=new_password]').val();
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
});*/
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

			   //$('#edit_coach_profile').append(res[0]);  
			   $('#coach_web').val(res[2]);
			   //$('#c_sport').val(res[1]);
				//$("#sport_xyz select").val(res[2]);
		  }

	 });

});

$("#upd_membership").click(function(){
	$('#membership_upd_err').html("");

	var baseurl		= "<?php echo base_url();?>";
	var club_name	= $('#club_name').val();
	var member_id	= $('#member_id').val();
	var org_id		= $('#org_id1').val();
	var club_sport	= $('#sport').val();
	var tab_id		= $('#tab_id').val();

	$.ajax({
		  type:"post",
		  url:baseurl+'profile/update_membership/',
		  data:{ member_id:member_id,org_id:org_id,club_sport:club_sport,tab_id:tab_id,club_name:club_name},
		  success:function(res){
			   /*var res = html.split('#');
			   
			   $("#edit_coach").show();

			   $('#coach_profile').val(res[0]);  
			   $('#coach_web').val(res[2]);
			   $('#c_sport').val(res[1]);*/
				//$("#sport_xyz select").val(res[2]);
				$('#membership_upd_err').html(res);
		  }
	 });
});

$(".edit_membership-details").click(function(){

	var tab_id = $(this).attr('name');
	$("#membership").hide();

	var baseurl = "<?php echo base_url();?>";
	if(tab_id != "") {
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

function showPassword() {
  var x = document.getElementById("npass");
  if (x.type === "password") {
    x.type = "text";
  } else {
    x.type = "password";
  }
}

</script>

<style>
.scrollit {
    overflow-x:scroll;
   /* height:100px;*/
}
</style>

<script>
function myFunction() {


if(confirm("Are you sure to delete your coach profile?")){	
	$.ajax({
		  type:"post",
		  url:baseurl+'profile/delete_coach/',
		  success: function( res ) {

			if(res == 1) {
				window.location = baseurl+"profile";			
			}
		  }
	 });
}

}

$(document).ready(function(){
	$('.club_sub').click(function(){
		var id = $(this).attr('id');
		if(id){
			$(location).attr('href', baseurl+'clubs/subscribe/'+id);
		}
	});


});
</script>

<script>
$(document).ready(function(){

var baseurl = "<?php echo base_url();?>";

/*$("#academy").autocomplete({

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
  });*/

$('#created_by').autocomplete({
	source: function( request, response ) {
  		$.ajax({
			url: baseurl+'search/autocomplete',
  			dataType: "json",
			method: 'post',
			data: {
			   name_startsWith: request.term,
			   type: 'users',
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
					//alert(item);
				}));
			}
  		});
  	},
  	autoFocus: true,
  	minLength: 1,
  	select: function( event, ui ) {
		var names = ui.item.data.split("|");
		var opp   = names[1];
		$.ajax({
			type:'POST',
			url:baseurl+'profile/get_user_opponent_stats/',
			data:{opp:opp},
			success:function(html){
			$('#standings').html(html);
			//$('#standings').DataTable().ajax.reload();


			}
		});

		//$('#created_by').val('');
		//$('#created_by').focus();
	}
});

$('#reset_stats').click(function(){
		var opp = -1;

		$.ajax({
			type:'POST',
			url:baseurl+'profile/get_user_opponent_stats/',
			data:{opp:opp},
			success:function(html){
			$('#standings').html(html);
			//$('#standings').DataTable().ajax.reload();
			}
		});
});

});
</script>

<script>
$(document).ready(function(){

var baseurl = "<?php echo base_url();?>";

/*$("#club_name").autocomplete({

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
  });*/

});
</script>

<section id="single_player" class="container secondary-page">
<div class="top-score-title right-score col-md-9">

<h3><?php echo $user_details['Firstname']." ".$user_details['Lastname'];?></h3>
<?php 
if(isset($pic)) { ?>
<div class="name" align='left'>
<label for="name_login" style="color:green"><?php //echo $pic; ?></label>
</div>
<?php }
if(isset($pass)) { ?>
<div class="name" align='left'>
<label for="name_login" style="color:green"><?php echo $pass; ?></label>
</div>
<?php }
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
<img  src="<?php echo base_url(); ?>profile_pictures/thumbs/<?php if($user_details['Profilepic']!=""){echo $user_details['Profilepic']; } else { echo "&nbsp;";}?>" id="prof_pic_id"  alt="" />
<?php } else { ?>
<img  src="<?php echo base_url(); ?>profile_pictures/<?php if($user_details['Profilepic']!=""){echo $user_details['Profilepic']; } else { echo "default-profile.png";}?>" id="prof_pic_id" alt="" />
<?php }  ?>

</div>

<div class="col-md-5 profilelist">
<p><b>Location:</b>
<?php if($user_details['City'] or $user_details['State']){ echo $user_details['City'].", ".$user_details['State']; }
else{ echo $user_details['Country']; }
?></p>
<p><b>Member Since:</b> <?php echo date('M, Y',strtotime($user_details['RegistrationDtTm'])); ?></p>
<p><b>About Me:</b>
<?php
if($user_details['bio']){ echo $user_details['bio']; }
?></p>
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
<p class="txt-torn"><button class="league-form-submit1" id="password">Set / Change Password</button></p>

<form  method="post"  action="<?php echo base_url(); ?>profile/change_password" role='form' autocomplete="off">
<div id="change_pass" style="display:none">
<label>Set / Change Password</label>
<!-- <input class='form-control' id='opass' type='password' name="old_password" placeholder='Current Password' required> <br /> -->
<?php
if($user_details['EmailID'] == NULL or $user_details['EmailID'] == '' or $user_details['EmailID'] == 'NULL' or $user_details['EmailID'] == 'null'){
?>
<input class='form-control' id='email2' type='text' name="email2" style="width:92%" value="" required autocomplete="off" />
<span id='email_stat2' style='text-transform: lowercase !important; color:red;'></span>
<?php
}
?>
<input class='form-control' id='npass' type='password' name="new_password" placeholder='New Password' required autocomplete="off"> 
<input type='checkbox' name='show_pwd' id='show_pwd' value='1' onclick="showPassword();" /> Show Password?
<!-- <input class='form-control' id='id="confirm_password"' type='password' name="conf_password" placeholder='Retype Password' required> --> 
<br /><br />
<!-- <div class="err" style="display: none; color:red">Passwords are mismatch</div> -->
<input type="submit" value="Update" style="margin-top:10px" class="league-form-submit1" />
<input type="button" value="Cancel" id="cancel_pass" style="margin-top:10px" class="league-form-submit1" />
</div>
</form>

<p class="txt-torn"><button class="league-form-submit1" id="pic">Change Profile Picture</button></p>

<form  method="post" enctype="multipart/form-data" action="<?php echo base_url(); ?>profile/upload_pic" role='form'>
<div id="upload" style="Display:none">
<input type="file" id="fileInput" name="Profilepic"  />
<input type="hidden" id="fileInput_ajax" name="Profilepic_ajax"  />
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
<input class='form-control' id='fname' type='text' name="fname" placeholder='First Name' value="<?php if($user_details['Firstname']){ echo $user_details['Firstname']; }?>" required /> 
</div>
<div class='col-md-3 form-group internal'>
<input class='form-control' id='lname' type='text'  name="lname" placeholder='Last Name' value="<?php if($user_details['Lastname']){ echo $user_details['Lastname']; }?>" required />
</div>
</div>

<div class='form-group' style="margin-top:10px">
<label class='control-label col-md-3' for='id_accomodation'>Email: </label>
<div class='col-md-6 form-group internal'>
<input class='form-control' id='email' type='text' name="email" style="width:92%" <?php if($user_details['EmailID'] != 'NULL' and $user_details['EmailID']){ echo "readonly='readonly'"; } ?> value="
<?php if($user_details['EmailID'] != 'NULL' and $user_details['EmailID']){ echo $user_details['EmailID']; }?>">
<span id='email_stat' style='text-transform: lowercase !important; color:red;'></span>
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
<?php
//var_dump($user_details['DOB']);exit;
if($user_details['DOB'] and $user_details['DOB'] != NULL){
?>
<input class='form-control' id="txt_dob" type="date" name="txt_dob" 
value="<?php if($user_details['DOB']){ echo date('Y-m-d',strtotime( $user_details['DOB'])); } else { echo "mm/dd/yy"; } ?>" readonly />
<?php
}
else{
?>
<input class='form-control' id="txt_dob" type="date" name="txt_dob" value="mm/dd/yy" />
<?php
}
?>
</div>
</div>
<?php if($user_details['Gender'] === "" OR $user_details['Gender'] === NULL){ ?>
<div class='form-group' style="margin-top:10px">
<label class='control-label col-md-3' for='id_accomodation'>Gender: </label>
<div class='col-md-3 form-group internal' style="margin-right:5px">
<select id='txt_gender' name='txt_gender' class='form-control' required>
<option value=''>Select</option>
<option value='1'>Male</option>
<option value='0'>Female</option>
</select>

</div>
</div>
<?php
}
else{
?>
<div class='form-group' style="margin-top:10px">
<label class='control-label col-md-3' for='id_accomodation'>Gender: </label>
<div class='col-md-3 form-group internal' style="margin-right:5px">
<?php
//echo ($user_details['Gender'] == 1) ? "Male" : "Female";
?>
<!-- <input class='form-control' id="db_txt_gender" type="hidden" name="txt_gender" value="<?=$user_details['Gender'];?>" /> -->
<select id='txt_gender' name='txt_gender' class='form-control' required>
<option value=''>Select</option>
<option value='1' <?php if($user_details['Gender'] == 1) echo "selected"; ?>>Male</option>
<option value='0' <?php if($user_details['Gender'] == 0) echo "selected"; ?>>Female</option>
</select>
</div>
</div>
<?php
}
$arr = array('U10','U11','U12','U13','U14','U15','U16','U17','U18');
if(in_array($user_details['UserAgegroup'], $arr)){
?>
<div class='form-group' style="margin-top:10px">
<label class='control-label col-md-3' for='id_accomodation'>School Name:&nbsp;<img src='<?=base_url();?>icons/question-mark.png' width='20px' height='20px' title='We use this to add your school name in our certificates' /></label>
<div class='col-md-8 form-group internal' style="margin-right:5px">
<input class='form-control' id="txt_school" type="text" name="txt_school" style="width:80%"
value="<?php if($user_details['School_Info']){ echo $user_details['School_Info']; }?>" />
</div>
</div>
<?php
}
?>

<div class='form-group' style="margin-top:10px">
<label class='control-label col-md-3' for='id_accomodation'>Home Phone: </label>
<div class='col-md-6 form-group internal'>
<input class='form-control' id='hphone' name="hphone" maxlength="15"  type='text' style="width:92%" value="<?php if($user_details['HomePhone']){ echo $user_details['HomePhone']; }?>">
</div>
</div>

<div class='form-group' style="margin-top:10px">
<label class='control-label col-md-3' for='id_accomodation'>Mobile Phone: </label>
<div class='col-md-6 form-group internal'>
<input class='form-control' id='mphone' name="mphone" maxlength="15"  type='text' style="width:92%" value="<?php if($user_details['Mobilephone']){ echo $user_details['Mobilephone']; }?>">
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
<input type="checkbox" name="pref[]" id="recommend_1" value="1" <?php  if(in_array("1", $pref_array)){echo "checked = checked"; }?> />  NOTIFY ME WHEN A NEW TOURNAMENT is CREATED IN MY AREA <br />
<input type="checkbox" name="pref[]" id="recommend_2" value="2" <?php  if(in_array("2", $pref_array)){echo "checked = checked"; }?> />  SEND TOURNAMENT / MATCH UPDATES & NOTIFICATIONS
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
if(count($user_matches) == 0 && count($user_tournment_matches) == 0 && count($user_tournment_team_matches) == 0)   
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

<?php 
} ?>

<!-- Tournament Line Matches -->
<?php 
foreach($user_tournment_team_matches as $row) { 
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
<?php
}?>
<!-- End section of Tournament Line Matches -->

<?php
}?>
</div>
</dd>



<!-- <dt class="accordion__title">Tournaments</dt>
<dd class="accordion__content">


<div class="acc-content">
<div class="col-md-3 acc-title">Tournament</div>
<div class="col-md-2 acc-title">Opponent</div>
<div class="col-md-2 acc-title">Score</div>
<div class="col-md-2 acc-title">Date</div>
<div class="col-md-3 acc-title">Winner</div>


<?php 
if(count($user_tournment_matches) == 0)   
{
?>
<h5>No Tournaments Matches are found.</h5>

<?php
}
else {
?>
<?php //User tournament Matches
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
<div class="acc-footer"></div>
<?php }
}
?>


<?php 
if(count($user_tournment_team_matches) == 0)   
{
?>
<h5>No Tournaments Matches are found.</h5>

<?php
}
else {
?>
<?php //Tournament Line Matches
foreach($user_tournment_team_matches as $row) { 
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

<div class="acc-footer"></div>
<?php }
}
?>

</div>
</dd> -->


<dt class="accordion__title">Statistics</dt>
<dd class="accordion__content">

<!-- New Statistics area -->
<div class="table-responsive scrollit">
<p>
<input class = 'ui-autocomplete-input form-control inwidth' id = 'created_by' name = 'created_by' type = 'text' placeholder = "Search by Opponent" style='width:40%; display:inline-block;' value = "" /> 
<input type='button' class='league-form-submit1' name='reset_stats' id='reset_stats' value='Reset' />
</p>

<table id="standings" cellpadding="8" cellspacing="8" border="0" class="tab-score" scrolltab>
<thead>
<tr class='top-scrore-table' style="background-color: #f68b1c; color:#fff; font-size:14px; padding:3px">
<th class="text-center">Sport</th>
<th class="text-center">A2M (S)</th>
<th class="text-center">A2M (D)</th>
<th class="text-center">A2M (M)</th>
<th class="text-center">Matches<br>Played</th>
<th class="text-center">Win - Loss</th>
<th class="text-center">Matches<br>Win%</th>
<th class="text-center">Scores</th>
<th class="text-center">Score<br>Differential</th>
<th class="text-center">Win%</th>
<th class="text-center">SD/MP</th>
<th class="text-center">SD/MP<br>+Win%</th>
</tr>
</thead>
<?php
if(count($user_stats) > 0) {
	foreach($user_stats as $sport => $stats) {
	$get_sport	= profile :: get_sport($sport);
	$get_a2m		= profile :: get_a2msocre($sport);
	$get_winper = profile :: get_winper($sport);
?>
<tr>
<td>&nbsp;<b><?=$get_sport['Sportname'];?></b></td>
<td align='center'><?php echo $get_a2m['A2MScore']; ?></td>
<td align='center'><?php echo $get_a2m['A2MScore_Doubles']; ?></td>
<td align='center'><?php echo $get_a2m['A2MScore_Mixed']; ?></td>
<td align='center'><?php echo $stats['played']; ?></td>
<td align='center'><?php echo $stats['won']." - ".$stats['lost']; ?></td>
<td align='center'><?php $win_per = ($stats['won'] / $stats['played']) * 100; echo number_format($win_per, 2); ?></td>
<td align='center'><?php echo $stats['points_for']." - ".$stats['points_against']; ?></td>
<td align='center'><?php $diff = ($stats['points_for'] - $stats['points_against']); echo $diff; ?></td>
<td align='center'><?php echo $get_winper['Win_Per']; ?></td>
<td align='center'><?php $pd = $diff / $stats['played']; echo number_format($pd, 2); ?></td>
<td align='center' style="font-weight:400;"><?php $pd_win_per = $pd + $win_per;	  echo number_format($pd_win_per, 2); ?></td>
</tr>
<?php
	}
}
else{
?>
<tr>
<td align='right'>No</td>
<td>Standings</td>
<td>Available</td>
<td>yet!</td>
<td>&nbsp;</td>
<td>&nbsp;</td>
<td>&nbsp;</td>
<td>&nbsp;</td>
<td>&nbsp;</td>
<td>&nbsp;</td>
</tr>
<?php
}?>
</table>
</div>
<!-- New Statistics area -->


<!-- Basketball Statistics Area -->
<?php 
$get_bb_matches = profile :: basketball_matches($user_details['Users_ID']);
if($get_bb_matches){
?>
<div class="table-responsive scrollit" style="margin-top: 35px;">

<table id="standings" cellpadding="8" cellspacing="8" border="0" class="tab-score" scrolltab>
<thead>  	            	         				                   
<tr class='top-scrore-table' style="background-color: #f68b1c; color:#fff; font-size:14px; padding:3px">
	<th class="text-center">Sport</th>
	<th class="text-center">GP</th>
	<th class="text-center">Pos</th>
	<th class="text-center">FG</th>
	<th class="text-center">3P</th>
	<th class="text-center">2P</th>
	<th class="text-center">FT</th>
	<th class="text-center">ORB</th>
	<th class="text-center">DRB</th>
	<th class="text-center">AST</th>
	<th class="text-center">ST</th>
	<th class="text-center">BLK</th>
	<th class="text-center">PTS</th>
</tr>
</thead>
<?php
if(0) {
	
}
else{
?>
<tr>
<td>&nbsp;<b>Basketball</b></td>
<td align="center">-</td>
<td align="center">-</td>
<td align="center">-</td>
<td align="center">-</td>
<td align="center">-</td>
<td align="center">-</td>
<td align="center">-</td>
<td align="center">-</td>
<td align="center">-</td>
<td align="center">-</td>
<td align="center">-</td>
<td align="center">-</td>
</tr>
<?php
}
?>
</table>
</div>
<?php
}
?>
<p style="font-size:10px; color:#605e5e;margin-top: 5px;">
GP: Games Played, Pos: Position, FG: Field Goals, 3P: 3point, 2P: 2Point, FT: Free Throw, ORB: Offensive Rebound, DRB: Defensive Rebound, AST: Assist, ST: Steals, BLK: Blocks, PTS: Points
</p>
<!-- Basketball Statistics Area -->

</dd>


<dt class="accordion__title">Memberships</dt>
<dd class="accordion__content">

<div class="acc-content">
<div class="col-md-1 acc-title" style="font-size: 12px;">&nbsp;&nbsp;&nbsp;</div>
<div class="col-md-3 acc-title" style="font-size: 12px;">Club Name</div>
<div class="col-md-2 acc-title" style="font-size: 12px;">MembershipID</div>
<div class="col-md-2 acc-title" style="font-size: 12px;">Sport</div>
<div class="col-md-2 acc-title" style="font-size: 12px;">Status</div>
<div class="col-md-2 acc-title" style="font-size: 12px;">Action</div>

<br /><br /><br />


<?php 
if(count($membership_details) == 0) {
?>
<h5>You have not added any Membership Details yet.</h5>
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


<div class="col-md-3 t9"><p>
<?php  $get_club = profile::get_club($row->Club_id);
echo $get_club['Aca_name'];  ?></p></div>

<div class="col-md-2 t3"><p> 
<?php
if($get_club['Aca_name'] == "USTA") { 
	echo "<a href='https://tennislink.usta.com/tournaments/Rankings/RankingHome.aspx?RankingPlayerName=".$this->session->userdata('user')."' target='_blank'>$row->Membership_ID</a>";
}
else {
	echo $row->Membership_ID;
}
?>
</p>

</div>

<div class="col-md-2 t4"><p>
<?php $get_sport = profile::get_sport($row->Related_Sport);
echo $get_sport['Sportname'];?></p></div>

<div class="col-md-2 t4"><p>
<?php echo ($row->Related_Sport == 1) ? "Active":"Inactive";?></p></div>

<div class="col-md-2 t4" style="cursor:pointer">
<p>
<img src="<?php echo base_url();?>images/edit_club.png" align="middle" width="30" height="20"  class="edit_membership-details" name="<?php echo $row->tab_id;?>" />
</p>
<?php
if($row->Membership_Code != '' and $row->Related_Sport == 0){
	//echo "<a href='#'>Pay Now!</a>";
?>
	<input type='button' name='btn_pay' class='club_sub' id='<?=$row->Membership_Code;?>' value=' Pay Now ' class="league-form-submit btn_pay" style='font-size:12px; margin-bottom:0px; padding:8px 8px;'/>
<?php
}
?>

</div>

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
	<input id='academy' name="club_name" class='ui-autocomplete-input form-control' type="text" 
	placeholder="USTA / USATT" autocomplete = "off" />
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
<!-- <form  method="post"  action="<?php echo base_url();?>profile/update_membership" role='form'> -->		
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
		 foreach($sports_details as $row){ 
		 ?>
		 <option value='<?php echo $row->SportsType_ID ;?>'<?php echo trim($row->SportsType_ID) == $sport ? 'selected="selected"' : ''; ?>><?php echo $row->Sportname ; ?></option>
		<?php 
		 }
		 echo "</select>";
		?>
		</div>

		<input id='tab_id' name="tab_id" class='' type="hidden"  value="<?php echo $tab_id; ?>" />

		<div class="col-md-4">
		<input type="submit" id='upd_membership' value="Update" style="margin-top:10px" class="league-form-submit1" />
		<input type="button" value="Cancel" id="Cancel_mem1" style="margin-top:10px" class="league-form-submit1" />
		</div>
		<div id='membership_upd_err' class="col-md-8" style='margin-top: 15px;color:blue;font-weight:bold;'></div>

<!-- </form> -->
</div>

</dd>

<dt class="accordion__title">Coach Profile</dt>
<dd class="accordion__content">
<div class="acc-content">

<?php if($user_details['Is_coach'] == 1){ ?>

<div style="text-transform:none"><p><b>SPORT:</b>

<?php $get_sport = profile::get_sport($user_details['coach_sport']);
echo $get_sport['Sportname'];?></p></div><br />

<div style="text-transform:none">
<p><b>COACH PROFILE :</b><?php echo $user_details['coach_profile']; ?></p></div><br />

<div style="text-transform:none">
<p><b>COACH WEBSITE: </b> 
<?php
if($user_details['Coach_Website'] != "") {
 $check = "http";
 $pos	= strpos($user_details['Coach_Website'], $check);
if($pos){ ?>
 <a target="_blank" href="<?php echo $user_details['Coach_Website'];?>"><?php echo $user_details['Coach_Website'];?></a>
<?php } else { ?>
 <a target="_blank" href="<?php echo "http://".$user_details['Coach_Website'];?>">
 <?php echo $user_details['Coach_Website'];?></a>  

<?php }
} ?>
</p>
</div><br />

<div style="text-transform:none">
<p><b>COACH CLUB: </b> 
<?php
if($user_details['coach_academy'] != "") {
$get_club = profile::get_club($user_details['coach_academy']);

	if($get_club['Aca_URL_ShortCode']){
		echo "<a href='".base_url().$get_club['Aca_URL_ShortCode']."' target='_blank'>{$get_club['Aca_name']}</a>";
	}
	else{
		echo $get_club['Aca_name'];
	}
?>

<?php 
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


<div id="coach" style="display:none">
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
		
		<div class="col-md-4">
		<label for="email">Coach for Club?</label>
		<input id="coach_club" name="coach_club" class="ui-autocomplete-input form-control" type="text" placeholder="USTA / USATT" autocomplete="off">
		<input class="form-control" id="org_id2" name="org_id" type="hidden" placeholder="Org_id" value="">
		<!-- <div id="org_stat" style="color:red;"></div> -->
		</div>


		<div class="col-md-12">
		<label for="email">Coach Profile</label><div class="clear"></div>
		<textarea cols="30" rows="10" id="coach_profile" name="coach_profile" class="txt-area"></textarea>
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
		 <option value='<?php echo $row->SportsType_ID ;?>' <?php if($row->SportsType_ID == $user_details['coach_sport']) { 
		 echo "selected"; } ?>><?php echo $row->Sportname ; ?></option>	 
		<?php 
		 }	
		?>
		</select>
		</div>
		<div class="col-md-4">
		<label for="email">Coach Website</label><div class="clear"></div>
		<input id="coach_web" name="coach_web" class="form-control" type="text" value="<?php echo $website; ?>" />
		</div>

		<div class="col-md-4">
		<label for="email">Coach for Club?</label>
		<input id="edit_coach_club" name="coach_club" class="ui-autocomplete-input form-control" type="text" placeholder="USTA / USATT" autocomplete="off" value="<?php echo $get_club['Aca_name']; ?>">
		<input class="form-control" id="org_id3" name="org_id" type="hidden" placeholder="Org_id" value="<?php echo $user_details['coach_academy']; ?>">
		<!-- <div id="org_stat" style="color:red;"></div> -->
		</div>

		<div class="col-md-12">
		<label for="email">Coach Profile</label><div class="clear"></div>
		<textarea cols="30" rows="10" id="edit_coach_profile" name="coach_profile" class="txt-area"><?php echo $user_details['coach_profile']; ?></textarea>
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
<div style="clear:both"></div>
</div>
<!--Close Top Match-->
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script> 
<link rel="stylesheet" href="https://unpkg.com/dropzone/dist/dropzone.css" />
<link href="https://unpkg.com/cropperjs/dist/cropper.css" rel="stylesheet"/>
<script src="https://unpkg.com/dropzone"></script>
<script src="https://unpkg.com/cropperjs"></script>

    		<div class="modal fade" id="modal" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
			  	<div class="modal-dialog modal-lg" role="document">
			    	<div class="modal-content">
			      		<div class="modal-header">
			        		<h5 class="modal-title">Crop Image Before Upload</h5>
			        		<button type="button" class="close" data-dismiss="modal" aria-label="Close">
			          			<span aria-hidden="true">×</span>
			        		</button>
			      		</div>
			      		<div class="modal-body">
			        		<div class="img-container">
			            		<div class="row">
			                		<div class="col-md-8">
			                    		<img src="" id="sample_image" />
			                		</div>
			                		<div class="col-md-4">
			                    		<div class="preview"></div>
			                		</div>
			            		</div>
			        		</div>
			      		</div>
			      		<div class="modal-footer">
			      			<button type="button" id="crop" class="btn btn-primary">Crop</button>
			        		<button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
			      		</div>
			    	</div>
			  	</div>
			</div>		

<script>
$(document).ready(function(){

	var $modal = $('#modal');
	var image	  = document.getElementById('sample_image');
	var image_orig	  = document.getElementById('prof_pic_id');

	var cropper;

	$('#fileInput').change(function(event){
		var files = event.target.files;

		var done = function(url){
			image.src = url;
			$modal.modal('show');
		};

		if(files && files.length > 0)	{
			reader = new FileReader();
			reader.onload = function(event){
				done(reader.result);
			};
			reader.readAsDataURL(files[0]);
		}
	});

	$modal.on('shown.bs.modal', function() {
		cropper = new Cropper(image, {
			aspectRatio: 1,
			viewMode: 3,
			preview:'.preview'
		});
	}).on('hidden.bs.modal', function(){
		cropper.destroy();
   		cropper = null;
	});

	$('#crop').click(function(){
		canvas = cropper.getCroppedCanvas({
			width:400,
			height:400
		});

		canvas.toBlob(function(blob){
			url = URL.createObjectURL(blob);
			var reader = new FileReader();
			reader.readAsDataURL(blob);
			reader.onloadend = function(){
				var base64data = reader.result;
				$.ajax({
					url:'profile/upload_crop_profimg',
					method:'POST',
					data:{image:base64data},
					success:function(data)
					{
						$modal.modal('hide');
						//$('#uploaded_image').attr('src', data);
						$('#fileInput_ajax').val(data);
						$('#prof_pic_id').attr('src', 'profile_pictures/'+data);
					}
				});
			};
		});
	});
	
});
</script>
<style>

		.image_area {
		  position: relative;
		}

		img {
		  	display: block;
		  	max-width: 100%;
		}

		.preview {
  			overflow: hidden;
  			width: 160px; 
  			height: 160px;
  			margin: 10px;
  			border: 1px solid red;
		}

		.modal-lg{
  			max-width: 1000px !important;
		}

		.overlay {
		  position: absolute;
		  bottom: 10px;
		  left: 0;
		  right: 0;
		  background-color: rgba(255, 255, 255, 0.5);
		  overflow: hidden;
		  height: 0;
		  transition: .5s ease;
		  width: 100%;
		}

		.image_area:hover .overlay {
		  height: 50%;
		  cursor: pointer;
		}

		.text {
		  color: #333;
		  font-size: 20px;
		  position: absolute;
		  top: 50%;
		  left: 50%;
		  -webkit-transform: translate(-50%, -50%);
		  -ms-transform: translate(-50%, -50%);
		  transform: translate(-50%, -50%);
		  text-align: center;
		}
		
		</style>