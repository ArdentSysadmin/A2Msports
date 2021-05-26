<section id="single_player" class="container secondary-page">
    <div class="top-score-title right-score col-md-9">
               <br />
				 <!-- <h3></h3> -->


						
			<!-- Coaches section start-->
			<div class="col-md-12 league-form-bg"  style="margin-top:40px; background:#fff; margin-bottom:20px">

				    <div class="fromtitle">Search for Coaches</div>

					<form method="post" id="coach_form"  action="<?php echo base_url().$org_details['Url_Shortcode'];?>/search_coaches"> 

							<div class='col-md-3 form-group internal' style="padding-left:0px">
								<input class='form-control' id='' name='coach_name' type='text' placeholder="Coach Name" value="<?php echo $coach_name; ?>" />
							</div>

							<div class='col-md-3 form-group internal' style="padding-left:0px">
								<?php
								$sport = "";
								if($this->input->post('coach_sport')){
								$sport = $this->input->post('coach_sport');
								}
								?>
								<select name="coach_sport"  id="coach_sport" class='form-control'>
								<option value="">Coach Sport</option>
								<option value="1" <?php if($sport=="1"){ echo "selected=selected"; } ?>>Tennis</option>
								<option value="2" <?php if($sport=="2"){ echo "selected=selected"; } ?>>Table Tennis</option>
								<option value="3" <?php if($sport=="3"){ echo "selected=selected"; } ?>>Badminton</option>
								<option value="4" <?php if($sport=="4"){ echo "selected=selected"; } ?>>Golf</option>
								<option value="5" <?php if($sport=="5"){ echo "selected=selected"; } ?>>Racquetball</option>
								<option value="6" <?php if($sport=="6"){ echo "selected=selected"; } ?>>Squash</option>
								</select>
							</div>

							<div class='col-md-3 form-group internal' style="padding-left:0px">
								<?php
								$range = "";
								if($this->input->post('coach_range')){
								$range = $this->input->post('coach_range');
								}
								?>

								<select name="coach_range"  id="coach_range" class='form-control'>
								<option value="" <?php if($range==""){ echo "selected=selected"; } ?>>Distance</option>
								<option value="10" <?php if($range=="10"){ echo "selected=selected"; } ?>>10Miles</option>
								<option value="20" <?php if($range=="20"){ echo "selected=selected"; } ?>>20Miles</option>
								<option value="30" <?php if($range=="30"){ echo "selected=selected"; } ?>>30Miles</option>
								<option value="40" <?php if($range=="40"){ echo "selected=selected"; } ?>>40Miles</option>
								<option value="50" <?php if($range=="50"){ echo "selected=selected"; } ?>>50Miles</option>
								</select>

							</div>

							<input class='form-control'  name='org_id' id='org_id' type='hidden' value="<?php echo $org_details['Org_ID'];?>"  />

							<div id="register-submit" class="col-md-2 form-group internal" style="padding-left:0px">
							<input type="submit" name="coach_mem" value=" Search " />
							</div>

							</form>

							<div class="clear"></div>


							<div class="tab-content">
							<table class="tab-score">
							<?php 
							if(count($coaches_list) == 0)
							{
								?>
							<tr>
							<td><h5>No Coach Members Found.</h5></td>
							</tr>
							<?php
							}
							else
							{

							foreach($coaches_list as $row){ ?><!-- img-djoko -->
							<tr>
							<td>
							<a href="#"><img class="scale_image" src="<?php echo base_url(); ?>profile_pictures/<?php if($row->Profilepic!=''){ echo $row->Profilepic; } else { echo "default-profile.png"; } ?>" alt="img" width="150px" height="250px" /></a>
							</td>
							<td width="90%" style="vertical-align:top;">
							&nbsp;&nbsp;<a href="<?php echo base_url();?>player/<?php echo $row->Users_ID;?>"><?php echo $row->Firstname.' '.$row->Lastname; ?></a><br />
							&nbsp;

							<br>&nbsp;

							Sport: 
							<?php 
								$get = $this->model_academy->get_sport_title($row->coach_sport);
								echo $get['Sportname'] ."<br>&nbsp;";
							?>

							Location: 

							<?php 
							if($row->City != "")
							{
							echo $row->City.", ".$row->State."<br>&nbsp;"; 
							}
							?>

							Profile Description: 

							<?php 
							if($row->coach_profile != "")
							{
							echo $row->coach_profile; 
							}
							?>
							<br> &nbsp;

							Coach Website: 

							<?php
							if($row->Coach_Website != ""){
							 $check = "http";
							$pos = strpos($row->Coach_Website,$check);
							if($pos){ ?>
							 
							 <a target="_blank" href="<?php echo $row->Coach_Website;?>"><?php echo $row->Coach_Website;?></a> 
							 
							<?php } else { ?>
							 <a target="_blank" href="<?php echo "http://".$row->Coach_Website;?>"><?php echo $row->Coach_Website;?></a>  

							<?php } 
							} ?>

							<br> &nbsp;

							</td>
							</tr>

							<?php } }?>
							</table>
							</div>

					</div>


		</div>



	</div>