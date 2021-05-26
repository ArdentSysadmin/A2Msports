<link href="<?php echo base_url();?>css/foundation-datepicker.css" rel="stylesheet">
<script src="<?php echo base_url();?>js/foundation-datepicker.js"></script>
<script> 
$(document).ready(function(){
	$('#reg_users_table').DataTable({
			searching : false, 
			paging	  : false, 
			lengthMenu: false,
			/*sDom	  : '<"clear">t<"H"p><"F"p>'*/
	});
});
/*$(document).on("click", '.mylink', function(event) { 
    alert("new link clicked!");
});*/


$(document).on("click", ".up, .down", function(){
	var row = $(this).parents("tr:first");
	if ($(this).is(".up")) {
		row.insertBefore(row.prev());
	}
	else {
		row.insertAfter(row.next());
	}
});

</script>

<link href="<?php echo base_url();?>css/fSelect.css" rel="stylesheet" />
<link href="https://cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css" rel="stylesheet" type="text/css" />
<!-- <script src="<?php echo base_url();?>js/jquery-1.10.2.js" type="text/javascript"></script> -->
<script src="<?php echo base_url();?>js/fSelect.js" type="text/javascript"></script>
<script type="text/javascript">

// Script Code For Groups Starts Here.
	$(document).ready(function(){
		$("#t_No").prop("checked",true);
		var tourn_type = $('#ttype').val();
		if(tourn_type == 'Round Robin'){
	  		$('#groups').show();
		}
 
  		$("input[name='is_groups']").click(function (){
	 	if($("#t_Yes").is(":checked")) {
  				$('#no_of_groups').show();
 			}
			else{
				$('#no_of_groups').hide();
			}
		});

		$('#myform').on('submit', function (e) {
			var ttype_val = $('#ttype').val();
			//var count	  = $('#a :selected').length;
			var count	  = 0;

			if(ttype_val == "Switch Doubles"){

				$('input[name="users[]"]:checked').each(function(){
					var x = this.value;
					var a = x.split('-');
					if(a[0])
					  count++;
					if(a[1])
					  count++;
				});

				if(count <= 3 || count == 6 || count == 7 || count > 8){
					alert("Switch Doubles doesn't support for "+count+" Players. \n Please choose 4/5/8 Players");
					return false;
					e.preventDefault();
				}
			}

			var isChecked = $('#t_Yes').attr('checked')
			if(isChecked){
				var sel_value = $('#sel_groups').val();
				//var count     = $('#a :selected').length;
				var count     = $('input[name="users[]"]:checked').length;

				var no_of_groups = count/sel_value;

				if(no_of_groups >= 3){
					return true;
				}
				else{
					alert("Insufficient players selected to form into groups. \nMinimum 3 players required per group");
					return false;
					e.preventDefault();
				}
			}
	 	});

		$('#ttype').change(function(){
			ttype_val = $(this).val();
			if(ttype_val != 'Round Robin'){
				$("#t_No").trigger('click');
				$('#groups').hide();
				$('#no_of_groups').hide();
				$('#div_multi_rounds').hide();
 			}
			else{
				$('#groups').show();
				//$('#div_multi_rounds').show();
			}
		});

		var ttype_val = $('#ttype').val();

		if(ttype_val == 'Round Robin'){
				$('#groups').show();
				//$('#div_multi_rounds').show();
		}
 	});
// Script Code For Groups Ends Here.	


$(function () {
$("input[name='chkPassPort']").click(function () {
if ($("#chkYes").is(":checked")) {
$("#dvPassport").show();
} else {
$("#dvPassport").hide();
}
});
});
function GetUsers(format){
  //alert(type);
//var format = $("#format").find('option:selected').val();
var sport = $("#sport").val();
var types = [];
var baseurl  = "<?php echo base_url();?>";
var tour_id  = "<?php echo $tourn_det['tournament_ID'];?>";
var is_event   = $('#is_event').val();
var is_checkin = $('input[type=radio][name=is_checkin]:checked').val();

  $('input:checkbox.macthtype:checked').each(function () {
       var match_type = this.value; 
       types.push(match_type);
  });
 
   $(document).on("click", "#userSelectAll", function () {
	  $(".user_select").prop('checked', $(this).prop('checked'));
   });

   $.ajax({
        type:'POST',
        url:baseurl+'league/getusers/',
        data:{types:types,tour_id:tour_id,format:format,is_event:is_event,is_checkin:is_checkin,sport:sport},
        success:function(html){
          //console.log(html);
            /*$('#a').html(html);
            var selectOptions = $("#a option");
              selectOptions.sort(function(a,b){
                  a = a.id;
                  b = b.id;
                return b-a;
              });
            
            $('#a').html(selectOptions);
			listbox_selectall('a', true);   */

		$('#age_group_users').html(html);
		
		$('#reg_users_table').DataTable({
			searching : false, 
			paging	  : false, 
			lengthMenu: false,
			/*sDom	  : '<"clear">t<"H"p><"F"p>'*/
		});

        }
    });
}
/*$(function($) {
    $(function() {
        $('#match_type').fSelect();
    });
});*/
/* $(function () {

        $('.active.3col').multiselect({
            columns: 1,
            placeholder: 'Select States',
            search: true,
            searchOptions: {
                'default': 'Search States'
            },
            selectAll: true
        });

    });*/
