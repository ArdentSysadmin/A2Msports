<section id="single_player" class="container secondary-page">
   <div class="top-score-title right-score col-md-9">

		<div class="col-md-12 league-form-bg" style="margin-top:40px; background:#fff; margin-bottom:20px">
           	<div class="fromtitle">Tournaments Album<div style="clear:both"></div></div>

				<?php 
				if(count($tourn_images) != 0)
				{
				
				foreach($tourn_images as $row) { ?>
	
				  <div class="col-md-4" style="margin-top:30px;">
					<a href="<?php echo base_url();?>league/images/<?php echo $row->tournament_ID;?>"><p align='center'>
					<img  src="<?php echo base_url(); ?>tour_pictures/<?php if($row->TournamentImage!=""){echo $row->TournamentImage; }
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
						
					  ?>" alt="" height="177px" width="236px" /></p></a>
					<br />
					<a href="<?php echo base_url();?>league/images/<?php echo $row->tournament_ID;?>"><b><p align='center'><?php echo $row->tournament_title;?></p></b></a>

					</div>

				 <?php }
					}
				 ?>
	    </div>
  </div>