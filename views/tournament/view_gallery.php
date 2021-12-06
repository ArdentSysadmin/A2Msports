<!-- Gallery CSS -->
<link href="<?=base_url();?>assets/club_pages/assets/vendor/venobox.css" rel="stylesheet" />
<link href="<?=base_url();?>assets/club_pages/css/pg.css" rel="stylesheet" />
<!-- Gallery CSS -->
<script>
var club_url = "<?php echo $club_url; ?>";
$('body').on('click', '#upload_image', function(e){
        e.preventDefault();
        var formData = new FormData($(this).parents('form')[0]);
        var fi = document.getElementById('userfile');   
          
        if(fi.files.length > 0){
		$('#upload_images').html("<h4 style='font-color:#81a32b'>Images are processing. Please wait... </h4>");
        $.ajax({
            url: club_url+'league/upload_pics',
            type: 'POST',
            xhr: function() {
                var myXhr = $.ajaxSettings.xhr();
                return myXhr;
            },
            success: function (data) {
              alert("Images are Uploaded");
			  location.reload();
            },
            data: formData,
            cache: false,
            contentType: false,
            processData: false
        });

      }else{
         
          alert('Please select atleast one image file!');
          return false;
      }
       return false;
});

</script>

<!-- Add mousewheel plugin (this is optional) -->
<script type="text/javascript" src="<?=$this->config->item('club_pr_url')."/";?>assets/fancybox/jquery.mousewheel-3.0.6.pack.js"></script>

<!-- Add fancyBox main JS and CSS files -->
<!-- <script type="text/javascript" src="<?=$this->config->item('club_pr_url')."/";?>assets/fancybox/jquery.fancybox.js?v=2.1.5"></script>
<link rel="stylesheet" type="text/css" href="<?=$this->config->item('club_pr_url')."/";?>assets/fancybox/jquery.fancybox.css?v=2.1.5" media="screen" />
 -->
<!-- Add Button helper (this is optional) -->
<!-- <link rel="stylesheet" type="text/css" href="<?=$this->config->item('club_pr_url')."/";?>assets/fancybox/helpers/jquery.fancybox-buttons.css?v=1.0.5" />
<script type="text/javascript" src="<?=$this->config->item('club_pr_url')."/";?>assets/fancybox/helpers/jquery.fancybox-buttons.js?v=1.0.5"></script> -->

<!-- Add Thumbnail helper (this is optional) -->
<!-- <link rel="stylesheet" type="text/css" href="<?=$this->config->item('club_pr_url')."/";?>assets/fancybox/helpers/jquery.fancybox-thumbs.css?v=1.0.7" />
<script type="text/javascript" src="<?=$this->config->item('club_pr_url')."/";?>assets/fancybox/helpers/jquery.fancybox-thumbs.js?v=1.0.7"></script> -->

<!-- Add Media helper (this is optional) -->
<!-- <script type="text/javascript" src="<?=$this->config->item('club_pr_url')."/";?>assets/fancybox/helpers/jquery.fancybox-media.js?v=1.0.6"></script> -->
<!-- <script src="https://a2msports.com/assets/club_pages/assets/jquery/jquery-1.12.0.min.js"></script> -->

<div id="upload_images" style="display:none;">
<h4>Upload Tournament Images</h4>
<form method='post' enctype='multipart/form-data' action="<?php echo $this->config->item('club_pr_url'); ?>/league/upload_pics" role='form' >
	<div class='file_upload' id='f1'>
	<input name='userfile[]' id='userfile' type='file' multiple='multiple' onchange='readURL(this);'/>
	</div><br />
	<input type='hidden' name='tourn_id' value="<?php echo $tour_details->tournament_ID; ?>">
	<input type="button" name='upload_image' id="upload_image" value="Upload File" class="league-form-submit1"/>
