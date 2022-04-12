<link href="https://a2msports.com/css/jquery.autocomplete.css" rel="stylesheet" type="text/css">
<?php
$tourn_def_imgs = unserialize(TOURN_DEF_IMGS);
$tourn_def_icons = unserialize(TOURN_DEF_ICONS);
//print_r($tourn_def_imgs); exit;
?>
<style>


* { box-sizing: border-box; }
/*body { font: 16px Arial; } */
.autocomplete {
/*the container must be positioned relative:*/
position: relative;
display: inline-block;
}
input {
border: 1px solid transparent;
background-color: #f1f1f1;
padding: 10px;
font-size: 16px;
}
input[type=text] {
background-color: #f1f1f1;
width: 100%;
}
input[type=submit] {
background-color: DodgerBlue;
color: #fff;
}
.autocomplete-items {
position: absolute;
border: 1px solid #d4d4d4;
border-bottom: none;
border-top: none;
z-index: 99;
/*position the autocomplete items to be the same width as the container:*/
top: 100%;
left: 0;
right: 0;
}
.autocomplete-items div {
padding: 10px;
cursor: pointer;
background-color: #fff;
border-bottom: 1px solid #d4d4d4;
}
.autocomplete-items div:hover {
/*when hovering an item:*/
background-color: #e9e9e9;
}
.autocomplete-active {
/*when navigating through the items using the arrow keys:*/
background-color: DodgerBlue !important;
color: #ffffff;
}
/* -----------------------------*/
/*body {font-family: Arial, Helvetica, sans-serif;}*/

#myImg {
border-radius: 5px;
cursor: pointer;
transition: 0.3s;
}

#myImg:hover {opacity: 0.7;}

/* The Modal (background) */

.modal {
display: none; /* Hidden by default */
position: relative; /* Stay in place */
z-index: 1; /* Sit on top */
padding-top: 0px; /* Location of the box */
left: 0;
/*top: 0;*/
top: 320pz;
width: 100%; /* Full width */
/*height: 100%;*/ /* Full height */
height: 400px; /* Full height */
overflow: auto; /* Enable scroll if needed */
background-color: rgb(0,0,0); /* Fallback color */
background-color: rgba(0,0,0,0.05); /* Black w/ opacity */
}

/* Modal Content (image) */

.modal-content {

margin: auto;
display: block;
height:400px;
/*width: 80%;*/

/*max-width: 700px;*/
}



/* Caption of Modal Image */

#caption {
margin: auto;
display: block;
width: 80%;
max-width: 700px;
text-align: center;
color: #ccc;
padding: 10px 0;
height: 150px;
}



/* Add Animation */

.modal-content, #caption { 
-webkit-animation-name: zoom;
-webkit-animation-duration: 0.6s;
animation-name: zoom;
animation-duration: 0.6s;
}



@-webkit-keyframes zoom {
from {-webkit-transform:scale(0)}
to {-webkit-transform:scale(1)}
}



@keyframes zoom {
from {transform:scale(0)}
to {transform:scale(1)}
}


/* The Close Button */

.close {
position: absolute;
top: 15px;
right: 20%;
color: #724d93;
font-size: 60px;
font-weight: bold;
transition: 0.3s;
z-index: 20;
}



.close:hover,

.close:focus {
color: #bbb;
text-decoration: none;
cursor: pointer;
}


/* 100% Image Width on Smaller Screens */

@media only screen and (max-width: 700px){
.modal-content {
width: 100%;
}

}


.clearfix:after {
content: "";
display: table;
clear: both;
}



/* Next & previous buttons */

.prev,

.next {

cursor: pointer;
position: absolute;
top: 50%;
width: auto;
padding: 16px;
margin-top: -50px;
color: #c08bda;
font-weight: bold;
font-size: 30px;
transition: 0.6s ease;
border-radius: 0 3px 3px 0;
user-select: none;
-webkit-user-select: none;
}


/* Position the "next button" to the right */

.next {
/*right: 0;*/
right:20%;
border-radius: 3px 0 0 3px;
}

.prev { left:20%; }

/* On hover, add a black background color with a little bit see-through */

.prev:hover,
.next:hover {
background-color: rgba(0, 0, 0, 0.8);
}

</style>
<!-- banner start -->

<section class="banner mx-3 pt-3">
<div class="container-fluid">
<div class="row">
<div class="col-lg-8">
<div class="banner_content text-start text-light pl-30 pt-3 pb-2">
<h1 class="font-45">Connecting players, <br>Coaches and Clubs!</h1>
<p class="font-15">Tournaments and Leagues, Court Reservations, Coach Booking, Team Communications and more! <br> For clubs, we host your website and offer branded mobile app with all these features built-in! <br></p>
<a  class="btn_banner " href="#popup1" type="button" style='margin-bottom: 60px; background:#fc8460; color:#fff'>Request a Demo</a>

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

