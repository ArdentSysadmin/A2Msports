<script src="<?php echo base_url();?>js/bootstrap.min.js"></script>
<script src="<?php echo base_url();?>js/bootstrap-timepicker.min.js"></script>
<script src="<?php echo base_url();?>js/jquery-migrate-1.2.1.min.js" type="text/javascript"></script>
<script src="<?php echo base_url();?>js/responsive-tabs.js" type="text/javascript"></script>
<script src="<?php echo base_url();?>js/jquery.simple-dtpicker.js" type="text/javascript"></script>
<!--MENU-->
<script src="<?php echo base_url();?>js/menu/modernizr.custom.js" type="text/javascript"></script>
<script src="<?php echo base_url();?>js/menu/cbpHorizontalMenu.js" type="text/javascript"></script>

 <script src="<?php echo base_url();?>js/tabs.js" type="text/javascript"></script>

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