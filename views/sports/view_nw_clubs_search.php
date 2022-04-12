<table class="table table-striped">
<thead>
<tr>
<th scope="col" style="font-weight: bold !important;">Club Name</th>
<th scope="col" style="font-weight: bold !important;">City</th>
<th scope="col" style="font-weight: bold !important;">State</th>
<th scope="col" style="font-weight: bold !important;">Contact #</th>
<th scope="col" style="font-weight: bold !important;">Rating</th>
</tr>
</thead>
<tbody>
<?php
if($club_results){
$k=1;
foreach($club_results as $key => $row) {
?>
<tr>
<td><p class="mt-3 mb-0">
<?php
if($row->Aca_URL_ShortCode != ""){
?>
<a href="<?php
if($row->A2M_Proxy_URL) 
	echo $row->A2M_Proxy_URL;
else
	echo base_url().$row->Aca_URL_ShortCode;	
?>">
<?php echo trim($row->Aca_name);?></a>
<?php
}
else if($row->Aca_url != ""){
?>
<a href="<?php echo stripslashes($row->Aca_url);?>"><?php echo stripslashes($row->Aca_name);?></a>
<?php
}
else{?>
<?php echo stripslashes($row->Aca_name);?>
<?php
}?></p></td>

<td><p class="mt-3 mb-0"><?php 
if($row->Aca_city != ""){
echo $row->Aca_city; 
}
?></p></td>

<td><p class="mt-3 mb-0"><?php 
if($row->Aca_state != ""){
echo $row->Aca_state; 
}
?></p></td>
<td><p class="mt-3 mb-0"><?php echo $row->Aca_contact_phone; ?></p></td>
<td><p class="mt-3 mb-0">
<?php
$get_clubratings = league::get_club_Rating($row->Aca_ID);

if($get_clubratings){

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
?></p></td>
</tr>
<?php 
$k++;
}
}
else{
?>
<tr><td colspan='5'><p class="mt-3 mb-0">No Results found!</p></td></tr>
<?php
}
?>
</tbody>
</table>