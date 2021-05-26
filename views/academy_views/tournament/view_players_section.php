<table class="table tab-score" id="tourn_players">
<thead>
<tr class="top-scrore-table" style='background-color:#f68b1c'>
<?php
if($this->logged_user_role == 'Admin' or $this->is_super_admin){
?>
<th class="score-position" valign="center" align="center">Check In</th>
<?php }?>
<th class="score-position" valign="center" align="center">Name</th>
<th class="score-position" valign="center" align="center">Events</th>
<th class="score-position" valign="center" align="center">Gender</th>
<?php
if($tour_details->Usersid == $this->logged_user or $this->is_super_admin){
?>
<th class="score-position" valign="center" align="center">Mobile</th>
<th class="score-position" valign="center" align="center">School</th>
<?php
} ?>
<th class="score-position" valign="center" align="center">City</th>
<th class="score-position" valign="center" align="center">State</th>
<?php
//if($this->academy_id == 1176){
?>
<!-- <th class="score-position" valign="center" align="center">GPA<br />Rating</th> -->
<?php
//}
//else{
?>
<th class="score-position" valign="center" align="center">A2M<br />Rating</th>
<?php
//}
if(($this->logged_user_role == 'Admin' or $this->is_super_admin) and $tour_details->TShirt){
?>
<th class="score-position" valign="center" align="center">T-Shirt</th>
<?php
}
if($tour_details->Usersid == $this->logged_user or $this->is_super_admin){
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
<?php }?>
<td style="padding-left:10px">
<?php
echo "<a href='".$this->config->item('club_form_url')."/player/".$name->Users_ID."' target='_blank'>" . ucfirst($name->Firstname) . " " . ucfirst($name->Lastname) . "</a>";
?>
</td>
<td style="padding-left:10px">
<?php
$reg_events_array = league::regenerate_events($reg_events);

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
if($tour_details->Usersid == $this->logged_user or $this->is_super_admin){
$mobile = preg_replace("/([0-9]{3})([0-9]{3})([0-9]{4})/", "($1) $2-$3", $name->Mobilephone); ?>
<td style="padding-left:10px"><?=$mobile; ?></td>
<td style="padding-left:10px"><?=$name->School_Info; ?></td>
<?php } ?>
<td style="padding-left:10px"><?=$name->City; ?></td>
<td style="padding-left:10px"><?=$name->State; ?></td>
<td style="padding-left:10px">
<span id='a2m_dis_<?=$name->Users_ID;?>' style='color:#000;font-size:13px;font-weight:normal;'><?=$user_a2m; ?></span>
<?php
//if(($tour_details->Usersid == $this->logged_user or $this->is_super_admin) and $user_a2m == 100){
if($tour_details->Usersid == $this->logged_user or $this->is_super_admin){
?>
<img src='<?=base_url();?>images/edit.png' class='edit_a2m' name='edit_a2m' id='<?=$name->Users_ID;?>' style='width:18px;height:18px;cursor:pointer;' />

<div id='edit_sec_<?=$name->Users_ID;?>' style='display:none;'>
	<!-- <input type='text' name='upd_a2m_val_<?=$name->Users_ID;?>' id='txt_<?=$name->Users_ID;?>' value='<?=$user_a2m;?>' style='width:50px;' maxlength='5' /><br /><br /> -->

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
if($tour_details->Usersid == $this->logged_user or $this->is_super_admin){
?>
<td class="score-position" valign="center" align="center">
<span style='display:none;'><?=strtotime($name->Reg_date);?></span>
<?php
if($name->Reg_date != NULL and $name->Reg_date != ''){ echo date('m-d-Y', strtotime($name->Reg_date)); } else { echo "N/A";}
?></td>
<?php
}?>
</tr>
<?php
	//if($max_a2m < $user_a2m){
	//	$max_a2m = $user_a2m;
	//}
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
