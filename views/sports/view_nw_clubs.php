<!--Clubs banner start -->
<div class="bg-white bg-fig pb-2" style="margin-top:100px;">
<div class="container-fluid">
<div class="row">
<div class="heading text-center pt-5 pb-1">
<h1>Top Rated Clubs</h1>
</div>
</div>
<div class="row">
<div class="col-lg-12">
<div id="owl-one3" class="owl-carousel owl-theme Testimonials" style="margin-top: -35px;">
<?php
if($club_results){
foreach($club_results as $i => $row){
?>
<div class="item activ_box ">
<div class="Active_box bg-white px-4 pt-4">
<div class="club_img mb-3 d-flex justify-content-between" style="height: 117px;">
<center><a href="<?php if($row->A2M_Proxy_URL) { echo $row->A2M_Proxy_URL; } else { echo base_url()."{$row->Aca_URL_ShortCode}"; } ?>">
<?php
if($row->Aca_logo){
?>
<img src="<?=base_url();?>/org_logos/<?=$row->Aca_logo;?>" style="width: 117px !important; height: auto !important;" /></a>
<?php
}
else{
switch($sport) {
case 1:
$club_logo_def = base_url()."tour_pictures/default_tennis_min.jpg";
break;
case 2:
$club_logo_def = base_url()."tour_pictures/default_table_tennis_min.jpg";
break;
case 3:
$club_logo_def = base_url()."tour_pictures/default_badminton_min.jpg";
break;
case 4:
$club_logo_def = base_url()."tour_pictures/default_golf_min.jpg";
break;
case 5:
$club_logo_def = base_url()."tour_pictures/default_racquet_ball_min.jpg";
break;
case 6:
$club_logo_def = base_url()."tour_pictures/default_squash_min.jpg";
break;
case 7:
$club_logo_def = base_url()."tour_pictures/default_pickleball_min.jpg";
break;
case 8:
$club_logo_def = base_url()."tour_pictures/default_chess_min.jpg";
break;
case 9:
$club_logo_def = base_url()."tour_pictures/default_carroms_min.jpg";
break;
case 10:
$club_logo_def = base_url()."tour_pictures/default_volleyball_min.jpg";
break;
case 11:
$club_logo_def =  base_url()."tour_pictures/default_fencing.jpg";
break;
case 12:
$club_logo_def =  base_url()."tour_pictures/default_bowling.jpg";
break;
case 16:
$club_logo_def =  base_url()."tour_pictures/default_cricket.jpg";
break;

default:
$club_logo_def =   "";
break;
}
?>
<img src="<?=$club_logo_def;?>" style="width: 117px !important; height: auto !important;" /></a>
<?php
}
?>
</center>
<h4 class="mt-2">
<a href="<?php if($row->A2M_Proxy_URL) { echo $row->A2M_Proxy_URL; } else { echo base_url()."{$row->Aca_URL_ShortCode}"; } ?>" style="color:#000;"><?=$row->Aca_name;?></a></h4>
</div>
<div class="club_content text-start">
<div class="text-start mb-2 d-flex justify-content-start align-items-start rating ">
<!-- <img src="<?=base_url()."assets_new/";?>images/star.png" >
<img src="<?=base_url()."assets_new/";?>images/star.png" >
<img src="<?=base_url()."assets_new/";?>images/star.png" >
<img src="<?=base_url()."assets_new/";?>images/star.png" > 
<img src="<?=base_url()."assets_new/";?>images/gray_start.png" >
&nbsp;<p class="gry">4.8 (62 reviews)</p> -->

<?php
$get_clubratings = league::get_club_Rating($row->Aca_ID);
$avg_star_rating = 0;
if($get_clubratings){?>
<?php 
$s5 = 0; $s4 = 0; $s3 = 0;  $s2 = 0;  $s1 = 0;
foreach($get_clubratings as $key => $value) {
if($value->Ratings==5){
$s5+=1;
} 
if($value->Ratings==4){
$s4+=1;
} 
if($value->Ratings==3){
$s3+=1;
} 
if($value->Ratings==2){
$s2+=1;
}
if($value->Ratings==1){
$s1+=1;
}
}

$avg_star_rating = ($s5*5 + $s4*4 + $s3*3 + $s2*2 + $s1*1) / ($s5 + $s4 + $s3 + $s2 + $s1);
echo "<a href='#searchclub' class='abc' id='club_$row->Aca_ID' style='text-decoration: none;'>";

if( is_float( $avg_star_rating ) ) { // Check to see if whole number or decimal
$rounded_ranking = round($avg_star_rating); // If decimal round it down to a whole number

for ($counter=2; $counter <= $rounded_ranking; $counter++){ 
echo " <i class='fa fa-star checked'></i> ";
}

echo '<i class="fa fa-star-half-o checked"></i> '; 
// Static half star used as the ranking value is a decimal and the is_float condition is met.

for(;$rounded_ranking<5;$rounded_ranking++){
echo '<i class="fa fa-star-o checked"></i> ';
}
}  
else{
// For Loop so we can run the stars as many times as is set, no offset need, as no half star required for whole number rankings
for ($counter=1; $counter <= $avg_star_rating; $counter++){
echo '<i class="fa fa-star checked"></i> ';
}
for(;$avg_star_rating<5;$avg_star_rating++){
echo '<i class="fa fa-star-o checked"></i> ';
}
}
echo "</a>";

}
else{
echo "<a href='#searchclub' class='abc' id='club_$row->Aca_ID' style='text-decoration: none;'>";
for($j=0;$j<5;$j++){
echo "<i class='fa fa-star-o checked'></i> ";
}
echo "</a>";
}
?>


<p class="gry">&nbsp;<?=$avg_star_rating; ?>  (<?=count($get_clubratings);?> reviews) </p>
</div>

<!-- <p class="gry">4.8 (62 reviews)</p> -->
<p class="club_info d-flex justify-content-start align-items-center mb-2"><img src="<?=base_url()."assets_new/";?>images/location.png"> <?=$row->Aca_city;?> <?php if($row->Aca_state) echo ", ".$row->Aca_state; ?></p>
<p class="club_info d-flex justify-content-start align-items-center mb-0 pb-2"><img src="<?=base_url()."assets_new/";?>images/label.png"> Starting at $10.00/hr</p>
</div>
</div>
<?php
$is_courts = league::is_club_haveCourts($row->Aca_ID);

if($is_courts){
?>
<a href="<?=base_url()."{$row->Aca_URL_ShortCode}/courts/reserve";?>" class="club_btn">Book a Sessions</a>
<?php
}
else{
?>
<a class="club_btn_disable">Book a Sessions</a>
<?php
}
?>
</div>
<?php
}
}
?>
</div>
</div>
<!-- <div class="col-lg-12">
<div class="btn_blue text-center">
<a href="#viewAll" class="orange_btn show_all" id="vclubs">View All  Clubs</a>
</div>
</div> -->
</div>
</div>
</div>
<!--Clubs banner end -->


