<!DOCTYPE html>
<html xmlns="https://www.w3.org/1999/xhtml">
<head>
<title>A2MSports - Sports Club</title>
<meta content="text/html; charset=utf-8" http-equiv="Content-Type" />

<meta name="keywords" content="Club, Management, Platform, Tennis, club, events, football, golf, non-profit, betting assistant, football, tennis, sport, soccer, goal, sports, volleyball, basketball,	charity, football, hockey, magazine, non profit, rugby, soccer, sport, sports, tennis" />
<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
<meta name="description" content="A2MSports is a social platform for sports lovers, from Amateurs to Masters.."/>

<link href="<?php echo base_url();?>css/bootstrap.css" rel="stylesheet" type="text/css"/>
<!-- <link href="https://cdnjs.cloudflare.com/ajax/libs/jquery-ui-bootstrap/0.5pre/assets/css/bootstrap.min.css" rel="stylesheet" type="text/css" /> -->

<link href='https://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,400,700,600,300' rel='stylesheet' type='text/css'/>
<link href='https://fonts.googleapis.com/css?family=Raleway:400,100,300,200,500,600,700,800,900' rel='stylesheet' type='text/css'/>
<link href='https://fonts.googleapis.com/css?family=Oswald:400,300,700' rel='stylesheet' type='text/css' />
<link href='https://fonts.googleapis.com/css?family=Lato:100,300,400,700,900,100italic,300italic,400italic,700italic,900italic' rel='stylesheet' type='text/css' />

<link href="<?php echo base_url();?>css/fonts/font-awesome-4.1.0/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
<!--Clients-->
<link href="<?php echo base_url();?>css/own/owl.carousel.css"		rel="stylesheet" type="text/css" />
<!-- <link href="<?php echo base_url();?>css/own/owl.theme.css"			rel="stylesheet" type="text/css" /> -->

<!-- <link href="https://cdnjs.cloudflare.com/ajax/libs/owl-carousel/1.3.3/owl.carousel.min.css" rel="stylesheet" type="text/css" /> -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/owl-carousel/1.3.3/owl.theme.min.css"	rel="stylesheet" type="text/css" />
<link href="<?php echo base_url();?>css/jquery.bxslider.css" rel="stylesheet" type="text/css" />
<!-- <link href="https://cdnjs.cloudflare.com/ajax/libs/bxslider/4.1.2/jquery.bxslider.css" rel="stylesheet" type="text/css" /> -->

<!-- <link href="<?php echo base_url();?>css/jquery.jscrollpane.css"		rel="stylesheet" type="text/css" /> -->
<!-- <link href="<?php echo base_url();?>css/minislide/flexslider.css"	rel="stylesheet" type="text/css" />  -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/flexslider/2.7.2/flexslider.min.css"	rel="stylesheet" type="text/css" />
<link href="<?php echo base_url();?>css/component.css"				rel="stylesheet" type="text/css" />
<link href="<?php echo base_url();?>css/bootsnav.css" rel="stylesheet">

<!-- <link href="<?php echo base_url();?>css/prettyPhoto.css" rel="stylesheet" type="text/css" /> -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/prettyPhoto/3.1.6/css/prettyPhoto.min.css" rel="stylesheet" type="text/css" />
<link href="<?php echo base_url();?>css/style_dir.css" rel="stylesheet" type="text/css" />
<link href="<?php echo base_url();?>images/favicon.png" rel="shortcut icon" type="image/png" />
<link href="<?php echo base_url();?>css/responsive.css" rel="stylesheet" type="text/css" />
<link href="<?php echo base_url();?>css/animate.css" rel="stylesheet" type="text/css" />
<script>
window.addEventListener("hashchange", function () {
window.scrollTo(window.scrollX, window.scrollY - 95);
});

/*nav.find('a').on('click', function () {
var $el = $(this)
, id = $el.attr('href');

$('html, body').animate({
scrollTop: $(id).offset().top - nav_height
}, 500);

return false;
});*/
</script>

<!-- Global site tag (gtag.js) - Google Analytics -->
<!-- <script async src="https://www.googletagmanager.com/gtag/js?id=UA-114329843-1"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'UA-114329843-1');
</script> -->



<style>
.li_disabled {
    pointer-events:none;	 /* This makes it not clickable */
    opacity:0.6;				 /* This grays it out to look disabled */
}
</style>
<noscript><img height="1" width="1" style="display:none"
  src="https://www.facebook.com/tr?id=636569003561353&ev=PageView&noscript=1"
