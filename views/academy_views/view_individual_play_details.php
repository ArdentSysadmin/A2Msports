<style>
.blink {
    color:green;
}
</style>

<script>
$(document).ready(function(){
   
	$(".add_score").click(function(){
		var pid = $(this).attr('name');
        $("#score"+pid).show();
		//$("#pic").hide();
		$(".add_score").hide();
    });
	

	$.fn.blink = function(options) {
        var defaults = {
            delay: 500
        };
        var options = $.extend(defaults, options);

        return this.each(function() {
            var obj = $(this);
            setInterval(function() {
                if ($(obj).css("visibility") == "visible") {
                    $(obj).css('visibility', 'hidden');
                }
                else {
                    $(obj).css('visibility', 'visible');
                }
            }, options.delay);
        });
    }


    $('.blink').blink(); // default is 500ms blink interval.
    $('.blink_third').blink({
        delay: 1500
    }); // causes a 1500ms blink interval.     
	});

</script>

 <section id="single_player" class="container secondary-page">

       <div class="top-score-title right-score col-md-9">
            <!-- <h3 style="text-align:left">Friendly Match - Score</h3> -->
			<h3></h3>
<?php
if($match_det)
{ 
?>
<form class="form-horizontal" id='myform' method='post' role="form"  action="<?php echo base_url(); ?>play/register/<?php echo $match_det['GeneralMatch_ID'] ;?>"> 

<input type="hidden" name="id" value="<?php echo $match_det['GeneralMatch_ID'] ;?>" /> 

		  
		   <div class="col-md-12 league-form-bg">
           		<div class="fromtitle"><?php echo $match_det['Play_Title']; ?></div>

				<div class="">
                   <div class="col-md-4 col-xs-4">
                    	<div align="center">
                        	<div class="score-head1">
							<?php 
							$get = play::get_sport_name($match_det['GeneralMatch_ID']);
							$owner = $get['users_id'];
							$p1_r = $get['Player1_Partner'];
							$match_type = $get['Match_Type'];

							$match_init = play::get_user($owner);
							$p1_rname = play::get_user($p1_r);

							if($match_type == "Doubles"){
							
							echo "<a target='_blank' href='".base_url()."player/$owner'>" . ucfirst($match_init['Firstname'])." ".ucfirst($match_init['Lastname']) . "</a>" . "; " . "<a target='_blank' href='".base_url()."player/$p1_r'>" . ucfirst($p1_rname['Firstname'])." ".ucfirst($p1_rname['Lastname']) . "</a>"; 
							}
							else
							{
								echo "<a target='_blank' href='".base_url()."player/$owner'>" . ucfirst($match_init['Firstname'])." ".ucfirst($match_init['Lastname']) . "</a>";
							}
						    ?>
							
						  </div>


						<a target='_blank' href='<?php echo base_url()."player/$owner"; ?>'>
						<img  src="<?php echo base_url(); ?>profile_pictures/<?php if($match_init['Profilepic']!=""){echo $match_init['Profilepic']; } else { echo "default-profile.png";}?>" alt="" />
						</a>	
                        	<div class="score-head2">
							A2MScore: 
							 <?php 
							 $sport = $get['Sports'];
							 $user_id = $get['users_id'];
							 $user_a2mscore = $this->model_play->get_a2msocre($sport,$user_id);
							 echo $user_a2mscore['A2MScore'];

							 ?>
							</div>
                            
                        </div>
                    </div>
                    
                    <div class="col-md-4 col-xs-4" align="center">
                        <!-- <div style="padding-top:40px; padding-bottom:10px">Simon, who's seeded just a lowly</div> -->

						 <div style="padding-top:40px;">
						 <?php
						 $sport = $get['Sports'];
						 $sport_name = play::get_sport($sport);
						 echo "<p style='color:#f59123'><b>" . $sport_name['Sportname'] . "</b></p>"?>
						 </div>
						
						<div style="padding-top:10px;">
						<?php if($match_det['Play_Date'] != ""){ ?>
						 <label  for='id_accomodation' align='center' class="scoredate">Match Date</label>
						 <?php echo "<p style='color:green' class='scoredate'><b>".  date("M d, Y", strtotime($match_det['Play_Date'])) . "</b></p>";
						} ?>
						 </div>

						 <div style="padding-top:20px; padding-bottom:10px" class="winner-web">
						  <?php if($match_det['Winner'] != ""){ ?>
						 <label  for='id_accomodation' align='center'>Winner</label>
						<?php
						$match_type = $get['Match_Type'];
						if($match_type == "Doubles"){
							$match_winner = play::get_user($match_det['Winner']);
							$get_user1 = play::get_user($match_det['Player2_Partner']);
							
							echo " <div class='blink' id='blink'><h2 style='margin-top:0px'>" . $match_winner['Firstname']." ".$match_winner['Lastname'] . " - " . $get_user1['Firstname']." ".$get_user1['Lastname']."</h2></div>";
						}
						else{

						$match_winner = play::get_user($match_det['Winner']);
						echo " <div class='blink' id='blink'><h2 style='margin-top:0px'>" . $match_winner['Firstname']." ".$match_winner['Lastname'] ."</h2></div>";

						} }
						 ?>
						 </div>

						 

                    </div>
                
                   	<div class="col-md-4 col-xs-4">
                   		<div align="center"  style="margin-bottom:20px">

							<?php $match_opp = play::get_user($match_det['Opponent']);
							 $match_opp_partner = play::get_user($match_det['Player2_Partner']);?>

                        	<div class="score-head1">
							<?php 
							if($match_type == "Doubles"){
							
							echo "<a target='_blank' href='".base_url()."player/$match_det[Opponent]'>" . ucfirst($match_opp['Firstname'])." ".ucfirst($match_opp['Lastname']) . "</a>" . "; " . "<a target='_blank' href='".base_url()."player/$match_det[Player2_Partner]'>" . ucfirst($match_opp_partner['Firstname'])." ".ucfirst($match_opp_partner['Lastname']) . "</a>"; 
							}
							else
							{
								echo "<a target='_blank' href='".base_url()."player/$match_det[Opponent]'>" . ucfirst($match_opp['Firstname'])." ".ucfirst($match_opp['Lastname']) . "</a>";
							}
							
							?>
							</div>
                   		
							<a target='_blank' href='<?php echo base_url()."player/$match_det[Opponent]"; ?>'>
							<img  src="<?php echo base_url(); ?>profile_pictures/<?php if($match_opp['Profilepic']!=""){echo $match_opp['Profilepic']; } else { echo "default-profile.png";}?>" alt="" />
							</a>
							
                        	<div class="score-head2">
							A2MScore: 
							<?php 
							 $sport = $get['Sports'];
							 $user_id = $match_det['Opponent'];
							 $user_a2mscore = $this->model_play->get_a2msocre($sport,$user_id);
							 echo $user_a2mscore['A2MScore'];

							 ?>
							
							
							</div>
                            
                        </div>
                   </div>

					
					
					<?php

					if($match_det['Player1_Score'] !=""){ ?>
					<div class="scoretable-web">	
					<table class="score-cont">
					<?php $sport = $get['Sports'];
					if($sport != 1){ ?>
						<tr>
							<th>Players</th>
							<th>Game1</th>
							<th>Game2</th>
							<th>Game3</th>
							<th>Game4</th>
							<th>Game5</th>
							<!--<th>Total</th>-->
							<th>Win%</th>
						 </tr>
					<?php
					} 
					else { ?>
						  <tr>
							<th>Players</th>
							<th>Set1</th>
							<th>Set2</th>
							<th>Set3</th>
							<th>Set4</th>
							<th>Set5</th>
							<!--<th>Total</th>-->
							<th>Win%</th>
						  </tr>
					<?php } ?>
						<tr>
                         <td bgcolor="#fdd7b0"><b>
						 <?php 
							if($match_type == "Doubles"){
							echo  ucfirst($match_init['Firstname'])." ".ucfirst($match_init['Lastname']) . "; " . ucfirst($p1_rname['Firstname'])." ".ucfirst($p1_rname['Lastname']); 
							}
							else
							{
								echo  ucfirst($match_init['Firstname'])." ".ucfirst($match_init['Lastname']); 
							}
						 ?>
						 </b>
						 </td>	

							<?php
							$p1 = json_decode($match_det['Player1_Score']);
							if(count(array_filter($p1))>0)
							{
								//$sum = 0;
								for($i=0; $i<5; $i++)
								{
								if($i<count(array_filter($p1)))
									{
									?>
								<td><?php echo $p1[$i]; ?></td>
									 <?php //$sum += $p1[$i];
									}								  
									else 
									{?>
									<td></td>
									<?php }
								} 
							} 
							?>

						<!-- <td> 
							<?php echo $sum; ?>
						</td> -->
						<td> 
							<?php echo round($match_det['Player1_Win_Percent'] ,2); ?>
						</td>
					    </tr>
						
						<tr>
						  <td bgcolor="#fdd7b0"><b>
						  <?php 
							if($match_type == "Doubles"){
							echo  ucfirst($match_opp['Firstname'])." ".ucfirst($match_opp['Lastname']) . "; " . ucfirst($match_opp_partner['Firstname'])." ".ucfirst($match_opp_partner['Lastname']); 
							}
							else
							{
								echo  ucfirst($match_opp['Firstname'])." ".ucfirst($match_opp['Lastname']); 
							}
						 ?>
						  </b></td>	
						<?php
							$p2 = json_decode($match_det['Opponent_Score']);
							if(count(array_filter($p2))>0)
							{
								//$sum = 0;
								for($i=0; $i<5; $i++)
								{
								if($i<count(array_filter($p2)))
									{
									?>
								<td><?php echo $p2[$i]; ?></td>
									 <?php //$sum += $p2[$i];
									}								  
									else 
									{?>
									<td></td>
									<?php }
								}  	
						   } 
						?>
						<!-- <td> 
							<?php echo $sum1; ?>
						</td> -->
						<td> 
							<?php echo round($match_det['Player2_Win_Percent'],2); ?>
						</td>

						
					   </tr>
							
					  </table>
					  </div>

					<div style="padding-top:10px; clear:both; text-align:center" class="winner-mob">
						  <?php if($match_det['Winner'] != ""){ ?>
						<?php
						$match_type = $get['Match_Type'];
						if($match_type == "Doubles"){
							$match_winner = play::get_user($match_det['Winner']);
							$get_user1 = play::get_user($match_det['Player2_Partner']);

							echo " <div><b>Winner: <font color='##ff0000'>" . $match_winner['Firstname']." ".$match_winner['Lastname'] .$get_user1['Firstname']." ".$get_user1['Lastname']."</font></b></div>";
							
						}
						else{

						$match_winner = play::get_user($match_det['Winner']);
						echo " <div><b>Winner: <font color='##ff0000'>" . $match_winner['Firstname']." ".$match_winner['Lastname'] ."</font></b></div>";

						}
					  }
						 ?>
						 </div>
					<div class="scoretable-mob">
                    <table class="score-cont">
					  <tr>
					   <th>Players</th>
					   <th> <?php 
							if($match_type == "Doubles"){
							echo  ucfirst($match_init['Firstname'])." ".ucfirst($match_init['Lastname']) . "; " . ucfirst($p1_rname['Firstname'])." ".ucfirst($p1_rname['Lastname']); 
							}
							else
							{
								echo  ucfirst($match_init['Firstname'])." ".ucfirst($match_init['Lastname']); 
							}
						 ?>
						 </th>
						<th>
						 <?php 
							if($match_type == "Doubles"){
							echo  ucfirst($match_opp['Firstname'])." ".ucfirst($match_opp['Lastname']) . "; " . ucfirst($match_opp_partner['Firstname'])." ".ucfirst($match_opp_partner['Lastname']); 
							}
							else
							{
								echo  ucfirst($match_opp['Firstname'])." ".ucfirst($match_opp['Lastname']); 
							}
						 ?>
						</th>
					   </tr>
						<?php
							$p1 = json_decode($match_det['Player1_Score']);
							$p2 = json_decode($match_det['Opponent_Score']);
							if(count(array_filter($p1))>0)
							{
								$sport = $get['Sports'];
								if($sport == 1)
								{ 
									$set_or_game = 'Set';
								}
								else
								{
								$set_or_game = 'Game';
								}
								for($i=0; $i<5; $i++)
								{ 
									$set_no = $i+1;?>
									<tr><td bgcolor="#fdd7b0"><b>
									<?php echo $set_or_game.$set_no; ?></b></td><?php
								if($i<count(array_filter($p1)))
									{
									?>
								<td><?php echo $p1[$i]; ?></td>
								<td><?php echo $p2[$i]; ?></td>
								
									 <?php
									}								  
									else 
									{?>
									<td></td>
									<?php } ?>
									</tr><?php
								}  	
						   } 
						?>

                                </table>
                                </div>
						

					<?php 
					}
					 else
					 {
						echo " <label class='' for='id_accomodation'>Score -
						<input type='button' id='add' name='$match_det[Play_id]' class='add_score league-form-submit1' value='Add Score' href='#reg_matches'></label>";
							
					 }

					?>
					
                    
               </div>
          
   		
</form>


			<!-- ----Start -Add Score------ -->
				<div id="score<?php echo $match_det['Play_id']; ?>" style="display:none;">
				
				<form method="post"  action="<?php echo base_url();?>play/update_score_data/<?php echo $match_det['Play_id']; ?>">
					<div class='form-group'>
					<div class='col-md-4 form-group internal' style="margin-right:5px; margin-left:20px">
					Play Date
					<input  type="text" class='form-control' placeholder="Date" id="sdate<?php echo $match_det['Play_id']; ?>"  name="match_date" style="margin-right:10px" required/> 
					</div>
				<script>
				$(function() {
					var spid = "<?php echo $match_det['Play_id']; ?>";
				 $('#sdate'+spid).datepick();
				});
				</script>

				<?php
					$get_opp_name = play::get_gen_mat_det($match_det['GeneralMatch_ID']);
					$match_type = $get_opp_name['Match_Type'];

					$get_name1 = play::get_user($get_opp_name['users_id']);
					$player1_name = $get_name1['Firstname'] . $get_name1['Lastname'];

					$get_partner1 = play::get_user($get_opp_name['Player1_Partner']);
					$player1_partner_name = $get_partner1['Firstname'] . $get_partner1['Lastname'];

					$get_name2 = play::get_user($match_det['Opponent']);
					$player2_name = $get_name2['Firstname'] . $get_name2['Lastname'];

					$get_partner2 = play::get_user($match_det['Player2_Partner']);
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

				<div class='col-md-6 form-group internal'>
					<?php /*
					$get_opp_name = play::get_gen_mat_det($match_det['GeneralMatch_ID']);
					$get_username = play::get_user_det($get_opp_name['users_id']); 
					
					

						<select name="id" class='form-control'>
						<option value="<?php echo $get_opp_name['users_id']; ?>">
						<?php $get_name = play::get_user($get_opp_name['users_id']);
						echo $get_name['Lastname'];
						?></option>
						<option value="<?php echo $match_det['Opponent']; ?>">
						<?php 
						$get_name = play::get_user($match_det['Opponent']);
						echo $get_name['Lastname'];
					
						?>	
						
						</option>
						</select>
						*/?>
						
					</div>
					</div>
					<div class="">
					<!-- <div class='form-group'> -->
					<div class='form-group internal'>
					<div class='scoretable-web'>
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
					<input name="submit" type="submit" value="Add" class="league-form-submit" style="margin-left:350px"/>
					</div>
					<div class="scoretable-mob table-responsive">
					<table class="score-cont">
						<tr>
							<th>Players</th>
							<th bgcolor="#fdd7b0"><b><?php echo $p;?></b></th>
							<th bgcolor="#fdd7b0"><b><?php echo $p1;?></b></th>
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
						<td><input id='set1_1' name='player1[]' style = "width:65%" type='text' maxlength='2' /></td>
						<td><input id='set1_2' name='player2[]' style = "width:65%" type='text' maxlength='2' /></td>
						</tr>
						<tr>
						<td>
							<?php echo $set_or_game . "2"; ?>
						</td>
						<td><input id='set2_1' name='player1[]' style = "width:65%" type='text' maxlength='2' /></td>
						<td><input id='set2_2' name='player2[]' style = "width:65%" type='text' maxlength='2' /></td>
						</tr>
						<tr>
						<td>
							<?php echo $set_or_game . "3"; ?>
						</td>
						<td><input id='set3_1' name='player1[]' style = "width:65%" type='text' maxlength='2' /></td>
						<td><input id='set3_2' name='player2[]' style = "width:65%" type='text' maxlength='2' /></td>
						</tr>
						<tr>
						<td>
							<?php echo $set_or_game . "4"; ?>
						</td>
						<td><input id='set4_1' name='player1[]' style = "width:65%" type='text' maxlength='2' /></td>
						<td><input id='set4_2' name='player2[]' style = "width:65%" type='text' maxlength='2' /></td>
						</tr>
						<tr>
						<td>
							<?php echo $set_or_game . "5"; ?>
						</td>
						<td><input id='set5_1' name='player1[]' style = "width:65%" type='text' maxlength='2' /></td>
						<td><input id='set5_2' name='player2[]' style = "width:65%" type='text' maxlength='2' /></td>
						</tr>

					</table>
					<input name="submit" type="submit" value="Add" class="league-form-submit" />
					</div>
					
					</div>
					<!-- </div> -->
					<!-- <div class='form-group'> -->
					

					<input class='form-control' value="<?php echo $match_det['Opponent'];?>" id="opp_user" name="opp_user" type='hidden'>
					<input class='form-control' value="<?php echo $match_det['GeneralMatch_ID'];?>" id="gen_match_id" name="gen_match_id" type='hidden'>
					<!-- </div> -->
				
					<!-- <div class='form-group'> -->
					
					
					<!-- </div> -->

				
				</div>
				</form>
				</div>
				<!-- --end of Add score------------- -->
<?php 
}
else
{ 
?>
	<p style="line-height:20px; font-size:13px"><h5>Oops! Invalid Access. Please contact admin@a2msports.com</h5></p>
<?php
}
?>

</div>
<div style="clear:both"></div>
</div>