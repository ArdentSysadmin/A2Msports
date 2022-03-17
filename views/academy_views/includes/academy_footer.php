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
<form name='club-contact' id='club-contact' action="<?=$this->config->item('club_form_url');?>/contact_us" method="POST">
  <div class="row">
    <div class="col-md-6">
      <div class="form-group">
	  	<input type='hidden' name='contact_redirect' id='contact_redirect' value='<?php echo $_SERVER['REQUEST_URI']; ?>' />

        <input class="form-control" id="nameId" required name="contactus_name" placeholder="Your Name" type="text">
      </div>
    </div>
    <!-- .col-md-6 -->
    <div class="col-md-6">
      <div class="form-group">
        <input class="form-control" id="emailId" required name="contactus_email" placeholder="Email" type="email">
      </div>
    </div>
    <!-- .col-md-6 --> 
  </div>
  <div class="form-group">
    <input class="form-control" id="subjectId" required name="contactus_subject" placeholder="Subject" type="text">
  </div>
  <textarea class="form-control text-area" rows="3" placeholder="Message" name="contactus_msg"></textarea>
  <button type="submit" class="btn btn-default">Submit</button>

</form>
            </div>
          </div>
        </div>
        <div class="col-md-3 col-sm-6">
          <div class="footer-contact">
            <div class="footer-widget-heading">
              <h3 style="margin-top:0px;">Contact Us</h3>
            </div>
            <div class="footer-widget-content">
              <ul class="footer-conatct-menu">
				<li style="margin-bottom: 10px; line-height: 25px;"> <a href="javascript:void(0)">
				<i class="fa fa-map-o"></i> <?php echo $org_details['Aca_addr1']; ?>, <br><?php echo $org_details['Aca_city']; ?>, <?php echo $org_details['Aca_state']; ?>, <?php echo $org_details['Aca_zip']; ?></a> </li>
				<?php if($org_details['Aca_ID'] == 1166 and $org_details['Aca_contact_email']){ ?>
                <li> <a href="javascript:void(0)"><i class="fa fa-envelope"></i> <?php echo $org_details['Aca_contact_email']; ?></a> </li>
				<?php
				} ?>
                <li style="margin-bottom: 10px;"> <a href="javascript:void(0)"><i class="fa fa-phone"></i> <?php echo $org_details['Aca_contact_phone']; ?></a> </li>
                
              </ul>
            </div>
			<div>
			<?php
				//$fb_link = 'https://www.facebook.com/a2msports';
				//$insta_link = 'https://www.instagram.com/a2msports/';
				//$tw_link = 'https://twitter.com/a2m_sports';

				if($org_details['Facebook_Page'])
					 $fb_link = "https://www.facebook.com/".$org_details['Facebook_Page'];
				if($org_details['Instagram_Page'])
					 $insta_link = "https://www.instagram.com/".$org_details['Instagram_Page'];
				if($org_details['Twitter_Handle'])
					 $tw_link = "https://www.twitter.com/".$org_details['Twitter_Handle'];

			if($fb_link){
			?>
				<a href="<?=$fb_link; ?>" target='_blank'>
				<img src='<?php echo base_url();?>assets/club_pages/icons/facebook.png' />
				</a>
				&nbsp;&nbsp;
			<?php
			}
			if($insta_link){
			?>
				<a href="<?=$insta_link; ?>" target='_blank'>
				<img src='<?php echo base_url();?>assets/club_pages/icons/instagram.png' style="width:36px; height:36px;" /></a>
				&nbsp;&nbsp;
			<?php
			}
			if($tw_link){
			?>
				<a href="<?=$tw_link; ?>" target='_blank'>
				<img src='<?php echo base_url();?>assets/club_pages/icons/twitter.png' />		
				</a>
			<?php
			}
			?>
			</div>
          </div>
        </div>
        <div class="col-md-2 col-sm-6">&nbsp;</div>

      </div>
    </div>
  </div>
  <div class="copyright-wrapper">
    <div class="container">
      <p>&copy; Copyright <span id="year"></span> <b><?php echo $org_details['Aca_name']; ?></b> | All Rights Reserved.</p>
	  <p>Powered By <a href="https://a2msports.com" target='_blank'><img src="<?php echo base_url(); ?>assets/club_pages/images/a2mlogo.png" alt=""></a></p>
    </div>
  </div>
