	<div id="age_group_users">
		<?php if(isset($tourn_age_group_users)){ ?>
		<select id='a' name='users[]' multiple style="width:100%;height:200pt;" required>
			
		<?php 
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

					$partner = league::get_username($row->Partner1);
					$partner_name = $partner['Firstname'] . ' ' . $partner['Lastname'];

					$partner_a2msocre = league::get_a2mscore($row->Partner1, $sport);
					$partner_score = $partner_a2msocre['A2MScore'];

					
					$partner_arr[] = $row->Partner1;

					if(!in_array($row->Users_ID, $partner_arr)){
					//$box = "<input type='text' name='first' value='".$partner_name."'>";
					?>
				<option value="<?php echo $row->Users_ID."-".$row->Partner1 ?>" <?php if(!$row->Partner1) { echo "readonly='readonly'"; } ?>><?php echo $user_name. ' (' . $user_score . ')' . " - " .  $partner_name  . ' (' . $partner_score . ')'; ?></option>
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
		</select>
	
		<!-- ----------------------------------------------------------------------------------------------- -->

				<br><br>
				Move <a  onclick="listbox_move('a', 'up')" style='cursor:pointer'>UP</a>,
				<a onclick="listbox_move('a', 'down')" style='cursor:pointer'>DOWN</a>

				&nbsp;&nbsp;&nbsp;

				Select
				<a  onclick="listbox_selectall('a', true)" style='cursor:pointer'>All</a>,
				<a  onclick="listbox_selectall('a', false)" style='cursor:pointer'>None</a>
			
							
</div>