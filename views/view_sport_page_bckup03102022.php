 <style>
/* body { padding:0px; margin:0px; font-family:"Century Gothic", "Segoe UI"; font-size:14px; }*/
div.gallery {
  border: 1px solid #ccc;
}
 
div.gallery:hover {
  border: 1px solid #777;
}
 
div.gallery img {
  /*width: 100%;*/
  height: auto;
  background-color:#141414;
}
 
div.desc {
  padding: 15px;
  text-align: center;
}
 
* {
  box-sizing: border-box;
}
 
.responsive {
  padding: 0 6px;
  float: left;
  width: 24.99999%;
}
 
div.scrollmenu {
               padding-top:4px;
  background-color: #141414;
  overflow: auto;
  white-space: nowrap;
}
 
div.scrollmenu a {
  display: inline-block;
  color: white;
  text-align: center;
  padding: 14px;
  text-decoration: none;
}
 
div.scrollmenu a:hover {
  background-color: #777;
}
.horizontal_image{ width:300px; height:300px; }
 
.zoom:hover {transform: scale(1.3); 
  z-index:90;}
 
@media only screen and (max-width: 700px) {
  .responsive {
    width: 49.99999%;
    margin: 6px 0;
  }
}
 
@media only screen and (max-width: 500px) {
  .responsive {
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

     <section class="banner mx-3 pt-5">
       <div class="container-fluid">
         <div class="row">
           <div class="col-lg-6">
             <div class="banner_content text-start text-light pl-30 pt-3 pb-2">
               <h1 class="font-45">Connecting players, <br>Coaches and Clubs!</h1>
               <p class="font-15">Register for tournaments or Leagues, Offer Court Reservations, Coach Booking, Team Communications and more! For clubs, we host your club's website and offer branded mobile app with all these features built-in!</p>
				<a  class="btn_banner " href="#popup1" type="button">Request a demo</a>
             </div>
           </div>
           <div class="col-lg-6">
             <div class="banner_content text-start text-light pt-3 pb-2 relative">
			 <?php if($sport == 1){ ?>
              <img src="<?=base_url()."assets_new/";?>images/chino-rocha-2FKTyJqfWX8-unsplash-removebg-preview (1).png" class="w-100"> 
			  <?php } else if($sport == 2){ ?>
              <img src="<?=base_url()."assets_new/";?>images/tt-home.png" class="w-100"> 
			  <?php } else if($sport == 3){ ?>
              <img src="<?=base_url()."assets_new/";?>images/man2.png" class="w-100"> 
			  <?php } else if($sport == 7){ ?>
              <img src="<?=base_url()."assets_new/";?>images/pickleball-home.png" class="w-100">
			  <!-- <div id="slider d_show">

					<div class="slides ">  
					<img src="<?=base_url()."assets_new/";?>images/pickleball-home.png" width="100%" height="70%" class="slidrimg" />
					</div>
					<div class="slides ">  
					<img src="<?=base_url()."assets_new/";?>images/pb1.png" width="100%" height="70%" class="slidrimg" />
					</div>
					<div class="slides">  
					<img src="<?=base_url()."assets_new/";?>images/pb2.png" class="slidrimg" width="100%" height="70%" />
					</div>
					<div class="slides">  
					<img src="<?=base_url()."assets_new/";?>images/pb3.png" width="100%" height="70%" class="slidrimg" />
					</div> 
					<div class="slides">  
					<img src="<?=base_url()."assets_new/";?>images/pb4.png" width="100%" height="70%" class="slidrimg"/>
					</div> 
					<div class="slides">  
					<img src="<?=base_url()."assets_new/";?>images/pb5.png" width="100%" height="70%" class="slidrimg"/>
					</div> 
					<div class="slides">  
					<img src="<?=base_url()."assets_new/";?>images/pb6.png" width="100%" height="70%" class="slidrimg"/>
					</div> 
<div id="dot"><span class="dot"></span><span class="dot"></span><span class="dot"></span><span class="dot"></span><span class="dot"></span><span class="dot"></span><span class="dot"></span></div> -->
			</div>
			 <?php } ?>

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
            <div style='padding-bottom:3px !important; padding-top:4rem !important;' class="heading text-center pt-5 pb-5">
              <h1>Featured Tournaments / Leagues / Events</h1>
            </div>
          </div>
          <div class="row">
            <div id="feature" class="owl-carousel  owl-theme Testimonials">
         
<?php
//echo "<pre>"; print_r($leagues); exit;
if(!empty($leagues)) { 
$i=1;
foreach($leagues as $j => $row) {

if(!empty($row)) {
?>
		   <div class="item  "><!-- d-flex justify-content-between -->
              <div class="d-flex feature_box">
                <div class="feature_left /*bg-white*/ p-3" style="border-top-right-radius:0px !important; border-bottom-right-radius:0px !important; background-color:#fcc9bc !important; height:280px; border:2px solid #f88264">
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
					case 18: echo "Basketball";	 break;
					case 19: echo "Handball";	 break;
					case 20: echo "Paddleball";	 break;
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
                <div class="feature_right" style="border:2px solid #8050ef; background-color:#d7ccfa; height:280px; border-top-right-radius:16px !important; border-bottom-right-radius:16px !important; ">
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
	case 18:
		echo "default_basketball.jpg";
		break;
	case 19:
		echo "default_handball.jpg";
		break;
	case 20:
		echo "default_paddleball.jpg";
		break;
	default:
		echo "";
		break;
}
}
?>" style="display:none; object-fit: contain; border:1px solid #d1d1d1;filter: blur(6px); position: relative; height: 242px;" />

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
?>" style="object-fit: contain; padding:5px; /*border:1px solid #d2d2d2; top: 0px; position: absolute; width: 45%;*/ height:280px; " class="/*w-242*/">

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
		  <div class="sport_blue_btn col-lg-12 mt-1">
            <div class="btn_blue text-center">
              <a href="#viewAll" class="blue_btn show_all" id="vtournaments">View All Tournaments</a>
            </div>
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
               <p class="mb-3 mt-3">Can't wait till the next tournament? You can find and "Challenge" <br> other players to play with you. We will reward you everytime <br> you challenge someone with more points towards your A2M <br>Score'.</p>
               <a href="<?=base_url()."search";?>" class="btn_orange">Find a Player</a>
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
           <div class="heading text-center pt-4 pb-2">
            <h1>Top Rated Players</h1>
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
<a href="<?php echo base_url()."player/".$row->Users_ID; ?>">
<?php 
    $filename =  "C:\inetpub\wwwroot\a2msports\profile_pictures\thumbs\'".$user_details['Profilepic'];
	$filename1 = "C:\inetpub\wwwroot\a2msports\profile_pictures\'".$user_details['Profilepic'];

if(file_exists($filename)){ ?>
<img  src="<?php echo base_url(); ?>profile_pictures/thumbs/<?php if($user_details['Profilepic']!=""){echo $user_details['Profilepic']; } else { echo "&nbsp;";}?>" class="player_img" style="border-radius: 15px;" />
<?php } else { ?>
<img  src="<?php echo base_url(); ?>profile_pictures/<?php if($user_details['Profilepic']!=""){echo $user_details['Profilepic']; } else { echo "default-profile.png";}?>" class="player_img" style="border-radius: 15px;" />
<?php }  ?></a>

                  <!-- <img src="<?=base_url()."assets_new/";?>images/player_1.png" class="player_img"> -->
                  <!-- <img src="<?=base_url()."assets_new/";?>images/rank_<?=($key+1);?>.png" class="player_ig"> -->
				  <div class="name text-end">
                    <p class="mb-0 gry">A2M Rating</p>
                    <h6 class=""><?php echo $row->A2MScore;?></h6>
                  </div>

                </div>
                <div class="palyer_names d-flex justify-content-between">
                  <div class="name">
                    <p class="mb-0 gry">Name</p>
                    <h6 class=""><a href="<?php echo base_url()."player/".$row->Users_ID; ?>">
					<?php echo ucfirst($row->FirstName)." ".ucfirst($row->LastName);?>
					</a>
					</h6>
                  </div>
                  <!-- <div class="name text-end">
                    <p class="mb-0 gry">A2M Rating</p>
                    <h6 class=""><?php echo $row->A2MScore;?></h6>
                  </div> -->
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
<div class="sport_blue_btn col-lg-12 mt-1">
            <div class="btn_blue text-center">
              <a href="#viewAll" class="blue_btn show_all" id="vplayers">View All Players</a>
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
           <div class="heading text-center pt-5 pb-1">
            <h1>Most Active Teams</h1>
          </div>
         </div>
         <div class="row">
          <div class="col-lg-12">
           <div id="owl-one2" class="owl-carousel owl-theme Testimonials">
<?php
if($teams_result){
	//echo "<pre>"; print_r($teams_result); exit;
foreach($teams_result as $unp){
	$get_team_stats = league :: get_team_stats($unp->Team_ID);
?>
           <div class="item  ">
              <div class="Active_box bg-white px-4 pt-4 pb-4">
                <div class="img mb-3 bg-grey d-flex align-items-center justify-content-center" style="height: 95px;">
					<center>
				<?php if($unp->Team_Logo != NULL || $unp->Team_Logo != ""){
				$team_logo = "<img src='".base_url()."/team_logos/cropped/$unp->Team_Logo' alt='' style='object-fit: contain;width: 60%;'>";
			 }
			 else{ 
				$team_logo = "<img src='".base_url()."/team_logos/default_team_logo.png' alt='' style='object-fit: contain;width: 40%;'>";
			 } 
			 echo $team_logo;
			?>
				  </center>
                  <!-- <img src="<?=base_url()."assets_new/";?>images/active.png" > -->
                </div>
                <div class="actie_content text-center">
                  <h3><?php echo $unp->Team_name; ?></h3><?php if(strlen($unp->Team_name) < 18) echo "<br>"; ?>
                  <p class="gry"><?php echo $get_team_stats['wins']." - ".$get_team_stats['loss']; ?> (Win - Loss)</p>
                  <!--<p class="gry">4.8 (62 reviews)</p>
                   <div class="text-center d-flex justify-content-center align-items-center rating ">
                    <img src="<?=base_url()."assets_new/";?>images/star.png" > -->
                    <!-- <img src="<?=base_url()."assets_new/";?>images/star.png" >
                    <img src="<?=base_url()."assets_new/";?>images/star.png" >
                    <img src="<?=base_url()."assets_new/";?>images/star.png" > 
                    <img src="<?=base_url()."assets_new/";?>images/star.png" >
                  </div> -->
                  <div class="group_img mt-3 mb-2 d-flex justify-content-center">
				  <?php
				$team_players = json_decode($unp->Players);
				  if($team_players){
					  $t = 1;
					foreach($team_players as $pl){
						if($t < 7){
							$get_user = league :: get_username($pl);
							if($get_user['Profilepic']){
					?>
					<img class="rounded-circle" src="<?=base_url()."profile_pictures/".$get_user['Profilepic'];?>" style="height: 30px !important;">
				 <?php
							}
					else{
					?>
					<img class="rounded-circle" src="<?=base_url()."profile_pictures/default-profile.png";?>">
				 <?php
					}
					$t++;
						}
					}
				  }
				  else{
				  ?>
						<img src="<?=base_url()."assets_new/";?>images/p (1).png">
						<img src="<?=base_url()."assets_new/";?>images/p (2).png">
						<img src="<?=base_url()."assets_new/";?>images/p (3).png">
						<img src="<?=base_url()."assets_new/";?>images/p (4).png">
						<img src="<?=base_url()."assets_new/";?>images/p (5).png">
						<img src="<?=base_url()."assets_new/";?>images/p (6).png">
				<?php
				  }
				?>
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
              <a href="#viewAll" class="orange_btn show_all" id="vteams">View All Teams</a>
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
               <a href="#" class="btn_orange text-center">Search now</a>
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
               <a href="#" class="btn_orange text-center">Add score</a>
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
           <div class="heading text-center pt-5 pb-1">
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
				  <center><a href="<?php if($row->A2M_Proxy_URL) { echo $row->A2M_Proxy_URL; } else { echo base_url()."{$row->Aca_URL_ShortCode}"; } ?>">
                  <img src="<?=base_url();?>/org_logos/<?=$row->Aca_logo;?>" style="width: 117px !important; height: auto !important;" /></a>
				  </center>
                  <h4 class="mt-2"><?=$row->Aca_name;?></h4>
                </div>
                <div class="club_content text-start">
                  <div class="text-start mb-2 d-flex justify-content-start align-items-start rating ">
                    <!-- <img src="<?=base_url()."assets_new/";?>images/star.png" >
                    <img src="<?=base_url()."assets_new/";?>images/star.png" >
                    <img src="<?=base_url()."assets_new/";?>images/star.png" >
                    <img src="<?=base_url()."assets_new/";?>images/star.png" > 
                    <img src="<?=base_url()."assets_new/";?>images/gray_start.png" >
&nbsp;<p class="gry">4.8 (62 reviews)</p> -->

<?php
$get_clubratings = league::get_club_Rating($row->Aca_ID);
$avg_star_rating = 0;
if($get_clubratings){?>
<?php 
$s5 = 0; $s4 = 0; $s3 = 0;  $s2 = 0;  $s1 = 0;
   foreach($get_clubratings as $key => $value) {
	if($value->Ratings==5){
	  $s5+=1;
	} 
	if($value->Ratings==4){
	  $s4+=1;
	} 
	if($value->Ratings==3){
	  $s3+=1;
	} 
	if($value->Ratings==2){
	  $s2+=1;
	}
	if($value->Ratings==1){
	  $s1+=1;
	}
   }
			   
	$avg_star_rating = ($s5*5 + $s4*4 + $s3*3 + $s2*2 + $s1*1) / ($s5 + $s4 + $s3 + $s2 + $s1);
		echo "<a href='#searchclub' class='abc' id='club_$row->Aca_ID' style='text-decoration: none;'>";
				
	if( is_float( $avg_star_rating ) ) { // Check to see if whole number or decimal
		$rounded_ranking = round($avg_star_rating); // If decimal round it down to a whole number
				
		for ($counter=2; $counter <= $rounded_ranking; $counter++){ 
			echo " <i class='fa fa-star checked'></i> ";
		}
		
		echo '<i class="fa fa-star-half-o checked"></i> '; 
		// Static half star used as the ranking value is a decimal and the is_float condition is met.
		
	   for(;$rounded_ranking<5;$rounded_ranking++){
			echo '<i class="fa fa-star-o checked"></i> ';
	   }
	}  
	else{
		// For Loop so we can run the stars as many times as is set, no offset need, as no half star required for whole number rankings
		for ($counter=1; $counter <= $avg_star_rating; $counter++){
			echo '<i class="fa fa-star checked"></i> ';
		}
		for(;$avg_star_rating<5;$avg_star_rating++){
			echo '<i class="fa fa-star-o checked"></i> ';
		}
	}
echo "</a>";

}
else{
	echo "<a href='#searchclub' class='abc' id='club_$row->Aca_ID' style='text-decoration: none;'>";
	 for($j=0;$j<5;$j++){
	 	echo "<i class='fa fa-star-o checked'></i> ";
	 }
	 echo "</a>";
}
?>


<p class="gry">&nbsp;<?=$avg_star_rating; ?>  (<?=count($get_clubratings);?> reviews) </p>
                  </div>
                  
                  <!-- <p class="gry">4.8 (62 reviews)</p> -->
                  <p class="club_info d-flex justify-content-start align-items-center mb-2"><img src="<?=base_url()."assets_new/";?>images/location.png"> Cumming, Georgia</p>
                  <p class="club_info d-flex justify-content-start align-items-center mb-0 pb-2"><img src="<?=base_url()."assets_new/";?>images/label.png"> Starting at $10.00/hr</p>
                </div>
              </div>
                 <a href="<?=base_url()."{$row->Aca_URL_ShortCode}/courts/reserve";?>" class="club_btn">Book a Session</a>
           </div>
<?php
		   }
}
?>
            </div>
          </div>
          <div class="col-lg-12">
            <div class="btn_blue text-center">
              <a href="#viewAll" class="orange_btn show_all" id="vclubs">View All  Clubs</a>
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
           <div class="heading text-center pt-5 pb-3">
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
				<a href="<?php echo base_url()."coach/".$coach->Users_ID; ?>">
				<?php 
    $filename   =  "C:\inetpub\wwwroot\a2msports\profile_pictures\thumbs\'".$coach->Profilepic;
	$filename1 = "C:\inetpub\wwwroot\a2msports\profile_pictures\'".$coach->Profilepic;

				if(file_exists($filename)){ ?>
<img  src="<?php echo base_url(); ?>profile_pictures/thumbs/<?php if($coach->Profilepic != ""){echo $coach->Profilepic; } else { echo "&nbsp;";}?>" class="player_img" style="border-radius: 15px !important;" />
<?php } else { ?>
<img  src="<?php echo base_url(); ?>profile_pictures/<?php if($coach->Profilepic != ""){echo $coach->Profilepic; } else { echo "default-profile.png";}?>" class="player_img" style="border-radius: 15px !important;" />
<?php }  ?></a>
                  <!-- <img src="<?=base_url()."assets_new/";?>images/player_1.png" class="player_img"> -->
                 <div class="">
                     <!-- <div class="text-end mb-2 d-flex justify-content-end align-items-end rating ">
                    <img src="<?=base_url()."assets_new/";?>images/star.png" >
                    <img src="<?=base_url()."assets_new/";?>images/star.png" >
                    <img src="<?=base_url()."assets_new/";?>images/star.png" >
                    <img src="<?=base_url()."assets_new/";?>images/star.png" >
                    <img src="<?=base_url()."assets_new/";?>images/star.png" >
                  </div>
                  <p class="gry">4.8 (62 reviews)</p> -->
                  </div>
                </div>
                <div class="palyer_names d-flex justify-content-between">
                  <div class="name">
                    <p class="mb-0 gry">Name</p>
                    <h6 class="">
					<a href="<?php echo base_url()."coach/".$coach->Users_ID; ?>">
					<?=$coach->Firstname." ".$coach->Lastname;?></a>
					</h6>
                  </div>
                  <!-- <div class="name text-end">
                    <p class="mb-0 gry">Batches</p>
                    <h6 class="">Individual <br> & Group</h6>
                  </div> -->
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
          <div class="col-lg-12 mt-3">
            <div class="btn_blue text-center">
              <a href="#viewAll" class="orange_btn show_all" id="vcoaches">View All Coaches</a>
            </div>
          </div>
         </div>
       </div>
     </div>
     <!-- Rated  banner end -->





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
            <div class="heading text-center pt-4 pb-5">
              <h1>A2M Latest News</h1>
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
case 16:
echo "default_handball_min.jpg";
break;
case 16:
echo "default_paddleball_min.jpg";
break;
default:
echo "logo_fb.jpg";
break;
} ?>" class="w-100">
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
            <div class="heading text-center pt-4 pb-5">
                <h1>Global News</h1>
              </div>
             <!--<iframe src=https://it4gov.net/dev/rss/index.php onload='javascript:(function(o){o.style.height=o.contentWindow.document.body.scrollHeight + 200 + "px";}(this));' style="height:1600px;width:100%;border:none;overflow:hidden;"></iframe>-->
             <!--START-->
             <div style='/*background-color:#d7ccfa;*/ padding:0px; width:100%; min-height:240px;border:20px solid #d7ccfa; border-radius:20px; margin-bottom:20px;'> 
	
	<div class='shell' style='/*width:50%;*/ vertical-align:middle; display:inline-block; text-align:right; float:right; /*min-height:200px;*/ '><img src='https://i0.wp.com/blog.pickleballcentral.com/wp-content/uploads/2022/02/Blog-Cover-2.png?resize=585%2C305&ssl=1' style='width:100%; height:auto; object-fit:contain; /*padding-left:20px;*/ max-height:200px; background-color:#d7ccfa;'></div> 
	
	<div class='shell2' style='/*width:49%;*/ vertical-align:top; display:inline-block; text-align:left; padding:10px; background-color:#FFF;'><a style='color:#141414; text-decoration: underline; font-size:14px; font-weight:700;' href='https://blog.pickleballcentral.com/2022/02/17/baddle-pickleball-is-coming-to-pickleball-central-with-a-great-new-range-of-paddles/' title='BADDLE Pickleball is coming to Pickleball Central with a great new range of Paddles!' target='_blank'>BADDLE Pickleball is coming to Pickleball Central with a great new range of Paddles!</a><br /> 
	<br /> 
	<div style='display:inline-block; text-align:left; font-size:13px; overflow-wrap:break-word; width:98%; /*min-height:160px; max-height:100px;*/'>
	Baddle Pickleball Paddles launched during the COVID-19 pandemic and has made a mark with their colo ...</div></div> 
	
	
	
	</div> 
	<div style='/*background-color:#d7ccfa;*/ padding:0px; width:100%; min-height:240px;border:20px solid #d7ccfa; border-radius:20px; margin-bottom:20px;'> 
	
	<div class='shell' style='/*width:50%;*/ vertical-align:middle; display:inline-block; text-align:right; float:right; /*min-height:200px;*/ '><img src='https://i0.wp.com/blog.pickleballcentral.com/wp-content/uploads/2022/01/Blog-Cover-1.png?resize=571%2C298&ssl=1' style='width:100%; height:auto; object-fit:contain; /*padding-left:20px;*/ max-height:200px; background-color:#d7ccfa;'></div> 
	
	<div class='shell2' style='/*width:49%;*/ vertical-align:top; display:inline-block; text-align:left; padding:10px; background-color:#FFF;'><a style='color:#141414; text-decoration: underline; font-size:14px; font-weight:700;' href='https://blog.pickleballcentral.com/2022/02/07/2021-final-pro-rankings-from-world-pickleball-rankings/' title='2021 Final Pro Rankings from World Pickleball Rankings' target='_blank'>2021 Final Pro Rankings from World Pickleball Rankings</a><br /> 
	<br /> 
	<div style='display:inline-block; text-align:left; font-size:13px; overflow-wrap:break-word; width:98%; /*min-height:160px; max-height:100px;*/'>
	Pickleball World Rankings 2021
	
	
	
	Powered by PickleballTournaments.com and launched in 2021, the Wo ...</div></div> 
	
	
	
	</div> 
	<div style='/*background-color:#d7ccfa;*/ padding:0px; width:100%; min-height:240px;border:20px solid #d7ccfa; border-radius:20px; margin-bottom:20px;'> 
	
	<div class='shell' style='/*width:50%;*/ vertical-align:middle; display:inline-block; text-align:right; float:right; /*min-height:200px;*/ '><img src='https://i0.wp.com/blog.pickleballcentral.com/wp-content/uploads/2022/01/pbs-court-small.jpg?resize=640%2C432&ssl=1' style='width:100%; height:auto; object-fit:contain; /*padding-left:20px;*/ max-height:200px; background-color:#d7ccfa;'></div> 
	
	<div class='shell2' style='/*width:49%;*/ vertical-align:top; display:inline-block; text-align:left; padding:10px; background-color:#FFF;'><a style='color:#141414; text-decoration: underline; font-size:14px; font-weight:700;' href='https://blog.pickleballcentral.com/2022/01/18/how-to-select-a-portable-pickleball-net/' title='How To Select A Portable Pickleball Net' target='_blank'>How To Select A Portable Pickleball Net</a><br /> 
	<br /> 
	<div style='display:inline-block; text-align:left; font-size:13px; overflow-wrap:break-word; width:98%; /*min-height:160px; max-height:100px;*/'>
	Portable pickleball nets (often referred to as “portable pickleball net systems”) are the perfe ...</div></div> 
	
	
	
	</div> 
	<div style='/*background-color:#d7ccfa;*/ padding:0px; width:100%; min-height:240px;border:20px solid #d7ccfa; border-radius:20px; margin-bottom:20px;'> 
	
	<div class='shell' style='/*width:50%;*/ vertical-align:middle; display:inline-block; text-align:right; float:right; /*min-height:200px;*/ '><img src='https://i0.wp.com/blog.pickleballcentral.com/wp-content/uploads/2022/01/nationals-2021_7146.jpg?resize=278%2C417&ssl=1' style='width:100%; height:auto; object-fit:contain; /*padding-left:20px;*/ max-height:200px; background-color:#d7ccfa;'></div> 
	
	<div class='shell2' style='/*width:49%;*/ vertical-align:top; display:inline-block; text-align:left; padding:10px; background-color:#FFF;'><a style='color:#141414; text-decoration: underline; font-size:14px; font-weight:700;' href='https://blog.pickleballcentral.com/2022/01/13/meet-the-pros-riley-and-lindsey-newman-aka-newman-squared/' title='Meet the Pros: Riley and Lindsey Newman (aka Newman Squared)' target='_blank'>Meet the Pros: Riley and Lindsey Newman (aka Newman Squared)</a><br /> 
	<br /> 
	<div style='display:inline-block; text-align:left; font-size:13px; overflow-wrap:break-word; width:98%; /*min-height:160px; max-height:100px;*/'>
	Riley and Lindsey Newman are a rockstar brother and sister duo (still working on their team name bu ...</div></div> 
	
	
	
	</div>

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
              <div class="heading text-center pt-1 pb-5">
                <h1>Gallery</h1>

				
<!--<img id="myImg" src="images/4.jpg" alt="" style="width:100%;max-width:300px">-->

<div style="display:block; padding-top:4px; background-color: #141414;overflow: auto;white-space: nowrap; width:100vw">

  <img id='1' style="height:250px;" src="images/16.jpg" onClick="openmodal(this.src, this.id)">

  <img id='2' style="height:250px;" src="images/18.jpg" onClick="openmodal(this.src, this.id)">

  <img id='3' style="height:250px;" src="images/20.jpg" onClick="openmodal(this.src, this.id)">

  <img id='4' style="height:250px;" src="images/4.jpg"  onClick="openmodal(this.src, this.id)">

  <img id='5' style="height:250px;" src="images/6.jpg"  onClick="openmodal(this.src, this.id)">

  <img id='6' style="height:250px;" src="images/8.jpg"  onClick="openmodal(this.src, this.id)">

</div>

 

 

<!-- The Modal -->

<div id="myModal" class="modal">

  <span class="close">&times;</span>

  <img class="modal-content" id="img01">

  <!--<div id="caption"></div>-->

  <input id="ok" name="ok" type="text" value="0" style="display:none;">

  <!-- Next/previous controls -->

    <a class="prev" onclick="previousSlide()">&#10094;</a>

    <a class="next" onclick="nextSlide()">&#10095;</a>

   

    <!--<input type='button' value='next' onclick='ic1.next("container")' />

               <input type='button' value='prev' onclick='ic1.prev("container")' />-->

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

 

 

const pictures = ["", "images/16.jpg", "images/18.jpg", "images/20.jpg", "images/4.jpg", "images/6.jpg", "images/8.jpg"];

 

function nextSlide(imageid) {

 

  var thisimageid = document.getElementById("ok").value;

  var gotoid = parseInt(thisimageid) + 1;

  if (gotoid == 7) { gotoid=1; }

              

var modalImg = document.getElementById("img01");

 

openmodal(pictures[gotoid], gotoid);

}

 

 

 

 

function previousSlide(imageid) {

 

  var thisimageid = document.getElementById("ok").value;

  var gotoid = parseInt(thisimageid) - 1;

  if (gotoid == 0) { gotoid=6; }

              

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
              })
            })
          </script>


              <script>
            $(document).ready(function() {
              var owl_ = $('#owl-one1');
              owl_.owlCarousel({
                margin: 20,
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
                    items: 4
                  }
                }
              })
            })
          </script>


        <script>
            $(document).ready(function() {
              var owl_ = $('#owl-one2');
              owl_.owlCarousel({
                margin: 20,
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
                    items: 4
                  }
                }
              })
            })
          </script>


          <script>
            $(document).ready(function() {
              var owl_ = $('#owl-one3');
              owl_.owlCarousel({
                margin: 20,
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
                    items: 4
                  }
                }
              })
            })
          </script>



          <script>
            $(document).ready(function() {
              var owl_ = $('#owl-one4');
              owl_.owlCarousel({
                margin: 20,
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
                    items: 4
                  }
                }
              })
            })
            document.addEventListener("DOMContentLoaded", function(){
  // add padding top to show content behind navbar
  navbar_height = document.querySelector('.navbar').offsetHeight;
  document.body.style.paddingTop = navbar_height + 'px';
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