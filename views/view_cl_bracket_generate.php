<link href="<?php echo base_url();?>css/foundation-datepicker.css" rel="stylesheet"> 
<script src="<?php echo base_url();?>js/foundation-datepicker.js"></script>  

<script>
 $(document).ready(function(){
 var baseurl = "<?php echo base_url();?>";

 $('#myform').submit(function(e) {
	var Draw_Title = $('#draw_title').val();
	var Tourn_id   = $('#tourn_id').val();

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

	$('#sdate1').fdatepicker({
		format: 'mm/dd/yyyy hh:ii',
		disableDblClickSelection: true,
		language: 'en',
		pickTime: true
	});

    $('#edate1').fdatepicker({
		format: 'mm/dd/yyyy hh:ii',
		disableDblClickSelection: true,
		language: 'en',
		pickTime: true
	});
});
</script>

<section id="login" class="container secondary-page">  
<div class="general general-results players view-brack1">

<!-- LOGIN BOX -->
<div class="top-score-title right-score col-md-12">
<h3>Bracket Generation</h3>
<div class="col-md-12 login-page">
<form method="post" id="myform" action='<?php echo base_url(); ?>league/bracket_save' class="login-form" style="width:100%;">

<label>Draw Title*</label>&nbsp;&nbsp;<span id="title_error" style="color:red"></span>
<input class="form-control" type="text" name="draw_title" id="draw_title" style="width:40%; border-radius: 8px; background-color: #f9f9f9;'" required />
<br />

<label>Challenge Positions</label>
<select id="ch_ladder_position" name="ch_ladder_position" class='form-control' style="width:15%" required />
	<option value="1" <?php if($ch_positions == '1'){ echo "selected = 'selected'"; } ?>>1</option>
	<option value="2" <?php if($ch_positions == '2'){ echo "selected = 'selected'"; } ?>>2</option>
	<option value="3" <?php if($ch_positions == '3'){ echo "selected = 'selected'"; } ?>>3</option>
	<option value="4" <?php if($ch_positions == '4'){ echo "selected = 'selected'"; } ?>>4</option>
	<option value="5" <?php if($ch_positions == '5'){ echo "selected = 'selected'"; } ?>>5</option>
</select>
<br />
<label>Challenge Duration (Days)</label>
<select id="ch_ladder_duration" name="ch_ladder_duration" class='form-control' style="width:15%" required />
<?php
for($i = 1; $i < 11; $i++){
?>
<option value="<?=$i;?>" <?php if($i==7){ echo "selected='selected'";} ?>><?=$i;?></option>
<?php
}
?>
</select>
<br />

<label>Start Date</label>
<input type="text" placeholder="Date" id="sdate1" name="match_sdate" value="<?=date('m/d/Y', strtotime($sdate));?>" style="width:20%; border-radius: 8px; background-color: #f9f9f9;'"/>

<label>End Date</label>
<input type="text" placeholder="Date" id="edate1" name="match_edate" value="<?=date('m/d/Y', strtotime($edate));?>" style="width:20%; border-radius: 8px; background-color: #f9f9f9;'"/>

<?php //echo "Date After One Month Is :: ".date('m/d/Y', strtotime('+1 year')); ?>
<br />
<div class="col-md-8" id="brackets">
<table class="tab-score">
<tr class="top-scrore-table">
	<td align="center"><b>Player</b></td>
	<td align="center"><b>Level</b></td>
	<td align="center">Change To</td>
</tr>
	<?php
	foreach($players as $l => $player){

		$level = "<select name='levels[]'>";
		for($i = 1; $i<=count($players); $i++){
			$sel = '';
			if( ($l+1) == $i){
				$sel = "selected = 'selected'";
			}
			$level .= "<option value='{$i}' {$sel}>{$i}</option>";
		}
		$level .= "</select>";

		$exp_player = explode('-', $player);
		$get_p1 = league::get_username(intval($exp_player[0]));

		$p1 = $get_p1['Firstname']." ".$get_p1['Lastname'];
		$p1p = "";
		if($exp_player[1]){
		$get_p1p = league::get_username(intval($exp_player[1]));

		$p1p = "; ".$get_p1p['Firstname']." ".$get_p1p['Lastname'];
		}
		echo "<tr>";
		echo "<td align='center'>".$p1.$p1p."</td>";
		echo "<td align='center'>".($l+1)."</td>";
		echo "<td align='center'>".$level."</td>";
		echo "</tr>";
	}
	?>
</table>

<input type="hidden" id="tourn_id"  name="tourn_id" value="<?php echo $this->input->post('tourn_id'); ?>" />
<input type='hidden' name='match_type'	  value="<?php echo $this->input->post('types'); ?>" />
<input type='hidden' name='filter_events' value='<?php if($filter_events != '' and $filter_events != 'null') { echo $filter_events; } 
else if($sport_level != '' and $sport_level != 'null'){ echo $sport_level; } ?>' />
<input type='hidden' name='players'	value='<?php echo serialize($players); ?>' />
<input type='hidden' name='ttype'	value="<?php echo $ttype; ?>" />
<input type='hidden' name='is_publish_draw'	value="<?php echo $is_publish_draw; ?>" />
<input type='hidden' name='num_of_sets'	value="<?php echo $num_of_sets; ?>" />
<input type='hidden' name='br_game_day'	value="<?php echo $br_game_day; ?>" />
<input type="hidden" name="draw_format"  id="draw_format"  value='<?=$draw_format;?>' />

<br /><br /><br />
<div>
<input type="submit" class="league-form-submit1" name="cl_bracket_confirm" id="cl_bracket_confirm" value="Confirm & Save" />
</div>

</div>
</form>

</div>
</div><!--Close Login-->

</div> 
</section>