<script src="<?php echo base_url();?>js/jquery.accordion.js" type="text/javascript"></script>
<script type="text/javascript">
$(document).ready(function () {
$(function () {
"use strict";
$('.accordion').accordion({ defaultOpen: 'section3' }); //some_id section1 in demoup_tour_section
});
});
</script>

<script>
$(document).ready(function(){
   
	$(".add_score").click(function(){

		var pid = $(this).attr('name');
		if($("#score"+pid).css('display')=='none'){
         $("#score"+pid).show();
		}else{
        $("#score"+pid).hide();
        }
    });
	
});
</script>

<section id="single_player" class="container secondary-page" style="background:#fff;">

<div class="top-score-title right-score col-md-9" style="background:#fff;">  

<div class="col-md-12 league-form-bg" style="margin-top:40px; background:#fff; margin-bottom:20px">
<div class="fromtitle">My Sports</div>
<p style="line-height:20px; font-size:13px">Here you can find your upcoming matches and tournaments that may interest you. You can also find all your past matches and tournaments.</p>

<?php if($this->session->userdata('user')=="") { ?>
				
<p style="line-height:5px; font-size:13px">Please <a href='<?php echo base_url()."login"; ?>'><b>Login</b> </a>to find Upcoming Matches</p>
<?php } ?>



</div>
<div style="clear:both"></div>
<!-- <h4>Upcoming Matches</h4> -->

<?php 
if(isset($reg)) { ?>
	   <div class="name" align='left'>
			<label for="name_login" style="color:green"><?php echo $reg; ?></label>
	   </div>
<?php } ?>

<?php 
if(isset($create_tourn)) { ?>
	   <div class="name" align='left'>
			<label for="name_login" style="color:green"><?php echo $create_tourn; ?></label>
	   </div>
<?php } ?>


