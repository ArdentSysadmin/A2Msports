<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
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
<link href="<?php echo base_url(); ?>css/jquery.datepick.css" rel="stylesheet" type="text/css" />
<link href="<?php echo base_url();?>css/jquery.autocomplete.css" rel="stylesheet" type="text/css" />
<link href="<?php echo base_url();?>css/bootsnav.css" rel="stylesheet">

<link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">

<link rel="stylesheet" href="<?php echo base_url();?>css/grid.css">

<script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
<!-- <script src="http://code.jquery.com/jquery-1.11.1.min.js"></script> -->
<script src="http://jqueryvalidation.org/files/dist/jquery.validate.min.js"></script>
<script src="http://jqueryvalidation.org/files/dist/additional-methods.min.js"></script>

<link href='<?php echo base_url(); ?>assets/css/fullcalendar.css' rel='stylesheet' />
<link href='<?php echo base_url(); ?>assets/css/fullcalendar.print.css' rel='stylesheet' media='print' />
<script src='<?php echo base_url(); ?>assets/js/moment.min.js'></script>
<!-- <script src='<?php echo base_url(); ?>assets/js/jquery.min.js'></script>
--><script src='<?php echo base_url(); ?>assets/js/jquery-ui.min.js'></script>
<script src='<?php echo base_url(); ?>assets/js/fullcalendar.min.js'></script>
<script src="<?php echo base_url();?>js/bootsnav.js"></script>

<style>
/*body{
margin-top: 40px;
text-align: center;
font-size: 14px;
font-family: "Lucida Grande",Helvetica,Arial,Verdana,sans-serif;
}*/

#wrap {
width: 850px;
margin: 10px 30px 0 0;
}

#external-events {
float: left;
width: 50px;
padding: 0 10px;
border: 1px solid #f59123; 
background: #f59123;
text-align: left;
}

#external-events h4 {
font-size: 16px;
margin-top: 0;
padding-top: 1em;
}

#external-events .fc-event {
margin: 10px 0;
cursor: pointer;
}

#external-events p {
margin: 1.5em 0;
font-size: 11px;
color: #111;
}

#external-events p input {
margin: 0;
vertical-align: middle;
}

/*#calendar { 
float: right;
width: 900px;
}*/

#calendar{
float: left;
/*margin: 40px 20px 0 0;*/
margin: 100px 20px 0 0;
width: 850px;
}

@media only screen and (max-width: 762px) {
#calendar{
float: none;
margin: 40px 20px 0 0;
width: auto;
}
}

</style>

<script>

$(document).ready(function(){

var baseurl = "<?php echo base_url(); ?>";
var zone = "05:30";  //Change this to your timezone

$.ajax({
url: baseurl+'calendar/process',
type: 'POST', // Send post data
data: 'type=fetch',
async: false,
success: function(s){
console.log(s)
json_events = s;
}
});


var currentMousePos = {
x: -1,
y: -1
};
jQuery(document).on("mousemove", function (event) {
currentMousePos.x = event.pageX;
currentMousePos.y = event.pageY;
});

/* initialize the external events
-----------------------------------------------------------------*/

$('#external-events .fc-event').each(function(){

// store data so the calendar knows to render an event upon drop
$(this).data('event', {
title: $.trim($(this).text()), // use the element's text as the event title
stick: true // maintain when user navigates (see docs on the renderEvent method)
});

// make the event draggable using jQuery UI
$(this).draggable({
zIndex: 999,
revert: true,      // will cause the event to go back to its
revertDuration: 0  //  original position after the drag
});

});


/* initialize the calendar
-----------------------------------------------------------------*/

$('#calendar').fullCalendar({
events: JSON.parse(json_events),
//events: [{"id":"14","title":"New Event","start":"2015-01-24T16:00:00+04:00","allDay":false}],
utc: true,
header: {
left: 'prev,next today',
center: 'title',
right: 'month,agendaWeek,agendaDay'
},
editable: true,
droppable: true, 
slotDuration: '00:30:00',
eventReceive: function(event){
var title = event.title;
var start = event.start.format("YYYY-MM-DD");
$.ajax({
//url: 'process.php',
url: baseurl+'calendar/process',
data: 'type=new&title='+title+'&startdate='+start+'&zone='+zone,
type: 'POST',
dataType: 'json',
success: function(response){
event.id = response.eventid;
$('#calendar').fullCalendar('updateEvent',event);
},
error: function(e){
console.log(e.responseText);

}
});
$('#calendar').fullCalendar('updateEvent',event);
console.log(event);
},


eventClick: function(event, jsEvent, view){
if (event.type == "tournament"){
window.location.href = baseurl+"league/"+event.id;
}
else
{
window.location.href = baseurl+"events/view/"+event.id;
}
}

});

function getFreshEvents(){
$.ajax({
//url: 'process.php',
url: baseurl+'calendar/process',
type: 'POST', // Send post data
data: 'type=fetch',
async: false,
success: function(s){
freshevents = s;
}
});
$('#calendar').fullCalendar('addEventSource', JSON.parse(freshevents));
}


function isElemOverDiv() {
var trashEl = jQuery('#trash');

var ofs = trashEl.offset();

var x1 = ofs.left;
var x2 = ofs.left + trashEl.outerWidth(true);
var y1 = ofs.top;
var y2 = ofs.top + trashEl.outerHeight(true);

if (currentMousePos.x >= x1 && currentMousePos.x <= x2 &&
currentMousePos.y >= y1 && currentMousePos.y <= y2) {
return true;
}
return false;
}

});
</script>
<style>
.li_disabled {
    pointer-events:none; //This makes it not clickable
    opacity:0.6;         //This grays it out to look disabled
}
</style>
</head>

