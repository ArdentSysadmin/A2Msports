<!--FOOTER--> 
<section id="footer-tag">
<div class="container">
<div class="col-md-12">
<div class="col-md-4 hidden-xs" style="text-align:justify">
<h3>About Us</h3>
<p>A2M Sports is a social platform for sports lovers, from Amateurs to Masters. It finds other players like you with similar interests, helps you keep track of your scores and manage your progress along the way. At A2M Sports, our mission is to help every player achieve their maximum potential by providing easy and convenient options to play.</p>

<p>We help sports academies or any business entities to organize variety of leagues or tournaments and keep the data for statistics and ranking purposes.</p>

<p style="float:right"><a href="<?php echo base_url();?>aboutus"><font color="#ffffff"><u>Read More</u></font></a></p>
</div>
<div class="col-md-4 hidden-xs">
<h3>Latest News</h3>
<?php foreach($results as $row ){ ?>
<ul class="footer-last-news">
<li>
<?php 
$admin_users= array(214,215);
$user_id = $this->session->userdata('users_id');
if(in_array($user_id, $admin_users)){ ?>
<p style="float:right"><a href=<?php echo base_url()."news/edit/" . $row->News_id ;?>><font color="#ffffff"><u>Edit</u></font></a></p> 
<?php }?>
<a href=<?php echo base_url()."news/" . $row->News_id ;?>>

<img class="" src="<?php echo base_url(); ?>tour_pictures/<?php 
if($row->SportsType_id == 1){echo "default_tennis.jpg"; }
else if($row->SportsType_id == 2){echo "default_table_tennis.jpg"; }
else if($row->SportsType_id == 3){echo "default_badminton.jpg"; }
else if($row->SportsType_id == 4){echo "default_golf.jpg"; }
else if($row->SportsType_id == 5){echo "default_racquet_ball.jpg"; }
else if($row->SportsType_id == 6){echo "default_squash.jpg"; }
else if($row->SportsType_id == 7){echo "default_pickleball_new.jpg"; }
else if($row->SportsType_id == 8){echo "default_chess.jpg"; }
else if($row->SportsType_id == 9){echo "default_carroms.jpg"; }
else if($row->SportsType_id == 10){echo "default_volleyball.jpg"; }
else if($row->SportsType_id == 11){echo "default_fencing.jpg"; }
else if($row->SportsType_id == 12){echo "default_bowling.jpg"; }
else if($row->SportsType_id == -1){echo "logo_fb.jpg"; }
?>" width='108px' height='81px' alt="" />
<p><?php
$abc	= strip_tags($row->News_content);
$s		= substr($abc, 0, 75);
$result = substr($s, 0, strrpos($s, '.'));
echo strip_tags($s) . "...";
?>
</p>
</a>
</li>
</ul>
<li style="clear:both; height:1px; list-style:none"></li>
<?php } ?>
</div>
<div class="col-md-4 footer-newsletters hidden-xs">
<h3>&nbsp;</h3>
<div id="loader"><br /><br /><br /><br /><br />
<input type="submit" name='req_demo' id='req_demo' value="Request a Demo"/>
</div>
</div>
<div class="col-xs-12"></div>
</div>
</div>
</section>
<footer>
<div class="content-footer">
<div class="container">
<div class="col-md-7">
<p>&copy; <?=date('Y');?> a2msports.com. All rights reserved. &nbsp;&nbsp;
<a id='priv_policy' style="cursor:pointer;color:#FFF">Privacy Policy</a></p>
</div>
<!-- <div class="col-md-5"> -->
<!-- <div class="fb-like col-md-5" data-href="https://www.a2msports.com/" data-layout="button_count" data-action="like" data-show-faces="false" data-share="true"></div> -->
</div>

</div>
</footer>

</section>
<!-- <script src="<?php //echo base_url();?>js/jquery-1.10.2.js" type="text/javascript"></script> -->
<script src="https://code.jquery.com/jquery-1.10.2.min.js" type="text/javascript"></script>
<script src="<?php echo base_url();?>js/bootstrap.min.js"></script>
<script src="<?php echo base_url();?>js/bootstrap-timepicker.min.js"></script>
<script src="<?php echo base_url();?>js/jquery-migrate-1.2.1.min.js" type="text/javascript"></script>
<script src="<?php echo base_url();?>js/responsive-tabs.js" type="text/javascript"></script>
<!--MENU-->
<script src="<?php echo base_url();?>js/menu/modernizr.custom.js" type="text/javascript"></script>
<script src="<?php echo base_url();?>js/menu/cbpHorizontalMenu.js" type="text/javascript"></script>

<!--END MENU-->

<!-- Button Anchor Top-->
<!-- <script src="<?php echo base_url();?>js/jquery.ui.totop.js" type="text/javascript"></script> -->
<!--PERCENTAGE-->





<script src="<?php echo base_url();?>js/custom/general.js" type="text/javascript"></script>
<script src="<?php echo base_url();?>js/jquery.autocomplete.js" type="text/javascript"></script>
<script src="<?php echo base_url();?>js/jquery.multiselect.js"></script>
<script src="<?php echo base_url();?>js/jquery-ui-custom.js"></script>

<script>
// Ajax post for refresh captcha image.
$(document).ready(function() {
	$("#req_demo").click(function() {
	baseurl = "<?php echo base_url(); ?>";
	window.location.href = baseurl+"help/demo";
	});

	$("#reload").click(function() {
		jQuery.ajax({
			type: "POST",
			url: "<?php echo base_url(); ?>" + "home/captcha_refresh",
			success: function(res) {
				if(res)
				{
				jQuery("div.image").html(res);
				}
			}
		});
	});
});
</script>

<script>
$(document).ready(function() {

	$('#priv_policy').click(function(){
	var baseurl = "<?php echo base_url(); ?>";

		$.ajax({
			type: "POST",
			async:false,
			url:baseurl+'home/priv_policy/',
			dataType: "html",
			success: function(res){
				var w = window.open('', null, "height=650, width=550, status=yes, toolbar=no, menubar=no, location=no");
				w.document.open();
				w.document.write(res);
				w.document.close();
			}
		});
	});

});
</script>
<script src="<?php echo base_url();?>js/custom.js" type="text/javascript"></script>
</body>
</html>