<script>
$(document).ready(function(){
   
	$("#import").click(function(){
        $("#upload").show();
		$("#import").hide();
    });

	$("#cancel").click(function(){
        $("#upload").hide();
		$("#import").show();
    });

	$("#img-winner").click(function(){
        $("#academy_pom").show();
		$("#pom_div").hide();
    });

	$("#pom_cancel").click(function(){
        $("#academy_pom").hide();
		$("#pom_div").show();
    });

});
</script>

 <script>
	$(document).ready(function(){

	var baseurl = "<?php echo base_url();?>";

	var academy_id = "<?php echo $org_details['Aca_ID']; ?>";
		
$('#txt_ac_pom').autocomplete({
	source: function( request, response ) {
  		$.ajax({
			url: baseurl+'search/academy_users',
  			dataType: "json",
			method: 'post',
			data: {
			   name_startsWith: request.term,
			   academy: academy_id,
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
				}));
			}
  		});
  	},
  	autoFocus: true,	      	
  	minLength: 1,
  	select: function( event, ui ) {
		var names = ui.item.data.split("|");						
		$('#txt_ac_pom_id').val(names[1]);
	}		      	
});


	});
</script>
<script>
$(document).ready(function(){

var baseurl = "<?php echo base_url();?>";

$('#pom_add').click(function (e) {

var user = $('#txt_ac_pom_id').val();

	  $.ajax({
		type: 'POST',
		url: baseurl+'academy/update_pom',
		data: $('#frm_academy_pom').serialize(),
		success: function () {
			location.reload();
		}
	  });
	  e.preventDefault();

	});
});
</script>


 <!--Right Column-->
           <div class="col-md-3">
		   
		   <!-- -------------Player of month start section------------------------------------ -->
				<!-- 
				<div class="atp-single-player">
				<label>PLAYER OF THE MONTH</label>
				<div class="top-score-title">
				<br />
				<?php $user = 214; 
				$org_pom = $org_details['POM'];

