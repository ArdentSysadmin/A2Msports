<table class="table table-striped">
<thead>
<tr>
<th scope="col" style="font-weight: bold !important;">Coach Name</th>
<th scope="col" style="font-weight: bold !important;">City</th>
<th scope="col" style="font-weight: bold !important;">State</th>
<th scope="col" style="font-weight: bold !important;">Coach Website</th>
<th scope="col" style="font-weight: bold !important;">Rating</th>
</tr>

</thead>
<tbody>
<?php
if($coach_results){
$k=1;
foreach($coach_results as $key => $row) {
?>
<tr>
<td>
<p class="mt-3 mb-0"><a style='font-weight: 600;' target="_blank" href="<?php echo base_url();?>coach/<?php echo $row->Users_ID;?>">
<!-- <img class="scale_image" src="<?php echo base_url(); ?>profile_pictures/<?php if($row->Profilepic!=''){ echo $row->Profilepic; } else { echo "default-profile.png"; } ?>" alt="img" width="100px" height="100px" /> -->
<?php echo $row->Firstname.' '.$row->Lastname; ?></a></p>
</td>

<td><p class="mt-3 mb-0"><?php 
if($row->City != "")
{
echo $row->City; 
}
?></p></td>
<td><p class="mt-3 mb-0"><?php 
if($row->State != "")
{
echo $row->State; 
}
?></p></td>
<td><p class="mt-3 mb-0"><?php
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
} ?></p></td>

<td><p class="mt-3 mb-0">
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
</p></td>
</tr>
<?php 
$k++;
}
}
else{?>                           
<tr><td colspan='5'><p class="mt-3 mb-0">No Results found!</p></td></tr>
<?php
}
?>
</tbody>
</table>