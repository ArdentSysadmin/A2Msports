<?php
$club_url = $this->config->item('club_form_url');

if($club_url == "https://a2msports.com/play")
	$profile_base = base_url();
else
	$profile_base = $club_url."/";
?>
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
		$('input:radio[name="payment_method"]').change(
    function(){
        if ($(this).is(':checked')) {
           var payment_method = $(this).val();
           if(payment_method != 'Free Entry'){
            $("#paid_amount_p").show();
            $("#paid_amount").val('');
           }else{
           	$("#paid_amount").val('0.00');
           	$("#paid_amount_p").hide();
           }
           
        }
    });

	$('.reg_player, .btn_register_cancel').click(function(){

		if($('#rpform').css('display')=='none'){
			$('#rpform').show();
			//$('.reg_players').hide();
		}
		else{
			$('#rpform').hide();
			//$('.reg_players').show();
		}
	});

var baseurl = "<?php echo base_url();?>";

$('.btn_register').click(function(){

var tournament_id = $("#tournament_id").val();
var lname	      = $("#txtlname").val();
var email	      = $("#txtemail").val();
var gender        = $("input[name='gender']:checked").val();
var zipcode       = $("#zipcode").val();
//alert(tournament_id);die();

if(lname != "" && email != "" && zipcode != ""){

var fname	= $("#txtfname").val();
var phone	= $("#txtphone").val();
$('#btn_register').prop("disabled", true);
$('#btn_register').attr('value', 'Please wait...');

$.ajax({
		type:'POST',
		url:baseurl+'register/instant_register/',
		data:{fname:fname, lname:lname, email:email, phone:phone, gender:gender, Zipcode:zipcode,tourn_id:tournament_id},
		success:function(res){
			//alert(res);die();
            $("#txtfname").val('');
			$("#txtlname").val('');
			$("#txtemail").val('');
			$("#txtphone").val('');
			$("#zipcode").val('');
			$('#rpform').hide();
			$('#btn_register').prop("disabled", false);
			$('#btn_register').attr('value', 'Register');
		}
});
}
else {
  alert("Last Name & Email should not be empty!");
}

});

$('.txt_email').blur(function(){
	
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
					$('#txtemail').val("");
					}
					else{
					$('#email_stat').html('');	
                    $('#txtemail').html("");
					}
                }
            }); 
        }
    });
