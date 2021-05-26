<div class='form-group'>
<div class='col-md-3 control-label'>

<select class="form-control" name="participant_format" id="participant_format" >
<!-- <option value="">Select</option> -->
<?php
$given_type = "";
if($this->input->post('participant_format')){
$given_type = $this->input->post('participant_format');
}
?>
<?php
$types= array();
$types = json_decode($tour_details->Singleordouble);
?>
<?php foreach($types as $type){ ?>
<option value="<?php echo $type;?>" <?php if($given_type == $type){ echo "selected=selected"; } ?>>
<?php echo $type;?></option>
<?php } ?>
</select>
</div>

<div class='col-md-3 control-label'>
<select class="form-control" id="participant_age_type" name="participant_type">
<!-- <option value="">Select</option> -->
<?php
$given_age = "";
if($this->input->post('participant_type')){
$given_age = $this->input->post('participant_type');
}
?>

<?php
$ages= array();
$ages = json_decode($tour_details->Age);
?>
<?php foreach($ages as $age){ ?>
<option value="<?php echo $age;?>" <?php if($given_age == $age){ echo "selected=selected"; } ?> ><?php 
switch ($age){
case "U12":
echo "Under 12";
break;
case "U14":
echo "Under 14";
break;
case "U16":
echo "Under 16";
break;
case "U18":
echo "Under 18";
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
?></option>
<?php } ?>
</select>
</div>

<div class='col-md-3 control-label'>
<?php
$levels= array();
if($tour_details->Sport_levels != "")
{
$levels = json_decode($tour_details->Sport_levels);
?>
<select class="form-control" name="participant_level" id="participant_level" >
<?php foreach($levels as $level){ ?>
<option value="<?php echo $level;?>">
<?php $get_level = league::get_level_name($tour_details->SportsType,$level);
echo $get_level['SportsLevel']; ?>
</option>
<?php } ?>
</select>
<?php 
} 
?>
</div>

</div>

<div class='col-md-8'>
<br /><br />
<div id="participants-users" style=" margin: auto;overflow-y: scroll;overflow-x: scroll;height:500px;width: auto;">
<table class="tab-score">
<?php 
$tourn_partner_names1 = league::get_reg_tourn_participants($tour_details->tournament_ID);
if(count(array_filter($tourn_partner_names1)) > 0) {
?>
<tr class="top-scrore-table">
<!-- <th width="5%" class="score-position">Select</th> -->
<th width=""></th>
<th style="padding-left:40px;">Players</th>
<th style="padding-left:30px;">A2MScore</th>
<th style="padding-left:30px;">Level</th>
<th style="padding-left:30px;">Age Group</th>
</tr>

<?php
foreach($tourn_partner_names1 as $name)
{
?>
<tr>
<td></td>
<td style="padding-left:40px;"><?php
if($tour_details->tournament_format != 'Teams'){
$player = league::get_username($name->Users_ID);
echo "<a href='".$this->config->item('club_form_url')."player/$name->Users_ID'>".$player['Firstname'] . " " .$player['Lastname']."</a>";
}
else{
$team = league::get_team($name->Team_id);
echo "<a href='#'>".$team['Team_name']."</a>";
}
?>
</td>

<td style="padding-left:40px;">
<?php 
$user_a2msocre = league::get_a2mscore($name->Users_ID, $tour_details->SportsType);
$user_score = $user_a2msocre['A2MScore'];
echo $user_score;
?>
</td>
<td style="padding-left:40px;">
<?php $get_level = league::get_level_name($tour_details->SportsType,$name->Reg_Sport_Level);
echo $get_level['SportsLevel']; ?>
</td>
<td> <?php 
switch ($name->Reg_Age_Group){
case "U12":
echo "Under 12";
break;
case "U14":
echo "Under 14";
break;
case "U16":
echo "Under 16";
break;
case "U18":
echo "Under 18";
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

?> </td>
</tr>
<?php 
}
} 
else {
?>
<tr><td colspan='6'><b>No players are registered yet. </b></td></tr>
<?php } ?>
</table>
</div>
</div>