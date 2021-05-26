<script src="<?php echo base_url();?>js/jquery.accordion.js" type="text/javascript"></script>
<script type="text/javascript">
$(document).ready(function () {
$(function () {
"use strict";
$('.accordion').accordion({ defaultOpen: 'up_match_section' }); //some_id section1 in demoup_tour_section
});
});
</script>


<script>
$(document).ready(function(){

var baseurl = "<?php echo base_url();?>";

$('#user_sport').on('change',function(){

// var SportID = $(this).val();
var SportID  = $( "#user_sport option:selected" ).val();

// if(SportID!=""){

$.ajax({
type:'POST',
url:baseurl+'academy/Sport_levels/',
data:'sport_id='+SportID,
success:function(html){
$('#sport_levels_div').html(html);
}
}); 
//}

}); 
});
</script>

<script>
$(document).ready(function(){

$('#div1').click(function(){
$('#members').show();	
});
});
</script>

<script>

var academyPlayers = function(){

//alert("hello");
var baseurl = "<?php echo base_url();?>";

var Name = $("#name").val();
var SportID = $("#user_sport").val();
var Level = $("#level").val();

var Range = $("#range").val();
if ($('#check_id').is(":checked"))
{
var Org_ID = $("#org_id").val();
}else
{
var Org_ID = "";	
}


$.ajax({
type:'POST',
url:baseurl+'academy/LoadUsers/',
data:{sport:SportID,level:Level,name:Name,range:Range,org_id:Org_ID},
success:function(html){
$('#load-users').html(html);
}
}); 

}
</script>


<?php //if($this->session->userdata('user')=="") { ?>

<!-- <p style="line-height:5px; font-size:13px">Please <a href='<?php //echo base_url()."login"; ?>'><b>Login</b> </a>to find Organization details .</p> -->
<?php //} ?>
</div>

<div style="clear:both"></div>



<!--  USER SESSION IS NOT EMPTY SHOW ALL CONTENT -->
<?php //if($this->session->userdata('user')!="") { 
$short_code = $this->uri->segment(1);
?>		

<section id="single_player" class="container secondary-page">
<div class="top-score-title right-score col-md-9">
<br />
<!-- <h3></h3> -->

<!-- Details Section start-->
<div class="col-md-12 atp-single-player">

<div class="col-md-4">
<img class="" src="<?php echo base_url(); ?>org_logos/<?php if($org_details['Aca_logo']!=""){echo $org_details['Aca_logo']; } else { echo "";}?>" alt="" height="200px" width="280px"  />
</div>

<!-- 	 <div class="col-md-2 profilelist"> </div>  -->
<div class="col-md-8 profilelist">
<h3><?php echo $org_details['Aca_name']; ?></h3>
<p style="text-align:center !important"><?php echo $org_details['Aca_addr1'];?></p>

<p style="text-align:center !important"><?php echo $org_details['Aca_	'];?>, <?php echo $org_details['Aca_state'];?></p>
<!--<p style="text-align:center !important"><?php echo $org_details['Aca_city'];?></p>
<p style="text-align:center !important"><?php echo $org_details['Aca_state'];?></p>
<p style="text-align:center !important"><?php echo $org_details['Aca_country'];?></p>-->
<p style="text-align:center !important"><?php echo $org_details['Aca_contact_phone'];?></p>
<p style="text-align:center !important"><?php echo $org_details['Aca_contact_email'];?></p>

</div>

</div>
<!-- Details section end -->


<!-- List of tournaments Section start-->
<div class="col-md-12 league-form-bg" style="margin-top:40px; margin-bottom:20px;">

<div class="accordion" id="up_match_section" style="background:#f59123; padding:5px; color:white;"><i class="fa fa-arrow-circle-o-right" style="color:white;"> </i>Upcoming Events<span></span></div>

<div class="tab-content">
<table class="tab-score">					
<!-- <tr class="top-scrore-table">
<td class="score-position" valign="center" align="center">Starts On</td>
<td class="score-position" valign="center" align="center">Tournament</td>
<td class="score-position" valign="center" align="center">Action</td>
</tr> -->

