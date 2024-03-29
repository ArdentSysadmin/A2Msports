<?php
$source = base_url().'assets_new/';
?>

<!-- banner start -->

<section class="banner mx-3 pt-5">
<div class="container-fluid">
<div class="row">
<div class="col-lg-6">
<!-- <div class="banner_content text-start text-light pl-30 pt-3 pb-2"> -->
<div class="banner_content text-start text-light pl-30 pt-3 pb-2">
<!-- <div class="m_show">
<img src="<?=$source;?>images/Pickleball - Graphic.png" class="mb-3">
</div> -->
<h1 class="font-45">Connecting Players, <br>Coaches and Clubs!</h1>
<p class="font-15">Our world class Sports Club Platform comes with Membership Management, Tournament and League Organization, Pay and Play (Court Reservations), Coach Booking, Event Management and more! We power your website and offer branded mobile app for the clubs with all these features built-in!</p>
<a  class="btn_banner " href="#popup1" type="button">Request a demo</a>
</div>

</div>
<div class="col-lg-6">
<div class="banner_content text-start text-light pt-3 pb-2 relative">
<div class="d-flex justify-content-between play_btn w-60 p-3">

<a onclick="lightbox_open();" style="cursor: pointer;"><img src="<?=$source;?>images/play.png" style="cursor: pointer;"></a>
<p class="mb-0 mt-3 mx-3">Watch how A2M connects the sports enthusiasts</p>

</div> 
<div id="slider d_show">  
<div class="slides ">  
<img src="<?=$source;?>images/men.png" width="100%" height="70%" class="slidrimg" />
</div>
<div class="slides">  
<img src="<?=$source;?>images/chino-rocha-2FKTyJqfWX8-unsplash-removebg-preview (1).png" class="slidrimg" width="100%" height="70%" />
</div>
<div class="slides">  
<img src="<?=$source;?>images/tt-home.png" width="100%" height="70%" class="slidrimg"/>
</div> 
<div class="slides">  
<img src="<?=$source;?>images/pickleball-home.png" width="100%" height="70%" class="slidrimg"/>
</div> 


<div id="dot"><span class="dot"></span><span class="dot"></span><span class="dot"></span><span class="dot"></span><span class="dot"></span></div>
</div>
</div>
</div>
</div>
</div>
</section>
<div id="light">
<a class="boxclose" id="boxclose" onclick="lightbox_close();"></a>
<video id="VisaChipCardVideo" width="600" controls>
<source src="<?=base_url();?>images/a2m1.mp4" type="video/mp4">
<!--Browser does not support <video> tag -->
</video>
</div>

<div id="fadevedio" onClick="lightbox_close();"></div>

<div>
<!-- banner end -->

<!--second banner start -->
<div class="container-fluid">
<div class="row">
<div class="col-lg-12">
<div class="heading text-center pt-5 pb-5">
<h1>Become an A2M Premium Club Member</h1>
</div>
</div>
</div>
</div>  
<!-- <div class="banner_two  mx-3 pt-5 mb-5 ">
<div class="container-fluid">
<div class="row">
<div class="col-lg-6">
<div class="banner_two_content pl-30 pt-5 mx-3">
<h1>Organize Events,<br>Tournaments & Leagues</h1>
<p>If you are a Coach trying to organize classes for different <br> groups, a team captain trying to manage.</p>
<a href="#" class="btn_orange">Become a A2M Club Member</a>
</div>
</div>
<div class="col-lg-6">
<div class="banner_img text-center">
<img src="<?=$source;?>images/mobile.png" class="w-50">
</div>
</div>
</div>
</div>
</div> -->
<style type="text/css">
.carousel-indicators [data-bs-target] {
box-sizing: content-box;
flex: 0 1 auto;
width: 20px;
border-radius: 50%;
height: 20px;
padding: 0;
margin-right: 3px;
margin-left: 3px;
text-indent: -999px;
cursor: pointer;
background-color: #774CFA;
background-clip: padding-box;
border: 0;
border-top: 10px solid transparent;
border-bottom: 10px solid transparent;
transition: opacity .6s ease;
}
.carousel-indicators .active {
box-sizing: content-box;
flex: 0 1 auto;
width: 20px;
border-radius: 50%;
height: 20px;
padding: 0;
margin-right: 3px;
margin-left: 3px;
text-indent: -999px;
cursor: pointer;
background-color: #F57549;
background-clip: padding-box;
border: 0;
border-top: 10px solid transparent;
border-bottom: 10px solid transparent;
transition: opacity .6s ease;
}

