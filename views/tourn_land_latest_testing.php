<?php 
//echo "<pre>";print_r($tour_details);
if($tour_details->TournamentImage!=""){ $tourn_img = $tour_details->TournamentImage; }
else if($tour_details->SportsType == 1){ $tourn_img = "tennis-img1.jpg"; }
else if($tour_details->SportsType == 2){ $tourn_img = "table-tennies-land.jpg"; }
else if($tour_details->SportsType == 3){ $tourn_img = "bat1.jpg"; }
else if($tour_details->SportsType == 4){ $tourn_img = "batminton-img1.jpg"; }
else if($tour_details->SportsType == 5){ $tourn_img = "batminton-img1.jpg"; }
else if($tour_details->SportsType == 6){ $tourn_img = "batminton-img1.jpg"; }
else if($tour_details->SportsType == 7){ $tourn_img = "batminton-img1.jpg"; }
else if($tour_details->SportsType == 8){ $tourn_img = "batminton-img1.jpg"; }
else if($tour_details->SportsType == 9){ $tourn_img = "carroms_land_bg.jpg"; }
else if($tour_details->SportsType == 10){ $tourn_img = "volleyball_land_bg.jpg"; }

switch ($tour_details->SportsType) {
    case 1:
        $sport_img="images/playerfocus_tennis.jpg";
        break;
    case 2:
        $sport_img="tour_pictures/table_tennis_player_focus.jpg";
        break;
    case 3:
        $sport_img="images/player-focus.jpg";
        break;
    case 4:
        $sport_img="images/player-focus.jpg";
        break;
    case 5:
        $sport_img="images/player-focus.jpg";
        break;
    case 6:
        $sport_img="images/player-focus.jpg";
        break;
    case 7:
        $sport_img="images/player-focus.jpg";
        break;
    case 8:
        $sport_img="images/player-focus.jpg";
        break;
    case 9:
       $sport_img="images/carroms-player-focus.jpg";
        break;
    case 10:
       $sport_img="images/player-focus.jpg";
        break;
    default:
        $sport_img="images/player-focus.jpg";
}
?>
  <style type="text/css">
   
    .batstubpage {
      /*background: url(<?php echo base_url();?>tour_pictures/<?php echo $tourn_img;?>);*/
       position:relative;
    }
    .land-client .highlight {
    font-weight:bold;
	color:#ea7f02;
    }

.land-client .highlight::after {
    content: '';
    position: absolute;
    left: 40%;
    top: 168px;
    width: 0;
    height: 0;
    border-left: 15px solid transparent;
    border-right: 15px solid transparent;
    border-top: 15px solid #e8e8e8;
    clear: both;
    /* z-index: 1; */
}
    .player-focusbg1 {
    background: url(<?php echo base_url().$sport_img;?>) center center no-repeat fixed;
    -webkit-background-size: cover;
    -moz-background-size: cover;
    -o-background-size: cover;
    background-size: cover;
    width: 100%;
    float: left;
  padding-bottom:10px;
}

#slideshow1 img {
  width: 450px;
  height: 160px;
}

#slideshow2 {
  position: relative;
  width: 450px;
  height: 160px;
}
#slideshow2 img {
  width: 450px;
  height: 120px;
}

#slideshow2 > div {
  position: absolute;
}

.overlay {
  position: fixed;
  top: 0;
  bottom: 0;
  left: 0;
  right: 0;
  background: rgba(0, 0, 0, 0.7);

  z-index:999;
}

.popup {
  margin: 70px auto;
  padding: 20px;
  background: #fff;
  border-radius: 5px;
  width: 50%;
  position: relative;
  transition: all 5s ease-in-out;
}

.popup .close {
  position: absolute;
  top: 0px;
  right: 3px;
  transition: all 200ms;
  font-size: 30px;
  font-weight: bold;
  text-decoration: none;
  color: #6f0805;
  opacity:10;
}
.popup .close:hover {
  color: #000000;
}
.popup .content {
  height: 100%;
  overflow: auto;
 
}

.draw_popup {
  margin: 70px auto;
  padding: 20px;
  background: #fff;
  border-radius: 5px;
  width: 95%;
  position: relative;
  transition: all 5s ease-in-out;
}

