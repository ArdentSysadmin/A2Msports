
<script src="<?php echo base_url();?>js/jquery.accordion.js" type="text/javascript"></script>
<script type="text/javascript">
$(document).ready(function () {
/*$( function() {
    $( ".accordion" ).accordion();
  } );*/
$(function () {
/*"use strict";
$('.accordion').accordion({ defaultOpen: 'up_match_section' }); //some_id section1 in demoup_tour_section
*/
$('.accordion').click(function() {
		$(this).next().toggle();
		return false;
	}).next().hide();

});
var baseurl = "<?php echo base_url();?>";

/* Manage Team Ajax code */
$('#teamlist').change(function(){
var team_id = $(this).val();
var tourn_id = $('#tourn_id').val();

if(team_id != "" && tourn_id != ""){
  $.ajax({
    type:'POST',
    url:baseurl+'teams/get_team_details/',
    data:{ team_id:team_id, tourn_id:tourn_id },
    success:function(html){
		//alert(html);
    $('#load_manage_team').show();
    $('#load_manage_team').html(html);
    }
  }); 
}

});
/* Manage Team Ajax code */

});

</script>

<script src="<?php echo base_url();?>js/jquery-1.10.2.js" type="text/javascript"></script>
<script>
var baseurl;
baseurl = "<?php echo base_url();?>";
</script>
<script src="<?php echo base_url();?>js/custom/league.js" type="text/javascript"></script>
<script>
$( document ).ready(function() {
	$('#show_tour_details_rules').click(function() {
        $("#tour_details").toggle();
		if($("#show_tour_details_rules").html() == "<b>Hide</b>"){
		   $("#show_tour_details_rules").html('<b>Show</b>');       
		}
		else{
		   $("#show_tour_details_rules").html('<b>Hide</b>');       
		}
	});

	$('#showdiv2').click(function() {
	var show_player_view = "<?php echo $valid_draws_count; ?>";
	var bid				 = "<?php echo $show_draw_bid; ?>";

	//alert(show_player_view);
	//alert(bid);

	$('div[id^=div]').hide();
	if(show_player_view == 1) { $('#list_draw_matches'+bid).trigger('click'); }
	else { $('#div2').show(); }
	$('#bracket_result').hide();
	$('#no_result').hide();
	});

	/* Start Show Team Lines*/
	$('#showdiv16').click(function(){
	$('div[id^=div]').hide();
	$('#div16').show();
	});
    /* End Show Team Lines */

	$('#league_more_details').click(function(){
		$('#landing_page_view').fadeOut(1000);
		$('#more_details_view').fadeIn(1000);
		$('html,body').scrollTop(0);
	});

	$('#send_comment').on('click', function(e) {

	var tid = $('#tourn_id').val();
	var mes = $('#message').val();

		  $.ajax({
			type: 'POST',
			url: baseurl+'league/add_comment',
			data:{message:mes,tid:tid},
			success: function(res) {
			 $('#message').val("");
			 //$("#sub_status").html("<b style='color:blue'>your comments are submitted!</b>");
			 $("#comments_div").html(res);
			}
		  });
		 // e.preventDefault();
	});


/*  Send mail with an attachment to all participants*/

$("#select_all_chk").click(function() {
   $(".tourn_participants_cls").prop("checked", $("#select_all_chk").prop("checked"))
   $(".tm_participants_cls").prop("checked", $("#select_all_chk").prop("checked"))
});


$('#send_mail').click(function() {
  if ($(this).prop('checked')==true){
    var count=$('input:checkbox.tm_participants_cls:checked').length;
    if(count==0){
    $('#send_mail').attr('checked', false);
   // $("error_alert").html("Please select participants to send mail!");
     alert("Please select participants to send mail!"); 
     die();
    }else{
      $("#send_mail_frm").show();	
    }   
  }else{
  	$("#send_mail_frm").hide();
  }
});
$("form#send_mail_frm").submit(function(){
  var player_id=[];
  var count=$('input:checkbox.tm_participants_cls:checked').length;
    if(count==0){
    	//$("error_alert").html("Please select participants to send mail!");
     alert("Please select participants to send mail!"); 
     die();
    }
   $('input[name="prtcpnts_mail_check"]:checked').each(function() {
     player_id.push(this.value);
   });
   
   var formData = new FormData($(this)[0]);
   //var msg_body = $("#message").val();
   var msg_body = tinymce.get("message").getContent();
   formData.append('msg', msg_body);
   //alert(msg_body);die();
    $.ajax({
        url: baseurl+'league/sendmail_tm_participants/'+player_id,
        type: 'POST',
        data: formData,
        async: false,
        success: function (data) {
        	//alert(data);die();
            if(data == true){
                $("#sendmail_notify").show();
			          $("#send_mail_frm").hide();
            }
			$('html, body').animate({
			scrollTop: ($("#sendmail_notify").offset().top)
			},500);
		},
        cache: false,
        contentType: false,
        processData: false
    });

    return false;
});

/*End Send mail with an attachment to all participants*/

 /* Starts Participant Withdraw*/
 $(".proceed_to_withdraw").click(function(){
  var player=$("#player").val();
  var cnt=$("#checkbox_cnt").val();
  var tourn_id=$("#tourn_id").val();
  var singles = [];
  var doubles = [];
  var mixed = [];
 var total=$('input[name="match_type_'+player+'[]"]:checked').length;
 //alert(tourn_id);
  //alert(player);
 //alert(total);

  $("input:checkbox.singles_matchtype_"+player+":checked").each(function () {
     var match_type = this.value; 
       singles.push(match_type);
  });

  $("input:checkbox.doubles_matchtype_"+player+":checked").each(function () {
     var match_type = this.value; 
       doubles.push(match_type);
  });
	$("input:checkbox.mixed_matchtype_"+player+":checked").each(function () {
	    var match_type = this.value; 
	       mixed.push(match_type);
	 });
  
     if(total==0){
      
      }else{
        $.ajax({
        type:'POST',
        url:baseurl+'league/UpdateLevels/',
        data:{singles:singles,doubles:doubles,mixed:mixed,tourn_id:tourn_id,player:player},
        success:function(html){
            if(html==true){ 
               alert("Updated Successfully!");
               location.reload();
              // $("#partcipantlevels_"+player).hide();
              // $("#partcipant_levels_"+player).html('');
            }
        }
      });

     }
  //window.location.href=baseurl+"league/ViewPayPalRefund/"+player+"/"+tourn_id;
  
});

$(".GetRefundAmnt").click(function(e){
	var baseurl = "<?php echo base_url();?>";
	var pamt	= parseFloat($('#paid_amnt').val());
	var pref	= $('#pr_ref').val();
	  $.ajax({
		type: 'POST',
		url: baseurl+'league/GetRefundAmnt',
		data: $('#frm_player_withdraw').serialize(),
		success: function(res){
			res = parseFloat(res);
      //alert(res);
      //alert(pamt);
			if(res > pamt){
				//alert('res>pamt');
				var ref_dec = ((pamt-pref) * 10)/100;
				      //alert(ref_dec);

				var new_ref = (pamt-pref) - ref_dec;
				      //alert(new_ref);

				$('#refund_amnt').html(new_ref);
				$('#refund_amnt_val').val(new_ref);
			}
			else{
				$('#refund_amnt').html(res);
				$('#refund_amnt_val').val(res);
			}
			e.preventDefault();
		}
	  });

});
$( "#player_withdraw_btn_cancel" ).click(function(e) {
	$('#frm_player_withdraw').trigger('reset');
	$('#refund_amnt').html('0.00');
	$('#refund_amnt_val').val('0');
	$('#div17').hide();
});

$( ".player_withdraw_btn" ).click(function(e) {
  var r        = confirm("Are you sure you want to continue for withdrawn?");
  var trans_id = $("#trans_id").val();
  var fee      = $("#refund_amnt_val").val();
  if(fee != 0.00){
    if(trans_id == ''){
      alert("You don't have Transactions. Please contact your admin!");
      e.preventDefault();
    }
  }
  if(r == true){
    var baseurl = "<?php echo base_url();?>";
	var tid = $('#tourn_id').val();
    $.ajax({
    type: 'POST',
    url: baseurl+'Payments_pro/Player_withdraw',
    data: $('#frm_player_withdraw').serialize(),
    success: function(res){

		               location.reload();

		 /*url = baseurl+"league/view/"+tid+'/9';
		 alert(url);
      $(location).attr("href", url);*/

       //console.log(res);
	       //e.preventDefault();

	   //die();
    }
    });
  
  }else{
    e.preventDefault();
  }
  
});

/*
$(".GetRefundAmnt").click(function(){
  var player=$("#player").val();
  var singles_checked=[];
  var doubles_checked=[];
  var mixed_checked=[];
  var singles_unchecked=[];
  var doubles_unchecked=[];
  var mixed_unchecked=[];
 
   $("input:checkbox.singles_matchtype_"+player+":checked").each(function () {
     var match_type = this.value; 
       singles_checked.push(match_type);
  });
  $("input:checkbox.singles_matchtype_"+player+":not(:checked)").each(function () {
            var match_type = this.value; 
            singles_unchecked.push(match_type);
   });
  
   $("input:checkbox.doubles_matchtype_"+player+":checked").each(function () {
     var match_type = this.value; 
       doubles_checked.push(match_type);
   });
    $("input:checkbox.doubles_matchtype_"+player+":not(:checked)").each(function () {
            var match_type = this.value; 
            doubles_unchecked.push(match_type);
   });
  
    $("input:checkbox.mixed_matchtype_"+player+":checked").each(function () {
        var match_type = this.value; 
        mixed_checked.push(match_type);
    });
    $("input:checkbox.mixed_matchtype_"+player+":not(:checked)").each(function () {
            var match_type = this.value; 
            mixed_unchecked.push(match_type);
   });
  
  var tourn_id=$("#tourn_id").val();
  //var event=$(this).val();
   $.ajax({
        type:'POST',
        url:baseurl+'league/GetRefundAmnt/',
        data:{player:player,tourn_id:tourn_id,singles_checked:singles_checked,doubles_checked:doubles_checked,mixed_checked:mixed_checked,singles_unchecked:singles_unchecked,doubles_unchecked:doubles_unchecked,mixed_unchecked:mixed_unchecked},
        success:function(res){
        	 console.log(res);
         die();
        	$("#refund_amnt").val(res);
       
        }
      });

});
*/
$( "#select_all_players").click(function() {
  if ($("#select_all_players").prop('checked')==true){
     $(".tm_participants_cls").prop('checked', true);
    }else{
     $(".tm_participants_cls").prop('checked', false);
    }
});

});