</style>
<div id="carouselExampleCaptions" class="carousel slide" data-bs-ride="carousel">
<div class="carousel-indicators">
<button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
<button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="1" aria-label="Slide 2"></button>
<!-- <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="2" aria-label="Slide 3"></button> -->
 </div>
<div class="carousel-inner">
<div class="carousel-item active">
<div class="banner_two  mx-3 pt-5 mb-5 ">
<div class="container-fluid">
<div class="row">
<div class="col-lg-6 pl-100" >
<div class="banner_two_content pl-30 pt-5 mx-3">
<h1>Organize Events,<br>Tournaments & Leagues</h1>
<p>If you are a Coach trying to organize classes for different <br> groups, a team captain trying to manage.</p>
<a href="<?=base_url()."login";?>" class="btn_orange">Sign up</a>
</div>
</div>
<div class="col-lg-6">
<div class="banner_img text-center">
<img src="<?=$source;?>images/mobile.png" class="w-50">
</div>
</div>
</div>
</div>
</div>
</div>
<div class="carousel-item">
<div class="banner_two  mx-3 pt-5 mb-5 ">
<div class="container-fluid">
<div class="row">
<div class="col-lg-6 pl-100" >
<div class="banner_two_content pl-30 pt-5 mx-3">
<h1>Sell Equipment or <br> Merchandise </h1>
<p>Give your Pro-shop a much needed uplift with online shopping experience</p>
<!-- <a href="#" class="btn_orange">Become a A2M Club Member</a> -->
</div>
</div>
<div class="col-lg-6">
<div class="banner_img text-center">
<img src="<?=$source;?>images/mobile.png" class="w-50">
</div>
</div>
</div>
</div>
</div>
</div>

</div>
</div>

<!--second banner end -->
<!--third banner start -->

<div id="carouselExampleCaptions2" class="carousel slide" data-bs-ride="carousel">
<div class="carousel-indicators">
<!-- <button type="button" data-bs-target="#carouselExampleCaptions2" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
<button type="button" data-bs-target="#carouselExampleCaptions2" data-bs-slide-to="1" aria-label="Slide 2"></button>
<button type="button" data-bs-target="#carouselExampleCaptions2" data-bs-slide-to="2" aria-label="Slide 3"></button> -->
</div>
<div class="carousel-inner">
<div class="carousel-item active">
<div class="mx-3 pt-5 mb-5 ">
<div class="container-fluid">
<div class="row">
<div class="col-lg-6">
<div class="pt-5 px-5 banner_three_one text-center text-light">
               <h2>Coach Booking</h2>
               <p class="mb-5">Schedule a Group or Private Lesson with Coaches<br /></p>
<img src="<?=$source;?>images/mob_2.png" class="w-60">
</div>
</div>
<div class="col-lg-6">
<div class="pt-5 px-5 banner_three_two text-center">
               <h2>Membership Management</h2>
               <p class="mb-5">Create unlimited number of Memberships and collect fees automatically</p>
<img src="<?=$source;?>images/desktop.png" class="w-60">
</div>
</div>
</div>
</div>
</div>
</div>

<!-- <div class="carousel-item">
<div class="  mx-3 pt-5 mb-5 ">
<div class="container-fluid">
<div class="row">
<div class="col-lg-6">
<div class="pt-5 px-5 banner_three_one text-center text-light">
<h2>Court Reservations</h2>
<p class="mb-5">200+ Available courts to book</p>
<img src="<?=$source;?>images/mob_2.png" class="w-60">
</div>
</div>
<div class="col-lg-6">
<div class="pt-5 px-5 banner_three_two text-center">
<h2>Membership <br>Management System</h2>
<p class="mb-5">If you are a Coach trying to organize classes for different</p>
<img src="<?=$source;?>images/desktop.png" class="w-60">
</div>
</div>
</div>
</div>
</div>
</div> -->

</div>

</div>
<!--third banner end -->
<!--fourth banner start -->
<div class="banner_two  mx-3 pt-5 mb-5 ">
<div class="container-fluid">
<div class="row">
<div class="col-lg-6">
<div class="banner_two_content pl-30 pt-5 mx-3">
<h1>Pay and Play <br>(Court Reservation System)</h1>
<p>Weather it's a dedicated Tennis, Badminton, or Squash Court, Table Tennis Tables or a shared Swimming Pool, you can book them here .</p>
<a href="<?=base_url()."login";?>" class="btn_orange">Sign up</a>
</div>
</div>
<div class="col-lg-6">
<div class="banner_img text-center">
<img src="<?=$source;?>images/mobile.png" class="w-50">
</div>
</div>
</div>
</div>
</div>
<!--fourth banner end -->

