<?php  
$num_teams = $num_of_teams;
$pow_vals	   = array(2,4,8,16,32,64,128,256,512);
$seed_team = $teams;
//echo "<pre>"; print_r($courts_new);print_r($match_timings); //exit;
$log_val   = ceil(log($num_teams, 2));
((in_array($log_val, $pow_vals)) or (in_array($num_teams, $pow_vals))) ? $total_rounds = $log_val : $total_rounds =  floor(log($num_teams, 2)) + 1;

$match_num = 1;
$pick_time	   = 1;
$new_match_timings = array();

//echo "<pre>";print_r($courts_new);	exit;
?>

<link rel="stylesheet" href="<?php echo base_url();?>css/grids/grid_<?=$total_rounds;?>.css">
<link href = "<?php echo base_url();?>css/foundation-datepicker.css" rel="stylesheet">
<script src = "<?php echo base_url();?>js/foundation-datepicker.js"></script>

<script>
$(document).ready(function(){
var baseurl = "<?php echo base_url();?>";

 $('#myform').submit(function(e) {
	var Draw_Title = $('#draw_title').val();
	var Tourn_id = $('#tourn_id').val();

	//alert(Tourn_id);
		 $.ajax({
			type: "POST",
			async:false,
			url:baseurl+'league/check_draw_title/',
			data:{tourn_id:Tourn_id,draw_title:Draw_Title},
			dataType: "html",
			success: function(msg){
				if(msg == 1){	
					$err_msg = Draw_Title + " is already existed!";
					$("#title_error").html($err_msg);
					$("#draw_title").val("");
					 e.preventDefault();
				      return false;
				}				
		   }
		});

	});
});
</script>

<section id="login" class="container secondary-page">  
<div class="general general-results players view-brack1">

<!-- LOGIN BOX -->
<div class="top-score-title right-score col-md-12">
<h3>Bracket Generation</h3>
<div class="col-md-12 login-page" style="display:grid;">
<!-- <form method="post" id="myform" action='<?php //echo base_url(); ?>league/bracket_save' class="login-form" style="width:100%;"> -->
<form method="post" id="myform" action='<?php echo $this->club_form_url; ?>league/bracket_save' class="login-form" style="width:100%;">

<div class='col-md-8'>
<label>Draw Title*</label>&nbsp;&nbsp;<span id="title_error" style="color:red"></span>
<input class="form-control" type="text" name="draw_title" id="draw_title" style="width:40%;" required />
</div>

<div class='col-md-4' style="margin-top: 25px;">
<input type="submit" class="league-form-submit1" name="bracket_confirm" id="bracket_confirm" value="Confirm & Save" />
</div>

