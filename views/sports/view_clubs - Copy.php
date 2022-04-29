<div id='Clubs' class="col-md-12">
<div class="fromtitle">Search for Clubs</div>

<form method="post" id="myform"  action="<?php echo base_url();?><?php echo $sport_segment;?>#Clubs"> 

<input  id='sport' name='sport' type='hidden' value="<?php echo $sport;?>">

<div class='col-md-3 form-group internal' style="padding-left:0px">
	<input class='form-control' id='name' name='club_name' type='text' placeholder="Club Name" value="<?php echo $club_name; ?>"  />
</div>

<div class='col-md-3 form-group internal' style="padding-left:0px">  
    <select class='form-control' id='club_country' name='club_country'>
        <option value="">Select Country</option>
	<?php
	foreach($countries as $cntry)
	{
		if($cntry->Country == $club_country){
            echo "<option value='$cntry->Country' selected>$cntry->Country</option>";
		}else{
			 echo "<option value='$cntry->Country'>$cntry->Country</option>";
		}
	
	}
	?>
    </select>	
</div>


<div class='col-md-3 form-group internal' id="clubstates_div" style="padding-left:0px">
<?php 
if($this->input->post('club_mem')){
	if($this->input->post('club_country')=='United States of America'){
         $states = array('Alabama','Alaska','Arizona','Arkansas','California','Colorado','Connecticut','Delaware','District of Columbia','Florida','Georgia',
	'Hawaii','Idaho','Illinois','Indiana','Iowa','Kansas','Kentucky','Louisiana','Maine','Maryland','Massachusetts','Michigan','Minnesota','Mississippi',
	'Missouri','Montana','Nebraska','Nevada','New Hampshire','New Jersey','New Mexico','New York','North Carolina','North Dakota','Ohio','Oklahoma', 'Oregon','Pennsylvania','Rhode Island','South Carolina','South Dakota','Tennessee','Texas','Utah','Vermont','Virginia','Washington','West Virginia',
	'Wisconsin','Wyoming'); 
	}else if($this->input->post('club_country')=='India'){
        $states = array('Andhra Pradesh','Arunachal Pradesh','Assam','Bihar','Chhattisgarh','Goa','Gujarat','Haryana','Himachal Pradesh','Jammu and Kashmir','Jharkhand','Karnataka','Kerala','Madhya Pradesh','Maharashtra','Manipur','Meghalaya','Mizoram','Nagaland','Odisha','Punjab','Rajasthan','Sikkim','Tamil Nadu','Telangana','Tripura','Uttar Pradesh','Uttarakhand','West Bengal');
	}

}else{
	 $states = array();
}
?>
<input class='form-control' list="clubstates" name="club_state" value="<?php  if($club_state){echo $club_state;}else{echo '';}?>" placeholder="State"/>
<datalist id="clubstates">
<?php foreach ($states as $key => $stat) {
	if($stat == $club_state){
        echo '<option value="'.$stat.'" selected>';
	}else{
		echo '<option value="'.$stat.'">';
	}
	
} ?> 
</datalist>
</div>

<div id="register-submit" class="col-md-2 form-group internal" style="padding-left:0px">
<input  id='tab'   name='tab'	type='hidden' value="Clubs">
<input type="submit" name="club_mem" value=" Search " />
</div>
</form>
<?php if($this->session->userdata('user')!="") { ?>	
<div id="register-submit" class="col-md-2 form-group internal" style="padding-left:0px">
<input type="submit" name="add_club" id="add_club"  value="Add New Club" />
</div>
<?php
}
?>
<div class="clear"></div>

<div id='add_Clubs' class="col-md-12" style="display:none;">
<div class="fromtitle">Add Club</div>
<form method="post" id="addClubs"  action="<?php echo base_url();?><?php echo $sport_segment;?>#addClub">
<input  id='sport' name='sport' type='hidden' value="<?php echo $sport;?>">
<div class='col-md-6 form-group internal' style="padding-left:0px">
<label>Club Name: </label>
	<input class='form-control' id='clubname' name='clubname' type='text' placeholder="Club Name"  required />
</div>
<div class='col-md-6 form-group internal' style="padding-left:0px">
<label>Country: </label>
 <select class='form-control' id='clubcountry' name='clubcountry'>
        <option value="">Select Country</option>
	<?php
	foreach($countries as $cntry)
	{	
	 echo "<option value='$cntry->Country'>$cntry->Country</option>";
	}
	?>
    </select>	
</div>
<div class='col-md-6 form-group internal' style="padding-left:0px" >
<label>State: </label>
<div id="addclubstates_div">

<input class='form-control' list="addclubstates" name="addclub_state"  placeholder="State"/>
<datalist id="addclubstates">
<?php foreach ($states as $key => $stat) {
		echo '<option value="'.$stat.'">';	
} ?> 
</datalist>
</div>
</div>
<div class='col-md-6 form-group internal' style="padding-left:0px">
<label>City: </label>
	<input class='form-control' id='clubcity' name='clubcity' type='text' placeholder="City"   />
</div>
<div class='col-md-6 form-group internal' style="padding-left:0px">
<label>Website: </label>
	<input class='form-control' id='club_website' name='club_website' type='text' placeholder="Website"   />
</div>

<div class='col-md-6 form-group internal' style="padding-left:0px">
<label>Contact Name: </label>
	<input class='form-control' id='contact_name' name='contact_name' type='text' placeholder="Contact Name"   />
