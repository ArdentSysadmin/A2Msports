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

});

$(document).ready(function(){
   
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

	var academy_id = "<?php echo $org_details['Org_ID']; ?>";
		
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
           <div class="col-md-3 right-column"> 
		   
		   <!-- -------------Player of month start section------------------------------------ -->
				<div class="col-md-12 atp-single-player">
				<label>PLAYER OF THE MONTH</label>
				<div class="top-score-title col-md-12 hidden-xs">
				<br />
				<?php $user = 214; 
				$org_pom = $org_details['POM'];

				$get_user = $this->model_academy->get_user($org_pom);

				?>

				<div id='pom_div'>
				<?php if($org_pom) {?> 
				<a href="<?php echo base_url();?>player/<?php echo $org_pom;?>"><?php echo ucfirst($get_user['Firstname'])." ".ucfirst($get_user['Lastname']); ?></a>
				<?php } else { echo "No Player is declared yet!"; } ?>
				<?php if($user_id == $creator OR $this->session->userdata('role') == 'Admin'){?>
				&nbsp;&nbsp;&nbsp;&nbsp;
				<img src='<?php echo base_url()."images/ico-images/Edit.png"; ?>' id='img-winner' class='edit_score img-winner' 
				width='30px' height='30px' style='cursor:pointer' />
				<?php } ?>
				</div>

				<form id='frm_academy_pom' name='frm_academy_pom' method="post" enctype="multipart/form-data" role='form'>
					<div id="academy_pom" style="display:none">
						<input type="text"  class='form-control' name="txt_ac_pom" id="txt_ac_pom" value=""  />
						<input type="hidden" class='form-control' name="txt_ac_pom_id" id="txt_ac_pom_id" value=""  />
						<input type="hidden" class='form-control' name="txt_org" id="txt_org" value="<?php echo $org_details['Org_ID']; ?>"  />
						<input type="button" id='pom_add' value=" Add " style="margin-top:10px" class="league-form-submit1" />
						<input type="button" value="Cancel" id="pom_cancel" style="margin-top:10px" class="league-form-submit1" />
					</div>
				</form>
				</div>
				</div>
			<!-- -------------Player of month end section------------------------------------ -->
			
			<!-- -------------Latest News start Section------------------------------------ -->
           <div class="top-score-title col-md-12 right-title hidden-xs">

				 <?php if($org_details['Org_ID']){ ?> 
                <h3> <a href="<?php echo base_url();?>academy/news/<?php echo $org_details['Org_ID'];?>">Latest News </a>
				  <?php } else { ?> 
				  
					 <h3><a href="<?php echo base_url();?>academy/list_news">Latest News</a> </h3> 
						
					 <?php } ?>

					<!-- <h3> Latest News  -->
					
				<?php 
					//$admin_users= array(214,215);
					$user_id = $this->session->userdata('users_id');
					$creator = $org_details['Users_ID'];
					$org_id= $org_details['Org_ID'];
					?>
					<?php if($user_id == $creator){ ?>
					 -  <a href="<?php echo base_url();?>academy/news_add/<?php echo $org_id;?>">ADD</a>
					 <?php } ?>
				
				</h3>

				<?php if(!empty($results)){
					foreach($results as $row){ ?>
                <div class="right-content">
                    <p class="news-title-right">
					<a href=<?php echo base_url() ."academy/get_news_detail/" . $row->News_id ;?>>
					<?php 
						 $s = substr($row->News_title, 0, 25);
						 $res = substr($s, 0, strrpos($s, ' '));
						 //$pos=strpos($row->News_title, ' ', 20);
						 //$s = 	substr($row->News_title,0,$pos ); 
						echo $res . "...";
						 ?>
					</a>
					</p>
                    <p class="txt-right">
					<?php 
						$abc = strip_tags($row->News_content);
						$result = substr($abc, 0, strpos($abc, '.'));

						// $s = substr($row->News_content, 0, 75);
						//  $result = substr($s, 0, strrpos($s, ''));

						echo $result . "...";
					?>
					</p>

                    <a href=<?php echo base_url() ."academy/get_news_detail/" . $row->News_id ;?> class="ca-more"><i class="fa fa-angle-double-right"></i>more...</a>

					<?php $creator = $org_details['Users_ID']; //echo $creator;
						$user_id = $this->session->userdata('users_id'); //echo $user_id;
					 if($creator == $user_id){ ?>
					<p style="float:right"><a href=<?php echo base_url()."academy/edit/" . $row->News_id ;?>><u>Edit</u></a>&nbsp;&nbsp;</p>
					<?php } ?>

                </div>
                <?php } } else if($user_id == $creator){ ?>
						<?php echo "<p><h4>No News were added yet.</h4></p>";?>
						<br /><br />
					<?php } else { ?>
							
							<h4> No News were added yet.</h4>
							
					<?php } ?>

        </div>
		<!-- -------------Latest News end section------------------------------------ -->
			
			<div class="clear"></div><h3></h3>   <!--gap  purpose b/w import an dplayer sectons  --> 

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

		-- -------------Import Players section end------------------------------------ -->
		<!---- -------------Photos section begin------------------------------------ --

           <div class="top-score-title col-md-12 right-title">
                <h3>Photos</h3> 
                <ul class="right-last-photo">
                        <li>
                            <div class="jm-item second">
							    <div class="jm-item-wrapper">
								    <div class="jm-item-image">
									    <img src="<?php echo base_url();?>images/1.jpg" alt="" />
									    <div class="jm-item-description">
                                            <div class="jm-item-button">
                                                <i class="fa fa-plus"></i>
                                            </div>
                                        </div>
								    </div>	
							    </div>
						    </div>
                        </li>
                        <li>
                            <div class="jm-item second">
							    <div class="jm-item-wrapper">
								    <div class="jm-item-image">
									    <img src="<?php echo base_url();?>images/2.jpg" alt="" />
									    <div class="jm-item-description">
                                            <div class="jm-item-button">
                                                <i class="fa fa-plus"></i>
                                            </div>
                                        </div>
								    </div>	
							    </div>
						    </div>
                        </li>
                        <li>
                            <div class="jm-item second">
							    <div class="jm-item-wrapper">
								    <div class="jm-item-image">
									    <img src="<?php echo base_url();?>images/3.jpg" alt="" />
									    <div class="jm-item-description">
                                            <div class="jm-item-button">
                                                <i class="fa fa-plus"></i>
                                            </div>
                                        </div>
								    </div>	
							    </div>
						    </div>
                        </li>
                        <li>
                            <div class="jm-item second">
							    <div class="jm-item-wrapper">
								    <div class="jm-item-image">
									    <img src="<?php echo base_url();?>images/4.jpg" alt="" />
									    <div class="jm-item-description">
                                            <div class="jm-item-button">
                                                <i class="fa fa-plus"></i>
                                            </div>
                                        </div>
								    </div>	
							    </div>
						    </div>
                        </li>
                        <li>
                            <div class="jm-item second">
							    <div class="jm-item-wrapper">
								    <div class="jm-item-image">
									    <img src="<?php echo base_url();?>images/5.jpg" alt="" />
									    <div class="jm-item-description">
                                            <div class="jm-item-button">
                                                <i class="fa fa-plus"></i>
                                            </div>
                                        </div>
								    </div>	
							    </div>
						    </div>
                        </li>
                        <li>
                            <div class="jm-item second">
							    <div class="jm-item-wrapper">
								    <div class="jm-item-image">
									    <img src="<?php echo base_url();?>images/6.jpg" alt="" />
									    <div class="jm-item-description">
                                            <div class="jm-item-button">
                                                <i class="fa fa-plus"></i>
                                            </div>
                                        </div>
								    </div>	
							    </div>
						    </div>
                        </li>
                        <li>
                            <div class="jm-item second">
							    <div class="jm-item-wrapper">
								    <div class="jm-item-image">
									    <img src="<?php echo base_url();?>images/2.jpg" alt="" />
									    <div class="jm-item-description">
                                            <div class="jm-item-button">
                                                <i class="fa fa-plus"></i>
                                            </div>
                                        </div>
								    </div>	
							    </div>
						    </div>
                        </li>
                        <li>
                            <div class="jm-item second">
							    <div class="jm-item-wrapper">
								    <div class="jm-item-image">
									    <img src="<?php echo base_url();?>images/1.jpg" alt="" />
									    <div class="jm-item-description">
                                            <div class="jm-item-button">
                                                <i class="fa fa-plus"></i>
                                            </div>
                                        </div>
								    </div>	
							    </div>
						    </div>
                        </li>
                        <li>
                            <div class="jm-item second">
							    <div class="jm-item-wrapper">
								    <div class="jm-item-image">
									    <img src="<?php echo base_url();?>images/4.jpg" alt="" />
									    <div class="jm-item-description">
                                            <div class="jm-item-button">
                                                <i class="fa fa-plus"></i>
                                            </div>
                                        </div>
								    </div>	
							    </div>
						    </div>
                        </li>
                </ul>
          </div>
          </div> -->
		  
		  </section>


		  <!-- -----------view_home,view_news_edit,footer,view_right_column----------------------------------------------- -->