<br />
<div class="brackets" id="brackets">
<div class="group<?php echo $total_rounds+1; ?>" id="b1">
<?php
for($round = 1, $source=1 ; $round <= $total_rounds; $round++) {
?>
<div class="r<?php echo $round; ?>" style="text-align:center">

<script>/*
$(function() {
 var rid = "<?php echo $round; ?>";
 $('#sdate_round'+rid).datepick();
});*/
</script>

<input type='hidden' name='round[]' value="<?php echo $round; ?>" />
<br>
<span style="text-align: center"><b>
<?php
$process_res = league::cal_c($pow_vals, $num_teams, $teams, $round);
$teams = array();

$rt = $process_res[1] + $process_res[2];
//--------------------------

if($rt >= pow(2,3)){
	$rrt = $rt*2;
	echo "Round of $rrt";
	}
else {
		switch($rt)
		{
			case 1:
				echo "Final";
				break;
			case 2:
				echo "Semi-Final";
				break;
			case 4:
				echo "Quarter-Final";
				break;
			default:
				echo "";
				break;
		}
	}
?>
</b></span>
<br>
<!-- 
<input  type="text" class='form-control' placeholder="Date" id="sdate_round<?php echo $round; ?>"  name="round_date<?php echo $round; ?>" />
 -->
<?php
if(!$match_timings){
?>
<input type="text" placeholder="Date" name="round_date<?php echo $round; ?>" id="sdate_round<?php echo $round; ?>" value="" />

<script>
var rid = "<?php echo $round; ?>";

  $('#sdate_round'+rid).fdatepicker({
		format: 'mm/dd/yyyy hh:ii',
		disableDblClickSelection: true,
		language: 'en',
		pickTime: true
	});
</script>
<?php
}
//--------------------------
$x=0;
foreach($process_res[6] as $ab => $game_pl){
$is_bye = 0;
if($this->input->post('tformat') == 'Teams' or $this->input->post('tformat') == 'TeamSport'){
	$team1 = league::get_team(intval($process_res[6][$ab][0]));
	$team2 = league::get_team(intval($process_res[6][$ab][1]));
	
$output =  "<span class='teama'>";
	if($team1['Team_name']){ $output .= $team1['Team_name']; }  else { ($round==1)? $output .= "Bye" : $output .= "---"; $is_bye = 1; 

	($round==1)? $is_bye = 1 : $is_bye = 0;
	}
$output .= "</span>";
$output .=  "<span class='teamb'>";
	if($team2['Team_name']){ $output .= $team2['Team_name']; }
	else { ($round==1)? $mn = "Bye" : $mn = "---";
	$output .= $mn;

	($round==1)? $is_bye = 1 : $is_bye = 0;
	}
$output .= "</span>";
}
else if($this->input->post('tformat') == 'Individual'){

$y = 1;
$player1 = explode(";", $process_res[6][$ab][0]);
$player2 = explode(";", $process_res[6][$ab][1]);

	$double_bye_pl		= explode("-", $process_res[6][$ab][0]);
	$get_username		= league::get_username(intval($process_res[6][$ab][0]));
	$get_partner			= league::get_username(intval($double_bye_pl[1]));

	$double_game_pl_2	= explode("-", $process_res[6][$ab][1]);
	$get_username2		= league::get_username(intval($process_res[6][$ab][1]));
	$get_partner2				= league::get_username(intval($double_game_pl_2[1]));

	$player1 = league::get_username(intval($rr_p1[0]));		
	$player2 = league::get_username(intval($rr_p2[0]));
	
	$p1_part = "";		
	$p2_part = "";		
	if($rr_p1[1]){		
	$player1_partner = league::get_username(intval($rr_p1[1]));		
	$p1_part = "; $player1_partner[Firstname] $player1_partner[Lastname]";		
	}		
	if($rr_p2[1]){		
	$player2_partner = league::get_username(intval($rr_p2[1]));		
	$p2_part = "; $player2_partner[Firstname] $player2_partner[Lastname]";		
	}		
$output =  "<span class='teama'>";		
	if($get_username){ $output .= $get_username['Firstname']." ".$get_username['Lastname']; } 
	else { ($round==1)? $output .= "Bye" : $output .= "---"; 
	($round==1)? $is_bye++ : $is_bye = 0;
	}		
	if($get_partner){ $output .= " - ".$get_partner['Firstname']." ".$get_partner['Lastname']; }
	if($round == 1 and $process_res[6][$ab][0] != '---') {
		$seed	 = array_search($process_res[6][$ab][0], $seed_team);
		$output .= " #".($seed+1);
	}
$output .= "</span>";		
$output .=  "<span class='teamb'>";		
	if($get_username2){ $output .= $get_username2['Firstname']." ".$get_username2['Lastname']; } 		
	else { ($round==1)? $mn = "Bye" : $mn = "---"; 		
	$output .= $mn;
	($round==1)? $is_bye++ : $is_bye = 0;
	}		
	if($get_partner2 && $get_partner){ $output .= " - ".$get_partner2['Firstname']." ".$get_partner2['Lastname']; }

$seed = '';
if($round == 1 and $process_res[6][$ab][1] != '---') {
$seed	 = array_search($process_res[6][$ab][1], $seed_team);
$output .= " #".($seed+1);
}

$output .= "</span>";		
}
	$prv_match1 = '';
	$prv_match2 = '';

?>
<input type='hidden' name="match_num[<?php echo $round; ?>][]" value="<?php echo $match_num; ?>" />
<input type='hidden' name="player1[<?php echo $round; ?>][<?php echo $match_num; ?>][0]" value="<?php echo $process_res[6][$ab][0]; ?>" />
<input type='hidden' name="player1[<?php echo $round; ?>][<?php echo $match_num; ?>][1]" value="<?php 
	if($round > 1) { $s = $match_num - ($match_num - $source); echo $s; $source++; } else { echo "0"; } ?>" />
<?php
if($round > 1){ $prv_match1 = $s; }
?>
<input type='hidden' name="player2[<?php echo $round; ?>][<?php echo $match_num; ?>][0]" value="<?php echo $process_res[6][$ab][1]; ?>" />
<input type='hidden' name="player2[<?php echo $round; ?>][<?php echo $match_num; ?>][1]" value="<?php 
	if($round > 1) { $s = $match_num - ($match_num - $source); echo $s; $source++; } else { echo "0"; } ?>" />
<?php
if($round > 1){ $prv_match2 = $s; }
?>
<div class="bracketbox">
<span class="info" style="color:#0937dc; font-weight:bold;"><?php 
echo $match_num;
$match_dt_time = '';
$court_name = '';
if($match_timings[$match_num] and $is_bye == 0){
//echo "<br>".$match_timings[$match_num][0] . " - " .date('m/d/Y H:i', (trim($match_timings[$match_num][2])));
	$i = 1;
	while($i <= 10 and ($new_match_timings[$prv_match1][2] == $match_timings[$pick_time][2] or $new_match_timings[$prv_match2][2] == $match_timings[$pick_time][2])) {
		$pick_time++;
	$i++;
	}

$court_name = $match_timings[$pick_time][0];
echo "&nbsp;&nbsp;&nbsp;".$court_name;
$match_dt_time = date('m/d/Y H:i', (trim($match_timings[$pick_time][2])));
$new_match_timings[$match_num] = array('1' => $court_name, '2' => $match_timings[$pick_time][2]);

$pick_time++;
}
?>
<!-- <input  type="text" class='form-control' placeholder="Date" id="sdate<?php echo $match_num; ?>"  name="match_date<?php echo $match_num; ?>" />  -->
<input type="hidden" id="court_<?php echo $match_num; ?>" name="assg_court<?php echo $match_num; ?>" 
value="<?php echo $court_name; ?>" />
<input type="text" placeholder="Date" id="sdate<?php echo $match_num; ?>" name="match_date<?php echo $match_num; ?>" value="<?php echo $match_dt_time; ?>" style="width: 62%;" />

<script>
var rid = "<?php echo $match_num; ?>";

  $('#sdate'+rid).fdatepicker({
		format: 'mm/dd/yyyy hh:ii',
		disableDblClickSelection: true,
		language: 'en',
		pickTime: true
	});
</script>

</span>
<?php
echo $output;
?>
</div>


<?php
if($round == ($total_rounds)){
	$match_num++;
$round2 = -1;
?>
<div class="third_place bracketbox">
<span class="info" style="color:#0937dc; font-weight:bold;"><?php 
echo $match_num;
$match_dt_time = '';
$court_name = '';
if($match_timings[$match_num] and $is_bye == 0){
//echo "<br>".$match_timings[$match_num][0] . " - " .date('m/d/Y H:i', (trim($match_timings[$match_num][2])));
	$i = 1;
	while($i <= 10 and ($new_match_timings[$prv_match1][2] == $match_timings[$pick_time][2] or $new_match_timings[$prv_match2][2] == $match_timings[$pick_time][2])) {
		$pick_time++;
	$i++;
	}

$court_name = $match_timings[$pick_time][0];
echo "&nbsp;&nbsp;&nbsp;".$court_name;
$match_dt_time = date('m/d/Y H:i', (trim($match_timings[$pick_time][2])));
$new_match_timings[$match_num] = array('1' => $court_name, '2' => $match_timings[$pick_time][2]);

$pick_time++;
}
?>
<!-- <input  type="text" class='form-control' placeholder="Date" id="sdate<?php echo $match_num; ?>"  name="match_date<?php echo $match_num; ?>" />  -->
<input type="hidden" id="court_<?php echo $match_num; ?>" name="assg_court<?php echo $round2; ?>" 
value="<?php echo $court_name; ?>" />
<input type="text" placeholder="Date" id="sdate<?php echo $match_num; ?>" name="match_date<?php echo $round2; ?>" value="<?php echo $match_dt_time; ?>" style="width: 62%;" />

<script>
var rid = "<?php echo $match_num; ?>";

  $('#sdate'+rid).fdatepicker({
		format: 'mm/dd/yyyy hh:ii',
		disableDblClickSelection: true,
		language: 'en',
		pickTime: true
	});
</script>

</span>
<?php
echo $output;
?>
</div>
<input type='hidden' name='round[]' value="<?php echo $round2; ?>" />

<input type='hidden' name="match_num[<?php echo $round2; ?>][]" value="<?php echo '-1'; ?>" />
<input type='hidden' name="player1[<?php echo $round2; ?>][<?php echo '-1'; ?>][0]" value="<?php echo $process_res[6][$ab][0]; ?>" />
<input type='hidden' name="player1[<?php echo $round2; ?>][<?php echo '-1'; ?>][1]" value="<?php 
	if($round > 1) { $s = ($match_num-2) - (($match_num-2) - ($source-2)); echo $s; /*$source++; */} else { echo "0"; } ?>" />
<?php
if($round > 1){ $prv_match1 = $s; }
?>
<input type='hidden' name="player2[<?php echo $round2; ?>][<?php echo '-1'; ?>][0]" value="<?php echo $process_res[6][$ab][1]; ?>" />
<input type='hidden' name="player2[<?php echo $round2; ?>][<?php echo '-1'; ?>][1]" value="<?php 
	if($round > 1) { $s = ($match_num-1) - (($match_num-1) - ($source-1)); echo $s; /*$source++; */} else { echo "0"; } ?>" />
<?php
}
?>

<?php
//$match_num++;

$y++;

	if($process_res[6][$ab][1] == '---') {

		if($round < 2){
		$teams[$x] = $process_res[6][$ab][0];
		}
		else{
		$teams[$x] = "---";
		}
		$x++;
	}
	else if($process_res[6][$ab][0] == '---') {
		if($round < 2){
		$teams[$x] = $process_res[6][$ab][1];
		}
		else{
		$teams[$x] = "---";
		}
		$x++;
	}
	else {
		$teams[$x] = '---';
		$x++;
	}

$match_num++;
}

unset($process_res[6]);
//print_r($teams);
//exit;

?>
</div>
<?php if($num_teams == 2){ ?>
  <div class="r<?php echo $total_rounds+1; ?>">
   		<div class="final">
        	<div class="bracketbox">
            	<span class="teamc"></span>
            </div>
        </div>
   </div>
<?php } ?>
<?php
$num_teams = $process_res[3];
$prev_round_games = $process_res[1];
($prev_round_games > 1) ? $process_res[1] = $process_res[1]/2: $process_res[1];
}
?>
</div>

