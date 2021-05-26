<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>A2MSports - Sports Club</title>
<meta content="text/html; charset=utf-8" http-equiv="Content-Type" />
<!-- <meta property="og:image" content="https://www.a2msports.com/images/logo.jpg" /> -->
<meta property='fb:app_id' content='792863394192570' />
<meta property='fb:secret' content='3af064a75201ceb1552db607d3d63fad' />
<meta property="og:title" content="<?php if(isset($tr_det)) { echo $tr_det->tournament_title; }?>" />
<meta property="og:type" content="Website" />
<!-- <meta property="og:url" content="<?php echo base_url(); ?>league/view/<?php echo $tr_det->tournament_ID; ?>" /> 
 -->
<meta property="og:image" content="<?php //echo base_url()."tour_pictures/"; ?><?php /*if($tour_details->TournamentImage!=""){ echo $tour_details->TournamentImage; }
else
if($tr_det->SportsType == 1){echo "default_tennis.jpg"; }
else if($tr_det->SportsType == 2){echo "default_table_tennis.jpg"; }
else if($tr_det->SportsType == 3){echo "default_badminton.jpg"; }
else if($tr_det->SportsType == 4){echo "default_golf.jpg"; }
else if($tr_det->SportsType == 5){echo "default_racquet_ball.jpg"; }
else if($tr_det->SportsType == 6){echo "default_squash.jpg"; }
*/
?>" />

<meta property="og:image:width" content="200" />
<meta property="og:image:height" content="200" />


<meta name="keywords" content="Tennis, club, events, football, golf, non-profit, betting assistant, football, tennis, sport, soccer, goal, sports, volleyball, basketball,	charity, club, cricket, football, hockey, magazine, non profit, rugby, soccer, sport, sports, tennis" />
<meta name="viewport" content="width=device-width, initial-scale=1.0"/>

<link href="<?php echo base_url();?>css/bootstrap.css" rel="stylesheet" type="text/css"/>
<!--<link href="css/bootstrap.min.css" rel="stylesheet" type="text/css" />-->

<link href='https://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,400,700,600,300' rel='stylesheet' type='text/css'/>
<link href='https://fonts.googleapis.com/css?family=Raleway:400,100,300,200,500,600,700,800,900' rel='stylesheet' type='text/css'/>
<link href='https://fonts.googleapis.com/css?family=Oswald:400,300,700' rel='stylesheet' type='text/css' />
<link href='https://fonts.googleapis.com/css?family=Lato:100,300,400,700,900,100italic,300italic,400italic,700italic,900italic' rel='stylesheet' type='text/css' />

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
<link rel="shortcut icon" type="image/png" href="<?php echo base_url();?>images/favicon.png" />
<link href="<?php echo base_url();?>css/responsive.css" rel="stylesheet" type="text/css" />
<link href="<?php echo base_url();?>css/animate.css" rel="stylesheet" type="text/css" />
<link href="<?php echo base_url();?>css/tabs.css" rel="stylesheet" type="text/css" />
<link href="<?php echo base_url(); ?>css/jquery.datepick.css" rel="stylesheet" type="text/css" />
<link href="<?php echo base_url();?>css/jquery.autocomplete.css" rel="stylesheet" type="text/css" />

<link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">

<link rel="stylesheet" href="<?php echo base_url();?>css/grid.css">
 
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
<!-- <script src="https://code.jquery.com/jquery-1.11.1.min.js"></script> -->
<script src="https://jqueryvalidation.org/files/dist/jquery.validate.min.js"></script>
<script src="https://jqueryvalidation.org/files/dist/additional-methods.min.js"></script>
<style type="text/css">
.waiting { cursor: wait; }
</style>

</head>

<body>
<div id="fb-root"></div>

<script>/*function fbs_click() {u=location.href;t=document.title;
window.open('https://www.facebook.com/sharer.php?u='+encodeURIComponent(u)+
'&t='+encodeURIComponent(t),'sharer','toolbar=0,status=0,width=626,height=436');
return false;}*/</script>

<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/en_US/sdk.js#xfbml=1&version=v2.6";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));
</script>

<!--<section class="content-top-login">
<div class="container">
<div class="col-md-12">
<div class="box-support"> 
<p class="txt-torn"><a href='<?php echo base_url();?>league'>Create Tournament</a></p>
</div>
<div class="box-login"> 
<a href='<?php echo base_url();?>login'>Login</a>
<a href='<?php echo base_url();?>Register'>New User</a>
</div>

</div>
</div>
</section>  -->

<section class="container box-logo">
<header>
<div class="content-logo col-md-12">
<div class="logo"> 
<a href="<?php echo base_url();?>"><img src="<?php echo base_url();?>images/logo.png" alt="" /></a>
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
<li><a class="lnk-menu <?php if($url_seg == 'Play'){ echo "active"; } ?>" href="<?php echo base_url();?>Play">Play</a></li>
<?php
}
?>
<li><a class="lnk-menu <?php if($url_seg == 'calendar'){ echo "active"; } ?>" href="<?php echo base_url();?>calendar">Calendar</a></li>
<li><a class="lnk-menu <?php if($url_seg == 'League'){ echo "active"; } ?>" href="<?php echo base_url();?>League">Create Tournament</a></li>
<li><a class="lnk-menu <?php if($url_seg == 'Opponent'){ echo "active"; } ?>" href='<?php echo base_url();?>Opponent'>Challenge</a></li>
<li><a class="lnk-menu <?php if($url_seg == 'Search'){ echo "active"; } ?>" href="<?php echo base_url();?>Search"> Search</a></li>
<li><a class="lnk-menu <?php if($url_seg == 'Addscore'){ echo "active"; } ?>" href="<?php echo base_url();?>Addscore">Add Score</a></li>
 <li><a class="lnk-menu <?php if($url_seg == 'Events'){ echo "active"; } ?>" href="<?php echo base_url();?>events/add">Schedule</a></li>
<li><a class="lnk-menu <?php if($url_seg == 'Help'){ echo "active"; } ?>" href="<?php echo base_url();?>Help">Help</a></li>
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

<?php 
$child = $this->session->userdata('child_user_id');
if(!$child) { ?>
<li><a href="<?php echo base_url();?>profile/add_profile"><span align='center'>Add Player</span></a></li> 
<?php } ?>

<li><a href="<?php echo base_url();?>profile"><span align='center'>My Profile</span></a></li>
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
<?php } 
else
{
?>
<li><a class="lnk-menu <?php if($url_seg == 'login'){ echo "active"; } ?>" href="<?php echo base_url();?>login">Login</a></li>
<?php
}
?>

</ul>
</nav>
</div>
</div>
</header>
</section>
<?php 
/*
header("cache-Control: no-store, no-cache, must-revalidate");
header("cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");
header("Expires: Sat, 26 Jul 1997 05:00:00 GMT");
*/
?>
<section class="drawer">
<div class="col-md-12 hidden-xs size-img back-img-match">
<div class="effect-cover">
<h3 class="txt-advert animated">Amateurs 2 Masters</h3>
<p class="txt-advert-sub"> Flexible to Play and Easy to Organize</p>
</div>
</div>