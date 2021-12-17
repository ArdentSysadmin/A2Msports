<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="<?=base_url()."assets_new/";?>css/style.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Rubik:ital,wght@0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <!-- Owl Stylesheets -->
    <link rel="stylesheet" href="<?=base_url()."assets_new/";?>css/owl.carousel.min.css">
    <link rel="stylesheet" href="<?=base_url()."assets_new/";?>css/owl.theme.default.min.css">
    <title>A2MSports</title>
    <script src="<?=base_url()."assets_new/";?>js/jquery.min.js"></script>
    <script src="<?=base_url()."assets_new/";?>js/owl.carousel.js"></script>
 <style type="text/css">
 	#fadevedio {
  display: none;
  position: fixed;
  top: 0%;
  left: 0%;
  width: 100%;
  height: 100%;
  background-color: black;
  z-index: 1001;
  -moz-opacity: 0.8;
  opacity: .80;
  filter: alpha(opacity=80);
}

#light {
  display: none;
  position: absolute;
  top: 50%;
  left: 50%;
  max-width: 600px;
  max-height: 360px;
  margin-left: -300px;
  margin-top: -180px;
  border: 2px solid #FFF;
  background: #FFF;
  z-index: 1002;
  overflow: visible;
}

#boxclose {
  float: right;
  cursor: pointer;
  color: #fff;
  border: 1px solid #AEAEAE;
  border-radius: 3px;
  background: #222222;
  font-size: 31px;
  font-weight: bold;
  display: inline-block;
  line-height: 0px;
  padding: 11px 3px;
  position: absolute;
  right: 2px;
  top: 2px;
  z-index: 1002;
  opacity: 0.9;
}

.boxclose:before {
  content: "x";
}

#fade:hover ~ #boxclose {
  display:none;
}

.test:hover ~ .test2 {
  display: none;
}
.slick-slider {
  position: relative;
  display: block;
  box-sizing: border-box;
  -webkit-user-select: none;
  -moz-user-select: none;
  -ms-user-select: none;
      user-select: none;
  -webkit-touch-callout: none;
  -khtml-user-select: none;
  -ms-touch-action: pan-y;
      touch-action: pan-y;
  -webkit-tap-highlight-color: transparent;
}

.slick-list {
  position: relative;
  display: block;
  overflow: hidden;
  margin: 0;
  padding: 0;
}

.slick-list:focus {
  outline: none;
}

.slick-list.dragging {
  cursor: pointer;
  cursor: hand;
}

.slick-slider .slick-track,
.slick-slider .slick-list {
    -webkit-transform: translate3d(0, 0, 0);
       -moz-transform: translate3d(0, 0, 0);
        -ms-transform: translate3d(0, 0, 0);
         -o-transform: translate3d(0, 0, 0);
            transform: translate3d(0, 0, 0);
}

.slick-track {
    position: relative;
    top: 0;
    left: 0;
    display: block;
}

.slick-track:before,
.slick-track:after {
    display: table;
    content: '';
}

.slick-track:after {
    clear: both;
}

.slick-loading .slick-track {
    visibility: hidden;
}

.slick-slide {
    display: none;
    float: left;
    height: 100%;
    min-height: 1px;
}

[dir='rtl'] .slick-slide {
    float: right;
}

.slick-slide img {
    display: block;
}

.slick-slide.slick-loading img {
    display: none;
}

.slick-slide.dragging img {
    pointer-events: none;
}
.slick-initialized .slick-slide {
    display: block;
}
.slick-loading .slick-slide {
    visibility: hidden;
}
.slick-vertical .slick-slide {
    display: block;
    height: auto;
    border: 1px solid transparent;
}

.slick-arrow.slick-hidden {
    display: none;
}

.slide {
    transition: filter .4s;
    margin: 0px 40px;
}



.section {
  max-width: 1200px;
  margin: 0 auto;
}
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
    opacity: .5;
    transition: opacity .6s ease;
}
nav.navbar.navbar-expand-lg.navbar-light.justify-content-end ul li a i {
    margin-left: 5px;
    margin-right: 0px;
}
 </style>
  </head>
  <body>
     <!-- nav start -->
     <div  class="container-fluid">
       <nav class="navbar navbar-expand-lg navbar-light justify-content-end">
        <div class="container-fluid">
          <a class="navbar-brand" href="<?php echo base_url();?>">
		  <img src="<?=base_url()."assets_new/";?>images/logo.png"></a>
          <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
          </button>
          <div class="collapse navbar-collapse" id="navbarNavDropdown">
            <ul class="navbar-nav mx-4">
              <li class="nav-item dropdown ml-20">
                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink_one" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                 Create <i class="fas fa-chevron-down"></i>
                </a>
                <ul class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink_one">
                  <li><a class="dropdown-item" href="<?php echo base_url();?>ladder">Challenge Ladder</a></li>
                  <li><a class="dropdown-item" href="<?php echo base_url();?>events/add">Event</a></li>
                  <li><a class="dropdown-item" href="<?php echo base_url();?>league/bracket_generator">Free Brackets</a></li>
                  <li><a class="dropdown-item" href="<?php echo base_url();?>league">League</a></li>
                  <li><a class="dropdown-item" href="<?php echo base_url();?>teams">Team</a></li>
                  <li><a class="dropdown-item" href="<?php echo base_url();?>league">Tournament</a></li>
                </ul>
              </li>
             
              <li class="nav-item">
                <a class="nav-link" href="<?php echo base_url();?>calendar">Calendar</a>
              </li>

              <li class="nav-item dropdown ml-20 mr-auto">
                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink_two" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                  Sports  <i class="fas fa-chevron-down"></i>
                </a>
                <ul class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink_two">
                  <li><a class="dropdown-item" href="<?=base_url(); ?>badminton"> Badminton </a></li>
                  <li><a class="dropdown-item" href="<?=base_url(); ?>pickleball"> Pickleball </a></li>
                  <li><a class="dropdown-item" href="<?=base_url(); ?>tt"> Table Tennis </a></li>
                  <li><a class="dropdown-item" href="<?=base_url(); ?>tennis"> Tennis </a></li>
                  <li><a class="dropdown-item" href="<?=base_url(); ?>sports"> More Sports </a></li>
                </ul>
              </li>
                            
              <li class="nav-item">
                <a class="nav-link" href="<?php echo base_url();?>Search">Search</a>
              </li>
			  <li class="nav-item dropdown ml-20">
                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink_two" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                  Do   <i class="fas fa-chevron-down"></i>
                </a>
                <ul class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink_two">
                  <li><a class="dropdown-item" href="<?php echo base_url();?>Addscore"> Add Score </a></li>
                  <li><a class="dropdown-item" href="<?php echo base_url();?>opponent"> Challenge </a></li>
                  <li><a class="dropdown-item" href="<?php echo base_url();?>clubs"> Pay and Play </a></li>
                </ul>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="<?php echo base_url();?>Help">Help</a>
              </li>




