<style type="text/css">
.rating {
    float:left;
    width:264px;
}
.rating span { 
  float:right; position:relative; 
}
.rating span input {
    position:absolute;
    top:0px;
    left:0px;
    opacity:0;
}
.rating span label {
      display: inline-block;
      overflow: hidden;
      text-indent: 9999px;
      width: 1em;
      white-space: nowrap;
      cursor: pointer;
      font-size: 22px;
}
.rating span label:before{
    display: inline-block;
        text-indent: -9999px;
        content: '\2606';
       
}
.rating span:hover ~ span label,
.rating span:hover label,
.rating span.checked label,
.rating span.checked ~ span label {
       content: '\2605';
       color: #ff8a00;
       text-shadow: 0 0 1px #ff8a00;
}

.checked {
    color: orange !important;
    
}
.accpad{
  margin-right: 0px !important;
    margin-left: 0px !important;
}
.ratingsimg img {
  width:auto !important;
}
.rating-head {
  margin-bottom:10px; color:#81a32b; font-size:16px
}
@media only screen and (max-width: 450px) {
.rating-head {
  font-size:13px
}
.accpad {
  font-size:10px !important;
  margin-right: -4px !important;
    margin-left: 0px !important;
}

}
@media only screen and (max-width: 380px) {
.rating-head {
  font-size:11px
}

}

.tab-score{
  width:100% !important;
}
.pagination {
    margin: 2px 0 0 -3px;
}
.pagepad {
  padding-left: 0px;
  padding-right: 0px;
  padding-top: 8px;
}
.tab-score td:last-child {
    font-weight: 400;
}
.tab-content {
    padding: 0;
    border-radius: 1px;
    background: #fff!important; 
}

.tab-content .tab-score thead .sorting_asc {
    background-image: url("<?php echo base_url(); ?>js/DataTables-1.10.16/images/sort_asc.png");
}
.tab-content .tab-score thead .sorting {
    background-image: url("<?php echo base_url(); ?>js/DataTables-1.10.16/images/sort_both.png");
}
.tab-content .tab-score thead .sorting_desc {
    background-image: url("<?php echo base_url(); ?>js/DataTables-1.10.16/images/sort_desc.png");
}
.tab-content .tab-score thead .sorting, .tab-content .tab-score thead .sorting_asc, .tab-content .tab-score thead .sorting_desc, .tab-content .tab-score thead .sorting_asc_disabled, .tab-content .tab-score thead .sorting_desc_disabled {
    cursor: pointer;
    background-repeat: no-repeat;
    background-position: center right;
}
.tab-score tr:nth-child(odd) {
    background-color: #fff9f3;
}
#register-submit input[type=button] {
    border: 1px solid #e78315;
    background-color: #f59123;
    padding: 5px 25px;
    font-size: 13px;
    text-transform: uppercase;
    color: #fff;
    margin-bottom: 13px;
    -webkit-transition: all .5s ease;
    -moz-transition: all .5s ease-in-out;
    -o-transition: all .5s ease-in-out;
    -ms-transition: all .5s ease-in-out;
    transition: all .5s ease-in-out;
    cursor: pointer;
}

.accordion i {
    font-size: 12px;
    margin-right: 0px;
    margin-left: 0px;
}
@media only screen and (max-width: 700px) {
.acc-content .col-md-3 {
    width: 100%;
}
.accordion i {
    font-size: 7px;
    margin-right: 0px;
    margin-left: 0px;
}
}

.scrollit {
    overflow-x:scroll;
   /* height:100px;*/
}
</style>

<script>
$(function () {
$(".rate").click(function(){
  $(this).hide();
  $("#coachdiv").show();
});
$(".change_status").click(function(){
  /*$(this).hide();
  $("#coachdiv").show();*/
  alert('test');
});
$('.rating input').click(function () {
        $('.rating span').removeClass('checked');
        $(this).parent().addClass('checked');
    });
$(".rate_to_coach_cancel").click(function(){
  $('.rating input:radio').attr("checked", false);
  $('.rating span').removeClass('checked');
  $("#coachdiv").hide();
  $(".rate").show();

});
$(".rate_to_coach_edit_cancel").click(function(){
  $("#coachdiv").hide();
  $(".rate").show();
});
});
$(document).ready(function(){

$('#country').on('change', function() {
if ( this.value == 'United States of America')
{
$("#state_drop").show();
$("#state_box").hide();
}
else
{
$("#state_drop").hide();
$("#state_box").show();
}
});

$('#sport_level_2, #sport_level_3, #sport_level_4' ).click(function(){      
$('#Sport_intrests_1').attr('checked', true);   
});   

$('#sport_level_5, #sport_level_6, #sport_level_7' ).click(function(){      
$('#Sport_intrests_2').attr('checked', true);   
});   

$('#sport_level_8, #sport_level_9, #sport_level_10' ).click(function(){      
$('#Sport_intrests_3').attr('checked', true);   
});   

$('#sport_level_11, #sport_level_12, #sport_level_13' ).click(function(){      
$('#Sport_intrests_4').attr('checked', true);   
});   

$('#sport_level_14, #sport_level_15, #sport_level_16' ).click(function(){      
$('#Sport_intrests_5').attr('checked', true);   
});   

$('#sport_level_17, #sport_level_18, #sport_level_19' ).click(function(){      
$('#Sport_intrests_6').attr('checked', true);   
});        


$('#Sport_intrests_1' ).click(function(){
$('#sport_level_2, #sport_level_3, #sport_level_4').prop('checked', false);
});  
$('#Sport_intrests_2' ).click(function(){
$('#sport_level_5, #sport_level_6, #sport_level_7').prop('checked', false);
});  
$('#Sport_intrests_3' ).click(function(){
$('#sport_level_8, #sport_level_9, #sport_level_10').prop('checked', false);
});  
$('#Sport_intrests_4' ).click(function(){
$('#sport_level_11, #sport_level_12, #sport_level_13').prop('checked', false);
});  
$('#Sport_intrests_5' ).click(function(){
$('#sport_level_14, #sport_level_15, #sport_level_16').prop('checked', false);
});  
$('#Sport_intrests_6' ).click(function(){
$('#sport_level_17, #sport_level_18, #sport_level_19').prop('checked', false);
});  


});
</script>

