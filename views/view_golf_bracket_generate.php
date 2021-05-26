<link href="<?php echo base_url();?>css/foundation-datepicker.css" rel="stylesheet">
<script src="<?php echo base_url();?>js/foundation-datepicker.js"></script>

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
				//	alert(msg);

				if(msg == 1){
				//alert(Draw_Title);
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
<!-- <div class="general general-results players"> -->
<!-- LOGIN BOX -->
<div class="top-score-title right-score col-md-12">
<h3>Selected Players</h3>
<div class="col-md-12">

<form method="post" id="myform" action='<?php echo base_url(); ?>league/bracket_save' class="col-md-8 login-page" >  

<label>Draw Title*</label>&nbsp;&nbsp;<span id="title_error" style="color:red"></span>
<input class="form-control" type="text" name="draw_title" id="draw_title" required />

<? //--------------------------------------------------------------------------------------------------------------- ?>
<?php
/*
echo "<pre>";
print_r($players_partners);
exit;*/
?>

<div class='tab-content'>
<table class='tab-score'>
<tr class='top-scrore-table'><td align='center'>Players</td></tr>

<?php
echo "<input type=hidden name='players[]' value='-1' />";

foreach($players as $player){
	$player_name = league::get_username(intval($player));
	echo "<tr align='center'><td>".$player_name['Firstname']." ".$player_name['Lastname']."</td></tr>";
	echo "<input type=hidden name='players[]' value='".$player."' />";
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
<input type='hidden' name='ttype' value="<?php echo $this->input->post('ttype'); ?>" />
<input type='hidden' name='is_publish_draw' value="<?php echo $this->input->post('is_publish_draw'); ?>" />
<input type='hidden' name='br_game_day'	value="<?php echo $br_game_day; ?>" />

<input type="submit" class="league-form-submit1" name="golf_bracket_confirm" id="golf_bracket_confirm" value=" Confirm & Save" />
</form>

</div>
</div>	  <!--end div of LOGIN BOX -->  

<!-- </div> -->    <!--end div of general-results players  -->  
</section>