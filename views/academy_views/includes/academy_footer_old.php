<!--FOOTER-->   
<footer>
<div class="content-footer">
  <div class="container">
	  <div class="col-md-7"><p>© 2016 a2msports.com. All rights reserved. </p></div>
	  <!-- <div class="col-md-5"> -->
	  <div class="fb-like col-md-5" data-href="https://www.a2msports.com/" data-layout="button_count" data-action="like" data-show-faces="false" data-share="true"></div>
  </div>
</div>
</footer>

</section>
<!-- <script src="<?php echo base_url();?>js/jquery-1.10.2.js" type="text/javascript"></script> -->
<script src="<?php echo base_url();?>js/jquery-migrate-1.2.1.min.js" type="text/javascript"></script>
<script src="<?php echo base_url();?>js/responsive-tabs.js" type="text/javascript"></script>
<script src="<?php echo base_url();?>js/jquery.simple-dtpicker.js" type="text/javascript"></script>
<!--MENU-->
<script src="<?php echo base_url();?>js/menu/modernizr.custom.js" type="text/javascript"></script>
<script src="<?php echo base_url();?>js/menu/cbpHorizontalMenu.js" type="text/javascript"></script>
<script src="<?php echo base_url();?>js/tabs.js" type="text/javascript"></script>
<!--END MENU-->

<!-- Button Anchor Top-->
<script src="<?php echo base_url();?>js/jquery.ui.totop.js" type="text/javascript"></script>
<script src="<?php echo base_url();?>js/jquery.accordion.js" type="text/javascript"></script>
    <script>
		$('.accordion__content:not(:first)').hide();
		$('.accordion__title:first-child').addClass('active');
		$('.accordion__title').on('click', function () {
		$('.accordion__content').hide();
		$(this).next().show().prev().addClass('active').siblings().removeClass('active');
		});
      //@ sourceURL=pen.js
    </script>
<!--PERCENTAGE-->
<script>
    $(function () {
        "use strict";
        $('.skillbar-pp').each(function () {
            $(this).find('.skillbar-bar-pp').width(0);
        });

        $('.skillbar-pp').each(function () {
            $(this).find('.skillbar-bar-pp').animate({
                width: $(this).attr('data-percent')
            }, 2000);
        });
    });
</script>

<script src="<?php echo base_url(); ?>js/jquery.plugin.js"></script>
<script src="<?php echo base_url(); ?>js/jquery.datepick.js"></script>


<script>
$(function() {
 $('#sdate').datepick();
 $('#edate').datepick();
 $('#reg_closedon').datepick();
});
</script>


<script type="text/javascript" charset="utf-8">
    $(document).ready(function () {
        "use strict";
        $(".portfolio a").hover(function () {
            $(this).children("img").animate({ opacity: 0.75 }, "fast");
        }, function () {
            $(this).children("img").animate({ opacity: 1.0 }, "slow");
        });

        $("a[rel^='prettyPhoto']").prettyPhoto({
            animation_speed: 'fast', /* fast/slow/normal */
            slideshow: 5000, /* false OR interval time in ms */
            autoplay_slideshow: false, /* true/false */
            opacity: 0.80, /* Value between 0 and 1 */
            show_title: true, /* true/false */
            allow_resize: true, /* Resize the photos bigger than viewport. true/false */
            default_width: 500,
            default_height: 344,
            counter_separator_label: '/', /* The separator for the gallery counter 1 "of" 2 */
            theme: 'pp_default', /* light_rounded / dark_rounded / light_square / dark_square / facebook */
            horizontal_padding: 20, /* The padding on each side of the picture */
            hideflash: false, /* Hides all the flash object on a page, set to TRUE if flash appears over prettyPhoto */
            wmode: 'opaque' /* Set the flash wmode attribute */
        });
    });

</script>

     
<script type="text/javascript">

    $(window).load(function () {
        "use strict";
        var $container = $('.albumContainer');
        $container.isotope({
            filter: '*',
            animationOptions: {
                duration: 750,
                easing: 'linear',
                queue: false
            }
        });

        $('.albumFilter li').on('click', function (e) {
            $('.albumFilter .current').removeClass('current');
            $(this).addClass('current');

            var selector = $(this).attr('data-filter');
            $container.isotope({
                filter: selector,
                animationOptions: {
                    duration: 750,
                    easing: 'linear',
                    queue: false
                }
            });
            return false;
        });
    });

</script>

<script src="<?php echo base_url();?>js/custom.js" type="text/javascript"></script>
<script src="<?php echo base_url();?>js/jquery.autocomplete.js" type="text/javascript"></script>
<script src="<?php echo base_url();?>js/gallery/jquery.prettyPhoto.js" type="text/javascript"></script>
<script src="<?php echo base_url();?>js/gallery/isotope.js" type="text/javascript"></script>
<script src="<?php echo base_url();?>js/jquery-ui-custom.js"></script>

</body>
</html>