<div class="col-lg-4">
<!-- POW -->
<div class="gallery_card text-center pt-2 pb-3 mb-2" style="background:#fff;">
<div id='pom_div'>
<img src="<?=base_url()."assets_new/";?>images/g_logo.png" class="mb-3">
<?php
if($this->logged_user == 240)
echo "<button name='edit_pom' id='edit_pom'>Edit</button>";
?>
<h4>Player of the Week</h4>
<?php if($org_pom) {?> 
<a href="<?php echo base_url();?>player/<?php echo $org_pom;?>">
<img src="<?php echo base_url(); ?>profile_pictures/<?php if($get_user['Profilepic']!=""){ echo $get_user['Profilepic']; } else { echo "default-profile.png"; }?>" class="w-80 player-month mt-2 mb-2" style="width: 40%; height:auto;">
<h4 class="mt-3"><?php echo ucfirst($get_user['Firstname'])." ".ucfirst($get_user['Lastname']); ?></h4>
</a>
<!-- <p class="club_info d-flex justify-content-center align-items-center mb-2">
<img src="<?=base_url()."assets_new/";?>images/location.png"><?php //echo $get_user['City'].", ".$get_user['State']; ?>
</p> -->
<?php } else { echo "No Player is declared yet!"; } ?>
<!-- <p class="club_info d-flex justify-content-center align-items-center mb-0 pb-2"><img src="<?=base_url()."assets_new/";?>images/date.png"> Oct, 2018</p> -->
</div>


<?php
if($this->logged_user == 240){
?>
<div id='edit_pom_div' style='display: none;'>
<!-- <form name='frm_pom' method='post' action='<?=base_url()."league/update_pom"; ?>'>
<label>Choose player of the week</label>
<input class='ui-autocomplete-input form-control inwidth' id='created_by' name='created_by' type='text' placeholder="Type player name.." value="" />
<input id='pom_user_id' name='pom_user_id' type='hidden' value='' />
<input type='submit' name='upd_pom' id='upd_pom' value='Update' />
&nbsp;&nbsp;&nbsp;
<input type='button' name='cancel_pom' id='cancel_pom' value='Cancel' />
</form> -->

<!--Make sure the form has the autocomplete function switched off:-->
<form autocomplete="off" method='post' action='<?=base_url()."league/update_pom"; ?>'>
<div class="autocomplete" style="width:300px;">
<input id="myInput" type="text" name="myCountry" placeholder="Type in user name" style="margin-bottom: 20px;margin-top: 18px;border-radius: 0.5em;">
<input id='pom_user_id' name='pom_user_id' type='hidden' value='' />
<input id='pom_sport' name='pom_sport' type='hidden' value='<?=$sport;?>' />
<input type='submit' name='upd_pom' id='upd_pom' value='Update' />
&nbsp;&nbsp;&nbsp;
<input type='button' name='cancel_pom' id='cancel_pom' value='Cancel' />
</div>
</form>

</div>
<?php
}
?>

</div>
<!-- POW -->

</div>
</div>


</div>
</div>
</div>
</section>
<!-- banner end -->

<!-- Featured tournaments start -->
<div class="bg-white">
<div class="container-fluid">
<div class="row">
<div style='padding-bottom:15px !important; padding-top:3rem !important;' class="heading text-center pt-5 pb-5">
<h1>Featured Tournaments / Leagues </h1>
</div>
</div>
<div class="row">
<div id="feature" class="owl-carousel  owl-theme Testimonials" style="margin-top: -45px;">