<!--seven banner start -->
<div class="bg-white">
<div class="container-fluid">
<div class="row">
<div class="heading text-center pt-5 pb-5">
<h1>Featured Tournaments / Leagues / Events</h1>
</div>
</div>
<div class="row">
<div id="feature" class="owl-carousel  owl-theme Testimonials">

<?php if(!empty($games)) { 
$i=1;
foreach($games as $row) {

if(!empty($row)) {
?>

<div class="item  "><!-- d-flex justify-content-between -->
<div class="d-flex feature_box">
<div class="feature_left bg-white p-3">
<div class="d-flex justify-content-start"><img src="<?=base_url()."assets_new/";?>images/icons/<?php switch($row[0]->SportsType){
					//case 1: echo "tennis.svg";		 break;
					case 2: echo "tt-ico.png"; break;
					case 3: echo "badminton-ico.png";	 break;
					case 4: echo "golf-ico.png";		 break; 
					} ?>" class="w-10" >
					<h6 class="uppercase mb-0 mx-3"><?php switch($row[0]->SportsType){
					case 1: echo "Tennis";		 break;
					case 2: echo "Table Tennis"; break;
					case 3: echo "Badminton";	 break;
					case 4: echo "Golf";		 break;
					case 5: echo "RacquetBall";	 break;
					case 6: echo "Squash";		 break;
					case 7: echo "Pickleball";	 break;
					case 8: echo "Chess";		 break;
					case 9: echo "Carroms";		 break;
					case 10: echo "Volleyball";	 break;
					case 11: echo "Fencing";	 break;
					case 12: echo "Bowling";	 break;
					case 16: echo "Cricket";	 break;
					} ?></h6></div>
<div class="day d-flex mt-1 mb-1">
<h1 class="mb-0"><?php echo date('d', strtotime($row[0]->StartDate)); ?></h1>
<h6 class="mx-3 mb-0"><?php echo strtoupper(date('M', strtotime($row[0]->StartDate))); ?> <br><?php echo date('h:i A', strtotime($row[0]->StartDate)); ?></h6>
</div>
<h6><a href="<?php
					if($row[0]->Short_Code != '' and $row[0]->Short_Code != NULL){
						echo base_url().$row[0]->Short_Code; } 
					else{ 
						echo base_url().'league/'.$row[0]->tournament_ID; } ?>" 
						title="<?php echo $row[0]->tournament_title; ?>">
					<?php $tour_title = $row[0]->tournament_title; $out = strlen($tour_title) > 29 ? substr($tour_title,0,29)."..." : $tour_title; echo $out; ?></a></h6>
                  <div class="d-flex justify-content-start mb-1"><img src="<?=base_url()."assets_new/";?>images/location.svg" class="w-10" ><p class="uppercase mb-0 mx-1"><?php echo trim($row[0]->TournamentCity).", ".trim($row[0]->TournamentState); ?></p></div>
                  <div class="d-flex justify-content-start mb-1"><img src="<?=base_url()."assets_new/";?>images/league.svg" class="w-10" ><p class="uppercase mb-0 mx-1"><?php echo $row[0]->tournament_format; ?></p></div>
<!-- <div class="d-flex justify-content-start mb-1"><img src="<?=$source;?>images/team.svg" class="w-10" ><p class="uppercase mb-0 mx-1"> 20 Teams</p></div> -->
</div>
<div class="feature_right">
<div class="feature_img">
<img src="<?php echo base_url(); ?>tour_pictures/
<?php if($row[0]->TournamentImage!=""){ echo $row[0]->TournamentImage; }
else{
switch($row[0]->SportsType) {
	case 1:
		echo "default_tennis_min.jpg";
		break;
	case 2:
		echo "default_table_tennis_min.jpg";
		break;
	case 3:
		echo "default_badminton_min.jpg";
		break;
	case 4:
		echo "default_golf_min.jpg";
		break;
	case 5:
		echo "default_racquet_ball_min.jpg";
		break;
	case 6:
		echo "default_squash_min.jpg";
		break;
	case 7:
		echo "default_pickleball_min.jpg";
		break;
	case 8:
		echo "default_chess_min.jpg";
		break;
	case 9:
		echo "default_carroms_min.jpg";
		break;
	case 10:
		echo "default_volleyball_min.jpg";
		break;
	case 11:
		echo "default_fencing.jpg";
		break;
	case 12:
		echo "default_bowling.jpg";
		break;
	case 16:
		echo "default_cricket.jpg";
		break;

	default:
		echo "";
		break;
}
}
?>" style="object-fit: fill; filter: blur(6px);  position: relative; height: 242px;" />

<img src="<?php echo base_url(); ?>tour_pictures/
<?php if($row[0]->TournamentImage!=""){ echo $row[0]->TournamentImage; }
else{
switch($row[0]->SportsType) {
	case 1:
		echo "default_tennis_min.jpg";
		break;
	case 2:
		echo "default_table_tennis_min.jpg";
		break;
	case 3:
		echo "default_badminton_min.jpg";
		break;
	case 4:
		echo "default_golf_min.jpg";
		break;
	case 5:
		echo "default_racquet_ball_min.jpg";
		break;
	case 6:
		echo "default_squash_min.jpg";
		break;
	case 7:
		echo "default_pickleball_min.jpg";
		break;
	case 8:
		echo "default_chess_min.jpg";
		break;
	case 9:
		echo "default_carroms_min.jpg";
		break;
	case 10:
		echo "default_volleyball_min.jpg";
		break;
	case 11:
		echo "default_fencing.jpg";
		break;
	case 12:
		echo "default_bowling.jpg";
		break;
	case 16:
		echo "default_cricket.jpg";
		break;

	default:
		echo "";
		break;
}
}
?>" style="object-fit: contain; top: 0px; position: absolute; width: 45%;" class="w-242">
</div>
</div>
</div>
</div>
 <?php
	}
  }
}
?>  