/></noscript>

<!-- Facebook Pixel Code -->
<script>
!function(f,b,e,v,n,t,s)
{if(f.fbq)return;n=f.fbq=function(){n.callMethod?
n.callMethod.apply(n,arguments):n.queue.push(arguments)};
if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version='2.0';
n.queue=[];t=b.createElement(e);t.async=!0;
t.src=v;s=b.getElementsByTagName(e)[0];
s.parentNode.insertBefore(t,s)}(window, document,'script',
'https://connect.facebook.net/en_US/fbevents.js');
fbq('init', '1061560047305790');
fbq('track', 'PageView');
</script>
<noscript><img height="1" width="1" style="display:none"
src="https://www.facebook.com/tr?id=1061560047305790&ev=PageView&noscript=1"
/></noscript>
<!-- End Facebook Pixel Code -->

</head>
<body>
<div class="headfixed">

<section class="container box-logo">
<header>
<nav class="navbar navbar-default bootsnav">
<div class="content-logo col-md-12">
<div class="logo"> <a href="<?php echo base_url();?>"><img src="<?php echo base_url();?>images/logo.png" alt="" /></a>
</div>
<!-- <div class="bt-menu"><a href="#" class="menu"><span>&equiv;</span> Menu</a></div>
<div class="box-menu"> -->

<!-- header menu -->
	<!-- Start Header Navigation -->

            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#navbar-menu">
                    <i class="fa fa-bars"></i>
                </button>
            </div>
            <!-- End Header Navigation -->

            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse" id="navbar-menu">
                <ul class="nav navbar-nav navbar-right" data-in="fadeInDown" data-out="fadeOutUp">
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" >Create</a>
                        <ul class="dropdown-menu">
						  <li><a href="<?php echo base_url();?>ladder"><span align='center'>Challenge Ladder</span></a></li>
						  <li><a href="<?php echo base_url();?>events/add"><span align='center'>Event</span></a></li>
						  <li><a href="<?php echo base_url();?>league/bracket_generator"><span align='center'>Free Brackets</span></a></li>
						  <li><a href="<?php echo base_url();?>league"><span align='center'>League</span></a></li>
						  <li><a href="<?php echo base_url();?>teams"><span align='center'>Team</span></a></li>
						  <li><a href="<?php echo base_url();?>tournament"><span align='center'>Tournament</span></a></li> 
                        </ul>
                    </li>  
<?php
//if($this->session->userdata('user')!="") {?>
<!-- <li><a class="lnk-menu <?php //if($url_seg == 'Play'){ echo "active"; } ?>" href="<?php //echo base_url();?>Play">My Sports</a></li> -->
<?php //} 
//else { ?>
<!-- <li><a class="lnk-menu <?php //if($url_seg == 'Play'){ echo "active"; } ?>" href="<?php //echo base_url();?>Play">Play</a></li> -->
<?php
//}
?>
<li><a class="lnk-menu <?php if($url_seg == 'calendar'){ echo "active"; } ?>" href="<?php echo base_url();?>calendar">Calendar</a></li>
<li class="dropdown"><a href="#" class="dropdown-toggle" data-toggle="dropdown">Sports</a>
<ul class="dropdown-menu">
<?php
//$menu_arr = $this->session->userdata('menu_items');

//foreach($menu_arr as $i => $menu_item) { ?>
	    <?php  //if($menu_item['Order'] < 5) { ?>
		<!-- <li><a href="<?php //echo base_url().$menu_item['ShortCode'];?>"><span align='center'><?php //echo $menu_item['Sport'];?></span></a></li> -->
		<?php //} else { 
		//$rest_menu .= "<li class='more_sports'><a href='".base_url().$menu_item['ShortCode']."'><span align='center'>{$menu_item['Sport']}</span></a></li>";
		//}
		?>
<?php
//}
?>
<li><a href="<?=base_url(); ?>badminton"><span align="center">Badminton</span></a></li>
<li><a href="<?=base_url(); ?>pickleball"><span align="center">Pickleball</span></a></li>
<li><a href="<?=base_url(); ?>tt"><span align="center">Table Tennis</span></a></li>
<li><a href="<?=base_url(); ?>tennis"><span align="center">Tennis</span></a></li>
<li id="show_more"><a href="<?php echo base_url(); ?>sports"><span align='center'>More Sports&nbsp;&nbsp;
<!-- <i class="fa fa-chevron-down"></i> --></span></a></li>
<?//=$rest_menu;?>
 </ul>