<script>
$(document).ready(function(){

$("#Contact-details").click(function(){
$("#login").show(); 
$("#contact").show();
$("#user_details").hide();
$("#Contact-details").hide();

});

$("#cancel").click(function(){
$("#login").hide(); 
$("#contact").hide();
$("#user_details").show();
$("#Contact-details").show();
});

var baseurl = "<?php echo base_url();?>";

$('#created_by').autocomplete({
	source: function( request, response ) {
  		$.ajax({
			url: baseurl+'search/autocomplete',
  			dataType: "json",
			method: 'post',
			data: {
			   name_startsWith: request.term,
			   type: 'users',
			   row_num : 1
			},
			 success: function( data ) {
				 response( $.map( data, function( item ) {
				 	var code = item.split("|");
					return {
						label: code[0],
						value: code[0],
						data : item
					}
					//alert(item);
				}));
			}
  		});
  	},
  	autoFocus: true,
  	minLength: 1,
  	select: function( event, ui ) {
		var names = ui.item.data.split("|");
		var opp   = names[1];
		var uid   = $('#uid').val();
		$.ajax({
			type:'POST',
			url:baseurl+'search/get_user_opponent_stats/',
			data:{opp:opp,user_id:uid},
			success:function(html){
			$('#standings').html(html);
			//$('#standings').DataTable().ajax.reload();


			}
		});

		//$('#created_by').val('');
		//$('#created_by').focus();
	}
});

$('#reset_stats').click(function(){
		var opp = -1;

		$.ajax({
			type:'POST',
			url:baseurl+'profile/get_user_opponent_stats/',
			data:{opp:opp},
			success:function(html){
			$('#standings').html(html);
			//$('#standings').DataTable().ajax.reload();
			}
		});
});

});
</script>



<section id="single_player" class="container secondary-page">
<div class="top-score-title right-score col-md-9">

<h3> <?php echo $user_details['Firstname'] . " " . $user_details['Lastname'];?> </h3>

<div class="col-md-12 atp-single-player">

<div class="col-md-3">
<img class="img-djoko" src="<?php echo base_url(); ?>profile_pictures/<?php if($user_details['Profilepic']!=""){echo $user_details['Profilepic']; } else { echo "default-profile.png";}?>" alt="" />
</div>

<div class="col-md-5 profilelist">
<p><b>Location:</b>
<?php
if($user_details['City']){ echo $user_details['City']; }
if($user_details['State']){ echo ", ".$user_details['State']; }
?></p>
<p><b>Age Group:</b> <?php echo $user_details['UserAgegroup'];?></p>
<?php
if($user_details['RegistrationDtTm']){
?>
<p><b>Member Since:</b> <?php echo date('M, Y',strtotime($user_details['RegistrationDtTm'])); ?></p>
<?php
}?>
<p><b>About Me:</b>
<?php
if($user_details['bio']){ echo $user_details['bio']; }
?></p>
<?php
if($this->is_super_admin){
?>
<p><b>Status:</b> <?php 
echo ($user_details['IsUserAccoutBlock'] == 1) ? "Blocked" : "Active"; 
if($user_details['IsUserAccoutBlock'] == 1)
	echo "<button class='league-form-submit1' class='change_status'>Activate</button>";
else
	echo "<button class='league-form-submit1' class='change_status'>Block</button>";
?></p>
<?php
}?>
</div>

<div class="col-md-4 profilelist">
<p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p class="txt-torn"><button class="league-form-submit1" id="Contact-details">Contact Player</button></p>      
</div>
</div>

<div class="col-md-12 atp-single-player skill-content" id="user_details" >  <!-- switch user details dic start  -->
<dl class="accordion" style="background:none">


