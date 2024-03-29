<?php
if(($this->logged_user_role == 'Admin' or $this->is_super_admin) and $tour_details->Is_USATT_Approved){
?>
<div class='col-md-12' align='right'>
<a id='show_new_usatt' style='cursor:pointer'>Show New USATT Memberships</a>
</div>
<script>
$(document).ready(function(){
	$('#show_new_usatt').click(function(){
		$('#div_players').toggle();
		$('#div_new_usatt').toggle();

		if($('#show_new_usatt').html()=='Switch to Players')
			$('#show_new_usatt').html('Show New USATT Memberships');
		else
			$('#show_new_usatt').html('Switch to Players');

	});
});
</script>
<?php
}
?>
<div id='div_players'>
<link href="//cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css" rel="stylesheet" type="text/css" />
<script>
$(document).ready(function(){

$('.edit_a2m').click(function(){
	var uid = $(this).attr('id');
	$('#edit_sec_'+uid).show();
	$('#a2m_dis_'+uid).hide();
	$('#'+uid).hide();
});

$('.cancel_a2m').click(function(){
	var id = $(this).attr('id');
	var x  = id.split('_');
	var uid = x[1];

	$('#edit_sec_'+uid).hide();
	$('#a2m_dis_'+uid).show();
	$('#'+uid).show();
});

$('.upd_a2m_btn').click(function(){
	var id   = $(this).attr('id');
	var x    = id.split('_');
	var uid  = x[1];
	var tid		= $('#tourn_id').val();
	//var uval   = $('#txt_'+uid).val();
	var sl_val			= $('#sl_txt_'+uid).val();
	var db_val		= $('#db_txt_'+uid).val();
	var mx_val		= $('#mx_txt_'+uid).val();

	//var mx_a2m = $('#temp_a2m').val();

	//if(mx_a2m > uval || mx_a2m == 0){
	if(sl_val > 0 && db_val > 0 && mx_val > 0){
		$.ajax({
		  type: 'POST',
		  url: baseurl+'league/edit_user_a2m',
		  //data:{user:uid,tourn_id:tid,uval:uval},
		  data:{user:uid,tourn_id:tid,sl_val:sl_val,db_val:db_val,mx_val:mx_val},
		  success: function(res) {
			  if ($.isNumeric(res)) {
			  $('#a2m_dis_'+uid).html(res);
			  }
			  else {
			  alert(res);
			  }
			  $('#edit_sec_'+uid).hide();
			  $('#a2m_dis_'+uid).show();
		  }
		});
	}
	else{
		//alert("Score shouldn't exceed "+(mx_a2m-1));
		alert("Invalid Scores!");
	}
});

 $('#frm_participants').click(function() {
  var atLeastOneIsChecked = false;
  $('input:checkbox').each(function() {
    if ($(this).is(':checked')) {
      atLeastOneIsChecked = true;
      // Stop .each from processing any more items
      return false;
    }
  });
  if(atLeastOneIsChecked == false){
		alert('Select atlease one player to proceed!');
		e.preventDefault();
		return false;
  }
  // Do something with atLeastOneIsChecked
});
$(".change_level").click(function(){
 var tid=$(this).attr("id");
 var tidarr=tid.split('_');
 var player=tidarr['2'];
  $("#withdrawplayer_"+player).hide();
 //alert(player);
 var tourn_id=tidarr['3'];
    $.ajax({
      type: 'POST',
      url: baseurl+'league/GetUserLevels',
      data:{player:player,tourn_id:tourn_id},
      success: function(res) {
        //console.log(res);die();
       $("#partcipantlevels_"+player).show();
       $("#partcipant_levels_"+player).html(res);
      }
      });
});

$(".withdraw_player").click(function(){
  var tid=$(this).attr("id");
  var tidarr=tid.split('_');
  var player=tidarr['2'];
  $("#partcipantlevels_"+player).hide();
  var tourn_id=tidarr['3'];
  $.ajax({
      type: 'POST',
      url: baseurl+'league/GetUserLevelsExist',
      data:{player:player,tourn_id:tourn_id},
      success: function(res) {
        //alert(res);
        $("#withdrawplayer_"+player).show();
        $("#existing_events_"+player).html(res);
      }
      });
});

$(".cancel").click(function(){
  var tid=$(this).attr("id");
  var tidarr=tid.split('_');
  var player=tidarr['1'];
  $("#withdrawplayer_"+player).hide();
});


$(".sub-proceed").click(function(){
  $(this).val("Please wait...");
});

	//$('input[type="checkbox"]').click(function() {
	$(document).on('click', '.players_check', function() {
		if($(this).prop("checked") == true)
		  var checkin = 1;
		else
		  var checkin = 0;

			var userID = $(this).val();

			$.ajax({
				type: 'POST',
				url: baseurl+'league/update_checkIn',
				data:{player:userID,tourn_id:tourn_id,checkin:checkin},
				success: function(res) {
				}
			});
	});

});

