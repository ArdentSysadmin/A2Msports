<div class="row mt-5">
                    <div class="col-lg-10 offset-lg-1">
                      <div class="bg-white p-3">
                        <div class="head d-flex justify-content-between align-items-center">
                          <h4 class="gry mb-0">Filter</h4>
                          <div class="input-group w-30 mb-3 sreach_filter">
                              <button class="btn btn-outline-secondary border-orange bg-orange" type="button" id="button-addon1">Search</button>
                              <input type="text" class="form-control" placeholder="Search by Name,City,State" aria-label="Example text with button addon" aria-describedby="button-addon1">
                            </div>
                        </div>
                        <div class="middle d-flex justify-content-between align-items-center">
                          <div class="Filter_middle_box d-flex align-items-center justify-content-start">
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
                          </div>
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
                        <div class="table_content relative">
                          <table class="table table-striped">
                            <thead>
                              <tr>
                                <th scope="col">Coach Name</th>
                                <th scope="col">City</th>
                                <th scope="col">State</th>
                                <th scope="col">Coach Website</th>
                                <th scope="col">Rating</th>
                              </tr>

                            </thead>
                            <tbody>
<?php
$k=1;
foreach($coach_results as $key => $row) {
 ?>
                              <tr>
                                <td>
								<p class="mt-3 mb-0"><a target="_blank" href="<?php echo base_url();?>coach/<?php echo $row->Users_ID;?>">
								<!-- <img class="scale_image" src="<?php echo base_url(); ?>profile_pictures/<?php if($row->Profilepic!=''){ echo $row->Profilepic; } else { echo "default-profile.png"; } ?>" alt="img" width="100px" height="100px" /> -->
								<?php echo $row->Firstname.' '.$row->Lastname; ?></a></p>
								</td>

								<td><p class="mt-3 mb-0"><?php 
if($row->City != "")
{
echo $row->City; 
}
?></p></td>
                                <td><p class="mt-3 mb-0"><?php 
if($row->State != "")
{
echo $row->State; 
}
?></p></td>
                                <td><p class="mt-3 mb-0"><?php
if($row->Coach_Website != ""){
 $check = "ttp:";
$pos = strpos($row->Coach_Website,$check);
if($pos){ ?>
 
 <a target="_blank" href="<?php echo $row->Coach_Website;?>"><?php echo "Click Here"; //$row->Coach_Website;?></a> 
 
<?php } else { ?>
 <a target="_blank" href="<?php echo "http://".$row->Coach_Website;?>">
 <?php echo "Click Here";//$row->Coach_Website;?></a>  
<?php } 
}else{
	echo "--";
} ?></p></td>

<td><p class="mt-3 mb-0">
<?php 
$get_coachratings = league::getCoachRatings($row->Users_ID);
//echo "<pre>";
//print_r($get_coachratings);

if($get_coachratings){?>
<a href="<?php echo base_url();?>coach/<?php echo $row->Users_ID;?>" target="_blank">
<?php 

               $s5=0;
			   $s4=0;
			   $s3=0;
			   $s2=0;
			   $s1=0;
			   $s0=0;

			   foreach ($get_coachratings as $key => $value) {
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
                if($value->Ratings==0){
                  $s0+=0;
                }
			   }
			   
			$avg_star_rating = ($s5*5 + $s4*4 + $s3*3 + $s2*2 + $s1*1 + $s0*1) / ($s5 + $s4 + $s3 + $s2 + $s1);
			//echo $avg_star_rating;
			//exit;

			if( is_float( $avg_star_rating ) ) { // Check to see if whole number or decimal
		        $rounded_ranking = round($avg_star_rating); // If decimal round it down to a whole number
		       
		        for ($counter=2; $counter <= $rounded_ranking; $counter++){ 
		            echo '<i class="fa fa-star checked"></i>';
		        }
		        echo '<i class="fa fa-star-half-o checked"></i>'; // Static half star used as the ranking value is a decimal and the is_float condition is met.
		       for(;$rounded_ranking<5;$rounded_ranking++){
		            echo '<i class="fa fa-star-o checked"></i>';
		        }
		    }
		    else if($avg_star_rating > -1){
		        // For Loop so we can run the stars as many times as is set, no offset need, as no half star required for whole number rankings
		        for ($counter=1; $counter <= $avg_star_rating; $counter++){
		            echo '<i class="fa fa-star checked"></i>';
		        }
		        for(;$avg_star_rating<5;$avg_star_rating++){
		            echo '<i class="fa fa-star-o checked"></i>';
		        }
		    }


	/*for($j=0;$j<5;$j++){
	if($j<$avg_star_rating){?>
        <i class="fa fa-star checked"></i>
	<?php }else{?>
        <i class="fa fa-star-half-o checked"></i>
	<?php } ?>
			 
	<?php }*/
?>

<?php 
//echo "( ".count($get_clubratings)." )";
?>
</a>
<?php
}else{
		for($j=0;$j<5;$j++){
	
       echo '<i class="fa fa-star-o checked"></i>';
	
			
	 }
}
?>
</p></td>
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