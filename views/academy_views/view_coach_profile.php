<!-- Breadcromb Wrapper Start -->
<div class="breadcromb-wrapper">
<div class="breadcromb-overlay"></div>
<div class="container">
<div class="row">
<div class="col-sm-12">
<div class="breadcromb-left">
<h3>Coaches</h3>
</div>
</div>
</div>

</div>
</div>
<!-- Breadcromb Wrapper End --> 
<section class="inner-page-wrapper">
<div class="container">
<div class="row">
<!-- <div class="col-md-12" style="margin-top: 5px; margin-left: 0px; margin-bottom: 20px; ">
<h3 style="color:#0032af;">Coaches</h3>
</div> -->

<div class="col-md-8">

<!-- Coaches section start-->

<!--<div class="fromtitle">Search for Coaches</div>

<form method="post" id="coach_form"  action="<?php echo base_url().$org_details['Aca_URL_ShortCode'];?>/search_coaches"> 

<div class='col-md-3 form-group internal' style="padding-left:0px">
<input class='form-control' id='' name='coach_name' type='text' placeholder="Coach Name" value="<?php echo $coach_name; ?>" />
</div>

<div class='col-md-3 form-group internal' style="padding-left:0px">
<?php
$sport = "";
if($this->input->post('coach_sport')){
$sport = $this->input->post('coach_sport');
}
?>
<select name="coach_sport"  id="coach_sport" class='form-control'>
<option value="">Coach Sport</option>
<option value="1" <?php if($sport=="1"){ echo "selected=selected"; } ?>>Tennis</option>
<option value="2" <?php if($sport=="2"){ echo "selected=selected"; } ?>>Table Tennis</option>
<option value="3" <?php if($sport=="3"){ echo "selected=selected"; } ?>>Badminton</option>
<option value="4" <?php if($sport=="4"){ echo "selected=selected"; } ?>>Golf</option>
<option value="5" <?php if($sport=="5"){ echo "selected=selected"; } ?>>Racquetball</option>
<option value="6" <?php if($sport=="6"){ echo "selected=selected"; } ?>>Squash</option>
<option value="7" <?php if($sport=="7"){ echo "selected=selected"; } ?>>Pickleball</option>
</select>
</div>

<div class='col-md-3 form-group internal' style="padding-left:0px">
<?php
$range = "";
if($this->input->post('coach_range')){
$range = $this->input->post('coach_range');
}
?>

<select name="coach_range"  id="coach_range" class='form-control'>
<option value="" <?php if($range==""){ echo "selected=selected"; } ?>>Distance</option>
<option value="10" <?php if($range=="10"){ echo "selected=selected"; } ?>>10Miles</option>
<option value="20" <?php if($range=="20"){ echo "selected=selected"; } ?>>20Miles</option>
<option value="30" <?php if($range=="30"){ echo "selected=selected"; } ?>>30Miles</option>
<option value="40" <?php if($range=="40"){ echo "selected=selected"; } ?>>40Miles</option>
<option value="50" <?php if($range=="50"){ echo "selected=selected"; } ?>>50Miles</option>
</select>

</div>

<input class='form-control'  name='org_id' id='org_id' type='hidden' value="<?php echo $org_details['Aca_ID'];?>"  />

<div id="register-submit" class="col-md-2 form-group internal" style="padding-left:0px">
<input type="submit" name="coach_mem" value=" Search " />
</div>

</form> -->

<div class="clear"></div>


<div class="tab-content">
<table class="tab-score">
<?php 
if(count($coaches_list) == 0)
{
?>
<tr>
<td><h5>No Coach Members Found.</h5></td>
</tr>
<?php
}
else
{
//echo "<pre>"; print_r($coaches_list); exit;
foreach($coaches_list as $row){ 
	if(count($coaches_list) == 1 or $row->Users_ID == $coach_id){
?><!-- img-djoko -->
<tr style="background-color:#eeefee">

<td>
	<a href="#"><img class="scale_image" src="<?php echo base_url(); ?>profile_pictures/<?php if($row->Profilepic!=''){ echo $row->Profilepic; } else { echo "default-profile.png"; } ?>" alt="img"width="150" height="150" style="object-fit: cover; margin-right:20px;" /></a>
</td>

<td width="90%" style="vertical-align:top;">
	<b><h3 style="padding-top:10px;"><a><?php echo ucfirst($row->Firstname).' '.ucfirst($row->Lastname); ?></a></h3></b>
	<b>Sport: </b><?php 
	$get = $this->model_academy->get_sport_title($row->coach_sport);
	echo $get['Sportname'] ;
	?><br />
	<b>Location: </b><?php 
	if($row->City != ""){
	echo $row->City.", ".$row->State; 
	}
	?><br />
	<b>Coach Website: </b>
	<?php
	if($row->Coach_Website != "") {
	$check = "http";
	$pos = strpos($row->Coach_Website,$check);
	if($pos) {
	?>
	<a target="_blank" href="<?php echo $row->Coach_Website;?>"><?php echo $row->Coach_Website;?></a> 
	<?php 
	} 
	else { ?>
	<a target="_blank" href="<?php echo "http://".$row->Coach_Website;?>"><?php echo $row->Coach_Website;?></a>  
	<?php
	 } 
	} ?>
</td>
<td width='40%'>&nbsp;&nbsp;&nbsp;&nbsp;</td>
</tr>



<tr>
<td colspan='2'>
<br />
	<h3 style="color:#123176;"><b>Profile<b></h3>
<?php 
	if($row->coach_profile){
		echo $row->coach_profile; 
	}
	else{
		echo "N/A";
	}
	?>
</td>
<td>&nbsp;&nbsp;&nbsp;&nbsp;</td>
</tr>
<tr><td colspan='2'><hr /></td></tr>

<?php
}
}
}?>
</table>
</div>

