<div style="margin:10px">
<h3>Edit Testimonials
</div>
<div style="margin:10px">
<textarea name="testim_message" class="txt-area" id="testim_message" cols='120' rows='5' placeholder='Enter your Testimonial'><?php echo $det['testimonial'];  ?></textarea>
</div>
<div style="margin:10px">
<input type='text' name='testim_by' id='testim_by' class='form-control' style='width: 35%;' placeholder='Testimonial By' value='<?php echo $det['user_name'];  ?>' />
</div>
<div style="margin:10px">
<span><a href='<?=base_url();?>assets/club_facility/<?=$this->academy_id;?>/testimonial_users/<?=$det['user_img'];?>' target='_blank'><?php echo $det['user_img'];  ?></a></span>
<br /><br />
<input type='file' name='testim_by_img' id='testim_by_img' value='' placeholder='Image' /><br />
<b>Note: </b>For best fit, use 170 x 170 image.<br />
</div>
<div style="margin:20px">
<input type='hidden' name='prev_user_img' id='prev_user_img' value='<?php echo $det['user_img']; ?>' />
<input type='hidden' name='testim_id' id='testim_id' value='<?php echo $det['tab_id']; ?>' />
<input type='hidden' name='redirect_page' id='redirect_page' value='<?php echo $this->short_code.'/settings'; ?>' />
<input type='submit' name='btn_upd_testim' id='btn_upd_testim' value='  Update  ' style='margin-right:15px;' />
<input type='button' name='cancel_upd_testim' id='cancel_upd_testim' value='  Cancel  ' style='margin-right:15px;' />
<span id='btn_upd_testim_wt' style='display:none; font-weight:bold;'>Please wait ... </span>
</div>
<br /><br /><br />