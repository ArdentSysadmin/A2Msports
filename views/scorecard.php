<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>A2MSports</title>
<link href="<?php echo base_url();?>css/bootstrap.css" rel="stylesheet" type="text/css"/>
<!--<link href="css/bootstrap.min.css" rel="stylesheet" type="text/css" />-->

<link href='https://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,400,700,600,300' rel='stylesheet' type='text/css'/>
<link href='https://fonts.googleapis.com/css?family=Raleway:400,100,300,200,500,600,700,800,900' rel='stylesheet' type='text/css'/>
<link href='https://fonts.googleapis.com/css?family=Oswald:400,300,700' rel='stylesheet' type='text/css' />
<link href='https://fonts.googleapis.com/css?family=Lato:100,300,400,700,900,100italic,300italic,400italic,700italic,900italic' rel='stylesheet' type='text/css' />

<link href="<?php echo base_url();?>css/fonts/font-awesome-4.1.0/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
<!--Clients-->
<link href="<?php echo base_url();?>css/own/owl.carousel.css" rel="stylesheet" type="text/css" />
<link href="<?php echo base_url();?>css/own/owl.theme.css" rel="stylesheet" type="text/css" />

<link href="<?php echo base_url();?>css/jquery.bxslider.css" rel="stylesheet" type="text/css" />
<link href="<?php echo base_url();?>css/jquery.jscrollpane.css" rel="stylesheet" type="text/css" />

<link href="<?php echo base_url();?>css/minislide/flexslider.css" rel="stylesheet" type="text/css" />
<link href="<?php echo base_url();?>css/component.css" rel="stylesheet" type="text/css" />
<link href="<?php echo base_url();?>css/prettyPhoto.css" rel="stylesheet" type="text/css" />
<link href="<?php echo base_url();?>css/style_dir.css" rel="stylesheet" type="text/css" />
<link rel="shortcut icon" type="image/png" href="<?php echo base_url();?>images/favicon.png"/>
<link href="<?php echo base_url();?>css/responsive.css" rel="stylesheet" type="text/css" />
<link href="<?php echo base_url();?>css/animate.css" rel="stylesheet" type="text/css" />
<link href="<?php echo base_url();?>css/tabs.css" rel="stylesheet" type="text/css" />
<link href="<?php echo base_url(); ?>css/jquery.datepick.css" rel="stylesheet" type="text/css" />
<link href="<?php echo base_url();?>css/jquery.autocomplete.css" rel="stylesheet" type="text/css" />

<link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">

<link rel="stylesheet" href="<?php echo base_url();?>css/grid.css">
 
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
<!-- <script src="https://code.jquery.com/jquery-1.11.1.min.js"></script> -->
<script src="https://jqueryvalidation.org/files/dist/jquery.validate.min.js"></script>
<script src="https://jqueryvalidation.org/files/dist/additional-methods.min.js"></script>
<style>
  .select-style {
    padding: 0;
    margin: 0;
    border: 0px solid #ccc;
    border-bottom:1px solid #ccc;
    width: 220px;
    border-radius: 3px;
    overflow: hidden;
    background: #fff;
}

.select-style select {
    padding: 15px 8px;
    width: 130%;
    border: none;
    box-shadow: none;
    background-color: transparent;
    background-image: none;
    -webkit-appearance: none;
       -moz-appearance: none;
            appearance: none;
}

.select-style select:focus {
    outline: none;
}
  </style>
</head>

<body>
<table width="900" border="0" cellspacing="0" cellpadding="0" align="center">
<tr>
<td style="border:2px solid #ff8a00">

<table width="900" border="0" cellspacing="0" cellpadding="0">
<tr>
<td width="172" style="padding:10px">
<img class="scale_image" src="<?php echo base_url(); ?>images/logo.png" alt="" />
</td>
<td width="524">
<div align="center" style="font-size:18px; font-weight:bold"><?php echo $tour_details->tournament_title; ?></div>
</td>
</tr>
<tr>
<td colspan="2" style="height:6px; background:#81a32b; font-size:6px"></td>
</tr>
</table>
      <br />

<table width="900" class='imagetable' border='0' cellpadding='10' cellspacing = '10' align="center">
<?php
$lines = $tour_details->lines_per_match;
$lines_arr = json_decode($lines, true);

