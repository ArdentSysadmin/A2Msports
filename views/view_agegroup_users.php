<script>
$(document).ready(function(){

$(".cl_sel_users, .ajax_blur").click(function(){
$('#part_count').hide();
});

});
</script>
<select id='a' class='cl_sel_users' name='users[]' multiple style="width:100%;height:200pt;" required>

<?php
if($match_type == 'Doubles'){ $partner_type = 'Partner1'; }
else if($match_type == 'Mixed'){ $partner_type = 'Partner2'; }

if(isset($tourn_age_group_users)){
 
	if(count($tourn_age_group_users) != 0)
	{
	foreach($tourn_age_group_users as $row) 
	{
	$user_a2msocre = league::get_a2mscore($row->Users_ID, $sport);
	$user_score = $user_a2msocre['A2MScore'];
	?>
	<option value=<?php  echo $row->Users_ID ?>><?php echo $row->Firstname . ' ' . $row->Lastname . ' (' . $user_score . ')'; ?></option>
	<?php 							
	}
	}
	else
	{
	?>
	<option value="" disabled>No Registered Users. </option>	
	<?php
	}
	?>
<!-- </select> -->
<?php  } ?>
<!-- -----------------------------------------	-------------------------------------------------------------- -->

<?php if(isset($tourn_double_group_users)){ ?>
<?php 
if(count($tourn_double_group_users) != 0)
{
$partner_arr = array();

foreach($tourn_double_group_users as $row) 
{
$user = league::get_username($row->Users_ID);
$user_name = $user['Firstname'] . ' ' . $user['Lastname'];

$user_a2msocre = league::get_a2mscore($row->Users_ID, $sport);
$user_score = $user_a2msocre['A2MScore'];

$partner = league::get_username($row->$partner_type);
$partner_name = $partner['Firstname'] . ' ' . $partner['Lastname'];

$partner_a2msocre = league::get_a2mscore($row->$partner_type, $sport);
$partner_score = $partner_a2msocre['A2MScore'];


$partner_arr[] = $row->$partner_type;

if(!in_array($row->Users_ID, $partner_arr)){
//$box = "<input type='text' name='first' value='".$partner_name."'>";
?>
<option value="<?php echo $row->Users_ID."-".$row->$partner_type ?>" <?php if(!$row->$partner_type) { echo "readonly='readonly'"; } ?>><?php echo $user_name. ' (' . $user_score . ')' . " - " .  $partner_name  . ' (' . $partner_score . ')'; ?></option>
<?php
}
}

}
else{
?>
<option value="" disabled>No Registered Users. </option>	
<?php
}
?>

<?php  } ?>
	<!-- ------------------- Teams -------------------------------------------------------------- -->				
<?php				
if(isset($tourn_reg_teams)){ ?>				
<?php 				
if(count($tourn_reg_teams) != 0){				
foreach($tourn_reg_teams as $row)				
{				
?>				
<option value=<?php echo $row->Team_ID ?>><?php echo $row->Team_name; ?></option>				
<?php 											
}				
}				
else{				
?>				
<option value="" disabled>No Registered Teams. </option>					
<?php } } ?>
</select>

<!-- ----------------------------------------------------------------------------------------------- -->

<br><br>
Move <a  onclick="listbox_move('a', 'up')" style='cursor:pointer'>UP</a>,
<a onclick="listbox_move('a', 'down')" style='cursor:pointer'>DOWN</a>

&nbsp;&nbsp;&nbsp;

Select
<a  onclick="listbox_selectall('a', true)" style='cursor:pointer'>All</a>,
<a  onclick="listbox_selectall('a', false)" style='cursor:pointer'>None</a>