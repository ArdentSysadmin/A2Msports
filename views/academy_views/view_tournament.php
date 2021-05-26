<script src="<?php echo base_url();?>js/jquery-1.10.2.js" type="text/javascript"></script>

<script>
$(document).ready(function () {
//$("a.scale_image").simpleLightBox();
var short_code	= "<?php echo $this->short_code;?>";
var baseurl		= "<?php echo base_url();?>";

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

<script>
// Show select image using file input.
function readURL(input) {
$('#default_img').show();
if (input.files && input.files[0]) {
var reader = new FileReader();

reader.onload = function(e) {
$('#select')
.attr('src', e.target.result)
.width(300)
.height(200);

};

reader.readAsDataURL(input.files[0]);
}
}
</script>

<script type="text/javascript">
$( document ).ready(function() {

$(".checkbox1").click(function() {
$chk_id = this.id;
$uid = $chk_id.slice(3,10);
if($('#sel'+$uid).prop('disabled')==true && $('#'+$chk_id).prop('checked')==true){
$('#sel'+$uid).prop('disabled', false);
}
else{
$('#sel'+$uid).prop('disabled', true);
$('#sel'+$uid).val('');
}
});

$(function() {

var short_code = "<?php echo $this->short_code;?>";
var baseurl	   = "<?php echo base_url();?>";

$('#showdiv1').click(function() {
$('div[id^=div]').hide();
$('#div1').show();
$('#bracket_result').hide();
// $('#no_bracket').hide();
});

/*$('#showdiv2').click(function() {
$('div[id^=div]').hide();
$('#div2').show();
$('#bracket_result').hide();
$('#no_result').hide();
});*/

$('#showdiv2').click(function() {
var show_player_view = "<?php echo $valid_draws_count; ?>";
var bid				 = "<?php echo $show_draw_bid; ?>";
	$('div[id^=div]').hide();
	if(show_player_view == 1) { $('#list_draw_matches'+bid).trigger('click'); }
	else { $('#div2').show(); }
	$('#bracket_result').hide();
	$('#no_result').hide();
});


$('#showdiv3').click(function() {
$('div[id^=div]').hide();
$('#div3').show();
$('#bracket_result').hide();
$('#no_result').hide();
});

$('#showdiv4').click(function() {
$('div[id^=div]').hide();
$('#div4').show();
$('#bracket_result').hide();
$('#no_result').hide();
});

$('#showdiv5').click(function() {
$('div[id^=div]').hide();
$('#div5').show();
$('#bracket_result').hide();
$('#no_result').hide();
});

$('#showdiv6').click(function() {
$('div[id^=div]').hide();
$('#div6').show();
$('#div_sel_partner').show();
$('#bracket_result').hide();
$('#no_result').hide();
});

$('#showdiv7').click(function() {
$('div[id^=div]').hide();
$('#div7').show();
$('#div_sel_partner').show();
$('#bracket_result').hide();
$('#no_result').hide();
});

$('#showdiv8').click(function() {
$('div[id^=div]').hide();
$('#div8').show();
$('#bracket_result').hide();
$('#no_result').hide();
});

/* Manage Team Ajax code */
$('#showdiv9').click(function(){
var team_id	= $(this).attr('class');
var tourn_id = $('#tourn_id').val();

if(team_id != "" && tourn_id != ""){
	$.ajax({
		type:'POST',
		url:baseurl+short_code+'/teams/get_tour_reg_team',
		data:{ team_id:team_id, tourn_id:tourn_id },
		success:function(html){
		$('div[id^=div]').hide();
		$('#div9').show();
		$('#div9').html(html);
		}
	}); 
}

});
/* Manage Team Ajax code */


$('#submit').click(function() {
$('div[id^=div]').hide();
$('#your_form').show();
$('#bracket_result').show();
});

$('#show_box').click(function() {
$('#show_msg').show();
$('#show_box').hide();
});

$('#cancel_msg').click(function() {
$('#show_msg').hide();
$('#show_box').show();
$("#uncheck").prop("checked", false);
});
});
});
</script>

<script>
$(document).ready(function(){

$(".add_score").click(function(){
var pid = $(this).attr('name');

if($("#score"+pid).css('display')=='none'){
$("#score"+pid).show();
$("#forfeit"+pid).hide();
$("#comment"+pid).hide();
}
else{
$("#forfeit"+pid).hide();
$("#score"+pid).hide();
$("#comment"+pid).hide();
}
});

$(".edit_score").click(function(){
var pid = $(this).attr('name');

if($("#escore"+pid).css('display')=='none'){
$("#escore"+pid).show();
//$("#eforfeit"+pid).hide();
}
else{
//$("#eforfeit"+pid).hide();
$("#escore"+pid).hide();
}
});

$(".cd_edit_score").click(function(){
var pid = $(this).attr('name');

if($("#cd_escore"+pid).css('display')=='none'){
$("#cd_escore"+pid).show();
//$("#eforfeit"+pid).hide();
}
else{
//$("#eforfeit"+pid).hide();
$("#cd_escore"+pid).hide();
}
});

$(".rr_edit_score").click(function(){
var pid = $(this).attr('name');

if($("#rr_escore"+pid).css('display')=='none'){
$("#rr_escore"+pid).show();
//$("#eforfeit"+pid).hide();
}
else{
//$("#eforfeit"+pid).hide();
$("#rr_escore"+pid).hide();
}
});

$('.wff_score').click(function() {
var pid2 = $(this).attr('name');

if($("#forfeit"+pid2).css('display')=='none'){
$("#forfeit"+pid2).show();
$("#score"+pid2).hide();
$("#comment"+pid).hide();
}
else{
$("#forfeit"+pid2).hide();
$("#score"+pid2).hide();
$("#comment"+pid).hide();
}

});

});

</script>


<script>
/*$(document).ready(function () {
$(".page").change(function () { 
var rid = $(this).attr('name');
if (this.value == "1") { 
$('#rotate_degree'+rid).show(); 
} else {
$('#rotate_degree'+rid).hide();
}
});
});*/
</script>


<script>

$(function(){
$("input[type='submit']").click(function(){
var $fileUpload = $("input[type='file']");
if (parseInt($fileUpload.get(0).files.length)>10){
alert("You can only upload a maximum of 10 files");
return false;
}
});    
});
</script>

<!-- -----------------------------------Registered Players start code (div 4 block)-------------------------------------------------- -->
<script>
$(document).ready(function(){
var baseurl = "<?php echo base_url();?>";

$('#age_type,#match_format,#tourn_level').on('change',function(){

$('#show_box').hide();

var Group = $('#age_type').val();
var Match_type = $('#match_format').val();
var Tourn_id = $('#tourn_id').val();
var Tourn_level = $('#tourn_level').val();

if(Group!="" && Match_type!="" && Tourn_level!= "" ){
$.ajax({
type:'POST',
url:baseurl+short_code+'/registered_players/',
data:{ tourn_id:Tourn_id,mtype:Match_type,age:Group,level:Tourn_level},    //{pt:'7',rngstrt:range1, rngfin:range2},
success:function(html){
$('#load-users').html(html);
}
}); 
}

});
});
</script>

<!-- -------------------------------Registered players end code-------------------------------------------- -->


<!-- -----------------------------------participants start code-------------------------------------------------- -->
<script>
$(document).ready(function(){
var baseurl = "<?php echo base_url();?>";

$('#participant_age_type, #participant_format,#participant_level').on('change',function(){

var AgeGroup	= $('#participant_age_type').val();
var Match_type	= $('#participant_format').val();
var Level		= $('#participant_level').val();
var Tourn_id	= $('#tourn_id').val();
var Sport_id	= $('#sport').val();

if(AgeGroup != "" && Match_type != ""){
$.ajax({
type:'POST',
url:baseurl+short_code+'/participants/',
data:{ tourn_id:Tourn_id,mtype:Match_type,age:AgeGroup,sport_id:Sport_id,level:Level},    //{pt:'7',rngstrt:range1, rngfin:range2},
success:function(html){
$('#participants-users').html(html);
}
}); 
}

});
});
</script>



<!-- -----------------------------------particiants code end ------------------------------------------------ -->
<script>
$(document).ready(function(){
var baseurl = "<?php echo base_url();?>";

$('#double_age_type').on('change',function(){

$('#show_box').hide();

var Group		= $(this).val();
var Match_type	= $('#match_type').val();
var Tourn_id	= $('#tourn_id').val();

//alert(Group);

if(Group!=""){
$.ajax({
type:'POST',
url:baseurl+short_code+'/registered_players_age/',
data:{ tourn_id:Tourn_id,mtype:Match_type,age:Group},    //{pt:'7',rngstrt:range1, rngfin:range2},
success:function(html){
$('#load-users').html(html);
}
}); 
}

});
});
</script>

<script>
$(document).ready(function(){ 
$("#sel_all").change(function(){
$(".checkbox1").prop('checked', $(this).prop("checked"));
});
});
</script>

<script>
$(document).ready(function(){ 
$('#send_reg_email').click(function() {
var checkedNum = $('input[name="sel_player[]"]:checked').length;
if (checkedNum === 0) {
alert('Select atleast one player to send Email');
return false;
}
});
});
</script>

<!-- -----------------double partner update--------------------- -->
<script>

$(document).ready(function(){
var baseurl = "<?php echo base_url();?>";

$('.double_partner').on('change',function(){

$sel_id = this.id;
$uid	= $sel_id.slice(3,10);

var Player		= $('#player_'+$uid).val();
var Partner		= $(this).val();
var Tourn_type	= $('#tourn_type').val();
var Tourn_id	= $('#tourn_id').val();

if(Partner != ""){
//alert("Updating players");
$.ajax({
type:'POST',
url:baseurl+short_code+'/double_players_change/',
data:{ tourn_id:Tourn_id, ttype:Tourn_type, partner:Partner, player:Player},    //{pt:'7',rngstrt:range1, rngfin:range2},
success:function(html){
$('#dbl-load-users').html(html);
}
}); 
}

});
});

</script>

<!-- -----------------print flyer --------------------- -->
<script language="javascript" type="text/javascript">
function myWin_flyer(tid)
{
var path = "<?php echo base_url(); ?>";
var tid  = '<?php echo $tour_details->tournament_ID; ?>';
	window.open(path+'/flyer/'+tid,null,"height=650,width=700,status=yes,toolbar=no,menubar=no,location=no");
}
</script>

<script>
$(document).ready(function(){
	$('#delete').click(function(e){
		
		//alert('hai');

		var r = confirm("Once draws are deleted, can't revert back. Are you sure to delete?");

		if(r == false){
			 e.preventDefault();
			 return false;	
		}else
		{
			return true;
		}

    });
});

$(".header").click(function () {

	$header = $(this);
    //getting the next element
    $content = $header.next();
    //open up the content needed - toggle the slide- if visible, slide up, if not slidedown.
    $content.slideToggle(500, function () {
        //execute this after slideToggle is done
        //change text of header based on visibility of content div
        $header.text(function () {
            //change text based on condition
            //return $content.is(":visible") ? 'Text1' : 'Text2';
        });
    });

});

</script>
<!-- ----------------- view gallery section --------------------- -->

<script language="javascript" type="text/javascript">
function refresh_blog(tid){

var short_code  = "<?php echo $this->short_code;?>";
var baseurl		= "<?php echo base_url();?>";
//var tid		= '<?php echo $tour_details->tournament_ID; ?>';

$.ajax({
type: 'POST',
url:baseurl+short_code+'/league/get_gallery',
data:{ tourn_id:tid},
cache: false,
success: function(html){ 
$('div[id^=div]').hide();
$('#bracket_result').hide();
$('#no_result').hide();
$('#div8').show();
$('#blog_container').html(html);

}           
});
}

</script>

<!-- ----------------- -------------------- -->

<?php
$short_code = $this->uri->segment(1);
?>
<section id="single_player" class="container secondary-page">
<div class="top-score-title right-score col-md-12">

<?php		
if(isset($fee_payable)){
$team_info = league::get_team($my_reg_team);		
?>		
<form name='tour_reg_fee_pay' method='POST' action='<?=base_url();?>league/fee_pay/<?=$tour_details->tournament_ID;?>'>		
<div class="col-md-12 league-form-bg" style="margin-top:40px; background:#ffff8a; margin-bottom:5px">		
<img src="<?=base_url();?>icons/warning_ico.png" width="30" height="30" border="0" alt="">&nbsp;<span style='font-size:15px;'>		
Your Team <b><?=$team_info['Team_name'];?></b> is participating in this tournament and you were selected by captain. Please pay Fee <b>$<?=$fee_payable;?></b> to participate.&nbsp;&nbsp;&nbsp;</span>		
<input type='submit' name='btn_pay' id='btn_pay' value=' Pay Now ' class="league-form-submit" style='margin-bottom:0px; padding:8px 8px;'/>		
</div>		
</form>		
<?php		
}
?>

<form class='form-horizontal' role='form'>
<div class="col-md-12 league-form-bg" style="margin-top:30px; background:#fff; margin-bottom:20px">

<?php 
$num = $this->uri->segment(6);

if($num == 1) { 
?>
<div class="name" align='left'>
<label for="name_login" style="color:green"><?php echo "You have successfully registered for this tournament.<br />"; ?></label>
</div>
<?php } ?>

<?php 
if(isset($reg_suc)){ ?>
<div class="name" align='left'>
<?php if($reg_suc != 5 and $reg_suc != 1){ ?>
<label for="name_login" style="color:green"><?php echo $reg_suc . "<br />"; ?></label>
<?php } else if($reg_suc != 1){ ?>		
<label for="name_login" style="color:green"><?php echo "Successfully Registered for this Tournament. " . "<br />"; ?></label>		
<?php } ?>
</div>
<?php } ?>

<div class="fromtitle">Tournament Details<!--<div style="clear:both"></div>-->
<div class="fb-like" data-href="<?php echo base_url(); ?>league/view/<?php echo $tour_details->tournament_ID; ?>" data-layout="button" data-mobile-iframe="true" data-action="like" data-show-faces="false" data-share="true"></div>
</div>

<div class='col-md-8'>
<p><label>Tournament:</label> <?php echo $tour_details->tournament_title; ?></p>
<p><label>Organizer:</label> <?php echo $tour_details->OrganizerName; ?></p>
<p><label>Contact #:</label> <?php echo $tour_details->ContactNumber; ?></p>
<p><label>Location:</label> 
<?php if($tour_details->TournamentAddress) { echo $tour_details->TournamentAddress.", "; }?> 
<?php if($tour_details->TournamentCity) { echo $tour_details->TournamentCity.", "; }?>
<?php echo $tour_details->TournamentState.", ";?>
<?php echo $tour_details->PostalCode;?></p>
<p><label>Duration:</label> <?php echo date('m/d/Y',strtotime(substr($tour_details->StartDate,0,10))); ?> - <?php echo date('m/d/Y',strtotime(substr($tour_details->EndDate,0,10))); ?></p>
<p><label>Registration Closes On:</label> <?php echo date ('m/d/Y',strtotime(substr($tour_details->Registrationsclosedon,0,10))); ?></p>
<p><label>Sport:</label> <?php
$get_sport = league::get_sport($tour_details->SportsType);
echo $get_sport['Sportname']; ?>
<input type='hidden' name='sp_type' id='sp_type' value="<?php echo $tour_details->SportsType; ?>" />
</p>
<p><label>Gender:</label> <?php 
if($tour_details->Gender == "all"){ echo "Open to all";} else if($tour_details->Gender == "1"){ echo "Male";}else if($tour_details->Gender == "0"){echo "Female";}else {echo "Not provided";}
?></p>

<p><label>Levels:</label> 

<?php
$level_array = array();
if($tour_details->Sport_levels != "")
{
$level_array = json_decode($tour_details->Sport_levels);
$numItems = count($level_array);

if($numItems > 0)
{
foreach($level_array as $i => $level)
{
$get_level = league::get_level_name($tour_details->SportsType,$level);
echo $get_level['SportsLevel']; 
if(++$i!=count($level_array)){
echo ", ";
}
}
}
}
?>

</p>
<?php 
if($tour_details->SportsType != '4' and $tour_details->tournament_format != 'Teams'){
?>
<p><label>Game Format:</label>
<?php
$match_array = array();

if($tour_details->Singleordouble != "")
{
$match_array = json_decode($tour_details->Singleordouble);
$numItems = count($match_array);

if($numItems > 0)
{
foreach($match_array as $i => $group)
{
echo $group;
if(++$i!=count($match_array)){
echo ", ";
}
}
}
}

?>
</p>
<?php
} ?>

<p><label>Fees:&nbsp;</label>
<?php

if($tour_details->is_mult_fee == 0 and $tour_details->Tournamentfee == 1){
echo "$" .number_format($tour_details->TournamentAmount,2)." (Singles), ". "$" . number_format($tour_details->extrafee,2)." (Additional Format)";
} 
else if($tour_details->is_mult_fee == 1 and $tour_details->Tournamentfee == 1){
	$addln_event = '';
	$pay_type = '';
	if($tour_details->tournament_format != 'Teams'){ 
		$pay_type	 = 'First Event'; 
		$addln_event = '<td>Additional Events</td>'; 
	}
	if($tour_details->Fee_collect_type != '' and $tour_details->tournament_format == 'Teams')
	{ $pay_type = 'Per ' . $tour_details->Fee_collect_type; }

echo "<table class='imagetable' border='1' cellpadding='10' cellspacing = '10'><tr><td>Age Group</td><td> {$pay_type}</td>{$addln_event}</tr>";

$age_grp	= json_decode($tour_details->Age);
$numItems	= count($age_grp);
$i = 0;

if($numItems > 0)
{
$mult_fee_array		  = json_decode($tour_details->mult_fee_collect);
$addn_mult_fee_array  = json_decode($tour_details->addn_mult_fee_collect);

foreach($age_grp as $i=>$ag)
{
echo "<tr><td>";
switch ($ag){
case "U10":
echo "Under 10";
break;
case "U11":
echo "Under 11";
break;
case "U12":
echo "Under 12";
break;
case "U14":
echo "Under 14";
break;
case "U16":
echo "Under 16";
break;
case "U18":
echo "Under 18";
break;
case "Adults":
echo "Adults ";
break;
case "Adults_30p":
echo "30s";
break;
case "Adults_40p":
echo "40s";
break;
case "Adults_50p":
echo "50s";
break;
case "Adults_veteran":
echo "Veteran";
break;
default:
echo "";
}

	$addln_event_fee = '';
	if($tour_details->tournament_format != 'Teams'){ $addln_event_fee = "<td>$addn_mult_fee_array[$i]</td>"; }

echo "</td><td>" . $mult_fee_array[$i] . "</td>{$addln_event_fee}</tr>";
}
}
echo "</table>";
}
else
{
echo "$0.00";
}
?></p>  

<p><label>Age Group:</label> 
<?php 
$option_array = array();
if($tour_details->Age != "")
{
$option_array = json_decode($tour_details->Age);
$numItems = count($option_array);
$i = 0;

if($numItems > 0)
{
foreach($option_array as $group)
{
switch ($group){
case "U10":
echo "Under 10";
break;
case "U11":
echo "Under 11";
break;
case "U12":
echo "Under 12";
break;
case "U14":
echo "Under 14";
break;
case "U16":
echo "Under 16";
break;
case "U18":
echo "Under 18";
break;
case "Adults":
echo "Adults ";
break;
case "Adults_30p":
echo "30s";
break;
case "Adults_40p":
echo "40s";
break;
case "Adults_50p":
echo "50s";
break;
case "Adults_veteran":
echo "Veteran";
break;
default:
echo "";
}

if(++$i!=count($option_array)){
echo ", ";
}
}
}
}
?></p>
<p><label>Bracket Type:&nbsp;</label><?php echo $tour_details->Tournament_type;?></p> 
<p><label>Details and Rules:&nbsp;</label><?php echo html_entity_decode($tour_details->TournamentDescription);?></p> 



<div class="col-md-12" style="padding-left:0px; margin-top:20px" id='draw_details'>


<?php
$users_id = $this->session->userdata('users_id');
$is_reg	  =	league::user_reg_or_not($users_id ,$tour_details->tournament_ID);

$team_captains = array();

if($tour_details->tournament_format == 'Teams'){
$get_reg_team_captains = league::get_tour_registered_teams($tour_details->tournament_ID);
	foreach($get_reg_team_captains as $team){
		$team_captains[$team->Captain] = $team->Team_ID;
	}
}

if($tour_details->Usersid == $users_id)    /// tournament admin access links
{

echo '<div class="col-md-4 txt-torn1" style="padding-left:0px; margin-bottom:20px">
<a href="#div2" id="showdiv2" style="cursor:pointer;">Add Score</a></div>
<div class="col-md-4 txt-torn1" style="padding-left:0px; margin-bottom:20px">
<a href="#div3" id="showdiv3" style="cursor:pointer;">Draws / Results</a></div>';

echo '<div class="col-md-4 txt-torn1" style="padding-left:0px; margin-bottom:20px"><a href="#div4" id="showdiv4"  style="cursor:pointer;">Participants</a></div>';

echo '<div class="col-md-4 txt-torn1" style="padding-left:0px; margin-bottom:20px"><a href="#div5" id="showdiv5"
style="cursor:pointer;">Upload Images</a></div>';

$format = json_decode($tour_details->Singleordouble);

if(in_array("Doubles", $format) or in_array("Mixed", $format))
{
echo '<div class="col-md-4 txt-torn1" style="padding-left:0px; margin-bottom:20px"><a href="#div6" id="showdiv6" style="cursor:pointer;">Change Partners</a></div>';
}
else
{
echo "";
}
echo "<div class='col-md-4 txt-torn1' style='padding-left:0px; margin-bottom:20px'><a style='cursor:pointer;' onclick='myWin_flyer($tour_details->tournament_ID)'>Print Flyer</a></div>";
//echo '<div class="col-md-4 txt-torn1" style="padding-left:0px; margin-bottom:20px"><a   onclick="refresh_blog($tour_details->tournament_ID)" style="cursor:pointer;">View Gallery</a></div>';
echo "<div class='col-md-4 txt-torn1' style='padding-left:0px; margin-bottom:20px'><a onclick='refresh_blog($tour_details->tournament_ID)' style='cursor:pointer;'>View Gallery</a></div>";

echo "<div class='col-md-4 txt-torn1' style='padding-left:0px; margin-bottom:20px'><a href=" . base_url().$this->short_code.
"/league/fixtures/$tour_details->tournament_ID  style='cursor:pointer;'>Create Draws</a></div>";
echo "<div class='col-md-4 txt-torn1' style='padding-left:0px; margin-bottom:20px'><a href=" . base_url().$this->short_code.
"/league/edit/$tour_details->tournament_ID  style='cursor:pointer;'>Edit tournament</a></div>";
echo "<div class='col-md-4 txt-torn1' style='padding-left:0px; margin-bottom:20px'><a href=" . base_url().$this->short_code.
"/play/reg_players/$tour_details->tournament_ID  style='cursor:pointer;'>Register Players</a></div>";
echo "<div class='col-md-4 txt-torn1' style='padding-left:0px; margin-bottom:20px'><a href=" . base_url().$this->short_code. "/play/invite/$tour_details->tournament_ID  style='cursor:pointer;'>Invite Players</a></div>";

}
else if($is_logged_user_reg and !array_key_exists($this->logged_user, $team_captains))
{

echo '<div class="col-md-4 txt-torn1" style="padding-left:0px; margin-bottom:20px">
<a href="#div2" id="showdiv2" style="cursor:pointer;">My Matches</a></div>
<div class="col-md-4 txt-torn1" style="padding-left:0px; margin-bottom:20px">
<a href="#div3" id="showdiv3" style="cursor:pointer;">Draws / Results</a></div>';

echo '<div class="col-md-4 txt-torn1" style="padding-left:0px; margin-bottom:20px"><a href="#div7" id="showdiv7"  style="cursor:pointer;">Participants</a></div>';
echo '<div class="col-md-4 txt-torn1" style="padding-left:0px; margin-bottom:20px"><a href="#div5" id="showdiv5"  style="cursor:pointer;">Upload Images</a></div>';
echo "<div class='col-md-4 txt-torn1' style='padding-left:0px; margin-bottom:20px'><a onclick='refresh_blog($tour_details->tournament_ID)' style='cursor:pointer;'>View Gallery</a></div>";
echo "<div class='col-md-4 txt-torn1' style='padding-left:0px; margin-bottom:20px'><a href=" . base_url().$this->short_code. "/play/invite/$tour_details->tournament_ID  style='cursor:pointer;'>Invite Friends</a></div>";

}
else if(array_key_exists($this->logged_user, $team_captains))
{
echo '<div class="col-md-4 txt-torn1" style="padding-left:0px; margin-bottom:20px">
<a href="#div2" id="showdiv2" style="cursor:pointer;">Add Score</a></div>';

echo '<div class="col-md-4 txt-torn1" style="padding-left:0px; margin-bottom:20px">
<a href="#div3" id="showdiv3" style="cursor:pointer;">Draws / Results</a></div>';

echo '<div class="col-md-4 txt-torn1" style="padding-left:0px; margin-bottom:20px"><a href="#div7" id="showdiv7" style="cursor:pointer;">Participants</a></div>';

echo '<div class="col-md-4 txt-torn1" style="padding-left:0px; margin-bottom:20px"><a href="#div9" id="showdiv9" class="'.$team_captains[$this->logged_user].'" style="cursor:pointer;">Manage Team</a></div>';

echo '<div class="col-md-4 txt-torn1" style="padding-left:0px; margin-bottom:20px"><a href="#div5" id="showdiv5"  style="cursor:pointer;">Upload Images</a></div>';

echo "<div class='col-md-4 txt-torn1' style='padding-left:0px; margin-bottom:20px'><a onclick='refresh_blog($tour_details->tournament_ID)' style='cursor:pointer;'>View Gallery</a></div>";

echo "<div class='col-md-4 txt-torn1' style='padding-left:0px; margin-bottom:20px'><a href=" . base_url() . "play/invite/$tour_details->tournament_ID  style='cursor:pointer;'>Invite Friends</a></div>";
}
else
{
$now		=  strtotime("now"); $oneday = 86400;
$reg_close	= strtotime($tour_details->Registrationsclosedon) + $oneday;

if($now < $reg_close){
echo "<div class='col-md-4 txt-torn1' style='padding-left:0px; margin-bottom:20px'><a href=" . base_url().$this->short_code. "/league/register_match/$tour_details->tournament_ID  style='cursor:pointer;'>Register</a></div>";
}
echo '<div class="col-md-4 txt-torn1" style="padding-left:0px; margin-bottom:20px">
<a href="#div3" id="showdiv3" style="cursor:pointer;">Draws / Results</a></div>';

echo '<div class="col-md-4 txt-torn1" style="padding-left:0px; margin-bottom:20px"><a href="#div7" id="showdiv7"  style="cursor:pointer;">Participants</a></div>';
echo "<div class='col-md-4 txt-torn1' style='padding-left:0px; margin-bottom:20px'><a onclick='refresh_blog($tour_details->tournament_ID)' style='cursor:pointer;'>View Gallery</a></div>";
}	
?>
</div>
</div>

<div class='col-md-4'>
<!-- <a href="http://www.facebook.com/share.php?u=<url>" onclick="return fbs_click()" target="_blank"> -->
<img class="scale_image" src="<?php echo base_url(); ?>tour_pictures/<?php if($tour_details->TournamentImage!=""){ echo $tour_details->TournamentImage; }
else if($tour_details->SportsType == 1){echo "default_tennis.jpg"; }
else if($tour_details->SportsType == 2){echo "default_table_tennis.jpg"; }
else if($tour_details->SportsType == 3){echo "default_badminton.jpg"; }
else if($tour_details->SportsType == 4){echo "default_golf.jpg"; }
else if($tour_details->SportsType == 5){echo "default_racquet_ball.jpg"; }
else if($tour_details->SportsType == 6){echo "default_squash.jpg"; }
else if($tour_details->SportsType == 7){echo "default_pickleball.jpg"; }
else if($tour_details->SportsType == 8){echo "default_chess.jpg"; }
else if($tour_details->SportsType == 9){echo "default_carroms.jpg"; }
?>" alt=""  />
<!-- </a> -->
</div>
<!--<div class="col-md-3" style="padding-right:50px">
<div class="fb-share-button" data-href=" . base_url() . "<?php echo $tour_details->tournament_ID; ?>" data-layout="button" data-mobile-iframe="true"></div>
</div>-->
</form>

</div>

<!---------------------------------------------------Add Score -----------------------------------------------------> 
<div class="col-md-12 league-form-bg" style="margin-top:40px; background:#fff; margin-bottom:20px; display:none;" id="div2">
<?php if($this->logged_user){ ?>
<div class="fromtitle">Add Scores</div>

<table class="tab-score">
<?php 
$brackets = league::get_bracket_list($tour_details->tournament_ID);

if(count(array_filter($brackets)) > 0){  ?>
<!-- <tr class="top-scrore-table">
<th width="15%">Draw Title</th>
<th width="15%">Match Type</th>
<th width="15%">Age Group</th>
<th width="15%">Action</th> 
</tr> -->
	<?php 
$check_user = 1;
$is_no_draws = 0;

foreach($brackets as $bk)
{

if($tour_details->Usersid != $users_id and $users_id){
	if($this->is_team_league){
		$check_user = league::check_team_is_user_exists($tour_details->tournament_ID, $bk->BracketID, $tour_details->SportsType);
	}
	else{
		$check_user = league::check_is_user_exists($tour_details->tournament_ID, $bk->BracketID, $tour_details->SportsType);
	}
}

		if($check_user){
?>

<tr>
<form id="your_form" action="<?php echo base_url().$short_code."/";?>league/view_matches" method="post">

<td>&nbsp;<b><?php echo $bk->Draw_Title; ?> </b></td>
<td><b><?php echo '<input type="submit" name="list_draw_matches'.$bk->BracketID.'" id="list_draw_matches'.$bk->BracketID.'" value="Show Matches" class="league-form-submit1" />'; ?></b></td>

<input type='hidden' name='tourn_id' value="<?php echo $tour_details->tournament_ID; ?>">
<input type='hidden' name='tourn_type' value = "<?php echo $bk->Bracket_Type; ?>">
<input type='hidden' name='match_type' value="<?php echo $bk->Match_Type; ?>">
<input type='hidden' name='age_group' value="<?php echo $bk->Age_Group; ?>">
<input type='hidden' name='bracket_id' value="<?php echo $bk->BracketID; ?>">
<input type='hidden' name='tour_admin' value="<?php echo $tour_details->Usersid;?>">
<input type='hidden' name='tformat'	   value = "<?php echo $tour_details->tournament_format;?>" />
</form>
</tr>
<?php
$is_no_draws++;
}
}

if($is_no_draws == 0)
{
echo "<tr><td>You are not part of any Draws to Add Score!</td></tr>";
}
}
else
{
echo "<tr><td>No Draws are available</td></tr>";
}
?>
</table>
<?php
} ?>
</div>

<br /><br />

<!---------------------------------------------------Admin view for Participants----------------------------------------------------->        


<div class="col-md-12 league-form-bg" style="margin-top:40px; background:#fff; margin-bottom:20px; display:none;" id="div4">
<div class="fromtitle">Participants</div>
<?php
if($tour_details->tournament_format != 'Teams'){
$this->load->view('academy_views/tournament/view_adm_participants');  // Load Participants view 
}
else{
$this->load->view('academy_views/teams/view_adm_team_participants');  // Load Participants view 
}
?>
</div>

<!------------------------------------------------Draws / Results------------------------------------------------------ -->        

<div class="col-md-12 league-form-bg" style="margin-top:40px; background:#fff; margin-bottom:20px; display:none;" id="div3">
<div class="fromtitle">Draws / Results</div>

<table class="tab-score">
<?php 
$brackets = league::get_bracket_list($tour_details->tournament_ID);

if(count(array_filter($brackets)) > 0){  ?>
<!-- <tr class="top-scrore-table">

 <th width="15%">Draw Title</th>
<th width="15%">Match Type</th>
<th width="15%">Age Group</th>
<th width="15%">Action</th> 
</tr> -->
	<?php foreach($brackets as $bk)
    {
?>

<tr>
<form id="your_form" action="<?php echo base_url().$short_code."/"; ?>viewbracket/" method="post">

<td>
<b><?php echo $bk->Draw_Title; ?> </b>
</td>
<td>
<b><?php //echo $bk->Match_Type; ?> </b>
</td>
<td>
<b><?php //echo $bk->Age_Group; ?> </b>
</td>

<td>
<b><?php echo '<input type="submit" name="tour_draw_show'.$bk->BracketID.'" id="submit" value="Show Draws" class="league-form-submit1"/>'; ?> </b>
&nbsp;&nbsp;
<?php $users_id = $this->session->userdata('users_id');
if($tour_details->Usersid == $users_id)    /// tournament admin access links
{ ?>
<b><?php echo '<input type="submit" name="tour_draw_delete'.$bk->BracketID.'" id="delete" value="Delete Draws" class="league-form-submit1"/>'; ?> </b>
<?php }
?>
</td>

<input type='hidden' name='tourn_id' value="<?php echo $tour_details->tournament_ID; ?>">
<input type='hidden' name='template' value="view_tournament">
<input type='hidden' name='tourn_type' value = "<?php echo $bk->Bracket_Type; ?>">
<input type='hidden' name='match_type' value="<?php echo $bk->Match_Type; ?>">
<input type='hidden' name='age_group' value="<?php echo $bk->Age_Group; ?>">
<input type='hidden' name='bracket_id' value="<?php echo $bk->BracketID; ?>">
<input type='hidden' name='tour_admin' value="<?php echo $tour_details->Usersid;?>">

</form>
</tr>
<?php
    }

 }else
 {
	echo "<tr><td>No Draws are available</td></tr>";
 }
?>
</table>

</div>

<!-- ------------------------------------------------Upload Tournament Images----------------------------------------------------  -->   

<div class="col-md-12 league-form-bg" style="margin-top:40px; background:#fff; margin-bottom:20px; display:none;" id="div5">
<div class="fromtitle">Upload Tournament Images</div>

<form method='post' enctype='multipart/form-data' action="<?php echo base_url().$short_code; ?>/league/upload_pics" role='form' >
<div class='file_upload' id='f1'><input name='userfile[]' type='file' multiple='multiple' onchange='readURL(this);'/></div>
<br />
<!-- <div id='file_tools'>
<input type="button" value="Add File" name="upload_image" id="add_file" class="league-form-submit1"/>&nbsp;&nbsp;&nbsp;&nbsp;
<input type="button" value="Delete File" name="delete_image" id="del_file" class="league-form-submit1"/>
</div> -->
<br />
<input type='hidden' name='tourn_id' value="<?php echo $tour_details->tournament_ID; ?>">
<input type='submit' name='upload_image' value='Upload' class="league-form-submit1"/>
</form>

</div>

<!-- ----------------------------------------------------------------------------------------------------  -->        


<!-- ---------------------------------------------Tournament Players update-------------------------------------------------------  -->   

<div class="col-md-12 league-form-bg" style="margin-top:40px; background:#fff; margin-bottom:20px; display:none;" id="div6">
<div class="fromtitle">Tournament Players update</div>
<div class='form-group'>
<?php
$mfs = array();
$mfs = json_decode($tour_details->Singleordouble);

$get_mf_type = '';
if(in_array('Doubles', $mfs)){ $get_mf_type = 'Doubles'; }
else if(in_array('Mixed', $mfs)){ $get_mf_type = 'Mixed'; }

$tourn_partner_names = league::get_reg_tourn_partner_names($tour_details->tournament_ID, $get_mf_type);

if($tourn_partner_names){
?>
<form method='post' enctype='multipart/form-data' action="<?php echo base_url().$short_code."/"; ?>update_players" role='form'>
<div class='col-md-3 control-label'>
<select class="form-control" id="mf_filter" name="mf_filter">
<!-- <option value="">Select</option> -->
<?php
$match_format = "";
if($this->input->post('mf_filter')){
$sel_mf = $this->input->post('mf_filter');
}
?>
<?php foreach($mfs as $mf){ 
if($mf != 'Singles'){?>
<option value="<?php echo $mf;?>" <?php if($sel_mf == $mf){ echo "selected=selected"; } ?> ><?php echo $mf; ?></option>
<?php }
} ?>
</select>
</div>

<div class='col-md-10'>
<br /><br />

<div id="dbl-load-users" style="overflow-y: scroll;">
<table class="tab-score">
<?php
$abc = $tourn_partner_names;
if(count(array_filter($tourn_partner_names)) > 0) {
?>
<tr class="top-scrore-table">
<!-- <th width="5%" class="score-position">Select</th> -->
<td width="15%">Name</td>
<td width="15%">Partner</td>
<td width="15%">Select</td>
<!-- <th width="15%">Age Group</th> -->
</tr>
<?php
if($get_mf_type == 'Doubles'){ $partner_type = 'Partner1'; }
else if($get_mf_type == 'Mixed'){ $partner_type = 'Partner2'; }

foreach($tourn_partner_names as $name)
{
?>
<tr>
<!-- <td>
<input class="checkbox1" type="checkbox" id='chk<?php echo $name->Users_ID; ?>' name="sel_player[]" value="<?php //echo $name->Users_ID;?>" />
</td> -->
<td><?php 
$player = league::get_username($name->Users_ID);
echo "<b>" . $player['Firstname']." ".$player['Lastname'] . "</b>";
?>
<input type='hidden' name = 'player_<?php echo $name->Users_ID; ?>' id = 'player_<?php echo $name->Users_ID; ?>' value = "<?php echo $name->Users_ID; ?>" />
</td>
<td>
<?php
if($name->$partner_type){
$partner = league::get_username($name->$partner_type);
echo "<b>" . $partner['Firstname']." ".$partner['Lastname'] . "</b>";
} ?>
</td>
<td>
<select id='sel<?php echo $name->Users_ID; ?>' name='upd_sel_partner[]' class='double_partner'>   <!-- disabled='disabled'> -->
<option value=''>Select</option>
<?php	
foreach($tourn_partner_names as $pname){
if($pname->Users_ID){
$partner_div = league::get_username($pname->Users_ID);
?>
<option value='<?php echo $pname->Users_ID; ?>'>
<?php echo $partner_div['Firstname']." ".$partner_div['Lastname']; ?>
</option>
<?php
}
}
?>
</select>
</td>
<!-- <td><?php //echo $name->Reg_Age_Group; ?></td> -->
</tr>
<?php
}
}
else {
?>
<tr><td colspan='6'><b>No players are registered yet. </b></td></tr>
<?php } ?>
</table>
</div>  
</div>
<input type='hidden' id="tourn_id"  name='tourn_id' value="<?php echo $tour_details->tournament_ID; ?>">
<input type='hidden' id='tourn_type' name='tourn_type' value = "<?php echo $tour_details->Tournament_type; ?>"> 
</form>
<?php
}
else{
?>
<table class="tab-score">
<tr><td colspan='6'><b>Draws are already generated. Could not change the player's partner </b></td></tr>
</table>
<?php
}
?>

</div>
</div>

<!-- ----------------------------------------------------------------------------------------------------  -->   

<!-- ------------------------------------------------Participants----------------------------------------  -->   

<div class="col-md-12 league-form-bg" style="margin-top:40px; background:#fff; margin-bottom:20px; display:none;" id="div7">
<div class="fromtitle" style="padding-left:40px;">Tournament Participants</div>

<form method="post" id="your_form"  action="<?php echo base_url(); ?>" class="register-form"> 
<?php
if($tour_details->tournament_format != 'Teams'){
$this->load->view('academy_views/tournament/view_participants');  // Load Participants view 
}
else{
$this->load->view('academy_views/teams/view_team_participants');  // Load Participants view 
}
?>
<input type='hidden' id="tourn_id"  name='tourn_id' value="<?php echo $tour_details->tournament_ID; ?>">
<input type='hidden' id='tourn_type' name='tourn_type' value = "<?php echo $tour_details->Tournament_type; ?>">
<input type='hidden' id='sport' name='sport' value="<?php echo $tour_details->SportsType; ?>" />
</form>
</div>

<!-- ----------------------------------------------------------------------------------------------------  -->    

<!-- -----------------------------------------------view gallery link section ---------------------------  -->   

<div class="col-md-12 league-form-bg" style="margin-top:40px; background:#fff; margin-bottom:20px;display:none;" id="div8">
<div id="blog_container">
<div class="fromtitle" style="padding-left:40px;"><?php echo $tour_details->tournament_title; ?> - Photo Gallery</div>

<?php 
if(isset($get_images))
{
foreach($get_images as $i => $row) { ?>

<div class="col-md-3" style="margin-top:30px;">
<a href="<?php echo base_url(); ?>tour_pictures/<?php echo $row->Tournament_id; ?>/<?php if($row->Image_file!=""){echo $row->Image_file; }
else { echo "";} ?>">
<img class="img-responsive" src="<?php echo base_url(); ?>tour_pictures/<?php echo $row->Tournament_id; ?>/<?php if($row->Image_file!=""){echo $row->Image_file; }
else { echo "";} ?>" alt="" height="205px" width="205px" />
</a>
<input type="hidden" value="<?php echo base_url();?>tour_pictures/<?php echo $row->Tournament_id;?>/<?php echo $row->Image_file;?>" name="filename<?=$i;?>" id="image">

<br />
</div>

<?php } 
}
else {
echo "<b>No Images are uploaded yet.</b>";
}
?> 
</div>
</div>

<!-- ------------------------------------------------view gallery link section end----------------------------------------------------  --> 

<div class="col-md-12 league-form-bg" style="margin-top:40px; background:#fff; margin-bottom:20px; display:none;" id="div9">
<!-- ------------------------------------------------ Manage Tournament Participation Team -------------------------------------------  --> 
</div>

<?php
/*echo "<pre>";
print_r($get_rr_tourn_matches);
exit;*/

if(isset($no_bracket)) { ?>
<div class="name" align='left' id="no_result">

<label for="name_login" style="color:red"><?php 
echo $no_bracket; 
unset($no_bracket);
?></label>
</div>
<?php } 
else if(isset($bracket_matches) or isset($get_tourn_matches) or isset($rr_bracket_matches) or isset($get_rr_tourn_matches) or isset($bracket_matches_main) or isset($golf_bracket_matches) or isset($get_golf_tourn_matches) or isset($golf_tourn_matches))
{
?>
<div class="col-md-12 league-form-bg" id="div22">
<div class="general general-results players" >
<div class="" id="">

<!-- --------------------------------------------- -->
<?php
if(isset($bracket_matches)){
	$this->load->view('view_se_addscore');
}

else if(isset($bracket_matches_main) && isset($bracket_matches_cd)){
	$this->load->view('view_cd_addscore');
}

else if(isset($get_tourn_matches) && !isset($get_cd_tourn_matches)){
	$this->load->view('view_se_draws');
}

else if(isset($get_tourn_matches) && isset($get_cd_tourn_matches)){
	$this->load->view('view_cd_draws');
}

else if(isset($rr_bracket_matches) and !isset($rr_line_matches)){
	$this->load->view('view_rr_addscore');
}

else if(isset($get_rr_tourn_matches) and !isset($get_rr_line_matches)){
	$this->load->view('view_rr_draws');
}

else if(isset($golf_bracket_matches)){
	$this->load->view('view_golf_addscore');
}

else if(isset($golf_tourn_matches)){
	$this->load->view('view_golf_draws');
}


else if(isset($get_rr_tourn_matches) and isset($get_rr_line_matches)){
	$this->load->view('academy_views/teams/view_team_rr_draws');
}

else if(isset($rr_bracket_matches) and isset($rr_line_matches)){
	$this->load->view('academy_views/teams/view_team_rr_addscore');
}
?>
</div>
<!--
<form id="your_form" action="<?php echo base_url(); ?>league/pdf/<?php echo $tourn_id; ?>" method="post">
<input type='hidden' name='users[]' value="<?php print_r($this->input->post('users'));?>">
<input type="submit" class="league-form-submit1" name="capture" id="restore" value="Print" />
</form>
-->
</div>
</div>

<!-- ------------------------------------------------------------------------------------------------------------- -->

</div><!--Close Top Match-->
<?php
}
?>
</div>
</section>
<br />