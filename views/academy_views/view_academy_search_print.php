<link href="<?php echo base_url();?>css/minislide/flexslider.css" rel="stylesheet" type="text/css" />
<link href="<?php echo base_url();?>css/component.css" rel="stylesheet" type="text/css" />
<link href="<?php echo base_url();?>css/prettyPhoto.css" rel="stylesheet" type="text/css" />
<link href="<?php echo base_url();?>css/style_dir.css" rel="stylesheet" type="text/css" />

<link href="<?php echo base_url();?>css/responsive.css" rel="stylesheet" type="text/css" />
<link href="<?php echo base_url();?>css/animate.css" rel="stylesheet" type="text/css" />
<link href="<?php echo base_url();?>css/tabs.css" rel="stylesheet" type="text/css" />
<link href="<?php echo base_url(); ?>css/jquery.datepick.css" rel="stylesheet" type="text/css" />
<link href="<?php echo base_url();?>css/jquery.autocomplete.css" rel="stylesheet" type="text/css" />

<link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">

<link rel="stylesheet" href="<?php echo base_url();?>css/grid.css">

<!-- <div style="padding-left:10px; float:left" class='col-md-4'>
<a href="<?php //echo base_url();?>"><img src="<?php //echo base_url();?>images/logo.png" alt="" ></a>
<br />
<br />
<br />

</div> -->
<div style='padding-left:180px; padding-top:20px; float:left'><p style='font-size:40px'><b>Club Members & Ratings 
<?php if($ag_grp != ''){ echo "- $ag_grp"; } ?></b><br /><br /></p></div> 
<section id="login" class="container secondary-page">  

<!-- LOGIN BOX -->
<div class="top-score-title right-score col-md-12">
<!-- <h3><?php echo $title->tournament_title; ?></h3> -->
<div class="col-md-12">
<div class="general water-mark">
<div class="brackets" id="brackets">
<!--  -->

<div style='padding-left:20px'>
<table width='100%' align='center'>
<tr style='background-color:skyblue'>
<td><b>Name</b></td>
<td><b>A2MScore</b></td>
<td><b>No.of Matches</b></td>
<td><b>Won</b></td>
<td><b>Loss</b></td>
<td><b>Win%</b></td>
</tr>

<?php 
if(count($query) == 0)
{
?>
<tr>
<td><h5>No Members Found.</h5></td>
</tr>
<?php
}
else
{
$i = 0;
foreach($query as $row){

$count = 0;

$get_data = academy::get_details($row->Users_ID);			
foreach($get_data as $r){
	if($r->Sport_id == $sport or $sport == ''){
	$sport		 = $r->Sport_id;
	$get_sp_name = academy::get_sport($sport);
	$user_id	 = $row->Users_ID;
	$user_stats = $this->model_academy->get_num_matches($user_id, $sport);
		if($user_stats[0]->Num_Matches > 0){
			$count++;
		}
	}
}


/* $bgcolor = "background-color:orange;";
if($i % 2 == 0){
$bgcolor = "background-color:green;";
}
$i++;*/

if($count > 0){
?><!-- img-djoko -->
<tr style='<?=$bgcolor;?>'>
<!-- <td>
<a href="#"><img class="scale_image" src="<?php echo base_url(); ?>profile_pictures/<?php if($row->Profilepic!=''){ echo $row->Profilepic; } else { echo "default-profile.png"; } ?>" alt="img" width="150px" height="250px" /></a>
</td> -->
<td style="vertical-align:top;">
&nbsp;&nbsp;<a href="<?php echo base_url();?>player/<?php echo $row->Users_ID;?>"><?php echo ucfirst($row->Firstname).' '.ucfirst($row->Lastname); ?></a><br />
&nbsp;</td>


<td style="vertical-align:top;">
<?php 
$get_data = academy::get_details($row->Users_ID);			
foreach($get_data as $r){
if($r->Sport_id == $sport or $sport == ''){
$sport		 = $r->Sport_id;
$get_sp_name = academy::get_sport($sport);
$user_id	 = $row->Users_ID;
$user_a2mscore = $this->model_academy->get_a2msocre($sport, $user_id);

if($user_a2mscore != ""){
echo $user_a2mscore['A2MScore'] . "" ."<br />";
echo "&nbsp;";
}
}
}

?></td>
<td style="vertical-align:top;">
<?php 
$get_data = academy::get_details($row->Users_ID);			
foreach($get_data as $r){
if($r->Sport_id == $sport or $sport == ''){
$sport		 = $r->Sport_id;
$get_sp_name = academy::get_sport($sport);
$user_id	 = $row->Users_ID;
$user_stats = $this->model_academy->get_num_matches($user_id, $sport);
echo $user_stats[0]->Num_Matches . "" ."<br />";
}
}

?></td>
<td style="vertical-align:top;">
<?php 
echo $user_stats[0]->Won . "" ."<br />";


?></td>
<td style="vertical-align:top;">
<?php 
echo $user_stats[0]->Lost . "" ."<br />";


?></td>
<td style="vertical-align:top;">
<?php 
echo $user_stats[0]->Win_Per . "" ."<br />";


?></td>
</tr>

<?php
}
} }?>
</table>
</div>


<!--  -->
</div>
</div>
</div>
<!--Close Login-->
</div>
</section>