<?php
//echo "<pre>"; print_r($leagues); exit;
if(!empty($top_leagues)) { 
$i=1;
foreach($top_leagues as $j => $row) {

if(!empty($row)) {
?>
<div class="item  "><!-- d-flex justify-content-between -->
<div class="d-flex feature_box">
<div class="feature_left /*bg-white*/ p-3" style="border-top-right-radius:0px !important; border-bottom-right-radius:0px !important; background-color:#fcc9bc !important; height:250px; border:2px solid #f88264">
<div class="d-flex justify-content-start">

</div>
<div class="day d-flex mt-1 mb-1">
<h1 class="mb-0"><?php echo date('d', strtotime($row->StartDate)); ?></h1>
<h6 class="mx-3 mb-0"><?php echo strtoupper(date('M', strtotime($row->StartDate))); ?> <br><?php echo date('h:i A', strtotime($row->StartDate)); ?></h6>
</div>
<h6 style="font-size: 1.3rem !important; <?php echo strlen($row->tournament_title) > 15 ? "margin-botton:1px;" : "margin-bottom: 20px;"; ?>"> <a href="<?php
if($row->Short_Code != '' and $row->Short_Code != NULL){
echo base_url().$row->Short_Code; } 
else{ 
echo base_url().'league/'.$row->tournament_ID; } ?>" 
title="<?php echo $row->tournament_title; ?>">
<?php $tour_title = $row->tournament_title; $out = strlen($tour_title) > 22 ? substr($tour_title,0,22)."..." : $tour_title; echo $out; ?></a></h6>
<div class="d-flex justify-content-start mb-1"><img src="<?=base_url()."assets_new/";?>images/location.svg" class="w-10" >
<p class="uppercase mb-0 mx-1" style='font-size: 13px !important;'><?php echo trim($row->TournamentCity).", ".trim($row->TournamentState); ?></p>
</div>

<div class="d-flex justify-content-start mb-1">
<img src="<?=base_url()."assets_new/";?>images/league.svg" class="w-10" >
<p class="uppercase mb-0 mx-1" style='font-size: 13px !important;'><?php echo $row->tournament_format; ?></p>
</div>

<!-- <div class="d-flex justify-content-start mb-1"> -->

<?php if(strtotime($row->Registrationsclosedon) < strtotime(date('Y-m-d H:i:s')) and strtotime($row->StartDate) > strtotime(date('Y-m-d H:i:s'))) {
?>
<div class="state" style="background-color: #333333 !important;color: #ffffff !important; padding: 5px; border-radius: 7px; font-size: 14px; margin-top:10px;">Registrations Closed</div>
<?php
}
else if(strtotime($row->StartDate) < strtotime(date('Y-m-d H:i:s'))){ 
?>
<div class="state" style="background-color: #333333 !important;color: #ffffff !important; padding: 5px; border-radius: 7px; font-size: 14px; margin-top:10px;">Completed</div>
<?php
} 
else if(strtotime($row->StartDate) > strtotime(date('Y-m-d H:i:s')) and strtotime($row->Registrations_Open_on) < strtotime(date('Y-m-d H:i:s'))){ 
?>
<div class="state" style="background-color: #14b641 !important;color: #ffffff !important; padding: 5px; border-radius: 7px; font-size: 14px; margin-top:10px;">Registrations Open</div>
<?php
} 
?>
<!-- </div> -->


<!-- <div class="d-flex justify-content-start mb-1"><img src="<?=base_url()."assets_new/";?>images/team.svg" class="w-10" ><p class="uppercase mb-0 mx-1"> 20 Teams</p></div> -->
</div>
<div class="feature_right" style="border:2px solid #8050ef; background-color:#d7ccfa; height:250px; border-top-right-radius:16px !important; border-bottom-right-radius:16px !important; ">
<div class="feature_img">
<a href="<?php if($row->Short_Code != '' and $row->Short_Code != NULL){ echo base_url().$row->Short_Code; } 
else{ echo base_url().'league/'.$row->tournament_ID; } ?>" title="<?php echo $row->tournament_title; ?>">
<img src="<?php echo base_url(); ?>tour_pictures/
<?php if($row->TournamentImage!=""){ echo $row->TournamentImage; }
else{
switch($row->SportsType) {
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
case 18:
echo "default_basketball.jpg";
break;
case 19:
echo "default_handball.jpg";
break;
case 18:
echo "default_paddleball.jpg";
break;

default:
echo "";
break;
}
}
?>" style="object-fit: cover; padding:1px; /*border:1px solid #d2d2d2; top: 0px; position: absolute; width: 45%;*/ height:247px; " class="/*w-242*/">
</a>
</div>
</div>
</div>
</div>
<?php
}
// if($i == 3) break; 				  $i++;
}
}
?>  

</div>
<div class="sport_blue_btn col-lg-12 mt-2 mb-4">
<div class="btn_blue text-center">
<a href="<?=base_url().$this->uri->segment(1).'/tournaments';?>" class="blue_btn show_all" id="vtournaments">View All Tournaments</a>
</div>
</div>
</div>
</div>
</div>
<!-- Featured tournaments banner end -->

<!--fourth banner start -->
<div class="banner_pagetwo_  mx-3 pt-3 mb-5 ">
<div class="container">
<div class="row banner_pagetwo_two">
<div class="col-lg-8 pb-0">
<div class="banner_two_content pl-30 pt-4 mx-3">
<h1 class="mb-2" style="text-align: var(--txt_align_left);">Challenge Players</h1>
<p class="mb-3 mt-3" style="text-align: var(--txt_align_left);">Can't wait till the next tournament? You can find and "Challenge" <br> other players to play with you. We will reward you everytime <br> you challenge someone with more points towards your A2M <br>Score.</p>
<p style="text-align: var(--txt_align_left);"><a href="<?=base_url().$this->uri->segment(1)."/players";?>" class="btn_orange" style="padding: 10px 25px;">Find a Player</a></p>
</div>
</div>
<div class="col-lg-4 p-0">
<div class="banner_img text-center">
<img src="<?=base_url()."assets_new/";?>images/image 30.png" class="w-100 brb_r">
</div>
</div>
</div>
</div>
</div>
<!--fourth banner end -->

<!-- livescore banner start -->
<div class="banner_pagetwo_  mx-3 pt-3 mb-5 ">
<div class="container">
<div class="row banner_pagetwo_two" style="background: url(../images/blue_pic.png), #d7ccfa !important;">

<div class="col-lg-4 p-0">
<div class="banner_img_l text-center">
<img src="<?=base_url()."assets_new/";?>images/Score.png" class="w-100 brb_l">
</div>
</div>

<div class="col-lg-8 pb-0">
<div class="banner_two_content pl-30 pt-3 mx-3">
<h1 class="mb-2" style="text-align: var(--txt_align_right);">Add Live Score</h1>
<p class="mb-2 mt-3" style="text-align: var(--txt_align_right);">You simply want to keep track of all your matches you play everyday. Just click</p>
<p class="mb-0 mt-2" style="text-align: var(--txt_align_right);"><a href="<?=base_url()."addscore";?>" class="btn_orange text-center">Add score</a></p>
</div>
</div>
</div>
</div>
</div>
<!-- livescore banner end -->



<!-- Active Teams -->     
<!-- End of Active Teams -->     

