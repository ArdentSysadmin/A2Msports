<script>
$(document).ready(function(){
$('#bracket_size').change(function(){
var size = $(this).val();
if(size == 'size'){
	$('#tournament_participants').removeAttr('required');
	$('#tourn_participants').show();
	$('#no_of_participants').attr('required', true);
	$('#tourn_Bracket12').hide();
	$('#tournament_participants').val('');
}else{
	$('#no_of_participants').removeAttr('required');
	$('#tourn_Bracket12').show();
	$('#tournament_participants').attr('required', true);
	$('#tourn_participants').hide();
	$('#no_of_participants').val('');
}
});

$('#tour_type').change(function(){
	var t_type = $(this).val();
	if(t_type == 'Round Robin'){
		$('#part_play_each').show();
	}else{
		$('#part_play_each').hide();
	}
});

});
</script>
<?php
			/*	$list_type		  = $this->input->post('bracket_size');

				if($list_type == 'participants'){
					$participants	  = $this->input->post('tournament_participants');
					$players		  = explode("\n", str_replace("\r", "", $participants));
				}
				else {
					$num_participants = $this->input->post('no_of_participants');
					$players		  = array();
					
					for($i = 0; $i < $num_participants; $i++) {
						$players[$i] = ($i+1).")"; 
					}
				}*/
if($this->input->post('bracket_size') == 'size'){
?>
<script>
	$(document).ready(function(){
	  $('#bracket_size').val('size').trigger('change');
	  $('#no_of_participants').val("<?php echo $this->input->post('no_of_participants'); ?>");
	});
</script>
<?php
}
?>
<section id="single_player" class="container secondary-page"> 
<div class="top-score-title right-score col-md-9"> 
<!-- Google AdSense -->
<div id='google' align='left'>
<script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
<ins class="adsbygoogle"
     style="display:block"
     data-ad-client="ca-pub-9772177305981687"
     data-ad-slot="1273487212"
     data-ad-format="auto"></ins>
<script>
(adsbygoogle = window.adsbygoogle || []).push({});
</script>
</div>
<!-- Google AdSense -->
<form class="form-horizontal" name='free_bracket_form' id='free_bracket_form' method='post' action="<?php echo base_url().'brackets';?>">  

<div class="col-md-12 league-form-bg" style="margin-top:30px;"> 
<div class="fromtitle">Bracket Generator</div>


<div style="margin-top:30px;">
<div class='form-group' id="tourn_name">
<label class='control-label col-md-3' for='id_accomodation'>Bracket Name </label>
<div class='col-md-8 form-group internal'>
<input class='form-control' name="tour_name" id="tour_name" type="text" style="width:36%" value="<?=$tour_name;?>" required /> 
</div>
</div> 

<div class='form-group' id="tourn_type">
<label class='control-label col-md-3' for='id_accomodation'>Bracket Type</label>
<div class='col-md-8 form-group internal'>
<select name="tour_type" id="tour_type" class='form-control' style="width:36%">
	<option value="Single Elimination" <?php $sel = ($type_format == "Single Elimination") ? "selected" : ""; echo $sel; ?>>Single Elimination</option>
	<option value="Round Robin" <?php $sel = ($type_format == "Round Robin") ? "selected" : ""; echo $sel; ?>>Round Robin</option>
	<option value="Consolation" <?php $sel = ($type_format == "Consolation") ? "selected" : ""; echo $sel; ?>>Consolation</option>
</select>
</div>
</div>

<div class='form-group' id="part_play_each" style="display:none">
<label class='control-label col-md-3' for='id_accomodation'>Participants play each other</label>
<div class='col-md-8 form-group internal'>
<select name="rr_rounds" id="rr_rounds" class='form-control' style="width:36%">
	<option value="1">Once</option>
	<option value="2">Twice</option>
	<option value="3">Thrice</option>
</select>
</div>
</div>

<div class='form-group' id="tourn_Bracket">
<label class='control-label col-md-3' for='id_accomodation'>Bracket Size</label>
<div class='col-md-8 form-group internal'>
<select name="bracket_size" id="bracket_size" class='form-control' style="width:60%">
	<option value="participants">Type Participants Names below</option>
	<option value="size">Select the size for blank bracket</option>
</select>
</div>
</div>

<div class='form-group' id="tourn_participants" style="display:none">
<label class='control-label col-md-3' for='id_accomodation'>Number of Participants</label>
<div class='col-md-8 form-group internal'>
<input type="number" name="no_of_participants" id="no_of_participants" class="form-control" style="width:36%" min="3" max="64" />
</div>
</div>

<div class='form-group' id="tourn_Bracket">
<label class='control-label col-md-3' for='id_accomodation'></label>
<div class='col-md-8 form-group internal' id="tourn_Bracket12">
<textarea class="form-control" style="height:200px;width:312px" name="tournament_participants" id="tournament_participants" required>
<?php
if($teams){ 
	foreach($teams as $i=>$team){
		if($i != (count($teams) - 1))
		  echo $team."\n";
		else
		  echo $team;
	}
}
?>
</textarea>
</div>
</div>

<div class='form-group' align='center' style='padding-right:15%'>
<input type="submit" name="generate" value="Generate Brackets" class="league-form-submit" />
</div>

</div>

</div> 
</form>

<!-- ------------------------- -->

<?php
if($type_format == 'Single Elimination') {
		$data['tour_name']	  = $tour_name;
		$data['type_format']  = $type_format;
		$data['teams']		  = $teams;
		$data['num_of_teams'] = $num_of_teams;

		$data['temp'] = serialize($data);

	if($num_of_teams <=32)
		echo $this->load->view('view_gen_se_draws', $data);
	else
		echo $this->load->view('view_gen_se64_draws', $data);
}
else if($type_format == 'Round Robin') {
		$data['tour_name']	  = $tour_name;
		$data['type_format']  = $type_format;
		$data['teams']		  = $teams;
		$data['num_of_teams'] = $num_of_teams;
	
		$data['robin_rounds']	= $robin_rounds;
		$data['robins']			= $robins;
		$data['total_games']	= $total_games;

		$data['rr_multi_rounds'] = $rr_multi_rounds;

		$data['temp'] = serialize($data);

	echo $this->load->view('view_gen_rr_draws', $data);
}
else if($type_format == 'Consolation') {
		$data['tour_name']	  = $tour_name;
		$data['type_format']  = $type_format;
		$data['teams']		  = $teams;
		$data['num_of_teams'] = $num_of_teams;

		$data['temp'] = serialize($data);

	echo $this->load->view('view_gen_cd_draws', $data);
}
?>
<script>

$('html, body').animate({
scrollTop: ($('#bracket_result').offset().top)
}, 500);

</script>
<!-- ------------------------- -->
<div style="clear:both"></div>
</div>
<!--Close Top Match -->