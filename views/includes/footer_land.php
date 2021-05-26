<footer>
<div class="content-footer">
  <div class="container">

	  <div class="col-md-7"><p>&copy; <?=date('Y');?> a2msports.com. All rights reserved. </p></div>
	  <!-- <div class="col-md-5"> -->
	  <div class="fb-like col-md-5" data-href="https://www.a2msports.com/" data-layout="button_count" data-action="like" data-show-faces="false" data-share="true"></div>
	  <!-- </div> -->
	  
	  <!--<div class="col-md-3" style="padding-right:50px">
		<a href='https://www.facebook.com/a2msports' target='_blank'><img src = "<?php echo base_url().'images/fb_round.png'; ?>" alt = 'Facebook Page' width = '25px' height='25px' align='right' /></a>
	  </div>-->

  </div>
</div>
</footer>

</section>
<!-- <script src="<?php echo base_url();?>js/jquery-1.10.2.js" type="text/javascript"></script> -->

<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

<script src="<?php echo base_url();?>js/jquery-migrate-1.2.1.min.js" type="text/javascript"></script>
<script src="<?php echo base_url();?>js/jquery.transit.min.js" type="text/javascript"></script>

<!--MENU-->
<script src="<?php echo base_url();?>js/menu/modernizr.custom.js" type="text/javascript"></script>
<script src="<?php echo base_url();?>js/menu/cbpHorizontalMenu.js" type="text/javascript"></script>
<!--END MENU-->

<!--Mini Flexslide-->
<script src="<?php echo base_url();?>js/minislide/jquery.flexslider.js" type="text/javascript"></script>

<!-- Percentace circolar -->

<script src="<?php echo base_url();?>js/circle/jquery-asPieProgress.js" type="text/javascript"></script>
<script src="<?php echo base_url();?>js/circle/rainbow.min.js" type="text/javascript"></script>

<!--Gallery-->
<script src="<?php echo base_url();?>js/gallery/jquery.prettyPhoto.js" type="text/javascript"></script>
<script src="<?php echo base_url();?>js/gallery/isotope.js" type="text/javascript"></script>

<!-- Button Anchor Top-->
<script src="<?php echo base_url();?>js/jquery.ui.totop.js" type="text/javascript"></script>
<script src="<?php echo base_url();?>js/custom.js" type="text/javascript"></script>
<script src="<?php echo base_url();?>js/jquery.bxslider.js" type="text/javascript"></script>
<!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/bxslider/4.2.15/jquery.bxslider.js" type="text/javascript"></script> -->

<!--Carousel News-->
<script src="<?php echo base_url();?>js/jquery.easing.1.3.js" type="text/javascript"></script>
<script src="<?php echo base_url();?>js/jquery.mousewheel.js" type="text/javascript"></script>

<!--Carousel Clients-->
<script src="<?php echo base_url();?>js/own/owl.carousel.js" type="text/javascript"></script>

<!--Count down-->
<script src="<?php echo base_url();?>js/jquery.countdown.js" type="text/javascript"></script>
<script src="<?php echo base_url();?>js1/custom_ini_land.js" type="text/javascript"></script>  

<!--  Fancy Box JS--> 
<!-- Add mousewheel plugin (this is optional) -->
<script type="text/javascript" src="<?=base_url();?>assets/fancybox/jquery.mousewheel-3.0.6.pack.js"></script>
<script type="text/javascript" src="<?=base_url();?>assets/fancybox/helpers/jquery.fancybox-buttons.js?v=1.0.5"></script>
<!-- Add fancyBox main JS and CSS files -->
<script type="text/javascript" src="<?=base_url();?>assets/fancybox/jquery.fancybox.js?v=2.1.5"></script>
<script type="text/javascript" src="<?=base_url();?>assets/fancybox/helpers/jquery.fancybox-thumbs.js?v=1.0.7"></script>

<!-- Add Media helper (this is optional) -->
<script type="text/javascript" src="<?=base_url();?>assets/fancybox/helpers/jquery.fancybox-media.js?v=1.0.6"></script>


<script>
//var $= jQuery.noConflict();

//$(document).ready(function() {
  $(".fancybox-thumb").fancybox({
    prevEffect  : 'none',
    nextEffect  : 'none',
    helpers : {
      title : {
        type: 'outside'
      },
      thumbs  : {
        width : 50,
        height  : 50
      }
    }
  });
//});
</script>
<!-- End Fancy BOX-->

<!-- Global site tag (gtag.js) - Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id=UA-110374306-1"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'UA-110374306-1');

//  var width = $(window).width();

/*var myslider = $('ul .bxslider').bxSlider({
    maxSlides: (width < 430) ? 3 : 6,
});*/
</script>


</body>
</html>