<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>A2MSports</title>
<link href="<?php echo base_url();?>css/bootstrap.css" rel="stylesheet" type="text/css" />
 <style>
.blank_row {
    height: 10px !important; /* overwrites any other rules */
    background-color: #FFFFFF;
}
.underline {
    text-decoration: underline;
}
@media print {
.pagebreak { page-break-after: always; }
}
</style>
</head>
<body>

<div class='col-xs-12'>
<?php
$i = 1;
$j = 1;
foreach($res_result as $index => $result) {

$rcount = 0;
foreach($result as $res){
	if($res->Round_Num == 1 and $res->Draw_Type == 'Main') 
		$rcount++;
}

foreach($result as $res){
 if($res->Player1_Score != 'Bye Match') {
	 $game_type = 'Game';
	 if($res->SportsType == '1') {
	 $game_type = 'Set';
	 }
?>

<div class='col-xs-6'>
<div style="outline: thin solid; padding:10px;margin-bottom:40px;">
<table border="0" cellspacing="0" cellpadding="0" width='100%'>
<tr>
<td align="left"><img src='<?php echo base_url(); ?>images/logo.png' alt='Print' title='Print' width='70px'/></td>
<td align="left" class="underline"> <h4><?php echo ucfirst($res->tournament_title); ?></h4></td>
</tr>
</table>

<table border="0" cellspacing="0" cellpadding="0" width='100%'>
<tr><td style="padding-left: 0px;">&nbsp;</td>
<td style="padding-left: 0px;">Round:&nbsp;<b>
<u><?php
if($res->Bracket_Type == 'Round Robin'){
echo "Round - ".$res->Round_Num;
}
else if($res->Bracket_Type == 'Single Elimination' or $res->Bracket_Type == 'Consolation'){
	if($res->Round_Num == $res->No_of_rounds){
		echo "Final";
	}
	else if($res->Round_Num == ($res->No_of_rounds - 1)){
		echo "Semi-Final";
	}
	else if($res->Round_Num == ($res->No_of_rounds - 2)){
		echo "Quarter-Final";
	}
	else if($rcount){
		echo "Round of ".($rcount * 2);
	}
}
?>
</u></b></td></tr>
<tr>
<td style="padding-left: 0px;">Draw Name:&nbsp;<b><u><?php echo $res->Draw_Title; if($res->Draw_Type == 'Consolation') echo " - Con";?></u></b></td>
<td style="padding-right: 0px;">Match #:&nbsp;<b><u><?=$res->Match_Num;?></u></b></td>
</tr> 
</table>

<table border="0" cellspacing="0" cellpadding="0" width='100%'>
<tr><td colspan="3" align="right">&nbsp;</td></tr>
<tr>
<td align='center' colspan='3'>
<?php 
$user  = $this->model_league->get_user_name($res->Player1);
$user1 = $this->model_league->get_user_name($res->Player2);

if($res->Player1_Partner){
$user_part1 = $this->model_league->get_user_name($res->Player1_Partner);
$partner1   = "; ".ucfirst($user_part1['Firstname']).' '.ucfirst($user_part1['Lastname']);
}

if($res->Player2_Partner){
$user_part2 = $this->model_league->get_user_name($res->Player2_Partner);
$partner2   = "; ".ucfirst($user_part2['Firstname']).' '.ucfirst($user_part2['Lastname']);
}

if($user){
echo "<b><u>" . ucfirst($user['Firstname']) . ' ' . ucfirst($user['Lastname']) . $partner1 . "</u></b>";
}
else{
echo "_________";
}

if($user1){
echo "   vs   " . "<b><u>".ucfirst($user1['Firstname']).' '.ucfirst($user1['Lastname'])."</u></b>";
}
else{
echo "   vs   __________";
}
?>
</td>
</tr>

<tr><td colspan="3" align="right">&nbsp;</td></tr>
<tr><td style="width:30%"><?=$game_type;?> 1</td><td style="width:30%">____</td><td style="width:30%">____</td></tr>
<tr><td><?=$game_type;?> 2</td><td>____</td><td>____</td></tr>
<tr><td><?=$game_type;?> 3</td><td>____</td><td>____</td></tr>
<tr><td><?=$game_type;?> 4</td><td>____</td><td>____</td></tr>
<tr><td><?=$game_type;?> 5</td><td>____</td><td>____</td></tr>

<tr><td colspan="3" align="right">&nbsp;</td></tr>
<tr><td colspan="3" align="right"><h5>at end of match - circle winner's name</h5></td></tr>
<tr><td colspan="3" align="right">&nbsp;</td></tr>
<tr><td colspan="3" align="right"><b>_____________________</b></td></tr>
<tr><td colspan="3" align="right">&nbsp;</td></tr>

<tr><td align="right" colspan="3" style="padding-right: 45px;">Umpire</td></tr>
</table>
</div>
</div>
<?php 
if($i%2 == 0 and $j%4 != 0){
echo "</div><div class='col-xs-12'>";
$i=0;
}

if(i%2 == 0 and $j%4 == 0){
echo "</div><div class='pagebreak'>&nbsp;</div><br /><div class='col-xs-12'>";
$j=0;
}
?>

<?php 
$i++;
$j++;
}
}
}?>

</body>
</html>