  <script>
 /* ------------------------- Collapse and Expand in Participants ---------------------- */
$("#teams_ajax_div .header").on('click', function() {
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

$("#mtdiv .header").on('click', function() {
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
 $(document).ready(function(){
  //  $('#teams_table1').DataTable();

	var baseurl = "<?php echo base_url();?>";

	$('.jteam').click(function (e) {
		var a_class = $(this).attr('class');
	
		if(a_class.indexOf('disabled') != -1){
			e.preventDefault();
			return false;
		}

		var tid = $(this).attr('id');

		$('a.jteam#'+tid).html('Please wait...');
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
					$('a.jteam#'+tid).html('Request Sent');
					$('a.jteam#'+tid).addClass('disabled');
				}
			}
			});
		e.preventDefault();
	});

	$(".mteam").click(function(e){
	var tid = $(this).attr('id');
	//alert("Manage Team ID Is :: "+tid);

		$.ajax({
		type: 'POST',
		url: baseurl+'teams/manageTeam',
		data: {teamId:tid},
		success: function(res) {
			//alert(res);
			$('#mtdiv').html(res);
			$('#mtdiv').show();

			$('html, body').animate({
			scrollTop: ($('#mtdiv').offset().top)
			},500);
		}
		});
	e.preventDefault();
 	/*if($('#team_'+tid).css('display') == 'none'){
		$('#team_'+tid).show();
	}
	else{	
		$('#team_'+tid).hide(); 
	} */
//$('#team_'+tid).show();

	}); 


	$('.wteam').click(function (e) {
	var tid = $(this).attr('id');
		$.ajax({
		type: 'POST',
		url: baseurl+'teams/withdraw',
		data: {tid:tid},
		success: function(res){
			if(res==1)
			{
				alert('Withdrawn completed!');
			    location.reload();

				/*$('#wr_status').fadeOut();
				$('#wr_status').html('Withdrawn completed!');
				$('#wr_status').fadeIn(); */
			}
		}
		});
	e.preventDefault();
	});

});
	</script>

	<span id='jteam_status' style='display:none;color:red;font-weight:bold;'></span>
	<div class="col-md-12 tab-content table-responsive container2">
		<table class="tab-score" id="teams_table1">
		<thead>
			<tr class="top-scrore-table">
				<td class="score-position">Team Name</td>
				<td class="score-position">City</td>
				<td class="score-position">State</td>
				<?php if($this->logged_user){ ?>
				<td class="score-position">Action</td>
				<?php } ?>
  			</tr>
		</thead>  

		<?php
		$count = count($teams_result);
		if($count){
			$i = 1;

		/*	echo "<pre>";
			print_r($teams_result);*/

  	 	foreach($teams_result as $unp){?>
			<tr>
			<!-- <td style="text-align:center"><?php echo $i;?></td> -->
			<td style="padding-left:3px;">
			<div>
			<?php if($unp->Team_Logo != NULL || $unp->Team_Logo != ""){
				$team_logo = "<img style='width:45px;height:40px' src='".base_url()."/team_logos/cropped/$unp->Team_Logo' alt=''>";
			 }
			 else{ 
				$team_logo = "<img style='width:45px;height:40px' src='".base_url()."/team_logos/default_team_logo.png' alt=''>";
			 } 
			?>
			</div>
			<?php
			$get_sport = league::get_sport($unp->Sport);

			echo "<div class='header' id='dis_tm_".$unp->Team_ID."'>$team_logo&nbsp;<span style='color:#03508c;font-size:13px;font-weight:400;'>".$unp->Team_name."&nbsp;&nbsp;&nbsp; </span></div><div class='content'><ul>";

			$team_players = json_decode($unp->Players, true);

			$data['team_id']	  = $unp->Team_ID;
			$data['team_name']	  = $unp->Team_name;
			$data['team_captain'] = $unp->Captain;
			$data['team_players'] = $team_players;
			$data['team_logo']	  = $unp->Team_Logo;
			$data['Sport']		  = $unp->Sport;

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
				<a href='".base_url()."player/".$player['Users_ID']."' target='_blank'>".ucfirst($player['Firstname'])." ".ucfirst($player['Lastname'])."</a> ".$gender."&nbsp;{$captain_ico}</li>";
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
			<?php
			if($this->logged_user){
			?>
			<td style="text-align:center">
				<!-- <div><a class='jteam' id='<?=$unp->Team_ID;?>' style="cursor:pointer">JOIN</a></div> --> 
				<?php //echo "<pre>"; echo $unp->Created_by;   echo $this->logged_user;
					if($this->logged_user == $unp->Created_by){
					?>
					<div> <a class='mteam' id='<?=$unp->Team_ID;?>' style="cursor:pointer">Manage Team</a>  </div>
					<?php }else if(in_array($this->logged_user, $team_players)){?>  
					<div><a class='wteam' id='<?=$unp->Team_ID;?>' style="cursor:pointer">WithDraw</a></div>
					<?php }else{?>
					<div><a class='jteam' id='<?=$unp->Team_ID;?>' style="cursor:pointer">JOIN</a></div> 
					<?php } ?> 
			</td>
			<?php
			} ?>
			</tr>

			<?php //if($this->logged_user == $unp->Created_by){ ?>
			  <!-- <tr id='team_<?=$unp->Team_ID;?>' style='display:none;'>
				<td colspan='4'>
				<?php //echo $this->load->view("teams/view_manage_team_2", $data); ?>
				</td>
			</tr>   --> 
			<?php //} ?>

		<?php $i++; } }
		else{  ?>
			<tr >
				<td style="text-align:center"><b> No Teams Found.</b></td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
			</tr>
		<?php
		}
		 ?>
		  </table>
	</div>

	<div id="mtdiv" class="col-md-12 tab-content table-responsive container2"></div>
				
	<?php if($this->logged_user){ ?>
		<script>
		$(document).ready(function(){
			$('#teams_table1').dataTable({dom: "<'row'<'col-sm-3'l><'col-sm-6'p><'col-sm-3'f>>" +
			"<'row'<'col-sm-12'tr>>", searching: true, paging: true, lengthMenu: [[10, 25], [10, 25]],  "columns": [ null, null, null, null ], language: {"search":"", "searchPlaceholder":"Search"}, columnDefs: [{ orderable: false, targets:  "no-sort"}] }); 
		});
		</script>
	<?php
	}
	else{
	?>
	<script>
		$(document).ready(function(){
			$('#teams_table1').dataTable({dom: "<'row'<'col-sm-3'l><'col-sm-6'p><'col-sm-3'f>>" +
			"<'row'<'col-sm-12'tr>>", searching: true, paging: true, lengthMenu: [[10, 25], [10, 25]],  "columns": [ null, null, null ], language: {"search":"", "searchPlaceholder":"Search"} }); 
		});
		</script>
	<?php } ?>