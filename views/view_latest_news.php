<section id="single_player" class="container secondary-page">

<div class="top-score-title right-score col-md-9">
<!-- start main body -->
<h3></h3>

<div class="col-md-12 league-form-bg">
<div class="fromtitle"><?php echo $news_id_det['News_title'] ?></div>

<div class="col-md-12">
<div class="pull-left" style="margin-right:20px">

<?php if(isset($news_id_det)){ ?>
<img class="" src="<?php echo base_url(); ?>tour_pictures/<?php 
if($news_id_det['SportsType_id'] == 1){echo "default_tennis.jpg"; }
else if($news_id_det['SportsType_id'] == 2){echo "default_table_tennis.jpg"; }
else if($news_id_det['SportsType_id'] == 3){echo "default_badminton.jpg"; }
else if($news_id_det['SportsType_id'] == 4){echo "default_golf.jpg"; }
else if($news_id_det['SportsType_id'] == 5){echo "default_racquet_ball.jpg"; }
else if($news_id_det['SportsType_id'] == 6){echo "default_squash.jpg"; }
else if($news_id_det['SportsType_id'] == 7){echo "default_pickleball.jpg"; }
else if($news_id_det['SportsType_id'] == 8){echo "default_chess.jpg"; }
else if($news_id_det['SportsType_id'] == 9){echo "default_carroms.jpg"; }
else if($news_id_det['SportsType_id'] == 10){echo "default_volleyball.jpg"; }
else if($news_id_det['SportsType_id'] == 11){echo "default_fencing.jpg"; }
else if($news_id_det['SportsType_id'] == 12){echo "default_bowling.jpg"; }
else if($news_id_det['SportsType_id'] == -1){echo "logo_fb.jpg"; }
?>" alt="" width="258px" height="154px" align="center" />
<br />
</div>
<div style="line-height:22px; text-align:justify">
<?php
echo "<b>" . $news_id_det['News_title'] . "</b>";
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