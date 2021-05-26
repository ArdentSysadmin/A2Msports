



<div class="tab-content">
<table class="tab-score">
				<?php 
				if(count($query) == 0)
				{
					?>
				<tr>
				<td><h5>No Search Members Found.</h5></td>
				</tr>
				<?php
				}
				else
				{
				foreach($query as $row){ ?><!-- img-djoko -->
				<tr>
				<td>
				<a href="#"><img class="scale_image" src="<?php echo base_url(); ?>profile_pictures/<?php if($row->Profilepic!=''){ echo $row->Profilepic; } else { echo "default-profile.png"; } ?>" alt="img" width="150px" height="250px" /></a>
				</td>
				<td width="90%" style="vertical-align:top;">
				&nbsp;&nbsp;<a href="<?php echo base_url();?>player/<?php echo $row->Users_ID;?>"><?php echo $row->Firstname.' '.$row->Lastname; ?></a><br />
				&nbsp;

				Interested Sports: 

				<?php 
				$get_data = academy::get_details($row->Users_ID);
				//print_r($get_data);
				$numItems = count($get_data);
				$i = 0;
				if($numItems > 0)
				{
				foreach($get_data as $r){

				$sport = $r->Sport_id;

				switch ($sport){
				case 1:
				echo "Tennis";
				break;
				case 2:
				echo "Table Tennis";
				break;
				case 3:
				echo "Badminton";
				break;
				case 4:
				echo "Golf";
				break;
				case 5:
				echo "RacquetBall";
				break;
				case 6:
				echo "Squash";
				break;
				default:
				echo "";
				}

				if(++$i != $numItems) {
				echo ", ";
				} }	}
				?>
				<br>&nbsp;

				Location: 

				<?php 
				if($row->City != "")
				{
				echo $row->City.", ".$row->State."<br>&nbsp;"; 
				}
				if($row->Country != "")
				{
				$row->Country; 
				}
				?>


				Age Group: 
				<?php 
				if($row->UserAgegroup != "")
				{
				echo $row->UserAgegroup; 
				}
				?>

				<br> &nbsp;

				A2M Score: 
				<?php 
					$get_data = academy::get_details($row->Users_ID);			
					 foreach($get_data as $r) { 
						$sport = $r->Sport_id;
						$get_sp_name = academy::get_sport($sport);
						$user_id = $row->Users_ID;
						$user_a2mscore = $this->model_academy->get_a2msocre($sport,$user_id);
						if($user_a2mscore != ""){
						echo  $get_sp_name['Sportname'] . " - " . $user_a2mscore['A2MScore'] . "" ."<br />";
						echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
						}
					 }

				?></td>
				 </tr>

					<?php } }?>
</table>
</div>