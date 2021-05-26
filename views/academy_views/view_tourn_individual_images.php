
<script src="<?php echo base_url();?>js/jquery-1.10.2.js" type="text/javascript"></script>

 <link href="<?php echo base_url();?>css/simple-lightbox.min.css" rel="stylesheet" />
<script src="<?php echo base_url();?>js/simple-lightbox.min.js"></script>
<script src="<?php echo base_url();?>js/simple-lightbox.js"></script>
 <script>
      $(document).ready(function () {
        $("img").simpleLightBox();
      });
    </script>

<style>
body { position: relative; }

#close-lightbox {
  position: fixed;
  top: 20px;
  right: 20px;
  font-size: 40px;
  color: #FFF;
  cursor: pointer;
}

#lightbox-image {
  position: fixed;
  top: 50%;
  left: 50%;
  margin: 0;
  max-width: 100%;
  -webkit-transform: translate(-50%, -50%);
  -moz-transform: translate(-50%, -50%);
  -ms-transform: translate(-50%, -50%);
  transform: translate(-50%, -50%);
}

#lightbox-image-wrapper {
  width: auto;
  max-width: 100%;
  max-height: 100%;
  margin: 0 auto;
}

#lightbox-wrapper {
  display: none;
  width: 100%;
  height: 100%;
  background: rgba(0, 0, 0, 0.8);
  position: fixed;
  top: 0;
  left: 0;
  z-index: 99999;
}

#lightbox-wrapper.active { display: block; }

.smp-lightbox {
  cursor: pointer;
  cursor: -moz-zoom-in;
  cursor: -webkit-zoom-in;
  cursor: zoom-in;
}

</style>



<section id="single_player" class="container secondary-page">

   <div class="top-score-title right-score col-md-12">

		<div class="col-md-12 league-form-bg" style="margin-top:40px; background:#fff; margin-bottom:20px">
           	<div class="fromtitle"><?php echo $tourn_title . " "; ?>Pictures<div style="clear:both"></div></div>

				
				<?php 
				if(count($images) != 0)
				{
				foreach($images as $row) { ?>
			
					
					<div class="col-md-3" style="margin-top:30px;">

					
				<img class="img-responsive" src="<?php echo base_url(); ?>tour_pictures/<?php echo $row->Tournament_id; ?>/<?php if($row->Image_file!=""){echo $row->Image_file; }
					else {
						echo "";
						}
						
					  ?>" alt="" height="154px" width="205px" />

					  <br />

					</div>
					

				 <?php } 
				 }
				 ?>




	    </div>
  </div> 
</section>