</script>

<style>
.multiselect {
width: 200px;
}
.selectBox {
position: relative;
}
.selectBox select {
width: 100%;
font-weight: bold;
}
.overSelect {
position: absolute;
left: 0; right: 0; top: 0; bottom: 0;
}

#checkboxes {
display: none;
border: 1px #dadada solid;
}
#checkboxes label {
display: block;
}
/*#checkboxes label:hover {
background-color: #1e90ff;
}*/
</style>

<script>
function showCheckboxes($uid){
var elements = document.getElementsByClassName('div_ag_sel')

for (var i = 0; i < elements.length; i++){
elements[i].style.display = "none";
}
var checkboxes = document.getElementById("checkboxes"+$uid);
checkboxes.style.display = "block";
}
</script>

<div class="col-md-12 league-form-bg" style="margin-top:15px; margin-bottom:0px;">
<?php
//$tourn_reg_names = league::get_reg_tourn_player_names($tour_details->tournament_ID);
$parent_class = $this->router->class;
$tourn_reg_names = $parent_class::get_reg_players($tour_details->tournament_ID, $tour_details->SportsType); 

//$get_x = $parent_class::get_tourn_events_arr($tour_details->tournament_ID); 
?>

<div class="tab-content table-responsive">
<table class="table tab-score" id="tourn_players">
<thead>
<tr class="top-scrore-table" style='background-color:#f68b1c'>
<?php
//echo "test".$this->logged_user_role." - ".$this->is_super_admin." - "; exit;
if($this->logged_user_role == 'Admin' or $this->logged_user_role == 'RegPlayer' or $this->is_super_admin){
?>
<th class="score-position" valign="center" align="center">Check In</th>
<?php }?>
<th class="score-position" valign="center" align="center">Name</th>
<th class="score-position" valign="center" align="center">Events</th>
<th class="score-position" valign="center" align="center">Gender</th>
<?php
if($this->logged_user_role == 'Admin' or $this->is_super_admin){
?>
<th class="score-position" valign="center" align="center">Mobile</th>
<th class="score-position" valign="center" align="center"><!-- School -->Age Group</th>
<?php
} ?>
<th class="score-position" valign="center" align="center">City</th>
<th class="score-position" valign="center" align="center">State</th>
<th class="score-position" valign="center" align="center">A2M<br />Rating</th>
<?php
if(($this->logged_user_role == 'Admin' or $this->is_super_admin) and $tour_details->TShirt){
?>
<th class="score-position" valign="center" align="center">T-Shirt</th>
<?php
}
if($this->logged_user_role == 'Admin' or $this->is_super_admin){
?>
<th class="score-position" valign="center" align="center">Register On</th>
<?php
}?>
</tr>
</thead>
<tbody>

<?php
/*echo "<pre>";
print_r($tourn_reg_names);*/