</li>
<li><a class="lnk-menu <?php if($url_seg == 'Search'){ echo "active"; } ?>" href="<?php echo base_url();?>Search"> Search</a></li>
<!-- <li><a class="lnk-menu <?php if($url_seg == 'Addscore'){ echo "active"; } ?>" href="<?php echo base_url();?>Addscore">Add Score</a></li> -->

<li class="dropdown">
	<a href="#" class="dropdown-toggle" data-toggle="dropdown" >Do</a>
	<ul class="dropdown-menu">
	  <li><a href="<?php echo base_url();?>Addscore"><span align='center'>Add Score</span></a></li>
	  <li><a href="<?php echo base_url();?>opponent"><span align='center'>Challenge</span></a></li>
	  <li><a href="<?php echo base_url();?>clubs"><span align='center'>Pay and Play</span></a></li>          
	</ul>
</li>  

<!-- <li><a class="lnk-menu <?php if($url_seg == 'Events'){ echo "active"; } ?>" href="<?php echo base_url();?>events/add">Schedule</a></li> --><li><a class="lnk-menu <?php if($url_seg == 'Help'){ echo "active"; } ?>" href="<?php echo base_url();?>Help">Help</a></li>

<?php if($this->session->userdata('user') != "") {?>
<li class="dropdown"><a href="#" class="dropdown-toggle" data-toggle="dropdown">
<?php 
$get_fname = explode(' ', $this->session->userdata('user'));
echo $get_fname[0];
?>
</a> 
<ul class="dropdown-menu">

<?php 
$child = $this->session->userdata('child_user_id');
if(!$child) { ?>
<li><a href="<?php echo base_url();?>profile/add_profile"><span align='center'>Add Player</span></a></li> 
<?php } ?>

<li><a href="<?php echo base_url();?>profile"><span align='center'>My Profile</span></a></li>
<li><a href="<?php echo base_url();?>a2mteams"><span align='center'>My Teams</span></a></li>
<li><a href="<?php echo base_url();?>play"><span align='center'>My Sports</span></a></li>

<?php if(isset($logout))
{ ?>
<li><a href="<?php echo $logout;?>"><span align='center'>Logout</span></a></li>
<?php } else {?>
<li><a href="<?php echo base_url();?>logout"><span align='center'>Logout</span></a></li>
<?php } ?>
</ul>
</div>
</div>
</div>
</li>
<?php } else { ?>
<li><a class="lnk-menu <?php if($url_seg == 'login'){ echo "active"; } ?>" href="<?php echo base_url();?>login">Login</a></li>
<?php
}
?>

</ul>
</div><!-- /.navbar-collapse -->

<!-- header menu -->
</div>
</nav>
</header>
</section>
</div>

<div class="slide-mob">
<section class="bbtxt-content-subscription">
<div class="container">
<div class="col-xs-12 bbtxt-box">
<h4><span class="middle-txt">About Us</span></h4>
<div class="col-md-6 homevideo-top">
<p style='padding-top:30px'>
<b>Amateurs to Masters (A2M) Sports is the best sports platform for Academies, Clubs, Coaches and Players. A simple and easy tool to find other Players with similar interests and skill levels, Coaches and Clubs or Sports Centers in the area and book courts/ tables for Pay and Play. An easy way to organize Tournaments or Leagues including Team Leagues and Challenge Ladders.</b>
</p>
<p>
<b>Our world class Sports Club Platform comes with Membership Management, Tournament and League Organization, Pay and Play (reservations), Club Ratings, Player Performance Tracking, Event Management and more! We even host your website and offer branded mobile app for the clubs with all these features built-in! We do all this for nominal fee and you got to see it to believe it! </b>
</p>
<div class="tshirt-buy"><a href="<?php echo base_url();?>aboutus" class="tshirt-cart">Read More..</a></div>
</div>

<div class="col-md-6 homevideo-top" style='margin-top:30px'>
<video id="example_video_1" class="video-js vjs-default-skin vjs-paused vjs-controls-enabled vjs-user-inactive" controls preload="none" width="100%" poster="<?=base_url();?>images/video.jpg" data-setup="{}">
<source src="<?=base_url();?>images/a2m1.mp4" type="video/mp4" />
<source src="<?=base_url();?>images/a2m1.ogg" type="video/ogg" />
<source src="<?=base_url();?>images/a2m1.webm" type="video/webm" />

