<!-- Add mousewheel plugin (this is optional) -->
<script type="text/javascript" src="<?=base_url();?>assets/fancybox/jquery.mousewheel-3.0.6.pack.js"></script>

<!-- Add fancyBox main JS and CSS files -->
<script type="text/javascript" src="<?=base_url();?>assets/fancybox/jquery.fancybox.js?v=2.1.5"></script>
<link rel="stylesheet" type="text/css" href="<?=base_url();?>assets/fancybox/jquery.fancybox.css?v=2.1.5" media="screen" />

<!-- Add Button helper (this is optional) -->
<link rel="stylesheet" type="text/css" href="<?=base_url();?>assets/fancybox/helpers/jquery.fancybox-buttons.css?v=1.0.5" />
<script type="text/javascript" src="<?=base_url();?>assets/fancybox/helpers/jquery.fancybox-buttons.js?v=1.0.5"></script>

<!-- Add Thumbnail helper (this is optional) -->
<link rel="stylesheet" type="text/css" href="<?=base_url();?>assets/fancybox/helpers/jquery.fancybox-thumbs.css?v=1.0.7" />
<script type="text/javascript" src="<?=base_url();?>assets/fancybox/helpers/jquery.fancybox-thumbs.js?v=1.0.7"></script>

<!-- Add Media helper (this is optional) -->
<script type="text/javascript" src="<?=base_url();?>assets/fancybox/helpers/jquery.fancybox-media.js?v=1.0.6"></script>


<script>
//var $= jQuery.noConflict();

//$(document).ready(function() {
	$(".fancybox-thumb").fancybox({
		prevEffect	: 'none',
		nextEffect	: 'none',
		helpers	: {
			title	: {
				type: 'outside'
			},
			thumbs	: {
				width	: 50,
				height	: 50
			}
		}
	});
//});
</script>

<!-- -----------------------------------------------view gallery link section ----------------------------------------------------  -->   
<div  id="blog_container">
<div class="fromtitle" style="padding-left:40px;"><?php echo $tour_details->tournament_title; ?> - Images</div>

	<?php
		//print_r($get_images);

		if(!empty($get_images))
		{
		foreach($get_images as $i => $row) { ?>
			<div class="col-md-3" style="margin-top:30px;">
				
			<?php
			$filename = base_url()."tour_pictures/".$row->Tournament_id."/".$row->Image_file;
			?>
				<a class="fancybox-thumb" rel="fancybox-thumb" href="<?php echo base_url();?>tour_pictures/<?php echo $row->Tournament_id;?>/<?php echo $row->Image_file;?>" title="">
					<img src="<?php echo base_url(); ?>tour_pictures/<?php echo $row->Tournament_id; ?>/thumbs/<?php if($row->Image_file!=""){echo $row->Image_file; } else { echo "";} ?>" alt="" />
				</a>

				<br />
			</div>
		 <?php }
		 }
		 else {
			echo "<b>No Images are uploaded yet.</b>";
		 }
	?>
</div>
<!-- ------------------------------------------------view gallery link section end----------------------------------------------------  --> 