</div>
</div>
</div>
</div>
<!--seven banner end -->
<!--fifth banner start -->

<!--fifth banner end -->

<!--seven banner start -->
<div class="Latest_newa  m_show">
<div class="container-fluid">
<div class="row">
<div class="heading text-center pt-5 pb-5">
<h1>A2M Latest News</h1>
</div>
</div>
<div class="row">
<div id="Testimonials" class="owl-carousel owl-theme Testimonials">
<?php
foreach($results as $row){
?>

<div class="item  ">
<div class="latest_card d-flex mb-4 justify-content-between">
<div class="latest_img">
<img src="<?php echo base_url(); ?>tour_pictures/<?php 
switch($row->SportsType_id) {
case 1:
echo "default_tennis_min.jpg";
break;
case 2:
echo "default_table_tennis_min.jpg";
break;
case 3:
echo "default_badminton_min.jpg";
break;
case 4:
echo "default_golf_min.jpg";
break;
case 5:
echo "default_racquet_ball_min.jpg";
break;
case 6:
echo "default_squash_min.jpg";
break;
case 7:
echo "default_pickleball_min.jpg";
break;
case 8:
echo "default_chess_min.jpg";
break;
case 9:
echo "default_carroms_min.jpg";
break;
case 10:
echo "default_volleyball_min.jpg";
break;
case 11:
echo "default_fencing_min.jpg";
break;
case 12:
echo "default_bowling_min.jpg";
break;
case 16:
echo "default_cricket_min.jpg";
break;
default:
echo "logo_fb.jpg";
break;
} ?>" class="w-100">
<!-- <span class="date_upload">May 4, 2021</span> -->
</div>
<div class="latest_content p-4 bg-white">
<?php
$nt		= strip_tags($row->News_title);
$nts			= substr($nt, 0, 30);
?>
<h5><?php /*$nt = strip_tags($row->News_title);*/ echo strip_tags($nts) . "..."; ?></h5>                  <p><?php 
$abc		= strip_tags($row->News_content);
$s			= substr($abc, 0, 114);
$result  = substr($s, 0, strrpos($s, '.'));
echo strip_tags($s) . "...";
?></p>
<a href="<?=base_url().'news/'.$row->News_id; ?>">Read more</a>
</div>
</div>
</div>
<?php
	 }
?>

</div>
</div>
</div>
</div>
<!--seven banner end -->