<?php if($user_details['Is_coach'] == 1){ ?>
<dt class="accordion__title">Coach Profile</dt>
<dd class="accordion__content">

<div class="acc-content">

<div style="text-transform:none"><p><b>SPORT: </b>

<?php $get_sport = search::get_sport($user_details['coach_sport']);
echo $get_sport['Sportname'];?></p></div>

<div style="text-transform:none"><p> <b>COACH PROFILE: </b><?php echo $user_details['coach_profile']; ?></p></div>

<div style="text-transform:none">
<p><b>COACH WEBSITE:</b> 
<?php
if($user_details['Coach_Website'] != ""){
 $check = "http";
$pos = strpos($user_details['Coach_Website'],$check);
if($pos){ ?>
 
 <a target="_blank" href="<?php echo $user_details['Coach_Website'];?>"><?php echo $user_details['Coach_Website'];?></a> 
 
<?php } else { ?>
 <a target="_blank" href="<?php echo "http://".$user_details['Coach_Website'];?>"><?php echo $user_details['Coach_Website'];?></a>  

<?php } 
} ?>

</p>
</div><br />

<?php
if($this->session->userdata('users_id')!=""){
if($get_userratings[0]->Ratings == ""){
?>
<input type="button" value="Rate Here" class="rate league-form-submit1">
<?php 
}else{?>
<input type="button" value="Edit Ratings" class="rate league-form-submit1">
<?php 
} }
?>


<div style="display: none;" id="coachdiv">
<div class="rating-head"><b>Give Ratings</b></div>
<form id="rate_form" method="POST" action="<?php echo base_url();?>league/<?php if($get_userratings){
echo "EditRating";

}else{
echo "AddRating";}?>">
<div class='rating' style="padding-left:0px">
<p><b>Ratings:</b> 
<?php if($get_userratings[0]->Ratings!=""){
$ratings = $get_userratings[0]->Ratings;

}?>
    <span class="<?php if($ratings == '5'){
echo "checked";
    } ?>"><input type="radio" name="rating" id="str5" value="5" <?php if($ratings == '5'){
echo "checked";
    } ?>><label for="str5"></label></span>
    <span  class="<?php if($ratings == '4'){
echo "checked";
    } ?>"><input type="radio" name="rating" id="str4" value="4" <?php if($ratings == '4'){
echo "checked";
    } ?>><label for="str4"></label></span>
    <span class="<?php if($ratings == '3'){
echo "checked";
    } ?>"><input type="radio" name="rating" id="str3" value="3" <?php if($ratings == '3'){
echo "checked";
    } ?>><label for="str3"></label></span>
    <span class="<?php if($ratings == '2'){
echo "checked";
    } ?>"><input type="radio" name="rating" id="str2" value="2" <?php if($ratings == '2'){
echo "checked";
    } ?>><label for="str2"></label></span>
    <span class="<?php if($ratings == '1'){
echo "checked";
    } ?>"><input type="radio" name="rating" id="str1" value="1" <?php if($ratings == '1'){
echo "checked";
    } ?>><label for="str1"></label></span>
 </p>
</div>
<div style="clear:both;"></div>
<div style="padding-left:0px">
<p><b>Comments:</b> <textarea class="form-control" style="width: 80%; display: inline-block;" name="comments" id="comments"><?php if($get_userratings[0]->Comments!=""){echo $get_userratings[0]->Comments;}?>
</textarea></p>
</div>
<div style="clear:both;"></div>
<div style="padding-left:0px">
<p><b> Do you want to hide your identity?</b> 
<input type="checkbox" name="anonymous"  value="1" <?php if($get_userratings[0]->Rate_Anonymous==1){echo "checked";}?>> 
</p>
</div>
<div id="register-submit" class="">
<input type="hidden" name="coach_id" value="<?php echo $user_details['Users_ID'];?>">
<input type="submit" value="Submit" name="rate_to_coach" id="rate_to_coach">
<?php if($get_userratings){?>
  <input type="button" value="Cancel" class="rate_to_coach_edit_cancel league-form-submit1" id="cancel_coach">
<?php }else{
  ?>
<input type="button" value="Cancel" class="rate_to_coach_cancel league-form-submit1" id="cancel_coach">
<?php }?>
</div>
</form>
</div>
<div style="clear:both;"></div>
<div class="top-score-title right-score">
<div class="rating-head"><b>Ratings & Reviews</b>   
<span>
<?php 
if($avg_star_rating!="" || $avg_star_rating!=0){

      if( is_float( $avg_star_rating ) ) { // Check to see if whole number or decimal
            $rounded_ranking = round($avg_star_rating); // If decimal round it down to a whole number
           
            for ($counter=2; $counter <= $rounded_ranking; $counter++){ 
                echo '<i class="fa fa-star checked accpad"></i>';
            }
            echo '<i class="fa fa-star-half-o checked accpad"></i>'; // Static half star used as the ranking value is a decimal and the is_float condition is met.
           for(;$rounded_ranking<5;$rounded_ranking++){
                echo '<i class="fa fa-star-o checked accpad"></i>';
            }
        }   
        else {
            // For Loop so we can run the stars as many times as is set, no offset need, as no half star required for whole number rankings
            for ($counter=1; $counter <= $avg_star_rating; $counter++){
                echo '<i class="fa fa-star checked accpad"></i>';
            }
            for(;$avg_star_rating<5;$avg_star_rating++){
                echo '<i class="fa fa-star-o checked accpad"></i>';
            }
        }
      }else{
        for($j=0;$j<5;$j++){
         echo '<i class="fa fa-star-o checked accpad"></i>';
       
      }
    }
      

  ?>
  </span>