.draw_popup .close {
  position: absolute;
  top: 0px;
  right: 3px;
  transition: all 200ms;
  font-size: 30px;
  font-weight: bold;
  text-decoration: none;
  color: #6f0805;
  opacity:10;
}
.draw_popup .close:hover {
  color: #000000;
}
.draw_popup .content {
  height: 500px;
  overflow:auto;
  
 
}

  </style>
    <section>

	<div id="google" align='center'> <!-- Google AdSense -->
<script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
<script>
  (adsbygoogle = window.adsbygoogle || []).push({
    google_ad_client: "ca-pub-9772177305981687",
    enable_page_level_ads: true
  });
</script>
</div><!-- Google AdSense -->

    <div class="landsocial social-share floating">
        <ul>
          <li class="facebook"><a href="https://www.facebook.com/a2msports" target="_blank"><i class="fa fa-facebook" aria-hidden="true"></i></a></li>
          <li class="twitter"><a href="https://twitter.com/a2m_sports" target="_blank"><i class="fa fa-twitter" aria-hidden="true"></i></a></li>
          <li class="instagram"><a href="https://www.instagram.com/a2msports" target="_blank"><i class="fa fa-instagram" aria-hidden="true"></i></a></li>
        </ul>
	</div>

	<!-- <div class="land-add1">
  <div class="alert alert-dismissable fade in close-but" align="center">
  <?php
	$sponsors2=json_decode($tour_details->Sponsors, true);
