<html>
<head>
<title>A2MSports - Sports Club</title>
<meta content="text/html; charset=utf-8" http-equiv="Content-Type" />
<?php
if($this->is_league_page OR $noIndex){
?>
<meta name="ROBOTS" content="NOINDEX, NOFOLLOW" />
<?php
}
?>
<meta property='fb:app_id' content='201602263551845' />
<?php
if(isset($tr_det)) {
?>
<meta property="og:title" content="<?php if(isset($tr_det)) { echo $tr_det->tournament_title; }?>" />
<meta property="og:type" content="Website" />
<meta property="og:url" content="<?php echo base_url(); ?>league/<?php echo $tr_det->tournament_ID; ?>" />
<meta property="og:description" content="<?php if($tr_det->TournamentDescription != "") { echo strip_tags($tr_det->TournamentDescription); } ?>"> 
<meta property="og:image" content="<?php echo base_url()."tour_pictures/"; ?>
<?php
if($tr_det->TournamentImage!=""){echo $tr_det->TournamentImage;}
else if($tr_det->SportsType == 1){echo "default_tennis.jpg";}
else if($tr_det->SportsType == 2){echo "default_table_tennis.jpg";}
else if($tr_det->SportsType == 3){echo "default_badminton.jpg";}
else if($tr_det->SportsType == 4){echo "default_golf.jpg";}
else if($tr_det->SportsType == 5){echo "default_racquet_ball.jpg";}
else if($tr_det->SportsType == 6){echo "default_squash.jpg";}
?>" />

<?php
}
else if(isset($ev_det)) {
?>
<meta property="og:title" content="<?php if(isset($ev_det)) { echo $ev_det['Ev_Title']; }?>" />
<meta property="og:type" content="Website" />
<meta property="og:url" content="<?php echo base_url(); ?>events/<?php echo $ev_det['Ev_ID']; ?>" />
<meta property="og:description" content="<?php if($ev_det['Ev_Desc'] != "") { echo strip_tags($ev_det['Ev_Desc']); } ?>"> 
<meta property="og:image" content="<?php echo base_url()."events_pictures/"; ?>
<?php
if($ev_det['EventImage'] != ""){echo $ev_det['EventImage'];}
else if($ev_det['Ev_Sport'] == 1){echo "default_tennis.jpg";}
else if($ev_det['Ev_Sport'] == 2){echo "default_table_tennis.jpg";}
else if($ev_det['Ev_Sport'] == 3){echo "default_badminton.jpg";}
else if($ev_det['Ev_Sport'] == 4){echo "default_golf.jpg";}
else if($ev_det['Ev_Sport'] == 5){echo "default_racquet_ball.jpg";}
else if($ev_det['Ev_Sport'] == 6){echo "default_squash.jpg";}
else if($ev_det['Ev_Sport'] == 7){echo "default_pickleball.jpg";}
else if($ev_det['Ev_Sport'] == 8){echo "default_chess.jpg";}
else if($ev_det['Ev_Sport'] == 9){echo "default_carroms.jpg";}
else if($ev_det['Ev_Sport'] == 10){echo "default_volleyball.jpg";}
?>" />
<?php
}
?>
<?php $isMobile = 0; ?>
<meta property="og:image:width" content="200" />
<meta property="og:image:height" content="200" />

<meta name="keywords" content="Tennis, club, events, football, golf, non-profit, betting assistant, football, tennis, sport, soccer, goal, sports, volleyball, basketball,	charity, club, cricket, football, hockey, magazine, non profit, rugby, soccer, sport, sports, tennis" />
<meta name="viewport" content="width=device-width, initial-scale=1.0"/>

<link href="<?php echo base_url();?>css/bootstrap.css" rel="stylesheet" type="text/css"/>
<!--<link href="css/bootstrap.min.css" rel="stylesheet" type="text/css" />-->

<link href='https://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,400,700,600,300' rel='stylesheet' type='text/css' />
<link href='https://fonts.googleapis.com/css?family=Raleway:400,100,300,200,500,600,700,800,900' rel='stylesheet' type='text/css' />
<link href='https://fonts.googleapis.com/css?family=Oswald:400,300,700' rel='stylesheet' type='text/css' />
<link href='https://fonts.googleapis.com/css?family=Lato:100,300,400,700,900,100italic,300italic,400italic,700italic,900italic' rel='stylesheet' type='text/css' />