</div>
<?php
foreach ($get_coachratings as $key => $value) {

$get_user = search::get_user($value->User_ID);
  
?>
<div style="text-transform:none; float:left; margin-right:6px" class="ratingsimg">
<?php if($get_user['Profilepic']!=""){
 $profile_pic = $get_user['Profilepic']; 
 } else { 
 $profile_pic = "default-profile.png";
 }
 if($value->Rate_Anonymous!=1){
  $profile_url = base_url().'profile_pictures/'.$profile_pic;
 }else{
  $profile_url = base_url().'profile_pictures/default-profile.png';
}?>
<img class="img-circle" width="50px" height="50px" src="<?php echo $profile_url;?>" alt="" />

</div>

<div style="text-transform:none; float:left">
  <p>
  <?php if($value->Rate_Anonymous != 1){
       echo $get_user['Firstname'] . " " . $get_user['Lastname'];
   }else{
      echo "Anonymous";
   } ?><br>
    <?php for($j=0;$j<5;$j++){
  if($j<$value->Ratings){?>
        <i class="fa fa-star checked accpad"></i>
  <?php }else{?>
        <i class="fa fa-star-o checked accpad"></i>
  <?php } ?>
       
  <?php }?>
  </p>
  <?php if($value->Comments != ""){?>
       <p><b>Comment: </b> <?php echo $value->Comments;?></p>
  <?php } ?>
  
</div>
<div style="clear:both;"></div>

  <hr>
   
<?php } ?>
</div>
</div>
<div style="clear:both;"></div>
</dd>

<?php } ?>



<dt class="accordion__title">Matches</dt>
<dd class="accordion__content">

