<link href="<?php echo base_url();?>css/foundation-datepicker.css" rel="stylesheet">
<script src="<?php echo base_url();?>js/foundation-datepicker.js"></script>

<script>
$(document).ready(function(){

var baseurl = "<?php echo base_url();?>";

$('#update_draw').click(function (e) {

	  $.ajax({
		type: 'POST',
		url: baseurl+'league/view_matches',
		data: $('#frm_upd_dates').serialize(),
		success: function() {
		  location.reload();
		}
	  });
	  e.preventDefault();

	});
});
</script>

<form method = "post" id = "frm_upd_dates" class = "login-form">
<script language="javascript" type="text/javascript">
function myWin(tid)
{
var path = "<?php echo base_url(); ?>";
var tid = '<?php echo $bracket_id; ?>';
window.open(path+'league/pdf/'+tid,null,"height=1200,width=1400,status=yes,toolbar=no,menubar=no,location=no");
}
</script>

<input type="button" class="league-form-submit1" name="capture" id="capture" value="Print" style="float:right;" onclick="myWin(<?=$bracket_id;?>)" />
<input type="hidden" name="update_draw_status" id="update_draw_status" value="2" />

<?php

//$list_matches = $get_cd_tourn_matches->result();

$total_rounds	= $get_bracket['No_of_rounds'];
$bracket_id		= $get_bracket['BracketID'];
$tour_id		= $get_bracket['Tourn_ID'];

$list_matches	= $get_tourn_matches->result();
?>
<div>
<h4 style="color:#f59123"><b><?php echo $get_bracket['Draw_Title']; ?></b></h4>
</div>

<div class = "brackets" id="brackets">
<div class="group<?php echo $total_rounds+1; ?>" id="b1">
<input type='hidden' name='bracket_id' value="<?php echo $get_bracket['BracketID']; ?>" />
<input type='hidden' name='tour_id'	value="<?php echo $get_bracket['Tourn_ID']; ?>" />

<?php
$nm = 0;
$round_type = array();
for($round = 1; $round <= $total_rounds; $round++) {
	foreach($list_matches as $m => $match){
		if($list_matches[$m]->Round_Num==$round){
			$round_dates[$round] = $list_matches[$m]->Match_DueDate;
			$nm++;
		}
	}
	$round_type[$round] = $nm;
	$nm = 0;
}