var gender = '<?php echo $r->Gender;?>';	
$('#created_by').autocomplete({
	source: function( request, response ) {
  		$.ajax({
			url: baseurl+'search/autocomplete',
  			dataType: "json",
			method: 'post',
			data: {
			   name_startsWith: request.term,gender: gender,
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

		/*$('#shortlist_users').append($('<option/>', { 
			value: names[1],
			text : names[0] 
		}));*/

		$("#pid").val(names[1]);
		$("#pname").val(names[0]);
		
		$('#created_by').val('');
		$('#home_court').focus();


		//	$('#phone_code_1').val(names[2]);
		//	$('#country_code_1').val(names[3]);
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
		//$('#created_users_id').val(names[1]);

		var user_id		= $('#pid').val();
		var user_name	= $('#pname').val();

		$('#shortlist_users').append($('<option/>', { 
			value: user_id+'_'+names[1],
			text : user_name+" ("+names[0]+")" 
		}));
		
		$('#home_court').val('');
		$('#home_court').focus();
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

$('.format').click(function(){
	var ft = $(this).attr('id');

	$('#'+ft+'_levels_div').find('input[type=checkbox]:checked').removeAttr('checked');
	$('#'+ft+'_levels_div').toggle();	
});

});
</script>

<section id="single_player" class="container secondary-page">

<div class="col-md-12 league-form-bg" style="margin-top:30px; margin-bottom:20px">
<div class="fromtitle">Register Players - <?php echo $r->tournament_title; ?></div>

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
<form class="form-horizontal" id='myform' method='post' role="form" action="<?php echo $profile_base; ?>play/reg_players/<?php echo $r->tournament_ID ;?>">
 
<div class='col-md-8'>

<input type="hidden" id='pid' name="pid" value="" />
<input type="hidden" id='pname' name="pname" value="" />

<input type="hidden" name="id" value="<?php echo $r->tournament_ID ;?>"/>

<p><label>Tournament:</label> <?php echo $r->tournament_title; ?></p>
<p><label>Period:</label> <?php echo date('m/d/Y',strtotime(substr($r->StartDate,0,10))); ?> - <?php echo date('m/d/Y',strtotime(substr($r->EndDate,0,10))); ?></p>

<p><label>Sport:</label> <?php 
$get_sport = play::get_sport($r->SportsType);
echo $get_sport['Sportname'];
?></p>
<p><label>Gender:</label> <?php 
if($r->Gender == "all"){ echo "Open to all";} else if($r->Gender == "1"){ echo "Male";}else if($r->Gender == "0"){echo "Female";}else {echo "Not provided";}
?></p>
<p>
<?php
//echo $ag_grp;
$json_array = array();
$event_format = array();
if($r->Singleordouble!="" and $r->tournament_format != 'Teams')
{

$json_array = json_decode($r->Singleordouble);
$numItems = count($json_array);

$i = 0;
	if($numItems > 0)
	{

	    if($r->Multi_Events != NULL){
           $event_format = json_decode($r->Multi_Events);
        }else
        {
			$formats   = json_decode($r->Singleordouble);
		    $age_group = json_decode($r->Age);
		    $levels    = json_decode($r->Sport_levels);

		     $tourn_gender_check = array();

			if($r->Gender=='all' || $r->Gender=='All'){
			   $tourn_gender_check[0]=1;
			   $tourn_gender_check[1]=0;
			}elseif ($r->Gender=='1') {
			   $tourn_gender_check[0]=1;
			}elseif ($r->Gender=='0') {
			   $tourn_gender_check[0]=0;
			}

			foreach ($tourn_gender_check as $key => $gender) {
			    if($gender == 1){
			        $gender_key = 1;
			    }else{
			        $gender_key = 0;
			    }  
			    $show_mixed = 1;

			    foreach($formats as $fr){
			        if($fr == 'Mixed' and $gender_key == 1){ $show_mixed = 0; }
			        foreach($age_group as $ag){
			            foreach($levels as $key=>$lv){
			           
						    if($fr != 'Mixed' or  $show_mixed == 1)
						    { 
						        if($fr == 'Mixed'){ $gender_key = 2; } 

						                  if($gender_key == 1){
						                      $genderkey = 1;
						                  }else if($gender_key == 0){
						                      $genderkey = 0;
						                  }else if($gender_key == 2){
						                      $genderkey = 2;
						                  }       

						        $val = $ag."-".$genderkey."-".$fr."-".$lv;
						        $event_format[] = $val;

						    }
			            }
			        }
			    }
			}
	        
        } 

        echo "<label>";
		echo "<b>* Select Format</b>";
		echo "</label>";
		echo "<div class='col-md-12 form-group internal text1'>";
		echo "<table style='padding:1px;'>";
		$eventformats = play::regenerate_events($event_format);
		foreach($eventformats as $key => $event)
		{
			$event_time = '';
			if($r->Multi_Event_Time != NULL){
		   		$Multi_Event_Time = json_decode($r->Multi_Event_Time,true);
		   
		            if($Multi_Event_Time[$key] != ""){
	                   $event_time = ' ('.$Multi_Event_Time[$key].')';
			        }  
		   	}
		    echo "<tr><td><input type='checkbox' class='event_format' name='events[]' value='".$key."'/> ".$event.' '.$event_time."</td></tr>";
		}
		echo "</table>";

		echo "</div>";
		echo "<input type='hidden' id='mtype_stat' name='mtype_stat' value='1' />";
?>
<?php
	}
	else{
		echo "<input type='hidden' id='mtype_stat' name='mtype_stat' value='0' />";
	}
}
?>
</p>

<!-- Register a new Player by tournament admin -->

<p><b>Note:</b> Click <b>
	<input type="button" id="rp" value="Register Player" class="reg_player league-form-submit1"></b> if you want to add a new player to our site.

	<div class='form-group' id="rpform" style="display:none">
				
		<div class='form-group'>
			<label class='control-label col-md-4' for='id_accomodation'>First Name </label>
			<div class='col-md-5 form-group internal'>
			<input type="text" id="txtfname" name="txt_fname" class='form-control' />
			</div>
		</div>

		<div class='form-group'>
			<label class='control-label col-md-4' for='id_accomodation'>Last Name </label>
			<div class='col-md-5 form-group internal'>
			<input type="text" id="txtlname" name="txt_lname" class='form-control' />
			</div>
		</div>

		<div class='form-group'>
			<label class='control-label col-md-4' for='id_accomodation'>Gender </label>
			<div class='col-md-5 form-group internal'>
			<input type="radio" name="gender" value="1" checked/>Male
			<input type="radio" name="gender" value="0" />Female
			</div>
		</div>

		<div class='form-group'>
			<label class='control-label col-md-4' for='id_accomodation'>Email </label>
			<div class='col-md-5 form-group internal'>
			<input type="text" id="txtemail" name="txt_email" class='form-control txt_email' />
			<span id='email_stat' style='color:red'></span>
			</div>
		</div>

		<div class='form-group'>
			<label class='control-label col-md-4' for='id_accomodation'>Phone </label>
			<div class='col-md-5 form-group internal'>
			<input type="text" id="txtphone" name="txt_phone" class='form-control' />
			</div>
		</div>

		<div class='form-group'>
			<label class='control-label col-md-4' for='id_accomodation'>Zip/Postal Code </label>
			<div class='col-md-5 form-group internal'>
			<input type="text" id="zipcode" name="Zipcode" class='form-control' />
			</div>
		</div>

		<div class='form-group'>
			<label class='control-label col-md-4' for='id_accomodation'></label>
			<div class='col-md-8 form-group internal'>
			<input type="hidden" value="<?php echo $r->tournament_ID ;?>" name="tournament_id" id="tournament_id" />
			<input type="button" id="btn_register" name="btn_register" value=" Register " class="btn_register league-form-submit1" />
			<input type="button" id="cancel" name="btn_register_cancel" value=" Cancel " class="league-form-submit1 btn_register_cancel" />
			</div>
		</div>
		
	</div>
	</p>

<!-- Register a new Player by tournament admin -->

<!--  -->


<!-- <p><label>Location</label> <?php echo $r->venue. ','. $r->TournamentAddress. ',' .$r->TournamentCity. ', ' .$r->TournamentState; ?></p> -->

<script>
$(document).ready(function(){

$('#myform').submit(function() {

    var anyBoxesChecked = false;

    $('.event_format').each(function() {
        if($(this).prop("checked") == true){
           anyBoxesChecked = true;
        }
    });

    if (anyBoxesChecked == false) {
        alert('Choose atleast one Event to Register!');
        return false;
    }else{
  	    return true;
    }

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
	<!-- <img class="img-djoko" src="<?php echo base_url(); ?>tour_pictures/<?php if($r->TournamentImage!=""){echo $r->TournamentImage; } else { echo "default_image.png";}?>" alt="" />
	 -->
	<img class="scale_image" src="<?php echo base_url(); ?>tour_pictures/<?php if($r->TournamentImage!=""){ echo $r->TournamentImage; }
	else if($r->SportsType == 1){echo "default_tennis.jpg"; }
	else if($r->SportsType == 2){echo "default_table_tennis.jpg"; }
	else if($r->SportsType == 3){echo "default_badminton.jpg"; }
	else if($r->SportsType == 4){echo "default_golf.jpg"; }
	else if($r->SportsType == 5){echo "default_racquet_ball.jpg"; }
	else if($r->SportsType == 6){echo "default_squash.jpg"; }
	else if($r->SportsType == 7){echo "default_pickleball.jpg";}
	else if($r->SportsType == 8){echo "default_chess.jpg";}
	else if($r->SportsType == 9){echo "default_carroms.jpg";}
	else if($r->SportsType == 10){echo "default_volleyball.jpg";}
	else if($r->SportsType == 11){echo "default_fencing.jpg";}
	else if($r->SportsType == 12){echo "default_bowling.jpg";}
	?>" alt="" width="250px" height="224px" />
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

});
</script>

<div class='col-md-9'>
	<p><label>Search Player & Add:</label>
	<input class='ui-autocomplete-input form-control inwidth' id='created_by' name='created_by' type='text' placeholder="Player Name" value="" /></p>
	<input class='ui-autocomplete-input form-control inwidth' id='home_court' name='home_court' type='text' placeholder="Home Court Location" value="" /></p>
	

	<div class='col-md-8 form-group internal'><b>Note:</b> Click <b>
	<input type="button" id="add_location" value="Add New" class="league-form-submit1"></b> if your location didn't auto populate.

	<div class='form-group' id="location_form" style="display:none">
		<!-- <form name='loc_form' id='loc_form' method="post" action='<?php echo base_url();?>events/location_add'> -->			
		<div class='form-group'>
			<label class='control-label col-md-4' for='id_accomodation'>Location Title </label>
			<div class='col-md-5 form-group internal'>
			<input type="text" id="loc_title" name="loc_title" class='form-control' />
			</div>
		</div>

		<div class='form-group'>
			<label class='control-label col-md-4' for='id_accomodation'>Address </label>
			<div class='col-md-5 form-group internal'>
			<input type="text" id="loc_add" name="loc_add" class='form-control' />
			</div>
		</div>

		<div class='form-group'>
			<label class='control-label col-md-4' for='id_accomodation'>City </label>
			<div class='col-md-5 form-group internal'>
			<input type="text" id="loc_city" name="loc_city" class='form-control' />
			</div>
		</div>

		<div class='form-group'>
			<label class='control-label col-md-4' for='id_accomodation'>State </label>
			<div class='col-md-5 form-group internal'>
			<input type="text" id="loc_state" name="loc_state" class='form-control' />
			</div>
		</div>

		<div class='form-group'>
			<label class='control-label col-md-4' for='id_accomodation'>Country </label>
			<div class='col-md-5 form-group internal'>
			<input type="text" id="loc_country" name="loc_country" class='form-control' />
			</div>
		</div>

		<div class='form-group'>
			<label class='control-label col-md-4' for='id_accomodation'>Zip Code </label>
			<div class='col-md-5 form-group internal'>
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

	
	<div id="doubles_div" class='reg_players'>
	<select id='shortlist_users' name="sel_player[]" multiple style="height:200pt;" class="inwidth" required>
	<option value='' disabled>Selected Players</option>
	</select>

	<br>Select
	<a  onclick="listbox_selectall('shortlist_users', true)" style='cursor:pointer'>All</a>,
	<a  onclick="listbox_selectall('shortlist_users', false)" style='cursor:pointer'>None</a>
	</div>
	<br>
 <p><label>Payment Method:</label>
  <input name="payment_method" type="radio" value="Free Entry" class="league-form-submit1" checked/> Free Entry
  <input name="payment_method" type="radio" value="Cash" class="league-form-submit1"/>By Cash
  <input name="payment_method" type="radio" value="Check" class="league-form-submit1"/> Check
  <input name="payment_method" type="radio" value="Paypal Direct" class="league-form-submit1"/> Paypal Direct
  <input name="payment_method" type="radio" value="Cash App" class="league-form-submit1"/> Cash App
</p>

<br>
<p id="paid_amount_p" style="display:none">
<label>Paid Amount:</label>
<input type="text"  name="paid_amount" id="paid_amount" class="form-control inwidth" placeholder="Enter Amount" value="0.00" required>
</p>
</div>

<div class='col-md-9 form-group internal reg_players' style="margin-top:10px">
<input name="bulk_register" type="submit" value="Register" class="league-form-submit1"/>
</div>

</form>
</div>
<?php
	}
} ?>
</div>


<!-- end main body -->
</div>
</div><!--Close Top Match-->
</section>