<script src="<?php echo base_url();?>js/jquery.accordion.js" type="text/javascript"></script>
<script type="text/javascript">
$(document).ready(function () {
$(function () {
"use strict";
$('.accordion').accordion({ defaultOpen: 'up_match_section' }); //some_id section1 in demoup_tour_section
});
});
</script>




<section id="single_player" class="container secondary-page" style="background:#fff;">

<div class="top-score-title right-score col-md-9" style="background:#fff;">  

<!-- <div class="col-md-12 league-form-bg" style="margin-top:40px; background:#fff; margin-bottom:20px">
<div class="fromtitle">Organizations</div>
<p style="line-height:20px; font-size:13px">Here you can find your Organisations that may interest you.</p>

<?php // if($this->session->userdata('user')=="") { ?>
				
<p style="line-height:5px; font-size:13px">Please <a href='<?php //echo base_url()."login"; ?>'><b>Login</b> </a>to find Organizations .</p>
<?php// } ?>
</div>
 -->
<div style="clear:both"></div>



<!--  USER SESSION IS NOT EMPTY SHOW ALL CONTENT -->
<?php //if($this->session->userdata('user')!="") { ?>		

<!-- Upcoming Matches Section start-->
<div class="col-md-12 league-form-bg" style="margin-top:40px; margin-bottom:20px;">

<div class="accordion" id="up_match_section" style="background:#f59123; padding:5px; color:white;"><i class="fa fa-arrow-circle-o-right" style="color:white;"> </i>Academy List<span></span></div>

<div class="tab-content">
<table class="tab-score">

<!-- <tr class="top-scrore-table">
<td class="score-position" valign="center" align="center">Academy Name</td>
</tr>
 -->
<?php 
if(count($academy_list) == 0 )
{
	?>
<tr>
<td colspan='3'><h5>No Academies are found.</h5></td>
</tr>
<?php
}
else
{
foreach($academy_list as $row) { ?>
<tr>

<td valign="center" align="center"><h4>
<a href='<?php echo base_url().$row->Url_Shortcode; ?>'><b><?php echo $row->Org_name; ?></a></b>
</h4>
</td>

</tr>

<?php } 
}
?>


</table>
</div>
</div>

</div>

<?php //} ?>