<link href="<?php echo base_url();?>css/fonts/font-awesome-4.1.0/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
<!--Clients-->
<!-- <link href="<?php echo base_url();?>css/own/owl.carousel.css" rel="stylesheet" type="text/css" />
<link href="<?php echo base_url();?>css/own/owl.theme.css" rel="stylesheet" type="text/css" /> -->
 <link href="https://cdnjs.cloudflare.com/ajax/libs/owl-carousel/1.3.3/owl.carousel.min.css" rel="stylesheet" type="text/css" />
<link href="https://cdnjs.cloudflare.com/ajax/libs/owl-carousel/1.3.3/owl.theme.min.css"	rel="stylesheet" type="text/css" />
<link href="<?php echo base_url();?>css/jquery.bxslider.css" rel="stylesheet" type="text/css" />
<link href="<?php echo base_url();?>css/jquery.jscrollpane.css" rel="stylesheet" type="text/css" />

<!-- <link href="<?php echo base_url();?>css/minislide/flexslider.css" rel="stylesheet" type="text/css" /> -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/flexslider/2.7.2/flexslider.min.css"	rel="stylesheet" type="text/css" />

<link href="<?php echo base_url();?>css/component.css" rel="stylesheet" type="text/css" />
<!-- <link href="<?php echo base_url();?>css/prettyPhoto.css" rel="stylesheet" type="text/css" /> -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/prettyPhoto/3.1.6/css/prettyPhoto.min.css" rel="stylesheet" type="text/css" />

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
<!-- <script async src="https://www.googletagmanager.com/gtag/js?id=UA-114329843-1"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'UA-114329843-1');
</script> -->
<script>

var isMobile = false; //initiate as false
// device detection
if(/(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|ipad|iris|kindle|Android|Silk|lge |maemo|midp|mmp|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows (ce|phone)|xda|xiino/i.test(navigator.userAgent) 
    || /1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i.test(navigator.userAgent.substr(0,4))) { 
    isMobile = true;
}
//alert(isMobile);

/*
if(isMobile){
var pathname = window.location.pathname; // Returns path only (/path/example.html)
var url      = window.location.href;						// Returns full URL (https://example.com/path/example.html)
var origin   = window.location.origin;				// Returns base URL (https://example.com)

    var path = window.location.pathname.split("/");
	if(path[1] == 'league'){
	alert("a2msports:/"+ path[1]+"/"+path[2] );
    window.location.href = "a2msports:/"+ path[1]+"/"+path[2] ;

	setTimeout(function(){ window.location.href = window.location.origin+path }, 2000);
	}
} */

if(isMobile){
"<?php $isMobile = 1; ?>"
}
</script>

<style type="text/css">
.waiting { cursor: wait; }
</style>
<style>
.li_disabled {
    pointer-events:none; //This makes it not clickable
    opacity:0.6;         //This grays it out to look disabled
}
</style>
<script src="<?php echo base_url();?>js/bootsnav.js"></script>

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
  fbq('init', '636569003561353');
  fbq('track', 'PageView');
</script>
<noscript><img height="1" width="1" style="display:none"
  src="https://www.facebook.com/tr?id=636569003561353&ev=PageView&noscript=1"
/></noscript>
<!-- End Facebook Pixel Code -->

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

<div class="headfixed">
<section class="container box-logo">
<header>
<nav class="navbar navbar-default bootsnav">
<div class="content-logo col-md-12">
<div class="logo"> 
<a href="<?php echo base_url();?>"><img src="<?php echo base_url();?>images/logo.png" alt="" /></a>
</div>
<?php
$data['isMobile'] = $isMobile;
  ?>     
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
 
 <li><a class="lnk-menu <?php if($url_seg == 'calendar'){ echo "active"; } ?>" href="<?php //echo base_url();?>?p=tournaments">Tournaments</a></li>
<li><a class="lnk-menu <?php if($url_seg == 'calendar'){ echo "active"; } ?>" href="<?php //echo base_url();?>?p=rankings">Players</a></li>
<li><a class="lnk-menu <?php if($url_seg == 'calendar'){ echo "active"; } ?>" href="<?php //echo base_url();?>?p=teams">Teams</a></li>
<li><a class="lnk-menu <?php if($url_seg == 'calendar'){ echo "active"; } ?>" href="<?php //echo base_url();?>?p=clubs">Clubs</a></li>
<li><a class="lnk-menu <?php if($url_seg == 'calendar'){ echo "active"; } ?>" href="<?php //echo base_url();?>?p=coaches">Coaches</a></li>


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
</div>

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
<div class="col-md-12 hidden-xs size-img <?=$bck_img_class;?>" style="margin-top: 90px;">
	<div class="effect-cover">
	<h3 class="txt-advert animated">Amateurs 2 Masters</h3>
	<p class="txt-advert-sub"><?=BANNER_TEXT;?></p>
	</div>
</div>