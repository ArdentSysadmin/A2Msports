<script src="<?php echo base_url();?>js/jquery-1.10.2.js" type="text/javascript"></script>
<script src="js/jquery.ui.totop.js" type="text/javascript"></script>
<script src="<?php echo base_url();?>js/jquery.accordion.js" type="text/javascript"></script>


 <style type="text/css">
            .error {
                color: #E13300;
            }

            .success {
                color: darkgreen;
            }
        </style>



<section id="single_player" class="container secondary-page">

<div class="top-score-title right-score col-md-9">


	<div class="col-md-12 league-form-bg" style="margin-top:30px; margin-bottom:30px">
	<div class="fromtitle">Create an Event/ Schedule a League</div>

	
   
        <div id="container">
            <h1>CodeIgniter Image Rotate</h1>

            <div id="body">
                <p>Select an image file to rotate</p>
                <?php
                if (isset($success) && strlen($success)) {
                    echo '<div class="success">';
                    echo '<p>' . $success . '</p>';
                    echo '</div>';
                }
                if (isset($errors) && strlen($errors)) {
                    echo '<div class="error">';
                    echo '<p>' . $errors . '</p>';
                    echo '</div>';
                }
                if (validation_errors()) {
                    echo validation_errors('<div class="error">', '</div>');
                }
                if (isset($rotate_img)) {
                    echo img($rotate_img);
                }
                ?>
              
			<form action="http://dev.ardentinc.com/a2msports/help/value" method="post" accept-charset="utf-8" name="image_upload_form" id="image_upload_form" enctype="multipart/form-data">			
                <p><input name="image_name" id="image_name" readonly="readonly" type="file"></p>
                <p><input name="image_upload" value="Upload Image" type="submit"></p>
                
			</form>
            </div>

        </div>
 







	

	</div>
	



</div>    <!--Close Top Match-->