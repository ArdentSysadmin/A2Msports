<script>

$(document).ready(function(){
	$(".rate").hide(); 
	$(".rating-head").hide();

});

$(document).ready(function(){
$(function () {

$(".rate").click(function(){
  $(this).hide();
  $("#RatingsDiv").show();
});

$('.rating input').click(function () {
        $('.rating span').removeClass('checked');
        $(this).parent().addClass('checked');
});

$(".rate_to_club_cancel").click(function(){
  $('.rating input:radio').attr("checked", false);
  $('.rating span').removeClass('checked');
  $("#RatingsDiv").hide();
  $(".rate").show();

});

$(".rate_to_club_edit_cancel").click(function(){
  $("#RatingsDiv").hide();
  $(".rate").show();
});

/*$(".rateEdit").click(function(){
  $("#rate_to_club").hide();
  $(".rate_to_club1").show();
});*/



});
});
 
</script>


<?php
//echo "<pre>";
//print_r($club_ratings);
//exit;

if($this->session->userdata('users_id')!=""){
if(!$user_club_ratings){
?>
<input type="button" value="Rate Here" class="rate league-form-submit1">
<?php 
}else{?>
<input type="button" value="Edit Ratings" class="rate league-form-submit1">
<?php 
} }
?>


<div style="display: none;" id="RatingsDiv">
<div class="rating-head"><b>Give Ratings</b></div>
<form id="rate_form" method="POST" action="<?php echo base_url();?>league/<?php if($user_club_ratings){
	echo "EditClubRating";
}else{
	echo "AddClubRating";}?>">
<div class='rating' style="padding-left:0px">
<p><b>Ratings:</b> 
<?php if($user_club_ratings[0]->Ratings!=""){
$ratings = $user_club_ratings[0]->Ratings;

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
<p><b>Comments:</b> <textarea class="form-control" style="width: 80%; display: inline-block;" name="comments" id="comments"><?php if($user_club_ratings[0]->Comments!=""){echo $user_club_ratings[0]->Comments;}?>
</textarea></p>
</div>
<div style="clear:both;"></div>
<div style="padding-left:0px">
<p><b> Do you want to hide your identity?</b> 
<input type="checkbox" name="anonymous"  value="1" <?php if($user_club_ratings[0]->Rate_Anonymous==1){echo "checked";}?>> 
</p>
</div>
<div id="register-submit" class="">
<input type="hidden" name="club_id" value="<?php echo $club_id;?>" />
<input type="hidden" name="sportname" value="<?php echo $sport_name;?>" />

<input type="submit" value="Submit" name="rate_to_club" id="rate_to_club" />
<!-- <input type="submit" value="Update" name="rate_to_club1" id="rate_to_club1"> -->

<?php if($club_ratings){?>
  <input type="button" value="Cancel" class="rate_to_club_edit_cancel league-form-submit1" id="cancel_club">
<?php }else{
  ?>
<input type="button" value="Cancel" class="rate_to_club_cancel league-form-submit1" id="cancel_club">
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
                echo ' <i class="fa fa-star checked accpad"></i>';
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
foreach($club_ratings as $key => $value){
 	$get_user = league::get_user($value->User_ID);
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
  <?php if($value->Comments!=""){?>
       <p><b>Comment: </b> <?php echo $value->Comments;?></p>
  <?php } ?>
  
</div>
<div style="clear:both;"></div>

  <hr>
   
<?php } ?>
</div>
</div>