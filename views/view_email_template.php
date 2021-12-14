<html>
<head>
<title>A2MSports</title>
<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">

<!-- jQuery library -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

<!-- Latest compiled JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
</head>
<body>
<table width="700" border="0" cellspacing="0" cellpadding="0" align="center">
<tr>
<td style="border:2px solid #ff8a00">
<table width="696" border="0" cellspacing="0" cellpadding="0">
<tr>
<td width="172" style="padding:10px">
<img class="scale_image" src="<?php echo base_url(); ?>images/logo.png" alt=""  />
</td>
<td width="524">
<div align="center" style="font-size:18px; font-weight:bold"><?php //echo $userName; ?></div>
</td>
</tr>
<tr>
<td colspan="2" style="height:6px; background:#81a32b; font-size:6px"></td>
</tr>
</table>

<br><br>
<div style="margin-left:16px; margin-right:16px; margin-bottom:20px">
<table border="0" cellspacing="0" cellpadding="0" align="center" width="660">
<tr>

<?php
/* ----------------------------Email body switch cases START here ------------------------------------ */
switch($page) {
	case "New Registration":
?>
<td style="padding:15px; line-height:20px; background:#eeeeee; border-radius:10px;">

<div style="Margin-top: 0;color: #565656;font-family: Georgia,serif;font-size: 16px;line-height: 25px;Margin-bottom: 25px">
Hi <?php echo $Firstname . " " . $Lastname  ;?>,
</div> 
<div style="Margin-top: 0;color: #565656;font-family: Georgia,serif;font-size: 16px;line-height: 25px;Margin-bottom: 25px"> 
Thank you for registering with A2msports. <br /> Please access given below link to activate your account. <br /> 

<?php $string =  base_url()."register/activate/".$Code;
//$string = auto_link($string, 'url');
echo $string;
?>
<br />

</div>
<div style="Margin-top: 0;color: #565656;font-family: Georgia,serif;font-size: 16px;line-height: 25px;Margin-bottom: 25px">Thank you, <br /> Admin, <br /> A2M Sports. </div>

</td>
<?php
break;
?>

<?php
case "New Club Registration with PayNow":
?>
<td style="padding:15px; line-height:20px; background:#eeeeee; border-radius:10px;">

<div style="Margin-top: 0;color: #565656;font-family: Georgia,serif;font-size: 16px;line-height: 25px;Margin-bottom: 25px">
Hi <?php echo $Firstname . " " . $Lastname  ;?>,
</div> 
<div style="Margin-top: 0;color: #565656;font-family: Georgia,serif;font-size: 16px;line-height: 25px;Margin-bottom: 25px"> 
<?php
$string =  base_url()."register/activate/".$Code;
//$string = auto_link($string, 'url');
//echo $string;
?>
Thank you for registering with <?=$club_name;?>. <br /> 
Click <a href='<?php echo $string; ?>' style="color: #fff; background-color: #337ab7; padding: 6px 12px; font-size: 14px; border-radius: 4px; text-decoration: none;font-family: Helvetica Neue,Helvetica,Arial,sans-serif;"> Activate </a>  to activate your account. 
<br /><br />
You have chosen the Subscription 
<b><?=$mem_info['Membership_Type'].' '.$mem_info['Frequency'];?></b>.
<br />
Please access the below links to Pay and complete your subscription. (Ignore this, if already paid)
<br />
<?php
$burl = $this->config->item('club_form_url');
if($this->config->item('club_form_url') == '')
	$burl = $_SERVER['HTTP_X_FORWARDED_HOST'];

if($mem_info['Act_Fee'] > 0) {
?>
One Time Activation Fee:&nbsp;&nbsp;<a href='<?php echo $burl."/membership/paynow/".$ot_id; ?>' style="color: #fff; background-color: #337ab7; padding: 6px 12px; font-size: 14px; border-radius: 4px; text-decoration: none;font-family: Helvetica Neue,Helvetica,Arial,sans-serif;"> Pay Now </a>
<?php
}
?>

<br />
Subscription:&nbsp;&nbsp;<a href='<?php echo $burl."/membership/paynow/".$subscr_id; ?>' style="color: #fff; background-color: #337ab7; padding: 6px 12px; font-size: 14px; border-radius: 4px; text-decoration: none;font-family: Helvetica Neue,Helvetica,Arial,sans-serif;"> Pay Now </a>
</div>
<div style="Margin-top: 0;color: #565656;font-family: Georgia,serif;font-size: 16px;line-height: 25px;Margin-bottom: 25px">
Thank you, <br /> Admin, <br /> A2M Sports.
</div>
</td>
<?php
break;
?>



<?php
case "New Club Registration - Admin":
?>
<td style="padding:15px; line-height:20px; background:#eeeeee; border-radius:10px;">

<div style="Margin-top: 0;color: #565656;font-family: Georgia,serif;font-size: 16px;line-height: 25px;Margin-bottom: 25px">
Hi Admin,
</div> 
<div style="Margin-top: 0;color: #565656;font-family: Georgia,serif;font-size: 16px;line-height: 25px;Margin-bottom: 25px"> 
<?php
$string =  base_url()."register/activate/".$Code;
//$string = auto_link($string, 'url');
//echo $string;
?>
New user <b><?=$Firstname . " " . $Lastname;?></b> registered with <b><?=$club_name;?></b>. 
<br /><br /><br />
Enrolled for the Subscription 
<b><?=$mem_info['Membership_Type'].' '.$mem_info['Frequency'];?></b>.
<br />
Here are the pay links to Pay and complete your subscription.
<br />
<?php
$burl = $this->config->item('club_form_url');
if($this->config->item('club_form_url') == '')
	$burl = $_SERVER['HTTP_X_FORWARDED_HOST'];

if($mem_info['Act_Fee'] > 0) {
?>
One Time Activation Fee:&nbsp;&nbsp;<a href='<?php echo $burl."/membership/paynow/".$ot_id; ?>' style="color: #fff; background-color: #337ab7; padding: 6px 12px; font-size: 14px; border-radius: 4px; text-decoration: none;font-family: Helvetica Neue,Helvetica,Arial,sans-serif;"> Pay Now </a>
<?php
}
?>

<br />
Subscription:&nbsp;&nbsp;<a href='<?php echo $burl."/membership/paynow/".$subscr_id; ?>' style="color: #fff; background-color: #337ab7; padding: 6px 12px; font-size: 14px; border-radius: 4px; text-decoration: none;font-family: Helvetica Neue,Helvetica,Arial,sans-serif;"> Pay Now </a>
</div>
<div style="Margin-top: 0;color: #565656;font-family: Georgia,serif;font-size: 16px;line-height: 25px;Margin-bottom: 25px">
Thank you, <br /> Admin, <br /> A2M Sports.
</div>
</td>
<?php
break;
?>


<?php
case "Instant Registration":
?>
<td style="padding:15px; line-height:20px; background:#eeeeee; border-radius:10px;">

<div style="Margin-top: 0;color: #565656;font-family: Georgia,serif;font-size: 16px;line-height: 25px;Margin-bottom: 25px">
Hi <?php echo $Firstname . " " . $Lastname  ;?>, Welcome to A2MSports.
</div> 
<div style="Margin-top: 0;color: #565656;font-family: Georgia,serif;font-size: 16px;line-height: 25px;Margin-bottom: 25px"> 
One of our Team Captains, <i>
<a href='<?=base_url();?>player/<?=$this->session->userdata('users_id');?>'><?=$this->session->userdata('user');?></a></i> wants you to play in his team. If you like to join, please access the below link to activate your account and access your profile on our site.
<br />
<?php $string =  base_url()."register/activate/".$Code;
//$string = auto_link($string, 'url');
echo $string;
?>
<br />
If you don't want to join the team or received this email in error, please contact admin@a2msports.com. Thank you.
<br />

</div>
<div style="Margin-top: 0;color: #565656;font-family: Georgia,serif;font-size: 16px;line-height: 25px;Margin-bottom: 25px">Thank you, <br />Admin,
<br />A2MSports. </div>
</td>
<?php
break;
?>

<?php
case "Instant Registration By Admin":
?>
<td style="padding:15px; line-height:20px; background:#eeeeee; border-radius:10px;">

<div style="Margin-top: 0;color: #565656;font-family: Georgia,serif;font-size: 16px;line-height: 25px;Margin-bottom: 25px">
Hi <?php echo $Firstname . " " . $Lastname  ;?>, Welcome to A2MSports.
</div> 
<div style="Margin-top: 0;color: #565656;font-family: Georgia,serif;font-size: 16px;line-height: 25px;Margin-bottom: 25px"> 
One of our Tournament Admin, <i>
<a href='<?=base_url();?>player/<?=$this->session->userdata('users_id');?>'><?=$this->session->userdata('user');?></a></i> wants you to play in his tournament. If you like to join, please access the below link to activate your account and access your profile on our site.
<br />
<?php $string =  base_url()."register/activate/".$Code;
//$string = auto_link($string, 'url');
echo $string;
?>
<br />
If you don't want to join the tournament or received this email in error, please contact admin@a2msports.com. Thank you.
<br />

</div>
<div style="Margin-top: 0;color: #565656;font-family: Georgia,serif;font-size: 16px;line-height: 25px;Margin-bottom: 25px">Thank you, <br />Admin,
<br />A2MSports. </div>
</td>
<?php
break;
?>

<?php
case "Request-Demo":
?>
<td style="padding:15px; line-height:20px; background:#eeeeee; border-radius:10px;">

<div style="Margin-top: 0;color: #565656;font-family: Georgia,serif;font-size: 16px;line-height: 25px;Margin-bottom: 25px">
Hi Admin,
</div> 
<div style="Margin-top: 0;color: #565656;font-family: Georgia,serif;font-size: 16px;line-height: 25px;Margin-bottom: 25px"> 
A new demo request in your site has raised. Given below are the contact details.<br />
Name: <?php echo $name; ?><br />
Phone: <?php echo $phone; ?><br />
Email: <?php echo $email; ?><br />
Comments: <?php echo $comments; ?><br />

</div>
<div style="Margin-top: 0;color: #565656;font-family: Georgia,serif;font-size: 16px;line-height: 25px;Margin-bottom: 25px">
Thank you, <br />
<?php
if($this->session->userdata('users_id')){
?>
<a href="<?php echo base_url().'player/'.$this->session->userdata('users_id'); ?>"><?php echo $this->session->userdata('user'); ?></a>
<?php
}
?>
</div>
</td>
<?php
break;
?>
<?php 
case "New Tournament Invitation":
?>
<td style="padding:15px; line-height:20px; background:#eeeeee; border-radius:10px;">

<div style="Margin-top: 0;color: #565656;font-family: Georgia,serif;font-size: 16px;line-height: 25px;Margin-bottom: 25px">
<?php echo $message." Here are the details."; ?> 
</div> 

<div style="Margin-top: 0;color: #565656;font-family: Georgia,serif;font-size: 16px;line-height: 25px;Margin-bottom: 25px"> 

<b>Tournament</b>: <?php echo $title; ?> <br />
<b>Sport</b>: <?php echo $sport; ?> <br />
<b>Location</b>: <?php echo $location; ?> <br />

<!-- <b>Gender</b>: <?php echo $gender; ?> <br /> -->

<b>Starts on</b>: <?php echo $start_date; ?> <br />
<b>Registration closes on</b>: <?php echo $close_date; ?>  <br />

<!-- <b>Fees</b>: <?php echo "$" .number_format($fee,2)." (Singles), ". "$" . number_format($extrafee,2)." (Additional Format)";?> <br /> -->

</div>

<div style="Margin-top: 0;color: #565656;font-family: Georgia,serif;font-size: 16px;line-height: 25px;Margin-bottom: 25px">
Please find the Tournament @ 

<?php //$string =  base_url()."league/view/".$tourn_id;
$string =  base_url().$sport;
$string = auto_link($string, 'url');
echo $string;
?>
<br />

</div>
<div style="Margin-top: 0;color: #565656;font-family: Georgia,serif;font-size: 16px;line-height: 25px;Margin-bottom: 25px">Thank you, <br /> 
<?php echo $this->session->userdata('user'); ?>, <br /> A2M Sports. </div>
</td>
<?php
break;
?>

<?php 
case "New Tournament Creation":
?>
<td style="padding:15px; line-height:20px; background:#eeeeee; border-radius:10px;">

<div style="Margin-top: 0;color: #565656;font-family: Georgia,serif;font-size: 16px;line-height: 25px;Margin-bottom: 25px">
Hi <?php echo $fname . " " . $lname ; ?>, <br />
</div> 

<div style="Margin-top: 0;color: #565656;font-family: Georgia,serif;font-size: 16px;line-height: 25px;Margin-bottom: 25px">
We have a new tournament starting soon and we think you may be interested in that. Given below are the tournament details.  <br />
</div> 

<div style="Margin-top: 0;color: #565656;font-family: Georgia,serif;font-size: 16px;line-height: 25px;Margin-bottom: 25px"> 
<b>Tournament</b>: <?php echo $title; ?> <br />
<b>Sport</b>: <?php echo $sport; ?> <br />
<!--<b>Gender</b>: <?php //echo $gender; ?> <br /> -->
<b>Start Date</b>: <?php echo $start_date; ?> <br />
<b>Registration closes on</b>: <?php echo $close_date; ?>  <br />
<b>Location</b>: <?php echo $location; ?> <br />


<!-- <b>Fees</b>: -->
<?php
/*
if($is_mult == 0){
echo "$" .number_format($fee,2)." (Singles), ". "$" . number_format($extrafee,2)." (Additional Format)"; 
echo "<br />";
}
else if($is_mult == 1) { 
echo "<table border='1' cellpadding='10' cellspacing = '10'><tr><td>Age Group</td><td>First Event</td><td>Additional Event</td></tr>";

$age_grp			  = json_decode($age_groups);
$numItems			  = count($age_grp);
$i = 0;

if($numItems > 0)
{
$mult_fee_array		  = json_decode($fee);
$addn_mult_fee_array  = json_decode($extrafee);

foreach($age_grp as $i=>$ag)
{
echo "<tr><td>";
switch ($ag){
case "U10":
echo "Under 10";
break;

case "U11":
echo "Under 11";
break;

case "U12":
echo "Under 12";
break;

case "U13":
echo "Under 13";
break;

case "U14":
echo "Under 14";
break;

case "U15":
echo "Under 15";
break;

case "U16":
echo "Under 16";
break;

case "U17":
echo "Under 17";
break;

case "U18":
echo "Under 18";
break;

case "U19":
echo "Under 19";
break;

case "Adults":
echo "Adults ";
break;
case "Adults_30p":
echo "30s";
break;
case "Adults_40p":
echo "40s";
break;
case "Adults_50p":
echo "50s";
break;
case "Adults_veteran":
echo "Veteran";
break;
default:
echo "";
}
echo "</td><td>" . $mult_fee_array[$i] . "</td><td>" . $addn_mult_fee_array[$i]."</td></tr>";
}
}
echo "</table>";

} else { 	 
echo "$0.00";
} 
*/
?>

<b>Organizer</b>: <?php echo $org; ?> <br />
<b>Contact</b>: <?php echo $contact; ?> </div><br />

<div style="Margin-top: 0;color: #565656;font-family: Georgia,serif;font-size: 16px;line-height: 25px;Margin-bottom: 25px">
Please access the below link  to register for the Tournament. <br />
<?php
//$sp = str_replace(' ', '-', $sport);
$string = base_url()."{$sport_sc}/".$tourn_id;
$string = auto_link($string, 'url');
echo $string;
?>
<br />
</div>
<div style="Margin-top: 0;color: #565656;font-family: Georgia,serif;font-size: 16px;line-height: 25px;Margin-bottom: 25px">
Thank you, <br /> 
Admin, <br />
A2M Sports. </div>

</td>
<?php
break;
?>

<?php 
case "Tournament Creation Admin Notif":
?>
<td style="padding:15px; line-height:20px; background:#eeeeee; border-radius:10px;">

<div style="Margin-top: 0;color: #565656;font-family: Georgia,serif;font-size: 16px;line-height: 25px;Margin-bottom: 25px">Hi <?php echo $admin_firstname . " " . $admin_lastname ; ?>, <br /></div> 

<div style="Margin-top: 0;color: #565656;font-family: Georgia,serif;font-size: 16px;line-height: 25px;Margin-bottom: 25px">A new tournament <b><?php echo $title; ?></b> is created. Given below are the tournament details.  <br />
</div> 

<div style="Margin-top: 0;color: #565656;font-family: Georgia,serif;font-size: 16px;line-height: 25px;Margin-bottom: 25px">Tournament Link: <br />
<?php
//$sp = str_replace(' ', '-', $sport);
$string = base_url()."league/".$tourn_id;
$string = auto_link($string, 'url');
echo $string;
?>
<br />
</div>
<div style="Margin-top: 0;color: #565656;font-family: Georgia,serif;font-size: 16px;line-height: 25px;Margin-bottom: 25px">
Thank you, <br /> 
Admin, <br />
A2M Sports. </div>

</td>
<?php
break;
?>


<?php 
case "Tournament Match Comments":
?>
<td style="padding:15px; line-height:20px; background:#eeeeee; border-radius:10px;">

<div style="Margin-top: 0;color: #565656;font-family: Georgia,serif;font-size: 16px;line-height: 25px;Margin-bottom: 25px">
Hi,
</div> 


<div style="Margin-top: 0;color: #565656;font-family: Georgia,serif;font-size: 16px;line-height: 25px;Margin-bottom: 25px">
<?php echo ucfirst($this->session->userdata('user')); ?> has sent a message in tournament <b>(<?php echo $title ;?></b>). <br />

<b>Message</b>: <?php echo $message ;?> <br />

Please access the below link to access the tournament details.<br />

<?php $string = base_url()."league/".$tourn_id;
$string = auto_link($string, 'url');
echo $string;
?>
<br />

</div>
<div style="Margin-top: 0;color: #565656;font-family: Georgia,serif;font-size: 16px;line-height: 25px;Margin-bottom: 25px">Thank you, <br /> 
<?php //echo ucfirst($this->session->userdata('user')); 
echo "Admin,";
?><br /> 
A2M Sports. 
</div>
</td>
<?php
break;
?>

<?php 
case "New Match Invitation":
?>
<td style="padding:15px; line-height:20px; background:#eeeeee; border-radius:10px;">

<div style="Margin-top: 0;color: #565656;font-family: Georgia,serif;font-size: 16px;line-height: 25px;Margin-bottom: 25px">
Hi <?php echo $firstname . " " . $lastname; ?> ,
</div> 


<div style="Margin-top: 0;color: #565656;font-family: Georgia,serif;font-size: 16px;line-height: 25px;Margin-bottom: 25px">
I have sent a match play invitation to you. <br />


<!-- Please <strong><a href="">click here</a></strong> to register for the match if you are intreseted.
<br /> -->

<?php $string = base_url()."play/register/".$match_id;?>
please <strong><a href='<?php echo $string;?>'>click here</a></strong> to register for the match if you are intreseted.
<br />

</div>
<div style="Margin-top: 0;color: #565656;font-family: Georgia,serif;font-size: 16px;line-height: 25px;Margin-bottom: 25px">Thank you, <br /> 
<?php echo $this->session->userdata('user'); ?>, <br />  A2M Sports. </div>

</td>
<?php
break;
?>

<?php 
case "New Event Invitation":
?>
<td style="padding:15px; line-height:20px; background:#eeeeee; border-radius:10px;">

<div style="Margin-top: 0;color: #565656;font-family: Georgia,serif;font-size: 16px;line-height: 25px;Margin-bottom: 25px">
Hi <?php echo $firstname . " " . $lastname; ?> ,
</div>

<div style="Margin-top: 0;color: #565656;font-family: Georgia,serif;font-size: 16px;line-height: 25px;Margin-bottom: 25px">
<?php
if($message == ''){
?>
A New Event (<?php echo $ev_title; ?>) invitation has been sent to you.
<?php
}
else { 
	echo $message;
}
?>
</div> 

<div style="Margin-top: 0;color: #565656;font-family: Georgia,serif;font-size: 16px;line-height: 25px;Margin-bottom: 25px">
<?php $string = base_url()."events/".$event_id;?>
Please <strong><a href='<?php echo $string;?>'>click here</a></strong> to view / respond to the event schedules .<br />
</div>

<div style="Margin-top: 0;color: #565656;font-family: Georgia,serif;font-size: 16px;line-height: 25px;Margin-bottom: 25px">Thank you, <br /> 
<?php echo $this->session->userdata('user'); ?>, <br />  A2M Sports. </div>

</td>
<?php
break;
?>

<?php 
case "New Event Details _ Backup":
?>
<td style="padding:15px; line-height:20px; background:#eeeeee; border-radius:10px;">

<div style="Margin-top: 0;color: #565656;font-family: Georgia,serif;font-size: 16px;line-height: 25px;Margin-bottom: 25px">
<?php echo $message." <br>Here are the event details."; ?> 
</div> 

<div style="Margin-top: 0;color: #565656;font-family: Georgia,serif;font-size: 16px;line-height: 25px;Margin-bottom: 25px">

<b>Event Title</b>: <?php echo $ev_title; ?> <br />

<b>Event Type</b>: <?php echo $ev_type_name; ?> <br />

<b>Start Date</b>: <?php echo $ev_sd; ?> <br />

<b>End Date</b>: <?php echo $ev_ed; ?>  <br />

<b>Location</b>: <?php echo $loc_title; ?> <br /> <?php echo $location; ?> <br />

<b>Organizer</b>: <?php echo $organizer; ?>  <br />

<b>Contact Number</b>: <?php echo $contact_num; ?>  <br />

</div>

<div style="Margin-top: 0;color: #565656;font-family: Georgia,serif;font-size: 16px;line-height: 25px;Margin-bottom: 25px">
Please access the below link to register. <br />

<?php $string =  base_url()."events/register/".$ev_id;
$string = auto_link($string, 'url');
echo $string;
?>	<br />

</div>
<div style="Margin-top: 0;color: #565656;font-family: Georgia,serif;font-size: 16px;line-height: 25px;Margin-bottom: 25px">Thank you, <br /> 
<?php echo $this->session->userdata('user'); ?>, <br />  A2M Sports. </div>

</td>
<?php
break;
?>

<?php 
case "New Event Details":
?>
<td>

<div style="Margin-top: 0;color: #565656;font-family: Georgia,serif;font-size: 16px;line-height: 25px;Margin-bottom: 25px">
<?php echo $message." <br>Here are the event details."; ?> 
</div> 

<div style="Margin-top: 0;color: #565656;font-family: Georgia,serif;font-size: 16px;line-height: 25px;Margin-bottom: 25px">

<b>Event Title</b>: <?php echo $ev_title; ?> <br />

<b>Event Type</b>: <?php echo $ev_type_name; ?> <br />

<b>Start Date</b>: <?php echo $ev_sd; ?> <br />

<b>End Date</b>: <?php echo $ev_ed; ?>  <br />

<b>Location</b>: <?php echo $loc_title; ?> <br /> <?php echo $location; ?> <br />

<b>Organizer</b>: <?php echo $organizer; ?>  <br />

<b>Contact Number</b>: <?php echo $contact_num; ?>  <br />

</div>

<div style="Margin-top: 0;color: #565656;font-family: Georgia,serif;font-size: 16px;line-height: 25px;Margin-bottom: 25px">
Please access the below link to register. <br />

<?php $string =  base_url()."events/view/".$ev_id."/".$act_code;
$string = auto_link($string, 'url');
echo $string;
?>	<br />

</div>
<div style="Margin-top: 0;color: #565656;font-family: Georgia,serif;font-size: 16px;line-height: 25px;Margin-bottom: 25px">Thank you, <br /> 
<?php echo $this->session->userdata('user'); ?>, <br />  A2M Sports. </div>

</td>
<?php
break;
?>


<?php 
case "Events Reminder to Players":
?>
<td>

<div style="Margin-top: 0;color: #565656;font-family: Georgia,serif;font-size: 16px;line-height: 25px;Margin-bottom: 25px">
<?php echo "Hi $firstname $lastname, <br>This is an event reminder for the Event '$ev_title'."; ?>
</div> 

<!-- <div style="Margin-top: 0;color: #565656;font-family: Georgia,serif;font-size: 16px;line-height: 25px;Margin-bottom: 25px">

<b>Event Title</b>: <?php //echo $ev_title; ?> <br />
<b>Event On</b>: <?php //echo $ev_sd; ?> <br />
<b>End Date</b>: <?php //echo $ev_ed; ?>  <br />
<b>Location</b>: <?php //echo $loc_title; ?> <br /> <?php //echo $location; ?> <br />
<b>Organizer</b>: <?php //echo $organizer; ?>  <br />
<b>Contact Number</b>: <?php //echo $contact_num; ?>  <br />

</div> -->

<div style="Margin-top: 0;color: #565656;font-family: Georgia,serif;font-size: 16px;line-height: 25px;Margin-bottom: 25px">
Please access the below link to view the details. <br />

<?php $string =  base_url()."events/view/".$ev_id;
$string = auto_link($string, 'url');
echo $string;
?>	<br />

</div>
<div style="Margin-top: 0;color: #565656;font-family: Georgia,serif;font-size: 16px;line-height: 25px;Margin-bottom: 25px">Thank you, <br /> 
<?php echo "Admin";   //$this->session->userdata('user'); ?>, <br />  A2M Sports. </div>

</td>
<?php
break;
?>

<?php 
case "AddScore Reminder to Players":
?>
<td>

<div style="Margin-top: 0;color: #565656;font-family: Georgia,serif;font-size: 16px;line-height: 25px;Margin-bottom: 25px">
<?php echo "Hi $firstname $lastname, <br>This is a reminder to play your match in Tournament - '$tour_title'. Please update the score if you already played the match."; ?>
</div> 

<div style="Margin-top: 0;color: #565656;font-family: Georgia,serif;font-size: 16px;line-height: 25px;Margin-bottom: 25px">
Please access the below link to view the details. <br />

<?php
$string = base_url()."league/".$tour_id;
$string = auto_link($string, 'url');
echo $string;
?>
<br />

</div>
<div style="Margin-top: 0;color: #565656;font-family: Georgia,serif;font-size: 16px;line-height: 25px;Margin-bottom: 25px">Thank you, <br /> 
<?php echo "Admin"; ?>, 
<br />A2M Sports. </div>

</td>
<?php
break;
?>

<?php 
case "Event Availability Status":
?>
<td>

<div style="Margin-top: 0;color: #565656;font-family: Georgia,serif;font-size: 16px;line-height: 25px;Margin-bottom: 25px">
Hi <?php echo ucfirst($firstname) . " " . ucfirst($lastname); ?>,
</div>  

<div style="Margin-top: 0;color: #565656;font-family: Georgia,serif;font-size: 16px;line-height: 25px;Margin-bottom: 25px">

<b><?php echo $this->session->userdata('user'); ?></b> has updated their availability status for the Event <b><?php echo $title; ?></b>.<br />

</div>

<div style="Margin-top: 0;color: #565656;font-family: Georgia,serif;font-size: 16px;line-height: 25px;Margin-bottom: 25px">
Please access the below link to view the event. <br />

<?php $string =  base_url()."events/view/".$event_id;
$string = auto_link($string, 'url');
echo $string;
?>	<br />

</div>
<div style="Margin-top: 0;color: #565656;font-family: Georgia,serif;font-size: 16px;line-height: 25px;Margin-bottom: 25px">Thank you, <br /> 
Admin, <br />  A2M Sports. </div>

</td>
<?php
break;
?>


<?php 
case "FM-Register":
?>
<td style="padding:15px; line-height:20px; background:#eeeeee; border-radius:10px;">

<div style="Margin-top: 0;color: #565656;font-family: Georgia,serif;font-size: 16px;line-height: 25px;Margin-bottom: 25px">
Hi <?php echo $creator_name; ?>,
</div> 

<div style="Margin-top: 0;color: #565656;font-family: Georgia,serif;font-size: 16px;line-height: 25px;Margin-bottom: 25px">
A new match registration has initiated. Given below are the details .</div>

<div style="Margin-top: 0;color: #565656;font-family: Georgia,serif;font-size: 16px;line-height: 25px;Margin-bottom: 25px">

<b>Match:</b> <?php echo $title; ?> <br /> 
<b>Registered by:</b> <?php echo $reg_user_name; ?> <br />
<?php if($partner_name){?>
<?php echo "<b>Partner :</b>". $partner_name; ?> <br /> 
<?php } ?>
<b>Play Date:</b> <?php echo $play_date; ?> <br /> 
<b>Comments:</b> <?php echo $comments; ?> <br /> 
</div>

<div style="Margin-top: 0;color: #565656;font-family: Georgia,serif;font-size: 16px;line-height: 25px;Margin-bottom: 25px">Thank you, <br /> 
Admin, <br />  A2M Sports. </div>

</td>
<?php
break;
?>


<?php
case "Reset Password":
?>
<td style="padding:15px; line-height:20px; background:#eeeeee; border-radius:10px;">

<div style="Margin-top: 0;color: #565656;font-family: Georgia,serif;font-size: 16px;line-height: 25px;Margin-bottom: 25px">
Hi <?php echo $firstname . " " . $lastname . ","; ?> 
</div> 

<div style="Margin-top: 0;color: #565656;font-family: Georgia,serif;font-size: 16px;line-height: 25px;Margin-bottom: 25px">
A New password request has been initiated for your A2MSports login. <br />
Please access the below link to reset the password.<br />

<?php $string =  base_url()."reset/password/".$code;
$string = auto_link($string, 'url');
echo $string;
?><br />
</div>

<div style="Margin-top: 0;color: #565656;font-family: Georgia,serif;font-size: 16px;line-height: 25px;Margin-bottom: 25px">
Please ignore this email if you were not initiated Password request.<br />
</div>

<div style="Margin-top: 0;color: #565656;font-family: Georgia,serif;font-size: 16px;line-height: 25px;Margin-bottom: 25px">Thank you, <br /> 
Admin, <br />  A2M Sports. </div>

</td>
<?php
break;
?>


<?php 
case "Reset Profile Password":
?>
<td style="padding:15px; line-height:20px; background:#eeeeee; border-radius:10px;">

<div style="Margin-top: 0;color: #565656;font-family: Georgia,serif;font-size: 16px;line-height: 25px;Margin-bottom: 25px">
Hi <?php echo $p_firstname . " " . $p_lastname . ","; ?> 
</div> 


<div style="Margin-top: 0;color: #565656;font-family: Georgia,serif;font-size: 16px;line-height: 25px;Margin-bottom: 25px">
A new password request has been initiated for one of your linked A2M Sports profiles.<br />
Given below are the details<br />
Name: <?php echo $firstname." ".$lastname; ?><br />
Username: <?php echo $child_user_name; ?></br><br />

Please access the below link to reset the password.<br />

<?php $string =  base_url()."reset/password/".$code;
//$string = auto_link($string, 'url');
echo $string;
?>	<br />

</div>

<div style="Margin-top: 0;color: #565656;font-family: Georgia,serif;font-size: 16px;line-height: 25px;Margin-bottom: 25px">
Please ignore this email if you were not initiated Password request.<br />
</div>

<div style="Margin-top: 0;color: #565656;font-family: Georgia,serif;font-size: 16px;line-height: 25px;Margin-bottom: 25px">Thank you, <br /> 
Admin, <br />  A2M Sports. </div>

</td>
<?php
break;
?>

<?php 
case "Registration-Singles":
?>
<td style="padding:15px; line-height:20px; background:#eeeeee; border-radius:10px;">

<div style="Margin-top: 0;color: #565656;font-family: Georgia,serif;font-size: 16px;line-height: 25px;Margin-bottom: 25px">
Hi <?php echo $firstname . " " . $lastname . ","; ?> 
</div> 


<div style="Margin-top: 0;color: #565656;font-family: Georgia,serif;font-size: 16px;line-height: 25px;Margin-bottom: 25px">
You have Successfully registered for the Tournament  <?php echo $title; ?> on <?php echo $date; ?> for <br>
<?php 
//print_r($categories);
   if(count($categories)>0)
   { 
//	echo "hi";
    foreach($categories as $level=>$category)
   	    {
   	    	//echo "hi";
   	    	if ($level=='Singles') {

	            foreach($category as $key=>$type){
	                
	                 echo $type; echo "<br>";
			    } 
            }
            if ($level=='Doubles') {

	            foreach($category as $key=>$type){
	           
	                 echo $type; echo "<br>";
			    } 
            }
            if ($level=='Mixed') {

	            foreach($category as $key=>$type){

	                 echo $type; echo "<br>";
			    } 
            }
   	
        }

    } 
    ?>.<br />
<?php
if($game_days){
	echo "Game Days:<br>";
	foreach($game_days as $gd){
		echo $gd."<br>";
	}
}
?>
<?php $string =  base_url()."league/".$tourn_id;
$string = auto_link($string, 'url');
echo $string;
?>	<br />
</div>

<div style="Margin-top: 0;color: #565656;font-family: Georgia,serif;font-size: 16px;line-height: 25px;Margin-bottom: 25px">Thank you, <br /> 
Admin, <br />  A2M Sports. </div>

</td>
<?php
break;
?>

<?php
case "Event Registration-Singles":
?>
<td style="padding:15px; line-height:20px; background:#eeeeee; border-radius:10px;">

<div style="Margin-top: 0;color: #565656;font-family: Georgia,serif;font-size: 16px;line-height: 25px;Margin-bottom: 25px">
Hi <?php echo $firstname . " " . $lastname . ","; ?> 
</div> 

<div style="Margin-top: 0;color: #565656;font-family: Georgia,serif;font-size: 16px;line-height: 25px;Margin-bottom: 25px">
You have Successfully registered for the Event  <?php echo $title; ?> on <?php echo $date; ?>
<br />

<?php
$string = base_url()."event/".$ev_id;
$string	= auto_link($string, 'url');

echo $string;
?>
<br />
</div>

<div style="Margin-top: 0;color: #565656;font-family: Georgia,serif;font-size: 16px;line-height: 25px;Margin-bottom: 25px">Thank you, <br /> 
Admin, <br />  A2M Sports. </div>

</td>
<?php
break;
?>

<?php 
case "Send mail to tournament admin once user registration":
?>
<td style="padding:15px; line-height:20px; background:#eeeeee; border-radius:10px;">

<div style="Margin-top: 0;color: #565656;font-family: Georgia,serif;font-size: 16px;line-height: 25px;Margin-bottom: 25px">
Hi <?php echo $admin_firstname . " " . $admin_lastname . ","; ?> 
</div> 

<div style="Margin-top: 0;color: #565656;font-family: Georgia,serif;font-size: 16px;line-height: 25px;Margin-bottom: 25px">
   <?php echo $firstname . " " . $lastname . ","; ?> is registered for the Tournament <?php echo $title; ?> on <?php echo $date; ?> for <br>
<?php 
//print_r($categories);
   if(count($categories)>0)
   { 
//	echo "hi";
    foreach($categories as $level=>$category)
   	    {
   
   	    	if ($level=='Singles') {

	            foreach($category as $key=>$type){
	              
	                 echo $type; echo "<br>";
			    } 
            }
            if ($level=='Doubles') {

	            foreach($category as $key=>$type){
	              
	                 echo $type; echo "<br>";
			    } 
            }
            if ($level=='Mixed') {

	            foreach($category as $key=>$type){
	              	                 
	                 echo $type; echo "<br>";
			    } 
            }
   	
        }

    } 
?>.<br />
<?php
if($game_days){
	echo "Game Days:<br>";
	foreach($game_days as $gd){
		echo $gd."<br>";
	}
}
?>

<?php $string =  base_url()."league/".$tourn_id;
$string = auto_link($string, 'url');
echo $string;
?><br />

</div>
<?php if($note_to_admin){
?>
<div style="Margin-top: 0;color: #565656;font-family: Georgia,serif;font-size: 16px;line-height: 25px;Margin-bottom: 25px">
   <?php echo $note_to_admin;?>
</div>
<?php
}
?>
<div style="Margin-top: 0;color: #565656;font-family: Georgia,serif;font-size: 16px;line-height: 25px;Margin-bottom: 25px">Thank you, <br /> 
Admin, <br />  A2M Sports. </div>
</td>
<?php
break;
?>

<?php 
case "Tourn-Reg-Doubles":
?>
<td style="padding:15px; line-height:20px; background:#eeeeee; border-radius:10px;">

<div style="Margin-top: 0;color: #565656;font-family: Georgia,serif;font-size: 16px;line-height: 25px;Margin-bottom: 25px">
Hi <?php echo $partner1; ?> ,<br />
</div> 


<div style="Margin-top: 0;color: #565656;font-family: Georgia,serif;font-size: 16px;line-height: 25px;Margin-bottom: 25px">

You have been selected as a Partner for one of the A2MSports Tournament by <?php echo $user; ?>.
If you are interested to participate, please access the below link and register for the tournament.<br />

<?php $string =  base_url()."league/register_match/".$tourn_id;
$string = auto_link($string, 'url');
echo $string;
?>	<br />

</div>

<div style="Margin-top: 0;color: #565656;font-family: Georgia,serif;font-size: 16px;line-height: 25px;Margin-bottom: 25px">Thank you, <br /> 
Admin, <br />  A2M Sports. </div>

</td>
<?php
break;
?>


<?php 
case "Tourn-Reg-Mixed":
?>
<td style="padding:15px; line-height:20px; background:#eeeeee; border-radius:10px;">

<div style="Margin-top: 0;color: #565656;font-family: Georgia,serif;font-size: 16px;line-height: 25px;Margin-bottom: 25px">
Hi <?php echo $partner2; ?> ,<br />
</div> 


<div style="Margin-top: 0;color: #565656;font-family: Georgia,serif;font-size: 16px;line-height: 25px;Margin-bottom: 25px">

You have been selected as a Partner for one of the A2M Sports Tournament by <?php echo $user2; ?>.
If you are interested to participate, please access the below link and register for the tournament.<br />

<?php $string =  base_url()."league/register_match/".$tourn_id;
$string = auto_link($string, 'url');
echo $string;
?>	<br />

</div>

<div style="Margin-top: 0;color: #565656;font-family: Georgia,serif;font-size: 16px;line-height: 25px;Margin-bottom: 25px">Thank you, <br /> 
Admin, <br />  A2M Sports. </div>

</td>
<?php
break;
?>

<?php 
case "Send Email Registered Players":
?>
<td style="padding:15px; line-height:20px; background:#eeeeee; border-radius:10px;">

<div style="Margin-top: 0;color: #565656;font-family: Georgia,serif;font-size: 16px;line-height: 25px;Margin-bottom: 25px">
Hi <?php echo $firstname . " " . $lastname; ?> ,<br />
</div> 

<div style="Margin-top: 0;line-height: 25px;Margin-bottom: 25px">
<?php echo html_entity_decode($des); ?><br />
</div>

<div style="Margin-top: 0;color: #565656;font-family: Georgia,serif;font-size: 16px;line-height: 25px;Margin-bottom: 25px">
Access the below link to view tournament details .<br />

<?php $string =  base_url()."league/".$tourn_id;
$string = auto_link($string, 'url');
echo $string;
?>	<br />

</div>

<div style="Margin-top: 0;color: #565656;font-family: Georgia,serif;font-size: 16px;line-height: 25px;Margin-bottom: 25px">Thank you, <br /> 
<?php echo $admin_name;?>, <br /> <?php echo $title;?>, <br /> </div>

</td>
<?php
break;
?>

<?php 
case "Send Email Event Players":
?>
<td style="padding:15px; line-height:20px; background:#eeeeee; border-radius:10px;">

<div style="Margin-top: 0;color: #565656;font-family: Georgia,serif;font-size: 16px;line-height: 25px;Margin-bottom: 25px">
Hi <?php echo $firstname . " " . $lastname; ?> ,<br />
</div> 

<div style="Margin-top: 0;color: #565656;font-family: Georgia,serif;font-size: 16px;line-height: 25px;Margin-bottom: 25px">
<?php echo $des; ?><br />
</div>

<div style="Margin-top: 0;color: #565656;font-family: Georgia,serif;font-size: 16px;line-height: 25px;Margin-bottom: 25px">
Access the below link to view Event details .<br />

<?php $string =  base_url()."events/view/".$ev_id;
$string = auto_link($string, 'url');
echo $string;
?>	<br />

</div>

<div style="Margin-top: 0;color: #565656;font-family: Georgia,serif;font-size: 16px;line-height: 25px;Margin-bottom: 25px">Thank you, <br /> 
Admin, <br />  A2M Sports. </div>

</td>
<?php
break;
?>

<?php 
case "Contact-US":
?>
<td style="padding:15px; line-height:20px; background:#eeeeee; border-radius:10px;">

<div style="Margin-top: 0;color: #565656;font-family: Georgia,serif;font-size: 16px;line-height: 25px;Margin-bottom: 25px">
Hi Admin,<br />
</div> 

<div style="Margin-top: 0;color: #565656;font-family: Georgia,serif;font-size: 16px;line-height: 25px;Margin-bottom: 25px">
<?php echo $des; ?><br />
</div>

<div style="Margin-top: 0;color: #565656;font-family: Georgia,serif;font-size: 16px;line-height: 25px;Margin-bottom: 25px">
Details: <br />
Email: <?php echo $email; ?> <br /> 
Phone: <?php echo $phone; ?> <br /> 
</div>


<div style="Margin-top: 0;color: #565656;font-family: Georgia,serif;font-size: 16px;line-height: 25px;Margin-bottom: 25px">Thank you, <br /> 
<?php echo $name; ?>, <br />  A2M Sports. </div>

</td>
<?php
break;
?>


<?php 
case "Enquiry":
?>
<td style="padding:15px; line-height:20px; background:#eeeeee; border-radius:10px;">

<div style="Margin-top: 0;color: #565656;font-family: Georgia,serif;font-size: 16px;line-height: 25px;Margin-bottom: 25px">
Hi Admin,<br />
</div> 

<div style="Margin-top: 0;color: #565656;font-family: Georgia,serif;font-size: 16px;line-height: 25px;Margin-bottom: 25px">
<?php echo $message; ?><br />
</div>

<!-- <div style="Margin-top: 0;color: #565656;font-family: Georgia,serif;font-size: 16px;line-height: 25px;Margin-bottom: 25px">
Details: <br />
Email: <?php echo $email; ?> <br />
</div> -->

<div style="Margin-top: 0;color: #565656;font-family: Georgia,serif;font-size: 16px;line-height: 25px;Margin-bottom: 25px">Thank you, <br /> 
<?php echo $name; ?>,<br />
<?php echo $email; ?>
</div>

</td>
<?php
break;
?>


<?php 
case "Add-Score-SE-RR": 
?>
<td style="padding:15px; line-height:20px; background:#eeeeee; border-radius:10px;">

<div style="Margin-top: 0;color: #565656;font-family: Georgia,serif;font-size: 16px;line-height: 25px;Margin-bottom: 25px">
<?php echo "Hi, <br> One of your tournament match score was updated. Given below are the details";?><br />
</div> 


<div style="Margin-top: 0;color: #565656;font-family: Georgia,serif;font-size: 16px;line-height: 25px;Margin-bottom: 25px">
<?php echo "Tournament Title:  " . $title ;?><br />
</div> 

<div style="Margin-top: 0;color: #565656;font-family: Georgia,serif;font-size: 16px;line-height: 25px;Margin-bottom: 25px">


<?php if($draw_name){
$name = $draw_name." ";
}else
{
$name = "";
}
?>
<?php echo "Round:  " . $name . $round_title;?><br />
<?php echo "Player1:  " . ucfirst($player1_name); if($player1_partner){ echo "; ".ucfirst($player1_partner); } ?><br />
<?php echo "Player2:  " . ucfirst($player2_name); if($player2_partner){ echo "; ".ucfirst($player2_partner); } ?><br />
<?php echo "Winner:  " . ucfirst($winner); if($winner_partner_name){ echo "; ".ucfirst($winner_partner_name); }  ?><br />

<?php
if($player1_score !=""){
$p1=array();$p2=array();
$p1 = json_decode($player1_score);
$p2 = json_decode($player2_score);

$cnt = count(array_filter($p1));
if($cnt > 0){
for($i=0; $i<count(array_filter($p1)); $i++)
{
$score .= "($p1[$i] - $p2[$i]) ";
}

}

}
?>


<?php echo "Score:  " . $score ;?><br />

</div>

<div style="Margin-top: 0;color: #565656;font-family: Georgia,serif;font-size: 16px;line-height: 25px;Margin-bottom: 25px">
Access the below link to view tournament details .<br />

<?php $string =  base_url()."league/".$tourn_id;
$string = auto_link($string, 'url');
echo $string;
?>	<br />
</div>


<div style="Margin-top: 0;color: #565656;font-family: Georgia,serif;font-size: 16px;line-height: 25px;Margin-bottom: 25px">Thank you, <br /> 
Admin, <br />  A2M Sports. </div>

</td>
<?php
break;
?>

<?php 
case "Add-Score-WFF":
?>
<td style="padding:15px; line-height:20px; background:#eeeeee; border-radius:10px;">

<div style="Margin-top: 0;color: #565656;font-family: Georgia,serif;font-size: 16px;line-height: 25px;Margin-bottom: 25px">
<?php echo "Hi, <br> One of your tournament match result was declared by win by forfeit. Given below are the details";?><br />
</div> 

<div style="Margin-top: 0;color: #565656;font-family: Georgia,serif;font-size: 16px;line-height: 25px;Margin-bottom: 25px">
<?php echo "Tournament Title:  " . $title ;?><br />
</div> 

<div style="Margin-top: 0;color: #565656;font-family: Georgia,serif;font-size: 16px;line-height: 25px;Margin-bottom: 25px">

<?php if($draw_name){
$name = $draw_name." ";
}else
{
$name = "";
}
?>
<?php echo "Round: " . $name . $round_title;?><br />

<?php echo "Winner: " . ucfirst($winner); if($winner_partner_name){ echo "; ".ucfirst($winner_partner_name); } ?><br />

<?php echo "Score: Win by forfeit"; ?><br />

</div>

<div style="Margin-top: 0;color: #565656;font-family: Georgia,serif;font-size: 16px;line-height: 25px;Margin-bottom: 25px">
Access the below link to view tournament details .<br />

<?php $string =  base_url()."league/".$tourn_id;
$string = auto_link($string, 'url');
echo $string;
?>	<br />
</div>


<div style="Margin-top: 0;color: #565656;font-family: Georgia,serif;font-size: 16px;line-height: 25px;Margin-bottom: 25px">Thank you, <br /> 
Admin, <br />  A2M Sports. </div>

</td>
<?php
break;
?>


<?php 
case "New Add Player":
?>
<td style="padding:15px; line-height:20px; background:#eeeeee; border-radius:10px;">

<div style="Margin-top: 0;color: #565656;font-family: Georgia,serif;font-size: 16px;line-height: 25px;Margin-bottom: 25px">
Hi <?php echo $name;?>,<br />
</div> 

<div style="Margin-top: 0;color: #565656;font-family: Georgia,serif;font-size: 16px;line-height: 25px;Margin-bottom: 25px">
A New Profile has been created in A2MSports under your Account. <br />
</div>
<div style="Margin-top: 0;color: #565656;font-family: Georgia,serif;font-size: 16px;line-height: 25px;Margin-bottom: 25px">
Given below are the details.<br />
<?php echo "Username:  " . $username ;?><br />
</div>

<div style="Margin-top: 0;color: #565656;font-family: Georgia,serif;font-size: 16px;line-height: 25px;Margin-bottom: 25px">
Access the below link to login .<br />

<?php $string =  base_url()."login";
$string = auto_link($string, 'url');
echo $string;
?>	<br />
</div>

<div style="Margin-top: 0;color: #565656;font-family: Georgia,serif;font-size: 16px;line-height: 25px;Margin-bottom: 25px">Thank you, <br /> 
Admin, <br />  A2M Sports. </div>

</td>
<?php
break;
?>

<?php 
case "Update Tournament":
?>
<td style="padding:15px; line-height:20px; background:#eeeeee; border-radius:10px;">

<div style="Margin-top: 0;color: #565656;font-family: Georgia,serif;font-size: 16px;line-height: 25px;Margin-bottom: 25px">
Hi <?php echo $name;?>,<br />
</div> 

<div style="Margin-top: 0;color: #565656;font-family: Georgia,serif;font-size: 16px;line-height: 25px;Margin-bottom: 25px">
One of the tournament (<?php echo "<b>".$title."</b>";?>) details are updated in A2M Sports. Please go through the below link to view the changes.
<br />
</div>

<div style="Margin-top: 0;color: #565656;font-family: Georgia,serif;font-size: 16px;line-height: 25px;Margin-bottom: 25px">
<?php $string =  base_url()."league/".$tourn_id;
$string = auto_link($string, 'url');
echo $string;
?>	<br />
</div>

<div style="Margin-top: 0;color: #565656;font-family: Georgia,serif;font-size: 16px;line-height: 25px;Margin-bottom: 25px">Thank you, <br /> 
Admin, <br />  A2M Sports. </div>

</td>
<?php
break;
?>

<?php 
case "Contact Player":
?>
<td style="padding:15px; line-height:20px; background:#eeeeee; border-radius:10px;">

<div style="Margin-top: 0;color: #565656;font-family: Georgia,serif;font-size: 16px;line-height: 25px;Margin-bottom: 25px">
Hi <?php echo $fname;?>  <?php echo $lname;?>,<br />
</div> 

<div style="Margin-top: 0;color: #565656;font-family: Georgia,serif;font-size: 16px;line-height: 25px;Margin-bottom: 25px">

<?php echo $message; ?>	<br />
</div>

<div style="Margin-top: 0;color: #565656;font-family: Georgia,serif;font-size: 16px;line-height: 25px;Margin-bottom: 25px">Thank you, <br /> 
<?php echo $from_name; ?>, <br /> 

<?php
$string = base_url() . "player/$from_id";
$string = auto_link($string, 'url');
echo $string;
?>
<br />
</div>

</td>
<?php
break;
?>

<?php 
case "News Notification":
?>
<td style="padding:15px; line-height:20px; background:#eeeeee; border-radius:10px;">

<div style="Margin-top: 0;color: #565656;font-family: Georgia,serif;font-size: 16px;line-height: 25px;Margin-bottom: 25px">
Hi <?php echo $firstname;?> <?php echo $lastname;?>,<br />
</div> 

<div style="Margin-top: 0;color: #565656;font-family: Georgia,serif;font-size: 16px;line-height: 25px;Margin-bottom: 25px">

<?php 
echo $news_details."<br />";
echo "Please access the link to access the news content<br>";
$string =  base_url()."news/$news_id";
$string = auto_link($string, 'url');
echo $string;
?>	<br />

</div>

<div style="Margin-top: 0;color: #565656;font-family: Georgia,serif;font-size: 16px;line-height: 25px;Margin-bottom: 25px">Thank you, <br /> 

Admin,<br /> 
A2M Sports. </div>
</td>
<?php
break;
?>

<?php 
case "Admin Notification":
?>
<td style="padding:15px; line-height:20px; background:#eeeeee; border-radius:10px;">

<div style="Margin-top: 0;color: #565656;font-family: Georgia,serif;font-size: 16px;line-height: 25px;Margin-bottom: 25px">
Hi <?php echo $firstname . " " . $lastname; ?>,
</div> 

<span style="Margin-top: 0;color: #565656;font-family: Georgia,serif;font-size: 16px;line-height: 25px;Margin-bottom: 25px">
<?php echo $mes;?> <br />
</span>

<?php
if($tourn_id and $tourn_id != NULL and $tourn_id != ''){
$string =  base_url()."league/$tourn_id";
$string = auto_link($string, 'url');
echo $string;
}
?><br />

<div style="Margin-top: 0;color: #565656;font-family: Georgia,serif;font-size: 16px;line-height: 25px;Margin-bottom: 25px">Thank you, 
<br /> 
<?php
if($tadmin and $tadmin != NULL and $tadmin != ''){
echo $tadmin.",<br />";
}
if($title and $title != NULL and $title != ''){
echo $title.",<br />";
}
else{
echo "Admin, <br />";
}
?>
A2M Sports. </div>
</td>
<?php
break;
?>

<?php
case "Team Join Request from Player":
?>
<td style="padding:15px; line-height:20px; background:#eeeeee; border-radius:10px;">

<div style="Margin-top: 0;color: #565656;font-family: Georgia,serif;font-size: 16px;line-height: 25px;Margin-bottom: 25px">
Hi <?php echo $captain;?>,<br />
</div>

<div style="Margin-top: 0;color: #565656;font-family: Georgia,serif;font-size: 16px;line-height: 25px;Margin-bottom: 25px">

<?php echo "Player <b><i>{$player}</i></b> wants to join into your team - <b><i>{$team}</i></b> to play in the tournament <b><i>{$title}</i></b>."; ?>
<br /><br />
<?php
echo "Click the below link to view the player profile.<br />";

$string = base_url() . "player/" . $this->logged_user;
$string = auto_link($string, 'url');
echo $string;

echo "<br /><br />Please access the below link to approve the player to join into your team<br >";

$string = base_url() . "teams/approve/" . $sec_code;
$string = auto_link($string, 'url');
echo $string;
?>
</div>

<div style="Margin-top: 0;color: #565656;font-family: Georgia,serif;font-size: 16px;line-height: 25px;Margin-bottom: 25px">Thank you, <br />

Admin,
<br />
A2M Sports. </div>
</td>
<?php
break;
?>

<?php
case "Join Request in Team":
?>
<td style="padding:15px; line-height:20px; background:#eeeeee; border-radius:10px;">

<div style="Margin-top: 0;color: #565656;font-family: Georgia,serif;font-size: 16px;line-height: 25px;Margin-bottom: 25px">
Hi <?php echo $captain;?>,<br />
</div>

<div style="Margin-top: 0;color: #565656;font-family: Georgia,serif;font-size: 16px;line-height: 25px;Margin-bottom: 25px">

<?php echo "Player <b><i>{$player}</i></b> wants to join into your team - <b><i>{$team}</i></b>."; ?>	
<br /><br />
<?php
echo "Click the below link to view the player profile.<br />";

$string = base_url() . "player/" . $this->logged_user;
$string = auto_link($string, 'url');
echo $string;

echo "<br /><br />Please access the below link to approve the player to join into your team<br >";

$string = base_url() . "teams/approve/" . $sec_code;
$string = auto_link($string, 'url');
echo $string;
?>
</div>

<div style="Margin-top: 0;color: #565656;font-family: Georgia,serif;font-size: 16px;line-height: 25px;Margin-bottom: 25px">Thank you, <br />

Admin,
<br />
A2M Sports. </div>
</td>
<?php
break;
?>

<?php
case "Response for Join Request in Team":
?>
<td style="padding:15px; line-height:20px; background:#eeeeee; border-radius:10px;">

<div style="Margin-top: 0;color: #565656;font-family: Georgia,serif;font-size: 16px;line-height: 25px;Margin-bottom: 25px">
Hi <?php echo $player_name;?>,<br />
</div>

<div style="Margin-top: 0;color: #565656;font-family: Georgia,serif;font-size: 16px;line-height: 25px;Margin-bottom: 25px">
<?php echo "Your request to join in Team <b><i>{$team}</i></b> has been processed."; ?>	
<br />
Action Taken: <b><?=$action_taken; ?></b>
<br />
Commnets: <?=$comments; ?>
<br />
</div>

<div style="Margin-top: 0;color: #565656;font-family: Georgia,serif;font-size: 16px;line-height: 25px;Margin-bottom: 25px">Thank you, <br />

Admin,
<br />
A2M Sports. </div>
</td>
<?php
break;
?>

<?php
case "Withdraw from Team":
?>
<td style="padding:15px; line-height:20px; background:#eeeeee; border-radius:10px;">

<div style="Margin-top: 0;color: #565656;font-family: Georgia,serif;font-size: 16px;line-height: 25px;Margin-bottom: 25px">
Hi <?php echo $captain;?>,<br />
</div>

<div style="Margin-top: 0;color: #565656;font-family: Georgia,serif;font-size: 16px;line-height: 25px;Margin-bottom: 25px">

<?php echo "Player <b><i>{$player}</i></b> withdrawn from your team - <b><i>{$team}</i></b>."; ?>
<br /><br />
<?php
echo "Click the below link to view the player profile.<br />";

$string = base_url() . "player/" . $this->logged_user;
$string = auto_link($string, 'url');
echo $string;

echo "<br /><br />Please access the below link to access teams<br >";

$string = base_url() . "a2mteams/";
$string = auto_link($string, 'url');
echo $string;
?>
</div>

<div style="Margin-top: 0;color: #565656;font-family: Georgia,serif;font-size: 16px;line-height: 25px;Margin-bottom: 25px">Thank you, <br />

Admin,
<br />
A2M Sports. </div>
</td>
<?php
break;
?>

<?php
case "UnRegister by Admin":
?>
<td style="padding:15px; line-height:20px; background:#eeeeee; border-radius:10px;">

<div style="Margin-top: 0;color: #565656;font-family: Georgia,serif;font-size: 16px;line-height: 25px;Margin-bottom: 25px">
Hi <?php echo $player;?>,<br />
</div>

<div style="Margin-top: 0;color: #565656;font-family: Georgia,serif;font-size: 16px;line-height: 25px;Margin-bottom: 25px">
<?php echo "You were unregistered from the tournament <b><i>{$title}</i></b> by Tournament Admin."; ?>	
<br /><br />
</div>

<div style="Margin-top: 0;color: #565656;font-family: Georgia,serif;font-size: 16px;line-height: 25px;Margin-bottom: 25px">Thank you, <br />

Admin,
<br />
A2M Sports. </div>
</td>
<?php
break;
?>

<?php
case "UnRegister Team by Admin":
?>
<td style="padding:15px; line-height:20px; background:#eeeeee; border-radius:10px;">

<div style="Margin-top: 0;color: #565656;font-family: Georgia,serif;font-size: 16px;line-height: 25px;Margin-bottom: 25px">
Hi <?php echo $captain;?>,<br />
</div>

<div style="Margin-top: 0;color: #565656;font-family: Georgia,serif;font-size: 16px;line-height: 25px;Margin-bottom: 25px">
<?php echo "Your Team '{$team}' is unregistered from the tournament <b><i>{$title}</i></b> by Tournament Admin."; ?>	
<br /><br />
</div>

<div style="Margin-top: 0;color: #565656;font-family: Georgia,serif;font-size: 16px;line-height: 25px;Margin-bottom: 25px">Thank you, <br /> 

Admin,
<br />
A2M Sports. </div>
</td>
<?php
break;
?>

<?php
case "A2M Paypal values - Developer":
?>
<td style="padding:15px; line-height:20px; background:#eeeeee; border-radius:10px;">

<div style="Margin-top: 0;color: #565656;font-family: Georgia,serif;font-size: 16px;line-height: 25px;Margin-bottom: 25px">
Hi <?php echo $firstname;?>,<br />
</div>

<div style="Margin-top: 0;color: #565656;font-family: Georgia,serif;font-size: 16px;line-height: 25px;Margin-bottom: 25px">
<?php echo "Given below are the paypal details:"; ?>	
<br />
<?php echo "Paypal Return: "; print_r($paypal_vals); ?><br />
<br />
</div>

<div style="Margin-top: 0;color: #565656;font-family: Georgia,serif;font-size: 16px;line-height: 25px;Margin-bottom: 25px">Thank you, <br /> 

Admin,
<br />
A2M Sports. </div>
</td>
<?php
break;
?>



<?php
case "WithDraw with Refund all events by Admin":
?>
<td style="padding:15px; line-height:20px; background:#eeeeee; border-radius:10px;">

<div style="Margin-top: 0;color: #565656;font-family: Georgia,serif;font-size: 16px;line-height: 25px;Margin-bottom: 25px">
Hi <?php echo $player; ?>,<br />
</div>

<div style="Margin-top: 0;color: #565656;font-family: Georgia,serif;font-size: 16px;line-height: 25px;Margin-bottom: 25px">
<?php echo "You have been withdrawn from the tournament '{$title}' by the Tournament Director."; ?><br />
<?php if($Ref_Amt){ ?>
<?php echo "Refund has been initiated for your payment. Details are given below."; ?><br />
<?php echo "Amount: ".number_format($Ref_Amt, 2); ?><br />
<?php echo "Type: ".$Ref_Type; ?><br />
<?php echo "Transaction ID: ".$Ref_TxnID; ?><br />
<?php } ?>
<br />
<?php echo "If you have any queries please contact your tournament director."; ?><br />

<?php echo "Access the below link to view League"; ?><br />
<?php echo base_url()."league/".$tourn_id; ?><br />
</div>

<div style="Margin-top:0;color:#565656;font-family:Georgia,serif;font-size:16px;line-height:25px;Margin-bottom:25px">
Thank you,<br /> 
Admin,<br />
A2M Sports.</div>
</td>
<?php
break;
?>

<?php
case "WithDraw with Refund partial events by Admin":
?>
<td style="padding:15px; line-height:20px; background:#eeeeee; border-radius:10px;">

<div style="Margin-top: 0;color: #565656;font-family: Georgia,serif;font-size: 16px;line-height: 25px;Margin-bottom: 25px">
Hi <?php echo $player; ?>,<br />
</div>

<div style="Margin-top: 0;color: #565656;font-family: Georgia,serif;font-size: 16px;line-height: 25px;Margin-bottom: 25px">
<?php echo "You have been withdrawn from the tournament '{$title}' by the Tournament Director from the following Events."; ?><br />
<?php foreach($withdrawn_events as $ev){ ?>
<?php echo $ev; ?><br />
<?php } ?>
<?php echo "If you have any queries please contact your tournament director."; ?><br />

<br />
<?php echo "Access the below link to visit tournament page."; ?><br />
<?php echo base_url()."league/".$tourn_id; ?><br />
</div>

<div style="Margin-top:0;color:#565656;font-family:Georgia,serif;font-size:16px;line-height:25px;Margin-bottom:25px">
Thank you,<br /> 
Admin,<br />
A2M Sports.</div>
</td>
<?php
break;
?>

<?php
case "WithDraw without Refund all events by Admin":
?>
<td style="padding:15px; line-height:20px; background:#eeeeee; border-radius:10px;">

<div style="Margin-top: 0;color: #565656;font-family: Georgia,serif;font-size: 16px;line-height: 25px;Margin-bottom: 25px">
Hi <?php echo $player; ?>,<br />
</div>

<div style="Margin-top: 0;color: #565656;font-family: Georgia,serif;font-size: 16px;line-height: 25px;Margin-bottom: 25px">
<?php echo "You have been withdrawn from the tournament '{$title}' by the Tournament Admin. You are no longer part of this tournament."; ?><br />
<?php echo "If you have any questions or concerns please contact your tournament director."; ?><br />

<br />
<?php echo "Access the below link to visit tournament page."; ?><br />
<?php echo base_url()."league/".$tourn_id; ?><br />
</div>

<div style="Margin-top:0;color:#565656;font-family:Georgia,serif;font-size:16px;line-height:25px;Margin-bottom:25px">
Thank you,<br /> 
Admin,<br />
A2M Sports.</div>
</td>
<?php
break;
?>

<?php
case "WithDraw without Refund partial events by Admin":
?>
<td style="padding:15px; line-height:20px; background:#eeeeee; border-radius:10px;">

<div style="Margin-top: 0;color: #565656;font-family: Georgia,serif;font-size: 16px;line-height: 25px;Margin-bottom: 25px">
Hi <?php echo $player; ?>,<br />
</div>

<div style="Margin-top: 0;color: #565656;font-family: Georgia,serif;font-size: 16px;line-height: 25px;Margin-bottom: 25px">
<?php echo "You have been withdrawn from the tournament '{$title}' by the Tournament Admin from the following Events."; ?><br />
<?php foreach($withdrawn_events as $ev){ ?>
<?php echo $ev; ?><br />
<?php } ?>
<?php echo "If you have any concerns or questions please contact your tournament director."; ?><br />

<br />
<?php echo "Access the below link to visit tournament page."; ?><br />
<?php echo base_url()."league/".$tourn_id; ?><br />
</div>

<div style="Margin-top:0;color:#565656;font-family:Georgia,serif;font-size:16px;line-height:25px;Margin-bottom:25px">
Thank you,<br /> 
Admin,<br />
A2M Sports.</div>
</td>
<?php
break;
?>

<?php
case "WithDraw without Refund partial events by Player":
?>
<td style="padding:15px; line-height:20px; background:#eeeeee; border-radius:10px;">

<div style="Margin-top: 0;color: #565656;font-family: Georgia,serif;font-size: 16px;line-height: 25px;Margin-bottom: 25px">
Hi <?php echo $player; ?>,<br />
</div>

<div style="Margin-top: 0;color: #565656;font-family: Georgia,serif;font-size: 16px;line-height: 25px;Margin-bottom: 25px">
<?php echo "You were self withdrawn from the tournament '{$title}' for the following Events."; ?><br />
<?php foreach($withdrawn_events as $ev){ ?>
<?php echo $ev; ?><br />
<?php } ?>
<?php echo "If you have any questions please contact your tournament director."; ?><br />

<br />
<?php echo "Access the below link to visit tournament page."; ?><br />
<?php echo base_url()."league/".$tourn_id; ?><br />
</div>

<div style="Margin-top:0;color:#565656;font-family:Georgia,serif;font-size:16px;line-height:25px;Margin-bottom:25px">
Thank you,<br /> 
Admin,<br />
A2M Sports.</div>
</td>
<?php
break;
?>


<?php
case "WithDraw without Refund all events by Player":
?>
<td style="padding:15px; line-height:20px; background:#eeeeee; border-radius:10px;">

<div style="Margin-top: 0;color: #565656;font-family: Georgia,serif;font-size: 16px;line-height: 25px;Margin-bottom: 25px">
Hi <?php echo $player; ?>,<br />
</div>

<div style="Margin-top: 0;color: #565656;font-family: Georgia,serif;font-size: 16px;line-height: 25px;Margin-bottom: 25px">
<?php echo "You were self withdrawn from the tournament '{$title}'. You are no longer part of this tournament."; ?><br />
<?php echo "If you have any questions please contact your tournament director."; ?><br />

<br />
<?php echo "Access the below link to visit tournament page."; ?><br />
<?php echo base_url()."league/".$tourn_id; ?><br />
</div>

<div style="Margin-top:0;color:#565656;font-family:Georgia,serif;font-size:16px;line-height:25px;Margin-bottom:25px">
Thank you,<br /> 
Admin,<br />
A2M Sports.</div>
</td>
<?php
break;
?>

<?php
case "WithDraw with Refund partial events by Player":
?>
<td style="padding:15px; line-height:20px; background:#eeeeee; border-radius:10px;">

<div style="Margin-top: 0;color: #565656;font-family: Georgia,serif;font-size: 16px;line-height: 25px;Margin-bottom: 25px">
Hi <?php echo $player; ?>,<br />
</div>

<div style="Margin-top: 0;color: #565656;font-family: Georgia,serif;font-size: 16px;line-height: 25px;Margin-bottom: 25px">
<?php echo "You are self withdrawn from the tournament '{$title}' for the following events."; ?><br />
<?php foreach($withdrawn_events as $ev){ ?>
<?php echo $ev; ?><br />
<?php } ?>

<?php if($Ref_Amt){ ?>
<?php echo "Refund has been initiated for your payment. Details are given below."; ?><br />
<?php echo "Amount: ".number_format($Ref_Amt, 2); ?><br />
<?php echo "Type: ".$Ref_Type; ?><br />
<?php echo "Transaction ID: ".$Ref_TxnID; ?><br />
<?php } ?>
<br />
<?php echo "If you have any questions, please contact your tournament director."; ?><br />

<?php echo "Access the below link to view League"; ?><br />
<?php echo base_url()."league/".$tourn_id; ?><br />
</div>

<div style="Margin-top:0;color:#565656;font-family:Georgia,serif;font-size:16px;line-height:25px;Margin-bottom:25px">
Thank you,<br /> 
Admin,<br />
A2M Sports.</div>
</td>
<?php
break;
?>

<?php
case "WithDraw with Refund all events by Player":
?>
<td style="padding:15px; line-height:20px; background:#eeeeee; border-radius:10px;">

<div style="Margin-top: 0;color: #565656;font-family: Georgia,serif;font-size: 16px;line-height: 25px;Margin-bottom: 25px">
Hi <?php echo $player; ?>,<br />
</div>

<div style="Margin-top: 0;color: #565656;font-family: Georgia,serif;font-size: 16px;line-height: 25px;Margin-bottom: 25px">
<?php echo "You are self withdrawn from the tournament '{$title}' and you are no longer part of this tournament."; ?><br />
<?php if($Ref_Amt){ ?>
<?php echo "Refund has been initiated for your payment. Details are given below."; ?><br />
<?php echo "Amount: ".number_format($Ref_Amt, 2); ?><br />
<?php echo "Type: ".$Ref_Type; ?><br />
<?php echo "Transaction ID: ".$Ref_TxnID; ?><br />
<?php } ?>
<?php echo "If you have any questions, please contact your tournament director."; ?><br />

<br />
<?php echo "Access the below link to visit tournament page."; ?><br />
<?php echo base_url()."league/".$tourn_id; ?><br />
</div>

<div style="Margin-top:0;color:#565656;font-family:Georgia,serif;font-size:16px;line-height:25px;Margin-bottom:25px">
Thank you,<br /> 
Admin,<br />
A2M Sports.</div>
</td>
<?php
break;
?>
<!-- ----------------------------------------Club Notification Mails-------------------------------------- -->
<?php
case "Club Member Notif - Membership OT":
?>
<td style="padding:15px; line-height:20px; background:#eeeeee; border-radius:10px;">

<div style="Margin-top: 0;color: #565656;font-family: Georgia,serif;font-size: 16px;line-height: 25px;Margin-bottom: 25px">
Hi <?php echo $name; ?>,<br />
</div>

<div style="Margin-top: 0;color: #565656;font-family: Georgia,serif;font-size: 16px;line-height: 25px;Margin-bottom: 25px">
<?php echo "Thank you, this is to confirm you that we have received OneTime Activation charges for <b>{$subscription}</b> (<b>$club_name</b>). <br />Following are the details"; ?><br /><br />
<?php if($tx_id){ ?>
<?php echo "Subscription: ".$subscription; ?><br />
<?php echo "Subscription Code: ".$sub_code; ?><br />
<?php echo "Amount: $".number_format($amount, 2); ?><br />
<?php echo "Transaction ID: ".$tx_id; ?><br />
<?php } ?>
<br />
<?php echo "If you have any questions, please contact club director."; ?><br />
</div>

<div style="Margin-top:0;color:#565656;font-family:Georgia,serif;font-size:16px;line-height:25px;Margin-bottom:25px">
Thank you,<br /> 
Admin,<br />
A2M Sports.</div>
</td>
<?php
break;
?>

<?php
case "Club Admin Notif - Membership OT":
?>
<td style="padding:15px; line-height:20px; background:#eeeeee; border-radius:10px;">

<div style="Margin-top: 0;color: #565656;font-family: Georgia,serif;font-size: 16px;line-height: 25px;Margin-bottom: 25px">
Hi <?php echo $name; ?>,<br />
</div>

<div style="Margin-top: 0;color: #565656;font-family: Georgia,serif;font-size: 16px;line-height: 25px;Margin-bottom: 25px">
<?php echo "User, <b>{$member}</b> has paid OneTime Activation charges for Membership Type <b>{$subscription}</b> (<b>$club_name</b>).<br />Following are the details."; ?><br /><br />
<?php if($tx_id){ ?>
<?php echo "Subscription: ".$subscription; ?><br />
<?php echo "Subscription Code: ".$sub_code; ?><br />
<?php echo "Amount: $".number_format($amount, 2); ?><br />
<?php echo "Transaction ID: ".$tx_id; ?><br />
<?php } ?>
<br />
<?php echo "If you have any questions, please contact us."; ?><br /><br />
</div>

<div style="Margin-top:0;color:#565656;font-family:Georgia,serif;font-size:16px;line-height:25px;Margin-bottom:25px">
Thank you,<br /> 
Admin,<br />
A2M Sports.</div>
</td>
<?php
break;
?>

<?php
case "Club Member Notif - Membership SubScr":
?>
<td style="padding:15px; line-height:20px; background:#eeeeee; border-radius:10px;">

<div style="Margin-top: 0;color: #565656;font-family: Georgia,serif;font-size: 16px;line-height: 25px;Margin-bottom: 25px">
Hi <?php echo $name; ?>,<br />
</div>

<div style="Margin-top: 0;color: #565656;font-family: Georgia,serif;font-size: 16px;line-height: 25px;Margin-bottom: 25px">
<?php echo "Thank you for subscription to <b>{$subscription}</b> (<b>$club_name</b>). 
<br />Following are the details"; ?><br /><br />
<?php if($tx_id){ ?>
<?php echo "Subscription: ".$subscription; ?><br />
<?php echo "Subscription Code: ".$sub_code; ?><br />
<?php echo "Amount: $".number_format($amount, 2); ?><br />
<?php echo "Transaction ID: ".$tx_id; ?><br />
<?php } ?>
<br />
<?php echo "If you have any questions, please contact club director."; ?><br />
</div>

<div style="Margin-top:0;color:#565656;font-family:Georgia,serif;font-size:16px;line-height:25px;Margin-bottom:25px">
Thank you,<br /> 
Admin,<br />
A2M Sports.</div>
</td>
<?php
break;
?>

<?php
case "Club Admin Notif - Membership SubScr":
?>
<td style="padding:15px; line-height:20px; background:#eeeeee; border-radius:10px;">

<div style="Margin-top: 0;color: #565656;font-family: Georgia,serif;font-size: 16px;line-height: 25px;Margin-bottom: 25px">
Hi <?php echo $name; ?>,<br />
</div>

<div style="Margin-top: 0;color: #565656;font-family: Georgia,serif;font-size: 16px;line-height: 25px;Margin-bottom: 25px">
<?php echo "User, <b>{$member}</b> has enrolled for Membership Type <b>{$subscription}</b> (<b>$club_name</b>).<br />Following are the details."; ?><br /><br />
<?php if($tx_id){ ?>
<?php echo "Subscription: ".$subscription; ?><br />
<?php echo "Subscription Code: ".$sub_code; ?><br />
<?php echo "Amount: $".number_format($amount, 2); ?><br />
<?php echo "Transaction ID: ".$tx_id; ?><br />
<?php } ?>
<br />
<?php echo "If you have any questions, please contact us."; ?><br /><br />
</div>

<div style="Margin-top:0;color:#565656;font-family:Georgia,serif;font-size:16px;line-height:25px;Margin-bottom:25px">
Thank you,<br /> 
Admin,<br />
A2M Sports.</div>
</td>
<?php
break;
?>

<?php
case "ClubAdmin Updates Member PayNow":
?>
<td style="padding:15px; line-height:20px; background:#eeeeee; border-radius:10px;">

<div style="Margin-top: 0;color: #565656;font-family: Georgia,serif;font-size: 16px;line-height: 25px;Margin-bottom: 25px">
Hi <?php echo $Firstname. ' '. $Lastname; ?>,<br />
</div>

<div style="Margin-top: 0;color: #565656;font-family: Georgia,serif;font-size: 16px;line-height: 25px;Margin-bottom: 25px">
<?php echo "Club Admin (<b>$club_name</b>)  has updated you for the subscription {$subscription}."; ?>
<br /><br />
Please access the below links to Pay and complete your subscription.
<br />
<?php
if($club_sc){
$burl = base_url().$club_sc;
}
else{
$burl = $this->config->item('club_form_url');
if($this->config->item('club_form_url') == '')
	$burl = $_SERVER['HTTP_X_FORWARDED_HOST'];
}
if($mem_info['Act_Fee'] > 0) {
?>
One Time Activation Fee:&nbsp;&nbsp;<a href='<?php echo $burl."/membership/paynow/".$ot_id; ?>' style="color: #fff; background-color: #337ab7; padding: 6px 12px; font-size: 14px; border-radius: 4px; text-decoration: none;"> Pay Now </a>
<?php
}
?>

<br />
Subscription:&nbsp;&nbsp;<a href='<?php echo $burl."/membership/paynow/".$subscr_id; ?>' style="color: #fff; background-color: #337ab7; padding: 6px 12px; font-size: 14px; border-radius: 4px; text-decoration: none;"> Pay Now </a>

<br />
<?php echo "If you have any questions, please contact club director."; ?><br />
</div>

<div style="Margin-top:0;color:#565656;font-family:Georgia,serif;font-size:16px;line-height:25px;Margin-bottom:25px">
Thank you,<br /> 
Admin,<br />
A2M Sports.</div>
</td>
<?php
break;
?>


<?php
case "ClubAdmin Updates Member SubScr Paid":
?>
<td style="padding:15px; line-height:20px; background:#eeeeee; border-radius:10px;">

<div style="Margin-top: 0;color: #565656;font-family: Georgia,serif;font-size: 16px;line-height: 25px;Margin-bottom: 25px">
Hi <?php echo $Firstname. ' '. $Lastname; ?>,<br />
</div>

<div style="Margin-top: 0;color: #565656;font-family: Georgia,serif;font-size: 16px;line-height: 25px;Margin-bottom: 25px">
<?php echo "You have successfully enroled for the club membership (<b>{$mem_info['Membership_Type']}</b>) by Club Admin (<b>$club_name</b>)."; ?>
<br />

<br />
<?php echo "If you have any questions, please contact club director."; ?><br />
</div>

<div style="Margin-top:0;color:#565656;font-family:Georgia,serif;font-size:16px;line-height:25px;Margin-bottom:25px">
Thank you,<br /> 
Admin,<br />
A2M Sports.</div>
</td>
<?php
break;
?>


<?php
case "Court booking Cancel - Admin":
?>
<td style="padding:15px; line-height:20px; background:#eeeeee; border-radius:10px;">

<div style="Margin-top: 0;color: #565656;font-family: Georgia,serif;font-size: 16px;line-height: 25px;Margin-bottom: 25px">
Hi <?=$to_name;?>,<br />
</div>

<div style="Margin-top: 0;color: #565656;font-family: Georgia,serif;font-size: 16px;line-height: 25px;Margin-bottom: 25px">
<?php echo $message; ?>&nbsp;

<br />
<?php echo "Reply to this mail, If you have any queries."; ?><br /><br />
</div>

<div style="Margin-top:0;color:#565656;font-family:Georgia,serif;font-size:16px;line-height:25px;Margin-bottom:25px">
Thank you,<br /> 
Admin,<br />
A2M Sports.</div>
</td>
<?php
break;
?>

<?php
case "Test-Email":
?>
<td style="padding:15px; line-height:20px; background:#eeeeee; border-radius:10px;">

<div style="Margin-top: 0;color: #565656;font-family: Georgia,serif;font-size: 16px;line-height: 25px;Margin-bottom: 25px">
Hi,<br />
</div>

<div style="Margin-top: 0;color: #565656;font-family: Georgia,serif;font-size: 16px;line-height: 25px;Margin-bottom: 25px">
<?php echo "This is the test email to test"; ?>&nbsp;


<br />
<?php echo "If you have any questions, please contact us."; ?><br /><br />
</div>

<div style="Margin-top:0;color:#565656;font-family:Georgia,serif;font-size:16px;line-height:25px;Margin-bottom:25px">
Thank you,<br /> 
Admin,<br />
A2M Sports.</div>
</td>
<?php
break;
?>

<?php
case "Subscription Cancel Request to Admin":
?>
<td style="padding:15px; line-height:20px; background:#eeeeee; border-radius:10px;">

<div style="Margin-top: 0;color: #565656;font-family: Georgia,serif;font-size: 16px;line-height: 25px;Margin-bottom: 25px">
Hi <?=$ClubAdmin;?>,<br />
</div>

<div style="Margin-top: 0;color: #565656;font-family: Georgia,serif;font-size: 16px;line-height: 25px;Margin-bottom: 25px">
<?php echo "Subscription ({$Membership}) cancel request has sent by {$Username} "; ?>&nbsp;

<br />
<?php echo "You can reply to this mail to contact the member"; ?><br /><br />
</div>

<div style="Margin-top:0;color:#565656;font-family:Georgia,serif;font-size:16px;line-height:25px;Margin-bottom:25px">
Thank you,<br /> 
Admin,<br />
A2M Sports.</div>
</td>
<?php
break;
?>

<?php
case "Contact Us - Club":
?>
<td style="padding:15px; line-height:20px; background:#eeeeee; border-radius:10px;">

<div style="Margin-top: 0;color: #565656;font-family: Georgia,serif;font-size: 16px;line-height: 25px;Margin-bottom: 25px">
Hi Admin,<br />
You got a enquiry message from portal <?=$club;?>
</div>

<div style="Margin-top: 0;color: #565656;font-family: Georgia,serif;font-size: 16px;line-height: 25px;Margin-bottom: 25px">
Name: <?php echo $name; ?><br />
Email: <?php echo $user_email; ?><br />
Message: <?php echo $message; ?><br />

<br />

</div>

<div style="Margin-top:0;color:#565656;font-family:Georgia,serif;font-size:16px;line-height:25px;Margin-bottom:25px">
Thank you,<br /> 
Admin,<br />
A2MSports.</div>
</td>
<?php
break;
?>

<?php
default:

echo "";
break;
}

// ----------------------------Email body switch cases END here ----------------------------------------------------------------

?>
</tr>
</table>
</div>

<table width="696" border="0" cellspacing="0" cellpadding="0">
<tr>
<td style="background:#81a32b; font-size:12px; padding:6px; color:#ffffff; text-align:center">
© 2021 a2msports.com. All rights reserved.</td>
</tr>
 <?php if($unsubscribe){?>
<tr>
<td style="background:#81a32b; font-size:12px; padding:6px; color:#ffffff; text-align:center"> <a href="<?php echo base_url();?>unsubscribe/<?php echo base64_encode($user_id);?>">Unsubscribe</a> </td>
</tr>
<?php }?>
</table>

</td>
</tr>
</table>

</body>
</html>