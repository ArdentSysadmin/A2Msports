<script>
	$(document).ready(function(){
	var baseurl = "<?php echo base_url();?>";

	$('.double_partner').on('change',function(){

		$sel_id = this.id;
		$uid = $sel_id.slice(3,10);

		var Player = $('#player_'+$uid).val();
		var Partner = $(this).val();

		var Tourn_type = $('#tourn_type').val();
		var Tourn_id = $('#tourn_id').val();
				
        if(Partner != ""){
			alert("Updating players");
            $.ajax({
                type:'POST',
                url:baseurl+'league/double_players_change/',
                data:{ tourn_id:Tourn_id, ttype:Tourn_type, partner:Partner, player:Player},    //{pt:'7',rngstrt:range1, rngfin:range2},
				success:function(html){
                    $('#dbl-load-users').html(html);
                }
            }); 
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
		foreach($tourn_partner_names as $name)
		{
		?>
		<tr>
		<!-- <td>
		<input class="checkbox1" type="checkbox" id='chk<?php echo $name->Users_ID; ?>' name="sel_player[]" value="<?php //echo $name->Users_ID;?>" />
		</td> -->
		<td><?php 
			$player = league::get_username($name->Users_ID);
			echo "<b>" . $player['Firstname']." ".$player['Lastname'] . "</b>";
			?>
			<input type='hidden' name = 'player_<?php echo $name->Users_ID; ?>' id = 'player_<?php echo $name->Users_ID; ?>' value = "<?php echo $name->Users_ID; ?>" />
		</td>
		<td>
		<?php
		if($name->Partner1){
			$partner = league::get_username($name->Partner1);
			echo "<b>" . $partner['Firstname']." ".$partner['Lastname'] . "</b>";
		} ?>
		</td>
		<td>
	 	<select id='sel<?php echo $name->Users_ID; ?>' name='upd_sel_partner[]' class='double_partner'>   <!-- disabled='disabled'> -->
			<option value=''>Select</option>
		<?php	
		foreach($tourn_partner_names as $pname) {
			 if($pname->Users_ID){
				$partner_div = league::get_username($pname->Users_ID);
		?>
			<option value='<?php echo $pname->Users_ID; ?>'>
			<?php echo $partner_div['Firstname']." ".$partner_div['Lastname']; ?>
			</option>
		<?php
			 }
		}
		?>
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