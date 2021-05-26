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

<script>
$(function() {
 var rid = "<?php echo $round; ?>";
 $('#sdate_round'+rid).datepick();
});
</script>

<input type='hidden' name='round[]' value="<?php echo $round; ?>" />
<br>
<span style="text-align: center">
<b>
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
<input  type="text" class='form-control' placeholder="Date" id="sdate_round<?php echo $round; ?>"  name="round_date<?php echo $round; ?>" />

<?php
//--------------------------
$x=0;
foreach($process_res[6] as $ab => $game_pl){
	

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
	if($get_username2){ echo $get_username2['Firstname']." ".$get_username2['Lastname']; } else { ($round==1)? $mn = "Bye" : $mn = "---"; echo $mn; }
	if($get_partner2 && $get_partner){ echo " - ".$get_partner2['Firstname']." ".$get_partner2['Lastname']; }
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