<track kind="captions" src="demo.captions.html" srclang="en" label="English"></track><!-- Tracks need an ending tag thanks to IE9 -->
<track kind="subtitles" src="demo.captions.html" srclang="en" label="English"></track>
<p class="vjs-no-js">To view this video please enable JavaScript, and consider upgrading to a web browser that <a href="https://videojs.com/html5-video-support/" target="_blank">supports HTML5 video</a></p>
</video>
</div>

</div>
</div>
</section>

<div id="Club"></div>
<section class="yoga-desc-bg">
<div class="clearfix">
<div class="col-md-6 cup-img" style="padding:0;">


<img src="<?php echo base_url();?>images/clubpage.jpg" alt=""/>
</div>		

<div class="col-md-6 yoga-desc2 title">
<h1>Lets get started</h1>
<p>You built a club with your hardwork. Let us help you make more money from it. We give you all the tools so you can make more money, right on your website or mobile app. Sign-up here to find out how easy it really is!</p>

<p class="tshirt-buy"><a href="<?php echo base_url();?>register" class="tshirt-cart">Sign Up</a></p>
</div>

</div>
</section> 

<div id="Create"></div>
<section class="yoga-desc-bg">
<div class="clearfix">
<div class="col-md-6 yoga-desc title">
<h1>Create Tournament</h1>
<p>If you are a club or academy, corporate entity or just an active member of community and would like to organize sports leagues or tournaments, you can do that here.</p>
<p class="tshirt-buy"><a href="<?php echo base_url();?>League" class="tshirt-cart">Start Here..</a></p>
</div>
<div class="col-md-6 cup-img" style="padding:0;">
<section class="slider">
<div id="slider" class="flexslider flexslider-attachments">
	<ul class="slides">
		<li><img src="<?php echo base_url();?>images/Tennis.jpg" alt=""/></li>
		<li><img src="<?php echo base_url();?>images/BadmintonTournament.jpg" alt=""/></li>
		<li><img src="<?php echo base_url();?>images/Table_Tennis.jpg" alt=""/></li>
		<li><img src="<?php echo base_url();?>images/Pickleball2.jpg" alt=""/></li>
	</ul>
</div>
</section>
</div>	
</div>
</section> 

<div id="Event"></div>
<section class="yoga-desc-bg">
<div class="clearfix">
<div class="col-md-6 cup-img" style="padding:0;">


<img src="<?php echo base_url();?>images/ht3_new.jpg" alt=""/>
</div>		

<div class="col-md-6 yoga-desc2 title">
<h1>Schedule an Event</h1>
<p>If you are a Coach trying to organize classes for different groups, a team captain trying to mange the team schedule or just a player trying to organize practice or a fun event, you can create those events here.</p>

<p class="tshirt-buy"><a href="<?php echo base_url();?>events/add" class="tshirt-cart">SCHEDULE</a></p>
</div>

</div>
</section> 

<!--SECTION TOP PRODUCTS-->
<section class="yoga-desc-bg2">

<div class="container">
<div class="col-xs-12 col-md-12">
<div class="leaghead"><h2>Upcoming Tournaments</h2></div>

<ul id="product" class="bxslider">
<?php if(!empty($games)) { 
$i=1;
foreach($games as $row) {

if(!empty($row)) {
?>
<li>
<div class="bxslider-bg">
<div class="jm-item second">
<div class="jm-item-wrapper">
<div class="jm-item-image">
<a href="<?php
if($row[0]->Short_Code != '' and $row[0]->Short_Code != NULL){
	echo base_url().$row[0]->Short_Code; } 
else{ 
	echo base_url().'league/'.$row[0]->tournament_ID; }
?>">
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
?>" width = '238px' height = '165px' alt="" />
</a>
</div>
</div>
</div>
<div class="product-title" style='height:64px'>
<a href="<?php
if($row[0]->Short_Code != '' and $row[0]->Short_Code != NULL){
	echo base_url().$row[0]->Short_Code; } 
else{ 
	echo base_url().'league/'.$row[0]->tournament_ID; }
?>">
<?php echo $row[0]->tournament_title; ?></a>
</div>
<p><?php echo date('M d, Y', strtotime($row[0]->StartDate)); ?></p>
<p><b>Sport:</b> <?php switch($row[0]->SportsType){

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

} ?></p>
<p><b>Location:</b> <?php echo $row[0]->TournamentCity. ',' .$row[0]->TournamentState; ?></p>
<p style='height:32px'><?php 
$str	= html_entity_decode($row[0]->TournamentDescription);
$str2	= substr($str, 0, 40);
$result	= substr($str2, 0, strrpos($str2, ' '));

//echo $result." ...";
?></p>
</div>
<div class="drop-shadow"></div>
</li>

<?php
	}
  }
}
?>
</ul>
</div>
</div>
</section>

