<style> 
 .imgContainer{
    float:left;
	padding: 7px;
}
</style> 
<?php
$sponsors = array();
$sponsorsjsn = $tour_details->Sponsors;
 
if($sponsorsjsn != ""){
  $sponsors = json_decode($sponsorsjsn, true);
}
?>   
<!-- <div align='center'> -->
<div align='right'>
<a href="<?=base_url()?>sponsor/<?=$tour_details->tournament_ID;?>" style='cursor:pointer;margin-right:40px;' target='_blank'><img src='<?=base_url();?>icons/become-a-sponsor.png' alt='Become a Sponsor' title='Become a Sponsor' width='200px'></a>
</div>
<?php
if(count($sponsors) > 1){
echo "<div id='slideshow2'>";
}
else
{
echo "<div id='slideshow1'>";
}
?>
<div class="col-md-80" style="margin-top:5px; align:center">
<?php 
 	foreach ($sponsors as $sponsor => $sponsor_addr_link)
	{
	if($sponsor_addr_link){
		if (!preg_match("~^(?:f|ht)tps?://~i", $sponsor_addr_link)) {
		$sponsor_addr_link = "http://" . $sponsor_addr_link;
		}
	?>
	 <div class="imgContainer">  
	 <a target="_blank" href="<?php echo $sponsor_addr_link; ?>" style="cursor:pointer;"><img src="<?php echo base_url();?>tour_pictures/<?php echo $tour_details->tournament_ID;?>/sponsors/<?php echo $sponsor;?>" width="450" height="220" alt="" /></a>
	 </div>
	 <?php
	 
  	}
	else{
	?>
	<div class="imgContainer" >
	  <img src="<?php echo base_url();?>tour_pictures/<?php echo $tour_details->tournament_ID;?>/sponsors/<?php echo $sponsor;?>" width="250" height="250" alt="" /> 
	</div>
	<?php
 
	} }?>
</div>
<?php 
if($sponsor_details != ""){
	foreach($sponsor_details as $details){
	  if($details->Sponsor_Image != ""){
?>
 <div class="imgContainer" >
		 <a target="_blank" href="http://<?php echo $details->Sponsor_URL;?>" style="cursor:pointer;"><img src="<?php echo base_url();?>tour_pictures/ext_sponsors/<?php echo $details->Sponsor_Image;?>"  width="450" height="220" alt="<?php echo $details->Sponsor_Name;?>" /></a>
</div>
<?php }
	  else{ ?>
	<div class="imgContainer">
 		<h3><?php echo $details->Sponsor_Name;?></h3> 
	</div>
<?php		
	  }
	}
}
else{
?>
<div style="display:none"></div>
<?php 
}
?>
<script type="text/javascript">
	$("ul.bxslider li:first-child").addClass("highlight");
	var baseurl="<?php echo base_url();?>";
</script>