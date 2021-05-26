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
<!-- <div class="general general-results players">
 -->
<!-- LOGIN BOX -->
<div class="top-score-title right-score col-md-12">
<h3>Round Robin Matches</h3>
<div class="col-md-12">

<form method="post" id="myform" action='<?php echo base_url(); ?>league/bracket_save' class="col-md-8 login-page" >  

<label>Draw Title*</label>&nbsp;&nbsp;<span id="title_error" style="color:red"></span>
<input class="form-control" type="text" name="draw_title" id="draw_title" required />

<? //--------------------------------------------------------------------------------------------------------------- ?>
<?php

$robin = $robins;

//echo "<pre>";
//print_r($robin);

$total_matches = count($robin);
if($total_matches > 3){
	$num_rounds = ($total_matches % 2 == 0) ? ($total_matches / 2) : ($total_matches / 3);

	if($num_rounds > 10)
	{
	$num_rounds = ($total_matches % 4 == 0) ? ($total_matches / 4) : ($total_matches / 5);
	}

	$per_round = $total_matches / $num_rounds;
}
else{
$per_round = 1;
$num_rounds = 3;
}


$round_num = 1;
$match_num = 1;
$p1 = 0;

/*echo "<br>per_round= ".$per_round;
echo "<br>num_rounds= ".$num_rounds;
exit;*/

$players = array();

$per_round_count = 1;
foreach($robin as $rr)
{
		
/* --------Get individual player array-------- */

	$rr_p1 = explode('-',$rr[0]);
	$rr_p2 = explode('-',$rr[1]);


	if(!in_array($rr_p1[0], $players)){
		$players[] = $rr_p1[0];
		$players_partners[$rr_p1[0]] = $rr_p1[1];
	}

	if(!in_array($rr_p2[0], $players)){
		$players[] = $rr_p2[0];
		$players_partners[$rr_p2[0]] = $rr_p2[1];
	}

/* --------End of individual player array------ */

	$rr_matches[$round_num][$match_num][] = $rr[0];
	$rr_matches[$round_num][$match_num][] = $rr[1];

	if($round_num != $num_rounds && $per_round == $per_round_count)
	{
		$round_num++;
		$per_round_count = 1;
	}
	else
	{
		$per_round_count++;
	}

$match_num++;
}


/*
echo "<pre>";
print_r($players_partners);
exit;*/
?>
   <script>
$(document).ready(function(){

 $('body').on('focus',".datepicker", function(){
    $(this).datepicker();
});

});

</script>
<input type='hidden' name='rr_matches' id='rr_matches' value="<?php echo htmlentities(serialize($rr_matches)); ?>" />
<div class='tab-content'>
<table class='tab-score'>
<?php
foreach($rr_matches as $i=>$rrm){
?>
<tr class='top-scrore-table'><td align='center'>Round <?=$i;?></td>
<td>
<div>
<input style='width:40%' type='text' class='datepicker' placeholder='mm/dd/yyyy' id='sdate<?php echo $i; ?>' name='round_date<?php echo $i; ?>' />
<select name='match_time_hr<?php echo $i; ?>'>
<option value=''>HH</option>
<?php for($j=0; $j<13; $j++){
$hh = ($j<10) ? "0".$j : $j;
echo "<option value='$hh'>$hh</option>";
}?></select>

<select name='match_time_mm<?php echo $i; ?>'>
<option value=''>MM</option>
<?php for($k=0; $k<60; ($k += 5)){
$mm = ($k<10) ? "0".$k : $k;
echo "<option value='$mm'>$mm</option>";
}?></select>

<select name='match_time_am<?php echo $i; ?>'>
<option value='am'>AM</option>
<option value='pm'>PM</option>
</select>
</div>
 </td>
 </tr>
 <?php
 	 echo "<tr align='center'><td><b>Player 1 / Team 1</b></td><td><b>Player 2 / Team 2</b></td></tr>";

 foreach($rr_matches[$i] as $j=>$match){
	$rr_p1 = explode('-',$rr_matches[$i][$j][0]);
	$rr_p2 = explode('-',$rr_matches[$i][$j][1]);

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

	 echo "<tr align='center'><td>".$player1['Firstname']." ".$player1['Lastname'].$p1_part."</td>
	 <td style='font-weight:normal'>".$player2['Firstname']." ".$player2['Lastname'].$p2_part."</td></tr>";

?>

 
<?php
 }
}
?>
</table>
</div>
<br />
<br />

<? // -------------------------------------------------------------------------------------------------------------- ?>

<input type="hidden" name="tourn_id" id="tourn_id" value="<?php echo $tourn_id; ?>" />
<input type='hidden' name='match_type' value="<?php echo $this->input->post('types'); ?>" />
<input type='hidden' name='age_group' value="<?php echo $this->input->post('type_gen'); ?>" />

<input type="submit" class="league-form-submit1" name="rr_bracket_confirm" id="rr_bracket_confirm" value=" Confirm & Save" />
</form>

</div>
</div>	  <!--end div of LOGIN BOX -->  

<!-- </div> -->    <!--end div of general-results players  -->  
</section>