<?php 
if(count($tourn_list) == 0)
{
?>
<tr>
<td colspan='3'><h5>No Upcoming Events found.</h5></td>
</tr>
<?php
}
else
{
foreach($tourn_list as $row) { ?>
<tr>
<td valign="center" align="center" ><?php echo date('m/d/Y',strtotime(substr($row->StartDate,0,10))) ;?></td>
<td valign="center" align="center">
<p></p>

<div class="col-md-4" style="">
<img class="img-djoko" src="<?php echo base_url(); ?>tour_pictures/<?php if($row->TournamentImage!=""){echo $row->TournamentImage; }
else {
switch($row->SportsType) {
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
case 8:
echo "default_chess.jpg";
break;
case 9:
echo "default_carroms.jpg";
break;
case 10:
echo "default_volleyball.jpg";
break;
case 11:
echo "default_fencing.jpg";
break;
case 12:
echo "default_bowling.jpg";
break;
default:
echo "";
}
}
?>" alt=""  width="500px" height="500px"  />

</div>
<div align='left' class="col-md-7" style="margin-left:10px;">
<p style="font-size:16px"><a href="<?php
if(($row->Short_Code != '' and $row->Short_Code != NULL)){
echo base_url().$row->Short_Code; } 
else{ 
echo base_url().'league/view/'.$row->tournament_ID; }
?>"><?php echo $row->tournament_title;?></a></p>
<p><strong>Sport:</strong> <?php 
$get_sport = academy::get_sport($row->SportsType);
echo $get_sport['Sportname'];
?>
<?php
echo "(";
$option_array = json_decode($row->Singleordouble);										
$numItems = count($option_array);

$i = 0;
if($numItems > 0){
foreach($option_array as $sport){
echo $sport;

if(++$i != $numItems) {
echo ", ";
}
}
}

echo ")";
?>                
</p>                          

<p><strong>Registration closes on:</strong> <?php echo date('m/d/Y',strtotime(substr($row->Registrationsclosedon,0,10))); ?></p>
<p><strong>Location:</strong> <?php echo $row->TournamentCity. ',' . $row->TournamentState; ?></p>
<p></p>
</div>
</td>

<td valign="center" align="center">
<div>
<?php if(($this->session->userdata('user')!="") && ($row->Usersid != $this->session->userdata('users_id'))) {?>
<a href="<?php echo base_url(); //.$this->short_code; ?>league/register_match/<?php echo $row->tournament_ID;?>">Register</a>
<?php } ?> 
</div>  

<div>
<?php if(($this->session->userdata('user')!="") && ($row->Usersid == $this->session->userdata('users_id'))) {?>
<a href="<?php echo base_url(); ?>league/edit/<?php echo $row->tournament_ID;?>">Edit</a>
<?php } ?> 
</div>

<div> 
<?php if(($this->session->userdata('user')!="") && ($row->Usersid == $this->session->userdata('users_id')) && $row->SportsType != 4) {
?>
<a href="<?php echo base_url();?>league/fixtures/<?php echo $row->tournament_ID;?>">Create Draws</a><?php } ?> 
</div>

<div>
<?php if(($this->session->userdata('user')!="") && ($row->Usersid == $this->session->userdata('users_id'))) {?>
<a href="<?php echo base_url();?>play/invite/<?php echo $row->tournament_ID;?>">Invite Players</a><?php } ?> 
</div>  
</td>
</tr>

<?php } 
}
?>
</table>
</div>

</div>
<!-- List of upcoming Events End-->

<!-- List of past tournaments start-->

<div class="col-md-12 league-form-bg" style="margin-top:40px; margin-bottom:20px;">

<div class="accordion" id="section3" style="background:#f59123; padding:5px; color:white;"><i class="fa fa-arrow-circle-o-right" style="color:white;"> </i>Past Events<span></span></div>


<div class="tab-content">
<table class="tab-score">

<?php

