<!--FOOTER-->   
    <section id="footer-tag">
           <div class="container">
             <div class="col-md-12">
              <div class="col-md-4 hidden-xs">
                 <h3>About Us</h3>
                 <p>A2M Sports is a social platform for sports lovers, from Amateurs to Masters. It finds other players like you with similar interests, helps you keep track of your scores and manage your progress along the way. At A2M Sports, our mission is to help every player achieve their maximum potential by providing easy and convenient options to play.</p>
                 
				 <p>We help sports academies or any business entities to organize variety of leagues or tournaments and keep the data for statistics and ranking purposes.</p>

		<p style="float:right"><a href="<?php echo base_url();?>aboutus"><font color="#ffffff"><u>Read More</u></font></a></p>
              </div>
<!--               <div class="col-md-3 cat-footer">
                
                <h3 class='last-cat'>Categories</h3>
                <ul class="last-tips">
                  <li><a href="index.html">Home</a></li>
                  <li><a href="create-league.html">Sports</a></li>
                  <li><a href="member-list.html">Members</a></li>
                  <li><a href="calendar.html">Calendar</a></li>
                  <li><a href="help.html">Help</a></li>
                  <li><a href="contactus.html">Contact us</a></li>
                </ul>
              </div>
 -->              <div class="col-md-4 hidden-xs">
                 <h3>Latest News</h3>
				
				 <?php foreach($results as $row ){ ?>

                 <ul class="footer-last-news">
                    <li>
					<?php 
						$admin_users= array(214,215);
						$user_id = $this->session->userdata('users_id');
				 if(in_array($user_id, $admin_users)){ ?>
					<p style="float:right"><a href=<?php echo base_url()."News/edit/" . $row->News_id ;?>><font color="#ffffff"><u>Edit</u></font></a></p> 
					<?php }?>
					<a href=<?php echo base_url()."News/get_news_detail/" . $row->News_id ;?>>
					
					<img class="" src="<?php echo base_url(); ?>tour_pictures/<?php 
						 if($row->SportsType_id == 1){echo "default_tennis.jpg"; }
					else if($row->SportsType_id == 2){echo "default_table_tennis.jpg"; }
					else if($row->SportsType_id == 3){echo "default_badminton.jpg"; }
					else if($row->SportsType_id == 4){echo "default_golf.jpg"; }
					else if($row->SportsType_id == 5){echo "default_racquet_ball.jpg"; }
					else if($row->SportsType_id == 6){echo "default_squash.jpg"; }
					else if($row->SportsType_id == 7){echo "default_pickleball.jpg"; }
			    ?>" alt="" />

					<p><?php 
						 // $s = substr($row->News_content, 0, 75);
						 // $result = substr($s, 0, strrpos($s, ' '));

						 $abc = strip_tags($row->News_content);
						  $s = substr($abc, 0, 75);
						 $result = substr($s, 0, strrpos($s, '.'));
						 echo strip_tags($s) . "...";
					?>
					</p>
					
					</li>
					</a>
                 </ul>
				 <li style="clear:both; height:1px; list-style:none"></li>
				  <?php } ?>
              </div>
              <div class="col-md-4 footer-newsletters hidden-xs">
                <h3>Request a Demo</h3>
                <form method="post" action='<?php echo base_url(); ?>help/req_demo' >     
                    <div class="name">
                        <label for="name">* Name:</label><div class="clear"></div>
                        <input id="name" name="txt_req_name" type="text" placeholder="e.g. Mr. John Doe" required/>
                    </div>
                    <div class="email">
                        <label for="email">* Email:</label><div class="clear"></div>
                        <input id="email" name="txt_req_email" type="text" placeholder="example@domain.com" required/>
                    </div>
                    <div id="loader">
                        <input type="submit" value="Submit"/>
                    </div>
                </form>
              </div>
              <div class="col-xs-12">
                <!-- <ul class="social">
                      <li><a href="#"><i class="fa fa-facebook"></i></a></li>
                      <li><a href="#"><i class="fa fa-twitter"></i></a></li>
                      <li><a href="#"><i class="fa fa-linkedin"></i></a></li>
                      <li><a href="#"><i class="fa fa-digg"></i></a></li>
                      <li><a href="#"><i class="fa fa-rss"></i></a></li>
                      <li><a href="#"><i class="fa fa-youtube"></i></a></li>
                      <li><a href="#"><i class="fa fa-tumblr"></i></a></li>

                    </ul> -->
              </div>
             </div>
           </div>
    </section>
<footer>
<div class="content-footer">
  <div class="container">

	  <div class="col-md-7"><p>© 2016 a2msports.com. All rights reserved. </p></div>
	  <!-- <div class="col-md-5"> -->
	  <div class="fb-like col-md-5" data-href="https://www.a2msports.com/" data-layout="button_count" data-action="like" data-show-faces="false" data-share="true"></div>
  
	  <!--<div class="col-md-3" style="padding-right:50px">
		<a href='https://www.facebook.com/a2msports' target='_blank'><img src = "<?php echo base_url().'images/fb_round.png'; ?>" alt = 'Facebook Page' width = '25px' height='25px' align='right' /></a>
	  </div>-->

  </div>
</div>
</footer>

</section>
<script src="<?php echo base_url();?>js/jquery-1.10.2.js" type="text/javascript"></script>
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

<script src="<?php echo base_url();?>js/custom.js" type="text/javascript"></script>
<script type="text/javascript" src="<?php echo base_url();?>js/jquery.autocomplete.js"></script>
<script src="<?php echo base_url();?>js/jquery-ui-custom.js"></script>
<script src="<?php echo base_url();?>js/simple-lightbox.js"></script>
<script src="<?php echo base_url();?>js/simple-lightbox.min.js"></script>
</body>
</html>