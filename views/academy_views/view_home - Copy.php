<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>A2MSports - Sports Club</title>
<meta content="text/html; charset=utf-8" http-equiv="Content-Type" />

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
<link href="<?php echo base_url();?>rs-plugin/css/settings.css" rel="stylesheet" />
<link href="<?php echo base_url();?>css/prettyPhoto.css" rel="stylesheet" type="text/css" />
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

(function(d, s, id) {
var js, fjs = d.getElementsByTagName(s)[0];
if (d.getElementById(id)) return;
js = d.createElement(s); js.id = id;
js.src = "//connect.facebook.net/en_US/sdk.js#xfbml=1&version=v2.6";
fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));


</script>
</head>
<body>
<!-- <div id="fb-root"></div>
-->
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
<div class="headfixed">

<section class="container box-logo">
<header>
<div class="content-logo col-md-12">
<div class="logo"> <a href="<?php echo base_url();?>"><img src="<?php echo base_url();?>images/logo.png" alt="" /></a>
</div>

<div class="bt-menu"><a href="#" class="menu"><span>&equiv;</span> Menu</a></div>

<div class="box-menu">

<nav id="cbp-hrmenu" class="cbp-hrmenu">
<ul id="menu" class='slide-mob'>    
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
<li><a class="lnk-menu" href="#Create">Create Tournament</a></li>
<li><a class="lnk-menu" href="#Challenge">Challenge</a></li>
<li><a class="lnk-menu" href="#Search">Search</a></li>
<li><a class="lnk-menu" href="#Addscore">Add Score</a></li>
<!-- <li><a class="lnk-menu" href="<?php echo base_url();?>Events">Team Captain</a></li>-->
<li><a class="lnk-menu" href="#Event">Schedule</a></li>
<li><a class="lnk-menu" href="<?php echo base_url();?>help">Help</a></li>
<!--<li><a class="lnk-menu" href="contactus.html">Contact us</a></li>-->