if($lines_arr[0]['Singles'] or $lines_arr[0]['Doubles']){
	$sline_count = $lines_arr[0]['Singles'];
	$dline_count = $lines_arr[1]['Doubles'];
}
else{
	$m_sline_count = $lines_arr[0]['MSingles'];
	$w_sline_count = $lines_arr[1]['WSingles'];

	$m_dline_count = $lines_arr[2]['MDoubles'];
	$w_dline_count = $lines_arr[3]['WDoubles'];

	$mx_line_count = $lines_arr[4]['Mixed'];

	$o_sline_count = $lines_arr[5]['OSingles'];
	$o_dline_count = $lines_arr[6]['ODoubles'];
}

$team_players = array();
if($team_info){
$team_players = json_decode($team_info['Team_Players']);
}
//print_r($reg_team);
?>
<tr>
<td align='center'><b>Line#</b></td>
<td align='left'><b>Team-1</b></td>
<td align='center'><b>Score</b></td>
<td align='left'><b>Team-2</b></td>
</tr>

<?php
if($lines_arr[0]['Singles'] or $lines_arr[0]['Doubles']){
for($i=0; $i<$sline_count; $i++){
?>
<tr>
<td><?=($i+1)."(Singles)";?></td>
<td>
<div class="select-style">
<select>
<option value=''></option>
<?php foreach($team_players as $player){
$user = league::get_username($player);
$player_name = $user['Firstname']. " ".$user['Lastname']
?>
<option value='<?=$player;?>'><?=$player_name;?></option>
<?php
}?>
</select>
</div>
</td>
<td><div class="select-style"><select></select></div></td>
<td><div class="select-style"><select></select></div></td>
</tr>
<?php
}
for($j=0; $j<$dline_count; $j++, $i++){
?>
<tr>
<td><?=($j+1)."(Doubles)";?></td>
<td><div class="select-style">
<select style="border:0px solid;">
<option value=''></option>
<?php foreach($team_players as $player){
$user = league::get_username($player);
$player_name = $user['Firstname']. " ".$user['Lastname']
?>
<option value='<?=$player;?>'><?=$player_name;?></option>
<?php
}?>
</select>
</div> 
<div class="select-style">
<select style="border:0px solid;">
<option value=''></option>
<?php foreach($team_players as $player){
$user = league::get_username($player);
$player_name = $user['Firstname']. " ".$user['Lastname']
?>
<option value='<?=$player;?>'><?=$player_name;?></option>
<?php
}?>
</select>
</div>
</td>

<td><div class="select-style"><select></select></div></td>

<td><div class="select-style"><select></select></div> <div class="select-style"><select></select></div></td>

</tr>
<?php
}
} // close of IF
else{
for($i=0; $i<$m_sline_count; $i++){
?>
<tr>
<td><?=($i+1)."(Men's Singles)";?></td>
<td>
<div class="select-style">
<select>
<option value=''></option>
<?php foreach($team_players as $player){
$user = league::get_username($player);
$player_name = $user['Firstname']. " ".$user['Lastname']
?>
<option value='<?=$player;?>'><?=$player_name;?></option>
<?php
}?>
</select>
</div>
</td>
<td><div class="select-style"><select></select></div></td>
<td><div class="select-style"><select></select></div></td>
</tr>
<?php
}
for($i=0; $i<$w_sline_count; $i++){
?>
<tr>
<td><?=($i+1)."(Women's Singles)";?></td>
<td>
<div class="select-style">
<select>
<option value=''></option>
<?php foreach($team_players as $player){
$user = league::get_username($player);
$player_name = $user['Firstname']. " ".$user['Lastname']
?>
<option value='<?=$player;?>'><?=$player_name;?></option>
<?php
}?>
</select>
</div>
</td>
<td><div class="select-style"><select></select></div></td>
<td><div class="select-style"><select></select></div></td>
</tr>
<?php
}
for($j=0; $j<$m_dline_count; $j++, $i++){
?>
<tr>
<td><?=($j+1)."(Men's Doubles)";?></td>
<td><div class="select-style">
<select style="border:0px solid;">
<option value=''></option>
<?php foreach($team_players as $player){
$user = league::get_username($player);
$player_name = $user['Firstname']. " ".$user['Lastname']
?>
<option value='<?=$player;?>'><?=$player_name;?></option>
<?php
}?>
</select>
</div> 
<div class="select-style">
<select style="border:0px solid;">
<option value=''></option>
<?php foreach($team_players as $player){
$user = league::get_username($player);
$player_name = $user['Firstname']. " ".$user['Lastname']
?>
<option value='<?=$player;?>'><?=$player_name;?></option>
<?php
}?>
</select>
</div>
</td>

<td><div class="select-style"><select></select></div></td>

<td><div class="select-style"><select></select></div> <div class="select-style"><select></select></div></td>

</tr>
<?php
}

for($j=0; $j<$w_dline_count; $j++, $i++){
?>
<tr>
<td><?=($j+1)."(Women's Doubles)";?></td>
<td><div class="select-style">
<select style="border:0px solid;">
<option value=''></option>
<?php foreach($team_players as $player){
$user = league::get_username($player);
$player_name = $user['Firstname']. " ".$user['Lastname']
?>
<option value='<?=$player;?>'><?=$player_name;?></option>
<?php
}?>
</select>
</div> 
<div class="select-style">
<select style="border:0px solid;">
<option value=''></option>
<?php foreach($team_players as $player){
$user = league::get_username($player);
$player_name = $user['Firstname']. " ".$user['Lastname']
?>
<option value='<?=$player;?>'><?=$player_name;?></option>
<?php
}?>
</select>
</div>
</td>
<td><div class="select-style"><select></select></div></td>
<td><div class="select-style"><select></select></div> <div class="select-style"><select></select></div></td>
</tr>
<?php
}
for($j=0; $j<$mx_line_count; $j++, $i++){
?>
<tr>
<td><?=($j+1)."(Mixed Doubles)";?></td>
<td><div class="select-style">
<select style="border:0px solid;">
<option value=''></option>
<?php foreach($team_players as $player){
$user = league::get_username($player);
$player_name = $user['Firstname']. " ".$user['Lastname']
?>
<option value='<?=$player;?>'><?=$player_name;?></option>
<?php
}?>
</select>
</div> 
<div class="select-style">
<select style="border:0px solid;">
<option value=''></option>
<?php foreach($team_players as $player){
$user = league::get_username($player);
$player_name = $user['Firstname']. " ".$user['Lastname']
?>
<option value='<?=$player;?>'><?=$player_name;?></option>
<?php
}?>
</select>
</div>
</td>

<td><div class="select-style"><select></select></div></td>
<td><div class="select-style"><select></select></div> <div class="select-style"><select></select></div></td>
</tr>
<?php
}
for($j=0; $j<$o_sline_count; $j++, $i++){
?>
<tr>
<td><?=($j+1)."(Open Singles)";?></td>
<td><div class="select-style">
<select style="border:0px solid;">
<option value=''></option>
<?php foreach($team_players as $player){
$user = league::get_username($player);
$player_name = $user['Firstname']. " ".$user['Lastname']
?>
<option value='<?=$player;?>'><?=$player_name;?></option>
<?php
}?>
</select>
</div>
</td>

<td><div class="select-style"><select></select></div></td>
<td><div class="select-style"><select></select></div> <div class="select-style"><select></select></div></td>
</tr>
<?php
}
for($j=0; $j<$o_dline_count; $j++, $i++){
?>
<tr>
<td><?=($j+1)."(Open Doubles)";?></td>
<td><div class="select-style">
<select style="border:0px solid;">
<option value=''></option>
<?php foreach($team_players as $player){
$user = league::get_username($player);
$player_name = $user['Firstname']. " ".$user['Lastname']
?>
<option value='<?=$player;?>'><?=$player_name;?></option>
<?php
}?>
</select>
</div> 
<div class="select-style">
<select style="border:0px solid;">
<option value=''></option>
<?php foreach($team_players as $player){
$user = league::get_username($player);
$player_name = $user['Firstname']. " ".$user['Lastname']
?>
<option value='<?=$player;?>'><?=$player_name;?></option>
<?php
}?>
</select>
</div>
</td>

<td><div class="select-style"><select></select></div></td>
<td><div class="select-style"><select></select></div> <div class="select-style"><select></select></div></td>
</tr>
<?php
}
}	// close of Else
?>
</table>
<br />
<div align='right'>
	<div class="select-style"><select></select></div>
	Team-1 Captain's Signature&nbsp;&nbsp;&nbsp;&nbsp;

	<div class="select-style"><select></select></div>
	Team-2 Captain's Signature&nbsp;&nbsp;&nbsp;&nbsp;

</div>
<br />
<table width="900" border="0" cellspacing="0" cellpadding="0">
<tr>
<td style="background:#81a32b; font-size:12px; padding:6px; color:#ffffff; text-align:center">&copy; 2016 a2msports.com. All rights reserved.</td>
</tr>
</table>

</td>
</tr>
</table>

</body>
</html>