function getlines(teamid) {
//alert(teamid);
var bracket_id = $("#brackets_list option:selected").val();
var tourn_id   = $("#tourn_id").val();

if(bracket_id==0){
alert("Please choose a Bracket!");
die();
}
//alert(bracket_id);die();
if(teamid != "" && tourn_id != ""){
	$.ajax({
		type:'POST',
		url:baseurl+'league/get_tourn_reg_team_lines/',
		data:{ team_id:teamid, tourn_id:tourn_id , bracket_id:bracket_id },
		dataType:'text',
		success:function(html){
			//alert(html);
		$('#div16').html(html);
		}
	}); 
}

}

function check_tourn_prtcpnts(team_id){
	if ($("#tourn_participants_"+team_id).prop('checked')==true){
	   $(".prtcpnts_mail_check_"+team_id).prop('checked', true);
    }else{
	   $(".prtcpnts_mail_check_"+team_id).prop('checked', false);
    }
}

function getallcheckboxes(k){
	if ($("#select_all_chk_"+k).prop('checked')==true){
	   $(".tm_participants_cls_"+k).prop('checked', true);
    }else{
	   $(".tm_participants_cls_"+k).prop('checked', false);
    }
} 

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
.sendmail_alert {
    padding: 20px;
    background-color: green;
    color: white;
}
</style>

