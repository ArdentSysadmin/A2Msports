<section id="single_player" class="container secondary-page">

<div class="top-score-title right-score col-md-9">
<h3 style="text-align:left"></h3>

<div class="col-md-12 league-form-bg" style="margin-top:0px;">
<div class="fromtitle">Become a Sponsor<?php echo " - ".$title; ?></div>
<!-- start main body -->

<?php
if(!$status){
?>
<div align='left'>
<p style="line-height: 20px; padding:10px 20px; text-align:justify">While playing in our tournaments is the most fun and the best way to sponsor our tournaments through entry fee, we understand you can't always play in all our tournaments. In those cases, you can sponsor for this tournament by donating here. Please note that 100% of the money sponsored will be used for trophies and prizes for this tournament and you will be added as a sponsor, no matter how small the amount is. Thank you for your generous donation. </p>
</div>

<div>
<form action="<?=base_url();?>sponsor" method="POST" enctype="multipart/form-data" class="form-horizontal">
<input type="hidden" name="tid" value="<?=$tid;?>" />

<div class='form-group'>
<label class='control-label col-md-3' for='id_accomodation'>Sponsor Name</label>
<div class='col-md-9 form-group internal'>
  <input type="text" class='form-control' style='width:40%' name="sponsor_name" value="" required />
</div>
</div>

<div class='form-group'>
<label class='control-label col-md-3' for='id_accomodation'>Sponsor Logo/Image</label>
<div class='col-md-9 form-group internal'>
  <input type="file" name="sponsor_image" />
</div>
</div>

<div class='form-group'>
<label class='control-label col-md-3' for='id_accomodation'>URL (optional)</label>
<div class='col-md-9 form-group internal'>
  <input type="text" class='form-control' style='width:40%' name="sponsor_url" value="" />
</div>
</div>

<div class='form-group'>
<label class='control-label col-md-3' for='id_accomodation'>Sponsor Amount($)</label>
<div class='col-md-9 form-group internal'>
  <input type="number" class='form-control' style='width:20%' name="sponsor_amount" value="" min="1" required />
</div>
</div>

<div class='form-group'>
<label class='control-label col-md-3' for='id_accomodation'>&nbsp;</label>
<div class='col-md-9 form-group internal'>
  <input type="submit" class='league-form-submit' value="Sponsor Now" name="sponsor_now" id="sponsor_now" />
</div>
</div>

</form>
</div>
<?php
}
else if($status == 'Completed'){
?>
<div>
<b><?php 
echo "Thankyou for your Sponsorship for the league <h4 style='display:inline;'><i>{$league}</i></h4><br /><br />";
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