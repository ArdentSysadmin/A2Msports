<section id="login" class="container secondary-page">  

<!-- LOGIN BOX -->
<div class="top-score-title right-score col-md-12">
<h3>Bracket Generation</h3>

<div class="col-md-12 login-page">
<form id="your_form" action="<?php echo base_url(); ?>league/viewbracket/" method="post">


<?php //print_r($tourn_det); ?>
<!-- <div class='form-group'> -->
<label class='control-label col-md-1' for='id_accomodation'> Type of Bracket: </label>
<div class='col-md-4 form-group internal'>

<select class="form-control" name="match_type" id="match_type" style="width:35%" required>
<option value="">Select</option>
<?php
$given_type = "";
if($this->input->post('match_type'))	{
$given_type = $this->input->post('match_type');
}
?>
	<?php
		$types= array();
		$types = json_decode($tourn_det->Singleordouble);
	?>
	<?php foreach($types as $type){ ?>
	<option value="<?php echo $type;?>" <?php if($given_type == $type){ echo "selected=selected"; } ?>><?php echo $type;?></option>
	<?php } ?>
</select>

</div>
<!-- </div> -->

<!-- <div class='form-group'> -->
<label class='control-label col-md-1' for='id_accomodation'> Age Group : </label>
<div class='col-md-4 form-group internal'>

<select class="form-control" id="age_group" name="age_group" style="width:35%" required>
<option value="">Select</option>
<?php
$given_age = "";
if($this->input->post('age_group'))	{
$given_age = $this->input->post('age_group');
}
?>

	<?php
		$ages= array();
		$ages = json_decode($tourn_det->Age);
	?>
	<?php foreach($ages as $age){ ?>
	<option value="<?php echo $age;?>" <?php if($given_age == $age){ echo "selected=selected"; } ?> ><?php echo $age;?></option>
	<?php } ?>
</select>
</div>

<!-- </div> -->
<div class='col-md-2 form-group internal'>
<input type='hidden' name='tourn_id' value="<?php echo $tourn_det->tournament_ID; ?>">
<input type="submit" class="league-form-submit1" name="get_bracket" id="get_bracket" value="Get Bracket" />
<input type="submit" class="league-form-submit1" name="print_bracket" id="print_bracket" value="Print" />
</div>

</form>
<br /><br />
<?php

if(isset($no_bracket)) { ?>
<div class="name" align='left'>

<label for="name_login" style="color:red"><?php echo $no_bracket; ?></label>
</div>
<?php } ?>

<div class="general general-results players">

<div class="brackets" id="brackets">
<?php
if(isset($get_tourn_matches)){
$total_rounds =	$get_bracket['No_of_rounds'];
$list_matches = $get_tourn_matches->result();
?>
<div class="group<?php echo $total_rounds+1; ?>" id="b1">

<?php
for($round = 1; $round <= $total_rounds; $round++) {
?>
<div class="r<?php echo $round; ?>">

<?
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
	}
	if($list_matches[$m]->Player2 != 0){
		 $get_username2 = league::get_username(intval($list_matches[$m]->Player2));
	}
	
	echo $list_matches[$m]->Match_Num; ?>
	</span>
	<span class="teama"><?php if($get_username){ echo $get_username['Firstname']." ".$get_username['Lastname']; } else { echo "----"; }?>
	<?php  echo $list_matches->Player1_Score;
if($list_matches->Player1_Score !=""){

$p1 = json_decode($row->Player1_Score);
$p2 = json_decode($row->Player2_Score);
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
	<span class="teamb"><?php if($list_matches[$m]->Round_Num == 1 and $list_matches[$m]->Player2 != 0)
		{ echo $get_username2['Firstname']." ".$get_username2['Lastname']; } 
	else if($list_matches[$m]->Round_Num != 1 and $list_matches[$m]->Player2 == 0){ echo "---"; }
	else if($get_username2) { echo $get_username2['Firstname']." ".$get_username2['Lastname']; }
	else { echo "Bye"; }
	?></span>
	</div>
<? }
 }
?>
</div>
<?php if(($round) == $total_rounds){ ?>
  <div class="r<?php echo $total_rounds+1; ?>">
   		<div class="final">
        	<div class="bracketbox">
            	<span class="teamc"></span>
            </div>
        </div>
   </div>
<?php } ?>

<?
}
?>
</div>
<?

}

?>

</div>

<!-- <form id="your_form" action="<?php echo base_url(); ?>league/pdf/<?php echo $tourn_id; ?>" method="post">
<input type='hidden' name='users[]' value="<?php print_r($this->input->post('users'));?>">
<input type="submit" class="league-form-submit1" name="capture" id="restore" value="Print" />
</form>
 -->
</div>
</div><!--Close Login-->

</div> 
</section>