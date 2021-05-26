<script src="<?php echo base_url();?>js/jquery.accordion.js" type="text/javascript"></script>

<script src="http://code.jquery.com/jquery-1.9.1.js"></script>
<script>
$(document).ready(function(){
var baseurl = "<?php echo base_url(); ?>";
});

/*$(document).ready(function () {
$(function () {
"use strict";
$('.accordion').accordion({ defaultOpen: 'section' }); //some_id section1 in demoup_tour_section
});
});*/
</script>

<script>
$(document).ready(function(){
var baseurl = "<?php echo base_url(); ?>";

$('.edit_score').on('click',function(){

var tab_row_id = $(this).attr('name');
//alert (tab_row_id);
$("#forfeit"+tab_row_id).hide();
$("#wff_score").attr('checked', false);

if(tab_row_id!=""){
$.ajax({
type:'POST',
url:baseurl+'league/get_tour_row_info/',
data:{ row_id:tab_row_id},
success:function(html){

var res = html.split('#');

$('#tourn_match_id').val(res[0]);
$('#bracket_id').val(res[1]);

$('#tournid').val(res[2]);
$('#match_num').val(res[4]);

$('#player1_user').val(res[5]);
$('#player2_user').val(res[6]);

if(res[12] || res[13]){
	var p1= res[10]+"; "+res[12];
	var p2= res[10]+"; "+res[13];
	$('#player1_name').html(p1);
	$('#player2_name').html(p2);
}
else{
	$('#player1_name').html(res[10]);
	$('#player2_name').html(res[11]);
}
var p1_score = "";
var p2_score = "";
if(res[14] != "" && res[14] != "Bye Match" && res[14] != 'NULL')
{
var x = res[14].slice(1, -1);
var y = res[15].slice(1, -1);

var p1_score = x.split(',');
var p2_score = y.split(',');

for($i=0; $i<p1_score.length; $i++){
$('#set1_'+($i+1)+'_'+res[0]).val(p1_score[$i]);
//$('#mset1_'+($i+1)+'_'+res[0]).val(p1_score[$i]);
}

for($j=0; $j<p2_score.length; $j++){
$('#set2_'+($j+1)+'_'+res[0]).val(p2_score[$j]);
//$('#mset2_'+($j+1)+'_'+res[0]).val(p2_score[$j]);
}
}

var dateArr = res[16].split('-');
$('#edate'+res[0]).val(dateArr[1]+"/"+dateArr[2]+"/"+dateArr[0]);
$('#escore'+res[0]).show();
}
}); 
}

});

});
</script>

<!-- ------------------------Add Score without page redirect-------------------------- -->

<script>
$(document).ready(function(){

var baseurl = "<?php echo base_url(); ?>";

$('.wff_add').click(function (e) {

var id_val = $(this).attr('id');

$.ajax({
type: 'POST',
url: baseurl+'league/view_matches',
data: $('#form-wff'+id_val).serialize(),
success: function (res) {
//location.reload();
alert("Result, added successfully!");

   $('#forfeit'+id_val).hide();
   $('#tr_'+id_val).html(res);
}
});
e.preventDefault();

});
});
</script>