<!--six banner start -->
<div class="container-fluid">
<div class="row">
<div class="col-lg-12">
<div class="heading text-center pt-5 pb-5">
<h1>Premium Clubs</h1>
</div>
</div>
</div>
</div>  
<div class="mx-3 mb-5">
<div class="container-fluid">
<div class="row">
<div id="company" class="owl-carousel owl-theme Testimonials">
<div class="item  ">
<div class="company">
<img src="<?=base_url()."assets_new/";?>images/premium_clubs/ARC.png">
</div>
</div>
<div class="item  ">
<div class="company">
<img src="<?=base_url()."assets_new/";?>images/premium_clubs/AUSSINICK.png">
</div>
</div>
<div class="item  ">
<div class="company">
<img src="<?=base_url()."assets_new/";?>images/premium_clubs/SATTA.png">
</div>
</div>
<div class="item  ">
<div class="company">
<img src="<?=base_url()."assets_new/";?>images/premium_clubs/SBA.png">
</div>
</div>
<div class="item  ">
<div class="company">
<img src="<?=base_url()."assets_new/";?>images/premium_clubs/WDCTT.png">
</div>
</div>
</div>
<div class="col-lg-12">
<!-- <section class="customer-logos slider">
<div class="slide"></div>
<div class="slide"><img src="<?=$source;?>images/c_logo (2).png"></div>
<div class="slide"><img src="<?=$source;?>images/c_logo (3).png"></div>
<div class="slide"><img src="<?=$source;?>images/c_logo (4).png"></div>
<div class="slide"><img src="<?=$source;?>images/c_logo (5).png"></div>
<div class="slide"><img src="<?=$source;?>images/c_logo (1).png"></div>
<div class="slide"><img src="<?=$source;?>images/c_logo (2).png"></div>
<div class="slide"><img src="<?=$source;?>images/c_logo (3).png"></div>
</section> -->
</div>
</div>
</div>
</div>
<!--six banner end -->
<!--seven banner start -->
<div class="bg-white">
<div class="container-fluid">
<div class="row">
<div class="heading text-center pt-5 pb-5">
<h1>Testimonials</h1>
</div>
</div>
<div class="row">
<div id="Testimonials1" class="owl-carousel owl-theme Testimonials">
<div class="item  ">
<div class="testimonials_box">
<div class=" p-4">
<img src="<?=$source;?>images/coma.png" class="w-10 mb-3">
<p>I got all I need for my academy and more from A2M Sports. It's a great platform with exceptional customer service. </p>
<br />
<div class="review_name d-flex justify-content-start align-items-center">
<img src="<?=base_url();?>profile_pictures/KSP1.jpg" class="w-15">
<h6 class="mx-3">Praveen Kolipaka<br> Sree Badminton Academy</h6>
</div>
</div>
</div>
</div>

<div class="item  ">
<div class="testimonials_box">
<div class=" p-4">
<img src="<?=$source;?>images/coma.png" class="w-10 mb-3">
 <p>The app is very well organized and really all players liked it and helped them track the scores and matches. I highly recommend the app for all sport to use. <br></p>
<div class="review_name d-flex justify-content-start align-items-center">
<img src="<?=base_url()."assets_new/";?>images/SamAwadallah.jpg" class="w-15">
<h6 class="mx-3">Sameh Boshra</h6>
</div>
</div>
</div>
</div>


</div>
</div>
</div>
</div>
<!--seven banner end -->

<!--Nine banner start -->
<div class="bg_nine mt-5 mb-5">
<div class="container-fluid">
<div class="row">
<div class="col-lg-10 offset-lg-1">
<div class="bg_app p-5 text-center text-light">
<h1 class="mb-5">Find A2M Sports<br>app on your mobile</h1>
<div class="app_imges">
<a href="https://apps.apple.com/in/app/a2m-sports/id1450412731" target="_blank">
<img src="<?=base_url()."assets_new/";?>images/Apple - App Store.png" />
</a>
<a href="https://play.google.com/store/apps/details?id=com.a2msports.a2msports3" target="_blank">
<img src="<?=base_url()."assets_new/";?>images/Google - Play Store.png" />
</a>
</div>
</div>
</div>
</div>
</div>
</div>
<!--Nine banner end -->

<!--Eight banner start -->
<div class="container-fluid d_show">
<div class="row">
<div class="col-lg-12">
<div class="heading text-center pt-5 pb-5">
<h1>A2M Latest News</h1>
</div>
</div>
</div>
</div>  
<div class="mx-3 mb-5">
<div class="container-fluid d_show">
<div class="row">
<div class="col-lg-6">
<div class="Latest_newa" style="padding: 1.5rem 1.5rem 1.5rem 1.5rem !important;">
 <?php
 $i = 1;
