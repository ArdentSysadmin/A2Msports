<script>
$(document).ready(function(){

$('.show_lines').click(function(){
var tid = $(this).attr('name');

	if($('.match_lines_'+tid).is(':visible')){
		$('.match_lines_'+tid).hide();
	}
	else{
		$('.match_lines_'+tid).show();
	}
});


$("select").change(function()
{
	$cname = $(this).attr('class');
	if($cname != 'wff_sel')		// to skip for WFF select box
	{
	$ids   = $(this).attr('id');
	$user  = $(this).val();
	$temp  = $ids.split('_');

	$line  = $temp[2];	
	$ptype = $temp[0]+'_'+$temp[1];


	if($ptype === 't1_p1'){
	$('#player1_user_'+$line).val($user);
	$('#wf_player1_user_'+$line).val($user);
	}
	else if($ptype === 't1_p1p'){
	$('#player1_user_partner_'+$line).val($user);
	$('#wf_player1_user_partner_'+$line).val($user);
	}
	else if($ptype === 't2_p1'){
	$('#player2_user_'+$line).val($user);
	$('#wf_player2_user_'+$line).val($user);
	}
	else if($ptype === 't2_p1p'){
	$('#player2_user_partner_'+$line).val($user);
	$('#wf_player2_user_partner_'+$line).val($user);
	}

	var selectedText = $(this).find('option:selected').text();
	    $('#div_'+$temp[0]+'_'+$temp[1]+'_'+$line).html(selectedText);
	$('#div_mob_'+$temp[0]+'_'+$temp[1]+'_'+$line).html(selectedText);

//alert($temp[1]);
	
	if($temp[1] == 'p1p')
	{
		$get_html = $('#div_'+$temp[0]+'_p1_'+$line).html();
		$temp2	  = $get_html.split(';');
	
		//alert($temp2);
		if($temp2[0]){
			    $('#div_'+$temp[0]+'_p1_'+$line).html($temp2[0]+'; '+selectedText);
			$('#div_mob_'+$temp[0]+'_p1_'+$line).html($temp2[0]+'; '+selectedText);
		}
		else{
			    $('#div_'+$temp[0]+'_p1_'+$line).append('; '+selectedText);
			$('#div_mob_'+$temp[0]+'_p1_'+$line).append('; '+selectedText);
		}
	}
	else
	{
		$('#win_ff_team'+$line).append($('<option>', {
			value: $user,
			text: selectedText
		}));
	}

	$("."+$cname+" option").attr('disabled','disabled').siblings().removeAttr('disabled');

	DisableOptions(); //disable selected values
	}
});


function DisableOptions()
{
	var arr=[];
	$("."+$cname+" option:selected").each(function()
	{
		if($(this).val() != ""){
		  arr.push($(this).val());
		}
	});

	$("."+$cname+" option").filter(function()
	{
		//alert($.inArray($(this).val(),arr));
			if($.inArray($(this).val(),arr) > -1){
				$(this).attr("disabled","disabled");
			}
			else{
				$(this).attr("enabled","enabled");
			}
	});
}

var baseurl = "<?php echo base_url();?>";

$(".team_edit_score").click(function(){
var line = $(this).attr('name');

if(line){
	if(confirm('Are you sure to drop the line match score?')){
		  $.ajax({
			type:'POST',
			url:baseurl+'league/drop_line_matchscore',
			data:{'line':line},
			success: function(res){
			   location.reload();
			}
		  });
		  //e.preventDefault();
	}
	else{
		//alert('cancelled');
	}

}

});

});
</script>


<script type="text/javascript">
$(document).ready(function () {
$(function () {
"use strict";
$('.accordion').accordion({ defaultOpen: 'section' }); //some_id section1 in demoup_tour_section
});
});
</script>

<script>
$(document).ready(function(){
var baseurl = "<?php echo base_url();?>";

$('.edit_score').on('click',function(){

var tab_row_id = $(this).attr('name');
//alert (tab_row_id);

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
	}else{
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
			$('#mset1_'+($i+1)+'_'+res[0]).val(p1_score[$i]);
		}

		for($j=0; $j<p2_score.length; $j++){
			$('#set2_'+($j+1)+'_'+res[0]).val(p2_score[$j]);
			$('#mset2_'+($j+1)+'_'+res[0]).val(p2_score[$j]);
		}
	}
	
	var dateArr = res[16].split('-');
	$('#edate'+res[0]).val(dateArr[1]+"/"+dateArr[2]+"/"+dateArr[0]);
}
}); 
}

});

});
</script>

<!-- ------------------------Add Score without page redirect-------------------------- -->

