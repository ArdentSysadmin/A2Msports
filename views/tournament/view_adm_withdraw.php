<!-- <script src="<?=base_url();?>assets/tinymce/tinymce.min.js"></script> -->

<script>
/*tinymce.init({
  selector: 'textarea',
  height: 300,
  theme: 'modern',
  plugins: [
    'advlist autolink lists link image charmap print preview hr anchor pagebreak',
    'searchreplace wordcount visualblocks visualchars code fullscreen',
    'insertdatetime media nonbreaking save table contextmenu directionality',
    'template paste textcolor colorpicker textpattern imagetools codesample toc help'
  ],
  toolbar1: 'undo redo | insert | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image',
  toolbar2: 'print preview media | forecolor backcolor emoticons | codesample help',
  image_advtab: true,
  templates: [
    { title: 'Test template 1', content: 'Test 1' },
    { title: 'Test template 2', content: 'Test 2' }
  ],
  content_css: [
    '//fonts.googleapis.com/css?family=Lato:300,300i,400,400i',
    '//www.tinymce.com/css/codepen.min.css'
  ]
 });*/
$(document).ready(function(){


 $('#frm_participants').click(function() {
  var atLeastOneIsChecked = false;
  $('input:checkbox').each(function() {
    if ($(this).is(':checked')) {
      atLeastOneIsChecked = true;
      // Stop .each from processing any more items
      return false;
    }
  });
  if(atLeastOneIsChecked == false){
		alert('Select atlease one player to proceed!');
		e.preventDefault();
		return false;
  }
  // Do something with atLeastOneIsChecked
});

});

</script>

<form method="post" name='frm_participants' id="frm_participants"  action="<?php echo base_url(); ?>league/adm_withdraw_players" class="register-form" novalidate> 

<div class='form-group'>
<?php
if($get_sport['Sportname'] != 'Golf'){ ?>
<div class='col-md-3 control-label'>

<select class="form-control" name="match_format" id="match_format" >
<!-- <option value="">Select</option> -->
<?php
$given_type = "";
if($this->input->post('match_format')) {
$given_type = $this->input->post('match_format');
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
<?php
} ?>

<div class='col-md-3 control-label'>
<select class="form-control" id="age_type" name="age_type">
<!-- <option value="">Select</option> -->
<?php
$given_age = "";
if($this->input->post('age_type'))	{
$given_age = $this->input->post('age_type');
}

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
<select class="form-control" name="tourn_level" id="tourn_level" >
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
</form> 

<style>
.multiselect {
width: 200px;
}
.selectBox {
position: relative;
}
.selectBox select {
width: 100%;
font-weight: bold;
}
.overSelect {
position: absolute;
left: 0; right: 0; top: 0; bottom: 0;
}

#checkboxes {
display: none;
border: 1px #dadada solid;
}
#checkboxes label {
display: block;
}
/*#checkboxes label:hover {
background-color: #1e90ff;
}*/
</style>

<script>
function showCheckboxes($uid){
var elements = document.getElementsByClassName('div_ag_sel')

for (var i = 0; i < elements.length; i++){
elements[i].style.display = "none";
}
var checkboxes = document.getElementById("checkboxes"+$uid);
checkboxes.style.display = "block";
}
</script>

<div class='col-md-12'>
<br /><br />
<?php $tourn_reg_names = league::get_reg_tourn_player_names($tour_details->tournament_ID); ?>

<h4>Registered Players (<?php echo count($tourn_reg_names); ?>) [WithDraw Players]</h4>

<div id="load-users" style="overflow-y: scroll;" class="tab-content table-responsive">
<table class="tab-score">
<tr class="top-scrore-table">
<td width="6%" class="score-position"><input type='checkbox' name="sel_all" id="sel_all" /></td>
<td width="30%">Name</td>
<td width="15%">Contact#</td>
<?php if($get_sport['Sportname'] != 'Golf'){?>
<td width="20%">Match Format</td>
<?php
}?>
<td width="15%">Age Group</td>
<td width="32%" align='center'>Level</td>
</tr>

<?php
if(count(array_filter($tourn_reg_names)) > 0){
foreach($tourn_reg_names as $name){
?>
<tr>

<td>
<input type="checkbox" name="sel_player[]" class="checkbox1" value="<?php echo $name->Users_ID;?>" style="margin-left:10px" />
<!-- 
<input type="hidden" name="rtid<?php echo $name->Users_ID;?>" value="<?php echo $name->Users_ID;?>" style="margin-left:10px" /> 
-->
</td>

<td style="padding-left:10px">
<?php
$player = league::get_username($name->Users_ID);
echo "<b>" . ucfirst($player['Firstname']) . " " . ucfirst($player['Lastname']) . "</b>";
?>
</td>

<td style="padding-left:10px"><?php echo $player['Mobilephone']; ?></td>

<?php if($get_sport['Sportname'] != 'Golf'){?>
<td style="padding-left:10px">
<div id='match_format<?php echo $name->Users_ID;?>'>
<?php
$match_array = array();
if($name->Match_Type != "")
{
$match_array = json_decode($name->Match_Type);
$numItems	 = count($match_array);

if($numItems > 0)
{
foreach($match_array as $i => $group)
{
echo $group;
if(++$i != count($match_array)){
echo ", ";
}
}
}
}
?>
</div>
</td>
<?php
}
?>

<td style="padding-left:10px">
<?php 
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
?>
</td>

<td id="load_player_<?=$name->Users_ID;?>">
<?php $get_level = league::get_level_name($tour_details->SportsType,$name->Reg_Sport_Level);
echo $get_level['SportsLevel']; ?>
</td>

</tr>
<?php
}
}
else {
?>
<tr><td colspan='6'><b>No Players Found. </b></td></tr>
<?php
}
?>
</table>
</div>  

<?php
if(count($tourn_reg_names) > 0)
{?>
<!-- <br />
</label>Comments</label>
<textarea name="comments" id="comments" cols="10" rows="2" required></textarea> -->
<br />
<input type="submit" id="withdraw_players" name="withdraw_players"  value="Withdraw Players" class="league-form-submit" style=""/>
<!-- <input type="button" id="cancel_msg" name="cancel_msg"  value="Cancel" class="league-form-submit1" style=""/> -->
<?php
}?>
</div>

<input type='hidden' name='tourn_id' id="tourn_id" value="<?php echo $tour_details->tournament_ID; ?>">
<input type='hidden' name='tourn_type' value = "<?php echo $tour_details->Tournament_type; ?>">

</div>
</form>