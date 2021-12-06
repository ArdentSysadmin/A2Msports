<script>
var club_baseurl = "<?php echo $this->config->item('club_form_url'); ?>";
</script>
<style>
 .course-item .course-body .course-desc {
    min-height: 70px;
	background:none;
}
 .course-item{
	border: 0px !important;
	background:none;
}
.club-rounded-circle1 {
    border-radius: 50%;
    width: 100% !important;
}
@media (max-width: 767px){
.course-item .course-body .course-desc {
    padding: 10px 10px;
    min-height: 60px;
}
}

div#events .course-item button { opacity:0; float:right }
div#events .course-item:hover button { opacity:1 }


.btn-default {
    color: #fff;
    background-color: #0b109f;
    border-color: #0b109f;
}
</style>

<!-- Breadcromb Wrapper Start -->
<!-- <div class="breadcromb-wrapper">
<div class="breadcromb-overlay"></div>
<div class="container">
<div class="row">
<div class="col-sm-12">
<div class="breadcromb-left">
<h3>Coaches</h3>
</div>
</div>
</div>
</div>
</div> -->
<!-- Breadcromb Wrapper End --> 
<section class="inner-page-wrapper">
<div class="container">
<div class="row">
<div class="col-md-12">
<div class="col-md-12" style="margin-top: 25px; margin-left: 0px; margin-bottom: 20px; ">
<h3 style="color:#0032af;">Coaches</h3>
</div>

<!-- Coaches section start-->


<!--<div class="fromtitle">Search for Coaches</div>

<form method="post" id="coach_form"  action="<?php echo base_url().$org_details['Aca_URL_ShortCode'];?>/search_coaches"> 

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
<option value="7" <?php if($sport=="7"){ echo "selected=selected"; } ?>>Pickleball</option>
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

<input class='form-control'  name='org_id' id='org_id' type='hidden' value="<?php echo $org_details['Aca_ID'];?>"  />

<div id="register-submit" class="col-md-2 form-group internal" style="padding-left:0px">
<input type="submit" name="coach_mem" value=" Search " />
</div>

</form> -->

<div class="clear"></div>


<div id='events' class="container">
<div class="row">
<?php 
if(count($coaches_list) == 0)
{
?>
    <div class="col-md-12 col-sm-12">
		 No Members found!
	</div><!-- col-md-4 -->
<?php
}
else
{

foreach($coaches_list as $row){ ?><!-- img-djoko -->

<div class="col-md-2 col-xs-6">
		 <div class="course-item">
			<div class="course-img">
			<a href="<?=$this->config->item('club_form_url').'/coach/'.$row->Users_ID;?>" target='_blank'>
			<img class="club-rounded-circle1" src="<?php echo base_url(); ?>profile_pictures/<?php if($row->Profilepic!=''){ echo $row->Profilepic; } else { echo "NPA.png"; } ?>" alt="" style="width:165px; height:182px;" />
			</a>
			</div>
			<div class="course-body">
				<div class="course-desc" style='text-align:center'>
					<b><h5><a href="<?=$this->config->item('club_form_url').'/coach/'.$row->Users_ID;?>" target='_blank'>
					<?php echo ucfirst($row->Firstname).' '.ucfirst($row->Lastname); ?>
					</a></h5></b>
				</div>
			</div>
		</div><!-- Tournaments-item -->
	</div><!-- col-md-4 -->



<?php } }?>
</div><!-- row -->
</div>
</div>
</section>