<div id="Challenge"></div>
<section class="yoga-desc-bg">
<div class="clearfix">
<div class="col-md-6 yoga-desc title">
<h1>Challenge Players</h1>
<p>Can't wait till the next tournament? You can "Challenge" other players to play with you. We will reward you everytime you challenge someone with more points towards your A2M Score'.</p>

<p class="tshirt-buy"><a href="<?php echo base_url();?>opponent" class="tshirt-cart">Challenge</a></p>

</div>
<div class="col-md-6 cup-img" style="padding:0;">
<img src="<?php echo base_url();?>images/l1.jpg" alt=""/>
</div>		
</div>
</section> 

<div id="Search"></div>
<section class="yoga-desc-bg">
<div class="clearfix">

<div class="col-md-6 cup-img" style="padding:0;">
<img src="<?php echo base_url();?>images/ht2.jpg" alt=""/>
</div>		

<div class="col-md-6 yoga-desc2 title">
<h1>Search Stuff</h1>
<p>Search for Players, Matches and Tournaments</p>

<p class="tshirt-buy"><a href="<?php echo base_url();?>search" class="tshirt-cart">Search</a></p>
</div>

</div>
</section>    

<div id="Addscore"></div>
<section class="yoga-desc-bg">
<div class="clearfix">
<div class="col-md-6 yoga-desc title">
<h1>Add Score</h1>
<p>You played a match without actually creating or registering it, you can still add it to your profile here. </p>

<p class="tshirt-buy"><a href="<?php echo base_url();?>Addscore" class="tshirt-cart">Add Score</a></p>

</div>
<div class="col-md-6 cup-img" style="padding:0;">
<img src="<?php echo base_url();?>images/AddScore_new.jpg" alt=""/>
</div>		
</div>
</section> 

<!--SECTION LAST PHOTO-->

<!--SECTION CLIENTS-->
<!-- <section class="yoga-desc-bg2">
<div class='container'>
<div class="top-video col-xs-12 col-md-12">
<h3>OUR PARTNERS</h3>
<div id="testimonials">
<div id="owl-demo" class="owl-carousel">
<div class="item">
<ul class="sponsor first">
<li><a href='#'><img src="<?php //echo base_url();?>org_logos/glen_abby.jpg" alt="" /></a></li>
<li><a href='https://atlbadminton.com/' target='_blank'><img src="<?php //echo base_url();?>org_logos/abc_logo.jpg" alt="" /></a></li>
<li><a href='https://www.atlpba.org/' target='_blank'><img src="<?php //echo base_url();?>org_logos/atlpba.jpg" alt="" /></a></li>
<li><a href='https://www.archistabletennis.com/' target='_blank'><img src="<?php //echo base_url();?>org_logos/ATTA_Logo.jpg" alt="" /></a></li>
<li><a href='#'><img src="<?php //echo base_url();?>org_logos/Crosstown-logo.png" alt="" /></a></li>
<li><a href='#'><img src="<?php //echo base_url();?>org_logos/CBC.jpg" alt="" /></a></li>
</ul>
</div>
<div class="item">
<ul class="sponsor second">
<li><a href='https://atlbadminton.com/' target='_blank'><img src="<?php //echo base_url();?>org_logos/abc_logo.jpg" alt="" /></a></li>
<li><a href='https://www.atlpba.org/' target='_blank'><img src="<?php //echo base_url();?>org_logos/atlpba.jpg" alt="" /></a></li>
<li><a href='https://www.archistabletennis.com/' target='_blank'><img src="<?php //echo base_url();?>org_logos/ATTA_Logo.jpg" alt="" /></a></li>
<li><a href='https://www.tama.org/' target='_blank'><img src="<?php //echo base_url();?>org_logos/TAMALogo.png" alt="" /></a></li>
<li><a href='#'><img src="<?php //echo base_url();?>org_logos/Crosstown-logo.png" alt="" /></a></li>
<li><a href='#'><img src="<?php //echo base_url();?>org_logos/CBC.jpg" alt="" /></a></li>
</ul>
</div>        
</div>
</div>
</div>
</div>
</section> -->

<!--SECTION CLIENTS-->
<!-- <section class="yoga-desc-bg2">
<div class='container'>
<div class="top-video col-xs-12 col-md-12">
<h3>SPONSORS & PARTNERS</h3>
<div id="testimonials">
<div id="owl-demo" class="owl-carousel">
	<div class="item">
	<ul class="sponsor first">
	
