<!--Load Script and Stylesheet -->
<script type="text/javascript" src="<?php echo base_url();?>js/jquery.simple-dtpicker.js"></script>
<link type="text/css" href="<?php echo base_url();?>css/jquery.simple-dtpicker.css" rel="stylesheet" />

<script src="<?php echo base_url();?>js/jquery.accordion.js" type="text/javascript"></script>

<script>
$(document).ready(function () {
$("img.scale_image").simpleLightBox();
});
</script>
<style>
body { position: relative; }

#close-lightbox {
position: fixed;
top: 20px;
right: 20px;
font-size: 40px;
color: #FFF;
cursor: pointer;
}

#lightbox-image {
position: fixed;
top: 50%;
left: 50%;
margin: 0;
max-width: 100%;
-webkit-transform: translate(-50%, -50%);
-moz-transform: translate(-50%, -50%);
-ms-transform: translate(-50%, -50%);
transform: translate(-50%, -50%);
}

#lightbox-image-wrapper {
width: auto;
max-width: 100%;
max-height: 100%;
margin: 0 auto;
}

#lightbox-wrapper {
display: none;
width: 100%;
height: 100%;
background: rgba(0, 0, 0, 0.8);
position: fixed;
top: 0;
left: 0;
z-index: 99999;
}

#lightbox-wrapper.active { display: block; }

.smp-lightbox {
cursor: pointer;
cursor: -moz-zoom-in;
cursor: -webkit-zoom-in;
cursor: zoom-in;
}

</style>

<script type="text/javascript">/*
$(document).ready(function (){
$(function () {
"use strict";
$('.accordion').accordion({ defaultOpen: 'up_match_section1' }); //some_id section1 in demoup_tour_section
});
});*/
</script>

<script>
$(document).ready(function(){

$("#edit").click(function(){
$("#mes").show();
$("#mes1").hide();
$("#edit").hide();
$("#update").show();
$("#cancel").show();
$("#date").hide();
$("#edit_date").show();
});

$("#cancel").click(function(){
$("#mes").hide();
$("#mes1").show();
$("#edit").show();
$("#update").hide();
$("#cancel").hide();
$("#edit_date").hide();
$("#date").show();
});

});
</script>

<script>
$(document).ready(function(){
$('body').on('focus',".datepicker", function(){
$(this).datepicker();
});
});

</script>


<script>
$(document).ready(function(){
var baseurl = "<?php echo base_url();?>";

$('#Sport').on('change',function(){

var SportID = $(this).val();
if(SportID!=""){
//	alert("hello");
$.ajax({
type:'POST',
url:baseurl+'events/Sport_levels/',
data:'sport_id='+SportID,
success:function(html){
$('#sport_levels_div').html(html);
$('#age').focus();
}
}); 
}

}); 

});
</script>