$(document).ready(function(){
    $("#format").change(function(){
      var format=$(this).val();
      $("#"+format).show();
      $(this).find('option').not(':selected').each( function(){
       var unselected = this.value;
       $("#"+unselected).hide();
      });     
    });

	$('#sport_level').change(function(){
		var level_id = $(this).val();
		var tour_id  = "<?php echo $tourn_det['tournament_ID'];?>";
		var baseurl = "<?php echo base_url();?>";
		
		$.ajax({
			type:'POST',
			url:baseurl+'league/get_teams_filter_level/',
			data:{level_id:level_id,tour_id:tour_id},
			success:function(html){
			//console.log(html);
			/*$('#a').html(html);
			var selectOptions = $("#a option");
			selectOptions.sort(function(a,b){
			a = a.id;
			b = b.id;
			return b-a;
			});

			$('#a').html(selectOptions);*/
			$('#age_group_users').html(html);
		
			$('#reg_users_table').DataTable({
				searching : false, 
				paging	  : false, 
				lengthMenu: false,
				/*sDom	  : '<"clear">t<"H"p><"F"p>'*/
			});

			}
		});
	});
});
</script>

<script type="text/javascript"> 

function listbox_move(listID, direction) {

var listbox = document.getElementById(listID);
var selIndex = listbox.selectedIndex;

//document.write(listbox);
//document.write(selIndex);

if(-1 == selIndex) {
alert("Please select an player to move.");
return;
}

var increment = -1;
if(direction == 'up')
increment = -1;
else
increment = 1;

if((selIndex + increment) < 0 ||
(selIndex + increment) > (listbox.options.length-1)) {
return;
}

var selValue = listbox.options[selIndex].value;
var selText = listbox.options[selIndex].text;
listbox.options[selIndex].value = listbox.options[selIndex + increment].value
listbox.options[selIndex].text = listbox.options[selIndex + increment].text

listbox.options[selIndex + increment].value = selValue;
listbox.options[selIndex + increment].text = selText;

listbox.selectedIndex = selIndex + increment;
}

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
/*$(document).ready(function(){
var baseurl = "<?php echo base_url();?>";

$('#Age_group, #match_type').on('change',function(){

//  var Agegroup = $(this).val();
var Agegroup = $('#Age_group').val();
var Match_type = $('#match_type').val();

var Tourn_id = $('#tourn_id').val();

if(Agegroup!="" && Match_type!=""){
var Sport_id = $('#sport').val();
$.ajax({
type:'POST',
url:baseurl+'league/age_group_users/',
data:{age_group:Agegroup, tourn_id:Tourn_id, match_type:Match_type, sport_id:Sport_id},    //{pt:'7',rngstrt:range1, rngfin:range2},
success:function(html){
$('#age_group_users').html(html);
}
}); 
}
});
});*/
</script>

<script>
$(document).ready(function(){
var baseurl = "<?php echo base_url();?>";
var tour_id="<?php echo $tourn_det['tournament_ID'];?>";
$('#match_type').on('change', function() {
   // alert(1);
   //  alert($(".fs-label").text());  
  var types = [];
  $("#match_type option:selected").each(function(){       
        types.push($(this).val());
    });
  
//alert(types);
    $.ajax({
        type:'POST',
        url:baseurl+'league/getusers/',
        data:{types:types,tour_id:tour_id},
        success:function(html){
         // console.log(html);
          //alert(html);
            $('#a').html(html);
        }
    }); 
   // alert(types);
 
});

$(".cl_sel_users, .ajax_blur").click(function(){
$('#part_count').hide();
});

$('#myform').submit(function(){

//var count = $("#a :selected").length;
var count = $(this).find('input[name="users[]"]:checked').length;
//alert(count);return false;
var foo = [];
$('#a :selected').each(function(i, selected){
	//alert($(selected).val());
foo[i] = $(selected).val();
});

var j;
var part_count = 0;
for (j = 0; j < foo.length; ++j) {
var sp = foo[j].split('-');

if(!sp[1]){ part_count++; }  
}

if (count < 2) { 
$('#part_count').show();
$('#part_count').html('Minimum 2 players should be selected');
//alert("Minimum 3 players should be select"); 
return false;
}
/*else if(part_count > 0){
$('#part_count').show();
$('#part_count').html('Some of the selected players having no partners. please recheck!');
//alert("Some of the selected players having no partners. please recheck!"); 
return false;
}*/
else { return true; }
});
});
</script>