$check_cond = array('0.00','0','NULL','');
$total		= 0;
if(count(array_filter($tourn_reg_names)) > 0){
$max_a2m = 0;

foreach($tourn_reg_names as $name){
	/*echo "<pre>";
	print_r($name);*/
	$get_a2m = $parent_class::get_a2mscore($name->Users_ID, $tour_details->SportsType);
	$a2m_sl    = $get_a2m['A2MScore'];
	$a2m_db  = $get_a2m['A2MScore_Doubles'];
	$a2m_mx = $get_a2m['A2MScore_Mixed'];

		$user_a2m = '';
		if($get_a2m and $tour_details->SportsType != 7){
		$user_a2m = max($get_a2m['A2MScore'],$get_a2m['A2MScore_Doubles'],$get_a2m['A2MScore_Mixed']);
		}
		else{
		$user_a2m = number_format(max($get_a2m['A2MScore'],$get_a2m['A2MScore_Doubles'],$get_a2m['A2MScore_Mixed']), 3);
		}

	$reg_events = '';
	if($name->Reg_Events)
	$reg_events = json_decode($name->Reg_Events);
?>
<tr>
<?php 
if($this->logged_user_role == 'Admin' or $this->is_super_admin){
?>
<td style="padding-left:10px">
<input type="checkbox" name="checkin<?=$name->Users_ID;?>" class="players_check" value="<?php echo $name->Users_ID;?>" <?php if($name->is_checkin)
{echo 'checked="checked"';}
?> />
<span style='display:none;'><?=$name->is_checkin;?></span>
</td>
<?php
}
else if($this->logged_user_role == 'RegPlayer'){
?>
<td style="padding-left:10px">
<span>
<?php 
if($name->is_checkin) 
	echo "Yes"; 
else
	echo " - ";
?>
</span>
</td>
<?php
}
?>
<td style="padding-left:10px">
<?php
echo "<a href='".base_url()."player/".$name->Users_ID."' target='_blank'>" . ucfirst($name->Firstname) . " " . ucfirst($name->Lastname) . "</a>";
?>
</td>
<td style="padding-left:10px">
<?php
$reg_events_array = league::regenerate_events($reg_events);

/*if($this->logged_user == 240){
	echo "<pre>"; print_r($this->tourn_events_arr); 
	echo "<pre>"; print_r($reg_events); 
	echo "<pre>"; print_r($reg_events_array); exit;
}*/
if(count($reg_events_array) > 0){
	foreach($reg_events_array as $i => $group){
	echo $group;
		if(++$i != count($reg_events_array)){
		echo "<br /> ";
		}
	}
}
?>
</td>
<td style="padding-left:10px"><?php if($name->Gender == '1'){ echo 'Male'; }
else if($name->Gender == '0'){ echo 'Female'; }; ?></td>
<?php 
if($this->logged_user_role == 'Admin' or $this->is_super_admin){
$mobile = preg_replace("/([0-9]{3})([0-9]{3})([0-9]{4})/", "($1) $2-$3", $name->Mobilephone); ?>
<td style="padding-left:10px"><?=$mobile; ?></td>
<!-- <td style="padding-left:10px"><?//=$name->School_Info; ?></td> -->
<td style="padding-left:10px"><?php 
$age_group = '';
if($name->DOB) {		
			$birthdate	= new DateTime($name->DOB);
			$today		= new DateTime('today');
			$age		= $birthdate->diff($today)->y;

			switch ($age) {
                case ($age >= 40 and $age < 50):
                   $age_group = "(<b>40+</b>)";
                   break;
                case ($age >= 50 and $age < 60):
                   $age_group = "(<b>50+</b>)";
                   break;
                case ($age >= 60 and $age < 70):
                   $age_group = "(<b>60+</b>)";
                   break;
                case ($age >= 70 and $age < 80):
                   $age_group = "(<b>70+</b>)";
                   break;
                case ($age >= 80 and $age < 90):
                   $age_group = "(<b>80+</b>)";
                   break;
                case ($age >= 90 and $age < 100):
                   $age_group = "(<b>90+</b>)";
                   break;
			}

			}
			
			echo $name->UserAgegroup.$age_group; ?></td>
<?php } ?>
<td style="padding-left:10px"><?=$name->City; ?></td>
<td style="padding-left:10px"><?=$name->State; ?></td>
<td style="padding-left:10px">
<span id='a2m_dis_<?=$name->Users_ID;?>' style='color:#000;font-size:13px;font-weight:normal;'><?=$user_a2m; ?></span>
<?php
//if(($tour_details->Usersid == $this->logged_user or $this->is_super_admin) and $user_a2m == 100){
if($this->logged_user_role == 'Admin' or $this->is_super_admin){
?>
<img src='<?=base_url();?>images/edit.png' class='edit_a2m' name='edit_a2m' id='<?=$name->Users_ID;?>' style='width:18px;height:18px;cursor:pointer;' />

<div id='edit_sec_<?=$name->Users_ID;?>' style='display:none;'>
	<!-- <input type='text' name='upd_a2m_val_<?=$name->Users_ID;?>' id='txt_<?=$name->Users_ID;?>' value='<?=$user_a2m;?>' style='width:50px;' maxlength='5' /> -->

	Singles<br /><input type='text' name='sl_upd_a2m_val_<?=$name->Users_ID;?>' 
	id='sl_txt_<?=$name->Users_ID;?>' value='<?=$a2m_sl;?>' style='width:50px;' maxlength='5' />

	<br />Doubles<br /><input type='text' name='db_upd_a2m_val_<?=$name->Users_ID;?>' id='db_txt_<?=$name->Users_ID;?>' value='<?=$a2m_db;?>' style='width:50px;' maxlength='5' />

	<br />Mixed<br /><input type='text' name='mx_upd_a2m_val_<?=$name->Users_ID;?>' 
	id='mx_txt_<?=$name->Users_ID;?>' value='<?=$a2m_mx;?>' style='width:50px;' maxlength='5' />
	
	<br /><br />
	<input class="upd_a2m_btn a2m-button-small" type='button' name='upd_a2m' id='btn_<?=$name->Users_ID;?>' value='Update' />
	<a class='cancel_a2m' id='cancel_<?=$name->Users_ID;?>' style='cursor:pointer;'>Cancel</a>
</div>
<?php
}
?>
</td>
<?php
if(($this->logged_user_role == 'Admin' or $this->is_super_admin) and $tour_details->TShirt){
?>
<td class="score-position" valign="center" align="center"><?=$name->TShirt_Size; ?></td>
<?php
}
if($this->logged_user_role == 'Admin' or $this->is_super_admin){
?>
<td class="score-position" valign="center" align="center">
<span style='display:none;'><?=strtotime($name->Reg_date);?></span>
<?php
if($name->Reg_date != NULL and $name->Reg_date != ''){ echo date('m-d-Y', strtotime($name->Reg_date)); }
else { echo "N/A"; }
?></td>
<?php
}?>
</tr>
<?php
	if($max_a2m < $user_a2m){
		$max_a2m = $user_a2m;
	}
}

}
else{
?>
<tr>
<?php
if(($this->logged_user_role == 'Admin' or $this->is_super_admin)) { 
?>
<td>&nbsp;</td>
<?php } ?>
<td><b>No Players are Registered yet. </b></td>
<td>&nbsp;</td>
<td>&nbsp;</td>
<td>&nbsp;</td>
<td>&nbsp;</td>
<td>&nbsp;</td>
<?php
if(($this->logged_user_role == 'Admin' or $this->is_super_admin) and !$tour_details->TShirt){ 
?>
<td>&nbsp;</td>
<td>&nbsp;</td>
<?php
}
else if(($this->logged_user_role == 'Admin' or $this->is_super_admin) and $tour_details->TShirt){ 
?>
<td>&nbsp;</td>
<td>&nbsp;</td>
<td>&nbsp;</td>
<td>&nbsp;</td>
<?php
}
?>
</tr>
<?php
}
?>
</tbody>
</table>
</div>  

