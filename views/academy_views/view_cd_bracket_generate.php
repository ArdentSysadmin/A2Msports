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
					//event.preventDefault();	
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
<div class="general general-results players">

<!-- LOGIN BOX -->
<div class="top-score-title right-score col-md-12">
<h3>Bracket Generation</h3>
<div class="col-md-12 login-page">
<form method="post" id="myform" action='<?php echo base_url().$this->short_code; ?>/league/bracket_save' class="login-form"> 


<label>Draw Title*</label>&nbsp;&nbsp;<span id="title_error" style="color:red"></span>
<input class="form-control" type="text" name="draw_title" id="draw_title" required />

<br />

<div class="brackets" id="brackets">

<?php  
$num_teams = $num_of_teams;
$pow_vals = array(2,4,8,16,32,64,128,256,512);

$log_val = ceil(log($num_teams, 2));
((in_array($log_val, $pow_vals)) or (in_array($num_teams, $pow_vals))) ? $total_rounds = $log_val : $total_rounds =  floor(log($num_teams, 2)) + 1;

$match_num = 1;
?>
<div class="group<?php echo $total_rounds+1; ?>" id="b1">
<?php


for($round = 1, $source=1 ; $round <= $total_rounds; $round++) {
?>
<div class="r<?php echo $round; ?>" style="text-align:center">
<input type='hidden' name='round[]' value="<?php echo $round; ?>" />
<br>

<script>
$(function() {
 var rid = "<?php echo $round; ?>";
 $('#sdate_round'+rid).datepick();
});
</script>

<span style="text-align: center"><b>
<?php

$process_res = league::cd_cal_c($pow_vals, $num_teams, $teams, $round, 'Main');
$teams = array();

if($round == 1)
{

//$num_looser_arr = count($process_res[8]);
//$looser_arr = $process_res[8];

$lteams = array();
$lteams_bye = array();
$lteams_game = array();

//$num_looser_arr = $process_res[7];
/*foreach($looser_arr as $pr)
{
	$lteams[] = $pr[2];
}*/

}

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
<input  type="text" class='form-control' placeholder="Date" id="sdate_round<?php echo $round; ?>"  name="round_date<?php echo $round; ?>" />

<?php
//--------------------------
$x=0;
$cnt = count($process_res[6]);
//echo "<pre>";
//print_r($process_res[6]);
//exit;

foreach($process_res[6] as $ab => $game_pl){
	if($round == 1){
	if($process_res[6][$ab][1]=="---")
	{
		$ind = $cnt + $match_num;
		if(!in_array("M-$ind", $lteams)) {
			//echo 'cnt = '.$cnt." match# ". $match_num. "ind ".$ind."<br>";
			//$lteams_bye[] = "M-$ind";
			$lteams_game[] = "M-$ind";
		}
			if($match_num % 3 == 0 or $match_num == 1 or $match_num == 5 or $match_num == 14)
			$cnt--;
	}
	else
	{
		if(!in_array("M-$match_num", $lteams)) {
			//$lteams_game[] = "M-$match_num";
			$lteams_bye[] = "M-$match_num";
		}
			if($match_num % 3 == 0 or $match_num == 1 or $match_num == 5 or $match_num == 14)
			$cnt--;
	}


		$lteams = array_merge($lteams_game,$lteams_bye);
		$num_looser_arr = count($lteams);
		$looser_arr = $lteams;
	}

$y = 1;

	$double_bye_pl = explode("-", $process_res[6][$ab][0]);
	$get_username = league::get_username(intval($process_res[6][$ab][0]));

	 $get_partner = league::get_username(intval($double_bye_pl[1]));


	$double_game_pl_2 = explode("-", $process_res[6][$ab][1]);
	 $get_username2 = league::get_username(intval($process_res[6][$ab][1]));

	 $get_partner2 = league::get_username(intval($double_game_pl_2[1]));
?>
<input type='hidden' name="match_num[<?php echo $round; ?>][]" value="<?php echo $match_num; ?>" />
<input type='hidden' name="player1[<?php echo $round; ?>][<?php echo $match_num; ?>][0]" value="<?php echo $process_res[6][$ab][0]; ?>" />
<input type='hidden' name="player1[<?php echo $round; ?>][<?php echo $match_num; ?>][1]" value="<?php 
	if($round > 1) { $s = $match_num - ($match_num - $source); echo $s; $source++; } else { echo "0"; } ?>" />

<input type='hidden' name="player2[<?php echo $round; ?>][<?php echo $match_num; ?>][0]" value="<?php echo $process_res[6][$ab][1]; ?>" />
<input type='hidden' name="player2[<?php echo $round; ?>][<?php echo $match_num; ?>][1]" value="<?php 
	if($round > 1) { $s = $match_num - ($match_num - $source); echo $s; $source++; } else { echo "0"; } ?>" />

<div class="bracketbox">
<span class="info"><?php echo $match_num; ?>
 <input  type="text" class='form-control' placeholder="Date" id="sdate<?php echo $match_num; ?>"  name="match_date<?php echo $match_num; ?>" /> 
</span>
<script>
$(function() {
 var spid = "<?php echo $match_num; ?>";
 $('#sdate'+spid).datepick();
});
</script>

<span class="teama">
<?php 
	if($get_username){ echo $get_username['Firstname']." ".$get_username['Lastname']; }  else { echo "---"; }
	if($get_partner){ echo " - ".$get_partner['Firstname']." ".$get_partner['Lastname']; }
?></span>
<span class="teamb"><?php 
	if($get_username2){ echo $get_username2['Firstname']." ".$get_username2['Lastname']; } else { ($round==1)? $mn = "Bye": $mn = "---"; echo $mn; }
	if($get_partner2){ echo " - ".$get_partner2['Firstname']." ".$get_partner2['Lastname']; }
?></span>
</div>

<?php
//$match_num++;

$y++;

	if($process_res[6][$ab][1]=='---'){

		if($round < 2){
		$teams[$x] = $process_res[6][$ab][0];
		}
		else{
		$teams[$x] = "---";
		}
		$x++;
	}
	else{

		$teams[$x] = '---';
		$x++;
	}

$match_num++;
}
//echo "<pre>";
//print_r($lteams);

unset($process_res[6]);
?>
</div>
<?php if($num_teams == 2){ ?>
  <div class="r<?php echo $total_rounds+1; ?>">
   		<div class="final final1">
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

<!-- <input type="hidden" name="tourn_id" value="<?php //echo $tourn_id; ?>" />
<input type='hidden' name='match_type' value="<?php //echo $this->input->post('types'); ?>" />
<input type='hidden' name='age_group' value="<?php //echo $this->input->post('type_gen'); ?>" /> -->
<!-- <input type="submit" class="league-form-submit1" name="bracket_confirm" id="bracket_confirm" value="Confirm & Save" /> -->
</div>

<!-- -------------------------------------  Consolation Draw  ------------------------------------------------------------------------------- -->

<div class="brackets" id="brackets">

<?php
$num_teams = $num_looser_arr;
$pow_vals = array(2,4,8,16,32,64,128,256,512);

$log_val = ceil(log($num_teams, 2));
((in_array($log_val, $pow_vals)) or (in_array($num_teams, $pow_vals))) ? $total_rounds = $log_val : $total_rounds =  floor(log($num_teams, 2)) + 1;

$match_num = 1;
?>
<div class="group<?php echo $total_rounds+1; ?>" id="b1">
<?php
for($round = 1, $source=1 ; $round <= $total_rounds; $round++) {
?>
<div class="r<?php echo $round; ?>" style="text-align:center">
<input type='hidden' name='c_round[]' value="<?php echo $round; ?>" />
<br>
<script>
$(function() {
 var rid = "<?php echo $round; ?>";
 $('#sdate_cround'+rid).datepick();
});
</script>

<span style="text-align: center"><b>
<?php

$process_res = league::cd_cal_c($pow_vals, $num_teams, $lteams, $round, 'Consolation');
$lteams = array();

$rt = $process_res[1] + $process_res[2];
//--------------------------
if($rt >= pow(2,3)){
	$rrt = $rt*2;
	//echo "Round of $rrt";
	}
else {
		switch($rt)
		{
			case 1:
				echo "Consolation Draw";
				//echo "Final";
				break;
			case 2:
				//echo "Semi-Final";
				break;
			case 4:
				//echo "Quarter-Final";
				break;
			default:
				//echo "";
				break;
		}
	}
?>
</b></span>
<br>
<input  type="text" class='form-control' placeholder="Date" id="sdate_cround<?php echo $round; ?>"  name="cround_date<?php echo $round; ?>" />

<?php
//--------------------------
$x=0;
foreach($process_res[8] as $ab => $game_pl){
	
$y = 1;
	//$double_bye_pl = explode("-", $process_res[6][$ab][0]);
	//$get_username = league::get_username(intval($process_res[6][$ab][0]));

	// $get_partner = league::get_username(intval($double_bye_pl[1]));


	//$double_game_pl_2 = explode("-", $process_res[6][$ab][1]);
	 //$get_username2 = league::get_username(intval($process_res[6][$ab][1]));

	 //$get_partner2 = league::get_username(intval($double_bye_pl[1]));
?>
<input type='hidden' name="c_match_num[<?php echo $round; ?>][]" value="<?php echo $match_num; ?>" />
<input type='hidden' name="c_player1[<?php echo $round; ?>][<?php echo $match_num; ?>][0]" value="<?php //echo $process_res[6][$ab][0]; ?>" />
<input type='hidden' name="c_player1[<?php echo $round; ?>][<?php echo $match_num; ?>][1]" value="<?php 
	if($round > 1) { $s = $match_num - ($match_num - $source); echo $s; $source++; } else { $s = explode("-", $process_res[8][$ab][0]);
  echo intval($s[1]); } ?>" />

<input type='hidden' name="c_player2[<?php echo $round; ?>][<?php echo $match_num; ?>][0]" value="<?php //echo $process_res[6][$ab][1]; ?>" />
<input type='hidden' name="c_player2[<?php echo $round; ?>][<?php echo $match_num; ?>][1]" value="<?php 
	if($round > 1) { $s = $match_num - ($match_num - $source); echo $s; $source++; } else { $s = explode("-", $process_res[8][$ab][1]);
  echo intval($s[1]); } ?>" />

<div class="bracketbox">
<span class="info"><?php echo $match_num; ?>
<input  type="text" class='form-control' placeholder="Date" id="sdate_c<?php echo $match_num; ?>"  name="cmatch_date<?php echo $match_num; ?>" />
</span>

<script>
$(function() {
 var spid = "<?php echo $match_num; ?>";
 $('#sdate_c'+spid).datepick();
});
</script>


<span class="teama">
<?php
	if($process_res[8][$ab][0]){

		$double_pl = explode("-", $process_res[8][$ab][0]);

		$get_username = league::get_username(intval($process_res[8][$ab][0]));
		$get_dbl_partner1 = league::get_username(intval($double_pl[1]));

		if($get_username){ echo $get_username['Firstname']." ".$get_username['Lastname']; }  else { echo "---"; }
		if($get_dbl_partner1){ echo "; ".$get_dbl_partner1['Firstname']." ".$get_dbl_partner1['Lastname']; }
	}
	else{
		echo $process_res[8][$ab][0];
	}
?>
</span>
<span class="teamb"><?php
	if($process_res[8][$ab][1]){

		$double_pl = explode("-", $process_res[8][$ab][1]);

		$get_username2 = league::get_username(intval($process_res[8][$ab][1]));
		$get_dbl_partner2 = league::get_username(intval($double_pl[1]));

		if($get_username2){ echo $get_username2['Firstname']." ".$get_username2['Lastname']; }  else { echo "---"; }
		if($get_dbl_partner2){ echo "; ".$get_dbl_partner2['Firstname']." ".$get_dbl_partner2['Lastname']; }
	}
	else{
		echo $process_res[8][$ab][1];
	}
?>
</span>
</div>
<?php
//$match_num++;

$y++;

	if($process_res[8][$ab][1]=='---'){

		if($round < 2){
		$lteams[$x] = $process_res[8][$ab][0];
		}
		else{
		$lteams[$x] = "---";
		}
		$x++;
	}
	else{

		$lteams[$x] = '---';
		$x++;
	}

$match_num++;
}

unset($process_res[8]);
?>
</div>
<?php if($num_teams == 2){ ?>
  <div class="r<?php echo $total_rounds+1; ?>">
   		 <div class="final final1">
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

<input type="hidden" id="tourn_id" name="tourn_id" value="<?php echo $this->input->post('tourn_id'); ?>" />
<input type='hidden' name='match_type' value="<?php echo $this->input->post('types'); ?>" />
<input type='hidden' name='age_group' value="<?php echo $this->input->post('type_gen'); ?>" />

<input type="submit" class="league-form-submit1" name="bracket_confirm" id="bracket_confirm" value="Confirm & Save" />
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