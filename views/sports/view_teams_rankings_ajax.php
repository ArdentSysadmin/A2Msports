  <script>
 /* ------------------------- Collapse and Expand in Participants ---------------------- */
$("#teams_rankings_ajax_div .header").on('click', function() {
//	alert('test');
    $header = $(this);
    //getting the next element
    $content = $header.next();
    //open up the content needed - toggle the slide- if visible, slide up, if not slidedown.
    $content.slideToggle(500, function () {
        //execute this after slideToggle is done
        //change text of header based on visibility of content div
        $header.text(function () {
            //change text based on condition
            //return $content.is(":visible") ? 'Text1' : 'Text2';
        });
    });
});
/* ------------------------- Collapse and Expand in Participants ---------------------- */
 </script>

 <style>
	.container2 .header {
		#background-color:#d3d3d3;
		padding: 2px;
		cursor: pointer;
		#font-weight: bold;
	}
	.container2 .content {
		display: none;
		padding : 5px;
	}
</style>
 
 <script>
    $('#teams_table').DataTable();

	$('.jteam').click(function (e) {
		var tid = $(this).attr('id');
			$.ajax({
			type: 'POST',
			url: baseurl+'teams/join_req',
			data: {tid:tid},
			success: function(res){
				if(res==1)
				{
					$('#jteam_status').fadeOut();
					$('#jteam_status').html('A Join notification has been sent to the Captain. Please wait for the response.');
					$('#jteam_status').fadeIn();
				}
			}
			});
		e.preventDefault();
	});
	</script>

	<span id='jteam_status' style='display:none;color:red;font-weight:bold;'></span>
	<div class="col-md-12 tab-content table-responsive container2">
		<table class="tab-score" id="teams_table">
		<thead>
			<tr class="top-scrore-table">
				<td class="score-position">Rank</td>
				<td class="score-position">Team Name</td>
				<!-- <td class="score-position">Team Captain</td> -->
				<!-- <td class="score-position">A2M TeamScore</td> -->
				<td class="score-position">City</td>
				<td class="score-position">State</td>
				<!-- <td class="score-position">Action</td> -->
  			</tr>
		</thead>  

		<?php
		$count = count($teams_result);
		if($count){
			$i = 1;
  	 	foreach($teams_result as $unp){?>
			<tr>
			<td style="text-align:center"><?php echo $i;?></td>
			<td style="padding-left:3px;">
			<div>
			<?php
			if($unp->Team_Logo != NULL and $unp->Team_Logo != ""){
				$team_logo = "<img style='width:45px;height:40px' src='".base_url()."team_logos/cropped/$unp->Team_Logo' alt=''>";
			}
			else{ 
				$team_logo = "<img style='width:45px;height:40px' src='".base_url()."team_logos/default_team_logo.png' alt=''>";
			}
			?>
			</div>
			<?php
			$get_sport = league::get_sport($unp->Sport);

			echo "<div class='header' id='dis_tm_".$uc->Team_ID."'>$team_logo&nbsp;<span style='color:#03508c;font-size:13px;font-weight:400;'>".ucfirst($unp->Team_name)."&nbsp;&nbsp;&nbsp; </span></div><div class='content'><ul>";

			$team_players = json_decode($unp->Players);

			$data['team_id']	  = $unp->Team_ID;
			$data['team_captain'] = $unp->Captain;
			$data['team_players'] = $team_players;
			$data['Sport']        = $unp->Sport;

  			foreach($team_players as $tp){
				$player = league::get_username($tp);
 				if($player['Gender'] == 1){
						$gender = "(M)";
				}
				else if($player['Gender'] == 0){
						$gender = "(F)";
				}

				$captain_ico = '';
				if($unp->Captain == $tp){
					$captain_ico = "<img src='".base_url()."icons/letter_c.png' title='Captain' style='width:15px; height:15px;' />";
				}
				echo "<li style='padding-left:25px;padding-bottom:5px;list-style:none;'>
				<a href='".base_url()."player/".$player['Users_ID']."' target='_blank'>".ucfirst($player['Firstname'])." ".ucfirst($player['Lastname'])."</a> ".$gender."</li>&nbsp;{$captain_ico}";
			}

			echo "</ul></div>";
			?>
			</td>

			<!-- <td>
				<div>
				<?php $get_captain = league::get_username($unp->Captain); 
				$captain_ico = "<img src='".base_url()."icons/letter_c.png' title='Captain' style='width:15px; height:15px;' />";
				echo "<a href='".base_url()."player/".$get_captain['Users_ID']."' target='_blank'>".ucfirst($get_captain['Firstname'])." ".ucfirst($get_captain['Lastname'])."</a>&nbsp;{$captain_ico}"; 
				?>
				</div>
			</td> -->
 			<!-- <td style="text-align:center"> 
				<div><?php echo $unp->A2MTeamScore;?></div>
			</td> -->
			<td>
				<div>
					<?php
					if($unp->hcl_city){
				 	  echo $unp->hcl_city;
	  				}else{
					echo "< None >";
					}
					?>
				</div>
			</td>

			<td> 
				<div>
					<?php
					if($unp->hcl_state){
				 		 echo $unp->hcl_state;
	  				}else{
					echo "< None >";
					}
					?>
				</div>
			</td>
 
			<!-- <td style="text-align:center">
				<div><a class='jteam' id='<?=$unp->Team_ID;?>' style="cursor:pointer">JOIN</a></div> 
			</td> -->

			</tr>
		<?php $i++;} 
		}
		else{  ?>
			<tr>
				<td colspan="8" style="text-align:center">
					<b> No Teams Found. </b>
				</td>
			</tr>
		<?php
		}
		 ?>
		  </table>
	</div>	