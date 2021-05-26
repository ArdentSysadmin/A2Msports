<?php 
//$url = $this->uri->segment(1);

$url2 = $_SERVER['QUERY_STRING'];

//$div_sec = explode('#',$url);

//$val = $div_sec[1];

?>
   
	<script src="<?php echo base_url();?>js/jquery-1.10.2.js" type="text/javascript"></script>
	<script src="js/jquery.ui.totop.js" type="text/javascript"></script>
	<script src="<?php echo base_url();?>js/jquery.accordion.js" type="text/javascript"></script>
	<script type="text/javascript">
        $(document).ready(function () {
		
			var abc = "<?php echo $url2; ?>";
			//alert(abc);

            $(function () {
                "use strict";
                $('.accordion').accordion({ defaultOpen: abc }); //some_id section1 in demo
            });
        });
    </script>

	
	
  <section id="single_player" class="container secondary-page">

           <div class="top-score-title right-score col-md-9">
           	<h3 style="text-align:left">Browse for help topics</h3>
              <div class="accordion" id="section1"><i class="fa fa-arrow-circle-o-right"></i>Create Tournament<span></span></div>
                    <div class="acc-content" style="padding:10px">
                            <p><b>Who Creates a Tournament? </b></p>
                            <p>At this point, there is no restriction on creating a tournament. So, anyone who wants to organize a tournament with at least 3 or more players can create a tournament.</p>
                            
                            <p style="margin-top:30px"><b>Is there a fee to create a tournament?</b></p>
                            <p>There is no fee to create a tournament at this point of time. However, if you want us to collect a registration fee for your tournament, we may charge a small fraction of that fee. Please contact us for pricing details.</p> 

							<p style="margin-top:30px"><b>Can I do Round Robin in the fist round and knockout after that?</b></p>
                            <p>At this point, we do not support mix and match in one tournament. However, customization of tournament draws is coming pretty soon. In the mean time, please create multiple tournaments for each round or contact us for help.</p>
                    </div>
                    <div class="accordion" id="section2"><i class="fa fa-arrow-circle-o-right"></i>Golf<span></span></div>
                    <div class="acc-content" style="padding:10px">
                            <p><b>How many holes to play in one round?</b></p>
                            <p>There are no restrictions. You play 9, 18 or anywhere in between. We calculate the scores based on what you enter.</p>
                            
                            <p style="margin-top:30px"><b>Would you pay the Golf Course entry fee?</b></p>
                            <p>You need to pay any entry fees associated with the Golf Club. We'll find a player for you.</p>
                    </div>
                    
                    <div class="accordion" id="section3"><i class="fa fa-arrow-circle-o-right"></i>Tennis<span></span></div>
                    <div class="acc-content" style="padding:10px">
                            <p><b>How many sets do I play in a tennis match?</b></p>
                            <p>It is completely up to you. To report a score we need at least one set of scores We allow up to 6 sets in a tennis match.</p>
                            
                            <p style="margin-top:30px"><b>What kind of balls should I play when playing with under 12 players?</b></p>
                            <p>It is completely up to you and your opponent. You can play with whichever you are most comfortable with.</p>
                    </div>
                    
                    <div class="accordion" id="section4"><i class="fa fa-arrow-circle-o-right"></i>Table Tennis<span></span></div>
                    <div class="acc-content" style="padding:10px">
                            <p><b>For how many points do I play a game?</b></p>
                            <p>It is completely up to you. You can either play 11 point game or 21 point game. You need to win by two points.</p>
                            
                            <p style="margin-top:30px"><b>Would you find a place to play for me?</b></p>
                            <p>We are working with multiple sports academies to provide space for you to play. However, you may still have to play an entry fee to play in those.</p>
                    </div>
                    
                    <div class="accordion" id="section5"><i class="fa fa-arrow-circle-o-right"></i>Badminton<span></span></div>
                    <div class="acc-content" style="padding:10px">
                            <p style="margin-top:30px"><b>Would you find a place to play for me?</b></p>
                            <p>We are working with multiple sports academies to provide space for you to play. However, you may still have to play an entry fee to play in those.</p>
                            
                            <p><b>For how many points do I play a game?</b></p>
                            <p>It is completely up to you. You can either play 11 point game or 21 point game. You need to win by two points.</p>
                    </div>
                    
                    <div class="accordion" id="section6"><i class="fa fa-arrow-circle-o-right"></i>Squash<span></span></div>
                    <div class="acc-content" style="padding:10px">
                            <p style="margin-top:30px"><b>Would you find a place to play for me?</b></p>
                            <p>We are working with multiple sports academies to provide space for you to play. However, you may still have to play an entry fee to play in those.</p>
                            
                             <p><b>For how many points do I play a game?</b></p>
                            <p>It is completely up to you. You can either play 11 point game or 21 point game. You need to win by two points.</p>
                    </div>
             
           </div><!--Close Top Match-->