if(count($past_tournments) == 0)
{
?>
<tr>
<td colspan='3'><h5>You were not registered for any tournament yet.</h5></td>
</tr>
<?php
}
else
{
foreach($past_tournments as $row) { ?>
<tr>
<td valign="center" align="center" ><?php echo date('m/d/Y',strtotime(substr($row->StartDate,0,10))) ;?></td>
<td valign="center" align="center">
<p></p>

<div class="col-md-3" style="">
<img class="img-djoko" src="<?php echo base_url(); ?>tour_pictures/<?php if($row->TournamentImage!=""){echo $row->TournamentImage; }
else {
switch($row->SportsType) {
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
case 8:
echo "default_chess.jpg";
break;
default:
echo "";
}
}
?>" alt=""  width="500px" height="500px"  />
</div>
<div align='left' class="col-md-7" style="margin-left:10px;">
<p style="font-size:16px"><a href="<?php echo base_url().$short_code; ?>/league/view/<?php echo $row->tournament_ID;?>"><?php echo $row->tournament_title;?></a></p>

<p><strong>Sport:</strong> <?php 
$get_sport = academy::get_sport($row->SportsType);
echo $get_sport['Sportname'];
?>
<?php
echo "(";
$option_array = json_decode($row->Singleordouble);										
$numItems = count($option_array);

$i = 0;
if($numItems > 0){
foreach($option_array as $sport){
echo $sport;

if(++$i != $numItems) {
echo ", ";
}
}
}

echo ")";


?>                
</p>                          
<!-- <p><strong>Period:</strong>  <?php //echo date('m/d/Y',strtotime(substr($row->StartDate,0,10))); ?> - 
<?php //echo date('m/d/Y',strtotime(substr($row->EndDate,0,10))); ?></p> -->

<p><strong>Registration closed on:</strong> <?php echo date('m/d/Y',strtotime(substr($row->Registrationsclosedon,0,10))); ?></p>
<p><strong>Location:</strong> <?php echo $row->TournamentCity. ',' . $row->TournamentState; ?></p>
<p></p>
</div>
</td>
<!-- <td valign="center" align="center" ><?php //echo $row->TournmentCity;?></td>
<td valign="center" align="center">
<?php //echo date('m/d/Y',strtotime(substr($row->Registrationsclosedon,0,10))); ?></td> -->
<td valign="center" align="center">

<!-- <?php echo base_url();?>Fixtures -->

<div>

<!-- <a href="">Add/View Scores</a> -->

</div>  <!--<?php echo base_url();?>Send-invite -->
</td>
</tr>

<?php }
} 
?>
</table>
</div>

</div>
<!-- List of past Events End-->



<!-- Members section start-->
<div class="col-md-12 league-form-bg" id="members" style="margin-top:40px; background:#fff; margin-bottom:20px">

<div class="fromtitle">Search for Members</div>

<form method="post" id="myform"  action="<?php echo base_url().$short_code;?>/search_member"> 

<!--<label class='control-label col-md-1' for='id_accomodation' style="padding-left:0px; padding-top:5px"><b>Search:</b></label> -->

<div class='col-md-3 form-group internal' style="padding-left:0px">
<input class='form-control' id='name' name='name' type='text' placeholder="Player Name" value="<?php echo $search_fname; ?>"  size="25" />
</div>

<div class='col-md-2 form-group internal' style="padding-left:0px">
<?php
$sport = "";
if($this->input->post('user_sport')){
$sport = $this->input->post('user_sport');
}
?>
<select name="user_sport"  id="user_sport" class='form-control'>
<option value="">Sport</option>
<option value="1" <?php if($sport=="1"){ echo "selected=selected"; } ?>>Tennis</option>
<option value="2" <?php if($sport=="2"){ echo "selected=selected"; } ?>>Table Tennis</option>
<option value="3" <?php if($sport=="3"){ echo "selected=selected"; } ?>>Badminton</option>
<option value="4" <?php if($sport=="4"){ echo "selected=selected"; } ?>>Golf</option>
<option value="5" <?php if($sport=="5"){ echo "selected=selected"; } ?>>Racquetball</option>
<option value="6" <?php if($sport=="6"){ echo "selected=selected"; } ?>>Squash</option>
<option value="7" <?php if($sport=="7"){ echo "selected=selected"; } ?>>Pickleball</option>
</select>

</div>

<div id='sport_levels_div' class='col-md-3 form-group internal'>

<?php
$sp_level = "";
if($this->input->post('level'))	{
$sp_level = $this->input->post('level');
}
?>
<select name="level" id="level" class='form-control'>
<option value="">Level</option>
<?php foreach($sport_levels as $row){ ?>
<option value="<?php echo $row->SportsLevel_ID;?>" <?php if($sp_level == $row->SportsLevel_ID){ echo "selected=selected"; } ?>>
<?php  echo $row->SportsLevel; ?> 
</option>
<?php } ?>
</select>
</div>


<div class='col-md-2 form-group internal' style="padding-left:0px">
<?php
$range = "";
if($this->input->post('range'))	{
$range = $this->input->post('range');
}
?>

