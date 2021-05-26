<div id='Tournaments' class="col-md-12" >
<h3>
<?php 
$get_sport = league::get_sport($sport);
echo $get_sport['Sportname']." Tournaments";
?>
</h3>
<div class="tab-content table-responsive">
<table id="searchtournaments" class="table tab-score">
<thead>
<tr class="top-scrore-table">
<td class="score-position" valign="center" align="center">Tournament</td>
<td class="score-position" valign="center" align="center">City</td>
<td class="score-position" valign="center" align="center">State</td>
<td class="score-position" valign="center" align="center">Date</td>
<td class="score-position" valign="center" align="center">Contact</td>
</tr>
</thead>
<?php 
if(count($leagues) == 0) {
?>
<tr>
<td style="padding-left:5px;"><h5>No Tournaments found.</h5></td>
<td></td>
<td></td>
<td></td>
<td></td>
</tr>
<?php
}
else {
?>
<tbody>
<!-- ******************** Events Code Starts Here. ************************** -->
<?php
foreach($events as $event) { 
if($event->EventImage!=""){$event_image = $event->EventImage; }
else if($sport == 1){ $event_image = "default_tennis.jpg";		}
else if($sport == 2){ $event_image = "default_table_tennis.jpg"; }
else if($sport == 3){ $event_image = "default_badminton.jpg";	}
else if($sport == 4){ $event_image = "default_golf.jpg";			}
else if($sport == 5){ $event_image = "default_racquet_ball.jpg"; }
else if($sport == 6){ $event_image = "default_squash.jpg";		}
else if($sport == 7){ $event_image = "default_pickleball_new.jpg";	}
else if($sport == 8){ $event_image = "default_chess.jpg";		}
else if($sport == 9){ $event_image = "default_carroms.jpg";		}
else if($sport == 10){ $event_image = "default_volleyball.jpg";  }
else if($sport == 18){ $event_image = "default_basketball1.jpg";  }

?>
<tr>
<td valign="center" style="padding-left:2px; font-size:14px;">
<div>
<img class="scale_image" src="<?php echo base_url(); ?>events_pictures/<?php echo $event_image;?>" alt="img" width="70px" height="70px" />
<?php $link = base_url()."events/".$event->Ev_ID; ?>
&nbsp;<a href='<?=$link;?>'>
<b><?=ucfirst($event->Ev_Title); ?></b>
</a>
</div>
</td>
<?php 
$eve_location = league::getEventLocation($event->Ev_Location);
?>
<td valign="center" style="padding-left:4px;">
<div><?=ucfirst($eve_location['loc_city']); ?></div>
</td>

<td valign="center" style="padding-left:4px;">
<div><?=ucfirst($eve_location['loc_state']); ?></div>
</td>

<td valign="center" style="padding-left:8px;">
<div style="display:none;">
<?php echo date('Y/m/d',strtotime($event->Ev_Start_Date)); ?> <!-- added for date sorting  -->
</div>
<?php echo date('m/d/Y',strtotime($event->Ev_Start_Date)); ?>
</td>

<td valign="center" style="padding:5px; font-weight:400;">
<div>
<?php
$phone = preg_replace("/^(\d{3})(\d{3})(\d{4})$/", "($1) $2-$3", $event->Ev_Contact_Num);
echo ucfirst($event->Ev_Organizer)."<br>".$phone;
?>
</div>
</td>
</tr>
<?php }?>
<!-- ******************** Events Code Ends Here. ************************** -->

<?php
foreach($leagues as $league) { 
	if($league->TournamentImage!=""){$tour_image = $league->TournamentImage; }
	else if($sport == 1){  $tour_image = "default_tennis.jpg";		 }
	else if($sport == 2){  $tour_image = "default_table_tennis.jpg"; }
	else if($sport == 3){  $tour_image = "default_badminton.jpg";	 }
	else if($sport == 4){  $tour_image = "default_golf.jpg";		 }
	else if($sport == 5){  $tour_image = "default_racquet_ball.jpg"; }
	else if($sport == 6){  $tour_image = "default_squash.jpg";		 }
	else if($sport == 7){  $tour_image = "default_pickleball_new.jpg";	 }
	else if($sport == 8){  $tour_image = "default_chess.jpg";		 }
	else if($sport == 9){  $tour_image = "default_carroms.jpg";		 }
	else if($sport == 10){ $tour_image = "default_volleyball.jpg";   }
	else if($sport == 11){ $tour_image = "default_fencing.jpg";		 }
	else if($sport == 12){ $tour_image = "default_bowling.jpg";		 }
	else if($sport == 16){ $tour_image = "default_cricket.jpg";		 }
	else if($sport == 18){ $tour_image = "default_basketball1.jpg";		 }
?>
<tr>
<td valign="center" style="padding-left:2px; font-size:14px;">
<div>
<img class="scale_image" src="<?php echo base_url(); ?>tour_pictures/<?php echo $tour_image;?>" alt="img" width="70px" height="70px" />
<?php
if($league->Short_Code != 'NULL' and $league->Short_Code != "" and $league->Short_Code != 'null') {
$link = base_url().$league->Short_Code;
}
else {
$link = base_url().$sport_segment."/".$league->tournament_ID;
}
?>
&nbsp;<a href='<?=$link;?>'>
<b><?=ucfirst($league->tournament_title); ?></b>
</a>
</div>
</td>

<td valign="center" style="padding-left:4px;">
<div><?=ucfirst($league->TournamentCity); ?></div>
</td>

<td valign="center" style="padding-left:4px;">
<div><?=ucfirst($league->TournamentState); ?></div>
</td>

<td valign="center" style="padding-left:8px;">
<div style="display:none;">
<?php echo date('Y/m/d',strtotime($league->StartDate)); ?> <!-- added hidden for date sorting (jQuery data tables) -->
</div>
<?php echo date('m/d/Y',strtotime($league->StartDate)); ?>
</td>

<td valign="center" style="padding:5px; font-weight:400;">
<div>
<?php
$phone = preg_replace("/^(\d{3})(\d{3})(\d{4})$/", "($1) $2-$3", $league->ContactNumber);
echo ucfirst($league->OrganizerName)."<br>".$phone;
?>
</div>
</td>
</tr>
<?php }?>
</tbody>
<?php
}
?>
</table>
</div>
</div>
<div class="clear"></div>