<body>
<div id="fb-root"></div>

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
						  <li><a href="<?php echo base_url();?>league"><span align='center'>Tournament</span></a></li> 
                        </ul>
                    </li>  
<?php
if($this->session->userdata('user')!="") {?>
<li><a class="lnk-menu <?php if($url_seg == 'Play'){ echo "active"; } ?>" href="<?php echo base_url();?>Play">My Sports</a></li>
<?php } else { ?>
<li><a class="lnk-menu <?php if($url_seg == 'Play'){ echo "active"; } ?>" href="<?php echo base_url();?>Play">Play</a></li>
<?php
}
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
<li><a class="lnk-menu <?php if($url_seg == 'Addscore'){ echo "active"; } ?>" href="<?php echo base_url();?>Addscore">Add Score</a></li>
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

<section class="drawer">
<div class="col-md-12 size-img back-img-match">
<div class="effect-cover">
<h3 class="txt-advert animated">Amateurs 2 Masters</h3>
<p class="txt-advert-sub"><?=BANNER_TEXT;?></p>
</div>
</div>
<section id="login" class="container secondary-page">
<!-- Google AdSense -->
<!-- <div id='google' align='left'>
<script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
<ins class="adsbygoogle"
     style="display:block"
     data-ad-client="ca-pub-9772177305981687"
     data-ad-slot="1273487212"
     data-ad-format="auto"></ins>
<script>
(adsbygoogle = window.adsbygoogle || []).push({});
</script>
</div> -->
<!-- Google AdSense -->
<div id=''>
<div id='calendar'></div>
</div>
<!-- ---------------right column --------------------------------------- -->

<!--Right Column-->
<!--Right Column-->
<div class="col-md-3 right-column">
<div class="top-score-title col-md-12 right-title hidden-xs">
<h3> <a href="<?php echo base_url();?>news">Latest News</a>

<?php 
//$admin_users= array(214,215);
$admin = $this->session->userdata('admin');
//$user_id = $this->session->userdata('users_id');?>
<?php if($admin){ ?>
-  <a href="<?php echo base_url();?>news/add">ADD</a>
<?php }?>
</h3>