//print_r($sponsors2);
  if(count($sponsors2) > 0){
	$banner = array_rand($sponsors2);
  ?>
   <a href="<?php echo $sponsors2[array_rand($sponsors2)]; ?>" target='_blank'>
     <img src="<?php echo base_url();?>tour_pictures/<?php echo $tour_details->tournament_ID;?>/sponsors/<?php echo $banner;?>" alt="" width='325px' height = '118px' />
   </a>
   <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
  <?php
  }
  ?>
 </div>
 </div> -->



 <div class="batstubpage">
 <div class="land-back-bg">
 <div align="center">
 <a href='<?=base_url();?>league/<?=$tr_det->tournament_ID;?>'><img src="<?=base_url();?>tour_pictures/<?=$tourn_img;?>" alt="" class="img-responsive-land" /></a>
 </div>
   <div class="landinnerbg1">
     <div class="land-match-text-head">
	 <?php if($tour_details->tournament_format != "TeamSport"){ ?>
       <h3 style="text-align:center;"><?php echo $tour_details->tournament_title;?></h3>

       <p class="txt-advert-sub" style="text-align:center;"> 
        <?php $tournmnt_addrs='';
        if($tour_details->TournamentAddress){
          $tournmnt_addrs.=$tour_details->TournamentAddress.', ';
        }
        if($tour_details->TournamentCity){
          $tournmnt_addrs.=$tour_details->TournamentCity.', ';
        }
        if($tour_details->TournamentState){
          $tournmnt_addrs.=$tour_details->TournamentState.', ';
        }
        if($tour_details->PostalCode){
          $tournmnt_addrs.=$tour_details->PostalCode;
        }

        echo $tournmnt_addrs;
        ?>                    
      </p>
      <?php } ?>          

		 </div> <!--.land-match-text-head --> 
	   </div><!--.land-back-bg --> 
	 </div><!--.landinnerbg1 --> 
   </div><!--batstubpage --> 
			<?php 
			if($tour_details->tournament_format=="Teams" or $tour_details->tournament_format=="TeamSport"){
			$tourn_reg_teams = league::get_reg_team_participants($tour_details->tournament_ID);
			?>                    
			<div class="batstubpage2">
        	<div class="container">
				<div class="land-client">
				<div class="leaghead" id="teams"><h2 style="padding-bottom:20px">Teams</h2></div>
				<?php
                if(count($tourn_reg_teams)==0){
                  echo '<div style="text-align:center; padding-bottom:30px; font-size:20px;"> No Teams registered yet! &nbsp; <a href="'.base_url().'teams/addnew"><input type="button" name="create_team" id="create_team" value="Create Team" class="league-form-submit"></a></div>';
                }
				else{
                ?>
                    <ul id="planding" class="bxslider">
                    <?php
                    foreach($tourn_reg_teams as $name){
                      $team = league::get_team($name->Team_id);
                      
                      if($team['Team_Logo'] != ""){
                        $team_logo_path = base_url()."team_logos/cropped/".$team['Team_Logo'];
                      }
					  else if($team['Team_Logo'] == 0){
                        $team_logo_path = base_url()."team_logos/default_team_logo.png";
                      }
					  else{
                        $team_logo_path = base_url()."team_logos/default_team_logo.png";
                      }
                      ?>
					<li onclick="Getteamplayers(this, '<?php echo $name->Team_id;?>');" id="team_<?php echo $name->Team_id;?>"  style="text-align:center; cursor:pointer;" class="teamslide1">
					<img alt="Team Logo" src="<?php echo $team_logo_path;?>" style="width:135px; height:150px;" />
					<?php echo $team['Team_name'];?>
					</li>
                      <?php
                     }
                      ?> 
                    </ul>

                    </div>
                    <div class="teamnames">
                    <?php 
                     $users=json_decode($tourn_reg_teams[0]->Team_Players);
                     foreach ($users as $key => $usr) {
                       $user_det = league::get_username($usr);
                     echo "<div class='col-md-3 namespadd'><a target='_blank' href='".base_url()."player/".$usr."'>".$user_det['Firstname'].' '.$user_det['Lastname']."</a></div>";
                     } 
                    ?>
                    </div>
					<div style="clear:both; border-top:1px solid #999; height:20px; margin-top:20px;"></div>
                    <?php
                  }
                  ?>
             </div><!--container --> 
             </div><!--batstubpage -->
              <?php 
          }

		  if($tour_details->tournament_format != "TeamSport"){
          ?>
             <div class="leaghead"><h2 style="padding-bottom:20px" id="players">Players in Focus</h2></div>
             <div class="player-focusbg1">
             <div class="container">
                <?php 
                if(count($top_players) == 0){
                  echo '<div style="text-align:center; padding-bottom:30px; color:#fff; font-size:20px;"> No players registered yet!</div>';
                }
				else{
                  ?>
                  <ul id="playerfocus" class="bxslider">
                   <?php
                   foreach ($top_players as $key => $player){
                    $user_det = league::get_username($player->Users_ID);

                    if($user_det['Profilepic']!=""){
                      $profile_pic=base_url()."profile_pictures/".$user_det['Profilepic'];
                    }
					else{
                      $profile_pic=base_url()."images1/player.png";
                    }
                    ?>
                    <li class="playerslide1">
                     <div class="col-md-12 homevideo">
                      <div class="col-md-5 it-video">
                        <a target="_blank" style="cursor:pointer;" href="<?php echo base_url();?>player/<?php echo $user_det['Users_ID'];?>" >
                          <img alt="" src="<?php echo $profile_pic;?>" >
                        </a>
                      </div>
                      <div class="video-txt">
                        <h3><a target="_blank"  style="cursor:pointer;" href="<?php echo base_url();?>player/<?php echo $user_det['Users_ID'];?>" ><font color="#ffffff"><u><?php echo $user_det['Firstname'].' '.$user_det['Lastname'];?></u></font></a></h3>
                        <p style="color:#fff"><span>A2MScore:</span>
                          <?php 
                          $getA2MScore=league::get_a2mscore($user_det['Users_ID'], $tour_details->SportsType);
                          echo $getA2MScore['A2MScore'];
                          ?>
                          <br>
                          <span>No. of Matches:</span>
                          <?php 
                          $getSportMatchesCount=league::get_matches_cnt($user_det['Users_ID'], $tour_details->SportsType);
                                              // echo "<pre>"; print_r($getSportMatchesCount);
                          if($getSportMatchesCount['Num_Matches']!=""){
                            echo $getSportMatchesCount['Num_Matches'];
                          }
						  else{
                            echo "0";
                          }

                          if($getSportMatchesCount['Num_Matches']!=""){ 
                            ?>
                            <br>
                            <span>Win-Loss:</span>
                            <?php echo $getSportMatchesCount['Won']."-".$getSportMatchesCount['Lost'];
                          }
                          ?>
                        </p>
                      </div>
                    </div>
                  </li>
                  <?php
                }
                ?>      
              </ul>
              <?php
            }
            ?>  
          </div>
        </div>
        <?php
		}
		if(count($get_images) == 0){
			// -------------
        }
		else{
		?>
        <div style="clear:both"></div>
        <div class="leaghead"><h2 style="padding-bottom:20px" id="gallery">Gallery</h2></div>
             <div class="gallery-arrow">
        <div class="container">
          
                <ul id="imagegallery" class="bxslider" >
                <?php
                foreach ($get_images as $i => $row){  
                   $filename = base_url()."tour_pictures/".$row->Tournament_id."/".$row->Image_file;
                ?>
                    <li>
                      <a class="fancybox-thumb" rel="fancybox-thumb" id="<?php echo $i;?>"  class="imagepopup" href="<?php echo base_url(); ?>tour_pictures/<?php echo $row->Tournament_id; ?>/<?php if($row->Image_file!=""){echo $row->Image_file; } else { echo "";} ?>" >
                          <img src="<?php echo base_url(); ?>tour_pictures/<?php echo $row->Tournament_id; ?>/thumbs/<?php if($row->Image_file!=""){echo $row->Image_file; } else { echo "";} ?>" alt="" />
                      </a>
                    </li>
				<?php
				}
				?>      
              </ul>
           
          </div>
          </div>
          <?php
            }
            if(count($brackets) == 0){
            }
			else{
            ?>  
        <div style="clear:both"></div>
        <div class="leaghead"><h2 style="padding-bottom:20px" id="draws">Draws</h2></div>
         <div class="container">
         
              <table id="brackets" cellpadding="0" border="0" class="table table-striped">
              <tr>
                <th>Title</th>
                <th class='text-center'>Winner</th>
                <th class='text-center'>Runner-up</th>
                <th class='text-center'>3rd Place</th>
                <th class='text-center'>4th Place</th>
              </tr>
              <?php
			  foreach($brackets as $bk){
              //echo "<pre>"; print_r($line_matches);
              ?>
              <tr>
              <td><a style="cursor:pointer; font-weight:bold;" class="show_draws"  id="<?php echo $bk->BracketID;?>"><?php echo $bk->Draw_Title;?></a></td>
			  <?php
			  if($bk->Bracket_Type != 'Round Robin'){
                 $line_matches = league::get_tourn_final_line_matches($bk->BracketID, $bk->No_of_rounds);
			  ?>
              <td align='center'><?php 
                 $winner = $line_matches['Winner'];
                 if($winner == $line_matches['Player1']){
                    $looser         = $line_matches['Player2']; 
                    $winner_partner = $line_matches['Player1_Partner'];
                    $looser_partner = $line_matches['Player2_Partner'];
                  }
				  else{
                    $looser         = $line_matches['Player1']; 
                    $winner_partner = $line_matches['Player2_Partner'];
                    $looser_partner = $line_matches['Player1_Partner'];
                  }
                 
				 if($tour_details->tournament_format == 'Teams'){
					$get_team = league::get_team(intval($winner));
					if($get_team['Team_Logo'] != NULL and $get_team['Team_Logo'] != ""){
					$team_logo = "<img style='width:35px;height:30px' src='".base_url()."team_logos/".$get_team['Team_Logo']."' alt='".$get_team['Team_name']."' />";
					}
					else{ 
					$team_logo = "<img style='width:35px;height:30px' src='".base_url()."team_logos/default_team_logo.png' alt='".$get_team['Team_name']."' />";
					}
					echo "<a>".$team_logo." ".$get_team['Team_name']."</a>";
					$get_team = "";
				 }
				 else{
					  $get_winnername  = league::get_username(intval($winner));
					  echo "<a href='".base_url()."player/{$winner}' target='_blank'>".$get_winnername['Firstname']." ".$get_winnername['Lastname']."</a>";
					  if($winner_partner){
						$get_winner_partner  = league::get_username(intval($winner_partner));
					   echo "; "."<a href='".base_url()."player/{$winner_partner}' target='_blank'>".$get_winner_partner['Firstname']." ".$get_winner_partner['Lastname']."</a>";
					  }
				 }
                ?>
              </td>
              <td align='center'><?php
				 if($tour_details->tournament_format == 'Teams'){
					$get_team = league::get_team(intval($looser));
					if($get_team['Team_Logo'] != NULL and $get_team['Team_Logo'] != ""){
					$team_logo = "<img style='width:35px;height:30px' src='".base_url()."team_logos/".$get_team['Team_Logo']."' alt='".$get_team['Team_name']."' />";
					}
					else{ 
					$team_logo = "<img style='width:35px;height:30px' src='".base_url()."team_logos/default_team_logo.png' alt='".$get_team['Team_name']."' />";
					}
					echo "<a>".$team_logo." ".$get_team['Team_name']."</a>";
					$get_team = "";
				 }
				 else{
                  $get_looser  = league::get_username(intval($looser));
                  echo "<a href='".base_url()."player/{$looser}' target='_blank'>".$get_looser['Firstname']." ".$get_looser['Lastname']."</a>";
                  if($looser_partner){
                      $get_looser_partner  = league::get_username(intval($looser_partner));
                      echo "; "."<a href='".base_url()."player/{$looser_partner}' target='_blank'>".$get_looser_partner['Firstname']." ".$get_looser_partner['Lastname']."</a>";
                  }
				 }
                ?>
              </td>
			  <td align='center'>N/A</td>
			  <td align='center'>N/A</td>
             <?php 
				}
				else if($bk->Bracket_Type == 'Round Robin'){
            
				  /*$num_rounds = intval($bk->No_of_rounds-1);*/
				  $rr_tourn_matches = league::get_tourn_rr_matches($bk->BracketID);
				  $players = array();
				  //echo "<pre>"; print_r($rr_tourn_matches);
				  foreach($rr_tourn_matches as $i => $rtm){
					  
					  $cur_player1 = $rtm->Player1;
					  if($rtm->Player1_Partner != NULL or $rtm->Player1_Partner != 0){
						$cur_player1 = $rtm->Player1."-".$rtm->Player1_Partner;
					  }

					  if(!array_key_exists($cur_player1, $players)){			//	Player1 
						$players[$cur_player1] = ($rtm->Player1_points != NULL) ? $rtm->Player1_points : 0;
					  }
					  else{
						$prev_points = $players[$cur_player1];
						$players[$cur_player1] = ($rtm->Player1_points != NULL) ? ($prev_points + $rtm->Player1_points) : $prev_points;
					  }

					  $cur_player2 = $rtm->Player2;
					  if($rtm->Player2_Partner != NULL or $rtm->Player2_Partner != 0){
						$cur_player2 = $rtm->Player2."-".$rtm->Player2_Partner;
					  }

					  if(!array_key_exists($cur_player2, $players)){			//	Player2 
						$players[$cur_player2] = ($rtm->Player2_points != NULL) ? $rtm->Player2_points : 0;
					  }
					  else{
						$prev_points = $players[$cur_player2];
						$players[$cur_player2] = ($rtm->Player2_points != NULL) ? ($prev_points + $rtm->Player2_points) : $prev_points;
					  }
				  }

						arsort($players);

						/*echo "<pre>"; print_r($players);*/
						$i = 4;
				foreach($players as $player => $points){
					echo "<td align='center'>";

					if($i > 0 and $points > 0){
						if($tour_details->tournament_format == 'Teams'){
							$get_team = league::get_team(intval($player));
							if($get_team['Team_Logo'] != NULL and $get_team['Team_Logo'] != ""){
							$team_logo = "<img style='width:35px;height:30px' src='".base_url()."team_logos/".$get_team['Team_Logo']."' alt='".$get_team['Team_name']."' />";
							}
							else{ 
							$team_logo = "<img style='width:35px;height:30px' src='".base_url()."team_logos/default_team_logo.png' alt='".$get_team['Team_name']."' />";
							}
							echo "<a>".$team_logo." ".$get_team['Team_name']."</a>";
							$get_team = "";
						}
						else{
						 $p = explode('-', $player);
							//echo $p[0];
							$get_name = league::get_username(intval($p[0]));
							echo "<a href='".base_url()."player/{$p[0]}' target='_blank'>".$get_name['Firstname']." ".$get_name['Lastname']."</a>";
							$get_pname = "";
							if($p[1]){
								//echo $p[1];
								$get_pname = league::get_username(intval($p[1]));
								echo "; "."<a href='".base_url()."player/{$p[1]}' target='_blank'>".$get_pname['Firstname']." ".$get_pname['Lastname']."</a>";
							}
						}
					}
					else{ echo "&nbsp;"; }
					echo "</td>";

					$i--;
				}
				if($i==1){ echo "<td align='center'>N/A</td>"; }

				} ?>
              </tr> 
              <?php 
              }
              ?>
              </table>
          
         </div>
         
             <div id="drawpopup" style="display:none;" class="overlay">
               <div class="draw_popup">
                <a class="close"  onclick="close_drawpopup();">&times;</a>
                 <div class="content" id="drawcontent">
                      
                  </div>
              </div>
            </div>
             <?php
            } ?>



             <div style="clear:both"></div>
       <?php 
       $sponsorsjsn = $tour_details->Sponsors;
        if($sponsorsjsn==""){    
        }else{
          $sponsors=json_decode($sponsorsjsn);
        ?> 
 
             
		<div class="batstubpage2" >
			<div class="container">
					<div class="land-client">
					<div class="leaghead" id="sponsors"><h2 style="padding-bottom:20px">Sponsors</h2></div>
					 <!--  -->
		<?php
		$sponsors = array();
		$sponsorsjsn = $tour_details->Sponsors;
		if($sponsorsjsn != ""){
		  $sponsors = json_decode($sponsorsjsn, true);
		}
		?> 
		<!-- <div align='center'> -->
		<ul id="sponsores" class="bxslider">
		<?php
		if(count($sponsors) > 1){
		//echo "<div id='slideshow2'>";
		}
		else
		{
		//echo "<div id='slideshow1'>";
		}
			foreach ($sponsors as $sponsor => $sponsor_addr_link)
			{
			if($sponsor_addr_link){
				if (!preg_match("~^(?:f|ht)tps?://~i", $sponsor_addr_link)) {
				$sponsor_addr_link = "http://" . $sponsor_addr_link;
				}
			?>
			<li><a target="_blank" href="<?php echo $sponsor_addr_link; ?>" style="cursor:pointer;"><img src="<?php echo base_url();?>tour_pictures/<?php echo $tour_details->tournament_ID;?>/sponsors/<?php echo $sponsor;?>" alt="" /></a>
			</li>
			<?php
			}
			else{
			?>
			<li>
			<img src="<?php echo base_url();?>tour_pictures/<?php echo $tour_details->tournament_ID;?>/sponsors/<?php echo $sponsor;?>" alt="" /></li>
			<?php
			}
			}
		?>
		</ul>
		<!-- </div> -->

		<!-- </div> -->
		<!--  -->
		</div>
			<div style="clear:both;"></div>
		 </div><!--container --> 
	 </div><!--batstubpage -->
	 <?php
      }
	  if($tour_details->tournament_format == 'Teams'){
      ?>
	     <div id="standings" class="leaghead"><h2 style="padding-bottom:20px" id="draws">Standings</h2></div>
         <div class="container">
         
              <table cellpadding="0" border="0" class="table table-striped">
              <tr>
                <th class="text-center">Pos</th>
                <th>Team</th>
                <th class="text-center">Played</th>
                <th class="text-center">Won</th>
                <th class="text-center">Lost</th>
                <th class="text-center">Total Points</th>
              </tr>

			  <?php
				$team_stat = array();

			  foreach($tourn_reg_teams as $team){
				  $played	= 0;
				  $won		= 0;
				  $lost		= 0;
				  $tp		= 0;
				  $tourn_matches = league::get_team_tourn_matches($team->Team_id, $tour_details->tournament_ID);

				  foreach($tourn_matches as $match){
						$source = '';
						if($match->Player1 == $team->Team_id){
							$line_matches = league::get_team_tourn_lines($match->Tourn_match_id);
							$source = 'Player1';
							$source_points = 'Player1_points';
						}
						else if($match->Player2 == $team->Team_id){
							$line_matches = league::get_team_tourn_lines($match->Tourn_match_id);
							$source = 'Player2';
							$source_points = 'Player2_points';
						}

						foreach($line_matches as $line){
						if($line->Winner != '' and $line->Winner != 0 and $line->Winner != NULL and $source){
							$played++;

							if($line->{$source} == $line->Winner){
							$won++;
							}
							else{
							$lost++;
							}

							$tp = $tp + $line->{$source_points};
						}

						}
					$team_stat[$team->Team_id]['played'] = $played;
					$team_stat[$team->Team_id]['won']    = $won;
					$team_stat[$team->Team_id]['lost']   = $lost;
					$team_stat[$team->Team_id]['tp']	 = $tp;
				  }
			  }
			  /*echo "<pre>";
			  print_r($team_stat);*/
			  //league::cmp()
			  //usort($team_stat, $this->cmp);
			  $sort_func = uasort($team_stat, array('league','compareOrder2'));
				$i = 1;
			  foreach($team_stat as $team => $standing){

			$tm	= league::get_team($team);

			if($tm['Team_Logo'] != NULL and $tm['Team_Logo'] != ""){
			$team_logo = "<img style='width:35px;height:30px' src='".base_url()."team_logos/".$tm['Team_Logo']."' alt='".$tm['Team_name']."' />";
			}
			else{ 
			$team_logo = "<img style='width:35px;height:30px' src='".base_url()."team_logos/default_team_logo.png' alt='".$tm['Team_name']."' />";
			}
			?>
			<tr>
                <td align='center'><?php echo $i; ?></td>
                <td><?php echo $team_logo." ".$tm['Team_name']; ?></td>
                <td align='center'><?php echo $standing['played']; ?></td>
                <td align='center'><?php echo $standing['won']; ?></td>
                <td align='center'><?php echo $standing['lost']; ?></td>
                <td align='center'><?php echo $standing['tp']; ?></td>
            </tr>
			<?php $i++;
			} ?>
			</table>
		</div>
<?php
	  }