<?php
/*$num_text = array("", "first", "second", "third", "fourth", "fifth", "sixth", "seventh", "eighth", "ninth", "tenth");

$displayed = array();
$c = 1;
$p = 2;

//echo "<pre>"; print_r($sp_list);
foreach($sp_list as $tourn_id => $sponsors){
	foreach($sponsors as $img => $url){
		if (!preg_match("~^(?:f|ht)tps?://~i", $url)) {
			$url = "https://" . $url;
		}
		else{
			$url = str_replace("http://", "https://", $url);
		}
		if($url and !in_array($url, $displayed)){
?>
	<li><a href='<?=$url;?>'><img src="<?php echo base_url();?>tour_pictures/<?=$tourn_id;?>/sponsors/<?=$img;?>" alt="" /></a></li>
<?php
			if($c == 5){ $c = 0; echo "</ul></div><div class='item'><ul class='sponsor ".$num_text[$p]."'>"; $p++;}
			$displayed[] = $url; $c++;
		}
	}
}*/
?>
</ul></div>

</div>
</div>
</div>
</div>
</section>
 -->
<section id="footer-tag">
<div class="container">
<div class="col-md-12">
<div class="col-md-8">

<div class="col-md-6">
<h3>Latest News</h3>
<ul class="footer-last-news">
<?php 
$i = 1;
foreach($results as $row){ 
if($i <= 3)
{
?>

<li>
<?php $admin_users = array(215,214);
$user_id = $this->session->userdata('users_id'); ?>

<?php if(in_array($user_id, $admin_users)){ ?>
<p style="float:right"><a href=<?php echo base_url()."news/edit/" . $row->News_id ;?>><font color="#ffffff"><u>Edit</u></font></a></p> 
<?php }?>
<a href=<?php echo base_url()."news/" . $row->News_id ;?>>

<img class="" src="<?php echo base_url(); ?>tour_pictures/<?php 
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
} ?>" width='103px' height='72px' alt="" />

<p>
<?php 
$abc = strip_tags($row->News_content);
$s = substr($abc, 0, 75);
$result = substr($s, 0, strrpos($s, '.'));
echo strip_tags($s) . "...";
?>
</p>
</a>
<br>
</li>

<?php 
}
$i++;
} ?>
</ul>
</div> <!-- col-md-4-->

<div class="col-md-6">
<ul class="footer-last-news" style="margin-top:70px">
<?php 
$i = 1;
foreach($results as $row){ 
if($i >= 4)
{
?>

<li>
<?php $admin_users = array(215,214);
$user_id = $this->session->userdata('users_id'); ?>

<?php if(in_array($user_id, $admin_users)){ ?>
<p style="float:right"><a href=<?php echo base_url()."news/edit/" . $row->News_id ;?>><font color="#ffffff"><u>Edit</u></font></a></p> 
<?php }?>
<a href=<?php echo base_url()."news/" . $row->News_id ;?>>

<img class="" src="<?php echo base_url(); ?>tour_pictures/<?php 
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
} ?>" width='103px' height='72px' alt="" />

<p><?php
$abc	= strip_tags($row->News_content);
$s		= substr($abc, 0, 75);
$result = substr($s, 0, strrpos($s, '.'));
echo strip_tags($s) . "...";
?>
</p>
</a>
<br>
</li>
<?php 
}
$i++;
} 
?>
</ul>
</div> <!-- col-md-4-->

</div>

<div class="col-md-4 footer-newsletters hidden-xs">
<h3>&nbsp;</h3>
<div id="loader"><br /><br /><br /><br /><br />
<input type="submit" name='req_demo' id='req_demo' value="Request a Demo"/>
</div>
</div>
<div class="col-xs-12"></div>
</div>
</div>
</section>
</div>

<div class="mob-view">
<div id="next-match">
<div class="container">
<div class="col-xs-12 col-md-12 top-first-info">
<div class="col-xs-6 col-md-2"><a href="<?php echo base_url();?>Play"><img src="images/mobile/MySportsImage2.jpg" alt="" /></a>
<div class="slide-news-bottom" style='text-align:center;'><a href="<?php echo base_url();?>Play">My Sports</a></div>
</div>

<div class="col-xs-6 col-md-2"><a href="<?php echo base_url();?>clubs"><img src="images/mobile/PayNPlay.jpg" alt="" /></a>
<div class="slide-news-bottom" style='text-align:center;'><a href="<?php echo base_url();?>clubs">Pay & Play</a></div>
</div>

