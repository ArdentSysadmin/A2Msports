<section id="single_player" class="container secondary-page">

<div class="top-score-title right-score col-md-9">
<h3 style="text-align:left"></h3>

<div class="col-md-12 league-form-bg" style="margin-top:0px;">
<div class="fromtitle">Make a Donation</div>
<!-- start main body -->
<br />
<?php
if(!$status){
?>
<div align='left'>
<p style="line-height: 20px; padding:10px 20px; text-align:justify">We are passionate about sports and provide our platform for free to everyone who wants to create and organize tournaments. While we are trying to make money through various means, we rely on your donations to meet all our costs. We appreciate your donation, no matter how small or big. The donations are used 100% to sponsor trophies and prizes for the tournaments we organize and promote. Thank you for your donation. </p>
</div>

<div align='center'>
<form action="https://www.paypal.com/cgi-bin/webscr" method="post" target="_top">
<input type="hidden" name="cmd" value="_s-xclick">
<input type="hidden" name="hosted_button_id" value="LLB8W9GQT5DR8">
<input type="image" src="https://www.paypalobjects.com/en_US/i/btn/btn_donateCC_LG.gif" border="0" name="submit" alt="PayPal - The safer, easier way to pay online!">
<img alt="" border="0" src="https://www.paypalobjects.com/en_US/i/scr/pixel.gif" width="1" height="1">
</form>

</div>
<?php
}
else if($status == 'Completed'){
?>
<div>
<b><?php 
echo "Thankyou for your Donation<br /><br />";
echo "Transaction #: <font color='blue'>".$Trans_id."</font><br />";
echo "Sponsored Amount  $<font color='blue'>".$Amount."</font><br />";
?></b>
</div>
<?php
}
else{
?>
<div>
<b>Something went wrong. Please contact the Admin. Thank you.</b>
</div>
<?php
}
?>
<br />
<br />
<br />
<br />
<br />
<br />
<!-- end main body -->

</div>
</div><!--Close Top Match-->