<!--sreach banner start -->
<!-- <div class="banner_pagetwo_  pt-2 mb-5 ">
<div class="container">
<div class="row ">

<div class="col-lg-6">
<div class="banner_two_content orange_pic p-3 sreach_orange_bg" style="1.5rem !important">
<h1 class="mb-2">Search Easily</h1>
<p class="mb-3 mt-3">Search for Players, Matches and  Tournaments<br />&nbsp;</p>
<a href="<?=base_url().$this->uri->segment(1)."/players";?>" class="btn_orange text-center">Search now</a>
</div>
<div class="sreach_img text-center">
<img src="<?=base_url()."assets_new/";?>images/sreach.png" class="w-100">
</div>
</div>

<div class="col-lg-6">
<div class="banner_two_content blue_pic p-3 sreach_blue_bg" style="1.5rem !important">
<h1 class="mb-2">Add Live Score</h1>
<p class="mb-3 mt-3">You simply want to keep track of all your matches you play everyday. Just click</p>
<a href="<?=base_url()."addscore";?>" class="btn_orange text-center">Add score</a>
</div>
<div class="sreach_img text-center">
<img src="<?=base_url()."assets_new/";?>images/Socre.png" class="w-100">
</div>
</div>

</div>
</div>
</div> -->
<!--sreach banner end -->



<!-- Top clubs -->
<!-- end of Top clubs -->

<!-- Top coaches -->
<!-- end of Top coaches -->






<!--Eight banner start --> 
<!-- <div class="mx-3 mb-5 mt-5 eight_banner">
<div class="container-fluid">
<div class="row">
<div class="col-lg-12">
<div class="heading text-center pt-2 pb-5">
<h1 id='viewAll'>Join a team. Compete in a tournament. <br> Connect to players and coaches. </h1>
</div>

<div class="tabs position-relative">
<div class="tab_btn">
<button class="filter mixitup-control-active" type="button"
data-filter=".category-a">Tournaments</button>
<button class="filter" type="button" data-filter=".category-b">Players</button>
<button class="filter" type="button" data-filter=".category-c">Teams</button>
<button class="filter" type="button" data-filter=".category-d">Clubs</button>
<button class="filter" type="button" data-filter=".category-e">Coaches</button>
</div>
<div class="tab_content">

<div class="item_1 mix category-a" data-order="1">
<div class="row mt-5">
<div class="col-lg-10 offset-lg-1">
<div class="bg-white p-3">
<div class="head d-flex justify-content-between align-items-center">
<h4 class="gry mb-0">Filter</h4>
<div class="input-group w-30 mb-3 sreach_filter">
<button class="btn btn-outline-secondary border-orange bg-orange" type="button" id="button-addon1">Search</button>
<input type="text" class="form-control" placeholder="Search by Name,City,State" aria-label="Example text with button addon" aria-describedby="button-addon1">
</div>
</div>
<div class="middle d-flex justify-content-between align-items-center">
<div class="Filter_middle_box align-items-center  d-flex justify-content-start">
<p class="mb-0">Tournament Date</p>
<ul class="filter">
<li class="nav-item dropdown">
<a class="dropdown-toggle" data-bs-toggle="dropdown" href="#" role="button" aria-expanded="false">This Year <img src="<?=base_url()."assets_new/";?>images/downarrow.png"></a>
<ul class="dropdown-menu">
<li><a class="dropdown-item" href="#">This Week</a></li>
<li><a class="dropdown-item" href="#">Next Week</a></li>
<li><a class="dropdown-item" href="#">This Month</a></li>
<li><a class="dropdown-item" href="#">Next 3 months</a></li>
<li><a class="dropdown-item" href="#">Custom</a></li>
</ul>
</li>
</ul>
</div>
<div class="Filter_middle_box align-items-center d-flex justify-content-start">
<p class="mb-0">Registration Status</p>
<ul class="filter">
<li class="nav-item dropdown">
<a class="dropdown-toggle" data-bs-toggle="dropdown" href="#" role="button" aria-expanded="false">All  <img src="<?=base_url()."assets_new/";?>images/downarrow.png"></a>
<ul class="dropdown-menu">
<li><a class="dropdown-item" href="#">Open</a></li>
<li><a class="dropdown-item" href="#">Closed</a></li>
</ul>
</li>
</ul>
</div>

</div>

<div class="table_content relative">