for($round = 1; $round <= $total_rounds; $round++) {
?>
<script>/*
$(function() {
 var rid = "<?php echo $round; ?>";
 $('#sdate_round'+rid).datepick();
});*/
</script>
<div class="r<?php echo $round; ?>">
<input type='hidden' name='round[]' value="<?php echo $round; ?>" />

<br>
<span style="text-align: center"><b>
<?php
	$rt = $round_type[$round];
if($rt >= pow(2,3)){
	$rrt = $rt*2;
	echo "Round of $rrt";
	}
else
	{
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
<?php
if($tour_details->Usersid == $this->logged_user){
?>

<input type = "text" placeholder = "Date" id = "sdate_round<?php echo $round; ?>" name = "round_date<?php echo $round; ?>" value = "<?php if($round_dates[$round] != "")
{ echo date('m/d/Y H:i', strtotime($round_dates[$round])); } ?>" />

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
} else {
	if($round_dates[$round] != "") { echo date("m-d-Y H:i",strtotime($round_dates[$round])); }
}
//	print_r($list_matches);exit;
foreach($list_matches as $m => $match){
$get_username = "";
$get_username2 = "";

	if($list_matches[$m]->Round_Num==$round){
	?>
	<div class="bracketbox">
	<span class="info"><?php
	if($list_matches[$m]->Player1 != 0){
		 $get_username = league::get_username(intval($list_matches[$m]->Player1));
		 $get_partner_username = league::get_username(intval($list_matches[$m]->Player1_Partner));
	}
	if($list_matches[$m]->Player2 != 0){
		 $get_username2 = league::get_username(intval($list_matches[$m]->Player2));
		 $get_partner_username2 = league::get_username(intval($list_matches[$m]->Player2_Partner));
	}
	
	$match_num = $list_matches[$m]->Match_Num;
	echo $match_num;
if($tour_details->Usersid == $this->logged_user){
?>
<input type="hidden" placeholder="Date" id="sdate<?php echo $match_num; ?>" name="match_date<?php echo $match_num; ?>" 
value = "<?php if($list_matches[$m]->Match_DueDate != "")
{ echo date('m/d/Y H:i', strtotime($list_matches[$m]->Match_DueDate)); } ?>" />

<script>
var rid = "<?php echo $match_num; ?>";

  $('#sdate'+rid).fdatepicker({
		format: 'mm/dd/yyyy hh:ii',
		disableDblClickSelection: true,
		language: 'en',
		pickTime: true
	});
</script>

<script>
/*$(function() {
 var spid = "<?php echo $match_num; ?>";
 $('#sdate'+spid).datepick();
});*/
</script>
<?php
} else {
	if($list_matches[$m]->Match_DueDate != "") { echo date("m-d-Y H:i",strtotime($list_matches[$m]->Match_DueDate)); }
}
?>
<br />
	<input type='hidden' name='match_num[<?php echo $round; ?>][]' value="<?php echo $match_num; ?>" />
	<input type='hidden' name='draw[]' value="<?php echo $list_matches[$m]->Draw_Type; ?>" />
	</span>
	<span class="teama"><?php
		if($get_username){ 
		echo "<a href='".base_url()."player/".$get_username['Users_ID']."'>".$get_username['Firstname']." ".$get_username['Lastname']."</a>";

			if($get_partner_username){
				echo " - <a href='".base_url()."player/".$get_partner_username['Users_ID']."'>".$get_partner_username['Firstname']." ".$get_partner_username['Lastname']."</a>"; 
			}
		} else { echo "----"; }?>

<?php
if($list_matches[$m]->Round_Num != 1){

		$get_source_scores1 = league::get_match_scores_player1($list_matches[$m]->Player1_source,$bracket_id,$tour_id,$list_matches[$m]->Draw_Type);

		if($get_source_scores1['Player1_Score'] !="" && $get_source_scores1['Player1_Score'] !="Bye Match"){

		$p1 = json_decode($get_source_scores1['Player1_Score']);
		$p2 = json_decode($get_source_scores1['Player2_Score']);
			if(count(array_filter($p1))>0)
			{
				for($i=0; $i<count(array_filter($p1)); $i++)
				{
					echo "($p1[$i] - $p2[$i]) ";
				}
			}
		}
	}
?>
	
	</span>
	<span class='team2'>&nbsp
	</span>
	<span class="teamb">
	<?php if($list_matches[$m]->Round_Num != 1){

		$get_source_scores2 = league::get_match_scores_player2($list_matches[$m]->Player2_source,$bracket_id,$tour_id,$list_matches[$m]->Draw_Type);

		if($get_source_scores2['Player1_Score'] !=""){
			$p1 = json_decode($get_source_scores2['Player1_Score']);
			$p2 = json_decode($get_source_scores2['Player2_Score']);

				if(count(array_filter($p1))>0)
				{
					for($i=0; $i<count(array_filter($p1)); $i++)
					{
						echo "($p1[$i] - $p2[$i]) ";
					}
				}

			} 
		}
		echo "<br>";
		?>
	
	<?php if($list_matches[$m]->Round_Num == 1 and $list_matches[$m]->Player2 != 0)
		{ 
		echo "<a href='".base_url()."player/".$get_username2['Users_ID']."'>".$get_username2['Firstname']." ".$get_username2['Lastname']."</a>"; 
			if($get_partner_username2){
				echo " - <a href='".base_url()."player/".$get_partner_username2['Users_ID']."'>".$get_partner_username2['Firstname']." ".$get_partner_username2['Lastname']."</a>"; 
			}
		}
	else if($list_matches[$m]->Round_Num != 1 and $list_matches[$m]->Player2 == 0){ echo "---"; }
	else if($get_username2) { 
		echo "<a href='".base_url()."player/".$get_username2['Users_ID']."'>".$get_username2['Firstname']." ".$get_username2['Lastname']."</a>"; 
			if($get_partner_username2){
				echo " - <a href='".base_url()."player/".$get_partner_username2['Users_ID']."'>".$get_partner_username2['Firstname']." ".$get_partner_username2['Lastname']."</a>"; 
			}
	}
	else { echo "Bye"; }
	?>

	</span>
	</div>
<? }
 }
?>
</div>
<?php if(($round) == $total_rounds){ ?>
  <div class="r<?php echo $total_rounds+1; ?>">
   		<div class="final">
        	<div class="bracketbox">
            	<span class="teamc">
				<?php if($list_matches[$m]->Winner != 0){
				 $get_username = league::get_username(intval($list_matches[$m]->Winner));
				 ($list_matches[$m]->Winner == $list_matches[$m]->Player1) ? 
					 $partner = $list_matches[$m]->Player1_Partner : $partner = $list_matches[$m]->Player2_Partner;
				 $get_partner_name = league::get_username(intval($partner));

				 echo "<h5 style='color:#f59123'><b>"."<a href='".base_url()."player/".$get_username['Users_ID']."'>".$get_username['Firstname']." ".$get_username['Lastname']."</a>";
				 	 if($partner) { echo " - <a href='".base_url()."player/".$get_partner_name['Users_ID']."'>".$get_partner_name['Firstname']." ".$get_partner_name['Lastname']."</a>"; }
				 echo "</b></h5>";

					if($list_matches[$m]->Player1_Score !="" && $list_matches[$m]->Winner == $list_matches[$m]->Player1){
					$p1 = json_decode($list_matches[$m]->Player1_Score);
					$p2 = json_decode($list_matches[$m]->Player2_Score);
					} 
					else if($list_matches[$m]->Player2_Score !="" && $list_matches[$m]->Winner == $list_matches[$m]->Player2){
					$p1 = json_decode($list_matches[$m]->Player2_Score);
					$p2 = json_decode($list_matches[$m]->Player1_Score);
					}
						
						if(count(array_filter($p1))>0)
						{
							for($i=0; $i<count(array_filter($p1)); $i++)
							{
							echo "($p1[$i] - $p2[$i]) ";
							}
						}
					}
				
				?>
				</span>
            </div>
        </div>
   </div>
<?php } ?>

<?
}
?>
</div>
<div><h4>Consolation Draw</h4></div>
<br>
<?php

 //----------------------------- Consolation Draw ---------------------------------------

$total_rounds	= intval($get_cd_num_rounds['total_rounds']);
$bracket_id		= $get_bracket['BracketID'];
$tour_id		= $get_bracket['Tourn_ID'];

$list_matches	= $get_cd_tourn_matches->result();
?>
<div class="group<?php echo $total_rounds+1; ?>" id="b1">

<?php
$nm = 0;
$round_type = array();
for($round = 1; $round <= $total_rounds; $round++) {
	foreach($list_matches as $m => $match){
		if($list_matches[$m]->Round_Num==$round){
			$cround_dates[$round] = $list_matches[$m]->Match_DueDate;
			$nm++;
		}
	}
	$round_type[$round] = $nm;
	$nm = 0;
}

for($round = 1; $round <= $total_rounds; $round++) {
?>
<script>/*
$(function() {
 var rid = "<?php echo $round; ?>";
 $('#cdate_round'+rid).datepick();
});*/
</script>
<div class="r<?php echo $round; ?>">
<input type='hidden' name='cround[]' value="<?php echo $round; ?>" />

<br>
<span style="text-align: center"><b>
<?php
	$rt = $round_type[$round];
if($rt >= pow(2,3)){
	$rrt = $rt*2;
	echo "Round of $rrt";
	}
else
	{
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
<?php
if($tour_details->Usersid == $this->logged_user){
?>

<input type = "text" placeholder = "Date" id = "cdate_round<?php echo $round; ?>" name = "cround_date<?php echo $round; ?>" value = "<?php if($cround_dates[$round] != "")
{ echo date('m/d/Y H:i', strtotime($cround_dates[$round])); } ?>" />

<script>
var rid = "<?php echo $round; ?>";

  $('#cdate_round'+rid).fdatepicker({
		format: 'mm/dd/yyyy hh:ii',
		disableDblClickSelection: true,
		language: 'en',
		pickTime: true
	});
</script>

<?php
} else {
	if($cround_dates[$round] != "") { echo date("m-d-Y H:i", strtotime($cround_dates[$round])); }
}
//	print_r($list_matches);exit;
foreach($list_matches as $m => $match){
$get_username = "";
$get_username2 = "";

	if($list_matches[$m]->Round_Num==$round){
	?>
	<div class="bracketbox">
	<span class="info"><?php
	if($list_matches[$m]->Player1 != 0){
		 $get_username = league::get_username(intval($list_matches[$m]->Player1));
		 $get_partner_username = league::get_username(intval($list_matches[$m]->Player1_Partner));
	}
	
	if($list_matches[$m]->Player2 != 0){
		 $get_username2 = league::get_username(intval($list_matches[$m]->Player2));
		 $get_partner_username2 = league::get_username(intval($list_matches[$m]->Player2_Partner));
	}
	
	$match_num = $list_matches[$m]->Match_Num;
	echo $match_num;

	if($tour_details->Usersid == $this->logged_user){
	?>
	<input type="hidden" placeholder="Date" id="csdate<?php echo $match_num; ?>" name="cons_match_date<?php echo $match_num; ?>" 
	value = "<?php if($list_matches[$m]->Match_DueDate != "")
	{ echo date('m/d/Y H:i', strtotime($list_matches[$m]->Match_DueDate)); } ?>" />

	<script>
	var rid = "<?php echo $match_num; ?>";

	  $('#csdate'+rid).fdatepicker({
			format: 'mm/dd/yyyy hh:ii',
			disableDblClickSelection: true,
			language: 'en',
			pickTime: true
		});
	</script>

	<script>/*
	$(function() {
	 var spid = "<?php echo $match_num; ?>";
	 $('#csdate'+spid).datepick();
	});*/
	</script>

	<?php
	} else {
		if($list_matches[$m]->Match_DueDate != "") { echo date("m-d-Y H:i",strtotime($list_matches[$m]->Match_DueDate)); }
	}
	?>
	<br />
	<input type='hidden' name='cmatch_num[<?php echo $round; ?>][]' value="<?php echo $match_num; ?>" />
	<input type='hidden' name='cdraw[]' value="<?php echo $list_matches[$m]->Draw_Type; ?>" />
	</span>
	<span class="teama"><?php
		if($get_username){ 
			echo "<a href='".base_url()."player/".$get_username['Users_ID']."'>".$get_username['Firstname']." ".$get_username['Lastname']."</a>";

				if($get_partner_username){
					echo " - <a href='".base_url()."player/".$get_partner_username['Users_ID']."'>".$get_partner_username['Firstname']." ".$get_partner_username['Lastname']."</a>"; 
				}
		} 
		else {
			//echo "----"; 
			if($list_matches[$m]->Player1_source AND $round == 1 AND $list_matches[$m]->Player1_Score != "Canceled Match" AND $list_matches[$m]->Player1 != "-1"){ $src = "Looser of Match - ".$list_matches[$m]->Player1_source; }
			else if($list_matches[$m]->Player1_Score == "Canceled Match" OR $list_matches[$m]->Player1 == "-1") { $src = "Bye"; }
			else if($list_matches[$m]->Player1_source AND $round > 1) { $src = "---"; }
			else { $src = "Bye"; }

			echo $src;
		}
	?>

	<?php if($list_matches[$m]->Round_Num != 1 AND $list_matches[$m]->Draw_Type == "Consolation"){

		$get_source_scores1 = league::get_match_scores_player1($list_matches[$m]->Player1_source,$bracket_id,$tour_id,$list_matches[$m]->Draw_Type);

		if($get_source_scores1['Player1_Score'] != "" AND $get_source_scores1['Player1_Score'] != "Bye Match" AND $get_source_scores1['Player1_Score'] != "Canceled Match"){

		$p1 = json_decode($get_source_scores1['Player1_Score']);
		$p2 = json_decode($get_source_scores1['Player2_Score']);
			if(count(array_filter($p1))>0)
			{
				for($i=0; $i<count(array_filter($p1)); $i++)
				{
					echo "($p1[$i] - $p2[$i]) ";
				}
			}
		}
		else if($get_source_scores1['Player1_Score'] == "Canceled Match")
		{
					echo "Match Canceled";

		}
	}
	?>
	</span>
	<span class='team2'>&nbsp;</span>
	<span class="teamb">
	<?php if($list_matches[$m]->Round_Num != 1 and $list_matches[$m]->Draw_Type == "Consolation"){

		$get_source_scores2 = league::get_match_scores_player2($list_matches[$m]->Player2_source,$bracket_id,$tour_id,$list_matches[$m]->Draw_Type);

		if($get_source_scores2['Player1_Score'] !=""){
			$p1 = json_decode($get_source_scores2['Player1_Score']);
			$p2 = json_decode($get_source_scores2['Player2_Score']);

				if(count(array_filter($p1))>0)
				{
					for($i=0; $i<count(array_filter($p1)); $i++)
					{
						echo "($p1[$i] - $p2[$i]) ";
					}
				}
			} 
		}
		echo "<br>";
		?>
	
	<?php
		if($list_matches[$m]->Round_Num == 1 and $list_matches[$m]->Player2 != 0)
		{ 
		echo "<a href='".base_url()."player/".$get_username2['Users_ID']."'>".$get_username2['Firstname']." ".$get_username2['Lastname']."</a>"; 
			if($get_partner_username2){
				echo " - <a href='".base_url()."player/".$get_partner_username2['Users_ID']."'>".$get_partner_username2['Firstname']." ".$get_partner_username2['Lastname']."</a>"; 
			}
		}
		else if($list_matches[$m]->Round_Num != 1 and $list_matches[$m]->Player2 == 0){ echo "---"; }
		else if($get_username2) { 
			echo "<a href='".base_url()."player/".$get_username2['Users_ID']."'>".$get_username2['Firstname']." ".$get_username2['Lastname']."</a>"; 
				if($get_partner_username2){
					echo " - <a href='".base_url()."player/".$get_partner_username2['Users_ID']."'>".$get_partner_username2['Firstname']." ".$get_partner_username2['Lastname']."</a>"; 
				}
		}
		else {
			//echo "Bye"; 
				if($list_matches[$m]->Player2_source and $round == 1 AND $list_matches[$m]->Player2_Score != "Canceled Match" AND $list_matches[$m]->Player2 != "-1"){ $src = "Looser of Match - ".$list_matches[$m]->Player2_source; }
				else if($list_matches[$m]->Player2_Score == "Canceled Match" OR $list_matches[$m]->Player2 == "-1") { $src = "Bye"; }
				else if($list_matches[$m]->Player2_source AND $round > 1) { $src = "---"; }
				else { $src = "Bye"; }

				echo $src;
			}
	?>

		
	</span>
	</div>
<? }
 }
?>
</div>
<?php if(($round) == $total_rounds){ ?>
  <div class="r<?php echo $total_rounds+1; ?>">
   		<div class="final">
        	<div class="bracketbox">
            	<span class="teamc">
				<?php if($list_matches[$m]->Winner != 0){
				 $get_username = league::get_username(intval($list_matches[$m]->Winner));
				 ($list_matches[$m]->Winner == $list_matches[$m]->Player1) ? 
					 $partner = $list_matches[$m]->Player1_Partner : $partner = $list_matches[$m]->Player2_Partner;
				 $get_partner_name = league::get_username(intval($partner));

				 echo "<h5 style='color:#f59123'><b><a href='".base_url()."player/".$get_username['Users_ID']."'>".$get_username['Firstname']." ".$get_username['Lastname']."</a>";
				 	 if($partner) { echo " - <a href='".base_url()."player/".$get_partner_name['Users_ID']."'>".$get_partner_name['Firstname']." ".$get_partner_name['Lastname']."</a>"; }
				 echo "</b></h5>";

					if($list_matches[$m]->Player1_Score !="" and $list_matches[$m]->Winner == $list_matches[$m]->Player1){
					$p1 = json_decode($list_matches[$m]->Player1_Score);
					$p2 = json_decode($list_matches[$m]->Player2_Score);
					} 
					else if($list_matches[$m]->Player2_Score !="" and $list_matches[$m]->Winner == $list_matches[$m]->Player2){
					$p1 = json_decode($list_matches[$m]->Player2_Score);
					$p2 = json_decode($list_matches[$m]->Player1_Score);
					}
						
						if(count(array_filter($p1))>0)
						{
							for($i=0; $i<count(array_filter($p1)); $i++)
							{
							echo "($p1[$i] - $p2[$i]) ";
							}
						}
					}
				
				?>

				</span>
            </div>
        </div>
   </div>
<?php } ?>

<?
}
?>
<input type="submit" class="league-form-submit1" name="update_draw" id="update_draw" value=" Update " />
</div>
</div>
</form>