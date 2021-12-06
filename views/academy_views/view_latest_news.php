<!-- Breadcromb Wrapper Start -->
<div class="breadcromb-wrapper">
<div class="breadcromb-overlay"></div>
<div class="container">
<div class="row">
<div class="col-sm-12">
<div class="breadcromb-left">
<h3>Latest News</h3>
</div>
</div>
</div>

</div>
</div>
<!-- Breadcromb Wrapper End --> 
<section id="single_player" class="secondary-page">
<div class='container'>
<div class='row'>
	<div class="col-md-9">
        <!-- start main body -->
		<!-- <h3></h3> -->	
<br />
		  <div class="col-md-12 league-form-bg">

           		<!-- <div class="fromtitle"><?php //echo $news_id_det['News_title'] ?></div> -->

                <div class="col-md-12">
                   <!-- <div class="pull-left" style="margin-right:20px">
					
					<?php 
					if(isset($news_id_det)){ 
					
					if($news_id_det['SportsType_id'])
						$sport = $org_details['Primary_Sport'];
					else
						$sport =  $news_id_det['SportsType_id'];
					?>
					<img class="" src="<?php //echo base_url(); ?>tour_pictures/<?php 
				/*if($sport == 1){echo "default_tennis.jpg"; }
				else if($sport == 2){echo "default_table_tennis.jpg"; }
				else if($sport == 3){echo "default_badminton.jpg"; }
				else if($sport == 4){echo "default_golf.jpg"; }
				else if($sport == 5){echo "default_racquet_ball.jpg"; }
				else if($sport == 6){echo "default_squash.jpg"; }
				else if($sport == 7){echo "default_pickleball.jpg"; }
				else {echo "default_pickleball.jpg"; }*/
			    ?>" alt="" width="258px" height="154px" align="center" />
			<br />
					</div> -->
					<div style="line-height:22px; text-align:justify">
					<?php
					echo "<b style='color: #123176; font-size: 18px;'>" . $news_id_det['News_title'] . "</b>";
					echo "<br />";
					echo "<br />";
					echo stripslashes($news_id_det['News_content']);
					echo "<br />";
					echo "<br />";
				?>
				 </div>	
               </div>
        </div>
		          <?php } ?>
             
   </div><!--Close Top Match-->