<!-- ------------------------------------------------------------------------------------------------------------- -->
<!-- ------------------------------------------------------------------------------------------------------------- -->

<div id='more_details_view'>
<section id="single_player" class="container secondary-page">
<div class="top-score-title right-score col-md-12">

<?php
//echo $tour_details->tournament_format;
$num = $this->uri->segment(4);

if($fee_payable and $fee_payable != "0.00"){
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
if($num == 1){ 
?>
<div class="name" align='left'>
<label for="name_login" style="color:green"><?php echo "You have successfully registered for this tournament.<br />"; ?></label>
</div>
<?php } 
if($num == 8){ 
?>
<div class="name" align='left'>
<label for="name_login" style="color:green"><?php echo "Player withdrawn successful.<br />"; ?></label>
</div>
<?php } 
if($num == 9){ 
?>
<div class="name" align='left'>
<label for="name_login" style="color:green"><?php echo "Refund was successful.<br />"; ?></label>
</div>
<?php } 
if(isset($reg_suc)){ ?>
<div class="name" align='left'>
<?php if($reg_suc != 5 and $reg_suc != 1){ ?>
<label for="name_login" style="color:green"><?php echo $reg_suc . "<br />"; ?></label>
<?php } else if($reg_suc != 1){ ?>		
<label for="name_login" style="color:green"><?php echo "Successfully Registered for this Tournament. " . "<br />"; ?></label>		
<?php } ?>
</div>
<?php } ?>
<div id="sendmail_notify" style="display:none;" class="sendmail_alert">
	We are proceeding to send mail to selected players!
</div>


<div class="fromtitle">Tournament Details<!--<div style="clear:both"></div>-->
<div class="fb-like" data-href="<?php echo base_url(); ?>league/view/<?php echo $tour_details->tournament_ID; ?>" data-layout="button_count" data-mobile-iframe="true" data-action="like" data-show-faces="false" data-share="true"></div>
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
<p><label>Duration:</label> <?php echo date('m/d/Y h:i',strtotime($tour_details->StartDate)); ?> - <?php echo date('m/d/Y h:i',strtotime($tour_details->EndDate)); ?></p>
<p><label>Registration Closes On:</label> <?php echo date ('m/d/Y h:i',strtotime($tour_details->Registrationsclosedon)); ?></p>
<p><label>Withdraw or Refund Date:</label> <?php echo date ('m/d/Y h:i',strtotime($tour_details->RefundDate)); ?></p>
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
if($tour_details->is_mult_fee == NULL and $tour_details->Tournamentfee == 1 and $tour_details->is_event_fee == 1 and $tour_details->Event_Reg_Fee!=NULL)
{
    $event_reg_fee=json_decode($tour_details->Event_Reg_Fee);

    foreach ($event_reg_fee as $Event => $Fees) 
    {
        $eventsarr = explode('_', $Event);

        if(count($eventsarr)>3){
           $num = (int)end($eventsarr);
           $ages=$eventsarr[1].'_'.$eventsarr[2];
        }else{
           $num=$eventsarr[2];
           $ages=$eventsarr[1];
        }

	    $level_name_arry = league::get_level_name('', $num);
	    $LevelName = $level_name_arry['SportsLevel'];
	    $event  = $eventsarr[0].'-'.$ages.'-'.$LevelName; 
    ?>
    <br> <label><?php echo $event;?>:</label> $<?php echo $Fees;?> 
  <?php 
   } 
}
else if($tour_details->is_mult_fee == 0 and $tour_details->Tournamentfee == 1)
{
        echo "$" .number_format($tour_details->TournamentAmount,2)." (Singles), ". "$" . number_format($tour_details->extrafee,2)." (Additional Format)";
} 
else if($tour_details->is_mult_fee == 1 and $tour_details->Tournamentfee == 1)
{
	$addln_event = '';
	$pay_type = '';
	if($tour_details->tournament_format != 'Teams'){ 
		$pay_type	 = 'First Event'; 
		$addln_event = '<td>Additional Events</td>'; 
	}
	if($tour_details->Fee_collect_type != '' and $tour_details->tournament_format == 'Teams')
	{ 
		$pay_type = 'Per ' . $tour_details->Fee_collect_type; 
	}

    echo "<table class='imagetable' border='1' cellpadding='10' cellspacing = '10'><tr><td>Age Group</td><td>{$pay_type}</td>{$addln_event}</tr>";

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
			case "U9":
				echo "Under 9";
				break;
			case "U10":
				echo "Under 10";
				break;
			case "U11":
				echo "Under 11";
				break;
			case "U12":
				echo "Under 12";
				break;
			case "U13":
				echo "Under 13";
				break;
			case "U14":
				echo "Under 14";
				break;
			case "U15":
				echo "Under 15";
				break;
			case "U16":
				echo "Under 16";
				break;
			case "U17":
				echo "Under 17";
				break;
			case "U18":
				echo "Under 18";
				break;
			case "U19":
				echo "Under 19";
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
		    if($tour_details->tournament_format != 'Teams')
		    { 
		       $addln_event_fee = "<td>$addn_mult_fee_array[$i]</td>"; 
		    }

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
case "U9":
echo "Under 9";
break;
case "U10":
echo "Under 10";
break;
case "U11":
echo "Under 11";
break;
case "U12":
echo "Under 12";
break;
case "U13":
echo "Under 13";
break;
case "U14":
echo "Under 14";
break;
case "U15":
echo "Under 15";
break;
case "U16":
echo "Under 16";
break;
case "U17":
echo "Under 17";
break;
case "U18":
echo "Under 18";
break;
case "U19":
echo "Under 19";
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
<p><label>Details and Rules:&nbsp;</label><a id="show_tour_details_rules" style="cursor:pointer;"><b>Show</b></a></p> 
<div id="tour_details" style="display:none;">
<?php echo html_entity_decode($tour_details->TournamentDescription);?>
</div>

<div class="col-md-12" style="padding-left:0px; margin-top:20px" id='draw_details'>


<?php $users_id = $this->session->userdata('users_id');
$is_reg = league::user_reg_or_not($users_id ,$tour_details->tournament_ID);

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

echo '<div class="col-md-4 txt-torn1" style="padding-left:0px; margin-bottom:20px"><a href="#div4" id="showdiv4" style="cursor:pointer;">Participants</a></div>';

echo '<div class="col-md-4 txt-torn1" style="padding-left:0px; margin-bottom:20px"><a href="#div5" id="showdiv5" 
style="cursor:pointer;">Upload Images</a></div>';

if($tour_details->tournament_format != 'Teams'){
	echo '<div class="col-md-4 txt-torn1" style="padding-left:0px; margin-bottom:20px"><a href="#div15" id="showdiv15" 
	style="cursor:pointer;">WithDraw Player</a></div>';
}
else{
/*	echo '<div class="col-md-4 txt-torn1" style="padding-left:0px; margin-bottom:20px"><a href="#div15" id="showdiv15" 
	style="cursor:pointer;">WithDraw Team</a></div>';*/
}

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

if($tour_details->tournament_format == 'Teams'){
echo "<div class='col-md-4 txt-torn1' style='padding-left:0px; margin-bottom:20px'><a style='cursor:pointer;' onclick='myWin_scorecard($tour_details->tournament_ID)'>Print Scorecard</a></div>";
echo '<div class="col-md-4 txt-torn1" style="padding-left:0px; margin-bottom:20px"><a href="#div10" id="showdiv10" style="cursor:pointer;">Manage Teams</a></div>';
}
//echo '<div class="col-md-4 txt-torn1" style="padding-left:0px; margin-bottom:20px"><a   onclick="refresh_blog($tour_details->tournament_ID)" style="cursor:pointer;">View Gallery</a></div>';
echo "<div class='col-md-4 txt-torn1' style='padding-left:0px; margin-bottom:20px'><a onclick='refresh_blog($tour_details->tournament_ID)' style='cursor:pointer;'>View Gallery</a></div>";

echo "<div class='col-md-4 txt-torn1' style='padding-left:0px; margin-bottom:20px'><a href=" . base_url() . "league/fixtures/$tour_details->tournament_ID  style='cursor:pointer;'>Create Draws</a></div>";

echo "<div class='col-md-4 txt-torn1' style='padding-left:0px; margin-bottom:20px'><a href=" . base_url() . "league/edit/$tour_details->tournament_ID  style='cursor:pointer;'>Edit tournament</a></div>";
if($tour_details->tournament_format != 'Teams'){
echo "<div class='col-md-4 txt-torn1' style='padding-left:0px; margin-bottom:20px'><a href=" . base_url() . "play/reg_players/$tour_details->tournament_ID  style='cursor:pointer;'>Register Players</a></div>";
}else{
echo "<div class='col-md-4 txt-torn1' style='padding-left:0px; margin-bottom:20px'><a href=" . base_url() . "league/add_players/$tour_details->tournament_ID  style='cursor:pointer;'>Register Players</a></div>";
}

echo "<div class='col-md-4 txt-torn1' style='padding-left:0px; margin-bottom:20px'><a href=" . base_url() . "play/invite/$tour_details->tournament_ID  style='cursor:pointer;'>Invite Players</a></div>";

}
else if($is_logged_user_reg and !array_key_exists($this->logged_user, $team_captains))
{

echo '<div class="col-md-4 txt-torn1" style="padding-left:0px; margin-bottom:20px">
<a href="#div2" id="showdiv2" style="cursor:pointer;">My Matches</a></div>
<div class="col-md-4 txt-torn1" style="padding-left:0px; margin-bottom:20px">
<a href="#div3" id="showdiv3" style="cursor:pointer;">Draws / Results</a></div>';

echo '<div class="col-md-4 txt-torn1" style="padding-left:0px; margin-bottom:20px"><a href="#div7" id="showdiv7"  style="cursor:pointer;">Participants</a></div>';
if($tour_details->tournament_format != 'Teams'){
$today_date	=	date('Y-m-d');
$curdate	=	strtotime($today_date);
$RefundDate	=	strtotime($tour_details->RefundDate);

/*echo "<div class='col-md-4 txt-torn1' style='padding-left:0px; margin-bottom:20px'>
<a href=".base_url()."league/register_more/$tour_details->tournament_ID style='cursor:pointer;'>My Events</a></div>";*/

if($curdate < $RefundDate OR $RefundDate == NULL OR $RefundDate == '1969-12-31 12:00:00.000'){
	echo '<div class="col-md-4 txt-torn1" style="padding-left:0px; margin-bottom:20px"><a href="#div17" id="showdiv17" 
	style="cursor:pointer;">WithDraw</a></div>';
}
}
echo '<div class="col-md-4 txt-torn1" style="padding-left:0px; margin-bottom:20px"><a href="#div5" id="showdiv5"  style="cursor:pointer;">Upload Images</a></div>';

echo "<div class='col-md-4 txt-torn1' style='padding-left:0px; margin-bottom:20px'><a onclick='refresh_blog($tour_details->tournament_ID)' style='cursor:pointer;'>View Gallery</a></div>";

echo "<div class='col-md-4 txt-torn1' style='padding-left:0px; margin-bottom:20px'><a href=" . base_url() . "play/invite/$tour_details->tournament_ID  style='cursor:pointer;'>Invite Friends</a></div>";

}
else if(array_key_exists($this->logged_user, $team_captains))		// Team Captains Block
{
echo '<div class="col-md-4 txt-torn1" style="padding-left:0px; margin-bottom:20px">
<a href="#div2" id="showdiv2" style="cursor:pointer;">My Matches</a></div>';

echo '<div class="col-md-4 txt-torn1" style="padding-left:0px; margin-bottom:20px">
<a href="#div3" id="showdiv3" style="cursor:pointer;">Draws / Results</a></div>';

echo '<div class="col-md-4 txt-torn1" style="padding-left:0px; margin-bottom:20px"><a href="#div7" id="showdiv7" style="cursor:pointer;">Participants</a></div>';

if($tour_details->tournament_format == 'Teams'){
echo "<div class='col-md-4 txt-torn1' style='padding-left:0px; margin-bottom:20px'><a style='cursor:pointer;' onclick='myWin_scorecard($tour_details->tournament_ID)'>Print Scorecard</a></div>";
}
echo '<div class="col-md-4 txt-torn1" style="padding-left:0px; margin-bottom:20px"><a href="#div9" id="showdiv9" class="'.$team_captains[$this->logged_user].'" style="cursor:pointer;">Manage Team</a></div>';

$get_event = league::get_team_track_event($tour_details->tournament_title);

echo '<div class="col-md-4 txt-torn1" style="padding-left:0px; margin-bottom:20px"><a href="'.base_url().'events/view/'.$get_event['Ev_ID'].'#div2" id="track_event" class="" style="cursor:pointer;">Team Tracker</a></div>';

echo '<div class="col-md-4 txt-torn1" style="padding-left:0px; margin-bottom:20px"><a href="#div16" id="showdiv16" class="teamlines_'.$team_captains[$this->logged_user].'"  style="cursor:pointer;">Line Tracker</a></div>';

echo '<div class="col-md-4 txt-torn1" style="padding-left:0px; margin-bottom:20px"><a href="#div5" id="showdiv5"  style="cursor:pointer;">Upload Images</a></div>';

echo "<div class='col-md-4 txt-torn1' style='padding-left:0px; margin-bottom:20px'><a onclick='refresh_blog($tour_details->tournament_ID)' style='cursor:pointer;'>View Gallery</a></div>";

echo "<div class='col-md-4 txt-torn1' style='padding-left:0px; margin-bottom:20px'><a href=" . base_url() . "play/invite/$tour_details->tournament_ID  style='cursor:pointer;'>Invite Friends</a></div>";
}
else
{
$now =  strtotime("now"); $oneday = 86400;
//$reg_close = strtotime($tour_details->Registrationsclosedon) + $oneday;
$reg_close = strtotime($tour_details->Registrationsclosedon);

if($now < $reg_close){
echo "<div class='col-md-4 txt-torn1' style='padding-left:0px; margin-bottom:20px'><a href=" . base_url() . "league/register_match/$tour_details->tournament_ID  style='cursor:pointer;'>Register</a></div>";
}
echo '<div class="col-md-4 txt-torn1" style="padding-left:0px; margin-bottom:20px">
<a href="#div3" id="showdiv3" style="cursor:pointer;">Draws / Results</a></div>';

echo '<div class="col-md-4 txt-torn1" style="padding-left:0px; margin-bottom:20px"><a href="#div7" id="showdiv7"  style="cursor:pointer;">Participants</a></div>';

echo "<div class='col-md-4 txt-torn1' style='padding-left:0px; margin-bottom:20px'><a onclick='refresh_blog($tour_details->tournament_ID)' style='cursor:pointer;'>View Gallery</a></div>";

}
?>
</div>
</div>

<!-- -------------------------------Comments Section ----------------------------- -->
<div class='col-md-4'>

 <img class="scale_image" src="
<?php echo base_url(); ?>tour_pictures/<?php 
if($tour_details->TournamentImage!=""){ echo $tour_details->TournamentImage; }

else if($tour_details->SportsType == 1){ echo "default_tennis.jpg"; }
else if($tour_details->SportsType == 2){ echo "default_table_tennis.jpg"; }
else if($tour_details->SportsType == 3){ echo "default_badminton.jpg"; }
else if($tour_details->SportsType == 4){ echo "default_golf.jpg"; }
else if($tour_details->SportsType == 5){ echo "default_racquet_ball.jpg"; }
else if($tour_details->SportsType == 6){ echo "default_squash.jpg"; }
else if($tour_details->SportsType == 7){ echo "default_pickleball.jpg"; }
else if($tour_details->SportsType == 8){ echo "default_chess.jpg"; }
else if($tour_details->SportsType == 9){ echo "default_carroms.jpg"; }
?>" alt="" /> 

		<div class="col-md-12" align='center'><h4 style="margin-top:25px;">Tourney Talk</h4></div>
		<?php if($this->logged_user){?>
		<div class='col-md-9 form-group internal' style='padding-right:0px'>
		<input type='text' name="message" id="message" placeholder="Talk to your fellow players" class='form-control col-md-9' />
		</div>
		<div class='col-md-3 form-group internal' align='center'>
		<input type="button" name='send_comment' id='send_comment' value="Add" class="league-form-submit1" style="padding:8px;22px;"/>
		</div>
	   <?php } ?>

		<div class="col-md-12"><br></div>
		<div class="col-md-12" style="overflow-y:scroll;height:270px;">

		<div id="comments_div" class="col-md-12">
		<?php
		if($tourn_comments){
		foreach($tourn_comments as $comment){ 
		$name = league :: get_user($comment->Users_Id);
		?>
			<div class='pull-left' style="margin-right:20px"><img style="width:50px !important; height:50px !important;" class='img-circle' src='<?php 
			if($name['Profilepic'] != "" and $name['Profilepic'] != 'NULL'){
			echo base_url()."profile_pictures/$name[Profilepic]"; }
			else{
			echo base_url()."profile_pictures/default-profile.png"; }
			?>' />
			</div>
			<div style="margin-top:5px; display:table">
				<?php echo "<span style='font-weight:bold; color:#464646'>".ucfirst($name['Firstname'])." ".ucfirst($name['Lastname'])."&nbsp;&nbsp;</span>"; ?> <?php echo "<span style='font-size:11px; color:#959595'>".date("m/d/Y H:i", strtotime($comment->Comment_On))."</span><br>"; ?>
				<?php echo $comment->Comments; ?>
			</div>
			<div style='clear:both; height:20px'></div>
		<?php
		}
		}
		else{
		?>		
			No comments added yet!
		<?php 
		}?>
		</div>
		</div>	
</div>
<!-- -------------------------------Comments Section ----------------------------- -->

<!--<div class="col-md-3" style="padding-right:50px">
<div class="fb-share-button" data-href=" . base_url() . "<?php echo $tour_details->tournament_ID; ?>" data-layout="button" data-mobile-iframe="true"></div>
</div>-->

</form>

</div>

<!---------------------------------------------------Add Score --------------------------------------------------- -->

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
//echo 'check_user '.$check_user; exit;

if($check_user){
?>
<tr>
<form id="frm_mymatches" action="<?php echo base_url();?>league/view_matches/#draw_details" method="post">

<td>&nbsp;<b><?php echo $bk->Draw_Title; ?> </b></td>
<td><b><?php echo '<input type="submit" name="list_draw_matches'.$bk->BracketID.'" id="list_draw_matches'.$bk->BracketID.'" value="Show Matches" class="league-form-submit1" />'; ?></b></td>

<input type='hidden' name='tourn_id'   value = "<?php echo $tour_details->tournament_ID; ?>" />
<input type='hidden' name='tourn_type' value = "<?php echo $bk->Bracket_Type; ?>" />
<input type='hidden' name='match_type' value = "<?php echo $bk->Match_Type; ?>" />
<input type='hidden' name='age_group'  value = "<?php echo $bk->Age_Group; ?>" />
<input type='hidden' name='bracket_id' value = "<?php echo $bk->BracketID; ?>" />
<input type='hidden' name='tour_admin' value = "<?php echo $tour_details->Usersid;?>" />
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

<!-- ----------------------------------------- Admin view for Participants ----------------------------------------- -->        
<?php

if($tour_details->tournament_format != 'Teams'){

$participants_names = league::get_reg_tourn_player_names($tour_details->tournament_ID);
//echo "<pre>";print_r($participants_names);
$tot_participants = count($participants_names);
}
else{
$tot_participants = league::get_participant_count($tour_details->tournament_ID); 
}

if($tour_details->Usersid == $this->logged_user){
?>
<script>
$(document).ready(function(){

	$('#show_pay_info').click(function(){
		$('#tourn_participants').toggle();
		$('#tourn_participants_payment').toggle();
		
		if($('#pinfo_label').html() == 'Show Payment Info.'){
				$('#pinfo_label').html('Show Participants');
		}
		else{
				$('#pinfo_label').html('Show Payment Info.');
		}
	});

});

</script>
<div class="col-md-12 league-form-bg" style="margin-top:40px; background:#fff; margin-bottom:20px; display:none;" id="div4">

<div class="fromtitle">Participants <?php if($tot_participants){ echo "(".$tot_participants.")"; } ?></div>
	<?php
	if($tour_details->tournament_format != 'Teams'){?>
<div style="text-align:right;">
<a id="show_pay_info" style="cursor:pointer;"><span id='pinfo_label' style="font-size:14px;font-weight:bold;">Show Payment Info.</span></a>
</div>
	<?php } ?>
	<div id='tourn_participants'>
	<?php
	if($tour_details->tournament_format != 'Teams'){
	$this->load->view('tournament/view_adm_participants');  // Load Participants view 
	}
	else{
	$this->load->view('teams/view_adm_team_participants');  // Load Team Participants view 
	}
	?>
	</div>
	<div id='tourn_participants_payment' style='display:none;'>
	<?php
	if($tour_details->tournament_format != 'Teams'){
	$this->load->view('tournament/view_participants_payment');  // Load Tourn Participants Fee Info
	}
	else{
	//$this->load->view('teams/view_team_participants_payment');  // Load Team Participants Fee Info 
	}
	?>	
	</div>
</div>

<!-- Admin view for Manage Team-->

<div class="col-md-12 league-form-bg" style="margin-top:40px; background:#fff; margin-bottom:20px; display:none;" id="div10">
<div id='team_div' class="fromtitle">Add / Manage Team Players</div>
<div class='col-md-3 control-label'>
<p><label>Choose Team:</label>
<select class="form-control" id="teamlist" name="team_list">
<option value="">Select</option>
<?php foreach($tourn_teams as $team){ ?>
<option value="<?php echo $team->Team_ID;?>"><?php echo $team->Team_name;?></option>
<?php 
} 
?>
</select>
</p>
</div>
<div class='col-md-10' id="load_manage_team">
</div>
</div>
<!-- Admin view for Manage Team-->


<!---------------------------------------------------Admin view for WithDraw -------------------------------------------------->

<div class="col-md-12 league-form-bg" style="margin-top:40px; background:#fff; margin-bottom:20px; display:none;" id="div15">
<div class="fromtitle">Withdraw</div>
<?php
if($tour_details->tournament_format != 'Teams'){
$this->load->view('tournament/view_adm_withdrawnew');  // Load Withdraw view 
}
else{
//$this->load->view('teams/view_adm_team_withdraw');  // Load Team Withdraw view 
}
?>
</div>

<?php
}
?>
<!------------------------------------------------Draws / Results------------------------------------------------------ -->        

<div class="col-md-12 league-form-bg" style="margin-top:40px; background:#fff; margin-bottom:20px; display:none;" id="div3">
<div class="fromtitle">Draws / Results</div>

<table class="tab-score">
<?php 
$brackets = league::get_bracket_list($tour_details->tournament_ID);

if(count(array_filter($brackets)) > 0){  ?>

<!-- 
<tr class="top-scrore-table">
<th width="15%">Draw Title</th>
<th width="15%">Match Type</th>
<th width="15%">Age Group</th>
<th width="15%">Action</th>
</tr>
-->
<?php foreach($brackets as $bk)
{
?>
<tr>

<form id="your_form" action="<?php echo base_url(); ?>league/viewbracket/#draw_details" method="post">
<?php
$users_id = $this->session->userdata('users_id');
if($tour_details->Usersid == $users_id)    /// tournament admin access links
{
echo '<td><input type="checkbox" name="tour_draws_delete" id="delete_draws_'.$bk->BracketID.'" class="delete_draws" value="'.$bk->BracketID.'"></td>';
}
?>
<td><b><?php echo $bk->Draw_Title; ?></b></td>
<td><b><?php //echo $bk->Match_Type; ?></b></td>
<td><b><?php //echo $bk->Age_Group; ?></b></td>

<td>
<b><?php echo '<input type="submit" name="tour_draw_show'.$bk->BracketID.'" id="submit" value="Show Draw" class="league-form-submit1"/>'; ?></b>
</td>

<?php
if($tour_details->Usersid == $users_id)    // tournament admin access links
{
?>
<td>
<b><?php echo '<input type="submit" name="tour_draw_edit'.$bk->BracketID.'" id="submit" value="Edit Draw" class="league-form-submit1"/>'; ?></b>
</td>
<?php
}
?>
<input type='hidden' name='tourn_id' value = "<?php echo $tour_details->tournament_ID; ?>">
<input type='hidden' name='tformat'  value = "<?php echo $tour_details->tournament_format; ?>" />
<input type='hidden' name='template' value = "view_tournament">
<!-- <input type='hidden' name='tourn_type' value = "<?php echo $tour_details->Tournament_type; ?>"> -->
<input type='hidden' name='tourn_type' value = "<?php echo $bk->Bracket_Type; ?>">
<input type='hidden' name='match_type' value = "<?php echo $bk->Match_Type; ?>">
<input type='hidden' name='age_group'  value = "<?php echo $bk->Age_Group; ?>">
<input type='hidden' name='bracket_id' value = "<?php echo $bk->BracketID; ?>">
<input type='hidden' name='tour_admin' value = "<?php echo $tour_details->Usersid;?>">

</form>
</tr>
<?php
}
}
else{

echo "<tr><td>No Draws are available</td></tr>";
}
?>

</table>

<?php

if(count(array_filter($brackets)) > 0)
{  
if($tour_details->Usersid == $users_id)    /// tournament admin access links
{
echo '<input type="button" name="tour_draws_delete_button" id="delete" class="league-form-submit1" value="Delete Draws">
<input type="hidden" name="tourn_format" id="tourn_format" value="'.$tour_details->tournament_format.'">';
}
}
?>
</div>

<!-- --------------------------- Upload Tournament Images ----------------------------------------  -->   

<div class="col-md-12 league-form-bg" style="margin-top:40px; background:#fff; margin-bottom:20px; display:none;" id="div5">
<div class="fromtitle">Upload Tournament Images</div>

<form method='post' enctype='multipart/form-data' action="<?php echo base_url(); ?>league/upload_pics" role='form' >
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


<!-- ---------------------------Tournament Players update -----------------------------------------------  -->   

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
/*
echo "<pre>dfdsf";
print_r($tourn_partner_names);
exit;
*/	
//if(!$tourn_partner_names){
if($tourn_partner_names){
?>
<form method='post' enctype='multipart/form-data' action="<?php echo base_url(); ?>league/update_players" role='form'>

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

<!--
<div class='col-md-3'>
<input type="submit" id="update_player" name="update_player"  value="Update" class="league-form-submit" style=""/>
</div>
-->	   
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
<div class="fromtitle" style="padding-left:40px;">Tournament Participants<?php if($tot_participants){ echo "(".$tot_participants.")"; } ?></div>

<form method="post" id="your_form"  action="<?php echo base_url(); ?>" class="register-form"> 
<?php
if($tour_details->tournament_format != 'Teams'){
$this->load->view('tournament/view_participants');  // Load Participants view 
}
else{
$this->load->view('teams/view_team_participants');  // Load Participants view 
}
?>
<input type='hidden' id="tourn_id"  name='tourn_id' value="<?php echo $tour_details->tournament_ID; ?>">
<input type='hidden' id='tourn_type' name='tourn_type' value = "<?php echo $tour_details->Tournament_type; ?>">
<input type='hidden' id='sport' name='sport' value="<?php echo $tour_details->SportsType; ?>" />
</form>
</div>
<?php
if($this->logged_user){
?>
<div class="col-md-12 league-form-bg" style="margin-top:40px; background:#fff; margin-bottom:20px; display:none;" id="div17">
<div class="fromtitle">Withdraw</div>

<?php
if($tour_details->tournament_format != 'Teams'){
    $this->load->view('tournament/view_participant_withdraw');
}
?>
</div>
<?php
}
?>

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

<!-- --------------------------view gallery link section end----------------------------------------------------  --> 

<div class="col-md-12 league-form-bg" style="margin-top:40px; background:#fff; margin-bottom:20px; display:none;" id="div9">
<!-- ---------------------------- Manage Tournament Participation Team ------------------------  --> 
</div>

<!-- ---------------------------- View Line Tracker for team captains -------------------------  --> 
<div class="col-md-12 league-form-bg" style="margin-top:40px; background:#fff; margin-bottom:20px; display:none;" id="div16">
<div class="fromtitle">Team Player's Line Tracker</div>
<br />
  <select class="form-control" id="brackets_list" style='width:50%' onchange="getlines('<?php echo $team_captains[$this->logged_user];?>');">
	<option value=''>Select Bracket</option>
	<?php foreach($brackets as $key=>$bracket){ ?>
     <option value="<?php echo $bracket->BracketID;?>" ><?php echo $bracket->Draw_Title;?></option>
	<?php } ?>
</select>
<select class="form-control" id="teams_list" style='width:50%' onchange="getlines(this.value);">
	<option value=''>Select Teams</option>
	<?php foreach($tourn_teams as $key=>$team){ ?>
     <option value="<?php echo $team->Team_ID;?>" ><?php echo $team->Team_name;?></option>
	<?php } ?>
</select>

</div>
<!-- ---------------------------- End of section - View Line Tracker for team captains -------------------------  --> 

<?php
if(isset($no_bracket)){
?>
<div class="name" align='left' id="no_result">
<label for="name_login" style="color:red">
<?php 
echo $no_bracket; 
unset($no_bracket);
?></label>
</div>
<?php
} 
else if(isset($bracket_matches) or isset($po_bracket_matches) or isset($get_po_tourn_matches) or isset($get_tourn_matches) or isset($rr_bracket_matches) or isset($get_rr_tourn_matches) or isset($bracket_matches_main) or isset($golf_bracket_matches) or isset($get_golf_tourn_matches) or isset($golf_tourn_matches))
{
?>
<div class="col-md-12 league-form-bg" id="div22">
<div class="general general-results players view-brack1">
<div class="" id="">

<!-- --------------------------------------------- -->
<?php
if(isset($bracket_matches) and !isset($se_line_matches)){
	$this->load->view('view_se_addscore');
}

else if(isset($bracket_matches) and isset($se_line_matches)){
	$this->load->view('teams/view_team_se_addscore');
}

else if(isset($po_bracket_matches) and isset($po_line_matches)){
	$this->load->view('teams/view_team_po_addscore');
}

else if(isset($bracket_matches_main) && isset($bracket_matches_cd)){
	$this->load->view('view_cd_addscore');
}

else if(isset($get_tourn_matches) && !isset($get_cd_tourn_matches) && !isset($get_se_line_matches)){
	$this->load->view('view_se_draws');
}

else if(isset($get_tourn_matches) && !isset($get_cd_tourn_matches) && isset($get_se_line_matches)){
	$this->load->view('teams/view_team_se_draws');
}

else if(isset($get_po_tourn_matches) and isset($get_po_line_matches)){
	$this->load->view('teams/view_team_po_draws');
}

else if(isset($get_tourn_matches) && isset($get_cd_tourn_matches)) {
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
	$this->load->view('teams/view_team_rr_draws');
}

else if(isset($rr_bracket_matches) and isset($rr_line_matches)){
	$this->load->view('teams/view_team_rr_addscore');
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



</div>