<!-- --------------------------------- -->
<div class="mt-1">
<div class="col-lg-10 offset-lg-1">
<div class="bg-white p-3">
<div class="head d-flex justify-content-between align-items-center">
<h4 class="gry mb-0">&nbsp;</h4>

<div class="input-group w-30 mb-3 sreach_filter align-items-right">
<input class="btn btn-outline-secondary border-orange bg-orange " type='button' name='btn_add_club' id='btn_add_club' value='Add Club' />
</div>

<div class="input-group w-30 mb-3 sreach_filter">
<select name='search_filter' id='search_filter' class='form-control' style="width: 15%">
<option value=''>All</option>
<option value='name'>Name</option>
<option value='city'>City</option>
<option value='state'>State</option>
</select>
<input style="width: 50%; background-color:white;" type="text" name="search_keywords" id="search_keywords" class="form-control" placeholder="Search Keyword" aria-label="Example text with button addon" aria-describedby="button-addon1"><input class="btn btn-outline-secondary border-orange bg-orange" type='button' name='btn_player_search' id='btn_player_search' value='Search' />
</div>


</div>
<div class="middle d-flex justify-content-between align-items-center">
<!-- <div class="Filter_middle_box d-flex align-items-center justify-content-start">
<p class="mb-0">Age Group</p>
<ul class="filter">
<li class="nav-item dropdown">
<a class="dropdown-toggle" data-bs-toggle="dropdown" href="#" role="button" aria-expanded="false">All <img src="<?=base_url();?>assets_new/images/downarrow.png"></a>
<ul class="dropdown-menu">
<li><a class="dropdown-item" href="#">Action</a></li>
<li><a class="dropdown-item" href="#">Another action</a></li>
<li><a class="dropdown-item" href="#">Something else here</a></li>
<li><hr class="dropdown-divider"></li>
<li><a class="dropdown-item" href="#">Separated link</a></li>
</ul>
</li>
</ul>
</div> -->
<!-- <div class="Filter_middle_box align-items-center  d-flex justify-content-start">
<p class="mb-0">Tournament Date</p>
<ul class="filter">
<li class="nav-item dropdown">
<a class="dropdown-toggle" data-bs-toggle="dropdown" href="#" role="button" aria-expanded="false">This Year <img src="images/downarrow.png"></a>
<ul class="dropdown-menu">
<li><a class="dropdown-item" href="#">Action</a></li>
<li><a class="dropdown-item" href="#">Another action</a></li>
<li><a class="dropdown-item" href="#">Something else here</a></li>
<li><hr class="dropdown-divider"></li>
<li><a class="dropdown-item" href="#">Separated link</a></li>
</ul>
</li>
</ul>
</div> -->
<!-- <div class="Filter_middle_box align-items-center d-flex justify-content-start">
<p class="mb-0">Registration Status</p>
<ul class="filter">
<li class="nav-item dropdown">
<a class="dropdown-toggle" data-bs-toggle="dropdown" href="#" role="button" aria-expanded="false">Closed  <img src="images/downarrow.png"></a>
<ul class="dropdown-menu">
<li><a class="dropdown-item" href="#">Action</a></li>
<li><a class="dropdown-item" href="#">Another action</a></li>
<li><a class="dropdown-item" href="#">Something else here</a></li>
<li><hr class="dropdown-divider"></li>
<li><a class="dropdown-item" href="#">Separated link</a></li>
</ul>
</li>
</ul>
</div> -->
<!-- <div class="Filter_middle_box d-flex align-items-center justify-content-start">
<p class="mb-0">Tournament Type</p>
<ul class="filter">
<li class="nav-item dropdown">
<a class="dropdown-toggle" data-bs-toggle="dropdown" href="#" role="button" aria-expanded="false"><img src="images/country.png" class="mx-0"> <img src="images/downarrow.png"></a>
<ul class="dropdown-menu">
<li><a class="dropdown-item" href="#">Action</a></li>
<li><a class="dropdown-item" href="#">Another action</a></li>
<li><a class="dropdown-item" href="#">Something else here</a></li>
<li><hr class="dropdown-divider"></li>
<li><a class="dropdown-item" href="#">Separated link</a></li>
</ul>
</li>
</ul>
</div> -->
</div>

