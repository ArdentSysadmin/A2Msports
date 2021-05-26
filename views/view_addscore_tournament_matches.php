<script>
$(document).ready(function(){

$(".add_score").click(function(){
var pid = $(this).attr('name');

if($("#score"+pid).css('display')=='none'){
$("#score"+pid).show();
$("#forfeit"+pid).hide();
}
else{
$("#forfeit"+pid).hide();
$("#score"+pid).hide();
}
});


$('.wff_score').click(function() {
var pid2 = $(this).attr('name');

if($("#forfeit"+pid2).css('display')=='none'){
$("#forfeit"+pid2).show();
$("#score"+pid2).hide();
}
else{
$("#forfeit"+pid2).hide();
$("#score"+pid2).hide();

}

});

});

</script>

<script>
$(document).ready(function(){

var baseurl = "<?php echo base_url();?>";

$('.wff_add').click(function (e) {

var id_val = $(this).attr('id');

	  $.ajax({
		type: 'POST',
		url: baseurl+'league/view_matches',
		data: $('#form-wff'+id_val).serialize(),
		success: function () {
		   location.reload();
		}
	  });
	 // alert("Still under development!");
	  e.preventDefault();

	});
});
</script>

<script>
$(document).ready(function(){

var baseurl = "<?php echo base_url();?>";

$('.add_score_ajax').click(function (e) {

var id_val = $(this).attr('id');
var Tourn_id = $("#tourn_id").val();

	  $.ajax({
		type: 'POST',
		url: baseurl+'league/view_matches',
		data: $('#form-addscore'+id_val).serialize(),
		success: function () {
		   //location.reload();
		   location.href = baseurl+"league/view/"+Tourn_id;
		}
	  });
	  	 // alert("Still under development!");

	  e.preventDefault();

	});
});
</script>

<?php 
//$arr_data = (array) $user_draws;
$arr_data = $user_draws;

//echo "<pre>"; print_r($user_draws);
//echo count($user_draws);