<div class="tab-content table-responsive">
<table id="SearchMatches11" class="table tab-score">
<thead>
<tr class="top-scrore-table">
<td class="score-position">Tournament/Match</td>
<td class="score-position">Opponent</td>
<td class="score-position">Score</td>
<td class="score-position">Date</td>
<td class="score-position">Winner</td>
</tr>
</thead>
<tbody>
<?php 
if(count($user_matches) == 0 && count($user_tournment_matches) == 0 && count($user_tournment_team_matches) == 0)  
{
?>
<tr>
<td colspan="5">No Played Matches are found.</td>
</tr>
<?php
}
else {
 /*echo "<pre>";
 print_r($user_matches);*/
foreach($user_matches as $row) { 
?>
<tr>
<td><a href='<?php echo base_url()."Play/reg_match/".$row->Play_id; ?>'><b><?php echo $row->Play_Title; ?></b></a></td>
<td><?php
$get_opp_name = search::get_gen_mat_det($row->GeneralMatch_ID);

if($row->Opponent == $user_details['Users_ID'])
{
$get_username = search::get_user_det($get_opp_name['users_id']); 
echo $get_username['Firstname']." ".$get_username['Lastname'];
}
else
{
$get_username = search::get_user_det($row->Opponent); 
echo $get_username['Firstname']." ".$get_username['Lastname'];
}

//echo $row->Opponent; ?></td>
<td>
<?php
if($row->Player1_Score !=""){

$p1 = json_decode($row->Player1_Score);
$p2 = json_decode($row->Opponent_Score);
	if(count(array_filter($p1))>0){
		for($i=0; $i<count(array_filter($p1)); $i++){
		echo "($p1[$i] - $p2[$i]) ";
		}
	}
}
?>
</td>
<td>
<div style="display:none;">
<?php echo date('Y/m/d',strtotime($row->Play_Date)); ?> <!-- added for date sorting  -->
</div>
 <?php echo date('M d, Y',strtotime($row->Play_Date)); ?>
 </td>
<td><?php 
$get_username = search::get_user_det($row->Winner); 
echo $get_username['Firstname']." ".$get_username['Lastname'];
?></td>
</tr>
<?php } ?>



<!-- User tournament Matches -->
<?php
/*echo "<pre>";
print_r($user_tournment_matches);
exit;*/
$tour_ids = array();
foreach($user_tournment_matches as $row) { 
if($row->Player1_Score != "Bye Match" and $row->Player2_Score != "Bye Match"){
	$get_tourn = search::get_tourn_name($row->Tourn_ID); 
?>
<tr>
 <?php
//print_r($tour_ids);
if(!in_array($row->Tourn_ID, $tour_ids)){ ?>
 <td> <a href="<?php echo base_url(); ?>league/<?php echo $row->Tourn_ID; ?>">
<b>
<?php
echo $get_tourn['tournament_title'];
	$tour_ids[] = $row->Tourn_ID;
?>
</b></a></td>
<?php
}

else{ ?>
  <td style='border-top: 0px;border-bottom: 0px;'>
    <div style="display:none;">
    <?php
echo $get_tourn['tournament_title'];

?>
    </div>
  </td>
  <?php
	//$tour_ids = array();
}
?>


<td><?php
//$get_opp_name = profile::get_gen_mat_det($row->Player2);

if($row->Player2 == $user_details['Users_ID'] or $row->Player2_Partner == $user_details['Users_ID'])
{
$get_username = search::get_user_det($row->Player1); 
echo $get_username['Firstname']." ".$get_username['Lastname'];
if($row->Player1_Partner != 0)
{
$get_partner = search::get_user_det($row->Player1_Partner); 
echo "; ".$get_partner['Firstname']." ".$get_partner['Lastname'];
}
}
else
{
$get_username = search::get_user_det($row->Player2); 
echo $get_username['Firstname']." ".$get_username['Lastname'];
if($row->Player2_Partner != 0)
{
$get_partner = search::get_user_det($row->Player2_Partner); 
echo "; ".$get_partner['Firstname']." ".$get_partner['Lastname'];
}
}

?></td>
<td> 

<?php 
if($row->Player1_Score !=""){
$p1=array();$p2=array();
$p1 = json_decode($row->Player1_Score);
$p2 = json_decode($row->Player2_Score);

$cnt = count(array_filter($p1));
if($cnt > 0){
for($i=0; $i<count(array_filter($p1)); $i++)
{
echo "($p1[$i] - $p2[$i]) ";
}
}
else if($cnt == 0 and $row->Player1_Score != "Bye Match" and $row->Player2_Score != "Bye Match"){
echo "Win by Forfeit ";
}

}
/*
if($row->Player1_Score == "Bye Match" or $row->Player2_Score == "Bye Match"){
echo "Bye Match";
}*/
?>
</td>

<td><?php if($row->Match_Date != ""){
 ?> <div style="display:none;">
<?php echo date('Y/m/d',strtotime($row->Match_Date)); ?> <!-- added for date sorting  -->
</div>
<?php
  echo date('M d, Y',strtotime($row->Match_Date));
}else {
  echo "";
} 
?></td>
<td><?php 
$get_username = search::get_user_det($row->Winner); 
echo $get_username['Firstname']." ".$get_username['Lastname'];

if($row->Winner == $row->Player1 && $row->Player1_Partner != 0)
{
$get_partner = search::get_user_det($row->Player1_Partner); 
echo "; ".$get_partner['Firstname']." ".$get_partner['Lastname'];
}
else if($row->Winner == $row->Player2 && $row->Player2_Partner != 0)
{
$get_partner = search::get_user_det($row->Player2_Partner); 
echo "; ".$get_partner['Firstname']." ".$get_partner['Lastname'];
}

?></td>
<!-- <div class="col-md-1 t13"><p></p></div> -->


<?php 
}
?>
</tr>
<?php
}
?>

<!-- User Tournament Team Matches -->
<?php 
$tour_ids = array();
$row = '';
//echo "<pre>";
//print_r($user_tournment_team_matches);
foreach($user_tournment_team_matches as $row) { 
if($row->Player1_Score != "Bye Match" and $row->Player2_Score != "Bye Match"){
	$get_tourn = search::get_tourn_name($row->Tourn_ID); 
?>
<tr>
<?php
//echo "<pre>";
//print_r($tour_ids);
if(!in_array($row->Tourn_ID, $tour_ids)){?>
  <td>
  <a href="<?php echo base_url(); ?>league/<?php echo $row->Tourn_ID; ?>">
  <b><?php echo $get_tourn['tournament_title'];
	$tour_ids[] = $row->Tourn_ID;?> 
  </b>
  </a>
  </td>
<?php
}
else{ ?>
   <td style='border-top: 0px;border-bottom: 0px;'>
    <div style="display:block;">
    <?php //echo $get_tourn['tournament_title'];?>
    </div>
  </td>
	<?php //$tour_ids = array();
}?>

<td><?php
//$get_opp_name = profile::get_gen_mat_det($row->Player2);

if($row->Player2 == $user_details['Users_ID'] or $row->Player2_Partner == $user_details['Users_ID'])
{
$get_username = search::get_user_det($row->Player1); 
echo $get_username['Firstname']." ".$get_username['Lastname'];
if($row->Player1_Partner != 0)
{
$get_partner = search::get_user_det($row->Player1_Partner); 
echo "; ".$get_partner['Firstname']." ".$get_partner['Lastname'];
}
}
else
{
$get_username = search::get_user_det($row->Player2); 
echo $get_username['Firstname']." ".$get_username['Lastname'];
if($row->Player2_Partner != 0)
{
$get_partner = search::get_user_det($row->Player2_Partner); 
echo "; ".$get_partner['Firstname']." ".$get_partner['Lastname'];
}
}

?></td>
<td> 

<?php 
if($row->Player1_Score !=""){
$p1=array();$p2=array();
$p1 = json_decode($row->Player1_Score);
$p2 = json_decode($row->Player2_Score);

$cnt = count(array_filter($p1));
if($cnt > 0){
for($i=0; $i<count(array_filter($p1)); $i++)
{
echo "($p1[$i] - $p2[$i]) ";
}
}
else if($cnt == 0 and $row->Player1_Score != "Bye Match" and $row->Player2_Score != "Bye Match"){
echo "Win by Forfeit ";
}

}
/*
if($row->Player1_Score == "Bye Match" or $row->Player2_Score == "Bye Match"){
echo "Bye Match";
}*/
?>
</td>

<td><?php if($row->Match_Date != ""){
  ?>
<div style="display:none;">
<?php echo date('Y/m/d',strtotime($row->Match_Date)); ?> <!-- added for date sorting  -->
</div>
  <?php
  echo date('M d, Y',strtotime($row->Match_Date));}else {"";} ?></td>
<td><?php 
$get_username = search::get_user_det($row->Winner); 
echo $get_username['Firstname']." ".$get_username['Lastname'];

if($row->Winner == $row->Player1 && $row->Player1_Partner != 0)
{
$get_partner = search::get_user_det($row->Player1_Partner); 
echo "; ".$get_partner['Firstname']." ".$get_partner['Lastname'];
}
else if($row->Winner == $row->Player2 && $row->Player2_Partner != 0)
{
$get_partner = search::get_user_det($row->Player2_Partner); 
echo "; ".$get_partner['Firstname']." ".$get_partner['Lastname'];
}

?></td>
<!-- <div class="col-md-1 t13"><p></p></div> -->


<?php 
}?>
</tr>
<?php
}
?>
<!-- End of User Tournament Team Matches -->

<?php
}?>
</tbody>
</table>
</div>
</dd>