<div id='add_Clubs' class="col-md-12" style="display:none;">
<div class="fromtitle">Add Club</div>
<form method="post" id="addClubs" enctype="multipart/form-data" 
action="<?php echo base_url();?><?php echo $sport_segment;?>#addClub">

<input  id='sport' name='sport' type='hidden' value="<?php echo $sport;?>">
<div class='col-md-6 form-group internal' style="padding-left:0px">
<label>Club Name: </label>
	<input class='form-control' id='clubname' name='clubname' type='text' placeholder="Club Name"  required />
</div>
<div class='col-md-6 form-group internal' style="padding-left:0px">
<label>Country: </label>
 <select class='form-control' id='clubcountry' name='clubcountry'>
        <option value="">Select Country</option>
	<?php
	foreach($countries as $cntry)
	{	
	 echo "<option value='$cntry->Country'>$cntry->Country</option>";
	}
	?>
    </select>	
</div>
<div class='col-md-6 form-group internal' style="padding-left:0px">
<label>Address Line1: </label>
	<input class='form-control' id='addr_line1' name='addr_line1' type='text' placeholder="Address"   />
</div>
<div class='col-md-6 form-group internal' style="padding-left:0px">
<label>Address Line2:  </label>
	<input class='form-control' id='addr_line2' name='addr_line2' type='text' placeholder="Address"   />
</div>
<div class='col-md-6 form-group internal' style="padding-left:0px">
<label>City: </label>
	<input class='form-control' id='clubcity' name='clubcity' type='text' placeholder="City"   />
</div>
<div class='col-md-6 form-group internal' style="padding-left:0px" >
<label>State: </label>
<div id="addclubstates_div">

