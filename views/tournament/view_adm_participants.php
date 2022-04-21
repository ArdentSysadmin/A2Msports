<!-- <script src="<?=base_url();?>/assets/tinymce/tinymce.min.js"></script> -->
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
  ],
relative_urls : false,
remove_script_host : true,
convert_urls : false
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

var club_baseurl = "<?php echo $club_url; ?>";


$("#select_all_chk").click(function(){
   $(".tourn_participants_cls").prop("checked", $("#select_all_chk").prop("checked"))
   $(".tm_participants_cls").prop("checked", $("#select_all_chk").prop("checked"))
});

$( "#select_all_players").click(function(){
	if ($("#select_all_players").prop('checked')==true){
     $(".tm_participants_cls").prop('checked', true);
    }
	else{
     $(".tm_participants_cls").prop('checked', false);
    }
});

/*  Send mail with an attachment to all participants*/

$('#send_mail').click(function(){
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
   formData.append('player_id', player_id);
   formData.append('sub', $('#subject').val());
   //alert(msg_body);die();
    $.ajax({
        url: club_baseurl+'league/sendmail_tm_participants',
        type: 'POST',
        data: formData,
        async: false,
        success: function (data){
          //alert(data);die();
            if(data == true){
                $("#sendmail_notify").show();
                $("#send_mail_frm").hide();
                  $('html, body').animate({
                    scrollTop: ($("#sendmail_notify").offset().top)
                  },500);
            }
        },
        cache: false,
        contentType: false,
        processData: false
    });

    return false;
});

/*End Send mail with an attachment to all participants*/
$(document).ready(function (){
	$('#ev_draw_filter').change(function(){
	var df			= $(this).val();
	var btn_val	= "<?php echo $btn_val; ?>";
	var tourn_id = $('#tourn_id').val();

			$.ajax({
				type:'POST',
				url:club_baseurl+'league/load_adm_participants/',
				data:{club_url:club_baseurl,tid:tourn_id,df:df},
				success:function(res){
				   $('#tourn_participants').html("");
				   $("#tourn_participants").html(res);
				}
			});
	});

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

	$('.user_change_partner').change(function(){
		var id  = $(this).attr('id');
		var x   = id.split('_');
		var Player   = x[4];
		var Partner = $(this).val();
		var Event	= $('#chp_event_'+x[0]).val();

		//alert(x[0]);
		//alert(x[4]);
		//alert($(this).val())
		if(Partner != ''){
		if(confirm("Are you sure to update your event partner?")){
			//alert(Event);
			var Tourn_type = $('#tourn_type').val();
			var Tourn_id		= $('#tourn_id').val();

		$.ajax({
			type:'POST',
			url:baseurl+'league/double_players_change/',
			data:{ tourn_id:Tourn_id, ttype:Tourn_type, partner:Partner, player:Player, event:Event },    //{pt:'7',rngstrt:range1, rngfin:range2},
			success:function(html){
				$('#dbl-load-users').html(html);
				var cur_sel = $('.event_change').val();
				//get_partners_jq(Tourn_id, cur_sel);
				alert("Event Partner updated successfully. Refresh the page to view the updation.");
				//location.reload();
			}
		});
		}
	}

	});

});
</script>

<div class='form-group'>
<div class='col-md-12 control-label'>
<div class="col-md-5"></div>
<div class="col-md-3" style="text-align: right; font-size:16px;">
	<?php
	//if(($this->logged_user == 239 or $this->is_super_admin or $this->logged_user == $tour_details->Usersid)){
	?>
	<!-- <div>
	<a id="show_pay_info" style="cursor:pointer;"><span id='pinfo_label'>Show Payment Info.</span></a>
	</div>  -->
	<?php
	//}
	?>