<select name="range"  id="range" class='form-control'>
<option value="" <?php if($range==""){ echo "selected=selected"; } ?>>Distance</option>
<option value="10" <?php if($range=="10"){ echo "selected=selected"; } ?>>10miles</option>
<option value="20" <?php if($range=="20"){ echo "selected=selected"; } ?>>20miles</option>
<option value="30" <?php if($range=="30"){ echo "selected=selected"; } ?>>30miles</option>
<option value="40" <?php if($range=="40"){ echo "selected=selected"; } ?>>40miles</option>
<option value="50" <?php if($range=="50"){ echo "selected=selected"; } ?>>50miles</option>
</select>

</div>

<input class='form-control'  name='org_id' id='org_id' type='hidden' value="<?php echo $org_details['Aca_ID'];?>"  />

<div id="register-submit" class="col-md-2 form-group internal" style="padding-left:0px">
<input type="submit"  class="league-form-submit1" name="search_mem" value=" Search " />
</div>

<input type="checkbox" id="academy_status"  name="academy_status"  checked  value="1"> Show results only from <?php echo $org_details['Aca_name']; ?> 

</form>
<div class="clear"></div>

<!-- -------search -----results --------------- -->

<?php
if($this->input->post('search_mem'))
{
?>
<div id="load-users">
<div class="tab-content">
<table class="tab-score">
<?php 
if(count($query) == 0)
{
?>
<tr>
<td><h5>No Search Members Found.</h5></td>
</tr>
<?php
}
else
{
foreach($query as $row){ ?><!-- img-djoko -->
<tr>
<td>
<a href="#"><img class="scale_image" src="<?php echo base_url(); ?>profile_pictures/<?php if($row->Profilepic!=''){ echo $row->Profilepic; } else { echo "default-profile.png"; } ?>" alt="img" width="150px" height="250px" /></a>
</td>
<td width="90%" style="vertical-align:top;">
&nbsp;&nbsp;<a href="<?php echo base_url();?>player/<?php echo $row->Users_ID;?>"><?php echo $row->Firstname.' '.$row->Lastname; ?></a><br />
&nbsp;

Interested Sports: 

<?php 
$get_data = academy::get_details($row->Users_ID);
//print_r($get_data);
$numItems = count($get_data);
$i = 0;
if($numItems > 0)
{
foreach($get_data as $r){

$sport = $r->Sport_id;

switch ($sport){
case 1:
echo "Tennis";
break;
case 2:
echo "Table Tennis";
break;
case 3:
echo "Badminton";
break;
case 4:
echo "Golf";
break;
case 5:
echo "RacquetBall";
break;
case 6:
echo "Squash";
break;
case 7:
echo "Pickleball";
break;
default:
echo "";
}

if(++$i != $numItems) {
echo ", ";
} }	}
?>
<br>&nbsp;

Location: 

<?php 
if($row->City != "")
{
echo $row->City.", ".$row->State."<br>&nbsp;"; 
}
if($row->Country != "")
{
$row->Country; 
}
?>


Age Group: 
<?php 
if($row->UserAgegroup != "")
{
echo $row->UserAgegroup; 
}
?>

<br> &nbsp;

A2M Score: 
<?php 
$get_data = academy::get_details($row->Users_ID);			
foreach($get_data as $r) { 
$sport = $r->Sport_id;
$get_sp_name = academy::get_sport($sport);
$user_id = $row->Users_ID;
$user_a2mscore = $this->model_academy->get_a2msocre($sport,$user_id);
if($user_a2mscore != ""){
echo  $get_sp_name['Sportname'] . " - " . $user_a2mscore['A2MScore'] . "" ."<br />";
echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
}
}

?></td>
</tr>

<?php } }?>
</table>
</div>
</div>

<?php
} 
?>

</div>
<!-- ----------------end of search results ----------------- -->


<!-- Coaches section start-->
<div class="col-md-12 league-form-bg"  style="margin-top:40px; background:#fff; margin-bottom:20px">

<div class="fromtitle">Search for Coaches</div>

<!-- <form method="post" id="coach_form" action="<?php //echo base_url().$short_code;?>/coaches"> --> 
<form method="post" id="coach_form"  action="<?php echo base_url().$short_code;?>/search_coaches"> 

<div class='col-md-3 form-group internal' style="padding-left:0px">
<input class='form-control' id='' name='coach_name' type='text' placeholder="Coach Name" value="<?php if(isset($coach_name)) echo $coach_name; ?>" />
</div>