<!-- <dt class="accordion__title">Tournaments</dt>
 -->
<dd class="accordion__content">
<!-- <h4>Content will be Updated soon</h4> -->

<div class="acc-content">
<div class="col-md-3 acc-title">Match</div>
<div class="col-md-2 acc-title">Opponent</div>
<div class="col-md-2 acc-title">Score</div>
<div class="col-md-2 acc-title">Date</div>
<div class="col-md-3 acc-title">Winner</div>
<!-- <div class="col-md-1 acc-title">Win%</div> -->

<?php
if(count($user_tournment_matches) == 0 && count($user_tournment_team_matches) == 0)   
{
?>
<br /><br />
<h5>No Tournament Matches are found.</h5>

<?php
}
else{ 

// User tournament Matches 

foreach($user_tournment_matches as $row) {

if($row->Player1_Score != "Bye Match" and $row->Player2_Score != "Bye Match")
{
?>

<div class="col-md-3 t9">
<p><a href="<?php echo base_url(); ?>league/<?php echo $row->Tourn_ID; ?>">
<b><?php 
$get_tourn = search::get_tourn_name($row->Tourn_ID); 
echo $get_tourn['tournament_title'];
?></b>
</a></p></div>

<div class="col-md-2 t10"><p><?php
//$get_opp_name = profile::get_gen_mat_det($row->Player2);

if($row->Player2 == $user_details['Users_ID'] or $row->Player2_Partner == $user_details['Users_ID'])
{
$get_username = search::get_user_det($row->Player1); 
echo $get_username['Firstname']." ".$get_username['Lastname'];
if($row->Player1_Partner != 0)
{
$get_partner = search::get_user_det($row->Player1_Partner); 
echo "; ".$get_partner['Firstname']." ".$get_partner['Lastname'];
}
}
else
{
$get_username = search::get_user_det($row->Player2); 
echo $get_username['Firstname']." ".$get_username['Lastname'];
if($row->Player2_Partner != 0)
{
$get_partner = search::get_user_det($row->Player2_Partner); 
echo "; ".$get_partner['Firstname']." ".$get_partner['Lastname'];
}
}

?></p></div>
<div class="col-md-2 t12"><p> 

<?php 
if($row->Player1_Score != ""){
  $p1=array();$p2=array();
  $p1 = json_decode($row->Player1_Score);
  $p2 = json_decode($row->Player2_Score);

  $cnt = count(array_filter($p1));
  if($cnt > 0){
    for($i=0; $i<count(array_filter($p1)); $i++)
    {
      echo "($p1[$i] - $p2[$i]) ";
    }
  }
  else if($cnt == 0 and $row->Player1_Score != "Bye Match" and $row->Player2_Score != "Bye Match"){
    echo "Win by Forfeit ";
  }
}
?>
</p></div>

<div class="col-md-2 t8"><p><?php if($row->Match_Date != ""){echo date('M d, Y',strtotime($row->Match_Date));}else {"";} ?></p></div>
<div class="col-md-3 t11"><p><?php 
$get_username = search::get_user_det($row->Winner); 
echo $get_username['Firstname']." ".$get_username['Lastname'];

if($row->Winner == $row->Player1 && $row->Player1_Partner != 0)
{
$get_partner = search::get_user_det($row->Player1_Partner); 
echo "; ".$get_partner['Firstname']." ".$get_partner['Lastname'];
}
else if($row->Winner == $row->Player2 && $row->Player2_Partner != 0)
{
$get_partner = search::get_user_det($row->Player2_Partner); 
echo "; ".$get_partner['Firstname']." ".$get_partner['Lastname'];
}


?></p></div>
<!-- <div class="col-md-1 t13"><p></p></div> -->
<div class="acc-footer"></div>

<?php 
}
}?>

<!-- User Tournament Team Matches -->
<?php 

foreach($user_tournment_team_matches as $row) { 
if($row->Player1_Score != "Bye Match" and $row->Player2_Score != "Bye Match"){
?>

<div class="col-md-3 t9"><p><a href="<?php echo base_url(); ?>league/<?php echo $row->Tourn_ID; ?>">
<b><?php 
$get_tourn = search::get_tourn_name($row->Tourn_ID); 
echo $get_tourn['tournament_title'];
?>
</a></b></p> </div>

<div class="col-md-2 t10"><p><?php
//$get_opp_name = profile::get_gen_mat_det($row->Player2);

if($row->Player2 == $user_details['Users_ID'] or $row->Player2_Partner == $user_details['Users_ID'])
{
$get_username = search::get_user_det($row->Player1); 
echo $get_username['Firstname']." ".$get_username['Lastname'];
if($row->Player1_Partner != 0)
{
$get_partner = search::get_user_det($row->Player1_Partner); 
echo "; ".$get_partner['Firstname']." ".$get_partner['Lastname'];
}
}
else
{
$get_username = search::get_user_det($row->Player2); 
echo $get_username['Firstname']." ".$get_username['Lastname'];
if($row->Player2_Partner != 0)
{
$get_partner = search::get_user_det($row->Player2_Partner); 
echo "; ".$get_partner['Firstname']." ".$get_partner['Lastname'];
}
}

?></p></div>
<div class="col-md-2 t12"><p> 

<?php 
if($row->Player1_Score !=""){
$p1=array();$p2=array();
$p1 = json_decode($row->Player1_Score);
$p2 = json_decode($row->Player2_Score);

$cnt = count(array_filter($p1));
if($cnt > 0){
for($i=0; $i<count(array_filter($p1)); $i++)
{
echo "($p1[$i] - $p2[$i]) ";
}
}
else if($cnt == 0 and $row->Player1_Score != "Bye Match" and $row->Player2_Score != "Bye Match"){
echo "Win by Forfeit ";
}

}
/*
if($row->Player1_Score == "Bye Match" or $row->Player2_Score == "Bye Match"){
echo "Bye Match";
}*/
?>
</p></div>

<div class="col-md-2 t8"><p><?php if($row->Match_Date != ""){echo date('M d, Y',strtotime($row->Match_Date));}else {"";} ?></p></div>
<div class="col-md-3 t11"><p><?php 
$get_username = search::get_user_det($row->Winner); 
echo $get_username['Firstname']." ".$get_username['Lastname'];

if($row->Winner == $row->Player1 && $row->Player1_Partner != 0)
{
$get_partner = search::get_user_det($row->Player1_Partner); 
echo "; ".$get_partner['Firstname']." ".$get_partner['Lastname'];
}
else if($row->Winner == $row->Player2 && $row->Player2_Partner != 0)
{
$get_partner = search::get_user_det($row->Player2_Partner); 
echo "; ".$get_partner['Firstname']." ".$get_partner['Lastname'];
}

?></p></div>
<!-- <div class="col-md-1 t13"><p></p></div> -->

<div class="acc-footer"></div>
<?php 
}
}
?>
<!-- End of User Tournament Team Matches -->

<?php
}?>
</div>

