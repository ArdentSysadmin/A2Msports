<link href="<?php echo base_url();?>css/minislide/flexslider.css" rel="stylesheet" type="text/css" />
<link href="<?php echo base_url();?>css/component.css" rel="stylesheet" type="text/css" />
<link href="<?php echo base_url();?>css/prettyPhoto.css" rel="stylesheet" type="text/css" />
<link href="<?php echo base_url();?>css/style_dir.css" rel="stylesheet" type="text/css" />

<link href="<?php echo base_url();?>css/responsive.css" rel="stylesheet" type="text/css" />
<link href="<?php echo base_url();?>css/animate.css" rel="stylesheet" type="text/css" />
<link href="<?php echo base_url();?>css/tabs.css" rel="stylesheet" type="text/css" />
<link href="<?php echo base_url(); ?>css/jquery.datepick.css" rel="stylesheet" type="text/css" />
<link href="<?php echo base_url();?>css/jquery.autocomplete.css" rel="stylesheet" type="text/css" />

<link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">

<?php
if($get_bracket['No_of_rounds']){
	$css_num = $get_bracket['No_of_rounds'];
?>
<link rel="stylesheet" href="<?php echo base_url();?>css/grids/grid_<?=$css_num;?>.css">
<?php
}
?>

<?php 
$tour_id = $get_bracket['Tourn_ID'];
$title = league::getonerow($tour_id);
?>
<!-- <div style="padding-left:10px; float:left" class='col-md-4'>
<a href="<?php //echo base_url();?>"><img src="<?php //echo base_url();?>images/logo.png" alt="" ></a>
<br />

</div> -->
<div style='padding-left:180px; padding-top:20px; color:#81a32b' align='center'>
<p style='font-size:20px'><b><?php echo $title->tournament_title." (".$get_bracket['Draw_Title']." - Consolation Draw".")"; ?></b></p>
<!-- <p style='font-size:20px'><b><?php echo $get_bracket['Draw_Title']." - Consolation Draw"; ?></b></p>
 --></div> 

<section id="login" class="container secondary-page">  

<!-- LOGIN BOX -->
<div class="top-score-title right-score col-md-12">
<!-- <h3><?php echo $title->tournament_title; ?></h3> -->
<div class="col-md-12">
<div class="general water-mark">
<div class="brackets" id="brackets">


<!-- ---------------------------------------------- Consolation ---------------------- -->
<?php  
if(isset($get_cd_tourn_matches)){

$total_rounds =	intval($get_cd_num_rounds['total_rounds']);
$bracket_id = $get_bracket['BracketID'];
$tour_id = $get_bracket['Tourn_ID'];

$list_matches = $get_cd_tourn_matches->result();
?>
<div class="group<?php echo $total_rounds+1; ?>" id="b1">

<?php
$nm = 0;
$round_type = array();
for($round = 1; $round <= $total_rounds; $round++) {
	foreach($list_matches as $m => $match){
		if($list_matches[$m]->Round_Num==$round){
			$nm++;
		}
	}
	$round_type[$round] = $nm;
	$nm = 0;
}

for($round = 1; $round <= $total_rounds; $round++) {
?>
<div class="r<?php echo $round; ?>">
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
	
	echo $list_matches[$m]->Match_Num; ?>
	<br />
	<?php if($list_matches[$m]->Match_DueDate != "") { echo date("m-d-Y",strtotime($list_matches[$m]->Match_DueDate)); }?>
	</span>
	<span class="teama" style="font-size:14px;"><b><?php
		if($get_username){ 
			echo $get_username['Firstname']." ".$get_username['Lastname'];

				if($get_partner_username){
					echo " - ".$get_partner_username['Firstname']." ".$get_partner_username['Lastname']; 
				}
		} 
		else {
			//echo "----"; 
			if($list_matches[$m]->Player1_source && $round == 1){ $src = "Looser of Match - ".$list_matches[$m]->Player1_source; } 
			else if($list_matches[$m]->Player1_source && $round > 1) { $src = "---"; }
			else { $src = "Bye"; }

			echo $src;
		}
	?>

	<?php if($list_matches[$m]->Round_Num != 1){

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
	</b></span>
	<span class='team2'>&nbsp
	</span>
	<span class="teamb" style="font-size:14px;"><b>
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
	
	<?php
		if($list_matches[$m]->Round_Num == 1 and $list_matches[$m]->Player2 != 0)
		{ 
		echo $get_username2['Firstname']." ".$get_username2['Lastname']; 
			if($get_partner_username2){
				echo " - ".$get_partner_username2['Firstname']." ".$get_partner_username2['Lastname']; 
			}
		}
		else if($list_matches[$m]->Round_Num != 1 and $list_matches[$m]->Player2 == 0){ echo "---"; }
		else if($get_username2) { 
			echo $get_username2['Firstname']." ".$get_username2['Lastname']; 
				if($get_partner_username2){
					echo " - ".$get_partner_username2['Firstname']." ".$get_partner_username2['Lastname']; 
				}
		}
		else {
			//echo "Bye"; 
				if($list_matches[$m]->Player2_source && $round == 1){ $src = "Looser of Match - ".$list_matches[$m]->Player2_source; } 
				else if($list_matches[$m]->Player2_source && $round > 1) { $src = "---"; }
				else { $src = "Bye"; }

				echo $src;
			}
	?>

		
	</b></span>
	</div>
<? }
 }
?>
</div>
<?php if(($round) == $total_rounds){ ?>
  <div class="r<?php echo $total_rounds+1; ?>">
   		<div class="final">
        	<div class="bracketbox">
            	<span class="teamc" style="font-size:14px;"><b>
				<?php if($list_matches[$m]->Winner != 0){
				 $get_username = league::get_username(intval($list_matches[$m]->Winner));
				 ($list_matches[$m]->Winner == $list_matches[$m]->Player1) ? 
					 $partner = $list_matches[$m]->Player1_Partner : $partner = $list_matches[$m]->Player2_Partner;
				 $get_partner_name = league::get_username(intval($partner));

				 echo "<h4 style='color:#f59123'><b>".$get_username['Firstname']." ".$get_username['Lastname'];
				 	 if($partner) { echo " - ".$get_partner_name['Firstname']." ".$get_partner_name['Lastname']; }
				 echo "</b></h4>";

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

				</b></span>
            </div>
        </div>
   </div>
<?php } ?>

<?
}
?>
</div>
<?php
}
?>
</div>
<!-- <form id="your_form" action="<?php echo base_url(); ?>league/pdf/<?php echo $tourn_id; ?>" method="post">
<input type='hidden' name='users[]' value="<?php print_r($this->input->post('users'));?>">
<input type="submit" class="league-form-submit1" name="capture" id="restore" value="Print" />
</form>
 -->

</div>
</div>
<!--Close Login-->

</div>
</section>