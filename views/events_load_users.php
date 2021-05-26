

<script>
$(document).ready(function(){ 
	$("#sel_all").change(function(){
	  $(".check_all").prop('checked', $(this).prop("checked"));
	  });
});
</script>

<div style="overflow-y:scroll;<?php if($users->num_rows() > 15) { echo "height:350px"; } else if($users->num_rows() == 0){ echo "height:100px"; } ?>"> 
<table class="tab-score-m">
<tr>
<th width="10%" class="score-position"><input type='checkbox' name="sel_all" id="sel_all" />Select</th>
<th width="22%">Name</th>
<th width="6%">Gender</th>
<th width="30%">Location</th>
<th width="15%">Level</th>
<th width="11%">A2M Score</th>
</tr>

<?php
if(count(array_filter($users->result())) > 0) {
	foreach($users->result() as $array)
	{
	?>
	<tr>
	<td><input class='check_all' type="checkbox" name="sel_user[]" value="<?php echo $array->Users_ID;?>" /></td>
	<td><a href="<?php echo base_url();?>player/<?php echo $array->Users_ID;?>"><?php echo $array->Firstname." ".$array->Lastname;?></a></td>
	<td><?php if($array->Gender == 1) { echo "Male"; } else { echo "Female"; } ?></td>
	<td><?php echo $array->City;?>, <?php echo $array->State; ?></td>

	<td>
	<?php	
			$sport = $sport_id;
			$user_id = $array->Users_ID;
			$get_level = $this->model_event->get_user_sport_level($sport,$user_id);	
			$level = $get_level['Level'];
			$level_name = $this->model_event->get_sport_level_title($level,$sport);
			echo $level_name['SportsLevel'];	
	?>
	</td>

	<td align='right'>
		<?php
		$sport = $sport_id;
	    $user_id = $array->Users_ID;
		$user_a2mscore = "";
		$user_a2mscore = $this->model_event->get_a2msocre($sport,$user_id);
		//if(isset($user_a2mscore)){echo $user_a2mscore['A2MScore'];}else{echo "none";}
		echo $user_a2mscore['A2MScore'];
		?>
		</td>
	</tr>
	<?php
	}
?>

<?php
}
else 
	{
?>
<tr><td colspan='6'><b>No Players Found.</b></td></tr>
<?php
}
?>
</table>
</div>




<?php 
	/*
	   if(isset($sport_intrests)){

		//print_r($sport_intrests);
		//exit;
			$intrests_count = count(array_filter($sport_intrests));
			$i = 0;
			
			if($intrests_count > 0)	{
				$sports_in = "";
				$sports_level = "";
				foreach($sport_intrests as $row)
				{
					$sports_in .= "$row->Sport_id";

					switch ($sports_in) {
					case 1:
					echo "Tennis -";

						$sports_level .= "$row->Level";
						/*if($sports_level == 1) echo Amateur;
						elseif($sports_level == 2) echo Challenger;
						elseif($sports_level == 3) echo Master;
						else echo "";
						
						switch($sports_level){
						case 1:
						echo "Amateur";
						break;
						case 2:
						echo "Challenger";
						break;
						case 3:
						echo "Master";
						break;
						default:
					    echo "";
						}
					break;
					case 2:
					echo "Table Tennis -";
						$sports_level .= "$row->Level";
						switch($sports_level){
						case 1:
						echo "Amateur";
						break;
						case 2:
						echo "Challenger";
						break;
						case 3:
						echo "Master";
						break;
						default:
					    echo "";
						}

					break;
					case 3:
					echo "Badminton -";
						$sports_level .= "$row->Level";
						switch($sports_level){
						case 1:
						echo "Amateur";
						break;
						case 2:
						echo "Challenger";
						break;
						case 3:
						echo "Master";
						break;
						default:
					    echo "";
						}

					break;
					case 4:
					echo "Golf -";
						$sports_level .= "$row->Level";
						switch($sports_level){
						case 1:
						echo "Amateur";
						break;
						case 2:
						echo "Challenger";
						break;
						case 3:
						echo "Master";
						break;
						default:
					    echo "";
						}
					break;
					case 5:
					echo "RacquetBall -";
						$sports_level .= "$row->Level";
						switch($sports_level){
						case 1:
						echo "Amateur";
						break;
						case 2:
						echo "Challenger";
						break;
						case 3:
						echo "Master";
						break;
						default:
					    echo "";
						}
					break;
					case 6:
					echo "Squash -";
						$sports_level .= "$row->Level";
						switch($sports_level){
						case 1:
						echo "Amateur";
						break;
						case 2:
						echo "Challenger";
						break;
						case 3:
						echo "Master";
						break;
						default:
					    echo "";
						}
					break;
					default:
					echo "";
					}

						//if(++$i != $intrests_count) {
							//$sports_in .= ",";
						//}
				}
				
			}
			else {
					
			}
	   }*/

	//print_r($sports_in);
	//exit;
	?>