</div>
<div class="col-md-4" align="right">
<select class="form-control" id='ev_draw_filter' name='draw_filter' style="width:60%;">
<option value=''>Show All</option>
<option value="Men's Singles" <?php if($df == "Men's Singles") echo "selected"; ?>>Men's Singles</option>
<option value="Men's Doubles" <?php if($df == "Men's Doubles") echo "selected"; ?>>Men's Doubles</option>
<option value="Women's Singles" <?php if($df == "Women's Singles") echo "selected"; ?>>Women's Singles</option>
<option value="Women's Doubles" <?php if($df == "Women's Doubles") echo "selected"; ?>>Women's Doubles</option>
<option value="Mixed Doubles" <?php if($df == "Mixed Doubles") echo "selected"; ?>>Mixed Doubles</option>
</select>
</div>

<?php
$res  = league::get_reg_tourn_participants_withGender($tour_details->tournament_ID, $tour_details->SportsType);

$reg_users			= $res[0];
$user_tsize			= $res[1];
$user_partners		= $res[2];
$user_names		= $res[3];
//if($this->logged_user == 240 and $df){ echo "<pre>"; print_r($res); exit; }
?>

<div class="col-md-12 league-form-bg" style="margin-top:15px; margin-bottom:0px;">
<table class="tab-score">

<tr>
<td class="score-position" valign="center" style="text-align:left">
<?php
if($tour_details->Usersid == $this->logged_user or $this->is_super_admin) {
 ?>
<input type="checkbox" name="select_all_players" id="select_all_players" class="select_all_players_chk" > &nbsp;
<?php
}
 ?>
<b>Events</b></td>
</tr>

<?php
$keys = 0;
//if(count($reg_users) > 0){

$waitlist_users = NULL;
if($tour_details->Event_Reg_Limit)
$waitlist_users = league :: GetWaitListUsersNew($tour_details->tournament_ID);

$event_format = array();
	if($tour_details->Multi_Events != NULL){
	  $events		= json_decode($tour_details->Multi_Events, true);
	  $event_format = league::regenerate_events($events);
	}
	else{
	  $events	= league::GetTournamentEvents($tour_details);
	  foreach ($events as $ages => $evnts){
		$formatted_arr = league::regenerate_events($evnts);
		foreach ($formatted_arr as $e_code => $e_label){
			$event_format[$e_code] = $e_label;
		}
	  }
	}
if($this->logged_user == 240){
//echo "<pre>"; print_r($event_format);
//echo "<pre>"; print_r($res); exit;
}


if($df){
	$new_event_format = array();
	foreach($event_format as $ev => $ef) {
		$pos = strpos($ef, $df);

		if ($pos > -1) {
			$new_event_format[$ev] = $ef; 
		}
	}
	$event_format = $new_event_format;
}

