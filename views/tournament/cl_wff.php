<!------------Win By forfeit-------------------->
<tr id="forfeit<?=$tm_id; ?>" style="display:none;">
<td colspan='4'>
<!-- <form method="post" name="form-wff" action="<?php echo base_url();?>league/view_matches"> -->
<form name="form-wff" id="form-wff<?=$tm_id; ?>">
 <div class='form-group'>
	<div class='col-md-3 form-group internal'>
		<select id="win_ff_team<?=$tm_id; ?>" name="win_ff_player" class='wff_sel form-control'>
		<option value='<?=$rr_matches[$m]->Player1;?>'>
		<?php
			$get_p1 = league::get_user($rr_matches[$m]->Player1);
			echo $get_p1['Firstname']." ".$get_p1['Lastname'];
			if($rr_matches[$m]->Player1_Partner){
				$player1_partner = league::get_username(intval($rr_matches[$m]->Player1_Partner));
				echo "; ".$player1_partner['Firstname']." ".$player1_partner['Lastname'];
			}
		?>
		</option>
		<option value='<?=$rr_matches[$m]->Player2;?>'>
		<?php
			$get_p2 = league::get_user($rr_matches[$m]->Player2);
			echo $get_p2['Firstname']." ".$get_p2['Lastname'];
			if($rr_matches[$m]->Player2_Partner){
				$player2_partner = league::get_username(intval($rr_matches[$m]->Player2_Partner));
				echo "; ".$player2_partner['Firstname']." ".$player2_partner['Lastname'];
			}
		?>
		</option>
		</select>
	</div>
</div>
</div>
<input class='form-control' value="CL_WFF" name="score_type" type='hidden' /> 
<input class='form-control' value="<?=$rr_matches[$m]->Player1;?>" id="wf_player1_user" name="player1_user" type='hidden' />
<input class='form-control' value="<?=$rr_matches[$m]->Player1_Partner;?>" id="wf_player1_user_partner" name="player1_user_partner" type='hidden' />
<input class='form-control' value="<?=$rr_matches[$m]->Player2;?>" id="wf_player2_user" name="player2_user" type='hidden' />
<input class='form-control' value="<?=$rr_matches[$m]->Player2_Partner;?>" id="wf_player2_user_partner" name="player2_user_partner" type='hidden' />

<input class='form-control' value="<?php echo $rr_matches[$m]->Tourn_ID;?>"	 id="tourn_id" name="tourn_id" type='hidden' />
<input class='form-control' value="<?php echo $rr_matches[$m]->BracketID;?>" id="bracket_id" name="bracket_id" type='hidden' />
<input class='form-control' value="<?php echo $rr_matches[$m]->Match_Num;?>" id="match_num" name="match_num" type='hidden' />
<input class='form-control' value="<?php echo $rr_matches[$m]->Draw_Type;?>" id="match_type" name="match_type"	type='hidden' />
<input class='form-control' value="<?php echo $rr_matches[$m]->Tourn_match_id;?>" id="tourn_match_id" name="tourn_match_id" type='hidden' />
<input class='form-control' value="<?php echo $round;?>" id="round_title" name="round_title" type='hidden' />
<input class='form-control' value="" id="" name="draw_name" type='hidden' />

<div class='form-group'>
	<div class='col-md-1 form-group internal'>
	 <input type="submit" name="cl_add_winner" id="<?=$tm_id; ?>" value="Add Winner" class="cl_wff_add league-form-submit1"/>
	</div>
</div>
</form>
</td>
</tr>
<!----------End of--Win By forfeit-------------------->