<input class='form-control' list="addclubstates" name="addclub_state"  placeholder="State"/>
<datalist id="addclubstates">
<?php foreach ($states as $key => $stat) {
		echo '<option value="'.$stat.'">';	
} ?> 
</datalist>
</div>
</div>

<div class='col-md-6 form-group internal' style="padding-left:0px">
<label>ZipCode:  </label>
	<input class='form-control' id='zipcode' name='zipcode' type='text' placeholder="ZipCode"   />
</div>
<div class='col-md-6 form-group internal' style="padding-left:0px">
<label>Website: </label>
	<input class='form-control' id='club_website' name='club_website' type='text' placeholder="Website"   />
</div>

<div class='col-md-6 form-group internal' style="padding-left:0px">
<label>Contact Name: </label>
	<input class='form-control' id='contact_name' name='contact_name' type='text' placeholder="Contact Name"   />
</div>
<div class='col-md-6 form-group internal' style="padding-left:0px">
<label>Contact Email: </label>
	<input class='form-control' id='contact_email' name='contact_email' type='text' placeholder="Contact Email"   />
</div>
<div class='col-md-6 form-group internal' style="padding-left:0px">
<label>Contact Phone: </label>
	<input class='form-control' id='contact_phone' name='contact_phone' type='text' placeholder="Contact Phone"   />
</div>


<div class='col-md-6 form-group internal' style="padding-left:0px">
<label>No Of Courts: </label>
	<input class='form-control' id='no_of_courts' name='no_of_courts' type='text' placeholder="Number of Courts"   />
</div>
<div class='col-md-6 form-group internal' style="padding-left:0px">
<label>Club Details: </label>
<textarea class='form-control' id='club_details' name='club_details' placeholder="Club details"></textarea>
</div>

<div class='col-md-6 form-group internal' style="padding-left:0px;padding-bottom:50px">
<label>Club Logo: </label>
<input type="file" name="club_logo" id="club_logo" />
</div>

<div class='col-md-12 form-group internal' style="padding-left:0px; padding-bottom:15px;">
<label>Sports: </label>
	<div class='row'>
	<?php 
	$selected = '';
	$i	  = 1;
	$cols = 3;
	foreach ($sports as $key => $sprt) {

		if($sprt->SportsType_ID == $sport){
		  $selected = 'checked';
		}else{
			$selected = '';
		}
			if($i == 1){
			echo "<div class='col-md-2 col-xs-4'>";
			}

			echo '<input type="checkbox"  name="clubsport[]" value="'.$sprt->SportsType_ID.'" '.$selected.'/>';
			echo "&nbsp".$sprt->Sportname;	
			echo "<br>";

			if($i == $cols) {
			echo "</div>";
			$i = 1;
			}
			else {			
			$i++;
			}

	} ?>
	</div>
</div>


<div class='col-md-12 form-group internal' style="padding-left:0px; padding-bottom:35px;">
<label>Timings: </label>
<?php
$time_sel   = '';
for($hours=0; $hours<24; $hours++)		// the interval for hours is '1'
    for($mins=0; $mins<60; $mins+=30)	// the interval for mins is '30'
     $time_sel .='<option>'.str_pad($hours,2,'0',STR_PAD_LEFT).':'.str_pad($mins,2,'0',STR_PAD_LEFT).'</option>';
?>
<div class='row' style='padding-bottom:20px;'>
	<div class='col-md-3'>
	<input type="checkbox"  name="clubTimings[]" class='ctime_chck' value="1" /> Monday <br />
	<select name="club_time_from[]" id="club_time_from_1" class='ctime'>
	<option value="">From</option><?=$time_sel;?></select>&nbsp;&nbsp;
	<select name="club_time_to[]" id="club_time_to_1" class='ctime'><option value="">To</option><?=$time_sel;?></select>
	</div>

	<div class='col-md-3'>
	<input type="checkbox"  name="clubTimings[]" class='ctime_chck' value="2" /> Tuesday <br />
	<select name="club_time_from[]" id="club_time_from_2" name="club_time[]" id="club_time_1" class='ctime'>
	<option value="">From</option><?=$time_sel;?></select>&nbsp;&nbsp;
	<select name="club_time_to[]" id="club_time_to_2" class='ctime'><option value="">To</option><?=$time_sel;?></select>
	</div>

	<div class='col-md-3'>
	<input type="checkbox"  name="clubTimings[]" class='ctime_chck' value="3" /> Wednesday <br />
	<select name="club_time_from[]" id="club_time_from_3" class='ctime'><option value="">From</option><?=$time_sel;?></select>&nbsp;&nbsp;
	<select name="club_time_to[]" id="club_time_to_3" class='ctime'><option value="">To</option><?=$time_sel;?></select>
	</div>

	<div class='col-md-3'>
	<input type="checkbox"  name="clubTimings[]" class='ctime_chck' value="4" /> Thursday <br />
	<select name="club_time_from[]" id="club_time_from_4" class='ctime'><option value="">From</option><?=$time_sel;?></select>&nbsp;&nbsp;
	<select name="club_time_to[]" id="club_time_to_4" class='ctime'><option value="">To</option><?=$time_sel;?></select>
	</div>
