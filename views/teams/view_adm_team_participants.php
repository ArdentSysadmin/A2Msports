<script src="<?=base_url();?>/assets/tinymce/tinymce.min.js"></script>
<script>

tinymce.init({
  selector: 'textarea',
  height: 300,
  theme: 'modern',
  plugins: [
    'advlist autolink lists link image charmap print preview hr anchor pagebreak',
    'searchreplace wordcount visualblocks visualchars code fullscreen',
    'insertdatetime media nonbreaking save table contextmenu directionality',
    'template paste textcolor colorpicker textpattern imagetools codesample toc help'
  ],
  toolbar1: 'undo redo | insert | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image',
  toolbar2: 'print preview media | forecolor backcolor emoticons | codesample help',
  image_advtab: true,
  templates: [
    { title: 'Test template 1', content: 'Test 1' },
    { title: 'Test template 2', content: 'Test 2' }
  ],
  content_css: [
    '//fonts.googleapis.com/css?family=Lato:300,300i,400,400i',
    '//www.tinymce.com/css/codepen.min.css'
  ]
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

/*  Send mail with an attachment to all participants*/

$(document).ready(function(){

$('.join_submit').click(function(){
var baseurl = "<?php echo base_url();?>";
var team_id		= $(this).attr('id');
var tour_id		= $('#tourn_id').val();

if(team_id!="" && tour_id!=""){
	$.ajax({
	type:'POST',
	url:baseurl+'teams/join_request/',
	data:{ tourn_id:tour_id,team_id:team_id},
	success:function(html){
		if(html == 1)
		{ window.location.replace(baseurl+"teams/thanks/1"); }
		else
		{ 
			var msg = 'Join Request already sent!';
			alert(msg);
			$('#join_err_'+team_id).show();
			$('#join_err_'+team_id).html(msg);
		}
	}
	}); 
}
});

$('#send_mail').click(function(){
  if ($(this).prop('checked') == true){
    var count=$('input:checkbox.tm_participants_cls:checked').length;
	//alert(count);
    if(count==0){
    $('#send_mail').attr('checked', false);
   // $("error_alert").html("Please select participants to send mail!");
     alert("Please select participants to send mail!"); 
     //die();
    }
	else{
      $("#email_section").show(); 
    }   
  }
  else{
    $("#email_section").hide();
  }
});

$("form#frm_send_mail").submit(function(){
alert('t');
});
$("#send").click(function(){
//$("form#frm_send_mail").submit(function(){
	//alert("test");
  var baseurl = "<?php echo base_url();?>";

  var player_id=[];
  var count=$('input:checkbox.tm_participants_cls:checked').length;
    if(count==0){
      //$("error_alert").html("Please select participants to send mail!");
     alert("Please select participants to send mail!");
	 return false;
     //die();
    }
   $('input[name="prtcpnts_mail_check"]:checked').each(function() {
     player_id.push(this.value);
   });
   
   var tourn_id = $("#tourn_id").val();
   var sub		= $("#subject").val();
   var formData = new FormData($('#frm_send_mail')[0]);

   //var msg_body = $("#message").val();
   var msg_body = tinymce.get("message").getContent();
   formData.append('msg', msg_body);
   formData.append('player_id', player_id);
   formData.append('tourn_id', tourn_id);
   formData.append('sub', sub);

   //alert(msg_body);die();
    $.ajax({
        url: baseurl+'league/sendmail_tm_participants',
        type: 'POST',
        data: formData,
        async: false,
        success: function (data){
          //alert(data);die();
            if(data == true){
                $("#error_alert").show();
                $("#error_alert").html("<font style='color:blue'>Email to the player will be sent soon!</font><br />");
                $('#send_mail').trigger('click');
                  $('html, body').animate({
                    scrollTop: ($("#error_alert").offset().top)
                  },500);
            }
        },
        cache: false,
        contentType: false,
        processData: false
    });

    return false;
});

$('.sportslevels').change(function(e){
	var upd_level = $(this).val();
	if(upd_level != ''){
	var res = window.confirm('Are you sure to change the level?');
		if(res){
		var teamid = $(this).attr('id');
		var tournament_id = '<?php echo $tour_details->tournament_ID; ?>';
		 $.ajax({
				url: baseurl+'league/update_teams_levels',
				type: 'POST',
				data: {reg_levels:upd_level, team_id:teamid, tourn_id:tournament_id},
				async: true,
				success: function (res){
					if(res){
						alert('Level Updated Successfully...');
					}
					else{
						alert('Level Not Updated...');
					}
				}
			});
		}
	}
	else{
		alert('Select a valid level to change!');
	}
});

});

/*End Send mail with an attachment to all participants*/
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
</style>
<span align='right'>
<a href="<?=base_url();?>teams/addnew"><input type="button" name="create_team" id="create_team" value="Create Team" class="league-form-submit"></a>
</span>
<div class='col-md-12'>
<div id="participants-users" style=" margin: auto;overflow-y: scroll;overflow-x: scroll;height:auto;width: auto;">
<div class="container2">

<table class="tab-score">
<?php 
$tourn_reg_teams = league::get_reg_team_participants($tour_details->tournament_ID);
if(count(array_filter($tourn_reg_teams)) > 0) {
?>
<tr>
<!-- <th width="5%" class="score-position">Select</th> -->
<th width=""><input type="checkbox" name="select_all_chk" id="select_all_chk" class="tourn_participants_cls"></th>
<th style="padding-left:40px;">Team</th>
<th style="padding-left:20px;">Level</th>
<th style="padding-left:20px;">Home Location</th>
<!-- <th style="padding-left:30px;">&nbsp;</th> -->
</tr>


<?php
foreach($tourn_reg_teams as $name)
{
?>
<tr>
<td><input type="checkbox" name="mail_check[]" onclick="check_tourn_prtcpnts('<?php echo $name->Team_id;?>');" id="tourn_participants_<?php echo $name->Team_id;?>" class="tourn_participants_cls"></td>
<td style="padding-left:40px;">
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
foreach($tour_team_players as $tp){

	if($tour_details->Tournamentfee == 1 and $tour_details->Fee_collect_type == 'Player'){
		$is_player_paid = league::check_is_player_paid($tp, $tour_details->tournament_ID, $name->Team_id);
	}

		$get_usatt_det = 0;
		if($tour_details->SportsType == 2){
			$get_usatt_det = league::is_user_have_usatt_table_entry($tp);
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
	$usatt_info  = '';

	if($tp == $team['Captain']){ 
		$captain_ico = "<img src='".base_url()."icons/letter_c.png' title='Captain' style='width:15px; height:15px;' />"; 
	}
	if(!empty($is_player_paid)){   // and $is_player_paid['Transaction_id']){ 
		/*$paid_ico = "<img src='".base_url()."icons/letter_p.png' title='$".number_format($is_player_paid['Amount'],2)." Paid' style='width:21px; height:21px;' />"; */
		$paid_ico = "<img src='".base_url()."icons/letter_p.png' title='Paid' style='width:21px; height:21px;' />"; 
	}

	if(!empty($get_usatt_det)){ 
		//$usatt_info = "&nbsp;&nbsp;USATT #: " . $get_usatt_det['Member_ID'] . " (Rating: " . $get_usatt_det['Rating'] . ")"; 
		$usatt_info = "&nbsp;&nbsp;USATT Rating: " . $get_usatt_det['Rating']; 
	}
	else if($tour_details->SportsType == 2){
		$usatt_info = "&nbsp;&nbsp;USATT Rating: N/A"; 
	}

    echo "<li style='padding-left:25px;padding-bottom:5px;list-style:none;'><input type='checkbox' name='prtcpnts_mail_check' id='tm_participants_".$player['Users_ID']."' class='tm_participants_cls prtcpnts_mail_check_".$name->Team_id."' value='".$player['Users_ID']."' />&nbsp;";
	echo "<a href='".base_url()."player/".$player['Users_ID']."' target='_blank' title='".$player['Mobilephone']."'>".$player['Firstname']." ".$player['Lastname']."</a> ".$gender."&nbsp;{$captain_ico}&nbsp;{$paid_ico}{$usatt_info}</li>";
}

echo "</ul></div>";
?>
</td>

<td style="padding-left:20px;">
<select class="form-control sportslevels" name='sportslevels' id='<?php echo $name->Team_id;?>'>
<option value=''>-Select-</option>
<?php
//if($name->Reg_Sport_Level != "")
//{
//$get_level = league::get_level_name($tour_details->SportsType, $name->Reg_Sport_Level);
//echo $get_level['SportsLevel']; 
$levels = json_decode($tour_details->Sport_levels);
foreach($levels as $levels1){
	$get_level_dropdown = league::get_level_name('',$levels1);
?>
 	<option value='<?php echo $levels1;?>'<?php if($name->Reg_Sport_Level == $levels1) 
	   echo 'selected'; ?>><?php echo $get_level_dropdown['SportsLevel'];?></option> 
<?php
}
//}
?>
</select>
</td>

<td style="padding-left:20px;">
<?php
if($team['Home_loc_id']){
$team_home_loc = league::get_home_location($team['Home_loc_id']);

$map_url = "https://www.google.co.in/maps/place/".$team_home_loc['hcl_address']."+".$team_home_loc['hcl_city']."+".$team_home_loc['hcl_state']."+".$team_home_loc['hcl_country'];

echo "<a href='".$map_url."' title='".$team_home_loc['hcl_address'].", ".$team_home_loc['hcl_city'].", ".$team_home_loc['hcl_state'].", ".$team_home_loc['hcl_country']."' target='_blank'>".$team_home_loc['hcl_title']."</a>";
}
else{
echo "< None >";
}
?>
</td>

<!-- <td style="padding-left:40px;"> ->
<?php
/*$is_tourn_player = league::is_tourn_reg_player($tour_details->tournament_ID);
if(!$is_tourn_player and $this->logged_user != $tour_details->Usersid){*/
?>
<!-- <input name="join_submit" id="<?//=$name->Team_id;?>" type="button" value="Request Join" class="league-form-submit join_submit" style="margin:2px;" /> -->
<!-- <div id="join_err_<?//=$name->Team_id;?>" style='color:red'></div> -->
<?php
//} ?>
<!-- </td> -->
</tr>
<?php 
}
}
else {
?>
<tr><td colspan='6'><b>No Teams are registered yet. </b></td></tr>
<?php } ?>
</table>
</div>
</div>
</div>
<br />
<?php if($tour_details->Usersid == $this->logged_user){?>
<div style='margin-top:10px;' class="col-md-12 league-form-bg">
<span id="error_alert"></span>
<input type="checkbox" value="" name="send_mail_to_participants" id="send_mail">
Click and Send mail to all participants:
<div id='email_section' style="display:none;">
  <form method="POST" name='frm_send_mail' id="frm_send_mail" enctype="multipart/form_data"/>
   <!--input type = "file" name="attach_file" id="attach_file" required="" --> 
   <input type = "hidden" name="tourn_id" id="tourn_id" value="<?php echo $tour_details->tournament_ID;?>"> 
   <br /><input type="text" name="subject" id="subject" class="form-control" placeholder="Enter Subject Here">
   <br />
   <textarea name="message" id="message"  cols="155" rows="5"></textarea>
  <br /><input type="submit" name="send" id="send" value="Send Mail" class="league-form-submit" />
 </form>
 </div>
</div>
<?php }?>