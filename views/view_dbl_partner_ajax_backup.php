<script>
	$(document).ready(function(){
	var baseurl = "<?php echo base_url();?>";

	$('.double_partner').on('change',function(){

		$sel_id = this.id;
		$uid	= $sel_id.slice(3,10);

		var Player		= $('#player_'+$uid).val();
		var Partner		= $(this).val();

		var Tourn_type	= $('#tourn_type').val();
		var Tourn_id	= $('#tourn_id').val();
		var mf_filter	= $('#mf_filter').val();
				
        if(Partner != ""){
			var c = confirm("Are you sure to change?");
			if(c === true){
				//alert("Updating players");
				$.ajax({
					type:'POST',
					url:baseurl+'league/double_players_change/',
					data:{ tourn_id:Tourn_id, ttype:Tourn_type, partner:Partner, player:Player, mf_filter:mf_filter },    //{pt:'7',rngstrt:range1, rngfin:range2},
					success:function(html){
						$('#dbl-load-users').html(html);
						alert("Partner updated successfully.");
					}
				});
			}
			else{
				$(this).val('');
			}
        }
		
     });
	 });
</script>
	
	<table class="tab-score">
	<tr>
	<!-- <th width="5%" class="score-position">Select</th> -->
	<th width="15%">Name</th>
	<th width="15%">Partner</th>
	<th width="15%">Select</th>
	<!-- <th width="15%">Age Group</th> -->
	</tr>

	<?php
	$abc = $tourn_partner_names;
	if(count(array_filter($tourn_partner_names)) > 0) {

	$opt_list = '';
	foreach($tourn_partner_names as $pname){
		if($pname->Reg_Users_ID){
		$partner_div_gender = "";
		//$partner_div = league::get_username($pname->Reg_Users_ID);
			if($pname->Reg_Gender == 1){
				$partner_div_gender = "(M)";
			}
			else if($pname->Reg_Gender == 0){
				$partner_div_gender = "(F)";
			}
		$opt_list .= "<option value='$pname->Reg_Users_ID'>$pname->Reg_Firstname $pname->Reg_Lastname $partner_div_gender</option>";
		}
	}

		if($get_mf_type == 'Doubles'){ $partner_type = 'Partner1'; }
		else if($get_mf_type == 'Mixed'){ $partner_type = 'Partner2'; }

		foreach($tourn_partner_names as $name)
		{
		?>
		<tr>
		<!-- <td>
		<input class="checkbox1" type="checkbox" id='chk<?php echo $name->Users_ID; ?>' name="sel_player[]" value="<?php //echo $name->Users_ID;?>" />
		</td> -->
		<td><?php 
		    $gender = "";
			//$player = league::get_username($name->Users_ID);
			if($name->Reg_Gender == 1){
				$gender = "(M)";
			}
			elseif($name->Reg_Gender == 0){
				$gender = "(F)";
			}
			echo "<b>" . $name->Reg_Firstname." ".$name->Reg_Lastname ." ".$gender.  "</b>";
			?>
			<input type='hidden' name = 'player_<?php echo $name->Reg_Users_ID; ?>' id = 'player_<?php echo $name->Reg_Users_ID; ?>' value = "<?php echo $name->Reg_Users_ID; ?>" />
		</td>
		<td>
		<?php
		$partner_id = $partner_type."_Users_ID";
		$partner_fn = $partner_type."_Firstname";
		$partner_ln = $partner_type."_Lastname";
		$partner_gen = $partner_type."_Gender";

		if($name->$partner_id){
		$partner_gender = "";
		//$partner = league::get_username($name->$partner_type);
		if($name->$partner_gen == 1){
			$partner_gender = "(M)";
		}else if($name->$partner_gen == 0){
			$partner_gender = "(F)";
		}
		echo "<b>" . $name->$partner_fn." ".$name->$partner_ln." ".$partner_gender. "</b>";
		} ?>
		</td>
		<td>
	 	<select id='sel<?php echo $name->Reg_Users_ID; ?>' name='upd_sel_partner[]' class='double_partner'>   <!-- disabled='disabled'> -->
		<option value=''>Select</option>
		<?=$opt_list;?>
		</select>
		</td>
		<!-- <td><?php //echo $name->Reg_Age_Group; ?></td> -->
		</tr>
		<?php
		}
	?>
	
	<?php
	}
	else {
	?>
	<tr><td colspan='6'><b>No Players Found. </b></td></tr>
	<?php
	}
	?>
	</table>