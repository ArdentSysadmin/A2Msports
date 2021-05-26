<script>
	$(document).ready(function(){
	var baseurl = "<?php echo base_url();?>";

	$('.double_partner').on('change',function(){

		$sel_id = this.id;
		$uid	= $sel_id.slice(3,10);

		var Player		= $('#player_'+$uid).val();
		var Partner		= $(this).val();
		var Event		= $('#event').val();

		var Tourn_type	= $('#tourn_type').val();
		var Tourn_id	= $('#tourn_id').val();
		var mf_filter	= $('#mf_filter').val();
				
        if(Partner != "" && Partner > 0){
			var c = confirm("Are you sure to change?");
			if(c === true){
				//alert("Updating players");
				$.ajax({
					type:'POST',
					url:baseurl+'league/double_players_change/',
					data:{ tourn_id:Tourn_id, ttype:Tourn_type, partner:Partner, player:Player, event:Event },    //{pt:'7',rngstrt:range1, rngfin:range2},
					success:function(html){
						$('#dbl-load-users').html(html);
						var cur_sel = $('.event_change').val();
						get_partners_jq(Tourn_id, cur_sel);
						alert("Partner updated successfully.");
					}
				});
			}
			else{
				$(this).val('');
			}
        }
		else if(Partner == "-1"){
			var c = confirm("Are you sure to release the partner?");
			if(c === true){
				//alert("Updating players");
				$.ajax({
					type:'POST',
					url:baseurl+'league/double_players_change_nopartner/',
					data:{ tourn_id:Tourn_id, ttype:Tourn_type, partner:Partner, player:Player, event:Event },    //{pt:'7',rngstrt:range1, rngfin:range2},
					success:function(html){
						$('#dbl-load-users').html(html);
						var cur_sel = $('.event_change').val();
						get_partners_jq(Tourn_id, cur_sel);
						alert("Partner updated successfully.");
					}
				});
			}
		}
		
     });
	 });
</script>
	
	<table class="tab-score">
	<tr class='top-scrore-table'>
	<td width="15%">Player</td>
	<td width="15%">Partner</td>
	<td width="15%">Change To</td>
	</tr>

	<?php
	$abc = $tourn_partner_names;
	if(count(array_filter($tourn_partner_names)) > 0) {

	$opt_list = '';
	foreach($tourn_partner_names as $pname){
		if($pname->Users_ID){
		$partner_div_gender = "";
		//$partner_div = league::get_username($pname->Reg_Users_ID);
			if($pname->Gender == 1){
				$partner_div_gender = "(M)";
			}
			else if($pname->Gender == 0){
				$partner_div_gender = "(F)";
			}
		$opt_list .= "<option value='$pname->Users_ID'>$pname->Firstname $pname->Lastname $partner_div_gender</option>";
		}
	}


		foreach($tourn_partner_names as $name)
		{
		?>
		<tr>
		<td><?php 
				$gender = "";
			//$player = league::get_username($name->Users_ID);
			if($name->Gender == 1){
				$gender = "(M)";
			}
			elseif($name->Gender == 0){
				$gender = "(F)";
			}
			echo "<b>".ucfirst($name->Firstname)." ".ucfirst($name->Lastname)." ".$gender."</b>";
			?>
			<input type='hidden' name='player_<?php echo $name->Users_ID; ?>' id='player_<?php echo $name->Users_ID; ?>' value="<?php echo $name->Users_ID; ?>" />
		</td>
		<td>
		<?php
		$partners = '';
		if($name->Partners){
		$partners = json_decode($name->Partners, true);
	
		$partner = '';
			if($partners[$event]){
			$partner_player = $partners[$event];
			$partner = league::get_username($partner_player);
			if($partner['Gender'] == 1){
				$p_gender = "(M)";
			}
			else if($partner['Gender'] == 0){
				$p_gender = "(F)";
			}

			echo "<b>".ucfirst($partner['Firstname'])." ".ucfirst($partner['Lastname'])." ".$p_gender."</b>";
			}
		}
		?>
		</td>
		<td>
	 	<select id='sel<?php echo $name->Users_ID; ?>' name='upd_sel_partner[]' class='double_partner form-control' style='width:50%'>   <!-- disabled='disabled'> -->
		<option value=''>Select</option>
		<option value='-1'>--Release Partner--</option>

		<?=$opt_list;?>
		</select>
		</td>
		<!-- <td><?php //echo $name->Reg_Age_Group; ?></td> -->
		</tr>
		<?php
		}
	?>
	<input type='hidden' name='event' id='event' value="<?=$event;?>" />
	<?php
	}
	else{
	?>
	<tr><td colspan='6'><b>No Players Found. </b></td></tr>
	<?php
	}
	?>
	</table>