<?php if($this->session->userdata('user')!="") {?>
<!-- <li><a class="lnk-menu" href="#" onclick="javascript:location.href='<?php echo base_url();?>profile'"> -->
<li><a class="lnk-menu" href="#">
<?php 
$get_fname = explode(' ', $this->session->userdata('user'));
echo $get_fname[0];
?>
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

<!-- ---------------------------------------------- -->

<ul id="menu" class='mob-view'>    
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
<li><a class="lnk-menu" href="<?php echo base_url();?>Opponent">Challenge</a></li>
<li><a class="lnk-menu" href="<?php echo base_url();?>Search">Search</a></li>
<li><a class="lnk-menu" href="<?php echo base_url();?>Addscore">Add Score</a></li>
<!-- <li><a class="lnk-menu" href="<?php echo base_url();?>Events">Team Captain</a></li>-->
<li><a class="lnk-menu" href="<?php echo base_url();?>events/add">Schedule</a></li>
<li><a class="lnk-menu" href="<?php echo base_url();?>help">Help</a></li>
<!--<li><a class="lnk-menu" href="contactus.html">Contact us</a></li>-->

<?php if($this->session->userdata('user')!="") {?>
<!-- <li><a class="lnk-menu" href="#" onclick="javascript:location.href='<?php echo base_url();?>profile'"> -->
<li><a class="lnk-menu" href="#">
<?php 
$get_fname = explode(' ', $this->session->userdata('user'));
echo $get_fname[0];
?>
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
</div>

<div class="slide-mob">
<section class="bbtxt-content-subscription">
<div class="container">
<div class="col-xs-12 bbtxt-box">
<h4><span class="middle-txt">About Us</span></h4>
<div class="col-md-6 homevideo-top">
<p style='padding-top:30px'>
Amateurs To Masters (A2M) Sports is a social platform for sports lovers, from Amateurs to Masters. It finds other players like you with similar interests, helps you keep track of your scores and manage your progress along the way. At A2M Sports, our mission is to help every player achieve their maximum potential by providing easy and convenient options to play.
</p>
<p>
We help sports academies or any business entities to organize variety of leagues or tournaments and keep the data for statistics and ranking purposes.
</p>
<div class="tshirt-buy"><a href="<?php echo base_url();?>aboutus" class="tshirt-cart">Read More..</a></div>
</div>

<div class="col-md-6 homevideo-top">
<video id="example_video_1" class="video-js vjs-default-skin vjs-paused vjs-controls-enabled vjs-user-inactive" controls preload="none" width="100%" poster="images/video.jpg" data-setup="{}" style='padding-top:30px'>
<source src="http://a2msports.com/images/a2m1.mp4" type='video/mp4' />
<source src="http://a2msports.com/images/a2m1.webm" type='video/webm' />
<source src="http://a2msports.com/images/a2m1.ogv" type='video/ogg' />
<track kind="captions" src="demo.captions.html" srclang="en" label="English"></track><!-- Tracks need an ending tag thanks to IE9 -->
<track kind="subtitles" src="demo.captions.html" srclang="en" label="English"></track>
<p class="vjs-no-js">To view this video please enable JavaScript, and consider upgrading to a web browser that <a href="http://videojs.com/html5-video-support/" target="_blank">supports HTML5 video</a></p>
</video>
</div>

</div>
</div>
</section>


<div id="Create"></div>
<section class="yoga-desc-bg">
<div class="clearfix">
<div class="col-md-6 yoga-desc title">
<h1>CREATE TOURNAMENT</h1>
<p>If you are an organization, business entity or just an active member of community and would like to organize sports leagues or tournaments, you can do that here.</p>

<p class="tshirt-buy"><a href="<?php echo base_url();?>League" class="tshirt-cart">Start Here..</a></p>


</div>
<div class="col-md-6 cup-img" style="padding:0;">
<img src="<?php echo base_url();?>images/BadmintonTournament.jpg" alt=""/>
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
<h1>Schedule An Event</h1>
<p>Whether you are a Team Captain managing the team schedule, a Coach trying to organize classes for different groups or just a player trying to organize practice or a fun event, you can do that here.</p>

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
?>

<li>
<div class="bxslider-bg">
<div class="jm-item second">
<div class="jm-item-wrapper">
<div class="jm-item-image"><img src="<?php echo base_url(); ?>tour_pictures/
<?php if($row[0]->TournamentImage!=""){ echo $row[0]->TournamentImage; }
else{
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
?>" width = '238px' height = '165px' alt="" /></div>
</div>
</div>
<div class="product-title" style='height:64px'>
<a href=<?php echo base_url()."league/view/" . $row[0]->tournament_ID; ?>>
<?php echo $row[0]->tournament_title; ?></a>
</div>
<p><?php echo date('M d, Y', strtotime($row[0]->StartDate)); ?></p>
<p><b>Sport:</b> <?php switch($row[0]->SportsType){

case 1: echo "Tennis"; break;
case 2: echo "Table Tennis"; break;
case 3: echo "Badminton"; break;
case 4: echo "Golf"; break;
case 5: echo "RacquetBall"; break;
case 6: echo "Squash"; break;

} ?></p>
<p><b>Location:</b> <?php echo $row[0]->TournamentCity. ',' .$row[0]->TournamentState; ?></p>
<p style='height:32px'><?php 
$str		= substr($row[0]->TournamentDescription, 0, 40);
$result	= substr($str, 0, strrpos($str, ' '));

echo $result." ...";
?></p>
</div>
<div class="drop-shadow"></div>
</li>

<?php } 
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
<section class="yoga-desc-bg2">
<div class='container'>
<div class="top-video col-xs-12 col-md-12">
<h3>OUR PARTNERS</h3>
<div id="testimonials">
<div id="owl-demo" class="owl-carousel">
<div class="item">
<ul class="sponsor first">
<li><img src="<?php echo base_url();?>org_logos/glen_abby.jpg" alt="" /></li>
<li><img src="<?php echo base_url();?>org_logos/abc_logo.jpg"  alt="" /></li>
<!--<li><img src="<?php echo base_url();?>org_logos/usta.png"  alt="" /></li>-->
<!--<li><img src="<?php echo base_url();?>org_logos/ustta.jpg" alt="" /></li>-->
<li><img src="<?php echo base_url();?>org_logos/ATTA_Logo.jpg" alt="" /></li>
<li><img src="<?php echo base_url();?>org_logos/TAMALogo.png"  alt="" /></li>
</ul>
</div>
<div class="item">
<ul class="sponsor second">
<!-- <li><img src="images/c1.gif" alt="" /></li> --> 
<li><img src="<?php echo base_url();?>org_logos/glen_abby.jpg" alt="" /></li>
<li><img src="<?php echo base_url();?>org_logos/abc_logo.jpg"  alt="" /></li>
<!--<li><img src="<?php echo base_url();?>org_logos/usta.png"	 alt="" /></li>-->
<!--<li><img src="<?php echo base_url();?>org_logos/ustta.jpg" alt="" /></li>-->
<li><img src="<?php echo base_url();?>org_logos/ATTA_Logo.jpg" alt="" /></li>
<li><img src="<?php echo base_url();?>org_logos/TAMALogo.png"  alt="" /></li>
</ul>
</div>        
</div>
</div>
</div>
</div>
</section>

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
case 7:
echo "default_pickleball.jpg";
break;
default:
echo "";
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
case 7:
echo "default_pickleball.jpg";
break;
default:
echo "";
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
} 
?>
</ul>
</div> <!-- col-md-4-->

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

<div class="col-md-4 footer-newsletters hidden-xs">
<h3>Request a Demo</h3>
<form method="post" action='<?php echo base_url(); ?>help/req_demo' >     
<div class="name">
<label for="name">* Name:</label><div class="clear"></div>
<input id="name" name="txt_req_name" type="text" placeholder="e.g. Mr. John Doe" required/>
</div>
<div class="email">
<label for="email">* Email:</label><div class="clear"></div>
<input id="email" name="txt_req_email" type="text" placeholder="example@domain.com" required/>
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
</div>

<div class="mob-view">
<div id="next-match">
<div class="container">
<div class="col-xs-12 col-md-12 top-first-info">
<div class="col-xs-6 col-md-2"> <a href="Play"><img src="images/mobile/MySportsImage2.jpg" alt=""/></a>
<div class="slide-news-bottom"><a href="<?php echo base_url();?>Play">My Sports</a></div>
</div>
<div class="col-xs-6 col-md-2"> <a href="League"><img src="images/mobile/TournBracketImage.jpg" alt=""/></a>
<div class="slide-news-bottom"><a href="<?php echo base_url();?>League">Create Tournament</a></div>
</div>
<div class="col-xs-6 col-md-2"> <a href="Opponent"><img src="images/mobile/ChallengeImage2.jpg" alt=""/></a>
<div class="slide-news-bottom"><a href="<?php echo base_url();?>Opponent">Challenge Players</a></div>
</div>
<div class="col-xs-6 col-md-2"> <a href="Events/Add"><img src="images/mobile/CalendarModern.jpg" alt=""/></a>
<div class="slide-news-bottom"><a href="<?php echo base_url();?>events/add">Schedule an Event</a></div>
</div>
<div class="col-xs-6 col-md-2"> <a href="AddScore"><img src="images/mobile/AddScore.jpg" alt=""/></a>
<div class="slide-news-bottom"><a href="<?php echo base_url();?>Addscore">Add Score</a></div>
</div>
<div class="col-xs-6 col-md-2"> <a href="Search"><img src="images/mobile/SearchImage.jpg" alt=""/></a>
<div class="slide-news-bottom"><a href="<?php echo base_url();?>Search">Search</a></div>
</div>
<!--<div class="col-xs-6 col-md-2"> <a href="Help"><img src="images/HelpImage.jpg" alt=""/></a>
<div class="slide-news-bottom"><a href="<?php echo base_url();?>Help">Help&nbsp;<span style="font-size:18px">(<?php echo $gen_matches + $tourn_matches;?>)</span></a><a class="i-ico" href="Opponent"><i class="fa fa-angle-double-right"></i></a></div>
</div>-->
</div>
</div>
</div>
</div>

<footer>
<div class="content-footer">
<div class="container">

<div class="col-md-7"><p>© 2016 a2msports.com. All rights reserved. </p></div>

<div class="col-md-5 slide-mob" style="padding-right:50px">
<div class="fb-like" data-href="http://www.a2msports.com/" data-layout="standard" data-action="like" data-show-faces="false" data-share="true"></div>
</div>

<!--<div class="col-md-3" style="padding-right:50px">
<a href='https://www.facebook.com/a2msports' target='_blank'><img src = "<?php echo base_url().'images/fb_round.png'; ?>" alt = 'Facebook Page' width = '25px' height='25px' align='right' /></a>
</div>-->

</div>
</div>
</footer>

<script src="<?php echo base_url();?>js/jquery-1.10.2.js" type="text/javascript"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<script src="<?php echo base_url();?>js/jquery-migrate-1.2.1.min.js" type="text/javascript"></script>
<script src="<?php echo base_url();?>js/jquery.transit.min.js" type="text/javascript"></script>

<!--MENU-->
<script src="<?php echo base_url();?>js/menu/modernizr.custom.js" type="text/javascript"></script>
<script src="<?php echo base_url();?>js/menu/cbpHorizontalMenu.js" type="text/javascript"></script>
<!--END MENU-->

<!--Mini Flexslide-->
<!-- <script src="<?php echo base_url();?>js/minislide/jquery.flexslider.js" type="text/javascript"></script> -->
<script type="text/javascript" src="<?php echo base_url();?>rs-plugin/js/jquery.themepunch.tools.min.js"></script> 
<script type="text/javascript" src="<?php echo base_url();?>rs-plugin/js/jquery.themepunch.revolution.min.js"></script> 

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