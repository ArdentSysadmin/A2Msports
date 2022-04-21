<table class="table table-striped">
<thead>
<tr>
<th scope="col" style="font-weight: bold !important; text-align: center;">Tournament</th>
<th scope="col" style="font-weight: bold !important;">City</th>
<th scope="col" style="font-weight: bold !important;">State</th>
<th scope="col" style="font-weight: bold !important;">Date</th>
<th scope="col" style="font-weight: bold !important;">Contact</th>
</tr>
</thead>
<tbody>
<?php
if(!empty($leagues)) { 
//$i=1;
foreach($leagues as $j => $row) {
?>
<tr>
<td >
<div class="names_table align-items-center d-flex">
<a href="<?=base_url().$this->uri->segment(1).'/'.$row->tournament_ID;?>">
<img src="<?php echo base_url(); ?>tour_pictures/
<?php if($row->TournamentImage!=""){ echo $row->TournamentImage; }
else{
switch($row->SportsType) {
case 1:
echo "default_tennis_min.jpg";
break;
case 2:
echo "default_table_tennis_min.jpg";
break;
case 3:
echo "default_badminton_min.jpg";
break;
case 4:
echo "default_golf_min.jpg";
break;
case 5:
echo "default_racquet_ball_min.jpg";
break;
case 6:
echo "default_squash_min.jpg";
break;
case 7:
echo "default_pickleball_min.jpg";
break;
case 8:
echo "default_chess_min.jpg";
break;
case 9:
echo "default_carroms_min.jpg";
break;
case 10:
echo "default_volleyball_min.jpg";
break;
case 11:
echo "default_fencing.jpg";
break;
case 12:
echo "default_bowling.jpg";
break;
case 16:
echo "default_cricket.jpg";
break;

default:
echo "";
break;
}
}
?>">
</a>
<p class="mb-0">
<a style="font-weight: 600; color:#0d6efd;" href="<?=base_url().$this->uri->segment(1).'/'.$row->tournament_ID;?>">
<?=$row->tournament_title;?>
</a></p>
</div>
</td>
<td><p class="mt-3 mb-0"><?=$row->TournamentCity;?></p></td>
<td><p class="mt-3 mb-0"><?=$row->TournamentState;?></p></td>
<td><p class="mt-3 mb-0"><?=date('m/d/Y', strtotime($row->StartDate));?></p></td>
<td><p class="mt-3 mb-0"><?=$row->OrganizerName;?></p></td>
</tr>
<?php
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