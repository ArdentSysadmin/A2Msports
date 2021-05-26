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


var sport = '<?php echo $r->SportsType;?>';	
$('#created_by').autocomplete({

	source: function( request, response ) {
  		$.ajax({
			url: baseurl+'search/autocomplete_team',
  			dataType: "json",
			method: 'post',
			data: {
			   name_startsWith: request.term,sport: sport,
			   type: 'teams',
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

		$('#shortlist_teams').append($('<option/>', { 
			value: names[1],
			text : names[0] 
		}));
		
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

});
</script>

<section id="single_player" class="container secondary-page">

<div class="col-md-12 league-form-bg" style="margin-top:30px; margin-bottom:20px">
<div class="fromtitle">Register Team - <?php echo $r->tournament_title; ?></div>

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
<form class="form-horizontal" id='myform' method='post' role="form" action="<?php echo base_url(); ?>league/reg_teams/<?php echo $r->tournament_ID ;?>">
 
<div class='col-md-8'>
	
<input type="hidden" name="id" value="<?php echo $r->tournament_ID ;?>"/> 
<p><label>Tournament:</label> <?php echo $r->tournament_title; ?></p>
<p><label>Period:</label> <?php echo date('m/d/Y',strtotime(substr($r->StartDate,0,10))); ?> - <?php echo date('m/d/Y',strtotime(substr($r->EndDate,0,10))); ?></p>

<p><label>Sport:</label> <?php 
$get_sport = league::get_sport($r->SportsType);
echo $get_sport['Sportname'];
?></p>
<p><label>Gender:</label> <?php 
if($r->Gender == "all"){ echo "Open to all";} else if($r->Gender == "1"){ echo "Male";}else if($r->Gender == "0"){echo "Female";}else {echo "Open";}
?></p>

<?php 
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
$json_array		= array();
$event_format	= array();
?>
<p>
<label>Location</label>
<?php
if($r->venue) echo $r->venue;
	if($r->TournamentAddress) echo ", ";

if($r->TournamentAddress) echo $r->TournamentAddress;
	if($r->TournamentAddress and $r->TournamentCity) echo ",";

if($r->TournamentCity) echo $r->TournamentCity;
	if($r->TournamentCity and $r->TournamentState) echo ",";

if($r->TournamentState) echo $r->TournamentState;
?></p>
<p>
<label>Levels</label>
<?php 
$level_array = array();

if($r->Sport_levels!=""){
$level_array = json_decode($r->Sport_levels);
	$lvl_checked = '';
	if(count($level_array) == 1){
	$lvl_checked = 'checked';
	}
 foreach($level_array as $row){ ?>
 <input type="radio"  name="level" value="<?php echo $row ;?>" <?=$lvl_checked;?> required /> 
<?php $get_level = league::get_level_name($r->SportsType,$row);
 echo $get_level['SportsLevel']."&nbsp;";
 }
}
?>

<p>
<label>Age Group</label>
<?php
$ag_checked = '';
if(count($level_array) == 1){
$ag_checked = 'checked';
}



foreach($option_array as $group){
	$agegrp_label = $this->config->item($group, 'age_values');
	echo "<input type='radio' class='team_ag' name='age_group' value='$group' $ag_checked required /> $agegrp_label <br />";
}
?>


<script>
$(document).ready(function(){

/*$('#myform').submit(function() {

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

});*/

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

 <p><label>Search Team & Add:</label> <input class='ui-autocomplete-input form-control inwidth' id='created_by' name='created_by' type='text' placeholder="Team Name" value="" /></p>

<div id="doubles_div">
<select id='shortlist_teams' name="sel_teams[]" multiple style="height:200pt;" class="inwidth" required />
<option value='' disabled>Selected Teams</option>
</select>
<br />
Select
<a  onclick="listbox_selectall('shortlist_teams', true)" style='cursor:pointer'>All</a>,
<a  onclick="listbox_selectall('shortlist_teams', false)" style='cursor:pointer'>None</a>
</div>
<br />

<p>
<label>Payment Method:</label>
<select name="payment_method" class="form-control inwidth" id="payment_method">
<option value="Free Entry" selected>Free Entry</option>
<option value="Cash">By Cash</option>
<option value="Check">Check</option>
<option value="Paypal Direct">Paypal Direct</option>
<option value="Cash App">Cash App</option>
</select>
</p>

<br>
<p id="paid_amount_p" style="display:none">
<label>Paid Amount:</label>
<input type="text"  name="paid_amount" id="paid_amount"  placeholder="Enter Amount" value="0.00" class="form-control inwidth" required>
</p>
<div class='col-md-7 form-group internal' style="margin-top:10px">
<input name="bulk_register" type="submit" value="Register" class="league-form-submit1"/>
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
</section>