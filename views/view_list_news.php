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
<div style="clear:both"></div>


<!-- Upcoming Matches Section start-->
<div class="col-md-12 league-form-bg" style="margin-top:40px; margin-bottom:20px;">

<div class="accordion" id="up_match_section" style="background:#f59123; padding:5px; color:white;"><i class="fa fa-arrow-circle-o-right" style="color:white;"> </i>Latest News<span></span></div>

<div class="tab-content">
<table class="tab-score">

<!-- <tr class="top-scrore-table">
<td class="score-position" valign="center" align="center">Academy Name</td>
</tr>
 -->
<?php 
if(count($news_list) == 0 )
{
	?>
<tr>
<td colspan='3'><h5>Latest news is not yet created.</h5></td>
</tr>
<?php
}
else
{
foreach($news_list as $row){
?>

<tr>
<td valign="center" align="left" style="padding:7px">
<div style="font-size:15px; padding-bottom:6px;"><a href='<?php echo base_url()."news/".$row->News_id;?>'><b><?php echo $row->News_title; ?></b></a></div>

<div align='right' style="margin-top:-17px"><b><?php echo date('m/d/Y',strtotime(substr($row->Created_on,0,10))); ?></b></div>
<div>
<?php
$abc	= strip_tags($row->News_content);
$s		= substr($abc, 0, 200);
$result = substr($s, 0, strrpos($s, '.'));

echo strip_tags($s) . "...";
?>
</div>	
</td>
<td>&nbsp;</td>
</tr>

<?php
}
}
?>
</table>
</div>
</div>

</div>