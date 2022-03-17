<section class="inner-page-wrapper course-list-wrapper tournaments-bg1">
<!-- form -->
	<div class="container">
		<div class="row">
			<div class="contact-form">
				<form action="#">
					<div class="col-md-2">&nbsp;</div>
					<div class="col-md-3">
					  <div class="form-group">
						<input class="form-control" id="nameId" required name="name" placeholder="Search Event" type="text">
					  </div>
					</div><!-- .col-md-6 -->
					<div class="col-md-3">
					  <div class="form-group">
						<select name="match_format" id="match_format" class="form-control" required="">
							<option value="">Sport</option>
							<option value="1">Tennis</option>
							<option value="2">Table Tennis</option>
							<option value="3">Badminton</option>
							<option value="7">Pickleball</option>
							<option value="18">Basketball</option>
							<?php
							if($org_details['Aca_ID'] == 1166){
							?>
							<option value="6">Squash</option>
							<option value="19">Athletics</option>
							<option value="20">Swimming</option>
							<?php
							}
							?>
						</select>
					  </div>
					</div>
					<div class="col-md-1">
					  <div class="form-group">
						<button type="submit" class="btn btn-default">Submit</button>
					  </div>
					</div><!-- .col-md-6 --> 
					<div class="col-md-2">&nbsp;</div>
			</div><!-- contact-form -->
		</div>
	</div><!-- form -->


  <div id='events' class="container">
    <div class="row">
<?php 
if(count($club_leagues) == 0 and count($club_events) == 0) {
?>
    <div class="col-md-12 col-sm-12">
		 No Tournaments / Events are listed yet!
	</div><!-- col-md-4 -->
<?php
}
else {

if(count($club_events) > 0){

foreach($club_events as $row) { 
?>
	<div class="col-md-3 col-sm-6">
	<!-- <div class="text-center col-md-3 col-md-offset-3"> -->
		 <div class="course-item">
			<div class="course-img">
			<a href="<?php echo base_url().$org_details['Aca_URL_ShortCode'].'/events/'.$row->Ev_ID; ?>">
			<img src="<?php echo base_url(); ?>events_pictures/<?php if($row->EventImage!=""){echo $row->EventImage; }
			else {
			switch($row->Ev_Sport) {
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
			case 7:
			echo "default_pickleball.jpg";
			break;
			case 8:
			echo "default_chess.jpg";
			break;
			case 9:
			echo "default_carroms.jpg";
			break;
			case 10:
			echo "default_volleyball.jpg";
			break;
			case 11:
			echo "default_fencing.jpg";
			break;
			case 12:
			echo "default_bowling.jpg";
			break;
			case 18:
			echo "default_basketball1.jpg";
			break;
			default:
			echo "";
			}
			}
			?>" alt="" style="/*width:261px; height:157px;*/  object-fit: contain; height:157px; margin-top: 5px;" />
			</a>
			</div>
			<div class="course-body">
				<div class="course-desc" style="min-height: 115px;">
					<h4 class="course-title" style='font-size:15px;'><a href="<?php echo base_url().$org_details['Aca_URL_ShortCode'].'/events/'.$row->Ev_ID; ?>"><?php echo $row->Ev_Title;?></a></h4>
					  <p><b>Sport:</b> <?php 
						$get_sport = events::get_sport($row->Ev_Sport);
						echo $get_sport['Sportname'];
						?><br>
						<!-- <b>Registration closed on:</b> <?php //echo date('m/d/Y',strtotime(substr($row->Registrationsclosedon,0,10))); ?><br> -->
						<b>Starts on:</b> <?php echo date('m/d/Y',strtotime(substr($row->Ev_Start_Date,0,10))); ?><br>
						<?php 
						$get_loc = events::get_location($row->Ev_Location);
						?>
						<b>Location:</b> <?php echo $get_loc['loc_city']. ', ' .$get_loc['loc_state']; ?></p>
						<?php 
						$now		  = strtotime("now");
						$end_date = strtotime($row->Ev_End_Date);

						if($end_date < $now){ ?>
						<b style="background-color:#2de033; padding:4px;">COMPLETED</b>
						<?php } ?>
				</div>
			</div>
		</div><!-- Events-item -->
	</div><!-- col-md-4 -->

<?php
}
}




foreach($club_leagues as $row) { 
?>
	<div class="col-md-3 col-sm-6">
		 <div class="course-item">
			<div class="course-img">
			<a href="<?php echo base_url().$org_details['Aca_URL_ShortCode'].'/league/'.$row->tournament_ID; ?>">
			<img title="<?=$row->tournament_title;?>" src="<?php echo base_url(); ?>tour_pictures/<?php if($row->TournamentImage!=""){echo $row->TournamentImage; }
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
			case 7:
			echo "default_pickleball.jpg";
			break;
			case 8:
			echo "default_chess.jpg";
			break;
			case 9:
			echo "default_carroms.jpg";
			break;
			case 10:
			echo "default_volleyball.jpg";
			break;
			case 11:
			echo "default_fencing.jpg";
			break;
			case 12:
			echo "default_bowling.jpg";
			break;
			case 18:
			echo "default_basketball1.jpg";
			break;
			default:
			echo "";
			}
			}
			?>" alt="" style="/*width:261px; height:157px;*/  object-fit: contain; height:157px; margin-top: 5px;" />
			</a>
			</div>
			<div class="course-body">
				<div class="course-desc">
					<h4 class="course-title" style='font-size:15px;'><a title="<?=$row->tournament_title;?>" href="<?php echo base_url().$org_details['Aca_URL_ShortCode'].'/league/'.$row->tournament_ID; ?>"><?php echo substr($row->tournament_title, 0, 24); if(strlen($row->tournament_title) > 24) echo "..."; ?></a></h4>
					  <p><b>Sport:</b> <?php 
						$get_sport = events::get_sport($row->SportsType);
						echo $get_sport['Sportname'];
						?><br>
						<b>Reg. closed on:</b> <?php echo date('m/d/Y',strtotime(substr($row->Registrationsclosedon,0,10))); ?><br>
						<b>Location:</b> <?php echo $row->TournamentCity. ',' . $row->TournamentState; ?></p>
						<?php 
						$now		  = strtotime("now");
						$end_date = strtotime($row->EndDate);

						if($end_date < $now){ ?>
						<b style="background-color:#2de033; padding:4px;">COMPLETED</b>
						<?php } else {?>
						<b style="padding:4px;">&nbsp;</b>
						<?php } ?>
				</div>
			</div>
		</div><!-- Tournaments-item -->
	</div><!-- col-md-4 -->

<?php
}

}
?>

    </div><!-- row -->
  </div>
</section>