</div>
<input type='hidden' name='tourn_id' id="tourn_id" value="<?php echo $tour_details->tournament_ID; ?>">
<input type='hidden' name='tourn_type' value = "<?php echo $tour_details->Tournament_type; ?>">
<!-- <input type='hidden' name='temp_a2m' id="temp_a2m" value="<?//=$max_a2m;?>" /> -->
<input type='hidden' name='temp_a2m' id="temp_a2m" value="99999" />

<!-- </div>--></form>
</div>
<div id='div_new_usatt' style='display:none;'>
New USATT signup users
</div>



<?php
if(($this->logged_user_role == 'Admin' or $this->is_super_admin) and $tour_details->TShirt) {
?>
<script>
$(document).ready(function() {
$('#tourn_players').dataTable({dom: "<'row'<'col-sm-3'l><'col-sm-5'p><'col-sm-4'f>>" +
"<'row'<'col-sm-12'tr>>", searching: true, paging: false, lengthMenu: false, aoColumns: [ null,null,null,null,null,null,null,null,null,null,null ], language: {"search":"", "searchPlaceholder":"Search"} });
});
</script>
<?php
}
else if($this->logged_user_role == 'Admin' or $this->is_super_admin) {
?>
<script>
$(document).ready(function() {
$('#tourn_players').dataTable({dom: "<'row'<'col-sm-3'l><'col-sm-5'p><'col-sm-4'f>>" +
"<'row'<'col-sm-12'tr>>", searching: true, paging: false, lengthMenu: false, aoColumns: [ null,null,null,null,null,null,null,null,null,null ], language: {"search":"", "searchPlaceholder":"Search"} });
});
</script>
<?php
}
else if($this->logged_user_role == 'RegPlayer') {
?>
<script>
$(document).ready(function() {
$('#tourn_players').dataTable({dom: "<'row'<'col-sm-3'l><'col-sm-5'p><'col-sm-4'f>>" +
"<'row'<'col-sm-12'tr>>", searching: true, paging: false, lengthMenu: false, aoColumns: [ null,null,null,null,null,null,null ], language: {"search":"", "searchPlaceholder":"Search"} });
});
</script>
<?php
}
else {
?>
<script>
$(document).ready(function() {
$('#tourn_players').dataTable({dom: "<'row'<'col-sm-3'l><'col-sm-5'p><'col-sm-4'f>>" +
"<'row'<'col-sm-12'tr>>", searching: true, paging: false, lengthMenu: false, aoColumns: [ null,null,null,null,null,null ], language: {"search":"", "searchPlaceholder":"Search"} });
});
</script>
<?php
}
?>