<?php if($this->session->userdata('user') != "") {?>
<li class="dropdown"><a href="#" class="dropdown-toggle" data-toggle="dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink_two" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                  <?php 
$get_fname = explode(' ', $this->session->userdata('user'));
echo $get_fname[0];
?>
<i class="fas fa-chevron-down"></i>
                </a>

<ul class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink_two" data-bs-popper="none">

<?php 
$child = $this->session->userdata('child_user_id');
if(!$child) { ?>
<li><a class="dropdown-item" href="<?php echo base_url();?>profile/add_profile"><span align='center'>Add Player</span></a></li> 
<?php } ?>

<li><a class="dropdown-item" href="<?php echo base_url();?>profile"><span align='center'>My Profile</span></a></li>
<li><a class="dropdown-item" href="<?php echo base_url();?>a2mteams"><span align='center'>My Teams</span></a></li>
<li><a class="dropdown-item" href="<?php echo base_url();?>play"><span align='center'>My Sports</span></a></li>

<?php if(isset($logout))
{ ?>
<li><a class="dropdown-item" href="<?php echo $logout;?>"><span align='center'>Logout</span></a></li>
<?php } else {?>
<li><a class="dropdown-item" href="<?php echo base_url();?>logout"><span align='center'>Logout</span></a></li>
<?php } ?>
</ul>

</div>
</div>
</div>
</li>
			  <?php } else { ?>
              <li class="nav-item">
                <!-- Button trigger modal -->
                <button type="button" id="log_btn" class="btn log_btn" data-bs-toggle="modal" data-bs-target="#exampleModal">
                 Login
                </button>
              </li>
			  <?php } ?>
            </ul>
          </div>
        </div>
      </nav>
     </div>
     <!-- nav end -->
	 <script>
	 var baseURL = "<?php echo base_url(); ?>";
$('#log_btn').click(function(){
	window.location.replace(baseURL+"login");
});
$('#news_btn').click(function(){
	window.location.replace(baseURL+"news");
});
	 </script>

     <!-- banner start -->

     <section class="banner mx-3 pt-5">
       <div class="container-fluid">
         <div class="row">
           <div class="col-lg-6">
             <div class="banner_content text-start text-light pl-30 pt-3 pb-2">
               <h1 class="font-45">Simple and smart tool to connect with players, <br>coaches, clubs & more!</h1>
               <p class="font-15">Our world class Sports Club Platform comes with Membership Management, Tournament and League Organization, Pay and Play (reservations), Club Ratings, Player Performance Tracking, Event Management and more! We even host your website and offer branded mobile app for the clubs with all these features built-in!</p>
               <a href="#" class="btn_banner">Request a demo</a>
             </div>
           </div>
           <div class="col-lg-6">
             <div class="banner_content text-start text-light pt-3 pb-2 relative">
              <img src="<?=base_url()."assets_new/";?>images/man2.png" class="w-100"> 
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
           <div class="heading text-center pt-5 pb-5">
            <h1>Featured Tournaments / Leagues / Events</h1>
          </div>
         </div>
         <div class="row">
           <div class="owl-carousel owl-theme Testimonials">
         
