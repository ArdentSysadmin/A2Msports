<link href="<?php echo base_url();?>css/style_dir.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" href="<?php echo base_url();?>css/grid.css">
<div class="tab-content">
<table width="100%" border="0" cellspacing="0" cellpadding="0">
<tr>
<td width="20%" style="padding:10px">
<img class="scale_image" src="<?php echo base_url(); ?>images/logo.png" alt="" />
</td>
<td width="80%">
<div align="center" style="font-size:25px; font-weight:bold">
<?php 

$title='';
if($search_uname!=""){
//$title.='Player - '.$search_uname;
}

if($country!=""){
$title.='- '.$country;
}
if($state!=""){
 $title.=' - '.$state;
}

if(count($age_group) > 0){
	$cnt = count($age_group);
    $last_age = $cnt-1;
	if(in_array('Kids', $age_group)){
      
       if($gender == 'Male'){
          $title.=' - Kids - Boys ';
       }else if($gender == 'Female'){
          $title.=' - Kids - Girls ';
       }else{
       	 $title.=' - Kids ';
       }
       
	}
	else if(in_array('Adults', $age_group)){
      
       if($gender == 'Male'){
          $title.=' - Adults - Mens ';
       }else if($gender == 'Female'){
          $title.=' - Adults - Womens ';
       }else{
       	 $title.=' - Adults ';
       }
	}else {
       	
       if($gender == 'Male'){
       	$title.=' - '.$age_group[$cnt-1].' and Below - Boys';
         
       }else if($gender == 'Female'){
         	$title.=' - '.$age_group[$cnt-1].' and Below - Girls';
       }else{

       	$title.=' - '.$age_group[$cnt-1].' and Below';

       }
	}
}

$get_sport = league::get_sport($sport);
$sport_name=$get_sport['Sportname'];

echo $sport_name." Rankings ".$title;

?>
</div>
</td>
</tr>
<tr>
<td colspan="2" style="height:6px; background:#81a32b; font-size:6px"></td>
</tr>
</table>

<div class="general water-mark">
<table width="100%" class='imagetable' border='0' cellpadding='10' cellspacing = '10' align="center">
<thead>
<tr class="top-scrore-table">
<td class="score-position"><b>Rank</b></td>
<td class="score-position" ><b>Player Name</b></td>
<td class="score-position"><b>Age Group</b></td>
<td class="score-position"><b>A2M Score</b></td>
<td class="score-position"><b>City</b></td>
<td class="score-position"><b>State</b></td>
<!--<td class="score-position"><b>Level</b></td>-->
<td class="score-position"><b>Club Name</b></td>
</tr>
</thead>
<tbody>
<?php 
if(count($loc_query) == 0)
{
	?>
<tr>
<td colspan="7"><h5>No Players Found.</h5></td>
</tr>
<?php
}
else
{
$k=1;
foreach($loc_query as $key => $row) {
$Sports_Interests = league::get_user_sport_intrests($row->Users_ID,$sport);
$membership_det = league::get_membership_details($row->Users_ID);
 ?><!-- img-djoko -->
<tr>
<td><?php echo $k;?></td>
<td><?php echo ucfirst($row->FirstName)." ".ucfirst($row->LastName);?></td>
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
$get_club = league::get_club($membership_det[0]->Org_id);
echo $get_club['Org_name'];?>	
</td>
</tr>
<?php 
	//if($row->A2MScore != $loc_query[$key+1]->A2MScore){
	$k++;
	//}
} }?>
</tbody>
</table>
</div>
</div>

<div class="clear"></div>