</div>
<!-- Footer Wrapper End -->


<!-- jQuery (necessary for Bootstrap's JavaScript plugins) --> 
<script src="<?php echo base_url(); ?>assets/club_pages/assets/jquery/jquery-1.12.0.min.js"></script> 
<script src="<?php echo base_url(); ?>assets/club_pages/assets/bootstrap/js/bootstrap.min.js"></script> 
<script src="<?php echo base_url(); ?>assets/club_pages/assets/jquery/plugin.js"></script> 
<script src="<?php echo base_url(); ?>assets/club_pages/assets/jquery/plugins.js"></script> 
<script src="<?php echo base_url(); ?>assets/club_pages/assets/jquery/slider.js"></script> 
<script src="<?php echo base_url(); ?>assets/club_pages/assets/owl-carousel/js/owl.carousel.js"></script> 
<script src="<?php echo base_url(); ?>assets/club_pages/assets/wow/wow.min.js"></script> 
<script src="<?php echo base_url(); ?>assets/club_pages/assets/jquery/jquery.slicknav.js"></script> 
<script src="<?php echo base_url(); ?>assets/club_pages/assets/jquery/popup.js"></script> 

<!-- Copied from old view file -->
<script src="<?php echo base_url();?>js/jquery.simple-dtpicker.js" type="text/javascript"></script>
<!-- <script src="<?php echo base_url();?>js/custom.js" type="text/javascript"></script> -->
<script src="<?php echo base_url();?>js/jquery.autocomplete.js" type="text/javascript"></script>
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

	var c_msg = "<?php echo $this->session->flashdata('contact_success'); ?>";
	if(c_msg != ""){
		alert(c_msg);
	}
});

</script>

<script src="<?=base_url();?>assets/club_pages/assets/isotope-layout/isotope.pkgd.min.js"></script>
<script src="<?=base_url();?>assets/club_pages/assets/vendor/venobox.min.js"></script>
	<!-- <script type="text/javascript" src="<?php echo base_url(); ?>static_assets/js/domEdit.js"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>static_assets/js/app.js"></script> -->
 <script>
  // Porfolio isotope and filter
  /*$(window).on('load', function() {
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
  });*/

  // Portfolio details carousel
  /*$(".portfolio-details-carousel").owlCarousel({
    autoplay: true,
    dots: true,
    loop: true,
    items: 1
  });*/

</script>
<script src="<?php echo base_url(); ?>assets/club_pages/js/custom.js"></script>

<!--  -------------------------------------  -->

<!-- <script src="https://code.jquery.com/jquery-3.5.1.js"></script> -->
<script src="https://cdn.datatables.net/1.10.24/js/dataTables.bootstrap4.min.js"></script>
<script src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.min.js"></script>
<link href='https://cdn.datatables.net/1.10.24/css/jquery.dataTables.min.css' rel='stylesheet' type='text/css' />
<!-- <link href='https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.2/css/bootstrap.css' rel='stylesheet' type='text/css' /> -->
 <link href='https://cdn.datatables.net/1.10.24/css/dataTables.bootstrap4.min.css' rel='stylesheet' type='text/css' /> 

<script>
$(document).ready(function() {
$('#players_rank_rating').dataTable({dom: "<'row'<'col-md-3'i><'col-md-5'p><'col-md-4'f>>", searching: true, paging: true, lengthMenu: false, pageLength: 20, aoColumns: [ null,null,null,null ], order: [[ 3, "desc" ]], language: {"search":"", "searchPlaceholder":"Search"} });

$('#club_members_list_view').dataTable({dom: "<'row'<'col-md-3'i><'col-md-5'p><'col-md-4'f>>", searching: true, paging: true, lengthMenu: false, pageLength: 20, aoColumns: [ null,null,null,null,null ], order: [[ 0, "desc" ]], language: {"search":"", "searchPlaceholder":"Search"} });

$('#gpa_clubs').dataTable({dom: "<'row'<'col-sm-3'l><'col-sm-5'p><'col-sm-4'f>>" +
"<'row'<'col-sm-12'tr>>", searching: true, paging: false, lengthMenu: false, aoColumns: [ null,null,null,null ], language: {"search":"", "searchPlaceholder":"Search"} });
});

$(document).ready(function(){
    $(".nav-tabs a").click(function(){
        $(this).tab('show');
    });
    
});

</script>

</body>
</html>