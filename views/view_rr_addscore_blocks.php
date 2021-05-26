
<!------------Win By forfeit-------------------->
<tr id="forfeit<?php echo $rr_matches[$m]->Tourn_match_id; ?>" style="display:none;">
<td colspan='6'>
<!-- <form method="post" name="form-wff" action="<?php echo base_url();?>league/view_matches"> -->
 <form name="form-wff" id="form-wff<?php echo $rr_matches[$m]->Tourn_match_id; ?>">
 <div class='form-group'>
	<div class='col-md-3 form-group internal'>

		<?php
		$get_name = league::get_username($rr_matches[$m]->Player1); 
		$player1_name = $get_name['Firstname'] . "  " . $get_name['Lastname'];
		?>
		<?php 
		$get_name = league::get_username($rr_matches[$m]->Player2);
		 $player2_name =  $get_name['Firstname'] . "  " . $get_name['Lastname'];
		?>

		<select name="id" class='form-control'>

		<option value="<?php echo $rr_matches[$m]->Player1; ?>">
		<?php echo $player1_name;

			if($partner1){ echo "; ".$partner1['Firstname']." ".$partner1['Lastname']; }
		?></option>

		<option value="<?php echo $rr_matches[$m]->Player2; ?>">
		<?php 
		echo $player2_name;

			 if($partner2){ echo "; ".$partner2['Firstname']." ".$partner2['Lastname']; }
		?>	
	    </option>
		</select> 
	</div>
</div>

	  <input class='form-control' value="WFF" name="score_type" type='hidden'> 
	  <input class='form-control' value="<?php echo $rr_matches[$m]->Tourn_ID;?>" id="tourn_id" name="tourn_id" type='hidden'> 
	  <input class='form-control' value="<?php echo $rr_matches[$m]->BracketID;?>" id="bracket_id" name="bracket_id" type='hidden'>
	  <input class='form-control' value="<?php echo $rr_matches[$m]->Match_Num;?>" id="match_num" name="match_num" type='hidden'> 
	  <input class='form-control' value="<?php echo $match_type;?>" id="match_type" name="match_type" type='hidden'> 
	<input class='form-control' value="<?php echo $rr_matches[$m]->Tourn_match_id;?>" id="tourn_match_id" name="tourn_match_id" type='hidden'>
	<input class='form-control' value="<?php echo $rd_type;?>" id="round_title" name="round_title" type='hidden'>
	<input class='form-control' value="" id="" name="draw_name" type='hidden'>

	<input class='form-control' value="<?php echo $rr_matches[$m]->Player1;?>" id="tourn_match_id" name="player1" type='hidden'>
	<input class='form-control' value="<?php echo $rr_matches[$m]->Player1_Partner;?>" id="tourn_match_id" name="player1_partner" type='hidden'>
	<input class='form-control' value="<?php echo $rr_matches[$m]->Player2;?>" id="tourn_match_id" name="player2" type='hidden'>
	<input class='form-control' value="<?php echo $rr_matches[$m]->Player2_Partner;?>" id="tourn_match_id" name="player2_partner" type='hidden'>

<div class='form-group'>
	<div class='col-md-1 form-group internal'>
	 <input type="submit" name="rr_add_winner" id="<?php echo $rr_matches[$m]->Tourn_match_id; ?>" value="Add Winner" class="wff_add league-form-submit1"/>
	</div>
</div>

</form>
</td>
</tr>

<!----------End of--Win By forfeit-------------------->

<tr id="score<?php echo $rr_matches[$m]->Tourn_match_id; ?>" class="tourn_match" style="display:none;">
<td colspan='6'>
<div>

<!-- <form method="post" name="form-addscore" action="<?php echo base_url();?>league/view_matches"> -->


<form name="form-addscore" id="form-addscore<?php echo $rr_matches[$m]->Tourn_match_id; ?>">

<div class='form-group'>
	<div class='col-md-2 form-group internal'>
<input type="text" class='form-control' placeholder="Date" id="sdate<?php echo $rr_matches[$m]->Tourn_match_id; ?>" 
name="tour_match_date" value="<?php echo date('m/d/Y');  ?>" required />
	</div>