<script>
$(document).ready(function(){
//$('.ajax_blur').click(FilterPlayers);
//$('.ajax_blur').change(FilterPlayers);
});
</script>

<script>
var FilterPlayers = function(){
var baseurl = "<?php echo base_url();?>";
var Match_type = $('#match_type').val();  
var Sport = $("#sport").val();

var Age_group = [];
$("input[name='age_group[]']:checked").each(function(i){
Age_group[i] = $(this).val();
});

var Level = [];
$("input[name='level[]']:checked").each(function(i){
Level[i] = $(this).val() ;
});

var Gender = [];
$("input[name='gender[]']:checked").each(function(i){
Gender[i] = $(this).val();
});

var Tourn_id = $('#tourn_id').val();
var TFormat  = $('#tformat').val();

if(Match_type != "" || Match_type == ""){

$.ajax({
type:'POST',
url:baseurl+'league/age_group_users/',
data:{gender:Gender,age_group:Age_group,match_type:Match_type,tourn_id:Tourn_id,sport:Sport,level:Level,tformat:TFormat},
success:function(html){
$('#age_group_users').html(html);
}
}); 
}
}
</script>

<section id="single_player" class="container secondary-page">

<div class="top-score-title right-score col-md-9">
<h3 style="text-align:left">Create Draws (Testing)</h3>

<?php 
if(isset($exist)) { ?>
<div class="name" align='left'>
<label for="name_login" style="color:red"><?php echo $exist; ?></label>
</div>
<?php } ?>

<!-- start main body -->

