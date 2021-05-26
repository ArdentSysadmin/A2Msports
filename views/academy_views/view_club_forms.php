<link href="<?=base_url();?>assets/club_pages/assets/vendor/venobox.css" rel="stylesheet">

<!-- Template Main CSS File -->
<link href="<?=base_url();?>assets/club_pages/css/pg.css" rel="stylesheet">

<!-- About Us End --> 

<section class="blog-wrapper" style="background:#fff">
  <div class="container">
    <div class="title">
      <h2>Forms</h2>
      <div><span></span></div>
    </div>

    <div class="team-row justify-content-center" id='lt-team'>
		<?php
			if($forms['terms_cond'] or $forms['priv_polic'] or $forms['waiver_form']){
				$path = base_url().'/assets/club_facility/'.$org_id."/forms/"; 
				$details = json_decode($club_pricing_info, TRUE);
				
					if($forms['terms_cond']){
		?>
			<div class="single-blog" style="border:0px;">
				<div class="blog-content" style="margin:30px; text-align:center;">
					<a href="<?=$path.$forms['terms_cond']; ?>" target='_blank'>
					<img src="<?php echo base_url(); ?>assets/club_pages/icons/terms_cond_ico.png" alt="Terms & Conditions" style="width:100px; height:auto;margin-bottom:5px;">
					<br />
					<b>Terms & Conditions</b></a>
				</div>
			</div>
		<?php	
					}
					if($forms['priv_polic']){
		?>
			<div class="single-blog" style="border:0px;">
				<div class="blog-content" style="margin:30px; text-align:center;">
					<a href="<?=$path.$forms['priv_polic']; ?>" target='_blank'>
					<img src="<?php echo base_url(); ?>assets/club_pages/icons/priv_polic_ico.png" alt="Privacy Policy" style="width:100px; height:auto; margin-bottom:5px;">
					<br />
					<b>Privacy Policy</b></a>
				</div>
			</div>
		<?php
					}
						if($forms['waiver_form']){
		?>
			<div class="single-blog" style="border:0px;">
				<div class="blog-content" style="margin:30px; text-align:center;">
					<a href="<?=$path.$forms['waiver_form']; ?>" target='_blank'>
					<img src="<?php echo base_url(); ?>assets/club_pages/icons/waiver_form_ico.png" alt="Waiver Form" style="width:100px; height:auto;margin-bottom:5px;">
					<br />
					<b>Waiver Form</b></a>
				</div>
			</div>
		<?php
					}
			}
			else{
		?>
		<div class="col-md-12 col-sm-6 text-center">No Forms are added yet!</div>
		<?php
			}
		?>
    </div>

  </div>
</section>