//foreach ($events as $ages => $evnts) {
	$p = 1;
   foreach ($event_format as $k => $evnt){

    $evntarr   = explode("-", $k);

    $ag				  = $evntarr[0];
    $genderkey  = $evntarr[1];
    $fr         = $evntarr[2];
    $lv         = $evntarr[3];
	//echo count($reg_users); exit;
	if(count($reg_users) > 0){
	$get_level	= league::get_level_name($tour_details->SportsType, $lv);
	//$users			= league::in_array_r($k, $reg_users);
	$users			= league::in_array_r_sort($k, $reg_users, $user_partners);
//if($this->logged_user == 240){
//echo "<pre>"; echo $k."<br />--------<br />"; print_r($users); echo "<br />--------<br />"; //exit;
//}
	}
//if($this->logged_user == 240){
	//echo "<pre>"; print_r($reg_users); //exit;
	//echo "<pre>"; print_r($user_partners); //exit;
	//echo "<pre>"; print_r($users); exit;
	//	$users			= league::in_array_r_sort($k, $reg_users, $user_partners);
	//echo "<pre>"; print_r($users); //exit;
//}
	$event_label = $evnt;
	$event_key = $k;

if(count($reg_users) == 0 or count($users) == 0 or empty($users)){
  if($genderkey  == 1){
  $empty_reg_men_events[] = $event_label;
  }
  elseif($genderkey == 0){
  $empty_reg_women_events[] = $event_label;
  }
  elseif($genderkey == 2){
  $empty_reg_mixed_events[] = $event_label;
  }
  elseif($ag == 'Open' or $genderkey == 'Open'){
  $empty_open_events[] = $event_label;
  }
}
else{
?>
<tr class="header"  id="up_match_section">
<td class="score-position" valign="center" style="text-align:left">
<input type='hidden' name='chp_event_<?=$p;?>' id='chp_event_<?=$p;?>' value='<?=$k;?>' />
<span style='color:blue;font-size:13px;font-weight:400;cursor:pointer;'>
<?php
echo $event_label." (<label id='$k'>".count($users)."</label>)";
$event = $k;
//$waitlistuserids = league::in_array_r($event, $waitlist_users);
$waitlistuserids = $waitlist_users[$event];
//echo "<pre>"; print_r($waitlist_users[$event]); exit;
?>
</span>
</td>
</tr>
<tr class="content" style="display:none;">
<!--td class="score-position" valign="center" align="center">&nbsp;&nbsp;</td-->
<td class="score-position" valign="center" align="center">
<table class="tab-score" >
<tr>
<?php
if($tour_details->Usersid == $this->logged_user or $this->is_super_admin) {
 ?>
<td width=""><input type="checkbox" name="select_all_chk" id="select_all_chk_<?php echo $keys;?>" class="tourn_participants_cls_<?php echo $keys;?>" onclick="getallcheckboxes('<?php echo $keys;?>');"></td>
<?php
}
 ?>
<td class="score-position" valign="center" align="center"><b>Player</b></td>
<td class="score-position" valign="center" align="center"><b>A2M Rating</b></td>
<?php
$colspan='3';
if($tour_details->SportsType == '2'){
  $colspan='5';
?>
<td class="score-position" valign="center" align="center"><b>USATT Membership</b></td>
<td class="score-position" valign="center" align="center"><b>USATT Rating</b></td>
<?php
}?>
</tr>
<?php 
$displayed_users = array();
$displayed_comb  = array();

foreach($users as $user){
$pp_comb = $user;
$inverse_pp_comb = $user;

	if($user_partners[$user][$k] and (strpos($event_label, 'Doubles') or strpos($event_label, 'Mixed') or strpos($event_key, 'Doubles') or strpos($event_key, 'Mixed'))){
	$pp_comb		 = $user.'-'.$user_partners[$user][$k];
	$inverse_pp_comb = $user_partners[$user][$k].'-'.$user;
	}

   $wtlst_style = "";
  //if(in_array($user, $waitlistuserids)){
  if(array_key_exists($user, $waitlistuserids)){
    $wtlst_style = "background-color:#f1f129;";
  }
  else{
    $wtlst_style = "";
  }
//echo "<pre>"; print_r($displayed_users);
if(!in_array($pp_comb, $displayed_comb, TRUE) and !in_array($inverse_pp_comb, $displayed_comb, TRUE) and 
	(strpos($event_label, 'Doubles') or strpos($event_label, 'Mixed') or strpos($event_key, 'Doubles') or strpos($event_key, 'Mixed')) and !in_array($user, $displayed_users)){

	//$player					= league::get_username($user);
	$player					= $user_names[$user];
	//$user_a2msocre	= league::get_a2mscore($user, $tour_details->SportsType);
	$user_a2msocre	= $user_names[$user];
	$user_score			= $user_a2msocre['A2MScore'];
	$avg_score			= $user_score;
 ?>
<tr style='<?=$wtlst_style;?>'>
<?php
if($tour_details->Usersid == $this->logged_user or $this->is_super_admin) {
 ?>
 <td style='padding-bottom:5px;'><input type='checkbox' name='prtcpnts_mail_check' class="tm_participants_cls tm_participants_cls_<?php echo $keys;?>" id="tm_participants_<?php echo $user;?>" value="<?php echo $user; if($user_partners[$user][$k]) echo "-{$user_partners[$user][$k]}"; ?>" ></td>
 <?php
 }
 ?>
<td class="score-position" valign="center" align="center">
<?php
$repeated = '';
if(in_array($user, $displayed_users) and (strpos($event_label, 'Doubles') or strpos($event_label, 'Mixed') or strpos($event_key, 'Doubles') or strpos($event_key, 'Mixed'))){
	$tooltip = "data-toggle='tooltip' data-placement='top' title='Duplicate Player'";
$repeated = "<img src='".base_url()."icons/exclamation.png' style='width:18px; height:15px;' {$tooltip} />";
}

//echo "<a>".$player['Firstname'] . " " .$player['Lastname']."</a> $repeated";
//$p1 = league :: get_user($user);
$p1 = $user_names[$user];

	$age_group = '';
	if($p1['DOB']) {		
			$birthdate	= new DateTime($p1['DOB']);
			$today		= new DateTime('today');
			$age			= $birthdate->diff($today)->y;

			switch ($age) {
                case ($age >= 40 and $age < 50):
                   $age_group = "({$p1['UserAgegroup']} <b>40+</b>)";
                   break;
                case ($age >= 50 and $age < 60):
                   $age_group = "({$p1['UserAgegroup']} <b>50+</b>)";
                   break;
                case ($age >= 60 and $age < 70):
                   $age_group = "({$p1['UserAgegroup']} <b>60+</b>)";
                   break;
                case ($age >= 70 and $age < 80):
                   $age_group = "({$p1['UserAgegroup']} <b>70+</b>)";
                   break;
                case ($age >= 80 and $age < 90):
                   $age_group = "({$p1['UserAgegroup']} <b>80+</b>)";
                   break;
                case ($age >= 90 and $age < 100):
                   $age_group = "({$p1['UserAgegroup']} <b>90+</b>)";
                   break;
			    default:
				   $age_group = "({$p1['UserAgegroup']})";
				   break;
			}
	}


echo "<a href='".base_url()."player/$user'>".$player['Firstname']." ".$player['Lastname']."</a> ".$age_group; 


//echo '$user_partners[$user][$k] '.var_dump($user_partners[$user][$k]).'<br />';
if($user_partners[$user][$k] and $user_partners[$user][$k] != ""){
	$player_partner	= league::get_username($user_partners[$user][$k]);
	$is_pp_reg			= league::user_reg_or_not($user_partners[$user][$k], $tour_details->tournament_ID);
	$style   = "";
	$tooltip = "";
	if($is_pp_reg){
		//$style = "style='background:blue;'";
	}
	else{
		$style   = "style='background:yellow;'";
		$tooltip = "data-toggle='tooltip' data-placement='top' title='Player is not Registered yet!'";
	}

	$repeated = '';
	if(in_array($user_partners[$user][$k], $displayed_users)){
	$tooltip = "data-toggle='tooltip' data-placement='top' title='Duplicate Player'";
	$repeated = "<img src='".base_url()."icons/exclamation.png' style='width:18px; height:15px;' {$tooltip} />";
	}

//$p2 = league :: get_user($user_partners[$user][$k]);
$p2 = $player_partner;

	$age_group = '';
	if($p2['DOB']) {		
			$birthdate	= new DateTime($p2['DOB']);
			$today		= new DateTime('today');
			$age			= $birthdate->diff($today)->y;

			switch ($age) {
                case ($age >= 40 and $age < 50):
                   $age_group = "({$p2['UserAgegroup']} <b>40+</b>)";
                   break;
                case ($age >= 50 and $age < 60):
                   $age_group = "({$p2['UserAgegroup']} <b>50+</b>)";
                   break;
                case ($age >= 60 and $age < 70):
                   $age_group = "({$p2['UserAgegroup']} <b>60+</b>)";
                   break;
                case ($age >= 70 and $age < 80):
                   $age_group = "({$p2['UserAgegroup']} <b>70+</b>)";
                   break;
                case ($age >= 80 and $age < 90):
                   $age_group = "({$p2['UserAgegroup']} <b>80+</b>)";
                   break;
                case ($age >= 90 and $age < 100):
                   $age_group = "({$p2['UserAgegroup']} <b>90+</b>)";
                   break;
			    default:
				   $age_group = "({$p2['UserAgegroup']})";
				   break;
			}
	}

	echo " - "."<a {$style} {$tooltip} href='".base_url()."player/{$user_partners[$user][$k]}'>" . $player_partner['Firstname'] . " " .$player_partner['Lastname']."</a> $repeated  ".$age_group;
	//echo " - "."<a {$style} {$tooltip}>" . $player_partner['Firstname'] . " " .$player_partner['Lastname']."</a> $repeated";

	$user_score = $user_a2msocre['A2MScore_Doubles'];
	$avg_score  = $user_score;

		$partner_score = 0;
		$partner_a2msocre   = league::get_a2mscore($user_partners[$user][$k], $tour_details->SportsType);
		
		if($partner_a2msocre['A2MScore_Doubles']){
		$partner_score	= $partner_a2msocre['A2MScore_Doubles'];
		$avg_score = ($user_score + $partner_score) / 2;
		}

}
else{
	echo " - <b>No Partner Assigned!</b>";
}

	/* ************************ */
	if(/*$now <= $reg_close and*/ $this->logged_user == $tour_details->Usersid or $this->is_super_admin) {
		//if($this->logged_user == 507){	echo "<pre>"; print_r($user_partners); 	}
		echo "&nbsp;&nbsp;<select class='user_change_partner' name='user_change_partner' id='{$p}_user_change_partner_{$user}'>";
		echo "<option value=''>Select Partner</option>";
		foreach($users as $usr){
			//if($usr != $this->logged_user and $usr != $user_partners[$usr][$k]){
			//if($usr != $this->logged_user and $user_partners[$usr][$k] == ''){
			if($usr != $user and $usr != $user_partners[$user][$k]){
				$select_get_user= league::get_user($usr);
				echo "<option value='$usr'>".$select_get_user['Firstname']." ".$select_get_user['Lastname']."</option>";
			}
		}
		echo "</select>";
	}
	/* ************************ */

?>
</td>
<td class="score-position" valign="center" align="center"><?php 
if($tour_details->SportsType == 7 )
	echo number_format($avg_score, 3); 
else
	echo $avg_score; ?></td>
<?php
if($tour_details->SportsType == '2'){
    $get_user_mem_details   = league::get_user_mem_details($user, $tour_details->SportsType);
    $get_user_rating				= league::get_user_rating($user, $tour_details->tournament_ID);

    //$search_user_usatt_mem = league::search_user_usatt_mem($player['Firstname'], $player['Lastname'], $tour_details->SportsType);
?>
<td class="score-position" valign="center" align="center">
<?php
$get_user_usatt_rating = "";
if($get_user_mem_details){
echo $get_user_mem_details['Membership_ID'];
$get_user_usatt_rating = league::get_user_usatt_rating($get_user_mem_details['Membership_ID']);
}
?>
</td>

<td class="score-position" valign="center" align="center">
<?php
if($get_user_usatt_rating){ 
  $rating_eligibility		= $get_user_rating['Rating'];
  $rating					= $get_user_usatt_rating['Rating'];
  $rating_eligibility_title = "";
  $rating_eligibility_class = "font-weight:400";
  $level					= substr($get_level['SportsLevel'],1);

	if(is_numeric($level)){
	  if($rating_eligibility!="" and $rating_eligibility != NULL and $rating_eligibility != 'NULL'){
		if($level < $get_user_rating['Rating']){	
		$rating_eligibility = $get_user_rating['Rating'].'<i class="fa fa-exclamation-triangle"></i>';
		$rating_eligibility_title = "exceeds the rating";
		$rating_eligibility_class = "";					
	  }
	  }
	  else{
		$rating_eligibility = $get_user_usatt_rating['Rating'];
	  }
	  
	}
	else{
		$rating_eligibility = $get_user_usatt_rating['Rating'];
	}

	echo '<label style="'.$rating_eligibility_class.'" title="'.$rating_eligibility_title.'">'.$rating_eligibility.'</label>';
}
?>
</td>
<?php
}
?>
</tr>
<?php
				if($event_entry_count[$k])
			$event_entry_count[$k] += 1;
			else
			$event_entry_count[$k] = 1;

}
else if(!strpos($event_label, 'Doubles') and !strpos($event_label, 'Mixed') and !strpos($event_key, 'Doubles') and !strpos($event_key, 'Mixed') and !in_array($user, $displayed_users, TRUE)){
//$player					= league::get_username($user);
//$user_a2msocre  = league::get_a2mscore($user, $tour_details->SportsType);
//if($this->logged_user == 240)
//	echo "<pre>"; print_r($user_names); exit;
$player					= $user_names[$user];
$user_a2msocre	= $user_names[$user];
$user_score			= $user_a2msocre['A2MScore'];
//echo "<pre>"; print_r($player);
//$p1 = league :: get_user($user);
$p1 = $player;

	$age_group = '';
	if($p1['DOB']) {		
			$birthdate	= new DateTime($p1['DOB']);
			$today		= new DateTime('today');
			$age			= $birthdate->diff($today)->y;

			switch ($age) {
                case ($age >= 40 and $age < 50):
                   $age_group = "({$p1['UserAgegroup']} <b>40+</b>)";
                   break;
                case ($age >= 50 and $age < 60):
                   $age_group = "({$p1['UserAgegroup']} <b>50+</b>)";
                   break;
                case ($age >= 60 and $age < 70):
                   $age_group = "({$p1['UserAgegroup']} <b>60+</b>)";
                   break;
                case ($age >= 70 and $age < 80):
                   $age_group = "({$p1['UserAgegroup']} <b>70+</b>)";
                   break;
                case ($age >= 80 and $age < 90):
                   $age_group = "({$p1['UserAgegroup']} <b>80+</b>)";
                   break;
                case ($age >= 90 and $age < 100):
                   $age_group = "({$p1['UserAgegroup']} <b>90+</b>)";
                   break;
			    default:
				   $age_group = "({$p1['UserAgegroup']})";
				   break;
			}
	}

 ?>
<tr style='<?php echo $wtlst_style;?>'>
 <td style='padding-bottom:5px;'><input type='checkbox' name='prtcpnts_mail_check' class="tm_participants_cls tm_participants_cls_<?php echo $keys;?>" id="tm_participants_<?php echo $user;?>"  value="<?php echo $user;?>" ></td>
<td class="score-position" valign="center" align="center">
<?php
echo "<a href='".base_url()."player/$user'>".$player['Firstname'] . " " .$player['Lastname']."</a>  ".$age_group;
//echo "<a>".$player['Firstname']. " " .$player['Lastname']."</a>"; 
if($wtlst_style != ''){
echo "&nbsp;&nbsp;<b>W.L # ".$waitlistuserids[$user]."</b>"; 
}
?>
</td>
<td class="score-position" valign="center" align="center">
<?php
if($tour_details->SportsType == 7 ){
	echo number_format($user_score, 3); 
}
else{
	echo $user_score;
}
?></td>
<?php
if($tour_details->SportsType == '2'){
    $get_user_mem_details  = league::get_user_mem_details($user, $tour_details->SportsType);
    $get_user_rating	   = league::get_user_rating($user, $tour_details->tournament_ID);

    //$search_user_usatt_mem = league::search_user_usatt_mem($player['Firstname'], $player['Lastname'], $tour_details->SportsType);
?>
<td class="score-position" valign="center" align="center">
<?php
$get_user_usatt_rating = "";
if($get_user_mem_details){
echo $get_user_mem_details['Membership_ID'];
$get_user_usatt_rating = league::get_user_usatt_rating($get_user_mem_details['Membership_ID']);
}
?>
</td>

<td class="score-position" valign="center" align="center">
<?php if($get_user_usatt_rating) { 
  $rating_eligibility		= $get_user_rating['Rating'];
  $rating					= $get_user_usatt_rating['Rating'];
  $rating_eligibility_title = "";
  $rating_eligibility_class = "font-weight:400";
  $level					= substr($get_level['SportsLevel'], 1);

	if(is_numeric($level)){
		if($rating_eligibility != "" and $rating_eligibility != NULL and $rating_eligibility != 'NULL') {
			if($level < $get_user_rating['Rating']) {
			$rating_eligibility		  = $get_user_rating['Rating'].'<i class="fa fa-exclamation-triangle"></i>';
			$rating_eligibility_title = "exceeds the rating";
			$rating_eligibility_class = "";
			}
		}
		else {
			$rating_eligibility = $get_user_usatt_rating['Rating'];
		}
	}
	else{
		$rating_eligibility = $get_user_usatt_rating['Rating'];
	}

    echo '<label style="'.$rating_eligibility_class.'" title="'.$rating_eligibility_title.'">'.$rating_eligibility.'</label>';
  }
?>
</td>
<?php
}
?>
</tr>
<?php
			if($event_entry_count[$k])
			$event_entry_count[$k] += 1;
			else
			$event_entry_count[$k] = 1;

}
	$displayed_users[] = $user;
	$displayed_comb[]  = $pp_comb;
	//echo $pp_comb."<br>";
	if($user_partners[$user][$k]){
	$displayed_users[] = $user_partners[$user][$k];
	}
}
?>
</table>
</td>
</tr>
<?php
}
$p++;
}
//echo "<pre>"; print_r($event_entry_count); 
//}
//}
foreach($event_entry_count as $k => $cnt){
?>
<script>
var ecnt	= "<?php echo $cnt; ?>";
var eid		= "<?php echo $k; ?>";
$('#'+eid).html(ecnt);
</script>
<?php
}
?>
<tr class="header"  id="up_match_section">
<td class="score-position" valign="center" style="text-align:left">
<span style='color:red;font-size:13px;font-weight:400;cursor:pointer;'>
Events (No Players registered yet!)
</span>
</td>
</tr>
<tr class="content" style="display:none;">
<td class="score-position" valign="center" align="left">
<table>
<?php
foreach($empty_reg_men_events as $evnts){
?>
<tr><td colspan='3'><?=$evnts;?></td></tr>
<?php
}