</div>
<div class='col-md-6 form-group internal' style="padding-left:0px">
<label>Contact Email: </label>
	<input class='form-control' id='contact_email' name='contact_email' type='text' placeholder="Contact Email"   />
</div>
<div class='col-md-6 form-group internal' style="padding-left:0px">
<label>Contact Phone: </label>
	<input class='form-control' id='contact_phone' name='contact_phone' type='text' placeholder="Contact Phone"   />
</div>


<div class='col-md-6 form-group internal' style="padding-left:0px">
<label>No Of Courts: </label>
	<input class='form-control' id='no_of_courts' name='no_of_courts' type='text' placeholder="Number of Courts"   />
</div>
<div class='col-md-6 form-group internal' style="padding-left:0px">
<label>Club Details: </label>
	<textarea class='form-control' id='club_details' name='club_details'>
	 Enter Club Details
	</textarea>
</div>

<div class='col-md-6 form-group internal' style="padding-left:0px">
<label>Sports: </label>
<?php 
$selected = '';
foreach ($sports as $key => $sprt) {

	if($sprt->SportsType_ID == $sport){
      $selected = 'checked';
	}else{
		$selected = '';
	}
		echo '<input type="checkbox"  name="clubsport[]" value="'.$sprt->SportsType_ID.'" '.$selected.'/>';
		echo $sprt->Sportname;	echo "&nbsp";

} ?> 
</div>
<div id="register-submit"  class='col-md-6 form-group internal' style="padding-left:0px">
	<input  id='tab'   name='tab'	type='hidden' value="Clubs">
	<input type="submit" name="addclub" id="addclub"  value="Add" />
	<input type="button" id="clear-form" value="Cancel" />
</div>

</form>
</div>

<div class="clear"></div>

<div class="tab-content table-responsive">
<table id="searchclub" class="table tab-score">
<thead>
<tr class="top-scrore-table">
<td class="score-position">Club Name</td>
<td class="score-position">City</td>
<td class="score-position">State</td>
<td class="score-position">Contact Number</td>
<td class="score-position">Rating</td>
</tr>
</thead>
<tbody>
<?php 
if(count($club_results) == 0)
{
?>
<tr>
<td><h5>No Clubs Found.</h5></td>
<td>&nbsp;</td>
<td>&nbsp;</td>
<td>&nbsp;</td>
<td>&nbsp;</td>
</tr>
<?php
}
else
{
foreach($club_results as $row){ ?><!-- img-djoko -->
<tr>
<td id="club_"<?=$row->Aca_ID;?>>
<?php
if($row->Aca_url != ""){
?>
<a href="#"><?php echo stripslashes($row->Aca_name);?></a>
<?php
}
else{?>
<?php echo stripslashes($row->Aca_name);?>
<?php
}?>
</td>

<td>
<?php 
if($row->Aca_city != ""){
echo $row->Aca_city; 
}
?>
</td>
<td>
<?php 
if($row->Aca_state != ""){
echo $row->Aca_state; 
}
?>
</td>
<td><?php echo $row->Aca_contact_phone; ?></td>

<td>
<?php
$get_clubratings = league::get_club_Rating($row->Aca_ID);

if($get_clubratings){?>
<?php 
$s5 = 0; $s4 = 0; $s3 = 0;  $s2 = 0;  $s1 = 0;
   foreach($get_clubratings as $key => $value) {
	if($value->Ratings==5){
	  $s5+=1;
	} 
	if($value->Ratings==4){
	  $s4+=1;
	} 
	if($value->Ratings==3){
	  $s3+=1;
	} 
	if($value->Ratings==2){
	  $s2+=1;
	}
	if($value->Ratings==1){
	  $s1+=1;
	}
   }
			   
	$avg_star_rating = ($s5*5 + $s4*4 + $s3*3 + $s2*2 + $s1*1) / ($s5 + $s4 + $s3 + $s2 + $s1);
		echo "<a href='#searchclub' class='abc' id='club_$row->Aca_ID' style='text-decoration: none;'>";
				
	if( is_float( $avg_star_rating ) ) { // Check to see if whole number or decimal
		$rounded_ranking = round($avg_star_rating); // If decimal round it down to a whole number
				
		for ($counter=2; $counter <= $rounded_ranking; $counter++){ 
			echo " <i class='fa fa-star checked'></i> ";
		}
		
		echo '<i class="fa fa-star-half-o checked"></i> '; 
		// Static half star used as the ranking value is a decimal and the is_float condition is met.
		
	   for(;$rounded_ranking<5;$rounded_ranking++){
			echo '<i class="fa fa-star-o checked"></i> ';
	   }
	}  
	else{
		// For Loop so we can run the stars as many times as is set, no offset need, as no half star required for whole number rankings
		for ($counter=1; $counter <= $avg_star_rating; $counter++){
			echo '<i class="fa fa-star checked"></i> ';
		}
		for(;$avg_star_rating<5;$avg_star_rating++){
			echo '<i class="fa fa-star-o checked"></i> ';
		}
	}
echo "</a>";

}
else{
	echo "<a href='#searchclub' class='abc' id='club_$row->Aca_ID' style='text-decoration: none;'>";
	 for($j=0;$j<5;$j++){
	 	echo "<i class='fa fa-star-o checked'></i> ";
	 }
	 echo "</a>";
}
?>
</td>
</tr>
<?php } }?>
</tbody>
</table>
</div>
</div>

<div class="clear"></div>
<div id="clubRatingsDiv"></div> 