<div id='Coaches' class="col-md-12" >
<div class="fromtitle">Search for Coaches</div>

<form method="post" id="myform"  action="<?php echo base_url();?><?php echo $sport_segment;?>?p=coaches"> 

<input  id='sport' name='sport' type='hidden' value="<?php echo $sport;?>">

<div class='col-md-3 form-group internal' style="padding-left:0px">
	<input class='form-control' id='name' name='coach_name' type='text' placeholder="Coach Name" value="<?php echo $coach_name; ?>"  />
</div>

<div class='col-md-3 form-group internal' style="padding-left:0px">  
    <select class='form-control' id='coach_country' name='coach_country'>
        <option value="">Select Country</option>
	<?php
	foreach($countries as $cntry)
	{
		if($cntry->Country == $coach_country){
            echo "<option value='$cntry->Country' selected>$cntry->Country</option>";
		}else{
			 echo "<option value='$cntry->Country'>$cntry->Country</option>";
		}
	
	}
	?>
    </select>	
</div>

<div class='col-md-3 form-group internal' id="coachstates_div" style="padding-left:0px">
<?php 
if($this->input->post('coach_mem')){
	if($this->input->post('coach_country')=='United States of America'){
         $states = array('Alabama','Alaska','Arizona','Arkansas','California','Colorado','Connecticut','Delaware','District of Columbia','Florida','Georgia',
	'Hawaii','Idaho','Illinois','Indiana','Iowa','Kansas','Kentucky','Louisiana','Maine','Maryland','Massachusetts','Michigan','Minnesota','Mississippi',
	'Missouri','Montana','Nebraska','Nevada','New Hampshire','New Jersey','New Mexico','New York','North Carolina','North Dakota','Ohio','Oklahoma', 'Oregon','Pennsylvania','Rhode Island','South Carolina','South Dakota','Tennessee','Texas','Utah','Vermont','Virginia','Washington','West Virginia',
	'Wisconsin','Wyoming'); 
	}else if($this->input->post('coach_country')=='India'){
        $states = array('Andhra Pradesh','Arunachal Pradesh','Assam','Bihar','Chhattisgarh','Goa','Gujarat','Haryana','Himachal Pradesh','Jammu and Kashmir','Jharkhand','Karnataka','Kerala','Madhya Pradesh','Maharashtra','Manipur','Meghalaya','Mizoram','Nagaland','Odisha','Punjab','Rajasthan','Sikkim','Tamil Nadu','Telangana','Tripura','Uttar Pradesh','Uttarakhand','West Bengal');
	}

}else{
	 $states = array();
}
?>
<input class='form-control' list="coachstates" name="coach_state" value="<?php  if($coach_state){echo $coach_state;}else{echo '';}?>" placeholder="State" />
<datalist id="coachstates">
<?php foreach ($states as $key => $stat) {
	if($stat == $coach_state){
        echo '<option value="'.$stat.'" selected>';
	}else{
		echo '<option value="'.$stat.'">';
	}
	
} ?> 
</datalist>
</div>

<div id="register-submit" class="col-md-2 form-group internal" style="padding-left:0px">
<input  id='tab'   name='tab'	type='hidden' value="Coaches">
<input type="submit" name="coach_mem" value=" Search " />
</div>

</form>
<div class="clear"></div>

<!-- <p style="padding-top:10px"><a href="#"><u>Advanced Search</u></a></p> -->

