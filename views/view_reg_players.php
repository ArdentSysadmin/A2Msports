<?php
$club_url = $this->config->item('club_form_url');

if($club_url == "https://a2msports.com/play")
	$profile_base = base_url();
else
	$profile_base = $club_url."/";
?>
<script type="text/javascript">
$('#Singles_levels_div').find('input[type=checkbox]:checked').removeAttr('checked');
$('#Doubles_levels_div').find('input[type=checkbox]:checked').removeAttr('checked');
$('#Mixed_levels_div').find('input[type=checkbox]:checked').removeAttr('checked');

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
	$('#payment_method').change(function() {
           var payment_method = $(this).find(":selected").val();
          // var payment_method = $(this).val();
           if(payment_method != 'Free Entry'){
            $("#paid_amount_p").show();
            $("#paid_amount").val('');
           }else{
           	$("#paid_amount").val('0.00');
           	$("#paid_amount_p").hide();
           }
           
        
    });

var baseurl = "<?php echo base_url();?>";

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


$('.btn_register').click(function(){


var baseurl       = "<?php echo base_url();?>";
var tournament_id = $("#tournament_id").val();
var sportstype    = $("#rpform #sportstype").val();
var lname	      = $("#rpform #txtlname").val();
var email	      = $("#rpform #txtemail").val();
var gender        = $("#rpform input[name='gender']:checked").val();
var zipcode       = $("#rpform #zipcode").val();
//alert(tournament_id);die();
var phone	= $("#rpform #txtphone").val();

//if(lname != "" && email != "" && zipcode != ""){
if(lname != "" && phone != "" && zipcode != ""){

var fname	= $("#rpform #txtfname").val();

		$('#btn_register').prop("disabled", true);
		$('#btn_register').attr('value', 'Please wait...');
$.ajax({
		type:'POST',
		url:baseurl+'register/instant_register/',
		data:{fname:fname, lname:lname, email:email, phone:phone, gender:gender, Zipcode:zipcode,tourn_id:tournament_id, sportstype:sportstype},
		success:function(res){
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
  alert("Last Name, Phone & Zipcode should not be empty!");
}

});

$('.txt_email').blur(function(){
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
var sp_type = "<?php echo $r->SportsType;?>";

$('#created_by').autocomplete({

	source: function( request, response ) {
  		$.ajax({
			url: baseurl+'search/autocomplete',
  			dataType: "json",
			method: 'post',
			data: {
			   name_startsWith: request.term,gender: gender,sp_type: sp_type,
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
		//alert(ui.item.data);
		var names = ui.item.data.split("|");						
		//$('#created_users_id').val(names[1]);

		/*$('#shortlist_users').append($('<option/>', { 
			value: names[1],
			text : names[0] 
		}));*/
		var chk_box = '<input type="checkbox" name="sel_player[]" id="sel_player_'+names[1]+'" value="'+names[1]+'" />';
		$('#reg_users_table tr:last').after('<tr><td>'+chk_box+'</td><td>'+names[0]+'</td><td>'+names[2]+'</td><td>'+names[3]+'</td><td>'+names[4]+'</td></tr>');
		
		$('#created_by').val('');
		$('#created_by').focus();


		//	$('#phone_code_1').val(names[2]);
		//	$('#country_code_1').val(names[3]);
	}	      	
});


$('.format').click(function(){
	var ft = $(this).attr('id');

	$('#'+ft+'_levels_div').find('input[type=checkbox]:checked').removeAttr('checked');
	$('#'+ft+'_levels_div').toggle();	
});

$('.get_occr').click(function(){
	/*if($(this).prop("checked") == true){
	$(".tr_"+$(this).val()).show();
	}
	else{
	$(".tr_"+$(this).val()).hide();
	$(".tr_"+$(this).val()+' .get_occr_fee').removeAttr('checked');
	}*/
});

  $('.get_occr_fee').change(function() {

    if($(this).is(':checked')) {
      var currentRow = $(this).closest('tr');
      var targetedRow = currentRow.prevAll('.parent').first();
      var targetedCheckbox = targetedRow.find(':checkbox');
      targetedCheckbox.prop('checked', false).trigger('click');
    }
	else {
      var currentRow		= $(this).closest('tr');
      var targetedRow		= currentRow.prevAll('.parent').first();
      var targetedCheckbox = targetedRow.find(':checkbox');
	      if(!$('.get_occr_fee:checked').length)
		  targetedCheckbox.prop('checked', true).trigger('click');
	}

  });

});
</script>

<section id="single_player" class=" secondary-page">
<div class='container'>
<div class='row'>
<div class="col-md-12 league-form-bg" style="margin-top:30px; margin-bottom:20px">
<div class="fromtitle" style="font-size: 16px;"><b>Register Players - <a href="<?=$profile_base; ?>league/<?php echo $r->tournament_ID ;?>"><span><?php echo $r->tournament_title; ?></span></a></b></div>

<?php if($this->session->userdata('user')=="") { ?>
<p style="line-height:5px; font-size:13px">Please <a href='<?php echo base_url()."login"; ?>'><b>Login</b> </a>to register for a tournament</p>
<?php  } ?>
<?php
if($this->session->userdata('user')!="") {

if(isset($reg_status)) {
?>
   <div class="name" align='left'>
	 <label for="name_login" style="color:green"><?php echo $reg_status; ?></label>
   </div>
<?php
}
else {
?>
<!-- <form class="form-horizontal" id='myform' method='post' role="form"  action="<?php echo base_url(); ?>league/register_trnmt"> -->
<form class="form-horizontal" id='myform' method='post' role="form" action="<?php echo $profile_base; ?>play/reg_players/<?php echo $r->tournament_ID ;?>">
 
<div class='col-md-8'>
	
<input type="hidden" name="id" value="<?php echo $r->tournament_ID ;?>"/> 
<p><label>Tournament:</label> <?php echo $r->tournament_title; ?></p>
<p><label>Period:</label> <?php echo date('m/d/Y',strtotime(substr($r->StartDate,0,10))); ?> - <?php echo date('m/d/Y',strtotime(substr($r->EndDate,0,10))); ?></p>
<?php 
$current_class = $this->router->class;

if($r->Is_League != 1){ ?>
<p><label>Sport:</label> <?php 

$get_sport = $current_class::get_sport($r->SportsType);
echo $get_sport['Sportname'];
?></p>
<p><label>Gender:</label> <?php 
if($r->Gender == "all"){ echo "Open to all";} else if($r->Gender == "1"){ echo "Male";}else if($r->Gender == "0"){echo "Female";}else {echo "Not provided";}
?></p>

<?php 
}
$option_array = array();
if($r->Age!="")
{
$option_array = json_decode($r->Age);
$age_grp_list = array();
$numItems = count($option_array);
$i = 0;
	if($numItems > 0)
	{
		foreach($option_array as $group){
			switch ($group){
			case "U12":
			$age_grp_list[] = "Under 12";
			break;
			case "U14":
			$age_grp_list[] = "Under 14";
			break;
			case "U16":
			$age_grp_list[] = "Under 16";
			break;
			case "U18":
			$age_grp_list[] = "Under 18";
			break;
			case "Adults":
			$age_grp_list[] = "Adults";
			break;
			case "Adults_30p":
			$age_grp_list[] = "30s";
			break;
			case "Adults_40p":
			$age_grp_list[] = "40s";
			break;
			case "Adults_50p":
			$age_grp_list[] = "50s";
			break;
			case "Adults_veteran":
			$age_grp_list[] = "Veteran";
			break;
			default:
			$age_grp_list[] = "";
			}
		}
	}

}
?>

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
}
else
{
	$formats   = json_decode($r->Singleordouble);
    $age_group = json_decode($r->Age);
    $levels    = json_decode($r->Sport_levels);

     $tourn_gender_check = array();

	if($r->Gender=='all' || $r->Gender=='All'){
	   $tourn_gender_check[0] = 1;
	   $tourn_gender_check[1] = 0;
	}
	elseif ($r->Gender=='1'){
	   $tourn_gender_check[0] = 1;
	}
	elseif ($r->Gender=='0'){
	   $tourn_gender_check[0] = 0;
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

	
//echo "<pre>";
//print_r($event_format);

        echo "<label>";
		echo "<b>* Select Event</b>";
		echo "</label>";
		echo "<div class='col-md-12 form-group internal text1'>";
		echo "<table style='padding:1px;'>";
		$eventformats = $current_class::regenerate_events($event_format);
		//echo "<pre>"; print_r($lg_occr);exit;
		foreach($eventformats as $key => $event)
		{
			$event_time = '';
			if($r->Multi_Event_Time != NULL){
		   		$Multi_Event_Time = json_decode($r->Multi_Event_Time,true);
			        if($Multi_Event_Time[$key] != ""){
	                   $event_time = ' ('.$Multi_Event_Time[$key].')';
			        }
		        
		   	}
		    echo "<tr class='parent'><td><input type='checkbox' class='event_format get_occr' name='events[]' value='".$key."' /> <label>".$event.' '.$event_time."</label></td></tr>";

		    //echo "<tr class='parent'><td><input type='checkbox' class='event_format get_occr' name='events[]' value='".$key."' /> ".$event.' '.$event_time."&nbsp;&nbsp;<input type='checkbox' class='get_occr_fee  lg_events' name='whole_lg_events[]' value='".$key."' autocomplete='off' />&nbsp;Select All Game Days"."</td></tr>";

			 foreach($lg_occr[$key] as $occr){
				echo "<tr class='tr_".$key."' style='display:block;'><td>&nbsp;&nbsp;&nbsp;&nbsp;<input type='checkbox' class='get_occr_fee' id='occr_".$occr[0]."' name='occr_ids[]' value='".$occr[0].":".$key."' autocomplete='off' />&nbsp;"."<label for='occr_".$occr[0]."'>".date("M d, Y H:i", strtotime($occr[1]))."</label>"."</td></tr>";
			}
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
<p>
<label>Location</label>
<?php echo $r->venue. ','. $r->TournamentAddress. ',' .$r->TournamentCity. ', ' .$r->TournamentState; ?></p>

<!-- Register a new Player by tournament admin -->

<p><b>Note:</b> Click <b>
	<input type="button" id="rp" value="Register Player" class="reg_player league-form-submit1"></b> If you want to add a new player to our site.

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
			<input type="radio" name="gender" value="1" checked/>&nbsp;Male
			<input type="radio" name="gender" value="0" />&nbsp;Female
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
			<input type="hidden" value="<?php echo $r->SportsType ;?>" name="sportstype" id="sportstype" />
			<input type="button" id="btn_register" name="btn_register" value=" Register " class="btn_register league-form-submit1" />
			<input type="button" id="cancel" name="btn_register_cancel" value=" Cancel " class="league-form-submit1 btn_register_cancel" />
			</div>
		</div>

	</div>
	</p>

<!-- Register a new Player by tournament admin -->

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
        alert('Choose an Event to Register!');
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
<!-- <div class='form-group text1'>

<label class='control-label col-md-3 padtop text1' for='id_accomodation'> <input type="checkbox" name="recommend" id="recommend" value="1" /></label>
  I accept the Tournament <a href='#' target='_blank'>Terms & Conditions</a> of A2MSports.

</div>
 -->
 <p><label>Search Player & Add:</label> <input class='ui-autocomplete-input form-control inwidth' id='created_by' name='created_by' type='text' placeholder="Player Name" value="" /></p>


<!-- <div id="doubles_div">


<select id='shortlist_users' name="sel_player[]" multiple style="height:200pt;" class="inwidth" required>
<option value='' disabled>Selected Players</option>
</select>

<br>Select
<a  onclick="listbox_selectall('shortlist_users', true)" style='cursor:pointer'>All</a>,
<a  onclick="listbox_selectall('shortlist_users', false)" style='cursor:pointer'>None</a>

</div> -->

<div class="col-md-8">
<!-- Table view Players section -->

<table id="reg_users_table" class="table tab-score">
<thead>
<tr class="top-scrore-table">
	<th>Select</th>
	<th>&nbsp;Player/Team</th>
	<th>&nbsp;City</th>
	<th>&nbsp;State</th>
	<th>&nbsp;A2MScore</th>
</tr>
</thead>
<tbody>

</tbody>
</table>
<!-- End of Table view Players section  -->
</div>


<!-- <div class='col-md-8'>
		<div id="load-users" style="overflow-y:scroll">
       <table class="tab-score">
        <tr>
        <th class="score-position"><input type='checkbox' name="sel_all" id="sel_all" /></th>
        <th>Name</th>
      <th width="30%">Match Format</th>
        <th width="15%">Age Group</th> 
        </tr>

        <?php
      /*  if(count(array_filter($optimum_users)) > 0) {
         foreach($optimum_users as $name)
         {*/
         ?>
        <tr>
        <td><input class="checkbox1" type="checkbox" name="sel_player[]" value="<?php //echo $name->Users_ID;?>"  style="margin-left:10px" /></td>

        <td><?php
      /*   $player = play::get_user($name->Users_ID);
         if(isset($player)){ echo "<b>" . $player['Firstname']." ".$player['Lastname'] . "</b>";}
        */ ?>
        </td>

        </tr>
        <?php /*}  
		} else {*/
        ?>
        <tr><td colspan='6'><b>No Users Found. </b></td></tr>
        <?php
      //  }
        ?>
        </table>
       </div>
</div>
 -->

 <div class='col-md-8'>
 <label>Payment Method:</label>
 <select name="payment_method" class="form-control inwidth" id="payment_method">
 <option value="Free Entry" selected>Free Entry</option>
  <option value="Cash">By Cash</option>
   <option value="Check">Check</option>
    <option value="Paypal Direct">Paypal Direct</option>
     <option value="Cash App">Cash App</option>
 </select>
 </div>

<div class='col-md-8' id="paid_amount_p" style="display:none">
<label>Paid Amount:</label>
<input type="text"  name="paid_amount" id="paid_amount"  placeholder="Enter Amount" value="0.00" class="form-control inwidth" required>
</div>

<div class='col-md-7 form-group internal' style="margin-top:10px">
<input id="reg_players" name="bulk_register" type="submit" value="Register" class="league-form-submit1"/>
</div>


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
</form>
</div>
<?php
	}
} ?>
</div>


<!-- end main body -->
</div>
</div><!--Close Top Match-->


</div>
</div>
</section>