</div>
<div class="col-md-4">

<!-- Coach Ratings -->
<div class="top-score-title right-score">
<div class="rating-head" style="font-size: 16px;
    margin-bottom: 20px; color:#123176"><b>Ratings & Reviews&nbsp;&nbsp;&nbsp;</b>   
<span>
<?php
$cur_class = $this->router->class;

			   $get_coachratings = $cur_class :: get_coachratings($row->Users_ID);
			   //echo "<pre>"; print_r($get_coachratings); exit;
			   $s5=0;
			   $s4=0;
			   $s3=0;
			   $s2=0;
			   $s1=0;
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
			   }

			   $avg_star_rating = ($s5*5 + $s4*4 + $s3*3 + $s2*2 + $s1*1) / ($s5 + $s4 + $s3 + $s2 + $s1);

if($avg_star_rating!="" || $avg_star_rating!=0){

      if( is_float( $avg_star_rating ) ) { // Check to see if whole number or decimal
            $rounded_ranking = round($avg_star_rating); // If decimal round it down to a whole number
           
            for ($counter=2; $counter <= $rounded_ranking; $counter++){ 
                echo '<i class="fa fa-star checked accpad"></i>';
            }
            echo '<i class="fa fa-star-half-o checked accpad"></i>'; // Static half star used as the ranking value is a decimal and the is_float condition is met.
           for(;$rounded_ranking<5;$rounded_ranking++){
                echo '<i class="fa fa-star-o checked accpad"></i>';
            }
        }   
        else {
            // For Loop so we can run the stars as many times as is set, no offset need, as no half star required for whole number rankings
            for ($counter=1; $counter <= $avg_star_rating; $counter++){
                echo '<i class="fa fa-star checked accpad"></i>';
            }
            for(;$avg_star_rating<5;$avg_star_rating++){
                echo '<i class="fa fa-star-o checked accpad"></i>';
            }
        }
      }else{
        for($j=0;$j<5;$j++){
         echo '<i class="fa fa-star-o checked accpad"></i>';
       
      }
    }
      

  ?>
  </span>
</div>
<?php
foreach ($get_coachratings as $key => $value) {
	$get_user = $cur_class :: get_user($value->User_ID);
?>
<div style="text-transform:none; float:left; margin-right: 15px;" class="ratingsimg">
<?php if($get_user['Profilepic']!=""){
 $profile_pic = $get_user['Profilepic']; 
 } else { 
 $profile_pic = "default-profile.png";
 }
 if($value->Rate_Anonymous!=1){
  $profile_url = base_url().'profile_pictures/'.$profile_pic;
 }else{
  $profile_url = base_url().'profile_pictures/default-profile.png';
}?>
<img class="img-circle" width="50px" height="50px" src="<?php echo $profile_url;?>" alt="" />

</div>
<!-- <div style="text-transform:none; float:left"> -->

  <p>
  <?php if($value->Rate_Anonymous != 1){
       echo $get_user['Firstname'] . " " . $get_user['Lastname'];
   }else{
      echo "Anonymous";
   } ?><br>
    <?php for($j=0;$j<5;$j++){
  if($j<$value->Ratings){?>
        <i class="fa fa-star checked accpad"></i>
  <?php }else{?>
        <i class="fa fa-star-o checked accpad"></i>
  <?php } ?>
       
  <?php }?>
  </p>
  <?php if($value->Comments != ""){?>
       <p><b>Comment: </b> <?php echo $value->Comments;?></p>
  <?php } ?>
  
<!-- </div> -->
<div style="clear:both;"></div>
   
<?php } ?>
</div>

<!-- Coach Ratings -->
</div>



</div>
</div>
</section>