//				$get_user = $this->model_academy->get_user($org_pom);
				$get_user = $this->general->get_user($org_pom);
				$user_id = $this->session->userdata('users_id');
				?>

				<div id='pom_div'>
				<?php if($org_pom) {?> 
				<a href="<?php echo base_url();?>player/<?php echo $org_pom;?>"><?php echo ucfirst($get_user['Firstname'])." ".ucfirst($get_user['Lastname']); ?></a>
				<?php } else { echo "No Player is declared yet!"; } ?>
				<?php 
				//$creator = $this->get_org_creator($org_details['Aca_ID']);
				if($user_id == $creator OR $this->session->userdata('role') == 'Admin'){?>
				&nbsp;&nbsp;&nbsp;&nbsp;
				<img src='<?php echo base_url()."images/ico-images/Edit.png"; ?>' id='img-winner' class='edit_score img-winner' 
				width='30px' height='30px' style='cursor:pointer' />
				<?php } ?>
				</div>

				<form id='frm_academy_pom' name='frm_academy_pom' method="post" enctype="multipart/form-data" role='form'>
					<div id="academy_pom" style="display:none">
						<input type="text"  class='form-control' name="txt_ac_pom" id="txt_ac_pom" value=""  />
						<input type="hidden" class='form-control' name="txt_ac_pom_id" id="txt_ac_pom_id" value=""  />
						<input type="hidden" class='form-control' name="txt_org" id="txt_org" value="<?php echo $org_details['Aca_ID']; ?>"  />
						<input type="button" id='pom_add' value=" Add " style="margin-top:10px" class="league-form-submit1" />
						<input type="button" value="Cancel" id="pom_cancel" style="margin-top:10px" class="league-form-submit1" />
					</div>
				</form>
				</div>
				</div>
 -->	
 <!-- -------------Player of month end section------------------------------------ -->
			<!-- <br> -->
			<!-- -------------Latest News start Section-------------------------------------- -->
           <div class="top-score-title right-title hidden-xs" style="padding-left:20px;">

				 <?php if($org_details['Aca_ID']){ ?> 
                <h3> <a href="<?php echo base_url().$this->short_code;?>/news">Latest News </a>
				<?php }?>

				<!-- <h3> Latest News  -->	
				<?php 
					//$admin_users= array(214,215);
					$user_id = $this->session->userdata('users_id');
					$creator = $org_details['Aca_User_id'];
					$org_id	 = $org_details['Aca_ID'];
				
					if($user_id == $creator){ ?>
					 -  <a href="<?php echo base_url().$this->short_code;?>/news/add">ADD</a>
					 <?php } ?>
				</h3>

				<?php if(!empty($results)){
					foreach($results as $row){ ?>
                <div class="right-content">
                    <p class="news-title-right">
					<a href=<?php echo base_url().$this->short_code."/news/view/".$row->News_id ;?>>
					<?php 
						 $s = substr($row->News_title, 0, 25);
						 $res = substr($s, 0, strrpos($s, ' '));

						 echo $res . "...";
						 //exit;
					?>
					</a>
					</p>
                    <p class="txt-right">
					<?php 
						$abc = strip_tags($row->News_content);
						//$result = substr($abc, 0, strpos($abc, '.'));
						$result = substr($abc, 0, 300);

						echo $result . "...";
					?>
					</p>
                    <a href=<?php echo base_url().$this->short_code."/news/view/".$row->News_id ;?> class="ca-more"><i class="fa fa-angle-double-right"></i>more...</a>

					<?php $creator = $org_details['Aca_User_id']; //echo $creator;
						$user_id = $this->session->userdata('users_id'); //echo $user_id;
					 if($creator == $user_id){ ?>
					<p style="float:right"><a href=<?php echo base_url().$this->short_code."/news/edit/".$row->News_id ;?>><u>Edit</u></a>&nbsp;&nbsp;</p>
					<?php } ?>

                </div>
                <?php } } else if($user_id == $creator){ ?>
						<?php echo "<p><h4>No news is added yet!</h4></p>";?>
						<br /><br />
					<?php } else { ?>
							<h4>No news is added yet!</h4>
					<?php } ?>

          </div>
		<!-- -------------Latest News end section------------------------------------ -->
			
			<!-- <div style="clear:both"></div> -->  <!--gap  purpose b/w import an dplayer sectons  --> 

			<!-- -------------Import Players section start------------------------------------ --
			 <div class="col-md-12 atp-single-player">
			<!--  <label>IMPORT PLAYERS</label> 
          <div class="top-score-title col-md-12 hidden-xs">
			<br />
			<p class="txt-torn"><button class="league-form-submit1" id="import">Import Players</button></p>

			<form  method="post" enctype="multipart/form-data" action="<?php echo base_url(); ?>" role='form'>
				<div id="upload" style="Display:none">
					 <input type="file" id="fileInput" name="Profilepic"  />
					<input type="button" value="Import" style="margin-top:10px" class="league-form-submit1" />
					<input type="button" value="Cancel" id="cancel" style="margin-top:10px" class="league-form-submit1" />
				</div>
			</form>

          </div>
		</div>
			-- -------------Import Players section end------------------------------------ --
			-- -------------Photos section begin ------------------------------------ -->
		<!--<br>
          <div class="top-score-title hidden-xs right-title">
                <h3>Photos</h3> 
                <ul class="right-last-photo">
				<?php
				/*$get_tour_images = $this->general->get_aca_tour_images();
					$a = 1;
				foreach($get_tour_images as $i => $get_info)
				{
						$get_image		= $this->general->get_images($get_info->mt);
						$get_tour_sport = $this->general->get_images($get_info->mt);
						$tour_id		= $get_image['Tournament_id'];

					if($a <= 9){*/
				?>
                        <li>
                            <div class="jm-item second">
							    <div class="jm-item-wrapper">
								    <div class="jm-item-image">
									<?php
									/*$image_pic = base_url()."tour_pictures/".$tour_id."/thumbs/".$get_image['Image_file'];
									$image_loc = $_SERVER['DOCUMENT_ROOT']."tour_pictures/".$tour_id."/thumbs/".$get_image['Image_file'];
									if(file_exists($image_loc)){*/
									?>
									 <a href="<?php echo base_url().$this->short_code."/league/view/".$tour_id; ?>">
									 <img src="<?php echo $image_pic; ?>" width = "83px" height = "62.25px" alt="" />
									 </a>
									<?php /*} else {
										$get_tour_sport = $this->general->get_tour_sport($tour_id);
										$tour_pic		= $_SERVER['DOCUMENT_ROOT']."tour_pictures/".$get_tour_sport['TournamentImage'];
										if(file_exists($tour_pic) and $get_tour_sport['TournamentImage'] != ""){*/
									?>
									 <a href="<?php echo base_url().$this->short_code."/league/view/".$tour_id; ?>">
									 <img src="<?php echo $tour_pic; ?>" width = "83px" height = "62.25px" alt="" />
									 </a>
									<?php
										/*}
										else
										{
										 switch($get_tour_sport['SportsType']) {
											case 1:
											$tour_def_pic = "default_tennis.jpg";
											break;
											case 2:
											$tour_def_pic = "default_table_tennis.jpg";
											break;
											case 3:
											$tour_def_pic = "default_badminton.jpg";
											break;
											case 4:
											$tour_def_pic = "default_golf.jpg";
											break;
											case 5:
											$tour_def_pic = "default_racquet_ball.jpg";
											break;
											case 6:
											$tour_def_pic = "default_squash.jpg";
											break;
											case 7:
											$tour_def_pic = "default_pickleball.jpg";
											break;
											case 8:
											$tour_def_pic = "default_chess.jpg";
											break;
											case 9:
											$tour_def_pic = "default_carroms.jpg";
											break;
											case 10:
											$tour_def_pic = "default_volleyball.jpg";
											break;
											case 11:
											$tour_def_pic = "default_fencing.jpg";
											break;
											case 12:
											$tour_def_pic = "default_bowling.jpg";
											break;
											default:
											$tour_def_pic = "";
										}*/
									?>
									 <a href="<?php echo base_url().$this->short_code."/league/view/".$tour_id; ?>">
									 <img src="<?php echo base_url()."tour_pictures/".$tour_def_pic; ?>" width = "83px" height = "62.25px" alt="" />
									 </a>
									<?php
										//}
									// } ?>
								    </div>	
							    </div>
						    </div>
                        </li>
				<?php
				//	}
			//	$a++;
			//	}
				?>
                </ul>
          </div>
          </div> -->
		  </div>
		  </div>
		  </div>

		  </div><!-- Container close -->
		  </section>