foreach($empty_reg_women_events as $evnts){
?>
<tr><td colspan='3'><?=$evnts;?></td></tr>
<?php
}

foreach($empty_reg_mixed_events as $evnts){
?>
<tr><td colspan='3'><?=$evnts;?></td></tr>
<?php
}

foreach($empty_open_events as $evnts){
?>
<tr><td colspan='3'><?=$evnts;?></td></tr>
<?php
}
?>
</table>
</td>
</tr>
</table>
</div>

<!-- End of Tournament Matches Section -->

</div>
</div>

<?php
//echo "test";
//echo $tour_details->Usersid."<br>";
//echo $this->logged_user."<br>";
//echo $this->is_super_admin."<br>";

if($tour_details->Usersid == $this->logged_user or $this->is_super_admin) {
?>
<div class="col-md-12 league-form-bg">
<span id="error_alert"> </span>
<input type="checkbox" value="" name="send_mail_to_participants" id="send_mail">
Click and Send mail to all participants:
<form method="POST" id="send_mail_frm" style="display:none;" enctype="multipart/form_data">
<!-- <input type = "file" name="attach_file" id="attach_file" required=""> --> 
<input type = "hidden" name="tourn_id" id="tourn_id" value="<?php echo $tour_details->tournament_ID;?>"> 
<input type="text" name="subject" id="subject" class="form-control" placeholder="Enter Subject Here" required>
<textarea name="message" id="message"  cols="155" rows="5">
</textarea>
<input type="submit" name="send" id="send" value="Send Mail" class="league-form-submit">
</form>
</div>
<?php
}
?>