<?php foreach($results as $row ){ ?>
<div class="right-content">
<p class="news-title-right">
<a href=<?php echo base_url() ."news/" . $row->News_id ;?>>
<?php 
$s = substr($row->News_title, 0, 25);
$res = substr($s, 0, strrpos($s, ' '));
echo $s;
?>
</a></p>
<p class="txt-right">
<?php
$abc = strip_tags($row->News_content);
$result = substr($abc, 0, strrpos($abc, '.'));
echo strip_tags($row->News_content) . "...";
?>
</p>

<a href=<?php echo base_url() ."news/" . $row->News_id ;?> class="ca-more"><i class="fa fa-angle-double-right"></i>More...</a>

<?php 
$user_id = $this->session->userdata('admin');?>
<?php if($admin){ ?>
<p style="float:right"><a href=<?php echo base_url()."news/edit/" . $row->News_id ;?>><u>Edit</u></a>&nbsp;&nbsp;</p>

<?php }?>
</div>
<?php } ?>
</div>
<div class="top-score-title col-md-12 hidden-xs">
<?php if($row->Sports_image!= ""){echo $row->Sports_image ;}else { ?>
<img src="<?php echo base_url();?>images/banner2.jpg" alt="" /> <?php } ?>
</div>
<div class="top-score-title col-md-12 right-title">
<h3>Photos</h3> 
<ul class="right-last-photo">
<?php
$get_tour_images = $this->general->get_tour_images();
$a = 1;
foreach($get_tour_images as $i => $get_info)
{
$get_image		= $this->general->get_images($get_info->mt);
$get_tour_sport = $this->general->get_images($get_info->mt);
$tour_id		= $get_image['Tournament_id'];

if($a <= 9){
?>
<li>
<div class="jm-item second">
<div class="jm-item-wrapper">
<div class="jm-item-image">
<?php 
$image_pic = base_url()."tour_pictures/".$tour_id."/thumbs/".$get_image['Image_file'];
$image_loc = $_SERVER['CONTEXT_DOCUMENT_ROOT']."tour_pictures/".$tour_id."/thumbs/".$get_image['Image_file'];
if(file_exists($image_loc)){
?>
<a href="<?php echo base_url()."league/".$tour_id; ?>">
<img src="<?php echo $image_pic; ?>" width = "83px" height = "62.25px" alt="" />
</a>
<?php } else { 
$get_tour_sport = $this->general->get_tour_sport($tour_id);
$tour_pic = $_SERVER['CONTEXT_DOCUMENT_ROOT']."tour_pictures/".$get_tour_sport['TournamentImage'];
if(file_exists($tour_pic) and $get_tour_sport['TournamentImage'] != ""){
?>
<a href="<?php echo base_url()."league/".$tour_id; ?>">
<img src="<?php echo $tour_pic; ?>" width = "83px" height = "62.25px" alt="" />
</a>
<?php
}
else
{
switch($get_tour_sport['SportsType']) {
case 1:
$tour_def_pic = "default_tennis.jpg";
break;
case 2:
$tour_def_pic = "default_table_tennis.jpg";
break;
case 3:
$tour_def_pic = "default_badminton.jpg";
break;
case 4:
$tour_def_pic = "default_golf.jpg";
break;
case 5:
$tour_def_pic = "default_racquet_ball.jpg";
break;
case 6:
$tour_def_pic = "default_squash.jpg";
break;
case 7:
$tour_def_pic = "default_pickleball.jpg";
break;
case 8:
$tour_def_pic = "default_chess.jpg";
break;
case 9:
$tour_def_pic = "default_carroms.jpg";
break;
case 10:
$tour_def_pic = "default_volleyball.jpg";
break;
case 11:
$tour_def_pic = "default_fencing.jpg";
break;
case 12:
$tour_def_pic = "default_bowling.jpg";
break;
default:
$tour_def_pic = "logo_fb.jpg";
}

?>
<a href="<?php echo base_url()."league/".$tour_id; ?>">
<img src="<?php echo base_url()."tour_pictures/".$tour_def_pic; ?>" width = "83px" height = "62.25px" alt="" />
</a>
<?php
}
} ?>
</div>	
</div>
</div>
</li>
<?php
}
$a++;
}
?>
</ul>
</div>
</div>

<!-- end of right column  -->
</section>

<!-- ------------------------------- -->

<!--FOOTER-->   
<section id="footer-tag">
<div class="container">
<div class="col-md-12">
<div class="col-md-4 hidden-xs">
<h3>About Us</h3>
<p>A2M Sports is a social platform for sports lovers, from Amateurs to Masters. It finds other players like you with similar interests, helps you keep track of your scores and manage your progress along the way. At A2M Sports, our mission is to help every player achieve their maximum potential by providing easy and convenient options to play.</p>

<p>We help sports academies or any business entities to organize variety of leagues or tournaments and keep the data for statistics and ranking purposes.</p>


<p style="float:right"><a href="<?php echo base_url();?>aboutus"><font color="#ffffff"><u>Read More</u></font></a></p>

</div>
<!--               <div class="col-md-3 cat-footer">