<script>
$(document).ready(function(){

var baseurl = "<?php echo base_url();?>";

$('.wff_add').click(function (e) {

var id_val = $(this).attr('id');

	  $.ajax({
		type: 'POST',
		url: baseurl+'league/view_matches',
		data: $('#form-wff'+id_val).serialize(),
		success: function () {
		   //location.reload();
			alert('Result added successfully!');
			$("#forfeit"+id_val).hide();
		}
	  });
	  e.preventDefault();

	});
});
</script>

<script>
$(document).ready(function(){

var baseurl = "<?php echo base_url();?>";

$('.add_score_ajax').click(function (e) {

var id_val = $(this).attr('id');

	  $.ajax({
		type: 'POST',
		url: baseurl+'league/view_matches',
		data: $('#form-addscore'+id_val).serialize(),
		success: function () {
			alert('Score added successfully!');
			$("#score"+id_val).hide();
		  //location.reload();
		}
	  });
	  e.preventDefault();

	});


$(".add_team_score").click(function(){
var pid = $(this).attr('name');
var tm1_player=$("#t1_p1_"+pid).val();
var tm2_player=$("#t2_p1_"+pid).val();
var Class = $("#t1_p1_"+pid).attr('class');
if(Class.indexOf('doubles') !== -1){
var tm1_p_partner=$("#t1_p1p_"+pid).val();
var tm2_p_partner=$("#t2_p1p_"+pid).val();
var cond=tm1_player=="" || tm2_player=="" || tm1_p_partner=="" || tm2_p_partner=="";
}else{
    cond=tm1_player=="" || tm2_player=="";
}
if(cond){
 alert("Choose players to add score!");
die();
}
if($("#score"+pid).css('display')=='none'){
$("#score"+pid).show();
$("#forfeit"+pid).hide();
//$("#comment"+pid).hide();
}
else{
$("#forfeit"+pid).hide();
$("#score"+pid).hide();
//$("#comment"+pid).hide();
}
});

});
</script>

<script>
$(document).ready(function(){

var baseurl = "<?php echo base_url();?>";

$('.edit_score_ajax').click(function (e) {

var id_val = $(this).attr('id');

	  $.ajax({
		type: 'POST',
		url: baseurl+'league/view_matches',
		data: $('#form-editscore'+id_val).serialize(),
		success: function () {
		  location.reload();
		}
	  });
	  e.preventDefault();

});

$('.wff_score').click(function() {
var pid2 = $(this).attr('name');

if($("#forfeit"+pid2).css('display')=='none'){
$("#forfeit"+pid2).show();
$("#score"+pid2).hide();
//$("#comment"+pid).hide();
}
else{
$("#forfeit"+pid2).hide();
$("#score"+pid2).hide();
//$("#comment"+pid).hide();
}

});

});
</script>


<!-- -------------------------------------------------------------------------------- -->

<?php
$tourn_id		= $get_bracket_details['Tourn_ID'];
$round_matches	= $bracket_matches->result();
$line_matches	= $se_line_matches->result();
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
	$rrt = $rt*2;

	$rd_type = "Round of $rrt";

	//echo "<b>$rd_type</b>";
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
	//echo "<b>$rd_type</b>";

}
	?>
	
<?php echo "<div class='accordion' id='section' style='background:#f59123; padding:5px; color:white;'><i class='fa fa-arrow-circle-o-right' style='color:white;'> </i><b>$rd_type</b><span></span></div>";

//echo "<b>Round:" . $round . "</b>";
?>

<table class="tab-score">

<tr class="top-scrore-table">
<td class="score-position" valign="center" align="center">Team1</td>
<td class="score-position" valign="center" align="center">Team2</td>
<td class="score-position" valign="center" align="center">Points</td>
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
<tr>
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

<td style="padding-left:15px;" align='center'>(<?=$player1_points;?> - <?=$player2_points;?>)</td>

<td style="padding-left:15px;">
<a id='show_lines' class='show_lines' href='#reg_matches' name='<?php echo $tm_id; ?>' style='text-decoration:none;'>Show Lines </a></td>

</tr>

<?php
$data['tm_id']		  = $tm_id;
$data['round']		  = $round;
$data['line_matches'] = $line_matches;
$data['rr_matches']	  = $round_matches;
$data['m']			  = $m;
$data['tourn_id']	  = $tourn_id;
$data['player1']	  = $player1;
$data['player2']	  = $player2;
$data['logged_user']  = $logged_user;
$data['tourn_admin']  = $tourn_admin;
$data['tour_details']  = $tour_details;

/*echo "<pre>";
print_r($data);
exit;*/

$this->load->view("scores/show_lines", $data);
?>


<?php 
}
}
?>
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