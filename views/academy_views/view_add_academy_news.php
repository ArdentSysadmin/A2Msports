

<section id="single_player" class="container secondary-page">


	<div class="top-score-title right-score col-md-9">
        <!-- start main body -->
		<h3></h3>

		<?php 
		if(isset($add_news)) { ?>
	   <div class="name" align='left'>
			<label for="name_login" style="color:green"><?php echo $add_news; ?></label>
	   </div>
		<?php } ?>
		
		<form class="form-horizontal" id='myform' method='post' role="form"  action="<?php echo base_url(); ?>academy/add_news/<?php echo $org_id; ?>"> 

			 <div class="col-md-12 league-form-bg">

           		<div class="fromtitle">Add Academy News</div>

                <div class="col-md-12">
                        <div>
                        <span style="color:red">*&nbsp;</span><b>Title:</b>
						<br />
						<input type="text" class='form-control' value="" name="title" minlength=10 required />
                        </div>
						<br /><br />

						<div>
						 <b>Related to sport:</b>
						<br />
							<select name="Sport" id="Sport" class='form-control' >
							<!-- <option value="">Select</option> -->
							<?php foreach($sports as $row) { ?>

								<option value="<?php echo $row->SportsType_ID;?>">
								<?php echo $row->Sportname;?> 
								</option>
							<?php } ?>
							 
							</select>
						</div>
                        
						<br /><br />
						 <div>
                         <b>Content:</b>
						 <br />
					   
						<?php echo $this->ckeditor->editor('description',@$default_value);?> 
                        </div>

						<div>
						<input type="hidden" class='form-control' value="<?php echo $org_id; ?>" name="org_id" />
                        </div>

						<input type="submit" id="add_news" name="add_news"  value="Submit" class="league-form-submit1" style="margin:20px 0px"/>


                    </div>
                   
               </div>
        </div>

		</form>
		
             
   </div><!--Close Top Match-->
