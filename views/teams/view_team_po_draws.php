<link href="<?php echo base_url();?>css/foundation-datepicker.css" rel="stylesheet">
<script src="<?php echo base_url();?>js/foundation-datepicker.js"></script>
<script type="text/javascript">
$(document).ready(function(){

var baseurl = "<?php echo base_url();?>";
$('.show_linematch_score').click(function (e) {

	var mid = $(this).attr('id');
	var header="show";
	//alert(mid);
	var a = mid.split('_');
	//if(('#lines_div').css('display') != 'none'){
	// $('#linematchscorelp2_'+a[1]).fadeOut(1000);
	//}
		setTimeout(function(){
		  $.ajax({
			type: 'POST',
			url: baseurl+'league/get_line_matches',
			data:{'P':a[0], 'mid':a[1], 'T1':a[2], 'T2':a[3],'header':header},
			success: function(res){
				//console.log(res);
				  $('#linematchscorelp2').show();
				  $('#showlinematchscorelp2').html(res);
			}
		  });
		}, 500); 
	  e.preventDefault();
});
});
	
</script>
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
			.brackets div.bracketbox2 > span {
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
<?php
/*echo "<pre>";
print_r($get_po_tourn_matches->result());
print_r($get_po_line_matches->result());
exit;*/
$po_matches = $get_po_tourn_matches->result();

/*echo "<pre>";
print_r($po_matches);
exit;
*/
	$et_team1	 = league::get_team(intval($po_matches[1]->Player1));
	$et_team2	 = league::get_team(intval($po_matches[1]->Player2));
	$et_winner	 = league::get_team(intval($po_matches[1]->Winner));
  //echo "<pre>";print_r($et_winner['Team_ID']);exit();
	if($et_winner['Team_ID'] == $po_matches[1]->Player1){
     $et_points = $po_matches[1]->Player1_points.' - '.$po_matches[1]->Player2_points;
	}else{
	  $et_points = $po_matches[1]->Player2_points.' - '.$po_matches[1]->Player1_points;
	}
    
	
	$q1_team1	 = league::get_team(intval($po_matches[0]->Player1));	
	$q1_team2	 = league::get_team(intval($po_matches[0]->Player2));
	$q1_winner	 = league::get_team(intval($po_matches[0]->Winner));
    
	if($q1_winner['Team_ID'] == $po_matches[0]->Player1){
       $q1_points = $po_matches[0]->Player1_points.' - '.$po_matches[0]->Player2_points;
	}else{
	   $q1_points = $po_matches[0]->Player2_points.' - '.$po_matches[0]->Player1_points;
	}
    
	//echo $q1_points;exit();
	$q1_loser	 = '';

	if($po_matches[0]->Winner != NULL and $po_matches[0]->Winner != '' and $po_matches[0]->Winner != 0){
		if($po_matches[0]->Winner == $po_matches[0]->Player1){
		$q1_loser	 = league::get_team(intval($po_matches[0]->Player2));
		}
		else{
		$q1_loser	 = league::get_team(intval($po_matches[0]->Player1));
		}
	}

	$q2_winner	 = league::get_team(intval($po_matches[2]->Winner));

    if($q2_winner['Team_ID'] == $po_matches[2]->Player1){
       $q2_points = $po_matches[2]->Player1_points.' - '.$po_matches[2]->Player2_points;	
    }else{
       $q2_points = $po_matches[2]->Player2_points.' - '.$po_matches[2]->Player1_points;
    }

	$final_winner = league::get_team(intval($po_matches[3]->Winner));	

  if($final_winner['Team_ID'] == $po_matches[3]->Player1){
         $final_points = $po_matches[3]->Player1_points.' - '.$po_matches[3]->Player2_points;
	
    }else{
    	 $final_points = $po_matches[3]->Player2_points.' - '.$po_matches[3]->Player1_points;
    }
?>
<section id="login" class="container secondary-page">
<div class="top-score-title right-score col-md-12">
<h3><?php echo $get_bracket['Draw_Title']; ?></h3>
<div class="col-md-12">
<!-- <form method="post" id="myform" action='<?php echo base_url(); ?>league/bracket_save' class="col-md-12 login-page"> 
 -->

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
			<span class="teama"><?=$et_winner['Team_name'];?>
				<a class="show_linematch_score" style="cursor:pointer;font-weight:bold;" id="P2_<?=$po_matches[1]->Tourn_match_id;?>_<?=$po_matches[1]->Player1;?>_<?=$po_matches[1]->Player2;?>"> (<?=$et_points;?>)</a>
			</span>
			<span class="teamc"><?php if($q1_loser){ echo $q1_loser['Team_name']; }?></span>
		</div>
		<div class="bracketbox2 r12">
			<span class="teama"><?=$q1_winner['Team_name'];?> 
			<a class="show_linematch_score" style="cursor:pointer;font-weight:bold;" id="P2_<?=$po_matches[0]->Tourn_match_id;?>_<?=$po_matches[0]->Player1;?>_<?=$po_matches[0]->Player2;?>"> (<?=$q1_points;?>) </a>
              
			</span>
		</div>
   </div>
   <div class="r3"> 
		<div class="bracketbox">
			<span class="teama"><?=$q2_winner['Team_name'];?>
				<?php if($q2_winner){ ?>
                  <a class="show_linematch_score" style="cursor:pointer;font-weight:bold;" id="P2_<?=$po_matches[2]->Tourn_match_id;?>_<?=$po_matches[2]->Player1;?>_<?=$po_matches[2]->Player2;?>"> (<?=$q2_points;?>) 
                  </a>
			    <?php }?>
					
			</span>
		</div>
   </div>
   <div class="r4">
   		<div class="final">
        	<div class="bracketbox">
            	<span class="teamc"><h4 style='color:blue'><?=$final_winner['Team_name'];?></h4>
            	<?php if($final_winner){ ?>
                  <a class="show_linematch_score" style="cursor:pointer;font-weight:bold;" id="P2_<?=$po_matches[3]->Tourn_match_id;?>_<?=$po_matches[3]->Player1;?>_<?=$po_matches[3]->Player2;?>"> (<?=$final_points;?>) 
                  </a>
			    <?php }?>
            	</span>
            </div>
        </div>
   </div>
</div>
</div>
<!-- <input type="hidden" name="po_list"  id="po_list" value='<?php echo serialize($po_list); ?>' />
<input type="hidden" name="po_list2"  id="po_list2" value='<?php echo serialize($po_list2); ?>' />
<input type="hidden" id="tourn_id"  name="tourn_id" value="<?php echo $this->input->post('tourn_id'); ?>" />
<input type='hidden' name='match_type'	value="<?php echo $this->input->post('types'); ?>" />
<input type='hidden' name='age_group'	value="<?php echo $this->input->post('type_gen'); ?>" />
<input type='hidden' name='ttype'		value="<?php echo $this->input->post('ttype'); ?>" />

<input type="submit" class="league-form-submit1" name="po_bracket_confirm" id="po_bracket_confirm" value="Confirm & Save" /> -->

<!-- </form>
 -->
<div id="linematchscorelp2" style="display:none;"> 
<table class='tab-score' id="showlinematchscorelp2">
<!-- Dynamic Lines Data loads from AJAX -->
</table>
</div>
 </div>

</div>
	
</section>