<div class="tab-content table-responsive">
<table id="searchcoach" class="table tab-score">
<thead>
<tr class="top-scrore-table">
<td class="score-position">&nbsp;</td>
<td class="score-position">Name</td>
<td class="score-position">City</td>
<td class="score-position">State</td>
<td class="score-position">Coach Website</td>
<td class="score-position">Rating</td>
</tr>
</thead>
<tbody>
<?php 
if(count($coach_results) == 0)
{
?>
<tr>
<td><h5>No Coaches Found.</h5></td>
<td>&nbsp;</td>
<td>&nbsp;</td>
<td>&nbsp;</td>
<td>&nbsp;</td>
<td>&nbsp;</td>
</tr>
<?php
}
else
{
foreach($coach_results as $row){ ?><!-- img-djoko -->
<tr>
<td>
<a href="#"><img class="scale_image" src="<?php echo base_url(); ?>profile_pictures/<?php if($row->Profilepic!=''){ echo $row->Profilepic; } else { echo "default-profile.png"; } ?>" alt="img" width="100px" height="100px" /></a>
</td>
<td>
<a target="_blank" href="<?php echo base_url();?>coach/<?php echo $row->Users_ID;?>"><?php echo $row->Firstname.' '.$row->Lastname; ?></a>
</td>
<td>
<?php 
if($row->City != "")
{
echo $row->City; 
}
?>
</td>
<td>
<?php 
if($row->State != "")
{
echo $row->State; 
}
?>
</td>

<td>
<?php
if($row->Coach_Website != ""){
 $check = "ttp:";
$pos = strpos($row->Coach_Website,$check);
if($pos){ ?>
 
 <a target="_blank" href="<?php echo $row->Coach_Website;?>"><?php echo "Click Here"; //$row->Coach_Website;?></a> 
 
<?php } else { ?>
 <a target="_blank" href="<?php echo "http://".$row->Coach_Website;?>">
 <?php echo "Click Here";//$row->Coach_Website;?></a>  
<?php } 
}else{
	echo "--";
} ?>
</td>
<td>
<?php 
$get_coachratings = league::getCoachRatings($row->Users_ID);
//echo "<pre>";
//print_r($get_coachratings);

if($get_coachratings){?>
<a href="<?php echo base_url();?>coach/<?php echo $row->Users_ID;?>" target="_blank">
<?php 

               $s5=0;
			   $s4=0;
			   $s3=0;
			   $s2=0;
			   $s1=0;
			   $s0=0;

			   foreach ($get_coachratings as $key => $value) {
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
                if($value->Ratings==0){
                  $s0+=0;
                }
			   }
			   
			$avg_star_rating = ($s5*5 + $s4*4 + $s3*3 + $s2*2 + $s1*1 + $s0*1) / ($s5 + $s4 + $s3 + $s2 + $s1);
			//echo $avg_star_rating;
			//exit;

			if( is_float( $avg_star_rating ) ) { // Check to see if whole number or decimal
		        $rounded_ranking = round($avg_star_rating); // If decimal round it down to a whole number
		       
		        for ($counter=2; $counter <= $rounded_ranking; $counter++){ 
		            echo '<i class="fa fa-star checked"></i>';
		        }
		        echo '<i class="fa fa-star-half-o checked"></i>'; // Static half star used as the ranking value is a decimal and the is_float condition is met.
		       for(;$rounded_ranking<5;$rounded_ranking++){
		            echo '<i class="fa fa-star-o checked"></i>';
		        }
		    }
		    else if($avg_star_rating > -1){
		        // For Loop so we can run the stars as many times as is set, no offset need, as no half star required for whole number rankings
		        for ($counter=1; $counter <= $avg_star_rating; $counter++){
		            echo '<i class="fa fa-star checked"></i>';
		        }
		        for(;$avg_star_rating<5;$avg_star_rating++){
		            echo '<i class="fa fa-star-o checked"></i>';
		        }
		    }


	/*for($j=0;$j<5;$j++){
	if($j<$avg_star_rating){?>
        <i class="fa fa-star checked"></i>
	<?php }else{?>
        <i class="fa fa-star-half-o checked"></i>
	<?php } ?>
			 
	<?php }*/
?>

<?php 
//echo "( ".count($get_clubratings)." )";
?>
</a>
<?php
}else{
		for($j=0;$j<5;$j++){
	
       echo '<i class="fa fa-star-o checked"></i>';
	
			
	 }
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