foreach($results as $row){

if($i <= 2){
?>
<div class="latest_card d-flex mb-4 justify-content-between">
<div class="latest_img">
<img src="<?php echo base_url(); ?>tour_pictures/<?php 
switch($row->SportsType_id) {
case 1:
echo "default_tennis_min.jpg";
break;
case 2:
echo "default_table_tennis_min.jpg";
break;
case 3:
echo "default_badminton_min.jpg";
break;
case 4:
echo "default_golf_min.jpg";
break;
case 5:
echo "default_racquet_ball_min.jpg";
break;
case 6:
echo "default_squash_min.jpg";
break;
case 7:
echo "default_pickleball_min.jpg";
break;
case 8:
echo "default_chess_min.jpg";
break;
case 9:
echo "default_carroms_min.jpg";
break;
case 10:
echo "default_volleyball_min.jpg";
break;
case 11:
echo "default_fencing_min.jpg";
break;
case 12:
echo "default_bowling_min.jpg";
break;
case 16:
echo "default_cricket_min.jpg";
break;
default:
echo "logo_fb.jpg";
break;
} ?>" class="w-100">
<span class="date_upload"><?=date('M d, Y', strtotime($row->Modified_on)); ?></span>
</div>
<div class="latest_content p-4 bg-white">
 <?php
					$nt		= strip_tags($row->News_title);
					$nts			= substr($nt, 0, 30);
				 ?>
                   <h5><?php /*$nt = strip_tags($row->News_title);*/ echo strip_tags($nts) . "..."; ?></h5>
                  <p><?php 
					$abc		= strip_tags($row->News_content);
					$s			= substr($abc, 0, 114);
					$result  = substr($s, 0, strrpos($s, '.'));
					echo strip_tags($s) . "...";
					?></p>
                  <a href="<?=base_url().'news/'.$row->News_id; ?>">Read more</a>
</div>
</div>
  <?php 
}
$i++;
}
?>  
</div>
</div>


<div class="col-lg-6">
<div class="Latest_newa" style="padding: 1.5rem 1.5rem 1.5rem 1.5rem !important;">
<?php
$i = 1;
foreach($results as $row){

if($i >= 5 and $i <= 6){
?>
<div class="latest_card d-flex mb-4 justify-content-between">
<div class="latest_img">
<img src="<?php echo base_url(); ?>tour_pictures/<?php 
			switch($row->SportsType_id) {
			case 1:
			echo "default_tennis_min.jpg";
			break;
			case 2:
			echo "default_table_tennis_min.jpg";
			break;
			case 3:
			echo "default_badminton_min.jpg";
			break;
			case 4:
			echo "default_golf_min.jpg";
			break;
			case 5:
			echo "default_racquet_ball_min.jpg";
			break;
			case 6:
			echo "default_squash_min.jpg";
			break;
			case 7:
			echo "default_pickleball_min.jpg";
			break;
			case 8:
			echo "default_chess_min.jpg";
			break;
			case 9:
			echo "default_carroms_min.jpg";
			break;
			case 10:
			echo "default_volleyball_min.jpg";
			break;
			case 11:
			echo "default_fencing_min.jpg";
			break;
			case 12:
			echo "default_bowling_min.jpg";
			break;
			case 16:
			echo "default_cricket_min.jpg";
			break;
			default:
			echo "logo_fb.jpg";
			break;
			} ?>" class="w-100">
<span class="date_upload"><?=date('M d, Y', strtotime($row->Modified_on)); ?></span>
</div>
<div class="latest_content p-4 bg-white">
<?php
					$nt2		= strip_tags($row->News_title);
					$nts2	= substr($nt2, 0, 30);
				 ?>
                   <h5><?php /*$nt = strip_tags($row->News_title);*/ echo strip_tags($nts2) . "..."; ?></h5>
                  <p><?php 
					$abc		= strip_tags($row->News_content);
					$s			= substr($abc, 0, 114);
					$result  = substr($s, 0, strrpos($s, '.'));
					echo strip_tags($s) . "...";
					?></p>
                  <a href="<?=base_url().'news/'.$row->News_id; ?>">Read more</a>
</div>
</div>
  <?php 
} 
$i++;
}
?> 
</div>
</div>
		 <div class='col-md-12' style="text-align: center; margin-top: 30px;">
<button type="button" id="news_btn" class="btn log_btn" data-bs-toggle="modal" data-bs-target="#exampleModal">
View All </button>
				</div>
</div>
</div>

</div>
<!--Eight banner end -->