<table class="table table-striped">
<thead>
<tr>
<th scope="col">Tournment</th>
<th scope="col">City</th>
<th scope="col">State</th>
<th scope="col">Date</th>
<th scope="col">Contact</th>
</tr>
</thead>
<tbody>
<?php
if(!empty($leagues)) { 
//$i=1;
foreach($leagues as $j => $row) {
?>
<tr>
<td >
<div class="names_table align-items-center d-flex">
<img src="<?php echo base_url(); ?>tour_pictures/
<?php if($row->TournamentImage!=""){ echo $row->TournamentImage; }
else{
switch($row->SportsType) {
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
?>">
<p class="mb-0"><a href="<?=base_url();?>league/<?=$row->tournament_ID;?>"><?=$row->tournament_title;?></a></p>
</div>
</td>
<td><p class="mt-3 mb-0"><?=$row->TournamentCity;?></p></td>
<td><p class="mt-3 mb-0"><?=$row->TournamentState;?></p></td>
<td><p class="mt-3 mb-0"><?=date('m/d/Y', strtotime($row->StartDate));?></p></td>
<td><p class="mt-3 mb-0"><?=$row->OrganizerName;?></p></td>
</tr>
<?php
}
}
?>

</tbody>
</table>
<?php if(!$this->session->userdata('user')) {?>
<div class="sing_up_theme">
<div class="text-center text_bottom">
<h1 class="text-light mb-5">Sign up for Complete Access</h1>
<div class="btn_blue text-center">
<a href="<?=base_url()."login";?>" class="white_btn">Sign Up</a>
</div>
</div>
</div>
<?php } ?>
</div>
</div>
</div>
</div>
</div>



<div class="item_1 mix category-b" data-order="2">
<?php //echo $this->load->view('sports/view_nw_players'); ?>
</div>
<div class="item_1 mix category-c" data-order="3">
<?php //echo $this->load->view('sports/view_nw_teams'); ?>
</div>
<div class="item_1 mix category-d" data-order="4">
<?php //echo $this->load->view('sports/view_nw_clubs'); ?>
</div>
<div class="item_1 mix category-e" data-order="5">
<?php //echo $this->load->view('sports/view_nw_coaches'); ?>
</div>

</div>

</div>
</div>
</div>
</div> -->
<!--Eight banner end -->


<!--Eight banner start --> 
<!-- <div class="mx-3 mb-5 d_show"> -->
<div class="mx-3 mb-5">
<div class="container-fluid">
<div class="row">

<div class="col-lg-6">
<div class="heading text-center pt-4 pb-2">
<h1><a href="<?=base_url().'news';?>" style='color:#000'>A2M Latest News</a></h1>
</div>
<div class="Latest_newa p-4 ">
<?php
//echo "<pre>"; print_r($results); exit;
foreach($results as $row){
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
case 18:
echo "default_basketball_min.jpg";
break;
case 19:
echo "default_handball_min.jpg";
break;
case 20:
echo "default_paddleball_min.jpg";
break;
default:
echo "logo_fb.jpg";
break;
} ?>" class="w-100" style="object-fit: cover;">
<span class="date_upload"><?php echo date('M d, Y', strtotime($row->Modified_on)); ?></span>
</div>
<div class="latest_content p-4 bg-white">
<?php
$nt		= strip_tags($row->News_title);
$nts		= substr($nt, 0, 60);
?>
<h5><?php /*$nt = strip_tags($row->News_title);*/ echo strip_tags($nts) . "..."; ?></h5> 
<p><?php 
$abc		= strip_tags($row->News_content);
$s			= substr($abc, 0, 114);
$result		= substr($s, 0, strrpos($s, '.'));
echo strip_tags($s) . "...";
?></p>
<a href="<?=base_url().'news/'.$row->News_id; ?>">Read more</a>
</div>
</div>
<?php
}
?>

</div>
</div>

<div class="col-lg-6">
<div class="heading text-center pt-4 pb-2">
<h1>Global News</h1>
</div>
<iframe src='https://it4gov.net/dev/rss/a2msports.php' onload='javascript:(function(o){o.style.height=o.contentWindow.document.body.scrollHeight + 200 + "px";}(this));' style="height:1000px;width:100%;border:none;overflow:hidden;"></iframe>

<?php
/*$left_container = "";
$right_container = "";
//header( "content-type: application/xml; charset=ISO-8859-15" );
$rss = new DOMDocument();
$feed = array();
$urlarray = array(
array('name' => 'Google Feed',       'url' => 'https://www.google.com/search?q=pickleball&sxsrf=APq-WBsva2alsagYWFA6pGrXVH5nz4Hakw:1648564879495&source=lnms&tbm=nws&sa=X&ved=2ahUKEwjN3p_gxuv2AhWVKM0KHTR3CLMQ_AUoBHoECAEQBg&biw=1536&bih=746&dpr=1.25'),
);

foreach ( $urlarray as $url ) {
$rss->load( $url['url'] );

foreach ( $rss->getElementsByTagName( 'item' ) as $node ) {
$item = array(
'site'  => $url['name'],
'title' => $node->getElementsByTagName( 'title' )->item( 0 )->nodeValue,
'description'  => $node->getElementsByTagName( 'description' )->item( 0 )->nodeValue,
'link'  => $node->getElementsByTagName( 'link' )->item( 0 )->nodeValue,
'date'  => $node->getElementsByTagName( 'pubDate' )->item( 0 )->nodeValue,
'content' => $node->getElementsByTagName('encoded')->item(0)->nodeValue,

);

array_push( $feed, $item );
}
}

usort( $feed, function( $a, $b ) {
return strtotime( $b['date'] ) - strtotime( $a['date'] );
});

$limit = 4;
//echo '<ul>';
for ( $x = 0; $x < $limit; $x++ ) {
$site = $feed[$x]['site'];
$title = str_replace( ' & ', ' & ', $feed[$x]['title'] );
$link = $feed[$x]['link'];
$description = $feed[$x]['description']; //desc
$content = $feed[$x]['content'];
$content_grab = filter_var($content, FILTER_SANITIZE_STRING);
$content_light = substr($content_grab,0,340);

$html = $content; //$description;
$docrss = new DOMDocument();
@$docrss->loadHTML($html);
$imgtags = $docrss->getElementsByTagName('img');
$this_image = $imgtags[0]->getAttribute('src');
//$image = $feed[$x]['image'];

if (strlen($content)<2) { $date = ""; }

$date = date( 'F d, Y', strtotime( $feed[ $x ]['date'] ) );
$actual_time = date( 'H:i:s', strtotime( $feed[ $x ]['date'] ) );

$printthis=1;
if (strlen($content)<2) { $date = ""; $printthis=0;}


if ($x % 2 == 0) { $rss_bgcolor = '#fffff'; } else { $rss_bgcolor = '#ffffff'; }

if ($printthis==1) 
{

$left_container.="

<div style='width:100%; background-color:$rss_bgcolor; padding:0px; max-height:240px; min-height:240px;border:20px solid #F9E2C7; border-radius:20px; margin-bottom:20px;'>
<div style='width:50%; vertical-align:top; display:inline-block; text-align:center;padding:10px;'><a style='color:#141414; text-decoration: underline; font-weight:700;' href='$link' title='$title' target='_blank'>$title</a><BR><BR><div style='display:inline-block; text-align:left; width:100%; font-size:12px; overflow:hidden; max-height:100px;'>" . $content_light . "</div></div><div style='width:50%; background-color:#141414;display:inline-block; text-align:center;'><img src='$this_image' style='width:100%;height:auto;object-fit:contain;max-height:200px;'></div>
</div>";


//</div><div style='width:50%;display:inline-block;padding:8px 20px;'>

$right_container.="                            
<div style='width:100%; background-color:$rss_bgcolor; padding:0px; max-height:240px;  min-height:240px;border:20px solid #d7ccfa; border-radius:20px; margin-bottom:20px;'>
<div style='width:50%; vertical-align:top; display:inline-block; text-align:center;padding:10px;'><a style='color:#141414; text-decoration: underline; font-weight:700;' href='$link' title='$title' target='_blank'>$title</a><BR><BR><div style='display:inline-block; text-align:left; width:100%; font-size:16px; overflow:hidden; max-height:100px;'>" . $content_light . "</div></div><div style='width:50%; background-color:#141414;display:inline-block; text-align:center;'><img src='$this_image' style='width:100%;height:auto;object-fit:contain;max-height:200px;'></div>
</div>";


}
}
//echo '</ul>';
$total_rss = $x + 1;

*/
?>

<!--START-->

<!--END-->


</div>
</div>
</div>
</div>
<!--Eight banner end -->





<!--Nine banner start -->
<div class="bg_nine mt-5 mb-5 m_show">
<div class="container-fluid">
<div class="row">
<div class="col-lg-10 offset-lg-1">
<div class="bg-orange b-29r p-5 text-center text-light">
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

<!--Partners and Sponsors banner start -->
<div class="container-fluid">
<div class="row">
<div class="col-lg-12">
<div class="heading text-center pt-4 pb-2">
<h1>Partners and Sponsors</h1>
</div>
</div>
</div>
</div>  
<div class="mx-3 mb-0" style="margin-top:-25px;">
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
<!--Partners and Sponsors banner end -->


<!--gallery banner start -->
<div class="gallery pt-5 pb-0 ">
<div class="container-fluid">
<div class="row">
<div class="col-lg-12">
<div class="heading text-center pt-1 pb-5">
<h1>Gallery</h1>


<!--<img id="myImg" src="images/4.jpg" alt="" style="width:100%;max-width:300px">-->

<div style="display:block; padding-top:4px; background-color: #141414;overflow: auto;white-space: nowrap; width:100%;">

<?php
$c = 1;
$jquery_const = array("");
foreach($get_tour_images as $i => $get_info) {
$tour_id		 = $get_info->Tournament_id;
$image_pic = base_url()."tour_pictures/".$tour_id."/thumbs/".$get_info->Image_file;
?>
<img id='<?=$c;?>' style="height:250px;" src="<?=$image_pic;?>" onClick="openmodal(this.src, this.id)">
<?php
$c++;
$jquery_const[] = $image_pic;
}
$json_const = json_encode($jquery_const);
$jquery_const_count = count($jquery_const);
?>
</div>
<?php
//print_r($jquery_const);
//echo "JSON ". $json_const; exit;
?>
<!-- The Modal -->
<div id="myModal" class="modal">

<span class="close">&times;</span>
<img class="modal-content" style="object-fit:contain; border:none; background-color: #fff0f0"; id="img01">

<!--<div id="caption"></div>-->
<input id="ok" name="ok" type="text" value="0" style="display:none;">

<!-- Next/previous controls -->

<a class="prev" onclick="previousSlide()">&#10094;</a>
<a class="next" onclick="nextSlide()">&#10095;</a>

<!-- <input type='button' value='next' onclick='ic1.next("container")' />
<input type='button' value='prev' onclick='ic1.prev("container")' /> -->
</div>

<script>
function openmodal(_src, image_full_id) {
//alert("SRC " + _src + " IMAGE ID " + image_full_id);

modal.style.display = "block";
modalImg.src = _src; //this.src;
document.getElementById("ok").value = image_full_id;
}

// Get the modal
var modal = document.getElementById("myModal");
var img = document.getElementById("myImg");
var modalImg = document.getElementById("img01");
var span = document.getElementsByClassName("close")[0];

span.onclick = function() {
modal.style.display = "none";
}
</script>

<script>
//const pictures = ["", "images/16.jpg", "images/18.jpg", "images/20.jpg", "images/4.jpg", "images/6.jpg", "images/8.jpg"];
//const pics_count = 7;

const pictures = <?php echo $json_const; ?>;
const pics_count = <?php echo $jquery_const_count; ?>;

function nextSlide(imageid) {
var thisimageid = document.getElementById("ok").value;
var gotoid = parseInt(thisimageid) + 1;

if (gotoid == pics_count) { gotoid=1; }

var modalImg = document.getElementById("img01");
openmodal(pictures[gotoid], gotoid);
}

function previousSlide(imageid) {
var thisimageid = document.getElementById("ok").value;
var gotoid = parseInt(thisimageid) - 1;

if (gotoid == 0){ gotoid=pics_count; }

var modalImg = document.getElementById("img01");
openmodal(pictures[gotoid], gotoid);
}

</script>

</div>
</div>
<!-- <?php
$a =1;
foreach($get_tour_images as $i => $get_info) {
$tour_id		 = $get_info->Tournament_id;
$image_pic = base_url()."tour_pictures/".$tour_id."/thumbs/".$get_info->Image_file;
$image_loc = $_SERVER['CONTEXT_DOCUMENT_ROOT']."tour_pictures/".$tour_id."/thumbs/".$get_info->Image_file;

if($a ==1 and file_exists($image_loc)){
?>
<div class="col-lg-4">
<div class="galler_img">
<a class="gallery_img" data-gall="myGallery" href="<?php echo $image_pic; ?>">
<img src="<?php echo $image_pic; ?>" class="w-100"></a>
</div>
</div>
<?php
break;
}
$a++;
}
?>

<div class="col-lg-4">
<div class="row">
<?php
$a =1;
foreach($get_tour_images as $i => $get_info) {
$tour_id		 = $get_info->Tournament_id;
$image_pic = base_url()."tour_pictures/".$tour_id."/thumbs/".$get_info->Image_file;
$image_loc = $_SERVER['CONTEXT_DOCUMENT_ROOT']."tour_pictures/".$tour_id."/thumbs/".$get_info->Image_file;

if(($a > 1 and $a <= 5) and file_exists($image_loc)){
?>
<div class="col-6">
<a class="gallery_img" data-gall="myGallery" href="<?php echo $image_pic; ?>">
<img src="<?php echo $image_pic; ?>" class="w-100 mb-3"></a>
</div>
<?php
}
$a++;
}
?>

</div>
</div>


<div class="col-lg-4">
<div class="gallery_card text-center pt-4 pb-4">
<img src="<?=base_url()."assets_new/";?>images/g_logo.png" class="mb-3">
<h4>Player of the Week</h4>
<?php if($org_pom) {?> 
<a href="<?php echo base_url();?>player/<?php echo $org_pom;?>">
<img src="<?php echo base_url(); ?>profile_pictures/<?php if($get_user['Profilepic']!=""){echo $get_user['Profilepic']; } else { echo "default-profile.png";}?>" class="w-80 player-month mt-2 mb-2" style="width: 40%; height:auto;">
<h4 class="mt-3"><?php echo ucfirst($get_user['Firstname'])." ".ucfirst($get_user['Lastname']); ?></h4>
</a>
<p class="club_info d-flex justify-content-center align-items-center mb-2"><img src="<?=base_url()."assets_new/";?>images/location.png"><?php echo $get_user['City'].", ".$get_user['State']; ?></p>
<?php } else { echo "No Player is declared yet!"; } ?> -->
<!-- <p class="club_info d-flex justify-content-center align-items-center mb-0 pb-2"><img src="<?=base_url()."assets_new/";?>images/date.png"> Oct, 2018</p> -->
<!-- </div>
</div>
</div>
</div>
</div> -->
<!--gallery banner end -->

<script>
$(document).ready(function() {
var owl = $('#owl-one');
owl.owlCarousel({
margin: 50,
nav: true,
loop: true,
responsive: {
0: {
items: 1
},
600: {
items: 1
},
1000: {
items: 3 
}
}
});

$('#edit_pom').click(function(){
$('#pom_div').hide();
$('#edit_pom_div').show();
});

$('#cancel_pom').click(function(){
$('#pom_div').show();
$('#pom_user_id').val('');
$('#edit_pom_div').hide();
});


//var sp_type = "<?php echo $r->SportsType;?>";
var baseurl = "<?php echo base_url();?>";

/*$('#created_by').autocomplete({

source: function( request, response ) {
$.ajax({
url: baseurl+'search/autocomplete',
dataType: "json",
method: 'post',
data: {
name_startsWith: request.term,
type: 'users',
row_num : 1
},
success: function( data ) {
response( $.map( data, function( item ) {
var code = item.split("|");
return {
label: code[0],
value: code[0],
data : item
}
}));
}
});
},
autoFocus: true,	      	
minLength: 1,
select: function( event, ui ) {
//alert(ui.item.data);
var names = ui.item.data.split("|");						
$('#pom_user_id').val(names[1]);

//$('#created_by').val('');
$('#created_by').focus();
}
});*/

function autocomplete(inp, arr) {
/*the autocomplete function takes two arguments,
the text field element and an array of possible autocompleted values:*/
var currentFocus;
/*execute a function when someone writes in the text field:*/
inp.addEventListener("input", function(e) {
var a, b, i, val = this.value;
/*close any already open lists of autocompleted values*/
closeAllLists();
if (!val) { return false;}
currentFocus = -1;
/*create a DIV element that will contain the items (values):*/
a = document.createElement("DIV");
a.setAttribute("id", this.id + "autocomplete-list");
a.setAttribute("class", "autocomplete-items");
/*append the DIV element as a child of the autocomplete container:*/
this.parentNode.appendChild(a);
/*for each item in the array...*/
// alert(arr.length);
for (i = 0; i < arr.length; i++) {
/*check if the item starts with the same letters as the text field value:*/
if (arr[i]['value'].substr(0, val.length).toUpperCase() == val.toUpperCase()) {
/*create a DIV element for each matching element:*/
b = document.createElement("DIV");
/*make the matching letters bold:*/
b.innerHTML = "<strong>" + arr[i]['value'].substr(0, val.length) + "</strong>";
b.innerHTML += arr[i]['value'].substr(val.length);
/*insert a input field that will hold the current array item's value:*/
b.innerHTML += "<input type='hidden' value='" + arr[i]['value'] + "'>";
b.innerHTML += "<input type='hidden' value='" + arr[i]['value2'] + "'>";
/*execute a function when someone clicks on the item value (DIV element):*/
b.addEventListener("click", function(e) {
/*insert the value for the autocomplete text field:*/
//alert(this.getElementsByTagName("input")[0].value);
inp.value = this.getElementsByTagName("input")[0].value;
document.getElementById('pom_user_id').value = this.getElementsByTagName("input")[1].value;
/*close the list of autocompleted values,
(or any other open lists of autocompleted values:*/
closeAllLists();
});
a.appendChild(b);
}
}
});
/*execute a function presses a key on the keyboard:*/
inp.addEventListener("keydown", function(e) {
var x = document.getElementById(this.id + "autocomplete-list");
if (x) x = x.getElementsByTagName("div");
if (e.keyCode == 40) {
/*If the arrow DOWN key is pressed,
increase the currentFocus variable:*/
currentFocus++;
/*and and make the current item more visible:*/
addActive(x);
} else if (e.keyCode == 38) { //up
/*If the arrow UP key is pressed,
decrease the currentFocus variable:*/
currentFocus--;
/*and and make the current item more visible:*/
addActive(x);
} else if (e.keyCode == 13) {
/*If the ENTER key is pressed, prevent the form from being submitted,*/
e.preventDefault();
if (currentFocus > -1) {
/*and simulate a click on the "active" item:*/
if (x) x[currentFocus].click();
}
}
});
function addActive(x) {
/*a function to classify an item as "active":*/
if (!x) return false;
/*start by removing the "active" class on all items:*/
removeActive(x);
if (currentFocus >= x.length) currentFocus = 0;
if (currentFocus < 0) currentFocus = (x.length - 1);
/*add class "autocomplete-active":*/
x[currentFocus].classList.add("autocomplete-active");
}
function removeActive(x) {
/*a function to remove the "active" class from all autocomplete items:*/
for (var i = 0; i < x.length; i++) {
x[i].classList.remove("autocomplete-active");
}
}
function closeAllLists(elmnt) {
/*close all autocomplete lists in the document,
except the one passed as an argument:*/
var x = document.getElementsByClassName("autocomplete-items");
for (var i = 0; i < x.length; i++) {
if (elmnt != x[i] && elmnt != inp) {
x[i].parentNode.removeChild(x[i]);
}
}
}
/*execute a function when someone clicks in the document:*/
document.addEventListener("click", function (e) {
closeAllLists(e.target);
});
}

var users = <?php echo $users; ?>;

autocomplete(document.getElementById("myInput"), users);

});
</script>







<script>
$(document).ready(function() {
$(".show_all").click(function() {
var id = $(this).attr('id');

if(id == 'vtournaments' || id == 'vtournaments_mn')
$('button[data-filter=".category-a"]').trigger( "click" );
else if(id == 'vplayers' || id == 'vplayers_mn')
$('button[data-filter=".category-b"]').trigger( "click" );
else if(id == 'vteams' || id == 'vteams_mn')
$('button[data-filter=".category-c"]').trigger( "click" );
else if(id == 'vclubs' || id == 'vclubs_mn')
$('button[data-filter=".category-d"]').trigger( "click" );
else if(id == 'vcoaches' || id == 'vcoaches_mn')
$('button[data-filter=".category-e"]').trigger( "click" );

});

//$('#profile-tab').click(function(){

//	$('#profile').html("Testing");
// });

});
</script>
<script src="https://a2msports.com/js/jquery.autocomplete.js" type="text/javascript"></script>

<script>
var baseURL = "<?php echo base_url(); ?>";
$('#news_btn').click(function(){
window.location.replace(baseURL+"news");
});
</script>



<?php $this->load->view('includes/login_popup'); ?>