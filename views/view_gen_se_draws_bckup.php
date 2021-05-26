<?php 
/*echo "test";
exit;*/
$num_teams = $num_of_teams;
$pow_vals = array(2,4,8,16,32,64,128,256,512);

$log_val = ceil(log($num_teams, 2));
((in_array($log_val, $pow_vals)) or (in_array($num_teams, $pow_vals))) ? $total_rounds = $log_val : $total_rounds =  floor(log($num_teams, 2)) + 1;

$match_num = 1;
?>
<!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.5.3/jspdf.min.js"></script> -->
<script src="https://docraptor.com/docraptor-1.0.0.js"></script>
<link rel="stylesheet" href="<?php echo base_url();?>css/grids/grid_<?=$total_rounds;?>.css">
<link rel="stylesheet" href="<?php echo base_url();?>css/grids/grid_<?=$total_rounds;?>.css">
<link href="<?php echo base_url();?>css/foundation-datepicker.css" rel="stylesheet">
<script src="<?php echo base_url();?>js/foundation-datepicker.js"></script>
<!-- <script src="<?php echo base_url();?>js/printThis.js"></script> -->

<script>
$(document).ready(function(){
var baseurl = "<?php echo base_url();?>";

	$('#print_frm').click(function() {
		var temp = $('#temp').val();
		//var newWindow = window.open("", "_blank");

	 	 $.ajax({
			type: "POST",
			async:false,
			url:baseurl+'league/print_gen_se_draws/',
			data:{temp:temp},
			dataType: "html",
			success: function(res){
			/*	var myBlob;
				var doc = new jsPDF();
				doc.fromHTML(res, 15, 15, {
					'width': 200
				});
				myBlob = doc.save('blob');
				var w = window.open('about:blank');
				w.document.open();
				w.document.write(res);
				w.document.close();*/

				DocRaptor.createAndDownloadDoc("YOUR_API_KEY_HERE", {
				test: true,													// test documents are free, but watermarked
				type: "pdf",
				document_content: res,									     // or supply HTML directly
		 //     document_content: document.querySelector('html').innerHTML, // use this page's HTML
		 //     document_url: "http://example.com/your-page",              // or use a URL
		 //     javascript: true,                                         // enable JavaScript processing
		 //     prince_options: {
		 //     media: "screen",                                        // use screen styles instead of print styles
		 //    }
				})
		   }
		}); 
	});
});
</script>

<section id="login" class="container secondary-page">  
<div class="general general-results players view-brack1" style="width: 74%; height: 100%; overflow-x: scroll;">

<!-- LOGIN BOX -->
<div class="top-score-title right-score col-md-12" id='bracket_result'>
<h3>Bracket Generation</h3>
<div class="col-md-12 login-page">
<!-- <form method="post" id="myform" action='' class="login-form" style="width:100%;"> -->

<!-- <label>Draw Title*</label>&nbsp;&nbsp;<span id="title_error" style="color:red"></span> -->
<!-- <input class="form-control" type="text" name="draw_title" id="draw_title" style="width:40%;" required /> -->

<div class="col-md-9"><h3 style="margin-bottom:30px; margin-top:0px;text-align:left;"><?=$tour_name;?></h3></div>
<div class="col-md-3" style='text-align:right;'>
<input type="hidden" name="temp" id="temp" value='<?=$temp;?>' />
<button type="button" id='print_frm'>Print Form</button>

</div>

<br />

<div class="brackets" id="brackets">

<div class="group<?php echo $total_rounds+1; ?>" id="b1">
<?php
for($round = 1, $source=1 ; $round <= $total_rounds; $round++) {
?>
<div class="r<?php echo $round; ?>" style="text-align:center">

<script>/*
$(function() {
 var rid = "<?php echo $round; ?>";
 $('#sdate_round'+rid).datepick();
});*/
</script>

<input type='hidden' name='round[]' value="<?php echo $round; ?>" />
<br>
<span style="text-align: center">
<b>
<?php
$process_res = league::cal_c($pow_vals, $num_teams, $teams, $round);
$teams		 = array();
$rt			 = $process_res[1] + $process_res[2];

if($rt >= pow(2,3)) {
	$rrt = $rt*2;
	echo "Round of $rrt";
}
else {
	switch($rt)	{
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
<!-- <input type="text" placeholder="Date" name="round_date<?php echo $round; ?>" id="sdate_round<?php echo $round; ?>" value="" /> -->

<script>
var rid = "<?php echo $round; ?>";

  $('#sdate_round'+rid).fdatepicker({
		format: 'mm/dd/yyyy hh:ii',
		disableDblClickSelection: true,
		language: 'en',
		pickTime: true
	});
</script>
<?php
$x=0;
foreach($process_res[6] as $ab => $game_pl){

/*echo "<pre>";
print_r($game_pl);*/
$y = 1;
	$player1 = explode(";", $process_res[6][$ab][0]);
	$player2 = explode(";", $process_res[6][$ab][1]);
	
$output =  "<span class='teama'>";
	if(!strpos($player1[0], ')') and $player1[0] != '---') {
		$output .= $player1[0]; 
	}
	else { 
		$output .= ""; 
	}

	if($player1[1]) {
		$output .= " - ".$player1[1];
	}
$output .= "</span>";

$output .=  "<span class='teamb'>";
	if($player2[0] != '---') {
		if(!strpos($player2[0], ')')){
			$output .= $player2[0];
		}
		else {
			$output .= "";
		}
	}
	else { 
		($round == 1) ? $mn = "Bye" : $mn = "";
		$output .= $mn; 
	}
	/*if($player2[0] and $player2[1]){ $output .= " - ".$player2[1]; }*/
$output .= "</span>";
?>

<div class="bracketbox">
<span class="info"><?php echo $match_num; ?>
<!-- <input type="text" placeholder="Date" id="sdate<?php echo $match_num; ?>" name="match_date<?php echo $match_num; ?>" value="" /> -->

<script>
var rid = "<?php echo $match_num; ?>";

$('#sdate'+rid).fdatepicker({
		format: 'mm/dd/yyyy hh:ii',
		disableDblClickSelection: true,
		language: 'en',
		pickTime: true
});
</script>

</span>
<?php
echo $output;
?>
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

<!-- 
<input type="hidden" id="tourn_id"  name="tourn_id" value="<?php echo $this->input->post('tourn_id'); ?>" />
<input type='hidden' name='match_type'	  value="<?php echo $this->input->post('types'); ?>" />
<input type='hidden' name='filter_events' value='<?php if($filter_events != '' and $filter_events != 'null') { echo $filter_events; } 
else if($sport_level != '' and $sport_level != 'null'){ echo $sport_level; } ?>' />
<input type='hidden' name='age_group'	  value="<?php echo $this->input->post('type_gen'); ?>" />
<input type='hidden' name='ttype'		  value="<?php echo $ttype; ?>" /> 
-->
<div style='clear:both;'></div>
<!-- <div><input type="submit" class="league-form-submit1" name="bracket_confirm" id="bracket_confirm" value="Confirm & Save" /></div> -->
</div>
</form>

<!--
<form id="your_form" action="<?php //echo base_url(); ?>league/pdf/<?php //echo $tourn_id; ?>" method="post">
<input type='hidden' name='users[]' value="<?php //print_r($this->input->post('users'));?>">
<input type="submit" class="league-form-submit1" name="capture" id="restore" value="Print" />
</form>
-->

</div>
</div><!--Close Login-->

</div> 
</section>
<script>

$('html, body').animate({
scrollTop: ($('#bracket_result').offset().top)
}, 500);

</script>