</form>
</div>
<?php 
if(!empty($get_images)){
?>
	<div style='float:right;'>
	<?php
	//if($this->logged_user_role == 'Admin' or	$this->logged_user_role == 'RegPlayer' or ($is_logged_user_reg and !array_key_exists($this->logged_user, $team_captains)) or 	array_key_exists($this->logged_user, $team_captains)){
	if($this->logged_user){
	?>
	<!-- <img style='cursor:pointer' src="<?php //echo base_url();?>icons/upload_ico.png" alt="Upload" title="Upload Image" onclick='upload_images()' width='30px' /> -->
	<input type="button" name="add_imgs" id="add_imgs" value="Add Images" class="league-form-submit1" style="padding:8px;22px;" onclick='upload_images()'>
	<?php
		if($this->logged_user == 237) {
	?>
	<input type="button" name="vist_gallry" id="vist_gallry" value="Visit Gallery" class="league-form-submit1" style="padding:8px;22px;" />
	<?php
		}
	}
	?>
	</div>
	<div style='clear:both;'></div>
	<!-- <div id="blog_container"> -->

      <div id="portfolio" class="portfolio team-row">
      <div class="container">

      <div class="row portfolio-container">
<?php 
foreach($get_images as $i => $row){ ?>
		<!-- <div class="col-md-3" style="margin-top:30px;">
		<a class="fancybox-thumb" rel="fancybox-thumb" href="<?php //echo base_url(); ?>tour_pictures/<?php //echo $row->Tournament_id; ?>/<?php //if($row->Image_file!=""){ echo $row->Image_file; }else { echo ""; } ?>">
		<img class="img-responsive" src="<?php //echo base_url(); ?>tour_pictures/<?php //echo $row->Tournament_id; ?>/thumbs/<?php //if($row->Image_file!=""){ echo $row->Image_file; }else { echo ""; } ?>" alt="" height="205px" width="205px" />
		</a>
		<input type="hidden" value="<?php //echo base_url();?>tour_pictures/<?php //echo $row->Tournament_id;?>/<?php //echo $row->Image_file;?>" name="filename<?//=$i;?>" id="image" />
		<br />
		</div> -->
		<div class="col-lg-4 col-md-6 portfolio-item">
		<img src="<?php echo base_url(); ?>tour_pictures/<?php echo $row->Tournament_id; ?>/thumbs/<?php if($row->Image_file!=""){ echo $row->Image_file; }
		else { echo ""; } ?>" class="pg-img-fluid" alt="">
		<div class="portfolio-info">
		<a target='_blank' href="<?php echo base_url(); ?>tour_pictures/<?php echo $row->Tournament_id; ?>/<?php if($row->Image_file!=""){ echo $row->Image_file; }
		else { echo ""; } ?>" data-gall="portfolioGallery" class="venobox preview-link" title="App 1">
		<i class="fa fa-search-plus" aria-hidden="true"></i></a>
		</div>
		</div>
<?php } ?> 
</div>
</div>
</div>
<?php
}
else{ 
?>
	<div id='upload_icon'>
	<b>No Images are uploaded yet..</b>
	<?php
	//if($this->logged_user_role == 'Admin' or $this->logged_user_role == 'RegPlayer' or ($is_logged_user_reg and !array_key_exists($this->logged_user, $team_captains)) or array_key_exists($this->logged_user, $team_captains)) {
	if($this->logged_user) {
	?>
	<!-- <img src="<?php echo base_url();?>icons/upload_ico.png" alt="Upload" title="Upload Image"  onclick='upload_images()' width='30px' /> -->
	<input type="button" name="add_imgs" id="add_imgs" value="Add Images" class="league-form-submit1" style="padding:8px;22px;" onclick='upload_images()' />	
	<?php
	}
	?>
	</div>
<?php
}
?>

<script src="<?=base_url();?>assets/club_pages/assets/isotope-layout/isotope.pkgd.min.js"></script>
<script src="<?=base_url();?>assets/club_pages/assets/vendor/venobox.min.js"></script>


<script>
//var $= jQuery.noConflict();

$(document).ready(function() {
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
});
</script>

 <script>
  // Porfolio isotope and filter
  $(window).on('load', function() {
    var portfolioIsotope = $('.portfolio-container').isotope({
      itemSelector: '.portfolio-item'
    });

    $('#portfolio-flters li').on('click', function() {
      $("#portfolio-flters li").removeClass('filter-active');
      $(this).addClass('filter-active');

      portfolioIsotope.isotope({
        filter: $(this).data('filter')
      });
      aos_init();
    });

    // Initiate venobox (lightbox feature used in portofilo)
    $(document).ready(function() {
      $('.venobox').venobox();
    });
  });

  // Portfolio details carousel
  $(".portfolio-details-carousel").owlCarousel({
    autoplay: true,
    dots: true,
    loop: true,
    items: 1
  });

</script>