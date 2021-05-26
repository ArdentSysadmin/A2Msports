<div id='MembersLoc'>
<div class="fromtitle">Search for Players & Rankings</div>
<?php $sport_segment = end($this->uri->segment_array()); ?>
<form method="post" id="myform"  action="<?php echo base_url();?><?php echo $sport_segment;?>?p=rankings"> 

<!-- <div class='col-md-4 form-group internal' style="padding-left:0px">
	<input class='form-control' id='name' name='name' type='text' placeholder="Player Name" value="<?php echo $search_uname; ?>"  size="25" />
</div> -->

<div class='col-md-4 form-group internal' style="padding-left:0px">  
    <select class='form-control' id='country' name='country'>
		<option value="">Select Country</option>
	<?php
	foreach($countries as $cntry){
		if($cntry->Country == $country){
            echo "<option value='$cntry->Country' selected>$cntry->Country</option>";
		}
		else{
			 echo "<option value='$cntry->Country'>$cntry->Country</option>";
		}
	}
	?>
    </select>	
</div>

<!-- <div class='col-md-3 form-group internal' style="padding-left:0px" id="usa_state_drop">
	<select name="state" id="usa_state" class='form-control' onChange="stateChange();">
	<option value="">Select</option>
	<?php
	$states = array('Alabama','Alaska','Arizona','Arkansas','California','Colorado','Connecticut','Delaware','District of Columbia','Florida','Georgia',
	'Hawaii','Idaho','Illinois','Indiana','Iowa','Kansas','Kentucky','Louisiana','Maine','Maryland','Massachusetts','Michigan','Minnesota','Mississippi',
	'Missouri','Montana','Nebraska','Nevada','New Hampshire','New Jersey','New Mexico','New York','North Carolina','North Dakota','Ohio','Oklahoma', 'Oregon','Pennsylvania','Rhode Island','South Carolina','South Dakota','Tennessee','Texas','Utah','Vermont','Virginia','Washington','West Virginia',
	'Wisconsin','Wyoming'); 
	
	foreach($states as $stat)
	{
		if($stat == $state){
            echo "<option value='$stat' selected>$stat</option>";
		}else{
			echo "<option value='$stat'>$stat</option>";
		}
		
	}
	?>
	</select>
</div>

<div class='col-md-3 form-group internal' style="padding-left:0px;display:none;" id="india_state_drop">
	<select name="state" id="india_state" class='form-control' onChange="stateChange();">
	<option value="">Select</option>
	<?php
	 $states = array('Andhra Pradesh','Arunachal Pradesh','Assam','Bihar','Chhattisgarh','Goa','Gujarat','Haryana','Himachal Pradesh','Jammu and Kashmir','Jharkhand','Karnataka','Kerala','Madhya Pradesh','Maharashtra','Manipur','Meghalaya','Mizoram','Nagaland','Odisha','Punjab','Rajasthan','Sikkim','Tamil Nadu','Telangana','Tripura','Uttar Pradesh','Uttarakhand','West Bengal');
	foreach($states as $stat)
	{
		if($stat == $state){
            echo "<option value='$stat' selected>$stat</option>";
		}else{
			echo "<option value='$stat'>$stat</option>";
		}
		
	}
	?>
	</select>
</div>

  -->
<!-- <div class='col-md-2 form-group internal' style="display:none;" id='state_box'>
	<input class='form-control' id='state1' name='state1' type='text' value="<?php if($state1!=""){echo $state1;}?>" placeholder="State"  size="45">
</div> -->
<div class='col-md-4 form-group internal' id="states_div" style="padding-left: 0px;">
<?php 
if($this->input->post('search_mem_loc')){
	if($this->input->post('country')=='United States of America'){
         $states = array('Alabama','Alaska','Arizona','Arkansas','California','Colorado','Connecticut','Delaware','District of Columbia','Florida','Georgia',
	'Hawaii','Idaho','Illinois','Indiana','Iowa','Kansas','Kentucky','Louisiana','Maine','Maryland','Massachusetts','Michigan','Minnesota','Mississippi',
	'Missouri','Montana','Nebraska','Nevada','New Hampshire','New Jersey','New Mexico','New York','North Carolina','North Dakota','Ohio','Oklahoma', 'Oregon','Pennsylvania','Rhode Island','South Carolina','South Dakota','Tennessee','Texas','Utah','Vermont','Virginia','Washington','West Virginia',
	'Wisconsin','Wyoming'); 
	}else if($this->input->post('country')=='India'){
        $states = array('Andhra Pradesh','Arunachal Pradesh','Assam','Bihar','Chhattisgarh','Goa','Gujarat','Haryana','Himachal Pradesh','Jammu and Kashmir','Jharkhand','Karnataka','Kerala','Madhya Pradesh','Maharashtra','Manipur','Meghalaya','Mizoram','Nagaland','Odisha','Punjab','Rajasthan','Sikkim','Tamil Nadu','Telangana','Tripura','Uttar Pradesh','Uttarakhand','West Bengal');
	}

}else{
	 $states = array();
}
?>
<input class='form-control' list="states" name="state" value="<?php  if($state){echo $state;}else{echo '';}?>" placeholder="State" />
<datalist id="states">
<?php foreach ($states as $key => $stat) {
	if($stat == $state){
        echo '<option value="'.$stat.'" selected>';
	}else{
		echo '<option value="'.$stat.'">';
	}
	
} ?> 
</datalist>
</div>

