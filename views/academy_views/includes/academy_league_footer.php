<!-- Footer Wrapper Start -->
<div class="footer-wrapper">
  <div class="footer-top-area">
    <div id='contact' class="container">
      <div class="row">
        <div class="col-md-2 col-sm-6">&nbsp;</div>
        <div class="col-md-5 col-sm-6">
          <div class="footer-tags-widget">
            <div class="footer-widget-heading">
			<?php
			if($org_details['Aca_ID'] == 1166){
			?>
              <h3 style="margin-top:0px;">General Inquiries</h3>
			<?php
			}
			else{
			?>
              <h3 style="margin-top:0px;">Comments / Feedback</h3>
			<?php
			}
			?>
			</div>
            <div class="footer-widget-content">
              <form action="#">
  <div class="row">
    <div class="col-md-6">
      <div class="form-group">
        <input class="form-control" id="nameId" required name="name" placeholder="Full Name" type="text">
      </div>
    </div>
    <!-- .col-md-6 -->
    <div class="col-md-6">
      <div class="form-group">
        <input class="form-control" id="emailId" required name="email" placeholder="Email Address" type="email">
      </div>
    </div>
    <!-- .col-md-6 --> 
  </div>
  <div class="form-group">
    <input class="form-control" id="subjectId" required name="subject" placeholder="Subject" type="text">
  </div>
  <textarea class="form-control text-area" rows="3" placeholder="Message"></textarea>
  <button type="submit" class="btn btn-default">Submit</button>
</form>
            </div>
          </div>
        </div>
        <div class="col-md-3 col-sm-6">
          <div class="footer-contact">
            <div class="footer-widget-heading">
              <h3 style="margin-top:20px;">Contact Us</h3>
            </div>
            <div class="footer-widget-content">
              <ul class="footer-conatct-menu">
				<li> <a href="javascript:void(0)"><i class="fa fa-map-o"></i><span>Address :</span> <?php echo $org_details['Aca_addr1']; ?>, <?php echo $org_details['Aca_city']; ?>, <?php echo $org_details['Aca_state']; ?>, <?php echo $org_details['Aca_zip']; ?></a> </li>
                <!--<li> <a href="javascript:void(0)"><i class="fa fa-envelope"></i><span>Email :</span> <?php echo $org_details['Aca_contact_email']; ?></a> </li> -->
                <li> <a href="javascript:void(0)"><i class="fa fa-phone"></i> <span>Phone : </span> <?php echo $org_details['Aca_contact_phone']; ?></a> </li>
                
              </ul>
            </div>
          </div>
        </div>
        <div class="col-md-2 col-sm-6">&nbsp;</div>

      </div>
    </div>
  </div>
  <div class="copyright-wrapper">
    <div class="container">
      <p>&copy; Copyright <span id="year"></span> <?php echo $org_details['Aca_name']; ?> | All Rights Reserved.</p>
	  <p>Powered By <a href="https://a2msports.com" target='_blank'><img src="<?php echo base_url(); ?>assets/club_pages/images/a2mlogo.png" alt=""></a></p>
    </div>
  </div>
</div>
<!-- Footer Wrapper End -->


