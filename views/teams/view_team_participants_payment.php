<script>
$(document).ready(function(){

 $('#frm_participants').click(function() {
  var atLeastOneIsChecked = false;
  $('input:checkbox').each(function() {
    if ($(this).is(':checked')) {
      atLeastOneIsChecked = true;
      // Stop .each from processing any more items
      return false;
    }
  });
  if(atLeastOneIsChecked == false){
		alert('Select atlease one player to proceed!');
		e.preventDefault();
		return false;
  }
  // Do something with atLeastOneIsChecked
});
$(".change_level").click(function(){
 var tid=$(this).attr("id");
 var tidarr=tid.split('_');
 var player=tidarr['2'];
  $("#withdrawplayer_"+player).hide();
 //alert(player);
 var tourn_id=tidarr['3'];
    $.ajax({
      type: 'POST',
      url: baseurl+'league/GetUserLevels',
      data:{player:player,tourn_id:tourn_id},
      success: function(res) {
        //console.log(res);die();
       $("#partcipantlevels_"+player).show();
       $("#partcipant_levels_"+player).html(res);
      }
      });
});

$(".withdraw_player").click(function(){
  var tid=$(this).attr("id");
  var tidarr=tid.split('_');
  var player=tidarr['2'];
  $("#partcipantlevels_"+player).hide();
  var tourn_id=tidarr['3'];
  $.ajax({
      type: 'POST',
      url: baseurl+'league/GetUserLevelsExist',
      data:{player:player,tourn_id:tourn_id},
      success: function(res) {
        //alert(res);
        $("#withdrawplayer_"+player).show();
        $("#existing_events_"+player).html(res);
      }
      });
});

$(".cancel").click(function(){
  var tid=$(this).attr("id");
  var tidarr=tid.split('_');
  var player=tidarr['1'];
  $("#withdrawplayer_"+player).hide();
});


$(".sub-proceed").click(function(){
  $(this).val("Please wait...");
});

/* ------------------------- Collapse and Expand in Participants ---------------------- */
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
/* ------------------------- Collapse and Expand in Participants ---------------------- */

});


</script>
<style>
.container2 .header {
    #background-color:#d3d3d3;
    padding: 2px;
    cursor: pointer;
    #font-weight: bold;
}
.container2 .content {
    display: none;
    padding : 5px;
}

.multiselect {
width: 200px;
}
.selectBox {
position: relative;
}
.selectBox select {
width: 100%;
font-weight: bold;
}
.overSelect {
position: absolute;
left: 0; right: 0; top: 0; bottom: 0;
}

#checkboxes {
display: none;
border: 1px #dadada solid;
}
#checkboxes label {
display: block;
}
/*#checkboxes label:hover {
background-color: #1e90ff;
}*/
</style>

<script>
function showCheckboxes($uid){
var elements = document.getElementsByClassName('div_ag_sel')

for (var i = 0; i < elements.length; i++){
elements[i].style.display = "none";
}
var checkboxes = document.getElementById("checkboxes"+$uid);
checkboxes.style.display = "block";
}
</script>

<div class="col-md-12 league-form-bg" style="margin-top:15px; margin-bottom:0px;">
<?php $tourn_reg_names = league::get_reg_team_participants($tour_details->tournament_ID); ?>

<div>
<table class="tab-score">
<tr>
<th width="35%">Name</th>
<th width="15%">Contact#</th>
<th width="20%">Amount Paid($)</th>
</tr>

<?php
$check_cond = array('0.00','0','NULL','');
$total		= 0;
if(count(array_filter($tourn_reg_names)) > 0){
foreach($tourn_reg_names as $name){
?>
<tr>
<td style="padding-left:10px;">
<?php
$team = league::get_team($name->Team_id);
	if($team['Team_Logo'] != NULL and $team['Team_Logo'] != ""){
	$team_logo = "<img style='width:45px;height:40px' src='".base_url()."team_logos/".$team['Team_Logo']."' alt='".$team['Team_name']."' />";
	}
	else{ 
	$team_logo = "<img style='width:45px;height:40px' src='".base_url()."team_logos/default_team_logo.png' alt='".$team['Team_name']."' />";
	}

echo "<div class='header'>{$team_logo}&nbsp;<span style='color:blue;font-size:13px;font-weight:400;'>".$team['Team_name']."</span></div><div class='content'><ul>";

$tour_team_players = json_decode($name->Team_Players);
$total = 0;

foreach($tour_team_players as $tp){

	if($tour_details->Tournamentfee == 1 and $tour_details->Fee_collect_type == 'Player'){
		$is_player_paid = league::check_is_player_paid($tp, $tour_details->tournament_ID, $name->Team_id);
	}
	$player = league::get_username($tp);
	if($player['Gender'] == 1){
		$gender = "(M)";
	}
	else if($player['Gender'] == 0){
		$gender = "(F)";
	}

	$paid_ico	 = '';
	$captain_ico = '';

	if($tp == $team['Captain']){ 
		$captain_ico = "<img src='".base_url()."icons/letter_c.png' title='Captain' style='width:15px; height:15px;' />"; 
	}
	if(!empty($is_player_paid)){   // and $is_player_paid['Transaction_id']){ 
		/*$paid_ico = "<img src='".base_url()."icons/letter_p.png' title='$".number_format($is_player_paid['Amount'],2)." Paid' style='width:21px; height:21px;' />"; */
		$paid_ico = "<img src='".base_url()."icons/letter_p.png' title='Paid' style='width:21px; height:21px;' />"; 


		$gross		= number_format($is_player_paid['Amount'], 2);
		$pp_charges = 0.00;

		if($is_player_paid['Gateway_Charges'] != NULL and $is_player_paid['Gateway_Charges'] != ''){
		$pp_charges = $is_player_paid['Gateway_Charges'];
		}

		$paid = ($gross - $pp_charges);
		$total += $paid;


	}

    echo "<li style='padding-left:25px;padding-bottom:5px;list-style:none;'><input type='checkbox' name='prtcpnts_mail_check' id='tm_participants_".$player['Users_ID']."' class='tm_participants_cls prtcpnts_mail_check_".$name->Team_id."' value='".$player['Users_ID']."' />&nbsp;";
	echo "<a href='".base_url()."player/".$player['Users_ID']."' target='_blank' title='".$player['Mobilephone']."'>".$player['Firstname']." ".$player['Lastname']."</a> ".$gender."&nbsp;{$captain_ico}&nbsp;{$paid_ico}</li>";
}

echo "</ul></div>";
?>
</td>
<td style="padding-left:10px"><?php //echo $player['Mobilephone']; ?></td> 

<td style="padding-left:10px">
<div>
<?php
echo number_format($total, 2);
?>
</div>
</td>

</tr>
<?php
		$grand_total += $total;

}
?>
<tr>
<td colspan='2' style="padding-right:10px" align='right'>Total</td>
<td style="padding-left:10px">
<div><?=number_format($grand_total, 2); ?></div>
</td>
</tr>
<?php
}
else {
?>
<tr><td colspan='6'><b>No Team is Registered yet. </b></td></tr>
<?php
}
?>
</table>
</div>  

</div>
<input type='hidden' name='tourn_id' id="tourn_id" value="<?php echo $tour_details->tournament_ID; ?>">
<input type='hidden' name='tourn_type' value = "<?php echo $tour_details->Tournament_type; ?>">
<!-- </div>--></form>