<div class='col-md-4 form-group internal' style="padding-left:0px">
	<select name="gender" id="gender" class='form-control' >
	<option value="">Select Gender</option>
	 <?php
	$gender_arry  = array('Male','Female');
	
	foreach($gender_arry as $gendr){
		if($gendr == $gender){
            echo "<option value='$gendr' selected >$gendr</option>";
		}
		else{
			echo "<option value='$gendr'>$gendr</option>";
		}
		
	}
	?> 
	</select>
</div>

<div class='col-md-4 form-group internal' style="padding-left:0px">
	<select name="age_group[]" multiple id="age_group" class='form-control'>
	<option value="">Select Age Group</option>
	<?php
	$agegroups_arry  = array('U10','U11','U12','U13','U14','U15','U16','U17','U18','U19','Kids','Adults');
	foreach($agegroups_arry as $agegroup){
		if(in_array($agegroup, $age_group)){
            echo "<option value='$agegroup' selected>$agegroup</option>";
		}
		else{
			echo "<option value='$agegroup'>$agegroup</option>";
		}
	}
	?>
	</select>
</div>

<div id="register-submit" class="col-md-2 form-group internal" style="padding-left:15px">
<input  id='age_group_post' name='age_group_post' type='hidden' value='<?php echo json_encode($age_group);?>'>
<input  id='sport' name='sport' type='hidden' value="<?php echo $sport;?>">
<input  id='tab'   name='tab'	type='hidden' value="Rankings">
<input type = "submit" name = "search_mem_loc" id = "search_mem_loc" value = " Search " />
</div>

</form>
<div class="clear"></div>
<?php
if(count($loc_query) > 0 and $this->session->userdata('users_id') == 240){
?>
<input type="button" class="league-form-submit1" name="capture" id="capture" value="Print" style="float:right;" onclick="print('<?=$sport;?>','<?=$search_uname;?>','<?=$country;?>','<?=$state;?>','<?=$gender;?>')" />
<?php
}?>

<!-- <p style="padding-top:10px"><a href="#"><u>Advanced Search</u></a></p> -->

<div class="col-md-12 tab-content table-responsive">
<?php 
if(count($loc_query) == 0)
{
?>
<table class="table tab-score">
<tr class="top-scrore-table">
<td class="score-position">Rank</td>
<td class="score-position">Player Name</td>
<td class="score-position">Age Group</td>
<td class="score-position">A2M Rating</td>
<td class="score-position">City</td>
<td class="score-position">State</td>
<!--<td class="score-position">Level</td>-->
<td class="score-position">Club Name</td>
</tr>
<tr>
<td colspan="7"><h5>No Players Found.</h5></td>
</tr>
</table>
<?php
}else{
?>
<table id="searchplayers" class="table tab-score">
<thead>
<tr class="top-scrore-table">
<td class="score-position">Rank</td>
<td class="score-position">Player Name</td>
<td class="score-position">Age Group</td>
<td class="score-position">A2M Rating</td>
<td class="score-position">City</td>
<td class="score-position">State</td>
<!--<td class="score-position">Level</td>-->
<td class="score-position">Club Name</td>
</tr>
</thead>
<tbody>
<?php
$k=1;
foreach($loc_query as $key => $row) {
$Sports_Interests = league::get_user_sport_intrests($row->Users_ID,$sport);
$membership_det = league::get_membership_details($row->Users_ID);
 ?><!-- img-djoko -->
<tr>
<td><?php echo $k;?></td>
<td>
<a target="_blank" href="<?php echo base_url();?>
<?php if($row->Is_coach==1){ echo "coach"; } else{ echo "player"; }?>/<?php echo $row->Users_ID;?>">
<?php echo ucfirst($row->FirstName)." ".ucfirst($row->LastName);?>
</a>
</td>
<td><?php echo $row->UserAgegroup;?></td>
<td><?php echo $row->A2MScore;?></td>
<td><?php echo $row->City;?></td>
<td><?php echo $row->State;?></td>
<!--<td><!--?php $levelid = $Sports_Interests[0]->Level;
$levelname = league::get_level_name('', $levelid);
echo $levelname['SportsLevel'];?>	
</td>-->
<td>
<?php
$get_club = league::get_club($membership_det[0]->Club_id);
echo $get_club['Aca_name'];?>	
</td>
</tr>
<?php 
	//if($row->A2MScore != $loc_query[$key+1]->A2MScore){
	$k++;
	//}
} ?>
</tbody>
</table>
<?php 
}
?>
</div>

</div>

<div class="clear"></div>