</dd>
<dt class="accordion__title">Statistics</dt>
<dd class="accordion__content">

<!-- New Statistics area -->
<div class="table-responsive scrollit">
<p>
<input class = 'ui-autocomplete-input form-control inwidth' id = 'created_by' name = 'created_by' type = 'text' placeholder = "Search by Opponent" style='width:40%; display:inline-block;' value = "" /> 
<input type='button' class='league-form-submit1' name='reset_stats' id='reset_stats' value='Reset' />
</p>

<table id="standings" cellpadding="8" cellspacing="8" border="0" class="tab-score" scrolltab>
<thead>
<tr class='top-scrore-table' style="background-color: #f68b1c; color:#fff; font-size:14px; padding:3px">
<th class="text-center">Sport</th>
<th class="text-center">A2M (S)</th>
<th class="text-center">A2M (D)</th>
<th class="text-center">A2M (M)</th>
<th class="text-center">Matches<br>Played</th>
<th class="text-center">Win - Loss</th>
<th class="text-center">Matches<br>Win%</th>
<th class="text-center">Scores</th>
<th class="text-center">Score<br>Differential</th>
<th class="text-center">Win%</th>
<th class="text-center">SD/MP</th>
<th class="text-center">SD/MP<br>+Win%</th>
</tr>
</thead>
<?php
if(count($user_stats) > 0){
	foreach($user_stats as $sport => $stats){
	$get_sport = search::get_sport($sport, $user_id);
	$get_a2m   = search::get_a2msocre($sport, $user_id);
	$get_winper   = search::get_winper($sport, $user_id);

	if($stats['won'] == '')
		$stats['won'] = 0;
	if($stats['lost'] == '')
		$stats['lost'] = 0;
?>
<tr>
<td>&nbsp;<b><?=$get_sport['Sportname'];?></b></td>
<td align='center'><?php echo $get_a2m['A2MScore']; ?></td>
<td align='center'><?php echo $get_a2m['A2MScore_Doubles']; ?></td>
<td align='center'><?php echo $get_a2m['A2MScore_Mixed']; ?></td>
<td align='center'><?php echo $stats['played']; ?></td>
<td align='center'><?php echo $stats['won']." - ".$stats['lost']; ?></td>
<td align='center'><?php $win_per = ($stats['won'] / $stats['played']) * 100; echo number_format($win_per, 2); ?></td>
<td align='center'><?php echo $stats['points_for']." - ".$stats['points_against']; ?></td>
<td align='center'><?php $diff = ($stats['points_for'] - $stats['points_against']); echo $diff; ?></td>
<td align='center'><?php echo $get_winper['Win_Per']; ?></td>
<td align='center'><?php $pd = $diff / $stats['played']; echo number_format($pd, 2); ?></td>
<td align='center' style="font-weight:400;"><?php $pd_win_per = $pd + $win_per;	  echo number_format($pd_win_per, 2); ?></td>
</tr>
<?php
	}
}
else{
?>
<tr>
<td align='right'>No</td>
<td>Standings</td>
<td>Available</td>
<td>yet!</td>
<td>&nbsp;</td>
<td>&nbsp;</td>
<td>&nbsp;</td>
<td>&nbsp;</td>
<td>&nbsp;</td>
<td>&nbsp;</td>
</tr>
<?php
}?>
</table>
</div>
<!-- New Statistics area -->

