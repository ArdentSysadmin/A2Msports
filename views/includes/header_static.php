<html>
<head>
<title>A2MSports - Sports Club</title>
<meta content="text/html; charset=utf-8" http-equiv="Content-Type" />

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
<link href="<?php echo base_url();?>css/jquery.datepick.css" rel="stylesheet" type="text/css" />
<link href="<?php echo base_url();?>css/jquery.autocomplete.css" rel="stylesheet" type="text/css" />
<link href="<?php echo base_url();?>css/bootsnav.css" rel="stylesheet">

<link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css" />
<!-- <link rel="stylesheet" href="<?php echo base_url();?>css/grid.css"> -->
 
<!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script> -->
<script src="https://code.jquery.com/jquery-1.11.1.min.js"></script>
<script src="https://jqueryvalidation.org/files/dist/jquery.validate.min.js"></script>
<script src="https://jqueryvalidation.org/files/dist/additional-methods.min.js"></script>
<!-- Global site tag (gtag.js) - Google Analytics -->

<style type="text/css">
.waiting { cursor: wait; }
</style>
<style>
.li_disabled {
    pointer-events:none;	/* This makes it not clickable */
    opacity:0.6;				/* This grays it out to look disabled */
}
</style>
<script src="<?php echo base_url();?>js/bootsnav.js"></script>
</head>

<body>
<div id="fb-root"></div>

<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/en_US/sdk.js#xfbml=1&version=v2.6";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));
</script>


<section class="container box-logo">
<header>
<nav class="navbar navbar-default bootsnav">
<div class="content-logo col-md-12">
<div class="logo"> 
<a href="<?php echo base_url();?>"><img src="<?php echo base_url();?>images/logo.png" alt="" /></a>
</div>

       
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
						  <li><a href="<?php echo base_url();?>league"><span align='center'>Tournament</span></a></li>
                        </ul>
                    </li>  
<?php
//if($this->session->userdata('user')!="") {?>
<!-- <li><a class="lnk-menu <?php //if($url_seg == 'Play'){ echo "active"; } ?>" href="<?php //echo base_url();?>Play">My Sports</a></li>
 --><?php //} else { ?>
<!-- 
<li><a class="lnk-menu <?php //if($url_seg == 'Play'){ echo "active"; } ?>" href="<?php //echo base_url();?>Play">Play</a></li> 
-->
<?php
//}
?>
<li><a class="lnk-menu <?php if($url_seg == 'calendar'){ echo "active"; } ?>" href="<?php echo base_url();?>calendar">Calendar</a></li>
<li class="dropdown"><a href="#" class="dropdown-toggle" data-toggle="dropdown">Sports</a>
<ul class="dropdown-menu">
<?php
$menu_arr = $this->session->userdata('menu_items');

foreach($menu_arr as $i => $menu_item) { ?>
	    <?php  if($menu_item['Order'] < 5) { ?>
		<li><a href="<?php echo base_url().$menu_item['ShortCode'];?>"><span align='center'><?php echo $menu_item['Sport'];?></span></a></li>
		<?php } else { 
		$rest_menu .= "<li class='more_sports'><a href='".base_url().$menu_item['ShortCode']."'><span align='center'>{$menu_item['Sport']}</span></a></li>";
		}
		?>
<?php
}
?>
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
		  <li><a href="<?php echo base_url();?>opponent"><span align='center'>Challenge Player</span></a></li>
		  <li><a href="<?php echo base_url();?>clubs"><span align='center'>Pay and Play</span></a></li>          
		</ul>
	</li>
<!-- <li><a class="lnk-menu <?php if($url_seg == 'Events'){ echo "active"; } ?>" href="<?php echo base_url();?>events/add">Schedule</a></li>
 --><li><a class="lnk-menu <?php if($url_seg == 'Help'){ echo "active"; } ?>" href="<?php echo base_url();?>Help">Help</a></li>

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




</div>
</nav>
</header>
</section>

<?php 
/*
header("cache-Control: no-store, no-cache, must-revalidate");
header("cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");
header("Expires: Sat, 26 Jul 1997 05:00:00 GMT");
*/

switch($this->uri->segment(1)){

case 'tt': 
case 'tabletennis': 
case 'table tennis': 
case 'pingpong':
	$bck_img_class = 'back-img-tt';
	break;
case 'tennis':
	$bck_img_class = 'back-img-match';
	break;
case 'badminton':
	$bck_img_class = 'back-img-badminton';
	break;
case 'golf':
	$bck_img_class = 'back-img-match';
	break;
case 'racquetball':
	$bck_img_class = 'back-img-rqball';
	break;
case 'racquet':
	$bck_img_class = 'back-img-rqball';
	break;
case 'squash':
	$bck_img_class = 'back-img-squash';
	break;
case 'pickleball':
	$bck_img_class = 'back-img-pickleball';
	break;
case 'chess':
	$bck_img_class = 'back-img-match';
	break;
case 'carroms':
	$bck_img_class = 'back-img-match';
	break;
case 'default':
	$bck_img_class = 'back-img-match';
	break;
}
?>
<section class="drawer">
<div class="col-md-12 hidden-xs size-img <?=$bck_img_class;?>">
	<div class="effect-cover" style='background:#744af4'>
	<h3 class="txt-advert animated">Amateurs 2 Masters</h3>
	<p class="txt-advert-sub"><?=BANNER_TEXT;?></p>
	</div>
</div>