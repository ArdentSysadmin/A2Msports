<div style='margin-top: 20px;' class='col-md-8'>

<form class="form-horizontal" id="myform" method="post" role="form" action="<?=base_url();?>league/po_update" autocomplete="off" style="/*display: none;*/"> 
<!-- Table view Players section  -->
<table id="reg_users_table" class="table tab-score">
<thead>
<tr class="top-scrore-table" style='background-color:#f68b1c'>
	<th class="score-position" style='display:none;'>Select <input type='checkbox' name='userSelectAll' id='userSelectAll' value='1' /></th>
	<th class="score-position">Player/Team</th>
	<th class="score-position">Win %</th>
	<!-- <th class="score-position">State</th>
	<th class="score-position">A2M Rating</th> -->
	<th class="score-position">Seed</th>
</tr>
</thead>
<tbody>
<?php
if(isset($esc_players)){ 

if(count($esc_players) != 0){
	$i = 1;
	foreach($esc_players as $i => $row){
		$exp = explode('-', $row['pl']);
		if($exp[0])
		$user_det   = league::get_user($exp[0]);

		if($exp[1])
		$user_det2   = league::get_user($exp[1]);

		?>
		<tr>
		<td style='display:none;'>
		<input type='checkbox' class='user_select' name='users[]' id='seeded_<?=$row['pl']; ?>' value='<?=$row['pl']; ?>' checked /></td>
		<td>
		<a href="<?=base_url();?>player/<?=$exp[0]; ?>" target='_blank'><?php echo $user_det['Firstname'] . ' ' . $user_det['Lastname'];?></a>
		<?php if($user_det2){ ?>
		<a href="<?=base_url();?>player/<?=$exp[1]; ?>" target='_blank'><?php echo $user_det2['Firstname'] . ' ' . $user_det2['Lastname'];?></a>		
		<?php
		}
		?>
		</td>
		<td><?php echo $row['wp'];?> </td>
		<!-- <td><?php echo $row->State;?> </td> -->
		<!-- <td><?=$user_score; ?></td> -->
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
<td>Players</td>  
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

<input type='hidden' id='bid' name='bid' value='<?php echo $bid; ?>' />
<input type='hidden' id='tourn_id' name='tourn_id' value='<?php echo $tid; ?>' />
<input type='hidden' id='upd_type' name='upd_type' value='<?php echo 'AUTO_ESC'; ?>' />
<input type="submit" name="generate" id="generate" value="Update" class="league-form-submit">
</form>

</div>
<script>
$(document).on("click", ".up, .down", function(){
	var row = $(this).parents("tr:first");
	if ($(this).is(".up")) {
		row.insertBefore(row.prev());
	}
	else {
		row.insertAfter(row.next());
	}
});
$(document).ready(function(){

//$('#generate').trigger('click');

});
</script>