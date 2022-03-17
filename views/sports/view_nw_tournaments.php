<div class="mt-5">
<div class="col-lg-10 offset-lg-1">
<div class="bg-white p-3">
<div class="head d-flex justify-content-between align-items-center" style="margin-top: 55px;">
<h4 class="gry mb-0"><!-- Filter --></h4>
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
<p class="mb-0">Tournament Type</p>
<ul class="filter">
<li class="nav-item dropdown">
<a class="dropdown-toggle" data-bs-toggle="dropdown" href="#" role="button" aria-expanded="false">All <img src="<?=base_url()."assets_new/";?>images/downarrow.png"></a>
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
<a class="dropdown-toggle" data-bs-toggle="dropdown" href="#" role="button" aria-expanded="false">This Year <img src="<?=base_url()."assets_new/";?>images/downarrow.png"></a>
<ul class="dropdown-menu">
<li><a class="dropdown-item" href="#">This Week</a></li>
<li><a class="dropdown-item" href="#">Next Week</a></li>
<li><a class="dropdown-item" href="#">This Month</a></li>
<li><a class="dropdown-item" href="#">Next 3 months</a></li>
<li><a class="dropdown-item" href="#">Custom</a></li>
</ul>
</li>
</ul>
</div> -->

<!-- <div class="Filter_middle_box align-items-center d-flex justify-content-start">
<p class="mb-0">Registration Status</p>
<ul class="filter">
<li class="nav-item dropdown">
<a class="dropdown-toggle" data-bs-toggle="dropdown" href="#" role="button" aria-expanded="false">All  <img src="<?=base_url()."assets_new/";?>images/downarrow.png"></a>
<ul class="dropdown-menu">
<li><a class="dropdown-item" href="#">Open</a></li>
<li><a class="dropdown-item" href="#">Closed</a></li>
</ul>
</li>
</ul>
</div> -->
<!-- <div class="Filter_middle_box d-flex align-items-center justify-content-start">
<p class="mb-0">Tournament Type</p>
<ul class="filter">
<li class="nav-item dropdown">
<a class="dropdown-toggle" data-bs-toggle="dropdown" href="#" role="button" aria-expanded="false"><img src="<?=base_url()."assets_new/";?>images/country.png" class="mx-0"> <img src="<?=base_url()."assets_new/";?>images/downarrow.png"></a>
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

<div class="table_content relative">

<table class="table table-striped">
<thead>
<tr>
<th scope="col" style="font-weight: bold !important; text-align: center;">Tournament</th>
<th scope="col" style="font-weight: bold !important;">City</th>
<th scope="col" style="font-weight: bold !important;">State</th>
<th scope="col" style="font-weight: bold !important;">Date</th>
<th scope="col" style="font-weight: bold !important;">Contact</th>
</tr>
</thead>
<tbody>
<?php
if(!empty($leagues)) { 
//$i=1;
foreach($leagues as $j => $row) {
?>
<tr>
<td >
<div class="names_table align-items-center d-flex">
<a href="<?=base_url();?>league/<?=$row->tournament_ID;?>">
<img src="<?php echo base_url(); ?>tour_pictures/
<?php if($row->TournamentImage!=""){ echo $row->TournamentImage; }
else{
switch($row->SportsType) {
case 1:
echo "default_tennis_min.jpg";
break;
case 2:
echo "default_table_tennis_min.jpg";
break;
case 3:
echo "default_badminton_min.jpg";
break;
case 4:
echo "default_golf_min.jpg";
break;
case 5:
echo "default_racquet_ball_min.jpg";
break;
case 6:
echo "default_squash_min.jpg";
break;
case 7:
echo "default_pickleball_min.jpg";
break;
case 8:
echo "default_chess_min.jpg";
break;
case 9:
echo "default_carroms_min.jpg";
break;
case 10:
echo "default_volleyball_min.jpg";
break;
case 11:
echo "default_fencing.jpg";
break;
case 12:
echo "default_bowling.jpg";
break;
case 16:
echo "default_cricket.jpg";
break;

default:
echo "";
break;
}
}
?>">
</a>
<p class="mb-0">
<a style="font-weight: 600; color:#0d6efd" href="<?=base_url();?>league/<?=$row->tournament_ID;?>">
<?=$row->tournament_title;?>
</a></p>
</div>
</td>
<td><p class="mt-3 mb-0"><?=$row->TournamentCity;?></p></td>
<td><p class="mt-3 mb-0"><?=$row->TournamentState;?></p></td>
<td><p class="mt-3 mb-0"><?=date('m/d/Y', strtotime($row->StartDate));?></p></td>
<td><p class="mt-3 mb-0"><?=$row->OrganizerName;?></p></td>
</tr>
<?php
}
}
?>

</tbody>
</table>
<?php if(!$this->session->userdata('user')) {?>
<div class="sing_up_theme">
<div class="text-center text_bottom">
<h1 class="text-light mb-5">Sign up for Complete Access</h1>
<div class="btn_blue text-center">
<a href="<?=base_url()."login";?>" class="white_btn">Sign Up</a>
</div>
</div>
</div>
<?php } ?>
</div>
</div>
</div>
</div>