
<section id="single_player" class="container secondary-page">


	<div class="top-score-title right-score col-md-9">
        <!-- start main body -->
		<h3></h3>
		<?php
		if($news_id_det)
		{ 
		?>
		<form class="form-horizontal" id='myform' method='post' role="form"  action="<?php echo base_url(); ?>academy/update_news/<?php echo $news_id_det['News_id'] ;?>"> 

			<input type="hidden" name="id" value="<?php echo $news_id_det['News_id'];?>" />
			
			<input type="hidden" class='form-control' value="<?php echo $org_id; ?>" name="org_id" />
                        
			 <div class="col-md-12 league-form-bg">

           		<div class="fromtitle"><?php echo $news_id_det['News_title']; ?></div>

                <div class="col-md-12">
                        <div>
                          <span style="color:red">*&nbsp;</span><b>News Title:</b>
						<br />
						<input type="text" class='form-control' value="<?php echo $news_id_det['News_title'] ?>" name="title" required/>
                        </div>
						<br />
						<div>
						  <b>Related to:</b>
						<br />
							<?php 
							 echo "<select class='form-control' name='sport' id=''>";
							 foreach($sports as $row)
							 { 
								?>
							 <option value='<?php echo $row->SportsType_ID ;?>'<?php echo trim($row->SportsType_ID) == $news_id_det['SportsType_id'] ? 'selected="selected"' : '' ?>><?php echo $row->Sportname ; ?></option>
							<?php 
							 }
							 echo "</select>";
							?>
								
						</div>
                        
						<br /><br />
						 <div>
                         <b>News Description:</b>
						 <br />
						 <?php echo $this->ckeditor->editor('description',stripslashes($news_id_det['News_content']));?> 

						<input type="submit" id="update" name="update"  value="UPDATE" class="league-form-submit1" style="margin:20px 0px"/>

                    </div>
                   
               </div>
        </div>

		</form>
		<?php 
		}
		else
		{ 
		?>
			<p style="line-height:20px; font-size:13px"><h5>Oops! Invalid Access. Please contact admin@a2msports.com</h5></p>
		<?php
		}
		?>
             
   </div><!--Close Top Match-->
