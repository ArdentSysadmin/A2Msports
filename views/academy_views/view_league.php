<script src="<?=base_url();?>assets/tinymce/tinymce.min.js"></script>

<script>
tinymce.init({
  selector: 'textarea',
  height: 300,
  theme: 'modern',
  plugins: [
    'advlist autolink lists link image charmap print preview hr anchor pagebreak',
    'searchreplace wordcount visualblocks visualchars code fullscreen',
    'insertdatetime media nonbreaking save table contextmenu directionality',
    'emoticons template paste textcolor colorpicker textpattern imagetools codesample toc help'
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
$(document).ready(function(){
	$(".x1").click(function () {
		var mtype_id = $(this).attr('id');
		
		var s_stat  = $('#singles').is(":checked");
		var d_stat  = $('#doubles').is(":checked");
		var m_stat  = $('#mixed').is(":checked");

		if(s_stat && (d_stat || m_stat)){	
			if($('input[name^="addn_fee_collect"]').length == 0){
				$('.div_grp').each(function() {
					var $ctrl = $("<div class='col-md-2'><input type='text' class='form-control' name='addn_fee_collect[]' placeholder='Additional Fee' value='0.00' /></div>");
					$(this).append($ctrl);
				});
			}
		}
		else{
			//alert('Additional Fee Not Required');
			$('input[name^="addn_fee_collect"]').each(function() {
				$(this).parent('div').remove();
				$(this).remove();
			});
		}
	
	});

var baseurl = "<?php echo base_url();?>";

$("#academy").autocomplete({
 
	source: function( request, response ) {
  		$.ajax({
			url: baseurl+'academy_ctrl/Opponent/autocomplete',
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
				  $('#org_id').val(names[1]);
				  
	}		      	
  });

});

</script>


<script>

function doCompareDate() {
var sdate1 = document.getElementById("sdate").value;

//var edate1 = document.getElementById("edate").value;

var reg_close = document.getElementById("reg_closedon").value;

var x = new Date(sdate1);
var z = new Date(reg_close);

if (z > x ) {
alert("Registration close date can not be greater than start date");
return false;
}
else
{
return true;
}
 
}
</script>

<script>
$(document).ready(function(){

	$(".age").click(function () {
	var ch_id		  = $(this).attr('id');
	var stat		  = $('#' + ch_id).is(":checked");
	var age_grp_label = $('label[for='+ch_id+']').text();

	if($('#singles').is(":checked") || $('#doubles').is(":checked") || $('#mixed').is(":checked")){
	var	label_text = "<div class='col-md-2' style='padding-top:5px;'>"+age_grp_label+"<input type='hidden' class='form-control' name='age_group[]' value='"+ch_id+"' /></div>";
	}else{
	var label_text = "";
	}

	if($('#singles').is(":checked")){
	var	fee_amount = "<div class='col-md-2'><input type='text' class='form-control' name='fee_collect[]' placeholder='Fee Amount' value='0.00' /></div>";
	}else{
	var fee_amount = "";
	}
	
	if($('#doubles').is(":checked") || $('#mixed').is(":checked")){
	var	add_fee_amount = "<div class='col-md-2'><input type='text' class='form-control' name='addn_fee_collect[]' placeholder='Additional Fee' value='0.00' /></div>";
	}else{
	var add_fee_amount = "";
	}

	if(stat){
		var i = 0;
	var $ctrl = $("<div class='col-md-12 div_grp' id='div_"+ch_id+"' style='padding-bottom:4px;'>"+label_text+fee_amount+add_fee_amount+"</div>");
				$("#dyn_courts").append($ctrl);
	}
	else{
	$("#dyn_courts #div_"+ch_id+"").remove();
	}

	});

});
</script>

<script>
function CompareDate() {
		var sdate1 = document.getElementById("sdate").value;
		var edate1 = document.getElementById("edate").value;

		var x = new Date(sdate1);
		var y = new Date(edate1);

		if (x > y){
			alert("Start date can not be greater than End date.");
			return false;
		}
	}
</script>

<script type="text/javascript">
$(function () {
	$("input[name='fee']").click(function () {
		if ($("#chkYes").is(":checked")) {

			var checked =  $('#singles:checkbox:checked').length > 0;
			var checked1 =  $('#doubles:checkbox:checked').length > 0;
			var checked2 =  $('#mixed:checkbox:checked').length > 0;

			if ((checked == true && checked1 == true) || (checked1 == true && checked2 == true) || (checked2 == true && checked == true)) {

				if ($("#chkYes").is(":checked")) {
					$("#div_fee_section").show();
				}
			} 
			else {
				$("#div_fee_section").hide();
			}

	$("#dvPassport").show();
	$("#div_fee_section").show();

	} else {
		$("#dvPassport").hide();
		$("#div_fee_section").hide();
	}
	});
});
</script>

<script type="text/javascript">
$(document).ready(function(){
    $('input[type="checkbox"]').click(function(){
        
		var checked  =  $('#singles:checkbox:checked').length > 0;
		var checked1 =  $('#doubles:checkbox:checked').length > 0;
		var checked2 =  $('#mixed:checkbox:checked').length > 0;		
		
		if ((checked == true && checked1 == true) || (checked1 == true && checked2 == true) || (checked2 == true && checked == true)) {
			 
			 if ($("#chkYes").is(":checked")) {
			 $("#add_event").show();
			 }
		} 
			else {
			 $("#add_event").hide();
		}
		});
		
		  
		 $("#visible1").click(function () {
          $("#academy_text").show();
		});
		
	    $("#visible").click(function () {
          $("#academy_text").hide();
        });
		if($("#visible1").is(":checked")) {
			 $("#academy_text").show();
	     }
		
});
</script>

<script>
$(document).ready(function(){

$(function () {
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
</script>

<script type="text/javascript">
$(document).ready(function(){
    $('#open_gender').click(function(){
			$("#mixed").removeAttr("disabled"); 
	});

    $('#male, #female').click(function(){
		 if ($("#mixed").is(":checked")) {
				$('#mixed').attr('checked', false);
			 }
		$("#mixed").attr("disabled", true); 
	});
});
</script>

<!-- -----------------Terms and conditions--------------------- -->
<script language="javascript" type="text/javascript">

function terms_conditions()
{
var path = "<?php echo base_url(); ?>";
var left  = ($(window).width()/2)-(725/2),
	top   = ($(window).height()/2)-(600/2),
	popup = window.open (path+'terms_conditions/', "popup", "width=725,scrollbars=1,height=600, top="+top+", left="+left);

   // window.open(path+'league/terms_conditions/',null,"height=650,width=700,status=yes,toolbar=no,menubar=no,location=no, top="+top+", left="+left");
}

</script>
<!-- -----------------end of Terms and conditions--------------------- -->


<script>
$(document).ready(function(){
    $('#myform').submit(function() {
       if ( $("input[name='age[]']:checked").length == 0 ) { 
           alert("Select at least one Age group"); 
			return false;
        }
	    else { return true; }
    });
});
</script>

<script>
$(document).ready(function(){
    $('#myform').submit(function() {
       if ( $("input[name='singles[]']:checked").length == 0 ) { 
            alert("Select at least one Match type"); 
			return false;
        }
	    else { return true; }
    });
});
</script>

<script>
$(document).ready(function(){
    $('#myform').submit(function() {
       if ( $("input[name='level[]']:checked").length == 0 ) { 
            alert("Select at least one Sport Level"); 
			return false;
        }
	    else { return true; }
    });
});
</script>

<script>
$(document).ready(function(){
var baseurl = "<?php echo base_url();?>";
	$('#Sport').on('change',function(){
	
        var SportID = $(this).val();

		 $('#sport_levels_div').show();

        if(SportID!=""){
			//alert(SportID);
            $.ajax({
                type:'POST',
                url:baseurl+'academy_ctrl/league/Sport_levels/',
                data:'sport_id='+SportID,
                success:function(html){
                    $('#sport_levels_div').html(html);
                }
            }); 
        }else
		{
			$('#sport_levels_div').hide();
		}
	});	
 }); 
</script>



 <section id="single_player" class="container secondary-page">

           <div class="top-score-title right-score col-md-9">
           
           <div class="col-md-12 league-form-bg" style="margin-top:40px;">
           		<div class="fromtitle">Create a Tournament</div>
                <p style="line-height:20px; font-size:13px">If you are an organization, business entity or just an active member of community and would like to organize sporting events, you can do that here. Start entering the details below. If you are simply looking to find a player to play one quick match, please click <b><a href="<?php echo base_url()."opponent"; ?>">Friendly Match</a></b>.</p><br /> 
				<?php if($this->session->userdata('user')=="") { ?>
				
				<p style="line-height:5px; font-size:13px">Please <a href='<?php echo base_url()."login"; ?>'><b>Login</b> </a>to create tournament</p>
				<?php } ?>
            </div>

<?php if($this->session->userdata('user')!="") { 
$short_code	= $this->uri->segment(1);
?>		           
		  <form class="form-horizontal" id='myform' method='post' role="form" enctype="multipart/form-data" 
		  action="<?php echo base_url().$short_code."/league/create_trnmt"; ?>"  onsubmit="return doCompareDate()">  
		   
		   <div class="col-md-12 league-form-bg" style="margin-top:30px;">
           		<div class="fromtitle">Tournament Details</div>

		  <div class='form-group'>
            <label class='control-label col-md-3' for='id_accomodation'>Sport Type</label>
            <div class='col-md-8 form-group internal'>
			<select name="sport_type" id="Sport" class='form-control' style="width:45%" required>
			<option value="">Select</option>
				<?php foreach($intrests as $row) { ?> 
				<option value="<?php echo $row->SportsType_ID;?>"><?php echo $row->Sportname;?></option>
				<?php } ?>
			</select>
            </div>
          </div>

		 <div id='sport_levels_div' class='form-group' style="display:none">
			<label class='control-label col-md-3' for='id_accomodation'>Levels </label>
			<?php
			$sp_level = array();
			if($this->input->post('level'))	{
			$sp_level = $this->input->post('level');
			}
			?>
			<div  class='col-md-8 form-group internal'>
			<?php foreach($sport_levels as $row){ ?>

			<input type="checkbox" class="ajax_click" name="level[]" <?php if(in_array($row->SportsLevel_ID, $sp_level)){echo "checked = checked"; } ?> value="<?php echo $row->SportsLevel_ID;?>"> <?php echo $row->SportsLevel;?> &nbsp;
		
			<?php } ?>
			</div>
		</div>
		  
		  <div class='form-group'>
            <label class='control-label col-md-3' for='id_accomodation'>Tournament Type</label>
            <div class='col-md-8 form-group internal'>
			<select name="tourn_type" class='form-control' style="width:45%" required>
				<option value="">Select</option>
				<option value="Single Elimination">Single Elimination</option>
				<option value="Consolation">Consolation</option>
				<option value="Round Robin">Round Robin</option>
			</select>
            </div>
          </div>

          <div class='form-group'>
            <label class='control-label col-md-3' for='id_accomodation'>Tournament Title </label>
            <div class='col-md-6 form-group internal'>
              <input class='form-control' id='title' name='title' type='text' required />
            </div>
          </div>
		  
          <div class='form-group'>
            <label class='control-label col-md-3' for='id_accomodation'>* Organizer Name<br />(Company / Individual) </label>
            <div class='col-md-6 form-group internal'>
              <input class='form-control' id='organizer' name='organizer' type='text' required />
            </div>
          </div>
          <div class='form-group'>
            <label class='control-label col-md-3' for='id_accomodation'>* Contact Number </label>
            <div class='col-md-6 form-group internal'>
              <input class='form-control' id='org_contact' name='org_contact' maxlength="12" type='text' style="width:64%;" required />
            </div>
          </div>
		  
		 

		  <div class="form-group">  
			<label class='control-label col-md-3' for='id_accomodation'>Tournament Image </label>
            <div class='col-md-6 form-group internal'>
			   <input id="playinglevel" name="TournamentImage" style="margin-bottom:28px" type="file"/>
            </div>
          </div>
		  
          <div class='form-group'>
            <label class='control-label col-md-3' for='id_title'>* Start Date</label>
            <div class='col-md-3 form-group internal'>
                  <!-- <input class='form-control datepicker' id='id_checkin' name='sdate' required> --> 
				  <input type="text" class='form-control' placeholder="MM/DD/YYYY" id="sdate"  name="sdate" required /> 
                 
              </div>
            <label class='control-label col-md-3' for='id_title'>* End Date</label>
            <div class='col-md-3 form-group internal'>
                  <input type="text" class='form-control datepicker' placeholder="MM/DD/YYYY" id="edate" name="edate"  required /> 
				 
                  <!--  <span class='input-group-addon'>
				   <div style='display:none;' id="lblerror">Start should not be on or before current date</div>
                    <i class="fa fa-calendar"></i>
                  </span>  -->

              </div>
          </div>
          
          <div class='form-group'>
            <label class='control-label col-md-3' for='id_title'>* Registrations closed on</label>
            <div class='col-md-4 form-group internal'> 
				  <input  type="text" class='form-control datepicker' placeholder="MM/DD/YYYY" id="reg_closedon" name="reg_closedon" onblur="CompareDate()" required />
            </div>
          </div>
   
          <div class='form-group'>
            <label class='control-label col-md-3' for='id_accomodation'>* Match Type</label>
            <div class='col-md-5 form-group internal'>
            	<input type="checkbox" class='x1' name="singles[]" id="singles" value="Singles"><label class='control-label' for='singles'> Singles &nbsp;</label>
				<input type="checkbox" class='x1' name="singles[]" id="doubles" value="Doubles"> <label class='control-label' for='doubles'>Doubles &nbsp;</label>
				<input type="checkbox" class='x1' name="singles[]" id="mixed" value="Mixed"> <label class='control-label' for='mixed'>Mixed Doubles </label>
            </div>
          </div>

		  <div class='form-group'>
            <label class='control-label col-md-3' for='id_title'>* Age Group</label>
            <div class='col-md-7 form-group internal'>
				<input type="checkbox" class='age' id='age_u12' name="age[]" value="U12"><label class='control-label' for='age_u12'>Under 12 &nbsp;</label>
				<input type="checkbox" class='age' id='age_u14' name="age[]" value="U14"> <label class='control-label' for='age_u14'>Under 14 &nbsp;</label>
				<input type="checkbox" class='age' id='age_u16' name="age[]" value="U16"> <label class='control-label' for='age_u16'>Under 16 &nbsp;</label>
				<input type="checkbox" class='age' id='age_u18' name="age[]" value="U18"> <label class='control-label' for='age_u18'>Under 18 &nbsp;</label><br />
				<input type="checkbox" class='age' id='age_adults' name="age[]" value="Adults"> <label class='control-label' for='age_adults'>Adults&nbsp;</label>
				<input type="checkbox" class='age' id='age_30p' name="age[]" value="Adults_30p"> <label class='control-label' for='age_30p'>30s&nbsp;&nbsp;</label>
				<input type="checkbox" class='age' id='age_40p' name="age[]" value="Adults_40p"> <label class='control-label' for='age_40p'>40s&nbsp;&nbsp;</label>
				<input type="checkbox" class='age' id='age_50p' name="age[]" value="Adults_50p"> <label class='control-label' for='age_50p'>50s&nbsp;&nbsp;</label>
				<input type="checkbox" class='age' id='veteran' name="age[]" value="Adults_veteran"> <label class='control-label' for='veteran'>Veteran</label>
            </div>
          </div>

          <div class='form-group'>
            <label class='control-label col-md-3' for='id_accomodation'>* Gender</label>
            <div class='col-md-8 form-group internal'>
			  <input type="radio" name="gender_type" id="male" value="1" required> <label class='control-label' for='male'> Male Only&nbsp;&nbsp;</label>
			  <input type="radio" name="gender_type" id="female" value="0" required><label class='control-label' for='female'> Female Only</label>
			  <input type="radio" name="gender_type" id="open_gender" value="all" required> <label class='control-label' for='open_gender'>  Open to All&nbsp;&nbsp; </label>
            </div>
          </div>

         <div class='form-group'>
            <label class='control-label col-md-3' for='id_accomodation'>Maximum players for this tournament </label>
            <div class='col-md-8 form-group internal'>
              <input class='form-control' id='max_players' name='max_players' type='text' style="width:25%">
            </div>
          </div>

          <div class='form-group'>
            <label class='control-label col-md-3' for='id_accomodation'>* Venue </label>
            <div class='col-md-6 form-group internal'>
              <input class='form-control' id='venue' name='venue' type='text' style="width:80%" required>
            </div>
            <!-- <div class='col-md-3 form-group internal' style="margin-top:6px; margin-left:1px">
              <input type="submit" value="Search.." style="padding:2px 10px"/>
            </div> -->
          </div>
          
         <div class='form-group'>
            <label class='control-label col-md-3' for='id_accomodation'>* Address Line1 </label>
            <div class='col-md-8 form-group internal'>
              <input class='form-control' id='addr1' name='addr1' type='text' style="width:80%" required>
            </div>
          </div>

		   <div class='form-group'>
            <label class='control-label col-md-3' for='id_accomodation'>Address Line2 </label>
            <div class='col-md-8 form-group internal'>
              <input class='form-control' id='addr2' name='addr2' type='text' style="width:80%">
            </div>
          </div>
          
          <div class='form-group'>
          
            <label class='control-label col-md-3' for='id_accomodation'>* Country</label>
            <div class='col-md-4 form-group internal'>
              <select class='form-control' id='country' name='country' required>
                <option value="">Select</option>
				<?php
$countries = array("Afghanistan", "Albania", "Algeria", "American Samoa", "Andorra", "Angola", "Anguilla", "Antarctica", "Antigua and Barbuda", "Argentina", "Armenia", "Aruba", "Australia", "Austria", "Azerbaijan", "Bahamas", "Bahrain", "Bangladesh", "Barbados", "Belarus", "Belgium", "Belize", "Benin", "Bermuda", "Bhutan", "Bolivia", "Bosnia and Herzegowina", "Botswana", "Bouvet Island", "Brazil", "British Indian Ocean Territory", "Brunei Darussalam", "Bulgaria", "Burkina Faso", "Burundi", "Cambodia", "Cameroon", "Canada", "Cape Verde", "Cayman Islands", "Central African Republic", "Chad", "Chile", "China", "Christmas Island", "Cocos (Keeling) Islands", "Colombia", "Comoros", "Congo", "Congo, the Democratic Republic of the", "Cook Islands", "Costa Rica", "Cote d'Ivoire", "Croatia (Hrvatska)", "Cuba", "Cyprus", "Czech Republic", "Denmark", "Djibouti", "Dominica", "Dominican Republic", "East Timor", "Ecuador", "Egypt", "El Salvador", "Equatorial Guinea", "Eritrea", "Estonia", "Ethiopia", "Falkland Islands (Malvinas)", "Faroe Islands", "Fiji", "Finland", "France", "France Metropolitan", "French Guiana", "French Polynesia", "French Southern Territories", "Gabon", "Gambia", "Georgia", "Germany", "Ghana", "Gibraltar", "Greece", "Greenland", "Grenada", "Guadeloupe", "Guam", "Guatemala", "Guinea", "Guinea-Bissau", "Guyana", "Haiti", "Heard and Mc Donald Islands", "Holy See (Vatican City State)", "Honduras", "Hong Kong", "Hungary", "Iceland", "India", "Indonesia", "Iran (Islamic Republic of)", "Iraq", "Ireland", "Israel", "Italy", "Jamaica", "Japan", "Jordan", "Kazakhstan", "Kenya", "Kiribati", "Korea, Democratic People's Republic of", "Korea, Republic of", "Kuwait", "Kyrgyzstan", "Lao, People's Democratic Republic", "Latvia", "Lebanon", "Lesotho", "Liberia", "Libyan Arab Jamahiriya", "Liechtenstein", "Lithuania", "Luxembourg", "Macau", "Macedonia, The Former Yugoslav Republic of", "Madagascar", "Malawi", "Malaysia", "Maldives", "Mali", "Malta", "Marshall Islands", "Martinique", "Mauritania", "Mauritius", "Mayotte", "Mexico", "Micronesia, Federated States of", "Moldova, Republic of", "Monaco", "Mongolia", "Montserrat", "Morocco", "Mozambique", "Myanmar", "Namibia", "Nauru", "Nepal", "Netherlands", "Netherlands Antilles", "New Caledonia", "New Zealand", "Nicaragua", "Niger", "Nigeria", "Niue", "Norfolk Island", "Northern Mariana Islands", "Norway", "Oman", "Pakistan", "Palau", "Panama", "Papua New Guinea", "Paraguay", "Peru", "Philippines", "Pitcairn", "Poland", "Portugal", "Puerto Rico", "Qatar", "Reunion", "Romania", "Russian Federation", "Rwanda", "Saint Kitts and Nevis", "Saint Lucia", "Saint Vincent and the Grenadines", "Samoa", "San Marino", "Sao Tome and Principe", "Saudi Arabia", "Senegal", "Seychelles", "Sierra Leone", "Singapore", "Slovakia (Slovak Republic)", "Slovenia", "Solomon Islands", "Somalia", "South Africa", "South Georgia and the South Sandwich Islands", "Spain", "Sri Lanka", "St. Helena", "St. Pierre and Miquelon", "Sudan", "Suriname", "Svalbard and Jan Mayen Islands", "Swaziland", "Sweden", "Switzerland", "Syrian Arab Republic", "Taiwan, Province of China", "Tajikistan", "Tanzania, United Republic of", "Thailand", "Togo", "Tokelau", "Tonga", "Trinidad and Tobago", "Tunisia", "Turkey", "Turkmenistan", "Turks and Caicos Islands", "Tuvalu", "Uganda", "Ukraine", "United Arab Emirates", "United Kingdom", "United States of America", "United States Minor Outlying Islands", "Uruguay", "Uzbekistan", "Vanuatu", "Venezuela", "Vietnam", "Virgin Islands (British)", "Virgin Islands (U.S.)", "Wallis and Futuna Islands", "Western Sahara", "Yemen", "Yugoslavia", "Zambia", "Zimbabwe");

foreach($countries as $country)
{
 echo "<option value='$country'>$country</option>";
}
?>
</select>

		</div>
	   </div>
          
	<div class='form-group' style='display:none;' id='state_box'>
	<label class='control-label col-md-3' for='id_accomodation'>* State</label>
	<div class='col-md-8 form-group internal'>
	<input class='form-control' id='state1' name='state1' type='text' style="width:45%">
	</div>
	</div>

	<div class='form-group' id="state_drop">
	<label class='control-label col-md-3' for='id_title'>* State</label>
	<div class='col-md-4 form-group internal'>
	<select name="state" id="state" class='form-control' onChange="stateChange();">
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
	<label class='control-label col-md-3' for='id_accomodation'>* City</label>
	<div class='col-md-8 form-group internal'>
	<input class='form-control' id='city' name='city' type='text' style="width:45%" required>
	</div>
	</div>

	<div class='form-group'>
	<label class='control-label col-md-3' for='id_accomodation'>* Postal Code</label>
	<div class='col-md-8 form-group internal'>
	<input class='form-control' id='zipcode' name="zipcode" type='text' style="width:45%" required>
	</div>
	</div>

	<div class='form-group'>
	<label class='control-label col-md-3' for='id_accomodation'>Tournament Description</label>
	<div class='col-md-7 form-group internal'>
	<textarea name="desc" class="txt-area" id="desc" cols="20" rows="2"></textarea>
	</div>
	</div>
	</div>

	<div class="col-md-12 league-form-bg" style="margin-top:30px;">
	<div class="fromtitle">Fees</div>
	Do you want to collect a fee from players to participate in the tournament&nbsp; <label for="chkYes">
	<input type="radio" id="chkYes" name="fee" value="1" />
	Yes
	</label>&nbsp;&nbsp;
	<label for="chkNo">
	<input type="radio" id="chkNo" name="fee" value="0" checked="checked" />
	No
	<br />
	</label>
	
	<div id="div_fee_section" style="display: none">	<!-- Fee Section -->
	<div class='col-md-12' style='padding-bottom:4px;'>
		<div class='col-md-2' style='padding-top:5px;'>&nbsp;</div>
		<div class='col-md-2'>Fee Amount</div>
		<div class='col-md-2'>Additional Fee</div>
	</div>
	
	<div id='dyn_courts'><!-- Dynamic Add New Courts Area --></div> 
	</div>												<!-- Fee Section end -->

	<!-- <div id="add_event" style="display: none">
	<div class='form-group'>
	<label class='control-label col-md-3' for='id_accomodation'>Amount for additional event: </label>
	<div class='col-md-6 form-group internal'>
	  <input class='form-control' id='amt_two' name='amt_two' type='text' style="width:48%;" />
	</div>
	</div> 
	</div> -->

	</div>


	<div class="col-md-12 league-form-bg" style="margin-top:30px;">
	<div class="fromtitle">Access </div>
	Visible to  &nbsp; <label for="chkYes">
	<input type="radio" id="visible" name="visible" value="public" checked="checked"  />
	Public
	</label>&nbsp;&nbsp;
	<label for="chkNo">
	<input type="radio" id="visible1" name="visible" value="private" />
	Private
	</label>

	<div id="academy_text" style="display: none">
		<div class='form-group'>
			<label class='control-label col-md-3' for='id_accomodation'>Academy Name: </label>
			<div class='col-md-6 form-group internal'>
		<input id='academy' name="club_name" class='ui-autocomplete-input col-md-3 form-control ajax_blur' type="text" placeholder="USTA / USATT" />
		<input class='form-control' id='org_id' name='org_id' type='hidden' placeholder="Org_id" value=""  />
			</div>
		</div> 
	</div>

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

<div class="col-md-12 league-form-bg" style="margin-top:30px; margin-bottom:20px;">
<div class="fromtitle">Review & Submit</div>

<div class='form-group'>
<div class='col-md-12 form-group internal input-group' style="font-size:13px; margin-left:25px">

<br>
<input type="checkbox" name="recommend" id="recommend" value="1" />
I accept the <a style='cursor:pointer;' onclick='terms_conditions()'><b>Terms & Conditions</b></a> of A2M Sports. I'm responsible for conducting the tournament and accept full responsibility that for any personnel, financial and legal issues that may arise.<br />

<input type="submit" value="Submit" name='create_tourn' style="margin-top:20px" class="league-form-submit" />
</div>
</div>
</div>

</form>
<?php } ?>
</div><!--Close Top Match-->