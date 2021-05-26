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

<form method="post" id="myform" action='<?php echo base_url(); ?>league/bracket_save' class="col-md-12 login-page" >  

<label>Draw Title*</label>&nbsp;&nbsp;<span id="title_error" style="color:red"></span>
<input class="form-control" type="text" name="draw_title" id="draw_title" required />

<? //--------------------------------------------------------------------------------------------------------------- ?>

<?php

$robin = $robins;

/*echo "<pre>";
print_r($robin);
exit;*/

$players = array();
foreach($robin as $rr){

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
}

/*echo "<pre>";
print_r($players);

echo "<pre>";
print_r($players_partners);
exit;*/
?>
   
<div class='tab-content'>
<table class='tab-score'>
<tr class='top-scrore-table'>
<td>Team</td>
<?php
for($i=1; $i<=(count($players)-1); $i++)
{ ?>
<td>Match-<?=$i;?></td>
<?php
}
?>
</tr>
<?php
$i = 1;
foreach($players as $player){

	$pl_name = league::get_username(intval($player));
	echo "<tr><td style='padding:5px'><b>$pl_name[Firstname] $pl_name[Lastname]";
	if($players_partners[$player]){
	$pl_part_name = league::get_username(intval($players_partners[$player]));
	echo "; $pl_part_name[Firstname] $pl_part_name[Lastname]";
	}
	echo "</b></td>";

	foreach($robin as $rr){

	$rr_p1 = explode('-',$rr[0]);
	$rr_p2 = explode('-',$rr[1]);

	if($player == $rr_p1[0])
	{
		$player1 = league::get_username(intval($rr_p2[0]));
		
	echo "<td style='padding:5px'>";
		echo "<div>$player1[Firstname] $player1[Lastname]";
		if($rr_p2[1]){
			$player1_partner = league::get_username(intval($rr_p2[1]));
			echo "; $player1_partner[Firstname] $player1_partner[Lastname]";
		}
		echo "</div>";
?>
<input  type="text" class='form-control' placeholder="Date" id="sdate<?php echo $i; ?>"  name="match_date<?php echo $i; ?>" />
&nbsp;&nbsp;
<script>
$(function() {
 var spid = "<?php echo $i; ?>";
 $('#sdate'+spid).datepick();
});
</script>

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

	<input type='hidden' name="match[<?php echo $i; ?>][0]" value="<?php echo $rr[0]; ?>" />
	<input type='hidden' name="match[<?php echo $i; ?>][1]" value="<?php echo $rr[1]; ?>" />

<?php
	echo "</td>";
	$i++;
	}
	else if($player == $rr_p2[0])
	{
		$player1 = league::get_username(intval($rr_p1[0]));

	echo "<td style='padding:5px'>";
		echo "<div>$player1[Firstname] $player1[Lastname]";

		if($rr_p1[1]){
			$player1_partner = league::get_username(intval($rr_p1[1]));
			echo "; $player1_partner[Firstname] $player1_partner[Lastname]";
		}
		echo "</div>";
?>
<!-- <input  type="text" class='form-control' placeholder="Date" id="sdate<?php echo $i; ?>"  name="match_date<?php echo $i; ?>" />
&nbsp;&nbsp;
<script>
$(function() {
 var spid = "<?php echo $i; ?>";
 $('#sdate'+spid).datepick();
});
</script>

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
</select> -->
<?php
	echo "</td>";
	}
?>


<?php
//echo $i;
//$i++;
	}	// End of Foreach $rr_matches
	echo "<td></td>";
echo "</tr>";
?>
<?php
}	// End of Foreach $players
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