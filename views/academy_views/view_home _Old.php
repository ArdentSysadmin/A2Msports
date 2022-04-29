<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <title>A2MSports - Sports Club</title>
<meta content="text/html; charset=utf-8" http-equiv="Content-Type" />
<!-- <meta property='fb:appid' content='792863394192570' />
<meta property='fb:secret' content='3af064a75201ceb1552db607d3d63fad' />
<meta property="og:title" content="Tournament" />
<meta property="og:type" content="Sports" />
<meta property="og:url" content="<?php echo base_url(); ?>" />
<meta property="og:image" content="<?php echo base_url(); ?>tour_pictures/Tennis_shake_hands_after_match.jpg" /> -->

<meta name="keywords" content="Tennis, club, events, football, golf, non-profit, betting assistant, football, tennis, sport, soccer, goal, sports, volleyball, basketball,	charity, club, cricket, football, hockey, magazine, non profit, rugby, soccer, sport, sports, tennis" />
<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    
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

</head>
<body>
<div id="fb-root"></div>
<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/en_US/sdk.js#xfbml=1&version=v2.6";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));</script>
<!--SECTION TOP LOGIN
     <section class="content-top-login">
           <div class="container">
      <div class="col-md-12">
           <div class="box-support"> 
             <p class="txt-torn"><a href='<?php echo base_url();?>league'>Create Tournament</a></p>
          </div>
           <div class="box-login"> 
             <a href='login'>Login</a>
             <a href='Register'>New User</a>
          </div>
          
        </div>
      </div>
     </section>  -->
      <!--SECTION MENU -->
	 
	   <section class="container box-logo">
        <header>
           <div class="content-logo col-md-12">
          <div class="logo"> <a href="<?php echo base_url();?>"><img src="<?php echo base_url();?>images/logo.png" alt="" /></a>
          </div>
          
          <div class="bt-menu"><a href="#" class="menu"><span>&equiv;</span> Menu</a></div>

         <div class="box-menu">
            
            <nav id="cbp-hrmenu" class="cbp-hrmenu">
					    <ul id="menu">    
                          <?php $url_seg = $this->uri->segment(1); ?>

							
							<?php if($this->session->userdata('user')!="") {?>
                            <li><a class="lnk-menu <?php if($url_seg == 'Play'){ echo "active"; } ?>" href="<?php echo base_url();?>Play">My Sports</a></li>
							<?php } 
							else
							{
							?>
							<li><a class="lnk-menu" href="<?php echo base_url();?>Play">Play</a></li>
							<?php
							}
							?>
							<li><a class="lnk-menu" href="<?php echo base_url();?>calendar">Calendar</a></li>
                            <li><a class="lnk-menu" href="<?php echo base_url();?>League">Create Tournament</a></li>
                            <li><a class="lnk-menu" href='<?php echo base_url();?>Opponent'>Challenge</a></li>
                            <li><a class="lnk-menu" href="<?php echo base_url();?>Search">Search</a></li>
							<li><a class="lnk-menu" href="<?php echo base_url();?>Addscore">Add Score</a></li>
                           <!-- <li><a class="lnk-menu" href="<?php echo base_url();?>Events">Team Captain</a></li>-->
                            <li><a class="lnk-menu" href="<?php echo base_url();?>events/add">Schedule</a></li>
							 <li><a class="lnk-menu" href="<?php echo base_url();?>help">Help</a></li>
                            <!--<li><a class="lnk-menu" href="contactus.html">Contact us</a></li>-->

					<?php if($this->session->userdata('user')!="") {?>
							<!-- <li><a class="lnk-menu" href="#" onclick="javascript:location.href='<?php echo base_url();?>profile'"> -->
							<li><a class="lnk-menu" href="#">
							<?php echo $this->session->userdata('user'); ?>
							<i class="fa fa-chevron-down"></i></a> 
                             <div class="cbp-hrsub sub-little">
                             <div class="cbp-hrsub-inner"> 
                             <div class="content-sub-menu">
                             <ul class="menu-pages" style="float:left; width:100%;">
                                   <li><a href="<?php echo base_url();?>profile/add_profile"><span align='center'>Add Player</span></a></li> 
								 <!-- <li><a href="#"><span align='center'>Add Player</span></a></li> -->
                                    <li><a href="<?php echo base_url();?>profile"><span align='center'>My Profile</span></a></li>
                                    <li><a href="<?php echo base_url();?>logout"><span align='center'>Logout</span></a></li>
                                </ul>
                                </div>
                                </div>
                                </div>
                            </li>
					<?php } 
					else
					{
					?>
					<li><a class="lnk-menu" href="login">Login</a></li>
					<?php
					}
					?>
					</ul>
				</nav>
              </div>
			</div>
	    </header>
     </section>
	 
	
	 
          <!--SECTION CONTAINER SLIDER-->
   <section class="slider">
                            <div id="slider" class="flexslider flexslider-attachments hidden-xs">
                                <ul class="slides">
                                    <li><img src="<?php echo base_url();?>images/slide1.jpg" alt=""/>
                                    <!--<p class="flex-caption">Adventurer Cheesecake Brownie</p>-->
                                    </li>
  	    	                        <li><img src="<?php echo base_url();?>images/slide2.jpg" alt=""/></li>
  	    	                        <li><img src="<?php echo base_url();?>images/slide3.jpg" alt=""/></li>
                                    <li><img src="<?php echo base_url();?>images/slide4.jpg" alt=""/></li>
                                    <li><img src="<?php echo base_url();?>images/slide5.jpg" alt=""/></li>
                                    <!-- <li><img src="images/slide6.jpg" alt=""/></li> -->
                                </ul>
                            </div>
   </section>
          <!-- SECTION NEWS SLIDER -->
         <section class="news_slide-over-color">

           <div class="container">
           
           	<div class="col-xs-12 col-md-12 top-slide-info">
            	<div class="leaghead"><h2>Tournaments</h2></div>
           
			<?php if(!empty($games)) { 
				$i=1;
				foreach($games as $row) { 
				?>

				<div class="col-xs-6 col-md-6" <?php if($i > 2) { echo "box-top-txt"; } ?>>
				<div class="col-md-12" style="border-bottom:1px solid #f7a224; margin-bottom:10px; padding-bottom:10px; min-height:173px;  padding-right:0px; margin-right:0px;">
                
				<div class="col-md-8" style="padding-left:0px">
                <div class="event_date dd-date"><?php echo date('M d, Y', strtotime($row[0]->StartDate)); ?></div>
				<h4><a href=<?php echo base_url()."league/view/" . $row[0]->tournament_ID; ?>><?php echo $row[0]->tournament_title; ?></a></h4>
				<p><b>Sport </b> <?php switch($row[0]->SportsType){
				
				case 1: echo "Tennis"; break;
				case 2: echo "Table Tennis"; break;
				case 3: echo "Badminton"; break;
				case 4: echo "Golf"; break;
				case 5: echo "RacquetBall"; break;
				case 6: echo "Squash"; break;
				
				} ?></p>
                <p><b>Location </b> <?php echo $row[0]->TournamentCity. ',' .$row[0]->TournamentState; ?></p>

                <p><?php 
				//$str = $row[0]->TournamentDescription;
                //$sp = strpos($str,'.');
				//echo substr($str,0,$sp);
				?>
				
				
				<?php 
						  $str = substr($row[0]->TournamentDescription, 0, 40);
						  $result = substr($str, 0, strrpos($str, ' '));

						echo $result." ...";
					?>


				</p>


			</div>

			<div class="col-md-4 slide-cont-img" style="padding-right:0px !important"><a href=<?php echo base_url()."league/view/" . $row[0]->tournament_ID; ?>>
				<img class="scale_image" src="<?php echo base_url(); ?>tour_pictures/<?php if($row[0]->TournamentImage!=""){ echo $row[0]->TournamentImage; }
				
				else {
					switch($row[0]->SportsType) {
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


			    ?>" alt="" width="178px" height="124px" />
				</a></div>

			</div>
                
			</div>


				<?php $i++; 
				} ?>
				<?php } ?>

             </div>
             <!-- <div class="txt-torn" align="center" style="padding-bottom:40px"><a href="#">Create Tornament</a></div>-->
           </div>
     </section>

    <section id="parallaxTraining">
          <section id="next-match">
          <div class="container">
       <div class="col-xs-12 col-md-12 top-first-info">
               <div class="col-md-4"> <a href="Search"><img src="images/ht2.jpg" alt=""/></a>
                     <div class="slide-news-bottom"><a href="<?php echo base_url();?>Search">Search for Members&nbsp;<span style="font-size:18px">(<?php echo $members;?>)</span></a><a class="i-ico" href="Search"><i class="fa fa-angle-double-right"></i></a></div>
                </div>
                <div class="col-md-4"> <a href="League"><img src="images/ht1.jpg" alt=""/></a>
                     <div class="slide-news-bottom"><a href="<?php echo base_url();?>League">Create Tournament&nbsp;<span style="font-size:18px">(<?php echo $tourns;?>)</span></a><a class="i-ico" href="Play"><i class="fa fa-angle-double-right"></i></a></div>
                </div>
                <div class="col-md-4"> <a href="Opponent"><img src="images/l1.jpg" alt=""/></a>
                     <div class="slide-news-bottom"><a href="<?php echo base_url();?>Opponent">Create Matches&nbsp;<span style="font-size:18px">(<?php echo $gen_matches + $tourn_matches;?>)</span></a><a class="i-ico" href="Opponent"><i class="fa fa-angle-double-right"></i></a></div>
                </div>
             </div>
             </div>
     </section>
     </section>
              <section class="container"></section>
			  
			   <section id="footer-tag">
           <div class="container">
             <div class="col-md-12">
              <div class="col-md-4 hidden-xs">
                 <h3>About Us</h3>
                 <p>Amateurs To Masters (A2M) Sports is a social platform for sports lovers, from Amateurs to Masters. It finds other players like you with similar interests, helps you keep track of your scores and manage your progress along the way. At A2M Sports, our mission is to help every player achieve their maximum potential by providing easy and convenient options to play.</p>
                 
				 <p>We help sports academies or any business entities to organize variety of leagues or tournaments and keep the data for statistics and ranking purposes.</p>


		<p style="float:right"><a href="<?php echo base_url();?>aboutus"><font color="#ffffff"><u>Read More</u></font></a></p>
              </div>
			<!--  <div class="col-md-3 cat-footer">
                
                <h3 class='last-cat'>Categories</h3>
                <ul class="last-tips">
                  <li><a href="index.html">Home</a></li>
                  <li><a href="create-league.html">Sports</a></li>
                  <li><a href="member-list.html">Members</a></li>
                  <li><a href="calendar.html">Calendar</a></li>
                  <li><a href="help.html">Help</a></li>
                  <li><a href="contactus.html">Contact us</a></li>
                </ul>
              </div> -->
              <div class="col-md-4 hidden-xs">
                 <h3>Latest News</h3>
                 
				 <?php foreach($results as $row ){ ?>

                 <ul class="footer-last-news">
                    <li>
					<?php $admin_users = array(215,214);
					$user_id = $this->session->userdata('users_id'); ?>

					<?php if(in_array($user_id, $admin_users)){ ?>
					<p style="float:right"><a href=<?php echo base_url()."News/edit/" . $row->News_id ;?>><font color="#ffffff"><u>Edit</u></font></a></p> 
					<?php }?>
					<a href=<?php echo base_url()."News/get_news_detail/" . $row->News_id ;?>>
					
					<img class="" src="<?php echo base_url(); ?>tour_pictures/<?php 
					
					switch($row->SportsType_id) {
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

				
			    ?>" alt="" />

					
					<p><?php 
						  $abc = strip_tags($row->News_content);
						  $s = substr($abc, 0, 75);
						 $result = substr($s, 0, strrpos($s, '.'));
						 echo strip_tags($s) . "...";
					?>
					</p>
					
					</li>
					</a>
                 
                 </ul>
					 <li style="clear:both; height:1px; list-style:none"></li>
				  <?php } ?>

              </div>
              <div class="col-md-4 footer-newsletters hidden-xs">
                <h3>Newsletters</h3>
                <form method="post">     
                    <div class="name">
                        <label for="name">* Name:</label><div class="clear"></div>
                        <input id="name" name="name" type="text" placeholder="e.g. Mr. John Doe" required/>
                    </div>
                    <div class="email">
                        <label for="email">* Email:</label><div class="clear"></div>
                        <input id="email" name="email" type="text" placeholder="example@domain.com" required/>
                    </div>
                    <div id="loader">
                                <input type="submit" value="Submit"/>
                        </div>
                </form>
              </div>
              <div class="col-xs-12">
                <!-- <ul class="social">
                      <li><a href="#"><i class="fa fa-facebook"></i></a></li>
                      <li><a href="#"><i class="fa fa-twitter"></i></a></li>
                      <li><a href="#"><i class="fa fa-linkedin"></i></a></li>
                      <li><a href="#"><i class="fa fa-digg"></i></a></li>
                      <li><a href="#"><i class="fa fa-rss"></i></a></li>
                      <li><a href="#"><i class="fa fa-youtube"></i></a></li>
                      <li><a href="#"><i class="fa fa-tumblr"></i></a></li>

                    </ul> -->
              </div>
             </div>
           </div>
    </section>
    
    <footer>
<div class="content-footer">
  <div class="container">
	  <div class="col-md-9">
		<p>© 2016 a2msports.com. All rights reserved. </p>
	  </div>
	  <div class="col-md-3" style="padding-right:50px">
	  <div class="fb-like" data-href="http://www.a2msports.com/" data-layout="standard" data-action="like" data-show-faces="false" data-share="true"></div>
		</div>
	  <!--<div class="fb-share-button" data-href="http://www.a2msports.com/" data-layout="button" data-mobile-iframe="false"></div>
	  <div class="col-md-3" style="padding-right:50px">
		<a href='https://www.facebook.com/a2msports' target='_blank'>
		<img src="<?php echo base_url().'images/fb_round.png'; ?>" alt='Facebook Page' width='25px' height='25px' align='right' />
		</a>
	  </div>-->
  </div>
</div>
	</footer>

<script src="<?php echo base_url();?>js/jquery-1.10.2.js" type="text/javascript"></script>
<script src="<?php echo base_url();?>js/jquery-migrate-1.2.1.min.js" type="text/javascript"></script>
<script src="<?php echo base_url();?>js/jquery.transit.min.js" type="text/javascript"></script>

<!--MENU-->
<script src="<?php echo base_url();?>js/menu/modernizr.custom.js" type="text/javascript"></script>
<script src="<?php echo base_url();?>js/menu/cbpHorizontalMenu.js" type="text/javascript"></script>
<!--END MENU-->

<!--Mini Flexslide-->
<script src="<?php echo base_url();?>js/minislide/jquery.flexslider.js" type="text/javascript"></script>

<!-- Percentace circolar -->
<script src="<?php echo base_url();?>js/circle/jquery-asPieProgress.js" type="text/javascript"></script>
<script src="<?php echo base_url();?>js/circle/rainbow.min.js" type="text/javascript"></script>

<!--Gallery-->
<script src="<?php echo base_url();?>js/gallery/jquery.prettyPhoto.js" type="text/javascript"></script>
<script src="<?php echo base_url();?>js/gallery/isotope.js" type="text/javascript"></script>

<!-- Button Anchor Top-->
<script src="<?php echo base_url();?>js/jquery.ui.totop.js" type="text/javascript"></script>
<script src="<?php echo base_url();?>js/custom.js" type="text/javascript"></script>
<script src="<?php echo base_url();?>js/jquery.bxslider.js" type="text/javascript"></script>

<!--Carousel News-->
<script src="<?php echo base_url();?>js/jquery.easing.1.3.js" type="text/javascript"></script>
<script src="<?php echo base_url();?>js/jquery.mousewheel.js" type="text/javascript"></script>

<!--Carousel Clients-->
<script src="<?php echo base_url();?>js/own/owl.carousel.js" type="text/javascript"></script>

<!--Count down-->
<script src="<?php echo base_url();?>js/jquery.countdown.js" type="text/javascript"></script>

<script src="<?php echo base_url();?>js/custom_ini.js" type="text/javascript"></script> 
 
</body>
</html>
