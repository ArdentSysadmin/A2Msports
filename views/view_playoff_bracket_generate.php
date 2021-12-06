<link href="<?php echo base_url();?>css/foundation-datepicker.css" rel="stylesheet">
<script src="<?php echo base_url();?>js/foundation-datepicker.js"></script>
<style type="text/css">

			.brackets > div {
				vertical-align: top;
				clear: both;
			}
			.brackets > div > div {
				float: left;
				height: 100%;
			}
			.brackets > div > div > div {
				margin: 50px 0;
			}
			.brackets div.bracketbox {
				position: relative;
				width: 100%; height: 100%;
				border-top: 1px solid #555;
				border-right: 1px solid #555;
				border-bottom: 1px solid #555;
			}

			.brackets div.bracketbox1 {
				position: relative;
				width: 100%; height: 100%;
				border-top: 0px solid #555;
				border-right: 0px solid #555;
				border-bottom: 0px solid #555;
			}
			.brackets div.bracketbox2 {
				position: relative;
				width: 100%; height: 100%;
				border-top: 1px solid #555;
				border-right: 0px solid #555;
				border-bottom: 0px solid #555;
			}

			.brackets div.bracketbox > span.info {
				position: absolute;
				top: 25%;
				left: 25%;
				font-size: 0.8em;
				color: #BBB;
			}
			.brackets div.bracketbox > span {
				position: absolute;
				left: 5px;
				font-size: 0.85em;
			}
			.brackets div.bracketbox > span.teama {
				top: -20px;
			}
			.brackets div.bracketbox > span.teamb {
				bottom: -20px;
			}
			.brackets div.bracketbox > span.teamc {
				bottom: 1px;
			}
			.brackets > .group2 {
				height: 260px;
			}
			.brackets > .group2 > div {
				width: 49%;
			}
			.brackets > .group3 {
				height: 320px;
			}
			.brackets > .group3 > div {
				width: 32.7%;
			}
			.brackets > .group4 > div {
				width: 24.5%;
			}
			.brackets > .group5 > div {
				width: 19.6%;
			}
			.brackets > .group6 {
				height: 2000px;
			}
			.brackets > .group6 > div {
				width: 16.3%;
			}
			.brackets > div > .r1 > div {
				height: 60px;
			}
			.brackets > div > .r2 > div {
				margin: 80px 0 110px 0;
				height: 102px;
			}
			.r12 {
				margin: -87px 0 -26px 0 !important;
				height: 11px !important;
			}
			.brackets > div > .r3 > div {
				margin: 135px 0 220px 0;
				height: 71px;
			}
			.brackets > div > .r4 > div {
				margin: 176px 0 445px 0;
				height: 220px;
			}
			.brackets > div > .r5 > div {
				margin: 460px 0 0 0;
				height: 900px;
			}
			.brackets > div > .r6 > div {
				margin: 900px 0 0 0;
			}
			.brackets div.final > div.bracketbox {
				border-top: 0px;
				border-right: 0px;
				height: 0px;
			}
			.brackets > div > .r4 > div.drop {
				height: 180px;
				margin-bottom: 0px;
			}
			.brackets > div > .r5 > div.final.drop {
				margin-top: 345px;
				margin-bottom: 0px;
				height: 1px;
			}
			.brackets > div > div > div:last-of-type {
				margin-bottom: 0px;
			}
		</style>
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

<?php
list($q1_teams, $et_teams) = array_chunk($teams, ceil(count($teams) / 2));
$q2_teams = array('---', '---');

$po_list = array(
		'Q1' => $q1_teams,
		'Q2' => $q2_teams,
		'ET' => $et_teams,
		);

$po_list2 = array(
		'1' => array('1' => $q1_teams, '2' => $et_teams),
		'2' => array('3' => $q2_teams),
		'3' => array('4' => $q2_teams)
		);

	$et_team1	 = league::get_team(intval($et_teams[0]));		
	$et_team2	 = league::get_team(intval($et_teams[1]));	

	$q1_team1	 = league::get_team(intval($q1_teams[0]));		
	$q1_team2	 = league::get_team(intval($q1_teams[1]));	
?>
<section id="login" class="container secondary-page">
<div class="top-score-title right-score col-md-12">
<h3>Playoff Matches</h3>
<div class="col-md-12">
<form method="post" id="myform" action='<?php echo base_url(); ?>league/bracket_save' class="col-md-12 login-page"> 
<label>Draw Title*</label>&nbsp;&nbsp;<span id="title_error" style="color:red"></span>
<input class="form-control" type="text" name="draw_title" id="draw_title" required />

<div class="brackets" id="brackets">
<div class="group4" id="b1">
	<div class="r1">
		<div class="bracketbox">
			<span class="info">Eliminator</span>
			<span class="teama"><?=$et_team1['Team_name']." (3)";?></span>
			<span class="teamb"><?=$et_team2['Team_name']." (4)";?></span>
		</div>

		<!-- <div class="bracketbox1"></div> -->

		<div class="bracketbox">
			<span class="info">Qualifier 1</span>
			<span class="teama"><?=$q1_team1['Team_name']." (1)";?></span>
			<span class="teamb"><?=$q1_team2['Team_name']." (2)";?></span>
		</div>
   </div>
   <div class="r2">
		<div class="bracketbox">
			<span class="info">Qualifier 2</span>
			<span class="teama"><?=$q2_team[0];?></span>
			<span class="teamb"><?=$q2_team[1];?></span>
		</div>
		<div class="bracketbox2 r12">
			<span class="teama">&nbsp;</span>
		</div>
   </div>
   <div class="r3">
		<div class="bracketbox">
			<span class="teama">&nbsp;</span>
		</div>
   </div>
   <div class="r4">
   		<div class="final">
        	<div class="bracketbox">
            	<span class="teamc">&nbsp;</span>
            </div>
        </div>
   </div>
</div>
</div>
<input type="hidden" name="po_list"   id="po_list"  value='<?php echo serialize($po_list); ?>' />
<input type="hidden" name="po_list2"  id="po_list2" value='<?php echo serialize($po_list2); ?>' />
<input type="hidden" name="tourn_id"  id="tourn_id" value="<?php echo $this->input->post('tourn_id'); ?>" />
<input type='hidden' name='match_type'	value="<?php echo $this->input->post('types'); ?>" />
<input type='hidden' name='age_group'	value="<?php echo $this->input->post('type_gen'); ?>" />
<input type='hidden' name='filter_events' value='<?php if($filter_events != '' and $filter_events != 'null') { echo $filter_events; } 
else if($sport_level != '' and $sport_level != 'null'){ echo $sport_level; } ?>' />
<input type='hidden' name='ttype'		value="<?php echo $this->input->post('ttype'); ?>" />
<input type='hidden' name='is_publish_draw'		value="<?php echo $this->input->post('is_publish_draw'); ?>" />
<input type='hidden' name='num_of_sets'		value="<?php echo $this->input->post('num_of_sets'); ?>" />
<input type='hidden' name='br_game_day'	value="<?php echo $br_game_day; ?>" />
<input type="hidden" name="draw_format"  id="draw_format"  value='<?=$draw_format;?>' />

<input type="submit" class="league-form-submit1" name="po_bracket_confirm" id="po_bracket_confirm" value="Confirm & Save" />

</form>
</div>
</div>
</section>