?>

<div class="batstubpage3">
<div class="container">
<div class="leaghead" style="padding-top:20px;"><h2 style="padding-bottom:20px" id="social_wall">Social Wall</h2></div>
<div class="col-md-6">
<div class="leaghead"><h4>Twitter</h4></div>
<div style="height:466px;overflow-y:scroll;">
<a class="twitter-timeline" href="https://twitter.com/a2m_sports?ref_src=twsrc%5Etfw">Tweets by a2m_sports</a> <script async src="https://platform.twitter.com/widgets.js" charset="utf-8"></script>
</div>
</div>
<div class="col-md-6">
<div class="leaghead"><h4>Instagram</h4></div>
<div style="overflow-y:scroll; height:466px;">

<a href="https://instawidget.net/v/user/a2msports" id="link-e78b469f2fce99cfb53828b165616ddcc04e145cceba466e407e091f66854b8f">@a2msports</a>
<script src="https://instawidget.net/js/instawidget.js?u=e78b469f2fce99cfb53828b165616ddcc04e145cceba466e407e091f66854b8f&width=100%"></script>
</div>
</div>
<div style="clear:both;"></div>
</div>
</div><!--batstubpage -->
                    
                    
<div class="" style="padding-top:0px">
<div class="">                  
			<div class="leaghead" style="padding-top:20px;"><h2 style="padding-bottom:20px" id="contact_us">Contact us</h2></div>
			 <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js"></script>
			<script type="text/javascript" src="https://maps.google.com/maps/api/js?key=AIzaSyC0JNMWyyW6t1fSNyrprBJC2bWKG4btytc"></script>
			
			<?php
			$address	= '';
			if($tour_details->TournamentAddress != '' and $tour_details->TournamentAddress != 0){
			$address	= $tour_details->TournamentAddress;
			}
			$city		= $tour_details->TournamentCity;
			$state		= $tour_details->TournamentState;
			$country	= $tour_details->TournamentCountry;
			$zip		= $tour_details->PostalCode;
			$latitude	= $tour_details->latitude;
			$longitude	= $tour_details->longitude;
			?> 