<!--  USER SESSION IS NOT EMPTY SHOW ALL CONTENT -->
<?php if($this->session->userdata('user')!="") { ?>

<!-- My created Events section   -->

<div class="col-md-12 league-form-bg" style="margin-top:40px; margin-bottom:20px;">

<div class="accordion" id="up_match_section" style="background:#f59123; padding:5px; color:white;"><i class="fa fa-arrow-circle-o-right" style="color:white;"> </i>Scheduled Events<span></span></div>


<div class="tab-content">
<table class="tab-score">

<tr class="top-scrore-table">
<td class="score-position" valign="center" align="center">Event</td>
<td class="score-position" valign="center" align="center">Duration</td>
<td class="score-position" valign="center" align="center">Invited By</td>
</tr>

<?php 
$out_evnts = array_map("unserialize", array_unique(array_map("serialize", $user_created_events)));
if(count($out_evnts) == 0)
{
?>
<tr>
<td colspan='3' style="padding-left:5px;"><h5>No Events found.</h5></td>
</tr>
<?php
}
else 
{
//print_r($input);

foreach($out_evnts as $row){ 
	
	$user_id = $this->session->userdata('users_id');
?>
<tr>
<td valign="center" style="padding-left:5px;"><b>
<a href="<?php echo base_url();?>events/view/<?php echo $row->Ev_ID;?>">
<?php echo $row->Ev_Title; ?>
</a></b>
</td>

<td valign="center" align="center">
<?php if($row->Ev_Schedule == 'singleday'){
echo date('m/d/Y',strtotime($row->Ev_Start_Date));
} else { 	
echo date('m/d/Y',strtotime($row->Ev_Start_Date))." - ".date('m/d/Y',strtotime($row->Ev_End_Date));	
}?>
</td>

<td valign="center" style="padding-left:5px;">
<div><?php $get_user = $this->general->get_user($row->Ev_Created_by); 
echo $get_user['Firstname']." ".$get_user['Lastname'];
?></div>  
</td>

 </tr>

<?php
	}
}
?>
</table>
</div>
</div>

<!-- end of My created Events section   -->


<div style="clear:both"></div>

<!-- -------------------------------------------- -->

<!-- New Challenges Section start-->
<div class="col-md-12 league-form-bg" style="margin-top:40px; margin-bottom:20px;">

<div class="accordion" id="up_match_section" style="background:#f59123; padding:5px; color:white;"><i class="fa fa-arrow-circle-o-right" style="color:white;"> </i>New Challenges<span></span></div>

<div class="tab-content">
<table class="tab-score">

<tr class="top-scrore-table">
<td class="score-position" valign="center" align="center">Created By</td>
<td class="score-position" valign="center" align="center">Match Name</td>
<td class="score-position" valign="center" align="center">Action</td>
</tr>

<?php 
if(count($matches) == 0 and count($visible_matches) == 0)
{
	?>
<tr>
<td colspan='3' style="padding-left:5px;"><h5>No Challenges found close to your location.</h5></td>
</tr>
<?php
}
else 
{

foreach($visible_matches as $row){ 
	
	$user_id = $this->session->userdata('users_id');
	$allowed_users = json_decode($row->Allowed_Users);

if(in_array($user_id,$allowed_users) or $row->users_id == $user_id){?>
<tr>
<td valign="center" style="padding-left:5px;"><a href="<?php echo base_url();?>player/<?php echo $row->users_id;?>"><b>
<?php $get_username = play::get_user($row->users_id); 
echo $get_username['Firstname']." ".$get_username['Lastname']; ?>
</a></b></td>

<td valign="center" style="padding-left:5px;">
<p></p>

<div class="col-md-1" style=""></div>
<p style="font-size:14px"><a href="<?php echo base_url();?>play/match/<?php echo $row->GeneralMatch_id;?>"><?php echo $row->Match_Title;?></a>

<?php 
$get_sport = play::get_sport($row->Sports);
echo "(" .$get_sport['Sportname']. ")";
?>
</p>
                         
</td>


<td valign="center" align="center">
<div>
<?php if(($this->session->userdata('user')!="") && ($row->users_id == $this->session->userdata('users_id'))) { ?> 

<?php } else 
 { ?>
<a href="<?php echo base_url();?>play/register/<?php echo $row->GeneralMatch_id;?>">Register</a>
<?php } ?>
</div>  
<!-- <?php echo base_url();?>Register-match -->


<div>

<?php if(($this->session->userdata('user')!="") && ($row->users_id == $this->session->userdata('users_id'))) {?>
<a href="<?php echo base_url();?>play/match/<?php echo $row->GeneralMatch_id;?>">Edit</a>
<?php } ?> 

</div>
</td>
</tr>

<?php } }

//

foreach($matches as $row){ 
 ?>
<tr>
<td valign="center" style="padding-left:5px;"><a href="<?php echo base_url();?>player/<?php echo $row->users_id;?>"><b>
<?php $get_username = play::get_user($row->users_id); 
echo $get_username['Firstname']." ".$get_username['Lastname']; ?>
</a></b></td>

<td valign="center" style="padding-left:5px;">
<p></p>

<div class="col-md-1" style=""></div>
<p style="font-size:14px"><a href="<?php echo base_url();?>play/match/<?php echo $row->GeneralMatch_id;?>"><?php echo $row->Match_Title;?></a>

<?php 
$get_sport = play::get_sport($row->Sports);
echo "(" .$get_sport['Sportname'] . ")";
?>
</p>
                         
</td>


<td valign="center" align="center">
<div>
<?php if(($this->session->userdata('user')!="") && ($row->users_id == $this->session->userdata('users_id'))) { ?> 

<?php } else 
 { ?>
<a href="<?php echo base_url();?>play/register/<?php echo $row->GeneralMatch_id;?>">Register</a>
<?php } ?>
</div>  
<!-- <?php echo base_url();?>Register-match -->


<div>

<?php if(($this->session->userdata('user')!="") && ($row->users_id == $this->session->userdata('users_id'))) {?>
<a href="<?php echo base_url();?>play/match/<?php echo $row->GeneralMatch_id;?>">Edit</a>
<?php } ?> 

</div>
</td>
</tr>

<?php } 

}
?>

</table>
</div>
</div>


<!-- End of New matches section -->


<div style="clear:both"></div>



<!-- start section for ready to play matches  -->

<div class="col-md-12 league-form-bg" style="margin-top:40px; margin-bottom:20px;">

<div class="accordion" id="up_match_section" style="background:#f59123; padding:5px; color:white;"><i class="fa fa-arrow-circle-o-right" style="color:white;"> </i>Ready To Play<span></span></div>

<div class="tab-content">

<table class="tab-score">

<tr class="top-scrore-table">
<td class="score-position" valign="center" align="center">Match Name</td>
<td class="score-position" valign="center" align="center">Sport Type</td>
<td class="score-position" valign="center" align="center">Action</td>
</tr>

<?php 
if(count($user_owner_matches) == 0 && count($user_reg_matches) == 0)
{
	?>
<tr>
<td colspan='3' style="padding-left:5px;"><h5>No Registered Matches are found.</h5></td>
</tr>
<?php
}
else
{
foreach($user_owner_matches as $row) { ?>
<tr>
<td valign="center" style="padding-left:5px;">
<a href='<?php echo base_url()."Play/reg_match/".$row->Play_id; ?>'><b><?php echo $row->Play_Title; ?></a></b>
</td>

<td valign="center" style="padding-left:5px;">
<p style="font-size:14px">
<?php 
$get = play::get_sport_name($row->GeneralMatch_ID);

$sport = $get['Sports'];
$get_sport = play::get_sport($sport);
echo $get_sport['Sportname'];
?>
</p>                          
</td>

<?php

$get = play::get_sport_name($row->GeneralMatch_ID);

$owner = $get['users_id'];

if($owner != $this->session->userdata('users_id') )
{
?>
<td valign="center" align="center"></td>
<?php
}
else
{
?>
<td valign="center" align="center">
<div>
<a id="add" class="add_score" href="#reg_matches" name="<?php echo $row->Play_id; ?>">Add score </a>
</div>
</td>
<?php
}
?>
</tr>


<tr id="score<?php echo $row->Play_id; ?>" style="display:none;">

<td colspan='5'>
<div>
<form method="post"  action="<?php echo base_url();?>play/update_score_data/<?php echo $row->Play_id; ?>">
	<div class='form-group'>
	<div class='col-md-2 form-group internal'>
	<input  type="text" class='form-control' placeholder="Date" id="sdate<?php echo $row->Play_id; ?>"  name="match_date" required /> 
	</div>
<script>
$(function(){
	var spid = "<?php echo $row->Play_id; ?>";
 $('#sdate'+spid).datepick();
});
</script>

	<div class='form-group'>
	<div class='col-md-8 form-group internal scoretable-web'>
		
		<?php
		$get_opp_name = play::get_gen_mat_det($row->GeneralMatch_ID);
		$match_type = $get_opp_name['Match_Type'];

		$get_name1 = play::get_user($get_opp_name['users_id']);
		$player1_name = $get_name1['Firstname'] . $get_name1['Lastname'];

		$get_partner1 = play::get_user($get_opp_name['Player1_Partner']);
		$player1_partner_name = $get_partner1['Firstname'] . $get_partner1['Lastname'];

		$get_name2 = play::get_user($row->Opponent);
		$player2_name = $get_name2['Firstname'] . $get_name2['Lastname'];

		$get_partner2 = play::get_user($row->Player2_Partner);
		$player2_partner_name = $get_partner2['Firstname'] . $get_partner2['Lastname'];

		if($match_type == "Doubles"){
			$p = $player1_name . "; " . $player1_partner_name;
			$p1 = $player2_name . "; " . $player2_partner_name;
		}else
		{
			$p = $player1_name;
			$p1 = $player2_name;
		}

		?>

			  <table class="score-cont">
                                  <?php if($sport == 1){ ?>
								  <tr>
                                  	<th>Players</th>
									<th>Set1</th>
                                  	<th>Set2</th>
                                  	<th>Set3</th>
                                  	<th>Set4</th>
                                    <th>Set5</th>
									
                                 </tr> <?php } else {?>
								  <tr>
                                  	<th>Players</th>
									<th>Game1</th>
                                  	<th>Game2</th>
                                  	<th>Game3</th>
                                  	<th>Game4</th>
                                    <th>Game5</th>
					
                                 </tr>
									<?php } ?>

                                 <tr>
                                  	<td bgcolor="#fdd7b0"><b><?php echo $p; ?></b></td>
									<td><input id='set1_1' name='player1[]' style = "width:65%" type='text' maxlength='2' /></td>
                                  	<td><input id='set1_1' name='player1[]' style = "width:65%" type='text' maxlength='2' /></td>
									<td><input id='set1_1' name='player1[]' style = "width:65%" type='text' maxlength='2' /></td>
									<td><input id='set1_1' name='player1[]' style = "width:65%" type='text' maxlength='2' /></td>
                                    <td><input id='set1_1' name='player1[]' style = "width:65%" type='text' maxlength='2' /></td>

								 </tr>
                                  <tr>
                                  	<td bgcolor="#fdd7b0"><b><?php echo $p1; ?></b></td>
									<td><input id='set1_2' name='player2[]' style = "width:65%" type='text' maxlength='2' /></td>
                                  	<td><input id='set1_2' name='player2[]' style = "width:65%" type='text' maxlength='2' /></td>
									<td><input id='set1_2' name='player2[]' style = "width:65%" type='text' maxlength='2' /></td>
									<td><input id='set1_2' name='player2[]' style = "width:65%" type='text' maxlength='2' /></td>
                                    <td><input id='set1_2' name='player2[]' style = "width:65%" type='text' maxlength='2' /></td>
									
								 </tr>
      </table> 
	</div>
	</div>
				<!-- ---------------Mobile view------------------------------------------------------- -->
			<div class="scoretable-mob">
				<table class="score-cont">
						<tr>
							<th><span id="format"></span></th>
							<th bgcolor="#fdd7b0"><b><?php echo $p; ?></b></th>
							<th bgcolor="#fdd7b0"><b><?php echo $p1; ?></b></th>
							<?php if($sport == 1){
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
			
	<input class='form-control' value="<?php echo $row->Opponent;?>" id="opp_user" name="opp_user" type='hidden'>
	<input class='form-control' value="<?php echo $row->GeneralMatch_ID;?>" id="gen_match_id" name="gen_match_id" type='hidden'>

	<div class='form-group'>
	<div class='col-md-2 form-group internal'>
	 <input name="submit" type="submit" value="Add" class="league-form-submit"/>
	</div>
	</div>

</form>
</div>
</td>
</tr>


<?php }

}
?>




<!-- ----------------------------------------------------------------------------------------------- -->
<!-- Start of registered matches -->


<?php
foreach($user_reg_matches as $row) { ?>
<tr>
<td valign="center" style="padding-left:5px;">
<a href='<?php echo base_url()."Play/reg_match/".$row->Play_id; ?>'><b><?php echo $row->Play_Title; ?></a></b>
</td>

<td valign="center" style="padding-left:5px;">
<p style="font-size:14px">
<?php 
$get = play::get_sport_name($row->GeneralMatch_ID);

$sport = $get['Sports'];
$get_sport = play::get_sport($sport);
echo $get_sport['Sportname'];
?>
</p>                          
</td>

<?php
$get = play::get_sport_name($row->GeneralMatch_ID);

$owner = $get['users_id'];
if($owner != $this->session->userdata('users_id') )
{
?>
<td valign="center" align="center">
<?php if($row->Winner != ""){ ?>
<b><a href="">View-Score</a></b>

<?php } else { ?>

<!-- <b>Yet to add score</b> -->
<div>
<a id="add" class="add_score" href="#reg_matches" name="<?php echo $row->Play_id; ?>">Add score </a>
</div>
<?php } ?>
</td>
<?php
}
else
{
?>
<td valign="center" align="center">
<div>
<a id="add" class="add_score" href="#reg_matches" name="<?php echo $row->Play_id; ?>">Add score </a>
</div>
</td>
<?php
}
?>
</tr>



<tr id="score<?php echo $row->Play_id; ?>" style="display:none;">
<td colspan='5'>
<div>


<form method="post"  action="<?php echo base_url();?>play/update_score_data/<?php echo $row->Play_id; ?>">
	<div class='form-group'>
	<div class='col-md-2 form-group internal'>
	<input  type="text" class='form-control' placeholder="Date" id="sdate<?php echo $row->Play_id; ?>"  name="match_date" required /> 
	</div>
<script>
$(function() {
	var spid = "<?php echo $row->Play_id; ?>";
 $('#sdate'+spid).datepick();
});
</script>


	<div class='form-group'>
	<div class='col-md-8 form-group internal scoretable-web'>

	<?php
		$get_opp_name = play::get_gen_mat_det($row->GeneralMatch_ID);
		$match_type = $get_opp_name['Match_Type'];

		$get_name1 = play::get_user($get_opp_name['users_id']);
		$player1_name = $get_name1['Firstname'] . $get_name1['Lastname'];

		$get_partner1 = play::get_user($get_opp_name['Player1_Partner']);
		$player1_partner_name = $get_partner1['Firstname'] . $get_partner1['Lastname'];

		$get_name2 = play::get_user($row->Opponent);
		$player2_name = $get_name2['Firstname'] . $get_name2['Lastname'];

		$get_partner2 = play::get_user($row->Player2_Partner);
		$player2_partner_name = $get_partner2['Firstname'] . $get_partner2['Lastname'];

		if($match_type == "Doubles"){
			$p = $player1_name . "; " . $player1_partner_name;
			$p1 = $player2_name . "; " . $player2_partner_name;
		}else
		{
			$p = $player1_name;
			$p1 = $player2_name;
		}
	?>


		  <table class="score-cont">
                                  <?php if($sport == 1){ ?>
								  <tr>
                                  	<th>Players</th>
									<th>Set1</th>
                                  	<th>Set2</th>
                                  	<th>Set3</th>
                                  	<th>Set4</th>
                                    <th>Set5</th>
									
                                 </tr> <?php } else {?>
								  <tr>
                                  	<th>Players</th>
									<th>Game1</th>
                                  	<th>Game2</th>
                                  	<th>Game3</th>
                                  	<th>Game4</th>
                                    <th>Game5</th>
									
                                 </tr>
									<?php } ?>

                                 <tr>
                                  	<td bgcolor="#fdd7b0"><b><?php echo $p; ?></b></td>
									<td><input id='set1_1' name='player1[]' style = "width:65%" type='text' maxlength='2' /></td>
                                  	<td><input id='set1_1' name='player1[]' style = "width:65%" type='text' maxlength='2' /></td>
									<td><input id='set1_1' name='player1[]' style = "width:65%" type='text' maxlength='2' /></td>
									<td><input id='set1_1' name='player1[]' style = "width:65%" type='text' maxlength='2' /></td>
                                    <td><input id='set1_1' name='player1[]' style = "width:65%" type='text' maxlength='2' /></td>

								 </tr>
                                  <tr>
                                  	<td bgcolor="#fdd7b0"><b><?php echo $p1; ?></b></td>
									<td><input id='set1_2' name='player2[]' style = "width:65%" type='text' maxlength='2' /></td>
                                  	<td><input id='set1_2' name='player2[]' style = "width:65%" type='text' maxlength='2' /></td>
									<td><input id='set1_2' name='player2[]' style = "width:65%" type='text' maxlength='2' /></td>
									<td><input id='set1_2' name='player2[]' style = "width:65%" type='text' maxlength='2' /></td>
                                    <td><input id='set1_2' name='player2[]' style = "width:65%" type='text' maxlength='2' /></td>
									
								 </tr>
      </table> 


	</div>
	</div>

	<!-- ---------------Mobile view------------------------------------------------------- -->
			<div class="scoretable-mob">
				<table class="score-cont">
						<tr>
							<th><span id="format"></span></th>
							<th bgcolor="#fdd7b0"><b><?php echo $p; ?></b></th>
							<th bgcolor="#fdd7b0"><b><?php echo $p1; ?></b></th>
							<?php if($sport == 1){
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


	<input class='form-control' value="<?php echo $row->Opponent;?>" id="opp_user" name="opp_user" type='hidden'>
	<input class='form-control' value="<?php echo $row->GeneralMatch_ID;?>" id="gen_match_id" name="gen_match_id" type='hidden'>

	<div class='form-group'>
	<div class='col-md-2 form-group internal'>
	 <input name="submit" type="submit" value="Add" class="league-form-submit"/>
	</div>
	</div>

</form>
</div>
</td>
</tr>
<!-- --------------- -->

<!---

REMOVED SECTION 

-->

<?php } ?>
<!--end of registered matches -->
<!-- ------------------------------------------------------------------------------------------------- -->

</table>

</div>

</div>

<!-- end of ready to play matches  -->



<!-- Tournament Matches Section Start -->

<div class="col-md-12 league-form-bg" style="margin-top:40px; margin-bottom:20px;">

<div class="accordion"  id="up_match_section"  style="background:#f59123; padding:5px; color:white;"><i class="fa fa-arrow-circle-o-right" style="color:white;"> </i>Registered Tournaments<span></span></div>



<div class="tab-content">

<table class="tab-score">

<tr class="top-scrore-table">
<td class="score-position" valign="center" align="center">Tournament Name</td>
<td class="score-position" valign="center" align="center">Sport Type</td>
<td class="score-position" valign="center" align="center">Action</td>
</tr>

<?php 
if(count($user_reg_tournament_matches) == 0 )
{
	?>
<tr>
<td colspan='3'><h5>No Tournament Matches are found.</h5></td>
</tr>
<?php
}
else
{
foreach($user_reg_tournament_matches as $row) { ?>
<tr>
<td valign="center" style="padding-left:5px;">
<a href='<?php echo base_url(); ?>league/view/<?php echo $row->tournament_ID;?>'><b><?php echo $row->tournament_title;?></a></b>
</td>

<td valign="center" style="padding-left:5px;">
<p style="font-size:14px">
<?php 
$get_sport = play::get_sport($row->SportsType);
echo $get_sport['Sportname'];
?>
</p>                          
</td>


<td valign="center" align="center">
<div>
<a id="add" href="<?php echo base_url(). "league/viewbracket/" .$row->tournament_ID; ?>" name="">View Bracket</a>
</div>
</td>


</tr>

<?php }} ?>


</table>
</div>
</div>


<!-- End of Tournament Matches Section -->


<!-- Tournament Div Start -->

<div class="col-md-12 league-form-bg" style="margin-top:40px; margin-bottom:20px;">

<div class="accordion" id="up_match_section" style="background:#f59123; padding:5px; color:white;"><i class="fa fa-arrow-circle-o-right" style="color:white;"> </i>Upcoming Tournaments<span></span></div>


<div class="tab-content">

<table class="tab-score">

<tr class="top-scrore-table">
<td class="score-position" valign="center" align="center">Starts On</td>
<td class="score-position" valign="center" align="center">Tournament</td>

<!--
<td class="score-position" valign="center" align="center">Location</td>
<td class="score-position" valign="center" align="center">Entries Close</td>
-->

<td class="score-position" valign="center" align="center">Action</td>
</tr>

<?php 
//echo "dff".count($tournments);
if(count($tournments) == 0 and count($visible_tournments) == 0)
{
	?>
<tr>
<td colspan='3' style="padding-left:5px;"><h5>No Upcoming tournaments are found near to your location.</h5></td>
</tr>
<?php
}
else
{
foreach($visible_tournments as $row){ 
	
	$chk_tourn = play::check_tourn($row->tournament_ID);
    if(!$chk_tourn){

		$access_groups = json_decode($row->Access_Groups);
		$items = count(array_filter($access_groups));
		$i = 0;
		if($items > 0)
		{
			$xyz = "";
			foreach($access_groups as $row)
			{
				$xyz .= "'$row'";
					if(++$i != $items) {
						$xyz .= ",";
					}
				}
		} 

		$check_visible = array();
		$check_visible = play::check_access_group($access_groups);
		$user_id = $this->session->userdata('users_id');
		
	    if(in_array($user_id,$check_visible)){
?>

<tr>
<td valign="center" align="center" ><?php echo date('m/d/Y',strtotime(substr($row->StartDate,0,10))) ;?></td>
<td valign="center"">
<p></p>

<div class="col-md-4" style="">

<img class="img-djoko" src="<?php echo base_url(); ?>tour_pictures/<?php if($row->TournamentImage!=""){echo $row->TournamentImage; }
  	else {
		switch($row->SportsType) {
			case 1:
			echo "default_tennis.jpg";
			break;
			case 2:
			echo "default_table_tennis.jpg";
			break;
			case 3:
			echo "default_badminton.jpg";
			break;
			case 4:
			echo "default_golf.jpg";
			break;
			case 5:
			echo "default_racquet_ball.jpg";
			break;
			case 6:
			echo "default_squash.jpg";
			break;
			default:
			echo "";
			}
	}
		
	?>" alt=""  width="500px" height="500px"  />

</div>



<p style="font-size:16px"><a href="<?php 
if(($row[0]->Short_Code != '' and $row[0]->Short_Code != NULL)){
	echo base_url().$row->Short_Code; } 
else{ 
	echo base_url().'league/view/'.$row->tournament_ID; }
?>"><?php echo $row->tournament_title;?></a></p>
<p><strong>Sport:</strong> <?php 
$get_sport = play::get_sport($row->SportsType);
echo $get_sport['Sportname'];
?>
<?php
echo "(";
$option_array = json_decode($row->Singleordouble);										
$numItems = count($option_array);

$i = 0;
	if($numItems > 0){
		foreach($option_array as $sport){
			echo $sport;

			if(++$i != $numItems) {
				echo ", ";
			}
		}
	}

echo ")";

?>                
</p>                          
<!-- <p><strong>Period:</strong>  <?php //echo date('m/d/Y',strtotime(substr($row->StartDate,0,10))); ?> - 
<?php //echo date('m/d/Y',strtotime(substr($row->EndDate,0,10))); ?></p> -->

<p><strong>Registration closed on:</strong> <?php echo date('m/d/Y',strtotime(substr($row->Registrationsclosedon,0,10))); ?></p>
<p><strong>Location:</strong> <?php echo $row->TournamentCity. ',' . $row->TournamentState; ?></p>
<p></p>
</td>

<td valign="center" align="center">
<div>
<?php if(($this->session->userdata('user')!="") && ($row->Usersid != $this->session->userdata('users_id'))) {
	$now =  strtotime("now"); $oneday = 86400;
	$reg_close = strtotime($row->Registrationsclosedon) + $oneday;

   if($now < $reg_close){
	 ?>
     <a href="<?php echo base_url();?>league/register_match/<?php echo $row->tournament_ID;?>">Register</a>
   <?php 
   }
   else
	{
   ?>
   
    <a style="color:red;">Registrations <br /> Closed</a>  
  <?php
	}
   } ?> 

</div>  


<div>
<?php if(($this->session->userdata('user')!="") && ($row->Usersid == $this->session->userdata('users_id'))) {?>
<a href="<?php echo base_url();?>league/edit/<?php echo $row->tournament_ID;?>">Edit</a>
<?php } ?> 
</div>

<div> 
<?php if(($this->session->userdata('user')!="") && ($row->Usersid == $this->session->userdata('users_id')) && $row->SportsType != 4) {
  ?>
<a href="<?php echo base_url();?>league/fixtures/<?php echo $row->tournament_ID;?>">Create Draws</a><?php } ?> 
</div>

<div>
<?php if(($this->session->userdata('user')!="") && ($row->Usersid == $this->session->userdata('users_id'))) {?>
<a href="<?php echo base_url();?>play/invite/<?php echo $row->tournament_ID;?>">Invite Players</a><?php } ?> 
</div> 

<div>
<?php if(($this->session->userdata('user')!="") && ($row->Usersid == $this->session->userdata('users_id'))) {?>
<a href="<?php echo base_url();?>play/reg_players/<?php echo $row->tournament_ID;?>">Register Players</a><?php } ?>
</div> 
</td>
</tr>

<?php } } }  ?>

<?php 
foreach($tournments as $row){ 

	$chk_tourn = play::check_tourn($row->tournament_ID);
    if(!$chk_tourn){

?>

<tr>
<td valign="center" align="center" ><?php echo date('m/d/Y',strtotime(substr($row->StartDate,0,10))) ;?></td>
<td valign="center" align="center">
<p></p>

<div class="col-md-4" style="">

<img class="img-djoko" src="<?php echo base_url(); ?>tour_pictures/<?php if($row->TournamentImage!=""){echo $row->TournamentImage; }
  	else {
		switch($row->SportsType) {
			case 1:
			echo "default_tennis.jpg";
			break;
			case 2:
			echo "default_table_tennis.jpg";
			break;
			case 3:
			echo "default_badminton.jpg";
			break;
			case 4:
			echo "default_golf.jpg";
			break;
			case 5:
			echo "default_racquet_ball.jpg";
			break;
			case 6:
			echo "default_squash.jpg";
			break;
			default:
			echo "";
			}
	}
		
	?>" alt=""  width="500px" height="500px"  />

</div>



<p style="font-size:16px"><a href="<?php echo base_url();?>league/view/<?php echo $row->tournament_ID;?>"><?php echo $row->tournament_title;?></a></p>
<p><strong>Sport:</strong> <?php 
$get_sport = play::get_sport($row->SportsType);
echo $get_sport['Sportname'];
?>
<?php
echo "(";
$option_array = json_decode($row->Singleordouble);										
$numItems = count($option_array);

$i = 0;
	if($numItems > 0){
		foreach($option_array as $sport){
			echo $sport;

			if(++$i != $numItems) {
				echo ", ";
			}
		}
	}

echo ")";

?>                
</p>                          
<!-- <p><strong>Period:</strong>  <?php //echo date('m/d/Y',strtotime(substr($row->StartDate,0,10))); ?> - 
<?php //echo date('m/d/Y',strtotime(substr($row->EndDate,0,10))); ?></p> -->

<p><strong>Registration closed on:</strong> <?php echo date('m/d/Y',strtotime(substr($row->Registrationsclosedon,0,10))); ?></p>
<p><strong>Location:</strong> <?php echo $row->TournamentCity. ',' . $row->TournamentState; ?></p>
<p></p>
</td>

<td valign="center" align="center">
<div>
<?php if(($this->session->userdata('user')!="") && ($row->Usersid != $this->session->userdata('users_id'))) {
	$now =  strtotime("now"); $oneday = 86400;
	$reg_close = strtotime($row->Registrationsclosedon) + $oneday;

   if($now < $reg_close){
	 ?>
     <a href="<?php echo base_url();?>league/register_match/<?php echo $row->tournament_ID;?>">Register</a>
   <?php 
   }
   else
	{
   ?>
   
    <a style="color:red;">Registrations <br /> Closed</a>  
  <?php
	}
   } ?> 

</div>  


<div>
<?php if(($this->session->userdata('user')!="") && ($row->Usersid == $this->session->userdata('users_id'))) {?>
<a href="<?php echo base_url();?>league/edit/<?php echo $row->tournament_ID;?>">Edit</a>
<?php } ?> 
</div>

<div> 
<?php if(($this->session->userdata('user')!="") && ($row->Usersid == $this->session->userdata('users_id')) && $row->SportsType != 4) {
  ?>
<a href="<?php echo base_url();?>league/fixtures/<?php echo $row->tournament_ID;?>">Create Draws</a><?php } ?> 
</div>

<div>
<?php if(($this->session->userdata('user')!="") && ($row->Usersid == $this->session->userdata('users_id'))) {?>
<a href="<?php echo base_url();?>play/invite/<?php echo $row->tournament_ID;?>">Invite Players</a><?php } ?> 
</div> 

<div>
<?php if(($this->session->userdata('user')!="") && ($row->Usersid == $this->session->userdata('users_id'))) {?>
<a href="<?php echo base_url();?>play/reg_players/<?php echo $row->tournament_ID;?>">Register Players</a><?php } ?>
</div> 
</td>
</tr>

<?php } }


}
?>

</table>
</div>
</div>

<!-- end main body -->
 
<div class="col-md-12 league-form-bg" style="margin-top:40px; margin-bottom:20px;">

<div class="accordion" id="section3" style="background:#f59123; padding:5px; color:white;"><i class="fa fa-arrow-circle-o-right" style="color:white;"> </i>Past Tournaments<span></span></div>



<div class="tab-content">
<table class="tab-score">

<?php
//echo "dff".count($tournments);

if(count($past_tournments) == 0)
{
	?>
<tr>
<td colspan='3' style="padding-left:5px;"><h5>You were not registered for any tournament yet.</h5></td>
</tr>
<?php
}
else
{
foreach($past_tournments as $row) { 
?>
<tr>
<td valign="center" align="center" ><?php echo date('m/d/Y',strtotime(substr($row->StartDate,0,10))) ;?></td>
<td valign="center" align="center">
<p></p>

<div class="col-md-3" style=""><img class="img-djoko" height="90" width="150" src="<?php echo base_url(); ?>tour_pictures/<?php if($row->TournamentImage!=""){echo $row->TournamentImage; } else { echo "default_image.png";}?>" alt="" /></div>

<p style="font-size:16px"><a href="<?php echo base_url();?>league/view/<?php echo $row->tournament_ID;?>"><?php echo $row->tournament_title;?></a></p>

<p><strong>Sport:</strong> <?php 
$get_sport = play::get_sport($row->SportsType);
echo $get_sport['Sportname'];
?>
<?php
echo "(";
$option_array = json_decode($row->Singleordouble);										
$numItems = count($option_array);

$i = 0;
	if($numItems > 0){
		foreach($option_array as $sport){
			echo $sport;

			if(++$i != $numItems) {
				echo ", ";
			}
		}
	}

echo ")";

/*else
{
	echo "";  href='" .base_url().'topic/view_topic/'. $row->category_id ."'
}*/
?>                
</p>                          
<!-- <p><strong>Period:</strong>  <?php //echo date('m/d/Y',strtotime(substr($row->StartDate,0,10))); ?> - 
<?php //echo date('m/d/Y',strtotime(substr($row->EndDate,0,10))); ?></p> -->

<p><strong>Registration closed on:</strong> <?php echo date('m/d/Y',strtotime(substr($row->Registrationsclosedon,0,10))); ?></p>
<p><strong>Location:</strong> <?php echo $row->TournamentCity. ',' . $row->TournamentState; ?></p>
<p></p>
</td>
<!-- <td valign="center" align="center" ><?php //echo $row->TournmentCity;?></td>
<td valign="center" align="center">
<?php //echo date('m/d/Y',strtotime(substr($row->Registrationsclosedon,0,10))); ?></td> -->
<td valign="center" align="center">

  <!-- <?php echo base_url();?>Fixtures -->

<div>

<!-- <a href="">Add/View Scores</a> -->

</div>  <!--<?php echo base_url();?>Send-invite -->
</td>
</tr>

<?php }
} 
?>
</table>

</div>
</div>

<div style="clear:both"></div>

<!-- Past Matches Section Start -->

<div class="col-md-12 league-form-bg" style="margin-top:40px; margin-bottom:20px;">

<div class="accordion" id="section3" style="background:#f59123; padding:5px; color:white;"><i class="fa fa-arrow-circle-o-right" style="color:white;"> </i>Past Matches<span></span></div>



<div class="tab-content">
<table class="tab-score table-responsive">

<?php 
if(count($user_past_matches) == 0 and count($owner_past_matches) == 0)
{
	?>
<tr>
<td colspan='4' style="padding-left:5px;"><h5>No Past Matches are found.</h5></td>
</tr>
<?php
}
else
{
?>

<tr class="top-scrore-table">
<td class="score-position" valign="center" align="center">Match</td>
<td class="score-position" valign="center" align="center">Sport</td>
<td class="score-position" valign="center" align="center">Score</td>
<td class="score-position" valign="center" align="center">Winner</td>

</tr>
<?php
foreach($user_past_matches as $row) { ?>

<tr>

<td valign="center" style="padding-left:1px;">
<a href='<?php echo base_url()."Play/reg_match/".$row->Play_id; ?>'><b><?php echo $row->Play_Title ; ?></a></b>
</td>


<td valign="center" style="padding-left:4px;">
<p><?php 
$get = play::get_sport_name($row->GeneralMatch_ID);

$sport = $get['Sports'];
$get_sport = play::get_sport($sport);
echo $get_sport['Sportname'];
?>
</p>                          
</td>


<td valign="center" style="padding-left:4px;">
<div>
<?php
if($row->Player1_Score !=""){

$p1 = json_decode($row->Player1_Score);
$p2 = json_decode($row->Opponent_Score);

$cnt = count(array_filter($p1));
if($cnt >= 0)
	{
		for($i=0; $i<count(array_filter($p1)); $i++)
		{
			echo "($p1[$i] - $p2[$i]) ";
		}
		if($cnt == 0){
			echo "($p1[0] - $p2[0]) ";
		}
	}

}

?>

</div>  
<!-- <?php echo base_url();?>Register-match -->

</td>


<td valign="center" style="padding-left:4px;">
<div class="" style="">
<?php
if($row->Winner !=""){

	$match_type = $get['Match_Type'];
if($match_type == "Doubles"){
$get_user = play::get_user($row->Winner);
$get_user1 = play::get_user($row->Player2_Partner);

echo $get_user['Firstname']." ".$get_user['Lastname'] . ' - ' . $get_user1['Firstname']." ".$get_user1['Lastname'];
}else
{
$get_user = play::get_user($row->Winner);
echo $get_user['Firstname']." ".$get_user['Lastname'];
}
}
?>
</div>
</td>


</tr>
<?php }
}
?>

<?php
foreach($owner_past_matches as $row) { ?>

<tr>

<td valign="center" style="padding-left:1px;">
<a href='<?php echo base_url()."Play/reg_match/".$row->Play_id; ?>'><b><?php echo $row->Play_Title ; ?></a></b>
</td>


<td valign="center" style="padding-left:4px;">
<p><?php 
$get = play::get_sport_name($row->GeneralMatch_ID);

$sport = $get['Sports'];
$get_sport = play::get_sport($sport);
echo $get_sport['Sportname'];
?>
</p>                          
</td>


<td valign="center" style="padding-left:4px;">
<div>
<?php
if($row->Player1_Score !=""){

$p1 = json_decode($row->Player1_Score);
$p2 = json_decode($row->Opponent_Score);

$cnt = count(array_filter($p1));
if($cnt >= 0)
	{
		for($i=0; $i<count(array_filter($p1)); $i++)
		{
			echo "($p1[$i] - $p2[$i]) ";
		}
		if($cnt == 0){
			echo "($p1[0] - $p2[0]) ";
		}
	}

}

?>

</div>  
<!-- <?php echo base_url();?>Register-match -->

</td>


<td valign="center" style="padding-left:4px;">
<div>
<?php
if($row->Winner !=""){

$match_type = $get['Match_Type'];
if($match_type == "Doubles"){
$get_user = play::get_user($row->Winner);
$get_user1 = play::get_user($row->Player2_Partner);

echo $get_user['Firstname']." ".$get_user['Lastname'] . ' - ' . $get_user1['Firstname']." ".$get_user1['Lastname'];
}else
{
$get_user = play::get_user($row->Winner);
echo $get_user['Firstname']." ".$get_user['Lastname'];
}

}
?>
</div>
</td>

</tr>

<?php }
?>

</table>

</div>
</div>


<!-- Past Matches Section End -->

<!-- ----------Past Tournament Matches start ------------ -->

<div style="clear:both"></div>

<!-- Past Matches Section Start -->





<?php } ?>    <!-- END BRACE FOR  USER SESSION CONTENT  -->


</div>

<!--Close Top Match-->

<!--Right Column -->
<!-- <div class="col-md-3 right-column">

</div> 
</div>  
</section> -->