<input type="hidden" id="tourn_id"  name="tourn_id" value="<?php echo $this->input->post('tourn_id'); ?>" />
<input type='hidden' name='match_type'	  value="<?php echo $this->input->post('types'); ?>" />
<input type='hidden' name='filter_events' value='<?php if($filter_events != '' and $filter_events != 'null') { echo $filter_events; }
else if($sport_level != '' and $sport_level != 'null'){ echo $sport_level; } ?>' />
<input type='hidden' name='age_group' value="<?php echo $this->input->post('type_gen'); ?>" />
<input type='hidden' name='ttype' value="<?php echo $ttype; ?>" />
<input type='hidden' name='is_publish_draw' value="<?php echo $is_publish_draw; ?>" />
<input type='hidden' name='br_game_day' value="<?php echo $br_game_day; ?>" />
<input type="hidden" name="draw_format"  id="draw_format"  value='<?=$draw_format;?>' />

<input type='hidden' name='squad' value='<?php echo serialize($seed_team); ?>' />
<div style='clear:both;'></div>
<!-- <div>
<input type="submit" class="league-form-submit1" name="bracket_confirm" id="bracket_confirm" value="Confirm & Save" />
</div> -->
</div>
</form>

<!-- <form id="your_form" action="<?php //echo base_url(); ?>league/pdf/<?php //echo $tourn_id; ?>" method="post">
<input type='hidden' name='users[]' value="<?php //print_r($this->input->post('users'));?>">
<input type="submit" class="league-form-submit1" name="capture" id="restore" value="Print" />
</form> -->

</div>
</div><!--Close Login-->

</div> 
</section>