<h3 class='last-cat'>Categories</h3>
<ul class="last-tips">
<li><a href="index.html">Home</a></li>
<li><a href="create-league.html">Sports</a></li>
<li><a href="member-list.html">Members</a></li>
<li><a href="calendar.html">Calendar</a></li>
<li><a href="help.html">Help</a></li>
<li><a href="contactus.html">Contact us</a></li>
</ul>
</div>
-->              <div class="col-md-4 hidden-xs">
<h3>Latest News</h3>

<?php foreach($results as $row ){ ?>

<ul class="footer-last-news">
<li>
<?php 
$admin = $this->session->userdata('admin');
if($admin){ ?>
<p style="float:right"><a href=<?php echo base_url()."News/edit/" . $row->News_id ;?>><font color="#ffffff"><u>Edit</u></font></a></p> 
<?php }?>
<a href=<?php echo base_url()."News/get_news_detail/" . $row->News_id ;?>>

<img class="" src="<?php echo base_url(); ?>tour_pictures/<?php 
if($row->SportsType_id == 1){echo "default_tennis.jpg"; }
else if($row->SportsType_id == 2){echo "default_table_tennis.jpg"; }
else if($row->SportsType_id == 3){echo "default_badminton.jpg"; }
else if($row->SportsType_id == 4){echo "default_golf.jpg"; }
else if($row->SportsType_id == 5){echo "default_racquet_ball.jpg"; }
else if($row->SportsType_id == 6){echo "default_squash.jpg"; }
else if($row->SportsType_id == 7){echo "default_pickleball.jpg"; }
else if($row->SportsType_id == 8){echo "default_chess.jpg"; }
else if($row->SportsType_id == 9){echo "default_carroms.jpg"; }
else if($row->SportsType_id == 10){echo "default_volleyball.jpg"; }
else if($row->SportsType_id == 11){echo "default_fencing.jpg"; }
else if($row->SportsType_id == 12){echo "default_bowling.jpg"; }
else if($row->SportsType_id == -1){echo "logo_fb.jpg"; }
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
<form method="post" name="news_letter">     
<div class="name">
<label for="name">* Name:</label><div class="clear"></div>
<input id="name" name="user_letter" type="text" placeholder="e.g. Mr. John Doe" />
</div>
<div class="email">
<label for="email">* Email:</label><div class="clear"></div>
<input id="email" name="letter_email" type="text" placeholder="example@domain.com" />
</div>
<div id="loader">
<input type="submit" value="Submit" name="news_submit"/>
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

<div class="col-md-7"><p>&copy; <?=date('Y');?> a2msports.com. All rights reserved.  &nbsp;&nbsp;<a id='priv_policy' style="cursor:pointer;color:#FFF">Privacy Policy</a></p></div>
<!-- <div class="col-md-5"> -->
<div class="fb-like col-md-5" data-href="https://www.a2msports.com/" data-layout="button_count" data-action="like" data-show-faces="false" data-share="true"></div>

<!--<div class="col-md-3" style="padding-right:50px">
<a href='https://www.facebook.com/a2msports' target='_blank'><img src = "<?php echo base_url().'images/fb_round.png'; ?>" alt = 'Facebook Page' width = '25px' height='25px' align='right' /></a>
</div>-->
</div>
</div>
</footer>

</section>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<script src="<?php echo base_url();?>js/custom.js" type="text/javascript"></script>
<script src="<?php echo base_url();?>js/custom_ini.js" type="text/javascript"></script> 
<!--MENU-->
<script src="<?php echo base_url();?>js/menu/modernizr.custom.js" type="text/javascript"></script>
<script src="<?php echo base_url();?>js/menu/cbpHorizontalMenu.js" type="text/javascript"></script>
<script>
$(document).ready(function(){
$('#priv_policy').click(function(){
var baseurl = "<?php echo base_url(); ?>";
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
});
</script>
<script>
 $(document).ready(function(){
 $('.more_sports').hide();

	 $('#show_more').click(function(){
		 $('#show_more').hide();
		 $('.more_sports').show();
	 }); 
	 
 $('.more_sports_mob').hide();

	$('#show_more_mob').click(function(){
	 $('#show_more_mob').hide();
	 $('.more_sports_mob').show();
	});
 });
</script>
<!--END MENU-->
</body>
</html>
<?php //exit; ?>