<?php
//echo "<pre>"; print_r($leagues); exit;
if(!empty($leagues)) { 
$i=1;
foreach($leagues as $j => $row) {

if(!empty($row)) {
?>
		   <div class="item  "><!-- d-flex justify-content-between -->
              <div class="d-flex feature_box">
                <div class="feature_left bg-white p-3">
                  <div class="d-flex justify-content-start">
				 
					<img src="<?=base_url()."assets_new/";?>images/tennis.svg" class="w-10">
					<h6 class="uppercase mb-0 mx-3">
					<?php switch($row->SportsType){
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
					} ?></h6>
				 </div>
                  <div class="day d-flex mt-1 mb-1">
                    <h1 class="mb-0"><?php echo date('d', strtotime($row->StartDate)); ?></h1>
                    <h6 class="mx-3 mb-0"><?php echo strtoupper(date('M', strtotime($row->StartDate))); ?> <br><?php echo date('h:i A', strtotime($row->StartDate)); ?></h6>
                  </div>
                  <h6> <a href="<?php
					if($row->Short_Code != '' and $row->Short_Code != NULL){
						echo base_url().$row->Short_Code; } 
					else{ 
						echo base_url().'league/'.$row->tournament_ID; } ?>" 
						title="<?php echo $row->tournament_title; ?>">
					<?php $tour_title = $row->tournament_title; $out = strlen($tour_title) > 29 ? substr($tour_title,0,29)."..." : $tour_title; echo $out; ?></a></h6>
                  <div class="d-flex justify-content-start mb-1"><img src="<?=base_url()."assets_new/";?>images/location.svg" class="w-10" ><p class="uppercase mb-0 mx-1"><?php echo trim($row->TournamentCity).", ".trim($row->TournamentState); ?></p></div>
                  <div class="d-flex justify-content-start mb-1"><img src="<?=base_url()."assets_new/";?>images/league.svg" class="w-10" ><p class="uppercase mb-0 mx-1"><?php echo $row->tournament_format; ?></p></div>
                  <!-- <div class="d-flex justify-content-start mb-1"><img src="<?=base_url()."assets_new/";?>images/team.svg" class="w-10" ><p class="uppercase mb-0 mx-1"> 20 Teams</p></div> -->
                </div>
                <div class="feature_right">
                  <div class="feature_img">
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
?>" class="w-2424" style="object-fit: contain;  width:184px;  height:242px;">
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
     <!-- Featured tournaments banner end -->
	 
	 <!--fourth banner start -->
     <div class="banner_pagetwo_  mx-3 pt-5 mb-5 ">
       <div class="container">
         <div class="row banner_pagetwo_two">
           <div class="col-lg-8 pb-4">
             <div class="banner_two_content pl-30 pt-4 mx-3">
               <h1 class="mb-2">Challenge Players</h1>
               <p class="mb-3 mt-3">Can't wait till the next tournament? You can "Challenge" <br> other players to play with you. We will reward you everytime <br> you challenge someone with more points towards your A2M <br>Score'.</p>
               <a href="#" class="btn_orange">Become a A2M Club Member</a>
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



     <!--seven banner start -->
     <div class="bg-blue pb-5">
       <div class="container-fluid">
         <div class="row">
           <div class="heading text-center pt-5 pb-5">
            <h1>Top Rated Badminton Players</h1>
          </div>
         </div>
         <div class="row">
           <div id="owl-one1" class="owl-carousel owl-theme Testimonials">
<?php
foreach($loc_query as $key => $row) {
$Sports_Interests = league::get_user_sport_intrests($row->Users_ID, $sport);
$membership_det = league::get_membership_details($row->Users_ID);
$user_details = league::get_user($row->Users_ID);
?>
           <div class="item  "><!-- d-flex justify-content-between -->
              <div class="players_box bg-white px-4 pt-4 pb-4">
                <div class="img mt-3  mb-4 d-flex align-items-center justify-content-between">
				<?php 
    $filename =  "C:\inetpub\wwwroot\a2msports\profile_pictures\thumbs\'".$user_details['Profilepic'];
	$filename1 = "C:\inetpub\wwwroot\a2msports\profile_pictures\'".$user_details['Profilepic'];

if(file_exists($filename)){ ?>
<img  src="<?php echo base_url(); ?>profile_pictures/thumbs/<?php if($user_details['Profilepic']!=""){echo $user_details['Profilepic']; } else { echo "&nbsp;";}?>" class="player_img" style="border-radius: 15px;" />
<?php } else { ?>
<img  src="<?php echo base_url(); ?>profile_pictures/<?php if($user_details['Profilepic']!=""){echo $user_details['Profilepic']; } else { echo "default-profile.png";}?>" class="player_img" style="border-radius: 15px;" />
<?php }  ?>

                  <!-- <img src="<?=base_url()."assets_new/";?>images/player_1.png" class="player_img"> -->
                  <img src="<?=base_url()."assets_new/";?>images/rank_<?=($key+1);?>.png" class="player_ig">
                </div>
                <div class="palyer_names d-flex justify-content-between">
                  <div class="name">
                    <p class="mb-0 gry">Name</p>
                    <h6 class=""><?php echo ucfirst($row->FirstName)." ".ucfirst($row->LastName);?></h6>
                  </div>
                  <div class="name text-end">
                    <p class="mb-0 gry">A2M Rating</p>
                    <h6 class=""><?php echo $row->A2MScore;?></h6>
                  </div>
                </div>
                <div class="club_name">
                  <p class="mb-0 gry">Club</p>
                  <h6 class="mb-0"><?php
					$get_club = league::get_club($membership_det[0]->Club_id);
					if($get_club['Aca_name']) echo $get_club['Aca_name'];
					else echo "N/A";?></h6>
                </div>
              </div>
            </div>
<?php
}
?>


          </div>
          <div class="col-lg-12 mt-5">
            <div class="btn_blue text-center">
              <a href="#" class="blue_btn">View All Players</a>
            </div>
          </div>
         </div>
       </div>
     </div>
     <!--seven banner end -->

   
    <!--active banner start -->
     <div class="bg-white bg-fig pb-5">
       <div class="container-fluid">
         <div class="row">
           <div class="heading text-center pt-5 pb-5">
            <h1>Most Active Teams</h1>
          </div>
         </div>
         <div class="row">
          <div class="col-lg-12">
           <div id="owl-one2" class="owl-carousel owl-theme Testimonials">
<?php
if($teams_result){
foreach($teams_result as $unp){
?>
           <div class="item  ">
              <div class="Active_box bg-white px-4 pt-4 pb-4">
                <div class="img mb-3 bg-grey">
				<?php if($unp->Team_Logo != NULL || $unp->Team_Logo != ""){
				$team_logo = "<img src='".base_url()."/team_logos/cropped/$unp->Team_Logo' alt='' style='object-fit: contain;width: 35%;'>";
			 }
			 else{ 
				$team_logo = "<img src='".base_url()."/team_logos/default_team_logo.png' alt='' style='object-fit: contain;width: 35%;'>";
			 } 
			 echo $team_logo;
			?>
                  <!-- <img src="<?=base_url()."assets_new/";?>images/active.png" > -->
                </div>
                <div class="actie_content text-center">
                  <h3><?=$unp->Team_name;?></h3>
                  <p class="gry">4.8 (62 reviews)</p>
                  <div class="text-center d-flex justify-content-center align-items-center rating ">
                    <img src="<?=base_url()."assets_new/";?>images/star.png" >
                    <!-- <img src="<?=base_url()."assets_new/";?>images/star.png" >
                    <img src="<?=base_url()."assets_new/";?>images/star.png" >
                    <img src="<?=base_url()."assets_new/";?>images/star.png" > -->
                    <img src="<?=base_url()."assets_new/";?>images/star.png" >
                  </div>
                  <div class="group_img mt-3 mb-2 d-flex justify-content-center">
                    <img src="<?=base_url()."assets_new/";?>images/group_img.png">
                  </div>
                </div>
                    
              </div>
            </div>

<?php
}
	 }
?>
            </div>

          </div>
          <div class="col-lg-12">
            <div class="btn_blue text-center">
              <a href="#" class="orange_btn">View All Players</a>
            </div>
          </div>
         </div>
       </div>
     </div>
     <!--active banner end -->
     

     <!--sreach banner start -->
     <div class="banner_pagetwo_  pt-5 mb-5 ">
       <div class="container">
         <div class="row ">
          <div class="col-lg-6">
            <div class="banner_two_content orange_pic p-5 sreach_orange_bg">
               <h1 class="mb-2">Search Easily</h1>
               <p class="mb-3 mt-3">Search for Players, Matches and<br> Tournaments</p>
               <a href="#" class="btn_orange text-center w-50">Search now</a>
             </div>
             <div class="sreach_img text-center">
               <img src="<?=base_url()."assets_new/";?>images/sreach.png" class="w-100">
             </div>
           
          </div>


          <div class="col-lg-6">
            <div class="banner_two_content blue_pic p-5 sreach_blue_bg">
               <h1 class="mb-2">Add Live Score</h1>
               <p class="mb-3 mt-3">You played a match without actually
                creating or registering it, you can still  add it to your profile here.</p>
               <a href="#" class="btn_orange text-center w-50">Add score</a>
             </div>
             <div class="sreach_img text-center">
               <img src="<?=base_url()."assets_new/";?>images/Socre.png" class="w-100">
             </div>
           
          </div>
           
         </div>
       </div>
     </div>
     <!--sreach banner end -->





      <!--Clubs banner start -->
     <div class="bg-white bg-fig pb-5">
       <div class="container-fluid">
         <div class="row">
           <div class="heading text-center pt-5 pb-5">
            <h1>Top Rated Clubs</h1>
          </div>
         </div>
         <div class="row">
          <div class="col-lg-12">
           <div id="owl-one3" class="owl-carousel owl-theme Testimonials">
<?php
if($club_results){
foreach($club_results as $i => $row){
?>
           <div class="item activ_box ">
              <div class="Active_box bg-white px-4 pt-4">
                <div class="club_img mb-3 d-flex justify-content-between" style="height: 117px;">
                  <img src="<?=base_url();?>/org_logos/<?=$row->Aca_logo;?>" style="width: 117px !important; height: auto !important;">
                  <h4 class="mt-2"><?=$row->Aca_name;?></h4>
                </div>
                <div class="club_content text-start">
                  <div class="text-start mb-2 d-flex justify-content-start align-items-start rating ">
                    <img src="<?=base_url()."assets_new/";?>images/star.png" >
                    <!-- <img src="<?=base_url()."assets_new/";?>images/star.png" >
                    <img src="<?=base_url()."assets_new/";?>images/star.png" >
                    <img src="<?=base_url()."assets_new/";?>images/star.png" > -->
                    <img src="<?=base_url()."assets_new/";?>images/gray_start.png" >
                  </div>
                  <p class="gry">4.8 (62 reviews)</p>
                  <p class="club_info d-flex justify-content-start align-items-center mb-2"><img src="<?=base_url()."assets_new/";?>images/location.png"> Cumming, Georgia</p>
                  <p class="club_info d-flex justify-content-start align-items-center mb-0 pb-2"><img src="<?=base_url()."assets_new/";?>images/label.png"> Starting at $10.00/hr</p>
                </div>
              </div>
                 <a href="#" class="club_btn">Book a Session</a>
           </div>
<?php
		   }
}
?>
            </div>
          </div>
          <div class="col-lg-12">
            <div class="btn_blue text-center">
              <a href="#" class="orange_btn">View All  Clubs</a>
            </div>
          </div>
         </div>
       </div>
     </div>
     <!--Clubs banner end -->



     <!-- Rated  banner start -->
     <div class="bg-blue1 pb-5">
       <div class="container-fluid">
         <div class="row">
           <div class="heading text-center pt-5 pb-5">
            <h1>Top Rated Coaches</h1>
          </div>
         </div>
         <div class="row">
           <div id="owl-one4" class="owl-carousel owl-theme Testimonials">
			<?php
			if($coach_results){
				//echo "<pre>"; print_r($coach_results);
			foreach($coach_results as $i => $coach){
			?>
           <div class="item ">
              <div class="players_box bg-white px-4 pt-4 pb-4">
                <div class="img mt-3  mb-4 d-flex align-items-center justify-content-between">
				<?php 
    $filename   =  "C:\inetpub\wwwroot\a2msports\profile_pictures\thumbs\'".$coach->Profilepic;
	$filename1 = "C:\inetpub\wwwroot\a2msports\profile_pictures\'".$coach->Profilepic;

				if(file_exists($filename)){ ?>
<img  src="<?php echo base_url(); ?>profile_pictures/thumbs/<?php if($coach->Profilepic != ""){echo $coach->Profilepic; } else { echo "&nbsp;";}?>" class="player_img" style="border-radius: 15px !important;" />
<?php } else { ?>
<img  src="<?php echo base_url(); ?>profile_pictures/<?php if($coach->Profilepic != ""){echo $coach->Profilepic; } else { echo "default-profile.png";}?>" class="player_img" style="border-radius: 15px !important;" />
<?php }  ?>
                  <!-- <img src="<?=base_url()."assets_new/";?>images/player_1.png" class="player_img"> -->
                  <div class="">
                    <div class="text-end mb-2 d-flex justify-content-end align-items-end rating ">
                    <img src="<?=base_url()."assets_new/";?>images/star.png" >
                    <img src="<?=base_url()."assets_new/";?>images/star.png" >
                    <img src="<?=base_url()."assets_new/";?>images/star.png" >
                    <img src="<?=base_url()."assets_new/";?>images/star.png" >
                    <img src="<?=base_url()."assets_new/";?>images/star.png" >
                  </div>
                  <p class="gry">4.8 (62 reviews)</p>
                  </div>
                </div>
                <div class="palyer_names d-flex justify-content-between">
                  <div class="name">
                    <p class="mb-0 gry">Name</p>
                    <h6 class=""><?=$coach->Firstname." ".$coach->Lastname;?></h6>
                  </div>
                  <div class="name text-end">
                    <p class="mb-0 gry">Batches</p>
                    <h6 class="">Individual <br> & Group</h6>
                  </div>
                </div>
                <div class="club_name mt-3">
                 <p class="club_info d-flex justify-content-start align-items-center mb-2"><img src="<?=base_url()."assets_new/";?>images/location.png"> <?=$coach->City.", ".$coach->State;?></p>
                  <p class="club_info d-flex justify-content-start align-items-center mb-0 pb-2"><img src="<?=base_url()."assets_new/";?>images/label.png"> Starting at $10.00/hr</p>
                </div>
              </div>
            </div>
    
			<?php
			}
			}
			?>
          </div>
          <div class="col-lg-12 mt-5">
            <div class="btn_blue text-center">
              <a href="#" class="orange_btn">View All Coaches</a>
            </div>
          </div>
         </div>
       </div>
     </div>
     <!-- Rated  banner end -->





     <!--Eight banner start --> 
     <div class="mx-3 mb-5 mt-5">
       <div class="container-fluid">
         <div class="row">
           <div class="col-lg-12">
            <div class="heading text-center pt-5 pb-5">
              <h1>Join a team. Compete in a tournament. <br> Connect to players and coaches. </h1>
            </div>

            <div class="tabs">
              <ul class="nav nav-tabs" id="myTab" role="tablist">
                <li class="nav-item" role="presentation">
                  <button class="nav-link active" id="Tournaments-tab" data-bs-toggle="tab" data-bs-target="#Tournaments" type="button" role="tab" aria-controls="Tournaments" aria-selected="true">Tournaments</button>
                </li>
                <li class="nav-item" role="presentation">
                  <button class="nav-link gry" id="profile-tab" data-bs-toggle="tab" data-bs-target="#profile" type="button" role="tab" aria-controls="profile" aria-selected="false">Players</button>
                </li>
                <li class="nav-item" role="presentation">
                  <button class="nav-link gry" id="contact-tab" data-bs-toggle="tab" data-bs-target="#contact" type="button" role="tab" aria-controls="contact" aria-selected="false">Teams</button>
                </li>
                <li class="nav-item" role="presentation">
                  <button class="nav-link gry" id="contact-tab" data-bs-toggle="tab" data-bs-target="#contact" type="button" role="tab" aria-controls="contact" aria-selected="false">Clubs</button>
                </li>
                <li class="nav-item" role="presentation">
                  <button class="nav-link gry" id="contact-tab" data-bs-toggle="tab" data-bs-target="#contact" type="button" role="tab" aria-controls="contact" aria-selected="false">Coaches</button>
                </li>
              </ul>
              <div class="tab-content" id="myTabContent">
                <div class="tab-pane fade show active" id="Tournaments" role="tabpanel" aria-labelledby="Tournaments-tab">
                  <div class="row mt-5">
                    <div class="col-lg-10 offset-lg-1">
                      <div class="bg-white p-3">
                        <div class="head d-flex justify-content-between align-items-center">
                          <h4 class="gry mb-0">Filter</h4>
                          <div class="input-group w-30 mb-3 sreach_filter">
                              <button class="btn btn-outline-secondary border-orange bg-orange" type="button" id="button-addon1">Sreach</button>
                              <input type="text" class="form-control" placeholder="Search by Name,City,State" aria-label="Example text with button addon" aria-describedby="button-addon1">
                            </div>
                        </div>
                        <div class="middle d-flex justify-content-between align-items-center">
                          <div class="Filter_middle_box d-flex align-items-center justify-content-start">
                            <p class="mb-0">Tournament Type</p>
                            <ul class="filter">
                            <li class="nav-item dropdown">
                              <a class="dropdown-toggle" data-bs-toggle="dropdown" href="#" role="button" aria-expanded="false">All <img src="<?=base_url()."assets_new/";?>images/downarrow.png"></a>
                              <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="#">Action</a></li>
                                <li><a class="dropdown-item" href="#">Another action</a></li>
                                <li><a class="dropdown-item" href="#">Something else here</a></li>
                                <li><hr class="dropdown-divider"></li>
                                <li><a class="dropdown-item" href="#">Separated link</a></li>
                              </ul>
                            </li>
                          </ul>
                          </div>
                          <div class="Filter_middle_box align-items-center  d-flex justify-content-start">
                            <p class="mb-0">Tournament Date</p>
                            <ul class="filter">
                            <li class="nav-item dropdown">
                              <a class="dropdown-toggle" data-bs-toggle="dropdown" href="#" role="button" aria-expanded="false">This Year <img src="<?=base_url()."assets_new/";?>images/downarrow.png"></a>
                              <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="#">Action</a></li>
                                <li><a class="dropdown-item" href="#">Another action</a></li>
                                <li><a class="dropdown-item" href="#">Something else here</a></li>
                                <li><hr class="dropdown-divider"></li>
                                <li><a class="dropdown-item" href="#">Separated link</a></li>
                              </ul>
                            </li>
                          </ul>
                          </div>
                          <div class="Filter_middle_box align-items-center d-flex justify-content-start">
                            <p class="mb-0">Registration Status</p>
                            <ul class="filter">
                            <li class="nav-item dropdown">
                              <a class="dropdown-toggle" data-bs-toggle="dropdown" href="#" role="button" aria-expanded="false">Closed  <img src="<?=base_url()."assets_new/";?>images/downarrow.png"></a>
                              <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="#">Action</a></li>
                                <li><a class="dropdown-item" href="#">Another action</a></li>
                                <li><a class="dropdown-item" href="#">Something else here</a></li>
                                <li><hr class="dropdown-divider"></li>
                                <li><a class="dropdown-item" href="#">Separated link</a></li>
                              </ul>
                            </li>
                          </ul>
                          </div>
                          <div class="Filter_middle_box d-flex align-items-center justify-content-start">
                            <p class="mb-0">Tournament Type</p>
                            <ul class="filter">
                            <li class="nav-item dropdown">
                              <a class="dropdown-toggle" data-bs-toggle="dropdown" href="#" role="button" aria-expanded="false"><img src="<?=base_url()."assets_new/";?>images/country.png" class="mx-0"> <img src="<?=base_url()."assets_new/";?>images/downarrow.png"></a>
                              <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="#">Action</a></li>
                                <li><a class="dropdown-item" href="#">Another action</a></li>
                                <li><a class="dropdown-item" href="#">Something else here</a></li>
                                <li><hr class="dropdown-divider"></li>
                                <li><a class="dropdown-item" href="#">Separated link</a></li>
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
                                    <p class="mb-0"><?=$row->tournament_title;?></p>
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
                                <a href="#" class="white_btn">Sign Up</a>
                              </div>
                            </div>
                          </div>
						<?php } ?>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>


                <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">...</div>
                <div class="tab-pane fade" id="contact" role="tabpanel" aria-labelledby="contact-tab">...</div>
              </div>
            </div>
             
           </div>
         </div>
       </div>
     </div>
     <!--Eight banner end -->


     <!--Eight banner start --> 
     <div class="mx-3 mb-5 d_show">
       <div class="container-fluid">
         <div class="row">
           <div class="col-lg-6">
            <div class="heading text-center pt-5 pb-5">
              <h1>A2M Latest News</h1>
            </div>
             <div class="Latest_newa p-4 ">
               <div class="latest_card d-flex mb-4 justify-content-between">
                 <div class="latest_img">
                   <img src="<?=base_url()."assets_new/";?>images/latest.png" class="w-100">
                   <span class="date_upload">May 4, 2021</span>
                 </div>
                 <div class="latest_content p-4 bg-white">
                   <h5>We are heading to South Carolina for <br> Summer Pickleball Tournament! Detai</h5>
                  <p>Amet minim mollit non deserunt ullamco est sit <br> aliqua dolor do amet sint. Amet minim mollit non <br> Amet minim mollit non</p>
                  <a href="#">Read more</a>
                 </div>
               </div>
               <div class="latest_card d-flex mb-4 justify-content-between">
                 <div class="latest_img">
                   <img src="<?=base_url()."assets_new/";?>images/latest.png" class="w-100">
                   <span class="date_upload">May 4, 2021</span>
                 </div>
                 <div class="latest_content p-4 bg-white">
                   <h5>We are heading to South Carolina for <br> Summer Pickleball Tournament! Detai</h5>
                  <p>Amet minim mollit non deserunt ullamco est sit <br> aliqua dolor do amet sint. Amet minim mollit non <br> Amet minim mollit non</p>
                  <a href="#">Read more</a>
                 </div>
               </div>
               <div class="latest_card d-flex mb-4 justify-content-between">
                 <div class="latest_img">
                   <img src="<?=base_url()."assets_new/";?>images/latest.png" class="w-100">
                   <span class="date_upload">May 4, 2021</span>
                 </div>
                 <div class="latest_content p-4 bg-white">
                   <h5>We are heading to South Carolina for <br> Summer Pickleball Tournament! Detai</h5>
                  <p>Amet minim mollit non deserunt ullamco est sit <br> aliqua dolor do amet sint. Amet minim mollit non <br> Amet minim mollit non</p>
                  <a href="#">Read more</a>
                 </div>
               </div>
               <div class="latest_card d-flex justify-content-between">
                 <div class="latest_img">
                   <img src="<?=base_url()."assets_new/";?>images/latest.png" class="w-100">
                   <span class="date_upload">May 4, 2021</span>
                 </div>
                 <div class="latest_content p-4 bg-white">
                   <h5>We are heading to South Carolina for <br> Summer Pickleball Tournament! Detai</h5>
                  <p>Amet minim mollit non deserunt ullamco est sit <br> aliqua dolor do amet sint. Amet minim mollit non <br> Amet minim mollit non</p>
                  <a href="#">Read more</a>
                 </div>
               </div>
             </div>
           </div>
           <div class="col-lg-6">
            <div class="heading text-center pt-5 pb-5">
                <h1>Global News</h1>
              </div>
             <div class="sreach_blue_bg p-4 b-29r">
               <div class="latest_card d-flex mb-4 justify-content-between">
                 <div class="latest_img">
                   <img src="<?=base_url()."assets_new/";?>images/latest.png" class="w-100">
                   <span class="date_upload">May 4, 2021</span>
                 </div>
                 <div class="latest_content p-4 bg-white">
                   <h5>We are heading to South Carolina for <br> Summer Pickleball Tournament! Detai</h5>
                  <p>Amet minim mollit non deserunt ullamco est sit <br> aliqua dolor do amet sint. Amet minim mollit non <br> Amet minim mollit non</p>
                  <a href="#">Read more</a>
                 </div>
               </div>
               <div class="latest_card d-flex mb-4 justify-content-between">
                 <div class="latest_img">
                   <img src="<?=base_url()."assets_new/";?>images/latest.png" class="w-100">
                   <span class="date_upload">May 4, 2021</span>
                 </div>
                 <div class="latest_content p-4 bg-white">
                   <h5>We are heading to South Carolina for <br> Summer Pickleball Tournament! Detai</h5>
                  <p>Amet minim mollit non deserunt ullamco est sit <br> aliqua dolor do amet sint. Amet minim mollit non <br> Amet minim mollit non</p>
                  <a href="#">Read more</a>
                 </div>
               </div>
               <div class="latest_card d-flex mb-4 justify-content-between">
                 <div class="latest_img">
                   <img src="<?=base_url()."assets_new/";?>images/latest.png" class="w-100">
                   <span class="date_upload">May 4, 2021</span>
                 </div>
                 <div class="latest_content p-4 bg-white">
                   <h5>We are heading to South Carolina for <br> Summer Pickleball Tournament! Detai</h5>
                  <p>Amet minim mollit non deserunt ullamco est sit <br> aliqua dolor do amet sint. Amet minim mollit non <br> Amet minim mollit non</p>
                  <a href="#">Read more</a>
                 </div>
               </div>
               <div class="latest_card d-flex justify-content-between">
                 <div class="latest_img">
                   <img src="<?=base_url()."assets_new/";?>images/latest.png" class="w-100">
                   <span class="date_upload">May 4, 2021</span>
                 </div>
                 <div class="latest_content p-4 bg-white">
                   <h5>We are heading to South Carolina for <br> Summer Pickleball Tournament! Detai</h5>
                  <p>Amet minim mollit non deserunt ullamco est sit <br> aliqua dolor do amet sint. Amet minim mollit non <br> Amet minim mollit non</p>
                  <a href="#">Read more</a>
                 </div>
               </div>
             </div>
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
                 <img src="<?=base_url()."assets_new/";?>images/Apple - App Store.png">
                 <img src="<?=base_url()."assets_new/";?>images/Google - Play Store.png">
               </div>
             </div>
           </div>
         </div>
       </div>
     </div>
     <!--Nine banner end -->



     <!--gallery banner start -->
     <div class="gallery pt-5 pb-5 ">
       <div class="container-fluid">
         <div class="row">
           <div class="col-lg-12">
              <div class="heading text-center pt-5 pb-5">
                <h1>Gallery</h1>
              </div>
           </div>
            <div class="col-lg-4">
              <div class="galler_img">
                <img src="<?=base_url()."assets_new/";?>images/g (4).png" class="w-100">
              </div>
            </div>
            <div class="col-lg-4">
              <div class="row">
                <div class="col-6">
                  <img src="<?=base_url()."assets_new/";?>images/g (2).png" class="w-100 mb-3">
                </div>
                <div class="col-6">
                  <img src="<?=base_url()."assets_new/";?>images/g (3).png" class="w-100 mb-3">
                </div>
                <div class="col-6">
                  <img src="<?=base_url()."assets_new/";?>images/g (1).png" class="w-100 mt-2">
                </div>
                <div class="col-6">
                  <img src="<?=base_url()."assets_new/";?>images/g (5).png" class="w-100 mt-2">
                </div>
              </div>
            </div>
            <div class="col-lg-4">
              <div class="gallery_card text-center pt-4 pb-4">
                <img src="<?=base_url()."assets_new/";?>images/g_logo.png" class="mb-3">
                <h4>Player of the Month</h4>
                <img src="<?=base_url()."assets_new/";?>images/player_of_the_month.png" class="w-80 player-month mt-2 mb-2">
                <h4 class="mt-3">David Hollifield</h4>
                <p class="club_info d-flex justify-content-center align-items-center mb-2"><img src="<?=base_url()."assets_new/";?>images/location.png"> Cumming, Georgia</p>
                  <p class="club_info d-flex justify-content-center align-items-center mb-0 pb-2"><img src="<?=base_url()."assets_new/";?>images/date.png"> Oct, 2018</p>
              </div>
            </div>
         </div>
       </div>
     </div>
     <!--gallery banner end -->

<!-- <div style="width: 850px; height: 500px; position: 'relative'; overflow: 'hidden';">
  <img src="https://picsum.photos/id/1062/1000/800" style="width:100%; height:100%; objectFit: 'cover'; filter: 'blur(6px)'"  />
  <img src="https://picsum.photos/id/1062/1000/800" style="width:100%; height:50%; objectFit: 'contain'; position: 'absolute'; zIndex: 2; left: 0"  />
 </div> -->

     <div class="bg_fotter pt-5 pb-5">
       <div class="container-fluid">
         <div class="row">
           <div class="col-lg-6">
             <div class="heading pb-3 text-center">
               <h1>Comments/Feedback</h1>
             </div>
             <div class="row">
               <div class="col-lg-8 offset-lg-2">
                 
                 <form class="row g-3">
                    <div class="col-md-12">
                      <input type="text" class="form-control" id="inputl4" placeholder="Full Name">
                    </div>
                    <div class="col-md-12">
                      <input type="email" class="form-control" id="inputEmail4" placeholder="Email Address">
                    </div>
                    <div class="col-12">
                      <textarea class="form-control" id="exampleFormControlTextarea1" rows="3" placeholder="Add Your Message (optional)"></textarea>
                    </div>
                    
                     <div class="form-group">
                            <!-- <div class="g-recaptcha" data-sitekey="6LfjEmgdAAAAACNY29t5aDGOlU48cf3nXq-NqQpT" data-callback="verifyRecaptchaCallback" data-expired-callback="expiredRecaptchaCallback"></div> -->
							<div class="g-recaptcha" data-sitekey="6LcmImgdAAAAAB70ZsDd9SBMA5JXNlFGwcttZv76"></div>
                            <input class="form-control d-none" data-recaptcha="true" required data-error="Please complete the Captcha">
                            <div class="help-block with-errors"></div>
                        </div>
                    <div class="col-12">
                      <button type="submit" class="btn btn_orange w-100 pt-2 pb-2">Submit</button>
                    </div>

                  </form>


               </div>
             </div>
           </div>
           <div class="col-lg-6">
             <div class="heading pb-3 text-center">
               <h1>Contact Us</h1>
             </div>
             <div class="row">
               <div class="col-lg-8 offset-lg-2">
                 <div class="contact d-flex justify-content-center align-items-center">
                   <p><img src="<?=base_url()."assets_new/";?>images/phone.png" >
                   +1 470 533 8707</p>
                 </div>
                 <div class="socil text-center">
                   <a href="#"><img src="<?=base_url()."assets_new/";?>images/Facebook.png"></a>
                   <a href="#"><img src="<?=base_url()."assets_new/";?>images/TwitterLogo.png"></a>
                   <a href="#"><img src="<?=base_url()."assets_new/";?>images/InstagramLogo.png"></a>
                 </div>
                 


               </div>
             </div>
           </div>
         </div>
       </div>
     </div>
     <div class="copyright pt-4 pb-4">
       <div class="container-fluid">
         <div class="row">
           <div class="col-lg-12">
             <p class="text-center text-light mb-0">Copyright &copy; 2021 A2M Sports. All Rights Reserved.</p>
           </div>
         </div>
       </div>
     </div>

    <!-- Optional JavaScript; choose one of the two! -->

    <!-- Option 1: Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>

    <!-- Option 2: Separate Popper and Bootstrap JS -->
    <!--
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js" integrity="sha384-7+zCNj/IqJ95wo16oMtfsKbZ9ccEh31eOz1HGyDuCQ6wgnyJNSYdrPa03rtR1zdB" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js" integrity="sha384-QJHtvGhmr9XOIpI6YVutG+2QOK9T+ZnN4kzFN1RtK3zEFEIsxhlmWl5/YESvpZ13" crossorigin="anonymous"></script>
    -->
    <script>
            $(document).ready(function() {
              var owl = $('.owl-carousel');
              owl.owlCarousel({
                margin: 50,
                nav: true,
                loop: true,
                responsive: {
                  0: {
                    items: 1
                  },
                  600: {
                    items: 3
                  },
                  1000: {
                    items: 3
                  }
                }
              })
            })
          </script>

    <script>
    
    $(document).ready(function(){
        $('.customer-logos').slick({
            slidesToShow: 6,
            slidesToScroll: 1,
            autoplay: true,
            autoplaySpeed: 1500,
            arrows: false,
            dots: false,
            pauseOnHover:false,
            responsive: [{
                breakpoint: 768,
                setting: {
                    slidesToShow:4
                }
            }, {
                breakpoint: 520,
                setting: {
                    slidesToShow: 3
                }
            }]
        });
    });

    </script>
          <script src="<?=base_url()."assets_new/";?>js/highlight.js"></script>
    <script src="<?=base_url()."assets_new/";?>js/app.js"></script>
    <script src="https://kit.fontawesome.com/140af656c6.js" crossorigin="anonymous"></script>
  </body>
</html>
<script src="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.6.0/slick.js"></script>
    <script src='https://www.google.com/recaptcha/api.js'></script>
    <script src="<?=base_url()."assets_new/";?>validator.js"></script>
    <script src="<?=base_url()."assets_new/";?>contact.js"></script>

<script type="text/javascript">
   $(document).ready(function(){
    $('.customer-logos').slick({
        slidesToShow: 6,
        slidesToScroll: 1,
        autoplay: true,
        autoplaySpeed: 1500,
        arrows: false,
        dots: false,
        pauseOnHover: false,
        responsive: [{
            breakpoint: 768,
            settings: {
                slidesToShow: 4
            }
        }, {
            breakpoint: 520,
            settings: {
                slidesToShow: 3
            }
        }]
    });
});
     var index = 0;
var slides = document.querySelectorAll(".slides");
var dot = document.querySelectorAll(".dot");

function changeSlide(){

  if(index<0){
    index = slides.length-1;
  }
  
  if(index>slides.length-1){
    index = 0;
  }
  
  for(let i=0;i<slides.length;i++){
    slides[i].style.display = "none";
    dot[i].classList.remove("active");
  }
  
  slides[index].style.display= "block";
  dot[index].classList.add("active");
  
  index++;
  
  setTimeout(changeSlide,3000);
  
}

changeSlide();

window.document.onkeydown = function(e) {
  if (!e) {
    e = event;
  }
  if (e.keyCode == 27) {
    lightbox_close();
  }
}

function lightbox_open() {
  var lightBoxVideo = document.getElementById("VisaChipCardVideo");
  window.scrollTo(0, 0);
  document.getElementById('light').style.display = 'block';
  document.getElementById('fadevedio').style.display = 'block';
  lightBoxVideo.play();
}

function lightbox_close() {
  var lightBoxVideo = document.getElementById("VisaChipCardVideo");
  document.getElementById('light').style.display = 'none';
  document.getElementById('fadevedio').style.display = 'none';
  lightBoxVideo.pause();
}
</script>
<script type="text/javascript">
 
  $(document).ready(function(){
    $('.customer-logos').slick({
    slidesToShow: 4,
    slidesToScroll: 1,
    autoplay: true,
    autoplaySpeed: 1500,
    arrows: true,
    dots: false,
    pauseOnHover: false,
    prevArrow: '',
    nextArrow: '',
    responsive: [{
      breakpoint: 768,
      settings: {
        slidesToShow: 3
      }
    }, {
      breakpoint: 520,
      settings: {
        slidesToShow: 2
      }
    }]
    });
  });
</script>


<!-- -------------------------------------- -->



<div style="width: 650; height: 50;, position: relative; overflow: hidden">
          <img src="https://picsum.photos/id/1062/1000/800" style="width:100%; height: 100%; objectFit: cover; filter: blur(10px);" />
		            <img src="https://picsum.photos/id/1062/1000/800" style="width:50%; height: 50%; objectFit: cover; position: absolute; zIndex: 2; left: 133px; top: 0;" />

        </div>