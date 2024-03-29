<!--fourth banner start -->
<div class="bg-blue pb-2" style="margin-top: 125px">
<div class="banner_pagetwo_  mx-3 pt-3 mb-5 ">
<div class="container">
<div class="row banner_pagetwo_two">
	<div class="col-lg-8 pb-0">
		<div class="banner_two_content pl-30 pt-4 mx-3">
		<h1 class="mb-2" style="text-align: var(--txt_align_left);">Keep all your matches Live</h1>
		<p class="mb-3 mt-3" style="text-align: var(--txt_align_left);">Played an awesome match with your friends? Make the match count! <br> Add the Score here and we will keep it alive. Each match will help you rate yourself better!</p>
		<p style="text-align: var(--txt_align_left);"><a href="<?=base_url()."/addscore";?>" class="btn_orange" style="padding: 10px 25px;">Add Score</a></p>
		</div>
	</div>
	<div class="col-lg-4 p-0">
		<div class="banner_img text-center">
		<img src="<?=base_url()."assets_new/";?>images/image 30.png" class="w-100 brb_r">
		</div>
	</div>
</div>
</div>
</div>
<!--fourth banner end -->


<!--seven banner start -->
<div class="bg-blue pb-2" style="margin-top: 25px">
<div class="container-fluid">
<div class="row">
<div class="heading text-center pt-4 pb-2">
<h1>Top Rated Players</h1>
</div>
</div>
<div class="row">
<div id="owl-one1" class="owl-carousel owl-theme Testimonials">
<?php
//print_r($top_players); exit;
foreach($top_players as $key => $row) {
$Sports_Interests = league::get_user_sport_intrests($row->Users_ID, $sport);
$membership_det = league::get_membership_details($row->Users_ID);
$user_details = league::get_user($row->Users_ID);
?>
<div class="item  "><!-- d-flex justify-content-between -->
<div class="players_box bg-white px-4 pt-4 pb-4">
<div class="img mt-3  mb-4 d-flex align-items-center justify-content-between">
<a href="<?php echo base_url()."player/".$row->Users_ID; ?>">
<?php 
$filename =  "C:\inetpub\wwwroot\a2msportssite\profile_pictures\thumbs\'".$user_details['Profilepic'];
$filename1 = "C:\inetpub\wwwroot\a2msportssite\profile_pictures\'".$user_details['Profilepic'];

if(file_exists($filename)){ ?>
<img  src="<?php echo base_url(); ?>profile_pictures/thumbs/<?php if($user_details['Profilepic']!=""){echo $user_details['Profilepic']; } else { echo "&nbsp;";}?>" class="player_img" style="border-radius: 15px;" />
<?php } else { ?>
<img  src="<?php echo base_url(); ?>profile_pictures/<?php if($user_details['Profilepic']!=""){echo $user_details['Profilepic']; } else { echo "default-profile-square.jpg";}?>" class="player_img" style="border-radius: 15px;" />
<?php }  ?></a>

<!-- <img src="<?=base_url()."assets_new/";?>images/player_1.png" class="player_img"> -->
<!-- <img src="<?=base_url()."assets_new/";?>images/rank_<?=($key+1);?>.png" class="player_ig"> -->
<div class="name text-end">
<p class="mb-0 gry">A2M Rating</p>
<h6 class=""><?php echo number_format($row->A2MScore, 3);?></h6>
</div>

</div>
<div class="palyer_names d-flex justify-content-between">
<div class="name">
<!-- <p class="mb-0 gry">Name</p> -->
<h6 class="" style="font-size: 1.1rem !important;"><a href="<?php echo base_url()."player/".$row->Users_ID; ?>">
<?php echo ucfirst($row->FirstName)." ".ucfirst($row->LastName);?>
</a>
</h6>
</div>
<!-- <div class="name text-end">
<p class="mb-0 gry">A2M Rating</p>
<h6 class=""><?php echo $row->A2MScore;?></h6>
</div> -->
</div>
<div class="club_name">
<!-- <p class="mb-0 gry">Club</p> -->
<h6 class="mb-0">
<?php echo ucfirst($row->City);
if($row->City and $row->State) echo ", ";
if($row->State) echo ucfirst($row->State);
//$get_club = league::get_club($membership_det[0]->Club_id);
//if($get_club['Aca_name']) echo $get_club['Aca_name'];
//else echo "N/A";?></h6>
</div>
</div>
</div>
<?php
}
?>


</div>
	<!-- <div class="sport_blue_btn col-lg-12 mt-1">
		<div class="btn_blue text-center">
		<a href="#viewAll" class="blue_btn show_all" id="vplayers">View All Players</a>
		</div>
	</div> -->