<!-- Basketball Statistics Area -->
<?php 
$get_bb_matches = search :: basketball_matches($user_details['Users_ID']);
if($get_bb_matches){
?>
<div class="table-responsive scrollit" style="margin-top: 35px;">

<table id="standings" cellpadding="8" cellspacing="8" border="0" class="tab-score" scrolltab>
<thead>  	            	         				                   
<tr class='top-scrore-table' style="background-color: #f68b1c; color:#fff; font-size:14px; padding:3px">
	<th class="text-center">Sport</th>
	<th class="text-center">GP</th>
	<th class="text-center">Pos</th>
	<th class="text-center">FG</th>
	<th class="text-center">3P</th>
	<th class="text-center">2P</th>
	<th class="text-center">FT</th>
	<th class="text-center">ORB</th>
	<th class="text-center">DRB</th>
	<th class="text-center">AST</th>
	<th class="text-center">ST</th>
	<th class="text-center">BLK</th>
	<th class="text-center">PTS</th>
</tr>
</thead>
<?php
if(0){

}
else{
?>
<tr>
<td>&nbsp;<b>Basketball</b></td>
<td align="center">-</td>
<td align="center">-</td>
<td align="center">-</td>
<td align="center">-</td>
<td align="center">-</td>
<td align="center">-</td>
<td align="center">-</td>
<td align="center">-</td>
<td align="center">-</td>
<td align="center">-</td>
<td align="center">-</td>
<td align="center">-</td>
</tr>
<?php
}
?>
</table>
</div>
<?php
}
?>
<p style="font-size:10px; color:#605e5e;margin-top: 5px;">
GP: Games Played, Pos: Position, FG: Field Goals, 3P: 3point, 2P: 2Point, FT: Free Throw, ORB: Offensive Rebound, DRB: Defensive Rebound, AST: Assist, ST: Steals, BLK: Blocks, PTS: Points
</p>
<!-- Basketball Statistics Area -->

</dd>

<dt class="accordion__title">Memberships</dt>
<dd class="accordion__content">

<div class="acc-content">
<div class="col-md-5 acc-title" style="font-size: 12px;">Club Name</div>
<div class="col-md-3 acc-title" style="font-size: 12px;">MembershipID</div>
<div class="col-md-2 acc-title" style="font-size: 12px;">Sport</div>
<br /><br /><br />

<?php 
if(count($membership_details) == 0)
{
?>
<h5>Membership details are not available.</h5>
<?php
}
else {
foreach($membership_details as $row){ 
?>
<div class="col-md-5 t9">
<p>
<?php
$get_club = search::get_club($row->Club_id);
echo $get_club['Aca_name'];
?>
</p>
</div>

<div class="col-md-3 t3"><p> 
<?php
if($get_club['Aca_name'] == "USTA"){
  echo "<a href='https://tennislink.usta.com/tournaments/Rankings/RankingHome.aspx?RankingPlayerName=".$this->session->userdata('user')."' target='_blank'>$row->Membership_ID</a>";
}
else{
  echo $row->Membership_ID;
}
?></p></div>

<div class="col-md-2 t4"><p>
<?php $get_sport = search::get_sport($row->Related_Sport);
echo $get_sport['Sportname'];?>
</p></div>

<div style="clear:both"></div>

<div class="acc-footer"></div>
<?php }
 } ?>
</div>
</dd>

</dl>

</div> 
<div style="clear:both"></div>
    <!--Close Top Match-->
<?php if(!$this->session->userdata('user')){
?>
<div class="col-md-12 league-form-bg" id="login" style="margin-top:40px;display:none;">
<p style="line-height:5px; font-size:13px">Please <a href="<?=base_url();?>login"><b>Login</b> </a>to contact player &nbsp; <a id="cancel">Back to Details</a></p> 
</div>

<?php     
}else{ ?>
<div class="col-md-12 skill-content" id="contact" style="display:none"> 

<!-- ---------------------contact player section--------------------------------------------- -->

<form class="form-horizontal" id='myform' method='post' role="form"  action="<?php echo base_url();?>search/contact_player"> 

<div class='form-group'>
<label class='control-label col-md-3' for='id_accomodation'>Message :</label> 
<div class='col-md-7 form-group internal'>
<textarea name="mes" class='form-control' id="mes" rows="10" cols="40"></textarea>
</div>  
</div>

<div class='form-group'>
<label class='control-label col-md-3' for='id_accomodation'></label>
<div class='col-md-7 form-group internal'>
<input type="submit" value="Send" name="send_email" style="margin-top:10px" class="league-form-submit1" />
<input type="button" value="Cancel" id="cancel" style="margin-top:10px" class="league-form-submit1" />  
</div>
</div>

<input type="hidden" value="<?php echo $user_details['EmailID'];?>" name="contact_email" />
<input type="hidden" value="<?php echo $user_details['AlternateEmailID'];?>" name="alter_contact_email" />
<input type="hidden" value="<?php echo $user_details['Firstname'];?>" name="fname" />
<input type="hidden" value="<?php echo $user_details['Lastname'];?>" name="lname" />
<input type="hidden" value="<?php echo $user_details['Users_ID'];?>" id="uid" name="id" />

</form>

</div> 

<?php }?>


 <!-- close div -->

<!-- -----------------contact player section end ------------------------------------------------- -->          


<!-- Google AdSense -->
<div id='google' align='left'>
<script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
<ins class="adsbygoogle"
style="display:block"
data-ad-client="ca-pub-9772177305981687"
data-ad-slot="1273487212"
data-ad-format="auto"></ins>
<script>
(adsbygoogle = window.adsbygoogle || []).push({});
</script>
</div>
<!-- Google AdSense -->



</div>