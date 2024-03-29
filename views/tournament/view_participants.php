<script>
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

$(document).ready(function(){

$('#ev_draw_filter').change(function(){
	var df			= $(this).val();
	var btn_val	= "<?php echo $btn_val; ?>";

	var tourn_id = $('#tourn_id').val();
			$.ajax({
				type:'POST',
				url:club_baseurl+'league/load_participants/',
				data:{club_url:club_baseurl,tid:tourn_id,df:df},
				success:function(res){
					//$("#tourn_participants").html(res);
					$("#Participants").html(res);
				}
			});
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
				alert("Event Partner updated successfully.");
				location.reload();
			}
		});
		}
	}

	});
});
</script>

<div class='form-group'>
<div class='col-md-12 control-label'>

<div class="col-md-8"></div>
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
$now			= time();
$reg_close   = strtotime(date('Y-m-d H:i:s',strtotime($tour_details->Registrationsclosedon)));

//$res  = league::get_reg_tourn_participants_withGender($tour_details->tournament_ID);
$res = league::get_reg_tourn_participants_withGender($tour_details->tournament_ID, $tour_details->SportsType);

$reg_users		= $res[0];
$user_tsize		= $res[1];
$user_partners  = $res[2];
$user_names	= $res[3];
?>

<div class="col-md-12 league-form-bg" style="margin-top:15px; margin-bottom:0px;">
<table class="tab-score">

<tr><td class="score-position" valign="center" style="text-align:left"><b>Events</b></td></tr>

<?php
$keys = 0;
//if(count($reg_users) > 0){
	$waitlist_users = league::GetWaitListUsersNew($tour_details->tournament_ID);
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

    $ag         = $evntarr[0];
    $genderkey  = $evntarr[1];
    $fr         = $evntarr[2];
    $lv         = $evntarr[3];
	
	if(count($reg_users) > 0){
	$get_level	= league::get_level_name($tour_details->SportsType, $lv);
	//$users		= league::in_array_r($k, $reg_users);
	$users			= league::in_array_r_sort($k, $reg_users, $user_partners);
	}

/*if($this->logged_user == 240){
echo "<pre>"; print_r($users); exit;
}*/

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
<span style='color:blue;font-size:13px;font-weight:400;cursor:pointer;'>
<input type='hidden' name='chp_event_<?=$p;?>' id='chp_event_<?=$p;?>' value='<?=$k;?>' />
<?php
	$is_user_reg_event = 0;
$inner_row_style = ' style="display: none;"';

if($this->logged_user)
	$is_user_reg_event = league :: is_user_reg_event($tour_details->tournament_ID, $event_key);

if($is_user_reg_event){
	echo "<b style='font-size: 15px; color: green; '>".$event_label." (<label id='$k'>".count($users)."</label>)</b>";
	$inner_row_style = ' style="display: table-row;"';
}
else
	echo $event_label." (<label id='$k'>".count($users)."</label>)";

$event = $k;
$waitlistuserids = league :: in_array_r($event, $waitlist_users);
?>
</span>
</td>
</tr>
<tr class="content" <?=$inner_row_style; ?>>
<!--td class="score-position" valign="center" align="center">&nbsp;&nbsp;</td-->
<td class="score-position" valign="center" align="center">
<table class="tab-score" >
<tr>
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
	$pp_comb					 = $user.'-'.$user_partners[$user][$k];
	$inverse_pp_comb	 = $user_partners[$user][$k].'-'.$user;
	}
