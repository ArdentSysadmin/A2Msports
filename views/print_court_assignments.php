<?php
$color_arr = array('8cf29b','b9f326','b38cf5','fef676','f3b06b','e6d2ce','e86eb1','48c2ed','44b86d','fee998','abd318','189bbd','f3b06b','e6d2ce','d9b3bf','88aa8e','e1d6f6','855dfc');

$res = $matches->result();
$c = 0;
$uniq_draws = array();
foreach($res as $i => $match){
	$timestamp = strtotime($match->Match_DueDate);
	$courts_arr[$timestamp][$match->Court_Info][] = array('draw_title' => $match->Draw_Title, 'match_num' => $match->Match_Num);
	
	if(!in_array($match->Court_Info, $court_titles))
		$court_titles[] = $match->Court_Info;
	if(!array_key_exists($match->Draw_Title, $uniq_draws)){
		$uniq_draws[$match->Draw_Title] = "#".$color_arr[$c];
		$c++;
	}		
}
sort($court_titles);
?>
<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>

<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

<table id='tbl_court_grid' class="table table-bordered" style='font-size:14px;'>
<tr>
<th scope="col">&nbsp;</th>
<?php
foreach($court_titles as $court){
?>
<th scope="col"><?=$court;?></th>
<?php
}
?>
</tr>

<tr>
<?php
$temp_time = '';
foreach($courts_arr as $time => $info){
$ev_date = date('Md,Y', $time);
?>
<th scope="row" style="text-align:right;">
<?php if($temp_time != $ev_date) { echo date('Md,Y', $time);} echo "<br>".date('h:i A', $time);?>
</th>
<?php
$temp_time = $ev_date;
foreach($court_titles as $court){
?>
<td style="background-color:<?php echo $uniq_draws[$info[$court][0]['draw_title']]; ?>">
<?php
if($info[$court]){
	foreach($info[$court] as $i => $data){
		echo $data['draw_title']." - <b>Match ".$data['match_num']."</b><br>";
	}
}
//print_r($info[$court]);
?></td>
<?php
}
?>
</tr>
<?php
}
?>
</table>