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
		
		$('#created_by').val();
		$('#created_by').focus();


		//	$('#phone_code_1').val(names[2]);
		//	$('#country_code_1').val(names[3]);
	}		      	
});

  $('input[type=text]').focus(function() {
       $(this).val('');
    });
});
</script>

<section id="single_player" class="container secondary-page">

<div class="col-md-12 league-form-bg" style="margin-top:30px; margin-bottom:20px"">
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
<form class="form-horizontal" id='myform' method='post' role="form" action="<?php echo base_url().$this->short_code; ?>/play/reg_players/<?php echo $r->tournament_ID ;?>">
 
<div class='col-md-8'>
	
<input type="hidden" name="id" value="<?php echo $r->tournament_ID ;?>"/> 
<p><label>Tournament:</label> <?php echo $r->tournament_title; ?></p>
<p><label>Period:</label> <?php echo date('m/d/Y',strtotime(substr($r->StartDate,0,10))); ?> - <?php echo date('m/d/Y',strtotime(substr($r->EndDate,0,10))); ?></p>

<p><label>Sport:</label> <?php 
$get_sport = play::get_sport($r->SportsType);
echo $get_sport['Sportname'];
?></p>

<p><label>Levels:</label> 
<?php 
$level_array = array();
if($r->Sport_levels!="")
{
$level_array = json_decode($r->Sport_levels);

 foreach($level_array as $row){ ?>

<input type="radio"  name="level"  value="<?php echo $row ;?>" required /> 
<?php $get_level = play::get_level_name($r->SportsType,$row);
echo $get_level['SportsLevel'];
?> &nbsp;
		
<?php 
 } 
}
else
{
?>
<input type="hidden"  name="level"  value="" /> 
<?php
}
?>
</p>

<p><label>Age Group *</label> 

<?php 
$option_array = array();
if($r->Age!="")
{
$option_array = json_decode($r->Age);

$numItems = count($option_array);
$i = 0;
	if($numItems > 0)
	{
	
		foreach($option_array as $group){

			switch ($group){
			case "U12":
			echo "<input type='radio'  name='age_group' value=".$group." required /> Under 12 &nbsp";
			break;
			case "U14":
			echo "<input type='radio'  name='age_group' value=".$group." required /> Under 14 &nbsp";
			break;
			case "U16":
			echo "<input type='radio'  name='age_group' value=".$group." required /> Under 16 &nbsp";
			break;
			case "U18":
			echo "<input type='radio'  name='age_group' value=".$group." required /> Under 18 &nbsp";
			break;
			case "Adults":
			echo "<input type='radio'  name='age_group' value=".$group." required /> Adults &nbsp";
			break;
			case "Adults_30p":
			echo "<input type='radio'  name='age_group' value=".$group." required /> 30s &nbsp";
			break;
			case "Adults_40p":
			echo "<input type='radio'  name='age_group' value=".$group." required /> 40s &nbsp";
			break;
			case "Adults_50p":
			echo "<input type='radio'  name='age_group' value=".$group." required /> 50s &nbsp";
			break;
			case "Adults_veteran":
			echo "<input type='radio'  name='age_group' value=".$group." required /> Veteran &nbsp";
			break;
			default:
			echo "";
			}
		}

	}

}
else
{
?>
<input type='radio' name='age_group' value="" />
<?php
}
?>
</p>

<p><label>Play Format *</label> <?php 
$json_array = array();
if($r->Singleordouble!="")
{
$json_array = json_decode($r->Singleordouble);
$numItems = count($json_array);

$i = 0;
	if($numItems > 0)
	{
		foreach($json_array as $type)
		{
		echo "<input type='checkbox' id='$type' class='amount' name='mtype[]' value=".$type." /> ". $type ." &nbsp";
		}
	}
}
?></p>

<p><label>Location</label> <?php echo $r->venue. ','. $r->TournamentAddress. ',' .$r->TournamentCity. ', ' .$r->TournamentState; ?></p>



<script>
$(document).ready(function(){
    $('#myform').submit(function() {

var sg =  $('#Singles:checkbox:checked').length > 0;
var db =  $('#Doubles:checkbox:checked').length > 0;
var mx =  $('#Mixed:checkbox:checked').length > 0;

var count = (db+mx+sg);

//alert(count);

		if(count < 1){
			alert("Select atleast one play format");
			return false;
		}
       /* else if (!($('#recommend').is(':checked'))) {
            alert("Please accept the Terms & Conditions");
			return false;
        }*/
	    else { return true; }
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

<div id="doubles_div">


<select id='shortlist_users' name="sel_player[]" multiple style="height:200pt;" class="inwidth" required>
<option value='' disabled>Selected Players</option>
</select>

							<br>Select
							<a  onclick="listbox_selectall('shortlist_users', true)" style='cursor:pointer'>All</a>,
							<a  onclick="listbox_selectall('shortlist_users', false)" style='cursor:pointer'>None</a>

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