<div class="info-company1 top-score-title" align="center">

<div>
<div style="padding-bottom:20px; height:300px" id="map">

</div>
<p style="padding-top:10px;">
<i class="fa fa-globe"></i><?php echo $address;?>, <?php echo $city;?>, <?php echo $state;?> <i class="fa fa-user"></i> <?php echo $tour_details->OrganizerName;?> <i class="fa fa-phone"></i> <?php echo $tour_details->ContactNumber;?> 
<i class="fa fa-envelope-o"></i>
<?php  $userdat = league::get_username($tour_details->Usersid);
echo $userdat['EmailID'];
?>
</p>
</div>
</div>
<div style="clear:both; border-top:0px solid #444; height:40px"></div>
</div><!--container --> 
</div><!--batstubpage -->
</section>
    

<script>
  // Starts google maps code

  var geocoder = new google.maps.Geocoder(); // initialize google map object
  var address = "<?php echo $address;?>, <?php echo $city;?>, <?php echo $state;?>, <?php echo $country;?>, <?php echo $zip;?>";
  geocoder.geocode( { 'address': address}, function(results, status) {
   
  if (status == google.maps.GeocoderStatus.OK) {
      var latitude = results[0].geometry.location.lat();
  var longitude = results[0].geometry.location.lng();
  var myCenter=new google.maps.LatLng(latitude,longitude);
         function initialize()
  {
  var mapProp = {
    center:myCenter,
    zoom:7,
    mapTypeId:google.maps.MapTypeId.ROADMAP
    };
   
  var map=new google.maps.Map(document.getElementById("map"),mapProp);
   
  var marker=new google.maps.Marker({
    position:myCenter,
    });
   
  marker.setMap(map);
  }
   
  google.maps.event.addDomListener(window, 'load', initialize); 
      } 
  }); 
      // var latitude="<?php echo $latitude;?>";
       //   var longitude="<?php echo $longitude;?>";

        /*function initMap() {
         
          var uluru = {lat: latitude, lng: longitude};
          var map = new google.maps.Map(document.getElementById('map'), {
            zoom: 4,
            center: uluru
          });
          var marker = new google.maps.Marker({
            position: uluru,
            map: map
          });
        }*/
    </script>
    <script type="text/javascript">