<script>
$(document).ready(function(){

var baseurl = "<?php echo base_url(); ?>";

$('.add_score_ajax').click(function (e) {

var id_val = $(this).attr('id');

$.ajax({
type: 'POST',
url: baseurl+'league/view_matches',
data: $('#form-addscore'+id_val).serialize(),
success: function (res) {
//location.reload();
alert("Scores, added successfully!");

   $('#score'+id_val).hide();
   $('#tr_'+id_val).html(res);
}
});
e.preventDefault();

});

$(".add_score").click(function(){
	//alert('testaa');
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

});
</script>

<script>
$(document).ready(function(){

var baseurl = "<?php echo base_url(); ?>";

$('.edit_score_ajax').click(function (e) {

var id_val = $(this).attr('id');

$.ajax({
type: 'POST',
url: baseurl+'league/view_matches',
data: $('#form-editscore'+id_val).serialize(),
success: function (res) {
//location.reload();
alert("Scores, updated successfully!");

   $('#escore'+id_val).hide();
   $('#tr_'+id_val).html(res);
}
});
e.preventDefault();

});

$('.wff_score').click(function() {
var pid2 = $(this).attr('name');

if($("#forfeit"+pid2).css('display')=='none'){
$("#forfeit"+pid2).show();
$("#score"+pid2).hide();
$("#escore"+pid2).hide();
//$("#comment"+pid).hide();
}
else{
$("#forfeit"+pid2).hide();
$("#score"+pid2).hide();
$("#escore"+pid2).hide();
//$("#comment"+pid).hide();
}

});

});
</script>

<!-- -------------------------------------------------------------------------------- -->

<?php
$tourn_id		= $get_bracket_details['Tourn_ID'];
$round_matches	= $bracket_matches->result();
$logged_user	= $this->logged_user;
$tourn_admin	= $tour_details->Usersid;

$total_rounds	=	$get_bracket_details['No_of_rounds'];
$tourn_id		=	$get_bracket_details['Tourn_ID'];
$sess_id		=	$this->session->userdata('users_id');
?>
<div>
<h4 style="color:#f59123"><b><?php echo $get_bracket_details['Draw_Title']; ?></b></h4>
</div>

<div class="tab-content">
<?php
if(!empty($round_matches)){

$nm = 0;
$round_type = array();
for($round = 1; $round <= $total_rounds; $round++){
foreach($round_matches as $m => $match){
if($round_matches[$m]->Round_Num==$round){
$nm++;
}
}
$round_type[$round] = $nm;
$nm = 0;
}


for($round = 1; $round <= $total_rounds; $round++){

$rt = $round_type[$round];

if($rt >= pow(2,3)){
$rrt	 = $rt*2;
$rd_type = "Round of $rrt";
}
else{
switch($rt){
case 1:
$rd_type = "Final";
break;
case 2:
$rd_type = "Semi-Final";
break;
case 4:
$rd_type = "Quarter-Final";
break;
default:
$rd_type = "---";
break;
}
}
echo "<div class='accordion' id='section' style='background:#f59123; padding:5px; color:white;'><i class='fa fa-arrow-circle-o-right' style='color:white;'> </i><b>$rd_type</b><span></span></div>";
?>

<table class="tab-score">

<tr class="top-scrore-table">
<td class="score-position" valign="center" align="center">Team1</td>
<td class="score-position" valign="center" align="center">Team2</td>
<!-- <td class="score-position" valign="center" align="center">Points</td> -->
<td class="score-position" valign="center" align="center"></td>
</tr>

<?php
foreach($round_matches as $m => $match){
$player1 = "";
$player2 = "";

if($round_matches[$m]->Round_Num==$round){

if($round_matches[$m]->Player1 != 0){
$player1 = league::get_team(intval($round_matches[$m]->Player1));
}
if($round_matches[$m]->Player2 != 0){
$player2 = league::get_team(intval($round_matches[$m]->Player2));
}

$tm_id = $round_matches[$m]->Tourn_match_id;
?>
<tr id='tr_<?=$tm_id;?>'>
<?php 
$get = league::getonerow($round_matches[$m]->Tourn_ID);
$tourn_admin = $get->Usersid;
$winner_medal_p1 = "";
$winner_medal_p2 = "";
?>
<td valign="center" style="padding-left:15px;"><b>
<?php
$player1_points		= ($round_matches[$m]->Player1_points != NULL) ? $round_matches[$m]->Player1_points : '0';
$player2_points		= ($round_matches[$m]->Player2_points != NULL) ? $round_matches[$m]->Player2_points : '0';

if($round_matches[$m]->Winner == $round_matches[$m]->Player1){
$winner_medal_p1	= "<img id='img-winner' src='".base_url()."images/gold_medal_small.png' width='20' height='20'></img>";
}
if($round_matches[$m]->Winner == $round_matches[$m]->Player2){
$winner_medal_p2	= "<img id='img-winner' src='".base_url()."images/gold_medal_small.png' width='20' height='20'></img>";
//	Swaping the points, to Display the points on winner perspectively
$temp 				= $player1_points;
$player1_points		= $player2_points;		
$player2_points		= $temp;
}

if($player1){ echo "<a style='text-decoration:none;'>".$player1['Team_name']."</a>".$winner_medal_p1; } else { echo "----"; }
?></b></td>

<td valign="center" style="padding-left:15px;"><b>
<?php
if($player2){ echo "<a style='text-decoration:none;'>".$player2['Team_name']."</a>".$winner_medal_p2; } else { echo "----"; }
?></b></td>

<!-- <td style="padding-left:15px;">(<?=$player1_points;?> - <?=$player2_points;?>)</td> -->

<?php
if($round_matches[$m]->Winner == ''){
?>
<td valign="center" style="padding-left:15px;">
<div>
<a id="add" class="add_score" href="#reg_matches" name="<?php echo $round_matches[$m]->Tourn_match_id; ?>">Add score</a> 
</div>
</td>
<?php 
}
else{
?>
<td style="padding-left:15px;">
<?php 
if($round_matches[$m]->Player1_Score !=""){
$p1=array();$p2=array();
$p1 = json_decode($round_matches[$m]->Player1_Score);
$p2 = json_decode($round_matches[$m]->Player2_Score);

$cnt  = count(array_filter($p1));
$cnt2 = count(array_filter($p2));

if($cnt > 0){
for($i=0; $i<count(array_filter($p1)); $i++){
echo "($p1[$i] - $p2[$i]) ";
}
}
else if($cnt2 > 0){	
for($i=0; $i<count(array_filter($p2)); $i++){
echo "($p1[$i] - $p2[$i]) ";
}
}
else if($cnt == 0 and $round_matches[$m]->Player1_Score != "Bye Match" and $round_matches[$m]->Player2_Score != "Bye Match"){
echo "Win by Forfeit ";
}
}

if($tourn_admin  == $sess_id and ($round_matches[$m]->Player1_Score != "Bye Match" and $round_matches[$m]->Player2_Score != "Bye Match")){
?>
<?php  echo "\t"; ?>
<img src='<?php echo base_url()."images/ico-images/Edit.png"; ?>' id='<?php echo $round_matches[$m]->Tourn_match_id; ?>' class='edit_score img-winner' href='#edit_score' name='<?php echo $round_matches[$m]->Tourn_match_id; ?>'   style='cursor:pointer;width:20px;height:20px' />
<?php }
else if($round_matches[$m]->Player1_Score == "Bye Match" and $round_matches[$m]->Player2_Score == "Bye Match"){
echo "Bye Match";
}
?>

</td>
<?php } ?>

</tr>

<!--  Add, wff, Edit Score blocks -->
<!------------Win By forfeit-------------------->
<tr id="forfeit<?php echo $round_matches[$m]->Tourn_match_id; ?>" style="display:none;">
<td colspan='6'>
<!-- <form method="post"  action="<?php echo base_url();?>league/view_matches"> -->
<form name="form-wff" id="form-wff<?php echo $round_matches[$m]->Tourn_match_id; ?>">
<div class='form-group'>
<div class='col-md-3 form-group internal'>
<?php
$get_name = league::get_team(intval($round_matches[$m]->Player1)); 
$team1 = $get_name['Team_name'];
?>
<?php 
$get_name = league::get_team(intval($round_matches[$m]->Player2));
$team2 =  $get_name['Team_name'];
?>
<select name="id" class='form-control'>
<option value="<?php echo $round_matches[$m]->Player1; ?>">
<?php echo $team1; ?>
</option>
<option value="<?php echo $round_matches[$m]->Player2; ?>">
<?php echo $team2; ?>	
</option>
</select> 
</div>
</div>
<input class='form-control' value="TS_SE_WFF" name="score_type" type='hidden' /> 
<input class='form-control' value="<?php echo $round_matches[$m]->Tourn_ID;?>" id="tourn_id" name="tourn_id" type='hidden' /> 
<input class='form-control' value="<?php echo $round_matches[$m]->BracketID;?>" id="bracket_id" name="bracket_id" type='hidden' />
<input class='form-control' value="<?php echo $round_matches[$m]->Match_Num;?>" id="match_num" name="match_num" type='hidden' /> 
<input class='form-control' value="<?php echo $match_type;?>" id="match_type" name="match_type" type='hidden' /> 
<input class='form-control' value="<?php echo $round_matches[$m]->Tourn_match_id;?>" id="tourn_match_id" name="tourn_match_id" type='hidden' />

<input class='form-control' value="<?php echo $round_matches[$m]->Round_Num;?>" id="round_num" name="round_num" type='hidden' />
<input class='form-control' value="<?php echo $rd_type;?>" id="round_title" name="round_title" type='hidden' />
<input class='form-control' value="" id="" name="draw_name" type='hidden' />

<input class='form-control' value="<?php echo $round_matches[$m]->Player1;?>" id="tourn_match_id" name="player1" type='hidden' />
<input class='form-control' value="<?php echo $round_matches[$m]->Player1_Partner;?>" id="tourn_match_id" name="player1_partner" type='hidden' />
<input class='form-control' value="<?php echo $round_matches[$m]->Player2;?>" id="tourn_match_id" name="player2" type='hidden' />
<input class='form-control' value="<?php echo $round_matches[$m]->Player2_Partner;?>" id="tourn_match_id" name="player2_partner" type='hidden' />

<div class='form-group'>
<div class='col-md-1 form-group internal'>
<input type="submit" name="se_add_winner" id="<?php echo $round_matches[$m]->Tourn_match_id; ?>" value="Add Winner" class="wff_add league-form-submit1" />
</div>
</div>

</form>
</td>
</tr>

<!----------End of--Win By forfeit-------------------->

<tr id="score<?php echo $round_matches[$m]->Tourn_match_id; ?>" class="tourn_match" style="display:none;">
<td colspan='6'>
<div>

<!-- <form method="post" action="<?php echo base_url();?>league/view_matches"> -->
<form name="form-addscore" id="form-addscore<?php echo $round_matches[$m]->Tourn_match_id; ?>">

<div class='form-group'>
<div class='col-md-2 form-group internal'>
<input type="text" class='form-control' placeholder="Date" id="sdate<?php echo $round_matches[$m]->Tourn_match_id; ?>" name="tour_match_date" value="<?php echo date("m/d/Y"); ?>" required />
</div>
<script>
$(function() {
var spid = "<?php echo $round_matches[$m]->Tourn_match_id; ?>";
$('#sdate'+spid).datepick();
});
</script>

<div class='form-group'>
<div class='col-md-8 form-group internal scoretable-web'>

<input type='checkbox' name="<?php echo $round_matches[$m]->Tourn_match_id; ?>" id='wff_add' class='wff_score' />&nbsp;Declare winner by Win by Forfeit
<?php
$get_sport = league::getonerow($tourn_id);
$sport_id = $get_sport->SportsType;
?>
<table class="score-cont">
<?php if($sport_id == 1){ ?>
<tr>
<th>Players</th>
<th>Set1</th>
<th>Set2</th>
<th>Set3</th>
<th>Set4</th>
<th>Set5</th>
<!-- <th>Set6</th> -->
</tr> 
<?php } else { ?>
<tr>
<th>Players</th>
<th>Game1</th>
<th>Game2</th>
<th>Game3</th>
<th>Game4</th>
<th>Game5</th>
<!-- <th>Game6</th> -->
</tr> 
<?php } ?>
<tr>
<td bgcolor="#fdd7b0"><b><?php echo $team1;	?></b></td>
<td><input id='set1_1' name='player1[]' style = "width:65%" type='text' maxlength='2' /></td>
<td><input id='set1_1' name='player1[]' style = "width:65%" type='text' maxlength='2' /></td>
<td><input id='set1_1' name='player1[]' style = "width:65%" type='text' maxlength='2' /></td>
<td><input id='set1_1' name='player1[]' style = "width:65%" type='text' maxlength='2' /></td>
<td><input id='set1_1' name='player1[]' style = "width:65%" type='text' maxlength='2' /></td>
<!-- <td><input id='set1_1' name='player1[]' style = "width:65%" type='text' maxlength='2' /></td> -->
</tr>
<tr>
<td bgcolor="#fdd7b0"><b><?php echo $team2; ?></b></td>
<td><input id='set1_2' name='player2[]' style = "width:65%" type='text' maxlength='2' /></td>
<td><input id='set1_2' name='player2[]' style = "width:65%" type='text' maxlength='2' /></td>
<td><input id='set1_2' name='player2[]' style = "width:65%" type='text' maxlength='2' /></td>
<td><input id='set1_2' name='player2[]' style = "width:65%" type='text' maxlength='2' /></td>
<td><input id='set1_2' name='player2[]' style = "width:65%" type='text' maxlength='2' /></td>
<!-- <td><input id='set1_2' name='player2[]' style = "width:65%" type='text' maxlength='2' /></td>-->
</tr>
</table>
</div>
</div>

<!-- ---------------Mobile view------------------------------------------------------- -->
<div class="scoretable-mob">
<table class="score-cont">
<tr>
<th>Players</th>
<th bgcolor="#fdd7b0"><b><?php echo $team1; ?></b></th>
<th bgcolor="#fdd7b0"><b><?php echo $team1; ?></b></th>
<?php if($sport_id == 1){
$set_or_game = 'Set';
}
else
{
$set_or_game = 'Game';
}
?>
</tr>
<tr>
<td>
<?php echo $set_or_game . "1"; ?>
</td>
<td><input id='set1_1' name='player1[]' style = "width:45%" type='text' maxlength='2' /></td>
<td><input id='set1_2' name='player2[]' style = "width:45%" type='text' maxlength='2' /></td>
</tr>
<tr>
<td>
<?php echo $set_or_game . "2"; ?>
</td>
<td><input id='set2_1' name='player1[]' style = "width:45%" type='text' maxlength='2' /></td>
<td><input id='set2_2' name='player2[]' style = "width:45%" type='text' maxlength='2' /></td>
</tr>
<tr>
<td>
<?php echo $set_or_game . "3"; ?>
</td>
<td><input id='set3_1' name='player1[]' style = "width:45%" type='text' maxlength='2' /></td>
<td><input id='set3_2' name='player2[]' style = "width:45%" type='text' maxlength='2' /></td>
</tr>
<tr>
<td>
<?php echo $set_or_game . "4"; ?>
</td>
<td><input id='set4_1' name='player1[]' style = "width:45%" type='text' maxlength='2' /></td>
<td><input id='set4_2' name='player2[]' style = "width:45%" type='text' maxlength='2' /></td>
</tr>
<tr>
<td>
<?php echo $set_or_game . "5"; ?>
</td>
<td><input id='set5_1' name='player1[]' style = "width:45%" type='text' maxlength='2' /></td>
<td><input id='set5_2' name='player2[]' style = "width:45%" type='text' maxlength='2' /></td>
</tr>

</table>
</div>

<!-- ---------------Mobile view------------------------------------------------------- -->
<input class='form-control' value="TS_SE_ADDSCORE" name="score_type" type='hidden' /> 
<input class='form-control' value="<?php echo $round_matches[$m]->Player1;?>" id="player1_user" name="player1_user" type='hidden' />
<input class='form-control' value="<?php echo $round_matches[$m]->Player1_Partner;?>" id="player1_user_partner" name="player1_user_partner" type='hidden' />

<input class='form-control' value="<?php echo $round_matches[$m]->Player2; ?>" id="player2_user" name="player2_user" type='hidden' />
<input class='form-control' value="<?php echo $round_matches[$m]->Player2_Partner; ?>" id="player2_user_partner" name="player2_user_partner" type='hidden' />

<input class='form-control' value="<?php echo $round_matches[$m]->Tourn_ID;?>" id="tourn_id" name="tourn_id" type='hidden' />
<input class='form-control' value="<?php echo $round_matches[$m]->BracketID;?>" id="bracket_id" name="bracket_id" type='hidden' />
<input class='form-control' value="<?php echo $round_matches[$m]->Match_Num;?>" id="match_num" name="match_num" type='hidden' />
<input class='form-control' value="<?php echo $match_type;?>" id="match_type" name="match_type" type='hidden' />
<input class='form-control' value="<?php echo $round_matches[$m]->Tourn_match_id;?>" id="tourn_match_id" name="tourn_match_id" type='hidden' />

<input class='form-control' value="<?php echo $round_matches[$m]->Round_Num;?>" id="round_num" name="round_num" type='hidden' />
<input class='form-control' value="<?php echo $rd_type;?>" id="round_title" name="round_title" type='hidden' />
<input class='form-control' value="" id="" name="draw_name" type='hidden' />


<div class='form-group'>
<div class='col-md-1 form-group internal'>
<input name="add_match_score" id="<?php echo $round_matches[$m]->Tourn_match_id;?>" type="submit" value="Add" class="add_score_ajax league-form-submit" />
</div>
</div>

</form>
</div>
</td>
</tr>

<!-- -------------------------Edit score block ------------------------- -->
<tr id="escore<?php echo $round_matches[$m]->Tourn_match_id; ?>" class="tourn_match" style="display:none;">
<td colspan='6'>
<div>

<form name="form-editscore" id="form-editscore<?php echo $round_matches[$m]->Tourn_match_id; ?>">

<div class='form-group'>
<div class='col-md-2 form-group internal'>
<input type="text" class='form-control' placeholder="Date" id="edate<?php echo $round_matches[$m]->Tourn_match_id; ?>" name="tour_match_date" /> 
</div>
<script>
$(function() {
var spid = "<?php echo $round_matches[$m]->Tourn_match_id; ?>";
$('#edate'+spid).datepick();
});
</script>

<div class='form-group'>
<div class='col-md-8 form-group internal scoretable-web'>

<input type='checkbox' name="<?php echo $round_matches[$m]->Tourn_match_id; ?>" id='wff_edit' class='wff_score' />&nbsp;Declare winner by Win by Forfeit

<?php
$get_sport = league::getonerow($tourn_id);
$sport_id  = $get_sport->SportsType;
?>
<table class="score-cont">
<?php if($sport_id == 1){ ?>
<tr>
<th>Players</th><th>Set1</th><th>Set2</th><th>Set3</th><th>Set4</th><th>Set5</th><!-- <th>Set6</th> -->
</tr>
<?php }
else{ ?>
<tr>
<th>Players</th><th>Game1</th><th>Game2</th><th>Game3</th><th>Game4</th><th>Game5</th><!-- <th>Game6</th> -->
</tr>
<?php } ?>				  
<tr>
<td bgcolor="#fdd7b0"><b><?php echo $team1; ?></b></td>
<td><input id='set1_1_<?php echo $round_matches[$m]->Tourn_match_id; ?>' name='player1[]' style = "width:65%" type='text' maxlength='2' /></td>
<td><input id='set1_2_<?php echo $round_matches[$m]->Tourn_match_id; ?>' name='player1[]' style = "width:65%" type='text' maxlength='2' /></td>
<td><input id='set1_3_<?php echo $round_matches[$m]->Tourn_match_id; ?>' name='player1[]' style = "width:65%" type='text' maxlength='2' /></td>
<td><input id='set1_4_<?php echo $round_matches[$m]->Tourn_match_id; ?>' name='player1[]' style = "width:65%" type='text' maxlength='2' /></td>
<td><input id='set1_5_<?php echo $round_matches[$m]->Tourn_match_id; ?>' name='player1[]' style = "width:65%" type='text' maxlength='2' /></td>
<!-- <td><input id='set1_6_<?php //echo $round_matches[$m]->Tourn_match_id; ?>' name='player1[]' style = "width:65%" type='text' maxlength='2' /></td> -->
</tr>
<tr>
<td bgcolor="#fdd7b0"><b><?php echo $team2; ?></b></td>
<td><input id='set2_1_<?php echo $round_matches[$m]->Tourn_match_id; ?>' name='player2[]' style = "width:65%" type='text' maxlength='2' /></td>
<td><input id='set2_2_<?php echo $round_matches[$m]->Tourn_match_id; ?>' name='player2[]' style = "width:65%" type='text' maxlength='2' /></td>
<td><input id='set2_3_<?php echo $round_matches[$m]->Tourn_match_id; ?>' name='player2[]' style = "width:65%" type='text' maxlength='2' /></td>
<td><input id='set2_4_<?php echo $round_matches[$m]->Tourn_match_id; ?>' name='player2[]' style = "width:65%" type='text' maxlength='2' /></td>
<td><input id='set2_5_<?php echo $round_matches[$m]->Tourn_match_id; ?>' name='player2[]' style = "width:65%" type='text' maxlength='2' /></td>
<!-- <td><input id='set2_6_<?php //echo $round_matches[$m]->Tourn_match_id; ?>' name='player2[]' style = "width:65%" type='text' maxlength='2' /></td> -->
</tr>
</table> 

</div>
</div>

<!-- ---------------Mobile view------------------------------------------------------- -->
<div class="scoretable-mob">
<table class="score-cont">
<tr>
<th>Players</th>
<th bgcolor="#fdd7b0"><b><?php echo $team1; ?></b></th>
<th bgcolor="#fdd7b0"><b><?php echo $team2; ?></b></th>
<?php if($sport_id == 1){
$set_or_game = 'Set';
}
else{
$set_or_game = 'Game';
}
?>
</tr>
<tr>
<td><?php echo $set_or_game . "1"; ?></td>
<td><input id='mset1_1_<?php echo $round_matches[$m]->Tourn_match_id; ?>' name='player1[]' style = "width:45%" type='text' maxlength='2' /></td>
<td><input id='mset2_1_<?php echo $round_matches[$m]->Tourn_match_id; ?>' name='player2[]' style = "width:45%" type='text' maxlength='2' /></td>
</tr>

<tr>
<td><?php echo $set_or_game . "2"; ?></td>
<td><input id='mset1_2_<?php echo $round_matches[$m]->Tourn_match_id; ?>' name='player1[]' style = "width:45%" type='text' maxlength='2' /></td>
<td><input id='mset2_2_<?php echo $round_matches[$m]->Tourn_match_id; ?>' name='player2[]' style = "width:45%" type='text' maxlength='2' /></td>
</tr>
<tr>
<td>
<?php echo $set_or_game . "3"; ?>
</td>
<td><input id='mset1_3_<?php echo $round_matches[$m]->Tourn_match_id; ?>' name='player1[]' style = "width:45%" type='text' maxlength='2' /></td>
<td><input id='mset2_3_<?php echo $round_matches[$m]->Tourn_match_id; ?>' name='player2[]' style = "width:45%" type='text' maxlength='2' /></td>
</tr>
<tr>
<td>
<?php echo $set_or_game . "4"; ?>
</td>
<td><input id='mset1_4_<?php echo $round_matches[$m]->Tourn_match_id; ?>' name='player1[]' style = "width:45%" type='text' maxlength='2' /></td>
<td><input id='mset2_4_<?php echo $round_matches[$m]->Tourn_match_id; ?>' name='player2[]' style = "width:45%" type='text' maxlength='2' /></td>
</tr>
<tr>
<td>
<?php echo $set_or_game . "5"; ?>
</td>
<td><input id='mset1_5_<?php echo $round_matches[$m]->Tourn_match_id; ?>' name='player1[]' style = "width:45%" type='text' maxlength='2' /></td>
<td><input id='mset2_5_<?php echo $round_matches[$m]->Tourn_match_id; ?>' name='player2[]' style = "width:45%" type='text' maxlength='2' /></td>
</tr>

</table>
</div>
<!-- ---------------Mobile view------------------------------------------------------- -->


<input class='form-control' value="TS_SE_EDITSCORE" name="score_type" type='hidden'> 
<input class='form-control' value="<?php echo $round_matches[$m]->Player1;?>" id="player1_user" name="player1_user" type='hidden'>

<input class='form-control' value="<?php echo $round_matches[$m]->Player1_Partner;?>" id="player1_user_partner" 
name="player1_user_partner" type='hidden'>

<input class='form-control' value="<?php echo $round_matches[$m]->Player2; ?>" id="player2_user" name="player2_user" type='hidden'>

<input class='form-control' value="<?php echo $round_matches[$m]->Player2_Partner; ?>" id="player2_user_partner" 
name="player2_user_partner" type='hidden'>

<input class='form-control' value="<?php echo $round_matches[$m]->Tourn_ID;?>" id="tourn_id" name="tourn_id" type='hidden'> 
<input class='form-control' value="<?php echo $round_matches[$m]->BracketID;?>" id="bracket_id" name="bracket_id" type='hidden'>
<input class='form-control' value="<?php echo $round_matches[$m]->Match_Num;?>" id="match_num" name="match_num" type='hidden'>
<input class='form-control' value="<?php echo $match_type;?>" id="match_type" name="match_type" type='hidden'>
<input class='form-control' value="<?php echo $round_matches[$m]->Tourn_match_id;?>" id="tourn_match_id" name="tourn_match_id" type='hidden'>

<input class='form-control' value="<?php echo $round_matches[$m]->Round_Num;?>" id="round_num" name="round_num" type='hidden'>
<input class='form-control' value="<?php echo $rd_type;?>" id="round_title" name="round_title" type='hidden'>
<input class='form-control' value="" id="" name="draw_name" type='hidden'>

<div class='form-group'>
<div class='col-md-1 form-group internal'>
<input name="upd_match_score" id="<?php echo $round_matches[$m]->Tourn_match_id;?>" type="submit" value="Update" class="edit_score_ajax league-form-submit"/>
</div>
</div>
</form>
</div>
</td>
</tr>
<!-- -------------------------End of edit score block ------------------------- -->
<?php 
}
}
?>
<!-- End of  Add, wff, Edit Score blocks -->
</table>
<?php 
}
}
else{
?>
<div>Draws are not generated for this tournament yet!</div>
<?php
}
?>
</div>