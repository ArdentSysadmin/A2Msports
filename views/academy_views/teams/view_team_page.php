<script>
$(document).ready(function(){

$(".mteam").click(function(){
	var tid = $(this).attr('id');
	/*if(!$('#team_'+tid).css('display') == 'none'){
		$('#team_'+tid).show();
	}
	else{	
		$('#team_'+tid).hide(); 
	}*/
$('#team_'+tid).show();

});

/* ------------------------- Collapse and Expand in Participants ---------------------- */
$(".header").click(function() {
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


var baseurl = "<?php echo base_url();?>";

	$('.upd_players').click(function (e) {
	var tid = $(this).attr('id');
		$.ajax({
		type: 'POST',
		url: baseurl+'teams/update',
		data: $('#frm_manage_team_'+tid).serialize(),
		success: function () {
		   location.reload();
		}
		});
	e.preventDefault();
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
				$('#wr_status').fadeOut();
				$('#wr_status').html('A Withdraw notification has been sent to the Captain. Please wait for the response.');
				$('#wr_status').fadeIn();
			}
		}
		});
	e.preventDefault();
	});

	$('.jteam').click(function (e) {
	var tid = $(this).attr('id');
		$.ajax({
		type: 'POST',
		url: baseurl+'teams/join_req',
		data: {tid:tid},
		success: function(res){
			if(res==1)
			{
				$('#jt_status').fadeOut();
				$('#jt_status').html('A Join notification has been sent to the Captain. Please wait for the response.');
				$('#jt_status').fadeIn();
			}
		}
		});
	e.preventDefault();
	});

});
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


 <section id="single_player" class="container secondary-page">

   <div class="top-score-title right-score col-md-9">
   <div class="col-md-12 league-form-bg" style="margin-top:40px;">
		<div class="fromtitle">Create a Team</div>
		<p style="line-height:20px; font-size:13px">If you have a team, go ahead and create a team here.
		<?php if($this->session->userdata('user')=="") { ?>
		
		Please <b style="font-size:14px;"><a href='<?php echo base_url()."login"; ?>'>Login</a></b> to create a team.
		<?php } else { ?>
		<b style="font-size:14px;"><a href="<?php echo base_url()."teams/addnew"; ?>">Create a Team</a></b>
		<?php } ?>
		</p><br /> 
	</div>
	<?php 
	if($this->logged_user)
	{ ?>
   <div class="col-md-12 league-form-bg" style="margin-top:40px;">
		<div class="fromtitle">My Teams</div>
		<span id='wr_status' style='display:none;color:red;font-weight:bold;'></span>
		<div class="tab-content container2">
		<table class="tab-score">
		<?php 

		foreach($user_created as $uc){?>
		<tr>
			<!-- <a href='#'><b><?php //echo $uc->Team_name; ?></b></a> -->
			<td style="padding-left:3px;">
			<?php
			$get_sport = teams::get_sport($uc->Sport);

			echo "<div class='header'><span style='color:#03508c;font-size:13px;font-weight:400;'>".$uc->Team_name."&nbsp;&nbsp;&nbsp;(".$get_sport['Sportname'].")</span></div><div class='content'><ul>";

			$team_players = json_decode($uc->Players);

			$data['team_id']	  = $uc->Team_ID;
			$data['team_captain'] = $uc->Captain;
			$data['team_players'] = $team_players;

			foreach($team_players as $tp){
				$player = teams::get_username($tp);

				echo "<li style='padding-left:25px;padding-bottom:5px;list-style:none;'>
				<a href='".base_url()."player/".$player['Users_ID']."' target='_blank'>".$player['Firstname']." ".$player['Lastname']."</a>
				</li>";
			}

			echo "</ul></div>";
			?>
			</td>

			<td>
				<div>
				<?php $get_captain = teams::get_username($uc->Captain); 
				$captain_ico = "<img src='".base_url()."icons/letter_c.png' title='Captain' style='width:15px; height:15px;' />";
				echo "<a href='".base_url()."player/".$get_captain['Users_ID']."' target='_blank'>".$get_captain['Firstname']." ".$get_captain['Lastname']."</a>&nbsp;{$captain_ico}"; 
				?>
				</div>
			</td>

			<td style="padding-left:20px;">
				<div>
				<?php
				if($uc->Home_loc_id){
				$team_home_loc = teams::get_home_location($uc->Home_loc_id);

				$map_url = "https://www.google.co.in/maps/place/".$team_home_loc['hcl_address']."+".$team_home_loc['hcl_city']."+".$team_home_loc['hcl_state']."+".
						$team_home_loc['hcl_country'];

				echo "<a href='".$map_url."' title='".$team_home_loc['hcl_address'].", ".$team_home_loc['hcl_city'].", ".$team_home_loc['hcl_state'].", ".$team_home_loc['hcl_country']."' target='_blank'>".$team_home_loc['hcl_title']."</a>";
				}else{
				echo "< None >";
				}
				?>
				</div>
			</td>

			<td><div><a style="cursor:pointer;" class='mteam' id='<?=$uc->Team_ID;?>'>Manage Team</a></div></td>

		</tr>
		<tr id='team_<?=$uc->Team_ID;?>' style='display:none;'>
		<td colspan='4'>
			<?php echo $this->load->view("teams/view_manage_team", $data); ?>
		</td>
		</tr>
		<?php } ?>  <!-- Close of user created Teams -->

		<?php foreach($user_part as $up){?>
		<tr>
			<td style="padding-left:3px;">
			<?php
			$get_sport = teams::get_sport($up->Sport);

			echo "<div class='header'><span style='color:#03508c;font-size:13px;font-weight:400;'>".$up->Team_name."&nbsp;&nbsp;&nbsp;(".$get_sport['Sportname'].")</span></div><div class='content'><ul>";

			$team_players = json_decode($up->Players);

			$data['team_id']	  = $up->Team_ID;
			$data['team_captain'] = $up->Captain;
			$data['team_players'] = $team_players;

			foreach($team_players as $tp){
				$player = teams::get_username($tp);

				echo "<li style='padding-left:25px;padding-bottom:5px;list-style:none;'>
				<a href='".base_url()."player/".$player['Users_ID']."' target='_blank'>".$player['Firstname']." ".$player['Lastname']."</a>
				</li>";
			}

			echo "</ul></div>";
			?>
			</td>

			<td>
				<div>
				<?php
				$get_captain = teams::get_username($up->Captain);
				$captain_ico = "<img src='".base_url()."icons/letter_c.png' title='Captain' style='width:15px; height:15px;' />";

				echo "<a href='".base_url()."player/".$get_captain['Users_ID']."' target='_blank'>".$get_captain['Firstname']." ".$get_captain['Lastname']."</a>&nbsp;{$captain_ico}"; 
				?>
				</div>
			</td>

			<td style="padding-left:20px;">
				<div>
				<?php
				if($up->Home_loc_id){
				$team_home_loc = teams::get_home_location($up->Home_loc_id);

				$map_url = "https://www.google.co.in/maps/place/".$team_home_loc['hcl_address']."+".$team_home_loc['hcl_city']."+".$team_home_loc['hcl_state']."+".
						$team_home_loc['hcl_country'];

				echo "<a href='".$map_url."' title='".$team_home_loc['hcl_address'].", ".$team_home_loc['hcl_city'].", ".$team_home_loc['hcl_state'].", ".$team_home_loc['hcl_country']."' target='_blank'>".$team_home_loc['hcl_title']."</a>";
				}else{
				echo "< None >";
				}
				?>
				</div>
			</td>

			<td><div><a style="cursor:pointer;" class='wteam' id='<?=$up->Team_ID;?>'>Withdraw</a></div></td>

		</tr>
		<tr id='team_<?=$up->Team_ID;?>' style='display:none;'>
		<td colspan='4'>
			<?php echo $this->load->view("teams/view_manage_team", $data); ?>
		</td>
		</tr>

		<?php } ?>	<!-- Close of User Part in Teams -->


		</table>

		</div>
   </div>
<?php } ?>
   <!-- <div class="col-md-12 league-form-bg" style="margin-top:40px;">
		<div class="fromtitle">Create a Team</div>
		<?php //$this->load->view('teams/view_new_team'); ?>
   </div> --> 

	<?php 
	if($this->logged_user)
	{ ?>

   <div class="col-md-12 league-form-bg" style="margin-top:40px;">
		<div class="fromtitle">Nearby Teams</div>
		<span id='jt_status' style='display:none;color:red;font-weight:bold;'></span>
		<div class="tab-content container2">
		<table class="tab-score">
		<?php
		foreach($user_non_part as $unp){?>
			<tr>
			<td style="padding-left:3px;">
			<?php
			$get_sport = teams::get_sport($unp->Sport);

			echo "<div class='header'><span style='color:#03508c;font-size:13px;font-weight:400;'>".$unp->Team_name."&nbsp;&nbsp;&nbsp;(".$get_sport['Sportname'].")</span></div><div class='content'><ul>";

			$team_players = json_decode($unp->Players);

			$data['team_id']	  = $unp->Team_ID;
			$data['team_captain'] = $unp->Captain;
			$data['team_players'] = $team_players;

			foreach($team_players as $tp){
				$player = teams::get_username($tp);

				echo "<li style='padding-left:25px;padding-bottom:5px;list-style:none;'>
				<a href='".base_url()."player/".$player['Users_ID']."' target='_blank'>".$player['Firstname']." ".$player['Lastname']."</a>
				</li>";
			}

			echo "</ul></div>";
			?>
			</td>

			<td>
				<div>
				<?php $get_captain = teams::get_username($unp->Captain); 
				$captain_ico = "<img src='".base_url()."icons/letter_c.png' title='Captain' style='width:15px; height:15px;' />";
				echo "<a href='".base_url()."player/".$get_captain['Users_ID']."' target='_blank'>".$get_captain['Firstname']." ".$get_captain['Lastname']."</a>&nbsp;{$captain_ico}"; 
				?>
				</div>
			</td>

			<td style="padding-left:20px;">
				<div>
				<?php
				if($unp->Home_loc_id){
				$team_home_loc = teams::get_home_location($unp->Home_loc_id);

				$map_url = "https://www.google.co.in/maps/place/".$team_home_loc['hcl_address']."+".$team_home_loc['hcl_city']."+".$team_home_loc['hcl_state']."+".
						$team_home_loc['hcl_country'];

				echo "<a href='".$map_url."' title='".$team_home_loc['hcl_address'].", ".$team_home_loc['hcl_city'].", ".$team_home_loc['hcl_state'].", ".$team_home_loc['hcl_country']."' target='_blank'>".$team_home_loc['hcl_title']."</a>";
				}else{
				echo "< None >";
				}
				?>
				</div>
			</td>

			<td>
				<div><a class='jteam' id='<?=$unp->Team_ID;?>' style="cursor:pointer;">JOIN</a></div>
			</td>

			</tr>
		<?php } 
		 ?>
		</table>
   </div>
   </div>
   <?php } ?>
</div><!--Close Top Match-->