<!-- jQuery (necessary for Bootstrap's JavaScript plugins) --> 
<!-- <script src="<?php //echo base_url(); ?>assets/club_pages/assets/jquery/jquery-1.12.0.min.js"></script> -->
 <script src="https://code.jquery.com/jquery-migrate-1.3.0.min.js"></script>
<script src="<?php echo base_url(); ?>assets/club_pages/assets/bootstrap/js/bootstrap.min.js"></script> 
<script src="<?php echo base_url(); ?>assets/club_pages/assets/jquery/plugin.js"></script> 
<script src="<?php echo base_url(); ?>assets/club_pages/assets/jquery/plugins.js"></script> 
<script src="<?php echo base_url(); ?>assets/club_pages/assets/jquery/slider.js"></script> 
<script src="<?php echo base_url(); ?>assets/club_pages/assets/owl-carousel/js/owl.carousel.js"></script> 
<script src="<?php echo base_url(); ?>assets/club_pages/assets/wow/wow.min.js"></script> 
<script src="<?php echo base_url(); ?>assets/club_pages/assets/jquery/jquery.slicknav.js"></script> 
<script src="<?php echo base_url(); ?>assets/club_pages/js/custom.js"></script>
<script src="<?php echo base_url(); ?>assets/club_pages/assets/jquery/popup.js"></script> 

<!-- Copied from old view file -->
<script src="<?php echo base_url();?>js/jquery.simple-dtpicker.js" type="text/javascript"></script>
<!-- <script src="<?php echo base_url();?>js/custom.js" type="text/javascript"></script> -->
<!-- <script src="<?php echo base_url();?>js/jquery.autocomplete.js" type="text/javascript"></script> -->
<script src="<?php echo base_url();?>js/gallery/jquery.prettyPhoto.js" type="text/javascript"></script>
<!-- <script src="<?php echo base_url();?>js/gallery/isotope.js" type="text/javascript"></script> -->
<script src="<?php echo base_url();?>js/jquery-ui-custom.js"></script>

<script src="<?php echo base_url(); ?>js/jquery.datetimepicker.full.js"></script>
<script>
/*jslint browser:true*/
/*global jQuery, document*/

$(document).ready(function () {
	'use strict';

	$('#res_date, #search-from-date, #search-to-date').datetimepicker();
});

</script>


  <script src="<?=base_url();?>assets/club_pages/assets/isotope-layout/isotope.pkgd.min.js"></script>
  <script src="<?=base_url();?>assets/club_pages/assets/vendor/venobox.min.js"></script>

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

<?php
if($is_academy_league){
?>
<!-- <script src="https://code.jquery.com/jquery-1.10.2.min.js" type="text/javascript"></script> -->
<script src="<?php echo base_url();?>js/bootstrap.min.js"></script>
<script src="<?php echo base_url();?>js/bootstrap-timepicker.min.js"></script>
<script src="<?php echo base_url();?>js/jquery-migrate-1.2.1.min.js" type="text/javascript"></script>
<script src="<?php echo base_url();?>js/responsive-tabs.js" type="text/javascript"></script>
<script src="<?php echo base_url();?>js/jquery.simple-dtpicker.js" type="text/javascript"></script>
<!--MENU-->
<script src="<?php echo base_url();?>js/menu/modernizr.custom.js" type="text/javascript"></script>
<script src="<?php echo base_url();?>js/menu/cbpHorizontalMenu.js" type="text/javascript"></script>

 <script src="<?php echo base_url();?>js/tabs.js" type="text/javascript"></script>
<!--END MENU-->

<!-- Button Anchor Top-->
<!-- <script src="<?php echo base_url();?>js/jquery.ui.totop.js" type="text/javascript"></script> -->
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
<script src="<?php echo base_url();?>js/foundation-datepicker.js"></script>
<script>
$(function() {
$('#sdate').datepick();
$('#edate').datepick();
$('#reg_closedon').datepick();
});
</script>

<!-- <script src="<?php echo base_url();?>js/custom.js" type="text/javascript"></script> -->
<script src="<?php echo base_url();?>js/custom/general.js" type="text/javascript"></script>
<script src="<?php echo base_url();?>js/jquery.autocomplete.js" type="text/javascript"></script>
<script src="<?php echo base_url();?>js/jquery-ui-custom.js"></script>
<script src="<?php echo base_url();?>js/simple-lightbox.js"></script>
<script src="<?php echo base_url();?>js/simple-lightbox.min.js"></script>
<script src="<?php echo base_url();?>js/jquery.multiselect.js"></script>

<!-- jQuery DataTables -->
<script src="<?php echo base_url(); ?>js/DataTables-1.10.16/js/jquery.dataTables.min.js"></script>
<script src="<?php echo base_url(); ?>js/DataTables-1.10.16/js/dataTables.bootstrap.min.js"></script>
<?php
if(($this->logged_user_role == 'Admin' or $this->is_super_admin) and $tour_details->TShirt) {
?>
<script>
$(document).ready(function() {
$('#tourn_players').dataTable({dom: "<'row'<'col-sm-3'l><'col-sm-5'p><'col-sm-4'f>>" +
"<'row'<'col-sm-12'tr>>", searching: true, paging: false, lengthMenu: false, aoColumns: [ null,null,null,null,null,null,null,null,null,null,null ], language: {"search":"", "searchPlaceholder":"Search"} });
});
</script>
<?php
}
else if($this->logged_user_role == 'Admin' or $this->is_super_admin) {
?>
<script>
$(document).ready(function() {
$('#tourn_players').dataTable({dom: "<'row'<'col-sm-3'l><'col-sm-5'p><'col-sm-4'f>>" +
"<'row'<'col-sm-12'tr>>", searching: true, paging: false, lengthMenu: false, aoColumns: [ null,null,null,null,null,null,null,null,null,null ], language: {"search":"", "searchPlaceholder":"Search"} });
});
</script>
<?php
}
else if($this->logged_user_role == 'RegPlayer') {
?>
<script>
$(document).ready(function() {
$('#tourn_players').dataTable({dom: "<'row'<'col-sm-3'l><'col-sm-5'p><'col-sm-4'f>>" +
"<'row'<'col-sm-12'tr>>", searching: true, paging: false, lengthMenu: false, aoColumns: [ null,null,null,null,null,null,null ], language: {"search":"", "searchPlaceholder":"Search"} });
});
</script>
<?php
}
else {
?>
<script>
$(document).ready(function() {
$('#tourn_players').dataTable({dom: "<'row'<'col-sm-3'l><'col-sm-5'p><'col-sm-4'f>>" +
"<'row'<'col-sm-12'tr>>", searching: true, paging: false, lengthMenu: false, aoColumns: [ null,null,null,null,null,null ], language: {"search":"", "searchPlaceholder":"Search"} });
});
</script>
<?php
}

}
?>
<script>
$(document).ready(function () {             
  $('.dataTables_filter input[type="search"]').css(
     {'width':'155px','display':'inline-block', 'margin-left':'80px'}
  );
});
</script>
<script type="text/javascript" src="<?php echo base_url(); ?>js/wickedpicker.js"></script>
<!-- <link rel="stylesheet" type="text/css" href="<?php echo base_url();?>css/jquery.autocomplete.css" />
<script type="text/javascript" src="<?php echo base_url();?>include/jquery.autocomplete.js"></script> -->
</body>
</html>