//if(empty($user_draws)){
if(count($user_draws) == 0){

	echo "<div style='margin-left:260px;' class='form-group' id='no_result'><br /><b>No matches found to add score.</b></div>";
?>
<!-- <img src='<?php// echo base_url();?>images/ajax_loader.gif' width='50px' height='60px' id='loading' style="display:none;margin-left:360px;" align="middle" /> -->
<?php
}
else
{
    if(count($user_draws) > 0){

$a = 1;
	foreach($user_draws as $draw){
		  ?>
		<br />
		<img src='<?php echo base_url();?>images/ajax_loader.gif' width='50px' height='60px' id='loading' style="display:none;margin-left:360px;" align="middle" />

	  <?php
	 // echo "dfdsfsd".$draw->BracketID;
	    $matches = addscore::get_brackets($draw->BracketID);

		  $arr_matches = (array) $matches;
//echo "<pre>"; print_r($matches);
//echo "<pre>"; print_r($arr_matches);


	    if(count($arr_matches) > 0){

			$total_rounds = $draw->No_of_rounds;
			$nm = 0;
			$round_type = array();
			if($draw->Bracket_Type == "Round Robin"){
			$title_r = "#";
			}else { $title_r = "Round";}
			echo "<b><br /><br />". $draw->Draw_Title. "</b>"; ?>
			
			<div class="tab-content table-responsive">
			<table class="tab-score">

			  <tr class="top-scrore-table">
			  	<td class="score-position" valign="center" align=""><?php echo $title_r;?></td>

				<?php if($draw->Match_Type == "Doubles"){ ?>
				<td class="score-position" valign="center" align="">Team1</td>
				<td class="score-position" valign="center" align="">Team2</td>
				<?php } else { ?>
				<td class="score-position" valign="center" align="">Player1</td>
				<td class="score-position" valign="center" align="">Player2</td>
				<?php } ?>
				<td class="score-position" valign="center" align="">Score</td>
				<!-- <td class="score-position" valign="center" align="center">Winner</td>-->
				<!-- <td class="score-position" valign="center" align="center">Action</td>
 -->			 </tr>

		
		<?php  foreach($matches as $match){
			
			$player1 = "";
			$player2 = "";

			if($match->Player1 != 0){
				 $player1 = addscore::get_name(intval($match->Player1));
				 $partner1 = addscore::get_name(intval($match->Player1_Partner));
			}
			if($match->Player2 != 0){
				 $player2 = addscore::get_name(intval($match->Player2));
				 $partner2 = addscore::get_name(intval($match->Player2_Partner));
			}
			
			?>
			
			<tr>
			<td style="padding-left:8px;">
			<?php if($draw->Bracket_Type != "Round Robin"){
			$get_rd_nm = $this->model_addscore->get_num_matches($match->BracketID, $match->Round_Num);

			$rt = $get_rd_nm['count'];

				if($rt >= pow(2,3)){
					$rrt = $rt*2;
					$rd_type = "Round of $rrt";
				}
				else{
					switch($rt){
						case 1:
							$rd_type = "Final";
							break;
						case 2:
							$rd_type = "Semi-Final";
							break;
						case 4:
							$rd_type = "Quarter-Final";
							break;
						default:
							$rd_type = "-";
							break;
					}
					
				}
			}
			else
			{
				$rd_type = $match->Round_Num;
			}
			echo "<b>$rd_type</b>";
			?>
			
			</td>
				<td valign="center" style="padding-left:10px;"><b>
				<?php if($player1){ 
					echo "<a href='".base_url()."player/".$player1['Users_ID']."'>".$player1['Firstname']." ".$player1['Lastname']."</a>"; 
					if($partner1){ echo "; <a href='".base_url()."player/".$partner1['Users_ID']."'>".$partner1['Firstname']." ".$partner1['Lastname']."</a>"; }
					} else { echo "----"; }
					if($match->Winner == $match->Player1 and $match->Winner != '') {
						echo "<img id='img-winner' src='".base_url()."images/gold_medal_small.png' width='20' height='20'></img>";
					}
					?>
				</b>
				</td>
				<td valign="center" style="padding-left:10px;"><b>
				<?php if($player2){ 
						echo "<a href='".base_url()."player/".$player2['Users_ID']."'>".$player2['Firstname']." ".$player2['Lastname']."</a>"; 
					if($partner2){ echo "; <a href='".base_url()."player/".$partner2['Users_ID']."'>".$partner2['Firstname']." ".$partner2['Lastname']; }
						} else { echo "----"; }
						if($match->Winner == $match->Player2 and $match->Winner != '') {
						echo "<img id='img-winner' src='".base_url()."images/gold_medal_small.png' width='20' height='20'></img>";
						}
						?>
				</b>
				</td>

				<td valign="center" style="padding-left:10px;">
				<div>
				<?php
				$get = $this->model_addscore->get_tournment_title($match->Tourn_ID);
				$tourn_admin = $get->Usersid;

				if($match->Player1_Score !=""){
				$p1=array();$p2=array();
				$p1 = json_decode($match->Player1_Score);
				$p2 = json_decode($match->Player2_Score);

				$cnt = count(array_filter($p1));
				if($cnt > 0){
						for($i=0; $i<count(array_filter($p1)); $i++)
						{
							echo "($p1[$i] - $p2[$i]) ";
						}
					}
					else if($cnt == 0 and $match->Player1_Score != "Bye Match" and $match->Player2_Score != "Bye Match"){
							echo "Win by Forfeit ";
					}

				}

				//else if($match->Player1_Score == "Bye Match" or $match->Player2_Score == "Bye Match"){
					//echo "Bye Match";
				//}
				else if($match->Player1 != '' and  $match->Player2 != '')
				{
				if($tourn_admin ==  $this->session->userdata('users_id') and $match->Winner != '')
				{
				$chck_edit_match = addscore::check_edit_match($match->BracketID, $match->Match_Num, $match->Round_Num, $match->Draw_Type, $get->Tournament_type);

				if($chck_edit_match){
				?>
				<a id="edit" class="edit_score" href="#reg_matches" name="<?php echo $match->Tourn_match_id; ?>">Edit Score</a><!-- edit score link -->
				<?php
				}
				else { 
					echo "Edit Not Avail";
				}
				?>
			
				
				<?php
				}
				else if((($this->session->userdata('users_id') == $match->Player1) or ($this->session->userdata('users_id') == $match->Player1_Partner) or ($this->session->userdata('users_id') == $match->Player2) or ($this->session->userdata('users_id') == $match->Player2_Partner) or $tourn_admin == $this->session->userdata('users_id')) and ($match->Winner == ''))
				{
				?>

				<a id="add" class="add_score" href="#reg_matches" name="<?php echo $match->Tourn_match_id; ?>">Add score</a> 

				<?php 
				}
				}

				if($match->Player1_Score == "Bye Match" or $match->Player2_Score == "Bye Match"){
					echo "Bye Match";
				}
				?>


				</div>  
				</td>

				</tr>

				
				<!-- -----------------------------------Add/Win by forfeit blocks ---------------------------- -->
				
					<!------------Win By forfeit-------------------->
					<tr id="forfeit<?php echo $match->Tourn_match_id; ?>" style="display:none;">
					<td colspan='6'>
					<!-- <form method="post"  action="<?php echo base_url();?>league/view_matches"> -->
					<form name="form-wff" id="form-wff<?php echo $match->Tourn_match_id; ?>">
					<div class='form-group'>
						<div class='col-md-3 form-group internal' style="margin-left:35px;">

						<?php
						$get_name = addscore::get_name($match->Player1); 
						$player1_name = $get_name['Firstname'] . "  " . $get_name['Lastname'];
						?>
						<?php 
						$get_name = addscore::get_name($match->Player2);
						 $player2_name =  $get_name['Firstname'] . "  " . $get_name['Lastname'];
						?>

						<select name="id" class='form-control'>

						<option value="<?php echo $match->Player1; ?>">
						<?php echo $player1_name;

							if($partner1){ echo "; ".$partner1['Firstname']." ".$partner1['Lastname']; }
						?></option>

						<option value="<?php echo $match->Player2; ?>">
						<?php 
						echo $player2_name;

							 if($partner2){ echo "; ".$partner2['Firstname']." ".$partner2['Lastname']; }
						?>	
						</option>
						</select> 
					   </div>
				       </div>

					   <?php
							if($draw->Bracket_Type == 'Challenge Ladder'){
								$br_type_wff = "CL_WFF";
							}
							else{
								$br_type_wff = "WFF";
							}
						?>
						<input class='form-control' value="<?=$br_type_wff;?>" name="score_type" type='hidden'> 
						<input class='form-control' value="<?php echo $match->Tourn_ID;?>" id="tourn_id" name="tourn_id" type='hidden'> 
						<input class='form-control' value="<?php echo $match->BracketID;?>" id="bracket_id" name="bracket_id" type='hidden'>
						<input class='form-control' value="<?php echo $match->Match_Num;?>" id="match_num" name="match_num" type='hidden'> 
						<input class='form-control' value="<?php echo $draw->Match_Type;?>" id="match_type" name="match_type" type='hidden'> 
						<input class='form-control' value="<?php echo $match->Tourn_match_id;?>" id="tourn_match_id" name="tourn_match_id" type='hidden'>
						<input class='form-control' value="<?php echo $rd_type;?>" id="round_title" name="round_title" type='hidden'>
						<input class='form-control' value="" id="" name="draw_name" type='hidden'>

						<input class='form-control' value="<?php echo $match->Player1;?>" id="tourn_match_id" name="player1" type='hidden'>
						<input class='form-control' value="<?php echo $match->Player1_Partner;?>" id="tourn_match_id" name="player1_partner" type='hidden'>
						<input class='form-control' value="<?php echo $match->Player2;?>" id="tourn_match_id" name="player2" type='hidden'>
						<input class='form-control' value="<?php echo $match->Player2_Partner;?>" id="tourn_match_id" name="player2_partner" type='hidden'>

						<div class='form-group'>
							<div class='col-md-1 form-group internal' style="margin-left:35px;">
							 <input type="submit" name="se_add_winner" id="<?php echo $match->Tourn_match_id; ?>" value="Add Winner" class="wff_add league-form-submit1"/>
							</div>
						</div>

						</form>
						</td>
					</tr>

						<!----------------------------------------End of--Win By forfeit---------------------------------------------------------->

						<!---------------------------------------Add Score Block ----------------------------------------------->

						<tr id="score<?php echo $match->Tourn_match_id; ?>" class="tourn_match" style="display:none;">
						<td colspan='5'>
						<div>

						<!-- <form method="post" action="<?php echo base_url();?>league/view_matches"> -->
						<form name="form-addscore" id="form-addscore<?php echo $match->Tourn_match_id; ?>">

						<div class='form-group'>
							<div class='col-md-2 form-group internal' style="margin-left:12px;">
							<input type="text" class='form-control' placeholder="Date" id="sdate<?php echo $match->Tourn_match_id; ?>" name="tour_match_date" value="<?php echo date("m/d/Y"); ?>" required />
							</div>
							<script>
							$(function() {
								var spid = "<?php echo $match->Tourn_match_id; ?>";
							 $('#sdate'+spid).datepick();
							});
							</script>

						<div class='form-group'>
						<div class='col-md-8 form-group internal scoretable-web'>

						<input type='checkbox' name="<?php echo $match->Tourn_match_id; ?>" id='wff_add' class='wff_score' />&nbsp;Declare winner by Win by Forfeit

		
						<?php
						$get_name = addscore::get_name($match->Player1);
						$player1_name = $get_name['Firstname'] . "  " . $get_name['Lastname'];
						?>
						<?php
						$get_name = addscore::get_name($match->Player2); 
						 $player2_name =  $get_name['Firstname'] . "  " . $get_name['Lastname'];
						?>
						<?php
						$get_sport = $this->model_addscore->get_tournment_title($match->Tourn_ID); 
						$sport_id = $get_sport['SportsType'];
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
                                 </tr> 
								 <?php } else { ?>
								 <tr>
                                  	<th>Players</th>
									<th><?php //echo $sport_id;?>Game1</th>
                                  	<th>Game2</th>
                                  	<th>Game3</th>
                                  	<th>Game4</th>
                                    <th>Game5</th>
                                 </tr> 
								  <?php } ?>

                                 <tr>
                                  	<td bgcolor="#fdd7b0"><b><?php echo $player1_name; 
									 if($partner1){ echo "; ".$partner1['Firstname']." ".$partner1['Lastname']; }
									 ?></b></td>
									<td><input id='set1_1' name='player1[]' style = "width:45%" type='text' maxlength='2' /></td>
                                  	<td><input id='set1_1' name='player1[]' style = "width:45%" type='text' maxlength='2' /></td>
									<td><input id='set1_1' name='player1[]' style = "width:45%" type='text' maxlength='2' /></td>
									<td><input id='set1_1' name='player1[]' style = "width:45%" type='text' maxlength='2' /></td>
                                    <td><input id='set1_1' name='player1[]' style = "width:45%" type='text' maxlength='2' /></td>

								 </tr>
                                  <tr>
                                  	<td bgcolor="#fdd7b0"><b><?php echo $player2_name; 
									 if($partner2){ echo "; ".$partner2['Firstname']." ".$partner2['Lastname']; }
									?></b></td>
									<td><input id='set1_2' name='player2[]' style = "width:45%" type='text' maxlength='2' /></td>
                                  	<td><input id='set1_2' name='player2[]' style = "width:45%" type='text' maxlength='2' /></td>
									<td><input id='set1_2' name='player2[]' style = "width:45%" type='text' maxlength='2' /></td>
									<td><input id='set1_2' name='player2[]' style = "width:45%" type='text' maxlength='2' /></td>
                                    <td><input id='set1_2' name='player2[]' style = "width:45%" type='text' maxlength='2' /></td>
									
								 </tr>
							</table> 
	
						    </div>
						   </div>

			  <!-- ---------------Mobile view------------------------------------------------------- -->
					<div class="scoretable-mob table-responsive">
					<input type='checkbox' name="<?php echo $match->Tourn_match_id; ?>" id='wff_add' class='wff_score' />
					&nbsp;Declare winner by Win by Forfeit

						<table class="score-cont">
								<tr>
									<th>Players</th>
									<th bgcolor="#fdd7b0"><b><?php echo $player1_name;  if($partner1){ echo "; ".$partner1['Firstname']." ".$partner1['Lastname']; } ?></b></th>
									<th bgcolor="#fdd7b0"><b><?php echo $player2_name; if($partner2){ echo "; ".$partner2['Firstname']." ".$partner2['Lastname']; }?></b></th>
									<?php if($sport_id == 1){
											$set_or_game = 'Set';
										   }
										  else
										  {
											  $set_or_game = 'Game';
										  }
									?>
					           </tr>
					  <tr>
						<td>
							<?php echo $set_or_game . "1"; ?>
						</td>
						<td><input id='set1_1' name='player1[]' style = "width:25%" type='text' maxlength='2' /></td>
						<td><input id='set1_2' name='player2[]' style = "width:25%" type='text' maxlength='2' /></td>
						</tr>
						<tr>
						<td>
							<?php echo $set_or_game . "2"; ?>
						</td>
						<td><input id='set2_1' name='player1[]' style = "width:25%" type='text' maxlength='2' /></td>
						<td><input id='set2_2' name='player2[]' style = "width:25%" type='text' maxlength='2' /></td>
						</tr>
						<tr>
						<td>
							<?php echo $set_or_game . "3"; ?>
						</td>
						<td><input id='set3_1' name='player1[]' style = "width:25%" type='text' maxlength='2' /></td>
						<td><input id='set3_2' name='player2[]' style = "width:25%" type='text' maxlength='2' /></td>
						</tr>
						<tr>
						<td>
							<?php echo $set_or_game . "4"; ?>
						</td>
						<td><input id='set4_1' name='player1[]' style = "width:25%" type='text' maxlength='2' /></td>
						<td><input id='set4_2' name='player2[]' style = "width:25%" type='text' maxlength='2' /></td>
						</tr>
						<tr>
						<td>
							<?php echo $set_or_game . "5"; ?>
						</td>
						<td><input id='set5_1' name='player1[]' style = "width:25%" type='text' maxlength='2' /></td>
						<td><input id='set5_2' name='player2[]' style = "width:25%" type='text' maxlength='2' /></td>
						</tr>

			     </table>
		      </div>
				<!-- ---------------Mobile view------------------------------------------------------- -->

						   <?php
						   $br_type = "";

							switch($draw->Bracket_Type){
							case 'Single Elimination':
								$br_type = "SE_ADDSCORE";
							break;

							case 'Consolation':
								if($match->Draw_Type == 'Main'){
								$br_type = "CD_ADDSCORE"; }
								else if($match->Draw_Type == 'Consolation'){
								$br_type = "CD_CD_ADDSCORE"; }
							break;

							case 'Round Robin':
								$br_type = "ADDSCORE";
							break;

							case 'Challenge Ladder':
								$br_type = "CL_ADDSCORE";
							break;

							}

						   ?>
						 <input class='form-control' value="<?php echo $br_type; ?>" name="score_type" type='hidden'> 
						<input class='form-control' value="<?php echo $match->Player1;?>" id="player1_user" name="player1_user" type='hidden'>
						<input class='form-control' value="<?php echo $match->Player1_Partner;?>" id="player1_user_partner" name="player1_user_partner" type='hidden'>

						<input class='form-control' value="<?php echo $match->Player2; ?>" id="player2_user" name="player2_user" type='hidden'>
					    <input class='form-control' value="<?php echo $match->Player2_Partner; ?>" id="player2_user_partner" name="player2_user_partner" type='hidden'>

						<input class='form-control' value="<?php echo $match->Tourn_ID;?>" id="tourn_id" name="tourn_id" type='hidden'>
						<input class='form-control' value="<?php echo $match->BracketID;?>" id="bracket_id" name="bracket_id" type='hidden'>
						<input class='form-control' value="<?php echo $match->Match_Num;?>" id="match_num" name="match_num" type='hidden'>
						<input class='form-control' value="<?php echo $draw->Match_Type;?>" id="match_type" name="match_type" type='hidden'>
						<input class='form-control' value="<?php echo $match->Tourn_match_id;?>" id="tourn_match_id" name="tourn_match_id" type='hidden'>
						<input class='form-control' value="<?php echo $rd_type;?>" id="round_title" name="round_title" type='hidden'>
						<input class='form-control' value="" id="" name="draw_name" type='hidden'>


						<div class='form-group'>
						<div class='col-md-1 form-group internal' style="margin-left:35px;">
						 <input name="add_match_score" id="<?php echo $match->Tourn_match_id;?>" type="submit" value="Add" class="add_score_ajax league-form-submit"/>
						</div>
						</div>

						</form>
						</div>
						</td>
					</tr>


				
				<!-- ------------------------------------------End of  score Blocks----------------------------------------- -->

	        <?php } ?>
			</table>
			 </div>
	     <?php  $a++; }
		 else
		{
				if(count($arr_data) == $a++)
				{
				echo "<div style='margin-left:260px;' class='form-group' id='no_result'><br /><b>No matches found to add score.</b></div>";
				exit;
				}
		}
	  }
	}
}
?>