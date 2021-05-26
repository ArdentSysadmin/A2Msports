<script>
$(document).ready(function(){

var baseurl = "<?php echo base_url();?>";
	
	$('#user_sport').on('change',function(){
	
         // var SportID = $(this).val();
		  var SportID  = $( "#user_sport option:selected" ).val();
		
       // if(SportID!=""){
		
            $.ajax({
                type:'POST',
                url:baseurl+'academy/Sport_levels/',
                data:'sport_id='+SportID,
                success:function(html){
                    $('#sport_levels_div').html(html);
                }
            }); 
        //}
		
    }); 
});
</script>




<section id="single_player" class="container secondary-page">
    <div class="top-score-title right-score col-md-9">
               <br />
				 <!-- <h3></h3> -->


						
			<!-- Coaches section start-->
			<div class="col-md-12 league-form-bg"  style="margin-top:40px; background:#fff; margin-bottom:20px">

				    <div class="fromtitle">Search for Members</div>

					<form method="post" id="coach_form"  action="<?php echo base_url().$org_details['Url_Shortcode'];?>/search_members"> 

							<div class='col-md-3 form-group internal' style="padding-left:0px">
								<input class='form-control' id='name' name='name' type='text' placeholder="Player Name" value="<?php echo $search_fname; ?>"  size="25" />
							</div>

							<div class='col-md-2 form-group internal' style="padding-left:0px">
								<?php
								$sport = "";
								if($this->input->post('user_sport')){
								$sport = $this->input->post('user_sport');
								}
								?>
								<select name="user_sport"  id="user_sport" class='form-control'>
								<option value="">Sport</option>
								<option value="1" <?php if($sport=="1"){ echo "selected=selected"; } ?>>Tennis</option>
								<option value="2" <?php if($sport=="2"){ echo "selected=selected"; } ?>>Table Tennis</option>
								<option value="3" <?php if($sport=="3"){ echo "selected=selected"; } ?>>Badminton</option>
								<option value="4" <?php if($sport=="4"){ echo "selected=selected"; } ?>>Golf</option>
								<option value="5" <?php if($sport=="5"){ echo "selected=selected"; } ?>>Racquetball</option>
								<option value="6" <?php if($sport=="6"){ echo "selected=selected"; } ?>>Squash</option>
								</select>

							</div>

							<div id='sport_levels_div' class='col-md-3 form-group internal'>

								<?php
									$sp_level = "";
									if($this->input->post('level'))	{
									$sp_level = $this->input->post('level');
									}
								?>
								<select name="level" id="level" class='form-control'>
								<option value="">Level</option>
								<?php foreach($sport_levels as $row){ ?>
								<option value="<?php echo $row->SportsLevel_ID;?>" <?php if($sp_level == $row->SportsLevel_ID){ echo "selected=selected"; } ?>>
								<?php  echo $row->SportsLevel; ?> 
								</option>
								<?php } ?>
								</select>
							</div>
							
							<div class='col-md-2 form-group internal' style="padding-left:0px">
							<?php
							$range = "";
							if($this->input->post('range'))	{
							$range = $this->input->post('range');
							}
							?>

							<select name="range"  id="range" class='form-control'>
							<option value="" <?php if($range==""){ echo "selected=selected"; } ?>>Distance</option>
							<option value="10" <?php if($range=="10"){ echo "selected=selected"; } ?>>10miles</option>
							<option value="20" <?php if($range=="20"){ echo "selected=selected"; } ?>>20miles</option>
							<option value="30" <?php if($range=="30"){ echo "selected=selected"; } ?>>30miles</option>
							<option value="40" <?php if($range=="40"){ echo "selected=selected"; } ?>>40miles</option>
							<option value="50" <?php if($range=="50"){ echo "selected=selected"; } ?>>50miles</option>
							</select>

							</div>


							<input class='form-control'  name='org_id' id='org_id' type='hidden' value="<?php echo $org_details['Org_ID'];?>"  />

							<div id="register-submit" class="col-md-2 form-group internal" style="padding-left:0px">
							<input type="submit"  class="league-form-submit1" name="search_mem" value=" Search " />
							</div>

							<input type="checkbox" id="academy_status"  name="academy_status"  checked  value="1"> Show results only from <?php echo $org_details['Org_name']; ?> 

							</form>

							<div class="clear"></div>
							
							<!-- -------search -----results --------------- -->
				
							<div class="tab-content">
							<table class="tab-score">
							<?php 
							if(count($query) == 0)
							{
								?>
							<tr>
							<td><h5>No Academy Members Found.</h5></td>
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

							<br>&nbsp;

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

					</div>


		</div>



	</div>