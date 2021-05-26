<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>A2MSports</title>
<link href="<?php echo base_url();?>css/bootstrap.css" rel="stylesheet" type="text/css"/>
<!--<link href="css/bootstrap.min.css" rel="stylesheet" type="text/css" />-->

<link href='http://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,400,700,600,300' rel='stylesheet' type='text/css'/>
<link href='http://fonts.googleapis.com/css?family=Raleway:400,100,300,200,500,600,700,800,900' rel='stylesheet' type='text/css'/>
<link href='http://fonts.googleapis.com/css?family=Oswald:400,300,700' rel='stylesheet' type='text/css' />
<link href='http://fonts.googleapis.com/css?family=Lato:100,300,400,700,900,100italic,300italic,400italic,700italic,900italic' rel='stylesheet' type='text/css' />

<link href="<?php echo base_url();?>css/fonts/font-awesome-4.1.0/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
<!--Clients-->
<link href="<?php echo base_url();?>css/own/owl.carousel.css" rel="stylesheet" type="text/css" />
<link href="<?php echo base_url();?>css/own/owl.theme.css" rel="stylesheet" type="text/css" />

<link href="<?php echo base_url();?>css/jquery.bxslider.css" rel="stylesheet" type="text/css" />
<link href="<?php echo base_url();?>css/jquery.jscrollpane.css" rel="stylesheet" type="text/css" />

<link href="<?php echo base_url();?>css/minislide/flexslider.css" rel="stylesheet" type="text/css" />
<link href="<?php echo base_url();?>css/component.css" rel="stylesheet" type="text/css" />
<link href="<?php echo base_url();?>css/prettyPhoto.css" rel="stylesheet" type="text/css" />
<link href="<?php echo base_url();?>css/style_dir.css" rel="stylesheet" type="text/css" />
<link rel="shortcut icon" type="image/png" href="<?php echo base_url();?>images/favicon.png"/>
<link href="<?php echo base_url();?>css/responsive.css" rel="stylesheet" type="text/css" />
<link href="<?php echo base_url();?>css/animate.css" rel="stylesheet" type="text/css" />
<link href="<?php echo base_url();?>css/tabs.css" rel="stylesheet" type="text/css" />
<link href="<?php echo base_url(); ?>css/jquery.datepick.css" rel="stylesheet" type="text/css" />
<link href="<?php echo base_url();?>css/jquery.autocomplete.css" rel="stylesheet" type="text/css" />

<link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">

<link rel="stylesheet" href="<?php echo base_url();?>css/grid.css">
 
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
<!-- <script src="http://code.jquery.com/jquery-1.11.1.min.js"></script> -->
<script src="http://jqueryvalidation.org/files/dist/jquery.validate.min.js"></script>
<script src="http://jqueryvalidation.org/files/dist/additional-methods.min.js"></script>
</head>
<body>

<table width="700" border="0" cellspacing="0" cellpadding="0" align="center">
  <tr>
    <td style="border:2px solid #ff8a00">
    	<table width="696" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="172" style="padding:10px">
		<img class="scale_image" src="<?php echo base_url(); ?>images/logo.png" alt=""  />
	</td>
    <td width="524">
    	<div align="center" style="font-size:18px; font-weight:bold"><?php echo $tour_details->tournament_title; ?></div>
    </td>
  </tr>
  <tr>
    <td colspan="2" style="height:6px; background:#81a32b; font-size:6px"></td>
    </tr>
      </table>
      <br><br>
      <table width="670" border="0" cellspacing="0" cellpadding="0" align="center">
  <tr>
    <td width="" style="padding-left:10px;">
	<img class="" src="<?php echo base_url(); ?>tour_pictures/<?php if($tour_details->TournamentImage!=""){ echo $tour_details->TournamentImage; }
	else if($tour_details->SportsType == 1){echo "default_tennis.jpg"; }
	else if($tour_details->SportsType == 2){echo "default_table_tennis.jpg"; }
	else if($tour_details->SportsType == 3){echo "default_badminton.jpg"; }
	else if($tour_details->SportsType == 4){echo "default_golf.jpg"; }
	else if($tour_details->SportsType == 5){echo "default_racquet_ball.jpg"; }
	else if($tour_details->SportsType == 6){echo "default_squash.jpg"; }
	else if($tour_details->SportsType == 7){echo "default_pickleball.jpg"; }
	?>" alt="" height="200px" width="250px" />
	</td>
    <td width="392" style="line-height:25px">

