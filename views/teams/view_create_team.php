<script type="text/javascript">
 	function listbox_selectall(listID, isSelect) {
        var listbox = document.getElementById(listID);
        for(var count=0; count < listbox.options.length; count++) {

			var selIndex = listbox.selectedIndex;
		 
			//document.write(listbox);
			//document.write(selIndex);

            listbox.options[count].selected = isSelect;
		}
	}
</script>

<script>
$(document).ready(function(){
var baseurl = "<?php echo base_url();?>";
		
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
				}));
			}
  		});
  	},
  	autoFocus: true,	      	
  	minLength: 1,
  	select: function( event, ui ) {
		var names = ui.item.data.split("|");						
		//$('#created_users_id').val(names[1]);

		$('#shortlist_users').append($('<option/>', { 
			value: names[1],
			text : names[0] 
		}));

		$('#created_by').val(''); 
		$('#created_by').focus();

	}
});


  /*$('input[type=text]').focus(function() {
     $(this).val('');
  });*/
 $('#home_court').focus(function(){
	$('#home_loc_err').html('');
 });

  $('#home_court').blur(function(){
    if( $('#home_court_id').val() == ''){
		$('#home_court').val('');
		$('#home_loc_err').html('Invalid Home Location! Select a location from the list.');
	}
  
  });
});
</script>

<script>
$(document).ready(function(){
var baseurl = "<?php echo base_url();?>";

$('#home_court').autocomplete({
	source: function( request, response ) {
  		$.ajax({
			url: baseurl+'league/autocomplete_hloc',
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
				}));
			}
  		});
  	},
  	autoFocus: true,	      	
  	minLength: 1,
  	select: function( event, ui ) {
		var names = ui.item.data.split("|");						
		$('#home_court_id').val(names[1]);
	}
});

});
</script>

<script>
$(document).ready(function(){

$('#btn_location').click(function(){

var baseurl = "<?php echo base_url();?>";
var Title	= $("#loc_title").val();

if(Title != ""){
var Add		= $("#loc_add").val();
var City	= $("#loc_city").val();
var State	= $("#loc_state").val();
var Country = $("#loc_country").val();
var Zip		= $("#loc_zipcode").val();

$.ajax({
		type:'POST',
		url:baseurl+'league/homeloc_add/',
		data:{title:Title, add:Add, city:City, state:State, country:Country, zip:Zip},
		success:function(res){
			$('#loc_form').each(function(){
			this.reset();
			});
			$('#location_form').hide();
			$('.reg_players').show();
		}
});
}
else {
alert("Location Name should not be empty!");
}

});

$('#btn_register').click(function(){

var baseurl = "<?php echo base_url();?>";
var lname	= $("#txt_lname").val();
var email	= $("#txt_email").val();
var gender  = $("input[name='txt_gender']:checked"). val();

if(lname != "" && email != ""){

var fname	= $("#txt_fname").val();
var phone	= $("#txt_phone").val();

$.ajax({
		type:'POST',
		url:baseurl+'register/instant_register/',
		data:{fname:fname, lname:lname, email:email, gender:gender, phone:phone},
		success:function(res){

			if(res != '0'){
			var names = res.split("|");						

			$('#shortlist_users').append($('<option/>', { 
				value: names[1],
				text : names[0] 
			}));
			$('#reg_player_form').hide();
			$('.reg_players').show();
			}
			else{
				alert('Something went wrong! Please try again.');
			}
		}
});
}
else {
alert("Last Name & Email should not be empty!");
}

});

	$('#txt_email').blur(function(){
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
					$('#txt_email').val("");
					}
					else{
                    $('#txt_email').html("");
					}
                }
            }); 
        }
    });

	$('#myform').submit(function(){
		$('#create_team').hide();
		$('#submit_text').html('<h4>Please wait ....</h4>');
	});
});
</script>

<section id="single_player" class="container secondary-page">

<div class="col-md-9 league-form-bg" style="margin-top:30px; margin-bottom:20px;">
<div class="fromtitle">New Team</div>

