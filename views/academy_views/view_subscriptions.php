<!-- Breadcromb Wrapper Start -->
<div class="breadcromb-wrapper">
<div class="breadcromb-overlay"></div>
<div class="container">
<div class="row">
<div class="col-sm-12">
<div class="breadcromb-left">
<h3>Membership Subscriptions</h3>
</div>
</div>
</div>

</div>
</div>
<!-- Breadcromb Wrapper End --> 
<section class="inner-page-wrapper">
<div class="container">
<div class="row">
<div class="col-md-9">

<?php 
if(count($club_memberships) == 0) {
?>
<div><h5>No Subscription are available!.</h5></div>
<?php
}
else {
	$club_country = $org_details['Aca_country'];
	$currency = '';
	/*if($club_country == 'India'){
		$currency = '&#8377;';
	}
	else{
		$currency = '&dollar;';
	}*/
?>
<form id='member_login' method="get" action='<?php echo base_url().$org_details['Aca_URL_ShortCode']; ?>/subscribe'  style='margin-left:100px;'>
<!-- <form id='member_login' method="post" action='<?php //echo base_url(); ?>/login/verify_user' class="login-form" style='margin-left:20px;' > --> 
<div class="name" align='left'>
<label for="name_login" id="err_msg" style="color:red"></label>
</div>
<?php
//echo "<pre>";
//print_r($user_membership);

foreach($club_memberships as $mem) {
?>
<div>
<?php
if($mem->tab_id != $user_membership['Membership_Code']){
?>
<input type="radio" id="<?=$mem->Membership_ID;?>" name="c" value="<?=$mem->Membership_ID;?>"  />&nbsp;
<?php
}
else
	echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
?>
<label for="<?=$mem->Membership_ID;?>">
<?php echo $mem->Membership_ID . " - " . $mem->Membership_Type; ?>
</label>
<?php
if($mem->tab_id == $user_membership['Membership_Code']){
?>
<span style="font-weight:bold; background-color: #ff8a00; margin:5px;line-height: 2em;"> Subscribed </span>
<?php
}
?>
</div>

<div style="margin-bottom:25px;">
<label for="name_login" style="margin-left:25px; font-weight: 200">
<?php echo $mem->Membership_ID . " - " . $mem->Membership_Type . " - " . $mem->Frequency . " - {$currency} " . number_format($mem->Fee, 2); ?>
<?php 
if($mem->ActivationFee > 0){
echo "<br>(One Time Activation Fee: {$currency} " . number_format($mem->ActivationFee, 2).")"; 
}?>
</label>
<?php
if($mem->tab_id == $user_membership['Membership_Code']){
?>
<a href="<?=$this->config->item('club_form_url');?>/subscription/cancel?d=<?=$mem->tab_id;?>">Cancel Subscription?</a>
<?php
}
?>
</div>
<?php
}
?>
<div id="login-submit" style="line-height:25px">
<!-- <input name="academy"  type="hidden" value="<?=$org_details['Aca_ID'];?>" />
<input name="shortcode" type="hidden" value="<?=$org_details['Aca_URL_ShortCode'];?>" />
<input name="aca_page" id="aca_page" type="hidden" value="" /> -->
<?php
if(!$this->logged_user){ 
?>
<input type="button" id='user_subscription' name='user_subscription'  value="  Subscribe  " style="padding: 5px 30px;color: #fff;font-weight: bold; margin-top:10px; border:#ff8a00; background-color:#ff8a00" />
<?php
}
else{
?>
<input type="submit" id='user_subscription' name='user_subscription'  value="  Subscribe  " style="padding: 5px 30px;color: #fff;font-weight: bold; margin-top:10px; border:#ff8a00; background-color:#ff8a00" onclick="return valid_lo();" />
<?php
}
?>
</div>
</form>
<?php
}
?>
</div>