$("ul.bxslider li:first-child").addClass("highlight");
var baseurl="<?php echo base_url();?>";

function Getteamplayers(elmnt, team_id){
	var classname = elmnt.className;

	var tourn_id = '<?php echo $tour_details->tournament_ID;?>';
	$.ajax({
		type: 'POST',
		url: baseurl+'league/Getteamplayers',
		data:{tourn_id:tourn_id,team_id:team_id},
		success: function(res) {
		$(".teamnames").html(res);
		$("ul.bxslider li").removeClass("highlight");
		if(classname=="teamslide1"){
		$(elmnt).addClass("highlight");
		}   
		}
	});
}

	$("#slideshow2 > div:gt(0)").hide();
	setInterval(function() {
	$('#slideshow2 > div:first')
    .fadeOut(1000)
    .next()
    .fadeIn(1000)
    .end()
    .appendTo('#slideshow2');
	}, 5000);

    </script>
   <!--  <script async defer
    src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCEqhq8qelHU0FF4Ion9yaJ-X_n1FKJWBw&callback=initMap">
    </script> -->
    <!--Ends google map code-->

    <script type="text/javascript">
     function close_popup(i){

      $("#popup"+i).fadeOut();
     
   }
   function close_drawpopup(){
      $("#drawpopup").fadeOut();
   }
     
     $(function(){
       $( ".imagepopup" ).click(function() {
          var i = $(this).attr('id');
          $("#popup"+i).show();
       });
     $( ".show_draws" ).click(function() {
      var bid = $(this).attr('id');
          $.ajax({
            type: 'POST',
            url: baseurl+'league/ShowDraw/'+bid,
            success: function(res) {
              $("#drawpopup").show();
              $("#drawcontent").html(res);
            }
          });
      
     }); 
     });
    </script>