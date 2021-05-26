


<table class="tab-score">
		<?php 
		if(count(array_filter($tourn_participants)) > 0) {
		?>
		<tr class="top-scrore-table">
		<!-- <th width="5%" class="score-position">Select</th> -->
		<th width=""></th>
		<th style="padding-left:40px;">Players:</th>
		<th style="padding-left:40px;">A2MScore:</th>
		<th style="padding-left:40px;">Level</th>
		<th style="padding-left:40px;">Age Group</th>
		</tr>

		<?php
			foreach($tourn_participants as $name)
			{
			?>
			<tr>
			<td></td>
			<td style="padding-left:40px;"><?php 
				$player = league::get_username($name->Users_ID);
				echo "<a href='".base_url()."player/$name->Users_ID'>".$player['Firstname'] . " " .$player['Lastname']."</a>";
				?>
			</td>

			<td style="padding-left:40px;">
			<?php 
			$user_a2msocre = league::get_a2mscore($name->Users_ID, $sport_id);
			$user_score = $user_a2msocre['A2MScore'];
			echo $user_score;
			?>
			</td>
			<td style="padding-left:40px;">
			<?php $get_sport = league::getonerow($name->Tournament_ID);
			$get_level = league::get_level_name($get_sport->SportsType,$name->Reg_Sport_Level);
			echo $get_level['SportsLevel']; ?>
			</td>

			</tr>
			<?php 
			}
		} 
		else {
		?>
			<tr><td colspan='6'><b>No players are registered yet. </b></td></tr>
		<?php } ?>
</table>