<?php if($this->session->userdata('user')=="") { ?>
<p style="line-height:5px; font-size:13px">Please <a href='<?php echo base_url()."login"; ?>'><b>Login</b> </a>to register for a tournament</p>
<?php  } ?>
<?php if($this->session->userdata('user')!="") { ?>
<?php 
if(isset($reg_status)) { ?>
   <div class="name" align='left'>
	 <label for="name_login" style="color:green"><?php echo $reg_status; ?></label>
   </div>
<?php
} else {
?>
<!-- <form class="form-horizontal" id='myform' method='post' role="form"  action="<?php echo base_url(); ?>league/register_trnmt"> -->
<form class="form-horizontal" id='myform' method='post' role="form" action="<?php echo base_url(); ?>teams/create" enctype="multipart/form-data">
 
<div class='col-md-8'>

<input type="hidden" name="id" value="<?php echo $_SERVER['HTTP_REFERER']; ?>" />

<p><label>Team Name</label> <input class='form-control' id='title' name='title' style='width:45%' type='text' required /></p>
<p><label>Team Logo</label><input type="file" name="team_logo" id="team_logo"></p>
<p><label>Sport</label> 
<select name="sport_type" id="Sport" class='form-control' style="width:45%" required>
<option value="">Select</option>
<?php foreach($sports as $row) { ?> 
<option value="<?php echo $row->SportsType_ID;?>"><?php echo $row->Sportname;?></option>
<?php } ?>
</select>
</p>
<p>
<input class='ui-autocomplete-input form-control inwidth' id='home_court' name='home_court' type='text' placeholder="Home Court Location" value="" required /><div id='home_loc_err' style='color:red'></div>
<input class='ui-autocomplete-input form-control inwidth' id='home_court_id' name='home_court_id' type='hidden' value="" />

<div class='col-md-8 form-group internal'><b>Note:</b> Click <b>
	<input type="button" id="add_location" value="Add New" class="league-form-submit1"></b> if your location didn't auto populate.

	<div class='form-group' id="location_form" style="display:none">
		<!-- <form name='loc_form' id='loc_form' method="post" action='<?php echo base_url();?>events/location_add'> -->			
		<div class='form-group'>
			<label class='control-label col-md-4' for='id_accomodation'>Location Title </label>
			<div class='col-md-8 form-group internal'>
			<input type="text" id="loc_title" name="loc_title" class='form-control' />
			</div>
		</div>

		<div class='form-group'>
			<label class='control-label col-md-4' for='id_accomodation'>Address </label>
			<div class='col-md-8 form-group internal'>
			<input type="text" id="loc_add" name="loc_add" class='form-control' />
			</div>
		</div>

		<div class='form-group'>
			<label class='control-label col-md-4' for='id_accomodation'>City </label>
			<div class='col-md-8 form-group internal'>
			<input type="text" id="loc_city" name="loc_city" class='form-control' />
			</div>
		</div>

		<div class='form-group'>
			<label class='control-label col-md-4' for='id_accomodation'>State </label>
			<div class='col-md-8 form-group internal'>
			<input type="text" id="loc_state" name="loc_state" class='form-control' />
			</div>
		</div>

		<div class='form-group'>
			<label class='control-label col-md-4' for='id_accomodation'>Country </label>
			<div class='col-md-8 form-group internal'>
			<input type="text" id="loc_country" name="loc_country" class='form-control' />
			</div>
		</div>

		<div class='form-group'>
			<label class='control-label col-md-4' for='id_accomodation'>Zip Code </label>
			<div class='col-md-8 form-group internal'>
			<input type="text" id="loc_zipcode" name="loc_zipcode" class='form-control' />
			</div>
		</div>
		
		<div class='form-group'>
			<label class='control-label col-md-4' for='id_accomodation'></label>
			<div class='col-md-8 form-group internal'>
			<input type="button" id="btn_location" name="btn_location"  value=" Add " class="league-form-submit1" />
			<input type="button" id="btn_loc_cancel" name="btn_location_cancel"  value=" Cancel " class="league-form-submit1" />
			</div>
		</div>
		<!-- </form> -->
	</div>
	</div>

</p>

<!-- <p><label>Location</label> <?php echo $r->venue. ','. $r->TournamentAddress. ',' .$r->TournamentCity. ', ' .$r->TournamentState; ?></p> -->

<script>
$(document).ready(function(){

$('#myform').submit(function() {

/*var sg =  $('#Singles:checkbox:checked').length > 0;
var db =  $('#Doubles:checkbox:checked').length > 0;
var mx =  $('#Mixed:checkbox:checked').length > 0;

var count = (db+mx+sg);

		if(count < 1 && $('#mtype_stat').val() != 0){
			alert("Select atleast one play format");
			return false;
		}
	    else { return true; }*/
    });
});
</script>

<script>
 $(document).ready(function(){ 
  $("#sel_all").change(function(){
    $(".checkbox1").prop('checked', $(this).prop("checked"));
    });
 });

 	function listbox_selectall(listID, isSelect) {
        var listbox = document.getElementById(listID);
        for(var count=0; count < listbox.options.length; count++) {

			var selIndex = listbox.selectedIndex;
		 
			//document.write(listbox);
			//document.write(selIndex);

            listbox.options[count].selected = isSelect;
		}
	}

 </script>

<?php } ?>
</div>

<?php
if(!isset($reg_status)) { 
?>
<div class='col-md-4'>
	<!-- tour image -->
</div>

<div class='col-md-12'>&nbsp;</div>
<script>
$(document).ready(function(){	

	$('#add_location, #btn_loc_cancel').click(function(){
		if($('#location_form').css('display')=='none'){
			$('#location_form').show();
			$('.reg_players').hide();
		}
		else{
			$('#location_form').hide();
			$('.reg_players').show();
		}
	});

	$('#reg_player, #btn_register_cancel').click(function(){
		if($('#reg_player_form').css('display')=='none'){
			$('#reg_player_form').show();
			$('.reg_players').hide();
		}
		else{
			$('#reg_player_form').hide();
			$('.reg_players').show();
		}
	});

});
</script>

<div class='col-md-9'>
	<p><label>Search Player & Add:</label>
	<input class='ui-autocomplete-input form-control inwidth' id='created_by' name='created_by' type='text' placeholder="Player Name" value="" /></p>
	</p>

<!-- Register a new Player by team captain -->

<div class='col-md-12 form-group internal'><b>Note:</b> Click <b>
	<input type="button" id="reg_player" value="Register Player" class="league-form-submit1"></b> if you want to add a new player to our site.

	<div class='form-group' id="reg_player_form" style="display:none">
		<!-- <form name='loc_form' id='loc_form' method="post" action='<?php echo base_url();?>events/location_add'> -->			
		<div class='form-group'>
			<label class='control-label col-md-4' for='id_accomodation'>First Name </label>
			<div class='col-md-5 form-group internal'>
			<input type="text" id="txt_fname" name="txt_fname" class='form-control' />
			</div>
		</div>

		<div class='form-group'>
			<label class='control-label col-md-4' for='id_accomodation'>Last Name </label>
			<div class='col-md-5 form-group internal'>
			<input type="text" id="txt_lname" name="txt_lname" class='form-control' />
			</div>
		</div>

		<div class='form-group'>
			<label class='control-label col-md-4' for='id_accomodation'>Gender </label>
			<div class='col-md-5 form-group internal'>
			<input type="radio" name="txt_gender" value="1" checked /> Male&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			<input type="radio" name="txt_gender" value="0" /> Female
			</div>
		</div>

		<div class='form-group'>
			<label class='control-label col-md-4' for='id_accomodation'>Email </label>
			<div class='col-md-5 form-group internal'>
			<input type="text" id="txt_email" name="txt_email" class='form-control' />
			<span id='email_stat' style='color:red'></span>
			</div>
		</div>

		<!-- <div class='form-group'>
			<label class='control-label col-md-4' for='id_accomodation'>Phone </label>
			<div class='col-md-5 form-group internal'> -->
			<input type="hidden" id="txt_phone" name="txt_phone" class='form-control' />
			<!-- </div>
		</div> -->

		<div class='form-group'>
			<label class='control-label col-md-4' for='id_accomodation'></label>
			<div class='col-md-8 form-group internal'>
			<input type="button" id="btn_register" name="btn_register"  value=" Register " class="league-form-submit1" />
			<input type="button" id="btn_register_cancel" name="btn_register_cancel" value=" Cancel " class="league-form-submit1" />
			</div>
		</div>
		<!-- </form> -->
	</div>
	</div>

<!-- Register a new Player by team captain -->
	

	<div id="doubles_div" class='reg_players'>
	<select id='shortlist_users' name="sel_player[]" multiple style="height:200pt;" class="inwidth" required>
	<option value='' disabled>Selected Players</option>
	</select>

	<br>Select
	<a  onclick="listbox_selectall('shortlist_users', true)" style='cursor:pointer'>All</a>,
	<a  onclick="listbox_selectall('shortlist_users', false)" style='cursor:pointer'>None</a>
	</div>
</div>

<div class='col-md-9 form-group internal reg_players' style="margin-top:10px">
<input name="bulk_register" id="create_team" type="submit" value="Create Team" class="league-form-submit1"/>
<span id='submit_text'></span>
</div>

</form>
</div>
<div style="clear:both;"></div>

<?php
	}
} ?>
</div>



<!-- end main body -->
</div>
</div><!--Close Top Match-->