<b>Duration:</b> <?php echo date('m/d/Y',strtotime(substr($tour_details->StartDate,0,10))); ?> - <?php echo date('m/d/Y',strtotime(substr($tour_details->EndDate,0,10))); ?><br>

<b>Registration Closed on:</b> <?php echo date('m/d/Y',strtotime(substr($tour_details->Registrationsclosedon,0,10))); ?><br>

<b>Sport:</b> <?php 
			 $get_sport = league::get_sport($tour_details->SportsType);
			 echo $get_sport['Sportname']; ?><br>

<b>Categories:</b> 
			  <?php 
				$match_array = array();
				if($tour_details->Singleordouble != "")
				{
				$match_array = json_decode($tour_details->Singleordouble);
				$numItems = count($match_array);

				if($numItems > 0)
				{
					foreach($match_array as $i => $group)
					{
						echo $group;
						if(++$i!=count($match_array)){
							echo ", ";
						}
					}
				}
				}
				?>
			  <br />
<b>Age Group:</b> 
			  <?php 
				$option_array = array();
				if($tour_details->Age != "")
				{
				$option_array = json_decode($tour_details->Age);
				$numItems = count($option_array);

				if($numItems > 0)
				{
					foreach($option_array as $i => $group)
					{
						echo $group;
						if(++$i!=count($option_array)){
							echo ", ";
						}
					}
				}
				}
				?>
				<br />

<b>Type of Bracket: </b> <?php echo $tour_details->Tournament_type; ?><br>

<b>Register at: </b> <a href="<?php echo base_url() .'league/view/'.$tour_details->tournament_ID; ?>"> <?php echo base_url() .'league/view/'.$tour_details->tournament_ID; ?></a><br>

<b>Venue:</b> 
	<?php if($tour_details->venue!=""){ echo  $tour_details->venue . ",<br>" ;}else{"";}?> 

	<?php if($tour_details->TournamentAddress!=""){ echo "<span style='margin-left:50px'>" . $tour_details->TournamentAddress . ",<br></span>";}?> 

	<?php if($tour_details->TournamentCity!=""){ echo "<span style='margin-left:50px'>" . $tour_details->TournamentCity . ",<br></span>" ;}?> 

	<?php if($tour_details->TournamentState!=""){ echo "<span style='margin-left:50px'>" . $tour_details->TournamentState . ",<br></span>" ;}?> 

	<?php if($tour_details->TournamentCountry!=""){ echo "<span style='margin-left:50px'>" . $tour_details->TournamentCountry . ",<br></span>" ;}?> 

	<?php if($tour_details->PostalCode!=""){ echo "<span style='margin-left:50px'>" . $tour_details->PostalCode . ".</span>"; } ?>
</td>
  </tr>
</table>
 <br><br>
 <div style="margin-left:20px; margin-right:20px; margin-bottom:20px">
 <table border="0" cellspacing="0" cellpadding="0" align="center">
  <tr>
    <td style="padding:15px; line-height:20px; background:#eeeeee; border-radius:10px;">
	<?php if($tour_details->TournamentDescription!=""){echo html_entity_decode($tour_details->TournamentDescription); }?>
	</td>
  </tr>
</table>
 </div>
 
 <table width="696" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td style="background:#81a32b; font-size:12px; padding:6px; color:#ffffff; text-align:center">© 2016 a2msports.com. All rights reserved.</td>
    </tr>
 </table>
    </td>
  </tr>
</table>

</body>
</html>