<div class="col-xs-6 col-md-2"><a href="<?php echo base_url();?>AddScore"><img src="images/mobile/AddScore.jpg" alt="" /></a>
<div class="slide-news-bottom" style='text-align:center;'><a href="<?php echo base_url();?>Addscore">Add Score</a></div>
</div>

<!-- <div class="col-xs-6 col-md-2"><a href="<?php echo base_url();?>Search"><img src="images/mobile/SearchImage.jpg" alt="" /></a>
<div class="slide-news-bottom"><a href="<?php echo base_url();?>Search">Search</a></div>
</div> -->



<div class="col-xs-6 col-md-2"><a href="<?php echo base_url();?>Events/Add"><img src="images/mobile/CalendarModern.jpg" alt="" /></a>
<div class="slide-news-bottom" style='text-align:center;'><a href="<?php echo base_url();?>events/add">Schedule an Event</a></div>
</div>

<div class="col-xs-6 col-md-2"><a href="<?php echo base_url();?>sports"><img src="images/mobile/Clubs.jpg" alt="" /></a>
<div class="slide-news-bottom" style='text-align:center;'><a href="<?php echo base_url();?>sports">Clubs</a></div>
</div>

<div class="col-xs-6 col-md-2"><a href="<?php echo base_url();?>sports"><img src="images/mobile/Coach.jpg" alt="" /></a>
<div class="slide-news-bottom" style='text-align:center;'><a href="<?php echo base_url();?>sports">Coaches</a></div>
</div>

<div class="col-xs-6 col-md-2"><a href="<?php echo base_url();?>a2mteams"><img src="images/mobile/Teams.jpg" alt="" /></a>
<div class="slide-news-bottom" style='text-align:center;'><a href="<?php echo base_url();?>a2mteams">Teams</a></div>
</div>

<div class="col-xs-6 col-md-2">
<a href="<?php echo base_url();?>League"><img src="images/mobile/TournBracketImage.jpg" alt="" /></a>
<div class="slide-news-bottom" style='text-align:center;'><a href="<?php echo base_url();?>League">Create Tournament</a></div>
</div>

</div>

<div align="center"> 
	<button type="button" id="watchInto" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal" style="background-color: #81a32b; border-color:#ff8a00">
  Watch Intro >>
</button>

<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">

</div>
</div><!-- video end -->

<!-- <script>
var vid = document.getElementById("myVideo");
function enableAutoplay() { 
  vid.autoplay = true;
  vid.load();
}

function disableAutoplay() { 
  vid.autoplay = false;
  vid.load();
} 

function checkAutoplay() { 
  alert(vid.autoplay);
} 
</script>  -->


</div>
</div>

</div>

<footer>
<div class="content-footer">
<div class="container">

<div class="col-md-7"><p>&copy; <?=date('Y');?> a2msports.com. All rights reserved. &nbsp;&nbsp;
<a id='priv_policy' style="cursor:pointer;color:#FFF">Privacy Policy</a></p></div>

<!--<div class="col-md-5 slide-mob" style="padding-right:50px">-->
<div class="fb-like" data-href="<?=base_url();?>" data-layout="button_count" data-action="like" data-show-faces="false" data-share="true"></div>
<!--</div>-->

<!--<div class="col-md-3" style="padding-right:50px">
<a href='https://www.facebook.com/a2msports' target='_blank'><img src = "<?php echo base_url().'images/fb_round.png'; ?>" alt = 'Facebook Page' width = '25px' height='25px' align='right' /></a>
</div>-->

</div>
</div>
</footer>

<!-- <script src="<?php echo base_url();?>js/jquery-1.10.2.js" type="text/javascript"></script> -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/1.10.2/jquery.min.js" type="text/javascript"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<script src="<?php echo base_url();?>js/jquery-migrate-1.2.1.min.js" type="text/javascript"></script>
<script src="<?php echo base_url();?>js/jquery.transit.min.js" type="text/javascript"></script>

<!--MENU-->
<!-- <script src="<?php echo base_url();?>js/menu/modernizr.custom.js" type="text/javascript"></script>
<script src="<?php echo base_url();?>js/menu/cbpHorizontalMenu.js" type="text/javascript"></script> -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/modernizr/2.6.2/modernizr.min.js" type="text/javascript"></script>
<script src="<?php echo base_url();?>js/menu/cbpHorizontalMenu.js" type="text/javascript"></script>

<!--END MENU-->