<div class='col-md-3 form-group internal' style="padding-left:0px">
<?php
$sport = "";
if($this->input->post('coach_sport')){
$sport = $this->input->post('coach_sport');
}
?>
<select name="coach_sport"  id="coach_sport" class='form-control'>
<option value="">Coach Sport</option>
<option value="1" <?php if($sport=="1"){ echo "selected=selected"; } ?>>Tennis</option>
<option value="2" <?php if($sport=="2"){ echo "selected=selected"; } ?>>Table Tennis</option>
<option value="3" <?php if($sport=="3"){ echo "selected=selected"; } ?>>Badminton</option>
<option value="4" <?php if($sport=="4"){ echo "selected=selected"; } ?>>Golf</option>
<option value="5" <?php if($sport=="5"){ echo "selected=selected"; } ?>>Racquetball</option>
<option value="6" <?php if($sport=="6"){ echo "selected=selected"; } ?>>Squash</option>
<option value="7" <?php if($sport=="7"){ echo "selected=selected"; } ?>>Pickleball</option>
</select>
</div>

<div class='col-md-3 form-group internal' style="padding-left:0px">
<?php
$range = "";
if($this->input->post('coach_range')){
$range = $this->input->post('coach_range');
}
?>

<select name="coach_range"  id="coach_range" class='form-control'>
<option value="" <?php if($range==""){ echo "selected=selected"; } ?>>Distance</option>
<option value="10" <?php if($range=="10"){ echo "selected=selected"; } ?>>10Miles</option>
<option value="20" <?php if($range=="20"){ echo "selected=selected"; } ?>>20Miles</option>
<option value="30" <?php if($range=="30"){ echo "selected=selected"; } ?>>30Miles</option>
<option value="40" <?php if($range=="40"){ echo "selected=selected"; } ?>>40Miles</option>
<option value="50" <?php if($range=="50"){ echo "selected=selected"; } ?>>50Miles</option>
</select>

</div>

<input class='form-control'  name='org_id' id='org_id' type='hidden' value="<?php echo $org_details['Aca_ID'];?>"  />

<div id="register-submit" class="col-md-2 form-group internal" style="padding-left:0px">
<input type="submit" name="coach_mem" value=" Search " />
</div>

</form>

<div class="clear"></div>

<?php
if($this->input->post('coach_mem'))
{
?>

<div class="tab-content">
<table class="tab-score">
<?php
if(count($coach_results) == 0)
{
?>
<tr>
<td><h5>No Coach Members Found.</h5></td>
</tr>
<?php
}
else
{

foreach($coach_results as $row){ ?><!-- img-djoko -->
<tr>
<td>
<a href="#"><img class="scale_image" src="<?php echo base_url(); ?>profile_pictures/<?php if($row->Profilepic!=''){ echo $row->Profilepic; } else { echo "default-profile.png"; } ?>" alt="img" width="150px" height="250px" /></a>
</td>
<td width="90%" style="vertical-align:top;">
&nbsp;&nbsp;<a href="<?php echo base_url();?>player/<?php echo $row->Users_ID;?>"><?php echo $row->Firstname.' '.$row->Lastname; ?></a><br />
&nbsp;

<br>&nbsp;

Sport: 
<?php 
$get = $this->model_academy->get_sport_title($row->coach_sport);
echo $get['Sportname'] ."<br>&nbsp;";
?>

Location: 

<?php 
if($row->City != "")
{
echo $row->City.", ".$row->State."<br>&nbsp;"; 
}
?>

Profile Description: 

<?php 
if($row->coach_profile != "")
{
echo $row->coach_profile; 
}
?>
<br> &nbsp;

Coach Website: 

<?php
if($row->Coach_Website != ""){
$check = "http";
$pos = strpos($row->Coach_Website,$check);
if($pos){ ?>

<a target="_blank" href="<?php echo $row->Coach_Website;?>"><?php echo $row->Coach_Website;?></a> 

<?php } else { ?>
<a target="_blank" href="<?php echo "http://".$row->Coach_Website;?>"><?php echo $row->Coach_Website;?></a>  

<?php } 
} ?>

<br> &nbsp;

</td>
</tr>

<?php } }?>
</table>
</div>

<?php
} 
?>
</div>

<div class="clear"></div>

</div>

</div>
<?php //} ?>