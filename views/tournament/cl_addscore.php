<!-- -------------  Add Score Section	-------------------- -->
<tr id="score<?=$tm_id; ?>" class="tourn_match" style="display:none;">
<td colspan='4'>
<div>
<form name="form-addscore" id="form-addscore<?=$tm_id; ?>">

<div class='form-group'>
<div class='col-md-2 form-group internal'>
<input type="text" class='form-control' placeholder="Date" id="sdate<?=$tm_id;?>" name="match_date" value="<?php echo date('m/d/Y');?>" required />
</div>

	<div class='form-group'>
	<div class='col-md-8 form-group internal scoretable-web'>

	<input type='checkbox' name="<?=$tm_id;?>" id='wff_add' class='wff_score' />&nbsp;Declare winner by Win by Forfeit
	
		<?php $sport_id = $tour_details->SportsType; ?>
		<table class="score-cont">
		  <?php if($sport_id == 1){ ?>
		 <tr>
			<th>Players</th><th>Set1</th><th>Set2</th><th>Set3</th><th>Set4</th><th>Set5</th>
		 </tr> 
		 <?php } else{ ?>
		 <tr>
			<th>Players</th><th>Game1</th><th>Game2</th><th>Game3</th><th>Game4</th><th>Game5</th>
		 </tr> 
		  <?php } ?>

		 <tr>
			<td bgcolor="#fdd7b0"><b><div id='div_t1_p1_<?=$tm_id;?>'><?php
			$get_p1 = league::get_user($rr_matches[$m]->Player1);
			echo $get_p1['Firstname']." ".$get_p1['Lastname'];
			if($rr_matches[$m]->Player1_Partner){
				$player1_partner = league::get_username(intval($rr_matches[$m]->Player1_Partner));
				echo "; ".$player1_partner['Firstname']." ".$player1_partner['Lastname'];
			}
			?></div></b></td>
			<td><input id='set1_1' name='player1[]' style = "width:65%" type='text' maxlength='2' /></td>
			<td><input id='set1_1' name='player1[]' style = "width:65%" type='text' maxlength='2' /></td>
			<td><input id='set1_1' name='player1[]' style = "width:65%" type='text' maxlength='2' /></td>
			<td><input id='set1_1' name='player1[]' style = "width:65%" type='text' maxlength='2' /></td>
			<td><input id='set1_1' name='player1[]' style = "width:65%" type='text' maxlength='2' /></td>
			<!-- <td><input id='set1_1' name='player1[]' style = "width:65%" type='text' maxlength='2' /></td> -->
		 </tr>
		 <tr>
			<td bgcolor="#fdd7b0"><b><div id='div_t2_p1_<?=$tm_id;?>'><?php
			$get_p2 = league::get_user($rr_matches[$m]->Player2);
			echo $get_p2['Firstname']." ".$get_p2['Lastname'];
			if($rr_matches[$m]->Player2_Partner){
				$player2_partner = league::get_username(intval($rr_matches[$m]->Player2_Partner));
				echo "; ".$player2_partner['Firstname']." ".$player2_partner['Lastname'];
			}
			?></div></b></td>
			<td><input id='set1_2' name='player2[]' style = "width:65%" type='text' maxlength='2' /></td>
			<td><input id='set1_2' name='player2[]' style = "width:65%" type='text' maxlength='2' /></td>
			<td><input id='set1_2' name='player2[]' style = "width:65%" type='text' maxlength='2' /></td>
			<td><input id='set1_2' name='player2[]' style = "width:65%" type='text' maxlength='2' /></td>
			<td><input id='set1_2' name='player2[]' style = "width:65%" type='text' maxlength='2' /></td>
			<!-- <td><input id='set1_2' name='player2[]' style = "width:65%" type='text' maxlength='2' /></td> -->	
		 </tr>
		 </table> 
	
		</div>
		</div>

		 <!-- ---------------Mobile view------------------------------------------------------- -->
		<div class="scoretable-mob">
		<input type='checkbox' name="<?=$tm_id; ?>" id='wff_add' class='wff_score' />&nbsp;
		Declare winner by Win by Forfeit

			<table class="score-cont">
					<tr>
						<th>Players</th>
						<th bgcolor="#fdd7b0"><b><div id='div_mob_<?=$tm_id;?>'></div></b></th>
						<th bgcolor="#fdd7b0"><b><div id='div_mob_<?=$tm_id;?>'></div></b></th>
						<?php 
							if($sport_id == 1){
							$set_or_game = 'Set';
							}
							else{
							$set_or_game = 'Game';
							}
						?>
				   </tr>
		  <tr>
			<td>
				<?php echo $set_or_game . "1"; ?>
			</td>
			<td><input id='set1_1' name='player1[]' style = "width:45%" type='text' maxlength='2' /></td>
			<td><input id='set1_2' name='player2[]' style = "width:45%" type='text' maxlength='2' /></td>
			</tr>
			<tr>
			<td>
				<?php echo $set_or_game . "2"; ?>
			</td>
			<td><input id='set2_1' name='player1[]' style = "width:45%" type='text' maxlength='2' /></td>
			<td><input id='set2_2' name='player2[]' style = "width:45%" type='text' maxlength='2' /></td>
			</tr>
			<tr>
			<td>
				<?php echo $set_or_game . "3"; ?>
			</td>
			<td><input id='set3_1' name='player1[]' style = "width:45%" type='text' maxlength='2' /></td>
			<td><input id='set3_2' name='player2[]' style = "width:45%" type='text' maxlength='2' /></td>
			</tr>
			<tr>
			<td>
				<?php echo $set_or_game . "4"; ?>
			</td>
			<td><input id='set4_1' name='player1[]' style = "width:45%" type='text' maxlength='2' /></td>
			<td><input id='set4_2' name='player2[]' style = "width:45%" type='text' maxlength='2' /></td>
			</tr>
			<tr>
			<td>
				<?php echo $set_or_game . "5"; ?>
			</td>
			<td><input id='set5_1' name='player1[]' style = "width:45%" type='text' maxlength='2' /></td>
			<td><input id='set5_2' name='player2[]' style = "width:45%" type='text' maxlength='2' /></td>
			</tr>

	 </table>
	</div>
			<!-- ---------------End of Mobile view------------------------------------------------------- -->

	 <input class='form-control' value="CL_ADDSCORE" name="score_type" type='hidden' /> 
	 <input class='form-control' value="<?=$rr_matches[$m]->Player1;?>" id="player1_user" name="player1_user" type='hidden' />
	 <input class='form-control' value="<?=$rr_matches[$m]->Player1_Partner;?>" id="player1_user_partner" name="player1_user_partner" 
	 type='hidden' />

	 <input class='form-control' value="<?=$rr_matches[$m]->Player2;?>" id="player2_user" name="player2_user" type='hidden' />
	 <input class='form-control' value="<?=$rr_matches[$m]->Player2_Partner;?>" id="player2_user_partner"	name="player2_user_partner"	type='hidden' />

	 <input class='form-control' value="<?php echo $rr_matches[$m]->Tourn_ID;?>"	id="tourn_id"		name="tourn_id"		type='hidden' />
	 <input class='form-control' value="<?php echo $rr_matches[$m]->BracketID;?>"	id="bracket_id"		name="bracket_id"	type='hidden' />
	 <input class='form-control' value="<?php echo $rr_matches[$m]->Match_Num;?>"	id="match_num"		name="match_num"	type='hidden' />
	 <input class='form-control' value="<?php echo $rr_matches[$m]->Draw_Type;?>"	id="match_type"		name="match_type"	type='hidden' />
	 <input class='form-control' value="<?php echo $rr_matches[$m]->Tourn_match_id;?>" id="tourn_match_id" name="tourn_match_id" type='hidden' />
	 <input class='form-control' value="<?php echo $round;?>"						id="round_title"	name="round_title"	type='hidden' />
	 <input class='form-control' value="" id="" name="draw_name" type='hidden' />

	<div class='form-group'>
	<div class='col-md-1 form-group internal'>
	 <input name="add_cl_match_score" id="<?=$tm_id; ?>" type="submit" value="Add" class="add_cl_score_ajax league-form-submit" />
	</div>
	</div>

</form>
</div>
</td>
</tr>
<!-- End of Add Score Section -->