<section id="single_player" class="container secondary-page" style="background:#fff;">

<div class="top-score-title right-score col-md-9" style="background:#fff;">  

<div class="col-md-12 league-form-bg" style="margin-top:40px; background:#fff; margin-bottom:20px">


<?php
if($reg_stat)
{ 
?>
	<div class='fromtitle'>Match Registration</div>
	<p style="line-height:20px; font-size:13px;"><h5 style="color:green"><?php echo $reg_stat; ?></h5></p>
	<p style="line-height:20px; font-size:14px">Please click <a href='<?php echo base_url()."play"; ?>'><b>My Sports</b> </a> to continue.</p>

<?php 
}
?> 

<?php

if($event_stat)
{ 
?>
	<div class='fromtitle'>Event Registration</div>
	<p style="line-height:20px; font-size:13px;"><h5 style="color:green"><?php echo $event_stat; ?></h5></p>
	<p style="line-height:20px; font-size:14px">Please click <a href='<?php echo base_url()."events/view/".$ev_id; ?>'><b>here</b> </a> to view Event Details.</p>

<?php 
}
?> 

<?php

if($event_stat1)
{ 
?>
	<div class='fromtitle'>Event Registration</div>
	<p style="line-height:20px; font-size:13px;"><h5 style="color:red"><?php echo $event_stat1; ?></h5></p>
	<p style="line-height:20px; font-size:14px">Please click <a href='<?php echo base_url()."events/view/".$ev_id; ?>'><b>here</b> </a> to view Event Details.</p>

<?php 
}
?>


</div>
<div style="clear:both"></div>

</div>