</div>
<div class='row'>
	<div class='col-md-3'>
	<input type="checkbox"  name="clubTimings[]" class='ctime_chck' value="5" /> Friday <br />
	<select name="club_time_from[]" id="club_time_from_5" class='ctime'><option value="">From</option><?=$time_sel;?></select>&nbsp;&nbsp;
	<select name="club_time_to[]" id="club_time_to_5" class='ctime'><option value="">To</option><?=$time_sel;?></select>
	</div>

	<div class='col-md-3'>
	<input type="checkbox"  name="clubTimings[]" class='ctime_chck' value="6" /> Saturday <br />
	<select name="club_time_from[]" id="club_time_from_6" class='ctime'><option value="">From</option><?=$time_sel;?></select>&nbsp;&nbsp;
	<select name="club_time_to[]" id="club_time_to_6" class='ctime'><option value="">To</option><?=$time_sel;?></select>
	</div>

	<div class='col-md-3'>
	<input type="checkbox"  name="clubTimings[]" class='ctime_chck' value="0" /> Sunday <br />
	<select name="club_time_from[]" id="club_time_from_0" class='ctime'><option value="">From</option><?=$time_sel;?></select>&nbsp;&nbsp;
	<select name="club_time_to[]" id="club_time_to_0" class='ctime'><option value="">To</option><?=$time_sel;?></select>
	</div>
</div>
</div>
<script>
$(document).ready(function(){
$('.ctime').prop('disabled',true);
$('.ctime_chck').click(function(){
	var id = $(this).val();
	if($(this).prop("checked") == true){
	$('#club_time_from_'+id).prop('disabled',false);
	$('#club_time_to_'+id).prop('disabled',false);
	}
	else{
	$('#club_time_from_'+id).val('');
	$('#club_time_to_'+id).val('');
	$('#club_time_from_'+id).prop('disabled',true);
	$('#club_time_to_'+id).prop('disabled',true);
	}
});
});
</script>
<div id="register-submit"  class='col-md-6 form-group internal' style="padding-left:0px">
	<input  id='tab'   name='tab'	type='hidden' value="Clubs">
	<input type="submit" name="addclub" id="addclub"  value="Add" />
	<input type="button" id="clear-form" value="Cancel" />
</div>

</form>
</div>


