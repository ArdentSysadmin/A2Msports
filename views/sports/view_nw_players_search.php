<table class="table table-striped">
<thead>
<tr>
<!-- <th scope="col">Rank</th> -->
<th scope="col">Player Name</th>
<th scope="col">City</th>
<th scope="col">State</th>
<th scope="col">A2M Rating <br>(Singles)</th>
<th scope="col">A2M Rating <br>(Doubles)</th>
<th scope="col">A2M Rating <br>(Mixed)</th>
</tr>
</thead>
<tbody>
<?php
if($loc_query){
$k=1;
foreach($loc_query as $key => $row) {
$Sports_Interests = league::get_user_sport_intrests($row->Users_ID,$sport);
$membership_det = league::get_membership_details($row->Users_ID);
?>
<tr>
<!-- <td><p class="mt-3 mb-0"><?php echo $k;?></p></td> -->
<td><p class="mt-3 mb-0"><a target="_blank" href="<?php echo base_url();?>
<?php if($row->Is_coach==1){ echo "coach"; } else{ echo "player"; }?>/<?php echo $row->Users_ID;?>">
<?php echo ucfirst($row->FirstName)." ".ucfirst($row->LastName);?>
</a></p></td>
<td><p class="mt-3 mb-0"><?php echo $row->City;?></p></td>
<td><p class="mt-3 mb-0"><?php echo $row->State;?></p></td>
<td><p class="mt-3 mb-0"><?php echo number_format($row->A2M_Singles, 3);?></p></td>
<td><p class="mt-3 mb-0"><?php echo number_format($row->A2M_Doubles, 3);?></p></td>
<td><p class="mt-3 mb-0"><?php echo number_format($row->A2M_Mixed, 3);?></p></td>
</tr>
<?php 
$k++;
} 
}
else{
?>                           
<tr>
<td colspan='7'><p class="mt-3 mb-0">No Results found!</p></td>
<?php
}
?>  


</tbody>
</table>