<?php
if($tourn_det){
?>
<form class="form-horizontal" id='myform' method='post' role="form" action="<?php echo base_url()."league_v2/bracket/".$tourn_det['tournament_ID'];?>"> 

<input type="hidden" id="tourn_id" name="tourn_id" value="<?php echo $tourn_det['tournament_ID'] ;?>" /> 
<input type="hidden" id="is_event" name="is_event" value="<?php echo ($tourn_det['Multi_Events'] != NULL) ? '1' : '0'; ?>" /> 

<div class="col-md-12 league-form-bg" style="margin-top:30px;">
<div class="fromtitle">Bracket / Draws</div>

<div class='form-group'>
<label class='control-label col-md-3' for='id_accomodation' style='padding-top:0px;'>Tournament:</label>
<div class='col-md-6 form-group internal' valign='middle'>
<?php echo $tourn_det['tournament_title'];?>
</div>
</div>

<div class='form-group'>
<label class='control-label col-md-3' for='id_accomodation' style='padding-top:0px;'>Game Type:</label>
<div class='col-md-6 form-group internal'>
<?php $sport_name = league::get_sport($tourn_det['SportsType']);
echo $sport_name['Sportname'];
?>
<input type='hidden' id='sport' name='sport' value='<?php echo $tourn_det['SportsType']; ?>' />
<input type='hidden' id='tour_type' name='tour_type' value='<?php echo $tourn_det['Tournament_type']; ?>' />
<input type='hidden' id='tformat' name='tformat' value='<?php echo $tourn_det['tournament_format']; ?>' />
</div>
</div>
<?php
if($tourn_det['tournament_format'] != 'Teams' and $tourn_det['tournament_format'] != 'TeamSport'){
?>
<div class='form-group'>
<label class='control-label col-md-3' for='id_accomodation' style='padding-top:0px;'>Show only Check-In Players</label>
<div class='col-md-6 form-group internal'>
<input type='radio' id='checkin_yes' name='is_checkin' value='1' /> Yes
<input type='radio' id='checkin_no'  name='is_checkin' value='0' checked /> No
</div>
</div>
<?php
}
if($tourn_det['SportsType'] != 4 and $tourn_det['tournament_format'] != 'Teams' and $tourn_det['tournament_format'] != 'TeamSport'){
?>
<div class='form-group' >
<label class='control-label col-md-3' for='id_accomodation' style='padding-top:0px;'>Filters:</label>
<div class='col-md-6 form-group internal' style="overflow-y:scroll;height:300px;" >
<?php
$res  = league::get_reg_tourn_participants_withGender($tourn_det['tournament_ID'], $tourn_det['SportsType']);
$reg_users  = $res[0];

/*
$total_events = array();
  foreach($events as $user=>$event){
    foreach ($event as $key => $evnt) {
      $evntarr=explode('-', $evnt);
        $age=$evntarr['2'];
       
       $total_events[$age][]=$evnt;
    }
      
  } */
//echo "<pre>";print_r($reg_users);exit();
 //print_r($events);
?>

<table> 
<?php
//echo "<pre>";print_r($events);

foreach($events as $age=>$evnts){    

$evnts = array_unique($evnts);
$event_format = league::regenerate_events($evnts);
//echo "<pre>";print_r($event_format);
//exit;

foreach ($event_format as $key => $evnt) {

$evntarr         = explode('-', $key);
$age             = $evntarr[0];
$gender          = $evntarr[1];
if(in_array($evntarr[0], array('Doubles','Mixed')))
	$format          = $evntarr[0];  
else if(in_array($evntarr[1], array('Doubles','Mixed')))
	$format          = $evntarr[1];  
else if(in_array($evntarr[2], array('Doubles','Mixed')))
	$format          = $evntarr[2];  

$level_id        = $evntarr[3];
$level_name_arry = league::get_level_name('',$level_id);
$LevelName       = $level_name_arry['SportsLevel'];
$users           = league::in_array_r($key, $reg_users);
//echo "<pre>";print_r($users);
$users=array_unique($users);
if(count($users) != 0){
?>
<tr>
<td style="padding-left:40px;" ><input type="checkbox" value="<?php echo $key; ?>" name="match_type[]" class="macthtype" onclick="GetUsers('<?php echo $format;?>');"> &nbsp; <?php echo $evnt." (".count($users).")"; ?>
</td>
</tr>
<?php
}
}

}
?>
</table>

</div>
</div>
<?php 
}
else{
echo "<div class='form-group'>";
echo "<label class='control-label col-md-3' for='id_accomodation'> Level: </label>";
echo "<div class='col-md-6 form-group internal'>";

echo "<input type='hidden' name='types' id='match_type' value='' />";
echo "<select class='form-control' id='sport_level' name='sport_level' style='width:45%' required>";
	 echo "<option value=''>Select</option>";

$sport_levels = json_decode($tourn_det['Sport_levels']);
 foreach($sport_levels as $level){
	 $level_name = league::get_level_name('', $level);
	 echo "<option value='{$level}'>{$level_name['SportsLevel']}</option>";
 }
echo "</select>";
echo "</div>";
echo "</div>";
}
?>
<div class='form-group'>
<div class='form-group'>
<label class='control-label col-md-3' for='id_accomodation' style='padding-top:0px;'> Bracket Type: </label>
<div class='col-md-6 form-group internal'>

<?php //if($tourn_det['Tournament_type'] != "Challenge Ladder"){?>

<select class="form-control" name="ttype" id="ttype" style="width:45%" required>
<?php if($tourn_det['SportsType'] != 4){ ?>
<option value="Single Elimination" 
<?php if($tourn_det['Tournament_type'] == 'Single Elimination') { echo "selected"; } ?>>Single Elimination</option>
<option value="Consolation" 
<?php if($tourn_det['Tournament_type'] == 'Consolation') { echo "selected"; } ?>>Consolation</option>
<option value="Round Robin" 
<?php if($tourn_det['Tournament_type'] == 'Round Robin') { echo "selected"; } ?>>Round Robin</option>
<option value="Switch Doubles">Switch Doubles</option>
<!-- <option value="Switch Doubles2">Switch Doubles - 2</option> -->
<?php if($tourn_det['Tournament_type'] == "Challenge Ladder"){ ?>
<option value="Challenge Ladder">Challenge Ladder</option>
<?php
}?>

<?php if($tourn_det['SportsType'] != 4 and ($tourn_det['tournament_format'] == 'Teams' || $tourn_det['tournament_format'] == 'TeamSport')){ ?>
<option value="Play Off">Play Off</option>
<?php 
}
}
else{ ?>
<option value='conventional' <?php if($tourn_det['Tournament_type'] == 'conventional') { echo "selected"; } ?>>Conventional</option>
<option value='drive_chip_putt' <?php if($tourn_det['Tournament_type'] == 'drive_chip_putt') { echo "selected"; } ?>>Drive, Chip & Putt</option>
<?php
}
?>
</select>
<?php
//}
/*else{
echo $tourn_det['Tournament_type']; */?>
<!-- <input type = 'hidden' name='ttype' value='<?php echo $tourn_det['Tournament_type']; ?>' /> -->
<?php
//}
?>

<?php //echo $tourn_det['Tournament_type']; ?>
<!-- <input type = 'hidden' name='ttype' value='<?php echo $tourn_det['Tournament_type']; ?>' /> -->
</div>
</div>

<div class='form-group'>
<label class='control-label col-md-3' for='id_accomodation' style='padding-top:0px;'>Registered Players:</label> 
<div class='col-md-7 form-group internal'>
<div id="age_group_users">

<!-- -------------------  for single players -------------------------------------------------------------- -->

<!--
<select id='a' class='cl_sel_users' name='users[]' multiple style="width:100%;height:200pt;" required>

</select>
-->           

<?php
if($tourn_det['tournament_format'] != 'Teams' and $tourn_det['tournament_format'] != 'TeamSport'){
?>
<!-- Table view Players section  -->

<table id="reg_users_table" class="table tab-score">
<thead>
<tr class="top-scrore-table" style='background-color:#f68b1c'>
	<th class="score-position">Select <input type='checkbox' name='userSelectAll' id='userSelectAll' value='1' /></th>
	<th class="score-position">Player/Team</th>
	<th class="score-position">City</th>
	<th class="score-position">State</th>
	<th class="score-position">A2MScore</th>
	<th class="score-position">Seed</th>
</tr>
</thead>
<tbody>
<?php
if(isset($tourn_single_users)){ 

if(count($tourn_single_users) != 0){
	$i = 1;
	foreach($tourn_single_users as $row){
		$user_a2msocre   = league::get_a2mscore($row->Users_ID, $tourn_det['SportsType']);
		$user_membership = league::get_user_mem_details($row->Users_ID, $tourn_det['SportsType']);
		$rating		 = "";
		if($user_membership['Membership_ID']){
		$user_rating = league::get_user_usatt_rating1($user_membership['Membership_ID']);
		$rating		 = $user_rating['Rating'];
		}

		$user_score	 = $user_a2msocre['A2MScore']; 
		$user_mem_id = $user_membership['Membership_ID']; 
		//echo $i;
		?>
		<tr>
		<td>
		<input type='checkbox' class='user_select' name='users[]' id='seeded_<?=$row->Users_ID; ?>' value='<?=$row->Users_ID; ?>' checked /></td>
		<td><?php echo $row->Firstname . ' ' . $row->Lastname;?> </td>
		<td><?php echo $row->City;?> </td>
		<td><?php echo $row->State;?> </td>
		<td><?=$user_score; ?></td>
		<td>
		<img src="<?=base_url();?>icons/up.png" class='up' style='cursor:pointer;width:20px;height:20px;' />
		&nbsp;&nbsp;
		<img src="<?=base_url();?>icons/down.png" class='down' style='cursor:pointer;width:20px;height:20px;' />
		</td>
		</tr>
<?php
		$i++;
	}
}
else{
?>
<tr>
<td>No</td>  
<td>Registered Users</td>  
<td>found. </td>  
<td></td>  
<td></td>  
<td></td>  
</tr>
<?php 
}
}
?>

</tbody>
</table>
<!-- End of Table view Players section  -->
<?php
}
else{
?>
<!-- Table view Teams section  -->

<table id="reg_users_table" class="table tab-score">
<thead>
<tr class="top-scrore-table" style='background-color:#f68b1c'>
	<th class="score-position">Select <input type='checkbox' name='userSelectAll' id='userSelectAll' value='1' /></th>
	<th class="score-position">Team</th>
	<th class="score-position">Seed</th>
</tr>
</thead>
<tbody>
<?php
if(count($tourn_reg_teams2) != 0){

}
else{
?>
<tr>
<td>No</td>  
<td>Registered Teams</td>  
<td>found. </td>    
</tr>
<?php 
}
?>

</tbody>
</table>
<!-- End of Table view Teams section  -->
<?php
}?>
</div>
</div>
</div>
<label class='control-label col-md-3'></label>
<div class='col-md-7 err_msg' id='part_count' style='color:red; display:none;'></div>     
<br />

<div class='form-group' id='div_multi_rounds' style='display:none'>
<label class='control-label col-md-5' style='padding-top:0px;'>No. of Rounds that player plays each other?</label>
<select class="form-control" name="num_of_times" id="num_of_times" style="width:10%">
<option value='1'>1</option>
<option value='2'>2</option>
<option value='3'>3</option>
</select>
</div>

<!-- HTML Code For Groups Creation Starts Here. -->

<div class='form-group' id='groups' style='display:none'>
<label class='control-label col-md-5' style='padding-top:0px;'>Do you want to have groups?</label>
	<label for="Yes"><input type="radio" id="t_Yes" name="is_groups" value="1" /> Yes</label>&nbsp;&nbsp;
	<label for="No"><input type="radio" id="t_No" name="is_groups" value="0" checked="checked" /> No<br /></label>
</div>

<div class='form-group' id='no_of_groups' style='display:none'>
	<label class='control-label col-md-5' style='padding-top:0px;'>How many groups?</label>
	<select class="form-control" name="sel_groups" id="sel_groups" style="width:10%">
		<option value='2'>2</option>
		<option value='3'>3</option>
		<option value='4'>4</option>
		<option value='5'>5</option>
		<option value='6'>6</option>
		<option value='7'>7</option>
		<option value='8'>8</option>
		<option value='9'>9</option>
		<option value='10'>10</option>
	</select>

<label class='control-label col-md-5' style='padding-top:7px;'>Do you want to keep the top players in the same group?</label>
	<label for="Yes" style="padding-top:7px;"><input type="radio" id="top_Yes" name="is_group_top_players" value="1" /> Yes</label>&nbsp;&nbsp;
	<label for="No"><input type="radio" id="top_No"  name="is_group_top_players" value="0" checked="checked" /> No<br /></label>
</div>

<!-- HTML Code For Groups Creation Ends Here.  -->

<script>
$(document).ready(function() {
	$('input[name=is_sch_courts]').click(function() {
			if($(this).val()){
				$('#court_sch_ques').toggle();
			}
			else{
				$('#court_sch_ques').toggle();
			}
	});	

		$("#num_courts").change(function () {

		var count = $("#court_sch_times .div_grp").size();
		//alert(count);
		var requested = parseInt($("#num_courts").val(), 10);
		//alert(requested);

		if (requested > count) {
			for (i = count; i < requested; i++) {
				var $ctrl = $("<div class='col-md-12 div_grp' style='padding-bottom:4px;'><div class='col-md-4'><input type='text' class='form-control' name='courts[]' placeholder='Court Name/#"+(i+1)+"' value='Court "+(i+1)+"' /></div><div class='col-md-3'><input type='text' class='form-control court_date' name='match_date[]' placeholder='MM/DD/YYYY' value='' autocomplete='off' /></div><div class='col-md-2'><select class='form-control' name='stime[]' id='stime_"+i+"' style='width: 108%; !important'><option value=''>Start Time</option><option value='05:00:00'>5:00 am</option><option value='06:00:00'>6:00 am</option><option value='07:00:00'>7:00 am</option><option value='08:00:00'>8:00 am</option><option value='09:00:00'>9:00 am</option><option value='10:00:00'>10:00 am</option><option value='11:00:00'>11:00 am</option><option value='12:00:00'>12:00 pm</option><option value='13:00:00'>1:00 pm</option><option value='14:00:00'>2:00 pm</option><option value='15:00:00'>3:00 pm</option><option value='16:00:00'>4:00 pm</option><option value='17:00:00'>5:00 pm</option><option value='18:00:00'>6:00 pm</option><option value='19:00:00'>7:00 pm</option><option value='20:00:00'>8:00 pm</option><option value='21:00:00'>9:00 pm</option><option value='22:00:00'>10:00 pm</option></select></div><div class='col-md-2'><select class='form-control' name='etime[]' id='etime_"+i+"' style='width: 108%; !important'><option value=''>End Time</option><option value='06:00:00'>6:00 am</option><option value='07:00:00'>7:00 am</option><option value='08:00:00'>8:00 am</option><option value='09:00:00'>9:00 am</option><option value='10:00:00'>10:00 am</option><option value='11:00:00'>11:00 am</option><option value='12:00:00'>12:00 pm</option><option value='13:00:00'>1:00 pm</option><option value='14:00:00'>2:00 pm</option><option value='15:00:00'>3:00 pm</option><option value='16:00:00'>4:00 pm</option><option value='17:00:00'>5:00 pm</option><option value='18:00:00'>6:00 pm</option><option value='19:00:00'>7:00 pm</option><option value='20:00:00'>8:00 pm</option><option value='21:00:00'>9:00 pm</option><option value='22:00:00'>10:00 pm</option><option value='23:00:00'>11:00 pm</option></select></div>");

				$("#court_sch_times").append($ctrl);
				//$('.addn_fee_all').prop('disabled', true);
				//	$('#dynamic_startEndDates_Fees').append($ctrl1);
	
			}
		} else if (requested < count) {
			var x = requested - 1;
			//alert(x);
			$("#court_sch_times .div_grp:gt(" + x + ")").remove();
		}
	});

		$("#num_cons_courts").change(function () {

		var count = $("#cons_court_sch_times .div_grp").size();
		//alert(count);
		var requested = parseInt($("#num_cons_courts").val(), 10);
		//alert(requested);

		if (requested > count) {
			for (i = count; i < requested; i++) {
				var $ctrl = $("<div class='col-md-12 div_grp' style='padding-bottom:4px;'><div class='col-md-4'><input type='text' class='form-control' name='cc_courts[]' placeholder='Court Name/#"+(i+1)+"' value='Court "+(i+1)+"' /></div><div class='col-md-3'><input type='text' class='form-control court_date' name='cc_match_date[]' placeholder='MM/DD/YYYY' value='' autocomplete='off' /></div><div class='col-md-2'><select class='form-control' name='cc_stime[]' id='stime_"+i+"' style='width: 108%; !important'><option value=''>Start Time</option><option value='05:00:00'>5:00 am</option><option value='06:00:00'>6:00 am</option><option value='07:00:00'>7:00 am</option><option value='08:00:00'>8:00 am</option><option value='09:00:00'>9:00 am</option><option value='10:00:00'>10:00 am</option><option value='11:00:00'>11:00 am</option><option value='12:00:00'>12:00 pm</option><option value='13:00:00'>1:00 pm</option><option value='14:00:00'>2:00 pm</option><option value='15:00:00'>3:00 pm</option><option value='16:00:00'>4:00 pm</option><option value='17:00:00'>5:00 pm</option><option value='18:00:00'>6:00 pm</option><option value='19:00:00'>7:00 pm</option><option value='20:00:00'>8:00 pm</option><option value='21:00:00'>9:00 pm</option><option value='22:00:00'>10:00 pm</option></select></div><div class='col-md-2'><select class='form-control' name='cc_etime[]' id='etime_"+i+"' style='width: 108%; !important'><option value=''>End Time</option><option value='06:00:00'>6:00 am</option><option value='07:00:00'>7:00 am</option><option value='08:00:00'>8:00 am</option><option value='09:00:00'>9:00 am</option><option value='10:00:00'>10:00 am</option><option value='11:00:00'>11:00 am</option><option value='12:00:00'>12:00 pm</option><option value='13:00:00'>1:00 pm</option><option value='14:00:00'>2:00 pm</option><option value='15:00:00'>3:00 pm</option><option value='16:00:00'>4:00 pm</option><option value='17:00:00'>5:00 pm</option><option value='18:00:00'>6:00 pm</option><option value='19:00:00'>7:00 pm</option><option value='20:00:00'>8:00 pm</option><option value='21:00:00'>9:00 pm</option><option value='22:00:00'>10:00 pm</option><option value='23:00:00'>11:00 pm</option></select></div>");

				$("#cons_court_sch_times").append($ctrl);
				//$('.addn_fee_all').prop('disabled', true);
				//	$('#dynamic_startEndDates_Fees').append($ctrl1);
	
			}
		} else if (requested < count) {
			var x = requested - 1;
			//alert(x);
			$("#cons_court_sch_times .div_grp:gt(" + x + ")").remove();
		}
	});


});

$('#ttype').change(function (){
	if($(this).val() == 'Consolation'){
		$('#cons_court_dura').show();
	}
	else{
		$('#cons_court_dura').hide();
	}
});

</script>
<script>
$(document).on('change', '#etime_0', function(){ 
	//alert('test'); 
});
/*$('.court_date').fdatepicker({format: 'mm/dd/yyyy hh:ii', disableDblClickSelection: true, language: 'en', pickTime: true });*/
$(document).on('focus', '.court_date', function(){ $(this).fdatepicker({format: 'mm/dd/yyyy ', disableDblClickSelection: true, language: 'en', pickTime: false }); });

$(document).on('focus', '#main_draw_dt', function(){ $(this).fdatepicker({format: 'mm/dd/yyyy hh:ii', disableDblClickSelection: true, language: 'en', pickTime: true }); });
</script>
<!-- HTML Code For Groups Creation Ends Here.  -->
<div class='form-group'>
<label class='control-label col-md-5' style='padding-top:7px;'>Draw Start Date & Time: </label>
<input type='text' class='form-control' id='main_draw_dt' name='main_draw_dt' placeholder='MM/DD/YYYY' value='' autocomplete='off' style='width:20%' />
</div>

<div class='form-group'>
<label class='control-label col-md-5' style='padding-top:7px;'>Do you want to schedule the courts and match timings?</label>
	<label for="sch_Yes" style="padding-top:7px;"><input type="radio" id="sch_Yes" name="is_sch_courts" value="1" /> Yes</label>&nbsp;&nbsp;
	<label for="sch_No"><input type="radio" id="sch_No"  name="is_sch_courts" value="0" checked="checked" /> No<br /></label>
</div>

<div id='court_sch_ques' style='display:none;'>
<div>
<label class='control-label col-md-3' style='padding-top:7px;'>No. of Courts?</label>
	<select class="form-control" name="num_courts" id="num_courts" style="width:20%; margin-bottom:35px;">
		<option value='1'>1</option>
		<option value='2'>2</option>
		<option value='3'>3</option>
		<option value='4'>4</option>
		<option value='5'>5</option>
		<option value='6'>6</option>
		<option value='7'>7</option>
		<option value='8'>8</option>
		<option value='9'>9</option>
		<option value='10'>10</option>
	</select>
</div>
<div id='court_sch_times'></div>
<div id='main_draw_dura'>
<div>
<label class='control-label col-md-3' style='padding-top:7px;'>Match Duration</label>
<input class="form-control" type='number' name='match_duration' id='match_duration' placeholder='Minutes' style="width:20%; margin-bottom:35px;" />
</div>
<div>
<label class='control-label col-md-3' style='padding-top:7px;'>Break time between Matchs</label>
<input class="form-control" type='number' name='match_break' id='match_break' placeholder='Minutes' style="width:20%; margin-bottom:35px;" />
</div>
</div>


<div id='cons_court_dura' style='display:none;'>

<div>
<label class='control-label col-md-3' style='padding-top:7px;'>No. of Courts (Consolation)?</label>
	<select class="form-control" name="num_cons_courts" id="num_cons_courts" style="width:20%; margin-bottom:35px;">
		<option value='1'>1</option>
		<option value='2'>2</option>
		<option value='3'>3</option>
		<option value='4'>4</option>
		<option value='5'>5</option>
		<option value='6'>6</option>
		<option value='7'>7</option>
		<option value='8'>8</option>
		<option value='9'>9</option>
		<option value='10'>10</option>
	</select>
</div>
<div id='cons_court_sch_times'></div>
<div>
<label class='control-label col-md-3' style='padding-top:7px; '>Consolation Match Duration</label>
<input class="form-control" type='number' name='cons_match_duration' id='cons_match_duration' placeholder='Minutes' style="width:20%; margin-bottom:35px;" />
</div>
<div>
<label class='control-label col-md-3' style='padding-top:7px;'>Break time between Matchs (Consolation)</label>
<input class="form-control" type='number' name='cons_match_break' id='cons_match_break' placeholder='Minutes' style="width:20%; margin-bottom:35px;" />
</div>
</div>


</div>

<div class='form-group'>
	<label class='control-label col-md-5' style='padding-top:10px;'>Do you want to Publish the draw to players?</label>
	<select class="form-control" name="is_publish_draw" id="is_publish_draw" style="width:20%; margin-bottom:35px;">
		<option value='0'>UnPublish</option>
		<option value='1'>Publish</option>
	</select>
</div>

<div class='form-group'>
<label class='control-label col-md-3' for='id_accomodation'></label>
<div class='col-md-7 form-group internal'>
<input type="submit" name='generate' id="generate" value="Generate" class="league-form-submit"/>
</div>
</div>
</div>
</form>

<?php 
}
else
{ 
?>
<p style="line-height:20px; font-size:13px"><h5>Oops! Invalid Access. Please contact admin@a2msports.com</h5></p>
<?php
}
?>

<!-- end main body -->

</div><!--Close Top Match-->
<div style='clear:both'></div>
</div><!--Close Top Match-->