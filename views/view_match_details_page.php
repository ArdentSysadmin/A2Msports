<!--Load Script and Stylesheet -->
<script type="text/javascript" src="<?php echo base_url();?>js/jquery.simple-dtpicker.js"></script>
<link type="text/css" href="<?php echo base_url();?>css/jquery.simple-dtpicker.css" rel="stylesheet" />

<script>
$(document).ready(function(){
	
$("#edit").click(function(){
	$("#mes").show();
	$("#mes1").hide();
	$("#edit").hide();
	$("#update").show();
	$("#cancel").show();
	$("#date").hide();
	$("#edit_date").show();
});

$("#cancel").click(function(){
	$("#mes").hide();
	$("#mes1").show();
	$("#edit").show();
	$("#update").hide();
	$("#cancel").hide();
	$("#edit_date").hide();
	$("#date").show();
});

	
	//jQuery('#datetimepicker2').datetimepicker({
	//datepicker:false,
	 ///format:'H:i'
//});
 });
</script>

<script>
$(document).ready(function(){
	$('body').on('focus',".datepicker", function(){
	$(this).datepicker();
	});
});

</script>
	<section id="single_player" class="container secondary-page">

	<div class="top-score-title right-score col-md-9">
        <!-- start main body -->
		<h3></h3>
		<?php
		if($match_det)
		{ 
		?>
		<form class="form-horizontal" id='myform' method='post' role="form"  action="<?php echo base_url(); ?>play/register/<?php echo $match_det['GeneralMatch_id'] ;?>"> 

			<input type="hidden" name="id" value="<?php echo $match_det['GeneralMatch_id'];?>" /> 

		  <div class="col-md-12 league-form-bg">

           		<div class="fromtitle"><?php echo $match_det['Match_Title']; ?></div>

                <div class="col-md-12">
                   <div class="col-md-4">
						<?php $match_init_name = play::get_user($match_det['users_id']);?>
                   		
						<img class="img-djoko" src="<?php echo base_url(); ?>profile_pictures/<?php if($match_init_name['Profilepic']!=""){echo $match_init_name['Profilepic']; } else { echo "default-profile.png";}?>" alt="" width="165px" height="184px" />
                    </div>
                    
                    <div class="col-md-8">
                        
						<div class='form-group internal' style="font-size:16px; color:#ff8a00; font-weight:bold; padding-bottom:10px">
						<b>Match Initiator :</b> <?php $match_init_name = play::get_user($match_det['users_id']);
							 echo $match_init_name['Firstname']." ".$match_init_name['Lastname'];?>
						</div>


                        <div class='form-group internal' style="line-height:26px">
                            <b>Sport :</b> 
							 <?php $sport_name = play::get_sport($match_det['Sports']);
							 echo $sport_name['Sportname'];?>
                        </div>
						
					<div class='form-group internal' style="line-height:26px">
                       	
					<b>Match Dates :</b><span id="date"><?php //$date =  date("m-d-Y",strtotime($match_det['Match_Date'])); echo $date;//if($sp_level == $row->SportsLevel_ID){ echo "selected=selected"; } ?>
						  
						<?php if($match_det['Match_Date'] != ""){ 
						
						$split_date = explode(" ",$match_det['Match_Date']);
						$date0 = ($split_date[1] != "00:00:00.000") ?
						 date("m-d-Y h:i A", strtotime($match_det['Match_Date'])) : date("m-d-Y", strtotime($match_det['Match_Date']));
						
						echo "<br>".$date0;
						}?><br />

						<?php if($match_det['Match_Date2'] != ""){ 
						
						$split_date = explode(" ",$match_det['Match_Date2']);
						$date1 = ($split_date[1] != "00:00:00.000") ?
						 date("m-d-Y h:i A", strtotime($match_det['Match_Date2'])) : date("m-d-Y", strtotime($match_det['Match_Date2']));
						
						echo $date1; 
						}?><br /> 
						<?php if($match_det['Match_Date3'] != ""){ 
					
						$split_date = explode(" ",$match_det['Match_Date3']);
						$date2 = ($split_date[1] != "00:00:00.000") ?
						 date("m-d-Y h:i A", strtotime($match_det['Match_Date3'])) : date("m-d-Y", strtotime($match_det['Match_Date3']));

						echo $date2; 
						}?><br /> 
					</span>

					<span id="edit_date" style="display:none;"><br />
						<?php if($match_det['Match_Date'] != ""){ 
				
						$split_date = explode(" ",$match_det['Match_Date']);
						if($split_date[1] != "00:00:00.000"){
							$hr = date("h", strtotime($match_det['Match_Date']));
							$min = date("i", strtotime($match_det['Match_Date']));
							$am = date("A", strtotime($match_det['Match_Date']));
						} else { $hr = $min = $am = ""; }
						?>

					<div class='col-md-4 form-group internal' > 
					 <input  type="text" class='form-control datepicker' id="" name="match_date" value="<?php echo date("m/d/Y",strtotime($match_det['Match_Date']));?>" placeholder="MM/DD/YYYY" />
					 </div>

					 <div class='col-md-3 form-group internal'>
						<select name='match_time_hr'  class='form-control'>
						<option value=''>HH</option>
							<?php for($j=1; $j<13; $j++){
							$st = "";
							$hh = ($j<10) ? "0".$j : $j;
							if($hh == $hr){ $st = "selected"; }
							echo "<option value='$hh' $st>$hh</option>";
							} ?>
						</select>
						</div>
						<div class='col-md-3 form-group internal'>
						<select name='match_time_mm' class='form-control'>
							<option value="">MM</option>
							<?php for($k=0; $k<60; ($k += 5)){
							$st ="";
							$mm = ($k<10) ? "0".$k : $k;
							if($mm == $min){ $st = "selected"; }
							echo "<option value='$mm' $st>$mm</option>";
							}?>	
						</select>
						</div>
						<div class='col-md-3 form-group internal'>
						<select name='match_time_am'  class='form-control'>
							<option value='AM' <?php if ($am == "AM") echo 'selected' ; ?> >AM</option>
							<option value='PM' <?php if ($am == "PM") echo 'selected' ; ?> >PM</option>
						</select>
					</div>
						<?php } ?>

						<?php if($match_det['Match_Date2'] != ""){ 
						
						$split_date = explode(" ",$match_det['Match_Date2']);
						if($split_date[1] != "00:00:00.000"){
							$hr = date("h", strtotime($match_det['Match_Date2']));
							$min = date("i", strtotime($match_det['Match_Date2']));
							$am = date("A", strtotime($match_det['Match_Date2']));
						} else { $hr = $min = $am = ""; }
						?>

					<div class='col-md-4 form-group internal' > 
					 <input  type="text" class='form-control datepicker' id="" name="match_date1" value="<?php echo date("m/d/Y",strtotime($match_det['Match_Date2']));?>" placeholder="MM/DD/YYYY" />
					 </div>

					 <div class='col-md-3 form-group internal'>
						<select name='match_time_hr1'  class='form-control'>
							<option value=''>HH</option>
							<?php for($j=1; $j<13; $j++){
							$st = "";
							$hh = ($j<10) ? "0".$j : $j;
							if($hh == $hr){ $st = "selected"; }
							echo "<option value='$hh' $st>$hh</option>";
							} ?>
						</select>
						</div>
						<div class='col-md-3 form-group internal'>
						<select name='match_time_mm1' class='form-control'>
							<option value='00'>MM</option>
							<?php for($k=0; $k<60; ($k += 5)){
							$st ="";
							$mm = ($k<10) ? "0".$k : $k;
							if($mm == $min){ $st = "selected"; }
							echo "<option value='$mm' $st>$mm</option>";
							}?>	
						</select>
						</div>
						<div class='col-md-3 form-group internal'>
						<select name='match_time_am1'  class='form-control'>
							<option value='AM' <?php if ($am == "AM") echo 'selected' ; ?> >AM</option>
							<option value='PM' <?php if ($am == "PM") echo 'selected' ; ?> >PM</option>
						</select>
					</div>
						<?php } ?>

						<?php if($match_det['Match_Date3'] != ""){ 

						$split_date = explode(" ",$match_det['Match_Date3']);
						if($split_date[1] != "00:00:00.000"){
							$hr = date("h", strtotime($match_det['Match_Date3']));
							$min = date("i", strtotime($match_det['Match_Date3']));
							$am = date("A", strtotime($match_det['Match_Date3']));
						} else { $hr = $min = $am = ""; }
						?>

					<div class='col-md-4 form-group internal' > 
					 <input  type="text" class='form-control datepicker' id="" name="match_date2" value="<?php echo date("m/d/Y",strtotime($match_det['Match_Date3']));?>" placeholder="MM/DD/YYYY" />
					 </div>

					 <div class='col-md-3 form-group internal'>
						<select name='match_time_hr2'  class='form-control'>
							<option value=''>HH</option>
							<?php for($j=1; $j<13; $j++){
							$st = "";
							$hh = ($j<10) ? "0".$j : $j;
							if($hh == $hr){ $st = "selected"; }
							echo "<option value='$hh' $st>$hh</option>";
							} ?>
						</select>
						</div>
						<div class='col-md-3 form-group internal'>
						<select name='match_time_mm2' class='form-control'>
							<option value='00'>MM</option>
							<?php for($k=0; $k<60; ($k += 5)){
							$st ="";
							$mm = ($k<10) ? "0".$k : $k;
							if($mm == $min){ $st = "selected"; }
							echo "<option value='$mm' $st>$mm</option>";
							}?>	
						</select>
						</div>
						<div class='col-md-3 form-group internal'>
						<select name='match_time_am2'  class='form-control'>
							<option value='AM' <?php if ($am == "AM") echo 'selected' ; ?> >AM</option>
							<option value='PM' <?php if ($am == "PM") echo 'selected' ; ?> >PM</option>
						</select>
					</div>
						<?php } ?>
						
					</span>

                        </div>
						
                        <div class=' form-group internal' style="line-height:26px">
                        	<b>Description :</b>
                            <span id="mes1"><?php echo $match_det['Message']; ?></span>
							<textarea name="mes" id="mes" rows="4" cols="50" style="display:none;"><?php echo $match_det['Message']; ?></textarea>
                        </div>
                        
						<?php if($match_det['users_id'] == $this->session->userdata('users_id')){ ?> 
						
						<input type="button" id="edit" value="EDIT" class="league-form-submit1" style="margin:20px 0px">
						
						<?php } else { ?>
						
						<a href="<?php echo base_url();?>play/register/<?php echo $match_det['GeneralMatch_id'];?>"><input name="match" type="submit" value="Register" class="league-form-submit1" style="margin:20px 0px"/></a>

						<?php } ?>

						<input type="submit" id="update" name="update"  value="UPDATE" class="league-form-submit1" style="margin:20px 0px;display:none;"/>

						<input type="button" id="cancel" name="cancel"  value="CANCEL" class="league-form-submit1" style="margin:20px 0px;display:none;"/>


                    </div>
                
                
                   
               </div>
        </div>

		</form>

		
<?php 
}
else
{ 
?>
	<p style="line-height:20px; font-size:13px"><h5>Oops! Invalid Access. Please contact admin@a2msports.com</h5></p>
<?php
}
?>
             
   </div><!--Close Top Match-->