<!--Mini Flexslide-->
<!-- <script src="<?php echo base_url();?>js/minislide/jquery.flexslider.js" type="text/javascript"></script> -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/flexslider/2.7.2/jquery.flexslider.min.js" type="text/javascript"></script>

<!-- Percentace circolar -->
<!-- <script src="<?php echo base_url();?>js/circle/jquery-asPieProgress.js" type="text/javascript"></script>
<script src="<?php echo base_url();?>js/circle/rainbow.min.js" type="text/javascript"></script> -->

<!--Gallery-->
<!-- <script src="<?php echo base_url();?>js/gallery/jquery.prettyPhoto.js" type="text/javascript"></script> -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/prettyPhoto/3.1.6/js/jquery.prettyPhoto.min.js" type="text/javascript"></script>
<!-- <script src="<?php echo base_url();?>js/gallery/isotope.js" type="text/javascript"></script> -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.isotope/1.5.25/jquery.isotope.min.js" type="text/javascript"></script>

<!-- Button Anchor Top-->
<script src="<?php echo base_url();?>js/jquery.ui.totop.js" type="text/javascript"></script>
<script src="<?php echo base_url();?>js/custom.js" type="text/javascript"></script>
<script src="<?php echo base_url();?>js/jquery.bxslider.js" type="text/javascript"></script>
<!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/bxslider/4.1.2/jquery.bxslider.min.js" type="text/javascript"></script> -->

<!--Carousel News-->
<!-- <script src="<?php echo base_url();?>js/jquery.easing.1.3.js" type="text/javascript"></script>
<script src="<?php echo base_url();?>js/jquery.mousewheel.js" type="text/javascript"></script> -->

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-easing/1.3/jquery.easing.min.js" type="text/javascript"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-mousewheel/3.0.4/jquery.mousewheel.min.js" type="text/javascript"></script>

<!--Carousel Clients-->
<script src="<?php echo base_url();?>js/own/owl.carousel.js" type="text/javascript"></script>
<!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/owl-carousel/1.3.3/owl.carousel.min.js" type="text/javascript"></script> -->

<!--Count down-->
<!-- <script src="<?php echo base_url();?>js/jquery.countdown.js" type="text/javascript"></script> -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.countdown/2.0.4/jquery.countdown.min.js" type="text/javascript"></script>

<script src="<?php echo base_url();?>js/custom_ini.js" type="text/javascript"></script>

<script>
// Ajax post for refresh captcha image.
$(document).ready(function() {

$("#req_demo").click(function() {
baseurl = "<?php echo base_url(); ?>";
window.location.href = baseurl+"help/demo";
});

$("#reload").click(function() {
jQuery.ajax({
type: "POST",
url: "<?php echo base_url(); ?>" + "home/captcha_refresh",
success: function(res) {
if(res)
{
jQuery("div.image").html(res);
}
}
});
});
});
</script>

<script>
 $(document).ready(function(){
	 baseurl = "<?php echo base_url(); ?>";

	/*$('.more_sports').hide();

	$('#show_more').click(function(){
		 $('#show_more').hide();
		 $('.more_sports').show();
	}); 
	 
	$('.more_sports_mob').hide();

	$('#show_more_mob').click(function(){
	  $('#show_more_mob').hide();
	  $('.more_sports_mob').show();
	});*/

$('#priv_policy').click(function(){
	$.ajax({
		type: "POST",
		async:false,
		url:baseurl+'home/priv_policy/',
		dataType: "html",
		success: function(res){
			var w = window.open('', null, "height=650, width=550, status=yes, toolbar=no, menubar=no, location=no");
			w.document.open();
			w.document.write(res);
			w.document.close();
		}
	});
});

$('#watchInto').click(function(){
	$.ajax({
		type: "POST",
		async:false,
		url:baseurl+'home/watch_intro/',
		dataType: "html",
		success: function(res){
			$('#exampleModal').html(res);
			/*var w = window.open('', null, "height=650, width=550, status=yes, toolbar=no, menubar=no, location=no");
			w.document.open();
			w.document.write(res);
			w.document.close();*/
		}
	});
});
});

</script>
<script src="<?php echo base_url();?>js/bootsnav.js"></script>
<script>
(function(d, s, id) {
var js, fjs = d.getElementsByTagName(s)[0];
if (d.getElementById(id)) return;
js = d.createElement(s); js.id = id;
js.src = "//connect.facebook.net/en_US/sdk.js#xfbml=1&version=v2.6";
fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));
</script>

</body>
</html>