<script>
$(function() {
	var spid = "<?php echo $rr_matches[$m]->Tourn_match_id; ?>";
 $('#sdate'+spid).datepick();
});
</script>

	<div class='form-group'>
	<div class='col-md-8 form-group internal'>

	<input type='checkbox' name="<?php echo $rr_matches[$m]->Tourn_match_id; ?>" id='wff_add' class='wff_score' />&nbsp;Declare winner by Win by Forfeit
	
		<?php
		$get_name = league::get_username($rr_matches[$m]->Player1); 
		$player1_name = $get_name['Firstname'] . "  " . $get_name['Lastname'];
		?>
		<?php
		$get_name = league::get_username($rr_matches[$m]->Player2);
		 $player2_name =  $get_name['Firstname'] . "  " . $get_name['Lastname'];
		?>
		<?php
		$get_sport = league::getonerow($tourn_id);
		$sport_id = $get_sport->SportsType;
		?>
		<table class="score-cont">
		  <?php if($sport_id == 1){ ?>
		  <tr>
			<th>Players</th>
			<th>Set1</th>
			<th>Set2</th>
			<th>Set3</th>
			<th>Set4</th>
			<th>Set5</th>
			<!-- <th>Set6</th> -->
		 </tr> 
		 <?php } else { ?>
		 <tr>
			<th>Players</th>
			<th>Game1</th>
			<th>Game2</th>
			<th>Game3</th>
			<th>Game4</th>
			<th>Game5</th>
			<!-- <th>Game6</th> -->
		 </tr> 
		  <?php } ?>

		 <tr>
			<td bgcolor="#fdd7b0"><b><?php echo $player1_name; 
			 if($partner1){ echo "; ".$partner1['Firstname']." ".$partner1['Lastname']; }
			 ?></b></td>
			<td><input id='set1_1' name='player1[]' style = "width:65%" type='text' maxlength='2' /></td>
			<td><input id='set1_1' name='player1[]' style = "width:65%" type='text' maxlength='2' /></td>
			<td><input id='set1_1' name='player1[]' style = "width:65%" type='text' maxlength='2' /></td>
			<td><input id='set1_1' name='player1[]' style = "width:65%" type='text' maxlength='2' /></td>
			<td><input id='set1_1' name='player1[]' style = "width:65%" type='text' maxlength='2' /></td>
			<!-- <td><input id='set1_1' name='player1[]' style = "width:65%" type='text' maxlength='2' /></td> -->

		 </tr>
		  <tr>
			<td bgcolor="#fdd7b0"><b><?php echo $player2_name; 
			 if($partner2){ echo "; ".$partner2['Firstname']." ".$partner2['Lastname']; }
			?></b></td>
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
	 <input class='form-control' value="ADDSCORE" name="score_type" type='hidden'> 
	 <input class='form-control' value="<?php echo $rr_matches[$m]->Player1;?>" id="player1_user" name="player1_user" type='hidden'>
	 <input class='form-control' value="<?php echo $rr_matches[$m]->Player1_Partner;?>" id="player1_user_partner" name="player1_user_partner" type='hidden'>

	 <input class='form-control' value="<?php echo $rr_matches[$m]->Player2; ?>" id="player2_user" name="player2_user" type='hidden'>
	 <input class='form-control' value="<?php echo $rr_matches[$m]->Player2_Partner; ?>" id="player2_user_partner" name="player2_user_partner" type='hidden'>

	 <input class='form-control' value="<?php echo $rr_matches[$m]->Tourn_ID;?>" id="tourn_id" name="tourn_id" type='hidden'>
	  <input class='form-control' value="<?php echo $rr_matches[$m]->BracketID;?>" id="bracket_id" name="bracket_id" type='hidden'>
	  <input class='form-control' value="<?php echo $rr_matches[$m]->Match_Num;?>" id="match_num" name="match_num" type='hidden'>
	  <input class='form-control' value="<?php echo $match_type;?>" id="match_type" name="match_type" type='hidden'>
	<input class='form-control' value="<?php echo $rr_matches[$m]->Tourn_match_id;?>" id="tourn_match_id" name="tourn_match_id" type='hidden'>
		<input class='form-control' value="<?php echo $rd_type;?>" id="round_title" name="round_title" type='hidden'>
	<input class='form-control' value="" id="" name="draw_name" type='hidden'>

	<div class='form-group'>
	<div class='col-md-1 form-group internal'>
	 <input name="add_rr_match_score" id="<?php echo $rr_matches[$m]->Tourn_match_id;?>" type="submit" value="Add" class="add_score_ajax league-form-submit"/>
	</div>
	</div>

</form>
</div>
</td>
</tr>