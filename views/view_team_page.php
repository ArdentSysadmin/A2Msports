<link href="<?php echo base_url();?>css/teamprofile.css" rel="stylesheet" type="text/css" />
<script>
$(document).ready(function(){
var baseurl = "<?php echo base_url();?>";

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

<!-- Team Profile Begin -->


      <header class="teamtitle">
        <h1>Team Profile</h1>
      </header>

    <section class="topbar">
      <section class="head">
	  <?php 
$filename	 =  "C:\inetpub\wwwroot\a2msportssite\\team_logos\cropped\\".$team_info['Team_Logo'];
$filename1 =  "C:\inetpub\wwwroot\a2msportssite\\team_logos\\".$team_info['Team_Logo'];

if(file_exists($filename) and $team_info['Team_Logo']){ ?>
<img  src="<?php echo base_url(); ?>team_logos/cropped/<?php if($team_info['Team_Logo'] != ""){ echo $team_info['Team_Logo']; } else { echo "&nbsp;";}?>" />
<?php }
else if(file_exists($filename1) and $team_info['Team_Logo']){ ?>
<img  src="<?php echo base_url(); ?>team_logos/<?php if($team_info['Team_Logo'] != ""){ echo $team_info['Team_Logo']; } else { echo "&nbsp;";}?>" />
<?php } else { ?>
<img  src="<?php echo base_url(); ?>team_logos/<?php echo "default_team_logo.png"; ?>" />
<?php }  ?>
<?php
$team_members = json_decode($team_info['Players'], TRUE);
$team_members[] = $team_info['Created_by'];
if(!in_array($this->logged_user, $team_members)){
?>
        <button class='jteam' id='<?=$team_info['Team_ID'];?>'>Request to JOIN</button>
		<br />
		<span id="jt_status" style="display:none;color:red;font-weight:bold;"></span>
<?php
}
?>
      </section>
      <section class="desc">
        <div class="descriptor">
          <h2>Name</h2>
          <h4><?=$team_info['Team_name'];?></h4>
        </div>
        <div class="descriptor">
		<?php
		$home_loc = teams :: get_home_location($team_info['Team_ID']);
		?>
          <h2>Location</h2>
          <h4><?=$home_loc['hcl_city'].", ".$home_loc['hcl_state'];?></h4>
        </div>
        <div class="descriptor">
          <h2>Wins - Losses</h2>
          <h4><?=$team_stats['wins'] . " - " . $team_stats['loss']; ?></h4>
        </div>
      </section>
    </section>

<article class="coaches">
  <h1>Captain</h1>
    <section class="coachgrid">
	<?php
	$captain = teams :: get_username($team_info['Captain']);
$filename =  "C:\inetpub\wwwroot\a2msportssite\profile_pictures\thumbs\'".$captain['Profilepic'];
?>

<div class="person">
<?php
if(file_exists($filename)){
?>
<img  src="<?php echo base_url(); ?>profile_pictures/thumbs/<?php if($captain['Profilepic']!=""){ echo $captain['Profilepic']; } else { echo "&nbsp;";}?>" />
<?php } else { ?>
<img  src="<?php echo base_url(); ?>profile_pictures/<?php if($captain['Profilepic']!=""){ echo $captain['Profilepic']; } else { echo "default-profile-square.jpg";}?>" />
<?php } ?>
<div>

	   <a href="#"><?=$captain['Firstname']." ".$captain['Lastname']; ?></a>
	</div>
</div>

      <section>
  </article>

<article class="players">
  <h1>Team Members</h1>
    <section class="playergrid">
	<?php
	if($team_info['Players']){
	$players = json_decode($team_info['Players'], TRUE);
		foreach($players as $pl){
			$player = teams :: get_username($pl);
	?>
		<div class="person">
<?php 
$filename =  "C:\inetpub\wwwroot\a2msportssite\profile_pictures\thumbs\'".$player['Profilepic'];
//$filename1 = "C:\inetpub\wwwroot\a2msportssite\profile_pictures\'".$player['Profilepic'];

if(file_exists($filename)){ ?>
<img  src="<?php echo base_url(); ?>profile_pictures/thumbs/<?php if($player['Profilepic']!=""){echo $player['Profilepic']; } else { echo "&nbsp;";}?>" />
<?php } else { ?>
<img  src="<?php echo base_url(); ?>profile_pictures/<?php if($player['Profilepic']!=""){echo $player['Profilepic']; } else { echo "default-profile-square.jpg";}?>" />
<?php } ?>
			<div>
				<a href="#"><?=$player['Firstname']." ".$player['Lastname']; ?></a>
			</div>
		</div>
	<?php
		}
	}
	?>
   <section>
  </article>
  
    <!-- Team Profile Ending -->