if(!in_array($pp_comb, $displayed_comb) and !in_array($inverse_pp_comb, $displayed_comb) and 
	(strpos($event_label, 'Doubles') or strpos($event_label, 'Mixed') or strpos($event_key, 'Doubles') or strpos($event_key, 'Mixed')) and !in_array($user, $displayed_users)){
   $wtlst_style = "";
  if(in_array($user, $waitlistuserids)){
    $wtlst_style = "background-color:yellow;";
  }
  else{
    $wtlst_style = "";
  }
    
//$player					= league::get_username($user);
//$user_a2msocre   = league::get_a2mscore($user, $tour_details->SportsType);
$player					= $user_names[$user];
$user_a2msocre   = $user_names[$user];
$user_score			= $user_a2msocre['A2MScore'];
		$avg_score = $user_score;

 ?>
<tr style='<?php echo $wtlst_style;?>'>
<td class="score-position" valign="center" align="center">
<?php
$repeated = '';
if(in_array($user, $displayed_users) and (strpos($event_label, 'Doubles') or strpos($event_label, 'Mixed') or strpos($event_key, 'Doubles') or strpos($event_key, 'Mixed'))){
	$tooltip = "data-toggle='tooltip' data-placement='top' title='Duplicate Player'";
$repeated = "<img src='".base_url()."icons/exclamation.png' style='width:18px; height:15px;' {$tooltip} />";

}

echo "<a href='".base_url()."player/$user'>".$player['Firstname'] . " " .$player['Lastname']."</a> $repeated";
//echo "<a>".$player['Firstname'] . " " .$player['Lastname']."</a> $repeated";
//echo '$user_partners[$user][$k] '.var_dump($user_partners[$user][$k]).'<br />';
if($user_partners[$user][$k] and $user_partners[$user][$k] != ""){
	$player_partner = league::get_username($user_partners[$user][$k]);
	$is_pp_reg			 = league::user_reg_or_not($user_partners[$user][$k], $tour_details->tournament_ID);

	$user_score	= $user_a2msocre['A2MScore_Doubles'];
	$avg_score		= $user_score;


		$partner_score			= 0;
		$partner_a2msocre  = league::get_a2mscore($user_partners[$user][$k], $tour_details->SportsType);
		if($partner_a2msocre['A2MScore_Doubles']){
			$partner_score	= $partner_a2msocre['A2MScore_Doubles'];
			$avg_score = ($user_score + $partner_score) / 2;
		}

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

	echo " - "."<a {$style} {$tooltip} href='".base_url()."player/{$user_partners[$user][$k]}'>" . $player_partner['Firstname'] . " " .$player_partner['Lastname']."</a> $repeated";
	// echo " - "."<a {$style} {$tooltip}>" . $player_partner['Firstname'] . " " .$player_partner['Lastname']."</a> $repeated";
	
	/* ************************ */
	if($now <= $reg_close and ($this->logged_user == $user or $this->logged_user == $user_partners[$user][$k]) and $this->logged_user) {
		echo "<select class='user_change_partner' name='user_change_partner' id='{$p}_user_change_partner_{$this->logged_user}'>";
		echo "<option value=''>Change Partner</option>";
		foreach($users as $usr){
			//if($usr != $this->logged_user and $usr != $user_partners[$usr][$k]){
			if($usr != $this->logged_user and $user_partners[$usr][$k] == ''){
				$select_get_user= league::get_user($usr);
			echo "<option value='$usr'>".$select_get_user['Firstname']."".$select_get_user['Lastname']."</option>";
			}
		}
		echo "</select>";
	}
	/* ************************ */
}
else{
	echo " - <b>No Partner Assigned!</b>";

	/* ************************ */
	if($now <= $reg_close and ($this->logged_user == $user or $this->logged_user == $user_partners[$user][$k]) and $this->logged_user) {
		//if($this->logged_user == 507){	echo "<pre>"; print_r($user_partners); 	}
		echo "&nbsp;&nbsp;<select class='user_change_partner' name='user_change_partner' id='{$p}_user_change_partner_{$this->logged_user}'>";
		echo "<option value=''>Select Partner</option>";
		foreach($users as $usr){
			//if($usr != $this->logged_user and $usr != $user_partners[$usr][$k]){
			if($usr != $this->logged_user and $user_partners[$usr][$k] == ''){
				$select_get_user= league::get_user($usr);
				echo "<option value='$usr'>".$select_get_user['Firstname']." ".$select_get_user['Lastname']."</option>";
			}
		}
		echo "</select>";
	}
	/* ************************ */
}

?>
</td>
<td class="score-position" valign="center" align="center"><?php echo number_format($avg_score, 3); ?></td>
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
<?php if($get_user_usatt_rating){ 
  $rating_eligibility = $get_user_rating['Rating'];
  $rating = $get_user_usatt_rating['Rating'];
  $rating_eligibility_title = "";
  $rating_eligibility_class = "font-weight:400";
                $level = substr($get_level['SportsLevel'],1);
                if(is_numeric($level)){
                  if($rating_eligibility != "" and $rating_eligibility != NULL and $rating_eligibility != 'NULL'){
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
else if(!strpos($event_label, 'Doubles') and !strpos($event_label, 'Mixed') and !strpos($event_key, 'Doubles') and !strpos($event_key, 'Mixed') and !in_array($user, $displayed_users)){
//$player					= league::get_username($user);
//$user_a2msocre	= league::get_a2mscore($user, $tour_details->SportsType);
$player					= $user_names[$user];
$user_a2msocre	= $user_names[$user];
$user_score			= $user_a2msocre['A2MScore'];
 ?>
<tr style='<?php echo $wtlst_style;?>'>
<td class="score-position" valign="center" align="center">
<?php
echo "<a href='".base_url()."player/$user'>".$player['Firstname'] . " " .$player['Lastname']."</a>"; 
//echo "<a>".$player['Firstname'] . " " .$player['Lastname']."</a>"; 
?>
</td>
<td class="score-position" valign="center" align="center"><?php echo number_format($user_score, 3); ?></td>
<?php
//if($tour_details->TShirt){
?>
<!-- <td class="score-position" valign="center" align="center"><?php //echo $user_tsize[$user]; ?></td> -->
<?php
//}
if($tour_details->SportsType == '2'){
    $get_user_mem_details  = league::get_user_mem_details($user, $tour_details->SportsType);
    $get_user_rating	   = league::get_user_rating($user, $tour_details->tournament_ID);

    //$search_user_usatt_mem = league::search_user_usatt_mem($player['Firstname'], $player['Lastname'], $tour_details->SportsType);
?>
<td class="score-position" valign="center" align="center">
<?php
$get_user_usatt_rating = "";

if($get_user_mem_details) {
	echo $get_user_mem_details['Membership_ID'];
	$get_user_usatt_rating = league::get_user_usatt_rating($get_user_mem_details['Membership_ID']);
}
?>
</td>

<td class="score-position" valign="center" align="center">
<?php
if($get_user_usatt_rating) { 
  $rating_eligibility = $get_user_rating['Rating'];
  $rating			  = $get_user_usatt_rating['Rating'];
  $rating_eligibility_title = "";
  $rating_eligibility_class = "font-weight:400";
                $level = substr($get_level['SportsLevel'],1);
                if(is_numeric($level)) {
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
				else {
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

	if($user_partners[$user][$k]) {
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
var ecnt = "<?php echo $cnt; ?>";
var eid = "<?php echo $k; ?>";
$('#'+eid).html(ecnt);
</script>
<?php
}
?>

<!-- New code -->
<table style="color: blue;
    font-size: 13px;
    cursor: pointer;
	background-color: #fff9f3;
	width: 100%;">
<?php
foreach($empty_reg_men_events as $evnts){
?>
<tr><td style="height: 29px;">
<span style="margin-left: 7px; padding: 0 5px;"><?=$evnts." <b>(0)</b>";?></span></td></tr>
<?php
}

foreach($empty_reg_women_events as $evnts){
?>
<tr><td style="height: 29px;">
<span style="margin-left: 7px; padding: 0 5px;"><?=$evnts." <b>(0)</b>";?></span></td></tr>
<?php
}

foreach($empty_reg_mixed_events as $evnts){
?>
<tr><td style="height: 29px;">
<span style="margin-left: 7px; padding: 0 5px;"><?=$evnts." <b>(0)</b>";?></span></td></tr>
<?php
}

foreach($empty_open_events as $evnts){
?>
<tr><td style="height: 29px;">
<span style="margin-left: 7px; padding: 0 5px;"><?=$evnts." <b>(0)</b>";?></span></td></tr>
<?php
}
?>
</table>


<!-- New code -->
</table>
</div>

<!-- End of Tournament Matches Section -->
<input type='hidden' id="tourn_id"   name='tourn_id'   value = "<?php echo $tour_details->tournament_ID; ?>" />
<input type='hidden' id='tourn_type' name='tourn_type' value = "<?php echo $tour_details->Tournament_type; ?>" />
</div>
</div>