<div class="table_content relative" id="search_results">
<table class="table table-striped">
<thead>
<tr>
<th scope="col" style="font-weight: bold !important;">Club Name</th>
<th scope="col" style="font-weight: bold !important;">City</th>
<th scope="col" style="font-weight: bold !important;">State</th>
<th scope="col" style="font-weight: bold !important;">Contact #</th>
<th scope="col" style="font-weight: bold !important;">Rating</th>
</tr>
</thead>
<tbody>
<?php
$k=1;
foreach($club_results as $key => $row) {
?>
<tr>
<td><p class="mt-3 mb-0"><?php
if($row->Aca_URL_ShortCode != ""){
?>
<a href="<?php 
if($row->A2M_Proxy_URL) 
echo $row->A2M_Proxy_URL;
else
echo base_url().$row->Aca_URL_ShortCode;	
?>">
<?php echo trim($row->Aca_name);?></a>
<?php
}
else if($row->Aca_url != ""){
?>
<a href="<?php echo stripslashes($row->Aca_url);?>"><?php echo stripslashes($row->Aca_name);?></a>
<?php
}
else{?>
<?php echo stripslashes($row->Aca_name);?>
<?php
}?></p></td>
<td><p class="mt-3 mb-0"><?php 
if($row->Aca_city != ""){
echo $row->Aca_city; 
}
?></p></td>
<td><p class="mt-3 mb-0"><?php 
if($row->Aca_state != ""){
echo $row->Aca_state; 
}
?></p></td>
<td><p class="mt-3 mb-0"><?php echo $row->Aca_contact_phone; ?></p></td>
<td><p class="mt-3 mb-0"><?php
$get_clubratings = league::get_club_Rating($row->Aca_ID);

if($get_clubratings){?>
<?php 
$s5 = 0; $s4 = 0; $s3 = 0;  $s2 = 0;  $s1 = 0;
foreach($get_clubratings as $key => $value) {
if($value->Ratings==5){
$s5+=1;
} 
if($value->Ratings==4){
$s4+=1;
} 
if($value->Ratings==3){
$s3+=1;
} 
if($value->Ratings==2){
$s2+=1;
}
if($value->Ratings==1){
$s1+=1;
}
}

$avg_star_rating = ($s5*5 + $s4*4 + $s3*3 + $s2*2 + $s1*1) / ($s5 + $s4 + $s3 + $s2 + $s1);
echo "<a href='#searchclub' class='abc' id='club_$row->Aca_ID' style='text-decoration: none;'>";

if( is_float( $avg_star_rating ) ) { // Check to see if whole number or decimal
$rounded_ranking = round($avg_star_rating); // If decimal round it down to a whole number

for ($counter=2; $counter <= $rounded_ranking; $counter++){ 
echo " <i class='fa fa-star checked'></i> ";
}

echo '<i class="fa fa-star-half-o checked"></i> '; 
// Static half star used as the ranking value is a decimal and the is_float condition is met.

for(;$rounded_ranking<5;$rounded_ranking++){
echo '<i class="fa fa-star-o checked"></i> ';
}
}  
else{
// For Loop so we can run the stars as many times as is set, no offset need, as no half star required for whole number rankings
for ($counter=1; $counter <= $avg_star_rating; $counter++){
echo '<i class="fa fa-star checked"></i> ';
}
for(;$avg_star_rating<5;$avg_star_rating++){
echo '<i class="fa fa-star-o checked"></i> ';
}
}
echo "</a>";

}
else{
echo "<a href='#searchclub' class='abc' id='club_$row->Aca_ID' style='text-decoration: none;'>";
for($j=0;$j<5;$j++){
echo "<i class='fa fa-star-o checked'></i> ";
}
echo "</a>";
}
?></p></td>
</tr>
<?php 
$k++;
} ?>                           



</tbody>
</table>
<?php if(!$this->session->userdata('user')) {?>
<div class="sing_up_theme">
<div class="text-center text_bottom">
<h1 class="text-light mb-5">Sign up for Complete Access</h1>
<div class="btn_blue text-center">
<a href="#" class="white_btn">Sign Up</a>
</div>
</div>
</div>
<?php } ?>
</div>
</div>
</div>
</div>
<script>
$(document).ready(function() {
var owl_ = $('#owl-one3');
owl_.owlCarousel({
margin: 20,
nav: true,
loop: true,
responsive: {
0: {
items: 1
},
600: {
items: 1
},
1000: {
items: 4
}
}
})
})
</script>
<script>
$('document').ready(function(){
	var baseurl = "<?php echo base_url();?>";
	var segment_1 = "<?php echo $this->uri->segment(1);?>";
	var segment_2 = "<?php echo $this->uri->segment(2);?>";

	//$("#search_keywords").on('keyup', function() {
	$("#btn_player_search").on('click', function() {
	search_val(baseurl, segment_1, segment_2);
	});
	$("#search_filter").change(function() {
	search_val(baseurl, segment_1, segment_2);
	});

	$('#search_keywords').keypress(function (e) {
	var code = e.keyCode || e.which;
	if (code === 13){
	e.preventDefault();
	$("#btn_player_search").trigger('click'); /*add this, if you want to submit form by pressing `Enter`*/
	}
	});
});

function search_val(baseurl, segment_1, segment_2){
	//$('#search_results').html("Please wait.....");

	$.ajax({
	type: 'POST',
	url: baseurl+segment_1+'/'+segment_2,
	data: {keywords:$('#search_keywords').val(), filter:$('#search_filter').val(), is_search:1},
	success: function(res) {
	//location.reload();
	$('#search_results').html(res);
	}
	});
}
</script>
<?php $this->load->view('includes/login_popup'); ?>