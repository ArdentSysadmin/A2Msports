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
<h3>Round Robin Matches</h3>
<div class="col-md-12 login-page">

<form method="post" id="myform" action='<?php echo base_url(); ?>league/bracket_save' class="login-form" >  

<label>Draw Title*</label>&nbsp;&nbsp;<span id="title_error" style="color:red"></span>
<input class="form-control" type="text" name="draw_title" id="draw_title" required />

<br />

<?php
$robin = $robins;

echo "<table class='tab-score' id='test'>";
?>
<tr class="top-scrore-table">
<td class="score-position" valign="center" align="center"  style='font-weight:bold'>Match#</td>
<?php
if($types == "Doubles"){
?>
<td class="score-position" valign="center" align="center"> Team-1&nbsp;&nbsp;&nbsp;vs&nbsp;&nbsp;&nbsp;Team-2</td>
<?php
} else {
?>
<td class="score-position" valign="center" align="center"> Player-1&nbsp;&nbsp;&nbsp;vs&nbsp;&nbsp;&nbsp;Player-2</td>
<?php
}
?>
</tr>
<?php
$i = 1;
foreach($robin as $rr)
{
	$double_plyr = explode("-", $rr[0]);

	if($types == "Doubles"){
	$get_username = league::get_username(intval($double_plyr[0]));
	$get_partner1 = league::get_username(intval($double_plyr[1]));
	}
	else
	{
	$get_username = league::get_username(intval($rr[0]));
	}


	$double_plyr2 = explode("-", $rr[1]);

	if($types == "Doubles"){
	$get_username2 = league::get_username($double_plyr2[0]);
	$get_partner2 = league::get_username(intval($double_plyr2[1]));
	}
	else
	{
	$get_username2 = league::get_username(intval($rr[1]));
	}

	if($types == "Doubles"){
		echo "<tr>
		<td align='center'>$i</td>
		<td align='center' style='font-weight:normal'>".$get_username['Firstname']." ".$get_username['Lastname']."; ".$get_partner1['Firstname']." ".$get_partner1['Lastname']."&nbsp;&nbsp;&nbsp;vs&nbsp;&nbsp;&nbsp; ".$get_username2['Firstname']." ".$get_username2['Lastname']."; ".$get_partner2['Firstname']." ".$get_partner2['Lastname']."</td></tr>";
	} else {
		echo "<tr>
		<td align='center'>$i</td>
		<td align='center' style='font-weight:normal'>".$get_username['Firstname']." ".$get_username['Lastname']."&nbsp;&nbsp;&nbsp;vs&nbsp;&nbsp;&nbsp; ".$get_username2['Firstname']." ".$get_username2['Lastname']."</td></tr>";
	}
?>
	<input type='hidden' name="match[<?php echo $i; ?>][0]" value="<?php echo $rr[0]; ?>" />
	<input type='hidden' name="match[<?php echo $i; ?>][1]" value="<?php echo $rr[1]; ?>" />
<?php
$i++;
}
echo "</table>";
?>
<br /><br />

<input type="hidden" name="tourn_id" id="tourn_id" value="<?php echo $tourn_id; ?>" />
<input type='hidden' name='match_type' value="<?php echo $this->input->post('types'); ?>" />
<input type='hidden' name='age_group' value="<?php echo $this->input->post('type_gen'); ?>" />

<input type="submit" class="league-form-submit1" name="rr_bracket_confirm" id="rr_bracket_confirm" value=" Confirm & Save" />
</form>

</div>
</div>	  <!--end div of LOGIN BOX -->  

</div>    <!--end div of general-results players  -->  
</section>