</div>
</div>
</div>
<!--seven banner end -->



<!-- <div class="row mt-5"> -->
<div class="">
<div class="col-lg-10 offset-lg-1">
<div class="bg-white p-3">
<div class="head d-flex justify-content-between align-items-center" style="margin-top: 0px;">
<h4 class="gry mb-0">&nbsp;</h4>
<div class="input-group w-30 mb-3 sreach_filter">
<select name='search_filter' id='search_filter' class='form-control' style="width: 15%">
<option value=''>All</option>
<option value='name'>Name</option>
<option value='city'>City</option>
<option value='state'>State</option>
<option value='age_group'>Age Group</option>
</select>
<input style="width: 50%; background-color:white;" type="text" name="search_keywords" id="search_keywords" class="form-control" placeholder="Search Keyword" aria-label="Example text with button addon" aria-describedby="button-addon1"><input class="btn btn-outline-secondary border-orange bg-orange" type='button' name='btn_player_search' id='btn_player_search' value='Search' />
<!-- <button class="btn btn-outline-secondary border-orange bg-orange" type="button" id="btn_player_search">Search</button> -->

<!-- <img class="form-control" src="<?=base_url()."icons/spinning-loading.gif"; ?>"name="sp_loading" id="sp_loading" /> -->

</div>
</div>
<div class="middle d-flex justify-content-between align-items-center">
<div class="Filter_middle_box d-flex align-items-center justify-content-start" style="margin-bottom: 15px;">
<!-- <p class="mb-0">Age Group</p>
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
--></div>


</div>
<div class="table_content relative" id='search_results'>
<table class="table table-striped">
<thead>
<tr>
<!-- <th scope="col">Rank</th> -->
<th scope="col" style="font-weight: bold !important;">Player Name</th>		
<th scope="col" style="font-weight: bold !important;">City</th>				
<!-- <th scope="col" style="font-weight: bold !important;">Win-Loss</th> -->
<th scope="col" style="font-weight: bold !important;">A2M Rating <br>(Singles)</th>
<th scope="col" style="font-weight: bold !important;">A2M Rating <br>(Doubles)</th>
<th scope="col" style="font-weight: bold !important;">A2M Rating <br>(Mixed)</th>
</tr>
</thead>
<tbody>
<?php
$k=1;
//echo "<pre>"; print_r($loc_query); exit;

foreach($loc_query as $key => $row) {
$Sports_Interests = league::get_user_sport_intrests($row->Users_ID,$sport);
$membership_det = league::get_membership_details($row->Users_ID);
?>
<tr>
<!-- <td><p class="mt-3 mb-0"><?php echo $k;?></p></td> -->
<td><p class="mt-3 mb-0"><a style='font-weight: 600;' target="_blank" href="<?php echo base_url();?>
player/<?php echo $row->Users_ID;?>">
<?php echo ucfirst($row->FirstName)." ".ucfirst($row->LastName);?>
</a></p></td>
<td><p class="mt-3 mb-0"><?php echo $row->City.", ".$row->State;?></p></td>
<!-- <td><p class="mt-3 mb-0"><?php echo $row->Won." - ".$row->Lost;?></p></td> -->
<td><p class="mt-3 mb-0"><?php echo number_format($row->A2M_Singles, 3);?></p></td>
<td><p class="mt-3 mb-0"><?php echo number_format($row->A2M_Doubles, 3);?></p></td>
<td><p class="mt-3 mb-0"><?php echo number_format($row->A2M_Mixed, 3);?></p></td>
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
$('document').ready(function(){
var baseurl = "<?php echo base_url();?>";
var segment = "<?php echo $this->uri->segment(1);?>";

//$("#search_keywords").on('keyup', function() {
$("#btn_player_search").on('click', function() {
search_val(baseurl, segment);
});
$("#search_filter").change(function() {
search_val(baseurl, segment);
});

$('#search_keywords').keypress(function (e) {
var code = e.keyCode || e.which;
if (code === 13){
e.preventDefault();
$("#btn_player_search").trigger('click'); /*add this, if you want to submit form by pressing `Enter`*/
}
});


});

function search_val(baseurl, segment){
//$('#search_results').html("Please wait.....");

$.ajax({
type: 'POST',
url: baseurl+segment+'/players',
data: {keywords:$('#search_keywords').val(), filter:$('#search_filter').val(), is_search:1},
success: function(res) {
//location.reload();
$('#search_results').html(res);
}
});

}
</script>
<script>
$(document).ready(function() {
var owl_ = $('#owl-one1');
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
});
});
</script>
<?php $this->load->view('includes/login_popup'); ?>