<script>
$(document).ready(function(){

var baseurl = "<?php echo base_url();?>";

$("#academy").autocomplete({

source: function( request, response ) {
$.ajax({
url: baseurl+'Opponent/autocomplete',
dataType: "json",
method: 'post',
data: {
name_startsWith: request.term,
type: 'Academy',
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
select: function( event, ui ){
var names = ui.item.data.split("|");						
$('#org_id').val(names[1]);
$('#match_title').focus();
}		      	
});

});
</script>

<script>
$(document).ready(function(){
$("#academy").blur(function(){
var Aca = $(this).val();

if(Aca == ""){
$('#org_id').val("");
}else
{
//--------
}
});

});
</script>

<script>
$(document).ready(function(){

$('.ajax_click').click(FilterPlayers)
$('.ajax_blur').blur(FilterPlayers)
$('.ajax_change').change(Change_FilterPlayers)
$('.ajax_mile_change').change(FilterPlayers)

});

</script>

<script>

var FilterPlayers = function(){

//alert("hello");
var baseurl = "<?php echo base_url();?>";

var SportID = $("#Sport").val();

var Age_group = [];
$("input[name='age_group[]']:checked").each(function(i){
Age_group[i] = $(this).val();
});

var Level = [];
$("input[name='level[]']:checked").each(function(i){
Level[i] = $(this).val() ;
});

var Gender = $('input[type=radio][name=gend]:checked').val();
var Miles = $("#range").val();

var Org_ID = $("#org_id").val();

if(Org_ID == ""){
$('#org_id').val("");
}

if(SportID!=""){

$.ajax({
type:'POST',
url:baseurl+'events/LoadUsers/',
data:{sport_id:SportID,level:Level,age_group:Age_group,gender:Gender,range:Miles,org_id:Org_ID},
success:function(html){
$('#load-users').html(html);
}
}); 
}
}

var Change_FilterPlayers = function(){

//alert("hello");
var baseurl = "<?php echo base_url();?>";

var SportID = $("#Sport").val();

var Age_group = [];
$("input[name='age_group[]']:checked").each(function(i){
Age_group[i] = $(this).val();
});

var Level = [];

var Gender = $('input[type=radio][name=gend]:checked').val();
var Miles = $("#range").val();

var Org_ID = $("#org_id").val();

if(Org_ID == ""){
$('#org_id').val("");
}

if(SportID!=""){

$.ajax({
type:'POST',
url:baseurl+'events/LoadUsers/',
data:{sport_id:SportID,level:Level,age_group:Age_group,gender:Gender,range:Miles,org_id:Org_ID},
success:function(html){
$('#load-users').html(html);
}
}); 
}
}

$('#showdiv2').click(function() {
$('div[id^=div]').hide();
$('#div2').show();
});



</script>

<section id="single_player" class="container secondary-page">

<div class="top-score-title right-score col-md-9">
<!-- start main body -->

<br /><br />
<?php
if($ev_det)
{ 
?>
<input type="hidden" name="ev_id" value="<?php echo $ev_det['Ev_ID'];?>" /> 

<?php 
$num = $this->uri->segment(4);

if($num == 1) { 
?>
<div class="name" align='left'>
<label for="name_login" style="color:green"><?php echo "Event successfully created."; ?></label>
</div>
<?php } 
else if($num == 2) { 
?>
<div class="name" align='left'>
<label for="name_login" style="color:green"><?php echo "Invitation to the players has been sent successfully."; ?></label>
</div>
<?php } 
else if($num == 3) { 
?>
<div class="name" align='left'>
<label for="name_login" style="color:green"><?php echo "Email message sent to the players successfully."; ?></label>
</div>
<?php }

else if($num == 4) { 
?>
<div class="name" align='left'>
<label for="name_login" style="color:green"><?php echo "Comments successfully added."; ?></label>
</div>
<?php }

else if($num == 5) { 
?>
<div class="name" align='left'>
<label for="name_login" style="color:red"><?php echo "You were already in the list of Invited Players. Thankyou."; ?></label>
</div>

<?php }

else if($num == 6) { 
?>
<div class="name" align='left'>
<label for="name_login" style="color:green"><?php echo "You are successfully registered for this event. Thankyou."; ?></label>
</div>

<?php }

else if($num == 7) { 
?>
<div class="name" align='left'>
<label for="name_login" style="color:green"><?php echo "Successfully Images are Uploaded. Thankyou."; ?></label>
</div>

<?php } ?>



<div class="col-md-12 league-form-bg" >
<div class="fromtitle"><?php echo $ev_det['Ev_Title'];?></div>

<div class='col-md-8'>
<p><label>Event Type:</label>
<?php $title = events::get_event_name($ev_det['Ev_Type_ID']);
echo $title['Ev_Type'];?>
</p>

<?php if($ev_det['Ev_Schedule'] == 'singleday'){ ?>

<p><label>Date of Event:</label> <?php 
if($ev_det['Ev_Start_Date'] != "1900-01-01 00:00:00.000"){ echo  date("m-d-Y", strtotime($ev_det['Ev_Start_Date'])); } else { echo "&lt;Not Available&gt;"; }
?></p>
<?php } else { ?>

<p><label>Start Date:</label> <?php 
if($ev_det['Ev_Start_Date'] != "1900-01-01 00:00:00.000"){ echo  date("m-d-Y", strtotime($ev_det['Ev_Start_Date'])); } else { echo "&lt;Not Available&gt;"; }
?></p>
<p><label>End Date:</label> <?php
if($ev_det['Ev_End_Date'] != "1900-01-01 00:00:00.000"){ echo  date("m-d-Y", strtotime($ev_det['Ev_End_Date']));  } else { echo "&lt;Not Available&gt;"; }
?></p>
<?php } ?>

<?php  if($ev_det['Ev_Location']) { $loc = $this->model_event->get_location_name($ev_det['Ev_Location']); 
$location = $loc['loc_title'];
} else { $location = "&lt;Not Available&gt;"; }?>
<p><label>Location:</label> <?php echo $location; ?></p>
<p><?php if($loc['loc_add']) 
echo "<label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</label>".$loc['loc_add']; 

if($loc['loc_city']) echo $loc['loc_city']; 
if($loc['loc_state']) echo ",".$loc['loc_state']; 
if($loc['loc_country']) echo ",".$loc['loc_country']; 

?></p>

<p><label>Organized By:</label> <?php $event_init = events::get_user_details($ev_det['Ev_Created_by']);
echo $event_init['Firstname']." ".$event_init['Lastname'];?>
</p>
<p><label>Contact Number:</label> <?php echo $ev_det['Ev_Contact_Num'];?></p>
<p><label>Description:</label> <?php 
if($ev_det['Ev_Location']) {
$description = $ev_det['Ev_Desc'];
} else { 
$description = "&lt;Not Available&gt;";
}
echo $description; ?> </p>
</div>

<div class="col-md-4">
<?php if($ev_det['EventImage']!=""){ ?>
<img class="scale_image" src="<?php echo base_url(); ?>events_pictures/<?php echo $ev_det['EventImage']; ?>" alt="" width="200px" height="200px" />
<?php } else {

} ?>
</div>


<div class="col-md-12">
<?php
if($actcode_det){

if($actcode_det['Act_Status'] == 0){ 
?>
<div class="col-md-4 txt-torn1" style="padding-left:0px; margin-bottom:20px">
<a href="<?php echo base_url();?>events/register_user/<?php echo $actcode_det['Ev_ID'];?>/<?php echo $actcode_det['Act_Code'];?>"  style="cursor:pointer;">Register</a></div>

<?php } else if($actcode_det['Act_Status'] == 1) { ?>  

<div style="color:red">Activation Code has expired! Please contact event organizer for any queries.</div>

<?php }
}
else { ?>

<?php $users_id = $this->session->userdata('users_id');

if($ev_det['Ev_Created_by'] == $users_id){
?>
<br />
<div class="col-md-4 txt-torn1" style="padding-left:0px; margin-bottom:20px">
<a href="#div1" id="showdiv1" style="cursor:pointer;">Send Invites</a></div>

<div class="col-md-4 txt-torn1" style="padding-left:0px; margin-bottom:20px">
<a href="#div2" id="showdiv2" style="cursor:pointer;">Track/ Update Schedule</a></div>

<div class="col-md-4 txt-torn1" style="padding-left:0px; margin-bottom:20px">
<a href="#div3" id="showdiv3" style="cursor:pointer;">Send Email to Players</a></div>

<div class="col-md-4 txt-torn1" style="padding-left:0px; margin-bottom:20px">
<a href="#div4" id="showdiv4"  style="cursor:pointer;">Upload Images</a></div>

<div class="col-md-4 txt-torn1" style="padding-left:0px; margin-bottom:20px">
<a onclick="refresh_blog(<?php echo $ev_det['Ev_ID'];?>)" style='cursor:pointer;'>View Gallery</a></div>

<?php
}

if(count($is_ev_user) > 0  and ($num_players > 0) and ($ev_det['Ev_Created_by'] != $users_id)){
?>

<br /><div class="col-md-4 txt-torn1" style="padding-left:0px; margin-bottom:20px">
<a href="#div2" id="showdiv2" style="cursor:pointer;">Track/ Update Schedule</a></div>


<div class="col-md-4 txt-torn1" style="padding-left:0px; margin-bottom:20px">
<a onclick="refresh_blog(<?php echo $ev_det['Ev_ID'];?>)" style='cursor:pointer;'>View Gallery</a></div>

<?php
}
?>

<?php } ?>
</div>


</div>

<?php 
}
else
{ 
?>
<p style="line-height:20px; font-size:13px"><h5>Oops! Invalid Access. Please contact admin@a2msports.com</h5></p>
<?php
}
?>

<div class="clear:both"></div>

<?php 
$this->load->view('events/view_ev_invite_reg.php');		// Invite section for registered players
$this->load->view('events/view_ev_respond_sch.php');    // Check the Status of Availability	
$this->load->view('events/view_ev_send_email.php');    // send email to players
$this->load->view('events/view_ev_upload.php');    // upload images 
?>





</div>   <!--Close Top Match-->