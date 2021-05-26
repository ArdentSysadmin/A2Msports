<!------------Win By forfeit-------------------->
<tr id="forfeit<?=$line_id; ?>" style="display:none;">
<td colspan='4'>
<!-- <form method="post" name="form-wff" action="<?php echo base_url();?>league/view_matches"> -->
<form name="form-wff" id="form-wff<?=$line_id; ?>">
 <div class='form-group'>
	<div class='col-md-3 form-group internal'>
		<select id="win_ff_team<?=$line_id; ?>" name="win_ff_player" class='wff_sel form-control'></select> 
	</div>
</div>
</div>
 <input class='form-control' value="TEAM_SE_WFF" name="score_type" type='hidden' /> 
 <input class='form-control' value="" id="wf_player1_user_<?=$line_id;?>"			name="player1_user"			type='hidden' />
 <input class='form-control' value="" id="wf_player1_user_partner_<?=$line_id;?>"	name="player1_user_partner" type='hidden' />
 <input class='form-control' value="" id="wf_player2_user_<?=$line_id;?>"			name="player2_user"			type='hidden' />
 <input class='form-control' value="" id="wf_player2_user_partner_<?=$line_id;?>"	name="player2_user_partner"	type='hidden' />
 <input class='form-control' value='<?=$rr_matches[$m]->Player1;?>' id="player1_team_<?=$line_id;?>" name="player1_team" type='hidden' />
 <input class='form-control' value='<?=$rr_matches[$m]->Player2;?>' id="player2_team_<?=$line_id;?>" name="player2_team" type='hidden' />
 <input class='form-control' value="<?php echo $rr_matches[$m]->Tourn_ID;?>"	id="tourn_id"		name="tourn_id"		type='hidden' />
 <input class='form-control' value="<?php echo $rr_matches[$m]->BracketID;?>"	id="bracket_id"		name="bracket_id"	type='hidden' />
 <input class='form-control' value="<?php echo $rr_matches[$m]->Match_Num;?>"	id="match_num"		name="match_num"	type='hidden' />
 <input class='form-control' value="<?php echo $line->Match_Type;?>"			id="match_type"		name="match_type"	type='hidden' />
 <input class='form-control' value="<?php echo $rr_matches[$m]->Tourn_match_id;?>" id="tourn_match_id" name="tourn_match_id" type='hidden' />
 <input class='form-control' value="<?php echo $line_id;?>"						id="match_line_id" name="match_line_id" type='hidden' />
 <input class='form-control' value="<?php echo $round;?>"						id="round_title"	name="round_title"	type='hidden' />
 <input class='form-control' value="" id="" name="draw_name" type='hidden' />

<div class='form-group'>
	<div class='col-md-1 form-group internal'>
	 <input type="submit" name="team_rr_add_winner" id="<?=$line_id; ?>" value="Add Winner" class="wff_add league-form-submit1"/>
	</div>
</div>
</form>
</td>
</tr>
<!----------End of--Win By forfeit-------------------->